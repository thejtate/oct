(function ($) {
  $(function () {
    init_scrollFix();
  });


  function init_scrollFix() {
    setTimeout(function () {
      $('.form-textarea-wrapp .form-textarea').cuText({
        showArrows:false,
        scrollbarWidth:5
      }).hasClass('error') && $('.area-container .cuTextWrap').addClass('error');
    });
  };
})(jQuery);