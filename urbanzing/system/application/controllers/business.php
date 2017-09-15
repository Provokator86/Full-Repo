<?php
include BASEPATH.'application/controllers/MY_Controller'.EXT;

class business extends MY_Controller
{
    private $user_type_id='';
    private $pagination_per_page	=	5;
	function __construct()
    {
        parent::__construct();
        $this->user_type_id = $this->session->userdata('user_type_id');
        if( $this->router->fetch_method() != 'index')
			$this->clear_business_search();
		
    }

    function index($business_id='')
    {
		$this->load->model('category_model');
        if(!isset($business_id) || $business_id=='' || !is_numeric($business_id) || $business_id<1)
        {
            $this->session->set_userdata(array('message'=>"You have to select a business.",'message_type'=>'err'));
            header("location:".base_url().'search/restaurants');
            exit;
        }
		$this->session->set_userdata('user_values', '' );
        $this->load->model('business_profile_model');
        $this->data['business_id']  = $business_id;
        $this->data['row']  = $this->business_profile_model->get_business_detail(array('id'=>$business_id));
		//var_dump($this->data['row']);exit;
		$this->data['business_type_name'] = $this->category_model->get_category_list(1,0,$this->data['row'][0]['business_type_id']);
		$this->data['menu_list']  = $this->business_profile_model->get_menu_list($business_id);
		if(!isset($this->data['row']) || !isset($this->data['row'][0]))
        {
            $this->session->set_userdata(array('message'=>"No such business exists.",'message_type'=>'err'));
            header("location:".base_url().'search/restaurants');
            exit;
        }
		$this->data['business_category'] = (string)$this->session->userdata('business_category'); // for back link

		$this->data['title'] = $this->data['row'][0]['name'];
        $this->session->set_userdata(array('redirect_url'=>base_url().'business/'.$business_id));
        $this->add_js(array('ajax_helper','common_js','jquery.lightbox-0.5','tooltip','recaptcha_ajax'));
        $this->add_css(array('jquery.lightbox-0.5'));
        $this->set_include_files(array('business/profile'));
        $this->render();
        
    }

   function manage_menu($business_id)
    {
        if(!isset($business_id) || $business_id=='' || $business_id<1)
        {
            header("Location: ".base_url().'profile');
            exit();
        }
        $this->load->model('business_profile_model');
        $this->data['business_detail']    = $this->business_profile_model->get_business_detail(array('id'=>$business_id));
        $this->data['menu_list']    = $this->business_profile_model->get_menu_list($business_id);
        $this->data['business_id']  = $business_id;
        $this->set_include_files(array('business/upload_menu'));
        $this->render();
    }

