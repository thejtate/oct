Drupal.behaviors.js = function (context) {

};

$(document).ready(function(){
	$("#slider").easySlider({
		prevText:'',
		nextText:'',
		vertical:true,
                auto:true,
                speed:800,
                pause:2000,
                continuous:true
	});
	$("#slider li:first").css('margin-left', '0');

  setMaskUserInfoPhone();
  validateUserInfoForm();
  pressDonateButton();

  //set oct custom radibutton 
  if(navigator.userAgent.search(/msie/i)!= -1) {
    // IE Code
  } else {
    // Non-IE Code
  Custom.init();
  }
  
});

function validateUserInfoForm(){
  //default validate
   var validator = $('#uc-cart-checkout-form').validate({
    rules:{
      'panes[oct_custom][user_info_parent_of_guardian_first_name]':{
        required: true,
        minlength: 1
      },
      'panes[oct_custom][user_info_parent_of_guardian_last_name]':{
        required: true,
        minlength: 1
      },
      'panes[oct_custom][user_info_another_parent_of_guardian_first_name]':{
        /*required: true,*/
        minlength: 1
      },
      'panes[oct_custom][user_info_another_parent_of_guardian_last_name]':{
        /*required: true,*/
        minlength: 1
      },
      'panes[oct_custom][user_info_phone_number]':{
        required: true,
        minlength: 14,
        maxlength: 14
      },
      'panes[oct_custom][user_info_address]':{
        required: true,
        minlength: 2
      },
      'panes[oct_custom][user_info_сity]':{
        required: true,
        minlength: 2
      },
      'panes[oct_custom][user_info_state]':{
        required: true
      },
      'panes[oct_custom][user_info_zip]':{
        required: true,
        minlength: 5,
        maxlength: 5,
        digits: true
      },
      'panes[oct_custom][user_info_email]':{
        required: true,
        email: true
      },
      'panes[oct_custom][user_info_email_confirm]':{
        required: true,
        /*email: true,*/
        equalTo: '#edit-panes-oct-custom-user-info-email'
      }
    },
    messages:{
      'panes[oct_custom][user_info_parent_of_guardian_first_name]':{
        required: 'Parent or Guardian First name field is required.',
        minlength: 'First name too short.'
      },
      'panes[oct_custom][user_info_parent_of_guardian_last_name]':{
        required: 'Parent or Guardian Last name field is required.',
        minlength: 'Last name too short.'
      },
      'panes[oct_custom][user_info_another_parent_of_guardian_first_name]':{
        /*required: 'Another Parent or Guardian First name field is required.',*/
        minlength: 'First name too short.'
      },
      'panes[oct_custom][user_info_another_parent_of_guardian_last_name]':{
        /*required: 'Another Parent or Guardian Last name field is required.',*/
        minlength: 'Last name too short.'
      },
      'panes[oct_custom][user_info_phone_number]':{
        required: 'Phone Number field is required.',
        minlength: 'Phone Number is too short.',
        maxlength: 'Phone Number is too long.'
      },
      'panes[oct_custom][user_info_address]':{
        required: 'Address field is required.',
        minlength: 'Address field is too short.'
      },
      'panes[oct_custom][user_info_сity]':{
        required: 'City field is required.',
        minlength: 'City field is too short'
      },
      'panes[oct_custom][user_info_state]':{
        required: 'Chose state.'
      },
      'panes[oct_custom][user_info_zip]':{
        required: 'Zip field is required.',
        minlength: 'Zip field is too short.',
        maxlength: 'Zip field is too long.',
        digits: 'Use only digits'
      },
      'panes[oct_custom][user_info_email]':{
        required: 'Email address field is required.',
        email: 'Email address not valid.'
      },
      'panes[oct_custom][user_info_email_confirm]':{
        required: 'Re-enter email address field is required.',
        /*email: true,*/
        equalTo: 'Email not equal'
      }
    }
  });
  $('#edit-cancel').live('click', function(){
    $('#oct_custom-pane' , $('#uc-cart-checkout-form')).remove();
  });
}

function setMaskUserInfoPhone(){
  $("#uc-cart-checkout-form #edit-panes-oct-custom-user-info-phone-number").mask("(999) 999-9999");
}
function pressDonateButton(){
  $('a','.b-sidebar-links .donation').click( function(){
    $('.paypal-donate-form').submit();
  });
  $('.make_a_donation').click( function(){
    $('.paypal-donate-form').submit();
  });
}
