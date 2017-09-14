<?php
/*********
* Author: Samarendu Ghosh
* Date  : 24 Oct 2011
* Modified By: 
* Modified Date: 
* 
* Purpose:
* Model For Job Radar
* 
* @package Content Management
* @subpackage Content
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/tradesman.php
* @link views/admin/tradesman/
*/


class Radar_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
	private $tbl_cms_master;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->RADAR; 
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
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["i_postal_code"]=get_unformatted_string($row->i_postal_code);
				  $ret_[$i_cnt]["i_radius"]= intval($row->i_radius);
                  $ret_[$i_cnt]["i_category_id"]= intval($row->i_category_id); 
				  $ret_[$i_cnt]["i_user_id"]= intval($row->i_user_id); 
                  
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
    * @param int $id
    * @returns array
    */
    public function fetch_this($id)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select * "
                ."From ".$this->tbl." AS c "
                ." Where c.i_user_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($id)));
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_["id"]=$row->id;////always integer
                  $ret_["i_postal_code"]=get_unformatted_string($row->i_postal_code);
				  $ret_["i_radius"]= intval($row->i_radius);
                  //$ret_["i_category_id"]= intval($row->i_category_id); 
				  /////////////// get categories  / ///////
				 if($ret_["id"])
				  {
				  $ret_["i_category_id"]			=	$this->get_radar_cat($ret_["id"]);
				  }
		  
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$id);
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
				$s_qry.=" i_user_id=? ";
                $s_qry.=", i_postal_code=? ";
                $s_qry.=", i_radius=? ";
				
                $s_qry.=", i_category_id=? ";
                
                $this->db->query($s_qry,array(	
													  intval(trim($info["i_user_id"])),
													  get_formatted_string($info["i_postal_code"]),
                                                      intval($info["i_radius"]),
                                                      intval($info["i_category_id"])
                                                     ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(	
													  intval(trim($info["i_user_id"])),
													  get_formatted_string($info["i_postal_code"]),
                                                      intval($info["i_radius"]),
                                                      intval($info["i_category_id"])
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
    * @param int $id, id value to be updated used in where clause
    * @returns $i_rows_affected  on success and FALSE if failed 
    */
    public function edit_info($info,$id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";
				$s_qry.=" i_user_id=? ";
                $s_qry.=", i_postal_code=? ";
                $s_qry.=", i_radius=? ";
				
                $s_qry.=", i_category_id=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(	
													  intval(trim($info["i_user_id"])),
													  get_formatted_string($info["i_postal_code"]),
                                                      intval($info["i_radius"]),
                                                      intval($info["i_category_id"]),
													  intval($id) 
                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(	
													  intval(trim($info["i_user_id"])),
													  get_formatted_string($info["i_postal_code"]),
                                                      intval($info["i_radius"]),
                                                      intval($info["i_category_id"]),
													  intval($id) 
                                                     )) ) ;                                
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
    /******
    * Deletes all or single record from db. 
    * For Master entries deletion only change the flag i_is_deleted. 
    *
    * @param int $id, id value to be deleted used in where clause 
    * @returns $i_rows_affected  on success and FALSE if failed 
    * 
    */
    public function delete_info($id)
    {
        try
        {
            $i_ret_=0;////Returns false
    
            if(intval($id)>0)
            {
				$s_qry="DELETE FROM ".$this->tbl." ";
                $s_qry.=" Where id=? ";
                $this->db->query($s_qry, array(intval($id)) );
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Deleting ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($id))) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                           
            }
            elseif(intval($id)==-1)////Deleting All
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
	
	
	function get_radar_cat($id)
	{
         $ret_=array();
		 $s_qry="SELECT * FROM ".$this->db->RADAR_CAT." WHERE i_radar_id = ".$id;
		 //echo "<br/> 2::".$s_qry."<br/>";		
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  $ret_[$i_cnt]["i_radar_id"]= intval($row->i_radar_id);
                  $ret_[$i_cnt]["i_category_id"]= intval($row->i_category_id); 
                  
                  $i_cnt++;
              }    
              $rs->free_result();          
          }
       
          return $ret_;
          
        
		
	}
	
	
	function del_radar_cat($i_radar_id)
	{
		$s_qry="DELETE FROM ".$this->db->RADAR_CAT." WHERE i_radar_id=".$i_radar_id;
		$this->db->query($s_qry);
		$i_ret_=$this->db->affected_rows();        
		if($i_ret_)
		{
			$logi["msg"]="Deleting information from ".$this->db->RADAR_CAT." ";
			$logi["sql"]= serialize(array($s_qry) ) ;
			$this->log_info($logi); 
			unset($logi,$logindata);
		}            
	}
	
	function get_radar_cat_name($s_where)
	{
         $ret_=array();
		 /*$s_qry="SELECT DISTINCT cat_l.s_name
		 		FROM {$this->db->CATEGORY} c				
				LEFT JOIN {$this->db->CATEGORYCHILD}  cat_l
				ON c.id = cat_l.i_cat_id
				$s_where";*/
		$s_qry="SELECT DISTINCT c.s_category_name FROM {$this->db->CATEGORY} c	{$s_where} ";		
				
          $rs=$this->db->query($s_qry);
		  //echo $this->db->last_query();
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[]= get_unformatted_string($row->s_name);                   
                  $i_cnt++;
              }    
              $rs->free_result();          
          }
       
          return $ret_;
          
        
		
	}
	
	function set_data_insert($tableName,$arr)
    {
        if( !$tableName || $tableName=='' ||  count($arr)==0 )
			return false;
		if($this->db->insert($tableName, $arr))
            return $this->db->insert_id();
        else
            return false;
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