<?php
include BASEPATH.'application/controllers/MY_Controller'.EXT;

class Party extends MY_Controller
{
    private $user_type_id='';
	private $invites_arr = array();

    function __construct()
    {
        parent::__construct();
        $this->clear_business_search();
        $this->user_type_id = $this->session->userdata('user_type_id');
		$this->menu_id = 6;
		$this->load->model('party_model');
		$this->load->model('business_model');
    }

    function index()
    {
        header("location:".base_url().'profile');
		exit;
    }

    function add_party($business_id = -1)
    {
		if($business_id != -1 && $business_id > 0)
		{
			$business_detail = $this->business_model->get_business_list(array('id'=>$business_id));
			if(!$business_detail || count($business_detail)<0)
			{
				$this->session->set_userdata(array('message'=>"Sorry, Business not exists",'message_type'=>'err'));
				header('location:'.base_url().'user/message_page');
				exit();
			}
			$this->data['business_id'] = $business_id;
		}

		$this->check_user_page_access('registered');
		$this->data['title'] = 'Plan a Party, Event or Get Together and Invite Friends and Family';
		$this->data['meta_keywords'] = 'Party planning, Plan party, party planners, Party tips, Party ideas, invitations, Party invitations, Party invitation, party help, party planning help, theme party, theme parties, invitation cards, Invitation card';
		$this->data['meta_desc'] = 'Plan a Party, Event or Get Together and Invite Friends and Family';

		if($this->session->userdata('user_type_id') != 2)
		{
			$this->session->set_userdata(array('message'=>"You don't have permission to add a party",'message_type'=>'err'));
			header('location:'.base_url().'user/message_page');
			exit();
		}

		$this->load->model('category_model');
		$this->load->model('location_model');
		$this->load->model('occasion_model');
		$this->load->model('date_time_model');
                $this->load->model('article_model');
                
		$this->load->library('generat_calender');

                $this->data['party_page_upper_text'] = $this->article_model->get_article_list(1, 0, -1, '', 1, 'party_add');

		/*These two lines for getting max file size can be uploaded by user*/
       	$this->load->model('site_settings_model'); 
		$this->data['max_file_size'] = $this->site_settings_model->get_site_settings('max_image_file_size');
		$this->data['old_values'] = $this->session->userdata('user_values');
		$this->session->set_userdata('user_values', '' );
		
		$occasion_id = ($this->data['old_values']['occasion_id"']) ? $this->data['old_values']['occasion_id"'] : '';
		$country_id = (isset($business_detail[0]['country_id'])) ? $business_detail[0]['country_id'] : (($this->data['old_values']['country_id'] != '') ? $this->data['old_values']['country_id'] : 113);
		$state_id = (isset($business_detail[0]['state_id'])) ? $business_detail[0]['state_id'] : $this->data['old_values']['state_id'];
		$city_id = (isset($business_detail[0]['city_id'])) ? $business_detail[0]['city_id'] : $this->data['old_values']['city_id'];
		$zip_code = (isset($business_detail[0]['city_id'])) ? $this->location_model->get_location_list(1, 0, array('id'=>$business_detail[0]['zipcode'])) : '';
		$business_category = ($business_detail[0]['business_category']) ? $business_detail[0]['business_category'] : $this->data['old_values']['business_type_id'];

		$this->data['occasion_option'] = $this->occasion_model->get_occasion_option($occasion_id);
		$this->data['business_category']    = makeOption($this->category_model->get_cat_selectlist(),$business_category);
		$this->category_model->option_results='';
		if($business_category>0)
			$this->data['business_type']    = makeOption($this->category_model->get_cat_selectlist('',$business_category),$this->data['old_values']['business_type_id']);
		$this->data['country_option']    = $this->location_model->get_country_list_option($country_id);
		$this->data['state_option']    = $this->location_model->get_state_list_option($state_id,$country_id);
		if($state_id>0)
			$this->data['city_option']    = $this->location_model->get_city_list_option($city_id,$state_id);
		if($city_id>0)
			//$this->data['zipcode_option']    = $this->location_model->get_zip_code_list_option($this->data['old_values']['zipcode'],$city_id);

		$this->data['phone_no'] = 	($business_detail[0]['phone_number'])?$business_detail[0]['phone_number']:$this->data['old_values']['phone_no'];
		$this->data['location_name'] = 	($business_detail[0]['name'])?$business_detail[0]['name']:$this->data['old_values']['location_name'];
		$this->data['zip_code'] = 	(isset($zip_code[0]['zipcode']))? $zip_code[0]['zipcode']:$this->data['old_values']['zipcode'];
		$this->data['street_address'] = ($business_detail[0]['address'])?$business_detail[0]['address']:$this->data['old_values']['street_address'];


		/*		if(!isset($this->data['old_values']) || count($this->data['old_values'])<1 || $this->data['old_values'].'a'=='a')
		{
			$tmp    = $this->users_model->get_user_list(1,0,array('id'=>$cur_user_id));
			$this->data['old_values'] = $tmp[0];
			$this->data['old_values']['dob'] = date('Y-m-d',$tmp[0]['dob']);
		}*/

		$this->data['dob']	= $this->generat_calender->calender('dob',$this->data['old_values']['dob']);
		$this->data['hour_option']    = $this->date_time_model->generate_hour_option($this->data['old_values']['hour']);
		$this->data['min_option']    = $this->date_time_model->generate_min_option($this->data['old_values']['min']);

		$this->add_js(array('ajax_helper','common_js','fromvalidation','ModalDialog','jasons_date_input_calendar/calendarDateInput','js_form'));
		$this->add_css('autocomplete');
		$this->set_include_files(array('party/add_party'));
		$this->render();
   	}
	
