<div id="content-inner">
  <div id="content-bot">
    <div id="content-area">
      <h2 class="season"><span> <?php print $node->field_classes_content_title[0]['value']; ?></span></h2>
      <div class="center">
        <?php print $node->content['body']['#value']; ?>
      </div>
      <?php print $classes_list; ?>
      <div class="b-register-classes">
        <h2><?php print $node->field_classes_tp_title[0]['value']; ?></h2>
        <?php print $node->field_classes_tp_description[0]['value']; ?>
        <div class="b-type-register clr">
          <div class="b-col">
            <div class="b-online">
              <img src="<?php print base_path().drupal_get_path('theme','oct');?>/images/icon-register-classes.png" alt="Register Classes" align="right" />
              <b><?php print t('ONLINE');?></b> <?php print $node->field_classes_tp_online[0]['value']; ?>
            </div>
            <div class="b-phone">
              <b><?php print t('BY PHONE');?></b> <?php print $node->field_classes_tp_by_phone[0]['value']; ?>
            </div>
          </div>
          <div class="b-col">
            <div class="b-fax">
              <b><?php print t('FAX');?></b> <?php print $node->field_classes_tp_fax[0]['value']; ?>
            </div>
            <div class="b-mail">
              <b><?php print t('MAIL');?></b> <?php print $node->field_classes_tp_mail[0]['value']; ?>
            </div>
          </div>
        </div>
        <div class="b-register-links clr">
          <ul>
            <?php foreach($node->field_classes_tp_links as $item): ?>
            <li><?php print $item['view']; ?></li>
            <?php endforeach; ?>
            <?php foreach($node->field_classes_tp_pdfs as $item): ?>
            <li><?php print $item['view']; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
