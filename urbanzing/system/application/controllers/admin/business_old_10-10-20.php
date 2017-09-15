<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class Business extends MY_Controller
{
    function __construct()
    {
		parent::__construct();
		$this->check_user_page_access('registered');
        $this->load->model('business_model');
		$this->menu_id  = 1;
	}

	function index($order_name='cr_date',$order_type='asc',$page=0)
    {
		$this->load->model('category_model');
        $sessArrTmp = array();
        $this->data['title'] = 'Business Page';
        if($this->input->post('go'))
        {
            $sessArrTmp['src_business_title']=$this->input->post('title');
            $sessArrTmp['src_business_status']=$this->input->post('status');
            $sessArrTmp['src_business_featured']=$this->input->post('featured');
            $sessArrTmp['src_business_category']=$this->input->post('business_category');
        }
        else
        {
            $sessArrTmp['src_business_title']=$this->get_session_data('src_business_title');
            $sessArrTmp['src_business_status']=$this->get_session_data('src_business_status');
			$sessArrTmp['src_business_featured']=$this->get_session_data('src_business_featured');
            $sessArrTmp['src_business_category']=$this->input->post('business_category');
        }

        $this->data['txtArray']   = array("title"=>"Title");
        $this->data['txtValue']   = array($sessArrTmp['src_business_title']);
        $this->data['optArray']   = array("business_category"=>"Business_Type","featured"=>"Featured","status"=>"Status");
        $this->data['optValue']   = array(makeOption($this->category_model->business_type,$sessArrTmp['src_business_category']) ,makeOption(array("Y"=>"Yes","N"=>"No"),$sessArrTmp['src_business_featured']),
            makeOption(array("1"=>"Enable","0"=>"Disable"),$sessArrTmp['src_business_status']));
		
		//echo $sessArrTmp['src_business_title'];
		$arr = array('name'=>$sessArrTmp['src_business_title'],'business_category'=>$sessArrTmp['src_business_category'],'featured'=>$sessArrTmp['src_business_featured'],'status'=>$sessArrTmp['src_business_status']);
		
        $this->data['business']=$this->business_model->get_business_list($arr,$this->admin_page_limit,($page)?$page:0,$order_name,$order_type);
		//var_dump($this->data['business']);
        $totRow = $this->business_model->get_business_list_count($arr);
        if(!$this->data['business'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/business/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/business/index/'.$order_name.'/'.$order_type,
                    'total_row'=>$totRow,
                    'per_page'=>$this->admin_page_limit,
                    'uri_segment'=>6,
                    'next_link'=>'Next&gt;',
                    'prev_link'=>'&lt;Prev'
                )
            );
		$this->data['status'] = $this->business_model->business_status;
        $this->data['order_name']=$order_name;
        $this->data['order_type']=$order_type;
        $this->data['page']=$page;
        $sessArrTmp['redirect_url']=base_url().'admin/business/index/'.$order_name.'/'.$order_type.'/'.$page;
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','business/business_list'));
		$this->render();
	}

    function ajax_change_status()
    {
        $status   = $this->input->post('status');
        $id   = $this->input->post('id');
        if($this->business_model->change_data_status('business',$id,$status))
        {
            $txt     = " Not Approved";
            $style='';
            $status=1-$status;
            if($status==1)
            {
                $style  = "color:green;";
                $txt     = " Approved";
            }
            $jsnArr = json_encode(array('id'=>$id,'status'=>$status));
            echo "<a onclick='call_ajax_business_status_change(\"".base_url()."admin/business/ajax_change_status\",".$jsnArr.",\"status".$id."\");' style='cursor:pointer; ".$style."'> ".$txt."</a>|".$id;
        }
    }

    function delete_business($id)
    {
        if($this->business_model->delete_business($id))
            $this->session->set_userdata(array('message'=>'Business deleted successfully..','message_type'=>'err'));
        else
            $this->session->set_userdata(array('message'=>'Unable to delete business..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }

    function add_business()
    {
        $this->data['title'] = 'Add business Page';
        $this->data['table_title'] = 'Add business';
		$this->load->model('location_model');
		$this->data['country'] = $this->location_model->get_country_list_option(113);

        $this->add_js(array('tinymce/jscripts/tiny_mce/tiny_mce','tinymce_load','fromvalidation'));
        $this->set_include_files(array('common/admin_menu','business/add_business'));
		$this->render();
    }

    function edit_business($business_id=-1)
    {
        if(!$business_id||!is_numeric($business_id)||$business_id==-1)
        {
            $this->session->set_userdata(array('message'=>'Data not found for this business..','message_type'=>'err'));
            header("Location: ".$this->get_redirect_url());
            exit(0);
        }
		$this->data['table_title'] = 'Edit business';
		$this->data['title'] = 'Edit business';
		$this->load->model('location_model');
		$this->load->model('category_model');
        $this->load->model('location_model');
        $this->load->model('price_range_model');
        $this->load->model('cuisine_model');
        $this->load->model('date_time_model');
        $this->load->model('business_model');
		$this->load->model('business_profile_model');

        $this->data['data'] = $this->session->userdata('user_values');
        if(!isset($this->data['data']) || count($this->data['data'])<1 || $this->data['data'].'a'=='a')
        {
            $tmp    = $this->business_model->get_business_list(array('id'=>$business_id),1);
            $this->data['data'] = $tmp[0];
            $this->data['data']['hour'] = '';
            $this->data['data']['cuisine_id']   = $this->cuisine_model->get_cuisine_id_arr($this->data['data']['id']);

        }
		if(!isset($this->data['data']['id']))
		{
            $this->session->set_userdata(array('message'=>"Sorry, business not available now.",'message_type'=>'err'));
            //header('location:'.base_url().'profile');
			header('location:'.$this->get_redirect_url());
            exit();
		}
		
        $this->session->set_userdata('user_values', '' );
  $this->data['business_status']    = makeOption($this->business_model->business_status,$this->data['data']['status']);		
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
	
		$this->data['redirect_url'] = $this->get_redirect_url();
        $this->set_include_files(array('common/admin_menu','business/edit_business'));
		$this->render();
    }

    function insert_business()
    {
        $arr= array("price_from"=>htmlspecialchars($this->input->post('price_from'), ENT_QUOTES, 'utf-8'),
					"price_to"=>htmlspecialchars($this->input->post('price_to'), ENT_QUOTES, 'utf-8'),
					"country_id"=>htmlspecialchars($this->input->post('country_id'), ENT_QUOTES, 'utf-8'),
					"status"=>$this->input->post('status'),
                    "cr_date"=>time(),
					"cr_by"=>$this->session->userdata('user_id')
        );
		$id = $this->business_model->set_data_insert('business',$arr);
        if($id)
			$this->session->set_userdata(array('message'=>'Business add successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to add Business..','message_type'=>'err'));
        header('location:'.base_url().'admin/business');
        exit;
    }

    function save_business_edit()
    {
		
        $this->upload_path = BASEPATH.'../images/uploaded/business/';
		$this->load->library('image_lib');
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

        if($message=='' )
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
						"tags"=>htmlspecialchars($this->input->post('tags'), ENT_QUOTES, 'utf-8'),
                        "region_id"=>1,
                        "menu_image_name"=>($menuname=='')?$this->input->post('menu_image_name'):$menuname,
						"editorial_comments"=>htmlspecialchars($this->input->post('editorial_comments'), ENT_QUOTES, 'utf-8'),
                        "update_date"=>time(),
                        "update_by"=>$this->session->userdata('user_id'),
						"status"=>htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
						"other_cuisine"=>htmlspecialchars($this->input->post('other_cuisine'), ENT_QUOTES, 'utf-8')
                );
            $this->business_model->set_data_update('business', $arr, $businessId);
            if($businessId)
            {
                $this->load->model('cuisine_model');
                $this->cuisine_model->set_delete_cuisine(-1, $businessId);
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
                }

                $max_file_size = $this->site_settings_model->get_site_settings('max_image_file_size');
				$str_permissible_extensions = 'gif|jpg|png|jpeg';
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
								$config['image_library'] = 'gd2';
								$config['source_image'] = $img_details['full_path'];
								$config['create_thumb'] = TRUE;
								$config['maintain_ratio'] = TRUE;
								$config['thumb_marker'] = '';
								$config['width'] = 150;
								$config['height'] = 150;
								$config['new_image'] = $this->upload_path.'thumb/'.$img_details['orig_name'];
								$this->image_lib->initialize($config);
								$this->image_lib->resize();
								$this->image_lib->clear();
								$arr_menuname[$counter_menu_image] = $img_details['orig_name'];
							}
							else {
								$err = explode('|', $img_details);
								$message = $err[0];
							}

							unset($img_details, $config);
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
								$config['image_library'] = 'gd2';
								$config['source_image'] = $pic_details['full_path'];
								$config['create_thumb'] = TRUE;
								$config['maintain_ratio'] = TRUE;
								$config['thumb_marker'] = '';
								$config['width'] = 150;
								$config['height'] = 150;
								$config['new_image'] = $this->upload_path.'thumb/'.$pic_details['orig_name'];
								$this->image_lib->initialize($config);
								$this->image_lib->resize();
								$this->image_lib->clear();
								$arr_picname[$counter_pic] = $pic_details['orig_name'];
							}
							else {
								$err = explode('|', $pic_details);
								$message = $err[0];
							}

							unset($pic_details, $config);
						}

						if (!empty($arr_picname[$counter_pic])) {
							if (empty($cover_pic_row_details) && $counter_available_pic == 1) {
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
				$this->session->set_userdata(array('message'=>'Business edited successfully.','message_type'=>'succ'));
                //header('location:'.base_url().'business/'.$businessId);
				header('location:'.$this->get_redirect_url());
                exit();
            }
            else
            {
				$this->session->set_userdata(array('message'=>'Unable to edit your business','message_type'=>'err'));
                $this->session->set_userdata('user_values', '' );
                //header('location:'.base_url().'profile');
				header('location:'.$this->get_redirect_url());
                exit();
            }
        }

        $this->session->set_userdata(array('message'=>$message,'message_type'=>'err'));
        header('location:'.base_url().'admin/business/edit_business/'.$businessId);
        exit();
    
	
	
	}

    
	function delete_image()
	{
		$this->check_user_page_access('registered');
		$id= $this->input->post('id');
		$business_img_name=$this->business_model->get_business_list(1,0,$id);
	 	if($business_img_name && $business_img_name[0]['img'])
	 	{
	 		$img_name = $business_img_name[0]['img'];
			$job_id = $business_img_name[0]['id'];
			$img_path = $this->dir_name.$img_name;
			$img_thumb_path = $this->dir_thumb_name.$img_name;
			
			if(file_exists($img_path))
				unlink($img_path);
			if(file_exists($img_thumb_path))
				unlink($img_thumb_path);	

			if($this->business_model->delete_image($id)) 
			{
				echo 'Image deleted successfully<br>|';
			}	
			else
				echo 'Not deleted successfully<br>|0';					 
		 } 
		 else 
			echo 'Not deleted successfullyaaa<br>|0';	 	
		 
	}
	
	function business_claim($business_id=-1)
	{
		if($business_id==-1 || $business_id=='')
		{
			 header('location:'.$this->get_redirect_url());
       		 exit;
		}
        $sessArrTmp = array();
        $this->data['title'] = 'Business Claim Page';
/*        if($this->input->post('go'))
        {
            $sessArrTmp['src_business_title']=$this->input->post('title');
            $sessArrTmp['src_business_status']=$this->input->post('status');
        }
        else
        {
            $sessArrTmp['src_business_title']=$this->get_session_data('src_business_title');
            $sessArrTmp['src_business_status']=$this->get_session_data('src_business_status');
        }

        $this->data['txtArray']   = array("title"=>"Title");
        $this->data['txtValue']   = array($sessArrTmp['src_business_title']);
        $this->data['optArray']   = array("status"=>"Status");
        $this->data['optValue']   = array(
            makeOption(array("1"=>"Enable","0"=>"Disable"),$sessArrTmp['src_business_status'])
        );*/
		//echo $sessArrTmp['src_business_title'];
	
		
        $this->data['business'] = $this->business_model->business_claim_list($business_id);
		//var_dump($this->data['business']);

        $this->data['order_name']=$order_name;
        $this->data['order_type']=$order_type;
        $this->data['page']=$page;
        $this->data['redirect_url']=$this->get_redirect_url();;
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js(array('ajax_helper','jquery.blockUI'));
        $this->set_include_files(array('common/admin_menu','business/business_claim_list'));
		$this->render();
			
	}
	
    function ajax_business_claim_change_status()
    {
        $status   = $this->input->post('status');
        $business_id = $this->input->post('business_id');
        $id   = $this->input->post('id');

        if($status==0)
        {
            $arr = array('verified'=>1,'business_id'=>$business_id);
            $tot = $this->business_model->get_business_claim_list($arr,-1,0);
            if(count($tot) > 0){
                echo 'err|Already one claim verified.';
                return;
            }
        }
        if($this->business_model->change_data_claim_status('business_claimed',$id,$status))
        {
            $arr = array('id'=>$id);
            $cr_by = $this->business_model->get_business_claim_list($arr,1,0);
			//var_dump($cr_by);
            if($cr_by[0]['verified']==1)
            {
                $arr = array('business_owner_id'=>$cr_by[0]['cr_by']);
                $this->business_model->set_data_update('business',$arr,$cr_by[0]['business_id']);
            }
            else
            {
                $arr = array('business_owner_id'=>0);
                $this->business_model->set_data_update('business',$arr,$cr_by[0]['business_id']);
            }
            $txt     = " Not Approved";
            $style='';
            $status=1-$status;
            if($status==1)
            {
                $style  = "color:green;";
                $txt     = " Approved";
            }
            $jsnArr = json_encode(array('id'=>$id,'status'=>$status,'business_id'=>$business_id));
            echo "succ|<a onclick='call_ajax_status_change_UiBlock(\"".base_url()."admin/business/ajax_business_claim_change_status\",".$jsnArr.",\"status".$id."\");' style='cursor:pointer; ".$style."'> ".$txt."</a>";
        }
    }	
	
	function ajax_change_featured_status()
	{
        $featured   = $this->input->post('featured');
        $id   = $this->input->post('id');
		$arr = array('is_featured'=>$featured);
        if($this->business_model->set_data_update('business',$arr,$id))
		{
			$arr = array('id'=>$id);
			$this->data['business'] = $this->business_model->get_business_list($arr,1,0);
			//var_dump($this->data['business']);
			echo $this->load->view('admin/business/ajax_featured_option.tpl.php',$this->data);
		}	
    	
	}
	
	function ajax_claim_link()
	{
		$id   = $this->input->post('business_id');
		$this->data['business'] = $this->business_model->get_business_list(array('id'=>$id),1,0);
		echo $this->load->view('admin/business/ajax_claim_list.tpl.php',$this->data);
	}
	
	
}
