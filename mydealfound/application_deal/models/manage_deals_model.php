<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor. 
 * Description of Deal_model
 * deal model automatically detect deal from the database means cd_deals.i_coupon_type =
 * 1=>deal, 2=>coupon 
 * @author user
 * New changes On 28 March 2014
 * two new table cd_deals , cd_deals_brand created for deals only which
 * data added from backend  manage_coupon.php controllers
 * so new deal list fetched from cd_deals table

 */

class Manage_deals_model extends MY_Model {

    //put your code here    

    public $table_name,$joiningArray;    
	public $deal_alert_tbl;
	public $tbl_store;
	public $tbl_category;
	public $tbl_sub_deals;
	public $tbl_fav_deals;
	public $tbl_coupon;
	public $tbl_offer_type, $tbl_bank_offer;
	

    public function __construct() {

        parent::__construct();

        $this->table_name = 'cd_deals';
		$this->tbl_coupon = 'cd_coupon';
		$this->deal_alert_tbl = 'cd_deal_alert';		
		$this->tbl_category = 'cd_category';	
		$this->tbl_store = 'cd_store';
			
		$this->tbl_sub_deals = 'user_sub_deals';
		$this->tbl_fav_deals = 'user_fav_deals';
		$this->tbl_offer_type = 'cd_offer';
		$this->tbl_bank_offer = 'cd_bank_offer';
		

        $this->joiningArray[0]['table'] = 'cd_store';
		
		$this->joiningArray[1]['table'] = 'cd_category';

        $this->joiningArray[0]['condition'] = 'cd_store.i_id = cd_deals.i_store_id';
		
		$this->joiningArray[1]['condition'] = 'cd_category.i_id = cd_deals.i_cat_id';
    }

    

    public function get_active_deal_list($condition=NULL,$column=NULL,$limit=10,$start=0,$likeCondition = NULL) {

        $condition = $this->process_condition($condition);

        $this->db->start_cache();

        if($column)

            $this->db->select($column);

        if($condition)
		{		
			 if(is_array($condition))
			 {
				$this->db->where($condition);
			  }
			  else
			  {
				$this->db->where($condition, NULL , FALSE);
			  }			
		}

        if($likeCondition){

            if(is_array($likeCondition))

                $this->db->like($likeCondition);

            if(is_string($likeCondition)){

                $likeData = explode('|', $likeCondition);

                $this->db->like($likeData[0],$likeData[1],$likeData[2]);
            }
        }
		
		$this->db->order_by($this->table_name.'.dt_date_of_entry', 'desc');

        $this->db->stop_cache();

        $query = $this->db->get($this->table_name,$limit,$start);

        $this->db->flush_cache();

        return $query->result_array();
    }

    public function get_joined_active_deal_list($condition=NULL,$column=NULL,$limit=10,$start=0,$likeCondition = NULL) 
	{
		$condition = $this->process_condition($condition);

        $this->db->start_cache();

        if($column)

            $this->db->select($column);

        if($condition)
		{		
			 if(is_array($condition))
			 {
				$this->db->where($condition);
			  }
			  else
			  {
				$this->db->where($condition, NULL , FALSE);
			  }			
		}

        if($likeCondition){

            if(is_array($likeCondition))

                $this->db->like($likeCondition);

            if(is_string($likeCondition)){

                $likeData = explode('|', $likeCondition);

                $this->db->like($likeData[0],$likeData[1],$likeData[2]);
            }	
        }
		
       if($this->joiningArray)	
            foreach ($this->joiningArray as $joinMeta){

                $this->db->join($joinMeta['table'], $joinMeta['condition'],isset($joinMeta['type'])?$joinMeta['type']:'left');
        }
		
		//if($orderby)

        $this->db->order_by($this->table_name.'.dt_date_of_entry', 'desc'); 

        $this->db->stop_cache();

        $query = $this->db->get($this->table_name,$limit,$start);
		
        $this->db->flush_cache();
		
		//echo $this->db->last_query();

        return $query->result_array();
    }
	

