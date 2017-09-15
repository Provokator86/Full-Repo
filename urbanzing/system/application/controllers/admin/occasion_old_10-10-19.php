<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class Occasion extends MY_Controller
{
	public 	$dir_name = '';
	public  $dir_thumb_name = '';

    function __construct()
    {
		parent::__construct();
		$this->check_user_page_access('registered');
        $this->load->model('occasion_model');
		$this->dir_name = BASEPATH.'../images/uploaded/occasion/';
		$this->dir_thumb_name = BASEPATH.'../images/uploaded/occasion/thumb/';
		$this->menu_id  = 3;
	}

	function index($order_name='occasion',$order_type='asc',$page=0)
    {
        $sessArrTmp = array();
        $this->data['title'] = 'Occasion Page';
        if($this->input->post('go'))
        {
            $sessArrTmp['src_occasion_title']=$this->input->post('title');
            $sessArrTmp['src_occasion_status']=$this->input->post('status');
        }
        else
        {
            $sessArrTmp['src_occasion_title']=$this->get_session_data('src_occasion_title');
            $sessArrTmp['src_occasion_status']=$this->get_session_data('src_occasion_status');
        }

        $this->data['txtArray']   = array("title"=>"Title");
        $this->data['txtValue']   = array($sessArrTmp['src_occasion_title']);
        $this->data['optArray']   = array("status"=>"Status");
        $this->data['optValue']   = array(
            makeOption(array("1"=>"Enable","0"=>"Disable"),$sessArrTmp['src_occasion_status']),
            makeOption($this->occasion_model->occasion_category,$sessArrTmp['src_occasion_category'])
        );
		$arr = array('occasion'=>$sessArrTmp['src_occasion_title'],'status'=>$sessArrTmp['src_occasion_status']);
		
        $this->data['occasion']=$this->occasion_model->get_occasion_list($arr,$this->admin_page_limit,($page)?$page:0,$order_name,$order_type);
        $totRow = $this->occasion_model->get_occasion_list_count($arr);
        if(!$this->data['occasion'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/occasion/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/occasion/index/'.$order_name.'/'.$order_type,
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
        $sessArrTmp['redirect_url']=base_url().'admin/occasion/index/'.$order_name.'/'.$order_type.'/'.$page;
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','occasion/occasion_list'));
		$this->render();
	}

    function ajax_change_status()
    {
        $status   = $this->input->post('status');
        $id   = $this->input->post('id');
        if($this->occasion_model->change_data_status('occasion',$id,$status))
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
            echo "<a onclick='call_ajax_status_change(\"".base_url()."admin/occasion/ajax_change_status\",".$jsnArr.",\"status".$id."\");' style='cursor:pointer; ".$style."'> ".$txt."</a>";
        }
    }

    function delete_occasion($id)
    {
        if($this->occasion_model->delete_occasion($id))
            $this->session->set_userdata(array('message'=>'Occasion deleted successfully..','message_type'=>'err'));
        else
            $this->session->set_userdata(array('message'=>'Unable to delete occasion..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }

    function add_occasion()
    {
        $this->data['title'] = 'Add Occasion Page';
        $this->data['table_title'] = 'Add Occasion';

        $this->add_js(array('tinymce/jscripts/tiny_mce/tiny_mce','tinymce_load','fromvalidation'));
        $this->set_include_files(array('common/admin_menu','occasion/add_occasion'));
		$this->render();
    }

    function edit_occasion($id=-1)
    {
        if(!$id||!is_numeric($id)||$id==-1)
        {
            $this->session->set_userdata(array('message'=>'Data not found for this occasion..','message_type'=>'err'));
            header("Location: ".$this->get_redirect_url());
            exit(0);
        }
		$arr = array('id'=>$id);
        $this->data['occasion']=$this->occasion_model->get_occasion_list($arr,1,0);
        
        $this->data['title'] = 'Edit Occasion Page';
        $this->data['table_title'] = 'Edit Occasion';
        $this->data['redirect_url']=$this->get_redirect_url();
	
        $this->add_js(array('tinymce/jscripts/tiny_mce/tiny_mce','tinymce_load','fromvalidation','ajax_helper','common_js'));
        $this->add_js(array('ajax_helper','fromvalidation','common_js'));
        $this->set_include_files(array('common/admin_menu','occasion/edit_occasion'));
		$this->render();
    }

    function insert_occasion()
    {
        $arr= array("occasion"=>htmlspecialchars($this->input->post('occasion'), ENT_QUOTES, 'utf-8'),
					"status"=>$this->input->post('status'),
                    "cr_date"=>time(),
					"cr_by"=>$this->session->userdata('user_id')
        );
		$id = $this->occasion_model->set_data_insert('occasion',$arr);
        if($id)
		{
			$config['upload_path'] = $this->dir_name;
			$config['file_name'] = 'occ_'.time();
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '0';
			$config['max_width']  = '0';
			$config['max_height']  = '0';	
			$this->load->library('upload', $config);
		
			if ($this->upload->do_upload('img_name')){
				$img_details = $this->upload->data();
				$config['image_library'] = 'gd2';
				$config['source_image'] = $img_details['full_path'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['thumb_marker'] = '';
				$config['width'] = 150;
				$config['height'] = 100;
				$config['new_image'] = $this->dir_thumb_name.$img_details['orig_name'];
				$this->load->library('image_lib', $config);
				
				$this->image_lib->resize();	
				$arr= array(
					 "img_name"=>htmlspecialchars($img_details['orig_name'], ENT_QUOTES, 'utf-8')
					);
				$this->occasion_model->set_data_update('occasion',$arr,$id);	
					
			}				
			$this->session->set_userdata(array('message'=>'Occasion add successfully..','message_type'=>'succ'));
			
		}	
        else
            $this->session->set_userdata(array('message'=>'Unable to add occasion..','message_type'=>'err'));
        header('location:'.base_url().'admin/occasion');
        exit;
    }

    function update_occasion()
    {
		$id = $this->input->post('id');
        $arr= array("occasion"=>htmlspecialchars($this->input->post('occasion'), ENT_QUOTES, 'utf-8'),
					"status"=>$this->input->post('status'),
                    "update_date"=>time(),
					"update_by"=>$this->session->userdata('user_id')
        );

        if($this->occasion_model->set_data_update('occasion',$arr,$id))
		{
         	if( isset($_FILES['img_name']['name']) && $_FILES['img_name']['name']!='') {
			   $arr = array('id'=>$id);	
				
				$config['upload_path'] = $this->dir_name;
				$config['file_name'] = 'occ'.time();
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '0';
				$config['max_width']  = '0';
				$config['max_height']  = '0';	
				$this->load->library('upload', $config);
				
				if ($this->upload->do_upload('img_name')){
					$img_details = $this->upload->data();
					
					$config['image_library'] = 'gd2';
					$config['source_image'] = $img_details['full_path'];
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['thumb_marker'] = '';
					$config['width'] = 150;
					$config['height'] = 100;
					$config['new_image'] = $this->dir_thumb_name.$img_details['orig_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					
				    $occ_details = $this->occasion_model->get_occasion_list($arr,1,0);
				    $img_path = $this->dir_name.$occ_details[0]['img_name'];
				    $img_full_path = $this->dir_thumb_name.$occ_details[0]['img_name'];
			
				    @unlink($img_path);
				    @unlink($img_full_path);						
						
					$arr1= array("img_name"=>htmlspecialchars($img_details['orig_name'], ENT_QUOTES, 'utf-8'),
							);
							
					$this->occasion_model->set_data_update('occasion', $arr1, $id);		
					
				}	else {
					   $this->session->set_userdata(array('message'=>'Unable to upload file ..','message_type'=>'err'));
					   header('location:'.base_url().'admin/occasion');
					   exit;				
				
				}	
		 	}
		    $this->session->set_userdata(array('message'=>'Occasion update successfully..','message_type'=>'succ'));
		}	
        else
            $this->session->set_userdata(array('message'=>'Unable to update occasion..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }
    
	function delete_image()
	{
		$this->check_user_page_access('registered');
		$id= $this->input->post('id');
		$occasion_img_name=$this->occasion_model->get_occasion_list(1,0,$id);
	 	if($occasion_img_name && $occasion_img_name[0]['img'])
	 	{
	 		$img_name = $occasion_img_name[0]['img'];
			$job_id = $occasion_img_name[0]['id'];
			$img_path = $this->dir_name.$img_name;
			$img_thumb_path = $this->dir_thumb_name.$img_name;
			
			if(file_exists($img_path))
				unlink($img_path);
			if(file_exists($img_thumb_path))
				unlink($img_thumb_path);	

			if($this->occasion_model->delete_image($id)) 
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
