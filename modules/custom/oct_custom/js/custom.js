Drupal.behaviors.custom = function (context) {
  $('#group_product_session_time_values div[id*="-field-product-wd-"]').addClass('weekdays');

  $('#group_product_session_time_values div[id*="-field-class-date-"]').addClass('field-class-date-list').find('input').datepicker({altFormat: 'M d, Y'});
  $('#group_product_session_time_values div[id*="-field-class-time-"]').addClass('field-class-time-list').find('input');
  initTableUserInfoSorter();
  initTableOnlineRegisterSorter();
  duplicateProductDateOnChangeTicketsAction();
}

$(document).ready(function() {
  setNoRedirectToForm($('#webform-client-form-67'));
  setNoRedirectToForm($('#webform-client-form-396'));

  //edit product
  RadioButtonProductNodeTypeInit();
});
function RadioButtonProductNodeTypeInit(){

   // on load
  selectNodeTaxonomy();
  // on change
  $("#edit-taxonomy-1").change(
    selectNodeTaxonomy
  );
  // on load
  selectProductTaxonomy();
  // on change
  $("#edit-taxonomy-4").change(
    selectProductTaxonomy
  );

  checkMinToMax($('#edit-field-min-class-age-value-wrapper select'), $('#edit-field-max-class-age-value-wrapper select'));
  checkMinToMax($('#edit-field-group-child-quantity-from-value'), $('#edit-field-group-child-quantity-to-value'));
  checkMinToMax($('#edit-field-group-adult-quantity-from-value'), $('#edit-field-group-adult-quantity-to-value'));
}

