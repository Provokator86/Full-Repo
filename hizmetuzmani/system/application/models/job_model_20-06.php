<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 26 April 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
* Model For jobs
* 
* @package Content Management
* @subpackage Testimonial
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/testimonial.php
* @link views/admin/testimonial/
*/


class Job_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
	private $tbl_user;
	private $tbl_cat;
	private $tbl_lang;
	private $tbl_province;
	private $tbl_city;
	private $tbl_zipcode;
	private $tbl_job_quotes;
	private $tbl_job_files;
	private $tbl_job_invitation;
	private $tbl_job_history;
	private $tbl_job_payment_history;
	private $tbl_waiver_payment;
	private $tbl_trade_detail;
	private $tbl_trade_member;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl 						= $this->db->JOBS;
		  $this->tbl_job_quotes 			= $this->db->JOBQUOTES;
		  $this->tbl_province 				= $this->db->PROVINCE;
		  $this->tbl_city 					= $this->db->CITY;
		  $this->tbl_zipcode 				= $this->db->ZIPCODE;
		  $this->tbl_job_files 				= $this->db->JOBS_FILES;   
		  $this->tbl_user 					= $this->db->MST_USER; 
		  $this->tbl_cat 					= $this->db->CATEGORY;  
		  $this->tbl_lang 					= $this->db->LANGUAGE;      
		  $this->tbl_job_invitation 		= $this->db->JOB_INVITATION; 
		  $this->tbl_job_history 			= $this->db->JOB_HISTORY;
		  $this->tbl_job_payment_history 	= $this->db->JOB_PAYMENT_HISTORY;		  
		  $this->tbl_waiver_payment 		= $this->db->WAIVER_PAYMENT;
		  $this->tbl_trade_detail 			= $this->db->TRADESMANDETAILS;
		  $this->tbl_trade_member 			= $this->db->TRADESMAN_MEMBERSHIP;
		  
		  $this->tbl_membership         	= $this->db->MEMBERSHIPPLAN;
		 
		  
          $this->conf =& get_config();
		  $this->s_lang_prefix=   $this->session->userdata('lang_prefix');
		  
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
    public function fetch_multi($s_where=null,$i_start=null,$i_limit=null,$order_by="n.i_created_date")
    {
		
        try
        {
          	$ret_=array();
			$s_qry = "SELECT n.*,cat.{$this->s_lang_prefix}_s_category_name AS s_category_name,
			 z.postal_code, s.province, c.city, z.latitude , z.longitude, tradesman.s_username, 
			 tradesman.s_email, tradesman.s_address, tradesman.s_contact_no, buyer.s_username s_buyer_name
					 FROM ".$this->tbl." n "
					." LEFT JOIN {$this->tbl_cat} cat ON n.i_category_id = cat.i_id"
					." LEFT JOIN {$this->tbl_zipcode} z ON n.i_zipcode_id = z.id"
					." LEFT JOIN {$this->tbl_province} s ON n.i_province_id = s.id"
					." LEFT JOIN {$this->tbl_city} c ON n.i_city_id = c.id"
					." LEFT JOIN {$this->tbl_user} tradesman ON tradesman.id = n.i_tradesman_id"
					." LEFT JOIN {$this->tbl_user} buyer ON buyer.id = n.i_buyer_user_id"
					." LEFT JOIN {$this->tbl_job_invitation} inv ON n.id = inv.i_job_id"
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_by} DESC" .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
		  //echo $s_qry; 
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
				  $ret_[$i_cnt]["i_buyer_user_id"]=$row->i_buyer_user_id;
                  $ret_[$i_cnt]["s_title"]=stripslashes(htmlspecialchars_decode($row->s_title)); 
				  $ret_[$i_cnt]["s_part_title"] = string_part($ret_[$i_cnt]["s_title"],40);				  
				 // $ret_[$i_cnt]["s_category_name"]=stripslashes(htmlspecialchars_decode($row->s_category_name)); 
				  $ret_[$i_cnt]["s_category_name"]		=  get_unformatted_string($row->s_category_name); 
				  if(empty($ret_[$i_cnt]["s_category_name"]))
				  {
				  $ret_[$i_cnt]["s_category_name"]		=  get_unformatted_string($row->{$this->site_default_lang_prefix.'_s_category_name'}); 
				  }
				 
				  $s_desc = stripslashes(htmlspecialchars_decode($row->s_description));
				  if(strlen($s_desc)>197)
				  	$s_desc = substr_replace($s_desc,'...',200);
				  $ret_[$i_cnt]["s_description"]= $s_desc;
				  $ret_[$i_cnt]["d_budget_price"]		= doubleval($row->d_budget_price);
				  $ret_[$i_cnt]["s_budget_price"]		= doubleval($row->d_budget_price).' '.$this->conf["default_currency"];
				  $ret_[$i_cnt]["s_province"]			= stripslashes(htmlspecialchars_decode($row->province)); 
				  $ret_[$i_cnt]["s_city"]				= get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["s_postal_code"]		= get_unformatted_string($row->postal_code); 
				  $ret_[$i_cnt]["i_days_left"] 			= ($row->i_expire_date)?round(($row->i_expire_date-time()) / 86400):0;
				  $ret_[$i_cnt]["s_days_left"] 			= ($ret_[$i_cnt]["i_days_left"]>1) ? $ret_[$i_cnt]["i_days_left"].' days' :' 0 day';
				  
                  $ret_[$i_cnt]["dt_entry_date"]		= date($this->conf["site_date_format"],intval($row->i_created_date));
				  $ret_[$i_cnt]["dt_completed_date"]	= date($this->conf["site_date_format"],intval($row->i_completed_date));
				  $ret_[$i_cnt]["dt_expired_date"]		= ($row->i_expire_date)?date($this->conf["site_date_format"],intval($row->i_expire_date)):'N/A';
				  $ret_[$i_cnt]["dt_fn_assigned_date"]	= ($row->i_assigned_date) ? date($this->conf["front_job_date_format"],intval($row->i_assigned_date)):'';
				  
				  $s_where = " WHERE i_job_id={$row->id} And i_status!=3";
				  $ret_[$i_cnt]["i_quotes"]		= $this->gettotal_job_quote_info($s_where);
				  
				  
				  $ret_[$i_cnt]["s_username"]	= get_unformatted_string($row->s_username); 
				  $ret_[$i_cnt]["s_email"]		= get_unformatted_string($row->s_email); 
				  $ret_[$i_cnt]["s_address"]	= get_unformatted_string($row->s_address); 
				  $ret_[$i_cnt]["s_contact_no"]	= get_unformatted_string($row->s_contact_no); 
				  
				  $ret_[$i_cnt]["s_buyer_name"]	= get_unformatted_string($row->s_buyer_name); 				  
				  
                  $ret_[$i_cnt]["i_is_active"]	= intval($row->i_status); 
				  $ret_[$i_cnt]["i_status"]		= intval($row->i_status); 
				  $ret_[$i_cnt]["s_is_active"]	= $this->db->JOBSTATUS[$row->i_status];				  
				 $ret_[$i_cnt]["i_tradesman_id"]=$row->i_tradesman_id;////always integer 
                  
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
					." LEFT JOIN {$this->tbl_cat} cat ON n.i_category_id = cat.i_id"
					." LEFT JOIN {$this->tbl_zipcode} z ON n.i_zipcode_id = z.id"
					." LEFT JOIN {$this->tbl_province} s ON n.i_province_id = s.id"
					." LEFT JOIN {$this->tbl_city} c ON n.i_city_id = c.id"
					." LEFT JOIN {$this->tbl_user} tradesman ON tradesman.id = n.i_tradesman_id"
					." LEFT JOIN {$this->tbl_user} buyer ON buyer.id = n.i_buyer_user_id"   
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
    
	
	/* this fuction called in home page jobs just completed */
	public function fetch_multi_completed($s_where=null,$i_start=null,$i_limit=null)
    {
		
        try
        {
          	$ret_=array();
			
			$s_qry = "SELECT n.*,cat.{$this->s_lang_prefix}_s_category_name AS s_category_name,cat.i_id AS i_category_id,
			cat.s_icon,z.postal_code,s.province, c.city, z.latitude , z.longitude, tradesman.s_username,tradesman.s_email,
			tradesman.s_address,tradesman.s_contact_no,detail.s_gsm_no,buyer.s_username AS s_buyer_name,buyer.s_address AS
			s_buyer_address,buyer.s_email AS s_buyer_email FROM ".$this->tbl." n "
					." LEFT JOIN ".$this->tbl_cat." cat ON n.i_category_id = cat.i_id"
					." LEFT JOIN ".$this->tbl_zipcode." z ON n.i_zipcode_id = z.id"
					." LEFT JOIN ".$this->tbl_province." s ON n.i_province_id = s.id"
					." LEFT JOIN ".$this->tbl_city." c ON n.i_city_id = c.id"
					." LEFT JOIN ".$this->tbl_user." tradesman ON tradesman.id = n.i_tradesman_id"
					." LEFT JOIN ".$this->tbl_user." buyer ON buyer.id = n.i_buyer_user_id"
					." LEFT JOIN ".$this->tbl_trade_detail." AS detail ON detail.i_user_id = tradesman.id "
                .($s_where!=""?$s_where:"" ). " ORDER BY n.i_created_date DESC" .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
		 //echo "<br/> 4::".$s_qry."<br/>"; 
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
				  $ret_[$i_cnt]["i_buyer_user_id"]		=  $row->i_buyer_user_id;
                  $ret_[$i_cnt]["s_title"]				=  stripslashes(htmlspecialchars_decode($row->s_title)); 
				  $ret_[$i_cnt]["s_part_title"] 		=  string_part($ret_[$i_cnt]["s_title"],40);
				  $ret_[$i_cnt]["s_keyword"] 			=  get_unformatted_string($row->s_keyword);
				  $ret_[$i_cnt]["s_icon"] 				=  get_unformatted_string($row->s_icon);
				  $ret_[$i_cnt]["i_category_id"]		=  intval($row->i_category_id);
				  
				  $ret_[$i_cnt]["s_category_name"]		=  get_unformatted_string($row->s_category_name); 
				  if(empty($ret_[$i_cnt]["s_category_name"]))
				  {
				  $ret_[$i_cnt]["s_category_name"]		=  get_unformatted_string($row->{$this->site_default_lang_prefix.'_s_category_name'}); 
				  }
				   
				  $s_desc = stripslashes(htmlspecialchars_decode($row->s_description));
				  if(strlen($s_desc)>197)
				  	$s_desc = substr_replace($s_desc,'...',204);
				  $ret_[$i_cnt]["s_description"]		= $s_desc;
				  $ret_[$i_cnt]["d_budget_price"]		= doubleval($row->d_budget_price);
				  $ret_[$i_cnt]["s_budget_price"]		= doubleval($row->d_budget_price).' '.$this->conf["default_currency"];
				  $ret_[$i_cnt]["s_province"]			= stripslashes(htmlspecialchars_decode($row->province)); 
				  $ret_[$i_cnt]["s_city"]				= get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["s_postal_code"]		= get_unformatted_string($row->postal_code); //job_time_left
				  //$ret_[$i_cnt]["i_days_left"] 			= ($row->i_expire_date)?round((($row->i_expire_date)-time()) / 86400):0;
				  //$ret_[$i_cnt]["s_days_left"] 			= ($ret_[$i_cnt]["i_days_left"]>1) ? $ret_[$i_cnt]["i_days_left"].' days' :' 0 day';
				  $ret_[$i_cnt]["i_days_left"] 			= job_time_left(intval($row->i_expire_date));				 
				  $ret_[$i_cnt]["s_days_left"] 			= job_time_left(intval($row->i_expire_date));
				  
				  $ret_[$i_cnt]["i_entry_date"]			= intval($row->i_created_date);
				  $ret_[$i_cnt]["i_approve_date"]		= intval($row->i_admin_approval_date);
                  $ret_[$i_cnt]["dt_entry_date"]		= date($this->conf["site_date_format"],intval($row->i_created_date));
				  $ret_[$i_cnt]["dt_completed_date"]	= date($this->conf["site_date_format"],intval($row->i_completed_date));
				  $ret_[$i_cnt]["dt_expired_date"]		= ($row->i_expire_date)?date($this->conf["site_date_format"],intval($row->i_expire_date)):'N/A';
				  $ret_[$i_cnt]["dt_fn_assigned_date"]	= ($row->i_assigned_date) ? date($this->conf["site_date_format"],intval($row->i_assigned_date)):'';
				  
				  $s_where = " WHERE i_job_id={$row->id} And i_status!=3";
				  $ret_[$i_cnt]["i_quotes"]				= $this->gettotal_job_quote_info($s_where);	
				  $ret_[$i_cnt]["max_quote"]			= $this->get_quote_high_low($row->id);	
				  $ret_[$i_cnt]["avg_quote"]			= $this->get_quote_average($row->id);		  
				  
				  $ret_[$i_cnt]["s_username"]			= get_unformatted_string($row->s_username); 
				  $ret_[$i_cnt]["s_email"]				= get_unformatted_string($row->s_email); 
				  $ret_[$i_cnt]["s_address"]			= get_unformatted_string($row->s_address); 
				  $ret_[$i_cnt]["s_contact_no"]			= get_unformatted_string($row->s_contact_no);				  
				  $ret_[$i_cnt]["s_buyer_name"]			= get_unformatted_string($row->s_buyer_name); 
				  $ret_[$i_cnt]["s_buyer_address"]		= get_unformatted_string($row->s_buyer_address);
				  $ret_[$i_cnt]["s_buyer_email"]		= get_unformatted_string($row->s_buyer_email);
				  
				  $ret_[$i_cnt]["s_gsm_no"]				= get_unformatted_string($row->s_gsm_no);				  
				  
                  $ret_[$i_cnt]["i_is_active"]			= intval($row->i_status); 
				  $ret_[$i_cnt]["i_status"]				= intval($row->i_status); 
				  $ret_[$i_cnt]["s_is_active"]			= $this->db->JOBSTATUS[$row->i_status];
				  
				 $ret_[$i_cnt]["i_tradesman_id"]		= $row->i_tradesman_id;////always integer 
				                  
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
	
	
	public function fetch_multi_completed_for_radar_cron($s_where=null,$i_start=null,$i_limit=null)
    {
		
        try
        {
          	$ret_=array();
			$start_time =time() -10800;//strtotime(date('Y-m-d H:i:s'));	
			$end_time	= 	time();
			$s_qry = "SELECT n.*, z.postal_code, s.province, c.city, tradesman.s_username,tradesman.s_email,
					 tradesman.s_address, tradesman.s_contact_no, buyer.s_username AS s_buyer_name
					 FROM ".$this->tbl." n "
					." LEFT JOIN {$this->tbl_cat} cat ON n.i_category_id = cat.i_id"
					." LEFT JOIN {$this->tbl_zipcode} z ON n.i_zipcode_id = z.id"
					." LEFT JOIN {$this->tbl_province} s ON n.i_province_id = s.id"
					." LEFT JOIN {$this->tbl_city} c ON n.i_city_id = c.id"
					." LEFT JOIN {$this->tbl_user} tradesman ON tradesman.id = n.i_tradesman_id"
					." LEFT JOIN {$this->tbl_user} buyer ON buyer.id = n.i_buyer_user_id"
                .($s_where!=""?$s_where:"" )." And n.i_admin_approval_date BETWEEN ".$start_time." And ".$end_time." ". " ORDER BY n.i_created_date DESC" .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
		 //echo "<br/> 4::".$s_qry."<br/>"; 
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
				  $ret_[$i_cnt]["i_buyer_user_id"]		= $row->i_buyer_user_id;
                  $ret_[$i_cnt]["s_title"]				= get_unformatted_string($row->s_title); 
				  $ret_[$i_cnt]["s_part_title"] 		= string_part($ret_[$i_cnt]["s_title"],40);
				  
				  $ret_[$i_cnt]["s_category_name"]		= get_unformatted_string($row->s_category_name); 
				  $s_desc 								= get_unformatted_string($row->s_description);
				  if(strlen($s_desc)>197)
				  	$s_desc = substr_replace($s_desc,'...',200);
				  $ret_[$i_cnt]["s_description"]		= $s_desc;
				  $ret_[$i_cnt]["d_budget_price"]		= doubleval($row->d_budget_price);
				  $ret_[$i_cnt]["s_budget_price"]		= doubleval($row->d_budget_price).' '.$this->conf["default_currency"];
				  $ret_[$i_cnt]["s_province"]				= get_unformatted_string($row->province); 
				  $ret_[$i_cnt]["s_city"]				= get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["s_postal_code"]		= get_unformatted_string($row->postal_code); 
				  $ret_[$i_cnt]["i_days_left"] 			= ($row->i_expire_date)?round(($row->i_expire_date-time()) / 86400):0;
				  $ret_[$i_cnt]["s_days_left"] 			= ($ret_[$i_cnt]["i_days_left"]>1) ? $ret_[$i_cnt]["i_days_left"].' days' :' 0 day';
				  
                  $ret_[$i_cnt]["dt_entry_date"]		= date($this->conf["site_date_format"],intval($row->i_created_date));
				  $ret_[$i_cnt]["dt_completed_date"]	= date($this->conf["site_date_format"],intval($row->i_completed_date));
				  $ret_[$i_cnt]["dt_expired_date"]		= ($row->i_expire_date)?date($this->conf["site_date_format"],intval($row->i_expire_date)):'N/A';
				  $ret_[$i_cnt]["dt_fn_assigned_date"]	= ($row->i_assigned_date) ? date($this->conf["front_job_date_format"],intval($row->i_assigned_date)):'';
				  
				  $s_where = " WHERE i_job_id={$row->id} And i_status!=3";
				  $ret_[$i_cnt]["i_quotes"]			=	$this->gettotal_job_quote_info($s_where);				  
				  
				  $ret_[$i_cnt]["s_username"]		=	get_unformatted_string($row->s_username); 
				  $ret_[$i_cnt]["s_email"]			=	get_unformatted_string($row->s_email); 
				  $ret_[$i_cnt]["s_address"]		=	get_unformatted_string($row->s_address); 
				  $ret_[$i_cnt]["s_contact_no"]		= 	get_unformatted_string($row->s_contact_no); 				  
				  $ret_[$i_cnt]["s_buyer_name"]		=	get_unformatted_string($row->s_buyer_name); 				  
				  
                  $ret_[$i_cnt]["i_is_active"]		= 	intval($row->i_status); 
				  $ret_[$i_cnt]["i_status"]			= 	intval($row->i_status); 
				  $ret_[$i_cnt]["s_is_active"]		= 	$this->db->JOBSTATUS[$row->i_status];				  
				 $ret_[$i_cnt]["i_tradesman_id"]	=	$row->i_tradesman_id;////always integer 
                  
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
	
	
	public function fetch_multi_sorted_quote_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {	
          $ret_=array();
		  $s_qry = "SELECT n.*,j.s_title AS job_title,buyer.s_name AS buyer_name, tradesman.s_name, 
		  			tradesman.id i_tradesman_id, c.city FROM ".$this->tbl_job_quotes." n "
					." LEFT JOIN ".$this->tbl_user." tradesman ON n.i_tradesman_user_id = tradesman.id"
					." LEFT JOIN ".$this->tbl_city." c ON tradesman.i_city = c.id"
					." LEFT JOIN ".$this->tbl." j ON j.id = n.i_job_id "
					." LEFT JOIN ".$this->tbl_user." buyer ON buyer.id = j.i_buyer_user_id "
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}" .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          
		  $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]			= $row->id;////always integer
				  $ret_[$i_cnt]["i_job_id"]		= $row->i_job_id;
				  $ret_[$i_cnt]["i_job_status"]	= $this->get_job_status($row->i_job_id); 
				  $ret_[$i_cnt]["i_tradesman_id"]=intval($row->i_tradesman_id);////always integer\
				  $ret_[$i_cnt]["i_view"]		= intval($row->i_view);
				  $ret_[$i_cnt]["s_name"]		= get_unformatted_string($row->s_name); 
				  $ret_[$i_cnt]["s_comment"]	= get_unformatted_string($row->s_comment); 
				  $ret_[$i_cnt]["job_title"]	= get_unformatted_string($row->job_title);
				  $ret_[$i_cnt]["buyer_name"]	= get_unformatted_string($row->buyer_name);
				  
				  
				  $ret_[$i_cnt]["s_status"]		= $this->db->QUOTESTATE[$row->i_status]; 
				  $ret_[$i_cnt]["i_status"]		= $row->i_status; 
				  $ret_[$i_cnt]["s_city"]		= get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["d_quote"]		= doubleval($row->d_quote); 
				  $ret_[$i_cnt]["s_quote"]		= doubleval($row->d_quote);
				  $ret_[$i_cnt]["dt_created_on"]= date($this->conf["site_date_format"],intval($row->i_created_date));
                  
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
	
	
	
	
    /*******
    * Fetches One record from db for the id value.
    * 
    * @param int $i_id
    * @returns array
    */
    public function fetch_this($i_id,$i_lang_id=1)
    {
        try
        {
			
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select n.*, z.postal_code, s.province, c.city, z.latitude s_latitude, z.longitude s_longitude, 
		  			u.s_username,u.s_email, u.s_lat s_buyer_latitide, u.s_lng s_buyer_longitude, trades.s_username s_tradesman_name,cat.{$this->s_lang_prefix}_s_category_name s_category_name"
                ." From ".$this->tbl." AS n "
				." INNER JOIN ".$this->tbl_user." u ON n.i_buyer_user_id = u.id"
				." LEFT JOIN ".$this->tbl_user." trades ON n.	i_tradesman_id = trades.id"
				." LEFT JOIN ".$this->tbl_zipcode." z ON n.i_zipcode_id = z.id"
				." LEFT JOIN ".$this->tbl_province." s ON n.i_province_id = s.id"
				." LEFT JOIN ".$this->tbl_city." c ON n.i_city_id = c.id"
				." lEFT JOIN ".$this->tbl_cat." cat ON cat.i_id = n.i_category_id"
                ." Where n.id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
		  //echo $this->db->last_query();exit;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]						=	$row->id;////always integer		
				  $ret_["i_buyer_user_id"]			=	$row->i_buyer_user_id;
				  $ret_["i_tradesman_id"]			=	$row->i_tradesman_id;
				  $ret_['s_tradesman_name']			=	get_unformatted_string($row->s_tradesman_name);
				  $ret_['s_buyer_name']				=	get_unformatted_string($row->s_username);
				  $ret_['s_email']				    =	get_unformatted_string($row->s_email);
				  $ret_['s_buyer_latitide']			=	get_unformatted_string($row->s_buyer_latitide);
				  $ret_['s_buyer_longitude']		=	get_unformatted_string($row->s_buyer_longitude);	
				  $ret_['s_job_lattitude']			=	get_unformatted_string($row->s_job_lattitude);
				  $ret_['s_job_longitude']			=	get_unformatted_string($row->s_job_longitude);
				  $ret_["i_category_id"]			=	$row->i_category_id;
				  $ret_["i_city_id"]				=	intval($row->i_city_id);
				  //$ret_['s_category']				=	$this->get_category_name($ret_["i_category_id"],$i_lang_id);	  
				  $ret_['s_category']				=	get_unformatted_string($row->s_category_name);
				  if($ret_['s_category']=='')
				  {
				  $ret_['s_category']				=	get_unformatted_string($row->{$this->site_default_lang_prefix.'_s_category_name'});
				  }
                  $ret_["s_title"]					=	stripslashes(htmlspecialchars_decode($row->s_title)); 
				  $ret_["s_description"]			=	stripslashes(htmlspecialchars_decode($row->s_description)); 
				  $ret_["d_budget_price"]			=	stripslashes(htmlspecialchars_decode($row->d_budget_price));
				  $ret_["s_budget_price"]			=	$ret_["d_budget_price"].' '.$this->conf["default_currency"];
				  $ret_["i_quoting_period_days"]	=	intval($row->i_quoting_period_days);
				  
				  $ret_["i_approval_date"]			=	intval($row->i_admin_approval_date);
				  $ret_["i_created_date"]			=	intval($row->i_created_date);
                  $ret_["dt_entry_date"]			=	date($this->conf["site_date_format"],intval($row->i_created_date));
				  $ret_["dt_approval_date"]			=	date($this->conf["site_date_format"],intval($row->i_admin_approval_date));
				  $ret_["dt_expire_date"]			=	date($this->conf["site_date_format"],intval($row->i_expire_date));
				  
                  $ret_["dt_front_entry_date"]		=	date($this->conf["front_job_date_format"],intval($row->i_created_date));
				  $ret_["dt_front_approval_date"]	=	$row->i_admin_approval_date?date($this->conf["front_job_date_format"],intval($row->i_admin_approval_date)):'N/A';
				  $ret_["dt_front_expire_date"]		=	$row->i_expire_date?date($this->conf["front_job_date_format"],intval($row->i_expire_date)):'N/A';
				  $ret_["dt_front_i_assigned_date"]	=	date($this->conf["front_job_date_format"],intval($row->i_assigned_date));
				  
				  $ret_["i_days_left"] 				=  ($row->i_expire_date)?round(($row->i_expire_date-time()) / 86400):0;
		
				  $ret_["s_days_left"] 				= ($ret_["i_days_left"]>1) ? $ret_["i_days_left"].' days' : '0 day'; 
				  $ret_["s_supply_material"]		=	$this->db->JOB_MATERIAL[$row->i_supply_material];   
				  $ret_["s_keyword"]				=	stripslashes(htmlspecialchars_decode($row->s_keyword));  
				  $s_where = " WHERE i_job_id={$row->id} And i_status!=3 ";  
				  $ret_["i_quotes"]					=	$this->gettotal_job_quote_info($s_where); 
				  //$ret_["i_lowest_quote"]			=	$this->get_lowest_quote($s_where);  
				  $ret_["i_lowest_quote"]			=	$this->get_quote_high_low($row->id,0);
				  $ret_["s_lowest_quote"]			=	$ret_["i_lowest_quote"].' '.$this->conf["default_currency"];
				  
				  $ret_["s_province"]					=	stripslashes(htmlspecialchars_decode($row->province)); 
				  $ret_["s_city"]					=	stripslashes(htmlspecialchars_decode($row->city)); 
				  $ret_["s_postal_code"]			=	stripslashes(htmlspecialchars_decode($row->postal_code)); 
				 // $ret_["s_postal_code"]			=	stripslashes(htmlspecialchars_decode($row->postal_code)); 
				  $ret_["s_latitude"]				=	stripslashes(htmlspecialchars_decode($row->s_latitude)); 
				  $ret_["s_longitude"]				=	stripslashes(htmlspecialchars_decode($row->s_longitude)); 
				         
				  $ret_["i_is_active"]				=	intval($row->i_status); 
				  $ret_["i_quote_id"]				=	intval($row->i_quote_id); 
				  $ret_["s_is_active"]				=	$this->db->JOBSTATUS[$row->i_status];
				  $s_where = " WHERE i_job_id={$i_id}";
				  $ret_["job_files"]				=	$this->fetch_multi_job_image($s_where); 
		  
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
	
	
	
	/* fetch details of an quote 
	* called from @admin/manage_quotes
	*/   
	public function fetch_this_quote($i_id)
    {
        try
        {
			
          $ret_=array();
          $s_qry="SELECT * FROM ".$this->tbl_job_quotes." AS n  WHERE n.id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]			=	$row->id;////always integer		
				  $ret_['s_comment']	=	get_unformatted_string($row->s_comment);
				  $ret_["d_quote"]		=	get_unformatted_string($row->d_quote);		  
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
	
	
	
	/* get job history*/
	public function fetch_job_history($s_where=null,$i_start=null,$i_limit=null)
    {
		
        try
        {
          	$ret_=array();
			$s_qry = "SELECT u.s_username,j.s_title,n.* FROM ".$this->tbl_job_history." n "	
					." LEFT JOIN {$this->tbl_user} u ON u.id = n.i_user_id"
					." LEFT JOIN {$this->tbl} j ON j.id = n.i_job_id "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
		  //echo $s_qry;
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_title"]		= get_unformatted_string($row->s_title); 			  
                  $ret_[$i_cnt]["dt_entry_date"]= date($this->conf["site_date_format"],intval($row->i_created_date));		  
				 
				  $ret_[$i_cnt]["s_username"]	= get_unformatted_string($row->s_username); 
				  $ret_[$i_cnt]["s_username"] 	= ($row->i_user_id) ? $ret_[$i_cnt]["s_username"] : 'Admin';
				  $ret_[$i_cnt]["s_message"]	= get_unformatted_string($row->s_message);	
				  
				  $ret_[$i_cnt]["content"]=$this->db->JOB_HISTORY_KEY[stripslashes(htmlspecialchars_decode($row->s_message))];
				  
				  if(!empty($ret_[$i_cnt]["content"]))
					{							
						$description = $ret_[$i_cnt]["content"];
						$description = str_replace("##USERNAME##",$ret_[$i_cnt]["s_username"],$description);	
						$description = str_replace("##TIME##",$ret_[$i_cnt]["dt_entry_date"],$description);		
					}
				
				  $ret_[$i_cnt]["msg_string"] = $description;				  
				  
                  
                  
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
	
	
	
	//get all files of jobs
    public function fetch_multi_job_image($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
          	$ret_=array();
			$s_qry = "SELECT n.*
					 FROM ".$this->tbl_job_files." n "
                .($s_where!=""?$s_where:"" )." " .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
		  //echo $s_qry;
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_file_name"]	=	get_unformatted_string($row->s_file_name); 
				  $ret_[$i_cnt]["s_type"]		=	get_unformatted_string($row->s_type);                   
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
	
	
	/* fetch for invoice details */
	public function fetch_invoice_details($s_where=null,$i_start=null,$i_limit=null)
    {
		
        try
        {
          	$ret_=array();
			$s_qry = "SELECT n.*, z.postal_code, s.province, c.city,pay.i_payment_date,pay.d_pay_amount,pay.i_invoice_no,tradesman.s_username, tradesman.s_address 
					 FROM ".$this->tbl." n "
					." LEFT JOIN {$this->tbl_zipcode} z ON n.i_zipcode_id = z.id"
					." LEFT JOIN {$this->tbl_province} s ON n.i_province_id = s.id"
					." LEFT JOIN {$this->tbl_city} c ON n.i_city_id = c.id"
					." LEFT JOIN {$this->tbl_user} tradesman ON tradesman.id = n.i_tradesman_id"
					." LEFT JOIN {$this->tbl_job_payment_history} pay ON n.id = pay.i_job_id"
                .($s_where!=""?$s_where:"" )." ORDER BY i_created_date DESC" .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
		  //echo $s_qry;
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
				  $ret_[$i_cnt]["i_buyer_user_id"]	= $row->i_buyer_user_id;
                  $ret_[$i_cnt]["s_title"]			= get_unformatted_string($row->s_title); 
				  $ret_[$i_cnt]["s_part_title"] 	= get_unformatted_string($row->s_title); 
				  $s_desc = get_unformatted_string(htmlspecialchars_decode($row->s_description));
				  if(strlen($s_desc)>197)
				  	$s_desc = substr_replace($s_desc,'...',200);
				  //$ret_[$i_cnt]["s_description"]= $s_desc;
				  $ret_[$i_cnt]["d_budget_price"]	= doubleval($row->d_budget_price);
				  $ret_[$i_cnt]["s_budget_price"]	= doubleval($row->d_budget_price).' '.$this->conf["default_currency"];
				  $ret_[$i_cnt]["s_province"]			= get_unformatted_string($row->province); 
				  $ret_[$i_cnt]["s_city"]			= get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["s_postal_code"]	= get_unformatted_string($row->postal_code); 
				  
				  $ret_[$i_cnt]["s_username"]		= get_unformatted_string($row->s_username); 
				  //$ret_[$i_cnt]["s_email"]=get_unformatted_string($row->s_email); 
				  $ret_[$i_cnt]["s_address"]		= get_unformatted_string($row->s_address); 
				  //$ret_[$i_cnt]["s_contact_no"]= get_unformatted_string($row->s_contact_no); 
				  $ret_[$i_cnt]["dt_payment_date"]	= date($this->conf["site_date_format"],intval($row->i_payment_date));
				  $ret_[$i_cnt]["s_paid_amount"]	= doubleval($row->d_pay_amount).' '.$this->conf["default_currency"];
				  $ret_[$i_cnt]["i_invoice_no"]		= get_unformatted_string($row->i_invoice_no); 
				  
				  
                  
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
	
	
	// get buyer name fetching by id
	
	function get_buyer_name($i_id)
	{
		
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select * "
                ."From ".$this->tbl_user." AS n "
                ." Where n.id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]				=	$row->id;////always integer		 
                  $ret_["s_name"]			=	get_unformatted_string($row->s_name); 		  
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
	
	// get category name fetching by id
	
	function get_category_name($i_id,$i_lang_id)
	{
		
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select n.i_id "
                ."From ".$this->tbl_cat." AS n "
                ." Where n.i_id=? ";
                
          $rs=$this->db->query($s_qry,array(intval($i_id),intval($i_lang_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]				=	$row->id;////always integer		 
                  $ret_["s_category_name"]			=	get_unformatted_string($row->s_category_name); 		  
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_id);
          return $ret_["s_category_name"];
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    
	}
	
	
	
	// to show default in form 
	public function get_to_show_default()
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select * "
                ."From ".$this->tbl." AS n "
                ." Where n.i_is_active=?";
                
          $rs=$this->db->query($s_qry,array(intval(1))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]=$row->i_id;////always integer
                  $ret_["s_commission_slab_100"]=stripslashes(htmlspecialchars_decode($row->s_commission_slab_100));
				  $ret_["s_commission_greater_than_100"]=stripslashes(htmlspecialchars_decode($row->s_commission_greater_than_100)); 
                  $ret_["dt_created_on"]=date($this->conf["site_date_format"],intval($row->dt_entry_date)); 		  
				  
                  $ret_["i_is_active"]= intval($row->i_is_active); 
				  $ret_["s_is_active"]=(intval($row->i_is_active)==1?"Active":"Inactive");
		  
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
		//var_dump($info);exit;
        try
        {
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl." Set ";
                $s_qry.=" i_buyer_user_id=? ";
                $s_qry.=", i_category_id=? ";
                $s_qry.=", s_title=? ";
                $s_qry.=", s_description=? ";
				$s_qry.=", i_supply_material=? ";
				$s_qry.=", i_province_id=? ";
				$s_qry.=", i_city_id=? ";
				$s_qry.=", i_zipcode_id=? ";
				$s_qry.=", d_budget_price=? ";
				$s_qry.=", i_quoting_period_days=? ";
				$s_qry.=", i_created_date=? ";
				$s_qry.=", s_keyword=? ";
				$s_qry.=", s_address=? ";
				$s_qry.=", s_job_lattitude=? ";
				$s_qry.=", s_job_longitude=? ";
				
                $this->db->query($s_qry,array(	 
												  intval($info["i_buyer_user_id"]),
												  intval($info["i_category_id"]),
												  get_formatted_string($info["s_title"]),
												  get_formatted_string($info["s_description"]),
												  intval($info["i_supply_material"]),
												  intval($info["i_province_id"]),
												  intval($info["i_city_id"]),
												  intval($info["i_zipcode_id"]),
												  doubleval($info["d_budget_price"]),
												  intval($info["i_quoting_period_days"]),
												  intval($info["i_created_date"]),
												  get_formatted_string($info["s_keyword"]),
												  get_formatted_string($info["s_address"]),
												  get_formatted_string($info["s_job_lattitude"]),
												  get_formatted_string($info["s_job_longitude"])
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
					$this->set_slab($info,$i_ret_); 
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(	 
												  intval($info["i_buyer_user_id"]),
												  intval($info["i_category_id"]),
												  get_formatted_string($info["s_title"]),
												  get_formatted_string($info["s_description"]),
												  intval($info["i_supply_material"]),
												  intval($info["i_province_id"]),
												  intval($info["i_city_id"]),
												  intval($info["i_zipcode_id"]),
												  doubleval($info["d_budget_price"]),
												  intval($info["i_quoting_period_days"]),
												  intval($info["i_created_date"]),
												  get_formatted_string($info["s_keyword"]),
												  get_formatted_string($info["s_address"]),
												  get_formatted_string($info["s_job_lattitude"]),
												  get_formatted_string($info["s_job_longitude"])
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
    * Inserts new records into db. As we know the table name 
    * we will not pass it into params.
    * 
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @returns $i_new_id  on success and FALSE if failed 
    */
    public function add_job_file_info($info)
    {
        try
        {
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl_job_files." Set ";
                $s_qry.=" i_job_id=? ";
                $s_qry.=", s_file_name=? ";
                $s_qry.=", s_type=? ";
				
                $this->db->query($s_qry,array(	  intval($info["i_job_id"]),
												  get_formatted_string($info["s_file_name"]),
												  get_formatted_string($info["s_type"]),
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
					$this->set_slab($info,$i_ret_); 
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(	 
												  intval($info["i_job_id"]),
												  get_formatted_string($info["s_file_name"]),
												  get_formatted_string($info["s_type"]),
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


	function set_job_insert_all($arr)
	{
		if($arr['job']['i_buyer_user_id'] && $arr['job']['i_buyer_user_id']!='' && is_numeric($arr['job']['i_buyer_user_id']))
		{
		 	$job_id = $this->add_info($arr['job']);	
			if($arr['img'])
			{
				foreach($arr['img'] as $value)
				{
					$match = getExtension($value);
					switch($match)
					{
						case ".pdf":
							$type = 'pdf';
							break;
						case ".doc":
							$type = 'doc';
							break;
						default:
							$type = 'image';		
					}
					
					$arr_img = array("i_job_id"=>$job_id,"s_file_name"=>$value,"s_type"=>$type);
					$this->add_job_file_info($arr_img);
				}
			}
			
			/* insert data to job history and stattus change*/
			$arr1 = array();
			$arr1['i_job_id'] =  $job_id;
			$arr1['i_user_id'] =  $arr['job']['i_buyer_user_id'];
			$arr1['s_message'] =  'job_created';
			$arr1['i_created_date'] =  time();
			$table = $this->db->JOB_HISTORY;
			$this->set_data_insert($table,$arr1);					
			/*============*/
			$table = $this->db->JOB_STATUS_HISTORY;
			$arr1 = array();
			$arr1['i_job_id'] =  $job_id;
			$arr1['i_user_id'] =  $arr['job']['i_buyer_user_id'];
			$arr1['s_status'] =  'New';		
			$arr1['i_created_date'] =  time();			
			$this->set_data_insert($table,$arr1);			
			/* end */
			
			$this->session->set_userdata(array('job_post_session'=>''));
			return $job_id;
		 }
		return false;
	}


   
	
	
	/* Edit job quote days*/
    public function edit_quote_days_info($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";
				 $s_qry.=" 	i_quoting_period_days=? ";
                $s_qry.=", i_expire_date=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(
												  intval($info["i_quoting_period_days"]),
												  intval($info["i_expire_date"]),
												  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   

                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  intval($info["i_quoting_period_days"]),
												  intval($info["i_expire_date"]),
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
	
	
	/* delete job */
    public function delete_job($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";
				 $s_qry.=" 	i_is_deleted=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(	 intval($info["i_is_deleted"]),
												  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
				//echo $this->db->last_query();
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(	 intval($info["i_is_deleted"]),
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
	
	
	/* to delete a quote from admin */
	 public function delete_quote($i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
    
            if(intval($i_id)>0)
            {
				$s_qry="DELETE FROM ".$this->tbl_job_quotes." ";
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
				$s_qry="DELETE FROM ".$this->tbl_job_quotes." ";
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
	
	/* Edit job quote is read*/
    public function read_quote($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl_job_quotes." Set ";
				 $s_qry.=" 	i_view=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(
												  intval($info["i_view"]),
												  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   

                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl_job_quotes." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  intval($info["i_view"]),
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
	
	public function gettotal_job_quote_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl_job_quotes." n "
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
	
	
	
	/****  FOR CHECKING DEFAULT SLAB SLECTED   *****/
	public function set_slab($info,$id)
	{
		try
		{
			$i_ret_=0;////Returns false
			if(!empty($info))
			{
				if($info['i_status'] == 1)
				{
					$s_qry	=	"Update ".$this->tbl." Set ";
					$s_qry.=" i_is_active= ?";
					$s_qry.=" Where i_is_active=? ";
					
					$this->db->query($s_qry,array(
													intval(2),
													intval(1)
												));
					$i_ret_=$this->db->affected_rows();   
					
					$s_qry_1	=	"Update ".$this->tbl." Set ";
					$s_qry_1.=" i_is_active= ?";
					$s_qry_1.=" Where i_id=? ";
					
					$this->db->query($s_qry_1,array(
														intval($info["i_status"]),
														intval($id)
													));
					if($i_ret_)
					{
						$logi["msg"]="Updating ".$this->tbl." ";
						$logi["sql"]= serialize(array($s_qry,array(
													intval(2),
													intval(1)
												)) ) ;                                 
						$this->log_info($logi); 
						$logi_1["msg"]="Updating ".$this->tbl." ";
						$logi_1["sql"]= serialize(array($s_qry_1,array(
														intval($info["i_status"]),
														intval($id)
													)) ) ;                                 
						$this->log_info($logi_1); 
						unset($logi);
					}  
				}
				else
				$i_ret_ = true;
			}
			return $i_ret_;
		}
		catch(Exception $err_obj)
		{	
			show_error($err_obj->getMessage());
		}
	}	

	
	
	/* add quote job*/
    public function job_quote($info)
    {
		//var_dump($info);exit;
        try
        {
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl_job_quotes." Set ";
                $s_qry.=" i_tradesman_user_id=? ";
                $s_qry.=", i_job_id=? ";
                $s_qry.=", d_quote=? ";
                $s_qry.=", s_comment=? ";
				$s_qry.=", i_created_date=? ";
				
                $this->db->query($s_qry,array(	  intval($info["i_tradesman_user_id"]),
												  intval($info["i_job_id"]),
												  doubleval($info["d_quote"]),
												  get_formatted_string($info['s_comment']),
												  intval($info["i_created_date"]),
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
					$this->set_slab($info,$i_ret_); 
                    $logi["msg"]="Inserting into ".$this->tbl_job_quotes." ";
                    $logi["sql"]= serialize(array($s_qry,array(	  intval($info["i_tradesman_user_id"]),
												  intval($info["i_job_id"]),
												  doubleval($info["d_quote"]),
												  get_formatted_string($info['s_comment']),
												  intval($info["i_created_date"]),
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
	
	/* get lowest quote of the job*/
	public function get_quote_average($i_job_id='')
    {
        try
        {
          $ret_=0;
          $s_qry="Select avg(n.d_quote) as avg_quote "
                ."From ".$this->tbl_job_quotes." n "
                ." WHERE n.i_job_id = ".$i_job_id;
          $rs=$this->db->query($s_qry);		  
          $i_cnt=0;
		  if($rs)
		  {
              foreach($rs->result() as $row)
              {
                  $ret_=doubleval($row->avg_quote); 
              }   
		 }	   
          
          return $ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    } 
	
	
	public function get_quote_high_low($i_job_id,$flag=1)
	{
		try
        {
          $ret_=0;
		 // echo $flag;
		  $s_part = ($flag==1)?" MAX(d_quote) ": " MIN(d_quote)";
          $s_qry="Select $s_part as i_total "
                ."FROM ".$this->tbl_job_quotes." n "
					
					." WHERE n.i_job_id = ".$i_job_id;
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
	
	
	
	public function get_job_status($i_job_id)
    {
        try
        {
          $ret_=0;
          $s_qry="Select i_status as i_total "
                ."From ".$this->tbl." WHERE id={$i_job_id} "
					
					;
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
          unset($s_qry,$rs,$row,$i_cnt);
          return $ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    } 
	/* get quote list*/
    public function fetch_quote_multi($s_where=null,$i_start=null,$i_limit=null)
    {
		
        try
        {
			//echo $i_lang_id;
          	$ret_=array();
			$s_qry = "SELECT n.*, tradesman.s_username, tradesman.s_name,tradesman.i_signup_lang,tradesman.s_address,
			tradesman.s_address2,tradesman.s_email,tradesman.s_verified,tradesman.id i_tradesman_id, c.city,
					det.i_jobs_won,det.s_gsm_no,det.i_ssn_verified,det.i_address_verified,det.i_mobile_verified,
					det.i_tax_no_verified,lang.s_short_name AS s_lang_prefix	 FROM ".$this->tbl_job_quotes." n "
					." LEFT JOIN {$this->tbl_user} tradesman ON n.i_tradesman_user_id = tradesman.id"
					." LEFT JOIN {$this->tbl_city} c ON tradesman.i_city = c.id"
					." LEFT JOIN ".$this->tbl_trade_detail." det ON det.i_user_id = tradesman.id"
					." LEFT JOIN ".$this->tbl_lang." AS lang ON lang.i_id = tradesman.i_signup_lang "
                .($s_where!=""?$s_where:"" )." ORDER BY n.i_created_date DESC" .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
		  //echo $s_qry;
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
				  $ret_[$i_cnt]["i_job_id"]		= $row->i_job_id;
				  $ret_[$i_cnt]["i_job_status"]	= $this->get_job_status($row->i_job_id); 
				  $ret_[$i_cnt]["i_tradesman_id"]=intval($row->i_tradesman_id);////always integer
                  $ret_[$i_cnt]["s_username"]	= get_unformatted_string($row->s_username); 
				  $ret_[$i_cnt]["s_name"]		= get_unformatted_string($row->s_name); 
				  $ret_[$i_cnt]["s_email"]		= get_unformatted_string($row->s_email); 
				  $ret_[$i_cnt]["s_comment"]	= get_unformatted_string($row->s_comment); 
				  $ret_[$i_cnt]["s_address2"]	= get_unformatted_string($row->s_address2);
				  $ret_[$i_cnt]["s_address"]	= get_unformatted_string($row->s_address);
				  $ret_[$i_cnt]["s_gsm_no"]		= get_unformatted_string($row->s_gsm_no);
				  
				  /* tradesman verification */
				  $ret_[$i_cnt]["i_verified"]	= intval($row->s_verified);////always integer
				  $ret_[$i_cnt]["i_ssn_verified"]= intval($row->i_ssn_verified);////always integer
				  $ret_[$i_cnt]["i_address_verified"]=intval($row->i_address_verified);////always integer
				  $ret_[$i_cnt]["i_mobile_verified"]=intval($row->i_mobile_verified);////always integer
				  $ret_[$i_cnt]["i_tax_no_verified"]=intval($row->i_tax_no_verified);////always integer
				  /* tradesman verification */
				  
				  $ret_[$i_cnt]["i_signup_lang"]= intval($row->i_signup_lang); 	
				  $ret_[$i_cnt]["s_lang_prefix"]= get_unformatted_string($row->s_lang_prefix);			  
				  $ret_[$i_cnt]["i_jobs_won"]	= intval($row->i_jobs_won)?intval($row->i_jobs_won):0;////always integer
				  
				  $ret_[$i_cnt]["s_status"]		= $this->db->QUOTESTATE[$row->i_status]; 
				  $ret_[$i_cnt]["i_status"]		= $row->i_status; 
				  $ret_[$i_cnt]["s_city"]		= get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["d_quote"]		= doubleval($row->d_quote); 
				  $ret_[$i_cnt]["s_quote"]		= doubleval($row->d_quote).' '.$this->conf["default_currency"];
				  $ret_[$i_cnt]["dt_entry_date"]= date($this->conf["site_date_format"],intval($row->i_created_date));
				  $ret_[$i_cnt]["job_details"] 	= $this->fetch_this($row->i_job_id);
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
	
	
	/* get job quote list*/
    public function fetch_job_quote_multi($s_where=null,$i_start=null,$i_limit=null)
    {
		
        try
        {
			//echo $i_lang_id;
          	$ret_=array();
			$s_qry = "SELECT n.*,job.s_title,job.i_city_id,job.i_province_id,job.s_description,job.d_budget_price,
			job.i_expire_date,tradesman.s_username,tradesman.id i_tradesman_id,c.city,s.province,
			z.postal_code,cat.{$this->s_lang_prefix}_s_category_name s_category_name	FROM ".$this->tbl_job_quotes." n "
				." LEFT JOIN ".$this->tbl." job ON n.i_job_id = job.id"
				." LEFT JOIN ".$this->tbl_user." tradesman ON n.i_tradesman_user_id = tradesman.id"
				." LEFT JOIN ".$this->tbl_city." c ON tradesman.i_city = c.id"
				." LEFT JOIN ".$this->tbl_zipcode." z ON job.i_zipcode_id = z.id"
				." LEFT JOIN ".$this->tbl_province." s ON job.i_province_id = s.id"
				." lEFT JOIN ".$this->tbl_cat." cat ON cat.i_id = job.i_category_id"
                .($s_where!=""?$s_where:"" )." ORDER BY n.i_created_date DESC" .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
		  //echo $s_qry;
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
				  $ret_[$i_cnt]["i_job_id"]		= $row->i_job_id;
				  $ret_[$i_cnt]["i_job_status"]	= $this->get_job_status($row->i_job_id); 
				  $ret_[$i_cnt]["i_tradesman_id"]=intval($row->i_tradesman_id);////always integer
                  $ret_[$i_cnt]["s_username"]	= get_unformatted_string($row->s_username); 
				  $ret_[$i_cnt]["s_comment"]	= get_unformatted_string($row->s_comment); 				  
				  $ret_[$i_cnt]["s_status"]		= $this->db->QUOTESTATE[$row->i_status]; 
				  $ret_[$i_cnt]["i_status"]		= $row->i_status; 
				  //$ret_[$i_cnt]["s_city"]		= get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["d_quote"]		= doubleval($row->d_quote); 
				  $ret_[$i_cnt]["s_quote"]		= doubleval($row->d_quote).' '.$this->conf["default_currency"];
				  $ret_[$i_cnt]["dt_entry_date"]= date($this->conf["site_date_format"],intval($row->i_created_date));
				  
				  $ret_[$i_cnt]['s_category']				=	get_unformatted_string($row->s_category_name);
				  if($ret_[$i_cnt]['s_category']=='')
				  {
				  $ret_[$i_cnt]['s_category']				=	get_unformatted_string($row->{$this->site_default_lang_prefix.'_s_category_name'});
				  }
                  $ret_[$i_cnt]["s_title"]					=	stripslashes(htmlspecialchars_decode($row->s_title)); 
				  $ret_[$i_cnt]["s_description"]			=	stripslashes(htmlspecialchars_decode($row->s_description)); 
				  $ret_[$i_cnt]["d_budget_price"]			=	stripslashes(htmlspecialchars_decode($row->d_budget_price));
				  $ret_[$i_cnt]["s_budget_price"]			=	$ret_[$i_cnt]["d_budget_price"].' '.$this->conf["default_currency"];
				  $ret_[$i_cnt]["s_province"]				=	stripslashes(htmlspecialchars_decode($row->province)); 
				  $ret_[$i_cnt]["s_city"]					=	stripslashes(htmlspecialchars_decode($row->city)); 
				  $ret_[$i_cnt]["s_postal_code"]			=	stripslashes(htmlspecialchars_decode($row->postal_code));
				  $ret_[$i_cnt]["dt_expire_date"]			=	date($this->conf["site_date_format"],intval($row->i_expire_date));
				 
				  
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
	
	 public function gettotal_job_quotes($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."FROM ".$this->tbl_job_quotes." n "
					." LEFT JOIN ".$this->tbl." job ON n.i_job_id = job.id"
				." LEFT JOIN ".$this->tbl_user." tradesman ON n.i_tradesman_user_id = tradesman.id"
				." LEFT JOIN ".$this->tbl_city." c ON tradesman.i_city = c.id"
				." LEFT JOIN ".$this->tbl_zipcode." z ON job.i_zipcode_id = z.id"
				." LEFT JOIN ".$this->tbl_province." s ON job.i_province_id = s.id"
				." lEFT JOIN ".$this->tbl_cat." cat ON cat.i_id = job.i_category_id"
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
	
    public function gettotal_quote_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."FROM ".$this->tbl_job_quotes." n "
					." LEFT JOIN {$this->tbl_user} tradesman ON n.i_tradesman_user_id = tradesman.id"
					." LEFT JOIN {$this->tbl_city} c ON tradesman.i_city = c.id"
					." LEFT JOIN ".$this->tbl." j ON j.id = n.i_job_id "
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
	
	
	public function gettotal_quote_dashboard_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."FROM ".$this->tbl_job_quotes." n "				
				//." LEFT JOIN {$this->tbl_user} tradesman ON n.i_tradesman_user_id = tradesman.id"
				//." LEFT JOIN {$this->tbl_city} c ON tradesman.i_city = c.id"
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
	
	
	 public function gettotal_dashboard_job_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl." n "
					." LEFT JOIN {$this->tbl_cat} cat ON n.i_category_id = cat.i_id"
					." LEFT JOIN {$this->tbl_zipcode} z ON n.i_zipcode_id = z.id"
					." LEFT JOIN {$this->tbl_province} s ON n.i_province_id = s.id"
					." LEFT JOIN {$this->tbl_city} c ON n.i_city_id = c.id"
					." LEFT JOIN {$this->tbl_user} tradesman ON tradesman.id = n.i_tradesman_id"
					." LEFT JOIN {$this->tbl_user} buyer ON buyer.id = n.i_buyer_user_id"   
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
	
	
	public function gettotal_dashboard_accept_job_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl." n "
					." LEFT JOIN {$this->tbl_cat} cat ON n.i_category_id = cat.i_id"
					." LEFT JOIN {$this->tbl_zipcode} z ON n.i_zipcode_id = z.id"
					." LEFT JOIN {$this->tbl_province} s ON n.i_province_id = s.id"
					." LEFT JOIN {$this->tbl_city} c ON n.i_city_id = c.id"
					." LEFT JOIN {$this->tbl_user} tradesman ON tradesman.id = n.i_tradesman_id"
					." LEFT JOIN {$this->tbl_user} buyer ON buyer.id = n.i_buyer_user_id"   
					." LEFT JOIN {$this->tbl_job_payment_history} jph ON jph.i_job_id = n.id"
					." LEFT JOIN {$this->tbl_waiver_payment} wp ON wp.i_job_id = n.id"
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
	
	
    public function gettotal_job_invitation_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."FROM ".$this->tbl_job_invitation." n "
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
	
	
	
	public function gettotal_job_invitation($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl." n "
					." LEFT JOIN {$this->tbl_cat} cat ON n.i_category_id = cat.i_id"
					." LEFT JOIN {$this->tbl_zipcode} z ON n.i_zipcode_id = z.id"
					." LEFT JOIN {$this->tbl_province} s ON n.i_province_id = s.id"
					." LEFT JOIN {$this->tbl_city} c ON n.i_city_id = c.id"
					." LEFT JOIN {$this->tbl_user} tradesman ON tradesman.id = n.i_tradesman_id"
					." LEFT JOIN {$this->tbl_user} buyer ON buyer.id = n.i_buyer_user_id"   
					." LEFT JOIN {$this->tbl_job_invitation} inv ON n.id = inv.i_job_id"
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
	
	
	
	
	/* assign job to tradesman*/
    public function assign_job_to_tradesman($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";
				$s_qry.=" i_tradesman_id=? ";
				$s_qry.=" ,i_status=? ";
				$s_qry.=" ,i_quote_id=? ";
                $s_qry.=", i_assigned_date=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(
												  intval($info["i_tradesman_id"]),
												  intval($info["i_status"]),
												  intval($info["i_quote_id"]),
												  intval($info["i_assigned_date"]),
												  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
				//echo $this->db->last_query();
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  intval($info["i_tradesman_id"]),
												  intval($info["i_status"]),
												  intval($info["i_quote_id"]),
												  intval($info["i_assigned_date"]),
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
	
	function set_data_update($tableName,$arr,$id=-1) 
	{
		
        if(!$tableName || $tableName=='' || count($arr)==0 )
            return false;
        $cond   = '';
        if(is_array($id))
            $cond   = $id;
        else
            $cond   = array('id'=>$id);
        if($this->db->update($tableName, $arr, $cond))
            return true;
        else
            return false;				
	}
	
	function set_data_insert($tableName,$arr)
    {
        if( !$tableName || $tableName=='' ||  count($arr)==0 )
			return false;
		if($this->db->insert($tableName, $arr))
            return $this->db->insert_id();
        else
            return false;
    }	
	
	
	public function update_tradesman_member_placed_quote($i_tradesman_id='')  //$this->tbl_trade_member
	{
		$sql = "UPDATE ".$this->tbl_trade_member." SET i_quotes_placed = i_quotes_placed+1 WHERE i_tradesman_id=".$i_tradesman_id." AND i_status = 1 ";
		$this->db->query($sql);
	}
	
	/*Function to fetch radar job based on user's Job Radar data*/
	public function radar_job($id,$i_lang_id=1)
	{
		try
		{
			$CI = & get_instance();
			$CI->load->model("radar_model");
			$i_total =0;
			$info = $CI->radar_model->fetch_this($id);
			if(count($info)>0)
			{
				$arr_search[] = " n.i_status=1 AND n.i_is_deleted!=1 AND n.i_category_id=".$info['i_category_id']." AND cat_c.i_lang_id =".$i_lang_id;
				$CI->load->model("zipcode_model");
				$zipcode = $CI->zipcode_model->fetch_multi(" WHERE n.postal_code='{$info['i_postal_code']}'");
				if(!empty($zipcode))
				 {
					$lat = $zipcode[0]['latitude'];
					$lng = $zipcode[0]['longitude'];
					$job_radius = intval($info['i_radius']);
					$mile= ($job_radius*1.6093);
					$arr_search[] =" (
										(
										  (
										  acos( sin( ( {$lat} * pi( ) /180 ) ) * sin( (
										  `latitude` * pi( ) /180 ) ) + cos( ( {$lat} * pi( ) /180 ) ) * cos( (
										  `latitude` * pi( ) /180 ) 
										  ) * cos( (
										  (
										  {$lng} - `longitude` 
										  ) * pi( ) /180 ) 
										  )
										  )
										  ) *180 / pi( ) 
										 ) *60 * 1.1515 * 1.609344
										)  <= $mile";	
				}
				else
					$arr_search[] =" z.postal_code='{$info['i_postal_code']}'";						
			
			
				$s_where .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
			
				$i_total = $this->gettotal_info($s_where);
			}
			
			return $i_total;
		}
		catch(Exception $e)
		{
			show_error($e->getMessage());
		}
	}
	
 	public function gettotal_payment_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->db->JOB_PAYMENT_HISTORY." n "
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
    * Fetch the job status 
    * 31 March 2012
    * @author Koushik
    * 
    * @param mixed $s_where
    * @return array $ret_
    */
   public function fetch_job_status($s_where=null)
   {
       try
       {
          $ret_= array();
          $s_qry="Select count(*) as i_total,i_status "
                ."From ".$this->tbl." n " 
                    .($s_where!=""?$s_where:"" )." GROUP BY n.i_status";
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]['i_total']      =   intval($row->i_total);
                  $ret_[$i_cnt]['i_status']     =   intval($row->i_status);
                  $i_cnt++;    
              } 
          }   
              $rs->free_result();
              return $ret_;
           
       }
       catch(Exception $err_obj)
       {
            show_error($err_obj->getMessage());
       } 
   }	
   
   /**
   * This function use for fetch job ststus for left menu
   * after buyer login....
   *  
   */
   public function gettotal_jobs_user($s_where='')
   {
       try
       {
           $i_ret_  =   array();
           $s_qry   =   " SELECT n.* FROM ".$this->tbl." n ".($s_where!=""?$s_where:"") ;
           $rs=$this->db->query($s_qry);
          //echo $s_qry; 
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]         =   $row->id;////always integer
                  $ret_[$i_cnt]["i_status"]   =   $row->i_status;////always integer
                 
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
    
	/****************************** functions called from admin *************************************/
	/*
	*	Method to change the status for a record
	*	param int $i_id     id of the record
	*	param int $i_status status id to update
	*/
	public function update_status($i_id,$i_status)
	{
		try
		{
			$i_ret_=0;////Returns false
    
            if(intval($i_id)>0)
            {
				global $CI;
			 	$details 			= $this->fetch_this($i_id);
				$s_wh_id 			= " WHERE n.i_user_id=".$details['i_buyer_user_id']." ";
				$CI->load->model('manage_buyers_model');
				$buyer_details 		= $CI->manage_buyers_model->fetch_this($details['i_buyer_user_id']);				
				$buyer_email_key 	= $CI->manage_buyers_model->fetch_email_keys($s_wh_id);
				$is_mail_need 		= in_array('admin_buyer_cancel_job',$buyer_email_key);
				
				//echo $i_id.'-'.$i_status;
				$s_qry = '';
				
				if(intval($i_status) == 1)	
				{			
					$s_qry.="UPDATE ".$this->tbl."  SET i_status=?";
					$s_qry.=" ,i_expire_date = UNIX_TIMESTAMP(ADDDATE(SYSDATE(),INTERVAl (i_quoting_period_days*7) DAY))";
					$s_qry.=" ,i_admin_approval_date  = UNIX_TIMESTAMP(SYSDATE())";
					$s_qry.=" Where id=? ";
					
					$i_ret_ = $this->db->query($s_qry, array(intval($i_status),intval($i_id)) );
					//$i_ret_ =  $this->db->affected_rows();        
					if($i_ret_)
					{
						$logi["msg"]="Updating ".$this->tbl." ";
						$logi["sql"]= serialize(array($s_qry, array(intval($i_id),intval($i_status)) ) ) ;
						$this->log_info($logi); 
						unset($logi,$logindata);
					} 
					
					$CI->load->model('auto_mail_model');
					$content  = $CI->auto_mail_model->fetch_mail_content('job_approved','buyer',$buyer_details['s_lang_prefix']);					
					$filename = $this->config->item('EMAILBODYHTML')."common.html";
				   	$handle   = @fopen($filename, "r");
				   	$mail_html= @fread($handle, filesize($filename));
					$s_subject= $content['s_subject'];
					if(!empty($content))
					{		
						$description = $content["s_content"];
						$description = str_replace("[Buyer name]",$details['s_buyer_name'],$description);
						$description = str_replace("[job title]",$details['s_title'],$description);	
						$description = str_replace("[site_url]",base_url(),$description);
						$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);	
					}
					//unset($content);
					
					$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					/// Mailing code...[start]
					
					$site_admin_email = $this->s_admin_email;	
					$this->load->helper('mail');
					if($is_mail_need)
					{										
						$rect = sendMail($buyer_details['s_email'],$s_subject,$mail_html);	
						
					}
                    /// Mailing code...[end]
					
				} // end job approved mail
				
				if(intval($i_status) == 2)	
				{			
					$s_qry.="UPDATE ".$this->tbl."  SET i_status=?";
					$s_qry.=" ,i_expire_date = UNIX_TIMESTAMP(ADDDATE(SYSDATE(),INTERVAl (i_quoting_period_days*7) DAY))";
					$s_qry.=" ,i_admin_approval_date  = UNIX_TIMESTAMP(SYSDATE())";
					$s_qry.=" Where id=? ";
					
					$i_ret_ = $this->db->query($s_qry, array(intval($i_status),intval($i_id)) );
					//$i_ret_ =  $this->db->affected_rows();        
					if($i_ret_)
					{
						$logi["msg"]="Updating ".$this->tbl." ";
						$logi["sql"]= serialize(array($s_qry, array(intval($i_id),intval($i_status)) ) ) ;
						$this->log_info($logi); 
						unset($logi,$logindata);
					} 
					
					$CI->load->model('auto_mail_model');
					$content  = $CI->auto_mail_model->fetch_mail_content('job_rejected','buyer',$buyer_details['s_lang_prefix']);					
					$filename = $this->config->item('EMAILBODYHTML')."common.html";
				   	$handle   = @fopen($filename, "r");
				   	$mail_html= @fread($handle, filesize($filename));
					$s_subject= $content['s_subject'];
					if(!empty($content))
					{		
						$description = $content["s_content"];
						$description = str_replace("[Buyer name]",$details['s_buyer_name'],$description);
						$description = str_replace("[job title]",$details['s_title'],$description);	
						$description = str_replace("[site_url]",base_url(),$description);
						$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);	
					}
					//unset($content);
					
					$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					/// Mailing code...[start]
					//echo $mail_html; exit;
					
					$site_admin_email = $this->s_admin_email;	
					$this->load->helper('mail');
					
					if($is_mail_need)
					{							
						$rect = sendMail($buyer_details['s_email'],$s_subject,$mail_html);	
					}
                    /// Mailing code...[end]
					
				} // end job rejected mail
                
				//echo $s_qry;
                                                          
            }
            unset($s_qry, $i_id);
            return $i_ret_;
		}
		catch(Exception $e)
		{
			show_error($e->getMessage());
		}
	}
	
	
	
    /* Fetches One record from db for the id value.
    * @param int $i_id
    * @returns array
    */
    public function fetch_job_info($i_id)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select c.{$this->s_lang_prefix}_s_category_name AS s_category_name,n.*,qu.s_name,z.postal_code, s.province, ct.city, z.latitude , z.longitude,tr.s_name AS tradesman_name "
                ."From ".$this->tbl." AS n "
				."LEFT JOIN ".$this->db->MST_USER." AS qu ON n.i_buyer_user_id = qu.id "
				."LEFT JOIN ".$this->tbl_cat." AS c ON n.i_category_id = c.i_id "
				." LEFT JOIN ".$this->tbl_zipcode." z ON n.i_zipcode_id = z.id"
				." LEFT JOIN ".$this->tbl_province." s ON n.i_province_id = s.id"
				." LEFT JOIN ".$this->tbl_city." ct ON n.i_city_id = ct.id"
				." LEFT JOIN ".$this->db->MST_USER." AS tr ON n.i_tradesman_id = tr.id "
                ." Where n.id=?";
             
			    
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
		 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]=$row->id;////always integer
                  $ret_["s_title"]					=	get_unformatted_string($row->s_title); 
				  $ret_["s_description"]			=	get_unformatted_string($row->s_description); 
				  $ret_["i_buyer_id"]				=	stripslashes($row->i_buyer_user_id); 
				  $ret_["s_buyer_name"]				=	get_unformatted_string($row->s_name);
				 
				  $ret_["opt_city"] 				= 	stripslashes($row->i_city); 
				  $ret_["opt_province"] 			= 	stripslashes($row->i_province); 
				  $ret_["opt_zip"] 					= 	stripslashes($row->i_zipcode);
				  $ret_["s_province"]				=	get_unformatted_string($row->province); 
				  $ret_["s_city"]					=	get_unformatted_string($row->city); 
				  $ret_["s_postal_code"]			=	get_unformatted_string($row->postal_code); 
				  
				  $ret_["s_category_name"]			=	get_unformatted_string($row->s_category_name); 
				  if(empty($ret_["s_category_name"]))
				  {
				  $ret_["s_category_name"]			=	get_unformatted_string($row->{$this->site_default_lang_prefix.'_s_category_name'}); 
				  }
				  
                  $ret_["s_contact_no"]				=	get_unformatted_string($row->s_contact_no);
				  $ret_["d_budget_price"]			=	stripslashes($row->d_budget_price).' '.$this->conf["default_currency"]; 
				  $ret_["i_quoting_period_days"]	=	stripslashes($row->i_quoting_period_days); 
				  $ret_["s_keyword"]				=	get_unformatted_string($row->s_keyword);				  
                  $ret_["dt_created_on"]			=	date($this->conf["site_date_format"],intval($row->i_created_date)); 
				  
				  $ret_["dt_expired_on"]			=	!empty($row->i_expire_date)?date($this->conf["site_date_format"],intval($row->i_expire_date)):'Yet to approve'; 
				  $ret_["dt_admin_approval_date"]	=   !empty($row->i_admin_approval_date)?date($this->conf["site_date_format"],intval($row->i_admin_approval_date)):'Not approved';
				  $ret_["i_supply_material"]		=	intval($row->i_supply_material); 
				  $ret_["s_supply_material"]		=	$this->db->JOB_MATERIAL[$row->i_supply_material];   
				  
				  $ret_["dt_assigned_date"]			=	!empty($row->i_assigned_date)?date($this->conf["site_date_format"],intval($row->i_assigned_date)):'NA'; 
				  $ret_["tradesman_name"]			=	!empty($row->i_tradesman_id)?get_unformatted_string($row->tradesman_name):'NA';
				  $ret_["i_is_active"]				=	intval($row->i_status); 
				  $ret_["s_is_active"]				=	$this->db->JOBSTATUS[$row->i_status];
				  
				  //$CI = get_instance();
				 // $CI->load->model('job_model');
				  $ret_["job_files"]				=	$this->fetch_multi_job_image(" WHERE n.i_job_id=".$row->id); 
		  
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
    * Update records in db. As we know the table name 
    * we will not pass it into params.
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
				$s_qry.=" s_title=? ";
				$s_qry.=", s_description=? ";
				$s_qry.=", s_keyword=? ";
                $s_qry.=" Where id=? ";
                
                $i_ret_ = $this->db->query($s_qry,array(
												  get_unformatted_string($info["s_title"]),
												  get_unformatted_string($info["s_description"]),
												  get_unformatted_string($info["s_keyword"]),
												  intval($i_id)

                                                     ));
                //$i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  get_unformatted_string($info["s_title"]),
												  get_unformatted_string($info["s_description"]),
												  get_unformatted_string($info["s_keyword"]),
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
    * This method will fetch all records from the db with the sort criteria. 
    * 
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @param int $i_start, starting value for pagination
    * @param int $i_limit, number of records to fetch used for pagination
    * @returns array
    */
    public function fetch_multi_sorted_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {	
          	$ret_=array();
			$CI = & get_instance();
			$CI->load->model("job_model");
			 $s_qry="SELECT n.*,qu.s_username AS s_name,qt.s_username AS s_tradesman_name,
			 		cat.{$this->s_lang_prefix}_s_category_name AS s_category_name, z.postal_code, s.province, c.city, z.latitude , z.longitude FROM ".$this->tbl." n "
					."LEFT JOIN ".$this->tbl_user." AS qu ON n.i_buyer_user_id = qu.id "
					."LEFT JOIN ".$this->tbl_user." AS qt ON n.i_tradesman_id = qt.id"
					." LEFT JOIN ".$this->tbl_cat." AS cat ON n.i_category_id = cat.i_id "
					." LEFT JOIN ".$this->tbl_zipcode." z ON n.i_zipcode_id = z.id"
					." LEFT JOIN ".$this->tbl_province." s ON n.i_province_id = s.id"
					." LEFT JOIN ".$this->tbl_city." c ON n.i_city_id = c.id"
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}" .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          
		  $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]                   =   $row->id;////always integer
                  $ret_[$i_cnt]["s_title"]				=	get_unformatted_string($row->s_title); 
				  $ret_[$i_cnt]["s_part_title"]			=	get_unformatted_string($row->s_title);
				  $s_desc = stripslashes(htmlspecialchars_decode($row->s_description));
				  $ret_[$i_cnt]["s_part_description"]	=	string_part($s_desc,150);
				  $ret_[$i_cnt]["s_category_name"]		=	get_unformatted_string($row->s_category_name); 
				  if(empty($ret_[$i_cnt]["s_category_name"]))
				  {
				  $ret_[$i_cnt]["s_category_name"]		=	get_unformatted_string($row->{$this->site_default_lang_prefix.'_s_category_name'}); 
				  }
				  if(strlen($s_desc)>97)
				  	$s_desc = substr_replace($s_desc,'...',100);
				  $ret_[$i_cnt]["s_description"]		=	$s_desc; 
				  $ret_[$i_cnt]["i_buyer_id"]			=	stripslashes($row->i_buyer_user_id); 
				  $ret_[$i_cnt]["i_tradesman_id"]		=	stripslashes($row->i_tradesman_id); 
				  $ret_[$i_cnt]["s_buyer_name"]			=	stripslashes($row->s_name);
				  
				  $ret_[$i_cnt]["s_tradesman_name"]		=	get_unformatted_string($row->s_tradesman_name);
				   $ret_[$i_cnt]["s_keyword"]			=	get_unformatted_string($row->s_keyword); 
				  $ret_[$i_cnt]["s_contact_no"]			=	get_unformatted_string($row->s_contact_no); 
				  $ret_[$i_cnt]["d_budget_price"]   	= 	doubleval($row->d_budget_price).' '.$this->conf["default_currency"];;
				  $ret_[$i_cnt]["i_quoting_period_days"]=	intval($row->i_quoting_period_days);
				  $ret_[$i_cnt]["s_province"]			=	get_unformatted_string($row->province); 
				  $ret_[$i_cnt]["s_city"]				=	get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["s_postal_code"]		=	get_unformatted_string($row->postal_code); 
				  $ret_[$i_cnt]["i_quotes"]				=	$CI->job_model->gettotal_job_quote_info(" WHERE n.i_job_id={$row->id}");	
				  
                  $ret_[$i_cnt]["dt_created_on"]		=	date($this->conf["site_date_format"],intval($row->i_created_date));
				  $ret_[$i_cnt]["dt_expired_on"]		=	($row->i_expire_date)?date($this->conf["site_date_format"],intval($row->i_expire_date)):'';  
				  $ret_[$i_cnt]["i_is_active"]			=	intval($row->i_status); 
				  $ret_[$i_cnt]["s_is_active"]			=	$this->db->JOBSTATUS[$row->i_status];
				  $ret_[$i_cnt]["i_admin_approval_date"]= 	date($this->conf["site_date_format"],intval($row->i_admin_approval_date));
				  
				  $ret_[$i_cnt]["dt_completed_date"]	= 	date($this->conf["site_date_format"],intval($row->i_completed_date));
				  $ret_[$i_cnt]["dt_fn_assigned_date"]	= 	($row->i_assigned_date) ? date($this->conf["site_date_format"],intval($row->i_assigned_date)):'';
                  
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
	
	
	function update_buyer_posted_job($buyer_id='')
	{
		$sql = "UPDATE {$this->db->BUYERDETAILS} SET i_total_job_posted = i_total_job_posted+1 WHERE i_user_id={$buyer_id}";
		$this->db->query($sql);
	}
	
	
	function update_job_cloud_search($key='')
	{
		$sql = "UPDATE {$this->db->JOBSCLOUDSEARCH} SET i_weight = i_weight+1 WHERE s_keyword='".$key."' ";
		$this->db->query($sql);
	}
	// Tag cloude
	function tag_cloud()
	{
		$sql	=	"SELECT * FROM {$this->db->JOBSCLOUDSEARCH} ORDER BY i_weight DESC LIMIT 0,20 ";
		$query 	=   $this->db->query($sql);
        return $query->result_array();
	}
	// End
	
	
	/********************** FUNCTIONS FOR REPORT SECTIONS ******************************/
	public function fetch_report_multi($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {
          	$ret_=array();
			$s_qry = "SELECT n.id, n.s_title, n.s_description, n.i_created_date, n.d_budget_price, n.i_status,
						n.i_quoting_period_days, n.i_expire_date, n.i_assigned_date,n.i_terminate_date,
						cat.{$this->s_lang_prefix}_s_category_name AS s_category_name, u.s_username, trades_user.s_username s_tradesman_name, s.province, p.postal_code, c.city
					 FROM ".$this->tbl." n ".
				     " LEFT JOIN {$this->tbl_user} u ON u.id = n.i_buyer_user_id".
					 " LEFT JOIN {$this->tbl_user} trades_user ON trades_user.id = n.i_tradesman_id".
					 " LEFT JOIN {$this->tbl_cat} cat ON cat.i_id = n.i_category_id".
					 " LEFT JOIN {$this->tbl_province} s ON s.id = n.i_province_id".
					 " LEFT JOIN {$this->tbl_city} c ON c.id = n.i_city_id".
					 " LEFT JOIN {$this->tbl_zipcode} p ON p.id = n.i_zipcode_id"
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}" .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
		 //echo $s_qry; 
          if($rs->num_rows()>0)
          {
		  		$CI = & get_instance();
				$CI->load->model("job_model");
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_title"]					= get_unformatted_string($row->s_title); 
				  $ret_[$i_cnt]["s_description"]			= get_unformatted_string($row->s_description); 
                  $ret_[$i_cnt]["dt_entry_date"]			= date($this->conf["site_date_format"],intval($row->i_created_date));
				  $ret_[$i_cnt]["dt_expire_date"]			= date($this->conf["site_date_format"],intval($row->i_expire_date));
				  $ret_[$i_cnt]["dt_assigned_date"]			= date($this->conf["site_date_format"],intval($row->i_assigned_date));
				  $ret_[$i_cnt]["dt_terminate_date"]		= date($this->conf["site_date_format"],intval($row->i_terminate_date));
				  $ret_[$i_cnt]["s_username"]				= get_unformatted_string($row->s_username); 
				  $ret_[$i_cnt]["s_tradesman_name"]			= get_unformatted_string($row->s_tradesman_name); 
				  
				  $ret_[$i_cnt]["s_category_name"]			= get_unformatted_string($row->s_category_name); 
				  if(empty($ret_[$i_cnt]["s_category_name"]))
				  {
				  $ret_[$i_cnt]["s_category_name"]			=	get_unformatted_string($row->{$this->site_default_lang_prefix.'_s_category_name'}); 
				  }
				  
				  $ret_[$i_cnt]["s_province"]				= get_unformatted_string($row->province); 
				  $ret_[$i_cnt]["s_city"]					= get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["s_postal_code"]			= get_unformatted_string($row->postal_code);
				  $ret_[$i_cnt]["d_budget_price"]			= doubleval($row->d_budget_price);
				  $ret_[$i_cnt]["d_quote"]					= doubleval($row->d_quote);
				  $ret_[$i_cnt]["i_quoting_period_days"]	= intval($row->i_quoting_period_days);
                  $ret_[$i_cnt]["i_is_active"]				= intval($row->i_status); 
				  $ret_[$i_cnt]["s_is_active"]				= $this->db->JOBSTATUS[$row->i_status];
				  
				  $ret_[$i_cnt]["i_quotes"] =$CI->job_model->gettotal_job_quote_info(" WHERE n.i_job_id={$row->id}");
				  $ret_[$i_cnt]["ar_quote"] = $CI->job_model->fetch_quote_multi(" WHERE n.i_job_id={$row->id} AND n.i_status=2");
                  
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
	
	
    public function gettotal_report_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl." n "
				." LEFT JOIN {$this->db->CATEGORY} cat ON cat.i_id = n.i_category_id"
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
	
	public function fetch_quote_report_multi($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
		
        try
        {
          	$ret_=array();
		    $s_qry = "SELECT DISTINCT n.id, n.*,u.s_name, cat.{$this->s_lang_prefix}_s_category_name
					 FROM {$this->tbl} n "
					 ." LEFT JOIN {$this->tbl_cat} cat ON cat.i_id = n.i_category_id"
					 ." INNER JOIN {$this->tbl_job_quotes} jq ON jq.i_job_id = n.id"
					." LEFT JOIN {$this->tbl_user} u ON n.i_buyer_user_id = u.id"
					
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}" .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
		 // echo $s_qry;
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
		  	$CI = & get_instance();
			$CI->load->model("job_model");
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
				  $ret_[$i_cnt]["i_job_id"]			= $row->i_job_id;
				  $ret_[$i_cnt]["s_title"]			= get_unformatted_string($row->s_title); 
				  
				  $ret_[$i_cnt]["s_category_name"]	= get_unformatted_string($row->s_category_name); 
				  if(empty($ret_[$i_cnt]["s_category_name"]))
				  {
				  $ret_[$i_cnt]["s_category_name"]	= get_unformatted_string($row->{$this->site_default_lang_prefix.'_s_category_name'}); 
				  }
				  
				  $ret_[$i_cnt]["i_tradesman_id"]	= intval($row->i_tradesman_id);////always integer
                  $ret_[$i_cnt]["s_username"]		= get_unformatted_string($row->s_name); 
				  $ret_[$i_cnt]["s_email"]			= get_unformatted_string($row->s_email); 
				  $ret_[$i_cnt]["s_status"]			= $this->db->QUOTESTATE[$row->i_status]; 
				  $ret_[$i_cnt]["s_city"]			= get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["d_budget_price"]	= doubleval($row->d_budget_price);
				  $ret_[$i_cnt]["d_quote"]			= doubleval($row->d_quote); 
				  $ret_[$i_cnt]["s_quote"]			= doubleval($row->d_quote).' '.$this->conf["default_currency"];
				  $ret_[$i_cnt]["dt_entry_date"]	= date($this->conf["site_date_format"],intval($row->i_created_date));
				  $ret_[$i_cnt]["job_details"] 		= $this->fetch_this($row->i_job_id);
				  $ret_[$i_cnt]["i_quotes"]			= $CI->job_model->gettotal_job_quote_info(" WHERE n.i_job_id={$row->id}");
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
	
	 public function gettotal_report_quote_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(DISTINCT n.id) as i_total "
                ."  FROM {$this->tbl} n "
					 ." LEFT JOIN {$this->tbl_cat} cat ON cat.i_id = n.i_category_id"
					 ." INNER JOIN {$this->tbl_job_quotes} jq ON jq.i_job_id = n.id"
					." LEFT JOIN {$this->tbl_user} u ON n.i_buyer_user_id = u.id"
                .($s_where!=""?$s_where:"" );
			//	echo $s_qry;
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
	
	
	public function fetch_in_progress_report($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {
          	$ret_=array();
			 $s_qry="SELECT DISTINCT n.id,n.*,u.s_name AS s_buyer_name, 
			 		p.d_pay_amount,q.d_quote,cat.{$this->s_lang_prefix}_s_category_name AS s_category_name, w.d_waiver_amt,
					u.id AS i_buyer_id,n.i_tradesman_id AS i_tradesman_id,
					ut.s_name AS s_tradesman_name  FROM {$this->tbl} n "
				." LEFT JOIN {$this->tbl_job_payment_history} p ON p.i_job_id = n.id  "
				." LEFT JOIN {$this->tbl_waiver_payment} w ON w.i_job_id = n.id  "
				." INNER JOIN {$this->tbl_job_quotes} q ON q.id = n.i_quote_id  "
				." LEFT JOIN {$this->tbl_cat} cat ON cat.i_id = n.i_category_id"
				." LEFT JOIN {$this->tbl_user} u ON u.id = n.i_buyer_user_id  "
				." LEFT JOIN {$this->tbl_user} ut ON ut.id = n.i_tradesman_id  "
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by} " .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_job_title"] 			= get_unformatted_string($row->s_title); 
				  $ret_[$i_cnt]["s_buyer_name"] 		= get_unformatted_string($row->s_buyer_name); 
				  $ret_[$i_cnt]["i_buyer_id"] 			= intval($row->i_buyer_id); 
				  $ret_[$i_cnt]["i_job_id"] 			= intval($row->i_job_id); 
				  $ret_[$i_cnt]["i_tradesman_id"] 		= intval($row->i_tradesman_id); 
				  $ret_[$i_cnt]["s_tradesman_name"] 	= get_unformatted_string($row->s_tradesman_name);
				  
				  $ret_[$i_cnt]["s_category_name"] 		= get_unformatted_string($row->s_category_name);
				  if(empty($ret_[$i_cnt]["s_category_name"]))
				  {
				  $ret_[$i_cnt]["s_category_name"]		= get_unformatted_string($row->{$this->site_default_lang_prefix.'_s_category_name'}); 
				  }
				  
				  $ret_[$i_cnt]["d_quote_amount"] 		= doubleval($row->d_quote);
				  $ret_[$i_cnt]["d_pay_amount"] 		= doubleval($row->d_pay_amount);
				  $ret_[$i_cnt]["d_waiver_amt"] 		= doubleval($row->d_waiver_amt);
				  
				  $ret_[$i_cnt]["dt_entry_date"]=date($this->conf["site_date_format"],intval($row->i_created_date));
				  $ret_[$i_cnt]["dt_expire_date"]=date($this->conf["site_date_format"],intval($row->i_expire_date));
				  $ret_[$i_cnt]["dt_assigned_date"]=date($this->conf["site_date_format"],intval($row->i_assigned_date));
				  $ret_[$i_cnt]["dt_terminate_date"]=date($this->conf["site_date_format"],intval($row->i_terminate_date));
				  $ret_[$i_cnt]["dt_completed_date"]=date($this->conf["site_date_format"],intval($row->i_completed_date));

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
	
	
    public function gettotal_in_progress_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ." FROM {$this->tbl} n "
				." LEFT JOIN {$this->tbl_job_payment_history} p ON p.id = n.id  "
				." LEFT JOIN {$this->tbl_waiver_payment} w ON w.id = n.id  "
				." INNER JOIN {$this->tbl_job_quotes} q ON q.id = n.i_quote_id  "
				." LEFT JOIN {$this->tbl_cat} cat ON cat.i_id = n.i_category_id"
				." LEFT JOIN {$this->tbl_user} u ON u.id = n.i_buyer_user_id  "
				." LEFT JOIN {$this->tbl_user} ut ON ut.id = n.i_tradesman_id  "
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
	
	/* membership report */
	 public function fetch_tradesman_membership_plan($s_where='',$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {

            $ret_   =   array();
            $s_qry  =   ' SELECT tm.*,m.i_type,m.d_additional_contact_price,u.s_username FROM '.$this->tbl_trade_member.' tm 
            LEFT JOIN '.$this->tbl_membership.' m ON tm.i_membership_plan_id = m.i_id'.
			' LEFT JOIN '.$this->tbl_user.' u ON tm.i_tradesman_id = u.id '.($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" ); ; 
            $rs =   $this->db->query($s_qry);   
            
            $membership_plan    =   $this->db->MEMBERPLAN   ;
            if($rs->num_rows()>0)
            { 
                $i_cnt  =   0;
                foreach($rs->result() as $row)
                {
                      $ret_[$i_cnt]['id']               =   intval($row->i_id) ;
                      $ret_[$i_cnt]['i_plan_type']      =   intval($row->i_type) ;
                      $ret_[$i_cnt]['s_plan_type']      =   $membership_plan[intval($row->i_type)];
                      $ret_[$i_cnt]['i_duration']       =   intval($row->i_duration) ;
                      $ret_[$i_cnt]['d_price']          =   $row->d_price ;
                      $ret_[$i_cnt]['d_additional_contact_price']=   $row->d_additional_contact_price ;
                      $ret_[$i_cnt]['s_invoice_pdf_name']=  trim($row->s_invoice_pdf_name) ;
					  $ret_[$i_cnt]['s_username']		=  trim($row->s_username) ;
                      $ret_[$i_cnt]['dt_created_on']    =   date($this->conf["site_date_format"],intval($row->dt_created_on)) ;
                      $ret_[$i_cnt]['dt_expired_date']  =   date($this->conf["site_date_format"],intval($row->dt_expired_date));
                      
                      $i_cnt++;
                  }
                  $rs->free_result();
                  unset($i_cnt);
            }
            unset($s_qry,$rs,$membership_plan);
            return $ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    public function gettotal_membership_plan($s_where='')
    {
        try
        {
              $ret_=0;
              $s_qry="Select count(*) as i_total "
                    ."From ".$this->tbl_trade_member." tm ".
					"LEFT JOIN ".$this->tbl_user." u ON tm.i_tradesman_id = u.id ".($s_where!=""?$s_where:"" );
            
              $rs=$this->db->query($s_qry);

              if($rs->num_rows()>0)
              {
                  foreach($rs->result() as $row)
                  {
                      $ret_=intval($row->i_total); 
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
    
	
    
    /**
    * fetch job list from job table.....
    * 
    * @param mixed $s_where
    */
    public function fetch_job_list($s_where='',$i_tradesman_id)
    {
        try
        {
            $ret_=array();
            $s_qry = "SELECT n.*
                     FROM ".$this->tbl." n ".($s_where!=""?$s_where:"" )." 
                     AND n.id NOT IN (SELECT i_job_id FROM ".$this->tbl_job_invitation." WHERE i_tradesman_id=".$i_tradesman_id." )";
            
                     
          $rs=$this->db->query($s_qry);
          //echo $s_qry; 
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]               =   $row->id;////always integer
                  $ret_[$i_cnt]["i_buyer_user_id"]  =   $row->i_buyer_user_id;
                  $ret_[$i_cnt]["s_title"]          =   stripslashes(htmlspecialchars_decode($row->s_title)); 
                  $ret_[$i_cnt]["i_tradesman_id"]   =   $row->i_tradesman_id;////always integer 
                  $ret_[$i_cnt]["i_status"]         =   $row->i_status;////always integer 
                  
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
    
    public function delete_invitation($info)
    {
        try
        {
            $i_ret_  =   0;
            $s_qry  =   $s_qry="DELETE FROM ".$this->tbl_job_invitation." WHERE i_job_id=".$info['i_job_id']." AND i_tradesman_id=".$info['i_tradesman_id'];
            $this->db->query($s_qry, array(intval($i_id)) );
            $i_ret_=$this->db->affected_rows(); 
            
            unset($s_qry,$info);
            return   $i_ret_ ;     
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	/********************** END FUNCTIONS FOR REPORT SECTIONS ******************************/
    public function __destruct()
    {}                 
  
  
}
///end of class
?>