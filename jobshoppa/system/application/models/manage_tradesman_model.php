<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 21 Sep 2011
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
		  $this->tbl_news_subscript = $this->db->NEWSLETTERSUBCRIPTION;  
		  $this->tbl_testimonial = $this->db->TESTIMONIAL; 		  
		  $this->tbl_automail_right = $this->db->AUTOMAILRIGHT;
		  
		  $this->tbl_cat = $this->db->CATEGORY; 
		  
		  $this->tbl_trades_album = $this->db->TRADESALBUM;
		  
		  $this->tbl_trades_ver = $this->db->TRADESMAN_VERIFICATION;
		  $this->tbl_cred_file = $this->db->CREDENTIAL_FILE;
		  
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
			$s_qry="SELECT n.id, n.s_username, n.s_name, n.s_email, n.s_skype_id, n.s_msn_id, n.s_yahoo_id, n.s_contact_no,
					n.s_address, n.i_created_date, n.i_is_active, n.i_account_expire_date,
					s.state, c.city, z.postal_code					
					 FROM ".$this->tbl." n ".
					 " LEFT JOIN {$this->tbl_state} s ON s.id = n.i_province".
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
				  $ret_[$i_cnt]["s_state"]			=	get_unformatted_string($row->state); 
				  $ret_[$i_cnt]["s_city"]			=	get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["s_postal_code"]	=	get_unformatted_string($row->postal_code);
				  
				  $ret_[$i_cnt]["i_account_expire_date"]	=	intval($row->i_account_expire_date);
				  $ret_[$i_cnt]["dt_account_expire_date"]=date($this->conf["site_date_format"],intval($row->i_account_expire_date));
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
					n.s_address, n.i_created_date, n.i_is_active, s.state, c.city, z.postal_code					
					 FROM ".$this->tbl." n ".
					 " LEFT JOIN {$this->tbl_state} s ON s.id = n.i_province".
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
	
	
	/* verification list */
	public function fetch_multi_verification_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {	
          	$ret_=array();
			$s_qry="SELECT tradesman.s_username,tradesman.s_name,tradesman.s_email,tradesman.s_contact_no,
					td.i_verify_credentials,td.i_verify_phone,td.i_verify_facebook ,n.* FROM ".$this->tbl_trades_ver." n ".
					 " LEFT JOIN {$this->tbl_tradesman_detail} td ON td.i_user_id = n.i_user_id".
					 //" INNER JOIN {$this->tbl_cred_file} cred ON cred.i_user_id = n.i_user_id".
					 " LEFT JOIN {$this->tbl} tradesman ON tradesman.id = n.i_user_id"
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
				  $ret_[$i_cnt]["i_user_id"]=$row->i_user_id;
                  $ret_[$i_cnt]["s_username"]		=	get_unformatted_string($row->s_username); 
				  $ret_[$i_cnt]["s_name"]			=	get_unformatted_string($row->s_name); 
				  $ret_[$i_cnt]["s_email"]			=	get_unformatted_string($row->s_email); 
				  
				  $ret_[$i_cnt]["s_contact_no"]		=	get_unformatted_string($row->s_contact_no); 
				  $ret_[$i_cnt]["s_address"]		=	get_unformatted_string($row->s_address);
				  
                 
				  $ret_[$i_cnt]["dt_created_on"]	=	date($this->conf["site_date_format"],intval($row->i_created_on));
				  $ret_[$i_cnt]["i_verifcation_status"]	=	intval($row->i_verifcation_status);
				  $ret_[$i_cnt]["s_verify_status"]	=	$this->db->VERIFICATIONSTATUS[$row->i_verifcation_status];
				  $ret_[$i_cnt]["i_verify_type"]	=	intval($row->i_verification_type);
				  $ret_[$i_cnt]["s_verify_type"]	=	$this->db->VERIFICATIONTYPE[$row->i_verification_type];
				  
				  $ret_[$i_cnt]["i_verify_credentials"]	=	empty($row->i_verify_credentials)?0:intval($row->i_verify_credentials);
				  $ret_[$i_cnt]["i_verify_phone"]		=	empty($row->i_verify_phone)?0:intval($row->i_verify_phone);
				  $ret_[$i_cnt]["i_verify_facebook"]	=	empty($row->i_verify_facebook)?0:intval($row->i_verify_facebook);
				  if($row->i_verification_type==1)
				  {
				  $ret_[$i_cnt]["cred_files"]			=	$this->get_cred_files($row->i_user_id);
				  }
                  
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
	
	
	public function fetch_this_verification($i_id)
    {
        try
        {	
          	$ret_=array();
			$s_qry="SELECT tradesman.s_username,tradesman.s_name,tradesman.s_email,tradesman.s_contact_no,
					td.i_verify_credentials,td.i_verify_phone,td.i_verify_facebook ,n.* FROM ".$this->tbl_trades_ver." n ".
					 " LEFT JOIN {$this->tbl_tradesman_detail} td ON td.i_user_id = n.i_user_id".
					 //" INNER JOIN {$this->tbl_cred_file} cred ON cred.i_user_id = n.i_user_id".
					 " LEFT JOIN {$this->tbl} tradesman ON tradesman.id = n.i_user_id
					  Where n.id=? ";
                
          //$rs=$this->db->query($s_qry);
		   $rs=$this->db->query($s_qry,array(intval($i_id))); 
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_["id"]=$row->id;////always integer
                  $ret_["s_username"]		=	get_unformatted_string($row->s_username); 
				  $ret_["s_name"]			=	get_unformatted_string($row->s_name); 
				  $ret_["s_email"]			=	get_unformatted_string($row->s_email); 
				  
				  $ret_["s_contact_no"]		=	get_unformatted_string($row->s_contact_no); 
				  $ret_["s_address"]		=	get_unformatted_string($row->s_address);
				  
                 
				  $ret_["dt_created_on"]	=	date($this->conf["site_date_format"],intval($row->i_created_on));
				  $ret_["i_verifcation_status"]	=	intval($row->i_verifcation_status);
				  $ret_["s_verify_status"]	=	$this->db->VERIFICATIONSTATUS[$row->i_verifcation_status];
				  $ret_["s_verify_type"]	=	$this->db->VERIFICATIONTYPE[$row->i_verification_type];
				  
				  $ret_["i_verify_credentials"]	=	empty($row->i_verify_credentials)?0:intval($row->i_verify_credentials);
				  $ret_["i_verify_phone"]		=	empty($row->i_verify_phone)?0:intval($row->i_verify_phone);
				  $ret_["i_verify_facebook"]	=	empty($row->i_verify_facebook)?0:intval($row->i_verify_facebook);
				  if($row->i_verification_type==1)
				  {
				  $ret_[$i_cnt]["cred_files"]			=	$this->get_cred_files($row->i_user_id);
				  }
                  
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
	
	
	function get_cred_files($i_id)
	{
		
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select n.id,n.s_file_name AS s_file_name "
                ."From ".$this->tbl_cred_file." AS n "
                ." Where n.i_user_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
		  $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_[$i_cnt]["id"]				=	$row->id;////always integer		 
                  $ret_[$i_cnt]["s_file_name"]		=	stripslashes(htmlspecialchars_decode($row->s_file_name)); 	
				  
				  $i_cnt++;	  
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
	
	
	
	public function gettotal_verification_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl_trades_ver." n "
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
          $s_qry="Select s.s_skills,s.s_about_me,s.s_qualification,s.s_website,s.s_business_name,s.i_payment_type,s.i_like_travel,s.s_work_history,s.i_verify_credentials,s.i_verify_phone,s.i_verify_facebook,u.s_user_image, n.*,c.city s_city_name,st.state, z.postal_code From ".$this->tbl." AS n ".
		  	" LEFT JOIN {$this->tbl_tradesman_detail} s ON s.i_user_id = n.id".
			" LEFT JOIN {$this->tbl_user_image} u ON u.i_user_id = n.id".   
			" LEFT JOIN {$this->tbl_state} st ON st.id = n.i_province".
			" LEFT JOIN {$this->tbl_city} c ON c.id = n.i_city".
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
				  $ret_["s_city_name"]		=	get_unformatted_string($row->s_city_name);
				  $ret_["s_skype_id"]		=	get_unformatted_string($row->s_skype_id); 
				  $ret_["s_msn_id"]			=	get_unformatted_string($row->s_msn_id); 
				  $ret_["s_yahoo_id"]		=	get_unformatted_string($row->s_yahoo_id); 
				  $ret_["s_contact_no"]		=	get_unformatted_string($row->s_contact_no);
                  $ret_["s_fax"]            =    get_unformatted_string($row->s_fax);
                  $ret_["s_landline"]       =    get_unformatted_string($row->s_landline);
				  $ret_["s_lat"]			=	get_unformatted_string($row->s_lat); 
				  $ret_["s_lng"]			=	get_unformatted_string($row->s_lng); 
				  $ret_["opt_city"] 		= 	stripslashes($row->i_city); 
				  $ret_["opt_state"] 		= 	stripslashes($row->i_province); 
				  $ret_["opt_zip"] 			= 	stripslashes($row->i_zipcode); 
				  $ret_["i_dob"]           =    date('d/m/Y',intval($row->i_dob));
				  $ret_["s_state"]			=	get_unformatted_string($row->state); 
				 // $ret_["s_city"]			=	get_unformatted_string($row->city); 
				  $ret_["s_postal_code"]	=	get_unformatted_string($row->postal_code);

				  
                  $ret_["dt_created_on"]	=	date($this->conf["site_date_format"],intval($row->i_created_date)); 
				  $ret_["i_verified"]		=	intval($row->s_verified); 
				  $ret_["s_verified"]		=	(intval($row->s_verified)==1?"Verified":"Not Verified");
				  $ret_["i_is_active"]		=	intval($row->i_is_active); 
				  $ret_["s_is_active"]		=	(intval($row->i_is_active)==1?"Active":"Inactive");
				  
				  $ret_["s_skills"]			=	get_unformatted_string($row->s_skills);
				  $ret_["s_about_me"]		=	get_unformatted_string($row->s_about_me);
				  $ret_["s_qualification"]	=	get_unformatted_string($row->s_qualification);
				  $ret_["s_website"]		=	get_unformatted_string($row->s_website);
				  $ret_["s_business_name"]	=	get_unformatted_string($row->s_business_name);
				  $ret_["i_payment_type"]	=	($row->i_payment_type);
				  $ret_["i_like_travel"]	=	intval($row->i_like_travel);
				  
				  $ret_["s_user_image"]		=	get_unformatted_string($row->s_user_image);
				  $ret_["f_positive_feedback_percentage"]	=	empty($row->f_positive_feedback_percentage)?0:doubleval($row->f_positive_feedback_percentage);
				  $ret_["i_jobs_won"]	    =	empty($row->i_jobs_won)?0:intval($row->i_jobs_won);
				  $ret_["i_feedback_received"]	=	empty($row->i_feedback_received)?0:intval($row->i_feedback_received);
                  $ret_["s_work_history"]    =    get_unformatted_string($row->s_work_history);  
				  //$ret_["i_category_id"]	=	stripslashes($row->i_category_id);
				  $ret_["i_verify_credentials"]	=	empty($row->i_verify_credentials)?0:intval($row->i_verify_credentials);
				  $ret_["i_verify_phone"]		=	empty($row->i_verify_phone)?0:intval($row->i_verify_phone);
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
			//pr($info); exit;
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
				$s_qry.=", i_inform_news=? ";
                $s_qry.=", i_created_date=? ";
                $s_qry.=", s_fax=? ";
                $s_qry.=", s_landline=? "; 
                $s_qry.=", i_dob=? ";
				$s_qry.=", i_facebook_login=? ";
				$s_qry.=", s_facebook_email=? ";

                
                
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
												  intval($info["i_inform_news"]),
												  intval($info["i_created_date"]),
                                                  get_formatted_string($info["s_fax"]),
                                                  get_formatted_string($info["s_landline"]),
                                                  get_formatted_string($info["i_dob"]),
												  intval($info["i_facebook_login"]),
												  get_formatted_string($info["s_facebook_email"])


												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
					$this->insert_image($info,$i_ret_); 
					
					$this->insert_details($info,$i_ret_);
					
					//$this->insert_newsletter_subscription($info,$i_ret_);
					
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
												  get_formatted_string($info["s_lat"]),
												  get_formatted_string($info["s_lng"]),
												  intval($info["i_role"]),
												  
												  //intval($info["s_verified"]),
												  //intval($info["i_is_active"]),
												  intval($info["i_inform_news"]),
												  intval($info["i_created_date"]),
                                                  get_formatted_string($info["s_fax"]),
                                                  get_formatted_string($info["s_landline"]),
                                                  get_formatted_string($info["i_dob"]),
												  intval($info["i_facebook_login"]),
												  get_formatted_string($info["s_facebook_email"]),


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
	public function insert_image($info,$id)
	{
		try
		{
			//print_r($info); exit;
			$i_ret_=0;////Returns false
			if(!empty($info))
			{
				if($info['s_image'] !='')
				{
					$s_qry="Insert Into ".$this->tbl_user_image." Set ";
                	$s_qry.=" i_user_id=? ";
					$s_qry.=", s_user_image=? ";
					
					$this->db->query($s_qry,array(
													intval($id),
													get_formatted_string($info['s_image'])
												));
												
					$i_ret_=$this->db->insert_id(); 
					if($i_ret_)
					{
						 $logi["msg"]="Inserting into ".$this->tbl_user_image." ";
                    	$logi["sql"]= serialize(array($s_qry,array(
													intval($id),
													get_formatted_string($info['s_image'])
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
					$s_qry.=", s_skills=? ";
					$s_qry.=", s_about_me=? ";
					$s_qry.=", s_qualification=? ";
					$s_qry.=", s_website=? ";
					$s_qry.=", s_business_name=? ";
					$s_qry.=", i_payment_type=? ";
					$s_qry.=", i_like_travel=? ";
					$s_qry.=", i_phone_internet=? ";
					$s_qry.=", i_job_radar_radius=? ";
					$s_qry.=", i_verify_facebook=? ";

					
					$this->db->query($s_qry,array(
													intval($id),
													get_formatted_string($info['s_skills']),
													get_formatted_string($info['s_about_me']),
													get_formatted_string($info['s_qualification']),
													get_formatted_string($info['s_website']),
													get_formatted_string($info['s_business']),
													get_formatted_string($info['payment_type']),
													intval($info['s_like_travel']),
													intval($info['i_phone_internet']),
													intval($info['i_radius']),
													intval($info['i_verify_facebook']),
                                                    
												));
												
					$i_ret_=$this->db->insert_id(); 
					if($i_ret_)
					{
						 $logi["msg"]="Inserting into ".$this->tbl_tradesman_detail." ";
                    	$logi["sql"]= serialize(array($s_qry,array(
													intval($id),
													get_formatted_string($info['s_skills']),
													get_formatted_string($info['s_about_me']),
													get_formatted_string($info['s_qualification']),
													get_formatted_string($info['s_website']),
													get_formatted_string($info['s_business']),
													intval($info['payment_type']),
													intval($info['s_like_travel']),
													intval($info['i_phone_internet']),
													intval($info['i_radius']),
													intval($info['i_verify_facebook']),
                                                    
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
	
	
	
	
	/* tradesman details insert into database*/
	public function update_profile_details($info,$id)
	{
		try
		{
			
			$i_ret_=0;////Returns false
			if(!empty($info))
			{
				
					$s_qry=" Update ".$this->tbl_tradesman_detail." Set ";
                	//$s_qry.=" i_user_id=? ";
					//$s_qry.=" s_skills=? ";
					$s_qry.=" s_about_me=? ";
					//$s_qry.=", s_qualification=? ";
					$s_qry.=", s_website=? ";
					$s_qry.=", s_business_name=? ";
					$s_qry.=", i_payment_type=? ";
					//$s_qry.=", i_like_travel=? ";
                    $s_qry.=", s_work_history=? ";
					 $s_qry.=" Where i_user_id=? ";
					
					$this->db->query($s_qry,array(
													//intval($id),
													//get_formatted_string($info['s_skills']),
													get_formatted_string($info['s_about_me']),
													//get_formatted_string($info['s_qualification']),
													get_formatted_string($info['s_website']),
													get_formatted_string($info['s_business']),
													get_formatted_string($info['payment_type']),
													//intval($info['s_like_travel']),
                                                    get_formatted_string($info['s_work_history'])  ,
													intval($id)
												));
												
					$i_ret_=$this->db->affected_rows(); 
					if($i_ret_)
					{
						 $logi["msg"]="Inserting into ".$this->tbl_tradesman_detail." ";
                    	$logi["sql"]= serialize(array($s_qry,array(
													//intval($id),
													//get_formatted_string($info['s_skills']),
													get_formatted_string($info['s_about_me']),
													//get_formatted_string($info['s_qualification']),
													get_formatted_string($info['s_website']),
													get_formatted_string($info['s_business']),
													get_formatted_string($info['payment_type']),
													//intval($info['s_like_travel']),
                                                    get_formatted_string($info['s_work_history'])  ,
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
	
	
	
	/* tradesman multiple category insert into database*/
	public function insert_multiple_category($info,$id)
	{
		try
		{
			//print_r($info); exit;
			$i_ret_=0;////Returns false
			if(!empty($info))
			{

					foreach($info as $val)
					{
					$s_qry="Insert Into ".$this->tbl_tradesman_cat." Set ";
                	$s_qry.=" i_user_id=? ";
					$s_qry.=", i_category_id=? ";
					
					$this->db->query($s_qry,array(
													intval($id),
													intval($val)
												));
					}							
												
					$i_ret_=$this->db->insert_id(); 
					if($i_ret_)
					{
					    $logi["msg"]="Inserting into ".$this->tbl_tradesman_cat." ";
                    	$logi["sql"]= serialize(array($s_qry,array(
													intval($id),
													intval($val)
												)) ) ; 
						$this->log_info($logi); 
                    	unset($logi,$logindata);						
					}								
				                     
			}
            else
                $i_ret_ = true;   
			unset($s_qry, $info );
            return $i_ret_;
		}
		catch(Exception $err_obj)
		{	
			show_error($err_obj->getMessage());
		}
	}
	
	
	    
		
	/* newsletter subscriber insert into database*/
	public function insert_newsletter_subscription($info,$id)
	{
		try
		{
			//print_r($info); exit;
			$i_ret_=0;////Returns false
			if(!empty($info))
			{
				if($info['i_inform_news'] ==1)
				{
					$s_qry="Insert Into ".$this->tbl_news_subscript." Set ";
                	$s_qry.=" i_user_id=? ";
					$s_qry.=", i_user_type=? ";
					$s_qry.=", s_email=? ";
					$s_qry.=", s_name=? ";
					
					$this->db->query($s_qry,array(
													intval($id),
													intval($info['i_role']),
													get_formatted_string($info['s_email']),
													get_formatted_string($info['s_name'])
												));
												
					$i_ret_=$this->db->insert_id(); 
					if($i_ret_)
					{
						 $logi["msg"]="Inserting into ".$this->tbl_news_subscript." ";
                    	$logi["sql"]= serialize(array($s_qry,array(
													intval($id),
													intval($info['i_role']),
													get_formatted_string($info['s_email']),
													get_formatted_string($info['s_name'])
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
				$s_qry.=", s_skype_id=? ";
				$s_qry.=", s_msn_id=? ";
				$s_qry.=", s_yahoo_id=? ";
				$s_qry.=", s_contact_no=? ";
				$s_qry.=", i_province=? ";
				$s_qry.=", i_city=? ";
				$s_qry.=", i_zipcode=? ";
				//$s_qry.=", s_lat=? ";
				//$s_qry.=", s_lng=? ";
				$s_qry.=", i_role=? ";
				
				$s_qry.=", s_verified=? ";
                $s_qry.=", i_is_active=? ";
                $s_qry.=", i_edited_date=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(
												  get_formatted_string($info["s_username"]),
												  get_formatted_string($info["s_name"]),
												  get_formatted_string($info["s_email"]),
												  get_formatted_string($info["s_skype_id"]),
												  get_formatted_string($info["s_msn_id"]),
												  get_formatted_string($info["s_yahoo_id"]),
												  get_formatted_string($info["s_contact_no"]),
												  intval(decrypt($info["i_province"])),
												  intval(decrypt($info["i_city"])),
												  intval(decrypt($info["i_zipcode"])),
												  //get_formatted_string($info["s_lat"]),
												  //get_formatted_string($info["s_lng"]),
												  intval($info["i_role"]),
												  
												  intval($info["s_verified"]),
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
												  get_formatted_string($info["s_skype_id"]),
												  get_formatted_string($info["s_msn_id"]),
												  get_formatted_string($info["s_yahoo_id"]),
												  get_formatted_string($info["s_contact_no"]),
												  intval(decrypt($info["i_province"])),
												  intval(decrypt($info["i_city"])),
												  intval(decrypt($info["i_zipcode"])),
												  //get_formatted_string($info["s_lat"]),
												  //get_formatted_string($info["s_lng"]),
												  intval($info["i_role"]),
												  
												  intval($info["s_verified"]),
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
						//$this->delete_previous_setting($i_id); 
						
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
				 
                  //$ret_[$i_cnt]["id"]		=$row->id;////always integer
                  $ret_[]	=	get_unformatted_string($row->mail_key); 
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
	
	/* fetch all category for tradesman */
 public function fetch_all_category($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
			
		  	
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select c.id,c.s_category_name,n.i_user_id From ".$this->tbl_tradesman_cat." AS n "  
		  		."LEFT JOIN ".$this->db->CATEGORY." AS c ON n.i_category_id = c.id	"           
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            
			//echo $s_qry;     
          $rs=$this->db->query($s_qry); 
           $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				 
                  $ret_[$i_cnt]["id"]				=	$row->id;////always integer
                  $ret_[$i_cnt]['s_category_name']	=	get_unformatted_string($row->s_category_name); 
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
          
		 
		          /////Added the salt value with the password///		  
		 
		  
		  
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
                  $ret_["i_is_active"]=intval($row->i_is_active); 
                  $ret_["s_is_active"]=(intval($row->i_is_active)==1?"Active":"Inactive");                   
                 
                  //////////log report///
                    $logi["msg"]="Logged in as ".$ret_["s_name"]
                                ."[".$ret_["s_user_name"]."] at ".date("Y-M-d H:i:s") ;
                    //$logi["sql"]= serialize(array($s_qry) ) ;
                    //$logi["user_id"]=$ret_["id"];///Loggedin User Id                                 
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
													intval($info['i_created_date'])
												));
												
					$i_ret_=$this->db->insert_id(); 
					if($i_ret_)
					{
						 $logi["msg"]="Inserting into ".$this->tbl_testimonial." ";
                    	$logi["sql"]= serialize(array($s_qry,array(
													get_formatted_string($user_name),
													get_formatted_string($info['s_content']),
													intval($info['i_created_date'])
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
	
	
	
	
	
	
	public function set_contact_details($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";
				$s_qry.=" s_skype_id=? ";
				$s_qry.=", s_msn_id=? ";
				$s_qry.=", s_yahoo_id=? ";
				$s_qry.=", s_contact_no=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(
												 
												  get_formatted_string($info["s_skype_id"]),
												  get_formatted_string($info["s_msn_id"]),
												  get_formatted_string($info["s_yahoo_id"]),
												  trim(htmlspecialchars($info["s_contact_no"], ENT_QUOTES, 'utf-8')),
												  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												 
												  get_formatted_string($info["s_skype_id"]),
												  get_formatted_string($info["s_msn_id"]),
												  get_formatted_string($info["s_yahoo_id"]),
												  trim(htmlspecialchars($info["s_contact_no"], ENT_QUOTES, 'utf-8')),
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
	
	
	public function set_new_password($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";
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
	
	
	public function set_edit_profile($info,$i_id)
    {
        try
        {
			
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";
				$s_qry.=" s_name=? ";
				$s_qry.=", s_address=? ";
				$s_qry.=", i_province=? ";
				$s_qry.=", i_city=? ";
				$s_qry.=", i_zipcode=? ";
				$s_qry.=", s_lat=? ";
				$s_qry.=", s_lng=? ";
				$s_qry.=", i_edited_date=? ";
                $s_qry.=", i_dob=? ";
                $s_qry.=", s_msn_id=? "; 
                $s_qry.=", s_contact_no=? ";
                $s_qry.=", s_fax=? "; 
                $s_qry.=", s_landline=? "; 
                $s_qry.=", s_yahoo_id=? "; 
                $s_qry.=", s_skype_id=? "; 
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(
												 
												  get_formatted_string($info["s_name"]),
												  get_formatted_string($info["s_address"]),
												  intval($info["i_province_id"]),
												  intval($info["i_city_id"]),
												  intval($info["i_zipcode_id"]),
												  get_formatted_string($info["s_lat"]),
												  get_formatted_string($info["s_lng"]),
												  intval($info["i_edited_date"]),
                                                  intval($info["i_dob"]), 
                                                  get_formatted_string($info["s_msn_id"]), 
                                                  get_formatted_string($info["s_contact_no"]),
                                                  get_formatted_string($info["s_fax"]), 
                                                  get_formatted_string($info["s_landline"]), 
                                                  get_formatted_string($info["s_yahoo_id"]), 
                                                  get_formatted_string($info["s_skype_id"]),  
                                                  
												  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
				
					//$this->update_profile_details($info,$i_id);
					
					//$this->update_profile_image($info,$i_id); 
					
					//
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												 
												  get_formatted_string($info["s_name"]),
												  get_formatted_string($info["s_email"]),
												  get_formatted_string($info["s_address"]),
												  intval($info["i_province_id"]),
												  intval($info["i_city_id"]),
												  intval($info["i_zipcode_id"]),
												  get_formatted_string($info["s_lat"]),
												  get_formatted_string($info["s_lng"]),
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
	
	
	
	public function update_profile_image($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl_user_image." Set ";
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
	
	
	/* tradesman album */
	
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
					//$s_qry.=", s_title=? ";
					$s_qry.=", i_uploaded_date=? ";
					
					$this->db->query($s_qry,array(
													intval($id),
													get_formatted_string($info['s_image']),
													//get_formatted_string($info['s_title']),
													intval($info['i_uploaded_date'])
												));
												
					$i_ret_=$this->db->insert_id(); 
					if($i_ret_)
					{
						 $logi["msg"]="Inserting into ".$this->tbl_trades_album." ";
                    	$logi["sql"]= serialize(array($s_qry,array(
													intval($id),
													get_formatted_string($info['s_image']),
													//get_formatted_string($info['s_title']),
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
                  $ret_[$i_cnt]["s_title"]	=	get_unformatted_string($row->s_title); 
				  $ret_[$i_cnt]["s_image"]	=	get_unformatted_string($row->s_image); 
				  
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
	
	
	
	 public function active_account($activation_code) {
				$sql = "SELECT s_username FROM jobshoppa_user
							WHERE s_verification_code='{$activation_code}' AND i_is_active = 0";
				$res = $this->db->query($sql);
				$num = $res->num_rows();
				$arr_master = array('i_is_active'=>1);
				if ($num == 1 )
				{
					$sql = " UPDATE jobshoppa_user SET i_is_active=1
							WHERE s_verification_code='{$activation_code}' AND i_is_active = 0";
					$res = $this->db->query($sql);
					return true;
				}
				else
				{
					return false;
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
                ." Where n.state_id=?";
                
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
                ." Where n.state_id=?"
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
	
	
	public function change_verification_status($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl_trades_ver." Set ";
				$s_qry.=" i_verifcation_status= ? ";
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
	function set_data_insert($tableName,$arr)
    {
        if( !$tableName || $tableName=='' ||  count($arr)==0 )
			return false;
		if($this->db->insert($tableName, $arr))
            return $this->db->insert_id();
        else
            return false;
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
	
	/* verification approved reject mail */
	function verifiaction_approved_reject($user_id,$info,$stat)
	{
		try
		{//echo $user_id; exit;
			if($info)
			{		
					$details = $this->fetch_this($user_id);
					
					global $CI;				
					$CI->load->model('auto_mail_model');					
					
					$content = $CI->auto_mail_model->fetch_contact_us_content('verification_check','tradesman');
					$mail_subject = $content['s_subject'];
					
					//print_r($content); exit;
					$filename = $this->config->item('EMAILBODYHTML')."common.html";
					$handle = @fopen($filename, "r");
					$mail_html = @fread($handle, filesize($filename));	
					
					if(!empty($content))
					{							
						$description = $content["s_content"];
						$description = str_replace("[username]",$details['s_username'],$description);	
						if($info==2)
						{
							$description = str_replace("[type]",'Phone Verification.',$description);
						}
						if($info==1)
						{
							$description = str_replace("[type]",'Credentials Verification',$description);
						}	
						if($stat==3)
						{
							$description = str_replace("[status]",'Approved',$description);
						}
						if($stat==2)
						{
							$description = str_replace("[status]",'Rejected',$description);
						}
													
						$description = str_replace("%EMAIL_DISCLAMER%","",$description);
						$description = str_replace("[site_url]",base_url(),$description);							
					}
					unset($content);
					//echo "<br>DESC".$description;	exit;
					$mail_html = str_replace("[site url]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					/// Mailing code...[start]
					$site_admin_email = $this->s_admin_email;
					$this->load->helper('mail');
					$tect = sendMail($details['s_email'],$mail_subject,$mail_html,$site_admin_email);			
				
				
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
					 	$content = $CI->auto_mail_model->fetch_contact_us_content('account_deactivate','general');
						$mail_subject = $content['s_subject'];
					}
					else if($info['i_is_active']==1)
					{
						$content = $CI->auto_mail_model->fetch_contact_us_content('account_reactivate','general');
						$mail_subject = $content['s_subject'];
					}
					//print_r($content); exit;
					$filename = $this->config->item('EMAILBODYHTML')."common.html";
					$handle = @fopen($filename, "r");
					$mail_html = @fread($handle, filesize($filename));	
					
					if(!empty($content))
					{							
						$description = $content["s_content"];
						$description = str_replace("[username]",$details['s_username'],$description);
						$description = str_replace("[site_url]",base_url(),$description);								
						$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
					}
					unset($content);
					//echo "<br>DESC".$description;	exit;
					$mail_html = str_replace("[site url]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					/// Mailing code...[start]
					$site_admin_email = $this->s_admin_email;
					$this->load->helper('mail');
					$tect = sendMail($details['s_email'],$mail_subject,$mail_html,$site_admin_email);			
				
				
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
    
    
    /***
    * Update records in db. As we know the table name 
    * we will not pass it into params.
    * 
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @param int $i_id, id value to be updated used in where clause
    * @returns $i_rows_affected  on success and FALSE if failed 
    */
    
    
      public function update_info($info,$i_id)
    {
        try
        {

            $i_ret_=0;////Returns false
            
            if(!empty($info))
            {
                $this->db->update($this->tbl, $info, array('id'=>$i_id));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $this->db->trans_commit();///new    
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= $this->db->last_query();  
                    $this->log_info($logi); 
                    unset($logi);
                }
                else
                {
                    $this->db->trans_rollback();///new
                }                                         
            }
            return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }    
}  


 public function update_tradesman_info($info,$i_id)
    {
        try
        {

            $i_ret_=0;////Returns false
            
            if(!empty($info))
            {
                
                
                $this->db->update($this->tbl_tradesman_detail, $info, array('i_user_id'=>$i_id));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $this->db->trans_commit();///new    
                    $logi["msg"]="Updating ".$this->tbl_tradesman_detail." ";
                    $logi["sql"]= $this->db->last_query();  
                    $this->log_info($logi); 
                    unset($logi);
                }
                else
                {
                    $this->db->trans_rollback();///new
                }                                         
            }
            return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }    
}  
	
	/*upadte tardesman won jobs */
	function update_tradesman_won_job($i_tradesman_id)
	{
		$sql = "UPDATE {$this->tbl_tradesman_detail} SET i_jobs_won = i_jobs_won +1 WHERE i_user_id={$i_tradesman_id}";
		$this->db->query($sql);
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