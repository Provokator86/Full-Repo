<script type="text/javascript">
jQuery(function($) {
$(document).ready(function(){
	var tot_comments = '<?php echo $total_rows ?>';

	$("#btn_comment_srch").click(function(){
	
	var blog_title = $("#search03").val();
	
		$.ajax({
					type: "POST",
					async: false,
					url: base_url+'home/ajax_search_blog_comments',
					data: "txt_title="+blog_title,
					success: function(msg){
						if(msg)
						{
							$("#tot_com").text(tot_comments);
							 $("#blog_comments").html(msg);
						}
					}
				})   // end post ajax
	
	
	});

		// ajax call to post comments
	$("#btn_post_comment").click(function(){

	var b_valid =true;
	var comment = $("#comment").val();
	var blog_id = $("#h_blog_id").val();
	
	if($.trim($("#comment").val())=="") //// For  name 
	{
		$("#comment").next(".err").html('<strong>Please provide comment.</strong>').slideDown('slow');        
		b_valid  =  false;
	}
	else
	{
		$("#comment").next(".err").slideUp('slow').text('');
	}
	
	
	if(b_valid)
	{
		$.ajax({
				type: "POST",
				async: false,
				url: base_url+'home/ajax_post_comments',
				data: "txt_comment="+comment+"&blog_id="+blog_id,
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
				
			})   // end post ajax
		setTimeout('window.location.reload()',2000);
	}
	return false;

	});	
		
	// end ajax call to post comments
	
});
});

</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">

	<div class="search-details-right">
		<div class="small-search-bg">
		<div class="lable02">
		<input name="search03" type="text" id="search03" />
		</div>
		
		<input class="small-search-button" type="button" value="" id="btn_comment_srch" />
		</div>
	</div>
	 <div class="search-details-left bg">
	
		 <div class="blog-box">
		  <div class="blog-headline"><?php echo $blog_detail["s_title"] ?> </div>
		 <div class="date">
		 <ul>
		 <li><em><?php echo $blog_detail['dt_fe_created_on'] ?></em></li>
		 <li>|</li>
		 <li><em>Author: admin </em></li>
		  <li>|</li>
		 <li> <img src="images/fe/comments.png" alt="" /> <em><span id="tot_com"><?php echo $blog_detail["i_comments"] ?></span> Comments</em></li>
		  <li>|</li>
		 </ul>
		 </div>
		 <br class="spacer" />
			<!-- <div class="left-photo">
			 <img src="images/fe/blog-property.png" alt="blog-property" />
			 </div>-->
		 <div class="text-box-right">
		 	<?php echo $blog_detail["s_description"] ?>
		 </div>
		 
		<div class="spacer">&nbsp;</div>
		 </div>
		 
		 	<!-- blog comments -->
		 	<div id="blog_comments">
				<?php echo $blog_comments; ?>
			</div>	
		 	<!-- blog comments -->
		 
		 
		 <div class="comment-form-box">
			
			 <h2>Live Comment </h2>
			  <div id="div_err1">
			  </div>
			 <div class="form-box">
			 <?php if(!empty($loggedin)) { ?>
			 <div class="text-box-bg">
			 	<!--<input name="name02" type="text" id="name02" />-->
				<input type="hidden" id="h_blog_id" name="h_blog_id" value="<?php echo $blog_detail["id"] ?>"  />
				Commented By : <?php ; echo ($loggedin!='')?$loggedin["user_first_name"]." ".$loggedin["user_last_name"]:""; ?>
			 </div>
			 <?php } ?>
			 <!--<div class="text-box-bg">
			 	<input name="email" type="text" id="email" />
			 </div>-->
			 
			 <div class="comment-box-bg">			 
			 	<textarea name="comment" cols="" rows="" id="comment"><?php echo $posted["txt_comment"] ?></textarea>
				<div class="err"><?php echo form_error('comment') ?></div> 
			 </div>	
			 <br class="spacer" />
			 	<input class="submit-button" type="button" value="" id="btn_post_comment"/>
			 </div>
		 </div>
		 
	 </div>
	<br class="spacer" />
</div>