<?php

/*********
* Author: Mrinmoy Mondal
* Date  : 18 Jan 2013
* Modified By:  
* Modified Date: 
* Purpose:
*  Custom Helpers 
* Includes all necessary files and common functions
*/

/////////Encryption and Decryption////////

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

function select_chain_category_ids($cat_id=0) 
{	
	$CI = & get_instance();
	$sql = "SELECT i_id FROM cd_category WHERE i_parent_id = '".$cat_id."' ";	
	$rs  = $CI->db->query($sql);
	$sttr = "";
	if($rs->num_rows()>0)
	{
	  foreach($rs->result() as $row)
	  {
			$sttr = $sttr.','.select_chain_category_ids($row->i_id);				
	  }
	  
	}
	else
	{
		return $cat_id;
	}
	
	return $cat_id.$sttr;
}


/* function for fetch all parent category and insert corresponding
* into matrix cashback_matrix tables
* ex. 
*/
function insert_matrix_wrt_category() 
{	
	$CI = & get_instance();
	$sql = "SELECT i_id FROM cd_category WHERE i_parent_id = 0 ";	
	$rs  = $CI->db->query($sql);	
	$res = $rs->result_array();
	/*echo '<pre>';
	print_r($res);*/	
	if($rs->num_rows()>0)
	{
	  foreach($res as $val)
	  {			
			$sql2 = "SELECT i_id FROM cd_cashback_matrix WHERE i_cat_id = '".$val["i_id"]."' ";	
			$rs2  = $CI->db->query($sql2);	
			if($rs2->num_rows()>0){}else{
				$info = array();
				$info["i_cat_id"] 	= 	$val["i_id"];
				$info["dt_time"]	=	date('Y-m-d H:i:s');
				
				$i_ins = $CI->db->insert('cd_cashback_matrix', $info);
			}	
	  }
	  
	}	
	return true;
}

