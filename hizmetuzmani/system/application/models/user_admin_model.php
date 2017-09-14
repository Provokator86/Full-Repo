<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 9 Sep 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For News
* 
* @package Content Management
* @subpackage news
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/news.php
* @link views/admin/news/
*/


class User_admin_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
	private $tbl_master;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->ADMIN; 
		  $this->tbl_master = $this->db->USER_TYPE;         
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
			$s_qry="SELECT n.*,m.s_user_type FROM ".$this->tbl." n "
				   ." LEFT JOIN ".$this->tbl_master. " m "	
				   ." ON n.i_user_type_id=m.id "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );

          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_email"]=stripslashes(htmlspecialchars_decode($row->s_email)); 
				  $ret_[$i_cnt]["s_first_name"]=stripslashes(htmlspecialchars_decode($row->s_first_name));
				  $ret_[$i_cnt]["s_last_name"]=stripslashes(htmlspecialchars_decode($row->s_last_name));
				  $ret_[$i_cnt]["s_user_name"]=stripslashes(htmlspecialchars_decode($row->s_user_name)); 
				  $ret_[$i_cnt]["i_user_type_id"]=intval($row->i_user_type_id); 
				  $ret_[$i_cnt]["s_user_type"]=stripslashes(htmlspecialchars_decode($row->s_user_type)); 
				  
                  $ret_[$i_cnt]["dt_created_on"]=date($this->conf["site_date_format"],intval($row->dt_created_on)); 
                  $ret_[$i_cnt]["i_is_active"]=intval($row->i_stat); 
				  $ret_[$i_cnt]["s_is_active"]=(intval($row->i_stat)==1?"Active":"Inactive");
                  
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
          $s_qry="Select n.*,m.s_user_type "
                ."From ".$this->tbl." AS n "
				." LEFT JOIN ".$this->tbl_master. " m "
				." ON n.i_user_type_id=m.id "
                ." Where n.id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]=$row->id;////always integer
                  $ret_["s_email"]=stripslashes(htmlspecialchars_decode($row->s_email)); 
				  $ret_["s_first_name"]=stripslashes(htmlspecialchars_decode($row->s_first_name));
				  $ret_["s_last_name"]=stripslashes(htmlspecialchars_decode($row->s_last_name));
				  $ret_["s_user_name"]=stripslashes(htmlspecialchars_decode($row->s_user_name)); 
				  $ret_["i_user_type_id"]=intval($row->i_user_type_id); 
				  $ret_["s_user_type"]=stripslashes(htmlspecialchars_decode($row->s_user_type)); 
				  
                  $ret_["dt_created_on"]=date($this->conf["site_date_format"],intval($row->dt_created_on)); 
                  $ret_["i_is_active"]=intval($row->i_stat); 
				  $ret_["s_is_active"]=(intval($row->i_stat)==1?"Active":"Inactive");
		  
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
                $s_qry.=" s_email=? ";
				$s_qry.=", s_first_name=? ";
				$s_qry.=", s_last_name=? ";
				$s_qry.=", s_user_name=? ";
				$s_qry.=", i_user_type_id=? ";
				$s_qry.=", s_password=? ";
                //$s_qry.=", i_stat=? ";
                $s_qry.=", dt_created_on=? ";
                
                $this->db->query($s_qry,array(
												  trim(htmlspecialchars($info["s_email"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_first_name"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_last_name"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_user_name"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_user_type_id"]),
												  md5(trim(htmlspecialchars($info["s_password"], ENT_QUOTES, 'utf-8').$this->conf["security_salt"])),
												  //intval($info["i_status"]),
												  intval($info["dt_entry_date"])
												 ));
               
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  trim(htmlspecialchars($info["s_email"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_first_name"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_last_name"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_user_name"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_user_type_id"]),
												  md5(trim(htmlspecialchars($info["s_password"], ENT_QUOTES, 'utf-8').$this->conf["security_salt"])),
												  //intval($info["i_status"]),
												  intval($info["dt_entry_date"])
												 ))) ;
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
				$s_qry.=" s_email=? ";
				$s_qry.=", s_first_name=? ";
				$s_qry.=", s_last_name=? ";
				$s_qry.=", s_user_name=? ";
				$s_qry.=", i_user_type_id=? ";
				$s_qry.=", s_password=? ";
                //$s_qry.=", i_stat=? ";
                $s_qry.=", dt_created_on=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(  	  trim(htmlspecialchars($info["s_email"], ENT_QUOTES, 'utf-8')),
												  	  trim(htmlspecialchars($info["s_first_name"], ENT_QUOTES, 'utf-8')),
												  	  trim(htmlspecialchars($info["s_last_name"], ENT_QUOTES, 'utf-8')),
                                                      trim(htmlspecialchars($info["s_user_name"], ENT_QUOTES, 'utf-8')),
                                                      intval($info["i_user_type_id"]),
													  md5(trim(htmlspecialchars($info["s_password"], ENT_QUOTES, 'utf-8').$this->conf["security_salt"])),
													  //intval($info["i_status"]),
                                                      intval($info["dt_entry_date"]),
													  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
													  trim(htmlspecialchars($info["s_email"], ENT_QUOTES, 'utf-8')),
												  	  trim(htmlspecialchars($info["s_first_name"], ENT_QUOTES, 'utf-8')),
												  	  trim(htmlspecialchars($info["s_last_name"], ENT_QUOTES, 'utf-8')),
                                                      trim(htmlspecialchars($info["s_user_name"], ENT_QUOTES, 'utf-8')),
                                                      intval($info["i_user_type_id"]),
													  md5(trim(htmlspecialchars($info["s_password"], ENT_QUOTES, 'utf-8').$this->conf["security_salt"])),
													  //intval($info["i_status"]),
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
	
    public function __destruct()
    {}                 
  
  
}
///end of class
?>