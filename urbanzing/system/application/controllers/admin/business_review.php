<?php
//for MLM
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;

class business_review extends MY_Controller
{
    function __construct()
    {
		parent::__construct();
		$this->check_user_page_access('registered');
                $this->load->model('business_model');
		$this->menu_id  = 1;
	}

    function index($order_name='cr_date',$order_type='asc',$page=0)
    {
		$this->load->model('category_model');
        $sessArrTmp = array();
        $this->data['title'] = 'Business Review';
        if($this->input->post('go'))
        {
            $sessArrTmp['src_business_title']       =   trim(htmlentities($this->input->post('title'),ENT_QUOTES, 'utf-8'));
            $sessArrTmp['src_business_category']  	=   $this->input->post('business_category');
			$page = 0;
        }
        else
        {
            $sessArrTmp['src_business_title']=$this->get_session_data('src_business_title');
            $sessArrTmp['src_business_category']=$this->input->post('business_category');
        }

       

        $this->data['txtArray']   = array("title"=>"Search");
        $this->data['txtValue']   = array($sessArrTmp['src_business_title']);
        $this->data['optArray']   = array("business_category"=>"Business");
        $this->data['optValue']   = array(makeOption($this->category_model->business_type,$sessArrTmp['src_business_category']));

		//echo $sessArrTmp['src_business_title'];
		$arr = array('name'=>$sessArrTmp['src_business_title'],'business_category'=>$sessArrTmp['src_business_category']);
        $this->data['business']=$this->business_model->get_business_review_list($arr,$this->admin_page_limit,($page)?$page:0,$order_name,$order_type);
     
        $totRow = $this->business_model->get_business_review_list_count($arr,$this->admin_page_limit,($page)?$page:0,$order_name,$order_type);
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        if(!$this->data['business'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/business_review/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }

        paggingInitialization($this,
            array('base_url'=>base_url().'admin/business_review/index/'.$order_name.'/'.$order_type,
                    'total_row'=>$totRow,
                    'per_page'=>$this->admin_page_limit,
                    'uri_segment'=>6,
                    'next_link'=>'Next&gt;',
                    'prev_link'=>'&lt;Prev'
                )
            );
		$this->data['status'] = $this->business_model->business_status;
        $this->data['order_name']=$order_name;
        $this->data['order_type']=$order_type;
        $this->data['page']=$page;
        $sessArrTmp['redirect_url']=base_url().'admin/business_review/index/'.$order_name.'/'.$order_type.'/'.$page;
        //$this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js(array('ajax_helper','thickbox'));
        $this->add_css('thickbox');


        $this->set_include_files(array('common/admin_menu','business/business_review.list'));
	$this->render();
	}
	
	function ajax_show_review($id)
	{
		$data['review'] = $this->business_model->get_review($id);
		$this->load->view('ajax_view/show_review.tpl.php',$data);
	}

	function delete_review()
	{
        $review_id = $_POST['id'];
		$this->check_user_page_access('registered');
		$this->load->model('review_model');
		$business_id = $this->review_model->get_review($review_id);
		$this->review_model->delete_review($review_id);
		$this->review_model->set_business_review_update($business_id[0]['business_id']);
		$this->session->set_userdata(array('message'=>"Review deleted Successfully.",'message_type'=>'succ'));
        header("location:".base_url().'admin/business_review/');
		exit();
	}

        
	
   
}
