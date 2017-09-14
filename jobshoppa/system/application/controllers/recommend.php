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

class Recommend extends My_Controller
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
		  if(empty( $this->data['loggedin']))
			{
				redirect(base_url()."home");
				exit;
			}
		  
		  $this->cls_msg=array();
		  $this->cls_msg["save_recommend"]="recommend(s) send successfully.";
		  $this->cls_msg["save_recommend_err"]="please try again.";
		  
		  $this->cls_msg["msg_del"]	=	"message deleted successfull";
		  $this->cls_msg["msg_del_err"]	=	"unable to delete message";
		  
		  $this->cls_msg["save_messag"] = "message status changed successfully.";
		  
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  $this->load->model('recommend_model','mod_recomm');
		  
		  $this->load->model('auto_mail_model','mod_auto');
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
				redirect(base_url().'recommend/buyer_recommend');
			}
			if(decrypt($this->data['loggedin']['user_type_id'])==2)
			{
				redirect(base_url().'recommend/tradesman_recommend');
			}
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
	
	
	/* private message board */
	public function buyer_recommend()
    {
        try
        {
			$this->i_sub_menu_id	=	15;			
			$this->data['pathtoclass']=$this->pathtoclass;
			//print_r($this->data['loggedin']);
			
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
		   
		   /** Feed back count **/		
		   /** Feed back count **/	
		   	
		  $this->data['breadcrumb'] = array(t('Recommend Us')=>'');
		  $this->add_css('css/fe/dd.css');
		  $this->add_js('js/fe/jquery.dd.js');	
		  
		  if($_POST)
		  {
		  	$posted	=	array();
			foreach($_POST['email_arr'] as $emails)
			{
			 //$email	=	implode(',',$_POST['email_arr']);
			$emails = trim($emails);
			 	if(!empty($emails))
			 	$all_mail[]	=	$emails;
			 		 
			}
			
			//print_r($all_mail); exit;			
			foreach($_POST['name_arr'] as $names)
			{
				//$name	=	implode(',',$_POST['name_arr']);
				$names = trim($names);
			 	if(!empty($names))
			 	$all_name[]	=	$names;
				
			}
			$duplicate = false;
			$ar_recom = array();
			$ar_ext = array();
			$count = 0;
			for($i=0;$i<count($all_mail);$i++)
			{			
				$i_newid = false;	
				$s_verification_code	=	genVerificationCode();  // function written in common_helper
				$info["s_verification_code"] = $s_verification_code;	
				$chk_val = $this->mod_recomm->check_email($all_mail[$i],$this->user_id);	
				if($chk_val==0)	
				{				
					$i_newid	=	$this->mod_recomm->add_info($all_mail[$i],$all_name[$i],$info,$this->user_id);
				}
				else
				{
					$duplicate = true;
					if($chk_val==1)	
					{
						$ar_recom[] = $all_mail[$i];
					}				
					elseif($chk_val==2)
					{
						$ar_ext[] = $all_mail[$i];
					}
				}
				 /* for referred verification mail to the user */
				   if($i_newid)
				   {
				   $count++;
				   $content = $this->mod_auto->fetch_contact_us_content('referral_mail','general');	
				   
				   $filename = $this->config->item('EMAILBODYHTML')."common.html";
				   $handle = @fopen($filename, "r");
				   $mail_html = @fread($handle, filesize($filename));				
					//print_r($content); exit;
					if(!empty($content))
						{		
							$description = $content["s_content"];
							$description = str_replace("[referred name]",$all_name[$i],$description);	
							$description = str_replace("[Buyer/Service Professional name]", $user_details['user_name'],$description);								
							$description = str_replace("[##register_link##]",base_url().'home/active_account'.'/'.$s_verification_code,$description);
							$description = str_replace("[site_url]",base_url(),$description);
							$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
						}
					//unset($content);
					
					$mail_html = str_replace("[site url]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
						
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
                    
                    $this->email->from($site_admin_email);	
									
                    $this->email->to($all_mail[$i]);
                    //$this->email->subject('::: Referral mail :::');
					$this->email->subject($content['s_subject']);
					unset($content);
					
                    $this->email->message($mail_html);
					//echo "<br>DESC".$description;	exit;	
					 if(SITE_FOR_LIVE)///For live site
						{	
							//$this->session->set_userdata('s_verification_code',$s_verification_code);								
							$i_nwid = $this->email->send();																	
						}
					else
						{
							$i_nwid = TRUE;				
						}
						
					
				}	
				
				
			} // end for loop
			
			 if($i_nwid)////saved successfully
				{
					$msg =array();
					if($duplicate)
					{
						
						if(count($ar_recom)>0)
						{
							$s_email = implode(", ",$ar_recom);
							$msg[] = $s_email." email(s) are already recomended by you.";
							//$this->session->set_userdata(array('message'=>$msg,'message_type'=>'err'));
						
						}
						if(count($ar_ext)>0)
						{
							$s_email = implode(", ",$ar_ext);
							$msg[] = $s_email." email(s) are already registered.";
							//$this->session->set_userdata(array('message'=>$msg,'message_type'=>'err'));
						
						}
						
					}     
					if(count($msg)>0)      
						$s_part = implode(" <br/>",$msg).'<br/>';
					else
						$s_part = "";   
					$this->session->set_userdata(array('message'=>$s_part.' '.$count.' '.$this->cls_msg["save_recommend"],'message_type'=>'succ'));
					redirect($this->pathtoclass."success_message");
				}
				else///Not saved, show the form again
				{
					$msg =array();
					if($duplicate)
					{
						
						if(count($ar_recom)>0)
						{
							$s_email = implode(", ",$ar_recom);
							$msg[] = $s_email." email(s) are already recomended by you.";
							//$this->session->set_userdata(array('message'=>$msg,'message_type'=>'err'));
						
						}
						if(count($ar_ext)>0)
						{
							$s_email = implode(", ",$ar_ext);
							$msg []= $s_email." email(s) are already registered.";
							//$this->session->set_userdata(array('message'=>$msg,'message_type'=>'err'));
						
						}
						
					}  
					if(count($msg)>0)      
						$s_part = implode(" <br/>",$msg).'<br/>';
					else
						$s_part = "";
					$this->session->set_userdata(array('message'=>$s_part.$this->cls_msg["save_recommend_err"],'message_type'=>'err'));
					redirect(base_url().'recommend/buyer_recommend');
					
					//set_error_msg($this->cls_msg["save_recommend"]);
				}
			
		  }
		  		
		  /* for pagination and listing */
		  	$s_wh_recommend = " WHERE n.i_referrer_id=".$this->user_id." ";
		    $start = ($this->uri->segment($this->i_uri_seg)) ? $this->uri->segment($this->i_uri_seg) : 0;
			$limit	= $this->i_fe_page_limit;
			$this->data['rec_list']	=	$this->mod_recomm->fetch_multi($s_wh_recommend,intval($start), $limit);
			
			//print_r($this->data['rec_list']);			
			
			$i_total_no = $this->mod_recomm->gettotal_info($s_wh_recommend);
			$s_pageurl = base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
			$i_uri_segment = $this->i_fe_uri_segment;
			
			$this->data['pagination'] = $this->get_fe_pagination($s_pageurl,$i_total_no,$limit,$i_uri_segment);
		  
		  	
		  $this->render('recommend/buyer_recommend');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	/* success page */
	public function success_message()
	{	
		//$this->i_menu_id = 1;		
		$this->data['breadcrumb'] = array(t('Confirmation Page')=>'');	
		$this->render();
	}
	
	/* active account page */
	public function active_account()
	{
        try
        {			
				
			$activation_code = $this->uri->segment(3);
			$this->session->set_userdata('s_referred_code',$activation_code);	
			redirect(base_url().'user/registration/TWlOaFkzVT0');
			//exit;
			//redirect(base_url().'user/login/');
			
        }
		
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	 	    
    
	}	
	
	
	
	
	public function tradesman_recommend()
    {
        try
        {
			$this->i_sub_menu_id	=	20;			
			$this->data['pathtoclass']=$this->pathtoclass;
			
		  /* job count list*/
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
			
		  /* job count list*/
		  /* Radar Model*/
		  $this->load->model('radar_model');		  
		  $this->data['i_total_radar_job'] = $this->job_model->radar_job($this->user_id);
		  /**/
		  
		  /** Feed back count **/		 
		 /** Feed back count **/
		 
		  
			
			/* count feedback received */
		  $this->load->model('tradesman_model');
		  $this->data['profile_info'] = $this->tradesman_model->fetch_this($this->user_id);	
			
			
		  $this->data['breadcrumb'] = array(t('Recommend Us')=>'');
		  $this->add_css('css/fe/dd.css');
		  $this->add_js('js/fe/jquery.dd.js');
		  
		  if($_POST)
		  {
		  	
		  	$posted	=	array();
			foreach($_POST['email_arr'] as $emails)
			{
			 //$email	=	implode(',',$_POST['email_arr']);
			$emails = trim($emails);
			 	if(!empty($emails))
			 	$all_mail[]	=	$emails;
			 		 
			}
			
			//print_r($all_mail); exit;			
			foreach($_POST['name_arr'] as $names)
			{
				//$name	=	implode(',',$_POST['name_arr']);
				$names = trim($names);
			 	if(!empty($names))
			 	$all_name[]	=	$names;
				
			}
			$duplicate = false;
			$ar_recom = array();
			$ar_ext = array();
			$count=0;
			for($i=0;$i<count($all_mail);$i++)
			{				
				$i_newid = false;
				
				$s_verification_code	=	genVerificationCode();  // function written in common_helper
				$info["s_verification_code"] = $s_verification_code;	
				 $chk_val = $this->mod_recomm->check_email($all_mail[$i],$this->user_id);	
				if($chk_val==0)	
				{	
				$i_newid	=	$this->mod_recomm->add_info($all_mail[$i],$all_name[$i],$info,$this->user_id);
				}
				else
				{
					$duplicate = true;
					if($chk_val==1)	
					{
						$ar_recom[] = $all_mail[$i];
					}				
					elseif($chk_val==2)
					{
						$ar_ext[] = $all_mail[$i];
					}
				}
				 /* for referred verification mail to the user */
				   if($i_newid)
				   {
				   $count++;
				   $content = $this->mod_auto->fetch_contact_us_content('referral_mail','general');
				   
				   $filename = $this->config->item('EMAILBODYHTML')."common.html";
				   $handle = @fopen($filename, "r");
				   $mail_html = @fread($handle, filesize($filename));					
					//print_r($content); exit;
					if(!empty($content))
						{							
							$description = $content["s_content"];
							$description = str_replace("[referred name]",$all_name[$i],$description);	
							$description = str_replace("[Buyer/Service Professional name]", $user_details['user_name'],$description);								
							$description = str_replace("[##register_link##]",base_url().'home/active_account'.'/'.$s_verification_code,$description); 
							$description = str_replace("[site_url]",base_url(),$description);
							$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
						}
					//unset($content);
					
					$mail_html = str_replace("[site url]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
						
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
                    
                    $this->email->from($site_admin_email);	
									
                    $this->email->to($all_mail[$i]);
                    
                    //$this->email->subject('::: Referral mail :::');
					$this->email->subject($content['s_subject']);
					unset($content);
					
                    $this->email->message($mail_html);
					//echo "<br>DESC".$description;	exit;	
					 if(SITE_FOR_LIVE)///For live site
						{	
							//$this->session->set_userdata('s_verification_code',$s_verification_code);								
							$i_nwid = $this->email->send();																	
						}
					else
						{
							$i_nwid = TRUE;				
						}
				}	
				
				
			} // end for loop
		//	exit;
			 if($i_nwid)////saved successfully
				{      
					$msg =array();
					if($duplicate)
					{
						
						if(count($ar_recom)>0)
						{
							$s_email = implode(", ",$ar_recom);
							$msg[] = $s_email.t(" email(s) are already recomended by you.");
							//$this->session->set_userdata(array('message'=>$msg,'message_type'=>'err'));
						
						}
						if(count($ar_ext)>0)
						{
							$s_email = implode(", ",$ar_ext);
							$msg[] = $s_email.t(" email(s) are already registered.");
							//$this->session->set_userdata(array('message'=>$msg,'message_type'=>'err'));
						
						}
						
					}     
					if(count($msg)>0)      
						$s_part = implode(" <br/>",$msg).'<br/>';
					else
						$s_part = "";           
					$this->session->set_userdata(array('message'=>$s_part." ".$count.' '.$this->cls_msg["save_recommend"],'message_type'=>'succ'));
					redirect($this->pathtoclass."success_message");
				}
				else///Not saved, show the form again
				{
					$msg =array();
					if($duplicate)
					{
						
						if(count($ar_recom)>0)
						{
							$s_email = implode(", ",$ar_recom);
							$msg[] = $s_email.t(" email(s) are already recomended by you.");
							//$this->session->set_userdata(array('message'=>$msg,'message_type'=>'err'));
						
						}
						if(count($ar_ext)>0)
						{
							$s_email = implode(", ",$ar_ext);
							$msg[] = $s_email.t(" email(s) are already registered.");
							//$this->session->set_userdata(array('message'=>$msg,'message_type'=>'err'));
						
						}
						
					}     
					if(count($msg)>0)      
						$s_part = implode(" <br/>",$msg).'<br/>';
					else
						$s_part = "";        
					$this->session->set_userdata(array('message'=>$s_part.$this->cls_msg["save_recommend_err"],'message_type'=>'err'));
					redirect(base_url().'recommend/tradesman_recommend');
					//set_error_msg($this->cls_msg["save_recommend"]);
				}
		  }
		  
		    /* get tradesman referral history */
		  	$s_wh	=" WHERE n.i_referrer_id=".$this->user_id." ";
			$this->data['i_total_referred']	=	$this->mod_recomm->gettotal_info($s_wh);
			
			$s_where	=	" WHERE n.i_referrer_id=".$this->user_id." And n.i_is_active=1 ";
			$this->data['i_total_join'] = $this->mod_recomm->gettotal_info($s_where);
			
			$s_where	=	" WHERE n.i_referrer_id=".$this->user_id." And n.i_is_active=1 AND i_waiver_used=0";
			$this->data['i_not_used'] = $this->mod_recomm->gettotal_info($s_where);
			
			
			$this->load->model('commission_waiver_model');
		    $s_where_waiver = " WHERE i_is_active=1";
		    $comm = $this->commission_waiver_model->fetch_multi($s_where_waiver);
		    $this->data['i_total_comm_waiver'] = $comm[0]['i_waiver_commission'];
			
			//echo $this->data['i_not_used'].'<br>'.$this->data['i_total_comm_waiver'];
			$this->data['exemption'] = intval($this->data['i_total_join']/$this->data['i_total_comm_waiver']);
			$this->data['i_comm_free_waiver_status'] = floor($this->data['i_not_used']/$this->data['i_total_comm_waiver']);
			
			$this->data['remain_user'] = $this->data['i_total_join']-($this->data['exemption']*$this->data['i_total_comm_waiver']);
			$this->data['i_remain_user'] = $this->data['i_total_comm_waiver'] - $this->data['remain_user'];
		  //pr($comm);
		  
		  
		   /* for pagination and listing */
		  	$s_wh_recommend = " WHERE n.i_referrer_id=".$this->user_id." ";
		    $start = ($this->uri->segment($this->i_uri_seg)) ? $this->uri->segment($this->i_uri_seg) : 0;
			$limit	= $this->i_fe_page_limit;
			$this->data['rec_list']	=	$this->mod_recomm->fetch_multi($s_wh_recommend,intval($start), $limit);
			
			//print_r($this->data['pmb_list']);			
			
			$i_total_no = $this->mod_recomm->gettotal_info($s_wh_recommend);
			$s_pageurl = base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
			$i_uri_segment = $this->i_fe_uri_segment;
			
			$this->data['pagination'] = $this->get_fe_pagination($s_pageurl,$i_total_no,$limit,$i_uri_segment);
		  
		
		  $this->render('recommend/tradesman_recommend');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
  
	

    public function __destruct()

    {}           

}