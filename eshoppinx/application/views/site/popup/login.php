<div style='display:none'>

  <div id='inline_example4' style='background:#fff;'>
  
  		<div class="popup_page">
        
  			<!--<a class="close_box cboxClose1" href="javascript:void(0)">x</a>-->
  
  			<div class="popup_header"><?php if($this->lang->line('templates_letssign') != '') { echo stripslashes($this->lang->line('templates_letssign')); } else echo "Let's sign you in"; ?>. </div>
            
            <div class="popup_detail">
            
            	<div class="banner_signup">
                            	
                                <a class="popup_facebook" onclick="window.location.href='<?php echo base_url();?>facebook/user.php'"><?php if($this->lang->line('landing_start_shop') != '') { echo stripslashes($this->lang->line('landing_start_shop')); } else echo "START SHOPPING"; ?></a>
                                	
                                 <span class="popup_signup_or"><?php if($this->lang->line('credit_or') != '') { echo stripslashes($this->lang->line('credit_or')); } else echo "OR"; ?></span>
                                 <div class="div_email1"></div>
                                 <form onSubmit="return signin_popup();" method="post" class="frm clearfix" name="SignupForm" id="SignupForm">
		
		    
			
			<input type="text" id="semail" name="semail" value="" placeholder="<?php if($this->lang->line('signup_emailaddrs') != '') { echo stripslashes($this->lang->line('signup_emailaddrs')); } else echo "Email Address"; ?>" class="popup_signup_scroll" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
		    
			<input type="password" id="spassword" name="password" placeholder="<?php if($this->lang->line('signup_password') != '') { echo stripslashes($this->lang->line('signup_password')); } else echo "Password"; ?>" value="" class="popup_signup_scroll" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
                    
                    
                    <input type="submit" name="next" value="<?php if($this->lang->line('landing_start_shop') != '') { echo stripslashes($this->lang->line('landing_start_shop')); } else echo "START SHOPPING"; ?>" class="start_btn" /> 
            </form>
                                 
                                 
                                 <!--<span class="popup_stay"><input class="check" type="checkbox" /> Stay signed in</span>-->
                                 
                              
                                 
                                  <span class="popup_forgot"><a href="<?php echo base_url();?>forgot-password"><?php if($this->lang->line('forgot_passsword') != '') { echo stripslashes($this->lang->line('forgot_passsword')); } else echo "Forgot password"; ?>?</a></span>
                                 
                                 <span class="popup_forgot"><a class="example5 log_box" href="#"><?php if($this->lang->line('templates_not_mem') != '') { echo stripslashes($this->lang->line('templates_not_mem')); } else echo "Not a member yet? Join us!"; ?></a></span>
                                 
                            </div>
                    
                    	
            </div>
        
        </div>
        
  </div>
  
</div>