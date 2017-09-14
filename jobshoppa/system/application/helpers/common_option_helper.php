<?php

/*********

* Author: Sahinul Haque

* Date  : 08 April 2011

* Modified By: Samarendu Ghosh

* Modified Date: 26 april 2011

* Purpose:

*  Custom Helpers 

* Includes all necessary files and common functions

* 

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






/* date 15 sep 2011
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


/* date 15 sep 2011
*  for Buyer user   drop down in quoteforjob for admin user management
**
****/
function makeOptionUserByType($mix_where = '', $s_id = '',$i_role =1)
{
    try
	{
		$CI = &get_instance();
		
		$cond = (trim($mix_where)) ? "WHERE id!=0 AND i_role = $i_role AND ".$mix_where :" WHERE id!=0 AND i_role = ".$i_role;		
	
		$res = $CI->db->query("select id, s_username from {$CI->db->USERMANAGE} {$cond}");	
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
		$res = $CI->db->query("select id, s_title from {$CI->db->JOBS} {$cond}");	
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


/* used in prof. pmb job list dropdown */
function makeOptionJobForProfessional($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		//$cond = ' WHERE id !=0';		
		$cond = (trim($mix_where)) ? "WHERE j.id!=0 AND ".$mix_where : ' WHERE j.id!=0';	
		$sql_query = "SELECT j.id, j.s_title FROM {$CI->db->JOBS} AS j LEFT JOIN {$CI->db->PMB} AS p ON j.id = p.i_job_id {$cond} ";
		$res = $CI->db->query($sql_query);			
		$mix_value = $res->result_array();
		//pr($mix_value); exit;
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


/* date 9 sep 2011
*  for state drop down in quoteforjob
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
				if($val["id"] == $s_id)
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



/* date 9 sep 2011
*  for city drop down in 
**
****/
function makeOptionCity($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		$cond = (trim($mix_where)) ? "WHERE id!=0 AND ".$mix_where : ' WHERE id!=0';
		//$cond = (trim($mix_where)) ? "WHERE id!=0 AND ".$mix_where : ' WHERE id!=0';		
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






/* date 21 sep 2011
*  for zip drop down in quoteforjob
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
				if($val["id"] == $s_id)
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
|	For QUOTEURJOB Content Type dropdown					|
+---------------------------------------------------+
|	Added by  Mrinmoy Mondal on 20 Aug 2011		|
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
|	For QUOTEURJOB Country dropdown								|
+---------------------------------------------------------------+
|	Added by  Mrinmoy Mondal on 20 Aug 2011					    |
+---------------------------------------------------------------+
*/
function makeOptionCountry($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		$cond = ' WHERE i_con_id !=0';		
		$res = $CI->db->query("select i_con_id, s_con_name from {$CI->db->COUNTRY} {$cond}");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["i_con_id"]) == $s_id)
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".encrypt($val["i_con_id"])."' title='".(($val["i_status"]==1)?'Active':'Inactive')."' >".$val["s_con_name"]."</option>";
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
*End Country dropdown
*/

/*
+---------------------------------------------------------------+
|	For QUOTEURJOB Language dropdown								|
+---------------------------------------------------------------+
|	Added by  Mrinmoy Mondal on 20 Aug 2011						|
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

* For Album selectbox option making

* 
* @param mix $mixwhere: array of select condition

* @param string $s_id : seleted string

* @return string

*/



function makeOptionAlbum($mix_where = '', $s_id = '')
{
    try
	{
		
		$CI = & get_instance();
		$cond = (trim($mix_where)) ? "WHERE id!=0 AND ".$mix_where : ' WHERE id!=0';		
		$res = $CI->db->query("select id, s_title, i_is_active from {$CI->db->ALBUM} {$cond}");	
		$mix_value = $res->result_array();
		
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["id"]) == $s_id)
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".encrypt($val["id"])."' title='".(($val["i_is_active"]==1)?'Active':'Inactive')."' >".$val["s_title"]."</option>";
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
		
  		$cond = (trim($mix_where)) ? "WHERE c.id!=0 AND ".$mix_where : ' WHERE c.id!=0';		
		$res = $CI->db->query("select c.id, c.s_category_name , c.i_status from {$CI->db->CATEGORY} c  {$cond} ORDER BY s_category_name");	
		$mix_value = $res->result_array();
				
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["id"]) == $s_id)
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".encrypt($val["id"])."'>".get_unformatted_string($val["s_category_name"])."</option>";
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

/*
* For category type selectbox option making
* 
* @param mix $mixwhere: string of select condition
* @param string $s_id : seleted string
* @return string*/
function makeOptionCategoryType($mix_where = '', $s_id = '')
{
    try
	{
		$CI = & get_instance();		
		$mix_value = $CI->db->CATEGORY_TYPE;
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



/* job radar  */
function makeOptionCategoryList($mix_where = '', $s_id = '')
{
    try
	{		
		$CI = & get_instance();		
  		$cond = (trim($mix_where)) ? "WHERE c.id!=0 AND ".$mix_where : ' WHERE c.id!=0';		
		$res = $CI->db->query("select c.id, c.s_category_name AS s_category_name, c.i_status from {$CI->db->CATEGORY} c {$cond} ORDER BY s_category_name");	
		$mix_value = $res->result_array();
				
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				//if(encrypt($val["id"]) == $s_id)
				if(in_array(encrypt($val["id"]),$s_id) )
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".encrypt($val["id"])."'>".get_unformatted_string($val["s_category_name"])."</option>";
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



/*
	for frontend milestones year dropdown
*/


function makeOptionYear($mix_where = '', $s_id = '')
{
    try
	{
		
		$CI = & get_instance();
		$cond = (trim($mix_where)) ? "WHERE i_id!=0 AND ".$mix_where : ' WHERE i_id!=0';	
		$cond.=' ORDER BY i_year DESC';	
		$res = $CI->db->query("select i_id, i_year, s_title, i_is_active from {$CI->db->MILESTONES} {$cond}");	
		$mix_value = $res->result_array();
		
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["i_id"]) == $s_id)
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".encrypt($val["i_id"])."' title='".(($val["i_is_active"]==1)?'Active':'Inactive')."' >".$val["i_year"]."</option>";
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
                if(encrypt($key) == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".encrypt($key)."'>".$val." miles</option>";
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

function makeOptionAvailableTime($mix_where = '', $s_id = '')
{
    try
	{
		$CI = & get_instance();		
		$mix_value = $CI->db->AVAILABLE_TIME;
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