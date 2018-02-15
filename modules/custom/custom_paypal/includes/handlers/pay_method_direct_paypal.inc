<?php

/**
 * @file
 */

class pay_method_direct_paypal extends pay_method_direct {
  var $paypal_account = '';
  var $paypal_sandbox = '';

  // Always assume this is a 'paypal' payment, since we won't get more specific.
  var $payment_type = 'paypal';

  /**
   * A list of all currencies supported by PayPal.
   */
  function available_currencies() {
    return paypal_currencies();
  }

  function direct_request() {
    $host = $this->paypal_sandbox ? 'www.sandbox' : 'www';
    $host = 'https://' . $host . '.paypal.com/cgi-bin/webscr';

    // Map pay actions to PayPal paymentaction types.
    $txntypes = array(
      'complete'  => 'sale',
      'authorize' => 'authorization',
    );

    // Set the transaction type based on requested activity.
    if (!$txntype = $txntypes[$this->activity->action]) {
      drupal_set_message(t("Payment activity '!action' is unsupported. Not processing transaction", array('!action' => $this->activity->action)), 'error');
      return FALSE;
    }

    $step_1 = $_SESSION['register_online_step_1'];
    $step_2 = $_SESSION['register_online_step_2'];
    $step_2['first_last_names_ages_of_children_in_my_party'] = $_SESSION['register_online_step_2']['first_last_names_ages_of_children_in_my_party'];
    $step_2['first_last_names_of_adults_in_my_party'] = $_SESSION['register_online_step_2']['first_last_names_of_adults_in_my_party'];
  
    unset($_SESSION['register_online_step_1']);
    unset($_SESSION['register_online_step_2']);
    // save custom db;
    if (empty($step_1['online_registration_donate'])){
      $step_1['online_registration_donate_amount'] = 0;
    }
    
    $query = 'INSERT INTO {register_online_data} VALUE (%d,"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s",%d, %f, %d, %f, %d, %f, %d, %f, %d, %f, %f, %f, %f, %f, %d, %d, %d, %d);';
    db_query($query,
      $this->activity->pxid,
      $step_2['name_company_name'],
      $step_2['contact_name'],
      $step_2['phone'],
      $step_2['fax'],
      $step_2['email'],
      $step_2['adress'],
      $step_2['city'],
      $step_2['state'],
      $step_2['zip'],
      $step_2['name_of_your_sitter'],
      $step_2['we_wish_to_be_seated_with'],

      $step_1['online_registration_adult_qty'],
      $step_1['online_registration_total_adult_cost'],

      $step_1['online_registration_children_qty_children_dinner'],
      $step_1['online_registration_total_child_cost_children_dinner'],

      $step_1['online_registration_children_qty_adult_dinner'],
      $step_1['online_registration_total_child_cost_adult_dinner'],

      $step_1['online_registration_sitters_qty_children_dinner'],
      $step_1['online_registration_total_sitters_cost_children_dinner'],

      $step_1['online_registration_sitters_qty_adult_dinner'],
      $step_1['online_registration_total_sitters_cost_adult_dinner'],

      $step_1['online_registration_total_cost'],
      $step_1['online_registration_handling_fee'],
      $step_1['online_registration_total_attendee_cost'],
      $step_1['online_registration_donate_amount'],
      $step_1['online_registration_coins'],

      $step_1['online_registration_tweenball'],
      $step_1['online_registration_total_tweenball_cost'],
            
      $step_2['sid']
    );
    
    if (!empty($step_2['first_last_names_ages_of_children_in_my_party']) && is_array($step_2['first_last_names_ages_of_children_in_my_party']) ){
      foreach($step_2['first_last_names_ages_of_children_in_my_party'] as $key => $val){
        if (!empty($val) ){
          $query = 'INSERT INTO {register_online_childrens_on_party} VALUE (%d, "%s");';
          db_query($query, $this->activity->pxid, $val);
        }
      }
    }
    if (!empty($step_2['first_last_names_of_adults_in_my_party']) && is_array($step_2['first_last_names_of_adults_in_my_party']) ){
      foreach($step_2['first_last_names_of_adults_in_my_party'] as $key => $val){
        if (!empty($val) ){
          $query = 'INSERT INTO {register_online_adults_on_party} VALUE (%d, "%s");';
          db_query($query, $this->activity->pxid, $val );
        }
      }
    }
    $donate = '';
    foreach($step_1 as $k => $v){
      if (strpos($k, "online_registration_checkbox_value_") === 0){
        $id = substr($k, strlen("online_registration_checkbox_value_"), strlen($k) - strlen("online_registration_checkbox_value_"));
        if ( isset( $step_1['online_registration_checkbox_'.$id] )){
          $query = 'INSERT INTO {register_online_checkboxes} VALUE (%d, %f,"%s");';
          db_query($query, $this->activity->pxid, $step_1['online_registration_checkbox_value_'.$id], $step_1['online_registration_checkbox_name_'.$id]);
          $donate .= $step_1['online_registration_checkbox_name_'.$id] . ' ' . $step_1['online_registration_checkbox_value_'.$id] .' ';
        }
      }
    }

    $description = '';
    if (!empty($step_1['online_registration_adult_qty'])){
      $description .= 'Adults ' . $step_1['online_registration_adult_qty'] . 'x ' . $step_1['online_registration_total_adult_cost'] . ' ';
    }
    if (!empty($step_1['online_registration_children_qty_children_dinner'])){
      $description .= 'Children ' . $step_1['online_registration_children_qty_children_dinner'] . 'x ' . $step_1['online_registration_total_child_cost_children_dinner'] . ' ';
    }
    if (!empty($step_1['online_registration_children_qty_adult_dinner'])){
      $description .= 'Children ' . $step_1['online_registration_children_qty_adult_dinner'] . 'x ' . $step_1['online_registration_total_child_cost_adult_dinner'] . ' ';
    }
    if (!empty($step_1['online_registration_sitters_qty_children_dinner'])){
      $description .= 'Sitters ' . $step_1['online_registration_sitters_qty_children_dinner'] . 'x ' . $step_1['online_registration_total_sitters_cost_children_dinner'] . ' ';
    }
    if (!empty($step_1['online_registration_sitters_qty_adult_dinner'])){
      $description .= 'Sitters ' . $step_1['online_registration_sitters_qty_adult_dinner'] . 'x ' . $step_1['online_registration_total_sitters_cost_adult_dinner'] . ' ';
    }
    $description .= $donate;
    if (!empty($step_1['online_registration_donate_amount'])){
      $description .= ' ' . $step_1['online_registration_donate_amount'];
    }

    $this->total = $step_1['online_registration_total_attendee_cost'];
    $this->first_name = $step_2['name_company_name'];
    $this->last_name = $step_2['contact_name'];
    $this->billto['street1'] = $step_2['adress'];
    $this->billto['city'] = $step_2['city'];
    $this->billto['state'] = $step_2['state'];
    $this->billto['zip'] = $step_2['zip'];
    $this->billto['phone'] = $step_2['phone'];

    $data = array(
      'item_name'     => $description,
      'cmd'           => '_xclick',
      'paymentaction' => $txntype,
      'business'      => $this->paypal_account,
      'charset'       => 'utf-8',
      'amount'        => $this->total,
      'first_name'    => $this->first_name,
      'last_name'     => $this->last_name,
      'address1'      => $this->billto['street1'],
      'address2'      => $this->billto['street2'],
      'city'          => $this->billto['city'],
      'state'         => $this->billto['state'],
      'zip'           => $this->billto['zip'],
      'night_phone_a' => $this->billto['phone'],
      'country'       => isset($this->billto['country']) ? $this->billto['country'] : 'us',
      'currencycode'  => $this->activity->currency(),
      //'DESC' => $this->note,
      'INVNUM' => $this->pxid,
      //'BUTTONSOURCE' => 'Ubercart_ShoppingCart_DP_US',
      'notify_url'    => url('pay/gateway/response/'. $this->activity->paid, array('absolute' => TRUE)),
      'email'         => $step_2['email'],
      //'PHONENUM' => $this->billto['phone'],
    );

    $req = '';
    foreach ($data as $key => $val) {
      if ($val = trim($val)) $req .= check_plain($key) .'='. urlencode($val) .'&';
    }
    return $host . '?' . $req;
  }

