<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Description of User_fav_deals_model
 * @author user
 */

class User_fav_deals_model extends MY_Model {

    //put your code here
    public $table_name,$joiningArray,$joinTables;

    public function __construct() {
        parent::__construct();
        $this->table_name = 'user_fav_deals';
       // $this->joiningArray[0]['table'] = 'cd_user';
       // $this->joiningArray[0]['condition'] = 'user_deals.i_user_id = cd_user.i_id';
        $this->joiningArray[1]['table'] = 'cd_coupon';
        $this->joiningArray[1]['condition'] = 'user_fav_deals.i_deal_id = cd_coupon.i_id';        

        $this->joiningArray[2]['table'] = 'cd_store';
        $this->joiningArray[2]['condition'] = 'cd_store.i_id = cd_coupon.i_store_id';
		
		$this->joinTables[1]['table'] = 'cd_deals';
        $this->joinTables[1]['condition'] = 'user_fav_deals.i_deal_id = cd_deals.i_id';        

        $this->joinTables[2]['table'] = 'cd_store';
        $this->joinTables[2]['condition'] = 'cd_store.i_id = cd_deals.i_store_id';
		

    }   
    
    public function get_favourite_product_list($s_where=null,$i_start=null,$i_limit=null) 
    {
        $ret_=array();
        $s_qry="SELECT n.i_type,n.i_user_id AS userID,n.txt_extra,n.i_deal_id,p.*,
            s.s_store_title,s.s_store_logo,s.s_store_url FROM ".$this->table_name." AS n ".
            "LEFT JOIN cd_coupon AS p ON p.i_id = n.i_deal_id ". 
            "LEFT JOIN cd_store AS s ON s.i_id = p.i_store_id ".
        ($s_where!=""?$s_where:"" )." ORDER BY n.i_id DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
              
        $rs=$this->db->query($s_qry);
        //echo $this->db->last_query();
        //echo '</br>'; 
        $ret_ = $rs->result_array();
        return $ret_;
    } 
    
    public function count_favourite_product_list($s_where=null) 
    {
        $ret_=0;
        $s_qry="SELECT COUNT(n.i_id) as i_total "
            ."FROM ".$this->table_name." n "   
            ."LEFT JOIN cd_coupon AS p ON p.i_id = n.i_deal_id " 
            ."LEFT JOIN cd_store AS s ON s.i_id = p.i_store_id "
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
    
    

    /**
     * get the count of all favorite deals data in cd_fav_deals 
     */
	 
    public function count_total_fav_deals($condition = NULL, $column = NULL, $limit = NULL, $start = 0,$orderby = NULL,$ordertype='desc', $likeCondition = NULL) {

        $this->db->start_cache();
        $this->db->select('COUNT(*) AS total');
        if ($condition)
            $this->db->where($condition);

        if ($likeCondition) {
            if (is_array($likeCondition))
                $this->db->like($likeCondition);

            if (is_string($likeCondition)) {
                $likeData = explode('|', $likeCondition);
                $this->db->like($likeData[0], $likeData[1], $likeData[2]);
            }

        }

        if ($this->joinTables)
		{
            foreach ($this->joinTables as $joinMeta) 
			{
                $this->db->join($joinMeta['table'], $joinMeta['condition'], isset($joinMeta['type']) ? $joinMeta['type'] : 'left');
            }
		}

        $this->db->stop_cache();
        $query = $this->db->get($this->table_name, $limit, $start);
        $this->db->flush_cache();
        $data = $query->result_array();
        $this->db->flush_cache();
        return $data[0]['total'];

    }
	
	 public function get_fav_deals_list($condition = NULL, $column = NULL, $limit = NULL, $start = 0,$orderby = NULL,$ordertype='desc', $likeCondition = NULL) {

        $this->db->start_cache();
        if ($column)
            $this->db->select($column);

        if ($condition)
            $this->db->where($condition);

        if ($likeCondition) {
            if (is_array($likeCondition))
                $this->db->like($likeCondition);
            if (is_string($likeCondition)) {
                $likeData = explode('|', $likeCondition);
                $this->db->like($likeData[0], $likeData[1], $likeData[2]);
            }
        }

        if ($this->joinTables)
            foreach ($this->joinTables as $joinMeta) {
                $this->db->join($joinMeta['table'], $joinMeta['condition'], isset($joinMeta['type']) ? $joinMeta['type'] : 'left');
            }
             if($orderby)
            $this->db->order_by($orderby, $ordertype); 

        $this->db->stop_cache();
        $query = $this->db->get($this->table_name, $limit, $start);
        $this->db->flush_cache();
        return $query->result_array();

    }
	
	

}
?>