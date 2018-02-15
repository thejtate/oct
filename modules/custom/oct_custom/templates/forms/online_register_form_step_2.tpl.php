<?php $buttons = drupal_render($form['online_registration_form_back_to_step_1']); ?>
<?php $buttons .= drupal_render($form['online_registration_form_submit']); ?>
<div class="dot-line"></div>
<?php print drupal_render($form); ?>
<div id="form-control">
  <?php print $buttons; ?>
</div>
<div class="clear-both"></div>
