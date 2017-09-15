<?php
/*********
* Author: Iman Biswas
* Date  : 23 Sep 2011
* Modified By: 
* Modified Date: 
* 
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class Home extends My_Controller
{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public function __construct()
    {
        try
        { 
          parent::__construct(); 
          $this->data['title']="Home";////Browser Title
		  $this->data['ctrlr'] = "home";

          $this->cls_msg=array();

		  $this->cls_msg["no_result"]=t("No information found about latest news.");
		  
		  $this->cls_msg["contact_send_err"]=t("Contact us mail not delivered.");
          $this->cls_msg["contact_send_succ"]=t("Contact us mail delivered successfully.");
		  
		  $this->cls_msg["abuse_send_err"]=t("Abuse report mail not delivered.");
          $this->cls_msg["abuse_send_succ"]=t("Abuse report mail delivered successfully.");
		  
		  $this->cls_msg["subcribe_succ"] = t("Newletter subscribed successfully");
		  $this->cls_msg["subcribe_err"] = t("Newletter not subscribed successfully");
		  $this->cls_msg["subcribe_duplicate_err"] = t("Email address already subscribed.");
		  
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  $this->load->model('content_model','mod');
		  
		  		  
		 // $this->load->model('auto_mail','mod_auto');
		  
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
			
			$this->s_meta_type = 'home';
			
			//echo date('Y-m-d',1322029423);
		    /**fetch job category **/
		    $this->load->model('category_model');
		    $s_where = " WHERE s_category_type='job' and i_status=1 AND cc.i_lang_id =".$this->i_default_language; 
		    $this->data['category_list'] =  $this->category_model->fetch_multi($s_where,0,20);
		    /**end fetch job category **/
		  
		    /**fetch news **/
		    $this->load->model('news_model');
		    $s_where = " WHERE i_status=1"; 
		    $this->data['news_list'] =  $this->news_model->fetch_multi($s_where);
		    $this->data['tot_news'] = count($this->data['news_list']);
			
		   /**end fetch news **/	
		   
		    /**fetch testimonial **/
		    $this->load->model('testimonial_model');
		    $s_where = " WHERE i_status=2 AND i_del_status =1"; 
		    $this->data['testimonial_list'] =  $this->testimonial_model->fetch_multi($s_where);
			
			
			/*****Featured Tradesman******/
			$this->load->model('Tradesman_model',"mod_trades");
		    $s_where = " WHERE i_is_active=1 "; 
			$orderby = " td.i_jobs_won,td.i_feedback_received ";
			$this->data['tradesman_list'] = $this->mod_trades->fetch_featured_latest($s_where,$orderby,0,5);
			//print_r($this->data['tradesman_list']);exit;
			$this->data['image_path'] = $this->config->item("user_profile_image_thumb_path");
			$this->data['image_up_path'] = $this->config->item("user_profile_image_thumb_upload_path");
			//pr($this->data['tradesman_list']);
			/***** End Featured Tradesman******/
			
		    /**completed jobs**/
		    $this->load->model('job_model');
		    $s_where = " WHERE n.i_status=6 AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 
		    $this->data['complete_job_list'] =  $this->job_model->fetch_multi_completed($s_where,0,5,"n.i_completed_date");
			//pr($this->data['loggedin']);
			/** end completed jobs **/
			/*$this->load->model('auto_mail_model');
			$content = $this->auto_mail_model->fetch_contact_us_content('job_posted','buyer');	
			var_dump($content); exit;*/
			
		   /**end fetch testimonial **/		   
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
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
	
	
	
    public function cms($param)
    {
        try
        {			
			//$this->data['breadcrumb'] = array('How it works'=>'');
			//$this->render();
			//echo $param;
			switch($param)
			{
				case "about_us":
					$i_cms_type_id = 1;
					$this->s_meta_type = 'about_us';
					break;
				case "careers":
					$i_cms_type_id = 3;
					$this->s_meta_type = 'careers';
					break;
				case "mission_vision":
					$i_cms_type_id = 4;
					$this->s_meta_type = 'mission_vision';
					break;
				case "privacy_policy":
					$i_cms_type_id = 5;
					$this->s_meta_type = 'privacy_policy';
					break;
				case "terms_condition":
					$i_cms_type_id = 6;
					$this->s_meta_type = 'terms_&_conditions';
					break;			
				default :	
					$i_cms_type_id = 1;
					$this->s_meta_type = 'default';
			}
			
			$s_where = " WHERE c.i_cms_type_id={$i_cms_type_id} And c.i_status=1 ";
			$data_exist = $this->mod->fetch_multi($s_where.' And c.i_lang_id="'.$this->i_default_language.'"');
			if(!empty($data_exist))
			{
			$this->data["info"] = $data_exist;
			}
			else
			{
				$this->data['info'] = $this->mod->fetch_multi($s_where.' And c.i_lang_id="'.$this->i_main_default_language.'"');
			}
			
			$this->data['breadcrumb'] = array(t($this->data['info'][0]["s_title"])=>'');
			
			$title = explode(' ',$this->data['info'][0]["s_title"],2);
			$this->data["pre"] = $title[0];
			$this->data["next"] = $title[1];
			$this->render("home/cms");			
			
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	
	/*public function about_us()
    {
        try
        {
			
			$s_where = " WHERE c.i_cms_type_id=1 And c.i_status=1 ";			
			
			
			$data_exist = $this->mod->fetch_multi($s_where.' And c.i_lang_id="'.$this->i_default_language.'"');
			if(!empty($data_exist))
			{
			$this->data["info"] = $data_exist;
			}
			else
			{
				$this->data['info'] = $this->mod->fetch_multi($s_where.' And c.i_lang_id="'.$this->i_main_default_language.'"');
			}
			
			
			$this->data['breadcrumb'] = array('About Us'=>'');
			
			//$this->data['info'] = $this->mod->fetch_multi($s_where);
			
			$title = explode(' ',$this->data['info'][0]["s_title"],2);
			$this->data["pre"] = $title[0];
			$this->data["next"] = $title[1];
			
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }*/
	
	
	
	public function help()
    {
        try
        {
			$this->i_menu_id = 5;
			
			$this->s_meta_type = 'help';
			
			$this->load->model('help_model','mod_help');
			
			$this->load->model('category_model','mod_cat');
			
			$s_wh_cat = " WHERE c.s_category_type='".help."' AND cc.i_lang_id =".$this->i_default_language; 
				
			
			// fetch the question answer
			$s_lang_query = " And n.i_status=1 ";
			
			if(!empty($this->i_default_language))
			{				
				$s_lang_query .=" And n.i_lang_id=".$this->i_default_language."";
			}
			else if(!empty($this->i_main_default_language))
			{				
				$s_lang_query .=" And n.i_lang_id=".$this->i_main_default_language."";
			}
			else if(!empty($this->i_main_default_language) && ($this->i_default_language == $this->i_main_default_language))
			{	
				$s_lang_query .=" And n.i_lang_id=".$this->i_default_language."";
			}
			
			
			$this->data['breadcrumb'] = array(t('Help')=>'');			
			
			$this->data['category']	=	$this->mod_cat->fetch_help_content($s_wh_cat,'','',$s_lang_query);
			
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/* how it works start*/
	
	public function how_it_works($type)
    {
        try
        {	
			$this->s_meta_type = 'how_it_works_buyer';		
			$s_type = decrypt($type);	
			if($s_type==2)
			{
				$this->s_meta_type = 'how_it_works_tradesman';
			}	
			if($s_type==1)
			{
				$this->s_meta_type = 'how_it_works_buyer';
			}		
			
			$s_where = " WHERE n.i_status=1 ";
			
			//$this->data['check_data_exist'] = $this->mod_how_it_works_tradesman->fetch_multi($s_where.' And n.i_lang_id="'.$this->i_main_default_language.'"');
			if(!empty($this->i_default_language))
			{				
				$s_where .=" And n.i_lang_id=".$this->i_default_language."";
			}
			else if(!empty($this->i_main_default_language))
			{				
				$s_where .=" And n.i_lang_id=".$this->i_main_default_language."";
			}
			else if(!empty($this->i_main_default_language) && ($this->i_default_language == $this->i_main_default_language))
			{	
				$s_where .=" And n.i_lang_id=".$this->i_default_language."";
			}
			
			$this->data['breadcrumb'] = array(t('How it works')=>'');
			
			if($s_type==2)
			{		
			//$this->data['breadcrumb'] = array(t('How it works for tradesman')=>'');	
			$this->load->model('how_it_works_tradesman_model','mod_how_it_works_tradesman');
			$this->data['info'] = $this->mod_how_it_works_tradesman->fetch_multi($s_where);
			$this->render('home/how_it_works_tradesman');
			}
			if($s_type==1)
			{		
			//$this->data['breadcrumb'] = array(t('How it works for buyers')=>'');
			$this->load->model('how_it_works_buyer_model','mod_how_it_works_buyer');	
			$this->data['info'] = $this->mod_how_it_works_buyer->fetch_multi($s_where);
			$this->render('home/how_it_works_buyer');
			}			
			
			//$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/* how it works end */
	
	/* faq starts */
	public function faq($type)
    {
        try
        {
			//$this->load->model('help_model','mod_help');
			$s_type = decrypt($type);
			
			$this->load->model('category_model','mod_cat');
			
			if($s_type==1)
			{
			$s_wh_cat = " WHERE c.s_category_type='".buyer_faq."'";
			}		
			
			if($s_type==2)
			{
			$s_wh_cat = " WHERE c.s_category_type='".tradesman_faq."' ";
			}			
			
			// fetch the question answer
			$s_lang_query = " And n.i_status=1 ";
			$i_lang_id = $this->i_default_language;
			if(!empty($this->i_default_language))
			{				
				$s_lang_query .=" And n.i_lang_id=".$this->i_default_language."";
				$i_lang_id = $this->i_default_language;
			}
			else if(!empty($this->i_main_default_language))
			{				
				$s_lang_query .=" And n.i_lang_id=".$this->i_main_default_language."";
				$i_lang_id = $this->i_main_default_language;
			}
			else if(!empty($this->i_main_default_language) && ($this->i_default_language == $this->i_main_default_language))
			{	
				$s_lang_query .=" And n.i_lang_id=".$this->i_default_language."";
				$i_lang_id = $this->i_default_language;
			}
			
		//echo	$s_lang_query ;
			if($s_type==1)		// buyers faq
			{
			$this->data['breadcrumb'] = array(t('Buyer FAQ')=>'');
			
			$this->s_meta_type = 'faq_buyer';			
		//	echo $s_lang_query;
			$this->data['category']	=	$this->mod_cat->fetch_buyer_faq_content($s_wh_cat,'','',$s_lang_query,$i_lang_id);
			
			$this->render('home/job_poster_questions');
			}			
			if($s_type==2)		// tradesman faq
			{
			$this->data['breadcrumb'] = array(t('Tradesman FAQ')=>'');
			
			$this->s_meta_type = 'faq_tradesman';			
			
			$this->data['category']	=	$this->mod_cat->fetch_tradesman_faq_content($s_wh_cat,'','',$s_lang_query,$i_lang_id);
			
			$this->render('home/service_provider_questions');
			}
			
			
			
			//$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	/* end faq*/	
	
	public function contact_us()
    {
        try
        {
			if(count($_POST)>0)
			{
                $this->load->model('auto_mail_model','mod_auto');
                $info = array();
                
                $this->form_validation->set_rules('txt_name', t('Provide name'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('txt_email', t('Provide email'), 'trim|required|valid_email');
                $this->form_validation->set_rules('txt_msg', t('Provide message'), 'required');
                $this->form_validation->set_rules('txt_subject', t('Provide subject'), 'trim|xss_clean');
                
                if ($this->form_validation->run() != FALSE)
                {
                    $info['s_name'] 	= htmlentities($this->input->post('txt_name'), ENT_QUOTES, 'utf-8');
					$info['s_username'] = htmlentities($this->input->post('txt_username'), ENT_QUOTES, 'utf-8');
                    $info['s_email'] 	= htmlentities($this->input->post('txt_email'), ENT_QUOTES, 'utf-8');
                    $info['s_msg'] 		= htmlentities($this->input->post('txt_msg'), ENT_QUOTES, 'utf-8');
					$info['s_subject'] 	= htmlentities($this->input->post('txt_subject'), ENT_QUOTES, 'utf-8');
                    
					
					$content = $this->mod_auto->fetch_contact_us_content('contact_us','general');	
					$filename = $this->config->item('EMAILBODYHTML')."common.html";
				   	$handle = @fopen($filename, "r");
				   	$mail_html = @fread($handle, filesize($filename));				
					//print_r($content); exit;
					if(!empty($content))
						{							
							$description = $content["s_content"];
							$description = str_replace("[name]",$info['s_name'],$description);	
							$description = str_replace("[username]",$info['s_username'],$description);	
							$description = str_replace("[email]",$info['s_email'],$description);		
							$description = str_replace("[subject]",$info['s_subject'],$description); 
							$description = str_replace("[content]",$info['s_msg'],$description);
							$description = str_replace("[site url]",base_url(),$description);	
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
                    
                    $this->email->from($info['s_email']);					
                    $this->email->to($site_admin_email);
                    
                    $this->email->subject('::: Contact us mail :::');
                    $this->email->message($mail_html);
					//echo "<br>DESC".$description;	exit;	
					
                    if(SITE_FOR_LIVE)///For live site
					{
						
						$i_newid = $this->email->send();
						
					}
					else{
						$i_newid = TRUE;				
					}
                    /// Mailing code...[end]
					if($i_newid)////saved successfully
                    {
                        set_success_msg($this->cls_msg["contact_send_succ"]);
                        redirect('home/contact_us_success');
                    }
                    else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["contact_send_err"]);
                    }
                    
                }
			}            
			
			/*$s_where = " WHERE c.i_cms_type_id=2 And c.i_status=1 ";
			
			$data_exist = $this->mod->fetch_multi($s_where.' And c.i_lang_id="'.$this->i_default_language.'"');
			if(!empty($data_exist))
			{
				$this->data["info"] = $data_exist;
			}
			else
			{
				$this->data['info'] = $this->mod->fetch_multi($s_where.' And c.i_lang_id="'.$this->i_main_default_language.'"');
			}*/
			
			$this->data['breadcrumb'] = array(t('Contact Us')=>'');
			
			$this->s_meta_type = 'contact_us';
			
			//$this->data['info'] = $this->mod->fetch_multi($s_where);
			
			/*$title = explode(' ',$this->data['info'][0]["s_title"],2);
			$this->data["pre"] = $title[0];
			$this->data["next"] = $title[1];*/
			
			
			
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	 public function contact_us_success()
    {
        try
        {			
			$this->data['breadcrumb'] = array(t('Thank You')=>'');
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	
	//abuse report
	
	public function abuse_report()
    {
        try
        {
			$this->s_meta_type = 'abuse_report';
			if(count($_POST)>0)
			{
                $this->load->model('auto_mail_model','mod_auto');
                $info = array();
                
                $this->form_validation->set_rules('txt_fname', t('Firstame'), 'trim|required|xss_clean');
				 $this->form_validation->set_rules('txt_lname', t('Lastame'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('txt_email', t('Email'), 'trim|required|valid_email');
                $this->form_validation->set_rules('txt_msg', t('Comments'), 'required');
                $this->form_validation->set_rules('txt_contact', t('Contact No.'), 'trim|xss_clean');
                
                if ($this->form_validation->run() != FALSE)
                {
                    $info['s_fname'] 	= htmlentities($this->input->post('txt_fname'), ENT_QUOTES, 'utf-8');
					$info['s_lname'] 	= htmlentities($this->input->post('txt_lname'), ENT_QUOTES, 'utf-8');
                    $info['s_email'] 	= htmlentities($this->input->post('txt_email'), ENT_QUOTES, 'utf-8');
                    $info['s_msg'] 		= htmlentities($this->input->post('txt_msg'), ENT_QUOTES, 'utf-8');
					$info['s_contact'] 	= htmlentities($this->input->post('txt_contact'), ENT_QUOTES, 'utf-8');
                    
					
					$content = $this->mod_auto->fetch_contact_us_content('abuse_report','general');
					$filename = $this->config->item('EMAILBODYHTML')."common.html";
				   	$handle = @fopen($filename, "r");
				   	$mail_html = @fread($handle, filesize($filename));					
					//print_r($content); exit;
					if(!empty($content))
						{							
							$description = $content["s_content"];
							$description = str_replace("[firstname]",$info['s_fname'],$description);	
							$description = str_replace("[lastname]",$info['s_lname'],$description);	
							$description = str_replace("[email]",$info['s_email'],$description);		
							$description = str_replace("[contact]",$info['s_contact'],$description); 
							$description = str_replace("[content]",$info['s_msg'],$description);
							$description = str_replace("[site url]",base_url(),$description);	
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
                    
                    $this->email->from($info['s_email']);					
                    $this->email->to($site_admin_email);
                    
                    $this->email->subject('::: Abuse Report mail :::');
                    $this->email->message($mail_html);
					//echo "<br>DESC".$description;	exit;	
					
                    if(SITE_FOR_LIVE)///For live site
					{
						
						$i_newid = $this->email->send();
						
					}
					else{
						$i_newid = TRUE;				
					}
                    /// Mailing code...[end]
					if($i_newid)////saved successfully
                    {
                        set_success_msg($this->cls_msg["abuse_send_succ"]);
                        redirect('home/abuse_report_success');
                    }
                    else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["abuse_send_err"]);
                    }
                    
                }
			}            
			
			/*$s_where = " WHERE c.i_cms_type_id=7 And c.i_status=1 ";			
			
			$data_exist = $this->mod->fetch_multi($s_where.' And c.i_lang_id="'.$this->i_default_language.'"');
			if(!empty($data_exist))
			{
			$this->data["info"] = $data_exist;
			}
			else
			{
				$this->data['info'] = $this->mod->fetch_multi($s_where.' And c.i_lang_id="'.$this->i_main_default_language.'"');
			}*/
			
			$this->data['breadcrumb'] = array(t('Abuse Report')=>'');
			
			//$this->data['info'] = $this->mod->fetch_multi($s_where);
			
			/*$title = explode(' ',$this->data['info'][0]["s_title"],2);
			$this->data["pre"] = $title[0];
			$this->data["next"] = $title[1];*/
			
			
			
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	 public function abuse_report_success()
    {
        try
        {			
			$this->data['breadcrumb'] = array(t('Thank You')=>'');
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
	
	
	
	/*** ajax call to get city dropdown ***/
	
	 function ajax_change_city_option()
    {
		$this->load->model('city_model');
        $state_id  = decrypt($this->input->post('state_id'));
		$parent_city_option = $this->city_model->get_city_selectlist($state_id);
        echo '<select id="opt_city" name="opt_city" style="width:192px;" onchange="call_ajax_get_zipcode(\'ajax_change_zipcode_option\',this.value,'.$state_id.',\'parent_zip\');">
              <option value="">Select city</option>'.$parent_city_option.'</select>';
    }
	
	 function ajax_change_city_option_auto_complete()
    {
		$this->load->model('city_model');
        $state_id  = decrypt($this->input->post('state_id'));
		$parent_city_option = $this->city_model->get_city_selectlist($state_id);
        echo '<select id="opt_city" name="opt_city" style="width:192px;" onchange="call_ajax_get_zipcode_list(\'ajax_change_zipcode_option_auto_complete\',this.value,'.$state_id.',\'parent_zip\');">
              <option value="">Select city</option>'.$parent_city_option.'</select>';
    }	
	
	function ajax_change_zipcode_option_auto_complete()
	{
		/*$str = "[ ";
		$this->load->model('zipcode_model');
		$state_id = $this->input->post('state_id');
		$city_id  = decrypt($this->input->post('city_id'));
		$s_where = " WHERE n.city_id={$city_id} ";
		$parent_zip_option = $this->zipcode_model->fetch_multi($s_where);
		if($parent_zip_option)
		{
			foreach($parent_zip_option as $val)
			{
				$str .= '"'.$val['postal_code'].'",';
			}
		}
		$str .=" ]";
		echo $str;*/
	}
		
	
	/*** ajax call to get zip code dropdown ***/
	function ajax_change_zipcode_option()
	{
		$this->load->model('city_model');
		$state_id = $this->input->post('state_id');
		$city_id  = decrypt($this->input->post('city_id'));
		$parent_zip_option = $this->city_model->get_zip_selectlist($state_id,$city_id);
		echo '<select id="opt_zip" name="opt_zip" style="width:192px;" >
              <option value="">Select Postalcode</option>'.$parent_zip_option.'</select>';		
	}
	
	
	function ajax_autocomplete_zipcode($city_id='', $state_id='', $postal_code='')
	{
		if(!$city_id || !$state_id || $postal_code='')
		{
			return false;
		}
		
	
		$city_id  = decrypt($city_id);
		$state_id  = decrypt($state_id);
	    $postal_code = $this->uri->segment(5);
		//echo '===='.$postal_code;
		$this->load->model('zipcode_model');
		$s_where = " WHERE n.city_id={$city_id} AND n.state_id={$state_id} AND n.postal_code LIKE '%{$postal_code}%'";
		//echo $this->db->last_query();
		$zip_list = $this->zipcode_model->fetch_multi($s_where);
		if($zip_list)
		{
			foreach($zip_list as $val)
			{
				echo '<div class="autocomplete_link" onclick="business_fill(\''. htmlspecialchars ($val['postal_code']).'^'.encrypt($val['id']).'\');">'.$val['postal_code'].'</div>';
			}
		}
		
	
		
	}
	/* to show news details*/
	function news($news_id)
	{
		try
		{
			$this->i_menu_id = 1;
			$this->data['breadcrumb'] = array(t('News')=>'');
			$news_id =  decrypt($news_id);
			$this->load->model('news_model');
		    $this->data['news_details'] =  $this->news_model->fetch_this($news_id);
			$this->render();
					
			
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	}
	
	/* to show all testimonial list*/
	function testimonial()
	{
		try
		{
			//$this->i_menu_id = 1;
			$this->data['breadcrumb'] = array(t('Testimonial')=>'');			
			$this->load->model('testimonial_model');
			$s_where = " WHERE i_status=2 AND i_del_status =1"; 
			$start = ($this->uri->segment($this->i_uri_seg)) ? $this->uri->segment($this->i_uri_seg) : 0;
			$limit	= $this->i_fe_page_limit;
		    $this->data['testimonial_list'] =  $this->testimonial_model->fetch_multi($s_where,intval($start), $limit);
			$i_total_no = $this->testimonial_model->gettotal_info($s_where);
			$s_pageurl = base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
			$i_uri_segment = $this->i_fe_uri_segment;
			$this->data['pagination'] = $this->get_fe_pagination($s_pageurl,$i_total_no,$limit,$i_uri_segment); 
			$this->render();
			unset($s_where,$start,$limit,$i_total_no,$s_pageurl,$i_uri_segment);
			
			
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	}	
	
	/* to show testimonial details*/
	function testimonial_details($testimonial_id)
	{
		try
		{
			//$this->i_menu_id = 1;
			$this->data['breadcrumb'] = array(t('Testimonial')=>base_url().'home/testimonial',t('Testimonial Details')=>'');
			$testimonial_id =  decrypt($testimonial_id);
			$this->load->model('testimonial_model');
		    $this->data['testimonial_details'] =  $this->testimonial_model->fetch_this($testimonial_id);
			
			//print_r($this->data['testimonial_details']);
			$this->render();
			
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	}		
		
	/* to save newsletter*/
	function save_newsletter()
	{
		try
		{
			$this->i_menu_id = 1;
			$this->load->model('manage_buyers_model');
			$info = array();
			$info['i_inform_news'] = 1;
			$info['i_role'] = 4;
			$info['s_name'] = trim($this->input->post('txt_name'));
			$info['s_email'] = trim($this->input->post('txt_email'));
			$s_where = " WHERE s_email='{$info['s_email']}'";
			$tot = $this->manage_buyers_model->gettotal_newsletter_info($s_where);
			if($tot)
			{
				$this->session->set_userdata(array('message'=>$this->cls_msg["subcribe_duplicate_err"],'message_type'=>'err'));
			}
			else
			{
				$i_newid = $this->manage_buyers_model->insert_newsletter_subscription($info);
				if($i_newid)////saved successfully
				{
					$this->session->set_userdata(array('message'=>$this->cls_msg["subcribe_succ"],'message_type'=>'succ'));
				}
				else///Not saved, show the form again
				{
					$this->session->set_userdata(array('message'=>$this->cls_msg["subcribe_err"],'message_type'=>'err'));
				}
			}			
			redirect(base_url().'home/message');
			
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	}	
	
	public function message()
	{
		$this->render();
	}	
		
    public function __destruct()

    {}           

}



/* End of file welcome.php */

/* Location: ./system/application/controllers/welcome.php */

