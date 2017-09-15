<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class Price_range extends MY_Controller
{
    function __construct()
    {
		parent::__construct();
		$this->check_user_page_access('registered');
        $this->load->model('price_range_model');
		$this->menu_id  = 3;
	}

	function index($order_name='cr_date',$order_type='asc',$page=0)
    {
        $sessArrTmp = array();
        $this->data['title'] = 'Price range Page';
        if($this->input->post('go'))
        {
           // $sessArrTmp['src_price_range_title']=$this->input->post('title');
            $sessArrTmp['src_price_range_status']=$this->input->post('status');
        }
        else
        {
           // $sessArrTmp['src_price_range_title']=$this->get_session_data('src_price_range_title');
            $sessArrTmp['src_price_range_status']=$this->get_session_data('src_price_range_status');
        }

/*        $this->data['txtArray']   = array("title"=>"Title");
        $this->data['txtValue']   = array($sessArrTmp['src_price_range_title']);
*/      $this->data['optArray']   = array("status"=>"Status");
        $this->data['optValue']   = array(
            makeOption(array("1"=>"Enable","0"=>"Disable"),$sessArrTmp['src_price_range_status'])
        );
		//echo $sessArrTmp['src_price_range_status'];
		$arr = array('status'=>$sessArrTmp['src_price_range_status']);
		
        $this->data['price_range']=$this->price_range_model->get_price_range_list($arr,$this->admin_page_limit,($page)?$page:0,$order_name,$order_type);
        $totRow = $this->price_range_model->get_price_range_list_count($arr);
        if(!$this->data['price_range'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/price_range/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/price_range/index/'.$order_name.'/'.$order_type,
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
        $sessArrTmp['redirect_url']=base_url().'admin/price_range/index/'.$order_name.'/'.$order_type.'/'.$page;
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','price_range/price_range_list'));
		$this->render();
	}

    function ajax_change_status()
    {
        $status   = $this->input->post('status');
        $id   = $this->input->post('id');
        if($this->price_range_model->change_data_status('price_range',$id,$status))
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
            echo "<a onclick='call_ajax_status_change(\"".base_url()."admin/price_range/ajax_change_status\",".$jsnArr.",\"status".$id."\");' style='cursor:pointer; ".$style."'> ".$txt."</a>";
        }
    }

    function delete_price_range($id)
    {
        if($this->price_range_model->delete_price_range($id))
            $this->session->set_userdata(array('message'=>'price range deleted successfully..','message_type'=>'err'));
        else
            $this->session->set_userdata(array('message'=>'Unable to delete price_range..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }

    function add_price_range()
    {
        $this->data['title'] = 'Add price_range Page';
        $this->data['table_title'] = 'Add price_range';
		$this->load->model('location_model');
		$this->data['country'] = $this->location_model->get_country_list_option(113);

        $this->add_js(array('tinymce/jscripts/tiny_mce/tiny_mce','tinymce_load','fromvalidation'));
        $this->set_include_files(array('common/admin_menu','price_range/add_price_range'));
		$this->render();
    }

    function edit_price_range($id=-1)
    {
        if(!$id||!is_numeric($id)||$id==-1)
        {
            $this->session->set_userdata(array('message'=>'Data not found for this price_range..','message_type'=>'err'));
            header("Location: ".$this->get_redirect_url());
            exit(0);
        }
		$this->load->model('location_model');
		$arr = array('id'=>$id);
        $this->data['price_range']=$this->price_range_model->get_price_range_list($arr,1,0);
		$this->data['country'] = $this->location_model->get_country_list_option($this->data['price_range'][0]['country_id']);
        
        $this->data['title'] = 'Edit price_range Page';
        $this->data['table_title'] = 'Edit price_range';
        $this->data['redirect_url']=$this->get_redirect_url();
	
        $this->add_js(array('tinymce/jscripts/tiny_mce/tiny_mce','tinymce_load','fromvalidation','ajax_helper','common_js'));
        $this->add_js(array('ajax_helper','fromvalidation','common_js'));
        $this->set_include_files(array('common/admin_menu','price_range/edit_price_range'));
		$this->render();
    }

    function insert_price_range()
    {
        $arr= array("price_from"=>htmlspecialchars($this->input->post('price_from'), ENT_QUOTES, 'utf-8'),
					"price_to"=>htmlspecialchars($this->input->post('price_to'), ENT_QUOTES, 'utf-8'),
					"country_id"=>htmlspecialchars($this->input->post('country_id'), ENT_QUOTES, 'utf-8'),
					"status"=>$this->input->post('status'),
                    "cr_date"=>time(),
					"cr_by"=>$this->session->userdata('user_id')
        );
		$id = $this->price_range_model->set_data_insert('price_range',$arr);
        if($id)
			$this->session->set_userdata(array('message'=>'price range add successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to add price range..','message_type'=>'err'));
        header('location:'.base_url().'admin/price_range');
        exit;
    }

    function update_price_range()
    {
		$id = $this->input->post('id');
        $arr= array("price_from"=>htmlspecialchars($this->input->post('price_from'), ENT_QUOTES, 'utf-8'),
					"price_to"=>htmlspecialchars($this->input->post('price_to'), ENT_QUOTES, 'utf-8'),
					"country_id"=>htmlspecialchars($this->input->post('country_id'), ENT_QUOTES, 'utf-8'),
					"status"=>$this->input->post('status'),
                    "update_date"=>time(),
					"update_by"=>$this->session->userdata('user_id')
        );

        if($this->price_range_model->set_data_update('price_range',$arr,$id))
		    $this->session->set_userdata(array('message'=>'Price range update successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to update price range..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }
    
	function delete_image()
	{
		$this->check_user_page_access('registered');
		$id= $this->input->post('id');
		$price_range_img_name=$this->price_range_model->get_price_range_list(1,0,$id);
	 	if($price_range_img_name && $price_range_img_name[0]['img'])
	 	{
	 		$img_name = $price_range_img_name[0]['img'];
			$job_id = $price_range_img_name[0]['id'];
			$img_path = $this->dir_name.$img_name;
			$img_thumb_path = $this->dir_thumb_name.$img_name;
			
			if(file_exists($img_path))
				unlink($img_path);
			if(file_exists($img_thumb_path))
				unlink($img_thumb_path);	

			if($this->price_range_model->delete_image($id)) 
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
