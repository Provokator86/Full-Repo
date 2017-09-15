<div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
            <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			<div id="div_err">
			 		<?php
						show_msg("error");  
						echo validation_errors();
					?>
			</div>	
            <?php include_once(APPPATH.'views/fe/common/tradesman_left_menu.tpl.php'); ?>
			
            <div class="body_right">
                  <h1><img src="images/fe/settings.png" alt="" /><?php echo get_title_string(t('Email Settings'))?></h1>
                  <div class="shadow_big">
                        <div class="right_box_all_inner">
						<form name="email_setting_frm" id="email_setting_frm" action="" method="post">
                              <div class="brd"><?php echo t('System would send you alert email to you in the following scenarios. If you would like to receive such emails, please check the following options')?></div>
                              <div class="box02">
                                    <input name="chk_job_ivitations" type="checkbox" value="job_invitation" <?php if(!empty($email_key)) echo in_array('job_invitation',$email_key) ? 'checked':''?> style="vertical-align:middle; margin-right:5px;" />
                                    <?php echo t('Job Invitations from Buyer')?>.</div>
                              <div class="box02">
                                    <input name="chk_buyer_posted_msg" type="checkbox" value="buyer_post_msg" <?php if(!empty($email_key)) echo in_array('buyer_post_msg',$email_key) ? 'checked':''?> style="vertical-align:middle; margin-right:5px;" />
                                    <?php echo t('Buyer has posted Message')?>.</div>
                              <div class="box02">
                                    <input name="chk_job_radar_search" type="checkbox" value="job_match_criteria" <?php if(!empty($email_key)) echo in_array('job_match_criteria',$email_key) ? 'checked':''?> style="vertical-align:middle; margin-right:5px;" />
                                    <?php echo t('Jobs matching Radar Search Criteria')?></div>
                              <div class="box02">
                                    <input name="chk_buyer_awarded_job" type="checkbox" value="buyer_awarded_job" <?php if(!empty($email_key)) echo in_array('buyer_awarded_job',$email_key) ? 'checked':''?> style="vertical-align:middle; margin-right:5px;" />
                                    <?php echo t('Buyer has Awarded Job')?>.</div>
                              <div class="box02">
                                    <input name="chk_buyer_provide_feedback" type="checkbox" value="buyer_provided_feedback" <?php if(!empty($email_key)) echo in_array('buyer_provided_feedback',$email_key) ? 'checked':''?> style="vertical-align:middle; margin-right:5px;" />
                                    <?php echo t('Buyer has provided Feedback')?>.</div>
                              <div class="box02">
                                    <input name="chk_buyer_terminate_job" type="checkbox" value="buyer_terminate_job" <?php if(!empty($email_key)) echo in_array('buyer_terminate_job',$email_key) ? 'checked':''?> style="vertical-align:middle; margin-right:5px;" />
                                    <?php echo t('Buyer has Terminated Job')?></div>
                              <div class="box02">
                                    <input name="chk_buyer_cancel_job" type="checkbox" value="buyer_cancell_job" <?php if(!empty($email_key)) echo in_array('buyer_cancell_job',$email_key) ? 'checked':''?> style="vertical-align:middle; margin-right:5px;" />
                                    <?php echo t('Buyer has Cancelled Job in which you have placed Quote')?>.</div>
                              <br />
                              <input  class="button" type="submit" value="<?php echo t('Save')?>" style=" margin-bottom:10px;"/>
                              <div class="spacer"></div>
							  </form>
                        </div>
                  </div>
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
      </div>