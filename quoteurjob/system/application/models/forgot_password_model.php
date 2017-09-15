<?php
/*********
* Author: Mrinmoy Modal
* Date  : 22 Sept 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For Region
* 
* @package User
* @subpackage Access Control
* 
* @includes infModel.php 
* @includes MY_Model.php
* 
* @link MY_Model.php
*/
class Forgot_password_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl=$this->db->USER;  
		  $this->tbl_user =   $this->db->USERMANAGE;       
          $this->conf=&get_config();
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
    * @param string $s_order_by, Column names to be ordered ex- " dt_created_on desc,i_is_deleted asc,id asc "
    * @returns array
    */
    public function fetch_multi($s_where=null,$i_start=null,$i_limit=null,$s_order_by=null)
    {}
    
	/****
    * Fetch Total records
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @returns int on success and FALSE if failed 
    */
    public function gettotal_info($s_where=null)
    {}     
    
    /*******
    * Fetches One record from db for the id value.
    * 
    * @param int $i_id
    * @returns array
    */
    public function fetch_this($i_id)
    {}
	
	///***Fetching User Name from table ****///
	public function fetch_name($s_where=null)
	{
		 try
        {
          	$s_qry = "SELECT s_first_name,s_last_name FROM ".$this->db->USER." ".$s_where;	          
			$rs=$this->db->query($s_qry);
			if(is_array($rs->result()))
			{
			  foreach($rs->result() as $row)
			  {				 
				  $ret_["s_username"]=get_unformatted_string($row->s_first_name).''.get_unformatted_string($row->s_last_name); 
			  }    
			  $rs->free_result();          
			}
			unset($s_qry,$rs,$row,$s_where);
          	return $ret_;			
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
    {}            

    /***
    * Update records in db. As we know the table name 
    * we will not pass it into params.
    * 
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @param int $i_id, id value to be updated used in where clause
    * @returns $i_rows_affected  on success and FALSE if failed 
    */
    public function edit_info($info,$i_id)
    {}      
    /******
    * Deletes all or single record from db. 
    * For Master entries deletion only change the flag i_is_deleted. 
    *
    * @param int $i_id, id value to be deleted used in where clause 
    * @returns $i_rows_affected  on success and FALSE if failed 
    * 
    */
    public function delete_info($i_id)
    {}      

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
	
	  /*******
    * Forgot password added by Arnab Biswas starts here
    * 
    * @param int $i_id
    * @returns array
    */
    public function change_password($s_where=null,$org_changed_pass)
    {
        try
        {
          $ret_=array();
		   $i_ret_=0;////Returns false
		  /////Generating Random number and Added the salt value with the password///
		  $changed_pass	= 	md5($org_changed_pass.$this->conf["security_salt"]);
		  ////Using Prepared Statement///			
			$s_qry = "UPDATE ".$this->db->USER." SET s_password='".$changed_pass."'  ".$s_where;				
                $this->db->trans_begin();///new  
                $this->db->query($s_qry);
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                   /* $logi["msg"]="Updating ".$this->db->USER." ";
                    $logi["sql"]= serialize(array($s_qry, array($s_where)) ) ;
                    $this->log_info($logi); 
                    unset($logi);*/
                    $this->db->trans_commit();///new   
                }
                else
                {
                    $this->db->trans_rollback();///new
                }
			unset($s_qry);	
			return $i_ret_;	
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    } 
	///**Forgot password ends**//    
	
	
	 /*******
    * Forgot password for frontend user added by Arnab Biswas starts here
    * 
    * @param int $i_id
    * @returns array
    */
    public function change_password_front_user($s_where=null,$org_changed_pass)
    {
        try
        {
          $ret_=array();
		   $i_ret_=0;////Returns false
		  /////Generating Random number and Added the salt value with the password///
		  $changed_pass	= 	md5($org_changed_pass.$this->conf["security_salt"]);
		  ////Using Prepared Statement///			
			$s_qry = "UPDATE ".$this->db->USERMANAGE." SET s_password='".$changed_pass."'  ".$s_where;				
                $this->db->trans_begin();///new  
                $this->db->query($s_qry);
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                   /* $logi["msg"]="Updating ".$this->db->USER." ";
                    $logi["sql"]= serialize(array($s_qry, array($s_where)) ) ;
                    $this->log_info($logi); 
                    unset($logi);*/
                    $this->db->trans_commit();///new   
                }
                else
                {
                    $this->db->trans_rollback();///new
                }
			unset($s_qry);	
			return $i_ret_;	
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    } 
	///**Forgot password ends**//   
	
	///***Fetching User Name from table ****///
	public function fetch_name_front_user($s_where=null)
	{
		 try
        {
          	$s_qry = "SELECT s_name,s_username FROM ".$this->db->USERMANAGE." ".$s_where;	          
			$rs=$this->db->query($s_qry);
			if(is_array($rs->result()))
			{
			  foreach($rs->result() as $row)
			  {				 
				  $ret_["s_name"]=get_unformatted_string($row->s_name); 
				  $ret_["s_username"]=get_unformatted_string($row->s_username); 
			  }    
			  $rs->free_result();          
			}
			unset($s_qry,$rs,$row,$s_where);
          	return $ret_;			
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
	}	      
	
	
	///***Fetching User Name from table ****///
	public function fetch_front_user_detail($s_where=null)
	{
		 try
        {
          	$s_qry = "SELECT s_name,s_username,i_signup_lang FROM ".$this->db->USERMANAGE." ".$s_where;	          
			$rs=$this->db->query($s_qry);
			if(is_array($rs->result()))
			{
			  foreach($rs->result() as $row)
			  {				 
				  $ret_["s_name"]=get_unformatted_string($row->s_name); 
				  $ret_["s_username"]=get_unformatted_string($row->s_username); 
				  $ret_["i_signup_lang"]=intval($row->i_signup_lang); 
			  }    
			  $rs->free_result();          
			}
			unset($s_qry,$rs,$row,$s_where);
          	return $ret_;			
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
	}	
	               

    public function __destruct()
    {} 
}
/////end of class