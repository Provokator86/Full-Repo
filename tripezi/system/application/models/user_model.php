<?php
/*********
* Author: Koushik Rout
* Date  : 28 DEC 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
* Model For User
* 
* @package User
* @subpackage User
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/manage_user.php
* @link views/fe/manage_user/
*/



class User_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
	private $tbl_country;
	private $tbl_state;
	private $tbl_property;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl 			= $this->db->USER;  
		  $this->tbl_country 	= $this->db->COUNTRY;
		  $this->tbl_state 		= $this->db->STATE;
		  $this->tbl_property 	= $this->db->PROPERTY;        
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
            $s_qry="SELECT c.s_country,s.s_state,n.* FROM ".$this->tbl." n "
				." LEFT JOIN ".$this->tbl_country." c ON c.i_id = n.i_country_id "
				." LEFT JOIN ".$this->tbl_state." s ON s.i_id = n.i_state_id "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
                  {
				  $ret_[$i_cnt]["id"]               	= intval($row->i_id);////always integer
				  $ret_[$i_cnt]["s_first_name"]     	= get_unformatted_string($row->s_first_name); 
				  $ret_[$i_cnt]["s_last_name"]      	= get_unformatted_string($row->s_last_name); 
				  $ret_[$i_cnt]["s_email"]          	= get_unformatted_string($row->s_email);
				  $ret_[$i_cnt]["s_phone_number"]     	= get_unformatted_string($row->s_phone_number); 
				  $ret_[$i_cnt]["s_facebook_address"]   = get_unformatted_string($row->s_facebook_address); 
				  $ret_[$i_cnt]["s_twitter_address"]    = get_unformatted_string($row->s_twitter_address);
				  $ret_[$i_cnt]["s_linkedin_address"]   = get_unformatted_string($row->s_linkedin_address); 
				  $ret_[$i_cnt]["s_about_me"]      		= get_unformatted_string($row->s_about_me); 
				  $ret_[$i_cnt]["s_image"]          	= get_unformatted_string($row->s_image);
				  $ret_[$i_cnt]["s_last_ip_address"]    = get_unformatted_string($row->s_last_ip_address); 
				  
				  $ret_[$i_cnt]["dt_created_on"]		= date($this->conf["site_date_format"],intval($row->dt_created_on));
				  $ret_[$i_cnt]["dt_last_login"]		= date($this->conf["site_date_format"],intval($row->dt_last_login));		 
				  $ret_[$i_cnt]["i_status"]      		= intval($row->i_status); 
				  $ret_[$i_cnt]["s_status"]      		= (intval($row->i_status)==1?"Active":"Inactive");
				  
				  $ret_[$i_cnt]["i_phone_verified"]    	= intval($row->i_phone_verified); 
				  $ret_[$i_cnt]["i_facebook_verified"]  = intval($row->i_facebook_verified); 
				  $ret_[$i_cnt]["i_twitter_verified"]   = intval($row->i_twitter_verified); 
                  $ret_[$i_cnt]["i_linkedin_verified"]  = intval($row->i_linkedin_verified);
                   
                  $ret_[$i_cnt]["i_country_id"]         = intval($row->i_country_id); 
                  $ret_[$i_cnt]["i_state_id"]           = intval($row->i_state_id); 
                  $ret_[$i_cnt]["s_city"]               = get_unformatted_string($row->s_city); 
				  $ret_[$i_cnt]["s_address"]            = get_unformatted_string($row->s_address); 
				  $ret_[$i_cnt]["s_country"]            = get_unformatted_string($row->s_country); 
				  $ret_[$i_cnt]["s_state"]            	= get_unformatted_string($row->s_state); 
                  
                  $i_cnt++; //Incerement row
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
    }   //End of function fetch_multi
	
	
	public function fetch_multi_sorted_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {
          $ret_=array();
		  $s_qry="SELECT n.* FROM ".$this->tbl." n "
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		
			//echo $s_qry;
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  $ret_[$i_cnt]["id"]               	= intval($row->i_id);////always integer
				  $ret_[$i_cnt]["s_first_name"]     	= get_unformatted_string($row->s_first_name); 
				  $ret_[$i_cnt]["s_last_name"]      	= get_unformatted_string($row->s_last_name); 
				  $ret_[$i_cnt]["s_email"]          	= get_unformatted_string($row->s_email);
				  $ret_[$i_cnt]["s_phone_number"]     	= get_unformatted_string($row->s_phone_number); 
				  $ret_[$i_cnt]["s_facebook_address"]   = get_unformatted_string($row->s_facebook_address); 
				  $ret_[$i_cnt]["s_twitter_address"]    = get_unformatted_string($row->s_twitter_address);
				  $ret_[$i_cnt]["s_linkedin_address"]   = get_unformatted_string($row->s_linkedin_address); 
				  $ret_[$i_cnt]["s_about_me"]      		= get_unformatted_string($row->s_about_me); 
				  $ret_[$i_cnt]["s_image"]          	= get_unformatted_string($row->s_image);
				  $ret_[$i_cnt]["s_last_ip_address"]    = get_unformatted_string($row->s_last_ip_address); 
				  
				  $ret_[$i_cnt]["dt_created_on"]		= date($this->conf["site_date_format"],intval($row->dt_created_on));
				  $ret_[$i_cnt]["dt_last_login"]		= date($this->conf["site_date_format"],intval($row->dt_last_login));		 
				  $ret_[$i_cnt]["i_status"]      		= intval($row->i_disabled); 
				  $ret_[$i_cnt]["s_status"]      		= (intval($row->i_disabled)==1?"Active":"Inactive");
				  
				  $ret_[$i_cnt]["i_phone_verified"]    	= intval($row->i_phone_verified); 
				  $ret_[$i_cnt]["i_facebook_verified"]  = intval($row->i_facebook_verified); 
				  $ret_[$i_cnt]["i_twitter_verified"]   = intval($row->i_twitter_verified); 
				  $ret_[$i_cnt]["i_linkedin_verified"]  = intval($row->i_linkedin_verified); 
                  
                  $i_cnt++; //Incerement row
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
          unset($s_qry,$rs,$row,$i_cnt,$s_where);
          return $ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }  //End of function gettotal_info        
    

    
    
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
          $s_qry="Select n.*,co.s_country,s.s_state "
                ."From ".$this->tbl." AS n "
                ." LEFT JOIN ".$this->tbl_country." co       ON n.i_country_id=co.i_id "
                ." LEFT JOIN ".$this->tbl_state." s          ON n.i_state_id=s.i_id "
                ." Where n.i_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id)));           
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  $ret_["id"]               	= intval($row->i_id);////always integer
				  $ret_["s_first_name"]     	= get_unformatted_string($row->s_first_name); 
				  $ret_["s_last_name"]      	= get_unformatted_string($row->s_last_name); 
				  $ret_["s_email"]          	= get_unformatted_string($row->s_email);
				  $ret_["s_password"]          	= get_unformatted_string($row->s_password);
				  $ret_["s_phone_number"]     	= get_unformatted_string($row->s_phone_number); 
				  $ret_["s_facebook_address"]   = get_unformatted_string($row->s_facebook_address); 
				  $ret_["s_twitter_address"]    = get_unformatted_string($row->s_twitter_address);
				  $ret_["s_linkedin_address"]   = get_unformatted_string($row->s_linkedin_address); 
				  $ret_["s_about_me"]      		= get_unformatted_string($row->s_about_me); 
				  $ret_["s_image"]          	= get_unformatted_string($row->s_image);
				  $ret_["s_last_ip_address"]    = get_unformatted_string($row->s_last_ip_address); 
				  $ret_["s_paypal_details"]     = get_unformatted_string($row->s_paypal_details); 
                  
				  $ret_["dt_created_on"]		= date($this->conf["site_date_format"],intval($row->dt_created_on));
				  $ret_["dt_last_login"]		= ($row->dt_last_login!=0)?date($this->conf["site_date_format"],intval($row->dt_last_login)):"Not login till now";		 
				  $ret_["i_status"]      		= intval($row->i_status); 
				  $ret_["s_status"]      		= (intval($row->i_status)==1?"Active":"Inactive");
				  
				  $ret_["i_phone_verified"]    	= intval($row->i_phone_verified); 
				  $ret_["i_facebook_verified"]  = intval($row->i_facebook_verified); 
				  $ret_["i_twitter_verified"]   = intval($row->i_twitter_verified); 
				  $ret_["i_linkedin_verified"]  = intval($row->i_linkedin_verified); 
                  $ret_["i_country_id"]         = intval($row->i_country_id); 
                  $ret_["i_state_id"]           = intval($row->i_state_id); 
                  $ret_["s_city"]               = get_unformatted_string($row->s_city); 
                  $ret_["s_address"]            = get_unformatted_string($row->s_address);
                  $ret_["s_paypal_details"]     = get_unformatted_string($row->s_paypal_details);
                  $ret_["s_country"]            = get_unformatted_string($row->s_country); 
                  $ret_["s_state"]            	= get_unformatted_string($row->s_state);
				  $ret_["i_owner_checked"]    	= intval($row->i_owner_checked); 
				  $ret_["i_traveler_checked"]  	= intval($row->i_traveler_checked);
                  
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
    }  //End of function fetch_this     
	
	
	 /*******
    * Fetches One user and his properties from db .
    * 
    * @param int $i_id
    * @returns array
    */
    public function fetch_user_profile($i_id)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="SELECT n.*,c.s_country,s.s_state "
                ."FROM ".$this->tbl." AS n "
				." LEFT JOIN ".$this->tbl_country." c ON c.i_id = n.i_country_id "
				." LEFT JOIN ".$this->tbl_state." s ON s.i_id = n.i_state_id "
                ." Where n.i_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id)));           
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  $ret_["id"]               	= intval($row->i_id);////always integer
				  $ret_["s_first_name"]     	= get_unformatted_string($row->s_first_name); 
				  $ret_["s_last_name"]      	= get_unformatted_string($row->s_last_name); 
				  $ret_["s_email"]          	= get_unformatted_string($row->s_email);
				  $ret_["s_phone_number"]     	= get_unformatted_string($row->s_phone_number); 
				  $ret_["s_facebook_address"]   = get_unformatted_string($row->s_facebook_address); 
				  $ret_["s_twitter_address"]    = get_unformatted_string($row->s_twitter_address);
				  $ret_["s_linkedin_address"]   = get_unformatted_string($row->s_linkedin_address); 
				  $ret_["s_about_me"]      		= get_unformatted_string($row->s_about_me); 
				  $ret_["s_image"]          	= get_unformatted_string($row->s_image);
				  $ret_["s_last_ip_address"]    = get_unformatted_string($row->s_last_ip_address); 				  
				  $ret_["dt_created_on"]		= date($this->conf["site_date_format"],intval($row->dt_created_on));
				  $ret_["dt_last_login"]		= date($this->conf["site_date_format"],intval($row->dt_last_login));		 
				  $ret_["i_status"]      		= intval($row->i_status); 
				  $ret_["s_status"]      		= (intval($row->i_status)==1?"Active":"Inactive");				  
				  $ret_["i_phone_verified"]    	= intval($row->i_phone_verified); 
				  $ret_["i_facebook_verified"]  = intval($row->i_facebook_verified); 
				  $ret_["i_twitter_verified"]   = intval($row->i_twitter_verified); 
				  $ret_["i_linkedin_verified"]  = intval($row->i_linkedin_verified); 
				  $ret_["s_city_name"]  		= get_unformatted_string($row->s_city_name);
				  $ret_["s_address"]  			= get_unformatted_string($row->s_address);
				  
				  $ret_["s_country"]     		= get_unformatted_string($row->s_country);
				  $ret_["s_state"]     			= get_unformatted_string($row->s_state);
				  
				  /*$CI	=	& get_instance();
				  $CI->load->model('property_model');
				  $s_where	=	"WHERE p.i_owner_user_id = ".$ret_["id"]." ";
				  $order_name	=	" p.dt_created_on";
				  $order_by		=	" DESC";
				  $ret_["property"]    			= $CI->property_model->fetch_multi_sorted_list($s_where,$order_name,$order_by);*/
				  
                  
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
    }  //End of function fetch_this             
     
     
        
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
                $s_qry.=", i_status=? ";
                
                $this->db->query($s_qry,array(
                                                  trim(htmlspecialchars($info["s_username"], ENT_QUOTES, 'utf-8')),
                                                  trim(htmlspecialchars($info["s_name"], ENT_QUOTES, 'utf-8')),
                                                  trim(htmlspecialchars($info["s_email"], ENT_QUOTES, 'utf-8')),
                                                  intval($info["i_status"])
                                                 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
                                                  trim(htmlspecialchars($info["s_username"], ENT_QUOTES, 'utf-8')),
                                                  trim(htmlspecialchars($info["s_name"], ENT_QUOTES, 'utf-8')),
                                                  trim(htmlspecialchars($info["s_email"], ENT_QUOTES, 'utf-8')),
                                                  intval($info["i_status"])
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
                $s_qry  = "UPDATE ".$this->tbl." SET ";
                $s_qry.=" s_first_name=? ";
                $s_qry.=", s_last_name=? ";
                $s_qry.=", s_email=? ";
                $s_qry.=", s_phone_number=? ";
				$s_qry.=", s_facebook_address=? ";
				$s_qry.=", s_twitter_address=? ";
				$s_qry.=", s_linkedin_address=? ";
				$s_qry.=", s_about_me=? ";
                $s_qry.=", s_image=? ";
                $s_qry.=", i_country_id=? ";
                $s_qry.=", i_state_id=? ";
                $s_qry.=", s_city=? ";
				$s_qry.=", s_address=? ";
                $s_qry.=", dt_updated_on=? ";
                $s_qry.=", i_phone_verified=? ";
              
                $s_qry.=", i_facebook_verified='".$info["i_facebook_verified"]."'";                    
                $s_qry.=", i_linkedin_verified='".$info["i_linkedin_verified"]."'";                    
                $s_qry.=", i_twitter_verified='".$info["i_twitter_verified"]."'";                    
               
               
                
				if($info["s_verification_code"])
                {
                    $s_qry.=", i_status=".$info["i_status"];
                    $s_qry.=", s_verification_code='".get_formatted_string($info["s_verification_code"])."'";
                    
                }
                $s_qry.=", s_paypal_details=? ";  
                $s_qry.=" WHERE i_id=? ";
                
                $i_ret_ = $this->db->query($s_qry,array(
                                                get_formatted_string($info["s_first_name"]),
                                                get_formatted_string($info["s_last_name"]),
                                                get_formatted_string($info["s_email"]),
                                                get_formatted_string($info["s_phone_number"]),
												get_formatted_string($info["s_facebook_address"]),
                                                get_formatted_string($info["s_twitter_address"]),
                                                get_formatted_string($info["s_linkedin_address"]),
                                                get_formatted_string($info["s_about_me"]),
                                                get_formatted_string($info["s_image"]),
                                                intval($info["i_country_id"]),
                                                intval($info["i_state_id"]),
                                                get_formatted_string($info["s_city"]),
												get_formatted_string($info["s_address"]),
                                                time(),
                                                intval($info["i_phone_verified"]), 
                                                get_formatted_string($info["s_paypal_details"]),   
                                                intval($i_id)
                                                     ));
                //$i_ret_=$this->db->affected_rows();                         
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
					
                                                get_formatted_string($info["s_first_name"]),
                                                get_formatted_string($info["s_last_name"]),
                                                get_formatted_string($info["s_email"]),
                                                get_formatted_string($info["s_phone_number"]),
                                                get_formatted_string($info["s_facebook_address"]),
                                                get_formatted_string($info["s_twitter_address"]),
                                                get_formatted_string($info["s_linkedin_address"]),
                                                get_formatted_string($info["s_about_me"]),
                                                get_formatted_string($info["s_image"]),
                                                intval($info["i_country_id"]),
                                                intval($info["i_state_id"]),
                                                get_formatted_string($info["s_city"]),
                                                get_formatted_string($info["s_address"]),
                                                time(),
                                                intval($info["i_phone_verified"]),
                                                get_formatted_string($info["s_paypal_details"]),   
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
    
    
    public function edit_info_admin($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry  = "UPDATE ".$this->tbl." SET ";
                $s_qry.=" s_first_name=? ";
                $s_qry.=", s_last_name=? ";
                $s_qry.=", s_email=? ";
                $s_qry.=", s_phone_number=? ";
                $s_qry.=", s_facebook_address=? ";
                $s_qry.=", s_twitter_address=? ";
                $s_qry.=", s_linkedin_address=? ";
                $s_qry.=", s_about_me=? ";
                $s_qry.=", s_image=? ";
                $s_qry.=", i_country_id=? ";
                $s_qry.=", i_state_id=? ";
                $s_qry.=", s_city=? ";
                $s_qry.=", s_address=? ";
  
                $s_qry.=", s_paypal_details=? ";  
                $s_qry.=" WHERE i_id=? ";
                
                $i_ret_ = $this->db->query($s_qry,array(
                                                get_formatted_string($info["s_first_name"]),
                                                get_formatted_string($info["s_last_name"]),
                                                get_formatted_string($info["s_email"]),
                                                get_formatted_string($info["s_phone_number"]),
                                                get_formatted_string($info["s_facebook_address"]),
                                                get_formatted_string($info["s_twitter_address"]),
                                                get_formatted_string($info["s_linkedin_address"]),
                                                get_formatted_string($info["s_about_me"]),
                                                get_formatted_string($info["s_image"]),
                                                intval($info["i_country_id"]),
                                                intval($info["i_state_id"]),
                                                get_formatted_string($info["s_city"]),
                                                get_formatted_string($info["s_address"]), 
                                                get_formatted_string($info["s_paypal_details"]),   
                                                intval($i_id)
                                                     ));
                //$i_ret_=$this->db->affected_rows();                         
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
                    
                                                get_formatted_string($info["s_first_name"]),
                                                get_formatted_string($info["s_last_name"]),
                                                get_formatted_string($info["s_email"]),
                                                get_formatted_string($info["s_phone_number"]),
                                                get_formatted_string($info["s_facebook_address"]),
                                                get_formatted_string($info["s_twitter_address"]),
                                                get_formatted_string($info["s_linkedin_address"]),
                                                get_formatted_string($info["s_about_me"]),
                                                get_formatted_string($info["s_image"]),
                                                intval($info["i_country_id"]),
                                                intval($info["i_state_id"]),
                                                get_formatted_string($info["s_city"]),
                                                get_formatted_string($info["s_address"]),
                                                get_formatted_string($info["s_paypal_details"]),   
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
        {}
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
   * This function call time of registration form user controler
   *  
   * @param mixed $info
   */
    public function create_an_account($info)
    {
        try
        {
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl." Set ";
                $s_qry.=" s_first_name=? ";
                $s_qry.=", s_last_name=? ";
                if(isset($info["s_password"]) && !empty($info["s_password"]))
                {
                    $s_password = md5(trim($info["s_password"]).$this->conf["security_salt"]);
                    $s_qry.=", s_password= '".$s_password."' ";
                }
                $s_qry.=", s_email=? ";
                $s_qry.=", s_verification_code=? ";
                $s_qry.=", i_status=? ";
                $s_qry.=", dt_created_on=? ";
                
                $i_ret_ = $this->db->query($s_qry,array(
                                            get_formatted_string($info["s_first_name"]),
                                            get_formatted_string($info["s_last_name"]),
                                            get_formatted_string($info["s_email"]),
                                            get_formatted_string($info["s_verification_code"]),
                                            intval($info["i_status"]),
                                            $info["dt_created_on"]
                                            ));
                                             if($i_ret_)
                {
                    
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
                                             get_formatted_string($info["s_first_name"]),
                                            get_formatted_string($info["s_last_name"]),
                                            get_formatted_string($info["s_email"]),
                                            get_formatted_string($info["s_verification_code"]),
                                            intval($info["i_status"]),
                                            $info["dt_created_on"]
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
    
    
    
   
    
    /****
* to generate verification code after registration
*
*/

function genVerificationCode() 
    {
    
        try
        {
            
             $num_length = 10;
             $char_length = 2;
             $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
             $characters = '0123456789';
             $string = ''; 
             $string1 = '';   
              for ($p = 0; $p < $char_length; $p++) 
                {
                    $string1 .= $char[mt_rand(0, strlen($char))];
                }
              for ($p = 0; $p < $num_length; $p++)
                 {
                    $string .= $characters[mt_rand(0, strlen($characters))];
                 }
             $final_string = $string1.'-'.$string;
             $sql = "SELECT * FROM {$this->tbl} WHERE s_verification_code='".$final_string."'";
             $query=$this->db->query($sql);
             if($query->num_rows()>0)
                {
                     $this->genVerificationCode();
                }
             else    
                 return $final_string;
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
         
    }
    
    /**
    * This function match the security code and and active account.
    *  
    */
    function active_account($s_verification_code)
    {
        try
        {
            $i_aff  =   0;
            $s_qry  =   " UPDATE ".$this->tbl." SET i_status=1 WHERE i_status=0 AND s_verification_code ='".$s_verification_code."' ";
            $i_aff  =   $this->db->query($s_qry);
            
            return $i_aff;
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	public function check_password($login_data,$id)
    {

        try
        {
			
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="SELECT s_email,s_first_name,i_status From ".$this->tbl." 
		  			WHERE s_password='".md5(trim($login_data).$this->conf["security_salt"])."' ";
					
		  $s_qry.="And i_id=".$id." ";			
          $s_qry.="And i_status=1 ";
		  /////Added the salt value with the password///	
		  
          $rs=$this->db->query($s_qry,$stmt_val);
		  //echo $this->db->last_query();
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_["id"]=$row->i_id;////always integer
                  $ret_["s_email"]=stripslashes($row->s_email);                   
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
	
	 /* This function set new password */
    public function set_new_password($info,$s_email)
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
                $s_qry.=" Where s_email=? ";
                
                $i_ret_ = $this->db->query($s_qry,array(
                                                  $s_email

											 ));
                //$i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
                                                  $s_email

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
    
    public function __destruct()
    {}                 
  
  
}
///end of class
?>