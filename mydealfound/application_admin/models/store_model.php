<?php
/*********
* Author: MM
* Date  : 07 jan 2013
* Modified By: 
* Modified Date:
* Purpose:
*  Model For Admin user
* @package Content Management
* @subpackage user_admin
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/user_admin.php
* @link views/admin/user_admin/
*/

class store_model extends MY_Model implements InfModel
{

    private $conf;
    private $tbl;///used for this class

    public function __construct()
    {
        try
        {

          	parent::__construct();
			$this->tbl = $this->db->STORE; 
			$this->tbl_cat=$this->db->CATEGORY;
			$this->tbl_cpn=$this->db->COUPON;
			$this->tbl_brand=$this->db->BRAND;
			$this->tbl_offer=$this->db->OFFER;
			$this->tbl_store=$this->db->STORE; 		         
			$this->tbl_affi=$this->db->AFFILIATES;
			
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

	/*public function change_status($info,$i_id)

    {

        try

        {

            $i_ret_=0;////Returns false

            if(!empty($info))

			 {

                $s_qry	=	"Update ".$this->tbl." Set ";

				$s_qry.=" i_is_active= ? ";

                $s_qry.=" Where i_id=? ";

                //echo $i_id.$info['i_is_active'];

                $i_ret_=$this->db->query($s_qry,array(	intval($info['i_is_active']),

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

    } */

	

	

	

	

	public function change_status($info,$i_id)

    {

        try

        {

            $i_ret_=0;////Returns false

            if(!empty($info))

            {

                $s_qry	=	"Update ".$this->tbl." Set ";

				$s_qry.=" i_is_active= ? ";

                $s_qry.=" Where i_id=? ";

                //echo $i_id.$info['i_is_active'];

                $i_ret_=$this->db->query($s_qry,array(	intval($info['i_is_active']),

												  intval($i_id)

                                                     ));

													 

				if($info['i_is_active']==0)

				{

					$sql="UPDATE ".$this->tbl." Set i_is_hot = 0, i_is_discount = 0 WHERE i_id=".$i_id;

					$rs=$this->db->query($sql);

				}

                			

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

	



public function search_result1($ind_id)

{

  //echo "111";

   $s_qry="SELECT * FROM pl_startup_personal WHERE {$ind_id} IN( s_industry1,s_industry2, s_industry3 )";

  $query		= $this->db->query($s_qry);          

			  $result_arr	= $query->result_array();				

			  

			  return $result_arr;          

  //exit;

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



 public function get_category()

    {

        try

        {   //echo $s_where;exit;

			//echo $this->tbl;

          	$s_qry="SELECT * FROM ".$this->tbl_cat." WHERE i_status=1 ORDER BY s_category ASC";

			$rs		= $this->db->query($s_qry); 

			//pr($query,1);

			$i_cnt=0;

	foreach ($rs->result() as $row)

	{

		$ret_[$row->i_id] = $row->s_category;//always integer

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

		

 public function get_brand()

    {

        try

        {   //echo $s_where;exit;

			//echo $this->tbl;

          	$s_qry="SELECT * FROM ".$this->tbl_brand." WHERE i_is_active=1 ORDER BY s_brand_title ASC";

			$rs		= $this->db->query($s_qry); 

			//pr($s_qry,1);

			$i_cnt=0;

	foreach ($rs->result() as $row)

	{

		$ret_[$row->i_id] = $row->s_brand_title;//always integer

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

        {   //echo $s_where;exit;

			//echo $this->tbl;

          	$s_qry="SELECT * FROM cd_store WHERE i_is_active=1 ORDER BY s_store_title ASC ";

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



		

	public function get_offer()
    {
        try
        {  
          	$s_qry="SELECT * FROM ".$this->tbl_offer." WHERE i_is_active=1 ORDER BY s_offer ASC ";
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





	public function get_coupon_hot_status($coupon_id)

	{

		try

		{

			$s_query="SELECT count(*) as total FROM ".$this->tbl." WHERE i_is_hot = 1";

			$sqr="SELECT i_is_hot FROM ".$this->tbl." WHERE i_id = " .$coupon_id ;

			$rs = $this->db->query($s_query);

			$rs2 = $this->db->query($sqr);

			//echo $this->db->last_query();

			$ret = $rs->result_array();

			$ret2 = $rs2->result_array();

			$ret[0]['i_is_hot'] = $ret2[0]['i_is_hot'];

			$val = $ret[0]['total'] . '+' . $ret[0]['i_is_hot'];

			//pr($ret);exit;

			return $val;

		}

		catch(Exception $err_obj)

		{

			show_error($err_obj->getMessage());

		}	

	}
	
	
	public function get_coupon_top_status($coupon_id)
	{
		try
		{
			$s_query="SELECT count(*) as total FROM ".$this->tbl." WHERE i_is_top = 1";

			$sqr="SELECT i_is_top FROM ".$this->tbl." WHERE i_id = " .$coupon_id ;

			$rs = $this->db->query($s_query);

			$rs2 = $this->db->query($sqr);

			//echo $this->db->last_query();

			$ret = $rs->result_array();

			$ret2 = $rs2->result_array();

			$ret[0]['i_is_top'] = $ret2[0]['i_is_top'];

			$val = $ret[0]['total'] . '+' . $ret[0]['i_is_top'];

			//pr($ret);exit;
			return $val;
		}

		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
	}



	public function update_hot_coupon_status($current_coupon_id, $status = 0)
	{

		try

		{		

				if ($status==0)

				{

				$s_query = "UPDATE ".$this->tbl ." SET `i_is_hot` = 1 WHERE i_id = ".intval($current_coupon_id);

				$this->db->query($s_query);

				}

				if($status==1)

				{

				$s_query = "UPDATE ".$this->tbl ." SET `i_is_hot` = 0 WHERE i_id = ".intval($current_coupon_id);

				$this->db->query($s_query);

				}

			

			return $this->db->affected_rows();

		}

		catch(Exception $err_obj)

		{

			show_error($err_obj->getMessage());

		}

	}
	
	
	public function update_top_coupon_status($current_coupon_id, $status = 0)
	{
		try
		{	
				if ($status==0)
				{

				$s_query = "UPDATE ".$this->tbl ." SET `i_is_top` = 1 WHERE i_id = ".intval($current_coupon_id);

				$this->db->query($s_query);

				}

				if($status==1)
				{

				$s_query = "UPDATE ".$this->tbl ." SET `i_is_top` = 0 WHERE i_id = ".intval($current_coupon_id);

				$this->db->query($s_query);
				}			

			return $this->db->affected_rows();
		}

		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	}











public function get_coupon_discount_status($coupon_id)

	{

		try

		{

			$s_query="SELECT count(*) as total FROM ".$this->tbl." WHERE i_is_discount = 1";

			$sqr="SELECT i_is_discount FROM ".$this->tbl." WHERE i_id = " .$coupon_id ;

			$rs = $this->db->query($s_query);

			$rs2 = $this->db->query($sqr);

			//echo $this->db->last_query();

			$ret = $rs->result_array();

			$ret2 = $rs2->result_array();

			$ret[0]['i_is_discount'] = $ret2[0]['i_is_discount'];

			$val = $ret[0]['total'] . '+' . $ret[0]['i_is_discount'];

			//pr($ret);exit;

			return $val;

		}

		catch(Exception $err_obj)

		{

			show_error($err_obj->getMessage());

		}	

	}









public function update_discount_coupon_status($current_coupon_id, $status = 0)

	{

		try

		{		

				if ($status==0)

				{

				$s_query = "UPDATE ".$this->tbl ." SET `i_is_discount` = 1 WHERE i_id = ".intval($current_coupon_id);

				$this->db->query($s_query);

				}

				if($status==1)

				{

				$s_query = "UPDATE ".$this->tbl ." SET `i_is_discount` = 0 WHERE i_id = ".intval($current_coupon_id);

				$this->db->query($s_query);

				}

			

			return $this->db->affected_rows();

		}

		catch(Exception $err_obj)

		{

			show_error($err_obj->getMessage());

		}

	}







	public function fetch_this_with_url($url)

    {

        try

        {

          $s_qry="SELECT * 

				 FROM ".$this->tbl."

				 WHERE s_url='".my_receive($url)."'";

						 

          $query=$this->db->query($s_qry);

		$result_arr	= $query->result_array(); 

		

					/*if($query->num_rows()>0)

					{

						foreach($result_arr as $key=>$val)

						{ 

							$result_arr[$key]["images"]			= $this->fetch_product_image($val['i_id']);

							

						}    

					$query->free_result();          

					} */

         unset($s_qry, $query);

		return $result_arr;

          

        }

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }

    }   

	

	

	public function find_store($search)

    {

        try

        {

           $s_qry="SELECT * 

				 FROM ".$this->tbl."

				 WHERE s_store_title LIKE'%".my_receive($search)."%'";

						 

          $query=$this->db->query($s_qry);

		$result_arr	= $query->result_array(); 

					foreach ($query->result() as $row)

	{

		$ret= ($ret=='')?$row->i_id:$ret.','.$row->i_id;//always integer

		$i_cnt++;

	}

         unset($s_qry, $query);

		return $ret;

          

        }

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }

    }   

	

public function check_in_cpn_table($id)

    {

        try

        {

          $s_qry="SELECT COUNT(*) AS TOTAL 

				 FROM ".$this->tbl_cpn."

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



    public function __destruct()

    {}                 

  

  

}

///end of class

?>