<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of location_model *
 * @author user
 */

class Store_model extends MY_Model {

    //put your code here    

    public $table_name;
	public $table_coupon;
	public $table_deals;
	public $tbl_store_ads;

    public function __construct() 
	{
        parent::__construct();

        $this->table_name = 'cd_store';
		$this->table_coupon = 'cd_coupon';
		$this->table_deals = 'cd_deals';
		$this->tbl_store_ads = 'cd_store_ads';
    }

    public function get_store_deal_count($s_where=null)
	{
		 try
        {
          $ret_=0;
         $s_qry="SELECT count(cdc.i_id) as i_total 
					FROM ".$this->table_coupon." AS cdc 
					"
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
	
	public function get_store_offers_count($s_where=null)
	{
		try
        {
          $ret_=0;
          $s_qry="SELECT count(i_id) as i_total 
					FROM ".$this->table_deals." ".($s_where!=""?$s_where:"" );
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
	
	public function fetch_multi_sorted_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
	{		
        try
        {
          	$ret_=array();
			 $s_qry="SELECT * FROM ".$this->table_name. " "
			.($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
	
          $query		= $this->db->query($s_qry);// echo $this->db->last_query();exit;          
		  $result_arr	= $query->result_array();	
		  
		  foreach($result_arr as $key=>$val)
		  {
		  	$result_arr[$key]['deal_count']	= $this->get_store_deal_count(" WHERE (CONCAT(DATE(dt_exp_date),' 23:59:59')> now() OR dt_exp_date = 0) AND i_coupon_type = 1 AND i_is_active=1 AND i_store_id={$val['i_id']} ");
			
			$result_arr[$key]['offers_count']	= $this->get_store_offers_count(" WHERE (CONCAT(DATE(dt_exp_date),' 23:59:59')> now() OR dt_exp_date = 0) AND i_is_active=1 AND i_store_id={$val['i_id']} ");
		  }		  
		  return $result_arr;          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    
	}    

    /**

     * get the list of all data in table 

     */
	 
	public function fetch_store_ads_recent($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
			$s_qry= "SELECT n.*,s.s_store_title 
					FROM ".$this->tbl_store_ads." AS n "
					." LEFT JOIN ".$this->table_name." AS s ON s.i_id = n.i_store_id "		
					.($s_where!=""?$s_where:"" )
					." ORDER BY n.i_id DESC "					
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
	 
}


