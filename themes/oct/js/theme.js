$(document).ready(function() {
  // clone image
  $('img').each(function(){
      //this.src = grayscale(this.src);
  });
  $('a, ul, li, p, div, b, span, strong').each(function(){
    //grayColor($(this));
  });

});

// Grayscale w canvas method
function grayscale(src){
    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');
    var imgObj = new Image();
    imgObj.src = src;
    canvas.width = imgObj.width;
    canvas.height = imgObj.height;

    if (canvas.height && canvas.width){
      ctx.drawImage(imgObj, 0, 0);
      var imgPixels = ctx.getImageData(0, 0, canvas.width, canvas.height);
      for(var y = 0; y < imgPixels.height; y++){
          for(var x = 0; x < imgPixels.width; x++){
              var i = (y * 4) * imgPixels.width + x * 4;
              var avg = (imgPixels.data[i] + imgPixels.data[i + 1] + imgPixels.data[i + 2]) / 3;
              imgPixels.data[i] = avg;
              imgPixels.data[i + 1] = avg;
              imgPixels.data[i + 2] = avg;
          }
      }
      ctx.putImageData(imgPixels, 0, 0, 0, 0, imgPixels.width, imgPixels.height);
    return canvas.toDataURL();
    }
}
function grayColor(selector){

  var fontcolor = selector.css('color');
  var bcgcolor = selector.css('borderRightColor');
  var bordercolor = selector.css('bordercolor');
  var shadowcolor = selector.css('textShadow');

  if (fontcolor != 'none'){
    var fontgray = colorToGray(fontcolor);
    selector.css('color', 'rgb('+fontgray+','+fontgray+','+fontgray+')');
  }
  if (bcgcolor != 'none'){
    var bcggray = colorToGray(bcgcolor);
    selector.css('backgroundColor', 'rgb('+bcggray+','+bcggray+','+bcggray+')');
  }
  if (bordercolor != 'none'){
    var bordergray = colorToGray(bordercolor);
    selector.css('borderTopColor', 'rgb('+bordergray+','+bordergray+','+bordergray+')');
    selector.css('borderRightColor', 'rgb('+bordergray+','+bordergray+','+bordergray+')');
    selector.css('borderBottomColor', 'rgb('+bordergray+','+bordergray+','+bordergray+')');
    selector.css('borderLeftColor', 'rgb('+bordergray+','+bordergray+','+bordergray+')');
  }
  if (shadowcolor != 'none'){
    var shadowgray = colorToGray(shadowcolor);
    selector.css('textShadow', 'rgb('+shadowgray+','+shadowgray+','+shadowgray+')');
  }
}

function colorToGray(str){
  if (str.substring(0, 3) == 'rgb') {
		var arr = str.split(",");
    var r = parseInt(arr[0].replace('rgb(','').trim()),
        g = parseInt(arr[1].trim()),
        b = parseInt(arr[2].replace(')','').trim());
    var gray = Math.ceil((r+g+b)/3);
    return gray;
  }
}


function jsSelects() {
    $('select.enrollment-select').before('<span class="select-outline"><div class="select-text"><span class="stext-inner"></span></div><div class="sub-select"></div></span>').hide();
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
    $('.select-text').live('mouseenter mouseleave',function(){
        $(this).parent().toggleClass('select-hover')
    }).live('click',function(){
        var par = $(this).parent();
        $('.select-active').removeClass('current');
        if (!par.hasClass('select-active'))
            par.addClass('current');
        par.find('.sub-select').toggle();
        par.toggleClass('select-active');
        return false;
    });
    $('.sub-option').live('click',function(){
        var pars = $(this).parents('.select-outline');

        var id_suffix = pars.next('select.enrollment-select').attr('id');
        var selected_id = $(this).attr('id');
        var selected_value = str_replace(id_suffix+"_", "", selected_id);

        var s_val = '';
        pars.next('select.enrollment-select').find('option').attr('selected','').each(function(){
            s_val = create_select_val($(this).val());
            if (s_val == selected_value) {
                $(this).attr('selected','selected');
            }
        });


        pars.find('.active-sub-option').removeClass('active-sub-option');
        $(this).addClass('active-sub-option');
        pars.find('.select-text>span').text($(this).text());

        pars.next('select.enrollment-select').change();
        pars.find('.select-text>span').width('auto');
        Cufon.refresh();
    });
    //$('.sub-option, .select-text span').addClass('gothic');
    Cufon.refresh();
    $(document).click(function(e){
        if (e.target.className != 'sub-optgroup') {
            if ((e.target.className != 'select-text')&&(e.target.className != 'stext-inner')) {
                $('.sub-select').hide();
                $('.select-outline').removeClass('select-active');
            } else {
                var index = $('.select-outline').index($(e.target).parents('.select-outline'));
                $('.select-outline').each(function(i){
                    if (i != index) {
                        $(this).removeClass('select-active').find('.sub-select').hide();
                    }
                });
            }
        }
    });
}

function addSuboption(elem) {
    var id = elem.next('select.enrollment-select').attr('id');
    var val = '';
    elem.next('.hiddenSelect').find('option, optgroup').each(function(){
        if (this.localName == 'optgroup') {
            elem.find('.sub-select').append('<div class="sub-optgroup">'+$(this).attr('label')+'</div>');
        } else {
            val = $(this).val();
            val = create_select_val(val)
            elem.find('.sub-select').append('<div class="sub-option" id="'+id+'_'+val+'">'+$(this).text()+'</div>');
            val = '';
        }
        elem.change(function(){
            $(this).next('.hiddenSelect').change();
        });
    });
}


function create_select_val(val){
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
