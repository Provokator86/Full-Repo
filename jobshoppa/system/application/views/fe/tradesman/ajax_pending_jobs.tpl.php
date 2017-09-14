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
<?php 
if($job_list)
{
	//pr($job_list);
	$i=1;
	foreach($job_list as $val)
	{
?>
<div class="job_box">
	<div class="left_content_box">
		<p class="blue_txt18"><?php echo $val['s_title']?></p>
		<p class="grey_txt12">Awarded on : <?php echo $val['dt_assigned_date']?></p>
	  	<p><?php echo $val['s_description']?> </p>
		<p>&nbsp;</p>
		<p><span class="blue_txt">Name :</span><a href="<?php echo base_url().'user/buyer_profile/'.encrypt($val['i_buyer_user_id'])?>" class="lightbox1_main"><strong> <?php echo $val['s_buyer_name']?></strong></a> </p>
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
				<li><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>"><img src="images/fe/icon-29.png" alt="" /> View Job</a></li>
				<li class="last"><a href="<?php echo base_url().'private_message/private_msg_land/'.encrypt($val['id'])?>"><img src="images/fe/icon-43.png" alt="" /> PMB</a></li>
			</ul>
		</div>
		<div class="bot_c">&nbsp;</div>
	</div>
	<div class="blue_box02">
		<div class="b_top">&nbsp;</div>
		<div class="b_mid">
			<h2>Client denied completion  </h2>
			<a href="<?php echo base_url().'tradesman/confirm_job_complete/'.$val['id']?>" class="lightbox1_main feedback_btn_new" >Request Feedback</a>
			<!--<input type="button" value="Ask Feedback"  class="feedback_btn" style="margin-top:5px;" />-->
		</div>
		<div class="b_bot">&nbsp;</div>
	</div>
</div>
<?php
	}
} else {
	echo '<div class="job_box">No job found</div>';
}
?>

<div class="clr"></div>
<div class="paging_box" style="padding:5px 0;">
	<?php echo $page_links;?>
</div>
<div class="clr"></div>