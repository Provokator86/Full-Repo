<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class Cuisine extends MY_Controller
{
    function __construct()
    {
		parent::__construct();
		$this->check_user_page_access('registered');
        $this->load->model('cuisine_model');
		$this->menu_id  = 3;
	}

	function index($order_name='cuisine',$order_type='asc',$page=0)
    {
        $sessArrTmp = array();
        $this->data['title'] = 'Cuisine Page';
        if($this->input->post('go'))
        {
            $sessArrTmp['src_cuisine_title']=trim(htmlentities($this->input->post('title'),ENT_QUOTES, 'utf-8'));
            $sessArrTmp['src_cuisine_status']=$this->input->post('status');
			$page = 0;
        }
        else
        {
            $sessArrTmp['src_cuisine_title']=$this->get_session_data('src_cuisine_title');
            $sessArrTmp['src_cuisine_status']=$this->get_session_data('src_cuisine_status');
        }

        $this->data['txtArray']   = array("title"=>"Title");
        $this->data['txtValue']   = array($sessArrTmp['src_cuisine_title']);
        $this->data['optArray']   = array("status"=>"Status");
        $this->data['optValue']   = array(
            makeOption(array("1"=>"Enable","0"=>"Disable"),$sessArrTmp['src_cuisine_status']),
            makeOption($this->cuisine_model->cuisine_category,$sessArrTmp['src_cuisine_category'])
        );
		$arr = array('cuisine'=>$sessArrTmp['src_cuisine_title'],'status'=>$sessArrTmp['src_cuisine_status']);
        $this->data['cuisine']=$this->cuisine_model->get_cuisine_list($arr,$this->admin_page_limit,($page)?$page:0,$order_name,$order_type);
        $totRow = $this->cuisine_model->get_cuisine_list_count($arr);
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        if(!$this->data['cuisine'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/cuisine/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/cuisine/index/'.$order_name.'/'.$order_type,
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
        $sessArrTmp['redirect_url']=base_url().'admin/cuisine/index/'.$order_name.'/'.$order_type.'/'.$page;
        //$this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','cuisine/cuisine_list'));
		$this->render();
	}

    function ajax_change_status()
    {
        $status   = $this->input->post('status');
        $id   = $this->input->post('id');
        if($this->cuisine_model->change_data_status('cuisine',$id,$status))
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
            echo "<a onclick='call_ajax_status_change(\"".base_url()."admin/cuisine/ajax_change_status\",".$jsnArr.",\"status".$id."\");' style='cursor:pointer; ".$style."'> ".$txt."</a>";
        }
    }

    function delete_cuisine($id)
    {
        if($this->cuisine_model->delete_cuisine($id))
            $this->session->set_userdata(array('message'=>'Cuisine deleted successfully..','message_type'=>'err'));
        else
            $this->session->set_userdata(array('message'=>'Unable to delete cuisine..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }

    function add_cuisine()
    {
        $this->data['title'] = 'Add Cuisine Page';
        $this->data['table_title'] = 'Add Cuisine';

        $this->add_js(array('tinymce/jscripts/tiny_mce/tiny_mce','tinymce_load','fromvalidation'));
        $this->set_include_files(array('common/admin_menu','cuisine/add_cuisine'));
		$this->render();
    }

    function edit_cuisine($id=-1)
    {
        if(!$id||!is_numeric($id)||$id==-1)
        {
            $this->session->set_userdata(array('message'=>'Data not found for this cuisine..','message_type'=>'err'));
            header("Location: ".$this->get_redirect_url());
            exit(0);
        }
		$arr = array('id'=>$id);
        $this->data['cuisine']=$this->cuisine_model->get_cuisine_list($arr,1,0);
        
        $this->data['title'] = 'Edit Cuisine Page';
        $this->data['table_title'] = 'Edit Cuisine';
        $this->data['redirect_url']=$this->get_redirect_url();
	
        $this->add_js(array('tinymce/jscripts/tiny_mce/tiny_mce','tinymce_load','fromvalidation','ajax_helper','common_js'));
        $this->add_js(array('ajax_helper','fromvalidation','common_js'));
        $this->set_include_files(array('common/admin_menu','cuisine/edit_cuisine'));
		$this->render();
    }

    function insert_cuisine()
    {
		$cuisine = htmlspecialchars($this->input->post('cuisine'), ENT_QUOTES, 'utf-8');
        $arr= array("cuisine"=>$cuisine,
					"status"=>$this->input->post('status'),
                    "cr_date"=>time(),
					"cr_by"=>$this->session->userdata('user_id')
        );
        if($this->cuisine_model->set_data_insert('cuisine',$arr))
		{
         	$this->load->model('business_model');
			$cond_arr = array('other_cuisine'=>$cuisine);
			$business_list = $this->business_model->get_business_list($cond_arr,-1,0);
			if(isset($business_list) && !empty($business_list))
			{
				foreach($business_list as $val)
				{
					$cusine_update = str_replace($cuisine,' ',$val['other_cuisine']);
					$arr = array('other_cuisine'=>$cusine_update);
					$this->cuisine_model->set_data_update('business',$arr,$val['id']);
				}
			}
		    $this->session->set_userdata(array('message'=>'Cuisine add successfully..','message_type'=>'succ'));
        }
		else
            $this->session->set_userdata(array('message'=>'Unable to add cuisine..','message_type'=>'err'));
        header('location:'.base_url().'admin/cuisine');
        exit;
    }

    function update_cuisine()
    {
        $arr= array("cuisine"=>htmlspecialchars($this->input->post('cuisine'), ENT_QUOTES, 'utf-8'),
					"status"=>$this->input->post('status'),
                    "update_date"=>time(),
					"update_by"=>$this->session->userdata('user_id')
        );

        if($this->cuisine_model->set_data_update('cuisine',$arr,$this->input->post('id')))
            $this->session->set_userdata(array('message'=>'Cuisine update successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to update cuisine..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }
    
	function delete_image()
	{
		$this->check_user_page_access('registered');
		$id= $this->input->post('id');
		$cuisine_img_name=$this->cuisine_model->get_cuisine_list(1,0,$id);
	 	if($cuisine_img_name && $cuisine_img_name[0]['img'])
	 	{
	 		$img_name = $cuisine_img_name[0]['img'];
			$job_id = $cuisine_img_name[0]['id'];
			$img_path = $this->dir_name.$img_name;
			$img_thumb_path = $this->dir_thumb_name.$img_name;
			
			if(file_exists($img_path))
				unlink($img_path);
			if(file_exists($img_thumb_path))
				unlink($img_thumb_path);	

			if($this->cuisine_model->delete_image($id)) 
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
