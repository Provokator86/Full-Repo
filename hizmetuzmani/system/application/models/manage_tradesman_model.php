<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 27 April 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For User
* 
* @package Content Management
* @subpackage user
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/user.php
* @link views/admin/user/
*/


class Manage_tradesman_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
	private $tbl_city;
	private $tbl_zip;
	private $tbl_province;
	private $tbl_user_image;
	private $tbl_tradesman_detail;
	private $tbl_tradesman_cat;
	private $tbl_news_subscript;
	private $tbl_testimonial;
	private $tbl_automail_right;
	private $tbl_cat;
	private $tbl_lang;
	private $tbl_trades_album;
	private $tbl_work_place;
	private $tbl_tradesman_pay_unit;
	private $tbl_tradesman_pay_time;
	private $tbl_tradesman_work_days;

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
		  $this->tbl_news_subscript 	= $this->db->NEWSLETTERSUBCRIPTION;  
		  $this->tbl_testimonial 		= $this->db->TESTIMONIAL; 		  
		  $this->tbl_automail_right 	= $this->db->AUTOMAILRIGHT;
		  $this->tbl_lang 				= $this->db->LANGUAGE;
		  
		  $this->tbl_cat 				= $this->db->CATEGORY; 		  
		  $this->tbl_trades_album 		= $this->db->TRADESALBUM;
		  $this->tbl_work_place			= $this->db->TRADESMAN_WORKING_PLACE;
		  $this->tbl_tradesman_pay_unit	= $this->db->TRADESMAN_PAYMENT_TYPE;
		  $this->tbl_tradesman_pay_time	= $this->db->TRADESMAN_PAYMENT_TIME;
		  $this->tbl_tradesman_work_days= $this->db->TRADESMAN_WORKING_DAYS;
		  
          $this->conf =& get_config();
		  $this->s_lang_prefix	=   $this->session->userdata('lang_prefix');   // language prifix   
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
			$s_qry="SELECT n.id, n.s_username, n.s_name, n.s_email, n.s_skype_id, n.s_msn_id, n.s_yahoo_id, n.s_contact_no,
					n.s_address, n.i_created_date, n.i_is_active, s.province, c.city, z.postal_code					
					 FROM ".$this->tbl." n ".
					 " LEFT JOIN {$this->tbl_province} s ON s.id = n.i_province".
					 " LEFT JOIN {$this->tbl_city} c ON c.id = n.i_city".
					 " LEFT JOIN {$this->tbl_zip} z ON z.id = n.i_zipcode"
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
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
				  $ret_[$i_cnt]["s_province"]			=	get_unformatted_string($row->province); 
				  $ret_[$i_cnt]["s_city"]			=	get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["s_postal_code"]	=	get_unformatted_string($row->postal_code);
				  
                  $ret_[$i_cnt]["dt_created_on"]	=	date($this->conf["site_date_format"],intval($row->i_created_date)); 
				  $ret_[$i_cnt]["i_is_active"]		=	intval($row->i_is_active); 
				  $ret_[$i_cnt]["s_is_active"]		=	(intval($row->i_is_active)==1?"Active":"Inactive");
                  
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
    
	
	
	public function fetch_featured_latest($s_where=null,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {	
          	$ret_=array();
			$s_qry="SELECT DISTINCT f.i_receiver_user_id,n.id, n.s_username, n.s_name, n.s_email, n.s_skype_id, n.s_msn_id,
					 n.s_yahoo_id, n.s_contact_no,n.s_address, n.i_created_date, n.i_is_active, s.province, c.city, 
					 z.postal_code,td.s_about_me,td.i_feedback_rating,td.f_positive_feedback_percentage,
					 td.i_jobs_won,td.i_feedback_received,(SELECT COUNT(*) FROM quoteurjob_job_feedback m WHERE m.i_receiver_user_id  = f.i_receiver_user_id ) AS i_total,u.s_user_image 					
					 FROM {$this->db->JOBFEEDBACK} f LEFT JOIN  ".$this->tbl." n ON n.id = f.i_receiver_user_id ".
					 " LEFT JOIN {$this->tbl_province} s ON s.id = n.i_province".
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
				  $ret_[$i_cnt]["s_province"]			=	get_unformatted_string($row->province); 
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
 			$s_qry="Select lang.s_short_name AS s_lang_prefix,s.s_about_me,s.i_type,s_gsm_no,s.s_taxoffice_name,					 			s.s_business_name,s.s_firm_name,s.s_firm_phone,s.s_tax_no,s.i_work_place,s.s_keyword,s.s_ssn,
			s.s_address_file, n.*,c.city  AS s_city_name,st.province, z.postal_code From ".$this->tbl." AS n ".
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
                  $ret_["s_username"]        	=    get_unformatted_string($row->s_username); 
                  $ret_["s_name"]            	=    get_unformatted_string($row->s_name); 
                  $ret_["s_email"]            	=    get_unformatted_string($row->s_email); 
				  $ret_["s_image"]            	=    get_unformatted_string($row->s_image); 
                  $ret_["s_address"]        	=    get_unformatted_string($row->s_address);
				  $ret_["s_address2"]        	=    get_unformatted_string($row->s_address2);                 
				 // social media datas fetch 
				  $ret_["i_sm"]        			=    intval($row->i_sm);
				  $ret_["s_type_sm"]        	=    intval($row->i_sm)?$this->db->SOCIALMEDIA[intval($row->i_sm)]:"";
				  $ret_["s_sm"]        			=    get_unformatted_string($row->s_sm); 
				  $ret_["i_sm2"]        		=    intval($row->i_sm2);
				  $ret_["s_sm2"]        		=    get_unformatted_string($row->s_sm2);
				  $ret_["i_sm3"]        		=    intval($row->i_sm3);
				  $ret_["s_sm3"]        		=    get_unformatted_string($row->s_sm3);
				  
                  $ret_["s_contact_no"]        	=    get_unformatted_string($row->s_contact_no);
                  $ret_["s_lat"]            	=    get_unformatted_string($row->s_lat); 
                  $ret_["s_lng"]            	=    get_unformatted_string($row->s_lng); 
                  $ret_["opt_city"]         	=    stripslashes($row->i_city); 
                  $ret_["opt_province"]         =    stripslashes($row->i_province); 
                  $ret_["opt_zip"]             	=    stripslashes($row->i_zipcode); 
                  $ret_["chk_newsletter"]       =    intval($row->i_inform_news);                   
                  $ret_["i_signup_lang"]        =    intval($row->i_signup_lang); 
				  $ret_["s_lang_prefix"]		=	 get_unformatted_string($row->s_lang_prefix);
				  
                  $ret_["s_province"]           =    get_unformatted_string($row->province); 
                  $ret_["s_city_name"]        	=    get_unformatted_string($row->s_city_name);
                  $ret_["s_postal_code"]    	=    get_unformatted_string($row->postal_code);
                  
                  $ret_["dt_created_on"]    	=    date($this->conf["site_date_format"],intval($row->i_created_date)); 
                  $ret_["i_verified"]        	=    intval($row->s_verified); 
                  $ret_["s_verified"]        	=    (intval($row->s_verified)==1?"Verified":"Not Verified");
                  $ret_["i_is_active"]        	=    intval($row->i_is_active); 
                  $ret_["s_is_active"]        	=    (intval($row->i_is_active)==1?"Active":"Inactive");                  
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
                  //$ret_["s_user_image"]       	=    get_unformatted_string($row->s_user_image);
				  
                  $ret_["f_positive_feedback_percentage"]    =    empty($row->f_positive_feedback_percentage)?0:doubleval($row->f_positive_feedback_percentage);
                  $ret_["i_jobs_won"]    		=    empty($row->i_jobs_won)?0:intval($row->i_jobs_won);
                  $ret_["i_feedback_received"]  =    empty($row->i_feedback_received)?0:intval($row->i_feedback_received);                  
				  // fetch other details 
				  $s_wh = " WHERE n.i_user_id = ".$ret_["id"]." ";
				  $ret_["category"]			=	$this->fetch_all_category($s_wh);
				  $ret_["workplace"]		=	$this->fetch_all_work_place($s_wh);
				  $ret_["payment_unit"]		=	$this->fetch_tradesmen_payment_unit($s_wh);
				  
				  
          
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
				$s_qry.=", i_sm=? ";
				$s_qry.=", s_sm=? ";
				//$s_qry.=", s_skype_id=? ";
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
												  //get_formatted_string($info["s_skype_id"]),
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
												  //get_formatted_string($info["s_skype_id"]),
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
            $i_ret_=0;////Returns false
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
                $s_qry.=", i_created_date=? ";
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
												  intval($info["i_created_date"]),
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
												  intval($info["i_created_date"]),
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
                  $ret_[$i_cnt]["id"]				=	$row->id;////always integer
                  $ret_[$i_cnt]['s_work_place']		=	get_unformatted_string($row->s_work_place); 
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
                  $ret_[$i_cnt]["id"]				=	$row->i_id;////always integer
                  $ret_[$i_cnt]['s_payment_unit']	=	get_unformatted_string($row->s_payment_unit); 
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
                  $ret_[$i_cnt]["id"]				=	$row->i_id;////always integer
                  $ret_[$i_cnt]['s_pay_time']		=	get_unformatted_string($row->s_pay_time); 
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
		  		."LEFT JOIN ".$this->tbl_cat." AS c ON n.i_category_id = c.i_id	"           
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );            
			//echo $s_qry;     
          $rs=$this->db->query($s_qry); 
           $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {				 
                  $ret_[$i_cnt]["id"]				=	$row->category_id;////always integer
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

	
	
	
	
	

	
	

	
	
	public function insert_profile_image($info,$id)
	{
		try
		{
			//print_r($info); exit;
			$i_ret_=0;////Returns false
			if(!empty($info))
			{
				if($info['s_user_image'] !='')
				{
					$s_qry="Insert Into ".$this->tbl_user_image." Set ";
                	$s_qry.=" i_user_id=? ";
					$s_qry.=", s_user_image=? ";
					
					$this->db->query($s_qry,array(
													intval($id),
													get_formatted_string($info['s_user_image'])
												));
												
					$i_ret_=$this->db->insert_id(); 
					if($i_ret_)
					{
						 $logi["msg"]="Inserting into ".$this->tbl_user_image." ";
                    	$logi["sql"]= serialize(array($s_qry,array(
													intval($id),
													get_formatted_string($info['s_user_image'])
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
	
	
	public function update_multiple_category($info,$id)
	{
		try
		{
			//print_r($info); exit;
			$i_ret_=0;////Returns false
			if(!empty($info))
			{
				if($info!='')
				{
					$this->delete_previous_category($id); 
					
					foreach($info as $val)
					{
					 if($val!=''){
					$s_qry="Insert Into ".$this->tbl_tradesman_cat." Set ";                	
					$s_qry.=" i_category_id=? ";
					$s_qry.=" ,i_user_id=? ";
					
					$this->db->query($s_qry,array(													
													intval($val),
													intval($id)
												));
												
					}
					}							
												
					$i_ret_=$this->db->insert_id(); 
					if($i_ret_)
					{
						 $logi["msg"]="Updating  ".$this->tbl_tradesman_cat." ";
                    	$logi["sql"]= serialize(array($s_qry,array(													
													intval($val),
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
	
	/* delete previous category setting */
	public function delete_previous_category($i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
    
            if(intval($i_id)>0)
            {
				$s_qry="DELETE FROM ".$this->tbl_tradesman_cat." ";
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
				$s_qry="DELETE FROM ".$this->tbl_tradesman_cat." ";
                $this->db->query($s_qry);
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Deleting all information from ".$this->tbl_tradesman_cat." ";
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
	
	
	
	
	
	
	
	/* tradesman album */
	
	
	
	
	
	
	
	public function delete_profile_image($s_where='')
	{
		$s_qry="DELETE FROM ".$this->tbl_user_image." ".$s_where;
		$this->db->query($s_qry);
		//echo $this->db->last_query(); exit;
		$i_ret_=$this->db->affected_rows(); 
		if($i_ret_)
		{
			return true;
		}
		return false;
	}
	
	public function delete_album_photo($i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
    
            if(intval($i_id)>0)
            {
				$s_qry="DELETE FROM ".$this->tbl_trades_album." ";
                $s_qry.=" Where id=? ";
                $this->db->query($s_qry, array(intval($i_id)) );
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Deleting ".$this->tbl_trades_album." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($i_id))) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                           
            }
            elseif(intval($i_id)==-1)////Deleting All
            {
				$s_qry="DELETE FROM ".$this->tbl_trades_album." ";
                $this->db->query($s_qry);
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Deleting all information from ".$this->tbl_trades_album." ";
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
	
	
	
	

	
	
	/*
	* recursive function to create city as tree structure
	*/
	
    function get_city_selectlist($id='')
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select id,city "
                ."From ".$this->tbl_city." AS n "
                ." Where n.province_id=?";
                
          $res=$this->db->query($s_qry,array(intval($id))); 
		  $mix_value = $res->result_array();
		  if($mix_value)
			{
				foreach ($mix_value as $val)
				{
					$s_select = '';
					if($val["id"] == $s_id)
						$s_select = " selected ";
						
					$s_option .= "<option $s_select value='".encrypt($val["id"])."' >".$val["city"]."</option>";
				}
			}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
          
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	
	
	function get_zip_selectlist($state_id='',$city_id='')
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select n.id,n.postal_code "
                ."From ".$this->tbl_zip." AS n "
                ." Where n.province_id=?"
				." And n.city_id=?";
                
          $res=$this->db->query($s_qry,array(intval($state_id),intval($city_id))); 
		  $mix_value = $res->result_array();
		  if($mix_value)
			{
				foreach ($mix_value as $val)
				{
					$s_select = '';
					if($val["id"] == $s_id)
						$s_select = " selected ";
						
					$s_option .= "<option $s_select value='".encrypt($val["id"])."' >".$val["postal_code"]."</option>";
				}
			}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
          
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	public function change_status($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";
				$s_qry.=" i_is_active= ? ";
                $s_qry.=" Where id=? ";
                //echo $i_id.$info['i_is_active'];
                $this->db->query($s_qry,array(	intval($info['i_is_active']),
												  intval($i_id)
                                                     ));
                $i_ret_=$this->db->affected_rows();   
				
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(	intval($info['i_is_active']),
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
	
	
	/* deactivate account and reactivate account mail */
	function account_activate_deactivate($user_id,$info)
	{
		try
		{//echo $user_id; exit;
			if($info)
			{		
					$details = $this->fetch_this($user_id);
					
					global $CI;				
					$CI->load->model('auto_mail_model');					
					
					if($info['i_is_active']==0)
					{
					 $content= $CI->auto_mail_model->fetch_mail_content('account_deactivate','general',$details['s_lang_prefix']);
					 $filename = $this->config->item('EMAILBODYHTML')."common.html";
					 $handle = @fopen($filename, "r");
					 $mail_html = @fread($handle, filesize($filename));
					}
					else if($info['i_is_active']==1)
					{
					 $content= $CI->auto_mail_model->fetch_mail_content('account_reactivate','general',$details['s_lang_prefix']);
					 $filename = $this->config->item('EMAILBODYHTML')."common.html";
					 $handle = @fopen($filename, "r");
					 $mail_html = @fread($handle, filesize($filename));
					}
					//print_r($content); exit;
					if(!empty($content))
					{			
						$description = $content["s_content"];
						$description = str_replace("[username]",$details['s_username'],$description);								
						$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
					}
					//unset($content);
					
					$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					//echo "<br>DESC".$description;	exit;
					/// Mailing code...[start]
					$site_admin_email = $this->s_admin_email;
					$subject = $content['s_subject'];
					unset($content);
					$this->load->helper('mail');
					$tect = sendMail($details['s_email'],$subject,$mail_html);			
				
				
					return $tect;
				
			}			
			
			else
			{
				return true;
			}
			
			
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	} 
	
    function get_all_tradesman_won_job()
    {
        $ret_=array();
        $s_qry = "SELECT count( id ) tot_won_job , i_tradesman_id
                        FROM quoteurjob_jobs
                        WHERE i_status
                            IN ( 4, 11, 9, 6, 5 )
                            AND i_tradesman_id !=0
                        GROUP BY i_tradesman_id";
                        
      $rs=$this->db->query($s_qry);
      $i_cnt=0;
      if($rs->num_rows()>0)
      {
          foreach($rs->result() as $row)
          {
              $ret_[$i_cnt]["tot_won_job"]=$row->tot_won_job;
              $ret_[$i_cnt]["i_tradesman_id"]=$row->i_tradesman_id;          
              $i_cnt++;
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