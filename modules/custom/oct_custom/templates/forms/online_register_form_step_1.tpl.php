<div class="dot-line"></div>
<div class="register-form-row">
  <?php print drupal_render($form['online_registration_adult_qty']); ?><div class="form-symbols">=$</div>
  <?php print drupal_render($form['online_registration_total_adult_cost']); ?>
  <div class="clear-both"></div>
</div>
<div class="register-form-row">
  <?php print drupal_render($form['online_registration_children_qty_children_dinner']); ?><div class="form-symbols">=$</div>
  <?php print drupal_render($form['online_registration_total_child_cost_children_dinner']); ?>
  <div class="clear-both"></div>
</div>
<div class="label-description"><?php print t("Attending children's dinner"); ?></div>
<div class="form-help-text"><?php print t('And/Or');?></div>
<div class="register-form-row">
  <?php print drupal_render($form['online_registration_children_qty_adult_dinner']); ?><div class="form-symbols">=$</div>
  <?php print drupal_render($form['online_registration_total_child_cost_adult_dinner']); ?>
  <div class="clear-both"></div>
</div>
<div class="label-description"><?php print t("Attending adult's dinner"); ?></div>

<div class="register-form-row">
  <?php print drupal_render($form['online_registration_tweenball']); ?><div class="form-symbols">=$</div>
  <?php print drupal_render($form['online_registration_total_tweenball_cost']); ?>
    <div class="clear-both"></div>
</div>
<div class="label-description"><?php print t("Attending Tween Ball"); ?></div>

<div class="form-help-text"><?php print t('Optional');?></div>
<div class="register-form-row">
  <?php print drupal_render($form['online_registration_sitters_qty_children_dinner']); ?><div class="form-symbols">=$</div>
  <?php print drupal_render($form['online_registration_total_sitters_cost_children_dinner']); ?>
  <div class="clear-both"></div>
</div>
<div class="label-description"><?php print t("Attending children’s dinner"); ?></div>
<div class="register-form-row">
  <?php print drupal_render($form['online_registration_sitters_qty_adult_dinner']); ?><div class="form-symbols">=$</div>
  <?php print drupal_render($form['online_registration_total_sitters_cost_adult_dinner']); ?>
  <div class="clear-both"></div>
</div>
<div class="label-description"><?php print t("Attending adult’s dinner"); ?></div>

<div class="register-form-row">
  <?php print drupal_render($form['online_registration_coins']); ?><div class="form-symbols">=$</div>
  <?php print drupal_render($form['online_registration_total_coins_cost']); ?>
  <div class="clear-both"></div>
</div>
<div class="label-description"><?php print t("See details below"); ?></div>

<div class="solid-line"></div>
<div class="register-form-row total-form-right">
  <div class="form-symbols">$</div>
  <?php print drupal_render($form['online_registration_total_cost']); ?>
  <div class="clear-both"></div>
</div>
<div class="register-form-row  total-form-right">
  <div class="form-symbols">$</div>
  <?php print drupal_render($form['online_registration_handling_fee']); ?>
  <div class="clear-both"></div>
</div>
<div class="register-form-row  total-form-right">
  <div class="form-symbols">$</div>
  <?php print drupal_render($form['online_registration_total_attendee_cost']); ?>
  <div class="clear-both"></div>
</div>

<div class="dot-line"></div>
  <div class="form-text">
    <?php print $form['#extra_arg']['online_coins_descr']; ?>
  </div>
<div class="dot-line"></div>

<?php print theme('stretch_title', $form['#extra_arg']['sub_title']); ?>
<div class="form-subtitle-text"><?php print $form['#extra_arg']['sub_title_description']; ?></div>

<?php $sponsorship_list = views_get_view_result('sponsorship_list'); ?>

<?php //custom view theming for form ?>
<?php if (!empty($sponsorship_list) && (is_array($sponsorship_list))): ?>

  <?php if (user_access('create sponsorship content')): ?>
    <?php print theme('manager_custom_links', array(
        0 => array('path' => 'node/add/sponsorship', 'title' => 'Add'),
        1 => array('path' => 'admin/content/nodequeue/' . SPONSORSHIP_ITEMS_QID . '/view', 'title' => 'Order')
      ),'add-order-auction-tab');?>
  <?php endif; ?>

  <?php $now_nid = null; ?>
  <?php $i = 0; ?>
  <?php foreach ($sponsorship_list as $key => $val): ?>
    <?php if ($now_nid != $val->nid): ?>
      <?php $now_nid = $val->nid; ?>

        <div class="register-form-row">
          <?php if (user_access('edit any sponsors content')): ?>
            <?php print theme('manager_links', $now_nid, 'edit-staff-tab');?>
          <?php endif; ?>
          <?php if ( !empty($form['online_registration_checkbox_'.$i]) && is_array($form['online_registration_checkbox_'.$i]) && ($now_nid == $form['online_registration_checkbox_'.$i]['#nid'] ) ): ?>
            <?php print drupal_render($form['online_registration_checkbox_'.$i]); ?>
          <?php endif; ?>
          <div class="clear-both"></div>
          <div class="form-text">
            <?php if ( !empty($val->node_data_field_sponsorship_list_field_sponsorship_list_value)): ?>
              <ul class="description-list">
                <?php foreach ($sponsorship_list as $key_list => $val_list): ?>
                  <?php if ($val_list->nid == $now_nid): ?>
                    <li><?php print $val_list->node_data_field_sponsorship_list_field_sponsorship_list_value; ?></li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </div>
        <div class="dot-line"></div>

      <? $i++ ?>
    <?php endif; ?>
  <?php endforeach; ?>
<?php endif; ?>

<?php print drupal_render($form); ?>
<div class="clear-both"></div>