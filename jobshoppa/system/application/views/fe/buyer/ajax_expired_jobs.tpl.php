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
 // pr($job_list);exit;
	foreach($job_list as $val)
	{
  ?>	
  
  
<div class="job_box <?php echo ($i++%2) ? 'white01' : ''?>">
	<div class="left_content_box">
		<p class="blue_txt18"><?php echo $val['s_title']?></p>
		<p class="grey_txt12">Expired on : <?php echo $val['dt_expired_date']?></p>
		<p><?php echo $val['s_description']?> </p>
		<p>&nbsp;</p>
	</div>
	<div class="right_content_box">
		<div class="top_c">&nbsp;</div>
		<div class="mid_c">
			<ul>
			   <li><a href="<?php echo base_url().'buyer/view_job/'.encrypt($val['id']);?>"><img src="images/fe/icon-29.png" alt="" /> View Job</a></li>
			  <li><a href="<?php echo base_url().'buyer/repost_job/'.encrypt($val['id']);?>"><img src="images/fe/icon-31.png" alt="" /> Repost Job</a></li>
			   <li><a href="javascript:void(0);" onclick="send_msg('<?php echo encrypt($val['id']);?>')"><img src="images/fe/icon-43.png" alt="" /> PMB</a></li>
			  <li class="last"><a href="<?php echo base_url().'job/job_history/'.encrypt($val['id'])?>" class="lightbox1_main"><img src="images/fe/icon-42.png" alt="" /> History</a></li>
			</ul>
		</div>
		<div class="bot_c">&nbsp;</div>
	</div>
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
							