<?php

define('CAMPS_SPONSORS_VID', 2);
define('CAMPS_PARTNERS_VID', 3);
define('SITEMAP_NODE', 54);
define('PRODUCTS_TAXONOMY_VID', 1);
define('SPONSORS_NODE', 201);

define('PRODUCTS_TAXONOMY_ID', 1);
define('CLASSES_TAXONOMY_ID', 2);
define('CAMPS_TAXONOMY_ID', 3);

define('FAQ_NID', 72);
define('CLASSES_NID', 17);

define('PRODUCT_THEATRE_PAGE', 'node/19');
define('PRODUCT_TOURING_PAGE', 'node/20');
define('CLASSES_PAGE', 'node/17');
define('CAMPS_PAGE', 'node/104');

/**
 * Implementation of hook_preprocess_page()
 */
function oct_preprocess_page(&$vars) {
    global $user;
    if (!empty($user->uid)) {
        $vars['logged_in'] = true;
    }
    $node = $vars['node'];

//    additional_classes
    $vars['additional_classes'] = array();
    if ($_GET['q'] == 'cart/checkout/complete') {
      $vars['additional_classes'][] = 'checkout_complete';
    }

    $sponsor_node = node_load(SPONSORS_NODE);
    $vars['sponsors'] = node_view($sponsor_node);

    // Send variable mission for all site $custom_mission to page.tpl.php
    $vars['custom_mission'] = variable_get('site_mission', '');

    $vars['oct_primary_links'] = oct_get_primary_menu();

    $vars['page_class'] = 'home-page';
    if (user_is_logged_in ()) {
        $vars['logout_buttons'] = theme('manager_custom_links', array(
            0 => array('path' => 'logout', 'title' => t('Log out')),
            ), 'logout-button');
    }
    if (user_access('manager access')) {
        $vars['manager_buttons'] = theme('manager_custom_links', array(
            array('path' => 'admin/user/user', 'title' => t('Users'), 'no_return' => true),
            array('path' => 'admin/settings/oct_custom', 'title' => t('OCT Config'), 'destination' => 'admin/settings/oct_custom'),
            array('path' => 'admin/discounts', 'title' => t('Discounts'), 'destination' => 'admin/discounts'),
            array('path' => 'admin/store/products', 'title' => t('Products')),
            array('path' => 'admin/store/orders', 'title' => t('Orders'), 'no_return' => true),
            array('path' => 'admin/user-info', 'title' => t('Customers')),
            array('path' => 'admin/online-register/info', 'title' => t('Online Register')),
                ), 'discount-button');
    }
    switch ($node->type) {
        case 'camps':
            $vars['page_class'] = 'camps';
            $vars['top_image'] = '/images/top-img2.png';
            break;
        case 'classes':
            $vars['page_class'] = 'classes';
            $vars['top_image'] = '/images/top-img5.png';
            break;
        case 'products_page':
            $vars['page_class'] = 'productions';
            $vars['top_image'] = '/images/top-img3.png';
            break;
        case 'contact_us_page':
            $vars['page_class'] = 'contact-us';
            $vars['top_image'] = '/images/top-img6.png';
            break;
        case 'fary_tale_ball_page':
            //$vars['page_class'] = 'contact-us';
            $vars['top_image'] = '/images/top-img7.png';
            break;
        case 'about_us_location_page':
            $vars['top_image'] = '/images/top-img4.png';
            break;
        case 'about_us_history_page':
            $vars['top_image'] = '/images/top-img4.png';
            break;
        case 'membership':
            $vars['page_class'] = 'membership';
            break;
        case 'register_online_page':
            $vars['top_image'] = '/images/top-img6.png';
            break;
        case 'product':
        case 'discounts':
            // don't show enybody usual node page
            $arg2 = arg(2);
            if (arg(0) == 'node' && empty($arg2) && ($user->uid != 1)) {
                drupal_goto('<front>');
            }
            break;
        case 'fairy_tale_ball_general_informat':
            break;
        case 'pdf_menu_file':
            if ($user->uid != 1) {
              $vars['tabs'] = '';
            }
            break;
    }
    /*
    if (in_array('page-node-edit', $vars['template_files'])) {
        if ($node->type == 'product') {
            drupal_add_js('Drupal.behaviors.octRadioProductNodeType = function(context) {RadioButtonProductNodeTypeInit(); } ', 'inline');
        }
    }
     */
    if( ( arg(0) == 'admin') && (arg(1) == 'user-info') ){
      $vars['template_files'][] = 'page-admin-big';
      $vars['page_class'] = 'user-info-page';
    }
    if( ( arg(0) == 'admin') && (arg(1) == 'online-register') && (arg(2) == 'info')){
      $vars['template_files'][] = 'page-admin-big';
      $vars['page_class'] = 'user-info-page';
    }
    if (in_array('page-admin-user-info', $vars['template_files'])) {
        $vars['special_wrapper_class'] = ' user-info-wrapper';
    }
    if (in_array('page-about-us-board-of-directors', $vars['template_files'])) {
        $vars['top_image'] = '/images/top-img4.png';
    }
    if (in_array('page-artists', $vars['template_files'])) {
        $vars['top_image'] = '/images/top-img4.png';
    }
    if (in_array('page-about-us-staff', $vars['template_files'])) {
        $vars['top_image'] = '/images/top-img4.png';
    }
    if (in_array('page-about-us', $vars['template_files'])) {
        $vars['top_image'] = '/images/top-img4.png';
    }
    if ($vars['node']->nid == SITEMAP_NODE && $user->uid != 1) {
        $vars['tabs'] = '';
    }
    if (in_array('page-user', $vars['template_files']) && $user->uid != 1) {
        $vars['tabs'] = '';
    }
    if (!in_array('page-cart-checkout-review', $vars['template_files'])){
      unset($_SESSION['uc_discounts_codes']);
    }


    if (in_array('page-enrollment', $vars['template_files'])) {
        //$vars['top_image'] = '/images/top-img4.png';
        $vars['page_class'] = "enrollment";
    }
    if (in_array('page-tickets', $vars['template_files'])) {
        $vars['page_class'] = ' tickets';
    }

    if (in_array('page-calendar', $vars['template_files'])) {
        $vars['page_class'] = ' calendar';
    }

    //Summer camp dates vocabulary edit page
    if (in_array('page-admin-content-taxonomy-9', $vars['template_files'])) {
      $vars['help'] = l('Add week', 'admin/content/taxonomy/9/add/term', array('query' => array('destination' => drupal_get_destination())));

      $vars['tabs'] = '';
    }

    if (in_array('page-prop-room', $vars['template_files'])) {
        if (isset($user->uid) && empty($user->uid)) {
          drupal_goto('user/login', array('destination' => $_GET['q']));
        }
        $vars['page_class'] = ' prop-room';
    }

    if (in_array('page-message-board', $vars['template_files'])) {
      if (isset($user->uid) && empty($user->uid)) {
         drupal_goto('user/login', array('destination' => $_GET['q']));
      }
        $vars['page_class'] = ' message-board';
        $node = new stdClass();
        $node->type = 'message';
        $node->act = 'message';
        module_load_include('inc', 'node', 'node.pages');
        $vars['add_message_form'] = drupal_get_form("message_node_form", $node);
    }

//  $vars['secondary_links'] = phyconbill_get_secondary_menu();
//
//  $vars['footer_info'] = variable_get('phyconbill_footer_info', '');
//  $vars['footer_message'] = variable_get('phyconbill_footer_message', '');
//  $vars['copyright'] = variable_get('phyconbill_copyright', 'Copyright &copy; PhyCon Incorporated');
//
//  switch ($node->nid) {
//    case FREE_AUDIT_NODE_NID:
//      $vars['messages'] = '';
//      break;
//  }
//
//

    if (in_array('page-user', $vars['template_files']) && !in_array('page-user-register', $vars['template_files']) && (!isset($user->uid) || (isset($user->uid) && empty($user->uid)))) {
      $vars['template_files'][] = 'page-user-login';
    }
    

    $vars['node'] = $node;

    $vars['backstage'] = l(t('Psst! Sneak &amp; check out our KIDS ONLY page!'), 'message-board');
}

