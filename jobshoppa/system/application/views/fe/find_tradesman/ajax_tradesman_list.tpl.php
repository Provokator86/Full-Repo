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
<div class="result_box">
   <div class="top">&nbsp;</div>
	<div class="mid">
		<div class="heading_box"><?php echo $tot_prof; ?> Professional(s) found</div>
		
		 <?php
		 // pr($tradesman_list);
		  if($tradesman_list)
		  {
			$i=1;
			  foreach($tradesman_list as $val)
			  {
			
			$img = (!empty($val["s_user_image"])&&file_exists($image_up_path."thumb_".trim($val["s_user_image"])))?" <img src='".$image_path."thumb_".$val["s_user_image"]."' width='66' height='65'  />":" <img src='images/fe/man.png'/>";
		  ?>
		
	<div class="job_box">
		<div class="left" style="width:380px;">
			<p class="blue_txt18"><?php echo $val['s_business_name'] ?></p>
			<p class="orng_txt12"><?php echo $val['s_username']?></p>
		
			
		</div>
		<div class="right">
			<div class="link_box11"><a href="<?php echo base_url().'tradesman_profile/'?><?php echo encrypt($val['id'])?>">View profile</a></div>
			<!--<div class="link_box07"><a href="javascript:void(0);" onclick="return show_dialog('lightbox2')">Invite to job </a></div>-->
			<?php
			//pr($loggedin);exit;							
			if(decrypt($loggedin['user_type_id'])==1)
			{
			?>
			
			<div class="link_box07"><a href="<?php echo base_url().'invite_tradesman/'.encrypt($val['id']);?>" class="lightbox1_main">Invite to quote </a></div>
			<?php } ?>
			
		</div>
		<div class="clr"></div>
			<p><span class="blue_txt">Skills :</span> <?php echo $val['s_skills']?></p>
			<p style="margin-top:5px;"><?php echo substr($val['s_about_me'],0,150).'...'?></p>
			<p style="font-weight:bold;"><?php echo $val['i_feedback_received']?> Reviews, <?php echo $val['i_jobs_won'] ?> jobs won</p>
		<div class="view_box">
		
			<div class="top_c">&nbsp;</div>
			<?php if($val['i_feedback_received']>0) 
				{ 
					$feedback = $val['feedback'];
		?>	
			<div class="mid_c">
				<p><?php echo $feedback['s_comments']?></p>
				<p><?php echo $feedback['s_sender_user']?></p>
				<p class="grey_txt12"><?php echo $feedback['dt_created_on']?></p>
				<p>&nbsp;</p>
				<?php if($feedback['i_positive']==1) {?>
				<p><?php echo show_star($feedback['i_rating'])?></p>
				<p class="grey_txt12">Rating - <?php echo $feedback['f_positive_feedback_percentage']?>% Positive</p>
				<?php } else { ?>
				<p><?php echo show_star($feedback['i_rating'])?></p>
				<p class="red_txt">Rating - Negative</p>
				<?php } ?>
			</div>
			<?php } else {
			echo '<div class="mid_c">No Feedback rating yet</div>';									  
		 } ?>
			<div class="bot_c">&nbsp;</div>
		 
			<div class="clr"></div>
		</div>
		
		
	</div>		
	
	<?php 
			}
		} else echo 'No Record Found';
	?> 
		
		
		<div class="clr"></div>
		<div class="paging_box" style="padding:10px;">
			<?php echo $page_links?>
		</div>
		<div class="clr"></div>
	</div>
	<div class="bot">&nbsp;</div>
</div>