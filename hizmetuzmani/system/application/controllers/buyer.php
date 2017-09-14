<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 31 March 2012
* Modified By: 
* Modified Date: 
* 
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class Buyer extends My_Controller
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
	public $uploaddir;
    public $thumbdir;
    public $showimgdir;
	public $thumbDisplayPath;
	private $user_id;

    public function __construct()
    {
        try
        { 
		  parent::__construct(); 
          $this->data['title']="buyer";////Browser Title
		  $this->data['ctrlr'] = "buyer";
		  //pr(  $this->data['loggedin']); exit;
		  if(empty( $this->data['loggedin']) || decrypt($this->data['loggedin']['user_type_id'])!=1)
			{
				redirect(base_url()."home");
				exit;
			}
		  
		  $this->cls_msg=array();
		  $this->cls_msg["save_pwd"]			= addslashes(t("password changed successfully."));
		  $this->cls_msg["save_pwd_err"]		= addslashes(t("password changed could not saved."));
		  $this->cls_msg["wrong_pwd"]			= addslashes(t("existing password does not match."));		  
		  $this->cls_msg["save_comment"]		= addslashes(t("comment saved successfully."));
		  $this->cls_msg["save_comment_err"]	= addslashes(t("failed to save comment."));		  
		  $this->cls_msg["save_email_setting"]	= addslashes(t("email setting saved successfully."));		  
		  $this->cls_msg["save_contact"] 		= addslashes(t("contact details saved succesfully"));
		  $this->cls_msg["save_contact_err"] 	= addslashes(t("contact details failed to save"));
		  $this->cls_msg["save_profile"] 		= addslashes(t("profile details saved succesfully"));
          $this->cls_msg["save_profile_err"]    = addslashes(t("profile details could not saved"));
		  $this->cls_msg["save_invite"] 	    = addslashes(t("Tradesmans invited succesfully for "));
		  		  
		  $this->cls_msg["save_testi"]			= addslashes(t("testimonial saved successfully."));
		  $this->cls_msg["save_testi_err"]		= addslashes(t("testimonial saved failure."));		  	  
		  $this->cls_msg["save_job_quote"]		= addslashes(t("Quote days saved successfully."));
		  $this->cls_msg["save_job_quote_err"]	= addslashes(t("Quote days saved failure."));		  
		  $this->cls_msg["invalid_job_err"] 	= addslashes(t("Job not exist."));
		  $this->cls_msg["job_del"] 			= addslashes(t("Job deleted successfully."));
		  $this->cls_msg["job_del_err"] 		= addslashes(t("Job not deleted."));		  
		  $this->cls_msg["job_assign"] 			= addslashes(t("Quote accepted successfully."));
		  $this->cls_msg["job_assign_err"] 		= addslashes(t("Quote acceptance failed."));		  
		  $this->cls_msg["job_terminate"] 		= addslashes(t("Job terminated successfully."));
		  $this->cls_msg["job_terminate_err"] 	= addslashes(t("Job termination failed."));
		  $this->cls_msg["job_complete"]		= addslashes(t('Job completed sucessfully'));
		  $this->cls_msg["job_incomplete"]		= addslashes(t('Job not completed'));
		  $this->cls_msg["job_not_complete"]	= addslashes(t('Job denied successfully to be complete.'));
		  $this->cls_msg["job_not_complete_err"]= addslashes(t('Job denied save to failed.'));
		  $this->cls_msg["quote_period"]		= addslashes(t('Job has been edited successfully'));
		  $this->cls_msg["err_quote_period"]	= addslashes(t('Job edit failed to save'));
		  $this->cls_msg["quote_reject"]		= addslashes(t('Quote has been rejected successfully'));
		  $this->cls_msg["quote_reject_err"]	= addslashes(t('Quote rejected failed to save'));
          
          $this->cls_msg["save_recommend"]  =   addslashes(t("recommend(s) send successfully."));

		  
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  $this->load->model('manage_buyers_model','mod_buyer');
		  $this->load->model('tradesman_model','mod_td');
          $this->load->model('job_model');    
		  $this->load->model('common_model','mod_common');	
		  
		  $user_details = $this->data['loggedin'];
		  $this->data['name']	=	$user_details['user_name'];
		  $this->user_id 		=	decrypt($user_details['user_id']);
		 
          /*************** Start job count list *****************/
          
          $s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_is_deleted!=1 "; 
          $info    =  $this->job_model->gettotal_jobs_user($s_where);
          $i_total      =   0;
          $i_assign     =   0;
          $i_active     =   0;
          $i_complete   =   0;
          $i_expire     =   0;

          if(!empty($info))
          {
              foreach($info as $val)
              {
                  if($val['i_status']   == 1)
                  {
                      $i_active += 1;
                      $i_total  += 1;
                  }
                  else if($val['i_status']   == 4 || $val['i_status']   == 5 || $val['i_status']   == 8 || $val['i_status'] == 11)
                  {
                      $i_assign += 1;
                      $i_total  += 1;
                  }
                  else if($val['i_status']   == 6)
                  {
                      $i_complete += 1;
                      $i_total  += 1;
                  }
                  else if($val['i_status']   == 7)
                  {
                      $i_expire += 1;
                      $i_total  += 1;
                  }
				  else if($val['i_status']   == 9)
                  {                      
                      $i_total  += 1;
                  }
				  else if($val['i_status']   == 2 || $val['i_status']   == 3 || $val['i_status']   == 10)
                  {                      
                      $i_total  += 1;
                  }
                  
              }
          }
          $arr_jobs['i_total']     =    $i_total ;   
          $arr_jobs['i_assign']    =    $i_assign ;   
          $arr_jobs['i_active']    =    $i_active ;   
          $arr_jobs['i_complete']  =    $i_complete ;   
          $arr_jobs['i_expire']    =    $i_expire ; 
          
          $this->data['job_count']  =   $arr_jobs ;  
          
          /*************** End job count list *****************/
          
		  /* profile Image */
		  $this->allowedExt = 'jpg|jpeg|png';	
		  $this->uploaddir = $this->config->item('user_profile_image_upload_path');	
		  $this->thumbdir = $this->config->item('user_profile_image_thumb_upload_path');
		  $this->thumbDisplayPath = $this->config->item('user_profile_image_thumb_path');
		  $this->thumb_ht = $this->config->item('user_profile_photo_upload_thumb_height');	
		  $this->thumb_wd = $this->config->item('user_profile_photo_upload_thumb_width');
          
          $this->load->model('manage_private_message_model','mod_pmb');
          $s_where  =   " WHERE i_receiver_id=".$this->user_id." AND i_receiver_view_status = 0 ";
          $this->data['i_new_message']  =   $this->mod_pmb->gettotal_msg_info($s_where);
		  
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
			
			//$this->i_menu_id = 1;
			redirect('buyer/dashboard');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
	
    public function dashboard()
    {
        try
        {		
			$this->data['pathtoclass']=$this->pathtoclass;
			$this->data['breadcrumb'] = array(addslashes(t('Dashboard'))=>'');
			$this->data['dt_current_time'] = date("l j-M-Y H:i T",time());
            
            
			$start = 0;
			$limit = 5;
			$s_where = " WHERE n.i_buyer_user_id={$this->user_id} AND n.i_status=1 AND n.i_is_deleted!=1 "; 
			$this->data['open_jobs'] = $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);
			//pr($this->data['open_jobs'],1);
			
			/* tradesman declared the job as complete and asked for complete */
			$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_status=5 AND n.i_is_deleted!=1 "; 			
		    $this->data['feedback_job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);		
			//pr($this->data['feedback_job_list'],1);
            
            $this->load->model('manage_private_message_model','mod_pmb');
            
            $s_where    =   " WHERE i_receiver_id=".$this->user_id." AND i_receiver_view_status=0 " ;
            $this->data['i_new_msg']  =   $this->mod_pmb->gettotal_msg_info($s_where) ;
            unset($s_where);
			
			/* total new quotes */
			$i_total_quotes = 0;
			if(!empty($this->data['open_jobs']))
			{
				foreach($this->data['open_jobs'] as $val)
				{
					$s_where = " WHERE n.i_job_id = ".$val['id']." AND n.i_status = 1 ";
					$i_total_quotes+= $this->job_model->gettotal_quote_info($s_where);
				}
			}
            $this->data['i_new_quotes'] = $i_total_quotes;
			/* total new quotes */
			$this->render('buyer/dashboard');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }		
	
	
	
	public function edit_profile()
    {
        try
        {
			$this->left_menu	=	1;
			$this->data['pathtoclass']=$this->pathtoclass;
			$user_details = $this->session->userdata('loggedin');
			$this->data['user_id']	=	$user_details['user_id'];
			$this->data['info']	=	$this->mod_buyer->fetch_this($this->user_id);
			//pr($this->data['info']);
			$image_exist	=	$this->data['info']['image'][0]['s_user_image']; 
			$this->data['breadcrumb'] = array(t('Edit Profile')=>'');
			//print_r($this->data['info']); exit;
			
			$this->load->model('city_model');
			$this->load->model('province_model');
			$this->load->model('zipcode_model');
			
			if($_POST)
			{				
				$posted=array();
                $posted["txt_name"]			= trim($this->input->post("txt_name"));
				$posted["txt_email"]		= trim($this->input->post("txt_email"));
				$posted["txt_address"]		= trim($this->input->post("txt_address"));
				$posted["opt_province_id"]	= trim($this->input->post("opt_state"));
				$posted["opt_city_id"]		= trim($this->input->post("opt_city"));
				$posted["i_zipcode_id"]		= trim($this->input->post("opt_zip"));
				$posted["chk_newletter"]	= trim($this->input->post("chk_newletter"));
				$posted["h_image_name"]		= trim($this->input->post("h_image"));
				
				//print_r($posted); exit;
				
				if(isset($_FILES['f_image']) && !empty($_FILES['f_image']['name']))
				{
					$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'f_image','','',$this->allowedExt);					
					$arr_upload_res = explode('|',$s_uploaded_filename);
				}
				
				
				$this->form_validation->set_rules('txt_name', addslashes(t('name')), 'required');
				$this->form_validation->set_rules('txt_email', addslashes(t('email')), 'valid_email|required');
				$this->form_validation->set_rules('txt_address', addslashes(t('address')), 'required');
                $this->form_validation->set_rules('opt_state', addslashes(t('province')), 'required');
				$this->form_validation->set_rules('opt_city', addslashes(t('city')), 'required');
				//$this->form_validation->set_rules('txt_zip', addslashes(t('zip code')), 'required');
				
				
				//print_r($arr_upload_res); exit;
				
				 if($this->form_validation->run() == FALSE || ($arr_upload_res[0]==='err'))/////invalid
					{
						///Display the add form with posted values within it////
						$this->data["posted"]=$posted;
					}
				else
					{
						
						$info=array();
						$info["s_name"]			=	$posted["txt_name"];
						$info["s_email"]		=	$posted["txt_email"];
						$info["s_address"]		=	$posted["txt_address"];
						$info["i_province_id"]	=	decrypt($posted["opt_province_id"]);
						$info["i_city_id"]		=	decrypt($posted["opt_city_id"]);
						$info["i_zipcode_id"]	=	decrypt($posted["i_zipcode_id"]);
						$info["chk_newletter"]	=	$posted["chk_newletter"];
						$info["i_edited_date"]	=	time();
						
						if(count($arr_upload_res)==0)
						{
							$info["s_user_image"] = 	$posted['h_image_name'];
						}
						else
						{
							$info["s_user_image"] = 	$arr_upload_res[2];
						}
						
						/* start  latitude and longitude  */
					$state = $this->province_model->fetch_this($info["i_province_id"]);
					$city = $this->city_model->fetch_this($info["i_city_id"]);
					$zipcode = $this->zipcode_model->fetch_this($info["i_zipcode_id"]);
					
				 	
					$info['s_lat'] = $zipcode['latitude'];
    				$info['s_lng'] = $zipcode['longitude'];	
						
						
					//print_r($info); echo$this->user_id; exit;
					$i_newid = $this->mod_buyer->set_edit_profile($info,$this->user_id);
					
					$this->load->model('newsletter_subscribers_model');
					if($info['chk_newletter']==1)
					{
						
						$s_sub = " WHERE n.s_email='".$info['s_email']."' ";
						$is_subscribed = $this->newsletter_subscribers_model->gettotal_info($s_sub);
						if($is_subscribed<=0)
						{
						$info['i_user_type'] = 1;
						$info['i_status'] = 1;
						$info['i_user_id'] = $this->user_id;
						$info['dt_entry_date'] = time();							
						$chk_id = $this->newsletter_subscribers_model->add_info($info);
						}
					}
					else
					{
						$s_sub = " WHERE n.s_email='".$info['s_email']."' ";
						$is_subscribed = $this->newsletter_subscribers_model->fetch_multi($s_sub,0,1);
						if(count($is_subscribed)>0)
						{
							//Delete The subcription
							$i_id = $is_subscribed[0]['id'];
							$this->newsletter_subscribers_model->delete_newsletter_info($i_id);
						}
						
					}
					
					//echo $i_newid; exit;
					if($i_newid)////saved successfully
					{
						
						if($arr_upload_res[0]==='ok')
						{
							get_image_thumb($this->uploaddir.$info["s_user_image"], $this->thumbdir, 'thumb_'.$info["s_user_image"],$this->thumb_ht,$this->thumb_wd,'');
						}						
						
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_profile"],'message_type'=>'succ'));
						redirect(base_url().'buyer/edit-profile');
					}
					else///Not saved, show the form again
					{
					$this->session->set_userdata(array('message'=>$this->cls_msg["save_profile_err"],'message_type'=>'err'));
					redirect(base_url().'buyer/edit-profile');
					}
						
					
					}					
			
			}		

            $info   =   $this->mod_buyer->fetch_this(decrypt($this->data['user_id']));
            //pr($info);
            $posted['txt_name']         =   $info['s_name'];
            $posted['txt_email']        =   $info['s_email'];
            $posted['txt_address']      =   $info['s_address'];
            $posted['txt_zip']          =   $info['s_zip'];
            $posted['opt_city']         =   encrypt($info['opt_city']);
            $posted['opt_province']     =   encrypt($info['opt_province']);
			$posted['opt_zip']         	=   encrypt($info['opt_zip']);
            
            //$posted['s_user_image']     =   $info['image'][0]['s_user_image'];
			$posted['s_user_image']     =   $info['s_image'];
            $posted['chk_newsletter']   =   $info['chk_newsletter'];
            
            $this->data['thumbPath']    =   $this->thumbDisplayPath ;
            
			/* get province list with selected city */
				$this->load->model('common_model','mod_common');
				$tablename      =   $this->db->PROVINCE ;
				$arr_where      =   array('i_city_id'=>decrypt($posted["opt_city"])) ;
				$info_province  =   $this->mod_common->common_fetch($tablename,$arr_where);
				
				if(!empty($info_province))
				{
					$arr_province   =   array();
					foreach($info_province as $val)
					{
						$arr_province[$val['id']]   =   $val['province'] ; 
					}
				}
				
				$this->data['arr_province'] =   $arr_province ;
				
			  /* end get province list with selected city */
			  
			  /* get zipcode list with selected city and province*/
			   $tablename		=	$this->db->ZIPCODE;
			   $arr_where		=	array('city_id'=>decrypt($posted["opt_city"]),'province_id'=>decrypt($posted["opt_province"])) ;
			   $info_zipcode  =   $this->mod_common->common_fetch($tablename,$arr_where);
				
				if(!empty($info_zipcode))
				{
					$arr_zipcode   =   array();
					foreach($info_zipcode as $val)
					{
						$arr_zipcode[$val['id']]   =   $val['postal_code'] ; 
					}
				}
				
				$this->data['arr_zipcode'] =   $arr_zipcode ;
				
				/* get zipcode list with selected city and province*/
            
            $this->data['posted']   =   $posted   ;

			$this->render('buyer/edit_profile');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
	
	
	public function change_password()
    {
        try
        {
			$this->left_menu	=	2;
			$user_details 				= $this->session->userdata('loggedin');
			$this->data['user_id']		=	$user_details['user_id'];
			$this->data['breadcrumb'] 	= array(addslashes(t('Change Password'))=>'');
			
			if($_POST)
			{
				$posted=array();
                $posted["txt_password"]			= trim($this->input->post("txt_password"));
				$posted["txt_new_password"]		= trim($this->input->post("txt_new_password"));
				$posted["txt_confirm_password"]	= trim($this->input->post("txt_confirm_password"));
				
				if(!empty($posted["txt_password"]) && !empty($posted["txt_new_password"]))
				{
					$this->form_validation->set_rules('txt_password', addslashes(t('existing password')), 'required|callback_authentication_check');
					$this->form_validation->set_rules('txt_new_password', addslashes(t('New password')), 'required|matches[txt_confirm_password]');
					$this->form_validation->set_rules('txt_confirm_password', addslashes(t('Confirm password')), 'required');
				}
				
				$user_data['s_password']	=	$posted["txt_password"];
				$is_pwd_correct	=	$this->mod_buyer->check_password($user_data['s_password'],$this->user_id);
				
				 if($this->form_validation->run() == FALSE || empty($is_pwd_correct))/////invalid
					{
						if(empty($is_pwd_correct))
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["wrong_pwd"],'message_type'=>'err'));
							redirect(base_url().'buyer/change-password');
							//$this->render('buyer/change_password');
						}
						///Display the add form with posted values within it////
						$this->data["posted"]=$posted;
					}
				else
					{
						
						$info=array();
						if(!empty($posted["txt_password"]) && !empty($posted["txt_new_password"]))
						{
							$info["s_password"]	=$posted["txt_new_password"];
						}
						
						$i_newid = $this->mod_buyer->set_new_password($info,$this->user_id );
						if($i_newid)////saved successfully
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_pwd"],'message_type'=>'succ'));	
							redirect(base_url().'buyer/change-password');
						}
						else///Not saved, show the form again
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_pwd_err"],'message_type'=>'err'));
							$this->render('buyer/change-password');
						}
						
					
					}	
				
			}
			
			$this->render('buyer/change_password');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	public function contact_details()
    {
        try
        {					
			$this->left_menu=3;	
			$this->data['breadcrumb'] 		= array(addslashes(t('Contact Details'))=>'');
			$this->data['contact_details']	=	$this->mod_buyer->fetch_this($this->user_id);	
			$gsm_arr = $this->data['contact_details']['s_contact_no']!=''?explode('-',$this->data['contact_details']['s_contact_no']):"";
			$this->data['gsm_code'] = $gsm_arr[0];
			$this->data['gsm_no']   = $gsm_arr[1];
			
			if($_POST)
			{			
				$posted=array();
                //$posted["txt_contact"]	= trim($this->input->post("txt_contact"));
				$posted['txt_gsm']		=	trim($this->input->post("txt_gsm"));
				$posted['opt_gsm']		=	trim($this->input->post("opt_gsm"));
				$posted["i_sm"]			= 	trim($this->input->post("social_media"));
				$posted["txt_sm"]		= 	trim($this->input->post("txt_sm"));
				$posted["i_sm2"]		= 	trim($this->input->post("social_media2"));
				$posted["txt_sm2"]		= 	trim($this->input->post("txt_sm2"));
				$posted["i_sm3"]		= 	trim($this->input->post("social_media3"));
				$posted["txt_sm3"]		= 	trim($this->input->post("txt_sm3"));	
				
				$this->form_validation->set_rules('txt_gsm', addslashes(t('contact number')), 'required');
				
				 if($this->form_validation->run() == FALSE)/////invalid
					{
						$this->data["posted"]=$posted;
					}
				else
					{
						
						$info=array();
						//$info["s_contact_no"]	=	$posted["txt_contact"];
						$info["s_contact_no"]=!empty($posted["txt_gsm"])?decrypt($posted['opt_gsm']).'-'.$posted["txt_gsm"]:"";	
						$info["i_sm"]			=	$posted["i_sm"];	// social media options like skype, msn, yahoo
						$info["s_sm"]			=	$posted["txt_sm"];	
						$info["i_sm2"]			=	$posted["i_sm2"];
						$info["s_sm2"]			=	$posted["txt_sm2"];
						$info["i_sm3"]			=	$posted["i_sm3"];
						$info["s_sm3"]			=	$posted["txt_sm3"];
						
						//pr($info,1);
						$i_newid = $this->mod_buyer->set_contact_details($info,$this->user_id);
						if($i_newid)////saved successfully
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_contact"],'message_type'=>'succ'));
							redirect(base_url().'buyer/contact-details');
						}
						else///Not saved, show the form again
						{
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_contact_err"],'message_type'=>'err'));
						//$this->render('tradesman/contact-details/');
						$this->data["posted"]=$posted;
						}
						
					
					}	
				
			
			}
			
				
			$this->render('buyer/contact_details');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
	
	public function edit_job($i_job_id='')
    {
        try
        {
			
			//$user_details 				= $this->session->userdata('loggedin');
			
			$this->data['user_id']		=	$user_details['user_id'];
			$this->data['breadcrumb'] 	= array(addslashes(t('Edit Job'))=>'');
			$job = array();
			if(decrypt($i_job_id)!='')
			{
				$job_id = decrypt($i_job_id);
				$job_detail = $this->job_model->fetch_this($job_id);
				if(empty($job_detail))
				{
					$this->session->set_userdata(array('message'=>$this->cls_msg["invalid_job_err"],'message_type'=>'err'));
					redirect(base_url().'home/message');
				}
				$job['quote_period'] = $job_detail['i_quoting_period_days'];
				$job['job_id'] = 	$i_job_id;		
			}
			
			if($_POST)
			{
				$posted=array();
                $posted["quote_period"]			= trim($this->input->post("quote"));				
				$this->form_validation->set_rules('quote', addslashes(t('quote period')), 'required');
			
				 if($this->form_validation->run() == FALSE)/////invalid
					{						
						///Display the add form with posted values within it////
						$this->data["posted"]=$posted;
					}
				else
					{						
						$info=array();						
						$info["i_quoting_period_days"] = decrypt($posted["quote_period"]);
						$quote_days = 	$info["i_quoting_period_days"]*7;
						$info["i_expire_date"]	=	strtotime("+ {$quote_days} day", $job_detail['i_approval_date']);	
						$s_table = $this->db->JOBS;	
									
						$i_aff = $this->job_model->set_data_update($s_table,$info,$job_id);
						if($i_aff)////saved successfully
						{
						$this->session->set_userdata(array('message'=>$this->cls_msg["quote_period"],'message_type'=>'succ'));	
						redirect(base_url().'buyer/edit-job/'.$i_job_id);
						}
						else///Not saved, show the form again
						{
						$this->session->set_userdata(array('message'=>$this->cls_msg["err_quote_period"],'message_type'=>'err'));
						$this->render('buyer/edit-job/'.$i_job_id);
						}
						
					
					}	
				
			}
			$this->data['posted'] = $job;
			$this->render('buyer/buyer_edit_job');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	/********************************** start of my jobs section of buyer account **********************************/
	/* fetch all jobs*/
   public function all_jobs()
   {
   		try
		{
			$this->left_menu	=	5;
			$this->data['breadcrumb'] = array(addslashes(t('All Jobs'))=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			
			if($_POST)
			{
				$sessArrTmp['i_category_id']  	= decrypt(trim($this->input->post('category')));				
				$sessArrTmp['opt_status'] 		= decrypt(trim($this->input->post('opt_status')));
			}  
			$this->session->set_userdata(array('model_session'=>$sessArrTmp));	// to store data in session
			$this->data['posted'] = $sessArrTmp;
			
			ob_start();
			$this->all_jobs_pagination_ajax();
			$job_contents = ob_get_contents();
			ob_end_clean();
			$this->data['job_contents'] = $job_contents;
			$this->render();
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
   }
   
   /* Ajax pagination for all jobs */
	function all_jobs_pagination_ajax($start=0) {	
	
		//$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_status!=0 AND n.i_is_deleted!=1 ";
		$s_where = '';
		$arr_search[] = " n.i_buyer_user_id = {$this->user_id} AND n.i_status!=0 AND n.i_is_deleted!=1 ";
		$sessArrTmp['i_category_id']  	= $this->get_session_data('i_category_id');
		$sessArrTmp['opt_status'] 		= $this->get_session_data('opt_status');
		//pr($sessArrTmp['opt_status'],1);
		if($sessArrTmp['i_category_id'])
		{
			$arr_search[] =" n.i_category_id=".$sessArrTmp['i_category_id'];
		}	
		if($sessArrTmp['opt_status'])
		{
			
			if($sessArrTmp['opt_status']==3)
			{
			$arr_search[] = '(n.i_status=4 OR n.i_status=5 OR n.i_status=8 OR n.i_status=11)';
			}
			else
			{
			$arr_search[] =" n.i_status=".$sessArrTmp['opt_status'];
			}
		}
		
		$s_where .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
		
		$limit	= $this->i_fe_page_limit ;			
		$this->data['job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);
		$total_rows 			= $this->job_model->gettotal_info($s_where);	
		//pr($this->data['job_list'],1);
					
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'buyer/all_jobs_pagination_ajax/';
		$paging_div = 'job_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		$this->load->view('fe/buyer/ajax_all_jobs.tpl.php',$this->data);
			
	}	 
	
	/* all quotes placed for jobs */
	public function all_quotes()
   {
   		try
		{
			$this->left_menu	=	15;
			$this->data['breadcrumb'] = array(addslashes(t('Job Quotes'))=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			
			ob_start();
			$this->all_quotes_pagination_ajax();
			$job_contents = ob_get_contents();
			ob_end_clean();
			$this->data['job_contents'] = $job_contents;
			$this->render();
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
   }
   
   /* Ajax pagination for all quotes */
	function all_quotes_pagination_ajax($start=0) {	
	
		$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_is_deleted!=1 AND n.i_status=1 ";
		$limit	= $this->i_fe_page_limit ;			
		$this->data['job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);
		$total_rows 			= $this->job_model->gettotal_info($s_where);	
		//pr($this->data['job_list'],1);
					
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'buyer/all_quotes_pagination_ajax/';
		$paging_div = 'job_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		$this->load->view('fe/buyer/ajax_all_quotes.tpl.php',$this->data);
			
	}	 
	
	
	
	
	/* fetch active jobs*/
   public function active_jobs()
   {
   		try
		{
			$this->left_menu	=	6;
			$this->data['breadcrumb'] = array(addslashes(t('Active Jobs'))=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			
			ob_start();
			$this->active_jobs_pagination_ajax();
			$job_contents = ob_get_contents();
			ob_end_clean();
			$this->data['job_contents'] = $job_contents;
			$this->render();
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
   }
   
   /* Ajax pagination for active jobs */
	function active_jobs_pagination_ajax($start=0) {	
	
		$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_is_deleted!=1 AND n.i_status=1 ";
		$limit	= $this->i_fe_page_limit;			
		$this->data['job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);
		$total_rows 			= $this->job_model->gettotal_info($s_where);	
		//pr($this->data['job_list'],1);
				
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'buyer/active_jobs_pagination_ajax/';
		$paging_div = 'job_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		$this->load->view('fe/buyer/ajax_active_jobs.tpl.php',$this->data);
			
	}	
	
	/* fetch assigned jobs*/
   public function assigned_jobs()
   {
   		try
		{
			$this->left_menu	=	7;
			$this->data['breadcrumb'] = array(addslashes(t('Assigned Jobs'))=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			
			ob_start();
			$this->assigned_jobs_pagination_ajax();
			$job_contents = ob_get_contents();
			ob_end_clean();
			$this->data['job_contents'] = $job_contents;
			$this->render();
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
   }
   
   /* Ajax pagination for assigned jobs */
	function assigned_jobs_pagination_ajax($start=0) {	
	
		$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_is_deleted!=1 AND (n.i_status=4 OR n.i_status=5 OR n.i_status=8 OR n.i_status=11) ";
		
		$limit	= $this->i_fe_page_limit;			
		$this->data['job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);
		$total_rows 			= $this->job_model->gettotal_info($s_where);	
		//pr($this->data['job_list'],1);
					
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'buyer/assigned_jobs_pagination_ajax/';
		$paging_div = 'job_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		$this->load->view('fe/buyer/ajax_assigned_jobs.tpl.php',$this->data);
			
	}	
	
	
	/* fetch completed jobs*/
   public function completed_jobs()
   {
   		try
		{
			$this->left_menu	=	8;
			$this->data['breadcrumb'] = array(addslashes(t('Completed Jobs'))=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			
			ob_start();
			$this->completed_jobs_pagination_ajax();
			$job_contents = ob_get_contents();
			ob_end_clean();
			$this->data['job_contents'] = $job_contents;
			$this->render();
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
   }
   
   /* Ajax pagination for completed jobs */
	function completed_jobs_pagination_ajax($start=0) {	
	
		$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_is_deleted!=1 AND n.i_status=6 ";
		//$s_where = " WHERE 1";
		
		$limit	= $this->i_fe_page_limit;			
		$this->data['job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);
		$total_rows 			= $this->job_model->gettotal_info($s_where);	
		//pr($this->data['job_list'],1);
					
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'buyer/completed_jobs_pagination_ajax/';
		$paging_div = 'job_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		$this->load->view('fe/buyer/ajax_completed_jobs.tpl.php',$this->data);
			
	}	
	
	
	/* fetch expired jobs*/
   public function expired_jobs()
   {
   		try
		{
			$this->left_menu	=	9;
			$this->data['breadcrumb'] = array(addslashes(t('Expired Jobs'))=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			
			ob_start();
			$this->expired_jobs_pagination_ajax();
			$job_contents = ob_get_contents();
			ob_end_clean();
			$this->data['job_contents'] = $job_contents;
			$this->render();
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
   }
   
   /* Ajax pagination for expired jobs */
	function expired_jobs_pagination_ajax($start=0) {	
	
		$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_is_deleted!=1 AND n.i_status=7 ";
		//$s_where = " WHERE 1";
		
		$limit	= $this->i_fe_page_limit;			
		$this->data['job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);
		$total_rows 			= $this->job_model->gettotal_info($s_where);	
		//pr($this->data['job_list'],1);
					
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'buyer/expired_jobs_pagination_ajax/';
		$paging_div = 'job_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		$this->load->view('fe/buyer/ajax_expired_jobs.tpl.php',$this->data);
			
	}	
	
	
	
	function job_quotes($i_job_id='')
	{
		$i_job_id = decrypt($i_job_id);
		$this->data['breadcrumb'] = array(addslashes(t('Job Quotes'))=>'');	
		$this->left_menu	=	15;
		$this->data['pathtoclass'] = $this->pathtoclass;
		$this->data['job_details'] = $this->job_model->fetch_this($i_job_id);
		
		$this->session->set_userdata('i_job_quote_id',$i_job_id);
		ob_start();
		$this->quote_jobs_pagination_ajax();
		$job_contents = ob_get_contents();
		ob_end_clean();
		$this->data['job_contents'] = $job_contents;
		
		$this->render();
	
	}
	
	
	 /* Ajax pagination for quotes on jobs */
	function quote_jobs_pagination_ajax($start=0) {	
	
		if($this->session->userdata('i_job_quote_id')!='')
		{
		$i_job_id = $this->session->userdata('i_job_quote_id');
		}
		//$s_where = "  WHERE n.i_job_id={$i_job_id} AND 	n.i_status!=3 ";
		$s_where = "  WHERE n.i_job_id={$i_job_id} AND 	n.i_status!=0 ";
		//$s_where = " WHERE 1";
		
		$limit	= $this->i_fe_page_limit;			
		$this->data['job_list']	= $this->job_model->fetch_quote_multi($s_where,intval($start),$limit);
		$total_rows 			= $this->job_model->gettotal_quote_info($s_where);	
		//pr($this->data['job_list'],1);
					
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'buyer/quote_jobs_pagination_ajax/';
		$paging_div = 'job_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		$this->load->view('fe/buyer/ajax_job_quotes.tpl.php',$this->data);
			
	}
	
	
	/********************************** end of my jobs section of buyer account *********************************/
	
	public function testimonial()
    {
        try
        {
			$this->left_menu	=	14;	
			$user_details 		= $this->session->userdata('loggedin');
			$user_name			=	$user_details['user_name'];
			$this->data['breadcrumb'] = array(addslashes(t('My Testimonial'))=>'');
			//print_r($user_details);
			$this->data['user_id']	=	$user_details['user_id'];
			if($_POST)
			{
				
				$posted=array();
                $posted["ta_content"]= trim($this->input->post("ta_content"));				
				
				$this->form_validation->set_rules('ta_content', addslashes(t('testimonial')), 'required');
				
				
				 if($this->form_validation->run() == FALSE)/////invalid
					{
						///Display the add form with posted values within it////
						$this->data["posted"]=$posted;
					}
				else
					{
						
						$info=array();
						$info["s_content"]	=	$posted['ta_content'];
						$info['i_created_date'] = time();
						
						$i_newid = $this->mod_buyer->add_new_testimonial($info,$user_name);
						if($i_newid)////saved successfully
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_testi"],'message_type'=>'succ'));
							redirect(base_url().'buyer/testimonial');
						}
						else///Not saved, show the form again
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_testi_err"],'message_type'=>'err'));
							$this->render('buyer/testimonial');
						}
						
					
					}	
				
			
			}
			
			ob_start();
			$this->ajax_pagination_testimonial(0,1);
			$contents = ob_get_contents();
			ob_end_clean();
			$testi = explode('^',$contents);			
			$this->data['testimonial'] 	  = $testi[0];
			
			$this->render('buyer/testimonial');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	function ajax_pagination_testimonial($start=0,$param=0) 
	{	
		$s_where='';
		$user_details 	= $this->session->userdata('loggedin');
		$user_id		=	decrypt($user_details['user_id']);
		$user_name		=	decrypt($user_details['user_name']);
		$s_where 		= " WHERE n.s_person_name='".$user_details['user_name']."' "; 
		$limit			=  $this->i_fe_page_limit = 5;
		
		$this->data['testimonial'] 	= $this->mod_buyer->fetch_testimonial($s_where,intval($start),$limit);	
		//pr($this->data['testimonial'],1);
		$this->load->model('testimonial_model');
		$total_rows 				= $this->testimonial_model->gettotal_info($s_where);
		
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'buyer/ajax_pagination_testimonial/';
		$paging_div = 'testimonial_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		if(empty($param))
			$job_vw = $this->load->view('fe/buyer/ajax_pagination_testimonial.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/buyer/ajax_pagination_testimonial.tpl.php',$this->data,TRUE).'^'.$total_rows;
		echo $job_vw;
		/* pagination end */

	
	}
	
	
	/* accept quote of a tradesman 
	* author @ mrinmoy
	*/
	
	public function tradesman_assign_job()
	{
		
		if($_POST)
		{
			$info = array();
			$str			= trim($this->input->post("data_str"));
			$data_str		= explode(',',$str);
			
			$i_quote_id 	= decrypt($data_str[0]);
			$i_job_id 		= decrypt($data_str[1]);			
			$i_tradesman_id = decrypt($data_str[2]);
			
			
			$info['i_tradesman_id'] = $i_tradesman_id;
			$info['i_quote_id'] 	= $i_quote_id;
			$info['i_status'] 		= 8; // frozen
			$info['i_assigned_date'] = time();
						
			/** UPDATE QUOTE STATUS */
			$arr1 = array();
			$arr1['i_status']  =  2; //Accepted
			$table = $this->db->JOBQUOTES;
			$new = $this->job_model->set_data_update($table,$arr1,$i_quote_id);
			/**END  UPDATE QUOTE STATUS */
			$i_newid = $this->job_model->assign_job_to_tradesman($info,$i_job_id);
			//$i_newid = true;
			if($i_newid)
			{			
				/* insert data to job history and stattus change*/
				$arr1 = array();
				$arr1['i_job_id']  =  $i_job_id;
				//$arr1['i_user_id'] =  $this->user_id;
				$arr1['i_user_id'] =  $i_tradesman_id;
				$arr1['s_message'] =  'job_assigned';
				$arr1['i_created_date'] =  time();
				$table = $this->db->JOB_HISTORY;
				$this->job_model->set_data_insert($table,$arr1);	
				/*============*/
				$arr1 = array();
				$arr1['i_job_id']  =  $i_job_id;
				$arr1['i_user_id'] =  $this->user_id;
				$arr1['s_status'] =  'Frozen';
				$arr1['i_created_date'] =  time();
				$table = $this->db->JOB_STATUS_HISTORY;
				$this->job_model->set_data_insert($table,$arr1);	
				/* end */		
				
				/* insert data tradesman action history table */
				$arr2 = array();
				$arr2['i_user_id'] 		= $i_tradesman_id;
				$arr2['i_job_id'] 		= $i_job_id;
				$arr2['s_action']  		= 'awarded_job';
				$arr2['i_created_date']	= time();
				$table_history = $this->db->TRADESMANHISTORY;
				$this->job_model->set_data_insert($table_history,$arr2);
				unset($table_history,$arr2);						
				/* insert data tradesman action history table */									
				
			   /* for job quote mail to the user */			   
			   $this->load->model('job_model');
			   $s_where 	= " WHERE n.i_tradesman_user_id={$i_tradesman_id} AND n.i_job_id={$i_job_id} ";
			   $job_details = $this->job_model->fetch_quote_multi($s_where,0,1);
			   //pr($job_details); exit;
			  
			   $this->load->model('tradesman_model','mod_td');
			   $this->load->model('manage_buyers_model');		
			   $tradesman_details	= $this->mod_td->fetch_tradesman_details($i_tradesman_id);
			   $s_wh_id 			= " WHERE n.i_user_id=".$i_tradesman_id." ";
			   $buyer_email_key 	= $this->manage_buyers_model->fetch_email_keys($s_wh_id);
			   $is_mail_need 		= in_array('buyer_awarded_job',$buyer_email_key);
			   
			   /**************************** Send a notification to admin ************************/
				$admin_notification	= array();
				$admin_notification['i_user_id'] 			= decrypt($this->data['loggedin']['user_id']);
				$admin_notification['i_user_type'] 			= 1;
				$admin_notification['dt_created_on'] 		= time();
				$admin_notification['i_notification_type'] 	= 3;  
				$admin_notification['s_data1'] 				= $tradesman_details['s_username'];
				$admin_notification['s_data2'] 				= $job_details[0]['job_details']['s_title'];
				$admin_notification['s_data3'] 				= date($this->config->item('notification_date_format')) ;
				$admin_notification['i_is_read'] 			= 0;
				
				$a_tablename = $this->db->ADMIN_NOTIFICATIONS; 
				$this->load->model('common_model');
				$i_notify = $this->common_model->common_add_info($a_tablename, $admin_notification);
				unset($admin_notification,$a_tablename,$i_notify);
				/**************************** End Send a notification to admin ************************/			   
			   
			   if($is_mail_need)
				  {
				   $this->load->model('auto_mail_model');
				   $content 	= $this->auto_mail_model->fetch_mail_content('buyer_awarded_job','tradesman',$tradesman_details['lang_prefix']);	
				   $filename 	= $this->config->item('EMAILBODYHTML')."common.html";
				   $handle 		= @fopen($filename, "r");
				   $mail_html 	= @fread($handle, filesize($filename));
				   $s_subject 	= $content['s_subject'];				
					//print_r($content); exit;
					if(!empty($content))
					{	
						$description = $content["s_content"];
						$description = str_replace("[TRADESMAN_NAME]",$tradesman_details['s_username'],$description);
						$description = str_replace("[BUYER_NAME]",$job_details[0]['job_details']['s_buyer_name'],$description);
						$description = str_replace("[JOB_TITLE]",$job_details[0]['job_details']['s_title'],$description);	
						$description = str_replace("[QUOTE_AMOUNT]",$job_details[0]['s_quote'],$description);	
						$description = str_replace("[LOGIN_URL]",base_url().'user/login/TVNOaFkzVT0',$description);	
					}
					unset($content);
					
					$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					//echo "<br>DESC".$description;	exit;
					
					/// Mailing code...[start]
					$site_admin_email = $this->s_admin_email;	
					$this->load->helper('mail');										
					$i_newid = sendMail($tradesman_details['s_email'],$s_subject,$mail_html);	
                    /// Mailing code...[end]			
					}
			   $msg = '1|'.$this->cls_msg["job_assign"];
			}
			else
			{
				$msg = '2|'.$this->cls_msg["job_assign_err"];
			}
		}			
		echo $msg;			
	
	}
	
	
	
	/* reject quote of a tradesman 
	* author @ mrinmoy
	*/
	
	public function tradesman_reject_quote()
	{
		
		if($_POST)
		{
			$info = array();
			$str			= trim($this->input->post("data_str"));
			$data_str		= explode(',',$str);
			
			$i_quote_id 	= decrypt($data_str[0]);
			$i_job_id 		= decrypt($data_str[1]);			
			$i_tradesman_id = decrypt($data_str[2]);
			
						
			/** UPDATE QUOTE STATUS */
			$arr1 = array();
			$arr1['i_status']  =  3; //Rejected
			$table = $this->db->JOBQUOTES;
			$i_newid = $this->job_model->set_data_update($table,$arr1,$i_quote_id);
			/**END  UPDATE QUOTE STATUS */
			
			//$i_newid = true;
			if($i_newid)
			{			
				/* insert data to job history and stattus change*/
				$arr1 = array();
				$arr1['i_job_id']  =  $i_job_id;
				$arr1['i_user_id'] =  $i_tradesman_id;
				$arr1['s_message'] =  'quote_rejected';
				$arr1['i_created_date'] =  time();
				$table = $this->db->JOB_HISTORY;
				$this->job_model->set_data_insert($table,$arr1);				
				/* end */						
				
			   /* for job quote mail to the user */			   
			   $this->load->model('job_model');
			   $s_where 	= " WHERE n.i_tradesman_user_id={$i_tradesman_id} AND n.i_job_id={$i_job_id} ";
			   $job_details = $this->job_model->fetch_quote_multi($s_where,0,1);
			   //pr($job_details); exit;
			  
			   $this->load->model('tradesman_model','mod_td');
			   $this->load->model('manage_buyers_model');		
			   $tradesman_details	= $this->mod_td->fetch_tradesman_details($i_tradesman_id);
			   
			   /**************************** Send a notification to admin ************************/
				$admin_notification	= array();
				$admin_notification['i_user_id'] 			= decrypt($this->data['loggedin']['user_id']);
				$admin_notification['i_user_type'] 			= 1;
				$admin_notification['dt_created_on'] 		= time();
				$admin_notification['i_notification_type'] 	= 10;  
				$admin_notification['s_data1'] 				= $tradesman_details['s_username'];
				$admin_notification['s_data2'] 				= $job_details[0]['job_details']['s_title'];
				$admin_notification['s_data3'] 				= date($this->config->item('notification_date_format')) ;
				$admin_notification['i_is_read'] 			= 0;
				
				$a_tablename = $this->db->ADMIN_NOTIFICATIONS; 
				$this->load->model('common_model');
				$i_notify = $this->common_model->common_add_info($a_tablename, $admin_notification);
				unset($admin_notification,$a_tablename,$i_notify);
				/**************************** End Send a notification to admin ************************/			   
			   
				 /* sending a mail to tradesman */ 
			   $this->load->model('auto_mail_model');
			   $content 	= $this->auto_mail_model->fetch_mail_content('buyer_reject_quote','tradesman',$tradesman_details['lang_prefix']);	
			   $filename 	= $this->config->item('EMAILBODYHTML')."common.html";
			   $handle 		= @fopen($filename, "r");
			   $mail_html 	= @fread($handle, filesize($filename));
			   $s_subject 	= $content['s_subject'];				
				//print_r($content); exit;
				if(!empty($content))
				{	
					$description = $content["s_content"];
					$description = str_replace("[TRADESMAN_NAME]",$tradesman_details['s_username'],$description);
					$description = str_replace("[BUYER_NAME]",$job_details[0]['job_details']['s_buyer_name'],$description);
					$description = str_replace("[JOB_TITLE]",$job_details[0]['job_details']['s_title'],$description);	
					$description = str_replace("[QUOTE_AMOUNT]",$job_details[0]['s_quote'],$description);	
					$description = str_replace("[LOGIN_URL]",base_url().'user/login/TVNOaFkzVT0',$description);	
				}
				unset($content);
				
				$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
				$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
				//echo "<br>DESC".$description;	exit;
				
				/// Mailing code...[start]
				$site_admin_email = $this->s_admin_email;	
				$this->load->helper('mail');										
				$i_newid = sendMail($tradesman_details['s_email'],$s_subject,$mail_html);	
				/// Mailing code...[end]			
					
			   $msg = '1|'.$this->cls_msg["quote_reject"];
			}
			else
			{
				$msg = '2|'.$this->cls_msg["quote_reject_err"];
			}
		}			
		echo $msg;			
	
	}
	
	
	/* accept job as complete and give feedback 
	* author @ mrinmoy
	*/
	
	public function confirm_job_complete()
	{		
		if($_POST)
		{	
			$info = array();
			$i_job_id		= decrypt(trim($this->input->post("i_job_id")));
			$s_comment		= trim($this->input->post("s_comment"));
			$i_rating		= trim($this->input->post("i_rating"));
			$is_positive	= trim($this->input->post("is_positive"));
			
			$job_details = $this->job_model->fetch_this($i_job_id);
			//pr($job_details,1);
			$arr1 = array();
			$arr1['i_status'] = 6; // complete state
			$arr1['i_completed_date'] = time();
			$table = $this->db->JOBS;			
			$i_newid = $this->job_model->set_data_update($table,$arr1,$i_job_id);
			unset($arr1,$table);
			
			$table = $this->db->JOBFEEDBACK;
			$arr1 = array();
			$arr1['i_job_id'] 			= $i_job_id;
			$arr1['i_sender_user_id'] 	= $this->user_id;
			$arr1['i_receiver_user_id'] = $job_details['i_tradesman_id'];
			$arr1['s_comments'] 		= $s_comment;
			$arr1['i_rating'] 			= $i_rating;
			$arr1['i_positive'] 		= $is_positive;
			$arr1['i_created_date'] 	= time();
			$arr1['i_status'] 			= 1;
			$this->job_model->set_data_insert($table,$arr1);
			unset($arr1,$table);
			
			
			
			/**************************** Send a notification to admin ************************/
			$admin_notification	= array();
			$admin_notification['i_user_id'] 			= decrypt($this->data['loggedin']['user_id']);
			$admin_notification['i_user_type'] 			= 1;
			$admin_notification['dt_created_on'] 		= time();
			$admin_notification['i_notification_type'] 	= 7;  
			$admin_notification['s_data1'] 				= $this->data['loggedin']['user_name'];
			$admin_notification['s_data2'] 				= $job_details['s_title'];
			$admin_notification['s_data3'] 				= date($this->config->item('notification_date_format')) ;
			$admin_notification['i_is_read'] 			= 0;
			
			$a_tablename = $this->db->ADMIN_NOTIFICATIONS; 
			$this->load->model('common_model');
			$i_notify = $this->common_model->common_add_info($a_tablename, $admin_notification);
			unset($admin_notification,$a_tablename,$i_notify);
			/**************************** End Send a notification to admin ************************/			
			
			/*************** calcution for update tradesman details table *****************/
			$this->load->model('manage_feedback_model','mod_feed');	
			/**Accepted feedback*/
			$s_where = " WHERE i_receiver_user_id ={$job_details['i_tradesman_id']} AND n.i_status=1 "; 
			$tot_accepted_feedback = $this->mod_feed->gettotal_info($s_where);
			/**Total feelback*/
			$s_where 		= " WHERE i_receiver_user_id ={$job_details['i_tradesman_id']} AND n.i_status !=0 "; 			
			$tot_feedback 	= $this->mod_feed->gettotal_info($s_where);
			
			$s_where 		= " WHERE i_receiver_user_id ={$job_details['i_tradesman_id']} AND n.i_status !=0";			
			$feedback_details = $this->mod_feed->fetch_feedback_rating($s_where);
			
			$s_where = " WHERE i_receiver_user_id ={$job_details['i_tradesman_id']} AND n.i_status !=0 AND n.i_positive=1" ;
			$i_positive 	= $this->mod_feed->fetch_feedback_positive($s_where);
			
			$info = array();
			$info['i_feedback_rating'] = $feedback_details['i_rating'];
			$info['f_positive_feedback_percentage'] = ($tot_feedback!=0)?round(($i_positive['i_positive']/$tot_feedback)*100):0;
			//$info['i_jobs_won'] = $tot_accepted_feedback;
			$info['i_feedback_received'] = $tot_feedback;
			$table = $this->db->TRADESMANDETAILS;
			$cond = array('i_user_id'=>$job_details['i_tradesman_id']);
			//exit;
			$this->job_model->set_data_update($table,$info,$cond);
			/****************** end of calcution for update tradesman details table *****************/		
			//$i_newid = true;
			
			/* start update job history table and change status of the job */
			if($i_newid)
			{
				/* insert data to job history and stattus change*/
				$arr1 = array();
				$arr1['i_job_id']  =  $i_job_id;
				$arr1['i_user_id'] =  $this->user_id;
				$arr1['s_message'] =  'job_feedback';
				$arr1['i_created_date'] =  time();
				$table = $this->db->JOB_HISTORY;
				$this->job_model->set_data_insert($table,$arr1);	
				/*============*/
				$arr2 = array();
				$arr2['i_job_id']  =  $i_job_id;
				$arr2['i_user_id'] =  $this->user_id;
				$arr2['s_status'] =  'Completed';
				$arr2['i_created_date'] =  time();
				$s_table = $this->db->JOB_STATUS_HISTORY;
				$this->job_model->set_data_insert($s_table,$arr2);	
				unset($s_table,$arr2);
				/* end */	
				
				$tradesman_details = $this->mod_td->fetch_tradesman_details($job_details['i_tradesman_id']);
				$s_wh_id = " WHERE n.i_user_id=".$job_details['i_tradesman_id']." ";
			    $buyer_email_key = $this->mod_buyer->fetch_email_keys($s_wh_id);
				$is_mail_need 	 = in_array('buyer_provided_feedback',$buyer_email_key);
				if($is_mail_need)
			    {
				   $this->load->model('auto_mail_model');
				   $content  = $this->auto_mail_model->fetch_mail_content('buyer_provided_feedback','tradesman',$tradesman_details['lang_prefix']);	
				   $filename 	= $this->config->item('EMAILBODYHTML')."common.html";
				   $handle   	= @fopen($filename, "r");
				   $mail_html	= @fread($handle, filesize($filename));
				   $s_subject	=	$content['s_subject'];
				   if(!empty($content))
					{	
						$description = $content["s_content"];
						$description = str_replace("[BUYER_NAME]",$job_details['s_buyer_name'],$description);
						$description = str_replace("[JOB_TITLE]",$job_details['s_title'],$description);	
						$description = str_replace("[TRADESMAN_NAME]",$job_details['s_tradesman_name'],$description);	
						$description = str_replace("[LOGIN_URL]",base_url().'user/login/TVNOaFkzVT0',$description);	
					}
					unset($content);
					
					$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);						
					//echo "<br>".$mail_html;	exit;
					/// Mailing code...[start]
					$site_admin_email = $this->s_admin_email;	
					$this->load->helper('mail');										
					$i_newid = sendMail($tradesman_details['s_email'],$s_subject,$mail_html);	
                    /// Mailing code...[end]
				   
				}
				
				
				$msg = '1|'.$this->cls_msg["job_complete"];
			}
			/* end update job history table and change status of the job */			
			else
			{
				$msg = '2|'.$this->cls_msg["job_incomplete"];
			}
			
		}			
		echo $msg;			
	
	}
	
	/* deny job as complete and give feedback 
	* author @ mrinmoy
	*/
	
	public function deny_job_complete()
	{		
		if($_POST)
		{	
			$info = array();
			$i_job_id		= decrypt(trim($this->input->post("i_job_id")));
			$s_comment		= get_formatted_string(trim($this->input->post("s_comment")));
			$i_rating		= trim($this->input->post("i_rating"));
			
			$job_details = $this->job_model->fetch_this($i_job_id);
			
			/* test purpose*/
			/*pr($job_details);
			echo decrypt($i_job_id).'comment==>'.$s_comment.'</br>rating==>'.$i_rating;
			exit;*/		
			/* test purpose*/
			
			$arr1 = array();
			$arr1['i_status'] = 11; // pending state
			$table = $this->db->JOBS;
			$i_newid = $this->job_model->set_data_update($table,$arr1,$i_job_id);
			//unset($arr1,$table);
			
			$table = $this->db->JOBFEEDBACK;
			$arr1 = array();
			$arr1['i_job_id'] 			= $i_job_id;
			$arr1['i_sender_user_id'] 	= $this->user_id;
			$arr1['i_receiver_user_id'] = $job_details['i_tradesman_id'];
			$arr1['s_comments'] 		= $s_comment;
			$arr1['i_rating'] 			= $i_rating;
			$arr1['i_positive'] 		= 0;
			$arr1['i_created_date'] 	= time();
			$arr1['i_status'] 			= 0;
			$this->job_model->set_data_insert($table,$arr1);
			//unset($arr1,$table);
			
			$arr1 = array();
			$arr1['i_job_id']  =  $i_job_id;
			$arr1['i_user_id'] =  $this->user_id;
			$arr1['s_message'] =  'job_denied_complition';
			$arr1['i_created_date'] =  time();
			$table = $this->db->JOB_HISTORY;
			$this->job_model->set_data_insert($table,$arr1);	
			/*============*/
			$arr1 = array();
			$arr1['i_job_id']  =  $i_job_id;
			$arr1['i_user_id'] =  $this->user_id;
			$arr1['s_status'] =  'In Progress';
			$arr1['i_created_date'] =  time();
			$table = $this->db->JOB_STATUS_HISTORY;
			$this->job_model->set_data_insert($table,$arr1);	
			/* end */	
			
			
			
			/*************** calcution for update tradesman details table *****************/
			
			/**************************** Send a notification to admin ************************/
			$admin_notification	= array();
			$admin_notification['i_user_id'] 			= decrypt($this->data['loggedin']['user_id']);
			$admin_notification['i_user_type'] 			= 1;
			$admin_notification['dt_created_on'] 		= time();
			$admin_notification['i_notification_type'] 	= 8;  
			$admin_notification['s_data1'] 				= $this->data['loggedin']['user_name'];
			$admin_notification['s_data2'] 				= $job_details['s_title'];
			$admin_notification['s_data3'] 				= date($this->config->item('notification_date_format')) ;
			$admin_notification['i_is_read'] 			= 0;
			
			$a_tablename = $this->db->ADMIN_NOTIFICATIONS; 
			$this->load->model('common_model');
			$i_notify = $this->common_model->common_add_info($a_tablename, $admin_notification);
			unset($admin_notification,$a_tablename,$i_notify);
			/**************************** End Send a notification to admin ************************/
			
			
			$this->load->model('manage_feedback_model');	
			/**Accepted feedback*/
			$s_where = " WHERE i_receiver_user_id ={$job_details['i_tradesman_id']} AND n.i_status=1"; 
			$tot_accepted_feedback = $this->manage_feedback_model->gettotal_info($s_where);
			/**Total feelback*/
			$s_where = " WHERE i_receiver_user_id ={$job_details['i_tradesman_id']}"; 
			$tot_feedback = $this->manage_feedback_model->gettotal_info($s_where);
			
			
			$feedback_details = $this->manage_feedback_model->fetch_feedback_rating($s_where);
			$info = array();
			$info['i_feedback_rating'] = $feedback_details['i_rating'];
			$info['f_positive_feedback_percentage'] = ($tot_feedback!=0)?round(($feedback_details['i_positive']/$tot_feedback)*100):0;
			//$info['i_jobs_won'] = $tot_accepted_feedback;
			$info['i_feedback_received'] = $tot_feedback;
			$table = $this->db->TRADESMANDETAILS;
			$cond = array('i_user_id'=>$job_details['i_tradesman_id']);
			$this->job_model->set_data_update($table,$info,$cond);
			/****************** end of calcution for update tradesman details table *****************/		
			
			/* start update job history table and change status of the job */
			
			if($i_newid)
			{
				$msg = '1|'.$this->cls_msg["job_not_complete"];
			}
			/* end update job history table and change status of the job */			
			else
			{
				$msg = '2|'.$this->cls_msg["job_not_complete_err"];
			}
			
		}			
		echo $msg;			
	
	}
	
	/* job terminate by buyer
	* author @ mrinmoy 
	*/
	public function save_job_terminate()
	{ 
		if($_POST)
		{
			$info = array();
			$i_job_id 			= decrypt($this->input->post("i_job_id"));
			$job_details 		= $this->job_model->fetch_this($i_job_id);			
			$s_terminate_reason = get_formatted_string($this->input->post("s_reason"));
			$s_comments 		= get_formatted_string($this->input->post("s_feedback"));
			$i_rating 			= intval($this->input->post("i_rating"));
			
			//pr($job_details,1);
			//exit;
			
			$info = array();
			$info['i_status'] = 9; // terminate state
			$info['i_terminate_date'] = time();
			$table = $this->db->JOBS;
			$i_newid = $this->job_model->set_data_update($table,$info,$i_job_id);
			
			//$i_newid = true;
			if($i_newid)
			{
			$table = $this->db->JOBFEEDBACK;
			$info = array();
			$info['i_job_id'] = $i_job_id;
			$info['i_sender_user_id'] = $this->user_id;
			$info['i_receiver_user_id'] = $job_details['i_tradesman_id'];
			$info['s_terminate_reason'] = $s_terminate_reason;
			$info['s_comments'] = $s_comments;
			$info['i_rating'] = $i_rating;
			$info['i_positive'] = 0; // negative
			$info['i_created_date'] = time();
			$info['i_status'] = 2;
			$this->job_model->set_data_insert($table,$info);
			
			
			/* insert data to job history and stattus change*/
			$arr1 = array();
			$arr1['i_job_id']  =  $i_job_id;
			$arr1['i_user_id'] =  $this->user_id;
			$arr1['s_message'] =  'job_terminate';
			$arr1['i_created_date'] =  time();
			$table = $this->db->JOB_HISTORY;
			$this->job_model->set_data_insert($table,$arr1);
			
			/*============*/
			$arr1 = array();
			$arr1['i_job_id']  =  $i_job_id;
			$arr1['i_user_id'] =  $this->user_id;
			$arr1['s_status'] =  'Terminated';
			$arr1['i_created_date'] =  time();
			$table = $this->db->JOB_STATUS_HISTORY;
			$this->job_model->set_data_insert($table,$arr1);	
			
			/* end */				
			/**************************** Send a notification to admin ************************/
			$admin_notification	= array();
			$admin_notification['i_user_id'] 			= decrypt($this->data['loggedin']['user_id']);
			$admin_notification['i_user_type'] 			= 1;
			$admin_notification['dt_created_on'] 		= time();
			$admin_notification['i_notification_type'] 	= 9;  
			$admin_notification['s_data1'] 				= $this->data['loggedin']['s_user_name'];
			$admin_notification['s_data2'] 				= $job_details[0]['job_details']['s_title'];
			$admin_notification['s_data3'] 				= date($this->config->item('notification_date_format')) ;
			$admin_notification['i_is_read'] 			= 0;
			
			$a_tablename = $this->db->ADMIN_NOTIFICATIONS; 
			$this->load->model('common_model');
			$i_notify = $this->common_model->common_add_info($a_tablename, $admin_notification);
			unset($admin_notification,$a_tablename,$i_notify);
			/**************************** End Send a notification to admin ************************/
			
			
			/* calcution for update tradesman details table */
			$this->load->model('manage_feedback_model');	
			/**Accepted feedback*/
			$s_where = " WHERE i_receiver_user_id ={$job_details['i_tradesman_id']} AND n.i_status=1 "; 
			$tot_accepted_feedback = $this->manage_feedback_model->gettotal_info($s_where);
			/**Total feelback*/
			$s_where = " WHERE i_receiver_user_id ={$job_details['i_tradesman_id']} AND n.i_status!=0 "; 
			$tot_feedback = $this->manage_feedback_model->gettotal_info($s_where);
			
			$s_where = " WHERE i_receiver_user_id ={$job_details['i_tradesman_id']} AND n.i_status !=0";
			$feedback_details = $this->manage_feedback_model->fetch_feedback_rating($s_where);
			//pr($feedback_details,1);
			$s_where = " WHERE i_receiver_user_id ={$job_details['i_tradesman_id']} AND n.i_status !=0 AND n.i_positive=1" ;
			$i_positive = $this->manage_feedback_model->fetch_feedback_positive($s_where);
			$info = array();
			$info['i_feedback_rating'] = $feedback_details['i_rating'];
			$info['f_positive_feedback_percentage'] = ($tot_feedback!=0)?round(($i_positive['i_positive']/$tot_feedback)*100):0;
			$info['i_feedback_received'] = $tot_feedback;
			$table = $this->db->TRADESMANDETAILS;
			$cond = array('i_user_id'=>$job_details['i_tradesman_id']);			
			$this->job_model->set_data_update($table,$info,$cond);
			 //end of calcution for update tradesman details table 	
			
			
			
		   /* for job terminate mail to the user */		  
		   $this->load->model('job_model');
		   $s_where = " WHERE n.i_job_id={$i_job_id}";
		   $job_details = $this->job_model->fetch_quote_multi($s_where);
		   //print_r($job_details);exit;
		   
		   $this->load->model('auto_mail_model');
		   $content 	= $this->auto_mail_model->fetch_mail_content('buyer_terminate_job','tradesman');
		   $filename 	= $this->config->item('EMAILBODYHTML')."common.html";
		   $handle 		= @fopen($filename, "r");
		   $mail_html 	= @fread($handle, filesize($filename));	
		   $s_subject	= $content['s_subject'];				
		   
		   //print_r($content); 
		   
		   /* for sending mail to all the tradesman those quote on this job */
		   if(!empty($job_details))
		   {	
		   	//$str = '';
		   		foreach($job_details as $val)
				{		
					if(!empty($content))
					{					
						$description = $content["s_content"];
						$description = str_replace("[TRADESMAN_NAME]",$val['s_username'],$description);
						$description = str_replace("[BUYER_NAME]",$val['job_details']['s_buyer_name'],$description);
						$description = str_replace("[JOB_TITLE]",$val['job_details']['s_title'],$description);	
						$description = str_replace("[CATEGORY]",$val['job_details']['s_category'],$description);
						$description = str_replace("[REASON]",$s_terminate_reason,$description);	
						$description = str_replace("[LOGIN_URL]",base_url().'user/login/TVNOaFkzVT0',$description);	
						
					}
					unset($content);
					//echo "<br>DESC".$description;	exit;
					$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					//echo $val['s_email'];	
					
					
					// fetch if the tradesman need the email or not from email settings
					$this->load->model('manage_buyers_model');	
					$s_wh_id = " WHERE n.i_user_id=".$val['i_tradesman_id']." ";
			        $buyer_email_key = $this->manage_buyers_model->fetch_email_keys($s_wh_id);					
			        $is_mail_need = in_array('buyer_terminate_job',$buyer_email_key);	
					
					if($is_mail_need)
					{						
						$this->load->helper('mail');								
						$i_terminate = sendMail($val['s_email'],$s_subject,$mail_html);
					}
				}				
			}
			/// end if loop 
			//unset($content,$s_subject);
			/* mail for admin*/
		   $content 	= $this->auto_mail_model->fetch_mail_content('admin_buyer_terminated_job','general');	
		   $filename 	= $this->config->item('EMAILBODYHTML')."common.html";
		   $handle 		= @fopen($filename, "r");
		   $mail_html 	= @fread($handle, filesize($filename));	
		   $s_sub		= $content['s_subject'];			
			//print_r($content); exit;
		
			if(!empty($content))
			{		
								
				$description = $content["s_content"];
				$description = str_replace("[BUYER_NAME]",$job_details[0]['job_details']['s_buyer_name'],$description);
				$description = str_replace("[JOB_TITLE]",$job_details[0]['job_details']['s_title'],$description);	
				$description = str_replace("[CATEGORY]",$job_details[0]['job_details']['s_category'],$description);
				$description = str_replace("[REASON]",$s_terminate_reason,$description);					
				
			}
			//unset($content);
			$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
			$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);				
			//echo "<br>DESC".$mail_html;	exit;
			
			/// Mailing code...[start]
			$site_admin_email = $this->s_admin_email;	
			$this->load->helper('mail');										
			sendMail($site_admin_email,$s_sub,$mail_html);	
			/// Mailing code...[end]
			/* end mail for admin*/							
			/* end job terminate mail to the tradesmen and also admin */						
							
				$msg = '1|'.$this->cls_msg["job_terminate"];
			}
			else
			{				
				$msg = '2|'.$this->cls_msg["job_terminate_err"];
			}
		}
			
		echo $msg;			
	}
	
	
	public function private_message_board()
    {
        try
        {
            $this->left_menu=10;
            
            $this->data['pathtoclass']=$this->pathtoclass;
            $user_details = $this->session->userdata('loggedin');
            //print_r($user_details);
            $user_id    =    decrypt($user_details['user_id']);
            $this->data['breadcrumb'] = array(addslashes(t('Private Message Board'))=>'');
            $this->load->model('manage_private_message_model','mod_pmb');
            
            
            /**
            * Fetching job list for drop down
            */
            $s_where    =   " WHERE n.i_buyer_user_id  =".$user_id ." AND n.i_status!=0" ;
            $info_jobs  =   $this->mod_pmb->fetch_jobs($s_where) ;
            $arr_jobs   =   array();
            if(!empty($info_jobs))
            {
                foreach($info_jobs as $val)
                {
                    $arr_jobs[$val['i_job_id']]     =   $val['s_job_title'] ; 
                }
            }
            $this->data['arr_jobs']     =    $arr_jobs ;
            
            if($this->session->userdata('sch_job_id'))
            {
                $this->data['job_id']   =   $this->session->userdata('sch_job_id') ;   
            }
            
            /**
            * Fetching tradesman list for drop down
            */
            $s_where    =   " WHERE n.i_buyer_id  =".$user_id ;
            $s_group    =   " GROUP BY n.i_tradesman_id ";
            $info_users =   $this->mod_pmb->fetch_users_pmb($s_where,$s_group) ;
            
            $arr_users  =   array();
            if(!empty($info_users))
            {
                foreach($info_users as $val)
                {
                    $arr_users[$val['i_tradesman_id']]     =   $val['s_tradesman_name'] ;
                }
            }
           
            $this->data['arr_users']    =   $arr_users ;
            
            unset($arr_users,$arr_jobs,$s_where,$s_group,$info_jobs,$info_users); 
			
            $sessArr   =   array();
            $this->session->set_userdata(array('pmb_session'=>$sessArr));
            
			ob_start();
            $this->ajax_pagination_pmb();
            $contents = ob_get_contents();
            ob_end_clean();
         
            $this->data['pmb_list']       = $contents;
			
            
            $this->render('buyer/private_message_board');
            
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	public function ajax_pagination_pmb($start=0)
	{
		try
		{
			if($this->session->userdata('sch_job_id'))
            {
               
                $sessArr['session_job_id']  = trim($this->session->userdata('sch_job_id'));    
                $this->session->unset_userdata('sch_job_id') ;
            }

			if($_POST)
			{
                if($this->input->post('job_id'))
                {
                    $sessArr['session_job_id']  = trim($this->input->post('job_id'));
                }
                if($this->input->post('user_id'))
                {
                    $sessArr['session_user_id']  = trim($this->input->post('user_id'));
                }
                 $this->session->set_userdata(array('pmb_session'=>$sessArr));
			}
          
		
				// to store data in session
			//$this->data['posted'] = $sessArr;
			
			$s_where='';
			$sessArr    =   $this->session->userdata('pmb_session');

			$arr_search[]	=	" n.i_is_deleted=1 And n.i_buyer_id =".$this->user_id." ";
            
			if($sessArr['session_job_id'])
			{
				$arr_search[] =" n.i_job_id=".decrypt($sessArr['session_job_id']);
			}	
            if($sessArr['session_user_id'])
            {
                $arr_search[] =" n.i_tradesman_id=".decrypt($sessArr['session_user_id']);
            }		
			//echo trim($this->input->post('opd_job')).'====='.decrypt($sessArrTmp['src_job_id']);
			$s_where .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';

		    $i_receiver_id  =   $this->user_id ;      
		
			$this->load->model('manage_private_message_model','mod_pmb');
			
			$limit	= $this->i_fe_page_limit;			
				
			$this->data['pmb_list']	=	$this->mod_pmb->fetch_pmb($s_where,intval($start), $limit,$i_receiver_id);	
			
				
			$total_rows				=	$this->mod_pmb->gettotal_info($s_where);
			
			
			$this->data['imagePath']	=	$this->config->item('user_profile_image_thumb_path');
			
			
			$ctrl_path     = base_url().'buyer/ajax_pagination_pmb/';
			$paging_div = 'pmb_list';
			$this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
			$this->data['total_rows']     = $total_rows;
			$this->data['start']          = $start;
		   
			echo $this->load->view('fe/buyer/ajax_pagination_pmb.tpl.php',$this->data,TRUE);
			/* pagination end */
			
			
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
		
	
	}
    
    public function pmb_landing($enc_job_id,$enc_tradesman_id='')
    {
        try
        {
            $this->data['pathtoclass']=$this->pathtoclass;
            $user_details = $this->session->userdata('loggedin');
            //print_r($user_details);
            $user_id    =    decrypt($user_details['user_id']);
            $this->load->model('manage_private_message_model','mod_pmb');
            if($enc_tradesman_id!='')
            {
                $s_where = " WHERE n.i_job_id=".decrypt($enc_job_id)." AND n.i_tradesman_id= ".decrypt($enc_tradesman_id);   
            }
            else
            {
                $this->session->set_userdata('sch_job_id',$enc_job_id);
                redirect(base_url().'buyer/private-message-board/') ; 
            }
            $ret_ = $this->mod_pmb->fetch_pmb_exist($s_where);   
			
			if(empty($ret_))
			{
				$this->load->model('job_model','mod_job');
				$job_details	=	 $this->mod_job->fetch_this(decrypt($enc_job_id));
				$info	=	array();
				$info['i_job_id']	=	decrypt($enc_job_id) ;
				$info['i_tradesman_id']	=	decrypt($enc_tradesman_id) ;
				$info['i_buyer_id']		=	$job_details['i_buyer_user_id'] ;
				$i_new_id = $this->mod_pmb->insert_info($info);
				$i_msg_brd_id = $i_new_id; 		
			}
			else
			{
				$i_msg_brd_id	=	$ret_[0]['id'];
			
			}

			redirect(base_url().'buyer/private-message-details/'.encrypt($i_msg_brd_id).'/all');           
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    
    
    /**
    * This function shows details of message board
    * contains list of messages send by buyer
    *  
    * @param mixed $enc_msg_board_id
    */
    public function private_message_details($enc_msg_board_id='',$type='all')
    {
        try
        {
            $this->left_menu=10;
            
            $this->data['pathtoclass']=$this->pathtoclass;
            $user_details = $this->session->userdata('loggedin');
           
            $user_id    =    decrypt($user_details['user_id']);
            $this->data['breadcrumb'] = array(addslashes(t('Private Message Board'))=>'');

            $this->load->model('manage_private_message_model','mod_pmb');
            $i_msg_board_id     =   decrypt($enc_msg_board_id) ;
            
           
            
            //pr($this->data['pmb_details']);
            
            
            
            if($_POST)
            {                
                $posted=array();
                $posted["ta_comment"]= trim($this->input->post("ta_comment"));
                
                $this->form_validation->set_rules('ta_comment', 'provide comment', 'required');
                
                 if($this->form_validation->run() == FALSE)/////invalid
                    {                        
                        ///Display the add form with posted values within it////
                        $this->data["posted"]=$posted;
                    }
                else
                    {
                       
                        $s_where=" WHERE n.id = ".$i_msg_board_id." ";                        
                        $info_pmb    =    $this->mod_pmb->fetch_pmb_board($s_where,'','');    
                        //print_r($fetch_receiver_id);     exit;                
                        //$i_msg_job_id = decrypt($this->session->userdata('s_msg_job_id'));
          
                        //$msg_job_details = $this->job_model->fetch_this($i_msg_job_id);
                        
                        //$i_status = ($msg_job_details['i_is_active'] ==4)?1:0;
                        
                        
                        // Remove email address from content......
                         $posted["ta_comment"]   =   preg_replace('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/','',$posted["ta_comment"]); 
                         
                         // Remove website address from content......
                         $posted["ta_comment"]   =   preg_replace('/([a-z0-9_-]+\.)*[a-z0-9_-]+(\.[a-z]{2,6}){1,2}/','',$posted["ta_comment"]);  
                         
                        
                        $info=array();
                        $info['i_msg_board_id']    =    $i_msg_board_id;
                        $info['s_content']         =    $posted["ta_comment"];
                        $info['i_status']          =    1;
                        $info['i_sender_id']       =    $this->user_id;
                        $info['i_receiver_id']     =    $info_pmb[0]['i_tradesman_id'];
                        $info['i_date']            =    time();
                       
                        
                        $this->load->model('manage_buyers_model');
                        //$this->load->model('tradesman_model','mod_td');
                        $tradesman_details = $this->mod_td->fetch_tradesman_details($info_pmb[0]['i_tradesman_id']);
                        //$buyer_details =  $this->manage_buyers_model->fetch_this($fetch_receiver_id[0]['i_buyer_id']);
                        //print_r($buyer_details); exit;
                        
                        $s_where = " WHERE n.id=".$i_msg_board_id." And n.i_tradesman_id=".$info_pmb[0]['i_tradesman_id']." ";
                        $job_details = $this->mod_pmb->fetch_pmb($s_where,'','',$info_pmb[0]['i_tradesman_id']);
                                                
                        //print_r($job_details); exit;
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
                            $content = $this->auto_mail_model->fetch_mail_content('buyer_post_msg','tradesman',$tradesman_details['lang_prefix']);
							$s_subject = $content['s_subject'];
                            $filename = $this->config->item('EMAILBODYHTML')."common.html";
                            $handle = @fopen($filename, "r");
                            $mail_html = @fread($handle, filesize($filename));    
                            //print_r($content); exit;
                            if(!empty($content))
                            {        
                                
                                $description = $content["s_content"];
                                $description = str_replace("[Buyer name]",$job_details[0]['s_username'],$description);
                                $description = str_replace("[job title]",$job_details[0]['s_job_title'],$description);    
                                $description = str_replace("[service professional name]",$job_details[0]['s_tradesman_username'],$description);
                                $description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);    
                                $description = str_replace("[site_url]",base_url(),$description);                        
                            }
                            //unset($content);
                            
                            $mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);    
                            $mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);                        
                            //echo "<br>".$mail_html;    exit;
                            /// Mailing code...[start]
                                
                            $this->load->helper('mail');                                        
                            $i_newid = sendMail($job_details[0]['s_tradesman_email'],$s_subject,$mail_html);    
                            
                            unset($content);
                            //echo $this->data['loggedin']['user_email'];
                            //echo "<br>DESC".$description;    exit;    
                            
                            /// Mailing code...[end]                                    
                            }    

                            $this->session->set_userdata(array('message'=>$this->cls_msg["save_comment"],'message_type'=>'succ'));    
                            redirect(base_url().'buyer/private-message-details/'.$enc_msg_board_id.'/all');
                        }
                        else///Not saved, show the form again
                        {
                            $this->session->set_userdata(array('message'=>$this->cls_msg["save_comment_err"],'message_type'=>'err'));
                            $this->render('buyer/private-message-details/'.$enc_msg_board_id.'/all');
                        }
                    }    
            }
            
            if($type=="all")
            {
                $s_where    =    " WHERE pd.i_status = 1 AND pd.i_msg_board_id = ".$i_msg_board_id." ";
                
            }
            else if($type=="new")
            {
                $s_where    =    " WHERE pd.i_status = 1 AND pd.i_msg_board_id = ".$i_msg_board_id." AND pd.i_receiver_id = {$this->user_id} AND pd.i_receiver_view_status = 0 ";
    
            }
            
            $this->data['pmb_details'] =  $this->mod_pmb->fetch_this_pmb($s_where);
            
            /**** This code for new message *******/
            $s_where    =    " WHERE i_status = 1 AND i_msg_board_id = ".$i_msg_board_id." AND i_receiver_id = {$this->user_id} AND i_receiver_view_status = 0 ";
            
            $this->mod_pmb->update_view_status($s_where);
            
            $this->render('buyer/private_message_details');
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    
    /** 
    * This is a ajax function to fetch all the job history of a buyer
    * and display in a light box
    * added by koushik
    *  
    */
    public function ajax_fetch_job_history()
    {
        try
        {
           if($_POST)
           {
               $enc_job_id  =   trim($this->input->post('job_id'));
               $this->load->model('job_model','mod_job');
               $s_where = " WHERE n.i_job_id=".decrypt($enc_job_id)." ";                    
               $history_details = $this->mod_job->fetch_job_history($s_where); 
               
               if(!empty($history_details)) 
               {
                   $str =   '';
                   foreach($history_details as $key=>$val)
                   {
                       $extra_class =   ($key%2==1)?'bg05':'';
                       $str .=   ' <div class="htstory_box '.$extra_class.'">
                       <p>'.$val['msg_string'] .'</p>
                       </div>' ;
                   }
                  
               }
               else
               {
                   $str =   ' <div class="htstory_box bg05">
                       <p> No item found.</p>
                       <div>' ;
               }
               unset($history_details,$s_where,$enc_job_id);
               echo $str ;

           }
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    public function ajax_fetch_feedback()
    {
        try
        {
            
			$enc_job_id = trim($this->input->post('job_id'));
            $s_where  = ' WHERE n.i_job_id="'.decrypt($enc_job_id).'" AND n.i_sender_user_id='.$this->user_id.' AND n.i_status=1 ';
            $this->load->model('manage_feedback_model','mod_feed');
            $info_feed  =    $this->mod_feed->fetch_multi($s_where);
          
            $str    =   '';

            if(!empty($info_feed))
            {
                foreach($info_feed as $val)
                {
                    $s_positive =   ($val['i_positive']==1)?'<img src="images/fe/Positive.png" alt="" />"'.addslashes(t('Positive feedback')).'"':'"'.addslashes(t('Negetive feedback')).'"'  ;
                    $str    .=   '<h4>'.$val['s_job_title'].'</h4><div class="rating">'.show_star($val['i_rating']).'</div>
                  <div class="spacer"></div>
                  <div class="feedback_box">
                        <p>'.$val['s_comments'].' <span>- '.$val['s_receiver_user'].'<br/>'.$val['dt_created_on'].'</span></p>
                         <div class="spacer"></div>
                           <div class="positive">'.$s_positive.'</div>
                            <div class="spacer"></div>
                         
                        
                  </div>' ;
                }
                
            }
            else
            {
                $str .= 'no item found';
            }
            
            echo $str; 
            
            
          /*        */
 
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	
    
    
    public function email_settings()
    {
        try
        {
            $this->left_menu=12;
            
            $this->data['pathtoclass']=$this->pathtoclass;
            $user_details = $this->session->userdata('loggedin');
            $this->data['breadcrumb'] = array(addslashes(t('Email Settings'))=>'');    
            $this->data['user_id']    =    $user_details['user_id'];
            if($_POST)
            {
                $posted    =    array();
                $posted["chk_trade_place_quote"]            =    trim($this->input->post("chk_trade_place_quote"));
                $posted["chk_trade_accept_reject_job"]      =    trim($this->input->post("chk_trade_accept_reject_job"));
                $posted["chk_trade_submit_msg"]             =    trim($this->input->post("chk_trade_submit_msg"));
                $posted["chk_trade_asked_feedback"]         =    trim($this->input->post("chk_trade_asked_feedback"));
                $posted["chk_admin_approved_reject_job"]    =    trim($this->input->post("chk_admin_approved_reject_job"));
                $posted["chk_trade_review_rating"]          =    trim($this->input->post("chk_trade_review_rating"));

                $info=array();
                $info["chk_trade_place_quote"]              =    $posted["chk_trade_place_quote"];
                $info["chk_trade_accept_reject_job"]        =    $posted["chk_trade_accept_reject_job"];
                $info["chk_trade_submit_msg"]               =    $posted["chk_trade_submit_msg"];
                $info["chk_trade_asked_feedback"]           =    $posted["chk_trade_asked_feedback"];
                $info["chk_admin_approved_reject_job"]      =    $posted["chk_admin_approved_reject_job"];
                $info["chk_trade_review_rating"]            =    $posted["chk_trade_review_rating"];
                
                //print_r($info); exit;
                
                $i_newid = $this->mod_buyer->set_email_settings($info,$this->user_id);
                if($i_newid)////saved successfully
                {
                    $this->session->set_userdata(array('message'=>$this->cls_msg["save_email_setting"],'message_type'=>'succ'));
                    redirect(base_url().'buyer/email-settings');
                }
                else///Not saved, show the form again
                {
                    set_error_msg($this->cls_msg["save_err"]);
                   redirect(base_url().'buyer/email-settings');  
                }                    
                    
                    
              
            }
            
            $s_user_id    =    " WHERE n.i_user_id=".$this->user_id." ";
            
            $this->data['email_key']    =    $this->mod_buyer->fetch_email_keys($s_user_id,'','');
            
            //pr($this->data['email_key']);exit;
            
            $this->render();
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
    
    /**
    * Recommend us for the buyer
    * 
    */
    public function recommend_us()
    {
        try
        {
            $this->left_menu    =   13;
            
            $this->data['pathtoclass']=$this->pathtoclass;
            $user_details = $this->session->userdata('loggedin');
            $this->data['breadcrumb'] = array(addslashes(t('Email Settings'))=>'');    
            $this->data['user_id']    =    $user_details['user_id'];
            
            $this->load->model('recommend_model','mod_recomm');
            $this->load->model('auto_mail_model','mod_auto');
            
            if($_POST)
            {
                $posted     =   array();
                $posted['txt_name']     =   $this->input->post('txt_name');
                $posted['txt_email']    =   $this->input->post('txt_email');
                
                $info            =   array();
                $arr_recommended =   array();
                $arr_registered  =   array();
                $arr_msg         =   array();
                
                $count  =   0 ;

                foreach($posted['txt_name'] as $key=>$val)
                {
                    if($val!='' && $posted['txt_email'][$key]!='')
                    {
                        $i_newid   =    '' ;
                        $email      =    $posted['txt_email'][$key] ;
                        $chk_val    =    $this->mod_recomm->check_email($email,$this->user_id);
                        
                        if($chk_val==0)    
                        {
                            $info['s_referred_name']       =   $val ;
                            $info['s_referred_email']      =   $email ;
                            $info['s_referred_code']       =   genVerificationCode();
                            $info['i_referrer_id']         =   $this->user_id ;
                            $info['i_is_active']           =   0 ;
                            $info['i_created_date']        =   time() ;
                           
                            $i_newid    =    $this->mod_recomm->add_info($info);
                            
                            if($i_newid)
                            {
                               $count++ ;
                               $content = $this->mod_auto->fetch_mail_content('referral_mail','general');
                               
                               $filename = $this->config->item('EMAILBODYHTML')."common.html";
                               $handle = @fopen($filename, "r");
                               $mail_html = @fread($handle, filesize($filename));
                               $s_subject   =   $content['s_subject'] ;                    
                                //print_r($content); exit;
                                if(!empty($content))
                                    {                            
                                        $description = $content["s_content"];
                                        $description = str_replace("[referred name]",$info['s_referred_name'],$description);    
                                        $description = str_replace("[Buyer/Tradesman name]", $user_details['user_name'],$description);                                
                                        $description = str_replace("[##register_link##]",base_url().'home/active_account'.'/'.$info['s_referred_code'],$description); 
                                        $description = str_replace("[site_url]",base_url(),$description);
                                        $description = str_replace("%EMAIL_DISCLAMER%","",$description);                            
                                    }
                                //unset($content);
                                
                                
                            $mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);    
                            $mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);                        
                            //echo "<br>".$mail_html;    exit;
                            /// Mailing code...[start]
                                
                            $this->load->helper('mail');                                        
                            $i_aff = sendMail($email,$s_subject,$mail_html);    

                            unset($content);

                            }    
                        }
                        else
                        {
                            $duplicate = true;
                            if($chk_val==1) // already recommended by user   
                            {
                                $arr_recommended[] = $email;
                            }                
                            elseif($chk_val==2) // already registered user
                            {
                                $arr_registered[] = $email;
                            }
                        }
                        
                    }
                }
                if(!empty($arr_recommended))
                {
                    $arr_msg[] = implode(',',$arr_recommended)." email(s) are already recomended by you.";  
                }
                if(!empty($arr_registered))
                {
                    $arr_msg[] = implode(',',$arr_registered)." email(s) are already registered.";
                }
                if(!empty($arr_msg))
                {
                    $msg_part   =   implode('<br/>',$arr_msg).'<br/>';
                }
                $this->session->set_userdata(array('message'=>$msg_part.' '.$count.' '.$this->cls_msg["save_recommend"],'message_type'=>'succ'));
                redirect($this->pathtoclass."recommend-us");
                
            }
            
            
            ob_start();
            $this->ajax_pagination_recommend_us();
            $contents = ob_get_contents();
            ob_end_clean();
         
            $this->data['recommend_list']       = $contents;
            
            $this->render('buyer/recommend_us');
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    /**
    * Recommend us listing with ajax pagination
    * 
    */
    public function ajax_pagination_recommend_us($start=0) 
    {
        try
        {
            $this->load->model('recommend_model','mod_recomm'); 
            $limit            =  $this->i_fe_page_limit ;
            $s_where    =   ' WHERE i_referrer_id='.$this->user_id;
            
            
            $this->data['info_recommend']   =   $this->mod_recomm->fetch_multi($s_where,$start,$limit);
            /* pagination start @ defined in common-helper */
            $total_rows                 = $this->mod_recomm->gettotal_info($s_where);
            $ctrl_path     = base_url().'tradesman/ajax_pagination_recommend_us/';
            $paging_div = 'recommend_list';
            $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
            $this->data['total_rows']     = $total_rows;
            $this->data['start']          = $start;
           
            echo $this->load->view('fe/buyer/ajax_pagination_recommend_us.tpl.php',$this->data,TRUE);
            /* pagination end */

            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    /**
    * This is the function list of tradesman 
    * for searching and invite tradesman
    * 
    */
    public function invite_tradesman()
    {
        try
        {
            $this->left_menu    =   11;
            
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['breadcrumb'] = array(addslashes(t('Search').'/'.('Invite Tradrsman'))=>''); 
            $this->session->unset_userdata('arr_session'); 
           if($_POST)
           {

                $sessArrTmp  =   array();
                $sessArrTmp['src_tradesman_category_id']    = trim($this->input->post('category'));                        
                $sessArrTmp['src_tradesman_city_id']        = trim($this->input->post('opt_city'));
                $sessArrTmp['src_tradesman_province_id']    = trim($this->input->post('opt_state'));
                $sessArrTmp['src_tradesman_keyword']        = trim($this->input->post('txt_keyword'));
                
                if(!empty($sessArrTmp))
                {
                    $this->session->set_userdata('arr_session',$sessArrTmp);
                }
                
                $arr_job_id         =   $this->input->post('chk_jobs');
                $enc_tradesman_id   =   $this->input->post('h_tradesman_id');
                $tradesman_profile  =   $this->input->post('tradesman_profile') ;
                
                $tablename  =   $this->db->MST_USER ;
                $arr_where  =   array('id'=>decrypt($enc_tradesman_id));
                $info_tradesman     =   $this->mod_common->common_fetch($tablename,$arr_where);  // tradesman details
                
                $user_details   =   $this->data['loggedin']; // Buyer login data
             
                
                if(!empty($arr_job_id)) // for all selected jobs invite tradesman
                {
                    
                    
                     // Data to insert job invitation table.... 
                    $info['i_tradesman_id']   =   decrypt($enc_tradesman_id)  ; 
                    $info['i_request_date']   =   time()  ; 
                    $info['i_status']         =   1  ; 
                    
                    foreach($arr_job_id as $val)
                    {
                        $info['i_job_id']         =   decrypt($val)  ; 
                        $this->job_model->set_data_insert($this->db->JOB_INVITATION,$info); // add row in job invitation table
                        //print_r($content); exit;                       
                    }
                    
					$this->load->model('manage_buyers_model');    
					$s_where = " WHERE n.i_user_id=".$info['i_tradesman_id']." ";
					$buyer_email_key = $this->manage_buyers_model->fetch_email_keys($s_where);
					$is_mail_need = in_array('job_invitation',$buyer_email_key);
					
					if($is_mail_need)
					{
                     //Fetch mail content for job invitation
                     $this->load->model('auto_mail_model','mod_auto');
                     $contents  =   $this->mod_auto->fetch_mail_content('job_invitation','tradesman',$info_tradesman[0]['i_signup_lang']);
                    
                    $filename      = $this->config->item('EMAILBODYHTML')."common.html";
                    $handle        = @fopen($filename, "r");
                    $mail_html     = @fread($handle, filesize($filename));
                    $s_subject     = $contents['s_subject']; 
                    
                    if(!empty($contents))
                    {    
                        $description = $contents["s_content"];
                        $description = str_replace("[TRADESMAN_NAME]",$info_tradesman[0]['s_username'],$description);
                        $description = str_replace("[BUYER_NAME]",$user_details['user_name'],$description);
                        $description = str_replace("[LOGIN_URL]",base_url().'user/login/TVNOaFkzVT0',$description);    
                    }

                    $mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);    
                    $mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
                    //echo "<br>DESC".$description;    exit;
                    
                    /// Mailing code...[start]
   
                    $this->load->helper('mail');  
                  
                    $i_newid = sendMail($info_tradesman[0]['s_email'],$s_subject,$mail_html); // sending mail
					}
					else
					{
						$i_newid = true;
					}
                    
                    if($i_newid)
                    {
                        $cnt    =   count($arr_job_id).' '.addslashes(t('job(s)'));
                        $this->session->set_userdata(array('message'=>$this->cls_msg["save_invite"].$cnt,'message_type'=>'succ'));
                        
                        if($tradesman_profile)
                        {
                             redirect(base_url().'tradesman-profile/'.$enc_tradesman_id);
                        }
                        redirect(base_url().'buyer/invite-tradesman');
                    }
                        
                    
                    unset($content,$filename,$mail_html,$s_subject);
                    
                }
                
                unset($user_details,$info_tradesman,$tablename,$arr_where);
           }

            ob_start();
            $this->ajax_pagination_invite_tradesman(0);
            $contents = ob_get_contents();
            ob_end_clean();
            $tradesman_list = explode('^',$contents);
            
            $this->data['tradesman_list'] = $tradesman_list[0];
            $this->data['tot_rows']       = $tradesman_list[1];
            
            $this->render('buyer/invite_tradesman');

        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    public function ajax_pagination_invite_tradesman($start=0)
    {
        try
        {
                $s_where='';
                $orderbyArry = array(0=>'n.s_name',1=>'td.i_feedback_rating',2=>'td.i_jobs_won');
                
                $arr_session    =   $this->session->userdata('arr_session');
                $sessArrTmp['src_tradesman_keyword']          = $arr_session['src_tradesman_keyword'];
                $sessArrTmp['src_tradesman_category_id']      = $arr_session['src_tradesman_category_id'];
                $sessArrTmp['src_tradesman_city_id']          = $arr_session['src_tradesman_city_id'];
                $sessArrTmp['src_tradesman_province_id']      = $arr_session['src_tradesman_province_id'];    
               
                
                $arr_search[] = " n.id!=0 AND n.i_is_active=1 AND n.i_role=2";
                if($sessArrTmp['src_tradesman_verified'])
                {
                    $arr_search[] =" (td.i_ssn_verified = 1 AND td.i_address_verified = 1 AND td.i_mobile_verified = 1) ";
                }
                // search for workdays array defined  @ database.php
                if($sessArrTmp['src_tradesman_weekend'])
                {
                    $arr_search[] =" (w_days.i_work_days IN(2,3)) ";
                }
                
                if($sessArrTmp['src_tradesman_keyword']!="")
                {
                     $arr_search[] =" (n.s_name LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_keyword'])."%' OR n.s_username LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_keyword'])."%' OR td.s_keyword LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_keyword'])."%' OR td.s_about_me LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_keyword'])."%') ";
                }            
                        
                if($sessArrTmp['src_tradesman_category_id'] && $sessArrTmp['src_tradesman_category_id']!=t('All'))
                {
                    $arr_search[] =" tc.i_category_id=".decrypt($sessArrTmp['src_tradesman_category_id']);
                }    
                if($sessArrTmp['src_tradesman_city_id'])
                {
                    $arr_search[] =" n.i_city=".decrypt($sessArrTmp['src_tradesman_city_id']);
                }    
                if($sessArrTmp['src_tradesman_province_id'])
                {
                    $arr_search[] =" n.i_province=".decrypt($sessArrTmp['src_tradesman_province_id']);
                }
                
                
                $s_where .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
                $limit     =  $this->i_fe_page_limit;        
                $orderby = $orderbyArry[1].' DESC ';
                
                $tradesman_list    = $this->mod_td->fetch_featured($s_where,$orderby,intval($start),$limit);
                 
                $total_rows     = $this->mod_td->gettotal_info($s_where);
                
                
                if($total_rows > 0)
                {
                    $this->load->model('manage_feedback_model','mod_feed');
                    for($i = 0;$i<count($tradesman_list);$i++) 
                    {
                        $s_where = " WHERE n.i_receiver_user_id = ".$tradesman_list[$i]['id']." AND n.i_status !=0 "; 
                        $feedback = $this->mod_feed->fetch_multi($s_where,$i_start=0,$i_limit=1);
                    //    pr($feedback);
                        $tradesman_list[$i]['feedback'] = $feedback[0];
                    }
                
                }
                
                if($total_rows > 0)
                {
                    for($i = 0;$i<count($tradesman_list);$i++) 
                    {
                        $s_wh = " WHERE n.i_user_id = ".$tradesman_list[$i]['id']." "; 
                        $category = $this->mod_td->fetch_all_category($s_wh);
                        //pr($category);
						$cat_arr = array();
                        if(!empty($category))
						{
						
						foreach($category as $val)
							{
								$cat_arr[] = $val['s_category_name'];
							}
							
						}
						$tradesman_list[$i]['category'] = implode(', ',$cat_arr);
                    }
                
                }
                
                //echo $limit.'--'. $start;
                $this->data['tradesman_list'] = $tradesman_list;  

                //pr($this->data['tradesman_list'],1);    
                /* pagination start @ defined in common-helper */
                $ctrl_path     = base_url().'buyer/ajax_pagination_invite_tradesman/';
                $paging_div = 'trades_list';
                $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
                $this->data['total_rows']     = $total_rows;
                $this->data['start']         = $start;
                $this->data['image_path']     = $this->config->item("user_profile_image_thumb_path");
                $this->data['image_up_path']= $this->config->item("user_profile_image_thumb_upload_path");
                //$this->data['current_page'] = $page;
                if($start>0)
                {
                    $job_vw = $this->load->view('fe/buyer/ajax_pagination_invite_tradesman.tpl.php',$this->data,TRUE);
                }
                else
                {
                    $job_vw = $this->load->view('fe/buyer/ajax_pagination_invite_tradesman.tpl.php',$this->data,TRUE).'^'.$total_rows;
                }
                echo $job_vw;
        
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
   
	

    public function __destruct()

    {}           

}



/* End of file welcome.php */

/* Location: ./system/application/controllers/welcome.php */

