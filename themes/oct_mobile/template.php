<?php
define('SPONSORS_LIST', 153);
/**
 *  Implementation of hook_preprocess_page()
 */
function oct_mobile_preprocess_page($vars)
{
  //$vars['back_link'] = "<a href='#' onClick='history.go(-1)'></a>";

  // show it only 3 sec and hide;
  if (!$_COOKIE["sponsor_showed"]) {
    $vars['sponsor'] = theme('sponsor_page', '/images/oct_mobile_sponsor_1_allied_arts.png');
    $vars['classes'] .= 'sponsor-bg';
    setcookie("sponsor_showed", true, time() + 15);
  }

  if ($vars['is_front']) {
    $vars['sponsors_slider'] = '';
    $vars['title'] = t('Home');
    $vars['head_title'] = $vars['title'] . ' | ' . $vars['site_name'];
    drupal_add_css(path_to_theme() . '/css/home.css', 'theme', 'all', false);
    //$vars['css'] = drupal_add_css();
    $vars['styles'] = drupal_get_css();

    $mobile_menu = menu_tree_all_data('menu-menu-mobile-menu');
    $menu = render_mobile_menu($mobile_menu);

    $link_list = theme('main_menu_list', $menu);
    $vars['mobile_menu'] = theme('item_list', $link_list, NULL, 'ul', array('class' => 'home-mobile-menu'));
    $sponsors_node = node_load(SPONSORS_LIST);
    if (!empty($sponsors_node->field_sponsors_list)) {
      foreach ($sponsors_node->field_sponsors_list as $k => $v) {
        $list[$k] = '<p>' . $v['value'] . '</p>';
      }
      $vars['sponsors_slider'] = theme('item_list', $list);
    }

  }

  switch ($vars['node']->type) {
    case 'contact_us_page':
      $vars['page_class'] = ' contact';
      $vars['page_title'] = 'Contact Us';
      break;
    case 'camps_page':
      $vars['page_class'] = ' camps';
      $vars['page_title'] = 'Camps';
      break;
    case 'friday_fun_night_page':
      $vars['page_class'] = ' friday';
      $vars['page_title'] = 'Friday Fun Night';
      break;
    case 'classes':
      $vars['page_class'] = ' classes';
      $vars['page_title'] = 'Classes';
      break;
    case 'fairy_tale_ball_general_informat':
      $vars['page_class'] = ' ftb';
      $vars['page_title'] = 'Fairy Tale Ball';
      break;
    case 'products_page':
      $vars['page_class'] = ' productions';
      $vars['page_title'] = 'Productions';
      break;
    case 'membership':
      $vars['page_class'] = ' member';
      $vars['page_title'] = 'Be A Member';
      break;
    case 'about_us_history_page':
      $vars['page_class'] = ' history';
      $vars['page_title'] = 'History';
      break;
    case 'products_page_touring':
      $vars['page_class'] = ' productions';
      $vars['page_title'] = 'Productions';
      break;
  }

  $mobile_menu = menu_tree_all_data('menu-menu-mobile-menu');

  switch ($_GET['q']) {
    case 'about-us':
      $vars['page_title'] = 'About Us';
      break;
    case 'about-us/board-of-directors':
      $vars['page_title'] = 'Board of Directors';
      break;
    case 'about-us/staff':
      $vars['page_title'] = 'Staff';
      break;
    case 'fairy-tale-ball/auction-items':
      $vars['page_title'] = 'Auction items';
      break;
  }
  if (in_array('page-coming-up', $vars['template_files'])) {
    $vars['page_class'] = ' classes';
    $vars['page_title'] = $vars['title'];
    //$home_node = node_load(143);
    //$vars['content'] = '<div class="middle-item first"><div class="middle-content">' . $home_node->body . '</div></div>';
    $vars['content'] = views_embed_view('homepage_items', 'default');
  }
  if (in_array('page-productions', $vars['template_files'])) {
    $vars['page_class'] = '';
    $mobile_menu = menu_tree_all_data('menu-menu-mobile-menu');

    foreach ($mobile_menu as $key => $value) {
      if (!empty($value['below']) && is_array($value['below'])) {
        if ($value['link']['link_path'] == 'productions') {
          $link_list = theme('child_menu_list', $value['below']);
          $vars['mobile_productions_menu'] = theme('child_menu_render', $link_list);
        }
      }
    }
  }
  if (in_array('page-artists', $vars['template_files'])) {
    $vars['page_class'] = ' artists';
    $vars['page_title'] = 'Artists';
    //$vars['coming_list'] = views_embed_view('homepage_items');
  }
  $vars['back_link'] = _oct_mobile_get_back_link();
}