    function upload_business_menu()
    {
        $this->upload_path = $this->config->item('upload_image_folder_biz');
        $message    = '';
        $imagename  = '';
        $business_id    = $this->input->post('business_id');
        $max_file_size    =$this->site_settings_model->get_site_settings('max_image_file_size');
        if( isset($_FILES['img']['name']) && $_FILES['img']['name']!='' )
        {
            $img_details = upload_file($this,
               array('upload_path' => $this->upload_path,
                  'file_name' => 'menu_'.time(),
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
                $config['width'] = 53;
                $config['height'] = 53;
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
        if($message=='' )
        {
            $this->load->model('business_model');
            $arr= array("business_id"=>$business_id,
                        "img_name"=>$imagename,
                        "cr_date"=>time(),
                        "cr_by"=>$this->session->userdata('user_id')
                );
            $this->business_model->set_data_insert('business_menu',$arr);
            $this->session->set_userdata(array('message'=>'Menu update successfully','message_type'=>'succ'));
            header('location:'.base_url().'business/manage_menu/'.$business_id);
            exit();
        }
        $this->session->set_userdata(array('message'=>$message,'message_type'=>'err'));
        header('location:'.base_url().'business/manage_menu/'.$business_id);
        exit();
    }

	/**
	 * @author Anutosh Ghosh
	 * @param string $target => 'menu', 'pic'
	 */
	function delete_biz_image($target = 'menu')
	{
		$this->load->model('business_profile_model');
		$id = $this->input->post('id');

		if ($target == 'menu') {
			$arr_details = $this->business_profile_model->get_menu_list(0, $id);
			$image_path = $this->config->item('upload_image_folder_biz');
			$field_name = 'img_name';
		}
		else {
			$arr_details = $this->business_profile_model->get_business_photo(array('id' => $id, 'all' => 1));
			$image_path = $this->config->item('upload_image_folder_biz');
			$field_name = 'img_name';
		}
		
		@unlink($image_path.$arr_details[0][$field_name]);
		@unlink($image_path.$this->config->item('image_folder_thumb').$arr_details[0][$field_name]);
		@unlink($image_path.$this->config->item('image_folder_view').$arr_details[0][$field_name]);

		if ($target == 'menu') {
			$result = $this->business_profile_model->set_data_delete('business_menu', $id);
		}
		else {
			$result = $this->business_profile_model->set_data_delete('business_picture', $id);

			if ($result)
			{
				$this->business_profile_model->set_business_cover_pic($arr_details[0]['business_id'], $arr_details[0]['cover_picture']);
			}
		}

		if ($result) {
			echo "Image deleted successfully.";
		}
		else {
			echo "Sorry, Image could not be deleted.";
		}
	}

    function write_review($business_id=-1)
    {
        if(!isset($business_id) || $business_id=='' || $business_id<1)
        {
            header('Location: '.base_url().'search');
            exit();
        }
		$this->load->model('article_model');
		$this->data['write_review_text']=$this->article_model->get_article_list(-1,0,-1,'',1,'write_review_upper_text');
        $this->data['business_id']  = $business_id;
        $this->data['old_values'] = $this->session->userdata('user_values');
        $this->load->model('business_profile_model');
        $this->data['business_detail']    = $this->business_profile_model->get_business_detail(array('id'=>$business_id));
        $this->data['title'] = $this->data['business_detail'][0]['name'];
        $this->session->set_userdata('user_values', '' );
        $this->add_js(array('ajax_helper','common_js','fromvalidation','ModalDialog','js_form'));
        $this->set_include_files(array('business/write_review'));
        $this->render();
    }

    function save_review()
    {
        $this->check_user_page_access('registered');
        $this->upload_path = $this->config->item('upload_image_folder_review');
        $message    = '';
//        $imagename  = '';
        $business_id    = $this->input->post('business_id');
        $arr_post = array();
        $temp_arr = array_merge($arr_post, $_POST);
        $this->session->set_userdata('user_values', $temp_arr );
        $this->session->set_userdata('user_messages', array());
        if(trim($this->input->post('review_title'))=='')
            $message    = 'Please give your review title';
        elseif(trim($this->input->post('star_rating'))=='' || $this->input->post('star_rating')<1)
            $message    = 'Please give your star rating';
        elseif(trim($this->input->post('comment'))=='' )
            $message    = 'Please write your comment';
//        else
//        {
//            $max_file_size    =$this->site_settings_model->get_site_settings('max_image_file_size');
//            if( isset($_FILES['img']['name']) && $_FILES['img']['name']!='' )
//            {
//                $img_details = upload_file($this,
//                   array('upload_path' => $this->upload_path,
//                      'file_name' => 'review_'.time(),
//                      'allowed_types' => $this->config->item('image_support_extensions'),
//                      'max_size' => $max_file_size,
//                      'max_width' => '0',
//                      'max_height' => '0',
//                      ), 'img'
//                   );
//                if (is_array($img_details))
//                {
//                    $config['image_library'] = 'gd2';
//                    $config['source_image'] = $img_details['full_path'];
//                    $config['create_thumb'] = TRUE;
//                    $config['maintain_ratio'] = TRUE;
//                    $config['thumb_marker'] = '';
//                    $config['width'] = 53;
//                    $config['height'] = 53;
//                    $config['new_image'] = $this->upload_path.'thumb/'.$img_details['orig_name'];
//                    $this->load->library('image_lib', $config);
//                    $this->image_lib->resize();
//                    $imagename = $img_details['orig_name'];
//                }
//                else
//                {
//                    $err=explode('|',$img_details);
//                    $message    = $err[0];
//                }
//            }
//        }

        if($message=='' )
        {
            $this->load->model('review_model');
            $arr= array("review_title"=>htmlspecialchars($this->input->post('review_title'), ENT_QUOTES, 'utf-8'),
                        "comment"=>htmlspecialchars($this->input->post('comment'), ENT_QUOTES, 'utf-8'),
                        "star_rating"=>htmlspecialchars($this->input->post('star_rating'), ENT_QUOTES, 'utf-8'),
                        "business_id"=>$business_id,
//                        "img"=>$imagename,
                        "cr_date"=>time(),
                        "user_id"=>$this->session->userdata('user_id'),
                        "cr_by"=>$this->session->userdata('user_id')
                );
            $this->review_model->set_data_insert('business_reviews',$arr);
            $this->review_model->set_business_review_update($business_id);
            $this->session->set_userdata(array('message'=>'Review updated successfully','message_type'=>'succ'));
            header('location:'.base_url().'business/'.$business_id);
            exit();
        }
        $this->session->set_userdata(array('message'=>$message,'message_type'=>'err'));
        header('location:'.base_url().'business/write_review/'.$business_id);
        exit();
    }

    function claimed_business()
    {
        $this->check_user_page_access('registered');
        $this->data['title'] = 'Claim business';
        if($this->user_type_id==4)
        {
            $this->load->model('article_model');
            $this->data['business_claim_page_text']=$this->article_model->get_article_list(1,0,-1,'',1,'business_claim_page_text');
			
            $this->add_js(array('ajax_helper','common_js'));
            $this->session->set_userdata(array('redirect_url'=>base_url().'business/claimed_business'));
            $this->set_include_files(array('business/claimed_business'));
            $this->render();
        }
        else
        {
            $this->session->set_userdata(array('message'=>"Your can't access this page..",'message_type'=>'err'));
            header("Location: ".base_url().'profile');
            exit();
        }
    }

    function claimed_business_list_ajax()
    {
        $this->load->model('business_model');
        $cur_user_id    = $this->session->userdata('user_id');
        $data = array();
        $search_str   = $this->input->post('search_str');
        $business_page   = $this->input->post('business_page');
        $business_page   = ($business_page)?$business_page:0;
        $data['business_page']	= $business_page;
        $data['toshow'] = $this->admin_page_limit;
        $data['rows'] = $this->business_model->get_claimed_business_list($data['toshow'],$business_page,$cur_user_id);
        $data['tot_data'] = $this->business_model->get_claimed_business_list_count($cur_user_id);
        $data['cur_user_id'] = $cur_user_id;
        $data['jsnArr'] = json_encode(array('business_page'=>$business_page));
        $this->load->view('business/claimed_business_list.tpl.php',$data);
    }

    function unlock_business($business_id,$code)
    {
        $this->check_user_page_access('registered');
        if(!isset($business_id) || $business_id<1)
        {
            $this->session->set_userdata(array('message'=>'Your have to select a business..','message_type'=>'err'));
            header("Location: ".base_url().'profile');
            exit();
        }
        elseif(!isset($code) || $code=='')
        {
            $this->session->set_userdata(array('message'=>'Your have to give your code..','message_type'=>'err'));
            header("Location: ".base_url().'profile');
            exit();
        }
        $this->load->model('business_model');
        $user_id    = $this->session->userdata('user_id');
        $iscalimed  = $this->business_model->is_claimed_proper($business_id,$user_id,$code);
        if($iscalimed==false)
        {
            $this->session->set_userdata(array('message'=>'You cant claim this business any more..','message_type'=>'err'));
            header("Location: ".base_url().'profile');
            exit();
        }
        $this->business_model->set_data_update('business_claimed',array('verified'=>'1'),$iscalimed);
        $this->business_model->set_data_update('business',array('business_owner_id'=>$user_id),$business_id);
        $this->session->set_userdata(array('message'=>'Your business unlocked successfully..','message_type'=>'succ'));
        header("Location: ".$this->get_redirect_url());
        exit;
    }

    function claim()
    {
        $this->check_user_page_access('registered');
        $this->data['title'] = 'Claim business';
        if($this->user_type_id==4)
        {
			$this->load->model('article_model');
			$this->data['business_claim_page_text']=$this->article_model->get_article_list(1,0,-1,'',1,'business_claim_page_text');		
            $this->add_js(array('ajax_helper','common_js'));
            $this->session->set_userdata(array('redirect_url'=>base_url().'business/claim'));
            $this->set_include_files(array('business/claim'));
            $this->render();
        }
        else
        {
            $this->session->set_userdata(array('message'=>"Your can't claim any business business..",'message_type'=>'err'));
            header("Location: ".base_url().'profile');
            exit();
        }
    }

    function claim_business_list_ajax()
    {
        $this->load->model('business_model');
        $cur_user_id    = $this->session->userdata('user_id');
        $data = array();
        $search_str   = $this->input->post('search_str');
        $business_page   = $this->input->post('business_page');
        $business_page   = ($business_page)?$business_page:0;
        $data['business_page']	= $business_page;
        $data['toshow'] = $this->admin_page_limit;
        $condition  = " AND b.name LIKE '%$search_str%' ";
        $data['rows'] = $this->business_model->get_claim_business_list($data['toshow'],$business_page,$condition,$cur_user_id);
        $data['tot_data'] = $this->business_model->get_claim_business_list_count($condition,$cur_user_id);
        $data['cur_user_id'] = $cur_user_id;
        $data['jsnArr'] = json_encode(array('business_page'=>$business_page));
        $this->load->view('business/claim_business_list.tpl.php',$data);
    }

     function claim_my_business($business_id=-1)
    {
        $this->check_user_page_access('registered');
        $this->load->model('business_model');
        $business_id    = (!isset($business_id) || $business_id<1)?$this->input->post('business_id'):$business_id;
        $msg = $this->business_model->claim_my_business_final($business_id);
        $this->session->set_userdata(array('message'=>$msg[0],'message_type'=>$msg[1]));
        header('location:'.$this->get_redirect_url());
        exit;

    } 

    function edit($business_id=-1)
    {
        $this->check_user_page_access('registered');
        $this->data['title'] = 'Edit business';

        if($this->session->userdata('user_type_id')!=4)
        {
            $this->session->set_userdata(array('message'=>"You don't have permission to add a business",'message_type'=>'err'));
            header('location:'.base_url().'user/message_page');
            exit();
        }
        elseif(!isset($business_id) || !is_numeric($business_id) || $business_id<0)
        {
            $this->session->set_userdata(array('message'=>"You have to select a business",'message_type'=>'err'));
            header('location:'.base_url().'profile');
            exit();
        }
        $this->load->model('category_model');
        $this->load->model('location_model');
        $this->load->model('price_range_model');
        $this->load->model('cuisine_model');
        $this->load->model('date_time_model');
        $this->load->model('business_model');
		$this->load->model('business_profile_model');
		$this->load->model('article_model');
		$this->data['content_text'] = $this->article_model->get_article_list(1,0,-1,'',1,'edit_business_page_text');
        $this->data['data'] = $this->session->userdata('user_values');
        if(!isset($this->data['data']) || count($this->data['data'])<1 || $this->data['data'].'a'=='a')
        {
            $tmp    = $this->business_model->get_business_list(array('id'=>$business_id),1);
            $this->data['data'] = $tmp[0];
            $this->data['data']['hour'] = '';
            $this->data['data']['cuisine_id']   = $this->cuisine_model->get_cuisine_id_arr($this->data['data']['id']);

        }
        $this->session->set_userdata('user_values', '' );
        $this->data['business_category']    = makeOption($this->category_model->get_cat_selectlist(),$this->data['data']['business_category']);
        $this->category_model->option_results='';
        if($this->data['data']['business_category']>0)
            $this->data['business_type']    = makeOption($this->category_model->get_cat_selectlist('',$this->data['data']['business_category']),$this->data['data']['business_type_id']);
        $this->data['country_option']    = $this->location_model->get_country_list_option($this->data['data']['country_id']);
        $this->data['state_option']    = $this->location_model->get_state_list_option($this->data['data']['state_id'],$this->data['data']['country_id']);
        if($this->data['data']['state_id']>0)
            $this->data['city_option']    = $this->location_model->get_city_list_option($this->data['data']['city_id'],$this->data['data']['state_id']);
        if($this->data['data']['city_id']>0)
            $this->data['zipcode_option']    = $this->location_model->get_zip_code_list_option($this->data['data']['zipcode'],$this->data['data']['city_id']);
        $this->data['price_option']    = $this->price_range_model->get_price_range_option($this->data['data']['price_range_id'],$this->data['data']['country_id']);
        $this->data['cuisine_option']    = $this->cuisine_model->get_cuisine_option($this->data['data']['cuisine_id']);
        $this->data['hour_option']    = $this->date_time_model->generate_business_hour_html($this->data['data'],$this->data['data']['id']);
		
		// Section for Menu Image
		$this->data['arr_menu_list']    = $this->business_profile_model->get_menu_list($business_id);
		$this->data['no_of_menu'] = $this->config->item('no_of_menu') ? $this->config->item('no_of_menu') : 5;
		$this->data['arr_biz_pics'] = $this->business_profile_model->get_business_photo(array(
			'business_id' => $business_id,
			'all' => 1,
			'order_by' => 'id'
		));
	
        $this->add_js(array('ajax_helper','common_js','fromvalidation','ModalDialog','js_form'));
        $this->set_include_files(array('business/edit'));
        $this->render();
    }

    function add()
    {
        $this->check_user_page_access('registered');
        $this->data['title'] = 'Add business';
		/*if($this->session->userdata('user_type_id')!=4)
        {
            $this->session->set_userdata(array('message'=>"Only merchants can access this page, if you are a merchant please logout and log back in with your merchant username and password. If you do not have a merchant login then please logout and click on this tab again to create a merchant login.",'message_type'=>'err'));
            header('location:'.base_url().'user/message_page');
            exit();
        }*/
        $this->load->model('category_model');
        $this->load->model('location_model');
        $this->load->model('price_range_model');
        $this->load->model('cuisine_model');
        $this->load->model('date_time_model');
        $this->load->model('article_model');
		
		/*These two lines for getting max file size can be uploaded by user*/
       	$this->load->model('site_settings_model'); 
		$this->data['max_file_size'] = $this->site_settings_model->get_site_settings('max_image_file_size');
		
		
        $this->data['business_add_page_text']=$this->article_model->get_article_list(1,0,-1,'',1,'business_add_page_text');
       
        $this->data['old_values'] = $this->session->userdata('user_values');
        $this->session->set_userdata('user_values', '' );
        $country_id     = (isset($this->data['old_values']['country_id']))?$this->data['old_values']['country_id']:113;
        $state_id       = $this->data['old_values']['state_id'];
        $city_id       = $this->data['old_values']['city_id'];
        $business_category       = $this->data['old_values']['business_category'];
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
        $this->data['price_option']    = $this->price_range_model->get_price_range_option($this->data['old_values']['price_range_id'],$country_id);
        $this->data['cuisine_option']    = $this->cuisine_model->get_cuisine_option($this->data['old_values']['cuisine_id']);
        $this->data['hour_option']    = $this->date_time_model->generate_business_hour_html($this->data['old_values']);
        $this->data['no_of_menu'] = $this->config->item('no_of_menu') ? $this->config->item('no_of_menu') : 5;
		
		
        $this->add_js(array('ajax_helper','common_js','fromvalidation','ModalDialog','js_form'));
        $this->set_include_files(array('business/add'));
        $this->render();
    }

    function reset_business()
    {
        $this->session->set_userdata('user_values', '' );
        header('location:'.base_url().'business/add');
        exit();
    }
    
    function reset_business_edit($id)
    {
        $this->session->set_userdata('user_values', '' );
        header('location:'.base_url().'business/edit/'.$id);
        exit();
    }

    function save_business_edit()
    {
        $this->check_user_page_access('registered');
        $this->upload_path = $this->config->item('upload_image_folder_biz');
        $message    = '';
        $arr_post = array();
        $temp_arr = array_merge($arr_post, $_POST);

        $this->session->set_userdata('user_values', $temp_arr );
        $this->session->set_userdata('user_messages', array());
        $businessId = $this->input->post('id');

        if(trim($this->input->post('name'))=='')
            $message    = 'Please give your business name';
        elseif(trim($this->input->post('business_category'))=='' )
            $message    = 'Please select your business category';
        elseif(trim($this->input->post('business_type_id'))=='' )
            $message    = 'Please select your business type';
        elseif(trim($this->input->post('address'))=='')
            $message    = 'Please give your business street address';
        elseif(trim($this->input->post('country_id'))=='')
            $message    = 'Please select your business country';
        elseif(trim($this->input->post('state_id'))=='')
            $message    = 'Please select your business state';
        elseif(trim($this->input->post('city_id'))=='')
            $message    = 'Please select your business city';
        elseif(trim($this->input->post('zipcode'))=='')
            $message    = 'Please select your business pincode';
        elseif(trim($this->input->post('phone_number'))=='')
            $message    = 'Please select your business phone number';

        if(empty($message))
        {
            $this->load->model('business_model');
            
            $arr= array("name"=>htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
                        "address"=>htmlspecialchars($this->input->post('address'), ENT_QUOTES, 'utf-8'),
                        "city_id"=>htmlspecialchars($this->input->post('city_id'), ENT_QUOTES, 'utf-8'),
                        "state_id"=>htmlspecialchars($this->input->post('state_id'), ENT_QUOTES, 'utf-8'),
                        "country_id"=>htmlspecialchars($this->input->post('country_id'), ENT_QUOTES, 'utf-8'),
                        "zipcode"=>htmlspecialchars($this->input->post('zipcode'), ENT_QUOTES, 'utf-8'),
                        "land_mark"=>htmlspecialchars($this->input->post('land_mark'), ENT_QUOTES, 'utf-8'),
                        "phone_number"=>htmlspecialchars($this->input->post('phone_number'), ENT_QUOTES, 'utf-8'),
                        "website"=>htmlspecialchars($this->input->post('website'), ENT_QUOTES, 'utf-8'),
                        "contact_person"=>htmlspecialchars($this->input->post('contact_person'), ENT_QUOTES, 'utf-8'),
                        "contact_email"=>htmlspecialchars($this->input->post('contact_email'), ENT_QUOTES, 'utf-8'),
                        "business_type_id"=>htmlspecialchars($this->input->post('business_type_id'), ENT_QUOTES, 'utf-8'),
                        "price_range_id"=>htmlspecialchars($this->input->post('price_range_id'), ENT_QUOTES, 'utf-8'),
                        "credit_card"=>htmlspecialchars($this->input->post('credit_card'), ENT_QUOTES, 'utf-8'),
                        "delivery"=>htmlspecialchars($this->input->post('delivery'), ENT_QUOTES, 'utf-8'),
                        "vegetarian"=>htmlspecialchars($this->input->post('vegetarian'), ENT_QUOTES, 'utf-8'),
                        "parking"=>htmlspecialchars($this->input->post('parking'), ENT_QUOTES, 'utf-8'),
                        "take_reservation"=>htmlspecialchars($this->input->post('take_reservation'), ENT_QUOTES, 'utf-8'),
                        "air_conditioned"=>htmlspecialchars($this->input->post('air_conditioned'), ENT_QUOTES, 'utf-8'),
                        "serving_alcohol"=>htmlspecialchars($this->input->post('serving_alcohol'), ENT_QUOTES, 'utf-8'),
                        "business_category"=>htmlspecialchars($this->input->post('business_category'), ENT_QUOTES, 'utf-8'),
                        "hour_comment"=>htmlspecialchars($this->input->post('hour_comment'), ENT_QUOTES, 'utf-8'),
                        "other_cuisine"=>htmlspecialchars($this->input->post('other_cuisine'), ENT_QUOTES, 'utf-8'),
						"tags"=>htmlspecialchars($this->input->post('tags'), ENT_QUOTES, 'utf-8'),
                        "region_id"=>1,
                        "update_date"=>time(),
                        "update_by"=>$this->session->userdata('user_id')
                );
            $this->business_model->set_data_update('business', $arr, $businessId);

            if($businessId)
            {
                $this->load->model('cuisine_model');
                $this->cuisine_model->set_delete_cuisine(-1,$businessId);
                $cuisine_id     = $this->input->post('cuisine_id');
                if(is_array($cuisine_id))
                {
                    foreach($cuisine_id as $v)
                    {
                        $tmp_arr= array("business_id"=>$businessId,
                            "cuisine_id"=>$v,
                            "cr_date"=>time(),
                            "cr_by"=>$this->session->userdata('user_id')
                        );
                        $this->business_model->set_data_insert('business_cuisine',$tmp_arr);
						unset($tmp_arr);
                    }
                }

                $this->load->model('date_time_model');
                foreach($this->date_time_model->day_text as $k=>$v)
                {
                    $tmp_arr= array(
                        "hour_from"=>$this->input->post('hour_from'.$v),
                        "hour_to"=>$this->input->post('hour_to'.$v),
                        "update_date"=>time(),
                        "update_by"=>$this->session->userdata('user_id')
                    );
                    $cond_arr   = array("business_id"=>$businessId,
                        "day"=>$v);
                    $this->business_model->set_data_update('business_hour',$tmp_arr,$cond_arr);
					unset($tmp_arr, $cond_arr);
                }

				$max_file_size = $this->site_settings_model->get_site_settings('max_image_file_size');
				$str_permissible_extensions = $this->config->item('image_support_extensions');
				$this->load->library('image_lib');
				$max_available_menu_image = $this->input->post('counter_menu_image');
				$max_available_pics = $this->input->post('counter_img');

                if (isset($max_available_menu_image) && !empty($max_available_menu_image) && $this->input->post('business_category')==1) {
					$arr_menuname = array();
					$counter_menu_image = 1;

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
								"business_id"=>$businessId,
								"img_name"=>$arr_menuname[$counter_menu_image],
								"status"=>'1',
								"cr_date"=>time(),
								"cr_by"=>$this->session->userdata('user_id')
							);
							$this->business_model->set_data_insert('business_menu', $tmp_arr);
							unset($tmp_arr);
							$counter_menu_image++;
						}
					}
				}

				if (isset($max_available_pics) && !empty($max_available_pics)) {
					$arr_picname = array();
					$counter_pic = 1;
					$this->load->model('business_profile_model');

					$cover_pic_row_details = $this->business_profile_model->get_business_photo(array(
						'business_id' => $businessId,
						'cover_picture' => 'Y'
					));

					for ($counter_available_pic = 1; $counter_available_pic <= $max_available_pics; $counter_available_pic++) {
						if (is_uploaded_file($_FILES["img$counter_available_pic"]['tmp_name'])) {
							$pic_details = upload_file($this,
								array(
									'upload_path' => $this->upload_path,
									'file_name' => 'business_'.$businessId."_".$counter_pic."_".time(),
									'allowed_types' => $str_permissible_extensions,
									'max_size' => $max_file_size,
									'max_width' => '0',
									'max_height' => '0'
								), "img$counter_available_pic"
							);

							if (is_array($pic_details)) {
								$arr_picname[$counter_pic] = $pic_details['orig_name'];
								
								$config['image_library'] = 'gd2';
								$config['source_image'] = $pic_details['full_path'];
								$config['create_thumb'] = TRUE;
								$config['maintain_ratio'] = TRUE;
								$config['thumb_marker'] = '';
								$config['width'] = $this->config->item('image_thumb_width');
								$config['height'] = $this->config->item('image_thumb_height');
								$config['new_image'] = $this->upload_path.$this->config->item('image_folder_thumb').$arr_picname[$counter_pic];
								$this->image_lib->initialize($config);
								$this->image_lib->resize();
								$this->image_lib->clear();

								$showable_image['image_library'] = 'gd2';
								$showable_image['source_image'] = $pic_details['full_path'];
								$showable_image['create_thumb'] = TRUE;
								$showable_image['maintain_ratio'] = TRUE;
								$showable_image['thumb_marker'] = '';
								$showable_image['width'] = $this->config->item('image_view_width_menu');
								$showable_image['height'] = $this->config->item('image_view_height_menu');
								$showable_image['new_image'] = $this->upload_path.$this->config->item('image_folder_view').$arr_picname[$counter_pic];
								$this->image_lib->initialize($showable_image);
								$this->image_lib->resize();
								$this->image_lib->clear();
							}
							else {
								$err = explode('|', $pic_details);
								$message = $err[0];
							}

							unset($pic_details, $config, $showable_image);
						}

						if (!empty($arr_picname[$counter_pic])) {
							if (empty($cover_pic_row_details) && $counter_pic == 1) {
								$cover_picture = 'Y';
							}
							else {
								$cover_picture = 'N';
							}

							$tmp_arr = array(
								"business_id"=>$businessId,
								"img_name"=>$arr_picname[$counter_pic],
								"cover_picture" => $cover_picture,
								"status"=>'1',
								"cr_date"=>time(),
								"cr_by"=>$this->session->userdata('user_id')
							);
							$this->business_model->set_data_insert('business_picture', $tmp_arr);
							unset($tmp_arr);
							$counter_pic++;
						}
					}
				}

				$this->session->set_userdata('user_values', '' );
                header('location:'.base_url().'business/'.$businessId);
                exit();
            }
            else
            {
				$this->session->set_userdata(array('message'=>'Unable to edit your business','message_type'=>'err'));
                header('location:'.base_url().'profile');
                $this->session->set_userdata('user_values', '' );
                exit();
            }
        }
		
        $this->session->set_userdata(array('message'=>$message,'message_type'=>'err'));
        header('location:'.base_url().'business/edit/'.$businessId);
        exit();
    }