/**
 * Implementation of hook_preprocess_node()
 */
function oct_preprocess_node(&$variables) {
    global $user;
    $node = $variables['node'];
    switch ($node->type) {
        case 'camps':
            $variables['sponsors'] = _oct_convert_taxonomy_to_string(taxonomy_node_get_terms_by_vocabulary($node, CAMPS_SPONSORS_VID));
            $variables['partners'] = _oct_convert_taxonomy_to_string(taxonomy_node_get_terms_by_vocabulary($node, CAMPS_PARTNERS_VID));
            break;
        case 'classes':
            $variables['classes_list'] = views_embed_view('classes');

            break;
        case 'products_page':
            $variables['products_list'] = views_embed_view('products', 'block_1');
            break;
        case 'products_page_touring':
            $variables['products_list'] = views_embed_view('products', 'block_2');
            break;
        case 'product':
            if (isset($node->taxonomy[1])) {
                $variables['template_files'][] = 'node_product_productions';
            } elseif (isset($node->taxonomy[2])) {
                $variables['template_files'][] = 'node_product_classes';
            } elseif (isset($node->taxonomy[3])) {
                $variables['template_files'][] = 'node_product_classes';
            }

            break;
        case 'friday_fun_night_page':
            $variables['event_list'] = views_embed_view('friday_night_event_view');
            break;
        case 'camps_page':
            $variables['class_list'] = views_embed_view('camps_page_view', 'block_1');
            $variables['camp_list'] = views_embed_view('camps_page_view', 'block_2');
            $variables['summer_camp_list'] = views_embed_view('summer_camps_products');

            drupal_add_js('Drupal.behaviors.chooseWeekSelect = function(context){ jsSelects();}','inline');
            break;
        case 'home_page':
          $list = views_embed_view('homepage_items', 'default');
          $variables['home_page_items_list'] = $list;
          break;
        case 'fairy_tale_ball_general_informat':
          $variables['gen_info_list'] = views_embed_view('general_info_items');
          break;
        case 'register_online_page':
          // first onload show form
          // next steps will be show with ajax
          $options = get_coins_price_list();
          for($i =0; $i <= 10; $i++){
            $options['ticket_qty'][] = $i;
          }
          //this args has in other place too! call_online_registration_form_step_1()
          $options['sub_title'] = $node->field_registr_online_sub_title[0]['value'];
          $options['sub_title_description'] = $node->field_registr_online_sub_descrip[0]['value'];
          $options['online_coins_descr'] = $node->field_registr_online_coins_descr[0]['value'];
          //price => value
          $variables['registration_form'] = drupal_get_form('online_registration_form_step_1', $options);

          //set themed select for form step 1
          drupal_add_js('Drupal.behaviors.changeRegistrationSelect = function(context){ jsSelects();}','inline');
          //count total price form step 1
          drupal_add_js('Drupal.behaviors.changeRegisterOnlinePriceCount = function(context){ countRegistratoinOnlineFormStepOne();}','inline'); ;
          //submit ajax form step 1
          drupal_add_js('Drupal.behaviors.ajaxStepTwoOnlineRegistratonFormSubmit = function(context){ ajaxStepTwoOnlineRegistratonFormSubmit();}','inline'); ;

          break;
        case 'pdf_menu_file':

          // download file
          $path =  $_SERVER['DOCUMENT_ROOT'] . '/' . $node->field_pdf_file[0]['filepath'];
          $filename = $node->field_pdf_file[0]['filename'];
          header("Content-Type: application/pdf");
          header("Content-Length: ".filesize($path));
          header("Content-Disposition: attachment; filename=\"{$filename}\"");
          header('Pragma: no-cache');
          header('Expires: 0');
          readfile($path);
          exit;
          break;
        case 'summer_camp_list_page':
          $variables['summer_camps_list'] = views_embed_view('summer_camp_list');
          break;
        case 'summer_camp_description_page':
          $variables['summer_camps_descr'] = views_embed_view('summer_camp_description');;
          break;
        case 'message':
            if (!$variables['teaser']) {
             drupal_goto('message-board');
           }
          break;
        case 'prop_room_res':
           if (!$variables['teaser']) {
             drupal_goto('prop-room');
           }
          break;
    }

    switch ($variables['node']->nid) {
        case (SITEMAP_NODE):
            $variables['tree'] = menu_tree_all_data($menu_name = 'primary-links');
            break;
        case (FAQ_NID):
            $variables['back_link'] = 'node/' . CLASSES_NID;
            break;
    }
    $variables['node'] = $node;
}

