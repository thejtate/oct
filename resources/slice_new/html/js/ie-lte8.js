(function ($) {
  $(function() {
    page_pseudo();
  });

  function process_pseudo($elements) {
    if (typeof($elements) == 'undefined') {
      return;
    }
    $elements.each(function() {
      $.pseudo(this);
    });
  }

  function page_pseudo($context) {
    //apply pseudo fix
    if (ie_lessthan(8)) {
      var $pseudo_elements = $('.sidebar-block', $context).find('.button-go')
          .add($('.sidebar-block', $context).find('.button-submit'))
          .add($('.item-messages-wrapp', $context).find('.item-messages'))
          .add($('.item-messages-wrapp', $context))
          .add($('.header', $context).find('.decor-title'))
          .add($('.header', $context).find('.title-header'))
          .add($('.item-name', $context).find('.button'))
          .add($('.item-name .button-download', $context).find('span'))
          .add($('.item-name .button-visit', $context).find('span'))
          .add($('.item-messages', $context))
          .add($('.login-form-wrapper', $context))
          .add($('.login-form-wrapper', $context).find('.button-submit'))
          .add($('.login-form-wrapper', $context).find('.button-go'))
          .add($('.form-register-wrapper .button-submit', $context).find('.form-item'))

          //.add($('', $context).find(''))
        ;
      process_pseudo($pseudo_elements);
    }
  }


})(jQuery);


function ie_lessthan(v) {
  if (v == 8) {
    return typeof(window.localStorage) == 'undefined';
  }
  return jQuery.browser.msie && jQuery.browser.version.match(/^\d+/)[0] < v;
}

function ie_equal(v) {
  if (!jQuery.browser.msie) {
    return false;
  }
  var current = jQuery.browser.version.match(/^\d+/)[0];

  if (current == 7) {
    if (v == 8) {
      return typeof(window.localStorage) == 'object';
    }
    else if (v == 7) {
      return typeof(window.localStorage) == 'undefined';
    }
  }
  return jQuery.browser.version.match(/^\d+/)[0] == v;
}