    function save_business()
    {
        $this->check_user_page_access('registered');
        $this->upload_path = $this->config->item('upload_image_folder_biz');
        $message    = '';
        $arr_post = array();
        $temp_arr = array_merge($arr_post, $_POST);

        $this->session->set_userdata('user_values', $temp_arr );
        $this->session->set_userdata('user_messages', array());

		if(trim($this->input->post('name'))=='')
            $message    = 'Please give your business name';
        elseif(trim($this->input->post('business_category'))=='' )
            $message    = 'Please select your business category';
        elseif(trim($this->input->post('business_type_id'))=='' )
            $message    = 'Please select your business type';
        elseif(trim($this->input->post('address'))=='')
            $message    = 'Please give your business street address';
        elseif(trim($this->input->post('country_id'))=='')
            $message    = 'Please select your business country';
        elseif(trim($this->input->post('state_id'))=='')
            $message    = 'Please select your business state';
        elseif(trim($this->input->post('city_id'))=='')
            $message    = 'Please select your business city';
        elseif(trim($this->input->post('zipcode'))=='')
            $message    = 'Please select your business pincode';
        elseif(trim($this->input->post('phone_number'))=='')
            $message    = 'Please select your business phone number';
        
        if($message=='' )
        {
            $this->load->model('business_model');
			
			#=========================   Radio buttons values and making them 2 if not selected====================
			/*Taking 7 options from radio buttons */
			$credit_card  		=  	htmlspecialchars($this->input->post('credit_card'), ENT_QUOTES, 'utf-8');
            $delivery	  		=  	htmlspecialchars($this->input->post('delivery'), ENT_QUOTES, 'utf-8');
           	$vegetarian   		=  	htmlspecialchars($this->input->post('vegetarian'), ENT_QUOTES, 'utf-8');
            $parking      		= 	htmlspecialchars($this->input->post('parking'), ENT_QUOTES, 'utf-8');
            $take_reservation 	=	htmlspecialchars($this->input->post('take_reservation'), ENT_QUOTES, 'utf-8');
            $air_conditioned 	=	htmlspecialchars($this->input->post('air_conditioned'), ENT_QUOTES, 'utf-8');
            $serving_alcohol    =   htmlspecialchars($this->input->post('serving_alcohol'), ENT_QUOTES, 'utf-8');
			
			/*Making them 2 if radio buttons not selected */
			$credit_card =( $credit_card ==='' )?'2':$credit_card;
			$delivery =( $delivery ==='' )?'2':$delivery;
			$vegetarian =( $vegetarian ==='' )?'2':$vegetarian;
			$parking =( $parking ==='' )?'2':$parking;
			$take_reservation =( $take_reservation ==='' )?'2':$take_reservation;
			$air_conditioned =( $air_conditioned ==='' )?'2':$air_conditioned;
			$serving_alcohol =( $serving_alcohol ==='' )?'2':$serving_alcohol;
			#=========================   Radio buttons values and making them 2 if not selected====================
						
            $business_category    = htmlspecialchars($this->input->post('business_category'), ENT_QUOTES, 'utf-8');
            $arr= array("name"=>htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
                        "address"=>htmlspecialchars($this->input->post('address'), ENT_QUOTES, 'utf-8'),
                        "city_id"=>htmlspecialchars($this->input->post('city_id'), ENT_QUOTES, 'utf-8'),
                        "state_id"=>htmlspecialchars($this->input->post('state_id'), ENT_QUOTES, 'utf-8'),
                        "country_id"=>htmlspecialchars($this->input->post('country_id'), ENT_QUOTES, 'utf-8'),
                        "zipcode"=>htmlspecialchars($this->input->post('zipcode'), ENT_QUOTES, 'utf-8'),
                        "land_mark"=>htmlspecialchars($this->input->post('land_mark'), ENT_QUOTES, 'utf-8'),
                        "phone_number"=>htmlspecialchars($this->input->post('phone_number'), ENT_QUOTES, 'utf-8'),
                        "website"=>htmlspecialchars($this->input->post('website'), ENT_QUOTES, 'utf-8'),
                        "contact_person"=>htmlspecialchars($this->input->post('contact_person'), ENT_QUOTES, 'utf-8'),
                        "contact_email"=>htmlspecialchars($this->input->post('contact_email'), ENT_QUOTES, 'utf-8'),
                        "business_type_id"=>htmlspecialchars($this->input->post('business_type_id'), ENT_QUOTES, 'utf-8'),
                        "price_range_id"=>htmlspecialchars($this->input->post('price_range_id'), ENT_QUOTES, 'utf-8'),
                        "credit_card"=>$credit_card,
                        "delivery"=>$delivery,
                        "vegetarian"=>$vegetarian,
                        "parking"=>$parking,
                        "take_reservation"=>$take_reservation,
                        "air_conditioned"=>$air_conditioned,
                        "serving_alcohol"=>$serving_alcohol,
                        "business_category"=>htmlspecialchars($this->input->post('business_category'), ENT_QUOTES, 'utf-8'),
                        "hour_comment"=>htmlspecialchars($this->input->post('hour_comment'), ENT_QUOTES, 'utf-8'),
                        "other_cuisine"=>htmlspecialchars($this->input->post('other_cuisine'), ENT_QUOTES, 'utf-8'),
						"tags"=>htmlspecialchars($this->input->post('tags'), ENT_QUOTES, 'utf-8'),
                        "region_id"=>1,
                        "cr_date"=>time(),
                        "cr_by"=>$this->session->userdata('user_id')
                );
            $businessId	= $this->business_model->set_data_insert('business', $arr);
            if($businessId)
            {
				$cuisine_id = $this->input->post('cuisine_id');
                if(is_array($cuisine_id))
                {
                    foreach($cuisine_id as $v)
                    {
                        $tmp_arr= array("business_id"=>$businessId,
                            "cuisine_id"=>$v,
                            "cr_date"=>time(),
                            "cr_by"=>$this->session->userdata('user_id')
                        );
                        $this->business_model->set_data_insert('business_cuisine',$tmp_arr);
                    }
                }
                $this->load->model('date_time_model');
                foreach($this->date_time_model->day_text as $k=>$v)
                {
                    $tmp_arr= array("business_id"=>$businessId,
                        "day"=>$v,
                        "hour_from"=>$this->input->post('hour_from'.$v),
                        "hour_to"=>$this->input->post('hour_to'.$v),
                        "cr_date"=>time(),
                        "cr_by"=>$this->session->userdata('user_id')
                    );
                    $this->business_model->set_data_insert('business_hour', $tmp_arr);
                }
				
				$max_file_size = $this->site_settings_model->get_site_settings('max_image_file_size');
                $str_permissible_extensions = $this->config->item('image_support_extensions');
				$this->load->library('image_lib');
				$max_available_menu_image = $this->input->post('counter_menu_image');
				$max_available_pics = $this->input->post('counter_img');
				
				if (isset($max_available_menu_image) && !empty($max_available_menu_image) && $this->input->post('business_category')==1) {
					$arr_menuname = array();
					$counter_menu_image = 1;

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
								"business_id"=>$businessId,
								"img_name"=>$arr_menuname[$counter_menu_image],
								"status"=>'1',
								"cr_date"=>time(),
								"cr_by"=>$this->session->userdata('user_id')
							);
							$this->business_model->set_data_insert('business_menu', $tmp_arr);
							unset($tmp_arr);
							$counter_menu_image++;
						}
					}
				}
				
