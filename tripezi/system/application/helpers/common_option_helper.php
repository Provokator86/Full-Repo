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


function makeOptionRating($s_id = '')
{
    try
	{
		$CI = & get_instance();		
		$mix_value = array(1=>'1',2=>'2',3=>'3',4=>'4',5=>'5');
		if($mix_value)
		{
			$s_select = '';//defined here for unsetting this var 
            foreach ($mix_value as $key=>$val)
			{
				$s_select = '';
                if($key == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".$key."'>".$val."</option>";
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



/* 
*  for country drop down 
**
****/
function makeOptionCountry($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		$cond = ' WHERE i_id !=0';		
		$res = $CI->db->query("select i_id, s_country from {$CI->db->COUNTRY} {$cond} ORDER BY s_country ");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["i_id"]) == $s_id)
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".encrypt($val["i_id"])."' >".$val["s_country"]."</option>";
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
*End cuontry dropdown
*/


/* 
*  for state drop down 
**
****/
function makeOptionState($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
        if($mix_where=='')
        {
            $cond = ' WHERE i_id !=0';    
        }
        else
        {
            $cond = $mix_where;    
        }
			
		$res = $CI->db->query("select i_id, s_state from {$CI->db->STATE} {$cond} ORDER BY s_state ");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["i_id"]) == $s_id)
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".encrypt($val["i_id"])."' >".$val["s_state"]."</option>";
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


/* dropdown for time 1 am to 12 pm */
 function makeOptionTimetable($s_id)
    {
        try
        {
            $s_option   =   '';
            for($i=1;$i<=24;$i++)
            {
                if($i<=12)
                {
                    $str1 =  ' AM ';
                }
                else
                {
                    $str1 =  ' PM '; 
                }
                $str    =   '';
                $str    =   str_pad(($i%12==0)?"12":$i%12, 2, "0", STR_PAD_LEFT);
                $str    .=   '.00'.$str1; 
				
				$s_select = '';
				if($i == $s_id)
					$s_select = " selected ";
               
                $s_option   .=   '<option '.$s_select.' value="'.$i.'">'.$str.'</option>';
            }
            //echo '<select><option>Select</option>'.$s_option.'</select>';
            return $s_option;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }




/* 
*  for city drop down in 
**
****/
function makeOptionCity($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
        if($mix_where=='')
        {
            $cond = ' WHERE i_id !=0';
        }
        else
        {
            $cond = $mix_where;
        }
				
		$res = $CI->db->query("select i_id, s_city from {$CI->db->CITY} {$cond} ORDER BY s_city ");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["i_id"]) == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".encrypt($val["i_id"])."' >".$val["s_city"]."</option>";
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


/* 
*  for country drop down 
**
****/
function makeOptionCurrency($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		$cond = ' WHERE i_id !=0';		
		$res = $CI->db->query("select i_id, s_currency_code from {$CI->db->CURRENCY} {$cond} ORDER BY i_id DESC ");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["i_id"]) == $s_id)
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".encrypt($val["i_id"])."' >".$val["s_currency_code"]."</option>";
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
*End cuontry dropdown
*/



/*
+---------------------------------------------------+
|	For property space Content Type dropdown					|
+---------------------------------------------------+
|	Added by  Mrinmoy Mondal on 29 March 2012		|
+---------------------------------------------------+
*/


function makeOptionContentType($mix_where = '', $s_id = '')
{
    try
	{
		
		$CI = & get_instance();		
		$CI->load->model('cms_model','mod_cms');	
		$mix_value = $CI->mod_cms->fetch_multi() ;
        
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
/* Content Type dropdown end*/

  	/**
    * Added by koushik for the project property space listing
    * 
    * @param array $arr_amenity
    * @param string $enc_id
    */
    
    function makeOptionAmenity($arr_amenity,$enc_id)
    {
        try
        {
            if(empty($arr_amenity))
            {
                $CI     =   &get_instance();
                $CI->load->model("assets_model");
                $arr_amenity   =   $CI->assets_model->fetch_amenity_list();
            }
            $s_option   =   '';
            if(!empty($arr_amenity))
            {
                       
                foreach($arr_amenity as $val)
                {
                   $s_select = '';//defined here for unsetting this var 
                     if(encrypt($val['id']) == $enc_id)
                     {
                         $s_select = " selected ";
                         
                     }
                     $s_option .= "<option $s_select value='".encrypt($val['id'])."'>".$val['s_name']."</option>";
                }
                  unset($s_select) ; 
            }
            unset($enc_id,$arr_amenity);
          return $s_option;     
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	
	/**
    * Added by mrinmoy for the project property space listing
    * 
    * @param array $arr_property_type
    * @param string $enc_id
    */
    
    function makeOptionPropertyType($arr_property_type,$enc_id)
    {
        try
        {
            if(empty($arr_property_type))
            {
                $CI     =   &get_instance();
                $CI->load->model("assets_model");
                $arr_property_type   =   $CI->assets_model->fetch_property_type_list();
            }
            $s_option   =   '';
            if(!empty($arr_property_type))
            {
                       
                foreach($arr_property_type as $val)
                {
                   $s_select = '';//defined here for unsetting this var 
                     if(encrypt($val['id']) == $enc_id)
                     {
                         $s_select = " selected ";
                         
                     }
                     $s_option .= "<option $s_select value='".encrypt($val['id'])."'>".$val['s_name']."</option>";
                }
                  unset($s_select) ; 
            }
            unset($enc_id,$arr_property_type);
          return $s_option;     
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	/**
    * Added by mrinmoy for the project property space listing
    * 
    * @param array $arr_bed_type
    * @param string $enc_id
    */
    
    function makeOptionBedType($arr_bed_type,$enc_id)
    {
        try
        {
            if(empty($arr_bed_type))
            {
                $CI     =   &get_instance();
                $CI->load->model("assets_model");
                $arr_bed_type   =   $CI->assets_model->fetch_bed_type_list();
            }
            $s_option   =   '';
            if(!empty($arr_bed_type))
            {
                       
                foreach($arr_bed_type as $val)
                {
                   $s_select = '';//defined here for unsetting this var 
                     if(encrypt($val['id']) == $enc_id)
                     {
                         $s_select = " selected ";
                         
                     }
                     $s_option .= "<option $s_select value='".encrypt($val['id'])."'>".$val['s_name']."</option>";
                }
                  unset($s_select) ; 
            }
            unset($enc_id,$arr_property_type);
          return $s_option;     
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	/**
    * Added by mrinmoy for the project property space listing
    * 
    * @param array $arr_cancellation_policy
    * @param string $enc_id
    */
    
    function makeOptionCancellationPolicy($arr_cancellation_policy,$enc_id)
    {
        try
        {
            if(empty($arr_cancellation_policy))
            {
                $CI     =   &get_instance();
                $CI->load->model("assets_model");
				$s_where = " WHERE c.i_status = 1 ";
                $arr_cancellation_policy   =   $CI->assets_model->fetch_cancellation_policy_list($s_where);
            }
            $s_option   =   '';
            if(!empty($arr_cancellation_policy))
            {
                       
                foreach($arr_cancellation_policy as $val)
                {
                   $s_select = '';//defined here for unsetting this var 
                     if(encrypt($val['id']) == $enc_id)
                     {
                         $s_select = " selected ";
                         
                     }
                     $s_option .= "<option $s_select value='".encrypt($val['id'])."'>".$val['s_name']."</option>";
                }
                  unset($s_select) ; 
            }
            unset($enc_id,$arr_property_type,$s_where);
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

/**
* Send a array it create a option month and year from current month to next 10 month
*     
* @param mixed $s_id
*/
    
function makeOptionMonthYear($s_id = '')
{
    try
    {
        
        
         /************************ START MONTH ******************/
        $month  =   array(1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',
                        5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',
                        9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec');
        
        $arr_current    =   explode('-',date('m-Y'));
        
        $i_month    =   (int)$arr_current[0] ;
        $i_year     =   (int)$arr_current[1] ;
        $s_option   =   '';
            for($i=1;$i<=10;$i++)
            {
                $s_select = '';
                $s_value    =   $i_month.'_'.$i_year ;  
                if($s_value == $s_id)
                $s_select = " selected ";
                $s_option   .=   "<option $s_select value='".$s_value."'>".$month[$i_month]."  ".$i_year."</option>";
                
                $i_month++ ;
                if($i_month%13==0)
                {
                    $i_month    =   1;
                    $i_year    +=   1;     
                }
                   
            }
       
        return $s_option;
        
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}

function makeOptionNoEncrypt($mix_value = array(),$s_id = '')
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
    
    
  
