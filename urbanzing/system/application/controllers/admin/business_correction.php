<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class Business_correction extends MY_Controller
{
    function __construct()
    {
		parent::__construct();
		$this->check_user_page_access('registered');
        $this->load->model('business_model');
		$this->menu_id  = 2;
	}

	function index($order_name='cr_date',$order_type='asc',$page=0)
    {
        $sessArrTmp = array();
        $this->data['title'] = 'Business Correction Page';
        if($this->input->post('go'))
        {
            $sessArrTmp['src_cuisine_title']=$this->input->post('title');
            $sessArrTmp['src_cuisine_status']=$this->input->post('status');
        }
        else
        {
            $sessArrTmp['src_cuisine_title']=$this->get_session_data('src_cuisine_title');
            $sessArrTmp['src_cuisine_status']=$this->get_session_data('src_cuisine_status');
        }
		$this->data['status'] = array("D"=>"Duplicate","I"=>"Inaccurate","C"=>"Closed","O"=>"Other");
     /*   $this->data['txtArray']   = array("title"=>"Title");
        $this->data['txtValue']   = array($sessArrTmp['src_cuisine_title']);*/
        $this->data['optArray']   = array("status"=>"Status");
        $this->data['optValue']   = array(
            makeOption($this->data['status'],$sessArrTmp['src_cuisine_status']),
            makeOption($this->cuisine_model->cuisine_category,$sessArrTmp['src_cuisine_category'])
        );
		$arr = array('business_correction'=>$sessArrTmp['src_cuisine_title'],'status'=>$sessArrTmp['src_cuisine_status']);
		
        $this->data['business_correction']=$this->business_model->get_business_correction_list($arr,$this->admin_page_limit,($page)?$page:0,$order_name,$order_type);
		
        $totRow = $this->business_model->get_business_correction_list_count($arr);
        if(!$this->data['business_correction'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/business_correction/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/business_correction/index/'.$order_name.'/'.$order_type,
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
        $sessArrTmp['redirect_url']=base_url().'admin/business_correction/index/'.$order_name.'/'.$order_type.'/'.$page;
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','business_correction/business_correction_list'));
		$this->render();
	}

    function ajax_change_status()
    {
        $status   = $this->input->post('status');
        $id   = $this->input->post('id');
        if($this->cuisine_model->change_data_status('business_correction',$id,$status))
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
            echo "<a onclick='call_ajax_status_change(\"".base_url()."admin/business_correction/ajax_change_status\",".$jsnArr.",\"status".$id."\");' style='cursor:pointer; ".$style."'> ".$txt."</a>";
        }
    }

    function delete_business_correction($id)
    {
        if($this->business_model->set_data_delete('business_correction',$id))
            $this->session->set_userdata(array('message'=>'Business Correction deleted successfully..','message_type'=>'err'));
        else
            $this->session->set_userdata(array('message'=>'Unable to delete business_correction..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }

    
}