/**
 * Implementation of hook_preprocess_block()
 */
function oct_preprocess_block(&$variables) {

}

/**
 * Implementation of hook_theme().
 */
function oct_theme() {
    return array(
        'menu_item_link_bold' => array(
            'arguments' => array('link' => NULL,)
        ),
       'stretch_title' => array(
            'arguments' => array('title' => NULL,)
        )
    );
}

/**
 * implenettation of theme_stretch_title();
 */
function oct_stretch_title($title){
  if( !empty($title) ){
    $output = '<h2 class="stretch-title" ><span class="stretch-title-bg"><span class="left"></span>' . $title . '<span class="right"></span></span></h2>';
  }
  return $output;
}
/**
 * Get primary links
 * @return string html code with menus
 */
function oct_get_primary_menu() {
    $output = '';
    $primary_links = menu_tree_all_data(variable_get('menu_primary_links_source', 'primary-links'));
    if ($primary_links) {
        $output_links = array();
        $k = 1;
        foreach ($primary_links as $link) {
            if ($link['link']['hidden'] != 1) {
                $ectra_class = ($k > 1) ? 'item' . $k : '';
                $link['link']['localized_options']['attributes']['class'] .= 'sl';
                $item = theme('menu_item_link_bold', $link['link']);
                $ot = _oct_get_submenu($link);
                $submenu = $ot[0];
                !empty($submenu) ? $has_children = true : $has_children = false;
                if (($link['link']['href'] == $_GET['q'] || ($link['link']['href'] == '<front>' && drupal_is_front_page())) || $ot[1]) {
                    $ectra_class .= ' active';
                }
                $output_links[] = theme('menu_item', $item, $has_children, $submenu, $ot[1], $ectra_class);
            }
            $k++;
        }
        if (count($output_links)) {
            $output .= theme('menu_tree', (implode('', $output_links)));
        }
    }
    return $output;
}

/**
 * Get submenu for menu links
 * @param array $links
 * @return array HTML code for links and active status
 */
function _oct_get_submenu($links) {
    $output = '';
    $active = false;

    if ($links['below']) {
        $output_links = array();
        foreach ($links['below'] as $link) {
            if (!$link['link']['hidden']) {
                $ectra_class = '';
                $item = theme('menu_item_link_bold', $link['link']);
                $ot = _oct_get_submenu($link);
                $submenu = $ot[0];
                !empty($submenu) ? $has_children = true : $has_children = false;
                if (($link['link']['href'] == $_GET['q']) || $ot[1]) {
                    $ectra_class .= ' active';
                    $active = true;
                }
                if ($link['link']['href'] == 'node/'.SPONSORSHIP_OPPORTUNITIES_PDF_FILE_NID){
                  if (user_access('manager access')) {
                    $edit = l(t('Edit'), 'node/' . SPONSORSHIP_OPPORTUNITIES_PDF_FILE_NID . '/edit', array('attributes' => array('class' => 'menu-tabs'), 'query' => urlencode(drupal_get_destination()) ));
                  }
                  $output_links[] = theme('menu_item', $item . $edit , $has_children, $submenu, $ot[1], $ectra_class);
                }else{
                  $output_links[] = theme('menu_item', $item, $has_children, $submenu, $ot[1], $ectra_class);
                }
            }
        }
        if (count($output_links)) {
            $output .= theme('menu_tree', (implode('', $output_links)));
        }
    }
    return array($output, $active);
}

function oct_menu_item_link_bold($link) {
    if (empty($link['localized_options'])) {
        $link['localized_options'] = array();
    }
    $link['localized_options']['html'] = true;
    $link['title'] = '<b>' . $link['title'] . '</b>';
    return '<span>' . l($link['title'], $link['href'], $link['localized_options']) . '</span>';
}

/**
 * Convert taxonomy object to string
 * @param array $taxonomy
 * @return string
 */
function _oct_convert_taxonomy_to_string($taxonomy, $delimeter = ', ') {
    $terms = array();
    foreach ($taxonomy as $key => $value) {
        $terms[] = $value->name;
    }
    return implode($delimeter, $terms);
}

function oct_preprocess_views_view_fields__products__block_1(&$variables) {
    $node = node_load($variables['fields']['nid']->raw);

    $dates = array();
    $minDate = null;
    $maxDate = null;
    foreach ($node->field_product_date as $item) {
      if($item['value'] != 0){
        $date = date('l, d F Y - h:ia', strtotime($item['value']));

        if (is_null($minDate)) {
            $minDate = strtotime($item['value']);
        } elseif ($minDate > strtotime($item['value'])) {
            $minDate = strtotime($item['value']);
        }
        if (is_null($maxDate)) {
            $maxDate = strtotime($item['value']);
        } elseif ($maxDate < strtotime($item['value'])) {
            $maxDate = strtotime($item['value']);
        }
        $date = str_replace("-", "@", $date);
        if (!empty($item['value2'])) {
            if (($item['value']) != ($item['value2'])) {
                $date .= ' - ' . date('h:ia', strtotime($item['value2']));
            }
        }
        $dates[] = $date;
      }
    }
    if ($minDate == $maxDate) {
        $maxDate = '';
    }
    $variables['product_dates'] = $dates;
    if (!empty($minDate)) {
        $variables['min_date'] = date('F d, Y ', $minDate);
    }
    if (!empty($maxDate)) {
        $variables['max_date'] = date('F d, Y ', $maxDate);
    }
}

/**
 * @ingroup themeable
 * @see uc_cart_view_form()
 */
