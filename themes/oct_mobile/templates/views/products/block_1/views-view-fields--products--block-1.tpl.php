<?php// kpr($fields); ?>
<div class="middle-item norm">
  <?php if ($fields['field_product_image_fid']->raw): ?>
  <div class="actor">
    <?php print $fields['field_product_image_fid']->content; ?>
  </div>
  <?php endif; ?>
  <h2><?php print $fields['title']->content; ?></h2>
  <p>
    <strong>
      <?php print $min_date;?>
    </strong>
    <?php if(!empty($max_date)) : ?> -
      <br />
      <strong>
        <?php print $max_date; ?>
      </strong>
    <?php endif; ?>
  </p>

  <div><?php print $fields['body']->content; ?></div>
  <br />
  <p>
    <?php foreach($product_dates as $item):?>
      <?php print $item; ?><br />
    <?php endforeach; ?>
  </p>
</div><!--middle-item-->

