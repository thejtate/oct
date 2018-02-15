<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">

  <head>
    <?php print $head; ?>
    <title><?php print $head_title; ?></title>
    <?php print $styles; ?>
    <?php print $scripts; ?>
    <!--[if (lt IE 8) & (!IEMobile)]>
      <link rel="stylesheet" href="<?php print base_path() . path_to_theme(); ?>/screen-ie7.css" />
    <![endif]-->
    <!--[if IE]>
       <link rel="stylesheet" href="<?php print base_path() . path_to_theme(); ?>/css/win-ie-all.css" />
    <![endif]-->
  </head>
  <body class="body">
  <div class="outer-wrapper-login">
  <div class="main">

    <div class="login-form-wrapper">
      <div class="for-wrapp">
        <?php print $messages; ?>
        <?php print $content; ?>
        <div class="block-reg">
          <span class="reg-label">
            <?php print t("New here?");?>
          </span>
          <span class="reg-title">
            <?php print t("Register");?>
          </span>
          <?php print l(t("Go!"), 'user/register', array('attributes' => array('class' => 'button-go')));?>
        </div>
      </div>

    </div>
    <div class="decor-login-line">

    </div>
  </div>
</div>
    <?php print $closure; ?>
</body>
</html>
