<?php
include BASEPATH.'application/controllers/MY_Controller'.EXT;

class search extends MY_Controller
{
	function __construct()
    {
        parent::__construct();
    }

    function index($category = 1)
    {
		if($category == 1)
			header("location:".base_url().'search/restaurants');
		elseif($category == 2)
			header("location:".base_url().'search/health');
		elseif($category == 3)
			header("location:".base_url().'search/fun');
		elseif($category == 4)
			header("location:".base_url().'search/shopping');
		else
			header("location:".base_url().'search/general_search');
		
		exit;
    }

    function health()
    {
		$this->business_type_data(2);
    }
    
    function fun()
    {
		$this->business_type_data(3);
    }
    
    function shopping()
    {
		$this->business_type_data(4);
    }
    
    function restaurants()
    {
		
		$this->business_type_data(1);
    }

    function general_search()
    {
		
		$this->business_type_data(0);
    }

	/**
	 * Function to set the Basic Part & the Left Panel of Search
	 *
	 * @param int $this_cat_id
	 */
    function business_type_data($this_cat_id)
    {
		// added by iman . checking required for changing the caegory
		if($this->session->userdata('business_category')!=$this_cat_id)
			$this->clear_business_search();	
	    ////
		$this->load->model('business_search_model');
		$this->data['search_category'] = $this_cat_id;
		$this->menu_id = $this_cat_id + 1;
		$this->data['general_search_factor'] = FALSE;
		$arr = array();
		
		switch($this_cat_id)
		{
			case 1: // Restaurants, Food & Nightlife
				$this->data['title'] = 'Kolkata Restaurants, Bars, Clubs';
				$this->data['meta_keywords'] = 'Kolkata Chinese Restaurant, Kolkata Indian Restaurant, Kolkata Continental Restaurant, Kolkata Mughlai Restaurant, Kolkata Bengali Restaurant, Kolkata Tandoori Restaurant, Kolkata South Indian Restaurant, Kolkata Noth Indian Restaurant, Kolkata Punjabi Restaurant, Kolkata Thai Restaurant, Kolkata Mexican Restaurant, Kolkata Italian Restaurant, Kolkata Pakistani Restaurant, Kolkata Momo Restaurant, Kolkata Tibetian Restaurant, Kolkata Pizza Restaurant, Kolkata Restaurants, Kolkata Clubs, Kolkata Bars, Kolkata Sweets, Kolkata Snacks, Kolkata Caterers, Kolkata Fast food, Kolkata cafes, Kolkata bakeries, Kolkata Ice cream';
				$this->data['meta_desc'] = 'Kolkata Restaurants, Bars, Clubs';
				break;
			
			case 2: // Health & Beauty
				$this->data['title'] = 'Kolkata Beauty Parlours, Yoga Studios, Gyms, Health Clubs';
				$this->data['meta_keywords'] = 'Kolkata Salons, Kolkata Salon, Kolkata Yoga, Kolkata Yoga Studio, Kolkata Pilate, Kolkata Pilate Studio, Kolkata gym, Kolkata gyms, Kolkata fitness center, Kolkata health center, Kolkata health club, Kolkata swimming, Kolkata salsa, Kolkata aerobics, Kolkata treadmill, Kolkata beauty parlours, Kolkata beauty parlour, Kolkata spas, Kolkata spa, Kolkata haircut, Kolkata manicure, Kolkata pedicure, Kolkata waxing';
				$this->data['meta_desc'] = 'Kolkata Beauty Parlours, Yoga Studios, Gyms, Health Clubs';
				break;
			
			case 3: // Fun & Entertainment
				$this->data['title'] = 'Kolkata Cinema Halls, Bowling alleys, Theme parks';
				$this->data['meta_keywords'] = 'Kolkata Movie, movies, kolkata cinema, Kolkata cinema hall, Kolkata cinema halls, Kolkata bowling alleys, bowling alley, Kolkata video game parlour, Kolkata theme park, Kolkata theme parks, Kolkata water park, Kolkata water parks, Kolkata rides';
				$this->data['meta_desc'] = 'Kolkata Cinema Halls, Bowling alleys, Theme parks';
				break;
			
			case 4: // Shopping Club
				$this->data['title'] = 'Kolkata Shopping Centers, Malls, Boutiques';
				$this->data['meta_keywords'] = 'Kolkata Boutiques, Kolkata shopping, Kolkata shopping mall, Kolkata shopping malls, Kolkata shopping center, Kolkata shopping centers, Kolkata Garment, Kolkata Garments, Kolkata Garment Shop, Kolkata garment shops, Kolkata toy, Kolkata toy shops, Kolkata jewellery, Kolkata jewelry, Kolkata jewellery Shop, Kolkata jewelry Shop, Kolkata Saree Shops, Kolkata shoe shop';
				$this->data['meta_desc'] = 'Kolkata Shopping Centers, Malls, Boutiques';
				break;
			
			default:
				$this->data['title'] = 'Search UrbanZing';
				$this->data['meta_keywords'] = 'Kolkata';
				$this->data['meta_desc'] = 'Search UrbanZing';
				$this->data['general_search_factor'] = TRUE;
		}

		if ($this->data['general_search_factor'] || ($this->session->userdata('search_for') != '' && !empty($this_cat_id)))
		{
			$this->data['search_for'] = $arr['search_for'] = $this->session->userdata('search_for');
			
		}
		$arr = $this->generate_query_arr();
		$arr['business_category'] = $this_cat_id;
		
		$this->data['search_session_value'] = $arr;
		//var_dump($arr);//exit;
		$this->data['category_name'] = $this->root_category[$this_cat_id];
		$this->data['business_menu'] = $this->business_search_model->get_business_menu_count($this_cat_id, $arr, $this->data['general_search_factor']);

		$this->data['business_type'] = $this->business_search_model->get_business_type_list($this_cat_id, $arr, $this->data['general_search_factor']);
		$this->data['price_range'] = $this->business_search_model->get_price_range_list($this_cat_id, $arr, $this->data['general_search_factor']);
		$this->data['cuisine_list'] = $this->business_search_model->get_cuisine_list($this_cat_id, $arr, $this->data['general_search_factor']);
		$this->data['avg_review'] = $this->business_search_model->get_avg_review_list($this_cat_id, $arr, $this->data['general_search_factor']);
		$this->data['business_location'] = $this->business_search_model->get_area_list($this_cat_id, $arr, $this->data['general_search_factor']);
		$this->data['business_category'] = $this_cat_id;

		$this->session->set_userdata(array('business_category' => $this_cat_id));
		$this->add_js(array('ajax_helper', 'common_js', 'jquery.lightbox-0.5', 'tooltip'));
		$this->add_css(array('jquery.lightbox-0.5'));

		$this->set_include_files(array('search/restaurants'));
		$this->render();
    }

