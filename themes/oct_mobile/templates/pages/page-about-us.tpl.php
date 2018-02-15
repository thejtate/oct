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
    <div class="header" id="header">
      <div class="header-logo">
        <?php print theme('image', drupal_get_path('theme', 'oct_mobile').'/images/logo_OKT.png', 'Oklahoma Children Theatre', '', array('class' => 'logo_OKT')); ?>
      </div>
      <div class="header-title">
        <?php// print $header_mobile; ?>
        <?php print $back_link; ?>
        <h2><?php print $page_title; ?></h2>
        <?php print l('home', '<front>'); ?>
      </div><!--header-title-->
      <hr />
    </div>
    <!--header-->

    <div class="middle <?php print $page_class; ?>" id="middle">
      <?php if (!empty($tabs)): print $tabs; endif; ?>
      <?php if (!empty($messages)): print $messages; endif; ?>
      <?php //if ($title): print '<h2'. ($tabs ? ' class="with-tabs"' : '') .'>'. $title .'</h2>'; endif; ?>
      <div class="middle-content">
        <?php print $mobile_about_us_menu; ?>
        <?php print $content; ?>
      </div>
    </div>

    <?php print $closure; ?>

  </body>
</html>