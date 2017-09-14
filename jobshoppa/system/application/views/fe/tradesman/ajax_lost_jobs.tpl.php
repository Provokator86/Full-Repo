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
		<p class="grey_txt12">Quote date : <?php echo $val['dt_entry_date']?></p>
		<p><?php echo $val['s_description']?></p>
		<p>&nbsp;</p>

		<!--<p><img src="images/fe/star-mark01.png" alt="" width="105" height="20" /></p>
		<p class="grey_txt12">Rating - 100% Positive</p>-->
	</div>
	<div class="right_content_box">
		<div class="top_c">&nbsp;</div>
		<div class="mid_c">
			<ul>
				 <li><a href="<?=base_url().'job/job_details/'.encrypt($val['i_job_id'])?>"><img src="images/fe/icon-29.png" alt="" /> View Job</a></li>
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


