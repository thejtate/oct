Drupal.behaviors.enrollment = function (context) {
    jsSelects();

    $("#enrollment-month, #enrollment-day, #enrollment-year").change(loadCamp = function(){
        var month = $('#enrollment-month').find('option:selected').val();
        var day = $('#enrollment-day').find('option:selected').val();
        var year = $('#enrollment-year').find('option:selected').val();
        $.get('/enrollment/getData/'+month+'/'+day+'/'+year, null, enrollmentUpdateClass);        
    });
    /*
    $('#enrollment-class').change(function(){
      var nid = $(this).find('option:selected').val();
    });
    */
    loadCamp();
    
    // add to cart
    $("#submit").click(function(){
      $('.product-message .sold-out').html();
      var nid = $('#enrollment-class').find('option:selected').val();
      var oid = $('#enrollment-session-time').find('option:selected').val();
      var firstName = $('#enrollment_first_name').val();
      var lastName = $('#enrollment_last_name').val();
      if (nid && nid != '-1' && oid && oid != '-1' && !empty(firstName) && !empty(lastName)) {
          var data = $("#form-enrollment").serializeArray();
          $.post('/enrollment/setData/', data, enrollmentUpdateCart); 
      } else {
          alert('Please input First Name, Last Name and select Class/Camp with Session Time and Day');
          return false;
      }
    });
}


function enrollmentUpdateCart(response){
  var result = Drupal.parseJson(response);
    if (result.status == 0){
      //alert(result.data);
      if ( result.data ){
      $('.product-message .sold-out').html('<p><span style="color: red;">'+result.data+'</span></p>');
    }
  }
}

function enrollmentUpdateClass(response){
    var result = Drupal.parseJson(response);
    $("#enrollment-class").html('');
    $("#enrollment-session-time").html('');
    $("#t-sirts-attribut").addClass('hidden');
    var session = new Array();

    $("#enrollment-class").append('<option value="-1">Please select...</option>');
    $("#enrollment-session-time").append('<option value="-1">Please select...</option>');

    if( empty(result.data) ){
      /*$("#t-sirts-attribut").addClass('hidden');*/
    } else {
        for(n in result.data){
            $("#enrollment-class").append('<option value="' + n + '">' + result.data[n]['title'] + '</option>');
        }
        session = result.data;
    }
    // onload Class /Camp
    $("#enrollment-class").data('session', session);
        reloadSessionTimeAndPrice();
        jsEnrollmentSelectsReload();
    //onchange Class /Camp
    $("#enrollment-class").change(function(){
        reloadSessionTimeAndPrice();
        checkSold($(this));
    });
}

function jsEnrollmentSelectsReload(){
   // $('select.enrollment-select').before('<span class="select-outline"></span>');
    $('.select-outline').html('<div class="select-text"><span class="stext-inner"></span></div><div class="sub-select"></div>');
    $('.select-outline').each(function(){
        $(this).addClass($(this).next('select.enrollment-select').attr('class'));
        $(this).next('select.enrollment-select').addClass('hiddenSelect');
        $(this).find('.select-text>span').text($(this).next('.hiddenSelect').find('option:selected').text())
        .css('width',$(this).width()+10-parseInt($(this).find('.select-text').css('padding-left'))-parseInt($(this).find('.select-text').css('padding-right'))+'px');
        addSuboption($(this));
        $(this).find('.sub-option:eq(0)').addClass('first').before('<div class="sub-top"></div>');
        $(this).find('.sub-option:contains(' + $(this).find('.select-text>span').text() + ')').addClass('active-sub-option');
        $(this).find('.sub-option:last').addClass('last').after('<div class="sub-bot"><div class="sub-bot-right"></div></div>');
    });
}
function checkSold(select){
  var selected_class = select.find('option:selected').val();
}
/*
function jsSelectsReload(){
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
}*/

