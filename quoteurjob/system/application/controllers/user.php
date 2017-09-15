<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 07 Oct 2011
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
		  $this->data['ctrlr'] = "home";
		  
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  $this->data['i_lang_id'] = $this->i_default_language;
		  $this->cls_msg=array();
		  $this->cls_msg["invalid_login"]=t("Invalid user name or password. Please try again.");
		  $this->cls_msg["success_login"]=t("Successfully logged in.");
		  
		  $this->cls_msg["invalid_info"]=t("Invalid user name or email. Please try again.");
		  $this->cls_msg["save_succ"]	=t("A new password has been generated and sent to your email successfully.");
		  $this->cls_msg["send_err"]	=t("Mail not delivered.");
		  
		  $this->cls_msg["email_exist"]=t("Email already exist.");
		  $this->cls_msg["username_exist"]=t("Username already exist.");
		  
		  $this->cls_msg["proper_username"] = t('give a proper username with minnimum 6 character');
		  
		  $this->cls_msg["invalid_account"]=t("Account not validated.");
		  $this->cls_msg["valid_account"]=t("Account validated you can login now .");
		  
		  $this->cls_msg["captcha_err"]=t("Invalid captcha.");
		  $this->cls_msg["save_reg"]=t("You have been registered successfully.");
		  
		  $this->load->model('manage_buyers_model','mod_rect');		  
		  $this->load->model('manage_tradesman_model','mod_trades');
		  
		  /* profile Image */
		  $this->allowedExt = 'jpg|jpeg|png';	
		  $this->uploaddir = $this->config->item('user_profile_image_upload_path');	
		  $this->thumbdir = $this->config->item('user_profile_image_thumb_upload_path');
		  $this->thumbDisplayPath = $this->config->item('user_profile_image_thumb_path');
		  $this->nw_width = 	$this->config->item('user_profile_photo_upload_thumb_width');
		  $this->nw_height = 	$this->config->item('user_profile_photo_upload_thumb_height');
		  
		   /****** ALBUM IMAGE UPLOAD SETTINGS  ******/
		  $this->uploadDir = $this->config->item('trades_album_image_upload_path');	
		  $this->thumbDir = $this->config->item('trades_album_image_thumb_upload_path');
		  $this->t_ht = $this->config->item('trades_album_image_upload_thumb_height');	
		  $this->t_wd = $this->config->item('trades_album_image_upload_thumb_width');
		  
		   $this->cls_msg["save_album"] = t(" album details saved succesfully");
		  $this->cls_msg["save_album_err"] = t(" album details could not saved ");
		  $this->cls_msg["img_del"]		=	t("image deleted succesfully");
		  $this->cls_msg["img_del_err"]		=	t("image could not deleted");
		  
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
			
			
			
			//$this->i_menu_id = 1;
			$this->data['breadcrumb'] = array(t('Register')=>'');
			$this->add_css('css/fe/dd.css');
			$this->add_js('js/fe/jquery.dd.js');
