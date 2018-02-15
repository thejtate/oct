<div id="content-inner">
  <div id="content-bot">
    <div id="content-area">
      <div class="b-story">
        <?php print $node->field_camps_top_image[0]['view']; ?>
        <div class="b-story-inner">
          <p class="f12px"><?php print $node->content['body']['#value']; ?></p>
          <div class="accordion">
            <?php foreach($node->field_camps_at as $key => $at): ?>
            <h4><a href="#"><?php print $at['value']; ?></a></h4>
            <div>
              <?php
                if (isset($node->field_camps_ad[$key])) {
                  print $node->field_camps_ad[$key]['value'];
                }
              ?>
            </div>
            <?php endforeach; ?>
          </div>
          <p><b><?php print t('SPONSORS');?></b><br /><?php print $sponsors; ?></p>
          <p><b><?php print t('PARTNERS');?></b><br /><?php print $partners; ?></p>
        </div>
      </div>
    </div>
  </div>
</div>