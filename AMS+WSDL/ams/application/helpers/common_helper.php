<?php

/*********
* Author: SWI
* Date  : 02 June 2016
* Modified By:  
* Modified Date: 
* Purpose:
*  Custom Helpers 
* Includes all necessary files and common functions
*/

//Encryption and Decryption//

/***
* Encryption double ways.
* @param string $s_var
* @return string
*/

function encrypt($s_var)
{
    try
    { 
        $ret_=$s_var."#acu";///Hardcodded here for security reasons
        $ret_=base64_encode(base64_encode($ret_));
        unset($s_var);
        return $ret_;
    }

    catch(Exception $err_obj)
    {
		show_error($err_obj->getMessage());
    }  
}

/**
* Decryption double ways.
* 
* @param string $s_var
* @return string
*/
function decrypt($s_var)
{
    try
    {
        $ret_=base64_decode(base64_decode($s_var));
        $ret_=str_replace("#acu","",$ret_);
        unset($s_var);
        return $ret_;
    }

    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }      

}
//end Encryption and Decryption//


/**
 * Admin Base URL *
 * Returns the "admin_base_url" item from your config file *
 * @access    public
 * @return    string
 */
if ( ! function_exists('admin_base_url'))
{
    function admin_base_url()
    {
        try
        {
         	$CI =& get_instance();
			return $CI->config->slash_item('admin_base_url');
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    }

}
// ------------------------------------------------------------------------

function text_template($key)
{
    $template_ = array(
        'file_info' => "\nFile Name: %s \nCreated By: %s \nCreated On: %s \nPurpose: %s \n",
        'include_javascript' => "<script type=\"text/javascript\" src=\"%s\"></script>",
        'include_css' => "<link rel=\"stylesheet\" type=\"text/css\" href=\"%s\">",
        'text' => "<div class=\"col-md-5 %s\">\n\t\t<div class=\"form-group\">\n\t\t<label for=\"focusedInput\"><?php echo addslashes(t(\"%s\"))?><span class=\"text-danger\">%s</span></label>\n\t\t\t<input class=\"form-control\" rel=\"%s\" id=\"%s\" name=\"%s\" value=\"<?php echo \$posted[\"%s\"];?>\" type=\"text\" /><span class=\"text-danger\"></span>\n\t\t</div>\n\t</div>",
        'radio' => "<div class=\"col-md-5\">\n\t\t<div class=\"form-group\">\n\t\t<label for=\"focusedInput\"><?php echo addslashes(t(\"%s\"))?><span class=\"text-danger\">%s</span></label>\n\t\t\t<input type=\"radio\" name=\"%s\" id=\"%s\" value=\"<?php echo \$posted[\"%s\"]?>\">n<span class=\"text-danger\"></span>\n\t\t</div>\n</div>",
        'image_upload' => "<div class=\"col-md-5 %s\">\n\t\t<div class=\"form-group\">\n\t\t<label for=\"focusedInput\"><?php echo addslashes(t(\"Upload %s\"))?><span class=\"text-danger\">%s</span></label>\n\t\t\t%s<input id=\"%s\" name=\"%s\" type=\"file\" /><span class=\"text-danger\"></span>\n\t\t</div>\n\t</div>",
        'file_upload' => "<div class=\"col-md-5 %s\">\n\t\t<div class=\"form-group\">\n\t\t<label for=\"focusedInput\"><?php echo addslashes(t(\"Upload %s\"))?><span class=\"text-danger\">%s</span></label>\n\t\t\t%s<input id=\"%s\" name=\"%s\" type=\"file\" /><span class=\"text-danger\"></span>\n\t\t</div>\n\t</div>",
    );

       return $template_[$key];
}

// ------------------------------------------------------------------------
/**
* Saves the error messages into session.
* 
* @param string $s_msg
* @return void
*/
function fe_set_error_msg($s_msg)
{
    try
    {
        $ret_="";
        if(trim($s_msg)!="")
        {
            $o_ci=&get_instance();
            $ret_=$o_ci->session->userdata('error_msg');
            $ret_.='<div id="err_msg" class="error_message">'.$s_msg.'</div>';
            $o_ci->session->set_userdata('error_msg',$ret_);
        }
        unset($s_msg,$ret_);
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }     
}

/**
* Saves the error messages into session.
* 
* @param string $s_msg
* @return void
*/
function fe_set_success_msg($s_msg)
{
    try
    {
        $ret_="";
        if(trim($s_msg)!="")
        {
            $o_ci=&get_instance();
            $ret_=$o_ci->session->userdata('success_msg');
            $ret_.='<div class="success_message">'.$s_msg.'</div>';
            $o_ci->session->set_userdata('success_msg',$ret_);
            //echo $o_ci->session->userdata('success_msg');
        }
        unset($s_msg,$ret_);
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }     
}

/**
* Displays the success or error or both messages.
* And removes the messages from session
* 
* @param string $s_msgtype, "error","success","both" 
* @return void
*/
function show_msg($s_msgtype="both")
{
    try
    {
        $o_ci=&get_instance();
        switch($s_msgtype)
        {
            case "error":
                echo $o_ci->session->userdata('error_msg');
                $o_ci->session->unset_userdata('error_msg');
            break;    

            case "success":
                echo $o_ci->session->userdata('success_msg');
                $o_ci->session->unset_userdata('success_msg');
            break;    

            default:
                echo $o_ci->session->userdata('success_msg');
                echo $o_ci->session->userdata('error_msg');
                $array_items = array('success_msg' => '', 'error_msg' => '');
                $o_ci->session->unset_userdata($array_items);
                unset($array_items);
            break;            
        }
        unset($s_msgtype);
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }     
}


/**
* Displays the pre-formatted array 
* @param mix $mix_arr
* @param int $i_then_exit
* @return void
*/


function pr($mix_arr = array(), $i_then_exit = 0)
{
	try
        {
         	echo '<pre>';
			print_r($mix_arr);
			echo '</pre>';
			unset($mix_arr);
			if($i_then_exit)
			{
				exit();
			}
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

}



/**
* Displays the pre-formatted array with array element type
* @param mix $mix_arr
* @param int $i_then_exit
* @return void
*/

function vr($mix_arr = array(), $i_then_exit = 0)
{

	try
        {
         	echo '<pre>';
			var_dump($mix_arr);
			echo '</pre>';
			unset($mix_arr);
			if($i_then_exit)
			{
				exit();
			}

        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

}





/****
* Function to format input string
*
*****/
function get_formatted_string($str)
{
    try
    {  
	    return ($str);
		//return addslashes(htmlentities(trim($str),ENT_QUOTES,'UTF-8'));
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }         
}
/****
* Function to reverse of get_formatted_string
*
*****/
function get_unformatted_string($str)
{
    try
    {    
	    //return htmlspecialchars(stripslashes($str));
		return $str;
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }         
}

/****`
* Function to compare string
*
*****/
function my_receive_string($str)
{
    try
    {  
		return addslashes(trim($str));
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }         
}

/****
* Function to show string
*
*****/
function my_show_string($str)
{
    try
    {  
		return htmlspecialchars($str);
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }         
}




/**
* For uploading files, picture etc.
* @param string $s_up_path, $s_fld_name, $s_file_name
* @param int $i_max_file_size
* @param mixture $mix_allowed_types
* @param mixture $mix_configArr
* @return void
*/

function get_file_uploaded(	$s_up_path = '', $s_fld_name = '', $s_file_name = '', $i_max_file_size = '' ,
							$mix_allowed_types = '', $mix_configArr = array()
						  )
{
    try
        {
			$CI = & get_instance();		

			$CI->load->library('upload');
			$i_config_max_file_size = $CI->config->item('admin_file_upload_max_size');
			$s_file_ext	= getExtension(@$_FILES[$s_fld_name]['name']);			

			$mix_config['upload_path'] 	= $s_up_path;
			$mix_config['allowed_types']= (!empty($mix_allowed_types) && !is_numeric($mix_allowed_types))?$mix_allowed_types:'png|jpg|gif';
			$s_filename = (!empty($s_file_name))?$s_file_name:getFilenameWithoutExtension(@$_FILES[$s_fld_name]['name']);
			$mix_config['file_name']= $s_filename.$s_file_ext;
			$mix_config['max_size']	= (!empty($i_max_file_size) && is_numeric($i_max_file_size))?$i_max_file_size:$i_config_max_file_size;			

            //print_r($mix_config);exit;
            
			if(is_array($mix_configArr) && count($mix_configArr)>0)
			{
				foreach($mix_configArr as $key=>$val)
				$mix_config[$key] = $val;
			}				
			unset($s_up_path, $i_max_file_size , $mix_allowed_types ,$mix_configArr, $i_config_max_file_size);			

			$CI->upload->initialize($mix_config);			
			$s_response 	= ( ! $CI->upload->do_upload($s_fld_name))?('err|@sep@|'.$CI->upload->display_errors('<div>', '</div>')):('ok|@sep@|'.$s_filename.$s_file_ext);

			unset($s_filename, $s_fld_name, $s_file_ext);
			return $s_response;	
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

}



/**
* For geting extension of a file
* @param string $s_filename
* @return string
*/

function getExtension($s_filename = '')
{
	try
        {
         	if(empty($s_filename))
			return FALSE;
			$mix_matches = array();
			preg_match('/\.([^\.]*)$/', $s_filename, $mix_matches);
			unset($s_filename);		
			return strtolower($mix_matches[0]);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
}

/**
* For geting filename without extension of a file
* @param string $s_filename
* @return string
*/

function getFilenameWithoutExtension($s_filename = '')
{
	try
        {
         	if(empty($s_filename))
			return FALSE;

			$mix_matches = array();
			preg_match('/(.+?)(\.[^.]*$|$)/', $s_filename, $mix_matches);
			unset($s_filename);
			$entities = array(" ",'.','!', '*', "'","-", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]", "!");
			//$s_new_filename = str_replace($entities,"_",$mix_matches[1]);
			
			$s_new_filename = str_replace($entities,"_",$mix_matches[1]).'_'.time();
			return strtolower($s_new_filename);
			 
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

}

/**
* For deleting of a file from system
* @param string $s_up_path as the path of the file
* @param string $s_filename
* @return string
*/

function get_file_deleted($s_up_path = '', $s_file_name = '')
{
	try
        {
         	if(is_dir($s_up_path) && fileperms($s_up_path)!='0777')
			{
				chmod($s_up_path, 0777);
			}

			if(file_exists($s_up_path.$s_file_name))
			{
				 @unlink($s_up_path.$s_file_name);
				 return TRUE;
			}
			else
			{
				return FALSE;
			}

        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

}



/**
* For image thumbnailing
* @param string $s_img_path, $s_new_path, $s_file_name
* @param int $i_new_height, $i_new_width 
* @param mix $configArr
* @return string
*/



function get_image_thumb($s_img_path = '',$s_new_path = '',	$s_file_name = '', $i_new_height = '', $i_new_width = '',$mix_configArr = array())

{
	try
        {

			$CI = & get_instance();
			$CI->load->library('image_lib');
			$i_new_height = (!empty($i_new_height))?$i_new_height:$CI->config->item('admin_image_upload_thumb_height');
			$i_new_width  = (!empty($i_new_width))?$i_new_width:$CI->config->item('admin_image_upload_thumb_width');		

			$config['image_library'] 	= 'gd2';
			$config['source_image']  	= $s_img_path;
			$config['create_thumb']  	= TRUE;
			$config['maintain_ratio'] 	= TRUE;
			$config['width'] 			= $i_new_width;
			$config['height'] 			= $i_new_height;			
            $config['master_dim'] 		= "width";
			$config['thumb_marker'] 	= '';
			$config['new_image'] 		= $s_new_path.$s_file_name;			

			if(is_array($mix_configArr) && count($mix_configArr)>0)
			{
				foreach($mix_configArr as $s_key=>$mix_val)
					$config[$s_key] = $mix_val;
			}	

			$CI->image_lib->initialize($config); 
			unset($s_img_path, $s_new_path, $s_file_name, $i_new_height, $i_new_width ,$mix_configArr, $config);
			$b_res = $CI->image_lib->resize();
			$CI->image_lib->clear();
			if( !$b_res )
			{
				unset($b_res);
				return $msg	= $CI->image_lib->display_errors('<div class="err">','</div>');
			}
			else
			{
				unset($b_res);
				return 'ok';
			}
        }
        catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}

}

/*======================= START CREATE MENUS AND SUB-MENUS =======================*/

  /*
* Creates the menus and sub menus with respect to access control
* Provided to user type. This echos the formatted menus.
* @returns void
* Dont delete/ change this function
*/
function create_menus()
{
    try
    {
        //$s_active = '';
        $s_str = '';
        $CI =& get_instance();
        $admin_loggedin = $CI->session->userdata("admin_loggedin");
        
        $CI->load->model('menu_model');
        $s_where = " WHERE i_parent_id = 0 ";
        $top_menu = $CI->menu_model->fetch_menus_navigation($s_where,decrypt($admin_loggedin['user_type_id']));
        //print_r($top_menu);exit;
        foreach($top_menu as $key=>$menus)
        {    
            if($key == 0)
            {
                $s_active='class="active"';
            }
            else 
            {    
                $s_active= '';
            }
            
            $tmp = create_sub_menus($menus['id'],$key);
            
            if(trim($tmp)!='' || $menus['i_total_controls']>0)
            {                
                $s_str .= '<li  class="line"><a id="mnu_'.$key.'" href="javascript:void(0);" '.$s_active.'><b>'.$menus['s_name'].'</b></a>';            
                $s_str.= $tmp;            
                $s_str.= '</li>';
                unset($tmp);                
            }
           
        } // end for
        //var_dump($s_str);
        $s_str='<ul class="select">'.$s_str.'</ul>';
        echo $s_str;       
        unset($admin_loggedin,$menus,$key,$top_menu);   
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}

/*
* Creates the sub menus at layer 2 with respect to access control
* Provided to user type. This echos the formatted sub sub menus.
* @returns formatted submenu layer 1 as string
* Dont delete/ change this function
*/
function create_sub_menus($parent_id,$i_mnu_id,$i_layer=0)
{
    try
    {
            $s_ret_="";
       
            $CI =& get_instance();            
            $admin_loggedin = $CI->session->userdata("admin_loggedin");
            $CI->load->model('menu_model');
            // Changes made by koushik
            $s_wh_cl = " WHERE i_parent_id = {$parent_id} AND i_main_id!=-99 ";  
            $sub_menu = $CI->menu_model->fetch_menus_navigation($s_wh_cl,decrypt($admin_loggedin['user_type_id']));        
                
            foreach($sub_menu as $con=>$mnus)
            {
                
                $tmp = create_sub_menus2($mnus['id'],$i_mnu_id,$con);
                if(trim($tmp)!='' || $mnus['i_total_controls']>0)
                {
                    $s_link=($mnus["s_link"]!=""?admin_base_url().$mnus["s_link"]:"javascript:void(0);");
                    $s_ret_.='<li><a id="mnu_'.$i_mnu_id.'_'.$con.'" href="'.$s_link.'">'.$mnus['s_name'].'</a>';
                    $s_ret_.=$tmp;
                    $s_ret_.='</li>';
                    unset($tmp);
                }
                
            }///end for  
                      
            unset($con,$mnus,$s_link,$admin_loggedin);
               
        return ($s_ret_!=""?'<ul class="sub">'.$s_ret_.'</ul>':'');
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}

/* sub menus at layer 2 
* Dont delete/ change this function
*/
function create_sub_menus2($parent_id,$i_main_menu,$i_sub_menu)
{
    try
    {
            $s_ret_="";
            $CI =& get_instance();
            $admin_loggedin = $CI->session->userdata("admin_loggedin");
            $CI->load->model('menu_model');
            $s_wh_cl = " WHERE i_parent_id = {$parent_id} AND i_main_id!=-99";  
            $sub_menu = $CI->menu_model->fetch_menus_navigation($s_wh_cl,decrypt($admin_loggedin['user_type_id']));
                        
            foreach($sub_menu as $con=>$mnus)
            {
                if($mnus['i_total_controls']>0)
                {                
                    $s_link=($mnus["s_link"]!=""?admin_base_url().$mnus["s_link"]:"javascript:void(0);");    
                    $s_ret_.='<li><a id="mnu_'.$i_main_menu.'_'.$i_sub_menu.'_'.$con.'" href="'.$s_link.'">'.$mnus['s_name'].'</a>';
                    $s_ret_.='</li>';
                }
                
            }///end for
            ////end Sub sub menu exists i.e layer 2///////
            unset($con,$mnus,$s_link,$admin_loggedin);
       ///end if
       return ($s_ret_!=""?'<ul class="sub2">'.$s_ret_.'</ul>':'');
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}


	/*======================= END CREATE MENUS AND SUB-MENUS =======================*/
	



/* return string which end with a full letter */
function string_part($str, $limit=20)
{
	//$limit=20;
	$str = strip_tags($str);
	if(strlen($str)<$limit)
		return $str;
	
	$n_str =  explode(' ',substr($str,0,$limit));
	if(count($n_str)>1)
	{
		array_pop($n_str);
		$f_str = implode(' ',$n_str).' ...';
	}
	else
	{
		$f_str = implode(' ',$n_str);
	}
	return $f_str;
}




//////sh ajax Jason for any array to use into JS///
function makeArrayJs($mix_php_array = array())
{
    try
    {   
        if(!empty($mix_php_array))
        {
            return  json_encode($mix_php_array);
        }         
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}
//////sh ajax Jason for any array to use into JS///

    

function make_my_url($s_string='')
{
    try
    {
        if($s_string=='')
            return false ;
        $s_string = preg_replace('/([^a-z0-9A-Z])/i','-',$s_string);       
        $mix_matches = array();
        preg_match('/(.+?)(\.[^.]*$|$)/', trim($s_string), $mix_matches);
        unset($s_filename);
        $entities = array("^"," ",".","~","!", "*", "'","_", "(", ")", ";", ":", "@","&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
        $s_new_filename = str_replace($entities,"-",$mix_matches[1]);
        $s_new_filename = preg_replace('/[-]{2,}/','-',$s_new_filename);
        return mb_strtolower(trim($s_new_filename,'-'),'UTF-8');
        #return strtolower(trim($s_new_filename,'-'),'UTF-8');
        //return (trim($s_new_filename,'-'));
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}

function remove_space($str)
{
	if($str =='')
		return;
	else 
		return strtolower(str_replace(' ', '_', trim($str)));
}

function my_receive($value)
{
    $CI = get_instance();
 	return $CI->db->escape_str(trim($value));
}

function my_showtext($value)
{
 	return addslashes(htmlspecialchars($value));
}

function now()
{
	$CI	= &get_instance();
	$rslt  =   $CI->db->query("SELECT NOW() AS now")->row_array();
	return $rslt['now'];	
}



function r_path($path = '', $section = ADMIN_DIR)
{	
	$CI =& get_instance();
	return $CI->config->base_url($uri).'resource/'.$section.'/'.$path;
}

function fer_path($path = '')
{    
    $CI =& get_instance();
    return $CI->config->base_url($uri).'resource/fe/'.$path;
}

function show_text($str = '')
{
	return htmlspecialchars_decode($str);
}

function admin_date($date = '', $str = '', $show_time = false)
{
    $date = trim($date);
	if($date == '' || $date == '0000-00-00 00:00:00' || $date == '0000-00-00') return $str;
	return date('m/d/Y'.($show_time ? ' H:i:s' : ''), strtotime($date));
}

function make_db_date($date = '',$time_add=false)
{ 
	if($date == '') return '0000-00-00 00:00:00';
	list($date, $time) = explode(' ', $date);
    if($time_add && $time=='')
        $time = '00:00:00';
	list($m, $d, $y) = explode('/', $date);
	return trim($y.'-'.$m.'-'.$d.' '.$time);
}

/*
+-----------------------------------------------+
| Set congfiguration for front end pagination 	|
+-----------------------------------------------+
| Added by |
+-----------------------------------------------+
*/
function fe_ajax_pagination($ctrl_path = '',$total_rows = 0, $start, $limit = 0, $paging_div = '')
{
	$CI =   &get_instance();
	$CI->load->library('jquery_pagination');
	
	$config['base_url'] 	= $ctrl_path;
	$config['total_rows'] 	= $total_rows;
	$config['per_page'] 	= $limit;
	$config['cur_page'] 	= $start;
	$config['uri_segment'] 	= 0;
	$config['num_links'] 	= 3;
	$config['page_query_string'] = false;	
	$config['full_tag_open'] = '<ul>';
	$config['full_tag_close'] = '</ul>';
    
    //$config['prev_link'] = '<img src="'.fer_path('images/arrow4.png').'" alt=""> ';
    //$config['next_link'] = ' <img src="'.fer_path('images/arrow5.png').'" alt="">';
	//$config['prev_link'] = '<< ';
	//$config['next_link'] = ' >>';
    //$config['prev_link'] = '<li class="nxt_prv"><a><img src="'.fer_path('images/arrow4.png').'" alt=""></a></li>';
    //$config['next_link'] = '<li class="nxt_prv"><a><img src="'.fer_path('images/arrow5.png').'" alt=""></a></li>';
    
	$config['num_tag_open'] = '';
	$config['num_tag_close'] = '';
	$config['cur_tag_open'] = '<li class="active"><a>';
	$config['cur_tag_close'] = '</a></li>';

	/*$config['next_tag_open'] = '<a class="pagerPre">';
	$config['next_tag_close'] = '</a>';
	$config['prev_tag_open'] = '<a class="pagerPre">';
	$config['prev_tag_close'] = '</a>';
    $config['first_link'] = '';
    $config['last_link'] = '';*/
    $config['next_tag_open'] = '';
    $config['next_tag_close'] = '';
    $config['prev_tag_open'] = '';
    $config['prev_tag_close'] = '';
    
    //$config['first_link'] = '<li class="nxt_prv"><a><img src="'.fer_path('images/arrow4.png').'" alt=""></a></li>';
    //$config['last_link'] = '<li class="nxt_prv"><a><img src="'.fer_path('images/arrow5.png').'" alt=""></a></li>';
    
   $config['first_link'] = '<<';
   $config['last_link'] = '>>'; 
	
	$config['div'] = '#'.$paging_div;
	
	$CI->jquery_pagination->initialize($config);
	return $CI->jquery_pagination->create_links();
}


/*
+-------------------------------------------------------+
| Get verification code for front end user registration	|
+-------------------------------------------------------+
| Added by JS on 26 Feb 2014							|
+-------------------------------------------------------+
*/
function genVerificationCode() 
{
	$CI = & get_instance();
	$char = "ABC8D7EF4123497GHIJKL98874KJA798HJHSAS636131MNOPQRS55ASDDFASDFASDFFFASTUVWXYZ23AK465JF4SUYRBJKCJASDYSAF";
	$code = ''; 
	for ($p = 0; $p < 10; $p++) 
		$code .= $char[mt_rand(0, strlen($char))];
	$code .= '-'.time();
	$status = $CI->db->get_where($CI->db->USER, array('s_verification_code'=>$code))->num_rows();
	if($status > 0)
		genVerificationCode();
	else	
		return $code;
}



# ====================================================================================
#           NEW FUNCTIONS - BEGIN
# ====================================================================================

function get_url_fb($url, $internal_call_count=0)
{
    //$url = str_replace('access_token=','access_token2=',$url); // for force error testing
    
    log_message('info', basename(__FILE__).' : '.'get_url_fb fetching: '.$url. ' no. of try: '.($internal_call_count+1));

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 600); // originally 5 secs
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER,array('Connection: close'));
    $tmp = curl_exec($ch);
    
    $http_ret_code=curl_getinfo($ch, CURLINFO_HTTP_CODE).'';
    
    curl_close($ch);
    
    $zzz=@json_decode($tmp);
    
    if(
        ($http_ret_code!='200') ||
        ($tmp=='') ||
        isset($zzz->error)
    )
    {
        log_message('debug', basename(__FILE__).' : '.'get_url_fb fetching error: '.$tmp.' return status code: '.$http_ret_code.' for url: '.$url);

        $internal_call_count++;
        if($internal_call_count<3)
        {
            sleep(3);
            return get_url_fb($url,$internal_call_count);
        }    
    }
    
    return $tmp;
}

# ====================================================================================
#           NEW FUNCTIONS - END
# ====================================================================================


# ====================================================================================
#           CURRENT PAGE URL
# ====================================================================================
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

# ====================================================================================
#           CURRENT PAGE URL
# ====================================================================================

/*
 * below function for strong password validation
 * setting from site setting
 */

function chkPasswordValidation($password='')
{
    $CI = & get_instance();
    $CI->load->model('site_setting_model');    
    $info = $CI->site_setting_model->fetch_this("NULL");   
    
    $min_len    = $info['s_pwd_min_len'];
    $max_len    = $info['s_pwd_max_len'];
    $cap_let    = $info['s_pwd_cap_let']; // on
    $sml_let    = $info['s_pwd_sml_let'];
    $one_no     = $info['s_pwd_num'];
    $spl_char   = $info['s_pwd_spl_char'];
    
    $err_msg = array();
    if($password=='')
    return true;
    //if (!preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $candidate))
    if(intval($min_len)>0)
    {
        if(strlen($password)<$min_len)
        {
            $err_msg[] = "The password should have minimum of {$min_len} character(s)";
        }        
    }
    if(intval($max_len)>0)
    {
        if(strlen($password)>$max_len)
        {
            $err_msg[] = "The password should have maximum of {$max_len} character(s)";
        }        
    }    
    if($cap_let=='on')
    {
        if (!preg_match_all('$\S*(?=\S*[A-Z])\S*$', $password))
        {
            $err_msg[] = "The password should have at least one capital letter";
        }
    }    
    if($sml_let=='on')
    {
        if (!preg_match_all('$\S*(?=\S*[a-z])\S*$', $password))
        {
            $err_msg[] = "The password should have at least one small letter";
        }
    }  
    if($one_no=='on')
    {
        if (!preg_match_all('$\S*(?=\S*[\d])\S*$', $password))
        {
            $err_msg[] = "The password should have at least one number";
        }
    }      
    if($spl_char=='on')
    {
        if (!preg_match_all('$\S*(?=\S*[\W])\S*$', $password))
        {
            $err_msg[] = "The password should have at least one special character";
        }
    }
    
    if(!empty($err_msg))
        return $err_msg;
    else
        return true;
    
}



function get_category_for_listing($cat  = '', $sub_cat = '')
{
    $CI = & get_instance();
    if(trim($cat) == '') return '--';
    $cat = explode(',',$cat);
    if(!empty($sub_cat))
        $sub_cat = explode(',',$sub_cat);
    for($i = 0; $i < count($cat); $i++)
    {
        $tmp[$cat[$i]][] = $CI->db->SELECT("CONCAT_WS(' / ',c.s_category,sc.s_category) AS category", false)
        ->join($CI->db->CATEGORY.' AS sc', 'c.i_id = sc.i_parent_id AND sc.i_id ='.intval($sub_cat[$i]), 'left')
        ->where('c.i_id = '.intval($cat[$i]))
        ->get($CI->db->CATEGORY.' AS c')
        ->result_array();
    }
    if(!empty($tmp))
    {
        foreach($tmp as $k => $v)
        {
            for($i = 0; $i < count($v); $i++)
                $tmp_cat[] = $v[$i][0]['category'];
            $ret[] = implode(', ', $tmp_cat);
            unset($tmp_cat);
        }
    }
    unset($cat, $sub_cat, $tmp);
    return implode('; &nbsp;&nbsp;&nbsp;', $ret);
}

function _category($catId)
{
    $CI = &get_instance();
    if($catId>0)
    {
        $cond = "WHERE i_id='".$catId."' ";
        $res = $CI->db->query("select i_id, s_category from {$CI->db->CATEGORY} {$cond} ORDER BY s_category ");      
        
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            $s_option = $mix_value[0]['s_category'];
        }
    }
    else
    {
        $s_option = 'All Catergory';
    }
    unset($res, $mix_value, $s_select, $mix_where, $s_id);
    return $s_option;
}

function _chk_category($s_where=null)
{
    $CI = &get_instance();
    $ret_ = array();
    if($s_where)
    {
        $res = $CI->db->query("select i_id, s_category from {$CI->db->CATEGORY} {$s_where} ORDER BY s_category ");   
        $ret_ = $res->result_array();
    }
    unset($res, $mix_value, $s_select, $mix_where, $s_id);
    return $ret_;
}

function  _price($price = '0', $str = '', $lt = 0)
{
    if($price == '') return $str?$str:'$0';
    else return '$'.number_format($price, $lt, '.',',');
}

function  _numeric($price = '0', $str = '', $lt = 0)
{
    if($price == '') return $str? $str : '0';
    else return number_format($price, $lt,'.',',');
}

function _phone($phn)
{
    //return $phn;
    /*if($phn == '') return '';
    //echo "(".substr($phn, 0, 3).") ".substr($phn, 3, 3)."-".substr($phn,6);
    return  str_replace('--', '-', (substr($phn, 0, 3)."-".substr($phn, 3, 3)."-".substr($phn,6)));*/
    
    if($phn == '') return '';
    $entities = array(" ","-","(",")");
    $phn = str_replace($entities,'',$phn);
    $first_part = "(".substr($phn, 0, 3).")";
    return $first_part."-".substr($phn, 3, 3)."-".substr($phn,6);
        
}

function _country($countryId)
{
    $CI = &get_instance();
    if($countryId>0)
    {
        $cond = "WHERE i_id='".$countryId."' ";
        $res = $CI->db->query("select i_id, name from {$CI->db->COUNTRY} {$cond} ORDER BY name ");      
        
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            $s_option = $mix_value[0]['name'];
        }
    }
    else
    {
        $s_option = '';
    }
    unset($res, $mix_value, $s_select, $mix_where, $s_id);
    return $s_option;
}

function _state($stateId)
{
    $CI = &get_instance();
    if($stateId>0)
    {
        $cond = "WHERE i_id='".$stateId."' ";
        $res = $CI->db->query("select i_id, name, i_country_id from {$CI->db->STATE} {$cond} ORDER BY name ");      
        
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            $s_option = $mix_value[0]['name'];
        }
    }
    else
    {
        #$s_option = 'All States';
        $s_option = 'States';
    }
    unset($res, $mix_value, $s_select, $mix_where, $s_id);
    return $s_option;
}

function _city($cityId)
{
    $CI = &get_instance();
    if($cityId>0)
    {
        $cond = "WHERE i_id='".$cityId."' ";
        $res = $CI->db->query("select i_id, name from {$CI->db->CITY} {$cond} ORDER BY name ");      
        
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            $s_option = $mix_value[0]['name'];
        }
    }
    else
    {
        #$s_option = 'All Cities';
        $s_option = 'Cities';
    }
    unset($res, $mix_value, $s_select, $mix_where, $s_id);
    return $s_option;
}

// get form title
function _form_title($formId)
{
    $CI = &get_instance();
    if($formId>0)
    {
        $cond = "WHERE i_id='".$formId."' ";
        $res = $CI->db->query("SELECT i_id, s_form_title FROM {$CI->db->FORM_MASTER} {$cond} ORDER BY s_form_title ");      
        
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            $s_option = $mix_value[0]['s_form_title'];
        }
    }
    unset($res, $mix_value, $s_select, $mix_where, $s_id);
    return $s_option;
}

// get user details from s_user_name
function _get_user_details($s_user_name)
{
    $CI = &get_instance();
    $s_option='';
    if(trim($s_user_name) != '')
    {
        $cond = "WHERE s_user_name ='".addslashes($s_user_name)."' ";
        $res = $CI->db->query("SELECT * FROM {$CI->db->USER} {$cond} ORDER BY s_user_name ");      
        
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            $s_option = $mix_value[0];
        }
    }
    unset($res, $mix_value, $s_select, $mix_where, $s_id);
    return $s_option;
}


function make_seo_friendly_url($inputString = '')
{
    if($inputString == '')return '';
    $url = strtolower(trim($inputString));
    $patterns = $replacements = array();
    $patterns[0] = '/(&amp;|&)/i';
    $replacements[0] = '-and-';
    $patterns[1] = '/[^a-zA-Z01-9]/i';
    $replacements[1] = '-';
    $patterns[2] = '/(-+)/i';
    $replacements[2] = '-';
    $patterns[3] = '/(-$|^-)/i';
    $replacements[3] = '';
    $url = preg_replace($patterns, $replacements, $url);
    return $url;
}


// get cms master name
function _cms_master($i_id=0)
{
    $CI = &get_instance();
    if($i_id>0)
    {
        $cond = "WHERE i_id='".$i_id."' ";
        $res= $CI->db->query("select i_id,s_name from {$CI->db->CMS_MASTER} {$cond} ORDER BY s_name");      
        $mix_value = $res->result_array();
        $s_option = '';
        $s_option = $mix_value[0]['s_name'];
    }
    else
    {
        $s_option = '';
    }
   
    unset($res, $mix_value, $s_select, $mix_where, $s_id);
    return $s_option;
}


function get_percentage($amount = 0, $percent_of = 0)
{
    if($amount > 0 && $percent_of > 0)
        return round((($amount/$percent_of)*100),1).'%';
    else if($amount < 0 && $percent_of > 0)
    {
        $amount = $amount * (-1);
        return '-'.round((($amount/$percent_of)*100),1).'%';
    }
    else
        return '0%';
}

function _remove_zero_decimal($amount='')
{
    $amount =  str_replace('.00','',$amount);
    $amount =  str_replace('.0','',$amount);
    return $amount;
}

function _get_pageurl($page_id = 0)
{
    if(intval($page_id) == 0) return '';
    $CI = &get_instance();
    $tmp = $CI->db->select('s_url')->get_where($CI->db->CMS, array('i_id' => $page_id))->result_array();
    unset($sic);
    return $tmp[0]['s_url'];
}

function _get_page_summary($page_id = 0)
{
    if(intval($page_id) == 0) return '';
    $CI = &get_instance();
    $tmp = $CI->db->select('s_summary')->get_where($CI->db->CMS, array('i_id' => $page_id))->result_array();
    unset($sic);
    return $tmp[0]['s_summary'];
}

function generate_password_old($length = 10)
{
    $length = $length > 0 ? $length  :10;
    $string='123456789ABCDE123456789FGHJKL!@#$%&*^MNPQRSTUVWXYZ1234567!@#$%&*^89abcdefghijkl123456789mnopqrstuvwxyz!@#$%&*^';
    $code = '';
    $i = 0;
    while ($i < $length)
    {
        $code .= substr($string, mt_rand(0, strlen($string)-1), 1);
        $i++;
    }
    return $code;
}
function generate_password($length = 10, $add_dashes = false, $available_sets = 'lud')//luds
{
	$sets = array();
	if(strpos($available_sets, 'l') !== false)
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	if(strpos($available_sets, 'u') !== false)
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	if(strpos($available_sets, 'd') !== false)
		$sets[] = '23456789';
	if(strpos($available_sets, 's') !== false)
		$sets[] = '!@#$%&*?';
	$all = '';
	$password = '';
	foreach($sets as $set)
	{
		$password .= $set[array_rand(str_split($set))];
		$all .= $set;
	}
	$all = str_split($all);
	for($i = 0; $i < $length - count($sets); $i++)
		$password .= $all[array_rand($all)];
	$password = str_shuffle($password);
	if(!$add_dashes)
		return $password;
	$dash_len = floor(sqrt($length));
	$dash_str = '';
	while(strlen($password) > $dash_len)
	{
		$dash_str .= substr($password, 0, $dash_len) . '-';
		$password = substr($password, $dash_len);
	}
	$dash_str .= $password;
	return $dash_str;
}




/* creating efile required fucntions*/
function _getUserId($user_name = '')
{
	$CI = &get_instance();
	$s_option = '';
	if(trim($user_name)!='')
    {
        $cond = "WHERE s_username ='".addslashes($user_name)."' ";
        $res= $CI->db->query("select i_id,s_username from {$CI->db->USER} {$cond} ORDER BY s_username");      
        $mix_value = $res->result_array();
        $s_option = $mix_value[0]['i_id'];
    }    
    return $s_option;
    
}


function _getBatchIdCode($batch_id = 0)
{
    if(intval($batch_id) == 0) return '';
    $CI = &get_instance();
    $tmp = $CI->db->select('s_batch_id')->get_where($CI->db->BATCH_MASTER, array('i_id' => $batch_id))->result_array();
    unset($sic);
    return $tmp[0]['s_batch_id'];
}

function _batchStatus($i_status)
{
	$CI = &get_instance();
	$statusArr = $CI->db->BATCH_STATS; // see @database.php
	//pr($statusArr);
	if($i_status>=1)
        return $statusArr[$i_status];
    else
        return false;    
}

function generate_string($string, $length)
{
	if($string == '' || intval($length) == 0)
		return '';
	return str_pad($string,  $length, " ");
}

function add_blank_space($length=0)
{
	if(intval($length) == 0)
		return '';
	$str = '';
	for($i=0; $i<$length; $i++)
	{
		$str.=" ";
	}
	return $str;
}

function pad_blank_space($string,$length=0)
{	
	if(intval($length) == 0)
		return '';
	$diff = $length - strlen($string);
	
	if($diff==0)
		return $string;
	else if($diff>0)
	{
		for($i=0; $i<$diff; $i++)
		{
			$str.=" ";
		}
		//return $str;
		return str_pad($string,  $length, " ");
	}
	else if($diff<0)
	{
		$cut_str = abs($diff);
		$str = substr($string,0,$length);
		return $str;
	}
	else
		return false;
	
}

function addZeroLeft($string,$length=0)
{
	if(intval($length) == 0)
		return '';
	$diff = $length - strlen($string);
	if($diff==0)
		return $string;
	else if($diff>0)
	{
		$str='';
		for($i=0; $i<$diff; $i++)
		{
			$str.="0";
		}
		return $str.$string;
	}
	else if($diff<0)
	{
		$cut_str = abs($diff);
		$str = substr($string,0,$length);
		return $str;
	}
	else
		return false;
}

function addZeroRight($string,$length=0)
{
	if(intval($length) == 0)
		return '';
	$diff = $length - strlen($string);
	if($diff==0)
		return $string;
	else if($diff>0)
	{
		$str='';
		for($i=0; $i<$diff; $i++)
		{
			$str.="0";
		}
		return $string.$str;
	}
	else if($diff<0)
	{
		$cut_str = abs($diff);
		$str = substr($string,0,$length);
		return $str;
	}
	else
		return false;
}


function addZeroLeftPrice($price,$length=0)
{
	if(intval($length) == 0)
		return '';
	$price = str_replace('.','',$price);	
	$diff = $length - strlen($price);
	if($diff==0)
		return $price;
	else if($diff>0)
	{
		$str='';
		for($i=0; $i<$diff; $i++)
		{
			$str.="0";
		}
		return $str.$price;
	}
	else if($diff<0)
	{
		$cut_str = abs($diff);
		$str = substr($price,0,$length);
		return $str;
	}
	else
		return false;
}
