<div class="body_left">
                  <h1><img src="images/fe/account.png" alt="" /> <?php echo t('My')?> <span><?php echo t('Account')?></span></h1>
                  <div class="shadow_small">
                        <div class="left_box" style="padding-bottom:5px;">
                              <ul class="category" style="padding-bottom:0px;">
                                    <li><a href="<?php echo base_url().'tradesman/edit_profile/'?>" <?php echo ($this->i_sub_menu_id==1)?'class="active"': '' ?>><?php echo t('Edit My Profile')?></a></li>
                                  
                                 
                                    <li><a href="<?php echo base_url();?>tradesman_profile/<?php echo $loggedin['user_id'];?>"><?php echo t('View Trade Profile')?></a></li>   
									<li><a href="<?php echo base_url().'tradesman/album/'?>" <?php echo ($this->i_sub_menu_id==3)?'class="active"': '' ?>><?php echo t('My Album')?></a></li>
                                    <li><a href="<?php echo base_url().'tradesman/change_password/'?>" <?php echo ($this->i_sub_menu_id==4)?'class="active"': '' ?>><?php echo t('Change Password')?></a> </li>
                                    <li><a href="<?php echo base_url().'tradesman/contact_details/' ?>" <?php echo ($this->i_sub_menu_id==5)?'class="active"': '' ?>><?php echo t('Contact Details')?></a></li>
                              </ul>
                        </div>
                  </div>
                  <h1><img src="images/fe/job.png" alt="" /> <?php echo t('Job')?><span> <?php echo t('Prospects')?> </span></h1>
                  <div class="shadow_small">
                        <div class="left_box" style="padding-bottom:5px;">
                              <ul class="category" style="padding-bottom:0px;">
                                    <li><a href="<?php echo base_url().'tradesman/quote_jobs'?>" <?php echo ($this->i_sub_menu_id==6)?'class="active"': '' ?>><?php echo t('Quotes')?> (<?=$i_tot_quotes?>)</a></li>
                                 
                                    <li><a href="<?php echo base_url().'tradesman/job_invitation'?>" <?php echo ($this->i_sub_menu_id==7)?'class="active"': '' ?>><?php echo t('Job Invitations')?> (<?=$i_job_invitation?>)</a></li>
                                    <li><a href="<?php echo base_url().'tradesman/tradesman_radar_job'?>" <?php echo ($this->i_sub_menu_id==8)?'class="active"': '' ?>><?php echo t('Radar Jobs')?> (<?php echo $i_total_radar_job?>)</a></li>
                              </ul>
                        </div>
                  </div>
                  <h1><img src="images/fe/job_secure.png" alt="" /> <?php echo t('Job')?> <span><?php echo t('Secured')?></span></h1>
                  <div class="shadow_small">
                        <div class="left_box" style="padding-bottom:5px;">
                              <ul class="category" style="padding-bottom:0px;">
                                    <li><a href="<?=base_url().'tradesman/pending_jobs'?>" <?php echo ($this->i_sub_menu_id==9)?'class="active"': '' ?>><?php echo t('Pending Jobs')?> (<?=$i_pending_jobs?>)</a></li>
                                    <li><a href="<?=base_url().'tradesman/progress_jobs'?>" <?php echo ($this->i_sub_menu_id==10)?'class="active"': '' ?>><?php echo t('In Progress')?> (<?=$i_progress_jobs?>)</a></li>
                                    <li><a href="<?=base_url().'tradesman/completed_jobs'?>" <?php echo ($this->i_sub_menu_id==11)?'class="active"': '' ?>><?php echo t('Completed Jobs')?> (<?=$i_completed_jobs?>)</a></li>
                                    <li><a href="<?=base_url().'tradesman/frozen_jobs'?>" <?php echo ($this->i_sub_menu_id==12)?'class="active"': '' ?>><?php echo t('Frozen Jobs')?>(<?=$i_frozen_jobs?>)</a></li>
                              </ul>
                        </div>
                  </div>
                  <h1><img src="images/fe/feedback01.png" alt="" /> <?php echo t('Feedbacks')?> </h1>
                  <div class="shadow_small">
                        <div class="left_box" style="padding-bottom:5px;">
                              <ul class="category" style="padding-bottom:0px;">
                                    <li><a href="<?=base_url().'tradesman/feedback_received'?>" <?php echo ($this->i_sub_menu_id==13)?'class="active"': '' ?>><?php echo t('Feedback Received')?> (<?php  echo $i_total_feedback;?>)</a></li>
                                  
                              </ul>
                        </div>
                  </div>
                  <h1><img src="images/fe/msg_board.png" alt="" /> <?php echo t('Message')?> <span><?php echo t('Board')?></span></h1>
                  <div class="shadow_small">
                        <div class="left_box" style="padding-bottom:5px;">
                              <ul class="category" style="padding-bottom:0px;">
                                    <li><a href="<?php echo base_url().'private_message/tradesman_private_message_board/' ?>" <?php echo ($this->i_sub_menu_id==14)?'class="active"': '' ?>><?php echo t('My Private Message Board')?></a></li>
                              </ul>
                        </div>
                  </div>
                  <h1><img src="images/fe/settings.png" alt="" /> <?php echo t('My')?> <span> <?php echo t('Settings')?></span></h1>
                  <div class="shadow_small">
                        <div class="left_box" style="padding-bottom:5px;">
                              <ul class="category" style="padding-bottom:0px;">
                                    <li><a href="<?php echo base_url().'tradesman/email_settings/'?>" <?php echo ($this->i_sub_menu_id==15)?'class="active"': '' ?>><?php echo t('Email Settings')?></a></li>
                              </ul>
                        </div>
                  </div>
                  <h1><img src="images/fe/general.png" alt="" /> <?php echo t('General')?></h1>
                  <div class="shadow_small">
                        <div class="left_box" style="padding-bottom:5px;">
                              <ul class="category" style="padding-bottom:0px;">
                                   <li><a href="<?php echo base_url().'tradesman/job_radar/'?>" <?php echo ($this->i_sub_menu_id==16)?'class="active"': '' ?>><?php echo t('Job Radar')?></a></li>
                                  <?php /*?>   <li><a href="tradesman_alert.html"><?php echo t('My Alerts')?></a></li><?php */?>
                                    <li><a href="<?php echo base_url().'recommend/'; ?>" <?php echo ($this->i_sub_menu_id==18)?'class="active"': '' ?>><?php echo t('Recommend Us')?></a></li>
                                    <li><a href="<?php echo base_url().'tradesman/testimonial/'?>" <?php echo ($this->i_sub_menu_id==19)?'class="active"': '' ?>><?php echo t('My Testimonial')?></a></li>
                              </ul>
                        </div>
                  </div>
            </div>