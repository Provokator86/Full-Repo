<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 29 march 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For manage_private_message
* 
* @package Content Management
* @subpackage manage_private_message
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/manage_private_message.php
* @link views/admin/manage_private_message/
*/

/************** This model to be deleted.............. ******/ 
class Private_message_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
	public $tbl_users;
	public $tbl_jobs;
    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->PMB; 
		  $this->tbl_users = $this->db->MST_USER;
		  $this->tbl_jobs = $this->db->JOBS; 
		 
		  $this->tbl_pmb_details	=	$this->db->PMBDETAILS;
          $this->conf =& get_config();
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
          $ret_=0;
           $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl." n "
				." LEFT JOIN {$this->tbl_jobs} j ON j.id = n.i_job_id "
				." LEFT JOIN {$this->tbl_users} u ON u.id	=	n.i_buyer_id " 
				." LEFT JOIN {$this->tbl_users} us ON us.id	=	n.i_tradesman_id " 
                .($s_where!=""?$s_where:"" )." GROUP BY n.i_job_id";
				//echo $s_qry;
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_=intval($row->i_total); 
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where);
          return $ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }      
	
	
	
    
        
   
    public function add_info($info)
    {
        try
        {
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl." Set ";
                $s_qry.=" s_username=? ";
                $s_qry.=", s_name=? ";
				$s_qry.=", s_email=? ";
				$s_qry.=", s_skype_id=? ";
				$s_qry.=", s_msn_id=? ";
				$s_qry.=", s_yahoo_id=? ";
				$s_qry.=", s_contact_no=? ";
				$s_qry.=", i_province=? ";
				$s_qry.=", i_city=? ";
				$s_qry.=", i_zipcode=? ";
				$s_qry.=", s_lat=? ";
				$s_qry.=", s_lng=? ";
				$s_qry.=", i_role=? ";
				
				$s_qry.=", s_verified=? ";
                $s_qry.=", i_is_active=? ";
                $s_qry.=", i_created_date=? ";
                
                $this->db->query($s_qry,array(
												  trim(htmlspecialchars($info["s_username"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_name"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_email"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_skype_id"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_msn_id"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_yahoo_id"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_contact_no"], ENT_QUOTES, 'utf-8')),
												  intval(decrypt($info["i_province"])),
												  intval(decrypt($info["i_city"])),
												  intval(decrypt($info["i_zipcode"])),
												  trim(htmlspecialchars($info["s_lat"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_lng"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_role"]),
												  
												  intval($info["s_verified"]),
												  intval($info["i_is_active"]),
												  intval($info["i_created_date"])
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  trim(htmlspecialchars($info["s_username"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_name"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_email"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_skype_id"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_msn_id"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_yahoo_id"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_contact_no"], ENT_QUOTES, 'utf-8')),
												  intval(decrypt($info["i_province"])),
												  intval(decrypt($info["i_city"])),
												  intval(decrypt($info["i_zipcode"])),
												  trim(htmlspecialchars($info["s_lat"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_lng"], ENT_QUOTES, 'utf-8')),
												  intval(decrypt($info["i_role"])),
												  
												  intval($info["s_verified"]),
												  intval($info["i_is_active"]),
												  intval($info["i_created_date"])
												 )) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }
            }
            unset($s_qry, $info );
            return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }    
	
	
	/* insert data when no pmb exist */
	
	        

    /***
    * Update records in db. As we know the table name 
    * we will not pass it into params.
    * 
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @param int $i_id, id value to be updated used in where clause
    * @returns $i_rows_affected  on success and FALSE if failed 
    */
    public function edit_info($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";	               
                $s_qry.=" s_message=? ";
				$s_qry.=", i_status=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(
												  
												  get_unformatted_string($info["s_message"]),
												  intval($info["i_status"]),
												  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  
												  get_unformatted_string($info["s_message"]),
												  intval($info["i_status"]),
												  intval($i_id)

                                                     )) ) ;                                 
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                                
            }
            unset($s_qry, $info,$i_id);
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
    * @param int $i_id, id value to be deleted used in where clause 
    * @returns $i_rows_affected  on success and FALSE if failed 
    * 
    */
    public function delete_info($i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
    
            if(intval($i_id)>0)
            {
				$s_qry="DELETE FROM ".$this->tbl." ";
                $s_qry.=" Where id=? ";
                $this->db->query($s_qry, array(intval($i_id)) );
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Deleting ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($i_id))) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                           
            }
            elseif(intval($i_id)==-1)////Deleting All
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
            unset($s_qry, $i_id);
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
	
	
	
	/* fetch private message board */
	
	 
	      
	
	
	
	
	
	
	
	
	
	 
	
	

    public function __destruct()
    {}                 
  
  
}
///end of class
?>