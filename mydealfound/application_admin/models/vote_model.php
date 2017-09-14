<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 07 jan 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For Admin user
* 
* @package Content Management
* @subpackage user_admin
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/user_admin.php
* @link views/admin/user_admin/
*/

class vote_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
	

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->VOTE;
		  $this->tbl_cmnt = $this->db->COMMENT; 
		  		         
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
        {   //echo $s_where;exit;
			//echo $this->tbl;
          	$s_qry="SELECT * FROM ".$this->tbl 
				   /*.($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" )*/;

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
			$s_qry="SELECT * FROM ".$this->tbl.
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
                ."From ".$this->tbl
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
    
	
	
 public function getavg_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select AVG(i_vote) as i_total "
                ."From ".$this->tbl
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
          /*$s_qry="Select n.*,m.s_user_type "
                ."From ".$this->tbl." AS n "
				." LEFT JOIN ".$this->tbl_master. " m "
				." ON n.i_user_type=m.i_id "
                ." Where n.i_id=?";*/
				
				$s_query="SELECT * 
						 FROM ".$this->tbl."
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
    * 
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @returns $i_new_id  on success and FALSE if failed 
    */
    public function add_info($info)
    {
        try
        { //print_r ($info);exit;
            $sql = $this->db->insert_string($this->tbl,$info);
		
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
    * 
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @param int $i_id, id value to be updated used in where clause
    * @returns $i_rows_affected  on success and FALSE if failed 
    */
    public function edit_info($info,$i_id)
    { //echo "aaaaaaaa";
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            { 
				$where=array("i_id"=>$i_id);
				$sql = $this->db->update_string($this->tbl,$info,$where);
				//echo $sql;
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
                $s_qry.=" Where i_id=? ";
                //echo $i_id.$info['i_is_active'];
				//echo $s_qry;exit;
                $i_ret_=$this->db->query($s_qry,array(	intval($info['i_status']),
												  intval($i_id)
                                                     ));
                			
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
	



















 public function fetch_multi_industry($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {   //echo $s_where;exit;
			//echo $this->tbl;
          	$s_qry="SELECT * FROM ".$this->tbl 
				   .($s_where!=""?$s_where:"" );

			  $query		= $this->db->query($s_qry);          
			  $result_arr	= $query->result_array();				
			  
			  return $result_arr;          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	


 
 
 /* first check if the industry exist in the databse or not
 * if exist returns its id and if not exist then insert first then return the insert id
 */
public function get_industry_id($s_name)
{
  $i_ret = 0;
  $s_qry = " SELECT i_id FROM ".$this->tbl." WHERE s_title = '".$s_name."' ";
  $query		= $this->db->query($s_qry);
  $result_arr	= $query->result_array();
  $no_of_row    = count($result_arr[0]);
  //pr($result_arr,1);
 if($no_of_row)
  {
	  return ($result_arr[0]['i_id']);
  }
  else
  {
  	// insert here and return id
	$info['s_title']= $s_name;
	$info['i_is_active']=1;
	$id=$this->add_info($info);
	return $id;
  }
  return $i_ret;
}
	
public function get_vote_details($id,$start=0,$limit)
    {
        try
        {   //echo $s_where;exit;
			//echo $this->tbl;
			
          $s_qry="SELECT * FROM ".$this->tbl." WHERE i_store_id=".$id .(($limit && $start)?' LIMIT '.$start.','.$limit:'');

			  $query		= $this->db->query($s_qry);          
			  $result_arr	= $query->result_array();				
			  
			  return $result_arr;          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }	
	
	
	
public function get_comments_details($id)
    {
        try
        {   
          	$s_qry="SELECT * FROM ".$this->tbl_cmnt." WHERE i_coupon_id=".$id;

			  $query		= $this->db->query($s_qry);          
			  $result_arr	= $query->result_array();				
			  
			  return $result_arr;          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }	


public function gettotal_vote($id)
    {
        try
        {
          $ret_=0;
          $s_qry="SELECT COUNT(*) FROM ".$this->tbl_cmnt." WHERE i_coupon_id=".$id;
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


public function check_whether_voted($ip,$store_ip)
    {
        try
        {
          $ret_=0;
          $s_qry="SELECT COUNT(*) as i_total FROM ".$this->tbl." WHERE i_ip='".$ip."' AND i_store_id=".$store_ip;
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
	
	
    public function __destruct()
    {}                 
  
  
}
///end of class
?>