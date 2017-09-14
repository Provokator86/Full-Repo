<?php
/*********
* Author: Koushik Rout
* Date  : 29 March 2012
* Modified By:  
* Modified Date: 
* 
* Purpose:
*  Model For  Category
* 
* @package General
* @subpackage Category
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/category.php
* @link views/admin/category/
*/


class Category_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
    private $s_lang_prefix;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl        =   $this->db->CATEGORY;        
          $this->conf       =   & get_config();
          $this->s_lang_prefix=   $this->session->userdata('lang_prefix');   // language prifix   
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
    public function fetch_multi($s_where=null,$i_start=null,$i_limit=null,$order_by=false)
    {
        try
        {
          $ret_=array();
            
          $s_qry="SELECT n.* FROM ".$this->tbl." n  "                                
                .($s_where!=""?$s_where:"" );
				if($order_by){
				$s_qry.=" ORDER BY RAND() ";
				}
				else
				{
				$s_qry.=" ORDER BY {$this->s_lang_prefix}_s_category_name COLLATE utf8_turkish_ci ";
				}
				$s_qry.=(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
                
              
         
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]               =   $row->i_id;////always integer
				  $ret_[$i_cnt]["s_icon"]  			=   get_unformatted_string($row->s_icon); 
                  $ret_[$i_cnt]["s_category_name"]  =   get_unformatted_string($row->{$this->s_lang_prefix.'_s_category_name'}); 
				  if($ret_[$i_cnt]["s_category_name"]=='')
				  {
				  $ret_[$i_cnt]["s_category_name"]  =   get_unformatted_string($row->{$this->site_default_lang_prefix.'_s_category_name'}); 
				  }
                  $ret_[$i_cnt]["dt_created_on"]    =   date($this->conf["site_date_format"],intval($row->dt_created_on)); 
                  $ret_[$i_cnt]["i_is_active"]      =   intval($row->i_status); 
                  $ret_[$i_cnt]["s_is_active"]      =   (intval($row->i_status)==1?"Active":"Inactive");
            
                  
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
    
    
    
    
    
    public function fetch_multi_sorted_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {
          $ret_=array();
            
          $s_qry="SELECT n.* FROM ".$this->tbl." n  "
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}"
				.(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
              
         
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  
                  $ret_[$i_cnt]["id"]               =   $row->i_id;////always integer
               
                  $ret_[$i_cnt]["s_category_name"]  =   get_unformatted_string($row->{$this->s_lang_prefix.'_s_category_name'}); 
				  if($ret_[$i_cnt]["s_category_name"]=='')
				  {
				  $ret_[$i_cnt]["s_category_name"]  =   get_unformatted_string($row->{$this->site_default_lang_prefix.'_s_category_name'}); 
				  }
                  
                  $ret_[$i_cnt]["dt_created_on"]    =   date($this->conf["site_date_format"],intval($row->dt_created_on)); 
                  $ret_[$i_cnt]["i_is_active"]      =   intval($row->i_status); 
                  $ret_[$i_cnt]["s_is_active"]      =   (intval($row->i_status)==1?"Active":"Inactive");
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
          $s_qry="Select n.* From ".$this->tbl." AS n "
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
                  $ret_["id"]               =   $row->i_id;////always integer
                  $ret_["s_category_name"]  =   get_unformatted_string($row->{$this->s_lang_prefix.'_s_category_name'});
                  if($ret_["s_category_name"]=='' && $s_prefix=='')
                  {
                  $ret_["s_category_name"]  =   get_unformatted_string($row->{$this->site_default_lang_prefix.'_s_category_name'}); 
                  }
				  $ret_["s_icon"]  			=   get_unformatted_string($row->s_icon);
                  $ret_["dt_created_on"]    =   date($this->conf["site_date_format"],intval($row->dt_created_on)); 
                  $ret_["i_is_active"]      =   intval($row->i_status); 
                  $ret_["s_is_active"]      =   (intval($row->i_status)==1?"Active":"Inactive");
                 
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_id,$s_prefix);
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
                //$s_qry.=" i_type_id=? "; 
                $s_qry.=" {$s_lang_prefix}_s_category_name=? ";
				$s_qry.=", s_icon=? ";
                $s_qry.=", dt_created_on=? "; 
               
                $this->db->query($s_qry,array(
                                                get_formatted_string($info["s_category_name"]),
												get_formatted_string($info["s_icon"]),
                                                intval($info["dt_created_on"])
                                                 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
                                                get_formatted_string($info["s_category_name"]),
												get_formatted_string($info["s_icon"]),
                                                intval($info["dt_created_on"])
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
                $s_lang_prefix  = get_formatted_string($info["s_lang_prefix"]); 
                $s_qry    =    "Update ".$this->tbl." Set ";               
                $s_qry.="  {$s_lang_prefix}_s_category_name=? ";
                $s_qry.=", s_icon=? ";
                $s_qry.=" Where i_id=? ";
                
                $i_ret_ = $this->db->query($s_qry,array( 
                                                get_formatted_string($info["s_category_name"]),
												get_formatted_string($info["s_icon"]),
                                                intval($i_id)
                                                ));
                                                    
                //$i_ret_=$this->db->affected_rows();   

                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array( 
                                                get_formatted_string($info["s_category_name"]),
												get_formatted_string($info["s_icon"]),
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
	
	  /******
    * This method will fetch all records from the db. 
    * 
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @param int $i_start, starting value for pagination
    * @param int $i_limit, number of records to fetch used for pagination
    * @returns array
    */
    public function test_category_fetch_multi($s_where=null,$i_start=null,$i_limit=null,$order_by=false)
    {
        try
        {
          $ret_=array();
            
          $s_qry="SELECT n.*,p.en_s_name,p.tr_s_name FROM ".$this->db->SUBCATEGORY." AS n "   
		   		." LEFT JOIN ".$this->db->PARENTCATEGORY." AS p "
				." ON p.i_id = n.i_parent_id "                             
                .($s_where!=""?$s_where:"" )
				." ORDER BY n.i_parent_id ASC ";		
						
		  $s_qry.=(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
                
              
         
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]               =   $row->i_id;////always integer
				  $ret_[$i_cnt]["i_parent_id"]      =   $row->i_parent_id;
                  $ret_[$i_cnt]["s_category_name"]  =   get_unformatted_string($row->{$this->s_lang_prefix.'_s_category_name'}); 
				  if($ret_[$i_cnt]["s_category_name"]=='')
				  {
				  $ret_[$i_cnt]["s_category_name"]  =   get_unformatted_string($row->{$this->site_default_lang_prefix.'_s_category_name'}); 
				  }    
				  
				  $ret_[$i_cnt]["s_parent_name"]  =   get_unformatted_string($row->{$this->s_lang_prefix.'_s_name'}); 
				  if($ret_[$i_cnt]["s_parent_name"]=='')
				  {
				  $ret_[$i_cnt]["s_parent_name"]  =   get_unformatted_string($row->{$this->site_default_lang_prefix.'_s_name'}); 
				  }              
            
                  
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
    

    public function __destruct()
    {}                 
  
  
}
///end of class
?>