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
 <div class="heading_box">
 </div>
  <?php
  if($job_list)
  {
  	$i=1;
  //pr($job_list);exit;
	foreach($job_list as $val)
	{
  ?>	
  
<div class="job_box <?php echo ($i++%2) ? 'white01' : ''?>">
<div class="left_content_box">
	<p class="blue_txt18"><?php echo $val['s_title']?></p>
	<p class="grey_txt12">Assigned on: <?php echo $val['dt_assigned_date']?></p>
	<p><?php echo $val['s_description']?></p>
	<p>&nbsp;</p>
	<?php
	if($val['i_status']==5)
	{
	?>
	<p><span class="blue_txt">Professional Name:</span> <?php echo $val['s_username']?></p>
	<p>&nbsp;</p>
	<p class="big_txt14"><img src="images/fe/icon-44.png" alt="" /><a href="mailto:<?php echo $val['s_email']?>"><?php echo $val['s_email']?></a></p>
	<p class="big_txt14"><img src="images/fe/icon-45.png" alt="" /><?php echo $val['s_contact_no']?></p>
	<p class="big_txt14"><img src="images/fe/icon-46.png" alt="" /><?php echo $val['s_address']?><br />
		</p>
		<p><span class="blue_txt"><?php echo $val['s_skype_id']?></span> <img src="images/fe/skype.png" /> <span class="blue_txt"><?php echo $val['s_msn_id']?></span><img src="images/fe/yahoo.png" /> <span class="blue_txt"><?php echo $val['s_yahoo_id']?></span><img src="images/fe/msn.png" /></p>
		<p></p>
	<?php } ?>	
	<p>&nbsp;</p>
</div>
<div class="right_content_box">
	<div class="top_c">&nbsp;</div>
	<div class="mid_c">
		<ul>
			<li><a href="<?php echo base_url().'job/job_history/'.encrypt($val['id'])?>" class="lightbox1_main"><img src="images/fe/icon-42.png" alt="" /> History</a></li>
			 <li><a href="<?php echo base_url().'buyer/view_job/'.encrypt($val['id']);?>"><img src="images/fe/icon-29.png" alt="" /> View Job</a></li>
			<li><a href="javascript:void(0);" onclick="send_msg('<?php echo encrypt($val['id']);?>')"><img src="images/fe/icon-43.png" alt="" /> PMB</a></li>
			<?php
			if($val['i_status']==4)
			{
			?>
			<li class="last"><a href="<?php echo base_url().'buyer/job_terminate_box/'.$val['id']?>" class="lightbox1_main"><img src="images/fe/icon-47.png" alt="" /> Terminate</a></li>
			<?php } ?>
		</ul>
	</div>
	<div class="bot_c">&nbsp;</div>
</div>
		<?php
		if($val['i_status']==5)
		{
		?>
		<div class="blue_box02">
			<div class="b_top">&nbsp;</div>
			<div class="b_mid">
				<h2>Professional declared this job as completed</h2>
			   <p><a href="<?php echo base_url().'buyer/give_feedback/'.$val['id']?>" class="lightbox1_main"><img src="images/fe/btn-accept.png" alt="" /></a> &nbsp; <a href="<?php echo base_url().'buyer/deny_feedback/'.$val['id']?>" class="lightbox1_main"><img src="images/fe/btn-deny.png" alt="" /></a></p>
			</div>
			<div class="b_bot">&nbsp;</div>
		</div>	
		<?php
		} else {
		?>
		<div class="blue_box02">
			<div class="b_top">&nbsp;</div>
			<div class="b_mid">
				<h2><?php echo $val['s_is_active']?></h2>
				
			</div>
			<div class="b_bot">&nbsp;</div>
		</div>
		<?php } ?>

</div>    			
	  <?php
			}
	  }	else
		echo  '<div class="job_box">No job found.</div>';
	  ?>
	
	<div class="clr"></div>
	<div class="paging_box" style="padding:5px 0;">
			<?php echo $page_links;?>
	</div>
	<div class="clr"></div>
							