				if (isset($max_available_pics) && !empty($max_available_pics)) {
					$arr_picname = array();
					$counter_pic = 1;
					$cover_picture = 'Y';

					for ($counter_available_pic = 1; $counter_available_pic <= $max_available_pics; $counter_available_pic++) {
						if (is_uploaded_file($_FILES["img$counter_available_pic"]['tmp_name'])) {
							$pic_details = upload_file($this,
								array(
									'upload_path' => $this->upload_path,
									'file_name' => 'business_'.$businessId."_".$counter_pic."_".time(),
									'allowed_types' => $str_permissible_extensions,
									'max_size' => $max_file_size,
									'max_width' => '0',
									'max_height' => '0'
								), "img$counter_available_pic"
							);

							if (is_array($pic_details)) {
								$arr_picname[$counter_pic] = $pic_details['orig_name'];
								
								$config['image_library'] = 'gd2';
								$config['source_image'] = $pic_details['full_path'];
								$config['create_thumb'] = TRUE;
								$config['maintain_ratio'] = TRUE;
								$config['thumb_marker'] = '';
								$config['width'] = $this->config->item('image_thumb_width');
								$config['height'] = $this->config->item('image_thumb_height');
								$config['new_image'] = $this->upload_path.$this->config->item('image_folder_thumb').$arr_picname[$counter_pic];
								$this->image_lib->initialize($config);
								$this->image_lib->resize();
								$this->image_lib->clear();

								$showable_image['image_library'] = 'gd2';
								$showable_image['source_image'] = $pic_details['full_path'];
								$showable_image['create_thumb'] = TRUE;
								$showable_image['maintain_ratio'] = TRUE;
								$showable_image['thumb_marker'] = '';
								$showable_image['width'] = $this->config->item('image_view_width_menu');
								$showable_image['height'] = $this->config->item('image_view_height_menu');
								$showable_image['new_image'] = $this->upload_path.$this->config->item('image_folder_view').$arr_picname[$counter_pic];
								$this->image_lib->initialize($showable_image);
								$this->image_lib->resize();
								$this->image_lib->clear();
							}
							else {
								$err = explode('|', $pic_details);
								$message = $err[0];
							}

							unset($pic_details, $config, $showable_image);
						}

						if (!empty($arr_picname[$counter_pic])) {
							if ($counter_pic > 1)
								$cover_picture = 'N';
							
							$tmp_arr = array(
								"business_id"=>$businessId,
								"img_name"=>$arr_picname[$counter_pic],
								"cover_picture" => $cover_picture,
								"status"=>'1',
								"cr_date"=>time(),
								"cr_by"=>$this->session->userdata('user_id')
							);
							$this->business_model->set_data_insert('business_picture', $tmp_arr);
							unset($tmp_arr);
							$counter_pic++;
						}
					}
				}

