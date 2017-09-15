<?php
include BASEPATH.'application/controllers/MY_Controller'.EXT;

class View_deals extends MY_Controller
{
    private $invites_arr = array();
    private $pagination_per_page = 10;

    function __construct()
    {
        parent::__construct();
        $this->menu_id = 9;
        $this->load->model('deals_model');
        $this->load->helper('text');
		$this->load->library('jquery_pagination');
    }

    function index($page=0)
    {
        /*
        $current_deals = $this->deals_model->get_current_deals_list();
        $current_deals_count = $this->deals_model->get_current_deals_list_count();
        
        Not in scope now
        $past_deals = $this->deals_model->get_past_deals_list();
        $past_deals_count = $this->deals_model->get_past_deals_list_count();
        */
        
        $keyword = '';
        $type = -1; 
        $category_id = -1;
        $location = '';
        // pr($_POST);
        if(count($_POST)>0 && $_POST['hdn_srch']=='srch')
        {
            $srch_str = '';
            $keyword = htmlentities($this->input->post('keyword'), ENT_QUOTES, 'utf-8');
            $location = htmlentities($this->input->post('location'), ENT_QUOTES, 'utf-8');
            $category_id = intval($this->input->post('category'));
            $type = intval($this->input->post('type'));
        }
        
        //echo '<br />'.$keyword."+++++++".$type."+++++++".$category_id."+++++++".$location."+++++++";
        
        $srch_str = base64_encode($keyword).'|@SEP@|'.$type.'|@SEP@|'.$category_id.'|@SEP@|'.$location;
        $srch_str = base64_encode($srch_str);
        $srch_str = urlencode($srch_str);
        
        
        # ======================================================================
        #          DEALS LISTING & PAGINATION PART [BEGIN]
        # ======================================================================
            
            $result = $this->deals_model->get_current_deals_list($this->pagination_per_page, $page, -1,$keyword, $type,$category_id, $location);
            /* 
            function get_current_deals_list($toshow=-1,$page=0,$id=-1,$keyword='',$type=-1,$category_id=-1, $location = '',$order_name='deal_start',$order_type='desc')
            */
            $resultCount = count($current_deals);
            $total_rows = $this->deals_model->get_current_deals_list_count(-1,$keyword, $type, $category_id, $location);

            $config['base_url'] = base_url().'view_deals/show_current_deals/'.$srch_str.'/';
            $config['total_rows'] = $total_rows;
            $config['per_page'] = $this->pagination_per_page;
            $config['uri_segment'] = 4;
            $config['num_links'] = 9;
            $config['page_query_string'] = false;
            
            /*
            <a href="#"><img alt="" src="images/arrow_left.png"></a>
            <a href="#">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a>
            <a href="#"><img alt="" src="images/arrow_right.png"></a>
            */
            
            $config['prev_link'] = '<img alt="" src="'.base_url().'images/front/arrow_left.png">';
            $config['next_link'] = '<img alt="" src="'.base_url().'images/front/arrow_right.png">';

            $config['cur_tag_open'] = '<strong>';
            $config['cur_tag_close'] = '</strong>';

            $config['next_tag_open'] = '<a href="javascript:void(0)">';
            $config['next_tag_close'] = '</a>';

            $config['prev_tag_open'] = '<a href="javascript:void(0)">';
            $config['prev_tag_close'] = '</a>';

            $config['num_tag_open'] = '<a href="javascript:void(0)">';
            $config['num_tag_close'] = '</a> ';

            $config['div'] = '#deals_listing'; /* Here #content is the CSS selector for target DIV */
            $config['js_bind'] = "showBusyScreen('show_loader'); "; /* if you want to bind extra js code */
            $config['js_rebind'] = "hideBusyScreen('show_loader'); "; /* if you want to rebind extra js code */

            $this->jquery_pagination->initialize($config);
            $this->data['page_links'] = $this->jquery_pagination->create_links();

            // getting note listing...
            $this->data['current_deals'] = $result;
            $this->data['current_deals_count'] = $total_rows;
            $this->data['current_page'] = $page;
            
           // pr($data['current_deals']);

        # ======================================================================
        #          DEALS LISTING & PAGINATION PART [END]
        # ======================================================================
        
        $this->data['title'] = 'Deals';
        $this->data['meta_keywords'] = 'deals';
        $this->data['meta_desc'] = 'deals';
        
        $this->data['search']['keyword'] = $keyword;
        $this->data['search']['type'] = $type; 
        $this->data['search']['category_id'] = $category_id;
        $this->data['search']['location'] = $location;
        $this->data['deals_category_name'] = $this->deals_model->get_deals_category_option($category_id);
        $this->data['deals_location_name'] = $this->deals_model->get_location_name_options($location);
        /*$this->data['current_deals'] = $current_deals;
        $this->data['current_deals_count'] = $current_deals_count;*/
        
        
        
        $this->add_js(array('ajax_helper','common_js','fromvalidation','ModalDialog','jasons_date_input_calendar/calendarDateInput','js_form'));
        $this->add_css('autocomplete');
        $this->set_include_files(array('deals/deals'));
        $this->render();
        
    }
    
