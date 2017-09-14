 <?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>   
  <div class="job_categories">
            <div class="top_part"></div>
            <div class="midd_part height02">
                  <div class="username_box">
                        <div class="right_box03">
                        
                              <?php include_once(APPPATH.'views/fe/common/message.tpl.php');  ?>
                              <h4><?php echo addslashes(t('Email Settings')); ?></h4>
                              
                             <div class="div01"> 
                             <p><?php echo addslashes(t('System would send you alert email to you in the following scenarios. If you would like to receive such emails, please check the following options')); ?></p>
                              <div class="spacer"></div>
                               <form name="email_setting_frm" id="email_setting_frm" action="" method="post">  
                             </div>
                             <div class="settings">
                             <ul>
                                 <li><input name="chk_trade_place_quote" type="checkbox" value="tradesman_placed_quote" <?php if(!empty($email_key)) echo in_array('tradesman_placed_quote',$email_key) ? 'checked':''?> /><?php echo addslashes(t('New Quote Received')); ?></li>
                                 <li><input name="chk_trade_accept_reject_job" type="checkbox" value="tradesman_accepted_job_offer" <?php if(!empty($email_key)) echo in_array('tradesman_accepted_job_offer',$email_key) ? 'checked':''?> /><?php echo addslashes(t('Service professional has accepted/rejected your offer')); ?></li>
                                 <li><input name="chk_trade_submit_msg" type="checkbox" value="tradesman_post_msg" <?php if(!empty($email_key)) echo in_array('tradesman_post_msg',$email_key) ? 'checked':''?>/><?php echo addslashes(t('New private message received')); ?></li>
                                 <li><input name="chk_trade_asked_feedback" type="checkbox" value="tradesman_feedback" <?php if(!empty($email_key)) echo in_array('tradesman_feedback',$email_key) ? 'checked':''?> /><?php echo addslashes(t('Job completion and feedback request')); ?></li>
                                 <li><input name="chk_admin_approved_reject_job" type="checkbox" value="admin_buyer_cancel_job" <?php if(!empty($email_key)) echo in_array('admin_buyer_cancel_job',$email_key) ? 'checked':''?> /><?php echo addslashes(t('Your job has been approved/rejected by hizmetuzmani')); ?></li>
                                
                             </ul>
                             </div>
                             <div class="spacer"></div>
                             <input class="small_button" type="submit" value="Save" />
                              </form>
                        </div>
                        <?php include_once(APPPATH."views/fe/common/buyer_left_menu.tpl.php"); ?>
                        <div class="spacer"></div>
                  </div>
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>
