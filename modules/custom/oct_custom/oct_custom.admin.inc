<?php
/**
 * @file
 * Admin settings for module
 *
 * @author
 * Sergey Grigorenko
 * @package OCT
 */

/**
 * Common settings for website.
 */
function oct_custom_admin_settings() {
  $form = array();

  $form['social_block'] = array(
      '#type'         => 'fieldset',
      '#title'        => t('Social block settings'),
      '#description'  => t('Make a donation, facebook etc'),
      '#collapsible'  => TRUE,
      '#collapsed'  => TRUE,
  );
  $form['social_block']['make_donation_url'] = array(
      '#type'           => 'textarea',
      '#title'        => t('Make a Donation URL'),
      '#description'  => t('Link to your "Make a Donation" page.'),
      '#default_value'  => variable_get('make_donation_url', 'https://www.paypal.com/us/cgi-bin/webscr?cmd=_flow&SESSION=JX3lCFEhqOWkg9nurFJuFXI8l0B8StIlZEk8chHxIVyKC4m2ZlT-Z4PVM2W&dispatch=5885d80a13c0db1f8e263663d3faee8d5863a909c4bb5aeebb52c6e1151bdaa9'),
      '#required'       => TRUE
  );
  $form['social_block']['facebook_url'] = array(
      '#type'           => 'textfield',
      '#title'          => t('Facebook URL'),
      '#description'    => t('Link to your facebook page.'),
      '#default_value'  => variable_get('facebook_url', 'http://facebook.com'),
      '#required'       => TRUE

  );
  $form['social_block']['fein'] = array(
      '#type'           => 'textfield',
      '#title'          => t('Federal Employers Identification Number'),
      '#default_value'  => variable_get('fein', ''),
  );
  $form['social_block']['receiver_product_email'] = array(
      '#type'           => 'textfield',
      '#title'          => t('Receiver uc product email'),
      '#default_value'  => variable_get('receiver_product_email', ''),
  );
  $form['social_block']['receiver_class_email'] = array(
      '#type'           => 'textfield',
      '#title'          => t('Receiver uc class/camp email'),
      '#default_value'  => variable_get('receiver_class_email', ''),
  );
  $form['social_block']['receiver_fairy_tale_ball_registration_email'] = array(
      '#type'           => 'textfield',
      '#title'          => t('Receiver "Fairy Tale Ball" registration email'),
      '#description'    => t('Input multiple email separated by comma'),
      '#default_value'  => variable_get('receiver_fairy_tale_ball_registration_email', ''),
  );
  $form['social_block']['user_register_approval_emails'] = array(
    '#type'           => 'textfield',
    '#title'          => t('Receivers of "New User waiting approval" registration email'),
    '#description'    => t('Input multiple email separated by comma'),
    '#default_value'  => variable_get('user_register_approval_emails', ''),
  );
  $form['backstage_block'] = array(
      '#type'           => 'fieldset',
      '#title'          => t('Backstage block settings'),
      '#description'    => t(''),
      '#collapsible'    => TRUE,
      '#collapsed'      => TRUE,
  );
  $form['backstage_block']['backstage_user_agreement'] = array(
      '#type'           => 'textarea',
      '#title'          => t('User Agreement'),
      '#cols'           => 60,
      '#rows'           => 50,
      '#default_value'  => variable_get('backstage_user_agreement', ''),
  );

  

//  $form['social']['phyconbill_twitter_link'] = array(
//      '#type'           => 'textfield',
//      '#title'        => t('Twitter page'),
//      '#description'  => t('Link to your twitter page.'),
//      '#default_value'  => variable_get('phyconbill_twitter_link', 'http://twitter.com/'),
//      '#required'       => TRUE
//    );
//
//
//  $form['site_settings'] = array(
//    '#type'         => 'fieldset',
//    '#title'        => t('Site content settings'),
//    '#description'  => t('Site content settings: footer blocks, copyright, etc.'),
//    '#collapsible'  => TRUE
//  );
//
//  $form['site_settings']['phyconbill_copyright'] = array(
//      '#type'           => 'textarea',
//      '#title'        => t('Copyright'),
//      '#description'  => t('Copyright text'),
//      '#cols' => 60,
//      '#rows' => 5,
//      '#default_value'  => variable_get('phyconbill_copyright', 'Copyright &copy; PhyCon Incorporated'),
//      '#required'       => TRUE
//  );
//
//
//  $form['site_settings']['phyconbill_footer_message'] = array(
//      '#type'           => 'textarea',
//      '#title'        => t('Footer message'),
//      '#description'  => t('Footer message text'),
//      '#cols' => 60,
//      '#rows' => 5,
//      '#default_value'  => variable_get('phyconbill_footer_message', ''),
//      '#required'       => TRUE
//  );
//
//  $form['site_settings']['phyconbill_footer_info'] = array(
//      '#type'           => 'textarea',
//      '#title'        => t('Footer info'),
//      '#description'  => t('Footer info text'),
//      '#cols' => 60,
//      '#rows' => 5,
//      '#default_value'  => variable_get('phyconbill_footer_info', ''),
//      '#required'       => TRUE
//  );

  return system_settings_form($form);
}