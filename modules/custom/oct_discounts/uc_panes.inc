<?php

define('ATTR_FIRST_NAME', 3);
define('ATTR_LAST_NAME', 4);
define('ATTR_AGE_YEAR', 5);
define('ATTR_AGE_MONTH', 15);
define('ATTR_AGE_DAY', 16);


define('PRODUCT_TERM_ID', 1);


define('MANUAL_FULL_COMP_DISCOUNT_TID', 35);
define('MANUAL_DISCOUNT_TID', 34);
define('ENCORE_DISCOUNT_TID', 33);
define('SIBLING_DISCOUNT_TID', 32);
define('MULTY_CLASS_CAMP_DISCOUNT_TID', 31);
define('EARLY_BIRD_DISCOUNT_TID', 30);



/**
 * Implementation of hook_cart_pane().
 *
 * @see hook_cart_pane()
 */
function oct_discounts_cart_pane($items) {
    $panes[] = array(
        'id' => 'oct_discounts_pane',
        'title' => t('Discounts'),
        'enabled' => TRUE,
        'weight' => 1,
        'body' => !is_null($items) ? oct_discounts_cart_pane_output($items) : '',
    );

    return $panes;
}

/**
 * Adds the discounts to the cart page as line items via javascript
 */
function oct_discounts_cart_pane_output($items) {
    global $user;
    
//Create phony order object to call to get_discounts_for_order
    $order = new stdClass();
    $order->uid = $user->uid;
    $order->products = $items;

    $errors = array();
    $warnings = array();
    $messages = array();
    $discounts = oct_discounts_get_discounts_for_order($order, $errors, $warnings, $messages);

//If there are no discounts, do not alter cart
    if (count($discounts) == 0) {
        return '';
    }

//Calculate subtotal with discounts
    $subtotal = 0;
    if (is_array($items)) {
        foreach ($items as $item)
            $subtotal += $item->price * $item->qty;
    }
    $total_discount_amount = 0;
    if (is_array($discounts)) {
        foreach ($discounts as $discount)
            $total_discount_amount += $discount['amount'];
    }
    $subtotal_including_discounts = $subtotal - $total_discount_amount;

//Add total discount message
    $messages[] = "<strong>" . t("Total discount") . ":</strong>&nbsp;" . uc_currency_format($total_discount_amount);

//Add new subtotal message
    $messages[] = "<strong>" . t("Subtotal including discounts") . ":</strong>&nbsp;" . uc_currency_format($subtotal_including_discounts);

//Start row index at item count + 2 (1 for subtotal row in cart form, 1 more for our first row)
    $i = count($items) + 2;

//Create table to hold discount messages
    $body = "<div class='uc-discounts-cart-pane-container'><table class='uc-discounts-cart-pane-table'>";
    foreach ($messages as $message) {
        $evenOddClass = (($i % 2) == 0) ? "even" : "odd";
        $body .= sprintf("<tr class='%s'><td class='%s'>", $evenOddClass, "uc-discounts-cart-pane-table-cell") . $message . "</td></tr>";
        $i += 1;
    }

//Close table
    $body .= "</table></div>";

//Write table using javascript between items and cart form buttons
    drupal_add_js(sprintf('$(document).ready(function() { $("#cart-form-buttons").before("%s"); });', $body), 'inline');
}

/**
 * Implementation of hook_checkout_pane().
 */
function oct_discounts_checkout_pane() {
    $panes[] = array(
        "id" => "oct_discounts",
        "callback" => "oct_discounts_pane_discounts",
        'process' => TRUE,
        'collapsible' => TRUE,
        "title" => t("Enter discount code"),
        "weight" => 4,
    );
    return $panes;
}

/**
 * Discounts checkout pane callback
 * More information at http://www.ubercart.org/docs/developer/245/checkout
 */
function oct_discounts_pane_discounts($op, &$arg1, $arg2) {
    global $user;
    switch ($op) {
        case "view":

          $description = t('Enter discount codes in the textfield below.');
          //If viewing an existing order, load order's codes
          if (!empty($arg1->order_id)) {
              //$codes_string = uc_discounts_order_codes_get($arg1->order_id);
          }
          $contents["oct-discounts-codes"] = array(
              "#type" => "textfield",
              //"#default_value" => $codes_string,
              '#size' => 22,
              "#prefix" => "<div class='discount-codes-wrapper'>",
              "#suffix" => "</div>",
          );
          $contents["oct-discounts-placeholder"] = array(
              "#type" => "hidden",
              "#prefix" => "<div class='oct-discounts-messages-container'>",
              "#suffix" => "</div>",
          );
          $contents["oct-discounts-button"] = array(
              "#type" => "button",
              "#button_type" => "button",
              "#value" => t("Click to calculate discounts"),
          );

          return array("description" => $description, "contents" => $contents);
          dreak;
        case "process":
            // get from checkout to rewiew. 

            $warnings = array();
            $errors = array();
            $messages = array();

            $discount = get_all_discount($arg1, $errors, $warnings, $messages, $arg2['oct-discounts-codes']);
            //add item lines for countiong;

            if(!empty($discount)){
                $order->line_items = $discount;
            }

            foreach ($errors as $error) {
                drupal_set_message($error, "error");
            }
            foreach ($warnings as $warning) {
                drupal_set_message(t('Warning: @warning', array('@warning' => $warning)), 'error');
            }
            if (!empty($errors)) {
                return FALSE;
            }
            //resave email and total amount to uc_orders base. is custom submition

            //Add discount line items to order
            oct_add_discount_line_items_to_order($arg1, $discount);

            //Mark order as needing discount line items updated
            $arg1->uc_discounts_line_items_need_updating = TRUE;

           // $arg1->oct_discounts_code_appled = $arg2['oct-discounts-codes'];
            break;
    }
}

