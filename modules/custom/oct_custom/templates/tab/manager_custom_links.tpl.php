<ul class="primary manager-links <?php print $class;?>">
  <?php foreach( $links as $val): ?>
    <?php if($val['no_return']):?>
      <?php $val['destination'] = ''; ?>
    <?php elseif (empty($val['destination'])):?>
      <?php $val['destination'] = drupal_get_destination(); ?>
    <?php endif; ?>
    <li class="ml_edit"><?php print l($val['title'], $val['path'] , array('query' => $val['destination']));?></li>
  <?php endforeach; ?>
</ul>