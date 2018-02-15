<?php
// $Id: views-view-unformatted.tpl.php,v 1.6 2008/10/01 20:52:11 merlinofchaos Exp $
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<h1><span><?php print t('Artists'); ?></span></h1>
<div id="content-inner">
  <div id="content-bot">
    <div id="content-area">
      <?php if (user_access('manager access')): ?>
        <?php print theme('manager_custom_links', 
                array(0 => array('path' => 'node/add/artists', 'title' => 'Add'),
                      1 => array('path' => 'admin/content/nodequeue/' . ARTIST_QID . '/view', 'title' => 'Order')),
                'add-artist-tab');?>
      <?php endif; ?>
      <?php foreach ($rows as $id => $row): ?>
        <div class="b-article clr <?php if($id == 0){print 'first-artist';}  ?>">
          <?php print $row; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