/**
 * Returns discounts for order.
 *
 * @param $order Order to get discounts for
 * @param $errors Reference to array to add error messages to
 * @param $messages Reference to array to add success messages to
 *
 * @return array of discount objects
 */
function oct_discounts_get_discounts_for_order($order, &$errors = NULL, &$warnings = NULL, &$messages = NULL) {

    $system_discounts = oct_discounts_get_discounts();
    $products = $order->products;

    // select nids from products
    $order_product_ids = array();
    if(!empty($products) && is_array($products)){
      foreach ($products as $key => $product) {
          $order_product_ids[] = $product->nid;
      }
    }

    // get taxonomy term ids for products
    $temp_term_ids = array();
    if (!empty($order_product_ids)) {
        //Get terms for order's products
        $result = db_query("SELECT DISTINCT * FROM {term_node} WHERE nid IN(%s)", join(",", $order_product_ids));
        while ($row = db_fetch_array($result)) {
            $temp_term_ids[$row["nid"]][] = $row["tid"];
        }
    }

    // remove products(tickets) from calculate discounts
    if(!empty($products) && is_array($products)){
      foreach ($products as $key => $product) {
          if (in_array(PRODUCT_TERM_ID, $temp_term_ids[$product->nid])) {
              unset($products[$key]);
          }
      }
    }
    
    // discount amount per nid
    $order_discounts = array();

    foreach ($system_discounts as $discount) {
        switch ($discount['term']['tid']) {
            case ENCORE_DISCOUNT_TID: //Encore Discount
                $valid_classes = oct_discounts_get_classes_by_children($products);
                foreach ($valid_classes as $child_id => $product) {
                    $applied_count = 0;
                    $qty = 0;
                    foreach ($product['products'] as $nid => $product_data) {
                        // if qty of first product for children >=6
                        $all_qty = $product_data->qty + $qty;

                        if ($all_qty >= 6) {
                            $c = $qty + 1;
                            for ($i = $qty; $i < $all_qty; $i++) {
                                if ($c == 6) {
                                    $applied_count++;
                                    $c = 1;
                                } else {
                                    $c++;
                                }
                            }
                            if(!empty($product_data->cart_item_id)){
                                  $product_data->cart_item_id = $product_data->order_product_id;
                            }
                            if ($discount['amount_type'] == 'persent') {
                                $order_discounts[$product_data->cart_item_id] = array(
                                    'amount' => ((($product_data->price * $applied_count) * $discount['amount']) / 100),
                                    'type' => $discount['name'],
                                    'applied_count' => $applied_count,
                                    'qty_free' => ($product_data->qty - $applied_count));
                            } else {
                                $order_discounts[$product_data->cart_item_id] = array(
                                    'amount' => $applied_count * $discount['amount'],
                                    'type' => $discount['name'],
                                    'applied_count' => $applied_count,
                                    'qty_free' => ($product_data->qty - $applied_count));
                            }

                            $qty = $all_qty % 6;
                        } else {
                            $qty = $all_qty;
                        }
                    }
                }
                break;
            case SIBLING_DISCOUNT_TID: //Sibling Discount (If more than one child enrolled, the 2nd child and on are discounted 10% on all classes. The first child can qualify for all the other discounts, so Child 1 could get early bird on a class, or received the multi class discount or the encore discount.)
                $valid_classes = oct_discounts_get_classes_by_children($products);
                $c = 0;
                foreach ($valid_classes as $child_id => $product) {
                    $c++;
                    if ($c == 1)
                        continue;  // not apply to first class

                        
                     // foreach products in each classes
                    foreach ($product['products'] as $nid => $product_data) {
                        // if for this class there isn't discount
                        $order_discounts = add_order_discounts($order_discounts, $product_data, $discount);
                    }
                }
                break;
            case MULTY_CLASS_CAMP_DISCOUNT_TID: //Multi Class/Camp (If a child signs up for more than one class, the first class is normal price and all of the following are discounted 10% (if the first class qualifies for the early bird discount however, then it also will be discounted 10%))
                $valid_classes = oct_discounts_get_classes_by_children($products);
                foreach ($valid_classes as $key => $value) {
                    if ($value['qty'] > 1) {
                        $c = 0; 
                        foreach ($value['products'] as $nid => $product_data) {
                            $c++;
                            $extra = ($c == 1) ? 1 : 0 ;
                            $order_discounts = add_order_discounts($order_discounts, $product_data, $discount, $extra);
                        }
                    }
                }
                break;
            case EARLY_BIRD_DISCOUNT_TID: //Early Bird (If a class qualifies but also qualifies for any other discount then the other discount should be applied.)
                if(!empty($products) && is_array($products)){
                  foreach ($products as $key => $product_data) {
                      // get early bird dates from node
                      $node = node_load($product_data->nid);
                      $current_time = time();
                      $start_time = strtotime($node->field_class_early_birds_date[0]['value']);
                      $end_time = strtotime($node->field_class_early_birds_date[0]['value2']);

                      // if is valid discount
                      if (($start_time <= $current_time) && ($current_time < $end_time)) {
                          $order_discounts = add_order_discounts($order_discounts, $product_data, $discount);
                      }
                  }
                }
                break;
        }
    }

    $discounts = array();
    foreach ($order_discounts as $cart_item_id => $discount_data) {
        $discounts[] = array('amount' => $discount_data['amount'], 'title' => $discount_data['type'] );
    }
    return $discounts;
}

