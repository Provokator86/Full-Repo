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
          $this->data['title']="Dashboard";////Browser Title
		  $this->data['ctrlr'] = "home";
		  //pr(  $this->data['loggedin']); exit;
		  if(empty( $this->data['loggedin']) || decrypt($this->data['loggedin']['user_type_id'])!=1)
			{
				redirect(base_url()."home");
				exit;
			}
		  
		  $this->cls_msg=array();
		  $this->cls_msg["save_pwd"]=" Password changed successfully.";
		  $this->cls_msg["save_pwd_err"]=" Password changed could not saved.";
		  $this->cls_msg["wrong_pwd"]=" Existing password does not match.";
		  
		  $this->cls_msg["save_comment"]=" Comment saved successfully.";
		  $this->cls_msg["save_comment_err"]=" Failed to save comment.";
		  
		  $this->cls_msg["save_email_setting"]=" Email setting saved successfully.";
		  
		  $this->cls_msg["save_contact_succ"] = " Contact details saved succesfully";
          $this->cls_msg["save_contact_err"] = " Contact details could not be saved";  
		  $this->cls_msg["save_profile"] = " Your profile has been updated.";
		  $this->cls_msg["save_profile_err"] = " Profile details could not saved";  
          
          $this->cls_msg["save_edit_job_succ"] = " Job saved successfully";
          $this->cls_msg["save_edit_job_err"] = " Job could not saved"; 
		  
		  $this->cls_msg["save_repost_job_succ"] = " Your job will need to be reveiwed before being reposted,we will email once this is done";
		  
		  $this->cls_msg["save_testi"]="testimonial saved successfully.";
		  $this->cls_msg["save_testi_err"]="testimonial saved failure.";
		  
		  $this->cls_msg["save_job_quote"]="Quote days saved successfully.";
		  $this->cls_msg["save_job_quote_err"]="Quote days saved failure.";
		  
		  
		  $this->cls_msg["invalid_job_err"] = "Job not exist.";
		  $this->cls_msg["job_del"] = "Job deleted successfully.";
		  $this->cls_msg["job_del_err"] = "Job not deleted.";
		  
		  $this->cls_msg["job_assign"] = "Quote accepted successfully.";
		  $this->cls_msg["job_assign_err"] = "Quote acceptance failed.";
		  
		  $this->cls_msg["job_terminate"] = "Job terminated successfully.";
		  $this->cls_msg["job_terminate_err"] = "Job termination failed.";		  
		  
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  $this->load->model('manage_buyers_model','mod_buyer');
		  $this->load->model('job_model');	
		  
		  $user_details = $this->data['loggedin'];
		  $this->data['name']	=	$user_details['user_name'];
		  $this->user_id 		=	decrypt($user_details['user_id']);
		  
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
		  
		  /* profile Image */
		  $this->allowedExt = 'jpg|jpeg|png';	
		  $this->uploaddir = $this->config->item('user_profile_image_upload_path');	
		  $this->thumbdir = $this->config->item('user_profile_image_thumb_upload_path');
		  $this->thumbDisplayPath = $this->config->item('user_profile_image_thumb_path');
		  $this->thumb_ht = $this->config->item('user_profile_photo_upload_thumb_height');	
		  $this->thumb_wd = $this->config->item('user_profile_photo_upload_thumb_width');
		  
		  
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
			//echo $this->user_id;exit;	
			$this->load->model('manage_buyers_model');	
			$this->data['pathtoclass']=$this->pathtoclass;
			$this->data['breadcrumb'] = array('Dashboard'=>'');
			$this->data['dt_current_time'] = date("l d M, Y H:i",time());
			$s_where = " WHERE n.i_buyer_user_id={$this->user_id} AND n.i_status=1 AND n.i_is_deleted!=1"; 
			$this->data['open_jobs'] = $this->job_model->fetch_multi($s_where,0,2);
			//pr($this->data['open_jobs']);
			$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_status=5 AND n.i_is_deleted!=1"; 			
		    $this->data['feedback_job_list']	= $this->job_model->fetch_multi($s_where,0,2);	
			$this->data['user_details'] = $this->manage_buyers_model->fetch_this($this->user_id);
			//pr($this->data['user_details']);exit;
			
			//$s_wh_pmb = " WHERE pd.i_receiver_id = {$this->user_id} AND pd.i_status=1 AND FROM_UNIXTIME( pd.i_date , '%Y-%m-%d')= CURDATE()";
			$s_wh_pmb = " WHERE pd.i_receiver_id = {$this->user_id} AND pd.i_status=1 AND  pd.i_receiver_view_status = 0 ";
			$this->load->model('private_message_model');
			$this->data['new_msg'] = $this->private_message_model->gettotal_pmb_info($s_wh_pmb);
				
			//echo $this->db->last_query(); exit;
			//pr($this->data['feedback_job_list']);
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
			$this->i_sub_menu_id	=	1;
			$this->data['pathtoclass']=$this->pathtoclass;
			$user_details = $this->session->userdata('loggedin');
			$this->data['user_id']	=	$user_details['user_id'];
			$info	=	$this->mod_buyer->fetch_this($this->user_id);
           
            $posted["txt_name"] = $info["s_name"] ;
            $posted["txt_username"] = $info["s_username"] ; 
            $posted["txt_email"] = $info["s_email"] ; 
            $posted["txt_dob"] = $info["s_dob"] ;   
            $posted["image"] = $info["image"] ;
            $posted["chk_newletter"] = $info["chk_newletter"]; 
            $this->data['posted'] = $posted;
			//echo $this->user_id;
			//pr($this->data['info']); exit;
			$image_exist	=	$this->data['posted']['image'][0]['s_user_image']; 
			$this->data['breadcrumb'] = array('Edit Profile'=>'');
			//print_r($this->data['info']); exit;
			$this->add_css('css/fe/dd.css');
			$this->add_js('js/fe/jquery.dd.js');
			//$this->load->model('city_model');
			//$this->load->model('state_model');
			//$this->load->model('zipcode_model');
			
			if($_POST)
			{				
				$posted=array();
                $posted["txt_name"]			= trim($this->input->post("txt_name"));
				$posted["txt_email"]		= trim($this->input->post("txt_email"));
				$posted["txt_username"]		= trim($this->input->post("txt_username"));
				$posted["txt_dob"]			= trim($this->input->post("txt_dob"));
				$posted["chk_newletter"]	= intval($this->input->post("chk_newletter"));
				$posted["h_image_name"]		= trim($this->input->post("h_image_name"));
				
				//print_r($posted); exit;
				
				if(isset($_FILES['f_image']) && !empty($_FILES['f_image']['name']))
				{
					$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'f_image','','',$this->allowedExt);					
					$arr_upload_res = explode('|',$s_uploaded_filename);
				}
				
				
				$this->form_validation->set_rules('txt_name', 'name', 'required');
				$this->form_validation->set_rules('txt_email', 'email', 'valid_email|required');
				$this->form_validation->set_rules('txt_username', 'username', 'required');
					
				
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
						$info["s_username"]		=	$posted["txt_username"];
						$info["i_dob"]			=	convert_date_mdy_format($posted["txt_dob"]);  ////////This function written in helper.php
						$info["chk_newletter"]	=	$posted["chk_newletter"];
						$info["i_edited_date"]	=	time();
                        
                        //////////This value is for News Subscription 
                        if($info["chk_newletter"])
                        {
                            $info['i_user_id']      =   $this->user_id;
                            $info['dt_entry_date']  =   time();
                            $info['i_status']       =  1;
                            $info['i_user_type']    =  1;
						}
						if(count($arr_upload_res)==0)
						{
							$info["s_user_image"] = 	$posted['h_image_name'];
						}
						else
						{
							$info["s_user_image"] = 	$arr_upload_res[2];
						}
						
						/* start  latitude and longitude  */
