<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class Business_image extends MY_Controller
{
 	public $upload_path = '';
    function __construct()
    {
		parent::__construct();
		$this->check_user_page_access('registered');
        $this->load->model('business_model');
		$this->upload_path = $this->config->item('upload_image_folder_biz');
		$this->menu_id  = 1;
	}

	function index($order_name='cr_date',$order_type='asc',$page=0)
    {
        $sessArrTmp = array();
        $this->data['title'] = 'Busienss image Page';
        if($this->input->post('go'))
        {
            $sessArrTmp['src_business_title']	=	trim(htmlentities($this->input->post('title'),ENT_QUOTES,'utf-8'));
            $sessArrTmp['src_business_status']	=	$this->input->post('status');
			$page=0;
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
            makeOption(array("1"=>"Enable","0"=>"Disable"),$sessArrTmp['src_business_status']),
            makeOption($this->business_model->business_category,$sessArrTmp['src_business_category'])
        );
		$cond_arr = array('name'=>$sessArrTmp['src_business_title'],'status'=>$sessArrTmp['src_business_status'],'cover_picture'=>'N');
        //$cond_arr['name'] = convert_special_character($cond_arr['name']);// For Handing with special Characters
		$this->data['business_image'] = $this->business_model->get_business_image_list($cond_arr,$this->admin_page_limit,($page)?$page:0,$order_name,$order_type);
		//var_dump($this->data['business_image']);
        $totRow = $this->business_model->get_business_image_list_count($cond_arr);
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        if(!$this->data['business_image'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/business_image/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/business_image/index/'.$order_name.'/'.$order_type,
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
        $sessArrTmp['redirect_url']=base_url().'admin/business_image/index/'.$order_name.'/'.$order_type.'/'.$page;
        //$this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','business_image/business_image_list'));
		$this->render();
	}

	/**
	 * @author Rubel Debnath
	 * @author Anutosh Ghosh
	 */
    function ajax_change_status()
    {
		$this->load->model('business_profile_model');
		$status = $this->input->post('status');
		$id = $this->input->post('id');

		if($this->business_model->change_data_status('business_picture', $id, $status))
		{
			$arr_details = $this->business_profile_model->get_business_photo(array('id' => $id, 'all' => 1));
			$this->business_profile_model->set_business_cover_pic($arr_details[0]['business_id']);

			$txt = " Disable";
			$style = '';
			$status = 1 - $status;
			if($status == 1)
			{
				$style = "color:green;";
				$txt = " Enable";
			}

			$jsnArr = json_encode(array('id' => $id, 'status' => $status));
			echo "<a onclick='call_ajax_status_change(\"".base_url()."admin/business_image/ajax_change_status\",".$jsnArr.", \"status".$id."\");' style='cursor:pointer; ".$style."'>".$txt."</a>";
		}
    }

	/**
	 * Deletes Business Image
	 * 
	 * @param integer $id
	 * @author Rubel Debnath
	 * @author Anutosh Ghosh
	 */
    function delete_business_image($id)
    {
		$cond_arr = array('id' => $id);
		$business_image = $this->business_model->get_business_image_list($cond_arr, 1, 0);

		if($this->business_model->set_data_delete('business_picture', $id))
		{
			@unlink($this->upload_path.$business_image[0]['img_name']);
			@unlink($this->upload_path.$this->config->item('image_folder_thumb').$business_image[0]['img_name']);
			@unlink($this->upload_path.$this->config->item('image_folder_view').$business_image[0]['img_name']);

			$this->session->set_userdata(array(
				'message' => 'Business image deleted successfully.',
				'message_type' => 'succ'
			));
		}
		else
		{
			$this->session->set_userdata(array(
				'message' => 'Unable to delete business image.',
				'message_type' => 'err'
			));
		}
		
		header('location:'.$this->get_redirect_url());
		exit;
    }



}
