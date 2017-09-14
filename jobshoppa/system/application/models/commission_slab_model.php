<?php
/*********
* Author: Jagannath Samanta
* Date  : 18 June 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
* Model For Testimonial
* 
* @package Content Management
* @subpackage Testimonial
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/testimonial.php
* @link views/admin/testimonial/
*/


class Commission_slab_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->SLAB;          
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
                .($s_where!=""?$s_where:"" )." ORDER BY dt_entry_date DESC" .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->i_id;////always integer
                  $ret_[$i_cnt]["s_commission_slab_100"]=stripslashes(htmlspecialchars_decode($row->s_commission_slab_100)); 
				  $ret_[$i_cnt]["s_commission_greater_than_100"]=stripslashes(htmlspecialchars_decode($row->s_commission_greater_than_100)); 
                  $ret_[$i_cnt]["dt_entry_date"]=date($this->conf["site_date_format"],intval($row->dt_entry_date));
				  
                  $ret_[$i_cnt]["i_is_active"]=intval($row->i_is_active); 
				  $ret_[$i_cnt]["s_is_active"]=(intval($row->i_is_active)==1?"Active":"Inactive");
                  
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
	
	
	public function fetch_multi_order($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {
          	$ret_=array();
			$s_qry="SELECT * FROM ".$this->tbl." n "
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by} " .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->i_id;////always integer
                  $ret_[$i_cnt]["s_commission_slab_100"]=stripslashes(htmlspecialchars_decode($row->s_commission_slab_100)); 
				  $ret_[$i_cnt]["s_commission_greater_than_100"]=stripslashes(htmlspecialchars_decode($row->s_commission_greater_than_100)); 
                  $ret_[$i_cnt]["dt_entry_date"]=date($this->conf["site_date_format"],intval($row->dt_entry_date));
				  
                  $ret_[$i_cnt]["i_is_active"]=intval($row->i_is_active); 
				  $ret_[$i_cnt]["s_is_active"]=(intval($row->i_is_active)==1?"Active":"Inactive");
                  
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
                  $ret_["s_commission_slab_100"]=stripslashes(htmlspecialchars_decode($row->s_commission_slab_100));
				  $ret_["s_commission_greater_than_100"]=stripslashes(htmlspecialchars_decode($row->s_commission_greater_than_100));
				  
                  $ret_["dt_created_on"]=date($this->conf["site_date_format"],intval($row->dt_entry_date)); 
                  $ret_["i_is_active"]= intval($row->i_is_active); 
				  $ret_["s_is_active"]=(intval($row->i_is_active)==1?"Active":"Inactive");
		  
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
	
	
	
	
	
	// to show default in form 
	public function get_to_show_default()
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select * "
                ."From ".$this->tbl." AS n "
                ." Where n.i_is_active=?";
                
          $rs=$this->db->query($s_qry,array(intval(1))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]=$row->i_id;////always integer
                  $ret_["s_commission_slab_100"]=stripslashes(htmlspecialchars_decode($row->s_commission_slab_100));
				  $ret_["s_commission_greater_than_100"]=stripslashes(htmlspecialchars_decode($row->s_commission_greater_than_100)); 
                  $ret_["dt_created_on"]=date($this->conf["site_date_format"],intval($row->dt_entry_date)); 		  
				  
                  $ret_["i_is_active"]= intval($row->i_is_active); 
				  $ret_["s_is_active"]=(intval($row->i_is_active)==1?"Active":"Inactive");
		  
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
                $s_qry.=" s_commission_greater_than_100=? ";
                $s_qry.=", s_commission_slab_100=? ";
                $s_qry.=", i_is_active=? ";
                $s_qry.=", dt_entry_date=? ";
				
                $this->db->query($s_qry,array(
												  trim(htmlspecialchars($info["s_up_slab"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_below_slab"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_status"]),
												  intval($info["dt_entry_date"])
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
					$this->set_slab($info,$i_ret_); 
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  trim(htmlspecialchars($info["s_up_slab"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_below_slab"], ENT_QUOTES, 'utf-8')),
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
				 $s_qry.=" s_commission_greater_than_100=? ";
                $s_qry.=", s_commission_slab_100=? ";
                $s_qry.=", i_is_active=? ";
                $s_qry.=", dt_entry_date=? ";
                $s_qry.=" Where i_id=? ";
                
                $this->db->query($s_qry,array(
												  trim(htmlspecialchars($info["s_up_slab"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_below_slab"], ENT_QUOTES, 'utf-8')),
												  intval($info["i_status"]),
												  intval($info["dt_entry_date"]),
												  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   

                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  trim(htmlspecialchars($info["s_up_slab"], ENT_QUOTES, 'utf-8')),
												  trim(htmlspecialchars($info["s_below_slab"], ENT_QUOTES, 'utf-8')),
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
	
	
	
	/****  FOR CHECKING DEFAULT SLAB SLECTED   *****/
	public function set_slab($info,$id)
	{
		try
		{
			$i_ret_=0;////Returns false
			if(!empty($info))
			{
				if($info['i_status'] == 1)
				{
					$s_qry	=	"Update ".$this->tbl." Set ";
					$s_qry.=" i_is_active= ?";
					$s_qry.=" Where i_is_active=? ";
					
					$this->db->query($s_qry,array(
													intval(2),
													intval(1)
												));
					$i_ret_=$this->db->affected_rows();   
					
					$s_qry_1	=	"Update ".$this->tbl." Set ";
					$s_qry_1.=" i_is_active= ?";
					$s_qry_1.=" Where i_id=? ";
					
					$this->db->query($s_qry_1,array(
														intval($info["i_status"]),
														intval($id)
													));
					if($i_ret_)
					{
						$logi["msg"]="Updating ".$this->tbl." ";
						$logi["sql"]= serialize(array($s_qry,array(
													intval(2),
													intval(1)
												)) ) ;                                 
						$this->log_info($logi); 
						$logi_1["msg"]="Updating ".$this->tbl." ";
						$logi_1["sql"]= serialize(array($s_qry_1,array(
														intval($info["i_status"]),
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

	
    public function __destruct()
    {}                 
  
  
}
///end of class
?>