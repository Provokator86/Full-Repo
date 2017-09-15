<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class message extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('inter_message_model');
        $this->check_user_page_access('registered');
        $this->menu_id  = 5;
    }

    function index($order_name='m_name',$order_type='asc',$page=0)
    {
        $sessArrTmp = array();
        $this->data['title'] = 'Admin inbox Page';
        
        if($this->input->post('go'))
            $sessArrTmp['src_name']=$this->input->post('name');
        else
            $sessArrTmp['src_name']=$this->get_session_data('src_name');
        $this->data['txtArray']   = array("name"=>"Name");
        $this->data['txtValue']   = array($sessArrTmp['src_name']);
        
        $this->data['message']=$this->inter_message_model->get_message_list($this->admin_page_limit,($page)?$page:0,'inbox',-1,$sessArrTmp['src_name'],'','contact_us',$order_name,$order_type);
        $totRow = $this->inter_message_model->get_message_list_count('inbox',-1,$sessArrTmp['src_name'],'','contact_us');
        if(!$this->data['message'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/message/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/message/index/'.$order_name.'/'.$order_type,
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
		
        $sessArrTmp['redirect_url']=base_url().'admin/message/index/'.$order_name.'/'.$order_type.'/'.$page;
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','message/inbox'));
		$this->render();
	}
	
	function view_message($id=-1)
	{
		if($this->get_session_data('redirect_url'))
			$this->data['redirect_url']= $this->get_session_data('redirect_url');
		else
			$this->data['redirect_url']= base_url().'admin/message';
		if(!$id || $id=='' || !is_numeric($id) || $id<=0)
		{
			header('location:'.$this->data['redirect_url']);
			exit(0);
		}
		
		$sessArrTmp = $this->session->userdata('model_session');
		$sessArrTmp['redirect_url_next']=base_url().'admin/message/view_message/'.$id;
		$this->session->set_userdata(array('model_session'=>$sessArrTmp));
		
		$this->data['message']=$this->inter_message_model->get_message_list(-1,0,'',$id);
		$this->inter_message_model->set_message_update(array('read_status'=>'read'),$id);
		$this->set_include_files(array('common/admin_menu','message/view_message'));
		$this->render();
	}
	
	function compose($id=-1)
	{
//		$this->load->model('category_model');
		if($this->get_session_data('redirect_url'))
			$this->data['redirect_url']= $this->get_session_data('redirect_url');
		if($id && $id!='' && is_numeric($id) && $id>0)
		{
			$this->data['message']=$this->inter_message_model->get_message_list(-1,0,'',$id);
			$this->data['redirect_url']= $this->get_session_data('redirect_url_next');
		}
		$this->data['redirect_url']	= ($this->data['redirect_url'])?$this->data['redirect_url']:base_url().'admin/message';
//		$this->data['feedback']=$this->category_model->get_cat_selectlist('help_feedback',0,0,1);
//		$this->data['contact_us']=$this->category_model->get_cat_selectlist('contact_us',0,0,1);
		$this->add_js(array('fromvalidation','common_js'));
		$this->set_include_files(array('common/admin_menu','message/compose'));
		$this->render();
	}
	
	function send_compose()
	{
		$this->load->model('automail_model');
//		$this->load->model('category_model');
		if($this->input->post('id'))
		{
			$message=$this->inter_message_model->get_message_list(-1,0,'',$this->input->post('id'));
//			$category_id=$message[0]['c_id'];
//			$category	= $this->category_model->get_category_list(-1,0,$category_id);
			$subject	= $this->input->post('subject');
		}
		else
		{
//			$category_id=$this->input->post('subject');
//			$category	= $this->category_model->get_category_list(-1,0,$category_id);
			$subject	= $category[0]['name'];
		}
		$item_type	= 'contact_us';
		$arr= array("name"=>htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
                            "email"=>htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8'),
                            "message"=>htmlspecialchars($this->input->post('message'), ENT_QUOTES, 'utf-8'),
                            "item_type"=>$item_type,
                            "status"=>'outbox',
                            "read_status"=>'read',
                            "date"=>time()
        	);
		if($this->inter_message_model->set_message_insert($arr))
		{
			$this->automail_model->send_compose_mail($subject,$this->input->post('message'),$this->input->post('email'));
			$this->session->set_userdata(array('message'=>'Message send successfully..','message_type'=>'succ'));
		}	
		else
			$this->session->set_userdata(array('message'=>'Unable to send message..','message_type'=>'err'));
		if($this->get_session_data('redirect_url'))
			$redirect_url= $this->get_session_data('redirect_url');
		else
			$redirect_url= base_url().'admin/message';
		header("Location: ".$redirect_url);
	}
	
	function outbox($order_name='m_name',$order_type='asc',$page=0)
    {
        $sessArrTmp = array();
        $this->data['title'] = 'Admin Outbox Page';
        
        if($this->input->post('go'))
            $sessArrTmp['src_name']=$this->input->post('name');
        else
            $sessArrTmp['src_name']=$this->get_session_data('src_name');
        $this->data['txtArray']   = array("name"=>"Name");
        $this->data['txtValue']   = array($sessArrTmp['src_name']);

        $this->data['message']=$this->inter_message_model->get_message_list($this->admin_page_limit,($page)?$page:0,'outbox',-1,$sessArrTmp['src_name'],$sessArrTmp['src_subject'],$sessArrTmp['src_type'],$order_name,$order_type);
        $totRow = $this->inter_message_model->get_message_list_count('outbox',-1,$sessArrTmp['src_name'],$sessArrTmp['src_subject'],$sessArrTmp['src_type']);
        if(!$this->data['message'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/message/outbox/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/message/outbox/'.$order_name.'/'.$order_type,
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
		
        $sessArrTmp['redirect_url']=base_url().'admin/message/outbox/'.$order_name.'/'.$order_type.'/'.$page;
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','message/outbox'));
		$this->render();
	}
	
	function make_archive($id=-1)
	{
		if(!$id || $id=='' || !is_numeric($id) || $id<=0)
		{
			header('location:'.base_url().'admin/message');
			exit(0);
		}
		if($this->inter_message_model->set_message_update(array('status'=>'archive'),$id))
			$this->session->set_userdata(array('message'=>'Message moved to archive successfully..','message_type'=>'succ'));
		else
			$this->session->set_userdata(array('message'=>'Unable to move message..','message_type'=>'err'));
		
		header("Location: ".base_url().'admin/message');
	}
	
	function archive($order_name='m_name',$order_type='asc',$page=0)
    {
        $sessArrTmp = array();
        $this->data['title'] = 'Admin Archive Page';
        
        if($this->input->post('go'))
            $sessArrTmp['src_name']=$this->input->post('name');
        else
            $sessArrTmp['src_name']=$this->get_session_data('src_name');
        $this->data['txtArray']   = array("name"=>"Name");
        $this->data['txtValue']   = array($sessArrTmp['src_name']);
        
        $this->data['message']=$this->inter_message_model->get_message_list($this->admin_page_limit,($page)?$page:0,'archive',-1,$sessArrTmp['src_name'],$sessArrTmp['src_subject'],$sessArrTmp['src_type'],$order_name,$order_type);
        $totRow = $this->inter_message_model->get_message_list_count('archive',-1,$sessArrTmp['src_name'],$sessArrTmp['src_subject'],$sessArrTmp['src_type']);
        if(!$this->data['message'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/message/archive/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/message/archive/'.$order_name.'/'.$order_type,
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
		
        $sessArrTmp['redirect_url']=base_url().'admin/message/archive/'.$order_name.'/'.$order_type.'/'.$page;
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','message/archive'));
		$this->render();
	}
	
	function delete($id=-1)
	{
		if($this->get_session_data('redirect_url'))
			$redirect_url= $this->get_session_data('redirect_url');
		else
			$redirect_url= base_url().'admin/message';
		if(!$id || $id=='' || !is_numeric($id) || $id<=0)
		{
			header('location:'.$redirect_url);
			exit(0);
		}
		
		if($this->inter_message_model->set_job_delete($id))
			$this->session->set_userdata(array('message'=>'Message deleted successfully..','message_type'=>'succ'));
		else
			$this->session->set_userdata(array('message'=>'Unable delete message..','message_type'=>'err'));
		
		header('location:'.$redirect_url);
	}
}