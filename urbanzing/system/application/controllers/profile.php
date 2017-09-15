<?php
include BASEPATH.'application/controllers/MY_Controller'.EXT;

class profile extends MY_Controller
{
    private $user_type_id='';
    
    function __construct()
    {
        parent::__construct();
        $this->clear_business_search();
        $this->user_type_id = $this->session->userdata('user_type_id');
    }

    function index()
    {
        $this->check_user_page_access('registered');
        $this->session->set_userdata('user_values', '' );
        $this->data['title'] = 'Profile page';
        if($this->user_type_id==4)
            $this->merchant_profile();
        else
            $this->regular_profile();
    }

    private function regular_profile()
    {
		$this->load->model('article_model');
		$this->data['content_text']=$this->article_model->get_article_list(-1,0,-1,'',1,'normal_user_page_text');
	 	$this->add_js(array('ajax_helper','common_js'));
        $this->set_include_files(array('profile/regular_profile'));
        $this->render();
    }

   //To Show The List Of Interested Coupons
	function interest_list_ajax()
    {
        $this->load->model('profile_normal_model');
        $cur_user_id    = $this->session->userdata('user_id');
        $data = array();
        $data['rows'] = $this->profile_normal_model->get_interested_business_detail($cur_user_id);
        $this->load->view('profile/interest_list.tpl.php',$data);
    }
    
  /*  function planed_party_ajax()
    {
        $this->load->model('profile_normal_model');
        $cur_user_id    = $this->session->userdata('user_id');
        $data = array();
        $data['rows'] = $this->profile_normal_model->get_planed_party_list($cur_user_id);
        $this->load->view('profile/planed_party_list.tpl.php',$data);
    }*/
	 function planed_party_ajax()
     {
        $this->load->model('profile_normal_model');
        $cur_user_id = $this->session->userdata('user_id');
        $data = array();
        $data['rows'] = $this->profile_normal_model->get_planed_party_list($cur_user_id);
		$num_rows = count($data['rows']);

		for ($i = 0; $i < $num_rows; $i++) {
			$text_status = 'Sent';
			if ($data['rows'][$i]['status'] == '2')
				$text_status = 'Draft';
			else if ($data['rows'][$i]['status'] == '4')
				$text_status = 'Expired';

			$data['rows'][$i]['text_status'] = $text_status;
			unset($text_status);

			$data['rows'][$i]['edit_link'] = base_url()."party/edit_party/".$data['rows'][$i]['id'];
		}

        $this->load->view('profile/planed_party_list.tpl.php', $data);
    }

    function business_review_ajax()
    {
        $this->load->model('review_model');
        $cur_user_id    = $this->session->userdata('user_id');
        $data = array();
        $data['rows'] = $this->review_model->get_review_detail_business($cur_user_id);
        $this->load->view('profile/business_review_list.tpl.php',$data);
    }
    
    function picture_uploaded_ajax()
    {
        $this->load->model('profile_normal_model');
        $cur_user_id    = $this->session->userdata('user_id');
        $data = array();
        $data['rows'] = $this->profile_normal_model->my_uploaded_picture($cur_user_id);
        $this->load->view('profile/picture_uploaded_list.tpl.php',$data);
    }

    function address_book_ajax()
    {
        $this->load->model('profile_normal_model');
        $cur_user_id    = $this->session->userdata('user_id');
        $data = array();
        $data['rows'] = $this->profile_normal_model->get_address_book_list($cur_user_id);
        $this->load->view('profile/address_book_list.tpl.php',$data);
    }

    function write_review()
    {
		$this->load->model('category_model');
        $this->load->model('profile_normal_model');
		$this->load->model('article_model');
		$this->data['content_text']=$this->article_model->get_article_list(1,0,-1,'',1,'write_review_upper_text');
        $this->data['old_values'] = $this->session->userdata('user_values');
        $this->session->set_userdata('user_values', '' );
        $business_category       = $this->data['old_values']['business_category'];
        $this->data['business_category']    = makeOption($this->category_model->get_cat_selectlist(),$business_category);
        if($business_category>0)
        {
            $this->category_model->option_results='';
            $this->data['business_type']    = makeOption($this->category_model->get_cat_selectlist('',$business_category),$this->data['old_values']['business_type_id']);
            if($this->data['old_values']['business_type_id']>0)
                $this->data['business_option']  = $this->profile_normal_model->get_business_list_option($this->data['old_values']['business_type_id'],$business_category,$this->data['old_values']['business_id']);
        }
        $this->add_js(array('ajax_helper','common_js'));
		$this->add_css('autocomplete');
        $this->set_include_files(array('profile/write_review'));
        $this->render();
    }

