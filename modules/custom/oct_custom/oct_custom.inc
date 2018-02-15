<?php
define('SHOW_USER_INFO_ROW_PER_PAGE', 10);

/**
 * Hook menu custom callback page
 */
function oct_custom_enrollment() {
  $cart_block = module_invoke('uc_ajax_cart', 'block', 'view', 0);
  $data = array('cart' => $cart_block['content']);
  return theme('enrollment_page', $data);
}

/**
 * Hook menu custom callback page
 */
function oct_custom_enrollment_get_data($month, $day, $year) {
  $date = $year . '-' . $month . '-' . $day . ' 00:00:00';
  $data = array();
  $data = _oct_custom_select_classes($date);
  drupal_json(array('status' => 1, 'data' => $data));
}

/**
 * Hook menu custom callback page
 */
function oct_custom_enrollment_set_data() {
  $data = $_POST;
  if (!empty($data['enrollment'])) {
    $nid = $data['enrollment']['class_camp'];
    $first_name = $data['enrollment']['first_name'];
    $last_name = $data['enrollment']['last_name'];
    $food_allergy = $data['enrollment']['food_allergy'];
    $year = $data['enrollment']['year'];
    $month = $data['enrollment']['month'];
    $day = $data['enrollment']['day'];

    $age = ((int)date('Y') - (int)$year);

    $class_date_oid = $data['enrollment']['session_time'];
    $t_short = is_numeric($data['enrollment']['t_shirt']) ? $data['enrollment']['t_shirt'] : NULL ;
    $node = node_load($nid);

    $birth_year_options = $node->attributes[5]->options;
    $b_year_oid = NULL;
    if (is_array($birth_year_options)) {
      foreach ($birth_year_options as $oid => $val) {
        if ($year == (int)$val->name) {
          $b_year_oid = $oid;
        }
      }
    }

    $birth_month_options = $node->attributes[15]->options;
    $b_month_oid = NULL;
    if (is_array($birth_month_options)) {
      foreach ($birth_month_options as $oid => $val) {
        if ($month == (int)$val->name) {
          $b_month_oid = $oid;
        }
      }
    }
    $birth_day_options = $node->attributes[16]->options;
    $b_day_oid = NULL;
    if (is_array($birth_day_options)) {
      foreach ($birth_day_options as $oid => $val) {
        if ($day == (int)$val->name) {
          $b_day_oid = $oid;
        }
      }
    }
    $attributes = array('14' => $t_short, '13' => $class_date_oid, '16' => $b_day_oid, '15' => $b_month_oid, '5' => $b_year_oid, '3' => $first_name, '4' => $last_name, '18' => $food_allergy);
    $stockinfo = oct_custom_get_qty_info_about_store($nid, $class_date_oid);

    $items_in_cart = uc_cart_get_contents();
    if (!empty($items_in_cart)) {
      foreach ($items_in_cart as $key => $item) {
        if ($item->model == $stockinfo['model'] && $item->data['attributes'][AID_CLASS_DATE] == $class_date_oid) {
          $stockinfo['stock'] -= $item->qty;
        }
      }
    }

    $stock = $stockinfo['stock'];

    //$stock = uc_stock_level($node->model);
    //        $items = uc_cart_get_contents();
    //        $cart_qty = 0;
    //        foreach($items as $item){
    //            if ($item->nid == $node->nid) {
    //              $cart_qty += $item->qty;
    //            }
    //        }
    if ($stock > 0 /*&& $stock > $cart_qty*/) {
      $product_data = array('attributes' => $attributes, 'shippable' => 1, 'module' => 'uc_product',);
      if (!empty($nid) && is_numeric($nid)) {
        $res = uc_cart_add_item($nid, 1, $product_data, NULL, FALSE, FALSE);
      }
      drupal_json(array('status' => 1, 'data' => $node->title . "\" added "));
    }
    else {
      drupal_json(array('status' => 0, 'data' => "We're sorry. We don't have any tickets for \"" . $node->title . "\" class. "));
    }
  }
  else {
    drupal_json(array('status' => 0, 'data' => 'error: Empty enroll data'));
  }
}

