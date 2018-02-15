<?php
// $Id: views-view-unformatted.tpl.php,v 1.6 2008/10/01 20:52:11 merlinofchaos Exp $
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<h2><?php print t('O.C.U. Student Interns &amp; Work Study'); ?></h2>
<?php if (user_access('manager access')): ?>
  <?php print theme('manager_custom_links', array(1 => array('path' => 'admin/content/nodequeue/' . STAFF_BOTTOM_QID . '/view', 'title' => 'Order')), 'add-person-tab');?>
<?php endif; ?>
<dl class="clr last">
<?php foreach ($rows as $id => $row): ?>
    <?php print $row; ?>
<?php endforeach; ?>
</dl>
