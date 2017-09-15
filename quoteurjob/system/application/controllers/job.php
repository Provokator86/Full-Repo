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

class Job extends My_Controller
{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
        try
        { 
          parent::__construct(); 
          $this->data['title']="Job";////Browser Title
		  $this->data['ctrlr'] = "home";
		  
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  $this->load->model('job_model','mod_');
		  $this->load->model('zipcode_model');
		  $this->cls_msg["job_find_err"] = t("Job not found.");
		  $this->cls_msg["tradesman_job_post_err"] = t('Only Buyer can post job.');
		  $this->cls_msg["not_access"] = t('You can\'t place quote without login.');
		  $this->cls_msg["not_for_buyer"] = t('Buyer can\'t place quote.');
		  $this->cls_msg["save_quote"] = t('Quote placed successfully.');
		  $this->cls_msg["save_quote_err"] = t('Quote not placed successfully.');
		  $this->cls_msg["file_type_error"] = t('The file type you want to upload is not permitted');
		  
		  $this->cls_msg["exists_quote_err"] = addslashes(t('You have already placed a quote.'));
		  $this->data['i_lang_id'] = $this->i_default_language;
		  
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
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
    public function job_post()
    {
        try
        {	
			if(!empty($this->data['loggedin']) && decrypt($this->data['loggedin']['user_type_id'])!=1)
			{
				$this->session->set_userdata(array('message'=>$this->cls_msg["tradesman_job_post_err"],'message_type'=>'err'));
				redirect(base_url().'home/message');
			}
			$this->i_menu_id = 2;		
			$this->data['breadcrumb'] = array(t('Post a Job')=>'');
			$this->s_meta_type = 'post_job';
			$this->add_css('css/fe/dd.css');
			$this->add_js('js/fe/jquery.dd.js');
			$o_ci = &get_config();	
			$allow_ext = array('jpg','jpeg','gif','png','doc','pdf');
			$this->data['allow_ext'] = implode(", ",$allow_ext);
			////////////Submitted Form///////////
			$user_id = decrypt($this->data['loggedin']['user_id']);	
			
			
			//var_dump($_POST);
            if($_POST)
            {
				$posted=array();
                $posted["txt_title"]	= trim($this->input->post("txt_title"));
				$posted["opd_category_id"]= trim($this->input->post("opd_category_id"));
				$posted["opt_province_id"]= trim($this->input->post("opt_state"));
				$posted["opt_city_id"]= trim($this->input->post("opt_city"));
				$posted["i_zipcode_id"]= trim($this->input->post("opt_zip"));
				$posted["chk_supply_material"]= trim($this->input->post("chk_supply_material"));
				$posted["txt_description"]= trim($this->input->post("txt_description"));
				$posted["txt_keyword"]= trim($this->input->post("txt_keyword"));
				$posted["opd_quoting_period_days"]= trim($this->input->post("opd_quoting_period_days"));
				$posted["txt_budget_price"]= trim($this->input->post("txt_budget_price"));
			
               
                $this->form_validation->set_rules('txt_title', t('provide job title'), 'required');
				$this->form_validation->set_rules('opd_category_id', t('select category'), 'required');
                $this->form_validation->set_rules('opt_state', t('select province'), 'required');
				$this->form_validation->set_rules('opt_city', t('select city'), 'required');
				$this->form_validation->set_rules('opt_zip', t('select postal code'), 'required');
				$this->form_validation->set_rules('txt_description', t('select description'), 'required');
				$this->form_validation->set_rules('txt_keyword', t('select keyword'), 'required');
				$this->form_validation->set_rules('opd_quoting_period_days', t('select quote period days'), 'required');

              
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
					$info["i_created_date"]=time();
					
					$arrImg = array();
					
					/******* Upload image **********/	
					foreach($_FILES as $key=>$file)
					{
						$i = substr($key,-1);
						if ( $file['name']!='') 
						{
							  $ext1 = strtolower(end(explode(".",$file['name'])));	
							
							//echo '<br>';
							
							
						if (in_array($ext1,$allow_ext)) 
						{		
								 $this->imagename = 'job_'.$i.'_'.time();
								$this->upload_image = $o_ci['job_file_upload_path'].$this->imagename;	
								$max_file_size    = $o_ci['job_file_upload_max_size'];
								$img_details = upload_file($this,
									array('upload_path' => $o_ci['job_file_upload_path'],
										  'file_name'	=> $this->imagename.".".$ext1 ,
										  'allowed_types' => 'pdf|gif|jpg|png|jpeg|doc',	
										  'max_size' => $max_file_size,
										  'max_width' => '0',
										  'max_height' => '0',
										  ), 'f_image_'.$i
									);
									
								if(is_array($img_details) &&  $ext1!="pdf" && $ext1!="doc")
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
									//header('location:'.base_url().'job/job_post');
									//exit;
								}
								 $arrImg = array_merge($arrImg,array('job_image'.$i=>$this->imagename.".".$ext1));
							} // end of extension checking 	
							
						else 
						{
							$this->session->set_userdata('arr_reg_value',$posted);
							$this->session->set_userdata(array('message'=>$this->cls_msg["file_type_error"],'message_type'=>'err'));
							redirect(base_url().'job/job_post');
						}
								
						} // end if
						
						
						
					}	// end of foreach
					
					
					/******* End of upload image *****/
					$jobtotArr	= array('job'=>$info,'img'=>$arrImg,'job_post_session'=>$this->session->userdata('session_id'));					
					$job_id = $this->mod_->set_job_insert_all($jobtotArr);	
					if($job_id)
					{
						   $this->load->model('category_model');
						  
						   //$category = $this->category_model->fetch_this($info['i_category_id']);
						  
						   $category = $this->category_model->fetch_this_cat_name($info['i_category_id'],$this->i_default_language);
						   //pr($category);
						   /* for job posting mail to the user */
						   $this->load->model('auto_mail_model');
						   $content = $this->auto_mail_model->fetch_contact_us_content('job_posted','buyer');
						    $filename = $this->config->item('EMAILBODYHTML')."common.html";
						   $handle = @fopen($filename, "r");
						   $mail_html = @fread($handle, filesize($filename));					
							//print_r($content); exit;	
							
							if(!empty($content))
								{		
									if($this->data['loggedin']['user_signup_lang']==2)
									{
										$description = $content["s_content_french"];
									}
									else
									{					
										$description = $content["s_content"];
									}
									$description = str_replace("[Buyer name]",$this->data['loggedin']['user_name'],$description);
									$description = str_replace("[job title]",$info['s_title'],$description);	
									$description = str_replace("[job type/category]",$category['s_category_name'],$description);
									$description = str_replace("[site url]",base_url(),$description);	
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
							$config['charset'] = 'utf-8';
							$config['wordwrap'] = TRUE;
							$config['mailtype'] = 'html';
												
							$this->email->initialize($config);					
							$this->email->clear();                    
							
							$this->email->from($site_admin_email);	
											
							$this->email->to($this->data['loggedin']['user_email']);
							
							if($this->data['loggedin']['user_signup_lang']==2) // for automail in french version 
							{
								$this->email->subject($content['s_subject_french']);
							}
							else
							{
								$this->email->subject('::: Job Posting Mail :::');
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
							
						/* end job posting mail to the user */							
						
						
						
						
						
					
						redirect($this->pathtoclass."sucess_job_post");						
					}	
					else
					{
						$this->session->set_userdata(array('job_post_session'=>$jobtotArr));
						header("Location: ".base_url().'user/registration/'.encrypt(1));
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
            ////////////end Submitted Form///////////			
			$this->data['posted'] = $this->session->userdata('arr_reg_value');
			$this->session->unset_userdata('arr_reg_value');
						
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/*To change language and redirect the referral page*/
/*	function change_lang($lang_id,$url)
	{
		$lang_id = decrypt($lang_id);
	  	$this->session->set_userdata(array('lang'=>$lang_id)); 
	  	$url = base64_decode($url);
	  	header('location:'.$url);
		exit(0); 
	}*/
	
	public function find_job($i_category_id=0)
	{
		try
		{
			$this->i_menu_id = 4;		
			$this->data['breadcrumb'] = array(t('Find Job')=>'');	
			$this->s_meta_type = 'find_job';
			$this->add_css('css/fe/dd.css');
			$this->add_js('js/fe/jquery.dd.js');

			/**fetch job category **/
		    $this->load->model('category_model');
		    $s_where = " WHERE s_category_type='job' and i_status=1 AND cc.i_lang_id =".$this->i_default_language;  
		    $this->data['category_list'] =  $this->category_model->fetch_multi($s_where);
		    /**end fetch job category **/
			
			$sessArrTmp = array();
			if(decrypt($i_category_id))
			{
				$sessArrTmp['src_job_category_id']  = $i_category_id;
			}
			elseif($_POST)
			{
				$sessArrTmp['src_job_fulltext_src'] = trim($this->input->post('txt_fulltext_src'));
				$sessArrTmp['src_job_fulladd_src']  = trim($this->input->post('txt_fulladd_src'));
				$sessArrTmp['src_job_category_id']  = (decrypt($i_category_id)) ? $i_category_id : trim($this->input->post('i_category_id'));	
				$sessArrTmp['src_job_radius'] 		= trim($this->input->post('opt_radius'));					
				$sessArrTmp['src_job_city_id']		= trim($this->input->post('opt_city_id'));
				$sessArrTmp['src_job_postal_code'] 	= trim($this->input->post('txt_postal_code'));
				$sessArrTmp['src_job_status'] 	 	= trim($this->input->post('opt_status'));
				$sessArrTmp['src_job_record'] 	 	= trim($this->input->post('opt_record'));	
			}
			
			$this->session->set_userdata(array('model_session'=>$sessArrTmp));	// to store data in session
			$this->data['posted'] = $sessArrTmp;
			
			

			ob_start();
			$this->pagination_ajax(0,1);
			$contents = ob_get_contents();
			ob_end_clean();
			$job_contents = explode('^',$contents);
			
			$this->data['job_contents'] = $job_contents[0];
			$this->data['tot_job'] 		= $job_contents[1];
			
			$this->data['arr_find_job_status'] = $this->db->FINDJOBTYPE;
			$this->render();
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	
	}
	
	
	function pagination_ajax($start=0,$param=0) {	
		$s_where='';
		
		$sessArrTmp['src_job_fulltext_src'] = $this->get_session_data('src_job_fulltext_src');
		$sessArrTmp['src_job_fulladd_src']  = $this->get_session_data('src_job_fulladd_src');
		$sessArrTmp['src_job_category_id']  = $this->get_session_data('src_job_category_id');
		$sessArrTmp['src_job_radius'] 		= $this->get_session_data('src_job_radius');
		$sessArrTmp['src_job_city_id'] 		= $this->get_session_data('src_job_city_id');
		$sessArrTmp['src_job_postal_code']  = $this->get_session_data('src_job_postal_code');
		$sessArrTmp['src_job_status'] 		= $this->get_session_data('src_job_status');
		$sessArrTmp['src_job_record'] 		= $this->get_session_data('src_job_record');
		
		$arr_search[] = " n.i_status!=0 AND (n.i_status=1 OR n.i_status=8 OR n.i_status=4) AND n.i_is_deleted=0  AND cat_c.i_lang_id =".$this->i_default_language;  
		if($sessArrTmp['src_job_fulltext_src']!="")
		{
			 $arr_search[] =" (n.s_title LIKE '%".get_formatted_string($sessArrTmp['src_job_fulltext_src'])."%' OR n.s_description LIKE '%".get_formatted_string($sessArrTmp['src_job_fulltext_src'])."%' OR n.s_keyword LIKE '%".get_formatted_string($sessArrTmp['src_job_fulltext_src'])."%') ";
		}			
		if(!empty($sessArrTmp['src_job_fulladd_src']))
		{
			$src_city = '';
			//$src_zip = '';
			$arr_src = explode(',',$sessArrTmp['src_job_fulladd_src']);
			if(!empty($arr_src) && is_array($arr_src))
			{
				foreach($arr_src as $val)
				{
					$src_city .= ($src_city) ? " OR c.city LIKE '%".trim($val)."%' OR z.postal_code = '".trim($val)."' " : " c.city LIKE '%".trim($val)."%' OR z.postal_code = '".trim($val)."'";
					//$src_zip  .= ($src_zip) ? " OR z.postal_code = '".trim($val)."'" : " z.postal_code = '".trim($val)."'";
				}
				$src_city = ($src_city) ? '('.$src_city.')' : '';
				//$src_zip  = ($src_zip) ? '('.$src_zip.')' : '';
			}
			//echo $src_city.'====='.$src_zip;
			if(!empty($src_city))
			 $arr_search[] = $src_city ;
		}	
		if($sessArrTmp['src_job_category_id'])
		{
			$arr_search[] =" n.i_category_id=".decrypt($sessArrTmp['src_job_category_id']);
		}	
		if($sessArrTmp['src_job_city_id'])
		{
			$arr_search[] =" n.i_city_id=".decrypt($sessArrTmp['src_job_city_id']);
		}	
		
		if(decrypt($sessArrTmp['src_job_status'])==4)  // added by mrinmoy as per html
		{
			$arr_search[] =" n.i_status>=".decrypt($sessArrTmp['src_job_status']);
		}
		
		else if($sessArrTmp['src_job_status'])
		{
			$arr_search[] =" n.i_status=".decrypt($sessArrTmp['src_job_status']);
		}
		if($sessArrTmp['src_job_radius'] && $sessArrTmp['src_job_postal_code'])
		{
			$zipcode = $this->zipcode_model->fetch_multi(" WHERE n.postal_code='{$sessArrTmp['src_job_postal_code']}'");
			if(!empty($zipcode))
			 {
				$lat = $zipcode[0]['latitude'];
				$lng = $zipcode[0]['longitude'];
				$job_radius = intval(decrypt($sessArrTmp['src_job_radius']));
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
		

		$limit	= ($sessArrTmp['src_job_record']) ? decrypt($sessArrTmp['src_job_record']) : $this->i_fe_page_limit;
			
			
		$this->data['job_list']	= $this->mod_->fetch_multi_completed($s_where,intval($start),$limit);		

		$total_rows = $this->mod_->gettotal_info($s_where);	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'job/pagination_ajax/';
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
		if(empty($param))
			$job_vw = $this->load->view('fe/job/ajax_job_list.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/job/ajax_job_list.tpl.php',$this->data,TRUE).'^'.$total_rows;
		echo $job_vw;		
	}	
	
	
	
	public function completed_job()
	{
		try
		{
			$this->i_menu_id = 4;		
			$this->data['breadcrumb'] = array(t('Completed Jobs')=>'');	
			$this->s_meta_type = 'find_job';
			$this->add_css('css/fe/dd.css');
			$this->add_js('js/fe/jquery.dd.js');

			/**fetch job category **/
		    $this->load->model('category_model');
		    $s_where = " WHERE s_category_type='job' and i_status=1 AND cc.i_lang_id =".$this->i_default_language;  
		    $this->data['category_list'] =  $this->category_model->fetch_multi($s_where);
		    /**end fetch job category **/
			
			$sessArrTmp = array();
			if(decrypt($i_category_id))
			{
				$sessArrTmp['src_job_category_id']  = $i_category_id;
			}
			elseif($_POST)
			{
				$sessArrTmp['src_job_fulltext_src'] = trim($this->input->post('txt_fulltext_src'));
				$sessArrTmp['src_job_fulladd_src']  = trim($this->input->post('txt_fulladd_src'));
				$sessArrTmp['src_job_category_id']  = (decrypt($i_category_id)) ? $i_category_id : trim($this->input->post('i_category_id'));	
				$sessArrTmp['src_job_radius'] 		= trim($this->input->post('opt_radius'));					
				$sessArrTmp['src_job_city_id']		= trim($this->input->post('opt_city_id'));
				$sessArrTmp['src_job_postal_code'] 	= trim($this->input->post('txt_postal_code'));
				$sessArrTmp['src_job_status'] 	 	= trim($this->input->post('opt_status'));
				$sessArrTmp['src_job_record'] 	 	= trim($this->input->post('opt_record'));	
			}
			
			$this->session->set_userdata(array('model_session'=>$sessArrTmp));	// to store data in session
			$this->data['posted'] = $sessArrTmp;			

			ob_start();
			$this->pagination_completed_ajax(0,1);
			$contents = ob_get_contents();
			ob_end_clean();
			$job_contents = explode('^',$contents);
			
			
			$this->data['job_contents'] = $job_contents[0];
			$this->data['tot_job'] 		= $job_contents[1];
			
			$this->data['arr_find_job_status'] = $this->db->FINDJOBTYPE;
			$this->render();
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	
	}
	
	
	function pagination_completed_ajax($start=0,$param=0) {	
		$s_where='';
		
		/*$sessArrTmp['src_job_fulltext_src'] = $this->get_session_data('src_job_fulltext_src');
		$sessArrTmp['src_job_fulladd_src']  = $this->get_session_data('src_job_fulladd_src');
		$sessArrTmp['src_job_category_id']  = $this->get_session_data('src_job_category_id');
		$sessArrTmp['src_job_radius'] 		= $this->get_session_data('src_job_radius');
		$sessArrTmp['src_job_city_id'] 		= $this->get_session_data('src_job_city_id');
		$sessArrTmp['src_job_postal_code']  = $this->get_session_data('src_job_postal_code');
		$sessArrTmp['src_job_status'] 		= $this->get_session_data('src_job_status');
		$sessArrTmp['src_job_record'] 		= $this->get_session_data('src_job_record');*/
		
		$arr_search[] = " n.i_status=6 AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language;  

		$s_where .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
		

		$limit	= ($sessArrTmp['src_job_record']) ? decrypt($sessArrTmp['src_job_record']) : $this->i_fe_page_limit;
			
		
		$this->data['job_list']	= $this->mod_->fetch_multi_completed($s_where,intval($start),$limit);		

		$total_rows = count($this->data['job_list']);	

		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'job/pagination_completed_ajax/';
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
		if(empty($param))
			$job_vw = $this->load->view('fe/job/ajax_job_completed_list.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/job/ajax_job_completed_list.tpl.php',$this->data,TRUE).'^'.$total_rows;
		echo $job_vw;		
	}	
	
	
	
	function job_details($job_id=0)
	{
		try
		{
			$job_id = decrypt($job_id);
			
			$this->data['breadcrumb'] = array(t('Job Details')=>'');
			$this->s_meta_type = 'job_details';
			$this->data['job_details'] = $this->mod_->fetch_this($job_id);
			$this->load->model('manage_buyers_model');
			if(empty($this->data['job_details']))
			{
				$this->session->set_userdata(array('message'=>$this->cls_msg["job_find_err"],'message_type'=>'err'));
				redirect(base_url().'home/message');
			}
			$s_where = " WHERE i_city_id={$this->data['job_details']['i_city_id']} AND n.id!={$job_id} AND n.i_status=1 AND n.i_is_deleted!=1 AND cat_c.i_lang_id =".$this->i_default_language; 
			$this->data['other_jobs'] = $this->mod_->fetch_multi_completed($s_where);			
			$this->data['user_details'] = $this->manage_buyers_model->fetch_this($this->data['job_details']['i_buyer_user_id']);
			/* to get total job awarded */
			$s_cond = " WHERE n.i_buyer_user_id=".$this->data['job_details']['i_buyer_user_id']." And n.i_status>=4 ";
			$this->data['i_total_awarded_job'] = $this->job_model->gettotal_info($s_cond);
			//pr($this->data['user_details']); exit;
			$this->data['user_path'] = $this->config->item('user_profile_image_thumb_upload_path');
			$this->data['user_url_path'] = $this->config->item('user_profile_image_thumb_path');
			$this->render();		
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	
	}
	
	
	/* job history */
	function job_history($job_id=0)
	{
		try
		{
			
			
			$job_id = decrypt($job_id);
			
			$s_whe = " WHERE n.i_job_id=".$job_id." ";
					
			$this->data['history_details'] = $this->mod_->fetch_job_history($s_whe);
			
			//print_r($this->data['history_details']); exit;
			
			$this->load->view('fe/job/job_history.tpl.php', $this->data);	
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	
	}
	
	
	/* Download job file*/
	function download_job_files($s_file_name,$job_id)
	{
		try
		{
			$this->load->helper('download');
			$data = $this->config->item('job_file_upload_path'); // Read the file's contents
			$name = decrypt($s_file_name);			
			$fullpath = @file_get_contents($data.$name);
			if($fullpath)
				force_download($name, $fullpath); 
			else
			{
				$this->session->set_userdata(array('message'=>t('Sorry, File not exist.'),'message_type'=>'err'));
				redirect(base_url().'job/job_details/'.$job_id);
				
				
			}	
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	}
	
	
	
	public function sucess_job_post()
	{	
		/*if(empty($this->data['loggedin']))
			{
				$this->session->set_userdata(array('message'=>'You are not authorized to access this page.','message_type'=>'err'));
				redirect(base_url().'home/message');
			}*/
		$this->i_menu_id = 2;		
		$this->data['breadcrumb'] = array(t('Confirmation Page')=>'');	
		$this->render();
	}
	
	public function quote_job($i_job_id='')
	{		
		$user_type_id =  decrypt($this->data['loggedin']['user_type_id']);
		
		if($user_type_id==1)
		{
			$this->session->set_userdata(array('message'=>$this->cls_msg["not_for_buyer"],'message_type'=>'err'));
			redirect(base_url().'buyer/dashboard');
		}
		
		$i_job_id = decrypt($i_job_id);
		$i_tradesman_user_id  =  decrypt($this->data['loggedin']['user_id']);
		
		$redirect_url   = substr(uri_string(),1,-1);
		$redirect_url = base_url().$redirect_url;
		if(!empty($redirect_url))
		{
			$is_prev_not_login  =   (strpos($redirect_url,'login'))?FALSE:TRUE;
			if($is_prev_not_login)
			{
				$this->session->set_userdata('login_redirect_url',$redirect_url);
			}
		}
		
		if($user_type_id!=2)
		{
			$this->session->set_userdata(array('message'=>$this->cls_msg["not_access"],'message_type'=>'err'));
			redirect(base_url().'user/login/TVNOaFkzVT0');

		}
		
		$s_where = " WHERE i_tradesman_user_id={$i_tradesman_user_id} AND i_job_id={$i_job_id} AND i_status=1";
		$i_quote = $this->mod_->gettotal_job_quote_info($s_where);
		if($i_quote)
		{
			$this->session->set_userdata(array('message'=>$this->cls_msg["exists_quote_err"],'message_type'=>'err'));
			redirect( $this->pathtoclass.'job_details/'.encrypt($i_job_id));
		}
		$this->data['breadcrumb'] = array(t('Job Details')=>base_url().'job/job_details/'.$i_job_id,t('Place Quote')=>'');
		$this->data['job_details'] = $this->mod_->fetch_this($i_job_id);
		$s_where = " WHERE i_city_id={$this->data['job_details']['i_city_id']} AND n.id!={$i_job_id}";
		$this->data['other_jobs'] = $this->mod_->fetch_multi($s_where);	
		if($_POST)
		{
			$posted=array();
            $posted["txt_quote"] = trim($this->input->post("txt_quote"));
			
			$this->form_validation->set_rules('txt_quote', t('job quote'), 'required');
			//echo  $this->pathtoclass;exit;
			 if($this->form_validation->run() == FALSE)/////invalid
				{
					////////Display the add form with posted values within it////
					$this->data["posted"]=$posted;
				}
				else///validated, now save into DB
				{
					$info=array();
					$info["i_tradesman_user_id"]=$i_tradesman_user_id;
					$info["i_job_id"]=$i_job_id;
					$info["d_quote"]=$posted["txt_quote"];
					$info["i_created_date"]=time();
					
					$i_newid = $this->mod_->job_quote($info);
					if($i_newid)////saved successfully
					{						
						/* insert data to job history and stattus change*/
						$arr1 = array();
						$arr1['i_job_id']  =  $i_job_id;
						$arr1['i_user_id'] =  $i_tradesman_user_id;
						$arr1['s_message'] =  'job_placed_quote';
						$arr1['i_created_date'] =  time();
						$table = $this->db->JOB_HISTORY;
						$this->mod_->set_data_insert($table,$arr1);	
						/*============*/
						/* end */							
						
						
					   /* for job quote mail to the user */
					   $this->load->model('tradesman_model');
					   $this->load->model('manage_buyers_model');
					   $job_details = $this->mod_->fetch_this($i_job_id);
					   $tradesman_details = $this->tradesman_model->fetch_this($i_tradesman_user_id);
					   $buyer_details =  $this->manage_buyers_model->fetch_this($job_details['i_buyer_user_id']);
					   //print_r($tradesman_details); exit;
					  // print_r($buyer_details); exit;
					    $this->load->model('manage_buyers_model');	
					   $s_wh_id = " WHERE n.i_user_id=".$job_details['i_buyer_user_id']." ";
					   $buyer_email_key = $this->manage_buyers_model->fetch_email_keys($s_wh_id);
					   $is_mail_need = in_array('tradesman_placed_quote',$buyer_email_key);
					   
					   if($is_mail_need)
					   {
					   $this->load->model('auto_mail_model');
					   $content = $this->auto_mail_model->fetch_contact_us_content('tradesman_placed_quote','buyer');
					    $filename = $this->config->item('EMAILBODYHTML')."common.html";
				   		$handle = @fopen($filename, "r");
				   		$mail_html = @fread($handle, filesize($filename));						
						//print_r($content); exit;
						if(!empty($content))
						{			
							if($buyer_details['i_signup_lang']==2)
							{
								$description = $content["s_content_french"];
							}
							else
							{				
								$description = $content["s_content"];
							}
							$description = str_replace("[Buyer name]",$job_details['s_buyer_name'],$description);
							$description = str_replace("[job title]",$job_details['s_title'],$description);	
							$description = str_replace("[Service professional name]",$tradesman_details['s_username'],$description);
							$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);		
							$description = str_replace("[trade_url]",base_url().'tradesman_profile/'.encrypt($tradesman_details['id']),$description);	
							$description = str_replace("[service city]",$tradesman_details['s_city'],$description);	
							$description = str_replace("[registration month, year]",$tradesman_details['dt_created_on'],$description);	
							$description = str_replace("[job won]",$tradesman_details['i_jobs_won'],$description);
							$description = str_replace("[feedback received]",$tradesman_details['i_feedback_received'],$description);		
							$description = str_replace("[about service professional]",$tradesman_details['s_about_me'],$description);	
							
							$description = str_replace("[site url]",base_url(),$description);
							$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
						}
						//unset($content);
						
						$mail_html = str_replace("[site url]",base_url(),$mail_html);	
						$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
						//echo $buyer_details['s_email'];	
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
							$this->email->subject('::: Job Quote Mail :::');
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
					
					
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_quote"],'message_type'=>'succ'));
						redirect( $this->pathtoclass.'job_details/'.encrypt($i_job_id));
					}
					else///Not saved, show the form again
					{
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_quote_err"],'message_type'=>'err'));
						redirect( $this->pathtoclass.'quote_job/'.encrypt($i_job_id));
					}					
					
					
			    }		
			
		}	
		$this->render();
	
	}
		
    public function __destruct()

    {}           

}



/* End of file welcome.php */

/* Location: ./system/application/controllers/welcome.php */