    function clear_search()
    {
		$business_category = $this->session->userdata('business_category');
		$this->clear_business_search();
		header("Location: ".base_url().'search/index/'.$business_category);
		exit();
    }

    function search_post()
    {
		$serch_category = $this->input->post('search_category');

		if($serch_category == 1)
			$redirect_url = 'restaurants';
		elseif($serch_category == 2)
			$redirect_url = 'health';
		elseif($serch_category == 3)
			$redirect_url = 'fun';
		elseif($serch_category == 4)
			$redirect_url = 'shopping';
		else
			$redirect_url = 'general_search';

		//if($this->session->userdata('business_category') != $serch_category)
			$this->clear_business_search();
			 $this->session->set_userdata(array('business_category'=>$serch_category));
		$this->session->set_userdata(array(
			'search_for' => htmlspecialchars($this->input->post('search_for'), ENT_QUOTES, 'utf-8'),
			'search_in' => $this->input->post('search_in'),
			'search_category' => $this->input->post('search_category')
		));
		
		header("Location: ".base_url().'search/'.$redirect_url);
		exit();
	}

    function search_business_list_ajax()
    {
		$data = $this->get_data_prepier();
		//var_dump($data);
		$this->load->model('business_search_model');
		$data['business_category'] = $this->session->userdata('business_category');
		$page = $data['page'];

		$data['general_search_factor'] = FALSE;
		if (empty($data['business_category']))
			$data['general_search_factor'] = TRUE;
		
		$arr = array();
		$arr['business_category'] = $data['business_category'];
		$arr['business_type_id'] = $data['business_type'];
		$arr['price_range_id'] = $data['price_range'];
		$arr['avg_review'] = $data['avg_review'];
		$arr['zipcode'] = $data['zipcode'];
		$arr['cuisine_id'] = $data['cuisine_id'];
		$arr['vegetarian'] = $data['vegetarian'];
		$arr['air_conditioned'] = $data['air_conditioned'];
		$arr['credit_card'] = $data['credit_card'];
		$arr['take_reservation'] = $data['take_reservation'];
		$arr['parking'] = $data['parking'];
		$arr['alcohol'] = $data['alcohol'];
		$arr['menu'] = $data['menu'];
		$arr['search_for'] = $data['search_for'];
		$arr['search_in'] = $data['search_in'];
		$arr['status'] = 1;
		$arr['general_search_factor'] = $data['general_search_factor'];

		$data['rows'] = $this->business_search_model->get_search_business($data['toshow'], $page, $arr, $data['order_by']);
		$data['jsnArr'] = json_encode(array('page' => $page));

		$this->load->model('cuisine_model');
		$cuisine_name = '';
		if (!empty($data['cuisine_id'])) {
			$cuisine_name = $this->cuisine_model->get_cuisine_list(array('id' => $data['cuisine_id']));
			$cuisine_name = $cuisine_name[0]['cuisine'];
		}

		$data['result_text'] = $this->get_result_text(
			$data['avg_review'],
			$data['business_type_text'],
			$data['business_category'],
			$data['zipcode'],
			$cuisine_name,
			$data['vegetarian'],
			$data['price_range_text'],
			$data['air_conditioned'],
			$data['credit_card'],
			$data['take_reservation'],
			$data['parking'],
			$data['alcohol'],
			$data['menu'],
			$data['search_for']
		);
		
		$this->session->set_userdata(array(
			'order_by' => $data['order_by'],
			'business_type' => $data['business_type'],
			'business_type_text' => $data['business_type_text'],
			'price_range' => $data['price_range'],
			'price_range_text' => $data['price_range_text'],
			'avg_review' => $data['avg_review'],
			'zipcode' => $data['zipcode'],
			'cuisine_id' => $data['cuisine_id'],
			'vegetarian' => $data['vegetarian'],
			'air_conditioned' => $data['air_conditioned'],
			'credit_card' => $data['credit_card'],
			'take_reservation' => $data['take_reservation'],
			'parking' => $data['parking'],
			'alcohol' => $data['alcohol'],
			'menu' => $data['menu'],
			'search_page_no' => $data['page'],
			'search_for' => $data['search_for'],
			'search_in' => $data['search_in']
		));

		$this->load->view('search/restaurants_list.tpl.php', $data);
    }

