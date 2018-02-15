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
<?php //kpr($fields);die('END!'); ?>
<?php if(in_array($fields['tid']->raw, array(1,2,3))): ?>
  <div class="b-article clr">
    <?php if (user_access('manager access')): ?>
      <?php print theme('manager_links', $fields['nid']->content, 'edit-home-item'); ?>
    <?php endif; ?>
    <?php if(!empty($fields['field_product_image_fid']->content)): ?>
      <div class="b-img"><?php print l($fields['field_product_image_fid']->content, 'enrollment/'.$fields['nid']->raw, array('html'=> true));?></div>
    <?php endif; ?>
    <div class="b-info">
      <?php if($fields['tid']->raw == '1'): ?>
        <h2><?php print l($fields['title']->raw, 'tickets/'.$fields['nid']->raw, array('html' => true));?></h2>
      <?php else: ?>
        <h2><?php print l($fields['title']->raw, 'enrollment/'.$fields['nid']->raw, array('html' => true));?></h2>
      <?php endif;?>
      <?php print $fields['body']->content; ?>
      <div class="b-buts-panel">
        <?php if($fields['tid']->raw == '1'): ?>
          <?php print l("", 'tickets/'.$fields['nid']->raw, array('attributes'=> array('class' => 'tickets')));?>
          <?php if( $fields['tid_1']->content == 'Theatre' ): ?>
            <?php print l("", PRODUCT_THEATRE_PAGE, array('attributes'=> array('class' => 'info'), 'fragment' => 'product-'.$fields['nid']->raw));?>
          <?php elseif( $fields['tid_1']->content == 'Touring' ): ?>
            <?php print l("", PRODUCT_TOURING_PAGE, array('attributes'=> array('class' => 'info'), 'fragment' => 'product-'.$fields['nid']->raw));?>
          <?php else: ?>
            <?php print l("", PRODUCT_THEATRE_PAGE, array('attributes'=> array('class' => 'info'), 'fragment' => 'product-'.$fields['nid']->raw));?>
          <?php endif; ?>
        <?php elseif($fields['tid']->raw == '2'):  ?>
          <?php print l("", 'enrollment/'.$fields['nid']->raw, array('attributes'=> array('class' => 'enroll')));?>
          <?php print l("", CLASSES_PAGE, array('attributes'=> array('class' => 'info'), 'fragment' => 'class-'.$fields['nid']->raw));?>
        <?php elseif($fields['tid']->raw == '3'):  ?>
          <?php print l("", 'enrollment/'.$fields['nid']->raw, array('attributes'=> array('class' => 'enroll')));?>
          <?php print l("", CAMPS_PAGE, array('attributes'=> array('class' => 'info'), 'fragment' => 'camp-'.$fields['nid']->raw));?>
        <?php endif;?>
        </div>
    </div>
  </div>
<?php elseif( ($fields['type']->raw == 'fun_night_event') || ($fields['type']->raw == 'homepage_post') ): ?>
  <div class="b-article clr">
    <?php if (user_access('manager access')): ?>
      <?php print theme('manager_links', $fields['nid']->content, 'edit-home-item'); ?>
    <?php endif; ?>
    <?php if ($fields['type']->raw == 'fun_night_event'): ?>
      <?php if(!empty($fields['field_fun_night_image_fid']->content)): ?>
        <div class="b-img"><?php print $fields['field_fun_night_image_fid']->content ;?></div>
      <?php endif; ?>
    <?php elseif ($fields['type']->raw == 'homepage_post'): ?>
      <?php if(!empty($fields['field_homepage_post_image_fid']->content)): ?>
        <div class="b-img"><?php print $fields['field_homepage_post_image_fid']->content ;?></div>
      <?php endif; ?>
    <?php endif; ?>
    <div class="b-info">
      <?php if ($fields['type']->raw == 'fun_night_event'): ?>
        <h2><?php print l($fields['title']->content, 'node/'.$fields['nid']->content); ?></h2>
      <?php elseif ($fields['type']->raw == 'homepage_post'): ?>
        <h2><?php print $fields['title']->content ?></h2>
      <?php endif; ?>
      <?php if ($fields['type']->raw == 'fun_night_event'): ?>
        <?php print $fields['field_fun_night_teaser_value']->content; ?>
      <?php elseif ($fields['type']->raw == 'homepage_post'): ?>
        <?php print $fields['body']->content; ?>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>