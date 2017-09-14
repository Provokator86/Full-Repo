<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 30 April 2012
* Modified By: 
* Modified Date: 
* 
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class User extends My_Controller
{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
	public $uploaddir;
    public $thumbdir;
    public $showimgdir;
	public $thumbDisplayPath;

    public function __construct()
    {
        try
        { 
          parent::__construct(); 
          $this->data['title']="User";////Browser Title
		  $this->data['ctrlr'] = "user";
		  
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  $this->data['i_lang_id'] = $this->i_default_language;
		  $this->cls_msg=array();
		  $this->cls_msg["invalid_login"]	= addslashes(t("Invalid user name or password. Please try again."));
		  $this->cls_msg["success_login"]	= addslashes(t("Successfully logged in."));
		  
		  $this->cls_msg["invalid_info"]	= addslashes(t("Invalid user name or email. Please try again."));
		  $this->cls_msg["save_succ"]		= addslashes(t("A new password has been generated and sent to your email successfully."));
		  $this->cls_msg["send_err"]		= addslashes(t("Mail not delivered."));		  
		  $this->cls_msg["email_exist"]		= addslashes(t("Email already exist."));
		  $this->cls_msg["username_exist"]	= addslashes(t("Username already exist."));
		  
		  $this->cls_msg["proper_username"] = addslashes(t('give a proper username with minnimum 6 character'));
		  
		  $this->cls_msg["invalid_account"]	= addslashes(t("Account not validated."));
		  $this->cls_msg["valid_account"]	= addslashes(t("Account validated you can login now ."));		  
		  $this->cls_msg["captcha_err"]		= addslashes(t("Please provide proper captcha."));
		  $this->cls_msg["save_reg"]		= addslashes(t("You have been registered successfully."));
		  
		  $this->cls_msg["save_album"] 		= addslashes(t(" album details saved succesfully"));
		  $this->cls_msg["save_album_err"] 	= addslashes(t(" album details could not saved "));
		  $this->cls_msg["img_del"]			= addslashes(t("image deleted succesfully"));
		  $this->cls_msg["img_del_err"]		= addslashes(t("image could not deleted")); 
		  
		  $this->cls_msg["save_subscribe"] 	= addslashes(t("Newsletter unsubscribe succesfully"));
		  
		  $this->load->model('manage_buyers_model','mod_rect');		  
		  $this->load->model('tradesman_model','mod_td');
		  
		  /* profile Image */
		  $this->allowedExt 		= 	'jpg|jpeg|png';	
		  $this->uploaddir 			= 	$this->config->item('user_profile_image_upload_path');	
		  $this->thumbdir 			= 	$this->config->item('user_profile_image_thumb_upload_path');
		  $this->thumbDisplayPath 	= 	$this->config->item('user_profile_image_thumb_path');
		  $this->nw_width 			= 	$this->config->item('user_profile_photo_upload_thumb_width');
		  $this->nw_height 			= 	$this->config->item('user_profile_photo_upload_thumb_height');
		  $this->trade_width 		= 	$this->config->item('trades_photo_upload_thumb_width');
		  $this->trade_height 		= 	$this->config->item('tradesman_photo_upload_thumb_height');
		  
		   /****** ALBUM IMAGE UPLOAD SETTINGS  ******/
		  /*$this->uploadDir 			= $this->config->item('trades_album_image_upload_path');	
		  $this->thumbDir 			= $this->config->item('trades_album_image_thumb_upload_path');
		  $this->t_ht 				= $this->config->item('trades_album_image_upload_thumb_height');	
		  $this->t_wd 				= $this->config->item('trades_album_image_upload_thumb_width');*/
		  $this->addressExt 		= 	'jpg|jpeg|png|pdf';	
		  $this->addressdir 		= 	$this->config->item('tradesman_address_proof_upload_path');
		  
		  
		  
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
			$this->i_menu_id = 1;
			$this->data['breadcrumb'] = array('Register/Login'=>'');
			//$this->render('registration/buyer_registration');
			
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	 public function registration($param='')
    {
        try
        {
            
			
			if(!empty($this->data['loggedin']))
			{
				redirect(base_url()."user/dashboard");
				exit;
			}
			
			//var_dump($this->session->userdata('s_referred_code'));				
			//echo $this->i_main_default_language.'<br/>'.$this->i_default_language;				
			
			$this->data['breadcrumb'] = array(addslashes(t('Registration'))=>'');
			
			$this->load->model('city_model');
			$this->load->model('province_model');
			$this->load->model('zipcode_model');
			$type	=	decrypt($param);
			$type	=	($type) ? $type : 1;				
			
			if($_POST)
			{	
			
				//exit;
				$this->load->model('auto_mail_model','mod_auto');
				//pr($posted);
				$posted=array();
                $posted["txt_name"]			= 	trim($this->input->post("txt_name"));
				$posted["txt_email"]		= 	trim($this->input->post("txt_email"));
				$posted["txt_con_email"]	= 	trim($this->input->post("txt_con_email"));
				$posted["txt_username"]		= 	trim($this->input->post("txt_username"));
				$posted["txt_password"]		= 	trim($this->input->post("txt_password"));
				$posted["txt_con_password"]	= 	trim($this->input->post("txt_con_password"));
				//$posted["txt_contact"]		= 	trim($this->input->post("txt_contact"));
				$posted['txt_gsm1']				=	trim($this->input->post("txt_gsm1"));
				$posted['opt_gsm1']				=	trim($this->input->post("opt_gsm1"));
				
				//$posted["txt_yahoo"]		= 	trim($this->input->post("txt_yahoo"));
				$posted["i_sm"]				= 	trim($this->input->post("social_media"));
				$posted["txt_sm"]			= 	trim($this->input->post("txt_sm"));
				
				$posted["opt_state"]		= 	trim($this->input->post("opt_state"));
				$posted["opt_city"]			= 	trim($this->input->post("opt_city"));
                $posted["opt_zip"]          =   trim($this->input->post("opt_zip"));
				$posted["txt_zip"]			= 	trim($this->input->post("txt_zip"));
				
				$posted["txt_address"]		= 	trim($this->input->post("txt_address"));
				$posted["f_image"]			= 	trim($this->input->post("f_image"));
				
				$posted["txt_captcha"]		=	trim($this->input->post("txt_captcha"));
				//$posted["captcha_response"]=	trim($this->input->post("recaptcha_response_field"));
				
				$i_inform_news 				= 	trim($this->input->post("i_inform_news"));
				$posted["i_inform_news"]	= 	($i_inform_news==1)?$i_inform_news:2;
				
				$i_accept_terms 			= 	trim($this->input->post("i_accept_terms"));
				$posted["i_accept_terms"]	= 	($i_accept_terms==1)?$i_accept_terms:2;
				
				if($type==2)
				{
				$posted['i_trades_type']		=	trim($this->input->post("i_trades_type"));
				$posted['txt_trade_name']		=	trim($this->input->post("txt_trade_name"));
				$posted['txt_gsm']				=	trim($this->input->post("txt_gsm"));
				$posted['opt_gsm']				=	trim($this->input->post("opt_gsm"));
				$posted['txt_firm_name']		=	trim($this->input->post("txt_firm_name"));
                $posted['opt_firm_phone']       =    trim($this->input->post("opt_firm_phone"));
				$posted['txt_firm_phone']		=	trim($this->input->post("txt_firm_phone"));
				$posted['opt_gsm']				=	trim($this->input->post("opt_gsm"));
				$posted['ta_firm_add1']			=	trim($this->input->post("ta_firm_add1"));
				$posted['ta_firm_add2']			=	trim($this->input->post("ta_firm_add2"));
				$posted['txt_tax_office']		=	trim($this->input->post("txt_tax_office"));
				$posted['txt_tax_number']		=	trim($this->input->post("txt_tax_number"));
				$posted['txt_ssn']				=	trim($this->input->post("txt_ssn"));
				$posted['f_address']			=	trim($this->input->post("f_address"));
                
                
				if(isset($_FILES['f_address']) && !empty($_FILES['f_address']['name']))
					{
					$s_uploaded_filename = get_file_uploaded( $this->addressdir,'f_address','','',$this->addressExt);					
					$address_upload_res = explode('|',$s_uploaded_filename);
					}
				
				}
				
				//print_r($result_cat); exit;
				//print_r($posted); exit;
				
				
				
				if(isset($_FILES['f_image']) && !empty($_FILES['f_image']['name']))
				{					
					$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'f_image','','',$this->allowedExt);					
					$arr_upload_res = explode('|',$s_uploaded_filename);
				}   
				
                
				$this->form_validation->set_rules('txt_email', addslashes(t('email')), 'valid_email|required');
				$this->form_validation->set_rules('txt_con_email', addslashes(t('confirm email')), 'valid_email|required|matches[txt_email]');
				$this->form_validation->set_rules('txt_username', addslashes(t('username')), 'required');
				$this->form_validation->set_rules('txt_password', addslashes(t('password')), 'required');
				$this->form_validation->set_rules('txt_con_password', addslashes(t('confirm password')), 'required|matches[txt_password]');				
				$this->form_validation->set_rules('opt_state', addslashes(t('province')), 'required');
				$this->form_validation->set_rules('opt_city', addslashes(t('city')), 'required');
				//$this->form_validation->set_rules('opt_zip', addslashes(t('zip code')), 'required');				
				//$this->form_validation->set_rules('txt_captcha', addslashes(t('correct security code')), 'required');
				
				if($type==1)
				{
					$this->form_validation->set_rules('txt_name', addslashes(t('name')), 'required');
					//$this->form_validation->set_rules('txt_contact', addslashes(t('contact number')), 'required');
					$this->form_validation->set_rules('txt_address', addslashes(t('address')), 'required');
					$this->form_validation->set_rules('i_accept_terms', addslashes(t('accept terms & conditions')), 'required');
				}
				if($type==2)
				{
					$this->form_validation->set_rules('txt_trade_name', addslashes(t('tradesman name')), 'required');										
				}
			
             
                if($this->form_validation->run() == FALSE || ($arr_upload_res[0]==='err') || !empty($is_email_exist) || !empty($is_username_exist)  || ($posted['txt_captcha'] != $_SESSION['captcha']))/////invalid
                {
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
                    
                    $posted['arr_province'] =   $arr_province ;
					
                  /* end get province list with selected city */
				   
				   /* get zipcode list with selected city and province*/
				   $tablename		=	$this->db->ZIPCODE;
				   $arr_where		=	array('city_id'=>decrypt($posted["opt_city"]),'province_id'=>decrypt($posted["opt_state"])) ;
				   $info_zipcode  =   $this->mod_common->common_fetch($tablename,$arr_where);
                    
                    if(!empty($info_zipcode))
                    {
                        $arr_zipcode   =   array();
                        foreach($info_zipcode as $val)
                        {
                            $arr_zipcode[$val['id']]   =   $val['postal_code'] ; 
                        }
                    }
                    
                    $posted['arr_zipcode'] =   $arr_zipcode ;
					
					/* get zipcode list with selected city and province*/
				
					$this->session->set_userdata('arr_reg_value',$posted);
					if($arr_upload_res[0]==='err')
					{
						set_error_msg($arr_upload_res[2]);
					}
					else
					{
						get_file_deleted($this->uploaddir,$arr_upload_res[2]);
					}				

					if($posted['txt_captcha'] != $_SESSION['captcha'])
					  {
						$this->session->set_userdata(array('message'=>$this->cls_msg["captcha_err"],'message_type'=>'err'));
						//set_error_msg($this->cls_msg["captcha_err"]);
						$this->session->set_userdata('arr_reg_value',$posted);	
						if($type==1)
						{							
							redirect(base_url().'user/registration/TVNOaFkzVT0');
						}
						if($type==2)
						{
							redirect(base_url().'user/registration/TWlOaFkzVT0');
						}					
					  }
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
					
                }
                else///validated, now save into DB
                {
				
				
                    $info=array();
                    $info["s_name"]			=	$posted["txt_name"];
					$info["s_email"]		=	$posted["txt_email"];
					$info["s_username"]		=	$posted["txt_username"];
					$info["s_password"]		=	$posted["txt_password"];
					//$info["s_contact_no"]	=	$posted["txt_contact"];
					$info["s_contact_no"]	=	!empty($posted["txt_gsm1"])?decrypt($posted['opt_gsm1']).'-'.$posted["txt_gsm1"]:"";
					$info["i_province"]		=	$posted["opt_state"];
					$info["i_city"]			=	$posted["opt_city"];
					$info["i_zipcode"]		=	$posted["opt_zip"];
					$info["s_address"]		=	$posted["txt_address"];	
					$info["i_sm"]			=	$posted["i_sm"];	// social media options like skype, msn, yahoo
					$info["s_sm"]			=	$posted["txt_sm"];
					
					$s_verification_code	=	genVerificationCode();  // function written in common_helper
					$info["s_verification_code"] = $s_verification_code;
					
					$info["s_image"]		=	$arr_upload_res[2];//$posted["f_image"];
					$info["i_inform_news"]	=	$posted["i_inform_news"];
					$info["i_accept_terms"]	=	$posted["i_accept_terms"];
					$info["i_created_date"]	=	strtotime(date("Y-m-d H:i:s"));	
					$info['i_is_active']	=	1;  // for buyer direct login
					
					$info["i_role"]			=	$type;
					
					$emailSetBuyer = array(0=>'tradesman_placed_quote',1=>'tradesman_accepted_job_offer',2=>'tradesman_post_msg',3=>'tradesman_feedback',4=>'admin_buyer_cancel_job');
					
					// for tradesman user 
					if($type==2)
					{
						$info["i_type"]				=	$posted["i_trades_type"];	
						$info["s_gsm_no"]			=	!empty($posted["txt_gsm"])?decrypt($posted['opt_gsm']).'-'.$posted["txt_gsm"]:"";	
						$info["s_taxoffice_name"]	=	$posted["txt_tax_office"];	
						$info["s_tax_no"]			=	$posted["txt_tax_number"];	
						$info["s_firm_name"]		=	$posted["txt_firm_name"];	
						$info["s_business_name"]	=	$posted["txt_trade_name"];
						$info["s_firm_phone"]		=	decrypt($posted['opt_firm_phone']).'-'.$posted["txt_firm_phone"];
						$info["s_firm_address1"]	=	$posted["ta_firm_add1"];
						$info["s_firm_address2"]	=	$posted["ta_firm_add2"];
						$info["s_ssn"]				=	$posted["txt_ssn"];
						$info["s_address_file"]		=	$address_upload_res[2];
						
						$emailSetArr = array(0=>'job_invitation',1=>'buyer_post_msg',2=>'job_match_criteria',3=>'buyer_awarded_job',4=>'buyer_provided_feedback',5=>'buyer_terminate_job',6=>'buyer_cancell_job');
					}		
					
					
					
					/* start  latitude and longitude  */
					$state 	 = $this->province_model->fetch_this(decrypt($info["i_province"]));
					$city 	 = $this->city_model->fetch_this(decrypt($info["i_city"]));
					$zipcode = $this->zipcode_model->fetch_this(decrypt($info["i_zipcode"]));
					
					//$info['s_lat'] = $zipcode['latitude'];
    				//$info['s_lng'] = $zipcode['longitude'];			
					if($type==1)
					{
					$address = str_replace(' ','+',$info["s_address"]);	
					}
					if($type==2)
					{
					$address = str_replace(' ','+',$info["s_firm_address1"]);	
					}
					$geoCodeURL = "http://maps.google.com/maps/geo?q=".($address)."&output=xml";
								  
				    $data = $this->getURL($geoCodeURL);
					//pr($data,1);										
					$info['s_lat'] = $data["lat"];
    				$info['s_lng'] = $data["long"];		
					
					
					
					/* language in which the user signup */
					$info['i_signup_lang'] 		= $this->i_default_language;
					$info['signup_lang_prefix'] = $this->i_default_language_prefix; // for mail sending in which version
					/* language in which user signup */
					
					//pr($info,1);
									
					if($type==1)
					{
                  		 $i_newid = $this->mod_rect->add_info($info);
						 /* insert into buyer details table*/
						 $arr1 = array();
						 $arr1['i_user_id'] 	=  $i_newid;
						 $arr1['s_contact_no'] 	=  $info["s_contact_no"];
						 $table = $this->db->BUYERDETAILS;
						 $this->load->model('job_model');
						 $this->job_model->set_data_insert($table,$arr1);
						 /* insert into buyer details table*/
						 
						 $i_email_id = $this->mod_rect->insert_email_settings($emailSetBuyer,$i_newid);
						 
						 if($info['i_inform_news']==1)
							{
								$info['i_user_type'] = 1;
								$info['i_status'] = 1;
								$info['i_user_id'] = $i_newid;
								$info['dt_entry_date'] = time();
								$this->load->model('newsletter_subscribers_model');
								$chk_id = $this->newsletter_subscribers_model->add_info($info);
							}
				    }
					if($type==2)
					{
                  		 $i_newid = $this->mod_td->add_info($info);							 

						 
						 $i_mail_set_id= $this->mod_td->insert_email_settings($emailSetArr,$i_newid);
						 
						 if($info['i_inform_news']==1)
							{
								$info['i_user_type'] = 2;
								$info['i_status'] = 1;
								$info['i_user_id'] = $i_newid;
								$info['dt_entry_date'] = time();
								$this->load->model('newsletter_subscribers_model');
								$chk_id = $this->newsletter_subscribers_model->add_info($info);
							}
				    }
				   
				   /* for registration verification mail to the user */
				   
				   $content 	= $this->mod_auto->fetch_mail_content('registration_mail','general',$info['signup_lang_prefix']);	
				   $filename 	= $this->config->item('EMAILBODYHTML')."common.html";
				   $handle 		= @fopen($filename, "r");
				   $mail_html 	= @fread($handle, filesize($filename));	
				   $s_subject 	= $content['s_subject'];		
					//print_r($content); exit;	
									
					if(!empty($content))
					{					
						$description = $content["s_content"];
						
						$description = str_replace("[USERNAME]",$info['s_username'],$description);	
						$description = str_replace("[EMAIL_ADDRESS]",$info['s_email'],$description);		
						$description = str_replace("[PASSWORD]",$info['s_password'],$description); 
						if($type==2)
						{
						$description = str_replace("[NAME]",$info['s_business_name'],$description);	
						$description = str_replace("[VERIFY_LINK]",'<a href="'.base_url().'user/active_account'.'/'.$s_verification_code.'/'.$param.'">'.addslashes(t('click here to verify your account')).'</a>',$description); 
						
						}
						if($type==1)
						{
						$description = str_replace("[NAME]",$info['s_name'],$description);	
						$description = str_replace("[VERIFY_LINK]",'',$description); 	
						}
						$description = str_replace("[SITE_URL]",base_url(),$description); 
												
					}
						
					$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);	
					//echo "<br>DESC".$mail_html;	exit;
					
					/// Mailing code...[start]
					$site_admin_email = $this->s_admin_email;	
					$this->load->helper('mail');										
					$i_nwid = sendMail($info['s_email'],$s_subject,$mail_html);	
                    /// Mailing code...[end]
					
				/* end for registration verification mail to the user */	
				   
                   if($i_nwid)////saved successfully
                    {
                        if($type==1)
						{
						if($arr_upload_res[0]==='ok')
						{
							get_image_thumb($this->uploaddir.$info["s_image"], $this->thumbdir, 'thumb_'.$info["s_image"],$this->nw_height,$this->nw_width,'');
						}
						}
						if($type==2)
						{
						if($arr_upload_res[0]==='ok')
						{
							get_image_thumb($this->uploaddir.$info["s_image"], $this->thumbdir, 'thumb_'.$info["s_image"],$this->trade_height,$this->trade_width,'');
						}
						}
						
						if($this->session->userdata('s_referred_code')!='')  // for referral user who are going to registered
						{
						
							$this->load->model('recommend_model','mod_recomm');
							$info	=	array();
							$info['i_is_active']	=	1;
							$i_updated = $this->mod_recomm->update_status($info,$this->session->userdata('s_referred_code'));
							$this->session->set_userdata('s_referred_code','');
						}
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_reg"],'message_type'=>'succ'));
                       
					    if($type==2)
						{
					    	redirect($this->pathtoclass."success-registration");
						}
						if($type==1)
						{
								/*** to post job ***/
							if($this->session->userdata('job_post_session')!='')
							{
								$this->load->model('job_model');
								$job_arr	= $this->session->userdata('job_post_session');
								//pr($loggedin); 
								$job_arr['job']['i_buyer_user_id']	= $i_newid;	
								//print_r($job_arr); exit;
								$job_id = $this->job_model->set_job_insert_all($job_arr);
								//echo $job_id; exit;
								if($job_id!=0){
									redirect(base_url()."job/sucess_job_post");
									//exit;
								}
							}	
							 redirect($this->pathtoclass."success-buyer-registration");
						}
                    }
                    else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    
                }
			 
            
			}
			
			
			$this->data['posted'] = $this->session->userdata('arr_reg_value');
			$this->session->unset_userdata('arr_reg_value');
			
			
			/********************* START FETCH CONTENTS FOR LIGHTBOX ***********************/
			$this->load->model('cms_model','mod_cont');			
			$s_where = " WHERE c.i_cms_type_id=5 And c.i_status=1 ";
			$data_exist = $this->mod_cont->fetch_multi($s_where);
			if(!empty($data_exist))
			{
			$this->data["terms_condition"] = $data_exist;
			
			}
			unset($s_where,$data_exist);
			
			$s_where1 = " WHERE c.i_cms_type_id=4 And c.i_status=1 ";
			$data_exist1 = $this->mod_cont->fetch_multi($s_where1);
			if(!empty($data_exist1))
			{
			$this->data["privacy_policy"] = $data_exist1;
			}
			unset($s_where1,$data_exist1);
			/********************* END FETCH CONTENTS FOR LIGHTBOX ***********************/
			if($type==1)
			{				
				$this->render('user/buyer_registration');
				$this->s_meta_type = 'signup';
			}
			else if($type==2)
			{				
				$this->s_meta_type = 'signup';
				$this->render('user/tradesman_registration');
			}
			
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	function check_username_exist()
	{
		$s_username = $this->input->post('s_username');
		if(!preg_match('/^([a-zA-Z_#(\\\')]{5})([0-9a-zA-Z_#(\\\')]{1,20})$/', $s_username)) 
			echo 'error_pattern';
		else
		{	
			$s_wh_username	=	" WHERE n.s_username='".addslashes($s_username)."' ";
			$is_username_exist	=	$this->mod_rect->fetch_multi($s_wh_username);	
			//var_dump($is_username_exist);
			//echo '=='.$is_username_exist;
			if($is_username_exist)
				echo 'error';
			else
				echo 0;	
		}			
	}	
	
	function check_email_exist()
	{
		$s_email = $this->input->post('s_email');
		$s_wh_username	=	" WHERE n.s_email='".addslashes($s_email)."' ";
		$is_email_exist	=	$this->mod_rect->fetch_multi($s_wh_username);	
		//var_dump($is_username_exist);
		//echo '=='.$is_username_exist;
		if($is_email_exist)
			echo 'error';
		else
			echo 'succ';		
	}		
		
	
	function check_recapcha()
	{
		$recaptcha_response_field = $this->input->post('recaptcha_response_field');
		$recaptcha_challenge_field = $this->input->post('recaptcha_challenge_field');
		//echo $recaptcha_response_field.'========'.$recaptcha_challenge_field;
		include BASEPATH.'application/libraries/recaptchaLib/recaptchalib'.EXT;
		$RECAPTCHA_CHALLENGE	=	$recaptcha_challenge_field;
		$RECAPTCHA_RESPONSE		=	$recaptcha_response_field;
		$response = recaptcha_check_answer (
					$this->config->item('recaptcha_private_key'),
					$_SERVER["REMOTE_ADDR"],
					$RECAPTCHA_CHALLENGE,
					$RECAPTCHA_RESPONSE
			);		
		//var_dump($response->is_valid);	
	 if(!$response->is_valid)
	 	echo 'error';
	 else
	 	echo 'succ'; 			
		
	}
	
	public function success_registration()
	{	
		//$this->i_menu_id = 1;		
		$this->data['breadcrumb'] = array(addslashes(t('Confirmation Page'))=>'');	
		$this->render();
	}
	public function success_buyer_registration()
	{	
				
		$this->data['breadcrumb'] = array(addslashes(t('Confirmation Page'))=>'');	
		$this->render();
	}
	
	public function active_account()
	{
        try
        {			
			$this->load->model('tradesman_model','mod_td');	
			$this->load->model('manage_buyers_model','mod_rect');	
			$this->data['breadcrumb'] = array(addslashes(t('Activate Account'))=>'');		
			$activation_code = $this->uri->segment(3);	
			$user_type	=	$this->uri->segment(4);
			if(decrypt($user_type)==2)
			{
				$funRes = $this->mod_td->active_account($activation_code);
				/* send another mail to fill up professional information of the tradesman */
				$s_where = " WHERE n.s_verification_code=".$activation_code." AND n.i_is_active = 0 ";
				$trade_details = $this->mod_td->fetch_tradesman_using_activation_code($s_where);
				if($trade_details)
				{
					 $this->load->model('auto_mail_model');
					 $lang_prefix = $trade_details['lang_prefix'];
					 $content = $this->auto_mail_model->fetch_mail_content('tradesman_prof_info','tradesman',$lang_prefix);
					 $filename 	= $this->config->item('EMAILBODYHTML')."common.html";
					 $handle 	= @fopen($filename, "r");
					 $mail_html = @fread($handle, filesize($filename));	
					 $s_subject = $content['s_subject'];					
					//print_r($content); exit;
					if(!empty($content))
					{			
						$description = $content["s_content"];
						$description = str_replace("[TRADESMAN_NAME]",$trade_details['s_username'],$description);
						$description = str_replace("[LOGIN_URL]",base_url().'user/login/TVNOaFkzVT0',$description);		
						$description = str_replace("[SITE_URL]",base_url(),$description);						
					}
					//unset($content);
					
					$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					//echo "<br>DESC".$mail_html;	exit;
					
					/// Mailing code...[start]
					$this->load->helper('mail');										
					$i_newid = sendMail($trade_details['s_email'],$s_subject,$mail_html);	
						/// Mailing code...[end]
				}
			}
			if(decrypt($user_type)==1)
			{
				//$funRes = $this->mod_rect->active_account($activation_code);
				$this->session->set_userdata(array('message'=>$this->cls_msg["valid_account"],'message_type'=>'succ'));				
				redirect(base_url().'user/login/TVNOaFkzVT0');
			}
			if($funRes)
			{
				$this->session->set_userdata(array('message'=>$this->cls_msg["valid_account"],'message_type'=>'succ'));
				redirect(base_url().'user/login/TVNOaFkzVT0');
			}
			else
			{
				$this->session->set_userdata(array('message'=>$this->cls_msg["invalid_account"],'message_type'=>'err'));
				redirect(base_url().'user/registration/TVNOaFkzVT0');
			}
			$this->render();
			
        }
		
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	 	    
    
	}	
	
	
	public function login($param)
	{
	
        try
        {
			$type = decrypt($param);
			//$this->i_menu_id = 1;
			$this->data['breadcrumb'] = array(t('Login')=>'');
			$this->load->helper('cookie');
			if($_POST)
			{	
                $posted=array();
				
                $posted["txt_user_name"]= trim($this->input->post("txt_user_name"));
                $posted["txt_password"]= trim($this->input->post("txt_password"));
                
                $this->form_validation->set_rules('txt_user_name', addslashes(t('provide user name')), 'required');
                $this->form_validation->set_rules('txt_password', addslashes(t('provide password')), 'required');

                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }

                else///validated, now save into DB
                {

                    $this->load->model("User_login","mod_ul");   

                    $info=array();

                    $info["s_user_name"]=$posted["txt_user_name"];
                    $info["s_password"]=$posted["txt_password"];

                    $loggedin=$this->mod_ul->front_login($info);
					 
					//pr($loggedin); exit;
					
                    if(!empty($loggedin))   ////saved successfully
                    {						
						/*** keep me logged in****/
						$remember_me	=	$this->input->post('remember_me'); 
						if(!empty($remember_me))
						{							   
								set_cookie('User', $info["s_user_name"], time()+(60*60*24*365), '', '/', '');
								set_cookie('pass', $info["s_password"], time()+(60*60*24*365), '', '/', '');
						}
						else
						{
							   delete_cookie('User');
							   delete_cookie('pass');
						}
						/*** end keep me logged in****/
                        
                        
                        /*Start assigning membership plan if user is tadesman and in case of first time login*/
                        
                        if($loggedin['i_user_type_id']==2 && $loggedin['i_last_login_date']==0)
                        {
                            
                            $this->load->model('tradesman_model','mod_td');
                            
                            $this->mod_td->assign_tradesman_membership($loggedin['id'],1); //Assign trial membership plan
                            
                            
                        }
                        /*End assigning membership plan*/
                        
						$info = array();
						$info['i_last_login_date'] = time();
						$i_nwid	=	$this->mod_ul->update_login_date($info,$loggedin['id']); // to update last login date
						
						
						//var_dump($this->session->userdata('job_post_session'));exit;
                        /*** to post job ***/
						if($this->session->userdata('job_post_session') && $loggedin['i_user_type_id']==1)
						{
							$this->load->model('job_model');
							$job_arr	= $this->session->userdata('job_post_session');
							//pr($loggedin); 
							$job_arr['job']['i_buyer_user_id']	= $loggedin['id'];	
							//print_r($job_arr); exit;
							$job_id = $this->job_model->set_job_insert_all($job_arr);
							//echo $job_id; exit;
							if($job_id){
								redirect(base_url()."job/sucess_job_post");
								//exit;
							}
						}	
						//$this->session->unset_userdata('login_redirect_url');
						$refferer_page = $this->session->userdata('login_redirect_url');						
						//exit;
						if ($refferer_page !='')
						{
							//header('location:..'.$refferer_page);							
						    $this->session->unset_userdata('login_redirect_url');							
							redirect($refferer_page);
						}
						else if(isset($_SESSION['login_redirect_url'])&& !empty($_SESSION['login_redirect_url']))
						{
							
							$redirect_url   =   $_SESSION['login_redirect_url'];
						   //unset($_SESSION['login_redirect_url']);
							$this->session->unset_userdata('login_redirect_url');
							redirect($redirect_url);
						}
						else
						{	
										
							header('location:'.base_url()."user/dashboard");
							//redirect(base_url()."user/dashboard");
							exit;
						}
						
                       
                    }

                    else///Not saved, show the form again
                    {
                        
						$this->session->set_userdata(array('message'=>$this->cls_msg["invalid_login"],'message_type'=>'err'));
                        $this->data["posted"]=$posted;
						//redirect(base_url().'user/registration');
						redirect(base_url().'user/login/TVNOaFkzVT0');
                    }

                }
			}
			
		   unset($loggedin);
		   
           if($type==1)
			{
				$this->render('user/login/TVNOaFkzVT0');
			}
			else if($type==2)
			{
				$this->render('user/login/TVNOaFkzVT0');
			}
			
        }
		
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	 	    
    
	}
	
	public function logout()
	{
        try
        {
			$this->session->unset_userdata('login_redirect_url');
			$this->session->unset_userdata('job_post_session');
			$this->session->unset_userdata("loggedin");
			redirect(base_url().'home');			
			
        }
		
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	 	    
    
	}	
	
	
	public function forget_password()
    {
        try
        {
			//$this->i_menu_id = 1;
			$this->data['breadcrumb'] = array(addslashes(t('Forget Password'))=>'');
			
			if($_POST)
            {
				$this->load->model("forgot_password_model","obj_mod_");	
				$this->load->model("auto_mail_model");
				
                $posted=array();
                /// INPUT GIVEN EMAIL ID whose PASSWORD needs to be sent ///
				$s_email 	= $posted["txt_email"]		= 	trim($this->input->post("txt_email"));  
				$s_username	= $posted["txt_user_name"]	=	trim($this->input->post("txt_user_name"));
				
				$sender_email = $this->s_admin_email;
				             
                
				$this->form_validation->set_rules('txt_user_name', addslashes(t('provide username')), 'required'); 
				$this->form_validation->set_rules('txt_email', addslashes(t('provide email')), 'required');               
			 
              
			  	$s_where=" Where s_email='".get_formatted_string($s_email)."' And s_username='".get_formatted_string($s_username)."' ";  
				$user_detail = $this->obj_mod_->fetch_front_user_detail($s_where);
				            
                if($this->form_validation->run() == FALSE || empty($user_detail))/////invalid
                {
                    ////////Display the add form with posted values within it////
					$this->session->set_userdata(array('message'=>$this->cls_msg["invalid_info"],'message_type'=>'err'));
                    $this->data["posted"]=$posted;
					//redirect(base_url().'user/forget_password');
					redirect(base_url().'forget-password');
                }
                else///validated, now save into DB
                {
					// GENERATE NEW PASSWORD and send it to mail///
					$rand_no		=	rand(99,mktime());
		  			$org_changed_pass	=	(trim($rand_no));          			
				
                    $s_where=" WHERE s_email='".get_formatted_string($s_email)."' AND s_username='".get_formatted_string($s_username)."' ";              
                    
                 	$loggedin=$this->obj_mod_->change_password_front_user($s_where,$org_changed_pass);
					
							
                    if(!empty($loggedin))   ////saved successfully
                    {
						/// Fetching DESCRIPTION of Forgot Password and REPLACING VARIABLES///
						$info=$this->auto_mail_model->fetch_mail_content('forget_password','general');
						//pr($info);exit;
						
						$filename = $this->config->item('EMAILBODYHTML')."common.html";
				   		$handle = @fopen($filename, "r");
				   		$mail_html = @fread($handle, filesize($filename));
						$s_subject 	= $info['s_subject'];
						
						if(!empty($info))
						{	
							$description = $info["s_content"];
							$description = str_replace("[User name]",$user_detail['s_name'],$description);	
							$description = str_replace("[User username]",$user_detail["s_username"],$description);	
							$description = str_replace("[new password]",$org_changed_pass,$description); 			
						}
													
						$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
						$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
						//echo "<br>DESC".$mail_html;	exit;
							
						//save_succ #Email#
                        set_success_msg(str_replace("#Email#",get_unformatted_string($s_email),$this->cls_msg["save_succ"]));
											
						/// Mailing code...[start]
						$site_admin_email = $this->s_admin_email;	
						$this->load->helper('mail');										
						$i_newid = sendMail($s_email,$s_subject,$mail_html);	
						/// Mailing code...[end]						
						
						if($i_newid)////saved successfully
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_succ"],'message_type'=>'succ'));
							$this->data["posted"]=$posted;
							redirect($_SERVER['HTTP_REFERER']);
						}
						else///Not saved, show the form again
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["send_err"],'message_type'=>'err'));
							$this->data["posted"]=$posted;
							redirect($_SERVER['HTTP_REFERER']);
						}
						
						
                    }
                    else///Not saved, show the form again
                    {
                        $this->session->set_userdata(array('message'=>$this->cls_msg["invalid_info"],'message_type'=>'err'));
                        $this->data["posted"]=$posted;
						redirect($_SERVER['HTTP_REFERER']);
                    }
                }
            }
			
			$this->render();
			
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	/*To change language and redirect the referral page*/
	function change_lang($lang_id,$url)
	{
		$lang_id = decrypt($lang_id);
	  	$this->session->set_userdata(array('lang'=>$lang_id)); 
	  	$url = base64_decode($url);
	  	header('location:'.$url);
		exit(0); 
	}
	
	function dashboard()
	{
	
		try
		{
			$user_details = $this->session->userdata('loggedin');
			//pr($user_details,1);
			$user_type_id = decrypt($user_details['user_type_id']);			
			$red_url = ($user_type_id==1) ? 'buyer/dashboard' : 'tradesman/dashboard' ;
			redirect(base_url().$red_url);
			exit;
			
			//header('location:'.base_url().$red_url);
			//exit(0);
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	 	    
	}
	
	/* to unsubscribe newsletter */
	public function unsubscribe_newsletter()
	{
        try
        {			
			$this->load->model('newsletter_subscribers_model');	
			$this->load->model('manage_buyers_model','mod_rect');			
			$mail = $this->uri->segment(3);	
			$s_where_mail = " WHERE n.s_email=".$mail." ";
			$info = array();
			$info['i_status'] = 2;
			$change_stat = $this->newsletter_subscribers_model->unsubscribe_newsletter_info($info,$mail);
			$change_stat_user = $this->mod_rect->unsubscribe_newsletter($info,$mail);
			if($change_stat)
			{
				$this->session->set_userdata(array('message'=>$this->cls_msg["save_subscribe"],'message_type'=>'succ'));
				redirect(base_url().'home/message');
			}
			
			$this->render(base_url().'home/message');
			
        }
		
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	 	    
    
	}	

	/***
    * Checks duplicate value using ajax call
    */
    public function ajax_checkduplicate()
    {
        try
        {
            $posted=array();
            ///is the primary key,used for checking duplicate in edit mode
            $posted["id"]= decrypt($this->input->post("h_id"));/*don't change*/
            $posted["duplicate_value"]= htmlspecialchars(trim($this->input->post("h_duplicate_value")),ENT_QUOTES);
            
            if($posted["duplicate_value"]!="")
            {
                $qry=" Where ".(intval($posted["id"])>0 ? " n.id!=".intval($posted["id"])." And " : "" )
                    ." n.s_email='".$posted["duplicate_value"]."'";
                $info=$this->mod_rect->fetch_multi($qry,$start,$limit); /*don't change*/
                if(!empty($info))/////Duplicate eists
                {
                    echo "Duplicate exists";
                }
                else
                {
                    echo "valid";/*don't change*/
                }
                unset($qry,$info);
            }   
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }  
	
	
	/* to get lattitude and longitude by given address */
	public function getURL($url){
		 	$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_URL, $url);
			$tmp = curl_exec($ch);
			curl_close($ch);
			if ($tmp != false){
			 	//return $tmp;
				$data	=	$tmp;
				if ($data){
				$xml = new SimpleXMLElement($data);
				$requestCode = $xml->Response->Status->code;
				if ($requestCode == 200){
				 	//all is ok
				 	$coords = $xml->Response->Placemark->Point->coordinates;
				 	$coords = explode(',',$coords);
				 	if (count($coords) > 1){
				 		if (count($coords) == 3){
						 	return array('lat' => $coords[1], 'long' => $coords[0], 'alt' => $coords[2]);
						} else {
						 	return array('lat' => $coords[1], 'long' => $coords[0], 'alt' => 0);
						}
					}
				}
			}
			//return default data
			return array('lat' => 0, 'long' => 0, 'alt' => 0);
			}
			else
			{
				return array('lat' => 0, 'long' => 0, 'alt' => 0);
			}
		}
	
	
		
    public function __destruct()

    {}           

}