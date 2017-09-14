<?php



/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */



/**

 * Description of Deal_model

 * deal model automatically detect deal from the database means cd_coupon.i_coupon_type =

 * 1=>deal, 2=>coupon 

 * @author user

 */

class Deal_model extends MY_Model {

    //put your code here

    

    public $table_name,$joiningArray;
	public $deal_alert_tbl;

    

    public function __construct() {

        parent::__construct();

        $this->table_name = 'cd_coupon';
		$this->deal_alert_tbl = 'cd_deal_alert';

        $this->joiningArray[0]['table'] = 'cd_store';

        $this->joiningArray[0]['condition'] = 'cd_store.i_id = cd_coupon.i_store_id';

    }

    

    public function get_active_deal_list($condition=NULL,$column=NULL,$limit=10,$start=0,$likeCondition = NULL) {

        $condition = $this->process_condition($condition);

        $this->db->start_cache();

        if($column)

            $this->db->select($column);

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

        $query = $this->db->get($this->table_name,$limit,$start);

         $this->db->flush_cache();

        return $query->result_array();

        

    }

    

    public function get_joined_active_deal_list($condition=NULL,$column=NULL,$limit=10,$start=0,$likeCondition = NULL) {

        $condition = $this->process_condition($condition);

        $this->db->start_cache();

        if($column)

            $this->db->select($column);

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

        if($this->joiningArray)

            foreach ($this->joiningArray as $joinMeta) {

                $this->db->join($joinMeta['table'], $joinMeta['condition'],isset($joinMeta['type'])?$joinMeta['type']:'left');

            }

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

            $this->db->where($condition);

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

            echo 'none array where condition for deal model, need to rebuilt the code';

            die();

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
	/* end below function used for deal alert*/



    /**

     * get the list of all data in table 

     */

   

}



?>