    public function count_active_deal_total($condition=NULL,$likeCondition = NULL) {
		
       $condition = $this->process_condition($condition);

       $this->db->start_cache();

       $this->db->select('COUNT(*) AS total');

        if($condition)

            $this->db->where($condition);

        if($likeCondition){

            if(is_array($likeCondition))

                $this->db->like($likeCondition);

            if(is_string($likeCondition)){

                $likeData = explode('|', $likeCondition);

                $this->db->like($likeData[0],$likeData[1],$likeData[2]);
            }
        }

        $this->db->stop_cache();

        $query = $this->db->get($this->table_name);

        $data = $query->result_array();

        $this->db->flush_cache();

        return $data[0]['total'];
    }

    

    public function count_joined_active_deal_total($condition=NULL,$likeCondition = NULL) {

       $condition = $this->process_condition($condition);

       $this->db->start_cache();

       $this->db->select('COUNT(*) AS total');

        if($condition)
		{		
			 if(is_array($condition))
			 {
				$this->db->where($condition);
			  }
			  else
			  {
				$this->db->where($condition, NULL , FALSE);
			  }			
		}

        if($likeCondition){

            if(is_array($likeCondition))

                $this->db->like($likeCondition);

            if(is_string($likeCondition)){

                $likeData = explode('|', $likeCondition);

                $this->db->like($likeData[0],$likeData[1],$likeData[2]);

            }

        }
		
        if($this->joiningArray)

            foreach ($this->joiningArray as $joinMeta) {

                $this->db->join($joinMeta['table'], $joinMeta['condition'],isset($joinMeta['type'])?$joinMeta['type']:'left');

        }

        $this->db->stop_cache();

        $query = $this->db->get($this->table_name);

        $data = $query->result_array();

         $this->db->flush_cache();

        return $data[0]['total'];

    }



    private function process_condition($condition = null){
		
        if(is_array($condition)){

            //for active

            if(!(array_key_exists('i_is_active', $condition)||array_key_exists('cd_deals.i_is_active', $condition))){

                $condition['cd_deals.i_is_active'] = 1;

            }

            // for deal

            if(!(array_key_exists('i_coupon_type', $condition)||array_key_exists('cd_deals.i_coupon_type', $condition))){

                $condition['cd_deals.i_coupon_type'] = 2;

            }             

           //pr( array_key_exists('i_is_active', $condition));

            //pr($condition);

        } else {

            //echo 'none array where condition for deal model, need to rebuilt the code';
			$condition	.= ' AND cd_deals.i_is_active=1 AND cd_deals.i_coupon_type=2';

            //die();

        }

        return $condition;

    }

    
	/* below function used for deal alert by MM , Mar 2014*/
	public function count_total_deal_alert($condition = NULL) {

        $this->db->start_cache();
        $this->db->select('COUNT(*) AS total');

        if ($condition)
            $this->db->where($condition);

        $this->db->stop_cache();
        $query = $this->db->get($this->deal_alert_tbl);
        $data = $query->result_array();
        $this->db->flush_cache();
        return $data[0]['total'];

    }
	
	public function insert_deal_alert($dataToInsert=array()) {

		$ret = 0;
        if ($dataToInsert) {
            $this->db->insert($this->deal_alert_tbl, $dataToInsert);
			$ret = $this->db->insert_id();
        } 
        return $ret;

    }
	
	public function fetch_deal_alert($condition= '') {
	
		$sql = " SELECT * FROM ".$this->deal_alert_tbl." ".($condition!=""?$condition:"");
		$res = $this->db->query($sql);
        /*$this->db->select('*');
		$this->db->from($this->deal_alert_tbl);	
		if ($condition)
            $this->db->where($condition);	
		$query = $this->db->get();*/
		//echo $this->db->last_query();
		return $res->result_array();

    }
	
	function getCategoryPath($parent_id='',$cat_name='')
	{
		$ret_ = false;
		if(!$parent_id)
			$ret_ = $cat_name;
		else
		{
			$pc_name = $this->getCategoryName($parent_id);
			$ret_ = $pc_name.' > '.$cat_name;
		}
		return $ret_;
	}
	