	function party_details($party_id=-1,$invite_id='')
	{
		$this->data['title'] = 'Party Details';
		if($party_id==-1 || $party_id=='')
		{
			$this->session->set_userdata(array('message'=>"Sorry, party not available now. ",'message_type'=>'err'));
			header('location:'.base_url().'user/message_page');
            exit();
		}
		if($invite_id!='')  // checking for non - invited users
		{
			$invite = $this->party_model->get_party_invitation_list(1,0,array('id'=>$invite_id));
			if(!$invite)
			{
				$this->session->set_userdata(array('message'=>"Sorry, party not party not opened for you.",'message_type'=>'err'));
				header('location:'.base_url().'user/message_page');
				exit();
			}
		}
		
		$arr = array('id'=>$party_id);
		$this->data['party_details'] = $this->party_model->get_party_list($arr,1,0);
		//var_dump($this->data['party_details']);
		$this->data['invite_id'] = $invite_id;
		
		$this->data['party_no_reply_list'] =$this->party_model->get_party_invitation_list(-1,0,array('party_id'=>$party_id,'status'=>0));	
		$this->data['party_yes_list'] =$this->party_model->get_party_invitation_list(-1,0,array('party_id'=>$party_id,'status'=>1));	
		$this->data['party_no_list'] =$this->party_model->get_party_invitation_list(-1,0,array('party_id'=>$party_id,'status'=>2));	
		$this->data['party_undecided_list'] =$this->party_model->get_party_invitation_list(-1,0,array('party_id'=>$party_id,'status'=>3));
			
		$this->data['gmap_key'] = $this->site_settings_model->get_site_settings('google_api_key');	
		
		
		/* google map */
		$map_address =array( array("{$this->data['party_details'][0]['city']},{$this->data['party_details'][0]['state']},{$this->data['party_details'][0]['zipcode']},{$this->data['party_details'][0]['country']}","{$this->data['party_details'][0]['location_name']}",""));

		$gmap_key = $this->site_settings_model->get_site_settings('google_api_key');
		$gmap_width="400px";
		$gmap_height="305px";
		$gmap_type="G_NORMAL_MAP";
		
		$gmap_controls=array('GLargeMapControl','GScaleControl','GMapTypeControl');
		
		ob_start();
		include( BASEPATH."application/libraries/libgmap/libgmap.php");
		$this->data['gmap_html'] = ob_get_contents();
		ob_end_clean();
		
		/* -------------google map --------------*/

		// This Session Variable is being set from the "save_party" Controller Method
		$this->data['session_back_url_from_preview'] = $this->session->userdata('back_url_from_preview');

        $this->add_js(array('thickbox'));
		$this->add_css(array('thickbox'));
        $this->set_include_files(array('party/party_details'));
        $this->render();
   	}	
	
