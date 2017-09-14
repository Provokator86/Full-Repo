 <?php
 //pr($pmb_list);
	if($pmb_list){
	$i=1;
		foreach($pmb_list as $val)
		{
			
	?>

<div class="job_box">
	<div class="left_content_box">
		<p class="blue_txt18"><?php echo $val['s_job_title'] ?></p>
		<p></p>
		 <p>&nbsp;</p>
		<p><span class="blue_txt">Client :</span> </span> <?php echo $val['s_client_name'] ?></p>
		<p class="grey_txt12">Last Update : <?php echo $val['dt_reply_on']?></p>
		<p>&nbsp;</p>
	</div>
	<div class="right_content_box">
		<div class="top_c">&nbsp;</div>
		<div class="mid_c">
			<ul>
			<?php 
				if($val['i_no_msg'])
				 { 
				?>
				<li ><a href="<?php echo base_url().'private_message/tradesman_private_message_details/new__'.encrypt($val['id']) ?>"><img src="images/fe/new_messages.png" alt="" /> New Messages </a></li>
				<?php } ?>
				<li ><a href="<?php echo base_url().'private_message/tradesman_private_message_details/all__'.encrypt($val['id']) ?>"><img src="images/fe/icon-43.png" alt="" /> View Messages </a></li>
				<li class="last"><a href="<?php echo base_url().'job/job_details/'.encrypt($val['job_id']) ?>"><img src="images/fe/icon-29.png" alt="" /> View Job</a></li>
				<!--<li class="last"><a href="javascript:void(0)"><img src="../images/delete.png" alt="" /> Delete Message</a> </li>-->
			</ul>
		</div>
		<div class="bot_c">&nbsp;</div>
	</div>
</div>							

<?php }
	} 
	else {
			echo 'No record found';
		}
		 
?>
<!-- <div class="clr"></div>-->
<div class="paging_box" style="padding:5px 0;">	
	<?php echo $page_links;?>
</div>

