<?php
/*********
* Author: SWI
* Date  : 11 sept 2017
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
* @link views/corporate/manage_user/
*/



class User_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl, $tbl_doc, $tbl_manage, $tbl_task;

    public function __construct()
    {
        try
        {
            parent::__construct();
            $this->tbl = $this->db->USER;
            $this->tbl_role = $this->db->USERROLE;
			$this->tbl_ut	= $this->db->USER_TYPE;
            $this->conf = & get_config();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }


	public function fetch_all_user_type()
	{
		$ret = array();
		$tmp = $this->db->select('id,s_user_type')->get_where($this->tbl_ut, array('i_status' => 1, 'id > '=> 1))->result_array();
		for($i = 0; $i < count($tmp); $i++)
			$ret[$tmp[$i]['id']] = $tmp[$i]['s_user_type'];
		unset($tmp);
		return $ret;
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
			
		    $s_qry = "SELECT n.* FROM {$this->tbl} AS n "
					  .$s_where
					 .(is_numeric($i_start) && is_numeric($i_limit)?" LIMIT ".intval($i_start).",".intval($i_limit):"");
			return $this->db->query($s_qry)->result_array();
          
          
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
		  $s_qry="SELECT * FROM ".$this->tbl." "
                 .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		
			//echo $s_qry; 
			
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
			  	  $ret_[$i_cnt]["i_id"]				= intval($row->i_id);////always integer
				  $ret_[$i_cnt]["s_first_name"]		= $row->s_first_name; 
				  $ret_[$i_cnt]["s_last_name"]		= $row->s_last_name; 
				  $ret_[$i_cnt]["s_user_name"]		= $row->s_user_name; 
				 
				  $ret_[$i_cnt]["dt_created_on"]	= date('Y-m-d H:i:s',$row->dt_created_on); 
				  $ret_[$i_cnt]["s_email"]			= $row->s_email; 
				  $ret_[$i_cnt]["s_password"]		= $row->s_password; 
				 
				  $ret_[$i_cnt]["s_address"]		= $row->s_address; 
				 $ret_[$i_cnt]["i_created_by"]		= $row->i_created_by;
				  $ret_[$i_cnt]["s_contact_number"]	= $row->s_contact_number; 				  
				  $ret_[$i_cnt]["i_status"]			= $row->i_status; 
				 
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
	

	
    public function gettotal_info($s_where=null)
    {
       try
        {			
            $tmp = $this->db->query("SELECT count(1) AS total FROM {$this->tbl} AS n {$s_where}")->result_array();
            return $tmp[0]['total'];
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
			$tmp = $this->db->get_where($this->tbl, array('i_id'=>$i_id))->result_array();
			return $tmp[0];
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }  //End of function fetch_this     
	

        
    /***
    * Inserts new records into db. As we know the table name 
    * we will not pass it into params.
	* since we have two different user tables to manage, aicte_admin and aicte_college_user
	* so for login access we are using aicte_admin table and for college to user mapping
	* we are using aicte_college_user.
    * 
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @returns $i_new_id  on success and FALSE if failed 
    */
	
    public function add_info($info)
    {
		try{
			 $i_ret_=0; ////Returns false
	            if(!empty($info))
	            {
	                $s_qry="Insert Into ".$this->tbl." Set ";
	                $s_qry.=" s_first_name=? ";
					$s_qry.=", s_last_name=? ";
					$s_qry.=", s_user_name=? ";
					$s_qry.=", s_password=? ";
					$s_qry.=", s_email=? ";
					$s_qry.=", s_address=? ";
					$s_qry.=", s_contact_number=? ";
					$s_qry.=", i_created_by=? ";
					$s_qry.=", i_user_type=? ";
					$s_qry.=", i_status=? ";
					
					
					
					$s_qry.=", dt_created_on=NOW() ";
					
	                $this->db->query($s_qry,array(
													  $info["s_first_name"],
													  $info["s_last_name"],
													  $info["s_user_name"],
													  md5(($info["s_password"]).$this->conf["security_salt"]),
													  $info["s_email"],
													  $info["s_address"],
													  $info["s_contact_number"],
													  $info["i_created_by"],
													  $info["i_user_type"],
													  $info["i_status"]
													 ));
													 
					
	                $i_ret_=$this->db->insert_id();     
	                
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
	                $s_qry="Update ".$this->tbl." Set ";
	                $s_qry.=" s_first_name=? ";
					$s_qry.=", s_last_name=? ";
					$s_qry.=", s_email=? ";
					$s_qry.=", s_address=? ";
					$s_qry.=", s_contact_number=? ";
					$s_qry.=", i_user_type=? ";
					$s_qry.=" Where i_id=? ";
					
					$i_aff=$this->db->query($s_qry,array(
																  $info["s_first_name"],
																  $info["s_last_name"],
																  $info["s_email"],
																  $info["s_address"],
																  $info["s_contact_number"],
																  $info["i_user_type"],
																  $i_id
																 ));
																 
			}
            unset($s_qry, $info,$i_id);
            return $i_aff;
			
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
				//echo $this->db->last_query();    
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
            unset($s_qry, $id);
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
   
	
	
	
	public function change_status($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";
                $s_qry.=" i_status= ? ";
                $s_qry.=" Where i_id=? ";
                //echo $i_id.$info['i_is_active'];
                $i_ret_=$this->db->query($s_qry,array(	intval($info['i_status']),
                intval($i_id)
                ));

                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(	intval($info['i_status']),
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
	
	
    public function change_password_info($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry    =    "UPDATE ".$this->tbl." SET ";
                $s_qry.=" i_user_type='0' ";
                if(isset($info["s_password"]) && !empty($info["s_password"]))
                {
                    $s_password = md5(trim($info["s_password"]).$this->conf["security_salt"]);
                    $s_qry.=", s_password= '".$s_password."' ";
                }
                $s_qry.=" WHERE i_id=? ";
                
                $i_ret_ = $this->db->query($s_qry,array(  
                                                  intval($i_id)
                                                 ));
                //$i_ret_=$this->db->affected_rows(); 
            }
            unset($s_qry,$info,$i_id);
            return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }   
	
    
    
	
	public function backend_user_login($login_data)
    {
        try
        {
          	$ret_ = array();
	  	    $s_qry = "SELECT i_id, s_first_name, s_last_name, s_user_name, s_email, i_status, i_user_type, e_access_type 
                      FROM ".$this->tbl." WHERE BINARY s_user_name=?";
	        //$s_qry.=" And s_password=? And i_status = 1 AND e_deleted = 'No'";
	        $s_qry.=" And s_password=? And i_status = 1 AND i_user_type IN(1,2,3,4) AND e_deleted = 'No'"; 
	        $stmt_val["s_user_name"]= trim($login_data["s_user_name"]);
	        // Added the salt value with the password
	        $stmt_val["s_password"]= md5(trim($login_data["s_password"]).$this->conf["security_salt"]);
	        $rs = $this->db->query($s_qry,$stmt_val);
			
			if($rs->num_rows()>0)
	        {
                foreach($rs->result() as $row)
                {
                    $ret_["id"]=$row->i_id; // always integer
                    $ret_["s_first_name"] = $row->s_first_name;
                    $ret_["s_user_name"] = $row->s_user_name; 
                    $ret_["s_full_name"] = $row->s_first_name.' '.$row->s_last_name; 
                    $ret_["email"] = $row->s_email; 
                    $ret_["i_user_type_id"]= $row->i_user_type;
                    $ret_["e_access_type"]= $row->e_access_type;
                    $ret_["s_status"]=(intval($row->i_status)==1?"Active":"InActive"); 

                    // saving logged in user data into session
                    $this->session->set_userdata(array(
	                                                "admin_loggedin"=> array(
	                                                "user_id"=> encrypt(intval($ret_["id"])),
								                    "user_type_id"=> encrypt(intval($ret_["i_user_type_id"])),
	                                                "user_name"=> $ret_["s_user_name"],
	                                                "user_fullname"=> $ret_["s_full_name"],
	                                                "user_status"=> $ret_["s_status"]       ,
	                                                "access_type" => $ret_["e_access_type"]     
	                                          )));
                    // end saving logged in user data into session
                    // log report
                    $logi["msg"]="Logged in as ".$ret_['s_user_name']." at ".date("Y-M-d H:i:s");
                    //$logi["sql"]= serialize(array($s_qry) ) ;
                    //$logi["user_id"]=$ret_["id"];///Loggedin User Id                                 
                    $this->log_info($logi); 
                    unset($logi);  
                    // end log report   
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
	
	
    
    public function backend_chk_user($login_data)
    {
        try
        {
            $ret_ = array();
            $s_qry = "SELECT i_id, s_first_name, s_last_name, s_user_name, s_email, i_status, i_user_type, e_access_type 
                  FROM ".$this->tbl." WHERE BINARY s_email=?";
            $s_qry.=" AND i_user_type IN(1,2,3,4) AND e_deleted = 'No'";
            #$s_qry.=" And i_status = 1 AND e_deleted = 'No'";
            $stmt_val["s_email"]= trim($login_data["s_email"]);            
            $rs = $this->db->query($s_qry,$stmt_val);
            $ret_ = $rs->result_array();
            #echo $this->db->last_query();exit;
            unset($s_qry,$rs,$row,$login_data,$stmt_val);
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
