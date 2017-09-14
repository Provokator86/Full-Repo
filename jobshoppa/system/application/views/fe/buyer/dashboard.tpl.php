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
function send_msg(param)
{
	$('#opd_job').val(param);
	$('#frm_msg').submit();
}
</script>
<div id="banner_section">
    <?php
	include_once(APPPATH."views/fe/common/header_top.tpl.php");
	?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
	include_once(APPPATH."views/fe/common/common_buyer_search.tpl.php");
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
             </div>
        <div id="inner_container02">
            <div class="title">
                <h3><span>My</span> Dashboard</h3>
            </div>
            <div class="clr"></div>
            <div id="account_container">
                <div class="account_details">
                    <div class="img_box">
					<?php 
					//pr($user_details);exit;
					if($user_details['image']) 
					{  
						$user_image = $user_details['image'][0]['s_user_image']; 
					?>					
					<img src="<?php echo base_url().'uploaded/user/thumb/thumb_'.$user_image?>" alt="" width="100" height="100" />
					<?php
					} else {
					?>
						<img src="images/fe/profile_photo.png" alt="" />
					<?php } ?>
					</div>
                    <div class="txt_box">
                        <h6><?php echo $name; ?></h6>
                        <div class="box01"><img src="images/fe/icon-20.png" alt="" width="30" height="30" /><a href="<?php echo base_url().'buyer/edit_profile'?>">Edit Account Settings</a></div>
                        <div class="box02"><img src="images/fe/icon-23.png" alt="" width="30" height="30" /><a href="<?php echo base_url().'job/job_post'?>">Post a Different Job</a></div>
                        <div class="box02"><img src="images/fe/icon-24.png" alt="" width="30" height="30" /><a href="<?php echo base_url().'buyer/contact_details/'?>">My Actions</a></div>
						<div class="box03"><img src="images/fe/icon-25.png" alt="" width="30" height="30" /><a href="<?php echo base_url().'private_message/private_message_board' ?>">
						
						<?php if($new_msg>0) { ?>
						<strong>You have <?php echo $new_msg ?> new Message(s)</strong> 
						<?php } else { ?>
						You have No new Message(s)
						<?php } ?>
						</a></div>
                      <div class="box03"><img src="images/fe/icon-22.png" alt="" width="30" height="30" />Local time is <?php echo $dt_current_time;?> </div>
                    </div>
                </div>
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid">
                            <div class="heading_box">Active Jobs</div>
							<?php
							  if($open_jobs)
							  {		
							  	$i=1;
							  //pr($open_jobs);					  	
							  	foreach($open_jobs as $val)
								{
							  ?>
							
                             <div class="job_box" <?php if($i==2) {?>style="border-bottom: 0px" <?php }?>>
                                <div class="left_content_box">
                                	<p class="blue_txt18"><?php echo $val['s_title']?></p>
                                    <p class="grey_txt12">Posted on : <?php echo $val['dt_entry_date']?></p>
                                    <p><?php echo $val['s_description']?> </p>
                                    <p>&nbsp;</p>
                                    <p><span class="blue_txt">Location:</span> <?php echo $val['s_state']?>, <?php echo $val['s_city']?>,  <?php echo $val['s_postal_code']?></p>
                                	<p><span class="blue_txt">Time left:</span> <?php echo $val['s_days_left']?>    &nbsp;&nbsp;|&nbsp;&nbsp; <span class="blue_txt">Budget:</span> £<?php echo $val['d_budget_price']?></p>
                                	<p><span class="blue_txt">Interested:</span> <?php echo $val['i_interested']?>    &nbsp;&nbsp;|&nbsp;&nbsp; <span class="blue_txt">Quotes:</span> <?php echo $val['i_quotes']?></p>
                                    <p>&nbsp;</p>
                                    <!--<div class="blue_box01">
                                        <h2>Get more Professional, faster</h2>
                                        <p class="big_txt16"><a href="search-invite.html"><img src="images/fe/icon-32.png" alt="" />Search and Invite Professional</a></p>
                                  </div>-->
                                </div>
                                <div class="right_content_box">
                                    <div class="top_c">&nbsp;</div>
                                    <div class="mid_c">
                                        <ul>
                                            <!--<li><a href="javascript:void(0)" onclick="return show_dialog('upload_box')"><img src="images/fe/icon-28.png" alt="" /> Add Pictures/Files</a></li>-->
                                            <li><a href="<?php echo base_url().'buyer/view_job/'.encrypt($val['id']);?>"><img src="images/fe/icon-29.png" alt="" /> View Quotes</a></li>
                                            <!--<li><a href="javascript:void(0)" onclick="return show_dialog('cancel_box')"><img src="images/fe/icon-30.png" alt="" /> Cancel Job</a></li>-->
                                            <li><a href="<?php echo base_url().'buyer/edit_job/'.encrypt($val['id']);?>"><img src="images/fe/icon-31.png" alt="" /> Edit Job</a></li>
                                            <li><a href="<?php echo base_url().'job/job_history/'.encrypt($val['id'])?>" class="lightbox1_main"><img src="images/fe/icon-42.png" alt="" /> History</a></li>
                                            <li class="last"><a href="javascript:void(0);" onclick="send_msg('<?php echo encrypt($val['id']);?>')"><img src="images/fe/icon-43.png" alt="" /> PMB</a></li>
                                        </ul>
                                    </div>
                                    <div class="bot_c">&nbsp;</div>
                                </div>
                            </div>
                         <?php
						 	$i++;}
						 } else {
						 	echo '<div class="job_box">No record found</div>';    
							
						}						 
						 ?>   
							
							
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid">
                            <div class="heading_box">My Job Completion Alert</div>
							<?php
							  if($feedback_job_list)
							  {
							  	$i=1;
							  	foreach($feedback_job_list as $val)
								{ 
							  ?>
							
                            <div class="job_box" <?php if($i==2) {?>style="border-bottom: 0px" <?php }?>>
                                <p class="blue_txt18"><?php echo $val['s_title']?></p>
                                    <p class="grey_txt12">Posted on : <?php echo $val['dt_entry_date']?></p>
                                    <p><?php echo $val['s_description']?> </p>
                                    <p>&nbsp;</p>
                                    <p><span class="blue_txt">Location:</span> <?php echo $val['s_state']?>, <?php echo $val['s_city']?>,  <?php echo $val['s_postal_code']?></p>
                                	<p><span class="blue_txt">Time left:</span> <?php echo $val['s_days_left']?> &nbsp;&nbsp;|&nbsp;&nbsp; <span class="blue_txt">Budget:</span> £<?php echo $val['d_budget_price']?></p>
                                	<p><span class="blue_txt">Interested:</span> 5    &nbsp;&nbsp;|&nbsp;&nbsp; <span class="blue_txt">Quotes:</span> <?php echo $val['i_quotes']?></p>
                                    <p>&nbsp;</p>
                                <p><span class="blue_txt">Professional Name :</span> <?php echo $val['s_username']?></p>
                                <p>&nbsp;</p>
                                <div class="blue_box02">
                                    <div class="b_top">&nbsp;</div>
                                    <div class="b_mid">
                                        <h2>Professional declared this job as completed</h2>
                                          <p><a href="<?php echo base_url().'buyer/give_feedback/'.$val['id']?>"  class="lightbox1_main"><img src="images/fe/btn-accept.png" alt="" /></a> &nbsp; <a href="<?php echo base_url().'buyer/deny_feedback/'.$val['id']?>" class="lightbox1_main"><img src="images/fe/btn-deny.png" alt="" /></a></p>
                                    </div>
                                    <div class="b_bot">&nbsp;</div>
                                </div>
                            </div>
                            <?php
						 		$i++;}
							 } else {
								echo '<div class="job_box">No record found</div>';									
							}						 
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
                            <div class="box01"><img src="images/fe/icon-24.png" alt="" width="30" height="30" /><a href="<?php echo base_url().'buyer/all_jobs' ?>"> View all my Jobs posted</a></div>
                            <div class="box02">
                                <p>View the progress of all jobs submitted</p>
                            </div>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-25.png" alt="" width="30" height="30" /><a href="<?php echo base_url().'private_message/private_message_board'; ?>">Messages</a></div>
                            <div class="box02">
                                <p>View private messages from service professionals</p>
                            </div>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-26.png" alt="" width="30" height="30" /><a href="<?php echo base_url().'buyer/feedback_received' ?>">Reviews</a></div>
                            <div class="box02">
                                <p>View reviews received from service professionals</p>
                            </div>
                        </div>
                        <div class="content_box">
                            <div class="box01"><img src="images/fe/icon-27.png" alt="" width="30" height="30" /><a href="<?php echo base_url().'find_tradesman' ?>">Look for a Professional</a></div>
                            <div class="box02">
                                <p>Find the perfect match for your job </p>
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
