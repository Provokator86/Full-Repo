<?php

/*********

* Author: Sahinul Haque

* Date  : 08 Nov 2010

* Modified By: Jagannath Samanta 

* Modified Date: 27 June 2011

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

 * Admin Base URL

 *

 * Returns the "admin_base_url" item from your config file

 *

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

 * Agent Base URL

 *

 * Returns the "agent_base_url" item from your config file

 *

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

* 

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

* 

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



/*****************************************************************************************************

	Added By Arnab Chattopadhyay

******************************************************************************************************/



/**

* Displays the pre-formatted array 

* 

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

* 

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



function checkUsername($username){
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

* 

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

* 

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

function getFilenameWithoutExtension($s_filename = '')

{

	try

        {

         	if(empty($s_filename))

			return FALSE;

			$mix_matches = array();

			preg_match('/(.+?)(\.[^.]*$|$)/', $s_filename, $mix_matches);

			unset($s_filename);
			$s_new_filename = str_replace(" ","_",$mix_matches[1]).'_'.time();
			return strtolower($s_new_filename);
			 
        }

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }

}



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

* 

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

			$i_new_width = (!empty($i_new_width))?$i_new_width:$CI->config->item('admin_image_upload_thumb_width');

		

			$config['image_library'] = 'gd2';

			$config['source_image'] = $s_img_path;

			$config['create_thumb'] = TRUE;

			$config['maintain_ratio'] = FALSE;

			$config['width'] = $i_new_width;

			$config['height'] = $i_new_height;

			$config['master_dim'] = 'width';

			$config['thumb_marker'] = '';

			$config['new_image'] = $s_new_path.$s_file_name;

			

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

* 

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
					 $sql = "SELECT * FROM quoteurjob_user WHERE s_verification_code='".$final_string."'";
					 $query=$CI->db->query($sql);
					 if($query->num_rows()>0)
						{
							 genVerificationCode();
						}
					 else	
						 return $final_string;
				}


function get_banner1($ctrlr)
{
	try
	{
		switch($ctrlr)
		{
			case 'employee_helpdesk':
				?>
					<div class="banner">
						<div class="banner_left"><img alt="" src="images/fe/banner.jpg"></div>
							<div class="banner_right">
							<h4>People are our</h4><h2> greatest asset</h2>
						   </div>
						   <div class="clear"></div>
					  </div>
				<?php
			break;
			case 'idea_factory':
				?>
					<div class="banner">
						<div class="banner_left"><img alt="" src="images/fe/banner.jpg"></div>
							<div class="banner_right">
							<h4>People are our</h4><h2> greatest asset</h2>
						   </div>
						   <div class="clear"></div>
					  </div>
				<?php
			break;
			default:
				$CI = & get_instance();
				$CI->load->model("banner_model","mod_banner");				
				$banner_info	= $CI->mod_banner->fetch_multi($s_where,intval($start),$limit);
				$total_rows=count($banner_info);
				if($total_rows > 0)
				{
					$DisplayPath = $CI->config->item('banner_image_path');	//for display banner image 
					?>
					<!--BANNER SECTION-->
					<div id="myBanner">
					<?php 
					for($i=0; $i<$total_rows; $i++)
            		{
						
						$banner_image = $DisplayPath.$banner_info[$i]["s_banner_file"];
						$s_slogan_code = $banner_info[$i]["s_slogan_code"];
						$s_slogan_bg_code = $banner_info[$i]["s_slogan_bg_code"];
						$s_slogan = $banner_info[$i]["s_slogan"];
						$s_slogan_next = $banner_info[$i]["s_slogan_next"];
						?>
						  <div class="scrollEl" id="myBanner<?php echo $i?>">
							<div class="banner_left"><img src="<?php echo $banner_image?>" alt="" /></div>
							<div class="banner_right" style="background-color:#<?php echo $s_slogan_bg_code?>">
								<h4 style="color:#<?php echo $s_slogan_code?>"><?php echo $s_slogan?></h4>
								<h2 style="color:#<?php echo $s_slogan_code?>"><?php echo $s_slogan_next?></h2>
							</div>
						  </div>
						<?php  
					}
					?>
					</div>
					<script language="javascript">
					 var total_banner = <?php echo $total_rows;?>;
					 var i =0;
					 var fade_time = 1000;
					 $(function(){$("#myBanner0").css('display','block');bannerEffect();});
					 function bannerEffect()
					 {
					 	$('#myBanner'+i).fadeOut(fade_time,
							function()
							{
								if(i==total_banner)i=0;
								$('#myBanner'+ (++i)).fadeIn(fade_time);
								setInterval('bannerEffect',4000)
							});
					 }
					</script>
					<!--BANNER SECTION END-->
					<?php
				}
				unset($CI,$info);
			break;
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
		$a_srch = array('<pre>','</pre>');
		$a_rep = array('','');
		$str = str_ireplace($a_srch,$a_rep,$str);
	    //return addslashes(htmlspecialchars(trim($str),ENT_QUOTES,'UTF-8'));
		return addslashes(htmlentities(trim($str),ENT_QUOTES,'UTF-8'));
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
	foreach ($substr_arr as $key=>$value) {
	$substring_val_old = $substring_val;
	$substring_val .= $value." ";
	if (strlen($substring_val) > 300){ 
	$substring_val = $substring_val_old;
		continue;
	
	}
	

}

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

/*function mb_explode($separator, $string)
{	
	$sepEnc = mb_detect_encoding($separator, "ISO-8859-1, UTF-8");
	$strEnc = mb_detect_encoding($string, "ISO-8859-1, UTF-8");

	if ($strEnc != $sepEnc) {
		$separator = convert($separator, $sepEnc, $strEnc);
	}
	return explode($separator, $string);
}

function convert($str, $from = "UTF-8", $to = "ISO-8859-1")
{
	return mb_convert_encoding($str, $to, $from);
}*/
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
	    return stripslashes(trim($str));
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }         
}

