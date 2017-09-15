<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class User_type extends MY_Controller
{
    function __construct()
    {
		parent::__construct();
		$this->check_user_page_access('registered');
        $this->load->model('user_type_model');
		$this->menu_id  = 3;
	}

	function index($order_name='user_type',$order_type='asc',$page=0)
    {
        $sessArrTmp = array();
        $this->data['title'] = 'User Type Page';
        if($this->input->post('go'))
        {
            $sessArrTmp['src_user_type_title']=trim(htmlentities($this->input->post('title'),ENT_QUOTES, 'utf-8'));
            $sessArrTmp['src_user_type_status']=$this->input->post('status');
			$page = 0;
        }
        else
        {
            $sessArrTmp['src_user_type_title']=$this->get_session_data('src_user_type_title');
            $sessArrTmp['src_user_type_status']=$this->get_session_data('src_user_type_status');
        }

        $this->data['txtArray']   = array("title"=>"Title");
        $this->data['txtValue']   = array($sessArrTmp['src_user_type_title']);

		$arr = array('user_type'=>$sessArrTmp['src_user_type_title'],'status'=>$sessArrTmp['src_user_type_status']);
        $this->data['user_type']=$this->user_type_model->get_user_type_list($arr,$this->admin_page_limit,($page)?$page:0,$order_name,$order_type);
        $totRow = $this->user_type_model->get_user_type_list_count($arr);
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        if(!$this->data['user_type'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/user_type/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/user_type/index/'.$order_name.'/'.$order_type,
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
        $sessArrTmp['redirect_url']=base_url().'admin/user_type/index/'.$order_name.'/'.$order_type.'/'.$page;
        //$this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','user_type/user_type_list'));
		$this->render();
	}

    function ajax_change_status()
    {
        $status   = $this->input->post('status');
        $id   = $this->input->post('id');
        if($this->user_type_model->change_data_status('user_type',$id,$status))
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
            echo "<a onclick='call_ajax_status_change(\"".base_url()."admin/user_type/ajax_change_status\",".$jsnArr.",\"status".$id."\");' style='cursor:pointer; ".$style."'> ".$txt."</a>";
        }
    }

    function delete_user_type($id)
    {
        if($this->user_type_model->delete_user_type($id))
            $this->session->set_userdata(array('message'=>'User Type deleted successfully..','message_type'=>'err'));
        else
            $this->session->set_userdata(array('message'=>'Unable to delete user_type..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }

    function add_user_type()
    {
        $this->data['title'] = 'Add User Type Page';
        $this->data['table_title'] = 'Add User Type';

        $this->add_js(array('fromvalidation'));
        $this->set_include_files(array('common/admin_menu','user_type/add_user_type'));
		$this->render();
    }

    function edit_user_type($id=-1)
    {
        if(!$id||!is_numeric($id)||$id==-1)
        {
            $this->session->set_userdata(array('message'=>'Data not found for this user_type..','message_type'=>'err'));
            header("Location: ".$this->get_redirect_url());
            exit(0);
        }
		$arr = array('id'=>$id);
        $this->data['user_type']=$this->user_type_model->get_user_type_list($arr,1,0);
        
        $this->data['title'] = 'Edit User Type Page';
        $this->data['table_title'] = 'Edit User Type';
        $this->data['redirect_url']=$this->get_redirect_url();
	
        $this->add_js(array('tinymce/jscripts/tiny_mce/tiny_mce','tinymce_load','fromvalidation','ajax_helper','common_js'));
        $this->add_js(array('ajax_helper','fromvalidation','common_js'));
        $this->set_include_files(array('common/admin_menu','user_type/edit_user_type'));
		$this->render();
    }

    function insert_user_type()
    {
        $arr= array("user_type"=>htmlspecialchars($this->input->post('user_type'), ENT_QUOTES, 'utf-8'),
                    "cr_date"=>time(),
					"cr_by"=>$this->session->userdata('user_id')
        );
        if($this->user_type_model->set_data_insert('user_type',$arr))
            $this->session->set_userdata(array('message'=>'User Type add successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to add user type..','message_type'=>'err'));
        header('location:'.base_url().'admin/user_type');
        exit;
    }

    function update_user_type()
    {
        $arr= array("user_type"=>htmlspecialchars($this->input->post('user_type'), ENT_QUOTES, 'utf-8'),
                    "update_date"=>time(),
					"update_by"=>$this->session->userdata('user_id')
        );

        if($this->user_type_model->set_data_update('user_type',$arr,$this->input->post('id')))
            $this->session->set_userdata(array('message'=>'User Type update successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to update user_type..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }
    
	function delete_image()
	{
		$this->check_user_page_access('registered');
		$id= $this->input->post('id');
		$user_type_img_name=$this->user_type_model->get_user_type_list(1,0,$id);
	 	if($user_type_img_name && $user_type_img_name[0]['img'])
	 	{
	 		$img_name = $user_type_img_name[0]['img'];
			$job_id = $user_type_img_name[0]['id'];
			$img_path = $this->dir_name.$img_name;
			$img_thumb_path = $this->dir_thumb_name.$img_name;
			
			if(file_exists($img_path))
				unlink($img_path);
			if(file_exists($img_thumb_path))
				unlink($img_thumb_path);	

			if($this->user_type_model->delete_image($id)) 
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