/*					$state = $this->state_model->fetch_this($info["i_province_id"]);
					$city = $this->city_model->fetch_this($info["i_city_id"]);
					$zipcode = $this->zipcode_model->fetch_this($info["i_zipcode_id"]);
					
				 	$address = utf8_encode($info["s_address"].','.$state['state'].','.$city['city'].','.$zipcode['postal_code']);					
					// call geoencoding api with param json for output
					$geoCodeURL = "http://maps.google.com/maps/api/geocode/json?address=".
								  urlencode($address)."&sensor=false";
					
					$result = json_decode(file_get_contents($geoCodeURL), true);					
					$info['s_lat'] = ($result["results"][0]["geometry"]["location"]["lat"]) ? @$result["results"][0]["geometry"]["location"]["lat"] : 0;
    				$info['s_lng'] = ($result["results"][0]["geometry"]["location"]["lng"]) ? @$result["results"][0]["geometry"]["location"]["lng"]:0;
*/					/* end  latitude and longitude  */
						
						
						//print_r($info); echo decrypt($id); exit;
						//pr($info); exit;
						$i_newid = $this->mod_buyer->set_edit_profile($info,$this->user_id );
						if(!empty($image_exist))
						{
							$i_image	=	$this->mod_buyer->update_profile_image($info,$this->user_id);
						}
						else 
						{
							$i_image	=	$this->mod_buyer->insert_profile_image($info,$this->user_id);
						}
						
						//echo $i_newid; exit;
						if($i_newid)////saved successfully
						{
							//// Creating thumb image
							if($arr_upload_res[0]==='ok')
							{
								get_image_thumb($this->uploaddir.$info["s_user_image"], $this->thumbdir, 'thumb_'.$info["s_user_image"],$this->thumb_ht,$this->thumb_wd,'');
							}						
							
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_profile"],'message_type'=>'succ'));
							redirect(base_url().'buyer/edit_profile');
						}
						else///Not saved, show the form again
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_profile_err"],'message_type'=>'err'));
							redirect(base_url().'buyer/edit_profile');
						}
						
					
					}					
			
			}			
			
			
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
			$this->i_sub_menu_id	=	2;
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
				$is_pwd_correct	=	$this->mod_buyer->check_password($user_data['s_password'],$this->user_id);
				
				 if($this->form_validation->run() == FALSE || empty($is_pwd_correct))/////invalid
					{
						if(empty($is_pwd_correct))
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["wrong_pwd"],'message_type'=>'err'));
							redirect(base_url().'buyer/change_password');
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
							redirect(base_url().'buyer/change_password');
						}
						else///Not saved, show the form again
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_pwd_err"],'message_type'=>'err'));
							$this->render('buyer/change_password');
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
			$this->i_sub_menu_id	=	3;			
			$this->data['pathtoclass']=$this->pathtoclass;
            $this->data['breadcrumb'] = array('Contact Details'=>'');  
			$user_details = $this->session->userdata('loggedin');
			$this->data['user_id']	=	$user_details['user_id'];
            $this->load->model('city_model');
            $this->load->model('state_model');
            $this->load->model('zipcode_model');
            if($_POST)
            {
                $posted=array();
                $posted["txt_contact"]      =   trim($this->input->post("txt_contact"));
                $posted["txt_fax"]          =   trim($this->input->post("txt_fax"));
                $posted["txt_landline"]     =   trim($this->input->post("txt_landline"));
                $posted["txt_skype"]        =   trim($this->input->post("txt_skype"));
                $posted["txt_msn"]          =   trim($this->input->post("txt_msn"));
                $posted["txt_yahoo"]        =   trim($this->input->post("txt_yahoo"));
                $posted["txt_address"]      =   trim($this->input->post("txt_address"));
                $posted["opt_province_id"]  =   trim($this->input->post("opt_state"));
                $posted["opt_city_id"]      =   trim($this->input->post("opt_city"));
                $posted["i_zipcode_id"]     =   trim($this->input->post("opt_zip"));
                
                $this->form_validation->set_rules('txt_contact', 'provide contact number', 'required');  
                $this->form_validation->set_rules('txt_address', 'address', 'required');
                $this->form_validation->set_rules('opt_state', 'select province', 'required');
                $this->form_validation->set_rules('opt_city', 'select city', 'required');
                $this->form_validation->set_rules('opt_zip', 'select postal code', 'required');
                
                 if($this->form_validation->run() == FALSE)/////invalid
                    {
                        ///Display the add form with posted values within it////
                        $this->data["posted"]=$posted;
                    }
                else
                    {
                        //pr($posted);
                        
                        $info=array();
                        $info["s_contact_no"]   =   $posted["txt_contact"]; 
                        $info["s_fax"]          =   $posted["txt_fax"];
                        $info["s_landline"]     =   $posted["txt_landline"];
                        $info["s_skype_id"]     =   $posted["txt_skype"];
                        $info["s_msn_id"]       =   $posted["txt_msn"];
                        $info["s_yahoo_id"]     =   $posted["txt_yahoo"];
                        $info["s_address"]      =   $posted["txt_address"]; 
                        $info["i_province_id"]  =   $posted["opt_province_id"];
                        $info["i_city_id"]      =   $posted["opt_city_id"];
                        $info["i_zipcode_id"]   =   $posted["i_zipcode_id"];
                        
                        
                        
                        /* start  latitude and longitude  */
                        $state = $this->state_model->fetch_this(decrypt($info["i_province_id"]));
                        $city = $this->city_model->fetch_this(decrypt($info["i_city_id"]));
                        $zipcode = $this->zipcode_model->fetch_this(decrypt($info["i_zipcode_id"]));
                        
                        $address = utf8_encode($info["s_address"].','.$state['state'].','.$city['city'].','.$zipcode['postal_code']);                  
                        // call geoencoding api with param json for output
                        $geoCodeURL = "http://maps.google.com/maps/api/geocode/json?address=".
                                      urlencode($address)."&sensor=false";
                        
                        $result = json_decode(file_get_contents($geoCodeURL), true);                    
                        $info['s_lat'] = ($result["results"][0]["geometry"]["location"]["lat"]) ? @$result["results"][0]["geometry"]["location"]["lat"] : 0;
                        $info['s_lng'] = ($result["results"][0]["geometry"]["location"]["lng"]) ? @$result["results"][0]["geometry"]["location"]["lng"]:0;
                        /* end  latitude and longitude  */
                        
                        $i_newid = $this->mod_buyer->set_contact_details($info,$this->user_id );
                        if($i_newid)////saved successfully
                        {
                            $this->session->set_userdata(array('message'=>$this->cls_msg["save_contact_succ"],'message_type'=>'succ'));
                            redirect(base_url().'buyer/contact_details');
                        }
                        else///Not saved, show the form again
                        {
                            $this->session->set_userdata(array('message'=>$this->cls_msg["save_contact_err"],'message_type'=>'err'));
                            redirect(base_url().'buyer/contact_details'); 
                        }
                    } 
            }
            else
            {
                $info    =    $this->mod_buyer->fetch_this($this->user_id ); 
				
                $posted["txt_contact"] = $info["s_contact_no"] ; 
                $posted["txt_fax"]  = $info["s_fax"] ; 
                $posted["txt_landline"] = $info["s_landline"] ; 
                $posted["txt_skype"] = $info["s_skype_id"] ; 
                $posted["txt_msn"] = $info["s_msn_id"] ; 
                $posted["txt_yahoo"] = $info["s_yahoo_id"] ; 
                $posted["txt_address"] = $info["s_address"] ; 
                $posted["opt_province_id"] = $info["opt_state"] ;
                $posted["opt_city_id"] = $info["opt_city"] ;
                $posted["i_zipcode_id"] = $info["opt_zip"] ;
				$posted['s_zip'] = $info['s_zip'];
                
                $this->data['posted']   = $posted;
            }
			
			//print_r($this->data['contact_details']);
			
			$this->render('buyer/contact_details');
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
	
	/* public function set_contact_details()
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
						
						$i_newid = $this->mod_buyer->set_contact_details($info,$this->user_id );
						if($i_newid)////saved successfully
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_contact"],'message_type'=>'succ'));
							redirect(base_url().'buyer/contact_details');
						}
						else///Not saved, show the form again
						{
							set_error_msg($this->cls_msg["save_err"]);
							$this->render('buyer/contact_details');
						}
						
					
					}	
				
			}
			
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	 */
	/* email settings for tradesman */
	 public function email_settings()
    {
        try
        {
			$this->i_sub_menu_id=14;
			
			$this->data['pathtoclass']=$this->pathtoclass;
			$user_details = $this->session->userdata('loggedin');
			$this->data['breadcrumb'] = array('Email Settings'=>'');	
			$this->data['user_id']	=	$user_details['user_id'];
			if($_POST)
			{
				$posted	=	array();
				$posted["chk_trade_place_quote"]		=	trim($this->input->post("chk_trade_place_quote"));
				$posted["chk_trade_accept_reject_job"]	=	trim($this->input->post("chk_trade_accept_reject_job"));
				$posted["chk_trade_submit_msg"]			=	trim($this->input->post("chk_trade_submit_msg"));
				$posted["chk_trade_asked_feedback"]		=	trim($this->input->post("chk_trade_asked_feedback"));
				$posted["chk_admin_approved_reject_job"]=	trim($this->input->post("chk_admin_approved_reject_job"));
				
				$posted["chk_trade_review_rating"]		=	trim($this->input->post("chk_trade_review_rating"));
				
				//$this->form_validation->set_rules('chk_trade_place_quote', 'select Tradesman has placed Quote against your Job', 'required');
				
				if(empty($posted))/////invalid
					{
						///Display the add form with posted values within it////
						$this->data["posted"]=$posted;
					}
				else
				{					
						
						$info=array();
						$info["chk_trade_place_quote"]			=	$posted["chk_trade_place_quote"];
						$info["chk_trade_accept_reject_job"]	=	$posted["chk_trade_accept_reject_job"];
						$info["chk_trade_submit_msg"]			=	$posted["chk_trade_submit_msg"];
						$info["chk_trade_asked_feedback"]		=	$posted["chk_trade_asked_feedback"];
						$info["chk_admin_approved_reject_job"]	=	$posted["chk_admin_approved_reject_job"];
						
						$info["chk_trade_review_rating"]		=	$posted["chk_trade_review_rating"];
						
						//print_r($info); exit;
						
						$i_newid = $this->mod_buyer->set_email_settings($info,$this->user_id);
						if($i_newid)////saved successfully
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_email_setting"],'message_type'=>'succ'));
							redirect(base_url().'buyer/email_settings');
						}
						else///Not saved, show the form again
						{
							set_error_msg($this->cls_msg["save_err"]);
							$this->render('buyer/email_settings');
						}					
					
					
				}	
			}
			
			$s_user_id	=	" WHERE n.i_user_id=".$this->user_id." ";
			
			$this->data['email_key']	=	$this->mod_buyer->fetch_email_keys($s_user_id,'','');
			
			//pr($this->data['email_key']);exit;
			
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
		
	
	
	
	 public function buyer_testimonial()
    {
        try
        {
			$this->i_sub_menu_id	=	16;	
			$this->data['pathtoclass']=$this->pathtoclass;
			$user_details = $this->session->userdata('loggedin');
			$user_name	=	$user_details['user_name'];
			//print_r($user_details);
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
						
						$i_newid = $this->mod_buyer->add_new_testimonial($info,$user_name);
						if($i_newid)////saved successfully
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_testi"],'message_type'=>'succ'));
							redirect(base_url().'buyer/buyer_testimonial');
						}
						else///Not saved, show the form again
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_testi_err"],'message_type'=>'err'));
							$this->render('buyer/buyer_testimonial');
						}
						
					
					}	
				
			
			}
			
			$this->data['breadcrumb'] = array('My Testimonial'=>'');
			$s_wh_testi	=	" WHERE n.s_person_name='".$user_details['user_name']."' ";
			// pagination start
			
			$this->load->model('testimonial_model');
			$start = ($this->uri->segment($this->i_uri_seg)) ? $this->uri->segment($this->i_uri_seg) : 0;
			$limit	= $this->i_fe_page_limit;
			$this->data['testimonial_list']	=	$this->mod_buyer->fetch_testimonial($s_wh_testi,intval($start), $limit);
			
			//pr($this->data['testimonial_list']);
			$i_total_no = $this->testimonial_model->gettotal_info($s_wh_testi);
			$s_pageurl = base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
			$i_uri_segment = $this->i_fe_uri_segment;
			
			$this->data['pagination'] = $this->get_fe_pagination($s_pageurl,$i_total_no,$limit,$i_uri_segment);
			 
			$this->render('buyer/buyer_testimonial');
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
			
			$this->data['breadcrumb'] = array('My Private Message Board'=>'');
			$this->add_css('css/fe/dd.css');
			$this->add_js('js/fe/jquery.dd.js');
			
			$user_details = $this->session->userdata('loggedin');
			$this->data['user_id']	=	$user_details['user_id'];
			
			
			/* for searching with job */
			$sessArrTmp = array();
