<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 31 March 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
* Model For Tradesman
* 
* @package Content Management
* @subpackage Testimonial
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/find_tradesman.php
* @link views/fe/find_tradesman/
*/


class Tradesman_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
	private $tbl_city;
	private $tbl_zip;
	private $tbl_province;
	private $tbl_user_image;
	private $tbl_tradesman_detail;
	private $tbl_tradesman_cat;
	private $tbl_cat;
	private $tbl_lang;
	private $tbl_news_subscript;
	private $tbl_testimonial;
	private $tbl_job_invite;
	private $tbl_job_feed;
    private $tbl_membership;
    private $tbl_trades_membership;
    
    private $tbl_automail_right;
    private $tbl_trades_album;
    private $tbl_work_place;
    private $tbl_tradesman_pay_unit;
    private $tbl_tradesman_pay_time;
    private $tbl_tradesman_work_days;
    private $tbl_trades_contactlist;
    private $tbl_trades_history;
	private $tbl_bank_transfer;
    

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl 					= $this->db->MST_USER;  
		  $this->tbl_city 				= $this->db->CITY;   
		  $this->tbl_zip 				= $this->db->ZIPCODE;  
		  $this->tbl_province 			= $this->db->PROVINCE; 
		  $this->tbl_user_image 		= $this->db->USREIMAGE;   
		  $this->tbl_tradesman_detail 	= $this->db->TRADESMANDETAILS;
		  $this->tbl_tradesman_cat 		= $this->db->TRADESMANCAT; 
		  $this->tbl_cat 				= $this->db->CATEGORY; 
		  $this->tbl_lang 				= $this->db->LANGUAGE;
		  $this->tbl_news_subscript 	= $this->db->NEWSLETTERSUBCRIPTION;  
		  $this->tbl_testimonial 		= $this->db->TESTIMONIAL; 
		  
		  $this->tbl_jobs 				= $this->db->JOBS;
		  $this->tbl_job_invite 		= $this->db->JOB_INVITATION;
          $this->tbl_job_feed           = $this->db->JOBFEEDBACK;
          $this->tbl_membership         = $this->db->MEMBERSHIPPLAN;
		  $this->tbl_trades_membership  = $this->db->TRADESMAN_MEMBERSHIP;
          
          $this->tbl_trades_album       = $this->db->TRADESALBUM;
          $this->tbl_work_place         = $this->db->TRADESMAN_WORKING_PLACE;
          $this->tbl_tradesman_pay_unit = $this->db->TRADESMAN_PAYMENT_TYPE;
          $this->tbl_tradesman_pay_time = $this->db->TRADESMAN_PAYMENT_TIME;
          $this->tbl_tradesman_work_days= $this->db->TRADESMAN_WORKING_DAYS;
          $this->tbl_automail_right     = $this->db->AUTOMAILRIGHT;
          $this->tbl_trades_contactlist = $this->db->TRADESMAN_CONTACTLIST;
          $this->tbl_trades_history     = $this->db->TRADESMANHISTORY;
		  $this->tbl_bank_transfer 	    = $this->db->MEMBERSHIP_BANK_TRANSFER;
          
          
          $this->conf =& get_config();
		  $this->s_lang_prefix=   $this->session->userdata('lang_prefix');
		  
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
	//*********************** function used in admin ***********************************//
	public function fetch_multi_sorted_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {    
              $ret_=array();
            $s_qry="SELECT n.id, n.s_username, n.s_name, n.s_email, n.s_skype_id, n.s_msn_id, n.s_yahoo_id, n.s_contact_no,
                    n.s_address, n.i_created_date, n.i_is_active, s.province, c.city, z.postal_code                    
                     FROM ".$this->tbl." n ".
                     " LEFT JOIN {$this->tbl_province} s ON s.id = n.i_province".
                     " LEFT JOIN {$this->tbl_city} c ON c.id = n.i_city".
                     " LEFT JOIN {$this->tbl_zip} z ON z.id = n.i_zipcode"
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_username"]        =    get_unformatted_string($row->s_username); 
                  $ret_[$i_cnt]["s_name"]            =    get_unformatted_string($row->s_name); 
                  $ret_[$i_cnt]["s_email"]            =    get_unformatted_string($row->s_email); 
                  $ret_[$i_cnt]["s_skype_id"]        =    get_unformatted_string($row->s_skype_id); 
                  $ret_[$i_cnt]["s_msn_id"]            =    get_unformatted_string($row->s_msn_id); 
                  $ret_[$i_cnt]["s_yahoo_id"]        =    get_unformatted_string($row->s_yahoo_id); 
                  $ret_[$i_cnt]["s_contact_no"]        =    get_unformatted_string($row->s_contact_no); 
                  $ret_[$i_cnt]["s_address"]        =    get_unformatted_string($row->s_address);
                  $ret_[$i_cnt]["s_province"]            =    get_unformatted_string($row->province); 
                  $ret_[$i_cnt]["s_city"]            =    get_unformatted_string($row->city); 
                  $ret_[$i_cnt]["s_postal_code"]    =    get_unformatted_string($row->postal_code);
                  
                  $ret_[$i_cnt]["dt_created_on"]    =    date($this->conf["site_date_format"],intval($row->i_created_date)); 
                  $ret_[$i_cnt]["i_is_active"]        =    intval($row->i_is_active); 
                  $ret_[$i_cnt]["s_is_active"]        =    (intval($row->i_is_active)==1?"Active":"Inactive");
                  
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
	
	//*********************** end function used in admin ***********************************//
	

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
			$s_qry="SELECT DISTINCT  n.id, n.s_username, n.s_name, n.s_email, n.s_skype_id, n.s_msn_id,
					 n.s_yahoo_id, n.s_contact_no,n.s_address, n.i_created_date, n.i_is_active, s.state, c.city, 
					 z.postal_code,td.s_skills,td.s_about_me,td.s_qualification,td.s_website,td.s_business_name,
					 td.i_payment_type,td.i_like_travel,td.i_feedback_rating,td.f_positive_feedback_percentage,
					 td.i_jobs_won,td.i_feedback_received 					
					 FROM ".$this->tbl." n ".
					 " LEFT JOIN {$this->tbl_province} s ON s.id = n.i_province".
					 " LEFT JOIN {$this->tbl_city} c ON c.id = n.i_city".
					 " LEFT JOIN {$this->tbl_tradesman_detail} td ON td.i_user_id = n.id".
					 " LEFT JOIN {$this->tbl_user_image} u ON u.i_user_id = n.id".
					 " RIGHT JOIN {$this->tbl_tradesman_cat} tc ON tc.i_user_id = n.id".  
					 " LEFT JOIN {$this->tbl_zip} z ON z.id = n.i_zipcode"
					 
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
			//	echo $s_qry;
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_username"]		=	get_unformatted_string($row->s_username); 
				  $ret_[$i_cnt]["s_name"]			=	get_unformatted_string($row->s_name); 
				  $ret_[$i_cnt]["s_email"]			=	get_unformatted_string($row->s_email); 
				  $ret_[$i_cnt]["s_skype_id"]		=	get_unformatted_string($row->s_skype_id); 
				  $ret_[$i_cnt]["s_msn_id"]			=	get_unformatted_string($row->s_msn_id); 
				  $ret_[$i_cnt]["s_yahoo_id"]		=	get_unformatted_string($row->s_yahoo_id); 
				  $ret_[$i_cnt]["s_contact_no"]		=	get_unformatted_string($row->s_contact_no); 
				  $ret_[$i_cnt]["s_address"]		=	get_unformatted_string($row->s_address);
				  $ret_[$i_cnt]["s_province"]			=	get_unformatted_string($row->state); 
				  $ret_[$i_cnt]["s_city"]			=	get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["s_postal_code"]	=	get_unformatted_string($row->postal_code);
				  $ret_[$i_cnt]["s_user_image"]		=	get_unformatted_string($row->s_user_image);
                  $ret_[$i_cnt]["dt_created_on"]	=	date($this->conf["site_date_format"],intval($row->i_created_date)); 
				  $ret_[$i_cnt]["i_is_active"]		=	intval($row->i_is_active); 
				  $ret_[$i_cnt]["s_is_active"]		=	(intval($row->i_is_active)==1?"Active":"Inactive");
				  
				  $ret_[$i_cnt]["s_skills"]			=	get_unformatted_string($row->s_skills);
				  $ret_[$i_cnt]["s_about_me"]		=	get_unformatted_string($row->s_about_me);
				  $ret_[$i_cnt]["s_qualification"]	=	get_unformatted_string($row->s_qualification);
				  $ret_[$i_cnt]["s_website"]		=	get_unformatted_string($row->s_website);
				  $ret_[$i_cnt]["s_business_name"]	=	get_unformatted_string($row->s_business_name);
				  $ret_[$i_cnt]["i_payment_type"]	=	intval($row->i_payment_type);
				  $ret_[$i_cnt]["i_like_travel"]	=	intval($row->i_like_travel);
				  $ret_[$i_cnt]["i_feedback_rating"]	=	intval($row->i_feedback_rating);
				  $ret_[$i_cnt]["f_positive_feedback_percentage"]	=	empty($row->f_positive_feedback_percentage)?0:doubleval($row->f_positive_feedback_percentage);
				  $ret_[$i_cnt]["i_jobs_won"]	=	empty($row->i_jobs_won)?0:intval($row->i_jobs_won);
				  $ret_[$i_cnt]["i_feedback_received"]	=	empty($row->i_feedback_received)?0:intval($row->i_feedback_received);
                  
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
	
    /******
    * This method will fetch all records from the db. 
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @param int $i_start, starting value for pagination
    * @param int $i_limit, number of records to fetch used for pagination
    * @returns array
	* call @ home for featured tradesman list
    */
    public function fetch_featured($s_where=null,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {	
          	$ret_=array();
			$s_qry="SELECT DISTINCT  n.id,n.s_image, n.s_username, n.s_name, n.s_email, n.s_sm, n.s_sm2,
					 n.s_sm3,n.s_verified, n.s_contact_no,n.s_address,n.s_image,n.i_created_date,n.i_is_active,
					 s.province,c.city,z.postal_code,td.s_about_me,td.i_ssn_verified,td.i_address_verified,td.i_mobile_verified,
					 td.s_business_name,td.i_feedback_rating,td.f_positive_feedback_percentage,
					 td.i_jobs_won,td.i_feedback_received FROM ".$this->tbl." n ".
					 " LEFT JOIN ".$this->tbl_province." s ON s.id = n.i_province".
					 " LEFT JOIN ".$this->tbl_city." c ON c.id = n.i_city".
					 " LEFT JOIN ".$this->tbl_tradesman_detail." td ON td.i_user_id = n.id".
					 " LEFT JOIN ".$this->tbl_tradesman_cat." tc ON tc.i_user_id = n.id".  
					 " LEFT JOIN ".$this->tbl_zip." z ON z.id = n.i_zipcode".
					 " LEFT JOIN ".$this->tbl_tradesman_work_days." AS w_days ON w_days.i_user_id = n.id "
					 
					 
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_by} ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
			//echo $s_qry;
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_username"]		=	get_unformatted_string($row->s_username); 
				  $ret_[$i_cnt]["s_name"]			=	get_unformatted_string($row->s_name); 
				  $ret_[$i_cnt]["s_image"]			=	get_unformatted_string($row->s_image);
				  $ret_[$i_cnt]["s_email"]			=	get_unformatted_string($row->s_email); 
				  $ret_[$i_cnt]["s_sm"]				=	get_unformatted_string($row->s_sm); 
				  $ret_[$i_cnt]["s_sm2"]			=	get_unformatted_string($row->s_sm2); 
				  $ret_[$i_cnt]["s_sm3"]			=	get_unformatted_string($row->s_sm3); 
				  $ret_[$i_cnt]["s_contact_no"]		=	get_unformatted_string($row->s_contact_no); 
				  $ret_[$i_cnt]["s_address"]		=	get_unformatted_string($row->s_address);
				  $ret_[$i_cnt]["s_province"]		=	get_unformatted_string($row->province); 
				  $ret_[$i_cnt]["s_city"]			=	get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["s_postal_code"]	=	get_unformatted_string($row->postal_code);
				  $ret_[$i_cnt]["s_image"]			=	get_unformatted_string($row->s_image);
                  $ret_[$i_cnt]["dt_created_on"]	=	date($this->conf["site_date_format"],intval($row->i_created_date)); 
				  $ret_[$i_cnt]["i_is_active"]		=	intval($row->i_is_active); 
				  $ret_[$i_cnt]["s_is_active"]		=	(intval($row->i_is_active)==1?"Active":"Inactive");
				  $ret_[$i_cnt]["i_verified"]		=	intval($row->s_verified);
				  //$ret_[$i_cnt]["s_category"]		=	$this->get_tradesman_cat($row->id);
				  //$ret_[$i_cnt]["s_skills"]			=	get_unformatted_string($row->s_skills);
				  $ret_[$i_cnt]["s_about_me"]		=	get_unformatted_string($row->s_about_me);
				 //$ret_[$i_cnt]["s_qualification"]	=	get_unformatted_string($row->s_qualification);
				 
				  $ret_[$i_cnt]["s_business_name"]	=	get_unformatted_string($row->s_business_name);
				  $ret_[$i_cnt]["i_ssn_verified"]	=	intval($row->i_ssn_verified);
				  $ret_[$i_cnt]["i_address_verified"]	=	intval($row->i_address_verified);
				  $ret_[$i_cnt]["i_mobile_verified"]	=	intval($row->i_mobile_verified);
				  $ret_[$i_cnt]["i_feedback_rating"]	=	intval($row->i_feedback_rating);
				  $ret_[$i_cnt]["f_positive_feedback_percentage"]	=	empty($row->f_positive_feedback_percentage)?0:doubleval($row->f_positive_feedback_percentage);
				  $ret_[$i_cnt]["i_jobs_won"]	=	empty($row->i_jobs_won)?0:intval($row->i_jobs_won);
				  $ret_[$i_cnt]["i_feedback_received"]	=	empty($row->i_feedback_received)?0:intval($row->i_feedback_received);
                  
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
	
	
	 public function fetch_featured_latest($s_where=null,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {	
          	$ret_=array();
			$s_qry="SELECT DISTINCT f.i_receiver_user_id,avg(f.i_rating) AS avg_rating,n.id, n.s_username, n.s_name, n.s_email, n.s_sm, n.s_sm2,
					 n.s_contact_no,n.s_address,n.s_image, n.i_created_date, n.i_is_active, s.province, c.city, 
					 z.postal_code,td.s_about_me,td.i_feedback_rating,td.f_positive_feedback_percentage,
					 td.i_jobs_won,td.i_feedback_received,(SELECT COUNT(*) FROM {$this->tbl_job_feed} m WHERE m.i_receiver_user_id  = f.i_receiver_user_id ) AS i_total FROM ".$this->tbl_job_feed." f ".
					 "LEFT JOIN  ".$this->tbl." n ON n.id = f.i_receiver_user_id ".
					 " LEFT JOIN ".$this->tbl_province." s ON s.id = n.i_province".
					 " LEFT JOIN ".$this->tbl_city." c ON c.id = n.i_city".
					 " LEFT JOIN ".$this->tbl_tradesman_detail." td ON td.i_user_id = n.id".
					 //" RIGHT JOIN ".$this->tbl_tradesman_cat." tc ON tc.i_user_id = n.id".  
					 " LEFT JOIN ".$this->tbl_zip." z ON z.id = n.i_zipcode"					 
					 
                .($s_where!=""?$s_where:"" )."  ORDER BY {$order_by} "
				.(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
			//	echo $s_qry;
          $rs=$this->db->query($s_qry);
		  //echo $this->db->last_query().'<br/>';
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
				  $ret_[$i_cnt]["avg_rating"]		=	round($row->avg_rating);
                  $ret_[$i_cnt]["s_username"]		=	get_unformatted_string($row->s_username); 
				  $ret_[$i_cnt]["s_name"]			=	get_unformatted_string($row->s_name); 
				  $ret_[$i_cnt]["s_email"]			=	get_unformatted_string($row->s_email); 
				  $ret_[$i_cnt]["s_sm"]				=	get_unformatted_string($row->s_sm); 
				  $ret_[$i_cnt]["s_sm2"]			=	get_unformatted_string($row->s_sm2); 
				  //$ret_[$i_cnt]["s_yahoo_id"]		=	get_unformatted_string($row->s_yahoo_id); 
				  $ret_[$i_cnt]["s_contact_no"]		=	get_unformatted_string($row->s_contact_no); 
				  $ret_[$i_cnt]["s_address"]		=	get_unformatted_string($row->s_address);
				  $ret_[$i_cnt]["s_province"]		=	get_unformatted_string($row->province); 
				  $ret_[$i_cnt]["s_city"]			=	get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["s_postal_code"]	=	get_unformatted_string($row->postal_code);
				  $ret_[$i_cnt]["s_image"]			=	get_unformatted_string($row->s_image);
                  $ret_[$i_cnt]["dt_created_on"]	=	date($this->conf["site_date_format"],intval($row->i_created_date)); 
				  $ret_[$i_cnt]["i_is_active"]		=	intval($row->i_is_active); 
				  $ret_[$i_cnt]["s_is_active"]		=	(intval($row->i_is_active)==1?"Active":"Inactive");
				  
				  $ret_[$i_cnt]["s_about_me"]		=	get_unformatted_string($row->s_about_me);
				  //$ret_[$i_cnt]["s_qualification"]	=	get_unformatted_string($row->s_qualification);
				  //$ret_[$i_cnt]["s_website"]		=	get_unformatted_string($row->s_website);
				  $ret_[$i_cnt]["s_business_name"]	=	get_unformatted_string($row->s_business_name);
				  //$ret_[$i_cnt]["i_payment_type"]	=	intval($row->i_payment_type);
				 // $ret_[$i_cnt]["i_like_travel"]	=	intval($row->i_like_travel);
				  $ret_[$i_cnt]["i_feedback_rating"]	=	intval($row->i_feedback_rating);
				  $ret_[$i_cnt]["f_positive_feedback_percentage"]	=	empty($row->f_positive_feedback_percentage)?0:doubleval($row->f_positive_feedback_percentage);
				  $ret_[$i_cnt]["i_jobs_won"]	=	empty($row->i_jobs_won)?0:intval($row->i_jobs_won);
				  $ret_[$i_cnt]["i_feedback_received"]	=	empty($row->i_feedback_received)?0:intval($row->i_feedback_received);
                  
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
          $s_qry="Select count(DISTINCT n.id) as i_total "
                ."From ".$this->tbl." n ".
				" LEFT JOIN ".$this->tbl_province." s ON s.id = n.i_province".
					 " LEFT JOIN ".$this->tbl_city." c ON c.id = n.i_city".
					 " LEFT JOIN ".$this->tbl_tradesman_detail." td ON td.i_user_id = n.id".
					 //" LEFT JOIN {$this->tbl_user_image} u ON u.i_user_id = n.id".
					 " LEFT JOIN ".$this->tbl_tradesman_cat." tc ON tc.i_user_id = n.id".  
					 " LEFT JOIN ".$this->tbl_zip." z ON z.id = n.i_zipcode".
					 " LEFT JOIN ".$this->tbl_tradesman_work_days." AS w_days ON w_days.i_user_id = n.id "
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
    * @param int $i_id
    * @returns array
    */
    public function fetch_this($i_id)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
             $s_qry="Select lang.s_short_name AS s_lang_prefix,s.s_about_me,s.i_type,s_gsm_no,s.s_taxoffice_name,                     s.s_business_name,s.s_firm_name,s.s_firm_phone,s.s_tax_no,s.i_work_place,s.s_keyword,s.s_ssn,
                    s.s_address_file,s.i_ssn_verified,s.i_address_verified,s.i_tax_no_verified,s.f_positive_feedback_percentage,
					s.i_feedback_rating,s.i_mobile_verified, n.*,c.city  AS s_city_name,st.province, 
					z.postal_code From ".$this->tbl." AS n ".
             " LEFT JOIN {$this->tbl_tradesman_detail} s ON s.i_user_id = n.id".// change this line
           // " LEFT JOIN {$this->tbl_user_image} u ON u.i_user_id = n.id".   
            " LEFT JOIN {$this->tbl_province} st ON st.id = n.i_province".
            " LEFT JOIN {$this->tbl_city} c ON c.id = n.i_city".
            " LEFT JOIN {$this->tbl_zip} z ON z.id = n.i_zipcode".
            " LEFT JOIN ".$this->tbl_lang." AS lang ON lang.i_id = n.i_signup_lang".             
            " Where n.id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {                  
                  $ret_["id"]=$row->id;////always integer
                  $ret_["s_username"]            	=    get_unformatted_string($row->s_username); 
                  $ret_["s_name"]                	=    get_unformatted_string($row->s_name); 
                  $ret_["s_email"]                	=    get_unformatted_string($row->s_email); 
                  $ret_["s_image"]                	=    get_unformatted_string($row->s_image); 
                  $ret_["s_address"]            	=    get_unformatted_string($row->s_address);
                  $ret_["s_address2"]            	=    get_unformatted_string($row->s_address2);                 
                 // social media datas fetch 
                  $ret_["i_sm"]                    	=    intval($row->i_sm);
                  $ret_["s_type_sm"]            	=    intval($row->i_sm)?$this->db->SOCIALMEDIA[intval($row->i_sm)]:"";
                  $ret_["s_sm"]                    	=    get_unformatted_string($row->s_sm); 
                  $ret_["i_sm2"]                	=    intval($row->i_sm2);
                  $ret_["s_sm2"]                	=    get_unformatted_string($row->s_sm2);
                  $ret_["i_sm3"]                	=    intval($row->i_sm3);
                  $ret_["s_sm3"]                	=    get_unformatted_string($row->s_sm3);
                  
                  $ret_["s_contact_no"]            	=    get_unformatted_string($row->s_contact_no);
                  $ret_["s_lat"]                	=    get_unformatted_string($row->s_lat); 
                  $ret_["s_lng"]                	=    get_unformatted_string($row->s_lng); 
                  $ret_["opt_city"]             	=    stripslashes($row->i_city); 
                  $ret_["opt_province"]         	=    stripslashes($row->i_province); 
                  $ret_["opt_zip"]                 	=    stripslashes($row->i_zipcode); 
                  $ret_["chk_newsletter"]       	=    intval($row->i_inform_news);                   
                  $ret_["i_signup_lang"]        	=    intval($row->i_signup_lang); 
                  $ret_["s_lang_prefix"]        	=     get_unformatted_string($row->s_lang_prefix);
                  
                 /* $ret_["s_province"]           	=    get_unformatted_string($row->province); 
                  $ret_["s_city_name"]            	=    get_unformatted_string($row->s_city_name);*/
				   $ret_["s_province"]           	=    stripslashes(htmlspecialchars_decode($row->province)); 
                  $ret_["s_city_name"]            	=    stripslashes(htmlspecialchars_decode($row->s_city_name));
                  $ret_["s_postal_code"]        	=    get_unformatted_string($row->postal_code);
                  
                  $ret_["dt_created_on"]        	=    date($this->conf["site_date_format"],intval($row->i_created_date)); 
                  $ret_["s_last_login_on"]      	=  time_ago($row->i_last_login_date) ;
                  $ret_["s_created_on"]         	=     date('M Y',intval($row->i_created_date));
                  $ret_["i_verified"]            	=    intval($row->s_verified); 
                  $ret_["s_verified"]            	=    (intval($row->s_verified)==1?"Verified":"Not Verified");
                  $ret_["i_is_active"]            	=    intval($row->i_is_active); 
                  $ret_["s_is_active"]            	=    (intval($row->i_is_active)==1?"Active":"Inactive");                  
                  // FROM DETAILS TABLE
                  $ret_["s_ssn"]                  	=    get_unformatted_string($row->s_ssn);
                  $ret_["s_business_name"]      	=    get_unformatted_string($row->s_business_name);
                  $ret_["s_firm_name"]          	=    get_unformatted_string($row->s_firm_name);
                  $ret_["s_firm_phone"]          	=    get_unformatted_string($row->s_firm_phone);
                  $ret_["s_address_file"]          	=    get_unformatted_string($row->s_address_file);
                  $ret_["s_keyword"]               	=    get_unformatted_string($row->s_keyword);
                  //$ret_["s_about_me"]              	=    get_unformatted_string($row->s_about_me);
				  $ret_["s_about_me"]              	=    stripslashes(htmlspecialchars_decode($row->s_about_me));
                  $ret_["s_gsm_no"]                	=    get_unformatted_string($row->s_gsm_no);
                  $ret_["s_taxoffice_name"]        	=    get_unformatted_string($row->s_taxoffice_name);
                  $ret_["s_tax_no"]                	=    get_unformatted_string($row->s_tax_no);
                  $ret_["i_type"]                  	=    intval($row->i_type);
                  $ret_["i_ssn_verified"]          	=    intval($row->i_ssn_verified);
				  $ret_["i_address_verified"]      	=    intval($row->i_address_verified);
				  $ret_["i_mobile_verified"]       	=    intval($row->i_mobile_verified);
				  $ret_["i_tax_no_verified"]       	=    intval($row->i_tax_no_verified);
                  //$ret_["s_profile_pic"]           =    get_unformatted_string($row->s_profile_pic);
                  //$ret_["s_firm_logo"]           =    get_unformatted_string($row->s_firm_logo);                  
                  //$ret_["s_user_image"]           =    get_unformatted_string($row->s_user_image);
                  
                  $ret_["f_positive_feedback_percentage"]    =    empty($row->f_positive_feedback_percentage)?0:doubleval($row->f_positive_feedback_percentage);
                  $ret_["i_jobs_won"]            =    empty($row->i_jobs_won)?0:intval($row->i_jobs_won);
                  $ret_["i_feedback_received"]  =    empty($row->i_feedback_received)?0:intval($row->i_feedback_received);
				  $ret_["i_feedback_rating"]	=	intval($row->i_feedback_rating);                  
                  // fetch other details  fetch_tradesmen_working_days 
                  $s_wh = " WHERE n.i_user_id = ".$ret_["id"]." ";
                  $ret_["category"]            	=    $this->fetch_all_category($s_wh);
                  $ret_["workplace"]        	=    $this->fetch_all_work_place($s_wh);
                  $ret_["payment_unit"]        	=    $this->fetch_tradesmen_payment_unit($s_wh);
				  $ret_["payment_time"]        	=    $this->fetch_tradesmen_payment_time($s_wh);
				  $ret_["work_days"]        	=    $this->fetch_tradesmen_working_days($s_wh);
				  
				  $s_where = " WHERE tm.i_tradesman_id=".intval($i_id)." AND tm.i_status=1";
				  $ret_["membership"]        	=    $this->fetch_tradesman_membership_plan($s_where,0,1);
                  
                  
          
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

    /*******
    * Fetches One record from db for the id value.
    *
    *  
    * @param int $i_id
    * @returns array
    */
    public function fetch_tradesman_details($i_id)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select 
		  s.s_about_me,s.i_type,s_gsm_no,s.s_taxoffice_name,s.s_business_name,s.s_firm_name,s.s_firm_phone,
			s.s_tax_no,s.s_keyword,s.s_ssn,s.s_address_file,
			n.*,st.province,ct.city, z.postal_code,s.i_feedback_rating,
			lang.s_short_name AS lang_prefix,s.f_positive_feedback_percentage, s.i_jobs_won,
			s.i_feedback_received From ".$this->tbl." AS n ".
		  	" LEFT JOIN {$this->tbl_tradesman_detail} s ON s.i_user_id = n.id".
			" LEFT JOIN {$this->tbl_tradesman_cat} c ON c.i_user_id = n.id".  
			" LEFT JOIN {$this->tbl_province} st ON st.id = n.i_province".
			" LEFT JOIN {$this->tbl_city} ct ON ct.id = n.i_city".
			" LEFT JOIN {$this->tbl_zip} z ON z.id = n.i_zipcode".  
			" LEFT JOIN {$this->tbl_lang} lang ON lang.i_id = n.i_signup_lang".         
            " Where n.id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]=$row->id;////always integer
                  $ret_["s_username"]		=	get_unformatted_string($row->s_username); 
				  $ret_["s_name"]			=	get_unformatted_string($row->s_name); 
				  $ret_["s_email"]			=	get_unformatted_string($row->s_email); 
				  $ret_["s_address"]		=	get_unformatted_string($row->s_address);
				  /*$ret_["s_skype_id"]		=	get_unformatted_string($row->s_skype_id); 
				  $ret_["s_msn_id"]			=	get_unformatted_string($row->s_msn_id); 
				  $ret_["s_yahoo_id"]		=	get_unformatted_string($row->s_yahoo_id); */
				  // social media datas fetch 
                  $ret_["i_sm"]                    	=    intval($row->i_sm);
                  $ret_["s_type_sm"]            	=    intval($row->i_sm)?$this->db->SOCIALMEDIA[intval($row->i_sm)]:"";
                  $ret_["s_sm"]                    	=    get_unformatted_string($row->s_sm); 
                  $ret_["i_sm2"]                	=    intval($row->i_sm2);
                  $ret_["s_sm2"]                	=    get_unformatted_string($row->s_sm2);
                  $ret_["i_sm3"]                	=    intval($row->i_sm3);
                  $ret_["s_sm3"]                	=    get_unformatted_string($row->s_sm3);
				  
				  $ret_["s_contact_no"]		=	get_unformatted_string($row->s_contact_no);
				  $ret_["s_lat"]			=	get_unformatted_string($row->s_lat); 
				  $ret_["s_lng"]			=	get_unformatted_string($row->s_lng); 
				  $ret_["opt_city"] 		= 	stripslashes($row->i_city); 
				  $ret_["opt_province"] 	= 	stripslashes($row->i_province); 
				  $ret_["opt_zip"] 			= 	stripslashes($row->i_zipcode); 
				  $ret_["s_province"]		=	get_unformatted_string($row->province); 
				  $ret_["s_city"]			=	get_unformatted_string($row->city); 
				  $ret_["s_postal_code"]	=	get_unformatted_string($row->postal_code);
				  
				  $ret_["i_signup_lang"]	=	intval($row->i_signup_lang);
				  $ret_["lang_prefix"]		=	get_unformatted_string($row->lang_prefix);

				  
                  $ret_["dt_created_on"]    =    date($this->conf["site_date_format"],intval($row->i_created_date));
                 
                   
				  
				  $ret_["dt_last_login_on"]	=	$row->i_last_login_date?date($this->conf["last_log_date_format"],intval($row->i_last_login_date)):"not logged in yet"; 
                  
				  
				  $ret_["i_verified"]		=	intval($row->s_verified); 
				  $ret_["s_verified"]		=	(intval($row->s_verified)==1?"Verified":"Not Verified");
				  $ret_["i_is_active"]		=	intval($row->i_is_active); 
				  $ret_["s_is_active"]		=	(intval($row->i_is_active)==1?"Active":"Inactive");
				 
				  // FROM DETAILS TABLE
				  $ret_["s_ssn"]          		=    get_unformatted_string($row->s_ssn);
				  $ret_["s_business_name"]      =    get_unformatted_string($row->s_business_name);
				  $ret_["s_firm_name"]      	=    get_unformatted_string($row->s_firm_name);
				  $ret_["s_firm_phone"]      	=    get_unformatted_string($row->s_firm_phone);
				  $ret_["s_address_file"]       =    get_unformatted_string($row->s_address_file);
                  $ret_["s_keyword"]          	=    get_unformatted_string($row->s_keyword);
                  $ret_["s_about_me"]         	=    get_unformatted_string($row->s_about_me);
                  $ret_["s_gsm_no"]           	=    get_unformatted_string($row->s_gsm_no);
                  $ret_["s_taxoffice_name"]   	=    get_unformatted_string($row->s_taxoffice_name);
                  $ret_["s_tax_no"]           	=    get_unformatted_string($row->s_tax_no);
                  $ret_["i_type"]             	=    intval($row->i_type);
                  //$ret_["i_work_place"]      	=    intval($row->i_work_place);
				  //$ret_["s_profile_pic"]       	=    get_unformatted_string($row->s_profile_pic);
				  //$ret_["s_firm_logo"]       	=    get_unformatted_string($row->s_firm_logo);                  
                  $ret_["s_image"]       	=    get_unformatted_string($row->s_image);
				  
				  $ret_["s_user_image"]		=	get_unformatted_string($row->s_user_image);
				  $ret_["s_category_name"] 	= $this->get_tradesman_cat($row->id,$i_lang_id);
				  $ret_["i_category_id"]	=	stripslashes($row->i_category_id);
				  $ret_["f_positive_feedback_percentage"]	=	empty($row->f_positive_feedback_percentage)?0:doubleval($row->f_positive_feedback_percentage);
				  $ret_["i_jobs_won"]		=	empty($row->i_jobs_won)?0:intval($row->i_jobs_won);
				  $ret_["i_feedback_received"]	=	empty($row->i_feedback_received)?0:intval($row->i_feedback_received);
				  
				  // fetch other details 
                  $s_wh = " WHERE n.i_user_id = ".$ret_["id"]." ";
                  $ret_["category"]            =    $this->fetch_all_category($s_wh);
                  $ret_["workplace"]        =    $this->fetch_all_work_place($s_wh);
                  $ret_["payment_unit"]        =    $this->fetch_tradesmen_payment_unit($s_wh);
		  
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
	
	
	public function fetch_tradesman_using_activation_code($s_where)
	{
	
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="SELECT n.s_email,n.s_username,n.id,n.i_signup_lang,
		  		lang.s_short_name AS lang_prefix FROM ".$this->tbl." AS n ".
				" LEFT JOIN {$this->tbl_lang} lang ON lang.i_id = n.i_signup_lang ". 
				" ".$s_where." " ;   
            
                
          $rs=$this->db->query($s_qry); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]=$row->id;////always integer
                  $ret_["s_username"]		=	get_unformatted_string($row->s_username); 
				  $ret_["s_email"]			=	get_unformatted_string($row->s_email); 
				  $ret_["i_signup_lang"]	=	intval($row->i_signup_lang);
				  $ret_["lang_prefix"]		=	get_unformatted_string($row->lang_prefix);                 
		  
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
	
	/* tradesman history @ tradesman profile 
	* author mrinmoy , 30-05-2012
	* array defined in find_tradesman controller
	*/        
	/* get job history*/
	public function fetch_tradesman_history($s_where=null,$history_arr,$i_start=null,$i_limit=null)
    {
		
        try
        {
          	$ret_=array();
			$s_qry = "SELECT u.s_username,j.s_title,n.* FROM ".$this->tbl_trades_history." n "	
					." LEFT JOIN {$this->tbl} u ON u.id = n.i_user_id"
					." LEFT JOIN {$this->tbl_jobs} j ON j.id = n.i_job_id "
                .($s_where!=""?$s_where:"" )." ORDER BY n.i_created_date DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
		  //echo $s_qry;
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_title"]		= stripslashes(htmlspecialchars_decode($row->s_title)); 			  
                  $ret_[$i_cnt]["dt_create_date"]= date($this->conf["site_date_format"],intval($row->i_created_date));	
				  $ret_[$i_cnt]["i_create_date"]= intval($row->i_created_date);		 
				  $ret_[$i_cnt]["s_username"]	= get_unformatted_string($row->s_username); 
				  $ret_[$i_cnt]["s_action"]		= get_unformatted_string($row->s_action);				  
				  $ret_[$i_cnt]["content"]		= $history_arr[stripslashes(htmlspecialchars_decode($row->s_action))];
				  
				  if(!empty($ret_[$i_cnt]["content"]))
					{							
						$description = $ret_[$i_cnt]["content"];
						$description = str_replace("##TITLE##",$ret_[$i_cnt]["s_title"],$description);	
					}
				
				  $ret_[$i_cnt]["msg_str"] = $description;				  
				  
                  
                  
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
                if(isset($info["s_password"]) && !empty($info["s_password"]))
                {
                    $s_password = md5(trim($info["s_password"]).$this->conf["security_salt"]);
                    $s_qry.=", s_password= '".$s_password."' ";
                }
                $s_qry.=", s_name=? ";
                $s_qry.=", s_email=? ";
                $s_qry.=", i_sm=? ";
                $s_qry.=", s_sm=? ";
                $s_qry.=", s_image=? ";
                $s_qry.=", s_contact_no=? ";
                $s_qry.=", s_address=? ";
                $s_qry.=", s_address2=? ";
                $s_qry.=", s_verification_code=? ";
                $s_qry.=", i_province=? ";
                $s_qry.=", i_city=? ";
                $s_qry.=", i_zipcode=? ";
                $s_qry.=", s_lat=? ";
                $s_qry.=", s_lng=? ";
                $s_qry.=", i_role=? ";
                
                $s_qry.=", i_created_date=? ";
                $s_qry.=", i_inform_news=? ";
                $s_qry.=", i_signup_lang=? ";
                
                $this->db->query($s_qry,array(
                                                  get_formatted_string($info["s_username"]),
                                                  get_formatted_string($info["s_business_name"]),
                                                  get_formatted_string($info["s_email"]),
                                                   get_formatted_string($info["i_sm"]),
                                                  get_formatted_string($info["s_sm"]),
                                                  get_formatted_string($info["s_image"]),
                                                  trim(htmlspecialchars($info["s_firm_phone"])),
                                                  get_formatted_string($info["s_firm_address1"]),
                                                  get_formatted_string($info["s_firm_address2"]),
                                                  get_formatted_string($info["s_verification_code"]),
                                                  intval(decrypt($info["i_province"])),
                                                  intval(decrypt($info["i_city"])),
                                                  intval(decrypt($info["i_zipcode"])),
                                                  get_formatted_string($info["s_lat"]),
                                                  get_formatted_string($info["s_lng"]),
                                                  intval($info["i_role"]),
                                                 
                                                  intval($info["i_created_date"]),
                                                  intval($info["i_inform_news"]),
                                                  intval($info["i_signup_lang"])
                                                 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    //$this->insert_image($info,$i_ret_); 
                    
                    $this->insert_details($info,$i_ret_);
                                        
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
                                                  get_formatted_string($info["s_username"]),
                                                  get_formatted_string($info["s_business_name"]),
                                                  get_formatted_string($info["s_email"]),
                                                   get_formatted_string($info["i_sm"]),
                                                  get_formatted_string($info["s_sm"]),
                                                  get_formatted_string($info["s_image"]),
                                                  trim(htmlspecialchars($info["s_firm_phone"])),
                                                  get_formatted_string($info["s_firm_address1"]),
                                                  get_formatted_string($info["s_firm_address2"]),
                                                  get_formatted_string($info["s_verification_code"]),
                                                  intval(decrypt($info["i_province"])),
                                                  intval(decrypt($info["i_city"])),
                                                  intval(decrypt($info["i_zipcode"])),
                                                  get_formatted_string($info["s_lat"]),
                                                  get_formatted_string($info["s_lng"]),
                                                  intval($info["i_role"]),
                                                 
                                                  intval($info["i_created_date"]),
                                                  intval($info["i_inform_news"]),
                                                  intval($info["i_signup_lang"])
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
	
	
	/* tradesman details insert into database*/
	public function insert_details($info,$id)
	{
		try
		{
			//print_r($info); exit;
			$i_ret_=0;////Returns false
			if(!empty($info))
			{
				
					$s_qry="Insert Into ".$this->tbl_tradesman_detail." Set ";
                	$s_qry.=" i_user_id=? ";
					$s_qry.=", i_type=? ";
					$s_qry.=", s_firm_name=? ";
					$s_qry.=", s_business_name=? ";
					$s_qry.=", s_firm_phone=? ";
					$s_qry.=", s_gsm_no=? ";
					$s_qry.=", s_taxoffice_name=? ";
					$s_qry.=", s_tax_no=? ";
					$s_qry.=", s_ssn=? ";
					$s_qry.=", s_address_file=? ";
					
					$this->db->query($s_qry,array(
													intval($id),
													intval($info['i_type']),
													get_formatted_string($info['s_firm_name']),
													get_formatted_string($info['s_business_name']),
													get_formatted_string($info['s_firm_phone']),
													get_formatted_string($info['s_gsm_no']),
													get_formatted_string($info['s_taxoffice_name']),
													get_formatted_string($info['s_tax_no']),
													get_formatted_string($info['s_ssn']),
													get_formatted_string($info['s_address_file']),
													
												));
												
					$i_ret_=$this->db->insert_id(); 
					if($i_ret_)
					{
						 $logi["msg"]="Inserting into ".$this->tbl_tradesman_detail." ";
                    	$logi["sql"]= serialize(array($s_qry,array(
													intval($id),
													intval($info['i_trades_type']),
													get_formatted_string($info['s_firm_name']),
													get_formatted_string($info['s_business_name']),
													get_formatted_string($info['s_firm_phone']),
													get_formatted_string($info['s_gsm_no']),
													get_formatted_string($info['s_taxoffice_name']),
													get_formatted_string($info['s_tax_no']),
													get_formatted_string($info['s_ssn']),
													get_formatted_string($info['s_address_file']),
													
												)) ) ; 
						$this->log_info($logi); 
                    	unset($logi,$logindata);						
					}							
												
				
				else
				$i_ret_ = true;
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
            $i_ret_=0;////Returns falses_about
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";
				$s_qry.=" s_username=? ";
                $s_qry.=", s_name=? ";
				$s_qry.=", s_email=? ";				
				$s_qry.=", s_contact_no=? ";
				$s_qry.=", i_province=? ";
				$s_qry.=", i_city=? ";
				$s_qry.=", i_zipcode=? ";
				$s_qry.=", s_lat=? ";
				$s_qry.=", s_lng=? ";
                $s_qry.=", i_is_active=? ";
                $s_qry.=", i_edited_date=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(
												  get_formatted_string($info["s_username"]),
												  get_formatted_string($info["s_name"]),
												  get_formatted_string($info["s_email"]),
												  get_formatted_string($info["s_contact_no"]),
												  intval(decrypt($info["i_province"])),
												  intval(decrypt($info["i_city"])),
												  intval(decrypt($info["i_zipcode"])),
												  get_formatted_string($info["s_lat"]),
												  get_formatted_string($info["s_lng"]),
												  intval($info["i_is_active"]),
												  intval($info["i_edited_date"]),
												  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  get_formatted_string($info["s_username"]),
												  get_formatted_string($info["s_name"]),
												  get_formatted_string($info["s_email"]),
												  get_formatted_string($info["s_contact_no"]),
												  intval(decrypt($info["i_province"])),
												  intval(decrypt($info["i_city"])),
												  intval(decrypt($info["i_zipcode"])),
												  get_formatted_string($info["s_lat"]),
												  get_formatted_string($info["s_lng"]),
												  intval($info["i_is_active"]),
												  intval($info["i_edited_date"]),
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
	/*
		Fetch tradesman category
		param @$id tradesman id
	**/
	public function get_tradesman_cat($id,$i_lang_id=1)
	{
		 try
        {
           $s_qry = "SELECT cat.{$this->s_lang_prefix}_s_category_name AS s_category_name FROM ".$this->tbl_tradesman_cat." tc 
			LEFT JOIN {$this->tbl_cat} cat ON cat.i_id = tc.i_category_id WHERE tc.i_user_id =? ";
          $rs = $this->db->query($s_qry, intval($id));
		  $s_cat = "";
		 if($rs->num_rows()>0)
          {
		  	$arr = array();
              foreach($rs->result() as $row)
              {
			  	$arr[] = get_unformatted_string($row->s_category_name);
			  }
		  	 $s_cat = implode(", ",$arr);
		  }
		  
		  return $s_cat;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	}
	
	
	/* checking for duplicate invitation */
	 public function check_invitation_exist($job_id,$tradesman_id)
        {
            $sql = "SELECT id FROM {$this->db->JOB_INVITATION} WHERE i_job_id={$job_id} AND i_tradesman_id={$tradesman_id}";
            $res = $this->db->query($sql);
            $num = $res->num_rows();
            if ($num == 0 )
            {
                return true;
            }
            else
            {
                return false;
            }
        }
	
	
	/* job invitation entry */
	public function insert_job_invitation($info)
    {
        try
        {
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl_job_invite." Set ";
                $s_qry.=" i_job_id=? ";
                $s_qry.=", i_tradesman_id=? ";
                $s_qry.=", i_status=? ";
                $s_qry.=", i_request_date=? ";
                
                $this->db->query($s_qry,array(
												  intval($info['i_job_id']),
												  intval($info['i_tradesman_id']),
												  intval($info["i_status"]),
												  intval($info["i_request_date"])
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl_job_invite." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  intval($info['i_job_id']),
												  intval($info['i_tradesman_id']),
												  intval($info["i_status"]),
												  intval($info["i_request_date"])
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
	
	
	public function get_tradesman_detail($id)
	{
		 try
        {
           $s_qry = "SELECT n.s_email,n.s_name,n.i_signup_lang FROM ".$this->tbl." n  Where n.id=".$id." ";
		   
          $rs = $this->db->query($s_qry, array(intval($id)) );
		  
		 if($rs->num_rows()>0)
          {
		  	$arr = array();
              foreach($rs->result() as $row)
              {
			  	$arr['s_email'] = get_unformatted_string($row->s_email);
				$arr['s_name'] = get_unformatted_string($row->s_name);
				$arr['i_signup_lang'] = intval($row->i_signup_lang);
			  }
		  	 
		  }
		  return $arr;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	}
	
	
	public function invite_mail($job_id,$buyer_id,$tradesman_id,$buyer_name)
	{
		$info = array();
		$info['i_job_id'] = $job_id;
		$info['i_tradesman_id'] = $tradesman_id;
		$info['i_request_date'] = time();
		$info['i_status'] = intval(1);
		
		$to = $this->get_tradesman_detail($tradesman_id);
		$to['email'] = $to['s_email'];
		$tradesman_name = $to['s_name'];
		
		
		
		$is_data_exist = $this->check_invitation_exist($job_id,$tradesman_id);
		if($is_data_exist==1)
		{
			$is_insert = $this->insert_job_invitation($info);
		}
		
		
		 global $CI;
		 $CI->load->model('auto_mail_model','mod_auto');
		 $CI->load->model('manage_buyers_model');
		 
		 $s_wh_id = " WHERE n.i_user_id=".$tradesman_id." ";
		 $buyer_email_key = $CI->manage_buyers_model->fetch_email_keys($s_wh_id);
		 $is_mail_need = in_array('job_invitation',$buyer_email_key);
		 
		 
		 $mailContent	=	$CI->mod_auto->fetch_mail_content('job_invitation','tradesman');
		 $subject = $mailContent['s_subject']; 
		 
		  $filename = $this->config->item('EMAILBODYHTML')."common.html";
		  $handle = @fopen($filename, "r");
		  $mail_html = @fread($handle, filesize($filename));
		  //print_r($mailContent);
		 if(!empty($mailContent))
			{				
				if($to['i_signup_lang']==2)
				{
					$description = $mailContent["s_content_french"];
				}
				else
				{
					$description = $mailContent["s_content"];
				}			
				
				$description = str_replace("[Buyer name]",$buyer_name,$description);	
				$description = str_replace("[service professional name]",$tradesman_name,$description);					
				$description = str_replace("[login_url]",base_url().'user/registration',$description); 
				
				$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
			}
			//unset($mailContent);
		
					$mail_html = str_replace("[site url]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
						
					//echo "<br>DESC".$description;	exit;
					
		 /// Mailing code...[start]
					$site_admin_email = $this->s_admin_email;
					if($to['i_signup_lang']==2)
					{
						$s_subject = $mailContent["s_subject_french"];
					}
					else
					{
						$s_subject = '::: Job invitation mail :::';
					}	
					$this->load->helper('mail');
					
					if($is_mail_need)
					{
						$tect = sendMail($to['email'],$s_subject,$mail_html);
					}
					else
					{
						$tect = true;
					}
					
		 return $tect;
		
	}
    
    public function assign_tradesman_membership($i_tradesman_id,$plan_type)
    {
        try
        {
        $ret_   =   array();
        $s_qry  =   ' SELECT * FROM '.$this->tbl_membership.' WHERE i_type ='.$plan_type ;
        
        $rs =   $this->db->query($s_qry);
            
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_['i_quotes']         =   intval($row->i_quotes) ;
                  $ret_['i_contact_info']   =   intval($row->i_contact_info) ;
                  $ret_['d_price']          =   $row->d_price ;
                  $ret_['i_duration']       =   intval($row->i_duration) ;
              }
              $rs->free_result();
          }
          
          $i_ret_=0; ////Returns false
          if(!empty($ret_))
            {
                
                $s_qry="Insert Into ".$this->tbl_trades_membership." Set ";  
                $s_qry.=" i_tradesman_id=? ";
                $s_qry.=", i_membership_plan_id=? ";
                $s_qry.=", i_quotes=? ";
                $s_qry.=", i_contact_info=? ";
                $s_qry.=", d_price=? ";
                $s_qry.=", i_duration=? ";
                $s_qry.=", dt_created_on=? ";
                $s_qry.=", dt_expired_date=? ";
                
                
                 $this->db->query($s_qry,array(
                                                  $i_tradesman_id,
                                                  $plan_type,
                                                  $ret_['i_quotes'],
                                                  $ret_['i_contact_info'],
                                                  $ret_['d_price'],
                                                  $ret_['i_duration'],
                                                  time(),
                                                  calculate_expire_date(time(),$ret_['i_duration'])
                                                  ));
                 $i_ret_=$this->db->insert_id();
            }
            unset($ret_,$rs,$s_qry);
            return $i_ret_ ;
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
    
    /**
    * Return listing of membership plan of a tradesman
    * 
    * @param string $s_where
    * @param int $i_start
    * @param int $i_limit
    * @return array
    */
    public function fetch_tradesman_membership_plan($s_where='',$i_start=null,$i_limit=null)
    {
        try
        {

            $ret_   =   array();
            $s_qry  =   ' SELECT tm.*,m.i_type,m.d_additional_contact_price FROM '.$this->tbl_trades_membership.' tm 
            LEFT JOIN '.$this->tbl_membership.' m ON tm.i_membership_plan_id = m.i_id '.($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" ); ; 
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
                      $ret_[$i_cnt]['i_duration']       =   intval($row->i_duration);
                      $ret_[$i_cnt]['d_price']          =   $row->d_price ;
                      $ret_[$i_cnt]['d_additional_contact_price']=   $row->d_additional_contact_price ;
                      $ret_[$i_cnt]['s_invoice_pdf_name']=  trim($row->s_invoice_pdf_name) ;
                      $ret_[$i_cnt]['dt_created_on']    =   date($this->conf["site_date_format"],intval($row->dt_created_on)) ;
                      $ret_[$i_cnt]['dt_expired_date']  =   date($this->conf["site_date_format"],intval($row->dt_expired_date));
					  
					 /* $ret_[$i_cnt]['i_quotes']       	=   intval($row->i_quotes);
					  $ret_[$i_cnt]['i_contact_info']   =   intval($row->i_contact_info);
					  $ret_[$i_cnt]['i_quotes_placed']  =   intval($row->i_quotes_placed);
					  $ret_[$i_cnt]['i_contact_purchased']=   intval($row->i_contact_purchased);*/
					  
					  $ret_[$i_cnt]['i_quotes_remain']    =   intval(intval($row->i_quotes) - intval($row->i_quotes_placed));
					  $ret_[$i_cnt]['i_contact_remain']   =   intval(intval($row->i_contact_info) - intval($row->i_contact_purchased));
                      
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
                    ."From ".$this->tbl_trades_membership." tm ".($s_where!=""?$s_where:"" );
            
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
    
    public function update_membership_plan($info)
    {
        try
        {
            $i_ret_  =   0;
            if(!empty($info))
            {
                $s_qry  =   ' UPDATE '.$this->tbl_trades_membership.' SET i_status=0 WHERE i_status=1 AND i_tradesman_id='.$info['i_tradesman_id'];
                $i_aff  =   $this->db->query($s_qry);
                
                if($i_aff)
                {
                    $s_qry="Insert Into ".$this->tbl_trades_membership." Set ";  
                    $s_qry.=" i_tradesman_id=? ";
                    $s_qry.=", i_membership_plan_id=? ";
                    $s_qry.=", i_quotes=? ";
                    $s_qry.=", i_contact_info=? ";
                    $s_qry.=", d_price=? ";
                    $s_qry.=", i_duration=? ";
                    $s_qry.=", dt_created_on=? ";
                    $s_qry.=", dt_expired_date=? ";
                    
                     $this->db->query($s_qry,array(
                                                      $info['i_tradesman_id'],
                                                      $info['i_membership_plan_id'],
                                                      $info['i_quotes'],
                                                      $info['i_contact_info'],
                                                      $info['d_price'],
                                                      $info['i_duration'],
                                                      time(),
                                                      calculate_expire_date(time(),$info['i_duration'])
                                                      ));
                     $i_ret_=$this->db->insert_id();
                    
                }
            }
            unset($i_aff,$s_qry,$info);
            return $i_ret_;
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
//============================= Added from manage_tradesman_model ======================================= //    
    
    /**
    * This function fetch category and experience for a tradesman
    * 
    * @author koushik ,added 18 May 2012 ,hizmetuzmani
    * 
    * @param mixed $id
    * @param mixed $i_lang_id
    * @return string
    */
    public function fetch_tradesman_categoy($id)
    {
         try
        {
            $ret_ = array();
            $s_qry = "SELECT cat.*,tc.s_experience 
            FROM ".$this->tbl_tradesman_cat." tc 
            LEFT JOIN {$this->tbl_cat} cat ON cat.i_id = tc.i_category_id WHERE tc.i_user_id =? ";
          $rs = $this->db->query($s_qry, intval($id));
       
         if($rs->num_rows()>0)
          {
             $i_cnt  =   0; 
              foreach($rs->result() as $row)
              {
                  
                  $ret_[$i_cnt]["s_category_name"]  =   get_unformatted_string($row->{$this->s_lang_prefix.'_s_category_name'}); 
                  if($ret_[$i_cnt]["s_category_name"]=='')
                  {
                  $ret_[$i_cnt]["s_category_name"]  =   get_unformatted_string($row->{$this->site_default_lang_prefix.'_s_category_name'});
                 
                  }
                  $ret_[$i_cnt]['s_experience']       = get_unformatted_string($row->s_experience);
                  $i_cnt++ ;
              }  
        }
        unset($i_cnt,$row,$rs,$s_qry);
        return $ret_;   
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
    }
    
    
    
    /**
    * @author mrinmoy
    * Use in tradesman/edit_profile hizmetuzmani
    * 03-05-2012 set edit basic profile
    */
    
    public function set_edit_profile($info,$i_id)
    {
        try
        {
            
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry    =    "Update ".$this->tbl." Set ";
                //$s_qry.=" s_name=? ";
                $s_qry.=" s_email=? ";
                $s_qry.=", s_address=? ";
                $s_qry.=", s_address2=? ";
                $s_qry.=", i_province=? ";
                $s_qry.=", i_city=? ";
                $s_qry.=", i_zipcode=? ";
                $s_qry.=", s_lat=? ";
                $s_qry.=", s_lng=? ";
                $s_qry.=", i_sm=? ";
                $s_qry.=", s_sm=? ";
                $s_qry.=", i_edited_date=? ";
                //$s_qry.=", i_inform_news=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(
                                                  //get_formatted_string($info["s_name"]),
                                                  get_formatted_string($info["s_email"]),
                                                  get_formatted_string($info["s_address"]),
                                                  get_formatted_string($info["s_address2"]),
                                                  intval(decrypt($info["i_province"])),
                                                  intval(decrypt($info["i_city"])),
                                                  intval(decrypt($info["i_zipcode"])),
                                                  get_formatted_string($info["s_lat"]),
                                                  get_formatted_string($info["s_lng"]),
                                                  intval($info["i_sm"]),
                                                  get_formatted_string($info["s_sm"]),
                                                  intval($info["i_edited_date"]),
                                                  //intval($info["chk_newletter"]),
                                                  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
                                                  //get_formatted_string($info["s_name"]),
                                                  get_formatted_string($info["s_email"]),
                                                  get_formatted_string($info["s_address"]),
                                                  get_formatted_string($info["s_address2"]),
                                                  intval($info["i_province"]),
                                                  intval($info["i_city"]),
                                                  intval($info["i_zipcode"]),
                                                  get_formatted_string($info["s_lat"]),
                                                  get_formatted_string($info["s_lng"]),
                                                  intval($info["i_sm"]),
                                                  get_formatted_string($info["s_sm"]),
                                                  intval($info["i_edited_date"]),
                                                  //intval($info["chk_newletter"]),
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
    
    /**
    * @author mrinmoy
    * Use in tradesman/edit_profile hizmetuzmani
    * 03-05-2012 set edit basic profile
    */
    public function update_profile_details($info,$id)
    {
        try
        {
            
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                
                    $s_qry=" Update ".$this->tbl_tradesman_detail." Set ";
                    //$s_qry.=" i_user_id=? ";
                    $s_qry.=" i_type=? ";
                    $s_qry.=", s_firm_name=? ";
                    $s_qry.=", s_business_name=? ";
                    $s_qry.=", s_firm_phone=? ";
                    $s_qry.=", s_gsm_no=? ";
                    $s_qry.=", s_taxoffice_name=? ";
                    $s_qry.=", s_tax_no=? ";
                    $s_qry.=", s_ssn=? ";
                    $s_qry.=", s_address_file=? ";
                    $s_qry.=" Where i_user_id=? ";
                    
                    $this->db->query($s_qry,array(
                                                    get_formatted_string($info['i_type']),
                                                    get_formatted_string($info['s_firm_name']),
                                                    get_formatted_string($info['s_business_name']),
                                                    get_formatted_string($info['s_firm_phone']),
                                                    get_formatted_string($info['s_gsm_no']),
                                                    get_formatted_string($info['s_taxoffice_name']),
                                                    get_formatted_string($info['s_tax_no']),
                                                    get_formatted_string($info['s_ssn']),
                                                    get_formatted_string($info['s_address_file']),
                                                    intval($id)
                                                ));
                                                
                    $i_ret_=$this->db->affected_rows(); 
                    if($i_ret_)
                    {
                         $logi["msg"]="Inserting into ".$this->tbl_tradesman_detail." ";
                        $logi["sql"]= serialize(array($s_qry,array(
                                                    get_formatted_string($info['i_type']),
                                                    get_formatted_string($info['s_firm_name']),
                                                    get_formatted_string($info['s_business_name']),
                                                    get_formatted_string($info['s_firm_phone']),
                                                    get_formatted_string($info['s_gsm_no']),
                                                    get_formatted_string($info['s_taxoffice_name']),
                                                    get_formatted_string($info['s_tax_no']),
                                                    get_formatted_string($info['s_ssn']),
                                                    get_formatted_string($info['s_address_file']),
                                                    intval($id)
                                                )) ) ; 
                        $this->log_info($logi); 
                        unset($logi,$logindata);                        
                    }                            
                                                
                
                else
                $i_ret_ = true;
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
    * @author mrinmoy
    * Use in tradesman/contact_details hizmetuzmani
    * 03-05-2012 set edit basic profile
    */
    public function set_contact_details($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry    =    "Update ".$this->tbl." Set ";
                $s_qry.=" i_sm=? ";
                $s_qry.=", s_sm=? ";
                $s_qry.=", i_sm2=? ";
                $s_qry.=", s_sm2=? ";
                $s_qry.=", i_sm3=? ";
                $s_qry.=", s_sm3=? ";
                $s_qry.=", s_contact_no=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array( 
                                                  get_formatted_string($info["i_sm"]),
                                                  get_formatted_string($info["s_sm"]),
                                                  get_formatted_string($info["i_sm2"]),
                                                  get_formatted_string($info["s_sm2"]),
                                                  get_formatted_string($info["i_sm3"]),
                                                  get_formatted_string($info["s_sm3"]),
                                                  get_formatted_string($info["s_contact_no"]),
                                                  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array( 
                                                  get_formatted_string($info["i_sm"]),
                                                  get_formatted_string($info["s_sm"]),
                                                  get_formatted_string($info["i_sm2"]),
                                                  get_formatted_string($info["s_sm2"]),
                                                  get_formatted_string($info["i_sm3"]),
                                                  get_formatted_string($info["s_sm3"]),
                                                  get_formatted_string($info["s_contact_no"]),
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
    
    /**
    * @author mrinmoy
    * Use in tradesman/album hizmetuzmani
    * 03-05-2012 get total album image of a 
    */
    public function get_total_album_images($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl_trades_album." n "
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
    
    
    
    /**
    * @author mrinmoy
    * Use in tradesman/album hizmetuzmani
    * 03-05-2012 set update photo in album of tradesman
    */
    public function upload_album_photo($info,$id)
    {
        try
        {
            //print_r($info); exit;
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                if($info['s_image'] !='')
                {
                    $s_qry="Insert Into ".$this->tbl_trades_album." Set ";
                    $s_qry.=" i_user_id=? ";
                    $s_qry.=", s_image=? ";
                    $s_qry.=", s_title=? ";
                    $s_qry.=", i_uploaded_date=? ";
                    
                    $this->db->query($s_qry,array(
                                                    intval($id),
                                                    get_formatted_string($info['s_image']),
                                                    get_formatted_string($info['s_title']),
                                                    intval($info['i_uploaded_date'])
                                                ));
                                                
                    $i_ret_=$this->db->insert_id(); 
                    if($i_ret_)
                    {
                         $logi["msg"]="Inserting into ".$this->tbl_trades_album." ";
                        $logi["sql"]= serialize(array($s_qry,array(
                                                    intval($id),
                                                    get_formatted_string($info['s_image']),
                                                    get_formatted_string($info['s_title']),
                                                    intval($info['i_uploaded_date'])
                                                )) ) ; 
                        $this->log_info($logi); 
                        unset($logi,$logindata);                        
                    }                            
                                                
                }
                else
                $i_ret_ = true;
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
    * @author mrinmoy
    * Use in tradesman/album hizmetuzmani
    * 03-05-2012 get all image
    */
    
    public function get_album_images($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
              $ret_=array();
            $s_qry="SELECT * FROM ".$this->tbl_trades_album." n "
                .($s_where!=""?$s_where:"" )." ORDER BY n.i_uploaded_date DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_title"]    =    get_unformatted_string($row->s_title); 
                  $ret_[$i_cnt]["s_image"]    =    get_unformatted_string($row->s_image); 
                  
                  $ret_[$i_cnt]["dt_entry_date"]=date($this->conf["site_date_format"],intval($row->i_uploaded_date)); 
                  $ret_[$i_cnt]["fn_entry_date"]=date("d.m.Y",intval($row->i_uploaded_date));
                  
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
    
    
    /**
    * @author mrinmoy
    * tradesman working palce
    */
    /* 04-05-2012 fetch all working place of a tradesman */
     public function fetch_all_work_place($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {              
          $ret_=array();        
          $s_qry="SELECT n.* FROM ".$this->tbl_work_place." AS n "            
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );            
              
          $rs=$this->db->query($s_qry); 
           $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {                 
                  $ret_[$i_cnt]["id"]                =    $row->id;////always integer
                  $ret_[$i_cnt]['s_work_place']        =    get_unformatted_string($row->s_work_place); 
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
    
    
    /* 04-05-2012 fetch all payment units he want of a tradesman */
     public function fetch_tradesmen_payment_unit($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {              
          $ret_=array();        
          $s_qry="SELECT n.* FROM ".$this->tbl_tradesman_pay_unit." AS n "            
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );            
              
          $rs=$this->db->query($s_qry); 
           $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {                 
                  $ret_[$i_cnt]["id"]                =    $row->i_id;////always integer
                  $ret_[$i_cnt]['s_payment_unit']    =    get_unformatted_string($this->db->PAYMENTMETHOD[$row->s_payment_unit]);
				  $ret_[$i_cnt]['i_payment_unit']    =    get_unformatted_string($row->s_payment_unit); 
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
    
    
    /* 04-05-2012 fetch all payment accept time of a tradesman */
     public function fetch_tradesmen_payment_time($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {              
          $ret_=array();        
          $s_qry="SELECT n.* FROM ".$this->tbl_tradesman_pay_time." AS n "            
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );            
              
          $rs=$this->db->query($s_qry); 
           $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {                 
                  $ret_[$i_cnt]["id"]                =    $row->i_id;////always integer
                  $ret_[$i_cnt]['s_pay_time']        =    get_unformatted_string($row->s_pay_time); 
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
	
	/* 01-06-2012 fetch all working days  of a tradesman */
     public function fetch_tradesmen_working_days($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {              
          $ret_=array();        
          $s_qry="SELECT n.* FROM ".$this->tbl_tradesman_work_days." AS n "            
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );            
              
          $rs=$this->db->query($s_qry); 
           $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {                 
                  $ret_[$i_cnt]["id"]            =    $row->i_id;////always integer
                  $ret_[$i_cnt]['s_days']        =    get_unformatted_string($this->db->WORKINGDAYS[$row->i_work_days]); 
				  $ret_[$i_cnt]['i_days']        =    $row->i_work_days;
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
    
    
    
    /* fetch all category of a tradesman
    * date: 04-05-2012
    */
     public function fetch_all_category($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {              
          $ret_=array();
          $s_qry="SELECT c.i_id as category_id,c.{$this->s_lang_prefix}_s_category_name AS s_category_name,n.s_experience
                  FROM ".$this->tbl_tradesman_cat." AS n "  
                  ."LEFT JOIN ".$this->tbl_cat." AS c ON n.i_category_id = c.i_id    "           
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );            
            //echo $s_qry;     
          $rs=$this->db->query($s_qry); 
           $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {                 
                  $ret_[$i_cnt]["id"]                =    $row->category_id;////always integer
                  $ret_[$i_cnt]["s_experience"]     =    get_unformatted_string($row->s_experience);
                  
                  $ret_[$i_cnt]["s_category_name"]  =   get_unformatted_string($row->s_category_name); 
                  if($ret_[$i_cnt]["s_category_name"]=='')
                  {
                  $ret_[$i_cnt]["s_category_name"]  =   get_unformatted_string($row->{$this->site_default_lang_prefix.'_s_category_name'}); 
                  }
                  
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
    
    
    /* update professional information of a tradesman
    * date: 04-05-2012
    */
    
    public function update_professional_information($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry    =    "Update ".$this->tbl_tradesman_detail." Set ";
                $s_qry.=" s_keyword=? ";
                $s_qry.=", s_about_me=? ";
                //$s_qry.=", s_profile_pic=? ";
                //$s_qry.=", s_firm_logo=? ";
                $s_qry.=" Where i_user_id=? ";
                
                $i_ret_ = $this->db->query($s_qry,array( 
                                                  get_formatted_string($info["s_keyword"]),
                                                  get_formatted_string($info["s_about_me"]),
                                                  //get_formatted_string($info["s_profile_pic"]),
                                                  //get_formatted_string($info["s_firm_logo"]),
                                                  intval($i_id)

                                                     ));
               // $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl_tradesman_detail." ";
                    $logi["sql"]= serialize(array($s_qry,array( 
                                                  get_formatted_string($info["s_keyword"]),
                                                  get_formatted_string($info["s_about_me"]),
                                                  //get_formatted_string($info["s_profile_pic"]),
                                                 // get_formatted_string($info["s_firm_logo"]),
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
    
    
    public function update_profile_image($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry    =    "Update ".$this->tbl_user_image." Set ";
                $s_qry.=" s_user_image=? ";
                $s_qry.=" Where i_user_id=? ";
                
                $this->db->query($s_qry,array(                                                  
                                                  get_formatted_string($info["s_user_image"]),                                                  
                                                  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(                                                  
                                                  get_formatted_string($info["s_user_image"]),                                                  
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
    
    
    public function add_new_testimonial($info,$user_name)
    {
        try
        {
            //print_r($info); exit;
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                if($info['s_content'] !='')
                {
                    $s_qry="Insert Into ".$this->tbl_testimonial." Set ";
                    $s_qry.=" s_person_name=? ";
                    $s_qry.=", s_content=? ";
                    $s_qry.=", dt_entry_date=? ";
                    
                    $this->db->query($s_qry,array(
                                                    get_formatted_string($user_name),
                                                    get_formatted_string($info['s_content']),
                                                    intval($info['dt_entry_date'])
                                                ));
                                                
                    $i_ret_=$this->db->insert_id(); 
                    if($i_ret_)
                    {
                         $logi["msg"]="Inserting into ".$this->tbl_testimonial." ";
                        $logi["sql"]= serialize(array($s_qry,array(
                                                    get_formatted_string($user_name),
                                                    get_formatted_string($info['s_content']),
                                                    intval($info['dt_entry_date'])
                                                )) ) ; 
                        $this->log_info($logi); 
                        unset($logi,$logindata);                        
                    }                            
                                                
                }
                else
                $i_ret_ = true;
            }
            unset($s_qry, $info );
            return $i_ret_;
        }
        catch(Exception $err_obj)
        {    
            show_error($err_obj->getMessage());
        }
    }    
    
    
    public function fetch_testimonial($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
              $ret_=array();
            $s_qry="SELECT * FROM ".$this->tbl_testimonial." n "
                .($s_where!=""?$s_where:"" )." ORDER BY n.dt_entry_date DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->i_id;////always integer
                  $ret_[$i_cnt]["s_person_name"]=stripslashes(htmlspecialchars_decode($row->s_person_name)); 
                  $s_desc = strip_tags(stripslashes(htmlspecialchars_decode($row->s_content)));
                  $ret_[$i_cnt]["s_content"]= (strlen($s_desc)>70) ? substr_replace($s_desc,'...',74) : $s_desc;
                  $ret_[$i_cnt]["s_large_content"]= (strlen($s_desc)>300) ? substr_replace($s_desc,'...',304) : $s_desc;
                  $ret_[$i_cnt]["s_full_content"] = nl2br(stripslashes(htmlspecialchars_decode($row->s_content)));
                  
                  $ret_[$i_cnt]["dt_entry_date"]=date($this->conf["site_date_format"],intval($row->dt_entry_date)); 
                  $ret_[$i_cnt]["fn_entry_date"]=date("d/m/Y",intval($row->dt_entry_date));
                  $ret_[$i_cnt]["i_is_active"]=intval($row->i_status); 
                  $ret_[$i_cnt]["s_is_active"]=$this->db->TESTIMONIALSTATE[$row->i_status];
                  
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
    
    /*upadte tardesman won jobs 
    * author@ mrinmoy on 17-05-2012
    */
    function update_tradesman_won_job($i_tradesman_id)
    {
        $sql = "UPDATE {$this->tbl_tradesman_detail} SET i_jobs_won = i_jobs_won +1 WHERE i_user_id={$i_tradesman_id}";
        $this->db->query($sql);
    }
    
    
    
    /*** check given password is correct or not **/
    
    public function check_password($login_data,$id)
    {
        try
        {            
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select s_username,s_name,i_role,i_is_active From ".$this->tbl." 
                      Where s_password='".md5(trim($login_data).$this->conf["security_salt"])."' ";                    
           $s_qry.="And id=".$id." ";            
          $s_qry.="And i_is_active=1 ";
          
          $rs=$this->db->query($s_qry,$stmt_val);
          //echo $this->db->last_query();
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_["id"]=$row->id;////always integer
                  $ret_["s_user_name"]=stripslashes($row->s_username); 
                  $ret_["s_name"]=trim($row->s_name);
                  $ret_["i_user_type_id"]=intval($row->i_role);
                  $ret_["dt_created_on"]=date($this->conf["site_date_format"],intval($row->i_created_date)); 
                  $ret_["i_is_active"]    =intval($row->i_is_active); 
                  $ret_["s_is_active"]    =(intval($row->i_is_active)==1?"Active":"Inactive");                   
                 
                  //////////log report///
                    $logi["msg"]="Logged in as ".$ret_["s_name"]
                                ."[".$ret_["s_user_name"]."] at ".date("Y-M-d H:i:s") ;
                                                  
                    $this->log_info($logi); 
                    unset($logi);  
                    //////////end log report///                
                  
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$login_data,$stmt_val);
          return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    } 
    
    /* set new password */
    public function set_new_password($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry    =    "Update ".$this->tbl." Set ";
                if(isset($info["s_password"]) && !empty($info["s_password"]))
                {
                    $s_password = md5(trim($info["s_password"]).$this->conf["security_salt"]);
                    $s_qry.=" s_password= '".$s_password."' ";
                }            
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(
                                                  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
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
    
    
    /* insert email settings */
    public function insert_email_settings($info,$i_id)
    {
        try
        {
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
                
                foreach($info as $val)
                {
                    if($val!='')
                    {
                
                    $s_qry="Insert Into ".$this->tbl_automail_right." Set ";
                    $s_qry.=" mail_key=? ";
                    $s_qry.=", i_user_id=? ";
                    //echo $s_qry; exit;
                    $this->db->query($s_qry,array(
                                                      get_formatted_string($val),
                                                      intval($i_id)
                                                     ));
                    $i_ret_=$this->db->insert_id();     
                    if($i_ret_)
                    {
                        
                        
                        $logi["msg"]="Inserting into ".$this->tbl_automail_right." ";
                        $logi["sql"]= serialize(array($s_qry,array(
                                                      get_formatted_string($val),
                                                      intval($i_id)
                                                     )) ) ;
                        $this->log_info($logi); 
                        unset($logi,$logindata);
                    }
                    
              }
            
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
    
     public function active_account($activation_code) {
                $sql = "SELECT s_username FROM ".$this->tbl."
                            WHERE s_verification_code='{$activation_code}' AND i_is_active = 0";
                $res = $this->db->query($sql);
                $num = $res->num_rows();
                $arr_master = array('i_is_active'=>1);
                if ($num == 1 )
                {
                    $sql = " UPDATE ".$this->tbl." SET i_is_active=1
                            WHERE s_verification_code='{$activation_code}' AND i_is_active = 0";
                    $res = $this->db->query($sql);
                    return true;
                }
                else
                {
                    return false;
                }
          }
          
          
              
    /* set email settings key */
    public function set_email_settings($info,$i_id)
    {
        try
        {
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
                $this->delete_previous_setting($i_id); 
                foreach($info as $val)
                {
                    if($val!='')
                    {
                
                    $s_qry="Insert Into ".$this->tbl_automail_right." Set ";
                    $s_qry.=" mail_key=? ";
                    $s_qry.=", i_user_id=? ";
                    //echo $s_qry; exit;
                    $this->db->query($s_qry,array(
                                                      get_formatted_string($val),
                                                      intval($i_id)
                                                     ));
                    $i_ret_=$this->db->insert_id();     
                    if($i_ret_)
                    {
                        $logi["msg"]="Inserting into ".$this->tbl_automail_right." ";
                        $logi["sql"]= serialize(array($s_qry,array(
                                                      get_formatted_string($val),
                                                      intval($i_id)
                                                     )) ) ;
                        $this->log_info($logi); 
                        unset($logi,$logindata);
                    }
                    
              }
            
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
     
    
    /* delete previous email setting */
    public function delete_previous_setting($i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
    
            if(intval($i_id)>0)
            {
                $s_qry="DELETE FROM ".$this->tbl_automail_right." ";
                $s_qry.=" Where i_user_id=? ";
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
                $s_qry="DELETE FROM ".$this->tbl_automail_right." ";
                $this->db->query($s_qry);
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Deleting all information from ".$this->tbl_automail_right." ";
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
    
	
	/* image insert into database*/
	public function update_professional_image($info,$id)
	{
		try
		{
			//echo $info['s_firm_logo']; exit;
			$i_ret_=0;////Returns false
			if(!empty($info))
			{
				if($info['s_firm_logo'] !='')
				{
					$s_qry="Update  ".$this->tbl." Set ";
					$s_qry.=" s_image=? ";
					$s_qry.=" Where id=? ";
					
					$i_ret_ = $this->db->query($s_qry,array(
													get_formatted_string($info['s_firm_logo']),
													intval($id)
												));
					//echo $this->db->last_query(); exit;							
					//$i_ret_=$this->db->insert_id(); 
					if($i_ret_)
					{
						 $logi["msg"]="Inserting into ".$this->tbl." ";
                    	$logi["sql"]= serialize(array($s_qry,array(
													get_formatted_string($info['s_firm_logo']),
													intval($id)
												)) ) ; 
						$this->log_info($logi); 
                    	unset($logi,$logindata);						
					}							
												
				}
				else
				$i_ret_ = true;
			}
			unset($s_qry, $info );
            return $i_ret_;
		}
		catch(Exception $err_obj)
		{	
			show_error($err_obj->getMessage());
		}
	}	
    
    /* fetch email keys */    
     public function fetch_email_keys($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
            
              
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select * From ".$this->tbl_automail_right." AS n "             
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            
            //echo $s_qry;     
          $rs=$this->db->query($s_qry); 
           $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                 
                  //$ret_[$i_cnt]["id"]        =$row->id;////always integer
                  $ret_[]    =    get_unformatted_string($row->mail_key); 
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
    * This function use for fetch similar type of tradesman 
    * having same type of category
    * 
    * @added by koushik 25 may 2012 hizmetuzmani
    * 
    * @param mixed $s_where
    * @param mixed $i_start
    * @param mixed $i_limit
    */
    public function fetch_similar_tradesman($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT tc.i_category_id,tc.i_user_id,u.s_username                    
                     FROM ".$this->tbl_tradesman_cat." tc ".
                     " LEFT JOIN {$this->tbl} u ON tc.i_user_id = u.id"
                .($s_where!=""?$s_where:"" ).' GROUP BY tc.i_user_id'.(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
           $rs=$this->db->query($s_qry);
           $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["i_category_id"]     =   intval($row->i_category_id);////always integer
                  $ret_[$i_cnt]["i_user_id"]         =   intval($row->i_user_id); 
                  $ret_[$i_cnt]["s_username"]        =   get_unformatted_string($row->s_username); 

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
    
    public function delete_album_image($img_id)
    {
        try
        {
            $i_ret_     =   0 ;
            if($img_id)
            {
                $s_qry="DELETE FROM ".$this->tbl_trades_album." ";
                $s_qry.=" Where id=? ";
                $this->db->query($s_qry, array(intval($img_id)) );
               
                $i_ret_ =   $this->db->affected_rows();
            }
            return $i_ret_ ;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    public function add_contactlist($info,$update_contact=true)
    {
        try
        {
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl_trades_contactlist." Set ";
                
                $s_qry.=" i_tradesman_id=? ";
                $s_qry.=", i_buyer_id=? ";
                $s_qry.=", i_payment_type=? ";
                $s_qry.=", i_status=? ";
                $s_qry.=", dt_created_on=? ";

                $this->db->query($s_qry,array(
                                                  intval($info["i_tradesman_id"]),
                                                  intval($info["i_buyer_id"]),
                                                  intval($info["i_payment_type"]),
                                                  intval($info["i_status"]),
                                                  intval($info["dt_created_on"])

                                                 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    if($update_contact)
                    {
                        // Update the count purchased plus 1
                         $s_qry    =    "Update ".$this->tbl_trades_membership." Set i_contact_purchased=i_contact_purchased+1 WHERE i_tradesman_id=".$info["i_tradesman_id"] ." AND i_status=1";
                    $this->db->query($s_qry); 
                        
                    }
                    
                   
                    
                                                       
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
                                                  intval($info["i_tradesman_id"]),
                                                  intval($info["i_buyer_id"]),
                                                  intval($info["i_payment_type"]),
                                                  intval($info["i_status"]),
                                                  intval($info["dt_created_on"])
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
    
    public function fetch_contact_list($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
             $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select tc.i_id contactlist_id,tc.i_status,tc.i_tradesman_id,u.* From ".$this->tbl_trades_contactlist." AS tc 
          LEFT JOIN  ".$this->tbl." u ON u.id=tc.i_buyer_id "             
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            
            //echo $s_qry;     
          $rs=$this->db->query($s_qry); 
           $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]   =   $row->contactlist_id;////always integer
                  $ret_[$i_cnt]["id"]   =   $row->id;////always integer
                  $ret_[$i_cnt]["s_username"]        =    get_unformatted_string($row->s_username); 
                  $ret_[$i_cnt]["s_name"]            =    get_unformatted_string($row->s_name); 
                  $ret_[$i_cnt]["s_email"]           =    get_unformatted_string($row->s_email); 
                  $ret_[$i_cnt]["s_skype_id"]        =    get_unformatted_string($row->s_skype_id); 
                  $ret_[$i_cnt]["s_msn_id"]          =    get_unformatted_string($row->s_msn_id); 
                  $ret_[$i_cnt]["s_yahoo_id"]        =    get_unformatted_string($row->s_yahoo_id); 
                  $ret_[$i_cnt]["s_contact_no"]      =    get_unformatted_string($row->s_contact_no); 
                  $ret_[$i_cnt]["s_address"]         =    get_unformatted_string($row->s_address);
                  $ret_[$i_cnt]["dt_created_on"]     =    date($this->conf["site_date_format"],intval($row->i_created_date)); 
                  $ret_[$i_cnt]["i_is_active"]       =    intval($row->i_is_active); 
                  $ret_[$i_cnt]["s_is_active"]       =    (intval($row->i_is_active)==1?"Active":"Inactive");
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
    
    public function fetch_bank_transfer_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {
            $ret_=array();
            $member_plan    =   $this->db->MEMBERPLAN ;
            $s_qry="SELECT n.*,u.s_username,u.s_name                     
                     FROM ".$this->tbl_bank_transfer." n ".
                     " LEFT JOIN {$this->tbl} u ON n.i_tradesman_id = u.id "
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
                
          
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          $STATUS   =   array(0=>'Pending',1=>'Approved',2=>'Rejected');
          
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->i_id;////always integer
                  $ret_[$i_cnt]["s_username"]        =    get_unformatted_string($row->s_username); 
                  $ret_[$i_cnt]["s_name"]            =    get_unformatted_string($row->s_name); 
                  $ret_[$i_cnt]["s_bank_info"]       =    nl2br(get_unformatted_string($row->s_bank_info)); 
                  $ret_[$i_cnt]["i_membership_plan"] =    intval($row->i_membership_plan); 
                  $ret_[$i_cnt]["s_membership_plan"] =    $member_plan[intval($row->i_membership_plan)]; 
                  $ret_[$i_cnt]["dt_created_on"]     =    date($this->conf["site_date_format"],intval($row->dt_created_on)); 
                  $ret_[$i_cnt]["i_status"]          =    intval($row->i_status); 
                  $ret_[$i_cnt]["s_is_active"]       =    $STATUS[intval($row->i_status)] ;
                  
                  $i_cnt++;
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$order_name,$order_by);
          return $ret_;
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    public function gettotal_bank_transfer($s_where='')
    {
        try
        {
            $ret_=0;
              $s_qry="Select count(*) as i_total "
                    ."From ".$this->tbl_bank_transfer." n ".($s_where!=""?$s_where:"" );
            
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
    * Return listing of membership plan of a tradesman
    * 
    * @param string $s_where
    * @param int $i_start
    * @param int $i_limit
    * @return array
    */
    public function fetch_bank_transfer_membership($s_where='',$i_start=null,$i_limit=null)
    {
        try
        {

            $ret_   =   array();
            $s_qry  =   ' SELECT bt.*,m.i_id i_plan_id,m.i_type,m.i_quotes,m.i_contact_info,m.d_price,m.i_duration FROM '.$this->tbl_bank_transfer.' bt 
            LEFT JOIN '.$this->tbl_membership.' m ON bt.i_membership_plan = m.i_type'.($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" ); ; 
            $rs =   $this->db->query($s_qry);   
            
            $membership_plan    =   $this->db->MEMBERPLAN   ;
            if($rs->num_rows()>0)
            { 
                $i_cnt  =   0;
                foreach($rs->result() as $row)
                {
                      $ret_[$i_cnt]['id']               =   intval($row->i_id) ;
                      $ret_[$i_cnt]['i_plan_type']      =   intval($row->i_type) ;
                      $ret_[$i_cnt]['i_plan_id']        =   intval($row->i_plan_id) ;
                      $ret_[$i_cnt]['i_tradesman_id']   =   intval($row->i_tradesman_id) ;
                      $ret_[$i_cnt]['s_plan_type']      =   $membership_plan[intval($row->i_type)];
                      $ret_[$i_cnt]['i_duration']       =   intval($row->i_duration) ;
                      $ret_[$i_cnt]['i_contact_info']   =   intval($row->i_contact_info) ;
                      $ret_[$i_cnt]['i_quotes']         =   intval($row->i_quotes) ;
                      $ret_[$i_cnt]['d_price']          =   $row->d_price ;
                      $ret_[$i_cnt]['dt_created_on']    =   date($this->conf["site_date_format"],intval($row->dt_created_on)) ;
                     
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

	
    public function __destruct()
    {}                 
  
  
}
///end of class
?>