<?php
/*********
* Author: ACS
* Date  : 04 June 2014
* Modified By: 
* Modified Date:
* Purpose:
* Controller For manage food dining store
* @package Food & Dining
* @subpackage Manage Store
* @link InfController.php 
* @link My_Controller.php
* @link model/food_dining_model.php
* @link views/admin/food_dining_store/
*/

class Food_dining_model extends MY_Model
{
    private $conf;
    public $tbl_food_store, $tbl_food_offer, $tbl_food;///used for this class

    public function __construct()
    {
        try
        {
          	parent::__construct();
			$this->tbl_food_store 	= $this->db->FOOD_STORE; 
			$this->tbl_food_offer	= $this->db->FOOD_OFFER;	
			$this->tbl_food			= $this->db->FOOD;			
          	$this->conf =& get_config();

        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          

    }

    /******
    * This method will fetch all records from the db. 
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @param int $i_start, starting value for pagination
    * @param int $i_limit, number of records to fetch used for pagination
    * @returns array
    */

    public function fetch_multi($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {  
			$s_qry="SELECT * FROM ".$this->tbl_food 
				   .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
			
			$query		= $this->db->query($s_qry);   
			$result_arr	= $query->result_array();	
			return $result_arr;          

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
			$s_qry="SELECT * FROM ".$this->tbl_food.
				($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
			$query		= $this->db->query($s_qry);// echo $this->db->last_query();exit;  
			$result_arr	= $query->result_array();	
			return $result_arr;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }    
	}
	
	public function fetch_multi_store_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
	{
        try
        {
			$ret_=array();
			$s_qry="SELECT * FROM ".$this->tbl_food_store.
				($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
			$query		= $this->db->query($s_qry); 
			$result_arr	= $query->result_array();	
			return $result_arr;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }    
	}
	
	public function fetch_multi_offer_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
	{
        try
        {
			$ret_=array();
			$s_qry="SELECT * FROM ".$this->tbl_food_offer.
				($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
			$query		= $this->db->query($s_qry); 
			$result_arr	= $query->result_array();	
			return $result_arr;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }    
	}
	
	
	public function get_food_dining_list($s_where=null,$i_start=null,$i_limit=null,$order_by = false) 
	{
		
		$s_order = '';
		if($order_by)
		{
			$s_order .=$order_by;
		}
		else
		{
			$s_order .=" ORDER BY p.dt_date_of_entry DESC ";
		}
		$ret_=array();
		$s_qry="SELECT p.*,s.s_store_title,s.s_store_logo,s.s_store_url,of.s_offer FROM ".$this->tbl_food." AS p ".
			"LEFT JOIN ".$this->tbl_food_store." AS s ON s.i_id = p.i_store_id ".
			"LEFT JOIN ".$this->tbl_food_offer." AS of ON of.i_id = p.i_type ".
		($s_where!=""?$s_where:"" ).($s_order!=""?$s_order:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		$rs=$this->db->query($s_qry);
		/*echo $this->db->last_query();
		echo '</br>';*/
		$ret_ = $rs->result_array();		
		unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$order_name,$order_by);
		return $ret_;
    }
	
	public function count_food_dining_list($s_where=null) 
	{
		$ret_=0;
		$s_qry="SELECT COUNT(p.i_id) as i_total "
			."FROM ".$this->tbl_food." p "
			."LEFT JOIN ".$this->tbl_food_store." AS s ON s.i_id = p.i_store_id "
			."LEFT JOIN ".$this->tbl_food_offer." AS of ON of.i_id = p.i_type "
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

	public function gettotal_store_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl_food_store
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
	
	public function gettotal_offer_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl_food_offer
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
                ."From ".$this->tbl_food
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
    * @param int $i_id
    * @returns array
    */
    public function fetch_this($i_id)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
				$s_query="SELECT * 
						 FROM ".$this->tbl_food."
						 WHERE i_id='".($i_id)."'";
				//echo $s_query;exit;
                $rs=$this->db->query($s_query); 
          		return ($rs->result_array());
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    } 
	
	public function fetch_this_store($i_id)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
				$s_query="SELECT * 
						 FROM ".$this->tbl_food_store."
						 WHERE i_id='".($i_id)."'";
				//echo $s_query;exit;
                $rs=$this->db->query($s_query); 
          		return ($rs->result_array());
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    } 
	
	public function fetch_this_offer($i_id)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
				$s_query="SELECT * 
						 FROM ".$this->tbl_food_offer."
						 WHERE i_id='".($i_id)."'";
				//echo $s_query;exit;
                $rs=$this->db->query($s_query); 
          		return ($rs->result_array());
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }           


    /***
    * Inserts new records into db. As we know the table name 
    * we will not pass it into params.
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @returns $i_new_id  on success and FALSE if failed 
    */
    public function add_info($info)
    {
        try
        { //print_r ($info);exit;
            $sql = $this->db->insert_string($this->tbl_food,$info); 
			if($this->db->simple_query($sql))
			{
				$this_id	= $this->db->insert_id();
				return $this_id;	
			}
			else
			{
			   return FALSE; //error
			}
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          

    } 
	
	public function add_store_info($info)
    {
        try
        { //print_r ($info);exit;
            $sql = $this->db->insert_string($this->tbl_food_store,$info); 
			if($this->db->simple_query($sql))
			{
				$this_id	= $this->db->insert_id();
				return $this_id;	
			}
			else
			{
			   return FALSE; //error
			}
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          

    }
	
	public function add_offer_info($info)
    {
        try
        { //print_r ($info);exit;
            $sql = $this->db->insert_string($this->tbl_food_offer,$info); 
			if($this->db->simple_query($sql))
			{
				$this_id	= $this->db->insert_id();
				return $this_id;	
			}
			else
			{
			   return FALSE; //error
			}
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          

    }

    /***
    * Update records in db. As we know the table name 
    * we will not pass it into params.
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
				$where=array("i_id"=>$i_id);
				$sql = $this->db->update_string($this->tbl_food,$info,$where);
				//echo $sql;exit;
				if($this->db->simple_query($sql))
				{
					return	$this->db->affected_rows();
				}
				else
				{
					return FALSE; //error
				}
            }
            unset($s_qry, $info,$i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          

    } 
	
	public function edit_store_info($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            { 
				$where=array("i_id"=>$i_id);
				$sql = $this->db->update_string($this->tbl_food_store,$info,$where);
				//echo $sql;exit;
				if($this->db->simple_query($sql))
				{
					return	$this->db->affected_rows();
				}
				else
				{
					return FALSE; //error
				}
            }
            unset($s_qry, $info,$i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          

    }  
	
	public function edit_offer_info($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            { 
				$where=array("i_id"=>$i_id);
				$sql = $this->db->update_string($this->tbl_food_offer,$info,$where);
				//echo $sql;exit;
				if($this->db->simple_query($sql))
				{
					return	$this->db->affected_rows();
				}
				else
				{
					return FALSE; //error
				}
            }
            unset($s_qry, $info,$i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          

    }     

    /******
    * Deletes all or single record from db.
    * For Master entries deletion only change the flag i_is_deleted. 
    * @param int $i_id, id value to be deleted used in where clause 
    * @returns $i_rows_affected  on success and FALSE if failed 
    */
    public function delete_info($i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(intval($i_id)>0)
            {
				$s_qry="DELETE FROM ".$this->tbl_food." ";
                $s_qry.=" Where i_id=? ";
                $this->db->query($s_qry, array(intval($i_id)) );
                $i_ret_=$this->db->affected_rows();  
                if($i_ret_)
                {
                    $logi["msg"]="Deleting ".$this->tbl_food." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($i_id))) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                } 
            }
            elseif(intval($i_id)==-1)////Deleting All
            {
				$s_qry="DELETE FROM ".$this->tbl_food." ";
                $this->db->query($s_qry);
                $i_ret_=$this->db->affected_rows();  
                if($i_ret_)
                {
                    $logi["msg"]="Deleting all information from ".$this->tbl_food." ";
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
	
	 /******
    * Deletes all or single record from db.
    * For Master entries deletion only change the flag i_is_deleted. 
    * @param int $i_id, id value to be deleted used in where clause 
    * @returns $i_rows_affected  on success and FALSE if failed 
    */
    public function delete_store_info($i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(intval($i_id)>0)
            {
				$s_qry="DELETE FROM ".$this->tbl_food_store." ";
                $s_qry.=" Where i_id=? ";
                $this->db->query($s_qry, array(intval($i_id)) );
                $i_ret_=$this->db->affected_rows();  
                if($i_ret_)
                {
                    $logi["msg"]="Deleting ".$this->tbl_food_store." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($i_id))) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                } 
            }
            elseif(intval($i_id)==-1)////Deleting All
            {
				$s_qry="DELETE FROM ".$this->tbl_food_store." ";
                $this->db->query($s_qry);
                $i_ret_=$this->db->affected_rows();  
                if($i_ret_)
                {
                    $logi["msg"]="Deleting all information from ".$this->tbl_food_store." ";
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
	
	 public function delete_offer_info($i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(intval($i_id)>0)
            {
				$s_qry="DELETE FROM ".$this->tbl_food_offer." ";
                $s_qry.=" Where i_id=? ";
                $this->db->query($s_qry, array(intval($i_id)) );
                $i_ret_=$this->db->affected_rows();  
                if($i_ret_)
                {
                    $logi["msg"]="Deleting ".$this->tbl_food_offer." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($i_id))) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                } 
            }
            elseif(intval($i_id)==-1)////Deleting All
            {
				$s_qry="DELETE FROM ".$this->tbl_food_offer." ";
                $this->db->query($s_qry);
                $i_ret_=$this->db->affected_rows();  
                if($i_ret_)
                {
                    $logi["msg"]="Deleting all information from ".$this->tbl_food_offer." ";
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

	public function change_status($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl_food." Set ";
				$s_qry.=" i_is_active= ? ";
                $s_qry.=" Where i_id=? ";
                //echo $i_id.$info['i_is_active'];
                $i_ret_=$this->db->query($s_qry,array(	intval($info['i_is_active']),
												  intval($i_id)
                                                     ));
													 

				/*if($info['i_is_active']==0)
				{
					$sql="UPDATE ".$this->tbl_food." Set i_is_hot = 0, i_is_discount = 0 WHERE i_id=".$i_id;
					$rs=$this->db->query($sql);
				}*/		

                if($i_ret_)
                {

                    $logi["msg"]="Updating ".$this->tbl_food." ";
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
	
	public function change_store_status($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl_food_store." Set ";
				$s_qry.=" i_is_active= ? ";
                $s_qry.=" Where i_id=? ";
                //echo $i_id.$info['i_is_active'];
                $i_ret_=$this->db->query($s_qry,array(	intval($info['i_is_active']),
												  intval($i_id)
                                                     ));
													 

				
                if($i_ret_)
                {

                    $logi["msg"]="Updating ".$this->tbl_food_store." ";
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
	
	public function change_offer_status($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl_food_offer." Set ";
				$s_qry.=" i_is_active= ? ";
                $s_qry.=" Where i_id=? ";
                //echo $i_id.$info['i_is_active'];
                $i_ret_=$this->db->query($s_qry,array(	intval($info['i_is_active']),
												  intval($i_id)
                                                     ));
													 

				
                if($i_ret_)
                {

                    $logi["msg"]="Updating ".$this->tbl_food_offer." ";
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

	public function get_offer()
    {
        try
        {  
          	$s_qry="SELECT * FROM ".$this->tbl_food_offer." WHERE i_is_active=1 ORDER BY s_offer ASC ";
			$rs		= $this->db->query($s_qry); 
			//pr($s_qry,1);
			$i_cnt=0;
			foreach ($rs->result() as $row)		
			{		
				$ret_[$row->i_id] = $row->s_offer;//always integer		
				$i_cnt++;		
			}

			return $ret_;  
			return $result_arr;          

        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          

    }
	
	
	public function get_store()
    {
        try
        {  
          	$s_qry="SELECT * FROM ".$this->tbl_food_store." WHERE i_is_active=1 ORDER BY s_store_title ASC ";
			$rs		= $this->db->query($s_qry); 
			//pr($s_qry,1);
			$i_cnt=0;
			foreach ($rs->result() as $row)		
			{		
				$ret_[$row->i_id] = $row->s_store_title;//always integer		
				$i_cnt++;		
			}

			return $ret_;  
			return $result_arr;          

        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          

    }
	
	
	public function check_in_food_table($id)
    {
        try
        {
			$s_qry="SELECT COUNT(*) AS TOTAL 
				 FROM ".$this->tbl_food."
				 WHERE i_store_id='".my_receive($id)."'";
			$query=$this->db->query($s_qry);
			if($query->num_rows()>0)
			{
			  foreach($query->result() as $row)
			  {
				  $ret_=intval($row->TOTAL); 
			  }    
			  $query->free_result();         
			
			}
          //unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit);
          return $ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    } 
	
	public function check_offer_in_food_table($id)
    {
        try
        {
			$s_qry="SELECT COUNT(*) AS TOTAL 
				 FROM ".$this->tbl_food."
				 WHERE i_type='".my_receive($id)."'";
			$query=$this->db->query($s_qry);
			if($query->num_rows()>0)
			{
			  foreach($query->result() as $row)
			  {
				  $ret_=intval($row->TOTAL); 
			  }    
			  $query->free_result();         
			
			}
          //unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit);
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