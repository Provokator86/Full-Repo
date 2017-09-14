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
//pr($job_list);
if($job_list)
{
	$i=1;
	foreach($job_list as $val)
	{
?>
<div class="job_box">
<div class="left_content_box">
	<p class="blue_txt18"><?php echo $val['s_job_title']?></p>
	<p class="grey_txt12">Assigned on : <?php echo $val['dt_assign_date']?></p>
	<p><?php echo $val['s_description']?> </p>
	<p>&nbsp;</p>
	<p><span class="blue_txt">Name : </span><?php echo $val['s_sender_user']?></p>
	 <p>&nbsp;</p>
	<p class="big_txt14"><img src="images/fe/icon-44.png" alt="" /><a href="mailto:<?php echo $val['s_sender_email']?>"><?php echo $val['s_sender_email']?></a></p>
	<p class="big_txt14"><img src="images/fe/icon-45.png" alt="" /><?php echo $val['s_sender_contact_no']?></p>
	<p class="big_txt14"><img src="images/fe/icon-46.png" alt="" /><?php echo $val['s_sender_address']?><br />
		<span><?php echo $val['buyer_dtails']['s_state']?>, <?php echo $val['buyer_dtails']['s_city']?>, <?php echo $val['buyer_dtails']['s_zip']?></span>
		<p>
		<?php
		if($val['s_sender_skype_id']){
		?>
		 <span class="blue_txt"><?php echo $val['s_sender_skype_id'];?></span> <img src="images/fe/skype.png" />
		 <?php } 
		 if($val['s_sender_msn_id']){
		 ?>
		 <span class="blue_txt"><?php echo $val['s_sender_msn_id'];?></span><img src="images/fe/yahoo.png" /> 
		 <?php } 
		 if($val['s_sender_yahoo_id']){
		 ?>
		 <span class="blue_txt"><?php echo $val['s_sender_yahoo_id'];?></span><img src="images/fe/msn.png" />
		 <?php } ?>
		 </p>
	<p>&nbsp;</p>
	
</div>
<div class="right_content_box">
	<div class="top_c">&nbsp;</div>
	<div class="mid_c">
		<ul>
			<li><a href="<?php echo base_url().'job/job_details/'.encrypt($val['i_job_id'])?>"><img src="images/fe/icon-29.png" alt="" /> View Job</a></li>
			<li><a href="<?php echo base_url().'user/buyer_profile/'.encrypt($val['i_sender_user_id'])?>" class="lightbox1_main"><img src="images/fe/icon-53.png" alt="" /> Client Details</a></li>
			<li><a href="<?php echo base_url().'tradesman/post_feedback/'.encrypt($val['id'])?>"  class="lightbox1_main"><img src="images/fe/icon-48.png" alt="" /> Post Reviews</a></li>
			<li class="last"><a href="<?php echo base_url().'private_message/private_msg_land/'.encrypt($val['i_job_id'])?>"><img src="images/fe/icon-43.png" alt="" /> PMB</a></li>
		</ul>
	</div>
	<div class="bot_c">&nbsp;</div>
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