/*			$this->add_css('js/jquery/themes/base/jquery.ui.all.css');
			$this->add_js('js/jquery/ui/jquery.ui.core.js');
			$this->add_js('js/jquery/ui/jquery.ui.widget.js');
			$this->add_js('js/jquery/ui/jquery.ui.position.js');
			$this->add_js('js/jquery/ui/jquery.ui.autocomplete.js');*/
			$this->load->model('city_model');
			$this->load->model('state_model');
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
				$posted["txt_contact"]		= 	trim($this->input->post("txt_contact"));
				
				$posted["txt_skype"]		= 	trim($this->input->post("txt_skype"));
				$posted["txt_msn"]			= 	trim($this->input->post("txt_msn"));
				$posted["txt_yahoo"]		= 	trim($this->input->post("txt_yahoo"));
				$posted["opt_state"]		= 	trim($this->input->post("opt_state"));
				$posted["opt_city"]			= 	trim($this->input->post("opt_city"));
				$posted["opt_zip"]			= 	trim($this->input->post("opt_zip"));
				
				$posted["txt_address"]		= 	trim($this->input->post("txt_address"));
				$posted["f_image"]			= 	trim($this->input->post("f_image"));
				//$posted["s_captcha"]		= 	trim($this->input->post("s_captcha"));
				$posted["captcha_challenge"]=	trim($this->input->post("recaptcha_challenge_field"));
				$posted["captcha_response"]=	trim($this->input->post("recaptcha_response_field"));
				
				$i_inform_news 				= 	trim($this->input->post("i_inform_news"));
				$posted["i_inform_news"]	= 	($i_inform_news==1)?$i_inform_news:2;
				$i_accept_terms 			= 	trim($this->input->post("i_accept_terms"));
				$posted["i_accept_terms"]	= 	($i_accept_terms==1)?$i_accept_terms:2;
				
				if($type==2)
				{
				$posted['txt_website']		=	trim($this->input->post("txt_website"));
				$posted['txt_about_me']		=	trim($this->input->post("txt_about_me"));
				$posted['txt_skills']		=	trim($this->input->post("txt_skills"));
				$posted['txt_qualification']=	trim($this->input->post("txt_qualification"));
				$posted['txt_business_name']=	trim($this->input->post("txt_business_name"));
				/* multiple category */
				$posted["opd_category0"]	= 	trim($this->input->post("opd_category0"));
				$posted["opd_category1"]	= 	trim($this->input->post("opd_category1"));
				$posted["opd_category2"]	= 	trim($this->input->post("opd_category2"));
				
				$input_cat	=	array(decrypt($posted["opd_category0"]),decrypt($posted["opd_category1"]),decrypt($posted["opd_category2"]));
				$result_cat	=	array_unique($input_cat);	
				
				//var_dump($result_cat); exit;
				// insert multiple category into child table				
				/*$cat_str = '';
				foreach($result_cat as $val)
				{
					$cat_str .=$val.',';
				}
				$comma_separated = format_csv_string($cat_str); */
				
				
				//echo $str; exit;
				/* multiple category */
				
				$posted["payment_type"]		=	trim($this->input->post("RadioGroup1"));
				$posted["like_travel"]		=	trim($this->input->post("RadioGroup2"));
				$posted["radius"]			=	decrypt(trim($this->input->post("radius1")));
				}
				//print_r($result_cat); exit;
				//print_r($posted); exit;
				
				
				
				if(isset($_FILES['f_image']) && !empty($_FILES['f_image']['name']))
				{					
					$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'f_image','','',$this->allowedExt);					
					$arr_upload_res = explode('|',$s_uploaded_filename);
				}               
			   
			   	include BASEPATH.'application/libraries/recaptchaLib/recaptchalib'.EXT;
				$RECAPTCHA_CHALLENGE	=	$posted["captcha_challenge"];
				$RECAPTCHA_RESPONSE		=	$posted["captcha_response"];
				$response = recaptcha_check_answer (
                            $this->config->item('recaptcha_private_key'),
                            $_SERVER["REMOTE_ADDR"],
                            $RECAPTCHA_CHALLENGE,
                            $RECAPTCHA_RESPONSE
                    );
				
				//print_r($response); 
				//var_dump($response); 
			    //print_r($posted); exit;
				//echo 'hi----';
				
				
                $this->form_validation->set_rules('txt_name', 'provide name', 'required');
				$this->form_validation->set_rules('txt_email', 'provide email', 'valid_email|required');
				$this->form_validation->set_rules('txt_con_email', 'provide confirm email', 'valid_email|required|matches[txt_email]');
				$this->form_validation->set_rules('txt_username', 'provide username', 'required');
				$this->form_validation->set_rules('txt_password', 'provide password', 'required');
				$this->form_validation->set_rules('txt_con_password', 'provide confirm password', 'required|matches[txt_password]');
				$this->form_validation->set_rules('txt_contact', 'provide contact number', 'required');
				$this->form_validation->set_rules('opt_state', 'select province', 'required');
				$this->form_validation->set_rules('opt_city', 'select city', 'required');
				$this->form_validation->set_rules('opt_zip', 'select postal code', 'required');
				$this->form_validation->set_rules('txt_address', 'provide address', 'required');
				$this->form_validation->set_rules('recaptcha_response_field', 'provide correct security code', 'required');
				$this->form_validation->set_rules('i_accept_terms', 'accept terms & conditions', 'required');
				
				if($type==2)
				{
					$this->form_validation->set_rules('txt_about_me', 'provide about me', 'required');
					$this->form_validation->set_rules('txt_skills', 'provide skills', 'required');
					$this->form_validation->set_rules('txt_qualification', 'provide qualification', 'required');
					$this->form_validation->set_rules('txt_business_name', 'provide business name', 'required');
					$this->form_validation->set_rules('opd_category0', 'select category', 'required');
					$this->form_validation->set_rules('RadioGroup1', 'select payment type', 'required');
					$this->form_validation->set_rules('RadioGroup2', 'would you like to travel', 'required');
					
				}
			
				//echo 'hello----';
				$check_user_name	=	checkUsername($posted['txt_username']);
				if($check_user_name=='')
				{
					$this->session->set_userdata(array('message'=>$this->cls_msg["proper_username"],'message_type'=>'err'));					
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
				$s_wh = " WHERE n.s_email='".$posted['txt_email']."' ";
				$is_email_exist = $this->mod_rect->fetch_multi($s_wh);
				
				$s_wh_username	=	" WHERE n.s_username='".addslashes(trim($posted['txt_username']))."' ";
				$is_username_exist	=	$this->mod_rect->fetch_multi($s_wh_username);
				
				
			//	print_r($is_email_exist); exit;
              
                if($this->form_validation->run() == FALSE || ($arr_upload_res[0]==='err') || !empty($is_email_exist) || !empty($is_username_exist) )/////invalid
                {
					$this->session->set_userdata('arr_reg_value',$posted);
					if($arr_upload_res[0]==='err')
					{
						set_error_msg($arr_upload_res[2]);
					}
					else
					{
						get_file_deleted($this->uploaddir,$arr_upload_res[2]);
					}
					
					if(!empty($is_email_exist))
					{	
						$array = array('message' => $this->cls_msg["email_exist"],'message_type' =>'err');
						
						$this->session->set_userdata($array) ;
						
							
						if($type==1)
						{
						redirect(base_url().'user/registration/TVNOaFkzVT0');
						}
						if($type==2)
						{
						redirect(base_url().'user/registration/TWlOaFkzVT0');
						}					
					}
					
					if(!empty($is_username_exist))
					{	
					
						$this->session->set_userdata(array('message'=>$this->cls_msg["username_exist"],'message_type'=>'err'));				
						//set_error_msg($this->cls_msg["email_exist"]);	
						
						if($type==1)
						{							
							redirect(base_url().'user/registration/TVNOaFkzVT0');
						}
						if($type==2)
						{
							redirect(base_url().'user/registration/TWlOaFkzVT0');
						}										
					}
/*					if(!$response->is_valid)
					{
						//set_error_msg($this->cls_msg["captcha_err"]);	
						
						$this->session->set_userdata(array('message'=>$this->cls_msg["captcha_err"],'message_type'=>'err'));
						if($type==1)
						{
							redirect(base_url().'user/registration/TVNOaFkzVT0');
						}
						if($type==2)
						{
							redirect(base_url().'user/registration/TWlOaFkzVT0');
						}											
					}*/
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
					$info["s_contact_no"]	=	$posted["txt_contact"];
					$info["i_province"]		=	$posted["opt_state"];
					$info["i_city"]			=	$posted["opt_city"];
					$info["i_zipcode"]		=	$posted["opt_zip"];
					$info["s_address"]		=	$posted["txt_address"];
					$info["s_skype_id"]		=	$posted["txt_skype"];
					$info["s_msn_id"]		=	$posted["txt_msn"];
					$info["s_yahoo_id"]		=	$posted["txt_yahoo"];
					
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
						$info["s_website"]		=	$posted["txt_website"];	
						$info["s_about_me"]		=	$posted["txt_about_me"];	
						$info["s_skills"]		=	$posted["txt_skills"];	
						$info["s_qualification"]=	$posted["txt_qualification"];	
						$info["s_business"]		=	$posted["txt_business_name"];	
						$info["payment_type"]	=	$posted["payment_type"];
						$info["s_like_travel"]	=	$posted["like_travel"];
						$info["i_category"]		=	$posted["opd_category0"];
						$info["i_radius"]		=	$posted["radius"];
						
						$emailSetArr = array(0=>'job_invitation',1=>'buyer_post_msg',2=>'job_match_criteria',3=>'buyer_awarded_job',4=>'buyer_provided_feedback',5=>'buyer_terminate_job',6=>'buyer_cancell_job');
					}		
					
					/* start  latitude and longitude  */
					$state = $this->state_model->fetch_this(decrypt($info["i_province"]));
					$city = $this->city_model->fetch_this(decrypt($info["i_city"]));
					$zipcode = $this->zipcode_model->fetch_this(decrypt($info["i_zipcode"]));
					
				 	$address = utf8_encode($info["s_address"].','.$state['state'].','.$city['city'].','.$zipcode['postal_code']);					
					// call geoencoding api with param json for output
					$geoCodeURL = "http://maps.google.com/maps/api/geocode/json?address=".
								  urlencode($address)."&sensor=false";
					
					$result = json_decode(file_get_contents($geoCodeURL), true);					
					$info['s_lat'] = ($result["results"][0]["geometry"]["location"]["lat"]) ? @$result["results"][0]["geometry"]["location"]["lat"] : 0;
    				$info['s_lng'] = ($result["results"][0]["geometry"]["location"]["lng"]) ? @$result["results"][0]["geometry"]["location"]["lng"]:0;
					/* end  latitude and longitude  */
					
					/* language in which the user signup */
					$info['i_signup_lang'] = $this->i_default_language; // for mail sending in which version
					/* language in which user signup */
					
					//print_r($result); exit;					
					if($type==1)
					{
                  		 $i_newid = $this->mod_rect->add_info($info);
						 
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
                  		 $i_newid = $this->mod_trades->add_info($info);							 
						  
						 $i_cat_id= $this->mod_trades->insert_multiple_category($result_cat,$i_newid);
						 
						 $i_mail_set_id= $this->mod_trades->insert_email_settings($emailSetArr,$i_newid);
						 
						 if($info['i_inform_news']==1)
							{
								$info['i_user_type'] = 2;
								$info['i_status'] = 1;
								$info['i_user_id'] = $i_newid;
								$info['dt_entry_date'] = time();
								$this->load->model('newsletter_subscribers_model');
								$chk_id = $this->newsletter_subscribers_model->add_info($info);
							}
						/* radar setting entry */
							if($i_newid)
							{		
								$radar['i_user_id'] = $i_newid;
								$radar['i_postal_code'] = $zipcode['postal_code'];
								$radar['i_radius'] = $posted['radius1'];
								$radar['i_category_id'] = 1;
								$this->load->model('radar_model');
								$i_radar_id = $this->radar_model->add_info($radar);
								if($i_radar_id)
								{
									$this->radar_model->del_radar_cat($i_radar_id);
									$arr1 = array();
									if($result_cat)
									{
										foreach($result_cat as $val)
										{
											$arr1['i_radar_id']  =  $i_radar_id;
											$arr1['i_category_id'] =  intval($val);
											$table = $this->db->RADAR_CAT;
											$this->radar_model->set_data_insert($table,$arr1);
										}
									}	
								} 
							}
						/* end radar setting entry */	
							
							
				    }
				   
				   /* for registration verification mail to the user */
				   
				   $content = $this->mod_auto->fetch_contact_us_content('registration_mail','general');	
				   //print_r($content);	
				   $filename = $this->config->item('EMAILBODYHTML')."common.html";
				   $handle = @fopen($filename, "r");
				   $mail_html = @fread($handle, filesize($filename));			
					//print_r($content); exit;	
					
						
									
						if(!empty($content))
							{					
								if($info['i_signup_lang']==2)	
								{
									$description = $content["s_content_french"];
								}		
								else
								{
									$description = $content["s_content"];
								}
								$description = str_replace("[User name]",$info['s_name'],$description);	
								$description = str_replace("[User username]",$info['s_username'],$description);	
								$description = str_replace("[User email address]",$info['s_email'],$description);		
								$description = str_replace("[User password]",$info['s_password'],$description); 
								if($type==2)
								{
								$description = str_replace("[Click here to verify your account now]",'<a href="'.base_url().'user/active_account'.'/'.$s_verification_code.'/'.$param.'">'.t('click here to verify your account').'</a>',$description); 
								//$description = str_replace("[Click here to verify your account now]",base_url().'user/active_account'.'/'.$s_verification_code.'/'.$param,$description); 
								}
								if($type==1)
								{
								$description = str_replace("[Click here to verify your account now]",'',$description); 	
								}
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
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					$config['mailtype'] = 'html';
										
					$this->email->initialize($config);					
					$this->email->clear();                    
                    
                    $this->email->from($site_admin_email);	
									
                    $this->email->to($info["s_email"]);
                    if($info['i_signup_lang']==2)
					{
						$this->email->subject($content['s_subject_french']); // subject for french version
					}
					else
					{
                    	$this->email->subject('::: Registration mail :::');
					}
					unset($content);
                    $this->email->message($mail_html);
					//echo "<br>DESC".$description;	exit;	
					
                    if(SITE_FOR_LIVE)///For live site
					{		
									
						$i_nwid = $this->email->send();	
																
					}
					else{
						$i_nwid = TRUE;				
					}
                    /// Mailing code...[end]	
					
				/* end for registration verification mail to the user */	
				   
                   if($i_nwid)////saved successfully
                    {
                        if($arr_upload_res[0]==='ok')
						{
							get_image_thumb($this->uploaddir.$info["s_image"], $this->thumbdir, 'thumb_'.$info["s_image"],$this->nw_heightt,$this->nw_width,'');
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
					    	redirect($this->pathtoclass."success_registration");
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
							 redirect($this->pathtoclass."success_buyer_registration");
						}
                    }
                    else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    
                }
            
			}
			
			/////////to get static content for terms & conditions and privacy policy
			
			$this->load->model('content_model','mod_cont');			
			$s_where = " WHERE c.i_cms_type_id=6 And c.i_status=1 ";
			$data_exist = $this->mod_cont->fetch_multi($s_where.' And c.i_lang_id="'.$this->i_default_language.'"');
			if(!empty($data_exist))
			{
			$this->data["terms_condition"] = $data_exist;
			}
			else
			{
				$this->data['terms_condition'] = $this->mod_cont->fetch_multi($s_where.' And c.i_lang_id="'.$this->i_main_default_language.'"');
			}
			$title = explode(' ',$this->data['terms_condition'][0]["s_title"],2);
			$this->data["pre"] = $title[0];
			$this->data["next"] = $title[1];
			
			
			
			$s_where1 = " WHERE c.i_cms_type_id=5 And c.i_status=1 ";
			$data_exist1 = $this->mod_cont->fetch_multi($s_where1.' And c.i_lang_id="'.$this->i_default_language.'"');
			// policy
			if(!empty($data_exist1))
			{
			$this->data["policy"] = $data_exist1;
			}
			else
			{
				$this->data['policy'] = $this->mod_cont->fetch_multi($s_where1.' And c.i_lang_id="'.$this->i_main_default_language.'"');
			}
			$title1 = explode(' ',$this->data['policy'][0]["s_title"],2);
			$this->data["pre1"] = $title1[0];
			$this->data["next1"] = $title1[1];
			
			/////////// end  to get static content for terms & conditions and privacy policy
			
			
			
			$this->data['posted'] = $this->session->userdata('arr_reg_value');
			$this->session->unset_userdata('arr_reg_value');
			// load the view 
			if($type==1)
			{				
				$this->render('user/buyer_registration');
				$this->s_meta_type = 'signup';
			}
			else if($type==2)
			{
				$this->render('user/tradesman_registration');
				$this->s_meta_type = 'signup';
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
		$this->data['breadcrumb'] = array(t('Confirmation Page')=>'');	
		$this->render();
	}
	public function success_buyer_registration()
	{	
		//$this->i_menu_id = 1;		
		$this->data['breadcrumb'] = array(t('Confirmation Page')=>'');	
		$this->render();
	}
	
	public function active_account()
	{
        try
        {			
			$this->load->model('manage_tradesman_model','mod_trades');	
			$this->load->model('manage_buyers_model','mod_rect');			
			$activation_code = $this->uri->segment(3);	
			$user_type	=	$this->uri->segment(4);
			if(decrypt($user_type)==2)
			{
				$funRes = $this->mod_trades->active_account($activation_code);
			}
			if(decrypt($user_type)==1)
			{
				//$funRes = $this->mod_rect->active_account($activation_code);
				$this->session->set_userdata(array('message'=>$this->cls_msg["valid_account"],'message_type'=>'succ'));
				//redirect(base_url().'user/registration/TVNOaFkzVT0');
				redirect(base_url().'user/login/TVNOaFkzVT0');
			}
			if($funRes)
			{
				$this->session->set_userdata(array('message'=>$this->cls_msg["valid_account"],'message_type'=>'succ'));
				//redirect(base_url().'user/registration/TVNOaFkzVT0');
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
                
                $this->form_validation->set_rules('txt_user_name', 'provide user name', 'required');
                $this->form_validation->set_rules('txt_password', 'provide password', 'required');

              	//print_r($posted); exit;

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
					
					//print_r($loggedin); exit;
					
					
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
							//header('location:../home');
							redirect(base_url()."user/dashboard/");
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
		   
		   
		   /* get static content for terms & condition and privacy policy */
		   $this->load->model('content_model','mod_cont');			
			$s_where = " WHERE c.i_cms_type_id=6 And c.i_status=1 ";
			$data_exist = $this->mod_cont->fetch_multi($s_where.' And c.i_lang_id="'.$this->i_default_language.'"');
			if(!empty($data_exist))
			{
			$this->data["terms_condition"] = $data_exist;
			}
			else
			{
				$this->data['terms_condition'] = $this->mod_cont->fetch_multi($s_where.' And c.i_lang_id="'.$this->i_main_default_language.'"');
			}
			
			
			$s_where1 = " WHERE c.i_cms_type_id=5 And c.i_status=1 ";
			$data_exist1 = $this->mod_cont->fetch_multi($s_where1.' And c.i_lang_id="'.$this->i_default_language.'"');
			if(!empty($data_exist1))
			{
			$this->data["policy"] = $data_exist1;
			}
			else
			{
				$this->data['policy'] = $this->mod_cont->fetch_multi($s_where.' And c.i_lang_id="'.$this->i_main_default_language.'"');
			}
		   /* end get static content for terms & condition and privacy policy */
		   
           if($type==1)
			{
				//$this->render('user/buyer_registration');
				$this->render('user/login/TVNOaFkzVT0');
			}
			else if($type==2)
			{
				//$this->render('user/tradesman_registration');
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
			$this->session->set_userdata(array("loggedin"=> ''));
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
			$this->data['breadcrumb'] = array(t('Forget Password')=>'');
			
			if($_POST)
            {
				$this->load->model("forgot_password_model","obj_mod_");	
				$this->load->model("auto_alert_model","mod_auto");
				$this->load->model("auto_mail_model");
				
                $posted=array();
                /// INPUT GIVEN EMAIL ID whose PASSWORD needs to be sent ///
				$s_email 	= $posted["txt_email"]		= 	trim($this->input->post("txt_email"));  
				$s_username	= $posted["txt_user_name"]	=	trim($this->input->post("txt_user_name"));
				
				$sender_email = $this->s_admin_email;
				             
                
				$this->form_validation->set_rules('txt_user_name', t('provide username'), 'required'); 
				$this->form_validation->set_rules('txt_email', t('provide email'), 'required');               
			 
              
			  	$s_where=" Where s_email='".get_formatted_string($s_email)."' And s_username='".get_formatted_string($s_username)."' ";  
				$user_detail = $this->obj_mod_->fetch_front_user_detail($s_where);
				            
                if($this->form_validation->run() == FALSE || empty($user_detail))/////invalid
                {
                    ////////Display the add form with posted values within it////
					$this->session->set_userdata(array('message'=>$this->cls_msg["invalid_info"],'message_type'=>'err'));
                    $this->data["posted"]=$posted;
					redirect(base_url().'user/forget_password');
                }
                else///validated, now save into DB
                {
					// GENERATE NEW PASSWORD and send it to mail///
					$rand_no		=	rand(99,mktime());
		  			$org_changed_pass	=	(trim($rand_no));          			
				
                    $s_where=" Where s_email='".get_formatted_string($s_email)."' And s_username='".get_formatted_string($s_username)."' ";              
                    
                 	$loggedin=$this->obj_mod_->change_password_front_user($s_where,$org_changed_pass);
					
					//$user_detail = $this->obj_mod_->fetch_front_user_detail($s_where);						
					//print_r($user_detail); exit;/// getting USERNAME depending on EMAIL ///
					
							
                    if(!empty($loggedin))   ////saved successfully
                    {
						/// Fetching DESCRIPTION of Forgot Password and REPLACING VARIABLES///
						$info=$this->auto_mail_model->fetch_contact_us_content('forget_password','general');
						//pr($info);exit;
						
						$filename = $this->config->item('EMAILBODYHTML')."common.html";
				   		$handle = @fopen($filename, "r");
				   		$mail_html = @fread($handle, filesize($filename));
						
							if(!empty($info))
							{			
								if($user_detail["i_signup_lang"]==2)
								{
									$description = $info["s_content_french"];
								}
								else
								{				
									$description = $info["s_content"];
								}
								$description = str_replace("[User name]",$user_detail['s_name'],$description);	// Changine USER FULLNAME
								$description = str_replace("[User username]",$user_detail["s_username"],$description);	// Changine MAIL SENDER NAME	
								$description = str_replace("[new password]",$org_changed_pass,$description); // Changine PASSWORD
								
								$description = str_replace("[site url]",base_url(),$description);	
								$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
							}
							//unset($info);
						
						//echo "<br>DESC".$description;	exit;
						$mail_html = str_replace("[site url]",base_url(),$mail_html);	
						$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
							
						//save_succ #Email#
                        set_success_msg(str_replace("#Email#",get_unformatted_string($s_email),$this->cls_msg["save_succ"]));
											
						/// Mail sending Process starts//				
						$this->load->library('email');
						$config['protocol'] = 'sendmail';
						$config['mailpath'] = '/usr/sbin/sendmail';
						$config['charset'] = 'iso-8859-1';
						$config['wordwrap'] = TRUE;
						$config['mailtype'] = 'html';
						
						$this->email->initialize($config);
						
						$this->email->clear();
						
						$this->email->from($sender_email);
						$this->email->to($s_email);	
						if($user_detail['i_signup_lang']==2)  // for automail in french version
						{
							$this->email->subject($info['s_subject_french']);
						}	
						else
						{						
							$this->email->subject('Your Password has been changed.');
						}
						unset($info);
						$this->email->message($mail_html);						
						//$this->email->send();
						if(SITE_FOR_LIVE)///For live site
							{
								$i_newid = $this->email->send();
							}
						else{
							$i_newid = TRUE;				
						}
						if($i_newid)////saved successfully
							{
								$this->session->set_userdata(array('message'=>$this->cls_msg["save_succ"],'message_type'=>'succ'));
								$this->data["posted"]=$posted;
								redirect($_SERVER['HTTP_REFERER']);
							}
						 else///Not saved, show the form again
							{
								//set_error_msg($this->cls_msg["send_err"]);
								$this->session->set_userdata(array('message'=>$this->cls_msg["send_err"],'message_type'=>'err'));
								$this->data["posted"]=$posted;
								redirect($_SERVER['HTTP_REFERER']);
							}
						
						/// Mail sending Process ends//
                        ///redirect(admin_base_url()."home/");
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
			$user_type_id = decrypt($user_details['user_type_id']);			
			$red_url = ($user_type_id==1) ? 'buyer/dashboard' : 'tradesman/dashboard' ;
			redirect(base_url().$red_url);
			exit;
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	 	    
	}
	
	/*function buyer_dashboard()
	{
		$this->render();
	}
	function tradesman_dashboard()
	{
		$this->render();
	}*/
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
	
	
	
	
		
    public function __destruct()

    {}           

}