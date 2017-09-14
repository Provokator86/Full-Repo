<div style='display:none'>

  <div id='inline_example18' style='background:#fff;'>
  
  		<div class="popup_page">
        
        	<!--<a class="close_box" href="javascript:void(0);">x</a>-->       
            
            
            <div class="post_product" style="border-right:none; text-align:center; padding:0px 0px 15px 0px">
            	<span class="popup_title"><?php if($this->lang->line('templates_tag_frnd') != '') { echo stripslashes($this->lang->line('templates_tag_frnd')); } else echo "Tag a friend"; ?></span>
            	<span class="popup_stay" style="text-align:left"><?php if($this->lang->line('templates_taga') != '') { echo stripslashes($this->lang->line('templates_taga')); } else echo "Tag a"; ?> <?php echo $siteTitle;?> <?php if($this->lang->line('templates_friend_share') != '') { echo stripslashes($this->lang->line('templates_friend_share')); } else echo "friend to share this product with them"; ?>.</span>
                <!--<textarea maxlength="200" class="add_friend" placeholder="@"></textarea>-->
                    <input type="text" class="add_friends" id="searchid" placeholder="@"/>
                    <div id="result"></div>
                    <input type="hidden" id="product_tag_id" value="" name="product_tag_id">					
            	<input type="submit" class="start_btn_1 tag_done" value="<?php if($this->lang->line('product_tag') != '') { echo stripslashes($this->lang->line('product_tag')); } else echo "TAG"; ?>">
            </div>
            
        
        </div>
        
  </div>
  
</div>