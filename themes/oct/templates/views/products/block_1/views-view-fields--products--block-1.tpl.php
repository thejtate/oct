<div class="b-article clr">
  <?php if (user_access('manager access')): ?>
    <?php print theme('manager_links', $fields['nid']->content, 'edit-products'); ?>
  <?php endif; ?>

  <div class="b-img"><a href="<?php print url('tickets/' . $fields['nid']->raw); ?>">
      <?php print $fields['field_product_image_fid']->content; ?>
    </a><br />
    <div class="b-buts-panel"><a href="<?php print url('tickets/' . $fields['nid']->raw); ?>" class="tickets" title="Tickets"></a></div>
    <?php if (array_key_exists('field_stugy_guide_fid', $fields)) : ?>
      <div class="b-buts-panel"><?php print l('', $fields['field_stugy_guide_fid']->content, array('attributes' => array('class' => 'stugy_guide'))); ?></div>
    <?php endif; ?>
  </div>
  <div class="b-info">
    <h2><a name="product-<?php print $fields['nid']->raw; ?>" href="<?php print url('tickets/' . $fields['nid']->raw); ?>">&ldquo;<?php print $fields['title']->raw ?>&rdquo;</a></h2>
    <?php if(!empty($fields['field_theatre_select_description_value']->content)): ?>
      <p class="product-theatre-descr"><?php print $fields['field_theatre_select_description_value']->content; ?></p>
    <?php endif; ?>
    <p class="product-date-period"><b><?php print $min_date;?> <?php if(!empty($max_date)){ print ' - '.$max_date; } ?></b></p>
    <?php print $fields['field_product_teaser_value']->content; ?>
    
    <?php print $fields['body']->content; ?>
    <p>
      <?php foreach($product_dates as $item):?>
        <?php print $item; ?><br />
      <?php endforeach; ?>
    </p>
  </div>
</div>