

<div style='display:none'>

  <div id='inline_example5' style='background:#fff;'>
  
  		<div class="popup_page">
  			<!--<a class="close_box cboxClose1" href="javascript:void(0);">x</a>-->
  
  			<div class="popup_header"><?php if($this->lang->line('landing_all_stores') != '') { echo stripslashes($this->lang->line('landing_all_stores')); } else echo "All stores in one place"; ?>. </div>
            
            <div class="popup_detail">
            
            	<div class="banner_signup">
                            	
                                <a class="popup_facebook" onclick="window.location.href='<?php echo base_url();?>facebook/user.php'"><?php if($this->lang->line('landing_start_shop') != '') { echo stripslashes($this->lang->line('landing_start_shop')); } else echo "START SHOPPING"; ?></a>
                                	
                                 <span class="popup_signup_or"><?php if($this->lang->line('credit_or') != '') { echo stripslashes($this->lang->line('credit_or')); } else echo "OR"; ?></span>
                                <div class="div_email1"></div>
                                <form onSubmit="return register_user1();" method="post" class="frm clearfix" name="SignupForm" id="SignupForm" >
                    
                   	<input type="text" id="popemail" name="popemail" placeholder="<?php if($this->lang->line('signup_email_addrs') != '') { echo stripslashes($this->lang->line('signup_email_addrs')); } else echo "Your email"; ?>"  value="" class="signup_scroll1 required email" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
            
           
            <input type="text" name="popusername" placeholder="<?php if($this->lang->line('signup_user_name') != '') { echo stripslashes($this->lang->line('signup_user_name')); } else echo "Username"; ?>" id="popusername" class="signup_scroll1 required" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
            
		    
			<input type="password" id="poppassword" name="poppassword"  class="signup_scroll1 required" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" placeholder="<?php if($this->lang->line('signup_password') != '') { echo stripslashes($this->lang->line('signup_password')); } else echo "Password"; ?>"/>
                    
                    <input type="submit" name="next" value="<?php if($this->lang->line('landing_start_shop') != '') { echo stripslashes($this->lang->line('landing_start_shop')); } else echo "START SHOPPING"; ?>" class="start_btn" /> 
                    <input name="referrer" type="hidden" class="referrer" value="" />
                    <input name="invitation_key" type="hidden" class="invitation_key" value="" />
                    <input type='hidden' name='csrfmiddlewaretoken' value='UFLfIU881eyZJbm7Bq0kUFZ9sVaWGh54' />
		</form>
                                 
                                  <span class="popup_forgot"><?php if($this->lang->line('templates_been_before') != '') { echo stripslashes($this->lang->line('templates_been_before')); } else echo "Been here before"; ?>? <a class="example9 sign_box" href="#"><?php if($this->lang->line('signup_sign_in') != '') { echo stripslashes($this->lang->line('signup_sign_in')); } else echo "Sign in"; ?>. </a></span>
                                 
                            </div>
                    
                    	
            </div>
        
        </div>
        
  </div>
  
</div>

<!-- Popup_signup_end -->