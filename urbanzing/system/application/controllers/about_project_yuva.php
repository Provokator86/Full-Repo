<?php
include BASEPATH.'application/controllers/MY_Controller'.EXT;
class about_project_yuva extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
    }

    function index()
    {   
		
		$this->set_include_files(array('user/yuva_static1'));
        $this->render();
	}

	function sign_up()
	{
		$this->load->library('generat_calender');
		$this->data['dob']	= $this->generat_calender->calender('dob','1982-10-10');
		$this->load->model('occupation_model');
		$this->load->model('entries_model');
	    $this->data['occupation_option']    = $this->occupation_model->get_occupation_option($this->data['data']['occupation_id']);
		$this->data['entries_option']    	= $this->entries_model->get_entries_option($this->data['data']['entries_id']);
		$this->data['old_values'] = $this->session->userdata('user_values');
		$this->add_js(array('jasons_date_input_calendar/calendarDateInput'));
		$this->set_include_files(array('user/yuva_registration'));
        $this->render();
	}
	function save_registration()
	{ 
		
		$this->upload_path = $this->config->item('upload_image_folder_user');
        $message    = '';
        $imagename  = '';
        $arr_post = array();
        $temp_arr = array_merge($arr_post, $_POST);
		
        $this->session->set_userdata('user_values', $temp_arr );
        $this->session->set_userdata('user_messages', array());
		$this->data['old_values'] = $this->session->userdata('user_values');
			
		#================  VALIDATION =======================================================
		if(trim($this->input->post('email'))=='' ) 
			$message    = 'Please give your email address';
		elseif(!preg_match("/^[_a-z0-9-\+]+(\.[_a-z0-9-\+]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $this->input->post('email')) )
			$message    = 'Please Enter Proper email address';
		elseif(trim($this->input->post('f_name'))=='' ) 
			$message    = 'Please give your first name';
		elseif(trim($this->input->post('l_name'))=='' ) 
			$message    = 'Please give your last name';
		elseif(trim($this->input->post('pwd1'))=='' || trim($this->input->post('pwd2'))==''  || trim($this->input->post('pwd1'))!= trim($this->input->post('pwd2'))) 
			$message    = 'Passwords do not match';	
		elseif(trim($this->input->post('gender'))=='')
		    $message    = 'Please Select Gender';	
		else
		{
			$email = htmlspecialchars($this->input->post('email'));
			$email_exist = $this->users_model->get_user_list_count(array('email'=>$email));
			if($email_exist && $email_exist>0 )
			$message    = 'Email adderss has been taken by anothe user';	
		}
		#======================================================================================			
		if($message != '')		
		{
			$this->session->set_userdata(array('message'=>$message, 'message_type'=>'err'));
			header('location:'.base_url().'project_yuva/sign_up');
			exit();
		}
		
		$entries_id = $this->input->post(entries_id);
		$entry = '';
		foreach($entries_id as $key=>$value)
		{
			
			$entry .= $value.',';
		}
		$entry = substr($entry, 0, -1);  // TO REMOVE LAST COMMA
		
		
		#=============== If image provided then upload =======================================
		$max_file_size = $this->site_settings_model->get_site_settings('max_image_file_size');
		if( isset($_FILES['img']['name']) && !empty($_FILES['img']['name']) )
		{
			if( ceil(($_FILES['img']['size']/1000))> $max_file_size )
			{	
					$message    = 'The uploaded file exceeds the maximum allowed size';
			}
			else
			{
						$img_details = upload_file($this,
						array('upload_path' => $this->upload_path,
							'file_name' => 'user_'.time(),
							'allowed_types' => $this->config->item('image_support_extensions'),
							'max_size' => $max_file_size,
							'max_width' => '0',
							'max_height' => '0',
						), 'img'
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
						$err = explode('|', $img_details);
						$message = $err[0];
					}
			}
		 }
			
		
		#=====================================================================================
		
		
		$rndCode	= get_rendom_code('',15);
        $type_id    = htmlspecialchars($this->input->post('user_type_id'), ENT_QUOTES, 'utf-8');
		$screen_name = (isset($screen_name) && !empty($screen_name)) ? $screen_name : $f_name.' '.$l_name;
		
		$arr= array(
						"email"=>htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8'),
						"f_name"=>htmlspecialchars($this->input->post('f_name'), ENT_QUOTES, 'utf-8'),
						"l_name"=>htmlspecialchars($this->input->post('l_name'), ENT_QUOTES, 'utf-8'),
						"screen_name"=>$screen_name,
						"password"=>get_salted_password(htmlspecialchars($this->input->post('pwd1'), ENT_QUOTES, 'utf-8')),
						"entries_id"=>$entry,
						"gender"=>htmlspecialchars($this->input->post('gender'), ENT_QUOTES, 'utf-8'),
						"dob"=>strtotime(htmlspecialchars($this->input->post('dob'), ENT_QUOTES, 'utf-8')),
						"gender"=>$this->input->post('gender'),
						"occupation_id"=>htmlspecialchars($this->input->post('occupation_id'), ENT_QUOTES, 'utf-8'),
						"about_yourself"=>htmlspecialchars($this->input->post('about_yourself'), ENT_QUOTES, 'utf-8'),
						"source"=>"yuva project",
						"user_type_id"=>$type_id,
                        "date_created"=>time(),
                        "verified"=>($type_id==4)?2:1,
                        "country_id"=>113,
						"restricted"=>1,
                        "verification_code"=>$rndCode
						);
		if($imagename!='')
		$arr['img_name']    = $imagename;				
		$userId = $this->users_model->set_data_insert('users',$arr);
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
                $this->automail_model->send_yuva_registration_mail($this->input->post('email'),$mail_type);
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
                    $this->session->set_userdata(array('message'=>'Registered successfully...','message_type'=>'succ'));
                    header('location:'.base_url().'user/message_page');
                }
                exit();
            }
            else
            {
                $this->session->set_userdata(array('message'=>'Unable to register...','message_type'=>'err'));
                header('location:'.base_url().'user/message_page');
                $this->session->set_userdata('user_values', '' );
                exit();
            }


	}
	
	function verify_yuva_user($user_id='',$activation_code)
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
				  $mail_type = 'welcome_yuva_signup_mail';
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
	

}
