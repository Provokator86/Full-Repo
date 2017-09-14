 <?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>  
 <div class="job_categories">
            <div class="top_part"></div>
            <div class="midd_part height02">
                  <div class="username_box">
                        <div class="right_box03">
                        
                        
                             <?php include_once(APPPATH.'views/fe/common/message.tpl.php');  ?>
                        
                          
                              <h4><?php echo addslashes(t('Email Settings')); ?></h4>
                             <div class="div01"> 
                             <p><?php echo addslashes(t('System would send you alert email to you in the following scenarios. If   you would like to receive such emails, please check the following   options')); ?></p>
                              <div class="spacer"></div>
                             <form name="email_setting_frm" id="email_setting_frm" action="" method="post">
                             </div>
                             <div class="settings">
                             <ul>
                             <li><input name="chk_job_ivitations" type="checkbox" value="job_invitation" <?php if(!empty($email_key)) echo in_array('job_invitation',$email_key) ? 'checked':''?> /><?php echo addslashes(t('Job invitations from clients')) ; ?>.</li>
                             <li><input name="chk_buyer_posted_msg" type="checkbox" value="buyer_post_msg" <?php if(!empty($email_key)) echo in_array('buyer_post_msg',$email_key) ? 'checked':''?> /><?php echo addslashes(t('Private Messages')) ; ?>.</li>
                             <li><input name="chk_job_radar_search" type="checkbox" value="job_match_criteria" <?php if(!empty($email_key)) echo in_array('job_match_criteria',$email_key) ? 'checked':''?> /><?php echo addslashes(t('Radar Job Alerts')) ; ?>.</li>
                             <li><input name="chk_buyer_awarded_job" type="checkbox" value="buyer_awarded_job" <?php if(!empty($email_key)) echo in_array('buyer_awarded_job',$email_key) ? 'checked':''?> /><?php echo addslashes(t('Winning a job')) ; ?>.</li>
                             <li><input name="chk_buyer_provide_feedback" type="checkbox" value="buyer_provided_feedback" <?php if(!empty($email_key)) echo in_array('buyer_provided_feedback',$email_key) ? 'checked':''?>  /><?php echo addslashes(t('New rating and review')) ; ?>.</li>
                             <li><input name="chk_buyer_terminate_job" type="checkbox" value="buyer_terminate_job" <?php if(!empty($email_key)) echo in_array('buyer_terminate_job',$email_key) ? 'checked':''?>  /><?php echo addslashes(t('Jobs terminated by clients')) ; ?>.</li>
                             <li><input name="chk_buyer_cancel_job" type="checkbox" value="buyer_cancell_job" <?php if(!empty($email_key)) echo in_array('buyer_cancell_job',$email_key) ? 'checked':''?>  /><?php echo addslashes(t('Jobs cancelled by clients')) ; ?>.</li>
                             </ul>
                             </div>
                             <div class="spacer"></div>
                             <input class="small_button" type="submit" value="<?php echo addslashes(t('Save')); ?>" />
                              </form>
                        </div>
                         <?php include_once(APPPATH."views/fe/common/tradesman_left_menu.tpl.php"); ?>   
                        <div class="spacer"></div>
                  </div>
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>
