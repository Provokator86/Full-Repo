<?php
class Business_profile_model extends My_model
{
    public function __construct()
    {
        parent::__construct();
    }

/*	function get_menu_list($business_id=-1)
    {
        $sql    = "SELECT * FROM {$this->db->dbprefix}business_menu WHERE business_id=$business_id";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr;
    }*/	
	
	/**
	 * @author Rubel Debnath
	 * @author Anutosh Ghosh
	 */
	function get_menu_list($business_id = 0, $menu_id = 0, $str_name_prefix = 'Uploaded by')
    {
		$extra_col_text_prefix = $extra_col_text_suffix = '';
		if (!empty($str_name_prefix)) {
			$extra_col_text_prefix = trim($str_name_prefix).' &ldquo;';
			$extra_col_text_suffix = '&rdquo;';
		}

		if (!empty($business_id)) {
	        $sql = "SELECT menu.*, CONCAT('".$extra_col_text_prefix."', user.f_name, ' ', user.l_name, '".$extra_col_text_suffix."') full_name
					FROM {$this->db->dbprefix}business_menu as menu
						INNER JOIN {$this->db->dbprefix}users as user
						ON user.id = menu.cr_by
					WHERE business_id = $business_id";
		}
		else if (!empty($menu_id)) {
			$sql = "SELECT menu.*, CONCAT('".$extra_col_text_prefix."', user.f_name, ' ', user.l_name, '".$extra_col_text_suffix."') full_name
					FROM {$this->db->dbprefix}business_menu as menu
						INNER JOIN {$this->db->dbprefix}users as user
						ON user.id = menu.cr_by
					WHERE id = $menu_id";
		}

		if (!empty($sql)) {
	        $query = $this->db->query($sql);
		    $result_arr = $query->result_array();
			return $result_arr;
		}
		else {
			return FALSE;
		}
    }

    function get_business_detail($arr = array(), $str_name_prefix = 'Uploaded by')
    {
		$extra_col_text_prefix = $extra_col_text_suffix = '';
		if (!empty($str_name_prefix)) {
			$extra_col_text_prefix = trim($str_name_prefix).' &ldquo;';
			$extra_col_text_suffix = '&rdquo;';
		}
		
		$CI = get_instance();
		$CI->load->model('business_model');
		$subcond = '';
		if(isset($arr['id']) && $arr['id']!='')
			$subcond .= " AND b.id='{$arr['id']}' ";
		$business_category = $CI->business_model->get_business_list(array('id'=>$arr['id']),1,0);	
		
		if(isset($business_category[0]['business_category']) && !empty($business_category[0]['business_category']) && $business_category[0]['business_category'] == 1)
		{
			$sql = "SELECT b.*, CONCAT('".$extra_col_text_prefix."', user.f_name, ' ', user.l_name, '".$extra_col_text_suffix."') full_name, ct.name ct_name, s.name s_name, c.name c_name, z.zipcode, bp.img_name, p.price_from, p.price_to, z.place
					FROM {$this->db->dbprefix}business b
						INNER JOIN {$this->db->dbprefix}city ct ON ct.id = b.city_id
						INNER JOIN {$this->db->dbprefix}state s ON s.id = b.state_id
						INNER JOIN {$this->db->dbprefix}country c ON c.id = b.country_id
						INNER JOIN {$this->db->dbprefix}zipcode z ON z.id = b.zipcode
						INNER JOIN {$this->db->dbprefix}price_range p ON p.id = b.price_range_id
						LEFT JOIN {$this->db->dbprefix}business_picture bp ON b.id = bp.business_id AND bp.cover_picture = 'Y'
						LEFT JOIN {$this->db->dbprefix}users as user ON user.id = bp.cr_by
					WHERE 1 $subcond
					GROUP BY b.id";
		}
		else
		{
			$sql = "SELECT b.*, CONCAT('".$extra_col_text_prefix."', user.f_name, ' ', user.l_name, '".$extra_col_text_suffix."') full_name, ct.name ct_name, s.name s_name, c.name c_name, z.zipcode, bp.img_name, z.place
					FROM {$this->db->dbprefix}business b
						INNER JOIN {$this->db->dbprefix}city ct ON ct.id = b.city_id
						INNER JOIN {$this->db->dbprefix}state s ON s.id = b.state_id
						INNER JOIN {$this->db->dbprefix}country c ON c.id = b.country_id
						INNER JOIN {$this->db->dbprefix}zipcode z ON z.id = b.zipcode
						LEFT JOIN {$this->db->dbprefix}business_picture bp ON b.id = bp.business_id AND bp.cover_picture = 'Y'
						LEFT JOIN {$this->db->dbprefix}users as user ON user.id = bp.cr_by
					WHERE 1 $subcond
					GROUP BY b.id";
		
		}				
		$sql .= ' LIMIT 0,1';
		$query = $this->db->query($sql);
		$result_arr = $query->result_array();
		foreach ($result_arr as $k => $v)
		{
			$result_arr[$k]['cuisine'] = $this->get_business_cuisine_name($v['id']);
			$result_arr[$k]['business_picture'] = $this->get_business_photo(array('business_id' => $v['id']), $str_name_prefix);
			$result_arr[$k]['business_hour'] = $this->get_business_hour($v['id']);
		}
		return $result_arr;
    }

