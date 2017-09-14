<div class="account_right_panel">
                    <div class="top">&nbsp;</div>
                    <div class="mid">
                        <div class="heading_box">My Actions</div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-33.png" alt="" />My Account</div>
                            <div class="box02">
                                <ul>
                                    <li><a href="<?php echo base_url().'tradesman/edit_email'?>" <?php echo ($this->i_sub_menu_id==1)?'class="select"': '' ?>>Edit Email</a></li>
                                    <li><a href="<?php echo base_url().'tradesman/change_password'?>" <?php echo ($this->i_sub_menu_id==2)?'class="select"': '' ?>>Change Password</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-36.png" alt="" />My Profile</div>
                            <div class="box02">
                                <ul>
                                    <li><a href="<?php echo base_url().'tradesman/edit_profile'?>" <?php echo ($this->i_sub_menu_id==3)?'class="select"': '' ?>>Edit My Profile</a></li>
                                    <li><a href="<?php echo base_url().'tradesman/skills_qualifications'?>" <?php echo ($this->i_sub_menu_id==4)?'class="select"': '' ?>>My Skills And Qualifications</a></li>
                                    <li><a href="<?php echo base_url().'tradesman/album'?>" <?php echo ($this->i_sub_menu_id==5)?'class="select"': '' ?>>Manage Photos</a></li>
                                    <li><a href="<?php echo base_url().'find_tradesman/tradesman_profile/'.$loggedin['user_id']?>" <?php echo ($this->i_sub_menu_id==6)?'class="select"': '' ?>>View My Profile</a></li>
									<li><a href="<?php echo base_url().'tradesman/verify_profile/'?>" <?php echo ($this->i_sub_menu_id==22)?'class="select"': '' ?>>Manage Verifications</a></li>
									<!--<li><a href="<?php echo base_url().'tradesman/my_invoice/'?>" <?php echo ($this->i_sub_menu_id==23)?'class="select"': '' ?>>My Invoice</a></li>-->
                                </ul>
                            </div>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-34.png" alt="" />My Job Prospects</div>
                            <div class="box02">
                                <ul>
                                    <li><a href="<?php echo base_url().'tradesman/quote_jobs'?>" <?php echo ($this->i_sub_menu_id==7)?'class="select"': '' ?>>Quotes (<?php echo $i_tot_quotes ?>)</a></li>
                                    <li><a href="<?php echo base_url().'tradesman/watch_list'?>" <?php echo ($this->i_sub_menu_id==8)?'class="select"': '' ?>>Watch List (<?php echo $i_watch_jobs ?>)</a></li>
                                    <li><a href="<?php echo base_url().'tradesman/job_invitation'?>" <?php echo ($this->i_sub_menu_id==9)?'class="select"': '' ?>>Job  Invitations (<?php echo $i_job_invitation ?>)</a></li>
                                    <li><a href="<?php echo base_url().'tradesman/tradesman_radar_job/'; ?>" <?php echo ($this->i_sub_menu_id==10)?'class="select"': '' ?>>Jobs within Radar <?php //echo $i_total_radar_job ?></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-51.png" alt="" />Job Secured</div>
                            <div class="box02">
                                <ul>
                                    <li><a href="<?php echo base_url().'tradesman/pending_jobs'?>" <?php echo ($this->i_sub_menu_id==11)?'class="select"': '' ?>>Pending  Jobs(<?php echo $i_pending_jobs ?>)</a></li>
                                    <li><a href="<?php echo base_url().'tradesman/progress_jobs'?>" <?php echo ($this->i_sub_menu_id==12)?'class="select"': '' ?>>Jobs In Progress (<?php echo $i_progress_jobs ?>)</a></li>
                                    <li><a href="<?php echo base_url().'tradesman/completed_jobs'?>" <?php echo ($this->i_sub_menu_id==13)?'class="select"': '' ?>>Completed Jobs (<?php echo $i_completed_jobs ?>)</a></li>
                                    <li><a href="<?php echo base_url().'tradesman/frozen_jobs'?>" <?php echo ($this->i_sub_menu_id==14)?'class="select"': '' ?>>Frozen Jobs (<?=$i_frozen_jobs?>)</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-37.png" alt="" />Reviews</div>
                            <div class="box02">
                                <ul>
                                    <li><a href="<?php echo base_url().'tradesman/feedback_received'?>" <?php echo ($this->i_sub_menu_id==15)?'class="select"': '' ?>>Reviews Received (<?php echo $i_total_feedback?>)</a></li>
                                    <li><a href="<?php echo base_url().'tradesman/feedback_provided'?>" <?php echo ($this->i_sub_menu_id==16)?'class="select"': '' ?>>Reviews To Be Provided (<?php echo $i_feedback_to_be_provided?>)</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-35.png" alt="" />Message Board</div>
                            <div class="box02">
                                <ul>
                                    <li><a href="<?php echo base_url().'private_message/tradesman_private_message_board'?>" <?php echo ($this->i_sub_menu_id==17)?'class="select"': '' ?>>My Private Message Board</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-38.png" alt="" />My Settings</div>
                            <div class="box02">
                                <ul>
                                    <li><a href="<?php echo base_url().'tradesman/job_radar/'; ?>" <?php echo ($this->i_sub_menu_id==18)?'class="select"': '' ?>>Job Radar Settings</a></li>
                                    <li><a href="<?php echo base_url().'tradesman/email_settings/'; ?>" <?php echo ($this->i_sub_menu_id==19)?'class="select"': '' ?>>Email Settings</a></li>
                                    <li><a href="<?php echo base_url().'recommend/tradesman_recommend'?>" <?php echo ($this->i_sub_menu_id==20)?'class="select"': '' ?>>Recommend Us</a></li>
                                    <li><a href="<?php echo base_url().'tradesman/testimonial/'; ?>" <?php echo ($this->i_sub_menu_id==21)?'class="select"': '' ?>>Your Testimonial(s)</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="bot">&nbsp;</div>
                </div>
