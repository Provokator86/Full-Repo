<div style='display:none'>

  <div id='edit_comment_con' style='background:#fff;'>
  
  		<div class="popup_page">
        
        	<!--<a class="close_box" href="javascript:void(0);">x</a>-->       
            
            
            <div class="post_product" style="border-right:none; text-align:center; padding:0px 0px 15px 0px">
            	<span class="popup_title"><?php if($this->lang->line('edit_comment') != '') { echo stripslashes($this->lang->line('edit_comment')); } else echo "Edit Comment"; ?></span>
                	<textarea maxlength="200" class="edit_cmt_cnt" id="edit_cmt_cnt" placeholder=""></textarea>
                    <input type="hidden" id="comment_id" value="" name="comment_id">					
                    <input type="hidden" id="comment_type" value="" name="comment_type">					
            	<input type="submit" onclick="return update_comment(this);" class="start_btn_1" value="<?php if($this->lang->line('templates_submit') != '') { echo stripslashes($this->lang->line('templates_submit')); } else echo "Submit"; ?>">
            </div>
            
        
        </div>
        
  </div>
  
</div>