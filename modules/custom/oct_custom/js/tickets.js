$(document).ready(function(){
  $('#uc-product-add-to-cart-form #edit-attributes-2').val('0');
  jsSelects();
  //call back function. onchane select load node and add to card form

  $('#product-tickets-select').change( function(){
    var nid = $(this).find('option:selected').val();
    changeFormCheckStock(nid);
  });
  /*
  $('#edit-attributes-2').change( function(){
    var nid = $('#product-tickets-select').find('option:selected').val();
    changeFormCheckStock(nid);
  });
  */
  formAction();
});
function changeFormCheckStock(nid){
  $.post(Drupal.settings.basePath + 'tickets/get_product_node/' + nid, null, function(response){
    var result = response;
    $('#product-form').replaceWith(result);

    $('.select-outline').each(function(){
      $(this).remove();
    });

    $('#uc-product-add-to-cart-form #edit-attributes-2').val('0');

    jsTicketsSelectsReload();
    formAction();
    checkCustomStock(nid);

    $('#uc-product-add-to-cart-form #edit-attributes-2').change(function() {
      checkCustomStock(nid);
    });
  });
  changeEditButton(nid);
}

function checkCustomStock(nid){
    var form = $("#uc-product-add-to-cart-form");
    var product = new Object();
    var attributes = new Object();
    attributes.found = new Object();
    attributes.value = new Object();
    product.nid = nid;
    $(":input[name*=attributes]:not(:text)", form).each(function(index){
      id = $(this).attr('name').substring(11,$(this).attr('name').length-1);
      if ($(this).is(':radio')) {
        attributes.found['attr'+id] = 1;
        if ($(this).is(':checked')) {
          if ($(this).val()) {
            attributes.value['attr'+id] = 1;
            product['attr'+id] = $(this).val();
          }
        }
      } else {
      attributes.found['attr'+id] = 1;
        if ($(this).val()) {
          attributes.value['attr'+id] = 1;
          product['attr'+id] = $(this).val();
        }
      }
    });
    $('#uc-product-add-to-cart-form .uc_out_of_stock_html').remove();
    $('#uc-product-add-to-cart-form input.node-add-to-cart').after('<div class="uc_out_of_stock_html"></div>');
    $.post(Drupal.settings.basePath + 'uc_out_of_stock/query', product, function (data, textStatus){
      data = data.split('|');
      stock = data[0];
      if (stock == parseInt(stock) && stock <= 0 && data.length == 2) {
        html = data[1];
        $("input:submit.node-add-to-cart,input:submit.list-add-to-cart", form).css('display','none');
        $(".uc_out_of_stock_html", form).html(html);
      } else {
        // Put back the normal HTML of the add to cart form
        $(".uc_out_of_stock_html", form).html('');
        $("input:submit.node-add-to-cart,input:submit.list-add-to-cart", form).css('display','block');
      }

      $(".uc_out_of_stock_throbbing", form).removeClass('uc_oos_throbbing');
    });
}

function changeEditButton(nid){
  $('.edit-products .ml_edit a').attr('href', '/node/'+nid+'/edit?destination=tickets%2F'+nid+'' )
  $('.edit-products .ml_delete a').attr('href', '/node/'+nid+'/delete?destination=tickets%2F'+nid+'' )
}

function changeFreeAdultTicket(){
  var qtychildren = $('#edit-attributes-12-53').find('option:selected').val();
  var qtygroupchildren = $('#edit-attributes-12-56').find('option:selected').val();
  var qtyfreeadult = $('#edit-attributes-12-54');
  var qtyfreeadultshow = $('.free-adult');

  var freeticket = 0;
  var freegroupticket = 0;
  if (qtychildren >= 20){
    freeticket = Math.floor( qtychildren/20 );
  }
  if (qtygroupchildren >= 20){

    freegroupticket = Math.floor( qtygroupchildren/20 );
  }
  qtyfreeadult.attr('value', freegroupticket + freeticket);
  qtyfreeadultshow.html(freegroupticket + freeticket);

}

function formAction(){

  $('#edit-attributes-12-53').change(function(){
      changeFreeAdultTicket();
  });
  $('#edit-attributes-12-56').change(function(){
      changeFreeAdultTicket();
  });

  $(".node-add-to-cart").click(function(){
      var qtyadult = $('#edit-attributes-12-52').find('option:selected').val();
      var qtystud = $('#edit-attributes-12-57').find('option:selected').val();
      var qtychildren = $('#edit-attributes-12-53').find('option:selected').val();
      var qtygroupadult = $('#edit-attributes-12-56').find('option:selected').val();
      var qtygroupchildren = $('#edit-attributes-12-55').find('option:selected').val();
      if (qtyadult == 0 && qtystud == 0 && qtychildren == 0 && qtygroupadult == 0 && qtygroupchildren == 0) {
          alert('Please choose ticket quantity');
          return false;
      }
  });

}

function jsTicketsSelectsReload(){
    $('select.enrollment-select').before('<span class="select-outline"></span>');
    $('.select-outline').html('<div class="select-text"><span class="stext-inner"></span></div><div class="sub-select"></div>');
    $('.select-outline').each(function(){
        $(this).addClass($(this).next('select.enrollment-select').attr('class'));
        $(this).next('select.enrollment-select').addClass('hiddenSelect');
        $(this).find('.select-text>span').text($(this).next('.hiddenSelect').find('option:selected').text())
        .css('width',$(this).width()-parseInt($(this).find('.select-text').css('padding-left'))-parseInt($(this).find('.select-text').css('padding-right'))+'px');
        addSuboption($(this));
        $(this).find('.sub-option:eq(0)').addClass('first').before('<div class="sub-top"></div>');
        $(this).find('.sub-option:contains(' + $(this).find('.select-text>span').text() + ')').addClass('active-sub-option');
        $(this).find('.sub-option:last').addClass('last').after('<div class="sub-bot"><div class="sub-bot-right"></div></div>');
    });
}
/*
function check_stock_product_aid(){
  $('#edit-attributes-2').live('change', function(){
    var aid = $(this).attr('selected').val();
    var nid = $('#product-tickets-select').attr('selected').val();
    
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + '?q=admin/product_aid_stock/',
      data: {'aid': aid , 'nid':nid},
      success: function(xmlHttpRequest, textStatus){
        if(xmlHttpRequest.responseText){
          $(".uc_out_of_stock_html", form).html(html);
          $("input:submit.node-add-to-cart,input:submit.list-add-to-cart", form).css('display','none');
        }else{
          $(".uc_out_of_stock_html", form).html('');
          $("input:submit.node-add-to-cart,input:submit.list-add-to-cart", form).css('display','block');
        }
      }
    })
    return false;
  });
  
}*/