                $this->session->set_userdata('user_values', '' );
                $this->session->set_userdata(array('message'=>'Your business has been added successfully. It will be published within the next 24 hours','message_type'=>'succ'));
                header('location:'.base_url().'business/'.$businessId);
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
		
        $this->session->set_userdata(array('message'=>$message,'message_type'=>'err'));
        header('location:'.base_url().'business/add');
        exit();
    }

    function get_business_type_ajax()
    {
        $id = $this->input->post('id');
        $this->load->model('category_model');
        $htm    ='<select id="business_type_id" name="business_type_id">
                            <option value="">Select a business type</option>'.
                            makeOption($this->category_model->get_cat_selectlist('',$id)).
                        '</select>';
        echo $htm;
    }
    
    function get_state_ajax()
    {
        $id = $this->input->post('id');
        $this->load->model('location_model');
        $htm    ='<select id="state_id" name="state_id" onchange="fun_state(this.value);">
                            <option value="">Select a state</option>'.
                            $this->location_model->get_state_list_option(-1,$id).
                        '</select>';
        echo $htm;
    }

    function get_city_ajax()
    {
        $id = $this->input->post('id');
        $this->load->model('location_model');
        if($id>0)
            $htm    ='<select id="city_id" name="city_id" onchange="fun_city(this.value);">
                            <option value="">Select a city</option>'.
                            $this->location_model->get_city_list_option(-1,$id).
                        '</select>';
        else
            $htm    ='<select id="city_id" name="city_id">
                            <option value="">Select a city</option></select>';
        echo $htm;
    }
    
    function get_zipcode_ajax()
    {
        $id = $this->input->post('id');
        $this->load->model('location_model');
        if($id>0)
            $htm    ='<select id="zipcode" name="zipcode" >
                            <option value="">Select a pincode</option>'.
                            $this->location_model->get_zip_code_list_option(-1,$id).
                        '</select>';
        else
            $htm    ='<select id="zipcode" name="zipcode">
                            <option value="">Select a pincode</option></select>';
        echo $htm;
    }

    function get_price_ajax()
    {
        $id = $this->input->post('id');
        $this->load->model('price_range_model');
        $htm    ='<select id="price_range_id" name="price_range_id">'.
                            $this->price_range_model->get_price_range_option(-1,$id).
                        '</select>';
        echo $htm;
    }

	/**
	 * Shows the Ajax pop-up, for sending SMS to Phone
	 *
	 * @param integer $business_id
	 * @author Anutosh Ghosh
	 */
	function show_send_2_phone($business_id) {
		if(!isset($business_id) || empty($business_id) || $business_id < 1) {
			$this->session->set_userdata(array(
				'message' => "Business ID not available. Please check.",
				'message_type' => 'err'
			));
			header("Location: ".base_url().'profile');
			exit();
		}

		$data['biz_id'] = $business_id;
		$this->load->view('ajax_view/send_2_phone.tpl.php', $data);
	}

	/**
	 * Sends a SMS to a Phone, using SMS Gateway
	 *
	 * @param integer $business_id
	 * @author Anutosh Ghosh
	 */
	function get_send_2_phone($business_id) {
	
		$message = '';

		if(!isset($business_id) || empty($business_id))	{
			$message = 'ERR'."Business ID not available. Please check.";
		}
		else {
			if ($this->session->userdata('user_id') == '') {
				$recaptcha_challenge = $this->input->post('recaptcha_challenge_field');
				$recaptcha_response = $this->input->post('recaptcha_response_field');

				include BASEPATH.'application/libraries/recaptchaLib/recaptchalib'.EXT;
				$response = recaptcha_check_answer (
					$this->config->item('recaptcha_private_key'),
					$_SERVER["REMOTE_ADDR"],
					$recaptcha_challenge,
					$recaptcha_response
				);

				if (empty($response->is_valid)) {
					$message = 'ERR'."Sorry, the Captcha did not match. Please provide again.";
				}
			}

			if (empty($message)) {
				$mobile_num = $this->input->post('mobile_num');
				if (empty($mobile_num) || strlen($mobile_num) < 10 || !is_numeric($mobile_num)) {
					$message = 'ERR'."Please provide the Mobile Number of 10 digits only.";
				}
				else {
					$this->load->model('business_profile_model');
					$this->load->model('site_settings_model');

					$business_detail = $this->business_profile_model->get_business_detail(array('id'=>$business_id));
					if (empty($business_detail)) {
						$message = 'ERR'."Sorry, the Business ID provided is not correct and valid.";
					}
					else {
						$this->load->model('location_model');
						$site_settings = $this->site_settings_model->get_site_settings(array(
							'sms_gateway_username',
							'sms_gateway_password',
							'sms_gateway_senderid'
						));

						if (empty($site_settings['sms_gateway_username']) ||
								empty($site_settings['sms_gateway_password']) ||
								empty($site_settings['sms_gateway_senderid'])) {
							$message = 'ERR'."Sorry, the SMS could not be sent, as the SMS Gateway details are not available at this moment. Please try later.";
						}
						else {
							$arr_sms_msg = array();
							$arr_sms_msg[] = $business_detail[0]['name'];
							if (!empty($business_detail[0]['phone_number'])) {
								$arr_sms_msg[] = $business_detail[0]['phone_number'];
							}
							if (!empty($business_detail[0]['address'])) {
								$arr_sms_msg[] = $business_detail[0]['address'];
							}
							if (!empty($business_detail[0]['city_id'])) {
								$city_details = $this->location_model->get_city_list(1, 0, array('id' => $business_detail[0]['city_id']));

								if (!empty($city_details)) {
									$arr_sms_msg[] = $city_details[0]['name'];
									$arr_sms_msg[] = $city_details[0]['s_name'];
								}
							}
							if (!empty($business_detail[0]['zipcode'])) {
								$arr_sms_msg[] = $business_detail[0]['zipcode'];
							}
							$str_sms_msg = implode(', ', $arr_sms_msg);

							$arr_url_sms = array(
								'username' => $site_settings['sms_gateway_username'],
								'password' => $site_settings['sms_gateway_password'],
								'sendername' => $site_settings['sms_gateway_senderid'],
								'message' => $str_sms_msg,
								'mobileno' => $this->config->item('mobile_num_prefix').$mobile_num
							);

							#$str_url_sms = http_build_query($arr_url_sms);
							$str_url_sms = "username=".$site_settings['sms_gateway_username']."&password=".$site_settings['sms_gateway_password']."&sendername=".$site_settings['sms_gateway_senderid']."&message=".urlencode($str_sms_msg)."&mobileno=".$this->config->item('mobile_num_prefix').$mobile_num;
							$url_sms = "http://bulksms.mysmsmantra.com:8080/WebSMS/SMSAPI.jsp?".$str_url_sms;

							if (!empty($url_sms)) {
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, $url_sms);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								$sms_output = curl_exec($ch);
								curl_close($ch);
							}

							if (isset($sms_output) && preg_match('/successfully sent/i', $sms_output)) {
								$message = 'SUC'."SMS has been sent successfully.";
							}
							else {
								$message = 'ERR'."Sorry SMS could not be sent. ".$sms_output;
							}
						}
					}
				}
			}
		}

		echo $message;
	}
