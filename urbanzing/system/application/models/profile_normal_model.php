<?php
class Profile_normal_model extends My_model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
	 *
	 * @param <type> $cur_user_id = the id of current user
	 * @return <type> Purnendu
	 */
	function get_interested_business_detail($cur_user_id)
    {
     					
		$sql = "SELECT b.name, b.address, b.id as business_id, bp.img_name, c.id, c.cr_by
						FROM {$this->db->dbprefix}request_for_coupon c 
						INNER JOIN {$this->db->dbprefix}business b
						ON c.business_id = b.id
						LEFT JOIN {$this->db->dbprefix}business_picture bp
						ON b.id = bp.business_id
						WHERE  c.cr_by = {$cur_user_id}
						ORDER BY b.name";
		
		
		$query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr;
    }


    /**
	 *
	 * @param <type> $coupon_id = the id of urban_request_for_coupon
	 * @return <type> Purnendu
	 */

	function delete_interest_for_coupon($coupon_id)
	{
		$sql = sprintf("DELETE
						FROM {$this->db->dbprefix}request_for_coupon
						WHERE id = %s",
						$coupon_id);
		$this->db->query($sql);

		
	}
	function get_interested_business_details($coupon_id)
	{
		$sql = sprintf("SELECT *
						FROM {$this->db->dbprefix}request_for_coupon
						WHERE id = %s",
						$coupon_id);
		$query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr;

	}

    function get_business_cuisine_name($business_id)
    {
        if(!isset($business_id) || $business_id=='' || $business_id<1)
            return false;
        $sql    = "SELECT c.cuisine FROM
                    {$this->db->dbprefix}business_cuisine bc INNER JOIN {$this->db->dbprefix}cuisine c ON c.id=bc.cuisine_id
                    WHERE bc.business_id= $business_id ORDER BY c.cuisine";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        $arr    = array();
        foreach ($result_arr    as $k=>$v)
            $arr[$k]    = $v['cuisine'];
        return implode(', ', $arr);
    }

/*    function get_planed_party_list($user_id)
    {
        if(!isset($user_id) || $user_id<1)
            return false;
        $sql    = "SELECT * FROM {$this->db->dbprefix}party WHERE cr_by=$user_id";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr;
    }*/

	/**
	 * @param int $user_id
	 * @return array
	 * @author Iman Biswas
	 * @author Anutosh Ghosh
	 */
    function get_planed_party_list($user_id)
    {
        if(!isset($user_id) || $user_id<1)
            return false;
        $sql = "SELECT * FROM {$this->db->dbprefix}party
				WHERE cr_by = $user_id
					AND (status != 3 OR status != 0)
				ORDER BY start_date DESC";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr;
    }

   function my_uploaded_picture($user_id)
    {
        if(!isset($user_id) || $user_id<1)
            return false;
        $sql    = "SELECT bp.* , b.name FROM {$this->db->dbprefix}business_picture bp, {$this->db->dbprefix}business b 
					WHERE bp.cr_by = $user_id AND bp.business_id = b.id";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr;
    }

    function get_business_list_option($type_id,$category_id,$id=-1)
    {
        $sql    = "SELECT * FROM {$this->db->dbprefix}business WHERE business_category='$category_id' AND business_type_id='$type_id' ";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        $html   = '';
        foreach($result_arr as $k=>$v)
        {
            $selected   = '';
            if($v['id']==$id)
                $selected   = ' selected ';
            $html   .= "<option value='{$v['id']}' $selected>{$v['name']}</option>";
            return $html;
        }
    }

    function get_address_book_list($user_id)
    {
        if(!isset($user_id) || $user_id<1)
            return false;
        $sql    = "SELECT * FROM {$this->db->dbprefix}address_book WHERE cr_by=$user_id";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr;
    }

    function set_import_contact($arr)
    {
        if(isset($arr) && count($arr)>0 && isset($arr['cr_by']) && $arr['cr_by']>0 && isset ($arr['email']) && $arr['email']!='')
        {
            if($this->get_check_duplicate_contact($arr['cr_by'],$arr['email']))
            {
                $this->set_data_insert('address_book',$arr);
            }
        }
    }

    function get_check_duplicate_contact($user_id,$email)
    {
        $sql    = "SELECT id FROM {$this->db->dbprefix}address_book WHERE cr_by=$user_id AND email='$email'";
        $query = $this->db->query($sql);
        $tot    = $query->num_rows();
        if($tot>0)
            return false;
        return true;
    }






}