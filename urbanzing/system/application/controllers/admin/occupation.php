<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class Occupation extends MY_Controller
{
    function __construct()
    {
		parent::__construct();
		$this->check_user_page_access('registered');
        $this->load->model('occupation_model');
		$this->menu_id  = 3;
	}

	function index($order_name='occupation',$order_type='asc',$page=0)
    {
        $sessArrTmp = array();
        $this->data['title'] = 'Occupation Page';
        if($this->input->post('go'))
        {
            $sessArrTmp['src_occupation_title']=	trim(htmlentities($this->input->post('title'),ENT_QUOTES, 'utf-8'));
            $sessArrTmp['src_occupation_status']=$this->input->post('status');
			$page = 0;
        }
        else
        {
            $sessArrTmp['src_occupation_title']=$this->get_session_data('src_occupation_title');
            $sessArrTmp['src_occupation_status']=$this->get_session_data('src_occupation_status');
        }

        $this->data['txtArray']   = array("title"=>"Title");
        $this->data['txtValue']   = array($sessArrTmp['src_occupation_title']);
        $this->data['optArray']   = array("status"=>"Status");
        $this->data['optValue']   = array(
            makeOption(array("1"=>"Enable","0"=>"Disable"),$sessArrTmp['src_occupation_status']),
            makeOption($this->occupation_model->occupation_category,$sessArrTmp['src_occupation_category'])
        );
		$arr = array('occupation'=>$sessArrTmp['src_occupation_title'],'status'=>$sessArrTmp['src_occupation_status']);
        $this->data['occupation']=$this->occupation_model->get_occupation_list($arr,$this->admin_page_limit,($page)?$page:0,$order_name,$order_type);
        $totRow = $this->occupation_model->get_occupation_list_count($arr);
		$this->session->set_userdata(array('model_session'=>$sessArrTmp));
        if(!$this->data['occupation'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/occupation/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
		
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/occupation/index/'.$order_name.'/'.$order_type,
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
        $sessArrTmp['redirect_url']=base_url().'admin/occupation/index/'.$order_name.'/'.$order_type.'/'.$page;
        //$this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','occupation/occupation_list'));
		$this->render();
	}

    function ajax_change_status()
    {
        $status   = $this->input->post('status');
        $id   = $this->input->post('id');
        if($this->occupation_model->change_data_status('occupation',$id,$status))
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
            echo "<a onclick='call_ajax_status_change(\"".base_url()."admin/occupation/ajax_change_status\",".$jsnArr.",\"status".$id."\");' style='cursor:pointer; ".$style."'> ".$txt."</a>";
        }
    }

    function delete_occupation($id)
    {
        if($this->occupation_model->delete_occupation($id))
            $this->session->set_userdata(array('message'=>'Occupation deleted successfully..','message_type'=>'err'));
        else
            $this->session->set_userdata(array('message'=>'Unable to delete occupation..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }

    function add_occupation()
    {
        $this->data['title'] = 'Add Occupation Page';
        $this->data['table_title'] = 'Add Occupation';

        $this->add_js(array('tinymce/jscripts/tiny_mce/tiny_mce','tinymce_load','fromvalidation'));
        $this->set_include_files(array('common/admin_menu','occupation/add_occupation'));
		$this->render();
    }

    function edit_occupation($id=-1)
    {
        if(!$id||!is_numeric($id)||$id==-1)
        {
            $this->session->set_userdata(array('message'=>'Data not found for this occupation..','message_type'=>'err'));
            header("Location: ".$this->get_redirect_url());
            exit(0);
        }
		$arr = array('id'=>$id);
        $this->data['occupation']=$this->occupation_model->get_occupation_list($arr,1,0);
        
        $this->data['title'] = 'Edit Occupation Page';
        $this->data['table_title'] = 'Edit Occupation';
        $this->data['redirect_url']=$this->get_redirect_url();
	
        $this->add_js(array('tinymce/jscripts/tiny_mce/tiny_mce','tinymce_load','fromvalidation','ajax_helper','common_js'));
        $this->add_js(array('ajax_helper','fromvalidation','common_js'));
        $this->set_include_files(array('common/admin_menu','occupation/edit_occupation'));
		$this->render();
    }

    function insert_occupation()
    {
        $arr= array("occupation"=>htmlspecialchars($this->input->post('occupation'), ENT_QUOTES, 'utf-8'),
					"status"=>$this->input->post('status'),
                    "cr_date"=>time(),
					"cr_by"=>$this->session->userdata('user_id')
        );
        if($this->occupation_model->set_data_insert('occupation',$arr))
            $this->session->set_userdata(array('message'=>'Occupation add successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to add occupation..','message_type'=>'err'));
        header('location:'.base_url().'admin/occupation');
        exit;
    }

    function update_occupation()
    {
        $arr= array("occupation"=>htmlspecialchars($this->input->post('occupation'), ENT_QUOTES, 'utf-8'),
					"status"=>$this->input->post('status'),
                    "update_date"=>time(),
					"update_by"=>$this->session->userdata('user_id')
        );

        if($this->occupation_model->set_data_update('occupation',$arr,$this->input->post('id')))
            $this->session->set_userdata(array('message'=>'Occupation update successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to update occupation..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }
    
	function delete_image()
	{
		$this->check_user_page_access('registered');
		$id= $this->input->post('id');
		$occupation_img_name=$this->occupation_model->get_occupation_list(1,0,$id);
	 	if($occupation_img_name && $occupation_img_name[0]['img'])
	 	{
	 		$img_name = $occupation_img_name[0]['img'];
			$job_id = $occupation_img_name[0]['id'];
			$img_path = $this->dir_name.$img_name;
			$img_thumb_path = $this->dir_thumb_name.$img_name;
			
			if(file_exists($img_path))
				unlink($img_path);
			if(file_exists($img_thumb_path))
				unlink($img_thumb_path);	

			if($this->occupation_model->delete_image($id)) 
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
