<?php
/*********
* Author: Acumen CS
* Date  : 31 Jan 2014
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  Model For Language Management
* 
* @package General
* @subpackage Language Management
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/language_management.php
* @link views/admin/language_management/
*/

class Language_model extends MY_Model
{
    private $conf;
    private $tbl, $tbl_coutnry;//used for this class
    public function __construct()
    {
        try
        {
			parent::__construct();
			$this->tbl = $this->db->LANGUAGE; 
			$this->tbl_coutnry = $this->db->COUNTRY; 
			$this->conf = &get_config();   
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
    public function fetch_multi($s_where = NULL, $i_start = NULL, $i_limit = NULL)
    {
        try
        {
			/*if($s_where) $this->db->where($s_where);
			return $this->db->join($this->tbl_coutnry,$this->tbl_coutnry.'.i_id = '.$this->tbl.'.i_country_id','left')->get($this->tbl, $i_limit, $i_start)->result_array();*/
			if($s_where) $where = 'WHERE '.$s_where;
			$sql = "SELECT l.i_id, l.s_language, l.i_status, c.s_country 
					FROM {$this->tbl} AS l 
					LEFT JOIN {$this->tbl_coutnry} AS c ON c.i_id = l.i_country_id 
					{$where} "
					.(is_numeric($i_start)&& intval($i_start) > 0 ? "LIMIT {$i_start}, {$i_limit}" : '');
			return $this->db->query($sql)->result_array();
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
    public function gettotal_info($s_where = NULL)
    {
        try
        {
			if($s_where) $this->db->where($s_where);
			return $this->db->count_all($this->tbl);
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    } 

    /*******
    * Fetches One record from db for the id value.
    * 
    * @param int $id
    * @returns array
    */
    public function fetch_this($id)
    {
        try
        {
			return $this->db->get_where($this->tbl, array('i_id'=>$id))->result_array();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }       
	
			
		
    /***
    * Inserts new records into db. As we know the table name 
    * we will not pass it into params.
    * 
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @returns $i_new_id  on success and FALSE if failed 
    */
    public function add_info($info)
    {
        try
        {}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }   
	
    /***
    * Update records in db. As we know the table name 
    * we will not pass it into params.
    * 
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @param int $id, id value to be updated used in where clause
    * @returns $i_rows_affected  on success and FALSE if failed 
    */
    public function edit_info($info,$i_id)
    {
        try
        {}
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
    public function delete_info($id)
    {
        try
        {
            $i_ret_=0;//Returns false
    
            if(intval($id)>0)
            {
				$s_qry="DELETE FROM ".$this->tbl." ";
                $s_qry.=" Where i_id=? ";
                $this->db->query($s_qry, array(intval($id)) );
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"] = "Deleting ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($id))) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                           
            }
            elseif(intval($id)==-1)//Deleting All
            {
				$s_qry="DELETE FROM ".$this->tbl." ";
                $this->db->query($s_qry);
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Deleting all information from ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                
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
    * Register a log for add,edit and delete operation
    * 
    * @param mixed $attr
    * @returns TRUE on success and FALSE if failed 
    */
    public function log_info($attr)
    {
        try
        {
            $logindata=$this->session->userdata("admin_loggedin");
            return $this->write_log($attr["msg"],decrypt($logindata["user_id"]),($attr["sql"]?$attr["sql"]:""));
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }
	
	public function check_for_uniqueness($language, $country, $i_id = 0)
	{
		$this->db->where(array('i_country_id'=>$country,'s_language'=>$language));
		if(intval($i_id) > 0)
			$this->db->where('i_id != '.$i_id);
		$tmp = $this->db->select('count(*) as total')->get($this->tbl)->result_array();
		return intval($tmp[0]['total']) > 0? false : true;
	} 
	
    public function __destruct()
    {}                 
  
  
}