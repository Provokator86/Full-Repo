<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Description of location_model*
 * @author user
 */

class User_sub_deals_model extends MY_Model {
    //put your code here
    

    public $table_name,$joiningArray,$joinTables;

    public function __construct() {

        parent::__construct();
        $this->table_name = 'user_sub_deals';
       // $this->joiningArray[0]['table'] = 'cd_user';
       // $this->joiningArray[0]['condition'] = 'user_deals.i_user_id = cd_user.i_id';    

        $this->joiningArray[1]['table'] = 'cd_coupon';
        $this->joiningArray[1]['condition'] = 'user_sub_deals.i_deal_id = cd_coupon.i_id';        

        $this->joiningArray[2]['table'] = 'cd_store';
        $this->joiningArray[2]['condition'] = 'cd_store.i_id = cd_coupon.i_store_id';
		
		$this->joinTables[1]['table'] = 'cd_deals';
        $this->joinTables[1]['condition'] = 'user_sub_deals.i_deal_id = cd_deals.i_id';        

        $this->joinTables[2]['table'] = 'cd_store';
        $this->joinTables[2]['condition'] = 'cd_store.i_id = cd_deals.i_store_id';


    }    

     /**
     * get the count of all favorite deals data in cd_fav_deals 
     */
	 
    public function count_total_subscribe_deals($condition = NULL, $column = NULL, $limit = NULL, $start = 0,$orderby = NULL,$ordertype='desc', $likeCondition = NULL) {

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
	
	 public function get_subscribe_deals_list($condition = NULL, $column = NULL, $limit = NULL, $start = 0,$orderby = NULL,$ordertype='desc', $likeCondition = NULL) {

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