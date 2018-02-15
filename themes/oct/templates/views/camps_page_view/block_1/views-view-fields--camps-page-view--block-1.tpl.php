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
  <div class="b-info">
    <?php if (user_access('manager access')): ?>
      <?php print theme('manager_links', $fields['nid']->content, 'edit-products'); ?>
    <?php endif; ?>
    <div class="b-buts-panel"><a class="enroll" href="/enrollment/<?php print $fields['nid']->content ?>"></a></div>
      <h2><?php print l($fields['title']->raw, "enrollment/".$fields['nid']->content); ?></h2>
      <?php if ((!empty($fields['field_min_class_age_value']->content)) && (!empty($fields['field_max_class_age_value']->content))): ?>
        <p><b><?php print t('Ages') . ' : '. $fields['field_min_class_age_value']->content . ' - ' . $fields['field_max_class_age_value']->content; ?></b></p>
      <?php endif; ?>
      <?php if(!empty($fields['field_class_production_value']->content)): ?>
         <p><b><?php print t('Production') . ' : "' . $fields['field_class_production_value']->content . '"'; ?></b></p>
      <?php endif; ?>
 
      <p><b><?php print t('Class Dates') . ' : '; ?></b></p>
      <?php foreach($fields['date_from'] as $key => $val): ?>
        <p><b>
          <?php print date('F jS', strtotime($fields['date_from'][$key])); ?>
          <?php if(!empty($fields['date_to'][$key])): ?>
          - <?php print date('F jS', strtotime($fields['date_to'][$key]));?>
          <?php endif; ?>
        </b></p>
      <?php endforeach;?>
      
      <?php if(!empty($fields['field_class_no_dates_value']->content)): ?>
        <p><?php print t('( There will be no class '); ?>
          <?php foreach( $fields['no_date'] as $key => $val): ?>
            <?php print $val; ?>
            <?php if(!empty($fields['no_date'][$key+1])): ?>
              &
            <?php endif;?>
          <?php endforeach; ?>
        <?php print ' ) '; ?></p>
      <?php endif; ?>

      <p><b><?php print t('Class Time') . ' : '; ?></b></p>
      <?php foreach($fields['time_from'] as $key => $val): ?>
        <p><b>
          <?php print $fields['time_from'][$key]; ?>
          <?php if(!empty($fields['time_to'][$key])): ?>
          - <?php print $fields['time_to'][$key]; ?>
          <?php endif; ?>
        </b></p>
      <?php endforeach;?>

      <?php if(!empty($fields['field_class_final_perfomance_value']->content)): ?>
         <p><b><?php print t('Final Perfomance Date') . ' : '; ?>
        <?php if(!empty($fields['field_class_final_perfomance_value']->content)):?>
          <?php print  $fields['field_class_final_perfomance_value']->content; ?>
        <?php endif;?>
        <?php if(!empty($fields['field_class_final_perfomance_value2']->content)):?>
          <?php print ' - '.$fields['field_class_final_perfomance_value2']->content; ?>
        <?php endif;?>

        <?php if(!empty($fields['field_class_final_perfomance_value_1']->content)):?>
          <?php print ' at ' . $fields['field_class_final_perfomance_value_1']->content; ?>
        <?php endif;?>
        <?php if(!empty($fields['field_class_final_perfomance_value2_1']->content)):?>
          <?php print ' - ' . $fields['field_class_final_perfomance_value2_1']->content; ?>
        <?php endif;?>
        </b></p>
      <?php endif;?>

      <?php if(!empty($fields['field_class_price_value']->content)): ?>
         <p><b><?php print t('Tuition') . ' : $' . $fields['field_class_price_value']->content; ?></b></p>
      <?php endif; ?>
  </div>



