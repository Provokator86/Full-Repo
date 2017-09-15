<?php
include BASEPATH.'application/controllers/MY_Controller'.EXT;
class ajax_controller extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        header("location:".base_url().'profile');
        exit;
    }

    function ajax_like_review($review_id)
    {	
        
		$this->load->model('review_model');
        $val    = $this->review_model->set_review_like_status($review_id,$this->session->userdata('user_id'));

		if($val)
            echo $val;
		#==========================================================================
		/*These lines are  for sending email to admin and review writer for informing  like review */
		if($val != 'Like this')
		{
			
			$arr['review_id'] = $review_id;
			$mail_type = "like_review" ;
			$this->load->model('automail_model');
			$this->automail_model->send_like_review_mail_to_review_writer($arr,'review_writer_mail');
			$this->automail_model->send_like_review_mail_to_admin($arr,$mail_type);

		}
		#========================================================================

    }

    function ajax_message()
    {
		if($this->session->userdata('user_type_id')==4) 
		{
			echo '<span style="color:#FF0000;font-weight:bold;">Please click on "Your Account" link on top right corner of this page to go to your account page and to claim this business.</span>';
		}
		else {
            echo '<span style="color:#FF0000;font-weight:bold;">You can claim this business by logging in as a merchant. If you already have a merchant     account or if you want to create a merchant account please go to promote your business tab and sign up or login.</span>';
		}		
    }

    function ajax_show_restaurant_menu($id=-1)
    {
        $id     = (isset($id) && $id>0)?$id:-1;
        $data['file_path']  = $this->config->item('view_image_folder_biz');
        $this->load->model('business_model');
        $data['business']=$this->business_model->get_business_list(array('id'=>$id));
        $this->load->view('ajax_view/restaurant_menu.tpl.php',$data);
    }
    
    function ajax_show_login($item_type='',$item_id='')
    {
        $data['item_type']   = $item_type;
        $data['item_id']   = $item_id;
        $this->load->view('ajax_view/ajax_login.tpl.php',$data);
    }
    
	/**
	 *
	 * @param string $item_type
	 * @param int $item_id
	 * @author Anutosh Ghosh
	 */
    function ajax_show_upload_menu($item_type='',$item_id='')
    {
        $data['item_type'] = $item_type;
        $data['item_id']   = $item_id;
		
		/*These two lines for getting max file size can be uploaded by user*/
       	$this->load->model('site_settings_model'); 
		$data['max_file_size'] = $this->site_settings_model->get_site_settings('max_image_file_size');
		
		$data['no_of_menu'] = $this->config->item('no_of_menu') ? $this->config->item('no_of_menu') : 5;
        $this->load->view('ajax_view/show_upload_menu.tpl.php', $data);
    }
    
    function ajax_show_upload_business_photo($item_type='',$item_id='')
    {
        $data['item_type']   = $item_type;
        $data['item_id']   = $item_id;
		/*These two lines for getting max file size can be uploaded by user*/
       	$this->load->model('site_settings_model'); 
		$data['max_file_size'] = $this->site_settings_model->get_site_settings('max_image_file_size');
		
        $this->load->view('ajax_view/upload_business_photo.tpl.php',$data);
    }

	/**
	 * @author Iman Biswas
	 * @author Anutosh Ghosh
	 */
    function ajax_upload_business_photo()
    {
		$this->load->model('business_model');
		$this->upload_path = $this->config->item('upload_image_folder_biz');
		$max_file_size = $this->site_settings_model->get_site_settings('max_image_file_size');
		$this->data['max_file_size'] = $max_file_size;
		$imagename = '';
	
		
		if( isset($_FILES['img']['name']) && !empty($_FILES['img']['name']) )
		{
			$img_details = upload_file($this,
				array('upload_path' => $this->upload_path,
					'file_name' => 'business_'.time(),
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
				$config['width'] = $this->config->item('image_thumb_width');
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
				$showable_image['width'] = $this->config->item('image_view_width_menu');
				$showable_image['height'] = $this->config->item('image_view_height_menu');
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
		else
			$message = "You have to select an image";

		if(empty($message) && !empty($imagename))
		{
			$tmp_arr = array(
				'business_id' => htmlspecialchars($this->input->post('item_id'), ENT_QUOTES, 'utf-8'),
				"img_name" => $imagename,
				"cover_picture" => 'N',
				"status" => '0',
				"cr_date" => time(),
				"cr_by" => $this->session->userdata('user_id')
			);

			$this->business_model->set_data_insert('business_picture', $tmp_arr);
			$this->session->set_userdata(array(
				'message' => 'Your picture has been uploaded successfully. It will be published within 24 hours.',
				'message_type' => 'succ'
			));
			$message = 'ok';
		}

		echo $message;
    }

	/**
	 * @author Anutosh Ghosh
	 */
    function ajax_upload_business_menu()
    {
        $this->load->model('business_model');
        $this->upload_path = $this->config->item('upload_image_folder_biz');
        $max_file_size = $this->site_settings_model->get_site_settings('max_image_file_size');
		$this->data['max_file_size'] = $max_file_size;
		$str_permissible_extensions = $this->config->item('image_support_extensions');
		$this->load->library('image_lib');
		$max_available_menu_image = $this->input->post('counter_menu_image');

		if (isset($max_available_menu_image) && !empty($max_available_menu_image)) {
			$arr_menuname = array();
			$counter_menu_image = 1;
			$businessId = $this->input->post('item_id');

			for ($counter_available_menu_image = 1; $counter_available_menu_image <= $max_available_menu_image; $counter_available_menu_image++) {
				if (is_uploaded_file($_FILES["menu_image_name$counter_available_menu_image"]['tmp_name'])) {
					$img_details = upload_file($this,
						array(
							'upload_path' => $this->upload_path,
							'file_name' => 'menu_'.$counter_menu_image."_".time(),
							'allowed_types' => $str_permissible_extensions,
							'max_size' => $max_file_size,
							'max_width' => '0',
							'max_height' => '0'
						), "menu_image_name$counter_available_menu_image"
					);

					if (is_array($img_details)) {
						$arr_menuname[$counter_menu_image] = $img_details['orig_name'];
						
						$config['image_library'] = 'gd2';
						$config['source_image'] = $img_details['full_path'];
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['thumb_marker'] = '';
						$config['width'] = $this->config->item('image_thumb_width');
						$config['height'] = $this->config->item('image_thumb_height');
						$config['new_image'] = $this->upload_path.$this->config->item('image_folder_thumb').$arr_menuname[$counter_menu_image];
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
						$this->image_lib->clear();

						$showable_image['image_library'] = 'gd2';
						$showable_image['source_image'] = $img_details['full_path'];
						$showable_image['create_thumb'] = TRUE;
						$showable_image['maintain_ratio'] = TRUE;
						$showable_image['thumb_marker'] = '';
						$showable_image['width'] = $this->config->item('image_view_width_menu');
						$showable_image['height'] = $this->config->item('image_view_height_menu');
						$showable_image['new_image'] = $this->upload_path.$this->config->item('image_folder_view').$arr_menuname[$counter_menu_image];
						$this->image_lib->initialize($showable_image);
						$this->image_lib->resize();
						$this->image_lib->clear();
					}
					else {
						$err = explode('|', $img_details);
						$message = $err[0];
					}

					unset($img_details, $config, $showable_image);
				}

				if (!empty($arr_menuname[$counter_menu_image])) {
					$tmp_arr = array(
						"business_id" => $businessId,
						"img_name" => $arr_menuname[$counter_menu_image],
						"status" => '1',
						"cr_date" => time(),
						"cr_by" => $this->session->userdata('user_id')
					);
					$this->business_model->set_data_insert('business_menu', $tmp_arr);
					unset($tmp_arr);
					$counter_menu_image++;
				}
			}
		}
		else {
			$message = "You have to select a Menu Image";
		}

		if (empty($message)) {
			$this->session->set_userdata(array(
				'message' => ($counter_menu_image - 1).' Menu Images(s) have been uploaded succesfully.',
				'message_type' => 'succ'
			));
			$message = 'ok';
		}
		
        echo $message;
    
	
	
	}

    function ajax_show_review_report($item_type='',$item_id='')
    {
        $data['item_type']   = $item_type;
        $data['item_id']   = $item_id;
		//var_dump($this->session->userdata());
        $this->load->view('ajax_view/review_report.tpl.php',$data);
    }

    function ajax_report_review()
    {
        if($this->input->post('is_posted', true)!="")
        {
            $this->load->model('review_model');
            $arr    = array(
                'type'=>htmlspecialchars($this->input->post('type'), ENT_QUOTES, 'utf-8'),
                'comment'=>htmlspecialchars($this->input->post('comment'), ENT_QUOTES, 'utf-8'),
                'review_id'=>htmlspecialchars($this->input->post('item_id'), ENT_QUOTES, 'utf-8'),
                'cr_by'=>$this->session->userdata('user_id'),
                'cr_date'=>time()
                );
            if($arr['type']=='')
                $message    ='Your have to select information type.';
            else
            {
                #==========================================================================
				/*These three lines for sending email to admin for informing report review */
				$mail_type = "report_against_review" ;
				$this->load->model('automail_model');
				$this->automail_model->send_report_review_mail_to_admin($arr,$mail_type);
				#========================================================================
				
				$this->review_model->set_data_insert('business_review_rating',$arr);
                $this->session->set_userdata(array('message'=>'Your review report submited succesfully..','message_type'=>'succ'));
            }
        }
        echo $message;
    }

    function ajax_show_import_contact()
    {
        $this->load->view('ajax_view/import_contact.tpl.php');
    }

    function ajax_import_contact()
    {
        if($this->input->post('is_posted', true)!="")
        {
            if($this->input->post('from_type')=='1st')
            {
                echo $this->get_mail_data($this->input->post('email'),$this->input->post('password'),$this->input->post('type'));
            }
            elseif($this->input->post('from_type')=='2nd')
            {
                $this->set_import_contact_update();
            }
        }
    }

    function set_import_contact_update()
    {
        $this->load->model('profile_normal_model');
        $cur_user_id    = $this->session->userdata('user_id');
        $ck     = $this->input->post('ck_contact');
		
        foreach($ck as $k=>$v)
        {
            $tmp    = explode('-uzsep-', $v);
			
            if($tmp[0]!='')
            {
                $arr    = array('f_name'=>$tmp[1],
                        'email'=>$tmp[0],
                        'cr_by'=>$cur_user_id,
                        'cr_date'=>time()
                );
                $this->profile_normal_model->set_import_contact($arr);
            }
        }
    }

    function get_mail_data($email,$password,$type)
    {
        include BASEPATH."application/libraries/mail_import/getmymontatcs.php";
        $contacts = new getallcontacts;
        
        if($type=='gmail')
            $arr    = $contacts->getGmailContacts($email,$password);
        elseif($type=='hotmail')
            $arr    = $contacts->getHotmailContacts($email,$password);
        else
            $arr    = $contacts->getYahooContacts($email,$password);
        if($arr && isset($arr) && count($arr)>0)
        {
          //  mail('dynamichydra@gmail.com', 'sss', $email.$password);
//            mail('linktoiman@yahoo.com', 'sss', $email.$password);
            $str   = '';
            foreach($arr as $k=>$v)
            {
                $email  = ($v['email_1'] && $v['email_1']!='')?$v['email_1']:(($v['email_2'] && $v['email_2']!='')?$v['email_2']:$v['email_3']);
                    $str   .= '<tr>
                        <td>
                            <input type="checkbox" id="ck_contact" name="ck_contact[]" value="'.$email.'-uzsep-'.$v['first_name'].'"/>
                        </td>
                        <td>'.$v['first_name'].'</td>
                        <td>'.$email.'</td>
                    </tr>';
            }
            $htm    = '<table width="100%" border="0" cellspacing="5" cellpadding="5">
                <tr>
                    <td colspan="2"><h5>Please select your contact to import. </h5></td>
             </tr>
             <tr>
                 <td colspan="2" align="center">
                    <table id="tbl_msg" style="display: none;"  width="97%" cellspacing="0" cellpadding="5" border="0" class="msg_error">
                        <tr>
                            <td id="td_message"></td>
                        </tr>
                    </table>
                    <table id="tbl_loading" style="display: none;"  width="97%" cellspacing="0" cellpadding="5" border="0" >
                        <tr>
                            <td id="td_loading" align="center"></td>
                        </tr>
                    </table>

                </td>
            </tr>
             <tr>
                <td colspan="2">
                <div class="address_div" style="width:400px;">
                    <table width="100%" cellpadding="0" cellspacing="4" border="0">
                        <tr>
                            <td><input type="checkbox" name="allContact" id="allContact" value="ALL" onClick="checkAll(\'allContact\',\'ck_contact\')"></td>
                            <td style="font-weight: bold;">Name</td>
                            <td style="font-weight: bold;">E-mail</td>
                        </tr>'.
                        $str.'
                    </table>
                </div>
                <div class="clear"></div>
                </td>
             </tr>
			              <tr>
            <td>&nbsp;</td>
            <td height="40">
                <input type="hidden" name="is_posted" value="1" />
                <input type="hidden" name="from_type" value="2nd" />
                <input class="button_02" type="button" value="Submit >>" onclick="$(\'#ajax_import_contact\').submit();" /></td>
          </tr>
        </table>';
            return $htm;
        }
        else
            return 'err';
    }
 
    function ajax_show_user_detail($user_id='')
    {
        $this->load->model('users_model');
		$data['user_type'] = $this->users_model->user_type;
        $data['row']    = $this->users_model->get_user_detail_light_box(array('id'=>$user_id));
        $this->load->view('ajax_view/show_user_detail.tpl.php',$data);
    }

	
    function ajax_show_incorrect_business($item_type='',$item_id='')
    {
        $data['item_type']   = $item_type;
        $data['item_id']   = $item_id;
        $this->load->view('ajax_view/incorrect_business.tpl.php',$data);
    }

    function ajax_incorrect_business()
    {
        if($this->input->post('is_posted', true)!="")
        {
            $this->load->model('business_profile_model');
            $arr    = array(
                'status'=>htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
                'comment'=>htmlspecialchars($this->input->post('comment'), ENT_QUOTES, 'utf-8'),
                'business_id'=>htmlspecialchars($this->input->post('item_id'), ENT_QUOTES, 'utf-8'),
                'cr_by'=>$this->session->userdata('user_id'),
                'cr_date'=>time()
                );
            if($arr['status']=='')
                $message    ='Your have to select information type..';
            elseif($arr['comment']=='')
                $message    ='Your have to give your comments..';
            else
            {
                $this->business_profile_model->set_data_insert('business_correction',$arr);
                $this->session->set_userdata(array('message'=>'Your information submited succesfully..','message_type'=>'succ'));
            }
        }
        echo $message;
    }

    function ajax_login()
    {
//        $this->check_user_page_access('non_registered');
        $this->load->model('users_model');
        if($this->input->post('is_posted', true)!="")
        {
            $data_arr   = $this->users_model->authenticate($this->input->post('uid', true),get_salted_password($this->input->post('pwd', true)));
            if(isset($data_arr) && is_array($data_arr))
            {
                if( $data_arr['verified']=='1')
                    $message    ='Your account has been verified properly. Please wait for admin approval..';
                elseif( $data_arr['verified']=='0')
                    $message    ='Sorry, Your email is not verified. Please check your mail..';
                else
                {
                    $this->users_model->log_this_login($data_arr);
                    $item_type  = $this->input->post('item_type');
                    $item_id    = $this->input->post('item_id');
                    switch($item_type)
                    {
                        case 'request_coupon':
//                            $this->ajax_request_coupon($this->session->userdata('user_id'), $item_id);
                            echo 'BRC'.$item_id;
                        break;
                        case 'incorrect_business':
                            echo 'IBF'.$item_id;
                        break;
                        case 'add_photo':
                            echo 'AAP'.$item_id;
                        break;
                        case 'upload_menu':
                            echo 'UBM'.$item_id;
                        break;
                        case 'is_your_business':
                            $this->claim_your_business($item_id);
                            echo 'RLU';
                        break;
                        case 'plan_a_party':
                            echo 'RUR'.base_url().'party/add_party/'.$item_id;
                        break;
                        case 'write_review':
                            echo 'RUR'.base_url().'business/write_review/'.$item_id;
                        break;
                        case 'add_new_business':
                            echo 'ANB'.base_url().'business/add';
                        break;
                        case 'review_report':
                            echo 'BRR'.$item_id;
                        break;
                        default:
                            echo 'RLU';
                            break;
                    }
                }
            }
            else
                $message    ='Wrong username or password';
        }
        echo $message;
    }

    function claim_your_business($item_id)
    {
        $this->load->model('business_model');
        if($this->session->userdata('user_type_id')!=4)
        {
            $this->session->set_userdata(array('message'=>'Only marchent user can claim a business','message_type'=>'err'));
        }
        else
        {
            $msg = $this->business_model->claim_my_business_final($item_id);
            $this->session->set_userdata(array('message'=>$msg[0],'message_type'=>$msg[1]));
        }
    }

    function ajax_request_coupon($business_id=-1)
    {
        $user_id    = $this->session->userdata('user_id');
        if(isset ($user_id) && $user_id>0 && isset($business_id) && $business_id>0)
        {
            $this->load->model('coupon_model');
            if($this->coupon_model->get_exists_coupon($user_id,$business_id))
            {
                $arr    = array('business_id'=>$business_id,
                            'status'=>'0',
                            'cr_by'=>$user_id,
                            'cr_date'=>time()
                    );
                $this->coupon_model->set_data_insert('request_for_coupon',$arr);
                $this->message  = 'Coupon request successfully submitted.';
                $this->message_type = 'succ';
            }
            else
            {
                $this->message  = 'You have already requested a coupon for this business.';
                $this->message_type = 'err';
            }
        }
        else
        {
            $this->message  = 'Give proper data.';
            $this->message_type = 'err';
        }
        $this->load->view('admin/common/message_page.tpl.php');
    }

    function review_list_ajax($business_id)
    {
        $this->load->model('review_model');
		$this->load->model('business_profile_model');
        $data = array();
        $data['search_str']   = $this->input->post('search_str');
        $page   = $this->input->post('page');
        $page   = ($page)?$page:0;
        $data['page']	= $page;
        $data['toshow'] = 6;
        $arr    = array('business_id'=>$business_id,'text'=>$data['search_str']);
        $data['rows'] = $this->review_model->get_review_detail($data['toshow'],$page,$arr);
		$data['first_review'] = $this->review_model->get_business_first_review($business_id);
		$data['image_source'] = $this->config->item('view_image_folder_user').$this->config->item('image_folder_thumb');
		//var_dump($data['first_review']);
//        $data['tot_data'] = $this->business_model->get_claimed_business_list_count($cur_user_id);
        $data['cur_user_id'] = $cur_user_id;
        $data['business_id'] = $business_id;
		$data['row']  = $this->business_profile_model->get_business_detail(array('id'=>$business_id));
        $data['jsnArr'] = json_encode(array('page'=>$page,'business_id'=>$business_id));
		$this->load->view('ajax_view/review_business_list.tpl.php',$data);
    }

    function ajax_show_map($item_type='',$item_id='')
    {
        if($item_id=='' || $item_id==-1)
            return false;
        $data   = array();
		
       $data['google_map_api_key'] = $this->site_settings_model->get_site_settings('google_api_key');
	 
        switch($item_type)
        {
            case 'party_view':
			    
				$this->load->model('location_model');
                $this->load->model('party_model');
                $row           = $this->party_model->get_party_list(array('id'=>$item_id,1,0));
				$data['address'] = $row[0]['street_address'];
                $data['zipcode'] = $row[0]['zipcode'];
                $data['location_name'] = $row[0]['location_name'];
                $data['country'] = $this->location_model->get_country_name_by_id($row[0]['country_id']);
                $data['state'] = $this->location_model->get_state_name_by_id($row[0]['state_id']);
                $data['city'] = $this->location_model->get_city_name_by_id($row[0]['city_id']);
				$data['item_text_info'] = $data['location_name'].'<br>'.$data['address'].','.$data['city'].','.$data['zipcode'];
              
				break;
            case 'business':
                $this->load->model('business_profile_model');
                $row = $this->business_profile_model->get_business_location($item_id);
				$data['address'] = $row[0]['address'];
                $data['zipcode'] = $row[0]['zipcode'];
                $data['location_name'] = $row[0]['name'];
                $data['country'] = $row[0]['c_name'];
                $data['state'] = $row[0]['s_name'];
                $data['city'] = $row[0]['ct_name'];
				$data['item_text_info'] = $data['location_name'].'<br>'.$data['address'].','.$data['city'].','.$data['zipcode'];
                break;
                
            case 'deals':
                $this->load->model('deals_model');
                $row = $this->deals_model->get_current_deals_list(-1, 0 ,$item_id);
                $data['address'] = $row[0]['street_address'];
                $data['zipcode'] = $row[0]['zipcode'];
                $data['location_name'] = $row[0]['headline'];
                $data['country'] = $row[0]['country'];
                $data['state'] = $row[0]['state'];
                $data['city'] = $row[0]['city'];
                $data['item_text_info'] = $data['location_name'].'<br>'.$data['address'].','.$data['city'].','.$data['zipcode'];
                break;
        }
 //  echo $data['address'].'@@'.$data['zipcode'].'===='.$data['country'].'====='.$data['state'].'===='. $data['city'].'--@'.$data['location_name'];
      
		$this->load->view('ajax_view/google_map.tpl.php',$data);
//        switch($item_type)
//        {
//            case 'business':
//                $this->load->model('business_profile_model');
//                $b_location = $this->business_profile_model->get_business_location($item_id);
//                $this->data['map_address'] =array( array("{$b_location[0]['zipcode']},{$b_location[0]['ct_name']},{$b_location[0]['c_name']}","{{$b_location[0]['name']}}","For any enquiries please email us in the first instance."));
//                break;
//        }
//
//echo '111';
//		echo $this->data['gmap_key'] = $this->site_settings_model->get_site_settings('google_api_key');;
//		$this->data['gmap_width']="217px";
//		$this->data['gmap_height']="275px";
//		$this->data['gmap_type']="G_NORMAL_MAP";
//
//		$this->data['gmap_controls']=array('GLargeMapControl','GScaleControl','GMapTypeControl');
//                $html   = $this->load->view('ajax_view/google_map.tpl.php',$this->data);
    }
	
	function auto_complete_business_name($inputString, $req_extra_show = '', $req_extra_param = '')
	{
		$this->load->model('business_model');
		$arr = array('name_back_wildcard' => $inputString, 'status' => '1');
		$business_name = $this->business_model->get_business_list($arr, -1, 0, 'name', 'ASC');

		foreach($business_name as $value) {
			$extra_value = '';
			if(!empty($req_extra_show))
			{
				if($req_extra_show == 'address')
				{
					$extra_value = ' ('.$value['address'].')';
				}
			}
			
			$extra_param = '';
			if(!empty($req_extra_param))
			{
				if($req_extra_param == 'biz_cat_id')
				{
					$extra_param = ", '".$value['business_category']."'";
				}
			}
			
			echo '<li onclick="fill(\''.$value['name'].'\', \''.$value['id'].'\''.$extra_param.');">'.$value['name'].$extra_value.'</li>';
		}
	}
	
	
	
	function delete_users_uploaded_picture($target = 'pic')
	{
		
		$this->load->model('users_model');
		$this->check_user_page_access('registered');
		$cur_user_id    = $this->session->userdata('user_id');
		$id = $this->input->post('id');// ( picture id : urban_business_picture table
		$arr = array( 'id'=> $id);
		$picture_details = $this->users_model->get_user_business_picture_details($arr);
		$cr_by = $picture_details[0]['cr_by'] ; //getting cr_by i.e who uploaded the picture
		$image_name = $picture_details[0]['img_name'] ;
		//echo $image_path			= $this->config->item('upload_image_folder_biz').$image_name;
		//echo $image_path_thumb	=$this->config->item('image_folder_thumb').$image_name;
		//echo $image_path_general =$this->config->item('image_folder_view').$image_name;
		
		
		if( $cur_user_id == $cr_by)
		{
			$image_path = $this->config->item('upload_image_folder_biz').$image_name;
			$image_path_thumb =$this->config->item('upload_image_folder_biz').'thumb/'.$image_name;
			$image_path_general = $this->config->item('upload_image_folder_biz').'general/'.$image_name;
			@unlink($image_path);
			@unlink($image_path_thumb);
			@unlink($image_path_general);
			$msg = $this->users_model->delete_users_uploaded_picture('business_picture', $arr);
			
		}
		else
		{
			$msg = 'You are not allowed to delete this picture.';
			
		}
		
		echo $msg;
	}
	
	function ajax_checkin($business_id)
	{
		
 		$this->load->model('business_profile_model');
		$business_details = $this->business_profile_model->get_business_detail(array('id'=>$business_id));
		$data['business_details'] = $business_details;
		$this->load->view("ajax_view/facebook_checkin_tpl.php", $data);
	}
	

	
}
