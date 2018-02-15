Drupal.behaviors.oct_discounts = function (context) {

};

function editDiscount(){
    var discount_type = $("#edit-taxonomy-7");
    codeToggle(discount_type);
    discount_type.change(function(){
      // clear code input
      $("#edit-field-discount-code-0-value").val("");
      codeToggle(this);
    });
}

function codeToggle(e){
  var type = $("option:selected", e).val();
  // Manual
  if ((type == 34) || (type == 35)) {
     $("#edit-field-discount-code-0-value-wrapper").show(); 
  } else {
     $("#edit-field-discount-code-0-value-wrapper").hide();
  }
}

function octDiscountCount(){
  //onload count discount
  onloadCalculateDiscount();
  // onclick count code discount
  $('#edit-panes-oct-discounts-oct-discounts-button').click(function(e) {
   onloadCalculateDiscount();
   return false;
  });
}

function onloadCalculateDiscount(){
  var discountCode = $("#edit-panes-oct-discounts-oct-discounts-codes").val();

  //Show loading container
  var progress = new Drupal.progressBar("uc_discountsProgress");
  progress.setProgress(-1, Drupal.settings.oct_discounts.progress_msg);
  var messages_container = $(".oct-discounts-messages-container");
  messages_container.empty().append(progress.element);
  messages_container.addClass("solid-border");

  $.ajax({
    type: "POST",
    url: Drupal.settings.basePath + "?q=cart/checkout/oct_discounts/calculate",
    data: {discount_code: discountCode},
    complete : function(xmlHttpRequest, textStatus) {
      //Hide loading container
      $(".oct-discounts-messages-container").removeClass("solid-border").empty();
      var responseText = xmlHttpRequest.responseText;
      var calculateDiscountResponse = Drupal.parseJson(responseText);
      try{
        octCalculateDiscountResponse(calculateDiscountResponse);
      }catch(e){
        $('.oct-discounts-messages-container').append("<div class='messages error'> Error: Not return discount codes</div>");
        return;
      }
    }
  });
}

function octCalculateDiscountResponse(calculateDiscountResponse){

    var line_items = null;
    var errors = null;
    var messages = null;
    var table_subtotal = null;

    try {
      line_items = calculateDiscountResponse[Drupal.settings.oct_discounts.calculate_discount_response_line_items_key];
      errors = calculateDiscountResponse[Drupal.settings.oct_discounts.calculate_discount_response_errors_key];
      messages = calculateDiscountResponse[Drupal.settings.oct_discounts.calculate_discount_response_messages_key];
      table_subtotal = calculateDiscountResponse[Drupal.settings.oct_discounts.calculate_discount_response_subtotal];
    }
    catch (err) { }

    //Process discount line items and update total (false to not display messages)
    uc_discountsRenderLineItems(line_items, table_subtotal,true);

    //Add errors and messages to messages container
    var discounts_messages_container = $(".oct-discounts-messages-container");
    discounts_messages_container.empty();

    if ( (errors != null) && (errors.length > 0) ) {
      discounts_messages_container.append(  $("<div class='oct-discounts-messages messages error'><" + "/div>").append( errors.join("<br/>") )  );
    }

    if ( (messages != null) && (messages.length > 0) ) {
      var message_list = $("<ul><" + "/ul>");
      for (var i = 0; i < messages.length; i++) {
        message_list.append( $("<li><" + "/li>").append(messages[i]) );
      }
      discounts_messages_container.append( $("<div class='oct-discounts-messages messages'><" + "/div>").append(message_list) );
    }
    
    if (table_subtotal == 0){
      hideCreditCardForm();
    }else{
      showCreditCardForm();
    }
}
//Updates the discount line items list and updates totals
function uc_discountsRenderLineItems(line_items, table_subtotal , show_message) {
  if ((window.set_line_item == null) || (line_items == null)) {
    return;
  }

  //Remove total discount line item
  remove_line_item(Drupal.settings.oct_discounts.line_item_key_name);

   var total_amount = 0;
    for (i = 0; i < line_items.length; i++) {
      var line_item = line_items[i];
      total_amount += parseFloat(line_item["amount"]);
  }

  //Add total discount line item
  if (line_items.length > 0) {
    set_line_item(Drupal.settings.oct_discounts.line_item_key_name,
                  Drupal.settings.oct_discounts.total_discount_text, total_amount,
                  parseFloat(Drupal.settings.oct_discounts.line_item_weight) + 0.5,
                  1,
                  false);
  }

  // Update total
  if (window.render_line_items) {
    render_line_items();
  }

  //If there is tax in the system, recalculate tax
  if (window.getTax) {
    getTax();
  }

  udpateCheckoutTable(total_amount, table_subtotal);
}

function udpateCheckoutTable(discount, total_price){
  var table_discount = $('.discount-price');
  var table_subtotal = $('.subtotal td');
  
  if(discount){
    $('.uc-price', table_discount).addClass(' hidden');
    $('.uc-discount-price', table_discount).html('$'+(discount * (-1)).toFixed(2) );
  }else{
    $('.uc-price', table_discount).removeClass('hidden');
    $('.uc-discount-price', table_discount).html('');
  }
  if(total_price >= 0){
    $('.uc-price', table_subtotal).addClass(' hidden');
    $('.uc-discount-price', table_subtotal).html('$'+total_price.toFixed(2) );
  }else{
    $('.uc-price', table_subtotal).removeClass('hidden');
    $('.uc-discount-price', table_subtotal).html('');
  }
}

function showCreditCardForm(){
  $('#uc-cart-checkout-form #payment_details').removeClass('hidden');
}

function hideCreditCardForm(){
  $('#uc-cart-checkout-form #payment_details').addClass('hidden');
}
