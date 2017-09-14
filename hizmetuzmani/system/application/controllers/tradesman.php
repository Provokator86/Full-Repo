<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 03 May 2012
* Modified By: 
* Modified Date: 
* 
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class Tradesman extends My_Controller
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
        try
        { 
			
          parent::__construct(); 
          $this->data['title'] 	= "Dashboard";////Browser Title
		  $this->data['ctrlr'] 	= "tradesman";
		  $this->pathtoclass	= base_url().$this->router->fetch_class()."/"; 
		 
		 
		  if(empty( $this->data['loggedin']) || decrypt($this->data['loggedin']['user_type_id'])!=2)
			{
                $this->session->set_userdata(array('message'=>addslashes(t("Please login to access this page")),'message_type'=>'err'));
				redirect(base_url()."user/login/".encrypt(2));
				exit;
			}
		  $user_details 		=   $this->data['loggedin'];
		  $this->data['name']	=	$user_details['user_name'];
		  $this->user_id 		=	decrypt($user_details['user_id']);	
			
          
            
		  /**************   defined all the success and error messages  ****************/	
		  $this->cls_msg=array();
		  $this->cls_msg["save_profile"] 	= addslashes(t("profile details saved succesfully"));
		  $this->cls_msg["save_profile_err"]= addslashes(t("profile details could not saved"));
		  $this->cls_msg["save_pwd"]		= addslashes(t("password changed successfully"));
		  $this->cls_msg["save_pwd_err"]	= addslashes(t("password changed could not saved"));
		  $this->cls_msg["wrong_pwd"]		= addslashes(t("existing password does not match"));
		  $this->cls_msg["save_album"] 		= addslashes(t("album details saved succesfully"));
		  $this->cls_msg["save_album_err"] 	= addslashes(t("album details could not saved "));
		  $this->cls_msg["err_max_no"] 		= addslashes(t("you can upload maximum 15 photos to your album"));
		  $this->cls_msg["save_contact"] 	= addslashes(t("contact details saved succesfully"));
		  $this->cls_msg["save_contact_err"]= addslashes(t("contact details failed to save"));
		  $this->cls_msg["prof_info_save"]	= addslashes(t("professional information saved successfully"));
		  $this->cls_msg["prof_info_err"]	= addslashes(t("professional information failed to save"));
		  $this->cls_msg["save_testimoni"]	= addslashes(t("testimonial saved successfully"));
		  $this->cls_msg["testimoni_err"]	= addslashes(t("testimonial failed to save"));
		  
		  $this->cls_msg["quote_edit_save"]	= addslashes(t("Congratulations!! Your quote has been updated successfully."));
		  $this->cls_msg["quote_edit_err"]	= addslashes(t("Sorry!! Your quote price updation failed, Please try again."));
		  $this->cls_msg["auth_err"]		= addslashes(t("You are not authenticated to access this page."));
		  $this->cls_msg["job_inactive"]	= addslashes(t("This job is no longer active."));
		  $this->cls_msg["job_accept_save"]	= addslashes(t("Job has been accepted successfully."));
		  $this->cls_msg["job_accept_err"]	= addslashes(t("Job acceptance failed to save."));
		  $this->cls_msg["job_deny_save"]	= addslashes(t("Job has been denied successfully."));
		  $this->cls_msg["job_deny_err"]	= addslashes(t("Job denied failed to save."));		  
		  $this->cls_msg["job_complete"]	= addslashes(t("Feedback asked successfully."));
          $this->cls_msg["job_complete_err"]= addslashes(t("Feedback asked failed to save."));
          $this->cls_msg["save_email_setting"]= addslashes(t("Email setting saved successfully."));
          $this->cls_msg["save_comment"]      = addslashes(t("comment saved successfully."));
          $this->cls_msg["save_comment_err"]  = addslashes(t("failed to save comment."));  
          
          $this->cls_msg["save_recommend"]    = addslashes(t("Recommend(s) send successfully.")); 
		  
		  $this->cls_msg["save_radar_succ"]	= addslashes(t("Radar setting saved successfully."));
          $this->cls_msg["savve_radar_err"]    = addslashes(t("Radar setting failed to save."));    
		  $this->cls_msg["save_bank_transfer"]	= addslashes(t("Bank Trnsfer Information saved successfully ,It need admin approval."));    
		  
		  
		  /**************   end defined all the success and error messages  ****************/
		  
		  /****** TARDESMAN ALBUM IMAGE UPLOAD SETTINGS  ******/
		  $this->uploadDir 	= $this->config->item('trades_album_image_upload_path');	
		  $this->thumbDir 	= $this->config->item('trades_album_image_thumb_upload_path');
		  $this->t_ht 		= $this->config->item('trades_album_image_upload_thumb_height');	
		  $this->t_wd 		= $this->config->item('trades_album_image_upload_thumb_width');
          /****** END TARDESMAN ALBUM IMAGE UPLOAD SETTINGS  ******/
		  
		  /****** TARDESMAN PROFILE / LOGO IMAGE UPLOAD SETTINGS  ******/
		  $this->allowedExt 		=  'jpg|jpeg|png|gif';	
		  $this->uploaddir 			=  $this->config->item('user_profile_image_upload_path');	
		  $this->thumbdir 			=  $this->config->item('user_profile_image_thumb_upload_path');
		  $this->thumbDisplayPath 	=  $this->config->item('user_profile_image_thumb_path');
		  $this->nw_width 			=  $this->config->item('trades_photo_upload_thumb_width');
		  $this->nw_height 			=  $this->config->item('tradesman_photo_upload_thumb_height');
		  /****** TARDESMAN PROFILE / LOGO IMAGE UPLOAD SETTINGS  ******/
		  $this->addressExt			= 'jpg|jpeg|png|pdf';
		  $this->addressdir 		= $this->config->item('tradesman_address_proof_upload_path');
  
		  $this->load->model('tradesman_model','mod_td');	
		  $this->load->model('job_model');	
		  $this->load->model('common_model','mod_common');
		  $this->load->model('radar_model','mod_radar');
 
		 // $this->add_js('js/jquery.form.js');		
		 
		 
		 /*************** Start job count list *****************/
          
          $s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_is_deleted!=1 "; 
          $info    =  $this->job_model->gettotal_jobs_user($s_where);
          $i_total      =   0;
          $i_frozen     =   0;
          $i_progress     =   0;
          $i_complete   =   0;
          $i_pending     =   0;
          

          if(!empty($info))
          {
              foreach($info as $val)
              {
                  if($val['i_status']   == 8)
                  {
                      $i_frozen += 1;
                      $i_total  += 1;
                  }
                  else if($val['i_status']   == 4 || $val['i_status']   == 5)
                  {
                      $i_progress += 1;
                      $i_total  += 1;
                  }
                  else if($val['i_status']   == 11)
                  {
                      $i_pending += 1;
                      $i_total  += 1;
                  }
                  else if($val['i_status']   == 6)
                  {
                      $i_complete += 1;
                      $i_total  += 1;
                  }
                  
              }
          }
          $arr_jobs['i_frozen']     =    $i_frozen ;   
          $arr_jobs['i_progress']   =    $i_progress ;   
          $arr_jobs['i_pending']    =    $i_pending ;   
          $arr_jobs['i_complete']   =    $i_complete ;   
          $arr_jobs['i_total']      =    $i_total ;   
         
          $this->data['job_count']  =   $arr_jobs ;  
          
          /*************** End job count list *****************/
		  $s_where    =   " WHERE tm.i_tradesman_id= {$this->user_id} AND tm.i_status=1 " ;
          $this->data['i_membership']    =   $this->mod_td->fetch_tradesman_membership_plan($s_where);
		  //pr($this->data['i_membership'],1);
		  $s_where = " WHERE n.i_tradesman_user_id = {$this->user_id} And n.i_status!=3 ";
		  //$this->data['i_tot_quotes'] = $this->job_model->gettotal_quote_info($s_where);
		  $this->data['i_tot_quotes'] = $this->job_model->gettotal_job_quotes($s_where);
		  
		  $s_where = " WHERE inv.i_tradesman_id = {$this->user_id} AND inv.i_status=1 "; 
		  $this->data['i_tot_invitation'] = $this->job_model->gettotal_job_invitation($s_where);
		  
		  $this->load->model("Manage_feedback_model","mod_feed");
		  $s_where = " WHERE n.i_receiver_user_id = ".$this->user_id." AND n.i_status != 0 "; 		
		  $this->data['i_total_feedback']  = $this->mod_feed->gettotal_info($s_where);	
          
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
			redirect('tradesman/dashboard');
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
		//==========================================
            //$this->data['dt_local_time'] = date("l j-M-Y H:i T",time());  before it was there
			$this->data['dt_local_time'] = date("l j-M-Y",time());
			$this->data['breadcrumb'] = array(addslashes(t('Dashboard'))=>'');
            
            $user_details                 = $this->session->userdata('loggedin');
            $this->data['user_id']        = $user_details['user_id'];
			/* fetch quote details */
			$s_where = " WHERE n.i_tradesman_user_id={$this->user_id} AND n.i_status!=3";
			$this->data['quote_details'] = $this->job_model->fetch_quote_multi($s_where,0,3);
			//pr($this->data['quote_details']);
			/* end fetch quote details */
			
			/* fetch pending buyer reviews */
			$this->load->model("Manage_feedback_model","mod_feed");
			$s_where = " WHERE n.i_receiver_user_id = {$this->user_id} AND n.i_status=0  "; 
			$this->data['feedback_job_list'] = $this->mod_feed->fetch_pending_buyer_review_jobs($s_where,0,5);
			//pr($this->data['feedback_job_list'],1);
			/* end fetch pending buyer reviews */
            
            
            
            $s_where    =   ' WHERE tm.i_tradesman_id='.decrypt($this->data['user_id']).' AND tm.i_status=1 ' ;
            $info_membership    =   $this->mod_td->fetch_tradesman_membership_plan($s_where);
			//pr($info_membership,1);
            /*echo date('d-m-Y',strtotime('now')).'<br/>';
            echo date('d-m-Y',time()+(strtotime('+'.$info_membership[0]['i_duration'].' days')-strtotime('now')));
            exit;*/

            if(!empty($info_membership) && count($info_membership)==1)
            {
                $this->data['i_plan']           =   $info_membership[0]['i_plan_type'];
                $this->data['s_plan']           =   $info_membership[0]['s_plan_type'];
                $this->data['dt_expire_date']   =   $info_membership[0]['dt_expired_date'];
				
				$this->data['i_quotes_remain']  =   $info_membership[0]['i_quotes_remain'];
				$this->data['i_contact_remain'] =   $info_membership[0]['i_contact_remain'];
            }
            
           
            
            $this->load->model('manage_private_message_model','mod_pmb');
            
            $s_where    =   " WHERE i_receiver_id=".$this->user_id." AND i_receiver_view_status=0 " ;
            $this->data['i_new_msg']  =   $this->mod_pmb->gettotal_msg_info($s_where) ;
            
            unset($info_membership,$s_where);  
            
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
	
	/******************  START EDIT PROFILE ***********************/
	public function edit_profile()
    {
        try
        {	
			$this->left_menu=1;			
			$this->data['breadcrumb'] 	= array(addslashes(t('Edit Profile'))=>'');
			$this->data['pathtoclass']	= $this->pathtoclass;
			$user_details 				= $this->session->userdata('loggedin');
			$this->data['user_id']		= $user_details['user_id'];
			
			
			
			$this->load->model('city_model');
			$this->load->model('province_model');
			$this->load->model('zipcode_model');
			
			if($_POST)
			{
				$posted["txt_email"]			= 	trim($this->input->post("txt_email"));				
				$posted["i_sm"]					= 	trim($this->input->post("social_media"));
				$posted["txt_sm"]				= 	trim($this->input->post("txt_sm"));				
				$posted["opt_state"]			= 	trim($this->input->post("opt_state"));
				$posted["opt_city"]				= 	trim($this->input->post("opt_city"));
				$posted["opt_zip"]				= 	trim($this->input->post("opt_zip"));				
				
				$posted['i_trades_type']		=	trim($this->input->post("i_trades_type"));
				$posted['txt_trade_name']		=	trim($this->input->post("txt_trade_name"));
				$posted['txt_gsm']				=	trim($this->input->post("txt_gsm"));
				$posted['opt_gsm']				=	trim($this->input->post("opt_gsm"));
				$posted['txt_firm_name']		=	trim($this->input->post("txt_firm_name"));
				$posted['opt_firm_phone']		=	trim($this->input->post("opt_firm_phone"));
                $posted['txt_firm_phone']       =    trim($this->input->post("txt_firm_phone"));
				$posted['ta_firm_add1']			=	trim($this->input->post("ta_firm_add1"));
				$posted['ta_firm_add2']			=	trim($this->input->post("ta_firm_add2"));
				$posted['txt_tax_office']		=	trim($this->input->post("txt_tax_office"));
				$posted['txt_tax_number']		=	trim($this->input->post("txt_tax_number"));
				$posted['txt_ssn']				=	trim($this->input->post("txt_ssn"));
				$posted['f_address']			=	trim($this->input->post("f_address"));
				$posted['h_address']			=	trim($this->input->post("h_address"));
				
                
				if(isset($_FILES['f_address']) && !empty($_FILES['f_address']['name']))
				{
				$s_uploaded_filename = get_file_uploaded($this->addressdir,'f_address','','',$this->addressExt);					
				$address_upload_res = explode('|',$s_uploaded_filename);
				
				}
				
				$this->form_validation->set_rules('txt_trade_name', addslashes(t('name')), 'required');
				$this->form_validation->set_rules('txt_email', addslashes(t('email')), 'valid_email|required');				
                $this->form_validation->set_rules('opt_state', addslashes(t('select province')), 'required');
				$this->form_validation->set_rules('opt_city', addslashes(t('select city')), 'required');
				//$this->form_validation->set_rules('txt_zip', addslashes(t('select postal code')), 'required');
				
				if(trim($this->input->post("i_trades_type"))==1)	//// VALIDATION FOR FREELANCER TYPE TRADESMAN
				{
					$this->form_validation->set_rules('txt_ssn', addslashes(t('name')), 'required');
				}
				if(trim($this->input->post("i_trades_type"))==2)   //// VALIDATION FOR FIRM TYPE TRADESMAN
				{
					$this->form_validation->set_rules('txt_firm_name', addslashes(t('firm name')), 'required');
					$this->form_validation->set_rules('txt_firm_phone', addslashes(t('firm phone')), 'required');
					$this->form_validation->set_rules('ta_firm_add1', addslashes(t('firm address1')), 'required');
					$this->form_validation->set_rules('txt_tax_office', addslashes(t('txt office name')), 'required');
					$this->form_validation->set_rules('txt_tax_number', addslashes(t('txt number')), 'required');
				}
				if($this->form_validation->run() == FALSE || ($arr_upload_res[0]==='err'))/////invalid
				{
					///Display the add form with posted values within it////
					$this->data["posted"]=$posted;
				}
				else
				{				
                    $info=array();
                   
					$info["s_email"]			=	$posted["txt_email"];					
					$info["i_province"]			=	$posted["opt_state"];
					$info["i_city"]				=	$posted["opt_city"];
					$info["i_zipcode"]			=	$posted["opt_zip"];					
					$info["i_sm"]				=	$posted["i_sm"];	// social media options like skype, msn, yahoo
					$info["s_sm"]				=	$posted["txt_sm"];					
					$info["i_type"]				=	$posted["i_trades_type"];	
					$info["s_gsm_no"]			=	$posted["txt_gsm"]?decrypt($posted['opt_gsm']).'-'.$posted["txt_gsm"]:"";	
					$info["s_taxoffice_name"]	=	$posted["txt_tax_office"];	
					$info["s_tax_no"]			=	$posted["txt_tax_number"];	
					$info["s_firm_name"]		=	$posted["txt_firm_name"];	
					$info["s_business_name"]	=	$posted["txt_trade_name"];
					$info["s_firm_phone"]		=	$posted["txt_firm_phone"]?decrypt($posted['opt_firm_phone']).'-'.$posted["txt_firm_phone"]:"";
					$info["s_address"]	        =	$posted["ta_firm_add1"];
					$info["s_address2"]	        =	$posted["ta_firm_add2"];
					$info["s_ssn"]				=	$posted["txt_ssn"];
					
					$info["i_edited_date"]		=	time();
					
					if(count($address_upload_res)==0)
					{
						$info["s_address_file"] = 	$posted['h_address'];
					}
					else
					{
						$info["s_address_file"] = 	$address_upload_res[2];
					}
					
					/* start  latitude and longitude  */
					$state 	 = $this->province_model->fetch_this(decrypt($info["i_province"]));
					//pr($state);
					$city 	 = $this->city_model->fetch_this(decrypt($info["i_city"]));
					$zipcode = $this->zipcode_model->fetch_this(decrypt($info["i_zipcode"]));
					
					$info['s_lat'] = $zipcode['latitude'];
    				$info['s_lng'] = $zipcode['longitude'];	
					
					//pr($info,1);
					
					$i_newid 			= 	$this->mod_td->set_edit_profile($info,$this->user_id);	
					$i_trade_details	=	$this->mod_td->update_profile_details($info,$this->user_id);
					if($i_newid)////saved successfully
					{	
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_profile"],'message_type'=>'succ'));
						redirect(base_url().'tradesman/edit-profile');
					}
					else///Not saved, show the form again
					{
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_profile_err"],'message_type'=>'err'));
						$this->render('tradesman/edit-profile');
					}
				
                    
                
				}
				
				
			}
            else
            {
                $this->data['info']            = $this->mod_td->fetch_this($this->user_id);
                //pr($this->data['info'],1);
                $gsm_arr = explode('-',$this->data['info']['s_gsm_no']);
                $this->data['gsm_code'] = $gsm_arr[0];
                $this->data['gsm_no']   = $gsm_arr[1];
                $firm_ph = explode('-',$this->data['info']['s_firm_phone']);
                $this->data['firm_code'] = $firm_ph[0];
                $this->data['firm_phone'] = $firm_ph[1];
				
				/* get province list with selected city */
				$this->load->model('common_model','mod_common');
				$tablename      =   $this->db->PROVINCE ;
				$arr_where      =   array('i_city_id'=>$this->data['info']["opt_city"]) ;
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
			   $arr_where		=	array('city_id'=>$this->data['info']["opt_city"],'province_id'=>$this->data['info']["opt_province"]) ;
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
				
            }			
			
			
			$this->render('tradesman/edit_profile');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
	/******************  END EDIT PROFILE ***********************/	
	
	/******************  START CHANGE PASSWORD ***********************/
	public function change_password()
    {
        try
        {
			$this->left_menu=4;
			$user_details = $this->session->userdata('loggedin');
			$this->data['user_id']	=	$user_details['user_id'];
			$this->data['breadcrumb'] = array(addslashes(t('Change Password'))=>'');	
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
				$is_pwd_correct	=	$this->mod_td->check_password($user_data['s_password'],$this->user_id);
				 
				 if($this->form_validation->run() == FALSE || empty($is_pwd_correct))/////invalid
				 {
					if(empty($is_pwd_correct))
					{
						$this->session->set_userdata(array('message'=>$this->cls_msg["wrong_pwd"],'message_type'=>'err'));
						redirect(base_url().'tradesman/change_password');							
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
					
					$i_newid = $this->mod_td->set_new_password($info,$this->user_id);
					if($i_newid)////saved successfully
					{
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_pwd"],'message_type'=>'succ'));	
						redirect(base_url().'tradesman/change-password');
					}
					else///Not saved, show the form again
					{
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_pwd_err"],'message_type'=>'err'));
						$this->render('tradesman/change-password');
					}
					
				
				}	
				
			}
			
			$this->render('tradesman/change_password');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
	
	/******************  END CHANGE PASSWORD ***********************/
	
	/****************  START CONTACT DETAILS OF TRADESMAN   *********************/
	public function contact_details()
    {
        try
        {					
			$this->left_menu=5;	
			$this->data['breadcrumb'] 		= array(addslashes(t('Contact Details'))=>'');
			$this->data['contact_details']	=	$this->mod_td->fetch_this($this->user_id);	
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
						
						$i_newid = $this->mod_td->set_contact_details($info,$this->user_id);
						if($i_newid)////saved successfully
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_contact"],'message_type'=>'succ'));
							redirect(base_url().'tradesman/contact-details');
						}
						else///Not saved, show the form again
						{
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_contact_err"],'message_type'=>'err'));
						//$this->render('tradesman/contact-details/');
						$this->data["posted"]=$posted;
						}
						
					
					}	
				
			
			}
				
			$this->render('tradesman/contact_details');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
	/****************  END CONTACT DETAILS OF TRADESMAN   *********************/
	
	
	/****************  START ALBUM UPLOAD   *********************/
	
	public function album()
    {
        try
        {
			$this->left_menu=3;
			
			$this->data['pathtoclass']=$this->pathtoclass;
			$user_details = $this->session->userdata('loggedin');
			//print_r($user_details);
			$user_id	=	decrypt($user_details['user_id']);
			$this->data['breadcrumb'] = array(addslashes(t('My Album'))=>'');	
			
			if($_POST)
			{				
				$posted=array();
                $posted["txt_title"]= trim($this->input->post("txt_title"));				
				
				//$this->form_validation->set_rules('f_image', 'browse photo', 'required');
				$s_user_id = " WHERE i_user_id=".$user_id." ";
				$max_photo = $this->mod_td->get_total_album_images($s_user_id);
				if($max_photo>14)
				{
					$this->session->set_userdata(array('message'=>$this->cls_msg["err_max_no"],'message_type'=>'err'));
					redirect(base_url().'tradesman/album');					
				}
				
				if(isset($_FILES['f_image']) && !empty($_FILES['f_image']['name']))
				{
					$s_uploaded_filename = get_file_uploaded( $this->uploadDir,'f_image','','',$this->allowedExt);					
					$arr_upload_res = explode('|',$s_uploaded_filename);
				}
					
				
				//print_r($arr_upload_res); exit;
				 if(($arr_upload_res[0]==='err'))/////invalid
					{
						///Display the add form with posted values within it////
						$this->data["posted"]=$posted;
					}
				else
					{
						
						$info=array();
						$info["s_title"]		=	$posted["txt_title"];
						$info["s_image"]		=	$arr_upload_res[2];
						//$info['i_user_id']		=	$this->user_id;
						$info['i_uploaded_date']=	time();
						
						//print_r($info); exit;
						$i_newid = $this->mod_td->upload_album_photo($info,$user_id);
						if($i_newid)////saved successfully
						{
							if($arr_upload_res[0]==='ok')
							{
								get_image_thumb($this->uploadDir.$info["s_image"], $this->thumbDir, 'thumb_'.$info["s_image"],$this->t_ht,$this->t_wd,'');
							}	
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_album"],'message_type'=>'succ'));
							redirect(base_url().'tradesman/album');
						}
						else///Not saved, show the form again
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_err"],'message_type'=>'err'));
							$this->render('tradesman/album');
						}
					}	
			}
			ob_start();
			$this->ajax_pagination_album(0,1);
			$contents = ob_get_contents();
			ob_end_clean();
			$images = explode('^',$contents);
			
			$this->data['images'] 	  = $images[0];
			$this->data['tot_images'] = $images[1];			
			
			$this->render('tradesman/album');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	function ajax_pagination_album($start=0,$param=0) 
	{	
		$s_where='';
		$user_details 	= $this->session->userdata('loggedin');
		$user_id		=	decrypt($user_details['user_id']);
		$s_where 		= " WHERE i_user_id=".$user_id." "; 
		$limit			=  $this->i_fe_page_limit = 5;
		
		$this->data['images'] 	= $this->mod_td->get_album_images($s_where,intval($start),$limit);			
		$total_rows 			= $this->mod_td->get_total_album_images($s_where);
		
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'tradesman/ajax_pagination_album/';
		$paging_div = 'image_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		if(empty($param))
			$job_vw = $this->load->view('fe/tradesman/ajax_pagination_album.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/tradesman/ajax_pagination_album.tpl.php',$this->data,TRUE).'^'.$total_rows;
		echo $job_vw;
		/* pagination end */

	
	}	
	
	/****************  END ALBUM UPLOAD   *********************/
	
	/****************  START PROFESSIONAL INFORMATION OF TRADESMAN   *********************/
	public function professional_information()
    {
        try
        {		
			$this->left_menu=8;		
			$this->data['breadcrumb'] = array(addslashes(t('Professional Information'))=>'');
			$user_details = $this->session->userdata('loggedin');
			$this->data['user_id']	=	$user_details['user_id'];
			$this->data['info']		= $this->mod_td->fetch_this($this->user_id);
			//pr($this->data['info'],1);
			
			/* multiple values for work place, payment unit, payment time */
			$s_cond	= "WHERE n.i_user_id = ".$this->user_id." ";
			$this->data['work_place']	 =	$this->mod_td->fetch_all_work_place($s_cond);
			$this->data['counter_place'] =	count($this->data['work_place']);
			
			$this->data['pay_unit']	 =	$this->mod_td->fetch_tradesmen_payment_unit($s_cond);
			$this->data['count_pay_unit'] =	count($this->data['pay_unit']);
			//pr($this->data['pay_unit']);
			$this->data['pay_time']	 =	$this->mod_td->fetch_tradesmen_payment_time($s_cond);
			$this->data['count_pay_time'] =	count($this->data['pay_time']);
			
			$arr_cond	=	array('i_user_id'=>$this->user_id);
			$s_table 	=	$this->db->TRADESMAN_WORKING_DAYS;
			$this->data['work_days']	=	$this->mod_common->common_fetch($s_table,$arr_cond);
			//pr($this->data['work_days'],1);
			unset($s_table,$arr_cond);
			/* multiple values for work place, payment unit, payment time */
			
			/* fetch all category with experience of tradesman */
			$category_list	=	$this->mod_td->fetch_all_category($s_cond);
            $posted['working'] = array();
			foreach($category_list as $val)
            {
                  $posted['working'][]=encrypt($val['id']);
				  $posted['experience'][]=encrypt($val['s_experience']);
            }
            $this->data['cnt_working'] = count($category_list)  ;
			$this->data['cat_exp'] =$posted;
			//pr($this->data['cat_exp']); exit;
			/* fetch all category with experience of tradesman */
			
			if($_POST)
			{	
				$posted	=	array();
				$posted["txt_keyword"] 		= trim($this->input->post('txt_keyword'));
				$posted["ta_about"] 		= trim($this->input->post('ta_about'));  // about tradesman
				$posted["txt_work_place"] 	= $this->input->post('txt_work_place');
				$posted["workdays"] 		= $this->input->post('workdays');  // checkboxes for working days
				$posted["txt_pay_unit"] 	= $this->input->post('txt_pay_unit');
				$posted["txt_when_to_pay"] 	= $this->input->post('txt_when_to_pay');
				
				$posted["working"] 			= $this->input->post('working');	  // category specialist
				$posted["experience"] 		= $this->input->post('experience');	// experience in years
				
				$posted["h_logo"] 			= $this->input->post('h_logo');
				$posted["h_photo"] 			= $this->input->post('h_photo');
				
				//pr($posted['txt_pay_unit'],1);
				$arr_upload_logo = array();
				if(isset($_FILES['f_logo']) && !empty($_FILES['f_logo']['name']))
				{
					$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'f_logo','','',$this->allowedExt);					
					$arr_upload_logo = explode('|',$s_uploaded_filename);	
					
					get_file_deleted($this->uploaddir,$posted['h_logo']); // deleteing previous image from system
					get_file_deleted($this->thumbdir,'thumb_'.$posted['h_logo']); // deleteing previous thumb image from system
									
				}
				
				$arr_upload_photo = array();
				if(isset($_FILES['f_photo']) && !empty($_FILES['f_photo']['name']))
				{
					$s_uploaded_filename = get_file_uploaded($this->uploaddir,'f_photo','','',$this->allowedExt);					
					$arr_upload_photo = explode('|',$s_uploaded_filename);
					
					get_file_deleted($this->uploaddir,$posted['h_photo']); // deleteing previous image from system
					get_file_deleted($this->thumbdir,'thumb_'.$posted['h_photo']); // deleteing previous thumb image from system
					
				}
				
				$this->form_validation->set_rules('txt_keyword', addslashes(t('working place')), 'required');
				
				if($this->form_validation->run() == FALSE)/////invalid
				{
					$this->data["posted"]=$posted;
					
				}
				else
				{
					
					$info=array();
					$info["s_about_me"]		=	$posted["ta_about"];
					$info["s_keyword"]		=	$posted["txt_keyword"];
					/*if(count($arr_upload_photo)==0)
					{
						$info["s_profile_pic"] = 	$posted['h_photo'];
					}
					else
					{
						$info["s_profile_pic"] = 	$arr_upload_photo[2];
					}*/
					if(count($arr_upload_logo)==0)
					{
						$info["s_firm_logo"] = 	$posted['h_logo'];
					}
					else
					{
						$info["s_firm_logo"] = 	$arr_upload_logo[2];
					}
					
					
					if(!empty($posted["txt_pay_unit"]))   // ADD TRADESMAN PAYMENT TYPE
					{
						$table_name =   $this->db->TRADESMAN_PAYMENT_TYPE;
						$arr_where  =   array('i_user_id'=>$this->user_id) ; 
						$this->mod_common->common_delete_info($table_name,$arr_where); //Delete all payment type
						$info_pay    =   array();
						$info_pay['i_user_id'] =  intval($this->user_id);
						
						foreach($posted["txt_pay_unit"] as $value)
						{
							if($value!='')
							{
								$info_pay['s_payment_unit']   =   decrypt(trim($value));  // id of cash, credit card etc.
								$this->mod_common->common_add_info($table_name,$info_pay); //Add new payment type    
							}  
	
						}
						unset($table_name,$info_pay);
					}
					
					if(!empty($posted["txt_when_to_pay"]))   // ADD TRADESMAN PAYMENT TIMES
					{
						$tab_name =   $this->db->TRADESMAN_PAYMENT_TIME;
						$s_where  =   array('i_user_id'=>$this->user_id) ; 
						$this->mod_common->common_delete_info($tab_name,$s_where); //Delete all payment type
						$pay_time    =   array();
						$pay_time['i_user_id'] =  intval($this->user_id);
						
						foreach($posted["txt_when_to_pay"] as $value)
						{
							if($value!='')
							{
								$pay_time['s_pay_time']   =   trim($value);
								$this->mod_common->common_add_info($tab_name,$pay_time); //Add new payment type    
							}  
	
						}
						unset($tab_name,$pay_time);
					}
					
					if(!empty($posted["txt_work_place"]))   // ADD TRADESMAN WORKING PLACE
					{
						$s_table =   $this->db->TRADESMAN_WORKING_PLACE;
						$cond  =   array('i_user_id'=>$this->user_id) ; 
						$this->mod_common->common_delete_info($s_table,$cond); //Delete all
						$place   =   array();
						$place['i_user_id'] =  intval($this->user_id);
						
						foreach($posted["txt_work_place"] as $value)
						{
							if($value!='')
							{
								$place['s_work_place']   =   trim($value);
								$this->mod_common->common_add_info($s_table,$place); //Add new    
							}  
	
						}
						unset($s_table,$place,$cond);
					}
					
					if(!empty($posted["workdays"]))   // ADD TRADESMAN WORKING DAYS
					{
						$table_name =   $this->db->TRADESMAN_WORKING_DAYS;
						$arr_where  =   array('i_user_id'=>$this->user_id) ; 
						$this->mod_common->common_delete_info($table_name,$arr_where); //Delete all working days
						$info_pay    =   array();
						$info_pay['i_user_id'] =  intval($this->user_id);
						
						foreach($posted["workdays"] as $value)
						{
							if($value!='')
							{
								$info_pay['i_work_days']   =   trim($value);
								$this->mod_common->common_add_info($table_name,$info_pay); //Add new working days   
							}  
	
						}
						unset($table_name,$info_pay);
					}
					
					if(!empty($posted['working']) && !empty($posted['experience']))	// ADD TRADESMAN CATEGORY
					{
						$table_name =   $this->db->TRADESMANCAT;
						$arr_where  =   array('i_user_id'=>$this->user_id) ; 
						$this->mod_common->common_delete_info($table_name,$arr_where); //Delete all category
						$info_new   =   array();
						$info_new['i_user_id'] =  intval($this->user_id);
						
						foreach($posted["working"] as $key=>$value)
						{
							if($value!='')
							{
								$info_new['i_category_id']   =   decrypt($value);
								$info_new['s_experience']    =   decrypt($posted['experience'][$key]);
								$this->mod_common->common_add_info($table_name,$info_new); //Add new categories   
							}  
	
						}
						unset($table_name,$info_pay);
					}
					
						
					
					$i_aff = $this->mod_td->update_professional_information($info,$this->user_id);
					
					$update_image = $this->mod_td->update_professional_image($info,$this->user_id);
					if($i_aff)////saved successfully
					{
						if($arr_upload_photo[0]==='ok')
						{
							get_image_thumb($this->uploaddir.$info["s_profile_pic"], $this->thumbdir, 'thumb_'.$info["s_profile_pic"],$this->nw_height,$this->nw_width,'');
						}
						if($arr_upload_logo[0]==='ok')
						{
							get_image_thumb($this->uploaddir.$info["s_firm_logo"], $this->thumbdir, 'thumb_'.$info["s_firm_logo"],$this->nw_height,$this->nw_width,'');
						}
						$this->session->set_userdata(array('message'=>$this->cls_msg["prof_info_save"],'message_type'=>'succ'));
						redirect(base_url().'tradesman/professional-information');
					}
					else///Not saved, show the form again
					{
					$this->session->set_userdata(array('message'=>$this->cls_msg["prof_info_err"],'message_type'=>'err'));
					$this->data["posted"]=$posted;
					}

				}		
			}
					
			$this->render();
			unset($s_cond);
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
	/****************  END PROFESSIONAL INFORMATION OF TRADESMAN   *********************/
	
	/********************** JOBS SECURED BY TRADESMAN  ***********************/
	
	/* job invitation */
	public function job_invitation()
    {
   		try
		{
			
			$this->left_menu	=	10;
			$this->data['breadcrumb'] = array(addslashes(t('Job Invitations'))=>'');	
			$this->data['pathtoclass']= $this->pathtoclass;
			//$this->data['i_tradesman_id'] = $this->user_id;
			
			if($_POST)
			{
				$sessArrTmp['i_category_id']  	= decrypt(trim($this->input->post('category')));	
				$sessArrTmp['opt_city'] 		= decrypt(trim($this->input->post('opt_city')));					
				$sessArrTmp['opt_state'] 		= decrypt(trim($this->input->post('opt_state')));
			}  
			$this->session->set_userdata(array('model_session'=>$sessArrTmp));	// to store data in session
			$this->data['posted'] = $sessArrTmp;
			
			ob_start();
			$this->invite_jobs_pagination_ajax();
			$job_contents = ob_get_contents();
			ob_end_clean();
			//var_dump($job_contents);exit;
			$this->data['job_contents'] = $job_contents;
			$this->render();
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
    }
   
   /* Ajax pagination for invitation jobs */
	function invite_jobs_pagination_ajax($start=0) 
	{	
		//$s_where = " WHERE inv.i_tradesman_id = {$this->user_id} AND inv.i_status=1 "; 
		//$s_where = " WHERE 1 "; 
		$arr_search[] = " inv.i_tradesman_id = {$this->user_id} AND inv.i_status=1 ";
		$sessArrTmp['i_category_id']  	= $this->get_session_data('i_category_id');
		$sessArrTmp['opt_city'] 		= $this->get_session_data('opt_city');
		$sessArrTmp['opt_state']  		= $this->get_session_data('opt_state');
		
		if($sessArrTmp['i_category_id'])
		{
			$arr_search[] =" n.i_category_id=".$sessArrTmp['i_category_id'];
		}	
		if($sessArrTmp['opt_city'])
		{
			$arr_search[] =" n.i_city_id=".$sessArrTmp['opt_city'];
		}
		if($sessArrTmp['opt_state'])
		{
			$arr_search[] =" n.i_province_id=".$sessArrTmp['opt_state'];
		}
		
		
		$s_where .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
		
		$limit	= $this->i_fe_page_limit;				
		$this->data['job_list']	= $this->job_model->fetch_multi($s_where,intval($start),$limit);		
		$total_rows 			= $this->job_model->gettotal_job_invitation($s_where);
		/* pagination start @ defined in common-helper */
        $ctrl_path     				  = base_url().'tradesman/invite_jobs_pagination_ajax/';
        $paging_div 				  = 'job_list';
        $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
        $this->data['total_rows']     = $total_rows;
        $this->data['start']          = $start;
		
		$this->load->view('fe/tradesman/ajax_invitation_jobs.tpl.php',$this->data);
			
	}   
	
	/* all my own jobs*/
	public function my_won_jobs()
    {
   		try
		{
			$this->data['breadcrumb'] = array(addslashes(t('My Won Jobs'))=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			$this->data['i_tradesman_id'] = $this->user_id;
			
			ob_start();
			$this->won_jobs_pagination_ajax();
			$job_contents = ob_get_contents();
			ob_end_clean();
			//var_dump($job_contents);exit;
			
			
			$this->data['job_contents'] = $job_contents;
			$this->render('fe/tradesman/my_won_jobs');
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
    }
	
	/* Ajax pagination for my won jobs */
	function won_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND (n.i_status=4 || n.i_status=6 || n.i_status=10) AND n.i_is_deleted!=1 "; 
		
		$limit	= $this->i_fe_page_limit;				
		$this->data['job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);		
		//pr($this->data['job_list'],1);
		$total_rows = $this->job_model->gettotal_info($s_where);	
		/* pagination start @ defined in common-helper */
        $ctrl_path     				  = base_url().'tradesman/won_jobs_pagination_ajax/';
        $paging_div 				  = 'job_list';
        $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
        $this->data['total_rows']     = $total_rows;
        $this->data['start']          = $start;		
		
		echo $this->load->view('fe/tradesman/ajax_my_won_jobs.tpl.php',$this->data,TRUE);
			
	}   
	
	
	/* jobs you got */
    public function frozen_jobs()
    {
   		try
		{
			
			$this->left_menu	=	12;
			$this->data['breadcrumb'] = array(t('Job You Got')=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			
			$this->data['i_tradesman_id'] = $this->user_id;
			ob_start();
			$this->frozen_jobs_pagination_ajax();
			$job_contents = ob_get_contents();
			ob_end_clean();
			//var_dump($job_contents);exit;
			$this->data['job_contents'] = $job_contents;
			$this->render();
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
   }
   
   /* Ajax pagination for jobs you got  */
	function frozen_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=8 AND n.i_is_deleted!=1 "; 

		$limit	= $this->i_fe_page_limit;		
			
		$this->data['job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);	
		$total_rows = $this->job_model->gettotal_info($s_where);	
		//pr($this->data['job_list'],1);
		/* pagination start @ defined in common-helper */
        $ctrl_path     				  = base_url().'tradesman/frozen_jobs_pagination_ajax/';
        $paging_div 				  = 'job_list';
        $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
        $this->data['total_rows']     = $total_rows;
        $this->data['start']          = $start;
       
        echo $this->load->view('fe/tradesman/ajax_frozen_jobs.tpl.php',$this->data,TRUE);
			
	}  
	
	/* progress jobs
	* author @ mrinmoy
	*/
	public function progress_jobs()
    {
   		try
		{
			
			$this->left_menu	=	13;
			$this->data['breadcrumb'] = array(t('In Progress Jobs')=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			
			$this->data['i_tradesman_id'] = $this->user_id;
			ob_start();
			$this->progress_jobs_pagination_ajax();
			$job_contents = ob_get_contents();
			ob_end_clean();
			//var_dump($job_contents);exit;
			$this->data['job_contents'] = $job_contents;
			$this->render();
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
   }
   
   /* Ajax pagination for progress jobs  */
	function progress_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND (n.i_status=4 || n.i_status=5) AND n.i_is_deleted!=1 "; 

		$limit	= $this->i_fe_page_limit;		
			
		$this->data['job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);	
		$total_rows = $this->job_model->gettotal_info($s_where);	
		//pr($this->data['job_list'],1);
		/* pagination start @ defined in common-helper */
        $ctrl_path     				  = base_url().'tradesman/progress_jobs_pagination_ajax/';
        $paging_div 				  = 'job_list';
        $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
        $this->data['total_rows']     = $total_rows;
        $this->data['start']          = $start;
       
        echo $this->load->view('fe/tradesman/ajax_progress_jobs.tpl.php',$this->data,TRUE);
			
	}  
	
	/* pending jobs
	* author @ mrinmoy
	*/
	public function pending_jobs()
    {
   		try
		{
			
			$this->left_menu	=	14;
			$this->data['breadcrumb'] = array(t('Pending Jobs')=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			
			$this->data['i_tradesman_id'] = $this->user_id;
			ob_start();
			$this->pending_jobs_pagination_ajax();
			$job_contents = ob_get_contents();
			ob_end_clean();
			//var_dump($job_contents);exit;
			$this->data['job_contents'] = $job_contents;
			$this->render();
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
   }
   
   /* Ajax pagination for pending jobs  */
	function pending_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=11 AND n.i_is_deleted!=1 "; 

		$limit	= $this->i_fe_page_limit;		
			
		$this->data['job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);	
		$total_rows = $this->job_model->gettotal_info($s_where);	
		//pr($this->data['job_list'],1);
		/* pagination start @ defined in common-helper */
        $ctrl_path     				  = base_url().'tradesman/pending_jobs_pagination_ajax/';
        $paging_div 				  = 'job_list';
        $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
        $this->data['total_rows']     = $total_rows;
        $this->data['start']          = $start;
       
        echo $this->load->view('fe/tradesman/ajax_pending_jobs.tpl.php',$this->data,TRUE);
			
	} 
	
	
	/* completed jobs
	* author @ mrinmoy
	*/
	public function completed_jobs()
    {
   		try
		{
			
			$this->left_menu	=	15;
			$this->data['breadcrumb'] = array(t('Completed Jobs')=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			
			$this->data['i_tradesman_id'] = $this->user_id;
			ob_start();
			$this->completed_jobs_pagination_ajax();
			$job_contents = ob_get_contents();
			ob_end_clean();
			//var_dump($job_contents);exit;
			$this->data['job_contents'] = $job_contents;
			$this->render();
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
   }
   
   /* Ajax pagination for completed jobs  */
	function completed_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=6 AND n.i_is_deleted!=1 "; 

		$limit	= $this->i_fe_page_limit;		
			
		$this->data['job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);	
		$total_rows = $this->job_model->gettotal_info($s_where);	
		//pr($this->data['job_list'],1);
		/* pagination start @ defined in common-helper */
        $ctrl_path     				  = base_url().'tradesman/completed_jobs_pagination_ajax/';
        $paging_div 				  = 'job_list';
        $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
        $this->data['total_rows']     = $total_rows;
        $this->data['start']          = $start;
       
        echo $this->load->view('fe/tradesman/ajax_completed_jobs.tpl.php',$this->data,TRUE);
			
	} 
	
	/* feedbacks received from buyers */
	public function feedbacks()
	{
		try
		{
			$this->left_menu	=	16;
			$this->data['breadcrumb'] = array(addslashes(t('Feedback Received'))=>'');	
			ob_start();				
			//$id = $this->data['loggedin']['user_id'];			  
			$this->ajax_pagination_feedback_list();
			$contents = ob_get_contents();
			ob_end_clean();
			
			$info = $this->mod_td->fetch_tradesman_details(decrypt($id));
			$this->data['profile_info'] = $info;
			$this->data['feedback_contents'] = $contents;
				
			$this->render();
			
		}
		catch(Exeception $e)
		{
			show_error($e->getMessage());
		}
   }
   
   /* ajax pagination for feedback received */
   public function ajax_pagination_feedback_list($start=0) 
   {
		$limit	= $this->i_fe_page_limit;
		$s_id 	= $this->user_id; // loggedin user id
		$this->load->model("Manage_feedback_model","mod_feed");
		$s_where 	= " WHERE n.i_receiver_user_id = ".$s_id." AND n.i_status != 0  "; 
		$feedback 	= $this->mod_feed->fetch_multi($s_where,intval($start),$limit);	
		//pr($feedback,1);	
		$total_rows = $this->mod_feed->gettotal_info($s_where);			
		$this->data['feedbacks'] = $feedback;
		
		/* pagination start @ defined in common-helper */
        $ctrl_path     				  = base_url().'tradesman/ajax_pagination_feedback_list/';
        $paging_div 				  = 'feedback_list';
        $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
        $this->data['total_rows']     = $total_rows;
        $this->data['start']          = $start;
		
		
		$job_vw = $this->load->view('fe/tradesman/ajax_pagination_feedbacks.tpl.php',$this->data,TRUE);
		
		echo $job_vw;		
	}	
	
	
	/********************** END JOBS SECURED BY TRADESMAN  ***********************/
	
	
	
	/****************  START TESTIMONIAL OF TRADESMAN   *********************/
	public function testimonial()
	{
        try
        {
			$this->left_menu=21;
			$this->data['breadcrumb'] = array(addslashes(t('My Testimonial'))=>'');	
			$user_details = $this->session->userdata('loggedin');
			$user_name	=	$user_details['user_name'];
			$this->data['user_id']	=	$user_details['user_id'];
			if($_POST)
			{
				$posted=array();
                $posted["txt_content"]= trim($this->input->post("ta_content"));				
				$this->form_validation->set_rules('ta_content', addslashes(t('provide testimonial')), 'required');
				
				 if($this->form_validation->run() == FALSE)/////invalid
					{
						///Display the add form with posted values within it////
						$this->data["posted"]=$posted;
					}
				else
					{
						
						$info=array();
						$info["s_content"]	=	$posted['txt_content'];
						$info['dt_entry_date'] = time();
						
						$i_newid = $this->mod_td->add_new_testimonial($info,$user_name);
						if($i_newid)////saved successfully
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_testimoni"],'message_type'=>'succ'));
							redirect(base_url().'tradesman/testimonial');
						}
						else///Not saved, show the form again
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["testimoni_err"],'message_type'=>'err'));
							$this->render('tradesman/testimonial');
						}
					}	
			}
			
			
			ob_start();
			$this->ajax_pagination_testimonial(0,1);
			$contents = ob_get_contents();
			ob_end_clean();
			$testi = explode('^',$contents);			
			$this->data['testimonial'] 	  = $testi[0];
			 
			$this->render('tradesman/testimonial');
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
		
		$this->data['testimonial'] 	= $this->mod_td->fetch_testimonial($s_where,intval($start),$limit);			
		
		$this->load->model('testimonial_model');
		$total_rows 				= $this->testimonial_model->gettotal_info($s_where);
		
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'tradesman/ajax_pagination_testimonial/';
		$paging_div = 'testimonial_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		if(empty($param))
			$job_vw = $this->load->view('fe/tradesman/ajax_pagination_testimonial.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/tradesman/ajax_pagination_testimonial.tpl.php',$this->data,TRUE).'^'.$total_rows;
		echo $job_vw;
		/* pagination end */

	
	}	
	
	/****************  END TESTIMONIAL OF TRADESMAN   *********************/
	
    
    /**
    * This function use PAYPAL IPN and update membership plan
    * 
    */
    public function payment_update_membership()
    {
        try
        {
            $i_membership_plan  =   $this->input->post('radio_membership_plan');// paypal transaction
            $payment_type       =   $this->input->post('payment_type');

            $this->load->model('membership_model','mod_member');
            
            if($i_membership_plan   ==  1)
            {
                $s_where    =   ' WHERE n.i_type=3 ';
            }
            else if($i_membership_plan   ==  2)
            {
                $s_where    =   ' WHERE n.i_type=4 ';
            }
            
            $info_member    =   $this->mod_member->fetch_multi($s_where);
            
            if(!empty($info_member) && count($info_member))
            {
                $d_amount    =   $info_member[0]['d_price'] ;
                $i_plan_id   =   $info_member[0]['id'] ;   
                $i_quotes    =   $info_member[0]['i_quotes'] ;
                $i_contact_info=   $info_member[0]['i_contact_info'] ;
                $i_duration  =   $info_member[0]['i_duration'] ;
                $i_plan_type =   $info_member[0]['i_type'] ;
            }
            //unset();
            
            
            if($d_amount>0)
            {
                $this->load->model('site_setting_model');
                $site_settings = $this->site_setting_model->fetch_this(1);
                
                
                include_once(APPPATH.'libraries/paypal_IPN/paypal.class.php');    
                $data['title'] = t("Payment");
                
                $PAYPAL_ENVIRONMENT = 'test';
                $LOGGED_USR_ID = $this->user_id;
                $TOTAL_AMOUNT  = $d_amount;
                $SHIPPING_AMOUNT = 0;
                
                $IPN_OBJ = new paypal_class;     // initiate an instance of the IPN class...
                $IPN_OBJ->paypal_url = $this->config->item('paypal_url');//$this->site_settings_model->getPaypalURL($PAYPAL_ENVIRONMENT);
                $IPN_OBJ->add_field('cmd', '_cart');
                $IPN_OBJ->add_field('upload', 1);
                $IPN_OBJ->add_field('business', $site_settings['s_paypal_email']);
                
                
                $data['paypal_obj'] = $IPN_OBJ;
                $data['cart_contents'] = $CART_CONTENTS_ARR;

                # fixing shipping amount etc...
                
                $TOTAL_AMOUNT = $TOTAL_AMOUNT + $SHIPPING_AMOUNT;
                $data['total_charge'] = $TOTAL_AMOUNT;
                $data['shipping_charge'] = $SHIPPING_AMOUNT;
                $data['paypal_account'] = $site_settings['s_paypal_email'];
                $data['user_id'] = $LOGGED_USR_ID;
                $data['plan_id']        = $i_plan_id;
                $data['plan_type']      = $i_plan_type;
                $data['i_quotes']       = $i_quotes;
                $data['i_contact_info'] = $i_contact_info;
                $data['i_duration']     = $i_duration;
                
                $data['item_name'] = 'Membership payment';
                
                $data['currency'] = $this->config->item('default_currency_code');
                $this->session->set_userdata(array('ses_data_temp'=>$data));
                //print_r($this->session->userdata('ses_data_temp')); exit;
                $this->load->view('fe/tradesman/place_paypal_order.tpl.php', $data);  
            }
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    function payment_success_membership()
    {        
    
        # loading meta-data and header-data...
        include_once(APPPATH.'libraries/paypal_IPN/paypal.class.php');    
        $data = $this->data;
        $data['title'] = t("Payment Success");

        # processing all IPN data...
        $PAYPAL_ENVIRONMENT = 'test';
        //$this->load->model('site_settings_model');
        
        $IPN_OBJ = new paypal_class;     // initiate an instance of the IPN class...
        $IPN_OBJ->paypal_url = $this->config->item('paypal_url');//$this->site_settings_model->getPaypalURL($PAYPAL_ENVIRONMENT);


        if ($IPN_OBJ->validate_ipn()) {

            $body = '';
            $IPN_ARR = array();
            foreach ($IPN_OBJ->ipn_data as $key => $value)
            {
                $body .= "\r\n$key: $value";
                $IPN_ARR[$key] = $value;
            }

        }
        
       /* echo '<pre>';
        print_r($IPN_ARR);
        echo '</br>';
        var_dump($IPN_OBJ); exit*/;
        
        //print_r($body);
        //exit;
        # testing part [start]
        $filesrc = $this->file_path . 'ipn.txt';
        $fp = fopen($filesrc, 'w');
        fwrite($fp, $body);
        fclose($fp);
        # testing part [end]...


        
        # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //echo $IPN_OBJ->ipn_data['mc_gross'];
        //pr($IPN_OBJ->ipn_data['mc_gross']);exit;
        //var_dump($IPN_ARR);
        

        //// 1st, retrieving user-id (purchaser) and product-ids...
        //list($PURCHASER_ID, $itemIds) = explode('&', $IPN_ARR['custom']);
        
        $temp = $this->session->userdata('ses_data_temp');
        
        $i_tradesman_id = $temp['user_id'];
        $i_plan_id      = $temp['i_plan_id'];
        $info   =   array();
        $info['i_tradesman_id']             =   $temp['user_id'] ;
        $info['i_membership_plan_id']       =   $temp['plan_id'] ;
        $info['i_quotes']                   =   $temp['i_quotes'] ;
        $info['i_contact_info']             =   $temp['i_contact_info'] ;
        $info['i_duration']                 =   $temp['i_duration'] ;
        $info['d_price']                    =   $temp['total_charge'] ;
        $info['plan_type']                  =   $temp['plan_type'] ;
        
        $i_aff  =    $this->mod_td->update_membership_plan($info);

        
        
        if($i_aff)
        {
            
            $conf =& get_config();
            $membership_plan    =   $this->db->MEMBERPLAN   ;
            $arr_trades =   $this->mod_td->fetch_tradesman_details($info['i_tradesman_id']);
            
            
            $invoice_no = 100000+intval($i_aff);
            if(!empty($arr_trades))
            {
                $customer_name     = $arr_trades['s_business_name'];
                $address           = $arr_trades['s_address'];
                $province          = $arr_trades['s_province'];
                $city              = $arr_trades['s_city'];
                $postal            = $arr_trades['s_postal_code'];
                $payment_date      = date($conf["site_date_format"],time());
                $membership_plan   =  $membership_plan[$info['plan_type']];
                $payment_cost      = $info['d_price'] ;
                $paid_amount    = number_format($info['d_price'], 2, '.', '');
                $paid_amount_word = convert_number($paid_amount);
                
            }
       
        $logo_path = BASEPATH.'../images/fe/logo.png';
        $right_image_path = BASEPATH.'../images/fe/grey_up.png';
        $left_image_path = BASEPATH.'../images/fe/grey_down.png';
		
        
        /* html for pdf */    
        $html_n = '<html>
                    <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
                    <title>www.hizmetuzmani.com</title>
                    </head>
                    <body style="margin:0px; padding:0px;">
                    <table style="width:600px; margin:0px auto; line-height:16px; background-color:#FFFFFF; color:#000;font-size:12px;font-family:Arial, Helvetica, sans-serif;" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                  <td width="60%" style="padding:5px 12px"><img src="'.$logo_path.'" alt="" style="margin-top:5px;" /></td>
                                                  <td width="40%" align="right" style="padding:5px 12px;color:#616161;"><br />
                    <br />
                    </td>
                                            </tr>
                                      </table></td>
                          </tr>
                          
                          <tr>
                                <td style="border-bottom:1px solid #bfbfbf;border-top:1px solid #bfbfbf; text-transform:uppercase; font-size:16px; font-family:myriad Pro, arial;" align="right"><p style="padding:7px 12px; margin:0px;"><strong>RECEIPT NO :</strong> <span style="color:#f87d33;"><strong>'.$invoice_no.'</strong></span></p></td>
                          </tr>
                          <tr>
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                  <td width="57%" style="padding:12px ;color:#616161;"><span style="color:#000;"><strong>'.$customer_name.'</strong></span><br />
                                                        '.$address .',<br />
                                                        '.$province.', '.$city.',<br />
                                                        '.$postal.'</td>
                                                  <td width="43%" align="right" valign="top" style="color:#616161;padding:12px;"><span style="color:#000;"><strong>Date:</strong></span> '.$payment_date.'</td>
                                            </tr>
                                      </table></td>
                          </tr>

                          
                          <tr>
                                <td  style="background-color:#f1f1f1;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                  <td align="right" valign="top"><img src="'.$right_image_path.'" alt="" /> </td>
                                            </tr>
                                            <tr>
                                                  <td style="padding:0px 30px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                              <tr>
                                                                    <td width="73%" style="border-bottom:1px solid #b5b5b5; font-size:14px;  text-transform:uppercase;padding:0px 12px 12px;" ><strong>Description</strong></td>
                                                                    <td width="16%" style="border-bottom:1px solid #b5b5b5;font-size:14px; text-transform:uppercase;padding:0px 12px 12px;"><strong>Amount(TL)</strong></td>
                                                              </tr>
                                                              <tr>
                                                                    <td style="border-bottom:1px solid #b5b5b5; padding:8px;" height="80"   align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                                <tr>
                                                                                      <td width="31%" align="left" valign="top">Membership Plan : </td>
                                                                                      <td width="69%" valign="top" style="color:#616161;"> '.$membership_plan.' </td>
                                                                                </tr>
                                                                                <tr>
                                                                                      <td valign="top" align="left"> Pay amount : </td>
                                                                                      <td style="color:#616161;" valign="top"> '.$payment_cost.' </td>
                                                                                </tr>
                                                                                
                                                                          </table></td>
                                                                    <td style="border-bottom:1px solid #b5b5b5;border-left:1px solid #b5b5b5;padding:12px;" align="center" valign="top">'.$paid_amount.' </td>
                                                              </tr>
                                                              <tr>
                                                                    <td style="border-bottom:1px solid #b5b5b5; font-size:14px;padding:12px 12px;"  align="right" valign="top"> Net Payable Amount</span> </td>
                                                                    <td style="border-bottom:1px solid #b5b5b5;font-size:14px;color:#f87d33;border-left:1px solid #b5b5b5;padding:12px 12px;" align="center" valign="top"><strong>'.$paid_amount.' </strong> </td>
                                                              </tr>
                                                        </table>
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="3" style="margin:10px 8px 0px;">
                                                             <tr>
                                                                <td width="30%" valign="top"> Payment Method  :</td>
                                                                <td width="70%" style="color:#616161;" valign="top"> PAYPAL </td>
                                                             </tr>
                                                        </table></td>
                                            </tr>
                                            <tr>
                                                  <td align="left" valign="baseline"><p style="height:30px; overflow:hidden; padding:0px; margin:0px;background-color:#f1f1f1;"><img src="'.$left_image_path.'" alt="" /> </p></td>
                                            </tr>
                                      </table></td>
                          </tr>
                          <tr>
                                <td colspan="2" style=" color:#09c7e4; padding-top:5px; font-size:11px; text-align:center; font-family:Georgia, Times New Roman, Times, serif; "><strong>www.hizmetuzmani.com</strong></td>
                          </tr>

                    </table>
                    </body>
                    </html>';   
        /* html for pdf */  

           
       $this->load->plugin('to_mailpdf');
       $ffname = 'receipt_'.time();
       pdf_create($html_n, $ffname);
       
       
       
       $attachment_pdf  = $this->config->item('ATTACHMENT_PDF_PATH').$ffname.'.pdf';
 
            /* end generating invoice */        
            
            
           /* for job quote mail to the user */
           
           $user_info  =   $this->data['loggedin']   ; // login data
          // $membership_plan
           
           $this->load->model('auto_mail_model');
           $content = $this->auto_mail_model->fetch_mail_content('membership_payment_success','tradesman',$user_info['signup_lang_prefix']);   // send sign up language prefix for fetch email in perticular language only in which language user sign up.... 
           
            $filename = $this->config->item('EMAILBODYHTML')."common.html";
            $handle = @fopen($filename, "r");
            $mail_html = @fread($handle, filesize($filename));
            $s_subject  =   $content['s_subject'];                 
            //print_r($content); exit;[invoice no.]
            if(!empty($content))
            {
                $description = $content["s_content"];
                $description = str_replace("[USER_NAME]",$user_info['user_name'],$description);
                $description = str_replace("[MEMBERSHIP_PLAN]",$membership_plan,$description);
                $description = str_replace("[AMOUNT]",'TL '.$paid_amount,$description);
                $description = str_replace("[INVOICE_NO]",$invoice_no,$description);
                $description = str_replace("[LOGIN_URL]",base_url().'user/login/TVNOaFkzVT0',$description);    
                $description = str_replace("[SITE_URL]",base_url(),$description);
            }
            //unset($content);
            
            $mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);    
            $mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);                        
            //echo "<br>".$mail_html;    exit;
            
            /// Mailing code...[start]
            $site_admin_email = $this->s_admin_email;    
            $this->load->helper('mail');                                        
            $i_newid = sendMail($user_info['user_email'],$s_subject,$mail_html,$attachment_pdf);    
            /// Mailing code...[end]
            
            $info_update_membership['i_invoice_no']          =   $invoice_no ;
            $info_update_membership['s_invoice_pdf_name']    =   $ffname.'.pdf';
            $tablename  =   $this->db->TRADESMAN_MEMBERSHIP ;
            
            $this->mod_common->common_edit_info($tablename,$info_update_membership,array('i_id'=>$i_aff));
      
        
            $this->session->set_userdata(array('message'=>t('Your payment has been done sucessfully'),'message_type'=>'succ'));
            redirect(base_url().'home/message');
        }
        else
        {
            $this->session->set_userdata(array('message'=>t('Your payment has not been done sucessfully'),'message_type'=>'err'));
            redirect(base_url().'home/message');        
        }
    
    }
    
    
    function payment_failure_membership()
    {
            $this->session->set_userdata(array('message'=>t('Your payment has not been done sucessfully'),'message_type'=>'err'));
            redirect(base_url().'home/message');        

    }
	
    
    /**
    * This function shows the membership history plan
    * @author koushik
    * 
    */
    public function membership_history()
    {
        try
        {
            $this->left_menu=6;
            
            $this->data['pathtoclass']=$this->pathtoclass;
            $user_details = $this->session->userdata('loggedin');
            //print_r($user_details);
            $user_id    =    decrypt($user_details['user_id']);
            $this->data['breadcrumb'] = array(addslashes(t('Membership History'))=>'');
            
              
            ob_start();
            $this->ajax_pagination_membership_history();
            $contents = ob_get_contents();
            ob_end_clean();
         
            $this->data['membership_history']       = $contents;
            
            $this->render('tradesman/membership_history');
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
        
    }
    
    function ajax_pagination_membership_history($start=0) 
    { 
        try
        {
            $s_where='';
            $user_details     =    $this->session->userdata('loggedin');
            $user_id          =    decrypt($user_details['user_id']);
            
            $limit            =  $this->i_fe_page_limit ;
            $s_where    =   ' WHERE tm.i_tradesman_id='.$user_id;
               
            
            $this->data['membership_history']     = $this->mod_td->fetch_tradesman_membership_plan($s_where,intval($start),$limit);              
            //$total_rows             = $this->mod_td->get_total_album_images($s_where);
            //pr($this->data['testimonial'],1);
            $total_rows                 = $this->mod_td->gettotal_membership_plan($s_where);
            $this->data['download_path']    =   'ATTACHMENT_PDF_PATH';
            
            /* pagination start @ defined in common-helper */
            
            $ctrl_path     = base_url().'tradesman/ajax_pagination_membership_history/';
            $paging_div = 'membership_history';
            $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
            $this->data['total_rows']     = $total_rows;
            $this->data['start']          = $start;
           
            echo $this->load->view('fe/tradesman/ajax_pagination_membership_history.tpl.php',$this->data,TRUE);
            /* pagination end */
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }   
    }
    
    /* Download job file*/
    function download_it($s_file_name,$path)
    {
        try
        {
            $this->load->helper('download');
            $data =  $this->config->item($path) ;
            $name = decrypt($s_file_name);            
            $fullpath = file_get_contents($data.$name);
            //echo $fullpath;
            force_download($name, $fullpath);             
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    /**
    * This is the function show listing of tradesman pmb
    * 
    */
    public function private_message_board()
    {
        try
        {
            $this->left_menu=17;
            
            $this->data['pathtoclass']=$this->pathtoclass;
            $user_details = $this->session->userdata('loggedin');
            //print_r($user_details);
            $user_id    =    decrypt($user_details['user_id']);
            $this->data['breadcrumb'] = array(addslashes(t('Private Message Board'))=>'');
            $this->load->model('manage_private_message_model','mod_pmb'); 
            
            /**
            * Fetching job list for drop down
            */
            $s_where    =   " WHERE n.i_tradesman_id  =".$user_id ;
            $s_group    =   " GROUP BY n.i_job_id ";
            $info_jobs  =   $this->mod_pmb->fetch_jobs_pmb($s_where,$s_group) ;
            $arr_jobs   =   array();
            if(!empty($info_jobs))
            {
                
                foreach($info_jobs as $val)
                {
                    $arr_jobs[$val['i_job_id']]     =   $val['s_job_title'] ; 
                }
            }
            $this->data['arr_jobs']     =    $arr_jobs ;
            
            /**
            * Fetching buyer list for drop down
            */
            $s_where    =   " WHERE n.i_tradesman_id  =".$user_id ;
            $s_group    =   " GROUP BY n.i_buyer_id ";
            $info_users =   $this->mod_pmb->fetch_users_pmb($s_where,$s_group) ;
            
            $arr_users  =   array();
            if(!empty($info_users))
            {
                foreach($info_users as $val)
                {
                    $arr_users[$val['i_buyer_id']]     =   $val['s_buyer_name'] ;
                }
            }
            $this->data['arr_users']    =   $arr_users ;
            
            unset($arr_users,$arr_jobs,$s_where,$s_group,$info_jobs,$info_users);

			ob_start();
            $this->ajax_pagination_pmb();
            $contents = ob_get_contents();
            ob_end_clean();
         
            $this->data['pmb_list']       = $contents;
			
            
            $this->render('tradesman/private_message_board');
            
            
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
			if($_POST)
            {
                $sessArr = array();
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
			
			$arr_search[]	=	" n.i_is_deleted=1 And n.i_tradesman_id =".$this->user_id." ";
            
			if($sessArr['session_job_id'])
            {
                $arr_search[] =" n.i_job_id=".decrypt($sessArr['session_job_id']);
            }    
            if($sessArr['session_user_id'])
            {
                $arr_search[] =" n.i_buyer_id=".decrypt($sessArr['session_user_id']);
            }	
            		
			//echo trim($this->input->post('opd_job')).'====='.decrypt($sessArrTmp['src_job_id']);
			$s_where .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
		
		    $i_receiver_id  =   $this->user_id ;   
			$this->load->model('manage_private_message_model','mod_pmb');
			
			$limit	= $this->i_fe_page_limit;			
				
			$this->data['pmb_list']	=	$this->mod_pmb->fetch_pmb($s_where,intval($start), $limit,$i_receiver_id);	

			$total_rows				=	$this->mod_pmb->gettotal_info($s_where);
			$this->data['imagePath']	=	$this->config->item('user_profile_image_thumb_path');
			
			
			$ctrl_path     = base_url().'tradesman/ajax_pagination_pmb/';
			$paging_div = 'pmb_list';
			$this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
			$this->data['total_rows']     = $total_rows;
			$this->data['start']          = $start;
		   
			echo $this->load->view('fe/tradesman/ajax_pagination_pmb.tpl.php',$this->data,TRUE);
			/* pagination end */
			
			
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
		
	
	}
    
    public function pmb_landing($enc_job_id='')
    {
        try
        {
            $this->data['pathtoclass']=$this->pathtoclass;
            $user_details = $this->session->userdata('loggedin');
            //print_r($user_details);
            $user_id    =    decrypt($user_details['user_id']);
            $this->load->model('manage_private_message_model','mod_pmb');
            
            $s_where = " WHERE n.i_job_id=".decrypt($enc_job_id)." AND n.i_tradesman_id= ".$user_id ;
            $ret_ = $this->mod_pmb->fetch_pmb_exist($s_where);   
			
			if(empty($ret_))
			{
				$this->load->model('job_model','mod_job');
				$job_details	=	 $this->mod_job->fetch_this(decrypt($enc_job_id));
				$info	=	array();
				$info['i_job_id']	=	decrypt($enc_job_id) ;
				$info['i_tradesman_id']	=	$user_id ;
				$info['i_buyer_id']		=	$job_details['i_buyer_user_id'] ;
				$i_new_id = $this->mod_pmb->insert_info($info);
				$i_msg_brd_id = $i_new_id; 		
			}
			else
			{
				$i_msg_brd_id	=	$ret_[0]['id'];
			
			}
			
			redirect(base_url().'tradesman/private-message-details/'.encrypt($i_msg_brd_id).'/all');           
            
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
            $this->left_menu=17;
            
            $this->data['pathtoclass']=$this->pathtoclass;
            $user_details = $this->session->userdata('loggedin');
           
            $user_id    =    decrypt($user_details['user_id']);
            $this->data['breadcrumb'] = array(addslashes(t('Private Message Board'))=>'');

            $this->load->model('manage_private_message_model','mod_pmb');
            $i_msg_board_id     =   decrypt($enc_msg_board_id) ;

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

                        // Remove email address from content......
                         $posted["ta_comment"]   =   preg_replace('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/','',$posted["ta_comment"]); 
                         
                         // Remove email address from content......
                         $posted["ta_comment"]   =   preg_replace('/([a-z0-9_-]+\.)*[a-z0-9_-]+(\.[a-z]{2,6}){1,2}/','',$posted["ta_comment"]);  
                         
                        
                        $info=array();
                        $info['i_msg_board_id']    =    $i_msg_board_id;
                        $info['s_content']         =    $posted["ta_comment"];
                        $info['i_status']          =    1;
                        $info['i_sender_id']       =    $this->user_id;
                        $info['i_receiver_id']     =    $info_pmb[0]['i_buyer_id'];
                        $info['i_date']            =    time();
                       
                        
                        $this->load->model('manage_buyers_model');
                        
                        //$tradesman_details = $this->mod_td->fetch_tradesman_details($this->user_id);
                        $buyer_details =  $this->manage_buyers_model->fetch_this($info_pmb[0]['i_buyer_id']);
                        
                       // pr($buyer_details);
                        
                        $s_where = " WHERE n.id=".$i_msg_board_id." And n.i_buyer_id=".$info_pmb[0]['i_buyer_id']." ";
                        $job_details = $this->mod_pmb->fetch_pmb($s_where,'','',$this->user_id);
						
						/* insert data tradesman action history table */
						$arr2 = array();
						$arr2['i_user_id'] 		= $this->user_id;
						$arr2['i_job_id'] 		= $job_details[0]['job_id'];;
						$arr2['s_action']  		= 'post_message';
						$arr2['i_created_date']	= time();
						$table_history = $this->db->TRADESMANHISTORY;
						$this->job_model->set_data_insert($table_history,$arr2);
						unset($table_history,$arr2);						
						/* insert data tradesman action history table */

                        $i_newid = $this->mod_pmb->set_new_message_details($info);
                        
                        if($i_newid)////saved successfully
                        {
                            $this->load->model('manage_buyers_model');    
                            $s_where = " WHERE n.i_user_id=".$info_pmb[0]['i_buyer_id']." ";
                            $buyer_email_key = $this->manage_buyers_model->fetch_email_keys($s_where);
                            $is_mail_need = in_array('tradesman_post_msg',$buyer_email_key);
                            
                            if($is_mail_need)
                            {
                            $this->load->model('auto_mail_model');
                            $content = $this->auto_mail_model->fetch_mail_content('tradesman_post_msg','buyer',$buyer_details['s_lang_prefix']);
                            $s_subject = $content['s_subject'];
                            $filename = $this->config->item('EMAILBODYHTML')."common.html";
                            $handle = @fopen($filename, "r");
                            $mail_html = @fread($handle, filesize($filename));    
                            
                            if(!empty($content))
                            {            
                                
                                $description = $content["s_content"];
                                $description = str_replace("[service professional name]",$job_details[0]['s_tradesman_username'],$description);
                                $description = str_replace("[job title]",$job_details[0]['s_job_title'],$description);                                $description = str_replace("[Buyer name]",$job_details[0]['s_username'],$description);
                                $description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);                                $description = str_replace("[site_url]",base_url(),$description);                           
                            }
                            //unset($content);
                          
                            

                            $mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);    
                            $mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);                        
                            //echo "<br>".$mail_html;    exit;
                            /// Mailing code...[start]
                          
                            $this->load->helper('mail');                                        
                            $i_newid = sendMail($job_details[0]['s_buyer_email'],$s_subject,$mail_html);    
                            
                            unset($content);
                                 
                            }   

                            $this->session->set_userdata(array('message'=>$this->cls_msg["save_comment"],'message_type'=>'succ'));    
                            redirect(base_url().'tradesman/private-message-details/'.$enc_msg_board_id.'/all');
                        }
                        else///Not saved, show the form again
                        {
                            $this->session->set_userdata(array('message'=>$this->cls_msg["save_comment_err"],'message_type'=>'err'));
                            $this->render('tradesman/private-message-details/'.$enc_msg_board_id.'/all');
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
            
            $this->render('tradesman/private_message_details');
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    public function testing()
    {
        $posted["ta_comment"]   =   " i m koushik  rkoushik10@hotmail.com  email" ;
        
         $posted["ta_comment"]   =   preg_replace('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/','',$posted["ta_comment"]);  
         //$posted["ta_comment"]   =   preg_replace('/[a-zA-Z0-9._%+-]+@/','',$posted["ta_comment"]);  
         echo  $posted["ta_comment"] ;
    }
    
	/**
    * This function shows the quote placed by tradesman for  
	* different jobs
    * @author mrinmoy
    * 
    */
    public function quote_jobs()
    {
        try
        {
            $this->left_menu=9;
            
            $this->data['pathtoclass']=$this->pathtoclass;
            $user_details = $this->session->userdata('loggedin');
            //print_r($user_details);
            $user_id    =    decrypt($user_details['user_id']);
            $this->data['breadcrumb'] = array(addslashes(t('Job Quotes'))=>'');            
              
			if($_POST)
			{
				$sessArrTmp['i_category_id']  	= decrypt(trim($this->input->post('category')));	
				$sessArrTmp['opt_city'] 		= decrypt(trim($this->input->post('opt_city')));					
				$sessArrTmp['opt_state'] 		= decrypt(trim($this->input->post('opt_state')));
			}  
			$this->session->set_userdata(array('model_session'=>$sessArrTmp));	// to store data in session
			$this->data['posted'] = $sessArrTmp;
			  
            ob_start();
            $this->ajax_pagination_job_quotes();
            $contents = ob_get_contents();
            ob_end_clean();         
            $this->data['job_quotes']       = $contents;            
            $this->render('tradesman/job_quotes');
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
        
    }
	
	public function ajax_pagination_job_quotes($start=0) 
    {    
        $s_where='';
		//$arr_search[] = " n.i_tradesman_user_id = {$this->user_id} And (n.i_status!=3 OR n.i_status!=7 OR n.i_status!=10) ";
		$arr_search[] = " n.i_tradesman_user_id = {$this->user_id} And n.i_status!=3 ";
		$sessArrTmp['i_category_id']  	= $this->get_session_data('i_category_id');
		$sessArrTmp['opt_city'] 		= $this->get_session_data('opt_city');
		$sessArrTmp['opt_state']  		= $this->get_session_data('opt_state');
		
		if($sessArrTmp['i_category_id'])
		{
			$arr_search[] =" job.i_category_id=".$sessArrTmp['i_category_id'];
		}	
		if($sessArrTmp['opt_city'])
		{
			$arr_search[] =" job.i_city_id=".$sessArrTmp['opt_city'];
		}
		if($sessArrTmp['opt_state'])
		{
			$arr_search[] =" job.i_province_id=".$sessArrTmp['opt_state'];
		}
		
		
		$s_where .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
		
        $user_details   =  $this->session->userdata('loggedin');
        $user_id        =  decrypt($user_details['user_id']);
        
        $limit          =  $this->i_fe_page_limit ;
		
        //$s_where = " WHERE n.i_tradesman_user_id = {$this->user_id} And (n.i_status!=3 OR n.i_status!=7 OR n.i_status!=10) "; 
        //$this->data['job_quotes']	= $this->job_model->fetch_quote_multi($s_where,intval($start),$limit);	
		//$total_rows = $this->job_model->gettotal_quote_info($s_where);	
		
		$this->data['job_quotes']	= $this->job_model->fetch_job_quote_multi($s_where,intval($start),$limit);	
		$total_rows = $this->job_model->gettotal_job_quotes($s_where);
		//pr($this->data['job_quotes'],1);
		
        
        /* pagination start @ defined in common-helper */
        $ctrl_path     = base_url().'tradesman/ajax_pagination_job_quotes/';
        $paging_div = 'job_quotes';
        $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
        $this->data['total_rows']     = $total_rows;
        $this->data['start']          = $start;
       
        echo $this->load->view('fe/tradesman/ajax_pagination_job_quotes.tpl.php',$this->data,TRUE);
        /* pagination end */
    
    }
  
	/* tradesman accept job 
	* author @ mrinmoy
	*/
	public function confirm_accept_job()
	{
	 try
	  {
		if($_POST)
		{
			$posted=array();
			$posted["str_data"] 	= trim($this->input->post("data_str"));
			$str_data				= explode(',',$posted["str_data"]);  // index0=>job id,index1=>tradesman id
			
			$i_job_id 				= decrypt($str_data[0]);
		    $i_tradesman_id 		= decrypt($this->data['loggedin']['user_id']);
			
			//pr($this->data['loggedin'],1);
			if(!empty($this->data['loggedin']) && decrypt($this->data['loggedin']['user_type_id'])==2)
			{						
				$info=array();
				$info["i_status"]	=	4; // assigned
				$table = $this->db->JOBS;
				$cond  = array('id '=>$i_job_id);							
				$i_newid = $this->job_model->set_data_update($table,$info,$cond);
				
				
				//$i_newid = true;
				if($i_newid)////saved successfully
				{
					/* to update tradesman won job after successful accepting the job */
					$this->mod_td->update_tradesman_won_job($i_tradesman_id);
								
					/* insert data to job history and stattus change*/
					$arr1 = array();
					$arr1['i_job_id']  =  $i_job_id;
					$arr1['i_user_id'] =  $i_tradesman_id;
					$arr1['s_message'] =  'job_accepted';
					$arr1['i_created_date'] =  time();
					$table = $this->db->JOB_HISTORY;
					$this->job_model->set_data_insert($table,$arr1);	
					/*============*/
					$arr1 = array();
					$arr1['i_job_id']  =  $i_job_id;
					$arr1['i_user_id'] =  $i_tradesman_id;
					$arr1['s_status'] =  'In Progress';
					$arr1['i_created_date'] =  time();
					$table = $this->db->JOB_STATUS_HISTORY;
					$this->job_model->set_data_insert($table,$arr1);	
					/* end */	
					
					/* insert into job accept deny table */
					$arr1 = array();
					$arr1['i_job_id']  		=  $i_job_id;
					$arr1['i_tradesman_id'] =  $i_tradesman_id;
					$arr1['dt_created_on'] 	=  time();	
					$arr1['s_reason'] 		= 'none';
					$arr1['i_rating']   	= 3;
					$arr1['i_status']		= 1;
					$table = $this->db->JOBSACCEPTDENY;	
					$ins_id = $this->job_model->set_data_insert($table,$arr1);
					/* end insert into job accept deny table */
					
					
					/* insert data tradesman action history table */
					$arr2 = array();
					$arr2['i_user_id'] 		= $i_tradesman_id;
					$arr2['i_job_id'] 		= $i_job_id;
					$arr2['s_action']  		= 'accept_job';
					$arr2['i_created_date']	= time();
					$table_history = $this->db->TRADESMANHISTORY;
					$this->job_model->set_data_insert($table_history,$arr2);
					unset($table_history,$arr2);						
					/* insert data tradesman action history table */
					
					$job_details = $this->job_model->fetch_this($i_job_id);
					$tradesman_details = $this->mod_td->fetch_tradesman_details($i_tradesman_id);
					$this->load->model('manage_buyers_model','mod_buyer');
					$buyer_detail = $this->mod_buyer->fetch_this($job_details['i_buyer_user_id']);
					
					$this->load->model('manage_buyers_model');
					$this->manage_buyers_model->update_awarded_job($job_details['i_buyer_user_id']);
					// Send a notification to admin
					$admin_notification	= array();
					$admin_notification['i_user_id'] 			= $i_tradesman_id;
					$admin_notification['i_user_type'] 			= 1;
					$admin_notification['dt_created_on'] 		= time();
					$admin_notification['i_notification_type'] 	= 4;  
					$admin_notification['s_data1'] 				= $tradesman_details['s_username'];
					$admin_notification['s_data2'] 				= $job_details['s_title'] ;
					$admin_notification['s_data3'] 				= date($this->config->item('notification_date_format')) ;
					$admin_notification['i_is_read'] 			= 0;
					
					$a_tablename = $this->db->ADMIN_NOTIFICATIONS; 
					$this->load->model('common_model');
					$i_notify = $this->common_model->common_add_info($a_tablename, $admin_notification);
					unset($admin_notification,$a_tablename,$i_notify);
				  // End sending notification to admin
				  
				    $this->load->model('auto_mail_model');
				  	$content 	= $this->auto_mail_model->fetch_mail_content('tradesman_accepted_job_offer','buyer',$buyer_detail['s_lang_prefix']);	
					$s_subject 	= $content['s_subject'];						
					$filename 	= $this->config->item('EMAILBODYHTML')."common.html";
					$handle 	= @fopen($filename, "r");
					$mail_html 	= @fread($handle, filesize($filename));					
					//print_r($content); exit;
					if(!empty($content))
						{							
							$description = $content["s_content"];
							$description = str_replace("[BUYER_NAME]",$job_details['s_buyer_name'],$description);	
							$description = str_replace("[TRADESMAN_NAME]",$tradesman_details['s_username'],$description);	
							$description = str_replace("[JOB_TITLE]",$job_details['s_title'],$description);
							$description = str_replace("[BUDGET]",$job_details['s_budget_price'],$description);
							$description = str_replace("[LOGIN_URL]",base_url().'user/login/TVNOaFkzVT0',$description);						
						}
					unset($content);
				
					$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					//echo "<br>DESC".$buyer_detail['s_email'].'<br>'.$mail_html.'<br/>';	
					//exit;
							
					/// Mailing code...[start]
					$site_admin_email = $this->s_admin_email;	
					$this->load->helper('mail');										
					$i_mail_id = sendMail($buyer_detail['s_email'],$s_subject,$mail_html);	
					/// Mailing code...[end]
				  
					
					if($i_newid)
					{
					$msg = '1|'.$this->cls_msg["job_accept_save"];
					}
					
				}
				else	///Not saved, show the form again
				{
					$msg = '2|'.$this->cls_msg["job_accept_err"];
				}
			} // loggedin and tradesman checking end
			
			else   // login and not a tradesman error
			{
				$msg = '2|'.$this->cls_msg["auth_err"];
			}
		}
		echo $msg;
	 }
	catch(Exception $err_obj)
       {
            show_error($err_obj->getMessage());
       } 	
	}
	
	/* tradesman deny job 
	* author @ mrinmoy
	*/
	public function confirm_deny_job()
	{
	 try
	  {
		if($_POST)
		{
			$posted=array();
			$posted["str_data"] 	= trim($this->input->post("data_str"));
			$str_data				= explode(',',$posted["str_data"]);  // index0=>job id,index1=>tradesman id
			
            //$posted["i_rating"] 	= trim($this->input->post("i_rating"));
			//$posted["s_comment"] 	= trim($this->input->post("s_comment"));
			$i_job_id 				= decrypt($str_data[0]);
		   	$i_tradesman_id 		= decrypt($this->data['loggedin']['user_id']);
			
			$arr_cond 		= array('i_job_id '=>$i_job_id,'i_tradesman_user_id'=>$i_tradesman_id);
			$s_table 		= $this->db->JOBQUOTES;
			$quote_detail 	= $this->mod_common->common_fetch($s_table,$arr_cond);
			$i_quote_id		= $quote_detail[0]['id'];
			
			unset($arr_cond,$s_table);
			//pr($this->data['loggedin'],1);
			if(!empty($this->data['loggedin']) && decrypt($this->data['loggedin']['user_type_id'])==2)
			{						
				$info = array();
				$info['i_status'] = 3;
				$cond = array('id '=>$i_quote_id);
				$table = $this->db->JOBQUOTES;
				$i_newid = $this->job_model->set_data_update($table,$info,$cond);
				//$i_newid = true;
				$info = array();
				$info['i_status'] = 1;
				$info['i_assigned_date'] = '';
				$info['i_tradesman_id'] = '';
				$info['i_quote_id'] = 0;
				$table = $this->db->JOBS;
				$cond = array('id '=>$i_job_id);
				$i_newid = $this->job_model->set_data_update($table,$info,$cond);
				
				
				/* insert data to job history and stattus change*/
				$arr1 = array();
				$arr1['i_job_id']  =  $i_job_id;
				$arr1['i_user_id'] =  $i_tradesman_id;
				$arr1['s_message'] =  'job_not_accepted';
				$arr1['i_created_date'] =  time();
				$table = $this->db->JOB_HISTORY;
				$this->job_model->set_data_insert($table,$arr1);	
				/*============*/
				$arr1 = array();
				$arr1['i_job_id']  =  $i_job_id;
				$arr1['i_user_id'] =  $i_tradesman_id;
				$arr1['s_status'] =  'Job Denied';
				$arr1['i_created_date'] =  time();
				$table = $this->db->JOB_STATUS_HISTORY;
				$this->job_model->set_data_insert($table,$arr1);	
				/* end */
				
				/* insert into job accept deny table */
				$arr1 = array();
				$arr1['i_job_id']  		=  $i_job_id;
				$arr1['i_tradesman_id'] =  $i_tradesman_id;
				$arr1['dt_created_on'] 	=  time();	
				$arr1['s_reason'] 		= '';
				$arr1['i_rating']   	= 0;
				$arr1['i_status']		= 2;
				$table = $this->db->JOBSACCEPTDENY;	
				$ins_id = $this->job_model->set_data_insert($table,$arr1);
				/* end insert into job accept deny table */
				
				/* insert data tradesman action history table */
				$arr2 = array();
				$arr2['i_user_id'] 		= $i_tradesman_id;
				$arr2['i_job_id'] 		= $i_job_id;
				$arr2['s_action']  		= 'deny_job';
				$arr2['i_created_date']	= time();
				$table_history = $this->db->TRADESMANHISTORY;
				$this->job_model->set_data_insert($table_history,$arr2);
				unset($table_history,$arr2);						
				/* insert data tradesman action history table */
				
				$job_details = $this->job_model->fetch_this($i_job_id);
				$tradesman_details = $this->mod_td->fetch_tradesman_details($i_tradesman_id);
				$this->load->model('manage_buyers_model','mod_buyer');
				$buyer_detail = $this->mod_buyer->fetch_this($job_details['i_buyer_user_id']);
				// Send a notification to admin
				$admin_notification	= array();
				$admin_notification['i_user_id'] 			= $i_tradesman_id;
				$admin_notification['i_user_type'] 			= 1;
				$admin_notification['dt_created_on'] 		= time();
				$admin_notification['i_notification_type'] 	= 5;  
				$admin_notification['s_data1'] 				= $tradesman_details['s_username'];
				$admin_notification['s_data2'] 				= $job_details['s_title'] ;
				$admin_notification['s_data3'] 				= date($this->config->item('notification_date_format')) ;
				$admin_notification['i_is_read'] 			= 0;
				
				$a_tablename = $this->db->ADMIN_NOTIFICATIONS; 
				$this->load->model('common_model');
				$i_notify = $this->common_model->common_add_info($a_tablename, $admin_notification);
				unset($admin_notification,$a_tablename,$i_notify);
			  // End sending notification to admin
			  
			  	$content 	= $this->auto_mail_model->fetch_mail_content('tradesman_deny_job_offer','buyer',$buyer_detail['s_lang_prefix']);	
				$s_subject 	= $content['s_subject'];						
				$filename 	= $this->config->item('EMAILBODYHTML')."common.html";
				$handle 	= @fopen($filename, "r");
				$mail_html 	= @fread($handle, filesize($filename));					
				//print_r($content); exit;
				if(!empty($content))
					{							
						$description = $content["s_content"];
						$description = str_replace("[BUYER_NAME]",$job_details['s_buyer_name'],$description);	
						$description = str_replace("[TRADESMAN_NAME]",$tradesman_details['s_username'],$description);	
						$description = str_replace("[JOB_TITLE]",$job_details['s_title'],$description);
						$description = str_replace("[BUDGET]",$job_details['s_budget_price'],$description);
						$description = str_replace("[SITE_URL]",base_url(),$description);						
					}
				unset($content);
			
				$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
				$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
				//echo "<br>DESC".$mail_html.'<br/>';	
						
				/// Mailing code...[start]
				$site_admin_email = $this->s_admin_email;	
				$this->load->helper('mail');										
				$i_newid = sendMail($buyer_detail['s_email'],$s_subject,$mail_html);	
				/// Mailing code...[end]	
			  
				
				if($ins_id)////saved successfully
				{
					$msg = '1|'.$this->cls_msg["job_deny_save"];
				}
				else	///Not saved, show the form again
				{
					$msg = '2|'.$this->cls_msg["job_deny_err"];
				}
			} // loggedin and tradesman checking end
			
			else   // login and not a tradesman error
			{
				$msg = '2|'.$this->cls_msg["auth_err"];
			}
		}
		echo $msg;
	 }
	catch(Exception $err_obj)
       {
            show_error($err_obj->getMessage());
       } 	
	}
	
	
	
	
	
	/* edit quote amount and comment*/
	public function edit_my_quote()
	{
	 try
	  {
		if($_POST)
		{
			$flag = false;
			$msg = "";
			//$s_jobs_id 		= $this->input->post('s_job_id');
			$s_quote_id 	= $this->input->post('s_quote_id');
			$d_quote_amt 	= $this->input->post('d_quote_amt');
			$s_comment 		= trim($this->input->post('s_comment'));
			
			// Remove email address from content......
		 	$s_comment = preg_replace('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/','',$s_comment); 
			// Remove website address from content......
		 	$s_comment = preg_replace('/([a-z0-9_-]+\.)*[a-z0-9_-]+(\.[a-z]{2,6}){1,2}/','',$s_comment); 
			 
			//mod_common
			$arr_where			= array('id'=>decrypt($s_quote_id));
			$s_tablename 		= $this->db->JOBQUOTES;
			$quote_detail 		= $this->mod_common->common_fetch($s_tablename,$arr_where,0,1); 
			$job_detail			= $this->job_model->fetch_this($quote_detail[0]['i_job_id']);
			$tradesman_detail 	= $this->mod_td->fetch_this($quote_detail[0]['i_tradesman_user_id']);
			$this->load->model('manage_buyers_model','mod_buyer');
			$buyer_detail		= $this->mod_buyer->fetch_this($job_detail['i_buyer_user_id']);
			//pr($buyer_detail,1);
			unset($s_tablename,$arr_where);
			/*if($this->job_model->get_job_status(decrypt($s_jobs_id))==1)			
			{*/
			//echo '<br>=='.decrypt($s_quote_id); echo '<br>=='.$d_quote_amt; echo '<br>=='.$s_comment; exit;
				if(decrypt($s_quote_id)>0)
				{
					$arr1 = array();
					$arr1['d_quote'] 	= doubleval($d_quote_amt);
					$arr1['s_comment'] 	= get_formatted_string($s_comment);
					$table = $this->db->JOBQUOTES;
				
					if($this->job_model->set_data_update($table,$arr1,decrypt($s_quote_id)))					
					{
						$flag = true;
						
						/* mailing code */
						$this->load->model('auto_mail_model');
						$lang_prefix = $buyer_detail['s_lang_prefix'];
						 $content = $this->auto_mail_model->fetch_mail_content('tradesman_edit_quote','buyer',$lang_prefix);
						 $filename 	= $this->config->item('EMAILBODYHTML')."common.html";
						 $handle 	= @fopen($filename, "r");
						 $mail_html = @fread($handle, filesize($filename));	
						 $s_subject = $content['s_subject'];					
						//print_r($content); exit;
						if(!empty($content))
						{			
							$description = $content["s_content"];
							$description = str_replace("[BUYER_NAME]",$job_detail['s_buyer_name'],$description);
							$description = str_replace("[JOB_TITLE]",$job_detail['s_title'],$description);	
							$description = str_replace("[BUDGET]",$job_detail['s_budget_price'],$description);
							$description = str_replace("[QUOTE_AMOUNT]",$d_quote_amt,$description);
							$description = str_replace("[TRADESMAN_NAME]",$tradesman_detail['s_username'],$description);
							$description = str_replace("[LOGIN_URL]",base_url().'user/login/TVNOaFkzVT0',$description);														
						}
						//unset($content);
						
						$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
						$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
						//echo "<br>DESC".$mail_html;	exit;
						
						/// Mailing code...[start]
						$site_admin_email = $this->s_admin_email;	
						$this->load->helper('mail');										
						$i_newid = sendMail($job_detail['s_email'],$s_subject,$mail_html);	
						/// Mailing code...[end]
						
						/* mailing code */
						
						
						$msg = $this->cls_msg["quote_edit_save"];
					}
					else
					{
						$msg = $this->cls_msg["quote_edit_err"];
					}
				}
				else
				{
					$msg = $this->cls_msg["auth_err"];
				}
			/*}
			else
			{
				$msg = $this->cls_msg["job_inactive"];
			}*/
			echo json_encode(array('flag'=>$flag,'msg'=>$msg));
			exit;
		}
		else
		{
			redirect(base_url());
		}
	 }
	catch(Exception $err_obj)
       {
            show_error($err_obj->getMessage());
       } 	
	}
	
	
	/* tradesman declared the job as complete
	* and asked for feedback from buyer
	* author @ mrinmoy
	*/
	function confirm_job_complete()
	{
		
		if($_POST)
		{
			$info = array();
			$i_job_id 		= decrypt($this->input->post("i_job_id"));			
			$i_tradesman_id	= $this->user_id;
			$info = array();
			$info['i_status'] = 5; // feedback asked
			$table = $this->db->JOBS;
			$cond = array('id '=>$i_job_id);
					
			$i_newid = $this->job_model->set_data_update($table,$info,$cond);
			if($i_newid)
			{				
				/* insert data to job history and stattus change*/
				$arr1 = array();
				$arr1['i_job_id']  =  $i_job_id;
				$arr1['i_user_id'] =  $this->user_id;
				$arr1['s_message'] =  'job_complete_confirmed';
				$arr1['i_created_date'] =  time();
				$table = $this->db->JOB_HISTORY;
				$this->job_model->set_data_insert($table,$arr1);	
				/*============*/
				$arr1 = array();
				$arr1['i_job_id']  =  $i_job_id;
				$arr1['i_user_id'] =  $this->user_id;
				$arr1['s_status'] =  'Feedback Asked';
				$arr1['i_created_date'] =  time();
				$table = $this->db->JOB_STATUS_HISTORY;
				$this->job_model->set_data_insert($table,$arr1);	
				/* end */	
			   
			   $this->load->model('manage_buyers_model');
			   $job_details 	= $this->job_model->fetch_this($i_job_id);			   
			   $buyer_details 	= $this->manage_buyers_model->fetch_this($job_details['i_buyer_user_id']);
			   
			   // Send a notification to admin
				$admin_notification	= array();
				$admin_notification['i_user_id'] 			= $i_tradesman_id;
				$admin_notification['i_user_type'] 			= 1;
				$admin_notification['dt_created_on'] 		= time();
				$admin_notification['i_notification_type'] 	= 6;  
				$admin_notification['s_data1'] 				= $job_details['s_tradesman_name'];
				$admin_notification['s_data2'] 				= $job_details['s_title'] ;
				$admin_notification['s_data3'] 				= date($this->config->item('notification_date_format')) ;
				$admin_notification['i_is_read'] 			= 0;
				
				$a_tablename = $this->db->ADMIN_NOTIFICATIONS; 
				$this->load->model('common_model');
				$i_notify = $this->common_model->common_add_info($a_tablename, $admin_notification);
				unset($admin_notification,$a_tablename,$i_notify);
			  // End sending notification to admin
			   
			   
			   /* for job complete mail to the user */
			   $s_wh_id = " WHERE n.i_user_id=".$job_details['i_buyer_user_id']." ";
			   $buyer_email_key = $this->manage_buyers_model->fetch_email_keys($s_wh_id);
			   $is_mail_need = in_array('tradesman_feedback',$buyer_email_key);
	  			
			   if($is_mail_need)
			   {
			   $this->load->model('auto_mail_model');
			   $content 	= $this->auto_mail_model->fetch_mail_content('tradesman_completed_job','buyer',$buyer_details['s_lang_prefix']);			   
			   $filename 	= $this->config->item('EMAILBODYHTML')."common.html";
			   $handle 		= @fopen($filename, "r");
			   $mail_html 	= @fread($handle, filesize($filename));	
			   $s_subject 	= $content['s_subject'];			
				//print_r($content); exit;
				if(!empty($content))
				{	
					$description = $content["s_content"];
					$description = str_replace("[BUYER_NAME]",$buyer_details['s_username'],$description);
					$description = str_replace("[JOB_TITLE]",$job_details['s_title'],$description);	
					$description = str_replace("[TRADESMAN_NAME]",$job_details['s_tradesman_name'],$description);
					$description = str_replace("[LOGIN_URL]",base_url().'user/login/TVNOaFkzVT0',$description);	
				}
				unset($content,$arr1,$table);
				
				$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
				$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
				//echo "<br>DESC".$mail_html;	exit;
				
				/// Mailing code...[start]	
				$site_admin_email = $this->s_admin_email;	
				$this->load->helper('mail');										
				$i_newid = sendMail($buyer_details['s_email'],$s_subject,$mail_html);
				/// Mailing code...[end]					
				/* end job complete mail to the user */					
				
			  }
			
			
				$msg = '1|'.$this->cls_msg["job_complete"];
			}
			else
			{
				$msg = '2|'.$this->cls_msg["job_complete_err"];
			}
		}
		else
		{
			$msg = '';
		}	
		echo $msg;			
	}
   	/* end tradesman declared the job as complete */
    
    
    /* email settings for tradesman */
     public function email_settings()
    {
        try
        {
            $this->left_menu    =   18;
            
            $this->data['pathtoclass']=$this->pathtoclass;
            $user_details = $this->session->userdata('loggedin');
            $this->data['breadcrumb'] = array(addslashes(t('Email Settings'))=>'');    
            $this->data['user_id']    =    $user_details['user_id'];
            if($_POST)
            {
                $posted    =    array();
                $posted["chk_job_ivitations"]            =    trim($this->input->post("chk_job_ivitations"));
                $posted["chk_buyer_posted_msg"]          =    trim($this->input->post("chk_buyer_posted_msg"));
                $posted["chk_job_radar_search"]          =    trim($this->input->post("chk_job_radar_search"));
                $posted["chk_buyer_awarded_job"]         =    trim($this->input->post("chk_buyer_awarded_job"));
                $posted["chk_buyer_provide_feedback"]    =    trim($this->input->post("chk_buyer_provide_feedback"));
                $posted["chk_buyer_terminate_job"]       =    trim($this->input->post("chk_buyer_terminate_job"));
                $posted["chk_buyer_cancel_job"]          =    trim($this->input->post("chk_buyer_cancel_job"));
                
                        
                $info=array();
                $info["chk_job_ivitations"]               =    $posted["chk_job_ivitations"];
                $info["chk_buyer_posted_msg"]             =    $posted["chk_buyer_posted_msg"];
                $info["chk_job_radar_search"]             =    $posted["chk_job_radar_search"];
                $info["chk_buyer_awarded_job"]            =    $posted["chk_buyer_awarded_job"];
                $info["chk_buyer_provide_feedback"]       =    $posted["chk_buyer_provide_feedback"];
                $info["chk_buyer_terminate_job"]          =    $posted["chk_buyer_terminate_job"];
                $info["chk_buyer_cancel_job"]             =    $posted["chk_buyer_cancel_job"];
                
                //print_r($info); exit;
                
                $i_newid = $this->mod_td->set_email_settings($info,$this->user_id);
                if($i_newid)////saved successfully
                {
                    $this->session->set_userdata(array('message'=>$this->cls_msg["save_email_setting"],'message_type'=>'succ'));
                    redirect(base_url().'tradesman/email-settings');
                }
                else///Not saved, show the form again
                {
                    set_error_msg($this->cls_msg["save_err"]);
                    redirect(base_url().'tradesman/email-settings');
                }    
            }    

            $s_user_id    =    " WHERE n.i_user_id=".$this->user_id." ";            
            $this->data['email_key']    =    $this->mod_td->fetch_email_keys($s_user_id,'','');
           
            $this->render('tradesman/email_setting');
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	
	
	/* tradesman radar settings
	*  author @ mrinmoy 28-05-2012
	*/
	
	public function radar_setting()
	{
		try
		{
			$this->left_menu =	19;
			$this->data['breadcrumb'] = array(addslashes(t('Radar Settings'))=>'');	
			$user_id	= 	$this->user_id;
			
			if($_POST)
			{
				$posted=array();
				$posted['opt_city'] 		= $this->input->post("opt_city");
				$posted['opt_state'] 		= $this->input->post("opt_state");
				$posted['opt_category_id'] 	= $this->input->post("opt_category_id");				
				$posted['h_id'] 			= $this->input->post("h_id");
				
				$this->form_validation->set_rules('opt_city', addslashes(t('city')), 'required');
                $this->form_validation->set_rules('opt_state', addslashes(t('province')), 'required');
             
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
					$info['i_city'] 		= $posted['opt_city'];
					$info['i_province'] 	= $posted['opt_state'];
					$info['i_category_id'] 	= $posted['opt_category_id'];
					$info['id'] 			= decrypt($posted['h_id']);
					$info['i_user_id'] 		= $user_id;
					//pr($info,1);
					if($info['id'] == '')
					{
                    	$i_aff=$this->mod_radar->add_info($info);
						$i_radar_id = $i_aff;
					}
					else
					{
						$i_aff=$this->mod_radar->edit_info($info,decrypt($posted["h_id"]));
						$i_radar_id = $info['id'];
					}
					//echo $i_radar_id; exit;
					if($i_radar_id)
					{
						$this->mod_radar->del_radar_cat($i_radar_id);
						$arr1 = array();
						if($info['i_category_id'])
						{
							foreach($info['i_category_id'] as $val)
							{
								$arr1['i_radar_id']  =  $i_radar_id;
								$arr1['i_category_id'] =  decrypt($val);
								$table = $this->db->RADAR_CAT;
								$this->mod_radar->set_data_insert($table,$arr1);
							}
						}	
					}
                    if($i_radar_id)////saved successfully
                    {
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_radar_succ"],'message_type'=>'succ'));
                        redirect(base_url().'tradesman/radar-setting');                      
                    }
                    else///Not saved, show the form again
                    {
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_radar_err"],'message_type'=>'err'));
                        $this->data["posted"]=$posted;
                        redirect(base_url().'tradesman/radar-setting');
                    }
                    unset($info,$posted, $i_aff);					
				}				
			}
			
			else
			{
			$info = $this->mod_radar->fetch_this($user_id);
			
			if($info['id'])
			{
				$info['opt_city'] 	= encrypt($info['i_city']);
				$info['opt_state'] 	= encrypt($info['i_province']);		
				$info['h_id'] 		= encrypt($info['id']);
				$this->data['radar_cat'] = $this->mod_radar->get_radar_cat($info['id']);
				//pr($this->data['radar_cat'],1);
				if($this->data['radar_cat'])
				{
					$tmp_arr = array();
					foreach($this->data['radar_cat'] as $val)
					{
						$tmp_arr[] = encrypt($val['i_category_id']);
					}
				}
				$info['opt_category_id'] = $tmp_arr;				
				$cnt = count($this->data['radar_cat'])!=0?count($this->data['radar_cat']):1;
			}
			else
			{
				$this->load->model('tradesman_model');
				$tradesman_details = $this->tradesman_model->fetch_this($user_id);
				$info['opt_city'] 	= encrypt($tradesman_details['opt_city']);
				$info['opt_state'] 	= encrypt($tradesman_details['opt_province']);			
			}
			//pr($this->data['radar_cat']);
			}
			
			$this->data['posted'] = $info;
			//pr($this->data['posted'],1);	
			$this->render();
		}
		catch(Exception $e)
		{
			show_error($e->getMessage());
		}
	}
	/* end radar setting */
	
	/* radar jobs of tradesman */
	public function radar_jobs()
	{
		try
		{
			$this->data['breadcrumb'] = array(addslashes(t('Radar Jobs'))=>'');	
			$s_cat_name = addslashes(t('None'));
			if($_POST)
			{
				$sessArrTmp['i_category_id']  	= decrypt(trim($this->input->post('category')));	
				$sessArrTmp['opt_city'] 		= decrypt(trim($this->input->post('opt_city')));					
				$sessArrTmp['opt_state'] 		= decrypt(trim($this->input->post('opt_state')));	
			}
			else
			{
				$this->load->model("radar_model");				
				$info = $this->radar_model->fetch_this($this->user_id);
				
				//pr($info);
				//$sessArrTmp['i_category_id']  = $info['i_category_id'];	
				$sessArrTmp['opt_city'] 	= $info['i_city'];					
				$sessArrTmp['opt_state'] 	= $info['i_province'];
				if($info)
				{
				
					$sessArrTmp['radar_category_id'] = $this->radar_model->get_radar_cat($info['id']);
					
					$cat_arr = array();
					foreach($sessArrTmp['radar_category_id'] as $val)
						$cat_arr[]=$val['i_category_id'];
					
					$s_cat_where = " WHERE c.i_id IN(".implode(",",$cat_arr).") ";
					$arr_cat = $this->radar_model->get_radar_cat_name($s_cat_where);
					//pr($arr_cat);exit;
					$s_cat_name = implode(", ",$arr_cat);
					
				}
			}
			
			$this->session->set_userdata(array('model_session'=>$sessArrTmp));	// to store data in session
			$this->data['posted'] = $sessArrTmp;
			//pr($this->data['posted'],1);
			$this->data['s_cat_name'] = $s_cat_name;
			
			$this->left_menu	=	11;
			ob_start();
			$this->ajax_pagination_radar_jobs();
			$contents = ob_get_contents();
			ob_end_clean();
			$job_contents = explode('^',$contents);
			
			$this->data['job_contents'] = $job_contents[0];
			$this->data['tot_job'] 		= $job_contents[1];
			$this->render();
		}
		catch(Exception $e)
		{
			show_error($e->getMessage());
		}
	}
	
	/* ajax pagination for radar jobs  */
   public function ajax_pagination_radar_jobs($start=0) 
   {
		$s_where='';
		$model_session = $this->session->userdata('model_session');
		//pr($model_session);
		$sessArrTmp['src_job_category_id'] 	 	= $model_session['i_category_id'];
		$sessArrTmp['src_radar_category_id'] 	= $model_session['radar_category_id'];
		$sessArrTmp['src_job_state'] 			= $model_session['opt_state'];
		$sessArrTmp['src_job_city']  			= $model_session['opt_city'];
		
		$arr_search[] = " n.i_status=1 AND n.i_is_deleted!=1 "; 
		
		if($sessArrTmp['src_job_category_id'])
		{
			$arr_search[] =" n.i_category_id=".$sessArrTmp['src_job_category_id'];
		}
		if($sessArrTmp['src_radar_category_id'])
		{
			$cat_arr = array();
			foreach($sessArrTmp['src_radar_category_id'] as $val)
				$cat_arr[]=$val['i_category_id'];
			$arr_search[] =" n.i_category_id IN(".implode(",",$cat_arr).")";
		}
		if($sessArrTmp['src_job_state'])
		{
			$arr_search[] =" n.i_province_id=".$sessArrTmp['src_job_state'];
		}
		if($sessArrTmp['src_job_city'])
		{
			$arr_search[] =" n.i_city_id=".$sessArrTmp['src_job_city'];
		}
		
		$s_where .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
		
		//echo $s_where;
		$limit		=  $this->i_fe_page_limit;			
		$job_list	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);
		$total_rows = $this->job_model->gettotal_info($s_where);		
		$this->data['job_list'] = $job_list;
		
		/* pagination start @ defined in common-helper */
        $ctrl_path     				  = base_url().'tradesman/ajax_pagination_radar_jobs/';
        $paging_div 				  = 'job_list';
        $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
        $this->data['total_rows']     = $total_rows;
        $this->data['start']          = $start;
		
		
		$job_vw = $this->load->view('fe/tradesman/ajax_pagination_radar_jobs.tpl.php',$this->data,TRUE);
		
		echo $job_vw;		
	}	
    
    public function recommend_us()
    {
        try
        {
            $this->left_menu    =   20;
            
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
                               $s_subject   =   $content['s_subject'];
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
                           // echo "<br>".$mail_html;    exit;
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
            
            $this->render('tradesman/recommend_us');
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
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
           
            echo $this->load->view('fe/tradesman/ajax_pagination_recommend_us.tpl.php',$this->data,TRUE);
            /* pagination end */
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    public function ajax_delete_album_image()
    {
        try
        {
            if($_POST)
            {
                $img_id     =   $this->input->post('img_id');
                $i_aff      =   $this->mod_td->delete_album_image(decrypt($img_id)) ;
                
                if($i_aff)
                {
                    ob_start();
                    $this->ajax_pagination_album(0,1);
                    $contents = ob_get_contents();
                    ob_end_clean();
                    
                    echo $contents ;
                   
                }
                
            }
            
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
            $s_where   = ' WHERE n.i_job_id="'.decrypt($enc_job_id).'" AND n.i_receiver_user_id='.$this->user_id.' AND n.i_status=1 ';
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
                        <p>'.$val['s_comments'].' <span>- '.$val['s_sender_user'].'<br/>'.$val['dt_created_on'].'</span></p>
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
	
	
	/** 
    * This is a ajax function to fetch quote details of tradesman
    * and display in a light box
    * added by mrinmoy
    *  
    */
    public function ajax_fetch_quote()
    {
        try
        {
           if($_POST)
           {
               $enc_quote_id  =   trim($this->input->post('quote_id'));
			        
               $quote_details = $this->job_model->fetch_this_quote(decrypt($enc_quote_id)); 
               //pr($quote_details,1);
               if(!empty($quote_details)) 
               {
			   	$str = '';
				
				$str.='<div class="lable04">'.addslashes(t('Your bid')).' :</div>
					  <div class="textfell">
					  <input name="txt_quote" id="txt_quote" class="numeric_valid" type="text"  value="'.intval($quote_details['d_quote']).'"/>
					  </div>  <div class="lable03">TL</div>
					  <div class="spacer"></div>
					  <div id="err_txt_quote" class="err" style="margin-left:130px;">'.form_error('txt_quote').'</div>	  
       				  <div class="spacer"></div>
					   <div class="lable04">'.addslashes(t('Message')).' :</div>
					  <div class="textfell06">
						  <textarea name="ta_message" id="ta_message" cols="" rows="">'.$quote_details['s_comment'].'</textarea>
					  </div>
					  <div class="spacer"></div>
	   				  <div id="err_ta_message" class="err" style="margin-left:130px;">'.form_error('ta_message').'</div>
					  <div class="spacer"></div>
					  <div class="lable04"></div>
					  <input class="small_button" id="btn_save_quote" onClick="edit_my_quote();" type="button" value="'.addslashes(t('Submit')).'" />';
			   }
               else
               {
                   $str =   ' <p> '.addslashes(t('No item found')).'</p>' ;
               }
               unset($quote_details,$s_where,$enc_buyer_id);
               echo $str ;

           }
		   
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
    
    public function contact_list()
    {
        try
        {
            $this->left_menu    =   7;
            
            $this->data['pathtoclass']=$this->pathtoclass;
            $user_details = $this->session->userdata('loggedin');
            $this->data['breadcrumb'] = array(addslashes(t('Email Settings'))=>'');    
            $this->data['user_id']    =    $user_details['user_id'];
            
            ob_start();
            $this->ajax_pagination_contact_list();
            $contents = ob_get_contents();
            ob_end_clean();
         
            $this->data['contact_list']       = $contents;
            
            $this->render('tradesman/contact_list');
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    public function ajax_pagination_contact_list($start=0)
    {
        try
        {
            $s_where='';
            $user_details     =    $this->session->userdata('loggedin');
            $user_id          =    decrypt($user_details['user_id']);
            
            $limit            =  $this->i_fe_page_limit ;
            $s_where    =   ' WHERE i_tradesman_id='.$user_id;
               
            
            $this->data['info_contact']     = $this->mod_td->fetch_contact_list($s_where,intval($start),$limit);              
            
            //$total_rows             = $this->mod_td->get_total_album_images($s_where);
            //pr($this->data['testimonial'],1);
            $tablename  =   $this->db->TRADESMAN_CONTACTLIST ;
            $total_rows                 = $this->mod_common->common_count_rows($tablename,$s_where);
            
            /* pagination start @ defined in common-helper */
            
            $ctrl_path     = base_url().'tradesman/ajax_pagination_contact_list/';
            $paging_div = 'contact_list';
            $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
            $this->data['total_rows']     = $total_rows;
            $this->data['start']          = $start;
            
            unset($tablename,$s_where,$total_rows);
            
            echo $this->load->view('fe/tradesman/ajax_pagination_contact_list.tpl.php',$this->data,TRUE);
            /* pagination end */
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
 
    
    public function ajax_get_bank_transfer()
    {
        try
        {
            $i_membership_plan  =   $this->input->post('i_membership_plan');
            
            $this->load->model('membership_model','mod_mem'); 
            $s_where    =   " WHERE i_type = ";
            $s_where    .=   ($i_membership_plan==1)?3:4;
       
            $info_plan  =   $this->mod_mem->fetch_multi($s_where) ;
            
            if($info_plan)
            {
                $price  =   $info_plan[0]['d_price'];
                $s_plan =   $info_plan[0]['s_type'];
            }
            
            $s_where    =   ' WHERE dt_created_on >='.strtotime('today');   
            $cnt        =   $this->mod_td->gettotal_bank_transfer($s_where);
            $code   =   'A'.date('ymd');
            $this->data['unique_code']  =   substr_replace($code,' ',4,0).' '.str_pad($cnt+1,3,'0',STR_PAD_LEFT) ;
            $this->data['price']        =   $price ;
            $this->data['s_plan']       =   $s_plan ;
            

            $info   =   array();
            $info['i_tradesman_id']     =   $this->user_id ;
            $info['i_membership_plan']  =   ($i_plan==1)?3:4;// if membership plan is 1 month id is 3 for 3 month id is 4
            $info['s_bank_info']        =   $this->data['unique_code']  ;
            $info['i_status']           =   0 ;
            $info['dt_created_on']      =   time() ;
                
            $tablename  =   $this->db->MEMBERSHIP_BANK_TRANSFER;
            $i_aff      =   $this->mod_common->common_add_info($tablename,$info);
            if($i_aff)
            {
                $this->session->set_userdata(array('message'=>$this->cls_msg["save_bank_transfer"],'message_type'=>'succ'));
                echo $this->load->view('fe/tradesman/lightbox_bank_transfer.tpl.php',$this->data);
            }
            else
            {
                echo 'error';
            }
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    
    
    
    
    /* progress jobs
    * author @ mrinmoy
    */
    public function all_jobs()
    {
           try
        {
            
            $this->left_menu    =    22;
            $this->data['breadcrumb'] = array(t('All Jobs')=>'');    
            $this->data['pathtoclass']=$this->pathtoclass;            
            $this->data['i_tradesman_id'] = $this->user_id;
			
            ob_start();
            $this->all_jobs_pagination_ajax();
            $job_contents = ob_get_contents();
            ob_end_clean();
            //var_dump($job_contents);exit;
            $this->data['job_contents'] = $job_contents;
            $this->render();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }    
   }
   
   /* Ajax pagination for progress jobs  */
    function all_jobs_pagination_ajax($start=0) {
        try
        {
			$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_is_deleted!=1 ";
			$limit    = $this->i_fe_page_limit;        
				
			$this->data['job_list']    = $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);    
			$total_rows = $this->job_model->gettotal_info($s_where);    
			//pr($this->data['job_list'],1);
			/* pagination start @ defined in common-helper */
			$ctrl_path                       = base_url().'tradesman/all_jobs_pagination_ajax/';
			$paging_div                   = 'job_list';
			$this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
			$this->data['total_rows']     = $total_rows;
			$this->data['start']          = $start;
		   
			echo $this->load->view('fe/tradesman/all_jobs_pagination_ajax.tpl.php',$this->data,TRUE);
            
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

