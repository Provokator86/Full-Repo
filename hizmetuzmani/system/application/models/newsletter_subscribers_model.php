<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 30 March 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For Newsletter Subscribers
* 
* @package Email
* @subpackage Newsletter Subscribers
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/newsletter_subscribers.php
* @link views/admin/newsletter_subscribers/
*/


class Newsletter_subscribers_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl 	= 	$this->db->NEWSLETTERSUBCRIPTION;          
          $this->conf 	=	&get_config();
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
			 $s_qry="SELECT * FROM ".$this->tbl." n "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]				=	$row->i_id;////always integer
                  $ret_[$i_cnt]["s_name"]			=	get_unformatted_string($row->s_name); 
				  $ret_[$i_cnt]["s_email"]			=	get_unformatted_string($row->s_email);
                  $ret_[$i_cnt]["dt_created_on"]	=	($row->dt_entry_date)?date($this->conf["site_date_format"],intval($row->dt_entry_date)):''; 
				  $ret_[$i_cnt]["i_user_type"]		=	intval($row->i_user_type); 
				  $ret_[$i_cnt]["s_user_type"]		=	$this->db->USERTYPE[$row->i_user_type]; 
				  
                  $ret_[$i_cnt]["i_is_active"]		=	intval($row->i_subscribe_status); 
				  $ret_[$i_cnt]["s_is_active"]		=	(intval($row->i_subscribe_status)==1?"Subscribed":"Unsubscribed");
                  
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
			 $s_qry="SELECT * FROM ".$this->tbl." n "
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]				=	$row->i_id;////always integer
                  $ret_[$i_cnt]["s_name"]			=	get_unformatted_string($row->s_name); 
				  $ret_[$i_cnt]["s_email"]			=	get_unformatted_string($row->s_email);
                  $ret_[$i_cnt]["dt_created_on"]	=	($row->dt_entry_date)?date($this->conf["site_date_format"],intval($row->dt_entry_date)):''; 
				  $ret_[$i_cnt]["i_user_type"]		=	intval($row->i_user_type); 
				  $ret_[$i_cnt]["s_user_type"]		=	$this->db->USERTYPE[$row->i_user_type]; 
				  
                  $ret_[$i_cnt]["i_is_active"]		=	intval($row->i_subscribe_status); 
				  $ret_[$i_cnt]["s_is_active"]		=	(intval($row->i_subscribe_status)==1?"Subscribed":"Unsubscribed");
                  
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
          $s_qry="Select * "
                ."From ".$this->tbl." AS n "
                ." Where n.i_id=? AND i_del_status=1";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_["id"]				=	$row->i_id;////always integer
                  $ret_["s_name"]			=	get_unformatted_string($row->s_name); 
                  $ret_["s_email"]			=	get_unformatted_string($row->s_email);  
                  $ret_["dt_created_on"]	=	date($this->conf["site_date_format"],intval($row->dt_entry_date)); 
				  $ret_["i_user_type"]		=	intval($row->i_user_type); 
				  $ret_["s_user_type"]		=	$this->db->USERTYPE[$row->i_user_type]; 
				  
                  $ret_["i_is_active"]		= 	intval($row->i_subscribe_status); 
				  $ret_["s_is_active"]		=	(intval($row->i_subscribe_status)==1?"Subscribed":"Unsubscribed");
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
                $s_qry.=" s_name=? ";
				if(!empty($info['i_user_id']))
				{
					$s_qry.=", i_user_id=".$info['i_user_id']." ";
				}
                $s_qry.=", s_email=? ";
				$s_qry.=", i_user_type=? ";
                $s_qry.=", i_subscribe_status=? ";
                $s_qry.=", dt_entry_date=? ";
                
                $this->db->query($s_qry,array(
												  trim(htmlspecialchars($info["s_name"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_email"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_user_type"]),
												  intval($info["i_status"]),
												  intval($info["dt_entry_date"])
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  trim(htmlspecialchars($info["s_name"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_email"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_user_type"]),
												  intval($info["i_status"]),
												  intval($info["dt_entry_date"])
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
				$s_qry.=" s_name=? ";
                $s_qry.=", s_email=? ";
                $s_qry.=", i_subscribe_status=? ";
                $s_qry.=", dt_entry_date=? ";
                $s_qry.=" Where i_id=? ";
                
                $this->db->query($s_qry,array(trim(htmlspecialchars($info["s_name"], ENT_QUOTES, 'utf-8')),
                                                      trim(htmlspecialchars($info["s_email"], ENT_QUOTES, 'utf-8')),
                                                      intval($info["i_status"]),
                                                      intval($info["dt_entry_date"]),
													  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   

                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(trim(htmlspecialchars($info["s_name"], ENT_QUOTES, 'utf-8')),
                                                      trim(htmlspecialchars($info["s_email"], ENT_QUOTES, 'utf-8')),
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
				//$s_qry="DELETE FROM ".$this->tbl." ";
				$s_qry="UPDATE ".$this->tbl." SET i_del_status=2";
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
				//$s_qry="DELETE FROM ".$this->tbl." ";
				$s_qry="UPDATE ".$this->tbl." SET i_del_status=2";
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
	
	/* used for edit profile of users*/
	public function delete_newsletter_info($i_id)
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
	
	/* to unsubscribe newsletter */
	public function unsubscribe_newsletter_info($info,$email)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";
				$s_qry.=" i_subscribe_status=? ";
                $s_qry.=" Where s_email=? ";
                
                $this->db->query($s_qry,array(												  
												  get_formatted_string($info["i_status"]),
												  get_formatted_string($email)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(												  
												  get_formatted_string($info["i_status"]),
												  get_formatted_string($email)

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