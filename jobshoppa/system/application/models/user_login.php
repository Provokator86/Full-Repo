<?php
/*********
* Author: Sahinul Haque
* Date  : 15 Nov 2010
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For User Login
* 
* @package User
* @subpackage Login
* 
* @includes infModel.php 
* @includes MY_Model.php
* 
* @link MY_Model.php
*/


class User_login extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl=$this->db->USER;      
		  $this->tbl_frontend_user=$this->db->USERMANAGE;       
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
          $s_qry="Select id,s_user_name,s_first_name,s_last_name,i_is_deleted,i_user_type_id From ".$this->tbl." Where s_user_name=?";
          $s_qry.=" And s_password=? ";
          $s_qry.="And i_is_deleted=0 ";
          
          $stmt_val["s_user_name"]= htmlspecialchars(trim($login_data["s_user_name"]));
          /////Added the salt value with the password///
		  
		  
          $stmt_val["s_password"]= md5(trim($login_data["s_password"]).$this->conf["security_salt"]);
		  
		  
		  
          $rs=$this->db->query($s_qry,$stmt_val);
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_["id"]=$row->id;////always integer
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
    
    
	
	 public function front_login($login_data)
    {

        try
        {
          $ret_=array();
          ////Using Prepared Statement///
         /* $s_qry="Select id,s_username,s_name,s_email,i_role,i_is_active From ".$this->tbl_frontend_user." 
		  			Where s_username=?";*/
					
		 
		 $s_qry = "Select id,s_username,s_name,s_email,i_role,i_is_active From ".$this->tbl_frontend_user." 
		  			Where (s_username = '".htmlspecialchars(trim($login_data["s_user_name"]),ENT_QUOTES)."' OR 
					s_email = '".htmlspecialchars(trim($login_data["s_user_name"]),ENT_QUOTES)."') ";								
          $s_qry.=" And s_password=? ";
          $s_qry.="And i_is_active=1 ";
          
		  //echo $s_qry;
         // $stmt_val["s_user_name"]= htmlspecialchars(trim($login_data["s_user_name"]),ENT_QUOTES);
		          /////Added the salt value with the password///		  
		  
          $stmt_val["s_password"]= md5(trim($login_data["s_password"]).$this->conf["security_salt"]);
		  //echo $stmt_val["s_password"].'<br>9bdb31764642c5306162695e86562bee <br>';
		  
		  
          $rs=$this->db->query($s_qry,$stmt_val);
		 // echo $this->db->last_query();
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_["id"]=$row->id;////always integer
                  $ret_["s_user_name"]=stripslashes($row->s_username); 
                 // $ret_["s_first_name"]=trim($row->s_first_name); 
                  $ret_["s_name"]=trim($row->s_name);
				  $ret_["s_email"]=trim($row->s_email);
				  //$ret_["i_user_type_id"]=intval($row->i_role);
				  $ret_["i_user_type_id"]=intval($row->i_role);
                  $ret_["dt_created_on"]=date($this->conf["site_date_format"],intval($row->i_created_date)); 
                  $ret_["i_is_active"]=intval($row->i_is_active); 
                  $ret_["s_is_active"]=(intval($row->i_is_active)==1?"Active":"Inactive"); 
                  
                  ////////saving logged in user data into session////
                  $this->session->set_userdata(array(
                                                    "loggedin"=> array(
                                                    "user_id"=> encrypt(intval($ret_["id"])),
													"user_type_id"=> encrypt(intval($ret_["i_user_type_id"])),
                                                    "user_name"=> $ret_["s_user_name"],
                                                    "user_fullname"=> $ret_["s_name"],
													"user_email"=> $ret_["s_email"],
                                                    "user_status"=> $ret_["s_is_active"])       
                                                ));
                  ////////end saving logged in user data into session////
                  //////////log report///
                   /* $logi["msg"]="Logged in as ".$ret_["s_name"]
                                ."[".$ret_["s_user_name"]."] at ".date("Y-M-d H:i:s") ;*/
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
    
	
	 public function facebook_login($login_data)
    {

        try
        {
          $ret_=array();
          ////Using Prepared Statement///
		 
		  $s_qry = "Select id,s_username,s_name,s_email,i_role,i_is_active From ".$this->tbl_frontend_user." 
		  			Where
					s_facebook_email = '".htmlspecialchars(trim($login_data["s_email"]),ENT_QUOTES)."' ";								
          $s_qry.="And i_is_active=1 ";
		  $s_qry.="And i_facebook_login=1 ";
          
		  //echo $s_qry;
         // $stmt_val["s_user_name"]= htmlspecialchars(trim($login_data["s_user_name"]),ENT_QUOTES);
		          /////Added the salt value with the password///		  
		  
          //$stmt_val["s_password"]= md5(trim($login_data["s_password"]).$this->conf["security_salt"]);
		  //echo $stmt_val["s_password"].'<br>9bdb31764642c5306162695e86562bee <br>';
		  
		  
          $rs=$this->db->query($s_qry);
		 // echo $this->db->last_query();
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_["id"]=$row->id;////always integer
                  $ret_["s_user_name"]=stripslashes($row->s_username); 
                 // $ret_["s_first_name"]=trim($row->s_first_name); 
                  $ret_["s_name"]=trim($row->s_name);
				  $ret_["s_email"]=trim($row->s_email);
				  //$ret_["i_user_type_id"]=intval($row->i_role);
				  $ret_["i_user_type_id"]=intval($row->i_role);
                  $ret_["dt_created_on"]=date($this->conf["site_date_format"],intval($row->i_created_date)); 
                  $ret_["i_is_active"]=intval($row->i_is_active); 
                  $ret_["s_is_active"]=(intval($row->i_is_active)==1?"Active":"Inactive"); 
                  
                  ////////saving logged in user data into session////
                  $this->session->set_userdata(array(
                                                    "loggedin"=> array(
                                                    "user_id"=> encrypt(intval($ret_["id"])),
													"user_type_id"=> encrypt(intval($ret_["i_user_type_id"])),
                                                    "user_name"=> $ret_["s_user_name"],
                                                    "user_fullname"=> $ret_["s_name"],
													"user_email"=> $ret_["s_email"],
                                                    "user_status"=> $ret_["s_is_active"])       
                                                ));
                  ////////end saving logged in user data into session////
                  //////////log report///
                   /* $logi["msg"]="Logged in as ".$ret_["s_name"]
                                ."[".$ret_["s_user_name"]."] at ".date("Y-M-d H:i:s") ;*/
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