/**
 *  Implementation of hook_preprocess_node()
 */
function oct_mobile_preprocess_node($vars)
{
//  $vars['template_files'][] = 'node';
  switch ($vars['type']) {
    case 'contact_us_page':
      $vars['template_files'][] = 'node-contact_us_page';
      $vars['node']->field_left_contact[0]['value'] = preg_replace('@(<p>\s*<strong>\s*<span[^>]+style\s*=\s*"[^"]*color: #cf760f[^"]+">.+?</span>\s*</strong>\s*</p>)\s*<p>&nbsp;</p>@ism', '$1', $vars['node']->field_left_contact[0]['value']);
      $vars['node']->content['body']['#value'] = preg_replace("/(>[^<]+?)([-a-z0-9_.]+)@(([-a-z0-9_.])+)+/i", '$1$2@<wbr/>$3', $vars['node']->content['body']['#value']);
      break;
    case 'camps_page':
      $vars['template_files'][] = 'node-camps_page';
      $vars['camp_list'] = views_embed_view('summer_camps_products');
      break;
    case 'friday_fun_night_page':
      $vars['template_files'][] = 'node-friday_fun_night_page';
      $vars['event_list'] = views_embed_view('friday_night_event_view');
      break;
    case 'classes':
      $vars['template_files'][] = 'node-classes';
      $vars['classes_list'] = views_embed_view('classes');
      break;
    case 'product':
      $vars['template_files'][] = 'node-view-classes-default';
      break;
    case 'fairy_tale_ball_general_informat':
      $vars['template_files'][] = 'node-fairy_tale_ball_general_informat';
      $vars['gen_info_list'] = views_embed_view('general_info_items');
      break;
    case 'products_page':
      $vars['template_files'][] = 'node-products_page';
      $vars['products_list'] = views_embed_view('products', 'block_1');
      break;
    case 'products_page_touring':
      $vars['template_files'][] = 'node-products_page_touring';
      $vars['products_list'] = views_embed_view('products', 'block_2');
      break;
    case 'membership':
      $vars['template_files'][] = 'node-membership';
      break;
    case 'about_us_history_page':
      $vars['template_files'][] = 'node-about_us_history_page';
      break;
    case 'summer_camp_list_page':
      $vars['summer_camps_list'] = views_embed_view('summer_camp_list');
      break;
    case 'summer_camp_description_page':
      $vars['summer_camps_descr'] = views_embed_view('summer_camp_description');;
      break;
  }
}

/**
 * Implementation of hook_theme()
 */
function oct_mobile_theme()
{
  return array(
    'main_menu_list' => array(
      'arguments' => array('menu' => array()),
    ),
    'child_menu_list' => array(
      'arguments' => array('menu' => array()),
    ),
    'child_menu_render' => array(
      'arguments' => array('list_links' => array()),
    ),
    'sponsor_page' => array(
      'arguments' => array('img_src' => array()),
    ),
  );
}

/**
 * theme function get from menu links for home page
 */
function oct_mobile_main_menu_list($menu)
{
  $link_list = array();
  $i = 0;
  foreach ($menu as $key => $val) {
    $link_name = ' <span class="first"></span>
                  <span class="medium">' . $val['link']['title'] . '</span>
                  <span class="last"></span>';
    $position_class = '';
    if (($i % 2) == 0) {
      $position_class = 'left';
    } else {
      $position_class = 'right';
    }
    $link_list[] = array(
      'data' => l($link_name, $val['link']['link_path'], array('html' => TRUE)),
      'class' => $position_class,
    );
    $i++;
  }
  $facebook_url = variable_get('facebook_url', '');
  $link_list[] = array(
    'data' => '<a class="first" href="' . $facebook_url . '">Follow Us!</a>
                  <a href="' . $facebook_url . '">
                  <img alt="" src="' . drupal_get_path('theme', 'oct_mobile') . '/images/fb.png">
                  </a>',
    'class' => 'right',
  );
  return $link_list;
}

