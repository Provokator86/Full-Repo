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
		  $this->data['default_currency']=$this->config->item('default_currency');
		  if(empty( $this->data['loggedin']) || decrypt($this->data['loggedin']['user_type_id'])!=2)
			{
				
				redirect(base_url()."home");
				exit;
			}
		  
		  $this->cls_msg=array();
		  $this->cls_msg["save_pwd"]=t("password changed successfully.");
		  $this->cls_msg["save_pwd_err"]=t("password changed could not saved.");
		  $this->cls_msg["wrong_pwd"]=t("existing password does not match.");
		  
		  $this->cls_msg["save_contact"] = t(" contact details saved succesfully");
		  $this->cls_msg["save_profile"] = t(" profile details saved succesfully");
		  $this->cls_msg["save_profile_err"] = t(" profile details could not saved ");
		  
		  $this->cls_msg["save_album"] = t(" album details saved succesfully");
		  $this->cls_msg["save_album_err"] = t(" album details could not saved ");
		  
		   $this->cls_msg["save_email_setting"]=t("email setting saved successfully.");
		  
		  $this->cls_msg["save_testi"]=t("testimonial saved successfully.");
		  $this->cls_msg["save_testi_err"]=t("testimonial saved failure.");
		  
		  $this->cls_msg["save_radar_succ"]=t("Job radar saved successfully.");
		  $this->cls_msg["save_radar_err"]=t("Job radar saved failure.");
		  
		  $this->cls_msg["img_del"] = addslashes(t(" image deleted successfully"));
		  $this->cls_msg["img_del_err"] = addslashes(t(" image deleted unsuccessfull"));
		  
		  $this->cls_msg["err_max_no"] = t(" you can upload maximum 15 photos to your album");
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
		  
		   $this->load->model('tradesman_model');
		  $this->data['profile_info'] = $this->tradesman_model->fetch_this($this->user_id);
		  /** Feed back count **/
		  $this->load->model("Manage_feedback_model","mod_feed");
		   $s_where = " WHERE n.i_receiver_user_id = ".$this->user_id." AND n.i_status != 0   AND cat_c.i_lang_id =".$this->i_default_language; 
		
		
		   $this->data['i_total_feedback']  = $this->mod_feed->gettotal_info($s_where);	
		/** Feed back count **/
		  /* Radar Model*/
		  $this->load->model('radar_model');		  
		  $this->data['i_total_radar_job'] = $this->job_model->radar_job($this->user_id,$this->i_default_language);
		  /**/
		  
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
		
			$this->data['dt_current_time'] = date("l j-M-Y H:i",time());
			$s_where = " WHERE n.i_tradesman_user_id={$this->user_id} AND n.i_status!=3";
			$this->data['quote_details'] = $this->job_model->fetch_quote_multi($s_where,0,3);
			//pr($this->data['quote_details'],1);
			
			//$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=5 AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 			
		    //$this->data['feedback_job_list']	= $this->job_model->fetch_multi($s_where,intval($start),$limit);			
			//$limit = 2;
			$this->load->model("Manage_feedback_model","mod_feed");
			$s_where = " WHERE n.i_receiver_user_id = {$this->user_id} AND n.i_status!=0  AND cat_c.i_lang_id =".$this->i_default_language; 
			$this->data['feedback_job_list'] = $this->mod_feed->fetch_multi($s_where,0,5);
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
			$this->i_sub_menu_id=1;
			$this->data['pathtoclass']=$this->pathtoclass;
			$user_details = $this->session->userdata('loggedin');
			$this->data['user_id']	=	$user_details['user_id'];
			$this->data['info']	=	$this->mod_trades->fetch_this($this->user_id);
			//pr($this->data['info']); exit;
			$image_exist	=	$this->data['info']['image'][0]['s_user_image']; 
			$this->data['breadcrumb'] = array(t('Edit My Profile')=>'');
			//print_r($this->data['info']);  exit;
			$s_wh = " WHERE n.i_user_id=".$this->user_id." ";
			$this->data['cat']	=	$this->mod_trades->fetch_all_category($s_wh,'','');
			$this->data['counter_cat']	=	count($this->data['cat']);
			//print_r($this->data['cat']);
			
			$this->add_css('css/fe/dd.css');
			$this->add_js('js/fe/jquery.dd.js');
			$this->load->model('city_model');
			$this->load->model('state_model');
			$this->load->model('zipcode_model');
			
			if($_POST)
			{			
				
				$posted=array();
				//pr($_POST);
                $posted["txt_name"]			= trim($this->input->post("txt_name"));
				$posted["txt_email"]		= trim($this->input->post("txt_email"));
				$posted["txt_address"]		= trim($this->input->post("txt_address"));
				$posted["opt_province_id"]	= trim($this->input->post("opt_state"));
				$posted["opt_city_id"]		= trim($this->input->post("opt_city"));
				$posted["i_zipcode_id"]		= trim($this->input->post("opt_zip"));
				$posted["chk_newletter"]	= trim($this->input->post("chk_newletter"));
				/* trade profile*/
				$posted['txt_website']		=	trim($this->input->post("txt_website"));
				$posted['txt_about_me']		=	trim($this->input->post("txt_about_me"));
				$posted['txt_skills']		=	trim($this->input->post("txt_skills"));
				$posted['txt_qualification']=	trim($this->input->post("txt_qualification"));
				$posted['txt_business_name']=	trim($this->input->post("txt_business_name"));
				/* multiple category */
				$posted["opd_category0"]	= 	trim($this->input->post("opd_category0"));
				$posted["opd_category1"]	= 	isset($_POST['opd_category1'])?trim($this->input->post("opd_category1")):'';
				$posted["opd_category2"]	= 	isset($_POST['opd_category2'])?trim($this->input->post("opd_category2")):'';
				
				$posted["h_image_name"]		= 	trim($this->input->post("h_image_name"));
				
				//print_r($posted); exit;
				
				$input_cat	=	array(decrypt($posted["opd_category0"]),decrypt($posted["opd_category1"]),decrypt($posted["opd_category2"]));
				$result_cat	=	array_unique($input_cat);	
				
				//print_r($result_cat); exit;
				/*$cat_str = '';
				foreach($result_cat as $val)
				{
					$cat_str .=$val.',';
				}
				$comma_separated = format_csv_string($cat_str); */				
				
				$posted["payment_type"]		=	trim($this->input->post("RadioGroup1"));
				$posted["like_travel"]		=	trim($this->input->post("RadioGroup2"));
				/* end trade profile*/
				
				//print_r($this->data['info']); echo '<br/>'.$this->data['info']['s_user_image'];  exit;
				
				
				$posted["h_image_name"]		= 	trim($this->input->post("h_image_name"));
				
				if(isset($_FILES['f_image']) && !empty($_FILES['f_image']['name']))
				{
					$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'f_image','','',$this->allowedExt);					
					$arr_upload_res = explode('|',$s_uploaded_filename);
				}
				
				
				$this->form_validation->set_rules('txt_name', t('name'), 'required');
				$this->form_validation->set_rules('txt_email', t('email'), 'valid_email|required');
				$this->form_validation->set_rules('txt_address', t('address'), 'required');
                $this->form_validation->set_rules('opt_state', t('select province'), 'required');
				$this->form_validation->set_rules('opt_city', t('select city'), 'required');
				$this->form_validation->set_rules('opt_zip', t('select postal code'), 'required');
				
				$this->form_validation->set_rules('txt_about_me', t('provide about me'), 'required');
				$this->form_validation->set_rules('txt_skills', t('provide skills'), 'required');
				$this->form_validation->set_rules('txt_qualification', t('provide qualification'), 'required');
				$this->form_validation->set_rules('txt_business_name', t('provide business name'), 'required');
				$this->form_validation->set_rules('opd_category0', t('select category'), 'required');
				
				
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
						
						$info["s_website"]		=	$posted["txt_website"];	
						$info["s_about_me"]		=	$posted["txt_about_me"];	
						$info["s_skills"]		=	$posted["txt_skills"];	
						$info["s_qualification"]=	$posted["txt_qualification"];	
						$info["s_business"]		=	$posted["txt_business_name"];	
						$info["payment_type"]	=	$posted["payment_type"];
						$info["s_like_travel"]	=	$posted["like_travel"];
						
						
						if(count($arr_upload_res)==0)
						{
							$info["s_user_image"] = 	$posted['h_image_name'];
						}
						else
						{
							$info["s_user_image"] = 	$arr_upload_res[2];
						}
						
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
						
						$i_newid 			= 	$this->mod_trades->set_edit_profile($info,$this->user_id);
						
						if(!empty($image_exist))
						{
							$s_where = " where i_user_id={$this->user_id}";
							$this->mod_trades->delete_profile_image($s_where);				
							$i_image			=	$this->mod_trades->update_profile_image($info,$this->user_id);
						}
						else if($s_uploaded_filename)
						{
							$s_where = " where i_user_id={$this->user_id}";
							$this->mod_trades->delete_profile_image($s_where);				
							$i_image			=	$this->mod_trades->insert_profile_image($info,$this->user_id);
						}
						//echo 'aa';exit;
						$this->load->model('newsletter_subscribers_model');
						if($info['chk_newletter']==1)
						{							
							$s_sub = " WHERE n.s_email='".$info['s_email']."' ";
							$is_subscribed = $this->newsletter_subscribers_model->gettotal_info($s_sub);
							if($is_subscribed<=0)
							{
								$info['i_user_id'] = $this->user_id;
								$info['i_user_type'] = 2;
								$info['i_status'] = 1;
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
								$del_id = $this->newsletter_subscribers_model->delete_newsletter_info($i_id);
							}
							
						}
						
						$i_trade_details	=	$this->mod_trades->update_profile_details($info,$this->user_id);
						
						$i_cat_id			= $this->mod_trades->update_multiple_category($result_cat,$this->user_id);
						
						
						if($i_newid)////saved successfully
						{	
							if($arr_upload_res[0]==='ok')
							{
								get_image_thumb($this->uploaddir.$info["s_user_image"], $this->thumbdir, 'thumb_'.$info["s_user_image"],$this->thumb_ht,$this->thumb_wd,'');
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
		
	
	public function change_password()
    {
        try
        {
			$this->i_sub_menu_id=4;
			$user_details = $this->session->userdata('loggedin');
			$this->data['user_id']	=	$user_details['user_id'];
			$this->data['breadcrumb'] = array(t('Change Password')=>'');	
			if($_POST)
			{
				$posted=array();
                $posted["txt_password"]= trim($this->input->post("txt_password"));
				$posted["txt_new_password"]= trim($this->input->post("txt_new_password"));
				$posted["txt_confirm_password"]= trim($this->input->post("txt_confirm_password"));
				
				if(!empty($posted["txt_password"]) && !empty($posted["txt_new_password"]))
				{
					$this->form_validation->set_rules('txt_password', t('existing password'), 'required|callback_authentication_check');
					$this->form_validation->set_rules('txt_new_password', t('New password'), 'required|matches[txt_confirm_password]');
					$this->form_validation->set_rules('txt_confirm_password', t('Confirm password'), 'required');
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
			$this->data['breadcrumb'] = array(t('Contact Details')=>'');	
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
				
				$this->form_validation->set_rules('txt_contact', t('provide contact number'), 'required');
				
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
			$this->i_sub_menu_id=3;
			
			$this->data['pathtoclass']=$this->pathtoclass;
			$user_details = $this->session->userdata('loggedin');
			//print_r($user_details);
			$user_id	=	decrypt($user_details['user_id']);
			$this->data['breadcrumb'] = array(t('My Album')=>'');	
			
			if($_POST)
			{
				//echo 'hi';
				$posted=array();
                $posted["txt_title"]= trim($this->input->post("txt_title"));				
				
				//$this->form_validation->set_rules('f_image', 'browse photo', 'required');
				$s_user_id = " WHERE i_user_id=".$user_id." ";
				$max_photo = $this->mod_trades->get_total_album_images($s_user_id);
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
						$i_newid = $this->mod_trades->upload_album_photo($info,$user_id);
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
							set_error_msg($this->cls_msg["save_err"]);
							$this->render('tradesman/album');
						}
						
					
					}	
				
			
			}
			
		
			$s_where = " WHERE i_user_id=".$user_id." "; 
			$start = ($this->uri->segment($this->i_uri_seg)) ? $this->uri->segment($this->i_uri_seg) : 0;
			$limit	= 15;
		    $this->data['images'] =  $this->mod_trades->get_album_images($s_where,intval($start), $limit);
			$i_total_no = $this->mod_trades->get_total_album_images($s_where);
			$s_pageurl = base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
			$i_uri_segment = $this->i_fe_uri_segment;
			$this->data['pagination'] = $this->get_fe_pagination($s_pageurl,$i_total_no,$limit,$i_uri_segment);
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
		
		if($_POST)
		{
			$info = array();
			$i_img_id = decrypt(trim($this->input->post("h_img_id")));			
			$info['i_is_deleted'] = 1;
			$i_newid = $this->mod_trades->delete_album_photo($i_img_id);
			if($i_newid)
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del"],'message_type'=>'succ'));
				$msg = '1|'.$this->cls_msg["img_del"];
			}
			else
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del_err"],'message_type'=>'err'));
				$msg = '2|'.$this->cls_msg["img_del_err"];
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
		
		if($_POST)
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
				$msg = '1|'.addslashes(t('Denied sucessfully'));
			}
			else
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del_err"],'message_type'=>'err'));
				$msg = '2|'.addslashes(t('Not denied sucessfully'));
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
			$this->i_sub_menu_id=15;
			
			$this->data['pathtoclass']=$this->pathtoclass;
			$user_details = $this->session->userdata('loggedin');
			$this->data['breadcrumb'] = array(t('Email Settings')=>'');	
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
		
   public function do_quote_update()
	{
		try
		{
			if($_POST)
			{
				$flag = false;
				$msg = "";
				$s_jobs_id = $this->input->post('s_job_id');
				$s_quote_id = $this->input->post('s_quote_id');
				$d_quote_amt = $this->input->post('d_quote_amt');
				if($this->job_model->get_job_status(decrypt($s_jobs_id))==1)
				{
					if(decrypt($s_quote_id)>0)
					{
						$arr1 = array();
						$arr1['d_quote'] = doubleval($d_quote_amt);
						$table = $this->db->JOBQUOTES;
					//echo decrypt($s_quote_id);
					
						if($this->job_model->set_data_update($table,$arr1,decrypt($s_quote_id)))
						{
							$flag = true;
							$msg = addslashes(t("Congratulations!! Your quote has been updated successfully."));
						}
						else
						{
							$msg = addslashes(t("Sorry. Your quote price updation failed. Please try again.."));
						}
					}
					else
					{
						$msg = addslashes(t(" You are not authenticated to access this page."));
					}
				}
				else{
					$msg = addslashes(t("This job is no longer active."));
				}
				echo json_encode(array('flag'=>$flag,'msg'=>$msg));
				exit;
			}
			else
			{
				//echo 'Hi';
				redirect(base_url());
			}
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
			$this->i_sub_menu_id	=	6;
			$this->data['breadcrumb'] = array(t('Quotes')=>'');	
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
		$s_where = " WHERE n.i_tradesman_user_id = {$this->user_id} And (n.i_status!=3 OR n.i_status!=7 OR n.i_status!=10) "; 
		//$s_where = " WHERE n.i_tradesman_user_id = {$this->user_id} And (n.i_status!=3) "; 
		$limit	= $this->i_fe_page_limit;			
		
		$this->data['job_list']	= $this->job_model->fetch_quote_multi($s_where,intval($start),$limit,$this->i_default_language);		
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
		
		$this->load->view('fe/tradesman/ajax_quote_jobs.tpl.php',$this->data);
			
	}   
	
	
	/* job invitation */
	 public function job_invitation()
   {
   		try
		{
			
			$this->i_sub_menu_id	=	7;
			$this->data['breadcrumb'] = array(t('Job Invitations')=>'');	
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
		$s_where = " WHERE inv.i_tradesman_id = {$this->user_id} AND inv.i_status=1 AND cat_c.i_lang_id =".$this->i_default_language; 

		$limit	= $this->i_fe_page_limit;			
			
		$this->data['job_list']	= $this->job_model->fetch_multi($s_where,intval($start),$limit);		
		//pr($this->data['job_list']);
		//$total_rows = $this->job_model->gettotal_job_invitation(" WHERE inv.i_tradesman_id = {$this->user_id} AND inv.i_status=1");	
		
		$total_rows = $this->job_model->gettotal_job_invitation($s_where);	


		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'tradesman/invite_jobs_pagination_ajax/';
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
			
			$this->i_sub_menu_id	=	12;
			$this->data['breadcrumb'] = array(t('Frozen Jobs')=>'');	
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
		$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=8 AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 

		$limit	= $this->i_fe_page_limit;			
			
		$this->data['job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);		
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
		$config['first_tag_open'] = '<div style="display:none">';
		$config['first_tag_close'] = '</div>';
		$config['last_tag_open'] = '<div style="display:none">';
		$config['last_tag_close'] = '</div>';

		$config['prev_link'] = '<';
		$config['next_link'] = '>';

		$config['cur_tag_open'] = '<a class="active">';
		$config['cur_tag_close'] = '</a>';

	
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
			
			$this->i_sub_menu_id	=	9;
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
   
   /* Ajax pagination for all jobs */
	function pending_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=11 AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 

		$limit	= $this->i_fe_page_limit;			
			
		$this->data['job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);		
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
		$config['first_tag_open'] = '<div style="display:none">';
		$config['first_tag_close'] = '</div>';
		$config['last_tag_open'] = '<div style="display:none">';
		$config['last_tag_close'] = '</div>';

		$config['prev_link'] = '<';
		$config['next_link'] = '>';

		$config['cur_tag_open'] = '<a class="active">';
		$config['cur_tag_close'] = '</a>';

	
		$config['div'] = '#job_list';

		$this->jquery_pagination->initialize($config);
		$this->data['page_links'] = $this->jquery_pagination->create_links();
		$this->data['total_rows'] = $total_rows;
		
		$this->load->view('fe/tradesman/ajax_pending_jobs.tpl.php',$this->data);
			
	}   	
	
	
	public function my_won_jobs()
   {
   		try
		{
			
			//$this->i_sub_menu_id	=	9;
			$this->data['breadcrumb'] = array(t('My Won Jobs')=>'');	
			$this->data['pathtoclass']=$this->pathtoclass;
			$this->data['i_tradesman_id'] = $this->user_id;
			ob_start();
			$this->my_won_jobs_pagination_ajax();
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
	function my_won_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND (n.i_status=4 || n.i_status=6 || n.i_status=10) AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 

		$limit	= $this->i_fe_page_limit;			
			
		$this->data['job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);		
		//pr($this->data['job_list']);
		$total_rows = $this->job_model->gettotal_info($s_where);	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'tradesman/my_won_jobs_pagination_ajax/';
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

	
		$config['div'] = '#job_list';

		$this->jquery_pagination->initialize($config);
		$this->data['page_links'] = $this->jquery_pagination->create_links();
		$this->data['total_rows'] = $total_rows;
		
		$this->load->view('fe/tradesman/ajax_my_won_jobs.tpl.php',$this->data);
			
	}   
	
	
	public function completed_jobs()
   {
   		try
		{			
			$this->i_sub_menu_id	=	11;
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
   
   /* Ajax pagination for all jobs */
	function completed_jobs_pagination_ajax($start=0) {	
		$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=6 AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 

		$limit	= $this->i_fe_page_limit;			
			
		$this->data['job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);		
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
		$config['first_tag_open'] = '<div style="display:none">';
		$config['first_tag_close'] = '</div>';
		$config['last_tag_open'] = '<div style="display:none">';
		$config['last_tag_close'] = '</div>';

		$config['prev_link'] = '<';
		$config['next_link'] = '>';

		$config['cur_tag_open'] = '<a class="active">';
		$config['cur_tag_close'] = '</a>';

	
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
			$this->i_sub_menu_id	=	10;
			$this->data['breadcrumb'] = array(t('In Progress')=>'');	
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
		$s_where = " WHERE n.i_tradesman_id = {$this->user_id} AND n.i_status=4 AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 

		$limit	= $this->i_fe_page_limit;			
			
		$this->data['job_list']	= $this->job_model->fetch_multi_completed($s_where,intval($start),$limit);		
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
		$config['first_tag_open'] = '<div style="display:none">';
		$config['first_tag_close'] = '</div>';
		$config['last_tag_open'] = '<div style="display:none">';
		$config['last_tag_close'] = '</div>';

		$config['prev_link'] = '<';
		$config['next_link'] = '>';

		$config['cur_tag_open'] = '<a class="active">';
		$config['cur_tag_close'] = '</a>';

	
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
		if($_POST)
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
			$i_newid = $this->job_model->set_data_update($table,$info,$cond);
			if($i_newid)
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del"],'message_type'=>'succ'));
				$msg = '1|'.addslashes(t('Denied sucessfully'));
			}
			else
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del_err"],'message_type'=>'err'));
				$msg = '2|'.addslashes(t('Not denied sucessfully'));
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
			   
			   $filename = $this->config->item('EMAILBODYHTML')."common.html";
			   $handle = @fopen($filename, "r");
			   $mail_html = @fread($handle, filesize($filename));				
				//print_r($content); exit;
				if(!empty($content))
				{				
					if($buyer_details['i_signup_lang']==2)	// for those buyers who have registered in french version
					{
						$description = $content["s_content_french"];
					}	
					else
					{	
					$description = $content["s_content"];
					}
					$description = str_replace("[Buyer name]",$buyer_details['s_username'],$description);
					$description = str_replace("[job title]",$job_details['s_title'],$description);	
					$description = str_replace("[Service professional name]",$job_details['s_tradesman_name'],$description);
					$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);	
						
					
					$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
				}
				//unset($content);
				
				$mail_html = str_replace("[site url]",base_url(),$mail_html);	
				$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
				//echo $this->data['loggedin']['user_email'];	
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
								
				$this->email->to($buyer_details['s_email']);
				if($buyer_details['i_signup_lang']==2)	
				{
					$this->email->subject($content['s_subject_french']);
				}
				else
				{	
					$this->email->subject('::: Feedback Asked :::');
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
				
			/* end job quote mail to the user */					
			  }
			
			
			
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del"],'message_type'=>'succ'));
				$msg = '1|'.addslashes(t('Feedback asked sucessfully'));
			}
			else
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["job_del_err"],'message_type'=>'err'));
				$msg = '2|'.addslashes(t('Feedback not asked sucessfully'));
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
		//echo $tot_recomm.'===='.$waiver_comm;exit;
		if($tot_recomm>=$waiver_comm)
		{
			//exit;
			$i_job_id = decrypt($i_job_id);
			$i_tradesman_id = $this->user_id;
			$info['i_status '] = 4;		
			//$info['i_status '] = 8;		
			$table = $this->db->JOBS;
			$cond  = array('id '=>$i_job_id);
			$i_newid = $this->job_model->set_data_update($table,$info,$cond);
			
			if($i_newid)
			{		
				/* to update tradesman won job after successful payment*/
				$this->mod_trades->update_tradesman_won_job($i_tradesman_id);				
				$this->load->model('commission_slab_model');
				$s_where = " WHERE 	i_is_active=1";
				$comm = $this->commission_slab_model->fetch_multi($s_where);
				//pr($comm); exit;
				$site_settings = $this->mod_site_setting->fetch_this(NULL);
				$s_where = " WHERE 	i_tradesman_user_id ={$this->user_id} AND i_job_id ={$i_job_id}";
				$job_details = $this->job_model->fetch_quote_multi($s_where,0,1);
				//$job_details[0]['d_quote'] = 150;
				//pr($job_details); exit;
				if($job_details[0]['d_quote'] >100)
				{
					$t1 = doubleval((100*$comm[0]['s_commission_slab_100'])/100);
					$t2 = doubleval((($job_details[0]['d_quote']-100)* $comm[0]['s_commission_greater_than_100'])/100);
					$tot_amt = $t1+ $t2;
				}
				else
				{
					$tot_amt = doubleval(($job_details[0]['d_quote']*$comm[0]['s_commission_slab_100'])/100);
				}	
				$tot_amt = $tot_amt.' '.$this->config->item('default_currency');	
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
				$arr1["i_job_id"] = $i_job_id;
				$arr1['i_user_id'] =  $this->user_id;
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
					if($tradesman_details['i_signup_lang']==2)	
					{
						$description = $content["s_content_french"];
					}
					else
					{			
						$description = $content["s_content"];
					}
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
				
				if($tradesman_details['i_signup_lang']==2)	
				{
					$this->email->subject($content['s_subject_french']);
				}
				else
				{	
					$this->email->subject('::: Job waivered sucessfully :::');
				}
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
				
				$this->session->set_userdata(array('message'=>t('Congratulations! You are waived for the job payment.'),'message_type'=>'succ'));
				redirect(base_url().'home/message');
			 }			
		}
		
				
		include_once(APPPATH.'libraries/paypal_IPN/paypal.class.php');	
		$i_job_id =  decrypt($i_job_id);	
			
		$data['title'] = t("Payment");
		
		# store the entire "Paypal-IPN" object...
		$PAYPAL_ENVIRONMENT = 'test';
		$this->load->model('commission_slab_model');
		$s_where = " WHERE 	i_is_active=1";
		$comm = $this->commission_slab_model->fetch_multi($s_where);
		//pr($comm); exit;
		$site_settings = $this->mod_site_setting->fetch_this(NULL);
		$s_where = " WHERE 	i_tradesman_user_id ={$this->user_id} AND i_job_id ={$i_job_id}";
		$job_details = $this->job_model->fetch_quote_multi($s_where,0,1);
		//$job_details[0]['d_quote'] = 150;
		//pr($job_details); exit;
		if($job_details[0]['d_quote'] >100)
		{
		 	$t1 = doubleval((100*$comm[0]['s_commission_slab_100'])/100);
			$t2 = doubleval((($job_details[0]['d_quote']-100)* $comm[0]['s_commission_greater_than_100'])/100);
			$tot_amt = $t1+ $t2;
		}
		else
		{
			$tot_amt = doubleval(($job_details[0]['d_quote']*$comm[0]['s_commission_slab_100'])/100);
		}	
		//pr($tot_amt); exit;
		
		$IPN_OBJ = new paypal_class;     // initiate an instance of the IPN class...
		$IPN_OBJ->paypal_url = $this->config->item('paypal_url');//$this->site_settings_model->getPaypalURL($PAYPAL_ENVIRONMENT);
		$IPN_OBJ->add_field('cmd', '_cart');
		$IPN_OBJ->add_field('upload', 1);
		$data['paypal_obj'] = $IPN_OBJ;

		# retrieving all cart-contents...
		//$CART_CONTENTS_ARR = $this->cart->_get_cart_contents();
		$data['cart_contents'] = $CART_CONTENTS_ARR;

		# fixing shipping amount etc...
		$LOGGED_USR_ID = $this->user_id;
		$TOTAL_AMOUNT  = $tot_amt;
		$SHIPPING_AMOUNT = 0;
		$TOTAL_AMOUNT = $tot_amt + $SHIPPING_AMOUNT;
		$data['total_charge'] = $TOTAL_AMOUNT;
		$data['shipping_charge'] = $SHIPPING_AMOUNT;
		$data['paypal_account'] = $site_settings['s_paypal_email'];
		$data['user_id'] = $LOGGED_USR_ID;
		$data['item_id'] = $i_job_id;
		$data['item_name'] = 'Job payment';
		$data['currency'] = $this->config->item('default_currency');
		$this->session->set_userdata(array('ses_data_temp'=>$data));
		//pr($data); exit;	
		$this->load->view('fe/tradesman/place_paypal_order.tpl.php', $data);
		
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
			$itemIdArr = explode('&', $IPN_ARR['custom']);
			$i_tradesman_id = $itemIdArr[0];	
			$i_job_id = $itemIdArr[1];
		}
		
	    /*To stop same entry*/
		$s_where = " WHERE n.i_job_id={$i_job_id} AND n.i_user_id={$i_tradesman_id}";
		$chk_tot = $this->job_model->gettotal_payment_info($s_where);
		if($chk_tot)
		{
			$this->session->set_userdata(array('message'=>t('Your payment has already completed'),'message_type'=>'err'));
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
		$customer_name 	= $info[0]['s_username'];
		$address 		= $info[0]['s_address'];
		$state 			= $info[0]['s_state'];
		$city 			= $info[0]['s_city'];
		$postal 		= $info[0]['s_postal_code'];
		$payment_date	= $info[0]['dt_payment_date'];
		$job_title 		= $info[0]['s_part_title'];
		$job_cost		= $info[0]['s_budget_price'];
		//$paid_amount	= $info[0]['s_paid_amount'];
		$paid_amount	= doubleval($info[0]['s_paid_amount']);
		$paid_amnt	= number_format($paid_amount, 2, '.', '');		
		//$paid_amount_word=$currency_object ->get_bd_amount_in_text($info[0]['s_paid_amount']);
		$paid_amount_word = convert_number($paid_amnt);
		
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
                  Postal Code-'.$postal.'</td>
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
                                                                  <td valign="top" align="right">  </td>
                                                                  <td style="color:#616161;" valign="top">  </td>
                                                            </tr>
                                                            
                                                      </table>
                                                  </td>
                                                <td style="border-bottom:1px solid #b5b5b5;border-left:1px solid #b5b5b5;padding:8px;" align="right" valign="top">'.$paid_amount.' CAD</td>
                                          </tr>
                                          
                                          <tr>
                                                <td style="border-bottom:1px solid #b5b5b5; padding:8px;" align="left" valign="top">&nbsp;</td>
                                                <td style="border-bottom:1px solid #b5b5b5; font-size:14px;border-left:1px solid #b5b5b5; padding:8px;"  align="right" valign="top"> Net Payable Amount</span> </td>
                                                <td style="border-bottom:1px solid #b5b5b5;font-size:14px;color:#17a2dd;border-left:1px solid #b5b5b5;padding:8px;" align="right" valign="top">'.$paid_amount.' CAD</td>
                                          </tr>
                                    </table>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                          <tr>
                                                <td style="color:#aaa; padding-top:8px;" colspan="2" align="right" valign="top"><span style="color:#ec2d52;">*</span> Price is inclusive all taxes</td>
                                          </tr>
                                          <tr>
                                      
                                                  <td width="20%" valign="top">Amount In Words : </td>
                                                <td width="80%" valign="top" style="color:#616161;"> '.$paid_amount_word.' CAD only</td>
                                          </tr>
                                            <tr>
                                                  <td valign="top"> Payment Method  :</td>
                                                  <td style="color:#616161;" valign="top"> PAYPAL  </td>
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
            <td colspan="2" style=" color:#aaa; line-height:35px; font-size:11px; text-align:center; font-family:Georgia, Times New Roman, Times, serif; "><em><strong>Quote your job.ca</strong></em></td>
      </tr>
</table>
</body>
</html>
';
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
				if($tradesman_details['i_signup_lang']==2)	
				{
					$description = $content["s_content_french"];
				}
				else
				{			
					$description = $content["s_content"];
				}
				
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
			if($tradesman_details['i_signup_lang']==2)	
			{
				$this->email->subject($content['s_subject_french']);
			}
			else
			{
				$this->email->subject('::: Sucessful Payment :::');
			}
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
   
   
   public function testimonial()
    {
        try
        {
			$this->i_sub_menu_id=19;
			$this->data['pathtoclass']=$this->pathtoclass;
			$user_details = $this->session->userdata('loggedin');
			$user_name	=	$user_details['user_name'];
			$this->data['user_id']	=	$user_details['user_id'];
			if($_POST)
			{
				
				$posted=array();
                $posted["txt_content"]= trim($this->input->post("txt_content"));				
				
				$this->form_validation->set_rules('txt_content', t('provide testimonial'), 'required');
				
				
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
			
			$this->data['breadcrumb'] = array(t('My Testimonial')=>'');	
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
		$s_where = " WHERE n.i_job_id={$i_job_id} AND n.i_status=1 AND n.i_receiver_user_id={$this->user_id} AND cat_c.i_lang_id =".$this->i_default_language; 
		$this->data['feedback_details'] =  $this->manage_feedback_model->fetch_multi($s_where,0,1);
		//pr($this->data['feedback_details']);
   		$this->load->view('fe/tradesman/job_feedback.tpl.php', $this->data);
   }
   
  function feedback_received()
	   {
		try
		{
				$this->i_sub_menu_id	=	13;
				$this->data['breadcrumb'] = array(t('Feedback Received')=>'');	
				ob_start();
				
			    $id = $this->data['loggedin']['user_id'];
			  
				$this->pagination_feedback_ajax($id,0,1);
				$contents = ob_get_contents();
				ob_end_clean();
				//$this->load->model('tradesman_model');
				$info = $this->tradesman_model->fetch_this(decrypt($id));
				$this->data['profile_info'] = $info;
				$this->data['feedback_contents'] = $contents;
					
				$this->render();
			
		}
	catch(Exeception $e)
	{
		show_error($e->getMessage());
	}
   }
		
		public function pagination_feedback_ajax($s_id,$start=0,$param=0) {
		$limit	= $this->i_fe_page_limit;
	//	$limit = 2;
		$this->load->model("Manage_feedback_model","mod_feed");
		$s_where = " WHERE n.i_receiver_user_id = ".decrypt($s_id)." AND n.i_status != 0   AND cat_c.i_lang_id =".$this->i_default_language; 
		$feedback = $this->mod_feed->fetch_multi($s_where,intval($start),$limit);
		
		$total_rows = $this->mod_feed->gettotal_info($s_where);	
		
		
		$this->data['feedback_list'] = $feedback;
		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'pagination_feedback_ajax/'.$s_id.'/';
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
		
		$job_vw = $this->load->view('fe/find_tradesman/ajax_feedback_list.tpl.php',$this->data,TRUE);
		
		echo $job_vw;		
	}	
	
	
	public function tradesman_radar_job()
	{
		try
		{
			$this->data['breadcrumb'] = array(t('Radar Jobs')=>'');	
			$s_cat_name = t('None');
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
					
					$s_cat_where = " WHERE c.id IN(".implode(",",$cat_arr).") AND cat_l.i_lang_id=".$this->i_default_language;
					$arr_cat = $this->radar_model->get_radar_cat_name($s_cat_where);
					//pr($arr_cat);exit;
					$s_cat_name = implode(", ",$arr_cat);
					
				}
			}
			
			$this->session->set_userdata(array('model_session'=>$sessArrTmp));	// to store data in session
			$this->data['posted'] = $sessArrTmp;
			$this->data['s_cat_name'] = $s_cat_name;
			
			$this->i_sub_menu_id	=	8;
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
		
		$arr_search[] = " n.i_status=1 AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 
				
			
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
		if($sessArrTmp['src_job_radius'] && $sessArrTmp['src_job_postal_code'])
		{
			
			$zipcode = $this->zipcode_model->fetch_multi(" WHERE n.postal_code='{$sessArrTmp['src_job_postal_code']}'");
			
			if(!empty($zipcode))
			 {
				$lat = $zipcode[0]['latitude'];
				$lng = $zipcode[0]['longitude'];
				$job_radius = intval($sessArrTmp['src_job_radius']);
				//$job_radius = (intval($sessArrTmp['src_job_radius'])*10)+10;
				
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
		$config['first_tag_open'] = '<div style="display:none">';
		$config['first_tag_close'] = '</div>';
		$config['last_tag_open'] = '<div style="display:none">';
		$config['last_tag_close'] = '</div>';

		$config['prev_link'] = '<';
		$config['next_link'] = '>';

		$config['cur_tag_open'] = '<a class="active">';
		$config['cur_tag_close'] = '</a>';


		$config['div'] = '#job_list';
		//$config['js_bind'] = "showLoading();";

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
			$this->i_sub_menu_id	=	16;
			$this->data['breadcrumb'] = array(t('Job Radar')=>'');	
			
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
				
				$this->form_validation->set_rules('txt_postal_code', t('postal code'), 'required');
                $this->form_validation->set_rules('opt_radius', t('radius'), 'required');
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
		$customer_name 	= $info[0]['s_username'];
		$address 		= $info[0]['s_address'];
		$state 			= $info[0]['s_state'];
		$city 			= $info[0]['s_city'];
		$postal 		= $info[0]['s_postal_code'];
		$payment_date	= $info[0]['dt_payment_date'];
		$job_title 		= $info[0]['s_part_title'];
		$job_cost		= $info[0]['s_budget_price'];
		//$paid_amount	= $info[0]['s_paid_amount'];
		$paid_amount	= doubleval($info[0]['s_paid_amount']);
		$paid_amnt	= number_format($paid_amount, 2, '.', '');		
		//$paid_amount_word=$currency_object ->get_bd_amount_in_text($info[0]['s_paid_amount']);
		$paid_amount_word = convert_number($paid_amnt);
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
                  Postal Code-'.$postal.'</td>
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
                                                                  <td valign="top" align="right">  </td>
                                                                  <td style="color:#616161;" valign="top">  </td>
                                                            </tr>
                                                            
                                                      </table>
                                                  </td>
                                                <td style="border-bottom:1px solid #b5b5b5;border-left:1px solid #b5b5b5;padding:8px;" align="right" valign="top">'.$paid_amount.' CAD</td>
                                          </tr>
                                          
                                          <tr>
                                                <td style="border-bottom:1px solid #b5b5b5; padding:8px;" align="left" valign="top">&nbsp;</td>
                                                <td style="border-bottom:1px solid #b5b5b5; font-size:14px;border-left:1px solid #b5b5b5; padding:8px;"  align="right" valign="top"> Net Payable Amount</span> </td>
                                                <td style="border-bottom:1px solid #b5b5b5;font-size:14px;color:#17a2dd;border-left:1px solid #b5b5b5;padding:8px;" align="right" valign="top">'.$paid_amount.' CAD</td>
                                          </tr>
                                    </table>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                          <tr>
                                                <td style="color:#aaa; padding-top:8px;" colspan="2" align="right" valign="top"><span style="color:#ec2d52;">*</span> Price is inclusive all taxes</td>
                                          </tr>
                                          <tr>
                                      
                                                  <td width="20%" valign="top">Amount In Words : </td>
                                                <td width="80%" valign="top" style="color:#616161;"> '.$paid_amount_word.' CAD only</td>
                                          </tr>
                                            <tr>
                                                  <td valign="top"> Payment Method  :</td>
                                                  <td style="color:#616161;" valign="top"> PAYPAL  </td>
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
            <td colspan="2" style=" color:#aaa; line-height:35px; font-size:11px; text-align:center; font-family:Georgia, Times New Roman, Times, serif; "><em><strong>Quote your job.ca</strong></em></td>
      </tr>
</table>
</body>
</html>
';
       $this->load->plugin('to_pdf');
       $ffname = 'invoice_'.time();
       pdf_create($html_n, $ffname);

    }
	
	function check_postar_code()
	{
		$this->load->model('zipcode_model');
		$txt_postal_code = $this->input->post('txt_postal_code');
		$s_where = " WHERE n.postal_code='{$check_postar_code}'";
		$chk = $this->zipcode_model->gettotal_info($s_where);
		if($chk)
			return true;
		else
			return false;	
		
		
	}
	
	
	/* script to update tradesman won job update field ata time for whole tradesman*/
	function tradesman_wonjob_update_script()
	{
		//echo 'aa';exit;
		$trad = $this->mod_trades->get_all_tradesman_won_job();
		if($trad)
		{
			foreach($trad as $val)
			{
				$info['i_jobs_won '] = $val['tot_won_job'];		
				$table = $this->db->TRADESMANDETAILS;
				$cond  = array('i_user_id '=>$val['i_tradesman_id']);
				$i_newid = $this->job_model->set_data_update($table,$info,$cond);	
			}
		}
	}
	
    public function __destruct()

    {}           

}



/* End of file welcome.php */

/* Location: ./system/application/controllers/welcome.php */

