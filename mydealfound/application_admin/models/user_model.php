<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of users_model
 * @author user
 */
class User_model extends MY_Model {

	public $table_name,$tbl,$tbl_cashbk_earn, $tbl_cashbk_paid, $joiningArray;
	
    public function __construct() {
        parent::__construct();
        $this->table_name = 'cd_user';		
		$this->tbl	= 'cd_user';
		$this->tbl_cashbk_earn 	= 'cd_cashback_earned';
		$this->tbl_cashbk_paid 	= 'cd_cashback_paid';
		
		$this->joiningArray[0]['table'] = 'cd_user_payment_info';
        $this->joiningArray[0]['condition'] = 'cd_user_payment_info.i_user_id = cd_user.i_id';
    }

    //put your code here	
	public function delete_info($i_id)
    {
        try
        {
            $i_ret_=0;////Returns false  
            if(intval($i_id)>0)
            {
				$s_qry="DELETE FROM ".$this->tbl." ";
                $s_qry.=" Where i_id=? ";
                $i_ret_= $this->db->query($s_qry, array(intval($i_id)) );
				//echo $this->db->last_query();exit;
                //$i_ret_=$this->db->affected_rows(); 
				if($i_ret_)  
				{
					$sql1="DELETE FROM ".$this->tbl_cashbk_earn." ";
					$sql1.=" Where user_id=? ";
					$this->db->query($sql1, array(intval($i_id)) );
					
					$sql2="DELETE FROM ".$this->tbl_cashbk_paid." ";
					$sql2.=" Where user_id=? ";
					$this->db->query($sql2, array(intval($i_id)) );
				}
            }
            elseif(intval($i_id)==-1)////Deleting All
            {
				$s_qry="DELETE FROM ".$this->tbl." ";
                $i_ret_= $this->db->query($s_qry);
				//echo $this->db->last_query();exit;
                //$i_ret_=$this->db->affected_rows();  
				if($i_ret_)  
				{
					$sql1="DELETE FROM ".$this->tbl_cashbk_earn." ";
					$sql1.=" Where user_id=? ";
					$this->db->query($sql1, array(intval($i_id)) );
					
					$sql2="DELETE FROM ".$this->tbl_cashbk_paid." ";
					$sql2.=" Where user_id=? ";
					$this->db->query($sql2, array(intval($i_id)) );
				}
            }
            unset($s_qry, $i_id, $sql2, $sql1);
			//echo '$i_ret_'.$i_ret_; exit;
            return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           

    }
	
	public function get_joined_user_detail($condition=NULL,$column=NULL,$limit=10,$start=0,$likeCondition = NULL) {

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
	
	
    private function process_condition($condition = null){

        if(is_array($condition)){
            //for active
            if(!(array_key_exists('i_active', $condition)||array_key_exists('cd_user.i_active', $condition))){
                $condition['cd_user.i_active'] = 1;
            }          
            //pr($condition);
        } else {
            echo 'none array where condition for deal model, need to rebuilt the code';
            die();
        }
        return $condition;

    }
	
	/*******
    * Fetches One record from db for the id value.
    * @param int $i_id
    * @returns array
    */
    public function fetch_this($i_id)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
				$s_query="SELECT * 
						 FROM ".$this->tbl."
						 WHERE i_id='".($i_id)."'";
				//echo $s_query;exit;
                $rs=$this->db->query($s_query); 
          		return ($rs->result_array());
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    } 

	 /***
    * Update records in db. As we know the table name 
    * we will not pass it into params.
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @param int $i_id, id value to be updated used in where clause
    * @returns $i_rows_affected  on success and FALSE if failed 
    */
    public function edit_info($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            { 
				$where=array("i_id"=>$i_id);
				$sql = $this->db->update_string($this->tbl,$info,$where);
				//echo $sql;exit;
				if($this->db->simple_query($sql))
				{
					return	$this->db->affected_rows();
				}
				else
				{
					return FALSE; //error
				}
            }
            unset($s_qry, $info,$i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          

    } 
	
    



}

?>