  function direct_response($response = array()) {
    $this->activity->result = FALSE;
    switch ($response['payment_status']) {
      case 'Canceled_Reversal':
      case 'Created':
      case 'Denied':
      case 'Expired':
      case 'Failed':
      case 'Refunded':
      case 'Reversed':
      case 'Voided':
        // TODO could probably expand these better.
        $this->activity->result = FALSE;
        break;

      case 'Pending':
        if ($this->activity->action == 'authorize') {
          if ($response['pending_reason'] == 'authorization') {
            $this->activity->result = TRUE;
          }
        }
        break;

      case 'Processed':
      case 'Completed':
        $this->activity->result = TRUE;
        $this->activity->action = 'complete';
        $this->activity->transaction_total = $response['mc_gross'];
        break;
    }

    $this->activity->total = $response['mc_gross'];
    $this->activity->identifier = $response['txn_id'];
    $this->activity->data[] = $response;

    return $this->activity->result;
  }

  function settings_form(&$form, &$form_state) {
    parent::settings_form($form, $form_state);
    $group = $this->handler();

    $form[$group]['pp']['#type'] = 'fieldset';
    $form[$group]['pp']['#collapsible'] = FALSE;
    $form[$group]['pp']['#title'] = t('PayPal Website Payments Standard settings');
    $form[$group]['pp']['#group'] = $group;

    $form[$group]['pp']['paypal_account'] = array(
      '#type' => 'textfield',
      '#title' => t('PayPal Account e-mail address'),
      '#default_value' => $this->paypal_account,
      '#required' => TRUE,
      '#parents' => array($group, 'paypal_account'),
    );
    $form[$group]['pp']['paypal_sandbox'] = array(
      '#type' => 'checkbox',
      '#title' => t('This is a sandbox test account'),
      '#description' => t('You can obtain a developer test account from https://www.x.com (The PayPal Develper Network) and use those credentials for development and testing. If the above values belong to a developer test account and not a real merchant account, check this box.'),
      '#default_value' => $this->paypal_sandbox,
      '#parents' => array($group, 'paypal_sandbox'),
    );
  }
}