	function search_submit_ck()
	{
		$ck_business_type = $this->input->post('ck_business_type');
		$ck_price_range = $this->input->post('ck_price_range');
		$ck_area_list = $this->input->post('ck_area_list');
		$ck_cuisine_list = $this->input->post('ck_cuisine_list');

		if(isset ($ck_business_type) && is_array($ck_business_type))
			$this->session->set_userdata(array('business_type' => implode(',', $ck_business_type)));
		if(isset ($ck_price_range) && is_array($ck_price_range))
			$this->session->set_userdata(array('price_range' => implode(',', $ck_price_range)));
		if(isset ($ck_area_list) && is_array($ck_area_list))
			$this->session->set_userdata(array('zipcode' => implode(',', $ck_area_list)));
		if(isset ($ck_cuisine_list) && is_array($ck_cuisine_list))
			$this->session->set_userdata(array('cuisine_id' => implode(',', $ck_cuisine_list)));
			
		$this->remove_search_page_no(); // remove the sssion page no
		$this->search_business_list_ajax();
	}

	/**
	 * The parameter "$general_search" will act as the "Search For" text, if General Search is being used,
	 * otherwise it will be FALSE
	 */
	function get_result_text($star = '',
			$business_type = '',
			$business_category = 1,
			$region = '',
			$cuisine = '',
			$veg = '',
			$price = '',
			$air_conditioned = '',
			$credit_card = '',
			$take_reservation = '',
			$parking = '',
			$alcohol ='',
			$menu  = '',
			$general_search = FALSE
	)
	{
		if (!empty($general_search))
			$txt = 'Search for &ldquo;'.$general_search.'&rdquo;, ';
		else if (!empty($business_category))
			$txt = $this->root_category[$business_category].', ';

		if(!empty($business_type))
			$txt .= $business_type.', ';
	
		if($star != '')
			$txt .= $star.'-Star, ';

		if($region != '')
			$txt .= 'in '.$region.', ';

		if(!empty($cuisine))
			$txt .= $cuisine.', ';

		if($veg == 1)
			$txt .= 'Veg Served, ';
		elseif($veg.'a' == '0a')
			$txt .= 'Non-veg Served, ';

		if($air_conditioned == 1)
			$txt .= 'Air Conditioned, ';
		elseif($air_conditioned.'a' == '0a')
			$txt .= 'Do not have AC, ';

		if($credit_card == 1)
			$txt .= 'Credit card accepted, ';
		elseif($credit_card.'a' == '0a')
			$txt .= 'Do not accept credit card, ';
	
		if($take_reservation == 1)
			$txt .= 'Takes Reservations, ';
		elseif($take_reservation.'a' == '0a')
			$txt .= 'Do not accept reservation, ';

		if($parking == 1)
			$txt .= 'Parking Available, ';
		elseif($parking.'a' == '0a')
			$txt .= 'Has no parking, ';
			
		if($alcohol == 1)
			$txt .= 'Alcohol Served, ';
		elseif($alcohol.'a' == '0a')
			$txt .= 'Alcohol not served, ';	
			
		if($menu == 1)
			$txt .= 'Places w/ Menu , ';
		elseif($menu.'a' == '0a')
			$txt .= 'Menu not provided, ';	
	
		if($price != '')
			$txt .= 'Price range: '.$price.', ';
		
		$txt = substr($txt, 0, -2);
		return $txt;
	}

