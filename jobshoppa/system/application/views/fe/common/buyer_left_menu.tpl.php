<div class="account_right_panel">
                    <div class="top">&nbsp;</div>
                    <div class="mid">
                        <div class="heading_box">My Actions</div>
                        <div class="blue_box03">
                            <h2>Do you want to a post new job?</h2>
                           <p><input name="" type="button" class="post_job"  value="Post a job " onclick="window.location.href='<?php echo base_url().'job/job_post'?>'"/></p>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-33.png" alt="" />My Account</div>
                            <div class="box02">
                                <ul>
                                    <li><a href="<?php echo base_url().'buyer/edit_profile/'; ?>" <?php echo ($this->i_sub_menu_id==1)?'class="select"': '' ?>>Edit / View Profile</a></li>
                                    <li><a href="<?php echo base_url().'buyer/contact_details'; ?>"<?php echo ($this->i_sub_menu_id==3)?'class="select"': '' ?>>Contact Details</a></li>
                                    <li><a href="<?php echo base_url().'buyer/change_password/'; ?>" <?php echo ($this->i_sub_menu_id==2)?'class="select"': '' ?>>Change Password</a></li>
                                </ul>                       
                            </div>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-34.png" alt="" />Jobs I have posted</div>
                            <div class="box02">
                                <ul>
                                    <li><a href="<?php echo base_url().'buyer/all_jobs/'; ?>" <?php echo ($this->i_sub_menu_id==5)?'class="select"': '' ?>>All Jobs (<?php echo $i_tot_jobs;?>)</a></li>
                                    <li><a href="<?php echo base_url().'buyer/active_jobs/'; ?>" <?php echo ($this->i_sub_menu_id==6)?'class="select"': '' ?>>Active Jobs (<?php echo $i_active_jobs;?>)</a></li>
                                    <li><a href="<?php echo base_url().'buyer/assign_jobs/'; ?>" <?php echo ($this->i_sub_menu_id==7)?'class="select"': '' ?>>Assigned Jobs (<?php echo $i_assigned_jobs;?>)</a></li>
                                    <li><a href="<?php echo base_url().'buyer/completed_jobs/'; ?>" <?php echo ($this->i_sub_menu_id==8)?'class="select"': '' ?>>Completed Jobs (<?php echo $i_completed_jobs;?>)</a></li>
                                    <li><a href="<?php echo base_url().'buyer/expired_jobs/'; ?>" <?php echo ($this->i_sub_menu_id==9)?'class="select"': '' ?>>Expired Jobs (<?php echo $i_expired_jobs;?>)</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-35.png" alt="" />Message Board</div>
                            <div class="box02">
                                <ul>
                                   <li><a href="<?php echo base_url().'private_message/private_message_board'; ?>" <?php echo ($this->i_sub_menu_id==10)?'class="select"': '' ?>>My Private Message Board</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-36.png" alt="" />Professionals</div>
                            <div class="box02">
                                <ul>
                                    <li><a href="<?php echo base_url().'find_tradesman'?>">Find Professionals</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-37.png" alt="" />Reviews</div>
                            <div class="box02">
                                <ul>
                                    <!--<li><a href="javascript:void(0);">Completion Alert From Professional</a></li>-->
                                    <li><a href="<?php echo base_url().'buyer/feedback_received'; ?>" <?php echo ($this->i_sub_menu_id==11)?'class="select"': '' ?>>Reviews Received</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-38.png" alt="" />My Settings</div>
                            <div class="box02">
                                <ul>
                                    <li><a href="<?php echo base_url().'buyer/email_settings/'; ?>" <?php echo ($this->i_sub_menu_id==14)?'class="select"': '' ?>>Email Settings</a></li>
                                    <li><a href="<?php echo base_url().'recommend/buyer_recommend'; ?>" <?php echo ($this->i_sub_menu_id==15)?'class="select"': '' ?>>Recommend Us</a></li>
                                    <li><a href="<?php echo base_url().'buyer/buyer_testimonial/'; ?>" <?php echo ($this->i_sub_menu_id==16)?'class="select"': '' ?>>Your Testimonial(s)</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="bot">&nbsp;</div>
                </div>