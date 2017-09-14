<?php
function custom_lang_display($str='')
{
    return $str;
}

function cs_display_menu($arr){
   
    // expect format : array('contaniner'=>'div','contaniner_id'=>'div_header_id','contaniner_class'=>'div_header_class','menu_name'=>'Hedaer','menu_id'=>'ul_hedaer_id','menu_class'=>'ul_header_class','menu_echo'=>1);
    
    if(empty($arr)) return;
    elseif(empty($arr['menu_name'])) return;
    
    $CI = &get_instance();
    $CI->db->select('p.*');    
    $CI->db->from('bb_menu_list l');
    $CI->db->where('s_name', 'Top'); 
    $CI->db->join('bb_menu_page p', 'p.menu_id = l.i_id');
    $CI->db->join('bb_cms c', 'c.i_id = p.page_id' , 'left');
    $CI->db->order_by('p.page_order ASC, p.i_id DESC'); 

    $result = $CI->db->get()->result_array();

    //pr($result);
    
    if(!empty($result)){
        $menu_content  = (empty($arr['container']) || $arr['container'] !='nav') ? '<div' : '<nav';
        $menu_content .= (empty($arr['container_id'])) ? '' : ' id="'.$arr['container_id'].'"';
        $menu_content .= (empty($arr['container_class'])) ? '' : ' class="'.$arr['container_class'].'"';
        $menu_content .= '>';
        $menu_content .= '<ul';
        $menu_content .= (empty($arr['menu_id'])) ? '' : ' id="'.$arr['menu_id'].'"';
        $menu_content .= (empty($arr['menu_class'])) ? '' : ' class="'.$arr['menu_class'].'"';
        $menu_content .= '>';
        foreach($result as $val){
        $menu_content .='<li'; 
        $menu_content .=(empty($val['page_class'])) ? '' : ' class="'.$val['page_class'].'"';          
        $menu_content .='><a href="'.$val['page_link'].'" target="'.$val['page_target'].'">'.$val['page_title'].'</a></li>';   
        }
        $menu_content .= '</ul>';
        $menu_content .= (empty($arr['add_clear']) || $arr['add_clear'] !='1') ? '' : '<div class="clear"></div>';
        $menu_content .= (empty($arr['container']) || $arr['container'] !='1') ? '</div>' : '</nav>'.'';
        if((empty($arr['menu_echo']) || $arr['menu_echo'] !='0'))  echo $menu_content; 
        else return $menu_content;
    }
    
}

function getOptionRootPages($i_parent =0,$results='',$not_in='',$select='')
{    
    $CI = &get_instance();    
    $sql = "SELECT * FROM ".$CI->db->CMS." WHERE i_parent_id = {$i_parent} AND i_id !='".$not_in."' AND i_cms_type=1 AND e_status='Published' ";     // staement 1
    //$sql = "SELECT * FROM ".$CI->db->CMS." WHERE i_parent_id = {$i_parent}";    // staement 2       
    $get_options_obj = $CI->db->query($sql);
    $get_options_arr = $get_options_obj->result_array();
    $space='';
    
    $s_option = '';
	if(!empty($get_options_arr)) 
    {
		foreach ($get_options_arr as $val)
		{
			$s_select = '';
			if($val["i_id"] == $select)
				$s_select = " selected ";
			$s_option .= "<option $s_select value='".$val["i_id"]."' >".$val["s_title"]."</option>";
		}
	}

	unset($res, $mix_value, $s_select, $mix_where, $s_id);
	return $s_option;
    
}


function getOptionPages($i_parent =0,$results='',$not_in='',$select='')
{    
    $CI = &get_instance();    
    $sql = "SELECT * FROM ".$CI->db->CMS." WHERE i_parent_id = {$i_parent} AND i_id !='".$not_in."' AND i_cms_type=1 AND e_status='Published'  ";     // staement 1
    //$sql = "SELECT * FROM ".$CI->db->CMS." WHERE i_parent_id = {$i_parent}";    // staement 2       
    $get_options_obj = $CI->db->query($sql);
    $get_options_arr = $get_options_obj->result_array();
    $space='';
   
    if(!empty($get_options_arr)) 
    {
        
        foreach($get_options_arr as $val)
        {                
            if($val['i_parent_id'] ==0)  $depth = 0; else  $depth=cms_pages_depth($val['i_id']);
            //echo "i_parent_id:".$val['i_parent_id']." : s_title:".$val['s_title']." : depth:".$depth."<br>"; 
            for($i=0;$i<$depth;$i++) $space .= "-- ";
            $selected = $select == $val['i_id'] ? 'selected="selected"' : '';                    
            //if ( $val['i_id'] != $not_in ) // if statement 2  
            $results .='<option value="'.$val['i_id'].'" '.$selected.'>'.$space.$val['s_title'].'</option>';  
            $results = getOptionPages($val['i_id'],$results,$not_in,$select);
            $space='';             
        }        
    }    
    return $results;
}

