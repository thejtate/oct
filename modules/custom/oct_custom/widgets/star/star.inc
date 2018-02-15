<?php
/**
 * @file
 *   Thumbs widget.
 */

/**
 * Implementation of hook_vud_widgets(). (Specialized)
 */
function oct_custom_star_vud_widgets() {
  return array(
    'title' => t('Star'),
    'widget template' => 'widget',
    'alter template variables' => 'oct_custom_widget_star_alter_template_vars',
    'js' => 'star.js',
  );
}

function oct_custom_widget_star_alter_template_vars($template_type, &$variables) {
  $criteria['content_id'] = $variables['content_id'];
  $criteria['content_type'] = $variables['type'];
  $criteria['value_type'] = 'points';
  $criteria['tag'] = $variables['tag'];
  $criteria['function']  = 'sum';
  $vote_sum = votingapi_select_single_result_value($criteria);
  $variables['vote_sum'] = ($vote_sum) ? $vote_sum : 0;
}
