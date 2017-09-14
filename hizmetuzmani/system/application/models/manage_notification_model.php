<?php
/*********
* Author: Koushik Rout
* Date  : 11 January 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For State
* 
* @package General
* @subpackage guideline
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/guideline.php
* @link views/admin/guidelines/
*/


class Manage_notification_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
	private $s_lang_prefix;
    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->ADMIN_NOTIFICATIONS;        
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
            
			$s_qry="SELECT * FROM ".$this->tbl." n  "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]            =	$row->i_id;////always integer
                  $ret_[$i_cnt]["s_page_name"]   =	get_unformatted_string($row->s_page_name); 
                  $ret_[$i_cnt]["s_description"] =	get_unformatted_string($row->{$this->s_lang_prefix.'_s_description'});
				  if($ret_[$i_cnt]["s_description"]==''){get_unformatted_string($row->{$this->site_default_lang_prefix.'_s_description'});}
                  $ret_[$i_cnt]["dt_created_on"] =  date($this->conf["site_date_format"],intval($row->dt_created_on));  
                  
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
	
	
	
	
	public function fetch_multi_sorted_list($s_where=null,$order_name = 'dt_created_on',$order_by = 'DESC',$i_start=null,$i_limit=null)
    {
        try
        {
          	$ret_=array();
            
			$s_qry="SELECT * FROM ".$this->tbl." n  "
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );

                
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]            		=	$row->i_id;////always integer 
				  $ret_[$i_cnt]["i_notification_type"]  =	$row->i_notification_type;
                  $ret_[$i_cnt]["s_data1"]   	 		=	get_unformatted_string($row->s_data1); 
                  $ret_[$i_cnt]["s_data2"]   	 		=	get_unformatted_string($row->s_data2); 
				  $ret_[$i_cnt]["s_data3"]   	 		=	get_unformatted_string($row->s_data3); 
				  
				  $notification_array = $this->db->ADMIN_NOTIFICATION_ARRAY;
				  $ret_[$i_cnt]["msg"]   	 			=	str_replace('##VAR3##',$ret_[$i_cnt]["s_data3"],str_replace('##VAR2##',$ret_[$i_cnt]["s_data2"],str_replace('##VAR1##',$ret_[$i_cnt]["s_data1"],$notification_array[$ret_[$i_cnt]["i_notification_type"]])));
				  $ret_[$i_cnt]["dt_created_on"] 		=	date($this->conf["site_date_format"],intval($row->dt_created_on)); 
                  
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
    }         
    

    /*******
    * Fetches One record from db for the id value.
    * 
    * @param int $i_id
    * @returns array
    */
    public function fetch_this($i_id,$s_prefix='')
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          
          $s_qry="Select * "
                ."From ".$this->tbl." AS n  "
                ." Where n.i_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
		  if($s_prefix!='')
          {
              $this->s_lang_prefix  =  $s_prefix; 
          }
		  
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				 ;
				  
				   $ret_[$i_cnt]["id"]            		=	$row->i_id;////always integer 
				  $ret_[$i_cnt]["i_notification_type"]  =	$row->i_notification_type;
                  $ret_[$i_cnt]["s_data1"]   	 		=	get_unformatted_string($row->s_data1); 
                  $ret_[$i_cnt]["s_data2"]   	 		=	get_unformatted_string($row->s_data2); 
				  
				  $notification_array = $this->db->ADMIN_NOTIFICATION_ARRAY;
				 $ret_["msg"]   	 			=	str_replace('##VAR2##',$ret_[$i_cnt]["s_data2"],str_replace('##VAR1##',$ret_[$i_cnt]["s_data1"],$notification_array[$ret_[$i_cnt]["i_notification_type"]]));
				  $ret_["dt_created_on"] 		=	date($this->conf["site_date_format"],intval($row->dt_created_on)); 
                  
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
				$s_lang_prefix  = get_formatted_string($info["s_lang_prefix"]);
                $s_qry="Insert Into ".$this->tbl." Set ";
                $s_qry.=" s_page_name=? ";
                $s_qry.=", {$s_lang_prefix}_s_description=? ";
				$s_qry.=", dt_created_on=? ";
                
                $this->db->query($s_qry,array(  
												get_formatted_string($info["s_page_name"]),
												get_formatted_string($info["s_description"]),
												intval($info["dt_created_on"])
												
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(  
												get_formatted_string($info["s_page_name"]),
												get_formatted_string($info["s_description"]),
												intval($info["dt_created_on"])
												
												 )) ) ;
                    $this->log_info($logi); 
                    unset($logi);
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
				$s_lang_prefix  = get_formatted_string($info["s_lang_prefix"]); 
                $s_qry	=	"Update ".$this->tbl." Set ";
				$s_qry.=" s_page_name=? ";
                $s_qry.=", {$s_lang_prefix}_s_description=? ";
				$s_qry.=", dt_created_on=? ";
                $s_qry.=" Where i_id=? ";
                
                $this->db->query($s_qry,array(    
												 get_formatted_string($info["s_page_name"]),
												 get_formatted_string($info["s_description"]),
												 intval($info["dt_created_on"]),
												 intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(    
												 get_formatted_string($info["s_page_name"]),
												 get_formatted_string($info["s_description"]),
												 intval($info["dt_created_on"]),
												 intval($i_id)

                                                     )) ) ;                                 
                    $this->log_info($logi); 
                    unset($logi);
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

                $i_ret_=$this->db->query($s_qry, array(intval($i_id)) );
                if($i_ret_)
                {
                    $logi["msg"]="Deleting ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($i_id))) ) ;
                    $this->log_info($logi); 
                    unset($logi);
                }                                           
            }
            elseif(intval($i_id)==-1)////Deleting All
            {
				$s_qry="DELETE FROM ".$this->tbl." ";
                $i_ret_=$this->db->query($s_qry);       
                if($i_ret_)
                {
                    $logi["msg"]="Deleting all information from ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry) ) ;
                    $this->log_info($logi); 
                    unset($logi);
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