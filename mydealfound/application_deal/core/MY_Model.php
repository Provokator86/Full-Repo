<?php



/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */



/**

 * Description of MY_Model

 *

 * @author user

 */

class MY_Model extends CI_Model {



    //put your code here

            protected $table_name, $joiningArray;



    public function __construct() {

        parent::__construct();

    }

    public function get_list($condition = NULL, $column = NULL, $limit = NULL, $start = 0,$orderby = NULL,$ordertype='desc',$likeCondition = NULL) {
	
	//echo $likeCondition;exit;

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

         if($orderby)

            $this->db->order_by($orderby, $ordertype);

        $this->db->stop_cache();

        $query = $this->db->get($this->table_name, $limit, $start, $likeCondition = NULL);		

        $this->db->flush_cache();

        return $query->result_array();

    }



    public function get_joined_list($condition = NULL, $column = NULL, $limit = NULL, $start = 0,$orderby = NULL,$ordertype='desc', $likeCondition = NULL) {



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

        if ($this->joiningArray)

            foreach ($this->joiningArray as $joinMeta) {

                $this->db->join($joinMeta['table'], $joinMeta['condition'], isset($joinMeta['type']) ? $joinMeta['type'] : 'left');

            }

             if($orderby)

            $this->db->order_by($orderby, $ordertype); 

        $this->db->stop_cache();

        $query = $this->db->get($this->table_name, $limit, $start);

        $this->db->flush_cache();

        return $query->result_array();

    }



    public function count_total_joined_list($condition = NULL, $column = NULL, $limit = NULL, $start = 0,$orderby = NULL,$ordertype='desc', $likeCondition = NULL) {



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

        if ($this->joiningArray)

            foreach ($this->joiningArray as $joinMeta) {

                $this->db->join($joinMeta['table'], $joinMeta['condition'], isset($joinMeta['type']) ? $joinMeta['type'] : 'left');

            }

        $this->db->stop_cache();

        $query = $this->db->get($this->table_name, $limit, $start);

        $this->db->flush_cache();

        $data = $query->result_array();

        $this->db->flush_cache();

        return $data[0]['total'];

    }



    public function count_total($condition = NULL, $likeCondition = NULL) {

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

        $this->db->stop_cache();

        $query = $this->db->get($this->table_name);

        $data = $query->result_array();

        $this->db->flush_cache();

        return $data[0]['total'];

    }



    public function insert_data($dataToInsert, $isMulti = FALSE) {

        if ($isMulti) {

            $this->db->insert_batch($this->table_name, $dataToInsert);

        } else {

            $this->db->insert($this->table_name, $dataToInsert);

        }

        return $this->db->insert_id();

    }



    public function update_data($dataToInsert, $condition = NULL, $target_field = NULL) {

        if ($target_field) {

            return $this->db->update_batch($this->table_name, $dataToInsert, $target_field);

        } else {

            return $this->db->update($this->table_name, $dataToInsert, $condition);

        }

    }



}