    function get_business_hour($business_id)
    {
        if(!isset($business_id) || $business_id=='' || $business_id<1)
            return false;
        $sql    = "SELECT * FROM {$this->db->dbprefix}business_hour WHERE business_id=$business_id";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr;
    }

    /**
	 * If "$arr" variable has an index "all", then no consideration will take place for "cover_picture" field
	 *
	 * @author Anutosh Ghosh
	 * @param array $arr
	 * @return array
	 */
    function get_business_photo($arr = array(), $str_name_prefix = 'Uploaded by')
    {
		$extra_col_text_prefix = $extra_col_text_suffix = '';
		if (!empty($str_name_prefix)) {
			$extra_col_text_prefix = trim($str_name_prefix).' &ldquo;';
			$extra_col_text_suffix = '&rdquo;';
		}
		
		$subcond = ' WHERE bp.status = "1"';

		if(isset($arr['business_id']) && !empty($arr['business_id']) && $arr['business_id'] > 0)
			$subcond .= " AND bp.business_id = {$arr['business_id']}";
		
		if(isset($arr['id']) && !empty($arr['id']) && $arr['id'] > 0)
			$subcond .= " AND bp.id = {$arr['id']}";

		if($arr['cover_picture'] == 'Y' && !array_key_exists('all', $arr))
			$subcond .= " AND bp.cover_picture = 'Y'";
		else if (!array_key_exists('all', $arr))
			$subcond .= " AND bp.cover_picture = 'N'";

		if (isset($arr['order_by']) && !empty($arr['order_by'])) {
			$order_type = !empty($arr['order_type']) ? $arr['order_type'] : 'ASC';
			$subcond .= " ORDER BY bp.".$arr['order_by']." ".$order_type;
		}

		if (isset($arr['limit']) && !empty($arr['limit'])) {
			$subcond .= " LIMIT ".$arr['limit'];
		}

		$sql = "SELECT bp.*, CONCAT('".$extra_col_text_prefix."', user.f_name, ' ', user.l_name, '".$extra_col_text_suffix."') full_name
				FROM {$this->db->dbprefix}business_picture bp
					INNER JOIN {$this->db->dbprefix}users as user
					ON user.id = bp.cr_by
				$subcond";
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

    function get_business_location($business_id)
    {
        if(!isset($business_id) || $business_id=='')
            return false;
        $sql    = "SELECT b.name,b.address, ct.name ct_name,s.name s_name,c.name c_name,z.zipcode
                    FROM {$this->db->dbprefix}business b
                        INNER JOIN {$this->db->dbprefix}city ct ON ct.id=b.city_id
                        INNER JOIN {$this->db->dbprefix}state s ON s.id=b.state_id
                        INNER JOIN {$this->db->dbprefix}country c ON c.id=b.country_id
                        INNER JOIN {$this->db->dbprefix}zipcode z ON z.id=b.zipcode
                  WHERE b.id=$business_id
                GROUP BY b.id";
        $sql    .= ' LIMIT 0,1';
//        echo $sql;
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr;
    }
	
	function set_business_cover_pic($biz_id)
	{
		if (!empty($biz_id) && $biz_id > 0)
		{
			$cover_pic_details = $this->get_business_photo(array(
				'business_id' => $biz_id,
				'cover_picture' => 'Y',
				'order_by' => 'id',
				'order_type' => 'ASC',
				'limit' => 1
			));

			if (empty($cover_pic_details))
			{
				$non_cover_pic_details = $this->get_business_photo(array(
					'business_id' => $biz_id,
					'cover_picture' => 'N',
					'order_by' => 'id',
					'order_type' => 'ASC',
					'limit' => 1
				));

				if (!empty($non_cover_pic_details))
				{
					$this->set_data_update('business_picture', array('cover_picture' => 'Y'), $non_cover_pic_details[0]['id']);
				}
			}
		}

		return false;
	}
}