<div id="online-register-page-content">
  <table class="online-register-table">
    <thead>
      <tr>
        <th><a href="#"><?php print t('Id');?></a></th>
        <th><a href="#"><?php print t('Name/Contact name');?></a></th>
        <th><a href="#"><?php print t('Contact Name');?></a></th>
        <th><a href="#"><?php print t('Phone') . '/' . t('Fax');?></a></th>
        <th><a href="#"><?php print t('Email');?></a></th>
        <th><a href="#"><?php print t('Adress');?></a></th>
        <th><a href="#"><?php print t('City');?></a></th>
        <th><a href="#"><?php print t('State');?></a></th>
        <th><a href="#"><?php print t('Zip');?></a></th>
        <th><?php print t('First & Last name(s) & age(s) of children in my party');?></th>
        <th><?php print t('First & Last names of adults in my party');?></th>
        <th><?php print t('Name of your sitter');?></th>
        <th><?php print t('We wish to be seated with');?></th>
        <th><?php print t("Adults Attending children's dinner");?></th>
        <th><?php print t("Children Attending children's dinner");?></th>
        <th><?php print t("Children Attending adult's dinner");?></th>
        <th><?php print t('Sitters Attending children’s dinner');?></th>
        <th><?php print t('Sitters Attending adult’s dinner');?></th>
        <th><a href="#"><?php print t('Tween Ball count');?></a></th>
        <th><a href="#"><?php print t('Coins');?></a></th>
        <th><a href="#"><?php print t('Total');?></a></th>
        <th><a href="#"><?php print t('Handling Fee');?></a></th>
        <th><a href="#"><?php print t('Total attendee cost');?></a></th>
        <th><a href="#"><?php print t('Sponsorships');?></a></th>
        <th><a href="#"><?php print t('Donate');?></a></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($data as $key => $val): ?>
        <tr>
          <td><?php print $key; ?></td>
          <td><?php print $val['name_company_name']; ?></td>
          <td><?php print $val['contact_name']; ?></td>
          <td><?php print $val['phone'] . ' '. $val['fax']; ?></td>
          <td><?php print $val['email']; ?></td>
          <td><?php print $val['adress']; ?></td>
          <td><?php print $val['city']; ?></td>
          <td><?php print $val['state']; ?></td>
          <td><?php print $val['zip']; ?></td>
          <td>
            <?php if ( !empty($val['children_in_party'])): ?>
              <?php foreach ($val['children_in_party']as $k => $v): ?>
                <p><?php print $v; ?></p>
              <?php endforeach; ?>
            <?php endif; ?>
          </td>
          <td>
            <?php if ( !empty($val['children_in_party'])): ?>
              <?php foreach ($val['adults_in_party']as $k => $v): ?>
                <p><?php print $v; ?></p>
              <?php endforeach; ?>
            <?php endif; ?>
          </td>
          <td><?php print $val['name_sitter']; ?></td>
          <td><?php print $val['seat_with']; ?></td>
          <td><?php print $val['adult_qty'] . 'x ' . number_format($val['total_adult_cost'], 2); ?></td>
          <td><?php print $val['children_qty_children_dinner'] . 'x ' . number_format($val['total_child_cost_children_dinner'],2); ?></td>
          <td><?php print $val['children_qty_adult_dinner'] . 'x ' . number_format($val['total_child_cost_children_dinner'],2); ?></td>
          <td><?php print $val['sitters_qty_children_dinner'] . 'x ' . number_format($val['total_sitters_cost_children_dinner'],2); ?></td>
          <td><?php print $val['sitters_qty_adult_dinner'] . 'x ' . number_format($val['total_sitters_cost_adult_dinner'],2); ?></td>
          <td>
            <?php print $val['tween_ball_count']. 'x75'; ?>
          </td>
            <td>
            <?php $opt = get_coins_price_list();
            if(!empty($opt['coins_price_list']) && is_array($opt['coins_price_list'])){
              foreach ($opt['coins_price_list'] as $k => $v){
                if($k == $val['coins_price']){
                  print $v;
                }
              }
            } ?>
          </td>
          <td><?php print number_format($val['total_cost'],2); ?></td>
          <td><?php print number_format($val['handling_fee'],2); ?></td>
          <td><?php print number_format($val['total_attendee_cost'],2); ?></td>
          <td>
            <?php if ( !empty($val['checkbox_amount']) && is_array($val['checkbox_amount']) ): ?>
              <?php foreach ($val['checkbox_amount']as $k => $v): ?>
                <p><?php print $v['checkbox_name'] .' '. number_format($v['checkbox_amount'],2); ?></p>
              <?php endforeach; ?>
            <?php endif; ?>
          </td>
          <td><?php print number_format($val['donate_amount'],2); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php print export_online_register_to_excel($data); ?>
</div>