<?php
/*********
* Author: Sahinul Haque
* Date  : 15 Nov 2010
* Modified By: 
* Modified Date:
* Purpose:
*  Model For User Login
* @package User
* @subpackage Login
* @includes infModel.php 
* @includes MY_Model.php
* @link MY_Model.php
*/


class User_login extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
	private $tbl_frontend_user;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl=$this->db->ADMIN;      
		  $this->tbl_frontend_user=$this->db->USER;  
          $this->conf=&get_config();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }

    /*******
    * Login and save loggedin values.
    * 
    * @param array $login_data, login[field_name]=value
    * @returns true if success and false
    */
    public function login($login_data)
    {

        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="SELECT i_id,s_user_name,s_first_name,s_last_name,i_is_deleted,i_user_type_id FROM ".$this->tbl." 
		  		WHERE s_user_name=?";
          $s_qry.=" And s_password=? ";
          $s_qry.="And i_is_deleted=0 ";
		  $s_qry.="And i_status=1 ";
		  
          
          $stmt_val["s_user_name"]= htmlspecialchars(trim($login_data["s_user_name"]));
          /////Added the salt value with the password///
		  
		  
          $stmt_val["s_password"]= md5(trim($login_data["s_password"]).$this->conf["security_salt"]);
		  
		  
		  
          $rs=$this->db->query($s_qry,$stmt_val);
		 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_["id"]=$row->i_id;////always integer
                  $ret_["s_user_name"]=stripslashes($row->s_user_name); 
                  $ret_["s_first_name"]=trim($row->s_first_name); 
                  $ret_["s_last_name"]=trim($row->s_last_name);
				  $ret_["i_user_type_id"]=intval($row->i_user_type_id);
                  $ret_["dt_created_on"]=date($this->conf["site_date_format"],intval($row->dt_created_on)); 
                  $ret_["i_is_deleted"]=intval($row->i_is_deleted); 
                  $ret_["s_is_deleted"]=(intval($row->i_is_deleted)==1?"Removed":"Active"); 
                  
                  ////////saving logged in user data into session////
                  $this->session->set_userdata(array(
                                                    "admin_loggedin"=> array(
                                                    "user_id"=> encrypt(intval($ret_["id"])),
													"user_type_id"=> encrypt(intval($ret_["i_user_type_id"])),
                                                    "user_name"=> $ret_["s_user_name"],
                                                    "user_fullname"=> $ret_["s_first_name"]." ".$ret_["s_last_name"],
                                                    "user_status"=> $ret_["s_is_deleted"])       
                                                ));
                  ////////end saving logged in user data into session////
                  //////////log report///
                    $logi["msg"]="Logged in as ".$ret_["s_first_name"]." ".$ret_["s_last_name"]
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
    
    /**
    * author koushik
    * 
    * This is a modified frontend login function
    * by fconnect one can login
    * And super admin can login by his master password
    * 
    * @param mixed $login_data
    * @param mixed $via_fconnect
    * @return int
    */
	
	 public function front_login($login_data,$via_fconnect=false)
    {

        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          if($via_fconnect==false)
          {
              $s_qry="Select i_id,s_first_name,s_last_name,s_email,i_status,dt_created_on,i_disabled,s_image  
               From ".$this->tbl_frontend_user." Where s_email=? ";
              $s_qry.=" And s_password=? ";
              $s_qry.="And i_status=1 ";
              
             
              
              $stmt_val["s_email"]= get_formatted_string($login_data["s_email"]);
      
              /////Added the salt value with the password///          
              $stmt_val["s_password"]= md5(trim($login_data["s_password"]).$this->conf["security_salt"]);
              
          }
          else // via fconnect
          {
              $s_qry="Select i_id,s_first_name,s_last_name,s_email,i_status,dt_created_on,s_image,i_disabled   
               From ".$this->tbl_frontend_user." Where  s_email=?  ";

              $stmt_val["s_email"]= get_formatted_string($login_data["s_email"]);
          }
          
		  
		  
          $rs=$this->db->query($s_qry,$stmt_val);  // return result set
          
          if($rs->num_rows()==0 && $via_fconnect==false) // if no of row is 0 or no not matched
          {
              // Check email exist or not
              $s_qry="Select i_id,s_first_name,s_last_name,s_email,i_status,dt_created_on,s_image  
              From ".$this->tbl_frontend_user." Where s_email=? ";

              $stmt_val["s_email"]= get_formatted_string($login_data["s_email"]);
      
              $rs1=$this->db->query($s_qry,$stmt_val); 
              
              if($rs1->num_rows()>0) // If email exists
              {
                  // Check for the master password by given by admin
                  $s_qry="Select *  
                  From ".$this->tbl." Where s_password=? ";
                  $s_val["s_password"]= md5(trim($login_data["s_password"]).$this->conf["security_salt"]); // check password from admin table
                  
                  $rs2 =  $this->db->query($s_qry,$s_val);
                  
                  if($rs2->num_rows()>0)
                  {
                      foreach($rs1->result() as $row)
                      {
                          $ret_["id"]           =   $row->i_id;////always integer
                          $ret_["s_first_name"] =   get_unformatted_string($row->s_first_name); 
                          $ret_["s_last_name"]  =   get_unformatted_string($row->s_last_name); 
                          $ret_["s_email"]      =   get_unformatted_string($row->s_email);
                          $ret_["s_image"]      =   get_unformatted_string($row->s_image);
                          
                          $ret_["dt_created_on"]=   date($this->conf["site_date_format"],intval($row->dt_created_on)); 
                          $ret_["i_status"]     =   intval($row->i_status); 
                          $ret_["s_status"]     =   (intval($row->i_status)==1?"Active":"Inactive"); 

                      }
                      
                  }
              }
              
          }

		  //echo $this->db->last_query();
          else if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_["id"]           =   $row->i_id;////always integer
                  $ret_["s_first_name"] =   get_unformatted_string($row->s_first_name); 
                  $ret_["s_last_name"]  =   get_unformatted_string($row->s_last_name); 
                  $ret_["s_email"]      =   get_unformatted_string($row->s_email);
				  $ret_["s_image"]      =   get_unformatted_string($row->s_image);
				  
                  $ret_["dt_created_on"]=   date($this->conf["site_date_format"],intval($row->dt_created_on)); 
                  $ret_["i_status"]     =   intval($row->i_status); 
                  $ret_["s_status"]     =   (intval($row->i_status)==1?"Active":"Inactive"); 
                  $ret_["i_disabled"]   =   intval($row->i_disabled);  

              }
               if($ret_["i_disabled"]==0)
               {
                   return 'account_disable';
               }
              
              if($via_fconnect && $ret_["i_status"]==0)
              {
                  $s_qry    =   " UPDATE ".$this->tbl_frontend_user." SET i_status=1 WHERE i_id=".$ret_["id"] ;
                  $rs=$this->db->query($s_qry);
                  $ret_["i_status"]     =   1; 
                  $ret_["s_status"]     =   (intval($row->i_status)==1?"Active":"Inactive");
              }	     
              
               //// Update last login date ///
              $s_qry    =   " UPDATE ".$this->tbl_frontend_user." SET dt_last_login =".time().
              " WHERE i_id=".intval($ret_["id"]) ;
              
              $i_aff    =   $this->db->query($s_qry);
              

              $rs->free_result();          
          }
          // Set the array to the session
           if($ret_)
              {
                  ////////saving logged in user data into session////
                  $this->session->set_userdata(array(
                                                    "loggedin"=> array(
                                                    "user_id"=> encrypt(intval($ret_["id"])),
                                                
                                                    "user_first_name"=> $ret_["s_first_name"],
                                                    "user_last_name"=> $ret_["s_last_name"],
                                                    
                                                    "user_email"=> $ret_["s_email"],
                                                    "user_image"=> $ret_["s_image"],
                                                    "user_status"=> $ret_["s_status"])     
                                                ));
                  ////////end saving logged in user data into session////
                  
                 
                  
              }
        
          unset($s_qry,$rs,$row,$login_data,$stmt_val);
          return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    

    
	
	/* update last login date */
	
	public function update_login_date($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl_frontend_user." Set ";
                $s_qry.=" i_last_login_date=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(    
                                                      intval($info["i_last_login_date"]),
													  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl_frontend_user." ";
                    $logi["sql"]= serialize(array($s_qry,array(    
                                                      intval($info["i_last_login_date"]),
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
   * This function call time of registration form user controler
   *  
   * @param mixed $info
   */
    public function create_an_account_by_fconnect($info)
    {
        try
        {
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl_frontend_user." Set ";
                $s_qry.=" s_first_name=? ";
                $s_qry.=", s_last_name=? ";
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
                    
                    $logi["msg"]="Inserting into ".$this->tbl_frontend_user." ";
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
            return $this->db->count_all($this->tbl);
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