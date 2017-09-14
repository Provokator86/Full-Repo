<?php

/*********
* Author: Mrinmoy Mondal
* Date  : 28 March 2012
* Modified By: Mrinmoy Mondal 
* Modified Date: 31 March 2012
* 
* Purpose:
*  Custom Helpers 
* Includes all necessary files and common functions
* 
*/

/////////Encryption and Decryption////////

/***
* Encryption double ways.
* 
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

/////////end Encryption and Decryption////////


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


/**
 * Agent Base URL *
 * Returns the "agent_base_url" item from your config file
 * @access    public
 * @return    string
 */

if ( ! function_exists('agent_base_url'))
{
    function agent_base_url()
    {
        try
        {
         	$CI =& get_instance();
			return $CI->config->slash_item('agent_base_url');
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    }

}

// ------------------------------------------------------------------------



/**
* Saves the error messages into session.
* @param string $s_msg
* @return void
*/

function set_error_msg($s_msg)
{
    try
    {
        $ret_="";
        if(trim($s_msg)!="")
        {
            $o_ci=&get_instance();
            $ret_=$o_ci->session->userdata('error_msg');
            $ret_.='<div id="err_msg" class="error_massage">'.$s_msg.'</div>';
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
* @param string $s_msg
* @return void
*/

function set_success_msg($s_msg)
{
    try
    {
        $ret_="";
        if(trim($s_msg)!="")
        {
            $o_ci=&get_instance();
            $ret_=$o_ci->session->userdata('success_msg');
            $ret_.='<div class="success_massage">'.$s_msg.'</div>';
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


/*
+-----------------------------------------------+
| Set congfiguration for front end pagination 	|
+-----------------------------------------------+
| Added by Mrinmoy Mondal on 30 April 2012		|
+-----------------------------------------------+
*/
function fe_ajax_pagination($ctrl_path = '',$total_rows = 0, $start, $limit = 0, $paging_div = '')
{
	$CI =   &get_instance();
	$CI->load->library('jquery_pagination');
	
	$config['base_url'] = $ctrl_path;
	$config['total_rows'] = $total_rows;
	$config['per_page'] = $limit;
	$config['cur_page'] = $start;
	$config['uri_segment'] = 0;
	$config['num_links'] = 9;
	$config['page_query_string'] = false;	
	$config['full_tag_open'] = '<ul>';
	$config['full_tag_close'] = '</ul>';	
	$config['prev_link'] = '<';
	$config['next_link'] = '>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li><a class="select">';
	$config['cur_tag_close'] = '</a></li>';

	$config['next_tag_open'] = '<li>';
	$config['next_tag_close'] = '</li>';

	$config['prev_tag_open'] = '<li>';
	$config['prev_tag_close'] = '</li>';
	
	$config['div'] = '#'.$paging_div;
	
	$CI->jquery_pagination->initialize($config);
	return $CI->jquery_pagination->create_links();
}





// Returns well formatted unique CSV string
 function format_csv_string($s_csv = '')
 {
	  if(trim($s_csv) == '') return '';
	 
	 $s_csv = trim($s_csv);
	 $arr_temp = explode(',',$s_csv);
	 $arr_temp = array_filter($arr_temp);
	 $arr_temp = array_unique($arr_temp);
	 
	 $formated_csv = implode(',',$arr_temp);
	 return $formated_csv;
 }



function checkUsername($username)
{
	  if (preg_match('/^([a-zA-Z_#(\\\')]{5})([0-9a-zA-Z_#(\\\')]{1,20})$/', $username)) 
	  {
	   return true;
	  } 
	  else 
	  {
	   return false;
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

function get_file_uploaded(	$s_up_path = '', 

				$s_fld_name = '', 
				$s_file_name = '', 
				$i_max_file_size = '' , 
				$mix_allowed_types = '',  
				$mix_configArr = array())

{

	try
        {
         	$CI = & get_instance();
			$CI->load->library('upload');			

			$i_config_max_file_size = $CI->config->item('admin_file_upload_max_size');
			$s_file_ext	= getExtension(@$_FILES[$s_fld_name]['name']);			

			$mix_config['upload_path'] 	= $s_up_path;
			$mix_config['allowed_types']= (!empty($mix_allowed_types) && !is_numeric($mix_allowed_types))?$mix_allowed_types:'png|jpg|gif';

			$s_filename 		= (!empty($s_file_name))?$s_file_name:getFilenameWithoutExtension(@$_FILES[$s_fld_name]['name']);

			$mix_config['file_name'] = $s_filename.$s_file_ext;

			$mix_config['max_size']	= (!empty($i_max_file_size) && is_numeric($i_max_file_size))?$i_max_file_size:$i_config_max_file_size;

			

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
			$config['master_dim'] 		= 'width';
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



				

/*************Get API SESSION KEY***************/

/**
* Saves the api session key into ci session. And returns the api url
* for global use
* @param void
* @return string of url
*/

function get_api_url()
{

    try
    {
        $ret_="";
        $o_ci=&get_instance();
        $api_url=$o_ci->config->item('api_url');
        $key=$o_ci->session->userdata('api_session');

        if($key=="")
        {
            $content = file_get_contents($o_ci->config->item('api_login_url'));
            preg_match('/PWD=SIT58\|([a-zA-Z0-9]+)&/', $content, $matches);
            $key= $matches[1];            
            $o_ci->session->set_userdata('api_session',$key);
        }

        $ret_=$api_url."&id_visiteur=".$key;

        unset($content,$matches,$key,$api_url);

        return $ret_;

    }

    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }     

}

/*************end Get API SESSION KEY***************/ 

/*This function is to get ascii value corresponding special character for example è =>&egrave;*/
function get_ascii($str = "")
{

$ascii_arr = array("&Agrave;", "&Aacute;", "&Acirc;", "&Atilde;","&Auml;","&Aring;","&AElig;","&Ccedil;","&Egrave;","&Eacute;","&Ecirc;","&Euml;","&Igrave;","&Iacute;","&Icirc;","&Iuml;","&ETH;","&Ntilde;","&Ograve;","&Oacute;","&Ocirc;","&Otilde;","&Ouml;","&times;","&Oslash;","&Ugrave;","&Uacute;","&Ucirc;","&Uuml;","&Yacute;","&THORN;","&szlig;","&agrave;","&aacute;","&acirc;","&atilde;","&auml;","&aring;","&aelig;","&ccedil;","&egrave;","&eacute;","&ecirc;","&euml;","&igrave;","&iacute;","&icirc;","&iuml;","&eth;","&ntilde;","&ograve;","&oacute;","&ocirc;","&otilde;","&ouml;","&divide;","&oslash;","&ugrave;","&uacute;","&ucirc;","&uuml;","&yacute;","&thorn;","&yuml;");

$sp_arr = array("À", "Á", "Â", "Ã", "Ä", "Å", "Æ", "Ç", "È" , "É", "Ê", "Ë", "Ì", "Í", "Î", "Ï", "Ð", "Ñ", "Ò", "Ó",
"Ô", "Õ", "Ö", "×", "Ø", "Ù", "Ú", "Û", "Ü", "Ý", "Þ", "ß", "à", "á", "â", "ã", "ä", "å", "æ", "ç", "è", "é", "ê", "ë",
"ì", "í", "î", "ï", "ð", "ñ","ò", "ó", "ô", "õ", "ö", "÷", "ø", "ù", "ú", "û", "ü", "ý", "þ", "ÿ" );
$str = str_replace( $sp_arr , $ascii_arr, $str );
return $str;
}

function get_seo_url($title='',$ext=".html")
 {
    $_ret =to7bit($title,'utf-8');
	//$_ret = $title ;
	/*$search = array(" ");
	$replace = array("-");
	$_ret    = str_replace($search ,$replace,$_ret).$ext;
	$_ret = strtolower($_ret) ;
	*/
	//$search  = array(" ","æ","à","â","ä","ç","é","è","ê","ë","î","ï","ô","ö","oe","ù","û","ü","&ccedil;");
	//$replace = array("-","ae","a","a","a","c","e","e","e","e","i","i","o","o","oe","u","u","u","x");
    
    $unwanted_array = array(" "=>"-","æ"=>"ae","à"=>"a","â"=>"a","ä"=>"a","ç"=>"c","é"=>"e","è"=>"e","ê"=>"e","ë"=>"e","î"=>"i","ï"=>"i","ô"=>"o","ö"=>"o","oe"=>"oe","ù"=>"u","û"=>"u","ü"=>"u");
	$_ret = strtr(mb_convert_encoding($_ret, 'utf-8', mb_detect_encoding($_ret)),$unwanted_array);
	$_ret = strtolower($_ret).$ext ;
	
	return $_ret;
	
	
 }
 
 
 function to7bit($text,$from_enc) {
    $text = mb_convert_encoding($text,'HTML-ENTITIES',$from_enc);
    $text = preg_replace(
        array('/&szlig;/','/&(..)lig;/',
             '/&([aouAOU])uml;/','/&(.)[^;]*;/'),
        array('ss',"$1","$1".'e',"$1"),
        $text);
		
	 	
    return $text;
}   

/* generate language array for multilingual*/
function genLanguage()
{
    try
	{
		$CI = &get_instance();
		
		$res = $CI->db->query("select i_id, s_language,s_short_name from {$CI->db->LANGUAGE} s_language");	
		$mix_value = $res->result_array();
		$s_array = array();
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_array[$val['s_short_name']] = $val['s_language'];
			}
		}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		//pr($s_array);
		return $s_array;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}



/****
* to generate verification code after registration
*
*/

function genVerificationCode() 
	{
	
		 $CI = & get_instance();
		 $num_length = 10;
		 $char_length = 2;
		 $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		 $characters = '0123456789';
		 $string = ''; 
		 $string1 = '';   
		  for ($p = 0; $p < $char_length; $p++) 
			{
				$string1 .= $char[mt_rand(0, strlen($char))];
			}
		  for ($p = 0; $p < $num_length; $p++)
			 {
				$string .= $characters[mt_rand(0, strlen($characters))];
			 }
		 $final_string = $string1.'-'.$string;
		 $sql = "SELECT * FROM {$CI->db->MST_USER} WHERE s_verification_code='".$final_string."'";
		 $query=$CI->db->query($sql);
		 if($query->num_rows()>0)
			{
				 genVerificationCode();
			}
		 else	
			 return $final_string;
	}




/****
* Function to format input string
*
*****/
function get_formatted_string($str)
{
    try
    {    
		$a_srch = array('<pre>','</pre>');
		$a_rep = array('','');
		$str = str_ireplace($a_srch,$a_rep,$str);
	    //return addslashes(htmlspecialchars(trim($str),ENT_QUOTES));
		return addslashes(htmlentities(trim($str),ENT_QUOTES,'UTF-8'));
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
		$a_srch = array('<pre>','</pre>');
		$a_rep = array('','');
		$str = str_ireplace($a_srch,$a_rep,$str);
	    //return htmlspecialchars_decode(stripslashes(trim($str)));
		return html_entity_decode(stripslashes(trim($str)),ENT_QUOTES, 'UTF-8');
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }         
}


function substr_details($str)
{
	$substr = substr($str,0,300);

	$substr_arr = explode(" ",$str);
	$substring_val = "";
	foreach ($substr_arr as $key=>$value) 
	{
		$substring_val_old = $substring_val;
		$substring_val .= $value." ";
		if (strlen($substring_val) > 300)
		{ 
			$substring_val = $substring_val_old;
			continue;	
		}
	} // end foreach

   return $substring_val;
}


function get_title_string($str)
{
    try
    { 
		//echo $str;
		$new_str = $str;
		$arr_str = explode(" ",$new_str);
		//pr($arr_str);
		//$stack = array("email", "setting");
		
		$res_str_part = $arr_str[0];
		$new_arr = array_slice($arr_str,1);
		 //return ($new_arr);
		$res_str = implode(" ",$new_arr);
		return $res_str_part.' <span>'.$res_str.'</span>';
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }         
}


/*
* Creates the menus and sub menus with respect to access control
* Provided to user type. This echos the formatted menus.
* @returns void
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
*/
function create_sub_menus($parent_id,$i_mnu_id,$i_layer=0)
{
    try
    {
        	$s_ret_="";
       
			$CI =& get_instance();			
			$admin_loggedin = $CI->session->userdata("admin_loggedin");
			$CI->load->model('menu_model');
			$s_wh_cl = " WHERE i_parent_id = {$parent_id} ";  
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

/* sub menus at layer 2 */
function create_sub_menus2($parent_id,$i_main_menu,$i_sub_menu)
{
    try
    {
        	$s_ret_="";
			$CI =& get_instance();
			$admin_loggedin = $CI->session->userdata("admin_loggedin");
			$CI->load->model('menu_model');
			$s_wh_cl = " WHERE i_parent_id = {$parent_id} ";  
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
            ///////////end Sub sub menu exists i.e layer 2///////
            unset($con,$mnus,$s_link,$admin_loggedin);
       ///end if
	   return ($s_ret_!=""?'<ul class="sub2">'.$s_ret_.'</ul>':'');
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}


/* return string which end with a full letter */
function string_part($str,$limit=20)
{
	//$limit=20;
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

/**
* This function returns the time ago or passed
*
* @author koushik 
* @param int $assign_time
* @param int $current_time
* @return string
*/
function time_ago($assign_time,$current_time='')
{
        try
        {
            if($current_time=='')
            {
                $current_time   =   time();
            }

            $str_left_time      =   '';
            $i_one_month_diff   =   time()-strtotime('-1 month');
            $i_left_time    =   $current_time-$assign_time ;

                if($i_left_time<60)
                {
                    $str_left_time  =    ($i_left_time<=1 )?'a second ago':$i_left_time.' seconds ago' ;                   
                }
                else if($i_left_time<3600)
                {
                    $i_time         =    floor($i_left_time/60) ;
                    $str_left_time  =    ($i_time==1)?'a minute ago':$i_time.' minutes ago' ;
                }
                else if($i_left_time<86400)
                {
                    $i_time         =    floor($i_left_time/3600) ;
                    $str_left_time  =    ($i_time==1)?'about an hour ago':$i_time.' hours ago' ;    
                }
                else if($i_left_time < $i_one_month_diff)
                {
                    $i_time         =    floor($i_left_time/86400) ;
                    $str_left_time  =    ($i_time==1)?' Yesterday':$i_time.' days ago' ;
                }
                else
                {
                    $str_left_time  =    date('d-m-Y',$assign_time);
                }
            return $str_left_time ;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
}

/**
* This function returns the time left or passed
*
* @author mrinmoy 
* @param int $assign_time
* @param int $current_time
* @return string
*/
function job_time_left($assign_time,$current_time='')
{
        try
        {
            if($current_time=='')
            {
                $current_time   =   time();
            }

            $str_left_time      =   '';
            $i_one_month_diff   =   time()-strtotime('-1 month');
            $i_left_time    =   abs($current_time-$assign_time) ;
			
				if($i_left_time < $i_one_month_diff)
                {
                    $i_time         =    floor($i_left_time/86400) ;
					if($i_time==0)
					{
					$str_left_time = 'Today';
					}
					else
					{
                    $str_left_time  =    ($i_time==1)?' Yesterday':$i_time.' days ago' ;
					}
                }
                
            return $str_left_time ;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
}


/////////////sh ajax Jason for any array to use into JS//////////
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
/////////////sh ajax Jason for any array to use into JS//////////


	
######################################### following functions created by iman #####################################

function upload_file($obj, $arr , $filename)
{

	$obj->load->library('upload');
	$obj->upload->initialize($arr);
	//echo $filename;
	/*$config['upload_path'] = $arr['upload_path'];
	$config['file_name'] = $arr['file_name'];
	$config['allowed_types'] = $arr['allowed_types'];
	$config['max_size']	= $arr['max_size'];
	$config['max_width']  = $arr['max_width'];
	$config['max_height']  = $arr['max_height'];	
	
	$obj->load->library('upload', $config);*/
	$upload = $obj->upload->do_upload($filename);
	
//	$obj->upload->clear();
	$retArr='';
    if($upload)
		$retArr=$obj->upload->data();
	else
		$retArr=$obj->upload->display_errors('','|');
	
		
	return $retArr;
}

function create_thumb($obj, $arr)
{
	$obj->load->library('image_lib');
	$obj->image_lib->initialize($arr);
	$return = $obj->image_lib->resize();
	$obj->image_lib->clear();
	return 	$return;
}

/* used in tradesman feedback and admin manage feedback */

function show_star($star=1)
	{
	$star;
	list($int, $parse) = explode('[.]', $star);
	$int;
	$parse;
	for ($i = 1; $i <= $int; $i++) 
	{
		$star_view .= "<img src=\"images/fe/blue-star.png\">";
	}
	if($parse==5)
		{
		$star_view .= "<img src=\"images/fe/half-star.png\">";
		$dim_star = 4-$int;
		}
	else{
		$star_view .= "";
		$dim_star = 5-$int;}
	$dim_star;
	if($dim_star!="")
	{
	for ($i = 1; $i <= $dim_star; $i++) 
	{
		$star_view .= "<img src=\"images/fe/gry-star.png\">";
	}
	}
	return $star_view;
	}


function replaceHash_new($reg_exp, $replace_with, $replace_on)
{
	$replace_on		=	preg_replace($reg_exp, $replace_with, $replace_on);
	return $replace_on;
}


function escape_singlequotes($str) {
 $chars= array("'", "&#039;");
 foreach($chars as $char) {
  switch ($char) {
   case "'":
    $str = str_replace($char, "\'", $str);
    break;
   case "\"":
    $str = str_replace($char, "\\\"", $str);
    break;
   case "&#039;":
    $str = str_replace($char, "\&#039;", $str);
    break;
   case "&quot;":
    $str = str_replace($char, "\&quot;", $str);
    break;
  }
 }

 return $str;
}




/**
* This function calculate the timestamp
* 
* For project hizmetuzmani by koushik
* 
* @param int $i_date
* @param int $i_days
* @return unix timestamp of expire date
*/
function calculate_expire_date($i_date='',$i_days='')
{
    try
    {
        return  $i_date + (strtotime('+'.$i_days.' days')-strtotime('now')) ;
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}
  
  

function convert_number($num) 
{
    $ones = array(
        1 => "one",
        2 => "two",
        3 => "three",
        4 => "four",
        5 => "five",
        6 => "six",
        7 => "seven",
        8 => "eight",
        9 => "nine",
        10 => "ten",
        11 => "eleven",
        12 => "twelve",
        13 => "thirteen",
        14 => "fourteen",
        15 => "fifteen",
        16 => "sixteen",
        17 => "seventeen",
        18 => "eighteen",
        19 => "nineteen"
        );
    $tens = array(
        2 => "twenty",
        3 => "thirty",
        4 => "forty",
        5 => "fifty",
        6 => "sixty",
        7 => "seventy",
        8 => "eighty",
        9 => "ninety"
    );
    $hundreds = array(
        "hundred",
        "thousand",
        "million",
        "billion",
        "trillion",
        "quadrillion"
    );
    
    $num = number_format($num,2,".",",");
    $num_arr = explode(".",$num);
    $wholenum = $num_arr[0];
    $decnum = $num_arr[1];
    $whole_arr = array_reverse(explode(",",$wholenum));
    krsort($whole_arr);
    $rettxt = "";
    foreach($whole_arr as $key => $i){
        if($i < 20){
            $rettxt .= $ones[$i];
        }elseif($i < 100){
            $rettxt .= $tens[substr($i,0,1)];
            $rettxt .= " ".$ones[substr($i,1,1)];
        }else{
            $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0];
            $rettxt .= " ".$tens[substr($i,1,1)];
            $rettxt .= " ".$ones[substr($i,2,1)];
        }
        if($key > 0){
            $rettxt .= " ".$hundreds[$key]." ";
        }
    }
    if($decnum > 0){
    $rettxt = ($rettxt)? $rettxt." Pound(s) & " : $rettxt;
        if($decnum < 20){
            $rettxt .= $ones[$decnum];
        }elseif($decnum < 100){
            $rettxt .= $tens[substr($decnum,0,1)];
            $rettxt .= " ".$ones[substr($decnum,1,1)];
        }
        $rettxt .= " Pence";
    }
    else
     $rettxt .= " Pound(s) & ";

    return $rettxt;
}


/**
* This function is image src if image not available it return not avalable image
* 
* @author Koushik Rout
* @access public  
* @param string $image_path              
* @param string $file_name
* @param string $default_image // should be store in default folder
* @param int $width
* @param int $height
* @return string img file
*/

function showThumbImageDefault($image_catagory,$file_name,$default_image='no_image.jpg',$width=110,$height=110,$extra_class='')
{
	try
	{
		$OBJ_CI = & get_instance();
		$thumbDisplayPath=$OBJ_CI->config->item($image_catagory.'_image_thumb_path');
		if($file_name=="")
		{
			return '<img src="uploaded/default/'.$default_image.'" width="'.$width.'" height="'.$height.'" class="'.$extra_class.'" alt="image not available">';    
		}
		else
		{
			
			if(file_exists($OBJ_CI->config->item($image_catagory.'_image_thumb_upload_path').'thumb_'.$file_name))
			//if(file_exists('./uploaded/question/thumb/thumb_'.$file_name))
			{
				return '<img src="'.$thumbDisplayPath.'thumb_'.$file_name.'" width="'.$width.'" height="'.$height.'" class="'.$extra_class.'" >';    
			}
			else
			{
				
				return '<img src="uploaded/default/'.$default_image.'" width="'.$width.'" height="'.$height.'" class="'.$extra_class.'" alt="image not available">';    
			}    
		}
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
} //End of showThumbImage
    
    function convert_date_mdy_format($s_date)
    {
    try
    {
        list($d,$m,$y)=explode('/',$s_date);
        unset($s_date) ;
        return strtotime($m.'/'.$d.'/'.$y) ;

    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }


}

/**
* This function use for creating seo friendly url
* this url contain no _ and any other special char just url contain (-)
* @author Koushik 
* 
* @param string $s_string
* @return string
*/
function make_my_url($s_string='')
{
    try
        {
           
            if($s_string=='')
            {
                return false ;
            }
           
            $mix_matches = array();
            preg_match('/(.+?)(\.[^.]*$|$)/', trim($s_string), $mix_matches);
            unset($s_filename);
           
            $entities = array(" ",".","~","!", "*", "'","_", "(", ")", ";", ":", "@","&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
            $s_new_filename = str_replace($entities,"-",$mix_matches[1]);
            
            $s_new_filename = preg_replace('/[-]{2,}/','-',$s_new_filename);
              
            return mb_strtolower(trim($s_new_filename,'-'),'UTF-8');
            //return (trim($s_new_filename,'-'));
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
}

/**
* This function is to replace some special turkish charecter
* make url  soported by all the browser..
* 
* @project hizmetuzmani
* @author Koushik
* 
* @param string $s_string
*/
function replace_turkish_char($s_string='')
{
    try
    {
        if($s_string!='')
        {
            $tarkish_char_replace   =   array(
                                            'Ş'=>'S',
                                            'ş'=>'s',
                                            'Ğ'=>'G',
                                            'Ü'=>'U',
                                            'İ'=>'I',
                                            'i'=>'i',
                                            'I'=>'I',
                                            'ı'=>'i',
                                            'Ö'=>'O',
                                            'ö'=>'o',
                                            'Ç'=>'C',
                                            'ç'=>'c',
                                            'ü'=>'u'
                                            );
            foreach($tarkish_char_replace as $key=>$value)
            {
                 $s_string      =      str_replace($key,$value,$s_string);
            }  
         
        }
        return $s_string ;
        
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}  