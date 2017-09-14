<!-- Popup_Buy_info_start -->


<div style='display:none'>

  	<div id='inline_example12' style='background:#fff;'>
    
    	<div class="popup_page">
        
        	<div class="popup_info">
            
            	<h3><?php if($this->lang->line('templates_wyareu') != '') { echo stripslashes($this->lang->line('templates_wyareu')); } else echo "Why are you reporting this"; ?>?</h3>
                
                <ul class="popup_checkout">
                
                	<li><input type="radio" value="" /> <?php if($this->lang->line('fancy_not_avail') != '') { echo stripslashes($this->lang->line('fancy_not_avail')); } else echo "Not available"; ?> </li>
                    
                    <li><input type="radio" value="" />  <?php if($this->lang->line('templates_incor_price') != '') { echo stripslashes($this->lang->line('templates_incor_price')); } else echo "Incorrect price"; ?> </li>
                    
                    <li><input type="radio" value="" />  <?php if($this->lang->line('templates_bad_image') != '') { echo stripslashes($this->lang->line('templates_bad_image')); } else echo "Bad image"; ?></li>
                
                
                </ul>
                
                <div class="popup_reports">
                
                	<a class="example18" href="#"><input type="submit" value="<?php if($this->lang->line('templates_reportit') != '') { echo stripslashes($this->lang->line('templates_reportit')); } else echo "Report It"; ?>" class="find_btn" /></a>
                    
                    <span><?php if($this->lang->line('templates_thanks') != '') { echo stripslashes($this->lang->line('templates_thanks')); } else echo "Thanks"; ?>.</span>
                
                </div>
            
            
            </div>
        
        
        
        </div>

		

	</div>

</div>



<!-- Popup_Buy_info_end -->