<div id="user-info-page-content">
<?php if(in_array($data['type'], array('product', 'class'))): ?>
    <?php print theme('date_sorter_user_info', $data); ?>
    <table class="user-info-table">
    <thead>
      <tr>
        <th><a href="#"><?php print t('Order ID'); ?></a><span class="arrow-sorter"></span></th>
        <!-- <th><a href="#"><?php //print t('Status'); ?></a><span class="arrow-sorter"></span></th> -->
        <th><a href="#"><?php print t('Purchaser'); ?></a><span class="arrow-sorter"></span></th>
        <?php if($data['type'] == 'product'): ?>
            <?php //-------------- product ------------ ?>
            <th><a href="#"><?php print t('First Name'); ?></a><span class="arrow-sorter"></span></th>
            <th><a href="#"><?php print t('Last Name'); ?></a><span class="arrow-sorter"></span></th>
            <?php //-------------- end product ------------ ?>
        <?php elseif($data['type'] == 'class'): ?>
            <?php //-------------- class ------------ ?>
            <th><a href="#"><?php print t('Parent or Guardian first name'); ?></a><span class="arrow-sorter"></span></th>
            <th><a href="#"><?php print t('Parent or Guardian last name'); ?></a><span class="arrow-sorter"></span></th>
            <th><a href="#"><?php print t('Another Parent or Guardian first name'); ?></a><span class="arrow-sorter"></span></th>
            <th><a href="#"><?php print t('Another Parent or Guardian last name'); ?></a><span class="arrow-sorter"></span></th>
            <?php //-------------- end class ------------ ?>
        <?php endif; ?>
        <th><a href="#"><?php print t('Phone'); ?></a><span class="arrow-sorter"></span></th>
        <th><a href="#"><?php print t('Address'); ?></a><span class="arrow-sorter"></span></th>
        <th><a href="#"><?php print t('City'); ?></a><span class="arrow-sorter"></span></th>
        <th><a href="#"><?php print t('State'); ?></a><span class="arrow-sorter"></span></th>
        <th><a href="#"><?php print t('Zip'); ?></a><span class="arrow-sorter"></span></th>
        <th><a href="#"><?php print t('Email'); ?></a><span class="arrow-sorter"></span></th>
        <th><a href="#"><?php print t('Cost'); ?></a><span class="arrow-sorter"></span></th>
        <th><a href="#"><?php print t('Discounts'); ?></a><span class="arrow-sorter"></span></th>
        <?php if($data['type'] == 'product'): ?>
            <?php //-------------- product ------------ ?>
            <th><a href="#"><?php print t('Production name(s)'); ?></a><span class="arrow-sorter"></span></th>
            <th><a href="#"><?php print t('Show DateTime'); ?></a><span class="arrow-sorter"></span></th>
            <th><a href="#"><?php print t('Payment DateTime'); ?></a><span class="arrow-sorter"></span></th>
            <th><a href="#"><?php print t('Quantity Adults'); ?></a><span class="arrow-sorter"></span></th>
            <th><a href="#"><?php print t('Quantity Students'); ?></a><span class="arrow-sorter"></span></th>
            <th><a href="#"><?php print t('Quantity Children'); ?></a><span class="arrow-sorter"></span></th>
            <th><a href="#"><?php print t('Quantity Group Children'); ?></a><span class="arrow-sorter"></span></th>
            <th><a href="#"><?php print t('Quantity Group Adult'); ?></a><span class="arrow-sorter"></span></th>
            <th><a href="#"><?php print t('Quantity Complimentary Adult'); ?></a><span class="arrow-sorter"></span></th>
          <?php //-------------- end product ------------ ?>
        <?php elseif($data['type'] == 'class'): ?>
            <?php //-------------- class ------------ ?>
            <th><a href="#"><?php print t('Class name(s)'); ?></a><span class="arrow-sorter"></span></th>
            <th><a href="#" class="session-time-title"><?php print t('Session time & days	'); ?></a><span class="arrow-sorter"></span></th>
            <th><a href="#"><?php print t('Child'); ?></a><span class="arrow-sorter"></span></th>
          <th><a href="#"><?php print t('Food allergy'); ?></a><span class="arrow-sorter"></span></th>
        <?php //-------------- end class ------------ ?>
        <?php endif; ?>
      </tr>
    </thead>
    <?php print theme('order_user_info_table_data', $data['result'], $data['type'], $data['now_page'], $data['total_row'], $data['show_per_page']); ?>
  </table>
  
  <?php if(!empty($data['now_page'])): ?>
    <div class="bottom-control" >
        <?php $total_pages = ceil($data['total_row'] / $data['show_per_page']);?>
        <ul class="table-pager">
        <?php for($i = 1;$i <= $total_pages; $i++): ?>
          <?php if(empty($data['now_page']) && ($i == 1) ): /**/ ?>
            <li><?php print $i; ?></li>
          <?php elseif($i !=  (int)$data['now_page']): ?>
            <li><?php //print l($i,'admin/user-info/',array('query' => array('type' => $data['type'],'page' => $i))); ?>
              <a href="#"><?php print $i; ?></a></li>
          <?php else: ?>
            <li><?php print $i; ?></li>
          <?php endif; ?>
        <?php endfor; ?>
        </ul>
    </div>
  <?php endif; ?>
  <?php print export_user_info_to_exel($data['type'], $data['result']); ?>
<?php else: ?>
  <?php print l('Productions Order User Info','admin/user-info/',array('query' => array('type' => 'product'))); ?>
  <br/>
  <?php print l('Class and Camp Order User Info','admin/user-info/',array('query' => array('type' => 'class'))); ?>
<?php endif; ?>
</div>