/*
* Creates the menus and sub menus with respect to access control
* Provided to user type. This echos the formatted menus.
* 
* @param $controllers is array of controllers
* @returns void
*/
function create_menus($controllers)
{
    try
    {
        $i_count_menus=0;
        $i_menus_counter=0;
        $i_mnu_id=0;
        $tmp_mnu_id=0;
        $s_top_menu="";
        $s_str="";
        $i_submnu_id=0;
        $s_active="";
        $s_link="";
        ///////menus @layer 2////
        $i_sub_submnu_id=0;
        $s_sub_menu="";
        $s_mnu_layer2="";
        
        //$CI = & get_instance();
        //$controllers=$CI->db->CONTROLLER_NAME;
        //////////Displaying Menus and Sub menus///////
        if(is_array($controllers))
        {
            $i_count_menus=count($controllers);
            foreach($controllers as $k=>$menus)
            {
                   
                   if($s_top_menu!=$menus["top_menu"] && trim($menus["top_menu"])!="")
                   {
                       /*////////Last element of the Sub Sub Menus at layer2//////////
                       if($s_mnu_layer2!="")
                       {
                           $s_str.= '<ul class="sub2">'.$s_mnu_layer2.'</ul>';//opening layer2
                           $s_str.= '</li>';///closing the previously opened sub_menu layer 1
                       }
                       elseif($i_submnu_id>0)
                       {
                           echo $i_submnu_id;
                           $s_str.= "</li>##";///closing the previously opened sub_menu layer 1
                       }                       
                       /////////end Last element of the Sub Sub Menus at layer2/////////*/
                       
                       /////For Layer 1 and 0/////
                       $tmp_mnu_id=$i_mnu_id;
                       if($tmp_mnu_id!=0)
                       {
                           $s_str.= "</ul></li>";///closing the previously opened submenu and top menu
                           $s_active="";
                       }
                       else
                       {
                           $s_active='class="active"';///
                       }
                       /////end For Layer 1 and 0/////
                       ///////opening the top menu /////
                       $s_str.=  '<li class="line"><a id="mnu_'.$tmp_mnu_id.'" href="javascript:void(0);" '.$s_active.'><b>'.$menus["top_menu"].'</b></a>';
                       $s_str.= '<ul class="sub">';
                       
                       $s_top_menu=$menus["top_menu"];
                       $i_mnu_id++;
                       $i_submnu_id=0;///sub menu layer 1
                       $i_sub_submnu_id=0;///sub menu layer 2
                   }
                   
                   //////Displaying the submenus//////////
                   if($menus["menu_name"]!=""
                      && (
                            $menus['action_add']==1 
                            || $menus['action_edit']==1 
                            || $menus['action_delete']==1 
                            || $menus["top_menu"]=="Report"                            
                         )  
                   )
                   {
                       
                       if($menus["menu_name"]!=$s_sub_menu)
                       {
                           
                           /*
                           if($s_mnu_layer2!="")
                           {
                               $s_str.= '<ul class="sub2">'.$s_mnu_layer2.'</ul>';//opening layer2
                               $s_str.= '</li>';///closing the previously opened sub_menu layer 1
                           }
                           elseif($i_sub_submnu_id>0)
                           {
                               $s_str.= "</li>";///closing the previously opened sub_menu layer 1
                           }
                           */
                           
                           $s_link=($menus["menu_link"]!=""?admin_base_url().$menus["menu_link"]:"javascript:void(0);");
                           $s_str.= '<li><a id="mnu_'.$tmp_mnu_id.'_'.$i_submnu_id.'" href="'.$s_link.'"
                                      title="'.$menus["menu_title"].'">'
                                         .$menus["menu_name"].'</a>';
                           $s_str.= create_submenus_layer2($controllers,$menus["menu_name"],$tmp_mnu_id,$i_submnu_id);  
                           $s_str.= '</li>';                                                        
                                         
                           //$s_str.= '<ul class="sub2">';//opening layer2
                           
                            $s_sub_menu=$menus["menu_name"];
                            $i_submnu_id++; 
                            $i_sub_submnu_id=0;    
                              
                            //$s_mnu_layer2="";
                       }
                       
                       /*////////Displaying the sub sub menus at layer 2////////
                       if($menus["sub_menu_name"]!="")
                       {
                            $s_link=($menus["sub_menu_link"]!=""?admin_base_url().$menus["sub_menu_link"]:"javascript:void(0);");
                            $s_mnu_layer2.='<li><a id="mnu_'.$tmp_mnu_id.'_'.$i_submnu_id.'_'.$i_sub_submnu_id
                                .'" href="'.$s_link.'">'.$menus["sub_menu_name"].'</a></li>';
                                
                                //echo htmlentities($s_mnu_layer2);    
                                        
                            $i_sub_submnu_id++;                       
                       }
                       /////////end Displaying the sub sub menus at layer 2///////*/
                       
                   }///end if
                   //////end Displaying the submenus//////////
                   
                   ///closing the previously opened sub_menu layer 0
                   $i_menus_counter++;
                   if($i_count_menus==$i_menus_counter)
                   {
                       $s_str.= "</ul></li>";
                   }
            }////end for
        }///end if
        
        /////Wraping the manus and submenus into the final "ul" wraper
        $s_str='<ul class="select">'.$s_str.'</ul>';
        unset($i_count_menus,$i_mnu_id,$tmp_mnu_id,$s_top_menu,$i_submnu_id,$i_sub_submnu_id,
              $s_sub_menu,$s_mnu_layer2,$s_link);
        //////////end Displaying Menus and Sub menus/////// 
        echo $s_str;
        
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}

/*
* Creates the sub menus at layer 2 with respect to access control
* Provided to user type. This echos the formatted sub sub menus.
* 
* @param $controllers is array of controllers
* @param $sub_menu is string of submenu at which 
* @param $i_mnu_id is int 
* @param $i_submnu_id is int 
* @returns formatted submenu layer 2 as string
*/
function create_submenus_layer2($controllers,$sub_menu,$i_mnu_id,$i_submnu_id)
{
    try
    {
        $s_ret_="";
        if(!empty($controllers) && trim($sub_menu)!="")
        {
            $i_sub_sub_menu=0;            
            foreach($controllers as $con=>$mnus)
            {
                if($mnus["sub_menu_name"]!="" && $mnus["menu_name"]==$sub_menu)
                {
                    $s_link=($mnus["sub_menu_link"]!=""?admin_base_url().$mnus["sub_menu_link"]:"javascript:void(0);");
                    $s_ret_.= '<li><a id="mnu_'.$i_mnu_id.'_'.$i_submnu_id.'_'.$i_sub_sub_menu.'" href="'.$s_link.'" 
                              title="'.$mnus["sub_menu_title"].'">'.$mnus["sub_menu_name"].'</a></li>';
                    $i_sub_sub_menu++;
                }
            }///end for
            
            ///////////Sub sub menu exists i.e layer 2///////
            if($s_ret_!="")
            {
                $s_ret_='<ul class="sub2">'.$s_ret_.'</ul>';
            }
            ///////////end Sub sub menu exists i.e layer 2///////
            unset($con,$mnus,$s_link);
        }///end if
        return $s_ret_;
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

function show_star($star=1)
	{
	$star;
	list($int, $parse) = explode('[.]', $star);
	$int;
	$parse;
	for ($i = 1; $i <= $int; $i++) 
	{
		$star_view .= "<img src=\"images/fe/star.png\">";
	}
	if($parse==5)
		{
		$star_view .= "<img src=\"images/fe/half_star.png\">";
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
		$star_view .= "<img src=\"images/fe/blank_star.png\">";
	}
	}
	return $star_view;
	}
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

function replaceHash_new($reg_exp, $replace_with, $replace_on)

{

	$replace_on		=	preg_replace($reg_exp, $replace_with, $replace_on);

	return $replace_on;

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
    $rettxt .= " point ";
        if($decnum < 20){
            $rettxt .= $ones[$decnum];
        }elseif($decnum < 100){
            $rettxt .= $tens[substr($decnum,0,1)];
            $rettxt .= " ".$ones[substr($decnum,1,1)];
        }

    }

    return $rettxt;
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




  