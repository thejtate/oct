<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">

  <head>
    <?php print $head; ?>
    <title><?php print $head_title; ?></title>
    <?php print $styles; ?>
    <?php print $scripts; ?>
    <!--[if lte IE 7]>
      <script src="<?php print base_path() . path_to_theme(); ?>/js/lib/jquery.pseudo.min.js"></script>
    <![endif]-->

    <!--[if lte IE 7]>
      <script src="<?php print base_path() . path_to_theme(); ?>/js/ie-lte8.js"></script>
    <![endif]-->

    <!--[if (lt IE 8) & (!IEMobile)]>
      <link rel="stylesheet" href="<?php print base_path() . path_to_theme(); ?>/screen-ie7.css" />
    <![endif]-->
    <!--[if IE]>
       <link rel="stylesheet" href="<?php print base_path() . path_to_theme(); ?>/css/win-ie-all.css" />
    <![endif]-->
  </head>
  <body>
    <div class="outer-wrapper">
      <div class="main form-register-outer">
        <div class="form-register-wrapper">
          <div class="title-form">
            <?php print t('Oklahoma Children’s Theatre'); ?>
          </div>
          <div class="register-wrapper">
            <?php print $messages; ?>
            <?php print $content; ?>
          </div>
        </div>
      </div>
    </div>


    <?php print $closure; ?>
  </body>
</html>
