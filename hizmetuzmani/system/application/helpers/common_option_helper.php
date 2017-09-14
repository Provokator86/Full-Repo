<?php

/*********
* Author: Mrinmoy Mondal
* Date  : 27 March 2012
* Modified By: Koushik Rout 
* Modified Date: 26 april 2012
* Purpose:
*  Custom Helpers 
* Includes all necessary files and common functions
*/

/**
* For selectbox option making
* 
* @param string $s_img_path, $s_new_path, $s_file_name
* @param int $i_new_height, $i_new_width 
* @param mix $configArr
* @return string
*/



function makeOption($mix_value = array(),$s_id = '')
{
    try
	{
		$s_option = '';
		
		if($mix_value)
		{
			foreach ($mix_value as $key=>$txt)
			{
				$s_select = '';
				if(encrypt($key) == $s_id)
					$s_select = " selected ";
				$s_option     .="<option $s_select value='".encrypt($key)."'>$txt</option>";
				
			}
		}
		
		unset($mix_value, $s_select);
		return $s_option;
		
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}





/* date 27 march 2012
*  for user type  drop down in quoteforjob for admin user management
**
****/
function makeOptionUser($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		$cond = ' WHERE id !=0';		
		$res = $CI->db->query("select id, s_user_type from {$CI->db->USER_TYPE} {$cond}");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if($val["id"] == $s_id)
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".encrypt($val["id"])."' >".$val["s_user_type"]."</option>";
			}
		}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}
/***
*End user dropdown
*/

/*
+---------------------------------------------------------------+
|    For HIZMETUZMANI Language dropdown prefix as option value|
+---------------------------------------------------------------+
|    Added by Koushik Rout on 10 Jan 2012                       |
+---------------------------------------------------------------+
*/
function makeOptionLanguagePrefix($s_id = '')
{
    try
    {
        $CI = &get_instance();
        $cond = ' WHERE i_id !=0';        
        $res = $CI->db->query("select i_id,s_short_name,s_language from {$CI->db->LANGUAGE} {$cond}");    
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            foreach ($mix_value as $val)
            {
                $s_select = '';
                if($val["s_short_name"] == $s_id)
                    $s_select = " selected ";
                    
                $s_option .= "<option $s_select value='".$val["s_short_name"]."'  >".$val["s_language"]."</option>";
            }
        }

        unset($res, $mix_value, $s_select, $mix_where, $s_id);
        return $s_option;
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}
/***
*End LanguagePrefix dropdown 
*/


/* 1 may 2012 */

function makeOptionGSMCode($mix_where = '', $s_id = '')
{
    try
	{
		$CI = & get_instance();		
		$mix_value = $CI->db->GSM;	// defined @ database.php\
		asort($mix_value);
		if($mix_value)
		{
			$s_select = '';	//defined here for unsetting this var 
            foreach ($mix_value as $key=>$val)
			{
				$s_select = '';
                if(encrypt($val) == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select  value='".encrypt($val)."'>".$val." </option>";
			}
            unset($s_select,$key,$val);
		}
        unset($mix_value, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}

function makeOptionAreaCode($mix_where = '', $s_id = '')
{
    try
	{
		$CI = & get_instance();		
		$mix_value = $CI->db->AREACODE; // defined @ database.php
		asort($mix_value);
		if($mix_value)
		{
			$s_select = ''; //defined here for unsetting this var 
            foreach ($mix_value as $key=>$val)
			{
				$s_select = '';
                if(encrypt($val) == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select  value='".encrypt($val)."'>".$val." </option>";
			}
            unset($s_select,$key,$val);
		}
        unset($mix_value, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}


/* paymrnt method dropdown , author @ mrinmoy */
function makeOptionPayMethod($mix_where = '', $s_id = '')
{
    try
	{
		$CI = & get_instance();		
		$mix_value = $CI->db->PAYMENTMETHOD;
		if(!empty($mix_where) && is_array($mix_where))
		{
			foreach($mix_where as $val)
			{
				unset($mix_value[$val]);
			}
		}
		
		if($mix_value)
		{
			$s_select = '';//defined here for unsetting this var 
            foreach ($mix_value as $key=>$val)
			{
				$s_select = '';
                if(encrypt($key) == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".encrypt($key)."'>".$val."</option>";
			}
            unset($s_select,$key,$val);
		}
        unset($mix_value, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}


/* date 29 march 2012 
*  for Buyer user   drop down in hizmetuzmani for admin user management
**
****/
function makeOptionUserByType($mix_where = '', $s_id = '',$i_role =1)
{
    try
	{
		$CI = &get_instance();
		
		$cond = (trim($mix_where)) ? "WHERE id!=0 AND i_role = $i_role AND ".$mix_where :" WHERE id!=0 AND i_role = ".$i_role;		
	
		$res = $CI->db->query("select id, s_username from {$CI->db->MST_USER} {$cond} ORDER BY s_username ASC");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["id"]) == $s_id)
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".encrypt($val["id"])."' >".$val["s_username"]."</option>";
			}
		}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}
/***
*End user dropdown
*/


function makeOptionJob($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		//$cond = ' WHERE id !=0';		
		$cond = (trim($mix_where)) ? "WHERE id!=0 AND ".$mix_where : ' WHERE id!=0';	
		$res = $CI->db->query("select id, s_title from {$CI->db->JOBS} {$cond} ORDER BY s_title");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["id"]) == $s_id)
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".encrypt($val["id"])."' >".$val["s_title"]."</option>";
			}
		}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}




/*****
*for rating on photo comments
*
***/
function makeRating($mix_value = array(),$s_id = '')
{
    try
	{
		$s_option = '';
		
		if($mix_value)
		{
			foreach ($mix_value as $key=>$txt)
			{
				$s_select = '';
				if($key == $s_id)
					$s_select = " selected ";
				$s_option     .="<option $s_select value='".$key."'>$txt</option>";
			}
		}
		unset($mix_value, $s_select);
		return $s_option;
		
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}


/* date 29 March 2012
*  for state drop down 
**
****/
function makeOptionState($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		$cond = ' WHERE id !=0';		
		$res = $CI->db->query("select id, state from {$CI->db->STATE} {$cond} ORDER BY state ");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["id"]) == $s_id)
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".encrypt($val["id"])."' >".$val["state"]."</option>";
			}
		}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}
