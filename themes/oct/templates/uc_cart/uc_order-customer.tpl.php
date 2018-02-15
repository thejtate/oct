<?php
// $Id: uc_order-customer.tpl.php,v 1.1.2.1 2010/07/16 15:45:09 islandusurper Exp $

/**
 * @file
 * This file is the default customer invoice template for Ubercart.
 */
?>
<style> table a{border-bottom: 1px dashed; color: #A93B43;} </style>
<table width="95%" cellspacing="0" cellpadding="0" align="center"  style="font-family: verdana, arial, helvetica; font-size: small; border: 16px solid #FCEA79; color: #3B5F94; font: 16px;">
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" bgcolor="#EEC951" style="font-family: verdana, arial, helvetica; font-size: small;">
        <?php if ($business_header) { ?>
        <tr valign="top" >
          <td style="border-right: 6px solid #D7A625; border-top: 6px solid #D7A625;">
            <table width="100%" style="font-family: verdana, arial, helvetica; font-size: small;">
              <tr>
                <td>
                  <?php echo $site_logo; ?>
                </td>
                <td width="98%">
                </td>
                <td nowrap="nowrap">
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <?php } ?>

        <tr valign="top">
          <td style="border-right: 6px solid #D7A625;">

            <?php if ($thank_you_message) { ?>
              <p><b><?php echo t('Thanks for your order, !order_first_name!', array('!order_first_name' => $order_first_name)); ?></b></p>

              <?php if (isset($_SESSION['new_user'])) { ?>
                <p><b><?php echo t('An account has been created for you with the following details:'); ?></b></p>
                <p><b><?php echo t('Username:'); ?></b> <?php echo $new_username; ?><br />
                <b><?php echo t('Password:'); ?></b> <?php echo $new_password; ?></p>
              <?php } ?>

            <?php } ?>

            <p><b><?php print t('Please print off this receipt and present it at the Box Office.'); ?></b></p>

            <table cellpadding="4" cellspacing="0" border="0" width="100%" style="font-family: verdana, arial, helvetica; font-size: small;">
              <tr>
                <td colspan="2" bgcolor="#E6BC3A" style="color: #CF760F;">
                  <b><?php echo t('Purchasing Information:'); ?></b>
                </td>
              </tr>
              <tr>
                <td nowrap="nowrap">
                  <b><?php echo t('E-mail Address:'); ?></b>
                </td>
                <td width="98%">
                  <?php echo $order_email; ?>
                </td>
              </tr>
              <tr>
                <td colspan="2">

                  <table width="100%" cellspacing="0" cellpadding="0" style="font-family: verdana, arial, helvetica; font-size: small;">
                    <tr>
                      <td valign="top" width="50%">
                        <b><?php echo t('Billing Address:'); ?></b><br />
                        <?php echo $order_billing_address; ?><br />
                        <br />
                        <b><?php echo t('Billing Phone:'); ?></b><br />
                        <?php echo $order_billing_phone; ?><br />
                      </td>
                      <?php if (uc_order_is_shippable($order)) { ?>
                      <td valign="top" width="50%">
                        &nbsp;
                        <?php /*
                        <b><?php echo t('Shipping Address:'); ?></b><br />
                        <?php echo $order_shipping_address; ?><br />
                        <br />
                        <b><?php echo t('Shipping Phone:'); ?></b><br />
                        <?php echo $order_shipping_phone; ?><br />
                         */?>
                      </td>
                      <?php } ?>
                    </tr>
                  </table>

                </td>
              </tr>
              <tr>
                <td nowrap="nowrap">
                  <b><?php echo t('Order Grand Total:'); ?></b>
                </td>
                <td width="98%">
                  <b><?php echo $order_total; ?></b>
                </td>
              </tr>
              <tr>
                <td nowrap="nowrap">
                  <b><?php echo t('Payment Method:'); ?></b>
                </td>
                <td width="98%">
                  <?php echo $order_payment_method; ?>
                </td>
              </tr>
              <?php foreach($order->products as $val): ?>
                <?php if( !empty($val->data['attributes']['Class date']) ): ?>
                  <tr>
                    <td nowrap="nowrap">
                      <b><?php echo t('Federal Employers Identification Number:'); ?></b>
                    </td>
                    <td width="98%">
                      <?php print variable_get('fein', ''); ?>
                    </td>
                  </tr>
                  <?php break; ?>
                <?php endif; ?>
              <?php endforeach; ?>

              <tr>
                <td colspan="2" bgcolor="#E6BC3A" style="color: #CF760F;">
                  <b><?php echo t('Order Summary:'); ?></b>
                </td>
              </tr>

              <?php /* if (uc_order_is_shippable($order)) { ?>
              <tr>
                <td colspan="2" bgcolor="#EEC951">
                  <b><?php echo t('Shipping Details:'); ?></b>
                </td>
              </tr>
              <?php } */ ?>

              <tr>
                <td colspan="2">

                  <table border="0" cellpadding="1" cellspacing="0" width="100%" style="font-family: verdana, arial, helvetica; font-size: small;">
                    <tr>
                      <td nowrap="nowrap">
                        <b><?php echo t('Order #:'); ?></b>
                      </td>
                      <td width="98%">
                        <?php echo $order_link; ?>
                      </td>
                    </tr>

                    <tr>
                      <td nowrap="nowrap">
                        <b><?php echo t('Order Date: '); ?></b>
                      </td>
                      <td width="98%">
                        <?php echo $order_date_created; ?>
                      </td>
                    </tr>

                    <?php /* if ($shipping_method && uc_order_is_shippable($order)) { ?>
                    <tr>
                      <td nowrap="nowrap">
                        <b><?php echo t('Shipping Method:'); ?></b>
                      </td>
                      <td width="98%">
                        <?php echo $order_shipping_method; ?>
                      </td>
                    </tr>
                    <?php } */ ?>

                    <tr>
                      <td nowrap="nowrap">
                        <?php echo t('Products Subtotal:'); ?>&nbsp;
                      </td>
                      <td width="98%">
                        <?php echo $order_subtotal; ?>
                      </td>
                    </tr>

                    <?php
                    $context = array(
                      'revision' => 'themed',
                      'type' => 'line_item',
                      'subject' => array(
                        'order' => $order,
                      ),
                    );
                    foreach ($line_items as $item) {
                    if ($item['line_item_id'] == 'subtotal' || $item['line_item_id'] == 'total') {
                      continue;
                    }?>

                    <tr>
                      <td nowrap="nowrap">
                        <?php echo $item['title']; ?>:
                      </td>
                      <td>
                        <?php
                          $context['subject']['line_item'] = $item;
                          echo uc_price($item['amount'], $context);
                        ?>
                      </td>
                    </tr>

                    <?php } ?>

                    <tr>
                      <td>&nbsp;</td>
                      <td>------</td>
                    </tr>

                    <tr>
                      <td nowrap="nowrap">
                        <b><?php echo t('Total for this Order:'); ?>&nbsp;</b>
                      </td>
                      <td>
                        <b><?php echo $order_total; ?></b>
                      </td>
                    </tr>

                    <tr>
                      <td colspan="2">
                        <br /><br /><b><?php echo t('Products on order:'); ?>&nbsp;</b>

                        <table width="100%" style="font-family: verdana, arial, helvetica; font-size: small;">

                          <?php if (is_array($order->products)) {
                            $context = array(
                              'revision' => 'formatted',
                              'type' => 'order_product',
                              'subject' => array(
                                'order' => $order,
                              ),
                            );
                            foreach ($order->products as $product) {
                              $price_info = array(
                                'price' => $product->price,
                                'qty' => $product->qty,
                              );
                              $context['subject']['order_product'] = $product;
                              $context['subject']['node'] = node_load($product->nid);
                              ?>
                          <tr>
                            <td valign="top" nowrap="nowrap">
                              <b><?php echo $product->qty; ?> x </b>
                            </td>
                            <td width="98%">
                              <b><?php echo $product->title .' - '. uc_price($price_info, $context); ?></b>
                              <?php if ($product->qty > 1) {
                                $price_info['qty'] = 1;
                                echo t('(!price each)', array('!price' => uc_price($price_info, $context)));
                              } ?>
                              <br />
                              <?php echo t('SKU: ') . $product->model; ?><br />
                              <?php if (is_array($product->data['attributes']) && count($product->data['attributes']) > 0):?>
                                <ul>
                                <?php foreach ($product->data['attributes'] as $attribute => $option): ?>
                                      <li>
                                        <?php print t('@attribute :', array('@attribute' => $attribute)); ?>
                                        <?php if (!empty ($option) && is_array($option)):?>
                                          <?php foreach ($option as $key => $val): ?>
                                            <?php if ( $product->data['values'][$attribute][$key]['val'] === NULL ):?>
                                              <?php print $val; ?>
                                            <?php else:?> 
                                              <p style="margin: 0px; padding: 0px;"><?php print $product->data['values'][$attribute][$key]['val'] . ' x ' . $val; ?></p>
                                            <?php endif; ?>
                                          <?php endforeach; ?>
                                        <?php endif;  ?>
                                      </li>
                                <?php endforeach; ?>
                                </ul>
                              <?php endif; ?>
                              <br />
                            </td>
                          </tr>
                          <?php }
                              }?>
                        </table>

                      </td>
                    </tr>
                  </table>

                </td>
              </tr>

              <?php if ($help_text || $email_text || $store_footer) { ?>
              <tr>
                <td colspan="2">
                  <hr noshade="noshade" size="1" /><br />

                  <?php if ($email_text) { ?>
                  <p><?php echo t('Please note: This e-mail message is an automated notification. Please do not reply to this message.'); ?></p>

                  <p><?php echo t('Thanks again for shopping with us.'); ?></p>
                  <?php } ?>

                  <?php if ($store_footer) { ?>
                  <p><b><?php echo $store_link; ?></b><br /><b><?php echo $site_slogan; ?></b></p>
                  <?php } ?>
                </td>
              </tr>
              <?php } ?>
              
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>