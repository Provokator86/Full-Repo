<?php
/*********
* Author: Iman Biswas
* Date  : 27 Sep 2011
* Modified By: 
* Modified Date: 
* 
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class Private_message extends My_Controller
{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
	private $user_id;

    public function __construct()
    {
        try
        { 
          parent::__construct(); 
          $this->data['title']="Dashboard";////Browser Title
		  $this->data['ctrlr'] = "home";
		  
		  
		  $this->cls_msg=array();
		  $this->cls_msg["save_comment"]="Message sent.";
		  $this->cls_msg["save_comment_err"]="Message not sent.";
		  
		  $this->cls_msg["msg_del"]	=	"Message deleted successfull";
		  $this->cls_msg["msg_del_err"]	=	"Unable to delete message";
		  
		  $this->cls_msg["save_messag"] = "Message status changed successfully.";		  
		  $this->cls_msg["not_access"] = 'You can\'t access this page';	
		  	
		  if(empty($this->data['loggedin']))
			{
				$this->session->set_userdata(array('message'=>$this->cls_msg["not_access"],'message_type'=>'err'));
				redirect(base_url()."user/login/TVNOaFkzVT0");
				exit;
			} 
		  
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class		  
		  
		  $this->load->model('manage_private_message_model','mod_pmb');
		  //$this->load->model('manage_buyers_model','mod_buyer');
		  $this->load->model('job_model');	
		  
		  /* job count list*/
		 
		  
		  $user_details 		= $this->data['loggedin'];
		  $this->data['name']	=	$user_details['user_name'];
		  $this->user_id 		=	decrypt($user_details['user_id']);			
		  
		  
		  /* add thick box css and js */
		  $this->add_js('js/thickbox.js');
		  $this->add_css('css/fe/thickbox.css');
		  $this->add_js('js/jquery.form.js');
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
    public function index()
    {
        try
        {	
			//print_r($this->data['loggedin']);	
			
			if(decrypt($this->data['loggedin']['user_type_id'])==1)
			{
				redirect(base_url().'private_message/private_message_board');
			}
			if(decrypt($this->data['loggedin']['user_type_id'])==2)
			{				
				redirect(base_url().'private_message/tradesman_private_message_board');
			}
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
	
	
	/* private message board */
	public function private_message_board()
    {
        try
        {
			
			$this->i_sub_menu_id	=	10;			
			$this->data['pathtoclass']=$this->pathtoclass;
			
			/* job count list*/
			  $s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_is_deleted!=1 "; 
			  $this->data['i_tot_jobs'] = $this->job_model->gettotal_info($s_where);
			  $s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_status=1 AND n.i_is_deleted!=1 "; 
			  $this->data['i_active_jobs'] = $this->job_model->gettotal_info($s_where);
			  $s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND (n.i_status=4 OR n.i_status=5 OR n.i_status=8) AND n.i_is_deleted!=1 "; 
			  $this->data['i_assigned_jobs'] = $this->job_model->gettotal_info($s_where);
			  $s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_status=6 AND n.i_is_deleted!=1 "; 
			  $this->data['i_completed_jobs'] = $this->job_model->gettotal_info($s_where);
			  $s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_status=7 AND n.i_is_deleted!=1 "; 
			  $this->data['i_expired_jobs'] = $this->job_model->gettotal_info($s_where);	 
		  	/* end job count list*/			
			
			
			$this->data['breadcrumb'] = array('My Personal Message Board'=>'');
			$this->add_css('css/fe/dd.css');
			$this->add_js('js/fe/jquery.dd.js');
			
			$user_details = $this->session->userdata('loggedin');
			$this->data['user_id']	=	$user_details['user_id'];		
			
			ob_start();
            $this->all_msg_pagination_ajax();
            $comment_contents = ob_get_contents();
            ob_end_clean();

			
			
			/* for searching with job */
			
			/*$sessArrTmp = array();
			$i_msg_src_job_id = ($this->session->userdata('i_msg_src_job_id')!='')?$this->session->userdata('i_msg_src_job_id'): trim($this->input->post('opd_job'));
			$this->session->unset_userdata('i_msg_src_job_id');
			if($i_msg_src_job_id)
			{
				$sessArrTmp['src_job_id']  = $i_msg_src_job_id;
			}
			
			$this->session->set_userdata(array('model_session'=>$sessArrTmp));	// to store data in session
			$this->data['posted'] = $sessArrTmp;
			//var_dump(decrypt($this->data['posted']['src_job_id']));exit;
			$s_wh_pmb='';
			$sessArrTmp['src_job_id']  = $this->get_session_data('src_job_id');
			
			$arr_search[]	=	" n.i_is_deleted=1 And n.i_buyer_id =".$this->user_id." ";
			if(decrypt($sessArrTmp['src_job_id']))
			{
				$arr_search[] =" n.i_job_id=".decrypt($sessArrTmp['src_job_id']);
			}			
			//echo decrypt($sessArrTmp['src_job_id']);
			$s_wh_pmb .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
			
			// pagination start
			
			$this->load->model('manage_private_message_model','mod_pmb');
			$start = ($this->uri->segment($this->i_uri_seg)) ? $this->uri->segment($this->i_uri_seg) : 0;
			$limit	= $this->i_fe_page_limit;
			$this->data['pmb_list']	=	$this->mod_pmb->fetch_pmb($s_wh_pmb,intval($start), $limit);
			//pr($this->data['pmb_list']); exit;
			
			//print_r($this->data['pmb_list']); exit;			
			
			$i_total_no = $this->mod_pmb->gettotal_info($s_wh_pmb);
			$s_pageurl = base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
			$i_uri_segment = $this->i_fe_uri_segment;
			
			$this->data['pagination'] = $this->get_fe_pagination($s_pageurl,$i_total_no,$limit,$i_uri_segment);	*/		
			
			$this->load->model('manage_private_message_model','mod_pmb');
			$s_wh = " WHERE (n.i_sender_id={$this->user_id} || n.i_receiver_id = {$this->user_id}) And n.i_status =1";
			$s_group="";
			if($_POST)
			{
				$i_job_id	=	decrypt(trim($this->input->post('opd_job')));
				if($this->input->post('opd_job')!="")
				{
					$s_wh.=" AND mb.i_job_id=".$i_job_id." ";
					$s_group = " GROUP BY n.i_msg_board_id ";
				}
				unset($i_job_id);
			
			}
			$this->data['total_message'] = $this->mod_pmb->gettotal_msg_by_job($s_wh,$s_group);
			//$this->data['total_message'] = $this->mod_pmb->gettotal_msg_info($s_wh);
			
			$this->data['pmb_list'] = $comment_contents;
			
			$this->render('private_message/private_message_board');
			unset($s_wh,$s_group);
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	 /* Ajax pagination for all jobs */
	function all_msg_pagination_ajax($start=0) {	
	
		$sessArrTmp = array();
		$i_msg_src_job_id = ($this->session->userdata('i_msg_src_job_id')!='')?$this->session->userdata('i_msg_src_job_id'): trim($this->input->post('opd_job'));
		$this->session->unset_userdata('i_msg_src_job_id');
		if($i_msg_src_job_id)
		{
			$sessArrTmp['src_job_id']  = $i_msg_src_job_id;
		}
		
		$this->session->set_userdata(array('model_session'=>$sessArrTmp));	// to store data in session
		$this->data['posted'] = $sessArrTmp;
		//var_dump(decrypt($this->data['posted']['src_job_id']));exit;
		$s_wh_pmb='';
		$sessArrTmp['src_job_id']  = $this->get_session_data('src_job_id');
		
		$arr_search[]	=	" n.i_is_deleted=1 And n.i_buyer_id =".$this->user_id." ";
		if(decrypt($sessArrTmp['src_job_id']))
		{
			$arr_search[] =" n.i_job_id=".decrypt($sessArrTmp['src_job_id']);
		}			
		//echo decrypt($sessArrTmp['src_job_id']);
		$s_wh_pmb .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
	
	
		$this->load->model('manage_private_message_model','mod_pmb');
		
		$limit	= $this->i_fe_page_limit;			
		
		$this->data['pmb_list']	=	$this->mod_pmb->fetch_pmb($s_wh_pmb,intval($start), $limit);	
		//pr($this->data['pmb_list']);
		//$total_rows = $this->mod_pmb->gettotal_info($s_wh_pmb);
		$total_rows = count($this->data['pmb_list']);
		//echo $total_rows;
		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'private_message/all_msg_pagination_ajax/';
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $limit;
		$config['cur_page'] = $start;
		$config['uri_segment'] = 0;
		$config['num_links'] = 9;
		$config['page_query_string'] = false;
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		
		$config['prev_link'] = '<';
		$config['next_link'] = '>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a class="select">';
		$config['cur_tag_close'] = '</a></li>';

		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';

		//$config['next_tag_open'] = '<span style="float:right;">';
		//$config['next_tag_close'] = '</span>';

		//$config['prev_tag_open'] = '<span style="float:left;">';
		//$config['prev_tag_close'] = '</span>';

		//$config['num_tag_open'] = '<delete>';
		//$config['num_tag_close'] = '</delete>';
	
		$config['div'] = '#job_list';
		//$config['js_bind'] = "showLoading();";
		//$config['js_rebind'] = "hideLoading();";
		//$config['js_rebind'] = "alert(data);";

		$this->jquery_pagination->initialize($config);
		//$this->data['page_links'] = preg_replace('/<delete>.*?<\/delete>/s','',$this->jquery_pagination->create_links());
		$this->data['page_links'] = $this->jquery_pagination->create_links();
		$this->data['total_rows'] = $total_rows;
		//$this->data['current_page'] = $page;
		
		$this->load->view('fe/private_message/all_msg_pagination_ajax.tpl.php',$this->data);
	
	}	
	
	
	
	public function tradesman_private_message_board()
    {
        try
        {	
			
		
			$this->i_sub_menu_id	=	17;			
			$this->data['pathtoclass']=$this->pathtoclass;
		  
		     /* job count list */
		  	$s_where = " WHERE n.i_tradesman_user_id = {$this->user_id} And n.i_status!=3 ";
		  	$this->data['i_tot_quotes'] = $this->job_model->gettotal_quote_info($s_where);
			
		    $s_where = " WHERE n.i_user_id = {$this->user_id}";
		    $this->data['i_watch_jobs'] = $this->job_model->gettotal_watchjob_info($s_where);					
			
		  	$s_where = " WHERE n.i_tradesman_id = {$this->user_id} "; 
			$this->data['i_job_invitation'] = $this->job_model->gettotal_job_invitation_info($s_where);
			  
			$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=4 AND n.i_is_deleted!=1 "; 
			$this->data['i_progress_jobs'] = $this->job_model->gettotal_info($s_where);
			$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=6 AND n.i_is_deleted!=1 "; 
			$this->data['i_completed_jobs'] = $this->job_model->gettotal_info($s_where);
			$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=11 AND n.i_is_deleted!=1 "; 
			$this->data['i_pending_jobs'] = $this->job_model->gettotal_info($s_where);
				 
			$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=8 AND n.i_is_deleted!=1 "; 
			$this->data['i_frozen_jobs'] = $this->job_model->gettotal_info($s_where);	
			
		    $this->load->model("Manage_feedback_model","mod_feed");
		    $s_where = " WHERE n.i_receiver_user_id = ".$this->user_id." AND n.i_status != 0 AND n.i_feedback_complete_status=1";	
		    $this->data['i_total_feedback']  = $this->mod_feed->gettotal_info($s_where);			  
		  
		    $s_where = " WHERE n.i_receiver_user_id = ".$this->user_id." AND n.i_status != 0 AND n.i_feedback_complete_status=0";	
		    $this->data['i_feedback_to_be_provided']  = $this->mod_feed->gettotal_info($s_where);					  
			  
		   /* Radar Model*/
		   $this->load->model('radar_model');		  
		   $this->data['i_total_radar_job'] = $this->job_model->radar_job($this->user_id);
		   /**/
		   
		   
			/* count feedback received */
		    $this->load->model('tradesman_model');
		    $this->data['profile_info'] = $this->tradesman_model->fetch_this($this->user_id);	
		
			
			$this->data['breadcrumb'] = array(t('My Personal Message Board')=>'');
			$this->add_css('css/fe/dd.css');
			$this->add_js('js/fe/jquery.dd.js');		
			

		  	
			if(time()>$this->data['profile_info']['i_account_expire_date'] &&  $this->data['site_setting']['i_subscrption_status']==1)
			{
				redirect(base_url().'user/subscription');
			}
		
			
			
			$user_details = $this->session->userdata('loggedin');
			$this->data['user_id']	=	$user_details['user_id'];
			
			
			ob_start();
            $this->trade_msg_pagination_ajax();
            $comment_contents = ob_get_contents();
            ob_end_clean();
			
			//pr($_POST);
			/* for searching with job */
			/*$sessArrTmp = array();

			if($_POST)
			{
				$sessArrTmp['src_job_id']  = trim($this->input->post('opd_job'));
			}
			
			$this->session->set_userdata(array('model_session'=>$sessArrTmp));	// to store data in session
			$this->data['posted'] = $sessArrTmp;
			//var_dump(decrypt($this->data['posted']['src_job_id']));exit;
			
			$s_wh_pmb='';
			$sessArrTmp['src_job_id']  = $this->get_session_data('src_job_id');
			
			$arr_search[]	=	" n.i_is_deleted=1 And n.i_tradesman_id =".$this->user_id." ";
			if($sessArrTmp['src_job_id'])
			{
				$arr_search[] =" n.i_job_id=".decrypt($sessArrTmp['src_job_id']);
			}			
			//echo trim($this->input->post('opd_job')).'====='.decrypt($sessArrTmp['src_job_id']);
			$s_wh_pmb .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
			
			// pagination start
			
			
			$this->load->model('manage_private_message_model','mod_pmb');
			$start = ($this->uri->segment($this->i_uri_seg)) ? $this->uri->segment($this->i_uri_seg) : 0;
			$limit	= $this->i_fe_page_limit;
			$this->data['pmb_list']	=	$this->mod_pmb->fetch_pmb($s_wh_pmb,intval($start), $limit);
			
			//print_r($this->data['pmb_list']);				
			
			//$i_total_no = $this->mod_pmb->gettotal_info($s_wh_pmb);
			$i_total_no = count($this->data['pmb_list']);
			$s_pageurl = base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
			$i_uri_segment = $this->i_fe_uri_segment;
			
			$this->data['pagination'] = $this->get_fe_pagination($s_pageurl,$i_total_no,$limit,$i_uri_segment);	*/		
			
			
			$this->load->model('manage_private_message_model','mod_pmb');
			$s_wh = " WHERE (n.i_sender_id={$this->user_id} || n.i_receiver_id = {$this->user_id}) And n.i_status =1";
			$s_group="";
			if($_POST)
			{
				$i_job_id	=	decrypt(trim($this->input->post('opd_job')));
				if($this->input->post('opd_job')!="")
				{
					$s_wh.=" AND mb.i_job_id=".$i_job_id." ";
					$s_group = " GROUP BY n.i_msg_board_id ";
				}
				unset($i_job_id);
			
			}
			
			$this->data['total_message'] = $this->mod_pmb->gettotal_msg_by_job($s_wh,$s_group);
			//$this->data['total_message'] = $this->mod_pmb->gettotal_msg_info($s_wh);
			
			$this->data['pmb_list'] = $comment_contents;
			
			$this->render('private_message/tradesman_private_message_board');
			unset($s_wh,$s_group);
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	function trade_msg_pagination_ajax($start=0) {	
	
		$sessArrTmp = array();

		if($_POST)
		{
			$sessArrTmp['src_job_id']  = trim($this->input->post('opd_job'));
		}
		
		$this->session->set_userdata(array('model_session'=>$sessArrTmp));	// to store data in session
		$this->data['posted'] = $sessArrTmp;
		//var_dump(decrypt($this->data['posted']['src_job_id']));exit;
		
		$s_wh_pmb='';
		$sessArrTmp['src_job_id']  = $this->get_session_data('src_job_id');
		
		$arr_search[]	=	" n.i_is_deleted=1 And n.i_tradesman_id =".$this->user_id." ";
		if($sessArrTmp['src_job_id'])
		{
			$arr_search[] =" n.i_job_id=".decrypt($sessArrTmp['src_job_id']);
		}			
		//echo trim($this->input->post('opd_job')).'====='.decrypt($sessArrTmp['src_job_id']);
		$s_wh_pmb .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
	
	
		$this->load->model('manage_private_message_model','mod_pmb');
		
		$limit	= $this->i_fe_page_limit;			
			
		$this->data['pmb_list']	=	$this->mod_pmb->fetch_pmb($s_wh_pmb,intval($start), $limit);	
		
		//$total_rows = $this->mod_pmb->gettotal_info($s_wh_pmb);
		$total_rows = count($this->data['pmb_list']);

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'private_message/trade_msg_pagination_ajax/';
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $limit;
		$config['cur_page'] = $start;
		$config['uri_segment'] = 0;
		$config['num_links'] = 9;
		$config['page_query_string'] = false;
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		
		$config['prev_link'] = '<';
		$config['next_link'] = '>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a class="select">';
		$config['cur_tag_close'] = '</a></li>';

		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';

		//$config['next_tag_open'] = '<span style="float:right;">';
		//$config['next_tag_close'] = '</span>';

		//$config['prev_tag_open'] = '<span style="float:left;">';
		//$config['prev_tag_close'] = '</span>';

		//$config['num_tag_open'] = '<delete>';
		//$config['num_tag_close'] = '</delete>';
	
		$config['div'] = '#job_list';
		//$config['js_bind'] = "showLoading();";
		//$config['js_rebind'] = "hideLoading();";
		//$config['js_rebind'] = "alert(data);";

		$this->jquery_pagination->initialize($config);
		//$this->data['page_links'] = preg_replace('/<delete>.*?<\/delete>/s','',$this->jquery_pagination->create_links());
		$this->data['page_links'] = $this->jquery_pagination->create_links();
		$this->data['total_rows'] = $total_rows;
		//$this->data['current_page'] = $page;
		
		$this->load->view('fe/private_message/all_msg_trade_pagination_ajax.tpl.php',$this->data);
			
	}	
	
	
	
	
	
	/* pmb details */
	public function private_message_details($i_id,$page=0)
    {
        try
        {
			$this->i_sub_menu_id	=	10;			
			$this->data['pathtoclass']=$this->pathtoclass;			
			/* job count list*/
			
			$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_is_deleted!=1 "; 
			$this->data['i_tot_jobs'] = $this->job_model->gettotal_info($s_where);
			$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_status=1 AND n.i_is_deleted!=1 "; 
			$this->data['i_active_jobs'] = $this->job_model->gettotal_info($s_where);
			$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND (n.i_status=4 OR n.i_status=5 OR n.i_status=8) AND n.i_is_deleted!=1 "; 
			$this->data['i_assigned_jobs'] = $this->job_model->gettotal_info($s_where);
			$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_status=6 AND n.i_is_deleted!=1 "; 
			$this->data['i_completed_jobs'] = $this->job_model->gettotal_info($s_where);
			$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_status=7 AND n.i_is_deleted!=1 "; 
			$this->data['i_expired_jobs'] = $this->job_model->gettotal_info($s_where);	 
			
		  	/* end job count list*/					
			
			$this->data['breadcrumb'] = array('My Personal Message Board'=>'');	
			$sep_id	=	explode("__",$i_id)	;
				
			$pmb_id	=	decrypt(trim($sep_id[1]));
			//$pmb_id	=	decrypt($i_id);
		
			//$start = ($this->uri->segment($this->i_uri_seg)) ? $this->uri->segment($this->i_uri_seg) : 0;
			$start = ($page) ? $page : 0;
			$limit	= $this->i_fe_page_limit;
			if(trim($sep_id[0])=="all")
			{
				$s_where	=	" WHERE pd.i_status = 1 AND pd.i_msg_board_id = ".$pmb_id." ";
				
			}
			else if(trim($sep_id[0])=="new")
			{
				$s_where	=	" WHERE pd.i_status = 1 AND pd.i_msg_board_id = ".$pmb_id." AND pd.i_receiver_id = {$this->user_id} AND pd.i_receiver_view_status = 0 ";
			}
			
			$this->data['pmb_details'] =  $this->mod_pmb->fetch_this_pmb($s_where,intval($start), $limit);
			
				$s_where	=	" WHERE pd.i_status = 1 AND pd.i_msg_board_id = ".$pmb_id." AND pd.i_receiver_id = {$this->user_id} AND pd.i_receiver_view_status = 0 ";
				
			$info['i_receiver_view_status']	=	1;
			$this->mod_pmb->update_view_status($info,$s_where);
			//$s_where	=	" WHERE pd.i_status = 1 AND pd.i_msg_board_id = ".$pmb_id." ";
			
		    
			//pr($this->data['pmb_details']);
			$i_total_no = $this->mod_pmb->total_msg_count($s_where);
			$s_pageurl = base_url().$this->router->fetch_class() . '/' . $this->s_action_name.'/'.$i_id;
			$i_uri_segment = $this->i_fe_uri_segment+1;
			//echo $s_pageurl.'<br>'.$i_total_no.'<br>'.$limit.'<br>'.$i_uri_segment.'<br>';
			$this->data['pagination'] = $this->get_fe_pagination($s_pageurl,$i_total_no,$limit,$i_uri_segment);			
			
			$this->data['msg_id']	=	$pmb_id	;
			
			if($_POST)
			{
				
				$posted=array();
                $posted["txt_comment"]= trim($this->input->post("txt_comment"));
				
				$this->form_validation->set_rules('txt_comment', 'provide comment', 'required');
				
				 if($this->form_validation->run() == FALSE)/////invalid
					{						
						///Display the add form with posted values within it////
						$this->data["posted"]=$posted;
					}
				else
					{
						$s_wh	=	" WHERE n.id = ".$pmb_id." ";
						$fetch_receiver_id	=	$this->mod_pmb->fetch_pmb_board($s_wh,'','');	
						//print_r($fetch_receiver_id);	 exit;				
						
						$info=array();
						$info['i_msg_board_id']	=	$pmb_id;
						$info['s_content']		=	$posted["txt_comment"];
						$info['i_sender_id']	=	$this->user_id;
						$info['i_receiver_id']	=	$fetch_receiver_id[0]['i_tradesman_id'];
						$info['i_date']			=	time();
						
						
						$this->load->model('manage_buyers_model');
						$this->load->model('tradesman_model');
					    $tradesman_details = $this->tradesman_model->fetch_this($fetch_receiver_id[0]['i_tradesman_id']);
					    $buyer_details =  $this->manage_buyers_model->fetch_this($this->user_id);
						
						$s_wh_job = " WHERE n.id=".$pmb_id." And n.i_buyer_id=".$this->user_id." ";
						$job_details = $this->mod_pmb->fetch_pmb($s_wh_job);
						
						//pr($job_details);exit;
						//echo '<br/>';
						//print_r($buyer_details);
						//exit;
						$i_newid = $this->mod_pmb->set_new_message_details($info);
						if($i_newid)////saved successfully
						{
							 $this->load->model('manage_buyers_model');	
							$s_wh_id = " WHERE n.i_user_id=".$tradesman_details['id']." ";
					        $buyer_email_key = $this->manage_buyers_model->fetch_email_keys($s_wh_id);
					        $is_mail_need = in_array('buyer_post_msg',$buyer_email_key);
							
							if($is_mail_need)
					   		{
							$this->load->model('auto_mail_model');
					        $content = $this->auto_mail_model->fetch_contact_us_content('buyer_post_msg','tradesman');
							$filename = $this->config->item('EMAILBODYHTML')."common.html";
				   			$handle = @fopen($filename, "r");
				   			$mail_html = @fread($handle, filesize($filename));	
							//print_r($content); exit;
							if(!empty($content))
							{		
								
								$description = $content["s_content"];
								$description = str_replace("[Buyer name]",$buyer_details['s_username'],$description);
								$description = str_replace("[job title]",$job_details[0]['s_job_title'],$description);	
								$description = str_replace("[service professional name]",$tradesman_details['s_username'],$description);
								$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);	
								$description = str_replace("[site_url]",base_url(),$description);									
								$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
							}
							//unset($content);
							
							$mail_html = str_replace("[site url]",base_url(),$mail_html);	
							$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
							//echo $buyer_details['s_email'];	
							//echo "<br>DESC".$description;	exit;
							
							/// Mailing code...[start]
							$site_admin_email = $this->s_admin_email;
							//echo $site_admin_email; exit;
							$this->load->library('email');
							$config['protocol'] = 'sendmail';
							$config['mailpath'] = '/usr/sbin/sendmail';
							$config['charset'] = 'utf-8';
							$config['wordwrap'] = TRUE;
							$config['mailtype'] = 'html';
												
							$this->email->initialize($config);					
							$this->email->clear();                    
							
							$this->email->from($buyer_details['s_email']);	
											
							$this->email->to($tradesman_details['s_email']);							
							
							//$this->email->subject('New Message Post Mail');
							$this->email->subject($content['s_subject']);
							
							unset($content);
							$this->email->message($mail_html);
							
							if(SITE_FOR_LIVE)///For live site
							{				
								$i_nwid = $this->email->send();	
																		
							}
							else{
								$i_nwid = TRUE;				
							}
							//echo $this->data['loggedin']['user_email'];
							//echo "<br>DESC".$description;	exit;	
							
							/// Mailing code...[end]									
							}	
							
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_comment"],'message_type'=>'succ'));	
							redirect(base_url().'private_message/private_message_details/'.$i_id);
						}
						else///Not saved, show the form again
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_comment_err"],'message_type'=>'err'));
							$this->render('private_message/private_message_details/'.$i_id);
						}
						
					
					}	
				
			
			}			
			
			$this->render('private_message/private_message_details');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	 
	
	
	
	
	public function tradesman_private_message_details($i_id,$page=0)
    {
        try
        {
			$this->i_sub_menu_id	=	17;			
			$this->data['pathtoclass']=$this->pathtoclass;	
			
			 /* job count list */
		  	$s_where = " WHERE n.i_tradesman_user_id = {$this->user_id} And n.i_status!=3 ";
		  	$this->data['i_tot_quotes'] = $this->job_model->gettotal_quote_info($s_where);
		  	$s_where = " WHERE n.i_tradesman_id = {$this->user_id} "; 
			$this->data['i_job_invitation'] = $this->job_model->gettotal_job_invitation_info($s_where);
			  
			$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=4 AND n.i_is_deleted!=1 "; 
			$this->data['i_progress_jobs'] = $this->job_model->gettotal_info($s_where);
			$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=6 AND n.i_is_deleted!=1 "; 
			$this->data['i_completed_jobs'] = $this->job_model->gettotal_info($s_where);
			$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=11 AND n.i_is_deleted!=1 "; 
			$this->data['i_pending_jobs'] = $this->job_model->gettotal_info($s_where);
				 
			$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=8 AND n.i_is_deleted!=1 "; 
			$this->data['i_frozen_jobs'] = $this->job_model->gettotal_info($s_where);	
			
		    $this->load->model("Manage_feedback_model","mod_feed");
			
		    $s_where = " WHERE n.i_receiver_user_id = ".$this->user_id." AND n.i_status != 0 AND n.i_feedback_complete_status=1";	
		    $this->data['i_total_feedback']  = $this->mod_feed->gettotal_info($s_where);			  
		 
		    $s_where = " WHERE n.i_receiver_user_id = ".$this->user_id." AND n.i_status != 0 AND n.i_feedback_complete_status=0";	
		    $this->data['i_feedback_to_be_provided']  = $this->mod_feed->gettotal_info($s_where);				
			 	  
			  
		   /* Radar Model*/
		    $this->load->model('radar_model');		  
		    $this->data['i_total_radar_job'] = $this->job_model->radar_job($this->user_id);
				
		    $this->load->model('tradesman_model');
		    $this->data['profile_info'] = $this->tradesman_model->fetch_this($this->user_id);		
			
			
			
			
			if(time()>$this->data['profile_info']['i_account_expire_date'] &&  $this->data['site_setting']['i_subscrption_status']==1)
			{
				redirect(base_url().'user/subscription');
			}

			$this->data['breadcrumb'] = array('My Personal Message Board'=>'');
			
			$sep_id	=	explode("__",$i_id)	;	
			$pmb_id	=	decrypt(trim($sep_id[1]));
			//$pmb_id	=	decrypt($i_id);
		
			//$start = ($this->uri->segment($this->i_uri_seg)) ? $this->uri->segment($this->i_uri_seg) : 0;
			$start = ($page) ? $page : 0;
			$limit	= $this->i_fe_page_limit;
			if(trim($sep_id[0])=="all")
			{
				$s_where	=	" WHERE pd.i_status = 1 AND pd.i_msg_board_id = ".$pmb_id." ";
				
			}
			else if(trim($sep_id[0])=="new")
			{
				$s_where	=	" WHERE pd.i_status = 1 AND pd.i_msg_board_id = ".$pmb_id." AND pd.i_receiver_id = {$this->user_id} AND pd.i_receiver_view_status = 0 ";
				
				
				
	
			}
			
			$this->data['pmb_details'] =  $this->mod_pmb->fetch_this_pmb($s_where,intval($start), $limit);
			
			$s_where	=	" WHERE pd.i_status = 1 AND pd.i_msg_board_id = ".$pmb_id." AND pd.i_receiver_id = {$this->user_id} AND pd.i_receiver_view_status = 0 ";
			$info['i_receiver_view_status']	=	1;
			$this->mod_pmb->update_view_status($info,$s_where);
			//pr($this->data['pmb_details']);
			
			//$pmb_id	=	decrypt($i_id);
			
									/* start of pagination */
			//$s_where	=	" WHERE pd.i_status = 1 AND  pd.i_msg_board_id = ".$pmb_id." ";	
			//$start = ($this->uri->segment($this->i_uri_seg)) ? $this->uri->segment($this->i_uri_seg) : 0;
			$start = ($page) ? $page : 0;
			$limit	= $this->i_fe_page_limit;		
			
		    //$this->data['pmb_details'] =  $this->mod_pmb->fetch_this_pmb($s_where,intval($start), $limit);
			
			$i_total_no = $this->mod_pmb->total_msg_count($s_where);
			$s_pageurl = base_url().$this->router->fetch_class() . '/' . $this->s_action_name.'/'.$i_id;
			$i_uri_segment = $this->i_fe_uri_segment+1;
			
			$this->data['pagination'] = $this->get_fe_pagination($s_pageurl,$i_total_no,$limit,$i_uri_segment);						
									/* end of pagination  */
												
			$this->data['msg_id']	=	$pmb_id	;			
			
			if($_POST)
			{
				
				$posted=array();
                $posted["txt_comment"]= trim($this->input->post("txt_comment"));
				
				$this->form_validation->set_rules('txt_comment', 'provide comment', 'required');
				
				 if($this->form_validation->run() == FALSE)/////invalid
					{						
						///Display the add form with posted values within it////
						$this->data["posted"]=$posted;
					}
				else
					{
						$this->load->model('manage_private_message_model');
						$s_where=" WHERE n.id = ".$pmb_id." ";						
						$fetch_receiver_id	=	$this->manage_private_message_model->fetch_pmb_board($s_where,'','');	
						//print_r($fetch_receiver_id);	 exit;				
						$i_msg_job_id = decrypt($this->session->userdata('s_msg_job_id'));
		  
		  				$msg_job_details = $this->job_model->fetch_this($i_msg_job_id);
						
						$i_status = ($msg_job_details['i_is_active'] ==4)?1:0;
						$info=array();
						$info['i_msg_board_id']	=	$pmb_id;
						$info['s_content']		=	$posted["txt_comment"];
						$info['i_status']		=	$i_status;
						$info['i_sender_id']	=	$this->user_id;
						$info['i_receiver_id']	=	$fetch_receiver_id[0]['i_buyer_id'];
						$info['i_date']			=	time();
						
						
						$this->load->model('manage_buyers_model');
						//$this->load->model('tradesman_model');
					    $tradesman_details = $this->tradesman_model->fetch_this($this->user_id);
					    $buyer_details =  $this->manage_buyers_model->fetch_this($fetch_receiver_id[0]['i_buyer_id']);
						//print_r($buyer_details); exit;
						
						$s_wh_job = " WHERE n.id=".$pmb_id." And n.i_buyer_id=".$fetch_receiver_id[0]['i_buyer_id']." ";
						$job_details = $this->mod_pmb->fetch_pmb($s_wh_job);
												
						//print_r($job_details); exit;
						//echo '<br/>';
						//print_r($buyer_details);
						//exit;
						
						
						$i_newid = $this->mod_pmb->set_new_message_details($info);
						if($i_newid)////saved successfully
						{
						 	$this->load->model('manage_buyers_model');	
							$s_wh_id = " WHERE n.i_user_id=".$buyer_details['id']." ";
					        $buyer_email_key = $this->manage_buyers_model->fetch_email_keys($s_wh_id);
					        $is_mail_need = in_array('tradesman_post_msg',$buyer_email_key);
							
							if($is_mail_need)
					   		{
							$this->load->model('auto_mail_model');
					        $content = $this->auto_mail_model->fetch_contact_us_content('tradesman_post_msg','buyer');
							$mail_subject = $content['s_subject'];
							$filename = $this->config->item('EMAILBODYHTML')."common.html";
				   		    $handle = @fopen($filename, "r");
				   		    $mail_html = @fread($handle, filesize($filename));	
							//print_r($content); exit;
							if(!empty($content))
							{			
								
								$description = $content["s_content"];
								$description = str_replace("[service professional name]",$tradesman_details['s_username'],$description);
								if(!empty($job_details[0]['s_job_title']))
								{
								$description = str_replace("[job title]",$job_details[0]['s_job_title'],$description);
								}
								else
								{
								$description = str_replace("[job title]",$msg_job_details['s_title'],$description);
								}	
								$description = str_replace("[Buyer name]",$buyer_details['s_username'],$description);
								$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);	
								$description = str_replace("[site_url]",base_url(),$description);									
								$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
							}
							//unset($content);
							
							$mail_html = str_replace("[site url]",base_url(),$mail_html);	
							$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
							//echo $buyer_details['s_email'];	
							//echo "<br>DESC".$description;	exit;
							
							/// Mailing code...[start]
							$site_admin_email = $this->s_admin_email;
							//echo $site_admin_email; exit;
							$this->load->library('email');
							$config['protocol'] = 'sendmail';
							$config['mailpath'] = '/usr/sbin/sendmail';
							$config['charset'] = 'utf-8';
							$config['wordwrap'] = TRUE;
							$config['mailtype'] = 'html';
												
							$this->email->initialize($config);					
							$this->email->clear();                    
							
							$this->email->from($tradesman_details['s_email']);	
											
							$this->email->to($buyer_details['s_email']);							
							//$this->email->subject('New Message Post Mai');
							$this->email->subject($mail_subject);
							
							unset($content);
							$this->email->message($mail_html);
							
							if(SITE_FOR_LIVE)///For live site
							{				
								$i_nwid = $this->email->send();	
																		
							}
							else{
								$i_nwid = TRUE;				
							}
							//echo $this->data['loggedin']['user_email'];
							//echo "<br>DESC".$description;	exit;	
							
							/// Mailing code...[end]									
							}	
						
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_comment"],'message_type'=>'succ'));	
							redirect(base_url().'private_message/tradesman_private_message_details/'.$i_id);
						}
						else///Not saved, show the form again
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_comment_err"],'message_type'=>'err'));
							$this->render('private_message/tradesman_private_message_details/'.$i_id);
						}
						
					
					}	
				
			
			}
			
			
			$this->render('private_message/tradesman_private_message_details');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	
	
	/* open confirm box*/
	function chk_delete($i_msg_id='')
	{
		//$i_image_id =  decrypt($i_image_id);
		$this->data['i_msg_id'] = $i_msg_id;
		$this->load->view('fe/private_message/chk_del.tpl.php',$this->data);
	}
	
	
	/* delete message */
	/* delete photo*/
	function delete_message()
	{
		$btn_sub = trim($this->input->post("btn_sub"));
		
		if($_POST)
		{
			$info = array();
			$i_msg_id = decrypt(trim($this->input->post("h_msg_id")));
			echo $i_msg_id; exit;
			$info['i_status'] = 2;
			$i_newid = $this->mod_pmb->edit_pmb($info,$i_msg_id);
			if($i_newid)
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del"],'message_type'=>'succ'));
				$msg = '1|'.$this->cls_msg["msg_del"];
			}
			else
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del_err"],'message_type'=>'err'));
				$msg = '2|'.$this->cls_msg["msg_del_err"];
			}
		}
		else
		{
			$msg = '';
		}	
		echo $msg;			
	}
	
	
	

   
  
	
	
	/* landing page for  professional*/   
   public function private_msg_land($s_job_id)
   {
   	try
		{
			$user_type_id =  decrypt($this->data['loggedin']['user_type_id']);
			if($user_type_id!=2)
			{				
				$this->session->set_userdata('i_msg_src_job_id',$s_job_id);
				redirect(base_url().'private_message/private_message_board');
			}
		
			
			$s_where = " WHERE n.i_job_id=".decrypt($s_job_id)." AND n.i_tradesman_id=".$this->user_id;
			$info = $this->mod_pmb->fetch_pmb_exist($s_where,0,1);			
			
			$this->session->set_userdata('s_msg_job_id',$s_job_id);
			//$s_job_poster = " WHERE n.i_job_id=".decrypt($s_job_id);
			$buyer_id = $this->job_model->fetch_this(decrypt($s_job_id));
			//print_r($buyer_id); exit;
			if(count($info)==0)
			{
				$detail = array();
				$detail['i_job_id'] = decrypt($s_job_id);
				$detail['i_tradesman_id'] = $this->user_id;
				$detail['i_buyer_id'] = $buyer_id['i_buyer_user_id'];
				$info = $this->mod_pmb->insert_info($detail);
				$i_msg_brd_id = $info;
			}
			else
			{
				$i_msg_brd_id = $info[0]['id'];
			}
			redirect(base_url().'private_message/tradesman_private_message_details/all__'.encrypt($i_msg_brd_id));
			
			
			
		}
	catch(Exception $e)
		{
			show_error($e->getMessage());
		}
   }
   
   
   		/* landing page for clients  */
   public function private_msg_land_buyer($s_job_id,$s_tradesman_id)
	   {
		try
			{
				$user_type_id =  decrypt($this->data['loggedin']['user_type_id']);
				if($user_type_id!=1)
				{	
					$this->session->set_userdata('i_msg_src_job_id',$s_job_id);
					redirect(base_url().'private_message/tradesman_private_message_board');
				}
			
				
				$s_where = " WHERE n.i_job_id=".decrypt($s_job_id)." AND n.i_tradesman_id=".decrypt($s_tradesman_id);
				$info = $this->mod_pmb->fetch_pmb_exist($s_where,0,1);
				//echo decrypt($s_tradesman_id);
				//pr($info); exit;
				$this->session->set_userdata('s_msg_job_id',$s_job_id);
				//$s_job_poster = " WHERE n.i_job_id=".decrypt($s_job_id);
				//$buyer_id = $this->job_model->fetch_this(decrypt($s_job_id));
				//print_r($buyer_id); exit;
				if(count($info)==0)
				{
					$detail = array();
					$detail['i_job_id'] = decrypt($s_job_id);
					$detail['i_tradesman_id'] = decrypt($s_tradesman_id);
					$detail['i_buyer_id'] = $this->user_id;
					$info = $this->mod_pmb->insert_info($detail);
					$i_msg_brd_id = $info;
				}
				else
				{
					$i_msg_brd_id = $info[0]['id'];
				}
				redirect(base_url().'private_message/private_message_details/all__'.encrypt($i_msg_brd_id));
				
				
				
			}
		catch(Exception $e)
			{
				show_error($e->getMessage());
			}
	   }
       
      

    public function __destruct()

    {}           

}