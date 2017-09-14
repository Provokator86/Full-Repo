<?php
/*********
* Author: SWI
* Date  : 02 June 2016
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


/*  COUNTRY FUNCTION(S) - START */
function makeOptionCountry($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		$cond = ' WHERE i_id !=0 AND i_is_deleted=0 AND i_status=1 ';	
		$res = $CI->db->query("select i_id, name from {$CI->db->COUNTRY} {$cond} ORDER BY name");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if($val["i_id"] == $s_id)
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".$val["i_id"]."' >".$val["name"]."</option>";
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

	
/* STATE FUNCTION(S) - START */
function makeOptionState($mix_where = '', $s_id = '')
{
  	try
	{
		$CI = &get_instance();
		$cond = (trim($mix_where)) ? "WHERE i_id!=0 AND i_is_deleted=0 AND i_status=1 AND ".$mix_where : ' WHERE i_id!=0  AND i_is_deleted=0 AND i_status=1';
		$res = $CI->db->query("select i_id, name, i_country_id from {$CI->db->STATE} {$cond} ORDER BY name ");	
		
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
            $s_id = explode(',', $s_id);
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(in_array($val["i_id"], $s_id))
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".$val["i_id"]."' >".$val["name"]."</option>";
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


/* CITY FUNCTION(S) - START */
function makeOptionCity($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		$cond = (trim($mix_where)) ? "WHERE i_id!=0 AND i_is_deleted=0 AND i_status=1 AND ".$mix_where : ' WHERE i_id!=0  AND i_is_deleted=0 AND i_status=1 ';		
		$res = $CI->db->query("select i_id, name, i_state_id,i_country_id from {$CI->db->CITY} {$cond} ORDER BY name");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if($val["i_id"] == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".$val["i_id"]."' >".$val["name"]."</option>";
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



/* CATEGORY FUNCTION(S) - START */
function makeOptionParentCategory($mix_where = '', $s_id = '')
{
    try
    {
        $CI = &get_instance();
        $cond = (trim($mix_where)) ? "WHERE i_parent_id=0 AND e_deleted='No' AND i_status=1 AND ".$mix_where : ' WHERE i_parent_id=0 AND e_deleted="No" AND i_status=1';        
        $res = $CI->db->query("select i_id, s_category, i_parent_id from {$CI->db->CATEGORY} {$cond} ORDER BY s_category");    
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            foreach ($mix_value as $val)
            {
                $s_select = '';
                if($val["i_id"] == $s_id)
                    $s_select = " selected ";
                $s_option .= "<option $s_select value='".$val["i_id"]."' >".$val["s_category"]."</option>";
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

function makeOptionCategory($mix_where = '', $s_id = '')
{
    try
    {
        $CI = &get_instance();
        $cond = (trim($mix_where)) ? "WHERE e_deleted='No' AND i_status=1 AND ".$mix_where : ' WHERE e_deleted="No" AND i_status=1';        
        $res = $CI->db->query("select i_id, s_category, i_parent_id from {$CI->db->CATEGORY} {$cond} ORDER BY s_category");    
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            foreach ($mix_value as $val)
            {
                $s_select = '';
                if($val["i_id"] == $s_id)
                    $s_select = " selected ";
                $s_option .= "<option $s_select value='".$val["i_id"]."' >".$val["s_category"]."</option>";
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
* bootstrap multi selected see@ views/web_master/comparison_market_analysis/show_list
*/
function multiSelectChildCategory($parent_id = '', $s_arr_id = array())
{
    try
    {
        if(intval($parent_id)<=0)
        return false;
        
        $CI = &get_instance();
        $cond = " WHERE e_deleted='No' AND i_status=1 AND i_parent_id = '".$parent_id."' ";        
        $res = $CI->db->query("select i_id,s_category,i_parent_id FROM {$CI->db->CATEGORY} {$cond} ORDER BY s_category");    
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            foreach ($mix_value as $val)
            {
                //if($val["i_id"] == $s_id)
                $s_select = '';
                if(in_array($val['i_id'],$s_arr_id))
                    $s_select = " selected ";
                $s_option .= "<option $s_select value='".$val["i_id"]."' >".$val["s_category"]."</option>";
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


/*CMS ADDITIONAL PAGES i.e. FAQ, NEWS DROPDOWN FUNCTION(S) - START */
function makeOptionCmsAdditionalPages($s_id = '')
{
    try
    {
        $CI = &get_instance();        
        $mix_value = $CI->config->item('CMS_SUB_PAGES');
        $s_option = '';
        if($mix_value)
        {
            foreach ($mix_value as $key=>$val)
            {
                $s_select = '';
                if($key == $s_id)
                    $s_select = " selected ";
                $s_option .= "<option $s_select value='".$key."' >".$val."</option>";
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

/*CMS PAGES i.e. FAQ, NEWS DROPDOWN FUNCTION(S) - START */
function getOptionAllCmsPages($s_id = '')
{
    try
    {
        $CI = &get_instance();
        $cond = " WHERE i_id!=0 AND e_status!='Deleted' ";        
        $res = $CI->db->query("SELECT i_id, s_title  from {$CI->db->CMS} {$cond} ORDER BY s_title");    
           
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            foreach ($mix_value as $val)
            {
                $s_select = '';
                if($val["i_id"] == $s_id)
                    $s_select = " selected ";
                $s_option .= "<option $s_select value='".$val["i_id"]."' >".$val["s_title"]."</option>";
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

// for advertisement dropdown
function getOptionAllContentPages($i_parent =0,$results='',$select='')
{    
    $CI = &get_instance();    
    $sql = "SELECT * FROM ".$CI->db->CMS." WHERE i_parent_id = {$i_parent} AND i_cms_type IN(1,2,3) ";         
    // staement 1
    //$sql = "SELECT * FROM ".$CI->db->CMS." WHERE i_parent_id = {$i_parent}";    // staement 2       
    $get_options_obj = $CI->db->query($sql);
    $get_options_arr = $get_options_obj->result_array();
    $space='';
   
    if(!empty($get_options_arr)) 
    {
        
        foreach($get_options_arr as $val)
        {                
            if($val['i_parent_id'] ==0)  $depth = 0; else  $depth=getPagesDepth($val['i_id']);
            //echo "i_parent_id:".$val['i_parent_id']." : s_title:".$val['s_title']." : depth:".$depth."<br>"; 
            for($i=0;$i<$depth;$i++) $space .= "-- ";
            $selected = $select == $val['i_id'] ? 'selected="selected"' : '';                    
            //if ( $val['i_id'] != $not_in ) // if statement 2  
            $disabled = '';
            if($val['i_parent_id'] ==0 && $val['i_cms_type'] ==1)
            $disabled = 'disabled="disabled"';
            
            $results .='<option '.$disabled.' value="'.$val['i_id'].'" '.$selected.'>'.$space.$val['s_title'].'</option>';  
            $results = getOptionAllContentPages($val['i_id'],$results,$select);
            $space='';             
        }        
    }    
    return $results;
}


function getPagesDepth($i_parent=0,$depth=0)
{    
    $CI = &get_instance();    
    $sql = "SELECT * FROM ".$CI->db->CMS." WHERE i_id = {$i_parent} AND i_cms_type IN(1,2,3) ";
    $get_options_obj = $CI->db->query($sql);
    $get_options_arr = $get_options_obj->result_array();    
     if(!empty($get_options_arr)) 
     {        
        foreach($get_options_arr as $val)
        {            
            if($val['i_parent_id'] !=0) 
                return cms_pages_depth($val['i_parent_id'],$depth+1);                    
            else
              return $depth;                
        }            
     }
}
// for advertisement dropdown end



function makeOptionCmsMaster($s_id = '')
{
    try
    {
        $CI = &get_instance();        
        $res = $CI->db->query("SELECT i_id, s_name  from {$CI->db->CMS_MASTER} ORDER BY s_name");                   
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            foreach ($mix_value as $val)
            {
                $s_select = '';                
                if($val["i_id"] == $s_id)
                    $s_select = " selected ";
                $s_option .= "<option $s_select value='".$val["i_id"]."'>".$val["s_name"]."</option>";
                
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

// below functions are used from 7 june
function makeOptionFormsMaster($s_id = '')
{
    try
    {
        $CI = &get_instance();        
        $res = $CI->db->query("SELECT i_id, s_form_title  from {$CI->db->FORM_MASTER} ORDER BY s_form_title");                   
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            foreach ($mix_value as $val)
            {
                $s_select = '';                
                if($val["i_id"] == $s_id)
                    $s_select = " selected ";
                $s_option .= "<option $s_select value='".$val["i_id"]."'>".$val["s_form_title"]."</option>";
                
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

// form master dropdown with title
function makeOptionFormsMasterWtTitle($s_id = '')
{
    try
    {
        $CI = &get_instance();        
        $res = $CI->db->query("SELECT i_id, s_form_title  from {$CI->db->FORM_MASTER} ORDER BY s_form_title");                   
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            foreach ($mix_value as $val)
            {
                $s_select = '';                
                if($val["s_form_title"] == $s_id)
                    $s_select = " selected ";
                $s_option .= "<option $s_select value='".$val["s_form_title"]."'>".$val["s_form_title"]."</option>";
                
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

// record type dropdown
function makeOptionRecordType($s_id = '')
{
    try
    {
        $CI = &get_instance();   
        $mix_value = $CI->db->RECORD_TYPE;
        $s_option = '';
        if($mix_value)
        {
            foreach ($mix_value as $key=>$val)
            {
                $s_select = '';                
                if($key == $s_id)
                    $s_select = " selected ";
                $s_option .= "<option $s_select value='".$key."'>".$val."</option>";
                
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

// payer dropdown
function makeOptionPayer($s_id = '')
{
    try
    {
        $CI = &get_instance();        
        $res = $CI->db->query("SELECT i_id, s_first_payer_name_line  from {$CI->db->PAYER_INFO} ORDER BY s_first_payer_name_line");                   
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            foreach ($mix_value as $val)
            {
                $s_select = '';                
                if($val["i_id"] == $s_id)
                    $s_select = " selected ";
                $s_option .= "<option $s_select value='".$val["i_id"]."'>".$val["s_first_payer_name_line"]."</option>";
                
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

// payee drop down
function makeOptionPayee($mix_where = '', $s_id = '')
{
    try
    {
        $CI = &get_instance();
        $cond = (trim($mix_where)) ? "WHERE i_status=1 AND ".$mix_where : ' WHERE i_status=1';        
        $res = $CI->db->query("SELECT i_id, s_first_payee_name_line, s_last_payee_name_line  from {$CI->db->PAYEE_INFO} ORDER BY s_first_payee_name_line");    
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            foreach ($mix_value as $val)
            {
                $s_select = '';                
                if($val["i_id"] == $s_id)
                    $s_select = " selected ";
                $name = $val["s_first_payee_name_line"].($val["s_last_payee_name_line"]?' '.$val["s_last_payee_name_line"]:"");
                $s_option .= "<option $s_select value='".$val["i_id"]."'>".$name."</option>";
                
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

// batch dropdown from batch master tbl 27 september, 2016
function makeOptionBatchMaster($s_id = '')
{
    try
    {
        $CI = &get_instance();        
        $res = $CI->db->query("SELECT i_id, s_batch_id FROM {$CI->db->BATCH_MASTER} WHERE i_status=1 ORDER BY s_batch_id");                   
        $mix_value = $res->result_array();
        $s_option = '';
        if($mix_value)
        {
            foreach ($mix_value as $val)
            {
                $s_select = '';                
                if($val["i_id"] == $s_id)
                    $s_select = " selected ";
                $s_option .= "<option $s_select value='".$val["s_batch_id"]."'>".$val["s_batch_id"]."</option>";
                
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

// batch status dropdown
function makeOptionBatchStatus($s_id = '')
{
    try
    {
        $CI = &get_instance();        
        $mix_value = $CI->db->BATCH_STATS;
        $s_option = '';
        if($mix_value)
        {
            foreach ($mix_value as $key=>$val)
            {
                $s_select = '';
                if($key == $s_id)
                    $s_select = " selected ";
                $s_option .= "<option $s_select value='".$key."' >".$val."</option>";
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

