<?php
$weekdays = array();
  if ($fields['field_product_wd_sunday_value']->content){ $weekdays[] = 'Sunday'; }
  if ($fields['field_product_wd_monday_value']->content){ $weekdays[] = 'Monday'; }
  if ($fields['field_product_wd_tuesday_value']->content){ $weekdays[] = 'Tuesday'; }
  if ($fields['field_product_wd_wednesday_value']->content){ $weekdays[] = 'Wednesday'; }
  if ($fields['field_product_wd_thursday_value']->content){ $weekdays[] = 'Thursday'; }
  if ($fields['field_product_wd_friday_value']->content){ $weekdays[] = 'Friday'; }
  if ($fields['field_product_wd_saturday_value']->content){ $weekdays[] = 'Saturday'; }

  $weekdays = implode(', ', $weekdays);
?>


<div class="b-article clr">
  <?php if (user_access('manager access')): ?>
    <?php print theme('manager_links', $fields['nid']->content, 'edit-products'); ?>
  <?php endif; ?>
  
  <div class="b-info">
    <div class="b-buts-panel"><?php print l('', 'enrollment/'.$fields['nid']->raw, array('attributes'=> array('class' => 'enroll'))); ?></div>
    <h2><?php print l($fields['title']->raw, 'enrollment/'.$fields['nid']->raw, array('html' => true)); ?></h2>
    <p>
      <b><?php print $weekdays;?><br>
      <?php print $fields['field_class_date_value']->content;?> - <?php print $fields['field_class_date_value2']->content;?> <br>
        <?php print $fields['field_min_class_age_value']->raw;?> <?php print t('years old and up'); ?> &bull; $<?php print $fields['field_class_price_value']->raw;?></b>
    </p>
    <?php print $fields['body']->content; ?>
  </div>
</div>