<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head; ?>
    <title><?php print $head_title; ?></title>
    <?php print $styles; ?>
    <?php print $scripts; ?>
    <meta name="viewport" content="width=320, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
  </head>
  <body class="<?php print $classes; ?>">
    <?php if(!empty($sponsor)): ?>
      <?php print $sponsor; ?>
    <?php endif; ?>
    <!-- header -->
    <div class="wrapper">
      <div class="header" id="header">
        <div class="header-logo">
          <?php print $header_mobile; ?>
          <?php print theme('image', drupal_get_path('theme', 'oct_mobile').'/images/logo_OKT.png', 'Oklahoma Children Theatre', '', array('class' => 'logo_OKT')); ?>
        </div>
        <hr />
      </div><!--header-->
      <div class="middle" id="middle">
        <?php if (!empty($messages)): print $messages; endif; ?>
        <?php //if ($title): print '<h2'. ($tabs ? ' class="with-tabs"' : '') .'>'. $title .'</h2>'; endif; ?>
        <?php print $content_mobile;?>
        <div class="block-buttons">
          <?php print $mobile_menu; ?>
        </div><!--block-buttons-->
      </div><!--middle-->
    </div><!--wrapper-->
    <div class="footer">
      <?php print $footer_mobile; ?>
      <div id="slider">
      <?php print $sponsors_slider; ?>
      </div>
    </div>
    <?php print $closure; ?>
  </body>
</html>
