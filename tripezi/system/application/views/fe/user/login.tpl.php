<script type="text/javascript">

jQuery(function($) {
$(document).ready(function() {
      /********** login start *************/
      $("#btn_login").click(function(){
            
            var b_valid =   true ;
            var reg_email     = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var email_address = $.trim($("#txt_email").val());
            var password      = $.trim($("#txt_password").val());
            
            
            if(email_address=="") //// For  name 
            {
                $("#txt_email").next(".err").html('<strong>Please provide your email address.</strong>').slideDown('slow');        
                b_valid  =  false;
            }
            else if(reg_email.test(email_address) == false)
            {
                $("#txt_email").next(".err").html('<strong>Please provide a proper email address.</strong>').slideDown('slow');
                b_valid  =  false;
            }
            else
            {
                $("#txt_email").next(".err").slideUp('slow').text('');
            }
            if(password=="") 
            {
                $("#txt_password").next(".err").html('<strong>Please provide a password.</strong>').slideDown('slow');        
                b_valid  =  false;
            }
            else
            {
                $("#txt_password").next(".err").slideUp('slow').text('');
            }
            
            if(b_valid)
            {
                $("#frm_login").submit(); 
            }
            
            
      }); 
      
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
		  <h2>Log in</h2>
		  <h4>Not registered yet? <a href="<?php echo base_url().'user/registration' ?>">Sign up here</a> </h4>
		  <div class="border02">&nbsp;</div>
		  <br class="spacer" />
		  <div class="left-box">
		   <form action="<?php echo base_url().'user/login' ?>" method="post"  name="frm_login" id="frm_login">
				<div class="label">Email</div>
				<div class="textfell">
					  <input name="txt_email" type="text" id="txt_email" />
                      <div class="err"><?php echo form_error('txt_email') ?></div>
				</div>
				<div class="label">Password</div>
				<div class="textfell">
					  <input name="txt_password" type="password" id="txt_password" />
                      <div class="err"><?php echo form_error('txt_password') ?></div> 
				</div>
                <div class="spacer" style="margin-bottom: 5px;"></div>
                
				<input class="button-blu" type="button" value="Log in"   name="btn_login" id="btn_login"/>
				<p><a href="<?php echo base_url().'forgot-password' ?>">Forgot password</a></p>
				</form>
		  </div>
		  <div class="right-box margin00">
				<h4>Log in faster by connecting with Facebook.</h4>
				<a href="javascript:void(0)"><img onclick="fblogincheck()" src="images/fe/facebook-button.png" alt="facebook-button"  class="facebook-button"/></a>
				<p>We will not post anything without your permission.</p>
		  </div>
		  <div class="spacer">&nbsp;</div>
		  
	</div>
</div>