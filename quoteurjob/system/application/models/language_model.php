<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 9 Sep 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For Language
* 
* @package Content Management
* @subpackage news
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/language.php
* @link views/admin/language/
*/


class Language_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->LANGUAGE;          
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
			$s_qry="SELECT * FROM ".$this->tbl." n "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          
		  $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->i_id;////always integer
                  $ret_[$i_cnt]["s_language"]=stripslashes(htmlspecialchars_decode($row->s_language));
				  $ret_[$i_cnt]["s_flag_image"]=stripslashes(htmlspecialchars_decode($row->s_flag_image)); 
				 
                  $ret_[$i_cnt]["dt_created_on"]=date($this->conf["site_date_format"],intval($row->dt_entry_date)); 
				  $ret_[$i_cnt]["i_selected"]=intval($row->i_default); 
				  $ret_[$i_cnt]["s_selected"]=(intval($row->i_default)==1?"Yes":"No");
				  
                  $ret_[$i_cnt]["i_is_active"]=intval($row->i_status); 
				  $ret_[$i_cnt]["s_is_active"]=(intval($row->i_status)==1?"Active":"Inactive");
                  
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
                ." Where n.i_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]=$row->i_id;////always integer
                  $ret_["s_language"]=stripslashes(htmlspecialchars_decode($row->s_language));
				  $ret_["s_short_name"]=stripslashes(htmlspecialchars_decode($row->s_short_name));
				  $ret_["s_flag_image"]=stripslashes(htmlspecialchars_decode($row->s_flag_image)); 
				 
                  $ret_["dt_created_on"]=date($this->conf["site_date_format"],intval($row->dt_entry_date)); 
				  $ret_["i_selected"]=intval($row->i_default); 
				  $ret_["s_selected"]=(intval($row->i_default)==1?"Yes":"No");
				  
                  $ret_["i_is_active"]=intval($row->i_status); 
				  $ret_["s_is_active"]=(intval($row->i_status)==1?"Active":"Inactive");
		  
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
                $s_qry.=" s_language=? ";
                $s_qry.=", s_flag_image=? ";
				$s_qry.=", i_default=? ";
                $s_qry.=", i_status=? ";
                $s_qry.=", dt_entry_date=? ";
                
                $this->db->query($s_qry,array(
												  trim(htmlspecialchars($info["s_language"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_flag_image"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_default"]),
												  intval($info["i_status"]),
												  intval($info["dt_entry_date"])
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
					$this->set_default_language($info,$i_ret_);    // for selecting default language
					
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  trim(htmlspecialchars($info["s_language"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_flag_image"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_default"]),
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
				$s_qry.=" s_language=? ";
                $s_qry.=", s_flag_image=? ";
				$s_qry.=", i_default=? ";
                $s_qry.=", i_status=? ";
				$s_qry.=", dt_entry_date=? ";
                $s_qry.=" Where i_id=? ";
                
                $this->db->query($s_qry,array(

												  trim(htmlspecialchars($info["s_language"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_flag_image"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_default"]),
												  intval($info["i_status"]),
												  intval($info["dt_entry_date"]),
												  intval($i_id)
                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
					$this->set_default_language($info,$i_id); // for selecting default language
					
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(

												  trim(htmlspecialchars($info["s_language"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_flag_image"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_default"]),
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
	
	
	/****  FOR CHECKING DEFAULT LANGUAGE SLECTED   *****/
	public function set_default_language($info,$id)
	{
		try
		{
			$i_ret_=0;////Returns false
			if(!empty($info))
			{
				if($info['i_default'] == 1)
				{
					$s_qry	=	"Update ".$this->tbl." Set ";
					$s_qry.=" i_default= ?";
					$s_qry.=" Where i_default=? ";
					
					$this->db->query($s_qry,array(
													intval(0),
													intval(1)
												));
					$i_ret_=$this->db->affected_rows();   
					
					$s_qry_1	=	"Update ".$this->tbl." Set ";
					$s_qry_1.=" i_default= ?";
					$s_qry_1.=" Where i_id=? ";
					
					$this->db->query($s_qry_1,array(
														intval($info["i_default"]),
														intval($id)
													));
					if($i_ret_)
					{
						$logi["msg"]="Updating ".$this->tbl." ";
						$logi["sql"]= serialize(array($s_qry,array(
													intval(0),
													intval(1)
												)) ) ;                                 
						$this->log_info($logi); 
						$logi_1["msg"]="Updating ".$this->tbl." ";
						$logi_1["sql"]= serialize(array($s_qry_1,array(
														intval($info["i_default"]),
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
	
    public function __destruct()
    {}                 
  
  
}
///end of class
?>