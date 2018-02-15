<div class="b-article clr">
  <?php if (user_access('manager access')): ?>
    <?php print theme('manager_links', $fields['nid']->content, 'edit-products'); ?>
  <?php endif; ?>
  
  <div class="b-img">
      <?php print $fields['field_product_image_fid']->content; ?>
  </div>
    <div class="b-info">
      <h2><a name="product-<?php print $fields['nid']->raw; ?>" ></a>&ldquo;<?php print $fields['title']->content ?>&ldquo;</h2>
      <?php print $fields['body']->content; ?>
    </div>
</div>