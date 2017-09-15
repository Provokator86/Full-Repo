<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends Controller
{
	protected $data = array();
	protected $controller_name;
	protected $action_name;
    protected $ses_user = array('loggedin'=>'', 'user_id'=>'', 'user_role'=>'', 'email'=>'', 'user_name'=>'');
    public $include_files = array();
    public $message_type;
    public $message;
    public $menu_id = 17;
    public $admin_page_limit = 10;
    protected $js_files = array();
    public $upload_path = '';
    public $root_category = array();


	public function __construct()
	{
		parent::__construct();
		$this->load->model('automail_base_model');
		$this->load->model('site_settings_model');
		$this->load->model('my_model');
		$this->load_defaults();

		$this->add_css(array('style', 'jquery.tabs', 'jquery.tabs-ie', 'thickbox'));
		$this->add_js(array('jquery-latest', 'jquery.history_remote.pack', 'jquery.tabs.pack', 'thickbox', 'jquery.form'));
		$this->load->helper('include_helper');

		include BASEPATH.'application/libraries/facebook/facebook'.EXT;
		$this->data['api_key'] = $this->config->item('facebook_app_key');//"e68489a7474ba20f8c2f7df67aa6fe55";
		$this->data['secret_key'] = $this->config->item('facebook_secret_key');//"8768419b30ef9b17b2412370b6f2bc9c";

		$fb = new Facebook( $this->data['api_key'], $this->data['secret_key'] );
		$fb_user = $fb->get_loggedin_user();
		if(!$fb_user)
		{
			$this->data['button'] = '<fb:login-button v="2" onlogin="facebook_onlogin();" length="long"><fb:intl>Signup with Facebook</fb:intl></fb:login-button><br/>';
		}
		$this->data['fb_post_object'] = $fb;
		$this->data['fb_post_user'] = $fb_user;
		
	}

	protected function load_defaults()
    {
		$this->data['heading'] = 'Page Heading';
		$this->data['content'] = '';
		$this->data['css'] = '';
		$this->data['js'] = '';
		$this->data['php'] = '';
		
		$this->data['title'] = 'Kolkata Restaurants, Beauty Parlours, Cinema Halls, Gyms, Boutiques';
		$this->data['meta_keywords'] = '';
		$this->data['meta_desc'] = 'UrbanZing.com, find information and reviews on Kolkata restaurants, clubs, bars, lounges, pubs, beauty parlours, gyms, shopping centers, boutiques, malls, jewellery etc.';
		
		$this->data['meta_revisit_after'] = '1';
		$this->data['meta_robots'] = 'all';
		$this->data['meta_language'] = 'en';
		$this->data['meta_expires'] = 'Never';
		$this->data['meta_google_site_verification'] = '';
		$this->data['meta_y_key'] = '';

		if($this->session->userdata('message'))
		{
			$this->message = $this->session->userdata('message');
			$this->session->unset_userdata(array('message' => ''));
		}

		if($this->session->userdata('message_type'))
		{
			$this->message_type = $this->session->userdata('message_type');
			$this->session->unset_userdata(array('message_type' => ''));
		}
		
		$this->controller_name = $this->router->fetch_directory() . $this->router->fetch_class();
		$this->action_name = $this->router->fetch_method();

		$pageLmt = $this->site_settings_model->get_site_settings('admin_page_limit');
		if($pageLmt && is_numeric($pageLmt) && $pageLmt > 0)
			$this->admin_page_limit = $pageLmt;
		
		$this->get_root_category();
    }

	function get_root_category()
	{
		$rows = $this->my_model->get_query_result("SELECT * FROM {$this->db->dbprefix}business_type WHERE parent_id = '0'");
		foreach($rows as $k => $v)
		{
			$this->root_category[$v['id']] = $v['name'];
		}

		$this->root_category[0] = 'All Categories';
		ksort($this->root_category);

		// Adds a Variable to the Global "$data" array for flexible use of this in the Template files
		$this->data['list_root_categories'] = $this->root_category;
	}

	protected function set_include_files($files = array())
	{
		$this->include_files = $files;
	}

	protected function render($template = 'main')
	{
		$view_path = $this->controller_name . '/' . $this->action_name . '.tpl.php';
		if (file_exists(APPPATH . 'views/' . $view_path))
			$this->data['content'] .= $this->load->view($view_path, $this->data, true);
		$this->load->view("$template.tpl.php", $this->data);
	}

	protected function add_css($filename)
	{
		$this->data['css'] .= $this->load->view("admin/common/css.tpl.php", array('filename' => $filename), true);
	}

	protected function add_php($filename)
	{
		$this->data['php'] .= $this->load->view("admin/common/php.tpl.php", array('filename' => $filename), true);
	}

	protected function add_js($filename)
	{
		$this->data['js'] .= $this->load->view("admin/common/js.tpl.php", array('filename' => $filename), true);
	}

	protected function check_user_page_access($access_role = 'registered')
	{
		if( (!$this->session->userdata('user_id') && $access_role == 'registered'))
		{
			header('location:'.base_url().'home/login');
			exit;
		}
		elseif( ($this->session->userdata('user_id') && $access_role == 'non_registered'))
		{
			header('location:'.base_url());
			exit;
		}
	}

	protected function get_session_data($key, $tmpArr = array())
	{
		$arr = $this->session->userdata('model_session');
		
		if(isset($arr[$key]))
			return $arr[$key];
		elseif(isset($tmpArr[$key]))
			return $tmpArr[$key];
		else
			return '';
	}

	protected function get_redirect_url()
	{
		$url = $this->session->userdata('redirect_url');

		if(!$url || empty($url))
			$url = $this->get_session_data('redirect_url');

		if(!$url || empty($url))
			$url = base_url().$this->controller_name = $this->router->fetch_directory() . $this->router->fetch_class();
		
		return $url;
	}

	function clear_business_search()
	{
		$this->session->set_userdata(array(
			'order_by'=>'',
			'business_type'=>'',
			'business_type_text'=>'',
			'price_range'=>'',
			'price_range_text'=>'',
			'avg_review'=>'',
			'zipcode'=>'',
			'vegetarian'=>'',
			'air_conditioned'=>'',
			'credit_card'=>'',
			'take_reservation'=>'',
			'parking'=>'',
			'search_for'=>'',
			'search_in'=>'',
			'cuisine_id'=>''
		));
	}
}
?>