    // Ajax paginition purpose...
    function show_current_deals($srch_str, $page=0)
    {
        $srch_str_decoded = urldecode($srch_str);
        $srch_str_decoded = base64_decode($srch_str_decoded);
        
        $srch_data = explode('|@SEP@|', $srch_str_decoded);
        $srch_data[0] = base64_decode($srch_data[0]);
        // pr($srch_data);
        
        $keyword = trim($srch_data[0]);
        $type = (intval($srch_data[1])==0)?-1:intval($srch_data[1]); 
        $category_id = (intval($srch_data[2])==0)?-1:intval($srch_data[2]); 
        $location = trim($srch_data[3]);;
        
        # ======================================================================
        #          DEALS LISTING & PAGINATION PART [BEGIN]
        # ======================================================================
            
            $result = $this->deals_model->get_current_deals_list($this->pagination_per_page, $page, -1,$keyword, $type,$category_id, $location);

            $resultCount = count($current_deals);
            $total_rows = $this->deals_model->get_current_deals_list_count(-1,$keyword, $type,$category_id, $location);

            $config['base_url'] = base_url().'view_deals/show_current_deals/'.$srch_str.'/';
            $config['total_rows'] = $total_rows;
            $config['per_page'] = $this->pagination_per_page;
            $config['uri_segment'] = 4;
            $config['num_links'] = 9;
            $config['page_query_string'] = false;
            
            /*
            <a href="#"><img alt="" src="images/arrow_left.png"></a>
            <a href="#">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a>
            <a href="#"><img alt="" src="images/arrow_right.png"></a>
            */
            
            $config['prev_link'] = '<img alt="" src="'.base_url().'images/front/arrow_left.png">';
            $config['next_link'] = '<img alt="" src="'.base_url().'images/front/arrow_right.png">';

            $config['cur_tag_open'] = '<strong>';
            $config['cur_tag_close'] = '</strong>';

            $config['next_tag_open'] = '<a href="javascript:void(0)">';
            $config['next_tag_close'] = '</a>';

            $config['prev_tag_open'] = '<a href="javascript:void(0)">';
            $config['prev_tag_close'] = '</a>';

            $config['num_tag_open'] = '<a href="#">';
            $config['num_tag_close'] = '</a> ';

            $config['div'] = '#deals_listing'; /* Here #content is the CSS selector for target DIV */
            $config['js_bind'] = "showBusyScreen('show_loader'); "; /* if you want to bind extra js code */
            $config['js_rebind'] = "hideBusyScreen('show_loader'); "; /* if you want to rebind extra js code */

            $this->jquery_pagination->initialize($config);
            $this->data['page_links'] = $this->jquery_pagination->create_links();

            // getting note listing...
            $this->data['current_deals'] = $result;
            $this->data['current_deals_count'] = $total_rows;
            $this->data['current_page'] = $page;
            
           // pr($data['current_deals']);

        # ======================================================================
        #          DEALS LISTING & PAGINATION PART [END]
        # ======================================================================


        ////////////////////////////////////////////////////////////////////////

        //dump($data);
        # rendering the view file...
        $view_file = 'deals/ajax/current_deals.tpl.php';
        $this->load->view($view_file, $this->data);
        
    }
    
    
    function details($id)
    {
        $current_deal_details = $this->deals_model->get_current_deals_list(-1, 0, $id);
        if(count($current_deal_details)<1)
            redirect('view_deals');
        $this->data['title'] = 'Deals';
        $this->data['meta_keywords'] = 'deals';
        $this->data['meta_desc'] = 'deals';
        $this->data['deal_details'] = $current_deal_details[0];
        
        $this->add_js(array('ajax_helper','common_js','fromvalidation','ModalDialog','jasons_date_input_calendar/calendarDateInput','js_form', 'js-timer'));
        $this->add_css('autocomplete');
        $this->set_include_files(array('deals/deal_details'));
        $this->render();
        
    }
    
    
    function getEndTimeAJAX($id)
    {
         $id = intval($id);      
         $deal_details = $this->deals_model->get_current_deals_list(-1, 0, $id);
         $end_date_time = date('m/d/Y H:i', $deal_details[0]['deal_end']);
         echo json_encode(array('deal_end_time'=>$end_date_time));
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /**
    * Previous code.............
    * 
    */
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
			$this->data['zipcode_option']    = $this->location_model->get_zip_code_list_option($this->data['old_values']['zipcode'],$city_id);

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
	function get_zipcode_ajax() 
    {
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

}
