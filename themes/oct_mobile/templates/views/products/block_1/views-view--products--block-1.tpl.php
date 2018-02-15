<?php if (user_access('manager access')): ?>
  <?php// print theme('manager_custom_links', array(0 => array('path' => 'node/add/product', 'title' => 'Add')), 'add-product-tab');?>
<?php endif; ?>

<?php if ($rows): ?>
  <?php print $rows; ?>
<?php elseif ($empty): ?>
  <?php print $empty; ?>
<?php endif; ?>

<?php if ($pager): ?>
  <?php print $pager; ?>
<?php endif; ?>
