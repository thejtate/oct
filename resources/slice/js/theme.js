$(document).ready(function () {
  jsSelects();
  initTShirtsSelect();
});

function addSuboption(elem) {
  var id = elem.next('select').attr('id');
  var val = '';
  elem.next('.hiddenSelect').find('option, optgroup').each(function () {
    if (this.localName == 'optgroup') {
      elem.find('.sub-select').append('<div class="sub-optgroup">' + $(this).attr('label') + '</div>');
    } else {
      val = $(this).val();
      val = create_select_val(val)
      elem.find('.sub-select').append('<div class="sub-option" id="' + id + '_' + val + '">' + $(this).text() + '</div>');
      val = '';
    }
    elem.change(function () {
      $(this).next('.hiddenSelect').change();
    });
  });
}

function jsSelects() {
  $('select:not(.normal)').before('<span class="select-outline"><div class="select-text"><span class="stext-inner"></span></div><div class="sub-select"></div></span>').hide();
  $('.select-outline').each(function () {
    $(this).addClass($(this).next('select').attr('class'));
    $(this).next('select').addClass('hiddenSelect');
    $(this).find('.select-text>span').text($(this).next('.hiddenSelect').find('option:selected').text())
      .css('width', $(this).width() - parseInt($(this).find('.select-text').css('padding-left')) - parseInt($(this).find('.select-text').css('padding-right')) + 'px');
    addSuboption($(this));
    $(this).find('.sub-option:eq(0)').addClass('first').before('<div class="sub-top"></div>');
    $(this).find('.sub-option:contains(' + $(this).find('.select-text>span').text()).addClass('active-sub-option');
    $(this).find('.sub-option:last').addClass('last').after('<div class="sub-bot"><div class="sub-bot-right"></div></div>');
  });
  $('.select-text').live('mouseenter mouseleave', function () {
    $(this).parent().toggleClass('select-hover')
  }).live('click', function () {
    var par = $(this).parent();
    $('.select-active').removeClass('current');
    if (!par.hasClass('select-active'))
      par.addClass('current');
    par.find('.sub-select').toggle();
    par.toggleClass('select-active');
    return false;
  });
  $('.sub-option').live('click', function () {
    var pars = $(this).parents('.select-outline');

    var id_suffix = pars.next('select').attr('id');
    var selected_id = $(this).attr('id');
    var selected_value = str_replace(id_suffix + "_", "", selected_id);

    var s_val = '';
    pars.next('select').find('option').attr('selected', '').each(function () {
      s_val = create_select_val($(this).val());
      if (s_val == selected_value) {
        $(this).attr('selected', 'selected');
      }
    });


    pars.find('.active-sub-option').removeClass('active-sub-option');
    $(this).addClass('active-sub-option');
    pars.find('.select-text>span').text($(this).text());

    pars.next('select').change();
    pars.find('.select-text>span').width('auto');
    Cufon.refresh();
  });
  $('.sub-option, .select-text span').addClass('gothic');
  Cufon.refresh();
  $(document).click(function (e) {
    if (e.target.className != 'sub-optgroup') {
      if ((e.target.className != 'select-text') && (e.target.className != 'stext-inner')) {
        $('.sub-select').hide();
        $('.select-outline').removeClass('select-active');
      } else {
        var index = $('.select-outline').index($(e.target).parents('.select-outline'));
        $('.select-outline').each(function (i) {
          if (i != index) {
            $(this).removeClass('select-active').find('.sub-select').hide();
          }
        });
      }
    }
  });
  jQuery('.sub-select').each(function () {
    i = 0;
    jQuery('.sub-option', this).each(function () {
      if (++i % 10 == 0) $(this).addClass('sub-option-dark');
    })
  })
}

function create_select_val(val) {
  val = str_replace("'", "", val);
  val = str_replace('"', "", val);
  val = str_replace('&', "", val);
  val = str_replace('%', "", val);
  val = str_replace('@', "", val);
  val = str_replace('$', "", val);
  val = str_replace('(', "", val);
  val = str_replace(')', "", val);
  val = str_replace(' ', "-", val);
  return val;
}

function str_replace(search, replace, subject) {
  return subject.split(search).join(replace);
}

function initTShirtsSelect() {
  if ($('.t-shirts-colors').size()) {
    images_src = new Array('red', 'dark-orange', 'orange', 'yellow', 'purple', 'dark-blue', 'blue', 'light-blue', 'green', 'olive', 'light-brown', 'light-green', 'white', 'grey', 'pink', 'dark-purple');
    images = new Array();

    for (key in images_src) {
      images[key] = new Image();
      images[key].src = './images/t-shirts/' + images_src[key] + '.jpg';

    }
    console.log(images);

    $('.t-shirts-colors div').click(function () {
      tshirtsrc = $(this).attr('class');
      $('.t-shirt-wrapper img').attr('src', images[$('.t-shirts-colors div').index($(this))].src);
      $('input', $(this).parent()).val();

      $('.t-shirts-colors label').text('Colour:  ' + $(this).attr('title').replace('-', ' '));
      Cufon.refresh();
    });
  }
}