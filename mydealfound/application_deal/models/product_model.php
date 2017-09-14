<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
 * Description of Product_model
 * deal model automatically detect deal from the database means cd_coupon.i_coupon_type =
 * 1=>deal, 2=>coupon 
 * @author user
 */

class Product_model extends MY_Model {

    //put your code here    

    public $table_name,$joiningArray;    
	public $tbl_category;
	public $tbl_store;
	public $tbl_brand;

    public function __construct() {

        parent::__construct();

        $this->table_name = 'cd_coupon';
		$this->tbl_category = 'cd_category';
		$this->tbl_store = 'cd_store';
		$this->tbl_brand = 'cd_brand';

        $this->joiningArray[0]['table'] = 'cd_store';		
		$this->joiningArray[1]['table'] = 'cd_category';
        $this->joiningArray[0]['condition'] = 'cd_store.i_id = cd_coupon.i_store_id';		
		$this->joiningArray[1]['condition'] = 'cd_category.i_id = cd_coupon.i_cat_id';
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
            if(!(array_key_exists('i_is_active', $condition)||array_key_exists('cd_coupon.i_is_active', $condition))){
                $condition['cd_coupon.i_is_active'] = 1;
            }
            // for deal
            if(!(array_key_exists('i_coupon_type', $condition)||array_key_exists('cd_coupon.i_coupon_type', $condition))){
                $condition['cd_coupon.i_coupon_type'] = 1;
            }            

           //pr( array_key_exists('i_is_active', $condition));
            //pr($condition);
        } else {
            //echo 'none array where condition for deal model, need to rebuilt the code';
			$condition	.= ' AND cd_coupon.i_is_active=1 AND cd_coupon.i_coupon_type=1';
            //die();
        }

