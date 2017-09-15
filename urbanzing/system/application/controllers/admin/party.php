<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class Party extends MY_Controller
{
	function __construct()
    {
		parent::__construct();
		$this->check_user_page_access('registered');
        $this->load->model('party_model');
		$this->menu_id  = 1;
	}

	function index($order_name='cr_date',$order_type='asc',$page=0)
    {
                $sessArrTmp = array();
        $this->data['title'] = 'Party List Page';

		if($this->input->post('go'))
        {
            $sessArrTmp['src_host_name']	=	trim(htmlentities($this->input->post('host_name'),ENT_QUOTES, 'utf-8')) ;
            $sessArrTmp['src_event_title']	=	trim(htmlentities($this->input->post('event_title'),ENT_QUOTES, 'utf-8')) ;
			$page = 0;
        }
        else
        {
            $sessArrTmp['src_host_name']=$this->get_session_data('src_host_name');
			$sessArrTmp['src_event_title']=$this->get_session_data('src_event_title');
        }
		
		$this->data['txtArray']   = array("host_name"=>"Host Name","event_title"=>"Party Name");
        $this->data['txtValue']   = array($sessArrTmp['src_host_name'],$sessArrTmp['src_event_title']);
		$arr   = array('host_name'=>$sessArrTmp['src_host_name'],'event_title'=>$sessArrTmp['src_event_title']);
		$val = $this->party_model->get_party_list($arr,$this->admin_page_limit,($page)?$page:0,$order_name,$order_type);
		$this->data['party_list'] = $val;
		
		
        $totRow = $this->party_model->get_party_list_count($arr);
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        if(!$this->data['party_list'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/party/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit();
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/party/index/'.$order_name.'/'.$order_type,
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
        //$this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','party/party_list'));
		$this->render();
	}
	
	function show_details($party_id)
	{
		$sessArrTmp = array();
        $this->data['title'] = 'Party Details Page';
		$val = $this->party_model->get_party_list(array(id=>$party_id));
		$this->data['party_details'] = $val;
		$this->data['table_title'] = 'Party Details';
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','party/party_details'));
		$this->render();
	}

    
}