function checkMinToMax(select_min, select_max){
  // on load
  setMax(select_min, select_max);
  setMin(select_min, select_max);
  // on change
  select_min.live('change', function(){
    setMax($(this), select_max);
  });
  select_max.live('change', function(){
    setMin(select_min, $(this));
  });
}
function  setMax(select_min, select_max){
  var min = parseInt(select_min.val());
  $('option', select_max).each(function(){
    $(this).attr('disabled','');
    var max  = parseInt($(this).val());
    if (min > max){
      $(this).attr('disabled','disabled');
    }
  });
}
function  setMin(select_min, select_max){
  var max = parseInt(select_max.val());
  $('option', select_min).each(function(){
    $(this).attr('disabled','');
    var min  = parseInt($(this).val());
  if (min > max){
    $(this).attr('disabled','disabled');
  }
  });
}
function selectNodeTaxonomy(){
  var select = $("#edit-taxonomy-1-wrapper #edit-taxonomy-1").val();
  switch(select){
  case '':
    // hide all fields
    $('fieldset.group-classes').addClass('hidden');
    $('fieldset.group-productions').addClass('hidden');
    //$('#edit-body-wrapper').addClass('hidden');
    $('#edit-field-quantity-of-seats-0-value-wrapper').addClass('hidden');
    $('#edit-taxonomy-4-wrapper').addClass('hidden');
    $('#edit-taxonomy-9-wrapper').addClass('hidden');

    $('#edit-field-product-sold-value-wrapper').addClass('hidden');
    $('#edit-field-product-unvaliable-online-value-wrapper').addClass('hidden');
    $('#edit-field-product-sold-message-0-value-wrapper').addClass('hidden');
    $('#edit-field-product-unvaliable-message-0-value-wrapper').addClass('hidden');

    // clear all fields
    $('fieldset.group-classes').find("input[type=text]").attr('value','');
    $('fieldset.group-productions').find("input[type=text]").attr('value','');
    //$('#edit-body-wrapper').find("input[type=text]").attr('value','');
    $('#edit-field-quantity-of-seats-0-value-wrapper').find("input[type=text]").attr('value','');
    $('#edit-taxonomy-4-wrapper #edit-taxonomy-4 option:first').attr('selected', 'yes');//empty();

    // clear all select
    $('fieldset.group-classes select').each(
      function(){
        $(this).val('option:first');
      }
    );
    $('fieldset.group-productions select').each(
      function(){
        $(this).val('option:first');
      }
    );
    break;
  case '1':
    // clear classes fields
    $('fieldset.group-classes').addClass('hidden');
    $('#edit-taxonomy-9-wrapper').addClass('hidden');

    setTimeout( function(){$('#edit-field-quantity-of-seats-0-value-wrapper').addClass('hidden');}, 1000);

    // clear classes fields
    $('.fieldsetgroup-classes').find('input[type=text]').attr('value','');
    $('#edit-field-quantity-of-seats-0-value-wrapper').find('input[type=text]').attr('value','');

    // clear classes select
    $('.fieldsetgroup-classes select').each(
      function(){
        $(this).val('option:first');
      }
    );
    $('#edit-taxonomy-4-wrapper').removeClass('hidden');
    break;
  case '2':
    //class date sorter
    //sortProductDates($('#group_product_session_time_values'), '.field-class-date-list:eq(0) input');

    // clear productions fields

    $('fieldset.group-productions').addClass('hidden');
    $('#edit-taxonomy-4-wrapper').addClass('hidden');
    $('#edit-taxonomy-9-wrapper').addClass('hidden');
    //$('#edit-body-wrapper').addClass('hidden');
    $('#field-class-no-dates-items').addClass('hidden');
    $('#field-class-final-perfomance-items').addClass('hidden');
    $('#edit-field-class-production-0-value-wrapper').addClass('hidden');

    // clear productions select
    $('fieldset.group-productions select').each(
      function(){
        $(this).val('option:first');
      }
    );
    // clear productions fields
    $('fieldset.group-productions').find("input[type=text]").attr('value','');
    //$('#edit-body-wrapper').find("textarea").attr('value','');

    // show classes fields
    $('fieldset.group-classes').removeClass('hidden')
    $('#field-class-final-perfomance-items').removeClass('hidden');
    $('#edit-field-quantity-of-seats-0-value-wrapper').removeClass('hidden');
    $('#edit-field-product-sold-value-wrapper').removeClass('hidden');
    $('#edit-field-product-unvaliable-online-value-wrapper').removeClass('hidden');
    $('#edit-field-product-sold-message-0-value-wrapper').removeClass('hidden');
    $('#edit-field-product-unvaliable-message-0-value-wrapper').removeClass('hidden');
    break;
  case '3':
    //class date sorter
    //sortProductDates($('#group_product_session_time_values'), '.field-class-date-list:eq(0) input');

    // clear productions fields
    $('fieldset.group-productions').addClass('hidden');
    $('#edit-taxonomy-4-wrapper').addClass('hidden');
    //$('#edit-body-wrapper').addClass('hidden');

    // clear productions select
    $('fieldset.group-productions select').each(
      function(){
        $(this).val('option:first');
      }
    );

    // clear productions fields
    $('fieldset.group-productions').find("input[type=text]").attr('value','');
    //$('#edit-body-wrapper').find("textarea").attr('value','');

    // show classes fields
    $('fieldset.group-classes').removeClass('hidden')
    $('#edit-field-quantity-of-seats-0-value-wrapper').removeClass('hidden');

    $('#field-class-no-dates-items').removeClass('hidden');
    $('#field-class-final-perfomance-items').removeClass('hidden');
    $('#edit-field-class-production-0-value-wrapper').removeClass('hidden');
    $('#edit-field-product-sold-value-wrapper').removeClass('hidden');
    $('#edit-field-product-unvaliable-online-value-wrapper').removeClass('hidden');
    $('#edit-field-product-sold-message-0-value-wrapper').removeClass('hidden');
    $('#edit-field-product-unvaliable-message-0-value-wrapper').removeClass('hidden');
    $('#edit-taxonomy-9-wrapper').removeClass('hidden');
    break;
  }
}
function setNoRedirectToForm(selector){
  selector.attr('action', '#');
}
/* Table sorter for Collection page */
function initTableUserInfoSorter(){
  $('.user-info-table').tablesorter( {sortList: [[0,0]]} );
}
/* Table sorter for Collection page */
function initTableOnlineRegisterSorter(){
  $('.online-register-table').tablesorter( {sortList: [[0,0]]} );
}
/*
 * check Thearte or Touring
 */
