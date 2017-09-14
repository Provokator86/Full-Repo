<?php
/*********
* Author: SW
* Date  : 
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Assigning Pages To Menu
* @package General*
* @link My_Controller.php
* @link views/menu_list/assign_pages/
*/
?>    
    
    
    <?php echo $assigned_pages_1; ?>
    
    
    <?php
    /*foreach($assigned_pages as $val){
    ?>
        <li class="ui-state-default" id="<?php echo $val['i_id'];?>" itemid="<?php echo $val['i_id'];?>">

        <input type="hidden" name="i_id[]" value="<?php echo encrypt($val['i_id']);?>">
        <span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $val['page_title'];?>


        <div class="sortable_content">
        <div class="sortable_content_left">Target</div>
        <div class="sortable_content_right">
        <select id="page_target" name="page_target[]"> 
        <option value="_self" <?php echo $val['page_target'] == "_self" ? 'selected="selected"' : '';?>>Open link in a same window/tab</option>
        <option value="_blank" <?php echo $val['page_target'] == "_blank" ? 'selected="selected"' : '';?>>Open link in a new window/tab</option>
        </select>
        </div>
        <div class="clr"></div>
        <div class="sortable_content_left">Title</div><div class="sortable_content_right"><input type="text" name="page_title[]" value="<?php echo $val['page_title'];?>"></div> 
        <div class="clr"></div>
        <div class="sortable_content_left">Class</div><div class="sortable_content_right"><input type="text" name="page_class[]" value="<?php echo $val['page_class'];?>"></div>  
        <?php
        if(!empty($val['page_title_default'])){
        ?>
            <div class="clr"></div>
            <div class="sortable_content_left">Original:</div><div class="sortable_content_right"><a href="<?php echo $val['page_link'];?>" target="_blank"><?php echo $val['page_title_default'];?></a></div>
        <?php
        }
        else{
        ?>
            <div class="clr"></div>
            <div class="sortable_content_left">Static:</div><div class="sortable_content_right"><a href="<?php echo $val['page_link'];?>" target="_blank"><?php echo $val['page_title'];?></a></div>
        <?php               
        }
        ?>
        <div class="clr"></div>
        <div class="sortable_content_left"><a href="javascript:;" class="menu_delete">Delete</a></div><div class="sortable_content_right"><a href="javascript:;" class="menu_cancle">Cancel</a></div>
        <div class="clr"></div>
        </div>
        <div class="clr"></div>
        </li>        
    <?php
    }*/                                  
    ?>        