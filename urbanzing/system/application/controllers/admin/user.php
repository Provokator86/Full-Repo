<?php
//for MLM
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class user extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
		$this->menu_id  = 1;

    }

    function index($order_name='f_name',$order_type='asc',$page=0)
    {
        $this->check_user_page_access('registered');
        $sessArrTmp = array();
        $this->menu_id  = 1;
        $this->data['title'] = 'Admin user Page';
		$this->data['user_type'] = $this->users_model->user_type;
        if($this->input->post('go'))
        {
            $sessArrTmp['src_user_name']=trim(htmlentities($this->input->post('name'),ENT_QUOTES, 'utf-8'));
            $sessArrTmp['src_user_email']=trim(htmlentities($this->input->post('email'),ENT_QUOTES, 'utf-8'));
            $sessArrTmp['src_user_restricted']=$this->input->post('restricted');
            $sessArrTmp['src_user_role']=$this->input->post('user_type_id');
			$page = 0;
        }
        else
        {
            $sessArrTmp['src_user_name']=$this->get_session_data('src_user_name');
            $sessArrTmp['src_user_email']=$this->get_session_data('src_user_email');
            $sessArrTmp['src_user_restricted']=$this->get_session_data('src_user_restricted');
            $sessArrTmp['src_user_role']=$this->get_session_data('src_user_role');
        }

        $this->data['txtArray']   = array("name"=>"Name","email"=>"Email");
        $this->data['txtValue']   = array($sessArrTmp['src_user_name'],$sessArrTmp['src_user_email']);
        $this->data['optArray']   = array("user_type_id"=>"User Type","restricted"=>"Status");
        $this->data['optValue']   = array(makeOption($this->data['user_type'],$sessArrTmp['src_user_role']),
            makeOption(array("1"=>"Enable","0"=>"Disable"),$sessArrTmp['src_user_restricted'])
            );
        $arr   = array('name'=>$sessArrTmp['src_user_name'],'email'=>$sessArrTmp['src_user_email'],'restricted'=>$sessArrTmp['src_user_restricted'],'user_type_id'=>$sessArrTmp['src_user_role']);
        $this->data['admin_user']=$this->users_model->get_user_list($this->admin_page_limit,($page)?$page:0,$arr,$order_name,$order_type);
        $totRow = $this->users_model->get_user_list_count($arr);
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        if(!$this->data['admin_user'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/user/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/user/index/'.$order_name.'/'.$order_type,
                    'total_row'=>$totRow,
                    'per_page'=>$this->admin_page_limit,
                    'uri_segment'=>6,
                    'next_link'=>'Next&gt;',
                    'prev_link'=>'&lt;Prev'
                )
            );
		
		
        $this->data['order_name']=$order_name;
        $this->data['order_type']=$order_type;
        $this->data['page']=$page;

        $sessArrTmp['redirect_url']=base_url().'admin/user/index/'.$order_name.'/'.$order_type.'/'.$page;
        //$this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','user/user_list'));
        $this->render();
    }

    function add_user()
    {
        $this->check_user_page_access('registered');
        $this->load->model('location_model');
		$this->data['table_title'] = 'Add User';
        $this->menu_id  = 3;
        $this->data['old_values'] = $this->session->userdata('user_values');
		
		$this->data['user_type_option'] = makeOption($this->users_model->user_type,$this->data['old_values']['user_type']);
		
        $this->session->set_userdata('user_values', '' );
        //$this->session->set_userdata('redirect_url', base_url().'admin/user' );

        $this->add_js(array('ajax_helper','common_js','fromvalidation','ModalDialog','js_form'));
        $this->set_include_files(array('common/admin_menu','user/add_user'));
        $this->render();
    }


    
    function generate_random_code()
    {
        echo $this->users_model->generate_user_rendom_dode();
    }

    function add_new_user_check()
    {
        $dataArr    = array('username'=>$this->input->post('username'),'email'=>$this->input->post('email'),'user_code'=>$this->input->post('user_code'));
        $id = $this->input->post('user_id');
        $user_code = $this->input->post('user_code');
        $msg    = $this->users_model->get_user_duplicate($dataArr,($id)?$id:-1);
        if($msg == '')
        {
            if($this->input->post('p_id') && trim($this->input->post('serial_code'))=='')
                $msg    = 'You have to give a pin code';
            else
                $msg    = $this->users_model->get_check_user_valid_pincode($this->input->post('p_id'),$this->input->post('serial_code'),($id)?$user_code:'');
            if($msg == '' && $this->input->post('p_id')!='')
            {
                $msg    = $this->users_model->check_paren_exists($this->input->post('p_id'));
                if($msg == '')
                    $msg    = $this->users_model->get_user_hand($this->input->post('p_id'),$this->input->post('p_status'),($id)?$user_code:'');
            }
        }
        echo $msg;
    }

    function insert_user()
    {
        $this->check_user_page_access('registered');
		//include BASEPATH.'application/config/common_message'.EXT;
		$this->upload_path = BASEPATH.'../images/uploaded/user/';
        $message    = '';
        $imagename  = '';
        $arr_post = array();
        $temp_arr = array_merge($arr_post, $_POST);
        $this->session->set_userdata('user_values', $temp_arr );
        $this->session->set_userdata('user_messages', array());
        if(trim($this->input->post('f_name'))=='')
            $message    = 'Please give first name';
        elseif(trim($this->input->post('l_name'))=='')
            $message    = 'Please give last name';
        elseif(trim($this->input->post('user_type'))=='' )
            $message    = 'Please give user type';
        elseif(trim($this->input->post('email'))=='' )
            $message    = 'Please give email';
        elseif(trim($this->input->post('password'))=='' )
            $message    = 'Please give password';
        elseif(trim($this->input->post('c_password'))=='' )
            $message    = 'Please give confirm password';
        elseif(trim($this->input->post('zip_id'))=='' )
            $message    = 'Please givezip code';
        elseif(!preg_match("/^[_a-z0-9-\+]+(\.[_a-z0-9-\+]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $this->input->post('email')) )
            $message    = 'Please give proper email id';
        elseif(trim($this->input->post('password'))!= trim($this->input->post('c_password')))
            $message    = 'password mismatched';
        else
        {
            $email_exist = $this->users_model->get_user_list_count(array('email'=>$this->input->post('email')));
            if($email_exist && $email_exist>0 )
                $message    = 'email address already exist';
            else
            {
                $max_file_size    =$this->site_settings_model->get_site_settings('max_image_file_size');
                if( isset($_FILES['img_name']['name']) && $_FILES['img_name']['name']!='' )
                {
                    $img_details = upload_file($this,
                       array('upload_path' => $this->upload_path,
                          'file_name' => 'user'.time(),
                          'allowed_types' => $this->config->item('image_support_extensions'),
                          'max_size' => $max_file_size,
                          'max_width' => '0',
                          'max_height' => '0',
                          ), 'img_name'
                       );
                    if (is_array($img_details))
                    {
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $img_details['full_path'];
                        $config['create_thumb'] = TRUE;
                        $config['maintain_ratio'] = TRUE;
                        $config['thumb_marker'] = '';
                        $config['width'] = 77;
                        $config['height'] = 150;
                        $config['new_image'] = $this->upload_path.'thumb/'.$img_details['orig_name'];
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                        $imagename = $img_details['orig_name'];
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
			$password = $this->input->post('password');
            $type_id    = htmlspecialchars($this->input->post('user_type'), ENT_QUOTES, 'utf-8');
			
            $arr= array("f_name"=>htmlspecialchars($this->input->post('f_name'), ENT_QUOTES, 'utf-8'),
                        "l_name"=>htmlspecialchars($this->input->post('l_name'), ENT_QUOTES, 'utf-8'),
                        "email"=>htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8'),
                        "password"=>get_salted_password($password),
                        "screen_name"=>htmlspecialchars($this->input->post('screen_name'), ENT_QUOTES, 'utf-8'),
                        "zipcode"=>htmlspecialchars($this->input->post('zip_id'), ENT_QUOTES, 'utf-8'),
                        "about_yourself"=>htmlspecialchars($this->input->post('about_yourself'), ENT_QUOTES, 'utf-8'),
                        "img_name"=>$imagename,
                        "user_type_id"=>$type_id,
                        "date_created"=>time(),
                        "verified"=>2,
						"restricted"=>1
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
                
                $mail_type  = 'admin_added_user_registration';
                $this->automail_model->send_admin_added_registration_mail($this->input->post('email'),$mail_type,$password);
                $this->session->set_userdata('user_values', '' );

                $this->session->set_userdata(array('message'=>'User added successfully.','message_type'=>'succ'));
                header('location:'.base_url().'admin/user');
                exit();
            }
            else
            {
                $this->session->set_userdata(array('message'=>'Unable to add user','message_type'=>'err'));
                header('location:'.base_url().'admin/user');
                $this->session->set_userdata('user_values', '' );
                exit();
            }
        }
        $this->session->set_userdata(array('message'=>$message,'message_type'=>'err'));
        header('location:'.base_url().'admin/user/add_user');
        exit();
    }


    function ajax_change_status()
    {
        $restricted   = $this->input->post('restricted');
        $id   = $this->input->post('id');
        if($this->users_model->change_user_status($id,$restricted))
        {
            //$this->load->model('automail_model');
			
            $txt     = " Disable";
            $style='';
            $restricted=1-$restricted;
            $mailType	= 'block_user';
            if($restricted==1)
            {
                $style  = "color:green;";
                $txt     = " Enable";
                $mailType	= 'unblock_user';
            }
            //$this->automail_model->send_block_unblock_user_mail($id,$mailType);
            $jsnArr = json_encode(array('id'=>$id,'restricted'=>$restricted));
            echo "<a onclick='call_ajax_status_change(\"".base_url()."admin/user/ajax_change_status\",".$jsnArr.",\"status".$id."\");' style='cursor:pointer; ".$style."'> ".$txt."</a>";
        }
    }

    function edit_user($id=-1)
    {
        $this->check_user_page_access('registered');
		$this->data['title'] = 'Edit User';
		$this->data['table_title'] = 'Edit User';
        if(!$id||!is_numeric($id)||$id==-1 || !$this->users_model->is_valid_user($id))
        {
            $this->session->set_userdata(array('message'=>'Data not found for this user..','message_type'=>'err'));
            header("Location: ".$this->get_redirect_url());
            exit(0);
        }
		
        $this->load->model('location_model');
        $this->load->model('occupation_model');
        $this->load->library('generat_calender');
		$this->load->model('article_model');
		
        $this->data['cur_user_id'] = $id;
		
        $this->data['data'] = $this->session->userdata('user_values');

        if(!isset($this->data['data']) || count($this->data['data'])<1 || $this->data['data'].'a'=='a')
        {
            $tmp    = $this->users_model->get_user_list(1,0,array('id'=>$this->data['cur_user_id']));
            $this->data['data'] = $tmp[0];
            $this->data['data']['dob'] = date('Y-m-d',$tmp[0]['dob']);
        }
		
        $this->data['dob']	= $this->generat_calender->calender('dob',$this->data['data']['dob']);
        $this->data['country_option']    = $this->location_model->get_country_list_option($this->data['data']['country_id']);
        $this->data['state_option']    = $this->location_model->get_state_list_option($this->data['data']['state_id'],$this->data['data']['country_id']);
        if($this->data['data']['state_id']>0)
            $this->data['city_option']    = $this->location_model->get_city_list_option($this->data['data']['city_id'],$this->data['data']['state_id']);
        if($this->data['data']['city_id']>0)
            $this->data['zipcode_option']    = $this->location_model->get_zip_code_list_option($this->data['data']['zipcode'],$this->data['data']['city_id']);
        $this->data['occupation_option']    = $this->occupation_model->get_occupation_option($this->data['data']['occupation_id']);
		$this->data['user_type_option'] = makeOption($this->users_model->user_type,$this->data['data']['user_type_id']);
		
       // $this->add_js(array('ajax_helper','common_js','fromvalidation','ModalDialog','jasons_date_input_calendar/calendarDateInput','js_form'));
		
		$this->data['redirect_url'] = $this->get_redirect_url();
        $this->add_js(array('ajax_helper','fromvalidation','common_js','jasons_date_input_calendar/calendarDateInput','js_form'));
        $this->set_include_files(array('common/admin_menu','user/edit_user'));
        $this->render();
    }

    function update_user()
    {
        $this->check_user_page_access('registered');
        $this->upload_path = BASEPATH.'../images/uploaded/user/';
        $cur_user_id    = $this->input->post('user_id');
        $message    = '';
        $imagename  = '';
        $arr_post = array();
        $temp_arr = array_merge($arr_post, $_POST);
        $this->session->set_userdata('user_values', $temp_arr );
        $this->session->set_userdata('user_messages', array());
        if(trim($this->input->post('f_name'))=='')
            $message    = 'Please give first name';
        elseif(trim($this->input->post('l_name'))=='' )
            $message    = 'Please give last name';
        elseif(trim($this->input->post('email'))=='' )
            $message    = 'Please give email address';
        elseif(trim($this->input->post('user_type_id'))=='' )
            $message    = 'Please give user type';
        /*elseif(trim($this->input->post('country_id'))=='')
            $message    = 'Please select country';
        elseif(trim($this->input->post('state_id'))=='')
            $message    = 'Please select state';
        elseif(trim($this->input->post('city_id'))=='')
            $message    = 'Please select city';
        elseif(trim($this->input->post('zipcode'))=='')
            $message    = 'Please select pincode';*/
        elseif(!preg_match("/^[_a-z0-9-\+]+(\.[_a-z0-9-\+]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $this->input->post('email')) )
            $message    = 'Please give Proper email address';
        else
        {
            $email_exist = $this->users_model->get_user_list_count(array('email'=>$this->input->post('email'),'ext_cond'=>" AND id<>$cur_user_id "));
            if($email_exist && $email_exist>0 )
                $message    = 'Email adderss has been taken by anothe user';
            else
            {
                $max_file_size    =$this->site_settings_model->get_site_settings('max_image_file_size');
                if( isset($_FILES['img']['name']) && $_FILES['img']['name']!='' )
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
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $img_details['full_path'];
                        $config['create_thumb'] = TRUE;
                        $config['maintain_ratio'] = TRUE;
                        $config['thumb_marker'] = '';
                        $config['width'] = 77;
                        $config['height'] = 150;
                        $config['new_image'] = $this->upload_path.'thumb/'.$img_details['orig_name'];
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                        $imagename = $img_details['orig_name'];
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
            $arr= array("f_name"=>htmlspecialchars($this->input->post('f_name'), ENT_QUOTES, 'utf-8'),
                        "l_name"=>htmlspecialchars($this->input->post('l_name'), ENT_QUOTES, 'utf-8'),
                        "city_id"=>htmlspecialchars($this->input->post('city_id'), ENT_QUOTES, 'utf-8'),
                        "state_id"=>htmlspecialchars($this->input->post('state_id'), ENT_QUOTES, 'utf-8'),
                        "country_id"=>htmlspecialchars($this->input->post('country_id'), ENT_QUOTES, 'utf-8'),
                        "zipcode"=>htmlspecialchars($this->input->post('zipcode'), ENT_QUOTES, 'utf-8'),
                        "screen_name"=>htmlspecialchars($this->input->post('screen_name'), ENT_QUOTES, 'utf-8'),
                        "phone"=>htmlspecialchars($this->input->post('phone'), ENT_QUOTES, 'utf-8'),
                        "email"=>htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8'),
                        "gender"=>htmlspecialchars($this->input->post('gender'), ENT_QUOTES, 'utf-8'),
                        "dob"=>strtotime(htmlspecialchars($this->input->post('dob'), ENT_QUOTES, 'utf-8')),
                        "occupation_id"=>htmlspecialchars($this->input->post('occupation_id'), ENT_QUOTES, 'utf-8'),
                        "about_yourself"=>htmlspecialchars($this->input->post('about_yourself'), ENT_QUOTES, 'utf-8'),
                        "date_updated"=>time(),
						"user_type_id"=>htmlspecialchars($this->input->post('user_type_id'), ENT_QUOTES, 'utf-8')
                );
            if($imagename!='')
                $arr['img_name']    = $imagename;
            $this->users_model->set_data_update('users',$arr,$cur_user_id);
			
            $this->session->set_userdata('user_values', '' );
            $this->session->set_userdata(array('message'=>'Profile edit successfully','message_type'=>'succ'));
            //header('location:'.base_url().'admin/user');
			header('location:'.$this->get_redirect_url());
            exit();
        }
        if($imagename  != '')
        {
            @unlink($this->upload_path.$imagename);
            @unlink($this->upload_path.'thumb/'.$imagename);
        }
        $this->session->set_userdata(array('message'=>$message,'message_type'=>'err'));
        header('location:'.base_url().'admin/user/edit_user/'.$cur_user_id);
        exit();
 	}
    

    function delete_user($id)
    {
        if($this->users_model->delete_user($id))
            $this->session->set_userdata(array('message'=>'User deleted successfully..','message_type'=>'err'));
        else
            $this->session->set_userdata(array('message'=>'Unable to delete user..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }
	
	function user_report( $page=0 )
	{
		
		$this->check_user_page_access('registered');
		$toshow = $this->admin_page_limit;
		$this->data['title'] = 'Users Report';
		$this->data['user_type'] = $this->users_model->user_type;
		$totRow = $this->users_model->get_user_report_count();
		$this->data['admin_user'] = $this->users_model->user_report($page,$toshow);
		#====  Pagination Starts ==================================
		$this->load->library('pagination');
		$config['base_url'] = base_url()."admin/user/user_report";
		$config['total_rows'] = $totRow;
		$config['per_page'] = $toshow;
		$config['uri_segment']=4;
		$this->pagination->initialize($config);
		$this->data['pagination_link'] = $this->pagination->create_links();
		#====  Pagination End ==================================
		$this->set_include_files(array('common/admin_menu','user/user_report'));
        $this->render();
	}
	
	/*This is for those users only who have added 15 business or 20 reviews or ... */
	function downloadUserReportToCSV()
	{
	  
	  $this->check_user_page_access('registered');
	  global $CI;
	  $query = $this->users_model->get_user_report_csv();
	  $this->load->helper('csv_helper');
	  query_to_csv($query, $headers = TRUE, $download = "user.csv");
	  exit();
	  }
	  
	 function download_user_list()
	{
	  
	 	 	$this->check_user_page_access('registered');
			global $CI;
	  		$query = $this->users_model->get_user_list_csv();
	  		$this->load->helper('csv_helper');
	  		query_to_csv($query, $headers = TRUE, $download = "userlist.csv");
	  		exit();
	  }
    
}