/***
*End state dropdown
*/


/* date 26 April 2012
*  for province drop down 
*
*/
function makeOptionProvince($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		//$cond = ($mix_where=='')?' WHERE id !=0':" WHERE id !=0 AND ".$mix_where." ";		
		$cond = (trim($mix_where)) ? "WHERE id!=0 AND ".$mix_where : ' WHERE id!=0';
		//$cond = "WHERE id!=0 ";
		$res = $CI->db->query("select id, province from {$CI->db->PROVINCE} {$cond} ORDER BY province ");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["id"]) == $s_id)
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".encrypt($val["id"])."' >".$val["province"]."</option>";
			}
		}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}
/***
*End state dropdown
*/



/* date 29 March 2012
*  for city drop down in 
**
****/
function makeOptionCity($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		$cond = ' WHERE id !=0';		
		$res = $CI->db->query("select id, city from {$CI->db->CITY} {$cond} ORDER BY city ");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["id"]) == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".encrypt($val["id"])."' >".$val["city"]."</option>";
			}
		}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}
/***
*End city dropdown
*/


/* date 29 March 2012
*  for zip drop down  
**
****/
function makeOptionZip($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		//$cond = ' WHERE id !=0';		
		$cond = (trim($mix_where)) ? "WHERE id!=0 AND ".$mix_where : ' WHERE id!=0';
		$res = $CI->db->query("select id, postal_code from {$CI->db->ZIPCODE} {$cond}");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["id"]) == $s_id)
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".encrypt($val["id"])."' >".$val["postal_code"]."</option>";
			}
		}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}
/***
*End zip dropdown
*/


/*
+---------------------------------------------------+
|	For hizmetuzmani Content Type dropdown					|
+---------------------------------------------------+
|	Added by  Mrinmoy Mondal on 29 March 2012		|
+---------------------------------------------------+
*/


function makeOptionContentType($mix_where = '', $s_id = '')
{
    try
	{
		
		$CI = & get_instance();		
		$res = $CI->db->query("select i_id, s_name from {$CI->db->CMSMASTERTYPE} where s_name not like 'Home%' order by s_name asc");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if($val["i_id"] == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".encrypt($val["i_id"])."' >".$val["s_name"]."</option>";
			}
		}
		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}
/* Content Type dropdown end*/





/*
+---------------------------------------------------------------+
|	For hizmetuzmani Language dropdown								|
+---------------------------------------------------------------+
|	Added by  Mrinmoy Mondal on 29 March 2012						|
+---------------------------------------------------------------+
*/
function makeOptionLanguage($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		$cond = ' WHERE i_id !=0';		
		$res = $CI->db->query("select i_id, s_language from {$CI->db->LANGUAGE} {$cond}");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["i_id"]) == $s_id)
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".encrypt($val["i_id"])."' title='".(($val["i_status"]==1)?'Active':'Inactive')."' >".$val["s_language"]."</option>";
			}
		}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}
/***
*End Language dropdown
*/



/**
* For categgory selectbox option making
* 
* @param mix $mixwhere: string of select condition
* @param string $s_id : seleted string
* @return string
*/


