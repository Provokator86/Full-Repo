<?php
/*********
* Author: Koushik
* Email: koushik.r@acumencs.info
* Date  : 07 July 2012
* Modified By: 
* Modified Date: 
*
* This is account controller all function will be call
* if the user is loged in 
* If user is not loged in the page just redirected to the login page 
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class Account extends My_Controller
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public $loggedin ;
    public $user_image ;
    public function __construct()
    {
        try
        { 
          parent::__construct(); 
          $this->data['title']="Account";////Browser Title
          $this->data['ctrlr'] = "account";

          $this->cls_msg=array();
                   
          $this->cls_msg["edit_acc_succ"]           = "Account edited Successfully.";          
          $this->cls_msg["edit_acc_err"]            = "Account failed to edit.";  
		  $this->cls_msg["add_property_succ"]		= "Your place has been added successfully.";	
		  $this->cls_msg["save_pwd"]				= "password changed successfully";
		  $this->cls_msg["save_pwd_err"]			= "password changed could not saved";        
          $this->cls_msg["wrong_pwd"]				= "wrong old password given";
          $this->cls_msg["dashboard_succ"]          = "Account successfully updated.";
		  $this->cls_msg["dashboard_err"]			= "you can not deselect both check box.";
		 
		  
		  $this->cls_msg["save_review_succ"]		= "review has been posted successfully";
		  $this->cls_msg["save_review_err"]			= "review failed to post";
		  $this->cls_msg["review_err"]				= "review failed to save";
		  $this->cls_msg["exists_review"]			= "You have already posted a review.";
          $this->cls_msg["remove_review_succ"]      = "Review removed successfully.";
		  $this->cls_msg["review_time_err"]			= "You cannot post a review untill amount paid and your check out date is over";
          $this->cls_msg["message_send_succ"]       = "Message send successfully.";
		  $this->cls_msg["email_edited_succ"]		= "Your Email address has been edited successfully, Please activate your account.";
		  
          $this->loggedin     =   $this->data['loggedin'] ;
         
          if(empty($this->loggedin))
          {
              $this->session->set_userdata(array('message'=>$this->cls_msg["login_err"],'message_type'=>'err'));
              redirect(base_url().'user/login');
          }
          
          
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
          
          $this->load->model('user_model','mod_user');          
          $this->load->model('assets_model','mod_assets');
		  $this->load->model('property_model','mod_property');
		  $this->load->model('common_model','mod_common');
          
          $this->user_image		= $this->config->item('user_image');
		  $this->property_image	= $this->config->item('property_image');
		  $this->review_image		= $this->config->item('review_image');
		  $user_detail = $this->mod_user->fetch_this(decrypt($this->loggedin["user_id"]));
		  //pr($user_detail);
		  $this->data["i_am_owner"] 	= $user_detail["i_owner_checked"];
		  $this->data["i_am_traveler"] 	= $user_detail["i_traveler_checked"];
          
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
            //$this->s_meta_type = 'home';
            redirect(base_url().'dashboard');
            $this->render();
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
            $this->data['breadcrumb'] = array('Dashboard'=>'');
            // for highlighting account left menu in account section in account_left_menu.tpl.php
            $this->data['left_menu']  = 1;   
			$enc_user_id	=	$this->loggedin["user_id"];
			if($_POST)
			{
				$posted	= array();				
				$posted["h_str_type"]	= trim($this->input->post("h_str_type"),',');				
				$h_str	=	explode(',',$posted["h_str_type"]);
				
				$info	= array();
				if($h_str[0]=='')
				{
					$this->session->set_userdata(array('message'=>$this->cls_msg["dashboard_err"],'message_type'=>'err'));
                    redirect(base_url()."dashboard");
				}
				if($h_str[0]==1 && count($h_str)==1)
				{
					$info["i_traveler_checked"]	=	0;
					$info["i_owner_checked"]	=	1;
				}
				else if($h_str[0]==2 && count($h_str)==1)
				{
					$info["i_traveler_checked"]	=	1;
					$info["i_owner_checked"]	=	0;
				}
				else if($h_str[1]!='')
				{
					$info["i_traveler_checked"]	=	1;
					$info["i_owner_checked"]	=	1;
				}
				
				//pr($info,1);
				$arr_where = array('i_id'=>decrypt($enc_user_id));
				
				$s_table_name = $this->db->USER;
				$i_aff	=	$this->mod_common->common_edit_info($s_table_name,$info,$arr_where);
				if($i_aff)
				{
					$this->session->set_userdata(array('message'=>$this->cls_msg["dashboard_succ"],'message_type'=>'succ'));
                    redirect(base_url()."dashboard");
				}
				
			}
			
			$s_where = " WHERE p.i_owner_user_id = ".decrypt($enc_user_id)." AND b.e_status='Request sent' ";
			$request_for_book = $this->mod_property->fetch_booking_list($s_where,0,10);
			$this->data["property_booking"] = $request_for_book;
			//pr($request_for_book,1);
			
			$s_where = " WHERE b.i_traveler_user_id =".decrypt($enc_user_id)." AND b.e_status = 'Approve by user' ";
			$user_approved_travel = $this->mod_property->fetch_booking_list($s_where,0,10);
			$this->data["travel_booking"] = $user_approved_travel;
			//pr($user_approved_travel,1);
			
            $this->render();
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    public function manage_account()
    {
        try
        {
            $this->data['breadcrumb'] = array('Manage Account'=>'');
            // for highlighting account left menu in account section in account_left_menu.tpl.php
            $this->data['left_menu']  = 2;
            $enc_user_id    =   $this->loggedin['user_id'];
			
			$verified_facebook_adddress = $this->session->userdata('facebook_address_verified'); 
			// session data after click on verify link if verified
            $this->session->unset_userdata('facebook_address_verified');
            
            
            $verified_twitter_adddress = $this->session->userdata('twitter_address_verified'); 
            // session data after click on verify link if verified
            $this->session->unset_userdata('twitter_address_verified');
            
            $verified_linkedin_adddress = $this->session->userdata('linkedin_address_verified'); 
            // session data after click on verify link if verified
            $this->session->unset_userdata('linkedin_address_verified');
   
            if($_POST)
            {
              
              
                $posted     =   array();
                $posted["txt_first_name"]           =   $this->input->post("txt_first_name") ;
                $posted["txt_last_name"]            =   $this->input->post("txt_last_name") ;
                $posted["txt_email"]                =   $this->input->post("txt_email") ;
                $posted["txt_phone_number"]         =   $this->input->post("txt_phone_number") ;
                $posted["txt_facebook_address"]     =   $this->input->post("txt_facebook_address") ;
                $posted["txt_twitter_address"]      =   $this->input->post("txt_twitter_address") ;
                $posted["txt_linkedin_address"]     =   $this->input->post("txt_linkedin_address") ;
                $posted["ta_about_me"]              =   $this->input->post("ta_about_me") ;
                $posted["h_image"]                  =   $this->input->post("h_image") ;
                $posted["opt_country"]              =   $this->input->post("opt_country") ;
                $posted["opt_state"]                =   $this->input->post("opt_state") ;
                $posted["txt_city"]                 =   $this->input->post("txt_city") ;
                $posted["ta_address"]               =   $this->input->post("ta_address") ;
                $posted["ta_paypal"]                =   $this->input->post("ta_paypal") ;
                
                $this->form_validation->set_rules('txt_first_name','your first name', 'required|trim');
                $this->form_validation->set_rules('txt_last_name','your last name', 'required|trim');
                $this->form_validation->set_rules('txt_email','your email address', 'valid_email|required|trim|callback__email_exist');
                $this->form_validation->set_rules('txt_phone_number','phone number', 'required|trim');
                $this->form_validation->set_rules('opt_country','country', 'required|trim');
                $this->form_validation->set_rules('opt_state','state', 'required|trim');
                $this->form_validation->set_rules('txt_city','city', 'required|trim');
                $this->form_validation->set_rules('ta_address','address', 'required|trim');
               
                
                if(isset($_FILES['f_image']) && !empty($_FILES['f_image']['name']))
                {
                    $UploadDir            = $this->user_image['general']['upload_path'];
                    $newfile_name         = 'user_'.time().'.jpg';
                    $img_source           = $_FILES['f_image']['tmp_name'];
                    $file_upload_status   = upload_image_file($img_source,$UploadDir,$newfile_name);    
                    $file_to_deleted      = getFilenameWithoutExtension($posted['h_image']);   
                }
                
                
                 
                if($this->form_validation->run() == FALSE || $file_upload_status=='err') // validation false (error occur)
                {
                  
                    $this->data["posted"]   =   $posted ;
                }
                else
                {
                    $info   =   array();
                    $info["s_first_name"]       =    $posted["txt_first_name"] ;  
                    $info["s_last_name"]        =    $posted["txt_last_name"] ;  
                    $info["s_email"]            =    $posted["txt_email"] ;  
                    $info["s_phone_number"]     =    $posted["txt_phone_number"] ;  
                    $info["s_facebook_address"] =    $posted["txt_facebook_address"] ;  
                    $info["s_twitter_address"]  =    $posted["txt_twitter_address"] ;  
                    $info["s_linkedin_address"] =    $posted["txt_linkedin_address"] ;  
                    $info["s_about_me"]         =    $posted["ta_about_me"] ;
                    $info["i_country_id"]       =    decrypt($posted["opt_country"]) ;
                    $info["i_state_id"]         =    decrypt($posted["opt_state"]) ;
                    $info["s_city"]             =    $posted["txt_city"] ;
                    $info["s_address"]          =    $posted["ta_address"] ;
                    $info["s_paypal_details"]   =    $posted["ta_paypal"] ;
                    if($this->loggedin['user_email']!=$info["s_email"])
                    {
                        $info["i_status"]           =   0 ; 
                        $info["s_verification_code"]=    $this->mod_user->genVerificationCode(); 
                    }
                    /********************** CHECK FOR FACEBOOK ADDRESS VERIFIED OR NOT  ***********************/
					$user_detail     =   $this->mod_user->fetch_this(decrypt($enc_user_id));
					//if($user_detail["s_facebook_address"]!=$info["s_facebook_address"])					
					if($info['s_facebook_address']!='')
					{
					if($info["s_facebook_address"] == $verified_facebook_adddress)
					{
						$info["s_facebook_address"] 	= $verified_facebook_adddress;
						$info["i_facebook_verified"] 	= 1;
					}
					else if($info["s_facebook_address"] != $verified_facebook_adddress)
					{
						//echo $user_detail["s_facebook_address"].'--'.$info["s_facebook_address"];
						if($info["s_facebook_address"]==$user_detail["s_facebook_address"])
						{
						$info["s_facebook_address"] 	= $user_detail["s_facebook_address"];
						$info["i_facebook_verified"] 	= $user_detail["i_facebook_verified"];
						}
                        else
                        {
                            $info["i_facebook_verified"]     = 0;
                        }
					}
					}
                    else
                    {
                        $info["i_facebook_verified"]     = 0;
                    }

					//pr($info,1);
                    /********************** CHECK FOR FACEBOOK ADDRESS VERIFIED OR NOT  ***********************/
                    
                     /********************** START CHECK FOR TWITTER ADDRESS VERIFIED OR NOT  ***********************/
                    
                    if($info['s_twitter_address']!='')
                    {
                    if($info["s_twitter_address"] == $verified_twitter_adddress)
                    {
                        $info["s_twitter_address"]     = $verified_twitter_adddress;
                        $info["i_twitter_verified"]     = 1;
                    }
                    else if($info["s_twitter_address"] != $verified_twitter_adddress)
                    {
                        //echo $user_detail["s_facebook_address"].'--'.$info["s_facebook_address"];
                        if($info["s_twitter_address"]==$user_detail["s_twitter_address"])
                        {
                        $info["s_twitter_address"]     = $user_detail["s_twitter_address"];
                        $info["i_twitter_verified"]    = $user_detail["i_twitter_verified"];
                        }
                        else
                        {   
                             $info["i_twitter_verified"]    = 0;
                        }
                    }
                    }
                    else
                    {
                        $info["i_twitter_verified"]     = 0;
                    }
                    /********************** END CHECK FOR TWITTER ADDRESS VERIFIED OR NOT  ***********************/    
                    
                    /********************** START CHECK FOR LINKEDIN ADDRESS VERIFIED OR NOT  ***********************/
                    
                    if($info['s_linkedin_address']!='')
                    {
                    if($info["s_linkedin_address"] == $verified_linkedin_adddress)
                    {
                        $info["s_linkedin_address"]     = $verified_linkedin_adddress;
                        $info["i_linkedin_verified"]     = 1;
                    }
                    else if($info["s_linkedin_address"] != $verified_linkedin_adddress)
                    {
                        //echo $user_detail["s_facebook_address"].'--'.$info["s_facebook_address"];
                        if($info["s_linkedin_address"]==$user_detail["s_linkedin_address"])
                        {
                        $info["s_linkedin_address"]     = $user_detail["s_linkedin_address"];
                        $info["i_linkedin_verified"]     = $user_detail["i_linkedin_verified"];
                        }
                        else
                        {
                            $info["i_linkedin_verified"]     = 0;    
                        }
                    }
                    }
                    else
                    {
                        $info["i_linkedin_verified"]     = 0;
                    }
                    
                     /********************** END CHECK FOR TWITTER ADDRESS VERIFIED OR NOT  ***********************/   
                    
                    
                    if( $info["s_phone_number"]!=$user_detail["s_phone_number"])
                    {
                        $info["i_phone_verified"]   =   0 ; 
                    }
                    else
                    {
                        $info["i_phone_verified"]   =   $user_detail["i_phone_verified"] ;
                    }
                    
                    
					/********************** END CHECK FOR LINKEDIN ADDRESS VERIFIED OR NOT  ***********************/
                    
                    if($file_upload_status=='ok')
                    {
                        $info["s_image"]            =    $newfile_name ;
                    }
                    else
                    {
                        $info["s_image"]            =    $posted["h_image"] ; 
                    }

                     $i_aff     =   $this->mod_user->edit_info($info,decrypt($enc_user_id));

                if($i_aff)
                {
                   
                      if($newfile_name!='' && $file_upload_status=='ok' )
                        {
                            $wm_text    =   $this->config->item('wm_text') ;
                            $tmp_file            =    getFilenameWithoutExtension($newfile_name);
                            foreach($this->user_image as $key=>$val)
                            {
                                if($key!='general')
                                {
                                    $ThumbDir            = $val['upload_path'];
                                    $thumbfile           = $tmp_file.'_'.$key.'.jpg';
                                    $img_source          = $_FILES['f_image']['tmp_name'];
                                    $width               = $val['width'];
                                    $height              = $val['height'];
                                    $s_uploaded_file     = upload_image_file($img_source,$ThumbDir,$thumbfile,$height,$width);
									if($s_uploaded_file=='ok' && $val['wm_font_size'])
									{
										watermark_text_image_file($ThumbDir.$thumbfile,$wm_text,$val['wm_font_size'],'858585');
									}
                                }
                            }
                            $i_deleted  =   delete_images_from_system('user_image',$file_to_deleted);
                            
                           
                        }
                        
                         if($this->loggedin['user_email']!=$info["s_email"])
                        {
                            //if email edited then send a email to activate email id
                           $this->load->model("auto_mail_model","mod_auto");
                           $content         =   $this->mod_auto->fetch_mail_content('edit_accout');    
                           $filename        =   $this->config->item('EMAILBODYHTML')."common.html";
                           $handle          =   @fopen($filename, "r");
                           $mail_html       =   @fread($handle, filesize($filename));    
                           $s_subject       =   $content['s_subject'];        
                            //print_r($content); exit;    
                                            
                            if(!empty($content))
                            {                    
                                $description = $content["s_content"];
                                
                                $description = str_replace("###NAME###",ucfirst($info['s_first_name']).' '.ucfirst($info['s_last_name']),$description);    
                                $description = str_replace("###EMAIL###",$info['s_email'],$description);        
                                $description = str_replace("###VERIFY_LINK###",base_url().'user/active-account/'.$info["s_verification_code"],$description);                        
                            }
                                
                            $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);    
                            $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);    
                           
                            
                            /// Mailing code...[start]
                            $site_admin_email = $this->s_admin_email;    
                            $this->load->helper('mail');                                        
                            $i_sent = sendMail($info['s_email'],$s_subject,$mail_html);
                            /////////// End of sending email /////////////
                            if($i_sent)
                            {
                                $this->session->unset_userdata('loggedin');
                                $this->session->set_userdata(array('message'=>$this->cls_msg["email_edited_succ"],'message_type'=>'succ'));
                                redirect(base_url().'user/login');
                            }
                            
                        }
                        
                         $info_user =   $this->mod_user->fetch_this(decrypt($enc_user_id));
                         
                         $this->session->set_userdata(array(
                                                    "loggedin"=> array(
                                                    "user_id"=> encrypt(intval($info_user["id"])),
                                                
                                                    "user_first_name"=> $info_user["s_first_name"],
                                                    "user_last_name"=> $info_user["s_last_name"],
                                                    
                                                    "user_email"=> $info_user["s_email"],
                                                    "user_image"=> $info_user["s_image"],
                                                    "user_status"=> $info_user["s_status"])     
                          
                                                ));
                         
                        
                         $this->session->set_userdata(array('message'=>$this->cls_msg["edit_acc_succ"],'message_type'=>'succ'));
                         redirect(base_url()."manage-account");
                      }
                      else
                      {
                          $this->session->set_userdata(array('message'=>$this->cls_msg["edit_acc_err"],'message_type'=>'err'));
                          redirect(base_url()."manage-account");
                          
                      }  
                }
               
                
            }
            else
            {
                  $info     =   array();
                  $info     =   $this->mod_user->fetch_this(decrypt($enc_user_id));
                  
                  $posted["txt_first_name"]         =   $info['s_first_name'];   
                  $posted["txt_last_name"]          =   $info['s_last_name'];   
                  $posted["txt_email"]              =   $info['s_email'];   
                  $posted["txt_phone_number"]       =   $info['s_phone_number'];   
                  $posted["txt_facebook_address"]   =   $info['s_facebook_address'];   
                  $posted["txt_twitter_address"]    =   $info['s_twitter_address'];   
                  $posted["txt_linkedin_address"]   =   $info['s_linkedin_address'];   
                  $posted["ta_about_me"]            =   $info['s_about_me'];   
                  $posted["s_image"]                =   $info['s_image'];   
                  $posted["h_image"]                =   $info['s_image'];   
                  $posted["i_phone_verified"]       =   $info['i_phone_verified'];   
                  $posted["i_facebook_verified"]    =   $info['i_facebook_verified'];   
                  $posted["i_twitter_verified"]     =   $info['i_twitter_verified'];   
                  $posted["i_linkedin_verified"]    =   $info['i_linkedin_verified']; 
                  $posted["opt_country"]            =   ($info['i_country_id'])?encrypt($info['i_country_id']):''; 
                  $posted["opt_state"]              =   ($info['i_state_id'])?encrypt($info['i_state_id']):''; 
                  $posted["txt_city"]               =   $info['s_city']; 
                  $posted["ta_address"]             =   $info['s_address']; 
                  $posted["ta_paypal"]              =   $info['s_paypal_details']; 
                    
                  $posted["h_id"]                   =   $enc_user_id;   
                  $this->data["posted"]     =   $posted ; 
                 
            
            }
            
            
            $this->render('account/manage_account');
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	/* to delete profile image*/
	public function ajax_delete_image()
    {
        try
        {
            $posted					= array();
			$posted["id"]       	= decrypt($this->input->post("h_id"));
			$posted["image_name"]	= $this->input->post("file_name");
			//pr($posted,1);
			$image_to_delete		= getFilenameWithoutExtension($posted["image_name"]);
            
            
			
			$info 				= array();
			$info['s_image']   	= '';
			$arr_where          = array('i_id'=>$posted["id"]);
			$i_rect				= $this->mod_common->common_edit_info($this->db->USER,$info,$arr_where); /*don't change*/
			
			$i_deleted			= delete_images_from_system('user_image',$posted["image_name"]); // delete all images from system
			          
			if($i_rect)////saved successfully
			{
                $this->data['loggedin']['user_image']   =   '';
                $this->session->set_userdata('loggedin',$this->data['loggedin']) ;
				echo "ok";                
			}
			else///Not saved, show the form again
			{
				echo "error" ;
			}
			
			unset($info,$i_rect);
              
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
			$this->data['breadcrumb'] = array('Change Password'=>'');
			$this->s_meta_type = 'change_password';
			$this->data['left_menu']	=	2;
			$s_email	=	$this->data["loggedin"]['user_email'];
			$user_id	=	$this->data["loggedin"]['user_id'];
			$user_detail=	$this->mod_user->fetch_this(decrypt($user_id));
			//pr($user_detail,1);
			if($user_detail["s_password"]!='')
			{
				$this->data["old_pwd_flag"] = 1;
			}
			
            if($_POST)
            {
                $posted=array();
				$posted["txt_old_password"]		= trim($this->input->post("txt_old_password"));
				$posted["txt_new_password"]		= trim($this->input->post("txt_new_password"));
				$posted["txt_confirm_password"]	= trim($this->input->post("txt_confirm_password"));
				
				if(!empty($posted["txt_new_password"]) || !empty($posted["txt_confirm_password"]))
				{
					$this->form_validation->set_rules('txt_new_password', 'New password', 'required');
					$this->form_validation->set_rules('txt_confirm_password', 'Confirm password', 'required|matches[txt_new_password]');
				}
				if($this->data["old_pwd_flag"]==1)
				{
					$this->form_validation->set_rules('txt_old_password', 'Old password', 'required');
				}
                
                if($this->form_validation->run() == FALSE) // validation false (error occur)
                {
                    $this->data["posted"]   =   $posted ;
                }
                else
                {
                    if($this->data["old_pwd_flag"]==1)
					{
						$user_data['s_password'] = $posted["txt_old_password"];
						$is_pwd_correct	=	$this->mod_user->check_password($user_data['s_password'],decrypt($user_id));
						if(empty($is_pwd_correct))
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["wrong_pwd"],'message_type'=>'err'));
							redirect(base_url().'change-password');
						}
					}
                    $info=array();
					if(!empty($posted["txt_new_password"]) && !empty($posted["txt_confirm_password"]))
					{
						$info["s_password"]	=$posted["txt_new_password"];
					}					
                    
                    $i_newid = $this->mod_user->set_new_password($info,$s_email);
					if($i_newid)////saved successfully
					{
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_pwd"],'message_type'=>'succ'));	
						redirect(base_url().'change-password');
					}
					else///Not saved, show the form again
					{
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_pwd_err"],'message_type'=>'err'));
						redirect(base_url().'change-password');
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
	
	
	/* this function lists the properties 
	*  added by the user
	*  @author : Mrinmoy Mondal
	*/
	public function manage_property()
	{
		$this->data['breadcrumb'] = array('Manage Property'=>'');
        // for highlighting account left menu in account section in account_left_menu.tpl.php
		$this->data['left_menu']  = 3;
		$enc_user_id    =   $this->loggedin['user_id'];
		
		ob_start();
		$this->ajax_pagination_property_list(0,1);
		$contents = ob_get_contents();
		ob_end_clean();
		$property_list = explode('^',$contents);			
		$this->data['property_list'] 	  = $property_list[0];
		
		$this->render('account/manage_property');
	}
	
	/* ajax call to get property list data */
	function ajax_pagination_property_list($start=0,$param=0) 
	{			
		
		$enc_user_id    = $this->loggedin['user_id'];
		$owner_id		= decrypt($enc_user_id);
		$s_where		= " WHERE p.i_owner_user_id = ".$owner_id." AND  p.i_status=1";
		
		$limit			= 5; 
		$this->data['property_list']= $this->mod_property->fetch_multi($s_where,intval($start),$limit);
		//pr($this->data['property_list'],1);
		$total_rows 				= $this->mod_property->gettotal_property_info($s_where);
		
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'account/ajax_pagination_property_list/';
		$paging_div = 'property_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		if(empty($param))
			$job_vw = $this->load->view('fe/account/ajax_pagination_property_list.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/account/ajax_pagination_property_list.tpl.php',$this->data,TRUE).'^'.$total_rows;
		echo $job_vw;
			
	}
	
	
	
	/* this function is to add and edit properties 
	*  added by the user
	*  @author : Mrinmoy Mondal
	*/
	public function list_your_place($i_property_id='')
	{
		$this->data['breadcrumb'] = array('List Your Place'=>'');
        // for highlighting account left menu in account section in account_left_menu.tpl.php
		$this->data['left_menu']  = 3;
		$enc_user_id    =   $this->loggedin['user_id'];
        $user_info      =   $this->mod_user->fetch_this(decrypt($enc_user_id));
		$this->data["i_phone_verified"] = $user_info["i_phone_verified"];
		
        if($i_property_id=='')
        {
            $currency_id    =    $this->curId;
            $this->data["currency_symbol"]=    $this->curSymbol;            
        }
		
		$this->data['arr_amenity']  =   array();
        
		if($_POST)
		{
			$posted     =   array();
            $posted["h_id"]                    = trim($this->input->post("h_id"));  
            $posted["h_mode"]                  = trim($this->input->post("h_mode"));  
			$posted["h_currency_id"]		   = $this->input->post("h_currency_id");  
			// place fields
			$posted["i_accomodation"]		= $this->input->post("i_accomodation");
			$posted["opt_property_type"]	= trim($this->input->post("opt_property_type"));
			$posted["opt_bedtype"]			= trim($this->input->post("opt_bedtype"));
			$posted["i_total_bathroom"]		= trim($this->input->post("i_total_bathroom"));
			$posted["i_total_guest"]		= trim($this->input->post("i_total_guest"));
			$posted["i_total_bedrooms"]		= trim($this->input->post("i_total_bedrooms"));
			// prices fields
			$posted["d_standard_price"]		= trim($this->input->post("d_standard_price"));
			$posted["d_monthly_price"]		= trim($this->input->post("d_monthly_price"));
			$posted["d_cleaning_price"]		= trim($this->input->post("d_cleaning_price"));
			$posted["d_weekly_price"]		= trim($this->input->post("d_weekly_price"));
			$posted["d_additional_price"]	= trim($this->input->post("d_additional_price"));
			// conditions fields
			$posted["opt_check_after"]		= trim($this->input->post("opt_check_after"));
			$posted["opt_policy"]			= trim($this->input->post("opt_policy"));
			$posted["opt_max_night"]		= trim($this->input->post("opt_max_night"));
			$posted["opt_check_before"]		= trim($this->input->post("opt_check_before"));
			$posted["opt_min_night"]		= trim($this->input->post("opt_min_night"));
			// Location fields
			$posted["opt_country"]			= trim($this->input->post("opt_country"));
			$posted["opt_state"]			= trim($this->input->post("opt_state"));
			$posted["opt_city"]				= trim($this->input->post("opt_city"));
			$posted["s_zipcode"]			= trim($this->input->post("s_zipcode"));
            $posted["location_on_map"]      = trim($this->input->post("location_on_map"));
            $posted["lat"]                  = trim($this->input->post("lat"));
			$posted["lng"]          		= trim($this->input->post("lng"));
			$posted["ta_address"]			= trim($this->input->post("ta_address"));
			// Amenities
			$posted["i_amenity"]			= $this->input->post("i_amenity");
			// photos and videos
			$posted["arr_images"]			= trim($this->input->post("f_image"));
			$posted["s_youtube_snippet"]	= trim($this->input->post("s_youtube_snippet"));
			// Description fields
			$posted["s_name"]				= trim($this->input->post("s_name"));
			$posted["s_description"]		= trim($this->input->post("s_description"));
			$posted["s_house_rules"]		= trim($this->input->post("s_house_rules"));
			$posted["arr_image"]			= $this->input->post("f_image");	
			
			$file_upload = array();
			//print_r($_FILES);
			/******* Upload image **********/	
			$UploadDir			= $this->property_image['general']['upload_path'];
			if(isset($_FILES['f_image']['name']))
			{
				foreach($_FILES['f_image']['name'] as $key=>$val)
				{
					if($val)
					{
					$file_upload[$key]["new_file"]		= 'property_'.$key.time().'.jpg';
					$file_upload[$key]["source_image"]	= $_FILES['f_image']['tmp_name'][$key];
					$s_upload = upload_image_file($file_upload[$key]["source_image"],$UploadDir,$file_upload[$key]["new_file"]);						
					}
				
				}
			
				   
			}
			//pr($file_upload);
			//exit;
			
			
			//pr($posted,1);
			$this->form_validation->set_rules('opt_property_type','property type', 'required|trim');
			$this->form_validation->set_rules('opt_bedtype','bed type', 'required|trim');
			$this->form_validation->set_rules('i_total_bathroom','total bathroom', 'required|trim');
			$this->form_validation->set_rules('i_total_guest','total guest', 'required|trim');
			$this->form_validation->set_rules('i_total_bedrooms','total bedrooms', 'required|trim');
			
			$this->form_validation->set_rules('d_standard_price','standard price', 'required|trim');
			$this->form_validation->set_rules('d_monthly_price','monthly price', 'required|trim');
			//$this->form_validation->set_rules('d_cleaning_price','cleaning price', 'required|trim');
			$this->form_validation->set_rules('d_weekly_price','weekly price', 'required|trim');
			//$this->form_validation->set_rules('d_additional_price','additional price', 'required|trim');
			
			$this->form_validation->set_rules('opt_check_after','check after', 'required');
			$this->form_validation->set_rules('opt_policy','cancellation policy', 'required');
			$this->form_validation->set_rules('opt_max_night','maximum stay', 'required');
			$this->form_validation->set_rules('opt_check_before','check before', 'required');
			$this->form_validation->set_rules('opt_min_night','minimum stay', 'required');
			
			$this->form_validation->set_rules('opt_country','country', 'required');
			$this->form_validation->set_rules('opt_state','state', 'required');
			$this->form_validation->set_rules('opt_city','city', 'required');
			$this->form_validation->set_rules('s_zipcode','zipcode', 'required|trim');
			$this->form_validation->set_rules('ta_address','address', 'required|trim');
			
			$this->form_validation->set_rules('s_name','property name', 'required|trim');
            $this->form_validation->set_rules('s_description','property description', 'required|callback__invalid_text_description');
			$this->form_validation->set_rules('s_house_rules','property rules', 'required|trim');

          
			if($this->form_validation->run() == FALSE ) // validation false (error occur)
			{
              
				$this->data["posted"]   =   $posted ;
			}
			else		// validated now save into database
			{
				$info   =   array();
				$info["s_property_id"]       		=    $this->mod_property->genUniqueId();  
				$info["s_property_name"]        	=    $posted["s_name"] ;  
				$info["i_country_id"]            	=    decrypt($posted["opt_country"]);  
				$info["i_state_id"]     			=    decrypt($posted["opt_state"]);  
				$info["i_city_id"] 					=    decrypt($posted["opt_city"]);  
				$info["s_zipcode"]  				=    $posted["s_zipcode"];  
				$info["s_address"]  				=    $posted["ta_address"];
				
				$info["e_accommodation_type"] 		=    $posted["i_accomodation"] ;  
				$info["i_property_type_id"]         =    decrypt($posted["opt_property_type"]);
				$info["i_total_guests"]       		=    $posted["i_total_guest"] ;
				$info["i_bed_type_id"]         		=    decrypt($posted["opt_bedtype"]);
				$info["i_total_bedrooms"]           =    $posted["i_total_bedrooms"];
				$info["i_total_bathrooms"]          =    $posted["i_total_bathroom"] ;
				
				$info["d_standard_price"] 			=    $posted["d_standard_price"] ;  
				$info["d_weekly_price"]         	=    $posted["d_weekly_price"] ;
				$info["d_monthly_price"]       		=    $posted["d_monthly_price"] ;
				$info["d_additional_price"]         =    $posted["d_additional_price"];
				$info["d_cleaning_fee"]         	=    $posted["d_cleaning_price"] ;
				
				$info["i_currency_id"]             	=    $posted["h_currency_id"] ; 
				$info["i_owner_user_id"]          	=    decrypt($enc_user_id);				
				$info["i_checkin_after"] 			=    $posted["opt_check_after"];  
				$info["i_checkout_before"]         	=    $posted["opt_check_before"];
				$info["i_cancellation_policy_id"]	=    decrypt($posted["opt_policy"]) ;
				$info["s_description"]         		=    $posted["s_description"];
				$info["s_house_rules"]          	=    $posted["s_house_rules"];
				
				$info["s_youtube_snippet"] 			=    $posted["s_youtube_snippet"] ;  
				$info["i_minimum_night_stay"]		=    decrypt($posted["opt_min_night"]);
				$info["i_maximum_night_stay"]		=    decrypt($posted["opt_max_night"]);
				$info["dt_created_on"]          	=    time();
				
				
				$info['s_lattitude']                =     $posted["lat"];
    			$info['s_longitude']                =     $posted["lng"];
				/* end  latitude and longitude  */
				
				
				
				//pr($info,1);
				//exit;
				
				$this->load->model('common_model','mod_common');
				$s_table_name = $this->db->PROPERTY; 
				if($posted["h_mode"]=='edit')
				{
				$arr_where  	=   array('i_id'=>intval(decrypt($i_property_id)));	
				$i_newid 		= $this->mod_common->common_edit_info($s_table_name,$info,$arr_where);
                

				}
				else
				{
				$i_newid	=	$this->mod_common->common_add_info($s_table_name,$info);
				}
                
               
                
				//$i_newid = true;
				if($i_newid)
				{
					/* ===========================   ADD NEW AMENITY ============================================*/
					if(!empty($posted["i_amenity"]))   // ADD AMENITY TYPE
					{
						$table_name =   $this->db->PROPERTYAMENITY;						
						$info_amenity    =   array();
						if($posted["h_mode"]=='edit')
						{
						$info_amenity['i_property_id'] =  decrypt($i_property_id);
						}
						else
						{
						$info_amenity['i_property_id'] =  $i_newid;
						}
						
						foreach($posted["i_amenity"] as $value)
						{
							if($value!='')
							{
								$info_amenity['i_amenity_id']   =   $value;  
								$this->mod_common->common_add_info($table_name,$info_amenity); //Add new amenity    
							}  
	
						}
						unset($table_name,$info_amenity);
					}
					/* ===========================   END ADD NEW AMENITY ============================================*/
					
					/************************** CREATE THUMB IMAGES ***********************/
					if(!empty($file_upload))
					{
                        $wm_text    =   $this->config->item('wm_text') ;	
						foreach($file_upload as $k=>$v)
						{
							
							$tmp_file =	getFilenameWithoutExtension($v["new_file"]);
							$table_name =   $this->db->PROPERTYIMAGE;
							$info_new   =   array();
							if($posted["h_mode"]=='edit')
							{
								$info_new['i_property_id']  =  decrypt($i_property_id);
							}
							else
							{
								$info_new['i_property_id']  =  $i_newid;
							}
							$info_new['s_property_image']   =  $v["new_file"] ;
							$this->mod_common->common_add_info($table_name,$info_new); //Add new categories 
							
                              
                            
							foreach($this->property_image as $key=>$val)
							{
								if($key!='general')
								{
								$ThumbDir			= $val['upload_path'];
								$thumbfile			= $tmp_file.'_'.$key.'.jpg';
								$img_source			= $v['source_image'];
								$width				= $val['width'];
								$height				= $val['height'];
								$s_uploaded_file 	= upload_image_file($img_source,$ThumbDir,$thumbfile,$height,$width);
								if($s_uploaded_file=='ok' && $val['wm_font_size'])
								{   
                                   
									watermark_text_image_file($ThumbDir.$thumbfile,$wm_text,$val['wm_font_size'],'858585');
								}
								
								}
							}
                             
							
						}
					}
                    
					$this->session->set_userdata(array('message'=>$this->cls_msg["add_property_succ"],'message_type'=>'succ'));
					if($posted["h_mode"]=='edit')
                    {
                        redirect(base_url()."list-your-place/".$posted["h_id"]);
                    }
                    else
                    {
                        redirect(base_url()."list-your-place");
                    }
					
                    
				}
				
			}
			
			
			
		}
		
		else
		{
			if($i_property_id!='')
			{
				$tablename  	=   $this->db->PROPERTY;
				$arr_where  	=   array('i_id'=>intval(decrypt($i_property_id)));				
				$info_property  =   $this->mod_common->common_fetch($tablename,$arr_where);
                
                $this->load->model('currency_model','mod_currency') ;
                $info_currency  =   $this->mod_currency->fetch_this($info_property[0]['i_currency_id']);
              
               
                $this->data["currency_symbol"]=    $info_currency['s_currency_symbol'];
                
                
                 unset($info_currency);	
				
				$s_where		= "WHERE pa.i_property_id = ".decrypt($i_property_id)." AND a.i_status = 1";
				$info_amenity	=	$this->mod_property->fetch_property_amenity($s_where); 
				$arr_amenity = array();
				if($info_amenity)
				{
					foreach($info_amenity as $val)
					{
						$arr_amenity[] = $val["s_name"];
					}
				}
				$this->data["arr_amenity"] = $arr_amenity;
				$posted     	=   array();
                $posted["h_mode"]=   "edit" ;
				$posted["h_id"]	=	$i_property_id ;
				if(!empty($info_property))
                {
					foreach($info_property as $val)
					{
						$posted["i_accommodation"]		= $val["e_accommodation_type"];
						$posted["opt_property_type"]	= encrypt($val["i_property_type_id"]);
						$posted["opt_bedtype"]			= encrypt($val["i_bed_type_id"]);
						$posted["i_total_bedrooms"]		= trim($val["i_total_bedrooms"]);
						$posted["i_total_bathroom"]		= trim($val["i_total_bathrooms"]);
						$posted["i_total_guest"]		= trim($val["i_total_guests"]);
						
						$posted["d_standard_price"]		= trim($val["d_standard_price"]);
						$posted["d_weekly_price"]		= trim($val["d_weekly_price"]);
						$posted["d_monthly_price"]		= trim($val["d_monthly_price"]);
						$posted["d_additional_price"]	= trim($val["d_additional_price"]);
						$posted["d_cleaning_price"]		= trim($val["d_cleaning_fee"]);
						
						$posted["opt_check_after"]		= $val["i_checkin_after"];
						$posted["opt_policy"]			= encrypt($val["i_cancellation_policy_id"]);
						$posted["opt_max_night"]		= encrypt($val["i_maximum_night_stay"]);
						$posted["opt_check_before"]		= $val["i_checkout_before"];
						$posted["opt_min_night"]		= encrypt($val["i_minimum_night_stay"]);
						
						$posted["opt_country"]          = ($val['i_country_id'])?encrypt($val['i_country_id']):''; 
                  		$posted["opt_state"]            = ($val['i_state_id'])?encrypt($val['i_state_id']):''; 
						$posted["opt_city"]				= ($val['i_city_id'])?encrypt($val['i_city_id']):'';
						$posted["s_zipcode"]			=  $val["s_zipcode"];
						$posted["ta_address"]			=  $val["s_address"];
						$posted["location_on_map"]      = !empty($val["s_longitude"])?$val["s_lattitude"].', '.$val["s_longitude"]:"";
						$posted["lat"]					= $val["s_lattitude"];
						$posted["lng"]					= $val["s_longitude"];
						
						$posted["s_youtube_snippet"]	= $val["s_youtube_snippet"];
						$posted["s_name"]				= trim($val["s_property_name"]);
						$posted["s_description"]		= trim($val["s_description"]);
						$posted["s_house_rules"]		= trim($val["s_house_rules"]);

                        
                        $posted["h_currency_id"]        =  $val['i_currency_id'] ;
					}
				} // end if
                
                $s_where        =   " WHERE pi.i_property_id= ".decrypt($i_property_id)." " ;
                $info_image     =   $this->mod_property->fetch_property_image($s_where) ;    
               
                
                $this->data["info_image"]    =   $info_image ;
            
			    $this->data['posted']	=	$posted ;
                //pr($this->data['posted']);
                
			}
            else
            {
               $posted['h_currency_id']    =   $currency_id ;
               $this->data['posted']       =   $posted ;
            }
		}
        
           
		
		$s_where	=	"WHERE a.i_status = 1 ";
		$this->data["amenity"]	=	$this->mod_assets->fetch_amenity_list($s_where);
		//echo '<br>';pr($this->data["amenity"],1);	
		$this->data["arr_number"]	=	$this->db->ARR_NUMBER;
		$this->render('account/list_your_place');
	}
	
	
	
	/* this function lists the property calender 
	*  booked and available dates of that property
	*  @author : Mrinmoy Mondal
	*/
	public function property_calender($enc_property_id='')
	{
		$this->data['breadcrumb'] = array('Manage Property Calender'=>'');
		$this->data['left_menu']  = 3;
		$enc_user_id    =   $this->loggedin['user_id'];	
        $i_property_id  =   decrypt($enc_property_id);
		if($_POST)
            {
                $selected_month  =   $this->input->post('selectmonth');
                $arr_month  =   explode('_',$selected_month);
                $this_month =   $arr_month[0];
                $this_year  =   $arr_month[1];
             
                $this->data['selected_month']   =   $selected_month ;
                $this->data['index']            =   1 ;
                
                
            }
            else
            {
                 $this_month =   date('m');
                 $this_year  =   date('Y');
             
            }
            /***************************** TO GENERATE CALENDER   *******************************/
            
            
            $this->data["start_day"]  = get_first_day($this_month,$this_year);
            $this->data["total_days"] = get_total_days_in_month($this_month,$this_year);
           
            
            if($this_month==12)
            {
                $next_month =   1;
                $next_year  =   $this_year +1 ;
            }
            else
            {
                $next_month =   $this_month+1;
                $next_year  =   $this_year ;
            }

            $s_where    = " WHERE i_property_id=".$i_property_id." AND dt_blocked_date >=".strtotime('01-'.$this_month.'-'.$this_year)." AND dt_blocked_date <".strtotime('01-'.$next_month.'-'.$next_year) ;
            
            $info_blocked    =   $this->mod_property->property_booked_date($s_where);
            $this->data['info_blocked']  =   $info_blocked ;
           
            
            $s_where    = " WHERE i_property_id=".$i_property_id." AND e_status!='Not Paid' AND (dt_booked_from >= ".strtotime('01-'.$this_month.'-'.$this_year)." AND dt_booked_from < ".strtotime('01-'.$next_month.'-'.$next_year)." OR ( dt_booked_to > ".strtotime('01-'.$this_month.'-'.$this_year)." AND dt_booked_to <= ".strtotime('01-'.$next_month.'-'.$next_year)." )) " ;
            
            
            $info_booked    =   $this->mod_property->fetch_booked_date($s_where);
            
            $arr_booked     =   array();
            if(!empty($info_booked))
            {
              
                foreach($info_booked as $val)
                {
                    if($val['booked_from_month']==$val['booked_to_month'] && $val['booked_from_month']==$this_month)
                    {
                        $arr_booked =   array_merge($arr_booked,range($val['booked_from_date'],$val['booked_to_date']-1));
                    }
                    else
                    {
                        if($val['booked_from_month']==$this_month)
                        {
                            $arr_booked =   array_merge($arr_booked,range($val['booked_from_date'],$this->data["total_days"]));
                        }
                        else if($val['booked_to_month']==$this_month && $val['booked_to_date']>1)
                        {
                            $arr_booked =   array_merge($arr_booked,range(1,$val['booked_to_date']-1));
                        }
                    }
                    
                }
            }
            
            $this->data['info_booked']   =   $arr_booked ; 
            
            $this->data['property_id']  =   $enc_property_id ;
           
		$this->render('account/property_calender');
	}
    
    
    
	public function add_property_calender()
	{		
		if($_POST)
		{
			$posted	=	array();
			echo $posted["month_year"] = $this->input->post("month_year");
			
		}
		
	}
	
	
	
    
    /**
    * This is a callback function for ci form validation for chcking email existance
    * if email exist it return false for showing error
    * 
    * @param mixed $s_email
    */
    function _email_exist($s_email)
    {
        if($s_email!='')
        {
            $enc_user_id =   $this->loggedin['user_id'];
            
            $s_where    =   " WHERE n.i_id!=".decrypt($enc_user_id)." AND  n.s_email = '".$s_email."'" ;
            $i_cnt      =   $this->mod_user->gettotal_info($s_where);
            if($i_cnt>0)
            {
                $this->form_validation->set_message('_email_exist', 'This %s already exist.');
                return false;
            }
            else
            {
                return true;
            }
            
        }
        else
        {
            return true;
        }
    }
	
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
    
    
   
	
	/* delete property on cheking delete dependencies */
	public function ajax_delete_property()
    {
        try
        {
            if($_POST)
            {
                $i_property_id  =   $this->input->post('property_id');
				$current_page	=   $this->input->post('current_page');
				$tot_rows		=   $this->input->post('total_rows');
				//echo $i_property_id; exit;
                $i_return      	=   $this->mod_property->delete_property($i_property_id) ;
			  
                //$i_return = false;
                if($i_return)
                {                   
					echo 'success';
                }
				else
				{
					echo 'fail';
				}
                
            }
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    /**
    * this is a ajax function to block a date
    * 
    */
    function ajax_property_block_date()
    {
        try
        {
            if($_POST)
            {
                $date           =   $this->input->post("date");
                $current_month  =   explode('_',$this->input->post("current_month"));
                $i_status       =   (trim($this->input->post("i_status"))=='true')?1:0;
                $property_id    =   decrypt(trim($this->input->post("property_id")));
                
                $date   =   str_pad($date,2,'0',STR_PAD_LEFT);
                $month  =   str_pad($current_month[0],2,'0',STR_PAD_LEFT);
                $year   =   $current_month[1];
                
                $date_month_year    =   strtotime($date.'-'.$month.'-'.$year) ;
              
              
                
                if($i_status)
                {
                    
                     $i_aff  =   $this->mod_property->unblock_property($property_id,$date_month_year);
                  
                }
                else
                { 
                     $info['i_property_id']   =   $property_id ;
                     $info['dt_blocked_date'] =   $date_month_year ;

                     $i_aff  =   $this->mod_property->block_property($info);
                }
              
                if($i_aff)
                {
                     
                    echo 'ok' ;
                }
                else
                {
                    echo 'error' ;
                }
                
                
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
    
    
    public function my_property_booking()
    {
        try
        {
            $this->data['breadcrumb'] = array('My Property Booking'=>'');
            // for highlighting account left menu in account section in account_left_menu.tpl.php
            $this->data['left_menu']  = 5;
            $enc_user_id    =   $this->loggedin['user_id'];

             $this->session->unset_userdata('filter_option');
            ob_start();
            $this->ajax_pagination_property_booking_list(0,1);
            $contents = ob_get_contents();
            ob_end_clean();
                     
            $this->data['property_list']       = $contents;
            
            $this->render('account/my_property_booking');
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    }
    
    
    function ajax_pagination_property_booking_list($start=0,$param=0) 
    {
        try
        {
            if($_POST)
            {
                $filter_option  =   $this->input->post('filter_option');
                if($filter_option!='')
                {
                    switch($filter_option)
                    {
                        case 1:
                                $s_wh  =   "  ";
                                break;
                        case 2:
                                $s_wh  =   " AND b.e_status='Request sent' ";
                                break;
                        case 3:
                                $s_wh  =   " AND b.e_status='Approve by user' ";
                                break;
                        case 4:
                                $s_wh  =   " AND b.e_status='Amount paid' ";
                                break;
                    }
                    
                    $this->session->set_userdata('filter_option',$s_wh) ;
                }
                
            }
            
            if($this->session->userdata('filter_option'))
            {
                $condition  =   $this->session->userdata('filter_option') ;
            }
            else
            {
                $condition  =   "  ";
            }
            
            $enc_user_id    = $this->loggedin['user_id'];
            $owner_id        = decrypt($enc_user_id);
            $s_where        = " WHERE p.i_owner_user_id = ".$owner_id.$condition ;
           
            $limit            = 5; 
            $this->data['property_list']= $this->mod_property->fetch_booking_list($s_where,intval($start),$limit);
           
            //pr($this->data['property_list'],1);
            $total_rows                 = $this->mod_property->gettotal_property_booking($s_where);
            
            /* pagination start @ defined in common-helper */
            $ctrl_path     = base_url().'account/ajax_pagination_property_booking_list/';
            $paging_div = 'property_list';
            $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
            $this->data['total_rows']     = $total_rows;
            $this->data['start']          = $start;
            
          
            echo   $job_vw = $this->load->view('fe/account/ajax_pagination_property_booking_list.tpl.php',$this->data,TRUE);
           
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }                
    }
    
    /**
    * This is an ajax function for approve a booking request
    * an email forword to the traveller 
    * 
    */
    public function ajax_approve_booking()
    {
        try
        {
            if($_POST)
            {
                $booking_id     =   $this->input->post('booking_id');
                $tablename      =   $this->db->BOOKING ;
                $arr_where      =   array('i_id'=>decrypt($booking_id));
                $info_update    =   array('e_status'=>'Approve by user','dt_approved_on'=>time());
                $i_aff  =   $this->mod_common->common_edit_info($tablename,$info_update,$arr_where);
                unset($tablename,$info_update,$arr_where);
                
                if($i_aff)
                {
                   $s_where =   " WHERE b.i_id=".decrypt($booking_id); 
                   $info_booking   =   $this->mod_property->fetch_booking_list($s_where);
                   
                    /* Booking approve send to the traveller */
                   $this->load->model("auto_mail_model","mod_auto");
                   $content         =   $this->mod_auto->fetch_mail_content('booking_confirmed');    
                   $filename        =   $this->config->item('EMAILBODYHTML')."common.html";
                   $handle          =   @fopen($filename, "r");
                   $mail_html       =   @fread($handle, filesize($filename));    
                   $s_subject       =   $content['s_subject'];        
                    //print_r($content); exit;    
                                    
                    if(!empty($content))
                    {                    
                        $description = $content["s_content"];
                        
                        
                        $description = str_replace("###TRAVELER###",ucfirst($info_booking[0]['s_first_name']).' '.ucfirst($info_booking[0]['s_last_name']),$description);
                        $description = str_replace("###OWNER###",ucfirst($this->loggedin['user_first_name']).' '.ucfirst($this->loggedin['user_last_name']),$description);    
                        $description = str_replace("###PROPERTY###",$info_booking[0]['s_property_name'],$description);        
                                               
                        $description = str_replace("###LINK_DETAILS###",base_url().'booking-details/'.$booking_id,$description);                        
                    }
                        
                    $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);    
                    $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);    
                   
                   
                 
                    /// Mailing code...[start]
                    $site_admin_email = $this->s_admin_email;    
                    $this->load->helper('mail');                                        
                    $i_sent = sendMail($info_booking[0]['s_email'],$s_subject,$mail_html);
                    
                    unset($mail_html,$description,$s_subject,$content,$info_booking,$s_where,$filename);
                    if($i_aff)
                    {
                        echo 'success';
                    }
                    else
                    {
                        echo 'error' ;
                    }
                    
                }
                else
                {
                    echo 'error';
                }
                
            }
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
        
    }
    
   /**
   * This is a function fetch all travel booking by a traveller
   * This function call the pegination function
   *  
   */
    public function my_travel_booking()
    {
        try
        {
            $this->data['breadcrumb'] = array('My Travel Booking'=>'');
            // for highlighting account left menu in account section in account_left_menu.tpl.php
            $this->data['left_menu']  = 6;
            $enc_user_id    =   $this->loggedin['user_id'];

            
            ob_start();
            $this->ajax_pagination_travel_booking_list(0,1);
            $contents = ob_get_contents();
            ob_end_clean();
                       
            $this->data['property_list']       = $contents;
            
            $this->render('account/my_travel_booking');
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    }
    
    /**
    * This function is ajax pegination function 
    * make the list all travel booking details of a traveller
    * 
    * @param mixed $start
    * @param mixed $param
    */
    function ajax_pagination_travel_booking_list($start=0,$param=0) 
    {
        try
        {
            $enc_user_id    = $this->loggedin['user_id'];
            
            $s_where        = " WHERE b.i_traveler_user_id = ".decrypt($enc_user_id) ;
            
            $limit            = 5; 
            $this->data['property_list']= $this->mod_property->fetch_booking_list($s_where,intval($start),$limit,decrypt($enc_user_id));
          
            $total_rows                 = $this->mod_property->gettotal_property_booking($s_where);
            //pr($this->data['property_list'],1);
            /* pagination start @ defined in common-helper */
            $ctrl_path     = base_url().'account/ajax_pagination_travel_booking_list/';
            $paging_div = 'property_list';
            $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
            $this->data['total_rows']     = $total_rows;
            $this->data['start']          = $start;
            
          
            echo   $job_vw = $this->load->view('fe/account/ajax_pagination_travel_booking_list.tpl.php',$this->data,TRUE);
           
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }                
    }
	
	
	
    /**
    * This function is for get the booking details and payment details
    * it take number of guest
    * guest name put in booking_guest table
    * and payment card details
    * cvv number and also expire date
    * 
    * 
    * 
    * @param mixed $booking_id
    */
    public function booking_details($booking_id)
    {
        try
        {
            
             $this->data['breadcrumb'] = array('Booking Details'=>'');
            // for highlighting account left menu in account section in account_left_menu.tpl.php
             $this->data['left_menu']  = 6;
             $enc_user_id    =   $this->loggedin['user_id'];
             
             $s_where   =   " WHERE b.i_id=".decrypt($booking_id);
             $info_booking  =   $this->mod_property->fetch_booking_front_end($s_where);
             
             if($_POST)
             {
                 
                 $total_guest       =   $this->input->post('opt_total_guest');
                 $arr_guest_name    =   $this->input->post('txt_guest_name');

                 $number_of_days    =   ($info_booking[0]['t_booked_to']-$info_booking[0]['t_booked_from'])/(60*60*24);
             
                 // if number of days more than 30 days monthly price ll applied here     
                 $d_price   =   0 ; 
                 if($number_of_days>30)
                 {
                     $cnt               =  (int)($number_of_days/30) ;
                     $number_of_days    =  $number_of_days%30 ;
                     $d_price          +=   $cnt*$info_booking[0]['d_monthly_price'];
                 }
                 // if number of days more than 7 days weekly price ll applied here
                 if($number_of_days>7)
                 {
                     $cnt               =  (int)($number_of_days/7) ;
                   
                     $number_of_days    =  $number_of_days%7 ;
                     $d_price          +=   $cnt*$info_booking[0]['d_weekly_price'];
                 }
                 // if number of days less dan 7 standard price ll be applied 
                if($number_of_days>0)
                 {
                     $d_price          +=   $number_of_days*$info_booking[0]['d_standard_price'];
                 }

               
                 $d_price   =    $d_price*$this->curRate ;
                 
                 $d_service_charge_amount  =   ($d_price*$this->data['d_service_charge_percentage'])/100 ; // Service tax 
                 
                 $d_amount =   $d_price+$d_service_charge_amount ; // service tax add to booking price
                
              
               
                if($d_amount > 0)
                {
                   
                    
                    $this->load->model('site_setting_model');
                    $site_settings = $this->site_setting_model->fetch_this(1);
                    include_once(APPPATH.'libraries/paypal_IPN/Paypal.php');  
                    
                    $data['title'] = "Booking Payment";
                    
                    $PAYPAL_ENVIRONMENT = 'test';
                     
                    $TOTAL_AMOUNT  = number_format($d_amount,2);  // Fetched Amount 
                    $SHIPPING_AMOUNT = 0;
                      
                    $IPN_OBJ = new paypal;     // initiate an instance of the IPN class...
                    $IPN_OBJ->paypal_url = $this->config->item('paypal_url');//$this->site_settings_model->getPaypalURL($PAYPAL_ENVIRONMENT);
                    $IPN_OBJ->add_field('cmd', '_cart');
                    $IPN_OBJ->add_field('upload', 1);
                    $IPN_OBJ->add_field('business', $site_settings['s_paypal_email']);

                    //$data['paypal_obj'] = $IPN_OBJ;
                    $data['cart_contents'] = $CART_CONTENTS_ARR;

                    # fixing shipping amount etc...
                    
                    $TOTAL_AMOUNT = $TOTAL_AMOUNT + $SHIPPING_AMOUNT;
                    
                    $data['total_charge'] = $TOTAL_AMOUNT;
                    $data['shipping_charge'] = $SHIPPING_AMOUNT;
                    $data['paypal_account'] = $site_settings['s_paypal_email'];
                    $data['item_name'] = 'Booking payment';
                    
                    
                    $data['currency'] = $this->db->CURRENCY_CODE[$this->curCode];
                    
                    $data['s_booking_id']   =   $info_booking[0]['s_booking_id'] ;

                    $all_guest  =   '';
                    foreach($arr_guest_name as $val)
                    {
                        $all_guest  .=   base64_encode($val).'||' ;
                    }
                    
                    
                  /*  $arr_booking_info   =   array(
                                                    'total_amount'   =>$TOTAL_AMOUNT,
                                                    'booking_id'     =>$booking_id,
                                                    'booking_price'  =>$d_price,
                                                    'i_cancellation_policy_id'=>$info_booking[0]['i_cancellation_policy_id'], 
                                                    'all_guest'=> trim($all_guest,'|') ,
                                                    'currency_id'=>$this->curId
                                                    );  */
                                                    
                    $info_update     =    array(
                                                    'd_total_amount'   =>$TOTAL_AMOUNT,
                                                    'i_booking_id'     =>decrypt($booking_id),
                                                    'd_booking_price'  =>$d_price,
                                                    'i_cancellation_policy_id'=>$info_booking[0]['i_cancellation_policy_id'], 
                                                    's_all_guest'=> trim($all_guest,'|') ,
                                                    'i_currency_id'=>$this->curId
                                                ); 
                   $s_tablename      =    $this->db->TEMPORARY_PAYMENT ;
                   $payment_id       =    $this->mod_common->common_add_info($s_tablename,$info_update);                
                 
                    
                    //$IPN_OBJ->add_field('custom',urlencode(base64_encode(serialize($arr_booking_info))) );
                    $IPN_OBJ->add_field('custom',$payment_id);
                     
                    unset($info_update,$s_tablename,$payment_id) ;
                    $data['paypal_obj'] = $IPN_OBJ;
                    
                    $this->load->view('fe/account/place_paypal_order.tpl.php', $data);
                     
                }                                

                

             }
            // Get total number of guest needed for the dropdown
             if(!empty($info_booking) && count($info_booking))
             {
                 if($info_booking[0]['e_status']=='Approve by user')
                 {
                     $total_guest   =   $info_booking[0]['i_total_guests'] ; 
                     // make the array for the total number of guest array(1=>1,2=>2,3=>3);
                     $arr_guest     =   array_combine(range(1,$total_guest),range(1,$total_guest)) ;
                     
                     $this->data['arr_guest']       =   $arr_guest ; 
                     //$this->data['h_property_id']   =   $info_booking[0]['i_property_id'];  
                     
                 }
                 else
                 {
                     redirect(base_url().'dashboard');
                 }
                 
             }
             else
             {
                     redirect(base_url().'dashboard');
             } 

             $this->render('account/booking_details');
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
  
    /**
    * This is the function to fetch the booking details 
    * total number guest and all guest name
    * booking price
    * 
    */
    public function ajax_fetch_booking_details()
    {
        try
        {
           if($_POST)
           {
                 $booking_id     =   $this->input->post('booking_id');
                 
                 // Fetch booking details.....
               
                 $info_booking  =   $this->mod_property->fetch_booking_info(decrypt($booking_id));
                 
                 if(!empty($info_booking))
                 {
                     if($info_booking['e_status']=='Amount paid' || $info_booking['e_status']=='Cancelled')
                     {
                         $s_tablename   =   $this->db->BOOKINGGUESTS ;
                         $arr_where     =   array('i_booking_id'=>decrypt($booking_id));
                         $info_guest    =   $this->mod_common->common_fetch($s_tablename,$arr_where);
                         
                         $this->data['info_guest']     =   $info_guest;
                         $this->data['info_booking']   =   $info_booking;
                         $this->data['info_traveler']  =   $this->mod_user->fetch_this($info_booking['i_traveler_user_id']); 
                         $this->data['info_owner']     =   $this->mod_user->fetch_this($info_booking['i_owner_user_id']); 
                         
                         unset($s_tablename,$arr_where,$info_guest);  
                         
                         echo $this->load->view('fe/account/ajax_booking_details.tpl.php',$this->data,true);   
                     }
                 }
                   
           }
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	/**
    * this is a ajax function to post review
    * 
    */
    function ajax_post_review()
    {
        try
        {
            if($_POST)
            {
				$booking_id	=	$this->input->post("h_booking_id");
                $name		=   trim($this->input->post("txt_name"));
				$rating		=	$this->input->post("opt_rating");
				$comment	=	trim($this->input->post("ta_comment"));
				$user_id	=	decrypt($this->data["loggedin"]["user_id"]);
				$image_file	=	$this->input->post("image_file");
				
				
				// check if any review exist for this booking by this user
				$s_where 	= " WHERE r.i_booking_id = ".$booking_id." AND r.i_user_id = ".$user_id." ";
				$info		=	$this->mod_property->fetch_review_exist($s_where);
				if(!empty($info))
				{
					$this->session->set_userdata(array('message'=>$this->cls_msg["exists_review"],'message_type'=>'err'));
					echo 'error';
				}
				else
				{
				
					$booking_detail = $this->mod_property->fetch_booking_details($booking_id);					
					if(($booking_detail["e_status"]=='Amount paid') && (time()>=$booking_detail["t_booked_to"]))
					{
					$property_detail = $this->mod_property->fetch_this($booking_detail["i_property_id"]);
					$owner_user_id = $property_detail["i_owner_user_id"];
					
					$info=array();
					$info["i_property_owner_id"]	=	$owner_user_id;
					$info["i_user_id"]		=	$user_id;
					$info["i_booking_id"]	=	$booking_id;
					$info["s_comment"]		=	$comment;
					$info["i_rating"]		=	$rating;
					$info["dt_created_on"]	=	time();	
					if(isset($_FILES['f_image']) && !empty($_FILES['f_image']['name']))
					{
						$UploadDir            = $this->review_image['general']['upload_path'];
						$newfile_name         = 'review_'.time().'.jpg';
						$img_source           = $_FILES['f_image']['tmp_name'];
						$file_upload_status   = upload_image_file($img_source,$UploadDir,$newfile_name);   
					}
					if($file_upload_status=='ok')
					{
						$info["s_review_image"]		=	$newfile_name;
					}
					// insert review into database
					$s_table	=	$this->db->REVIEWSRATING;
					$i_newid	=	$this->mod_common->common_add_info($s_table,$info);
					if($i_newid)
					{
						if($newfile_name!='' && $file_upload_status=='ok' )
                        {
                            $tmp_file            =    getFilenameWithoutExtension($newfile_name);
                            foreach($this->review_image as $key=>$val)
                            {
                                if($key!='general')
                                {
                                    $ThumbDir            = $val['upload_path'];
                                    $thumbfile           = $tmp_file.'_'.$key.'.jpg';
                                    $img_source          = $_FILES['f_image']['tmp_name'];
                                    $width               = $val['width'];
                                    $height              = $val['height'];
                                    $s_uploaded_file     = upload_image_file($img_source,$ThumbDir,$thumbfile,$height,$width);
                                }
                            }                            
                           
                        }
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_review_succ"],'message_type'=>'succ'));
						echo 'ok';
					}
					else
					{
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_review_err"],'message_type'=>'err'));
						echo 'error';
					}
					}
					else
					{						
						$this->session->set_userdata(array('message'=>$this->cls_msg["review_time_err"],'message_type'=>'err'));
						echo 'error';
					}
					
				} // end else
				
            }
            else
            {
				$this->session->set_userdata(array('message'=>$this->cls_msg["review_err"],'message_type'=>'err'));
				echo 'error';
                
            }
            
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
        
    }
	
	/* this function to fetch review content 
	* author @ mrinmoy
	*/
	public function ajax_fetch_review()
    {
        try
        {
            
			$booking_id = trim($this->input->post('booking_id'));
            $s_where  = " WHERE r.i_booking_id=".$booking_id." AND r.i_user_id=".decrypt($this->loggedin['user_id'])." ";
           
            $info_review = $this->mod_property->fetch_review_content($s_where);
			//pr($info_review,1);
            $str    =   '';
            if(!empty($info_review))
            {
               foreach($info_review as $val)
                {
                   
                    $str .= '<div class="review-box">
            <div class="review-photo">'.showThumbImageDefault('user_image',$val["s_owner_image"],'min',75,53).'</div>
            <div class="comment-box">
                  <div class="top-bg">&nbsp;</div>
                  <div class="midd-bg">'.showThumbImageDefault('review_image',$val["s_review_image"],'thumb',74,64,'','photo08').'
                        <div class="main-content">
						<div class="rating">'.show_star($val["i_rating"]).' <em>'.$val["dt_created_on"].'</em></div>
                        <p>'.$val["s_comment"].'</p>
                        <div class="remove"><a href="javascript:void(0);" onclick="remove_review('.$val['id'].');">Remove</a></div>
						</div>
                        <div class="spacer"></div>
                  </div>
                  <div class="bootom-bg">&nbsp;</div>
                  <div class="tick02">&nbsp;</div>
            </div>
      </div>' ;
                }
            }
            else
            {
                $str .= 'no review found';
            }
            
            echo $str; 
            
         
 
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	/**
    * this function to remove review with corresponding images from system
    */
	public function ajax_remove_review()
    {
        try
        {            
			$review_id = trim($this->input->post('review_id'));
			$s_where = " WHERE r.i_id = ".$review_id." ";
			$info = $this->mod_property->fetch_review_content($s_where);  
			//pr($info,1);          
			if(!empty($info))
			{
				$file_to_delete = getFilenameWithoutExtension($info[0]["s_review_image"]);
				$i_deleted  	= delete_images_from_system('review_image',$file_to_delete);
				
				$s_table_name 	= $this->db->REVIEWSRATING;
				$arr_where		= array('i_id'=>$review_id);
				$deleted 		= $this->mod_common->common_delete_info($s_table_name,$arr_where);
				if($i_deleted)
				{
					$this->session->set_userdata(array('message'=>$this->cls_msg["remove_review_succ"],'message_type'=>'succ'));
					echo 'ok';
				}
			}
			unset($review_id,$s_where,$s_table_name,$arr_where,$deleted,$i_deleted);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	/*end to remove review with corresponding images from system*/
    
    public function ajax_cancel_booking()
    {
        try
        {
                $booking_id     =   $this->input->post('booking_id');
                $tablename      =   $this->db->BOOKING ;
                $arr_where      =   array('i_id'=>decrypt($booking_id));
                $info_update    =   array('e_status'=>'Cancelled','dt_canceled_on'=>time());
                $i_aff  =   $this->mod_common->common_edit_info($tablename,$info_update,$arr_where);
                unset($tablename,$info_update,$arr_where);
                
                if($i_aff)
                {
                    echo 'success';
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
    
    public function write_message($booking_id='')
    {
        try
        {
            $posted     =   array();
             $this->data['breadcrumb'] = array('Write a Message'=>'');
            // for highlighting account left menu in account section in account_left_menu.tpl.php
             $this->data['left_menu']  = 4;
            $enc_user_id    = $this->loggedin['user_id'];
            if($_POST)
            {
                
               $posted["txt_receiver_name"]    =   $this->input->post("txt_receiver_name");
               $posted["txt_subject"]          =   $this->input->post("txt_subject");
               $posted["ta_message"]           =   $this->input->post("ta_message");
               $posted["h_receiver_id"]        =   $this->input->post("h_receiver_id");
               $posted["s_property_name"]      =   $this->input->post("h_property_name");
               $posted["s_booking_id"]         =   $this->input->post("h_booking_id");
               
                $this->form_validation->set_rules('txt_subject','your first name', 'required|trim');
                $this->form_validation->set_rules('ta_message','message', 'required|trim');
                
                if($this->form_validation->run() == FALSE ) // validation false (error occur)
                {
                    $this->data['posted']   =   $posted ;
                }
                else
                {
                    $info   =   array();
                    $info['i_receiver_user_id']=  decrypt($posted["h_receiver_id"]);
                    $info['i_sender_user_id'] =   decrypt($this->data['loggedin']['user_id']);
                    $info['s_subject']        =   $posted["txt_subject"];
                    $info['s_body']           =   $posted["ta_message"];
                    $info['dt_date_send']     =   time();
                    $info['i_booking_id']     =   decrypt($booking_id);

                    $s_tablename    =   $this->db->MESSAGE ;
                    
                    $i_aff  =   $this->mod_common->common_add_info($s_tablename,$info);
                     
                    if($i_aff) // If message sent successfully
                    {
                        $s_tablename    =   $this->db->USER ;
                        $arr_where      =   array('i_id'=>decrypt($posted["h_receiver_id"])) ;
                        $info_user      =   $this->mod_common->common_fetch($s_tablename,$arr_where);
                       
                         /* for registration verification mail to the user */
                           $this->load->model("auto_mail_model","mod_auto");
                           $content         =   $this->mod_auto->fetch_mail_content('send_message');    
                           $filename        =   $this->config->item('EMAILBODYHTML')."common.html";
                           $handle          =   @fopen($filename, "r");
                           $mail_html       =   @fread($handle, filesize($filename));    
                           $s_subject       =   $content['s_subject'];        
                            //print_r($content); exit;    
                                            
                            if(!empty($content))
                            {                    
                                $description = $content["s_content"];
                                
                                $description = str_replace("###RECEIVER###",ucfirst($info_user[0]['s_first_name']).' '.ucfirst($info_user[0]['s_last_name']),$description);    
                                $description = str_replace("###SENDER###",ucfirst($this->loggedin['user_first_name']).' '.ucfirst($this->loggedin['user_last_name']),$description);        
                                $description = str_replace("###PROPERTY###",$posted["s_property_name"],$description);                        
                                $description = str_replace("###BOOKING_ID###",$posted["s_booking_id"],$description);                        
                            }
                                
                            $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);    
                            $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);    
                           
                           
                            /// Mailing code...[start]
                            $site_admin_email = $this->s_admin_email;    
                            $this->load->helper('mail');                                        
                            $i_sent = sendMail($info_user[0]['s_email'],$s_subject,$mail_html);

                        unset($s_tablename,$arr_where,$info_user,$mail_html,$description,$content);
                        $this->session->set_userdata(array('message'=>$this->cls_msg["message_send_succ"],'message_type'=>'succ')); 

                        redirect(base_url().'manage-internal-messaging');
                      
                          
                    }
                }// End of else

            }// End of post
           
            
            $s_where        =   " WHERE b.i_id=".decrypt($booking_id) ;
            $info_booking   =   $this->mod_property->fetch_booking_order_list($s_where,null,null);

            $posted['s_property_name']    =   $info_booking[0]['s_property_name']  ;
            $posted['s_booking_id']       =   $info_booking[0]['s_booking_id']  ;
            
            if($info_booking[0]['i_owner_user_id']==decrypt($enc_user_id))
            {
                $posted['txt_receiver_name']    =   ucfirst($info_booking[0]['s_first_name'])." ".ucfirst($info_booking[0]['s_last_name'])  ;
                $posted['h_receiver_id']        =   encrypt($info_booking[0]['i_traveler_user_id']) ; 
                
            }
            else
            {
                $posted['txt_receiver_name']    =   ucfirst($info_booking[0]['owner_first_name'])." ".ucfirst($info_booking[0]['owner_last_name'])  ;
                $posted['h_receiver_id']        =   encrypt($info_booking[0]['i_owner_user_id']) ;  
            }
                
            $this->data['posted']   =   $posted ;    
            $this->render('account/write_message');

            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    public function manage_internal_messaging()
    {
        try
        {
            $this->data['breadcrumb'] = array('Manage Internal Messaging'=>'');
            // for highlighting account left menu in account section in account_left_menu.tpl.php
            $this->data['left_menu']  = 4;
            $enc_user_id    =   $this->loggedin['user_id']; 
            
            ob_start();
            $this->ajax_pagination_inbox(0);
            $contents = ob_get_contents();
            ob_end_clean();
                   
            $this->data['message_list']       = $contents ;  
        
            $this->render('account/manage_internal_messaging');

        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    
     public function ajax_pagination_inbox($start=0)
     {
         try
         {
             
            $enc_user_id    = $this->loggedin['user_id'];
            
            $this->load->model('message_model','mod_msg');
            $s_where        = " WHERE m.i_receiver_user_id = ".decrypt($enc_user_id)." AND m.i_receiver_copy=0 " ;
            $s_order        = " ORDER BY m.dt_date_send DESC ";
            $limit            = 10; 
            $this->data['message_list']= $this->mod_msg->fetch_multi($s_where,$s_order,intval($start),$limit);
          
            $total_rows                 = $this->mod_msg->gettotal_message($s_where);
           /* echo    $total_rows    ;
            pr($this->data['message_list'],1);  */
            /* pagination start @ defined in common-helper */
            $ctrl_path     = base_url().'account/ajax_pagination_inbox/';
            $paging_div = 'message_list';
            $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
            $this->data['total_rows']     = $total_rows;
            $this->data['start']          = $start; 
            
          
            echo    $this->load->view('fe/account/ajax_pagination_inbox.tpl.php',$this->data,TRUE);
             
             
         }
         catch(Exception $err_obj)
         {
             show_error($err_obj->getMessage());
         }
     }
     
     public function ajax_pagination_send_item($start=0)
     {
         try
         {
             
            $enc_user_id    = $this->loggedin['user_id'];
            
            $this->load->model('message_model','mod_msg');
            $s_where        = " WHERE m.i_sender_user_id = ".decrypt($enc_user_id)." AND m.i_sender_copy=0 " ;
            $s_order        = " ORDER BY m.dt_date_send DESC ";
            $limit            = 10; 
            $this->data['message_list']= $this->mod_msg->fetch_multi($s_where,$s_order,intval($start),$limit);
          
            $total_rows                 = $this->mod_msg->gettotal_message($s_where);
           /* echo    $total_rows    ;
            pr($this->data['message_list'],1);  */
            /* pagination start @ defined in common-helper */
            $ctrl_path     = base_url().'account/ajax_pagination_inbox/';
            $paging_div = 'message_list';
            $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
            $this->data['total_rows']     = $total_rows;
            $this->data['start']          = $start; 
            
          
            echo    $this->load->view('fe/account/ajax_pagination_send_item.tpl.php',$this->data,TRUE);
             
             
         }
         catch(Exception $err_obj)
         {
             show_error($err_obj->getMessage());
         }
     }
     
     /**
     * This is an ajax function
     * change the i_receiver_copy or   i_sender_copy
     * 
     * if both   i_receiver_copy = 0 and   i_sender_copy=0 remove the message completely
     * 
     */
     public function ajax_move_to_trash()
     {
         try
         {
             $msg_id     =   trim($this->input->post('msg_id'));
             $type       =   $this->input->post('type');
             
             $arr_where    =   array('i_id'=>decrypt($msg_id));   
             if($type=='receiver')
             {
                 $info_update   =   array('i_receiver_copy'=>1);
                 
             }
             else if($type=='sender')
             {
                 $info_update   =   array('i_sender_copy'=>1);
             }
             $s_tablename   =   $this->db->MESSAGE ;
             
             $info_message  =   $this->mod_common->common_fetch($s_tablename,$arr_where);
             if($info_message[0]['i_sender_copy']==1 || $info_message[0]['i_receiver_copy']==1) // if recever or sender already deleted then delete message completely
             {
                $i_aff     =   $this->mod_common->common_delete_info($s_tablename,$arr_where);
             }
             else
             {
                $i_aff     =   $this->mod_common->common_edit_info($s_tablename,$info_update,$arr_where);   
             }

           
             if($i_aff)
             {
                 if($type=='receiver')
                 {
                     ob_start();
                     $this->ajax_pagination_inbox(0);
                     $contents = ob_get_contents();
                     ob_end_clean();

                 }
                 else if($type=='sender')
                 {
                     ob_start();
                     $this->ajax_pagination_send_item(0);
                     $contents = ob_get_contents();
                     ob_end_clean();

                 }
                 echo   $contents ;
             }    
         }
         catch(Exception $err_obj)
         {
             show_error($err_obj->getMessage());
         }
         
     }
	 
	  /**
     * this function is to get cancellation policy description 
     * 
     */
     
     public function ajax_fetch_cancellation_policy()
     {
         try
         {
             $policy_id     =   trim($this->input->post('policy_id'));
             if(decrypt($policy_id))
			 {
             $arr_where		=   array('i_id'=>decrypt($policy_id));               
             $s_tablename   =   $this->db->PROPERTYCANCELLATIONPOLICY ;
             $arr_policy	=   $this->mod_common->common_fetch($s_tablename,$arr_where);
			 }
             //pr($arr_policy,1);
             if($arr_policy)
             {
                 echo 'ok^'.$arr_policy[0]["s_description"];
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
    
     
     /**
     * this function is to change the read status 
     * by changing i_receiver_read and i_sender_read
     * 
     */
     
     public function ajax_change_read_status()
     {
         try
         {
             $msg_id     =   trim($this->input->post('msg_id'));
             $type       =   $this->input->post('type');
             
             $arr_where    =   array('i_id'=>decrypt($msg_id));   
             if($type=='receiver')
             {
                 $info_update   =   array('i_receiver_read'=>1);
                 
             }
             else if($type=='sender')
             {
                 $info_update   =   array('i_sender_read'=>1);
             }
             $s_tablename   =   $this->db->MESSAGE ;
             $i_aff     =   $this->mod_common->common_edit_info($s_tablename,$info_update,$arr_where);
             
             if($i_aff)
             {
                 echo 'ok';
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
    
    
    public function ajax_verify_facebook()
	{
		$address     =   $this->input->post('address');
        $access_token       =   $this->input->post('access_token');

		$address_org = $address;
		
		$qry = urlencode("SELECT first_name, last_name, email, profile_url FROM user WHERE uid = me()");
        $content = @json_decode(get_url_fb('https://graph.facebook.com/fql?q='.$qry.'&access_token='.$access_token));
		$profile_url  =   $content->data[0]->profile_url ;
		
		$profile_url = explode('://',$profile_url,2);
		$profile_url = $profile_url[1];
		
		$address = explode('://',$address,2);
		$address = $address[1];
		
		if($profile_url==$address)
		{
			$this->session->set_userdata('facebook_address_verified',$address_org);
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	

	
    
    /**
    * This function is to set the session for linkedin verified address
    * 
    */
    
    public function ajax_verify_linkedin()
    {
        try
        {
            $linkedin_address   =   trim($this->input->post('linkedin_address'));
            
            $this->session->set_userdata('linkedin_address_verified',$linkedin_address);
            echo 'ok';
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
        
    }
    
    
     public function ajax_verify_twitter()
    {
        try
        {
            $twitter_address   =   trim($this->input->post('twitter_address'));
            
            $this->session->set_userdata('twitter_address_verified',$twitter_address);
            echo 'ok';
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
        
    }
    
    
     /**
    * This is a callback function for ci form validation for chcking description contain email and phone number
    * if email or phone no exist it return false
    * 
    * @param mixed $s_description
    */
    function _invalid_text_description($s_description)
    {
      
       
      
        if($s_description!='')
        {
               // This  preg match for email exist or not
                $i_email_exist    =   preg_match('/([a-z0-9_-]+\.)*[a-z0-9_-]+(\.[a-z]{2,6}){1,2}/',$s_description); 

                //First check number having <space> and -
                preg_match_all('/[0-9][0-9-\s]{6,15}/',$text,$matches);
                $i_phno_exist   =   false ;
                foreach($matches[0] as $detected)
                {
                    //Remove <space>  and -  
                     preg_replace('/[\s-]/','',$detected);
                     // Then check if any number is 8 digit or more than dat
                     if(strlen($detected)>7)
                     {
                         $i_phno_exist  =   true ;
                         break;
                     }
                } 
                
               
                if($i_email_exist || $i_phno_exist)
                {
                    $this->form_validation->set_message('_invalid_text_description', 'Email and phone number are not allowed in %s .'); 
                   
                    return false;
                }
                else
                {
                    return true;
                }
                     
        }
        else
        {
            return true;
        }  
    }
    
  
	

    public function __destruct()

    {} 
    
}