	function auto_complete_location_name($business_type_id = 2, $extra_req = '')
	{
		$letter = $this->input->post('queryString');
		$arr = array('business_category'=>$business_type_id,'name_back_wildcard'=>$letter);
		$location = $this->business_model->get_business_list($arr, -1, 0, 'name', 'ASC');
		foreach($location as $value)
		{
			$extra_value = '';
			if(!empty($extra_req))
			{
				if($extra_req == 'address')
				{
					$extra_value = ' ('.$value['address'].' )';
				}
			}
			
			echo '<li onclick="fill(\''.$value['name'].'\', \''.$value['id'].'\');">'.$value['name'].$extra_value.'</li>';
		}	
			
	}

	function get_street_address_ajax()
    {
        $business_type_id = $this->input->post('id');
        $location_name = $this->input->post('name');
		$arr = array('business_name'=>$location_name,'business_category'=>$business_type_id);
		$business_details = $this->business_model->get_business_list($arr,1,0);
		
        //$this->load->model('location_model');
        $htm    = '<input type="text" name="street_address" id="street_address" style="width:370px;" value="'.$business_details[0]['address'].'"/>';
        echo $htm;
    }
	
    function get_state_ajax()
    {
        $business_type_id = $this->input->post('id');
        $location_name = $this->input->post('name');
		$arr = array('business_name'=>$location_name,'business_category'=>$business_type_id);
		$business_details = $this->business_model->get_business_list($arr,1,0);
		
        $this->load->model('location_model');
        $htm    ='<select id="state_id" name="state_id" onchange="fun_state(this.value);">
                            <option value="">Select a state</option>'.
                            $this->location_model->get_state_list_option($business_details[0]['state_id']).
                        '</select>';
        echo $htm;
    }

    function get_city_ajax()
    {
        $business_type_id = $this->input->post('id');
        $location_name = $this->input->post('name');
		$arr = array('business_name'=>$location_name,'business_category'=>$business_type_id);
		$business_details = $this->business_model->get_business_list($arr,1,0);  
		$this->load->model('location_model');

            $htm    ='<select id="city_id" name="city_id" onchange="fun_city(this.value);">
                            <option value="">Select a city</option>'.
                            $this->location_model->get_city_list_option_party($business_details[0]['city_id']).
                        '</select>';
        echo $htm;
    }
    
	/**
	 * @author Anutosh Ghosh
	 */
	function get_zipcode_ajax() {
		$business_type_id = $this->input->post('id');
		$location_name = $this->input->post('name');
		$arr = array('business_name' => $location_name, 'business_category' => $business_type_id);
		$business_details = $this->business_model->get_business_list($arr, 1, 0);

		if(isset($business_details[0]['zipcode']) && !empty($business_details[0]['zipcode']))
		{
			$this->load->model('location_model');
			$zipcode_value = $this->location_model->get_zip_code_list_option($business_details[0]['zipcode'], 0, 'text');
			$htm = '<input type="text" name="zipcode" id="zipcode" value="'.$zipcode_value.'" style="width:370px;" />';
		}
		else {
			$htm = '<input type="text" name="zipcode" id="zipcode" value="" style="width:370px;" />';
		}
		
		echo $htm;
	}
	
	function verify_invitation($invite_id='')
	{
		if($invite_id=='' || $invite_id<1)
		{
            $this->session->set_userdata(array('message'=>"You have got wrong party or party already closed.",'message_type'=>'err'));
            header('location:'.base_url().'user/message_page');
            exit();	
		}
		$invite = $this->party_model->get_party_invitation_list(1,0,array('id'=>$invite_id));
		
		header('location:'.base_url().'party/party_details/'.$invite[0]['party_id'].'/'.$invite_id);
		exit;		
		
	}