function selectProductTaxonomy(){
  var select_product_type = $("#edit-taxonomy-4-wrapper #edit-taxonomy-4").val();
  switch(select_product_type){
      case '24':
        //Theatre

        //product date sorter
        //sortProductDates($('#field_product_date_values'), 'fieldset .container-inline-date:eq(0) .form-item .form-item:eq(0) input.form-text');

        // show productions fields
        $('.group-productions').removeClass('hidden');
        //$('#edit-body-wrapper').removeClass('hidden');
        $('#edit-field-quantity-of-seats-0-value-wrapper').removeClass('hidden');
        $('#edit-field-product-sold-value-wrapper').removeClass('hidden');
        $('#edit-field-product-unvaliable-online-value-wrapper').removeClass('hidden');
        $('#edit-field-product-sold-message-0-value-wrapper').removeClass('hidden');
        $('#edit-field-product-unvaliable-message-0-value-wrapper').removeClass('hidden');
        $('#edit-field-theatre-select-description-value').removeClass('hidden');
        break;
      case '25':
        //Touring
        $('.group-productions').addClass('hidden');
        $('#edit-field-quantity-of-seats-0-value-wrapper').addClass('hidden');
        $('#edit-field-product-sold-value-wrapper').addClass('hidden');
        $('#edit-field-product-unvaliable-online-value-wrapper').addClass('hidden');
        $('#edit-field-product-sold-message-0-value-wrapper').addClass('hidden');
        $('#edit-field-product-unvaliable-message-0-value-wrapper').addClass('hidden');
        $('#edit-field-theatre-select-description-value').addClass('hidden');
        //Dont show anything
      break;
  }
}
function validateProductForm(){
  $('.node-form').validate({
    rules:{}
  });
}
/**
 * Sort group field automaticly
 */

function sortProductDates(multiple_row_table_selector, first_input_in_row ){
  var date = {};
  var full_date;
  var i = 0;
  $('tbody tr', multiple_row_table_selector).each( function(){
    full_date = ($(first_input_in_row , $(this)).val()).split('/');
    var d = new Date();
    d.setDate(full_date[1]);
    d.setMonth(full_date[0]);
    d.setFullYear(full_date[2]);
    date[parseInt(i)] = {'value': d, 'key': i};
    i++;
  });
  var t = true;
  var now;
  // bubble sort for know what has item weight
  while(t){
    t = false;
    $.each(date, function(index, value){
      if (date[(parseInt(index)+1)]){
        if (date[index].value > date[(parseInt(index)+1)].value){
          now = date[index];
          date[index]= date[parseInt(index)+1];
          date[parseInt(index)+1] = now;
          t = true;
        }
      }
    });
  }
  //sorted

  var opt;
  //get length all dates
  var length = 0;
  for(var i in date) length++;
  // set order
  $('tbody tr .delta-order', multiple_row_table_selector).each(function(index_s, value_s){
    $('select').selectedIndex=-1;
    $.each(date, function(index, value){
      if (date[index].key == index_s){
        opt = (parseInt(index)); //length
      }
    });
    $('select option:eq(' + opt  + ')', $(this)).attr('selected', 'selected');
  });
  //after submit form they will be saved
}
function filterUserInfoByDate(){
  $('#filter-user-info-form').live('submit', function(e) {
      e.preventDefault();
      getUserInfoFilteredData();
      return false;
  });
  //onload init datepicker
  datepickerInitForFiterUserInfoTable();
}

function getUserInfoFilteredData( pressed_page ){
  if (typeof pressed_page == 'undefined'){
    pressed_page = 1;
  }
  var form_data = $('#filter-user-info-form').serialize();
  $.ajax({
    type: "POST",
    url: Drupal.settings.basePath + "?q=admin/user-info/get_from_date",
    data:  {'data': form_data, 'pressed_page': pressed_page},
    complete: function(xmlHttpRequest, textStatus) {
      try{
        // Set filtered data to table;
        $('#user-info-page-content').html(xmlHttpRequest.responseText);
        // again set datepicker;
        datepickerInitForFiterUserInfoTable()
      }catch(e){
        $('#user-info-page-content').html('');
        return;
      }
    }
  });
}

function changeUserInfoPage(){
  $('.bottom-control .table-pager a').live('click', function(e) {
      var pressed_page = $(this).text();
      e.preventDefault();
      getUserInfoFilteredData( pressed_page );
      return false;
  });
  //onload init datepicker
  datepickerInitForFiterUserInfoTable();
}

function datepickerInitForFiterUserInfoTable(){
  $('#edit-data-sorter-user-info-from').datepicker({dateFormat: "mm/dd/yy"});
  $('#edit-data-sorter-user-info-to').datepicker({dateFormat: "mm/dd/yy"});
}

function saveEventToDate(){
  //on load
  var from_date = $('#edit-field-fun-night-date-0-value-datepicker-popup-0').val();
  $('#edit-field-fun-night-date-0-value2-datepicker-popup-0').val(from_date);
  //on change
  $('#edit-field-fun-night-date-0-value-datepicker-popup-0').live('change', function (){
    var from_date = $('#edit-field-fun-night-date-0-value-datepicker-popup-0').val();
    $('#edit-field-fun-night-date-0-value2-datepicker-popup-0').val(from_date);
  });
}

