<?php
class Business_search_model extends My_model
{
	public function __construct()
	{
		parent::__construct();
	}

	function get_search_business($toshow = -1, $page = 0, $arr = array(), $order_by = 'b.name', $order_type = 'asc')
	{
		$subcond = $limit = '';

		if(isset($arr['business_category']) && !empty($arr['business_category']))
			$subcond .= " AND b.business_category = '{$arr['business_category']}' ";

		if(isset($arr['status']) && !empty($arr['status']))
			$subcond .= " AND b.status = '{$arr['status']}' ";

		// Here "empty()" function cannot be used, as there is a need to search for 0 values.
		if(isset($arr['avg_review']) && $arr['avg_review'] != '')
			$subcond .= " AND b.avg_review = '{$arr['avg_review']}' ";

		if(isset($arr['vegetarian']) && !empty($arr['vegetarian']))
			$subcond .= " AND b.vegetarian = '{$arr['vegetarian']}' ";
		
		if(isset($arr['air_conditioned']) && !empty($arr['air_conditioned']))
			$subcond .= " AND b.air_conditioned = '{$arr['air_conditioned']}' ";
		
		if(isset($arr['credit_card']) && !empty($arr['credit_card']))
			$subcond .= " AND b.credit_card = '{$arr['credit_card']}' ";
		
		if(isset($arr['take_reservation']) && !empty($arr['take_reservation']))
			$subcond .= " AND b.take_reservation = '{$arr['take_reservation']}' ";
		
		if(isset($arr['parking']) && !empty($arr['parking']))
			$subcond .= " AND b.parking = '{$arr['parking']}' ";
		
		if(isset($arr['business_type_id']) && !empty($arr['business_type_id']))
			$subcond .= " AND b.business_type_id IN ({$arr['business_type_id']}) ";

		if(isset($arr['price_range_id']) && !empty($arr['price_range_id']) &&
				isset($arr['business_category']) && $arr['business_category'] == 1)
			$subcond .= " AND b.price_range_id IN ({$arr['price_range_id']}) ";

		if(isset($arr['cuisine_id']) && !empty($arr['cuisine_id']) &&
				isset($arr['business_category']) && $arr['business_category'] == 1)
			$subcond .= " AND bc.cuisine_id IN ({$arr['cuisine_id']}) ";

		if(isset($arr['search_for']) && !empty($arr['search_for']))
		{
			$subcond .= " AND (";
			$subcond .= "b.name LIKE '%{$arr['search_for']}%'
						OR b.address LIKE '%{$arr['search_for']}%'
						OR b.land_mark LIKE '%{$arr['search_for']}%'
						OR b.tags LIKE '%{$arr['search_for']}%'";

			if (isset($arr['business_category']) && $arr['business_category'] == 1)
			{
				$subcond .= " OR cs.cuisine LIKE '%{$arr['search_for']}%'";
			}

			$subcond .= ")";
		}

		if(isset($arr['search_in']) && !empty($arr['search_in']))
			$subcond .= " AND (c.name LIKE '%{$arr['search_in']}%'
							OR ct.name LIKE '%{$arr['search_in']}%'
							OR s.name LIKE '%{$arr['search_in']}%'
							OR z.zipcode LIKE '%{$arr['search_in']}%'
							OR z.place LIKE '%{$arr['search_in']}%'
						)";

		if(isset($arr['zipcode']) && !empty($arr['zipcode']))
		{
			$zip_id_list = $this->get_zip_id_range($arr['zipcode']);
			$subcond .= " AND b.zipcode IN ($zip_id_list) ";
		}

