<!--tab-->
<script type="text/JavaScript" src="js/fe/tab.js"></script>
<script type="text/javascript" >
$(document).ready(function(){
	
	var index = <?php echo $param ?>;
	
	$(".tab-content ul li").filter(':eq(' + index + ')').find("a").addClass("select");
	
	$('.tab-details > div.details').hide();
	$('.tab-details > div.details').filter(':eq(' + index + ')').fadeIn('slow');
	
});
</script>
<script type="text/javascript">
    $(document).ready(function() {
	$("#btn_save_testimonial").click(function() { 
		var b_valid = true;		
		if($.trim($("#ta_message").val())=="") //// For  name 
		{
			 $("#ta_message").next(".err").html('<strong>Please provide your comment.</strong>').slideDown('slow');        
             b_valid  =  false;
		}
		else
		{
			$("#ta_message").next(".err").slideUp('slow').text('');
		}
		if(!b_valid)
		{
		   // $.unblockUI();  
			$("#div_err").html(s_err).show("slow");
		}
		
		else
		{
		//$("#ajax_frm_job_confirm").submit();
		var comment = $("#ta_message").val();
		var user_id = $("#h_user_id").val();
		 		$.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'home/save_testimonial',
                        data: "ta_message="+comment+"&h_user_id="+user_id,
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
    
  
	
	});	
</script>
<!--tab-->
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">
                        <h2>About  Property space listing. Everything there is to know about us.</h2>
                        <h3>Meet our team and learn about what we do. </h3>
                        <div class="about-photo"><img src="images/fe/about-photo.png" alt="about-photo" /></div>
	<div class="tab">
		  <div class="tab-content">
				<ul>
					  <li><a href="javascript:void(0);"><span>About us</span></a></li>
					  <li><a href="javascript:void(0);"><span>Testimonials</span></a></li>
					  <li><a href="javascript:void(0);"><span>Terms &amp; Privacy</span></a></li>
				</ul>
		  </div>
		  <!--tab_details-->
	  <div class="tab-details">
			<!--1st tab-->
			<div class="details">
				<?php if($info){ echo $info[0]['s_description']; } ?>
				  <div class="spacer">&nbsp;</div>
			</div>
			<!--1st tab-->
			<!--2nd tab-->
			<div class="details">
				  <h2 class="float02">Testimonials</h2>
				 <?php if(!empty($loggedin)) { ?>
				 <span class="write-testimonials"><a onclick="show_dialog('photo_zoom02')">Write Testimonials</a></span>
				 <?php } ?>
				  <div class="spacer">&nbsp;</div>
				  <h3>Property space listing connects hosts and guests from all over the world</h3>
				  
				  <?php if($testimonial) { 
				  		foreach($testimonial as $value)
						{
							$raw_file_name = getFilenameWithoutExtension($value["s_image"]);	
							$img = $value["s_image"]?$dispalyPath.$raw_file_name.'_min.jpg':"";
				  ?>
				  <div class="testimonials">
					  <div class="photo-box">
						  <div class="profile-photo"><img src="<?php echo $img ?>" height="53" width="75" alt="" /></div>
						  <span><?php echo $value["s_first_name"] ?></span>
					  </div>
					  <div class="comment-box">
						  <div class="tick">&nbsp;</div>
						  <div class="top-part-bg">&nbsp;</div>
						  <div class="part-bg">
						  <p><?php echo $value["s_full_content"] ?></p>
						  </div>
					  <div class="bottom-part-bg">&nbsp;</div>
					  </div>
				  <div class="spacer">&nbsp;</div>
				  </div>
				  
				  <?php } } ?>
				  
			</div>
			<!--2nd tab-->
			<!--3rd tab-->
			<div class="details">
				  <h2>Cancellation Policies</h2>
				  
				  <?php if($info) { echo $info[3]['s_description']; } ?>
				 
				  
				  
				  <h2>Terms and Conditions</h2>
				  			  
				  	<?php if($info) { echo $info[2]['s_description']; } ?>
				 
				  
				  <h2>Privacy</h2>
				  			  
				 	<?php if($info) { echo $info[1]['s_description']; } ?>
				 
		   </div>
		  <!--3rd tab-->
		</div>
		<!--tab_details-->
	</div>
</div>

<!--lightbox-->
<div class="light-box testimonials-bg photo_zoom02">
<div id="div_err1">
</div>
<div class="close"><a href="javascript:void(0)" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
<h4>Testimonial</h4>
<div class="form-box">
<label>Comment</label>
<div class="textarea-box">
<input type="hidden" name="h_user_id" id="h_user_id" value="<?php echo $loggedin['user_id']?>" />
<textarea name="ta_message" id="ta_message" cols="" rows=""></textarea>
<div class="err"><?php echo form_error('ta_message') ?></div> 
</div>
<br  class="spacer"/>
<label></label>
<br  class="spacer"/>
<!--<select id="as" name="as" style="width:273px">
<option>Spare Owner</option>
</select>-->
<br  class="spacer"/>
<input  type="button" value="Submit" class="button-blu" id="btn_save_testimonial"/>
</div>
</div> 
      
<!--lightbox-->