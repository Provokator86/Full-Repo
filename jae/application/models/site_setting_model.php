<?php
/*********
* Author: SWI 
* Date  : 11 sept 2017
* Modified By: 
* Modified Date:
* 
* Purpose:
* Model For Site Setting
* 
* @package Site Setting
* @subpackage Site Setting
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/site_setting.php
* @link views/admin/site_setting/
*/


class Site_setting_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl 	= 	$this->db->SITESETTING;        
          $this->conf 	=	&get_config();
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
    public function fetch_multi($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {  
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
    public function gettotal_info($s_where=null)
    {
        try
        {
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }         
    

    /*******
    * Fetches One record from db.
    * 
    * @param blank
    * @returns array
    */
    public function fetch_this($null)
    {
        try
        {
            $ret_=array();
            $s_qry="Select * From {$this->tbl} u ";
            $rs=$this->db->query($s_qry);            
            if($rs->num_rows()==1)
            {
                $info   = $rs->result_array(); 
                $info    = $info[0];
            }    
            unset ($ret_);
            return $info;
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
        { 
        }
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
    * @param int $i_id, id value to be updated used in where clause
    * @returns $i_rows_affected  on success and FALSE if failed 
    */
    //public function edit_info($info,$i_id)
    public function edit_info($arr,$id)
    {
        try
        {
            $cond   = '';
            if(is_array($id))
                $cond   = $id;
            else
                $cond   = array('i_id'=>$id);
            if($this->db->update($this->tbl, $arr, $cond))
                return true;
            else
                return false;                
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
    * @param int $i_id, id value to be deleted used in where clause 
    * @returns $i_rows_affected  on success and FALSE if failed 
    * 
    */
    public function delete_info($i_id)
    {
        try
        { 
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
	
	
    public function __destruct()
    {}                 
  
  
}
///end of class
?>
