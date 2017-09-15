<?php
include BASEPATH.'application/controllers/MY_Controller'.EXT;


class user extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->clear_business_search();
        $this->load->model('users_model');
    }

    function index()
    {
        $this->check_user_page_access('non_registered');
        include BASEPATH.'application/libraries/recaptchaLib/recaptchalib'.EXT;
		$this->load->model('article_model');

        $this->data['title'] = 'Sign up its FREE';
        $this->data['meta_desc'] = 'FREE account';
        
		$this->data['old_values'] = $this->session->userdata('user_values');
        $this->data['recaptcha_html'] = recaptcha_get_html($this->config->item('recaptcha_public_key'));
		$this->data['user_signup_upper']=$this->article_model->get_article_list(1, 0, -1, '', 1, 'user_signup_upper');
		
        $this->session->set_userdata('user_values', '' );
        $this->session->set_userdata('redirect_url', base_url().'user' );

        $this->add_js(array('ajax_helper', 'common_js', 'fromvalidation', 'ModalDialog', 'js_form'));
        $this->set_include_files(array('user/registration'));
        $this->render();
	}
    
    function registration()
    {
        $this->check_user_page_access('non_registered');
        include BASEPATH.'application/libraries/recaptchaLib/recaptchalib'.EXT;
		$this->load->model('article_model');

        $this->data['title'] = 'Business owner signup';
        $this->data['meta_desc'] = 'Business owner signup';
		
        $this->data['old_values'] = $this->session->userdata('user_values');
        $this->data['recaptcha_html'] = recaptcha_get_html($this->config->item('recaptcha_public_key'));
		$this->data['user_merchant_registration_page_text'] = $this->article_model->get_article_list(1, 0, -1, '', 1, 'user_merchant_registration_page_text');
		
        $this->session->set_userdata('user_values', '' );
        $this->session->set_userdata('redirect_url', base_url().'user/registration' );
		
        $this->add_js(array('ajax_helper', 'common_js', 'fromvalidation', 'ModalDialog', 'js_form', 'recaptcha_ajax'));
        $this->set_include_files(array('user/registration_merchant'));
        $this->render();
    }

    function save_registration()
    {
        $this->check_user_page_access('non_registered');
		$this->add_js(array('recaptcha_ajax'));
        include BASEPATH.'application/config/common_message'.EXT;
        $this->upload_path = $this->config->item('upload_image_folder_user');
        $message    = '';
        $imagename  = '';
        $arr_post = array();
        $temp_arr = array_merge($arr_post, $_POST);
		
        $this->session->set_userdata('user_values', $temp_arr );
        $this->session->set_userdata('user_messages', array());
        if(trim($this->input->post('f_name'))=='' && array_key_exists('f_name', $message_error) )
            $message    = $message_error['f_name'];
        elseif(trim($this->input->post('l_name'))=='' && array_key_exists('l_name', $message_error) )
            $message    = $message_error['l_name'];
        elseif(trim($this->input->post('email'))=='' && array_key_exists('email', $message_error) )
            $message    = $message_error['email'];
        elseif(trim($this->input->post('password'))=='' && array_key_exists('password', $message_error) )
            $message    = $message_error['password'];
        /*elseif(trim($this->input->post('c_password'))=='' && array_key_exists('c_password', $message_error) )
            $message    = $message_error['c_password'];
        elseif(trim($this->input->post('zip_id'))=='' && array_key_exists('zip_code', $message_error) )
            $message    = $message_error['zip_code'];*/
        elseif(trim($this->input->post('recaptcha_response_field'))=='' && array_key_exists('captcha', $message_error))
            $message    = $message_error['captcha'];
        elseif(!preg_match("/^[_a-z0-9-\+]+(\.[_a-z0-9-\+]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $this->input->post('email')) && array_key_exists('proper_email', $message_error))
            $message    = $message_error['proper_email'];
       /* elseif(trim($this->input->post('password'))!= trim($this->input->post('c_password')) && array_key_exists('password_match', $message_error))
            $message    = $message_error['password_match'];*/
        else
        {
            $email_exist = $this->users_model->get_user_list_count(array('email'=>$this->input->post('email')));
       		include BASEPATH.'application/libraries/recaptchaLib/recaptchalib'.EXT;
            $RECAPTCHA_CHALLENGE = $this->input->post('recaptcha_challenge_field');
                $RECAPTCHA_RESPONSE   = $this->input->post('recaptcha_response_field');
                $response = recaptcha_check_answer (
                            $this->config->item('recaptcha_private_key'),
                            $_SERVER["REMOTE_ADDR"],
                            $RECAPTCHA_CHALLENGE,
                            $RECAPTCHA_RESPONSE
                    );
            if($email_exist && $email_exist>0 && array_key_exists('email_exists', $message_error))
                $message    = $message_error['email_exists'];
            elseif (!$response->is_valid && array_key_exists('captcha_valid', $message_error))
                $message    = $message_error['captcha_valid'];
            else
            {
                $max_file_size    =$this->site_settings_model->get_site_settings('max_image_file_size');
                if( isset($_FILES['img_name']['name']) && !empty($_FILES['img_name']['name']) )
                {
                    $img_details = upload_file($this,
                       array('upload_path' => $this->upload_path,
                          'file_name' => 'business_'.time(),
                          'allowed_types' => $this->config->item('image_support_extensions'),
                          'max_size' => $max_file_size,
                          'max_width' => '0',
                          'max_height' => '0',
                          ), 'img_name'
                       );
                    if (is_array($img_details))
                    {
						$this->load->library('image_lib');
                        $imagename = $img_details['orig_name'];
						
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $img_details['full_path'];
                        $config['create_thumb'] = TRUE;
                        $config['maintain_ratio'] = TRUE;
                        $config['thumb_marker'] = '';
                        $config['width'] = 77;
                        $config['height'] = $this->config->item('image_thumb_height');
                        $config['new_image'] = $this->upload_path.$this->config->item('image_folder_thumb').$imagename;
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
						$this->image_lib->clear();

						$showable_image['image_library'] = 'gd2';
						$showable_image['source_image'] = $img_details['full_path'];
						$showable_image['create_thumb'] = TRUE;
						$showable_image['maintain_ratio'] = TRUE;
						$showable_image['thumb_marker'] = '';
						$showable_image['width'] = $this->config->item('image_view_width');
						$showable_image['height'] = $this->config->item('image_view_height');
						$showable_image['new_image'] = $this->upload_path.$this->config->item('image_folder_view').$imagename;
						$this->image_lib->initialize($showable_image);
						$this->image_lib->resize();
						$this->image_lib->clear();
                    }
                    else
                    {
                        $err=explode('|',$img_details);
                        $message    = $err[0];
                    }
                }
            }
        }
        if($message=='' )
        {
            $rndCode	= get_rendom_code('',15);
            $type_id    = htmlspecialchars($this->input->post('user_type_id'), ENT_QUOTES, 'utf-8');
			$f_name = htmlspecialchars($this->input->post('f_name'), ENT_QUOTES, 'utf-8');
			$l_name = htmlspecialchars($this->input->post('l_name'), ENT_QUOTES, 'utf-8');
			$screen_psot_val = htmlspecialchars($this->input->post('screen_name'), ENT_QUOTES, 'utf-8');
			$screen_name = (isset($screen_psot_val) && !empty($screen_psot_val)) ? $screen_psot_val : $f_name.' '.$l_name;
            $arr= array("f_name"=>$f_name,
                        "l_name"=>$l_name,
                        "email"=>htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8'),
                        "password"=>get_salted_password($this->input->post('password')),
                        "screen_name"=>$screen_name,
                        "zipcode"=>htmlspecialchars($this->input->post('zip_id'), ENT_QUOTES, 'utf-8'),
                        "about_yourself"=>htmlspecialchars($this->input->post('about_yourself'), ENT_QUOTES, 'utf-8'),
                        "img_name"=>$imagename,
                        "user_type_id"=>$type_id,
                        "date_created"=>time(),
                        "verified"=>($type_id==4)?2:1,
                        "country_id"=>113,
						"restricted"=>1,
                        "verification_code"=>$rndCode
                );
            $userId	=$this->users_model->set_data_insert('users',$arr);
            if($userId)
            {
				$arr_inv = array("email_provided_by"=>'Self',
								 "source_name"=>htmlspecialchars($this->input->post('f_name'), ENT_QUOTES, 'utf-8'),
								 "email_opt_in"=>'Y',
								 "invited_email"=>htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8'),
								 "invited_date"=>time(),
								 "invite_accepted"=>($type_id==4)?'Y':'N',
								 "user_id"=>$userId,
								 "user_type_id"=>$type_id
							);
							
				$this->users_model->set_data_insert('mailing_list',$arr_inv);
				
                $this->load->model('automail_model');
                $mail_type  = 'user_registration';
                if($type_id==4)
                    $mail_type  = 'user_registration_merchant';
                $this->automail_model->send_registration_mail($this->input->post('email'),$mail_type);
				//$this->automail_model->send_registration_mail($this->input->post('email'),'welcome_signup_mail');
                $this->session->set_userdata('user_values', '' );
                if($type_id==4)
                {
                    $data_arr   = $this->users_model->authenticate($arr['email'],$arr['password']);
                    $this->users_model->log_this_login($data_arr);
                    header('location:'.base_url().'profile');
                }
                else
                {
                    $this->session->set_userdata(array('message'=>$message_success['complete_registration'],'message_type'=>'succ'));
                    header('location:'.base_url().'user/message_page');
                }
                exit();
            }
            else
            {
                $this->session->set_userdata(array('message'=>$message_error['unable_registration'],'message_type'=>'err'));
                header('location:'.base_url().'user/message_page');
                $this->session->set_userdata('user_values', '' );
                exit();
            }
        }

		if(!empty($imagename))
		{
			@unlink($this->upload_path.$imagename);
			@unlink($this->upload_path.$this->config->item('image_folder_thumb').$imagename);
			@unlink($this->upload_path.$this->config->item('image_folder_view').$imagename);
		}
		
        $this->session->set_userdata(array('message'=>$message,'message_type'=>'err'));
        header('location:'.$this->session->userdata('redirect_url'));
        exit();
    }

    function message_page()
    {
        $this->data['title'] = 'Message';
		$this->load->model('article_model');
		$this->data['message_page_text']=$this->article_model->get_article_list(1,0,-1,'',1,'message_page_text');		
        $this->set_include_files(array('user/message'));
        $this->render();
    }

	function login()
	{
		$this->check_user_page_access('non_registered');
		if($this->input->post('is_posted', true)!="")
		{
			$data_arr = $this->users_model->authenticate($this->input->post('uid', true), get_salted_password($this->input->post('pwd', true)));
			if(isset($data_arr) && is_array($data_arr))
			{
				if( $data_arr['verified']=='1')
				{
					$this->message_type ='succ';
					$this->message  ='';
					$this->session->set_userdata(array('message'=>'Your account has been verified properly. Please wait for admin approval..','message_type'=>'err'));
				}
				elseif( $data_arr['verified']=='0')
				{
					$this->session->set_userdata(array('message'=>'Sorry, Your email is not verified. Please check your mail..','message_type'=>'err'));
				}
				else
				{
					$this->users_model->log_this_login($data_arr);
					if($data_arr['user_type_id']=='1')
					{
						header('location:'.base_url().'admin/home/display');
						exit;
					}
					else
					{
						$this->users_model->set_data_update('mailing_list', array('invite_accepted'=>'Y'), array('user_id'=>$data_arr['id']));
						header('location:'.base_url().'profile');
						exit;
					}
				}
			}
			else
			{
				$this->session->set_userdata(array('message'=>'Wrong username or password','message_type'=>'err'));
			}
		}

		if($this->input->post('redirect_url')=='marchant_login')
			header('location:'.base_url().'home/promote_your_business');
		else
			header('location:'.base_url().'home/login');
		exit();
	}

    function logout()
    {
        $this->data['title'] = 'Home Page';
        $this->users_model->logout_this_login();
        header('location:'.base_url().'home');
        exit;
    }

    function add_user_check()
    {
        $dataArr    = array('username'=>$this->input->post('username'),'email'=>$this->input->post('email'),'user_code'=>$this->input->post('user_code'));
        $id         = $this->input->post('user_id');
        $user_code  = $this->input->post('user_code');
        $msg        = $this->users_model->get_user_duplicate($dataArr,($id)?$id:-1);
        if($msg == '')
        {
            $p_id           = $this->input->post('p_id');
            $has_pin    = $this->input->post('has_pin');
            $p_status       = $this->input->post('p_status');
            $msg    = $this->users_model->check_paren_exists($p_id);
            if($msg == '')
                $msg    = $this->users_model->get_user_hand($p_id,$p_status,($id)?$user_code:'');
            else if($msg == '' && $has_pin=='pin')
            {
                $serial_code    = $this->input->post('serial_code');
                $msg            = $this->check_promoter_information($id,$p_id,$serial_code,$user_code,$p_status);
            }
        }
        echo $msg;
    }

	function paypal_return()
    {
        $this->load->library('paypal/paypal_lib');
        $res    =  $this->paypal_lib->paypal_return();
        if($res==true)
        {
            $arr    = $this->session->userdata('insert_detail');
            $this->users_model->set_user_payment_insert($arr['user_code'],'Paypal');
            $this->set_user_insert($arr);
            $this->session->set_userdata(array('insert_detail'=>''));
        }
        else
        {
            $this->session->set_userdata(array('message'=>'There are some problem at the time of payment..','message_type'=>'err'));
            header('location:'.base_url());
            exit;
        }
    }

    private function set_user_insert($arr)
    {
        $arr['verification_code']   = get_rendom_code('',15);
        if($this->users_model->set_user_insert($arr,get_salt()))
        {
            $this->load->model('automail_model');
            $this->load->model('sms_model');
            $this->users_model->update_user_heand($arr['p_id'],$arr['user_code'],$this->session->userdata('p_status'));
            $this->automail_model->send_registration_money_recipt($arr,$this->site_settings_model->get_site_settings('registration_charge'));
            $this->sms_model->send_sms('user_registration',$arr['phone_1']);
            $this->session->set_userdata(array('p_status'=>''));
            $this->session->set_userdata(array('message'=>'Your regisration complete successfully. An activation mail has been send to your email account. Please activate your email to access the account.','message_type'=>'succ'));
        }
        else
            $this->session->set_userdata(array('message'=>'Unable to complete the registration process..','message_type'=>'err'));
        header('location:'.base_url());
        exit;
    }

    function forget_password()
    {
        $this->check_user_page_access('non_registered');
        $this->data['title'] = 'Forgot password';
        if($this->input->post('submit_button', true)!="")
        {
            $this->load->model('automail_model');
            if($this->automail_model->send_forget_password_mail($this->input->post('email')))
            {
                    $this->message_type ='succ';
                    //$this->message  ='New password has been send successfully..';
                    $this->session->set_userdata(array('message'=>'New password has been sent successfully.','message_type'=>'succ'));
                    header('location:'.base_url().'user/message_page');
                    exit();
                }
                else
                {
                        $this->message_type ='err';
                    $this->message  ='Unable to send email..';
                }
        }
        $this->set_include_files(array('user/forget_password'));
        $this->render();
    }

    function ajax_user_detail($usercode)
    {
        $tmp    = $this->users_model->get_user_parent($usercode);
        $user_detail=$this->users_model->get_user_with_child($usercode);
        $user   = $tmp[0];
        $html   = '
                <table width="200"  cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="left"><b>User Id:</b></td>
                        <td align="left">'.$user['username'].'</td>
                    </tr>
                    <tr>
                        <td align="left"><b>Introducer Id:</b></td>
                        <td align="left">'.$user['p_user_code'].'</td>
                    </tr>
                    <tr>
                        <td align="left"><b>Join date:</b></td>
                        <td align="left">'.date('d-m-Y',$user['join_date']).'</td>
                    </tr>
                    <tr>
                        <td align="left"><b>Total Left Side:</b></td>
                        <td align="left">'.$user_detail[0]['left_total'].' Members</td>
                    </tr>
                    <tr>
                        <td align="left"><b>Total Right Side:</b></td>
                        <td align="left">'.$user_detail[0]['right_total'].' Members</td>
                    </tr>
                </table>
            ';
        echo $html;
    }
	
	function verify_user($user_id='',$activation_code)
	{
		$this->check_user_page_access('non_registered');
		$uID	= $this->users_model->confirem_user($user_id,$activation_code);
		if($uID)
		{
			$user_details = $this->users_model->get_user_list(1,0,array('id'=>$uID));
			$data_arr   = $this->users_model->authenticate($user_details[0]['email'],$user_details[0]['password']);
			if(isset($data_arr) && is_array($data_arr))
            {
				  $this->load->model('automail_model');	
				  $mail_type = 'welcome_signup_mail';
				  $this->automail_model->send_registration_mail($user_details[0]['email'],$mail_type);	
                  $this->users_model->log_this_login($data_arr);
				  header('location:'.base_url().'profile');
                  exit;
            }
            else
				$this->session->set_userdata(array('message'=>'Unable to activate your account..','message_type'=>'err'));
				
		}
		else
		{
			$this->session->set_userdata(array('message'=>'Unable to activate your account..','message_type'=>'err'));
		}
        header('location:'.base_url().'user/message_page');
		exit();
	}
	
	
	
	
	function facebook_regular_user_signup($user_type_id)
	{
		$fb=new Facebook( $this->data['api_key'] , $this->data['secret_key'] );
		$fb_user=$fb->get_loggedin_user();	
		
		if($fb_user) 
		{
			try{
			$user_details_all = $fb->api_client->fql_query("SELECT about_me, birthday, current_location, 
				 first_name, has_added_app, hometown_location, 
				 last_name, locale,  
				 pic, pic_with_logo, pic_big, 
				pic_big_with_logo, pic_small, pic_small_with_logo, pic_square, 
				pic_square_with_logo, profile_url, 
				proxied_email,email,contact_email, sex, 
				status, timezone, website FROM user WHERE uid = me()");
				//echo "<pre>";
				/*if( $frmAcumen )
					print_r($user_details_all);*/
				$fname			=	$user_details_all[0]['first_name'];
				$lname			=	$user_details_all[0]['last_name'];
				$city			=	$user_details_all[0]['current_location']['city'];
				$zip			=	$user_details_all[0]['current_location']['zip'];
				$email1			=	$user_details_all[0]['email'];
				$uid			=	strtolower( $user_details_all[0]['first_name'] );
				$fb_user_bday 	=  date("d/m/Y",strtotime($user_details_all[0]['birthday']));
				$fb_user_bday_list	=	explode('/',$fb_user_bday);
				$mnts			=	$fb_user_bday_list[1];
				$dd				=	$fb_user_bday_list[0];
				$yy				=	$fb_user_bday_list[2];
				$pic_big		=   $user_details_all[0]['pic_big'];
				$fbCurrentPos	=	$user_details_all[0]['current_location'];
				$fbCountry		=	$fbCurrentPos['country'];
				$fbState		=	$fbCurrentPos['state'];
				$fbCity			=	$fbCurrentPos['city'];
				$fbZip			=	$fbCurrentPos['zip'];	
				
				$fbCountryId	=	'';
	/*			var_dump($user_details_all);
				die();
				if($zip)			
					$this->data['zip']	=	$fbZip;
				if($fname)			
					 $this->data['fname']  =	$fname;
				if($lname )			
					$this->data['lname']		=	$lname;
				if($email1 )			
					$this->data['email']		=	$email1;*/
					
				$email_exist = $this->users_model->get_user_list_count(array('email'=>$email1));
				if($email_exist && $email_exist>0)
				{
					/*$this->session->set_userdata(array('message'=>'Email Address is already registered','message_type'=>'err'));
                    header('location:'.base_url().'user/message_page');
					exit;*/
				
					$user_details_all = $fb->api_client->fql_query("SELECT 
						 first_name, last_name, proxied_email,email,contact_email FROM user WHERE uid = me()");

					$email1	 =	$user_details_all[0]['email'];
		
		
					$user_details = $this->users_model->facebook_authenticate($email1);
					if(!$user_details)
					{
					  $this->session->set_userdata(array('message'=>'Sorry, not getting proper data from facebook','message_type'=>'err'));
					  header('location:'.base_url().'user/message_page');
					  exit;
					}
					$this->users_model->log_this_login($user_details);
					header('location:'.base_url().'profile');
					exit;
					
				}
				//die('enter');
					$image_name ='';
					$this->upload_path = $this->config->item('upload_image_folder_user');
					preg_match('/(^.*)\.([^\.]*)$/', $user_details_all[0]['pic'], $matches);
					$ext = "";
					
					if(count($matches)>0) {
						$ext = $matches[2];
						$original_name = 'user'.time();
						$file_name = $original_name.'.'.$ext;
						$image_name =  $this->upload_path.$file_name;
						copy($user_details_all[0]['pic'], $image_name);
						copy($user_details_all[0]['pic'], $this->upload_path.$this->config->item('image_folder_thumb').$file_name);
						copy($user_details_all[0]['pic'], $this->upload_path.$this->config->item('image_folder_view').$file_name);
					}
					
					$arr = array('f_name'=>$fname,'l_name'=>$lname,'email'=>$email1,'verified'=>2,'user_type_id'=>$user_type_id,'face_book_connect'=>'Y','date_created'=>time(),'img_name'=>$file_name);	
					$userId	=$this->users_model->set_data_insert('users',$arr);
					if($userId)
					{
						$user_details = $this->users_model->facebook_authenticate($email1);
						$this->users_model->log_this_login($user_details);
						header('location:'.base_url().'profile');
						exit;
					
/*						$this->session->set_userdata(array('message'=>'Facebook signup successfully completed. From now on you will be able to login with your facebook username and password.','message_type'=>'succ'));
                    	header('location:'.base_url().'user/message_page');
						exit;*/
					}
					
			}
			catch(Exception $e)
			{
				$this->session->set_userdata(array('message'=>'Sorry, Not getting any data from facebook. try again..','message_type'=>'err'));
				header('location:'.base_url().'user/message_page');
				exit;				
			}
				
		} 
		else 
		{
				$this->session->set_userdata(array('message'=>'Sorry, Not getting any data from facebook. try again..','message_type'=>'err'));
				header('location:'.base_url().'user/message_page');
				exit;
		}
		//var_dump($user_details_all);
	
	}
	
    function facebook_login()
    {
        $this->check_user_page_access('non_registered');
		$fb			=	new Facebook( $this->data['api_key'] , $this->data['secret_key'] );
		$fb_user	=	$fb->get_loggedin_user();	
	
		if($fb_user) 
		{
			try{
				$user_details_all = $fb->api_client->fql_query("SELECT 
					 first_name, last_name, proxied_email,email,contact_email FROM user WHERE uid = me()");
				//echo "<pre>";
				//if( $frmAcumen )
				//	print_r($user_details_all);
				//	exit;
				$email1	 =	$user_details_all[0]['email'];
	
	
				$user_details = $this->users_model->facebook_authenticate($email1);
				if(!$user_details)
				{
				  $this->session->set_userdata(array('message'=>'Sorry, not getting proper data from facebook','message_type'=>'err'));
				  header('location:'.base_url().'user/message_page');
				  exit;
				}
				$this->users_model->log_this_login($user_details);
				header('location:'.base_url().'profile');
                exit;
					
			}
			catch(Exception $e)
			{
				
				$this->session->set_userdata(array('message'=>'Sorry, Not getting any data from facebook. try again..','message_type'=>'err'));
				//header('location:'.base_url().'user/message_page');
				exit;				
			}
				
		} 
		else 
		{
				$this->session->set_userdata(array('message'=>'Sorry, Not getting any data from facebook. try again..','message_type'=>'err'));
				header('location:'.base_url().'user/message_page');
				exit;
		}		
           
		
        header('location:'.base_url().'home/login');
        exit();
    }
}
