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

		$res = $CI->db->query("SELECT i_id, s_country from {$CI->db->COUNTRY} {$cond} ORDER BY s_country ");	

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

  

/***************************CMS*********************************/

function makeOptionContentType($mix_where = '', $s_id = '')
{
    try
	{


		$CI = & get_instance();	
		//$res = $CI->db->query("select i_id, s_name from {$CI->db->CMSMASTERTYPE} where s_name not like 'Home%' order by s_name asc");	
		$res = $CI->db->query("select i_id, s_name from {$CI->db->CMSMASTERTYPE} where i_id<=4 order by s_name asc");	

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





function makeOptionPageType($mix_where = '', $s_id = '')

{

    try

	{

		

		$CI = & get_instance();		

		$res = $CI->db->query("select i_id, page_reference from {$CI->db->AD_PAGE} order by page_reference asc");	

		$mix_value = $res->result_array();

		$s_option = '';

		if($mix_value)

		{

			foreach ($mix_value as $val)

			{

				$s_select = '';

				if($val["i_id"] == $s_id)

					$s_select = " selected ";

				$s_option .= "<option $s_select value='".encrypt($val["i_id"])."' >".$val["page_reference"]."</option>";

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
*  for affiliates drop down 
** mrinmoy 6Mar 2014
****/

function makeOptionAffiliates($s_id = '')
{
    try
	{
		$CI = &get_instance();
		$res = $CI->db->query("select i_id, s_name from {$CI->db->AFFILIATES} WHERE i_status = 1 ORDER BY s_name ASC ");
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

/* 
*  for bank offer drop down 
** mrinmoy 5June 2014
****/

function makeOptionBankOffer($s_id = '')
{
    try
	{
		$CI = &get_instance();
		$res = $CI->db->query("select i_id, s_bank from {$CI->db->BANK_OFFER} WHERE i_status = 1 ORDER BY s_bank ASC ");
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if($val["i_id"] == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".$val["i_id"]."' >".$val["s_bank"]."</option>";
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

/*************************** below function for report sections 7 july 2014 **********************************/
function makeOptionCustomPeriod($s_id = '')
{
    try
    {
        $s_option = '';
		$mix_value = array(1=>'Custom Dates',2=> 'Today',3=> 'Yesterday',4=> 'Last 7 Days',5=> 'Last 30 Days');
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

function makeOptionReportStatus($s_id = '')
{
    try
    {
        $s_option = '';
		$mix_value = array(0=>'Pending',1=> 'Confirmed', 2=> 'Paid');
        if($mix_value)
        {
            foreach ($mix_value as $key=>$txt)
            {
                $s_select = '';
                if($key == $s_id && $s_id.'a'!='a')
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

function makeOptionNetwork($s_id = '')
{
    try
    {
        $s_option = '';
		
		$CI = &get_instance();		
		$s_qry		= "SELECT DISTINCT(s_network) FROM cd_cashback_earned WHERE s_network!='' ORDER BY s_network ASC ";
		$rs			= $CI->db->query($s_qry);
		$mix_value 	= $rs->result_array();
		
        if($mix_value)
        {
            foreach ($mix_value as $key=>$txt)
            {
                $s_select = '';
                if($txt['s_network'] == $s_id)
                    $s_select = " selected ";
                $s_option     .="<option $s_select value='".$txt['s_network']."'>".$txt['s_network']."</option>";

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

function getReportStatus($s_id = '')
{
    try
    {
        $s_option = '';
		$mix_value = array(0=>'Pending',1=> 'Confirmed', 2=> 'Paid');
		
        if($s_id.'a'!='a')
        {
			$s_option = $mix_value[$s_id];
        }
        unset($mix_value, $s_select);
        return $s_option;
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}

function makeOptionReportStore($s_id = '')
{
    try
	{
		$CI = &get_instance();
		$res = $CI->db->query("select i_id, s_store_title from {$CI->db->STORE} WHERE i_is_active = 1 ORDER BY s_store_title ASC ");
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if($val["s_store_title"] == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".$val["s_store_title"]."' >".$val["s_store_title"]."</option>";
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


/*************************************** end function for report sections 7 july 2014 ***********************************/


/* 
*  for affiliates drop down 
** mrinmoy 6Mar 2014
****/

function makeOptionStoreForAds($s_id = '')
{
    try
	{
		$CI = &get_instance();
		$res = $CI->db->query("select i_id, s_store_title from {$CI->db->STORE} WHERE i_is_active = 1 ORDER BY s_store_title ASC ");
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if($val["i_id"] == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".$val["i_id"]."' >".$val["s_store_title"]."</option>";
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

function getAffiliates($s_id = '')
{
    try
	{
		$CI = &get_instance();
		$res = $CI->db->query("select i_id, s_name from {$CI->db->AFFILIATES} WHERE i_id = {$s_id} ");
		$mix_value = $res->result_array();
		$s_name = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_name = $val["s_name"];
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

function get_category_breadcrumb($cat_id=0) 
{	
	$CI = & get_instance();
	$sql = "SELECT i_id,s_url,s_category,i_parent_id FROM cd_category WHERE i_id = '".$cat_id."' ";	
	$rs  = $CI->db->query($sql);
	$sttr = "";
	if($rs->num_rows()>0)
	{
	  foreach($rs->result() as $row)
	  {	
			if($row->i_parent_id>0)
			{
				$sttr = ' &gt; <span>'.$row->s_category.'</span>';
				$sttr = get_category_breadcrumb($row->i_parent_id).$sttr;
			}
			else
			{
				$sttr = '<span>'.$row->s_category.'</span>';
			}			
	  }
	  
	}
	
	return $sttr;
}

// Call get_cat_result('', '', '', '1', encrypt($opt_cat),2);
function get_cat_result($option_results='', $current_cat_id=0, $count=0, $show_child=-1, $selected_cat_id=-1, $depth=-1)
{
	$CI = &get_instance();
	if (!isset($current_cat_id))
		$current_cat_id = 0;
	
	$current_cat_id = $current_cat_id == '' ? 0 : $current_cat_id;
	
	$sub_cond   = '';
	$count = $count+1;
	
	$sql = "SELECT i_id, s_category FROM cd_category 
				WHERE i_parent_id = {$current_cat_id} AND i_status = 1 ORDER BY s_category ASC ";
	$get_options_obj = $CI->db->query($sql);
	$get_options_arr = $get_options_obj->result_array();
	
	if(count($get_options_arr))
	{
		foreach($get_options_arr as $key => $value)
		{
			if($current_cat_id != 0)
			{
				$indent_flag = "";
				for ($x = 2; $x <= $count; $x++)
					$indent_flag .= "&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			$cat_name = isset($indent_flag) ? $indent_flag : '';
			//$cat_name .= substr_replace($value['s_category'],'...', 22);
			$cat_name .= $value['s_category'];
			$select = '';
			if($selected_cat_id == encrypt($value['i_id']))
				$select = 'selected="selected"';
			$option_results .= '<option '.$select.' value="'.encrypt($value['i_id']).'">&nbsp;'.$cat_name.'</option>';
			if($show_child > 0 && ($depth <0 ||($depth > 0 && $count <= $depth)))
			{
				$option_results = get_cat_result($option_results, $value['i_id'], $count, $show_child , $selected_cat_id, $depth);
			}
		}
	}
	return $option_results;	
}


// Call get_cat_result('', '', '', '1', encrypt($opt_cat),2);
function get_travel_cat_result($option_results='', $current_cat_id=0, $count=0, $show_child=-1, $selected_cat_id=-1, $depth=-1)
{
	$CI = &get_instance();
	if (!isset($current_cat_id))
		$current_cat_id = 0;
	
	$current_cat_id = $current_cat_id == '' ? 0 : $current_cat_id;
	
	$sub_cond   = '';
	$count = $count+1;
	
	$sql = "SELECT i_id, s_category FROM cd_category_travel 
				WHERE i_parent_id = {$current_cat_id} AND i_status = 1 ORDER BY s_category ASC ";
	$get_options_obj = $CI->db->query($sql);
	$get_options_arr = $get_options_obj->result_array();
	
	if(count($get_options_arr))
	{
		foreach($get_options_arr as $key => $value)
		{
			if($current_cat_id != 0)
			{
				$indent_flag = "";
				for ($x = 2; $x <= $count; $x++)
					$indent_flag .= "&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			$cat_name = isset($indent_flag) ? $indent_flag : '';
			//$cat_name .= substr_replace($value['s_category'],'...', 22);
			$cat_name .= $value['s_category'];
			$select = '';
			if($selected_cat_id == encrypt($value['i_id']))
				$select = 'selected="selected"';
			$option_results .= '<option '.$select.' value="'.encrypt($value['i_id']).'">&nbsp;'.$cat_name.'</option>';
			if($show_child > 0 && ($depth <0 ||($depth > 0 && $count <= $depth)))
			{
				$option_results = get_travel_cat_result($option_results, $value['i_id'], $count, $show_child , $selected_cat_id, $depth);
			}
		}
	}
	return $option_results;	
}