function oct_uc_cart_view_form($form) {
    //drupal_add_css(drupal_get_path('module', 'uc_cart') .'/uc_cart.css');
    $output = '<div id="content-inner">
                <div id="content-bot">
                  <div id="content-area">
                    <div id="cart-form-products">' .
                      drupal_render($form['items']) .
                    '</div>';
    $output .=      '<div id="cart-form-buttons">' .
                      drupal_render($form) .
                    '</div>';
    $output .=    '</div>
                </div>
              </div>';

    foreach (element_children($form['items']) as $i) {
        foreach (array('title', 'options', 'remove', 'image', 'qty') as $column) {
            $form['items'][$i][$column]['#printed'] = TRUE;
        }
        $form['items'][$i]['#printed'] = TRUE;
    }


    // Add the continue shopping element and cart submit buttons.
    /*
      if (($type = variable_get('uc_continue_shopping_type', 'link')) != 'none') {
      // Render the continue shopping element into a variable.
      $cs_element = drupal_render($form['continue_shopping']);

      // Add the element with the appropriate markup based on the display type.
      if ($type == 'link') {
      $output .= '<div id="cart-form-buttons"><div id="continue-shopping-link">'
      . $cs_element .'</div>'. drupal_render($form) .'</div>';
      }
      elseif ($type == 'button') {
      $output .= '<div id="cart-form-buttons"><div id="update-checkout-buttons">'
      . drupal_render($form) .'</div><div id="continue-shopping-button">'
      . $cs_element .'</div></div>';
      }


      }
      else {
      }
     */
    return $output;
}

function oct_preprocess_product_tickets_page(&$vars) {
    $vars['node_ticket'] = arg(1);
    if (!empty($vars['node_ticket'])) {
        $vars['product_list'] = oct_custom_get_all_product();
        $node = node_load($vars['node_ticket']);
        $vars['add_to_cart_form'] = drupal_get_form('uc_product_add_to_cart_form', $node);
        $vars['node'] = $node;
    }
}

/**
 * Implementation theme_fieldset()
 */
function oct_fieldset($element) {
    $element[1]['#default_value'] = 3;
    $element[2]['#default_value'] = 3;
    $element[1]['#value'] = 3;
    $element[2]['#value'] = 3;

    global $user;
    if (!empty($element['#collapsible'])) {
        drupal_add_js('misc/collapse.js');

        if (!isset($element['#attributes']['class'])) {
            $element['#attributes']['class'] = '';
        }

        $element['#attributes']['class'] .= ' collapsible';
        //if element Input format
        if (!empty($element['#parents'])) {
            if (in_array('format', $element['#parents']) && ($user->uid != 1)) {
                $element['#attributes']['class'] .= ' hidden';
            }
        }
        if (!empty($element['#collapsed'])) {
            $element['#attributes']['class'] .= ' collapsed';
        }
    }
    return '<fieldset' . drupal_attributes($element['#attributes']) . '>' . ($element['#title'] ? '<legend>' . $element['#title'] . '</legend>' : '') . (isset($element['#description']) && $element['#description'] ? '<div class="description">' . $element['#description'] . '</div>' : '') . (!empty($element['#children']) ? $element['#children'] : '') . (isset($element['#value']) ? $element['#value'] : '') . "</fieldset>\n";
}

function oct_uc_attribute_add_to_cart($form) {
    //$form['#attributes'] = array('class' => 'mine');

    if (!empty($form[5])) {
        //class
        $output = '<div class="attributes">';
        $stripes = array('even' => 'odd', 'odd' => 'even');
        $parity = 'even';
        foreach (element_children($form) as $aid) {
            $parity = $stripes[$parity];
            $classes = array('attribute', 'attribute-' . $aid, $parity);
            $output .= '<div class="' . implode(' ', $classes) . '">';
            $output .= drupal_render($form[$aid]);
            $output .= '</div>';
        }
        $output .= drupal_render($form) . '</div>';
        return $output;
    } elseif (!empty($form[2])) {
        //product

        foreach (element_children($form) as $aid) {
            $classes = array('attribute', 'attribute-' . $aid);
            $output .= drupal_render($form[$aid]);
        }
        $output .= drupal_render($form);

        return $output;
    }
}

function oct_uc_quantity_grid($element) {
    $class = 'form-uc-attribute-quantity-grid';
    if (isset($element['#attributes']['class'])) {
        $class .= ' ' . $element['#attributes']['class'];
    }
    if (!empty($element['#value']['#location'])) {
        $description = '<h3>Location</h3>' . $element['#value']['#location'];
    }
    $element['#children'] = $description . '<table class="' . $class . '">
      <tbody>
        <tr class="header">
          <th class="first">' . t('TICKETS') . '</th>
          <th>' . t('PRICE') . '</th>
          <th>' . t('QUANTITY') . '</th>
        </tr>' .
            (!empty($element['#children']) ? $element['#children'] : '') .
            '</tbody></table>';
    return $element['#children'];
}

function oct_uc_quantity_grid_textfield($element) {
    $id = $element['#parents'][2];
    $class = array('form-text');
    _form_set_class($element, $class);

    if (!empty($element['#title'])) {
        $title = $element['#title'];
        $output.='<tr>';
        $output.= '<td>';
        $output.= t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required));
        $output.= '</td>';
    }
    $output .= '<td>' . variable_get('uc_currency_sign', '$') . ' ' . number_format($element['#ahah']['#price'][$id], 2, '.', '') . '</td>';
    $output .= '<td>';

    if ($id == 54) {
        $output .= '<span class="free-adult" >0</span><input type="hidden" name="' . $element['#name'] . '" " id="' . $element['#id'] . '" value="0">';
    } else {
        $output .= '<select class="enrollment-select" name="' . $element['#name'] . '" id="' . $element['#id'] . '" ' . drupal_attributes($element['#attributes']) . ' >';
        if (!empty($element['#ahah']['#min_val'][$id])) {
            $i = $element['#ahah']['#min_val'][$id];
        } else {
            $i = 1;
        }
        $output .= '<option value="0" selected="selected">0</option>';
        for ($i; $i <= $element['#ahah']['#max_val'][$id]; $i++) {
            $output .= '<option value="' . $i . '" > ' . $i . '</option>';
        }
        $output .= '</select>';
    }
    $output .= '</td>';
    $output .= '<tr>';

    return $output;
}