function getCheckPages($i_parent =0,$results='',$not_in='',$check=''){
    
    $CI = &get_instance();    
    $sql = "SELECT * FROM ".$CI->db->CMS." WHERE i_parent_id = {$i_parent} AND i_id !='".$not_in."' AND i_cms_type=1 AND e_status='Published' ORDER BY i_id ASC ";
    // staement 1
    //$sql = "SELECT * FROM ".$CI->db->CMS." WHERE i_parent_id = {$i_parent}";    // staement 2       
    $get_options_obj = $CI->db->query($sql);
    $get_options_arr = $get_options_obj->result_array();
    $space='';
    //pr($get_options_arr,1);
    // new code on 14 Oct, 2015. Already added page will not show in the list
    $exist_arr = array();
    $sql2 = "SELECT page_id FROM ".$CI->db->MENU_PAGE." WHERE 1";
    //$sql2 = "SELECT page_id FROM ".$CI->db->MENU_PAGE." WHERE i_parent_id!=0 ";
    $options_obj = $CI->db->query($sql2);
    $options_arr = $options_obj->result_array();
    if(!empty($options_arr))
    {
        foreach($options_arr as $v)
        {
            $exist_arr[]= $v['page_id'];
        }
    }
   
    if(!empty($get_options_arr)) {
        
            foreach($get_options_arr as $val)
            {
                  
                    if($val['i_parent_id'] ==0)  $depth = 0; else  $depth=cms_pages_depth($val['i_id']);
                    //echo "i_parent_id:".$val['i_parent_id']." : s_title:".$val['s_title']." : depth:".$depth."<br>"; 
                    for($i=0;$i<$depth;$i++) $space .= "&nbsp;&nbsp;&nbsp;";
                    $checked = $check == $val['i_id'] ? 'checked="checked"' : '';
                    
                    //if ( $val['i_id'] != $not_in ) // if statement 2  
                    if(!in_array($val['i_id'],$exist_arr))    
                    {
                        $results .= $space.'<input type="checkbox" name="cms[]" value="'.$val['i_id'].'" '.$check.' data-no-uniform="true">'.$val['s_title']."<br>"; 
                    }   
                                      
                    $results = getCheckPages($val['i_id'],$results,$not_in,$check);
                    $space='';                
                
            }        
    }    
    return $results;    
}


function cms_pages_depth($i_parent=0,$depth=0){
    
    $CI = &get_instance();
    
    $sql = "SELECT * FROM ".$CI->db->CMS." WHERE i_id = {$i_parent} AND (i_cms_type=1 OR i_cms_type=2) AND e_status='Published'  ";
    $get_options_obj = $CI->db->query($sql);
    $get_options_arr = $get_options_obj->result_array();
    
   
    
     if(!empty($get_options_arr)) {
        
            foreach($get_options_arr as $val){
                
                    if($val['i_parent_id'] !=0) {
                        
                        return cms_pages_depth($val['i_parent_id'],$depth+1);
                    }
                    
                    else{
                        
                      return $depth;
                    }
                
            }
            
     }
    
    
}


function getOptionMenu($s_id = 0)
{
    $CI =  &get_instance();
    $opt = '';
    $res = $CI->db->select('i_id, s_name')->get_where($CI->db->MENU_LIST, array('i_status'=>1))->result_array();
    for($i = 0; $i<count($res); $i++)
    {
        $selected = decrypt($s_id) == $res[$i]['i_id'] ? 'selected="selected"' : '';
        $opt .= '<option value="'.encrypt($res[$i]['i_id']).'" '.$selected.'>'.$res[$i]['s_name'].'</option>';
    }
    unset($CI, $res, $selected);
    return $opt;
}

function getCheckMenus($parent_id =0,$menu_id=''){
    
    if(empty($menu_id)) return $menu_id;
        
    $CI = &get_instance();
    $sql = "SELECT * FROM ".$CI->db->MENU_PAGE." WHERE menu_id='".$menu_id."' ORDER BY page_order ASC "; 
    $get_options_obj = $CI->db->query($sql);
    $get_options_arr = $get_options_obj->result_array();
   
    return html_ordered_menu($get_options_arr,$parent_id);
    
}

