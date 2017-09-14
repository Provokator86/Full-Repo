<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 17 Mar 2014
* Modified By: 
* Modified Date:
* Purpose:
*  Model For OMGP Product Manage
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/manage_product.php
* @link views/admin/user_admin/
*/



class Product_model_omgp extends MY_Model implements InfModel
{

    private $conf;
    private $tbl;///used for this class
	private $tbl_cat;
	private $tbl_store;
	private $tbl_store_cat_map;
	

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->COUPON; 
		  $this->tbl_cat = $this->db->CATEGORY; 
		  $this->tbl_store = $this->db->STORE;
		  //$this->tbl_store_cat_map=$this->db->CATEGORY_STORE_MAP
		  
		  
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
			$s_qry="SELECT * FROM ".$this->tbl 
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
			$s_qry="SELECT * FROM ".$this->tbl.
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
	
	/********************************** PRODUCT UPLOAD FUNCTIONS USED BELOW ************************/
	/* check which category to be skip */
	public function fetch_category_skip($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {   
			$s_qry="SELECT * FROM cd_category_store_skip " 
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
	
	
	public function fetch_category_map($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {   
			$s_qry="SELECT * FROM cd_category_store_map " 
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
	
	public function add_category_store_map($info)
    {
        try
        { 
            $sql = $this->db->insert_string('cd_category_store_map',$info);
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
	
	public function add_category_store_skip($info)
    {
        try
        { 
            $sql = $this->db->insert_string('cd_category_store_skip',$info);
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
	
	public function add_flipkart_product($info)
    {
        try
        { 
            $sql = $this->db->insert_string($this->tbl,$info);
			$sql = str_replace('INSERT INTO','REPLACE INTO',$sql);
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
	
	
	public function add_jabong_product($info)
    {
        try
        { 
            $sql = $this->db->insert_string($this->tbl,$info);
			$sql = str_replace('INSERT INTO','REPLACE INTO',$sql);
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
	
	
	/********************************** END PRODUCT UPLOAD FUNCTIONS USED ************************/
	
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
			$s_query="SELECT * FROM ".$this->tbl." WHERE i_id='".($i_id)."'";
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
        { 
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
    * Inserts new records into db. As we know the table name 
    * we will not pass it into params.
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @returns $i_new_id  on success and FALSE if failed 
    */
    public function insert_record_with_key($info,$start_key=0)
    {
        try
        { 
			$start = $start_key;
			if(!empty($info))
			{
				for($i=$start;$i<count($info);$start++)
				{
					$arr_set = $info[$start];
					$sql = $this->db->insert_string($this->tbl,$arr_set);
					
					/*if($this->db->simple_query($sql))
					{
						$this_id	= $this->db->insert_id();
						return $this_id;
					}
					else
					{
					   return FALSE; //error
					}*/
				}
			}
			else
				return false;
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
				 $sql = $this->db->update_string($this->tbl,$info,$where);
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
	
	
	/*******
    * Fetches One record from db for the id value.
    * @param int $i_id
    * @returns array
    */
    public function fetch_store_detail($i_id)
    {
        try
        {
          	$ret_=array();
			$s_query="SELECT * FROM ".$this->tbl_store." WHERE i_id='".($i_id)."'";
			$rs=$this->db->query($s_query); 
			return ($rs->result_array());
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    }
	
	
	/****
    * get category id or insert new category
    * @param mixed $name example: Accessories < Men's Shoes < Chappal etc.
    * @returns TRUE on success and FALSE if failed 
    */
    public function getCategoryIdForSeperator($name='',$sep="'\'")
    {
		$ret_=0;
		if($name!='')        
		{
			$arr_path = explode($sep,$name);
			$count = count($arr_path);
			if($count>1)
			{
				// multiple node
				$pc = trim($arr_path[$count-2]);
				$mc = trim($arr_path[$count-1]);									
				$ret_ = $this->getCategoryMultiple($pc,$mc);
			}
			else
			{
				// single node
				$ret_ = $this->getCategoryMultiple($arr_path[0],$mc);  // defined below
			}
			
		}
		return $ret_;
    }
	
	 /****
    * get category id or insert new category
    * @param mixed $name example: Accessories < Men's Shoes < Chappal etc.
    * @returns TRUE on success and FALSE if failed 
    */
    public function getCategoryId($name='')
    {
		$ret_=0;
		if($name!='')        
		{
			$arr_path = explode('>',$name);
			$count = count($arr_path);
			if($count>1)
			{
				// multiple node
				$pc = trim($arr_path[$count-2]);
				$mc = trim($arr_path[$count-1]);									
				$ret_ = $this->getCategoryMultiple($pc,$mc);
			}
			else
			{
				// single node
				$ret_ = $this->getCategoryMultiple($arr_path[0],$mc);  // defined below
			}
			
		}
		return $ret_;
    }
	
	
	
	public function getCategoryMultiple($pc='',$mc='')
    {
		$ret_=0;
		$parent_id = 0;
		if($mc!='')        
		{
			$sql = "SELECT i_id FROM ".$this->tbl_cat." WHERE s_category ='".my_receive_text($pc)."' ";
			$rs=$this->db->query($sql); 
			$res = $rs->result_array();
			if(!empty($res))
				$parent_id = $res[0]["i_id"];
			else
			{
				$info = array();
				$info["i_parent_id"] 	= 0;
				$info["s_category"] 	= $pc;
				$info["i_status"] 		= 1;
				$info["e_show_in_frontend"] 		= 1;
				
				$sql = $this->db->insert_string($this->tbl_cat,$info);
				if($this->db->simple_query($sql))
				{
					$this_id	= $this->db->insert_id();
					$parent_id =  $this_id;
				}
			}
				
			if($parent_id)
			{
				$sql = "SELECT i_id FROM ".$this->tbl_cat." WHERE s_category ='".my_receive_text($mc)."' ";
				$rs=$this->db->query($sql); 
				$res = $rs->result_array();
				if(!empty($res))
					$ret_ = $res[0]["i_id"];
				else
				{
					$info = array();
					$info["i_parent_id"] 	= $parent_id;
					$info["s_category"] 	= $mc;
					$info["i_status"] 		= 1;
					$info["e_show_in_frontend"]= 1;
					
					$sql = $this->db->insert_string($this->tbl_cat,$info);
					if($this->db->simple_query($sql))
					{
						$this_id	= $this->db->insert_id();
						$ret_ =  $this_id;
					}
				}
			}				
		}
		else
		{
			$sql = "SELECT i_id FROM ".$this->tbl_cat." WHERE s_category ='".my_receive_text($pc)."' ";
			$rs=$this->db->query($sql); 
			$res = $rs->result_array();
			if(!empty($res))
				$ret_ = $res[0]["i_id"];
			else
			{
				$info = array();
				$info["i_parent_id"] 	= 0;
				$info["s_category"] 	= $pc;
				$info["i_status"] 		= 1;
				$info["e_show_in_frontend"]= 1;
				
				$sql = $this->db->insert_string($this->tbl_cat,$info);
				if($this->db->simple_query($sql))
				{
					$this_id	= $this->db->insert_id();
					$ret_ =  $this_id;
				}
			}
		}
		return $ret_;
    }
	
	public function getStoreId($name='')
    {
		$ret_=0;
		if($name!='')        
		{
			$name = str_replace(".com","",$name);
			$name = str_replace(".in","",$name);
			
			$sql = "SELECT i_id FROM ".$this->tbl_store." WHERE s_store_title ='".my_receive_text($name)."' ";
			$rs=$this->db->query($sql); 
			$res = $rs->result_array();
			if(!empty($res))
				$ret_ = $res[0]["i_id"];
		}
		return $ret_;
    }

    public function __destruct()

    {}  

}
?>