	/**
	 * @author Anutosh Ghosh
	 */
    function upload_business_image1()
    {	//last good
        $this->load->model('category_model');
        $this->load->model('profile_normal_model');
		$this->load->model('article_model');
		$this->data['content_text']=$this->article_model->get_article_list(-1,0,-1,'',1,'upload_picture_upper_text');
        $this->data['old_values'] = $this->session->userdata('user_values');
        $this->session->set_userdata('user_values', '' );
        $business_category = $this->data['old_values']['business_category'];
        $this->data['business_category']    = makeOption($this->category_model->get_cat_selectlist(),$business_category);
        $this->data['no_of_menu'] = $this->config->item('no_of_menu') ? $this->config->item('no_of_menu') : 5;
		if($business_category)
        {
            $this->category_model->option_results='';
            $this->data['business_type']    = makeOption($this->category_model->get_cat_selectlist('',$business_category),$this->data['old_values']['business_type_id']);
            if($this->data['old_values']['business_type_id']>0)
                $this->data['business_option']  = $this->profile_normal_model->get_business_list_option($this->data['old_values']['business_type_id'],$business_category,$this->data['old_values']['business_id']);
        }
        $this->add_js(array('ajax_helper','common_js'));
		$this->add_css('autocomplete');
        $this->set_include_files(array('profile/upload_business_image'));
        $this->render();
    }
	
	

