<?php
/**
 * @file
 *   Template for star widget.
 */
?>
<div class="vud-widget vud-widget-star" id="<?php print $id; ?>">
  <span class="vote-current-title"><?php print t('Bravo'); ?></span>

  <div class="up-score">
    <?php if ($show_links): ?>
      <?php if ($show_up_as_link): ?>
        <a href="<?php print $link_up; ?>" rel="nofollow" class="<?php print "$link_class_up"; ?>" title="<?php print t('Vote up!'); ?>">
      <?php endif; ?>
      <div class="vote-star <?php print $class_up; ?>" title="<?php print t('Vote up!'); ?>"></div>
      <div class="element-invisible"><?php print t('Vote up!'); ?></div>
      <?php if ($show_up_as_link): ?>
        </a>
      <?php endif; ?>
    <?php endif; ?>
  </div>


  <?php if ($show_reset): ?>
    <a href="<?php print $link_reset; ?>" rel="nofollow" class="element-invisible <?php print $link_class_reset; ?>" title="<?php print $reset_long_text; ?>">
      <div class="<?php print $class_reset; ?>">
        <?php print $reset_short_text; ?>
      </div>
    </a>
  <?php endif; ?>
  <span class="vote-current-score"><?php print $vote_sum; ?></span>
</div>
