<?php
// $Id: block.tpl.php,v 1.3 2007/08/07 08:39:36 goba Exp $
//var_dump($block);
?>
<div class="clear-block block b-subscribe" id="block-<?php print $block->module .'-'. $block->delta; ?>" >
  <div class="b-subscribe-text"><?php print t('Enter your email for OCT updates!');?></div>
  <div class="b-subscribe-field">
    <?php print $block->content ?>
  </div>
</div>