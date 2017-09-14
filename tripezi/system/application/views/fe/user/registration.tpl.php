<script type="text/javascript">

// start document ready
jQuery(function($) {
$(document).ready(function() {
    
        // Change cpatcha image
        $("#change_image").click(function(){
            $("#captcha").attr('src','<?php echo base_url().'captcha'?>/index/'+Math.random());
        });
        
        /******** Create account start *********/
        
        $("#btn_create_account").click(function(){
            
            var b_valid =   true ;
            var reg_email     = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var email_address = $.trim($("#txt_email").val());
            var password      = $.trim($("#txt_password").val()); 
            var confirm_password = $.trim($("#txt_confirm_password").val()); 
            
            if($.trim($("#txt_first_name").val())=="") //// For  name 
            {
                $("#txt_first_name").next(".err").html('<strong>Please provide your first name.</strong>').slideDown('slow');        
                b_valid  =  false;
            }
            else
            {
                $("#txt_first_name").next(".err").slideUp('slow').text('');
            }
            if($.trim($("#txt_last_name").val())=="") 
            {
                $("#txt_last_name").next(".err").html('<strong>Please provide your last name.</strong>').slideDown('slow');        
                b_valid  =  false;
            }
            else
            {
                $("#txt_last_name").next(".err").slideUp('slow').text('');
            }
            if(email_address=="") 
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
            else if(password.length<6)
            {
                $("#txt_password").next(".err").html('<strong>Password should be at least 6 characters.</strong>').slideDown('slow');        
                b_valid  =  false;
            }
            else
            {
                $("#txt_password").next(".err").slideUp('slow').text('');
            }
             if(confirm_password=="") 
            {
                $("#txt_confirm_password").next(".err").html('<strong>Please provide confirm password.</strong>').slideDown('slow');        
                b_valid  =  false;
            }
            else if(password!=confirm_password)
            {
                $("#txt_confirm_password").next(".err").html('<strong>Please confirm your password.</strong>').slideDown('slow');        
                b_valid  =  false;
            }
            else
            {
                $("#txt_confirm_password").next(".err").slideUp('slow').text('');
            }
            if($.trim($("#txt_captcha").val())=="") 
            {
                $("#txt_captcha").next(".err").html('<strong>Please provide  security code.</strong>').slideDown('slow');        
                b_valid  =  false;
            }
            else
            {
                $("#txt_captcha").next(".err").slideUp('slow').text('');
            }
            
            if(b_valid)
            {
                $("#frm_create_account").submit(); 
            }
            else
            {
                $("#captcha").attr('src','<?php echo base_url().'captcha'?>/index/'+Math.random()); 
				$("#txt_captcha").val('');
            }
            
            
        })  ;
        
        /******** Create account end *********/
        
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
  <div class="gry-box">
	  <h2>Create your user account</h2>
	  <h4>(Already registered with Property space listing? <a href="<?php echo base_url().'user/login' ?>">Log in</a>) </h4>
	  <div class="border02">&nbsp;</div>
	  <br class="spacer" />
	  <div class="left-box">
	  
		   <form action="<?php echo base_url().'user/registration' ?>" method="post"  name="frm_create_account" id="frm_create_account">
			  <div class="label">First name</div>
			  <div class="textfell">
			  <input name="txt_first_name" type="text" id="txt_first_name" value="<?php echo $posted["txt_first_name"] ; ?>" />
              <div class="err"><?php echo form_error('txt_first_name') ?></div>  
			  </div>
                
              <div class="spacer"></div>
			  
			  <div class="label">Last name</div>
			  <div class="textfell">
			  <input name="txt_last_name" type="text" id="txt_last_name" value="<?php echo $posted["txt_last_name"] ; ?>" />
              <div class="err"><?php echo form_error('txt_last_name') ?></div>  
			  </div>
               
              <div class="spacer"></div>
			  
			  
			  <div class="label">Email</div>
			  <div class="textfell">
			  <input name="txt_email" type="text" id="txt_email" value="<?php echo $posted["txt_email"] ; ?>"   />
              <div class="err"><?php echo form_error('txt_email') ?></div> 
			  </div>
                
              <div class="spacer"></div>
			  
			  
			  <div class="label">Password</div>
			  <div class="textfell">
			  <input name="txt_password" type="password" id="txt_password"  />
              <div class="err"><?php echo form_error('txt_password') ?></div>  
			  </div>
               
               <div class="spacer"></div>
               
               <div class="label">Confirm password</div>
              <div class="textfell">
              <input name="txt_confirm_password" type="password" id="txt_confirm_password"  />
              <div class="err"><?php echo form_error('txt_confirm_password') ?></div>  
              </div>
               
               <div class="spacer"></div>
                  
			  
			  <div class="label">Captcha</div>
              <div>
			    <img src="<?php echo base_url().'captcha'?>" id="captcha" style="float: left;" />
             <a href="javascript:void(0);" id="change_image" style="padding : 2px;" >
                <img src="images/fe/ajax-refresh-icon.gif" alt="Change Text" title="Change Text" /></a>
                </div>
               <div class="spacer"></div>  
			  <div class="textfell">

			  <input name="txt_captcha" type="text" id="txt_captcha" /> 
              <div class="err"><?php echo form_error('txt_captcha') ?></div>  
			  </div>
               
               <div class="spacer"></div>   
             
			  <p>Your listing will not be published yet. You can review and <br />
			edit everything in your account. </p>
		  
	  </div>
	  
	  <div class="right-box">
	  <h4>Log in faster by connecting with Facebook.</h4>
	  <a href="javascript:void(0;"><img onclick="fblogincheck()" src="images/fe/facebook-button.png" alt="facebook-button"  class="facebook-button"/></a> 
	  <p>We will not post anything without your permission.</p>
				  </div>
	 
	   <div class="spacer">&nbsp;</div>
		<div class="border02">&nbsp;</div>
		<p>By clicking 'Create Account' you agree to the  Tripezi <a href="<?php echo base_url().'terms-conditions' ?>"> terms and conditions</a> . </p>
		<input class="button-blu" type="button" value="Create Account" name="btn_create_account" id="btn_create_account"/>
        </form>  
  </div>
	  
</div>