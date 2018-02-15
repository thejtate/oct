<ul class="primary manager-links <?php print $class;?>">
  <li class="ml_edit"><?php print l('Edit', 'node/'.$nid.'/edit', array('query' => drupal_get_destination()));?></li>
  <li class="ml_delete"><?php print l('Delete', 'node/'.$nid.'/delete', array('query' => drupal_get_destination()));?></li>
</ul>