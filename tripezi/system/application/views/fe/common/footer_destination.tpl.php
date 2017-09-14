<!--part-four-->
<div class="footer-part">
		<div class="destinations">
			  <h2>Top destinations</h2>
			  <?php 
			  	if($top_destinations)
				{
					if($i_count>4)
					{
						$arr_split  =   array_chunk($top_destinations,4);					
					}
					else
					{
						$arr_split  =   array_chunk($top_destinations,$i_count);
					}
				?> 
			 
			  <ul>
			  		 <?php
					if(!empty($arr_split[0]))
					{
					 foreach($arr_split[0] as $value){
				 	?>
					<li><a href="<?php echo base_url().'search/'.$value["id"] ?>"><?php echo $value["s_city"] ?></a></li>
					<?php } } ?>
			  </ul>
			 
			 
			  <ul>
					 <?php
					if(!empty($arr_split[1]))
					{
					 foreach($arr_split[1] as $value){
				 	?>
					<li><a href="<?php echo base_url().'search/'.$value["id"] ?>"><?php echo $value["s_city"] ?></a></li>
					<?php } } ?>
			  </ul>
			  
			  <ul>
					 <?php
					if(!empty($arr_split[2]))
					{
					 foreach($arr_split[2] as $value){
				 	?>
					<li><a href="<?php echo base_url().'search/'.$value["id"] ?>"><?php echo $value["s_city"] ?></a></li>
					<?php } } ?>
			  </ul>
			  
			  <ul>
					 <?php
					if(!empty($arr_split[3]))
					{
					 foreach($arr_split[3] as $value){
				 	?>
					<li><a href="<?php echo base_url().'search/'.$value["id"] ?>"><?php echo $value["s_city"] ?></a></li>
					<?php } } ?>
			  </ul>
			  <?php } ?>
			  
		</div>
                        
		<div class="follow-us-on">
			  <h2>Follow Us on</h2>
			  <div class="icon-box"><img src="images/fe/facebook.png" alt="" /><a href="<?php echo $s_facebook_address ?>">Facebook</a></div>
			  <div class="icon-box"><img src="images/fe/youtube.png" alt="" /><a href="<?php echo $s_youtube_address ?>">Youtube</a></div>
			  <div class="icon-box"><img src="images/fe/twitter.png" alt="" /><a href="<?php echo $s_twitter_address ?>">Twitter</a></div>
			  <div class="icon-box"><img src="images/fe/blog.png" alt="" /><a href="<?php echo base_url().'blog' ?>">Blog</a></div>
			  <div class="icon-box"><img src="images/fe/google.png" alt="" /><a href="<?php echo $s_google_plus_address ?>">Google+</a></div>
			   <div class="icon-box"><img src="images/fe/news-icon.png" alt="" />
			   		<a href="javascript:void(0);" onclick="show_dialog('photo_zoom04')">News Letter</a>
			   </div>
		</div>
                        
	<br class="spacer" />
</div>
<!--part-four-->
<!--lightbox-->
<div class="light-box subscribe-bg photo_zoom04">
<div id="div_err1">
</div>
	<div class="close"><a href="javascript:void(0)" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
		<h4>News Letter</h4>
		<div class="subscribe-bg">
		<label>Name</label>
		<div class="text-box04">
		<input name="txt_news_name" id="txt_news_name" type="text" />
		<div class="err"><?php echo form_error('txt_news_name') ?></div> 
		</div>
		<br  class="spacer"/>
		<label>Email</label>
		<div class="text-box04">
		<input name="txt_news_email" id="txt_news_email" type="text" />
		<div class="err"><?php echo form_error('txt_news_email') ?></div> 
		</div>
		<div class="spacer"></div>
		<br  class="spacer"/>
		<input  type="button" value="Subscribe" id="btn_subscribe_news" class="button-blu"/>
	</div>
</div> 
<!--lightbox-->
<script type="text/javascript">
    $(document).ready(function() {
		$("#btn_subscribe_news").click(function() { 
			var b_valid = true;		
			var s_err="";
		 	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
			
			if($.trim($("#txt_news_name").val())=="") //// For  name 
			{
				 $("#txt_news_name").next(".err").html('<strong>Please provide your nmae.</strong>').slideDown('slow');        
				 b_valid  =  false;
			}
			else
			{
				$("#txt_news_name").next(".err").slideUp('slow').text('');
			}
			if($.trim($("#txt_news_email").val())=="") //// For  name 
			{
				 $("#txt_news_email").next(".err").html('<strong>Please provide your email.</strong>').slideDown('slow');        
				 b_valid  =  false;
			}
			else if(!emailPattern.test($("#txt_news_email").val()))
			{
				 $("#txt_news_email").next(".err").html('<strong>Please provide proper email.</strong>').slideDown('slow');        
				 b_valid  =  false;
			}
			else
			{
				$("#txt_news_email").next(".err").slideUp('slow').text('');
			}
			if(!b_valid)
			{
				$("#div_err1").html(s_err).show("slow");
			}
			
			else
			{
			//$("#ajax_frm_job_confirm").submit();
			var txt_name = $("#txt_news_name").val();
			var txt_email = $("#txt_news_email").val();
					$.ajax({
							type: "POST",
							async: false,
							url: base_url+'home/subscribe_newsletter',
							data: "s_name="+txt_name+"&s_email="+txt_email,
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
				setTimeout('window.location.reload()',3000);		
			}
			return false;
		});
		
	});	
</script>