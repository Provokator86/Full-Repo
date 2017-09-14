<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of location_model
 *
 * @author user
 */
class User_sub_deals_model extends MY_Model {
    //put your code here
    
    public $table_name,$joiningArray;
    public function __construct() {
        parent::__construct();
        $this->table_name = 'user_sub_deals';
       // $this->joiningArray[0]['table'] = 'cd_user';
       // $this->joiningArray[0]['condition'] = 'user_deals.i_user_id = cd_user.i_id';
    
        $this->joiningArray[1]['table'] = 'cd_coupon';
        $this->joiningArray[1]['condition'] = 'user_sub_deals.i_deal_id = cd_coupon.i_id';
        
        $this->joiningArray[2]['table'] = 'cd_store';
        $this->joiningArray[2]['condition'] = 'cd_store.i_id = cd_coupon.i_store_id';

    }
    
    
    /**
     * get the list of all data in table 
     */
   
}

?>
