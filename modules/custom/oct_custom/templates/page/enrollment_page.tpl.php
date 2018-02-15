
<h1><span><?php print t('Enrollment');?></span></h1>
<div id="content-inner">
    <div id="content-bot">
        <div id="content-area">
            <p><?php print t('Please enter child’s name and birthday, including year of birth:');?></p>
            <form class="form-enrollment ajax-cart-submit-form" id="form-enrollment" action="/" method="post">
                <div>
                    <div class="form-field"><label><?php print t('First Name'); ?></label><input id="enrollment_first_name" name="enrollment[first_name]" size="20" type="text" class="form-text" /></div>
                    <div class="form-field"><label><?php print t('Last Name'); ?></label><input id="enrollment_last_name" name="enrollment[last_name]" size="20" type="text" class="form-text" /></div>
                    <div class="form-field"><label><?php print t('Does your child have a serious food allergy?'); ?></label><textarea id="enrollment_food_allergy" name="enrollment[food_allergy]" rows="4" cols="50" class="form-textarea" ></textarea></div>
                    <div class="form-field form-field-date">
                        <label><?php print t('Date of Birth'); ?></label>
                        <select name="enrollment[month]" class="enrollment-select" id="enrollment-month">
                            <?php for($i=1; $i<=12; $i++): ?>
                              <option><?php print ($i<10) ? "0".$i : $i;?></option>
                            <?php endfor;?>
                        </select>
                        <select name="enrollment[day]" class="enrollment-select" id="enrollment-day">
                            <?php for($i=1; $i<=31; $i++): ?>
                              <option><?php print ($i<10) ? "0".$i : $i;?></option>
                            <?php endfor;?>
                        </select>
                        <select name="enrollment[year]" class="enrollment-select" id="enrollment-year">
                            <?php
                              $year_from =  2000; //date("Y") - 40;
                              $year_to =  date("Y") - 0;
                            ?>
                            <?php for($i=$year_from; $i<=$year_to; $i++): ?>
                              <?php if($i == 2000){ $selected = ' selected="selected" ';} else { $selected = '';}; ?>
                              <option <?php print $selected; ?> ><?php print $i;?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                    <div class="form-field">
                        <label><?php print t('Class /Camp'); ?></label>
                        <select name="enrollment[class_camp]" class="enrollment-select" id="enrollment-class">
                            <option val="-1">Please select...</option>
                        </select>
                    </div>
                    <div class="form-field">
                        <label><?php print t('Session Time & Day(s)'); ?></label>
                        <select name="enrollment[session_time]" class="enrollment-select" id="enrollment-session-time">
                            <option val="-1">Please select...</option>
                        </select>
                    </div>
                    <div class="form-field hidden" id="t-sirts-attribut" >
                        <label><?php print t('T-Shirt'); ?></label>
                        <select name="enrollment[t_shirt]" class="enrollment-select" id="enrollment-t-sirts-size">
                            <option val="-1">Please select...</option>
                        </select> ***
                        <p><?php print '*** '.t('Please note: Summer Campers only receive one tee shirt after their first week of camp.'); ?></p>
                        <p class="t-shirt-fee"><?php print t('Select a shirt size if you wish to purchase a t-shirt. There is a single $5 fee for this.'); ?></p>
                    </div>

                    <div class="form-field"><label><?php print t('Price'); ?></label>$<span id="enrollment-price">0.00</span></div>
                    <div class="product-message">
                      <div class="sold-out"></div>
                      <div class="online-unvaliable"></div>
                    </div>

                    <input class="ajax-cart-submit-form-button" type="image" src="<?php print base_path() . drupal_get_path('module', 'oct_custom'); ?>/images/enrollment-add-to-cart-btn.png" name="submit" id="submit" />
                </div>
            </form>
            <div>
                <?php print $data['cart'];?>

                <p class="red first">TICKETS ARE NON-REFUNDABLE </br>
                    LATE COMERS WILL BE SEATED AT THE DISCRESION OF THE MANGEMENT</p>
                <p class="red second">To enroll more than one child, add all classes desired for the first child then change the information for second child and add all desired for the second child, repeat as necessary and then click enroll when you're ready.</p>

                <p><u>Enrollment Discounts</u></p>
                Beginning fall 2014, we will no longer offer a sibling discount.
                <p></p>
                    <ul>
                        <li><p>·  Multiple Camps -- Enroll your child  in more than one camp in the same transaction and receive 10% each camp after your first.  Applies only to individual campers, does not apply for siblings.  *Automatically applies during checkout*</p></li>
                        <li><p>·  Membership Discount -- 10% of each enrollment for families that purchase a production membership through the box office.  Call to register with this discount.</p></li>
                        <li><p>·  OCU Discount -- 20% off each enrollment for OCU faculty, staff, and students.  Call to register with this discount.</p></li>
                    </ul>
                <a href="<?php print url('cart');?>"><img src="<?php print base_path() . drupal_get_path('module', 'oct_custom'); ?>/images/enrollment-enroll.png" alt="Checkout"/></a>
                <div class="bottom">
                    <h4>Cancellation/Refund Policy</h4>
                    <p>Enrollment is on a first come basis, full payment is required in order to ensure a spot in classes/camps. A refund (minus a $10 processing fee per class/camp) will be issued if the student drops the class/camp five working days prior to the first day of class. A full refund will only be issued if the class is canceled by Oklahoma Children's Theatre. Classes will not be prorated and no other refunds or tuition transfers will apply. No refunds are available for before/AfterCare. If you are ineligible for a refund, you may obtain an acknowledgment from the Education Director, which enables you to claim unused tuition as a tax-deductible contribution. All classes have a minimum and maximum student enrollment. Oklahoma Children's Theatre reserves he right to substitute instructors if necessary. </p>
                </div>
            </div>
        </div>
    </div>
</div>
