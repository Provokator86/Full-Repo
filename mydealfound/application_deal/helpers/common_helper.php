<?php

require 'xml2array.php';

/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */

function pr($param,$is_exit = FALSE) 
{
    echo '<pre>';

    print_r($param);

    echo '</pre>';

    if($is_exit)

        exit();
}


function make_my_url($s_string='')
{
 try
 {
  if($s_string == '') return '';
  $s_string = preg_replace('/([^a-z0-9A-Z])/i','-',$s_string);
  
  $mix_matches = array();
  preg_match('/(.+?)(\.[^.]*$|$)/', trim($s_string), $mix_matches);
  unset($s_filename);
  
  $entities = array("^"," ",".","~","!", "*", "'","_", "(", ")", ";", ":", "@","&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
  $s_new_filename = str_replace($entities,"-",$mix_matches[1]);
  $s_new_filename = preg_replace('/[-]{2,}/','-',$s_new_filename);
  return mb_strtolower(trim($s_new_filename,'-'),'UTF-8');
 }
 catch(Exception $err_obj)
 {
  show_error($err_obj->getMessage());
 }
}


function forum_feeds(){

	$xmlToArryObj = new XML_Array();

	$feedsArray = array();        

	$arrayData = $xmlToArryObj->xml_to_array(file_get_contents('http://mydeal.acumencs.com/forum/feed.php?'));	

	foreach($arrayData['feed']['_child']['entry'] as $key=>$entry){

		$feedsArray[$key]['title'] = $entry['_child']['title']['_value'];

		$feedsArray[$key]['content'] = $entry['_child']['content']['_value'];

		$feedsArray[$key]['link'] = $entry['_child']['link']['_attribute']['href'];

	}
	return $feedsArray;
}


function genRandomUserId() 
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
	$sql = "SELECT * FROM cd_user WHERE s_uid='".$final_string."'";
	$query=$CI->db->query($sql);
	if($query->num_rows()>0)
	{
		 genRandomUserId();
	}
	else	
	 return $final_string;
	}
	

/* generate an random code for activation mail after registration
* 3 Apr 2014
*/	
function genActivationCode() 
{	
	$CI = & get_instance();
	$num_length = 10;
	$char_length = 10;
	$char = "abcdefghijklmnopqrstuvwxyz1234567890";
	$characters = '1234567890abcdefghijklmnopqrstuvwxyz';
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
	$final_string = $string1.$string;
	$sql = "SELECT * FROM cd_user WHERE s_activation_code='".$final_string."'";
	$query=$CI->db->query($sql);
	if($query->num_rows()>0)
	{
		 genActivationCode();
	}
	else	
	 return $final_string;
	}


	/************* functions on 22Mar 2014 ***************/
	 
	function update_category_count($parent_id=0) 
	{	
		$CI = & get_instance();
		$sql = "SELECT i_id,i_parent_id FROM cd_category WHERE i_parent_id = '".$parent_id."' ";	
		$rs  = $CI->db->query($sql);
		$rs->num_rows();
		if($rs->num_rows()>0)
		{
		  foreach($rs->result() as $row)
		  {
		  	
		  	$cat_id = $row->i_id;
			$parent_cat_id = $row->i_parent_id;
			
			update_category_count($cat_id);
			
			$sql2 = "UPDATE cd_category c  SET  i_total_product = (SELECT count(*) FROM cd_coupon p 
WHERE p.i_cat_id='".$cat_id."' ) WHERE c.i_id='".$cat_id."' ";
			$rs  = $CI->db->query($sql2);
			
			$total_product = "SELECT SUM(i_total_product) AS total_product FROM cd_category c WHERE c.i_parent_id='".$cat_id."' ";
			$rs2  = $CI->db->query($total_product);
			//print_r($rs2);
			$total_product_count= 0;
			
			if($rs2->num_rows()>0)
			{
			  foreach($rs2->result() as $row)
			  {
				  $total_product_count=intval($row->total_product); 
			  }   
			  $rs2->free_result(); 
			}
			$total_product_count;
			$sql = "UPDATE cd_category  SET i_total_product = i_total_product+'".$total_product_count."' WHERE i_id = '".$cat_id."' ";
			
			$rs  = $CI->db->query($sql);
			//echo $cat_id.'</br>';
			
		  }
		}
		else
		{
			//echo 'there';
			$sql = "UPDATE cd_category c  SET  i_total_product = (SELECT count(*) FROM cd_coupon p 
WHERE p.i_cat_id='".$parent_id."' ) WHERE c.i_id = '".$parent_id."' ";
			$rs  = $CI->db->query($sql);
			//return 5;
		}
    }
	
	function select_product_under_category($cat_id=0) 
	{	
		$CI = & get_instance();
		$sql = "SELECT i_id FROM cd_category WHERE i_parent_id = '".$cat_id."' ";	
		$rs  = $CI->db->query($sql);
		$sttr = "";
		if($rs->num_rows()>0)
		{
		  foreach($rs->result() as $row)
		  {
		  		$sttr = $sttr.','.select_product_under_category($row->i_id);				
		  }
		  
		}
		else
		{
			return $cat_id;
		}
		
		return $cat_id.$sttr;
    }
	
	
	function get_category_id($s_url='') 
	{	
		$CI = & get_instance();
		$sql = "SELECT i_id FROM cd_category WHERE s_url = '".addslashes(trim($s_url))."' ";	
		$rs  = $CI->db->query($sql);
		$cat_id = "";
		if($rs->num_rows()>0)
		{
		  foreach($rs->result() as $row)
		  {
		  		$cat_id = $row->i_id;				
		  }
		  
		}
		
		return $cat_id;
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
		  			$sttr = ' > <a class="last"  href="'.base_url().'category/'.$row->s_url.'">'.$row->s_category.'</a>';
					$sttr = get_category_breadcrumb($row->i_parent_id).$sttr;
				}
				else
				{
					$sttr = '<a href="'.base_url().'category/'.$row->s_url.'">'.$row->s_category.'</a>';
				}			
		  }
		  
		}
		
		return $sttr;
    }
	