/**
 *
 * @param <type> $business_review_id
 * Purnendu ( for updating review )
 */
	function update_review($business_review_id)
	{
		$this->check_user_page_access('registered');
		$this->load->model('review_model');
		$this->data['review_data'] = $this->review_model->get_review($business_review_id) ;
		$login_id = $this->session->userdata('user_id');
		//echo $this->data['review_data'][0]['star_rating'];exit;
		$review_row_user_id = $this->data['review_data'][0]['user_id'];
		if($login_id != $review_row_user_id)
			{

			$this->session->set_userdata(array(
				'message' => "You are not allowed to update this review",
				'message_type' => 'err'
			));
		header('location:'.base_url().'profile');

			}

		/*echo "<pre>";
		print_r($this->data['review_data'][0]['user_id']);
		echo "</pre>";exit;*/
		$this->data['review_id'] = $business_review_id;
		$this->data['business_id'] =$this->data['review_data'][0]['id'];
		$this->data['title'] = 'Update Review';
        $this->add_js(array('ajax_helper','common_js','fromvalidation','ModalDialog','js_form'));
        $this->set_include_files(array('business/write_review_update'));
        $this->render();
	}


	function save_review_update($review_id)
	{

		$review_title = htmlspecialchars($this->input->post('review_title'), ENT_QUOTES, 'utf-8');
		$review_comment = htmlspecialchars($this->input->post('comment'), ENT_QUOTES, 'utf-8');
		$star_rating    = htmlspecialchars($this->input->post('star_rating'), ENT_QUOTES, 'utf-8');
		$message    = '';
		$arr_post = array();
        $temp_arr = array_merge($arr_post, $_POST);
        $this->session->set_userdata('user_values', $temp_arr );
        $this->session->set_userdata('user_messages', array());
        if(trim($this->input->post('review_title'))=='')
            $message    = 'Please give your review title';
        elseif(trim($this->input->post('comment'))=='' )
            $message    = 'Please write your comment';
		//elseif(trim($this->input->post('star_rating'))=='' || $this->input->post('star_rating')<1)
          //  $message    = 'Please give your star rating';

		if( $message == '')
		{
		$this->load->model('review_model');
		$this->review_model->save_updated_review($review_id,$review_title,$review_comment,$star_rating );
		$this->session->set_userdata(array(
				'message' => "Updated Successfully.",
				'message_type' => 'suc'
			));
		$business_id = $this->review_model->get_review($review_id);
		
		$this->review_model->set_business_review_update($business_id[0]['id']);
		header('location:'.base_url().'profile');

		exit;
		}
		$this->session->set_userdata(array('message'=>$message,'message_type'=>'err'));
        header('location:'.base_url().'business/update_review/'.$review_id);
        exit();

	}


	function delete_review($review_id)
	{
		
		$this->check_user_page_access('registered');
		$this->load->model('review_model');
		$this->data['review_data'] = $this->review_model->get_review($review_id) ;
		$login_id = $this->session->userdata('user_id');
		$review_row_user_id = $this->data['review_data'][0]['user_id'];
		if($login_id != $review_row_user_id)
		{

			$this->session->set_userdata(array(
				'message' => "You are not allowed to delete this review",
				'message_type' => 'err'
			));
			header('location:'.base_url().'profile');
			exit();
		}
		
		$business_id = $this->review_model->get_review($review_id);
		$this->review_model->delete_review($review_id);
		$this->review_model->set_business_review_update($business_id[0]['business_id']);
		$this->session->set_userdata(array(
				'message' => "Deleted Successfully.",
				'message_type' => 'suc'
			));
		header('location:'.base_url().'profile');
	}

	function show_profile1($user_id=0, $search_text = '')
	{
		
		$search_text =  htmlspecialchars($this->input->post('search_text'), ENT_QUOTES, 'utf-8');
		$this->load->model('users_model');
        $this->load->model('review_model');
        $data['user_type'] = $this->users_model->user_type;
        $this->data['row']    = $this->users_model->get_user_detail_light_box(array('id'=>$user_id));
		if(	$search_text != '')
		$review_detail    = $this->review_model->get_review_detail(-1,0,array('user_id'=>$user_id , 'search_text'=>$search_text));
		else 
		$review_detail    = $this->review_model->get_review_detail(-1,0,array('user_id'=>$user_id ));
		foreach($review_detail as $key=>$value)
		{
			$sql1 = "SELECT b.id, b.name,b.address,b.zipcode FROM {$this->db->dbprefix}business b
			       WHERE  b.id = {$value['business_id']} ";
			$sql2 = "SELECT bp.img_name FROM {$this->db->dbprefix}business_picture bp
			       WHERE  bp.business_id = {$value['business_id']} AND bp.cover_picture = 'Y'";
			$review_detail[$key]['business_details'] = $this->review_model->get_query_result($sql1);
			$review_detail[$key]['business_img'] = $this->review_model->get_query_result($sql2);
		}
		$this->data['review_details'] = $review_detail;
		$this->data['total_review']	  =	count( $review_detail );
		$no_of_first_review = 0;
		foreach($review_detail as $key)
		{
			$first_review = $this->review_model->get_business_first_review($key['business_id']);
			if( $first_review['0']['id'] == $user_id )
				$no_of_first_review++;
		}
		$this->data['no_of_first_review']= $no_of_first_review;
		$this->data['facebook_url']	= base_url().substr(uri_string(),1);
		
		#===========================================================================================
			#Getting information about business added by user
		#============================================================================================
		/*$this->load->model('business_model');
		$added_business_details = $this->business_model->get_business_added_by_user($user_id);
		foreach($added_business_details as $key=>$value)
		{
			$added_business_details[$key]['business_img'] = $this->business_model->get_business_image($value['id']);
		}
		
		$this->data['added_business'] = $added_business_details;*/
		//var_dump($this->data['added_business']);exit;
		$this->add_js(array('jquery','jquery.tabs.pack'));
        //$this->add_css(array('jquery.tabs'));
		$this->set_include_files(array('business/reviewer_profile'));
        $this->render();


	}
	
	function show_profile($user_id=0, $search_text = '')
	{
		
		$search_text =  htmlspecialchars($this->input->post('search_text'), ENT_QUOTES, 'utf-8');
		$this->load->model('users_model');
        $this->load->model('review_model');
        $data['user_type'] = $this->users_model->user_type;
		$this->data['row']    = $this->users_model->get_user_detail_light_box(array('id'=>$user_id));
		$this->load->model('business_model');
		$business_added  =  $this->business_model->get_business_list_count(array('cr_by'=>$user_id, 'status'=> '1' ));
		$this->data['no_of_business_added'] = $business_added;
		$user_type_id = $this->data['row'][0]['user_type_id'];
		switch($user_type_id)
		{
			case 1: $this->data['user_type_icon'] = 'images/front/lightbox_close.png';
					$this->data['user_type'] = 'Admin' ;break;
			case 2: $this->data['user_type_icon'] = 'images/front/icon_24.png';
					$this->data['user_type'] = 'Regular' ;break;
			case 3: $this->data['user_type_icon'] = 'images/front/icon_25.png';
					$this->data['user_type'] = 'Elite' ;break;
			case 4: $this->data['user_type_icon'] = 'images/front/icon_26.png';
					$this->data['user_type'] = 'Merchant' ;
		}
		$review_detail    = $this->review_model->get_review_detail(-1,0,array('user_id'=>$user_id ));
		$this->data['total_review']	  =	count( $review_detail );
		$no_of_first_review = 0;
		foreach($review_detail as $key)
		{
			$first_review = $this->review_model->get_business_first_review($key['business_id']);
			if( $first_review['0']['id'] == $user_id )
				$no_of_first_review++;
		}
		$this->data['no_of_first_review']= $no_of_first_review;
		if(	$search_text != '')
		$review_detail    = $this->review_model->get_review_detail(-1,0,array('user_id'=>$user_id , 'search_text'=>$search_text));
		else 
		$review_detail    = $this->review_model->get_review_detail(-1,0,array('user_id'=>$user_id ));
		//var_dump($review_detail);exit;
		if( $review_detail[0]['tot_row'] !=0 ) 
		foreach($review_detail as $key=>$value)
		{
			$sql1 = "SELECT b.id, b.name,b.address,b.zipcode FROM {$this->db->dbprefix}business b
			       WHERE  b.id = {$value['business_id']} ";
			$sql2 = "SELECT bp.img_name FROM {$this->db->dbprefix}business_picture bp
			       WHERE  bp.business_id = {$value['business_id']} AND bp.cover_picture = 'Y'";
			$review_detail[$key]['business_details'] = $this->review_model->get_query_result($sql1);
			$review_detail[$key]['business_img'] = $this->review_model->get_query_result($sql2);
		}
		$this->data['review_details'] = $review_detail;
		
		$this->data['facebook_url']	= base_url().substr(uri_string(),1);
		
		#===========================================================================================
			#Getting information about business added by user
		#============================================================================================
		/*$this->load->model('business_model');
		$added_business_details = $this->business_model->get_business_added_by_user($user_id);
		foreach($added_business_details as $key=>$value)
		{
			$added_business_details[$key]['business_img'] = $this->business_model->get_business_image($value['id']);
		}
		
		$this->data['added_business'] = $added_business_details;*/
		//var_dump($this->data['added_business']);exit;
		$this->add_js(array('jquery','jquery.tabs.pack'));
        //$this->add_css(array('jquery.tabs'));
		$this->set_include_files(array('business/reviewer_profile'));
        $this->render();


	}
	




}