/**
 * add discount amount for each cart id
 * @param array $order_discounts
 * @param stdClass $product_data
 * @param array $discount
 * @return array 
 */
function add_order_discounts($order_discounts, $product_data, $discount, $extra_qty = 0) {
    if(empty($product_data->cart_item_id)){
        $product_data->cart_item_id = $product_data->order_product_id;
    }
    if (!isset($order_discounts[$product_data->cart_item_id])) {
        
        $qty = $product_data->qty;
        $new_qty = (!empty($extra_qty)) ? ($qty - $extra_qty) : $product_data->qty;

        if (!empty($new_qty)) {
            $order_discounts[$product_data->cart_item_id] = ($discount['amount_type'] == 'persent') ? array('amount' => ((($product_data->price * $new_qty) * $discount['amount']) / 100), 'type' => $discount['name']) : array('amount' => $discount['amount'], 'type' => $discount['name']);
            if ($discount['amount_type'] == 'persent') {
                $order_discounts[$product_data->cart_item_id] = array(
                    'amount' => ((($product_data->price * $new_qty) * $discount['amount']) / 100),
                    'type' => $discount['name'],
                    'applied_count' => $new_qty,
                    'qty_free' => ($qty - $new_qty),
                    'title' => $product_data->title);
            } else {
                $order_discounts[$product_data->cart_item_id] = array(
                    'amount' => ($discount['amount'] * $new_qty),
                    'type' => $discount['name'],
                    'applied_count' => $new_qty,
                    'qty_free' => ($qty - $new_qty),
                    'title' => $product_data->title);
            }
        }
    } else {

        // if for this class there is discount but have free qty
        $qty_free = $order_discounts[$product_data->cart_item_id]['qty_free'];
        if ($qty_free) {
            $qty = $qty_free;
            $qty_free = (!empty($extra_qty)) ? ($qty - $extra_qty) : $qty_free;

            if ($discount['amount_type'] == 'persent') {
                $order_discounts[$product_data->cart_item_id] = array(
                    'amount' => $order_discounts[$product_data->cart_item_id]['amount'] + ((($product_data->price * $qty_free) * $discount['amount']) / 100),
                    'type' => $order_discounts[$product_data->cart_item_id]['type'] . " & " . $discount['name'],
                    'applied_count' => $order_discounts[$product_data->cart_item_id]['applied_count'] + $qty_free,
                    'qty_free' => ($qty - $qty_free));
            } else {
                $order_discounts[$product_data->cart_item_id] = array(
                    'amount' => ($order_discounts[$product_data->cart_item_id]['amount'] * $qty_free) + $discount['amount'],
                    'type' => $order_discounts[$product_data->cart_item_id]['type'] . " & " . $discount['name'],
                    'applied_count' => $order_discounts[$product_data->cart_item_id]['applied_count'] + $qty_free,
                    'qty_free' => ($qty - $qty_free));
            }
        }
    }
    return $order_discounts;
}

/**
 * get product classes by children
 * @param type $products
 * @return type 
 */
function oct_discounts_get_classes_by_children($products) {
    $childrens = array();
    if (isset($products) && !empty($products) && is_array($products)) {
        foreach ($products as $product) {
            //bad code here!. Its for checkout, (in chekout adday atribute data - changed!)
            if(is_array($product->data['attributes']['child’s first name'])){
                $children['f_name'] = $product->data['attributes']['child’s first name'][0];
                $children['l_name'] = $product->data['attributes']['child’s last name'][0];
                $day = $product->data['attributes']['birth day'][0];
                $month = $product->data['attributes']['birth month'][0];
                $year = $product->data['attributes']['birth year'][0];
                $children['age'] = $month . "_" . $day . "_" . $year;
            }else{
                $attr = oct_discounts_get_attributes($product->data['attributes']);
                $children = oct_discounts_get_unique_children($attr);
            }

            $key = $children['f_name'] . '_' . $children['l_name'] . "_" . $children['age'];
            if (isset($childrens[$key])) {
                $childrens[$key]['count']++;
            } else {
                $childrens[$key]['count'] = 1;
            }
            $childrens[$key]['qty'] = (isset($childrens[$key]['qty'])) ? $childrens[$key]['qty'] + $product->qty : $product->qty;
            $childrens[$key]['products'][$product->nid] = $product;
        }
    }
    return $childrens;
}

