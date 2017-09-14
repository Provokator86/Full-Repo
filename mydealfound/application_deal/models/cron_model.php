<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of Deal_model
 * deal model automatically detect deal from the database means cd_coupon.i_coupon_type =
 * 1=>deal, 2=>coupon 
 * @author user
 */

class Cron_model extends MY_Model {

    //put your code here    

    public $table_name;    

    public function __construct() {

        parent::__construct();

        $this->table_name = 'cd_cashback_master';
    }

	
	public function insert_cashback($dataToInsert=array()) {

		$ret = 0;
        if ($dataToInsert) {
            $this->db->insert($this->table_name, $dataToInsert);
			$ret = $this->db->insert_id();
        } 
        return $ret;

    }
	
	public function fetch_cashback($condition= '') {
	
		$sql = " SELECT * FROM ".$this->table_name." ".($condition!=""?$condition:"");
		$res = $this->db->query($sql);       
		return $res->result_array();

    }
	
	/* end below function used for deal alert*/
    /**
     * get the list of all data in table 
     */
}