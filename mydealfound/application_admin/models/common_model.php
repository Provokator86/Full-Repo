<?php
/*********
* Author: Koushik Rout
* Date  : 10 January 2012
* Modified By: Jagannath Samanta
* Modified Date: 18 Feb 2012
* 
* Purpose:
*  Common Model is used for manipulating any table by passing arguments.
* 
* 
* @link InfModel.php 
* @link MY_Model.php
*/
class Common_model extends MY_Model implements InfModel
{
    private $conf;   
    
    public function __construct()
    {
        try
        {
          parent::__construct();
         
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
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }     
    

    
    /****
    * Fetch Total records
    * @param string @s_table_name 
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @returns int on success and FALSE if failed 
    */
    public function common_gettotal_info($s_table_name,$arr_where=null)
    {
        try
        {
            $ret_=0;

            $ret_ = $this->db->get_where($s_table_name,$arr_where) ; // CI function to fetch data
            $info   = $ret_->result_array(); 
        
          unset ($ret_);
          return count($info);

        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    } 
    
    /**
    * Count and Returns number of rows 
    * 
    * @param  string $s_table_name
    * @param  string $s_where
    * @return int
    */
    
    public function common_count_rows($s_table_name,$s_where=null)
    {
        try
        {
            $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$s_table_name." "
                .($s_where!=""?$s_where:"" );
                                 
          $rs=$this->db->query($s_qry);
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_=intval($row->i_total); 
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$s_where,$s_table_name);
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
                $s_qry="DELETE FROM ".$s_table_name." ";
                $s_qry.=" Where i_id=? ";
                $i_ret_=$this->db->query($s_qry, array(intval($i_id)) );
                if($i_ret_)
                {
                    $logi["msg"]="Deleting ".$s_table_name." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($i_id))) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                           
            }
            elseif(intval($i_id)==-1)////Deleting All
            {
                $s_qry="DELETE FROM ".$s_table_name." ";
                $i_ret_=$this->db->query($s_qry);       
                if($i_ret_)
                {
                    $logi["msg"]="Deleting all information from ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                
            }
            unset($s_qry, $i_id,$s_table_name);
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
    * Using CI function to fetch data
    * 
    * @param string $s_table_name
    * @param array $arr_where
    */
    
    public function common_fetch($s_table_name,$arr_where='',$offset='',$limit='' )
    {
        try
        {
            $info   = array();
            $ret_ = $this->db->get_where($s_table_name,$arr_where,$limit,$offset) ; // CI function to fetch data
            $info   = $ret_->result_array(); 
            //echo $this->db->last_query();
            
            unset ($ret_);
            return $info;
           
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    } 
    
    
    
    /**
    * Inserts new records into db. As we know the table name .
    * We have to pass two parameter array of data and table name 
    * 
    * @param String $table_name
    * @param Array $info
    * @return 0/1
    */
    public function common_add_info($s_table_name, $info)
    {
        try
        {
            $i_aff=0;
            $i_row_id=0;
            if(!empty($info))
            {
                if(!empty($info['s_password']))
                {
                     $info['s_password'] = md5(trim($info["s_password"]).$this->conf["security_salt"]);    
                }
                $i_aff  =   $this->db->insert($s_table_name,$info);

                if($i_aff)
                {
                    $i_row_id =   $this->db->insert_id();
                    $s_qry    =   $this->db->insert_string($s_table_name, $info);
                    
                    $logi["msg"]    =   "Inserting into ".$s_table_name." ";
                    $logi["sql"]    =   $s_qry ;
                     
                    $this->log_info($logi);
                    unset($s_qry);
                }

            }
            unset($info,$s_table_name,$i_aff);
            return $i_row_id;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    } 
    
    /***
    * Update table by condition
    * 
    * @param String $s_table_name
    * @param array $info
    * @param array $arr_where
    */

    public function common_edit_info($s_table_name,$info,$arr_where)
    {
        try
        {
            //$s_where = '"'.$s_where.'"';
            
            $i_aff=0;
            if(!empty($info) && $s_table_name!='')
            {
                if(!empty($info['s_password']))
                {
                     $info['s_password'] = md5(trim($info["s_password"]).$this->conf["security_salt"]);    
                }
                
                $i_aff  =   $this->db->update($s_table_name,$info,$arr_where);
				//echo $this->db->last_query().'<br>';
                if($i_aff)
                {
                    $s_qry  =   $this->db->update_string($s_table_name, $info,$arr_where);
                    
                    $logi["msg"]    =   "Updating ".$s_table_name." ";
                    $logi["sql"]    =   $s_qry ;
                    $this->log_info($logi);
                    unset($s_qry);
                }

            }
            unset($info,$s_table_name,$arr_where);
            return $i_aff;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    
    
    public function common_update_profile_view($s_table_name,$i_id)
    {
        try
        {
            $i_aff=0;
            if($i_id!='' && $s_table_name!='')
            {
                $sql = " UPDATE ".$s_table_name." SET i_profile_views = (i_profile_views +1) WHERE i_id =".$i_id." ";
                
                $i_aff = $this->db->query($sql);

                if($i_aff)
                {
                    echo $s_qry  =   $this->db->update_string($s_table_name, $info,$arr_where);
                    
                    $logi["msg"]    =   "Updating ".$s_table_name." ";
                    $logi["sql"]    =   $s_qry ;
                    $this->log_info($logi);
                    unset($s_qry);
                }

            }
            unset($info,$s_table_name,$arr_where);
            return $i_aff;
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
     public function common_delete_info($s_table_name,$arr_where)
    {
        try
        {
            $i_ret_=0;////Returns false
    
            if($s_table_name && !empty($arr_where))
            {
                $i_ret_=$this->db->delete($s_table_name,$arr_where);
                
                if($i_ret_)
                {
                    $logi["msg"]="Deleting ".$s_table_name." ";
                    $logi["sql"]= $this->db->last_query();
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                           
            }

            unset($s_table_name,$arr_where);
            return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }
    
    
    public function common_read_info_update($s_table_name,$info,$arr_where)
        {
            try 
                {
                     $i_aff=0;////Returns false
                      if($s_table_name && !empty($arr_where))
                            {
                             $i_aff  =   $this->db->update($s_table_name,$info,$arr_where);
                         }
                         /*echo $this->db->last_query();
                         exit;*/
                          if($i_aff)
                            {
                                $s_qry  =   $this->db->update_string($s_table_name, $info,$arr_where);
                    
                                $logi["msg"]    =   "Updating ".$s_table_name." ";
                                $logi["sql"]    =   $s_qry ;
                                $this->log_info($logi);
                                unset($s_qry);
                                }
                             
                              unset($s_table_name,$arr_where);
                                return $i_aff;
                     
                }
            catch(Exception $err_obj)
                {
                    show_error($err_obj->getMessage());
                    }    
        }
          
    
	/****
    * Fetch the id of the records
    * @param string @s_table_name 
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @returns i_id on success a 
    */
    public function getLastInsertedCountryId($s_table,$s_where=null,$field_name=null,$field_value=null)
    {
        try
        {
            $i_ret_ = 0;
			$s_qry = "SELECT i_id FROM ".$s_table." ".($s_where?$s_where:"")." ";
			$rs = $this->db->query($s_qry);
			
			if($rs->num_rows()>0)
          	{
				foreach($rs->result() as $row)
              	{
					$i_ret_ = $row->i_id;
				}
			}
			else
			{
				$new_qry = "INSERT INTO ".$s_table." SET ".$field_name." = '".$field_value."' ";
				$this->db->query($new_qry);
				$i_ret_ = $this->db->insert_id();
			}
			unset($s_qry,$rs,$new_qry,$s_table,$s_where,$field_name,$field_value);
			return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    } 
	
	public function getLastInsertedStateId($s_table,$s_where=null,$field_name=null,$field_value=array())
    {
        try
        {
            $i_ret_ = 0;
			$s_qry = "SELECT i_id FROM ".$s_table." ".($s_where?$s_where:"")." ";
			$rs = $this->db->query($s_qry);
			
			if($rs->num_rows()>0)
          	{
				foreach($rs->result() as $row)
              	{
					$i_ret_ = $row->i_id;
				}
			}
			else
			{
				$new_qry = "INSERT INTO ".$s_table." SET s_state = '".$field_value["s_state"]."', i_country_id='".$field_value["i_country_id"]."'  ";
				$this->db->query($new_qry);
				$i_ret_ = $this->db->insert_id();
			}
			unset($s_qry,$rs,$new_qry,$s_table,$s_where,$field_name,$field_value);
			return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }
	
	public function getLastInsertedCityId($s_table,$s_where=null,$field_name=null,$field_value=array())
    {
        try
        {
            $i_ret_ = 0;
			$s_qry = "SELECT i_id FROM ".$s_table." ".($s_where?$s_where:"")." ";
			$rs = $this->db->query($s_qry);
			
			if($rs->num_rows()>0)
          	{
				foreach($rs->result() as $row)
              	{
					$i_ret_ = $row->i_id;
				}
			}
			else
			{
				$new_qry = "INSERT INTO ".$s_table." SET s_city = '".$field_value["s_city"]."', i_country_id='".$field_value["i_country_id"]."', i_state_id='".$field_value["i_state_id"]."'  ";
				$this->db->query($new_qry);
				$i_ret_ = $this->db->insert_id();
			}
			unset($s_qry,$rs,$new_qry,$s_table,$s_where,$field_name,$field_value);
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