	function save_plan_reply()
	{
        $message    = '';
        $arr_post = array();
        $temp_arr = array_merge($arr_post, $_POST);
        if( trim($this->input->post('status')) != 2 && trim($this->input->post('no_of_guest'))=='')
            $message    = 'Please give guest number ';
		if(!$this->input->post('chk_email') && $this->input->post('guest_name')=='')
			$message    = 'Please give your name';
		$invite_id = htmlspecialchars($this->input->post('invite_id'), ENT_QUOTES, 'utf-8');
		if($invite_id=='')
		{
            $this->session->set_userdata(array('message'=>"Your invitation may be wrong.",'message_type'=>'err'));
            header('location:'.base_url().'user/message_page');
            exit();			
		}
		$invite = $this->party_model->get_party_invitation_list(1,0,array('id'=>$invite_id));

        if($message=='' )
        {
			$guest_name = ($this->input->post('chk_email')) ? $invite[0]['email_id'] : $this->input->post('guest_name');
            $arr = array("comment"=>htmlspecialchars($this->input->post('comment'), ENT_QUOTES, 'utf-8'),
						"no_of_guest"=>htmlspecialchars($this->input->post('no_of_guest'), ENT_QUOTES, 'utf-8'),
						"guest_name"=>htmlspecialchars($guest_name, ENT_QUOTES, 'utf-8'),
						"status"=>htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8')
                );
				
            $partyId	= $this->party_model->set_data_update('invites',$arr,$invite_id);
			
            if($partyId)
            {
				//var_dump($invite);
				//$this->load->model('automail_model');
				//$mail_type = 'invite_party_reply';
				//$this->automail_model->send_reply_mail_against_party_invitation($invite[0]['user_email'], $mail_type, $invite_id);
				
				$this->session->set_userdata(array('message'=>'Thanks for your reply.','message_type'=>'succ'));
                header('location:'.base_url().'party/party_details/'.$invite[0]['party_id'].'/'.$invite_id);
                exit();
            }
            else
            {
                $this->session->set_userdata(array('message'=>'Unable to send your reply about the party','message_type'=>'err'));
                header('location:'.base_url().'user/message_page');
                exit();
            }
        }
		$this->session->set_userdata(array('message'=>$message,'message_type'=>'err'));
        header('location:'.base_url().'party/party_details/'.$invite[0]['party_id'].'/'.$invite_id);
        exit();
		
		
	}

	function address_book_ajax()
    {
        $this->load->model('profile_normal_model');
        $cur_user_id    = $this->session->userdata('user_id');
        $data = array();
        $data['rows'] = $this->profile_normal_model->get_address_book_list($cur_user_id);
        $this->load->view('party/party_address_book_list.tpl.php',$data);
    }

	function get_imported_users()
	{
		$sel_users = $this->input->post('sel_users');
		if(!$sel_users)
			return false;
		$str = '';	
		foreach($sel_users as $value)
		{
			$str .= ($str) ? ','.$value:$value;
		}	
		echo $str;
	}
	
	function show_google_map($party_id=-1)
	{
		if($party_id=='' || $party_id==-1)
			return false;
		$this->load->model('location_model');
		$this->data['party_details'] = $this->party_model->get_party_list(array('id'=>$id,1,0));
		$this->data['country'] = $this->location_model->get_country_name_by_id($this->data['party_details'][0]['country_id']);
		$this->data['state'] = $this->location_model->get_state_name_by_id($this->data['party_details'][0]['state_id']);
		$this->data['city'] = $this->location_model->get_city_name_by_id($this->data['party_details'][0]['city_id']);
		//var_dump($this->data['party_details']);
		$this->load->view('party/show_google_map.tpl.php',$this->data);
	}

