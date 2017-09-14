<script>
jQuery(document).ready(function() {
	/*$.fancybox({
				'orig' : $(obj),
				'autoDimensions' : false,
				'padding' :0,
				'width' : 500,
				'height' : 250,
				'centerOnScroll' : true,
				'modal' : true,
				'content' : $('#delete_cat').html()
			});*/


		$(".lightbox1_main").fancybox({
			/*'autoDimensions' : false,
				'padding' :0,
				'width' : 500,
				'height' : 250,
				'centerOnScroll' : true,
				'modal' : true,*/
		
			'titlePosition'		: 'inside',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'showCloseButton'	: true
		});
});
</script>
<div class="heading_box">
						  
</div>
  <?php
  if($job_list)
  {
  //pr($job_list);exit;
	$i=1;
		foreach($job_list as $val)
		{
  ?>	
	<div class="job_box <?php echo ($i++%2) ? 'white01' : ''?>">
		<div class="left_content_box">
			<p class="blue_txt18"><?php echo $val['s_title']?></p>
			<p class="grey_txt12">Posted on : <?php echo $val['dt_entry_date']?></p>
			<p><?php echo $val['s_description']?></p>
			<p>&nbsp;</p>
		</div>
		<div class="right_content_box">
			<div class="top_c">&nbsp;</div>
			<div class="mid_c">
				<ul>
					<li ><a href="<?php echo base_url().'buyer/view_job/'.encrypt($val['id']);?>"><img src="images/fe/icon-29.png" alt="" /> View Job</a></li>
					<?php
					if($val['i_status']!=0)
					{
					?>
					<li><a href="javascript:void(0);" onclick="send_msg('<?php echo encrypt($val['id']);?>')"><img src="images/fe/icon-43.png" alt="" /> PMB</a></li>
					<?php } else {?>
					<li><a href="<?php echo base_url().'buyer/chk_delete/'.encrypt($val['id'])?>" class="lightbox1_main"><img src="images/fe/delete.png" alt="" /> Delete Job</a></li>
					<?php } 
					if($val['i_status']==0 || $val['i_status']==1 || $val['i_status']==8){
					?>
					<li><a href="<?php echo base_url().'buyer/edit_job/'.encrypt($val['id']);?>"><img src="images/fe/icon-31.png" alt="" /> Edit Job</a></li>
					<?php } 
					if($val['i_status']==4)
					{
					?>
					<li><a href="<?php echo base_url().'buyer/job_terminate_box/'.$val['id']?>" class="lightbox1_main"><img src="images/fe/icon-47.png" alt="" /> Terminate</a></li>
					<?php 
					} 
					?>	
				   <li class="last"><a href="<?php echo base_url().'job/job_history/'.encrypt($val['id'])?>" class="lightbox1_main"><img src="images/fe/icon-42.png" alt="" /> History</a></li>
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
				<h2><?php echo $val['s_job_status']?></h2>
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
							