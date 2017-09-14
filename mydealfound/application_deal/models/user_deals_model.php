<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Description of User_deals_model
 * @author user
 */

class User_deals_model extends MY_Model {
    //put your code here
    

    public $table_name,$joiningArray;

    public function __construct() {
	
        parent::__construct();
        $this->table_name = 'user_deals';
       // $this->joiningArray[0]['table'] = 'cd_user';
       // $this->joiningArray[0]['condition'] = 'user_deals.i_user_id = cd_user.i_id';    

        $this->joiningArray[1]['table'] = 'cd_coupon';
        $this->joiningArray[1]['condition'] = 'user_deals.i_deal_id = cd_coupon.i_id';        

        $this->joiningArray[2]['table'] = 'cd_store';
        $this->joiningArray[2]['condition'] = 'cd_store.i_id = cd_coupon.i_store_id';

    }    

    /**
     * get the list of all data in table 
     */

    public function total_cashback_earned($userId = NULL){

        if($userId)
        	$query = "SELECT i_user_id ,SUM(IF(i_is_cashback = 1, d_cashback_amount ,0)) AS `total` FROM `user_deals` WHERE  i_user_id = $userId";
        else
        	$query = "SELECT i_user_id ,SUM(IF(i_is_cashback = 1, d_cashback_amount ,0)) AS `total` FROM `user_deals` GROUP BY i_user_id";
			
        $rs = $this->db->query($query);
        return $rs->result_array();

    }

}
?>