	function getCategoryName($cat_id='')
	{
		$ret_=0;
		if($cat_id!='')        
		{
			$sql = "SELECT s_category FROM cd_category WHERE i_id ='".$cat_id."' ";
			$rs=$this->db->query($sql); 
			$res = $rs->result_array();
			$ret_ = $res[0]["s_category"];			
		}
		return $ret_;
	}
	
	
	public function get_deals_offers_list($s_where=null,$i_start=null,$i_limit=null,$order_by = false) 
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
		$s_qry="SELECT p.*,s.s_store_title,s.s_store_logo,s.s_store_url FROM ".$this->table_name." AS p ".
			"LEFT JOIN ".$this->tbl_store." AS s ON s.i_id = p.i_store_id ".
		($s_where!=""?$s_where:"" ).($s_order!=""?$s_order:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		$rs=$this->db->query($s_qry);
		/*echo $this->db->last_query();
		echo '</br>';*/
		
		$i_cnt=0;
		if($rs->num_rows()>0)
		{
		  foreach($rs->result() as $row)
		  {
			  $ret_[$i_cnt]["i_id"]					= intval($row->i_id);////always integer
			  $ret_[$i_cnt]["i_cat_id"]				= $row->i_cat_id; 
			  $ret_[$i_cnt]["i_brand_id"]			= $row->i_brand_id; 
			  $ret_[$i_cnt]["i_store_id"]			= $row->i_store_id; 
			  $ret_[$i_cnt]["i_coupon_code"]		= $row->i_coupon_code;  			
			  $ret_[$i_cnt]["s_product_id"]			= $row->s_product_id; 
			  $ret_[$i_cnt]["s_sku"]				= $row->s_sku; 
			  $ret_[$i_cnt]["s_url"]				= $row->s_url;
			  $ret_[$i_cnt]["s_merchant"]			= $row->s_merchant;
			  $ret_[$i_cnt]["s_title"]				= $row->s_title; 
			  $ret_[$i_cnt]["s_summary"]			= $row->s_summary;
			  $ret_[$i_cnt]["s_image_url"]			= $row->s_image_url;
			  
			  $ret_[$i_cnt]["d_list_price"]			= $row->d_list_price;
			  $ret_[$i_cnt]["d_discount"]			= $row->d_discount; 
			  $ret_[$i_cnt]["d_selling_price"]		= $row->d_selling_price;  
			  $ret_[$i_cnt]["s_discount_txt"]		= $row->s_discount_txt;
			  
			  $ret_[$i_cnt]["s_store_title"]		= $row->s_store_title;
			  $ret_[$i_cnt]["s_store_logo"]			= $row->s_store_logo; 
			  $ret_[$i_cnt]["s_store_url"]			= $row->s_store_url;
			  
			  $ret_[$i_cnt]["dt_exp_date"]			= $row->dt_exp_date;
			  $ret_[$i_cnt]["s_seo_url"]			= $row->s_seo_url;
			  
			  $ret_[$i_cnt]["d_shipping"]			= $row->d_shipping;
			  $ret_[$i_cnt]["s_terms"]				= $row->s_terms;
			  $ret_[$i_cnt]["i_cashback"]			= $row->i_cashback;
			   
			  $i_cnt++; //Incerement row
		  }    
		  $rs->free_result();          
		}
		unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$order_name,$order_by);
		return $ret_;
    }
	
	
	public function count_deals_offers_list($s_where=null) 
	{
		$ret_=0;
		$s_qry="SELECT COUNT(p.i_id) as i_total "
			."FROM ".$this->table_name." p "
			."LEFT JOIN ".$this->tbl_store." AS s ON s.i_id = p.i_store_id "
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
	
	
	/* product or list*/
	public function get_product_deal_list($s_where=null,$i_start=null,$i_limit=null) 
	{
		$ret_=array();
		$s_qry="SELECT p.*,s.s_store_title,s.s_store_logo,s.s_store_url FROM ".$this->tbl_coupon." AS p ".
			"LEFT JOIN ".$this->tbl_store." AS s ON s.i_id = p.i_store_id ".
		($s_where!=""?$s_where:"" )." ORDER BY p.i_view_count DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		$rs=$this->db->query($s_qry);
		/*echo $this->db->last_query();
		echo '</br>';*/
		
		$i_cnt=0;
		if($rs->num_rows()>0)
		{
		  foreach($rs->result() as $row)
		  {
			  $ret_[$i_cnt]["i_id"]					= intval($row->i_id);////always integer
			  $ret_[$i_cnt]["i_cat_id"]				= $row->i_cat_id; 
			  $ret_[$i_cnt]["i_brand_id"]			= $row->i_brand_id; 
			  $ret_[$i_cnt]["i_store_id"]			= $row->i_store_id; 
			  $ret_[$i_cnt]["i_coupon_code"]		= $row->i_coupon_code;  			
			  $ret_[$i_cnt]["s_product_id"]			= $row->s_product_id; 
			  $ret_[$i_cnt]["s_sku"]				= $row->s_sku; 
			  $ret_[$i_cnt]["s_url"]				= $row->s_url;
			  $ret_[$i_cnt]["s_merchant"]			= $row->s_merchant;
			  $ret_[$i_cnt]["s_title"]				= $row->s_title; 
			  $ret_[$i_cnt]["s_summary"]			= $row->s_summary;
			  $ret_[$i_cnt]["s_image_url"]			= $row->s_image_url;
			  
			  $ret_[$i_cnt]["d_list_price"]			= $row->d_list_price;
			  $ret_[$i_cnt]["d_discount"]			= $row->d_discount; 
			  $ret_[$i_cnt]["d_selling_price"]		= $row->d_selling_price;  
			  $ret_[$i_cnt]["s_discount_txt"]		= $row->s_discount_txt;
			  
			  $ret_[$i_cnt]["s_store_title"]			= $row->s_store_title;
			  $ret_[$i_cnt]["s_store_logo"]			= $row->s_store_logo; 
			  $ret_[$i_cnt]["s_store_url"]		= $row->s_store_url;
			  
			  $ret_[$i_cnt]["dt_exp_date"]		= $row->dt_exp_date;
			  $ret_[$i_cnt]["s_seo_url"]		= $row->s_seo_url;
			  $ret_[$i_cnt]["i_cashback"]			= $row->i_cashback; 
			  $i_cnt++; //Incerement row
		  }    
		  $rs->free_result();          
		}
		unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$order_name,$order_by);
		return $ret_;
    }
	
	
	public function count_product_deal_list($s_where=null) 
	{
		$ret_=0;
		$s_qry="SELECT COUNT(p.i_id) as i_total "
			."FROM ".$this->tbl_coupon." p "
			."LEFT JOIN ".$this->tbl_store." AS s ON s.i_id = p.i_store_id "
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
	
	/* product or list*/
	
	public function get_bank_offer($s_where=null,$i_start=null,$i_limit=null) 
	{
		$ret_=array();
		$s_qry="SELECT * FROM ".$this->tbl_bank_offer." ".
		($s_where!=""?$s_where:"" )." ORDER BY s_bank ASC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		$rs=$this->db->query($s_qry);
		
		$i_cnt=0;
		if($rs->num_rows()>0)
		{
		  foreach($rs->result() as $row)
		  {
			  $ret_[$i_cnt]["i_id"]					= intval($row->i_id);////always integer
			  $ret_[$i_cnt]["s_bank"]				= $row->s_bank; 
			  $ret_[$i_cnt]["i_status"]				= $row->i_status;			   
			  $i_cnt++; //Incerement row
		  }    
		  $rs->free_result();          
		}
		unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$order_name,$order_by);
		return $ret_;
    }
	
	public function get_offer_type($s_where=null,$i_start=null,$i_limit=null) 
	{
		$ret_=array();
		$s_qry="SELECT * FROM ".$this->tbl_offer_type." ".
		($s_where!=""?$s_where:"" )." ORDER BY s_offer ASC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		$rs=$this->db->query($s_qry);
		
		$i_cnt=0;
		if($rs->num_rows()>0)
		{
		  foreach($rs->result() as $row)
		  {
			  $ret_[$i_cnt]["i_id"]					= intval($row->i_id);////always integer
			  $ret_[$i_cnt]["s_offer"]				= $row->s_offer; 
			  $ret_[$i_cnt]["s_url"]				= $row->s_url;			   
			  $i_cnt++; //Incerement row
		  }    
		  $rs->free_result();          
		}
		unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$order_name,$order_by);
		return $ret_;
    }
	
	public function get_category($s_where=null,$i_start=null,$i_limit=null) 
	{
		$ret_=array();
		$s_qry="SELECT * FROM ".$this->tbl_category." ".
		($s_where!=""?$s_where:"" )." ORDER BY s_category ASC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		$rs=$this->db->query($s_qry);
		
		$i_cnt=0;
		if($rs->num_rows()>0)
		{
		  foreach($rs->result() as $row)
		  {
			  $ret_[$i_cnt]["i_id"]					= intval($row->i_id);////always integer
			  $ret_[$i_cnt]["s_category"]			= $row->s_category; 
			  $ret_[$i_cnt]["s_url"]				= $row->s_url;			   
			  $i_cnt++; //Incerement row
		  }    
		  $rs->free_result();          
		}
		unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$order_name,$order_by);
		return $ret_;
    }
	
	public function get_distinct_store_from_offer($s_where=null,$i_start=null,$i_limit=null) 
	{
		$ret_= '';
		$s_qry="SELECT DISTINCT(p.i_store_id) FROM ".$this->table_name." AS p ".
			"LEFT JOIN ".$this->tbl_store." AS s ON s.i_id = p.i_store_id ".
		($s_where!=""?$s_where:"" )." ORDER BY p.i_view_count DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		$rs=$this->db->query($s_qry);
		
		$i_cnt=0;
		if($rs->num_rows()>0)
		{
		  foreach($rs->result() as $row)
		  {
			  $ret_	= $ret_.','.$row->i_store_id;  
			  $i_cnt++; //Incerement row
		  }    
		  $rs->free_result();          
		}
		unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$order_name,$order_by);
		return ltrim($ret_,',');
    }
	
	
	public function get_user_subscribe_deals($s_where=null,$i_start=null,$i_limit=null) 
	{
		$ret_=array();
		$s_qry="SELECT * FROM ".$this->tbl_sub_deals." ".
		($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		$rs=$this->db->query($s_qry);
		/*echo $this->db->last_query();
		echo '</br>';*/
		$ret_ = $rs->result_array();
		return $ret_;
    }
	
	public function insert_subscribe_deals($dataToInsert, $isMulti = FALSE) {
        if ($isMulti) {
            $this->db->insert_batch($this->tbl_sub_deals, $dataToInsert);
        } else {
            $this->db->insert($this->tbl_sub_deals, $dataToInsert);
        }
        return $this->db->insert_id();
    }
	
	public function get_user_fav_deals($s_where=null,$i_start=null,$i_limit=null) 
	{
		$ret_=array();
		$s_qry="SELECT * FROM ".$this->tbl_fav_deals." ".
		($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		$rs=$this->db->query($s_qry);
		/*echo $this->db->last_query();
		echo '</br>';*/
		$ret_ = $rs->result_array();
		return $ret_;
    }
	
	public function insert_fav_deals($dataToInsert, $isMulti = FALSE) {
        if ($isMulti) {
            $this->db->insert_batch($this->tbl_fav_deals, $dataToInsert);
        } else {
            $this->db->insert($this->tbl_fav_deals, $dataToInsert);
        }
        return $this->db->insert_id();
    }
	
	public function get_this_deal_details($i_id=0) 
	{
		$ret_=array();
		$s_qry="SELECT p.*,s.s_store_title,s.s_store_logo,s.s_store_url FROM ".$this->table_name." AS p ".		
			"LEFT JOIN ".$this->tbl_store." AS s ON s.i_id = p.i_store_id ".
			" WHERE p.i_id = '".intval($i_id)."' ";
		$rs=$this->db->query($s_qry);
		$ret_ = $rs->result_array();
		return $ret_;
    }
	
	public function increase_deal_view_count($i_id=0) 
	{
		if(intval($i_id)>0)
		{
			$s_qry="UPDATE ".$this->table_name." SET i_view_count=(i_view_count+1) WHERE i_id = '".intval($i_id)."' ";
			$rs=$this->db->query($s_qry);
		}
		return true;
    }
	
	/* end below function used for deal alert*/

    /**

     * get the list of all data in table 

     */
	 
	

}

