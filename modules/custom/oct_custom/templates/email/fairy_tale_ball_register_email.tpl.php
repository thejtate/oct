<?php
/**
 * @file
 * This file is the default customer email template for fairy tale ball section
 */
?>
<style> table a{border-bottom: 1px dashed; color: #A93B43;} </style>
<table width="95%" cellspacing="0" cellpadding="0" align="center"  style="font-family: verdana, arial, helvetica; font-size: small; border: 16px solid #FCEA79; color: #000000; font: 16px;">
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" bgcolor="#EEC951" style="font-family: verdana, arial, helvetica; font-size: small;">

        <tr valign="top" >
          <td style="border-right: 6px solid #D7A625; border-top: 6px solid #D7A625;">
            <table width="100%" style="font-family: verdana, arial, helvetica; font-size: small;">
              <tr>
                <td>
                </td>
                <td width="98%">
                  <div style="padding-left: 1em;">
                    <span style="font-size: large;"><?php echo t('OCT Store'); ?></span><br />
                  </div>
                </td>
                <td nowrap="nowrap">
                </td>
              </tr>
            </table>
          </td>
        </tr>


        <tr valign="top">
          <td style="border-right: 6px solid #D7A625;">

            <table cellpadding="4" cellspacing="0" border="0" width="100%" style="font-family: verdana, arial, helvetica; font-size: small;">
              <tr>
                <td colspan="2" bgcolor="#E6BC3A" style="color: #CF760F;">
                  <b><?php echo t('New user on Fairy Tale Ball:'); ?></b>
                </td>
              </tr>
              <?php if (!empty($vars['name_company_name'])): ?>
                <tr>
                  <td nowrap="nowrap">
                    <b><?php echo t('Name/Company Name:'); ?></b>
                  </td>
                  <td width="98%">
                    <?php print $vars['name_company_name']; ?>
                  </td>
                </tr>
              <?php endif; ?>
              <?php if (!empty($vars['contact_name'])): ?>
                <tr>
                  <td nowrap="nowrap">
                    <b><?php echo t('Contact Name:'); ?></b>
                  </td>
                  <td width="98%">
                    <?php print $vars['contact_name']; ?>
                  </td>
                </tr>
              <?php endif; ?>
              <?php if (!empty($vars['phone'])): ?>
                <tr>
                  <td nowrap="nowrap">
                    <b><?php echo t('Phone:'); ?></b>
                  </td>
                  <td width="98%">
                    <?php print $vars['phone']; ?>
                  </td>
                </tr>
              <?php endif; ?>
              <?php if (!empty($vars['fax'])): ?>
                <tr>
                  <td nowrap="nowrap">
                    <b><?php echo t('Fax:'); ?></b>
                  </td>
                  <td width="98%">
                    <?php print $vars['fax']; ?>
                  </td>
                </tr>
              <?php endif; ?>      
              <?php if (!empty($vars['email'])): ?>
                <tr>
                  <td nowrap="nowrap">
                    <b><?php echo t('Email:'); ?></b>
                  </td>
                  <td width="98%">
                    <?php print $vars['email']; ?>
                  </td>
                </tr>
              <?php endif; ?> 
              <?php if (!empty($vars['adress'])): ?>
                <tr>
                  <td nowrap="nowrap">
                    <b><?php echo t('Address:'); ?></b>
                  </td>
                  <td width="98%">
                    <?php print $vars['adress']; ?>
                  </td>
                </tr>
              <?php endif; ?>                  
              <?php if (!empty($vars['city'])): ?>
                <tr>
                  <td nowrap="nowrap">
                    <b><?php echo t('City:'); ?></b>
                  </td>
                  <td width="98%">
                    <?php print $vars['city']; ?>
                  </td>
                </tr>
              <?php endif; ?>
              <?php if (!empty($vars['state'])): ?>
                <tr>
                  <td nowrap="nowrap">
                    <b><?php echo t('State:'); ?></b>
                  </td>
                  <td width="98%">
                    <?php print $vars['state']; ?>
                  </td>
                </tr>
              <?php endif; ?>
              <?php if (!empty($vars['zip'])): ?>
                <tr>
                  <td nowrap="nowrap">
                    <b><?php echo t('Zip:'); ?></b>
                  </td>
                  <td width="98%">
                    <?php print $vars['zip']; ?>
                  </td>
                </tr>
              <?php endif; ?>
              <?php if (!empty($vars['name_sitter'])): ?>
                <tr>
                  <td nowrap="nowrap">
                    <b><?php echo t('Name of your sitter:'); ?></b>
                  </td>
                  <td width="98%">
                    <?php print $vars['name_sitter']; ?>
                  </td>
                </tr>
              <?php endif; ?>
              <?php if (!empty($vars['seat_with'])): ?>
                <tr>
                  <td nowrap="nowrap">
                    <b><?php echo t('We wish to be seated with:'); ?></b>
                  </td>
                  <td width="98%">
                    <?php print $vars['seat_with']; ?>
                  </td>
                </tr>
              <?php endif; ?>

              <?php if (!empty($vars['children_in_party']) && is_array($vars['children_in_party'])): ?>
                <?php $flag = TRUE; //first printed row flag?>
                <?php foreach ($vars['children_in_party'] as $key => $value): ?>
                  <?php if ($flag): ?>
                    <?php $flag = FALSE; ?>
                    <tr>
                      <td nowrap="nowrap">
                        <b><?php print t('First & Last name(s) & age(s) of children in my party:') ?></b>
                      </td>
                      <td width="98%">
                        &nbsp;
                      </td>
                    </tr>
                  <?php endif; ?>

                  <tr>
                    <td nowrap="nowrap">
                      <?php print $value; ?> 
                    </td>
                    <td width="98%">
                      &nbsp;
                    </td>
                  </tr>

                <?php endforeach; ?>
              <?php endif; ?>
              <?php if (!empty($vars['adults_on_party']) && is_array($vars['adults_on_party'])): ?>
                <?php $flag = TRUE; //first printed row flag?>
                <?php foreach ($vars['adults_on_party'] as $key => $value): ?>
                  <?php if ($flag): ?>
                    <?php $flag = FALSE; ?>
                    <tr>
                      <td nowrap="nowrap">
                        <b><?php print t('First & Last names of adults in my party:') ?></b>
                      </td>
                      <td width="98%">
                        &nbsp;
                      </td>
                    </tr>
                  <?php endif; ?>

                  <tr>
                    <td nowrap="nowrap">
                      <?php print $value; ?> 
                    </td>
                    <td width="98%">
                      &nbsp;
                    </td>
                  </tr>

                <?php endforeach; ?>
              <?php endif; ?>                
              <tr>
                <td colspan="2" bgcolor="#E6BC3A" style="color: #CF760F;">
                  <b><?php echo t('ORDER INFO:'); ?></b>
                </td>
              </tr>

              <?php if (!empty($vars['adult_qty']) && !empty($vars['total_adult_cost'])): ?>    

                <tr>
                  <td nowrap="nowrap">
                    <b><?php print $vars['adult_qty'] . ' ' . t('Adults x $150 each ='); ?></b>
                  </td>
                  <td width="98%">
                    <?php print '$' . $vars['total_adult_cost'] . ' ' . t('Total adult cost'); ?>
                  </td>
                </tr>
              <?php endif; ?>
              <?php if (!empty($vars['children_qty_children_dinner']) && !empty($vars['total_child_cost_children_dinner'])): ?>    

                <tr>
                  <td nowrap="nowrap">
                    <b><?php print $vars['children_qty_children_dinner'] . ' ' . t('Children x $50 each ='); ?></b>
                  </td>
                  <td width="98%">
                    <?php print '$' . $vars['total_child_cost_children_dinner'] . ' ' . t('Total child cost (Attending children’s dinner)'); ?>
                  </td>
                </tr>
              <?php endif; ?>
              <?php if (!empty($vars['children_qty_adult_dinner']) && !empty($vars['total_child_cost_children_dinner'])): ?>    
                <tr>
                  <td nowrap="nowrap">
                    <b><?php print $vars['children_qty_adult_dinner'] . ' ' . t('Children x $125 each ='); ?></b>
                  </td>
                  <td width="98%">
                    <?php print '$' . $vars['total_child_cost_adult_dinner'] . ' ' . t('Total child cost (Attending adult’s dinner)'); ?>
                  </td>
                </tr>
              <?php endif; ?>
              <?php if (!empty($vars['sitters_qty_children_dinner']) && isset($vars['total_sitters_cost_children_dinner'])): ?>    
                <tr>
                  <td nowrap="nowrap">
                    <b><?php print $vars['sitters_qty_children_dinner'] . ' ' . t('Sitters x $0 ='); ?></b>
                  </td>
                  <td width="98%">
                    <?php print '$' . $vars['total_sitters_cost_children_dinner'] . ' ' . t('Total sitter cost (Attending children’s dinner)'); ?>
                  </td>
                </tr>
              <?php endif; ?> 
              <?php if (!empty($vars['sitters_qty_adult_dinner']) && !empty($vars['total_sitters_cost_adult_dinner'])): ?>
                <tr>
                  <td nowrap="nowrap">
                    <b><?php print $vars['sitters_qty_adult_dinner'] . ' ' . t('Sitters x $125 ='); ?></b>
                  </td>
                  <td width="98%">
                    <?php print '$' . $vars['total_sitters_cost_adult_dinner'] . ' ' . t('Total sitter cost (Attending adult’s dinner)'); ?>
                  </td>
                </tr>
              <?php endif; ?>
              <?php if (!empty($vars['tween_ball_count']) && !empty($vars['tween_ball_price'])): ?>
              <tr>
                  <td nowrap="nowrap">
                      <b><?php print $vars['tween_ball_count'] . ' ' . t('Tween Ball x $75 ='); ?></b></b>
                  </td>
                  <td width="98%">
                    <?php print '$' . $vars['tween_ball_price'] . ' ' . t('Total Tween Ball cost'); ?>
                  </td>
              </tr>
                <?php endif; ?>
              <?php if (!empty($vars['coins_price'])): ?>    
                <tr>
                  <td nowrap="nowrap">
                    <b><?php print t('Coins:');?></b>
                  </td>
                  <td width="98%">
                    <?php print '$' . $vars['coins_price'] . ' ' . t('Total coins cost'); ?>
                  </td>
                </tr>
              <?php endif; ?>                  
              <?php if (!empty($vars['checkboxes']) && is_array($vars['checkboxes'])): ?>
                <?php $flag = TRUE; //first printed row flag?>
                <?php foreach ($vars['checkboxes'] as $key => $value): ?>
                  <?php if ($flag): ?>
                    <?php $flag = FALSE; ?>
                    <tr>
                      <td nowrap="nowrap">
                        <b><?php print t('Sponsorship packages:') ?></b>
                      </td>
                      <td width="98%">
                        &nbsp;
                      </td>
                    </tr>
                  <?php endif; ?>

                  <tr>
                    <td nowrap="nowrap">
                      <?php print $value['checkbox_name']; ?> 
                    </td>
                    <td width="98%">
                      <?php print '$' . $value['checkbox_amount']; ?>
                    </td>
                  </tr>

                <?php endforeach; ?>
              <?php endif; ?>
              <tr>
                <td colspan="2">
                  &nbsp;
                </td>
              </tr> 

              <?php if (!empty($vars['donate_amount'])): ?>    

                <tr>
                  <td nowrap="nowrap">
                    <b><?php print t('Donate:'); ?> </b>
                  </td>
                  <td width="98%">
                    <?php print '$' . $vars['donate_amount']; ?>
                  </td>
                </tr>

              <?php endif; ?>
              <?php if (!empty($vars['total_cost'])): ?>    
                <tr>
                  <td nowrap="nowrap">
                    <b><?php print t('Total:'); ?> </b>
                  </td>
                  <td width="98%">
                    <?php print '$' . $vars['total_cost']; ?>
                  </td>
                </tr>
              <?php endif; ?>
              <?php if (!empty($vars['handling_fee'])): ?>    
                <tr>
                  <td nowrap="nowrap">
                    <b><?php print t('Handling Fee:'); ?> </b>
                  </td>
                  <td width="98%">
                    <?php print '$' . $vars['handling_fee']; ?>
                  </td>
                </tr>
              <?php endif; ?>                       
              <?php if (!empty($vars['total_attendee_cost'])): ?>    
                <tr>
                  <td nowrap="nowrap">
                    <b><?php print t('TOTAL ATTENDEE COST:'); ?></b>
                  </td>
                  <td width="98%">
                    <?php print '$' . $vars['total_attendee_cost']; ?>
                  </td>
                </tr>
              <?php endif; ?>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>