	/**
	 * @author Anutosh Ghosh
	 */
    function upload_business_image_save1()
    {
		$this->check_user_page_access('registered');
		$this->upload_path = $this->config->item('upload_image_folder_biz');
		$message = '';
		$imagename = '';
		$arr_post = array();
		$temp_arr = array_merge($arr_post, $_POST);

		$this->session->set_userdata('user_values', $temp_arr );
		$this->session->set_userdata('user_messages', array());

		if(trim($this->input->post('business_category')) == '' )
			$message = 'Please select a business category';
		elseif(trim($this->input->post('business_type_id')) == '' )
			$message = 'Please select a business type';
		elseif(trim($this->input->post('business_id')) == '')
			$message = 'Please select a business';
		elseif($this->input->post('business_category') == '1' && $this->input->post('upload_type') == '')
			$message = 'Please select what do you want to upload';
		elseif(!isset($_FILES['img']['name']) || $_FILES['img']['name'] == '')
			$message = 'Please select a business image';
		elseif($this->input->post('ck_tearms') == '' || $this->input->post('ck_tearms') != 'on')
			$message = 'You have to accept tearms and condition';
		else
		{
			$max_file_size = $this->site_settings_model->get_site_settings('max_image_file_size');
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

		if(empty($message))
		{
			$this->load->model('business_model');
			$arr = array("business_id" => $this->input->post('business_id'),
						"img_name" => $imagename,
						"status" => '0',
						"cr_date" => time(),
						"cr_by" => $this->session->userdata('user_id')
					);

			$target_db_table = 'business_picture';
			if ($this->input->post('upload_type') == 'menu') {
				$target_db_table = 'business_menu';
			}
			else {
				$arr['cover_picture'] = 'N';
			}

			$this->business_model->set_data_insert($target_db_table, $arr);
			$this->session->set_userdata('user_values', '' );
			$this->session->set_userdata(array(
				'message' => 'Business Image uploaded successfully',
				'message_type' => 'succ'
			));
			unset($arr);

			header('Location:'.base_url().'profile');
			exit();
		}

		if(!empty($imagename))
		{
			@unlink($this->upload_path.$imagename);
			@unlink($this->upload_path.$this->config->item('image_folder_thumb').$imagename);
			@unlink($this->upload_path.$this->config->item('image_folder_view').$imagename);
		}

		$this->session->set_userdata(array(
			'message' => $message,
			'message_type' => 'err'
		));
		
		header('Location:'.base_url().'profile/upload_business_image');
		exit();
    }
#================================================================================================================================
#=================================   Upload Pictures Section start ================================================================
	/**
	 * @author Purnendu Shaw
	 */
    function upload_business_image()
    {	//last good
        $this->load->model('category_model');
        $this->load->model('profile_normal_model');
		$this->load->model('article_model');
		$this->data['content_text']=$this->article_model->get_article_list(-1,0,-1,'',1,'upload_picture_upper_text');
        $this->data['old_values'] = $this->session->userdata('user_values');
        $this->session->set_userdata('user_values', '' );
        $business_category = $this->data['old_values']['business_category'];
        $this->data['business_category']    = makeOption($this->category_model->get_cat_selectlist(),$business_category);
		$this->data['max_file_size']		=	$this->site_settings_model->get_site_settings('max_image_file_size');
        $this->data['no_of_menu'] = $this->config->item('no_of_menu') ? $this->config->item('no_of_menu') : 5;
		if($business_category)
        {
            $this->category_model->option_results='';
            $this->data['business_type']    = makeOption($this->category_model->get_cat_selectlist('',$business_category),$this->data['old_values']['business_type_id']);
            if($this->data['old_values']['business_type_id']>0)
                $this->data['business_option']  = $this->profile_normal_model->get_business_list_option($this->data['old_values']['business_type_id'],$business_category,$this->data['old_values']['business_id']);
        }
        $this->add_js(array('ajax_helper','common_js'));
		$this->add_css('autocomplete');
        $this->set_include_files(array('profile/upload_business_image2'));
        $this->render();
    }

function upload_business_image_save()
{
	
	$this->check_user_page_access('registered');
	$this->upload_path = $this->config->item('upload_image_folder_biz');
	$message = '';
	$imagename = '';
	$arr_post = array();
	$temp_arr = array_merge($arr_post, $_POST);

	$this->session->set_userdata('user_values', $temp_arr );
	$this->session->set_userdata('user_messages', array());
	
	#================ start::getting all the values posted by user  ===============================
	$business_category = trim($this->input->post('business_category'));
	$business_id = trim($this->input->post('business_id'));
	$upload_type = trim($this->input->post('upload_type'));
	$count= 	0;
	//$count_picture 		=	0;
	foreach($_FILES as $key=>$value)
	{
		if($value['error'] == 0) 
			$count++;
		
	}
	#================ end::getting all the values posted by user  ===============================
		
    #===========================================================================================================================
	#==================  @@ Checking the inputs are valid or not :: [START] @@ ================================================
	#===========================================================================================================================
	if($business_category == '' || $business_id == '')
		$message = 'Please select a proper business ';
	else if($business_category == 1 && $upload_type == '')
		$message = "Please select what to upload ( menu or picture )";
	else if( $count == 0 )
		$message = "Please select a image.";
	/*else if($this->input->post('ck_tearms') == '' || $this->input->post('ck_tearms') != 'on')
		$message = 'You have to accept tearms and condition';*/
	#=============================== Checking the inputs are valid or not ::[END]=================================================
	#=============================================================================================================================
	if(empty($message))
	{
			$max_file_size = $this->site_settings_model->get_site_settings('max_image_file_size');
			#======= if upload type is menu [START] ================================
			#=======================================================================
			if( $upload_type == 'menu' && $business_category == 1)
			{
					$this->load->model('business_profile_model');
					$business_menu_exist = $this->business_profile_model->get_menu_list($business_id);
		
					if(!empty($business_menu_exist))
					{
						$this->session->set_userdata(array(
							'message' => 'Menu already exists for this business, please email us at info@urbanzing.com if you want the menu changed.',
						'message_type' => 'err'));
						header('Location:'.base_url().'profile/upload_business_image');
						exit();
					}
			
					foreach( $_FILES as $key=>$value ) 
					{
						if( $value['error'] == 0)
						{			$img_details = upload_file($this,
									array('upload_path' => $this->upload_path,
									'file_name' => 'business_'.time(),
									'allowed_types' => $this->config->item('image_support_extensions'),
									'max_size' => $max_file_size,
									'max_width' => '0',
									'max_height' => '0',
								), $key
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
								$showable_image['width'] = $this->config->item('image_view_width');
								$showable_image['height'] = $this->config->item('image_view_height');
								$showable_image['new_image'] = $this->upload_path.$this->config->item('image_folder_view').$imagename;
								$this->image_lib->initialize($showable_image);
								$this->image_lib->resize();
								$this->image_lib->clear();
							   $this->load->model('business_model');
								$arr = array("business_id" => $this->input->post('business_id'),
										"img_name" => $imagename,
										"status" => '0',
										"cr_date" => time(),
										"cr_by" => $this->session->userdata('user_id')
									);

								$target_db_table = 'business_menu';
								$this->business_model->set_data_insert($target_db_table, $arr);
								$this->session->set_userdata('user_values', '' );
								
									$message ='Business Image uploaded successfully';
									$message_type = 'succ';
								unset($arr);
							}
							else
							{
								$err = explode('|', $img_details);
								$message = $err[0];
								$message_type = 'err';
							}
					}
					}
			}
		#======= if upload type is menu [END] =======================================================================
		#=============================================================================================================
				
		#=============================================================================================================	
		#======= if upload type is pic [START] =======================================================================		
		else if( $upload_type == 'pic' || $business_category != 1)
		{	
			$message  =	'';
			foreach( $_FILES as $key=>$value ) 
			{
				if($value['error'] == 0)
				{
							
							$img_details = upload_file($this,
							array('upload_path' => $this->upload_path,
							'file_name' => 'business_'.time(),
							'allowed_types' => $this->config->item('image_support_extensions'),
							'max_size' => $max_file_size,
							'max_width' => '0',
							'max_height' => '0',
						), $key 
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
								$showable_image['width'] = $this->config->item('image_view_width');
								$showable_image['height'] = $this->config->item('image_view_height');
								$showable_image['new_image'] = $this->upload_path.$this->config->item('image_folder_view').
								$imagename;
								$this->image_lib->initialize($showable_image);
								$this->image_lib->resize();
								$this->image_lib->clear();
								$this->load->model('business_model');
								$arr = array("business_id" => $this->input->post('business_id'),
								"img_name" => $imagename,
								"status" => '0',
								"cr_date" => time(),
								"cr_by" => $this->session->userdata('user_id')
								);

								$target_db_table = 'business_picture';
								$arr['cover_picture'] = 'N';
								
					
								$this->business_model->set_data_insert($target_db_table, $arr);
								$this->session->set_userdata('user_values', '' );
							
									$message = 'Business Image uploaded successfully';
									$message_type = 'succ';
							
								unset($arr);
							}
							else
							{
								$err = explode('|', $img_details);
								$message = $err[0];
								$message_type = 'err';
							}
	
				}
			}
		}
		#======= if upload type is pic [END] =======================================================================
		#=============================================================================================================		
	}

	$this->session->set_userdata(array(
		'message' => $message,
		'message_type' => $message_type));

		
	header('Location:'.base_url().'profile/upload_business_image');
	exit();		
		
}
#=================================   Upload Pictures Section End  ==========================================================
#=================================================================================================================================
	/**
	 * @author Iman Biswas
	 * @author Anutosh Ghosh
	 */
    function save_review()
    {
		$this->check_user_page_access('registered');
		$this->upload_path = $this->config->item('upload_image_folder_review');
		$message = '';
		$imagename = '';
		$arr_post = array();
		$temp_arr = array_merge($arr_post, $_POST);

		$this->session->set_userdata('user_values', $temp_arr );
		$this->session->set_userdata('user_messages', array());
		if(trim($this->input->post('business_name')) == '')
			$message	= 'Please select a business';
		elseif(trim($this->input->post('business_id')) == '' || trim($this->input->post('business_id')) == 0)
			$message	= 'Please select a business';
		elseif(trim($this->input->post('review_title')) == '')
			$message	= 'Please give your review title';
		elseif(trim($this->input->post('star_rating')) == '' || $this->input->post('star_rating') < 1)
			$message	= 'Please give your star rating';
		elseif(trim($this->input->post('comment')) == '')
			$message	= 'Please give your comment';
		/*elseif($this->input->post('ck_tearms') == '' || $this->input->post('ck_tearms') != 'on')
			$message	= 'You have to accept terms and conditions';*/
		else
		{
			$business_id = $this->input->post('business_id');
			$this->load->model('business_model');
			$business_details = $this->business_model->get_business_list(array('id'=>$business_id), -1, 0);
			if(empty($business_details))
			{
				$message	= 'Please select a proper business';
			}
			else {
				$max_file_size = $this->site_settings_model->get_site_settings('max_image_file_size');
				if( isset($_FILES['img']['name']) && !empty($_FILES['img']['name']) )
				{
					$img_details = upload_file($this,
						array(
							'upload_path' => $this->upload_path,
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
		}

		if(empty($message))
		{
			$this->load->model('review_model');
			$arr = array(
				"review_title" => htmlspecialchars($this->input->post('review_title'), ENT_QUOTES, 'utf-8'),
				"comment" => htmlspecialchars($this->input->post('comment'), ENT_QUOTES, 'utf-8'),
				"star_rating" => htmlspecialchars($this->input->post('star_rating'), ENT_QUOTES, 'utf-8'),
				"business_id" => $this->input->post('business_id'),
				"img" => $imagename,
				"cr_date" => time(),
				"user_id" => $this->session->userdata('user_id'),
				"cr_by" => $this->session->userdata('user_id')
			);
			$this->review_model->set_data_insert('business_reviews', $arr);
			$this->review_model->set_business_review_update($business_id);
			
			$this->session->set_userdata('user_values', '' );
			$this->session->set_userdata(array(
				'message' => 'Business review inserted successfully',
				'message_type' => 'succ'
			));

			header('location:'.base_url().'profile');
			exit();
		}

		if(!empty($imagename))
		{
			@unlink($this->upload_path.$imagename);
			@unlink($this->upload_path.$this->config->item('image_folder_thumb').$imagename);
			@unlink($this->upload_path.$this->config->item('image_folder_view').$imagename);
		}
		
		$this->session->set_userdata(array(
			'message' => $message,
			'message_type' => 'err'
		));
		
		header('location:'.base_url().'profile/write_review');
		exit();
    }

    function get_business_ajax()
    {
        $id = $this->input->post('id');
        $this->load->model('profile_normal_model');
        $arr    = explode('-', $id);
        $htm    ='<select id="business_id" name="business_id">
                            <option value="">Select a business</option>'.
                            $this->profile_normal_model->get_business_list_option($arr[0],$arr[1]).
                        '</select>';
        echo $htm;
    }
    
    function get_business_type_ajax()
    {
        $id = $this->input->post('id');
        $this->load->model('category_model');
		
        $htm = '<select id="business_type_id" name="business_type_id" onchange="fun_business_id();">'."\n";
        $htm .= "\t".'<option value="">Select a business type</option>'."\n";
		$htm .= makeOption($this->category_model->get_cat_selectlist('', $id));
        $htm .= '</select>';
        
		echo $htm;
    }
    
    private function merchant_profile()
    {
		$this->load->model('article_model');
		$this->data['content_text']=$this->article_model->get_article_list(-1,0,-1,'',1,'marchant_user_page_text');

        $this->add_js(array('ajax_helper','common_js'));
        $this->set_include_files(array('profile/merchant_profile'));
        $this->render();
    }

    function business_list_ajax()
    {
        $this->load->model('business_model');
        $cur_user_id    = $this->session->userdata('user_id');
        $data = array();
        $business_page   = $this->input->post('business_page');
        $business_page   = ($business_page)?$business_page:0;
        $data['business_page']	= $business_page;
        $data['toshow'] = $this->admin_page_limit;
        $arr    = array('ext_cond'=>" AND (cr_by=$cur_user_id OR business_owner_id=$cur_user_id) ");
        $data['rows'] = $this->business_model->get_business_user_profile($data['toshow'],$business_page,$arr);
        $data['tot_data'] = $this->business_model->get_business_user_profile_count($arr);
        $data['cur_user_id'] = $cur_user_id;
        $this->session->set_userdata(array('redirect_url'=>base_url().'profile'));
        $data['jsnArr'] = json_encode(array('business_page'=>$business_page));
		$data['messageList'] = $this->business_model->business_status;
        $this->load->view('profile/business_list.tpl.php',$data);
    }

    function edit()
    {
        $this->load->model('business_profile_model');
		$this->check_user_page_access('registered');
        $this->data['title'] = 'Edit your profile';
        $this->load->model('users_model');
        $this->load->model('location_model');
        $this->load->model('occupation_model');
		$this->load->model('article_model');
        $this->load->library('generat_calender');
		$this->data['edit_user_text']=$this->article_model->get_article_list(-1,0,-1,'',1,'edit_user_profile');
		
        $cur_user_id    = $this->session->userdata('user_id');
		$this->data['user_id'] = $cur_user_id;
        $this->data['data'] = $this->session->userdata('user_values');
        if(!isset($this->data['data']) || count($this->data['data'])<1 || $this->data['data'].'a'=='a')
        {
            $tmp    = $this->users_model->get_user_list(1,0,array('id'=>$cur_user_id));
            $this->data['data'] = $tmp[0];
            $this->data['data']['dob'] = date('Y-m-d',$tmp[0]['dob']);
        }
		$this->data['dob']	= $this->generat_calender->calender('dob',$this->data['data']['dob']);
		
		$county_id = ($this->data['data']['country_id'])?$this->data['data']['country_id']:113;
        $this->data['country_option']    = $this->location_model->get_country_list_option($county_id);
        $this->data['state_option']    = $this->location_model->get_state_list_option($this->data['data']['state_id'],$this->data['data']['country_id']);
        if($this->data['data']['state_id']>0)
            $this->data['city_option']    = $this->location_model->get_city_list_option($this->data['data']['city_id'],$this->data['data']['state_id']);
        if($this->data['data']['city_id']>0)
            $this->data['zipcode_option']    = $this->location_model->get_zip_code_list_option($this->data['data']['zipcode'],$this->data['data']['city_id']);
        $this->data['occupation_option']    = $this->occupation_model->get_occupation_option($this->data['data']['occupation_id']);
		$this->add_js(array('ajax_helper','common_js','fromvalidation','ModalDialog','jasons_date_input_calendar/calendarDateInput','js_form'));
        $this->set_include_files(array('profile/edit'));
        $this->render();
    }

    function edit_profile_save()
    {
		$this->check_user_page_access('registered');
		$this->load->model('users_model');
		$this->upload_path = $this->config->item('upload_image_folder_user');
		$cur_user_id = $this->session->userdata('user_id');
		$message = '';
		$imagename = '';
		$arr_post = array();
		$temp_arr = array_merge($arr_post, $_POST);

		$this->session->set_userdata('user_values', $temp_arr );
		$this->session->set_userdata('user_messages', array());

		if(trim($this->input->post('f_name'))=='')
			$message    = 'Please give your first name';
		elseif(trim($this->input->post('l_name'))=='' )
			$message    = 'Please give your last name';
		elseif(trim($this->input->post('email'))=='' )
			$message    = 'Please give your email address';
		/*        elseif(trim($this->input->post('country_id'))=='')
			$message    = 'Please select your country';
		elseif(trim($this->input->post('state_id'))=='')
			$message    = 'Please select your state';
		elseif(trim($this->input->post('city_id'))=='')
			$message    = 'Please select your city';
		elseif(trim($this->input->post('zipcode'))=='')
			$message    = 'Please select your pincode';*/
		elseif(!preg_match("/^[_a-z0-9-\+]+(\.[_a-z0-9-\+]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $this->input->post('email')) )
			$message    = 'Please Proper email address';
		else
		{
			if(trim($this->input->post('o_password'))!='')
			{
				if(trim($this->input->post('password'))=='')
					$message    = 'Please give your new password';
				elseif(trim($this->input->post('c_password'))=='')
					$message    = 'Please confirm your password';
				elseif(trim($this->input->post('c_password'))!=trim($this->input->post('password')))
					$message    = 'Two password does not match';
				else
				{
					$data_arr   = $this->users_model->authenticate($this->session->userdata('user_email'), get_salted_password($this->input->post('o_password')));
					if($data_arr == FALSE)
						$message    = 'Please give proper old password';
				}
			}
			$email_exist = $this->users_model->get_user_list_count(array('email'=>$this->input->post('email'),'ext_cond'=>" AND id<>$cur_user_id "));
			if($email_exist && $email_exist>0 )
				$message    = 'Email adderss has been taken by anothe user';
			else
			{
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
			}
		}

		if(empty($message) )
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
						"date_updated"=>time()
				);
			if($imagename!='')
				$arr['img_name']    = $imagename;
			$this->users_model->set_data_update('users',$arr,$cur_user_id);
			if(trim($this->input->post('o_password'))!='')
			{
				$arr    = array("password"=>get_salted_password($this->input->post('password')));
				$this->users_model->set_data_update('users',$arr,$cur_user_id);
			}
			$this->session->set_userdata('user_values', '' );
			$this->session->set_userdata(array('message'=>'Profile updated successfully','message_type'=>'succ'));
			header('location:'.base_url().'profile');
			exit();
		}

		if(!empty($imagename))
		{
			@unlink($this->upload_path.$imagename);
			@unlink($this->upload_path.$this->config->item('image_folder_thumb').$imagename);
			@unlink($this->upload_path.$this->config->item('image_folder_view').$imagename);
		}

		$this->session->set_userdata(array('message'=>$message, 'message_type'=>'err'));
		header('location:'.base_url().'profile/edit');
		exit();
    }
	
	function user_uploaded_business()
	{
        $this->load->model('business_model');
        $cur_user_id    = $this->session->userdata('user_id');
        $data = array();
        $business_page   = $this->input->post('business_page');
        $business_page   = ($business_page)?$business_page:0;
        $data['business_page']	= $business_page;
        $data['toshow'] = $this->admin_page_limit;
        $arr    = array('ext_cond'=>" AND (cr_by=$cur_user_id OR business_owner_id=$cur_user_id) ");
        $data['rows'] = $this->business_model->get_business_user_profile($data['toshow'],$business_page,$arr);
        $data['tot_data'] = $this->business_model->get_business_user_profile_count($arr);
        $data['cur_user_id'] = $cur_user_id;
        $this->session->set_userdata(array('redirect_url'=>base_url().'profile'));
        $data['jsnArr'] = json_encode(array('business_page'=>$business_page));
		$data['messageList'] = $this->business_model->business_status;

        $this->load->view('profile/normal_user_uploaded_business_list.tpl.php', $data);
    		
	}
	
	/*
	 * Purnendu shaw 04.11.2010
	 * $coupon_id = the id of urban_request_for_coupon
	 */
	function delete_interest_shown($coupon_id)
	{
		$this->check_user_page_access('registered'); 
		$cur_user_id    = $this->session->userdata('user_id');
		$this->load->model('profile_normal_model');
		$message        = '';
		$msg_type          = 'err';

		if($coupon_id < 1  )
		{
			$message = "The coupon id is not valid.";
		}

		$coupon_details = $this->profile_normal_model->get_interested_business_details($coupon_id );
		if(empty($coupon_details))
		{
			$message = "No such row exists.";
		}

		$cr_by   = $coupon_details[0]['cr_by'];
		if($cur_user_id != $cr_by )
		{
			$message = "You are not allowed to delete this coupon interest for...";
		}

		if(empty($message))
		{
			$this->load->model('profile_normal_model');
			$this->profile_normal_model->delete_interest_for_coupon($coupon_id);
			$message = "Deleted successfully";
			$msg_type 		=	'succ';
		}

		$this->session->set_userdata(array(
			'message'=>$message,
			'message_type'=>$msg_type
		));
		header('location:'.base_url().'profile');
		exit();
	}

	/**
	 * Purnendu  05.11.2010
	 * This function is for delete profile picture   ( Edit/Update Profile LINK)
	 *
	 */
	function delete_user_image($target = 'pic')
	{
		$this->load->model('users_model');
		$this->check_user_page_access('registered');
		$cur_user_id    = $this->session->userdata('user_id');
		$id = $this->input->post('id');
		

		if(	$cur_user_id == $id )
		{
			$tmp    = $this->users_model->get_user_list(1,0,array('id'=>$cur_user_id));
			$this->data['data'] = $tmp[0];
			$image_name = $this->data['data']['img_name'];
			/*$image_path = $this->config->item('view_image_folder_user').$image_name;
			$image_path_thumb = $image_path.$this->config->item('image_folder_thumb').$image_name;
			$image_path_general = $image_path.$this->config->item('image_folder_view').$image_name;business_1288956742.jpg*/
			
			$image_path = BASEPATH.'../images/uploaded/user/'.$image_name;
			$image_path_thumb = BASEPATH.'../images/uploaded/user/thumb/'.$image_name;
			$image_path_general = BASEPATH.'../images/uploaded/user/general/'.$image_name;
			@unlink($image_path);
			@unlink($image_path_thumb);
			@unlink($image_path_general);
			$msg = $this->users_model->update_user_image('users', $cur_user_id);
			echo $msg; 
		}
		else
		{
			echo 'You are not allowed to delete the profile picture.';
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


}