	/**
	 * @author Anutosh Ghosh
	 */
	function edit_party($party_id = 0) {
		if ($this->session->userdata('user_type_id') != 2) {
			$this->session->set_userdata(array(
				'message' => "You don't have permission to edit this Party.",
				'message_type' => 'err'
			));
			header("Location: " . base_url().'user/message_page');
			exit();
		}

		if (empty($party_id) || $party_id < 1) {
			$this->session->set_userdata(array(
				'message' => 'Please edit a valid Party.',
				'message_type' => 'err'
			));
			header("Location: " . base_url().'user/message_page');
			exit();
		}

		$this->check_user_page_access('registered');
		$arr_temp_party_details = $this->party_model->get_party_list(array('id' => $party_id), 1);

		if ($this->session->userdata('user_values')) {
			$this->data['data'] = array_merge($arr_temp_party_details[0], $this->session->userdata('user_values'));
		}
		else {
			$this->data['data'] = $arr_temp_party_details[0];
		}

		if (empty($this->data['data'])) {
			$this->data['data'] = $arr_temp_party_details[0];
			#unset($arr_temp_party_details);
		} else {
			/*foreach ($this->data['data'] as $key => $val) {
				if (empty($val)) {
					$this->data['data'][$key] = $arr_temp_party_details[0][$key];
				}
			}*/
		}

		if ($this->data['data']['cr_by'] != $this->session->userdata('user_id')) {
			$this->session->set_userdata(array(
				'message' => "Sorry, you cannot edit this Party, as you are not the Creator of this one.",
				'message_type' => 'err'
			));
			header("Location: " . base_url().'user/message_page');
			exit();
		}

		$this->load->model('category_model');
		$this->load->model('location_model');
		$this->load->model('occasion_model');
		$this->load->model('date_time_model');
		$this->load->library('generat_calender');

		$this->load->model('article_model');

		/*These two lines for getting max file size can be uploaded by user*/
       	$this->load->model('site_settings_model'); 
		$this->data['max_file_size'] = $this->site_settings_model->get_site_settings('max_image_file_size');
		
		$this->data['title'] = 'Edit Party';
		$this->data['style_width_box_gen'] = 'width: 370px;';

		$this->data['party_page_upper_text'] = $this->article_model->get_article_list(1, 0, -1, '', 1, 'party_add');

		$occasion_id = ($this->data['data']['occasion_id"']) ? $this->data['data']['occasion_id"'] : '';
		$this->data['occasion_option'] = $this->occasion_model->get_occasion_option($occasion_id);
		#$this->data['business_category'] = makeOption($this->category_model->get_cat_selectlist(), $this->data['data']['business_category']);
		$this->data['business_category'] = makeOption($this->category_model->get_cat_selectlist(), $this->data['data']['business_type_id']);
		if ($this->data['data']['business_type_id']) {
			$this->data['business_type'] = makeOption($this->category_model->get_cat_selectlist('', $this->data['data']['business_type_id']), $this->data['data']['business_type_id']);
		}

		$this->data['country_option'] = $this->location_model->get_country_list_option($this->data['data']['country_id']);
		$this->data['state_option'] = $this->location_model->get_state_list_option($this->data['data']['state_id'], $this->data['data']['country_id']);
		if ($this->data['data']['state_id']) {
			$this->data['city_option'] = $this->location_model->get_city_list_option($this->data['data']['city_id'], $this->data['data']['state_id']);
		}

		$this->data['zip_code'] = (!empty($this->data['data']['city_id'])) ? $this->data['data']['zipcode'] : '';
		#$this->data['street_address'] = 

		$temp_dob_part = (isset($this->data['data']['dob'])) ? $this->data['data']['dob'] : date('Y-m-d', $this->data['data']['start_date']);
		$this->data['dob'] = $this->generat_calender->calender('dob', $temp_dob_part);

		$temp_hour_part = (isset($this->data['data']['hour'])) ? $this->data['data']['hour'] : date('H', $this->data['data']['start_date']);
		$this->data['hour_option'] = $this->date_time_model->generate_hour_option($temp_hour_part);

		$temp_min_part = (isset($this->data['data']['min'])) ? $this->data['data']['min'] : date('i', $this->data['data']['start_date']);
		$this->data['min_option'] = $this->date_time_model->generate_min_option($temp_min_part);

		$party_invitees = $this->party_model->get_party_invitation_list(0, 0, array('party_id' => $party_id));
		if (is_array($party_invitees)) {
			foreach ($party_invitees as $values) {
				if (!empty($this->data['data']['selected_invitees']))
					$this->data['data']['selected_invitees'] .= ', ';
				$this->data['data']['selected_invitees'] .= $values['email_id'];
			}
		}
		else {
			$this->data['data']['selected_invitees'] = $party_invitees;
		}

		// As this Session Variable will be used in the Save Party Method of this Controller,
		// so don't unset this Session Variable.
		$this->session->set_userdata('invited_guest_list', $this->data['data']['selected_invitees']);

		$this->add_js(array(
			'ajax_helper',
			'common_js',
			'fromvalidation',
			'ModalDialog',
			'jasons_date_input_calendar/calendarDateInput',
			'js_form',
			'thickbox',
			'jquery.form'
		));
		$this->add_css(array('thickbox'));
		$this->set_include_files(array('party/edit_party'));
		$this->render();
	}