	function get_data_prepier()
	{
		$data = array();
		//$page = ($this->input->post('page')) ? $this->input->post('page') :$this->session->userdata('search_page_no');
		//  changed by Purnendu 11.01.2011 , as when posted value is 0 from ajax then also we should take that value
		//  so checking is done by != ''
		$page = ($this->input->post('page') != '') ? $this->input->post('page') :$this->session->userdata('search_page_no');
		$page = ($page) ? $page : 0;
		$data['page'] = $page;
		$data['toshow'] = $this->admin_page_limit;

		$data['order_by'] = $this->input->post('order_by');
		$data['order_by'] = (isset($data['order_by']) && $data['order_by'] != '') ? $data['order_by'] : $this->session->userdata('order_by');
		$data['order_by'] = (isset($data['order_by']) && $data['order_by'] != '') ? $data['order_by'] : 'b.name';

		$data['business_type'] = $this->input->post('business_type');
		$data['business_type'] = (isset($data['business_type']) && $data['business_type'] != '') ? $data['business_type'] : $this->session->userdata('business_type');
		$data['business_type'] = (isset($data['business_type']) && $data['business_type'] != '') ? $data['business_type'] : '';

		$data['business_type_text'] = $this->input->post('business_type_text');
		$data['business_type_text'] = (isset($data['business_type_text']) && $data['business_type_text'] != '') ? $data['business_type_text'] : $this->session->userdata('business_type_text');
		$data['business_type_text'] = (isset($data['business_type_text']) && $data['business_type_text'] != '') ? $data['business_type_text'] : '';

		$data['price_range'] = $this->input->post('price_range');
		$data['price_range'] = (isset($data['price_range']) && $data['price_range'] != '') ? $data['price_range'] : $this->session->userdata('price_range');
		$data['price_range'] = (isset($data['price_range']) && $data['price_range'] != '') ? $data['price_range'] : '';

		$data['price_range_text'] = $this->input->post('price_range_text');
		$data['price_range_text'] = (isset($data['price_range_text']) && $data['price_range_text'] != '') ? $data['price_range_text'] : $this->session->userdata('price_range_text');
		$data['price_range_text'] = (isset($data['price_range_text']) && $data['price_range_text'] != '') ? $data['price_range_text'] : '';

		$data['avg_review'] = $this->input->post('avg_review');
		$data['avg_review'] = (isset($data['avg_review']) && $data['avg_review'] != '') ? $data['avg_review'] : $this->session->userdata('avg_review');
		$data['avg_review'] = (isset($data['avg_review']) && $data['avg_review'] != '') ? $data['avg_review'] : '';

		$data['zipcode'] = $this->input->post('zipcode');
		$data['zipcode'] = (isset($data['zipcode']) && $data['zipcode'] != '') ? $data['zipcode'] : $this->session->userdata('zipcode');
		$data['zipcode'] = (isset($data['zipcode']) && $data['zipcode'] != '') ? $data['zipcode'] : '';

		$data['cuisine_id'] = $this->input->post('cuisine_id');
		$data['cuisine_id'] = (isset($data['cuisine_id']) && $data['cuisine_id'] != '') ? $data['cuisine_id'] : $this->session->userdata('cuisine_id');
		$data['cuisine_id'] = (isset($data['cuisine_id']) && $data['cuisine_id'] != '') ? $data['cuisine_id'] : '';

		$data['vegetarian'] = $this->input->post('vegetarian');
		$data['vegetarian'] = (isset($data['vegetarian']) && $data['vegetarian'] != '') ? $data['vegetarian'] : $this->session->userdata('vegetarian');
		$data['vegetarian'] = (isset($data['vegetarian']) && $data['vegetarian'] != '') ? $data['vegetarian'] : '';

		$data['air_conditioned'] = $this->input->post('air_conditioned');
		$data['air_conditioned'] = (isset($data['air_conditioned']) && $data['air_conditioned'] != '') ? $data['air_conditioned'] : $this->session->userdata('air_conditioned');
		$data['air_conditioned'] = (isset($data['air_conditioned']) && $data['air_conditioned'] != '') ? $data['air_conditioned'] : '';

		$data['credit_card'] = $this->input->post('credit_card');
		$data['credit_card'] = (isset($data['credit_card']) && $data['credit_card'] != '') ? $data['credit_card'] : $this->session->userdata('credit_card');
		$data['credit_card'] = (isset($data['credit_card']) && $data['credit_card'] != '') ? $data['credit_card'] : '';

		$data['take_reservation'] = $this->input->post('take_reservation');
		$data['take_reservation'] = (isset($data['take_reservation']) && $data['take_reservation'] != '') ? $data['take_reservation'] : $this->session->userdata('take_reservation');
		$data['take_reservation'] = (isset($data['take_reservation']) && $data['take_reservation'] != '') ? $data['take_reservation'] : '';
		$data['parking'] = $this->input->post('parking');
		$data['parking'] = (isset($data['parking']) && $data['parking'] != '') ? $data['parking'] : $this->session->userdata('parking');
		$data['parking'] = (isset($data['parking']) && $data['parking'] != '') ? $data['parking'] : '';
		//echo $this->input->post('parking').'======'.$this->session->userdata('parking');
		$data['alcohol'] = $this->input->post('alcohol');
		$data['alcohol'] = (isset($data['alcohol']) && $data['alcohol'] != '') ? $data['alcohol'] : $this->session->userdata('alcohol');
		$data['alcohol'] = (isset($data['alcohol']) && $data['alcohol'] != '') ? $data['alcohol'] : '';
		
		$data['menu'] = $this->input->post('menu');
		$data['menu'] = (isset($data['menu']) && $data['menu'] != '') ? $data['menu'] : $this->session->userdata('menu');
		$data['menu'] = (isset($data['menu']) && $data['menu'] != '') ? $data['menu'] : '-1';


		$data['search_for'] = htmlspecialchars($this->input->post('search_for'), ENT_QUOTES, 'utf-8');
		$data['search_for'] = (isset($data['search_for']) && $data['search_for'] != '') ? $data['search_for'] : $this->session->userdata('search_for');
		$data['search_for'] = (isset($data['search_for']) && $data['search_for'] != '') ? $data['search_for'] : '';

		$data['search_in'] = $this->input->post('search_in');
		$data['search_in'] = (isset($data['search_in']) && $data['search_in'] != '') ? $data['search_in'] : $this->session->userdata('search_in');
		$data['search_in'] = (isset($data['search_in']) && $data['search_in'] != '') ? $data['search_in'] : '';

		$data['search_category'] = $this->input->post('search_category');
		$data['search_category'] = (isset($data['search_category']) && $data['search_category'] != '') ? $data['search_category'] : $this->session->userdata('search_category');
		$data['search_category'] = (isset($data['search_category']) && $data['search_category'] != '') ? $data['search_category'] : '';
		//echo $data['alcohol'];
		return $data;
	}
	