/**
 * get unique children (first name, last name, age)
 * @param array $attributes
 * @return array 
 */
function oct_discounts_get_unique_children($attributes) {
    $data = array(
        'f_name' => '',
        'l_name' => '',
        'age' => ''
    );
    foreach ($attributes as $attr_id => $attribute_data) {
        switch ($attribute_data['data']->aid) {
            case ATTR_FIRST_NAME:
                $data['f_name'] = $attribute_data['value'];
                break;
            case ATTR_LAST_NAME:
                $data['l_name'] = $attribute_data['value'];
                break;
            case ATTR_AGE_YEAR:
                $year = $attribute_data['data']->options[$attribute_data['value']]->name;
                break;
            case ATTR_AGE_MONTH:
                $month = $attribute_data['data']->options[$attribute_data['value']]->name;
                break;
            case ATTR_AGE_DAY:
                $day = $attribute_data['data']->options[$attribute_data['value']]->name;
                break;
        }
        $data['age'] = $month . "_" . $day . "_" . $year;
    }
    return $data;
}

/**
 * Get full data of attribute
 * @param array $attributes
 * @return array 
 */
function oct_discounts_get_attributes($attributes) {
    foreach ($attributes as $attr_id => $attribute_value) {
        $attr = uc_attribute_load($attr_id);
        $attributes[$attr_id] = array('value' => $attribute_value, 'data' => $attr);
    }
    return $attributes;
}

/**
 * Get all discounts
 * @return array 
 */
function oct_discounts_get_discounts() {
    $discounts = array();
// get all discounts
    $result = views_get_view_result("Discounts", "block_1");
// cheate discounts array
    foreach ($result as $discount) {
        $discounts[] = array(
            'nid' => $discount->nid,
            'name' => $discount->node_title,
            'term' => array(
                'name' => $discount->term_data_name,
                'vid' => $discount->term_data_vid,
                'tid' => $discount->term_data_tid
            ),
            'weight' => $discount->node_data_field_discount_weight_field_discount_weight_value,
            'code' => $discount->node_data_field_discount_weight_field_discount_code_value,
            'date' => array(
                'start' => $discount->node_data_field_discount_weight_field_discount_date_value,
                'end' => $discount->node_data_field_discount_weight_field_discount_date_value2,
            ),
            'amount' => $discount->node_data_field_discount_weight_field_discount_amount_value,
            'amount_type' => ($discount->node_data_field_discount_weight_field_discount_percent_fixed_value) ? 'fixed' : 'persent',
        );
    }
    return $discounts;
}
/**
 * AJAX callback for discounts calculation.
 *
 * Calculate discount for an order in the checkout page.
 */

function get_oct_custom_discounts(){
  global $user;

  if (!empty($_SESSION["cart_order"])) {
      $order_id = $_SESSION['cart_order'];
      $order = uc_order_load($order_id);
      //If session order exists, use it
      if (is_null($order)) {
          print '{}';
          exit;
      }
  }else {//Otherwise create phony order
      $order = new stdClass();
      $order->uid = $user->uid;
      $order->products = uc_cart_get_contents();
  }
  $order->uc_discounts_codes = $_POST['discount_code'];
  // Session vars get used by conditional action
  $_SESSION['uc_discounts_codes'] = $order->uc_discounts_codes;

  $errors = array();
  $warnings = array();
  $messages = array();

  $line_items = get_all_discount($order, $errors, $warnings, $messages, $order->uc_discounts_codes);
/*
  $order_total = 0;

  if(!empty($order->line_items) && is_array($order->line_items)){
    foreach($order->line_items as $item){
      $order_total += $item->amount;
    }
  }
*/
  $order_total = 0;
  if(!empty($order->products) && is_array($order->products)){
    foreach($order->products as $product){
      $order_total += $product->price * $product->qty;
    }
  }
  if (!empty($line_items) && is_array($line_items)){
    foreach ($line_items as $discount){
      $order_total += $discount["amount"];
    }
  }

  $calculate_discount_response = array(
        OCT_CALCULATE_DISCOUNT_RESPONSE_SUBTOTAL => $order_total,
        OCT_CALCULATE_DISCOUNT_RESPONSE_LINE_ITEMS_KEY => $line_items,
        OCT_CALCULATE_DISCOUNT_RESPONSE_ERRORS_KEY => $warnings,
        OCT_CALCULATE_DISCOUNT_RESPONSE_MESSAGES_KEY => $messages,
  );
  drupal_json($calculate_discount_response);
  exit;
}