function countRegistratoinOnlineFormStepOne(){

  //onload selects
  $('.register-form-row').each(function(){
    var price_item_object = $('div.online-register-price', $(this));
    var input_item_object = $('input.count-form-text', $(this));
    var qty_item_value = $("select.form-select", $(this)).find('option:selected');
    input_item_object.val( qty_item_value.val() * parseInt(price_item_object.text()));
    countTotalOnlineForm();
  });

  //onchange selects
  $(".register-form-row select.form-select").change( function(){
    var price_item_value = parseInt($(this).parent().parent().find('div.online-register-price').text());
    var input_item_object = $(this).parent().parent().find('input.form-text');
    var qty_item_value = parseInt($(this).find('option:selected').val());
    input_item_object.val( qty_item_value * price_item_value);
    countTotalOnlineForm();
  });

  //onchange radios
  var radio_price = 0;
  $('.register-form-row .form-checkbox').click( function(){
    countTotalOnlineForm();
  });

  //onchange donate
  $('#edit-online-registration-donate').change( function(){
    countTotalOnlineForm();
  });
  $('#edit-online-registration-donate-amount').keyup( function(){
    countTotalOnlineForm();
  });
}

function countTotalOnlineForm(){

  var input_item_object = $('.register-form-row input.count-form-text');
  var total_object = $('#edit-online-registration-total-cost');
  var fee_object = $('#edit-online-registration-handling-fee');
  var total_cost_object = $('#edit-online-registration-total-attendee-cost');
  //count textfields
  var total = 0;
  input_item_object.each(function(){
    total += parseInt($(this).val());
  });

  //count radios
  var total_radio = 0;
  $('.register-form-row .form-checkbox').each(function(){
    if($(this).attr('checked')){
      total_radio += parseInt( $(this).parent().parent().parent().find('.online-register-radiobutton-price').text() );
    }
  });
  total = (total + total_radio);
  total_object.val(  total.toFixed(2) );

  var fee = getTotalFee(total);
  fee_object.val( fee.toFixed(2) );

  var result = (total + fee);
  total_cost_object.val(  result.toFixed(2) );

  //count donate textfield
  var donate_checkbox = $('#edit-online-registration-donate');
  var donate = parseInt($('#edit-online-registration-donate-amount').val());
  if ( is_int(donate) && donate_checkbox.attr('checked') ){
    result = result + donate;
    total_cost_object.val(  result.toFixed(2) );
  }
}

function getTotalFee( total ){
  var fee = (total/100) * 3;
  return fee;
}

function addAnotherFieldAfterFill(){
  autoCreateEmptyField( $('.first-last-names-of-children') );
  autoCreateEmptyField( $('.first-last-names-of-adult') );
}
function autoCreateEmptyField(parent){

  var el_class = ".form-text";

  $(el_class + ":last", parent).live('keyup', function(){
    //add new row
    if ($(this).val() != '') {
      var new_el = $(this).removeAttr('id').clone().val("");
      new_el.appendTo($( 'div.form-item', parent));
    }
  });

  $(el_class + ":not(:last)", parent).live('keyup', function(e){
    // remove empty (not last)
    var code = e.keyCode || e.which;
    if ($(this).val() == '' && code != '9' && this.localName.toLowerCase() == 'input' && $(this).parent().find('input').length > 1) { // 9 = <TAB>
      $parent = $(this).parent();
      $(this).remove();
      $parent.find('input:last').focus();
      //$(el_class + ":last", parent).focus();
    }
  });
}

function empty (mixed_var) {
    var key;
    if (mixed_var === "" || mixed_var === 0 || mixed_var === "0" || mixed_var === null || mixed_var === false || typeof mixed_var === 'undefined') {
        return true;
    }

    if (typeof mixed_var == 'object') {for (key in mixed_var) {
            return false;
        }
        return true;
    }
    return false;
}

function is_int(value){
  if((parseFloat(value) == parseInt(value)) && !isNaN(value)){
      return true;
  } else {
      return false;
  }
}

function checkTotalPriceIsNull(){
  $('#online-registration-form-step-1').submit( function(){
    if ( empty( parseInt($('#edit-online-registration-total-attendee-cost', $(this)).val()) ) ){
      alert('Total attendee price is empty');
      return false;
    }
  });
}

