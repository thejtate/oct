<?php

/**
 * @file
 * Customize the display of a webform submission.
 *
 * Available variables:
 * - $node: The node object for this webform.
 * - $submission: The Webform submission array.
 * - $email: If sending this submission in an e-mail, the e-mail configuration
 *   options.
 * - $format: The format of the submission being printed, either "html" or
 *   "text".
 * - $renderable: The renderable submission array, used to print out individual
 *   parts of the submission, just like a $form array.
 */ 
?>

<?php print drupal_render($renderable); ?>

<?php if (is_array($pay_info['register_online_data'])) : ?>
<div class="pay-info">
  <h1><?php print t('Online Register Info');?></h1>
  
   <div class="row">
    <div class="pay-name form-item center">
      <label>
        <?php print t('Product Name'); ?>
      </label>
    </div>
    <div class="pay-num center">
      <?php print t('Num.'); ?>
    </div>
    <div class="pay-amount center">
      <?php print t('$'); ?>
    </div>
  </div>
  
   <div class="row">
    <div class="pay-name form-item">
      <label>
        <?php print t('Adults x $150 each'); ?>
      </label>
    </div>
    <div class="pay-num">
      <?php print $pay_info['register_online_data']['adult_qty'] ; ?>
    </div>
    <div class="pay-amount">
      <?php print number_format($pay_info['register_online_data']['total_adult_cost'], 2, '.', ' '); ?>
    </div>
  </div>
  
  <div class="row">
    <div class="pay-name form-item">
      <label>
        <?php print t('Children x $50 each'); ?>
      </label>
    </div>
    <div class="pay-num">
      <?php print $pay_info['register_online_data']['children_qty_children_dinner'] ; ?>
    </div>
    <div class="pay-amount">
      <?php print number_format($pay_info['register_online_data']['total_child_cost_children_dinner'], 2, '.', ' '); ?>
    </div>
  </div>
  
  <div class="row">
    <div class="pay-name form-item">
      <label>
        <?php print t('Children x $125 each'); ?>
      </label>
    </div>
    <div class="pay-num">
      <?php print $pay_info['register_online_data']['children_qty_adult_dinner']; ?>
    </div>
    <div class="pay-amount">
      <?php print number_format($pay_info['register_online_data']['total_child_cost_adult_dinner'], 2, '.', ' '); ?>
    </div>
  </div>
  
  <div class="row">
    <div class="pay-name form-item">
      <label>
        <?php print t('Tween Ball x $75'); ?>
      </label>
    </div>
    <div class="pay-num">
      <?php print $pay_info['register_online_data']['tween_ball_count']; ?>
    </div>
    <div class="pay-amount">
      <?php print number_format($pay_info['register_online_data']['tween_ball_price'], 2, '.', ' '); ?>
    </div>
  </div>
  
  <div class="row">
    <div class="pay-name form-item">
      <label>
        <?php print t('Sitters x $0'); ?>
      </label>
    </div>
    <div class="pay-num">
      <?php print $pay_info['register_online_data']['sitters_qty_children_dinner']; ?>
    </div>
    <div class="pay-amount">
      <?php print number_format($pay_info['register_online_data']['total_sitters_cost_children_dinner'], 2, '.', ' '); ?>
    </div>
  </div>
  
  <div class="row">
    <div class="pay-name form-item">
      <label>
        <?php print t('Sitters x $125'); ?>
      </label>
    </div>
    <div class="pay-num">
      <?php print $pay_info['register_online_data']['sitters_qty_adult_dinner']; ?>
    </div>
    <div class="pay-amount">
      <?php print number_format($pay_info['register_online_data']['total_sitters_cost_adult_dinner'], 2, '.', ' '); ?>
    </div>
  </div>
  
  <div class="row">
    <div class="pay-name form-item">
    <label><?php print t('Coins'); ?></label>
    </div>
    <div class="pay-num">
      &nbsp
    </div>
    <div class="pay-amount">
      <?php print number_format($pay_info['register_online_data']['coins_price'], 2, '.', ' '); ?>
    </div>
  </div>
    
  <?php if (is_array($pay_info['register_online_checkboxes']) || $pay_info['register_online_data']['donate_amount']) : ?>
  <h1><?php print t('Sponsorship');?></h1>
  <div class="row row-online-checkboxes">
      <div class="pay-name form-item center">
        <label><?php print t('Product Name'); ?></label>
      </div>
      <div class="pay-amount">
        <?php print '$'; ?>
      </div>
    </div>
  <?php if (is_array($pay_info['register_online_checkboxes'])) : ?>
    <?php    foreach ($pay_info['register_online_checkboxes'] as $value) : ?>
      <div class="row row-online-checkboxes">
        <div class="pay-name form-item">
          <label><?php print $value['checkbox_name']; ?></label>
        </div>
        <div class="pay-amount">
          <?php print number_format($value['checkbox_amount'], 2, '.', ' '); ?>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
  <div class="row row-online-checkboxes">
      <div class="pay-name form-item">
        <label><?php print t('Donate'); ?></label>
      </div>
      <div class="pay-amount">
        <?php print number_format($pay_info['register_online_data']['donate_amount'], 2, '.', ' '); ?>
      </div>
    </div>
  <?php endif; ?>
  
  <div class="pay-info-total">
    <div class="row">
      <div class="pay-name form-item">
        <label><?php print t('Total'); ?></label>
      </div>
      <div class="pay-amount">
        <?php print number_format($pay_info['register_online_data']['total_cost'], 2, '.', ' '); ?>
      </div>
    </div>
    <div class="row">
      <div class="pay-name form-item">
        <label><?php print t('Handling Fee'); ?></label>
      </div>
      <div class="pay-amount">
        <?php print number_format($pay_info['register_online_data']['handling_fee'], 2, '.', ' '); ?>
      </div>
    </div>
    <div class="row">
      <div class="pay-name form-item">
        <label><?php print t('Total attendee cost'); ?></label>
      </div>
      <div class="pay-amount">
        <?php print number_format($pay_info['register_online_data']['total_attendee_cost'], 2, '.', ' '); ?>
      </div>
    </div>
    <div class="row">
      <div class="pay-name form-item">
        <label><?php print t('Transaction Status:'); ?></label>
      </div>
      <div class="pay-amount form-item">
        <label><?php print $pay_info['pay_activity'][(count($pay_info['pay_activity'])-1)]['action']; ?></label>
      </div>
    </div>
  </div>
  
</div>
<?php endif; ?>