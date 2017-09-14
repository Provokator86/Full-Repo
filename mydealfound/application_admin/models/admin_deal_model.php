<?php

/*********

* Author: Mrinmoy Mondal

* Date  : 28 Mar 2013

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



class Admin_deal_model extends MY_Model implements InfModel

{

    private $conf;

    private $tbl;///used for this class
	private $tbl_coupon_brand;
	private $tbl_brand;
	private $tbl_store;
	private $tbl_offer;
	

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->DEALS; 
		  $this->tbl_coupon_brand = $this->db->DEALSBRAND; 
		  $this->tbl_brand = $this->db->BRAND; 
		  $this->tbl_store = $this->db->STORE;
		  $this->tbl_offer = $this->db->OFFER;
		  $this->tbl_report = $this->db->REPORT;
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

	

	

	public function fetch_multi_top_latest_coupons($s_where=null,$i_start=null,$i_limit=null)

    {

        try

        {   

			/*$s_qry="SELECT cdc.*,cdc.s_url as coupon_url,cdc.i_id AS coupon_id,  cds.*,  cds.i_id AS store_id 

					FROM ".$this->tbl." AS cdc 

					JOIN ".$this->tbl_store." AS cds ON cdc.i_store_id = cds.i_id "

					.($s_where!=""?$s_where:"" )

					.(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );*/

			 $s_qry=" SELECT  cds.*,cdc.s_url as coupon_url, cds.i_id AS store_id , cdc.* ,cds.s_url as s_url

					FROM (SELECT *  FROM ". $this->tbl.") cdc 

					JOIN ".$this->tbl_store." AS cds ON cdc.i_store_id = cds.i_id "

					.($s_where!=""?$s_where:"" )

					.(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );

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

	

	

    

	

	public function fetch_multi_sorted_product_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)

	{

		

        try

        {

          	$ret_=array();

			$s_qry="SELECT * FROM cd_product".

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

    

	

	

	//---------------------------------------------------------

	

	 public function gettotal_info_coupon($s_where=null)

    {

        try

        {

          $ret_=0;

         $s_qry="SELECT count(cdc.i_id) as i_total 

					FROM ".$this->tbl." AS cdc 

					JOIN ".$this->tbl_store." AS cds ON cdc.i_store_id = cds.i_id "

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

	

    /* Fetch Total records

    * @param string $s_where, ex- " status=1 AND deleted=0 " 

    * @returns int on success and FALSE if failed 

    */

    public function gettotal_product_info($s_where=null)

    {

        try

        {

          $ret_=0;

          $s_qry="Select count(*) as i_total "

                ."From cd_product "

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

			//echo "111";exit;

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

	

	 public function fetch_coupon_brand($i_id)

    {

        try

        {

          	$ret_=array();

         

			$s_query="SELECT cp.i_brand_id,b.s_brand_title 

					 FROM ".$this->tbl_coupon_brand." AS cp "

					 ."LEFT JOIN ".$this->tbl_brand." AS b ON b.i_id = cp.i_brand_id "

					 ." WHERE cp.i_coupon_id = '".$i_id."' ";

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

					$sql="UPDATE ".$this->tbl." Set i_is_hot=0 WHERE i_id=".$i_id;

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

	

 public function fetch_industry($s_where=null,$i_start=null,$i_limit=null)

    {

        try

        {   //echo $s_where;exit;

			//echo $this->tbl;

          	$s_qry="SELECT pi.i_id, pi.s_title, COUNT( psp.i_id ) AS total

FROM pl_industry AS pi

LEFT JOIN pl_startup_personal AS psp ON pi.i_id

IN (

psp.s_industry1, psp.s_industry2, psp.s_industry3

)

GROUP BY pi.i_id " 

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





public function get_cat_id($cat_name)

{

  //echo "111";

   	$s_qry="SELECT i_id FROM cd_category WHERE s_category LIKE '".$cat_name."%'";

	$query		= $this->db->query($s_qry);          

	$result_arr	= $query->result_array();				

			  

	return $result_arr;          

  //exit;

 }

 

 

 public function get_store_id($store_name)

{

  //echo "111";

   	$s_qry="SELECT i_id FROM cd_store WHERE s_store_title LIKE '".$store_name."%'";

	$query		= $this->db->query($s_qry);          

	$result_arr	= $query->result_array();				

			  

	return $result_arr;          

  //exit;

 }



public function get_coupon_id($brand_id)//used from report model

{

  //echo "111";

   	$s_qry="SELECT * FROM ".$this->tbl_coupon_brand." WHERE i_brand_id =".$brand_id;

	$query		= $this->db->query($s_qry);          

	$result_arr	= $query->result_array();				

			  

	return $result_arr;          

  //exit;

 }



	public function get_coupon_hot_status($coupon_id)
	{
		try
		{

			$s_query="SELECT count(*) as total FROM ".$this->tbl." WHERE i_is_hot = 1";
			$sqr="SElect i_is_hot FROM ".$this->tbl." WHERE i_id = " .$coupon_id ;
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
	
	public function get_coupon_popular_status($coupon_id)
	{
		try
		{

			$s_query="SELECT count(*) as total FROM ".$this->tbl." WHERE i_is_popular = 1";
			$sqr="SElect i_is_popular FROM ".$this->tbl." WHERE i_id = " .$coupon_id ;
			$rs = $this->db->query($s_query);
			$rs2 = $this->db->query($sqr);
			//echo $this->db->last_query();
			$ret = $rs->result_array();
			$ret2 = $rs2->result_array();
			$ret[0]['i_is_popular'] = $ret2[0]['i_is_popular'];
			$val = $ret[0]['total'] . '+' . $ret[0]['i_is_popular'];
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

	public function update_popular_coupon_status($current_coupon_id, $status = 0)
	{
		try
		{		
				if ($status==0)
				{
					$s_query = "UPDATE ".$this->tbl ." SET `i_is_popular` = 1 WHERE i_id = ".intval($current_coupon_id);
					$this->db->query($s_query);
				}
				if($status==1)
				{
					$s_query = "UPDATE ".$this->tbl ." SET `i_is_popular` = 0 WHERE i_id = ".intval($current_coupon_id);
					$this->db->query($s_query);
				}

			return $this->db->affected_rows();

		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	}

	

	public function get_offer_name($id)

	{

		try

		{		

			$s_query	= " SELECT s_offer FROM ".$this->tbl_offer." WHERE i_id	= '".my_receive($id)."'";

			$query		= $this->db->query($s_query);          

			return ($query->result_array());	

		}

		

		catch(Exception $err_obj)

		{

			show_error($err_obj->getMessage());

		}

	}

	

	

	public function count_no_of_coupon_under_this_store($id)

	{

		try

		{		

			 $s_query	= " SELECT COUNT(*) AS total_coupons FROM ".$this->tbl." WHERE i_store_id	= '".my_receive($id)."'" ." AND CONCAT(DATE(dt_exp_date),' 23:59:59') > now() AND i_is_active=1";

			$query		= $this->db->query($s_query);          

			return ($query->result_array());	

		}

		

		catch(Exception $err_obj)

		{

			show_error($err_obj->getMessage());

		}

	}

	

	public function fetch_coupon_under_this_brand($id,$start=0,$limit=0)

	{

		try

		{		

			/*$s_query	= " SELECT * FROM ".$this->tbl." WHERE i_id IN(SELECT i_coupon_id FROM ".$this->tbl_coupon_brand." WHERE i_brand_id='".my_receive($id)."')";*/

			$s_query	= " SELECT n.*,n.s_url as cpn_url ,s.s_store_title,s.s_store_logo,s.s_url FROM ".$this->tbl." AS n

							LEFT JOIN ".$this->tbl_store." AS s ON s.i_id = n.i_store_id

							WHERE n.i_id IN(SELECT i_coupon_id FROM ".$this->tbl_coupon_brand." WHERE i_brand_id='".my_receive($id)."') AND n.dt_of_live_coupons<=now() AND CONCAT(DATE(n.dt_exp_date),' 23:59:59')> now() AND n.i_is_active=1".(is_numeric($start) && is_numeric($limit)?" Limit ".intval($start).",".intval($limit):"" );

			$query		= $this->db->query($s_query);          

			return ($query->result_array());	

		}

		

		catch(Exception $err_obj)

		{

			show_error($err_obj->getMessage());

		}

	}











public function count_coupon_under_this_brand($id)

	{

		try

		{		

			/*$s_query	= " SELECT * FROM ".$this->tbl." WHERE i_id IN(SELECT i_coupon_id FROM ".$this->tbl_coupon_brand." WHERE i_brand_id='".my_receive($id)."')";*/

			$s_query	= " SELECT COUNT(n.i_id) as total FROM ".$this->tbl." AS n

							LEFT JOIN ".$this->tbl_store." AS s ON s.i_id = n.i_store_id

							WHERE n.i_id IN(SELECT i_coupon_id FROM ".$this->tbl_coupon_brand." WHERE i_brand_id='".my_receive($id)."') AND n.dt_of_live_coupons<=now() AND CONCAT(DATE(n.dt_exp_date),' 23:59:59') > now() AND n.i_is_active=1";

			$rs		= $this->db->query($s_query);          

			$i_cnt=0;

          if($rs->num_rows()>0)

          {

              foreach($rs->result() as $row)

              {

                  $ret_=intval($row->total); 

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

	

	

public function fetch_coupon_under_this_category($id)

	{

		try

		{		

			$s_query	= " SELECT cp.i_id,st.s_url AS store_url,st.*,cp.* FROM ".$this->tbl." as cp LEFT JOIN cd_store as st ON cp.i_store_id=st.i_id WHERE cp.i_cat_id= '".my_receive($id)."' AND CONCAT(DATE(cp.dt_exp_date),' 23:59:59') > now() AND cp.dt_of_live_coupons<=now() AND cp.i_is_active=1";

			$query		= $this->db->query($s_query);          

			return ($query->result_array());	

		}

		

		catch(Exception $err_obj)

		{

			show_error($err_obj->getMessage());

		}

	}

	

public function fetch_coupon_under_this_offer($id)

	{

		try

		{		

			$s_query	= " SELECT cp.i_id,st.s_url AS store_url,st.*,cp.* FROM ".$this->tbl." as cp LEFT JOIN cd_store as st ON cp.i_store_id=st.i_id WHERE cp.i_type= '".my_receive($id)."' AND CONCAT(DATE(cp.dt_exp_date),' 23:59:59')>=NOW() AND cp.dt_of_live_coupons<=now() AND cp.i_is_active=1";

			$query		= $this->db->query($s_query);          

			return ($query->result_array());	

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
			 WHERE s_seo_url='".my_receive($url)."'"; 
					 
			
			$query=$this->db->query($s_qry);
			$result_arr	= $query->result_array(); 
			unset($s_qry, $query);
			return $result_arr;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    }

	

public function find_coupon_from_store_id($store_id)

    {

        try

        {

          $s_qry="SELECT   c.i_id as id,c.* ,c.s_url as cpn_url,s.*

				 FROM ".$this->tbl."  AS c

				 LEFT JOIN ".$this->tbl_store." AS s

				 ON c.i_store_id=s.i_id

				 WHERE c.i_store_id IN (".my_receive($store_id).") 

				 AND CONCAT(DATE(c.dt_exp_date),' 23:59:59') > now() AND c.dt_of_live_coupons<=now() 

				 AND c.i_is_active=1";

						 

          $query=$this->db->query($s_qry);

		$result_arr	= $query->result_array(); 

         unset($s_qry, $query);

		return $result_arr;

          

        }

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }

    }





public function get_coupon_for_brand($brand_name)

    {

        try

        {

          $s_qry="SELECT c.i_id as id, c.*,c.s_url as cpn_url,s.*

		  				FROM ".$this->tbl." AS c 

						LEFT JOIN ".$this->tbl_store." AS s ON s.i_id=c.i_store_id

						LEFT JOIN ".$this->tbl_coupon_brand." AS brn ON c.i_id=brn.i_coupon_id

						LEFT JOIN ".$this->tbl_brand." AS b ON brn.i_brand_id=b.i_id

						WHERE b.s_brand_title LIKE '" .$brand_name. "%' AND CONCAT(DATE(c.dt_exp_date),' 23:59:59') > now() AND c.dt_of_live_coupons<=now() AND c.i_is_active=1 ";

						 

          $query=$this->db->query($s_qry);

		$result_arr	= $query->result_array(); 

         unset($s_qry, $query);

		return $result_arr;

          

        }

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }

    }







	

public function find_coupon_for_search($search)

    {

        try

        {

           $s_qry="SELECT c.i_id as id, c.*,c.s_url as cpn_url,s.* 

				 FROM ".$this->tbl." AS c

				 LEFT JOIN ".$this->tbl_store." AS s

				 ON c.i_store_id=s.i_id

				 WHERE (c.s_title LIKE '%".my_receive($search)."%' OR c.s_summary LIKE '%".my_receive($search)."%') AND CONCAT(DATE(c.dt_exp_date),' 23:59:59') > now() AND c.dt_of_live_coupons<=now() AND c.i_is_active=1";

						 

          $query=$this->db->query($s_qry);

		$result_arr	= $query->result_array(); 

         unset($s_qry, $query);

		return $result_arr;

          

        }

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }

    }

	 

public function fetch_auto_complete($where)

    {

        try

        {

          /*$s_qry="SELECT c.i_id, c.*,s.* 

				 FROM ".$this->tbl." AS c

				 LEFT JOIN ".$this->tbl_store." AS s

				 ON c.i_store_id=s.i_id".(($where!='')?$where:"");*/

		$s_qry="SELECT  c.s_title  

as cpn_title FROM ".$this->tbl." AS c WHERE (c.s_title LIKE '".$where."%' OR c.s_summary LIKE '%".$where."%') AND CONCAT(DATE(c.dt_exp_date),' 23:59:59') > now() AND c.dt_of_live_coupons<=now() UNION SELECT s.s_store_title as store_title FROM ".$this->tbl_store." AS s WHERE s.s_store_title LIKE '".$where."%'";					 

        $query=$this->db->query($s_qry);

		$result_arr	= $query->result_array(); 

         unset($s_qry, $query);

		return $result_arr;

          

        }

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }

    }



public function fetch_fav_coupon($cat_id,$store_id)

    {

        try

        {

          $s_qry="SELECT s.s_url as store_url,s.*,n.*,n.i_id 

		  				FROM ".$this->tbl." AS n 

						LEFT JOIN ".$this->tbl_store." AS s ON n.i_store_id=s.i_id

						WHERE n.i_store_id IN (" .$store_id. ") AND n.i_cat_id=".$cat_id. " AND CONCAT(DATE(n.dt_exp_date),' 23:59:59') > now() AND n.dt_of_live_coupons<=now() AND n.i_is_active=1";

						 

          $query=$this->db->query($s_qry);

		$result_arr	= $query->result_array(); 

         unset($s_qry, $query);

		return $result_arr;

          

        }

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }

    }



public function del_cpn_brand($coupon_id)

    {

        try

        {

          $s_qry="DELETE FROM ".$this->tbl_coupon_brand ." WHERE i_coupon_id=".$coupon_id;

						 

          $query=$this->db->query($s_qry);

		  $s_qry1="DELETE FROM ".$this->tbl_report. " WHERE i_coupon_id=".$coupon_id;

		  $query1=$this->db->query($s_qry1);

		//$result_arr	= $query->result_array(); 

         unset($s_qry, $query);

		return $result_arr;

          

        }

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }

    }





public function remove_top_status()

    {

        try

        {

          $s_qry="UPDATE ".$this->tbl." SET i_is_hot=0 WHERE CONCAT(DATE(dt_exp_date),' 23:59:59') < now()" ;

						 

          $query=$this->db->query($s_qry);

		//$result_arr	= $query->result_array(); 

         unset($s_qry, $query);

		//return $result_arr;

          

        }

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }

    }



public function fetch_max_hit()

    {

        try

        {

          $s_qry="SELECT cp.s_title, r.i_coupon_id, SUM( r.i_no_of_hit ) AS TOT

				FROM ".$this->tbl." AS cp

				LEFT JOIN ".$this->tbl_report." AS r ON r.i_coupon_id = cp.i_id

				GROUP BY r.i_coupon_id

				ORDER BY TOT DESC

				" ;

						 

          $query=$this->db->query($s_qry);

		$result_arr	= $query->result_array(); 

         unset($s_qry, $query);

		return $result_arr;

          

        }

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }

    }







public function get_store_id_name($cat_id)

    {

        try

        {

          $s_qry="SELECT cp.*,s.i_id AS id,s.s_store_title as title

				FROM ".$this->tbl." AS cp

				LEFT JOIN ".$this->tbl_store." AS s ON s.i_id = cp.i_store_id

				WHERE cp.i_cat_id=".$cat_id." AND CONCAT(DATE(cp.dt_exp_date),' 23:59:59') > now()"

				

				 ;

						 

          $query=$this->db->query($s_qry);

		  foreach ($query->result() as $row)

			{

				$ret_[$row->id] = $row->title;//always integer

				$i_cnt++;

			}

	

	return $ret_;

		/*$result_arr	= $query->result_array(); 

         unset($s_qry, $query);

		return $result_arr;*/

          

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