<?php
// $Id: views-view-table.tpl.php,v 1.8 2009/01/28 00:43:43 merlinofchaos Exp $
/**
 * @file views-view-table.tpl.php
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $class: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * @ingroup views_templates
 */
?>
<table class="<?php print $class; ?>">
  <?php if (!empty($title)) : ?>
    <caption><?php print $title; ?></caption>
  <?php endif; ?>
  <thead>
    <tr>
      <th class="views-field views-field"><?php print $header['nid']; ?></th>
      <th class="views-field views-field"><?php print $header['title']; ?></th>
      <th class="views-field views-field"><?php print t('Product type'); ?></th>
      <th class="views-field views-field"><?php print $header['created']; ?></th>
      <th class="views-field views-field"><?php print t('On home'); ?></th>
      <th class="views-field views-field"><?php print t('Sold'); ?></th>
      <th class="views-field views-field"><?php print t('Online'); ?></th>
      <th class="views-field views-field"><?php print $header['edit_node']; ?></th>
      <th class="views-field views-field"><?php print $header['delete_node']; ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $count => $row): ?>
      <?php if ($row['status'] == 'No'): ?>
        <tr class="<?php print implode(' ', $row_classes[$count]); ?> unpublished">
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['nid']?></td>
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['title']?><?php print t(" (Unpublished)")?></td>
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['tid']?></td>
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['created']?></td>
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['field_show_on_homepage_value']?></td>
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['field_product_sold_value']?></td>
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['field_product_unvaliable_online_value']?></td>
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['edit_node']?></td>
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['delete_node']?></td>
        </tr>
      <?php else: ?>
         <tr class="<?php print implode(' ', $row_classes[$count]); ?>">
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['nid']?></td>
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['title']?></td>
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['tid']?></td>
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['created']?></td>
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['field_show_on_homepage_value']?></td>
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['field_product_sold_value']?></td>
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['field_product_unvaliable_online_value']?></td>
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['edit_node']?></td>
          <td class="views-field views-field-<?php print $fields[$field]; ?>"><?php print $row['delete_node']?></td>
         </tr>
      <?php endif; ?>
    <?php endforeach; ?>
  </tbody>
</table>
<?php print l(t('Download xls'), $url_file_xls, array('attributes' => array('class' => 'excel-link'))); ?>