function ajaxStepOneOnlineRegistratonForm(){
  $('#edit-actions #edit-back').live('click', function(){
    var data_form_step_2 = $('#webform-client-form-182').serializeArray();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + '?q=fairy-tale-ball/register-online/step_1',
      data: data_form_step_2,
      success: function(xmlHttpRequest, textStatus){
        try{
          $('#registration-online-form-wrapper').html( xmlHttpRequest );
          jsSelects();
          if(navigator.userAgent.search(/msie/i)!= -1) {
            // IE Code
          } else {
            // Non-IE Code
            Custom.init();
          }
          countRegistratoinOnlineFormStepOne();
          //ajaxStepTwoOnlineRegistratonForm();
          ajaxStepTwoOnlineRegistratonFormSubmit();
        }catch(e){
          $('#registration-online-form-wrapper').html( '<p>Some error happend. Please try again later</p>');
          return;
        }
      }
    })
    return false;
  });
}

function ajaxStepTwoOnlineRegistratonFormSubmit(){
  $('#online-registration-form-step-1').submit( function(){
    //check total price if is null form step 1
    if ( empty( parseInt($('#edit-online-registration-total-attendee-cost', $(this)).val()) ) ){
      alert('Total attendee price is empty');
      return false;
    }
    var data_form_step_1 = $(this).serializeArray();
    // reload fo new step
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + "?q=fairy-tale-ball/register-online/step_2",
      data: data_form_step_1,
      dataType: "JSON",
      success:function(xmlHttpRequest, textStatus){
        try{
          //redraw next step
          $('#registration-online-form-wrapper').html( xmlHttpRequest );
          jsSelects();
          validateOnlineRegistrationStepTwo();
          ajaxStepOneOnlineRegistratonForm();
          ajaxStepThreeOnlineRegistratonForm();
          addAnotherFieldAfterFill();
        }catch(e){
          $('#registration-online-form-wrapper').html( '<p>Some error happend. Please try again later</p>');
          return;
        }
      }
    })
    return false;
  });
}

function ajaxStepThreeOnlineRegistratonForm(){
  $('#online-registration-form-step-2').submit( function(){
    var data_form_step_2 = $(this).serializeArray();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + '?q=fairy-tale-ball/register-online/step_3',
      data: data_form_step_2,
      success: function(xmlHttpRequest, textStatus){
        try{
          $('#registration-online-form-wrapper').html( xmlHttpRequest );
        }catch(e){
          $('#registration-online-form-wrapper').html( '<p>Some error happend. Please try again later</p>');
          return;
        }
      }
    })
    return false;
  });
}

function validateOnlineRegistrationStepTwo(){
  $('#webform-client-form-182').validate({
    rules:{
      'submitted[name_company_name]':{
        required: true,
        minlength: 1
      },
      'submitted[name_company_name]':{
        required: true,
        minlength: 1
      },
      'submitted[phone]':{
        required: true,
        minlength: 1
      },
      'submitted[email]':{
        required: true,
        email: true
      },
      'submitted[adress]':{
        required: true,
        minlength: 2
      },
      'submitted[city]':{
        required: true,
        minlength: 2
      },
      'submitted[zip]':{
        required: true,
        minlength: 3
      }
    },
    messages:{
      'submitted[name_company_name]':{
        required: 'Name/Company Name field is required.',
        minlength: 'Name too short.'
      },
      'submitted[name_company_name]':{
        required: 'Name/Company Name field is required.',
        minlength: 'Name too short.'
      },
      'submitted[phone]':{
        required: 'Phone field is required.',
        minlength: 'Phone number too short.'
      },
      'submitted[email]':{
        required: 'Email address field is required.',
        email: 'Email address not valid.'
      },
      'submitted[adress]':{
        required: 'Address field is required.',
        minlength: 'Address too short.'
      },
      'submitted[city]':{
        required: 'City field is required.',
        minlength: 'City too short.'
      },
      'submitted[zip]':{
        required: 'Zip field is required.',
        minlength: 'Zip code too short.'
      }
    }
  });
}

function duplicateProductDateOnChangeTicketsAction(){
  $('table#group_product_date_values tbody tr td fieldset').each(function(){
    var date_from = $('.container-inline-date:first .form-item .form-item:first input[id*="edit-group-product-date"]',  $(this) );
    var date_to = $('.container-inline-date:last .form-item .form-item:first input[id*="edit-group-product-date"]', $(this) );
    date_from.change(function(){
      if ( date_from.val() ){
        date_to.val( date_from.val() );
      }
    });
  });
}