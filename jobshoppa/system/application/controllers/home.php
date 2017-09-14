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

		  $this->cls_msg["no_result"]="No information found about latest news.";
		  
		  $this->cls_msg["contact_send_err"]="Contact us mail not delivered.";
          $this->cls_msg["contact_send_succ"]="Contact us mail delivered successfully.";
		  
		  $this->cls_msg["abuse_send_err"]="Abuse report mail not delivered.";
          $this->cls_msg["abuse_send_succ"]="Abuse report mail delivered successfully.";
          
          $this->cls_msg["customer_support_send_err"]="customer support mail not delivered.";
          $this->cls_msg["customer_support_send_succ"]="Customer support mail delivered successfully.";
		  
		  $this->cls_msg["subcribe_succ"] = "Newletter subscribed successfully";
		  $this->cls_msg["subcribe_err"] = "Newletter not subscribed successfully";
		  $this->cls_msg["subcribe_duplicate_err"] = "Email address already subscribed.";
          $this->cls_msg["save_comment_err"]="Comment failed to save.";
          $this->cls_msg["save_comment_succ"]="Comment saved successfully.";
		  
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
			
		    /**fetch job category **/
		    $this->load->model('category_model');
			
		    $s_where = " WHERE c.s_category_type='job' and c.i_status=1 "; 
		    $this->data['category_list'] =  $this->category_model->fetch_multi($s_where);
			
			$this->data['top_category_list'] =  $this->category_model->fetch_top_category($s_where);
			//pr($this->data['top_category_list']);
		    /**end fetch job category **/
			
		  
		    /**###########   fetch banner images  ###############**/
		   
		    $this->load->model('banner_model');
		    $s_where = " WHERE i_status=1"; 
		    $this->data['banner_list'] =  $this->banner_model->fetch_multi($s_where,0,6);
			//pr($this->data['banner_list']);
			$this->data['thumbPath'] = $this->config->item('banner_image_thumb_path');
		    $this->data['tot_banner'] = count($this->data['banner_list']);
			
		   /**###########   end fetch banner images  ###############**/	
		   
		   
		    /* fetch safety content */
		    $s_where = " WHERE c.i_cms_type_id=9 And c.i_status=1 ";			
			$this->data['safety'] = $this->mod->fetch_multi($s_where,0,1);
			//print_r($this->data['safety']);
		    /* fetch safety content */
		   
		    /**fetch testimonial **/
		    $this->load->model('testimonial_model');
		    $s_where = " WHERE i_status=2 AND i_del_status =1"; 
		    $this->data['testimonial_list'] =  $this->testimonial_model->fetch_multi($s_where);
			//pr($this->data['testimonial_list']);
			
			/*****Featured Tradesman******/
			$this->load->model('Tradesman_model',"mod_trades");
		    $s_where = " WHERE i_is_active=1 "; 
			$orderby = " td.i_jobs_won DESC,td.i_feedback_received DESC";
			$this->data['tradesman_list'] = $this->mod_trades->fetch_home_page_featured($s_where,$orderby,0,5);
			//print_r($this->data['tradesman_list']);exit;
			$this->data['image_path'] = $this->config->item("user_profile_image_thumb_path");
			$this->data['image_up_path'] = $this->config->item("user_profile_image_thumb_upload_path");
			//pr($this->data['tradesman_list']);
			/***** End Featured Tradesman******/
			
		    /**completed jobs**/
		    $this->load->model('job_model');
		    $s_where = " WHERE n.i_status=6 AND n.i_is_deleted!=1";                  
		    $this->data['complete_job_list'] =  $this->job_model->fetch_home_page_multi($s_where,0,4);
			
			$s_where = " WHERE n.i_status=1 AND n.i_is_deleted!=1";                  
		    $this->data['job_opportunity_list'] =  $this->job_model->fetch_multi($s_where,0,4);
			
			//pr($this->data['loggedin']);
			/** end completed jobs **/
						

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
                case "safety":
                    $i_cms_type_id = 9;
                    $this->s_meta_type = 'safety';  
                    break;		
				default :	
					$i_cms_type_id = 1;
					$this->s_meta_type = 'about_us';
			}
			
			$s_where = " WHERE c.i_cms_type_id={$i_cms_type_id} And c.i_status=1 ";
			$data_exist = $this->mod->fetch_multi($s_where);
			if(!empty($data_exist))
			{
				$this->data["info"] = $data_exist;
			}
			else
			{
				$this->data['info'] = $this->mod->fetch_multi($s_where);
			}
			
			$this->data['breadcrumb'] = array($this->data['info'][0]["s_title"]=>'');
			
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
			
			$s_wh_cat = " WHERE c.s_category_type='help'"; 
				
			
			// fetch the question answer
			$s_lang_query = " And n.i_status=1 ";

			
			$this->data['breadcrumb'] = array('Help'=>'');			
			
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
				
			$s_type = decrypt($type);			
			
			$s_where = " WHERE n.i_status=1 ";
			
			//$this->data['check_data_exist'] = $this->mod_how_it_works_tradesman->fetch_multi($s_where.' And n.i_lang_id="'.$this->i_main_default_language.'"');
			
			
			$this->data['breadcrumb'] = array('How it works'=>'');
			
			if($s_type==2)
			{	
			$this->s_meta_type = 'how_it_works_professional';			
			$this->load->model('how_it_works_tradesman_model','mod_how_it_works_tradesman');
			$this->data['info'] = $this->mod_how_it_works_tradesman->fetch_multi($s_where);
			$this->render('home/how_it_works_tradesman');
			}
			if($s_type==1)
			{		
			$this->s_meta_type = 'how_it_works_client';	
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
			$s_wh_cat = " WHERE c.s_category_type='".buyer_faq."' ORDER BY c.id ";
			}		
			
			if($s_type==2)
			{
			$s_wh_cat = " WHERE c.s_category_type='".tradesman_faq."' ORDER BY c.id ";
			}			
			
			// fetch the question answer
			$s_lang_query = " And n.i_status=1 ";
			
			
			
			
			if($s_type==1)		// buyers faq
			{
			$this->s_meta_type = 'faq_client';					
			$this->data['breadcrumb'] = array('Client\'s Questions'=>'');			
			$this->data['category']	=	$this->mod_cat->fetch_buyer_faq_content($s_wh_cat,'','',$s_lang_query);
			
			$this->render('home/job_poster_questions');
			}
			
			if($s_type==2)		// tradesman faq
			{
			$this->s_meta_type = 'faq_professional';			
			$this->data['breadcrumb'] = array('Prefessional\'s Questions'=>'');				
			$this->data['category']	=	$this->mod_cat->fetch_tradesman_faq_content($s_wh_cat,'','',$s_lang_query);
           

           // exit;
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
    
    
    /* Customer support */
    public function customer_support()
    {
        try
        {
            //$this->load->model('help_model','mod_help');
            
            
            $this->load->model('customer_support_model','mod_cs');
            $s_where=" WHERE cs.i_del_status != 2 ";
            $s_order=" ORDER BY cs.i_question_cat ASC ";
            

            $info   =    $this->mod_cs->fetch_multi($s_where,$s_order,'','');

            $total_record=count($info);
            $about_professional['qus']=array();
            $about_professional['qus_ans']=array();
            $general['qus']=array();
            $general['qus_ans']=array();
            $posting_jobs['qus']=array();
            $posting_jobs['qus_ans']=array();
            for($i=0;$i<$total_record;$i++)
            {
                if($info[$i]['i_question_cat']==1)
                {
                    $about_professional['qus'][]      = $info[$i]['s_question'];      
                    $about_professional['qus_ans'][]  = $info[$i]['s_desc_full'];
                }
                else if($info[$i]['i_question_cat']==2)
                {
                    $general['qus'][]     = $info[$i]['s_question'];      
                    $general['qus_ans'][]  = $info[$i]['s_desc_full'];
                    
                }
                else if($info[$i]['i_question_cat']==3)
                {
                    $posting_jobs['qus'][]      = $info[$i]['s_question'];      
                    $posting_jobs['qus_ans'][]  = $info[$i]['s_desc_full'];
                    
                }
            }
            $this->data['category']['About professional']= $about_professional;
            $this->data['category']['General']= $general;
            $this->data['category']['Posting job']= $posting_jobs;  

            $this->s_meta_type = 'customer_support';
            if(count($_POST)>0)
            {
                
               
                
                $this->load->model('auto_mail_model','mod_auto');
                $info = array();
                /////////////////////Validation Started//////////////////////////
                $this->form_validation->set_rules('txt_subject', 'Subject', 'trim|xss_clean');  
                $this->form_validation->set_rules('txt_fname', 'Firstame', 'trim|required|xss_clean');
                $this->form_validation->set_rules('txt_lname', 'Lastame', 'trim|required|xss_clean');
                $this->form_validation->set_rules('txt_email', 'Email', 'trim|required|valid_email');
                $this->form_validation->set_rules('txt_msg', 'Comments', 'required');
                //$this->form_validation->set_rules('txt_contact', 'Contact No.', 'trim|xss_clean');

                if ($this->form_validation->run() != FALSE )
                {
                    $info['s_fname']     = htmlentities($this->input->post('txt_fname'), ENT_QUOTES, 'utf-8');
                    $info['s_lname']     = htmlentities($this->input->post('txt_lname'), ENT_QUOTES, 'utf-8');
                    $info['s_email']     = htmlentities($this->input->post('txt_email'), ENT_QUOTES, 'utf-8');
                    $info['s_msg']       = htmlentities($this->input->post('txt_msg'), ENT_QUOTES, 'utf-8');
                    $info['s_contact']   = htmlentities($this->input->post('txt_contact'), ENT_QUOTES, 'utf-8');
                    $info['s_subject']  = htmlentities($this->input->post('txt_subject'), ENT_QUOTES, 'utf-8');
                    
                    //$content = $this->mod_auto->fetch_contact_us_content('abuse_report','general'); 
                    $content = $this->mod_auto->fetch_contact_us_content('customer_support','general');    
					
					$mail_subject = $content['s_subject'];
					
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
                            $description = str_replace("%EMAIL_DISCLAMER%","",$description);
                            $description = str_replace("[subject]",$info['s_subject'],$description);  
							$description = str_replace("[site_url]",base_url(),$description);                            
                        }
                    unset($content);
					
					$mail_html = str_replace("[site url]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
                        
                    //echo "<br>DESC".$description;    exit;    
                    
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
                    
                    $this->email->subject($mail_subject);
                    $this->email->message($mail_html);
                    //echo "<br>DESC".$description;    exit;    
                    
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
                        set_success_msg($this->cls_msg["customer_support_send_succ"]);
                        redirect('home/customer_support_success');
                    }
                    else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["customer_support_send_err"]);
                    }
                    
                }
            }
            $this->data['breadcrumb'] = array('Customer Support'=>''); 
			
			$s_where = " WHERE c.i_cms_type_id=10 And c.i_status=1 "; 
			
			$this->data['contents'] = $this->mod->fetch_multi($s_where,0,1);

            $this->render('home/customer_support');

            //$this->render();
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
    
    
    /* end customer_support*/
     public function customer_support_success()
    {
        try
        {            
            $this->data['breadcrumb'] = array('Thank You'=>'');
            $this->render();
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	
	public function contact_us()
    {
        try
        {
			$this->s_meta_type = 'contact_us';
			if(count($_POST)>0)
			{
                
                $posted=array();
                $posted["captcha_challenge"]=    trim($this->input->post("recaptcha_challenge_field"));
                $posted["captcha_response"]=    trim($this->input->post("recaptcha_response_field"));

                $this->load->model('auto_mail_model','mod_auto');
                $info = array();
                /////////////////////Validation Started//////////////////////////
                $this->form_validation->set_rules('txt_name', 'Name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('txt_email', 'Email', 'trim|required|valid_email');
                $this->form_validation->set_rules('txt_msg', 'Message', 'required');
                $this->form_validation->set_rules('txt_subject', 'Subject', 'trim|xss_clean');
                $this->form_validation->set_rules('recaptcha_response_field', 'provide correct security code', 'required'); 
                
                /////////////////////Captcha matching/////////////////////////
                include BASEPATH.'application/libraries/recaptchaLib/recaptchalib'.EXT;
                $RECAPTCHA_CHALLENGE       =    $posted["captcha_challenge"];
                $RECAPTCHA_RESPONSE        =    $posted["captcha_response"];
                $response = recaptcha_check_answer (
                            $this->config->item('recaptcha_private_key'),
                            $_SERVER["REMOTE_ADDR"],
                            $RECAPTCHA_CHALLENGE,
                            $RECAPTCHA_RESPONSE
                    ); 
                
                if ($this->form_validation->run() != FALSE || ($response->is_valid))
                {
                    $info['s_name'] 	= htmlentities($this->input->post('txt_name'), ENT_QUOTES, 'utf-8');
					$info['s_username'] = htmlentities($this->input->post('txt_username'), ENT_QUOTES, 'utf-8');
                    $info['s_email'] 	= htmlentities($this->input->post('txt_email'), ENT_QUOTES, 'utf-8');
                    $info['s_msg'] 		= htmlentities($this->input->post('txt_msg'), ENT_QUOTES, 'utf-8');
					$info['s_subject'] 	= htmlentities($this->input->post('txt_subject'), ENT_QUOTES, 'utf-8');
                    
					
					$content = $this->mod_auto->fetch_contact_us_content('contact_us','general');	
					$mail_subject = $content['s_subject'];
					
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
							$description = str_replace("[site_url]",base_url(),$description);
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
                    
                    $this->email->subject($mail_subject);
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
			
			$this->data['breadcrumb'] = array('Contact Us'=>'');
			
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
			$this->data['breadcrumb'] = array('Thank You'=>'');
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
                $posted=array();
                $posted["captcha_challenge"]=    trim($this->input->post("recaptcha_challenge_field"));
                $posted["captcha_response"]=    trim($this->input->post("recaptcha_response_field"));
                
                $this->load->model('auto_mail_model','mod_auto');
                $info = array();
                /////////////////////Validation Started//////////////////////////
                $this->form_validation->set_rules('txt_subject', 'Subject', 'trim|xss_clean');
                $this->form_validation->set_rules('txt_fname', 'Firstame', 'trim|required|xss_clean');
				$this->form_validation->set_rules('txt_lname', 'Lastame', 'trim|required|xss_clean');
                $this->form_validation->set_rules('txt_email', 'Email', 'trim|required|valid_email');
                $this->form_validation->set_rules('txt_msg', 'Comments', 'required');
                //$this->form_validation->set_rules('txt_contact', 'Contact No.', 'trim|xss_clean');
                $this->form_validation->set_rules('recaptcha_response_field', 'provide correct security code', 'required');  
                
                /////////////////////Captcha matching/////////////////////////
                include BASEPATH.'application/libraries/recaptchaLib/recaptchalib'.EXT;
                $RECAPTCHA_CHALLENGE       =    $posted["captcha_challenge"];
                $RECAPTCHA_RESPONSE        =    $posted["captcha_response"];
                $response = recaptcha_check_answer (
                            $this->config->item('recaptcha_private_key'),
                            $_SERVER["REMOTE_ADDR"],
                            $RECAPTCHA_CHALLENGE,
                            $RECAPTCHA_RESPONSE
                    );
                
                if ($this->form_validation->run() != FALSE || ($response->is_valid))
                {
                    $info['s_fname'] 	= htmlentities($this->input->post('txt_fname'), ENT_QUOTES, 'utf-8');
					$info['s_lname'] 	= htmlentities($this->input->post('txt_lname'), ENT_QUOTES, 'utf-8');
                    $info['s_email'] 	= htmlentities($this->input->post('txt_email'), ENT_QUOTES, 'utf-8');
                    $info['s_msg'] 		= htmlentities($this->input->post('txt_msg'), ENT_QUOTES, 'utf-8');
					$info['s_contact'] 	= htmlentities($this->input->post('txt_contact'), ENT_QUOTES, 'utf-8');
                        
                    
					
					$content = $this->mod_auto->fetch_contact_us_content('abuse_report','general');		
					
					$mail_subject = $content['s_subject'];
					
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
							$description = str_replace("[site_url]",base_url(),$description);
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
                    
                    
                    $this->email->subject($mail_subject);
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
			
			$this->data['breadcrumb'] = array('Abuse Report'=>'');
			
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
			$this->data['breadcrumb'] = array('Thank You'=>'');
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
		$zip_list = $this->zipcode_model->fetch_multi($s_where);
		if($zip_list)
		{
			foreach($zip_list as $val)
			{
				echo '<div class="autocomplete_link" onclick="business_fill(\''. htmlspecialchars ($val['postal_code']).'^'.encrypt($val['id']).'\');">'.$val['postal_code'].'</div>';
			}
		}
		
	
		
	}
	
	
	
	function ajax_autocomplete_city_state($city='')
	{
		if(!$city)
		{
			return false;
		}
		
	
		//$city  = $this->input->post('opt_city');;
		
		//echo '===='.$postal_code;
		$this->load->model('city_model');
		//$s_where = " WHERE n.city_id={$city_id} AND n.state_id={$state_id} AND n.postal_code LIKE '%{$postal_code}%'";
		$s_where = " WHERE  c.city LIKE '%{$city}%'";
		$city_list = $this->city_model->fetch_multi($s_where);
		//pr($city_list); exit;
		if($city_list)
		{
			foreach($city_list as $val)
			{
				echo '<div class="autocomplete_link" onclick="business_fill(\''. htmlspecialchars ($val['city'].' , '.$val['state']).'^'.encrypt($val['id']).'\');">'.$val['city'].' , '.$val['state'].'</div>';
			}
		}
		
	
		
	}
	
	
	/* to show news details*/
	function news($news_id)
	{
		try
		{
			$this->i_menu_id = 1;
			$this->data['breadcrumb'] = array('News'=>'');
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
    
    /////////////To show all the blog posted///////////
    function blog()
    {
        try
        {

            $this->data['breadcrumb'] = array('Blog'=>'');

            $this->load->model('manage_blog_model','mod_blog');
			$s_where = " WHERE n.i_status=1 ";
            $this->data['blog_details'] =  $this->mod_blog->fetch_multi($s_where);
            //pr($this->data['blog_details']) ;

            $this->render('home/blog');
                    
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
    }////////End of blog
    
     /////////////To show a the blog /////////// 
     function blog_details($param)
    {
        try
        {
            $id=decrypt($param);
            $this->data['breadcrumb'] = array('Blog'=>'');

            $this->load->model('manage_blog_model','mod_blog');
            $this->data['blog_details'] =  $this->mod_blog->fetch_this($id);
            //pr($this->data['blog_details']) ;

            $this->render('home/blog_details');
            unset($id,$param);        
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
    }///////End of blog_details
    
    
    
    //////////////To show a blog with comments////////////
    function blog_comment($param)
    {
        try
        {
            $id=decrypt($param);
            $this->data['breadcrumb'] = array('Blog Comment'=>'');
            $this->session->set_userdata('blog_id',$param);
            ob_start();
            $this->ajax_blog_comment();
            $comment_contents = ob_get_contents();
            ob_end_clean();

            $this->data['comment_contents'] = $comment_contents;
            
            
            $this->load->model('manage_blog_model','mod_blog');
             
            $this->data['blog_details'] =  $this->mod_blog->fetch_this($id);
            //pr($this->data['blog_details']) ;
            
             //pr($this->data['all_comments']) ;
            // exit;
            if(count($_POST)>0)
            {

               

                $info = array();
                /////////////////////Validation Started//////////////////////////
                $this->form_validation->set_rules('txt_name', 'Name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('txt_email', 'Email', 'trim|required|valid_email');
                $this->form_validation->set_rules('txt_msg', 'Message', 'required');

                
                if ($this->form_validation->run() != FALSE )
                {
                    $info['i_blog_id']      =   $id;
                    $info['s_name']         =   trim($this->input->post('txt_name'));
                    $info['s_email']        =   trim($this->input->post('txt_email'));
                    $info['s_comment']      =   trim($this->input->post('txt_msg'));
                    $info["i_status"]       =   1;
                    $info["dt_entry_date"]  =   strtotime(date("Y-m-d H:i:s"));
                    
                    $i_newid = $this->mod_come->add_info($info);
                    if($i_newid)//save successfully. 
                    {
                        set_success_msg($this->cls_msg["save_comment_succ"]); 
                        
                        redirect($this->pathtoclass.'blog_comment/'.$param); 
                    }   
                   else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["save_comment_err"]);
                    }
                    
                }
            }
            $this->render('home/blog_comment');
            unset($id,$param,$s_where);        
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
    }/////////End of blog_comment
    
    
     function ajax_blog_comment($start=0)
    {
        try
        {
        $this->load->model('blog_comment_model','mod_come');
        
        $s_where    =   " WHERE bc.i_blog_id=".decrypt($this->session->userdata('blog_id'))." ";
        $limit    = $this->i_fe_page_limit;            
        $this->data['all_comments'] =  $this->mod_come->fetch_multi($s_where,intval($start),$limit); 
        $total_rows = $this->mod_come->gettotal_info($s_where);    
        
        
        //$s_where = " WHERE n.i_buyer_user_id = {$this->user_id} AND n.i_is_deleted!=1 AND n.i_status=1 AND cat_c.i_lang_id =".$this->i_default_language; 

        //$limit    = $this->i_fe_page_limit;   
            
        //$this->data['job_list']    = $this->job_model->fetch_multi($s_where,intval($start),$limit);        

        //$total_rows = $this->job_model->gettotal_info($s_where);    

        $this->load->library('jquery_pagination');
        $config['base_url'] = base_url().'home/ajax_blog_comment/';
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
    
        $config['div'] = '#comment_only';
        //$config['js_bind'] = "showLoading();";
        //$config['js_rebind'] = "hideLoading();";
        //$config['js_rebind'] = "alert(data);";

        $this->jquery_pagination->initialize($config);
        //$this->data['page_links'] = preg_replace('/<delete>.*?<\/delete>/s','',$this->jquery_pagination->create_links());
        $this->data['page_links'] = $this->jquery_pagination->create_links();
        $this->data['total_rows'] = $total_rows;
        //$this->data['current_page'] = $page;
        
        $this->load->view('fe/home/ajax_blog_comment.tpl.php',$this->data);
        }
         catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }//////////End of  Ajax Blog Comment
    
    
	
	/* to show all testimonial list*/
	function testimonial()
	{
		try
		{
			//$this->i_menu_id = 1;
			$this->data['breadcrumb'] = array('Testimonial'=>'');			
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
			$this->data['breadcrumb'] = array('Testimonial'=>base_url().'home/testimonial','Testimonial Details'=>'');
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
	
	
	/* to show safety details */	
	function safety_details()
	{
		try
		{
			//$this->i_menu_id = 1;
			$this->data['breadcrumb'] = array('Safety'=>'');
			$this->load->model('content_model');
			$s_wh_safety = " WHERE c.i_cms_type_id=9 And c.i_status=1 ";	
		    $this->data['safety_details'] =  $this->content_model->fetch_multi($s_wh_safety,0,1);
			
			//print_r($this->data['safety_details']);
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
			$s_where = " WHERE n.s_email='".$info['s_email']."' ";
			$tot = $this->manage_buyers_model->gettotal_newsletter_info($s_where);
			
			if($tot)
			{
				$this->session->set_userdata(array('message'=>$this->cls_msg["subcribe_duplicate_err"],'message_type'=>'err'));
				//redirect(base_url().'home/message');
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
	
	public function sign_up_lightbox()
	{
		try
		{
			$this->load->view('fe/home/sign_up_lightbox.tpl.php',$this->data);
			
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
		
	}	
		
		
	function test()
	{
		exec("/usr/bin/text2wave /home/acumencs/public_html/jobshoppa/uploaded/job/wasim.txt -o /home/acumencs/public_html/jobshoppa/uploaded/job/aa.mp3", $output);
		var_dump($output);
		//echo "It's such a beautiful day! Why are you in front of the computer?" | text2wave -scale 50 -o beautiful_day.wav
	}	
		
    public function __destruct()

    {}           

}



/* End of file welcome.php */

/* Location: ./system/application/controllers/welcome.php */