/*			if($opd_job)
			{
				$sessArrTmp['src_job_id']  = $opd_job;
			}
			elseif($_POST)
			{				
				$sessArrTmp['src_job_id']  = ($opd_job) ? $opd_job : trim($this->input->post('opd_job'));				
			}*/
			if($_POST)
			{
				$sessArrTmp['src_job_id']  = trim($this->input->post('opd_job'));
			}
			
			$this->session->set_userdata(array('model_session'=>$sessArrTmp));	// to store data in session
			$this->data['posted'] = $sessArrTmp;
			//var_dump(decrypt($this->data['posted']['src_job_id']));exit;
			$s_wh_pmb='';
			$sessArrTmp['src_job_id']  = $this->get_session_data('src_job_id');
			
			$arr_search[]	=	" n.i_is_deleted=1 ";
			if($sessArrTmp['src_job_id'])
			{
				$arr_search[] =" n.i_job_id=".decrypt($sessArrTmp['src_job_id']);
			}			
			
			$s_wh_pmb .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
			
			// pagination start
			
			$this->load->model('manage_private_message_model','mod_pmb');
			$start = ($this->uri->segment($this->i_uri_seg)) ? $this->uri->segment($this->i_uri_seg) : 0;
			$limit	= $this->i_fe_page_limit;
			$this->data['pmb_list']	=	$this->mod_buyer->fetch_pmb($s_wh_pmb,intval($start), $limit);
			
			//print_r($this->data['pmb_list']);			
			
			$i_total_no = $this->mod_pmb->gettotal_info($s_wh_pmb);
			$s_pageurl = base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
			$i_uri_segment = $this->i_fe_uri_segment;
			
			$this->data['pagination'] = $this->get_fe_pagination($s_pageurl,$i_total_no,$limit,$i_uri_segment);
			
			
			$this->render('buyer/private_message_board');
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
			
			$this->data['breadcrumb'] = array('My Private Message Board'=>base_url().'buyer/private_message_board','My Private Message Board Details '=>'');
			
			$pmb_id	=	decrypt($i_id);
			$s_where	=	" WHERE pd.i_msg_board_id = ".$pmb_id." ";
		    $this->data['pmb_details'] =  $this->mod_buyer->fetch_this_pmb($s_where,'','');
			$this->data['msg_id']	=	$pmb_id	;
			
			//print_r($this->data['pmb_details']);
			
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
						$fetch_receiver_id	=	$this->mod_buyer->fetch_pmb($s_wh,'','');	
						//print_r($fetch_receiver_id);	 exit;				
						
						$info=array();
						$info['i_msg_board_id']	=	$pmb_id;
						$info['s_content']		=	$posted["txt_comment"];
						$info['i_sender_id']	=	$this->user_id;
						$info['i_receiver_id']	=	$fetch_receiver_id[0]['i_tradesman_id'];
						$info['i_date']			=	time();
						
						
						$i_newid = $this->mod_buyer->set_new_message_details($info);
						if($i_newid)////saved successfully
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_comment"],'message_type'=>'succ'));	
							redirect(base_url().'buyer/private_message_details/'.$i_id);
						}
						else///Not saved, show the form again
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["save_comment_err"],'message_type'=>'err'));
							$this->render('buyer/private_message_details/'.$i_id);
						}
						
					
					}	
				
			
			}
			
			//print_r($this->data['pmb_details']);
			
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	
	/* fetch all jobs*/
   public function all_jobs()
   {
   		try
		{
			$this->i_sub_menu_id	=	5;
			$this->data['breadcrumb'] = array('All Jobs'=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			
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
   
   /* Ajax pagination for all jobs */
	function all_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_is_deleted!=1"; 

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
		
		$this->load->view('fe/buyer/ajax_all_jobs.tpl.php',$this->data);
			
	}	   
	
	
	/* fetch active jobs*/
   public function active_jobs()
   {
   		try
		{
			$this->i_sub_menu_id	=	6;
			$this->data['breadcrumb'] = array('Active Jobs'=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			
			ob_start();
			$this->active_jobs_pagination_ajax();
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
   
   /* Ajax pagination for active jobs */
	function active_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_is_deleted!=1 AND n.i_status=1"; 

		$limit	= $this->i_fe_page_limit;			
			
		$this->data['job_list']	= $this->job_model->fetch_multi($s_where,intval($start),$limit);		

		$total_rows = $this->job_model->gettotal_info($s_where);	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'buyer/active_jobs_pagination_ajax/';
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
		
		$this->load->view('fe/buyer/ajax_active_jobs.tpl.php',$this->data);
			
	}	  	
	
	
	/* fetch frozen , In progress and feedback asked jobs*/
   public function assign_jobs()
   {
   		try
		{
			$this->i_sub_menu_id	=	7;
			$this->data['breadcrumb'] = array('Assigned Jobs'=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			
			ob_start();
			$this->assigned_jobs_pagination_ajax();
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
   
   /* Ajax pagination for active jobs */
	function assigned_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_is_deleted!=1 AND (n.i_status=4 OR n.i_status=5 OR n.i_status=8) "; 

		$limit	= $this->i_fe_page_limit;			
			
		$this->data['job_list']	= $this->job_model->fetch_multi($s_where,intval($start),$limit);		
		//pr($this->data['job_list']);
		$total_rows = $this->job_model->gettotal_info($s_where);	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'buyer/assigned_jobs_pagination_ajax/';
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
		
		$this->load->view('fe/buyer/ajax_assigned_jobs.tpl.php',$this->data);
			
	}	  	
	
	
	
   public function completed_jobs()
   {
   		try
		{
			$this->i_sub_menu_id	=	8;
			$this->data['breadcrumb'] = array('Completed Jobs'=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			
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
   
   /* Ajax pagination for active jobs */
	function completed_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_is_deleted!=1 AND n.i_status=6"; 

		$limit	= $this->i_fe_page_limit;			
			
		$this->data['job_list']	= $this->job_model->fetch_multi($s_where,intval($start),$limit);		
		//pr($this->data['job_list']);
		$total_rows = $this->job_model->gettotal_info($s_where);	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'buyer/completed_jobs_pagination_ajax/';
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
		
		$this->load->view('fe/buyer/ajax_completed_jobs.tpl.php',$this->data);
			
	}	  	
	
	
	
   public function expired_jobs()
   {
   		try
		{
			$this->i_sub_menu_id	=	9;
			$this->data['breadcrumb'] = array('Expired Jobs'=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;			
			ob_start();
			$this->expired_jobs_pagination_ajax();
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
   
   /* Ajax pagination for active jobs */
	function expired_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_is_deleted!=1 AND n.i_status=7"; 

		$limit	= $this->i_fe_page_limit;			
			
		$this->data['job_list']	= $this->job_model->fetch_multi($s_where,intval($start),$limit);		
		//pr($this->data['job_list']);
		$total_rows = $this->job_model->gettotal_info($s_where);	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'buyer/expired_jobs_pagination_ajax/';
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
		
		$this->load->view('fe/buyer/ajax_expired_jobs.tpl.php',$this->data);
			
	}	  		
	
	
	
	
	function buyer_quotes($i_job_id='')
	{
		$i_job_id = decrypt($i_job_id);
		$this->data['breadcrumb'] = array('Quote(s)'=>'');	
		$this->data['pathtoclass'] = $this->pathtoclass;
		$this->data['job_details'] = $this->job_model->fetch_this($i_job_id);
		$s_where = " WHERE n.i_job_id={$i_job_id} AND 	n.i_status!=3";
		$this->i_fe_uri_segment = 4;
		$start = ($this->uri->segment($this->i_fe_uri_segment)) ? $this->uri->segment($this->i_fe_uri_segment) : 0;
		$limit	= $this->i_fe_page_limit;		
		$i_total_no = $this->job_model->gettotal_quote_info($s_where);
		$s_pageurl = base_url().$this->router->fetch_class() . '/' . $this->s_action_name.'/'.encrypt($i_job_id);
		$i_uri_segment = $this->i_fe_uri_segment;
		$this->data['job_quote_details'] = $this->job_model->fetch_quote_multi($s_where,intval($start), $limit);
		$this->data['pagination'] = $this->get_fe_pagination($s_pageurl,$i_total_no,$limit,$i_uri_segment);
		//pr($this->data['job_quote_details']);
		//exit;
		
		$this->render();
	
	}
	
	function view_job($i_job_id='')
	{
		$i_job_id = decrypt($i_job_id);
		$this->i_sub_menu_id	=	6;
		$this->data['breadcrumb'] = array('Active Job'=>'');	
		$this->data['pathtoclass'] = $this->pathtoclass;
		$this->data['job_details'] = $this->job_model->fetch_this($i_job_id);
		$s_where = " WHERE n.i_job_id={$i_job_id} AND 	n.i_status!=3";
		$this->i_fe_uri_segment = 4;
		$start = ($this->uri->segment($this->i_fe_uri_segment)) ? $this->uri->segment($this->i_fe_uri_segment) : 0;
		$limit	= $this->i_fe_page_limit;		
		$i_total_no = $this->job_model->gettotal_quote_info($s_where);
		$s_pageurl = base_url().$this->router->fetch_class() . '/' . $this->s_action_name.'/'.encrypt($i_job_id);
		$i_uri_segment = $this->i_fe_uri_segment;
		$this->data['job_quote_details'] = $this->job_model->fetch_quote_multi($s_where,intval($start), $limit,"n.d_quote ASC");
		$this->data['pagination'] = $this->get_fe_pagination($s_pageurl,$i_total_no,$limit,$i_uri_segment);
		//pr($this->data['job_details']);
		//pr($this->data['job_quote_details']);
		//exit;
		
		$this->render();
	
	}	
    function edit_job($i_job_id='')
    {
        
        if(!empty($this->data['loggedin']) && decrypt($this->data['loggedin']['user_type_id'])!=1)
        {
                $this->session->set_userdata(array('message'=>$this->cls_msg["tradesman_job_post_err"],'message_type'=>'err'));
                redirect(base_url().'home/message');
        }
        
        $i_job_id = decrypt($i_job_id);
		
		$s_where = " WHERE n.id={$i_job_id }"; 
		$job_details = $this->job_model->fetch_this($i_job_id);		
		
		//echo date("Y-m-d",$job_details['i_approval_date']);exit;
		
        $this->i_sub_menu_id    =    6;
        $this->data['breadcrumb'] = array('Edit Job'=>'');    
        $this->data['pathtoclass'] = $this->pathtoclass;
        $o_ci = &get_config();
        $this->load->model('job_model','mod_'); 
        $this->data['file_location'] = $o_ci['job_file_upload_path'] ;
        $user_id = decrypt($this->data['loggedin']['user_id']);     
        if($_POST)
        {
                $posted=array();
                $posted["txt_title"]    = trim($this->input->post("txt_title"));
                $posted["opd_category_id"]= trim($this->input->post("opd_category_id"));
                $posted["opt_province_id"]= trim($this->input->post("opt_state"));
                $posted["opt_city_id"]= trim($this->input->post("opt_city"));
                $posted["i_zipcode_id"]= trim($this->input->post("opt_zip"));
                $posted["chk_supply_material"]= trim($this->input->post("chk_supply_material"));
                $posted["txt_description"]= trim($this->input->post("txt_description"));
                $posted["txt_keyword"]= trim($this->input->post("txt_keyword"));
                $posted["opd_quoting_period_days"]= trim($this->input->post("opd_quoting_period_days"));
                $posted["txt_budget_price"]= trim($this->input->post("txt_budget_price"));
                $posted["rd_available_time"]= trim($this->input->post("rd_available_time"));
                $posted["opd_available_time"]= trim($this->input->post("opd_available_time"));
                $posted["txt_time"]= trim($this->input->post("txt_time"));
                $posted["txt_time_from"]= trim($this->input->post("txt_time_from"));
                $posted["txt_time_to"]= trim($this->input->post("txt_time_to"));
            
                 
                $this->form_validation->set_rules('txt_title', 'provide job title', 'required');
                $this->form_validation->set_rules('opd_category_id', 'select category', 'required');
                $this->form_validation->set_rules('opt_state', 'select county', 'required');
                $this->form_validation->set_rules('opt_city', 'select city', 'required');
                $this->form_validation->set_rules('opt_zip', 'select postal code', 'required');
                $this->form_validation->set_rules('txt_description', 'select description', 'required');
                $this->form_validation->set_rules('txt_keyword', 'select keyword', 'required');
                $this->form_validation->set_rules('opd_quoting_period_days', 'select quote period days', 'required');
                $this->form_validation->set_rules('txt_budget_price', 'provide budget price', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
                    $info["i_buyer_user_id"]=$user_id;
                    $info["s_title"]=$posted["txt_title"];
                    $info["i_category_id"]=decrypt($posted["opd_category_id"]);
                    $info["i_province_id"]=decrypt($posted["opt_province_id"]);
                    $info["i_city_id"]=decrypt($posted["opt_city_id"]);
                    $info["i_zipcode_id"]=decrypt($posted["i_zipcode_id"]);
                    $info["i_supply_material"]=$posted["chk_supply_material"];
                    $info["s_description"]=$posted["txt_description"];
                    $info["s_keyword"]=$posted["txt_keyword"];
                    $info["i_quoting_period_days"]=$posted["opd_quoting_period_days"];
                    $info["d_budget_price"]=$posted["txt_budget_price"];
                   // $info["i_created_date"]=time();
				   
				   
					//$info["i_quoting_period_days"]=$posted["i_quoting_period_days"];
					$info["i_expire_date"]	=	strtotime("+ {$info['i_quoting_period_days']} day", $job_details['i_approval_date']);				   
                    //echo $info["i_expire_date"];exit;
                    $info["i_available_option"]=$posted["rd_available_time"];
                    if($info["i_available_option"]==1)
                    {    
                        $info["s_available_time"] = decrypt($posted["opd_available_time"]);
                    }
                    else
                    {                        
                        $info["s_available_time"] = date("m/d/Y",strtotime($posted["txt_time"])).' from '. $posted["txt_time_from"].' to '. $posted["txt_time_to"]; 
                    }
                    
                    //pr($info); exit;
                    $arrImg = array();
                    
                    /******* Upload image **********/    
                    foreach($_FILES as $key=>$file)
                    {
                        $i = substr($key,-1);
                        if ( $file['name']!='') 
                        {
                            $ext1 = getExtension($file['name']);    
                            
                        if ( $ext1==".jpg" || $ext1==".jpeg" || $ext1==".gif" || $ext1==".png" || $ext1==".pdf" || $ext1==".doc") 
                        {        
                                $this->imagename = 'job_'.$i.'_'.time();
                                $this->upload_image = $o_ci['job_file_upload_path'].$this->imagename;    
                                $max_file_size    = $o_ci['job_file_upload_max_size'];
                                $img_details = upload_file($this,
                                    array('upload_path' => $o_ci['job_file_upload_path'],
                                          'file_name'    => $this->imagename.$ext1 ,
                                          'allowed_types' => 'pdf|gif|jpg|png|jpeg|doc',    
                                          'max_size' => $max_file_size,
                                          'max_width' => '0',
                                          'max_height' => '0',
                                          ), 'f_image_'.$i
                                    );
                                    
                                if(is_array($img_details) &&  $ext1!=".pdf" && $ext1!=".doc")
                                {
                                    
                                    $create_thumb = create_thumb($this, 
                                                            array('image_library'=> 'gd2',
                                                                  'source_image' => $img_details['full_path'],
                                                                  'create_thumb' => TRUE,
                                                                  'maintain_ratio' => TRUE,
                                                                  'thumb_marker' => '',
                                                                  'width' => $o_ci['job_photo_upload_thumb_height'],
                                                                  'height' => $o_ci['job_photo_upload_thumb_width'],
                                                                  'new_image'=>$o_ci['job_file_upload_thumb_path'].$img_details['orig_name']
                                                                  ) 
                                                        );
                                }
                                elseif($img_details!='' && !is_array($img_details))
                                {
                                    $err=explode('|',$img_details);
                                    $this->session->set_userdata(array('message'=>$err[0],'message_type'=>'err'));
                                    //header('location:'.base_url().'post_job');
                                    //exit;
                                }
                                 $arrImg = array_merge($arrImg,array('job_image'.$i=>$this->imagename.$ext1));
                            } // end of extension checking         
                        } // end if
                        
                    }    // end of foreach
                    
                    
                    /******* End of upload image *****/
                    $jobtotArr    = array('job'=>$info,'img'=>$arrImg,'job_post_session'=>$this->session->userdata('session_id'));                    
                    $job_id = $this->mod_->set_job_update_all($jobtotArr,$i_job_id);
					//var_dump($job_id);
					//exit;
                       
                    if($job_id)
                    {
                           $this->load->model('category_model');    
                           $category = $this->category_model->fetch_this($info['i_category_id']);
                           
                           /* for job posting mail to the user */
                           $this->load->model('auto_mail_model');
                           $content = $this->auto_mail_model->fetch_contact_us_content('job_posted','buyer'); 
						   $mail_subject = $content['s_subject'];
					
							$filename = $this->config->item('EMAILBODYHTML')."common.html";
							$handle = @fopen($filename, "r");
							$mail_html = @fread($handle, filesize($filename));	                   
                            //print_r($content); exit;
                            if(!empty($content))
                                {                            
                                    $description = $content["s_content"];
                                    $description = str_replace("[Buyer name]",$this->data['loggedin']['user_name'],$description);
                                    $description = str_replace("[job title]",$info['s_title'],$description);    
                                    $description = str_replace("[job type/category]",$category['s_category_name'],$description); 
									$description = str_replace("[site_url]",base_url(),$description);   
                                    $description = str_replace("%EMAIL_DISCLAMER%","",$description);                            
                                }
                            unset($content);
							
							$mail_html = str_replace("[site url]",base_url(),$mail_html);	
					        $mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
                                
                            //echo "<br>DESC".$description;    exit;
     /// Edit job mail content required/////////                       
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
                                            
                            $this->email->to($this->data['loggedin']['user_email']);
                            
                            $this->email->subject(mail_subject);
                            $this->email->message($mail_html);
                            
                            if(SITE_FOR_LIVE)///For live site
                            {                
                                $i_nwid = $this->email->send();    
                                                                        
                            }
                            else
                            {
                                $i_nwid = TRUE;                
                            }
                            //echo $this->data['loggedin']['user_email'];
                            //echo "<br>DESC".$description;    exit;    
                            
                            /// Mailing code...[end]    
                            
                        /* end job posting mail to the user */                                
                         $this->session->set_userdata(array('message'=>$this->cls_msg["save_edit_job_succ"],'message_type'=>'succ'));    
                         redirect(base_url().'buyer/edit_job/'.encrypt($i_job_id));
                        //redirect($this->pathtoclass."sucess_job_post");                        
                    }    
                    else
                    {
                        $this->session->set_userdata(array('message'=>$this->cls_msg["save_edit_job_err"],'message_type'=>'err'));    
                        redirect(base_url().'buyer/edit_job/'.encrypt($i_job_id));
                    }
                    
                        
                        
/*                    $i_newid = 1;//$this->mod_->add_info($info);
                    if($i_newid)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."job/sucess_job_post");
                    }
                    else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["save_err"]);
                    }*/
                    
                }
            }
        else 
        {
            $info   =   $this->mod_->fetch_this($i_job_id);
            //pr($info);
           // exit;
            $posted["txt_title"]            =  $info['s_title'];
            $posted["opd_category_id"]      =  $info['i_category_id'];
            $posted["opt_province_id"]      =  $info['i_province_id'];
            $posted["opt_city_id"]          =  $info['i_city_id'];
            $posted["i_zipcode_id"]         =  $info['i_zipcode_id'];
            $posted["chk_supply_material"]  =  $info['i_supply_material'];
            $posted["txt_description"]      =  $info['s_description'];
            $posted["txt_keyword"]          =  $info['s_keyword'];
            $posted["opd_quoting_period_days"]=intval($info['i_quoting_period_days']); 
            $posted["txt_budget_price"]     =  $info['d_budget_price'];
            $posted["rd_available_time"]    =  intval($info['i_available_option']);
            if($posted["rd_available_time"]==1)
            {
                $posted["opd_available_time"]   =  $info['s_available_time'];  
            }
            elseif($posted["rd_available_time"]==2)
            {
                 $s_available_time               =  explode(" ",$info['s_available_time']);
                 $posted["txt_time"]             =  date("Y-M-d",strtotime($s_available_time[0]));
                 $posted["txt_time_from"]        =  $s_available_time[2]."  ".$s_available_time[4]  ;
                 $posted["txt_time_to"]          =  $s_available_time[6]."  ".$s_available_time[8]  ;
                
            }
            
            $posted['job_files']            =  $info['job_files']; 
            //pr($posted);
			$posted['s_zip'] = $info['s_postal_code'];
            
            
            $this->data["posted"]=$posted;
        }
        
        
        $this->render();
    
    }
	
	
	
	/* for repost the expire job as new job */
	function repost_job($i_job_id='')
    {
        
        if(!empty($this->data['loggedin']) && decrypt($this->data['loggedin']['user_type_id'])!=1)
        {
                $this->session->set_userdata(array('message'=>$this->cls_msg["tradesman_job_post_err"],'message_type'=>'err'));
                redirect(base_url().'home/message');
        }
        
       	$i_job_id = decrypt($i_job_id);
		
		$s_where = " WHERE n.id={$i_job_id }"; 
		$job_details = $this->job_model->fetch_this($i_job_id);		
		
		
		//echo date("Y-m-d",$job_details['i_approval_date']);exit;
		
        //$this->i_sub_menu_id    =    6;
        $this->data['breadcrumb'] = array('Post Job'=>'');    
        $this->data['pathtoclass'] = $this->pathtoclass;
        $o_ci = &get_config();
        $this->load->model('job_model','mod_'); 
        $this->data['file_location'] = $o_ci['job_file_upload_path'] ;
        $user_id = decrypt($this->data['loggedin']['user_id']);     
        if($_POST)
        {
                $posted=array();
                $posted["txt_title"]    = trim($this->input->post("txt_title"));
                $posted["opd_category_id"]= trim($this->input->post("opd_category_id"));
                $posted["opt_province_id"]= trim($this->input->post("opt_state"));
                $posted["opt_city_id"]= trim($this->input->post("opt_city"));
                $posted["i_zipcode_id"]= trim($this->input->post("opt_zip"));
                $posted["chk_supply_material"]= trim($this->input->post("chk_supply_material"));
                $posted["txt_description"]= trim($this->input->post("txt_description"));
                $posted["txt_keyword"]= trim($this->input->post("txt_keyword"));
                $posted["opd_quoting_period_days"]= trim($this->input->post("opd_quoting_period_days"));
                $posted["txt_budget_price"]= trim($this->input->post("txt_budget_price"));
                $posted["rd_available_time"]= trim($this->input->post("rd_available_time"));
                $posted["opd_available_time"]= trim($this->input->post("opd_available_time"));
                $posted["txt_time"]= trim($this->input->post("txt_time"));
                $posted["txt_time_from"]= trim($this->input->post("txt_time_from"));
                $posted["txt_time_to"]= trim($this->input->post("txt_time_to"));
            
                 
                $this->form_validation->set_rules('txt_title', 'provide job title', 'required');
                $this->form_validation->set_rules('opd_category_id', 'select category', 'required');
                $this->form_validation->set_rules('opt_state', 'select county', 'required');
                $this->form_validation->set_rules('opt_city', 'select city', 'required');
                $this->form_validation->set_rules('opt_zip', 'select postal code', 'required');
                $this->form_validation->set_rules('txt_description', 'select description', 'required');
                $this->form_validation->set_rules('txt_keyword', 'select keyword', 'required');
                $this->form_validation->set_rules('opd_quoting_period_days', 'select quote period days', 'required');
                $this->form_validation->set_rules('txt_budget_price', 'provide budget price', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
                    $info["i_buyer_user_id"]=$user_id;
                    $info["s_title"]=$posted["txt_title"];
                    $info["i_category_id"]=decrypt($posted["opd_category_id"]);
                    $info["i_province_id"]=decrypt($posted["opt_province_id"]);
                    $info["i_city_id"]=decrypt($posted["opt_city_id"]);
                    $info["i_zipcode_id"]=decrypt($posted["i_zipcode_id"]);
                    $info["i_supply_material"]=$posted["chk_supply_material"];
                    $info["s_description"]=$posted["txt_description"];
                    $info["s_keyword"]=$posted["txt_keyword"];
                    $info["i_quoting_period_days"]=$posted["opd_quoting_period_days"];
                    $info["d_budget_price"]=$posted["txt_budget_price"];
					
					/* datas to reset in the database */
                    $info["i_created_date"]=time();
					$info["i_admin_approval_date"] = "";
					$info["i_tradesman_id"] = "";
					$info["i_quote_id"] = "";
					$info["i_status"] = 0;
					/* end new datas */
				   
					//$info["i_quoting_period_days"]=$posted["i_quoting_period_days"];
					$info["i_expire_date"]	=	strtotime("+ {$info['i_quoting_period_days']} day", $job_details['i_approval_date']);				   
                    //echo $info["i_expire_date"];exit;
                    $info["i_available_option"]=$posted["rd_available_time"];
                    if($info["i_available_option"]==1)
                    {    
                        $info["s_available_time"] = decrypt($posted["opd_available_time"]);
                    }
                    else
                    {                        
                        $info["s_available_time"] = date("m/d/Y",strtotime($posted["txt_time"])).' from '. $posted["txt_time_from"].' to '. $posted["txt_time_to"]; 
                    }
                    
                    //pr($info); exit;
                    $arrImg = array();
                    
                    /******* Upload image **********/    
                    foreach($_FILES as $key=>$file)
                    {
                        $i = substr($key,-1);
                        if ( $file['name']!='') 
                        {
                            $ext1 = getExtension($file['name']);    
                            
                        if ( $ext1==".jpg" || $ext1==".jpeg" || $ext1==".gif" || $ext1==".png" || $ext1==".pdf" || $ext1==".doc") 
                        {        
                                $this->imagename = 'job_'.$i.'_'.time();
                                $this->upload_image = $o_ci['job_file_upload_path'].$this->imagename;    
                                $max_file_size    = $o_ci['job_file_upload_max_size'];
                                $img_details = upload_file($this,
                                    array('upload_path' => $o_ci['job_file_upload_path'],
                                          'file_name'    => $this->imagename.$ext1 ,
                                          'allowed_types' => 'pdf|gif|jpg|png|jpeg|doc',    
                                          'max_size' => $max_file_size,
                                          'max_width' => '0',
                                          'max_height' => '0',
                                          ), 'f_image_'.$i
                                    );
                                    
                                if(is_array($img_details) &&  $ext1!=".pdf" && $ext1!=".doc")
                                {
                                    
                                    $create_thumb = create_thumb($this, 
                                                            array('image_library'=> 'gd2',
                                                                  'source_image' => $img_details['full_path'],
                                                                  'create_thumb' => TRUE,
                                                                  'maintain_ratio' => TRUE,
                                                                  'thumb_marker' => '',
                                                                  'width' => $o_ci['job_photo_upload_thumb_height'],
                                                                  'height' => $o_ci['job_photo_upload_thumb_width'],
                                                                  'new_image'=>$o_ci['job_file_upload_thumb_path'].$img_details['orig_name']
                                                                  ) 
                                                        );
                                }
                                elseif($img_details!='' && !is_array($img_details))
                                {
                                    $err=explode('|',$img_details);
                                    $this->session->set_userdata(array('message'=>$err[0],'message_type'=>'err'));
                                    //header('location:'.base_url().'post_job');
                                    //exit;
                                }
                                 $arrImg = array_merge($arrImg,array('job_image'.$i=>$this->imagename.$ext1));
                            } // end of extension checking         
                        } // end if
                        
                    }    // end of foreach
                    
                    
                    /******* End of upload image *****/
                    $jobtotArr    = array('job'=>$info,'img'=>$arrImg,'job_post_session'=>$this->session->userdata('session_id'));                    
                    //$job_id = $this->mod_->set_job_update_all($jobtotArr,$i_job_id);
					
					
					$job_id = $this->mod_->set_expire_to_new_job_update_all($jobtotArr,$i_job_id);
					//var_dump($job_id);
					//exit;
                       
                    if($job_id)
                    {
                           $this->load->model('category_model');    
                           $category = $this->category_model->fetch_this($info['i_category_id']);
                           
                           /* for job posting mail to the user */
                           $this->load->model('auto_mail_model');
                           $content = $this->auto_mail_model->fetch_contact_us_content('job_posted','buyer'); 
						   $mail_subject = $content['s_subject'];
					
							$filename = $this->config->item('EMAILBODYHTML')."common.html";
							$handle = @fopen($filename, "r");
							$mail_html = @fread($handle, filesize($filename));	                   
                            //print_r($content); exit;
                            if(!empty($content))
                                {                            
                                    $description = $content["s_content"];
                                    $description = str_replace("[Buyer name]",$this->data['loggedin']['user_name'],$description);
                                    $description = str_replace("[job title]",$info['s_title'],$description);    
                                    $description = str_replace("[job type/category]",$category['s_category_name'],$description);  
									$description = str_replace("[site_url]",base_url(),$description);  
                                    $description = str_replace("%EMAIL_DISCLAMER%","",$description);                            
                                }
                            unset($content);
							
							$mail_html = str_replace("[site url]",base_url(),$mail_html);	
					        $mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
                                
                            //echo "<br>DESC".$description;    exit;
     /// Edit job mail content required/////////                       
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
                                            
                            $this->email->to($this->data['loggedin']['user_email']);
                            
                            $this->email->subject(mail_subject);
                            $this->email->message($mail_html);
                            
                            if(SITE_FOR_LIVE)///For live site
                            {                
                                $i_nwid = $this->email->send();    
                                                                        
                            }
                            else
                            {
                                $i_nwid = TRUE;                
                            }
                            //echo $this->data['loggedin']['user_email'];
                            //echo "<br>DESC".$description;    exit;    
                            
                            /// Mailing code...[end]    
                            
                        /* end job posting mail to the user */                                
                         $this->session->set_userdata(array('message'=>$this->cls_msg["save_repost_job_succ"],'message_type'=>'succ'));    
                         redirect(base_url().'buyer/expired_jobs/');
                        //redirect($this->pathtoclass."sucess_job_post");                        
                    }    
                    else
                    {
                        $this->session->set_userdata(array('message'=>$this->cls_msg["save_edit_job_err"],'message_type'=>'err'));    
                        redirect(base_url().'buyer/repost_job/'.encrypt($i_job_id));
                    }
                    
                        
                        
/*                    $i_newid = 1;//$this->mod_->add_info($info);
                    if($i_newid)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."job/sucess_job_post");
                    }
                    else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["save_err"]);
                    }*/
                    
                }
            }
        else 
        {
            $info   =   $this->mod_->fetch_this($i_job_id);
            //pr($info);
           // exit;
            $posted["txt_title"]            =  $info['s_title'];
            $posted["opd_category_id"]      =  $info['i_category_id'];
            $posted["opt_province_id"]      =  $info['i_province_id'];
            $posted["opt_city_id"]          =  $info['i_city_id'];
            $posted["i_zipcode_id"]         =  $info['i_zipcode_id'];
            $posted["chk_supply_material"]  =  $info['i_supply_material'];
            $posted["txt_description"]      =  $info['s_description'];
            $posted["txt_keyword"]          =  $info['s_keyword'];
            $posted["opd_quoting_period_days"]=intval($info['i_quoting_period_days']); 
            $posted["txt_budget_price"]     =  $info['d_budget_price'];
            $posted["rd_available_time"]    =  intval($info['i_available_option']);
            if($posted["rd_available_time"]==1)
            {
                $posted["opd_available_time"]   =  $info['s_available_time'];  
            }
            elseif($posted["rd_available_time"]==2)
            {
                 $s_available_time               =  explode(" ",$info['s_available_time']);
                 $posted["txt_time"]             =  date("Y-M-d",strtotime($s_available_time[0]));
                 $posted["txt_time_from"]        =  $s_available_time[2]."  ".$s_available_time[4]  ;
                 $posted["txt_time_to"]          =  $s_available_time[6]."  ".$s_available_time[8]  ;
                
            }
            
            $posted['job_files']            =  $info['job_files']; 
            //pr($posted);
            $posted['s_zip'] = $info['s_postal_code'];
            
            $this->data["posted"]=$posted;
        }
        
        
        $this->render();
    
    }

   
	function job_edit($i_job_id='')
	{
		try
		{
			$this->i_sub_menu_id	=	5;
			$this->data['breadcrumb'] = array('Edit Job'=>'');	
			$this->data['pathtoclass'] = $this->pathtoclass;
			$this->add_css('css/fe/dd.css');
			$this->add_js('js/fe/jquery.dd.js');
			$i_job_id = decrypt($i_job_id );
			
			$s_where = " WHERE n.id={$i_job_id } AND cat_c.i_lang_id =".$this->i_default_language; 
			$job_details = $this->job_model->fetch_this($i_job_id);
			$this->data['i_quote_days_start'] = intval($job_details['i_quoting_period_days']+1);
			//pr($job_details);exit;
			$job_exist = $this->job_model->gettotal_info($s_where);
			if(empty($job_exist))
			{
				$this->session->set_userdata(array('message'=>$this->cls_msg["invalid_job_err"],'message_type'=>'err'));
				redirect(base_url().'home/message');
			}
			if($_POST)
			{
				$posted=array();
                $posted["opd_quote_period"]	= trim($this->input->post("opd_quote_period"));
				$this->form_validation->set_rules('opd_quote_period', 'quote period', 'required');
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
				else
				{
					$info=array();
					$info["i_quoting_period_days"]=$posted["opd_quote_period"];
					$info["i_expire_date"]	=	strtotime("+ {$info['i_quoting_period_days']} day", $job_details['i_approval_date']);
					
                    $i_newid = $this->job_model->edit_quote_days_info($info,$i_job_id);
                    if($i_newid)////saved successfully
                    {	
									
						/* insert data to job history and stattus change*/
						$arr1 = array();
						$arr1['i_job_id']  =  $i_job_id;
						$arr1['i_user_id'] =  $this->user_id;
						$arr1['s_message'] =  'job_edited';
						$arr1['i_created_date'] =  time();
						$table = $this->db->JOB_HISTORY;
						$this->job_model->set_data_insert($table,$arr1);					
						/* end */			
						
						//exit;
                        $this->session->set_userdata(array('message'=>$this->cls_msg["save_job_quote"],'message_type'=>'succ'));
                    }
                    else///Not saved, show the form again
                    {
                          $this->session->set_userdata(array('message'=>$this->cls_msg["save_job_quote_err"],'message_type'=>'err'));
                    }					
				
				}	
				redirect($this->pathtoclass.'job_edit/'.encrypt($i_job_id));		
			}
			
			$this->render();		
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
	}
	
	/* open confirm box*/
	function chk_delete($i_job_id='')
	{
		//$i_job_id =  decrypt($i_job_id);
		$this->data['i_job_id'] = $i_job_id;
		$this->load->view('fe/buyer/chk_del.tpl.php',$this->data);
	}
	
	/* delete job*/
	function delete_job()
	{
		$btn_sub = trim($this->input->post("btn_sub"));
		
		if($_POST)
		{
			$info = array();
			$i_job_id = decrypt(trim($this->input->post("h_job_id")));
			
			$info['i_is_deleted'] = 1;
			$i_newid = $this->job_model->delete_job($info,$i_job_id);
			if($i_newid)
			{
					
				/* insert data to job history and stattus change*/
				$arr1 = array();
				$arr1['i_job_id']  =  $i_job_id;
				$arr1['i_user_id'] =  $this->user_id;
				$arr1['s_message'] =  'job_cancelled';
				$arr1['i_created_date'] =  time();
				$table = $this->db->JOB_HISTORY;
				$this->job_model->set_data_insert($table,$arr1);	
				/*============*/
				$table = $this->db->JOB_STATUS_HISTORY;
				$arr1 = array();
				$arr1['i_job_id'] =  $i_job_id;
				$arr1['i_user_id'] =  $this->user_id;
				$arr1['s_status'] =  'Cancelled';		
				$arr1['i_created_date'] =  time();			
				$this->job_model->set_data_insert($table,$arr1);
							
					
				//exit;				
				/* end */		
				
				
			   /* for job quote mail to the user */
			   $this->load->model('manage_buyers_model');			   
			   $job_details = $this->job_model->fetch_this($i_job_id);
			   //echo '==========='.$i_tradesman_id;exit;
			   $buyer_details = $this->manage_buyers_model->fetch_this($job_details['i_buyer_user_id']);
			  
			   $this->load->model('auto_mail_model');
			   $content = $this->auto_mail_model->fetch_contact_us_content('admin_buyer_cancel_job','general');		
			   $mail_subject = $content['s_subject'];	
			   
			   $filename = $this->config->item('EMAILBODYHTML')."common.html";
			   $handle = @fopen($filename, "r");
			   $mail_html = @fread($handle, filesize($filename));						
				//print_r($content); exit;
				if(!empty($content))
				{							
					$description = $content["s_content"];
					$description = str_replace("[Buyer name]",$job_details['s_buyer_name'],$description);
					$description = str_replace("[job title]",$job_details['s_title'],$description);	
					$description = str_replace("[job type/category]",$job_details['s_category'],$description);	
					$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);	
					$description = str_replace("[site_url]",base_url(),$description);
					
					$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
				}
				unset($content);
				//echo $this->s_admin_email;	
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
				
				$this->email->from($buyer_details['s_email']);	
								
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
				
			/* end job quote mail to the user */	
				
					
						
			
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del"],'message_type'=>'succ'));
				$msg = '1|'.$this->cls_msg["job_del"];
			}
			else
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del_err"],'message_type'=>'err'));
				$msg = '2|'.$this->cls_msg["job_del_err"];
			}
		}
		else
		{
			$msg = '';
		}	
		echo $msg;			
	}
	
	
    function deny_feedback($i_job_id=0)
	{
		//$this->data['i_tradesman_id'] = $i_tradesman_id;
		$this->data['i_job_id'] = $i_job_id;
		$this->data['job_details'] = $this->job_model->fetch_this($this->data['i_job_id']);
		
		$this->load->view('fe/buyer/deny_feedback.tpl.php',$this->data);
	}
   
	function save_deny_feedback()
	{
		$btn_sub = trim($this->input->post("btn_sub"));
		//if($btn_sub == 'Yes')
		//{
			$info = array();
			$i_job_id = $this->input->post("h_job_id");
			$job_details = $this->job_model->fetch_this($i_job_id);
			//$i_tradesman_id = $this->input->post("h_tradesman_id");
			$s_comments = get_formatted_string($this->input->post("s_comments"));
			$info = array();
			$info['i_status'] = 11; // pending state

			$table = $this->db->JOBS;
			//$cond = array('id '=>$i_job_id);
			$i_newid = $this->job_model->set_data_update($table,$info,$i_job_id);
			
			$table = $this->db->JOBFEEDBACK;
			$info = array();
			$info['i_job_id'] = $i_job_id;
			$info['i_sender_user_id'] = $this->user_id;
			$info['i_receiver_user_id'] = $job_details['i_tradesman_id'];
			$info['s_comments'] = $s_comments;
			$info['i_created_date'] = time();
			$info['i_status'] = 0;
			$this->job_model->set_data_insert($table,$info);
			
			if($i_newid)
			{
			
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
			
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del"],'message_type'=>'succ'));
				$msg = '1|Feedback sent';
			}
			else
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del_err"],'message_type'=>'err'));
				$msg = '2|Feedback not sent';
			}
/*		}
		else
		{
			$msg = '';
		}	*/
		echo $msg;			
	}	
	
	
    function give_feedback($i_job_id=0)
	{	//echo 'hi'; exit;
		//$this->data['i_tradesman_id'] = $i_tradesman_id;
		$this->data['i_job_id'] = $i_job_id;
		$this->data['job_details'] = $this->job_model->fetch_this($this->data['i_job_id']);
		
		$this->load->view('fe/buyer/give_feedback.tpl.php',$this->data);
	}
   
	function save_give_feedback()
	{
		$btn_sub = trim($this->input->post("btn_sub"));
		if($_POST)
		{
			$info = array();
			$i_job_id = $this->input->post("h_job_id");
			$job_details = $this->job_model->fetch_this($i_job_id);
			//$i_tradesman_id = $this->input->post("h_tradesman_id");
			$s_comments = get_formatted_string($this->input->post("s_comments"));
			$i_rating 	= intval($this->input->post("i_rating"));
			$i_positive	= intval($this->input->post("i_positive"));
			
			$info = array();
			$info['i_status'] = 6; // complete state
			$info['i_completed_date'] = time();
			$table = $this->db->JOBS;
			
			$i_newid = $this->job_model->set_data_update($table,$info,$i_job_id);
			
			$table = $this->db->JOBFEEDBACK;
			$info = array();
			$info['i_job_id'] = $i_job_id;
			$info['i_sender_user_id'] = $this->user_id;
			$info['i_receiver_user_id'] = $job_details['i_tradesman_id'];
			$info['s_comments'] = $s_comments;
			$info['i_rating'] = $i_rating;
			$info['i_positive'] = $i_positive;
			$info['i_created_date'] = time();
			$info['i_status'] = 1;
			$info['i_feedback_complete_status'] = 0;
			$this->job_model->set_data_insert($table,$info);
			
		
			
			
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
				$arr1 = array();
				$arr1['i_job_id']  =  $i_job_id;
				$arr1['i_user_id'] =  $this->user_id;
				$arr1['s_status'] =  'Completed';
				$arr1['i_created_date'] =  time();
				$table = $this->db->JOB_STATUS_HISTORY;
				$this->job_model->set_data_insert($table,$arr1);	
				/* end */							
				
				
			   /* for job quote mail to the user */
			   $this->load->model('tradesman_model');			   
			   $job_details = $this->job_model->fetch_this($i_job_id);
			   //echo '==========='.$i_tradesman_id;exit;
			   $tradesman_details = $this->tradesman_model->fetch_this($job_details['i_tradesman_id']);
			    $this->load->model('manage_buyers_model');	
			   $s_wh_id = " WHERE n.i_user_id=".$job_details['i_tradesman_id']." ";
			   $buyer_email_key = $this->manage_buyers_model->fetch_email_keys($s_wh_id);
			   $is_mail_need = in_array('buyer_provided_feedback',$buyer_email_key);
			  
			   if($is_mail_need)
			   {
			   $this->load->model('auto_mail_model');
			   $content = $this->auto_mail_model->fetch_contact_us_content('buyer_provided_feedback','tradesman');
			   $mail_subject = $content['s_subject'];		
			   $filename = $this->config->item('EMAILBODYHTML')."common.html";
			   $handle = @fopen($filename, "r");
			   $mail_html = @fread($handle, filesize($filename));				
				//print_r($content); exit;
				if(!empty($content))
				{			
					$description = $content["s_content"];
					$description = str_replace("[Buyer name]",$job_details['s_buyer_name'],$description);
					$description = str_replace("[job title]",$job_details['s_title'],$description);	
					$description = str_replace("[service professional name]",$job_details['s_tradesman_name'],$description);	
					$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);	
					$description = str_replace("[site_url]",base_url(),$description);
					$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
				}
				//unset($content);
				$mail_html = str_replace("[site url]",base_url(),$mail_html);	
				$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
				//echo $tradesman_details['s_email'];	exit;
				//echo "<br>DESC".$description;	
				
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
				
			/* end job quote mail to the user */	
			 }
			
			
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del"],'message_type'=>'succ'));
				$msg = '1|'.addslashes('Job completed sucessfully');
			}
			else
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del_err"],'message_type'=>'err'));
				$msg = '2|'.addslashes('Job not completed sucessfully');
			}
		}
		else
		{
			redirect(base_url());
		}	
		echo $msg;			
	}		
	
	
	
    function job_terminate_box($i_job_id=0)
	{
		//$this->data['i_tradesman_id'] = $i_tradesman_id;
		$this->data['i_job_id'] = $i_job_id;
		$this->data['job_details'] = $this->job_model->fetch_this($this->data['i_job_id']);
		
		$this->load->view('fe/buyer/job_terminate_box.tpl.php',$this->data);
	}
   
	function save_job_terminate()
	{ 
		$btn_sub = trim($this->input->post("btn_sub"));
		if($_POST)
		{
			$info = array();
			$i_job_id = $this->input->post("h_job_id");
			$job_details = $this->job_model->fetch_this($i_job_id);
			//print_r($this->data['loggedin']); exit;
			//$i_tradesman_id = $this->input->post("h_tradesman_id");
			$s_terminate_reason = get_formatted_string($this->input->post("s_terminate_reason"));
			$s_comments = get_formatted_string($this->input->post("s_comments"));
			$i_rating 	= intval($this->input->post("i_rating"));
			$i_positive = intval($this->input->post("i_positive"));
			
			
			$info = array();
			$info['i_status'] = 9; // terminate state
			$info['i_terminate_date'] = time();
			$table = $this->db->JOBS;
			//$cond = array('id '=>$i_job_id);
			$i_newid = $this->job_model->set_data_update($table,$info,$i_job_id);
			
			$table = $this->db->JOBFEEDBACK;
			$info = array();
			$info['i_job_id'] = $i_job_id;
			$info['i_sender_user_id'] = $this->user_id;
			$info['i_receiver_user_id'] = $job_details['i_tradesman_id'];
			$info['s_terminate_reason'] = $s_terminate_reason;
			$info['s_comments'] = $s_comments;
			$info['i_rating'] = $i_rating;
			$info['i_positive'] = $i_positive; // negative
			$info['i_created_date'] = time();
			$info['i_status'] = 2;
			$this->job_model->set_data_insert($table,$info);
			
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
			$s_where = " WHERE i_receiver_user_id ={$job_details['i_tradesman_id']} AND n.i_status !=0 AND n.i_positive=1" ;
			$i_positive = $this->manage_feedback_model->fetch_feedback_positive($s_where);
			$info = array();
			$info['i_feedback_rating'] = $feedback_details['i_rating'];
			$info['f_positive_feedback_percentage'] = ($tot_feedback!=0)?round(($i_positive['i_positive']/$tot_feedback)*100):0;
			//$info['i_jobs_won'] = $tot_accepted_feedback;
			$info['i_feedback_received'] = $tot_feedback;
			$table = $this->db->TRADESMANDETAILS;
			$cond = array('i_user_id'=>$job_details['i_tradesman_id']);
			$this->job_model->set_data_update($table,$info,$cond);
			/* end of calcution for update tradesman details table */	
			
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
			
			
		   /* for job quote mail to the user */
		   //$this->load->model('tradesman_model');
		   //$s_where = " WHERE n.i_job_id={$i_job_id} AND n.i_status=1";
		   
		   $this->load->model('job_model');
		   $s_where = " WHERE n.i_job_id={$i_job_id}";
		   $job_details = $this->job_model->fetch_quote_multi($s_where);
		   //echo '==========='.$i_tradesman_id;exit;
		   //echo $this->db->last_query(); exit;
		   //print_r($job_details);exit;
		   
		   $this->load->model('auto_mail_model');
		   $content = $this->auto_mail_model->fetch_contact_us_content('buyer_terminate_job','tradesman');
		   $mail_subject = $content['s_subject'];		
		   $filename = $this->config->item('EMAILBODYHTML')."common.html";
		   $handle = @fopen($filename, "r");
		   $mail_html = @fread($handle, filesize($filename));					
		   
		   //print_r($content); 
		    
		   //exit;
		   if($job_details)
		   {	
		   	//$str = '';
		   		foreach($job_details as $val)
				{		
					if(!empty($content))
					{					
						$description = $content["s_content"];
						$description = str_replace("[service professional name]",$val['s_username'],$description);
						$description = str_replace("[Buyer name]",$val['job_details']['s_buyer_name'],$description);
						$description = str_replace("[job title]",$val['job_details']['s_title'],$description);	
						$description = str_replace("[job type/category]",$val['job_details']['s_category'],$description);
						$description = str_replace("[terminate reason]",$s_terminate_reason,$description);	
						$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);	
						$description = str_replace("[site_url]",base_url(),$description);
						$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
					}
					//unset($content);
					
					$mail_html = str_replace("[site url]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					//echo $val['s_email'];	
					//echo "<br>DESC".$description;	exit;
					//$str .= ($str) ? $str.','.$val['s_email'] : $val['s_email']; 
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
					$this->email->to($val['s_email']);	
					$this->email->subject($mail_subject);
					unset($content);
					$this->email->message($mail_html);	
					
					$this->load->model('manage_buyers_model');	
					$s_wh_id = " WHERE n.i_user_id=".$val['i_tradesman_id']." ";
			        $buyer_email_key = $this->manage_buyers_model->fetch_email_keys($s_wh_id);
					
			        $is_mail_need = in_array('buyer_terminate_job',$buyer_email_key);	
					
					if($is_mail_need)
					{						
						if(SITE_FOR_LIVE)///For live site
						{				
							$i_nwid_terminate = $this->email->send();															
						}
						else
						{
							$i_nwid_terminate = TRUE;				
						}
					}
				}				
			}
			/// Mailing code...[end]	
			//echo $str; exit;
			/* mail for admin*/
		   $content = $this->auto_mail_model->fetch_contact_us_content('admin_buyer_terminated_job','general');	
		   $filename = $this->config->item('EMAILBODYHTML')."common.html";
		   $handle = @fopen($filename, "r");
		   $mail_html = @fread($handle, filesize($filename));				
			//print_r($content); exit;
		
			if(!empty($content))
			{		
								
				$description = $content["s_content"];
				$description = str_replace("[Buyer name]",$job_details[0]['job_details']['s_buyer_name'],$description);
				$description = str_replace("[job title]",$job_details[0]['job_details']['s_title'],$description);	
				$description = str_replace("[job type/category]",$job_details[0]['job_details']['s_category'],$description);
				$description = str_replace("[terminate reason]",$s_terminate_reason,$description);	
				$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);	
				$description = str_replace("[site_url]",base_url(),$description);
				$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
			}
			//unset($content);
			$mail_html = str_replace("[site url]",base_url(),$mail_html);	
			$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
			//echo $this->s_admin_email;	
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
			$this->email->to($site_admin_email);
						
			$this->email->subject($content['s_subject']);
			unset($content);
			$this->email->message($mail_html);			
			if(SITE_FOR_LIVE)///For live site
			{				
				$i_nwid_terminate = $this->email->send();															
			}
			else{
				$i_nwid_terminate = TRUE;				
			}
			
			
			/* end mail for admin*/
			
				
			/* end job quote mail to the user */					
			
					
			
			
			if($i_nwid_terminate)
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del"],'message_type'=>'succ'));
				$msg = '1|'.$this->cls_msg["job_terminate"];
			}
			else
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del_err"],'message_type'=>'err'));
				$msg = '2|'.$this->cls_msg["job_terminate_err"];
			}
		}
		else
		{
			redirect(base_url());
		}	
		echo $msg;			
	}		
		








	function confirm_job_assign($i_tradesman_id='',$i_job_id='',$s_quote_id='')
	{
		$this->data['i_tradesman_id'] = decrypt($i_tradesman_id);
		$this->data['i_job_id'] = decrypt($i_job_id);
		$this->data['i_quote_id'] = decrypt($s_quote_id);
		$this->data['job_details'] = $this->job_model->fetch_this($this->data['i_job_id']);
		//pr($this->data['job_details']);
		$this->load->view('fe/buyer/confirm_job_assign.tpl.php',$this->data);
		
	}

	function tradesman_assign_job()
	{
		$btn_sub = trim($this->input->post("btn_sub"));
		//$msg = '';
		
		if($btn_sub == 'Yes')
		{
			$info = array();
			$i_job_id = trim($this->input->post("h_job_id"));
			$i_tradesman_id = trim($this->input->post("h_tradesman_id"));
			$i_quote_id = trim($this->input->post("h_quote_id"));
			
			
			
			$info['i_tradesman_id'] = $i_tradesman_id;
			$info['i_quote_id'] 	= $i_quote_id;
			$info['i_status'] = 8; // frozen
			$info['i_assigned_date'] = time();
			/** UPDATE QUOTE STATUS */
			$arr1 = array();
			$arr1['i_status']  =  2; //Accepted
			$table = $this->db->JOBQUOTES;
			$new = $this->job_model->set_data_update($table,$arr1,$i_quote_id);
			/**END  UPDATE QUOTE STATUS */
			$i_newid = $this->job_model->assign_job_to_tradesman($info,$i_job_id);
			
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
				
				
			   /* for job quote mail to the user */
			   $this->load->model('tradesman_model');
			   $s_where = " WHERE n.i_tradesman_user_id={$i_tradesman_id} AND n.i_job_id={$i_job_id} AND n.i_status=2";
			   $job_details = $this->job_model->fetch_quote_multi($s_where,0,1);
			   //echo '==========='.$i_tradesman_id;exit;
			  
			   $tradesman_details = $this->tradesman_model->fetch_this($i_tradesman_id);
			   $this->load->model('manage_buyers_model');		
			   $s_wh_id = " WHERE n.i_user_id=".$i_tradesman_id." ";
			   $buyer_email_key = $this->manage_buyers_model->fetch_email_keys($s_wh_id);
			   $is_mail_need = in_array('buyer_awarded_job',$buyer_email_key);
			   
			   if($is_mail_need)
			  {
			   $this->load->model('auto_mail_model');
			   $content = $this->auto_mail_model->fetch_contact_us_content('buyer_awarded_job','tradesman');
			   $mail_subject = $content['s_subject'];	
			   
			   $filename = $this->config->item('EMAILBODYHTML')."common.html";
			   $handle = @fopen($filename, "r");
			   $mail_html = @fread($handle, filesize($filename));				
				//print_r($content); exit;
				if(!empty($content))
				{							
					$description = $content["s_content"];
					$description = str_replace("[service professional name]",$tradesman_details['s_username'],$description);
					$description = str_replace("[Buyer name]",$job_details[0]['job_details']['s_buyer_name'],$description);
					$description = str_replace("[job title]",$job_details[0]['job_details']['s_title'],$description);	
					$description = str_replace("[quote amount]",$job_details[0]['s_quote'],$description);	
					$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);	
					$description = str_replace("[site_url]",base_url(),$description);
					$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
				}
				unset($content);
				//echo $this->data['loggedin']['user_email'];	
				//echo "<br>DESC".$description;	exit;
				$mail_html = str_replace("[site url]",base_url(),$mail_html);	
				$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
				
				//pr($mail_html); exit;
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
								
				$this->email->to($tradesman_details['s_email']);
				
				$this->email->subject($mail_subject);
				$this->email->message($mail_html);
				
				if(SITE_FOR_LIVE)///For live site
				{				
					$i_nid = $this->email->send();	
															
				}
				else{
					$i_nid = TRUE;				
				}
				//echo $this->data['loggedin']['user_email'];
				//echo "<br>DESC".$description;	exit;	
				
				/// Mailing code...[end]	
				
			/* end job quote mail to the user */					
				}
			
			
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del"],'message_type'=>'succ'));
				$msg = '1|'.'Quote accepted successfully';
			}
			else
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del_err"],'message_type'=>'err'));
				$msg = '2|'.'Quote acceptance failed';
			}
		}			
		echo $msg;			
	
	}

   function job_feedback($i_job_id=0)
   {
   		$this->load->model('manage_feedback_model');
		
		$i_job_id = decrypt($i_job_id);
		$s_where = " WHERE n.i_job_id={$i_job_id} AND n.i_status=1 AND n.i_sender_user_id={$this->user_id}";
		$this->data['feedback_details'] =  $this->manage_feedback_model->fetch_multi($s_where,0,1);
		//pr($this->data['feedback_details']);
   		$this->load->view('fe/buyer/job_feedback.tpl.php', $this->data);
   }

    public function ajax_checkduplicate()
    {
        try
        {
            $posted=array();
            ///is the primary key,used for checking duplicate in edit mode
            $posted["id"]= $this->user_id;/*don't change*/
            $posted["duplicate_value"]= htmlspecialchars(trim($this->input->post("h_duplicate_value")),ENT_QUOTES);
						
            if($posted["duplicate_value"]!="")
            {
                $qry=" Where ".(intval($posted["id"])>0 ? " n.id!=".intval($posted["id"])." And " : "" )
                    ." n.s_username='".$posted["duplicate_value"]."'";
					
                //$info=$this->mod_rect->fetch_multi($qry,$start,$limit); /*don't change*/
				$info=$this->mod_buyer->gettotal_info($qry); /*don't change*/
				
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

	function feedback_received()
	{
		$this->i_sub_menu_id	=	11;	
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
*/		$this->data['feedback_contents'] = $contents;
			
		$this->render();
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
		$config['base_url'] = base_url().'buyer/feedback_receive_pagination_ajax/'.$s_id.'/';		
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



    public function __destruct()

    {}           

}



/* End of file welcome.php */

/* Location: ./system/application/controllers/welcome.php */