function ordered_menu($array,$parent_id = 0)
{
    $temp_array = array();
    foreach($array as $element)
    {
        if($element['i_parent_id']==$parent_id)
        {
          $element['subs'] = ordered_menu($array,$element['i_id']);
          $temp_array[] = $element;
        }
    }
    return $temp_array;
}

function html_ordered_menu_old($array, $parent_id = 0)
{
    $class = $parent_id == 0 ? "sortable" : "";
    $menu_html = '<ol class="'.$class.'">';
    foreach($array as $val)
    {
        if($val['i_parent_id']==$parent_id)
        {
            /*$menu_html .= '<li id="list_'.$val['i_id'].'"><div>'.$val['page_title'].'</div>';
            $menu_html .= html_ordered_menu($array,$val['i_id']);
            $menu_html .= '</li>';*/
            ob_start();
            ?>
            <li id="list_<?php echo $val['i_id'];?>" itemid="<?php echo $val['i_id'];?>">
                <div>
                    <a href="javascript:;" class="show_content" rel="<?php echo $val['i_id'];?>">+</a>
                    <?php echo $val['page_title'];?>
                </div>
                <input type="hidden" name="i_id[]" value="<?php echo encrypt($val['i_id']);?>">

                <div class="sortable_content" id="c_<?php echo $val['i_id'];?>">
                
                    <div class="col-md-12 no-padding">
                        <div class="col-md-3">
                            <label>Target</label>
                        </div>
                        <div class="col-md-3">
                            <select id="page_target" name="page_target[]" class="form-control" style="width: 250px;"> 
                                <option value="_self" <?php echo $val['page_target'] == "_self" ? 'selected="selected"' : '';?>>Open link in a same window/tab</option>
                                <option value="_blank" <?php echo $val['page_target'] == "_blank" ? 'selected="selected"' : '';?>>Open link in a new window/tab</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-12 no-padding">
                        <div class="col-md-3">
                            <label>Title</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="page_title[]" value="<?php echo $val['page_title'];?>">
                        </div>
                    </div>
                    
                    <div class="col-md-12 no-padding">
                        <div class="col-md-3">
                            <label>Class</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="page_class[]" value="<?php echo $val['page_class'];?>">
                        </div>
                    </div>
                    
                    <div class="col-md-12 no-padding">
                        <div class="col-md-3">
                            <?php /*if(!empty($val['page_title_default'])){?>
                            <label>Original</label>
                            <?php } else{ ?>                            
                            <label>Static</label>
                            <?php }*/ ?>
                            <label>Actions</label>
                        </div>
                        <div class="col-md-6">
                            <?php /*if(!empty($val['page_title_default'])){?>
                            <?php echo $val['page_title_default'];?>
                            <?php } else{ ?>                            
                            <?php echo $val['page_title'];?>
                            <?php }*/ ?>
                            <div class="sortable_content_left">
                                <a href="javascript:;" class="menu_delete">Delete</a>
                            </div>
                            <div class="sortable_content_right">
                                <a href="javascript:;" class="menu_cancle">Cancel</a>
                            </div>
                        </div>
                    </div>
                    <?php /* ?>
                    <div class="sortable_content_left">Target</div>
                        <div class="sortable_content_right">
                            <select id="page_target" name="page_target[]"> 
                                <option value="_self" <?php echo $val['page_target'] == "_self" ? 'selected="selected"' : '';?>>Open link in a same window/tab</option>
                                <option value="_blank" <?php echo $val['page_target'] == "_blank" ? 'selected="selected"' : '';?>>Open link in a new window/tab</option>
                            </select>
                        </div>
                        <div class="sortable_content_left">Title</div>
                        <div class="sortable_content_right">
                            <input type="text" name="page_title[]" value="<?php echo $val['page_title'];?>">
                        </div> 
                       
                        <div class="sortable_content_left">Class</div>
                        <div class="sortable_content_right">
                            <input type="text" name="page_class[]" value="<?php echo $val['page_class'];?>">
                        </div>  
                        <?php if(!empty($val['page_title_default'])){?>
                            <div class="sortable_content_left">Original:</div>
                            <div class="sortable_content_right">
                                <a href="<?php echo $val['page_link'];?>" target="_blank"><?php echo $val['page_title_default'];?></a></div>
                        <?php } else {?>
                            <div class="sortable_content_left">Static:</div><div class="sortable_content_right"><a href="<?php echo $val['page_link'];?>" target="_blank"><?php echo $val['page_title'];?></a></div>
                        <?php }?>
                        
                        <div class="sortable_content_left">
                            <a href="javascript:;" class="menu_delete">Delete</a>
                        </div>
                        <div class="sortable_content_right">
                            <a href="javascript:;" class="menu_cancle">Cancel</a>
                        </div>
                        <?php */ ?>
                        <div class="clearfix" style="border: none;"></div>
                    </div>
                    
            </li>
            <?php 
            $menu_html .= ob_get_contents();
            ob_clean();
            $menu_html .= html_ordered_menu($array,$val['i_id']);
        }
    }
    $menu_html .= '</ol>';
    return $menu_html;
}

