<?php

class webform_pay extends pay_form {
  var $min_amount = NULL;
  var $max_amount = NULL;
  var $embeddable = FALSE;

  /**
   * Override of pay_form::form().
   */
  function form(&$form, &$form_state) {
    // Call form_setup because we won't be calling parent::form.
    $this->form_setup($form, $form_state);
    $this->pay_method_form($form, $form_state);

    // Ensure there is a "total" field, but populate it on the validate hook.
    $group = $this->handler();
    $form[$group]['total'] = array(
      '#type' => 'textfield',
      '#access' => FALSE,
    );
  }

  /**
   * Override of pay_form::form_alter().
   *
   * Prevent the normal form_altering behavior, which we don't need at all.
   */
  function form_alter(&$form, &$form_state) {
    // Intentionally empty.
  }

  /**
   * Override of pay_form::form_validate().
   */
  function form_validate($form, &$form_state) {
    $values = $this->form_values($form_state);

    // If there is no total value per payment method, set the global total.
    foreach ($values['pay_method']['selected'] as $pmid => $status) {
      if (!$status) {
        continue;
      }
      $key = $this->handler();

      // Set the total value in the form state.
      $method_values = &$form_state['values'][$key]['pay_method'][$pmid];
      if (!$method_values['total']) {
        $method_values['total'] = $values['total'];
      }

      // Not all payment methods have a payment form (such as the "Custom
      // payment" method). Only fire the pay form validation handler if needed.
      if (isset($form[$key]['pay_method'][$pmid])) {
        $method_element = &$form[$key]['pay_method'][$pmid];
        $method_element['total']['#value'] = $values['total'];
        $pay_method = pay_method_load($method_values);
        $pay_method->pay_method_validate($form, $form_state, $method_element);
      }
    }
  }

  /**
   * Override of pay_form::form_submit().
   */
  function form_submit($form, &$form_state) {
    if ($form['details']['page_num']['#value'] == $form['details']['page_count']['#value']) {
      parent::form_submit($form, $form_state);
    }
  }
}

