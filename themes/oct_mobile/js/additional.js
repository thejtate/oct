Drupal.behaviors.js = function (context) {

};

$(document).ready(function(){
  showHideSponsorPage();
  //setLongLifeCookie();
  longCookieCycle(1);
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
});

/**
 * Remove sponsor page after 3 sec. 
 */
function showHideSponsorPage(){
  setTimeout( function(){
    $('body').removeClass('sponsor-bg');
    $('.sponsor-block' , $('body')).remove();
  }, 3000 );
}

/**
 * set coockie live + 60 sec every 10 sec
 */
function longCookieCycle(i){
  var expires_date = new Date();  
  expires_date.setTime(expires_date.getTime() + 60000);
  $.cookie("sponsor_showed", true,{ expires : expires_date });
  setTimeout('longCookieCycle('+(i+1)+')', 10000);
}
