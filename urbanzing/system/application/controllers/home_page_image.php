<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class Home_page_image extends MY_Controller
{
	public 	$dir_name = '';
	public  $dir_thumb_name = '';
	public  $dir_view_name = '';

    function __construct()
    {
		parent::__construct();
		$this->check_user_page_access('registered');
        $this->load->model('business_model');
		$this->menu_id  = 1;
		
		$this->dir_name = $this->config->item('upload_image_folder_biz');
		$this->dir_thumb_name = $this->dir_name.$this->config->item('image_folder_thumb');
		$this->dir_view_name = $this->dir_name.$this->config->item('image_folder_view');
	}

	function index($order_name='cr_date',$order_type='asc',$page=0)
    {
        $sessArrTmp = array();
        $this->data['title'] = 'Home page image Page';
        if($this->input->post('go'))
        {
           // $sessArrTmp['src_home_page_image_title']=$this->input->post('title');
            $sessArrTmp['src_home_page_image_status']=$this->input->post('status');
        }
        else
        {
           // $sessArrTmp['src_home_page_image_title']=$this->get_session_data('src_home_page_image_title');
            $sessArrTmp['src_home_page_image_status']=$this->get_session_data('src_home_page_image_status');
        }

        //$this->data['txtArray']   = array("title"=>"Title");
        //$this->data['txtValue']   = array($sessArrTmp['src_home_page_image_title']);
        $this->data['optArray']   = array("status"=>"Status");
        $this->data['optValue']   = array(
            makeOption(array("1"=>"Enable","0"=>"Disable"),$sessArrTmp['src_home_page_image_status']),
            makeOption($this->business_model->home_page_image_category,$sessArrTmp['src_home_page_image_category'])
        );
		$arr = array('home_page_image'=>$sessArrTmp['src_home_page_image_title'],'status'=>$sessArrTmp['src_home_page_image_status']);
		
        $this->data['home_page_image']=$this->business_model->get_home_page_image_list($arr,$this->admin_page_limit,($page)?$page:0,$order_name,$order_type);
		//var_dump($this->data['home_page_image']);
        $totRow = $this->business_model->get_home_page_image_list_count($arr);
        if(!$this->data['home_page_image'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/home_page_image/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/home_page_image/index/'.$order_name.'/'.$order_type,
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
        $sessArrTmp['redirect_url']=base_url().'admin/home_page_image/index/'.$order_name.'/'.$order_type.'/'.$page;
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','home_page_image/home_page_image_list'));
		$this->render();
	}

    function ajax_change_status()
    {
        $status   = $this->input->post('status');
        $id   = $this->input->post('id');
        if($this->business_model->change_data_status('home_page_image',$id,$status))
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
            echo "<a onclick='call_ajax_status_change(\"".base_url()."admin/home_page_image/ajax_change_status\",".$jsnArr.",\"status".$id."\");' style='cursor:pointer; ".$style."'> ".$txt."</a>";
        }
    }

    function delete_home_page_image($id)
    {
        if($id)
		{
			$arr = array('id'=>$id);
			$home_details = $this->business_model->get_home_page_image_list($arr, 1, 0);

			$img_path = $this->dir_name.$home_details[0]['img_name'];
			$img_thumb_path = $this->dir_thumb_name.$home_details[0]['img_name'];
			$img_view_path = $this->dir_view_name.$home_details[0]['img_name'];

			@unlink($img_path);
			@unlink($img_thumb_path);
			@unlink($img_view_path);
			
			$this->business_model->set_data_delete('urban_home_page_image', $id);
		    $this->session->set_userdata(array('message' => 'Home page image deleted successfully.',
				'message_type' => 'err'
			));
		}	
        else
            $this->session->set_userdata(array('message'=>'Unable to delete home_page_image..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }

    function add_home_page_image()
    {
        $this->data['title'] = 'Add Home page image Page';
        $this->data['table_title'] = 'Add Home page image';
	$this->load->model('location_model');
	$this->data['region'] = $this->location_model->get_region_list_option();

        $this->add_js(array('fromvalidation'));
        $this->set_include_files(array('common/admin_menu','home_page_image/add_home_page_image'));
	$this->render();
    }

    function edit_home_page_image($id=-1)
    {
        if(!$id||!is_numeric($id)||$id==-1)
        {
            $this->session->set_userdata(array('message'=>'Data not found for this home_page_image..','message_type'=>'err'));
            header("Location: ".$this->get_redirect_url());
            exit(0);
        }
		$arr = array('id'=>$id);
        $this->data['home_page_image']=$this->business_model->get_home_page_image_list($arr,1,0);
	//	var_dump($this->data['home_page_image']);
		$this->load->model('location_model');
		//echo $this->data['home_page_image'][0]['region'][0]['region'];
		$this->data['region'] = $this->location_model->get_region_list_option($this->data['home_page_image'][0]['region'][0]['id']);

        
        $this->data['title'] = 'Edit Home page image Page';
        $this->data['table_title'] = 'Edit Home page image';
        $this->data['redirect_url']=$this->get_redirect_url();
	
        $this->add_js(array('fromvalidation','ajax_helper','common_js'));
        $this->add_js(array('ajax_helper','fromvalidation','common_js'));
        $this->set_include_files(array('common/admin_menu','home_page_image/edit_home_page_image'));
		$this->render();
    }

    function insert_home_page_image()
    {
		$max_file_size = $this->site_settings_model->get_site_settings('max_image_file_size');
		if( isset($_FILES['img_name']['name']) && !empty($_FILES['img_name']['name']) )
		{
			$img_details = upload_file($this,
				array('upload_path' => $this->dir_name,
					'file_name' => 'home_'.time(),
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
				$config['width'] = 213;
				$config['height'] = 168;
				$config['new_image'] = $this->dir_thumb_name.$imagename;
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
				$showable_image['new_image'] = $this->dir_view_name.$imagename;
				$this->image_lib->initialize($showable_image);
				$this->image_lib->resize();
				$this->image_lib->clear();

				$arr= array(
					"img_name" => htmlspecialchars($img_details['orig_name'], ENT_QUOTES, 'utf-8'),
					"description" => htmlspecialchars($this->input->post('description'), ENT_QUOTES, 'utf-8'),
					"status" => htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
					"region_id" => htmlspecialchars($this->input->post('region_id'), ENT_QUOTES, 'utf-8'),
					"cr_date" => time(),
					"cr_by" => $this->session->userdata('user_id')
				);
				$this->business_model->set_data_insert('home_page_image', $arr);
			}
			else
			{
				$err = explode('|', $img_details);
				$message = $err[0];
			}
		}
		else {
			$this->session->set_userdata(array('message'=>'Unable to add home page image.','message_type'=>'err'));
		}
		
		header('location:'.base_url().'admin/home_page_image');
		exit;
    }

    function update_home_page_image()
    {
		$id = $this->input->post('id');
        $arr = array(
			"description"=>htmlspecialchars($this->input->post('description'), ENT_QUOTES, 'utf-8'),
			"status"=>$this->input->post('status'),
			"region_id"=>htmlspecialchars($this->input->post('region_id'), ENT_QUOTES, 'utf-8'),
			"update_date"=>time(),
			"update_by"=>$this->session->userdata('user_id')
        );

        if($this->business_model->set_data_update('home_page_image', $arr, $id))
		{
			if( isset($_FILES['img_name']['name']) && !empty($_FILES['img_name']['name']))
			{
				$arr = array('id'=>$id);

				$img_details = upload_file($this,
					array('upload_path' => $this->dir_name,
						'file_name' => 'home_'.time(),
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
					$config['width'] = 213;
					$config['height'] = 168;
					$config['new_image'] = $this->dir_thumb_name.$imagename;
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
					$showable_image['new_image'] = $this->dir_view_name.$imagename;
					$this->image_lib->initialize($showable_image);
					$this->image_lib->resize();
					$this->image_lib->clear();

					$home_details = $this->business_model->get_home_page_image_list($arr, 1, 0);
					$img_path = $this->dir_name.$home_details[0]['img_name'];
					$img_thumb_path = $this->dir_thumb_name.$home_details[0]['img_name'];
					$img_view_path = $this->dir_view_name.$home_details[0]['img_name'];

					@unlink($img_path);
					@unlink($img_thumb_path);
					@unlink($img_view_path);

					$arr1 = array(
						"img_name" => $imagename
					);
					$this->business_model->set_data_update('home_page_image', $arr1, $id);
				}
				else
				{
					$err = explode('|', $img_details);
					$message = $err[0];

					header('location:'.base_url().'admin/home_page_image');
					exit;
				}
			}

		    $this->session->set_userdata(array(
				'message' => 'Home page image updated successfully.',
				'message_type'=>'succ'
			));
		}
        else {
			$this->session->set_userdata(array(
				'message' => 'Unable to update home page image.',
				'message_type' => 'err'
			));
		}
		
        header('location:'.$this->get_redirect_url());
        exit;
    }
    
	function delete_image()
	{
		$this->check_user_page_access('registered');
		$id = $this->input->post('id');
		$home_page_image_img_name = $this->business_model->get_home_page_image_list(1, 0, $id);
		
	 	if($home_page_image_img_name && $home_page_image_img_name[0]['img'])
	 	{
	 		$img_name = $home_page_image_img_name[0]['img'];
			$job_id = $home_page_image_img_name[0]['id'];
			$img_path = $this->dir_name.$img_name;
			$img_thumb_path = $this->dir_thumb_name.$img_name;
			$img_view_path = $this->dir_view_name.$img_name;
			
			if(file_exists($img_path))
				unlink($img_path);
			if(file_exists($img_thumb_path))
				unlink($img_thumb_path);
			if(file_exists($img_view_path))
				unlink($img_view_path);

			if($this->business_model->delete_image($id)) 
			{
				echo 'Image deleted successfully<br/>|';
			}	
			else
				echo 'Not deleted successfully<br/>|0';
		 } 
		 else 
			echo 'Not deleted successfullyaaa<br/>|0';
	}
}
