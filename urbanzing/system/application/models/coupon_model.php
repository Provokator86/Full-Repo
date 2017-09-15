<?php
class Coupon_model extends My_model
{

    public function __construct()
    {
        parent::__construct();
    }

    function get_exists_coupon($user_id,$business_id)
    {
        if(!isset($user_id) || !isset($business_id) || $user_id<1 || $business_id<1)
            return false;
        $sql    = "SELECT id FROM {$this->db->dbprefix}request_for_coupon WHERE cr_by=$user_id AND business_id=$business_id";
        $query  = $this->db->query($sql);
	$tot    = $query->num_rows();
        if($tot>0)
            return false;
        else
            return true;
    }

}