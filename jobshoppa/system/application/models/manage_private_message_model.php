<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 21 Sep 2011
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


class Manage_private_message_model extends MY_Model implements InfModel
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
		  $this->tbl_users = $this->db->USERMANAGE;
		  $this->tbl_jobs = $this->db->JOBS; 
		  
		  //$this->tbl_pmb			=	$this->db->PMB;
		  $this->tbl_pmb_details	=	$this->db->PMBDETAILS;
          $this->conf =& get_config();
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
			$s_qry="SELECT u.s_name as SENDER_NAME,us.s_name as RECEIVER_NAME,j.s_title,n.* FROM ".$this->tbl." n "
				." LEFT JOIN {$this->tbl_jobs} j ON j.id = n.i_job_id "
				." LEFT JOIN {$this->tbl_users} u ON u.id	=	n.i_buyer_id " 
				." LEFT JOIN {$this->tbl_users} us ON us.id	=	n.i_tradesman_id " 
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          
		  $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
				  $ret_[$i_cnt]["s_message"]			=	get_unformatted_string($row->s_message); 
				  
				  $ret_[$i_cnt]["s_job_title"]			=	get_unformatted_string($row->s_title); 
				  
				  $ret_[$i_cnt]["s_sender_user"]		=	get_unformatted_string($row->SENDER_NAME); 
				  $ret_[$i_cnt]["s_receiver_user"]		=	get_unformatted_string($row->RECEIVER_NAME); 				  
				  
				  
                  $ret_[$i_cnt]["dt_created_on"]		=	date($this->conf["site_date_format"],intval($row->i_created_date));
				  $ret_[$i_cnt]["i_status"]				=	intval($row->i_status); 
				  $ret_[$i_cnt]["s_status"]				=	$this->db->PMBSTATUS[$row->i_status];
                  
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
                .($s_where!=""?$s_where:"" );
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
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit);
          return $ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }   
	
	public function gettotal_msg_info($s_where)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl_pmb_details." n "
                .($s_where!=""?$s_where:"" );
	
          $rs=$this->db->query($s_qry);
		  //echo $this->db->last_query(); exit;
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_=intval($row->i_total); 
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit);
          return $ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    } 
	
	/////////////////////for total msgs by job////////////
	public function gettotal_msg_by_job($s_where,$s_groupby)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl_pmb_details." n LEFT JOIN ".$this->tbl." mb  ON n.i_msg_board_id = mb.id"
                .($s_where!=""?$s_where:"" ).($s_groupby!=""?$s_groupby:"" );
				
          $rs=$this->db->query($s_qry);
		  //echo $this->db->last_query(); exit;
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_=intval($row->i_total); 
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$s_groupby);
          return $ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }   
	
	
	/* total message count for pmb*/
	public function total_msg_count($s_where)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl_pmb_details." pd "
                .($s_where!=""?$s_where:"" );
				
          $rs=$this->db->query($s_qry);
		  //echo $this->db->last_query(); exit;
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_=intval($row->i_total); 
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit);
          return $ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    } 
	
	
	
	
	
	
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
          $s_qry="Select u.s_name as SENDER_NAME,u.s_email as SENDER_MAIL,us.s_name as RECEIVER_NAME,us.s_email as RECEIVER_MAIL,j.s_title,n.* "
                ."From ".$this->tbl." AS n "
				." LEFT JOIN {$this->tbl_jobs} j ON j.id = n.i_job_id "
				." LEFT JOIN {$this->tbl_users} u ON u.id	=	n.i_buyer_id " 
				." LEFT JOIN {$this->tbl_users} us ON us.id	=	n.i_tradesman_id " 
                ." Where n.id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]=$row->id;////always integer
                  $ret_["s_message"]			=	get_unformatted_string($row->s_message); 
				  $ret_["s_job_title"]			=	get_unformatted_string($row->s_title); 
				  
				  $ret_["s_sender_user"]		=	get_unformatted_string($row->SENDER_NAME); 
				  $ret_["s_receiver_user"]		=	get_unformatted_string($row->RECEIVER_NAME); 
				  $ret_["s_sender_user_email"]	=	get_unformatted_string($row->SENDER_MAIL);  
				 
				  $ret_["s_receiver_user_email"]=	get_unformatted_string($row->RECEIVER_MAIL);
				  
				  
                  $ret_["dt_created_on"]		=	date($this->conf["site_date_format"],intval($row->i_created_date)); 
				  $ret_["i_status"]				=	intval($row->i_status); 
				  $ret_["s_status"]				=	$this->db->PMBSTATUS[$row->i_status];
		  
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
	public function insert_info($info)
    {
        try
        {
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl." Set ";
                $s_qry.=" i_job_id=? ";
				$s_qry.=", i_tradesman_id=? ";
				$s_qry.=", i_buyer_id=? ";
				$s_qry.=", i_created_date=? ";
                
                $this->db->query($s_qry,array(
												  intval($info["i_job_id"]),
												  intval($info["i_tradesman_id"]),
												  intval($info["i_buyer_id"]),
												  intval(time())
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  intval($info["i_job_id"]),
												  intval($info["i_tradesman_id"]),
												  intval($info["i_buyer_id"]),
												  intval(time())
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
	
	public function fetch_pmb($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
			$CI			=	&get_instance();
			$login_user	= 	$CI->session->userdata('loggedin');
			$user_id	=	decrypt($login_user['user_id']);
          	$ret_=array();
			$s_qry="SELECT j.s_title,j.i_buyer_user_id,u.s_name,us.s_name AS client_name,pd.i_date,pd.s_content,pd.i_receiver_view_status,cnt.i_no_msg,n.* FROM ".$this->tbl." n "
				." INNER JOIN {$this->tbl_pmb_details} pd ON pd.i_msg_board_id = n.id "
				." LEFT JOIN {$this->tbl_jobs} j ON j.id = n.i_job_id "
				." LEFT JOIN {$this->tbl_users} u ON u.id	=	n.i_tradesman_id "
				." LEFT JOIN {$this->tbl_users} us ON us.id	=	n.i_buyer_id "
				. " LEFT JOIN ( SELECT jmb.i_msg_board_id,COUNT(*) i_no_msg FROM {$this->tbl_pmb_details} jmb WHERE jmb.i_receiver_view_status=0 AND jmb.i_status=1 AND jmb.i_receiver_id={$user_id} GROUP BY jmb.i_msg_board_id ) cnt ON cnt.i_msg_board_id=n.id "
                .($s_where!=""?$s_where:"" )." GROUP BY n.id ORDER BY pd.i_date DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          //echo $s_qry; exit;
		  $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer				  
				 
				  $ret_[$i_cnt]["job_id"]=$row->i_job_id;
				  $ret_[$i_cnt]["i_tradesman_id"]=$row->i_tradesman_id;
				  $ret_[$i_cnt]["i_buyer_id"]=$row->i_buyer_id;
				  
				  $ret_[$i_cnt]["i_buyer_user_id"]=$row->i_buyer_user_id;
                  $ret_[$i_cnt]["s_tradesman_name"]	=	htmlspecialchars_decode(get_unformatted_string($row->s_name)); 
				  $ret_[$i_cnt]["s_job_title"]		=	htmlspecialchars_decode(get_unformatted_string($row->s_title)); 
				  
				  $ret_[$i_cnt]["s_client_name"]	=	htmlspecialchars_decode(get_unformatted_string($row->client_name)); 
				 //$s_desc = htmlspecialchars_decode(get_unformatted_string($row->s_message));
                  //$ret_[$i_cnt]["s_message"]		= 	(strlen($s_desc)>70) ? substr_replace($s_desc,'...',74) : $s_desc;
				  //$ret_[$i_cnt]["s_large_message"]	= 	(strlen($s_desc)>300) ? substr_replace($s_desc,'...',304) : $s_desc;
				  $msg_bd_id = $ret_[$i_cnt]["id"];
				  $s_wh = " WHERE n.i_msg_board_id = {$msg_bd_id} ";
				  $ret_[$i_cnt]["total_msg"] = $this->gettotal_msg_info($s_wh);
				  
				  $ret_[$i_cnt]["s_content"]		=	htmlspecialchars_decode(get_unformatted_string($row->s_content));
				  $ret_[$i_cnt]["dt_reply_on"]		=	date($this->conf["site_date_format"],intval($row->i_date));
				  $ret_[$i_cnt]["i_receiver_view_status"]	= intval($row->i_receiver_view_status);
                  $ret_[$i_cnt]["i_no_msg"]	= intval($row->i_no_msg);
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
	
	
	
	public function fetch_pmb_exist($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
          	$ret_=array();
			$s_qry="SELECT j.s_title,j.i_buyer_user_id,u.s_name,pd.i_date,pd.s_content,n.* FROM ".$this->tbl." n "
				." LEFT JOIN {$this->tbl_pmb_details} pd ON pd.i_msg_board_id = n.id "
				." LEFT JOIN {$this->tbl_jobs} j ON j.id = n.i_job_id "
				." LEFT JOIN {$this->tbl_users} u ON u.id	=	n.i_tradesman_id "
                .($s_where!=""?$s_where:"" )." GROUP BY n.id ORDER BY pd.i_date DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          //echo $s_qry;
		  $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer				  
				 
				  $ret_[$i_cnt]["job_id"]=$row->i_job_id;
				  $ret_[$i_cnt]["i_tradesman_id"]=$row->i_tradesman_id;
				  $ret_[$i_cnt]["i_buyer_id"]=$row->i_buyer_id;
				  
				  $ret_[$i_cnt]["i_buyer_user_id"]=$row->i_buyer_user_id;
                  $ret_[$i_cnt]["s_tradesman_name"]	=	htmlspecialchars_decode(get_unformatted_string($row->s_name)); 
				  $ret_[$i_cnt]["s_job_title"]		=	htmlspecialchars_decode(get_unformatted_string($row->s_title)); 
				 //$s_desc = htmlspecialchars_decode(get_unformatted_string($row->s_message));
                  //$ret_[$i_cnt]["s_message"]		= 	(strlen($s_desc)>70) ? substr_replace($s_desc,'...',74) : $s_desc;
				  //$ret_[$i_cnt]["s_large_message"]	= 	(strlen($s_desc)>300) ? substr_replace($s_desc,'...',304) : $s_desc;
				  $msg_bd_id = $ret_[$i_cnt]["id"];
				  $s_wh = " WHERE n.i_msg_board_id = {$msg_bd_id} ";
				  $ret_[$i_cnt]["total_msg"] = $this->gettotal_msg_info($s_wh);
				  
				  $ret_[$i_cnt]["s_content"]		=	htmlspecialchars_decode(get_unformatted_string($row->s_content));
				  $ret_[$i_cnt]["dt_reply_on"]		=	date($this->conf["site_date_format"],intval($row->i_date));
				  
                  
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
	
	
	public function fetch_pmb_board($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
          	$ret_=array();
			$s_qry="SELECT j.s_title,j.i_buyer_user_id,u.s_name,pd.i_date,pd.s_content,n.* FROM ".$this->tbl." n "
				." LEFT JOIN {$this->tbl_pmb_details} pd ON pd.i_msg_board_id = n.id "
				." LEFT JOIN {$this->tbl_jobs} j ON j.id = n.i_job_id "
				." LEFT JOIN {$this->tbl_users} u ON u.id	=	n.i_tradesman_id "
                .($s_where!=""?$s_where:"" )." GROUP BY n.id ORDER BY pd.i_date DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          //echo $s_qry;
		  $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
				  $ret_[$i_cnt]["job_id"]=$row->i_job_id;
				  $ret_[$i_cnt]["i_tradesman_id"]=$row->i_tradesman_id;
				  $ret_[$i_cnt]["i_buyer_id"]=$row->i_buyer_id;
				  
				  $ret_[$i_cnt]["i_buyer_user_id"]=$row->i_buyer_user_id;
                  $ret_[$i_cnt]["s_tradesman_name"]	=	htmlspecialchars_decode(get_unformatted_string($row->s_name)); 
				  $ret_[$i_cnt]["s_job_title"]		=	htmlspecialchars_decode(get_unformatted_string($row->s_title)); 
				  $s_desc = htmlspecialchars_decode(get_unformatted_string($row->s_message));
                  $ret_[$i_cnt]["s_message"]		= 	(strlen($s_desc)>70) ? substr_replace($s_desc,'...',74) : $s_desc;
				  $ret_[$i_cnt]["s_large_message"]	= 	(strlen($s_desc)>300) ? substr_replace($s_desc,'...',304) : $s_desc;
				  
				  $ret_[$i_cnt]["s_content"]		=	htmlspecialchars_decode(get_unformatted_string($row->s_content));
				  $ret_[$i_cnt]["dt_reply_on"]		=	$row->i_date?date($this->conf["site_date_format"],intval($row->i_date)):'';
				  
                  
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
	
	
	
	 public function fetch_this_pmb($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {			
		  	
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select u.s_name as SENDER_NAME,us.s_name as RECEIVER_NAME, pd.* From ".$this->tbl_pmb_details." AS pd " 
		  		." LEFT JOIN {$this->tbl_users} u ON u.id	=	pd.i_sender_id " 
				." LEFT JOIN {$this->tbl_users} us ON us.id	=	pd.i_receiver_id "              
                .($s_where!=""?$s_where:"" )." ORDER BY pd.i_date DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            
			//echo $s_qry;     
          $rs=$this->db->query($s_qry); 
           $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				 
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
				  $s_desc = strip_tags(stripslashes(htmlspecialchars_decode($row->s_content)));
                 // $ret_[$i_cnt]["s_content"]		=	nl2br(get_unformatted_string($row->s_content)); 
				  $ret_[$i_cnt]["s_content"]		=	nl2br($s_desc); 
				  $ret_[$i_cnt]["s_sender_name"]	=	get_unformatted_string($row->SENDER_NAME); 
				  $ret_[$i_cnt]["s_receiver_name"]	=	get_unformatted_string($row->RECEIVER_NAME); 
				
                  $ret_[$i_cnt]["dt_reply_on"]	=	date($this->conf["site_date_format"],intval($row->i_date)); 
				  $ret_[$i_cnt]["i_days_diff"] = ($row->i_date)?round((time()- $row->i_date) / 86400):0;
				  $ret_[$i_cnt]["s_days_diff"] 	= ($ret_[$i_cnt]["i_days_diff"]>1) ? $ret_[$i_cnt]["i_days_diff"].' days' :' 0 day';	 

		    	  $i_cnt++;
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit);
          return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    } 
	
	
	public function set_new_message_details($info)
    {
        try
        {
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl_pmb_details." Set ";
                $s_qry.=" s_content=? ";				
				$s_qry.=", i_msg_board_id=? ";
				$s_qry.=", i_sender_id=? ";
				$s_qry.=", i_receiver_id=? ";
                $s_qry.=", i_date=? ";
                
                $this->db->query($s_qry,array(
												  get_formatted_string($info["s_content"]),
												  intval($info["i_msg_board_id"]),
												  intval($info["i_sender_id"]),
												  intval($info["i_receiver_id"]),
												  intval($info["i_date"])
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {					
					
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  get_formatted_string($info["s_content"]),
												  intval($info["i_msg_board_id"]),
												  intval($info["i_sender_id"]),
												  intval($info["i_receiver_id"]),
												  intval($info["i_date"])
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
	
	
	 public function edit_pmb($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";	               
                $s_qry.=" i_is_deleted=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(	
												  intval($info["i_status"]),
												  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(	
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
	
	 /***
    * Update records in db. As we know the table name 
    * we will not pass it into params.
    * 
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @param int $i_id, id value to be updated used in where clause
    * @returns $i_rows_affected  on success and FALSE if failed 
    */
    
    
      public function update_view_status($info,$s_where)
    {
        try
        {
		$i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl_pmb_details." pd Set ";	               
                $s_qry.=" i_receiver_view_status=? ";
                $s_qry.=$s_where;
                
                $this->db->query($s_qry,array(
												  intval($info["i_receiver_view_status"])
                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  
												  intval($info["i_receiver_view_status"])
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
	
	
	
	
    public function __destruct()
    {}                 
  
  
}
///end of class
?>