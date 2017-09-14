<script type="text/javascript">

// start document ready
jQuery(function($) {
$(document).ready(function() {          
			/******** change password  start *********/
	$("#btn_pwd_change").click(function(){
	
		var new_password 	= $("#txt_new_password").val();
		var b_valid 	 	=   true ;
		var old_pwd_flag	= <?php echo $old_pwd_flag; ?>;
		if(old_pwd_flag==1)
		{
			if($.trim($("#txt_old_password").val())=="") //// For  name 
			{
				 $("#txt_old_password").next(".err").html('<strong>provide your old password.</strong>').slideDown('slow');
				 b_valid  =  false;
			}
		}
		if($.trim($("#txt_new_password").val())=="") //// For  name 
		{
			 $("#txt_new_password").next(".err").html('<strong>provide your new password.</strong>').slideDown('slow');
			 b_valid  =  false;
		}
		else if(new_password.length<6)
		{
			$("#txt_new_password").next(".err").html('<strong>provide your new password minimum 6 characters.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else if(new_password.length>15)
		{
			$("#txt_new_password").next(".err").html('<strong>provide your new password maximum 15 characters.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#txt_new_password").next(".err").slideUp('slow').text('');
		}
		if($.trim($("#txt_confirm_password").val())=="") //// For  name 
		{
			$("#txt_confirm_password").next(".err").html('<strong>provide your confirm password.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else if($.trim($("#txt_new_password").val()) != $.trim($("#txt_confirm_password").val()))
		{
			$("#txt_confirm_password").next(".err").html('<strong>both password should be same.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#txt_confirm_password").next(".err").slideUp('slow').text('');
		}
		
		if(b_valid)
		{
			$("#form_chng_pwd").submit(); 
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
	<?php include_once(APPPATH."views/fe/common/account_left_menu.tpl.php"); ?>
		<div class="right-part02">
		  <div class="text-container">
			<div class="inner-box03">
			<form name="form_chng_pwd" id="form_chng_pwd" action="<?php echo base_url().'change-password';?>" method="post" >
				  <div class="page-name02">Change Password</div>
				  <?php if($old_pwd_flag) { ?>
				  <div class="lable06">Old Password</div>
				  <div class="text-fell05">
						<input name="txt_old_password" id="txt_old_password" type="password" />
						<div class="err"><?php echo form_error('txt_old_password') ?></div>
				  </div>
				  <br class="spacer" />
				  <?php } ?>
				  <div class="lable06">New Password</div>
				  <div class="text-fell05">
						<input name="txt_new_password" id="txt_new_password" type="password" />
						<div class="err"><?php echo form_error('txt_new_password') ?></div>
				  </div>
				  
				  <br class="spacer" />
				  <div class="lable06">Confirm Password</div>
				  <div class="text-fell05">
						<input name="txt_confirm_password" id="txt_confirm_password" type="password" />
						<div class="err"><?php echo form_error('txt_confirm_password') ?></div>
				  </div>
				  
				  <br class="spacer" />
				  <input class="button-blu marginleft" type="button" value="Save" id="btn_pwd_change" />
				  
				 </form> 
			</div>
		  </div>
		</div>
	<br class="spacer" />
</div>