function oct_get_manual_discounts_for_order($order, &$errors = NULL, &$warnings = NULL, &$messages = NULL, $code) {
  $line_items = array();
  $code_match = false;
  $apply_discount = false;
  $order_total = null;

  // check printed code
  if(!empty($code)){
    $discounts = views_get_view_result("Discounts", "block_2");
    foreach($discounts as $discount){
      //if code set user equal any Manual code
      if($code == $discount->node_data_field_discount_weight_field_discount_code_value){
        // check this discount for product in cart
        $discount_tid = get_taxonomy_by_nid($discount->nid);
        if(!empty ($order->products) && is_array($order->products)){
          foreach($order->products as $product){
            $product_tid = get_taxonomy_by_nid($product->nid);
            if(!empty($discount_tid[$discount->nid]) && is_array($discount_tid[$discount->nid])){
              foreach($discount_tid[$discount->nid] as $d_tid){
                if (in_array($d_tid , $product_tid[$product->nid])){
                  $taxonomy = $d_tid;
                  // get sum of product foor that discount
                  $order_total += $product->price * $product->qty;
                  $apply_discount = true;
                }
              }
            }
          }
        }
        //set chosen discount

        $line_item["id"] = $discount->nid;

        $line_item["type"] = OCT_LINE_ITEM_KEY_NAME; // manual discount tid

        $line_item["title"] = $discount->node_title;
        if((int)$discount->node_data_field_discount_weight_field_discount_percent_fixed_value == 1){
          $line_item["amount"] = -(int)$discount->node_data_field_discount_weight_field_discount_amount_value;
        }elseif((int)$discount->node_data_field_discount_weight_field_discount_percent_fixed_value == 0){
          $line_item["amount"] = -(($order_total/100)*(int)$discount->node_data_field_discount_weight_field_discount_amount_value);
        }
        if( $order_total < $line_item["amount"]){
          $line_item["amount"] = 0;
        }
        $line_item["weight"] = $discount->node_data_field_discount_weight_field_discount_percent_fixed_value;
        $line_items[] = $line_item;
        $code_match = true;

        $options = array("@short_description" => $discount->node_title,
          "@code" => $discount->node_data_field_discount_weight_field_discount_code_value,
          "@times_applied" => format_date(strtotime($discount->node_data_field_discount_weight_field_discount_date_value), 'event_date_format') ,
        );
        if(!$apply_discount){
          $warnings[] = t('This discount not fir that product type.', $options);
        }
        if (time() < strtotime($discount->node_data_field_discount_weight_field_discount_date_value)){
          $warnings[] = t('The discount @short_description for code "@code" not start.', $options);
          $line_items = array();
        }
        if (time() > strtotime($discount->node_data_field_discount_weight_field_discount_date_value2)){
          $warnings[] = t('The discount @short_description for code "@code" has expired.', $options);
          $line_items = array();
        }
      }
    }
  }else{
    $warnings[] = t('You not enter discount code.', $options);
    $_SESSION['uc_discounts_codes'] = '';
  }
  if (!$code_match){
    $warnings[] = t('Coupon does not exist or is not valid.');
    $_SESSION['uc_discounts_codes'] = '';
  }
  if(empty($warnings) && $code_match){
    $messages[] = t("The discount, '@short_description', was applied.", $options);
  }
  return array('taxonomy' => $taxonomy , 'line_items' => $line_items);
}

/**
 * Add discount line items to order
 *
 * Note: assumes discount objects are the result of a call to get_discounts_for_order()
 */
function oct_add_discount_line_items_to_order(&$order, $discounts) {
    //Create line items for discounts and store in order's uc_discounts_line_items field
    $line_items = array();
    if(!empty($discounts) && is_array($discounts)){
      foreach ($discounts as $discount) {
        if(!empty($discount['type'])){
          $type = $discount['type'];
        }else{
          $type = OCT_LINE_ITEM_KEY_NAME;
        }
        $line_item = array(
            'type' => $type,
            'title' => $discount['title'],
            'amount' => $discount['amount'],
            'weight' => OCT_LINE_ITEM_WEIGHT,
            'data' => array('discount_id' => $discount['id']),
        );
        $line_items[] = $line_item;
      }
    }
    $order->uc_discounts_line_items = $line_items;
}

/**
 * Implementation of Übercart's hook_line_item().
 * Displays all discounts as a single line item
 * @see hook_line_item()
 */
function oct_discounts_line_item() {
  
    $line_items[] = array(
        "id" => OCT_LINE_ITEM_KEY_NAME,
        "title" => t("Discount"),
        "weight" => OCT_LINE_ITEM_WEIGHT,
        "stored" => TRUE,
        // Added to total
        "calculated" => TRUE,
        "display_only" => FALSE,
    );
    return $line_items;
   
}

/**
 * Implementation of hook_order().
 *
 * Manages order->uc_discounts_codes (array of code) and order->discounts (array of uses)
 */
