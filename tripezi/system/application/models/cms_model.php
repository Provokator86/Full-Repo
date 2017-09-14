<?php
/*********
* Author: KOushik Rout
* Date  : 02 July 2012
* Modified By: 
* Modified Date: 
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


class Cms_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl 			=   $this->db->CMS; 
		  $this->conf       	=   & get_config();
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
            ////Using Prepared Statement///
            $s_qry="Select * "
                ."From ".$this->tbl." AS c " ;

            $rs=$this->db->query($s_qry);

              if($rs->num_rows()>0)
              {
                  $i_cnt    =   0;
                  foreach($rs->result() as $row)
                  {
                      $ret_[$i_cnt]["id"]               =   $row->i_id;////always integer
                      $ret_[$i_cnt]["s_description"]    =   (stripslashes($row->s_description));
                      $ret_[$i_cnt]["s_title"]          =   get_unformatted_string($row->s_title); 
                      $ret_[$i_cnt]["dt_created_on"]    =   date($this->conf["site_date_format"],intval($row->dt_created_on)); 
                      $ret_[$i_cnt]["i_is_active"]      =   intval($row->i_status); 
                      $ret_[$i_cnt]["s_is_active"]      =   (intval($row->i_status)==1?"Active":"Inactive");
                      
                      $i_cnt++;
                  }    
                  $rs->free_result();          
              }
          unset($s_qry,$rs,$row,$i_id,$i_cnt);
          return  $ret_ ;
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
                  $ret_["s_description"]	= stripslashes(($row->s_description));
				  $ret_["s_title"]          = get_unformatted_string($row->s_title); 
				  
                  $ret_["dt_created_on"]	= date($this->conf["site_date_format"],intval($row->dt_created_on)); 
                  $ret_["i_is_active"]		= intval($row->i_status); 
				  $ret_["s_is_active"]		=(intval($row->i_status)==1?"Active":"Inactive");
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
                $s_qry.="s_title=? ";
                $s_qry.=",s_description=? ";				
                
                $s_qry.=", dt_created_on=? ";
                
                $this->db->query($s_qry,array(	
													  
													  get_formatted_string($info["s_title"]),
                                                      get_formatted_string($info["s_description"]),													 
                                                      intval($info["dt_created_on"])
                                                     ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(	
					                                    
                                                      get_formatted_string($info["s_title"]),
                                                      get_formatted_string($info["s_description"]),                                                     
                                                      intval($info["dt_created_on"])
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
                $s_qry.=" s_description=? ";				
                $s_qry.=", dt_updated_on=? ";
                $s_qry.=" Where i_id=? ";
                
                $this->db->query($s_qry,array(	
                                                       get_formatted_string($info["s_description"]),													 
                                                      intval($info["dt_updated_on"]),
													  intval($i_id) 
                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(	
                                                      get_formatted_string($info["s_description"]),													 
                                                      intval($info["dt_updated_on"]),
													  intval($i_id) 
                                                     )) ) ;                                
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                                
            }
            unset($s_qry, $i_id,$info);
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