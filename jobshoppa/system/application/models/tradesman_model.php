<?php
/*********
* Author: Samarendu Ghosh
* Date  : 18 Oct 2011
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

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->USERMANAGE;  
		  $this->tbl_city = $this->db->CITY;   
		  $this->tbl_zip = $this->db->ZIPCODE;  
		  $this->tbl_state = $this->db->STATE; 
		  $this->tbl_user_image = $this->db->USREIMAGE;   
		  $this->tbl_tradesman_detail = $this->db->TRADESMANDETAILS;
		  $this->tbl_tradesman_cat = $this->db->TRADESMANCAT; 
		  $this->tbl_cat = $this->db->CATEGORY; 
		  $this->tbl_news_subscript = $this->db->NEWSLETTERSUBCRIPTION;  
		  $this->tbl_testimonial = $this->db->TESTIMONIAL; 
		  
		  $this->tbl_job_invite = $this->db->JOB_INVITATION;
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
			$s_qry="SELECT DISTINCT  n.id, n.s_username, n.s_name, n.s_email, n.s_skype_id, n.s_msn_id,
					 n.s_yahoo_id, n.s_contact_no,n.s_address, n.i_created_date, n.i_is_active, 
					 n.i_account_expire_date, s.state, c.city, 
					 z.postal_code,td.s_skills,td.s_about_me,td.s_qualification,td.s_website,td.s_business_name,
					 td.i_payment_type,td.i_like_travel,td.i_feedback_rating,td.f_positive_feedback_percentage,
					 td.i_jobs_won,td.i_feedback_received 					
					 FROM ".$this->tbl." n ".
					 " LEFT JOIN {$this->tbl_state} s ON s.id = n.i_province".
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
				  $ret_[$i_cnt]["s_state"]			=	get_unformatted_string($row->state); 
				  $ret_[$i_cnt]["s_city"]			=	get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["s_postal_code"]	=	get_unformatted_string($row->postal_code);
				  $ret_[$i_cnt]["s_user_image"]		=	get_unformatted_string($row->s_user_image);
				  $ret_[$i_cnt]["i_account_expire_date"]= intval($row->i_account_expire_date); 
				  $ret_[$i_cnt]["dt_account_expire_date"]	=	date($this->conf["site_date_format"],intval($row->i_account_expire_date)); 
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
    * 
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @param int $i_start, starting value for pagination
    * @param int $i_limit, number of records to fetch used for pagination
    * @returns array
    */
    public function fetch_featured($s_where=null,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {	
          	$ret_=array();
			$s_qry="SELECT DISTINCT  n.id, n.s_username, n.s_name, n.s_email, n.s_skype_id, n.s_msn_id,
					 n.s_yahoo_id, n.s_contact_no,n.s_address, n.i_created_date, n.i_is_active, s.state, c.city, 
					 z.postal_code,td.s_skills,td.s_about_me,td.s_qualification,td.s_website,td.s_business_name,
					 td.i_payment_type,td.i_like_travel,td.i_feedback_rating,td.f_positive_feedback_percentage,
					 td.i_jobs_won,td.i_feedback_received,u.s_user_image 					
					 FROM ".$this->tbl." n ".
					 " LEFT JOIN {$this->tbl_state} s ON s.id = n.i_province".
					 " LEFT JOIN {$this->tbl_city} c ON c.id = n.i_city".
					 " LEFT JOIN {$this->tbl_tradesman_detail} td ON td.i_user_id = n.id".
					 " LEFT JOIN {$this->tbl_user_image} u ON u.i_user_id = n.id".
					 " RIGHT JOIN {$this->tbl_tradesman_cat} tc ON tc.i_user_id = n.id".  
					 " LEFT JOIN {$this->tbl_zip} z ON z.id = n.i_zipcode"
					 
					 
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_by} DESC".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
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
				  $ret_[$i_cnt]["s_email"]			=	get_unformatted_string($row->s_email); 
				  $ret_[$i_cnt]["s_skype_id"]		=	get_unformatted_string($row->s_skype_id); 
				  $ret_[$i_cnt]["s_msn_id"]			=	get_unformatted_string($row->s_msn_id); 
				  $ret_[$i_cnt]["s_yahoo_id"]		=	get_unformatted_string($row->s_yahoo_id); 
				  $ret_[$i_cnt]["s_contact_no"]		=	get_unformatted_string($row->s_contact_no); 
				  $ret_[$i_cnt]["s_address"]		=	get_unformatted_string($row->s_address);
				  $ret_[$i_cnt]["s_state"]			=	get_unformatted_string($row->state); 
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
	
	
	
	
	
    public function fetch_home_page_featured($s_where=null,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {	
          	$ret_=array();
			$s_qry="SELECT DISTINCT  n.id, n.s_username, n.s_name, n.s_email, n.s_skype_id, n.s_msn_id,
					 n.s_yahoo_id, n.s_contact_no,n.s_address, n.i_created_date, n.i_is_active, s.state, c.city, 
					 z.postal_code,td.s_skills,td.s_about_me,td.s_qualification,td.s_website,td.s_business_name,
					 td.i_payment_type,td.i_like_travel,td.i_feedback_rating,td.f_positive_feedback_percentage,
					 td.i_jobs_won,td.i_feedback_received,u.s_user_image 					
					 FROM ".$this->tbl." n ".
					 " LEFT JOIN {$this->tbl_state} s ON s.id = n.i_province".
					 " LEFT JOIN {$this->tbl_city} c ON c.id = n.i_city".
					 " LEFT JOIN {$this->tbl_tradesman_detail} td ON td.i_user_id = n.id".
					 " LEFT JOIN {$this->tbl_user_image} u ON u.i_user_id = n.id".
					 " RIGHT JOIN {$this->tbl_tradesman_cat} tc ON tc.i_user_id = n.id".  
					 " LEFT JOIN {$this->tbl_zip} z ON z.id = n.i_zipcode"
					 
					 
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
				  $ret_[$i_cnt]["s_email"]			=	get_unformatted_string($row->s_email); 
				  $ret_[$i_cnt]["s_skype_id"]		=	get_unformatted_string($row->s_skype_id); 
				  $ret_[$i_cnt]["s_msn_id"]			=	get_unformatted_string($row->s_msn_id); 
				  $ret_[$i_cnt]["s_yahoo_id"]		=	get_unformatted_string($row->s_yahoo_id); 
				  $ret_[$i_cnt]["s_contact_no"]		=	get_unformatted_string($row->s_contact_no); 
				  $ret_[$i_cnt]["s_address"]		=	get_unformatted_string($row->s_address);
				  $ret_[$i_cnt]["s_state"]			=	get_unformatted_string($row->state); 
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
				  $ret_[$i_cnt]["i_feedback_rating"]=	intval($row->i_feedback_rating);
				  $ret_[$i_cnt]["f_positive_feedback_percentage"]=	empty($row->f_positive_feedback_percentage)?0:doubleval($row->f_positive_feedback_percentage);
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
			$s_qry="SELECT DISTINCT f.i_receiver_user_id,n.id, n.s_username, n.s_name, n.s_email, n.s_skype_id, n.s_msn_id,
					 n.s_yahoo_id, n.s_contact_no,n.s_address, n.i_created_date, n.i_is_active, s.state, c.city, 
					 z.postal_code,td.s_skills,td.s_about_me,td.s_qualification,td.s_website,td.s_business_name,
					 td.i_payment_type,td.i_like_travel,td.i_feedback_rating,td.f_positive_feedback_percentage,
					 td.i_jobs_won,td.i_feedback_received,(SELECT COUNT(*) FROM quoteurjob_job_feedback m WHERE m.i_receiver_user_id  = f.i_receiver_user_id ) AS i_total,u.s_user_image 					
					 FROM {$this->db->JOBFEEDBACK} f LEFT JOIN  ".$this->tbl." n ON n.id = f.i_receiver_user_id ".
					 " LEFT JOIN {$this->tbl_state} s ON s.id = n.i_province".
					 " LEFT JOIN {$this->tbl_city} c ON c.id = n.i_city".
					 " LEFT JOIN {$this->tbl_tradesman_detail} td ON td.i_user_id = n.id".
					 " LEFT JOIN {$this->tbl_user_image} u ON u.i_user_id = n.id".
					 " RIGHT JOIN {$this->tbl_tradesman_cat} tc ON tc.i_user_id = n.id".  
					 " LEFT JOIN {$this->tbl_zip} z ON z.id = n.i_zipcode"
					 
					 
                .($s_where!=""?$s_where:"" )."  ORDER BY td.i_feedback_rating  DESC,td.f_positive_feedback_percentage DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
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
				  $ret_[$i_cnt]["s_state"]			=	get_unformatted_string($row->state); 
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
				" LEFT JOIN {$this->tbl_state} s ON s.id = n.i_province".
					 " LEFT JOIN {$this->tbl_city} c ON c.id = n.i_city".
					 " LEFT JOIN {$this->tbl_tradesman_detail} td ON td.i_user_id = n.id".
					 " LEFT JOIN {$this->tbl_user_image} u ON u.i_user_id = n.id".
					 " RIGHT JOIN {$this->tbl_tradesman_cat} tc ON tc.i_user_id = n.id".  
					 " LEFT JOIN {$this->tbl_zip} z ON z.id = n.i_zipcode"
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
    public function fetch_this($i_id,$i_lang_id=1)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select 
          s.s_skills,s.s_about_me,s.s_qualification,s.s_website,s.s_business_name,s.s_work_history,s.i_payment_type,
		  s.i_like_travel,s.i_phone_internet,u.s_user_image, n.*,st.state, ct.city, z.postal_code,s.i_feedback_rating,
		  s.f_positive_feedback_percentage, s.i_jobs_won,s.i_feedback_received,s.i_verify_credentials,
		  s.i_verify_phone,s.i_verify_facebook From ".$this->tbl." AS n ".
		  	" LEFT JOIN {$this->tbl_tradesman_detail} s ON s.i_user_id = n.id".
			" LEFT JOIN {$this->tbl_user_image} u ON u.i_user_id = n.id".   
			" LEFT JOIN {$this->tbl_tradesman_cat} c ON c.i_user_id = n.id".  
			" LEFT JOIN {$this->tbl_state} st ON st.id = n.i_province".
			" LEFT JOIN {$this->tbl_city} ct ON ct.id = n.i_city".
			" LEFT JOIN {$this->tbl_zip} z ON z.id = n.i_zipcode".           
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
				  $ret_["s_skype_id"]		=	get_unformatted_string($row->s_skype_id); 
				  $ret_["s_msn_id"]			=	get_unformatted_string($row->s_msn_id); 
				  $ret_["s_yahoo_id"]		=	get_unformatted_string($row->s_yahoo_id); 
				  $ret_["s_contact_no"]		=	get_unformatted_string($row->s_contact_no);

				  $ret_["s_lat"]			=	get_unformatted_string($row->s_lat); 
				  $ret_["s_lng"]			=	get_unformatted_string($row->s_lng); 
				  $ret_["opt_city"] 		= 	stripslashes($row->i_city); 
				  $ret_["opt_state"] 		= 	stripslashes($row->i_province); 
				  $ret_["opt_zip"] 			= 	stripslashes($row->i_zipcode); 
				  $ret_["s_state"]			=	get_unformatted_string($row->state); 
				  $ret_["s_city"]			=	get_unformatted_string($row->city); 
				  $ret_["s_postal_code"]	=	get_unformatted_string($row->postal_code);

				  
                  $ret_["dt_created_on"]	=	date($this->conf["site_date_format"],intval($row->i_created_date)); 
				  
				  $ret_["dt_last_login_on"]	=	$row->i_last_login_date?date($this->conf["last_log_date_format"],intval($row->i_last_login_date)):"not logged in yet"; 
				  
				  $ret_["i_verified"]		=	intval($row->s_verified); 
				  $ret_["s_verified"]		=	(intval($row->s_verified)==1?"Verified":"Not Verified");
				  $ret_["i_is_active"]		=	intval($row->i_is_active); 
				  $ret_["s_is_active"]		=	(intval($row->i_is_active)==1?"Active":"Inactive");
				  
				  $ret_["s_skills"]			=	get_unformatted_string($row->s_skills);
				  $ret_["s_about_me"]		=	get_unformatted_string($row->s_about_me);
				  $ret_["s_qualification"]	=	get_unformatted_string($row->s_qualification);
				  $ret_["s_website"]		=	get_unformatted_string($row->s_website);
				  $ret_["s_business_name"]	=	get_unformatted_string($row->s_business_name);
				  
				  $ret_["s_work_history"]	=	get_unformatted_string($row->s_work_history);				  
				  $ret_["i_job_radar_radius"]	=	intval($row->i_job_radar_radius);
				  
				  /* after chaging the payment type*/
				  //$ret_["i_payment_type"]	=	intval($row->i_payment_type);
				  //$ret_["s_payment_type"]	=	$this->db->PAYMENT_TYPE[intval($row->i_payment_type)];
				  $ret_["i_payment_type"]	=	($row->i_payment_type);
				  $diff_pay_type  =   $this->db->PAYMENT_TYPE;
				  $arr_pay_type_name =   array();
				  $arr_pay_type_id  = explode(',',$ret_["i_payment_type"]);
				  foreach($arr_pay_type_id as $val)
					{
						$arr_pay_type_name[]  =    $diff_pay_type[$val];      
					}
				  $ret_["s_payment_type"]	=	implode(', ',array_slice($arr_pay_type_name,0,-1));
				  if(count($arr_pay_type_name)>1)
				  {
				  	 $ret_["s_payment_type"] .= ' and ';
				  }
				  $ret_["s_payment_type"]	.= array_pop($arr_pay_type_name);
				  /* after chaging the payment type*/
				  
				  $ret_["i_like_travel"]	=	intval($row->i_like_travel);
				  $ret_["s_like_travel"]	=	(intval($row->i_like_travel)==1?"can":"cannot");
				  $ret_["i_phone_internet"]	=	intval($row->i_phone_internet);
				  $ret_["s_phone_internet"]	=	(intval($row->i_phone_internet)==1?"can":"cannot");
				  $ret_["s_user_image"]		=	get_unformatted_string($row->s_user_image);
				  $ret_["s_category_name"] 	= $this->get_tradesman_cat($row->id,$i_lang_id);
				  $ret_["i_category_id"]	=	stripslashes($row->i_category_id);
				  $ret_["f_positive_feedback_percentage"]	=	empty($row->f_positive_feedback_percentage)?0:doubleval($row->f_positive_feedback_percentage);
				  $ret_["i_jobs_won"]	=	empty($row->i_jobs_won)?0:intval($row->i_jobs_won);
				  $ret_["i_feedback_rating"]	=	empty($row->i_feedback_rating)?0:intval($row->i_feedback_rating);
				  $ret_["i_feedback_received"]	=	empty($row->i_feedback_received)?0:intval($row->i_feedback_received);
				  
				  $ret_["i_account_expire_date"]  = intval($row->i_account_expire_date); 
				  $ret_["dt_account_expire_date"] =	date($this->conf["site_date_format"],intval($row->i_account_expire_date)); 
				  
				  $ret_["i_verify_credentials"]	=	empty($row->i_verify_credentials)?0:intval($row->i_verify_credentials);
				  $ret_["i_verify_phone"]	=	empty($row->i_verify_phone)?0:intval($row->i_verify_phone);
				  $ret_["i_verify_facebook"]	=	empty($row->i_verify_facebook)?0:intval($row->i_verify_facebook);

		  
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
				if(isset($info["s_password"]) && !empty($info["s_password"]))
				{
					$s_password = md5(trim($info["s_password"]).$this->conf["security_salt"]);
					$s_qry.=", s_password= '".$s_password."' ";
				}
                $s_qry.=", s_name=? ";
				$s_qry.=", s_email=? ";
				$s_qry.=", s_skype_id=? ";
				$s_qry.=", s_msn_id=? ";
				$s_qry.=", s_yahoo_id=? ";
				$s_qry.=", s_contact_no=? ";
				$s_qry.=", s_address=? ";
				$s_qry.=", s_verification_code=? ";
				$s_qry.=", i_province=? ";
				$s_qry.=", i_city=? ";
				$s_qry.=", i_zipcode=? ";
				$s_qry.=", s_lat=? ";
				$s_qry.=", s_lng=? ";
				$s_qry.=", i_role=? ";
				
				//$s_qry.=", s_verified=? ";
                //$s_qry.=", i_is_active=? ";
                $s_qry.=", i_created_date=? ";
                
                $this->db->query($s_qry,array(
												  get_formatted_string($info["s_username"]),
												  get_formatted_string($info["s_name"]),
												  get_formatted_string($info["s_email"]),
												  get_formatted_string($info["s_skype_id"]),
												  get_formatted_string($info["s_msn_id"]),
												  get_formatted_string($info["s_yahoo_id"]),
												  trim(htmlspecialchars($info["s_contact_no"], ENT_QUOTES, 'utf-8')),
												  get_formatted_string($info["s_address"]),
												  trim(htmlspecialchars($info["s_verification_code"], ENT_QUOTES, 'utf-8')),
												  intval(decrypt($info["i_province"])),
												  intval(decrypt($info["i_city"])),
												  intval(decrypt($info["i_zipcode"])),
												  get_formatted_string($info["s_lat"]),
												  get_formatted_string($info["s_lng"]),
												  intval($info["i_role"]),
												  
												  //intval($info["s_verified"]),
												  //intval($info["i_is_active"]),
												  intval($info["i_created_date"])
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
					$this->insert_image($info,$i_ret_); 
					
					$this->insert_details($info,$i_ret_);
					
					$this->insert_newsletter_subscription($info,$i_ret_);
					
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  get_formatted_string($info["s_username"]),
												  get_formatted_string($info["s_name"]),
												  get_formatted_string($info["s_email"]),
												  get_formatted_string($info["s_skype_id"]),
												  get_formatted_string($info["s_msn_id"]),
												  get_formatted_string($info["s_yahoo_id"]),
												  trim(htmlspecialchars($info["s_contact_no"], ENT_QUOTES, 'utf-8')),
												  get_formatted_string($info["s_address"]),
												  trim(htmlspecialchars($info["s_verification_code"], ENT_QUOTES, 'utf-8')),
												  intval(decrypt($info["i_province"])),
												  intval(decrypt($info["i_city"])),
												  intval(decrypt($info["i_zipcode"])),
												  intval($info["i_role"]),
												  
												  //intval($info["s_verified"]),
												  //intval($info["i_is_active"]),
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
           $s_qry = "SELECT cat_c.s_name AS s_category_name FROM ".$this->tbl_tradesman_cat." tc 
			LEFT JOIN {$this->db->CATEGORYCHILD} cat_c ON cat_c.i_cat_id = tc.i_category_id WHERE tc.i_user_id =? 
			AND cat_c.i_lang_id =?";
          $rs = $this->db->query($s_qry, array(intval($id),intval($i_lang_id)) );
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
           $s_qry = "SELECT n.s_email,n.s_name FROM ".$this->tbl." n  Where n.id=".$id." ";
		   
          $rs = $this->db->query($s_qry, array(intval($id)) );
		  
		 if($rs->num_rows()>0)
          {
		  	$arr = array();
              foreach($rs->result() as $row)
              {
			  	$arr['s_email'] = get_unformatted_string($row->s_email);
				$arr['s_name'] = get_unformatted_string($row->s_name);
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
		 
		 
		 $mailContent	=	$CI->mod_auto->fetch_contact_us_content('job_invitation','tradesman');
		 $mail_subject = $mailContent['s_subject']; 
		 
		 $filename = $this->config->item('EMAILBODYHTML')."common.html";
		 $handle = @fopen($filename, "r");
		 $mail_html = @fread($handle, filesize($filename));	
		  //print_r($mailContent);
		 if(!empty($mailContent))
			{							
				$description = $mailContent["s_content"];
				$description = str_replace("[Buyer name]",$buyer_name,$description);	
				$description = str_replace("[service professional name]",$tradesman_name,$description);					
				//$description = str_replace("[Login to your account to view & quote on invited jobs]",'<a href="'.base_url().'user/registration'.'/'.'">click here to login</a>',$description); 
				$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);	
				$description = str_replace("[site_url]",base_url(),$description);
				$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
			}
		unset($mailContent);
						
		//echo "<br>DESC".$description;	exit;
		$mail_html = str_replace("[site url]",base_url(),$mail_html);	
		$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					
		 /// Mailing code...[start]
		$site_admin_email = $this->s_admin_email;
		$this->load->helper('mail');
		
		if($is_mail_need)
		{
			$tect = sendMail($to['email'],$mail_subject,$mail_html);
		}
		else
		{
			$tect = true;
		}
					
		 return $tect;
		
	}
	
    public function gettotal_verification_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(DISTINCT n.id) as i_total "
                ."From ".$this->db->TRADESMAN_VERIFICATION." n "
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
	
    public function gettotal_credential_file_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(DISTINCT n.id) as i_total "
                ."From ".$this->db->CREDENTIAL_FILE." n "
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
	
	
	
	
    public function __destruct()
    {}                 
  
  
}
///end of class
?>