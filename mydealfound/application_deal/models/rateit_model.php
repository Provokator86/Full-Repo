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
class Rateit_model extends MY_Model {
    //put your code here
    
    public $table_name;
    public function __construct() {
        parent::__construct();
        $this->table_name = 'cd_rateit';
    }
    public function get_groupby_rate($i_deal_id) {
        $record_set = $this->db->query("SELECT COUNT(1) as 'total_count', `f_value` FROM `cd_rateit` WHERE i_deal_id  = $i_deal_id GROUP BY `f_value`"); 
        return $record_set->result_array();
    }

    /**
     * get the list of all data in table 
     */
   
}

?>