/**
 * theme function get from menu links for about us page
 */
function oct_mobile_child_menu_list($menu)
{
  $link_list = array();

  foreach ($menu as $key => $val) {
    $link_name = ' <span class="first"></span>
                  <span class="medium">' . $val['link']['title'] . '</span>
                  <span class="last"></span>';
    $link_list[] = array(
      'data' => l($link_name, $val['link']['link_path'], array('html' => TRUE)),
    );
  }
  return $link_list;
}

/**
 * theme function for render child menu
 */
function oct_mobile_child_menu_render($list_links)
{
  $output = '<div class="block-buttons">';

  foreach ($list_links as $value) {
    $output .= $value['data'];
  }
  $output .= '</div>';

  return $output;
}


function oct_mobile_preprocess_views_view_fields__products__block_1(&$variables)
{
  $node = node_load($variables['fields']['nid']->raw);

  $dates = array();
  $minDate = null;
  $maxDate = null;

  foreach ($node->field_product_date as $item) {
    if ($item['value'] != 0) {
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
 * Return html for back link
 */
function _oct_mobile_get_back_link()
{

  $menu = menu_tree_all_data('menu-menu-mobile-menu');
  if (arg(0) == 'mobile-page') {
    $mlid = arg(1);
    $link = _oct_mobile_get_back_link_by_mlid_recursive($menu, $mlid);
  } else {
    $link = _oct_mobile_get_back_link_recursive($menu);
  }
  return l('#', $link['href'] ? $link['href'] : '<front>');
}

function _oct_mobile_get_back_link_by_mlid_recursive($menu, $mlid)
{
  $link = false;
  foreach ($menu as $menu_key => $menu_item) {
    if (!empty($menu_item['below'])) {
      foreach ($menu_item['below'] as $submenu_key => $submenu_item) {
        $menu_fixed_item = render_mobile_menu(array($menu_item));
        if ($submenu_item['link']['mlid'] == $mlid) {
          if (isset($menu_fixed_item[0]['link']['href'])) {
            return array('href' => $menu_fixed_item[0]['link']['link_path']);
          }
        }
      }
      $link = _oct_mobile_get_back_link_by_mlid_recursive($menu_item['below'], $mlid);
      if (!empty($link)) return $link;
    }
  }
  return $link;
}

function _oct_mobile_get_back_link_recursive($menu)
{
  $link = false;
  foreach ($menu as $menu_key => $menu_item) {
    if (!empty($menu_item['below'])) {
      foreach ($menu_item['below'] as $submenu_key => $submenu_item) {
        //$menu_fixed_item = render_mobile_menu( array($submenu_item) );
        if (isset($submenu_item['link']['href'])) {
          if (!is_array($submenu_item['below'])) {
            if ($submenu_item['link']['href'] == $_GET['q']) {
              $menu_fixed_item = render_mobile_menu(array($menu_item));
              if (isset($menu_fixed_item[0]['link']['link_path'])) {
                return array('href' => $menu_fixed_item[0]['link']['link_path'],);
              }
            }
          }
        }
      }
      $link = _oct_mobile_get_back_link_recursive($menu_item['below']);
      if (!empty($link)) return $link;
    }
  }
  return $link;
}

/*
 * Implementation of theme_sponsor_page();
 */
function oct_mobile_sponsor_page($path)
{
  $output = '<div class="sponsor-block">';
  $output .= '<div class="sponsor-top"></div>';
  $output .= '<div class="sponsor-logo">' . theme('image', drupal_get_path('theme', 'oct_mobile') . $path) . '</div>';
  $output .= '<div class="sponsor-text">';
  $output .= t('Proud sponsor of') . '<br/>';
  $output .= '<span>' . t("Oklahoma Children's Theatre") . '</span>';
  $output .= '</div>';
  $output .= '<div class="sponsor-bot"></div>';
  $output .= '</div>';
  return $output;
}