        return $condition;

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
	
	
    public function count_total_root_category($s_where=null) 
	{
      
		$ret_=0;
		$s_qry="Select count(*) as i_total "
			."From ".$this->tbl_category." "
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
	
	public function get_category_with_product_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null) 
	{
		$ret_=array();
		$s_qry="SELECT * FROM ".$this->tbl_category." ".
		($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		
		$rs=$this->db->query($s_qry);
		/*echo $s_qry;
		echo '</br>';*/
		
		$i_cnt=0;
		if($rs->num_rows()>0)
		{
		  foreach($rs->result() as $row)
		  {
			  $ret_[$i_cnt]["i_id"]					= intval($row->i_id);////always integer
			  $ret_[$i_cnt]["s_category"]			= $row->s_category; 
			  $ret_[$i_cnt]["s_image"]				= $row->s_image; 
			  $ret_[$i_cnt]["s_thumb"]				= $row->s_thumb; 
			  $ret_[$i_cnt]["s_url"]				= $row->s_url; 
			  $ret_[$i_cnt]["i_status"]				= $row->i_status;
			  $ret_[$i_cnt]["i_total_product"]				= $row->i_total_product; 
			  
			  $this->db->cache_on();
			  $get_all_cat_ids = select_product_under_category(intval($row->i_id));
			  $dealListCondition = " WHERE p.i_cat_id IN ($get_all_cat_ids) ";
			  //$dealListCondition = array('cd_coupon.i_cat_id'=>intval($row->i_id));
			  $likeCondition = '';
			  $limit = 5;
			  $start = 0;
			  /*$ret_[$i_cnt]["products"]				= $this->get_joined_active_deal_list($dealListCondition,'cd_coupon.i_id,cd_coupon.i_cat_id,s_title,s_store_title,s_store_logo,s_store_logo,s_seo_url,i_cashback,dt_exp_date,cd_coupon.s_url,cd_coupon.s_url,s_store_url,s_image_url,cd_store.s_meta_description as store_meta,cd_coupon.s_meta_description as coupon_meta,d_list_price,d_selling_price,d_discount,s_discount_txt',$limit,$start,$likeCondition); */
			  
			  $ret_[$i_cnt]["products"]				= $this->get_product_list($dealListCondition,$start,$limit); 
			  $this->db->cache_off();
			   
			  $i_cnt++; //Incerement row
		  }    
		  $rs->free_result();          
		}
		unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$order_name,$order_by);
		return $ret_;
    }
	
	
	public function get_product_list($s_where=null,$i_start=null,$i_limit=null) 
	{
		$ret_=array();
		$s_qry="SELECT p.*,s.s_store_title,s.s_store_logo,s.s_store_url FROM ".$this->table_name." AS p ".
			"LEFT JOIN ".$this->tbl_store." AS s ON s.i_id = p.i_store_id ".
		($s_where!=""?$s_where:"" )." ORDER BY RAND() ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		
		/*$s_qry="SELECT p.*,s.s_store_title,s.s_store_logo,s.s_store_url FROM ".$this->table_name." AS p ".
			"LEFT JOIN ".$this->tbl_store." AS s ON s.i_id = p.i_store_id ".
		($s_where!=""?$s_where:"" )." ORDER BY p.dt_date_of_entry DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );*/
		
		$rs=$this->db->query($s_qry);
		//echo $this->db->last_query();
		//echo '</br>';
		
		$i_cnt=0;
		if($rs->num_rows()>0)
		{
		  foreach($rs->result() as $row)
		  {
			  $ret_[$i_cnt]["i_id"]					= intval($row->i_id);////always integer
			  $ret_[$i_cnt]["i_cat_id"]				= $row->i_cat_id; 
			  $ret_[$i_cnt]["i_brand_id"]			= $row->i_brand_id; 
			  $ret_[$i_cnt]["i_store_id"]			= $row->i_store_id;  			
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
			  
			  $ret_[$i_cnt]["s_store_title"]			= $row->s_store_title;
			  $ret_[$i_cnt]["s_store_logo"]			= $row->s_store_logo; 
			  $ret_[$i_cnt]["s_store_url"]		= $row->s_store_url;
			  
			  $ret_[$i_cnt]["i_cashback"]			= $row->i_cashback;
			   
			  $i_cnt++; //Incerement row
		  }    
		  $rs->free_result();          
		}
		unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$order_name,$order_by);
		return $ret_;
    }
	
	/* 8 May 2014 get store and product list */
	public function get_product_and_store_list($s_where=null,$i_start=null,$i_limit=null) 
	{
		$ret_=array();
		
		/*$s_qry = "select p.s_title AS title, null as store_url from ".$this->table_name." AS p
				union all
				select s.s_store_title AS title, s.s_url AS store_url from ".$this->tbl_store." AS s "
				.($s_where!=""?$s_where:"" )." ORDER BY RAND() "
				.(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );*/
		
		$s_qry = "SELECT * FROM (
		   Select s_title,null as store_url from ".$this->table_name."  as one 
		UNION 
		Select s_store_title,s_url from ".$this->tbl_store." as two 
		) as u "
		.($s_where!=""?$s_where:"" )." ORDER BY RAND() "
		.(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
    	$rs=$this->db->query($s_qry);
		
		return $rs->result_array();
	
	}
	
	public function count_product_list($s_where=null) 
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
	
	public function get_sub_category($s_where=null,$i_start=null,$i_limit=null) 
	{
		$ret_=array();
		$s_qry="SELECT * FROM ".$this->tbl_category." ".
		($s_where!=""?$s_where:"" )." ORDER BY i_total_product DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
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
	
	public function get_all_brand($s_where=null,$i_start=null,$i_limit=null) 
	{
		$ret_=array();
		$s_qry="SELECT * FROM ".$this->tbl_brand." ".
		($s_where!=""?$s_where:"" )." ORDER BY s_brand_title ASC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		$rs=$this->db->query($s_qry);
		
		$i_cnt=0;
		if($rs->num_rows()>0)
		{
		  foreach($rs->result() as $row)
		  {
			  $ret_[$i_cnt]["i_id"]					= intval($row->i_id);////always integer
			  $ret_[$i_cnt]["s_brand_title"]		= $row->s_brand_title;  
			  $ret_[$i_cnt]["s_brand_logo"]		= $row->s_brand_logo; 
			  $i_cnt++; //Incerement row
		  }    
		  $rs->free_result();          
		}
		unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$order_name,$order_by);
		return $ret_;
    }
	
	public function get_all_store($s_where=null,$i_start=null,$i_limit=null) 
	{
		$ret_=array();
		$s_qry="SELECT * FROM ".$this->tbl_store." ".
		($s_where!=""?$s_where:"" )." ORDER BY s_store_title ASC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		$rs=$this->db->query($s_qry);
		
		$i_cnt=0;
		if($rs->num_rows()>0)
		{
		  foreach($rs->result() as $row)
		  {
			  $ret_[$i_cnt]["i_id"]					= intval($row->i_id);////always integer
			  $ret_[$i_cnt]["s_store_title"]		= $row->s_store_title;   
			  $i_cnt++; //Incerement row
		  }    
		  $rs->free_result();          
		}
		unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$order_name,$order_by);
		return $ret_;
    }
	
	public function get_distinct_store_from_product($s_where=null,$i_start=null,$i_limit=null) 
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
	
	public function get_distinct_brand_from_product_BKUP($s_where=null,$i_start=null,$i_limit=null) 
	{
		$ret_= '';
		$s_qry="SELECT DISTINCT(p.i_brand_id) FROM ".$this->table_name." AS p ".
			"LEFT JOIN ".$this->tbl_store." AS s ON s.i_id = p.i_store_id ".
		($s_where!=""?$s_where:"" )." ORDER BY p.i_view_count DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		$rs=$this->db->query($s_qry);
		
		$i_cnt=0;
		if($rs->num_rows()>0)
		{
		  foreach($rs->result() as $row)
		  {
			  $ret_	= $ret_.','.$row->i_brand_id;  
			  $i_cnt++; //Incerement row
		  }    
		  $rs->free_result();          
		}
		unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$order_name,$order_by);
		return ltrim($ret_,',');
    }
	
	public function get_distinct_brand_from_product($s_where=null,$i_start=null,$i_limit=null) 
	{
		$ret_= '';
		$s_qry="SELECT DISTINCT(p.s_brand_name) FROM ".$this->table_name." AS p ".
		($s_where!=""?$s_where:"" )." ORDER BY p.s_brand_name ASC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		$rs=$this->db->query($s_qry);
		
		return $rs->result_array();
    }
	
	public function get_this_product_details($i_id=0) 
	{
		$ret_=array();
		$s_qry="SELECT p.* FROM ".$this->table_name." AS p WHERE p.i_id = '".intval($i_id)."' ";
		$rs=$this->db->query($s_qry);
		$ret_ = $rs->result_array();
		return $ret_;
    }
	
	public function increase_view_count($product_id=0) 
	{
		if(intval($product_id)>0)
		{
			$s_qry="UPDATE ".$this->table_name." SET i_view_count=(i_view_count+1) WHERE i_id = '".intval($product_id)."' ";
			$rs=$this->db->query($s_qry);
		}
		return true;
    }
	/* end below function used for deal alert
     * get the list of all data in table 
     */
	 
	 

}