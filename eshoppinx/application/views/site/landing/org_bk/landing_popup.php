
<!-- Popup_mobile_start -->

<!--
<div style='display:none'>

  <div id='inline_example6' style='background:#fff;'>
  
  		<div class="popup_page">
  
  			<div class="popup_mobile_header">Enter your phone number to get the waneloo app.</div>
            
            <div class="popup_mobile_detail" style="margin-top:0px;">
            
				<div class="mobile_box"><img src="images/mobile_img.png" /></div>   
                
                <div class="mobile_box_right">
                
                	<input type="text" class="mobile_text" value="" />
                    
                    <a class="example12" href="javascript:void(0);"><input type="submit" class="send_btn" value="Send It" />
                  </a>
                    
                    <span class="store_number">(we will NOT store your number.)</span>
                    
                    <a class="may_later example12" href="#">May be later</a>
                
                </div>
                
                                 
                    	
            </div>
        
        </div>
        
  </div>
  
</div>


<!-- Popup_mobile_end -->




<!-- Popup_deals_start -->


<div style='display:none'>

  <div id='inline_example7' style='background:#fff;'>
  
  		<div class="popup_page">
  
  			<div class="popup_deals_header"><?php if($this->lang->line('landing_post_like') != '') { echo stripslashes($this->lang->line('landing_post_like')); } else echo "Products are posted by people like you"; ?>.
            
<!--             	<ul class="category_field">
                
                	<li><input type="radio" name="prod_cat" class="cat_select" value="female" /> Female</li>
                    
                    <li><input type="radio" name="prod_cat" class="cat_select" value="male" /> Male</li>
                    
                    <li><input type="radio" name="prod_cat" class="cat_select" value="both" /> Both</li>
                
                </ul>
 -->                <span class="example13"></span>
                <span class="send_main"><a class="prod_cat_select" onclick="javascript:load_onboard_stores();"><input type="submit" value="<?php if($this->lang->line('onboarding_next') != '') { echo stripslashes($this->lang->line('onboarding_next')); } else echo "Next"; ?>" class="send_btn" />
                </a></span>
            
            </div>
            <script type="text/javascript">
            	$('.cat_select').click(function(){
					$('.prod_cat_select').show();
                });
            </script>
            <div class="popup_mobile_detail">
            
                
                <ul class="product_popup_thumb">
              </ul>
                
                                 
                    	
            </div>
        
        </div>
        
  </div>
  
</div>


<!-- Popup_deals_end -->



<!-- Popup_follows_store_start -->


<div style='display:none'>

  <div id='inline_example8' style='background:#fff;'>
  
  		<div class="popup_page">
  
  			<div class="popup_follow_header">
            
            	<h2><?php if($this->lang->line('landing_follow_get') != '') { echo stripslashes($this->lang->line('landing_follow_get')); } else echo "Follow some stores to get started"; ?>.</h2>
                <span class="example14"></span>
                
                <div class="popup_check">
                
                	 <span class="send_main"><input data-fcount="0" onclick="javascript:load_onboard_peoples();"  type="submit" value="<?php if($this->lang->line('onboarding_next') != '') { echo stripslashes($this->lang->line('onboarding_next')); } else echo "next"; ?>"  class="send_btn onboard_peoples_next" />
                	 </span>
            
                    <ul class="popup_checkbox">
                    
                        <li><input class="store_follow_check1" disabled="disabled" type="radio" /></li>
                        
                        <li><input class="store_follow_check2" disabled="disabled" type="radio" /></li>
                        
                        <li><input class="store_follow_check3" disabled="disabled" type="radio" /></li>
                    
                    </ul>
                
                </div>
            
            </div>
            
            <div class="popup_mobile_detail" style="margin-top:75px;">
            
            </div>
        
        </div>
        
  </div>
  
</div>


<!-- Popup_follows_store_end -->



<!-- Popup_follows_start -->


<div style='display:none'>

  <div id='inline_example9' style='background:#fff;'>
  
  		<div class="popup_page">
  
  			<div class="popup_follow_header">
            
            	<h2><?php if($this->lang->line('landing_now_foll') != '') { echo stripslashes($this->lang->line('landing_now_foll')); } else echo "Now follow some people"; ?>.</h2>
                
                <div class="popup_check">
                
                	 <span class="send_main"><input data-fcount="0" onclick="window.location.reload();" type="submit" value="<?php if($this->lang->line('landing_ok') != '') { echo stripslashes($this->lang->line('landing_ok')); } else echo "Ok"; ?>!"  class="send_btn onboard_final" />
               	  </span>
            
                    <ul class="popup_checkbox">
                    
                        <li><input class="user_follow_check1" disabled="disabled" type="radio" /></li>
                        
                        <li><input class="user_follow_check2" disabled="disabled" type="radio" /></li>
                        
                        <li><input class="user_follow_check3" disabled="disabled" type="radio" /></li>
                    
                    </ul>
                
                </div>
                
            
            </div>
            
            <div class="popup_mobile_detail" style="margin-top:75px;">
            
				<div class="follow_main">
                
                	<div class="left_follow">
                    
                    	<span class="follow_icon"><img src="images/follow_icon1.png" /></span>
                        
                        <a class="follow_icon_links" href="javascript:void(0);">mrporter.com</a>
                        
                        <span class="follow_count">98K followers</span>
                    
                    
                    </div>
                    
                    <div class="right_follow">
                    
                   	 	<a class="follow_btn" href="javascript:void(0);">Follow</a>
                        
                        <a class="following_btn" href="javascript:void(0);">Following</a>                	</div>	
                    
                    
      <ul class="product_popup_follow">
                
                        
                
               	  </ul>
                
                </div>                
                
                
                <div class="follow_main">
                
                	<div class="left_follow">
                    
                    	<span class="follow_icon"><img src="images/follow_icon1.png" /></span>
                        
                        <a class="follow_icon_links" href="#">mrporter.com</a>
                        
                        <span class="follow_count">98K followers</span>
                    
                    
                    </div>
                    
                    <div class="right_follow">
                    
                   	 	<a class="follow_btn" href="#">Follow</a>
                        
                        <a class="following_btn" href="#">Following</a>                	</div>	
                    
                    
      <ul class="product_popup_follow">
                
                        
                
               	  </ul>
                
                </div>
                
                
                <div class="follow_main">
                
                	<div class="left_follow">
                    
                    	<span class="follow_icon"><img src="images/follow_icon1.png" /></span>
                        
                        <a class="follow_icon_links" href="#">mrporter.com</a>
                        
                        <span class="follow_count">98K followers</span>
                    
                    
                    </div>
                    
                    <div class="right_follow">
                    
                   	 	<a class="follow_btn" href="#">Follow</a>
                        
                        <a class="following_btn" href="#">Following</a>                	</div>	
                    
                    
      <ul class="product_popup_follow">
                
                        
                
               	  </ul>
                
                </div>
                                 
                    	
            </div>
        
        </div>
        
  </div>
  
</div>


<!-- Popup_follows_end -->