function  oct_discounts_order($op, $arg1, $arg2) {

    switch ($op) {
        case 'load':
            break;

        case 'save':
            if(!empty($_SESSION['uc_discounts_codes'])){
              $code = $_SESSION['uc_discounts_codes'];
            }
            $warnings = array();
            $errors = array();
            $messages = array();

            // drop fee for especial manual discount
            $line_item_id = oct_custom_drop_fee_for_manual_discount($code, $arg1);
            if (!empty($line_item_id)){
              uc_order_delete_line_item($line_item_id);
            }

            $line_items = get_all_discount($arg1, $errors, $warnings, $messages, $code);
            if (is_array($line_items)) {
              foreach ($line_items as $line) {
                if ($line['type'] == OCT_LINE_ITEM_KEY_NAME) {
                  oct_order_delete_discount_line_item($arg1->order_id);
                }
              }
            }
            if (is_array($line_items)) {
              foreach ($line_items as $line) {
                uc_order_line_item_add($arg1->order_id, OCT_LINE_ITEM_KEY_NAME, $line['title'], $line['amount'], 10);
              }
            }
            break;
    }
}
/**
 * Implementation of hook_checkout_pane_alter()
 * Get discounted price to show up on checkout, & review
 */

function oct_discounts_checkout_pane_alter(&$panes) {
    foreach ($panes as &$pane) {
        if ($pane['id'] == 'cart') {
            $pane['callback'] = 'oct_discounts_checkout_pane_content';
        }
    }
}

function oct_discounts_checkout_pane_content($op) {
    switch ($op) {
        case 'view':
            $contents['cart_review_table'] = array(
                '#value' => theme('oct_discounts_cart_checkout_table'),
                '#weight' =>  2,
            );
            return array('contents' => $contents, 'next-button' => FALSE);
        case 'review':
            $discount_amount = oct_discounts_get_discount_amount_for_order($op);
          
            $items = uc_cart_get_contents();
            $output = '<table>';
            $context = array(
                'revision' => 'themed',
                'type' => 'cart_item',
                'subject' => array(),
            );
            $total = 0;
            foreach ($items as $item) {
                $total += ($item->price * $item->qty);
                $desc = check_plain($item->title) . uc_product_get_description($item);

                $price_info = array(
                    'price' => $item->price,
                    'qty' => $item->qty,
                );
                $context['subject'] = array(
                    'cart' => $items,
                    'cart_item' => $item,
                    'node' => node_load($item->nid),
                );
                $output .= '<tr valign="top"><td>' . $item->qty . '&times;</td><td width="100%">' . $desc
                        . '</td><td nowrap="nowrap">' . uc_price($price_info, $context) . '</td></tr>';
            }
            if ($discount_amount > 0) {
                $final_price = $total - $discount_amount;
                $output .= '<tr valign="top"><td colspan="2"><strong>' . t('Discount') . ': </strong></td><td nowrap="nowrap">' . uc_price($discount_amount, $context) . '</td></tr>';
                $output .= '<tr valign="top"><td colspan="2"><strong>' . t('Total') . ': </strong></td><td nowrap="nowrap"><b>' . uc_price($final_price, $context) . '</b></td></tr>';
            }
            $output .= '</table>';
            $review[] = $output;
            return $review;
    }
}
/**
 * Helper function that gets the discount amount for the order
 * @return int *
 */
function oct_discounts_get_discount_amount_for_order($op) {

  if (!empty($_SESSION["cart_order"])) {
      $order_id = $_SESSION['cart_order'];
      $order = uc_order_load($order_id);
  }else {//Otherwise create phony order
      $order = new stdClass();
      $order->uid = $user->uid;
      $order->products = uc_cart_get_contents();
  }
  if(!empty($_SESSION['uc_discounts_codes'])){
      $code = $_SESSION['uc_discounts_codes'];
  }

  $errors = array();
  $warnings = array();
  $messages = array();

  $line_items = get_all_discount($order, $errors, $warnings, $messages, $code);
  
  $total_discount_amount = 0;
  if(!empty ($line_items) && is_array($line_items)){
      foreach($line_items as $discount){
           $total_discount_amount += $discount['amount'];
      }
  }
  return ( $total_discount_amount * (-1));
}

