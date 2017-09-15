<div class="body_left">
                 <h1><img src="images/fe/account.png" alt="" /> <?php echo t('My')?> <span><?php echo t('Account')?></span></h1>
                  <div class="shadow_small">
                        <div class="left_box" style="padding-bottom:5px;">
                              <ul class="category" style="padding-bottom:0px;">
                                    <li><a href="<?php echo base_url().'buyer/edit_profile/';?>"  <?php echo ($this->i_sub_menu_id==1)?'class="active"': '' ?>><?php echo t('Edit Profile')?></a></li>
                                    <li><a href="<?php echo base_url().'buyer/change_password/'; ?>" <?php echo ($this->i_sub_menu_id==2)?'class="active"': '' ?>><?php echo t('Change Password')?></a> </li>
                                    <li><a href="<?php echo base_url().'buyer/contact_details/'; ?>" <?php echo ($this->i_sub_menu_id==3)?'class="active"': '' ?>><?php echo t('Contact Details')?></a></li>
                              </ul>
                        </div>
                  </div>
                   <h1><img src="images/fe/job.png" alt="" /> <?php echo t('My')?><span> <?php echo t('Jobs')?></span></h1>
                  <div class="shadow_small">
                        <div class="left_box" style="padding-bottom:5px;">
                              <ul class="category" style="padding-bottom:0px;">
                                    <li><a href="<?php echo base_url().'job/job_post/'; ?>" <?php echo ($this->i_sub_menu_id==4)?'class="active"': '' ?>><?php echo t('Post a Job')?></a></li>
                                    <li><a href="<?php echo base_url().'buyer/all_jobs/'; ?>" <?php echo ($this->i_sub_menu_id==5)?'class="active"': '' ?>><?php echo t('All Jobs')?> (<?php echo $i_tot_jobs;?>)</a></li>
                                    <li><a href="<?php echo base_url().'buyer/active_jobs/'; ?>" <?php echo ($this->i_sub_menu_id==6)?'class="active"': '' ?>><?php echo t('Active Jobs')?> (<?php echo $i_active_jobs;?>)</a></li>
                                    <li><a href="<?php echo base_url().'buyer/assign_jobs/'; ?>" <?php echo ($this->i_sub_menu_id==7)?'class="active"': '' ?>><?php echo t('Assigned Jobs')?> (<?php echo $i_assigned_jobs;?>)</a></li>
                                    <li><a href="<?php echo base_url().'buyer/completed_jobs/'; ?>" <?php echo ($this->i_sub_menu_id==8)?'class="active"': '' ?>><?php echo t('Completed Jobs')?> (<?php echo $i_completed_jobs;?>)</a></li>
                                    <li><a href="<?php echo base_url().'buyer/expired_jobs/'; ?>" <?php echo ($this->i_sub_menu_id==9)?'class="active"': '' ?>><?php echo t('Expired Jobs')?> (<?php echo $i_expired_jobs;?>)</a></li>
                              </ul>
                        </div>
                  </div>
                 <h1><img src="images/fe/msg_board.png" alt="" /> <?php echo t('Message')?> <span><?php echo t('Board')?></span></h1>
                  <div class="shadow_small">
                        <div class="left_box" style="padding-bottom:5px;">
                              <ul class="category" style="padding-bottom:0px;">
                                    <li><a href="<?php echo base_url().'private_message/';?>" <?php echo ($this->i_sub_menu_id==10)?'class="active"': '' ?> ><?php echo t('My Private Message Board')?></a></li>
                              </ul>
                        </div>
                  </div>
                  <h1><img src="images/fe/tradesman.png" alt="" />  <?php echo t('Tradesman')?> </h1>
                  <div class="shadow_small">
                        <div class="left_box" style="padding-bottom:5px;">
                              <ul class="category" style="padding-bottom:0px;">
                                    <li><a href="<?=base_url().'find_tradesman'?>"><?php echo t('Search / InviteTradesman')?></a></li>
                              </ul>
                        </div>
                  </div>
                 <h1><img src="images/fe/settings.png" alt="" />  <?php echo t('My')?> <span> <?php echo t('Settings')?></span></h1>
                  <div class="shadow_small">
                        <div class="left_box" style="padding-bottom:5px;">
                              <ul class="category" style="padding-bottom:0px;">
                                    <li><a href="<?php echo base_url().'buyer/email_settings/'; ?>" <?php echo ($this->i_sub_menu_id==12)?'class="active"': '' ?>><?php echo t('Email Settings')?></a></li>
                              </ul>
                        </div>
                  </div>
                  <h1><img src="images/fe/general.png" alt="" />  <?php echo t('General')?></h1>
                  <div class="shadow_small">
                        <div class="left_box" style="padding-bottom:5px;">
                              <ul class="category" style="padding-bottom:0px;">
                                    <?php /*?><li><a href="javascript:void(0);"><?php echo t('My Alerts')?></a></li><?php */?>
                                    <li><a href="<?php echo base_url().'recommend/'; ?>" <?php echo ($this->i_sub_menu_id==14)?'class="active"': '' ?>><?php echo t('Recommend Us')?></a></li>
                                    <li><a href="<?php echo base_url().'buyer/buyer_testimonial/'; ?>" <?php echo ($this->i_sub_menu_id==15)?'class="active"': '' ?>><?php echo t('My Testimonial')?></a></li>
                                   
                              </ul>
                        </div>
                  </div>
            </div>
			