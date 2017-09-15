<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
For MLM
*/
class MY_Controller extends Controller
{
    protected $data = array();
    protected $controller_name;
    protected $action_name;
    public $include_files=array();
    public $message_type;
    public $message;
    public $menu_id='';
    public $admin_page_limit=10;
    protected $js_files    = array();

    public function __construct()
    {
        parent::__construct();
		$this->load->model('my_model');
        $this->load->model('automail_base_model');
        $this->load->model('site_settings_model');
		$this->load_defaults();
        $this->add_css('admin-styles');
        $this->add_js(array('jquery-latest'));
        $this->load->helper('include_helper');
        $this->get_redirect_url();
    }

    protected function load_defaults()
    {
        $this->data['heading'] = 'Page Heading';
	$this->data['content'] = '';
	$this->data['css'] = '';
	$this->data['js'] = '';
	$this->data['php'] = '';
	$this->data['title'] = 'Page Title';
        if($this->session->userdata('message'))
        {
            $this->message  = $this->session->userdata('message');
            $this->session->unset_userdata(array('message'=>''));
        }
        if($this->session->userdata('message_type'))
        {
            $this->message_type  = $this->session->userdata('message_type');
            $this->session->unset_userdata(array('message_type'=>''));
        }
	$this->controller_name = $this->router->fetch_directory() . $this->router->fetch_class();
	$this->action_name = $this->router->fetch_method();
        $pageLmt    =$this->site_settings_model->get_site_settings('admin_page_limit');
        if($pageLmt && is_numeric($pageLmt) && $pageLmt>0)
            $this->admin_page_limit =   $pageLmt;
    }

    protected function set_include_files($files=array())
    {
        $this->include_files    = $files;
    }

    protected function render($template='main')
    {
        $view_path = $this->controller_name . '/' . $this->action_name . '.tpl.php';
	if (file_exists(APPPATH . 'views/' . $view_path))
            $this->data['content'] .= $this->load->view($view_path, $this->data, true);
	$this->load->view("admin/$template.tpl.php", $this->data);
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

    protected function check_user_page_access($access_role='registered')
    {
        if( $this->session->userdata('user_type_id')!=true && $access_role=='registered')
        {
            header('location:'.base_url().'admin');
            exit;
        }
        elseif ($this->session->userdata('user_type_id')==true && $access_role=='non_registered')
        {
            header('location:'.base_url().'admin/home/display');
            exit;
        }
    }

    protected function get_session_data($key,$tmpArr=array())
    {
        $arr    = $this->session->userdata('model_session');
        if(isset($arr[$key]))
            return $arr[$key];
        elseif(isset($tmpArr[$key]))
            return $tmpArr[$key];
        else
            return '';
    }
    
    protected function get_redirect_url()
    {
    	$url	= $this->get_session_data('redirect_url');
    	if(!$url || $url=='')
    		$url	= base_url().$this->controller_name = $this->router->fetch_directory() . $this->router->fetch_class();
    	return $url;
    }
}
?>