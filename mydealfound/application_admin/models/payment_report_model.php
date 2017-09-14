<?php

/*********
* Author: Mrinmoy Mondal
* Date  : 13 May 2014
* Modified By: 
* Modified Date:
* Purpose:
*  Model For Admin Payment Report
* @package Report
* @subpackage Payment Report
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/Payment_report.php
* @link views/admin/Payment_report/
*/

class Payment_report_model extends MY_Model implements InfModel
{

    private $conf;
    private $tbl_cashbk_earn, $tbl_cashbk_paid, $tbl_user, $tbl_product;///used for this class

    public function __construct()
    {
        try
        {
          	parent::__construct();
			
			$this->tbl_cashbk_earn 	= 'cd_cashback_earned';
			$this->tbl_cashbk_paid 	= 'cd_cashback_paid';	
        	$this->tbl_user 		= 'cd_user';
			$this->tbl_product 		= 'cd_coupon';	
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
			$s_qry= "SELECT e.*,u.s_name AS user_name,u.s_email AS user_email, ref.s_name AS ref_name, ref.s_email AS ref_mail,
					p.s_title,p.i_store_id, p.s_product_id
					FROM ".$this->tbl_cashbk_earn." AS e "
					." LEFT JOIN ".$this->tbl_user." AS u ON u.i_id = e.user_id "					
					." LEFT JOIN ".$this->tbl_user." AS ref ON ref.i_id = e.referral_user_id "
					." LEFT JOIN ".$this->tbl_product." AS p ON p.i_id = e.product_id "
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
			$s_qry= "SELECT e.*,u.s_name AS user_name,u.s_uid,u.s_email AS user_email, ref.s_name AS ref_name, ref.s_email AS ref_mail,
					p.s_title,p.i_store_id, p.s_product_id
					FROM ".$this->tbl_cashbk_earn." AS e "
					." LEFT JOIN ".$this->tbl_user." AS u ON u.i_id = e.user_id "					
					." LEFT JOIN ".$this->tbl_user." AS ref ON ref.i_id = e.referral_user_id "
					." LEFT JOIN ".$this->tbl_product." AS p ON p.i_id = e.product_id "
					.($s_where!=""?$s_where:"" )
					." ORDER BY e.{$order_name} {$order_by} "
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
	
	
	public function fetch_multi_withdraw_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
	{	
        try
        {
          	$ret_=array();
			$s_qry= "SELECT e.*,u.s_uid,u.s_name AS user_name,u.s_email AS user_email, p.s_title, p.s_product_id
					FROM ".$this->tbl_cashbk_paid." AS e "
					." LEFT JOIN ".$this->tbl_user." AS u ON u.i_id = e.user_id "	
					." LEFT JOIN ".$this->tbl_product." AS p ON p.i_id = e.product_id "
					.($s_where!=""?$s_where:"" )
					." ORDER BY e.{$order_name} {$order_by} "
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
			/*$s_qry= "SELECT e.*,u.s_name AS user_name,u.s_email AS user_email, ref.s_name AS ref_name, ref.s_email AS ref_mail,
				p.s_title, p.s_product_id
				FROM ".$this->tbl_cashbk_earn." AS e "
				." LEFT JOIN ".$this->tbl_user." AS u ON u.i_id = e.user_id "					
				." LEFT JOIN ".$this->tbl_user." AS ref ON ref.i_id = e.referral_user_id "
				." LEFT JOIN ".$this->tbl_product." AS p ON p.i_id = e.product_id "
				.($s_where!=""?$s_where:"" );*/
			
			$s_qry= "SELECT COUNT(e.i_id) AS i_total
				FROM ".$this->tbl_cashbk_earn." AS e "
				." LEFT JOIN ".$this->tbl_user." AS u ON u.i_id = e.user_id "					
				." LEFT JOIN ".$this->tbl_user." AS ref ON ref.i_id = e.referral_user_id "
				." LEFT JOIN ".$this->tbl_product." AS p ON p.i_id = e.product_id "
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

	
    public function gettotal_withdraw_list($s_where=null)
    {
        try
        {
			$ret_=0;
			/*$s_qry= "SELECT e.*,u.s_name AS user_name,u.s_email AS user_email, p.s_title, p.s_product_id
				FROM ".$this->tbl_cashbk_paid." AS e "
				." LEFT JOIN ".$this->tbl_user." AS u ON u.i_id = e.user_id "	
				." LEFT JOIN ".$this->tbl_product." AS p ON p.i_id = e.product_id "
				.($s_where!=""?$s_where:"" );*/
			$s_qry= "SELECT COUNT(e.i_id) AS i_total FROM ".$this->tbl_cashbk_paid." AS e "
				." LEFT JOIN ".$this->tbl_user." AS u ON u.i_id = e.user_id "	
				." LEFT JOIN ".$this->tbl_product." AS p ON p.i_id = e.product_id "
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
	
	
	public function fetch_store_performance_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
	{	
        try
        {
          	$ret_=array();
			$s_qry= "SELECT e.*, COUNT(e.i_id) AS i_total, SUM(e.d_amount) AS total_amount, SUM(e.cashback_amount) AS total_cashback_amount,SUM(e.commission_amount) AS total_commission_amount
					FROM ".$this->tbl_cashbk_earn." AS e "
					.($s_where!=""?$s_where:"" )
					." GROUP BY e.s_merchant_name ORDER BY total_commission_amount DESC "
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
	
	 public function gettotal_store_performance($s_where=null)
    {
        try
        {
			$ret_=0;
			$s_qry= "SELECT COUNT(e.i_id) AS i_total
					FROM ".$this->tbl_cashbk_earn." AS e "
					.($s_where!=""?$s_where:"" )
					." GROUP BY e.s_merchant_name ORDER BY e.s_merchant_name ASC ";
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
						 FROM ".$this->tbl."
						 WHERE i_id='".my_receive($i_id)."'";						 

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
    public function add_cashback_earn($info)
    {
        try
        {
            $sql = $this->db->insert_string($this->tbl_cashbk_earn,$info);
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
				$s_qry="DELETE FROM cd_report ";
                $s_qry.=" Where i_id=? ";
                $this->db->query($s_qry, array(intval($i_id)) );
				//echo $this->db->last_query();exit;
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









 public function get_info_of_ip_coupon($ip,$coupon_id)

    {

        try

        {

          $ret_=array();

          ////Using Prepared Statement///

          	$s_query="SELECT * 

						 FROM ".$this->tbl."

						 WHERE i_ip='".my_receive($ip)."' AND i_coupon_id='".my_receive($coupon_id)."'";

						 

                $rs=$this->db->query($s_query); 

		

          		return ($rs->result_array());

          

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