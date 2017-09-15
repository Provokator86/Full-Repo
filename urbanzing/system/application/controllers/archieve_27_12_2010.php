<?php
include BASEPATH.'application/controllers/MY_Controller'.EXT;

class archieve extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
       
    }

    function index($order_name = 'cr_date', $page = 0)
	{
		$this->load->model('archieve_model');
		$toshow = $this->admin_page_limit;
		$this->data['title'] = 'Archieve list';
		$this->data['order_name'] = $order_name;
		$totRow = $this->archieve_model->count_table_row('urban_archieve_master');
		$this->data['archieve_list'] = $this->archieve_model->get_archieve_list($page,$toshow,'',$order_name);
		#====  Pagination Starts ==================================
		$this->load->library('pagination');
		$config['base_url'] = base_url()."archieve/index/".$order_name;
		$config['total_rows'] = $totRow;
		$config['per_page'] = $toshow;
		$config['uri_segment']=4;
		$this->pagination->initialize($config);
		$this->data['pagination_link'] = $this->pagination->create_links();
		#====  Pagination End ==================================
		$this->set_include_files(array('archieve/archieve_front'));
        $this->render();
		
	}
		
	
	
	
	
	
	function show( $archieve_id = 1, $url = '')
    {
		$this->data['title'] = 'Kolkata Restaurants, Beauty Parlours, Cinema Halls, Gyms, Boutiques';
		$this->data['meta_keywords'] = 'business listing, business directory, business list, List of Kolkata Business, List of Kolkata Businesses, Urbanzing, kolkata entertainment, Kolkata business reviews, kolkata restaurant reviews, kolkata reviews, kolkata food, Kolkata attractions';
		$this->data['meta_desc'] = "Kolkata Restaurants, Beauty Parlours, Cinema Halls, Gyms, Boutiques";

		$this->data['meta_google_site_verification'] = '7msVX7sqskfU1tZ-qLu55YRc-eudvtenU2Aa5Ste2_I';
		$this->data['meta_y_key'] = '0ee98af10717da1b';
		$this->menu_id = 1;
		$this->load->model('archieve_model');
		
		$arr = array('id'=>$archieve_id);
		$this->data['home_page_text']	=	$this->archieve_model->get_archieve_list( 0, -1, $arr);
		
		
		
		$this->data['img_list'] = $this->archieve_model->get_archieve_image_list('urban_archieve_picture', $arr = array('archieve_id'=>$archieve_id));
		$this->data['featured_business'] = $this->archieve_model->get_archieve_image_list('urban_archieve_business',$arr = array('archieve_id'=>$archieve_id));
		
		$this->add_js('stepcarousel');
		
		
		$this->set_include_files(array('home/archieve_home'));
		$this->render();
    }

   
}
