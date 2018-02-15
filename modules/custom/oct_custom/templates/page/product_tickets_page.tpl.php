<?php if (user_access('manager access') && !empty($node_ticket)): ?>
  <?php print theme('manager_links', $node_ticket, 'edit-products'); ?>
<?php endif; ?>
<h1><span><?php print t('Tickets');?></span></h1>
<div id="content-inner">
  <div id="content-bot">
    <div id="content-area">
      <div class="add-to-cart-left-col">
      <p><label><?php print t('Production');?></label></p>
      <select class="enrollment-select " id="product-tickets-select">
        <?php if(!empty($product_list)):?>
          <?php foreach($product_list as $key => $val): ?>

            <?php if(!empty($node_ticket) && $node_ticket == $key): ?>
              <?php $selected = 'selected="selected"'; ?>
            <?php else: ?>
              <?php $selected = ''; ?>
            <?php endif;?>

            <option <?php print 'value="'.$key .'"'. $selected; ?>> <?php print $val; ?> </option>

          <?php endforeach; ?>
        <?php endif;?>
      </select>
      </div>
      <? //this code show when you go on ticket/%  (also it has in oct_custom.inc for ajax) ?>
<!--      --><?php //if (($node->field_product_sold[0]['value'] == 1) || ($node->field_product_unvaliable_online[0]['value'] == 1)): ?>
<!--        <div class="product-message" id="product-form">-->
<!--        --><?php //if ($node->field_product_sold[0]['value'] == 1): ?>
<!--            --><?php //if ($node->field_product_sold_message[0]['value']): ?>
<!--              <h3>--><?php //print $node->field_product_sold_message[0]['value']; ?><!--</h3>-->
<!--            --><?php //else: ?>
<!--              <h3>--><?php //print '' . t('This product Sold Out') . '';?><!--</h3>-->
<!--            --><?php //endif; ?>
<!--        --><?php //endif; ?>
<!--        --><?php //if($node->field_product_unvaliable_online[0]['value'] == 1): ?>
<!--            --><?php //if ($node->field_product_unvaliable_message[0]['value']): ?>
<!--              <h3>--><?php //print $node->field_product_unvaliable_message[0]['value']; ?><!--</h3>-->
<!--            --><?php //else: ?>
<!--              <h3>--><?php //print '' . t('Not available online. Please check at the door') . '';?><!--</h3>-->
<!--            --><?php //endif; ?>
<!--        --><?php //endif; ?>
<!--        --><?php //if ($node->body): ?>
<!--            <h3>--><?php //print t('Location'); ?><!--</h3>-->
<!--            --><?php //print ($node->body); ?>
<!--        --><?php //endif; ?>
<!--          </div>-->
<!--      --><?php //else: ?>
        <?php if (!empty($node_ticket)): ?>
          <?php print $add_to_cart_form; ?>
        <?php endif; ?>
      <?php// endif; ?>
    </div>
  </div>
</div>