/* function to generate random string
* ex. $s_format = uploaded/book_page_template/s%.png
*/
function generate_random_string($i_id,$s_table,$s_column,$s_format)
{
	$CI = & get_instance();	
	
	
	while(true)
	{
		$s_rand = time().'_'.rand('111','999');
		$val = sprintf($s_format,$s_rand);	
		$s_qry = " UPDATE ".$s_table." SET ".$s_column." = '".my_receive_text($val)."' WHERE i_id='".my_receive_text($i_id)."'";
		
		if($CI->db->query($s_qry))
			break;
		sleep(100);
		
	}
	
	return $val;
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

/****
* Function to compare string
*
*****/
function my_receive_text($str)
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
function my_show_text($str)
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

function watermark_text_image_file($source_image,$text,$font_size='16',$font_color='ffffff',$vrt_alignment='top',$hor_alignment='right',$padding='20')
{
	$CI = & get_instance();
	$CI->load->library('image_lib');

	$config['image_library'] 	= 'gd2';

	$config['source_image'] = $source_image;
	$config['new_image'] = $source_image;
	$config['dynamic_output'] = FALSE;
	//$config['quality'] = '100%';
	
	
	
	$config['wm_text'] = $text;
	$config['wm_type'] = 'text';
	$config['wm_font_path'] = BASEPATH.'fonts/helveti2.ttf';

	$config['wm_font_size'] = $font_size;
	$config['wm_font_color'] = $font_color;
	$config['wm_vrt_alignment'] = $vrt_alignment;
	$config['wm_hor_alignment'] = $hor_alignment;
    $config['wm_padding'] = $padding;
    //$config['wm_shadow_color'] = 'cccccc';
	//$config['wm_shadow_distance'] = 5;
	
	$CI->image_lib->clear();
	
	$CI->image_lib->initialize($config);
	
	if(!$CI->image_lib->watermark())
	{
		echo $CI->image_lib->display_errors('<p>', '</p>');
		return false;
	}
	
	return true;
}


/**
* For image thumbnailing
* @param string $s_img_path, $s_new_path, $s_file_name
* @param int $i_new_height, $i_new_width 
* @param mix $configArr
* @return string
*/



function upload_image_file($s_img_path = '',$s_new_path = '',	$s_file_name = '', $i_new_height = '', $i_new_width = '',$mix_configArr = array())

{
	try
        {

			$CI = & get_instance();
			$CI->load->library('image_lib');
			$i_new_height = (!empty($i_new_height))?$i_new_height:768;
			$i_new_width  = (!empty($i_new_width))?$i_new_width:1024;		

			$config['image_library'] 	= 'gd2';
			$config['source_image']  	= $s_img_path;  // $_FILES['f_image']['tmp_name']
			//$config['create_thumb']  	= TRUE;
			$config['maintain_ratio'] 	= TRUE;
		    $config['canvas_color'] 	= array('red'=>255,'green'=>255,'blue'=>255);
		    //$config['do_not_upsize'] 	= "false";
		    $config['master_dim'] 		= "auto";
			$config['width'] 			= $i_new_width;
			$config['height'] 			= $i_new_height;
			$config['thumb_marker'] 	= '';
			$config['new_image'] 		= $s_new_path.$s_file_name;		// upload_path.upload_file_name	

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


function delete_images_from_system($arr_name,$s_image_name = '')
{
	try
        {
			$conf = &get_config();
			//pr($conf);
			$image_arr	=	$conf[''.$arr_name.''];
			foreach($image_arr as $key=>$val)
			{								
				$ThumbDir			= $val['upload_path'];	
				if($key!='general')
				{			
					$s_name = $s_image_name.'_'.$key.'.jpg';
					if(file_exists($ThumbDir.$s_name))
					{
						 @unlink($ThumbDir.$s_name);						
					}				
				}
				else
				{
					$s_name = $s_image_name.'.jpg';
					if(file_exists($ThumbDir.$s_name))
					{
						 @unlink($ThumbDir.$s_name);						
					}
				}
				
			}     
			
			return true;
			
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
	$config['num_links'] = 4;
	$config['page_query_string'] = false;	
	$config['full_tag_open'] = '<ul>';
	$config['full_tag_close'] = '</ul>';	
	$config['prev_link'] = '&laquo;';
	$config['next_link'] = '&raquo;';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li><a class="select"><b>';
	$config['cur_tag_close'] = '</b></a></li>';

	$config['next_tag_open'] = '<li>';
	$config['next_tag_close'] = '</li>';

	$config['prev_tag_open'] = '<li>';
	$config['prev_tag_close'] = '</li>';

	$config['first_tag_open'] = '<li>';
	$config['first_tag_close'] = '</li>';
	
	$config['last_tag_open'] = '<li>';
	$config['last_tag_close'] = '</li>';

		
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
 
 /* param @ timestamp of a date
 * return total days of a month
 * and first day of the month (start from monday)  
 * 1->Mon,2->Tue,....6->Sat,0->Sun
 */
 function get_first_day($month,$year)
 {
     try
     {
         $first_day     = mktime(0,0,0,$month, 1, $year) ;
         return date('w',$first_day) ;
     }
      catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
 	
	
 }
 
 function get_total_days_in_month($month,$year)
 {
     try
     {
         $total_day     = date('t', mktime(0,0,0,$month,1,$year));
         return $total_day ;
         
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

			$s_filename 			= (!empty($s_file_name))?$s_file_name:getFilenameWithoutExtension(@$_FILES[$s_fld_name]['name']);
			$mix_config['file_name']= $s_filename.$s_file_ext;
			//$mix_config['file_name']= $s_filename;
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

			$config['image_library']  = 'gd2';
			$config['source_image']  = $s_img_path;
			$config['create_thumb']  = TRUE;
			$config['maintain_ratio']  = TRUE;
			$config['width']   = $i_new_width;
			$config['height']    = $i_new_height;
			//$config['master_dim']  = 'height';
			$config['canvas_color']  = array('red'=>255,'green'=>255,'blue'=>255); // fill canvas with white color;
			$config['thumb_marker']  = '';
			$config['new_image']   = $s_new_path.$s_file_name;		

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
            // Changes made by koushik 27 april
            $s_wh_cl = " WHERE i_parent_id = {$parent_id} AND i_main_id!=-99";  
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


	/*======================= END CREATE MENUS AND SUB-MENUS =======================*/

/* return string which end with a full letter */


function string_part($text, $limit=20)
{
    if($text == '')
  return '';
 $text = trim(strip_tags($text));
 if(strlen($text) <= $limit)
 {
  return $text;
 }
 $n_text =  explode(' ', substr($text, 0, $limit));
 if(count($n_text) > 1)
 {
  array_pop($n_text);
  $f_text = implode(' ', $n_text).' ...';
 }
 else
 {
  $f_text = implode(' ',$n_text);
 }
 return $f_text;
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

function showThumbImageDefault($image_catagory,$file_name,$image_type='general',$width=110,$height=110,$default_image='no_image.jpg',$extra_class='')
{
	try
	{
		$OBJ_CI = & get_instance();
		$arr_image_detail   =   $OBJ_CI->config->item($image_catagory);
        
		if($file_name=="")
		{
			return '<img src="uploaded/default/'.$default_image.'" width="'.$width.'" height="'.$height.'" class="'.$extra_class.'" alt="image not available">';    
		}
		else
		{
            $file_name  =   getFilenameWithoutExtension($file_name).'_'.$image_type.'.jpg';
			
			if(file_exists($arr_image_detail[$image_type]['upload_path'].$file_name))
			//if(file_exists('./uploaded/question/thumb/thumb_'.$file_name))
			{
                if($extra_class)
                {
                    
                    return '<img src="'.$arr_image_detail[$image_type]['display_path'].$file_name.'" width="'.$width.'" height="'.$height.'" class="'.$extra_class.'" >';    
                }
                else
                {
                    return '<img src="'.$arr_image_detail[$image_type]['display_path'].$file_name.'" width="'.$width.'" height="'.$height.'" >';    
                    
                }
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
} 

function my_receive_like($value)
{
	 $CI = get_instance();
	 return $CI->db->escape_like_str($value);
}

function my_receive($value)
{
    $CI = get_instance();
     return $CI->db->escape_str(trim($value));
}
function my_showtext($value)
{
     return htmlspecialchars($value);
}

function now()
{
	 $CI = &get_instance();
	 $CI->load->model('site_setting_model');
	 return $CI->site_setting_model->get_current_date_and_time();
}


function exclusive_strip_tags_more_view($str,$char=150)
{
	$str = strip_tags($str);
	return substr(preg_replace('/[\s]{2,}/', ' ', $str), 0, $char)."..."; 
}


function exclusive_strip_tags($str)
{
	  $str = strip_tags($str);
	  return preg_replace('/[\s]{2,}/', ' ', $str); 
}
 
 
function my_render($str)
{
    try
    {    
        return htmlspecialchars_decode(stripslashes(trim($str)));
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }         
}

/*
* @param $s_cond like => "WHERE i_id=1 AND s_uid='ABSC' "
*/
function getUserRefIdByCondn($s_cond = '')
{
    try
	{
		$CI = &get_instance();
		$res = $CI->db->query("SELECT s_referrer_id FROM cd_user {$s_cond} ");
		$mix_value = $res->result_array();
		$s_name = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_name = $val["s_referrer_id"];
			}
		}
		unset($res, $mix_value, $s_id);
		return $s_name;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
} 

/*
* @param $s_cond like => "WHERE i_id=1 AND s_uid='ABSC' "
*/

function getUserUid($s_uid = '')
{
    try
	{
		$CI = &get_instance();
		$res = $CI->db->query("SELECT s_uid FROM cd_user WHERE s_uid='".$s_uid."' ");
		$mix_value = $res->result_array();
		$s_name = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_name = $val["s_uid"];
			}
		}
		unset($res, $mix_value, $s_id);
		return $s_name;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}


function getUserIdByCondn($s_cond = '')
{
    try
	{
		$CI = &get_instance();
		$res = $CI->db->query("SELECT i_id FROM cd_user {$s_cond} ");
		$mix_value = $res->result_array();
		$s_name = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_name = $val["i_id"];
			}
		}
		unset($res, $mix_value, $s_id);
		return $s_name;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
} 

function getStoreTitles($s_id = '')
{
    try
	{
		$CI = &get_instance();
		$res = $CI->db->query("select i_id, s_store_title from {$CI->db->STORE} WHERE i_id = {$s_id} ");
		$mix_value = $res->result_array();
		$s_name = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_name = $val["s_store_title"];
			}
		}
		unset($res, $mix_value, $s_id);
		return $s_name;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}

} 

function getStoreTrackingParam($s_id = '')
{
    try
	{
		$CI = &get_instance();
		$res = $CI->db->query("select i_id, user_tracking_parameter from {$CI->db->STORE} WHERE i_id = {$s_id} ");
		$mix_value = $res->result_array();
		$s_name = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_name = $val["user_tracking_parameter"];
			}
		}
		unset($res, $mix_value, $s_id);
		return $s_name;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}

} 

function getSeoUrl($table,$url,$id='',$i=0)
{
	 $CI = &get_instance();
	
	 $ret = $url;
	 $furl = $url;
	
	 /* $splsearch = array(",",".","@","~","`","!","%","$","#","&","*","(",")",":",";"," ","'","Æ","Ø","Å","æ","Ã†","Ã¦");
	  $splreplace = array("","","","","","","","","","","","","","","","-","","ae","oe","aa","ae","ae","ae");
	
	  $furl 	= str_replace($splsearch,$splreplace,$furl); 
	  $furl		= strtolower(preg_replace('/\-+/', '-', $furl));*/
	  
	  $splsearch = array(",",".","@","~","`","!","%","$","#","&","*","(",")",":",";"," ","'","Æ","Ø","Å","æ","Ã†","Ã¦","/","deals","deal", "^"," ",".","~","!", "*", "'","_", "(", ")", ";", ":", "@","&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]","%");
	  $splreplace = array("","","","","","","","","","","","","","","","-","","ae","oe","aa","ae","ae","ae","","deals-detail","deal-details", "","","","","", "", "","", "", "", "", "","", "", "", "plus", "", "", "", "", "", "","");
	
	
	  $furl 	= str_replace($splsearch,$splreplace,$furl); 
	  $furl		= strtolower(preg_replace('/\-+/', '-', $furl));	  
  	  $furl 	= preg_replace('/[-]{2,}/','-',$furl);
	 
	if($i != 0)
	   $furl = $furl."-".$i;
	
	$where	= " WHERE s_url	='$furl'";
		 
	 if($id!='')
	 {	
		 $decrypt_id	= decrypt($id);
		 $where	.= " AND i_id <>'$decrypt_id'";
	 }
	 
	 $sql	= "SELECT * FROM $table $where";
	 
	 $res = $CI->db->query($sql);
	
	 if($res->num_rows()>0)
	 {	 	
		  $j = $i+1;
		  $ret = getSeoUrl($table,$url,$id,$j);		  
	 }
	 else
	 {		 		
	  	return $furl;
	 }
	
	 return $ret;
}



function getSeoUrl_for_coupon($table,$url,$id='',$i=0)
{
	 $CI = &get_instance();
	
	 $ret = $url;
	 $furl = $url;
	 
	   /*$splsearch = array(",",".","@","~","`","!","%","$","#","&","*","(",")",":",";"," ","'","Æ","Ø","Å","æ","Ã†","Ã¦","/","deals","deal");
	  $splreplace = array("","","","","","","","","","","","","","","","-","","ae","oe","aa","ae","ae","ae","","deals-detail","deal-details");*/
	
	  $splsearch = array(",",".","@","~","`","!","%","$","#","&","*","(",")",":",";"," ","'","Æ","Ø","Å","æ","Ã†","Ã¦","/","deals","deal", "^"," ",".","~","!", "*", "'","_", "(", ")", ";", ":", "@","&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]","%");
	  $splreplace = array("","","","","","","","","","","","","","","","-","","ae","oe","aa","ae","ae","ae","","deals-detail","deal-details", "","","","","", "", "","", "", "", "", "","", "", "", "plus", "", "", "", "", "", "","");
	
	
	  $furl 	= str_replace($splsearch,$splreplace,$furl); 
	  $furl		= strtolower(preg_replace('/\-+/', '-', $furl));	  
  	  $furl 	= preg_replace('/[-]{2,}/','-',$furl);
	 
	if($i != 0)
	   $furl = $furl."-".$i;
	
	$where	= " WHERE s_seo_url	='$furl'";
		 
	 if($id!='')
	 {	
		 $decrypt_id	= decrypt($id);
		 $where	.= " AND i_id <>'$decrypt_id'";
	 }
	 
	 $sql	= "SELECT * FROM $table $where";
	 
	 $res = $CI->db->query($sql);
	
	 if($res->num_rows()>0)
	 {	 	
		  $j = $i+1;
		  $ret = getSeoUrl_for_coupon($table,$url,$id,$j);		  
	 }
	 else
	 {		 		
	  	return $furl;
	 }
	
	 return $ret;
}





//End of showThumbImage
    
//------------------------for url----------------------------------------//

			function make_valid_url($url = '')
			{ //echo $str;
			 if($url == '') return 'javascript:void(0)';
			 return preg_match("/http/", $url) ?  $url : 'http://'.$url;
			}
//------------------------for url----------------------------------------//		
		
	