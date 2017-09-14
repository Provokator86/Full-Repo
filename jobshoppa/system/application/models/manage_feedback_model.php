<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 9 Sep 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For News
* 
* @package Content Management
* @subpackage news
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/news.php
* @link views/admin/news/
*/


class Manage_feedback_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->JOBFEEDBACK; 
		  $this->tbl_users = $this->db->USERMANAGE;
		  $this->tbl_jobs = $this->db->JOBS;    
		  $this->tbl_cat = $this->db->CATEGORY;    
		  $this->tbl_tradesman_detail = $this->db->TRADESMANDETAILS;  
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
			$s_wh = " ORDER BY n.i_created_date DESC ";
          	$ret_=array();
			$s_qry="SELECT n.*, u.s_name AS s_sender_user, u.s_email s_sender_email, u.s_skype_id s_sender_skype_id, 
					u.s_msn_id s_sender_msn_id, u.s_yahoo_id s_sender_yahoo_id, 
					u.s_contact_no s_sender_contact_no, u.s_address s_sender_address,
					r.s_name AS s_receiver_user, td.i_feedback_rating,td.f_positive_feedback_percentage,
					j.s_title AS s_job_title, j.s_description s_description, j.i_assigned_date,
					c.s_category_name As s_category_name
					
					 FROM ".$this->tbl." n ".
					" LEFT JOIN ".$this->tbl_users." AS u ON n.i_sender_user_id = u.id ".
					" LEFT JOIN ".$this->tbl_users." AS r ON n.i_receiver_user_id = r.id".
					" LEFT JOIN ".$this->tbl_jobs." AS j ON n.i_job_id = j.id ".
					" LEFT JOIN ".$this->tbl_cat." AS c ON j.i_category_id = c.id ".
					" LEFT JOIN ".$this->tbl_tradesman_detail." AS td ON  n.i_receiver_user_id = td.i_user_id "
					//." LEFT JOIN {$this->db->CATEGORYCHILD} cat_c ON cat_c.i_cat_id = c.id"
                .($s_where!=""?$s_where:"" ).$s_wh.(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          
		  $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
		  	  $CI = & get_instance();
			  $CI->load->model("manage_buyers_model");		  

              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]					=	$row->id;////always integer
				  $ret_[$i_cnt]["i_job_id"]				=	intval($row->i_job_id);
				  $ret_[$i_cnt]["s_job_title"]			=	get_unformatted_string($row->s_job_title);
				  $ret_[$i_cnt]["s_description"]		=	get_unformatted_string($row->s_description);
				  $ret_[$i_cnt]["dt_assign_date"]		=	date($this->conf["site_date_format"],intval($row->i_assigned_date));
				  
				  $ret_[$i_cnt]["s_category_name"]		=	get_unformatted_string($row->s_category_name);
				  $ret_[$i_cnt]["i_sender_user_id"]		=	intval($row->i_sender_user_id);
				  $ret_[$i_cnt]["s_sender_user"]		=	get_unformatted_string($row->s_sender_user);
				  $ret_[$i_cnt]["s_sender_email"]		=	get_unformatted_string($row->s_sender_email);
				  $ret_[$i_cnt]["s_sender_skype_id"]	=	get_unformatted_string($row->s_sender_skype_id);
				  $ret_[$i_cnt]["s_sender_msn_id"]		=	get_unformatted_string($row->s_sender_msn_id);
				  $ret_[$i_cnt]["s_sender_yahoo_id"]	=	get_unformatted_string($row->s_sender_yahoo_id);
				  $ret_[$i_cnt]["s_sender_contact_no"]	=	get_unformatted_string($row->s_sender_contact_no);
				  $ret_[$i_cnt]["s_sender_address"]		=	get_unformatted_string($row->s_sender_address);
				  
				  $ret_[$i_cnt]["i_receiver_user_id"]	=	intval($row->i_receiver_user_id);
				  $ret_[$i_cnt]["s_receiver_user"]		=	get_unformatted_string($row->s_receiver_user);
				  $ret_[$i_cnt]["i_positive"]			=	intval($row->i_positive);
				  $ret_[$i_cnt]["s_positive"]			=	(intval($row->i_positive)==1?"Positive":"Negative");
				  $ret_[$i_cnt]["i_rating"]				=	intval($row->i_rating); 
				  
				  $ret_[$i_cnt]["s_comments"]			=	get_unformatted_string($row->s_comments);
				  $ret_[$i_cnt]["s_terminate_reason"]	=	get_unformatted_string($row->s_terminate_reason);
                 
                  $ret_[$i_cnt]["dt_created_on"]		=	date($this->conf["site_date_format"],intval($row->i_created_date)); 
				  $ret_[$i_cnt]["fn_created_on"]		=	date($this->conf["front_db_date_format"],intval($row->i_created_date));
                  $ret_[$i_cnt]["i_status"]				=	intval($row->i_status); 
				  $ret_[$i_cnt]["s_status"]				=	(intval($row->i_status)==1?"Approved":"Rejected");
				  
				  $ret_[$i_cnt]["f_positive_feedback_percentage"]	=	empty($row->f_positive_feedback_percentage)?0:doubleval($row->f_positive_feedback_percentage);
				  
				  $ret_[$i_cnt]["buyer_dtails"]			= 	$CI->manage_buyers_model->fetch_this($row->i_sender_user_id);	
                  
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
	
	
	/* listing*/
	public function fetch_multi_sorted_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {
			//$s_wh = " ORDER BY n.i_created_date DESC ";
          	$ret_=array();
			$s_qry="SELECT n.*, u.s_name AS s_sender_user,u.i_role AS type,r.i_role AS user_type, r.s_name AS s_receiver_user,j.s_title AS s_job_title,j.s_description AS s_job_description,c.s_category_name FROM ".$this->tbl." n ".
					" LEFT JOIN ".$this->tbl_users." AS u ON n.i_sender_user_id = u.id ".
					" LEFT JOIN ".$this->tbl_users." AS r ON n.i_receiver_user_id = r.id".
					" INNER JOIN ".$this->tbl_jobs." AS j ON n.i_job_id = j.id ".
					" LEFT JOIN ".$this->tbl_cat." AS c ON j.i_category_id = c.id "
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by} ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          //echo $s_qry;
		  $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]					=	$row->id;////always integer
				  $ret_[$i_cnt]["i_job_id"]				=	intval($row->i_job_id);
				  $ret_[$i_cnt]["s_job_title"]			=	get_unformatted_string($row->s_job_title);
				  $s_desc = stripslashes(htmlspecialchars_decode($row->s_job_description));
				  $ret_[$i_cnt]["s_part_description"]	=	string_part($s_desc,150);
				  $ret_[$i_cnt]["s_category_name"]		=	get_unformatted_string($row->s_category_name);
				  $ret_[$i_cnt]["i_sender_user_id"]		=	intval($row->i_sender_user_id);
				  $ret_[$i_cnt]["s_sender_user"]		=	get_unformatted_string($row->s_sender_user);
				  $ret_[$i_cnt]["s_sender_type"]		=	intval($row->type);
				  
				  $ret_[$i_cnt]["i_receiver_user_id"]	=	intval($row->i_receiver_user_id);
				  $ret_[$i_cnt]["s_receiver_user"]		=	get_unformatted_string($row->s_receiver_user);
				  $ret_[$i_cnt]["s_receiver_type"]		=	get_unformatted_string($row->user_type);
				  
				  $ret_[$i_cnt]["i_positive"]			=	intval($row->i_positive);
				  $ret_[$i_cnt]["s_positive"]			=	(intval($row->i_positive)==1?"Positive":"Negative");
				  $ret_[$i_cnt]["i_rating"]				=	intval($row->i_rating); 
				  
				  $ret_[$i_cnt]["s_comments"]			=	get_unformatted_string($row->s_comments);
				  
				  $ret_[$i_cnt]["s_terminate_reason"]	=	get_unformatted_string($row->s_terminate_reason);
                 
                  $ret_[$i_cnt]["dt_created_on"]		=	date($this->conf["site_date_format"],intval($row->i_created_date)); 
                  $ret_[$i_cnt]["i_status"]				=	intval($row->i_status); 
				  $ret_[$i_cnt]["s_status"]				=	(intval($row->i_status)==1?"Approved":"Rejected");
                  
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
	
	
	
	
	
	// to get job title
	public function get_job_title($i_id)
	{
		try
		{
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select * "
                ."From ".$this->tbl_jobs." AS j "
                ." Where j.id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {				 
                  $ret_["s_title"]=get_unformatted_string($row->s_title); 		  
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_id);
          return $ret_["s_title"];
          
        }
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          		
	}
	
	// to get feedback sender and feedback receiver user
	public function get_feedback_send_user($i_id)
	{
		try
		{
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select * "
                ."From ".$this->tbl_users." AS u "
                ." Where u.id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {				 
                  $ret_["s_name"]=get_unformatted_string($row->s_name); 
				 	  
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_id);
          return $ret_["s_name"];
          
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
                ."From ".$this->tbl." n ".
				" LEFT JOIN ".$this->tbl_users." AS u ON n.i_sender_user_id = u.id ".
				" LEFT JOIN ".$this->tbl_users." AS r ON n.i_receiver_user_id = r.id".
				" LEFT JOIN ".$this->tbl_jobs." AS j ON n.i_job_id = j.id ".
				" LEFT JOIN ".$this->tbl_cat." AS c ON j.i_category_id = c.id "
				//." LEFT JOIN {$this->db->CATEGORYCHILD} cat_c ON cat_c.i_cat_id = c.id"
                .($s_where!=""?$s_where:"" );
          $rs=$this->db->query($s_qry);
		  //echo $this->db->last_query();exit;
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
          $s_qry="Select * "
                ."From ".$this->tbl." AS n "
                ." Where n.id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]					=	$row->id;////always integer
				  $ret_["i_job_id"]				=	intval($row->i_job_id);
				  $ret_["s_job_title"]			=	$this->get_job_title($ret_["i_job_id"]);
				  
				  $ret_["i_sender_user_id"]		=	intval($row->i_sender_user_id);
				  $ret_["s_sender_user"]		=	$this->get_feedback_send_user($ret_["i_sender_user_id"]);
				  
				  $ret_["i_receiver_user_id"]	=	intval($row->i_receiver_user_id);
				  $ret_["s_receiver_user"]		=	$this->get_feedback_send_user($ret_["i_receiver_user_id"]);
				  
				  $ret_["s_comments"]			=	get_unformatted_string($row->s_comments);
				  $ret_["s_terminate_reason"]			=	get_unformatted_string($row->s_terminate_reason);
				  $ret_["i_rating"]				=	intval($row->i_rating); 
				  $ret_["i_positive"]			=	intval($row->i_positive);
				  $ret_["s_positive"]			=	(intval($row->i_positive)==1?"Positive":"Negative");
                 
                  $ret_["dt_created_on"]		=	date($this->conf["site_date_format"],intval($row->i_created_date)); 
                  $ret_["i_status"]				=	intval($row->i_status); 
				  $ret_["s_status"]				=	(intval($row->i_status)==1?"Approved":"Rejected");
				  $ret_["i_feedback_complete_status"]=	intval($row->i_feedback_complete_status); 
		  
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
        
		
public function fetch_feedback_rating($s_where)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select AVG(i_rating) i_rating, SUM(i_positive) i_positive "
                ."From ".$this->tbl." AS n "
                 .$s_where
				//." GROUP BY i_receiver_user_id"
				;
                
          $rs=$this->db->query($s_qry); 
		  //echo $this->db->last_query();
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
				  {				  
                  $ret_["i_rating"]					=	$row->i_rating;////always integer
				  $ret_["i_positive"]					=	$row->i_positive;////always integer
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
		
	
	public function fetch_feedback_positive($s_where)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select count(i_positive) i_positive "
                ."From ".$this->tbl." AS n "
                 .$s_where
				." GROUP BY i_receiver_user_id"
				;
                
          $rs=$this->db->query($s_qry); 
		  //echo $this->db->last_query();
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
				  {				  
                  
				  $ret_["i_positive"]					=	$row->i_positive;////always integer
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
                $s_qry.=" s_title=? ";
                $s_qry.=", s_description=? ";
                $s_qry.=", i_status=? ";
                $s_qry.=", dt_entry_date=? ";
                
                $this->db->query($s_qry,array(
												  trim(htmlspecialchars($info["s_title"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_description"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_status"]),
												  intval($info["dt_entry_date"])
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  trim(htmlspecialchars($info["s_title"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_description"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_status"]),
												  intval($info["dt_entry_date"])
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
				$s_qry.=" s_comments=? ";
				$s_qry.=", s_terminate_reason=? ";
                $s_qry.=", i_rating=? ";
                //$s_qry.=", i_status=? ";
				$s_qry.=", i_positive=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(
													  get_unformatted_string($info["s_comments"], ENT_QUOTES, 'utf-8'),
													  get_unformatted_string($info["s_terminate_reason"], ENT_QUOTES, 'utf-8'),
													  intval($info["i_rating"]),
                                                      //intval($info["i_status"]),
													  intval($info["i_positive"]),
													  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
													  get_unformatted_string($info["s_comments"], ENT_QUOTES, 'utf-8'),
													  get_unformatted_string($info["s_terminate_reason"], ENT_QUOTES, 'utf-8'),
													  intval($info["i_rating"]),
                                                      //intval($info["i_status"]),
													  intval($info["i_positive"]),
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
                $s_qry.=" Where i_id=? ";
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
	
    public function __destruct()
    {}                 
  
  
}
///end of class
?>