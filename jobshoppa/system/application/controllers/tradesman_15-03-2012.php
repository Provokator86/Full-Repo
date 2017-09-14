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

class Tradesman extends My_Controller
{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
        try
        { 
          parent::__construct(); 
          $this->data['title']="Dashboard";////Browser Title
		  $this->data['ctrlr'] = "home";
		  $this->data['i_lang_id'] = $this->i_default_language;
		  if(empty( $this->data['loggedin']) || decrypt($this->data['loggedin']['user_type_id'])!=2)
			{
				
				redirect(base_url()."home");
				exit;
			}
		  
		  $this->cls_msg=array();
		  $this->cls_msg["save_pwd"]="password changed successfully.";
		  $this->cls_msg["save_pwd_err"]="password changed could not saved.";
		  $this->cls_msg["wrong_pwd"]="existing password does not match.";
          
          $this->cls_msg["save_email_succ"]="Email changed successfully.";
          $this->cls_msg["save_email_err"]="Email changed could not saved.";
          
          $this->cls_msg["save_skill_succ"]="Skill and Qualification saved successfully.";
          $this->cls_msg["save_skill_err"]="Skill and Qualification could not saved.";
          
		  $this->cls_msg["save_contact"] = " contact details saved succesfully";
		  $this->cls_msg["save_profile"] = " Your profile has been updated.";
		  $this->cls_msg["save_profile_err"] = " profile details could not saved ";
          
		  $this->cls_msg["dob_err"]="Date of Birth is less than 18 years."; 
             
		  $this->cls_msg["save_album"] = " Image uploaded successfully.";
		  $this->cls_msg["save_album_err"] = " Image could not uploaded . ";
		  
		  
		  
		   $this->cls_msg["save_email_setting"]="email setting saved successfully.";
		  
		  $this->cls_msg["save_testi"]="testimonial saved successfully.";
		  $this->cls_msg["save_testi_err"]="testimonial saved failure.";
		  
		  $this->cls_msg["save_radar_succ"]="Job radar saved successfully.";
		  $this->cls_msg["save_radar_err"]="Job radar saved failure.";
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  $this->load->model('manage_tradesman_model','mod_trades');	
		  $this->load->model('job_model');	
		  
		  /* profile Image */
		  $this->allowedExt = 'jpg|jpeg|png';	
		  $this->uploaddir = $this->config->item('user_profile_image_upload_path');	
		  $this->thumbdir = $this->config->item('user_profile_image_thumb_upload_path');
		  $this->thumbDisplayPath = $this->config->item('user_profile_image_thumb_path');
		  $this->thumb_ht = $this->config->item('user_profile_photo_upload_thumb_height');	
		  $this->thumb_wd = $this->config->item('user_profile_photo_upload_thumb_width');
		  
		  $user_details = $this->data['loggedin'];
		  $this->data['name']	=	$user_details['user_name'];
		  $this->user_id 		=	decrypt($user_details['user_id']);
		  
		  /****** ALBUM IMAGE UPLOAD SETTINGS  ******/
		  $this->uploadDir = $this->config->item('trades_album_image_upload_path');	
		  $this->thumbDir = $this->config->item('trades_album_image_thumb_upload_path');
		  $this->t_ht = $this->config->item('trades_album_image_upload_thumb_height');	
		  $this->t_wd = $this->config->item('trades_album_image_upload_thumb_width');
		  
		 
		  /* job count list*/
		  $s_where = " WHERE n.i_tradesman_user_id = {$this->user_id} And n.i_status!=3 ";
		  $this->data['i_tot_quotes'] = $this->job_model->gettotal_quote_info($s_where);
		  
		  $s_where = " WHERE n.i_user_id = {$this->user_id}";
		  $this->data['i_watch_jobs'] = $this->job_model->gettotal_watchjob_info($s_where);		  
		  
		  $s_where = " WHERE n.i_tradesman_id = {$this->user_id}  AND n.i_status=1"; 
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
		  		  
		  $this->load->model('tradesman_model');
		  $this->data['profile_info'] = $this->tradesman_model->fetch_this($this->user_id);
		  //pr($this->data['profile_info']);
		  /* Radar Model*/
		  $this->load->model('radar_model');		  
		  $this->data['i_total_radar_job'] = $this->job_model->radar_job($this->user_id);
		  /**/
		  
		  /* add thick box css and js */
		  $this->add_js('js/thickbox.js');
		  $this->add_css('css/fe/thickbox.css');
		  $this->add_js('js/jquery.form.js');		
		
		  
		  if(in_array($this->router->method, $this->db->TRADESMAN_SUBSCRIPTION) && $this->data['site_setting']['i_subscrption_status']==1)
		  {
		  	
			if(time()>$this->data['profile_info']['i_account_expire_date'])
				redirect(base_url().'user/subscription');
			
		  }
		  		  
		  
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
			
			$user_details = $this->session->userdata('loggedin');
			//print_r($user_details);
			$this->data['name']	=	$user_details['user_name'];
			$this->data['user_id']=$user_details['user_id'];
			//$this->i_menu_id = 1;
			//$this->render('tradesman/dashboard');
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
			
			$this->data['breadcrumb'] = array('Dashboard'=>'');
			$this->data['user_details']	=	$this->mod_trades->fetch_this($this->user_id);
			
		    
			$this->data['dt_current_time'] = date("l d M, Y H:i",time());
			$s_where = " WHERE n.i_tradesman_user_id={$this->user_id} AND n.i_status!=3";
			$this->data['quote_details'] = $this->job_model->fetch_quote_multi($s_where,0,2);
			
			$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=4 AND n.i_is_deleted!=1"; 
			$limit	= $this->i_fe_page_limit;
			$this->data['progress_job_list']	= $this->job_model->fetch_multi($s_where,0,2);		
			
			$s_where = " WHERE n.i_user_id = {$this->user_id}"; 
			$this->data['job_watch_list']	= $this->job_model->fetch_watch_multi($s_where,0,2);	
			
			$s_where = " WHERE inv.i_tradesman_id = {$this->user_id} AND inv.i_status=1 "; 			
			$this->data['job_invitation_list']	= $this->job_model->fetch_job_invitation_multi($s_where,0,2);		
						
				
            
			//pr($this->data['quote_details']);
			$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=5 AND n.i_is_deleted!=1"; 			
		    $this->data['feedback_job_list']	= $this->job_model->fetch_multi($s_where,intval($start),$limit);		
			//echo $this->db->last_query(); exit;
			//$s_wh_pmb = " WHERE pd.i_receiver_id = {$this->user_id} AND pd.i_status=1 AND FROM_UNIXTIME( pd.i_date , '%Y-%m-%d')= CURDATE()";
			$s_wh_pmb = " WHERE pd.i_receiver_id = {$this->user_id} AND pd.i_status=1 AND  pd.i_receiver_view_status =0 ";
			$this->load->model('private_message_model');
			$this->data['new_msg'] = $this->private_message_model->gettotal_pmb_info($s_wh_pmb);
			
			/* check renew subscription*/			
			if($this->data['site_setting']['i_subscrption_status']==1)
			{
				$exp_date = strtotime ( '-7 day' , $this->data['profile_info']['i_account_expire_date'] ) ;
				$this->data['check_renew_link'] = (time()>$exp_date) ? 1 : 0;
				$this->data['check_subscribtion'] = (time()>$this->data['profile_info']['i_account_expire_date']) ? 1 : 0;
			}	
			
			/* end renew subscription */
			
			//pr($this->data['feedback_job_list']);
			$this->render('tradesman/dashboard');
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
			$this->i_sub_menu_id=3;
			$this->data['pathtoclass']=$this->pathtoclass;
			$user_details = $this->session->userdata('loggedin');
			$this->data['user_id']	=	$user_details['user_id'];
			$info	=	$this->mod_trades->fetch_this($this->user_id);
            
            $posted = array();
            $posted["txt_name"] = $info["s_name"] ;
            $posted["txt_username"] = $info["s_username"] ; 
            $posted["txt_contact"] = $info["s_contact_no"] ; 
            $posted["txt_fax"]  = $info["s_fax"] ; 
            $posted["txt_landline"] = $info["s_landline"] ; 
            $posted["txt_skype"] = $info["s_skype_id"] ; 
            $posted["txt_msn"] = $info["s_msn_id"] ; 
            $posted["txt_yahoo"] = $info["s_yahoo_id"] ; 
            $posted["txt_address"] = $info["s_address"] ; 
            $posted["opt_province_id"] = encrypt($info["opt_state"]) ;
            $posted["opt_city_id"] = encrypt($info["opt_city"]) ;
            $posted["i_zipcode_id"] = encrypt($info["opt_zip"]) ;
            $posted['txt_business_name'] = $info["s_business_name"] ;
            $posted["txt_dob"] = $info["i_dob"] ;   
            $posted["s_user_image"] = $info["s_user_image"] ; 
            $posted['txt_website'] = $info["s_website"] ; 
            $posted['txt_about_me'] = $info["s_about_me"] ; 
            $posted['txt_work_history'] = $info["s_work_history"] ; 
			$posted['s_zip'] = $info['s_postal_code'];
            
			
			//pr($posted,1);
			$image_exist	=	$info['s_user_image']; 
			$this->data['breadcrumb'] = array('Edit Profile'=>'');
			//print_r($this->data['info']);  exit;
			$s_wh = " WHERE n.i_user_id=".$this->user_id." ";
            
            
			$category_list	=	$this->mod_trades->fetch_all_category($s_wh,'','');
            $posted['opd_category'] = array();
			foreach($category_list as $val)
            {
                  $posted['opd_category'][]=encrypt($val['id']);
            }
            $posted['cnt_opt_cat'] = count($posted['opd_category'])  ;
			$this->data['posted'] =$posted;
			$this->add_css('css/fe/dd.css');
			$this->add_js('js/fe/jquery.dd.js');
			$this->load->model('city_model');
			$this->load->model('state_model');
			$this->load->model('zipcode_model');
			
			if($_POST)
			{
				
				
				$posted=array();
				//pr($_POST);
                $posted["txt_name"]			=   trim($this->input->post("txt_name"));
                $posted["txt_username"]     =   trim($this->input->post("txt_username"));
                $posted["txt_contact"]      =   trim($this->input->post("txt_contact"));
                $posted["txt_fax"]          =   trim($this->input->post("txt_fax"));
                $posted["txt_landline"]     =   trim($this->input->post("txt_landline"));
                $posted["txt_skype"]        =   trim($this->input->post("txt_skype"));
                $posted["txt_msn"]          =   trim($this->input->post("txt_msn"));
                $posted["txt_yahoo"]        =   trim($this->input->post("txt_yahoo"));
                
				$posted["txt_address"]		=   trim($this->input->post("txt_address"));
				$posted["opt_province_id"]	=   trim($this->input->post("opt_state"));
				$posted["opt_city_id"]		=   trim($this->input->post("opt_city"));
				$posted["i_zipcode_id"]		=   trim($this->input->post("opt_zip"));
				$posted["txt_dob"]          =   trim($this->input->post("txt_dob"));
				/* trade profile*/
				$posted['txt_website']		=	trim($this->input->post("txt_website"));
				$posted['txt_about_me']		=	trim($this->input->post("txt_about_me"));
				$posted['txt_business_name']=	trim($this->input->post("txt_business_name"));
                $posted['txt_work_history']=    trim($this->input->post("txt_work_history"));
				/* multiple category */
				$posted["opd_category"]    =     $this->input->post("opd_category"); 
				$posted["h_image_name"]		= 	trim($this->input->post("h_image_name"));
				
				

				$result_cat = array();
                        foreach($posted["opd_category"] as $val)
                        {
                           $result_cat[]    =    decrypt(trim($val));   
                        }	

				//$posted["h_image_name"]		= 	trim($this->input->post("h_image_name"));
				/////////////Image Uploading/////////////
				if(isset($_FILES['f_image']) && !empty($_FILES['f_image']['name']))
				{
					$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'f_image','','',$this->allowedExt);					
					$arr_upload_res = explode('|',$s_uploaded_filename);
				}
				
				//////////////Start Validation Process//////////////////
				$this->form_validation->set_rules('txt_name', 'name', 'required');
				$this->form_validation->set_rules('txt_username', 'provide username', 'required');
                $this->form_validation->set_rules('txt_contact', 'provide contact number', 'required');  
				$this->form_validation->set_rules('txt_address', 'address', 'required');
                $this->form_validation->set_rules('opt_state', 'select province', 'required');
				$this->form_validation->set_rules('opt_city', 'select city', 'required');
				$this->form_validation->set_rules('opt_zip', 'select postal code', 'required');
                $this->form_validation->set_rules('txt_business_name', 'provide business name', 'required');    
				$this->form_validation->set_rules('txt_about_me', 'provide about me', 'required');
				$this->form_validation->set_rules('opd_category[]', 'select category', 'required');
                $this->form_validation->set_rules('txt_dob', 'provide Date of Birth', 'required|callback_check_dob');

				 if($this->form_validation->run() == FALSE || ($arr_upload_res[0]==='err') )/////invalid
					{
						///Display the add form with posted values within it////
						$this->data["posted"]=$posted;
                        
					}
				else
					{
						
						$info=array();
						$info["s_name"]			=	$posted["txt_name"];
						
                        $info["s_contact_no"]   =   $posted["txt_contact"]; 
                        $info["s_fax"]          =   $posted["txt_fax"];
                        $info["s_landline"]     =   $posted["txt_landline"];
                        $info["s_skype_id"]     =   $posted["txt_skype"];
                        $info["s_msn_id"]       =    $posted["txt_msn"];
                        $info["s_yahoo_id"]     =    $posted["txt_yahoo"];
                        $info["s_address"]      =    $posted["txt_address"]; 
						$info["i_province_id"]	=	decrypt($posted["opt_province_id"]);
						$info["i_city_id"]		=	decrypt($posted["opt_city_id"]);
						$info["i_zipcode_id"]	=	decrypt($posted["i_zipcode_id"]);
						$info["i_edited_date"]	=	time();
						$info["s_website"]		=	$posted["txt_website"];	
						$info["s_about_me"]		=	$posted["txt_about_me"];		
						$info["s_business"]		=	$posted["txt_business_name"];    
                        $info["i_dob"]          =   convert_date_mdy_format($posted["txt_dob"]);  ////////This function written in helper.php
                        $info["s_work_history"] =   $posted["txt_work_history"]; 
                        			
						if(count($arr_upload_res)==0)
						{
							$info["s_user_image"] = 	$posted['h_image_name']; ////////store pervious image
						}
						else
						{
							$info["s_user_image"] = 	$arr_upload_res[2];     ////////store new uploaded image
						}

						
						//pr($info); exit;
					/* start  latitude and longitude  */
					$state = $this->state_model->fetch_this($info["i_province_id"]);
					$city = $this->city_model->fetch_this($info["i_city_id"]);
					$zipcode = $this->zipcode_model->fetch_this($info["i_zipcode_id"]);
					
				 	$address = utf8_encode($info["s_address"].','.$state['state'].','.$city['city'].','.$zipcode['postal_code']);					
					// call geoencoding api with param json for output
					$geoCodeURL = "http://maps.google.com/maps/api/geocode/json?address=".
								  urlencode($address)."&sensor=false";
					
					$result = json_decode(file_get_contents($geoCodeURL), true);					
					$info['s_lat'] = ($result["results"][0]["geometry"]["location"]["lat"]) ? @$result["results"][0]["geometry"]["location"]["lat"] : 0;
    				$info['s_lng'] = ($result["results"][0]["geometry"]["location"]["lng"]) ? @$result["results"][0]["geometry"]["location"]["lng"]:0;
					/* end  latitude and longitude  */
						
						
						//print_r($info); 				

							
						$i_newid 			    = 	$this->mod_trades->set_edit_profile($info,$this->user_id);
                        
						if(!empty($image_exist))
						{
							
						    $i_image			=	$this->mod_trades->update_profile_image($info,$this->user_id);
						}
						else 
						{
							
							$i_image			=	$this->mod_trades->insert_profile_image($info,$this->user_id);
						}
						
						$i_trade_details	=	$this->mod_trades->update_profile_details($info,$this->user_id);
						
						$i_cat_id			= $this->mod_trades->update_multiple_category($result_cat,$this->user_id);
						
						
						if($i_newid)////saved successfully
						{						
							
							if($arr_upload_res[0]==='ok')
							{
								get_image_thumb($this->uploaddir.$info["s_user_image"], $this->thumbdir, 'thumb_'.$info["s_user_image"],$this->thumb_ht,$this->thumb_wd,'');
								get_image_thumb($this->uploaddir.$info["s_user_image"], $this->thumbdir, 'thumb_slider_'.$info["s_user_image"],250,350,'');
							}		
							
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_profile"],'message_type'=>'succ'));
							redirect(base_url().'tradesman/edit_profile');
						}
						else///Not saved, show the form again
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_profile_err"],'message_type'=>'err'));
							$this->render('tradesman/edit_profile');
						}

					}					
			
			}			
			
			
			$this->render('tradesman/edit_profile');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
		
	public function edit_email()
    {
        try
        {
            $this->i_sub_menu_id=1;
            $user_details = $this->session->userdata('loggedin');
            $this->data['user_id']    =    $user_details['user_id'];
            $this->data['breadcrumb'] = array('Edit Email'=>'');   
			
			//pr($this->data['details']);
			
            if($_POST)
            {
                $posted=array();
                $posted["txt_email"]= trim($this->input->post("txt_email"));
                $posted["txt_new_email"]= trim($this->input->post("txt_new_email"));
                $posted["txt_con_email"]= trim($this->input->post("txt_con_email"));
                
                
                $this->form_validation->set_rules('txt_email', 'existing email', 'valid_email|required|callback_authentication_check');
                $this->form_validation->set_rules('txt_new_email', 'New email', 'valid_email|required|matches[txt_con_email]');
                $this->form_validation->set_rules('txt_con_email', 'Confirm email', 'valid_email|required');
               

                
                 
                 if($this->form_validation->run() == FALSE)/////invalid
                    {
                        
                       /* if($email_valid != 1)
                        {
                            $this->session->set_userdata(array('message'=>$this->cls_msg["wrong_email"],'message_type'=>'err'));
                        }
                        elseif($email_exist > 0)
                        {     
                             $this->session->set_userdata(array('message'=>$this->cls_msg["email_exist"],'message_type'=>'err'));
                        }     */
                        ///Display the add form with posted values within it////
                        $this->data["posted"]=$posted; 
 
                        //redirect(base_url().'tradesman/edit_email');  
                    }
                else
                    {
                        
                        $info=array();
                        $info["s_email"]    =$posted["txt_new_email"];

                        $i_newid = $this->mod_trades->update_info($info,$this->user_id);
                        if($i_newid)////saved successfully
                        {
                            $this->session->set_userdata(array('message'=>$this->cls_msg["save_email_succ"],'message_type'=>'succ'));    
                            redirect(base_url().'tradesman/edit_email');
                        }
                        else///Not saved, show the form again
                        {
                            $this->session->set_userdata(array('message'=>$this->cls_msg["save_email_err"],'message_type'=>'err'));
                             redirect(base_url().'tradesman/edit_email'); 
                        }
                        
                    
                    }    
                
            }
            else
            {
                 $details    =    $this->mod_trades->fetch_this($this->user_id); 
                 $this->data['posted']['txt_email'] = $details['s_email']; 
                 
            }
            
            $this->render('tradesman/edit_email');
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
    
    public function skills_qualifications()
    {
        try
        {
            $this->i_sub_menu_id=4;
            $user_details = $this->session->userdata('loggedin');
            $this->data['user_id']    =    $user_details['user_id'];
            $this->data['breadcrumb'] = array('My skills and Qualifications'=>'');   
            
            //pr($this->data['details']);
            
            if($_POST)
            {
                $posted=array();
                 $posted['txt_skills']        =    trim($this->input->post("txt_skills"));
                 $posted['txt_qualification']=    trim($this->input->post("txt_qualification"));

                 $this->form_validation->set_rules('txt_skills', 'add your skills', 'required');
                 $this->form_validation->set_rules('txt_qualification', 'provide your qualification,or any type of experience', 'required');
               

                
                 
                 if($this->form_validation->run() == FALSE)/////invalid
                    {
                       
                        $this->data["posted"]=$posted; 
                        //redirect(base_url().'tradesman/edit_email');  
                    }
                else
                    {
                        
                        $info=array();
                        $info["s_skills"]            =      $posted["txt_skills"];    
                        $info["s_qualification"]    =       $posted["txt_qualification"];
						$info["i_edit_date"]		= 		time();
		
                        $i_newid = $this->mod_trades->update_tradesman_info($info,$this->user_id);
                        if($i_newid)////saved successfully
                        {
                            $this->session->set_userdata(array('message'=>$this->cls_msg["save_skill_succ"],'message_type'=>'succ'));    
                            redirect(base_url().'tradesman/skills_qualifications');
                        }
                        else///Not saved, show the form again
                        {
                            $this->session->set_userdata(array('message'=>$this->cls_msg["save_skill_err"],'message_type'=>'err'));
                             redirect(base_url().'tradesman/skills_qualifications'); 
                        }
                        
                    
                    }    
                
            }
            else
            {
                 $info   =    $this->mod_trades->fetch_this($this->user_id); 
                 $posted['txt_skills']          =    $info['s_skills'] ;
                 $posted['txt_qualification']   =    $info['s_qualification'] ;
                 $this->data['posted']          =    $posted; 
            }
            
            $this->render('tradesman/skills_qualifications');
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
			$this->i_sub_menu_id=2;
			$user_details = $this->session->userdata('loggedin');
			$this->data['user_id']	=	$user_details['user_id'];
			$this->data['breadcrumb'] = array('Change Password'=>'');	
			if($_POST)
			{
				$posted=array();
                $posted["txt_password"]= trim($this->input->post("txt_password"));
				$posted["txt_new_password"]= trim($this->input->post("txt_new_password"));
				$posted["txt_confirm_password"]= trim($this->input->post("txt_confirm_password"));
				
				if(!empty($posted["txt_password"]) && !empty($posted["txt_new_password"]))
				{
					$this->form_validation->set_rules('txt_password', 'existing password', 'required|callback_authentication_check');
					$this->form_validation->set_rules('txt_new_password', 'New password', 'required|matches[txt_confirm_password]');
					$this->form_validation->set_rules('txt_confirm_password', 'Confirm password', 'required');
				}
				
				
				$user_data['s_password']	=	$posted["txt_password"];
				$is_pwd_correct	=	$this->mod_trades->check_password($user_data['s_password'],$this->user_id);
				 
				 if($this->form_validation->run() == FALSE || empty($is_pwd_correct))/////invalid
					{
						if(empty($is_pwd_correct))
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["wrong_pwd"],'message_type'=>'err'));
							redirect(base_url().'tradesman/change_password');
							//$this->render('tradesman/change_password');
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
						
						$i_newid = $this->mod_trades->set_new_password($info,$this->user_id);
						if($i_newid)////saved successfully
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_pwd"],'message_type'=>'succ'));	
							redirect(base_url().'tradesman/change_password');
						}
						else///Not saved, show the form again
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_pwd_err"],'message_type'=>'err'));
							$this->render('tradesman/change_password');
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
	
	
	
	
	 public function contact_details()
    {
        try
        {
			$this->i_sub_menu_id=5;
			
			$this->data['pathtoclass']=$this->pathtoclass;
			$user_details = $this->session->userdata('loggedin');
			$this->data['breadcrumb'] = array('Contact Details'=>'');	
			$this->data['user_id']	=	$user_details['user_id'];
			$this->data['contact_details']	=	$this->mod_trades->fetch_this($this->user_id);
			//print_r($this->data['contact_details']);
			$this->render('tradesman/contact_details');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
	
	 public function set_contact_details()
    {
        try
        {
			if($_POST)
			{
				$posted=array();
                $posted["txt_contact"]= trim($this->input->post("txt_contact"));
				$posted["txt_skype"]= trim($this->input->post("txt_skype"));
				$posted["txt_yahoo"]= trim($this->input->post("txt_yahoo"));
				$posted["txt_msn"]= trim($this->input->post("txt_msn"));
				
				$this->form_validation->set_rules('txt_contact', 'provide contact number', 'required');
				
				 if($this->form_validation->run() == FALSE)/////invalid
					{
						///Display the add form with posted values within it////
						$this->data["posted"]=$posted;
					}
				else
					{
						
						$info=array();
						$info["s_contact_no"]	=	$posted["txt_contact"];
						$info["s_skype_id"]		=	$posted["txt_skype"];
						$info["s_yahoo_id"]		=	$posted["txt_yahoo"];
						$info["s_msn_id"]		=	$posted["txt_msn"];
						
						$i_newid = $this->mod_trades->set_contact_details($info,$this->user_id);
						if($i_newid)////saved successfully
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_contact"],'message_type'=>'succ'));
							redirect(base_url().'tradesman/contact_details');
						}
						else///Not saved, show the form again
						{
							set_error_msg($this->cls_msg["save_err"]);
							$this->render('tradesman/contact_details/');
						}
						
					
					}	
				
			}
			
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
	
	
	/* my album section */
	
	 public function album()
    {
        try
        {
			$this->i_sub_menu_id=5;
			
			$this->allow_ext = 'jpg|jpeg|png|gif';
			
			$this->data['pathtoclass']=$this->pathtoclass;
			$user_details = $this->session->userdata('loggedin');
			//print_r($user_details);
			$user_id	=	decrypt($user_details['user_id']);
			$this->data['breadcrumb'] = array('Upload Your Photo'=>'');	
			
			if($_POST)
			{
			
				
				//echo 'hi';
				$posted=array();
				
				
				if(isset($_FILES['f_image']) && !empty($_FILES['f_image']['name']))
					{
						$s_uploaded_filename = get_file_uploaded( $this->uploadDir,'f_image','','',$this->allow_ext);					
						$arr_upload_res = explode('|',$s_uploaded_filename);
					}
					
				
				//print_r($arr_upload_res); exit;
				 if(($arr_upload_res[0]==='err'))/////invalid
					{
						///Display the add form with posted values within it////
						//$this->data["posted"]=$posted;
					}
				else
					{
						
						$info=array();
						//$info["s_title"]		=	$posted["txt_title"];
						$info["s_image"]		=	$arr_upload_res[2];
						//$info['i_user_id']		=	$this->user_id;
						$info['i_uploaded_date']=	time();
						
						//print_r($info); exit;
						$i_newid = $this->mod_trades->upload_album_photo($info,$user_id);
						if($i_newid)////saved successfully
						{
							if($arr_upload_res[0]==='ok')
							{
								get_image_thumb($this->uploadDir.$info["s_image"], $this->thumbDir, 'thumb_'.$info["s_image"],$this->t_ht,$this->t_wd,'');
								get_image_thumb($this->uploadDir.$info["s_image"], $this->thumbDir, 'thumb_slider_'.$info["s_image"],250,350,'');
							}	
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_album"],'message_type'=>'succ'));
							redirect(base_url().'tradesman/album');
						}
						else///Not saved, show the form again
						{
							set_error_msg($this->cls_msg["save_err"]);
							$this->render('tradesman/album');
						}
						
					
					}	
				
			
			}
			
		    
			$s_where = " WHERE i_user_id=".$user_id." "; 
			//$start = ($this->uri->segment($this->i_uri_seg)) ? $this->uri->segment($this->i_uri_seg) : 0;
			//$limit	= 5;
		    $this->data['images'] =  $this->mod_trades->get_album_images($s_where);

			//$i_total_no = $this->mod_trades->get_total_album_images($s_where);
			//$s_pageurl = base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
			//$i_uri_segment = $this->i_fe_uri_segment;
			//$this->data['pagination'] = $this->get_fe_pagination($s_pageurl,$i_total_no,$limit,$i_uri_segment);
			//print_r($this->data['pagination']);
			  
			//print_r($this->data['images']);
			$this->render('tradesman/album');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/* open confirm box*/
	function chk_delete($i_image_id='')
	{
		//$i_image_id =  decrypt($i_image_id);
		$this->data['i_image_id'] = $i_image_id;
		$this->load->view('fe/tradesman/chk_del.tpl.php',$this->data);
	}
	
	/* delete photo*/
	function delete_photo()
	{
		$btn_sub = trim($this->input->post("btn_sub"));
		
		if($btn_sub == 'Yes')
		{
			$info = array();
			$i_img_id = decrypt(trim($this->input->post("h_img_id")));
			
			$info['i_is_deleted'] = 1;
			$i_newid = $this->mod_trades->delete_album_photo($i_img_id);
			if($i_newid)
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del"],'message_type'=>'succ'));
				$msg = '1|Photo deleted successfully';
			}
			else
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del_err"],'message_type'=>'err'));
				$msg = '2|Photo delete unsuccessfull';
			}
		}
		else
		{
			$msg = '';
		}	
		echo $msg;			
	}
	
	
	
	/* open confirm box*/
	function chk_invite_job_delete($i_job_id='')
	{
		//$i_image_id =  decrypt($i_image_id);
		$this->data['i_job_id'] = $i_job_id;
		$this->load->view('fe/tradesman/chk_invite_job_del.tpl.php',$this->data);
	}
	
	/* delete job*/
	function delete_invite_job()
	{
		$btn_sub = trim($this->input->post("btn_sub"));
		
		if($btn_sub == 'Yes')
		{
			$info = array();
			$i_job_id = decrypt($this->input->post("h_job_id"));
			$i_tradesman_id = $this->input->post("h_tradesman_id");
			$info = array();
			$info['i_status'] = 2;
			$cond = array('i_tradesman_id '=>$this->user_id ,'i_job_id'=>$i_job_id);
			//pr($cond,1);
			$table = $this->db->JOB_INVITATION;
			$i_newid = $this->job_model->set_data_update($table,$info,$cond);
			if($i_newid)
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del"],'message_type'=>'succ'));
				$msg = '1|Denied sucessfully';
			}
			else
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del_err"],'message_type'=>'err'));
				$msg = '2|Not denied sucessfully';
			}
		}
		else
		{
			$msg = '';
		}	
		echo $msg;			
	}
	
	
		
	
	/* email settings for tradesman */
	 public function email_settings()
    {
        try
        {
			$this->i_sub_menu_id=19;
			
			$this->data['pathtoclass']=$this->pathtoclass;
			$user_details = $this->session->userdata('loggedin');
			$this->data['breadcrumb'] = array('Email Settings'=>'');	
			$this->data['user_id']	=	$user_details['user_id'];
			if($_POST)
			{
				$posted	=	array();
				$posted["chk_job_ivitations"]			=	trim($this->input->post("chk_job_ivitations"));
				$posted["chk_buyer_posted_msg"]			=	trim($this->input->post("chk_buyer_posted_msg"));
				$posted["chk_job_radar_search"]			=	trim($this->input->post("chk_job_radar_search"));
				$posted["chk_buyer_awarded_job"]		=	trim($this->input->post("chk_buyer_awarded_job"));
				$posted["chk_buyer_provide_feedback"]	=	trim($this->input->post("chk_buyer_provide_feedback"));
				$posted["chk_buyer_terminate_job"]		=	trim($this->input->post("chk_buyer_terminate_job"));
				$posted["chk_buyer_cancel_job"]			=	trim($this->input->post("chk_buyer_cancel_job"));
				
				//$this->form_validation->set_rules('chk_job_ivitations', 'select Job Invitations from Buyer.', 'required');
				
				if(empty($posted))/////invalid
					{
						///Display the add form with posted values within it////
						$this->data["posted"]=$posted;
					}
				else
				{
					
						
						$info=array();
						$info["chk_job_ivitations"]				=	$posted["chk_job_ivitations"];
						$info["chk_buyer_posted_msg"]			=	$posted["chk_buyer_posted_msg"];
						$info["chk_job_radar_search"]			=	$posted["chk_job_radar_search"];
						$info["chk_buyer_awarded_job"]			=	$posted["chk_buyer_awarded_job"];
						$info["chk_buyer_provide_feedback"]		=	$posted["chk_buyer_provide_feedback"];
						$info["chk_buyer_terminate_job"]		=	$posted["chk_buyer_terminate_job"];
						$info["chk_buyer_cancel_job"]			=	$posted["chk_buyer_cancel_job"];
						
						//print_r($info); exit;
						
						$i_newid = $this->mod_trades->set_email_settings($info,$this->user_id);
						if($i_newid)////saved successfully
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_email_setting"],'message_type'=>'succ'));
							redirect(base_url().'tradesman/email_settings');
						}
						else///Not saved, show the form again
						{
							set_error_msg($this->cls_msg["save_err"]);
							$this->render('tradesman/email_settings/');
						}
						
					
					
				}	
			}
			
			$s_user_id	=	" WHERE n.i_user_id=".$this->user_id." ";			
			$this->data['email_key']	=	$this->mod_trades->fetch_email_keys($s_user_id,'','');
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
   
   
   
	/* fetch all jobs*/
   public function quote_jobs()
   {
   		try
		{
			$this->i_sub_menu_id	=	7;
			$this->data['breadcrumb'] = array('Quotes'=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			
			ob_start();
			$this->quote_jobs_pagination_ajax();
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
   
   /* Ajax pagination for all jobs */
	function quote_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_tradesman_user_id = {$this->user_id} And n.i_status!=3 "; 

		$limit	= $this->i_fe_page_limit;			
		
		$this->data['job_list']	= $this->job_model->fetch_quote_multi($s_where,intval($start),$limit);		
		//pr($this->data['job_list']);
		$total_rows = $this->job_model->gettotal_quote_info($s_where);	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'tradesman/quote_jobs_pagination_ajax/';
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
		
		$this->load->view('fe/tradesman/ajax_quote_jobs.tpl.php',$this->data);
			
	}   
	
	
	/* fetch all jobs*/
   public function watch_list()
   {
   		try
		{
			$this->i_sub_menu_id	=	8;
			$this->data['breadcrumb'] = array('Watching Only'=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;			
			ob_start();
			$this->watch_list_pagination_ajax();
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
   
   /* Ajax pagination for all jobs */
	function watch_list_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_user_id = {$this->user_id}"; 

		$limit	= $this->i_fe_page_limit;			
		
		$this->data['job_list']	= $this->job_model->fetch_watch_multi($s_where,intval($start),$limit);		
		//pr($this->data['job_list']);
		$total_rows = $this->job_model->gettotal_watchjob_info($s_where);	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'tradesman/watch_list_pagination_ajax/';
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
		
		$this->load->view('fe/tradesman/ajax_watch_list.tpl.php',$this->data);			
	}   	
	
	
	
	
	/* fetch all jobs*/
   public function feedback_provided()
   {
   		try
		{
			$this->i_sub_menu_id	=	16;
			$this->data['breadcrumb'] = array('Reviews Provided'=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			
			ob_start();
			$this->feedback_provided_pagination_ajax();
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
   
   /* Ajax pagination for all jobs */
	function feedback_provided_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_receiver_user_id = ".$this->user_id." AND n.i_status != 0  AND n.i_feedback_complete_status=0"; 	

		$limit	= $this->i_fe_page_limit;			
		
		$this->data['job_list']	= $this->mod_feed->fetch_multi($s_where,intval($start),$limit);		
		$total_rows = $this->mod_feed->gettotal_info($s_where);	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'tradesman/feedback_provided_pagination_ajax/';
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
		
		$this->load->view('fe/tradesman/ajax_feedback_provided.tpl.php',$this->data);
			
	}  	
	
	
	
	
	
	/* job invitation */
	 public function job_invitation()
   {
   		try
		{
			
			$this->i_sub_menu_id	=	9;
			$this->data['breadcrumb'] = array('Job Invitations'=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			$this->data['i_tradesman_id'] = $this->user_id;
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
   
   /* Ajax pagination for all jobs */
	function invite_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE inv.i_tradesman_id = {$this->user_id} AND inv.i_status=1 "; 

		$limit	= $this->i_fe_page_limit;			
			
		$this->data['job_list']	= $this->job_model->fetch_job_invitation_multi($s_where,intval($start),$limit);		
		//pr($this->data['job_list']);
		$total_rows = $this->job_model->gettotal_job_invitation(" WHERE inv.i_tradesman_id = {$this->user_id} AND inv.i_status=1");	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'tradesman/invite_jobs_pagination_ajax/';
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

	
		$config['div'] = '#job_list';

		$this->jquery_pagination->initialize($config);
		//$this->data['page_links'] = preg_replace('/<delete>.*?<\/delete>/s','',$this->jquery_pagination->create_links());
		$this->data['page_links'] = $this->jquery_pagination->create_links();
		$this->data['total_rows'] = $total_rows;
		//$this->data['current_page'] = $page;
		
		$this->load->view('fe/tradesman/ajax_invite_jobs.tpl.php',$this->data);
			
	}   
	
	
	
	
	
	
	
   public function frozen_jobs()
   {
   		try
		{
			
			$this->i_sub_menu_id	=	14;
			$this->data['breadcrumb'] = array('Frozen Jobs'=>'');	
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
   
   /* Ajax pagination for all jobs */
	function frozen_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=8 AND n.i_is_deleted!=1"; 

		$limit	= $this->i_fe_page_limit;			
			
		$this->data['job_list']	= $this->job_model->fetch_multi($s_where,intval($start),$limit);		
		//pr($this->data['job_list']);
		$total_rows = $this->job_model->gettotal_info($s_where);	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'tradesman/frozen_jobs_pagination_ajax/';
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
	
		$config['div'] = '#job_list';

		$this->jquery_pagination->initialize($config);
		$this->data['page_links'] = $this->jquery_pagination->create_links();
		$this->data['total_rows'] = $total_rows;
		
		$this->load->view('fe/tradesman/ajax_frozen_jobs.tpl.php',$this->data);
			
	}   	
	
	
   public function pending_jobs()
   {
   		try
		{
			
			$this->i_sub_menu_id	=	11;
			$this->data['breadcrumb'] = array('Pending Jobs'=>'');	
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
   
   /* Ajax pagination for all jobs */
	function pending_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=11 AND n.i_is_deleted!=1 "; 

		$limit	= $this->i_fe_page_limit;			
			
		$this->data['job_list']	= $this->job_model->fetch_multi($s_where,intval($start),$limit);		
		//pr($this->data['job_list']);
		$total_rows = $this->job_model->gettotal_info($s_where);	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'tradesman/pending_jobs_pagination_ajax/';
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

	
		$config['div'] = '#job_list';

		$this->jquery_pagination->initialize($config);
		$this->data['page_links'] = $this->jquery_pagination->create_links();
		$this->data['total_rows'] = $total_rows;
		
		$this->load->view('fe/tradesman/ajax_pending_jobs.tpl.php',$this->data);
			
	}   	
	
	
	
	public function completed_jobs()
   {
   		try
		{			
			$this->i_sub_menu_id	=	13;
			$this->data['breadcrumb'] = array('Completed Jobs'=>'');	
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
   
   /* Ajax pagination for all jobs */
	function completed_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=6 AND n.i_is_deleted!=1 "; 

		$limit	= $this->i_fe_page_limit;			
			
		$this->data['job_list']	= $this->job_model->fetch_multi($s_where,intval($start),$limit);		
		//pr($this->data['job_list']);
		$total_rows = $this->job_model->gettotal_info($s_where);	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'tradesman/completed_jobs_pagination_ajax/';
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

	
		$config['div'] = '#job_list';

		$this->jquery_pagination->initialize($config);
		$this->data['page_links'] = $this->jquery_pagination->create_links();
		$this->data['total_rows'] = $total_rows;
		
		$this->load->view('fe/tradesman/ajax_completed_jobs.tpl.php',$this->data);
			
	}   	
	
	
	
	
	
	function progress_jobs()
	{
   		try
		{			
			$this->i_sub_menu_id	=	12;
			$this->data['breadcrumb'] = array('In Progress'=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			$this->data['i_tradesman_id'] = $this->user_id;
			ob_start();
			$this->progree_jobs_pagination_ajax();
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
	
	/* Ajax pagination for all jobs */
	function progree_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=4 AND n.i_is_deleted!=1"; 

		$limit	= $this->i_fe_page_limit;			
			
		$this->data['job_list']	= $this->job_model->fetch_multi($s_where,intval($start),$limit);		
		//pr($this->data['job_list']);
		$total_rows = $this->job_model->gettotal_info($s_where);	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'tradesman/progree_jobs_pagination_ajax/';
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

	
		$config['div'] = '#job_list';

		$this->jquery_pagination->initialize($config);
		$this->data['page_links'] = $this->jquery_pagination->create_links();
		$this->data['total_rows'] = $total_rows;
		
		$this->load->view('fe/tradesman/ajax_progress_jobs.tpl.php',$this->data);
			
	} 	
	
	
	
	
	
	
	
	
    function deny_job($i_job_id=0)
	{
		//$this->data['i_tradesman_id'] = $i_tradesman_id;
		$this->data['i_job_id'] = $i_job_id;
		$this->data['job_details'] = $this->job_model->fetch_this($this->data['i_job_id'],$this->i_default_language);
		
		$this->load->view('fe/tradesman/deny_job.tpl.php',$this->data);
	}
   
	function deny_job_update()
	{
		$btn_sub = trim($this->input->post("btn_sub"));
		if($btn_sub == 'Yes')
		{
			$info = array();
			$i_job_id = $this->input->post("h_job_id");
			$i_tradesman_id = $this->input->post("h_tradesman_id");
			$i_quote_id = $this->input->post("h_quote_id");
			//pr($_POST);
			$info = array();
			$info['i_status'] = 3;
			//$cond = array('id '=>$this->user_id ,'i_job_id'=>$i_job_id);
			$cond = array('id '=>$i_quote_id);
			//pr($cond);
			$table = $this->db->JOBQUOTES;
			$i_newid = $this->job_model->set_data_update($table,$info,$cond);
			//pr($i_newid);
			//exit;
			$info = array();
			$info['i_status'] = 1;
			$info['i_assigned_date'] = '';
			$info['i_tradesman_id'] = '';
			$info['i_quote_id'] = 0;
			$table = $this->db->JOBS;
			$cond = array('id '=>$i_job_id);
			$i_new_id = $this->job_model->set_data_update($table,$info,$cond);
			if($i_new_id)
			{
				/* for job deny mail to the user */
				
			   $this->load->model('manage_buyers_model');
			   $job_details = $this->job_model->fetch_this($i_job_id);
			   //echo '==========='.$i_tradesman_id;exit;
			  
			   $buyer_details = $this->manage_buyers_model->fetch_this($job_details['i_buyer_user_id']);
			   $trades_details = $this->manage_buyers_model->fetch_this($i_tradesman_id);
			  
			   $this->load->model('auto_mail_model');
			   $content = $this->auto_mail_model->fetch_contact_us_content('tradesman_denied_job_offer','buyer');	
			   $mail_subject = $content['s_subject'];		
			   
			   $filename = $this->config->item('EMAILBODYHTML')."common.html";
			   $handle = @fopen($filename, "r");
			   $mail_html = @fread($handle, filesize($filename));				
				//print_r($content); exit;
				if(!empty($content))
				{							
					$description = $content["s_content"];
					$description = str_replace("[Buyer name]",$buyer_details['s_username'],$description);
					$description = str_replace("[job title]",$job_details['s_title'],$description);	
					$description = str_replace("[service professional name]",$trades_details['s_username'],$description);
					$description = str_replace("[budget amount]",$job_details['s_budget_price'],$description);
					$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);		
					
					$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
				}
				unset($content);
				//echo $this->data['loggedin']['user_email'];	
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
								
				$this->email->to($buyer_details['s_email']);
				
				$this->email->subject( $mail_subject);
				$this->email->message($mail_html);
				
				if(SITE_FOR_LIVE)///For live site
				{				
					$i_nwid = $this->email->send();	
															
				}
				else{
					$i_nwid = TRUE;				
				}
				
				/// Mailing code...[end]					
			/* end job deny mail to the user */					
			  
			
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del"],'message_type'=>'succ'));
				$msg = '1|Denied sucessfully';
			}
			else
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del_err"],'message_type'=>'err'));
				$msg = '2|Not denied sucessfully';
			}
		}
		else
		{
			$msg = '';
		}	
		echo $msg;			
	}
	
    function confirm_job_complete($i_job_id=0)
	{
		//$this->data['i_tradesman_id'] = $i_tradesman_id;
		$this->data['i_job_id'] = $i_job_id;
		$this->data['job_details'] = $this->job_model->fetch_this($this->data['i_job_id']);
		
		$this->load->view('fe/tradesman/confirm_job_complete.tpl.php',$this->data);
	}
   
	function complete_job_update()
	{
		$btn_sub = trim($this->input->post("btn_sub"));
		if($_POST)
		{
			$info = array();
			$i_job_id = $this->input->post("h_job_id");
			//$i_tradesman_id = $this->input->post("h_tradesman_id");
			
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
				
				
			   /* for job quote mail to the user */
			   $this->load->model('manage_buyers_model');
			   $job_details = $this->job_model->fetch_this($i_job_id);
			   //echo '==========='.$i_tradesman_id;exit;
			   $buyer_details = $this->manage_buyers_model->fetch_this($job_details['i_buyer_user_id']);
			   
			   $s_wh_id = " WHERE n.i_user_id=".$job_details['i_buyer_user_id']." ";
			   $buyer_email_key = $this->manage_buyers_model->fetch_email_keys($s_wh_id);
			   $is_mail_need = in_array('tradesman_feedback',$buyer_email_key);
	  			
			   if($is_mail_need)
			   {
			   
			   $this->load->model('auto_mail_model');
			   $content = $this->auto_mail_model->fetch_contact_us_content('tradesman_completed_job','buyer');	
			   $mail_subject = $content['s_subject'];		
			   
			   $filename = $this->config->item('EMAILBODYHTML')."common.html";
			   $handle = @fopen($filename, "r");
			   $mail_html = @fread($handle, filesize($filename));				
				//print_r($content); exit;
				if(!empty($content))
				{							
					$description = $content["s_content"];
					$description = str_replace("[Buyer name]",$buyer_details['s_username'],$description);
					$description = str_replace("[job title]",$job_details['s_title'],$description);	
					$description = str_replace("[Service professional name]",$job_details['s_tradesman_name'],$description);
					$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);		
					
					$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
				}
				unset($content);
				//echo $this->data['loggedin']['user_email'];	
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
								
				$this->email->to($buyer_details['s_email']);
				
				$this->email->subject( $mail_subject);
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
				
			/* end job quote mail to the user */					
			  }
			
			
			
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del"],'message_type'=>'succ'));
				$msg = '1|'.'Your request has been sent.';
			}
			else
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del_err"],'message_type'=>'err'));
				$msg = '2|'.'Your request has not been sent.';
			}
		}
		else
		{
			$msg = '';
		}	
		echo $msg;			
	}	
   
    function confirm_accept_job($i_job_id=0)
	{
		//$this->data['i_tradesman_id'] = $i_tradesman_id;
		$this->data['i_job_id'] = $i_job_id;
		$this->data['job_details'] = $this->job_model->fetch_this($this->data['i_job_id']);
		
		$this->load->view('fe/tradesman/confirm_accept_job.tpl.php',$this->data);
	}
   
    function pay_job($i_job_id=0)
	{
		/* for waiver commission */
		$this->load->model('commission_waiver_model');
		$this->load->model('recommend_model');
		$s_where = " WHERE i_is_active=1";
		$waiver = $this->commission_waiver_model->fetch_multi($s_where);
		$waiver_comm = $waiver[0]['i_waiver_commission'];
		$s_where = " WHERE n.i_referrer_id={$this->user_id} AND n.i_is_active=1 AND n.i_waiver_used=0";
		$recom_list = $this->recommend_model->fetch_multi($s_where);
		$tot_recomm = $this->recommend_model->gettotal_info($s_where);
	    $i_job_id = decrypt($i_job_id);
		$i_tradesman_id = $this->user_id;
		
		$this->load->model('commission_slab_model');
		$s_where = " WHERE 	i_is_active=1";
		$comm = $this->commission_slab_model->fetch_multi($s_where);
		
		$site_settings = $this->mod_site_setting->fetch_this(NULL);
		$s_where = " WHERE 	i_tradesman_user_id ={$this->user_id} AND i_job_id ={$i_job_id}";
		$job_details = $this->job_model->fetch_quote_multi($s_where,0,1);
		//pr($job_details); exit;
		$tot_amt = number_format(($job_details[0]['d_quote']*$comm[0]['s_commission_slab_100'])/100, 2, '.', '');		

		//echo $tot_recomm.'===='.$waiver_comm;
		if($tot_recomm>=$waiver_comm)
		{
			//exit;
			$info['i_status '] = 4;		
			//$info['i_status '] = 8;		
			$table = $this->db->JOBS;
			$cond  = array('id '=>$i_job_id);
			$i_newid = $this->job_model->set_data_update($table,$info,$cond);
			
			if($i_newid)
			{		
				/* to update tradesman won job after successful payment*/
				$this->mod_trades->update_tradesman_won_job($i_tradesman_id);				

				/* insert data to job history and stattus change*/
				
				$arr1 = array();
				$arr1['i_job_id']  =  $i_job_id;
				$arr1['i_user_id'] =  $this->user_id;
				$arr1['s_message'] =  'job_accepted';
				$arr1['i_created_date'] =  time();
				$table = $this->db->JOB_HISTORY;
				$this->job_model->set_data_insert($table,$arr1);	
				/*============*/
				$arr1 = array();
				$arr1['i_job_id']  =  $i_job_id;
				$arr1['i_user_id'] =  $this->user_id;
				$arr1['s_status']  =  'In Progress';
				$arr1['i_created_date'] =  time();
				$table = $this->db->JOB_STATUS_HISTORY;
				$this->job_model->set_data_insert($table,$arr1);	
				/* end */
				
				$arr1 = array();
				$arr1["i_job_id"] 	  = $i_job_id;
				$arr1['i_user_id'] 	  =  $this->user_id;
				$arr1['d_waiver_amt'] =  $tot_amt;
				$arr1['i_created_on'] =  time();
				$table = $this->db->WAIVER_PAYMENT;
				$this->job_model->set_data_insert($table,$arr1);	
				
				/* update user_referrer table*/
				if($recom_list)
				{
					$i=1;
					$table = $this->db->REFERRER;
					$arr1 = array();
					$arr1["i_waiver_used"] = 1;
					foreach($recom_list as $val)
					{
						 if($i>$waiver_comm)
						 	break;	
						 $cond  = array('id '=>$val['id']);
						 $this->job_model->set_data_update($table,$arr1,$cond);		
					 	 $i++; 				
					}
					
				}
				
				/* end of user_referrer table */
				
			   /* for job quote mail to the user */
			   $this->load->model('manage_buyers_model');
			   $this->load->model('tradesman_model');
			   $s_where = " WHERE n.id={$i_job_id}";
			   $job_details = $this->job_model->fetch_multi($s_where,0,1);
			   
			   //echo '==========='.$i_tradesman_id;exit;
			   $buyer_details = $this->manage_buyers_model->fetch_this($job_details[0]['i_buyer_user_id']);
			   $tradesman_details = $this->tradesman_model->fetch_this($i_tradesman_id);
			   
			   $this->load->model('auto_mail_model');
			   $content = $this->auto_mail_model->fetch_contact_us_content('waiver_payment_sucess','tradesman');	
			   $filename = $this->config->item('EMAILBODYHTML')."common.html";
			   $handle = @fopen($filename, "r");
			   $mail_html = @fread($handle, filesize($filename));				
				//print_r($content); exit;
				if(!empty($content))
				{			
					$description = $content["s_content"];
					$description = str_replace("[service professional]",$job_details[0]['s_username'],$description);
					$description = str_replace("[amount]",$tot_amt,$description);	
					$description = str_replace("[job title]",$job_details[0]['s_title'],$description);	
					$description = str_replace("[Buyer name]",$buyer_details['s_username'],$description);	
					$description = str_replace("[Buyer email]",$buyer_details['s_email'],$description);	
					$description = str_replace("[Buyer phone number]",$buyer_details['s_contact_no'],$description);	
					$description = str_replace("[Buyer skype IM]",$buyer_details['s_skype_id'],$description);	
					$description = str_replace("[Buyer address]",$buyer_details['s_address'],$description);	
					$description = str_replace("[Buyer county]",$buyer_details['s_state'],$description);	
					$description = str_replace("[Buyer city]",$buyer_details['s_city'],$description);	
					$description = str_replace("[Buyer post code]",$buyer_details['s_zip'],$description);	
					$description = str_replace("[invoice no.]",$invoice_no,$description);
					$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);	
					
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
								
				$this->email->to($tradesman_details['s_email']);
				
				
				$this->email->subject($content['s_subject']);
				
				unset($content);
				$this->email->message($mail_html);
				
				//$this->email->attach($attachment_pdf);
				if(SITE_FOR_LIVE)///For live site
				{				
					$i_nwid = $this->email->send();																
				}
				else
				{
					$i_nwid = TRUE;				
				}				
				
				$this->session->set_userdata(array('message'=>'Congratulations! You have earned a commission waiver, please check your inbox for client contact details or view these details in your Jobs in progress section.','message_type'=>'succ'));
				redirect(base_url().'home/message');
                
			 }			
		}
		/* End of waiver payment*/			
		
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
			$amount 			= $tot_amt;
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
			
			if($ack=="SUCCESS")
			{
				$info['i_status '] = 4;
				$table = $this->db->JOBS;
				$cond  = array('id '=>$i_job_id);
				$i_newid = $this->job_model->set_data_update($table,$info,$cond);
				if($i_newid)
				{
					/* to update tradesman won job after successful payment*/
					$this->mod_trades->update_tradesman_won_job($i_tradesman_id);
					/* to update buyer awarded job after successful payment*/
					$this->load->model('manage_buyers_model');
					$this->manage_buyers_model->update_awarded_job($job_details[0]['job_details']['i_buyer_user_id']);
								
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
					
					/* insert data into payment history */	
					$s_where = " WHERE 	i_tradesman_user_id ={$i_tradesman_id} AND i_job_id ={$i_job_id}";
					$job_details = $this->job_model->fetch_quote_multi($s_where,0,1);
					$arr1 = array();
					$arr1['i_job_id']  		=  $i_job_id;
					$arr1['i_user_id'] 		=  $i_tradesman_id;
					$arr1['i_payment_date'] =  time();	
					$arr1['d_quote_amount'] = $job_details[0]['d_quote'];
					$arr1['d_pay_amount']   = $tot_amt;
					$arr1['s_transaction_id']= '';
					$table = $this->db->JOB_PAYMENT_HISTORY;	
					$inv_id = $this->job_model->set_data_insert($table,$arr1);
					
					$inv['i_invoice_no'] = 10000+intval($inv_id);
					$cond = array('id'=>$inv_id);
					$table = $this->db->JOB_PAYMENT_HISTORY;
					$i_newid = $this->job_model->set_data_update($table,$inv,$cond);					
					/* end */	
					
					
					/*
					** for invoice generate and attach it to mail 
					**
					*/			
				
					$s_wh = " WHERE n.id=".$i_job_id." ";
					$info	=	$this->job_model->fetch_invoice_details($s_wh);
					//pr($info,1);exit;
					$this->load->library('Text_price_format');
					$currency_object = new Text_price_format();
					//$customer_name 	= $info[0]['s_username'];
					$customer_name 	= $info[0]['s_business_name'];
					$address 		= $info[0]['s_address'];
					$state 			= $info[0]['s_state'];
					$city 			= $info[0]['s_city'];
					$postal 		= $info[0]['s_postal_code'];
					$payment_date	= $info[0]['dt_payment_date'];
					$job_title 		= $info[0]['s_title'];
					$job_cost		= $info[0]['s_budget_price'];
					//$paid_amount	= doubleval($info[0]['s_paid_amount']);
					
					//$paid_amount	= number_format($info[0]['s_budget_price'], 2, '.', '');
					$paid_amount	= number_format($tot_amt, 2, '.', '');
					//echo 'aa';
					//exit;
					$quote_price = number_format($job_details[0]['d_quote'], 2, '.', '');
					
					$paid_amount_word = convert_number($paid_amount);
					//echo $paid_amount.'======='.$paid_amount_word ;exit;
					//$paid_amount_word=$currency_object ->get_bd_amount_in_text($info[0]['s_paid_amount']);
					$invoice_no	=	$info[0]['i_invoice_no'];
					$this->load->model('commission_slab_model');
					$s_where = " WHERE 	i_is_active=1";
					$comm = $this->commission_slab_model->fetch_multi($s_where);	
					$commission = $comm[0]['s_commission_slab_100'];	
				   
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
																								  <td width="31%" align="left" valign="top">Job Type : </td>
																								  <td width="69%" valign="top" style="color:#616161;"> '.$job_title.' </td>
																							</tr>
																							<tr>
																								  <td valign="top" align="left"> Job Cost : </td>
																								  <td style="color:#616161;" valign="top"> '.$quote_price.' </td>
																							</tr>
																							<tr>
																								  <td valign="top" align="left"> Commission : </td>
																								  <td style="color:#616161;" valign="top">@ '.$commission.'% </td>
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
					   $this->load->model('manage_buyers_model');
					   $this->load->model('tradesman_model');
					   $s_where = " WHERE n.id={$i_job_id}";
					   $job_details = $this->job_model->fetch_multi($s_where,0,1);
					   
					   //echo '==========='.$i_tradesman_id;exit;
					   $buyer_details = $this->manage_buyers_model->fetch_this($job_details[0]['i_buyer_user_id']);
					   $tradesman_details = $this->tradesman_model->fetch_this($i_tradesman_id);
					   
					   $this->load->model('auto_mail_model');
					   $content = $this->auto_mail_model->fetch_contact_us_content('payment_sucess','tradesman');	
					   
						$filename = $this->config->item('EMAILBODYHTML')."common.html";
						$handle = @fopen($filename, "r");
						$mail_html = @fread($handle, filesize($filename));				
						//print_r($content); exit;[invoice no.]
						if(!empty($content))
						{
							$description = $content["s_content"];
							$description = str_replace("[service professional]",$job_details[0]['s_username'],$description);
							$description = str_replace("[amount]",$paid_amount,$description);	
							$description = str_replace("[job title]",$job_details[0]['s_title'],$description);	
							$description = str_replace("[Buyer name]",$buyer_details['s_username'],$description);	
							$description = str_replace("[Buyer email]",$buyer_details['s_email'],$description);	
							$description = str_replace("[Buyer phone number]",$buyer_details['s_contact_no'],$description);	
							$description = str_replace("[Buyer skype IM]",$buyer_details['s_skype_id'],$description);	
							$description = str_replace("[Buyer address]",$buyer_details['s_address'],$description);	
							$description = str_replace("[Buyer county]",$buyer_details['s_state'],$description);	
							$description = str_replace("[Buyer city]",$buyer_details['s_city'],$description);	
							$description = str_replace("[Buyer post code]",$buyer_details['s_zip'],$description);	
							$description = str_replace("[invoice no.]",$invoice_no,$description);
							$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);	
							
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
										
						$this->email->to($tradesman_details['s_email']);
						
						$this->email->subject($content['s_subject']);
						unset($content);
						$this->email->message($mail_html);
						
						$this->email->attach($attachment_pdf);	
						
						if(SITE_FOR_LIVE)///For live site
							$i_nwid = $this->email->send();	
						else
							$i_nwid = TRUE;		
							
						$this->session->set_userdata(array('message'=>'Your payment has been done successfully.','message_type'=>'succ'));
						redirect(base_url().'home/message');	
							
					}	
				else
				{
					$this->session->set_userdata(array('message'=>'Sorry job not updated successfully.','message_type'=>'err'));
					redirect(base_url().'home/message');
				}		
									
			}
			else
			{
				$this->session->set_userdata(array('message'=>$resArray["L_LONGMESSAGE0"],'message_type'=>'err'));
				redirect(base_url().'home/message');
			}
			
			
		}	
		
		//pr($job_details,1);
		$this->data['job_type'] 	= $job_details[0]['job_details']['s_title'];
		//$this->data['job_category'] = $job_details[0]['job_details']['s_category'];
		$this->data['amt_quoted'] 	= $job_details[0]['d_quote'];
		$this->data['amt_to_paid'] 	= $tot_amt;
		$this->data['comm_slab'] 	= $comm[0]['s_commission_slab_100'];
		$this->data['i_job_id'] 	= $i_job_id;
		
		$this->render();
		
	}
   
   
    function payment_success()
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
		//var_dump($IPN_OBJ); exit;
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
		if(empty($IPN_ARR['custom'])) // paypal may not work properly for sometime
		{	
			$temp = $this->session->userdata('ses_data_temp');
			//$this->session->set_userdata(array('ses_data_temp'=>''));
			//pr($temp); exit;
			$i_tradesman_id = $temp['user_id'];
			$i_job_id = $temp['item_id'];
		
		}
		//$NO_OF_ITEMs = $IPN_ARR['num_cart_items'];
		else
		{
			//echo 'aa';exit;
			$itemIdArr = explode('&', $IPN_ARR['custom']);
			$i_tradesman_id = $itemIdArr[0];	
			$i_job_id = $itemIdArr[1];
		}
		
		//var_dump($itemIdArr);
		//exit;
		
	    /*To stop same entry*/
		$s_where = " WHERE n.i_job_id={$i_job_id} AND n.i_user_id={$i_tradesman_id}";
		$chk_tot = $this->job_model->gettotal_payment_info($s_where);
		if($chk_tot)
		{
			$this->session->set_userdata(array('message'=>'your payment has been made ','message_type'=>'err'));
			redirect(base_url().'home/message');				
		}
		
		/***********/		
		
		//pr($itemIdArr);	
		//exit;
		$info['i_status '] = 4;
		$table = $this->db->JOBS;
		$cond  = array('id '=>$i_job_id);
		$i_newid = $this->job_model->set_data_update($table,$info,$cond);
		if($i_newid)
		{
			/* to update tradesman won job after successful payment*/
			$this->mod_trades->update_tradesman_won_job($i_tradesman_id);
						
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
			
			/* insert data into payment history */	
			$s_where = " WHERE 	i_tradesman_user_id ={$i_tradesman_id} AND i_job_id ={$i_job_id}";
			$job_details = $this->job_model->fetch_quote_multi($s_where,0,1);
			$arr1 = array();
			$arr1['i_job_id']  		=  $i_job_id;
			$arr1['i_user_id'] 		=  $i_tradesman_id;
			$arr1['i_payment_date'] =  time();	
			$arr1['d_quote_amount'] = $job_details[0]['d_quote'];
			$arr1['d_pay_amount']   = $IPN_OBJ->ipn_data['mc_gross'];
			$arr1['s_transaction_id']= '';
			$table = $this->db->JOB_PAYMENT_HISTORY;	
			$inv_id = $this->job_model->set_data_insert($table,$arr1);
			
			$inv['i_invoice_no'] = 10000+intval($inv_id);
			$cond = array('id'=>$inv_id);
			$table = $this->db->JOB_PAYMENT_HISTORY;
			$i_newid = $this->job_model->set_data_update($table,$inv,$cond);
			
			/* end */	
			
			
			/*
			** for invoice generate and attach it to mail 
			**
			*/			
		
		$s_wh = " WHERE n.id=".$i_job_id." ";
		$info	=	$this->job_model->fetch_invoice_details($s_wh);
		//pr($info,1);
		$this->load->library('Text_price_format');
		$currency_object = new Text_price_format();
		//$customer_name 	= $info[0]['s_username'];
		$customer_name 	= $info[0]['s_business_name'];
		$address 		= $info[0]['s_address'];
		$state 			= $info[0]['s_state'];
		$city 			= $info[0]['s_city'];
		$postal 		= $info[0]['s_postal_code'];
		$payment_date	= $info[0]['dt_payment_date'];
		$job_title 		= $info[0]['s_part_title'];
		$job_cost		= $IPN_OBJ->ipn_data['mc_gross'];//$info[0]['s_budget_price'];
		//$paid_amount	= doubleval($info[0]['s_paid_amount']);
		
		//$paid_amount	= number_format($info[0]['s_budget_price'], 2, '.', '');
		$paid_amount	= number_format($job_cost, 2, '.', '');
		//echo 'aa';
		//exit;
		
		$paid_amount_word = convert_number($paid_amount);
		//$paid_amount_word=$currency_object ->get_bd_amount_in_text($info[0]['s_paid_amount']);
		$invoice_no	=	$info[0]['i_invoice_no'];
		$this->load->model('commission_slab_model');
		$s_where = " WHERE 	i_is_active=1";
		$comm = $this->commission_slab_model->fetch_multi($s_where);	
		$commission = $comm[0]['s_commission_slab_100'];	
       
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
																					  <td width="31%" align="left" valign="top">Job Type : </td>
																					  <td width="69%" valign="top" style="color:#616161;"> '.$job_title.' </td>
																				</tr>
																				<tr>
																					  <td valign="top" align="left"> Job Cost : </td>
																					  <td style="color:#616161;" valign="top"> '.$job_cost.' </td>
																				</tr>
																				<tr>
																					  <td valign="top" align="left"> Commission : </td>
																					  <td style="color:#616161;" valign="top">@ '.$commission.'% </td>
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
		   $this->load->model('manage_buyers_model');
		   $this->load->model('tradesman_model');
		   $s_where = " WHERE n.id={$i_job_id}";
		   $job_details = $this->job_model->fetch_multi($s_where,0,1);
		   
		   //echo '==========='.$i_tradesman_id;exit;
		   $buyer_details = $this->manage_buyers_model->fetch_this($job_details[0]['i_buyer_user_id']);
		   $tradesman_details = $this->tradesman_model->fetch_this($i_tradesman_id);
		   
		   $this->load->model('auto_mail_model');
		   $content = $this->auto_mail_model->fetch_contact_us_content('payment_sucess','tradesman');	
		   
		    $filename = $this->config->item('EMAILBODYHTML')."common.html";
			$handle = @fopen($filename, "r");
			$mail_html = @fread($handle, filesize($filename));				
			//print_r($content); exit;[invoice no.]
			if(!empty($content))
			{
				$description = $content["s_content"];
				$description = str_replace("[service professional]",$job_details[0]['s_username'],$description);
				$description = str_replace("[amount]",$IPN_OBJ->ipn_data['mc_gross'],$description);	
				$description = str_replace("[job title]",$job_details[0]['s_title'],$description);	
				$description = str_replace("[Buyer name]",$buyer_details['s_username'],$description);	
				$description = str_replace("[Buyer email]",$buyer_details['s_email'],$description);	
				$description = str_replace("[Buyer phone number]",$buyer_details['s_contact_no'],$description);	
				$description = str_replace("[Buyer skype IM]",$buyer_details['s_skype_id'],$description);	
				$description = str_replace("[Buyer address]",$buyer_details['s_address'],$description);	
				$description = str_replace("[Buyer county]",$buyer_details['s_state'],$description);	
				$description = str_replace("[Buyer city]",$buyer_details['s_city'],$description);	
				$description = str_replace("[Buyer post code]",$buyer_details['s_zip'],$description);	
				$description = str_replace("[invoice no.]",$invoice_no,$description);
				$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);	
				
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
							
			$this->email->to($tradesman_details['s_email']);
			
			$this->email->subject($content['s_subject']);
			unset($content);
			$this->email->message($mail_html);
			
			$this->email->attach($attachment_pdf);
			
			
			
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
			
		/* end job quote mail to the user */		
		
			$this->session->set_userdata(array('message'=>t('Your payment has been done sucessfully'),'message_type'=>'succ'));
			redirect(base_url().'home/message');
		}
		else
		{
			$this->session->set_userdata(array('message'=>t('Your payment has not been done sucessfully'),'message_type'=>'err'));
			redirect(base_url().'home/message');		
		}
	
	}
	
	function payment_failure()
	{
			$this->session->set_userdata(array('message'=>t('Your payment has not been done sucessfully'),'message_type'=>'err'));
			redirect(base_url().'home/message');		

	}
	
	function express_cancel_payment($par='')
	{		
		$this->session->set_userdata(array('message'=>'You have canceled your payment','message_type'=>'err'));
		redirect(base_url().'home/message');
	}
	   
   
	function express_payment($i_job_id='')
	{	
		if(empty($i_job_id))
		{
			$this->session->set_userdata(array('message'=>t('Sorry, Job not exists.'),'message_type'=>'err'));
			redirect(base_url().'home/message');
		}
		
		$tot_amt = $this->get_comm_amount($i_job_id);	
		$environment = EXPRESS_CHECKOUT_ENV;
		
		$paymentAmount = urlencode($tot_amt);
		$currencyID = urlencode('GBP');			// or other currency code ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
		$paymentType = urlencode('Sale');		// or 'Sale' or 'Order'
		
		$returnURL = urlencode(base_url()."tradesman/express_sucess_payment/".$i_job_id);
		$cancelURL = urlencode(base_url()."tradesman/express_cancel_payment");
		
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
   
	function express_sucess_payment($i_job_id)
	{	
		$tot_amt = $this->get_comm_amount($i_job_id);
		$i_tradesman_id = $this->user_id;	
		$job_details = $this->job_model->fetch_quote_multi($s_where,0,1);

		// Set request-specific fields.		
		$token = urlencode(htmlspecialchars($_REQUEST['token']));
		$payerID = urlencode(htmlspecialchars($_REQUEST['PayerID']));		
		
		$paymentType = urlencode("Sale");			// or 'Sale' or 'Order'
		$paymentAmount = urlencode($tot_amt);
		$currencyID = urlencode("GBP");						// or other currency code ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
		
		// Add request-specific fields to the request string.
		$nvpStr = "&TOKEN=$token&PAYERID=$payerID&PAYMENTACTION=$paymentType&AMT=$paymentAmount&CURRENCYCODE=$currencyID";
		
		// Execute the API operation; see the PPHttpPost function above.
		$httpParsedResponseAr = PPHttpPost('DoExpressCheckoutPayment', $nvpStr);
		
		
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
		
				$info['i_status '] = 4;
				$table = $this->db->JOBS;
				$cond  = array('id '=>$i_job_id);
				$i_newid = $this->job_model->set_data_update($table,$info,$cond);
				if($i_newid)
				{
					/* to update tradesman won job after successful payment*/
					$this->mod_trades->update_tradesman_won_job($i_tradesman_id);
					/* to update buyer awarded job after successful payment*/
					$this->load->model('manage_buyers_model');
					$this->manage_buyers_model->update_awarded_job($job_details[0]['job_details']['i_buyer_user_id']);
								
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
					
					/* insert data into payment history */	
					$s_where = " WHERE 	i_tradesman_user_id ={$i_tradesman_id} AND i_job_id ={$i_job_id}";
					$job_details = $this->job_model->fetch_quote_multi($s_where,0,1);
					$arr1 = array();
					$arr1['i_job_id']  		=  $i_job_id;
					$arr1['i_user_id'] 		=  $i_tradesman_id;
					$arr1['i_payment_date'] =  time();	
					$arr1['d_quote_amount'] = $job_details[0]['d_quote'];
					$arr1['d_pay_amount']   = $tot_amt;
					$arr1['s_transaction_id']= '';
					$table = $this->db->JOB_PAYMENT_HISTORY;	
					$inv_id = $this->job_model->set_data_insert($table,$arr1);
					
					$inv['i_invoice_no'] = 10000+intval($inv_id);
					$cond = array('id'=>$inv_id);
					$table = $this->db->JOB_PAYMENT_HISTORY;
					$i_newid = $this->job_model->set_data_update($table,$inv,$cond);					
					/* end */	
					
					
					/*
					** for invoice generate and attach it to mail 
					**
					*/			
				
					$s_wh = " WHERE n.id=".$i_job_id." ";
					$info	=	$this->job_model->fetch_invoice_details($s_wh);
					//pr($info,1);exit;
					$this->load->library('Text_price_format');
					$currency_object = new Text_price_format();
					//$customer_name 	= $info[0]['s_username'];
					$customer_name 	= $info[0]['s_business_name'];
					$address 		= $info[0]['s_address'];
					$state 			= $info[0]['s_state'];
					$city 			= $info[0]['s_city'];
					$postal 		= $info[0]['s_postal_code'];
					$payment_date	= $info[0]['dt_payment_date'];
					$job_title 		= $info[0]['s_title'];
					$job_cost		= $info[0]['s_budget_price'];
					$paid_amount	= number_format($tot_amt, 2, '.', '');
					$quote_price = number_format($job_details[0]['d_quote'], 2, '.', '');
					
					$paid_amount_word = convert_number($paid_amount);
					//echo $paid_amount.'======='.$paid_amount_word ;exit;
					//$paid_amount_word=$currency_object ->get_bd_amount_in_text($info[0]['s_paid_amount']);
					$invoice_no	=	$info[0]['i_invoice_no'];
					$this->load->model('commission_slab_model');
					$s_where = " WHERE 	i_is_active=1";
					$comm = $this->commission_slab_model->fetch_multi($s_where);	
					$commission = $comm[0]['s_commission_slab_100'];	
				   
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
																								  <td width="31%" align="left" valign="top">Job Type : </td>
																								  <td width="69%" valign="top" style="color:#616161;"> '.$job_title.' </td>
																							</tr>
																							<tr>
																								  <td valign="top" align="left"> Job Cost : </td>
																								  <td style="color:#616161;" valign="top"> '.$quote_price.' </td>
																							</tr>
																							<tr>
																								  <td valign="top" align="left"> Commission : </td>
																								  <td style="color:#616161;" valign="top">@ '.$commission.'% </td>
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
					   $this->load->model('manage_buyers_model');
					   $this->load->model('tradesman_model');
					   $s_where = " WHERE n.id={$i_job_id}";
					   $job_details = $this->job_model->fetch_multi($s_where,0,1);
					   
					   //echo '==========='.$i_tradesman_id;exit;
					   $buyer_details = $this->manage_buyers_model->fetch_this($job_details[0]['i_buyer_user_id']);
					   $tradesman_details = $this->tradesman_model->fetch_this($i_tradesman_id);
					   
					   $this->load->model('auto_mail_model');
					   $content = $this->auto_mail_model->fetch_contact_us_content('payment_sucess','tradesman');	
					   
						$filename = $this->config->item('EMAILBODYHTML')."common.html";
						$handle = @fopen($filename, "r");
						$mail_html = @fread($handle, filesize($filename));				
						//print_r($content); exit;[invoice no.]
						if(!empty($content))
						{
							$description = $content["s_content"];
							$description = str_replace("[service professional]",$job_details[0]['s_username'],$description);
							$description = str_replace("[amount]",$paid_amount,$description);	
							$description = str_replace("[job title]",$job_details[0]['s_title'],$description);	
							$description = str_replace("[Buyer name]",$buyer_details['s_username'],$description);	
							$description = str_replace("[Buyer email]",$buyer_details['s_email'],$description);	
							$description = str_replace("[Buyer phone number]",$buyer_details['s_contact_no'],$description);	
							$description = str_replace("[Buyer skype IM]",$buyer_details['s_skype_id'],$description);	
							$description = str_replace("[Buyer address]",$buyer_details['s_address'],$description);	
							$description = str_replace("[Buyer county]",$buyer_details['s_state'],$description);	
							$description = str_replace("[Buyer city]",$buyer_details['s_city'],$description);	
							$description = str_replace("[Buyer post code]",$buyer_details['s_zip'],$description);	
							$description = str_replace("[invoice no.]",$invoice_no,$description);
							$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);	
							
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
										
						$this->email->to($tradesman_details['s_email']);
						
						$this->email->subject($content['s_subject']);
						unset($content);
						$this->email->message($mail_html);
						
						$this->email->attach($attachment_pdf);	
						
						if(SITE_FOR_LIVE)///For live site
							$i_nwid = $this->email->send();	
						else
							$i_nwid = TRUE;		
							
						$this->session->set_userdata(array('message'=>'Your payment has been done successfully.','message_type'=>'succ'));
						redirect(base_url().'home/message');	
							
					}	
				else
				{
					$this->session->set_userdata(array('message'=>'Sorry job not updated successfully.','message_type'=>'err'));
					redirect(base_url().'home/message');
				}		
									
			
		
	
	} else  {
			$this->session->set_userdata(array('message'=>'Your payment has not been done successfully.','message_type'=>'err'));
			redirect(base_url().'home/message');
			//exit('DoExpressCheckoutPayment failed: ' . print_r($httpParsedResponseAr, true));
		}		
		
	
	}	   
   
   
   	function get_comm_amount($i_job_id)
	{
		$this->load->model('commission_slab_model');
		$s_where = " WHERE 	i_is_active=1";
		$comm = $this->commission_slab_model->fetch_multi($s_where);
		
		$site_settings = $this->mod_site_setting->fetch_this(NULL);
		$s_where = " WHERE 	i_tradesman_user_id ={$this->user_id} AND i_job_id ={$i_job_id}";
		$job_details = $this->job_model->fetch_quote_multi($s_where,0,1);
		$tot_amt = number_format(($job_details[0]['d_quote']*$comm[0]['s_commission_slab_100'])/100, 2, '.', '');	
		return $tot_amt;	
	}
   
   
   
   
   
   
   
   
   public function testimonial()
    {
        try
        {
			$this->i_sub_menu_id=21;
			$this->data['pathtoclass']=$this->pathtoclass;
			$user_details = $this->session->userdata('loggedin');
			$user_name	=	$user_details['user_name'];
			$this->data['user_id']	=	$user_details['user_id'];
			if($_POST)
			{
				
				$posted=array();
                $posted["txt_content"]= trim($this->input->post("txt_content"));				
				
				$this->form_validation->set_rules('txt_content', 'provide testimonial', 'required');
				
				
				 if($this->form_validation->run() == FALSE)/////invalid
					{
						///Display the add form with posted values within it////
						$this->data["posted"]=$posted;
					}
				else
					{
						
						$info=array();
						$info["s_content"]	=	$posted['txt_content'];
						$info['i_created_date'] = strtotime(date("Y-m-d H:i:s"));
						
						$i_newid = $this->mod_trades->add_new_testimonial($info,$user_name);
						if($i_newid)////saved successfully
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_testi"],'message_type'=>'succ'));
							redirect(base_url().'tradesman/testimonial');
						}
						else///Not saved, show the form again
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_testi_err"],'message_type'=>'err'));
							$this->render('tradesman/testimonial');
						}
						
					
					}	
				
			
			}
			
			$this->data['breadcrumb'] = array('My Testimonial'=>'');	
			$s_wh_testi	=	" WHERE n.s_person_name='".$user_details['user_name']."' ";	
			
			// pagination start
			
			$this->load->model('testimonial_model');
			$start = ($this->uri->segment($this->i_uri_seg)) ? $this->uri->segment($this->i_uri_seg) : 0;
			$limit	= $this->i_fe_page_limit;
			$this->data['testimonial_list']	=	$this->mod_trades->fetch_testimonial($s_wh_testi,intval($start), $limit);
			
			
			$i_total_no = $this->testimonial_model->gettotal_info($s_wh_testi);
			$s_pageurl = base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
			$i_uri_segment = $this->i_fe_uri_segment;
			
			$this->data['pagination'] = $this->get_fe_pagination($s_pageurl,$i_total_no,$limit,$i_uri_segment);
			 
			$this->render('tradesman/testimonial');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
   
		
   
   function job_feedback($i_job_id=0)
   {
   		$this->load->model('manage_feedback_model');
		
		$i_job_id = decrypt($i_job_id);
		$s_where = " WHERE n.i_job_id={$i_job_id} AND n.i_status=1 AND n.i_receiver_user_id={$this->user_id}";
		$this->data['feedback_details'] =  $this->manage_feedback_model->fetch_multi($s_where,0,1);
		//pr($this->data['feedback_details']);
   		$this->load->view('fe/tradesman/job_feedback.tpl.php', $this->data);
   }
   
  function feedback_received()
	   {
		try
		{
				$this->i_sub_menu_id	=	15;
			
				ob_start();				
			    $id = $this->data['loggedin']['user_id'];			  
				$this->feedback_receive_pagination_ajax($id,0,1);
				$contents = ob_get_contents();
				ob_end_clean();
				//pr($contents);
				//exit;
/*				$this->load->model('tradesman_model');
				$info = $this->tradesman_model->fetch_this(decrypt($id));
				$this->data['profile_info'] = $info;
*/				$this->data['feedback_contents'] = $contents;
					
				$this->render();
			
		}
	catch(Exeception $e)
	{
		show_error($e->getMessage());
	}
   }
		
	public function feedback_receive_pagination_ajax($s_id,$start=0,$param=0) 
	{
		$limit	= $this->i_fe_page_limit;
	//	$limit = 2;
		$this->load->model("Manage_feedback_model","mod_feed");
		$s_where = " WHERE n.i_receiver_user_id = ".decrypt($s_id)." AND n.i_status !=0 AND n.i_feedback_complete_status=1";
		$feedback = $this->mod_feed->fetch_multi($s_where,intval($start),$limit);
		//echo $this->db->last_query();
		$total_rows = $this->mod_feed->gettotal_info($s_where);	
		
		
		$this->data['feedback_list'] = $feedback;
		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'tradesman/feedback_receive_pagination_ajax/'.$s_id.'/';		
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
		
		$job_vw = $this->load->view('fe/tradesman/ajax_feedback_list.tpl.php',$this->data,TRUE);
		
		echo $job_vw;		
	}	
	
	
	function post_feedback($i_feedback_id)
	{
		$this->data['i_feedback_id'] = decrypt($i_feedback_id);
		$this->load->view('fe/tradesman/give_feedback.tpl.php', $this->data);
	}
	
	function save_give_feedback()
	{
		if($_POST)
		{
		
			$i_feedback_id = $this->input->post("i_feedback_id");
			$s_comments = get_formatted_string($this->input->post("s_comments"));
			$i_rating 	= intval($this->input->post("i_rating"));
			$i_positive	= intval($this->input->post("i_positive"));
			
			$feed_back_deatils = $this->mod_feed->fetch_this($i_feedback_id);
			
			$info = array();
			$info['i_job_id'] = $feed_back_deatils['i_job_id'];
			$info['i_sender_user_id'] = $this->user_id;
			$info['i_receiver_user_id '] = $feed_back_deatils['i_sender_user_id'];
			$info['s_comments'] = $s_comments;
			$info['i_rating'] = $i_rating;
			$info['i_positive'] = $i_positive;
			$info['i_created_date'] = time();
			$info['i_status'] = 1;
			$info['i_feedback_complete_status'] = 1;
			$table = $this->db->JOBFEEDBACK;
			$i_new_id = $this->job_model->set_data_insert($table,$info);
			
			if($i_new_id)
			{
				
				$info = array();
				$info['i_feedback_complete_status'] = 1;
				$cond = array('id'=>$i_feedback_id);
				$table = $this->db->JOBFEEDBACK;
				$i_new_id = $this->job_model->set_data_update($table,$info,$cond);
				
				/* calcution for update tradesman details table */
				$this->load->model('manage_feedback_model');	
				/**Accepted feedback*/
				$s_where = " WHERE i_receiver_user_id ={$this->user_id} AND n.i_status=1 AND n.i_feedback_complete_status=1"; 
				$tot_accepted_feedback = $this->manage_feedback_model->gettotal_info($s_where);
				/**Total feedback*/
				$s_where = " WHERE i_receiver_user_id ={$this->user_id} AND n.i_status!=0 AND n.i_feedback_complete_status=1"; 				
				$tot_feedback = $this->manage_feedback_model->gettotal_info($s_where);
				
				$s_where = " WHERE i_receiver_user_id ={$this->user_id} AND n.i_status !=0 AND n.i_feedback_complete_status=1"; 				
				$feedback_details = $this->manage_feedback_model->fetch_feedback_rating($s_where);
				//pr($feedback_details); exit;
				
				$s_where = " WHERE i_receiver_user_id ={$this->user_id} AND n.i_status !=0 AND n.i_positive=1 AND n.i_feedback_complete_status=1" ;
				$i_positive = $this->manage_feedback_model->fetch_feedback_positive($s_where);
				
				$info = array();
				$info['i_feedback_rating'] = round($feedback_details['i_rating']);
				$info['f_positive_feedback_percentage'] = ($tot_feedback!=0)?round(($i_positive['i_positive']/$tot_feedback)*100):0;
				//$info['i_jobs_won'] = $tot_accepted_feedback;
				$info['i_feedback_received'] = $tot_feedback;
				$table = $this->db->TRADESMANDETAILS;
				$cond = array('i_user_id'=>$this->user_id);
				//exit;
				$this->job_model->set_data_update($table,$info,$cond);
				/* end of calcution for update tradesman details table */					
				
					
				/* calcution for update buyer details table */
				/**Accepted feedback*/
				$s_where = " WHERE i_receiver_user_id ={$feed_back_deatils['i_sender_user_id']} AND n.i_status=1 AND n.i_feedback_complete_status=1"; 
				$tot_accepted_feedback = $this->manage_feedback_model->gettotal_info($s_where);
				/**Total feedback*/
				$s_where = " WHERE i_receiver_user_id ={$feed_back_deatils['i_sender_user_id']} AND n.i_status!=0 AND n.i_feedback_complete_status=1"; 				
				$tot_feedback = $this->manage_feedback_model->gettotal_info($s_where);
				
				$s_where = " WHERE i_receiver_user_id ={$feed_back_deatils['i_sender_user_id']} AND n.i_status !=0 AND n.i_feedback_complete_status=1"; 				
				$feedback_details = $this->manage_feedback_model->fetch_feedback_rating($s_where);
				
				$s_where = " WHERE i_receiver_user_id ={$feed_back_deatils['i_sender_user_id']} AND n.i_status !=0 AND n.i_positive=1 AND n.i_feedback_complete_status=1" ;
				$i_positive = $this->manage_feedback_model->fetch_feedback_positive($s_where);
				
				$info = array();
				$info['i_feedback_rating'] = round($feedback_details['i_rating']);
				$info['f_positive_feedback_percentage'] = ($tot_feedback!=0)?round(($i_positive['i_positive']/$tot_feedback)*100):0;
				//$info['i_jobs_won'] = $tot_accepted_feedback;
				$info['i_feedback_received'] = $tot_feedback;
				$table = $this->db->BUYERDETAILS;
				$cond = array('i_user_id'=>$feed_back_deatils['i_sender_user_id']);
				//exit;
				$this->job_model->set_data_update($table,$info,$cond);
				/* end of calcution for update tradesman details table */
				
				
			   $this->load->model('manage_buyers_model');
			   $job_details = $this->job_model->fetch_this($feed_back_deatils['i_job_id']);
			   $buyer_details = $this->manage_buyers_model->fetch_this($job_details['i_buyer_user_id']);
			   				
			   $this->load->model('auto_mail_model');
			   $content = $this->auto_mail_model->fetch_contact_us_content('tradesman_feedback','buyer');	
			   $mail_subject = $content['s_subject'];		
			   
			   $filename = $this->config->item('EMAILBODYHTML')."common.html";
			   $handle = @fopen($filename, "r");
			   $mail_html = @fread($handle, filesize($filename));				
				//print_r($content); exit;
				if(!empty($content))
				{							
					$description = $content["s_content"];
					$description = str_replace("[Buyer name]",$buyer_details['s_username'],$description);
					$description = str_replace("[job title]",$job_details['s_title'],$description);	
					$description = str_replace("[Service professional name]",$job_details['s_tradesman_name'],$description);
					$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);		
					
					$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
				}
				unset($content);
				//echo $this->data['loggedin']['user_email'];	
				$mail_html = str_replace("[site url]",base_url(),$mail_html);	
				$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
				//echo "{$buyer_details['s_email']}<br>DESC".$description;	exit;
				
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
								
				$this->email->to($buyer_details['s_email']);
				
				$this->email->subject( $mail_subject );
				$this->email->message($mail_html);
				
				if(SITE_FOR_LIVE)///For live site
				{				
					$i_nwid = $this->email->send();	
															
				}
				else{
					$i_nwid = TRUE;				
				}				
					
						
			
				$msg = '1|Feedback posted sucessfully';
			}
			else
				$msg = '2|Feedback not posted sucessfully';
			
			
			
		}
		/*else
		{
			redirect(base_url());
		}	*/
		echo $msg;	
	}
	
	
	public function tradesman_radar_job()
	{
		try
		{
			$this->data['breadcrumb'] = array('Radar Jobs'=>'');	
			$s_cat_name = 'None';
			if($_POST)
			{
				$sessArrTmp['i_category_id']  =  decrypt(trim($this->input->post('opt_category_id')));	
				$sessArrTmp['opt_radius'] 		= decrypt(trim($this->input->post('opt_radius')));					
				$sessArrTmp['txt_postal_code'] 	= trim($this->input->post('txt_postal_code'));	
			}
			else
			{
				$this->load->model("radar_model");
				
				$info = $this->radar_model->fetch_this($this->user_id);
				
				//pr($info);
				//$sessArrTmp['i_category_id']  = $info['i_category_id'];	
				$sessArrTmp['opt_radius'] 		= $info['i_radius'];					
				$sessArrTmp['txt_postal_code'] 	= $info['i_postal_code'];
				if($info)
				{
				
					$sessArrTmp['radar_category_id'] = $this->radar_model->get_radar_cat($info['id']);
					$cat_arr = array();
					foreach($sessArrTmp['radar_category_id'] as $val)
						$cat_arr[]=$val['i_category_id'];
					
					$s_cat_where = " WHERE c.id IN(".implode(",",$cat_arr).") ";
					$arr_cat = $this->radar_model->get_radar_cat_name($s_cat_where);
					//pr($arr_cat);exit;
					$s_cat_name = implode(", ",$arr_cat);
					
				}
			}
			
			$this->session->set_userdata(array('model_session'=>$sessArrTmp));	// to store data in session
			$this->data['posted'] = $sessArrTmp;
			$this->data['s_cat_name'] = $s_cat_name;
			
			$this->i_sub_menu_id	=	10;
			ob_start();
			$this->pagination_ajax(0,1);
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
	function pagination_ajax($start=0,$param=0) {	
		$s_where='';
		
		$model_session = $this->session->userdata('model_session');
		//pr($model_session);
		$sessArrTmp['src_job_category_id']  = $model_session['i_category_id'];
		$sessArrTmp['src_radar_category_id']  = $model_session['radar_category_id'];
		$sessArrTmp['src_job_radius'] 		= $model_session['opt_radius'];
		$sessArrTmp['src_job_postal_code']  = $model_session['txt_postal_code'];
		
		$arr_search[] = " n.i_status=1 AND n.i_is_deleted!=1";
				
		//pr($sessArrTmp);	
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
		
		if($sessArrTmp['src_job_postal_code'])
		{
			
			$zipcode = $this->zipcode_model->fetch_multi(" WHERE n.postal_code='{$sessArrTmp['src_job_postal_code']}'");
			if(!empty($zipcode))
			 {
				$lat = $zipcode[0]['latitude'];
				$lng = $zipcode[0]['longitude'];
				//$job_radius = intval($sessArrTmp['src_job_radius']);
				$job_radius = (intval($sessArrTmp['src_job_radius'])*10)+10;
				//echo '======'.$job_radius;
				$mile= ($job_radius*1.6093);
				$arr_search[] =" (
									(
									  (
									  acos( sin( ( {$lat} * pi( ) /180 ) ) * sin( (
									  `latitude` * pi( ) /180 ) ) + cos( ( {$lat} * pi( ) /180 ) ) * cos( (
									  `latitude` * pi( ) /180 ) 
									  ) * cos( (
									  (
									  {$lng} - `longitude` 
									  ) * pi( ) /180 ) 
									  )
									  )
									  ) *180 / pi( ) 
									 ) *60 * 1.1515 * 1.609344
									)  <= $mile";	
			}
			else
				$arr_search[] =" z.postal_code='{$sessArrTmp['src_job_postal_code']}'";						
		}	
		elseif($sessArrTmp['src_job_postal_code'])
		{
			$arr_search[] =" z.postal_code='{$sessArrTmp['src_job_postal_code']}'";
		}
		$s_where .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
		

		$limit	=  $this->i_fe_page_limit;
			
		//echo $s_where; exit;	
		$this->data['job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);
		
		//pr($this->data['job_list']);		

		$total_rows = $this->job_model->gettotal_info($s_where);	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'tradesman/pagination_ajax/';
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
		if(empty($param))
			$job_vw = $this->load->view('fe/tradesman/ajax_job_list.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/tradesman/ajax_job_list.tpl.php',$this->data,TRUE).'^'.$total_rows;
		echo $job_vw;		
	}	
	public function job_radar()
	{
		try
		{
			$this->i_sub_menu_id	=	18;
			$this->data['breadcrumb'] = array('Job Radar'=>'');	
			
			$id = $this->data['loggedin']['user_id'];
		  
			if($_POST)
			{
				$posted=array();
				$posted['txt_postal_code'] = $this->input->post("txt_postal_code");
				$posted['opt_radius'] = $this->input->post("opt_radius");
				$posted['opt_category_id'] = $this->input->post("opt_category_id");
				
				//$posted['opt_category_id1'] = $this->input->post("opt_category_id1");
				//$posted['opt_category_id2'] = $this->input->post("opt_category_id2");
				$posted['h_id'] = $this->input->post("h_id");
				
				$this->form_validation->set_rules('txt_postal_code', 'postal code', 'required');
                $this->form_validation->set_rules('opt_radius', 'radius', 'required');
				//$this->form_validation->set_rules('opt_category_id', t('category'), 'required');
             
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
					$info['i_postal_code'] = $posted['txt_postal_code'];
					$info['i_radius'] = decrypt($posted['opt_radius']);
					$info['i_category_id'] =$posted['opt_category_id'];
					//$info['i_category_id1'] =decrypt($posted['opt_category_id1']);
					//$info['i_category_id2'] =decrypt($posted['opt_category_id2']);
					$info['id'] = decrypt($posted['h_id']);
					$info['i_user_id'] = decrypt($id);
					
					if($info['id'] == 0)
					{
                    	$i_aff=$this->radar_model->add_info($info);
						$i_radar_id = $i_aff;
					}
					else
					{
						$i_aff=$this->radar_model->edit_info($info,decrypt($posted["h_id"]));
						$i_radar_id = $info['id'];
					}
					//echo $i_radar_id; exit;
					if($i_radar_id)
					{
						$this->radar_model->del_radar_cat($i_radar_id);
						$arr1 = array();
						if($info['i_category_id'])
						{
							foreach($info['i_category_id'] as $val)
							{
								$arr1['i_radar_id']  =  $i_radar_id;
								$arr1['i_category_id'] =  decrypt($val);
								$table = $this->db->RADAR_CAT;
								$this->radar_model->set_data_insert($table,$arr1);
							}
						}	
					}
                    if($i_radar_id)////saved successfully
                    {
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_radar_succ"],'message_type'=>'succ'));
                        redirect(base_url().'tradesman/job_radar');                      
                    }
                    else///Not saved, show the form again
                    {
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_radar_err"],'message_type'=>'err'));
                        $this->data["posted"]=$posted;
                        redirect(base_url().'tradesman/job_radar');
                    }
                    unset($info,$posted, $i_aff);					
				}				
			}
			//$this->load->model('tradesman_model');
			$info = $this->radar_model->fetch_this(decrypt($id));
			//pr($info);
			
			$cnt = 1;
			if($info['id'])
			{
				$info['txt_postal_code'] = $info['i_postal_code'];
				$info['opt_radius'] = encrypt($info['i_radius']);		
				$info['h_id'] = encrypt($info['id']);
				$this->data['radar_cat'] = $this->radar_model->get_radar_cat($info['id']);
				//var_dump($this->data['radar_cat']);exit;
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
				$tradesman_details = $this->tradesman_model->fetch_this(decrypt($id));
				//pr($tradesman_details);
				$info['txt_postal_code'] = $tradesman_details['s_postal_code'];
				
			}
			//pr($this->data['radar_cat']);
			$this->data['cnt'] = $cnt;
			$this->data['posted'] = $info;
				
			$this->render();
		}
		catch(Exception $e)
		{
			show_error($e->getMessage());
		}
	}
	
	/* for invoice pdf download */
	
	public function showPdfInvoice()
    {
		$i_job_id = $this->uri->segment(3); 
		
		$s_wh = " WHERE n.id=".$i_job_id." ";
		$info	=	$this->job_model->fetch_invoice_details($s_wh);
		//pr($info,1);
		$this->load->library('Text_price_format');
		$currency_object = new Text_price_format();
		$customer_name 	= $info[0]['s_business_name'];
		$address 		= $info[0]['s_address'];
		$state 			= $info[0]['s_state'];
		$city 			= $info[0]['s_city'];
		$postal 		= $info[0]['s_postal_code'];
		$payment_date	= $info[0]['dt_payment_date'];
		$job_title 		= $info[0]['s_part_title'];
		$job_cost		= $info[0]['s_budget_price'];
		$paid_amount	= $info[0]['s_paid_amount'];
		$paid_amount_word=$currency_object ->get_bd_amount_in_text($info[0]['s_paid_amount']);
		$invoice_no	=	$info[0]['i_invoice_no'];
		
       
		$logo_path = BASEPATH.'../images/fe/logo_invoice.png';
		$right_image_path = BASEPATH.'../images/fe/grey_up.png';
		$left_image_path = BASEPATH.'../images/fe/grey_down.png';
        $html_n = '<HTML><HEAD><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<body style="margin:0px; padding:0px;">
<table style="width:600px; margin:0px auto; line-height:16px; background-color:#FFFFFF; color:#000;font-size:12px;font-family:Arial, Helvetica, sans-serif;" border="0" cellspacing="0" cellpadding="0">
      <tr>
            <td style="padding:12px;"><img src="'.$logo_path.'" alt="" style="margin-top:8px;" /></td>
            <td align="right" style="padding:12px;color:#616161;">123 Someway Lane,Suite 789<br />
                  Somewhere,<br />
                  Ontario MV2 8SX</td>
      </tr>
      <tr>
            <td style="border-bottom:1px solid #bfbfbf;border-top:1px solid #bfbfbf; text-transform:uppercase; padding:7px 12px; font-size:16px; font-family:myriad Pro, arial;" align="right" colspan="2"><strong>INVOICE NO :</strong> <span style="color:#17a2dd;">#'.$invoice_no.'</span></td>
      </tr>
      <tr>
            <td style="padding:12px;color:#616161;"><span style="color:#000;"><strong>'.$customer_name.'</strong></span><br />
                  '.$address.',<br />
                  '.$state.', '.$city.',<br />
                  '.$postal.'</td>
            <td align="right" style="color:#616161;padding:12px;" valign="top"><span style="color:#000;"><strong>Date:</strong></span> '.$payment_date.'</td>
      </tr>
      <tr>
            <td  colspan="2" style="background-color:#f1f1f1;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                              <td align="right" valign="top"><img src="'.$right_image_path.'" alt="" /> </td>
                        </tr>
                        <tr>
                              <td style="padding:0px 30px;">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td width="11%" style="border-bottom:1px solid #b5b5b5;  text-transform:uppercase; padding:0px 8px 8px;"> <strong>SL.NO.</strong></td>
                                                <td width="73%" style="border-bottom:1px solid #b5b5b5;  text-transform:uppercase;padding:0px 8px 8px;" ><strong>Description</strong></td>
                                                <td width="16%" style="border-bottom:1px solid #b5b5b5; text-transform:uppercase;padding:0px 8px 8px;"><strong>Amount(s)</strong></td>
                                          </tr>
                                          <tr>
                                                <td style="border-bottom:1px solid #b5b5b5; padding:8px;" align="right" valign="top"><strong>1</strong></td>
                                                <td style="border-bottom:1px solid #b5b5b5;border-left:1px solid #b5b5b5; padding:4px;"  align="left" valign="top">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                            <tr>
                                                                  <td width="54%" align="right" valign="top">Total Commission against the Job : </td>
                                                                  <td width="46%" valign="top" style="color:#616161;"> '.$job_title.' </td>
                                                            </tr>
                                                            <tr>
                                                                  <td valign="top" align="right"> Job Cost : </td>
                                                                  <td style="color:#616161;" valign="top"> '.$job_cost.' </td>
                                                            </tr>
                                                            
                                                      </table>
                                                  </td>
                                                <td style="border-bottom:1px solid #b5b5b5;border-left:1px solid #b5b5b5;padding:8px;" align="right" valign="top">'.$paid_amount.'</td>
                                          </tr>
                                          <tr>
                                                <td style="border-bottom:1px solid #b5b5b5; padding:8px;" align="left" valign="top">&nbsp;</td>
                                                <td style="border-bottom:1px solid #b5b5b5;border-left:1px solid #b5b5b5; padding:8px;"  align="right" valign="top"> Discount <span  style="color:#616161;">( Refferal Waiver )</span> </td>
                                                <td style="border-bottom:1px solid #b5b5b5;border-left:1px solid #b5b5b5;padding:8px;" align="right" valign="top">0 </td>
                                          </tr>
                                          <tr>
                                                <td style="border-bottom:1px solid #b5b5b5; padding:8px;" align="left" valign="top">&nbsp;</td>
                                                <td style="border-bottom:1px solid #b5b5b5; font-size:14px;border-left:1px solid #b5b5b5; padding:8px;"  align="right" valign="top"> Net Payable Amount</span> </td>
                                                <td style="border-bottom:1px solid #b5b5b5;font-size:14px;color:#17a2dd;border-left:1px solid #b5b5b5;padding:8px;" align="right" valign="top">&#163; '.$paid_amount.' </td>
                                          </tr>
                                    </table>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                          <tr>
                                                <td style="color:#aaa; padding-top:8px;" colspan="2" align="right" valign="top"><span style="color:#ec2d52;">*</span> Price is inclusive all taxes</td>
                                          </tr>
                                          <tr>
											<td width="30%" valign="top"> Payment Method  :</td>
											<td width="70%" style="color:#616161;" valign="top"> PAYPAL </td>
										   </tr>
                      
                                      </table>
                              </td>
                        </tr>
                        <tr>
                              <td align="left" valign="baseline"><p style="height:30px; overflow:hidden; padding:0px; margin:0px;background-color:#f1f1f1;"><img src="'.$left_image_path.'" alt="" /> </p></td>
                        </tr>
                  </table></td>
      </tr>
      <tr>
            <td colspan="2" style=" color:#aaa; line-height:35px; font-size:11px; text-align:center; font-family:Georgia, Times New Roman, Times, serif; "><em><strong>Jobshoppa.com</strong></em></td>
      </tr>
</table>
</body>
</html>
';
       $this->load->plugin('to_pdf');
       $ffname = 'invoice_'.time();
       pdf_create($html_n, $ffname);



    }
	
     public function check_dob($txt_dob)
    {
        try
        {
            $i_dob=convert_date_mdy_format($txt_dob);  ////////This function written in helper.php
            if($i_dob > strtotime('-18 years'))
                    {
                        $this->form_validation->set_message('check_dob', '%s is less than 18 years.');
                        return FALSE;   
                    }
            return TRUE;   
            //return FALSE;     
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	
	}


    function ajax_check_email_exist()
    {
        $s_email = $this->input->post('s_email');
        $i_user_id = $this->input->post('user_id');  
        $s_where = " WHERE n.s_email= '{$s_email}' AND n.id != {$i_user_id} " ;    
        $email_exist =  $this->mod_trades->gettotal_info($s_where);    
        //var_dump($is_username_exist);
        //echo '=='.$is_username_exist;
        if($email_exist > 0)
            echo 'error';
        else
            echo 'succ';
                
    } 
      
    
    function ajax_check_email_valid()
    {
        $s_email = $this->input->post('s_email');
        $i_user_id = $this->input->post('user_id');  
        $s_where = " WHERE n.s_email= '{$s_email}' AND n.id = {$i_user_id} " ;    
        $email_valid =  $this->mod_trades->gettotal_info($s_where); 
        //var_dump($is_username_exist);
        //echo '=='.$is_username_exist;
        if($email_valid != 1)
            echo 'error';
        else
            echo 'succ';
               
    }   
    
	
	function edit_quote($i_quote_id)
	{
		$this->data['i_quote_id'] = decrypt($i_quote_id);
		//$i_tradesman_user_id  =  decrypt($this->data['loggedin']['user_id']);
		$this->load->view('fe/tradesman/edit_quote.tpl.php',$this->data);	
	}
	
   public function do_quote_update()
	{
		if($_POST)
		{
			$s_quote_id = $this->input->post('h_quote_id');
			$txt_quote = $this->input->post('txt_quote');
			
			$arr1 = array();
			$arr1['d_quote'] = doubleval($txt_quote);
			$table = $this->db->JOBQUOTES;
			$cond = array('id'=>$s_quote_id);
			//echo $s_quote_id.'========'.$txt_quote;
			if($this->job_model->set_data_update($table,$arr1,$cond))
			{
				$msg = '1|Your quote has been updated successfully';
			}	
			else
				$msg = '2|Your quote price updation failed. Please try again..';
		}
		else
		{
			$msg = $msg = '2|Your quote price updation failed. Please try again..';
		}
		echo $msg;
	}	
	
	function delete_watch_list($i_watch_list_id)
	{
		$this->data['i_watch_list_id'] = decrypt($i_watch_list_id);
		//$i_tradesman_user_id  =  decrypt($this->data['loggedin']['user_id']);
		$this->load->view('fe/tradesman/delete_watch_list.tpl.php',$this->data);	
	}
	
	
	function do_delete_watch_list()
	{
		$i_watch_list_id = $this->input->post('i_watch_list_id');
		//echo $i_watch_list_id.'====';
		if($_POST)
		{
			$table = $this->db->JOB_WATCHLIST;
			$cond = array('id'=>$i_watch_list_id);
			if($this->job_model->set_data_delete($table,$cond))
			{
				$msg = '1|Job has been deleted form your watchlist.';
			}	
			else
				$msg = '2|Job has not been deleted form your watchlist.';
		}
		else
			$msg = '2|Job has not been deleted form your watchlist.';
			
		echo $msg;			
		
	}
	
	
	/* fetch all jobs*/
   public function lost_jobs()
   {
   		try
		{
			//$this->i_sub_menu_id	=	7;
			$this->data['breadcrumb'] = array('Lost Jobs'=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			
			$s_where = " WHERE n.i_tradesman_user_id = {$this->user_id} And (job.i_status=3 OR job.i_status=4 OR job.i_status=5 OR job.i_status=6 OR job.i_status=8 OR job.i_status=9 OR job.i_status=10 OR job.i_status=11) AND job.i_tradesman_id!={$this->user_id}"; 
			$this->data['i_total_lost_jobs'] = $this->job_model->gettotal_lost_jobs_info($s_where);
			
			
			ob_start();
			$this->lost_jobs_pagination_ajax();
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
   
   /* Ajax pagination for all jobs */
	function lost_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_tradesman_user_id = {$this->user_id} And (job.i_status=3 OR job.i_status=4 OR job.i_status=5 OR job.i_status=6 OR job.i_status=8 OR job.i_status=9 OR job.i_status=10 OR job.i_status=11) AND job.i_tradesman_id!={$this->user_id}";  

		$limit	= $this->i_fe_page_limit;			
		
		$this->data['job_list']	= $this->job_model->fetch_lost_jobs_multi($s_where,intval($start),$limit);		
		//pr($this->data['job_list']);
		$total_rows = $this->job_model->gettotal_lost_jobs_info($s_where);	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'tradesman/lost_jobs_pagination_ajax/';
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
		
		$this->load->view('fe/tradesman/ajax_lost_jobs.tpl.php',$this->data);
			
	}   
		
	function verify_profile()
	{
   		try
		{
			$this->i_sub_menu_id	=	22;
			$this->data['breadcrumb'] = array('Verify Profile'=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;	
			
			$s_where = " WHERE i_user_id={$this->user_id} AND n.i_verification_type=1 AND n.i_verifcation_status=3"	;
			$this->data['chk_credential'] = $this->tradesman_model->gettotal_verification_info($s_where);
			
			$s_where = " WHERE i_user_id={$this->user_id} AND n.i_verification_type=2 AND n.i_verifcation_status=3"	;
			$this->data['chk_phone'] = $this->tradesman_model->gettotal_verification_info($s_where);

			//$s_where = " WHERE i_user_id={$this->user_id} AND n.i_verification_type=3 AND n.i_verifcation_status=3"	;
			//$this->data['chk_facebook'] = $this->tradesman_model->gettotal_verification_info($s_where);
			$user_details	=	$this->mod_trades->fetch_this($this->user_id);
			$this->data['chk_facebook'] = $user_details['i_verify_facebook'];
			//pr($this->data['user_details']);
			//echo $this->data['chk_credential'].'===='.$this->data['chk_phone'].'====='.$this->data['chk_facebook'];
				
			$this->render();
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
	}
	
	function verify_facebook()
	{
		$this->load->view('fe/tradesman/verify_facebook.tpl.php',$this->data);
	}
	
	function do_facebook_verification()
	{
		$s_where = " WHERE i_user_id={$this->user_id} AND n.i_verification_type=3 AND n.i_verifcation_status=3"	;
		$tot = $this->tradesman_model->gettotal_verification_info($s_where);
		if($tot>0)
		{
			$msg = '2|Your account has been already verified.';	
			echo $msg;
			return;
		}
	
		$this->load->model('job_model');
		$profile_name =  $this->input->post('txt_profile_name');
		@$op = file_get_contents('http://graph.facebook.com/'.$profile_name);
		$aa = json_decode($op);
		//var_dump($aa);
		if(!empty($aa))
		{
			$info = array();
			$info['i_verify_facebook'] = 1; 
			$table = $this->db->TRADESMANDETAILS;
			$cond = array('i_user_id '=>$this->user_id);
			$i_newid = $this->job_model->set_data_update($table,$info,$cond);		
			
			$info = array();
			$info['i_user_id'] = $this->user_id; 
			$info['i_verification_type'] = 3; 
			$info['i_created_on'] = time(); 
			$info['i_verifcation_status'] = 3; 
			$table = $this->db->TRADESMAN_VERIFICATION;
			//$cond = array('id '=>$i_job_id);
			$i_newid = $this->job_model->set_data_insert($table,$info);	
				
			$msg = '1|Feedback verification done sucessfully';	
		}
		else
			$msg = '2|Your facebook account is not verified';	
		
		echo $msg;
	}
	
	function verify_phone()
	{
		$this->load->view('fe/tradesman/verify_phone.tpl.php',$this->data);
	}	
	
	function do_phone_verification()
	{	
		$s_where = " WHERE i_user_id={$this->user_id} AND n.i_verification_type=2 AND n.i_verifcation_status!=2"	;
		$tot = $this->tradesman_model->gettotal_verification_info($s_where);
		if($tot>0)
		{
			$msg = '2|Your phone number verification request has already been sent.';	
			echo $msg;
			return;
		}
		
		$this->load->model('job_model');
		$info = array();
		$info['i_user_id'] = $this->user_id; 
		$info['i_verification_type'] = 2; 
		$info['i_created_on'] = time(); 
		$info['i_verifcation_status'] = 1; 
		$table = $this->db->TRADESMAN_VERIFICATION;
		//$cond = array('id '=>$i_job_id);
		$i_newid = $this->job_model->set_data_insert($table,$info);	
		
		if($i_newid)
		{
				
		   /* for job posting mail to the user */
		   $this->load->model('auto_mail_model');
		   $content = $this->auto_mail_model->fetch_contact_us_content('phone_number_verification','general');	
		   $mail_subject = $content['s_subject'];	
		   
		   $filename = $this->config->item('EMAILBODYHTML')."common.html";
		   $handle = @fopen($filename, "r");
		   $mail_html = @fread($handle, filesize($filename));				
			//print_r($content); exit;
			if(!empty($content))
				{							
					$description = $content["s_content"];
					$description = str_replace("[Professional name]",$this->data['profile_info']['s_username'],$description);
					$description = str_replace("[Phone Number]",$this->data['profile_info']['s_contact_no'],$description);	
					$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
				}
			unset($content);
			
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
							
			$this->email->to($site_admin_email);
			
			$this->email->subject($mail_subject);
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
			
		/* end job posting mail to the user */				
	
			$msg = '1|Request has been sent sucessfully';	
		}
		else
			$msg = '2|Request has not been sent sucessfully';	
		echo $msg;	
	}
	
	
	function verify_credentials()
	{
		$this->load->view('fe/tradesman/verify_credentials.tpl.php',$this->data);
		
	}
	
	function do_credentials_verification()
	{
		$cnt = 0;
		foreach($_FILES as $key=>$file)
		{
			if ( $file['name']!='')
			{
				$ext1 = getExtension($file['name']);	
				if ( $ext1!=".docx" && $ext1!=".pdf" && $ext1!=".doc") 
					$cnt++;
			}
				
		}
		if($cnt>0)
		{	
			echo '2|You can only upload doc, docx and pdf';
			return;
		}
		
/*		$s_where = " WHERE i_user_id={$this->user_id} "	;
		$tot = $this->tradesman_model->gettotal_credential_file_info($s_where);
		$tot_upload = $tot+$cnt;
		if($tot_upload>3)
		{	
			if($tot==3)		
				$msg = '2|You have already uploaded '.$tot.' file(s)';	
			else
				$msg = '2|You have already uploaded '.$tot.' file(s). Now you can upload only '.(3-$tot).' file(s).';		
			echo $msg;
			return;
		}*/
		
		$s_where = " WHERE i_user_id={$this->user_id} AND n.i_verification_type=1 AND n.i_verifcation_status!=2"	;
		$tot = $this->tradesman_model->gettotal_verification_info($s_where);
		if($tot>0)
		{
			$msg = '2|Your credential verification request has already been sent.';	
			echo $msg;
			return;
		}		
	
	
	
		$flag = false;
		foreach($_FILES as $key=>$file)
		{
			$i = substr($key,-1);
			if ( $file['name']!='') 
			{
				$ext1 = getExtension($file['name']);					
				if ( $ext1==".docx" || $ext1==".pdf" || $ext1==".doc") 
				{		
					$this->imagename = 'credentials_'.$i.'_'.time();
					$this->upload_image = $this->config->item('credentials_file_upload_path').$this->imagename;	
					$max_file_size    = $this->config->item('jcredentials_file_upload_max_size');
					$img_details = upload_file($this,
						array('upload_path' => $this->config->item('credentials_file_upload_path'),
							  'file_name'	=> $this->imagename.$ext1 ,
							  'allowed_types' => 'docx|pdf|doc',	
							  'max_size' => $max_file_size,
							  'max_width' => '0',
							  'max_height' => '0',
							  ), 'crd_file_'.$i
						);
						
					$flag = true;
					$this->load->model('job_model');
					$info = array();
					$info['i_user_id'] = $this->user_id; 
					$info['s_file_name'] = $this->imagename.$ext1; 
					$info['i_created_on'] = time(); 
					$table = $this->db->CREDENTIAL_FILE;
					$this->job_model->set_data_insert($table,$info);	
							
				} // end of extension checking
				else
				{ 	
					echo '2|You can only upload doc, docx and pdf';
					return;
				}	
			} // end if
			
		}	// end of foreach	
		if($flag)
		{
					$info = array();
					$info['i_user_id'] = $this->user_id; 
					$info['i_verification_type'] = 1; 
					$info['i_created_on'] = time(); 
					$info['i_verifcation_status'] = 1; 
					$table = $this->db->TRADESMAN_VERIFICATION;
					$i_newid = $this->job_model->set_data_insert($table,$info);	
					
					
				   /* for job posting mail to the user */
				   $this->load->model('auto_mail_model');
				   $content = $this->auto_mail_model->fetch_contact_us_content('credential_verification','general');	
				   $mail_subject = $content['s_subject'];	
				   
				   $filename = $this->config->item('EMAILBODYHTML')."common.html";
				   $handle = @fopen($filename, "r");
				   $mail_html = @fread($handle, filesize($filename));				
					//print_r($content); exit;
					if(!empty($content))
						{							
							$description = $content["s_content"];
							$description = str_replace("[Professional name]",$this->data['profile_info']['s_username'],$description);
							//$description = str_replace("[Phone Number]",$this->data['profile_info']['s_contact_no'],$description);	
							$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
						}
					unset($content);
					
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
									
					$this->email->to($site_admin_email);
					
					$this->email->subject($mail_subject);
					$this->email->message($mail_html);
					
					if(SITE_FOR_LIVE)///For live site
					{				
						$i_nwid = $this->email->send();	
																
					}
					else{
						$i_nwid = TRUE;				
					}				
		}
			
		
		echo ($flag) ? '1|File uploaded sucessfully' : '2|File not uploaded sucessfully';
		
	}
	
	public function my_invoice()
	{
		try
		{
			$this->i_sub_menu_id=23;
			$this->load->model('site_revenue_model','mod_srev');
			$s_where="";
			$info = $this->mod_srev->fetch_multi_total_site_revenue($s_where,intval($start),$limit);
			pr($info,1);
			
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

