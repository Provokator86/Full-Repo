<?php
/*********
* Author: Acumen CS
* Date  : 30 Jan 2014
* Purpose:
* Model For general curd
* 
* @package 
* @subpackage general insert, update, delete, select
* 
*/


class cs_model extends CI_Model
{
    private $conf;
    
    public function __construct()
    {
        try
        {
			parent::__construct();
			$this->conf = &get_config();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
	// Add info 
	public function add_data($table, $info, $insert_ignore = false)
    {
        try
        {
			
            if(!empty($info))
            {
				$s_qry = $this->db->insert_string($table, $info);
				if($insert_ignore) $s_qry = str_replace('INSERT INTO','INSERT IGNORE INTO',$s_qry);   
                //echo  $s_qry;
				return ($this->db->simple_query($s_qry))? $this->db->insert_id() : 0;
            }
			return false;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
	// Add multiple info at a time using 2D array 
	public function add_multiple_data($table, $info)
    {
        try
        {
            if(!empty($info))
            {
				return $this->db->insert_batch($table, $info);
            }
			return false;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
	// Edit Info
	public function edit_data($table, $info = array(), $where = array(), $affected_rows = false)
	{
		try
		{
			$s_qry = $this->db->update_string($table, $info, $where);
            //echo $s_qry;
			$st = $this->db->simple_query($s_qry);
			if(!$affected_rows)
				return $st;
			else
				return $this->db->affected_rows() > 0 ? TRUE : FALSE;
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	}
	
	// Fetch Info
	public function fetch_data($table, $where = array(), $feild_list = '', $limit = NULL, $offset = NULL)
	{
		try
		{ 			
			if($feild_list != '') $this->db->select($feild_list);
			if(!empty($where) && intval($offset) > 0)
				return $this->db->get_where($table, $where, $limit, $offset)->result_array();
			else if(!empty($where))
				return $this->db->get_where($table, $where)->result_array();
			else
				return $this->db->get($table)->result_array();
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	}
	
    public function fetch_data_new($table, $where = array(), $feild_list = '', $offset = NULL, $limit = NULL, $order_by='', $sort_type ='ASC')
    {
        try
        { 
            if($feild_list != '') $this->db->select($feild_list, false);
            if($order_by!='') $this->db->order_by($order_by, $sort_type);
            
            if($where)
            {
                if(is_array($where))
                    $this->db->where($where);
                else
                    $this->db->where($where, '', false);
            }
            if(intval($limit) > 0)
                return $this->db->get($table, $limit, $offset)->result_array();
            else
                return $this->db->get($table)->result_array();
                
           /* if(!empty($where) && intval($limit) > 0)
                return $this->db->where($where, '', false)->get($table, $limit, $offset)->result_array();
            else if(!empty($where))
                return $this->db->where($where, '', false)->get($table)->result_array();
            else
                return $this->db->get($table)->result_array();*/
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
    }
    
	// Execute Query  and if return_result =true  then returns result set else returns true false 
	public function exc_query($query = '', $return_result = true)
	{
		try
		{
			if($query == '') return '';
			if($return_result)
				return $query != '' ? $this->db->query($query)->result_array() : '';
			else
				return $this->db->simple_query($query);
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	
	}
	
	/****
    * Fetch Total records
    * @param string @s_table_name 
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @returns int on success and FALSE if failed 
    */
    public function count_info($s_table_name,$arr_where = NULL)
    {
        try
        {
			return count($this->db->get_where($s_table_name,$arr_where)->result_array()); // CI function to fetch data
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    } 
	
	public function count_info_new($s_table_name, $arr_where = NULL, $alias = '')
    {
        try
        {
            $tmp = $this->db->select('count('.$alias.'i_id) AS total', false)->where($arr_where,'',false)->get($s_table_name)->result_array(); 
            return intval($tmp[0]['total']);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }
	// Delete Info
	public function delete_data($table, $where = array())
	{
		try
		{
			return $this->db->delete($table, $where)? TRUE : FALSE;
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	}
	
	// fetch Info By table
	public function fetch_this($table,$field,$id, $s_order_by = '')
    {
        try
        {
			//echo ("SELECT n.* FROM {$table} AS n WHERE n.{$field} = {$id}")	;	
			//Using Prepared Statement//
			//return $this->db->query("SELECT n.*,'1' FROM {$table} AS n WHERE n.{$field} = 'TX'",array(intval($id)))->result_array();
			//return $this->db->query("SELECT n.* FROM {$table} AS n WHERE n.{$field} = ?",array(intval($id)))->result_array();
            return $this->db->query("SELECT n.* FROM {$table} AS n WHERE n.{$field} = ".(intval($id))." ".$s_order_by)->result_array();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	// Fetch Like
	public function fetch_like_this($table,$field,$val)
    {
        try
        {	
			//Using Prepared Statement//
			return $this->db->query("SELECT n.* FROM {$table} AS n WHERE n.{$field} LIKE '".$val."%'")->result_array();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	// Fetch Like
	public function fetch_like_multiple($table,$field_value=array())
    {
        try
        {	
			//Using Prepared Statement//
			
			$sql = "SELECT n.* FROM {$table} AS n WHERE 1 AND i_sale_type ='R' AND ";
			
			if(!empty($field_value)){
				$ind = 0;		
				$sql .=	"(";	
				foreach($field_value as $field=>$value){			
				$sql .= ($ind == 0)? (" ".$field . " LIKE '".$value."%'") : (" OR ".$field . " LIKE '".$value."%'");
				$ind++;					
				}
				$sql .=	")";	
			}
			
			return $this->db->query($sql)->result_array();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	// Fetch Like
	public function fetch_equ_this($table,$field,$val)
    {
        try
        {	
			//Using Prepared Statement//           
			return $this->db->query("SELECT n.* FROM {$table} AS n WHERE n.{$field} = '".$val."'")->result_array();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	
	
	/******
    * This method will fetch all records from the db. 
    * 
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @param int $i_start, starting value for pagination
    * @param int $i_limit, number of records to fetch used for pagination
    * @returns array
    */
    public function fetch_multi($table = NULL,$s_where = NULL, $i_start = NULL, $i_limit = NULL, $s_order_by = 'ORDER BY i_id DESC')
    {
        try
        {
			$s_qry = "SELECT n.* FROM {$table} AS n "					
					 ."{$s_where} {$s_order_by} "
					 .(is_numeric($i_start) && is_numeric($i_limit)?" LIMIT ".intval($i_start).",".intval($i_limit):"");
			return $this->db->query($s_qry)->result_array();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
	public function fetch_multi_join($table1 = NULL,$table2 = NULL,$s_where = NULL,$s_join = NULL, $t2_value = NULL,$i_start = NULL, $i_limit = NULL)
    {
        try
        {
			$s_qry = "SELECT n.*,{$t2_value} FROM {$table1} AS n 
					  LEFT JOIN {$table2} AS t2 {$s_join} {$s_where} ORDER BY i_id DESC "
					 .(is_numeric($i_start) && is_numeric($i_limit)?" LIMIT ".intval($i_start).",".intval($i_limit):"");
			return $this->db->query($s_qry)->result_array();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
	/****
    * Fetch Total records
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @returns int on success and FALSE if failed 
    */
    public function gettotal_info($table=NULL,$s_where=NULL)
    {
        try
        {
			$s_qry = "SELECT COUNT(i_id) as i_total FROM ".$table." n "
					 .($s_where!=""?$s_where:"" );
			$rs = $this->db->query($s_qry)->result_array();
          	return $rs[0]['i_total'];
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    } 
	
    /*
    Max ID        
    */
    public function slect_max_id($table=NULL)  {
        
        try{
        
        $s_qry = "SELECT max(i_id) as max_id FROM ".$table;
        $rs = $this->db->query($s_qry)->result_array();
        return $rs[0]['max_id']+1;   
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }  
        
    }
    
    
	/*
	+-----------------------------------------------------------------------------------------------------------------------+
	| Name: permormed_formatted_join																						|
	| 		It fetch all the table's column(field) from database and find the matching and if find any column name is 	 	| 		
	|		comflicting then rename that field name with that paeticular table alias as prefix(i.e alias_field_name).		|
	|		Then generate the query, execute it and return the result as array.												|
	+-----------------------------------------------------------------------------------------------------------------------+
	| Param: ($table_details = array[][], $where)																			|
	|		 $table_details = array(																						|
	|								array(																					|
	|										'alias'=>'t1', 																	|
	|										'name'=>'table1', 																|
	|										'condition'=>''																	|
	|									 ),																					|
	|								array(																					|
	|										'alias'=>'t2', 																	|
	|										'name'=>'table2',																| 
	|										'condition'=>'ON t2.feild_name = t1.feild_name AND t2.feild_name = value'		|
	|									  ),																				|
	|								....																					|
	|						        );																						|
	|		 $where = " WHERE alias.field_name = condition 																	|
	|					[OREDER BY alias.field_name ASC/DESC]																|
	|					[GROUP BY alias.field_name]																			|
	|					[LIMIT start, offest]";																				|
	+-----------------------------------------------------------------------------------------------------------------------+
	| Return: result array();																								|
	+-----------------------------------------------------------------------------------------------------------------------+										
	*/
	
	function performed_formatted_join($table_details  = array(), $where = NULL)
	{
		if(empty($table_details))
			return;
		
		// Get all the table column name as array
		for($i = 0; $i<count($table_details); $i++)
		{
			$fields[$i] = $this->db->list_fields($table_details[$i]['name']);
		}
		
		// Finding the match and rename that field
		for($j = 0; $j < count($table_details); $j++)
		{
			for($k = 0; $k < count($fields[$j]); $k++)
			{
				for($l = $j+1; $l < count($fields); $l++)
				{
					for($m = 0; $m < count($fields[$l]); $m++)
					{
						if($fields[$j][$k] == $fields[$l][$m])
							$fields[$j][$m] = $fields[$l][$m].' AS '.$table_details[$l]['alias'].'_'.$fields[$l][$m];
					}
				}
			}
		}
		
		// Generating all the fields to be select
		$selects_fields = '';
		for($n = 0; $n < count($fields); $n++)
		{
			$tmp = implode(",{$table_details[$n]['alias']}.", $fields[$n]);
			$tmp = $table_details[$n]['alias'].'.'.$tmp;
			$selects_fields .=  $selects_fields != '' ? ','.$tmp : $tmp;
		}
		
		// Generating query
		$query = "SELECT {$selects_fields}
					FROM {$table_details[0]['name']} AS {$table_details[0]['alias']} ";
		for($o = 1; $o < count($table_details); $o++)
		{
			$query .= "LEFT JOIN {$table_details[$o]['name']} AS {$table_details[$o]['alias']} {$table_details[$o]['condition']} ";
		}			
		$query .= $where;			
					
		// Getting result
		$rs = $this->db->query($query);
		unset($i, $j, $k, $l, $m, $n, $o, $tmp, $table_details, $query, $fields, $selects_fields);
		return $rs->result_array();
	}
  
  
  	public function change_status($table,$info,$i_id)
    {
        try
        {
            $i_ret_=0;//Returns false
            if(!empty($info))
            {              
				$s_key = array_keys($info);
				$s_qry	=	"Update ".$table." Set ";
				$s_qry.=	 $s_key[0] ." = ? ";
				$s_qry.=	" Where i_id=? ";
				//echo $i_id.$info['i_is_active'];
				$i_ret_=$this->db->query($s_qry,array(	intval($info[$s_key[0]]),
				intval($i_id)
				));                                         
            }
            unset($s_key,$s_qry, $info,$i_id);
            return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    } 
	
	/******
    * Deletes all or single record from db. 
    * For Master entries deletion only change the flag i_is_deleted. 
    *
    * @param int $id, id value to be deleted used in where clause 
    * @returns $i_rows_affected  on success and FALSE if failed 
    * 
    */
    public function delete_info($table,$id)
    {
        try
        {
            $i_ret_=0;//Returns false
    
            if(intval($id)>0)
            {
				$s_qry="DELETE FROM ".$table." ";
                $s_qry.=" Where i_id=? ";
                $this->db->query($s_qry, array(intval($id)) );
                $i_ret_=$this->db->affected_rows();        
                                          
            }
            elseif(intval($id)==-1)//Deleting All
            {
				$s_qry="DELETE FROM ".$table." ";
                $this->db->query($s_qry);
                $i_ret_=$this->db->affected_rows();       
                  
            }
            unset($s_qry, $id);
            return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }
    
    /****
    * It is  mainly used to create option array values
    ***/
    
    public function get_all_list($table, $where = '' , $feild_list = '', $order_by = '', $type = '')
    {
        //echo "SELECT {$feild_list} FROM {$table} WHERE $where ORDER BY {$order_by} {$type}<br><br>";
        $rs = $this->db->query("SELECT {$feild_list} FROM {$table} WHERE {$where} ORDER BY {$order_by} {$type}")->result_array();
        //echo $this->db->last_query();
        $field_name = explode(',',$feild_list);
        for($i = 0; $i <count($rs); $i++)
            $ret[$rs[$i][$field_name[0]]] = ucfirst($rs[$i][$field_name[1]]);
        return $ret;
    }
	
    public function __destruct()
    {} 
}
//end of class
?>