<?php
  /*********
* Author: Koushik
* Email:koushik.r@acumensoft.info
* Date  : 3 July 2012
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  Model For testimonial
* 
* @package CMS
* @subpackage testimonial
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/testimonial.php
* @link views/admin/testimonial/
*/


class Testimonial_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
	private $tbl_user;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl 		= $this->db->TESTIMONIALS;  
		  $this->tbl_user 	= $this->db->USER;         
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
			$s_qry="SELECT n.*,u.s_first_name,u.s_last_name,u.s_image FROM ".$this->tbl." n "
				." LEFT JOIN ".$this->tbl_user." u ON u.i_id = n.i_user_id "
                .($s_where!=""?$s_where:"" )." ORDER BY n.dt_created_on DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->i_id;////always integer
				 
				  $s_desc = nl2br(stripslashes($row->s_content));				  
                  $ret_[$i_cnt]["s_full_content"]	= $s_desc;	
				  $ret_[$i_cnt]["s_content"]		= (strlen($s_desc)>70) ? substr_replace($s_desc,'...',74) : $s_desc;
				  $ret_[$i_cnt]["s_first_name"]		= get_unformatted_string($row->s_first_name);
				  $ret_[$i_cnt]["s_last_name"]		= get_unformatted_string($row->s_last_name);
				  $ret_[$i_cnt]["s_image"]			= get_unformatted_string($row->s_image);
				  		  
                  $ret_[$i_cnt]["dt_created_on"]	= date($this->conf["site_date_format"],intval($row->dt_created_on)); 
				 
				  $ret_[$i_cnt]["i_status"]			= intval($row->i_status); 
				  $ret_[$i_cnt]["s_status"]			= intval($row->i_status)?"Active":"Inactive";
				
                  
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
			$s_qry="SELECT n.*,u.s_first_name,u.s_last_name FROM ".$this->tbl." n "
				." LEFT JOIN ".$this->tbl_user." u ON u.i_id = n.i_user_id "
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->i_id;////always integer
				 
				  $s_desc = nl2br(stripslashes($row->s_content));				  
                  $ret_[$i_cnt]["s_full_content"]	= $s_desc;	
				  $ret_[$i_cnt]["s_content"]		= (strlen($s_desc)>70) ? substr_replace($s_desc,'...',74) : $s_desc;
				  $ret_[$i_cnt]["s_full_name"]		= get_unformatted_string($row->s_first_name).' '.get_unformatted_string($row->s_last_name);
				  		  
                  $ret_[$i_cnt]["dt_created_on"]	= date($this->conf["site_date_format"],intval($row->dt_created_on)); 
				 
				  $ret_[$i_cnt]["i_status"]			= intval($row->i_status); 
				  $ret_[$i_cnt]["s_status"]			= intval($row->i_status)?"Active":"Inactive";
				
                  
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
				." LEFT JOIN ".$this->tbl_user." u ON u.i_id = n.i_user_id "
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
                ." Where n.i_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				 
                  $ret_["id"]=$row->i_id;////always integer
				  
                  $ret_["s_person_name"]=get_unformatted_string(htmlspecialchars_decode($row->s_person_name)); 
				  $ret_["i_lang_id"]= intval($row->i_lang_id); 
				  
				  //$s_desc = nl2br(htmlspecialchars_decode(get_unformatted_string($row->s_content)));
				  $s_desc = nl2br(get_unformatted_string($row->s_content));
				  
                  $ret_["s_content"]=$s_desc;
				 
				  
                  $ret_["dt_created_on"]=date($this->conf["site_date_format"],intval($row->dt_entry_date)); 
				  $ret_["fn_created_on"]=date("d/m/Y",intval($row->dt_entry_date)); 
				  $ret_["i_is_active"]=intval($row->i_status); 
				  $ret_["s_is_active"]=$this->db->TESTIMONIALSTATE[$row->i_status];				  
				
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
        {}
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
				$s_qry.=" s_content=? ";
                $s_qry.=" Where i_id=? ";
                
                $this->db->query($s_qry,array(
												  get_formatted_string($info["s_content"]),
												  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   

                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  get_formatted_string($info["s_content"]),
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
	
	
	
	
	public function fetch_content_by_ajax_call($lang_id,$name,$desc)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select * "
                ."From ".$this->tbl." AS c "
                ." Where c.i_lang_id=?"
				." And c.s_person_name=?"
				." And c.s_content=?";
                
          $rs=$this->db->query($s_qry,array(intval($lang_id),intval($cat_id),$s_question));
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_["id"]=$row->i_id;////always integer
                  $ret_["s_person_name"]=stripslashes(htmlspecialchars_decode($row->s_person_name)); 
				  $ret_["i_lang_id"]= intval($row->i_lang_id); 
				  
                  $ret_["s_content"]=stripslashes(htmlspecialchars_decode($row->s_content));
				  $ret_["s_person_address"]=stripslashes(htmlspecialchars_decode($row->s_person_address)); 
                  $ret_["s_person_phone"]=stripslashes(htmlspecialchars_decode($row->s_person_phone));
				  $ret_["s_person_email"]=stripslashes(htmlspecialchars_decode($row->s_person_email)); 
                  $ret_["s_person_image"]=stripslashes(htmlspecialchars_decode($row->s_person_image));   
                  $ret_["dt_created_on"]=date($this->conf["site_date_format"],intval($row->dt_entry_date)); 
				  
                  $ret_["i_is_active"]	=	intval($row->i_status); 
				  $ret_["s_is_active"]	=	$this->db->TESTIMONIALSTATE[$row->i_status];
		  
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
	
	
    public function __destruct()
    {}                 
  
  
}
///end of class
?>