function oct_content_view_multiple_field($items, $field, $values) {
    $output = '';
    switch ($field['field_name']) {
        case 'field_sponsors_list':
            foreach ($items as $value) {
                $output .= '<li><a onclick="return false;" href="#">' . $value . '</a></li>';
            }
            break;
        default:
            $output = implode(", ", $items);
            break;
    }

    return $output;
}

function oct_filefield_icon($file) {
    return '';
}

function oct_preprocess_calendar_month_node(&$vars) {
    oct_preprocess_calendar_node($vars);
}

function oct_preprocess_calendar_node(&$vars) {
    $node = $vars['node'];
    $view = $vars['view'];
    $fields = array();
    foreach ($view->field as $name => $field) {
        // Some fields, like the node edit and delete links, have no alias.
        $field_alias = $field->field_alias != 'unknown' ? $field->field_alias : $name;
        if (!empty($node->$field_alias)) {
            $data = $node->$field_alias;
            $label = $field->options['label'];

            // CCK has some special label options.
            if (!empty($field->content_field)) {
                switch ($field->options['label_type']) {
                    case 'none':
                        $label = '';
                        break;
                    case 'widget':
                        $label = $field->content_field['widget']['label'];
                        break;
                }
            }
            $fields[$field_alias] = array(
                'id' => views_css_safe($field_alias),
                'label' => $label,
                'data' => $data,
            );
        }
    }
    $vars['fields'] = $fields;
    $vars['calendar_start'] = $node->calendar_start;
    $vars['calendar_end'] = $node->calendar_end;
    $vars['calendar_start_date'] = $node->calendar_start_date;
    $vars['calendar_end_date'] = $node->calendar_end_date;

    // We added the node type to the results in the query,
    // but it will show up as $node->node_type instead of
    // $node->type. Rename it to match the normal way it
    // would show up on a node object.
    $vars['node']->type = $vars['node']->node_type;

    $class = '';
    switch ($node->type) {
        case 'product':
            $node_full = node_load($node->nid);
            $terms = array_values(taxonomy_node_get_terms_by_vocabulary($node_full, PRODUCTS_TAXONOMY_VID));
            switch ($terms[0]->tid) {
                case PRODUCTS_TAXONOMY_ID:  // tickets
                    $class = 'link1';
                    break;
                case CLASSES_TAXONOMY_ID:
                case CAMPS_TAXONOMY_ID:     // classes
                    $class = 'link2';
                    break;
            }
            break;

        case 'fun_night_event':
            $class = 'link3';
            break;
        case 'calendar_event':
            $class = 'link5';
            break;
    }
    if ($node->type != 'calendar_event'){
      $nid = $node->nid;
      $tid = get_taxonomy_by_nid($nid);
      if (!empty ($tid) && is_array($tid)){
        if(in_array('1',$tid[$nid])){
          $vars['title'] = l($node->raw->node_title, 'tickets/' . $node->nid, array('attributes' => array('class' => $class)));
        }elseif (in_array('3',$tid[$nid]) || in_array('2',$tid[$nid])){
          $vars['title'] = l($node->raw->node_title, 'enrollment/' . $node->nid, array('attributes' => array('class' => $class)));
        }
      }
    }else{
      if (user_access('manager access')) {
        $link_edit = l(t('Edit'), 'node/' . $node->nid . '/edit', array('attributes' => array('class' => "custom-edit-node-button"), 'query' => drupal_get_destination()));
      }
      $vars['title'] = $link_edit.'<span class="' . $class . '">' . $node->raw->node_title . '</span>';
    }
}

function oct_preprocess_views_view_table__products__page_1(&$vars) {
    // generate xml here
    //$themed_rows = array_merge(array($header), $themed_rows);
    $themed_rows = $vars['rows'];

    foreach ($themed_rows as $key => $val) {
        unset($themed_rows[$key]['edit_node']);
        unset($themed_rows[$key]['delete_node']);
    }
    $file_name = 'sites/default/files/product.xlsx';
    export_array_to_xls($themed_rows, $file_name);
    $vars['url_file_xls'] = $file_name;
}

/**
 * theme_uc_cart_checkout_review()
 * @param array $panes
 * @param string $form
 * @return string
 */
function oct_uc_cart_checkout_review($panes, $form) {

  /*
    // get all order
    $order = uc_order_load($_SESSION['cart_order']);
    $total = 0;

    // get subtotal and fee
    foreach ($order->line_items as $item) {
        switch ($item['type']) {
            case 'subtotal':
            case 'fee':
                $total += $item['amount'];
                break;
        }
    }
    // add our discount
    $errors = array();
    $warnings = array();
    $messages = array();
    if(!empty($_SESSION['uc_discounts_codes'])){
      $codes = $_SESSION['uc_discounts_codes'];
    }
    $discounts = get_all_discount($order, $errors, $warnings, $messages, $codes);

    $total_discount_amount = 0;
    if (is_array($discounts)) {
        foreach ($discounts as $discount)
            $total_discount_amount += $discount['amount'];
    }

    $total += $total_discount_amount;
    // END this code should be rewrite Alexandr Ilivanov
    // replace standart price;
    $context = array(
        'revision' => 'themed-original',
        'type' => 'amount',
    );
    $new_panes = array();
    if (isset($panes['Cart contents']) && is_array($panes['Cart contents'])) {
        $new_panes['Cart contents'] = $panes['Cart contents'];
    }
    if (isset($panes['Payment method']) && is_array($panes['Payment method'])) {
        foreach ($panes['Payment method'] as $key => $value) {
            if ($value['title'] == 'Total') {
                //$new_panes['Payment method'][] = array('title' => 'Discount', 'data' => uc_price($total_discount_amount, $context));
                $new_panes['Payment method'][] = array('title' => 'Total', 'data' => uc_price($total, $context));
            }else{
                $new_panes['Payment method'][] = $value;
            }
        }
    }
   */
    drupal_add_css(drupal_get_path('module', 'uc_cart') . '/uc_cart.css');
    $output = '<div id="content-inner">
                <div id="content-bot">
                  <div id="content-area">';

    $output .= check_markup(variable_get('uc_checkout_review_instructions', uc_get_message('review_instructions')), variable_get('uc_checkout_review_instructions_format', FILTER_FORMAT_DEFAULT), FALSE)
            . '<table class="order-review-table">';

    foreach ($panes as $title => $data) {
        $output .= '<tr class="pane-title-row"><td colspan="2">' . $title
                . '</td></tr>';
        if (is_array($data)) {
            foreach ($data as $row) {
                if (is_array($row)) {
                    if (isset($row['border'])) {
                        $border = ' class="row-border-' . $row['border'] . '"';
                    } else {
                        $border = '';
                    }
                    $output .= '<tr valign="top"' . $border . '><td class="title-col" '
                            . 'nowrap>' . $row['title'] . ':</td><td class="data-col">'
                            . $row['data'] . '</td></tr>';
                } else {
                    $output .= '<tr valign="top"><td colspan="2">' . $row . '</td></tr>';
                }
            }
        } else {
            $output .= '<tr valign="top"><td colspan="2">' . $data . '</td></tr>';
        }
    }

    $output .= '<tr class="review-button-row"><td colspan="2">' . $form
            . '</td></tr></table>';

    $output .= '</div>
            </div>
          </div>';
    return $output;
}

