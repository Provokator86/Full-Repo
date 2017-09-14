<?php
/*********
* Author: Purnendu Shaw
* Date  : 30 Dec 2010
* Modified By: Jagannath Samanta
* Modified Date: 14 July 2011
* 
* Purpose:
* Model For Content Management
* 
* @package Content Management
* @subpackage Content
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/content.php
* @link views/admin/content/
*/


class Content_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->CMS;          
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
			$s_qry="SELECT * FROM ".$this->tbl." c "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" ORDER BY s_title ASC Limit ".intval($i_start).",".intval($i_limit):"" );
				
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->i_id;////always integer
                  $ret_[$i_cnt]["s_title"]=get_unformatted_string($row->s_title); 
				  $ret_[$i_cnt]["s_full_description"]=html_entity_decode($row->s_description, ENT_QUOTES, 'UTF-8');
				  
				  $s_desc = strip_tags(stripslashes(htmlspecialchars_decode($row->s_description)));
				  
				  $ret_[$i_cnt]["s_desc_full"]= $s_desc ; 
				  if(strlen($s_desc)>197)
				  	$s_desc = substr_replace($s_desc,'...',200);
                  $ret_[$i_cnt]["s_description"]= $s_desc ; 
                  $ret_[$i_cnt]["dt_created_on"]=date($this->conf["site_date_format"],intval($row->dt_entry_date)); 
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
                ."From ".$this->tbl." c "
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
                ."From ".$this->tbl." AS c "
                ." Where c.i_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id)));
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_["id"]=$row->i_id;////always integer
                  //$ret_["s_name"]=stripslashes($row->s_name); 
                  $ret_["s_description"]=stripslashes(htmlspecialchars_decode($row->s_description));
				  $ret_["s_youtube_link"]=stripslashes(htmlspecialchars_decode($row->s_youtube_link));
				  $ret_["s_flv_video"]=stripslashes(htmlspecialchars_decode($row->s_flv_video));
				  $ret_["s_doc_mgnt_features"]=stripslashes(htmlspecialchars_decode($row->s_doc_mgnt_features)); 
				  $ret_["s_title"]=stripslashes($row->s_title);
				  $ret_["s_image_name"]=stripslashes($row->s_image); 
                  $ret_["dt_created_on"]=date($this->conf["site_date_format"],intval($row->dt_entry_date)); 
                  $ret_["i_is_active"]= intval($row->i_status); 
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
                $s_qry.=" s_title=? ";
                $s_qry.=", s_description=? ";
				$s_qry.=", s_youtube_link=? ";
				$s_qry.=", s_flv_video=? ";
				$s_qry.=", s_doc_mgnt_features=? ";
                $s_qry.=", i_status=? ";
                $s_qry.=", dt_entry_date=? ";
                //$s_qry.=", i_type=? ";
                
                $this->db->query($s_qry,array(addslashes(htmlspecialchars(trim($info["s_title"]))),
                                                      trim($info["s_description"]),
													  trim($info["s_youtube_link"]),
												  	  trim($info["s_flv_video"]),
													  htmlspecialchars(trim($info["s_doc_mgnt_features"])),
                                                      intval($info["i_status"]),
                                                      intval($info["dt_entry_date"])
                                                     ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(addslashes(htmlspecialchars(trim($info["s_title"]))),
                                                      trim($info["s_description"]),
													  trim($info["s_youtube_link"]),
												  	  trim($info["s_flv_video"]),
													  trim($info["s_doc_mgnt_features"]),
                                                      intval($info["i_status"]),
                                                      intval($info["dt_entry_date"])
                                                     )) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }
            }
            unset($s_qry, $info);
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
			    $s_qry.=" s_title=? ";
                $s_qry.=", s_description=? ";
				$s_qry.=", s_youtube_link=? ";
				$s_qry.=", s_flv_video=? ";
				$s_qry.=", s_doc_mgnt_features=? ";
                $s_qry.=", i_status=? ";
                $s_qry.=", dt_entry_date=? ";
                $s_qry.=" Where i_id=? ";
                
                $this->db->query($s_qry,array(addslashes(htmlspecialchars(trim($info["s_title"]))),
                                                      trim($info["s_description"]),
													  trim($info["s_youtube_link"]),
												  	  trim($info["s_flv_video"]),
													  htmlspecialchars(trim($info["s_doc_mgnt_features"])),
                                                      intval($info["i_status"]),
                                                      intval($info["dt_entry_date"]),
													  intval($i_id) 
                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(addslashes(htmlspecialchars(trim($info["s_title"]))),
                                                      trim($info["s_description"]),
													  trim($info["s_youtube_link"]),
												  	  trim($info["s_flv_video"]),
													  trim($info["s_doc_mgnt_features"]),
                                                      intval($info["i_status"]),
                                                      intval($info["dt_entry_date"]),
													  intval($i_id) 
                                                     )) ) ;                                
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
	
	function delete_all_info($i_content_type)
	{
		try
        {
		       
			$i_ret_=0;////Returns false
			$s_qry="DELETE FROM ".$this->tbl." ";
			$s_qry.=" Where i_type=? ";
			$i_ret_ = $this->db->query($s_qry, array(intval($i_content_type)) );
			if($i_ret_)
			{
				$logi["msg"]="Deleting all information from ".$this->tbl." ";
				$logi["sql"]= serialize(array($s_qry) ) ;
				$this->log_info($logi); 
				unset($logi,$logindata);
			} 
            unset($s_qry);
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