<?php
/*********
* Author: Iman Biswas
* Date  : 27 Sep 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
* Model For Testimonial
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

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->JOBS;
		  $this->tbl_job_quotes = $this->db->JOBQUOTES;
		  $this->tbl_state = $this->db->STATE;
		  $this->tbl_city = $this->db->CITY;
		  $this->tbl_zipcode = $this->db->ZIPCODE;
		  $this->tbl_job_files = $this->db->JOBS_FILES;   
		  $this->tbl_user = $this->db->USERMANAGE; 
		  $this->tbl_cat = $this->db->CATEGORY;        
		  $this->tbl_job_invitation = $this->db->JOB_INVITATION; 
		  $this->tbl_job_history = $this->db->JOB_HISTORY;
		  $this->tbl_job_payment_history = $this->db->JOB_PAYMENT_HISTORY;
		  
		  $this->tbl_waiver_payment = $this->db->WAIVER_PAYMENT;
		  
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
    public function fetch_multi($s_where=null,$i_start=null,$i_limit=null,$order_by="n.i_created_date")
    {
		
        try
        {
          	$ret_=array();
			$s_qry = "SELECT n.*, z.postal_code, s.state, c.city, z.latitude , z.longitude, cat_c.s_name AS s_category_name,
					  tradesman.s_username,  tradesman.s_email, tradesman.s_address, tradesman.s_contact_no, buyer.s_username s_buyer_name
					 FROM ".$this->tbl." n "
					." LEFT JOIN {$this->tbl_cat} cat ON n.i_category_id = cat.id"
					." LEFT JOIN {$this->db->CATEGORYCHILD} cat_c ON cat_c.i_cat_id = cat.id"
					." LEFT JOIN {$this->tbl_zipcode} z ON n.i_zipcode_id = z.id"
					." LEFT JOIN {$this->tbl_state} s ON n.i_province_id = s.id"
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
				  
				  $ret_[$i_cnt]["s_category_name"]=stripslashes(htmlspecialchars_decode($row->s_category_name)); 
				  $s_desc = stripslashes(htmlspecialchars_decode($row->s_description));
				  if(strlen($s_desc)>197)
				  	$s_desc = substr_replace($s_desc,'...',200);
				  $ret_[$i_cnt]["s_description"]= $s_desc;
				  $ret_[$i_cnt]["d_budget_price"]= doubleval($row->d_budget_price);
				  $ret_[$i_cnt]["s_budget_price"]= doubleval($row->d_budget_price).' '.$this->conf["default_currency"];
				  $ret_[$i_cnt]["s_state"]=stripslashes(htmlspecialchars_decode($row->state)); 
				  $ret_[$i_cnt]["s_city"]=stripslashes(htmlspecialchars_decode($row->city)); 
				  $ret_[$i_cnt]["s_postal_code"]=stripslashes(htmlspecialchars_decode($row->postal_code)); 
				  $ret_[$i_cnt]["i_days_left"] = ($row->i_expire_date)?round(($row->i_expire_date-time()) / 86400):0;
				  $ret_[$i_cnt]["s_days_left"] = ($ret_[$i_cnt]["i_days_left"]>1) ? $ret_[$i_cnt]["i_days_left"].' days' :' 0 day';
				  
                  $ret_[$i_cnt]["dt_entry_date"]= date($this->conf["site_date_format"],intval($row->i_created_date));
				  $ret_[$i_cnt]["dt_completed_date"]= date($this->conf["site_date_format"],intval($row->i_completed_date));
				  $ret_[$i_cnt]["dt_expired_date"]= ($row->i_expire_date)?date($this->conf["site_date_format"],intval($row->i_expire_date)):'N/A';
				  $ret_[$i_cnt]["dt_fn_assigned_date"]= ($row->i_assigned_date) ? date($this->conf["front_job_date_format"],intval($row->i_assigned_date)):'';
				  $s_where = " WHERE i_job_id={$row->id} And i_status!=3";
				  $ret_[$i_cnt]["i_quotes"]=$this->gettotal_job_quote_info($s_where);
				  
				  
				  $ret_[$i_cnt]["s_username"]=stripslashes(htmlspecialchars_decode($row->s_username)); 
				  $ret_[$i_cnt]["s_email"]=stripslashes(htmlspecialchars_decode($row->s_email)); 
				  $ret_[$i_cnt]["s_address"]=stripslashes(htmlspecialchars_decode($row->s_address)); 
				  $ret_[$i_cnt]["s_contact_no"]= stripslashes(htmlspecialchars_decode($row->s_contact_no)); 
				  
				  $ret_[$i_cnt]["s_buyer_name"]=stripslashes(htmlspecialchars_decode($row->s_buyer_name)); 				  
				  
                  $ret_[$i_cnt]["i_is_active"]= intval($row->i_status); 
				  $ret_[$i_cnt]["i_status"]= intval($row->i_status); 
				  $ret_[$i_cnt]["s_is_active"]= $this->db->JOBSTATUS[$row->i_status];
				  
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
					//." LEFT JOIN {$this->tbl_cat} cat ON n.i_category_id = cat.id"
					." LEFT JOIN {$this->db->CATEGORYCHILD} cat_c ON cat_c.i_cat_id = n.i_category_id"
					." LEFT JOIN {$this->tbl_zipcode} z ON n.i_zipcode_id = z.id"
					." LEFT JOIN {$this->tbl_state} s ON n.i_province_id = s.id"
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
    
	 public function fetch_multi_completed($s_where=null,$i_start=null,$i_limit=null)
    {
		
        try
        {
          	$ret_=array();
			
			$s_qry = "SELECT n.*, z.postal_code, s.state, c.city, z.latitude , z.longitude, cat_c.s_name AS s_category_name,
					  tradesman.s_username,  tradesman.s_email, tradesman.s_address, tradesman.s_contact_no, buyer.s_username AS s_buyer_name
					 FROM ".$this->tbl." n "
					//." LEFT JOIN {$this->tbl_cat} cat ON n.i_category_id = cat.id"
					." LEFT JOIN {$this->db->CATEGORYCHILD} cat_c ON cat_c.i_cat_id = n.i_category_id"
					." LEFT JOIN {$this->tbl_zipcode} z ON n.i_zipcode_id = z.id"
					." LEFT JOIN {$this->tbl_state} s ON n.i_province_id = s.id"
					." LEFT JOIN {$this->tbl_city} c ON n.i_city_id = c.id"
					." LEFT JOIN {$this->tbl_user} tradesman ON tradesman.id = n.i_tradesman_id"
					." LEFT JOIN {$this->tbl_user} buyer ON buyer.id = n.i_buyer_user_id"
                .($s_where!=""?$s_where:"" ). " ORDER BY n.i_created_date DESC" .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
		//echo "<br/> 4::".$s_qry."<br/>"; 
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
				  $ret_[$i_cnt]["i_buyer_user_id"]=$row->i_buyer_user_id;
                  $ret_[$i_cnt]["s_title"]=stripslashes(htmlspecialchars_decode($row->s_title)); 
				  $ret_[$i_cnt]["s_part_title"] = string_part($ret_[$i_cnt]["s_title"],40);
				  
				  $ret_[$i_cnt]["s_category_name"]=stripslashes(htmlspecialchars_decode($row->s_category_name)); 
				  $s_desc = stripslashes(htmlspecialchars_decode($row->s_description));
				  if(strlen($s_desc)>197)
				  	$s_desc = substr_replace($s_desc,'...',204);
				  $ret_[$i_cnt]["s_description"]= $s_desc;
				  $ret_[$i_cnt]["d_budget_price"]= doubleval($row->d_budget_price);
				  $ret_[$i_cnt]["s_budget_price"]= doubleval($row->d_budget_price).' '.$this->conf["default_currency"];
				  $ret_[$i_cnt]["s_state"]=stripslashes(htmlspecialchars_decode($row->state)); 
				  $ret_[$i_cnt]["s_city"]=stripslashes(htmlspecialchars_decode($row->city)); 
				  $ret_[$i_cnt]["s_postal_code"]=stripslashes(htmlspecialchars_decode($row->postal_code)); 
				  $ret_[$i_cnt]["i_days_left"] = ($row->i_expire_date)?round(($row->i_expire_date-time()) / 86400):0;
				  $ret_[$i_cnt]["s_days_left"] = ($ret_[$i_cnt]["i_days_left"]>1) ? $ret_[$i_cnt]["i_days_left"].' days' :' 0 day';
				  
                  $ret_[$i_cnt]["dt_entry_date"]= date($this->conf["site_date_format"],intval($row->i_created_date));
				  $ret_[$i_cnt]["dt_completed_date"]= date($this->conf["site_date_format"],intval($row->i_completed_date));
				  $ret_[$i_cnt]["dt_expired_date"]= ($row->i_expire_date)?date($this->conf["site_date_format"],intval($row->i_expire_date)):'N/A';
				  $ret_[$i_cnt]["dt_fn_assigned_date"]= ($row->i_assigned_date) ? date($this->conf["front_job_date_format"],intval($row->i_assigned_date)):'';
				  $s_where = " WHERE i_job_id={$row->id} And i_status!=3";
				  $ret_[$i_cnt]["i_quotes"]=$this->gettotal_job_quote_info($s_where);
				  
				  
				  $ret_[$i_cnt]["s_username"]=stripslashes(htmlspecialchars_decode($row->s_username)); 
				  $ret_[$i_cnt]["s_email"]=stripslashes(htmlspecialchars_decode($row->s_email)); 
				  $ret_[$i_cnt]["s_address"]=stripslashes(htmlspecialchars_decode($row->s_address)); 
				  $ret_[$i_cnt]["s_contact_no"]= stripslashes(htmlspecialchars_decode($row->s_contact_no)); 
				  
				  $ret_[$i_cnt]["s_buyer_name"]=stripslashes(htmlspecialchars_decode($row->s_buyer_name)); 				  
				  
                  $ret_[$i_cnt]["i_is_active"]= intval($row->i_status); 
				  $ret_[$i_cnt]["i_status"]= intval($row->i_status); 
				  $ret_[$i_cnt]["s_is_active"]= $this->db->JOBSTATUS[$row->i_status];
				  
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
	
	
	public function fetch_multi_completed_for_radar_cron($s_where=null,$i_start=null,$i_limit=null)
    {
		
        try
        {
          	$ret_=array();
			$start_time =time() -10800;//strtotime(date('Y-m-d H:i:s'));	
			$end_time	= 	time();
			$s_qry = "SELECT n.*, z.postal_code, s.state, c.city, z.latitude , z.longitude, cat_c.s_name AS s_category_name,
					  tradesman.s_username,  tradesman.s_email, tradesman.s_address, tradesman.s_contact_no, buyer.s_username AS s_buyer_name
					 FROM ".$this->tbl." n "
					//." LEFT JOIN {$this->tbl_cat} cat ON n.i_category_id = cat.id"
					." LEFT JOIN {$this->db->CATEGORYCHILD} cat_c ON cat_c.i_cat_id = n.i_category_id"
					." LEFT JOIN {$this->tbl_zipcode} z ON n.i_zipcode_id = z.id"
					." LEFT JOIN {$this->tbl_state} s ON n.i_province_id = s.id"
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
				  $ret_[$i_cnt]["i_buyer_user_id"]=$row->i_buyer_user_id;
                  $ret_[$i_cnt]["s_title"]=stripslashes(htmlspecialchars_decode($row->s_title)); 
				  $ret_[$i_cnt]["s_part_title"] = string_part($ret_[$i_cnt]["s_title"],40);
				  
				  $ret_[$i_cnt]["s_category_name"]=stripslashes(htmlspecialchars_decode($row->s_category_name)); 
				  $s_desc = stripslashes(htmlspecialchars_decode($row->s_description));
				  if(strlen($s_desc)>197)
				  	$s_desc = substr_replace($s_desc,'...',200);
				  $ret_[$i_cnt]["s_description"]= $s_desc;
				  $ret_[$i_cnt]["d_budget_price"]= doubleval($row->d_budget_price);
				  $ret_[$i_cnt]["s_budget_price"]= doubleval($row->d_budget_price).' '.$this->conf["default_currency"];
				  $ret_[$i_cnt]["s_state"]=stripslashes(htmlspecialchars_decode($row->state)); 
				  $ret_[$i_cnt]["s_city"]=stripslashes(htmlspecialchars_decode($row->city)); 
				  $ret_[$i_cnt]["s_postal_code"]=stripslashes(htmlspecialchars_decode($row->postal_code)); 
				  $ret_[$i_cnt]["i_days_left"] = ($row->i_expire_date)?round(($row->i_expire_date-time()) / 86400):0;
				  $ret_[$i_cnt]["s_days_left"] = ($ret_[$i_cnt]["i_days_left"]>1) ? $ret_[$i_cnt]["i_days_left"].' days' :' 0 day';
				  
                  $ret_[$i_cnt]["dt_entry_date"]= date($this->conf["site_date_format"],intval($row->i_created_date));
				  $ret_[$i_cnt]["dt_completed_date"]= date($this->conf["site_date_format"],intval($row->i_completed_date));
				  $ret_[$i_cnt]["dt_expired_date"]= ($row->i_expire_date)?date($this->conf["site_date_format"],intval($row->i_expire_date)):'N/A';
				  $ret_[$i_cnt]["dt_fn_assigned_date"]= ($row->i_assigned_date) ? date($this->conf["front_job_date_format"],intval($row->i_assigned_date)):'';
				  $s_where = " WHERE i_job_id={$row->id} And i_status!=3";
				  $ret_[$i_cnt]["i_quotes"]=$this->gettotal_job_quote_info($s_where);
				  
				  
				  $ret_[$i_cnt]["s_username"]=stripslashes(htmlspecialchars_decode($row->s_username)); 
				  $ret_[$i_cnt]["s_email"]=stripslashes(htmlspecialchars_decode($row->s_email)); 
				  $ret_[$i_cnt]["s_address"]=stripslashes(htmlspecialchars_decode($row->s_address)); 
				  $ret_[$i_cnt]["s_contact_no"]= stripslashes(htmlspecialchars_decode($row->s_contact_no)); 
				  
				  $ret_[$i_cnt]["s_buyer_name"]=stripslashes(htmlspecialchars_decode($row->s_buyer_name)); 				  
				  
                  $ret_[$i_cnt]["i_is_active"]= intval($row->i_status); 
				  $ret_[$i_cnt]["i_status"]= intval($row->i_status); 
				  $ret_[$i_cnt]["s_is_active"]= $this->db->JOBSTATUS[$row->i_status];
				  
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
          $s_qry="Select n.*, z.postal_code, s.state, c.city, z.latitude s_latitude, z.longitude s_longitude, 
		  			u.s_username,u.s_email, u.s_lat s_buyer_latitide, u.s_lng s_buyer_longitude, trades.s_username s_tradesman_name"
                ." From ".$this->tbl." AS n "
				." INNER JOIN {$this->tbl_user} u ON n.i_buyer_user_id = u.id"
				." LEFT JOIN {$this->tbl_user} trades ON n.	i_tradesman_id = trades.id"
				." LEFT JOIN {$this->tbl_zipcode} z ON n.i_zipcode_id = z.id"
				." LEFT JOIN {$this->tbl_state} s ON n.i_province_id = s.id"
				." LEFT JOIN {$this->tbl_city} c ON n.i_city_id = c.id"
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
				  $ret_["i_category_id"]			=	$row->i_category_id;
				  $ret_["i_city_id"]				=	intval($row->i_city_id);
				  $ret_['s_category']				=	$this->get_category_name($ret_["i_category_id"],$i_lang_id);	  
                  $ret_["s_title"]					=	stripslashes(htmlspecialchars_decode($row->s_title)); 
				  $ret_["s_description"]			=	stripslashes(htmlspecialchars_decode($row->s_description)); 
				  $ret_["d_budget_price"]			=	stripslashes(htmlspecialchars_decode($row->d_budget_price));
				  $ret_["s_budget_price"]			=	$ret_["d_budget_price"].' '.$this->conf["default_currency"];
				  $ret_["i_quoting_period_days"]	=	intval($row->i_quoting_period_days);
				  
				  $ret_["i_approval_date"]			=	intval($row->i_admin_approval_date);
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
				  $ret_["i_lowest_quote"]			=	$this->get_lowet_quote($s_where);  
				  $ret_["s_lowest_quote"]			=	$ret_["i_lowest_quote"].' '.$this->conf["default_currency"];
				  
				  $ret_["s_state"]					=	stripslashes(htmlspecialchars_decode($row->state)); 
				  $ret_["s_city"]					=	stripslashes(htmlspecialchars_decode($row->city)); 
				  $ret_["s_postal_code"]			=	stripslashes(htmlspecialchars_decode($row->postal_code)); 
				  $ret_["s_postal_code"]			=	stripslashes(htmlspecialchars_decode($row->postal_code)); 
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
                  $ret_[$i_cnt]["s_title"]=stripslashes(htmlspecialchars_decode($row->s_title)); 				
				  
                  $ret_[$i_cnt]["dt_entry_date"]= date($this->conf["site_date_format"],intval($row->i_created_date));				  
				 
				  $ret_[$i_cnt]["s_username"]=stripslashes(htmlspecialchars_decode($row->s_username)); 
				  $ret_[$i_cnt]["s_username"] = ($row->i_user_id) ? $ret_[$i_cnt]["s_username"] : 'Admin';
				  $ret_[$i_cnt]["s_message"]=stripslashes(htmlspecialchars_decode($row->s_message));	
				  
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
                  $ret_[$i_cnt]["s_file_name"]	=	stripslashes(htmlspecialchars_decode($row->s_file_name)); 
				  $ret_[$i_cnt]["s_type"]		=	stripslashes(htmlspecialchars_decode($row->s_type));                   
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
			$s_qry = "SELECT n.*, z.postal_code, s.state, c.city,pay.i_payment_date,pay.d_pay_amount,pay.i_invoice_no,tradesman.s_username, tradesman.s_address 
					 FROM ".$this->tbl." n "
					." LEFT JOIN {$this->tbl_zipcode} z ON n.i_zipcode_id = z.id"
					." LEFT JOIN {$this->tbl_state} s ON n.i_province_id = s.id"
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
				  $ret_[$i_cnt]["i_buyer_user_id"]=$row->i_buyer_user_id;
                  $ret_[$i_cnt]["s_title"]=get_unformatted_string($row->s_title); 
				  $ret_[$i_cnt]["s_part_title"] = get_unformatted_string($row->s_title); 
				//   $ret_[$i_cnt]["s_part_title"] = string_part($ret_[$i_cnt]["s_title"],20);
				  $s_desc = get_unformatted_string(htmlspecialchars_decode($row->s_description));
				  if(strlen($s_desc)>197)
				  	$s_desc = substr_replace($s_desc,'...',200);
				  //$ret_[$i_cnt]["s_description"]= $s_desc;
				  $ret_[$i_cnt]["d_budget_price"]= doubleval($row->d_budget_price);
				  $ret_[$i_cnt]["s_budget_price"]= doubleval($row->d_budget_price).' '.$this->conf["default_currency"];
				  $ret_[$i_cnt]["s_state"]=get_unformatted_string($row->state); 
				  $ret_[$i_cnt]["s_city"]=get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["s_postal_code"]=get_unformatted_string($row->postal_code); 			  
				  
				  
				  $ret_[$i_cnt]["s_username"]=get_unformatted_string($row->s_username); 
				  //$ret_[$i_cnt]["s_email"]=get_unformatted_string($row->s_email); 
				  $ret_[$i_cnt]["s_address"]=get_unformatted_string($row->s_address); 
				  //$ret_[$i_cnt]["s_contact_no"]= get_unformatted_string($row->s_contact_no); 
				  $ret_[$i_cnt]["dt_payment_date"]= date($this->conf["site_date_format"],intval($row->i_payment_date));
				  $ret_[$i_cnt]["s_paid_amount"]= doubleval($row->d_pay_amount).' '.$this->conf["default_currency"];
				  $ret_[$i_cnt]["i_invoice_no"]=get_unformatted_string($row->i_invoice_no); 
				  
				  
                  
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
                  $ret_["s_name"]			=	stripslashes(htmlspecialchars_decode($row->s_name)); 		  
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
          $s_qry="Select n.id,cat_c.s_name AS s_category_name "
                ."From ".$this->tbl_cat." AS n "
				." LEFT JOIN {$this->db->CATEGORYCHILD} cat_c ON cat_c.i_cat_id = n.id"
                ." Where n.id=? AND i_lang_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id),intval($i_lang_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]				=	$row->id;////always integer		 
                  $ret_["s_category_name"]			=	stripslashes(htmlspecialchars_decode($row->s_category_name)); 		  
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
				 $s_qry.=" s_commission_greater_than_100=? ";
                $s_qry.=", s_commission_slab_100=? ";
                $s_qry.=", i_is_active=? ";
                $s_qry.=", dt_entry_date=? ";
                $s_qry.=" Where i_id=? ";
                
                $this->db->query($s_qry,array(
												  trim(htmlspecialchars($info["s_up_slab"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_below_slab"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_status"]),
												  intval($info["dt_entry_date"]),
												  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   

                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  trim(htmlspecialchars($info["s_up_slab"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_below_slab"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_status"]),
												  intval($info["dt_entry_date"]),
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
	
	/* get lowest quote of the job*/
	public function get_lowet_quote($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select n.d_quote "
                ."From ".$this->tbl_job_quotes." n "
                .($s_where!=""?$s_where:"" ) ." ORDER BY d_quote ASC LIMIT 0,1";
          $rs=$this->db->query($s_qry);		  
          $i_cnt=0;
		  if($rs)
		  {
              foreach($rs->result() as $row)
              {
                  $ret_=intval($row->d_quote); 
              }   
		 }	   
          
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
												  '',
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
												  '',
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
                ."From ".$this->tbl." WHERE id=$i_job_id "
					
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
    public function fetch_quote_multi($s_where=null,$i_start=null,$i_limit=null,$i_lang_id=1)
    {
		
        try
        {
			//echo $i_lang_id;
          	$ret_=array();
			$s_qry = "SELECT n.*, tradesman.s_username, tradesman.s_name,tradesman.i_signup_lang, tradesman.s_email, tradesman.id i_tradesman_id, c.city
					 FROM ".$this->tbl_job_quotes." n "
					." LEFT JOIN {$this->tbl_user} tradesman ON n.i_tradesman_user_id = tradesman.id"
					." LEFT JOIN {$this->tbl_city} c ON tradesman.i_city = c.id"
                .($s_where!=""?$s_where:"" )." ORDER BY n.i_created_date DESC" .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
		  //echo $s_qry;
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
				  $ret_[$i_cnt]["i_job_id"]=$row->i_job_id;
				  $ret_[$i_cnt]["i_job_status"]=$this->get_job_status($row->i_job_id); 
				  $ret_[$i_cnt]["i_tradesman_id"]=intval($row->i_tradesman_id);////always integer
                  $ret_[$i_cnt]["s_username"]=get_unformatted_string($row->s_username); 
				  $ret_[$i_cnt]["s_name"]=get_unformatted_string($row->s_name); 
				  $ret_[$i_cnt]["s_email"]	=get_unformatted_string($row->s_email); 
				  $ret_[$i_cnt]["i_signup_lang"]	= intval($row->i_signup_lang); 
				  
				  $ret_[$i_cnt]["s_status"]	=$this->db->QUOTESTATE[$row->i_status]; 
				  $ret_[$i_cnt]["i_status"]	=$row->i_status; 
				  $ret_[$i_cnt]["s_city"]	=get_unformatted_string($row->city); 
				  $ret_[$i_cnt]["d_quote"]=doubleval($row->d_quote); 
				  $ret_[$i_cnt]["s_quote"]=doubleval($row->d_quote).' '.$this->conf["default_currency"];
				  $ret_[$i_cnt]["dt_entry_date"]= date($this->conf["site_date_format"],intval($row->i_created_date));
				  $ret_[$i_cnt]["job_details"] = $this->fetch_this($row->i_job_id,$i_lang_id);
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
          $s_qry="Select count(*) as i_total "
                ."FROM ".$this->tbl_job_quotes." n "
					." LEFT JOIN {$this->tbl_user} tradesman ON n.i_tradesman_user_id = tradesman.id"
					." LEFT JOIN {$this->tbl_city} c ON tradesman.i_city = c.id"
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
					//." LEFT JOIN {$this->tbl_cat} cat ON n.i_category_id = cat.id"
					." LEFT JOIN {$this->db->CATEGORYCHILD} cat_c ON cat_c.i_cat_id = n.i_category_id"
					." LEFT JOIN {$this->tbl_zipcode} z ON n.i_zipcode_id = z.id"
					." LEFT JOIN {$this->tbl_state} s ON n.i_province_id = s.id"
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
					//." LEFT JOIN {$this->tbl_cat} cat ON n.i_category_id = cat.id"
					." LEFT JOIN {$this->db->CATEGORYCHILD} cat_c ON cat_c.i_cat_id = n.i_category_id"
					." LEFT JOIN {$this->tbl_zipcode} z ON n.i_zipcode_id = z.id"
					." LEFT JOIN {$this->tbl_state} s ON n.i_province_id = s.id"
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
	
	
	
	public function gettotal_job_invitation($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl." n "
					." LEFT JOIN {$this->tbl_cat} cat ON n.i_category_id = cat.id"
					." LEFT JOIN {$this->db->CATEGORYCHILD} cat_c ON cat_c.i_cat_id = cat.id"
					." LEFT JOIN {$this->tbl_zipcode} z ON n.i_zipcode_id = z.id"
					." LEFT JOIN {$this->tbl_state} s ON n.i_province_id = s.id"
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
	
	
	
	
	
    public function __destruct()
    {}                 
  
  
}
///end of class
?>