function oct_preprocess_views_view_fields__summer_camps_products(&$vars) {
    $vars['fields']['date_from'] = split(',', $vars['fields']['field_class_date_from_value']->content);
    $vars['fields']['date_to'] = split(',', $vars['fields']['field_class_date_to_value']->content);
    $vars['fields']['time_from'] = split(',', $vars['fields']['field_class_time_from_value']->content);
    $vars['fields']['time_to'] = split(',', $vars['fields']['field_class_time_to_value']->content);
    $vars['fields']['no_date'] = split(',', $vars['fields']['field_class_no_dates_value']->content);
}

function oct_preprocess_views_view_fields__camps_page_view__block_1(&$vars) {
    $vars['fields']['date_from'] = split(',', $vars['fields']['field_class_date_from_value']->content);
    $vars['fields']['date_to'] = split(',', $vars['fields']['field_class_date_to_value']->content);
    $vars['fields']['time_from'] = split(',', $vars['fields']['field_class_time_from_value']->content);
    $vars['fields']['time_to'] = split(',', $vars['fields']['field_class_time_to_value']->content);
    $vars['fields']['no_date'] = split(',', $vars['fields']['field_class_no_dates_value']->content);
}

function oct_preprocess_views_view_fields__camps_page_view__block_2(&$vars) {
    $vars['fields']['date_from'] = split(',', $vars['fields']['field_class_date_from_value']->content);
    $vars['fields']['date_to'] = split(',', $vars['fields']['field_class_date_to_value']->content);
    $vars['fields']['time_from'] = split(',', $vars['fields']['field_class_time_from_value']->content);
    $vars['fields']['time_to'] = split(',', $vars['fields']['field_class_time_to_value']->content);
    $vars['fields']['no_date'] = split(',', $vars['fields']['field_class_no_dates_value']->content);
}
/**
 * Implementation theme__uc_product_attributes()
 * @param <type> $element
 * @return <type>
 */
function oct_uc_product_attributes($element) {
  $product = $element['#product']['#value'];
  $option_rows = array();

  foreach (element_children($element) as $key) {
    $optionstr = '';
    foreach ((array) $element[$key]['#options'] as $option_key => $option) {
      // --------- patch ----------
      if( is_array( $option ) && !empty( $option['name'] )){
        // old. for cart product arrtibutes
        $append = $option['name'];
      }else{
        // set attribute values on order info page;
        $option_name = $element[$key]['#attribute_name'];
        $append = '<p>' . $element['#product']['#value']->data['attributes'][$option_name][$option_key] . '</p>';
        if($element['#product']['#value']->data['values'][$option_name][$option_key]['val'] > 0){
          $append = '<p><b>' . $element['#product']['#value']->data['attributes'][$option_name][$option_key] . ' x ' . $append = $element['#product']['#value']->data['values'][$option_name][$option_key]['val'] . '</b></p>';
        }
        // Show quantity for grid
      }
      // ------- end patch --------
      if ($element[$key]['#display'] == 4) {
        $context['type'] = 'amount';
        $context['subject']['node'] = $product;
        $price_info = array(
            'price' => $element[$key]['#options'][$option_key]['price_each'],
            'qty' => 1,
        );
        if ( $element[$key]['#options'][$option_key]['quantity'] > 0 ){
          $append = '<p>'.t('@qty&times;', array('@qty' => $element[$key]['#options'][$option_key]['quantity'])) . ' ' . $option['name'] . ' (' . uc_price($price_info, $context) . ' ' . t('each') . ')</p>';
        }else{
          $append =  '';
        }
      }


      // We only need to allow translation from the second option onward
      if (empty($optionstr)) {
        $optionstr .= $append;
      } else {
          $optionstr .= t('!option', array('!option' => $append));
      }
    }
    $option_rows[$key] = t('@attribute: !option', array('@attribute' => $element[$key]['#attribute_name'], '!option' => $optionstr));
  }

  if (!empty($option_rows)) {
    return theme('item_list', array_values($option_rows), NULL, 'ul', array('class' => 'product-description'));
  }

  return '';
}

