<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 29 March 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For Manage Jobs
* 
* @package Content Management
* @subpackage jobs
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/user.php
* @link views/admin/user/
*/


class Manage_jobs_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
	public $tbl_city;
	public $tbl_zip;
	public $tbl_cat;
	public $tbl_user;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl 			= $this->db->JOBS;  
		  $this->tbl_city 		= $this->db->CITY;   
		  $this->tbl_zip 		= $this->db->ZIPCODE;  
		  $this->tbl_cat 		= $this->db->CATEGORY;     
		  $this->tbl_province 	= $this->db->PROVINCE;
		  $this->tbl_user 		= $this->db->MST_USER;
		  $this->tbl_job_quotes	= $this->db->JOBQUOTES;    
		  $this->tbl_pay 		= $this->db->JOB_PAYMENT_HISTORY;   
		  $this->tbl_waiver 	= $this->db->WAIVER_PAYMENT;
			
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
    public function fetch_multi($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {	
          	$ret_=array();
			$s_qry="SELECT n.*,qu.s_name FROM ".$this->tbl." n "
					."LEFT JOIN ".$this->tbl_user." AS qu ON n.i_buyer_user_id = qu.id "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          	//echo $s_qry;exit;
		  $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_title"]			    =	get_unformatted_string($row->s_title); 
				  $ret_[$i_cnt]["s_part_title"]			=	string_part(get_unformatted_string($row->s_title),50);
				  $s_desc = stripslashes(htmlspecialchars_decode($row->s_description));
				  $ret_[$i_cnt]["s_part_description"]	=	string_part($s_desc,150);
				  if(strlen($s_desc)>197)
				  	$s_desc = substr_replace($s_desc,'...',200);
				  $ret_[$i_cnt]["s_description"]	=	$s_desc; 
				  $ret_[$i_cnt]["i_buyer_id"]		=	intval($row->i_buyer_id); 
				  $ret_[$i_cnt]["i_tradesman_id"]	=	intval($row->i_tradesman_id); 
				  $ret_[$i_cnt]["s_buyer_name"]		=	stripslashes($row->s_name);
				  
				  $ret_[$i_cnt]["s_contact_no"]		=	get_unformatted_string($row->s_contact_no); 
				  
                  $ret_[$i_cnt]["dt_created_on"]	=	date($this->conf["site_date_format"],intval($row->i_created_date));
				  $ret_[$i_cnt]["dt_expired_on"]	=	($row->i_expire_date)?date($this->conf["site_date_format"],intval($row->i_expire_date)):0;  
				  $ret_[$i_cnt]["i_is_active"]		=	intval($row->i_status); 
				  $ret_[$i_cnt]["s_is_active"]		=	$this->db->JOBSTATUS[$row->i_status];
                  
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
					." LEFT JOIN ".$this->tbl_zip." z ON n.i_zipcode_id = z.id"
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
          $s_qry="Select c.{$this->s_lang_prefix}_s_category_name AS s_category_name,n.*,qu.s_name,z.postal_code, s.province, ct.city, z.latitude , z.longitude,tr.s_name AS tradesman_name "
                ."From ".$this->tbl." AS n "
				."LEFT JOIN ".$this->db->MST_USER." AS qu ON n.i_buyer_user_id = qu.id "
				."LEFT JOIN ".$this->tbl_cat." AS c ON n.i_category_id = c.i_id "
				." LEFT JOIN {$this->tbl_zip} z ON n.i_zipcode_id = z.id"
				." LEFT JOIN {$this->tbl_province} s ON n.i_province_id = s.id"
				." LEFT JOIN {$this->tbl_city} ct ON n.i_city_id = ct.id"
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
				  $ret_["s_buyer_name"]				=	stripslashes($row->s_name);
				 
				  $ret_["opt_city"] 				= 	stripslashes($row->i_city); 
				  $ret_["opt_province"] 				= 	stripslashes($row->i_province); 
				  $ret_["opt_zip"] 					= 	stripslashes($row->i_zipcode);
				  $ret_["s_province"]					=	get_unformatted_string($row->province); 
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
				  
				  $CI = get_instance();
				  $CI->load->model('job_model');
				  $ret_["job_files"]				=	$CI->job_model->fetch_multi_job_image(" WHERE n.i_job_id=".$row->id); 
		  
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
				
                //$s_qry.=" i_status=? ";
                //$s_qry.=", i_admin_approval_date=? ";
				//$s_qry.=", i_expire_date=? ";
				//$s_qry.=", s_type=? ";
				$s_qry.=" s_title=? ";
				$s_qry.=", s_description=? ";
				$s_qry.=", s_keyword=? ";
				$s_qry.=", i_quoting_period_days=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(
												  //intval($info["i_is_active"]),
												  //intval($info["i_admin_approval_date"]),
												  //intval($info["i_expire_date"]),
												  //trim(htmlspecialchars($info["s_type"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_title"], ENT_QUOTES, 'utf-8')),
												  get_unformatted_string($info["s_description"]),
												  trim(htmlspecialchars($info["s_keyword"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_quoting_period_days"]),
												  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  //intval($info["i_is_active"]),
												  //intval($info["i_admin_approval_date"]),
												  //intval($info["i_expire_date"]),
												  //trim(htmlspecialchars($info["s_type"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_title"], ENT_QUOTES, 'utf-8')),
												  get_unformatted_string($info["s_description"]),
												  trim(htmlspecialchars($info["s_keyword"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_quoting_period_days"]),
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
	/**
		Method to change the status for a record
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
			 
				//echo $i_id.'-'.$i_status;
				$s_qry="UPDATE ".$this->tbl."  SET i_status=?";
				if(intval($i_status) == 1)	
				{			
					$s_qry.=" ,i_expire_date = UNIX_TIMESTAMP(ADDDATE(SYSDATE(),INTERVAl (i_quoting_period_days*7) DAY))";
					$s_qry.=" ,i_admin_approval_date  = UNIX_TIMESTAMP(SYSDATE())";
				}
                $s_qry.=" Where id=? ";
				//echo $s_qry;
                $this->db->query($s_qry, array(intval($i_status),intval($i_id)) );
                $i_ret_ =  $this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($i_id),intval($i_status)) ) ) ;
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
	
	
	function job_accept_reject($job_id,$info)
	{
		try
		{
			if($info['i_is_active']==1)
			{
				global $CI;
				$CI->load->model('job_model');
				$details = $CI->job_model->fetch_this($job_id);
				
				//print_r($details); exit;
				$s_wh_id = " WHERE n.i_user_id=".$details['i_buyer_user_id']." ";
				$CI->load->model('manage_buyers_model');
				$buyer_details =  $CI->manage_buyers_model->fetch_this($details['i_buyer_user_id']);
				//print_r($buyer_details); exit;
				$buyer_email_key = $CI->manage_buyers_model->fetch_email_keys($s_wh_id);
				$is_mail_need = in_array('admin_buyer_cancel_job',$buyer_email_key);
				if($is_mail_need)
				{
					$CI->load->model('auto_mail_model');
					$content = $CI->auto_mail_model->fetch_mail_content('job_approved','buyer');
					
					$filename = $this->config->item('EMAILBODYHTML')."common.html";
				   	$handle = @fopen($filename, "r");
				   	$mail_html = @fread($handle, filesize($filename));
					//print_r($content); exit;
					if(!empty($content))
					{				
								
						$description = $content["s_content"];
						$description = str_replace("[Buyer name]",$details['s_buyer_name'],$description);
						$description = str_replace("[job title]",$details['s_title'],$description);	
						$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);									
						
					}
					//unset($content);
					
					$mail_html = str_replace("[site url]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					//echo "<br>DESC".$description;	exit;
					/// Mailing code...[start]
					$site_admin_email = $this->s_admin_email;
					if($buyer_details['i_signup_lang']==2)
					{
						$subject = $content['s_subject_french'];
					}
					else
					{
						$subject = '::: Job Approved mail :::';
					}
					unset($content);
					$this->load->helper('mail');
					$tect = sendMail($details['s_email'],$subject,$mail_html);					
					
				}
				else
				{
					$tect = true;
				}
				return $tect;
				
			}
			
			else if($info['i_is_active']==2)
			{
				
				global $CI;
				$CI->load->model('job_model');
				$details = $CI->job_model->fetch_this($job_id);
				
				//print_r($details); exit;
				$s_wh_id = " WHERE n.i_user_id=".$details['i_buyer_user_id']." ";
				$CI->load->model('manage_buyers_model');
				$buyer_details =  $CI->manage_buyers_model->fetch_this($details['i_buyer_user_id']);
				
				$buyer_email_key = $CI->manage_buyers_model->fetch_email_keys($s_wh_id);
				$is_mail_need = in_array('admin_buyer_cancel_job',$buyer_email_key);
				if($is_mail_need)
				{
					$CI->load->model('auto_mail_model');
					$content = $CI->auto_mail_model->fetch_mail_content('job_rejected','buyer');
					$filename = $this->config->item('EMAILBODYHTML')."common.html";
				   	$handle = @fopen($filename, "r");
				   	$mail_html = @fread($handle, filesize($filename));
					//print_r($content); exit;
					if(!empty($content))
					{							
						if($buyer_details['i_signup_lang']==2)
						{
							$description = $content["s_content_french"];
						}
						else
						{			
							$description = $content["s_content"];
						}
						$description = str_replace("[Buyer name]",$details['s_buyer_name'],$description);
						$description = str_replace("[job title]",$details['s_title'],$description);										
						$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
					}
					unset($content);
					
					$mail_html = str_replace("[site url]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					//echo "<br>DESC".$description;	exit;
					/// Mailing code...[start]
					$site_admin_email = $this->s_admin_email;
					if($buyer_details['i_signup_lang']==2)
					{
						$subject = $content['s_subject_french'];
					}
					else
					{
						$subject = '::: Job Reject mail :::';
					}
					$this->load->helper('mail');
					$tect = sendMail($details['s_email'],$subject,$mail_html);					
					
				}
				else
				{
					$tect = true;
				}
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
	
	
	
	/************************** FUNCTIONS FOR REPORTS SECTION   ****************************/
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
					 " LEFT JOIN {$this->tbl_zip} p ON p.id = n.i_zipcode_id"
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
	
	
	public function fetch_quote_multi($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
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
	
	
	 public function gettotal_quote_info($s_where=null)
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
				." LEFT JOIN {$this->tbl_pay} p ON p.i_job_id = n.id  "
				." LEFT JOIN {$this->tbl_waiver} w ON w.i_job_id = n.id  "
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
	
	/****
    * Fetch Total records
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @returns int on success and FALSE if failed 
    */
    public function gettotal_in_progress_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ." FROM {$this->tbl} n "
				." LEFT JOIN {$this->tbl_pay} p ON p.id = n.id  "
				." LEFT JOIN {$this->tbl_waiver} w ON w.id = n.id  "
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
	
	
	
	
	
    public function __destruct()
    {}                 
  
  
}
///end of class
?>