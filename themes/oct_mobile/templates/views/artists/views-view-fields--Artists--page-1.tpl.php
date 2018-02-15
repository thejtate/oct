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
  <?php// print theme('manager_links', $fields['nid']->content, 'edit-artist-tab');?>
<?php endif; ?>
<div class="b-img">
  <?php print $fields['field_artists_photo_fid']->content; ?>
</div>
<div class="b-info">
  <h2><?php print $fields['title']->content; ?></h2>

  <?php if ($fields['field_artists_fun_thing_value']->content): ?>
    <p><b><?php print t('FAVORITE FOOD IS'); ?>&hellip;</b></p>
    <p><?php print $fields['field_artists_favorite_food_value']->content; ?></p>
  <?php endif; ?>

  <?php if ($fields['field_artists_fun_thing_value']->content): ?>
    <p><b><?php print t('FAVORITE MOVIE IS'); ?>&hellip;</b></p>
    <p><?php print $fields['field_artists_favorite_movie_value']->content; ?></p>
  <?php endif; ?>

  <?php if ($fields['field_artists_fun_thing_value']->content): ?>
    <p><b><?php print t('THE MOST FUN THING I HAVE EVER DONE'); ?>&hellip;</b></p>
    <p><?php print $fields['field_artists_fun_thing_value']->content; ?></p>
  <?php endif; ?>

  <?php if ($fields['field_artists_q_value']->content && $fields['field_artists_a_value']->content): ?>
    <p><b><?php print $fields['field_artists_q_value']->content; ?></b></p>
    <p><?php print $fields['field_artists_a_value']->content; ?></p>
  <?php endif; ?>
</div>