<?php
// $Id: views-view-unformatted.tpl.php,v 1.6 2008/10/01 20:52:11 merlinofchaos Exp $
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<?php if (user_access('manager access')): ?>
  <?php// print theme('manager_custom_links', array(1 => array('path' => 'admin/content/nodequeue/' . BOARD_OF_DIRECTORS_TOP_QID . '/view', 'title' => 'Order')), 'add-person-tab');?>
<?php endif; ?>
<dl class="clr">
  <?php foreach ($rows as $id => $row): ?>
    <?php print $row; ?>
  <?php endforeach; ?>
</dl>


