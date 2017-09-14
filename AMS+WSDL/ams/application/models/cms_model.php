<?php
/*********
* Author: Acumen CS
* Date  : 07 Feb 2014
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

class Cms_model extends MY_Model
{
    private $conf;
    private $tbl, $tbl_news, $mnu_page;///used for this class

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl        =   $this->db->CMS; 
          $this->tbl_news   =   $this->db->NEWS; 
          $this->mnu_page	=   $this->db->MENU_PAGE; 
		  $this->conf	    =   & get_config();
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
			if($s_where) $this->db->where($s_where, '', false);
			return $this->db->get($this->tbl, $i_limit, $i_start)->result_array();
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
			//if($s_where) $this->db->where($s_where, '' , false);
			//return $this->db->count_all($this->tbl);	$ret_=0;
          $s_qry="Select count(*) as i_total "
                 ."From ".$this->tbl." n "
                 .($s_where!=""?' WHERE '.$s_where:"" );
                
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
			return $this->db->get_where($this->tbl, array('i_id'=>$i_id))->result_array();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }      
    
    /*******
    * Fetches One record from db for the url value.
    * 
    * @param int $i_id
    * @returns array
    */
    public function fetch_this_content($s_url='')
    {
        try
        {
            if($s_url=='') return;
            $sql = "SELECT n.*,m.i_id AS main_page_id,m.i_parent_id AS parent_page_id FROM {$this->tbl} AS n "
                    ." LEFT JOIN {$this->mnu_page} AS m on m.page_id = n.i_id "
                    ." WHERE s_url='".$s_url."' ";
            $res = $this->db->query($sql);
            $rs = $res->result_array();
            return $rs[0];
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }  
    
    public function fetch_this_news($s_url='')
    {
        try
        {
            if($s_url=='') return;
            $sql = "SELECT * FROM {$this->tbl_news} WHERE s_url='".$s_url."' ";
            $res = $this->db->query($sql);
            $rs = $res->result_array();
            return $rs[0];
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
											  $info["s_title"],
											  $info["s_description"],							 
											  $info["dt_created_on"]
											 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(	
                                                      $info["s_title"],
                                                      $info["s_description"],
                                                      $info["dt_created_on"]
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
                                                       $info["s_description"],													 
                                                      $info["dt_updated_on"],
													  intval($i_id) 
                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(	
                                                      $info["s_description"],													 
                                                      $info["dt_updated_on"],
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
            return $this->write_log($attr["msg"],decrypt(get_userLoggedIn("user_id")),($attr["sql"]?$attr["sql"]:""));
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    } 
	
    public function __destruct()
    {} 
    
    /******
    * This method will fetch all records from the db. 
    * 
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @param int $i_start, starting value for pagination
    * @param int $i_limit, number of records to fetch used for pagination
    * @returns array
    */
    public function fetch_multi_menu_pages($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT n.*,c.s_url,c.s_title FROM ".$this->mnu_page." n "
            ." LEFT JOIN ".$this->tbl." AS c ON c.i_id = n.page_id "
            .($s_where!=""?$s_where:"" )
            .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            $rs=$this->db->query($s_qry);
            $i_cnt=0;
            if($rs->num_rows()>0)
            {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["i_id"]             =   $row->i_id;////always integer
                  $ret_[$i_cnt]["i_parent_id"]      =   $row->i_parent_id;
                  $ret_[$i_cnt]["page_id"]          =   $row->page_id;
                  $ret_[$i_cnt]["page_link"]        =   $row->page_link;
                  $ret_[$i_cnt]["s_url"]            =   $row->s_url;
                  $ret_[$i_cnt]["s_title"]          =   $row->s_title;
                  $ret_[$i_cnt]["sub_menus"]        =   $this->fetch_sub_menus($row->i_id);
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
    
    public function fetch_sub_menus($parent_id=null)
    {
        try
        {
            if(!$parent_id) return;
            $s_where = " WHERE n.i_parent_id ='".$parent_id."' ";
            $ret_=array();
            $s_qry="SELECT n.*,mp2.page_id AS parent_page_id,c.s_url,c.s_title FROM ".$this->mnu_page." n "
            ." LEFT JOIN ".$this->mnu_page." AS mp2 ON mp2.i_id = n.i_parent_id "
            ." LEFT JOIN ".$this->tbl." AS c ON c.i_id = n.page_id "
            .($s_where!=""?$s_where:"" )." ORDER BY n.page_order ASC "
            .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            $rs=$this->db->query($s_qry);
            $i_cnt=0;
            if($rs->num_rows()>0)
            {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["i_id"]         =   $row->i_id;////always integer
                  $ret_[$i_cnt]["i_parent_id"]  =   $row->i_parent_id;
                  $ret_[$i_cnt]["parent_page_id"]  =   $row->parent_page_id;
                  $ret_[$i_cnt]["page_id"]      =   $row->page_id;
                  $ret_[$i_cnt]["page_link"]    =   $row->page_link;
                  $ret_[$i_cnt]["s_url"]        =   $row->s_url;
                  $ret_[$i_cnt]["s_title"]      =   $row->s_title;
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
}
///end of class
?>
