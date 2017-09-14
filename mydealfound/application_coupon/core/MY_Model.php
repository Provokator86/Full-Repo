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
    protected $table_name;
    public function __construct() {
        parent::__construct();
    }
    
     public function get_list($condition=NULL,$column=NULL,$limit=10,$start=0) {
        $this->db->start_cache();
        if($column)
            $this->db->select($column);
        if($condition)
            $this->db->where($condition);
        $this->db->stop_cache();
        $query = $this->db->get($this->table_name,$limit,$start);
         $this->db->flush_cache();
        return $query->result_array();
        
    }
}

?>
