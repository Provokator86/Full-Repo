<?php
//pr($feedback_list);
if($feedback_list)
{
$i=1;
  foreach($feedback_list as $val)
  {
	
	$job_link = base_url().'job/job_details/'.encrypt($val['i_job_id']);
?>
<div class="job_box">
	<p class="blue_txt18"><?php echo  $val['s_job_title']?></p>
	<p class="orng_txt12"><?php echo $val['s_sender_user']?></p>
	<div class="view_box">
		<div class="top_c">&nbsp;</div>
		<div class="mid_c">
			<p><?php echo $val['s_comments']?></p>
			<p class="grey_txt12"><?php echo $val['dt_created_on']?></p>
			<p>&nbsp;</p>
			<p>
			 <?php echo show_star($val['i_rating']);?>
			</p>
			<!--<p class="grey_txt12">Rating - 100% Positive</p>-->
		</div>
		<div class="bot_c">&nbsp;</div>
	</div>
</div>
<?php 
	}
} else echo 'No Reviews Found';

?>     
  


<div class="clr"></div>
<div class="paging_box" style="padding:5px 0;">
	 <?php echo $page_links?>
</div>
