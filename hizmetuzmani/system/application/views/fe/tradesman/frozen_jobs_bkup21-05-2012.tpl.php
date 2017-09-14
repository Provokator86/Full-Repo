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
	
	/* after clicking on the accept button */
	$("#btn_accept").click(function() { 
	
		var b_valid = true;
		var s_err = '';
		var data_str = $("#h_data").val();
		//alert(data_str);
		
		if($.trim($("#ta_comment").val())=="") //// For  name 
		{
			$("#err_ta_comment").text('<?php echo addslashes(t('Please provide comment'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_ta_comment").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
		
		
		if(b_valid)
		{
			var s_comment = $("#ta_comment").val();
			var i_rating  = $("#rating").val();
			
			$.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'tradesman/confirm_accept_job',
                        data: "data_str="+data_str+"&s_comment="+s_comment+"&i_rating="+i_rating,
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
		
		if($.trim($("#ta_message").val())=="") //// For  name 
		{
			$("#err_ta_message").text('<?php echo addslashes(t('Please provide comment'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_ta_message").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
		
		
		if(b_valid)
		{
			var s_comment = $("#ta_message").val();
			
			$.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'tradesman/confirm_deny_job',
                        data: "data_str="+data_str+"&s_comment="+s_comment,
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
<div class="lightbox05 photo_zoom02 box02 overflow02" style="height:400px;">
<div id="div_err1">
</div>
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
<h2><?php echo addslashes(t('Why do you want to accept this Job'))?>?</h2>

<div class="lable"><?php echo addslashes(t('Comments'))?> </div>
<div class="textfell">
<textarea name="ta_comment" id="ta_comment"></textarea>
</div>
<div class="lable"></div>
<div id="err_ta_comment" class="err"><?php echo form_error('ta_comment') ?></div>
<div class="spacer"></div>

<div class="lable"><?php echo addslashes(t('Rating'))?>  </div>
<div class="textfell">
<select id="rating" name="rating" style="width:269px;">
<?php for($i=1;$i<=5;$i++) { ?>
<option value="<?php echo $i ?>"><?php echo $i ?></option>
<?php } ?>
</select>
<script type="text/javascript">
	$(document).ready(function() {
	  $("#rating").msDropDown();
	   $("#rating").hide();
	   $('#rating_msdd').css("background-image", "url(images/fe/select.png)");
	   $('#rating_msdd').css("background-repeat", "no-repeat");
	   $('#rating_msdd').css("width", "269px");
	   $('#rating_msdd').css("margin-top", "0px");
	   $('#rating_msdd').css("padding", "0px");
		$('#rating_msdd').css("height", "38px");
	});

</script>
</div>
<div class="spacer"></div>

<!--<div class="lable">Positive   </div>
<div class="textfell"><input name="" type="radio" value="" />Yes   <input name="" type="radio" value="" />No </div>
<div class="spacer"></div>-->

<div class="lable">   </div>
<input type="hidden" id="h_data" name="h_data" value="" />
<input class="small_button" id="btn_accept" type="button" value="<?php echo addslashes(t('Submit'))?>" />

</div>
<!--lightbox Accept-->

<!--lightbox Deny-->
<div class="lightbox05 photo_zoom03 box02 overflow02">
<div id="div_err2">
</div>
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
<h2><?php echo addslashes(t('Why do you want to deny this Job'))?>?</h2>



<div class="lable"><?php echo addslashes(t('Comments'))?> </div>
<div class="textfell">
<textarea name="ta_message" id="ta_message"></textarea></div>
<div class="lable"></div>
<div id="err_ta_message" class="err"><?php echo form_error('ta_message') ?></div>
<div class="spacer"></div>


<div class="lable">   </div>
<input type="hidden" id="h_val" name="h_val" value="" />
<input class="small_button" id="btn_deny" type="button" value="<?php echo addslashes(t('Submit'))?>" />

</div>
<!--lightbox Deny-->