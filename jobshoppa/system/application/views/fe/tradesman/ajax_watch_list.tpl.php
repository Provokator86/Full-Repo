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
		<p class="blue_txt18"><?php echo $val['job_details']['s_title']?></p>
		<p class="grey_txt12">Expiry on : <?php echo $val['job_details']['dt_expire_date']?></p>
		<p><?php echo $val['job_details']['s_description']?></p>
		<p>&nbsp;</p>
		<p><span class="blue_txt">Budget :</span> £ <?php echo $val['job_details']['d_budget_price']?></p>
		<p><span class="blue_txt">Category  :</span> <?php echo $val['job_details']['s_category']?></p>
		<!--<p><span class="blue_txt">Total Quotes  :</span> <?php echo $val['job_details']['i_quotes']?></p>-->
		<p><span class="blue_txt">Time Left :</span> <?php echo $val['job_details']['s_days_left']?></p>
		<p><span class="blue_txt">Location :</span> <?php echo $val['job_details']['s_state']?>, <?php echo $val['job_details']['s_city']?> <?php //echo $val['job_details']['s_postal_code']?></p>
		<p>&nbsp;</p>
		<!--<p><img src="images/fe/star-mark01.png" alt="" width="105" height="20" /></p>
		<p class="grey_txt12">Rating - 100% Positive</p>-->
	</div>
	<div class="right_content_box">
		<div class="top_c">&nbsp;</div>
		<div class="mid_c">
			<ul>
				<?php
				if($val['job_details']['i_is_active']==1)
				{
				?>
				<li><a href="<?php echo base_url().'job/quote_job/'.encrypt($val['i_job_id']);?>" class="lightbox1_main"><img alt="" src="images/fe/icon-52.png"> Place Quote</a></li>
				<?php } ?>				
				 <li><a href="<?=base_url().'job/job_details/'.encrypt($val['i_job_id'])?>"><img src="images/fe/icon-29.png" alt="" /> View Job</a></li>
				 <li><a href="<?=base_url().'tradesman/delete_watch_list/'.encrypt($val['id'])?>" class="lightbox1_main"><img src="images/fe/delete.png" alt="" />Delete</a></li>
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


