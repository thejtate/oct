<tbody>
  <?php if(!empty($result)): ?>
    <?php foreach($result as $key => $val): ?>
        <?php if ( (( ($now_page - 1) * $show_per_page) <=  $key) &&  ($key <= (($now_page * $show_per_page) - 1) ) ): ?>
          <?php $data = unserialize($val['data']); ?>
          <tr>
            <td><?php print l($val['order_id'],'admin/store/orders/'.$val['order_id']); ?></td>
            <!-- <td><?php //print $val['order_status']; ?></td> -->
            <td><?php print $val['purchaser']; ?></td>
            <?php if($type == 'product'): ?>
                <?php //-------------- product ------------ ?>
                <td><?php print $val['first_name']; ?></td>
                <td><?php print $val['last_name']; ?></td>
                <?php //-------------- end product ------------ ?>
            <?php elseif($type == 'class'): ?>
                <?php //-------------- class ------------ ?>
                <td><?php print $val['parent_first_name']; ?></td>
                <td><?php print $val['parent_last_name']; ?></td>
                <td><?php print $val['parent_2_first_name']; ?></td>
                <td><?php print $val['parent_2_last_name']; ?></td>
                <?php //-------------- end class ------------ ?>
            <?php endif; ?>
            <td><?php print $val['phone_number']; ?></td>
            <td><?php print $val['address']; ?></td>
            <td><?php print $val['сity']; ?></td>
            <td><?php print $val['state']; ?></td>
            <td><?php print $val['zip']; ?></td>
            <td><?php print $val['email']; ?></td>
            <td><?php print number_format($val['price'], 2);//$row['order_total']; ?></td>
            <td>
              <?php if (!empty($val['discounts']) && is_array($val['discounts'])): ?>
                <?php foreach($val['discounts'] as $discount): ?>
                  <p><?php print number_format(round((float)$discount['amount'], 2),2);  ?></p>
                <?php endforeach; ?>
              <?php endif; ?>
              </td>
            <?php if($type == 'product'): ?>
              <?php //-------------- product ------------ ?>
              <td><?php print $val['title']; ?></td>
              <td> <?php print $data['attributes']['Date and time'][0]; ?>
<!--                --><?php //print date('m-d-Y h:ia', $val['modified']); ?>
              </td>
              <td> <?php //print $data['attributes']['Date and time'][0]; ?>
              <?php print date('m-d-Y h:ia', $val['modified']); ?>
              </td>
              <td>
              <?php if(is_array($data['values']['Tickets'][0])): ?>
                <?php print $data['values']['Tickets'][0]['val']; ?>
              <?php endif; ?>
              </td>
              <td>
              <?php if(is_array($data['values']['Tickets'][1])): ?>
                <?php print $data['values']['Tickets'][1]['val']; ?>
              <?php endif; ?>
              </td>
              <td>
              <?php if(is_array($data['values']['Tickets'][2])): ?>
                <?php print $data['values']['Tickets'][2]['val']; ?>
              <?php endif; ?>
              </td>
              <td>
              <?php if(is_array($data['values']['Tickets'][3])): ?>
                <?php print $data['values']['Tickets'][3]['val']; ?>
              <?php endif; ?>
              </td>
              <td>
              <?php if(is_array($data['values']['Tickets'][4])): ?>
                <?php print $data['values']['Tickets'][4]['val']; ?>
              <?php endif; ?>
              </td>
              <td>
              <?php if(is_array($data['values']['Tickets'][5])): ?>
                <?php print $data['values']['Tickets'][5]['val']; ?>
              <?php endif; ?>
              </td>
            <?php //-------------- end product ------------ ?>
          <?php elseif($type == 'class'): ?>
              <?php //-------------- class ------------ ?>
              <td><?php print $val['title']; ?></td>
              <td>
                <?php if (!empty($data['attributes']['Class date'][0])): ?>
                    <?php print $data['attributes']['Class date'][0]; ?>
                <?php endif; ?>
              </td>
              <td>
              <?php if(!empty($data['attributes']['birth month'][0]) && !empty($data['attributes']['birth day'][0]) && !empty($data['attributes']['birth year'][0])): ?>
                <p><?php print $data['attributes']['birth month'][0] . '.' . $data['attributes']['birth day'][0] . '.' . $data['attributes']['birth year'][0]; ?><p>
              <?php endif; ?>
              <?php print $data['attributes']['child’s first name'][0].' '; ?>
              <?php print $data['attributes']['child’s last name'][0]; ?>
              </td>
              <td>
                  <?php print !empty($data['attributes']['Child’s food allergy'][0]) ? $data['attributes']['Child’s food allergy'][0] : ''; ?>
              </td>
              <?php //-------------- end class ------------ ?>
          <?php endif; ?>

          </tr>
       <?php endif;?>
    <?php endforeach; ?>
  <?php endif;?>
</tbody>
