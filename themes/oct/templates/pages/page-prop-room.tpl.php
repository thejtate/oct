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
       <link rel="stylesheet" href="<?php print base_path() . path_to_theme(); ?>/win-ie-all.css" />
    <![endif]-->
  </head>
  <body>
    <div class="header">
      <div class="decor-title">
        <div class="decor-title-images">
    <!--      <img src="images/img/title-header-decor-md.png" alt="title">-->
        </div>
      </div>
      <div class="title-header">
        <img src="<?php print base_path() . path_to_theme(); ?>/images/img/title-header.png" alt="logo">
      </div>
    </div>

    <div class="outer-wrapper">
      <div class="main">
        <div class="main-content">
          <div class="logout-wrapp">

            <p><?php print t('Welcome back') . ' ' . l($user->name, "user/" . $user->uid, array('attributes' => array('class' => 'name-user'))); ?></p>
            <?php print l("LOG OUT", "logout", array('attributes' => array('class' => 'logout-button'))); ?>
          </div>
          <?php if (user_access('manager access')): ?>
            <?php print theme('manager_custom_links', array(0 => array('path' => 'node/add/prop-room-res', 'title' => 'Add')), 'add-person-tab');?>
          <?php endif; ?>
          <div class="backtrage-message">
            <?php print $messages; ?>
            <?php if ($tabs): ?><div class="tabs"><?php print $tabs; ?></div><?php endif; ?>
            <?php print $help; ?>
          </div>
          <?php print (isset($add_message_form)) ? $add_message_form : ''; ?>
          <div class="item-name-wrapp">
            <div class="title-images-wrapp">
              <span class="title-images">
                <img src="<?php print base_path() . path_to_theme(); ?>/images/img/title-p.png" alt="img" />
              </span>
            </div>
            <?php print $content; ?>
          </div>
        </div>
        <div class="sidebar">
          <?php print $right; ?>
        </div>
      </div>
    </div>
    <?php print $closure; ?>
  </body>
</html>