/**
 * Preprocess a formatted invoice with an order's data.

function template_preprocess_uc_order(&$variables) {

  $variables['thank_you_message'] = FALSE;

  switch ($variables['op']) {
    case 'checkout-mail':
      $variables['thank_you_message'] = TRUE;
    case 'admin-mail':
      $variables['help_text'] = TRUE;
      $variables['email_text'] = TRUE;
      $variables['store_footer'] = TRUE;
    case 'view':
    case 'print':
      $variables['business_header'] = TRUE;
      $variables['shipping_method'] = TRUE;
      break;
  }

  $variables['products'] = $variables['order']->products;
  if (!is_array($variables['products'])) {
    $variables['products'] = array();
  }

  $variables['line_items'] = $variables['order']->line_items;
  $items = _line_item_list();
  foreach ($items as $item) {
    if (isset($item['display_only']) && $item['display_only'] == TRUE) {
      $result = $item['callback']('display', $variables['order']);
      if (is_array($result)) {
        foreach ($result as $line) {
          $variables['line_items'][] = array(
            'line_item_id' => $line['id'],
            'title' => $line['title'],
            'amount' => $line['amount'],
            'weight' => $item['weight'],
            'data' => $item['data'],
          );
        }
      }
    }
  }
  if (!is_array($variables['line_items'])) {
    $variables['line_items'] = array();
  }
  usort($variables['line_items'], 'uc_weight_sort');

  $types = array(
    'order' => $variables['order'],
  );

  $full = new stdClass();
  $full->tokens = $full->values = array();
  foreach ($types as $type => $object) {
    $temp = token_get_values($type, $object, FALSE, $options);
    $full->tokens = array_merge($full->tokens, $temp->tokens);
    $full->values = array_merge($full->values, $temp->values);
  }

  foreach ($full->tokens as $key => $token) {
    $value = $full->values[$key];
    $variables[str_replace('-', '_', $token)] = $value;
  }

  // Add template file suggestions, default to customer template.
  $variables['template_files'] = array(
    'uc_order-customer',
    'uc_order-'. $variables['template'],
  );
}
*/

/**
 * Theme the subqueue overview as a sortable list.
 *
 * @ingroup themeable
 */
function oct_nodequeue_arrange_subqueue_form($form) {
  $output = '';

  $subqueue = $form['#subqueue'];

  // get css to hide some of the help text if javascript is disabled
  drupal_add_css(drupal_get_path('module', 'nodequeue') .'/nodequeue.css');

  // TODO: Would be nice to expose qid, sqid, reference as classes for more custom theming :).
  // TODO: Create unique ID to make multiple tabledrag forms on a page possible
  drupal_add_tabledrag('nodequeue-dragdrop', 'order', 'sibling', 'node-position');
  drupal_add_js(drupal_get_path('module', 'nodequeue') .'/nodequeue_dragdrop.js');

  drupal_add_js(array('nodequeue' => array('reverse' => (bool) $form['#queue']['reverse'])), 'setting');

  // render form as table rows
  $rows = array();
  $counter = 1;
  $first_header = t('Title');
  foreach (element_children($form) as $key) {
    if (isset($form[$key]['title'])) {
      $row = array();
      //-------------------------- patch ---------------------------------
      if ($form['#queue']['qid'] == GENERAL_INFO_ITEMS_QID){
        $first_header = t('Image');
        unset($form[$key]['title']);
        $nid = $form[$key]['#node']['nid'];
        $node = node_load($nid);
        $row[] = theme( 'imagecache', 'fairy_tale_general_info_small', $node->field_general_info_image[0]['filepath'] );
      }else{
        $row[] = drupal_render($form[$key]['title']);
      }
      //------------------------------------------------------------------
      $row[] = drupal_render($form[$key]['author']);
      $row[] = drupal_render($form[$key]['date']);
      $row[] = drupal_render($form[$key]['position']);
      $row[] = drupal_render($form[$key]['edit']);
      $row[] = drupal_render($form[$key]['remove']);
      $row[] = array(
        'data' => $counter,
        'class' => 'position'
      );

      $rows[] = array(
        'data'  => $row,
        'class' => 'draggable',
      );
    }
    $counter++;
  }

  if (empty($rows)) {
    $rows[] = array(array('data' => t('No nodes in this queue.'), 'colspan' => 7));
  }

  // render the main nodequeue table


  $header = array($first_header, t('Author'), t('Post Date'), t('Position'), array('data' => t('Operations'), 'colspan' => 2), t('Position'));
  $output .= theme('table', $header, $rows, array('id' => 'nodequeue-dragdrop', 'class' => 'nodequeue-dragdrop'));

  // render the autocomplete field for adding a node to the table
  $output .= '<div class="container-inline">';
  $output .= drupal_render($form['add']['nid']);
  $output .= drupal_render($form['add']['submit']);
  $output .= '</div>';

  // render the remaining form elements
  $output .= drupal_render($form);
  return $output;
}


/**
 * Implementation of theme_form_element();
 * Return a themed form element.
 */
