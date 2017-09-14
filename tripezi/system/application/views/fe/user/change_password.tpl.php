<script type="text/javascript">

// start document ready
jQuery(function($) {
$(document).ready(function() {          
			/******** change password  start *********/
	$("#btn_change_pwd").click(function(){
	
		var new_password = $("#txt_new_password").val();
		var b_valid 	 =   true ;
		if($.trim($("#txt_new_password").val())=="") //// For  name 
		{
			 $("#txt_new_password").next(".err").html('<strong>Please provide your new password.</strong>').slideDown('slow');
			 b_valid  =  false;
		}
		else if(new_password.length<6)
		{
			$("#txt_new_password").next(".err").html('<strong>Please provide your new password minimum 6 characters.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else if(new_password.length>15)
		{
			$("#txt_new_password").next(".err").html('<strong>Please provide your new password maximum 15 characters.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#txt_new_password").next(".err").slideUp('slow').text('');
		}
		if($.trim($("#txt_confirm_password").val())=="") //// For  name 
		{
			$("#txt_confirm_password").next(".err").html('<strong>Please provide your confirm password.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else if($.trim($("#txt_new_password").val()) != $.trim($("#txt_confirm_password").val()))
		{
			$("#txt_confirm_password").next(".err").html('<strong>Please provide confirm password as your new password.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#txt_confirm_password").next(".err").slideUp('slow').text('');
		}
		
		if(b_valid)
		{
			$("#frm_change_pwd").submit(); 
		}
				
				
	 })  ;
			
			/******** change password end *********/
        
        // If server side validation false occur 
        <?php if($posted)
        {
            ?>
            $(".err").show();
        <?php
        } 
            ?>
        
    });
});
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">
	<?php include_once(APPPATH."views/fe/common/message.tpl.php"); ?>                        
	<div class="gry-box">
		  <h2>Change Password</h2>
		  
		  <div class="border02">&nbsp;</div>
		  <br class="spacer" />
		  <div class="left-box">
		   <form name="frm_change_pwd" id="frm_change_pwd" action="<?php echo base_url().'user/change-password/'.$s_email ?>" method="post" >
				<div class="label">New Password</div>
				<div class="textfell">
					  <input name="txt_new_password" id="txt_new_password" type="password" />
					  <div class="err"><?php echo form_error('txt_new_password') ?></div> 
				</div>				
				<div class="spacer"></div>  
				<div class="label">Confirm Password</div>
				<div class="textfell">
					<input name="txt_confirm_password" id="txt_confirm_password" type="password" />
              		<div class="err"><?php echo form_error('txt_confirm_password') ?></div>  
				</div>
				<div class="spacer"></div> 
				<input class="button-blu" type="button" value="Save" id="btn_change_pwd" />
				
				</form>
			   
		  </div>
		  <div class="forgot-password-bg">
				
		  </div>
		  <div class="spacer">&nbsp;</div>
		  
	</div>
	<br class="spacer" />
</div>