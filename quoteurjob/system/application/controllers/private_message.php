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
		  $this->cls_msg["save_comment"]=t("comment saved successfully.");
		  $this->cls_msg["save_comment_err"]=t("failed to save comment.");
		  
		  $this->cls_msg["msg_del"]	=	addslashes(t("message deleted successfull"));
		  $this->cls_msg["msg_del_err"]	=	addslashes(t("unable to delete message"));
		  
		  $this->cls_msg["save_messag"] = t("message status changed successfully.");
		  
		  $this->cls_msg["not_access"] = t('You can\'t access this page');
		  
		  
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
		 
		  
		  $user_details = $this->data['loggedin'];
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
		  /* job count list*/
		  $s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 
		  $this->data['i_tot_jobs'] = $this->job_model->gettotal_info($s_where);
		  $s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_status=1 AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 
		  $this->data['i_active_jobs'] = $this->job_model->gettotal_info($s_where);
		  $s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND (n.i_status=4 OR n.i_status=5 OR n.i_status=8) AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 
		  $this->data['i_assigned_jobs'] = $this->job_model->gettotal_info($s_where);
		  $s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_status=6 AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 
		  $this->data['i_completed_jobs'] = $this->job_model->gettotal_info($s_where);
		  $s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_status=7 AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 
		  $this->data['i_expired_jobs'] = $this->job_model->gettotal_info($s_where);
		  /** Feed back count **/
		  $this->load->model("Manage_feedback_model","mod_feed");
		   $s_where = " WHERE n.i_receiver_user_id = ".$this->user_id." AND n.i_status != 0   AND cat_c.i_lang_id =".$this->i_default_language; 
		
		
		   $this->data['i_total_feedback']  = $this->mod_feed->gettotal_info($s_where);	
		/** Feed back count **/
		  /* end job count list*/
			
			$this->data['breadcrumb'] = array(t('My Private Message Board')=>'');
			$this->add_css('css/fe/dd.css');
			$this->add_js('js/fe/jquery.dd.js');
			
			$user_details = $this->session->userdata('loggedin');
			$this->data['user_id']	=	$user_details['user_id'];
			
			
			/* for searching with job */
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
			
			// pagination start
			
			$this->load->model('manage_private_message_model','mod_pmb');
			$start = ($this->uri->segment($this->i_uri_seg)) ? $this->uri->segment($this->i_uri_seg) : 0;
			$limit	= $this->i_fe_page_limit=1;
			$this->data['pmb_list']	=	$this->mod_pmb->fetch_pmb($s_wh_pmb,intval($start), $limit);
			//pr($this->data['pmb_list']); exit;
			//print_r($this->data['pmb_list']); exit;			
			
			$i_total_no = $this->mod_pmb->gettotal_buyer_info($s_wh_pmb);
			$s_pageurl = base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
			$i_uri_segment = $this->i_fe_uri_segment;
			
			//echo $limit.'======='.$i_total_no;
			$this->data['pagination'] = $this->get_fe_pagination($s_pageurl,$i_total_no,$limit,$i_uri_segment);
			
			
			$this->render('private_message/private_message_board');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	public function tradesman_private_message_board()
    {
        try
        {
			
		
			$this->i_sub_menu_id	=	14;			
			$this->data['pathtoclass']=$this->pathtoclass;
			
		/* job count list*/
		  $s_where = " WHERE n.i_tradesman_user_id = {$this->user_id} And n.i_status!=3 ";
		  $this->data['i_tot_quotes'] = $this->job_model->gettotal_quote_info($s_where);
		  //$s_where = " WHERE n.i_tradesman_id = {$this->user_id} "; 
		  $s_where = " WHERE inv.i_tradesman_id = {$this->user_id} AND inv.i_status=1 AND cat_c.i_lang_id =".$this->i_default_language; 
		 // $this->data['i_job_invitation'] = $this->job_model->gettotal_job_invitation_info($s_where);
		 $this->data['i_job_invitation'] = $this->job_model->gettotal_job_invitation($s_where);
		 
		  
		  $s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=4 AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 
		  $this->data['i_progress_jobs'] = $this->job_model->gettotal_info($s_where);
		  $s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=6 AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 
		  $this->data['i_completed_jobs'] = $this->job_model->gettotal_info($s_where);
		  $s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=11 AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 
		  $this->data['i_pending_jobs'] = $this->job_model->gettotal_info($s_where);
		  
		  $s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND (n.i_status=4 || n.i_status=6 || n.i_status=10) AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 
		  $this->data['i_won_jobs'] = $this->job_model->gettotal_info($s_where);
		  
		  $s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=8 AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 
		  $this->data['i_frozen_jobs'] = $this->job_model->gettotal_info($s_where);
		   /* Radar Model*/
		  $this->load->model('radar_model');
		  
		  $this->data['i_total_radar_job'] = $this->job_model->radar_job($this->user_id,$this->i_default_language);
		  /**/
		  
			/* count feedback received */
		  $this->load->model('tradesman_model');
		  $this->data['profile_info'] = $this->tradesman_model->fetch_this($this->user_id);	
		  
		  $this->load->model("Manage_feedback_model","mod_feed");
		   $s_where = " WHERE n.i_receiver_user_id = ".$this->user_id. " AND n.i_status != 0  AND cat_c.i_lang_id =".$this->i_default_language; 
		
		   $this->data['i_total_feedback']  = $this->mod_feed->gettotal_info($s_where);	
			
			
			$this->data['breadcrumb'] = array(t('My Private Message Board')=>'');
			$this->add_css('css/fe/dd.css');
			$this->add_js('js/fe/jquery.dd.js');
			
			$user_details = $this->session->userdata('loggedin');
			$this->data['user_id']	=	$user_details['user_id'];
			
			//pr($_POST);
			/* for searching with job */
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
			
			$this->data['pagination'] = $this->get_fe_pagination($s_pageurl,$i_total_no,$limit,$i_uri_segment);			
			
			$this->render('private_message/tradesman_private_message_board');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	
	
	
	
	
	/* pmb details */
	public function private_message_details($i_id)
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
		  /** Feed back count **/
		  $this->load->model("Manage_feedback_model","mod_feed");
		   $s_where = " WHERE n.i_receiver_user_id = ".$this->user_id." AND n.i_status != 0   AND cat_c.i_lang_id =".$this->i_default_language; 
		
		
		   $this->data['i_total_feedback']  = $this->mod_feed->gettotal_info($s_where);	
		/** Feed back count **/
		  /* end job count list*/			
			
			$this->data['breadcrumb'] = array(t('My Private Message Board')=>base_url().'private_message/private_message_board',t('My Private Message Board Details')=>'');
			
			$pmb_id	=	decrypt($i_id);
			$s_where	=	" WHERE pd.i_status = 1 AND pd.i_msg_board_id = ".$pmb_id." ";
		    $this->data['pmb_details'] =  $this->mod_pmb->fetch_this_pmb($s_where,'','');
			$this->data['msg_id']	=	$pmb_id	;
			
			//print_r($this->data['pmb_details']);
			
			if($_POST)
			{
				
				$posted=array();
                $posted["txt_comment"]= trim($this->input->post("txt_comment"));
				
				$this->form_validation->set_rules('txt_comment', t('provide comment'), 'required');
				
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
						
						//print_r($job_details);exit;
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
								if($tradesman_details['i_signup_lang']==2) // for those tradesman who registered in french version
								{
									$description = $content["s_content_french"];
								}
								else
								{					
									$description = $content["s_content"];
								}
								$description = str_replace("[Buyer name]",$buyer_details['s_username'],$description);
								$description = str_replace("[job title]",$job_details['s_job_title'],$description);	
								$description = str_replace("[service professional name]",$tradesman_details['s_username'],$description);
								$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);										
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
							
							if($tradesman_details['i_signup_lang']==2)
							{
								$this->email->subject($content['s_subject_french']);
							}
							else
							{
								$this->email->subject('::: Message Post Mail :::');
							}
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
							$this->render('private_message/private_message_details');
						}
						
					
					}	
				
			
			}
			
			//print_r($this->data['pmb_details']);
			
			$this->render('private_message/private_message_details');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	
	
	public function tradesman_private_message_details($i_id)
    {
        try
        {
			$this->i_sub_menu_id	=	14;			
			$this->data['pathtoclass']=$this->pathtoclass;	
			
			 /* job count list*/
		  $s_where = " WHERE n.i_tradesman_user_id = {$this->user_id} ";
		  $this->data['i_tot_quotes'] = $this->job_model->gettotal_quote_info($s_where);
		  $s_where = " WHERE n.i_tradesman_id = {$this->user_id} ";
		  $this->data['i_job_invitation'] = $this->job_model->gettotal_job_invitation_info($s_where);
		  
		  $s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=4 AND n.i_is_deleted!=1 ";
		  $this->data['i_progress_jobs'] = $this->job_model->gettotal_info($s_where);
		  $s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=6 AND n.i_is_deleted!=1 ";
		  $this->data['i_completed_jobs'] = $this->job_model->gettotal_info($s_where);
		  
		  $s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=8 AND n.i_is_deleted!=1 ";
		  $this->data['i_frozen_jobs'] = $this->job_model->gettotal_info($s_where);
		   /* Radar Model*/
		  $this->load->model('radar_model');
		  
		  $this->data['i_total_radar_job'] = $this->job_model->radar_job($this->user_id,$this->i_default_language);
		  /**/
		  
			/* count feedback received */
			$this->load->model("Manage_feedback_model","mod_feed");
		   $s_where = " WHERE n.i_receiver_user_id = ".$this->user_id. " AND n.i_status != 0  AND cat_c.i_lang_id =".$this->i_default_language; 
		
		   $this->data['i_total_feedback']  = $this->mod_feed->gettotal_info($s_where);	
			
		  $this->load->model('tradesman_model');
		  $this->data['profile_info'] = $this->tradesman_model->fetch_this($this->user_id);			
			
			$this->data['breadcrumb'] = array(t('My Private Message Board')=>base_url().'private_message/tradesman_private_message_board',t('My Private Message Board Details')=>'');
			
			 $pmb_id	=	decrypt($i_id);
			$s_where	=	" WHERE pd.i_status = 1 AND  pd.i_msg_board_id = ".$pmb_id." ";			
			
		    $this->data['pmb_details'] =  $this->mod_pmb->fetch_this_pmb($s_where,'','');
			
			$this->data['msg_id']	=	$pmb_id	;
			
			//print_r($this->data['pmb_details']);
			
			if($_POST)
			{
				
				$posted=array();
                $posted["txt_comment"]= trim($this->input->post("txt_comment"));
				
				$this->form_validation->set_rules('txt_comment', t('provide comment'), 'required');
				
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
							
							$filename = $this->config->item('EMAILBODYHTML')."common.html";
				   		    $handle = @fopen($filename, "r");
				   		    $mail_html = @fread($handle, filesize($filename));	
							//print_r($content); exit;
							if(!empty($content))
							{			
								if($buyer_details['i_signup_lang']==2)   // for those buyers who registered in french version
								{
									$description = $content["s_content_french"];
								}
								else
								{				
									$description = $content["s_content"];
								}
								$description = str_replace("[Buyer name]",$tradesman_details['s_username'],$description);
								$description = str_replace("[job title]",$job_details['s_job_title'],$description);	
								$description = str_replace("[service professional name]",$buyer_details['s_username'],$description);
								$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);										
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
							
							if($buyer_details['i_signup_lang']==2)
							{
								$this->email->subject($content['s_subject_french']);
							}
							else
							{
								$this->email->subject('::: Message Post Mail :::');
							}
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
							$this->render('private_message/tradesman_private_message_details');
						}
						
					
					}	
				
			
			}
			
			//print_r($this->data['pmb_details']);
			
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
	
	
	

   
   /* Ajax pagination for all jobs */
	function all_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_is_deleted!=1 ";

		$limit	= $this->i_fe_page_limit;			
			
		$this->data['job_list']	= $this->job_model->fetch_multi($s_where,intval($start),$limit);		

		$total_rows = $this->job_model->gettotal_info($s_where);	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'buyer/all_jobs_pagination_ajax/';
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $limit;
		$config['cur_page'] = $start;
		$config['uri_segment'] = 0;
		$config['num_links'] = 9;
		$config['page_query_string'] = false;
		$config['first_tag_open'] = '<div style="display:none">';
		$config['first_tag_close'] = '</div>';
		$config['last_tag_open'] = '<div style="display:none">';
		$config['last_tag_close'] = '</div>';

		$config['prev_link'] = '<';
		$config['next_link'] = '>';

		$config['cur_tag_open'] = '<a class="active">';
		$config['cur_tag_close'] = '</a>';

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
		
		$this->load->view('fe/buyer/ajax_all_jobs.tpl.php',$this->data);
			
	}	   
   public function private_msg_land($s_job_id)
   {
   	try
	{
		$user_type_id =  decrypt($this->data['loggedin']['user_type_id']);
		if($user_type_id!=2)
		{			
			//$this->session->set_userdata(array('message'=>$this->cls_msg["not_access"],'message_type'=>'err'));
			
			$this->session->set_userdata('i_msg_src_job_id',$s_job_id);
			redirect(base_url().'private_message/private_message_board');
		}
	
		
		$s_where = " WHERE n.i_job_id=".decrypt($s_job_id)." AND n.i_tradesman_id=".$this->user_id;
		$info = $this->mod_pmb->fetch_pmb($s_where,0,1);
		
		
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
		redirect(base_url().'private_message/tradesman_private_message_details/'.encrypt($i_msg_brd_id));
		
		
		
	}
	catch(Exception $e)
	{
		show_error($e->getMessage());
	}
   }
   
   public function private_msg_land_buyer($s_job_id,$s_tradesman_id)
   {
   	try
	{
		$user_type_id =  decrypt($this->data['loggedin']['user_type_id']);
		if($user_type_id!=1)
		{			
			//$this->session->set_userdata(array('message'=>$this->cls_msg["not_access"],'message_type'=>'err'));
			
			$this->session->set_userdata('i_msg_src_job_id',$s_job_id);
			redirect(base_url().'private_message/tradesman_private_message_board');
		}
	
		
		$s_where = " WHERE n.i_job_id=".decrypt($s_job_id)." AND n.i_tradesman_id=".decrypt($s_tradesman_id);
		$info = $this->mod_pmb->fetch_pmb($s_where,0,1);
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
		redirect(base_url().'private_message/private_message_details/'.encrypt($i_msg_brd_id));
		
		
		
	}
	catch(Exception $e)
	{
		show_error($e->getMessage());
	}
   }

    public function __destruct()

    {}           

}



/* End of file welcome.php */

/* Location: ./system/application/controllers/welcome.php */

