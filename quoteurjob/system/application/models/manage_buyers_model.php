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


class Manage_buyers_model extends MY_Model implements InfModel
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
		  //$this->tbl_user_image = $this->db->USERIMAGE;  
		  $this->tbl_city = $this->db->CITY;   
		  $this->tbl_zip = $this->db->ZIPCODE;  
		  $this->tbl_state = $this->db->STATE; 
		  $this->tbl_user_image = $this->db->USREIMAGE;
		  $this->tbl_news_subscript = $this->db->NEWSLETTERSUBCRIPTION;  
		  $this->tbl_testimonial = $this->db->TESTIMONIAL;  
		  $this->tbl_b_detail = $this->db->BUYERDETAILS;
		  
		  $this->tbl_pmb			=	$this->db->PMB;
		  $this->tbl_pmb_details	=	$this->db->PMBDETAILS;
		  $this->tbl_job	=	$this->db->JOBS;
		  $this->tbl_automail_right = $this->db->AUTOMAILRIGHT;
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
					n.s_address, n.i_created_date, n.i_is_active, s.state, c.city, z.postal_code					
					 FROM ".$this->tbl." n ".
					 " LEFT JOIN {$this->tbl_state} s ON s.id = n.i_province".
					 " LEFT JOIN {$this->tbl_city} c ON c.id = n.i_city".
					 " LEFT JOIN {$this->tbl_zip} z ON z.id = n.i_zipcode"
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
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
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" ORDER BY {$order_name} {$order_by} Limit ".intval($i_start).",".intval($i_limit):"" );
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
	
    public function fetch_buyer_image($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {	
          	$ret_=array();
			$s_qry="SELECT n.* 					
					 FROM ".$this->tbl_user_image." n "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          //echo $s_qry;
		  $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_user_image"]		=	get_unformatted_string($row->s_user_image); 
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
			
		  $CI	= &get_instance();
    	  $CI->load->model('job_model');		
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select n.*,bd.i_total_job_posted,bd.i_total_job_awarded, bd.i_feedback_rating, bd.f_positive_feedback_percentage, bd.i_feedback_received,c.city, s.state,z.postal_code "
                ."From ".$this->tbl." AS n 
				LEFT JOIN ".$this->tbl_b_detail." AS bd ON n.id = bd.i_user_id 
				LEFT JOIN ".$this->db->CITY." as c ON n.i_city = c.id 
				LEFT JOIN ".$this->db->STATE." As s ON n.i_province = s.id
				LEFT JOIN ".$this->db->ZIPCODE." AS z ON n.i_zipcode = z.id
				"
                ." Where n.id=? AND c.i_status = 1";
                
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
				  $ret_["s_lat"]			=	stripslashes(htmlspecialchars_decode($row->s_lat)); 
				  $ret_["s_lng"]			=	stripslashes(htmlspecialchars_decode($row->s_lng)); 
				  
				  $ret_["i_role"]			=	intval($row->i_role); 
				  
				  $ret_["opt_city"] 		= 	stripslashes($row->i_city); 
				  $ret_["opt_state"] 		= 	stripslashes($row->i_province); 
				  $ret_["opt_zip"] 			= 	stripslashes($row->i_zipcode); 
				  $ret_["s_city"] 		= 	stripslashes($row->city); 
				  $ret_["s_state"] 		= 	stripslashes($row->state); 
				  $ret_["s_zip"] 			= 	stripslashes($row->postal_code); 
				  $ret_["chk_newsletter"]		=	intval($row->i_inform_news); 
				  
				  $ret_["i_signup_lang"]		=	intval($row->i_signup_lang); 
				  
				 $ret_["i_total_job_posted"]		=	intval($row->i_total_job_posted); 
				 $ret_["i_total_job_awarded"]		=	intval($row->i_total_job_awarded); 
				 $ret_["f_positive_feedback_percentage"]		=	doubleval($row->f_positive_feedback_percentage);
				 $ret_["i_feedback_received"]		=	intval($row->i_feedback_received);
				 $ret_["i_feedback_rating"]		=	intval($row->i_feedback_rating);
				  
                  $ret_["dt_created_on"]	=	date($this->conf["site_date_format"],intval($row->i_created_date)); 
				  $ret_["i_verified"]		=	intval($row->s_verified); 
				  $ret_["s_verified"]		=	(intval($row->s_verified)==1?"Verified":"Not Verified");
				  $ret_["i_is_active"]		=	intval($row->i_is_active); 
				  $ret_["s_is_active"]		=	(intval($row->i_is_active)==1?"Active":"Inactive");
				  $s_where = " WHERE i_buyer_user_id={$row->id}";
				  $ret_["i_job_post"]		= 	$CI->job_model->gettotal_info($s_where);
				  $s_where = " WHERE i_user_id={$row->id}";
				  $ret_["image"]			= 	$this->fetch_buyer_image($s_where);
				 

		  
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
                $s_qry.=", i_is_active=? ";
                $s_qry.=", i_created_date=? ";
				$s_qry.=", i_inform_news=? ";
				$s_qry.=", i_signup_lang=? ";
                
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
												  intval($info["i_is_active"]),
												  intval($info["i_created_date"]),
												  intval($info["i_inform_news"]),
												  intval($info["i_signup_lang"])
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
					$this->insert_image($info,$i_ret_); 
					
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
												  intval($info["i_is_active"]),
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
	
	/* newsletter subscriber insert into database*/
	public function insert_newsletter_subscription($info,$id=0)
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
					$s_qry.=", dt_entry_date=? ";
					
					$this->db->query($s_qry,array(
													intval($id),
													intval($info['i_role']),
													get_formatted_string($info['s_email']),
													get_formatted_string($info['s_name']),
													intval(time())
												));
					
					$i_ret_=$this->db->insert_id(); 
					if($i_ret_)
					{
						$logi["msg"]="Inserting into ".$this->tbl_news_subscript." ";
                    	$logi["sql"]= serialize(array($s_qry,array(
													intval($id),
													intval($info['i_role']),
													get_formatted_string($info['s_email']),
													get_formatted_string($info['s_name']),
													intval(time())
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

	/** check newletter  **/
    public function gettotal_newsletter_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl_news_subscript." n "
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
                $s_qry.=", i_created_date=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(
												  get_formatted_string($info["s_username"]),
												  get_formatted_string($info["s_name"]),
												  get_formatted_string($info["s_email"]),
												  get_formatted_string($info["s_skype_id"]),
												  get_formatted_string($info["s_msn_id"]),
												  get_formatted_string($info["s_yahoo_id"]),
												  trim(htmlspecialchars($info["s_contact_no"], ENT_QUOTES, 'utf-8')),
												  intval(decrypt($info["i_province"])),
												  intval(decrypt($info["i_city"])),
												  intval(decrypt($info["i_zipcode"])),
												  //trim(htmlspecialchars($info["s_lat"], ENT_QUOTES, 'utf-8')),
												  //trim(htmlspecialchars($info["s_lng"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_role"]),
												  
												  intval($info["s_verified"]),
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
												  get_formatted_string($info["s_skype_id"]),
												  get_formatted_string($info["s_msn_id"]),
												  get_formatted_string($info["s_yahoo_id"]),
												  trim(htmlspecialchars($info["s_contact_no"], ENT_QUOTES, 'utf-8')),
												  intval(decrypt($info["i_province"])),
												  intval(decrypt($info["i_city"])),
												  intval(decrypt($info["i_zipcode"])),
												  //trim(htmlspecialchars($info["s_lat"], ENT_QUOTES, 'utf-8')),
												  //trim(htmlspecialchars($info["s_lng"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_role"]),
												  
												  intval($info["s_verified"]),
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
	
	
	
	
	public function set_edit_profile($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";
				$s_qry.=" s_name=? ";
				$s_qry.=", s_email=? ";
				$s_qry.=", s_address=? ";
				$s_qry.=", i_province=? ";
				$s_qry.=", i_city=? ";
				$s_qry.=", i_zipcode=? ";
				$s_qry.=", s_lat=? ";
				$s_qry.=", s_lng=? ";
				$s_qry.=", i_edited_date=? ";
				$s_qry.=", i_inform_news=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(
												 
												  get_formatted_string($info["s_name"]),
												  get_formatted_string($info["s_email"]),
												  get_formatted_string($info["s_address"]),
												  intval($info["i_province_id"]),
												  intval($info["i_city_id"]),
												  intval($info["i_zipcode_id"]),
												  get_formatted_string($info["s_lat"]),
												  get_formatted_string($info["s_lng"]),
												  intval($info["i_edited_date"]),
												  intval($info["chk_newletter"]),
												  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
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
												  intval($info["chk_newletter"]),
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
	
	
	public function fetch_testimonial($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
          	$ret_=array();
			$s_qry="SELECT * FROM ".$this->tbl_testimonial." n "
                .($s_where!=""?$s_where:"" )." ORDER BY n.dt_entry_date DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          //echo $s_qry;
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
	
	
	
	
	/* fetch private message board */
	
	public function fetch_pmb($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
          	$ret_=array();
			$s_qry="SELECT j.s_title,u.s_name,pd.i_date,n.* FROM ".$this->tbl_pmb." n "
				." LEFT JOIN {$this->tbl_pmb_details} pd ON pd.i_msg_board_id = n.id "
				." LEFT JOIN {$this->tbl_job} j ON j.id = n.i_job_id "
				." LEFT JOIN {$this->tbl} u ON u.id	=	n.i_tradesman_id "
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
                  $ret_[$i_cnt]["s_tradesman_name"]	=	htmlspecialchars_decode(get_unformatted_string($row->s_name)); 
				  $ret_[$i_cnt]["s_job_title"]		=	htmlspecialchars_decode(get_unformatted_string($row->s_title)); 
				  $s_desc = htmlspecialchars_decode(get_unformatted_string($row->s_message));
                  $ret_[$i_cnt]["s_message"]		= 	(strlen($s_desc)>70) ? substr_replace($s_desc,'...',74) : $s_desc;
				  $ret_[$i_cnt]["s_large_message"]	= 	(strlen($s_desc)>300) ? substr_replace($s_desc,'...',304) : $s_desc;
				  
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
	
	
	 public function fetch_this_pmb($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
			
		  	
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select u.s_name as SENDER_NAME,us.s_name as RECEIVER_NAME, pd.* From ".$this->tbl_pmb_details." AS pd " 
		  		." LEFT JOIN {$this->tbl} u ON u.id	=	pd.i_sender_id " 
				." LEFT JOIN {$this->tbl} us ON us.id	=	pd.i_receiver_id "              
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            
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
					$this->insert_image($info,$i_ret_); 
					
					$this->insert_newsletter_subscription($info,$i_ret_);
					
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
	
	
	
	 public function active_account($activation_code) {
				$sql = "SELECT s_username FROM quoteurjob_user
							WHERE s_verification_code='{$activation_code}' AND i_is_active = 0";
				$res = $this->db->query($sql);
				$num = $res->num_rows();
				$arr_master = array('i_is_active'=>1);
				if ($num == 1 )
				{
					//$this->db->update($this->tbl, $arr_master, array('s_verification_code'=>$activation_code));
					$sql = " UPDATE quoteurjob_user SET i_is_active=1
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
						
						$filename = $this->config->item('EMAILBODYHTML')."common.html";
				   		$handle = @fopen($filename, "r");
				   		$mail_html = @fread($handle, filesize($filename));
					}
					else if($info['i_is_active']==1)
					{
						$content = $CI->auto_mail_model->fetch_contact_us_content('account_reactivate','general');
						
						$filename = $this->config->item('EMAILBODYHTML')."common.html";
				   		$handle = @fopen($filename, "r");
				   		$mail_html = @fread($handle, filesize($filename));
					}
					//print_r($content); exit;
					if(!empty($content))
					{			
						if($details['i_signup_lang']==2)
						{
							$description = $content["s_content_french"];
						}
						else
						{				
							$description = $content["s_content"];
						}
						$description = str_replace("[username]",$details['s_username'],$description);
						$description = str_replace("[site url]",base_url(),$description);									
						$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
					}
					//unset($content);
					
					$mail_html = str_replace("[site url]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					//echo "<br>DESC".$description;	exit;
					/// Mailing code...[start]
					$site_admin_email = $this->s_admin_email;
					if($details['i_signup_lang']==2)
					{
						$subject = $content['s_subject_french'];
					}
					else
					{
						$subject = $content['s_subject'];
					}
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
	 
	
	
    public function __destruct()
    {}                 
  
  
}