function html_ordered_menu_bk_lastcode_4nov($array, $parent_id = 0) 
{ 
    $class = $parent_id == 0 ? "sortable" : "";
    $menu_html = '<ol class="'.$class.'">';
    if(!empty($array))
    {
        foreach($array as $val)
        {
            if($val['i_parent_id'] == $parent_id)
            {
                $menu_html .= '<li id="list_'.$val['i_id'].'" itemid="'.$val['i_id'].'">
                <div>
                    <a href="javascript:;" class="show_content" rel="'.$val['i_id'].'">&nbsp;<i class="fa fa-plus">&nbsp;</i></a>
                    '.$val['page_title'].'
                </div>
                <input type="hidden" name="i_id[]" value="'.encrypt($val['i_id']).'">
                
                <div class="sortable_content" id="c_'.$val['i_id'].'">
                
                    <div class="col-md-12 no-padding">
                        <div class="col-md-3">
                            <label>Target</label>
                        </div>
                        <div class="col-md-3">
                            <select id="page_target" name="page_target[]" class="form-control" style="width: 250px;"> 
                                <option value="_self" '.($val['page_target'] == "_self" ? 'selected="selected"' : '').'>Open link in a same window/tab</option>
                                <option value="_blank" '.($val['page_target'] == "_blank" ? 'selected="selected"' : '').'>Open link in a new window/tab</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-12 no-padding">
                        <div class="col-md-3">
                            <label>Title</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="page_title[]" value="'.$val['page_title'].'">
                        </div>
                    </div>
                    
                    <div class="col-md-12 no-padding">
                        <div class="col-md-3"><label>Actions</label></div>
                        <div class="col-md-6">
                            <div class="sortable_content_left">
                                <a href="javascript:;" class="menu_delete">Delete</a>
                            </div>
                            <div class="sortable_content_right">
                                <a href="javascript:;" class="menu_cancle">Cancel</a>
                            </div>
                        </div>
                    </div>
                    
                 </div>   
                '.html_ordered_menu($array, $val['i_id']).'
                </li>';
            }
        }
    }
    $menu_html .= '</ol>';
    return $menu_html;
} 

function html_ordered_menu($array, $parent_id = 0) 
{ 
    $class = $parent_id == 0 ? "sortable" : "";
    $menu_html = '<ol class="'.$class.'">';
    if(!empty($array))
    {
        foreach($array as $val)
        {
            if($val['i_parent_id'] == $parent_id)
            {
                $menu_html .= '<li id="list_'.$val['i_id'].'" itemid="'.$val['i_id'].'">
                <div>
                    <a href="javascript:;" class="show_content" rel="'.$val['i_id'].'">&nbsp;<i class="fa fa-plus">&nbsp;</i></a>
                    '.$val['page_title'].'
                </div>
                <input type="hidden" name="i_id[]" value="'.encrypt($val['i_id']).'">
                
                <div class="sortable_content" id="c_'.$val['i_id'].'">
                    
                    <div class="col-md-12 no-padding">
                        <div class="col-md-3"><label>Actions</label></div>
                        <div class="col-md-6">
                            <div class="sortable_content_left">
                                <a href="javascript:;" class="menu_delete">Delete</a>
                            </div>
                            <div class="sortable_content_right">
                                <a href="javascript:;" class="menu_cancle">Cancel</a>
                            </div>
                        </div>
                    </div>
                    
                 </div>   
                '.html_ordered_menu($array, $val['i_id']).'
                </li>';
            }
        }
    }
    $menu_html .= '</ol>';
    return $menu_html;
} 

?>
