<?php
/*********
* Author: Koushik Rout
* Date  : 02 April 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For manage_private_message
* 
* @package Jobs
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
    private $tbl_pmb_details ;
    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->PMB; 
          $this->tbl_users = $this->db->MST_USER;
          $this->tbl_jobs = $this->db->JOBS; 
          
          //$this->tbl_pmb            =    $this->db->PMB;
          $this->tbl_pmb_details    =    $this->db->PMBDETAILS;
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
                ." LEFT JOIN {$this->tbl_users} u ON u.id    =    n.i_buyer_id " 
                ." LEFT JOIN {$this->tbl_users} us ON us.id    =    n.i_tradesman_id " 
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" GROUP BY n.i_job_id ORDER BY n.i_created_date DESC Limit ".intval($i_start).",".intval($i_limit):"" );
          
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_message"]            =    get_unformatted_string($row->s_message); 
                  
                  $ret_[$i_cnt]["s_job_title"]            =    get_unformatted_string($row->s_title); 
                  
                  $ret_[$i_cnt]["s_sender_user"]        =    get_unformatted_string($row->SENDER_NAME); 
                  $ret_[$i_cnt]["s_receiver_user"]        =    get_unformatted_string($row->RECEIVER_NAME);                   
                  $ret_[$i_cnt]["i_total_pmb"]                =    $this->total_pmb($row->i_job_id); 
                  $ret_[$i_cnt]["i_new_pmb"]                =    $this->total_new_pmb($row->i_job_id);
                  $ret_[$i_cnt]["i_job_id"]                =    intval($row->i_job_id); 
                  $ret_[$i_cnt]["dt_created_on"]        =    date($this->conf["site_date_format"],intval($row->i_created_date));
                  $ret_[$i_cnt]["i_status"]                =    intval($row->i_status); 
                  $ret_[$i_cnt]["s_status"]                =    $this->db->PMBSTATUS[$row->i_status];
                  
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
                ." LEFT JOIN {$this->tbl_users} u ON u.id    =    n.i_buyer_id " 
                ." LEFT JOIN {$this->tbl_users} us ON us.id    =    n.i_tradesman_id " 
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
                
                ." LEFT JOIN {$this->tbl_users} u ON u.id    =    n.i_buyer_id " 
                ." LEFT JOIN {$this->tbl_users} us ON us.id    =    n.i_tradesman_id " 
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" GROUP BY n.id ORDER BY n.i_created_date DESC Limit ".intval($i_start).",".intval($i_limit):"" );
          //echo $s_qry;
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_message"]            =    get_unformatted_string($row->s_message); 
                  
                  $ret_[$i_cnt]["s_job_title"]          =    get_unformatted_string($row->s_title); 
                  
                  $ret_[$i_cnt]["s_sender_user"]        =    get_unformatted_string($row->SENDER_NAME); 
                  $ret_[$i_cnt]["s_receiver_user"]      =    get_unformatted_string($row->RECEIVER_NAME);                   
                  $ret_[$i_cnt]["i_total_pmb"]          =    $this->total_pmb($row->i_job_id,$row->id); 
                  $ret_[$i_cnt]["i_new_pmb"]            =    $this->total_new_pmb($row->i_job_id,$row->id);
                  $ret_[$i_cnt]["i_status"]             =    intval($row->i_status); 
                  $ret_[$i_cnt]["dt_created_on"]        =    date($this->conf["site_date_format"],intval($row->i_created_date));
                  $ret_[$i_cnt]["i_status"]             =    intval($row->i_status); 
                  $ret_[$i_cnt]["s_status"]             =    $this->db->PMBSTATUS[$row->i_status];
                  
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
    
    public function gettotal_msg_brd_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl." n "
                ." LEFT JOIN {$this->tbl_jobs} j ON j.id = n.i_job_id "
                ." LEFT JOIN {$this->tbl_users} u ON u.id    =    n.i_buyer_id " 
                ." LEFT JOIN {$this->tbl_users} us ON us.id    =    n.i_tradesman_id " 
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
    
    
    
    /****
    * Fetch Total records
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @returns int on success and FALSE if failed 
    */
    public function gettotal_info($s_where='')
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
          unset($s_qry,$rs,$row,$i_cnt,$s_where);
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
                ." LEFT JOIN {$this->tbl_users} u ON u.id    =    n.i_buyer_id " 
                ." LEFT JOIN {$this->tbl_users} us ON us.id    =    n.i_tradesman_id " 
                ." Where n.id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  
                  $ret_["id"]=$row->id;////always integer
                  $ret_["s_message"]            =    get_unformatted_string($row->s_message); 
                  $ret_["s_job_title"]            =    get_unformatted_string($row->s_title); 
                  
                  $ret_["s_sender_user"]        =    get_unformatted_string($row->SENDER_NAME); 
                  $ret_["s_receiver_user"]        =    get_unformatted_string($row->RECEIVER_NAME); 
                  $ret_["s_sender_user_email"]    =    get_unformatted_string($row->SENDER_MAIL);  
                 
                  $ret_["s_receiver_user_email"]=    get_unformatted_string($row->RECEIVER_MAIL);
                  $ret_["i_buyer_id"]                =    intval($row->i_buyer_id); 
                  $ret_["i_tradesman_id"]                =    intval($row->i_tradesman_id); 
                  $ret_["i_job_id"]                =    intval($row->i_job_id); 
                  
                  $ret_["dt_created_on"]        =    date($this->conf["site_date_format"],intval($row->i_created_date)); 
                  $ret_["i_status"]                =    intval($row->i_status); 
                  $ret_["s_status"]                =    $this->db->PMBSTATUS[$row->i_status];
          
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
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }    
    
    
    /* insert data when no pmb exist */
    public function add_message_board($info)
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
                $s_qry    =    "Update ".$this->tbl." Set ";                   
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
    // function is now changed
    public function fetch_pmb($s_where=null,$i_start=null,$i_limit=null,$i_receiver_id='')
    {
        try
        {
              $ret_=array();
            $s_qry="SELECT j.s_title,j.i_buyer_user_id,j.i_status job_status,u.s_name,u.s_username s_tradesman_username,u.s_email s_tradesman_email,u.s_image s_tradesman_image,ub.s_email s_buyer_email,ub.s_username,ub.s_image,n.*,cnt.i_total,inn.s_content,total.i_cnt_msg FROM ".$this->tbl." n "
                ." LEFT JOIN {$this->tbl_jobs} j ON j.id = n.i_job_id "
                ." LEFT JOIN {$this->tbl_users} u ON u.id    =    n.i_tradesman_id "
				." LEFT JOIN {$this->tbl_users} ub ON ub.id    =    j.i_buyer_user_id "
                ." LEFT JOIN (SELECT COUNT(*) i_total,i_msg_board_id  FROM ".$this->tbl_pmb_details." 
                WHERE i_receiver_id=".$i_receiver_id." AND i_receiver_view_status=0  GROUP BY i_msg_board_id) cnt 
                ON cnt.i_msg_board_id=n.id " 
                ." LEFT JOIN (SELECT COUNT(*) i_cnt_msg,i_msg_board_id  FROM ".$this->tbl_pmb_details." 
                GROUP BY i_msg_board_id) total 
                ON total.i_msg_board_id=n.id "
                ." LEFT JOIN (SELECT mbd.s_content,mb.id FROM ".$this->tbl." mb 
                LEFT JOIN ".$this->tbl_pmb_details." mbd ON mb.id=mbd.i_msg_board_id 
                GROUP BY  mbd.i_msg_board_id) inn ON n.id=inn.id " 
                .($s_where!=""?$s_where:"" )."  ORDER BY i_last_updated DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          
         
          
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["job_id"]=$row->i_job_id;
                  $ret_[$i_cnt]["i_tradesman_id"]=$row->i_tradesman_id;
                  $ret_[$i_cnt]["s_tradesman_email"]   =   get_unformatted_string($row->s_tradesman_email);
                  $ret_[$i_cnt]["s_buyer_email"]       =   get_unformatted_string($row->s_buyer_email);
                  
                  $ret_[$i_cnt]["i_buyer_id"]=$row->i_buyer_id;
                  $ret_[$i_cnt]["i_buyer_user_id"]=$row->i_buyer_user_id;
                  $ret_[$i_cnt]["s_tradesman_name"]    =    get_unformatted_string($row->s_name); 
				  $ret_[$i_cnt]["s_tradesman_username"]=    get_unformatted_string($row->s_tradesman_username); 
                  $ret_[$i_cnt]["s_job_title"]         =    get_unformatted_string($row->s_title);
                  $ret_[$i_cnt]["job_status"]          =   intval($row->job_status);
				  $ret_[$i_cnt]["s_username"]      =    get_unformatted_string($row->s_username);
                  $ret_[$i_cnt]["s_image"]         =    get_unformatted_string($row->s_image);
				  $ret_[$i_cnt]["s_tradesman_image"]=    get_unformatted_string($row->s_tradesman_image);
                  $ret_[$i_cnt]["dt_created_on"]   =    date($this->conf["site_date_format"],intval($row->i_created_date));
				  $ret_[$i_cnt]["i_new_message"]   =    intval($row->i_total);
                  $ret_[$i_cnt]["s_content"]       =    get_unformatted_string($row->s_content);
                  $ret_[$i_cnt]["i_cnt_msg"]       =    intval($row->i_cnt_msg);
				  
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
	
	
		 
    
    
     /* fetch private message board */
    // function is now changed
    public function fetch_message_board_list($s_where=null,$i_sender_id='',$i_start=null,$i_limit=null)
    {
        try
        {
              $ret_=array();
            $s_qry="SELECT j.s_title,j.i_buyer_user_id,u.s_name,n.*,nw.i_new_message FROM ".$this->tbl." n "
                ." LEFT JOIN {$this->tbl_jobs} j ON j.id = n.i_job_id "
                ." LEFT JOIN {$this->tbl_users} u ON u.id    =    n.i_tradesman_id "
                ." LEFT JOIN (SELECT count(*) i_new_message,i_msg_board_id FROM {$this->tbl_pmb_details} pd WHERE i_sender_id!={$i_sender_id} AND pd.i_status=1 AND i_view=0 GROUP BY pd.i_msg_board_id) nw ON nw.i_msg_board_id=n.id "
                .($s_where!=""?$s_where:"" )." GROUP BY n.id ORDER BY n.id ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
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
                  $ret_[$i_cnt]["s_tradesman_name"]    =    get_unformatted_string($row->s_name); 
                  $ret_[$i_cnt]["s_job_title"]         =    get_unformatted_string($row->s_title); 
                  $ret_[$i_cnt]["i_new_message"]       =    intval($row->i_new_message);
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
                ." LEFT JOIN {$this->tbl_users} u ON u.id    =    n.i_tradesman_id "
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
                  $ret_[$i_cnt]["s_tradesman_name"]    =    htmlspecialchars_decode(get_unformatted_string($row->s_name)); 
                  $ret_[$i_cnt]["s_job_title"]        =    htmlspecialchars_decode(get_unformatted_string($row->s_title)); 
                  $s_desc = htmlspecialchars_decode(get_unformatted_string($row->s_message));
                  $ret_[$i_cnt]["s_message"]        =     (strlen($s_desc)>70) ? substr_replace($s_desc,'...',74) : $s_desc;
                  $ret_[$i_cnt]["s_large_message"]    =     (strlen($s_desc)>300) ? substr_replace($s_desc,'...',304) : $s_desc;
                  
                  $ret_[$i_cnt]["s_content"]        =    htmlspecialchars_decode(get_unformatted_string($row->s_content));
                  $ret_[$i_cnt]["dt_reply_on"]        =    $row->i_date?date($this->conf["site_date_format"],intval($row->i_date)):'';
                  
                  
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

   
    
    
     public function edit_pmb($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry    =    "Update ".$this->tbl." Set ";                   
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
     
    
    public function fetch_pmb_list($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
              $ret_=array();
            $s_qry="SELECT pd.*,u.s_name AS s_receiver_name,ub.s_name AS s_sender_name,
                        pd.i_date FROM ".$this->tbl_pmb_details." pd "
                ." LEFT JOIN {$this->tbl_users} u ON u.id    =    pd.i_receiver_id "
                ." LEFT JOIN {$this->tbl_users} ub ON ub.id    =    pd.i_sender_id "
                .($s_where!=""?$s_where:"" )." ORDER BY pd.i_date DESC, pd.i_msg_board_id  ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          //echo $s_qry;
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer 
                  $ret_[$i_cnt]["job_id"]			=	$row->i_job_id;
                  $ret_[$i_cnt]["i_tradesman_id"]	=	$row->i_tradesman_id;
                  $ret_[$i_cnt]["i_buyer_id"]		=	$row->i_buyer_id;
                  $ret_[$i_cnt]["s_receiver_name"]  =    get_unformatted_string($row->s_receiver_name); 
                  $ret_[$i_cnt]["s_sender_name"]    =    get_unformatted_string($row->s_sender_name); 
                  
                  $ret_[$i_cnt]["s_content"]        =    htmlspecialchars_decode(get_unformatted_string($row->s_content));
                  $ret_[$i_cnt]["dt_reply_on"]      =    date($this->conf["site_date_format"],intval($row->i_date));
                  $ret_[$i_cnt]["i_status"]         =    intval($row->i_status); 
                  $ret_[$i_cnt]["s_status"]         =    $this->db->PMBSTATUS[$row->i_status];
				  $ret_[$i_cnt]["i_view_status"] 	=    intval($row->i_receiver_view_status);
                  
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
                ." LEFT JOIN {$this->tbl_users} u ON u.id    =    pd.i_receiver_id "
                ." LEFT JOIN {$this->tbl_users} ub ON ub.id    =    pd.i_sender_id " 
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
          $s_qry="SELECT u.s_username AS SENDER_NAME,us.s_username AS RECEIVER_NAME, pd.* FROM ".$this->tbl_pmb_details." AS pd " 
                  ." LEFT JOIN {$this->tbl_users} u ON u.id    =    pd.i_sender_id " 
                ." LEFT JOIN {$this->tbl_users} us ON us.id    =    pd.i_receiver_id "              
                .($s_where!=""?$s_where:"" )." ORDER BY pd.i_date DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            
           
          $rs=$this->db->query($s_qry); 
           $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                 
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_content"]        =    nl2br(get_unformatted_string($row->s_content)); 
                  $ret_[$i_cnt]["s_sender_name"]    =    get_unformatted_string($row->SENDER_NAME); 
                  $ret_[$i_cnt]["s_receiver_name"]  =    get_unformatted_string($row->RECEIVER_NAME); 
                  $ret_[$i_cnt]["dt_created_on"]    =    date($this->conf["site_date_format"],intval($row->i_date)); 
                  
                  $ret_[$i_cnt]["s_days_diff"]      =    time_ago(intval($row->i_date));     
                  $ret_[$i_cnt]["i_status"]         =    intval($row->i_status); 
                  $ret_[$i_cnt]["i_view"]           =    intval($row->i_view); 
                  $ret_[$i_cnt]["i_sender_id"]      =    intval($row->i_sender_id); 
                  $ret_[$i_cnt]["i_receiver_id"]    =    intval($row->i_receiver_id); 
                  $ret_[$i_cnt]["i_receiver_view_status"]=    intval($row->i_receiver_view_status); 
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
    
    /**
    * this function is used for message post
    * Time of message post it also update the last update time in pmb table
    * 
    * @param mixed $info
    */
    
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
                $s_qry.=", i_status=? ";
                
                $this->db->query($s_qry,array(
                                                  get_formatted_string($info["s_content"]),
                                                  intval($info["i_msg_board_id"]),
                                                  intval($info["i_sender_id"]),
                                                  intval($info["i_receiver_id"]),
                                                  intval($info["i_date"]),
                                                  intval($info["i_status"])
                                                 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    // update msg_board table
                    $s_qry  =   " UPDATE ".$this->tbl." SET i_last_updated=".time()." WHERE id=".$info["i_msg_board_id"] ;                            $this->db->query($s_qry) ;
                    
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
    
   
    
    public function fetch_single_pmb($i_id)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select u.s_name as SENDER_NAME,u.s_email as SENDER_MAIL,us.s_name as RECEIVER_NAME,us.s_email as RECEIVER_MAIL,j.s_title,n.* "
                ."From ".$this->tbl_pmb_details." AS n "
                
                ." LEFT JOIN {$this->tbl_users} u ON u.id    =    n.i_sender_id " 
                ." LEFT JOIN {$this->tbl} t ON t.id    =    n.i_msg_board_id " 
                ." LEFT JOIN {$this->tbl_jobs} j ON j.id = t.i_job_id "
                ." LEFT JOIN {$this->tbl_users} us ON us.id    =    n.i_receiver_id " 
                ." Where n.id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  
                  $ret_["id"]=$row->id;////always integer
                  $ret_["s_content"]            =    get_unformatted_string($row->s_content); 
                  $ret_["s_job_title"]            =    get_unformatted_string($row->s_title); 
                  
                  $ret_["s_sender_user"]        =    get_unformatted_string($row->SENDER_NAME); 
                  $ret_["s_receiver_user"]        =    get_unformatted_string($row->RECEIVER_NAME); 
                  $ret_["s_sender_user_email"]    =    get_unformatted_string($row->SENDER_MAIL);  
                 
                  $ret_["s_receiver_user_email"]=    get_unformatted_string($row->RECEIVER_MAIL);
                  $ret_["i_buyer_id"]                =    intval($row->i_buyer_id); 
                  $ret_["i_tradesman_id"]                =    intval($row->i_tradesman_id); 
                  $ret_["i_job_id"]                =    intval($row->i_job_id); 
                  
                  $ret_["dt_created_on"]        =    date($this->conf["site_date_format"],intval($row->i_date)); 
                  $ret_["i_status"]                =    intval($row->i_status); 
                  $ret_["s_status"]                =    $this->db->PMBSTATUS[$row->i_status];
          
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
        $s_qry = "SELECT COUNT(mbd1.id) AS i_total FROM ".$this->tbl_pmb_details." mbd1 INNER JOIN ".$this->tbl." mb ON  
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
        $s_qry = "SELECT COUNT(mbd1.id) AS i_total FROM ".$this->tbl_pmb_details." mbd1 INNER JOIN ".$this->tbl." mb ON  
mbd1.i_msg_board_id = mb.id WHERE mb.i_job_id=$i_job_id AND mbd1.i_receiver_view_status=0 ";
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
                $s_qry="UPDATE ".$this->tbl_pmb_details."  SET i_status=?";
                
                $s_qry.=" Where id=? ";
                //echo $s_qry;
                $this->db->query($s_qry, array(intval($i_status),intval($i_id)) );
                $i_ret_ =   $this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl_pmb_details." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($i_status),intval($i_id)) ) ) ;
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
    
    
    /** 
    * put your comment there...
    * 
    * @param mixed $s_where
    * @param mixed $i_start
    * @param mixed $i_limit
    * @return string
    */
    public function fetch_pmb_exist($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
              $ret_=array();
            $s_qry="SELECT j.s_title,j.i_buyer_user_id,u.s_name,pd.i_date,pd.s_content,n.* FROM ".$this->tbl." n "
                ." LEFT JOIN {$this->tbl_pmb_details} pd ON pd.i_msg_board_id = n.id "
                ." LEFT JOIN {$this->tbl_jobs} j ON j.id = n.i_job_id "
                ." LEFT JOIN {$this->tbl_users} u ON u.id    =    n.i_tradesman_id "
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
                  $ret_[$i_cnt]["s_tradesman_name"]    =    htmlspecialchars_decode(get_unformatted_string($row->s_name)); 
                  $ret_[$i_cnt]["s_job_title"]        =    htmlspecialchars_decode(get_unformatted_string($row->s_title)); 
                 //$s_desc = htmlspecialchars_decode(get_unformatted_string($row->s_message));
                  //$ret_[$i_cnt]["s_message"]        =     (strlen($s_desc)>70) ? substr_replace($s_desc,'...',74) : $s_desc;
                  //$ret_[$i_cnt]["s_large_message"]    =     (strlen($s_desc)>300) ? substr_replace($s_desc,'...',304) : $s_desc;
                  $msg_bd_id = $ret_[$i_cnt]["id"];
                  $s_wh = " WHERE n.i_msg_board_id = {$msg_bd_id} ";
                  $ret_[$i_cnt]["total_msg"] = $this->gettotal_msg_info($s_wh);
                  
                  $ret_[$i_cnt]["s_content"]        =    htmlspecialchars_decode(get_unformatted_string($row->s_content));
                  $ret_[$i_cnt]["dt_reply_on"]        =    date($this->conf["site_date_format"],intval($row->i_date));
                  
                  
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
    
    /**
    * Fetch job list
    * 
    * @param mixed $s_where
    * @return string
    */
    public function fetch_jobs_pmb($s_where=null,$s_group=null)
    {
        try
        {    
              $ret_=array();
             $s_qry="SELECT j.s_title,n.* FROM ".$this->tbl." n "
                ." LEFT JOIN {$this->tbl_jobs} j ON j.id = n.i_job_id "
                .($s_where!=""?$s_where:"" ).($s_group!=""?$s_group:"" ) ;
        
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  
                  $ret_[$i_cnt]["i_job_id"]               =    intval($row->i_job_id); 
                  $ret_[$i_cnt]["s_job_title"]            =    get_unformatted_string($row->s_title);
                  $i_cnt++;
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$s_group);
          return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }  
    
    /**
    * fetch receiver list 
    *  
    * @param mixed $s_where
    * @return string
    */
    public function fetch_users_pmb($s_where=null,$s_group=null)
    {
        try
        {    
              $ret_=array();
             $s_qry="SELECT u.s_username as BUYER_NAME,us.s_username as TRADESMAN_NAME,n.* FROM ".$this->tbl." n "
                ." LEFT JOIN {$this->tbl_users} u ON u.id    =    n.i_buyer_id " 
                ." LEFT JOIN {$this->tbl_users} us ON us.id    =    n.i_tradesman_id " 
                .($s_where!=""?$s_where:"" ).($s_group!=""?$s_group:"" ) ;
          
         
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                   
                                                             
                  $ret_[$i_cnt]["s_tradesman_name"]       =    get_unformatted_string($row->TRADESMAN_NAME); 
                  $ret_[$i_cnt]["i_tradesman_id"]         =    intval($row->i_tradesman_id); 
                  $ret_[$i_cnt]["s_buyer_name"]           =    get_unformatted_string($row->BUYER_NAME); 
                  $ret_[$i_cnt]["i_buyer_id"]             =    intval($row->i_buyer_id);                    
                  
                  $i_cnt++;
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$s_group);
          return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    public function fetch_jobs($s_where='')
    {
        try
        {
             $ret_=array();
             $s_qry="SELECT n.* FROM ".$this->tbl_jobs." n "
             .($s_where!=""?$s_where:"" ) ;
              $rs=$this->db->query($s_qry);
              $i_cnt=0;
              if($rs->num_rows()>0)
              {
                  foreach($rs->result() as $row)
                  {                   
                      $ret_[$i_cnt]["i_job_id"]               =    intval($row->id); 
                      $ret_[$i_cnt]["s_job_title"]            =    get_unformatted_string($row->s_title);
                      $i_cnt++;                   
                      
                      $i_cnt++;
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
    
    
    public function update_view_status($s_where)
    {
        try
        {
            $i_ret_=0;////Returns false
            
            $s_qry="UPDATE ".$this->tbl_pmb_details."  SET i_receiver_view_status=1".($s_where!=""?$s_where:"" );
            
            $i_ret_ =   $this->db->query($s_qry) ;
            return $i_ret_ ;
 
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