<script type="text/javascript">
$(document).ready(function () {
	
	$(".login_button02").click(function() {
	var param_str = $(this).attr('rel');
	$("#h_data").val(param_str);
	show_dialog('photo_zoom03');
	});
	
	$(".link_reject").click(function() {
	var param_str = $(this).attr('rel');
	$("#h_reject").val(param_str);
	show_dialog('photo_zoom04');
	});
	
	/* accept quote */
	$("#btn_no").click(function() { 
	hide_dialog('photo_zoom03');
	});
	
	$("#btn_yes").click(function() { 
	
		var data_str = $("#h_data").val();
		//alert(data_str);
		$.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'buyer/tradesman_assign_job',
                        data: "data_str="+data_str,
                        success: function(msg){
                            if(msg)
                            {
								msg = msg.split('|');
								var s_msg = msg[1];								
								if(msg[0]==1)
								{
									$('#div_err1').html('<div class="success_massage">'+s_msg+'<div>');
								}
								else
									$('#div_err1').html('<div class="error_massage">'+s_msg+'<div>');
							}
                        }
                    });
					
		setTimeout('window.location.reload()',2000);			
	
	});
	/* accept quote */
	
	/* reject quote */
	$("#reject_no").click(function() { 
	hide_dialog('photo_zoom04');
	});
	
	$("#reject_yes").click(function() { 
	
		var data_str = $("#h_reject").val();
		//alert(data_str);
		$.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'buyer/tradesman_reject_quote',
                        data: "data_str="+data_str,
                        success: function(msg){
                            if(msg)
                            {
								msg = msg.split('|');
								var s_msg = msg[1];								
								if(msg[0]==1)
								{
									$('#div_err4').html('<div class="success_massage">'+s_msg+'<div>');
								}
								else
									$('#div_err4').html('<div class="error_massage">'+s_msg+'<div>');
							}
                        }
                    });
					
		setTimeout('window.location.reload()',2000);			
	
	});
	/* reject quote */
});
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?> 
<div class="job_categories">
	<div class="top_part"></div>
	<div class="midd_part height02">
	  <div class="username_box">
		<div class="right_box03">
		  <h4><?php echo addslashes(t('Quote(s)'))?></h4>
		  <div class="div01">
				<p><?php echo addslashes(t('This section consists of quotes placed against a job by different tradesman'))?>.</p>
				<div class="spacer"></div>
		  </div>
		  <!-- job details -->
		  <h4><span><?php echo t('Job Overview')?></span></h4>		 
		  <div class="find_box02">
		  <table width="100%" cellspacing="0" cellpadding="0" style="border:1px dashed #ccc;">
		  	<tbody>
				<tr>
                <?php $job_url    =   make_my_url($job_details['s_title']).'/'.encrypt($job_details['id']) ; ?>
					<td valign="middle" align="left" style="border-right:none; border-bottom:none;"><h5><a href="<?php echo base_url().'job-details/'.$job_url ; ?>" target="_blank"><?php echo string_part($job_details['s_title'],100)?></a></h5><?php echo string_part($job_details['s_description'],150) ?></br>
					  <ul>
						  <li><?php echo addslashes(t('Budget'))?>: <span><?php echo $job_details['s_budget_price']?></span></li>
						  <li>|</li>
						  <li><?php echo addslashes(t('Lowest bid'))?>:<span> <?php echo $job_details['s_lowest_quote']?></span></li>
				      </ul>					                                                       
			    </td>
				</tr>
			</tbody>
		  </table>
		  </div>
			<!-- end job details -->
				  
		  <!-- job list -->
		  <div id="job_list">
		  <?php echo $job_contents ?>
		  </div>
		  <!-- job list -->
		  	  
		</div>
			<?php include_once(APPPATH."views/fe/common/buyer_left_menu.tpl.php"); ?>
			<div class="spacer"></div>
	  </div>
       <div class="spacer"></div>
     </div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>
</div>

<form name="ajax_quote_confirm" id="ajax_quote_confirm" method="post" action="<?php echo base_url().'buyer/tradesman_assign_job'?>">
<!--lightbox-->
<div class="lightbox04 photo_zoom03">
<div id="div_err1">
</div>
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
<h3><?php echo addslashes(t('Are you sure to choose this tradesman for the job'))?> "<?php echo $job_details['s_title'] ?>"?</h3>
<div class="buttondiv">
<input type="hidden" name="h_data" id="h_data" value="" />
<input class="login_button flote02" type="button" id="btn_yes" value="<?php echo addslashes(t('Yes'))?>" />
<input class="login_button flote02" type="button" id="btn_no" value="<?php echo addslashes(t('No'))?>" />
</div>
</div>
<!--lightbox-->
</form>

<!--lightbox-->
<div class="lightbox04 photo_zoom04">
<div id="div_err4">
</div>
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
<h3><?php echo addslashes(t('Are you sure to reject this quote for the job'))?> "<?php echo $job_details['s_title'] ?>"?</h3>
<div class="buttondiv">
<input type="hidden" name="h_reject" id="h_reject" value="" />
<input class="login_button flote02" type="button" id="reject_yes" value="<?php echo addslashes(t('Yes'))?>" />
<input class="login_button flote02" type="button" id="reject_no" value="<?php echo addslashes(t('No'))?>" />
</div>
</div>
<!--lightbox-->