	/**
	 * @author Iman Biswas
	 * @author Anutosh Ghosh
	 */
	function save_party() {
		$this->check_user_page_access('registered');
		$this->upload_path = $this->config->item('upload_image_folder_plan');

		$message = '';
		$imagename = '';
		$arr_post = array();
		$temp_arr = array_merge($arr_post, $_POST);
		$flag_source_add_party = TRUE;
		$str_target_url = "";
		$str_invited_guest_list = "";

		$this->session->set_userdata('user_values', $temp_arr);
		$this->session->set_userdata('user_messages', array());

		if ($this->input->post('shakalaka')) {
			$flag_source_add_party = FALSE;
			$partyId = $this->input->post('id');

			$str_invited_guest_list = $this->session->userdata('invited_guest_list');
			$arr_invited_guest_list = explode(', ', $str_invited_guest_list);
			$arr_invited_guest_list = array_map('trim', $arr_invited_guest_list);
		}

		if (trim($this->input->post('event_title')) == '')
			$message = 'Please give Event Title';
		elseif (trim($this->input->post('occasion_id')) == '')
			$message = 'Please select Occasion';
		elseif (trim($this->input->post('host_name')) == '')
			$message = 'Please give Host Name';
		elseif (trim($this->input->post('phone_no')) == '')
			$message = 'Please give Phone Number';
		elseif (trim($this->input->post('business_type_id')) == '')
			$message = 'Please select Location';
		elseif (trim($this->input->post('location_name')) == '')
			$message = 'Please give your Location Name';
		elseif (trim($this->input->post('country_id')) == '')
			$message = 'Please select Country';
		elseif (trim($this->input->post('state_id')) == '')
			$message = 'Please select State';
		elseif (trim($this->input->post('city_id')) == '')
			$message = 'Please select City';
		elseif (trim($this->input->post('zipcode')) == '')
			$message = 'Please select Zipcode';
		elseif (trim($this->input->post('status')) == 1) {
			if (empty($arr_invited_guest_list) && trim($this->input->post('invites')) == '')
				$message = 'Please give Minimum one Email ID';
			else {
				$invites = htmlspecialchars($this->input->post('invites'), ENT_QUOTES, 'utf-8');
				$temp_arr_invitees = explode(',', $invites);
				$temp_arr_invitees = array_map('trim', $temp_arr_invitees);
				$str = '';
				
				foreach ($temp_arr_invitees as $value) {
					if (!preg_match("/^[_a-z0-9-\+]+(\.[_a-z0-9-\+]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $value))
						$str = ($str) ? $str . ', ' . $value : $value;

					if (!$flag_source_add_party) {
						if (in_array($value, $arr_invited_guest_list)) {
							continue;
						}
					}

					if (!in_array($value, $this->invites_arr))
						$this->invites_arr[] = $value;
				}
				if ($str)
					$message = $str . ' Invalid Email ID';

				unset($temp_arr_invitees);
			}
		}

		$max_file_size = $this->site_settings_model->get_site_settings('max_image_file_size');
		if (isset($_FILES['img']['name']) && !empty($_FILES['img']['name'])) {
			$img_details_1 = upload_file($this,
					array('upload_path' => $this->upload_path,
						'file_name' => 'business_' . time(),
						'allowed_types' => $this->config->item('image_support_extensions'),
						'max_size' => $max_file_size,
						'max_width' => '0',
						'max_height' => '0',
					), 'img'
			);
			if (is_array($img_details_1))
			{
				$this->load->library('image_lib');
				$imagename = $img_details_1['orig_name'];
				
				$config['image_library'] = 'gd2';
				$config['source_image'] = $img_details_1['full_path'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['thumb_marker'] = '';
				$config['width'] = 272;
				$config['height'] = 245;
				$config['new_image'] = $this->upload_path . $this->config->item('image_folder_thumb') . $imagename;
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();

				$showable_image['image_library'] = 'gd2';
				$showable_image['source_image'] = $img_details_1['full_path'];
				$showable_image['create_thumb'] = TRUE;
				$showable_image['maintain_ratio'] = TRUE;
				$showable_image['thumb_marker'] = '';
				$showable_image['width'] = $this->config->item('image_view_width');
				$showable_image['height'] = $this->config->item('image_view_height');
				$showable_image['new_image'] = $this->upload_path . $this->config->item('image_folder_view') . $imagename;
				$this->image_lib->initialize($showable_image);
				$this->image_lib->resize();
				$this->image_lib->clear();
			} else {
				$err = explode('|', $img_details_1);
				$message = $err[0];
			}
		}

		if (empty($message)) {
			$start_date = strtotime($this->input->post('dob') . ' ' . $this->input->post('hour') . ':' . $this->input->post('min'));
			$guest_cansee_each_other = 	(htmlspecialchars($this->input->post('guest_cansee_each_other'), ENT_QUOTES, 'utf-8') ? htmlspecialchars($this->input->post('guest_cansee_each_other'), ENT_QUOTES, 'utf-8') : 'N');
			$rsvp_required = (htmlspecialchars($this->input->post('rsvp_required'), ENT_QUOTES, 'utf-8') ? htmlspecialchars($this->input->post('rsvp_required'), ENT_QUOTES, 'utf-8') : 'N');
			$notify_guest_reply = (htmlspecialchars($this->input->post('notify_guest_reply'), ENT_QUOTES, 'utf-8') ? htmlspecialchars($this->input->post('notify_guest_reply'), ENT_QUOTES, 'utf-8') : 'N');			

			$arr = array(
				"event_title" => htmlspecialchars($this->input->post('event_title'), ENT_QUOTES, 'utf-8'),
				"occasion_id" => htmlspecialchars($this->input->post('occasion_id'), ENT_QUOTES, 'utf-8'),
				"host_name" => htmlspecialchars($this->input->post('host_name'), ENT_QUOTES, 'utf-8'),
				"phone_no" => htmlspecialchars($this->input->post('phone_no'), ENT_QUOTES, 'utf-8'),
				"business_type_id" => htmlspecialchars($this->input->post('business_type_id'), ENT_QUOTES, 'utf-8'),
				"location_name" => htmlspecialchars($this->input->post('location_name'), ENT_QUOTES, 'utf-8'),
				"country_id" => htmlspecialchars($this->input->post('country_id'), ENT_QUOTES, 'utf-8'),
				"state_id" => htmlspecialchars($this->input->post('state_id'), ENT_QUOTES, 'utf-8'),
				"city_id" => htmlspecialchars($this->input->post('city_id'), ENT_QUOTES, 'utf-8'),
				"zipcode" => htmlspecialchars($this->input->post('zipcode'), ENT_QUOTES, 'utf-8'),
				"street_address" => htmlspecialchars($this->input->post('street_address'), ENT_QUOTES, 'utf-8'),
				"guest_cansee_each_other" => $guest_cansee_each_other,
				"rsvp_required" => $rsvp_required ,
				"notify_guest_reply" => $notify_guest_reply,
				"message" => htmlspecialchars($this->input->post('message'), ENT_QUOTES, 'utf-8'),
				"img_name" => ($imagename == '') ? $this->input->post('img_name') : $imagename,
				"start_date" => $start_date,
				"cr_date" => time(),
				"cr_by" => $this->session->userdata('user_id'),
				"status" => htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8')
			);

			if ($flag_source_add_party && empty($partyId)) {
				$partyId = $this->party_model->set_data_insert('party', $arr);
			}
			else {
				$update_result = $this->party_model->set_data_update('party', $arr, $partyId);
			}

			if ($partyId) {
				// This Session Variable must be unset here only before the checking of the Status of the Party.
				#$this->session->unset_userdata("back_url_from_preview");
				
				if (trim($this->input->post('status')) == 1) {
					$this->load->model('automail_model');
					$arr = array(
						'party_id' => $partyId,
						'rsvp_status' => htmlspecialchars($this->input->post('rsvp_required'), ENT_QUOTES, 'utf-8')
					);

					if( !$flag_source_add_party && is_array($arr_invited_guest_list))
					{
						
						$this->invites_arr = array_merge( $this->invites_arr, $arr_invited_guest_list );
						$this->invites_arr = array_unique($this->invites_arr);
						$this->party_model->set_data_delete('invites',array('party_id'=>$partyId));
					}
					foreach ($this->invites_arr as $value) {
						if (!empty($value)) {
							$arr['email_id'] = $value;
							$invite_id = $this->party_model->set_data_insert('invites', $arr);
							/* send mail */
							$mail_type = 'invite_party';
							$this->automail_model->send_party_invitation_mail($value, $mail_type, $partyId, $invite_id);
						}
					}
				}
				else if (trim($this->input->post('status')) == 3) {
					// As this Session Variable will be used in the Preview Page,
					// so don't unset this Session Variable, except when saving the Party at last.

					/*if ($flag_source_add_party) {
						$this->session->set_userdata('back_url_from_preview', base_url().'party/add_party/0/'.$partyId);
					}
					else {*/
						$this->session->set_userdata('back_url_from_preview', base_url().'party/edit_party/'.$partyId);
					//}
				}

				$this->session->set_userdata('user_values', '');
				$this->session->unset_userdata(array(
					'invited_guest_list'
				));
				$str_target_url = base_url() . 'party/party_details/' . $partyId;
			}
			else {
				if ($imagename != '') {
					@unlink($this->upload_path . $imagename);
					@unlink($this->upload_path . $this->config->item('image_folder_thumb') . $imagename);
					@unlink($this->upload_path . $this->config->item('image_folder_view') . $imagename);
				}

				$this->session->set_userdata(array(
					'message' => 'Unable to Add Party',
					'message_type' => 'err'
				));
				$this->session->set_userdata('user_values', '');
				$str_target_url = base_url() . 'user/message_page';
			}

			header('Location:' . $str_target_url);
			exit();
		}

		if ($imagename != '') {
			@unlink($this->upload_path . $imagename);
			@unlink($this->upload_path . $this->config->item('image_folder_thumb') . $imagename);
			@unlink($this->upload_path . $this->config->item('image_folder_view') . $imagename);
		}

		$business_id = htmlspecialchars($this->input->post('business_id'), ENT_QUOTES, 'utf-8');
		$this->session->set_userdata(array(
			'message' => $message,
			'message_type' => 'err'
		));

		if ($flag_source_add_party) {
			$str_target_url = base_url() . 'party/add_party/' . $business_id;
		}
		else {
			$str_target_url = base_url() . 'party/edit_party/' . $partyId;
		}

		header('Location:' . $str_target_url);
		exit();
	}
}
