<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class Deals extends MY_Controller
{
    public 	$dir_name = '';
    public  $dir_thumb_name = '';
    function __construct()
    {
		parent::__construct();
		$this->check_user_page_access('registered');
        $this->load->model('deals_model');
        $this->dir_name = BASEPATH.'../images/uploaded/deals/';
		$this->dir_thumb_name = BASEPATH.'../images/uploaded/deals/thumb/';
		$this->menu_id  = 5;
	}

    /***
    * function to show deal listing page...
    */
	function index($order_name='headline',$order_type='asc',$page=0)
    {
        $sessArrTmp = array();
        $this->data['title'] = 'Deal Page';
        if($this->input->post('go'))
        {
            $sessArrTmp['src_deal_headline']= trim(htmlentities($this->input->post('headline'),ENT_QUOTES, 'utf-8'));
            $sessArrTmp['src_deal_status']=$this->input->post('status');
            $sessArrTmp['src_deal_category']=$this->input->post('category_id');
			$page=0;
        }
        else
        {
            $sessArrTmp['src_deal_headline']=$this->get_session_data('src_deal_headline');
            $sessArrTmp['src_deal_status']=$this->get_session_data('src_deal_status');
            $sessArrTmp['src_deal_category']=$this->get_session_data('src_deal_category');
        }

        $this->data['txtArray']   = array("headline"=>"Headline");
        $this->data['txtValue']   = array($sessArrTmp['src_deal_headline']);
        $this->data['optArray']   = array("status"=>"Status",'category_id'=>'Category');
        $this->data['optValue']   = array(
            makeOption(array("1"=>"Enable","0"=>"Disable"),$sessArrTmp['src_deal_status']),
            $this->deals_model->get_deals_category_option($sessArrTmp['src_deal_category'])
        );

        $this->data['deals']=$this->deals_model->get_deals_list($this->admin_page_limit,($page)?$page:0,-1,$sessArrTmp['src_deal_headline'],$sessArrTmp['src_deal_status'],$sessArrTmp['src_deal_category'],$order_name,$order_type);
        $totRow = $this->deals_model->get_deals_list_count(-1,$sessArrTmp['src_deal_headline'],$sessArrTmp['src_deal_status'],$sessArrTmp['src_deal_category']);
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        if(!$this->data['deals'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/deals/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/deals/index/'.$order_name.'/'.$order_type,
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
        $this->data['deals_category_name'] = $this->deals_model->get_deals_category_name();
        /*echo "<pre>";
        print_r($this->data['deals_category_name']);
        echo "</pre>";
        exit(); */
        $sessArrTmp['redirect_url']=base_url().'admin/deals/index/'.$order_name.'/'.$order_type.'/'.$page;
        //$this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','deals/deals_list'));
		$this->render();
	}

    /***
    * function to show deal add page...
    */
    function add_deals()
    {
        $this->data['title'] = 'Add Deals Page';
        $this->data['table_title'] = 'Add Deals';

        // loading model and libraries...[start]
        $this->load->model('location_model');
        $this->load->model('date_time_model');
        $this->load->library('generat_calender');
        // loading model and libraries...[end]
        
        $this->data['country_option']    = $this->location_model->get_country_list_option($this->data['data']['country_id']);
        $this->data['category_option']    = $this->deals_model->get_deals_category_option();
        
        $this->data['start_date']    = $this->generat_calender->calender('start_date');
        $this->data['end_date']    = $this->generat_calender->calender('end_date');
        $this->data['hour_option']    = $this->date_time_model->generate_hour_option();
        $this->data['min_option']    = $this->date_time_model->generate_min_option();
        
        // loading js and view files...[start]
        $this->add_js(array('ajax_helper', 'tinymce/jscripts/tiny_mce/tiny_mce','tinymce_load','fromvalidation', 'jasons_date_input_calendar/calendarDateInput'));
        $this->set_include_files(array('common/admin_menu','deals/add_deals'));
		$this->render();
        // loading js and view files...[end]
    }

    /**
    * function to insert deals into database...
    */
    function insert_deals()
    {
        /*
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit(); */ 
        /**
        * headline] => 
    [country_id] => 1
    [state_id] => 
    [city_id] => 
    [zipcode] => 
    [phone_no] => 
    [website_url] => 
    [source_name] => 
    [category_id] => 
    [description] => 
    [start_date] => 2011-04-30
    [start_hour] => 00
    [start_min] => 00
    [end_date] => 2011-04-30
    [end_hour] => 00
    [end_min] => 00
    [purchase_link] => 
    [actual_price] => 
    [offer_price] 
        * 
        */
        /*
        not needed now...
        $imgPath	= '';
    	if( isset($_FILES['img']['name']) && $_FILES['img']['name']!='') 
		{
			$max_file_size    =$this->site_settings_model->get_site_settings('max_image_file_size');
			$img_details = upload_file($this,
							array('upload_path' => $this->dir_name,
								  'file_name'	=> 'article'.time(),
								  'allowed_types' => $this->config->item('image_support_extensions'),
								  'max_size' => '0',
								  'max_width' => '0',
								  'max_height' => '0',
								  ), 'img'
							);
			if(is_array($img_details))
			{	
				$config['image_library'] = 'gd2';
				$config['source_image'] = $img_details['full_path'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['thumb_marker'] = '';
				$config['width'] = 86;
				$config['height'] = 100;
				$config['new_image'] = $this->dir_thumb_name.$img_details['orig_name'];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();	
				$imgPath	= $img_details['orig_name'];
			}  
			else
			{
				$err=explode('|',$img_details);
	   			$this->session->set_userdata(array('message'=>$err[0],'message_type'=>'err'));
				header('location:'.base_url().'admin/article/add_article');
				exit;
			} 
		}
        */
        
        $start_date = strtotime($this->input->post('start_date') . ' ' . $this->input->post('start_hour') . ':' . $this->input->post('start_min'));
        $end_date = strtotime($this->input->post('end_date') . ' ' . $this->input->post('end_hour') . ':' . $this->input->post('end_min'));
        /* previous array....
        $arr= array(        "country_id"=>intval($this->input->post('country_id')),
                            "state_id"=>intval($this->input->post('state_id')),
                            "headline"=>htmlspecialchars($this->input->post('headline'), ENT_QUOTES, 'utf-8'),
                            "street_address"=>htmlspecialchars($this->input->post('street'), ENT_QUOTES, 'utf-8'),
                            "city_id"=>intval($this->input->post('city_id')),
                            "category_id"=>intval($this->input->post('category_id')),
                            "pin"=>htmlspecialchars($this->input->post('zipcode'), ENT_QUOTES, 'utf-8'),
                            "phone"=>htmlspecialchars($this->input->post('phone_no'), ENT_QUOTES, 'utf-8'),
                            "website_url"=>htmlspecialchars($this->input->post('website_url'), ENT_QUOTES, 'utf-8'),
                            "source_name"=>htmlspecialchars($this->input->post('source_name'), ENT_QUOTES, 'utf-8'),
                            "deal_description"=>htmlspecialchars($this->input->post('description'), ENT_QUOTES, 'utf-8'),
                            "external_site_link"=>htmlspecialchars($this->input->post('purchase_link'), ENT_QUOTES, 'utf-8'),
                            "actual_price"=>floatval($this->input->post('actual_price')),
                            "offer_price"=>floatval($this->input->post('offer_price')),
                            "deal_start"=>$start_date,
                            "deal_end"=>$end_date,
        					// "img"=>$imgPath,
                            "status"=>intval($this->input->post('status')),
                            "creation_dt"=>time()
        );
        */
        $arr= array(        "country_id"=>intval($this->input->post('country_id')),
                            "state_id"=>intval($this->input->post('state_id')),
                            "headline"=>htmlspecialchars($this->input->post('headline'), ENT_QUOTES, 'utf-8'),
                            "street_address"=>htmlspecialchars($this->input->post('street'), ENT_QUOTES, 'utf-8'),
                            "city_id"=>intval($this->input->post('city_id')),
                            "category_id"=>intval($this->input->post('category_id')),
                            "pin"=>htmlspecialchars($this->input->post('zipcode'), ENT_QUOTES, 'utf-8'),
                            "phone"=>htmlspecialchars($this->input->post('phone_no'), ENT_QUOTES, 'utf-8'),
                            "website_url"=>htmlspecialchars($this->input->post('website_url'), ENT_QUOTES, 'utf-8'),
                            "big_image_url"=>htmlspecialchars($this->input->post('big_image_url'), ENT_QUOTES, 'utf-8'),
                            "small_image_url"=>htmlspecialchars($this->input->post('small_image_url'), ENT_QUOTES, 'utf-8'),
                            "source_name"=>htmlspecialchars($this->input->post('source_name'), ENT_QUOTES, 'utf-8'),
                            "deal_description"=>htmlspecialchars($this->input->post('description'), ENT_QUOTES, 'utf-8'),
                            "fine_prints"=>htmlspecialchars($this->input->post('fine_prints'), ENT_QUOTES, 'utf-8'),
                            "external_site_link"=>htmlspecialchars($this->input->post('purchase_link'), ENT_QUOTES, 'utf-8'),
                            "actual_price"=>floatval($this->input->post('actual_price')),
                            "offer_price"=>floatval($this->input->post('offer_price')),
                            "deal_start"=>$start_date,
                            "deal_end"=>$end_date,
                            "status"=>intval($this->input->post('status')),
                            "type"=>intval($this->input->post('type')),
                            "creation_dt"=>time()
        );
        
        if($this->deals_model->set_deals_insert($arr))
            $this->session->set_userdata(array('message'=>'Deal added successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to add deal..','message_type'=>'err'));
            
        redirect('admin/deals/');
    }
    

    /**
    * function to change the status of a deal by AJAX calling
    */
    function ajax_change_status()
    {
        $status   = $this->input->post('status');
        $id   = $this->input->post('id');
        if($this->deals_model->change_deals_status($id,$status))
        {
            $txt     = " Disable";
            $style='';
            $status=1-$status;
            if($status==1)
            {
                $style  = "color:green;";
                $txt     = " Enable";
            }
            $jsnArr = json_encode(array('id'=>$id,'status'=>$status));
            echo "<a onclick='call_ajax_status_change(\"".base_url()."admin/deals/ajax_change_status\",".$jsnArr.",\"status".$id."\");' style='cursor:pointer; ".$style."'> ".$txt."</a>";
        }
    }

    /**
    * function to delete deals by its id
    * 
    * @param mixed $id
    */
    function delete_deals($id)
    {
        if($this->deals_model->delete_deals($id))
            $this->session->set_userdata(array('message'=>'Deal deleted successfully..','message_type'=>'err'));
        else
            $this->session->set_userdata(array('message'=>'Unable to delete deal..','message_type'=>'err'));
        redirect($this->get_redirect_url());
    }
    
    
    function edit_deals($id=-1)
    {
        
        if(!$id||!is_numeric($id)||$id==-1 || !$this->deals_model->is_valid_deals($id))
        {
            $this->session->set_userdata(array('message'=>'Data not found for this deal..','message_type'=>'err'));
            redirect($this->get_redirect_url());
        }

        $this->data['deals']=$this->deals_model->get_deals_list(1,0,$id);
        /* echo "<pre>";
        print_r($this->data['deals']);
        echo "</pre>";
        exit();*/
        $this->data['deals_category_option'] = $this->deals_model->get_deals_category_option($this->data['deals'][0]['category_id']);
        
        $this->load->model('location_model');
        $this->load->model('date_time_model');
        $this->load->library('generat_calender');
        
        $this->data['country_option']    = $this->location_model->get_country_list_option($this->data['deals'][0]['country_id']);
        $this->data['state_option']    = $this->location_model->get_state_list_option($this->data['deals'][0]['state_id'], $this->data['deals'][0]['country_id']);
        $this->data['city_option']    = $this->location_model->get_city_list_option($this->data['deals'][0]['city_id'], $this->data['deals'][0]['state_id']);
        $this->data['zipcode_option']    = $this->location_model->get_zip_code_list_option($this->data['deals'][0]['pin'], $this->data['deals'][0]['city_id']);
        
        
        $this->data['category_option']    = $this->deals_model->get_deals_category_option($this->data['deals'][0]['category_id']);
        
        /*
        not needed now...
         $img_path=$img_path = $this->dir_thumb_name.$this->data['article'][0]['img'];
        // $this->data['img_thumb_path']='';
        if(file_exists($img_path) && $this->data['article'][0]['img'])
            $this->data['img_thumb_path'] = base_url().'images/uploaded/article/thumb/'.$this->data['article'][0]['img'];
        */
        
        $this->data['title'] = 'Edit Deals Page';
        $this->data['table_title'] = 'Edit Deals';
        $this->data['redirect_url'] = $this->get_redirect_url();
        
        /// Deal start time setting....[start]
        $temp_deal_start_part = (isset($this->data['deals'][0]['deal_start'])) ?date('Y-m-d', $this->data['deals'][0]['deal_start']): '';
        
        $this->data['start_date'] = $this->generat_calender->calender('start_date', $temp_deal_start_part);

        $temp_deal_start_hour_part = (isset($this->data['deals'][0]['deal_start'])) ? date('H', $this->data['deals'][0]['deal_start']):'';
        $this->data['start_hour_option'] = $this->date_time_model->generate_hour_option($temp_deal_start_hour_part);

        $temp_deal_start_min_part = (isset($this->data['deals'][0]['deal_start'])) ? date('i', $this->data['deals'][0]['deal_start']):'';
        $this->data['start_min_option'] = $this->date_time_model->generate_min_option($temp_deal_start_min_part);
        /// Deal start time setting....[end]
        
        /// Deal end time setting....[start]
        $temp_deal_end_part = (isset($this->data['deals'][0]['deal_end'])) ?date('Y-m-d', $this->data['deals'][0]['deal_end']):'';
        
        $this->data['end_date'] = $this->generat_calender->calender('end_date', $temp_deal_end_part);

        $temp_deal_end_hour_part = (isset($this->data['deals'][0]['deal_end'])) ? date('H', $this->data['deals'][0]['deal_end']):'';
        $this->data['end_hour_option'] = $this->date_time_model->generate_hour_option($temp_deal_end_hour_part);

        $temp_deal_end_min_part = (isset($this->data['deals'][0]['deal_end'])) ? date('i', $this->data['deals'][0]['deal_end']):'';
        $this->data['end_min_option'] = $this->date_time_model->generate_min_option($temp_deal_end_min_part);
        /// Deal end time setting....[end]

    
        $this->add_js(array('tinymce/jscripts/tiny_mce/tiny_mce','jasons_date_input_calendar/calendarDateInput', 'tinymce_load','fromvalidation','ajax_helper','common_js'));

        $this->set_include_files(array('common/admin_menu','deals/edit_deals'));
        $this->render();
    }
    
    
    function update_deals()
    {
        /*$arr= array("category_id"=>htmlspecialchars($this->input->post('category_id'), ENT_QUOTES, 'utf-8'),
                            "title"=>htmlspecialchars($this->input->post('title'), ENT_QUOTES, 'utf-8'),
                            "description"=>htmlspecialchars($this->input->post('description'), ENT_QUOTES, 'utf-8')
        );
    	if($this->input->post('change_image') == 1) 
    	{
    		if( isset($_FILES['img']['name']) && $_FILES['img']['name']!='') 
    		{
	    		$max_file_size    =$this->site_settings_model->get_site_settings('max_image_file_size');
				$img_details = upload_file($this,
								array('upload_path' => $this->dir_name,
									  'file_name'	=> 'article'.time(),
									  'allowed_types' => $this->config->item('image_support_extensions'),
									  'max_size' => '0',
									  'max_width' => '0',
									  'max_height' => '0',
									  ), 'img'
								);
				if(is_array($img_details))
				{
					$create_thumb = create_thumb($this, 
										array('image_library'=> 'gd2',
										  'source_image' => $img_details['full_path'],
										  'create_thumb' => TRUE,
										  'maintain_ratio' => TRUE,
										  'thumb_marker' => '',
										  'width' => 86,
										  'height' => 100,
										  'new_image'=> $this->dir_thumb_name.$img_details['orig_name']	
										  ) 
									);
					if($create_thumb) 
					{
					   	$article = $this->deals_model->get_article_list(1,0,$this->input->post('id'));
					   	if($article[0]['img'])
					   	{
						   	$img_path = $this->dir_name.$article[0]['img'];
						   	$img_full_path = $this->dir_thumb_name.$article[0]['img'];
						   	if(file_exists($img_path))
								unlink($img_path);
						   	if(file_exists($img_full_path))
								unlink($img_full_path);	
					   	}					
						$this->deals_model->set_article_update(array("img"=>$img_details['orig_name']),$this->input->post('id'));
					}	
				}
				else
				{
					$err=explode('|',$img_details);
		   			$this->session->set_userdata(array('message'=>$err[0],'message_type'=>'err'));
					header('location:'.base_url().'admin/article/edit_article/'.$this->input->post('id'));
					exit;
				} 
    		}
		}
        */
        $start_date = strtotime($this->input->post('start_date') . ' ' . $this->input->post('start_hour') . ':' . $this->input->post('start_min'));
        $end_date = strtotime($this->input->post('end_date') . ' ' . $this->input->post('end_hour') . ':' . $this->input->post('end_min'));
        
        $arr= array(        "country_id"=>intval($this->input->post('country_id')),
                            "state_id"=>intval($this->input->post('state_id')),
                            "headline"=>htmlspecialchars($this->input->post('headline'), ENT_QUOTES, 'utf-8'),
                            "street_address"=>htmlspecialchars($this->input->post('street'), ENT_QUOTES, 'utf-8'),
                            "city_id"=>intval($this->input->post('city_id')),
                            "category_id"=>intval($this->input->post('category_id')),
                            "pin"=>htmlspecialchars($this->input->post('zipcode'), ENT_QUOTES, 'utf-8'),
                            "phone"=>htmlspecialchars($this->input->post('phone_no'), ENT_QUOTES, 'utf-8'),
                            "website_url"=>htmlspecialchars($this->input->post('website_url'), ENT_QUOTES, 'utf-8'),
                            "big_image_url"=>htmlspecialchars($this->input->post('big_image_url'), ENT_QUOTES, 'utf-8'),
                            "small_image_url"=>htmlspecialchars($this->input->post('small_image_url'), ENT_QUOTES, 'utf-8'),
                            "source_name"=>htmlspecialchars($this->input->post('source_name'), ENT_QUOTES, 'utf-8'),
                            "deal_description"=>htmlspecialchars($this->input->post('description'), ENT_QUOTES, 'utf-8'),
                            "fine_prints"=>htmlspecialchars($this->input->post('fine_prints'), ENT_QUOTES, 'utf-8'),
                            "external_site_link"=>htmlspecialchars($this->input->post('purchase_link'), ENT_QUOTES, 'utf-8'),
                            "actual_price"=>floatval($this->input->post('actual_price')),
                            "offer_price"=>floatval($this->input->post('offer_price')),
                            "deal_start"=>$start_date,
                            "deal_end"=>$end_date,
                            "status"=>intval($this->input->post('status')),
                            "type"=>intval($this->input->post('type')),
                            "creation_dt"=>time()
        );
        
        if($this->deals_model->set_deals_update($arr,$this->input->post('id')))
            $this->session->set_userdata(array('message'=>'Deal updated successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to update deal..','message_type'=>'err'));
       redirect($this->get_redirect_url());
    }
    
    
	function delete_image()
	{
		$this->check_user_page_access('registered');
		$id= $this->input->post('id');
		$article_img_name=$this->deals_model->get_article_list(1,0,$id);
	 	if($article_img_name && $article_img_name[0]['img'])
	 	{
	 		$img_name = $article_img_name[0]['img'];
			$job_id = $article_img_name[0]['id'];
			$img_path = $this->dir_name.$img_name;
			$img_thumb_path = $this->dir_thumb_name.$img_name;
			
			if(file_exists($img_path))
				unlink($img_path);
			if(file_exists($img_thumb_path))
				unlink($img_thumb_path);	

			if($this->deals_model->delete_image($id)) 
			{
				echo 'Image deleted successfully<br>|';
			}	
			else
				echo 'Not deleted successfully<br>|0';					 
		 } 
		 else 
			echo 'Not deleted successfullyaaa<br>|0';	 	
		 
	}
}
