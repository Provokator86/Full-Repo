<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Description of user_model
 * @author user
 */

class User_model extends MY_Model {
    //put your code here    

    public $table_name;
	public $tbl_invite;
	public $tbl_pay_info;
	public $tbl_cashbk_earn;
	public $tbl_cashbk_paid;

    public function __construct() {

        parent::__construct();
        $this->table_name = 'cd_user';
		$this->tbl_invite = 'cd_user_invitation';
		$this->tbl_pay_info = 'cd_user_payment_info';
		
		$this->tbl_cashbk_earn = 'cd_cashback_earned';
		$this->tbl_cashbk_paid = 'cd_cashback_paid';
    }


	/* check for duplicate emails */
	public function check_invite($mail,$user_id)
    {
        try
        {
          $ret_=0;
           $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl_invite." "
                ." Where s_email='".$mail."' AND  i_inviter=".$user_id;
				
          $rs=$this->db->query($s_qry);
		  
		   $s_qry1="Select count(*) as i_total "
                ."From ".$this->table_name." "
                ." Where s_email='".$mail."' ";
				
          $rs1=$this->db->query($s_qry1);
          $i_cnt=0;
		//   echo $ret_;
          if($rs->num_rows()>0)
          {
		  	 foreach($rs->result() as $row)
              {
                  $ret_=intval($row->i_total); 
              }  
			//  echo $ret_;
		  	if($ret_!=0)
			$ret_ =1;
          }
		  if($rs1->num_rows()>0 &&$ret_==0)
          {
		  	 foreach($rs1->result() as $row)
              {
                  $ret_=intval($row->i_total); 
              }  
		  	if($ret_!=0)
			   $ret_ = 2;        
          }
		 // echo $ret_;
         
          return $ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    } 
	
	public function add_invite($dataToInsert=array()) {

		$ret = 0;
        if ($dataToInsert) {
            $this->db->insert($this->tbl_invite, $dataToInsert);
			$ret = $this->db->insert_id();
        } 
        return $ret;

    }
	
	public function get_invite_list($condition='')
    {
		$sql = " SELECT * FROM ".$this->tbl_invite." ".($condition!=""?$condition:"");
		$res = $this->db->query($sql);
		return $res->result_array();
	} 
	
	public function get_payment_info($condition='')
    {
		$sql = " SELECT * FROM ".$this->tbl_pay_info." ".($condition!=""?$condition:"");
		$res = $this->db->query($sql);
		return $res->result_array();
	} 
	
	public function add_payment_info($dataToInsert=array()) {

		$ret = 0;
        if ($dataToInsert) {
            $this->db->insert($this->tbl_pay_info, $dataToInsert);
			$ret = $this->db->insert_id();
        } 
        return $ret;
    }
	
	public function update_payment_info($dataToInsert, $condition = NULL) 
	{   
    	return $this->db->update($this->tbl_pay_info, $dataToInsert, $condition);			
    }
	
	public function add_cashback_earned($dataToInsert=array()) {

		$ret = 0;
        if ($dataToInsert) {
            $this->db->insert($this->tbl_cashbk_earn, $dataToInsert);
			$ret = $this->db->insert_id();
        } 
        return $ret;

    }
	
	public function cashback_earned($condition='')
    {
		//$sql = " SELECT SUM(d_amount) AS tot_earn FROM ".$this->tbl_cashbk_earn." ".($condition!=""?$condition:"");
		$sql = " SELECT SUM(cashback_amount) AS tot_earn FROM ".$this->tbl_cashbk_earn." ".($condition!=""?$condition:"");
		$res = $this->db->query($sql);
		return $res->result_array();
	} 
	
	public function cashback_paid($condition='')
    {
		$sql = " SELECT SUM(d_price) AS tot_paid FROM ".$this->tbl_cashbk_paid." ".($condition!=""?$condition:"");
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	
	/****************** user total earnings and its list below ********************/
	
	public function get_earning_list($s_where=null,$i_start=null,$i_limit=null,$order_by=false) 
	{
		//$ret_=array();
		$order_str = '';
		if($order_by)
			$order_str = $order_by;
		else
			$order_str = "ORDER BY n.dt_of_payment DESC";
		
		$s_qry="SELECT n.* FROM ".$this->tbl_cashbk_earn." AS n ".
		($s_where!=""?$s_where:"" )." {$order_str} ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		
		$rs=$this->db->query($s_qry);		
		return $rs->result_array();
    }
	
	public function count_total_earning($s_where=null) 
	{
		$s_qry="Select count(n.i_id) as i_total "
			."From ".$this->tbl_cashbk_earn." AS n "
			.($s_where!=""?$s_where:"" );
		$rs=$this->db->query($s_qry);
		return count($rs->result_array);
    }
	
	
	public function all_cashback_earning($condition='')
    {
		$sql = " SELECT SUM(cashback_amount) AS tot_earn FROM ".$this->tbl_cashbk_earn." ".($condition!=""?$condition:"");
		$res = $this->db->query($sql);
		$ret = $res->result_array();
		return $ret[0]['tot_earn'];
	} 
	
	public function all_cashback_paid($condition='')
    {
		$sql = " SELECT SUM(d_price) AS tot_paid FROM ".$this->tbl_cashbk_paid." ".($condition!=""?$condition:"");
		$res = $this->db->query($sql);
		$ret = $res->result_array();
		return $ret[0]['tot_paid'];
	} 
	
	public function add_withdrawl_info($dataToInsert=array()) {

		$ret = 0;
        if ($dataToInsert) {
            $this->db->insert($this->tbl_cashbk_paid, $dataToInsert);
			$ret = $this->db->insert_id();
        } 
        return $ret;
    }
	
	public function get_withdrawl_list($s_where=null,$i_start=null,$i_limit=null,$order_by=false) 
	{
		//$ret_=array();
		$order_str = '';
		if($order_by)
			$order_str = $order_by;
		else
			$order_str = "ORDER BY n.dt_of_payment DESC";
		
		$s_qry="SELECT n.* FROM ".$this->tbl_cashbk_paid." AS n ".
		($s_where!=""?$s_where:"" )." {$order_str} ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		
		$rs=$this->db->query($s_qry);		
		return $rs->result_array();
    }
	
	public function update_invitation_info($dataToInsert, $condition = NULL) 
	{   
    	return $this->db->update($this->tbl_invite, $dataToInsert, $condition);			
    }
	
	/****************** end user total earnings and its list ********************/

}

?>