/*
+-----------------------------------------------+
| select category in travel_category 	|
+-----------------------------------------------+
| Added by Mrinmoy Mondal 		|
+-----------------------------------------------+
*/
	
	function select_travel_under_category($cat_id=0) 
	{	
		$CI = & get_instance();
		$sql = "SELECT i_id FROM cd_category_travel WHERE i_parent_id = '".$cat_id."' ";	
		$rs  = $CI->db->query($sql);
		$sttr = "";
		if($rs->num_rows()>0)
		{
		  foreach($rs->result() as $row)
		  {
		  		$sttr = $sttr.','.select_travel_under_category($row->i_id);				
		  }
		  
		}
		else
		{
			return $cat_id;
		}
		
		return $cat_id.$sttr;
    }
	
	/*
+-----------------------------------------------+
| Set congfiguration for front end pagination 	|
+-----------------------------------------------+
| Added by Mrinmoy Mondal 		|
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
	$config['prev_link'] = '&laquo;';
	$config['next_link'] = '&raquo;';
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


	/************* functions on 22Mar 2014 ***************/

function now()
{
	 $CI = &get_instance();
	 
	 $sql = "SELECT NOW() AS my_date_time";
	 $query  =   $CI->db->query($sql);
	 $rslt   =   $query->row_array();
	 return $rslt['my_date_time']; 
}

function string_part($str,$limit=20)
{
	//$limit=20;
	$n_str =  explode(' ',substr($str,0,$limit));
	if(count($n_str)>1)
	{
		array_pop($n_str);
		$f_str = implode(' ', $n_str).'...';
	}
	else
	{
		$f_str = implode(' ',$n_str);
	}
	return $f_str;
}

function exclusive_strip_tags($str)
{
	$str = strip_tags($str);
	return preg_replace('/[\s]{2,}/', ' ', $str); 
}

function get_commnets_for_this_store($id,$order_by='dt_entry_date',$order='DESC')
{
    $CI = &get_instance();
    $res = $CI->db->query("SELECT * FROM ".$CI->db->STORE_COMMENT. " WHERE i_store_id ='".intval($id)."' AND i_is_active=1 ORDER BY {$order_by} {$order}" );
    return $res->result_array();      
}

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

/* 
*  for stores drop down 
** mrinmoy 7Mar 2014
****/

