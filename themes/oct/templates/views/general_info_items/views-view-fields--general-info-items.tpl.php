<?php
// $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<?php if (user_access('manager access')): ?>
  <?php print theme('manager_links', $fields['nid']->content, 'edit-gen-info-item'); ?>
<?php endif; ?>
<?php if( $fields['field_general_info_image_fid']->content): ?>
  <div class="gen-info-image">
    <?php print $fields['field_general_info_image_fid']->content; ?>
  </div>
<?php endif; ?>
<div class="gen-info-text">
  <?php print $fields['body']->content; ?>
</div>
<div class="clear-both"></div>