function reloadSessionTimeAndPrice(){
  var session = $("#enrollment-class").data('session');
  var camp = $("#enrollment-class").find('option:selected').val();
  var oid = $('#enrollment-session-time').find('option:selected').val();

  if (camp == -1) return false;

  // t shorts check
  if( !empty(session) ){
    if (session[camp].show_t_shirts == 1){
      $('#t-sirts-attribut').removeClass(' hidden');
    }else{
      $('#t-sirts-attribut').addClass(' hidden');
    }
  
  //set parametrs in seletcs
  $("#enrollment-session-time").unbind().html('');
  $("#enrollment-session-time").append('<option value="-1">Please select...</option>');
  if (!empty(session[camp].dates)) {
    for (var key in session[camp].dates) {
      var val = session[camp].dates[key]['date'];
      $("#enrollment-session-time").append('<option value="'+ session[camp].oids[key]['oid'] +'" >' + val + '</option>');
    }
    jsEnrollmentSelectsReload();
  } else {
    $("#enrollment-session-time").html('');
  }
  if (session[camp].show_t_shirts == 1){
    $("#enrollment-t-sirts-size").html('');
  } else {
      $("#enrollment-t-sirts-size").val('');
  }

  if (!empty(session[camp].t_shirt)) {
      $("#enrollment-t-sirts-size").append('<option value >Please select...</option>');
    for (var key in session[camp].t_shirt) {
      $("#enrollment-t-sirts-size").append('<option value="'+ session[camp].t_shirt[key]['oid'] +'" >' + session[camp].t_shirt[key]['size'] + '</option>'); //
    }
    jsEnrollmentSelectsReload();
  } else {


  }
       
  //check not avaliable and sold out
  // onload Session Time & Day
  var first_oid = session[camp].oids[0].oid;
  showHideByTimeEnrollmentForm(session, camp, first_oid);
  for (var nid_camp in session){
    session[nid_camp].selected = false;
  }
  session[camp].selected = true;
  
  // onchange Session Time & Day
  $('#enrollment-session-time').change(function(){
    oid = $(this).find('option:selected').val()
    if (!empty(session)) {
      var selected_camp;
      for (var nid_camp in session){
        if (session[nid_camp].selected){
          selected_camp = nid_camp;
        }
      }
    }
    showHideByTimeEnrollmentForm(session, selected_camp, oid);
    jsEnrollmentSelectsReload();
  });
  }else{
    jsEnrollmentSelectsReload();
  }
}

/**
 * Session Time & Day(s) actions
 */
function showHideByTimeEnrollmentForm(session, camp, oid){
  var delta;
  if (oid == -1) return false;
  if ( session[camp].oids ){
    for (var key in session[camp].oids) {
      if (session[camp].oids[key].oid == oid){
        delta = key;
      }
    }
  }
  if (!empty(session) && !empty(session[camp])) {
    $("#enrollment-price").html(session[camp].price);

    $("#enrollment-price").parent().removeClass('hidden');
    $('input#submit').removeClass('hidden');
    $('.product-message .online-unvaliable').html('');
    $('.product-message .sold-out').html('');

    if ( !empty( session[camp].sold[delta]) || !empty( session[camp].tickets[delta]) ){
      if ( ( session[camp].sold[delta].sold_out == 1) || ( session[camp].tickets[delta].tickets_qty <= 0) ){
        // hide
        $("#enrollment-price").parent().addClass('hidden');
        $('input#submit').addClass('hidden');
        if ( session[camp].sold_mes){
          $('.product-message .sold-out').html('<p><span style="color: red;">'+session[camp].sold_mes+'</span></p>');
        }else{
          $('.product-message .sold-out').html('<p><span style="color: red;">Sold Out</span></p>');
        }
      }
    }
    if (!empty(session[camp].online[delta])){
      if (session[camp].online[delta].avaiable_online == 1){
        // hide
        $("#enrollment-price").parent().addClass('hidden');
        $('input#submit').addClass('hidden');
        if ( session[camp].online_mes){
          $('.product-message .online-unvaliable').html('<p>'+session[camp].online_mes+'</p>');
        }else{
          $('.product-message .online-unvaliable').html('<p>Online Registration unavailable, please call (405) 606-7003</p>');
        }
      }
    }
  } else {
    // show
    $("#enrollment-price").html("0.00");  
    $("#enrollment-session-time").html("");  
  }
}

// Determine whether a variable is empty
function empty( mixed_var ) {   
    return ( mixed_var === "" || mixed_var === 0   || mixed_var === "0" || mixed_var === null  || mixed_var === false  ||  ( is_array(mixed_var) && mixed_var.length === 0 ) );
}

function is_array(input){
    return typeof(input)=='object'&&(input instanceof Array);
}
