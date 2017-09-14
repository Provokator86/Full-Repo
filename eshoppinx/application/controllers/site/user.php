<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * User related functions
 * @author Teamtweaks
 *
 */

class User extends MY_Controller {

	function __construct(){
		//echo "<pre>";print_r($_REQUEST);echo "</pre>";// die;
		parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));
		$this->load->model(array('user_model','product_model','stories_model'));
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->product_model->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];

		if($_SESSION['sColorLists'] == ''){
			$_SESSION['sColorLists'] = $this->user_model->get_all_details(LIST_VALUES,array('list_id'=>'1'));
		}
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];

		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['likedProducts'] = array();
		if ($this->data['loginCheck'] != ''){
			$this->data['likedProducts'] = $this->user_model->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
		}
        
        ############## new coding start 4 jan ##############        
        $this->data['total_saved'] = $this->user_model->count_tbl_total_records(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
        
        $this->data['total_collection'] = $this->user_model->count_tbl_total_records(LISTS_DETAILS,array('user_id'=>$this->checkLogin('U')));
        $this->data['total_story'] = $this->user_model->count_tbl_total_records(STORIES,array('user_id'=>$this->checkLogin('U')));
        
        $username =  $this->uri->segment(2,0);
        if($username)
        {            
            $userProfileDetails = $this->user_model->get_all_details(USERS,array('user_name'=>$username,'status'=>'Active'));
            $userId = $userProfileDetails->row()->id;
            if($userId)
            {                
                $nw_condn = " WHERE followers LIKE  '%,".$userId.",%' OR followers LIKE '%,".$userId."'";
                $tot_store_follow = $this->product_model->get_follows_stores($nw_condn);
                $this->data['tot_store_follow'] = $tot_store_follow->num_rows();   
            }
        }
        ############## new coding end 4 jan ##############
	}

	/**
	 *
	 * Function for quick signup
	 */
	public function quickSignup(){
		$email = $this->input->post('email');
		$returnStr['success'] = '0';
		if (valid_email($email)){
			$condition = array('email'=>$email);
			$duplicateMail = $this->user_model->get_all_details(USERS,$condition);
			if ($duplicateMail->num_rows()>0){
				$returnStr['msg'] = 'Email id already exists';
			}else {
				$fullname = substr($email, 0,strpos($email, '@'));
				$checkAvail = $this->user_model->get_all_details(USERS,array('user_name'=>$fullname));
				if ($checkAvail->num_rows()>0){
					$avail = FALSE;
				}else {
					$avail = TRUE;
					$username = $fullname;
				}
				while (!$avail){
					$username = $fullname.rand(1111, 999999);
					$checkAvail = $this->user_model->get_all_details(USERS,array('user_name'=>$username));
					if ($checkAvail->num_rows()>0){
						$avail = FALSE;
					}else {
						$avail = TRUE;
					}
				}
				if ($avail){
					$pwd = $this->get_rand_str('6');
					$this->user_model->insertUserQuick($fullname,$username,$email,$pwd);
					$this->session->set_userdata('quick_user_name',$username);
					$returnStr['msg'] = 'Successfully registered';
					$returnStr['full_name'] = $fullname;
					$returnStr['user_name'] = $username;
					$returnStr['password'] = $pwd;
					$returnStr['email'] = $email;
					$returnStr['success'] = '1';
				}
			}
		}else {
			$returnStr['msg'] = "Invalid email id";
		}
		echo json_encode($returnStr);
	}

	/**
	 *
	 * Function for quick signup update
	 */
	public function quickSignupUpdate(){
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$returnStr['success'] = '0';
		$condition = array('user_name'=>$username,'email !='=>$email);
		$duplicateName = $this->user_model->get_all_details(USERS,$condition);
		if ($duplicateName->num_rows()>0){
			$returnStr['msg'] = 'Username already exists';
		}else {
			$pwd = $this->input->post('password');
			$fullname = $this->input->post('fullname');
			$this->user_model->updateUserQuick($fullname,$username,$email,$pwd);
			$this->session->set_userdata('quick_user_name',$username);
			$returnStr['msg'] = 'Successfully registered';
			$returnStr['success'] = '1';
		}
		echo json_encode($returnStr);
	}

	public function send_quick_register_mail(){
		if ($this->checkLogin('U') != ''){
			redirect(base_url());
		}else {
			$quick_user_name = $this->session->userdata('quick_user_name');
			if ($quick_user_name == ''){
				redirect(base_url());
			}else {
				$condition = array('user_name'=>$quick_user_name);
				$userDetails = $this->user_model->get_all_details(USERS,$condition);
				if ($userDetails->num_rows() == 1){
					$this->send_confirm_mail($userDetails);
					$this->login_after_signup($userDetails);
					$this->session->set_userdata('quick_user_name','');
					if ($userDetails->row()->is_brand == 'yes'){
						redirect(base_url().'create-brand');
					}else {
						redirect(base_url().'onboarding');
					}
				}else {
					redirect(base_url());
				}
			}
		}
	}

	public function registerUser(){

		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$pwd = $this->input->post('pwd');
		$returnStr['success'] = '0';
		if (valid_email($email)){
			$condition = array('user_name'=>$username);
			$duplicateName = $this->user_model->get_all_details(USERS,$condition);
			if ($duplicateName->num_rows()>0){
				$returnStr['msg'] = 'User name already exists';
			}else {
				$condition = array('email'=>$email);
				$duplicateMail = $this->user_model->get_all_details(USERS,$condition);
				if ($duplicateMail->num_rows()>0){
					$returnStr['msg'] = 'Email id already exists';
				}else {
					$this->user_model->insertUserQuick($username,$email,$pwd);
					$condition = array('user_name'=>$username);
					$userDetails = $this->user_model->get_all_details(USERS,$condition);
					$this->session->set_userdata('quick_user_name',$username);

					/**---------Make user log in-----------------**/
					$userdata = array(
						'fc_session_user_id' => $userDetails->row()->id,
						'session_user_name' => $username,
						'session_user_email' => $email
					);

					$this->session->set_userdata($userdata);
					/**---------Make user log in-----------------**/

					$this->send_confirm_mail($userDetails);

					$returnStr['msg'] = 'Successfully registered';
					$returnStr['products'] = $this->get_products_template();
					$returnStr['success'] = '1';
				}
			}
		}else {
			$returnStr['msg'] = "Invalid email id";
		}
		echo json_encode($returnStr);
	}

	public function get_products_template(){
		$condition = " where p.status='Publish' and u.status='Active' or p.status='Publish' and p.user_id=0 limit 20";
		$products_list_s = $this->product_model->view_product_details($condition);
		$products_list_u = $this->product_model->get_all_details(USER_PRODUCTS,array('status'=>'Publish'),'','20');
		$products_list = $this->product_model->get_sorted_array($products_list_s,$products_list_u,'created','desc');
		if (count($products_list)>0){
			$content = '<ul  class="product_popup_thumb">';
			foreach ($products_list as $products_list_row){
				$prodImg = 'dummyProductImage.jpg';
				$prodImgArr = array_filter(explode(',', $products_list_row->image));
				if (count($prodImgArr)>0){
					foreach ($prodImgArr as $prodImgArrRow){
						if (file_exists('images/product/thumb/'.$prodImgArrRow)){
							$prodImg = $prodImgArrRow;
							break;
						}
					}
				}
				$content .= '<li>
				<a><img src="images/product/thumb/'.$prodImg.'" /></a>
				</li>';
			}
			$content .= '</ul>';
		}else {
			$content = "<p>No products available</p>";
		}
		return $content;
	}

	public function resend_confirm_mail(){
		$mail = $this->input->post('mail');
		if ($mail == ''){
			echo '0';
		}else {
			$condition = array('email'=>$mail);
			$userDetails = $this->user_model->get_all_details(USERS,$condition);
			$this->send_confirm_mail($userDetails);
			echo '1';
		}
	}

	public function send_email_confirmation(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U') == ''){
			$returnStr['message'] = 'Login required';
		}else {
			$this->send_confirm_mail($this->data['userDetails']);
			$returnStr['status_code'] = 1;
		}
		echo json_encode($returnStr);
	}

	public function display_user_profile(){
		$username =  $this->uri->segment(2,0);
		if ($username == 'administrator'){
			$this->data['heading'] = $username;
			$this->load->view('site/user/display_admin_profile');
		}else {
			$userProfileDetails = $this->user_model->get_all_details(USERS,array('user_name'=>$username,'status'=>'Active'));
			if ($userProfileDetails->num_rows()==1){
				$this->data['heading'] = $username;
				if ($userProfileDetails->row()->visibility == 'Only you' && $userProfileDetails->row()->id != $this->checkLogin('U')){
					$this->load->view('site/user/display_user_profile_private',$this->data);
				}else {
					$productLikeDetails = $this->user_model->get_like_details_fully($userProfileDetails->row()->id);
					$userProductLikeDetails = $this->user_model->get_like_details_fully_user_products($userProfileDetails->row()->id);

					$this->data['product_details'] = $this->product_model->get_sorted_array($productLikeDetails,$userProductLikeDetails,'created','desc');
					$this->data['userProfileDetails'] = $userProfileDetails;
					$this->load->view('site/user/display_user_profile',$this->data);
				}
			}else {
				$this->setErrorMessage('error','User details not available');
				redirect(base_url());
			}
		}
	}

	public function send_confirm_mail($userDetails=''){
		$uid = $userDetails->row()->id;
		$email = $userDetails->row()->email;
		$randStr = $this->get_rand_str('10');
		$condition = array('id'=>$uid);
		$dataArr = array('verify_code'=>$randStr);
		$this->user_model->update_details(USERS,$dataArr,$condition);
		$newsid='3';
		$template_values=$this->user_model->get_newsletter_template_details($newsid);

		$cfmurl = base_url().'site/user/confirm_register/'.$uid."/".$randStr."/confirmation";
		$subject = 'From: '.$this->config->item('email_title').' - '.$template_values['news_subject'];
		$adminnewstemplateArr=array('email_title'=> $this->config->item('email_title'),'logo'=> $this->data['logo']);
		extract($adminnewstemplateArr);
		//$ddd =htmlentities($template_values['news_descrip'],null,'UTF-8');
		$header .="Content-Type: text/plain; charset=ISO-8859-1\r\n";

		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/><body>';
		include('./newsletter/registeration'.$newsid.'.php');

		$message .= '</body>
			</html>';

		if($template_values['sender_name']=='' && $template_values['sender_email']==''){
			$sender_email=$this->data['siteContactMail'];
			$sender_name=$this->data['siteTitle'];
		}else{
			$sender_name=$template_values['sender_name'];
			$sender_email=$template_values['sender_email'];
		}

		$email_values = array('mail_type'=>'html',
							'from_mail_id'=>$sender_email,
							'mail_name'=>$sender_name,
							'to_mail_id'=>$email,
							'subject_message'=>$template_values['news_subject'],
							'body_messages'=>$message,
							'mail_id'=>'register mail'
							);
							$email_send_to_common = $this->product_model->common_email_send($email_values);
	}

	public function signup_form(){
		if ($this->checkLogin('U') != ''){
			redirect(base_url());
		}else {
			$this->data['heading'] = 'Sign up';
			$this->load->view('site/user/signup',$this->data);
		}
	}

	/**
	 *
	 * Loading login page
	 */
	public function login_form(){
		if ($this->checkLogin('U')!=''){
			redirect(base_url());
		}else {
			$this->data['next'] = $this->input->get('next');
			//echo $this->data['next'];die;
			$this->data['heading'] = 'Sign in';
			$this->load->view('site/user/login',$this->data);
		}
	}

	public function login_user(){
		$this->form_validation->set_rules('email', 'Email Address', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$next = $this->input->post('next');
		if ($this->form_validation->run() === FALSE)
		{
			$this->setErrorMessage('error','Email and password fields required');
			redirect('login?next='.urlencode($next));
		}else {
			$email = $this->input->post('email');
			$pwd = md5($this->input->post('password'));
			$condition = array('email'=>$email,'password'=>$pwd,'status'=>'Active');
			$checkUser = $this->user_model->get_all_details(USERS,$condition);
			if ($checkUser->num_rows() == '1'){
				$userdata = array(
								'fc_session_user_id' => $checkUser->row()->id,
								'session_user_name' => $checkUser->row()->user_name,
								'session_user_email' => $checkUser->row()->email
				);

				$this->session->set_userdata($userdata);
				//				echo $this->session->userdata('fc_session_user_id');die;
				$datestring = "%Y-%m-%d %h:%i:%s";
				$time = time();
				$newdata = array(
	               'last_login_date' => mdate($datestring,$time),
	               'last_login_ip' => $this->input->ip_address()
				);
				$condition = array('id' => $checkUser->row()->id);
				$this->user_model->update_details(USERS,$newdata,$condition);

				$this->user_model->updategiftcard(GIFTCARDS_TEMP,$this->checkLogin('T'),$checkUser->row()->id);

				$this->setErrorMessage('success','You are Logged In ... Start Admiring !');
				//				$this->session->set_flashdata('loadAfterLog', '1');
				redirect($next);
			}else {
				$this->setErrorMessage('error','Invalid login details');
				redirect('login?next='.urlencode($next));
			}
		}
	}

	public function login_user_popup(){

		$email = $this->input->post('email');
		$pwd = md5($this->input->post('pwd'));
		$returnStr['success']='0';
		$condition = array('email'=>$email,'password'=>$pwd,'status'=>'Active');
		$checkUser = $this->user_model->get_all_details(USERS,$condition);
		if ($checkUser->num_rows() == '1'){
			$userdata = array(
								'fc_session_user_id' => $checkUser->row()->id,
								'session_user_name' => $checkUser->row()->user_name,
								'session_user_email' => $checkUser->row()->email
			);
			//				echo "<pre>";print_r($userdata);

			$this->session->set_userdata($userdata);
			//				echo $this->session->userdata('fc_session_user_id');die;
			$datestring = "%Y-%m-%d %h:%i:%s";
			$time = time();
			$newdata = array(
	               'last_login_date' => mdate($datestring,$time),
	               'last_login_ip' => $this->input->ip_address()
			);
			$condition = array('id' => $checkUser->row()->id);
			$this->user_model->update_details(USERS,$newdata,$condition);

			$this->user_model->updategiftcard(GIFTCARDS_TEMP,$this->checkLogin('T'),$checkUser->row()->id);

			$this->setErrorMessage('success','You are Logged In ... Start Admiring !');
			//				$this->session->set_flashdata('loadAfterLog', '1');
			$returnStr['msg']='You are Logged In ... Start Admiring !';
			$returnStr['success']='1';
		}else {
			$this->setErrorMessage('error','Invalid login details');
			$returnStr['msg']='Invalid login details';
			$returnStr['success']='0';
		}
		echo json_encode($returnStr);
	}

	public function login_after_signup($userDetails=''){
		if ($userDetails->num_rows() == '1'){
			$userdata = array(
							'fc_session_user_id' => $userDetails->row()->id,
							'session_user_name' => $userDetails->row()->user_name,
							'session_user_email' => $userDetails->row()->email
			);
			$this->session->set_userdata($userdata);
			$datestring = "%Y-%m-%d %h:%i:%s";
			$time = time();
			$newdata = array(
               'last_login_date' => mdate($datestring,$time),
               'last_login_ip' => $this->input->ip_address()
			);
			$condition = array('id' => $userDetails->row()->id);
			$this->user_model->update_details(USERS,$newdata,$condition);

			$this->user_model->updategiftcard(GIFTCARDS_TEMP,$this->checkLogin('T'),$userDetails->row()->id);


		}else {
			redirect(base_url());
		}
	}

	public function confirm_register(){
		$uid = $this->uri->segment(4,0);
		$code = $this->uri->segment(5,0);
		$mode = $this->uri->segment(6,0);
		if($mode=='confirmation'){
			$condition = array('verify_code'=>$code,'id'=>$uid);
			$checkUser = $this->user_model->get_all_details(USERS,$condition);
			if ($checkUser->num_rows() == 1){
				$conditionArr = array('id'=>$uid,'verify_code'=>$code);
				$dataArr = array('is_verified'=>'Yes');
				$this->user_model->update_details(USERS,$dataArr,$condition);
				$this->setErrorMessage('success','Great going ! Your mail ID has been verified');
				$this->login_after_signup($checkUser);
				redirect(base_url());
			}else {
				$this->setErrorMessage('error','Invalid confirmation link');
				redirect(base_url());
			}
		}else {
			$this->setErrorMessage('error','Invalid confirmation link');
			redirect(base_url());
		}
	}

	public function logout_user(){
		$datestring = "%Y-%m-%d %h:%i:%s";
		$time = time();
		$newdata = array(
               'last_logout_date' => mdate($datestring,$time)
		);
		$condition = array('id' => $this->checkLogin('U'));
		$this->user_model->update_details(USERS,$newdata,$condition);
		$userdata = array(
						'fc_session_user_id'=>'',
						'session_user_name'=>'',
						'session_user_email'=>'',
						'fc_session_temp_id'=>''
						);
						$this->session->unset_userdata($userdata);

						@session_start();
						unset($_SESSION['token']);
						$twitter_return_values = array('tw_status'=>'',
										'tw_access_token'=>''
										);

										$this->session->unset_userdata($twitter_return_values);

										$this->setErrorMessage('success','Successfully logout from your account');
										redirect(base_url());
	}

	public function forgot_password_form(){
		if ($this->checkLogin('U')==''){
			$this->data['heading'] = 'Forgot Password';
			$this->load->view('site/user/forgot_password.php',$this->data);
		}else {
			redirect('trending');
		}
	}

	public function forgot_password_user(){
		$this->form_validation->set_rules('email', 'Email Address', 'required');
		if ($this->form_validation->run() === FALSE)
		{
			$this->setErrorMessage('error','Email address required');
			redirect('forgot-password');
		}else {
			$email = $this->input->post('email');
			if (valid_email($email)){
				$condition = array('email'=>$email);
				$checkUser = $this->user_model->get_all_details(USERS,$condition);
				if ($checkUser->num_rows() == '1'){
					$pwd = $this->get_rand_str('6');
					$newdata = array('password' => md5($pwd));
					$condition = array('email' => $email);
					$this->user_model->update_details(USERS,$newdata,$condition);
					$this->send_user_password($pwd,$checkUser);
					$this->setErrorMessage('success','New password sent to your mail');
					redirect('login');
				}else {
					$this->setErrorMessage('error','Your email id not matched in our records');
					redirect('forgot-password');
				}
			}else {
				$this->setErrorMessage('error','Email id not valid');
				redirect('forgot-password');
			}
		}
	}

	public function send_user_password($pwd='',$query){
		$newsid='5';
		$template_values=$this->user_model->get_newsletter_template_details($newsid);
		$adminnewstemplateArr=array('email_title'=> $this->config->item('email_title'),'logo'=> $this->data['logo'],'full_name'=>$query->row()->full_name);
		extract($adminnewstemplateArr);
		$subject = 'From: '.$this->config->item('email_title').' - '.$template_values['news_subject'];
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>'.$template_values['news_subject'].'</title>
			<body>';
		include('./newsletter/registeration'.$newsid.'.php');

		$message .= '</body>
			</html>';
			

		if($template_values['sender_name']=='' && $template_values['sender_email']==''){
			$sender_email=$this->config->item('site_contact_mail');
			$sender_name=$this->config->item('email_title');
		}else{
			$sender_name=$template_values['sender_name'];
			$sender_email=$template_values['sender_email'];
		}

		$email_values = array('mail_type'=>'html',
							'from_mail_id'=>$sender_email,
							'mail_name'=>$sender_name,
							'to_mail_id'=>$query->row()->email,
							'subject_message'=>'Password Reset',
							'body_messages'=>$message,
							'mail_id'=>'forgot'
							);
							$email_send_to_common = $this->product_model->common_email_send($email_values);

							/*		echo $this->email->print_debugger();die;
							 */
	}

	public function add_fancy_item(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U') == ''){
			$returnStr['message'] = 'You must login';
		}else {
			$tid = $this->input->post('tid');
			$checkProductLike = $this->user_model->get_all_details(PRODUCT_LIKES,array('product_id'=>$tid,'user_id'=>$this->checkLogin('U')));
			$productDetails = $this->user_model->get_all_details(PRODUCT,array('seller_product_id'=>$tid));
			if ($productDetails->num_rows() == 0){
				$productDetails = $this->user_model->get_all_details(USER_PRODUCTS,array('seller_product_id'=>$tid));
				$productTable = USER_PRODUCTS;
			}else {
				$productTable = PRODUCT;
			}
			$returnStr['likes'] = $productDetails->row()->likes;
			if ($checkProductLike->num_rows() == 0){
				if ($productDetails->num_rows()==1){
					$likes = $productDetails->row()->likes;
					$dataArr = array('product_id'=>$tid,'user_id'=>$this->checkLogin('U'),'ip'=>$this->input->ip_address());
					$this->user_model->simple_insert(PRODUCT_LIKES,$dataArr);

					$actArr = array(
						'activity_name'	=>	'fancy',
						'activity_id'	=>	$tid,
						'user_id'		=>	$this->checkLogin('U'),
						'activity_ip'	=>	$this->input->ip_address()
					);
					$this->user_model->simple_insert(USER_ACTIVITY,$actArr);

					$datestring = "%Y-%m-%d %h:%i:%s";
					$time = time();
					$createdTime = mdate($datestring,$time);
					$actArr = array(
						'activity'		=>	'like',
						'activity_id'	=>	$tid,
						'user_id'		=>	$this->checkLogin('U'),
						'activity_ip'	=>	$this->input->ip_address(),
						'created'		=>	$createdTime
					);
					$this->user_model->simple_insert(NOTIFICATIONS,$actArr);
					$likes++;
					$dataArr = array('likes'=>$likes);
					$condition = array('seller_product_id'=>$tid);
					$this->user_model->update_details($productTable,$dataArr,$condition);

					//insert into magic
					$cat_ids = array_filter(explode(',', $productDetails->row()->category_id));
					if (count($cat_ids)>0){
						$magic_ids = array_filter(explode(',',$this->data['userDetails']->row()->magic_cat));
						$new_magic_ids = implode(',', array_unique(array_merge($cat_ids,$magic_ids)));
					}else {
						$new_magic_ids = $this->data['userDetails']->row()->magic_cat;
					}

					$totalUserLikes = $this->data['userDetails']->row()->likes;
					$totalUserLikes++;
					$this->user_model->update_details(USERS,array('likes'=>$totalUserLikes,'magic_cat'=>$new_magic_ids),array('id'=>$this->checkLogin('U')));
					$returnStr['likes'] = $likes;
					$returnStr['status_code'] = 1;
				}else {
					$returnStr['message'] = 'Product not available';
				}
			}
		}
		echo json_encode($returnStr);
	}

	public function remove_fancy_item(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U') == ''){
			$returnStr['message'] = 'You must login';
		}else {
			$tid = $this->input->post('tid');
			$checkProductLike = $this->user_model->get_all_details(PRODUCT_LIKES,array('product_id'=>$tid,'user_id'=>$this->checkLogin('U')));
			if ($checkProductLike->num_rows() == 1){
				$productDetails = $this->user_model->get_all_details(PRODUCT,array('seller_product_id'=>$tid));
				if ($productDetails->num_rows()==0){
					$productDetails = $this->user_model->get_all_details(USER_PRODUCTS,array('seller_product_id'=>$tid));
					$productTable = USER_PRODUCTS;
				}else {
					$productTable = PRODUCT;
				}
				if ($productDetails->num_rows()==1){
					$likes = $productDetails->row()->likes;
					$conditionArr = array('product_id'=>$tid,'user_id'=>$this->checkLogin('U'));
					$this->user_model->commonDelete(PRODUCT_LIKES,$conditionArr);
					$actArr = array(
						'activity_name'	=>	'unfancy',
						'activity_id'	=>	$tid,
						'user_id'		=>	$this->checkLogin('U'),
						'activity_ip'	=>	$this->input->ip_address()
					);
					$this->user_model->simple_insert(USER_ACTIVITY,$actArr);
					$likes--;
					$dataArr = array('likes'=>$likes);
					$condition = array('seller_product_id'=>$tid);
					$this->user_model->update_details($productTable,$dataArr,$condition);
					$totalUserLikes = $this->data['userDetails']->row()->likes;
					$totalUserLikes--;
					$this->user_model->update_details(USERS,array('likes'=>$totalUserLikes),array('id'=>$this->checkLogin('U')));
					$returnStr['status_code'] = 1;
				}else {
					$returnStr['message'] = 'Product not available';
				}
			}
		}
		echo json_encode($returnStr);
	}

	public function display_myfeed(){
		if ($this->checkLogin('U')==''){
			redirect('login');
		}else {
			if ($this->data['userDetails']->num_rows() == 1){
				$this->data['heading'] = $this->data['userDetails']->row()->full_name;

				if($this->input->get('pg') != ''){
					$paginationVal = $this->input->get('pg')*300;
					$limitPaging = $paginationVal.',300 ';
				} else {
					$limitPaging = ' 0,300';
				}


				$prodDetails = array();
				$product_owners = array();


				/*****************Get Products Added By Me*************/
				$userAddedProdDetails = $this->user_model->get_all_details(USER_PRODUCTS,array('user_id'=>$this->data['userDetails']->row()->id));
				if ($userAddedProdDetails->num_rows()>0){
					foreach ($userAddedProdDetails->result() as $userAddedProdDetailsRow){
						$prodDetails[$userAddedProdDetailsRow->seller_product_id] = $userAddedProdDetailsRow;
					}
				}
				$SellerAddedProdDetails = $this->user_model->get_all_details(PRODUCT,array('user_id'=>$this->data['userDetails']->row()->id));
				if ($SellerAddedProdDetails->num_rows()>0){
					foreach ($SellerAddedProdDetails->result() as $SellerAddedProdDetailsRow){
						$prodDetails[$SellerAddedProdDetailsRow->seller_product_id] = $SellerAddedProdDetailsRow;
					}
				}
				/***************************************************************************/

				/*****************Get Products Saved By Me*************/
				$saved_products_details = $this->user_model->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->data['userDetails']->row()->id));
				$saved_products_ids = array();
				if ($saved_products_details->num_rows()>0){
					foreach ($saved_products_details->result() as $saved_products_details_row){
						$saved_products_ids[] = $saved_products_details_row->product_id;
					}
				}
				if (count($saved_products_ids)>0){
					$cond_arr = array('status'=>'Publish');
					$saved_products_det_sell  = $this->product_model->get_prodcuts_from_ids($saved_products_ids,$cond_arr,PRODUCT);
					if ($saved_products_det_sell->num_rows()>0){
						foreach ($saved_products_det_sell->result() as $saved_products_det_sell_row){
							$prodDetails[$saved_products_det_sell_row->seller_product_id] = $saved_products_det_sell_row;
						}
					}
					$saved_products_det_affil  = $this->product_model->get_prodcuts_from_ids($saved_products_ids,$cond_arr,USER_PRODUCTS);
					if ($saved_products_det_affil->num_rows()>0){
						foreach ($saved_products_det_affil->result() as $saved_products_det_affil_row){
							$prodDetails[$saved_products_det_affil_row->seller_product_id] = $saved_products_det_affil_row;
						}
					}
				}
				/***************************************************************************/

				/*****************Get Products From Collections Which I Follow*************/
				$followingUserListProductArr = array_filter(explode(',',$this->data['userDetails']->row()->following_user_lists));
				if (count($followingUserListProductArr)>0){
					foreach($followingUserListProductArr as $listProdRow){
						$listProductDetails[] = $this->user_model->get_all_details(LISTS_DETAILS,array('id'=>$listProdRow));
					}
					$list_prod_ids = array();
					foreach($listProductDetails as $listProdRow ){
						if($listProdRow->num_rows()>0){
							$list_prod_ids_arr = array_filter(explode(',', $listProdRow->row()->product_id));
							$list_prod_ids = array_merge($list_prod_ids,$list_prod_ids_arr);
						}
					}
					$list_prod_ids = array_unique($list_prod_ids);
					if (count($list_prod_ids)>0){
						$cond_arr = array('status'=>'Publish');
						$collection_prod_details_sell  = $this->product_model->get_prodcuts_from_ids($list_prod_ids,$cond_arr,PRODUCT);
						if ($collection_prod_details_sell->num_rows()>0){
							foreach ($collection_prod_details_sell->result() as $collection_prod_details_sell_row){
								$prodDetails[$collection_prod_details_sell_row->seller_product_id] = $collection_prod_details_sell_row;
							}
						}
						$collection_prod_details_affil  = $this->product_model->get_prodcuts_from_ids($list_prod_ids,$cond_arr,USER_PRODUCTS);
						if ($collection_prod_details_affil->num_rows()>0){
							foreach ($collection_prod_details_affil->result() as $collection_prod_details_affil_row){
								$prodDetails[$collection_prod_details_affil_row->seller_product_id] = $collection_prod_details_affil_row;
							}
						}
					}
				}
				/***************************************************************************/

				/*****************Get Products From Users/Stores Which I Follow*************/
				$followingArr = array_filter(explode(',',$this->data['userDetails']->row()->following));
				if (count($followingArr)>0){
					$cond_arr = array('status'=>'Publish');
					$following_prod_details_sell  = $this->product_model->get_prodcuts_from_user_ids($followingArr,$cond_arr,PRODUCT);
					if ($following_prod_details_sell->num_rows()>0){
						foreach ($following_prod_details_sell->result() as $following_prod_details_sell_row){
							$prodDetails[$following_prod_details_sell_row->seller_product_id] = $following_prod_details_sell_row;
						}
					}
					$following_prod_details_affil  = $this->product_model->get_prodcuts_from_user_ids($followingArr,$cond_arr,USER_PRODUCTS);
					if ($following_prod_details_affil->num_rows()>0){
						foreach ($following_prod_details_affil->result() as $following_prod_details_affil_row){
							$prodDetails[$following_prod_details_affil_row->seller_product_id] = $following_prod_details_affil_row;
						}
					}
				}
				/***************************************************************************/
				if (count($prodDetails)>0){
					foreach ($prodDetails as $prodDetailsRow){
						$user_ids[] = $prodDetailsRow->user_id;
						$sort_prod_details['time'][] = $prodDetailsRow->created;
					}
					array_multisort($sort_prod_details['time'],SORT_DESC,$prodDetails);
					$user_ids = array_unique(array_filter($user_ids));
					if (count($user_ids)>0){
						$user_ids_details = $this->user_model->get_user_details_from_ids($user_ids);
						if ($user_ids_details->num_rows()>0){
							foreach ($user_ids_details->result() as $user_ids_details_row){
								$product_owners[$user_ids_details_row->id] = $user_ids_details_row;
							}
						}
					}
					//echo "<pre>";print_r($product_owners);die;
				}
				//echo "<pre>";print_r ($prodDetails);die;
				$this->data['product_details'] = $prodDetails;
				$this->data['product_owners'] = $product_owners;

				$newPage = $this->input->get('pg')+1;
				$qry_str = '?pg='.$newPage;
				$url = base_url().'myfeed'.$qry_str;
				if (count($this->data['product_details'])==0) $url = '';
				$paginationDisplay  = '<a title="'.$newPage.'" class="btn-more" href="'.$url.'" style="display: none;">See More Products</a>';
				$this->data['paginationDisplay'] = $paginationDisplay;
                
                ########### new code for new html ##################                        
                $this->load->model('product_model','shop');
                $this->data['nav_menu'] = 7;
                $this->data['topPeople'] = $this->shop->get_top_people();

				$this->load->view('site/user/display_myfeed',$this->data);
			}else {
				$this->setErrorMessage('error','Not available');
				redirect(base_url().'trending');
			}
		}
	}

	public function add_follow(){
		$returnStr['status_code'] = 0;

		if ($this->checkLogin('U') != ''){
			$follow_id = $this->input->post('user_id');
			$followingListArr = explode(',', $this->data['userDetails']->row()->following);
			if (!in_array($follow_id, $followingListArr)){
				$followingListArr[] = $follow_id;
				$newFollowingList = implode(',', $followingListArr);
				$followingCount = $this->data['userDetails']->row()->following_count;
				$followingCount++;
				$dataArr = array('following'=>$newFollowingList,'following_count'=>$followingCount);
				$condition = array('id'=>$this->checkLogin('U'));
				$this->user_model->update_details(USERS,$dataArr,$condition);
				$followUserDetails = $this->user_model->get_all_details(USERS,array('id'=>$follow_id));
				if ($followUserDetails->num_rows() == 1){
					$followersListArr = explode(',', $followUserDetails->row()->followers);
					if (!in_array($this->checkLogin('U'), $followersListArr)){
						$followersListArr[] = $this->checkLogin('U');
						$newFollowersList = implode(',', $followersListArr);
						$followersCount = $followUserDetails->row()->followers_count;
						$followersCount++;
						$dataArr = array('followers'=>$newFollowersList,'followers_count'=>$followersCount);
						$condition = array('id'=>$follow_id);
						$this->user_model->update_details(USERS,$dataArr,$condition);
					}
				}
				$actArr = array(
					'activity_name'	=>	'follow',
					'activity_id'	=>	$follow_id,
					'user_id'		=>	$this->checkLogin('U'),
					'activity_ip'	=>	$this->input->ip_address()
				);
				$this->user_model->simple_insert(USER_ACTIVITY,$actArr);
				$datestring = "%Y-%m-%d %h:%i:%s";
				$time = time();
				$createdTime = mdate($datestring,$time);
				$actArr = array(
					'activity'	=>	'follow',
					'activity_id'	=>	$follow_id,
					'user_id'		=>	$this->checkLogin('U'),
					'activity_ip'	=>	$this->input->ip_address(),
					'created'		=>	$createdTime
				);
				$this->user_model->simple_insert(NOTIFICATIONS,$actArr);
				$this->send_noty_mail($followUserDetails->result_array());
				$returnStr['status_code'] = 1;
			}else {
				$returnStr['status_code'] = 1;
			}
		}
		echo json_encode($returnStr);
	}

	public function add_follows(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U') != ''){
			$follow_ids = $this->input->post('user_ids');
			$follow_ids_arr = explode(',', $follow_ids);
			$followingListArr = explode(',', $this->data['userDetails']->row()->following);
			foreach ($follow_ids_arr as $flwRow){
				if (in_array($flwRow, $followingListArr)){
					if (($key = array_search($flwRow, $follow_ids_arr)) !== false){
						unset($follow_ids_arr[$key]);
					}
				}
			}
			if (count($follow_ids_arr)>0){
				$newfollowingListArr = array_merge($followingListArr,$follow_ids_arr);
				$newFollowingList = implode(',', $newfollowingListArr);
				$followingCount = $this->data['userDetails']->row()->following_count;
				$newCount = count($follow_ids_arr);
				$followingCount = $followingCount+$newCount;
				$dataArr = array('following'=>$newFollowingList,'following_count'=>$followingCount);
				$condition = array('id'=>$this->checkLogin('U'));
				$this->user_model->update_details(USERS,$dataArr,$condition);
				$conditionStr = 'where id IN ('.implode(',', $follow_ids_arr).')';
				$followUserDetailsArr = $this->user_model->get_users_details($conditionStr);
				if ($followUserDetailsArr->num_rows() > 0){
					foreach ($followUserDetailsArr->result() as $followUserDetails){
						$followersListArr = explode(',', $followUserDetails->followers);
						if (!in_array($this->checkLogin('U'), $followersListArr)){
							$followersListArr[] = $this->checkLogin('U');
							$newFollowersList = implode(',', $followersListArr);
							$followersCount = $followUserDetails->followers_count;
							$followersCount++;
							$dataArr = array('followers'=>$newFollowersList,'followers_count'=>$followersCount);
							$condition = array('id'=>$followUserDetails->id);
							$this->user_model->update_details(USERS,$dataArr,$condition);
							$datestring = "%Y-%m-%d %h:%i:%s";
							$time = time();
							$createdTime = mdate($datestring,$time);
							$actArr = array(
								'activity'	=>	'follow',
								'activity_id'	=>	$followUserDetails->id,
								'user_id'		=>	$this->checkLogin('U'),
								'activity_ip'	=>	$this->input->ip_address(),
								'created'		=>	$createdTime
							);
							$this->user_model->simple_insert(NOTIFICATIONS,$actArr);
							$this->send_noty_mails($followUserDetails);
						}
					}
				}
				$returnStr['status_code'] = 1;
			}else {
				$returnStr['status_code'] = 1;
			}
		}
		echo json_encode($returnStr);
	}

	public function delete_follow(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U') != ''){
			$follow_id = $this->input->post('user_id');
			$followingListArr = explode(',', $this->data['userDetails']->row()->following);
			if (in_array($follow_id, $followingListArr)){
				if(($key = array_search($follow_id, $followingListArr)) !== false) {
					unset($followingListArr[$key]);
				}
				$newFollowingList = implode(',', $followingListArr);
				$followingCount = $this->data['userDetails']->row()->following_count;
				$followingCount--;
				$dataArr = array('following'=>$newFollowingList,'following_count'=>$followingCount);
				$condition = array('id'=>$this->checkLogin('U'));
				$this->user_model->update_details(USERS,$dataArr,$condition);
				$followUserDetails = $this->user_model->get_all_details(USERS,array('id'=>$follow_id));
				if ($followUserDetails->num_rows() == 1){
					$followersListArr = explode(',', $followUserDetails->row()->followers);
					if (in_array($this->checkLogin('U'), $followersListArr)){
						if(($key = array_search($this->checkLogin('U'), $followersListArr)) !== false) {
							unset($followersListArr[$key]);
						}
						$newFollowersList = implode(',', $followersListArr);
						$followersCount = $followUserDetails->row()->followers_count;
						$followersCount--;
						$dataArr = array('followers'=>$newFollowersList,'followers_count'=>$followersCount);
						$condition = array('id'=>$follow_id);
						$this->user_model->update_details(USERS,$dataArr,$condition);
					}
				}
				$actArr = array(
					'activity_name'	=>	'unfollow',
					'activity_id'	=>	$follow_id,
					'user_id'		=>	$this->checkLogin('U'),
					'activity_ip'	=>	$this->input->ip_address()
				);
				$this->user_model->simple_insert(USER_ACTIVITY,$actArr);
				$returnStr['status_code'] = 1;
			}else {
				$returnStr['status_code'] = 1;
			}
		}
		echo json_encode($returnStr);
	}

	public function display_user_added(){
		$username =  $this->uri->segment(2,0);
		$userProfileDetails = $this->user_model->get_all_details(USERS,array('user_name'=>$username));
		if ($userProfileDetails->num_rows()==1){
			if ($userProfileDetails->row()->visibility == 'Only you' && $userProfileDetails->row()->id != $this->checkLogin('U')){
				$this->load->view('site/user/display_user_profile_private',$this->data);
			}else {
				$this->data['heading'] = $username;
				$this->data['userProfileDetails'] = $userProfileDetails;
				$addedProductDetails = $this->product_model->view_product_details(' where p.user_id='.$userProfileDetails->row()->id.' and p.status="Publish"');
				$notSellProducts = $this->product_model->view_notsell_product_details(' where p.user_id='.$userProfileDetails->row()->id.' and p.status="Publish"');

				$this->data['product_details'] = $this->product_model->get_sorted_array($addedProductDetails,$notSellProducts,'created','desc');
				$this->load->view('site/user/display_user_added',$this->data);
			}
		}else {
			redirect(base_url());
		}
	}

	public function display_user_trending(){
		$username =  $this->uri->segment(2,0);
		$userProfileDetails = $this->user_model->get_all_details(USERS,array('user_name'=>$username));
		if ($userProfileDetails->num_rows()==1){
			if ($userProfileDetails->row()->visibility == 'Only you' && $userProfileDetails->row()->id != $this->checkLogin('U')){
				$this->load->view('site/user/display_user_profile_private',$this->data);
			}else {
				$this->data['heading'] = $username;
				$this->data['userProfileDetails'] = $userProfileDetails;
				$condition = " where p.status='Publish' and p.user_id='".$userProfileDetails->row()->id."'";
				$this->data['product_details'] = $this->product_model->get_hotness_products($condition,$limitPaging);

				$this->load->view('site/user/display_user_trending',$this->data);
			}
		}else {
			redirect(base_url());
		}
	}

	public function display_user_added_collection(){
		$username =  $this->uri->segment(2,0);
		$catnameurl =  $this->uri->segment(3,0);
		$catname = str_replace("-"," ",$catnameurl);
		$userProfileDetails = $this->user_model->get_all_details(USERS,array('user_name'=>$username));
		if ($userProfileDetails->num_rows()==1){
			if ($userProfileDetails->row()->visibility == 'Only you' && $userProfileDetails->row()->id != $this->checkLogin('U')){
				$this->load->view('site/user/display_user_profile_private',$this->data);
			}else {
				$this->data['heading'] = $username;
				$this->data['userProfileDetails'] = $userProfileDetails;
				$this->data['recentActivityDetails'] = $this->user_model->get_activity_details($userProfileDetails->row()->id);

				$this->data['listDetails'] = $this->product_model->get_all_details(LISTS_DETAILS,array('user_id'=>$userProfileDetails->row()->id,'name'=>$catname));
				if ($this->data['listDetails']->num_rows()>0){
					foreach ($this->data['listDetails']->result() as $listDetailsRow){
						$this->data['listImg'][$listDetailsRow->id] = '';
						if ($listDetailsRow->product_id != ''){
							$returnCnt['product_lists'] = $pidArr = array_filter(explode(',', $listDetailsRow->product_id));

							$returnCnt['prodDetails'][$listDetailsRow->id] = '';

							if (count($pidArr)>0){
								$product_id_str = '';
								foreach ($pidArr as $pid_row){
									if ($pid_row != ''){
										$product_id_str .= $pid_row.',';
									}
								}
								$product_id_str = substr($product_id_str, 0,-1);
								/*$Query = "select * from ".PRODUCT." where status='Publish' and quantity>0 and seller_product_id in (".$product_id_str.")";
								 $returnCnt['prodDetails'][$listDetailsRow->id] = $this->product_model->ExecuteQuery($Query);*/

								$addedProductDetails = $this->product_model->view_product_details(" where p.status='Publish' and p.seller_product_id in (".$product_id_str.")");
								$notSellProducts = $this->product_model->view_notsell_product_details(" where p.status='Publish' and p.seller_product_id in (".$product_id_str.")");
								$returnCnt['prodDetails'][$listDetailsRow->id] = $this->product_model->get_sorted_array($addedProductDetails,$notSellProducts,'created','desc');
							}
						}
					}
				}
					
				$this->data['product_lists']=$returnCnt['product_lists'];
				$this->data['prodDetails']=$returnCnt['prodDetails'];
				$this->load->view('site/user/display_collection',$this->data);
			}
		}else {
			redirect(base_url());
		}
	}

	public function display_user_lists(){
		$username =  $this->uri->segment(2,0);
		$userProfileDetails = $this->user_model->get_all_details(USERS,array('user_name'=>$username));
		if ($userProfileDetails->num_rows()==1){
			if ($userProfileDetails->row()->visibility == 'Only you' && $userProfileDetails->row()->id != $this->checkLogin('U')){
				$this->load->view('site/user/display_user_profile_private',$this->data);
			}else {
				$this->data['heading'] = $username;
				$this->data['userProfileDetails'] = $userProfileDetails;
				$this->data['recentActivityDetails'] = $this->user_model->get_activity_details($userProfileDetails->row()->id);

				$this->data['listDetails'] = $this->product_model->get_all_details(LISTS_DETAILS,array('user_id'=>$userProfileDetails->row()->id));
                
				if ($this->data['listDetails']->num_rows()>0){
					foreach ($this->data['listDetails']->result() as $listDetailsRow){
						$this->data['listImg'][$listDetailsRow->id] = '';
						if ($listDetailsRow->product_id != ''){
							$returnCnt['product_lists'] = $pidArr = array_filter(explode(',', $listDetailsRow->product_id));

							$returnCnt['prodDetails'][$listDetailsRow->id] = '';

							if (count($pidArr)>0){
								$product_id_str = '';
								foreach ($pidArr as $pid_row){
									if ($pid_row != ''){
										$product_id_str .= $pid_row.',';
									}
								}
								$product_id_str = substr($product_id_str, 0,-1);
								/*$Query = "select * from ".PRODUCT." where status='Publish' and quantity>0 and seller_product_id in (".$product_id_str.")";
								 $returnCnt['prodDetails'][$listDetailsRow->id] = $this->product_model->ExecuteQuery($Query);*/

								$addedProductDetails = $this->product_model->view_product_details(" where p.status='Publish' and p.seller_product_id in (".$product_id_str.")");
								$notSellProducts = $this->product_model->view_notsell_product_details(" where p.status='Publish' and p.seller_product_id in (".$product_id_str.")");
								$returnCnt['prodDetails'][$listDetailsRow->id] = $this->product_model->get_sorted_array($addedProductDetails,$notSellProducts,'created','desc');
							}
						}
					}
				}
					
				$this->data['product_lists']=$returnCnt['product_lists'];
				$this->data['prodDetails']=$returnCnt['prodDetails'];
				$this->load->view('site/user/display_user_lists',$this->data);
			}
		}else {
			redirect(base_url());
		}
	}

	public function display_user_stories(){
		$username =  $this->uri->segment(2,0);
		$userProfileDetails = $this->user_model->get_all_details(USERS,array('user_name'=>urldecode($username)));
		if ($userProfileDetails->num_rows()==1){
			if ($userProfileDetails->row()->visibility == 'Only you' && $userProfileDetails->row()->id != $this->checkLogin('U')){
				$this->load->view('site/user/display_user_profile_private',$this->data);
			}else {
				$this->data['heading'] = urldecode($username);
				$this->data['userProfileDetails'] = $userProfileDetails;
				$this->data['recentActivityDetails'] = $this->user_model->get_activity_details($userProfileDetails->row()->id);
				$condition='s.status ="Publish" and s.user_id="'.$userProfileDetails->row()->id.'"';
				$this->data['stories_details'] = $this->stories_model->get_all_StoresDetails($condition);

				if ($this->data['stories_details']->num_rows()>0){
					foreach($this->data['stories_details']->result() as $getstories_details){

						$this->data['ProductDetails'][$getstories_details->id] = '';
						if ($getstories_details->seller_product_id != ''){
							$this->data['ProductDetails'][$getstories_details->id]= $this->stories_model->get_all_StoriesProduct($getstories_details->seller_product_id);
						}

						$this->data['storiesComment'][$getstories_details->id] = '';

						$this->data['storiesComment'][$getstories_details->id] = $this->stories_model->view_stories_comments_details('where c.stories_id='.$getstories_details->id.' order by c.dateAdded desc ');

					}
				}
				$users_list = $this->stories_model->get_all_details(USERS,array('status'=>'Active'));
				$users_list_arr = array();
				if ($users_list->num_rows()>0){
					foreach ($users_list->result() as $row){
						$users_list_arr[] = $row->user_name;
					}
				}
				$this->data['users_list'] = $users_list_arr;
				//echo "<pre>"; print_r($this->data['users_list']);die;
				$this->load->view('site/user/display_user_stories',$this->data);
			}
		}else {
			redirect(base_url());
		}
	}


	public function display_user_wants(){
		$username =  $this->uri->segment(2,0);
		$userProfileDetails = $this->user_model->get_all_details(USERS,array('user_name'=>$username));
		if ($userProfileDetails->num_rows()==1){
			if ($userProfileDetails->row()->visibility == 'Only you' && $userProfileDetails->row()->id != $this->checkLogin('U')){
				$this->load->view('site/user/display_user_profile_private',$this->data);
			}else {
				$this->data['heading'] = $username;
				$this->data['userProfileDetails'] = $userProfileDetails;
				$this->data['recentActivityDetails'] = $this->user_model->get_activity_details($userProfileDetails->row()->id);
				$wantList = $this->user_model->get_all_details(WANTS_DETAILS,array('user_id'=>$userProfileDetails->row()->id));
				$this->data['wantProductDetails'] = $this->product_model->get_wants_product($wantList);
				$this->data['notSellProducts'] = $this->product_model->get_notsell_wants_product($wantList);
				$this->load->view('site/user/display_user_wants',$this->data);
			}
		}else {
			redirect(base_url());
		}
	}

	public function display_user_owns(){
		$username =  $this->uri->segment(2,0);
		$userProfileDetails = $this->user_model->get_all_details(USERS,array('user_name'=>$username));
		if ($userProfileDetails->num_rows()==1){
			if ($userProfileDetails->row()->visibility == 'Only you' && $userProfileDetails->row()->id != $this->checkLogin('U')){
				$this->load->view('site/user/display_user_profile_private',$this->data);
			}else {
				$this->data['heading'] = $username;
				$this->data['userProfileDetails'] = $userProfileDetails;
				$this->data['recentActivityDetails'] = $this->user_model->get_activity_details($userProfileDetails->row()->id);
				$productIdsArr = array_filter(explode(',', $userProfileDetails->row()->own_products));
				$productIds = '';
				if (count($productIdsArr)>0){
					foreach ($productIdsArr as $pidRow){
						if ($pidRow != ''){
							$productIds .= $pidRow.',';
						}
					}
					$productIds = substr($productIds, 0,-1);
				}
				if ($productIds != ''){
					$this->data['ownsProductDetails'] = $this->product_model->view_product_details(' where p.seller_product_id in ('.$productIds.') and p.status="Publish"');
					$this->data['notSellProducts'] = $this->product_model->view_notsell_product_details(' where p.seller_product_id in ('.$productIds.') and p.status="Publish"');
				}else {
					$this->data['addedProductDetails'] = '';
					$this->data['notSellProducts'] = '';
				}
				$this->load->view('site/user/display_user_owns',$this->data);
			}
		}else {
			redirect(base_url());
		}
	}

	public function display_user_following(){
		$username =  $this->uri->segment(2,0);
		$userProfileDetails = $this->user_model->get_all_details(USERS,array('user_name'=>$username));
		if ($userProfileDetails->num_rows()==1){
			if ($userProfileDetails->row()->visibility == 'Only you' && $userProfileDetails->row()->id != $this->checkLogin('U')){
				$this->load->view('site/user/display_user_profile_private',$this->data);
			}else {
				$this->data['heading'] = $username;
				$this->data['userProfileDetails'] = $userProfileDetails;
				$this->data['recentActivityDetails'] = $this->user_model->get_activity_details($userProfileDetails->row()->id);
				$fieldsArr = array('*');
				$searchName = 'id';
				$searchArr = explode(',', $userProfileDetails->row()->following);
				$joinArr = array();
				$sortArr = array();
				$limit = '';
				$this->data['followingUserDetails'] = $followingUserDetails = $this->product_model->get_fields_from_many(USERS,$fieldsArr,$searchName,$searchArr,$joinArr,$sortArr,$limit);
				if ($followingUserDetails->num_rows()>0){
					foreach ($followingUserDetails->result() as $followingUserRow){
						$this->data['followingUserLikeDetails'][$followingUserRow->id] = $this->product_model->get_products_by_userid($followingUserRow->id,'publish');
					}
				}
				$this->load->view('site/user/display_user_following',$this->data);
			}
		}else {
			redirect(base_url());
		}
	}

	public function display_user_followers(){
		$username =  $this->uri->segment(2,0);
		$userProfileDetails = $this->user_model->get_all_details(USERS,array('user_name'=>$username));
		if ($userProfileDetails->num_rows()==1){
			if ($userProfileDetails->row()->visibility == 'Only you' && $userProfileDetails->row()->id != $this->checkLogin('U')){
				$this->load->view('site/user/display_user_profile_private',$this->data);
			}else {
				$this->data['heading'] = $username;
				$this->data['userProfileDetails'] = $userProfileDetails;
				$this->data['recentActivityDetails'] = $this->user_model->get_activity_details($userProfileDetails->row()->id);
				$fieldsArr = array('*');
				$searchName = 'id';
				$searchArr = explode(',', $userProfileDetails->row()->followers);
				$joinArr = array();
				$sortArr = array();
				$limit = '';
				$this->data['followingUserDetails'] = $followingUserDetails = $this->product_model->get_fields_from_many(USERS,$fieldsArr,$searchName,$searchArr,$joinArr,$sortArr,$limit);
				if ($followingUserDetails->num_rows()>0){
					foreach ($followingUserDetails->result() as $followingUserRow){
						$this->data['followingUserLikeDetails'][$followingUserRow->id] = $this->product_model->get_products_by_userid($followingUserRow->id,'publish');
					}
				}
			//	echo '<pre>';print_r($this->data['followingUserLikeDetails']);die;
				$this->load->view('site/user/display_user_followers',$this->data);
			}
		}else {
			redirect(base_url());
		}
	}

	public function add_list_when_fancyy(){
		$returnStr['status_code'] = 0;
		$returnStr['listCnt'] = '';
		$returnStr['wanted'] = 0;
		$uniqueListNames = array();
		if ($this->checkLogin('U') == ''){
			$returnStr['message'] = 'Login required';
		}else {
			$tid = $this->input->post('tid');
			$firstCatName = '';
			$firstCatDetails = '';
			$count = 1;

			//Adding lists which was not already created from product categories
			$productDetails = $this->user_model->get_all_details(PRODUCT,array('seller_product_id'=>$tid));
			if ($productDetails->num_rows()==0){
				$productDetails = $this->user_model->get_all_details(USER_PRODUCTS,array('seller_product_id'=>$tid));
			}
			if ($productDetails->num_rows()==1){
				$productCatArr = explode(',', $productDetails->row()->category_id);
				if (count($productCatArr)>0){
					$productCatNameArr = array();
					foreach ($productCatArr as $productCatID){
						if ($productCatID != ''){
							$productCatDetails = $this->user_model->get_all_details(CATEGORY,array('id'=>$productCatID));
							if ($productCatDetails->num_rows()==1){
								if ($count == 1){
									$firstCatName = $productCatDetails->row()->cat_name;
								}
								$listConditionArr = array('name'=>$productCatDetails->row()->cat_name,'user_id'=>$this->checkLogin('U'));
								$listCheck = $this->user_model->get_all_details(LISTS_DETAILS,$listConditionArr);
								if ($count == 1){
									$firstCatDetails = $listCheck;
								}
								if ($listCheck->num_rows()==0){
									$this->user_model->simple_insert(LISTS_DETAILS,$listConditionArr);
									$userDetails = $this->user_model->get_all_details(USERS,array('id'=>$this->checkLogin('U')));
									$listCount = $userDetails->row()->lists;
									if ($listCount<0 || $listCount == ''){
										$listCount = 0;
									}
									$listCount++;
									$this->user_model->update_details(USERS,array('lists'=>$listCount),array('id'=>$this->checkLogin('U')));
								}
								$count++;
							}
						}
					}
				}
			}

			//Check the product id in list table
			$checkListsArr = $this->user_model->get_list_details($tid,$this->checkLogin('U'));

			if ($checkListsArr->num_rows() == 0){

				//Add the product id under the first category name
				if ($firstCatName!=''){
					$listConditionArr = array('name'=>$firstCatName,'user_id'=>$this->checkLogin('U'));
					if ($firstCatDetails == '' || $firstCatDetails->num_rows() == 0){
						$dataArr = array('product_id'=>$tid);
					}else {
						$productRowArr = explode(',', $firstCatDetails->row()->product_id);
						$productRowArr[] = $tid;
						$newProductRowArr = implode(',', $productRowArr);
						$dataArr = array('product_id'=>$newProductRowArr);
					}
					$this->user_model->update_details(LISTS_DETAILS,$dataArr,$listConditionArr);
					$listCntDetails = $this->user_model->get_all_details(LISTS_DETAILS,$listConditionArr);
					if ($listCntDetails->num_rows()==1){
						array_push($uniqueListNames, $listCntDetails->row()->id);
						$returnStr['listCnt'] .= '<li class="selected"><label for="'.$listCntDetails->row()->id.'"><input type="checkbox" checked="checked" id="'.$listCntDetails->row()->id.'" name="'.$listCntDetails->row()->id.'">'.$listCntDetails->row()->name.'</label></li>';
					}
				}
			}else {

				//Get all the lists which contain this product
				foreach ($checkListsArr->result() as $checkListsRow){
					array_push($uniqueListNames, $checkListsRow->id);
					$returnStr['listCnt'] .= '<li class="selected"><label for="'.$checkListsRow->id.'"><input type="checkbox" checked="checked" id="'.$checkListsRow->id.'" name="'.$checkListsRow->id.'">'.$checkListsRow->name.'</label></li>';
				}
			}
			$all_lists = $this->user_model->get_all_details(LISTS_DETAILS,array('user_id'=>$this->checkLogin('U')));
			if ($all_lists->num_rows()>0){
				foreach ($all_lists->result() as $all_lists_row){
					if (!in_array($all_lists_row->id, $uniqueListNames)){
						$returnStr['listCnt'] .= '<li><label for="'.$all_lists_row->id.'"><input type="checkbox" id="'.$all_lists_row->id.'" name="'.$all_lists_row->id.'">'.$all_lists_row->name.'</label></li>';
					}
				}
			}

			//Check the product wanted status
			$wantedProducts = $this->user_model->get_all_details(WANTS_DETAILS,array('user_id'=>$this->checkLogin('U')));
			if ($wantedProducts->num_rows()==1){
				$wantedProductsArr = explode(',', $wantedProducts->row()->product_id);
				if (in_array($tid, $wantedProductsArr)){
					$returnStr['wanted'] = 1;
				}
			}
			$returnStr['firstCatName'] = $firstCatName;
			$returnStr['status_code'] = 1;
		}
		echo json_encode($returnStr);
	}

	public function add_item_to_lists(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U')==''){
			$returnStr['message'] = 'You must login';
		}else {
			$tid = $this->input->post('tid');
			$lid = $this->input->post('list_ids');
			$listDetails = $this->user_model->get_all_details(LISTS_DETAILS,array('id'=>$lid));
			if ($listDetails->num_rows()==1){
				$product_ids = explode(',', $listDetails->row()->product_id);
				if (!in_array($tid, $product_ids)){
					array_push($product_ids, $tid);
				}
				$new_product_ids = implode(',', $product_ids);
				$this->user_model->update_details(LISTS_DETAILS,array('product_id'=>$new_product_ids),array('id'=>$lid));
				$returnStr['status_code'] = 1;
			}
		}
		echo json_encode($returnStr);
	}

	public function remove_item_from_lists(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U')==''){
			$returnStr['message'] = 'You must login';
		}else {
			$tid = $this->input->post('tid');
			$lid = $this->input->post('list_ids');
			$listDetails = $this->user_model->get_all_details(LISTS_DETAILS,array('id'=>$lid));
			if ($listDetails->num_rows()==1){
				$product_ids = explode(',', $listDetails->row()->product_id);
				if (in_array($tid, $product_ids)){
					if(($key = array_search($tid, $product_ids)) !== false) {
						unset($product_ids[$key]);
					}
				}
				$new_product_ids = implode(',', $product_ids);
				$this->user_model->update_details(LISTS_DETAILS,array('product_id'=>$new_product_ids),array('id'=>$lid));
				$returnStr['status_code'] = 1;
			}
		}
		echo json_encode($returnStr);
	}

	public function add_want_tag(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U')==''){
			$returnStr['message'] = 'You must login';
		}else {
			$tid = $this->input->post('thing_id');
			$wantDetails = $this->user_model->get_all_details(WANTS_DETAILS,array('user_id'=>$this->checkLogin('U')));
			if ($wantDetails->num_rows()==1){
				$product_ids = explode(',', $wantDetails->row()->product_id);
				if (!in_array($tid, $product_ids)){
					array_push($product_ids, $tid);
				}
				$new_product_ids = implode(',', $product_ids);
				$this->user_model->update_details(WANTS_DETAILS,array('product_id'=>$new_product_ids),array('user_id'=>$this->checkLogin('U')));
			}else {
				$dataArr = array('user_id'=>$this->checkLogin('U'),'product_id'=>$tid);
				$this->user_model->simple_insert(WANTS_DETAILS,$dataArr);
			}
			$wantCount = $this->data['userDetails']->row()->want_count;
			if ($wantCount<=0 || $wantCount==''){
				$wantCount = 0;
			}
			$wantCount++;
			$dataArr = array('want_count'=>$wantCount);
			$ownProducts = explode(',', $this->data['userDetails']->row()->own_products);
			if (in_array($tid, $ownProducts)){
				if (($key = array_search($tid, $ownProducts)) !== false){
					unset($ownProducts[$key]);
				}
				$ownCount = $this->data['userDetails']->row()->own_count;
				$ownCount--;
				$dataArr['own_count'] = $ownCount;
				$dataArr['own_products'] = implode(',', $ownProducts);
			}
			$this->user_model->update_details(USERS,$dataArr,array('id'=>$this->checkLogin('U')));
			$returnStr['status_code'] = 1;
		}
		echo json_encode($returnStr);
	}

	public function delete_want_tag(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U')==''){
			$returnStr['message'] = 'You must login';
		}else {
			$tid = $this->input->post('thing_id');
			$wantDetails = $this->user_model->get_all_details(WANTS_DETAILS,array('user_id'=>$this->checkLogin('U')));
			if ($wantDetails->num_rows()==1){
				$product_ids = explode(',', $wantDetails->row()->product_id);
				if (in_array($tid, $product_ids)){
					if(($key = array_search($tid, $product_ids)) !== false) {
						unset($product_ids[$key]);
					}
				}
				$new_product_ids = implode(',', $product_ids);
				$this->user_model->update_details(WANTS_DETAILS,array('product_id'=>$new_product_ids),array('user_id'=>$this->checkLogin('U')));
				$wantCount = $this->data['userDetails']->row()->want_count;
				if ($wantCount<=0 || $wantCount==''){
					$wantCount = 1;
				}
				$wantCount--;
				$this->user_model->update_details(USERS,array('want_count'=>$wantCount),array('id'=>$this->checkLogin('U')));
				$returnStr['status_code'] = 1;
			}
		}
		echo json_encode($returnStr);
	}

	public function create_list(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U')==''){
			$returnStr['message'] = 'You must login';
		}else {
			$tid = $this->input->post('tid');
			$list_name = $this->input->post('list_name');
			$category_id = $this->input->post('category_id');
			$checkList = $this->user_model->get_all_details(LISTS_DETAILS,array('name'=>$list_name,'user_id'=>$this->checkLogin('U')));
			if ($checkList->num_rows() == 0){
				$dataArr = array('user_id'=>$this->checkLogin('U'),'name'=>$list_name,'product_id'=>$tid);
				if ($category_id != ''){
					$dataArr['category_id'] = $category_id;
				}
				$this->user_model->simple_insert(LISTS_DETAILS,$dataArr);
				$returnStr['list_id'] = $this->user_model->get_last_insert_id();
				$userDetails = $this->user_model->get_all_details(USERS,array('id'=>$this->checkLogin('U')));
				$listCount = $userDetails->row()->lists;
				if ($listCount<0 || $listCount == ''){
					$listCount = 0;
				}
				$listCount++;
				$this->user_model->update_details(USERS,array('lists'=>$listCount),array('id'=>$this->checkLogin('U')));
				$returnStr['new_list'] = 1;
			}else {
				$productArr = explode(',', $checkList->row()->product_id);
				if (!in_array($tid, $productArr)){
					array_push($productArr, $tid);
				}
				$product_id = implode(',', $productArr);
				$dataArr = array('product_id'=>$product_id);
				if ($category_id != ''){
					$dataArr['category_id'] = $category_id;
				}
				$this->user_model->update_details(LISTS_DETAILS,$dataArr,array('user_id'=>$this->checkLogin('U'),'name'=>$list_name));
				$returnStr['list_id'] = $checkList->row()->id;
				$returnStr['new_list'] = 0;
			}
			$returnStr['status_code'] = 1;
		}
		echo json_encode($returnStr);
	}

	public function search_users(){
		$search_key = $this->input->post('term');
		$returnStr = array();
		if ($search_key != ''){
			$userList = $this->user_model->get_search_user_list($search_key,$this->checkLogin('U'));
			if ($userList->num_rows()>0){
				$i=0;
				foreach ($userList->result() as $userRow){
					$userArr['id'] = $userRow->id;
					$userArr['fullname'] = $userRow->full_name;
					$userArr['username'] = $userRow->user_name;
					if ($userRow->thumbnail != ''){
						$userArr['image_url'] = 'images/users/'.$userRow->thumbnail;
					}else {
						$userArr['image_url'] = 'images/users/user-thumb1.png';
					}
					array_push($returnStr, $userArr);
					$i++;
				}
			}
		}
		echo json_encode($returnStr);
	}

	public function seller_signup_form(){
		if ($this->checkLogin('U')==''){
			redirect(base_url());
		}else {
			if ($this->data['userDetails']->row()->is_verified == 'No'){
				$this->setErrorMessage('error','Please confirm your email first');
				redirect(base_url().'trending');
			}else {
				$this->data['heading'] = 'Seller Signup';
				$this->load->view('site/user/seller_register',$this->data);
			}
		}
	}

	public function create_brand_form(){
		if ($this->checkLogin('U')==''){
			redirect(base_url());
		}else {
			$this->data['heading'] = 'Seller Signup';
			$this->load->view('site/user/seller_register',$this->data);
		}
	}



	public function seller_signup(){
		if ($this->checkLogin('U')==''){
			redirect(base_url());
		}else {
			if ($this->data['userDetails']->row()->is_verified == 'No'){
				$this->setErrorMessage('error','Please confirm your email first');
				redirect('create-brand');

			}else {
				$dataArr = array(
					'request_status'	=>	'Pending'
					);
					$this->user_model->commonInsertUpdate(USERS,'update',array(),$dataArr,array('id'=>$this->checkLogin('U')));
					$this->setErrorMessage('success','Welcome onboard ! Our team is evaluating your request. We will contact you shortly');
					redirect(base_url());
			}
		}
	}

	public function find_friends_twitter(){
		$returnStr['status_code'] = 1;
		$returnStr['url'] = base_url().'twtest/invite_friends';
		$returnStr['message'] = '';
		echo json_encode($returnStr);
	}

	public function view_purchase(){
		if ($this->checkLogin('U') == ''){
			show_404();
		}else {
			$uid = $this->uri->segment(2,0);
			$dealCode = $this->uri->segment(3,0);
			if ($uid != $this->checkLogin('U')){
				show_404();
			}else {
				$purchaseList = $this->user_model->get_purchase_list($uid,$dealCode);
				$invoice = $this->get_invoice($purchaseList);
				echo $invoice;
			}
		}
	}

	public function view_order(){
		if ($this->checkLogin('U') == ''){
			show_404();
		}else {
			$uid = $this->uri->segment(2,0);
			$dealCode = $this->uri->segment(3,0);
			if ($uid != $this->checkLogin('U')){
				show_404();
			}else {
				$orderList = $this->user_model->get_order_list($uid,$dealCode);
				$invoice = $this->get_invoice($orderList);
				echo $invoice;
			}
		}
	}

	public function get_invoice($PrdList){
		$shipAddRess = $this->user_model->get_all_details(SHIPPING_ADDRESS,array( 'id' => $PrdList->row()->shippingid ));
		$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width"/></head>
<title>Product Order Confirmation</title>
<body>
<div style="width:1012px;background:#FFFFFF; margin:0 auto;">
<div style="width:100%;background:#454B56; float:left; margin:0 auto;">
    <div style="padding:20px 0 10px 15px;float:left; width:50%;"><a href="'.base_url().'" target="_blank" id="logo"><img src="'.base_url().'images/logo/'.$this->data['logo'].'" alt="'.$this->data['WebsiteTitle'].'" title="'.$this->data['WebsiteTitle'].'"></a></div>
	
</div>			
<!--END OF LOGO-->
    
 <!--start of deal-->
    <div style="width:970px;background:#FFFFFF;float:left; padding:20px; border:1px solid #454B56; ">
    
	<div style=" float:right; width:35%; margin-bottom:20px; margin-right:7px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #cecece;">
			  <tr bgcolor="#f3f3f3">
                <td width="87"  style="border-right:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:center; width:100%; font-weight:bold; color:#000000; line-height:38px; float:left;">Order Id</span></td>
                <td  width="100"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:38px; text-align:center; width:100%; float:left;">#'.$PrdList->row()->dealCodeNumber.'</span></td>
              </tr>
              <tr bgcolor="#f3f3f3">
                <td width="87"  style="border-right:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:center; width:100%; font-weight:bold; color:#000000; line-height:38px; float:left;">Order Date</span></td>
                <td  width="100"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:38px; text-align:center; width:100%; float:left;">'.date("F j, Y g:i a",strtotime($PrdList->row()->created)).'</span></td>
              </tr>
			 
              </table>
        	</div>
		
    <div style="float:left; width:100%;">
	
    <div style="width:49%; float:left; border:1px solid #cccccc; margin-right:10px;">
    	<span style=" border-bottom:1px solid #cccccc; background:#f3f3f3; width:95.8%; float:left; padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000305;">Shipping Address</span>
    		<div style="float:left; padding:10px; width:96%;  font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#030002; line-height:28px;">
            	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                	<tr><td>Full Name</td><td>:</td><td>'.stripslashes($shipAddRess->row()->full_name).'</td></tr>
                    <tr><td>Address</td><td>:</td><td>'.stripslashes($shipAddRess->row()->address1).'</td></tr>
					<tr><td>Address 2</td><td>:</td><td>'.stripslashes($shipAddRess->row()->address2).'</td></tr>
					<tr><td>City</td><td>:</td><td>'.stripslashes($shipAddRess->row()->city).'</td></tr>
					<tr><td>Country</td><td>:</td><td>'.stripslashes($shipAddRess->row()->country).'</td></tr>
					<tr><td>State</td><td>:</td><td>'.stripslashes($shipAddRess->row()->state).'</td></tr>
					<tr><td>Zipcode</td><td>:</td><td>'.stripslashes($shipAddRess->row()->postal_code).'</td></tr>
					<tr><td>Phone Number</td><td>:</td><td>'.stripslashes($shipAddRess->row()->phone).'</td></tr>
            	</table>
            </div>
     </div>
    
    <div style="width:49%; float:left; border:1px solid #cccccc;">
    	<span style=" border-bottom:1px solid #cccccc; background:#f3f3f3; width:95.7%; float:left; padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000305;">Billing Address</span>
    		<div style="float:left; padding:10px; width:96%;  font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#030002; line-height:28px;">
            	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                	<tr><td>Full Name</td><td>:</td><td>'.stripslashes($PrdList->row()->full_name).'</td></tr>
                    <tr><td>Address</td><td>:</td><td>'.stripslashes($PrdList->row()->address).'</td></tr>
					<tr><td>Address 2</td><td>:</td><td>'.stripslashes($PrdList->row()->address2).'</td></tr>
					<tr><td>City</td><td>:</td><td>'.stripslashes($PrdList->row()->city).'</td></tr>
					<tr><td>Country</td><td>:</td><td>'.stripslashes($PrdList->row()->country).'</td></tr>
					<tr><td>State</td><td>:</td><td>'.stripslashes($PrdList->row()->state).'</td></tr>
					<tr><td>Zipcode</td><td>:</td><td>'.stripslashes($PrdList->row()->postal_code).'</td></tr>
					<tr><td>Phone Number</td><td>:</td><td>'.stripslashes($PrdList->row()->phone_no).'</td></tr>
            	</table>
            </div>
    </div>
</div> 
	   
<div style="float:left; width:100%; margin-right:3%; margin-top:10px; font-size:14px; font-weight:normal; line-height:28px;  font-family:Arial, Helvetica, sans-serif; color:#000; overflow:hidden;">   
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    	<td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #cecece; width:99.5%;">
        <tr bgcolor="#f3f3f3">
        	<td width="17%" style="border-right:1px solid #cecece; text-align:center;"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center;">Bag Items</span></td>
            <td width="43%" style="border-right:1px solid #cecece;text-align:center;"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center;">Product Name</span></td>
            <td width="12%" style="border-right:1px solid #cecece;text-align:center;"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center;">Qty</span></td>
            <td width="14%" style="border-right:1px solid #cecece;text-align:center;"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center;">Unit Price</span></td>
            <td width="15%" style="text-align:center;"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center;">Sub Total</span></td>
         </tr>';	   
			
		$disTotal =0; $grantTotal = 0;
		foreach ($PrdList->result() as $cartRow) { $InvImg = @explode(',',$cartRow->image);
		$unitPrice = ($cartRow->price*(0.01*$cartRow->product_tax_cost))+$cartRow->product_shipping_cost+$cartRow->price;
		$uTot = $unitPrice*$cartRow->quantity;
		if($cartRow->attr_name != '' || $cartRow->attr_type){ $atr = '<br>'.$cartRow->attr_type.' / '.$cartRow->attr_name; }else{ $atr = '';}
		$message.='<tr>
            <td style="border-right:1px solid #cecece; text-align:center;border-top:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:30px;  text-align:center;"><img src="'.base_url().PRODUCTPATH.$InvImg[0].'" alt="'.stripslashes($cartRow->product_name).'" width="70" /></span></td>
			<td style="border-right:1px solid #cecece;text-align:center;border-top:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:30px;  text-align:center;">'.stripslashes($cartRow->product_name).$atr.'</span></td>
            <td style="border-right:1px solid #cecece;text-align:center;border-top:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:30px;  text-align:center;">'.strtoupper($cartRow->quantity).'</span></td>
            <td style="border-right:1px solid #cecece;text-align:center;border-top:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:30px;  text-align:center;">'.$this->data['currencySymbol'].number_format($unitPrice,2,'.','').'</span></td>
            <td style="text-align:center;border-top:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:30px;  text-align:center;">'.$this->data['currencySymbol'].number_format($uTot,2,'.','').'</span></td>
        </tr>';
		$grantTotal = $grantTotal + $uTot;
		}
		$private_total = $grantTotal - $PrdList->row()->discountAmount;
		$private_total = $private_total + $PrdList->row()->tax  + $PrdList->row()->shippingcost;
			
		$message.='</table></td> </tr><tr><td colspan="3"><table border="0" cellspacing="0" cellpadding="0" style=" margin:10px 0px; width:99.5%;"><tr>
			<td width="460" valign="top" >';
		if($PrdList->row()->note !=''){
			$message.='<table width="97%" border="0"  cellspacing="0" cellpadding="0"><tr>
                <td width="87" ><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:left; width:100%; font-weight:bold; color:#000000; line-height:38px; float:left;">Note:</span></td>
               
            </tr>
			<tr>
                <td width="87"  style="border:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:left; width:97%; color:#000000; line-height:24px; float:left; margin:10px;">'.stripslashes($PrdList->row()->note).'</span></td>
            </tr></table>';
		}
			
		if($PrdList->row()->order_gift == 1){
			$message.='<table width="97%" border="0"  cellspacing="0" cellpadding="0"  style="margin-top:10px;"><tr>
                <td width="87"  style="border:1px solid #cecece;"><span style="font-size:16px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; text-align:center; width:97%; color:#000000; line-height:24px; float:left; margin:10px;">This Order is a gift</span></td>
            </tr></table>';
		}
			
		$message.='</td>
            <td width="174" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #cecece;">
            <tr bgcolor="#f3f3f3">
                <td width="87"  style="border-right:1px solid #cecece;border-bottom:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:center; width:100%; font-weight:bold; color:#000000; line-height:38px; float:left;">Sub Total</span></td>
                <td  style="border-bottom:1px solid #cecece;" width="69"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:38px; text-align:center; width:100%; float:left;">'.$this->data['currencySymbol'].number_format($grantTotal,'2','.','').'</span></td>
            </tr>
			<tr>
                <td width="87"  style="border-right:1px solid #cecece;border-bottom:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:center; width:100%; font-weight:bold; color:#000000; line-height:38px; float:left;">Discount Amount</span></td>
                <td  style="border-bottom:1px solid #cecece;" width="69"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:38px; text-align:center; width:100%; float:left;">'.$this->data['currencySymbol'].number_format($PrdList->row()->discountAmount,'2','.','').'</span></td>
            </tr>
		<tr bgcolor="#f3f3f3">
            <td width="31" style="border-right:1px solid #cecece;border-bottom:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; text-align:center; width:100%; color:#000000; line-height:38px; float:left;">Shipping Cost</span></td>
                <td  style="border-bottom:1px solid #cecece;" width="69"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:38px; text-align:center; width:100%;  float:left;">'.$this->data['currencySymbol'].number_format($PrdList->row()->shippingcost,2,'.','').'</span></td>
              </tr>
			  <tr>
            <td width="31" style="border-right:1px solid #cecece;border-bottom:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; text-align:center; width:100%; color:#000000; line-height:38px; float:left;">Shipping Tax</span></td>
                <td  style="border-bottom:1px solid #cecece;" width="69"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:38px; text-align:center; width:100%;  float:left;">'.$this->data['currencySymbol'].number_format($PrdList->row()->tax ,2,'.','').'</span></td>
              </tr>
			  <tr bgcolor="#f3f3f3">
                <td width="87" style="border-right:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center; width:100%; float:left;">Grand Total</span></td>
                <td width="31"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:38px; text-align:center; width:100%;  float:left;">'.$this->data['currencySymbol'].number_format($private_total,'2','.','').'</span></td>
              </tr>
            </table></td>
            </tr>
        </table></td>
        </tr>
    </table>
        </div>
        
        <!--end of left--> 
		
            
            <div style="width:27.4%; margin-right:5px; float:right;">
            
           
            </div>
        
        <div style="clear:both"></div>
        
    </div>
    </div></body></html>';
		return $message;
	}

	public function change_order_status(){
		if ($this->checkLogin('U') == ''){
			show_404();
		}else {
			$uid = $this->input->post('seller');
			if ($uid != $this->checkLogin('U')){
				show_404();
			}else {
				$returnStr['status_code'] = 0;
				$dealCode = $this->input->post('dealCode');
				$status = $this->input->post('value');
				$dataArr = array('shipping_status'=>$status);
				$conditionArr = array('dealCodeNumber'=>$dealCode,'sell_id'=>$uid);
				$this->user_model->update_details(PAYMENT,$dataArr,$conditionArr);
				$returnStr['status_code'] = 1;
				echo json_encode($returnStr);
			}
		}
	}

	public function display_user_lists_home(){
		$lid = $this->uri->segment('4','0');
		$uname = $this->uri->segment('2','0');
		$this->data['userProfileDetails'] =	$this->data['user_profile_details'] = $userProfileDetails = $this->user_model->get_all_details(USERS,array('user_name'=>$uname));
		if ($userProfileDetails->row()->visibility == 'Only you' && $userProfileDetails->row()->id != $this->checkLogin('U')){
			$this->load->view('site/user/display_user_profile_private',$this->data);
		}else {
			$this->data['list_details'] = $list_details = $this->product_model->get_all_details(LISTS_DETAILS,array('id'=>$lid,'user_id'=>$this->data['user_profile_details']->row()->id));
			if ($this->data['list_details']->num_rows()==0){
				show_404();
			}else {
				$searchArr = array_filter(explode(',', $list_details->row()->product_id));
				if (count($searchArr)>0){
					$fieldsArr = array(PRODUCT.'.*',USERS.'.user_name',USERS.'.full_name');
					$condition = array(PRODUCT.'.status'=>'Publish');
					$joinArr1 = array('table'=>USERS,'on'=>USERS.'.id='.PRODUCT.'.user_id','type'=>'');
					$joinArr = array($joinArr1);
					$this->data['product_details'] = $product_details = $this->product_model->get_fields_from_many(PRODUCT,$fieldsArr,PRODUCT.'.seller_product_id',$searchArr,$joinArr,'','',$condition);
					$this->data['totalProducts'] = count($searchArr);
					$fieldsArr = array(USER_PRODUCTS.'.*',USERS.'.user_name',USERS.'.full_name');
					$condition = array(USER_PRODUCTS.'.status'=>'Publish');
					$joinArr1 = array('table'=>USERS,'on'=>USERS.'.id='.USER_PRODUCTS.'.user_id','type'=>'');
					$joinArr = array($joinArr1);
					$this->data['notsell_product_details'] = $this->product_model->get_fields_from_many(USER_PRODUCTS,$fieldsArr,USER_PRODUCTS.'.seller_product_id',$searchArr,$joinArr,'','',$condition);
				}else {
					$this->data['notsell_product_details'] = '';
					$this->data['product_details'] = '';
					$this->data['totalProducts'] = 0;
				}
				$this->load->view('site/user/user_list_home',$this->data);
			}
		}
	}

	public function display_user_lists_followers(){
		$lid = $this->uri->segment('4','0');
		$uname = $this->uri->segment('2','0');
		$this->data['user_profile_details'] = $userProfileDetails = $this->user_model->get_all_details(USERS,array('user_name'=>$uname));
		if ($userProfileDetails->row()->visibility == 'Only you' && $userProfileDetails->row()->id != $this->checkLogin('U')){
			$this->load->view('site/user/display_user_profile_private',$this->data);
		}else {
			$this->data['list_details'] = $list_details = $this->product_model->get_all_details(LISTS_DETAILS,array('id'=>$lid,'user_id'=>$this->data['user_profile_details']->row()->id));
			if ($this->data['list_details']->num_rows()==0){
				show_404();
			}else {
				$fieldsArr = '*';
				$searchArr = explode(',', $list_details->row()->followers);
				$this->data['user_details'] = $user_details = $this->product_model->get_fields_from_many(USERS,$fieldsArr,'id',$searchArr);
				if ($user_details->num_rows()>0){
					foreach ($user_details->result() as $userRow){
						$fieldsArr = array(PRODUCT_LIKES.'.*',PRODUCT.'.product_name',PRODUCT.'.image',PRODUCT.'.id as PID');
						$searchArr = array($userRow->id);
						$joinArr1 = array('table'=>PRODUCT,'on'=>PRODUCT_LIKES.'.product_id='.PRODUCT.'.seller_product_id','type'=>'');
						$joinArr = array($joinArr1);
						$sortArr1 = array('field'=>PRODUCT.'.created','type'=>'desc');
						$sortArr = array($sortArr1);
						$this->data['product_details'][$userRow->id] = $this->product_model->get_fields_from_many(PRODUCT_LIKES,$fieldsArr,PRODUCT_LIKES.'.user_id',$searchArr,$joinArr,$sortArr,'5');
					}
				}
				$fieldsArr = array(PRODUCT.'.*',USERS.'.user_name',USERS.'.full_name');
				$searchArr = array_filter(explode(',', $list_details->row()->product_id));
				if (count($searchArr)>0){
					$this->data['totalProducts'] = count($searchArr);
				}else {
					$this->data['totalProducts'] = 0;
				}

				$this->load->view('site/user/user_list_followers',$this->data);
			}
		}
	}

	public function follow_list(){
		$returnStr['status_code'] = 0;
		$lid = $this->input->post('lid');
		if ($this->checkLogin('U') != ''){
			$listDetails = $this->product_model->get_all_details(LISTS_DETAILS,array('id'=>$lid));
			$followersArr = explode(',', $listDetails->row()->followers);
			$followersCount = $listDetails->row()->followers_count;
			$oldDetails = explode(',', $this->data['userDetails']->row()->following_user_lists);
			if (!in_array($lid, $oldDetails)){
				array_push($oldDetails, $lid);
			}
			if (!in_array($this->checkLogin('U'), $followersArr)){
				array_push($followersArr, $this->checkLogin('U'));
				$followersCount++;
			}
			$this->product_model->update_details(USERS,array('following_user_lists'=>implode(',', $oldDetails)),array('id'=>$this->checkLogin('U')));
			$this->product_model->update_details(LISTS_DETAILS,array('followers'=>implode(',', $followersArr),'followers_count'=>$followersCount),array('id'=>$lid));
			$returnStr['status_code'] = 1;
		}
		echo json_encode($returnStr);
	}

	public function unfollow_list(){
		$returnStr['status_code'] = 0;
		$lid = $this->input->post('lid');
		if ($this->checkLogin('U') != ''){
			$listDetails = $this->product_model->get_all_details(LISTS_DETAILS,array('id'=>$lid));
			$followersArr = explode(',', $listDetails->row()->followers);
			$followersCount = $listDetails->row()->followers_count;
			$oldDetails = explode(',', $this->data['userDetails']->row()->following_user_lists);
			if (in_array($lid, $oldDetails)){
				if ($key = array_search($lid, $oldDetails) !== false){
					unset($oldDetails[$key]);
				}
			}
			if (in_array($this->checkLogin('U'), $followersArr)){
				if ($key = array_search($this->checkLogin('U'), $followersArr) !== false){
					unset($followersArr[$key]);
				}
				$followersCount--;
			}
			$this->product_model->update_details(USERS,array('following_user_lists'=>implode(',', $oldDetails)),array('id'=>$this->checkLogin('U')));
			$this->product_model->update_details(LISTS_DETAILS,array('followers'=>implode(',', $followersArr),'followers_count'=>$followersCount),array('id'=>$lid));
			$returnStr['status_code'] = 1;
		}
		echo json_encode($returnStr);
	}

	public function edit_user_lists(){
		if ($this->checkLogin('U') == ''){
			redirect('login');
		}else {
			$lid = $this->uri->segment('4','0');
			$uname = $this->uri->segment('2','0');
			if ($uname != $this->data['userDetails']->row()->user_name){
				show_404();
			}else {
				$this->data['user_profile_details'] = $this->user_model->get_all_details(USERS,array('user_name'=>$uname));
				$this->data['list_details'] = $list_details = $this->product_model->get_all_details(LISTS_DETAILS,array('id'=>$lid,'user_id'=>$this->data['user_profile_details']->row()->id));
				if ($this->data['list_details']->num_rows()==0){
					show_404();
				}else {
					$this->data['list_category_details'] = $this->user_model->get_all_details(CATEGORY,array('id'=>$this->data['list_details']->row()->category_id));
					$this->data['heading'] = 'Edit List';
					$this->load->view('site/user/edit_user_list',$this->data);
				}
			}
		}
	}

	public function edit_user_list_details(){
		if ($this->checkLogin('U') == ''){
			redirect('login');
		}else {
			$lid = $this->input->post('lid');
			$uid = $this->input->post('uid');
			if ($uid != $this->checkLogin('U')){
				show_404();
			}else {
				$list_title = $this->input->post('setting-title');
				$catID = $this->input->post('category');
				$duplicateCheck = $this->user_model->get_all_details(LISTS_DETAILS,array('user_id'=>$uid,'id !='=>$lid,'name'=>$list_title));
				if ($duplicateCheck->num_rows()>0){
					$this->setErrorMessage('error','List title already exists');
					echo '<script>window.history.go(-1);</script>';
				}else {
					if ($catID == ''){
						$catID = 0;
					}
					$this->user_model->update_details(LISTS_DETAILS,array('name'=>$list_title,'category_id'=>$catID),array('id'=>$lid,'user_id'=>$uid));
					$this->setErrorMessage('success','List updated successfully');
					echo '<script>window.history.go(-1);</script>';
				}
			}
		}
	}

	public function delete_user_list(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U')==''){
			$returnStr['message'] = 'Login required';
		}else {
			$lid = $this->input->post('lid');
			$uid = $this->input->post('uid');
			if ($uid != $this->checkLogin('U')){
				$returnStr['message'] = 'You can\'t delete other\'s list';
			}else {
				$list_details = $this->user_model->get_all_details(LISTS_DETAILS,array('id'=>$lid,'user_id'=>$uid));
				if ($list_details->num_rows() == 1){
					$followers_id = $list_details->row()->followers;
					if ($followers_id != ''){
						$searchArr = array_filter(explode(',', $followers_id));
						$fieldsArr = array('following_user_lists','id');
						$followersArr = $this->user_model->get_fields_from_many(USERS,$fieldsArr,'id',$searchArr);
						if ($followersArr->num_rows()>0){
							foreach ($followersArr->result() as $followersRow){
								$listArr = array_filter(explode(',', $followersRow->following_user_lists));
								if (in_array($lid, $listArr)){
									if (($key = array_search($lid, $listArr)) != false){
										unset($listArr[$key]);
										$this->user_model->update_details(USERS,array('following_user_lists'=>implode(',', $listArr)),array('id'=>$followersRow->id));
									}
								}
							}
						}
					}
					$this->user_model->commonDelete(LISTS_DETAILS,array('id'=>$lid,'user_id'=>$this->checkLogin('U')));
					$listCount = $this->data['userDetails']->row()->lists;
					$listCount--;
					if ($listCount == '' || $listCount < 0){
						$listCount = 0;
					}
					$this->user_model->update_details(USERS,array('lists'=>$listCount),array('id'=>$this->checkLogin('U')));
					$returnStr['url'] = base_url().'user/'.$this->data['userDetails']->row()->user_name.'/lists';
					$this->setErrorMessage('success','List deleted successfully');
					$returnStr['status_code'] = 1;
				}else {
					$returnStr['message'] = 'List not available';
				}
			}
		}
		echo json_encode($returnStr);
	}

	public function image_crop(){
		if($this->checkLogin('U') == ''){
			redirect('login');
		}else {
			$uid = $this->uri->segment(2,0);
			if ($uid != $this->checkLogin('U')){
				show_404();
			}else {
				if ($this->session->userdata('img_crop') == 1){
					$this->data['heading'] = 'Cropping Image';
					$this->load->view('site/user/crop_image',$this->data);
				}else {
					$this->session->set_userdata('img_crop',1);
					redirect($this->uri->uri_string());
				}
			}
		}
	}

	public function image_crop_process(){
		if($this->checkLogin('U') == ''){
			redirect('login');
		}else {
			$targ_w = $targ_h = 240;
			$jpeg_quality = 90;

			$src = 'images/users/'.$this->data['userDetails']->row()->thumbnail;
			$ext = substr($src, strpos($src , '.')+1);
			if ($ext == 'png'){
				$jpgImg = imagecreatefrompng($src);
				imagejpeg($jpgImg, $src, 90);
			}
			$img_r = imagecreatefromjpeg($src);
			$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

			//			list($width, $height) = getimagesize($src);

			imagecopyresampled($dst_r,$img_r,0,0,$_POST['x1'],$_POST['y1'],	$targ_w,$targ_h,$_POST['w'],$_POST['h']);
			//		imagecopyresized($dst_r,$img_r,0,0,$_POST['x1'],$_POST['y1'],	$targ_w,$targ_h,$_POST['w'],$_POST['h']);
			//		imagecopyresized($dst_r, $img_r,0,0, $_POST['x1'],$_POST['y1'], $_POST['x2'],$_POST['y2'],1024,980);
			//			header('Content-type: image/jpeg');
			imagejpeg($dst_r,'images/users/'.$this->data['userDetails']->row()->thumbnail);
			$this->setErrorMessage('success','Profile photo changed successfully');
			redirect('user/'.$this->data['userDetails']->row()->user_name);
			exit;
		}
	}

	public function send_noty_mail($followUserDetails=array()){
		if (count($followUserDetails)>0){
			$emailNoty = explode(',', $followUserDetails[0]['email_notifications']);
			if (in_array('following', $emailNoty)){
				$newsid='7';
				$template_values=$this->product_model->get_newsletter_template_details($newsid);
				$adminnewstemplateArr=array('logo'=> $this->data['logo'],'meta_title'=>$this->config->item('meta_title'),'full_name'=>$followUserDetails[0]['full_name'],'cfull_name'=>$this->data['userDetails']->row()->full_name,'user_name'=>$this->data['userDetails']->row()->user_name);
				extract($adminnewstemplateArr);
				$subject = 'From: '.$this->config->item('email_title').' - '.$template_values['news_subject'];
				$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>'.$template_values['news_subject'].'</title><body>';
				include('./newsletter/registeration'.$newsid.'.php');

				$message .= '</body>
			</html>';


				if($template_values['sender_name']=='' && $template_values['sender_email']==''){
					$sender_email=$this->data['siteContactMail'];
					$sender_name=$this->data['siteTitle'];
				}else{
					$sender_name=$template_values['sender_name'];
					$sender_email=$template_values['sender_email'];
				}

				$email_values = array('mail_type'=>'html',
                                    'from_mail_id'=>$sender_email,
                                    'mail_name'=>$sender_name,
									'to_mail_id'=>$followUserDetails[0]['email'],
									'subject_message'=>$subject,
									'body_messages'=>$message
				);
				$email_send_to_common = $this->product_model->common_email_send($email_values);
			}
		}
	}

	public function send_noty_mails($followUserDetails=array()){
		if (count($followUserDetails)>0){
			$emailNoty = explode(',', $followUserDetails->email_notifications);
			if (in_array('following', $emailNoty)){

				$newsid='9';
				$template_values=$this->product_model->get_newsletter_template_details($newsid);
				$adminnewstemplateArr=array('logo'=> $this->data['logo'],'meta_title'=>$this->config->item('meta_title'),'full_name'=>$followUserDetails[0]['full_name'],'cfull_name'=>$this->data['userDetails']->row()->full_name,'user_name'=>$this->data['userDetails']->row()->user_name);
				extract($adminnewstemplateArr);
				$subject = 'From: '.$this->config->item('email_title').' - '.$template_values['news_subject'];
				$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>'.$template_values['news_subject'].'</title><body>';
				include('./newsletter/registeration'.$newsid.'.php');

				$message .= '</body>
			</html>';

				if($template_values['sender_name']=='' && $template_values['sender_email']==''){
					$sender_email=$this->data['siteContactMail'];
					$sender_name=$this->data['siteTitle'];
				}else{
					$sender_name=$template_values['sender_name'];
					$sender_email=$template_values['sender_email'];
				}

				$email_values = array('mail_type'=>'html',
                                    'from_mail_id'=>$sender_email,
                                    'mail_name'=>$sender_name,
									'to_mail_id'=>$followUserDetails->email,
									'subject_message'=>$subject,
									'body_messages'=>$message
				);
				$email_send_to_common = $this->product_model->common_email_send($email_values);
			}
		}
	}

	public function order_review(){
		if ($this->checkLogin('U')==''){
			show_404();
		}else {
			$uid = $this->uri->segment(2,0);
			$sid = $this->uri->segment(3,0);
			$dealCode = $this->uri->segment(4,0);
			if ($uid == $this->checkLogin('U')){
				$view_mode = 'user';
			}else if ($sid == $this->checkLogin('U')){
				$view_mode = 'seller';
			}else {
				$view_mode = '';
			}
			if ($view_mode == ''){
				show_404();
			}else {
				if ($view_mode == 'seller'){
					$this->db->select('p.*,pAr.attr_name as attr_type,sp.attr_name');
					$this->db->from(PAYMENT.' as p');
					$this->db->join(SUBPRODUCT.' as sp' , 'sp.pid = p.attribute_values','left');
					$this->db->join(PRODUCT_ATTRIBUTE.' as pAr' , 'pAr.id = sp.attr_id','left');
					$this->db->where('p.sell_id = "'.$sid.'" and p.status = "Paid" and p.dealCodeNumber = "'.$dealCode.'"');
					$order_details = $this->db->get();
					//$order_details = $this->user_model->get_all_details(PAYMENT,array('dealCodeNumber'=>$dealCode,'status'=>'Paid','sell_id'=>$sid));
				}else {
					$this->db->select('p.*,pAr.attr_name as attr_type,sp.attr_name');
					$this->db->from(PAYMENT.' as p');
					$this->db->join(SUBPRODUCT.' as sp' , 'sp.pid = p.attribute_values','left');
					$this->db->join(PRODUCT_ATTRIBUTE.' as pAr' , 'pAr.id = sp.attr_id','left');
					$this->db->where("p.status = 'Paid' and p.dealCodeNumber = '".$dealCode."'");
					$order_details = $this->db->get();
					//$order_details = $this->user_model->get_all_details(PAYMENT,array('dealCodeNumber'=>$dealCode,'status'=>'Paid'));
				}
				if ($order_details->num_rows()==0){
					show_404();
				}else {
					if ($view_mode == 'user'){
						$this->data['user_details'] = $this->data['userDetails'];
						$this->data['seller_details'] = $this->user_model->get_all_details(USERS,array('id'=>$sid));
					}elseif ($view_mode == 'seller'){
						$this->data['user_details'] = $this->user_model->get_all_details(USERS,array('id'=>$uid));
						$this->data['seller_details'] = $this->data['userDetails'];
					}
					foreach ($order_details->result() as $order_details_row){
						$this->data['prod_details'][$order_details_row->product_id] = $this->user_model->get_all_details(PRODUCT,array('id'=>$order_details_row->product_id));
					}
					$this->data['view_mode'] = $view_mode;
					$this->data['order_details'] = $order_details;
					$sortArr1 = array('field'=>'date','type'=>'desc');
					$sortArr = array($sortArr1);
					$this->data['order_comments'] = $this->user_model->get_all_details(REVIEW_COMMENTS,array('deal_code'=>$dealCode),$sortArr);
					$this->load->view('site/user/display_order_reviews',$this->data);
				}
			}
		}
	}

	/********* Coding for display add feedback form for user product *********/

	public function display_user_product_feedback($product_id)
	{
		if ($this->checkLogin('U')==''){
			redirect('login');
		}else {
			$id =  array('id'=>$product_id);
			$this->data['userVal'] = $this->product_model->get_all_details(PRODUCT,$id);
			$this->data['feedback_details'] = $this->product_model->get_all_details(PRODUCT_FEEDBACK,array('voter_id'=>$this->checkLogin('U'),'product_id'=>$product_id));
			$this->load->view('site/user/add_user_product_feedback',$this->data);
		}
	}

	/********* Coding for add feedback for user product *********/

	public function add_user_product_feedback()
	{
		$user_id = $this->input->post('rate');
		$rating = $this->input->post('rating_value');
		$title = $this->input->post('title');
		$description = $this->input->post('description');
		$product_id = $this->input->post('product_id');
		$seller_id = $this->input->post('seller_id');
		if($user_id!='')
		{
			$this->user_model->simple_insert(PRODUCT_FEEDBACK,array('title' => $title,'description' => $description,'product_id' => $product_id,'seller_id'=>$seller_id,'rating' => $rating, 'voter_id' => $user_id,'status'=>'InActive'));
			if($this->lang->line('ur_feedback_add_succ') != '')
			$lg_err_msg = $this->lang->line('ur_feedback_add_succ');
			else
			$lg_err_msg = 'Your feedback added successfully';
			$this->setErrorMessage('success',$lg_err_msg);
			//redirect($base_url);
			echo "<script>window.history.go(-1)</script>";

		}
	}

	public function post_order_comment(){
		if ($this->checkLogin('U') != ''){
			$this->user_model->commonInsertUpdate(REVIEW_COMMENTS,'insert',array(),array(),'');
		}
	}

	public function change_received_status(){
		if ($this->checkLogin('U')!=''){
			$status = $this->input->post('status');
			$rid = $this->input->post('rid');
			$this->user_model->update_details(PAYMENT,array('received_status'=>$status),array('id'=>$rid));
		}
	}

	public function del_save(){
		$returnStr['status_code'] = 0;
		$returnStr['msg'] = '';
		if ($this->checkLogin('U')!=''){
			$pid = $this->input->post('pid');
			if ($pid != '') {
				$likeCount = $this->data['userDetails']->likes;
				$likeCount--;
				if ($likeCount<0)$likeCount=0;
				$this->user_model->commonDelete(PRODUCT_LIKES,array('product_id'=>$pid,'user_id'=>$this->checkLogin('U')));
				$this->user_model->update_details(USERS,array('likes'=>$likeCount),array('id'=>$this->checkLogin('U')));
				$product_like_count = $this->user_model->get_all_details(PRODUCT_LIKES,array('product_id'=>$pid));
				$this->user_model->update_details(PRODUCT,array('likes'=>$product_like_count->num_rows()),array('seller_product_id'=>$pid));
				$this->user_model->update_details(USER_PRODUCTS,array('likes'=>$product_like_count->num_rows()),array('seller_product_id'=>$pid));
				$returnStr['status_code'] = 1;
			}
		}else {
			$returnStr['msg'] = 'Login required';
		}
		echo json_encode($returnStr);

	}

	public function display_user_stores(){
		$username =  $this->uri->segment(2,0);
		$userProfileDetails = $this->user_model->get_all_details(USERS,array('user_name'=>$username));
		if ($userProfileDetails->num_rows()==1){
			if ($userProfileDetails->row()->visibility == 'Only you' && $userProfileDetails->row()->id != $this->checkLogin('U')){
				$this->load->view('site/user/display_user_profile_private',$this->data);
			}else {
				$this->data['heading'] = $username;
				$this->data['userProfileDetails'] = $userProfileDetails;
				$condition = 'select * from '.WANTS_DETAILS.' where user_id = '.$userProfileDetails->row()->id.' GROUP BY product_id';
				$want_details = $this->user_model->ExecuteQuery($condition);
				$this->data['want_details'] = $want_details;
				$this->data['recentActivityDetails'] = $this->user_model->get_activity_details($userProfileDetails->row()->id);
				$fieldsArr = array('*');
				$searchName = 'id';
				$searchArr = explode(',', $userProfileDetails->row()->following);
				$joinArr = array();
				$sortArr = array();
				$limit = '1000';
				$condition_arr = array('group'=>'Seller');
				/*$this->data['store_lists'] = $this->data['followingUserDetails'] = $followingUserDetails = $this->product_model->get_fields_from_many(USERS,$fieldsArr,$searchName,$searchArr,$joinArr,$sortArr,$limit,$condition_arr);
               
                if($followingUserDetails->num_rows()>0){
                    foreach($followingUserDetails->result() as $store_lists_row){
                        $this->data['prodDetails'][$store_lists_row->id] = $this->product_model->get_both_products($store_lists_row->id);
                    }
                }*/
                
                ############ NEW CODE FRO STORE FOLLOWINGG ############
                $nw_condn = " WHERE followers LIKE  '%,".$userProfileDetails->row()->id.",%' OR followers LIKE '%,".$userProfileDetails->row()->id."'";
                $this->data['store_lists'] = $this->data['followingUserDetails'] = $followingUserDetails = $this->product_model->get_follows_stores($nw_condn);
                
                if($followingUserDetails->num_rows()>0){
                    foreach($followingUserDetails->result() as $store_lists_row){
                        $product_ids = array_filter(explode(',', $store_lists_row->products));
                         if (count($product_ids)>0){
                            $this->db->select('p.*,u.user_name,u.full_name,u.thumbnail');
                            $this->db->where_in('p.seller_product_id',$product_ids);
                            $this->db->from(USER_PRODUCTS.' as p');
                            $this->db->join(USERS.' as u','u.id=p.user_id','left');
                            $affilProdDetails = $this->db->get();

                            $this->data['prodDetails'][$store_lists_row->id] = $affilProdDetails;
                        }else {
                            $this->data['prodDetails'][$store_lists_row->id] = '';
                        }
                       /* echo $store_lists_row->id.'<pre>';
                        print_r($this->data['prodDetails'][$store_lists_row->id]);*/
                    }
                }        
                ############ NEW CODE FRO STORE FOLLOWINGG ############        
                
                
				$this->load->view('site/user/display_user_stores',$this->data);
			}
		}else {
			redirect(base_url());
		}
	}

	public function invite_friends(){
		if ($this->checkLogin('U') == ''){
			redirect('login');
		}else {
			$this->data['heading'] = 'Invite Friends';
			$this->load->view('site/user/invite_friends',$this->data);
		}
	}
}

/* End of file user.php */
/* Location: ./application/controllers/site/user.php */