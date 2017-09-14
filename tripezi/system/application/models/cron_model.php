<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 23 July 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For Newsletter Subscribers
* 
* @package Email
* @subpackage Newsletter Subscribers
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/newsletter_subscribers.php
* @link views/admin/newsletter_subscribers/
*/


class Cron_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl_email_log;///used for this class

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl_email_log 	= 	$this->db->EMAILLOG;          
          $this->conf 			=	&get_config();
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
          	$ret_=array();
			 $s_qry="SELECT * FROM ".$this->tbl_email_log." n "
                .($s_where!=""?$s_where:"" )." ORDER BY n.dt_posted_in_log ASC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["i_id"]				=	$row->i_id;////always integer s_subject
                  $ret_[$i_cnt]["s_from_email"]		=	get_unformatted_string($row->s_from_email); 
				  $ret_[$i_cnt]["s_to_emails"]		=	get_unformatted_string($row->s_to_emails);
				  $ret_[$i_cnt]["s_subject"]		=	get_unformatted_string($row->s_subject); 
				  $ret_[$i_cnt]["s_body"]			=	$row->s_body;
				  
                  $ret_[$i_cnt]["dt_posted_in_log"]	=	($row->dt_posted_in_log)?($row->dt_posted_in_log):''; 
                 
                  $i_cnt++;
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit, $s_desc);
          return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
	public function delete_email_log($i_id)
	{
		  $sql	=	"DELETE FROM ".$this->tbl_email_log." WHERE i_id = '".$i_id."'";
		 if($this->db->query($sql))
		 {
		 	return TRUE;
		 }
		 return FALSE;
	}
	
	
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
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select * "
                ."From ".$this->tbl." AS n "
                ." Where n.i_id=? ";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_["id"]				=	$row->i_id;////always integer
                  $ret_["s_name"]			=	get_unformatted_string($row->s_name); 
                  $ret_["s_email"]			=	get_unformatted_string($row->s_email);  
                  $ret_["dt_created_on"]	=	date($this->conf["site_date_format"],intval($row->dt_entry_date)); 
				
                  $ret_["i_failure_count"]	= 	intval($row->i_failure_count); 
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_id);
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
	
    public function __destruct()
    {}                 
  
  
}
///end of class
?>