function theme_oct_discounts_cart_checkout_table($show_subtotal = TRUE) {
    $subtotal = 0;

    $discount_amount = oct_discounts_get_discount_amount_for_order('checkout');
    // Set up table header.
    $header = array(
        array('data' => t('Qty'), 'class' => 'qty'),
        array('data' => t('Products'), 'class' => 'products'),
        array('data' => t('Price'), 'class' => 'price'),
    );

    $context = array();

    // Set up table rows.
    $contents = uc_cart_get_contents();
    foreach ($contents as $item) {
        $price_info = array(
            'price' => $item->price,
            'qty' => $item->qty,
        );

        $context['revision'] = 'altered';
        $context['type'] = 'cart_item';
        $context['subject'] = array(
            'cart' => $contents,
            'cart_item' => $item * $discount_amount,
            'node' => node_load($item->nid),
        );

        $total = uc_price($price_info, $context);
        $subtotal += $total;

        $description = check_plain($item->title) . uc_product_get_description($item);

        // Remove node from context to prevent the price from being altered.
        $context['revision'] = 'themed-original';
        $context['type'] = 'amount';
        unset($context['subject']);
        $rows[] = array(
            array('data' => t('@qty&times;', array('@qty' => $item->qty)), 'class' => 'qty'),
            array('data' => $description, 'class' => 'products'),
            array('data' => uc_price($total, $context), 'class' => 'price'),
        );
    }
    /*print 'subtotal:'.$subtotal;
    print 'discount_amount:'.$discount_amount;*/
    //if ($discount_amount > 0) {
        $rows[] = array(
            array('data' => ''),
            array('data' => t('Discount:'), 'align' => 'right'),
            array('data' => uc_price($discount_amount, $context).'<span class="uc-discount-price"></span>', 'class' => 'discount-price'),
        );
        $subtotal = $subtotal - $discount_amount;
    //}

    // Add the subtotal as the final row.
    if ($show_subtotal) {
        $context = array(
            'revision' => 'themed-original',
            'type' => 'amount',
        );
        $rows[] = array(
            'data' => array(array('data' => '<span id="subtotal-title">' . t('Subtotal:') . '</span> ' . uc_price($subtotal, $context). '<span class="uc-discount-price"></span>' , 'colspan' => 3, 'class' => 'subtotal')),
            'class' => 'subtotal',
        );
    }

    return theme('table', $header, $rows, array('class' => 'cart-review'));
}
/**
 * Get array of all disount
 *
 * @param stdClass $order
 * @param Array $errors
 * @param Array $warnings
 * @param Array $messages
 * @param str $codes
 * @return array
 */
function get_all_discount($order, &$errors, &$warnings, &$messages, $codes){
  $hard_discount = oct_discounts_get_discounts_for_order($order, $errors, $warnings, $messages);
  if(!empty($codes)){
      $code_discount = oct_get_manual_discounts_for_order($order, $errors, $warnings, $messages, $codes);
  }
  if ((!empty($code_discount['line_items'])) && (is_array($code_discount['line_items']))){
      foreach($code_discount['line_items'] as $discount){
          $line_items[] = $discount;
      }
  }
  // not count another discount if customer enter code discount
  if ($code_discount['taxonomy'] != 2  && $code_discount['taxonomy'] != 3){
      if (!empty($hard_discount) && is_array($hard_discount)){
          foreach($hard_discount as $discount){
              $line_items[] = array( 'amount' => ($discount['amount'] * (-1)),  'type' => OCT_LINE_ITEM_KEY_NAME, 'title' => $discount['title']);
          }
      }
  }

  // if discount more than total price
  $order_total = 0;
  if(!empty ($order->products) && is_array($order->products)){
      foreach($order->products as $product){
          $order_total += $product->price * $product->qty;
      }
  }
  $total_discount = 0;
  if(!empty ($line_items) && is_array($line_items)){
      foreach ($line_items as $disc){
          $total_discount += $disc['amount'];
      }
  }
  // make order $0
  if (($order_total + $total_discount) < 0){
    $disparity = $order_total + $total_discount;
    
    $reverted_line_items = array_reverse($line_items);
    foreach( $reverted_line_items as $key => $val){
      if ($val['type'] == 'oct_discounts'){
        if ($disparity < 0){
          $diff = $disparity - $reverted_line_items[$key]['amount'];
          if ($diff > 0){
            $reverted_line_items[$key]['amount'] = -$diff;
            $reverted_line_items[$key]['title'] .= t(' (modifed)');
          }elseif( $diff < 0){
            $disparity = $disparity - $reverted_line_items[$key]['amount'];
            $reverted_line_items[$key]['amount'] = 0;
            $reverted_line_items[$key]['title'] .= t(' (annulled)');
          }
        }
      }
    }
    $line_items = array_reverse($reverted_line_items);

  }
  return $line_items;
}

/**
 * another save after checkout
 * @param <type> $form
 * @param <type> $form_state
 */
function resave_order_after_checkout_submit($form, $form_state){
  // get zine id
  $query = "SELECT zone_id FROM uc_zones AS zones WHERE zones.zone_code = '%s';";
  $result = db_query($query, $form['#post']['panes']['oct_custom']['user_info_state']);
  $zone_id = db_fetch_array($result);
  $zid = 0;
  if(!empty($zone_id)){
    $zid = $zone_id;
  }
  if(!empty($form['#post']['panes']['oct_custom']['user_info_first_name'])){
      $first_name = $form['#post']['panes']['oct_custom']['user_info_first_name'];
      $last_name = $form['#post']['panes']['oct_custom']['user_info_last_name'];
  }elseif(!empty($form['#post']['panes']['oct_custom']['user_info_parent_of_guardian_first_name'])){
      $first_name =  $form['#post']['panes']['oct_custom']['user_info_parent_of_guardian_first_name'];
      $last_name = $form['#post']['panes']['oct_custom']['user_info_parent_of_guardian_last_name'];
  }
  if(!empty($form['panes']['#post']['panes']['oct_custom']['user_info_email'])){
      $primary_email = $form['panes']['#post']['panes']['oct_custom']['user_info_email'];
  }
  if (!empty($_SESSION["cart_order"])) {
      $order_id = $_SESSION['cart_order'];
  }
  // update uc_order table for set "billing info" and "primary email"
  $query = 'UPDATE {uc_orders} AS u_order
            SET u_order.primary_email = "%s",
                u_order.billing_first_name = "%s",
                u_order.billing_last_name = "%s",
                u_order.billing_phone = "%s",
                u_order.billing_street1 = "%s",
                u_order.billing_city = "%s",
                u_order.billing_zone = %d,
                u_order.billing_postal_code = "%s"
            WHERE u_order.order_id = %d';
  db_query($query,
          $primary_email,
          $first_name,
          $last_name,
          $form['#post']['panes']['oct_custom']['user_info_phone_number'],
          $form['#post']['panes']['oct_custom']['user_info_address'],
          $form['#post']['panes']['oct_custom']['user_info_сity'],
          $zid['zone_id'],
          $form['#post']['panes']['oct_custom']['user_info_zip'],
          $order_id);
}

