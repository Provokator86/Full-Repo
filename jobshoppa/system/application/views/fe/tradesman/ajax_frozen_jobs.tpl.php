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
		<p class="blue_txt18"><?php echo $val['s_title']?></p>
		<p class="grey_txt12">Assigned on : <?php echo $val['dt_assigned_date']?></p>
		<p><?php echo $val['s_description']?> </p>
		<p>&nbsp;</p>
		<?php /*?><p><span class="blue_txt">Name : </span><?php echo $val['s_buyer_name']?></p>
		 <p>&nbsp;</p>
		<p class="big_txt14"><img src="images/fe/icon-44.png" alt="" /><a href="mailto:wasim@gmail.com"><?php echo $val['s_email']?></a></p>
		<p class="big_txt14"><img src="images/fe/icon-45.png" alt="" /><?php echo $val['s_contact_no']?></p>
		<p class="big_txt14"><img src="images/fe/icon-46.png" alt="" /><?php echo $val['s_contact_no']?><br />
			<span>Llanddoged</span></p>
			<p><span class="blue_txt">alex.brown</span> <img src="images/fe/skype.png" /> <span class="blue_txt">alex_brown</span><img src="images/fe/yahoo.png" /> <span class="blue_txt">alex-brown</span><img src="images/fe/msn.png" /></p>
		<p>&nbsp;</p><?php */?>
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
			<h2>Job Awarded</h2>
			<p><a href="<?=base_url().'tradesman/pay_job/'.encrypt($val['id'])?>"><img src="images/fe/btn-accept.png" alt="" /></a> &nbsp; <a href="<?php echo base_url().'tradesman/deny_job/'.$val['id']?>" class="lightbox1_main" ><img src="images/fe/btn-deny.png" alt="" /></a></p>
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


