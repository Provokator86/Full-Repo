<script type="text/javascript">

// start document ready
jQuery(function($) {
$(document).ready(function() {
    
        // Change cpatcha image
        $("#change_image").click(function(){
            $("#captcha").attr('src','<?php echo base_url().'captcha'?>/index/'+Math.random());
        });
        
        /******** Create account start *********/
        
        $("#btn_forgot_pwd").click(function(){
            
            var b_valid =   true ;
            var reg_email     = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var email_address = $.trim($("#enteraddress").val()); 
          
            if(email_address=="") 
            {
                $("#enteraddress").next(".err").html('<strong>Please provide your email address.</strong>').slideDown('slow');
                b_valid  =  false;
            }
            else if(reg_email.test(email_address) == false)
            {
                $("#enteraddress").next(".err").html('<strong>Please provide a proper email address.</strong>').slideDown('slow');
                b_valid  =  false;
            }
            else
            {
                $("#enteraddress").next(".err").slideUp('slow').text('');
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
                $("#frm_forgot_pwd").submit(); 
            }
            else
            {
                $("#captcha").attr('src','<?php echo base_url().'captcha'?>/index/'+Math.random()); 
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
	<?php include_once(APPPATH."views/fe/common/message.tpl.php"); ?> 
	<div class="gry-box">
		  <h2>Forgot Password</h2>
		  
		  <div class="border02">&nbsp;</div>
		  <br class="spacer" />
		  <div class="left-box">
		   <form name="frm_forgot_pwd" id="frm_forgot_pwd" action="<?php echo base_url().'forgot-password' ?>" method="post" >
				<div class="label">Enter your email address</div>
				<div class="textfell">
					  <input name="enteraddress" type="text" value="<?php echo $posted["txt_email"] ; ?>" id="enteraddress" />
					  <div class="err"><?php echo form_error('enteraddress') ?></div> 
				</div>
				<div class="label">Captcha</div>
				<!--<img src="images/fe/capcha02.png" alt="capcha" />-->
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
				<input class="button-blu" type="button" value="Submit" id="btn_forgot_pwd"/>
				
				</form>
			   
		  </div>
		  <div class="forgot-password-bg">
				
		  </div>
		  <div class="spacer">&nbsp;</div>
		  
	</div>
</div>