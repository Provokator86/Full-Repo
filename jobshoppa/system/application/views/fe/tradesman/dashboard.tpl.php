<script>
jQuery(document).ready(function() {
		$(".lightbox1_main").fancybox({
			'titlePosition'		: 'inside',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'showCloseButton'	: true
		});
		//console.log($(".lightbox1_main"));
});
</script>
<div id="banner_section">
    <?php
    include_once(APPPATH."views/fe/common/header_top.tpl.php");
    ?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
    include_once(APPPATH."views/fe/common/common_search.tpl.php");
    ?>
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
<div id="content">
    <?php
    //include_once(APPPATH."views/fe/common/message.tpl.php");
    ?>
     <div id="div_err">
             <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>   
                     <?php
                        //show_msg("error");  
                        echo validation_errors();
                        //pr($posted);
						
                    ?>
					<?php
					if($check_renew_link)
					{
					?>
						<div class="error_massage">Please renew your account. Click on the link to <a href="<?php echo base_url().'user/subscription'?>">Renew</a>
						</div>
						<?php } ?>
							
							
					
					
             </div>
        <div id="inner_container02">
            <div class="title">
                <h3><span>My</span> Dashboard</h3>
            </div>
            <div class="clr"></div>
            <div id="account_container">
                <div class="account_details">
                    <div class="img_box">
					<?php echo showThumbImageDefault('user_profile',$user_details["s_user_image"],100,100);?>
					
					<?php /*?><?php 
                    if($user_details['image']) 
                    {  
                        $user_image = $user_details['image'][0]['s_user_image']; 
                    ?>                    
                    <img src="<?php echo base_url().'uploaded/user/thumb/thumb_'.$user_image?>" alt="" width="100" height="100" />
                    <?php
                    } else {
                    ?>
                        <img src="images/fe/profile_photo.png" alt="" />
                    <?php } ?><?php */?>
					
                    </div>
                    <div class="txt_box">
                        <h6><?php echo $name; ?></h6>
                        <div class="box01"><img src="images/fe/icon-20.png" alt="" width="30" height="30" /><a href="<?php echo base_url().'tradesman/edit_profile'?>">Edit Account Settings</a></div>
                        <div class="box02"><img src="images/fe/icon-32.png" alt="" width="20" height="20"  style="margin-top:5px;"/><a href="<?php echo base_url().'job/find_job' ?>">Find more Jobs</a></div>
						<div class="box02"><img src="images/fe/icon-24.png" alt="" width="20" height="20"  style="margin-top:5px;"/><a href="<?php echo base_url().'tradesman/edit_email' ?>">My Actions</a></div>
                        <div class="box03"><img src="images/fe/icon-25.png" alt="" width="30" height="30" /><a href="<?php echo base_url().'private_message/tradesman_private_message_board' ?>">
						<?php if($new_msg>0) { ?>
						<strong>You have <?php echo $new_msg ?> new Message(s)</strong> 
						<?php } else { ?>
						You have No new Message(s)
						<?php } ?>
						</a></div>
                        <div class="box03"><img src="images/fe/icon-22.png" alt="" width="30" height="30" />Local time is <?php echo $dt_current_time?> </div>
                        <div class="box03" style="margin-bottom:20px;"> 
                            <?php if($user_details['i_verify_phone']==1)  { echo '<img src="images/fe/icon-08.png" alt="" />'; } ?>
							<!--<img alt="" src="images/fe/icon-14.png">-->
                            <img alt="" src="images/fe/icon-15.png">
							<?php if($user_details['i_verify_facebook']==1)   { echo '<img src="images/fe/icon-10.png" alt="" />'; } ?>
                            <!--<img alt="" src="images/fe/icon-16.png">-->
                            <?php if($user_details['i_verify_credentials']==1)   { echo '<img src="images/fe/icon-11.png" alt="" />'; } ?>
							<!--<img alt="" src="images/fe/icon-17.png">-->
                        </div>
                    </div>
                </div>
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid">
                            <div class="heading_box">
                                <div class="left">My Quotes</div>
                              
                                <div class="right"><a href="<?php echo base_url().'tradesman/quote_jobs'?>">View All</a></div>
                            </div>
                              <?php
                              if($quote_details)
                              {   
							  	$i=1;                               
                                  foreach($quote_details as $val)
                                {
                              ?>
                            <div class="job_box" <?php if($i==2) {?>style="border-bottom: 0px" <?php }?>>
                                <div class="left_content_box">
                                    <p class="blue_txt18"><?=$val['job_details']['s_title']?></p>
                                    <p class="grey_txt12">Posted on : <?=$val['dt_entry_date']?></p>
                                    <p><?=$val['job_details']['s_description']?></p>
                                   <p>&nbsp;</p>
                                    <p><span class="blue_txt">Budget:</span><?php echo $val['job_details']['s_budget_price']?>   &nbsp;&nbsp;|&nbsp;&nbsp; <span class="blue_txt">Category:</span><?php echo $val['job_details']['s_category']?></p>
                                    <p><span class="blue_txt">Quoted Price:</span> <?php echo $val['d_quote']?>&nbsp;&nbsp;|&nbsp;&nbsp; <span class="blue_txt">Quoted On:</span> <?=$val['dt_entry_date']?></p>
                                    <p><span class="blue_txt">Total Quotes:</span><?php echo $val['job_details']['i_quotes']?></p>
                                    <p><span class="blue_txt">Time left:</span> <?php echo $val['job_details']['s_days_left']?> </p>
                                    <p>&nbsp;</p>
                                    <!--<p><img src="images/fe/star-mark01.png" alt="" width="105" height="20" /></p>
                                    <p class="grey_txt12">Rating - 100% Positive</p>-->
                                    
                                </div>
                                <div class="right_content_box">
                                    <div class="top_c">&nbsp;</div>
                                    <div class="mid_c">
                                        <ul>
										<?php
										if($val['job_details']['i_is_active']==1)
										{
										?>
                                            <li>
											<?php
											if($check_subscribtion)
											{
											?>
											<a href="<?php echo base_url().'user/subscription/';?>" >
											<?php } else {?>
											<a href="<?php echo base_url().'tradesman/edit_quote/'.encrypt($val['id']);?>" class="lightbox1_main">
											
											<?php } ?>
											<img src="images/fe/icon-52.png" alt="" /> Revise Your Quote</a></li>
										<?php } ?>	
                                            <li><a href="<?php echo base_url().'job/job_details/'.encrypt($val['job_details']['id'])?>"><img src="images/fe/icon-29.png" alt="" /> View Job</a></li>
                                            <li class="last"><a href="<?php echo base_url().'private_message/private_msg_land/'.encrypt($val['job_details']['id']) ?>"><img src="images/fe/icon-43.png" alt="" /> PMB</a></li>
                                        </ul>
                                    </div>
                                    <div class="bot_c">&nbsp;</div>
                                </div>
                            </div>
                              <?php $i++; } 
                               }else '<div class="job_box">No record found</div>';    
                               ?>                            
                            
                            
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                    
                   <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid">
                            <div class="heading_box">
                                <div class="left">Watch list</div>
                                <div class="right"><a href="<?php echo base_url().'tradesman/watch_list'?>">View All</a></div>
                            </div>
                            <?php
							//pr($job_list);
							if($job_watch_list)
							{
								$i=1;
								foreach($job_watch_list as $val)
								{
							?>
							 <div class="job_box" <?php if($i==2) {?>style="border-bottom: 0px" <?php }?>>
								<div class="left_content_box">
									<p class="blue_txt18"><?php echo $val['job_details']['s_title']?></p>
									<p class="grey_txt12">Expiry on : <?php echo $val['job_details']['dt_expire_date']?></p>
									<p><?php echo $val['job_details']['s_description']?></p>
									<p>&nbsp;</p>
									<p><span class="blue_txt">Budget :</span> £ <?php echo $val['job_details']['d_budget_price']?></p>
									<p><span class="blue_txt">Category  :</span> <?php echo $val['job_details']['s_category']?></p>
									<!--<p><span class="blue_txt">Total Quotes  :</span> <?php echo $val['job_details']['i_quotes']?></p>-->
									<p><span class="blue_txt">Time Left :</span> <?php echo $val['job_details']['s_days_left']?></p>
									<p><span class="blue_txt">Location :</span> <?php echo $val['job_details']['s_state']?>, <?php echo $val['job_details']['s_city']?> <?php //echo $val['job_details']['s_postal_code']?></p>
									<p>&nbsp;</p>
									<!--<p><img src="images/fe/star-mark01.png" alt="" width="105" height="20" /></p>
									<p class="grey_txt12">Rating - 100% Positive</p>-->
								</div>
								<div class="right_content_box">
									<div class="top_c">&nbsp;</div>
									<div class="mid_c">
										<ul>
											<?php
											if($val['job_details']['i_is_active']==1)
											{
											?>
											<li>
											<?php
											if($check_subscribtion)
											{
											?>
											<a href="<?php echo base_url().'user/subscription/';?>" >
											<?php } else {?>
											<a href="<?php echo base_url().'job/quote_job/'.encrypt($val['i_job_id']);?>" class="lightbox1_main">
											<?php } ?>
											<img alt="" src="images/fe/icon-52.png"> Place Quote</a></li>
											<?php } ?>				
											 <li><a href="<?=base_url().'job/job_details/'.encrypt($val['i_job_id'])?>"><img src="images/fe/icon-29.png" alt="" /> View Job</a></li>
											 <li><a href="<?=base_url().'tradesman/delete_watch_list/'.encrypt($val['id'])?>" class="lightbox1_main"><img src="images/fe/delete.png" alt="" />Delete</a></li>
											<li class="last"><a href="<?php echo base_url().'private_message/private_msg_land/'.encrypt($val['i_job_id'])?>"><img src="images/fe/icon-43.png" alt="" /> PMB</a></li>
										</ul>
									</div>
									<div class="bot_c">&nbsp;</div>
								</div>
							</div>
							<?php
								$i++;}
							} else {
								echo '<div class="job_box">No job found</div>';
							}
							?>

                            
                            
                            
                            
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                    
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid">
                            <div class="heading_box">
                                <div class="left">Job Invitations</div>
                                <div class="right"><a href="<?php echo base_url().'tradesman/job_invitation'?>">View All</a></div>
                            </div>							
							
							<?php
							//pr($job_list);
							if($job_invitation_list)
							{
								$i=1;
								foreach($job_invitation_list as $val)
								{
							?>
							 <div class="job_box" <?php if($i==2) {?>style="border-bottom: 0px" <?php }?>>
								<div class="left_content_box">
									<p class="blue_txt18"><?php echo $val['s_title']?></p>
									<p class="grey_txt12">Expiry on : <?php echo $val['dt_expired_date']?></p>
									<p><?php echo $val['s_description']?></p>
									<p>&nbsp;</p>
									<p><span class="blue_txt">Budget :</span> £ <?php echo $val['d_budget_price']?></p>
									<p><span class="blue_txt">Category  :</span> <?php echo $val['s_category_name']?></p>
									<!--<p><span class="blue_txt">Total Quotes  :</span> <?php echo $val['i_quotes']?></p>-->
									<p><span class="blue_txt">Time Left :</span> <?php echo $val['s_days_left']?></p>
									<p><span class="blue_txt">Location :</span> <?php echo $val['s_state']?>, <?php echo $val['s_city']?> <?php //echo $val['s_postal_code']?></p>
									<p>&nbsp;</p>
									<!--<p><img src="images/fe/star-mark01.png" alt="" width="105" height="20" /></p>
									<p class="grey_txt12">Rating - 100% Positive</p>-->
								</div>
								<div class="right_content_box">
									<div class="top_c">&nbsp;</div>
									<div class="mid_c">
										<ul>
											<?php
											if($val['i_is_active']==1)
											{
											?>
											<li>
											<?php
											if($check_subscribtion)
											{
											?>
											<a href="<?php echo base_url().'user/subscription/';?>" >
											<?php } else {?>
											<a href="<?php echo base_url().'job/quote_job/'.encrypt($val['id']);?>" class="lightbox1_main">
											<?php } ?>
											<img alt="" src="images/fe/icon-52.png"> Place Quote</a></li>
											<?php } ?>				
											 <li><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>"><img src="images/fe/icon-29.png" alt="" /> View Job</a></li>
											 <li><a href="<?php echo base_url().'tradesman/chk_invite_job_delete/'.encrypt($val['id'])?>" class="lightbox1_main"><img src="images/fe/delete.png" alt="" />Delete</a></li>
											<li class="last"><a href="<?php echo base_url().'private_message/private_msg_land/'.encrypt($val['id'])?>"><img src="images/fe/icon-43.png" alt="" /> PMB</a></li>
										</ul>
									</div>
									<div class="bot_c">&nbsp;</div>
								</div>
							</div>
							<?php
								$i++;}
							} else {
								echo '<div class="job_box">No job found</div>';
							}
							?>                            
                            
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                    
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid">
                            <div class="heading_box">
                                <div class="left">In Progress</div>
                                <div class="right"><a href="<?php echo base_url().'tradesman/progress_jobs' ?>">View All</a></div>
                            </div>
							<?php
							if($progress_job_list)
							{
								$i=1;
								foreach($progress_job_list as $val)
								{
							?>
							
                             <div class="job_box" <?php if($i==2) {?>style="border-bottom: 0px" <?php }?>>
                                <div class="left_content_box">
                                    <p class="blue_txt18"><?php echo $val['s_title']?></p>
                                    <p class="grey_txt12">Awarded on : <?php echo $val['dt_assigned_date']?></p>
                                    <p><?php echo $val['s_description']?> </p>
                                   <p>&nbsp;</p>
                                    <p><span class="blue_txt">Name :</span> <a href="<?php echo base_url().'user/buyer_profile/'.encrypt($val['i_buyer_user_id']);?>" class="lightbox1_main"><strong><?php echo $val['s_buyer_name']?> </strong></a> </p>
                                    <p>&nbsp;</p>
                                    <p class="big_txt14"><img src="images/fe/icon-44.png" alt="" /><a href="mailto:<?php echo $val['s_buyer_email']?>"><?php echo $val['s_buyer_email']?></a></p>
                                    <p class="big_txt14"><img src="images/fe/icon-45.png" alt="" /><?php echo $val['s_buyer_contact_no']?></p>
                                    <p class="big_txt14"><img src="images/fe/icon-46.png" alt="" /><?php echo $val['s_buyer_address']?><br />
                                    <span><?php echo $val['buyer_dtails']['s_state']?>, <?php echo $val['buyer_dtails']['s_city']?>, <?php echo $val['buyer_dtails']['s_zip']?></span>
                                      <p>
										<?php
										if($val['s_buyer_skype_id'])
										{
										?>
										<span class="blue_txt"><?php echo $val['s_buyer_skype_id']?></span> <img src="images/fe/skype.png" />
										<?php } 
										if($val['s_buyer_yahoo_id'])
										{
										?>
										<span class="blue_txt"><?php echo $val['s_buyer_yahoo_id']?></span><img src="images/fe/yahoo.png" /> 
										<?php
										}
										if($val['s_buyer_msn_id'])
										{
										?>
										<span class="blue_txt"><?php echo $val['s_buyer_msn_id']?></span><img src="images/fe/msn.png" />
										<?php } ?>
										</p>  
                                    <p>&nbsp;</p>
                                    
                                </div>
                                <div class="right_content_box">
                                    <div class="top_c">&nbsp;</div>
                                    <div class="mid_c">
                                        <ul>
                                           <!-- <li><a href="javascript:void(0)"><img src="images/fe/icon-52.png" alt="" /> Revise Your Quote</a></li>-->
                                            <li><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>"><img src="images/fe/icon-29.png" alt="" /> View Job</a></li>
                                            <li class="last"><a href="<?php echo base_url().'private_message/private_msg_land/'.encrypt($val['id'])?>"><img src="images/fe/icon-43.png" alt="" /> PMB</a></li>
                                        </ul>
                                    </div>
                                    <div class="bot_c">&nbsp;</div>
                                </div>
                            </div>
							<div class="blue_box02">
								<div class="b_top">&nbsp;</div>
								<div class="b_mid">
									<h2>In progress </h2>
									<a href="<?php echo base_url().'tradesman/confirm_job_complete/'.$val['id']?>" class="lightbox1_main feedback_btn_new" >Request Feedback</a>
									
								</div>
								<div class="b_bot">&nbsp;</div>
							</div>
													
							
							
							
							
                            <?php
								$i++;}
							} else 
								echo  '<div class="job_box">No job found.</div>';
							?>
                            
                            
                            
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                    
                    
                    
                </div>
                <div class="account_right_panel">
                    <div class="top">&nbsp;</div>
                    <div class="mid">
                        <div class="heading_box">My Quick Actions</div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-24.png" alt="" width="30" height="30" /><a href="<?php echo base_url().'tradesman/quote_jobs' ?>">View all your Quotes</a></div>
                            <div class="box02">
                                <p>Find all the quotes you have placed.</p>
                            </div>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-55.png" alt="" width="30" height="30" /><a href="<?php echo base_url().'tradesman/frozen_jobs' ?>">Jobs Frozen</a></div>
                            <div class="box02">
                                <p>Accept jobs awarded by clients</p>
                            </div>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-56.png" alt="" width="30" height="30" /><a href="<?php echo base_url().'tradesman/lost_jobs' ?>">Jobs Lost</a></div>
                            <div class="box02">
                                <p>View all the jobs you have lost till date.</p>
                            </div>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-25.png" alt="" width="30" height="30" /><a href="<?php echo base_url().'private_message/tradesman_private_message_board' ?>">Messages</a></div>
                            <div class="box02">
                                <p>View private messages from clients.</p>
                            </div>
                        </div>
                        <!--<div class="content_box">
                            <div class="box01"><img src="images/fe/icon-26.png" alt="" width="30" height="30" /><a href="reviews-provided.html">Reviews</a></div>
                            <div class="box02">
                                <p>From here you can view all the reviews that you have received and to be provided</p>
                            </div>
                        </div> -->   
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-27.png" alt="" width="30" height="30" /><a href="<?php echo base_url().'tradesman/tradesman_radar_job' ?>">Radar Jobs</a></div>
                            <div class="box02">
                                <p>View all Jobs available within your radar.</p>
                            </div>
                        </div>
                    </div>
                    <div class="bot">&nbsp;</div>
                </div>
            </div>
            <div class="clr"></div>
        </div>         
        
        
        <div class="clr"></div>
</div>
</div>
      