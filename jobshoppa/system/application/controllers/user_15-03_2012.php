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
		  $this->cls_msg["invalid_login"]="Invalid user name or password. Please try again.";
		  $this->cls_msg["success_login"]="Successfully logged in.";
		  
		  $this->cls_msg["invalid_info"]="Invalid user name or email. Please try again.";
		  $this->cls_msg["save_succ"]	="A new password has been generated and has been sent to your inbox.";
		  $this->cls_msg["send_err"]	="Mail not delivered.";
		  
		  $this->cls_msg["email_exist"]="Email already exist.";
		  $this->cls_msg["username_exist"]="Username already exist.";
          
          $this->cls_msg["dob_err"]="Date of Birth is less than 18 years.";
		  
		  $this->cls_msg["proper_username"] = 'give a proper username with minnimum 6 character';
		  
		  $this->cls_msg["invalid_account"]="Account not validated.";
		  $this->cls_msg["valid_account"]="Your account has been verified, please login.";
		  $this->cls_msg["valid_account_trades"]="Thank you for verifying your account, you can now login and bid for jobs.";
		  
		  $this->cls_msg["captcha_err"]="Invalid captcha.";
		  $this->cls_msg["save_reg"]="Registration successfull.";
		  
		  $this->cls_msg["save_subscribe"] = "Newsletter unsubscribe succesfully";
		  
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
		  
		   $this->cls_msg["save_album"] = " album details saved succesfully";
		  $this->cls_msg["save_album_err"] = " album details could not saved ";
		  $this->cls_msg["img_del"]		=	"image deleted succesfully";
		  $this->cls_msg["img_del_err"]		=	"image could not deleted";
		  
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
		
			//$this->i_menu_id = 1;
           
			$this->data['breadcrumb'] = array('Client Registration'=>'');
			$this->add_css('css/fe/dd.css');
			$this->add_js('js/fe/jquery.dd.js');
			$this->load->model('city_model');
			$this->load->model('state_model');
			$this->load->model('zipcode_model');
			$type	=	decrypt($param);
			$type	=	($type) ? $type : 1;
            $fconnet_user_detals = $this->session->userdata('fconnet_user_detals');

            if($type==1)
            {                            
                 $this->data['breadcrumb'] = array('Client Registration'=>'');       
            }
            if($type==2)
            {
                $this->data['breadcrumb'] = array('Professional Registration'=>'');        
            }			
			//var_dump($_POST);
            
			/* for fconnect*/


			if($_POST)
			{	                
				$this->load->model('auto_mail_model','mod_auto');
				
				$posted=array();
                $posted["txt_name"]			= 	trim($this->input->post("txt_name"));
				$posted["txt_email"]		= 	trim($this->input->post("txt_email"));
				$posted["txt_con_email"]	= 	trim($this->input->post("txt_con_email"));
				$posted["txt_username"]		= 	trim($this->input->post("txt_username"));
				$posted["txt_password"]		= 	trim($this->input->post("txt_password"));
				$posted["txt_con_password"]	= 	trim($this->input->post("txt_con_password"));
				$posted["txt_contact"]		= 	trim($this->input->post("txt_contact"));
                $posted["txt_fax"]          =   trim($this->input->post("txt_fax"));
                $posted["txt_landline"]     =   trim($this->input->post("txt_landline"));
				$posted["txt_skype"]		= 	trim($this->input->post("txt_skype"));
				$posted["txt_msn"]			= 	trim($this->input->post("txt_msn"));
				$posted["txt_yahoo"]		= 	trim($this->input->post("txt_yahoo"));
				$posted["opt_state"]		= 	trim($this->input->post("opt_state"));
				$posted["opt_city"]			= 	trim($this->input->post("opt_city"));
				$posted["opt_zip"]			= 	trim($this->input->post("opt_zip"));
				
				$posted["txt_address"]		= 	trim($this->input->post("txt_address"));
                
                $posted["txt_dob"]          =   trim($this->input->post("txt_dob"));
				//$posted["f_image"]		= 	trim($this->input->post("f_image"));
                $posted["f_image"]          =   $_FILES['f_image']['name'] ;
				//$posted["s_captcha"]		= 	trim($this->input->post("s_captcha"));
				$posted["captcha_challenge"]=	trim($this->input->post("recaptcha_challenge_field"));
				$posted["captcha_response"]=	trim($this->input->post("recaptcha_response_field"));
				
				$i_inform_news 				= 	trim($this->input->post("i_inform_news"));
				$posted["i_inform_news"]	= 	($i_inform_news==1)?$i_inform_news:2;
				$i_accept_terms 			= 	trim($this->input->post("i_accept_terms"));
				$posted["i_accept_terms"]	= 	($i_accept_terms==1)?$i_accept_terms:2;
				
				if($type==2)
				{
                        $posted["txt_facebook"]     =   trim($this->input->post("txt_facebook"));
				        $posted['txt_website']		=	trim($this->input->post("txt_website"));
				        $posted['txt_about_me']		=	trim($this->input->post("txt_about_me"));
				        $posted['txt_skills']		=	trim($this->input->post("txt_skills"));
				        $posted['txt_qualification']=	trim($this->input->post("txt_qualification"));
				        $posted['txt_business_name']=	trim($this->input->post("txt_business_name"));
                        $posted['txt_vatno']        =   trim($this->input->post("txt_vatno")); 
				        /* multiple category */
				        $posted["opd_category"]	= 	$this->input->post("opd_category");
                        $posted['cnt_opt_cat'] = count($posted["opd_category"]);
				        //$posted["opd_category1"]	= 	trim($this->input->post("opd_category1"));
				        //$posted["opd_category2"]	= 	trim($this->input->post("opd_category2"));
				        
				        //$input_cat	=	array(decrypt($posted["opd_category0"]),decrypt($posted["opd_category1"]),decrypt($posted["opd_category2"]));
                        $result_cat = array();
                        foreach($posted["opd_category"] as $val)
                        {
                           $result_cat[]    =    decrypt(trim($val));   
                        }

				        
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
				        
				        $posted["payment_type"]		    =	    trim($this->input->post("RadioGroup1"));
                        $posted["over_phone_internet"]  =       trim($this->input->post("RadioGroup2")); 
				        $posted["like_travel"]		    =	    trim($this->input->post("RadioGroup3"));
				        $posted["radius1"]			    =	    decrypt(trim($this->input->post("radius1")));
				}
                
				//print_r($result_cat); exit;
				//print_r($posted); exit;

				 
				$arr_upload_res = array();
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
                $this->form_validation->set_rules('txt_dob', 'provide date of birth', 'required'); 
				$this->form_validation->set_rules('recaptcha_response_field', 'provide correct security code', 'required');
				$this->form_validation->set_rules('i_accept_terms', 'accept terms & conditions', 'required');
                
				
				if($type==2)
				{
					$this->form_validation->set_rules('txt_about_me', 'provide about me', 'required');
					$this->form_validation->set_rules('txt_skills', 'provide skills', 'required');
					$this->form_validation->set_rules('txt_qualification', 'provide qualification', 'required');
					$this->form_validation->set_rules('txt_business_name', 'provide business name', 'required');
					$this->form_validation->set_rules('opd_category[]', 'select category', 'required');
					$this->form_validation->set_rules('RadioGroup1', 'select payment type', 'required');
					$this->form_validation->set_rules('RadioGroup3', 'would you like to travel', 'required');
                    $this->form_validation->set_rules('txt_dob', 'provide Date of Birth', 'required|callback_check_dob'); 
                    //echo   $type."SH";
					
				}
			
    
                if($this->form_validation->run() == FALSE || ($arr_upload_res[0]==='err') || !empty($is_email_exist) || !empty($is_username_exist) )/////invalid
                {
                    
                    //exit;
                    
					$this->session->set_userdata('arr_reg_value',$posted);
					if($arr_upload_res[0]==='err')
					{
						set_error_msg($arr_upload_res[2]);
					}
					else
					{
						get_file_deleted($this->uploaddir,$arr_upload_res[2]);
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
					$info["s_contact_no"]	=	$posted["txt_contact"];
					$info["i_province"]		=	$posted["opt_state"];
					$info["i_city"]			=	$posted["opt_city"];
					$info["i_zipcode"]		=	$posted["opt_zip"];
					$info["s_address"]		=	$posted["txt_address"];
                    $info["s_fax"]          =   $posted["txt_fax"];
                    $info["s_landline"]     =   $posted["txt_landline"];
                    
                    
					$info["s_skype_id"]		=	$posted["txt_skype"];
					$info["s_msn_id"]		=	$posted["txt_msn"];
					$info["s_yahoo_id"]		=	$posted["txt_yahoo"];
					
					$s_verification_code	=	genVerificationCode();  // function written in common_helper
					$info["s_verification_code"] = $s_verification_code;
					
					$info["s_image"]		=	$arr_upload_res[2];//$posted["f_image"];
					$info["i_inform_news"]	=	$posted["i_inform_news"];
					$info["i_accept_terms"]	=	$posted["i_accept_terms"];
					$info["i_created_date"]	=	strtotime(date("Y-m-d H:i:s"));	
					$info['i_is_active']	=	0;  // for buyer direct login
					
					$info["i_role"]			=	$type;
					$info["i_dob"]          =   convert_date_mdy_format($posted["txt_dob"]);    ////////This function written in helper.php
	
/*					pr($_POST);
					echo date("Y/m/d", 	$info["i_dob"]);
					pr($info);exit;
*/					
					$emailSetBuyer = array(0=>'tradesman_placed_quote',1=>'tradesman_accepted_job_offer',2=>'tradesman_post_msg',3=>'tradesman_feedback',4=>'admin_buyer_cancel_job',5=>'tradesman_review_rating');

					if(!empty($fconnet_user_detals))
					{
						$info["i_verify_facebook"]= 1;
						$info["i_facebook_login"]= 1;
						$info["s_facebook_email"] = $fconnet_user_detals['email'];
					}					
					//pr($info);
					//exit;
					
					// for tradesman user
					if($type==2)
					{
                        $info["s_facebook"]         =   $posted["txt_facebook"];    
						$info["s_website"]		    =	$posted["txt_website"];	
						$info["s_about_me"]		    =	$posted["txt_about_me"];	
						$info["s_skills"]		    =	$posted["txt_skills"];	
						$info["s_qualification"]    =	$posted["txt_qualification"];	
						$info["s_business"]		    =	$posted["txt_business_name"];	
						$info["payment_type"]	    =	$posted["payment_type"];
						$info["s_like_travel"]	    =	$posted["like_travel"];
                        $info["i_phone_internet"]   =   $posted["over_phone_internet"];  
						//$info["i_category"]		    =	$posted["opd_category"];
						$info["i_radius"]		    =	$posted["radius1"];
						

						
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
					
					//print_r($result); exit;	
                    
			
					if($type==1)
					{
						 $this->load->model('job_model');
                  		 $i_newid = $this->mod_rect->add_info($info);
						 $arr1 = array();
						 $arr1['i_user_id'] =  $i_newid;
						 $table = $this->db->BUYERDETAILS;
						 $this->job_model->set_data_insert($table,$arr1);		
						 
						 $i_email_id = $this->mod_rect->insert_email_settings($emailSetBuyer,$i_newid);
						 $this->session->unset_userdata('fconnet_user_detals');			
						  if($info['i_inform_news']==1)
							{
								/* Remove fconnnect session */
								//if(!empty($fconnet_user_detals))
									$this->session->unset_userdata('fconnet_user_detals');				
							
								$info['i_user_type'] = 1;
								$info['i_status'] = 1;
								$info['i_user_id'] = $i_newid;
								$info['dt_entry_date'] = time();
								$this->load->model('newsletter_subscribers_model');
								
								$s_sub = " WHERE n.s_email='".$info['s_email']."' ";
							    $is_subscribed = $this->newsletter_subscribers_model->gettotal_info($s_sub);
								$exist_id = $this->newsletter_subscribers_model->fetch_multi($s_sub);
								if($is_subscribed<=0)
								{
									$chk_id = $this->newsletter_subscribers_model->add_info($info);
								}
								else
								{
									$chk_id = $this->newsletter_subscribers_model->edit_info($info,$exist_id[0]['id']);
								}
							}
				    }
					if($type==2)
					{
						 //pr($info); exit;
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
								$s_sub = " WHERE n.s_email='".$info['s_email']."' ";
							    $is_subscribed = $this->newsletter_subscribers_model->gettotal_info($s_sub);
								$exist_id = $this->newsletter_subscribers_model->fetch_multi($s_sub);
								if($is_subscribed<=0)
								{
									$chk_id = $this->newsletter_subscribers_model->add_info($info);
								}
								else
								{
									$chk_id = $this->newsletter_subscribers_model->edit_info($info,$exist_id[0]['id']);
								}
							}
							
							/* radar setting entry */
							if($i_newid)
							{								
								$info_very = array();
								$info_very['i_user_id'] = $i_newid; 
								$info_very['i_verification_type'] = 3; 
								$info_very['i_created_on'] = time(); 
								$info_very['i_verifcation_status'] = 3; 
								$table = $this->db->TRADESMAN_VERIFICATION;
								$this->mod_trades->set_data_insert($table,$info_very);									
													
								/* Remove fconnnect session */								
								$this->session->unset_userdata('fconnet_user_detals');
								
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
				  // pr($info);
				   $content = $this->mod_auto->fetch_contact_us_content('registration_mail','general');	
				   $mail_subject = $content['s_subject'];	
				   
				   $filename = $this->config->item('EMAILBODYHTML')."common.html";
				   $handle = @fopen($filename, "r");
				   $mail_html = @fread($handle, filesize($filename));				
					//print_r($content); exit;
					if(!empty($content))
						{							
							$description = $content["s_content"];
							$description = str_replace("[User name]",$info['s_name'],$description);	
							$description = str_replace("[User username]",$info['s_username'],$description);	
							$description = str_replace("[User email address]",$info['s_email'],$description);		
							$description = str_replace("[User password]",$info['s_password'],$description); 
							$description = str_replace("[Click here to verify and activate your account now]",'<a href="'.base_url().'user/active_account'.'/'.$s_verification_code.'/'.$param.'">Click here to verify and activate your account now</a>',$description); 
							//$description = str_replace("[link_url]",base_url().'user/active_account'.'/'.$s_verification_code.'/'.$param,$description); 
							$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
						}
					unset($content);
						
					//echo "<br>DESC".$description;	exit;
					$mail_html = str_replace("[site url]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					
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
                    
                    $this->email->subject($mail_subject);
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
				   //echo '====='.$i_newid;exit;
                   if($i_nwid)////saved successfully
                    {
                        if($arr_upload_res[0]==='ok')
						{
							get_image_thumb($this->uploaddir.$info["s_image"], $this->thumbdir, 'thumb_'.$info["s_image"],$this->nw_heightt,$this->nw_width,'');
							get_image_thumb($this->uploaddir.$info["s_image"], $this->thumbdir, 'thumb_slider_'.$info["s_image"],250,350,'');
						}
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_reg"],'message_type'=>'succ'));
						
						if($this->session->userdata('s_referred_code')!='')  // if the user referred by others
						{
						
							$this->load->model('recommend_model','mod_recomm');
							$info	=	array();
							$info['i_is_active']	=	1;
							$i_updated = $this->mod_recomm->update_status($info,$this->session->userdata('s_referred_code'));
							$this->session->unset_userdata('s_referred_code');
						}
						
                       if($type==2 && $this->data['site_setting']['i_subscrption_status']==1)
					   {
					   		redirect($this->pathtoclass."subscription/".encrypt($i_newid)."/user");
						 	exit;
					   }	
                       else
					   {
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
								 redirect($this->pathtoclass."success_registration");
							}
					   		redirect($this->pathtoclass."success_registration");
							exit;
					    }	
                        
                    }
                    else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    
                }
            
			}
			
			
			

			$arr_reg_value = $this->session->userdata('arr_reg_value');
			if(!empty($fconnet_user_detals) && !$arr_reg_value)
			{
				$posted=array();
				$posted["txt_username"]		= 	$fconnet_user_detals['username'];
                $posted["txt_name"]			= 	$fconnet_user_detals['first_name'].' '.$fconnet_user_detals['last_name'];
				$posted["txt_email"]		= 	$fconnet_user_detals['email'];
				$posted["txt_con_email"]	= 	$fconnet_user_detals['email'];
				$posted["txt_dob"]			= 	$fconnet_user_detals['birthday'];
				
				$this->data["posted"]		= 	$posted;
				//$this->session->set_userdata('fconnet_user_detals','');
			}
			else
			{
				$this->data['posted'] = $arr_reg_value;
				$this->session->unset_userdata('arr_reg_value');
			}	
			
			if($this->data['site_setting']['i_subscrption_status']==1)
				$this->data['chk_subscrption_status'] = 1;
				
			


				
			// load the view 
			if($type==1)
			{		
				$this->s_meta_type = 'signup';		
				$this->render('user/client_registration');
			}
			else if($type==2)
			{
				$this->s_meta_type = 'signup_professional';
				$this->render('user/professional_registration');
			}
			
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	/////////// To show the terms and condition and private policy in fancy box/////////////
	function show_cms_lightbox($i_cms_id)
	{
		try
		{
		
			$this->load->model('content_model','mod_cont');			
			$s_where = " WHERE c.i_cms_type_id=".decrypt($i_cms_id)." And c.i_status=1 ";
			$data_exist = $this->mod_cont->fetch_multi($s_where);
			if(!empty($data_exist))
			{
			$this->data["contents"] = $data_exist;
			}
			
			$title = explode(' ',$this->data['contents'][0]["s_title"],2);
			$this->data["title_pre"] = $title[0];
			$this->data["title_next"] = $title[1];
		
			$this->load->view('fe/user/show_cms_lightbox.tpl.php',$this->data);
		
			unset($data_exist ,$s_where,$i_cms_id,$title);
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
			$s_wh_username	=	" WHERE n.s_username='".get_formatted_string($s_username)."' ";
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
	
	function check_mobile_no()
	{
		$s_contact = $this->input->post('s_contact');
		if(!preg_match('/^(?:\?0?7[]?)?\(?([0-9]{9})\)$/', $s_contact)) 
			echo 'error_pattern';
		else
		{	
			if(preg_match('/^(?:\?0?7[]?)?\(?([0-9]{9})\)$/', $s_contact))
			echo 0;
		}			
	}	
	
	
	public function success_registration()
	{	
	
		$this->data['breadcrumb'] = array('Confirmation Page'=>'');	
		$this->render();
	}
    public function success_client_registration()
    {    
      
        $this->data['breadcrumb'] = array('Confirmation Page'=>'');    
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
				$funRes2 = $this->mod_trades->active_account($activation_code);
			}
			if(decrypt($user_type)==1)
			{
				$funRes = $this->mod_rect->active_account($activation_code);
				//$this->session->set_userdata(array('message'=>$this->cls_msg["valid_account"],'message_type'=>'succ'));
				//redirect(base_url().'user/login');
			}
			if($funRes)
			{
				$this->session->set_userdata(array('message'=>$this->cls_msg["valid_account"],'message_type'=>'succ'));
				redirect(base_url().'user/login');
			}
			else if($funRes2)
			{
				$this->session->set_userdata(array('message'=>$this->cls_msg["valid_account_trades"],'message_type'=>'succ'));
				redirect(base_url().'user/login');
			}
			else
			{
				$this->session->set_userdata(array('message'=>$this->cls_msg["invalid_account"],'message_type'=>'err'));
				redirect(base_url().'user/login');
			}
			$this->render();
			
        }
		
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	 	    
    
	}	
	
	
	public function login()
	{
	
        try
        {
           if(!empty($this->data['loggedin']))
		   {
				redirect(base_url()."user/dashboard");
				exit;
			}

			$this->data['breadcrumb'] = array('Login'=>'');	
			$this->load->helper('cookie');
			if($_POST)
			{				

                $posted=array();

                $posted["txt_user_name"]= trim($this->input->post("txt_user_name"));
                $posted["txt_password"]= trim($this->input->post("txt_password"));
                
                $this->form_validation->set_rules('txt_user_name', 'provide user name or email', 'required');
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
						
						//var_dump($_POST);   exit;
                        /*** keep me logged in****/
						$chk_remember_me	=	$this->input->post('chk_remember_me');
                        
						if(!empty($chk_remember_me))
						{							   
								set_cookie('User', $info["s_user_name"], time()+(60*60*24*365), '', '/', '');
								set_cookie('pass', $info["s_password"], time()+(60*60*24*365), '', '/', '');
						}
                       //var_dump($_COOKIE);   exit;
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
						
                     ///////////REDIRECT IN SUCCESS////////////////   
                        
                    /**********************************/
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
                        //set_error_msg($this->cls_msg["invalid_login"]);
						$this->session->set_userdata(array('message'=>$this->cls_msg["invalid_login"],'message_type'=>'err'));
                        $this->data["posted"]=$posted; 
						redirect(base_url().'user/login');
                    }

                }
			}
			
		   unset($loggedin);
		   $this->render("user/login"); 
		   
		   
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
			$this->data['breadcrumb'] = array('Forget Password'=>'');
			
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
				             
                
				$this->form_validation->set_rules('txt_user_name', 'provide username', 'required'); 
				$this->form_validation->set_rules('txt_email', ' provide email', 'required');               
			 
              
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
						$mail_subject = $info['s_subject'];
						$filename = $this->config->item('EMAILBODYHTML')."common.html";
				   		$handle = @fopen($filename, "r");
				   		$mail_html = @fread($handle, filesize($filename));
						
							if(!empty($info))
							{			
							
								$description = $info["s_content"];								
								$description = str_replace("[User name]",$user_detail['s_name'],$description);	// Changine USER FULLNAME
								$description = str_replace("[User username]",$user_detail["s_username"],$description);	// Changine MAIL SENDER NAME	
								$description = str_replace("[new password]",$org_changed_pass,$description); // Changine PASSWORD
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
												
						$this->email->subject($mail_subject);
						
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
	
	function buyer_profile($i_buyer_id)
	{
		$i_buyer_id =  decrypt($i_buyer_id);
		$this->load->model('manage_buyers_model');
		
		ob_start();				
		//$id = $this->data['loggedin']['user_id'];				  
		$this->feedback_receive_pagination_ajax($i_buyer_id,0,1);
		$contents = ob_get_contents();
		ob_end_clean();
		//pr($contents);
		//exit;
/*				$this->load->model('tradesman_model');
		$info = $this->tradesman_model->fetch_this(decrypt($id));
		$this->data['profile_info'] = $info;
*/		
		$this->data['feedback_contents'] = $contents;			
		
		$this->data['buyer_details'] = $this->manage_buyers_model->fetch_this($i_buyer_id);
				
		$this->load->view('fe/user/buyer_profile.tpl.php',$this->data);		
	}
	
	
	public function feedback_receive_pagination_ajax($s_id,$start=0,$param=0) 
	{
		$limit	= $this->i_fe_page_limit=2;
	//	$limit = 2;
		$this->load->model("Manage_feedback_model","mod_feed");
		$s_where = " WHERE n.i_receiver_user_id = ".$s_id." AND n.i_status !=0 AND n.i_feedback_complete_status=1";
		$feedback = $this->mod_feed->fetch_multi($s_where,intval($start),$limit);
		//echo $this->db->last_query();
		$total_rows = $this->mod_feed->gettotal_info($s_where);	
		
		
		$this->data['feedback_list'] = $feedback;
		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'user/feedback_receive_pagination_ajax/'.$s_id.'/';		
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
	
		$config['div'] = '#feedback_list';
		//$config['js_bind'] = "showLoading();";
		//$config['js_rebind'] = "hideLoading();";
		//$config['js_rebind'] = "alert(data);";

		$this->jquery_pagination->initialize($config);
		//$this->data['page_links'] = preg_replace('/<delete>.*?<\/delete>/s','',$this->jquery_pagination->create_links());
		$this->data['page_links'] = $this->jquery_pagination->create_links();
		$this->data['total_rows'] = $total_rows;
		//$this->data['current_page'] = $page;
		
		$job_vw = $this->load->view('fe/user/ajax_buyer_feedback_list.tpl.php',$this->data,TRUE);
		
		echo $job_vw;		
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
	
    /**
    * This is CALLBACK function for checking date of birth greater than 18 or not
    * if it return FALSE to shows form validation error
    * @param string $txt_dob
    * @return bool TRUE OR FALSE
    */
    public function check_dob($txt_dob)
    {
        try
        {
            $i_dob=convert_date_mdy_format($txt_dob);   ////////This function written in helper.php
            if($i_dob > strtotime('-18 years'))
                    {
                        $this->form_validation->set_message('check_dob', '%s greater than 18 years.');
                        unset($i_dob); 
                        return FALSE;   
                    }
            unset($i_dob); 
            return TRUE;   
            //return FALSE;     
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
        
    }
    /**
    * This is AJAX function for checking date of birth greater than 18 or not
    * if it echo FALSE error to show form validation error client  side
    * @param string $txt_dob
    * 
    */
    function ajax_check_dob()
    {
        try
        {
            $i_dob=convert_date_mdy_format($this->input->post("s_dob"));    ////////This function written in helper.php     
            if($i_dob > strtotime('-18 years'))
                    {
                        echo 'error';  
                    } 
            unset($i_dob);      
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    /**
    * This is a AJAX function check user exist and its status
    * 
    */
    function ajax_check_login_status()
    {
        try
        {
            $s_username = trim($this->input->post('s_username'));
           
            //$s_where    =    " WHERE n.s_username='".get_formatted_string($s_username)."' ";
			$s_where    =    " WHERE n.s_username='".get_formatted_string($s_username)."' OR s_email='".get_formatted_string($s_username)."' ";
            $is_username_exist  =   $this->mod_rect->gettotal_info($s_where);    

            if($is_username_exist!=1)
            {
                echo 'error_user_exist';
            }
          /*  else
            {
                 $s_where.= " AND n.i_is_active=0 ";
                 $is_username_exist =   $this->mod_rect->gettotal_info($s_where);
				
                 if($is_username_exist)
                 {
                     echo 'error_user_active';
                 }
            }*/
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }      
                   
    }
	
	
	
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
	
	
	function subscription($i_user_id='',$page='')
	{		
		$i_user_id = ($i_user_id) ? decrypt($i_user_id) : decrypt($this->data['loggedin']['user_id']);
		$page = ($page) ? $page : 'renew';
		$this->data['i_user_id'] = $i_user_id;
		$this->data['page'] 	 = $page;
		
		if(empty($i_user_id))
		{
			redirect(base_url().'user/login');
		}
		if($_POST)
		{			
			include BASEPATH.'application/libraries/paypal_pro/CallerService'.EXT;
			
			$this->load->model('manage_tradesman_model');
			$user_deatils = $this->manage_tradesman_model->fetch_this($i_user_id);
			//pr($user_deatils);
			//exit;
			$txt_credit_card_number	 	= 	trim($this->input->post("txt_credit_card_number"));
			$opd_card_type 			 	= 	trim($this->input->post("opd_card_type"));
			$txt_card_verification_no   = 	trim($this->input->post("txt_card_verification_no"));
			$opd_card_type 				= 	trim($this->input->post("opd_card_type"));
			$exp_month 					=	trim($this->input->post("opd_exp_month"));
			$exp_year 					=	trim($this->input->post("opd_exp_year"));
			
			$callerserviceCard = new CallerService();
		
			$paymentType		= 'Sale';
			$firstName 			= urlencode($user_deatils['s_name']);
			$lastName 			= urlencode('');
			$creditCardType 	= urlencode($opd_card_type);
			$creditCardNumber 	= urlencode($txt_credit_card_number	);
			$expDateMonth 		= urlencode($exp_month);
		
			// Month must be padded with leading zero
		
			$padDateMonth 		= str_pad($expDateMonth, 2, '0', STR_PAD_LEFT); 
			$expDateYear 		= urlencode($exp_year);
			$cvv2Number 		= urlencode($txt_card_verification_no);
			$address1 			= urlencode($user_deatils['s_address']);
			//$address2 			= urlencode('bbbb');
			$city 				= urlencode($user_deatils['s_city_name']);
			$state				= urlencode($user_deatils['s_state']);
			$zip 				= urlencode($user_deatils['s_postal_code']);
			$amount 			= $this->data['site_setting']['d_subscription_amt'];
			$customercountry 	= 'GB';//urlencode($this->input->post('customercountry'));
			$currencyCode		= 'GBP';
			/* Construct the request string that will be sent to PayPal.
	
			The variable $nvpstr contains all the variables and is a
	
			name value pair string with & as a delimiter */
			$nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".$padDateMonth.$expDateYear."&CVV2=$cvv2Number&CURRENCYCODE=$currencyCode";
				
			/* Make the API call to PayPal, using API signature.
	
			The API response is stored in an associative array called $resArray */
	
			$resArray = $callerserviceCard->hash_call("doDirectPayment",$nvpstr);
			
			/* Display the API response back to the browser.
	
			If the response from PayPal was a success, display the response parameters'
	
			If the response was an error, display the errors received using APIError.php.
	
			*/
	
			$ack = strtoupper($resArray["ACK"]);
			//var_dump($ack);
	
			if($ack=="SUCCESS")
			{
			
				$this->load->model('tradesman_model');
		  		$profile_info = $this->tradesman_model->fetch_this($i_user_id);			
				$exp_date = (time()>$profile_info['i_account_expire_date']) ? strtotime("+365 day") : strtotime ( '+365 day' , $profile_info['i_account_expire_date'] ) ;
				
			
				$this->load->model('job_model');
				
				$info = array();
				$info['i_account_expire_date'] = $exp_date; 
				$table = $this->db->USERMANAGE;				
				$i_newid = $this->job_model->set_data_update($table,$info,$i_user_id);
				
				$info = array();
				$info['i_user_id'] = $i_user_id; 
				$info['d_amt'] 	= $resArray['AMT']; 
				$info['s_transaction_id'] = $resArray['TRANSACTIONID']; 				
				$info['i_created_on'] = time(); 				
				$table = $this->db->SUBSCRIPTION_PAYMENT;				
				$i_newid = $this->job_model->set_data_insert($table,$info,$i_user_id);
				
				$invoice_no = 10000+intval($i_newid);
				$inv['s_invoice_no'] = $invoice_no;
				$cond = array('id'=>$i_newid);
				$table = $this->db->SUBSCRIPTION_PAYMENT;
				$i_newid = $this->job_model->set_data_update($table,$inv,$cond);	
				
				
				/* Mail and invoice*/
				
				//$customer_name 	= $user_deatils['s_username'];
				$customer_name 	= $user_deatils['s_business_name'];
				$address 		= $user_deatils['s_address'];
				$state 			= $user_deatils['s_state'];
				$city 			= $user_deatils['s_city_name'];
				$postal 		= $user_deatils['s_postal_code'];
				$payment_date	= date("d/m/Y");
				$start_date 	= date("d/m/Y");
				$end_date 	 	= date("d/m/Y", $exp_date);
				
				
				$job_cost 		= $resArray['AMT']; 
				$paid_amount	= number_format($job_cost, 2, '.', '');
				//echo 'aa';
				//exit;
				
				$paid_amount_word = convert_number($paid_amount);
				//$paid_amount_word=$currency_object ->get_bd_amount_in_text($info[0]['s_paid_amount']);				
			   
				$logo_path = BASEPATH.'../images/fe/logo.png';
				$right_image_path = BASEPATH.'../images/fe/grey_up.png';
				$left_image_path = BASEPATH.'../images/fe/grey_down.png';
				
				
				$html_n = '<html>
							<head>
							<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
							<title>JobShoppa.com</title>
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
										<td style="border-bottom:1px solid #bfbfbf;border-top:1px solid #bfbfbf; text-transform:uppercase; font-size:16px; font-family:myriad Pro, arial;" align="right"><p style="padding:7px 12px; margin:0px;"><strong>INVOICE NO :</strong> <span style="color:#f87d33;"><strong>'.$invoice_no.'</strong></span></p></td>
								  </tr>
								  <tr>
										<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														  <td width="57%" style="padding:12px ;color:#616161;"><span style="color:#000;"><strong>'.$customer_name.'</strong></span><br />
																'.$address .',<br />
																'.$state.', '.$city.',<br />
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
																			<td width="16%" style="border-bottom:1px solid #b5b5b5;font-size:14px; text-transform:uppercase;padding:0px 12px 12px;"><strong>Amount(s)</strong></td>
																	  </tr>
																	  <tr>
																			<td style="border-bottom:1px solid #b5b5b5; padding:8px;" height="80"   align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="4">
																						<tr>
																							  <td> Membership Subscription for the period   '.$start_date.' - '.$end_date.'</td>
																							 
																						</tr>
																				  </table></td>
																			<td style="border-bottom:1px solid #b5b5b5;border-left:1px solid #b5b5b5;padding:12px;" align="center" valign="top">&#163; '.$paid_amount.' </td>
																	  </tr>
																	  <tr>
																			<td style="border-bottom:1px solid #b5b5b5; font-size:14px;padding:12px 12px;"  align="right" valign="top"> Net Payable Amount</span> </td>
																			<td style="border-bottom:1px solid #b5b5b5;font-size:14px;color:#f87d33;border-left:1px solid #b5b5b5;padding:12px 12px;" align="center" valign="top"><strong> &#163; '.$paid_amount.' </strong> </td>
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
										<td colspan="2" style=" color:#aaa; padding-top:10px; font-size:11px; text-align:center; font-family:Georgia, Times New Roman, Times, serif; ">Waterway Enterprise Ltd, 19 Waterloo Crescent, Wigston, Leicester, LE183QJ, UK
											  <p style="padding:0px; margin:0px; color:#666">Registration Number: 7521953</p></td>
								  </tr>
								  <tr>
										<td colspan="2" style=" color:#09c7e4; padding-top:5px; font-size:11px; text-align:center; font-family:Georgia, Times New Roman, Times, serif; "><em><strong>JobShoppa.com</strong></em></td>
								  </tr>
							</table>
							</body>
							</html>';       
					
		
			   $this->load->plugin('to_mailpdf');
			   $ffname = 'invoice_'.time();
			   pdf_create($html_n, $ffname);
			  
			   $attachment_pdf  = $this->config->item('ATTACHMENT_PDF_PATH').$ffname.'.pdf';
					
					/* end generating invoice */		
					
			
				   /* for job quote mail to the user */

			   $this->load->model('auto_mail_model');
			   $content = $this->auto_mail_model->fetch_contact_us_content('tradesman_payment_subscription','tradesman');	
			   
				$filename = $this->config->item('EMAILBODYHTML')."common.html";
				$handle = @fopen($filename, "r");
				$mail_html = @fread($handle, filesize($filename));				
				//print_r($content); exit;[invoice no.]
				if(!empty($content))
				{
					$description = $content["s_content"];
					$description = str_replace("[service professional name]",$user_deatils['s_username'],$description);
					$description = str_replace("[amount]",$resArray['AMT'],$description);	
					$description = str_replace("[invoice no]",$invoice_no,$description);	
					$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
				}
				//unset($content);
				
				$mail_html = str_replace("[site url]",base_url(),$mail_html);	
				$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
				//echo $tradesman_details['s_email'];
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
								
				$this->email->to($user_deatils['s_email']);
				
				$this->email->subject($content['s_subject']);
				unset($content);
				$this->email->message($mail_html);
				
				$this->email->attach($attachment_pdf);
				//echo $user_deatils['s_email']; exit;
				if(SITE_FOR_LIVE)///For live site
				{				
					$i_nwid = $this->email->send();	
															
				}
				else{
					$i_nwid = TRUE;				
				}				
					
				/* end of mail and invoice*/
				
				if($page=='user')
				{
					redirect($this->pathtoclass."success_registration");
				}
				else
				{
					$this->session->set_userdata(array('message'=>'Your payment has been done successfully.','message_type'=>'succ'));
					redirect(base_url().'home/message');
				}	
					
			}
			else
			{
				$this->session->set_userdata(array('message'=>$resArray["L_LONGMESSAGE0"],'message_type'=>'err'));
				redirect(base_url().'home/message');
			}	
		}
		$this->data['amt_to_paid'] = $this->data['site_setting']['d_subscription_amt'];
		
		$this->render();
		
	}	
	
	function paypal_payment($i_user_id='',$page='')
	{
	
		if(empty($i_user_id))
		{
			redirect(base_url().'user/login');
		}
	
		$environment = EXPRESS_CHECKOUT_ENV;
		
		$paymentAmount = urlencode($this->data['site_setting']['d_subscription_amt']);
		$currencyID = urlencode('GBP');							// or other currency code ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
		$paymentType = urlencode('Sale');				// or 'Sale' or 'Order'
		
		$returnURL = urlencode(base_url()."user/sucess_payment/".$i_user_id."/".$page);
		$cancelURL = urlencode(base_url()."user/cancel_payment");
		
		// Add request-specific fields to the request string.
		$nvpStr = "&Amt=$paymentAmount&ReturnUrl=$returnURL&CANCELURL=$cancelURL&PAYMENTACTION=$paymentType&CURRENCYCODE=$currencyID";
		
		// Execute the API operation; see the PPHttpPost function above.
		$httpParsedResponseAr = PPHttpPost('SetExpressCheckout', $nvpStr);
		
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
			// Redirect to paypal.com.
			$token = urldecode($httpParsedResponseAr["TOKEN"]);
			$payPalURL = "https://www.paypal.com/webscr&cmd=_express-checkout&token=$token";
			if("sandbox" === $environment || "beta-sandbox" === $environment) {
				$payPalURL = "https://www.$environment.paypal.com/webscr&cmd=_express-checkout&token=$token";
			}
			header("Location: $payPalURL");
			exit;
		} else  {
			exit('SetExpressCheckout failed: ' . print_r($httpParsedResponseAr, true));
		}	
	
	}
	
	
	function sucess_payment($i_user_id='',$page='')
	{		
		// Set request-specific fields.		
		$token = urlencode(htmlspecialchars($_REQUEST['token']));
		$payerID = urlencode(htmlspecialchars($_REQUEST['PayerID']));		
		
		$paymentType = urlencode("Sale");			// or 'Sale' or 'Order'
		$paymentAmount = urlencode($this->data['site_setting']['d_subscription_amt']);
		$currencyID = urlencode("GBP");						// or other currency code ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
		
		// Add request-specific fields to the request string.
		$nvpStr = "&TOKEN=$token&PAYERID=$payerID&PAYMENTACTION=$paymentType&AMT=$paymentAmount&CURRENCYCODE=$currencyID";
		
		// Execute the API operation; see the PPHttpPost function above.
		$httpParsedResponseAr = PPHttpPost('DoExpressCheckoutPayment', $nvpStr);
		
		
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
			
			
			$sub_amt = urldecode($httpParsedResponseAr['AMT']);
			
			
			$this->load->model('manage_tradesman_model');
			$user_deatils = $this->manage_tradesman_model->fetch_this($i_user_id);
			
			$this->load->model('tradesman_model');
			$profile_info = $this->tradesman_model->fetch_this($i_user_id);			
			$exp_date = (time()>$profile_info['i_account_expire_date']) ? strtotime("+365 day") : strtotime ( '+365 day' , $profile_info['i_account_expire_date'] ) ;
			
		
			$this->load->model('job_model');
			
			$info = array();
			$info['i_account_expire_date'] = $exp_date; 
			$table = $this->db->USERMANAGE;				
			$i_newid = $this->job_model->set_data_update($table,$info,$i_user_id);
			
			$info = array();
			$info['i_user_id'] = $i_user_id; 
			$info['d_amt'] 	= $sub_amt; 
			$info['s_transaction_id'] = $httpParsedResponseAr['TRANSACTIONID']; 				
			$info['i_created_on'] = time(); 				
			$table = $this->db->SUBSCRIPTION_PAYMENT;				
			$i_newid = $this->job_model->set_data_insert($table,$info,$i_user_id);
			
			$invoice_no = 10000+intval($i_newid);
			$inv['s_invoice_no'] = $invoice_no;
			$cond = array('id'=>$i_newid);
			$table = $this->db->SUBSCRIPTION_PAYMENT;
			$i_newid = $this->job_model->set_data_update($table,$inv,$cond);	
			
			
			/* Mail and invoice*/
			
			//$customer_name 	= $user_deatils['s_username'];
			$customer_name 	= $user_deatils['s_business_name'];
			$address 		= $user_deatils['s_address'];
			$state 			= $user_deatils['s_state'];
			$city 			= $user_deatils['s_city_name'];
			$postal 		= $user_deatils['s_postal_code'];
			$payment_date	= date("d/m/Y");
			$start_date 	= date("d/m/Y");
			$end_date 	 	= date("d/m/Y", $exp_date);
			
			
			$job_cost 		= $sub_amt; 
			$paid_amount	= number_format($job_cost, 2, '.', '');
			//echo 'aa';
			//exit;
			
			$paid_amount_word = convert_number($paid_amount);
			//$paid_amount_word=$currency_object ->get_bd_amount_in_text($info[0]['s_paid_amount']);				
		   
			$logo_path = BASEPATH.'../images/fe/logo.png';
			$right_image_path = BASEPATH.'../images/fe/grey_up.png';
			$left_image_path = BASEPATH.'../images/fe/grey_down.png';
			
			
			$html_n = '<html>
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
						<title>JobShoppa.com</title>
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
									<td style="border-bottom:1px solid #bfbfbf;border-top:1px solid #bfbfbf; text-transform:uppercase; font-size:16px; font-family:myriad Pro, arial;" align="right"><p style="padding:7px 12px; margin:0px;"><strong>INVOICE NO :</strong> <span style="color:#f87d33;"><strong>'.$invoice_no.'</strong></span></p></td>
							  </tr>
							  <tr>
									<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													  <td width="57%" style="padding:12px ;color:#616161;"><span style="color:#000;"><strong>'.$customer_name.'</strong></span><br />
															'.$address .',<br />
															'.$state.', '.$city.',<br />
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
																		<td width="16%" style="border-bottom:1px solid #b5b5b5;font-size:14px; text-transform:uppercase;padding:0px 12px 12px;"><strong>Amount(s)</strong></td>
																  </tr>
																  <tr>
																		<td style="border-bottom:1px solid #b5b5b5; padding:8px;" height="80"   align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="4">
																					<tr>
																						  <td> Membership Subscription for the period   '.$start_date.' - '.$end_date.'</td>
																						 
																					</tr>
																			  </table></td>
																		<td style="border-bottom:1px solid #b5b5b5;border-left:1px solid #b5b5b5;padding:12px;" align="center" valign="top">&#163; '.$paid_amount.' </td>
																  </tr>
																  <tr>
																		<td style="border-bottom:1px solid #b5b5b5; font-size:14px;padding:12px 12px;"  align="right" valign="top"> Net Payable Amount</span> </td>
																		<td style="border-bottom:1px solid #b5b5b5;font-size:14px;color:#f87d33;border-left:1px solid #b5b5b5;padding:12px 12px;" align="center" valign="top"><strong>&#163; '.$paid_amount.' </strong> </td>
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
									<td colspan="2" style=" color:#aaa; padding-top:10px; font-size:11px; text-align:center; font-family:Georgia, Times New Roman, Times, serif; ">Waterway Enterprise Ltd, 19 Waterloo Crescent, Wigston, Leicester, LE183QJ, UK
										  <p style="padding:0px; margin:0px; color:#666">Registration Number: 7521953</p></td>
							  </tr>
							  <tr>
									<td colspan="2" style=" color:#09c7e4; padding-top:5px; font-size:11px; text-align:center; font-family:Georgia, Times New Roman, Times, serif; "><em><strong>JobShoppa.com</strong></em></td>
							  </tr>
						</table>
						</body>
						</html>';       
				
	
		   $this->load->plugin('to_mailpdf');
		   $ffname = 'invoice_'.time();
		   pdf_create($html_n, $ffname);
		  
		   $attachment_pdf  = $this->config->item('ATTACHMENT_PDF_PATH').$ffname.'.pdf';
				
				/* end generating invoice */		
				
		
			   /* for job quote mail to the user */

		   $this->load->model('auto_mail_model');
		   $content = $this->auto_mail_model->fetch_contact_us_content('tradesman_payment_subscription','tradesman');	
		   
			$filename = $this->config->item('EMAILBODYHTML')."common.html";
			$handle = @fopen($filename, "r");
			$mail_html = @fread($handle, filesize($filename));				
			//print_r($content); exit;[invoice no.]
			if(!empty($content))
			{
				$description = $content["s_content"];
				$description = str_replace("[service professional name]",$user_deatils['s_username'],$description);
				$description = str_replace("[amount]",$sub_amt,$description);	
				$description = str_replace("[invoice no]",$invoice_no,$description);	
				$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
			}
			//unset($content);
			
			$mail_html = str_replace("[site url]",base_url(),$mail_html);	
			$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
			//echo $tradesman_details['s_email'];
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
							
			$this->email->to($user_deatils['s_email']);
			
			$this->email->subject($content['s_subject']);
			unset($content);
			$this->email->message($mail_html);
			
			$this->email->attach($attachment_pdf);
			//echo $user_deatils['s_email']; exit;
			if(SITE_FOR_LIVE)///For live site
			{				
				$i_nwid = $this->email->send();	
														
			}
			else{
				$i_nwid = TRUE;				
			}				
				
			/* end of mail and invoice*/
			
			if($page=='user')
			{
				redirect($this->pathtoclass."success_registration");
			}
			else
			{
				$this->session->set_userdata(array('message'=>'Your payment has been done successfully.','message_type'=>'succ'));
				redirect(base_url().'home/message');
			}	
				
			//exit('Express Checkout Payment Completed Successfully: '.print_r($httpParsedResponseAr, true));
		} else  {
			$this->session->set_userdata(array('message'=>'Your payment has not been done successfully.','message_type'=>'err'));
			redirect(base_url().'home/message');
			//exit('DoExpressCheckoutPayment failed: ' . print_r($httpParsedResponseAr, true));
		}		
		
	
	}	
	

	
	function cancel_payment($par='')
	{
		
		$this->session->set_userdata(array('message'=>'You have canceled your payment','message_type'=>'err'));
		redirect(base_url().'home/message');
	}
	
	
	
	
	
	
	
	function fconnect($access_token='')
	{	
		/*$cookie = get_facebook_cookie($this->data['facebook_app_id'], $this->data['facebook_sekret_key']);
		
		pr($cookie);
		exit;*/
		
		
		$this->data['breadcrumb'] = array('FConnect'=>'');
		$user = @json_decode(file_get_contents('https://graph.facebook.com/me?fields=name&access_token=' . $access_token));
		
		$qry = urlencode("SELECT uid,first_name,middle_name,last_name,name,pic_small,pic_big,pic_square,pic,affiliations,profile_update_time,				timezone,religion,birthday,birthday_date,sex,hometown_location,meeting_sex,meeting_for,relationship_status,				significant_other_id,political,current_location,activities,interests,is_app_user,music,tv,movies,books,quotes,				about_me,hs_info,education_history,work_history,notes_count,wall_count,status,has_added_app,online_presence,locale,				proxied_email,profile_url,email_hashes,pic_small_with_logo,pic_big_with_logo,pic_square_with_logo,pic_with_logo,
		allowed_restrictions,verified,profile_blurb,family,username,website,is_blocked,contact_email,email,third_party_id FROM user WHERE uid = me()");						
						
				
						//$qry = urlencode("SELECT page_id FROM page_fan WHERE uid = '$user->id' and page_id = '146283738777104'");
		$content = file_get_contents(
		'https://api.facebook.com/method/fql.query?query='.$qry.'&access_token='. $access_token .'&format=json');		
				
		$content = json_decode($content);	
		//var_dump($content);
		
		
		$this->load->model("User_login","mod_ul");  
        $info=array();
        $info["s_email"]	=  $content[0]->email;
		$loggedin = $this->mod_ul->facebook_login($info);
		if(!empty($loggedin))
		{
			$info['i_last_login_date'] = time();
			$i_nwid	=	$this->mod_ul->update_login_date($info,$loggedin['id']); // to update last login date
			$refferer_page = $this->session->userdata('login_redirect_url');						
			if ($refferer_page !='')
			{
				$this->session->unset_userdata('login_redirect_url');							
				redirect($refferer_page);
			}
			else if(isset($_SESSION['login_redirect_url'])&& !empty($_SESSION['login_redirect_url']))
			{
				$redirect_url   =   $_SESSION['login_redirect_url'];
				$this->session->unset_userdata('login_redirect_url');
				redirect($redirect_url);
			}
			else
				redirect(base_url()."user/dashboard/");

		}
		 
		
		$fconnet_user_detals['username'] 	= $content[0]->username;
		$fconnet_user_detals['email'] 	 	= $content[0]->email;
		$fconnet_user_detals['first_name']  = $content[0]->first_name;
		$fconnet_user_detals['last_name'] 	= $content[0]->last_name;
		$fconnet_user_detals['birthday'] 	= date("d/m/Y", strtotime($content[0]->birthday_date));
		
		$this->session->set_userdata('fconnet_user_detals',$fconnet_user_detals);
		
		$this->render();			
		
		
		
	}
	
	
		
    public function __destruct()
	{}           

}

