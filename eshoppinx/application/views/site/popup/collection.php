<div style='display:none'>

  <div id='inline_example19' style='background:#fff;'>
  
  		<div class="popup_page">
        
        	<!--<a class="close_box" href="javascript:void(0);">x</a>  -->     
            
            
            <div class="" style="border-right:none; padding:0px 0px 15px 0px; margin:0 0 15px 15px">
            	<span class="popup_title"><?php if($this->lang->line('templates_saving') != '') { echo stripslashes($this->lang->line('templates_saving')); } else echo "Saving"; ?>...</span>
            	<a href="javascript:showView('1');" style="float:left; width:100%;"><div class="select-list"><?php if($this->lang->line('templates_sele_cols') != '') { echo stripslashes($this->lang->line('templates_sele_cols')); } else echo "Select Collections"; ?></div></a>
                <div class="select-list-inner" id="showlist1" >
                	<ul style="margin:0 0 0 10px">
                    	<li><a href="#">Things I want as gifts</a></li>
                        <li><a href="#">fgfgf</a></li>
                        <li><a href="#">fgfgf</a></li>
                    </ul>
                    <input type="text" style="float:left; width:100px; margin:5px; color:#000" class="ship_txt" />
                    <input type="button" class="add_btn create_list_sub" />
                </div>
                <textarea maxlength="200" style="float:left; width:80% !important; margin:20px 0 0 ; padding:10px 0 0 10px" class="add_friend" placeholder="Comment"></textarea> 
                <div class="clear"></div>        	            
            	<input type="submit" style="width: 180px !important;" class="start_btn_1 save_done" value="<?php if($this->lang->line('header_done') != '') { echo stripslashes($this->lang->line('header_done')); } else echo "DONE"; ?>">
            </div>
            
        
        </div>
        
  </div>
  
</div>