		if(isset($arr['business_category']) && $arr['business_category'] == 1) {
			$sql = "SELECT b.id, b.name, b.address, b.land_mark, b.tags, b.phone_number, b.website, b.avg_review,
							b.tot_review, b.business_category, ct.name ct_name, s.name s_name, c.name c_name,
							z.zipcode, bp.img_name, p.price_from, p.price_to, z.place, bt.name bt_name
					FROM {$this->db->dbprefix}business b
					INNER JOIN {$this->db->dbprefix}city ct ON ct.id = b.city_id
					INNER JOIN {$this->db->dbprefix}state s ON s.id = b.state_id
					INNER JOIN {$this->db->dbprefix}country c ON c.id = b.country_id
					INNER JOIN {$this->db->dbprefix}zipcode z ON z.id = b.zipcode
					INNER JOIN {$this->db->dbprefix}business_type bt ON bt.id = b.business_type_id
					INNER JOIN {$this->db->dbprefix}business_type bt_main ON bt_main.id = b.business_category
					INNER JOIN {$this->db->dbprefix}price_range p ON p.id = b.price_range_id
					LEFT JOIN {$this->db->dbprefix}business_picture bp
						ON b.id = bp.business_id
						AND bp.cover_picture
					LEFT JOIN {$this->db->dbprefix}business_cuisine bc ON b.id = bc.business_id
					LEFT JOIN {$this->db->dbprefix}cuisine cs ON bc.cuisine_id = cs.id
					WHERE 1 $subcond
					GROUP BY b.id";
		}
		else {
			$sql = "SELECT b.id, b.name, b.address, b.land_mark, b.tags, b.phone_number, b.website, b.avg_review,
							b.tot_review, b.business_category, ct.name ct_name, s.name s_name, c.name c_name,
							z.zipcode, bp.img_name, z.place, bt.name bt_name
					FROM {$this->db->dbprefix}business b
					INNER JOIN {$this->db->dbprefix}city ct ON ct.id = b.city_id
					INNER JOIN {$this->db->dbprefix}state s ON s.id = b.state_id
					INNER JOIN {$this->db->dbprefix}country c ON c.id = b.country_id
					INNER JOIN {$this->db->dbprefix}zipcode z ON z.id = b.zipcode
					INNER JOIN {$this->db->dbprefix}business_type bt ON bt.id = b.business_type_id
					INNER JOIN {$this->db->dbprefix}business_type bt_main ON bt_main.id = b.business_category
					LEFT JOIN {$this->db->dbprefix}business_picture bp
						ON b.id = bp.business_id
						AND bp.cover_picture
					WHERE 1 $subcond
					GROUP BY b.id";
		}
		$query1 = $this->db->query($sql);

		if($toshow > 0)
		{
			$page = $page * $toshow;
			$limit = ' LIMIT '.$page.', '.$toshow;
		}
		
		if ($order_by == 'b.avg_review') {
			$order_type = "DESC";
		}

		$sql .= ' ORDER BY '.$order_by.' '.$order_type.$limit;
		$query = $this->db->query($sql);
		$result_arr = $query->result_array();

