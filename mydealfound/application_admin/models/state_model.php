<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 18 Jan 2013
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For State
* 
* @package General
* @subpackage state
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/state.php
* @link views/admin/state/
*/


class State_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
    private $tbl_country;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl 			= $this->db->STATE; 
          $this->tbl_country 	= $this->db->COUNTRY; 

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
			$s_qry="SELECT n.*,c.s_country FROM ".$this->tbl." n 
            		LEFT JOIN ".$this->tbl_country." c ON n.i_country_id = c.i_id "            
                	.($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]			= $row->i_id;////always integer
                  $ret_[$i_cnt]["s_state"]     	= get_unformatted_string($row->s_state); 
                  $ret_[$i_cnt]["s_country"]	= get_unformatted_string($row->s_country); 
				  $ret_[$i_cnt]["i_country_id"]	= intval($row->i_country_id); 
                  $ret_[$i_cnt]["i_status"]  	= intval($row->i_status); 
				  $ret_[$i_cnt]["s_status"]  	= (intval($row->i_status)==1?"Active":"Inactive");
                  
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
			$s_qry="SELECT n.*,c.s_country FROM ".$this->tbl." n 
            	    LEFT JOIN ".$this->tbl_country." c ON n.i_country_id = c.i_id " 
                    .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]			= $row->i_id;////always integer
                  $ret_[$i_cnt]["s_state"]     	= get_unformatted_string($row->s_state); 
                  $ret_[$i_cnt]["s_country"]	= get_unformatted_string($row->s_country); 
				  $ret_[$i_cnt]["i_country_id"]	= intval($row->i_country_id); 
                  $ret_[$i_cnt]["i_status"]  	= intval($row->i_status); 
				  $ret_[$i_cnt]["s_status"]  	= (intval($row->i_status)==1?"Active":"Inactive");
                  
                  $i_cnt++;
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$order_name,$order_by);
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
          $s_qry="SELECT COUNT(*) as i_total "
                ."FROM ".$this->tbl." n "
				."LEFT JOIN ".$this->tbl_country." c ON n.i_country_id = c.i_id "
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
          $s_qry="SELECT n.*,c.s_country "
                ."FROM ".$this->tbl." AS n  "
                ."LEFT JOIN ".$this->tbl_country." c ON n.i_country_id = c.i_id "
                ."WHERE n.i_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
        
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]			= $row->i_id;////always integer
                  $ret_["s_state"]     	= get_unformatted_string($row->s_state); 
                  $ret_["s_country"]	= get_unformatted_string($row->s_country); 
				  $ret_["i_country_id"]	= intval($row->i_country_id); 
                  $ret_["i_status"]  	= intval($row->i_status); 
				  $ret_["s_status"]  	= (intval($row->i_status)==1?"Active":"Inactive");
		  
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
                $s_qry.=" s_state=? ";
                $s_qry.=", i_country_id=? ";
                
                $this->db->query($s_qry,array(
												  get_formatted_string($info["s_state"]),
												  intval($info["i_country_id"])
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  get_formatted_string($info["s_state"]),
												  intval($info["i_country_id"])
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
				$s_qry.=" s_state=? ";
                $s_qry.=", i_country_id=? ";
                $s_qry.=" Where i_id=? ";
                
                $this->db->query($s_qry,array(
												get_formatted_string($info["s_state"]),
											    intval($info["i_country_id"]),
											    intval($i_id)

											 ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												get_formatted_string($info["s_state"]),
											    intval($info["i_country_id"]),
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

	/* change status */
	public function change_status($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";
				$s_qry.=" i_status= ? ";
                $s_qry.=" Where id=? ";
                //echo $i_id.$info['i_is_active'];
                $this->db->query($s_qry,array(	intval($info['i_is_active']),
												  intval($i_id)
                                                     ));
                $i_ret_=$this->db->affected_rows();   
				
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(	intval($info['i_is_active']),
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
    
    
    /**
    * This function is for select state by country id and from option for select box
    * this function call from ajax_common controler
    * 
    * @param mixed $id
    */
    function get_state_selectlist($id='')
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="SELECT s.i_id,s.s_state "
                ."FROM ".$this->tbl." AS s "
                ." WHERE s.i_country_id=?"
    			." ORDER BY s.s_state";
                
          $res=$this->db->query($s_qry,array(intval($id))); 
          $this->db->last_query();
          $info = $res->result_array();
          if($info)
           {
                foreach ($info as $val)
                {
                    $s_option .= "<option  value='".encrypt($val["i_id"])."' >".$val["s_state"]."</option>";
                }
           }

           unset($res, $info,$s_select,$id);
           return $s_option;
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