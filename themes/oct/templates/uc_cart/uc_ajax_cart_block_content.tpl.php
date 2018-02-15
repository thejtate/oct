<?php
/**
 * @file
 *
 * Theme file for non empty cart.
 */

?>
<div id="cart-block-contents-ajax">
    <table class="cart-block-items">
          <tr class="header">
            <th><?php print t('Class Name'); ?></th>
            <th><?php print t('Session Time & Day(s)'); ?></th>
            <th><?php print t('Price'); ?></th>
            <th class="close"></th>
          </tr>
          <?php foreach ($items as $item): ?>
          <?php
          
//            $week = $item['node']->field_class_week_days;
//            $week_tmp = array();
//            foreach($week as $v){
//                $week_tmp[] = $v['value'];
//            }
//            $date = $item['node']->field_class_date;
//            $dateFrom = format_date(strtotime($date[0]['value']), 'custom', 'F d, Y');
//            $dateTo = format_date(strtotime($date[0]['value']), 'custom', 'F d, Y');
//            $timeFrom = format_date(strtotime($date[0]['value']), 'custom', 'h:i a');
//            $timeTo = format_date(strtotime($date[0]['value']), 'custom', 'h:i a');
//            
//            $desc = implode(", ",$week_tmp);
//            $desc .= (!empty($desc)) ? " " : "" ;
//            $desc .= $timeFrom . " - " . $timeTo . " " . $dateFrom . " - " . $dateTo;
          $desc = '';
            $item['remove_link'] = str_replace('Remove product', '<img src="'. base_path() . drupal_get_path('module', 'oct_custom') . '/images/enrollment-close.png" />', $item['remove_link']);
            
            
          ?>
            <tr>
                <td><?php print $item['item']->title;?> (<?php print $item['qty'] ?>)</td>
                <td><?php print $desc;?></td>
                <td><?php print $item['total'] ?></td>
                <td class="close"><?php print $item['remove_link'] ?></td>
                </tr>
<?php endforeach; ?>
        </tbody>
    </table>
</div>
<hr />
<div>
  <label><?php print t('Total'); ?>: </label><?php print $total; ?>
</div>  
<hr />