function oct_order_delete_discount_line_item($order_id){
  $query = 'DELETE FROM {uc_order_line_items} WHERE `type` = "%s" AND `order_id`= %d;';
  //just casual discount;
  db_query($query , OCT_LINE_ITEM_KEY_NAME, $order_id);
  db_query($query , OCT_LINE_ITEM_FREE_MANUAL_KEY_NAME, $order_id);
}
/**
 * Implementation of hook_calculate_fees()
 */
function oct_discounts_calculate_fees($order){
  //  dsm($order);
  // i cant reset or drop previous fee from original module
  /*
  if (is_numeric($order)) {
    $order = uc_order_load($order);
  }
  if (!is_object($order)) {
    return array();
  }
  $order->fees[]= array('id' => 4, 'name' => "Handling fee for tickets oct_custom", 'amount' => 0, 'weight' => 0);
  return $order->fees;
   */
}

/**
 * Implementation of hook_cart_item()
 */
function oct_discounts_cart_item($op, &$item){

  
}

/**
 * like uc_payment_get_totals() it ajax build Order total preview in cart/checkout page
 * @param <type> $return
 * @param <type> $order
 * @return string
 */
function oct_custom_payment_get_totals($return = FALSE, $order = NULL) {
  $output = '';

  if (empty($order) && is_array($_POST) && isset($_POST['order'])) {
    $order = unserialize($_POST['order']);
  }

  if ($order) {
    usort($order->line_items, 'uc_weight_sort');

    $output = t('Order total preview:')
             .' <span id="order-total-throbber"></span><table>';
    $grand_total = 0;

    $context = array(
      'type' => 'line_item',
      'subject' => array(
        'order' => $order,
      ),
    );
    
    $code = $_SESSION['uc_discounts_codes'];
    // fiction hide fee only for checkout
    oct_custom_drop_fee_for_manual_discount($code, $order);

    foreach ($order->line_items as $line) {
      if (!empty($line['title'])) {
        $context['revision'] = 'themed';
        $context['subject']['line_item'] = $line;

        $output .= '<tr><td align="right"><b>'. filter_xss($line['title']) .':</b></td>'
                  .'<td align="right">'. uc_price($line['amount'], $context) .'</td></tr>';

        if ($line['summed']) {
          $context['revision'] = 'altered';
        }
      }
    }

    $context['revision'] = 'themed';
    $context['type'] = 'amount';
    unset($context['subject']);
    $output .= '<tr><td align="right"><b>'. t('Order total:') .'</b></td>'
              .'<td align="right">'. uc_price(uc_order_get_total($order), $context)
              .'</td></tr></table>';
  }

  if ($return) {
    return $output;
  }

  print $output;
  exit();
}

/**
 * Drop one fee from order
 */

function oct_custom_drop_fee_for_manual_discount($code, &$order){
  if (!empty($code)){
    // get taxonomy from code
    $discounts = views_get_view_result("Discounts", "block_2");
    $tid = 0;
    foreach($discounts as $discount){
      if($code == $discount->node_data_field_discount_weight_field_discount_code_value){
        $tids = get_taxonomy_by_nid($discount->nid);
        if (in_array(1, $tids[$discount->nid])){
          //product
          $tid = 1;
        }elseif(in_array(2, $tids[$discount->nid]) || in_array(3, $tids[$discount->nid])){
          //class or camp
          $tid = 2;
        }
      }
    }
    if (!empty ($order->line_items)){
      foreach ($order->line_items as $key => $value){
        if ( ($value['type'] == 'fee') && ($tid == 1) && ($value['title']  == 'Handling fee for tickets') ){
          if (!empty($value['line_item_id'])){
             $line_id = $value['line_item_id'];
          }
          unset ($order->line_items[$key]);


        }
        if ( ($value['type'] == 'fee') && ($tid == 2) && ($value['title'] == 'Handling fee for classes/camps') ){
          if (!empty($value['line_item_id'])){
             $line_id = $value['line_item_id'];
          }
          unset ($order->line_items[$key]);
        }
      }
    }
    
    switch($tid){
      case 1:
        unset($order->fees[4]);
        break;
      case 2:
        unset($order->fees[3]);
        break;
    }
    return $line_id;
  }
} 