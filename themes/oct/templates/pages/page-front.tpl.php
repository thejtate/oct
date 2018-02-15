<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">

  <head>
    <?php print $head; ?>
    <title><?php print $head_title; ?></title>
    <?php print $styles; ?>
    <?php print $scripts; ?>
    <!--[if IE]>
       <link rel="stylesheet" href="<?php print base_path() . path_to_theme(); ?>/win-ie-all.css" />
    <![endif]-->
  </head>
  <body class="body">
    <?php if (isset($backstage)): ?>
    <div class="button-go-page"><?php print $backstage; ?></div>
    <?php endif; ?>
  <div id="page" class="home-page">
    <div id="page-inner">

      <div id="header">
        <div id="header-inner">
          <img src="<?php print base_path() . path_to_theme(); ?>/images/top-img1.png" alt="" />
          <div id="logo"><a href="<?php print base_path();?>"><img src="<?php print base_path() . path_to_theme(); ?>/images/logo.png" alt="Oklahoma Children's Theatre" id="logo-image" /></a></div>
        </div>
        <?php if (user_is_logged_in ()): ?>
          <?php print $logout_buttons; ?>
        <?php endif; ?>
        <?php if (user_access('manager access')): ?>
          <?php print $manager_buttons; ?>
        <?php endif; ?>
      </div>
      <div id="nav">
        <?php print $oct_primary_links; ?>
      </div>
      <div id="main">
        <div id="main-inner" class="clr">
          <div id="content">
            <?php if ($tabs): ?><div class="tabs"><?php print $tabs; ?></div><?php endif; ?>
            <?php print $messages; ?>
            <?php print $help; ?>
            <?php print $content; ?>
          </div>
          <div id="sidebar">
            <div id="sidebar-inner">
                <?php print $right; ?>
                <?php print $sponsors; ?>
            </div>
          </div>
        </div>
      </div>


      <div id="footer">
        <div id="footer-inner">
	  <div class="footer-left"><span><?php print $custom_mission;?></span></div>
          <div id="footer-message">
            <div class="contact-info">
              <?php print $footer_message;?>
            </div>
          </div>
					<div class="footer-nav">
						<ul>
							<li><a href="/sitemap"><?php print t('Site Map');?></a></li>
              <?php if(!$logged_in): ?>
							<li><span>|</span><a href="/user"><?php print t('Log In');?></a></li>
              <?php endif ?>
						</ul>
					</div>
        </div>
      </div>

    </div>
  </div>
    <?php print $closure; ?>
</body>
</html>
