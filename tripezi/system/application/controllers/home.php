<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 06 July 2012
* Modified By: 
* Modified Date: 
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
          $this->data['title'] = "Home";////Browser Title
		  $this->data['ctrlr'] = "home";
		
          $this->cls_msg=array();

		  $this->cls_msg["no_result"]				= "No information found about latest news.";		  
		  $this->cls_msg["contact_send_err"]		= "Contact us mail not delivered.";
          $this->cls_msg["contact_send_succ"]		= "Contact us mail delivered successfully.";
		  $this->cls_msg["login_err"]				= "Please login to access this";
		  $this->cls_msg["save_testimonial"]		= "testimonial saved successfully.";
		  $this->cls_msg["save_testimonial_err"]	= "testimonial saved failed.";
		  $this->cls_msg["exceed_err"]				= "You have already post a testimonial";
		  $this->cls_msg["save_comment"]			= "comment saved successfully.";
		  $this->cls_msg["save_comment_err"]		= "comment saved failed.";
		  $this->cls_msg["comment_login_err"]		= "Please login to post comment on this blog";
		  $this->cls_msg["subscribe_exist_err"] 	= "You have already subscribed for newsletter.";
		  $this->cls_msg["subscribe_succ"] 			= "You have subscribed successfully.";
		  $this->cls_msg["subscribe_err"] 			= "Failed to save subscription.";
		  $this->cls_msg["unsubscribe_succ"]		= "You have unsubscribed successfully.";
		  $this->cls_msg["unsubscribe_err"]			= "Your unsubscription failed.";
		  $this->cls_msg["already_unsuscribe_err"]	= "You are not a subscribed member.";
		  
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  $this->load->model('cms_model','mod_cms');
		  $this->load->model('common_model','mod_common');		  
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
			$this->s_meta_type = 'home';			
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
			/*$activation_code = $this->uri->segment(3);
			$this->session->set_userdata('s_referred_code',$activation_code);	
			redirect(base_url().'user/registration');*/			
        }
		
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	 	    
    
	}	
	
	public function terms_condition()
    {
        try
        {		
			$this->s_meta_type = 'terms_conditions';
			$this->data['breadcrumb'] = array('Terms And Conditions'=>'');	
			$this->data['info']		= $this->mod_cms->fetch_this(3);  // fetch terms and conditions content
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	
	/* this function fetch the datas of
	*  about us, testimonials, terms & privacy tabs
	*  author @ mrinmoy
	*/
    public function cms($param)
    {
		try
        {	
			switch($param)
			{
				case "0":								
					$this->i_footer_menu = 4;
					$this->s_meta_type = 'about_us';
					$this->data['breadcrumb'] = array('About Us'=>'');
					break;	
				
				case "1":
					$this->i_footer_menu = 6;
					$this->s_meta_type = 'testimonial';
					$this->data['breadcrumb'] = array('Testimonials'=>'');
					break;
				case "2":
					$this->i_footer_menu = 5;
					$this->s_meta_type = 'terms_conditions';
					$this->data['breadcrumb'] = array('Terms & Privacy'=>'');
					break;		
				
				default :	
					$this->s_meta_type = 'default';	
			}	
			
			$s_where				= " WHERE c.i_id!=0 ";
			$this->data['info']		= $this->mod_cms->fetch_multi($s_where);  // fetch all cms contents
			$this->data['param']	= $param;
			
			$this->load->model('testimonial_model');
			$s_where 						= " WHERE n.i_status = 1 ";
			$this->data['testimonial']		= $this->testimonial_model->fetch_multi($s_where,0,5);
			$imagePathArr	=	$this->config->item('user_image');
			//pr($imagePathArr,1);
			$this->data["dispalyPath"]	=	$imagePathArr["min"]["display_path"];
			//pr($this->data['info'],1);
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	}
	
	
	/* this function fetch the datas of
	*  how it works, why to book with us, why to host
	*  author @ mrinmoy
	*/
    public function how_it_works($param)
    {
		try
        {	
			switch($param)
			{
				case "0":	
					$this->s_meta_type = 'how_it_works';
					$this->data['breadcrumb'] = array('How It Works'=>'');
					break;	
				
				case "1":
					$this->s_meta_type = 'why_to_book';
					$this->data['breadcrumb'] = array('Why To Book'=>'');
					break;
				case "2":
					$this->s_meta_type = 'why_to_host';
					$this->data['breadcrumb'] = array('Why To Host'=>'');
					break;		
				
				default :	
					$this->s_meta_type = 'default';	
			}	
			
			$s_where				= " WHERE c.i_status = 1 ";
			$this->data['info']		= $this->mod_cms->fetch_multi($s_where);  // fetch all cms contents
			//pr($this->data['info'],1);
			$this->load->model('site_setting_model','mod_site_setting');
			$detail	= $this->mod_site_setting->fetch_this("NULL");
			//pr($detail,1);
			$this->data["s_youtube_snippet_for_how_it_works"] = $detail["s_youtube_snippet_for_how_it_works"];
			$this->data['param']	= $param;		
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	}
	
	
	/* to show the job lists */
	public function job()
    {
        try
        {		
			$this->data['breadcrumb'] = array('Jobs'=>'');	
			$this->i_footer_menu = 3;	
			$this->data["jobs_hr_content"] = $this->mod_cms->fetch_this(9);
			$this->load->model('jobs_model');	
			$s_where = " WHERE n.i_status = 1 ";	
			$this->data['jobs'] = $this->jobs_model->fetch_multi($s_where,0,7);
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/* to show the FAQ lists */
	public function faq()
    {
        try
        {		
			$this->data['breadcrumb'] = array('FAQ'=>'');				
			$this->load->model('faq_model');	
			$s_where = " WHERE n.i_status = 1 ";	
			$this->data['faqs'] = $this->faq_model->fetch_multi($s_where);
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	/* to show all the press posted by site admin */
	public function press()
    {
        try
        {

            $this->data['breadcrumb'] = array('Press'=>'');
			$this->i_footer_menu = 2;
			$this->s_meta_type = 'press';
			
			$this->data["content_right_panel"] = $this->mod_cms->fetch_this(8);
            //pr($this->data["content_right_panel"],1);
			ob_start();
			$this->ajax_pagination_press(0,1);
			$contents = ob_get_contents();
			ob_end_clean();
			$press_list = explode('^',$contents);			
			$this->data['press_list'] 	  = $press_list[0];
			//$this->data['press_list']   = $press_list[0];
			
            $this->render('home/press');
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
    }
	
	
	/* ajax call to get bolgs data */
	function ajax_pagination_press($start=0,$param=0) 
	{			
		$this->load->model('press_model');
		$s_where 					= " WHERE p.i_status=1";
		$limit						= 3; 
		$this->data['press_list']	= $this->press_model->fetch_multi($s_where,intval($start),$limit);
		$total_rows 				= $this->press_model->gettotal_info($s_where);
		//pr($this->data['press_list'],1);
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'home/ajax_pagination_press/';
		$paging_div = 'press_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		if(empty($param))
			$job_vw = $this->load->view('fe/home/ajax_pagination_press.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/home/ajax_pagination_press.tpl.php',$this->data,TRUE).'^'.$total_rows;
		echo $job_vw;
			
	}
	
	/**************** end press posted by site admin **********************/
	
	
	/* to show all the blog posted */
	public function blog()
    {
        try
        {

            $this->data['breadcrumb'] = array('Blog'=>'');
			$this->i_footer_menu = 1;
			$this->s_meta_type = 'blog';
           
		    $this->session->unset_userdata('blog_title');
			ob_start();
			$this->ajax_pagination_blogs(0,1);
			$contents = ob_get_contents();
			ob_end_clean();
			$blog_list = explode('^',$contents);			
			$this->data['blog_list'] 	  = $blog_list[0];
			//$this->data['blog_list'] 	  = $blog_list[0];
			
            $this->render('home/blog');
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
    }	
	
	/* ajax call to get bolgs data */
	function ajax_pagination_blogs($start=0,$param=0) 
	{			
		$this->load->model('blog_model');
		$s_where 				= " WHERE n.i_status=1";
		
		/* if search is done */
		$sessArrTmp['blog_title'] = $this->session->userdata('blog_title');  
		if($sessArrTmp['blog_title']!="")
		{
		$s_where.=" AND (n.s_title LIKE '%".get_formatted_string($sessArrTmp['blog_title'])."%' OR n.s_description LIKE '%".get_formatted_string($sessArrTmp['blog_title'])."%') ";
		}
		/* if search is done */
		
		$limit					= 2; 
		$this->data['blog_list']= $this->blog_model->fetch_multi($s_where,intval($start),$limit);
		$total_rows 			= $this->blog_model->gettotal_info($s_where);
		//pr($this->data['blog_list'],1);
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'home/ajax_pagination_blogs/';
		$paging_div = 'blog_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		if(empty($param))
			$job_vw = $this->load->view('fe/home/ajax_pagination_blogs.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/home/ajax_pagination_blogs.tpl.php',$this->data,TRUE).'^'.$total_rows;
		echo $job_vw;
		/* pagination end */

	
	}
	
	
	function ajax_search_blog_name()
    {
		try
		{
			 //$sessArrTmp = array();
			if($_POST)
			{
			$sessArrTmp['blog_title'] = trim($this->input->post('txt_title'))!="Search"?trim($this->input->post('txt_title')):""; 
			}			
			$this->session->set_userdata('blog_title',$sessArrTmp['blog_title']);	// to store data in session
			
			ob_start();
            $this->ajax_pagination_blogs();
            $blog_list = ob_get_contents();
            ob_end_clean();
			
			echo $blog_list;
			
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
	}
	
	
	/* show the bolg comments */
	public function blog_comments($i_blog_id='')
    {
        try
        {

			$this->load->model('blog_model');
			if(decrypt($i_blog_id))
			{
				$this->data["blog_detail"]	=	$this->blog_model->fetch_this(decrypt($i_blog_id));
				$this->data['breadcrumb'] 	= array('Blog'=>base_url().'blog',$this->data["blog_detail"]["s_title"]=>'');
			}
			$this->s_meta_type = 'blog_comments';
           
		   	$this->session->unset_userdata('blog_comment');
			ob_start();
			$this->session->set_userdata('i_blog_id',decrypt($i_blog_id));
			$this->ajax_pagination_blog_comments(0,1);
			$contents = ob_get_contents();
			ob_end_clean();
			$blog_comments = explode('^',$contents);			
			$this->data['blog_comments'] 	  = $blog_comments[0];
            $this->render('home/blog_comments');
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
    }
	
	/* ajax call to get blog comments */
	function ajax_pagination_blog_comments($start=0,$param=0) 
	{			
		$this->load->model('blog_model');
		$i_blog_id	=	$this->session->userdata('i_blog_id');
		$s_where 				= " WHERE c.i_blog_id = ".$i_blog_id." AND c.i_status = 1 ";
		/* if search is done */
		$sessArrTmp['blog_comment'] = $this->session->userdata('blog_comment');  
		if($sessArrTmp['blog_comment']!="")
		{
		$s_where.=" AND c.s_comment LIKE '%".get_formatted_string($sessArrTmp['blog_comment'])."%' ";
		}
		/* if search is done */
		
		$limit					= 3; 
		$this->data['blog_comments']	= $this->blog_model->fetch_blog_comments($s_where,intval($start),$limit);
		$total_rows 					= $this->blog_model->gettotal_blog_comments($s_where);
		//pr($this->data['blog_list'],1);
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'home/ajax_pagination_blog_comments/';
		$paging_div = 'blog_comments';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		if(empty($param))
			$job_vw = $this->load->view('fe/home/ajax_pagination_blog_comments.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/home/ajax_pagination_blog_comments.tpl.php',$this->data,TRUE).'^'.$total_rows;
		echo $job_vw;
		/* pagination end */
	
	}
	
	/* search comments of blog*/
	function ajax_search_blog_comments()
    {
		try
		{
			 //$sessArrTmp = array();
			if($_POST)
			{
			$sessArrTmp['blog_comment'] = trim($this->input->post('txt_title'))!="Search"?trim($this->input->post('txt_title')):""; 
			}			
			$this->session->set_userdata('blog_comment',$sessArrTmp['blog_comment']);	// to store data in session
			
			ob_start();
            $this->ajax_pagination_blog_comments();
            $blog_list = ob_get_contents();
            ob_end_clean();
			
			echo $blog_list;
			
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
	}
	
	/* post new comment for a blog */
	function ajax_post_comments()
    {
		try
		{
			if($_POST)
			{
				$posted     =   array();               
				$posted["txt_comment"]	=   $this->input->post("txt_comment") ;
				$posted["i_blog_id"]	=   $this->input->post("blog_id");
                //pr($this->data['loggedin'],1);
                $this->form_validation->set_rules('txt_comment','your comment', 'required|trim');
               
			    if(!empty($this->data['loggedin']))
				{
					if($this->form_validation->run() == FALSE) // validation false (error occur)
					{
						$this->data["posted"]   =   $posted ;
					}
					else // no error
					{
						$info   				=	array();
						$info["s_comment"]		=	$posted["txt_comment"] ;  
						$info["i_blog_id"]		=	$posted["i_blog_id"] ; 
						$info["i_user_id"]		=	decrypt($this->data['loggedin']["user_id"]);	
						$info["dt_created_on"]	=	time();
						//pr($info,1);
						$s_table = $this->db->BLOGCOMMENT;
						$i_add	 =	$this->mod_common->common_add_info($s_table,$info);
				   
						if($i_add)
						{
							$msg = '1|'.$this->cls_msg["save_comment"];
						} 
						else
						{
							$msg = '2|'.$this->cls_msg["save_comment_err"];
						}                       
					  
					}
				}
				else
				{
					$msg = '2|'.$this->cls_msg["comment_login_err"];
				}
			}
			
			echo $msg;
			
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
	}
	
	
	
	/* end show all the blog posted */
	
	public function site_map()
    {
        try
        {		
			$this->data['breadcrumb'] = array('Site Map'=>'');	
			$this->i_footer_menu = 8;			
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
			
			$this->data['breadcrumb'] = array('Contact Us'=>'');			
			$this->s_meta_type = 'contact_us';
			if($_POST)
            {
                $posted     =   array();
                $posted["txt_name"]   		=   $this->input->post("txt_name") ;
                $posted["txt_email"]        =   $this->input->post("txt_email") ;
				$posted["txt_phone"]        =   $this->input->post("txt_phone") ;
				$posted["ta_message"]       =   $this->input->post("ta_message") ;
                $posted["txt_captcha"]      =   $this->input->post("txt_captcha") ;
                
                $this->form_validation->set_rules('txt_name','your name', 'required|trim');
                $this->form_validation->set_rules('txt_email','your email address', 'valid_email|required|trim');
                $this->form_validation->set_rules('ta_message','message', 'required|trim');
                $this->form_validation->set_rules('txt_captcha','security code', 'required|callback__captcha_valid');
                
                if($this->form_validation->run() == FALSE) // validation false (error occur)
                {
                    $this->data["posted"]   =   $posted ;
                }
                else // no error
                {
                    $info   =   array();
                    $info["s_name"]       		=    $posted["txt_name"] ;   
                    $info["s_email"]            =    $posted["txt_email"] ;  
                    $info["s_phone"]        	=    $posted["txt_phone"] ; 
                    $info["s_message"]          =    $posted["ta_message"] ;                    
                    
                    $this->load->model("auto_mail_model","mod_auto");
                    $content         =   $this->mod_auto->fetch_mail_content('contact_us');    
                    $filename        =   $this->config->item('EMAILBODYHTML')."common.html";
                    $handle          =   @fopen($filename, "r");
                    $mail_html       =   @fread($handle, filesize($filename));    
                    $s_subject       =   $content['s_subject'];        
                    //print_r($content); exit;                                      
                    if(!empty($content))
                    {                    
                        $description = $content["s_content"];                        
                        $description = str_replace("###NAME###",$info["s_name"],$description);    
                        $description = str_replace("###EMAIL###",$info['s_email'],$description); 
						$description = str_replace("###PHONE###",$info['s_phone'],$description);
						$description = str_replace("###MESSAGE###",$info['s_message'],$description);       
                                              
                    }
                        
                    $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);    
                    $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);    
                    //echo "<br>DESC".$mail_html;    exit;
                    
                    /// Mailing code...[start]
                    $site_admin_email = $this->s_admin_email;    
                    $this->load->helper('mail');                                        
                    $i_sent = sendMail($site_admin_email,$s_subject,$mail_html);
					if($i_sent)
					{
						$this->session->set_userdata(array('message'=>$this->cls_msg["contact_send_succ"],'message_type'=>'succ'));
						redirect(base_url()."contact-us-success");
					}                        
                  
                }
            }	
			$this->i_footer_menu = 7;			
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
			$this->data['breadcrumb'] = array('Contact Us'=>base_url().'contact-us','Thank You'=>'');
			$this->i_footer_menu = 7;
			$this->render();
		}
	
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		} 	    
	}
	
	/**
    * This is a callback private function for ci form validation
    * check captcha correct or not
    * 
    * @param mixed $s_captcha
    */
    function _captcha_valid($s_captcha)
    {
        if($s_captcha!=$this->session->userdata('captcha'))
        {
             $this->form_validation->set_message('_captcha_valid', 'Please provide correct %s.');
             
             unset($s_captcha);
             return false;
        }
        else
        {
            return true;
        }
    }
	
	
	public function message()
	{
		$this->data['breadcrumb'] = array('Message'=>'');
		$this->render();
	}
	
	/* ajax calll to post testimonial */
	function save_testimonial()
	{
		if($_POST)
		{
			$posted=array();           
			$posted["ta_message"] 	= trim($this->input->post("ta_message"));
			$i_user_id 				= decrypt($this->input->post("h_user_id"));
			
			// Remove email address from content......
			$posted["ta_message"] = preg_replace('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/','',$posted["ta_message"]); 
			// Remove website address from content......
            $posted["ta_message"] = preg_replace('/([a-z0-9_-]+\.)*[a-z0-9_-]+(\.[a-z]{2,6}){1,2}/','',$posted["ta_message"]);  
			
			$s_tablename	= 	$this->db->TESTIMONIALS;
			$s_where = " WHERE i_user_id={$i_user_id} AND i_status=1";
			$i_count = $this->mod_common->common_count_rows($s_tablename,$s_where);
			//pr($this->data['loggedin'],1);
			if(!empty($this->data['loggedin']))
			{
				if(!$i_count)
				{					
					$info=array();
					$info["i_user_id"]		=	$i_user_id;
					$info["s_content"]		=	$posted["ta_message"];
					$info["dt_created_on"]	=	time();	
					//pr($info,1);		
							
					$i_newid 		= $this->mod_common->common_add_info($s_tablename,$info);
					//$i_newid = true;
					if($i_newid)////saved successfully
					{											
						$msg = '1|'.$this->cls_msg["save_testimonial"];
					}
					else	///Not saved, show the form again
					{
						$msg = '2|'.$this->cls_msg["save_testimonial_err"];
					}		
				}
				else
				{
					$msg = '2|'.$this->cls_msg["exceed_err"];
				}			
			}				
			
			else   // login and not a tradesman error
			{
				$msg = '2|'.$this->cls_msg["login_err"];
			}
		}
		echo $msg;	
	}
	/* end ajax calll to post testimonial */
	
	/* subscribe newsletter */
	function subscribe_newsletter()
	{
		try
		{
			
			$s_name  = trim($this->input->post('s_name'));
			$s_email = $this->input->post('s_email');
			
			$s_tablename = $this->db->NEWSLETTERSUBCRIPTION;
			$s_where = " WHERE s_email = '".$s_email."' ";
			$i_count = $this->mod_common->common_count_rows($s_tablename,$s_where);
			
			if($i_count > 0)
			{	
				$msg = '2|'.$this->cls_msg["subscribe_exist_err"];
			}
			else 
			{
				$info 					= array();
				$info["s_name"]			= $s_name;
				$info["s_email"]		= $s_email;
				$info["dt_created_on"]	= time();
				$info["i_failure_count"]= 0;
				
				$i_newid = $this->mod_common->common_add_info($s_tablename,$info);
				if($i_newid)////saved successfully
				{
					$msg = '1|'.$this->cls_msg["subscribe_succ"];					
				}
				else ///Not saved,
				{
					$msg = '2|'.$this->cls_msg["subscribe_err"];
				}
			}			
			
			echo $msg;
			
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	}	
	/* end subscribe newsletter */
	
	/* for unsubscribe newsletter */
	function unsubscribe($enc_email)
	{
		try
		{
			$s_email = decrypt($enc_email);	
			if($s_email!='')
			{
				$s_where = " WHERE s_email = '".$s_email."' ";				
				$s_table = $this->db->NEWSLETTERSUBCRIPTION;
				$i_count = $this->mod_common->common_count_rows($s_table,$s_where);
				if($i_count>0)
				{
					$arr_where = array('s_email'=>$s_email);
					$i_delete = $this->mod_common->common_delete_info($s_table,$arr_where);
					
					$s_table = $this->db->EMAILLOG;
					$arr_where = array('s_to_emails'=>$s_email);
					$i_deleted = $this->mod_common->common_delete_info($s_table,$arr_where);
					if($i_delete)
					{
						$this->session->set_userdata(array('message'=>$this->cls_msg["unsubscribe_succ"],'message_type'=>'succ'));
						redirect(base_url()."home/message");
					}
					else
					{
						$this->session->set_userdata(array('message'=>$this->cls_msg["unsubscribe_err"],'message_type'=>'err'));
						redirect(base_url()."home/message");
					}
				}
				else
				{
					$this->session->set_userdata(array('message'=>$this->cls_msg["already_unsuscribe_err"],'message_type'=>'err'));
					redirect(base_url()."home/message");
				}
			}	
			
			unset($s_table,$arr_where,$i_delete,$i_deleted);
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	}	
	/* end un subscribe newsletter */
	
	/* for changing currency */
	public function change_currency()
	{
		try
        {
			$currency_id = decrypt($this->input->post('opt_currency'));
			$this->session->set_userdata('cur_id',$currency_id); 
			echo 'ok';
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