function makeOptionStores($s_id = '')
{
    try
	{
		$CI = &get_instance();
		$res = $CI->db->query("select i_id, s_store_title from {$CI->db->STORE} WHERE i_id != 0 ORDER BY s_store_title ASC ");
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

function getStoreUrls($s_id = '')
{
    try
	{
		$CI = &get_instance();
		$res = $CI->db->query("select i_id, s_url from {$CI->db->STORE} WHERE i_id = {$s_id} ");
		$mix_value = $res->result_array();
		$s_name = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_name = $val["s_url"];
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

function get_travel_category_breadcrumb($cat_id=0) 
	{	
		$CI = & get_instance();
		$sql = "SELECT i_id,s_url,s_category,i_parent_id FROM cd_category_travel WHERE i_id = '".$cat_id."' ";	
		$rs  = $CI->db->query($sql);
		$sttr = "";
		if($rs->num_rows()>0)
		{
		  foreach($rs->result() as $row)
		  {	
		  		if($row->i_parent_id>0)
				{
		  			$sttr = ' > <a class="last"  href="'.base_url().'category/'.$row->s_url.'">'.$row->s_category.'</a>';
					$sttr = get_travel_category_breadcrumb($row->i_parent_id).$sttr;
				}
				else
				{
					$sttr = '<a href="'.base_url().'category/'.$row->s_url.'">'.$row->s_category.'</a>';
				}			
		  }
		  
		}
		
		return $sttr;
    }

function getTravelCategoryName($cat_id='')
{
	$CI = &get_instance();
	$ret_=0;
	if($cat_id!='')        
	{
		$sql = "SELECT s_category FROM cd_category_travel WHERE i_id ='".$cat_id."' "; 
		$rs=$CI->db->query($sql); 
		$res = $rs->result_array();
		$ret_ = $res[0]["s_category"];			
	}
	return $ret_;
}

function getTravelCategoryUrl($cat_id='')
{
	$CI = &get_instance();
	$ret_=0;
	if($cat_id!='')        
	{
		$sql = "SELECT s_url FROM cd_category_travel WHERE i_id ='".$cat_id."' "; 
		$rs=$CI->db->query($sql); 
		$res = $rs->result_array();
		$ret_ = $res[0]["s_url"];			
	}
	return $ret_;
}

function getCategoryPath($parent_id='',$cat_name='')
{
	$CI = &get_instance();
	$ret_ = false;
	if(!$parent_id)
		$ret_ = $cat_name;
	else
	{
		$pc_name = getCategoryName($parent_id);
		$ret_ = $pc_name.' > '.$cat_name;
	}
	return $ret_;
}

function getCategoryName($cat_id='')
{
	$CI = &get_instance();
	$ret_=0;
	if($cat_id!='')        
	{
		$sql = "SELECT s_category FROM cd_category WHERE i_id ='".$cat_id."' "; 
		$rs=$CI->db->query($sql); 
		$res = $rs->result_array();
		$ret_ = $res[0]["s_category"];			
	}
	return $ret_;
}

function getCategoryUrl($cat_id='')
{
	$CI = &get_instance();
	$ret_=0;
	if($cat_id!='')        
	{
		$sql = "SELECT s_url FROM cd_category WHERE i_id ='".$cat_id."' "; 
		$rs=$CI->db->query($sql); 
		$res = $rs->result_array();
		$ret_ = $res[0]["s_url"];			
	}
	return $ret_;
}


function UpdateCategoryUrl()
{
	$CI = &get_instance();
	
	$sql = "SELECT i_id,s_category FROM cd_category WHERE s_url='' "; 
	$rs=$CI->db->query($sql); 
	if($rs->num_rows()>0)
	{
	  foreach($rs->result() as $row)
	  {
	  		$s_url = getSeoUrl('cd_category',$row->s_category);
			$sql = "UPDATE cd_category SET s_url = '".$s_url."' WHERE i_id = '".$row->i_id."' ";	
			$rs=$CI->db->query($sql); 			
	  }
	  
	}			
	
}

function getSeoUrl($table,$url,$id='',$i=0)
{
	 $CI = &get_instance();
	
	 $ret = $url;
	 $furl = $url;
	
	  $splsearch = array(",",".","@","~","`","!","%","$","#","&","*","(",")",":",";"," ","'","Æ","Ø","Å","æ","Ã†","Ã¦");
	  $splreplace = array("","","","","","","","","","","","","","","","-","","ae","oe","aa","ae","ae","ae");
	
	  $furl 	= str_replace($splsearch,$splreplace,$furl); 
	  $furl		= strtolower(preg_replace('/\-+/', '-', $furl));
	 
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

