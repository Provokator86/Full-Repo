<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 23 April 2012
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

		  $this->cls_msg["no_result"]				= addslashes(t("No information found about latest news."));		  
		  $this->cls_msg["contact_send_err"]		= addslashes(t("Contact us mail not delivered."));
          $this->cls_msg["contact_send_succ"]		= addslashes(t("Contact us mail delivered successfully."));		  
		  $this->cls_msg["abuse_send_err"]			= addslashes(t("Abuse report mail not delivered."));
          $this->cls_msg["abuse_send_succ"]			= addslashes(t("Abuse report mail delivered successfully."));		  
		  $this->cls_msg["subcribe_succ"] 			= addslashes(t("Newletter subscribed successfully"));
		  $this->cls_msg["subcribe_err"] 			= addslashes(t("Newletter not subscribed successfully"));
		  $this->cls_msg["subcribe_duplicate_err"] 	= addslashes(t("Email address already subscribed."));
		  
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  $this->load->model('cms_model','mod');
		  $this->load->model('job_model','mod_job');
		  
		  //redirect(base_url().'admin/home/');
		  
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
			
			/* fetch what we do content */
			$s_where 	= " WHERE c.i_cms_type_id= 8 And c.i_status=1 ";
			$this->data['what_we_do'] = $this->mod->fetch_multi($s_where);
			
		    /**fetch job category **/
		    $this->load->model('category_model');
		    $s_where = " WHERE i_status=1 "; 
		    $this->data['category_list'] =  $this->category_model->fetch_multi($s_where,0,18,true);
			$this->data['category_icon_path'] = $this->config->item("category_icon_thumb_path");
		    /**end fetch job category **/
		  
		    /**fetch news **/
		    $this->load->model('news_model');
		    $s_where = " WHERE i_status=1"; 
		    $this->data['news_list'] =  $this->news_model->fetch_multi($s_where);
		    $this->data['tot_news']  = count($this->data['news_list']);
			
		   /**end fetch news **/	
		   
		    /**fetch testimonial **/
		    $this->load->model('testimonial_model');
		    $s_where = " WHERE i_status=2 AND i_del_status =1"; 
		    $this->data['testimonial_list'] =  $this->testimonial_model->fetch_multi($s_where);
			//pr($this->data['testimonial_list']);
			/*****Featured Tradesman******/
			$this->load->model('Tradesman_model',"mod_td");
		    $s_where = " WHERE n.i_is_active=1 AND n.i_role = 2 "; 
			$orderby = " td.i_feedback_rating DESC,td.i_jobs_won DESC ";
			//$this->data['tradesman_list'] = $this->mod_td->fetch_featured($s_where,$orderby,0,7);
			$tradesman_list = $this->mod_td->fetch_featured($s_where,$orderby,0,8);
			$total_rows 	= $this->mod_td->gettotal_info($s_where,0,8);
			if($total_rows > 0)
			{
				for($i = 0;$i<count($tradesman_list);$i++) 
				{
					$s_wh = " WHERE n.i_user_id = ".$tradesman_list[$i]['id']." "; 
					$category = $this->mod_td->fetch_all_category($s_wh);
					//pr($category);
					$tradesman_list[$i]['category'] = $category;
				}
			
			}
			$this->data['tradesman_list'] = $tradesman_list;
			//pr($this->data['tradesman_list'],1);
			
			$this->data['image_path']     = $this->config->item("user_profile_image_thumb_path");
			$this->data['image_up_path']  = $this->config->item("user_profile_image_thumb_upload_path");
			
			/***** End Featured Tradesman******/
			
		    /** new jobs added **/
		    $this->load->model('job_model');
		    $s_where = " WHERE n.i_status=1 AND n.i_is_deleted!=1 AND n.i_created_date >= ".strtotime('-15 days')." "; 
		    $this->data['new_jobs'] 	=  $this->mod_job->fetch_multi_completed($s_where,0,8);
			$this->data['icon_path']    = $this->config->item("category_icon_path");
			$this->data['icon_thumb']  	= $this->config->item("category_icon_thumb_path");
			//pr($this->data['new_jobs'],1);
		   /**end fetch completed jobs **/	
		   
		   /* carousel images */
		   $this->load->model('carousel_model');
		   $s_where = " WHERE n.i_status=1 ";
		   $this->data['carousel_image']  =  $this->carousel_model->fetch_multi($s_where);
		   //pr($this->data['carousel_image'],1);
		   $this->data['carousel_path']   = $this->config->item("carousel_image_path");
		   $this->data['carousel_thumb']  = $this->config->item("carousel_image_thumb_path");
		   /* carousel images */
			
		   	   
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
			
			switch($param)
			{
				case "about-us":
					$i_cms_type_id = 1;					
					$this->i_footer_menu = 7;
					$this->s_meta_type = 'about_us';
					break;
				case "careers":
					$i_cms_type_id = 2;
					$this->i_footer_menu = 9;
					$this->s_meta_type = 'careers';
					break;
				case "mission-vision":
					$i_cms_type_id = 3;
					$this->i_footer_menu = 8;
					$this->s_meta_type = 'mission_vision';
					break;
				case "privacy-policy":
					$i_cms_type_id = 4;
					$this->i_footer_menu = 10;
					$this->s_meta_type = 'privacy_policy';
					break;
				case "terms-condition":
					$i_cms_type_id = 5;
					$this->i_footer_menu = 11;
					$this->s_meta_type = 'terms_&_conditions';
					break;	
				case "find-best-tradesman":
					$i_cms_type_id = 6;
					$this->s_meta_type = 'find_best_tradesman';
					break;
				case "find-customer":
					$i_cms_type_id = 7;
					$this->s_meta_type = 'find_customer';
					break;
				case "articles":
					$i_cms_type_id = 9;
					$this->s_meta_type = 'articles';
					break;					
				
			}
			
			$s_where = " WHERE c.i_cms_type_id={$i_cms_type_id} And c.i_status=1 ";
			$data_exist = $this->mod->fetch_multi($s_where);			
			$this->data["info"] = $data_exist;
			//pr($data_exist,1);
			
			$this->data['breadcrumb'] = array(addslashes(t($this->data['info'][0]["s_title"]))=>'');
			
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
	
	
	
	
	public function help()
    {
        try
        {
			$this->i_menu_id = 5;			
			$this->s_meta_type = 'help';
			$this->i_footer_menu = 12;
			
			$this->load->model('help_model','mod_help');
            
            $help_list   =   $this->mod_help->fetch_multi();
         
            $this->data['help_list']    =   $help_list;
            $this->data['arr_cat']      =   $this->db->ARR_CATEGORY['BUYER_FAQ'];
			$this->data['breadcrumb'] = array(t('Help')=>'');	
            unset($help_list);		
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	public function articles()
    {
        try
        {		
			$this->s_meta_type = 'article';		
			$this->data['breadcrumb'] = array(addslashes(t('Articles'))=>'');	
           
		   	ob_start();
			$this->ajax_pagination_article(0,1);
			$contents = ob_get_contents();
			ob_end_clean();
			$article = explode('^',$contents);			
			$this->data['article_list'] 	  = $article[0];
		   	
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	function ajax_pagination_article($start=0,$param=0) 
	{			
		$this->load->model('news_model');
		$s_where = " WHERE i_status=1";
		$limit	= $this->i_fe_page_limit; 
		$this->data['article_list'] =  $this->news_model->fetch_multi($s_where,intval($start),$limit);
		$total_rows = $this->news_model->gettotal_info($s_where);
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'home/ajax_pagination_article/';
		$paging_div = 'article_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		if(empty($param))
			$job_vw = $this->load->view('fe/home/ajax_pagination_article.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/home/ajax_pagination_article.tpl.php',$this->data,TRUE).'^'.$total_rows;
		echo $job_vw;
		/* pagination end */

	
	}
	
	public function article_details($i_id='')
    {
        try
        {		
			$this->s_meta_type = 'article';				
			$this->load->model('news_model');
			if(decrypt($i_id)>0)
			{
			$this->data['article'] =  $this->news_model->fetch_this(decrypt($i_id));
			
			$this->data['breadcrumb'] = array(addslashes(t('Article'))=>base_url().'articles',$this->data['article']['s_title']=>'');
			}
		   
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/* how it works start*/
	
	public function how_it_works($enc_type)
    {
        try
        {	
			
			$this->load->model('how_it_works_model');	
			$s_type = decrypt($enc_type);	
			if($s_type==2)
			{
				$this->s_meta_type = 'how_it_works_tradesman';
				$this->i_footer_menu = 5;
				$this->data['breadcrumb'] = array(addslashes(t('How it works Tradesman'))=>'');
			}	
			if($s_type==1)
			{
				$this->s_meta_type = 'how_it_works_buyer';
				$this->i_footer_menu = 2;
				$this->data['breadcrumb'] = array(addslashes(t('How it works Buyer'))=>'');
			}		
			
			$s_where = " WHERE n.i_status=1 ";			
			
			
			
			if($s_type==2)
			{		
			$s_where .= " AND n.i_user_type = 2 ";
			$this->data['info'] = $this->how_it_works_model->fetch_multi($s_where);
			//pr($this->data['info'],1);
			unset($s_where);
			$this->render('home/how_it_works_tradesman');
			}
			if($s_type==1)
			{	
			$s_where .= " AND n.i_user_type = 1 ";
			$this->data['info'] = $this->how_it_works_model->fetch_multi($s_where);
			//pr($this->data['info'],1);
			unset($s_where);
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
	public function faq($enc_type)
    {
        try
        {
			
			$s_type = decrypt($enc_type);
			
			$this->load->model('faq_model','mod_faq');
			// fetch the question answer
			$s_lang_query = " And n.i_status=1 ";
			
			
		//echo	$s_lang_query ;
			if($s_type==1)		// buyers faq
			{
			    $this->data['breadcrumb'] = array(addslashes(t('Buyer FAQ'))=>'');
			    $this->i_footer_menu = 3;
			    $this->s_meta_type = 'faq_buyer';	
                $s_where      =   ' WHERE n.i_user_type='.$s_type;           
                $faq_list   =   $this->mod_faq->fetch_multi($s_where);
                $this->data['faq_list']    =   $faq_list;
                $this->data['arr_cat']     =   $this->db->ARR_CATEGORY['BUYER_FAQ'];
              
			    $this->render('home/buyer_faq');
			}			
			if($s_type==2)		// tradesman faq
			{
			    $this->data['breadcrumb'] = array(addslashes(t('Tradesman FAQ'))=>'');
				$this->i_footer_menu = 6;
			    $this->s_meta_type = 'faq_tradesman';			
			    $s_where      =   ' WHERE n.i_user_type='.$s_type;           
                $faq_list   =   $this->mod_faq->fetch_multi($s_where);
                $this->data['faq_list']    =   $faq_list;
                $this->data['arr_cat']     =   $this->db->ARR_CATEGORY['TRADESMAN_FAQ'];
			    $this->render('home/tradesman_faq');
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
				
				$this->form_validation->set_rules('txt_name', addslashes(t('your name')), 'trim|required|xss_clean');
                $this->form_validation->set_rules('txt_email', addslashes(t('your email address')), 'trim|required|valid_email');
                $this->form_validation->set_rules('txt_msg', addslashes(t('message')), 'required');
                $this->form_validation->set_rules('txt_subject', addslashes(t('subject')), 'trim|xss_clean');
                
                if ($this->form_validation->run() != FALSE)
                {
                    $info['s_name'] 	= htmlentities($this->input->post('txt_name'), ENT_QUOTES, 'utf-8');
					$info['s_username'] = htmlentities($this->input->post('txt_username'), ENT_QUOTES, 'utf-8');
                    $info['s_email'] 	= htmlentities($this->input->post('txt_email'), ENT_QUOTES, 'utf-8');
                    $info['s_msg'] 		= htmlentities($this->input->post('txt_msg'), ENT_QUOTES, 'utf-8');
					$info['s_subject'] 	= htmlentities($this->input->post('txt_subject'), ENT_QUOTES, 'utf-8');
                    
					
					$content  	= $this->mod_auto->fetch_mail_content('contact_us','general');	
					$filename 	= $this->config->item('EMAILBODYHTML')."common.html";
				   	$handle 	= @fopen($filename, "r");
				   	$mail_html 	= @fread($handle, filesize($filename));
					$s_subject 	= $content['s_subject'];				
					//print_r($content); exit;
					if(!empty($content))
						{							
							$description = $content["s_content"];
							$description = str_replace("[NAME]",$info['s_name'],$description);	
							$description = str_replace("[USERNAME]",$info['s_username'],$description);	
							$description = str_replace("[EMAIL]",$info['s_email'],$description);		
							$description = str_replace("[SUBJECT]",$info['s_subject'],$description); 
							$description = str_replace("[MESSAGE]",$info['s_msg'],$description);						
						}
					unset($content);
					
					$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);						
					//echo "<br>".$mail_html;	exit;
					/// Mailing code...[start]
					$site_admin_email = $this->s_admin_email;	
					$this->load->helper('mail');										
					$i_newid = sendMail($site_admin_email,$s_subject,$mail_html);	
                    /// Mailing code...[end]
					
					if($i_newid)////saved successfully
                    {
						$this->session->set_userdata(array('message'=>$this->cls_msg["contact_send_succ"],'message_type'=>'succ'));
                        redirect(base_url().'contact-us-success');
                    }
                    else///Not saved, show the form again
                    {
						$this->session->set_userdata(array('message'=>$this->cls_msg["contact_send_err"],'message_type'=>'err'));
                    }
                    
                }
			}            
			
		
			$this->data['breadcrumb'] = array(addslashes(t('Contact Us'))=>'');			
			$this->s_meta_type = 'contact_us';	
			$this->i_footer_menu = 13;	
			
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
			$this->data['breadcrumb'] = array(addslashes(t('Contact Us'))=>base_url().'contact-us/',addslashes(t('Thank You'))=>'');
			$this->i_footer_menu = 13;
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
                
                $this->form_validation->set_rules('txt_fname', addslashes(t('your firstame')), 'trim|required|xss_clean');
                $this->form_validation->set_rules('txt_email', addslashes(t('your email')), 'trim|required|valid_email');
                $this->form_validation->set_rules('txt_msg', addslashes(t('your comments')), 'required');
                $this->form_validation->set_rules('txt_contact', addslashes(t('your contact number')), 'trim|xss_clean');
                
                if ($this->form_validation->run() != FALSE)
                {
                    $info['s_fname'] 	= htmlentities($this->input->post('txt_fname'), ENT_QUOTES, 'utf-8');
					$info['s_lname'] 	= htmlentities($this->input->post('txt_lname'), ENT_QUOTES, 'utf-8');
                    $info['s_email'] 	= htmlentities($this->input->post('txt_email'), ENT_QUOTES, 'utf-8');
                    $info['s_msg'] 		= htmlentities($this->input->post('txt_msg'), ENT_QUOTES, 'utf-8');
					$info['s_contact'] 	= htmlentities($this->input->post('txt_contact'), ENT_QUOTES, 'utf-8');
                    
					
					$content = $this->mod_auto->fetch_mail_content('abuse_report','general');
					$filename = $this->config->item('EMAILBODYHTML')."common.html";
				   	$handle = @fopen($filename, "r");
				   	$mail_html = @fread($handle, filesize($filename));	
					$s_subject = $content['s_subject'];				
					//print_r($content); exit;
					if(!empty($content))
						{							
							$description = $content["s_content"];
							$description = str_replace("[FIRSTNAME]",$info['s_fname'],$description);	
							$description = str_replace("[LASTNAME]",$info['s_lname'],$description);	
							$description = str_replace("[EMAIL]",$info['s_email'],$description);		
							$description = str_replace("[CONTACT]",$info['s_contact'],$description); 
							$description = str_replace("[MESSAGE]",$info['s_msg'],$description);					
						}
					unset($content);
					
					$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
						
					//echo "<br>".$mail_html;	exit;	
					/// Mailing code...[start]
					$site_admin_email = $this->s_admin_email;	
					$this->load->helper('mail');										
					$i_newid = sendMail($site_admin_email,$s_subject,$mail_html);
                    /// Mailing code...[end]
					if($i_newid)////saved successfully
                    {
						$this->session->set_userdata(array('message'=>$this->cls_msg["abuse_send_succ"],'message_type'=>'succ'));
                        redirect(base_url().'abuse-report-success');
                    }
                    else///Not saved, show the form again
                    {
						$this->session->set_userdata(array('message'=>$this->cls_msg["abuse_send_err"],'message_type'=>'err'));
                    }
                    
                }
			}   			
			
			$this->data['breadcrumb'] = array(addslashes(t('Abuse Report'))=>'');	
			$this->i_footer_menu = 14;		
			
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
			$this->data['breadcrumb'] = array(addslashes(t('Abuse Report'))=>base_url().'abuse-report/',addslashes(t('Thank You'))=>'');
			$this->i_footer_menu = 14;
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/*To change language and redirect the referral page*/
	function change_lang($lang_id)
	{
		$lang_id = decrypt($lang_id);
		//echo "<br>===>".$url;
		$this->load->model('language_model');
		$info = $this->language_model->fetch_this($lang_id);
		
	  	$this->session->set_userdata(array('lang'=>$lang_id)); 
		$this->session->set_userdata('current_language', $info['s_short_name']); 
	  	$url = base64_decode($url);
	  	header('location:'.base_url());
		exit(0); 
	}
	
	
	
	
	
	
	 function ajax_change_city_option()
    {
		$this->load->model('city_model');
        $state_id  = decrypt($this->input->post('state_id'));
		$parent_city_option = $this->city_model->get_city_selectlist($state_id);
        echo '<select id="opt_city" name="opt_city" style="width:192px;" onchange="call_ajax_get_zipcode(\'ajax_change_zipcode_option\',this.value,'.$state_id.',\'parent_zip\');">
              <option value="">Select city</option>'.$parent_city_option.'</select>';
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
	
	/* to get auto city suggestion
	* call at @fin_job.tpl.php
	*/
	function ajax_autocomplete_city_state($city='')
	{
		if(!$city)
		{
			return false;
		}
		$this->load->model('city_model');
		
		$s_where = " WHERE  c.city LIKE '%{$city}%'";
		$city_list = $this->city_model->fetch_multi($s_where);
		//pr($city_list); exit;
		if($city_list)
		{
			foreach($city_list as $val)
			{
				echo '<div class="autocomplete_link" onclick="business_fill(\''. htmlspecialchars ($val['city']).'^'.encrypt($val['id']).'\');">'.$val['city'].' </div>';
			}
		}
	
		
	}
	
	
	
	/* to show news details*/
	function news($news_id)
	{
		try
		{
			$this->i_menu_id = 1;
			$this->data['breadcrumb'] = array(addslashes(t('News'))=>'');
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
	
	
	
	/* to show testimonial details*/
	function testimonial_details($testimonial_id)
	{
		try
		{
			//$this->i_menu_id = 1;
			$this->data['breadcrumb'] = array(addslashes(t('Testimonial'))=>'');
			$testimonial_id =  decrypt($testimonial_id);
			$this->load->model('testimonial_model');
		    $this->data['testimonial_details'] =  $this->testimonial_model->fetch_this($testimonial_id);
			//pr($this->data['testimonial_details'],1);
			$this->render();
			
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	}		
		
	
	
	public function message()
	{
		$this->data['breadcrumb'] = array(addslashes(t('Message'))=>'');
		$this->render();
	}	
	
	
	//Tag Cloude
	function tag_cloud()
	{
		$tag	=	$this->mod_job->tag_cloud();
		shuffle($tag);
		
		//start json object
		$json = "({ tags:[";
		
		//loop through and return results
		for ($x = 0; $x < count($tag); $x++) 
		{
			//continue json object
			$json .= "{tag:'" . $tag[$x]["s_keyword"] . "',freq:'" . $tag[$x]["i_weight"] . "'}";
			
			//add comma if not last row, closing brackets if is
			if ($x < count($tag) -1)
				$json .= ",";
			else
				$json .= "]})";
		}
		
		//return JSON with GET for JSONP callback
		$response = $_REQUEST["callback"] . $json;
		echo $response; 
	}
	
    

  
	
    public function __destruct()

    {}           

}



/* End of file welcome.php */

/* Location: ./system/application/controllers/welcome.php */

