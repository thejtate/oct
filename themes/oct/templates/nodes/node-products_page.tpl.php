<h1><span><?php print $node->title; ?></span></h1>
<div id="content-inner">
  <div id="content-bot">
    <div id="content-area">
      <h2 class="season"><span><?php print $node->field_product_content_title[0]['value'];?></span></h2>
      <?php print $products_list;?>
      <div class="b-purchase-ticket">
        <h2><?php print $node->field_product_tp_title[0]['value'];?></h2>
        <div class="b-type-purchase clr">
          <div class="b-online">
            <img src="<?php print base_path().drupal_get_path('theme','oct'); ?>/images/icon-online-ticket.png" alt="Online Ticket" align="right" />
            <b><?php print t('ONLINE');?></b> <?php print $node->field_product_tp_online[0]['value'];?>
          </div>
          <div class="b-phone">
            <b><?php print t('BY PHONE');?></b> <?php print $node->field_product_tp_by_phone[0]['value'];?>
          </div>
        </div>
        <div class="b-time-purchase">
          <?php print $node->field_product_tp_description[0]['value'];?>
        </div>
      </div>
    </div>
  </div>
</div>