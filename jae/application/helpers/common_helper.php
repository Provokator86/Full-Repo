<?php

/*********
* Author: SWI
* Date  : 11 sept 2017
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


function  _numeric($price = '0', $str = '', $lt = 0)
{
    if($price == '') return $str? $str : '0';
    else return number_format($price, $lt,'.',',');
}

// get total question for an examination
function _total_question($examId)
{
    $CI = &get_instance();
    if($examId>0)
    {
        $cond = "WHERE i_exam_id='".$examId."' ";
        $res = $CI->db->query("SELECT COUNT(i_id) AS total FROM {$CI->db->EXAM_QUESTION_ANSWER} {$cond} ");      
        
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            $s_option = $mix_value[0]['total'];
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