/**
 * Hook menu custom callback page
 */
function oct_custom_product_tikets() {
  $data = array();
  return theme('product_tickets_page', $data);
}

/**
 * Ajax call enrollment form data.
 */
function _oct_custom_select_classes($date) {

  //take t-shirt oid for select;
  $result = db_query('SELECT uc_attribute_options.oid,uc_attribute_options.name FROM uc_attribute_options
    WHERE  uc_attribute_options.aid = %d', AID_T_SHORTS);
  while ($row = db_fetch_array($result)) {
    $t_shirt[] = array('oid' => $row['oid'], 'size' => $row['name']);
  }
  //take product data
  $sql = "SELECT DISTINCT
      node.nid,
      node.title,
      term_node.tid,
      uc_product_ticket_dates.oid,
      uc_product_ticket_dates.delta,
      content_type_product.field_class_price_value,
      content_type_product.field_product_sold_message_value,
      content_type_product.field_product_unvaliable_message_value,
      content_type_product.field_product_t_shirts_value,
      uc_attribute_options.name,
      content_field_class_sold.field_class_sold_value,
      content_field_class_unvaliable_online.field_class_unvaliable_online_value,
      content_field_qty_class_ticket.field_qty_class_ticket_value

      FROM {node} AS node
      JOIN {term_node} ON term_node.vid = node.vid
      JOIN {content_type_product} ON content_type_product.vid = node.vid
      JOIN {uc_product_ticket_dates} ON node.nid = uc_product_ticket_dates.nid_product
      JOIN {uc_attribute_options} ON uc_attribute_options.oid = uc_product_ticket_dates.oid
      JOIN {content_field_class_sold} ON content_field_class_sold.vid = node.vid AND content_field_class_sold.delta = uc_product_ticket_dates.delta
      JOIN {content_field_class_unvaliable_online} ON content_field_class_unvaliable_online.vid =  node.vid AND content_field_class_unvaliable_online.delta = uc_product_ticket_dates.delta
      JOIN {content_field_qty_class_ticket} ON content_field_qty_class_ticket.vid =  node.vid AND content_field_qty_class_ticket.delta = uc_product_ticket_dates.delta
      JOIN {term_node} AS term_node_2 ON term_node_2.vid = node.vid
      JOIN {term_data} ON term_data.tid = term_node_2.tid
      WHERE ( (term_node.tid IN (3)) OR ( term_node.tid = (2)) )
      AND node.status = 1
      AND node.type IN ('product')
      AND DATE(uc_product_ticket_dates.min_birth_date) -  INTERVAL (1) YEAR  <= DATE('%s')
      AND DATE('%s') <= DATE(uc_product_ticket_dates.max_birth_date) 
      AND uc_attribute_options.aid = %d
      ORDER BY term_data.weight;";

  $result = db_query($sql, $date, $date, AID_CLASS_DATE);
  $nods = array();

  while ($row = db_fetch_array($result)) {
    if (empty($nods[$row['nid']])) {
      $nods[$row['nid']] = array('title' => $row['title'], 'price' => $row['field_class_price_value'], 'sold_mes' => $row['field_product_sold_message_value'], 'online_mes' => $row['field_product_unvaliable_message_value'], 'show_t_shirts' => $row['field_product_t_shirts_value'], 'dates' => array(array('date' => $row['name'],)), 'oids' => array(array('oid' => $row['oid'],)), 'sold' => array(array('sold_out' => $row['field_class_sold_value'],)), 'online' => array(array('avaiable_online' => $row['field_class_unvaliable_online_value'],)), 'tickets' => array(array('tickets_qty' => $row['field_qty_class_ticket_value'],)),

      );
      if ($row['field_product_t_shirts_value']) {
        $nods[$row['nid']]['t_shirt'] = $t_shirt;
      }
    }
    else {
      $nods[$row['nid']]['dates'][] = array('date' => $row['name'],);
      $nods[$row['nid']]['oids'][] = array('oid' => $row['oid'],);
      $nods[$row['nid']]['sold'][] = array('sold_out' => $row['field_class_sold_value'],);
      $nods[$row['nid']]['online'][] = array('avaiable_online' => $row['field_class_unvaliable_online_value'],);
      $nods[$row['nid']]['tickets'][] = array('tickets_qty' => $row['field_qty_class_ticket_value'],);
    }
  }
  ;
  return $nods;
}

/**
 * @return array
 */
function oct_custom_get_all_product() {
  $sql = "SELECT node_d.nid AS nid,
      node_d.title AS node_title
      FROM {node} AS node_d
      INNER JOIN {term_node} AS terms ON node_d.vid = terms.vid
      WHERE (node_d.type IN ('product')) AND (node_d.status = 1) AND (terms.tid = 24)";
  $result = db_query($sql);
  $list = array();
  while ($row = db_fetch_array($result)) {
    $list[$row['nid']] = $row['node_title'];
  }
  return $list;
}

/**
 * this code show when you select ajax ticket/  (also it has in product_tickets_page.tpl.php for load page)
 */
function oct_custom_get_product_node() {
  if (is_numeric(arg(2))) {
    //bad code here =*(
    $node = node_load(arg(2));
    /* previous functional (when product has one "soldout button")
    if (($node->field_product_sold[0]['value'] == 1) || ($node->field_product_unvaliable_online[0]['value'] == 1)){
      print '<div class="product-message" id="product-form">';

      if ($node->field_product_sold[0]['value'] == 1){
        if ($node->field_product_sold_message[0]['value']){
          print '<h3>' . $node->field_product_sold_message[0]['value'] . '</h3>';
        }else{
          print '<h3>' . t('This product Sold Out') . '</h3>';
        }
      }
      if($node->field_product_unvaliable_online[0]['value'] == 1){
        if($node->field_product_unvaliable_message[0]['value']){
          print '<h3>' . $node->field_product_unvaliable_message[0]['value'] . '</h3>';
        }else{
          print '<h3>' . t('Not available online. Please check at the door') . '</h3>';
        }
      }
      if ($node->body){
        print '<h3>' . t('Location') . '</h3>';
        print ($node->body);
      }
      print '</div>';
    }else{
    */
    print drupal_get_form('uc_product_add_to_cart_form', $node);
    /*}*/
  }

}

/**
 * On load show user info table
 */
function oct_custom_user_info_page() {
  $type = $_GET['type'];
  $page = 1;

  // Onload page show data, Don't forget ajax filer
  $result = get_data_user_info_table($type, $page);
  drupal_add_js('Drupal.behaviors.ajaxFilterUserInfoByDate = function(context){ filterUserInfoByDate(); }', 'inline');
  drupal_add_js('Drupal.behaviors.ajaxUserInfoPage = function(context){ changeUserInfoPage(); }', 'inline');

  $data = array('type' => $type, 'result' => $result['table'], 'total_row' => $result['result_rows'], 'show_per_page' => SHOW_USER_INFO_ROW_PER_PAGE, 'date_from' => $date_from, 'date_to' => $date_to, 'concert_name' => NULL, 'all_product_names' => $result['all_product_names'], 'now_page' => $page,);
  $output = theme('order_user_info', $data);
  return $output;
}

/**
 * Ajax filter user info table
 */
function oct_custom_get_data_from_filter() {
  $data = array();
  parse_str($_POST['data'], $data);
  $date_from = $data['data_sorter_user_info_from'];
  $date_to = $data['data_sorter_user_info_to'];
  $type = $data['user_info_type_table'];
  $concert_name = $data['concert_name'];
  $chosen_nids = $data['name_sorter_product'];

  if (!empty($_POST['pressed_page'])) {
    $page = $_POST['pressed_page'];
  }
  else {
    $page = 1;
  }
  //Ajax filter load data
  $result = get_data_user_info_table($type, $page, $date_from, $date_to, $concert_name, $chosen_nids);
  drupal_add_js('Drupal.behaviors.ajaxFilterUserInfoByDate = function(context){ filterUserInfoByDate(); }', 'inline');
  drupal_add_js('Drupal.behaviors.ajaxUserInfoPage = function(context){ changeUserInfoPage(); }', 'inline');
  $data = array('type' => $type, 'result' => $result['table'], 'total_row' => $result['result_rows'], 'show_per_page' => SHOW_USER_INFO_ROW_PER_PAGE, 'date_from' => $date_from, 'date_to' => $date_to, 'concert_name' => $concert_name, 'all_product_names' => $result['all_product_names'], 'chosen_nids' => $chosen_nids, 'now_page' => $page,);
  $output = theme('order_user_info', $data);
  print $output;
}

/**
 * Get main User info data
 * @param string $type
 * @param int $page
 * @return array
 */
function get_data_user_info_table($type, $page, $date_from = NULL, $date_to = NULL, $concert_name = NULL, $chosen_nids = NULL) {
  if ($type == 'product') {
    $tid_1 = 1;
    $tid_2 = 1;
  }
  elseif ($type == 'class') {
    $tid_1 = 2;
    $tid_2 = 3;
  }
  else {
    return FALSE;
  }

  $query = ("
    SELECT info.*  , orders.order_total , orders.modified, orders.order_status, product.title, product.data, product.price, product.nid FROM {uc_order_user_info} AS info
    INNER JOIN {uc_orders} AS orders ON  orders.order_id = info.order_id
    LEFT JOIN {uc_order_products} AS product ON product.order_id = info.order_id
    LEFT JOIN {term_node} AS term ON product.nid = term.nid
    WHERE (term.tid = %d OR term.tid = %d)
    AND (orders.order_status = 'payment_received')
    ORDER BY info.order_id
    LIMIT %d,%d;
  ");

  // get user order list info
  $result_table = (db_query($query, $tid_1, $tid_2, 0, 10000));
  //$result_rows = get_total_user_order_rows($tid_1, $tid_2);
  // get all exist produt for filter form
  $all_product_names = get_all_product_type_names($tid_1, $tid_2);

  //if empty $chosen_nids then set by default only exist/active product nids
  if($type == 'product' && (empty($chosen_nids) || count(array_filter($chosen_nids)) === 0)) {
   $chosen_nids = array_filter(array_keys($all_product_names));
  }

  // -----------------------------------------------
  // get all dscounts for order
  $query = ("SELECT  items.title, items.amount,items.type  FROM  uc_order_line_items AS items
    WHERE (items.order_id = %d) AND (items.type = 'oct_discounts');
    ");
  // start collect rows for showing
  $table = array();
  while ($row = db_fetch_array($result_table)) {
    // add discount info
    $discounts = array();
    $discount_result = db_query($query, $row['order_id']);
    while ($discount_row = db_fetch_array($discount_result)) {
      $discounts[] = $discount_row;
    }
    $row['discounts'] = $discounts;
    $table[] = $row;
  }

  $table = filter_date_order_user($table, $type, $date_from, $date_to);
  $table = filter_name_order_user($table, $concert_name, $chosen_nids);

  $result_rows = count($table);
  // -----------------------------------------------
  return array('table' => $table, 'result_rows' => $result_rows, 'all_product_names' => $all_product_names);
}

/**
 *  filter data by date
 */
function filter_date_order_user($unfiltered_rows, $type, $date_from = NULL, $date_to = NULL) {
  $filtered_rows = array();
  foreach ($unfiltered_rows as $key => $row) {
    $data = unserialize($row['data']);
    if ($type == 'product') {
      //get product date
      if (!empty($data['attributes']['Date and time'][0])) {
        $split_date = explode(" ", $data['attributes']['Date and time'][0]);
        $date = $split_date[0];
        $date = str_replace('-', '/', $date);
      }
    }
    elseif ($type == 'class') {
      //get class date
      if (!empty($data['attributes']['Class date'][0])) {
        // byed attribute date
        $full_date = $data['attributes']['Class date'][0];
        $date_split = explode("|", $full_date);
        foreach ($date_split as $key => $val) {
          // search "from date" inside attributes
          $search_dates = explode("-", $val);
          if (!empty($search_dates) && is_array($search_dates)) {
            // if it "from date" (not time or week day)  get it
            $search_date = explode("/", $search_dates[0]);
            if (count($search_date) == 3) {
              $date = $search_dates[0];
            }
          }
        }
      }
    }

    if ((!empty($date_to)) && (!empty($date_from))) {
      if ((strtotime($date_from) <= strtotime($date)) && (strtotime($date) <= strtotime($date_to))) {
        $filtered_rows[] = $row;
      }
    }
    elseif (!empty($date_from)) {
      if (strtotime($date_from) <= strtotime($date)) {
        $filtered_rows[] = $row;
      }
    }
    elseif (!empty($date_to)) {
      if (strtotime($date) <= strtotime($date_to)) {
        $filtered_rows[] = $row;
      }
    }
    else {
      $filtered_rows[] = $row;
    }
  }
  return $filtered_rows;
}

/**
 *  filter data by name
 */
function filter_name_order_user($unfiltered_rows, $concert_name = NULL, $chosen_nids = NULL) {
  $filtered_rows = array();
  /*
  // filter for name
  if(!empty($concert_name)){

    foreach($unfiltered_rows as $row){
      if( strpos($row['title'], $concert_name) != 0){
        $xls[] = $row;
      }
    }
  }*/

  //Another filter by name from consert_name select
  if (!empty($chosen_nids)) {
    if (!empty($unfiltered_rows) && is_array($unfiltered_rows)) {
      foreach ($unfiltered_rows as $row) {
        if (in_array($row['nid'], $chosen_nids)) {
          //apply filter by nid
          $filtered_rows[] = $row;
        }
        elseif (in_array(0, $chosen_nids)) {
          // apply filter "all"
          $filtered_rows[] = $row;
        }
      }
    }
  }
  else {
    // don't apply filter
    $filtered_rows = $unfiltered_rows;
  }

  return $filtered_rows;
}

function get_all_product_type_names($tid_1, $tid_2) {
  $product_names = array(t('All'));
  $query = ("
    SELECT  node_table.title, node_table.nid
    FROM {node} AS node_table
    INNER JOIN {term_node} AS term ON term.nid = node_table.nid
    WHERE node_table.status = 1
    AND node_table.type = 'product'
    AND (term.tid = %d OR term.tid = %d)
    ORDER BY node_table.nid");
  $result_all_prod = db_query($query, $tid_1, $tid_2);
  while ($row = db_fetch_array($result_all_prod)) {
    $product_names += array($row['nid'] => $row['title']);
  }
  return $product_names;
}

function get_total_user_order_rows($tid_1, $tid_2) {
  // count total rows
  $query = ("
    SELECT COUNT(*) AS col_row  FROM {uc_order_user_info} AS info
    LEFT JOIN {uc_order_products} AS product ON product.order_id = info.order_id
    LEFT JOIN {term_node} AS term ON product.nid = term.nid
    LEFT JOIN uc_orders AS orders ON orders.order_id = info.order_id
    WHERE (term.tid = %d OR term.tid = %d)
    AND (orders.order_status = 'payment_received')");
  $result = db_fetch_array(db_query($query, $tid_1, $tid_2));
  return $result['col_row'];
}

/**
 * Export All User info data to xml XML
 * @param string $type
 * @param array $xls
 * @return array Link to exported file
 */
function export_user_info_to_exel($type, $xls) {
  $output = '';
  if (!empty($type)) {
    if ($type == 'product') {
      $filename = 'sites/default/files/user_info_product_export.xlsx';
      $output .= _user_info_xls_export_product($xls, $filename);
      $output .= l(t('Export product'), $filename, array('attributes' => array('class' => 'excel-link'), 'query' => array('t' => time())));
    }
    elseif ($type == 'class') {
      $filename = 'sites/default/files/user_info_class_export.xlsx';
      $output .= _user_info_xls_export_class($xls, $filename);
      $output .= l(t('Export class'), $filename, array('attributes' => array('class' => 'excel-link'), 'query' => array('t' => time())));
    }
  }
  return $output;
}

function export_online_register_to_excel($data) {
  $filename = 'sites/default/files/register_online_export.xlsx';
  _online_register_xls_export($data, $filename);
  $output = l(t('Export data'), $filename, array('attributes' => array('class' => 'excel-link')));
  return $output;
}

function online_register_data() {
  $data = array();
  $query1 = 'SELECT pay.pxid, pay.timestamp, pay.data, online.*
             FROM {pay_activity} AS pay
             LEFT JOIN register_online_data AS online ON online.pxid  =  pay.pxid
             WHERE pay.action = "%s";';
  $result = db_query($query1, "complete");
  $query2 = 'SELECT reg.adults_in_party
             FROM {register_online_adults_on_party} AS reg
             WHERE reg.pxid = %d';
  $query3 = 'SELECT reg.*
             FROM {register_online_checkboxes} AS reg
             WHERE reg.pxid = %d';
  $query4 = 'SELECT reg.children_in_party
             FROM {register_online_childrens_on_party} AS reg
             WHERE reg.pxid = %d';
  while ($row = db_fetch_array($result)) {
    $pxid = $row['pxid'];

    $adults_in_party = array();
    $result2 = db_query($query2, $pxid);
    while ($row2 = db_fetch_array($result2)) {
      $adults_in_party[] = $row2['adults_in_party'];
    }

    $checkbox_amount = array();
    $result3 = db_query($query3, $pxid);
    while ($row3 = db_fetch_array($result3)) {
      $checkbox_amount[] = $row3;
    }

    $children_in_party = array();
    $result4 = db_query($query4, $pxid);
    while ($row4 = db_fetch_array($result4)) {
      $children_in_party[] = $row4['children_in_party'];
    }
    $prev_data = unserialize($row['data']);
    if ($row['pxid']) {
      $data[$row['pxid']] = array('timestamp' => $row['timestamp'], 'data' => $prev_data[0], 'adult_qty' => $row['adult_qty'], 'adress' => $row['adress'], 'children_qty_adult_dinner' => $row['children_qty_adult_dinner'], 'children_qty_children_dinner' => $row['children_qty_children_dinner'], 'contact_name' => $row['contact_name'], 'donate_amount' => $row['donate_amount'], 'email' => $row['email'], 'fax' => $row['fax'], 'handling_fee' => $row['handling_fee'], 'name_company_name' => $row['name_company_name'], 'name_sitter' => $row['name_sitter'], 'phone' => $row['phone'], 'seat_with' => $row['seat_with'], 'sitters_qty_adult_dinner' => $row['sitters_qty_adult_dinner'], 'sitters_qty_children_dinner' => $row['sitters_qty_children_dinner'], 'state' => $row['state'], 'tween_ball_count' => $row['tween_ball_count'], 'coins_price' => $row['coins_price'], 'total_adult_cost' => $row['total_adult_cost'], 'total_attendee_cost' => $row['total_attendee_cost'], 'total_child_cost_adult_dinner' => $row['total_child_cost_adult_dinner'], 'total_child_cost_children_dinner' => $row['total_child_cost_children_dinner'], 'total_cost' => $row['total_cost'], 'total_sitters_cost_adult_dinner' => $row['total_sitters_cost_adult_dinner'], 'total_sitters_cost_children_dinner' => $row['total_sitters_cost_children_dinner'], 'zip' => $row['zip'], 'city' => $row['city'], 'children_in_party' => $children_in_party, 'adults_in_party' => $adults_in_party, 'checkbox_amount' => $checkbox_amount,);
    }
  }
  return theme('online_register_table', $data);
}

/**
 * return error if not enough product
 */
/*
function oct_custom_ajax_check_product_parametr(){
  $aid = $_POST['aid'];
  $query = "SELECT stock.delta FROM uc_product_stock_custom AS stock
  WHERE stock.oid_attribute = %d";
  $result = db_fetch_array(db_query($query, $aid));
  if($result['delta'] <= 0){
    $error = _uc_out_of_stock_get_error('out_of_stock', $nid, $attrs, $stockinfo['stock']);
    print $error;
  }
}*/
/**
 *  Custom page for displaying page coming up. check template php, content appears there
 */
function coming_up_data() {
  return FALSE;
}

/**
 * @param $mlid
 * @return string
 */
function mobile_page_second_level_menu($mlid) {
  $output = '';
  $mobile_menu = menu_tree_all_data('menu-menu-mobile-menu');
  $output = load_recursively_menu($mobile_menu, $mlid, '');
  return $output;
}

/**
 * Custom function to display menu
 */
function load_recursively_menu($menu, $mlid, $rendered) {
  $output = '';
  if (!empty($menu) && (is_array($menu))) {
    foreach ($menu as $key => $value) {
      if (!empty($value['below']) && is_array($value['below'])) {
        if ($value['link']['mlid'] == $mlid) {
          $mobile_menu_deeper_level = render_mobile_menu($value['below']);
          $link_list = theme('child_menu_list', $mobile_menu_deeper_level);
          $output .= theme('child_menu_render', $link_list);
        }
        else {
          $output .= load_recursively_menu($value['below'], $mlid, $rendered);
        }
      }
    }
  }
  return $output;
}

/**
 *  Submittion for uc last form, when amount is free
 */
function free_uc_custom_submittion() {
  //bad code here yeah.

  //after submit, if amout == 0 and user discount, order saved as complited.
  $order_id = $_SESSION['cart_order'];
  if (!empty($order_id)) {
    $items = uc_order_load($order_id);
    $total_amount = 0;
    if (!empty($items->line_items) && is_array($items->line_items)) {
      foreach ($items->line_items as $key => $val) {
        $total_amount += $val['amount'];
      }
    }
    if (($total_amount == 0) && ($_POST['form_id'] == 'uc_paypal_wps_form') && ($items->order_status == 'in_checkout')
    ) {
      // auto decrement qty for free order
      oct_custom_cart_autodecrement_product($order_id);

      /*
      foreach ($items->products as $k => $item) {
        $nid = $item->nid;
        $tid = get_taxonomy_by_nid($nid);
        if (!empty ($tid) && is_array($tid)){
          if(in_array('1',$tid[$nid])){
            // decrement from field "Product"
            if(!empty($item->data['attributes']['Date and time'])){
              $oid = $item->data['values']['Date and time'][0]['oid'];
              if(!empty($item->data['values']['Tickets'])){
                // each qty attributes fields
                foreach($item->data['values']['Tickets'] as $key => $val){
                  $qty = $val['val'];
                  if ($qty > 0){
                    oct_auto_decrement_product_qty($tid[$nid], $qty, $nid, $oid);
                    watchdog('uc_store', ' Apply free order to complete irder_id::' . $order_id . ' "Product" nid:'.$item->nid .' at date: ' . $item->data['attributes']['Date and time'][0] . ' qty:'. $qty);
                  }
                }
              }
            }
          }elseif (in_array('3',$tid[$nid]) || in_array('2',$tid[$nid])){
            // decrement from field "Class"
            if(!empty($item->data['attributes']['Class date'])){
              $oid = $item->data['values']['Class date'][0]['oid'];
              $qty = $item->qty;
              
              oct_auto_decrement_product_qty($tid[$nid], $qty, $nid, $oid);
              watchdog('uc_store', ' Apply free order to complete irder_id::' . $order_id . ' "Class" nid:'.$item->nid .' qty:'.$qty);
            }
          }
        }
      }
      */

      //resave order as complited. without redirect to paypal
      $query = 'UPDATE {uc_orders} AS u_order
            SET u_order.order_status = "%s"
            WHERE u_order.order_id = %d';
      db_query($query, 'completed', $order_id);
      drupal_set_message('Thank you for your submission!');
    }
  }

  // go out from submission 
  $retur_url = $_POST['return'];
  //$retur_url = false;
  if (!empty($retur_url)) {
    drupal_goto($retur_url);
  }
  else {
    drupal_goto('<front>');
  }
}