	function generate_query_arr()
	{
		$data = $this->get_data_prepier();
		$arr = array();
		$arr['business_category'] = $data['business_category'];
		$arr['business_type_id'] = $data['business_type'];
		$arr['price_range_id'] = $data['price_range'];
		$arr['avg_review'] = $data['avg_review'];
		$arr['zipcode'] = $data['zipcode'];
		$arr['cuisine_id'] = $data['cuisine_id'];
		$arr['vegetarian'] = $data['vegetarian'];
		$arr['air_conditioned'] = $data['air_conditioned'];
		$arr['credit_card'] = $data['credit_card'];
		$arr['take_reservation'] = $data['take_reservation'];
		$arr['parking'] = $data['parking'];
		$arr['alcohol'] = $data['alcohol'];
		$arr['menu'] = $data['menu'];
		$arr['search_for'] = $data['search_for'];
		$arr['search_in'] = $data['search_in'];
		$arr['status'] = 1;
		$arr['general_search_factor'] = $data['general_search_factor'];
		
		return $arr;
	}
	
	
function business_search_remove_session()
 {
  $id = strtolower($this->input->post('id'));
  $type = $this->input->post('type');
  $data = $this->get_data_prepier();
  
  if((isset($id) && $id=='') || (isset($type) && $type==''))
   return false;
  $tempArr = explode(",",$data[$type]);
  //var_dump($tempArr);
  foreach($tempArr as $key=>$value)
  {
   $value = strtolower($value);
   if($value==$id)
    unset($tempArr[$key]); 
  }
  //echo $id.'====='.$type;
  $this->session->set_userdata(array($type => implode(',', $tempArr)));
  if($type=='price_range')
   $this->session->set_userdata(array('price_range_text' => ''));
  if($type=='business_type')
   $this->session->set_userdata(array('business_type_text' => '')); 
  echo 1;
 }	
	function auto_complete_business_name($business_type_id=0)
	{
		$this->load->model('business_model');
		$letter = $this->input->post('queryString');
		$arr = array('business_category'=>(int)$business_type_id,'name_back_wildcard'=>$letter);
		$location = $this->business_model->get_auto_complete_business_list($arr, -1, 0, 'name', 'ASC');
		if($location)
		{
			foreach($location as $value)
			{
				echo '<li onclick="business_fill(\''. htmlspecialchars( $value['name']).'\');">'.$value['name'].'</li>';
			}	
	    }		
	}
	
	function remove_search_page_no()
	{
		$this->session->set_userdata(array('search_page_no'=>''));
		echo 1;
	}
	
}