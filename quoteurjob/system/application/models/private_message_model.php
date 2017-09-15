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
			 $s_qry="SELECT u.s_name as SENDER_NAME,us.s_name as RECEIVER_NAME,j.s_title,n.* FROM ".$this->tbl." n
					INNER JOIN {$this->tbl_pmb_details} mbd ON n.id=mbd.i_msg_board_id "
				." INNER JOIN {$this->tbl_jobs} j ON j.id = n.i_job_id "
				." LEFT JOIN {$this->tbl_users} u ON u.id	=	n.i_buyer_id " 
				." LEFT JOIN {$this->tbl_users} us ON us.id	=	n.i_tradesman_id " 
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" GROUP BY n.i_job_id ORDER BY n.i_created_date DESC Limit ".intval($i_start).",".intval($i_limit):"" );
          
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
				  $ret_[$i_cnt]["i_total_pmb"]				=	$this->total_pmb($row->i_job_id); 
				  $ret_[$i_cnt]["i_new_pmb"]				=	$this->total_new_pmb($row->i_job_id);
				  $ret_[$i_cnt]["i_job_id"]				=	intval($row->i_job_id); 
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
	
	 public function gettotal_board_info($s_where=null)
    {
        try
        {
          $ret_=0;
           $s_qry="Select count(DISTINCT n.i_job_id ) as i_total "
                ."FROM ".$this->tbl." n
					INNER JOIN {$this->tbl_pmb_details} mbd ON n.id=mbd.i_msg_board_id "
				." INNER JOIN {$this->tbl_jobs} j ON j.id = n.i_job_id "
				." LEFT JOIN {$this->tbl_users} u ON u.id	=	n.i_buyer_id " 
				." LEFT JOIN {$this->tbl_users} us ON us.id	=	n.i_tradesman_id " 
                .($s_where!=""?$s_where:"" )." ";
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
	
	
	/******
    * This method will fetch all records from the db. 
    * 
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @param int $i_start, starting value for pagination
    * @param int $i_limit, number of records to fetch used for pagination
    * @returns array
    */
    public function fetch_multi_msg_brd($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {	
          	$ret_=array();
			$s_qry="SELECT u.s_name as SENDER_NAME,us.s_name as RECEIVER_NAME,j.s_title,n.* FROM ".$this->tbl." n 
					INNER JOIN {$this->tbl_pmb_details} mbd ON n.id=mbd.i_msg_board_id "
				." INNER JOIN {$this->tbl_jobs} j ON j.id = n.i_job_id "
				
				." LEFT JOIN {$this->tbl_users} u ON u.id	=	n.i_buyer_id " 
				." LEFT JOIN {$this->tbl_users} us ON us.id	=	n.i_tradesman_id " 
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" GROUP BY n.id ORDER BY n.i_created_date DESC Limit ".intval($i_start).",".intval($i_limit):"" );
          //echo $s_qry;
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
				  $ret_[$i_cnt]["i_total_pmb"]				=	$this->total_pmb($row->i_job_id,$row->id); 
				  $ret_[$i_cnt]["i_new_pmb"]				=	$this->total_new_pmb($row->i_job_id,$row->id);
				  $ret_[$i_cnt]["i_status"]				=	intval($row->i_status); 
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
	
	public function gettotal_msg_brd_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl." n "
				." LEFT JOIN {$this->tbl_jobs} j ON j.id = n.i_job_id "
				." LEFT JOIN {$this->tbl_users} u ON u.id	=	n.i_buyer_id " 
				." LEFT JOIN {$this->tbl_users} us ON us.id	=	n.i_tradesman_id " 
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
				  $ret_["i_buyer_id"]				=	intval($row->i_buyer_id); 
				  $ret_["i_tradesman_id"]				=	intval($row->i_tradesman_id); 
				  $ret_["i_job_id"]				=	intval($row->i_job_id); 
				  
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
		public function update_status($i_id,$i_status)
	{
		try
		{
			$i_ret_=0;////Returns false
    
            if(intval($i_id)>0)
            {
			 
				//echo $i_id.'-'.$i_status;
				$s_qry="UPDATE ".$this->tbl_pmb_details."  SET i_status=?";
				
                $s_qry.=" Where id=? ";
				//echo $s_qry;
                $this->db->query($s_qry, array(intval($i_status),intval($i_id)) );
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl_pmb_details." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($i_status),intval($i_id)) ) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                           
            }
            elseif(intval($i_id)==-1)////Deleting All
            {
				$s_qry="UPDATE ".$this->tbl_pmb_details." SET i_status=?";
                $this->db->query($s_qry, array(intval($i_status)) );
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Updating all information from ".$this->tbl_pmb_details." ";
                    $logi["sql"]= serialize($s_qry, array(intval($i_status))) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                
            }
            unset($s_qry, $i_id);
            return $i_ret_;
		}
		catch(Exception $e)
		{
			show_error($e->getMessage());
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
                
                $this->db->query($s_qry,array(
												  intval($info["i_job_id"]),
												  intval($info["i_tradesman_id"]),
												  intval($info["i_buyer_id"])
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  intval($info["i_job_id"]),
												  intval($info["i_tradesman_id"]),
												  intval($info["i_buyer_id"])
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
          	$ret_=array();
			$s_qry="SELECT pd.*,u.s_name AS s_receiver_name,ub.s_name AS s_sender_name,
						pd.i_date FROM ".$this->tbl_pmb_details." pd "
				." LEFT JOIN {$this->tbl_users} u ON u.id	=	pd.i_receiver_id "
				." LEFT JOIN {$this->tbl_users} ub ON ub.id	=	pd.i_sender_id "
                .($s_where!=""?$s_where:"" )." ORDER BY pd.i_date DESC, pd.i_msg_board_id  ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
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
                  $ret_[$i_cnt]["s_receiver_name"]	=	get_unformatted_string($row->s_receiver_name); 
				  $ret_[$i_cnt]["s_sender_name"]	=	get_unformatted_string($row->s_sender_name); 
				  
				  $ret_[$i_cnt]["s_content"]		=	htmlspecialchars_decode(get_unformatted_string($row->s_content));
				  $ret_[$i_cnt]["dt_reply_on"]		=	date($this->conf["site_date_format"],intval($row->i_date));
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
    public function gettotal_pmb_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total  FROM ".$this->tbl_pmb_details." pd "
				." LEFT JOIN {$this->tbl_users} u ON u.id	=	pd.i_receiver_id "
				." LEFT JOIN {$this->tbl_users} ub ON ub.id	=	pd.i_sender_id " 
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
                  $ret_[$i_cnt]["s_content"]		=	get_unformatted_string($row->s_content); 
				  $ret_[$i_cnt]["s_sender_name"]	=	get_unformatted_string($row->SENDER_NAME); 
				  $ret_[$i_cnt]["s_receiver_name"]	=	get_unformatted_string($row->RECEIVER_NAME); 
				
                  $ret_[$i_cnt]["dt_reply_on"]	=	date($this->conf["site_date_format"],intval($row->i_date)); 
				  $ret_[$i_cnt]["i_days_diff"] = ($row->i_date)?round((time()- $row->i_date) / 86400):0;
				  $ret_[$i_cnt]["s_days_diff"] 	= ($ret_[$i_cnt]["i_days_diff"]>1) ? $ret_[$i_cnt]["i_days_diff"].' days' :' 0 day';	 
				  $ret_[$i_cnt]["i_status"]				=	intval($row->i_status); 
				  $ret_[$i_cnt]["s_status"]				=	$this->db->PMBSTATUS[$row->i_status];

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
	
	public function update_new_message_details($info,$i_id)
    {
        try
        {
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
                $s_qry="UPDATE ".$this->tbl_pmb_details." Set ";
                $s_qry.=" s_content=? ";				
				$s_qry.=", i_status=? ";
                $s_qry.=", i_date=? ";
				 $s_qry.=" WHERE id=? ";
                
                $this->db->query($s_qry,array(
												  get_formatted_string($info["s_content"]),
												  intval($info["i_status"]),
												  intval($info["i_date"]),
												   intval($i_id)
												 ));
                $i_ret_=$this->db->affected_rows();     
                if($i_ret_)
                {					
					
                    $logi["msg"]="UPDATE into ".$this->tbl_pmb_details." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  get_formatted_string($info["s_content"]),
												  intval($info["i_status"]),
												  intval($info["i_date"]),
												   intval($i_id)
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
	
	
	public function fetch_single_pmb($i_id)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select u.s_name as SENDER_NAME,u.s_email as SENDER_MAIL,us.s_name as RECEIVER_NAME,us.s_email as RECEIVER_MAIL,j.s_title,n.* "
                ."From ".$this->tbl_pmb_details." AS n "
				
				." LEFT JOIN {$this->tbl_users} u ON u.id	=	n.i_sender_id " 
				." LEFT JOIN {$this->tbl} t ON t.id	=	n.i_msg_board_id " 
				." LEFT JOIN {$this->tbl_jobs} j ON j.id = t.i_job_id "
				." LEFT JOIN {$this->tbl_users} us ON us.id	=	n.i_receiver_id " 
                ." Where n.id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]=$row->id;////always integer
                  $ret_["s_content"]			=	get_unformatted_string($row->s_content); 
				  $ret_["s_job_title"]			=	get_unformatted_string($row->s_title); 
				  
				  $ret_["s_sender_user"]		=	get_unformatted_string($row->SENDER_NAME); 
				  $ret_["s_receiver_user"]		=	get_unformatted_string($row->RECEIVER_NAME); 
				  $ret_["s_sender_user_email"]	=	get_unformatted_string($row->SENDER_MAIL);  
				 
				  $ret_["s_receiver_user_email"]=	get_unformatted_string($row->RECEIVER_MAIL);
				  $ret_["i_buyer_id"]				=	intval($row->i_buyer_id); 
				  $ret_["i_tradesman_id"]				=	intval($row->i_tradesman_id); 
				  $ret_["i_job_id"]				=	intval($row->i_job_id); 
				  
                  $ret_["dt_created_on"]		=	date($this->conf["site_date_format"],intval($row->i_date)); 
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
	public function total_pmb($i_job_id,$id=0)
	{
		$s_part = '';
		if($id!=0)
		$s_part = " AND mbd1.i_msg_board_id = $id";
		$s_qry = "SELECT COUNT(mbd1.id) AS i_total FROM quoteurjob_msg_board_details mbd1 INNER JOIN quoteurjob_msg_board mb ON  
mbd1.i_msg_board_id = mb.id WHERE mb.i_job_id=$i_job_id $s_part";
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
        
          return $ret_;
	}
	public function total_new_pmb($i_job_id,$id=0)
	{
		$s_part = '';
		if($id!=0)
		$s_part = " AND mbd1.i_msg_board_id = $id";
		$s_qry = "SELECT COUNT(mbd1.id) AS i_total FROM quoteurjob_msg_board_details mbd1 INNER JOIN quoteurjob_msg_board mb ON  
mbd1.i_msg_board_id = mb.id WHERE mb.i_job_id=$i_job_id AND mbd1.i_status=0 ";
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
        
          return $ret_;
	}
    public function __destruct()
    {}                 
  
  
}
///end of class
?>