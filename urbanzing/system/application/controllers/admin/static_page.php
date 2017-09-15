<?php
//for MLM
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class static_page extends MY_Controller
{
    public $static_id = 0;
	
	function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->check_user_page_access('registered');
	    $this->data['title'] = 'Add Static Page';
        $this->data['table_title'] = 'Add static page';
        //$this->data['article_category_option'] = makeOption($this->article_model->article_category);
		
		
		#====================   CI Form Validation:: [Starts] ===================================
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			$this->form_validation->set_rules('page_title', 'Page title field', 'trim|required|xss_clean');
			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
			$this->form_validation->set_rules('url', 'Url', 'callback_url_check');
			$this->form_validation->set_rules('meta_keywords', 'Meta Key Word', 'trim|required|xss_clean');
			$this->form_validation->set_rules('meta_description', 'Meta Descriptions', 'trim|required|xss_clean');
			$this->form_validation->set_rules('page_content', 'Page Content', 'trim|required|xss_clean');	
		#====================   CI Form Validation:: [End] ===================================
		if ($this->form_validation->run() == FALSE)
		{
			$this->add_js(array('tinymce/jscripts/tiny_mce/tiny_mce','tinymce_load','fromvalidation'));
			$this->set_include_files(array('common/admin_menu','static/static_page'));
			$this->render();
		}
		else
		{
			$arr = array('page_title'=>htmlspecialchars($this->input->post('page_title'), ENT_QUOTES, 'utf-8'),
						'title'=>htmlspecialchars($this->input->post('title'), ENT_QUOTES, 'utf-8'),
						'url'=>htmlspecialchars($this->input->post('url'), ENT_QUOTES, 'utf-8'),
						'meta_keywords'=>htmlspecialchars($this->input->post('meta_keywords'), ENT_QUOTES, 'utf-8'),
						'meta_description'=>htmlspecialchars($this->input->post('meta_description'), ENT_QUOTES, 'utf-8'),
						'page_content'=>htmlentities($this->input->post('page_content'), ENT_QUOTES, 'utf-8')
						);	
			$this->load->model('my_model');
			$this->my_model->set_data_insert('static_page', $arr);	
			$this->session->set_userdata(array('message'=>"Inserted Successfully",'message_type'=>'succ'));
            header("location:".base_url().'admin/static_page/static_page_list');
            exit;		
			
		
		}	
	}
	
	
	function url_check($url)
	{
		
		$page_id = $this->static_id;
		if ($url == '')
		{
			$this->form_validation->set_message('url_check', 'Please Enter url');
			return FALSE;
		}
		elseif(!preg_match("/^[a-z0-9_-]+$/",$url))
		{
			$this->form_validation->set_message('url_check', 'No special characters or capital letters allowed');
			return FALSE;
		}
		else 
		{
			
			$this->load->model('static_page_model');
			$result = $this->static_page_model->get_static_page_details(0,-1,$url, $arr = array(), $page_id);
			if(!empty($result))
			{
				$this->form_validation->set_message('url_check', 'url already exists.');
				return FALSE;
			
			}
			else
			return TRUE;
		}

	}
	
	
	function static_page_list($page = 0)
	{
		$this->check_user_page_access('registered');
		$this->data['title'] = 'Static page list';
		$toshow =  $this->admin_page_limit;
		$this->load->model('static_page_model');
		$this->data['static_page_list'] = $this->static_page_model->get_static_page_details($page, $toshow,'');
		$totRow  = $this->static_page_model->count_get_static_page_details();
		$this->session->set_userdata(array('page_no'=>$page));
		#====  Pagination Starts =======================================================
		$this->load->library('pagination');
		$config['base_url'] = base_url()."admin/static_page/static_page_list";
		$config['total_rows'] = $totRow;
		$config['per_page'] =  $toshow;
		$config['uri_segment']=4;
		$this->pagination->initialize($config);
		$this->data['pagination_link'] = $this->pagination->create_links();
		#====  Pagination End ===========================================================
		$this->set_include_files(array('common/admin_menu','static/static_page_list'));
		$this->render();
	}
	
	function edit_static_page( $id = 0)
	{
		
		$this->check_user_page_access('registered');
		$this->static_id = $id;
		$this->data['id'] = $id;
		$arr = array('id'=>$id);
		$this->load->model('static_page_model');
		if($this->input->post('chk_submit'))
		{
			$this->data['result'] = array('page_title'=>htmlspecialchars($this->input->post('page_title'), ENT_QUOTES, 'utf-8'),
								'title'=>htmlspecialchars($this->input->post('title'), ENT_QUOTES, 'utf-8'),
								'url'=>htmlspecialchars($this->input->post('url'), ENT_QUOTES, 'utf-8'),
								'meta_keywords'=>htmlspecialchars($this->input->post('meta_keywords'), ENT_QUOTES, 'utf-8'),
								'meta_description'=>htmlspecialchars($this->input->post('meta_description'), ENT_QUOTES, 'utf-8'),											                                'page_content'=>htmlentities($this->input->post('page_content'), ENT_QUOTES, 'utf-8')
					             );	
		}
		else
		{
			$this->data['result'] = $this->static_page_model->get_static_page_details(0,-1,'',$arr  );
			/*Just making two dimensional array into one dimensional to print data in tpl in same way*/
			foreach($this->data['result'] as $key=>$value)
			$this->data['result'] = $value;
		}
		
		$this->data['title'] = 'Edit Static Page';
        $this->data['table_title'] = 'Edit static page';
        
		//$this->data['article_category_option'] = makeOption($this->article_model->article_category);
		
		
		#====================   CI Form Validation:: [Starts] ===================================
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			$this->form_validation->set_rules('page_title', 'Page title field', 'trim|required|xss_clean');
			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
			$this->form_validation->set_rules('url', 'Url', 'callback_url_check');
			$this->form_validation->set_rules('meta_keywords', 'meta_keywords', 'trim|required|xss_clean');
			$this->form_validation->set_rules('meta_description', 'meta_description', 'trim|required|xss_clean');
			$this->form_validation->set_rules('page_content', 'Page Content', 'trim|required|xss_clean');	
		#====================   CI Form Validation:: [End] ===================================
		if ($this->form_validation->run() == FALSE)
		{
			$this->add_js(array('tinymce/jscripts/tiny_mce/tiny_mce','tinymce_load','fromvalidation'));
			$this->set_include_files(array('common/admin_menu','static/edit_static_page'));
			$this->render();
		}
		else
		{
			$arr = array('page_title'=>htmlspecialchars($this->input->post('page_title'), ENT_QUOTES, 'utf-8'),
						'title'=>htmlspecialchars($this->input->post('title'), ENT_QUOTES, 'utf-8'),
						'url'=>htmlspecialchars($this->input->post('url'), ENT_QUOTES, 'utf-8'),
						'meta_keywords'=>htmlspecialchars($this->input->post('meta_keywords'), ENT_QUOTES, 'utf-8'),
						'meta_description'=>htmlspecialchars($this->input->post('meta_description'), ENT_QUOTES, 'utf-8'),
						'page_content'=>htmlspecialchars($this->input->post('page_content'), ENT_QUOTES, 'utf-8')
						);	
			$this->load->model('my_model');
			$this->my_model->set_data_update('static_page', $arr, $id);	
			//$this->load->library('user_agent');
			//$previous_url = $this->agent->referrer();
			//echo $previous_url;
			$this->session->set_userdata(array('message'=>"Updated Successfully",'message_type'=>'succ'));
            header("location:".base_url()."admin/static_page/edit_static_page/$id");
            exit;		
			//header("location:".$previous_url);exit();
			
		
		}
	
	
	}
	
	
	function delete_static_page($id = 0)
	{
	
		$this->check_user_page_access('registered');
		$page_no 	= $this->session->userdata('page_no'); // uri segment value
		$this->session->unset_userdata(array('page_no'=>''));
		$arr = array('id'=>$id);
		$this->load->model('static_page_model');
		$this->static_page_model->delete_static_page($arr);
		$total_rows = $this->static_page_model->count_get_static_page_details();
		if( $page_no >=  $total_rows &&  $page_no !=0)  $page_no = $page_no - $this->admin_page_limit; 
		$this->session->set_userdata(array('message'=>"Deleted Successfully",'message_type'=>'succ'));
		header('location:'.base_url().'admin/static_page/static_page_list/'.$page_no);
	
	
	}
	
	
}
?>