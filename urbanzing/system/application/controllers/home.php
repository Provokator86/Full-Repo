<?php
include BASEPATH.'application/controllers/MY_Controller'.EXT;

class home extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->clear_business_search();
    }

    function index()
    {
		$this->data['title'] = 'UrbanZing.com - Kolkata Restaurants, Beauty Parlours, Cinema Halls, Gyms, Boutiques';
		$this->data['meta_keywords'] = 'business listing, business directory, business list, List of Kolkata Business, List of Kolkata Businesses, Urbanzing, kolkata entertainment, Kolkata business reviews, kolkata restaurant reviews, kolkata reviews, kolkata food, Kolkata attractions';
		$this->data['meta_desc'] = "Kolkata Restaurants, Beauty Parlours, Cinema Halls, Gyms, Boutiques";

		$this->data['meta_google_site_verification'] = '7msVX7sqskfU1tZ-qLu55YRc-eudvtenU2Aa5Ste2_I';
		$this->data['meta_y_key'] = '0ee98af10717da1b';

		$this->menu_id = 1;
		$this->load->model('article_model');
		$this->load->model('business_model');
		
		$this->data['edit_user_text'] 	= 	$this->article_model->get_article_list(-1, 0, -1, '', 1, 'edit_user_profile');
		$this->data['home_page_text']	=	$this->article_model->get_article_list(-1, 0, -1, '', 1, 'home_page_text');
		$arr = array('status'=>1);
		$this->data['img_list'] = $this->business_model->get_home_page_image_list($arr, 5, 0);
		$arr = array('featured'=>'Y', 'status'=>1);
		$this->data['featured_business'] = $this->business_model->get_business_list($arr, -1, 0);
		$this->add_js('stepcarousel');
		$this->set_include_files(array('home/home_body'));
		$this->render();
    }

    function promote_your_business()
    {
		if($this->session->userdata('user_id') != '' )
		{
			header("Location: ".base_url().'business/add');
			exit();
		}
		
		$this->menu_id  = 8;
		$this->load->model('article_model');
		
		$this->data['title'] = 'Business owners – Promote your business and get more customers';
		$this->data['meta_keywords'] = 'Small business marketing, small business promotion, Small business marketing tips, Small business marketing tactics, Free marketing, Free listing, Free business listing';
		$this->data['meta_desc'] = 'Business owners – Promote your business and get more customers';

		$this->data['promote_business_page_upper_text'] = $this->article_model->get_article_list(1, 0, -1, '', 1, 'promote_business_page_upper_text');
		$this->data['promote_business_page_middle_text'] = $this->article_model->get_article_list(1, 0, -1, '', 1, 'promote_business_page_middle_text');
		$this->data['promote_business_page_lower_text'] = $this->article_model->get_article_list(1, 0, -1, '', 1, 'promote_business_page_lower_text');

		$this->set_include_files(array('home/promote_your_business'));
		$this->render();
    }
	
    function login()
    {
		$this->load->model('users_model');
		$this->check_user_page_access('non_registered');
		$this->load->model('article_model');
		
		$this->data['title'] = 'Login to access your account';
		$this->data['meta_desc'] = 'Kolkata Restaurants, Beauty Parlours, Cinema Halls, Gyms, Boutiques';

		$this->data['login_page_upper_text'] = $this->article_model->get_article_list(1, 0, -1, '', 1, 'login_page_upper');
		$this->data['login_page_lower'] = $this->article_model->get_article_list(1, 0, -1, '', 1, 'login_page_lower');

		$this->set_include_files(array('home/login'));
		$this->render();
    }

    function logout()
    {
		$this->load->model('users_model');
		$this->data['title'] = 'Home Page';
		$this->check_user_page_access('registered');
		$this->users_model->logout_this_login();
		
		header('location:'.base_url());
		exit;
    }

	function send_frnd_invitation()
	{
		$this->load->model('automail_model');
		$this->load->model('users_model');
		$invited_email = htmlspecialchars($this->input->post('invited_email'), ENT_QUOTES, 'utf-8');
		$source_name = ($this->session->userdata('user_username'))? $this->session->userdata('user_username'): htmlspecialchars($this->input->post('source_name'), ENT_QUOTES, 'utf-8');
		$chk = $this->users_model->get_invite_user_list(-1,0,array('invited_email'=>$invited_email));	/* checking same data */	
		if(count($chk)>0)
		{
			 $this->session->set_userdata(array('message'=>'Sorry, this user is already a member.','message_type'=>'err'));
			 header('location:'.base_url().'user/message_page');
			 exit();
		}
		/* server side validation */
		if($invited_email=='' || $invited_email=='Friend\'s Email Address' || $source_name=='' || $source_name=='Your Name')
		{
			 $this->session->set_userdata(array('message'=>'You have either given an invalid email or have not given us your name. Please check and make sure you have entered the right information','message_type'=>'err'));
			 header('location:'.base_url().'user/message_page');
			 exit();
		}
		if(!preg_match("/^[_a-z0-9-\+]+(\.[_a-z0-9-\+]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $invited_email) )
		{
			 $this->session->set_userdata(array('message'=>'You have given an invalid email','message_type'=>'err'));
			 header('location:'.base_url().'user/message_page');
			 exit();			
		
		}
		
		$userId = ($this->session->userdata('user_id'))? $this->session->userdata('user_id'): 0;
		//$user_type_id = ($this->session->userdata('user_type_id'))? $this->session->userdata('user_type_id'): 0;

		$arr_inv = array(
			"email_provided_by"=>'Other',
			"source_name"=> $source_name,
			"email_opt_in"=> 'N',
			"invited_email"=>$invited_email,
			"invite_accepted"=>'N',
			"invited_date"=>time(),
			"user_id"=>$userId,
			"user_type_id"=>0
		);
						
		$id = $this->users_model->set_data_insert('mailing_list', $arr_inv);
		if($id)
		{
			$mail_type = 'invite_user';
			$this->automail_model->send_invite_user_mail($this->input->post('invited_email'), $mail_type);
			$this->session->set_userdata(array('message'=>'Thank you for inviting your friend','message_type'=>'succ'));
			header('location:'.base_url().'user/message_page');
			exit();
		}
		
		$this->session->set_userdata(array(
			'message'=>'Unable to send invitation mail',
			'message_type'=>'err'
		));
		header('location:'.base_url().'user/message_page');
		exit;
	}

	function site_content($par = '')
	{
		if(empty($par))
		{
			$this->session->set_userdata(array(
				'message' => 'Sorry, Invalid page.',
				'message_type' => 'succ'
			));
			header('location:'.base_url().'user/message_page');
			exit();
		}

		switch($par)
		{
			case 'about_us':
				$this->data['title'] = 'UrbanZing.com - About us';
				$this->data['meta_desc'] = 'UrbanZing.com - About us - Kolkata Restaurants, Beauty Parlours, Cinema Halls, Gyms, Boutiques';
				break;

			case 'privacy':
				$this->data['title'] = 'UrbanZing.com - Privacy Policy';
				$this->data['meta_desc'] = 'UrbanZing.com - Privacy Policy - Kolkata Restaurants, Beauty Parlours, Cinema Halls, Gyms, Boutiques';
				break;

			case 'careers':
				$this->data['title'] = 'UrbanZing.com - Career/Jobs';
				$this->data['meta_desc'] = 'UrbanZing.com - Career/Jobs - Kolkata Restaurants, Beauty Parlours, Cinema Halls, Gyms, Boutiques';
				break;

			case 'contact_us':
				$this->data['title'] = 'UrbanZing.com - Contact Information';
				$this->data['meta_desc'] = 'UrbanZing.com - Contact - Kolkata Restaurants, Beauty Parlours, Cinema Halls, Gyms, Boutiques';
				break;

			case 'terms':
				$this->data['title'] = 'UrbanZing.com - Terms and Conditions';
				$this->data['meta_desc'] = 'UrbanZing.com - Terms and Conditions - Kolkata Restaurants, Beauty Parlours, Cinema Halls, Gyms, Boutiques';
				break;
		}

		$this->load->model('article_model');
		$this->data['content1'] = $this->article_model->get_article_list(1, 0, -1, '', 1, $par);
		
		$this->set_include_files(array('home/site_content'));
		$this->render();
	}
}