function makeOptionCategory($mix_where = '', $s_id = '')
{
    try
	{		
		
		
		$CI = & get_instance();		
		$lang_prefix = $CI->session->userdata('lang_prefix');
		$default_pre = $CI->site_default_lang_prefix;
		
		
  		$cond = (trim($mix_where)) ? "WHERE c.i_id!=0 AND ".$mix_where : ' WHERE c.i_id!=0';		
		$res = $CI->db->query("SELECT * FROM {$CI->db->CATEGORY} c  {$cond} ORDER BY {$default_pre}_s_category_name ");	
		$mix_value = $res->result_array();
		
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["i_id"]) == $s_id)
					$s_select = " selected ";
				$category = $val["{$lang_prefix}_s_category_name"]?$val["{$lang_prefix}_s_category_name"]:$val["{$default_pre}_s_category_name"];
				$s_option .= "<option $s_select value='".encrypt($val["i_id"])."'>".get_unformatted_string($category)."</option>";
			}
		}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}

function makeOptionCategoryList($mix_where = '', $s_id = '')
{
    try
	{		
		$CI = & get_instance();		
		$lang_prefix = $CI->session->userdata('lang_prefix');
		$default_pre = $CI->site_default_lang_prefix;
		
  		$cond = (trim($mix_where)) ? "WHERE c.i_id!=0 AND ".$mix_where : ' WHERE c.i_id!=0';	
		$res = $CI->db->query("SELECT * FROM {$CI->db->CATEGORY} c  {$cond} ORDER BY {$default_pre}_s_category_name ");	
		$mix_value = $res->result_array();
				
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				//if(encrypt($val["id"]) == $s_id)
				if(in_array(encrypt($val["i_id"]),$s_id) )
					$s_select = " selected ";					
				
				$category = $val["{$lang_prefix}_s_category_name"]?$val["{$lang_prefix}_s_category_name"]:$val["{$default_pre}_s_category_name"];
				$s_option .= "<option {$s_select} value='".encrypt($val["i_id"])."'>".get_unformatted_string($category)."</option>";
			}
		}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}






function makeOptionJobStatus($mix_where = '', $s_id = '')
{
    try
	{
		$CI = & get_instance();		
		$mix_value = $CI->db->JOBSTATUS;
		if(!empty($mix_where) && is_array($mix_where))
		{
			foreach($mix_where as $val)
			{
				unset($mix_value[$val]);
			}
		}
		
		if($mix_value)
		{
			$s_select = '';//defined here for unsetting this var 
            foreach ($mix_value as $key=>$val)
			{
				$s_select = '';
                if(encrypt($key) == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".encrypt($key)."'>".$val."</option>";
			}
            unset($s_select,$key,$val);
		}
        unset($mix_value, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}


function makeOptionRadiusOption($mix_where = '', $s_id = '')
{
    try
	{
		$CI = & get_instance();		
		$mix_value = $CI->db->RADIUS;
		if($mix_value)
		{
			$s_select = '';//defined here for unsetting this var 
            foreach ($mix_value as $key=>$val)
			{
				$s_select = '';
                if(encrypt($val) == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select  value='".encrypt($val)."'>".$val." ".t('miles')."</option>";
			}
            unset($s_select,$key,$val);
		}
        unset($mix_value, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}


function makeOptionPaginationOption($mix_where = '', $s_id = '')
{
    try
	{
		$CI = & get_instance();		
		$mix_value = $CI->db->PAGINATION;
		if($mix_value)
		{
			$s_select = '';//defined here for unsetting this var 
            foreach ($mix_value as $key=>$val)
			{
				$s_select = '';
                if(encrypt($key) == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".encrypt($key)."'>".$val."</option>";
			}
            unset($s_select,$key,$val);
		}
        unset($mix_value, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}


function makeOptionExperience($mix_where = '', $s_id = '')
{
    try
	{
		$CI = & get_instance();		
		/*$mix_value = array(1=>'1',2=>'2',3=>'3',4=>'4',5=>'5');
		if($mix_value)
		{*/
			$s_select = '';//defined here for unsetting this var 
            /*foreach ($mix_value as $key=>$val)
			{
				$s_select = '';
                if(encrypt($key) == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".encrypt($key)."'>".$val."</option>";
			}*/
			for($i=1;$i<=30;$i++)
			{
				$s_select = '';
                if(encrypt($i) == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".encrypt($i)."'>".$i."</option>";
			}
            unset($s_select,$key,$val);
		/*}*/
        unset($s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}

function makeOptionQuotingPeriod($mix_where = '', $s_id = '')
{
    try
	{
		$CI = & get_instance();		
		$mix_value = array(1=>'1',2=>'2',3=>'3',4=>'4');
		if($mix_value)
		{
			$s_select = '';//defined here for unsetting this var 
            foreach ($mix_value as $key=>$val)
			{
				$s_select = '';
                if(encrypt($key) == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".encrypt($key)."'>".$val."</option>";
			}
            unset($s_select,$key,$val);
		}
        unset($mix_value, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}






 function match_words($s_heystack,$s_search) 
    {
        if( preg_match('#(^|\s)'.$s_search.'($|\s)#', $s_heystack) ) {
         return TRUE;
        }
        else {
         return FALSE;
        }
    }    
    
    
     
  function search_words() {
        $words = $this->_mtmx->getWords();
        //print_r($words);
        return $words;
    }