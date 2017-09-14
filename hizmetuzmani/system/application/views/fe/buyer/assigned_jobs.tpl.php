<script type="text/javascript">
$(document).ready(function() {
  var param_str = '';
  var data_str = '';
	$(".job_accept").click(function() {
	param_str = $(this).attr('rel');
	$("#h_job_id").val(param_str);
	show_dialog('photo_zoom02');
	});
	
	$(".job_deny").click(function() {
	data_str = $(this).attr('rel');
	$("#h_data_id").val(data_str);
	show_dialog('photo_zoom05');
	});
	
	$(".login_button02").click(function() {
	data_str = $(this).attr('rel');
	$("#h_job_terminate").val(data_str);
	show_dialog('photo_zoom04');
	});
	
	/* clicking on the submit button for job accept complete */
	$("#btn_accept").click(function() {
		var b_valid = true;
		
		if($.trim($("#s_comment").val())=="") //// For  name 
		{
			$("#err_s_comment").text('<?php echo addslashes(t('Please provide comment'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_s_comment").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
		
		var myRadio = $("input[name='i_rate']:checked").val();
		if(myRadio==1)
		{
			if($("#rating option:selected").val()<=2)
			{
				$("#err_rating").text('<?php echo addslashes(t('Please select rating greater than 2'))?>').slideDown('slow');
				b_valid  =  false;
			}
			else
			{
				$("#err_rating").slideUp('slow').text('<?php echo addslashes(t(''))?>');
			}
		}
		else
		{
			if($("#rating option:selected").val()>2)
			{
				$("#err_rating").text('<?php echo addslashes(t('Please select rating less than 3'))?>').slideDown('slow');
				b_valid  =  false;
			}
			else
			{
				$("#err_rating").slideUp('slow').text('<?php echo addslashes(t(''))?>');
			}
		}
		
		if(b_valid)
		{
			var i_job_id 	= $("#h_job_id").val();
			var s_comment 	= $("#s_comment").val();
			var i_rate		= $("#rating").val();
			var is_positive	= myRadio;
			$.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'buyer/confirm_job_complete',
                        data: "i_job_id="+i_job_id+"&s_comment="+s_comment+"&i_rating="+i_rate+"&is_positive="+is_positive,
                        success: function(msg){
                            if(msg)
                            {
								msg = msg.split('|');
								var s_msg = msg[1];								
								if(msg[0]==1)
								{
									$('#div_err3').html('<div class="success_massage">'+s_msg+'<div>');
								}
								else
									$('#div_err3').html('<div class="error_massage">'+s_msg+'<div>');
							}
							
							
                        }
						
						
                    });
					
		setTimeout('window.location.reload()',2000);			
	
	
		}
		
	});
	/* clicking on the submit button for job accept complete */
	
	/* clicking on the submit button for deny job complete */
	$("#btn_deny").click(function() {
		var b_valid = true;
		
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
			var i_job_id 	= $("#h_data_id").val();
			var s_comment 	= $("#ta_message").val();
			var i_rate		= $("#ratting").val();
			
			$.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'buyer/deny_job_complete',
                        data: "i_job_id="+i_job_id+"&s_comment="+s_comment+"&i_rating="+i_rate,
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
		
	});
	/* clicking on the submit button for deny job complete */
	
	/* clicking on the submit button for terminate from job */
	$("#btn_terminate").click(function() {
		var b_valid = true;
		
		if($.trim($("#s_reason").val())=="") //// For  name 
		{
			$("#err_s_reason").text('<?php echo addslashes(t('Please provide terminate reason'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_s_reason").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
		if($.trim($("#s_feedback").val())=="") //// For  name 
		{
			$("#err_s_feedback").text('<?php echo addslashes(t('Please provide feedback'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_s_feedback").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
				
		if(b_valid)
		{
			var i_job_id 	= $("#h_job_terminate").val();
			var s_reason 	= $("#s_reason").val();
			var s_feedback 	= $("#s_feedback").val();
			var i_rate		= $("#feedback").val();
			$.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'buyer/save_job_terminate',
                        data: "i_job_id="+i_job_id+"&s_reason="+s_reason+"&s_feedback="+s_feedback+"&i_rating="+i_rate,
                        success: function(msg){
                            if(msg)
                            {
								msg = msg.split('|');
								var s_msg = msg[1];	
														
								if(msg[0]==1)
								{
									$('#div_err5').html('<div class="success_massage">'+s_msg+'<div>');
								}
								else
									$('#div_err5').html('<div class="error_massage">'+s_msg+'<div>');
							}
                        }
                    });
					
		setTimeout('window.location.reload()',3000);			
	
	
		}
		
	});
	/* clicking on the submit button for terminate from job */
	
});
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?> 
<div class="job_categories">
	<div class="top_part"></div>
	<div class="midd_part height02">
	  <div class="username_box">
		<div class="right_box03">
		  <h4><?php echo addslashes(t('Assigned Jobs'))?></h4>
		  <div class="div01">
				<p><?php echo addslashes(t('This section consists of jobs that are under progress, and declared as completed'))?>.</p>
				<div class="spacer"></div>
		  </div>
		  <!-- job list -->
		  <div id="job_list">
		  <?php echo $job_contents ?>
		  </div>
		  <!-- job list -->
		  	
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
			<?php include_once(APPPATH."views/fe/common/buyer_left_menu.tpl.php"); ?>
			<div class="spacer"></div>
	  </div>
       <div class="spacer"></div>
     </div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>
</div>

<!--lightbox-->
<div class="lightbox04 photo_zoom02">
<div id="div_err3">
</div>
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
      <h3><?php echo addslashes(t('Are you sure to accept this job as complete'))?>?</h3>
      <div class="lable"><?php echo addslashes(t('Comments'))?>  :</div>
      <div class="textfell">
            <textarea name="s_comment" id="s_comment" ></textarea>
      </div>
      <div class="spacer"></div>
	  <div id="err_s_comment" class="err" style="margin-left:110px;"><?php echo form_error('s_comment') ?></div>
	  
      <div class="spacer"></div>
      <div class="lable"><?php echo addslashes(t('Rating'))?> :</div>
      <div class="textfell">
            <select id="rating" name="rating " style="width:269px;">
				  <option value="1">1 </option>
				  <option value="2">2 </option>
                  <option value="3">3 </option>
				  <option value="4">4 </option>
				  <option value="5">5 </option>
            </select>
			
			<div class="spacer"></div>
	  <div id="err_rating" class="err"><?php echo form_error('rating') ?></div>
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
       <div class="lable"><?php echo addslashes(t('Positive'))?>  :</div>
      <div class="textfell">
            <input name="i_rate" id="i_positive" class="i_positive" type="radio" value="1" /> <?php echo addslashes(t('Yes'))?>   
			<input name="i_rate" id="i_negative" class="i_positive" type="radio" value="2" checked="checked" /> <?php echo addslashes(t('No'))?> 
      </div>
      <div class="spacer"></div>
      
      <div class="lable"></div>
      <div class="textfell">
	  		<input type="hidden" name="h_job_id" id="h_job_id" value="" />
            <input class="small_button margintop" id="btn_accept" value="<?php echo addslashes(t('Submit'))?>" type="button" />
      </div>
</div>
<!--lightbox-->

<!--lightbox-->
<div class="lightbox04 photo_zoom05">
<div id="div_err2">
</div>
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
      <h3><?php echo addslashes(t('Why do you want to deny this job to be complete'))?>?</h3>
      <div class="lable"><?php echo addslashes(t('Comments'))?>  :</div>
      <div class="textfell">
            <textarea name="ta_message" id="ta_message"></textarea>
      </div>
	  <div class="spacer"></div>
	  <div id="err_ta_message" class="err" style="margin-left:110px;"><?php echo form_error('ta_message') ?></div>
	  
	  <div class="spacer"></div>
      <div class="lable"><?php echo addslashes(t('Rating'))?> :</div>
      <div class="textfell">
            <select id="ratting" name="ratting " style="width:269px;">
				  <option value="1">1 </option>
				  <option value="2">2 </option>
            </select>
			
			<div class="spacer"></div>
	  <div id="err_ratting" class="err"><?php echo form_error('ratting') ?></div>
            <script type="text/javascript">
	$(document).ready(function() {
	  $("#ratting").msDropDown();
	  $("#ratting").hide();
      $('#ratting_msdd').css("background-image", "url(images/fe/select.png)");
	  $('#ratting_msdd').css("background-repeat", "no-repeat");
	  $('#ratting_msdd').css("width", "269px");
	  $('#ratting_msdd').css("margin-top", "0px");
	  $('#ratting_msdd').css("padding", "0px");
	  $('#ratting_msdd').css("height", "38px");
						});
</script>
      </div>
	  
      <div class="spacer"></div>      
      <div class="lable"></div>
      <div class="textfell">
		<input type="hidden" name="h_data_id" id="h_data_id" value="" />
		<input class="small_button margintop" id="btn_deny" value="<?php echo addslashes(t('Submit'))?>" type="button" />
      </div>
</div>
<!--lightbox-->

<!--lightbox-->
<div class="lightbox04 photo_zoom04">

      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
	  
      <h3><?php echo addslashes(t('Why do you want to terminate this Job'))?>?</h3>
	  <div class="spacer"></div>
	  <div id="div_err5">
		</div>
      <div class="lable"><?php echo addslashes(t('Reason'))?> :</div>
      <div class="textfell">
            <textarea name="s_reason" id="s_reason"></textarea>
      </div>
	   <div class="spacer"></div>
	  <div id="err_s_reason" class="err" style="margin-left:110px;"><?php echo form_error('s_reason') ?></div>
	  
      <div class="spacer"></div>
      <div class="lable"><?php echo addslashes(t('Feedback'))?> :</div>
      <div class="textfell">
            <textarea name="s_feedback" id="s_feedback" ></textarea>
      </div>
	   <div class="spacer"></div>
	  <div id="err_s_feedback" class="err" style="margin-left:110px;"><?php echo form_error('s_feedback') ?></div>
	  
      <div class=" spacer"></div>
      <div class="lable"><?php echo addslashes(t('Feedback Ratings'))?>:</div>
      <div class="textfell">
            <select id="feedback" name="feedback " style="width:269px;">
			<?php for($i=1;$i<=2;$i++) { ?>
                  <option value="<?=$i?>"><?=$i?></option>
			<?php } ?>	  
            </select>
            <script type="text/javascript">
	$(document).ready(function() {
	  $("#feedback").msDropDown();
	  $("#feedback").hide();
        $('#feedback_msdd').css("background-image", "url(images/fe/select.png)");
	  $('#feedback_msdd').css("background-repeat", "no-repeat");
	  $('#feedback_msdd').css("width", "269px");
	  $('#feedback_msdd').css("margin-top", "0px");
	  $('#feedback_msdd').css("padding", "0px");
	  $('#feedback_msdd').css("height", "38px");
						});
</script>
      </div>
      <div class="spacer"></div>
      <div class="lable"></div>
      <div class="textfell">
	  		<input type="hidden" id="h_job_terminate" name="h_job_terminate" value="" />
            <input class="small_button margintop" id="btn_terminate" value="<?php echo addslashes(t('Submit'))?>" type="button" />
      </div>
</div>
<!--lightbox-->