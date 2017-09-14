<script type="text/javascript">
$(document).ready(function() {
var param_str = '';
var data_str = '';
	$(".accept_link").click(function() {
	param_str = $(this).attr('rel');
	$("#h_data").val(param_str);
	show_dialog('photo_zoom02');
	});
	
	$(".deny_link").click(function() {
	data_str = $(this).attr('rel');
	$("#h_val").val(data_str);
	show_dialog('photo_zoom03');
	});
	
	$("#btn_denyno").click(function() { 
	hide_dialog('photo_zoom03');
	});
	$("#btn_acceptno").click(function() { 
	hide_dialog('photo_zoom02');
	});
	
	/* after clicking on the accept button */
	$("#btn_accept").click(function() { 
	
		var b_valid = true;
		var s_err = '';
		var data_str = $("#h_data").val();
		//alert(data_str);
		
		if(b_valid)
		{
			
			$.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'tradesman/confirm_accept_job',
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
		}			
		return false;			
					
	
	});
	/* end after clicking on the accept button */
	
	/* after clicking on the accept button */
	$("#btn_deny").click(function() { 
	
		var b_valid = true;
		var s_err = '';
		var data_str = $("#h_val").val();
		//alert(data_str);
		
		if(b_valid)
		{
			//var s_comment = $("#ta_message").val();
			
			$.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'tradesman/confirm_deny_job',
                        data: "data_str="+data_str,
                        success: function(msg){
                            if(msg)
                            {
								msg = msg.split('|');
								var s_msg = msg[1];								
								if(msg[0]==1)
								{
									$('#div_err2').html('<div class="success_massage">'+s_msg+'<div>');
								}
								else
									$('#div_err2').html('<div class="error_massage">'+s_msg+'<div>');
							}
                        }
                    });
					
			setTimeout('window.location.reload()',2000);		
		}			
		return false;			
					
	
	});
	/* end after clicking on the accept button */
	
});
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
            <div class="top_part"></div>
	<div class="midd_part height02">
	  <div class="username_box">
		<div class="right_box03">
			  <h4><?php echo addslashes(t('Jobs You Got'))?></h4>
			  
			  <div class="div01">
			  <h2><?php echo addslashes(t('Congratulations'))?>!</h2>
			  <p><?php echo addslashes(t('From here you can view those jobs awarded to you by Buyers. The buyers have selected you as the winning bidder but you havent accepted the job offer yet. Please accept the job offer to win the auction.'))?></p>
			  <div class="spacer"></div>
			  </div>
			  <div id="job_list">
			  <?php echo $job_contents; ?>
			  </div>
			  
			  <div class="spacer"></div>
			  
			  <div class="icon_bar">
			  <ul>
			  <li><img src="images/fe/view.png" alt="" /> <?php echo addslashes(t('View'))?></li>
			   <li>|</li>
			  <li class="last"><img src="images/fe/mass.png" alt="" /><?php echo addslashes(t('Messages'))?></li>
			  </ul>
			   <div class="spacer"></div>
			  </div>
			   <div class="spacer"></div>
			  
		</div>
			<?php include_once(APPPATH."views/fe/common/tradesman_left_menu.tpl.php"); ?>
			<div class="spacer"></div>
	  </div>
		  <div class="spacer"></div>
	</div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>
</div>

<!--lightbox Accept-->
<div class="lightbox05 photo_zoom02 box02 overflow02">
<div id="div_err1">
</div>
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
<h2><?php echo addslashes(t('Are you sure you want to accept this Job'))?>?</h2>

<div class="buttondiv">
<input type="hidden" name="h_data" id="h_data" value="" />
<input class="login_button flote02" type="button" id="btn_accept" value="<?php echo addslashes(t('Yes'))?>" />
<input class="login_button flote02" type="button" id="btn_acceptno" value="<?php echo addslashes(t('No'))?>" />
</div>
</div>
<!--lightbox Accept-->

<!--lightbox Deny-->
<div class="lightbox05 photo_zoom03 box02 overflow02">
<div id="div_err2">
</div>
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
<h2><?php echo addslashes(t('Are you sure you want to deny this Job'))?>?</h2>

<div class="buttondiv">
<input type="hidden" name="h_val" id="h_val" value="" />
<input class="login_button flote02" type="button" id="btn_deny" value="<?php echo addslashes(t('Yes'))?>" />
<input class="login_button flote02" type="button" id="btn_denyno" value="<?php echo addslashes(t('No'))?>" />
</div>

</div>
<!--lightbox Deny-->