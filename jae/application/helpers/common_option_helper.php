<?php
/*********
* Author: SWI
* Date  : 11 Sept 2017
* Modified By:
* Modified Date:
* Purpose: generally for dropdown option
* Custom Helpers 
* Includes all necessary files and common functions
*/

/**
* For selectbox option making
* @param array $mix_value
* @param int $s_id(encrypted)
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

/**
* For selectbox option making
* @param array $mix_value
* @param int $s_id
* @return string
*/
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


/*  EXAMINATION FUNCTION(S) - START */
function makeOptionExam($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		$cond = ' WHERE i_id !=0 AND i_is_deleted=0 AND i_status=1 ';	
		$res = $CI->db->query("select i_id, s_name from {$CI->db->EXAM} {$cond} ORDER BY s_name");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if($val["i_id"] == $s_id)
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".$val["i_id"]."' >".$val["s_name"]."</option>";
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