function oct_form_element($element, $value) {
  $output = '';
   $special_fields = array(
    'online_registration_adult_qty',
    'online_registration_total_adult_cost',
    'online_registration_children_qty_children_dinner',
    'online_registration_total_child_cost_children_dinner',
    'online_registration_children_qty_adult_dinner',
    'online_registration_total_child_cost_adult_dinner',
    'online_registration_sitters_qty_children_dinner',
    'online_registration_total_sitters_cost_children_dinner',
    'online_registration_sitters_qty_adult_dinner',
    'online_registration_total_sitters_cost_adult_dinner',
    'online_registration_coins',
    'online_registration_tweenball',
    'online_registration_total_cost',
    'online_registration_handling_fee',
    'online_registration_total_attendee_cost',
    'online_registration_checkbox',
    'online_registration_total_coins_cost',
    'online_registration_total_tweenball_cost',
  );
  if ( in_array($element['#array_parents'][0], $special_fields) ){
    $t = get_t();

    $output = '<div class="form-item"';
    if (!empty($element['#id'])) {
      $output .= ' id="'. $element['#id'] .'-wrapper"';
    }
    $output .= ">\n";
    $required = !empty($element['#required']) ? '<span class="form-required" title="'. $t('This field is required.') .'">*</span>' : '';

    $output .= $element['#description'];
    $output .= " $value\n";

    if (!empty($element['#title'])) {
      $title = $element['#title'];
      if (!empty($element['#id'])) {
        $output .= ' <label for="'. $element['#id'] .'">'. $t('!title !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
      }
      else {
        $output .= ' <label>'. $t('!title !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
      }
    }

    if (!empty($element['#description'])) {
      $output .= ' <div class="description">'. $element['#description'] ."</div>\n";
    }
    $output .= "</div>\n";
    return $output;
  }else{
  // defdault
  // This is also used in the installer, pre-database setup.
    $t = get_t();

    $output = '<div class="form-item"';
    if (!empty($element['#id'])) {
      $output .= ' id="'. $element['#id'] .'-wrapper"';
    }
    $output .= ">\n";
    $required = !empty($element['#required']) ? '<span class="form-required" title="'. $t('This field is required.') .'">*</span>' : '';

    if (!empty($element['#title'])) {
      $title = $element['#title'];
      if (!empty($element['#id'])) {
        $output .= ' <label for="'. $element['#id'] .'">'. $t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
      }
      else {
        $output .= ' <label>'. $t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
      }
    }

    $output .= " $value\n";

    if (!empty($element['#description'])) {
      $output .= ' <div class="description">'. $element['#description'] ."</div>\n";
    }
    $output .= "</div>\n";
    return $output;
  }
}

/**
 * Theme an individual form element.
 *
 * Combine multiple values into a table with drag-n-drop reordering.
 */
function oct_content_multigroup_node_form($element) {
  $group_name = $element['#group_name'];
  $groups = fieldgroup_groups($element['#type_name']);
  $group = $groups[$group_name];
  $group_multiple = $group['settings']['multigroup']['multiple'];
  $group_fields = $element['#group_fields'];

  $table_id = $element['#group_name'] .'_values';
  $table_class = 'content-multiple-table';
  $order_class = $element['#group_name'] .'-delta-order';
  $subgroup_settings = isset($group['settings']['multigroup']['subgroup']) ? $group['settings']['multigroup']['subgroup'] : array();
  $show_label = isset($subgroup_settings['label']) ? $subgroup_settings['label'] : 'above';
  $subgroup_labels = isset($group['settings']['multigroup']['labels']) ? $group['settings']['multigroup']['labels'] : array();
  $multiple_columns = isset($group['settings']['multigroup']['multiple-columns']) ? $group['settings']['multigroup']['multiple-columns'] : 0;

  $headers = array();
  if ($group_multiple >= 1) {
    $headers[] = array('data' => '');
  }
  if ($multiple_columns) {
    foreach ($group_fields as $field_name => $field) {
      $required = !empty($field['required']) ? '&nbsp;<span class="form-required" title="'. t('This field is required.') .'">*</span>' : '';
      $headers[] = array(
        'data' => check_plain(t($field['widget']['label'])) . $required,
        'class' => 'content-multigroup-cell-'. str_replace('_', '-', $field_name),
      );
    }
    $table_class .= ' content-multigroup-edit-table-multiple-columns';
  }
  else {
    if ($group_multiple >= 1) {
      $headers[0]['colspan'] = 2;
    }
    $table_class .= ' content-multigroup-edit-table-single-column';
  }
  if ($group_multiple >= 1) {
    $headers[] = array('data' => t('Order'), 'class' => 'content-multiple-weight-header');
    if ($group_multiple == 1) {
      $headers[] = array('data' => '<span>'. t('Remove') .'</span>', 'class' => 'content-multiple-remove-header');
    }
  }
  $rows = array();

  $i = 0;
  foreach (element_children($element) as $delta => $key) {
    if (is_numeric($key)) {
      $cells = array();
      $label = ($show_label == 'above' && !empty($subgroup_labels[$i]) ? theme('content_multigroup_node_label', check_plain(t($subgroup_labels[$i]))) : '');
      $element[$key]['_weight']['#attributes']['class'] = $order_class;
      if ($group_multiple >= 1) {
        $cells[] = array('data' => '', 'class' => 'content-multiple-drag');
        $delta_element = drupal_render($element[$key]['_weight']);
        if ($group_multiple == 1) {
          $remove_element = drupal_render($element[$key]['_remove']);
        }
      }
      else {
        $element[$key]['_weight']['#type'] = 'hidden';
      }
      if ($multiple_columns) {
        foreach ($group_fields as $field_name => $field) {
          $cell = array(
            'data' => (isset($element[$key][$field_name]) ? drupal_render($element[$key][$field_name]) : ''),
            'class' => 'content-multigroup-cell-'. str_replace('_', '-', $field_name),
          );
          if (!empty($cell['data']) && !empty($element[$key][$field_name]['#description'])) {
            $cell['title'] = $element[$key][$field_name]['#description'];
          }
          $cells[] = $cell;
        }
      }
      else {
        //$cells[] = $label . drupal_render($element[$key]);
        $content = '';
        foreach ($element[$key] as $k => $elem){
          if (!empty( $elem['#type']) && is_array( $elem ) ){
            $prefix = '';
            $suffix = '';
            if (!empty($element['#group_fields'][$k])){
              $prefix = $element['#group_fields'][$k]['prefix'];
              $suffix = $element['#group_fields'][$k]['suffix'];
            }
            $content .= $prefix . drupal_render($element[$key][$k]) . $suffix;
          }
        }
        $cells[] = $content;
      }
      if ($group_multiple >= 1) {
        $row_class = 'draggable';
        $cells[] = array('data' => $delta_element, 'class' => 'delta-order');
        if ($group_multiple == 1) {
          if (!empty($element[$key]['_remove']['#value'])) {
            $row_class .= ' content-multiple-removed-row';
          }
          $cells[] = array('data' => $remove_element, 'class' => 'content-multiple-remove-cell');
        }
        $rows[] = array('data' => $cells, 'class' => $row_class);
      }
      else {
        $rows[] = array('data' => $cells);
      }
    }
    $i++;
  }

  drupal_add_css(drupal_get_path('module', 'content_multigroup') .'/content_multigroup.css');
  $output = theme('table', $headers, $rows, array('id' => $table_id, 'class' => $table_class));
  $output .= drupal_render($element[$group_name .'_add_more']);

  // Enable drag-n-drop only if the group really allows multiple values.
  if ($group_multiple >= 1) {
    drupal_add_tabledrag($table_id, 'order', 'sibling', $order_class);
    drupal_add_js(drupal_get_path('module', 'content') .'/js/content.node_form.js');
  }

  return $output;
}


/**
	 * Process variables to format email messages.
	 *
	 * @see htmlmail.tpl.php
	 */
function oct_preprocess_htmlmail(&$variables) {
	  // Run the default preprocess function.
	  template_preprocess_htmlmail($variables);

	  // Use the 'HTML Email' text format for the message body.
	  $variables['body'] = check_markup($variables['body'], 'html_email');
	}