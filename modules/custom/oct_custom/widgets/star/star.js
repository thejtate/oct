Drupal.behaviors.vud_widget_star = function (context) {
  if (!$('.vud-widget').hasClass('vud-widget-processed')) {
    $('.vote-star').click(function(){
      if($(this).hasClass('up-active') || $(this).hasClass('down-active')){
        $(this).parents('.vud-widget').find('.vud-link-reset').click();
      }
    });
  }
};