		if(isset($result_arr) && count($result_arr))
		{
			global $CI;
			$CI->load->model('business_profile_model');
		
			foreach($result_arr as $k => $v)
			{
				$result_arr[$k]['menu_list'] = $CI->business_profile_model->get_menu_list($v['id']);
			}
		}
		
		
		$result_arr['0']['tot_row'] = $query1->num_rows();
		return $result_arr;
		
	}

	function get_zip_id_range($place)
	{
		$place = str_replace(',', "','", $place);
		$sql = "SELECT id FROM {$this->db->dbprefix}zipcode WHERE place IN ('$place')";
		$query = $this->db->query($sql);
		$result_arr = $query->result_array();
		$arr = array();

		foreach($result_arr as $k => $v)
			$arr[$k] = $v['id'];

		return implode(',', $arr);
	}

	function get_business_type_list($business_category = 1, $arr = array(), $general_search = FALSE)
	{
		$subsql = '';
		$subcond = '';
		if (isset($business_category) && $business_category == 1)
		{
			$subsql .= "LEFT JOIN {$this->db->dbprefix}business_cuisine bc ON b.id = bc.business_id
						LEFT JOIN {$this->db->dbprefix}cuisine cs ON bc.cuisine_id = cs.id";
		}
		
		if(isset($arr['search_for']) && !empty($arr['search_for']))
		{
			$subcond .= "AND (";
			$subcond .= "b.name LIKE '%{$arr['search_for']}%'
						OR b.address LIKE '%{$arr['search_for']}%'
						OR b.land_mark LIKE '%{$arr['search_for']}%'
						OR b.tags LIKE '%{$arr['search_for']}%'";

			if (isset($business_category) && $business_category == 1)
			{
				$subcond .= " OR cs.cuisine LIKE '%{$arr['search_for']}%'";
			}

			$subcond .= ") ";
		}
		
		if ($general_search)
		{
			$subcond_ext .= "AND t.parent_id != 0 ";
		}
		else
		{
			$subcond_ext .= "AND t.parent_id = $business_category";
		}
		
		if(isset($arr['avg_review']) && $arr['avg_review'] != '')
			$subcond .= " AND b.avg_review = '{$arr['avg_review']}' ";

		if(isset($arr['vegetarian']) && !empty($arr['vegetarian']))
			$subcond .= " AND b.vegetarian = '{$arr['vegetarian']}' ";
		
		if(isset($arr['air_conditioned']) && !empty($arr['air_conditioned']))
			$subcond .= " AND b.air_conditioned = '{$arr['air_conditioned']}' ";
		
		if(isset($arr['credit_card']) && !empty($arr['credit_card']))
			$subcond .= " AND b.credit_card = '{$arr['credit_card']}' ";
		
		if(isset($arr['take_reservation']) && !empty($arr['take_reservation']))
			$subcond .= " AND b.take_reservation = '{$arr['take_reservation']}' ";
		
		if(isset($arr['parking']) && !empty($arr['parking']))
			$subcond .= " AND b.parking = '{$arr['parking']}' ";
		
		if(isset($arr['business_type_id']) && !empty($arr['business_type_id']))
			$subcond_ext .= " AND t.id IN ({$arr['business_type_id']}) ";

		if(isset($arr['price_range_id']) && !empty($arr['price_range_id']) &&
				isset($arr['business_category']) && $arr['business_category'] == 1)
			$subcond .= " AND b.price_range_id IN ({$arr['price_range_id']}) ";

		if(isset($arr['cuisine_id']) && !empty($arr['cuisine_id']) &&
				isset($arr['business_category']) && $arr['business_category'] == 1)
			$subcond .= " AND bc.cuisine_id IN ({$arr['cuisine_id']}) ";
			
		if(isset($arr['zipcode']) && !empty($arr['zipcode']))
		{
			$zip_id_list = $this->get_zip_id_range($arr['zipcode']);
			$subcond .= " AND b.zipcode IN ($zip_id_list) ";
		}	
		
		$sql = "SELECT COUNT(DISTINCT bt.id) tot, t.id, t.name
				FROM {$this->db->dbprefix}business_type t
				LEFT JOIN (SELECT b.id,b.business_type_id FROM {$this->db->dbprefix}business b 
							".$subsql."
							WHERE 1 ".$subcond."
							AND b.status = '1' ) bt 
				ON t.id = bt.business_type_id
				WHERE 1 $subcond_ext	
				GROUP BY t.id
				ORDER BY t.name ASC";
		$query = $this->db->query($sql);
		$result_arr = $query->result_array();

		$arrHtml = array();
		$inStart = '<div class="list_box"><ul>';
		$inEnd = '</ul></div>';
		$str1 = $str2 = $str3 = '';

		foreach($result_arr as $k => $v)
		{
			if(isset($arr['business_type_id']) && !empty($arr['business_type_id']))
			{
				$arrHtml['type_out'] .= "<li><a style='cursor:pointer;' onclick=\"business_type_search('".$v['id']."', '{$v['name']}');\">{$v['name']} ({$v['tot']})</a> <a style='cursor:pointer;' onclick=\"business_search_remove_session('".$v['id']."', 'business_type');\"><img src='".base_url()."images/front/small_close.png'></a></li>";
			}
			else
			{
				if($k <= 5)
					$arrHtml['type_out'] .= "<li><a style='cursor:pointer;' onclick=\"business_type_search('".$v['id']."', '{$v['name']}');\">{$v['name']} ({$v['tot']})</a></li>";
	
				if($k % 3 == 0)
					$str1 .= "<li><input name='ck_business_type[]' id='ck_business_type{$v['id']}' type='checkbox' value='{$v['id']}'/> {$v['name']} ({$v['tot']})</li>";
				elseif($k % 3 == 1)
					$str2 .= "<li><input name='ck_business_type[]' id='ck_business_type{$v['id']}' type='checkbox' value='{$v['id']}'/> {$v['name']} ({$v['tot']})</li>";
				else
					$str3 .= "<li><input name='ck_business_type[]' id='ck_business_type{$v['id']}' type='checkbox' value='{$v['id']}'/> {$v['name']} ({$v['tot']})</li>";
			}
		}

		$arrHtml['type_in'] = $inStart.$str1.$inEnd.$inStart.$str2.$inEnd.$inStart.$str3.$inEnd;
		return $arrHtml;
	}

	function get_price_range_list($business_category = 1, $arr = array(), $general_search = FALSE)
	{
		$subsql = '';
		$subcond = '';
		if (isset($business_category) && $business_category == 1)
		{
			$subsql .= "LEFT JOIN {$this->db->dbprefix}business_cuisine bc ON b.id = bc.business_id
						LEFT JOIN {$this->db->dbprefix}cuisine cs ON bc.cuisine_id = cs.id";
		}
		if(isset($arr['search_for']) && !empty($arr['search_for']))
		{
			$subcond .= "AND (";
			$subcond .= "b.name LIKE '%{$arr['search_for']}%'
						OR b.address LIKE '%{$arr['search_for']}%'
						OR b.land_mark LIKE '%{$arr['search_for']}%'
						OR b.tags LIKE '%{$arr['search_for']}%'";

			if (isset($business_category) && $business_category == 1)
			{
				$subcond .= " OR cs.cuisine LIKE '%{$arr['search_for']}%'";
			}

			$subcond .= ")";
		}
		

		if (!$general_search)
		{
			$subcond .= "AND b.business_category = $business_category";
		}
		
		if(isset($arr['avg_review']) && $arr['avg_review'] != '')
			$subcond .= " AND b.avg_review = '{$arr['avg_review']}' ";

		if(isset($arr['vegetarian']) && !empty($arr['vegetarian']))
			$subcond .= " AND b.vegetarian = '{$arr['vegetarian']}' ";
		
		if(isset($arr['air_conditioned']) && !empty($arr['air_conditioned']))
			$subcond .= " AND b.air_conditioned = '{$arr['air_conditioned']}' ";
		
		if(isset($arr['credit_card']) && !empty($arr['credit_card']))
			$subcond .= " AND b.credit_card = '{$arr['credit_card']}' ";
		
		if(isset($arr['take_reservation']) && !empty($arr['take_reservation']))
			$subcond .= " AND b.take_reservation = '{$arr['take_reservation']}' ";
		
		if(isset($arr['parking']) && !empty($arr['parking']))
			$subcond .= " AND b.parking = '{$arr['parking']}' ";
		
		if(isset($arr['business_type_id']) && !empty($arr['business_type_id']))
			$subcond .= " AND b.business_type_id IN ({$arr['business_type_id']}) ";

		if(isset($arr['price_range_id']) && !empty($arr['price_range_id']) &&
				isset($arr['business_category']) && $arr['business_category'] == 1)
			$subcond_ext .= " AND p.id IN ({$arr['price_range_id']}) ";

		if(isset($arr['cuisine_id']) && !empty($arr['cuisine_id']) &&
				isset($arr['business_category']) && $arr['business_category'] == 1)
			$subcond .= " AND bc.cuisine_id IN ({$arr['cuisine_id']}) ";
			
		if(isset($arr['zipcode']) && !empty($arr['zipcode']))
		{
			$zip_id_list = $this->get_zip_id_range($arr['zipcode']);
			$subcond .= " AND b.zipcode IN ($zip_id_list) ";
		}	
		
		$sql = "SELECT COUNT(DISTINCT bt.id) tot, p.id, p.price_from, p.price_to
				FROM {$this->db->dbprefix}price_range p
				LEFT JOIN (SELECT b.id,b.price_range_id FROM {$this->db->dbprefix}business b 
							".$subsql."
							WHERE 1 ".$subcond."
							AND b.status = '1' ) bt 
				ON p.id = bt.price_range_id
				WHERE 1 $subcond_ext
				GROUP BY p.id
				ORDER BY p.price_from ASC";


		$query = $this->db->query($sql);
		$result_arr = $query->result_array();

		$arrHtml = array();
		$inStart = '<div class="list_box"><ul>';
		$inEnd = '</ul></div>';
		$str1 = $str2 = $str3 = '';

		foreach($result_arr as $k => $v)
		{
			$price_range_text = $v['price_from'];
			if (!empty($v['price_to'])) {
				$price_range_text .= " - ".$v['price_to'];
			}
			if(isset($arr['price_range_id']) && !empty($arr['price_range_id']) &&
				isset($arr['business_category']) && $arr['business_category'] == 1)
			{
				$arrHtml['type_out'] .= "<li><a style='cursor:pointer;' onclick=\"autoload_ajax_no_jsn('".base_url()."search/search_business_list_ajax', 'div_search_business_list', 'price_range={$v['id']}&price_range_text={$price_range_text}');\">{$price_range_text} ({$v['tot']})</a> <a style='cursor:pointer;' onclick=\"business_search_remove_session('".$v['id']."', 'price_range');\"><img src='".base_url()."images/front/small_close.png'></a></li>";
			
			}	
			else
			{
				if($k <= 5)
					$arrHtml['type_out'] .= "<li><a style='cursor:pointer;' onclick=\"autoload_ajax_no_jsn('".base_url()."search/search_business_list_ajax', 'div_search_business_list', 'price_range={$v['id']}&price_range_text={$price_range_text}');\">{$price_range_text} ({$v['tot']})</a></li>";
				
				if($k % 3 == 0)
					$str1 .= "<li><input name='ck_price_range[]' id='ck_price_range{$v['id']}' type='checkbox' value='{$v['id']}' /> {$price_range_text} ({$v['tot']})</li>";
				elseif($k % 3 == 1)
					$str2 .= "<li><input name='ck_price_range[]' id='ck_price_range{$v['id']}' type='checkbox' value='{$v['id']}' /> {$price_range_text} ({$v['tot']})</li>";
				else
					$str3 .= "<li><input name='ck_price_range[]' id='ck_price_range{$v['id']}' type='checkbox' value='{$v['id']}' /> {$price_range_text} ({$v['tot']})</li>";
		   }			
		}

		$arrHtml['type_in'] = $inStart.$str1.$inEnd.$inStart.$str2.$inEnd.$inStart.$str3.$inEnd;
		return $arrHtml;
	}

	function get_avg_review_list($business_category = 1, $arr = array(), $general_search = FALSE)
	{
		$subsql = '';
		$subcond = '';
		if (isset($business_category) && $business_category == 1)
		{
			$subsql .= "LEFT JOIN {$this->db->dbprefix}business_cuisine bc ON b.id = bc.business_id
						LEFT JOIN {$this->db->dbprefix}cuisine cs ON bc.cuisine_id = cs.id";
		}

		if(isset($arr['search_for']) && !empty($arr['search_for']))
		{
			$subcond .= "AND (";
			$subcond .= "b.name LIKE '%{$arr['search_for']}%'
						OR b.address LIKE '%{$arr['search_for']}%'
						OR b.land_mark LIKE '%{$arr['search_for']}%'
						OR b.tags LIKE '%{$arr['search_for']}%'";

			if (isset($business_category) && $business_category == 1)
			{
				$subcond .= " OR cs.cuisine LIKE '%{$arr['search_for']}%'";
			}

			$subcond .= ")";
		}

		if (!$general_search)
		{
			$subcond .= "AND b.business_category = $business_category";
		}
		
		if(isset($arr['avg_review']) && $arr['avg_review'] != '')
			$subcond .= " AND b.avg_review = '{$arr['avg_review']}' ";

		if(isset($arr['vegetarian']) && !empty($arr['vegetarian']))
			$subcond .= " AND b.vegetarian = '{$arr['vegetarian']}' ";
		
		if(isset($arr['air_conditioned']) && !empty($arr['air_conditioned']))
			$subcond .= " AND b.air_conditioned = '{$arr['air_conditioned']}' ";
		
		if(isset($arr['credit_card']) && !empty($arr['credit_card']))
			$subcond .= " AND b.credit_card = '{$arr['credit_card']}' ";
		
		if(isset($arr['take_reservation']) && !empty($arr['take_reservation']))
			$subcond .= " AND b.take_reservation = '{$arr['take_reservation']}' ";
		
		if(isset($arr['parking']) && !empty($arr['parking']))
			$subcond .= " AND b.parking = '{$arr['parking']}' ";
		
		if(isset($arr['business_type_id']) && !empty($arr['business_type_id']))
			$subcond .= " AND b.business_type_id IN ({$arr['business_type_id']}) ";

		if(isset($arr['price_range_id']) && !empty($arr['price_range_id']) &&
				isset($arr['business_category']) && $arr['business_category'] == 1)
			$subcond .= " AND b.price_range_id IN ({$arr['price_range_id']}) ";

		if(isset($arr['cuisine_id']) && !empty($arr['cuisine_id']) &&
				isset($arr['business_category']) && $arr['business_category'] == 1)
			$subcond .= " AND bc.cuisine_id IN ({$arr['cuisine_id']}) ";
		
		if(isset($arr['zipcode']) && !empty($arr['zipcode']))
		{
			$zip_id_list = $this->get_zip_id_range($arr['zipcode']);
			$subcond .= " AND b.zipcode IN ($zip_id_list) ";
		}	
			

		$sql = "SELECT COUNT(DISTINCT b.id) tot, avg_review
				FROM {$this->db->dbprefix}business b
				".$subsql."
				WHERE 1 ".$subcond."
					AND b.status = '1'
				GROUP BY b.avg_review
				ORDER BY b.avg_review ASC";
		$query = $this->db->query($sql);
		$result_arr = $query->result_array();
		
		$arrHtml = array();
		$max_avg_review = 5;
		$img = '';

		foreach($result_arr as $k => $v)
		{
			$arr_required_avg_review[$v['avg_review']] = $v['tot'];
		}

		for($j = 0; $j <= $max_avg_review; $j++)
		{
			if($j)
				$img .= '<img src="'.base_url().'images/front/star.png" alt="" />';

			$avg_review_tot = isset($arr_required_avg_review[$j]) ? $arr_required_avg_review[$j] : 0;
			$num_stars = $j . ' ' . (($j > 1) ? 'Stars' : 'Star');
			if(isset($arr['avg_review']) && $arr['avg_review'] != '')
			{
				$arrHtml[] = "<li><a style='cursor:pointer;' onclick=\"autoload_ajax_no_jsn('".base_url()."search/search_business_list_ajax', 'div_search_business_list', 'avg_review=".$j."');\">".$num_stars.$img." ({$avg_review_tot})</a> <a style='cursor:pointer;' onclick=\"business_search_remove_session('".$j."', 'avg_review');\"><img src='".base_url()."images/front/small_close.png'></a> </li>";
			}
			else
			{
				$arrHtml[] = "<li><a style='cursor:pointer;' onclick=\"autoload_ajax_no_jsn('".base_url()."search/search_business_list_ajax', 'div_search_business_list', 'avg_review=".$j."');\">".$num_stars.$img." ({$avg_review_tot})</a></li>";
			}	
		}
		if(isset($arr['avg_review']) && $arr['avg_review'] != '')
			$arr_new_html['type_out'] = $arrHtml[$arr['avg_review']];
		else
		{	
			$arrHtml = array_reverse($arrHtml);
			$arr_new_html['type_out'] = implode(' ', $arrHtml);
		}
		return $arr_new_html;
	}

	function get_area_list($business_category = 1, $arr = array(), $general_search = FALSE)
	{
		$subsql = '';
		$subcond = '';
		if (isset($business_category) && $business_category == 1)
		{
			$subsql .= "LEFT JOIN {$this->db->dbprefix}business_cuisine bc ON b.id = bc.business_id
						LEFT JOIN {$this->db->dbprefix}cuisine cs ON bc.cuisine_id = cs.id";
		}

		if(isset($arr['search_for']) && !empty($arr['search_for']))
		{
			$subcond .= "AND (";
			$subcond .= "b.name LIKE '%{$arr['search_for']}%'
						OR b.address LIKE '%{$arr['search_for']}%'
						OR b.land_mark LIKE '%{$arr['search_for']}%'
						OR b.tags LIKE '%{$arr['search_for']}%'";

			if (isset($business_category) && $business_category == 1)
			{
				$subcond .= " OR cs.cuisine LIKE '%{$arr['search_for']}%'";
				$subsql .= "LEFT JOIN {$this->db->dbprefix}business_cuisine bc ON b.id = bc.business_id
							LEFT JOIN {$this->db->dbprefix}cuisine cs ON bc.cuisine_id = cs.id";
			}

			$subcond .= ")";
		}

		if (!$general_search)
		{
			$subcond .= "AND b.business_category = $business_category";
		}
		
		if(isset($arr['avg_review']) && $arr['avg_review'] != '')
			$subcond .= " AND b.avg_review = '{$arr['avg_review']}' ";

		if(isset($arr['vegetarian']) && !empty($arr['vegetarian']))
			$subcond .= " AND b.vegetarian = '{$arr['vegetarian']}' ";
		
		if(isset($arr['air_conditioned']) && !empty($arr['air_conditioned']))
			$subcond .= " AND b.air_conditioned = '{$arr['air_conditioned']}' ";
		
		if(isset($arr['credit_card']) && !empty($arr['credit_card']))
			$subcond .= " AND b.credit_card = '{$arr['credit_card']}' ";
		
		if(isset($arr['take_reservation']) && !empty($arr['take_reservation']))
			$subcond .= " AND b.take_reservation = '{$arr['take_reservation']}' ";
		
		if(isset($arr['parking']) && !empty($arr['parking']))
			$subcond .= " AND b.parking = '{$arr['parking']}' ";
		
		if(isset($arr['business_type_id']) && !empty($arr['business_type_id']))
			$subcond .= " AND b.business_type_id IN ({$arr['business_type_id']}) ";

		if(isset($arr['price_range_id']) && !empty($arr['price_range_id']) &&
				isset($arr['business_category']) && $arr['business_category'] == 1)
			$subcond .= " AND b.price_range_id IN ({$arr['price_range_id']}) ";

		if(isset($arr['cuisine_id']) && !empty($arr['cuisine_id']) &&
				isset($arr['business_category']) && $arr['business_category'] == 1)
			$subcond .= " AND bc.cuisine_id IN ({$arr['cuisine_id']}) ";
		
		if(isset($arr['zipcode']) && !empty($arr['zipcode']))
		{
			$zip_id_list = $this->get_zip_id_range($arr['zipcode']);
			$subcond_ext .= " AND z.id IN ($zip_id_list) ";
		}	
		
		$sql = "SELECT COUNT(DISTINCT bt.id) tot, place
				FROM {$this->db->dbprefix}zipcode z
				LEFT JOIN (SELECT b.id,b.zipcode FROM {$this->db->dbprefix}business b 
							".$subsql."
							WHERE 1 ".$subcond."
							AND b.status = '1' ) bt 
				ON bt.zipcode = z.id
				WHERE 1 $subcond_ext
				GROUP BY place
				ORDER BY place ASC";
		

/*		$sql = "SELECT COUNT(DISTINCT b.id) tot, place
				FROM {$this->db->dbprefix}zipcode z
				LEFT JOIN {$this->db->dbprefix}business b ON b.zipcode = z.id
				".$subsql."
				WHERE 1 ".$subcond."
					AND b.status = '1'
				GROUP BY place
				ORDER BY place ASC";*/
		$query = $this->db->query($sql);
		$result_arr = $query->result_array();

		$arrHtml = array();
		$inStart = '<div class="list_box"><ul>';
		$inEnd = '</ul></div>';
		$str1 = $str2 = $str3 = '';
		
		foreach($result_arr as $k => $v)
		{
			if(isset($arr['zipcode']) && !empty($arr['zipcode']))
			{
				$arrHtml['type_out'] .= "<li><a style='cursor:pointer;' onclick=\"autoload_ajax_no_jsn('".base_url()."search/search_business_list_ajax', 'div_search_business_list', 'zipcode=".$v['place']."');\">{$v['place']} ({$v['tot']})</a>  <a style='cursor:pointer;' onclick=\"business_search_remove_session('".$v['place']."', 'zipcode');\"><img src='".base_url()."images/front/small_close.png'></a></li>";
			}
			else
			{
			
				if($k <= 5)
					$arrHtml['type_out'] .= "<li><a style='cursor:pointer;' onclick=\"autoload_ajax_no_jsn('".base_url()."search/search_business_list_ajax', 'div_search_business_list', 'zipcode=".$v['place']."');\">{$v['place']} ({$v['tot']})</a></li>";
				
				if($k % 3 == 0)
					$str1 .= "<li><input name='ck_area_list[]' id='ck_area_list{$v['id']}' type='checkbox' value='{$v['place']}' /> {$v['place']} ({$v['tot']})</li>";
				elseif($k % 3 == 1)
					$str2 .= "<li><input name='ck_area_list[]' id='ck_area_list{$v['id']}' type='checkbox' value='{$v['place']}' /> {$v['place']} ({$v['tot']})</li>";
				else
					$str3 .= "<li><input name='ck_area_list[]' id='ck_area_list{$v['id']}' type='checkbox' value='{$v['place']}' /> {$v['place']} ({$v['tot']})</li>";
			}		
		}

		$arrHtml['type_in'] = $inStart.$str1.$inEnd.$inStart.$str2.$inEnd.$inStart.$str3.$inEnd;
		return $arrHtml;
	}

	function get_cuisine_list($business_category = 1, $arr = array(), $general_search = FALSE)
	{
		$subcond = '';

		if(isset($arr['search_for']) && !empty($arr['search_for']))
		{
			$subcond .= "AND (";
			$subcond .= "b.name LIKE '%{$arr['search_for']}%'
						OR b.address LIKE '%{$arr['search_for']}%'
						OR b.land_mark LIKE '%{$arr['search_for']}%'
						OR b.tags LIKE '%{$arr['search_for']}%'";

			if (isset($business_category) && $business_category == 1)
			{
				$subcond .= " OR c.cuisine LIKE '%{$arr['search_for']}%'";
			}

			$subcond .= ")";
		}

		if (!$general_search)
		{
			$subcond .= "AND b.business_category = $business_category";
		}
		
		if(isset($arr['avg_review']) && $arr['avg_review'] != '')
			$subcond .= " AND b.avg_review = '{$arr['avg_review']}' ";

		if(isset($arr['vegetarian']) && !empty($arr['vegetarian']))
			$subcond .= " AND b.vegetarian = '{$arr['vegetarian']}' ";
		
		if(isset($arr['air_conditioned']) && !empty($arr['air_conditioned']))
			$subcond .= " AND b.air_conditioned = '{$arr['air_conditioned']}' ";
		
		if(isset($arr['credit_card']) && !empty($arr['credit_card']))
			$subcond .= " AND b.credit_card = '{$arr['credit_card']}' ";
		
		if(isset($arr['take_reservation']) && !empty($arr['take_reservation']))
			$subcond .= " AND b.take_reservation = '{$arr['take_reservation']}' ";
		
		if(isset($arr['parking']) && !empty($arr['parking']))
			$subcond .= " AND b.parking = '{$arr['parking']}' ";
		
		if(isset($arr['business_type_id']) && !empty($arr['business_type_id']))
			$subcond .= " AND b.business_type_id IN ({$arr['business_type_id']}) ";

		if(isset($arr['price_range_id']) && !empty($arr['price_range_id']) &&
				isset($arr['business_category']) && $arr['business_category'] == 1)
			$subcond .= " AND b.price_range_id IN ({$arr['price_range_id']}) ";

		if(isset($arr['cuisine_id']) && !empty($arr['cuisine_id']) &&
				isset($arr['business_category']) && $arr['business_category'] == 1)
			$subcond_ext .= " AND bc.cuisine_id IN ({$arr['cuisine_id']}) ";
		
		if(isset($arr['zipcode']) && !empty($arr['zipcode']))
		{
			$zip_id_list = $this->get_zip_id_range($arr['zipcode']);
			$subcond .= " AND b.zipcode IN ($zip_id_list) ";
		}	

		$sql = "SELECT COUNT(DISTINCT bt.id) tot,c.id,c.cuisine
				FROM {$this->db->dbprefix}cuisine c
				LEFT JOIN {$this->db->dbprefix}business_cuisine bc ON c.id = bc.cuisine_id
				LEFT JOIN  (SELECT b.id FROM {$this->db->dbprefix}business b 
							WHERE 1 ".$subcond."
							AND b.status = '1' ) bt
			    ON bt.id = bc.business_id
				WHERE 1 $subcond_ext
				GROUP BY c.id
				ORDER BY c.cuisine ASC";
				
		$query = $this->db->query($sql);
		$result_arr = $query->result_array();
		$arrHtml = array();

		$inStart = '<div class="list_box"><ul>';
		$inEnd = '</ul></div>';
		$str1 = $str2 = $str3 = '';
		
		foreach($result_arr as $k => $v)
		{
			if(isset($arr['cuisine_id']) && !empty($arr['cuisine_id']) &&
				isset($arr['business_category']) && $arr['business_category'] == 1)
			{
				$arrHtml['type_out'] .= "<li><a style='cursor:pointer;' onclick=\"autoload_ajax_no_jsn('".base_url()."search/search_business_list_ajax', 'div_search_business_list', 'cuisine_id=".$v['id']."');\">{$v['cuisine']} ({$v['tot']})</a><a style='cursor:pointer;' onclick=\"business_search_remove_session('".$v['id']."', 'cuisine_id');\"><img src='".base_url()."images/front/small_close.png'></a></li>";
			}	
			else
			{
				if($k <= 5)
					$arrHtml['type_out'] .= "<li><a style='cursor:pointer;' onclick=\"autoload_ajax_no_jsn('".base_url()."search/search_business_list_ajax', 'div_search_business_list', 'cuisine_id=".$v['id']."');\">{$v['cuisine']} ({$v['tot']})</a></li>";
	
				if($k % 3 == 0)
					$str1 .= "<li><input name='ck_cuisine_list[]' id='ck_cuisine_list{$v['id']}' type='checkbox' value='{$v['id']}' /> {$v['cuisine']} ({$v['tot']})</li>";
				elseif($k % 3 == 1)
					$str2 .= "<li><input name='ck_cuisine_list[]' id='ck_cuisine_list{$v['id']}' type='checkbox' value='{$v['id']}' /> {$v['cuisine']} ({$v['tot']})</li>";
				else
					$str3 .= "<li><input name='ck_cuisine_list[]' id='ck_cuisine_list{$v['id']}' type='checkbox' value='{$v['id']}' /> {$v['cuisine']} ({$v['tot']})</li>";
			}		
		}

		$arrHtml['type_in'] = $inStart.$str1.$inEnd.$inStart.$str2.$inEnd.$inStart.$str3.$inEnd;
		return $arrHtml;
	}
}