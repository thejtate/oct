<h1><span><?php print $node->title; ?></span></h1>
<div id="content-inner" class="touring">
  <div id="content-bot">
    <div id="content-area">
      <h2><?php print $node->field_product_touring_tp_title[0]['value']; ?></h2>

      <?php print $products_list;?>
      
      <div class="b-article clr">
        <div class="b-info">
          <?php print $node->content['body']['#value']; ?>
        </div>
      </div>
    </div>
  </div>
</div>
