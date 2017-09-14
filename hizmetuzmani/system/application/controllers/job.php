<?php
/*********
* Author: Mrinmoy MOndal
* Date  : 25 April 2012
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
		  $this->data['ctrlr'] = "job";
		  
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  $this->cls_msg["job_find_err"] 			= addslashes(t("Job not found."));
		  $this->cls_msg["tradesman_job_post_err"] 	= addslashes(t('Only Buyer can post job.'));
		  $this->cls_msg["not_access"] 				= addslashes(t('You can\'t place quote without login.'));
		  $this->cls_msg["buyer_quote_err"] 		= addslashes(t('Please login as tradesman to place a quote.'));
		  $this->cls_msg["not_for_buyer"] 			= addslashes(t('Buyer can\'t place quote.'));
		  $this->cls_msg["save_quote"] 				= addslashes(t('Quote placed successfully.'));
		  $this->cls_msg["save_quote_err"] 			= addslashes(t('Quote not placed successfully.'));
		  $this->cls_msg["file_type_error"] 		= addslashes(t('The file type you want to upload is not permitted'));
		  
		  $this->cls_msg["exists_quote_err"] 		= addslashes(t('You have already placed a quote.'));
          $this->cls_msg["quote_exceed"]            = addslashes(t('You have no more quote to place.'));
          $this->cls_msg["contact_payment_succ"]    = addslashes(t('A contact information purchased successfully.'));
          $this->cls_msg["invitation_delete_succ"]  = addslashes(t('Job invitation deleted successfully.'));
		  $this->cls_msg["invitation_delete_err"]	= addslashes(t('Job invitation failed to deleted.'));
		  //$this->data['i_lang_id'] = $this->i_default_language;
		  $this->cls_msg["hold_post"]				= addslashes(t('Please login if you already a member or register to the site to post your job successfully.'));
		
		  $this->load->model('common_model','mod_common');
		  $this->load->model('job_model','mod_');
		  $this->load->model('zipcode_model');
		  $this->load->model('province_model');
		  $this->load->model('city_model');
		  
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
				
			$this->data['breadcrumb'] = array(addslashes(t('Post a job for free'))=>'');
			$this->i_footer_menu =1;
			$this->s_meta_type = 'post_job';
			
			$o_ci = &get_config();	
			$allow_ext = array('jpg','jpeg','gif','png','doc','pdf');
			$this->data['allow_ext'] = implode(", ",$allow_ext);
			////////////Submitted Form///////////
			$user_id 	= decrypt($this->data['loggedin']['user_id']);	
			$user_name 	= $this->data['loggedin']['user_fullname'];
			
			/* posted value from home search */
			$posted=array();
			if($this->input->post("h_cat")!='' || $this->input->post("h_city")!='')
			{
			$posted['opd_category_id'] 	= trim($this->input->post("h_cat"));
			$posted['opt_city_id'] 		= trim($this->input->post("h_city"));
			}
			
			//$this->data['posted'] = $this->data;
			//var_dump($_POST);
            if($_POST && empty($posted))
            {
				$posted=array();
                $posted["txt_title"]				= trim($this->input->post("txt_title"));
				$posted["opd_category_id"]			= trim($this->input->post("opd_category_id"));
				$posted["opt_province_id"]			= trim($this->input->post("opt_state"));
				$posted["opt_city_id"]				= trim($this->input->post("opt_city"));
				$posted["i_zipcode_id"]				= trim($this->input->post("opt_zip"));
				$posted["chk_supply_material"]		= trim($this->input->post("chk_supply_material"));
				$posted["txt_description"]			= trim($this->input->post("txt_description"));
				$posted["txt_keyword"]				= trim($this->input->post("txt_keyword"));
				$posted["opd_quoting_period_days"]	= trim($this->input->post("opd_quoting_period_days"));
				$posted["txt_budget_price"]			= trim($this->input->post("txt_budget_price"));
				$posted["txt_address"]				= trim($this->input->post("txt_address"));
				
				
               
                $this->form_validation->set_rules('txt_title', addslashes(t('provide job title')), 'required');
				$this->form_validation->set_rules('opd_category_id', addslashes(t('select category')), 'required');
                $this->form_validation->set_rules('opt_state', addslashes(t('select province')), 'required');
				$this->form_validation->set_rules('opt_city', addslashes(t('select city')), 'required');
				//$this->form_validation->set_rules('opt_zip', addslashes(t('select postal code')), 'required');
				$this->form_validation->set_rules('txt_description', addslashes(t('select description')), 'required');
				$this->form_validation->set_rules('txt_keyword', addslashes(t('select keyword')), 'required');
				$this->form_validation->set_rules('txt_address', addslashes(t('provide address')), 'required');
				
				
            
                if($this->form_validation->run() == FALSE)/////invalid
                {			
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
					$info["i_buyer_user_id"]		=	$user_id;
                    $info["s_title"]				=	$posted["txt_title"];
                    $info["i_category_id"]			=	decrypt($posted["opd_category_id"]);
					$info["i_province_id"]			=	decrypt($posted["opt_province_id"]);
					$info["i_city_id"]				=	decrypt($posted["opt_city_id"]);
					$info["i_zipcode_id"]			=	decrypt($posted["i_zipcode_id"]);
					$info["i_supply_material"]		=	$posted["chk_supply_material"];
					$info["s_description"]			=	$posted["txt_description"];
					$info["s_keyword"]				=	$posted["txt_keyword"];
					$info["i_quoting_period_days"]	=	$posted["opd_quoting_period_days"];
					$info["d_budget_price"]			=	$posted["txt_budget_price"];
					$info["i_created_date"]			=	time();	
					
					$info["s_address"]				=	$posted["txt_address"];	
					/* start  latitude and longitude  */
					$province 	= $this->province_model->fetch_this($info["i_province_id"]);
					$city 		= $this->city_model->fetch_this($info["i_city_id"]);
					$zipcode 	= $this->zipcode_model->fetch_this($info["i_zipcode_id"]);
										
					// call geoencoding api with param json for output					
					$address = str_replace(' ','+',$info["s_address"].','.$city['city'].','.$province['province']);							
					$geoCodeURL = "http://maps.google.com/maps/geo?q=".($address)."&output=xml";
				    $data = $this->getURL($geoCodeURL);
					//pr($data,1);														
					$info['s_job_lattitude'] = $data["lat"];
    				$info['s_job_longitude'] = $data["long"];
					
					/* author @ mrinmoy 
					* in case google cant find the lattitude and longitude with address 
					* then find it with city/province
					*/
					if($info['s_job_lattitude']=='' || $info['s_job_longitude']=='')
					{
						$address = str_replace(' ','+',$city['city'].','.$province['province']);
						$geoCodeURL = "http://maps.google.com/maps/geo?q=".($address)."&output=xml";
						$data = $this->getURL($geoCodeURL);
						//pr($data,1);														
						$info['s_job_lattitude'] = $data["lat"];
						$info['s_job_longitude'] = $data["long"];
					}
					/* 
					* in case google cant find the lattitude and longitude with address 
					* then find it with city/province
					*/
					/* end  latitude and longitude  */
					//pr($info,1);
					$arrImg = array();
					//pr($info,1);
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
										  'file_name'	=> $this->imagename.$ext1 ,
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
						
					}	// end of foreach
					
					
					/******* End of upload image *****/
					$jobtotArr	= array('job'=>$info,'img'=>$arrImg,'job_post_session'=>$this->session->userdata('session_id'));
					//pr($jobtotArr,1);					
					$job_id = $this->mod_->set_job_insert_all($jobtotArr);	
					if($job_id)
					{
						  
						  // Send a notification to admin
							$admin_notification	= array();
							$admin_notification['i_user_id'] 			= $user_id;
							$admin_notification['i_user_type'] 			= 1;
							$admin_notification['dt_created_on'] 		= time();
							$admin_notification['i_notification_type'] 	= 1;  
							$admin_notification['s_data1'] 				= $info['s_title'];
							$admin_notification['s_data2'] 				= $user_name ;
							$admin_notification['s_data3'] 				= date($this->config->item('notification_date_format')) ;
							$admin_notification['i_is_read'] 			= 0;
							
							$a_tablename = $this->db->ADMIN_NOTIFICATIONS; 
							$this->load->model('common_model');
							$i_notify = $this->common_model->common_add_info($a_tablename, $admin_notification);
							unset($admin_notification,$a_tablename,$i_notify);
						  // End sending notification to admin
						  
						  
						   $this->load->model('category_model');	
						   $category = $this->category_model->fetch_this($info['i_category_id']);
						   
						   /* for job posting mail to the user */
						   $this->load->model('auto_mail_model');
						   $lang_prefix = $this->data['loggedin']['signup_lang_prefix'];
						   $content 	= $this->auto_mail_model->fetch_mail_content('job_posted','buyer',$lang_prefix);
						   $filename 	= $this->config->item('EMAILBODYHTML')."common.html";
						   $handle 		= @fopen($filename, "r");
						   $mail_html 	= @fread($handle, filesize($filename));	
						   $s_subject 	= $content['s_subject'];	
						   			
							//print_r($content); exit;
							
							if(!empty($content))
								{					
									$description = $content["s_content"];
									$description = str_replace("[BUYER_NAME]",$this->data['loggedin']['user_name'],$description);
									$description = str_replace("[JOB_TITLE]",$info['s_title'],$description);	
									$description = str_replace("[CATEGORY]",$category['s_category_name'],$description);			
								}
							//unset($content);
							
							$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
							$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
							
							//echo "<br>DESC".$mail_html;	exit;
							
							/// Mailing code...[start]
							$site_admin_email = $this->s_admin_email;	
							$this->load->helper('mail');										
							$i_newid = sendMail($this->data['loggedin']['user_email'],$s_subject,$mail_html);	
							/// Mailing code...[end]	
														
							/* end job posting mail to the user */						
							redirect($this->pathtoclass."sucess_job_post");						
					}	
					else
					{
						$this->session->set_userdata(array('job_post_session'=>$jobtotArr));
						$this->session->set_userdata(array('message'=>$this->cls_msg["hold_post"],'message_type'=>'succ'));
						header("Location: ".base_url().'user/registration/'.encrypt(1));
					}
						
               
                    
                }
            }
            ////////////end Submitted Form///////////	
			
			$this->load->model('common_model','mod_common');
			$tablename      =   $this->db->PROVINCE ;
			$arr_where      =   array('i_city_id'=>decrypt($posted["opt_city_id"])) ;
			$info_province  =   $this->mod_common->common_fetch($tablename,$arr_where);
			
			if(!empty($info_province))
			{
				$arr_province   =   array();
				foreach($info_province as $val)
				{
					$arr_province[$val['id']]   =   $val['province'] ; 
				}
			}
			
			$this->data['arr_province'] =   $arr_province ;
			
			/* get zipcode list with selected city and province*/
			   $tablename		=	$this->db->ZIPCODE;
			   $arr_where		=	array('city_id'=>decrypt($posted["opt_city_id"]),'province_id'=>decrypt($posted["opt_province_id"])) ;
			   $info_zipcode  =   $this->mod_common->common_fetch($tablename,$arr_where);
				
				if(!empty($info_zipcode))
				{
					$arr_zipcode   =   array();
					foreach($info_zipcode as $val)
					{
						$arr_zipcode[$val['id']]   =   $val['postal_code'] ; 
					}
				}
				
				$this->data['arr_zipcode'] =   $arr_zipcode ;
				
				/* get zipcode list with selected city and province*/
			
			$this->data['posted'] = $posted;		
			//$this->data['posted'] = $this->session->userdata('arr_reg_value');
			//$this->session->unset_userdata('arr_reg_value');
						
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	public function sucess_job_post()
	{		
		$this->data['breadcrumb'] = array(addslashes(t('Confirmation Page'))=>'');	
		$this->render();
	}
	
	
	public function find_job($i_category_id=0)
	{
		try
		{
			$this->i_footer_menu =4;	
			$this->data['breadcrumb'] = array(addslashes(t('Find Job'))=>'');	
			$this->s_meta_type = 'find_job';			
			
			/**fetch job category **/
		    $this->load->model('category_model');
		    $s_where = " WHERE i_status=1 ";  
		    $this->data['category_list'] =  $this->category_model->fetch_multi($s_where);
			//pr($this->data['category_list'],1);
		    /**end fetch job category **/
			
			/* searching values get from header.tpl.php */
			$srch_str  = trim($this->input->post('txt_fulltext_src'));
			$srch_type = trim($this->input->post('job_select'));
			
			$this->data['srch_str']  = $srch_str;
			$this->data['srch_type'] = $srch_type;			
			/* searching values from header.tpl.php */
			if($srch_str==addslashes(t("What job do you need ?")))
			{
			$srch_str = '';
			}
			if($this->input->post('txt_fulladd_src')!='' && $this->input->post('txt_fulladd_src')!=addslashes(t('Where ?')))
			{
			$srch_addr = trim($this->input->post('txt_fulladd_src'));
			}
			/* keyword cloud search */
			if(!empty($srch_str))
			{
				$arr_key = explode(',',$srch_str);
				if(!empty($arr_key))
				{
					foreach($arr_key as $val)
					{
						/* fetch key already exists */
						$s_table = $this->db->JOBSCLOUDSEARCH;
						$arr_where = array('s_keyword'=>trim($val));
						$i_count = $this->mod_common->common_gettotal_info($s_table,$arr_where);
						if($i_count)
						{	
							$i_new_key = $this->mod_->update_job_cloud_search(trim($val));				
						}
						else
						{
							$arr1 = array();
							$arr1['i_weight'] = 1;
							$arr1['i_created_date'] = time();
							$arr1['s_keyword'] = trim($val);
							$i_new_key = $this->mod_common->common_add_info($s_table,$arr1);
						}
					}
				}
			}
			unset($arr_key,$s_table,$arr_where,$i_count,$arr1,$i_new_key);
			/* end keywords cloud search */
			
			//exit;
			$s_cloud_key = trim($this->input->post('h_keyword'));  // come from home page cloud keys 
			
			$sessArrTmp = array();
			if(decrypt($i_category_id))
			{
				$sessArrTmp['src_job_category_id']  = $i_category_id;
			}
			
			elseif($_POST)
			{
				$sessArrTmp['src_job_keyword'] 	 	= $s_cloud_key?$s_cloud_key:trim($this->input->post('txt_keyword'));
				$sessArrTmp['src_job_fulltext_src'] = $srch_str?$srch_str:"";
				$sessArrTmp['src_job_fulladd_src']  = $srch_addr?$srch_addr:"";
				$sessArrTmp['src_job_category_id']  = (decrypt($i_category_id)) ? $i_category_id : trim($this->input->post('i_category_id'));	
									
				$sessArrTmp['src_job_city_id']		= trim($this->input->post('opt_city_id'));
				$sessArrTmp['txt_city']				= trim($this->input->post('txt_city'));
				
				$sessArrTmp['src_job_status']		= $this->input->post('i_status');
				
			}
			
			
			/* for keyword cloud search from job find page */
			if(!empty($sessArrTmp['src_job_keyword']))
			{
				$arr_key = explode(',',$sessArrTmp['src_job_keyword']);
				if(!empty($arr_key))
				{
					foreach($arr_key as $val)
					{
						/* fetch key already exists */
						$s_table = $this->db->JOBSCLOUDSEARCH;
						$arr_where = array('s_keyword'=>trim($val));
						$i_count = $this->mod_common->common_gettotal_info($s_table,$arr_where);
						if($i_count)
						{	
							$i_new_key = $this->mod_->update_job_cloud_search(trim($val));				
						}
						else
						{
							$arr1 = array();
							$arr1['i_weight'] = 1;
							$arr1['i_created_date'] = time();
							$arr1['s_keyword'] = trim($val);
							$i_new_key = $this->mod_common->common_add_info($s_table,$arr1);
						}
					}
				}
			}
			unset($arr_key,$s_table,$arr_where,$i_count,$arr1,$i_new_key);
			/* end keywords cloud search */
			
			$this->session->set_userdata(array('model_session'=>$sessArrTmp));	// to store data in session
			$this->data['posted'] = $sessArrTmp;
			
			

			ob_start();
			$this->pagination_ajax(0,1);
			$contents = ob_get_contents();
			ob_end_clean();
			$job_contents = explode('^',$contents);
			
			$this->data['job_contents'] = $job_contents[0];
			$this->data['tot_job'] 		= $job_contents[1];
			
			//$this->data['arr_find_job_status'] = $this->db->FINDJOBTYPE;
			$this->render();
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	
	}
	
	
	function pagination_ajax($start=0,$param=0) {	
		$s_where='';
		
		$sessArrTmp['src_job_keyword'] 		= $this->get_session_data('src_job_keyword');
		$sessArrTmp['src_job_fulltext_src'] = $this->get_session_data('src_job_fulltext_src');
		$sessArrTmp['src_job_fulladd_src']  = $this->get_session_data('src_job_fulladd_src');
		$sessArrTmp['src_job_category_id']  = $this->get_session_data('src_job_category_id');
		$sessArrTmp['src_job_city_id'] 		= $this->get_session_data('src_job_city_id');
		$sessArrTmp['src_job_status'] 		= $this->get_session_data('src_job_status');
		
		
		$arr_search[] = " n.i_status!=0 AND n.i_status!=2 AND n.i_is_deleted=0  ";  
		if($sessArrTmp['src_job_keyword']!="")
		{ 
			$sessArrTmp['src_job_keyword'] = preg_replace('/[\s]+/',',',$sessArrTmp['src_job_keyword']);
			$src_key = '';
			$arr_src = explode(',',$sessArrTmp['src_job_keyword']);
			//pr($arr_src);
			if(!empty($arr_src) && is_array($arr_src))
			{
				foreach($arr_src as $val)
				{
				$src_key .= ($src_key)? " OR (n.s_keyword LIKE '%".get_formatted_string($val)."%') " :" n.s_keyword LIKE '%".get_formatted_string($val)."%' ";
					
				}
				$src_key = ($src_key) ? '('.$src_key.')' : '';
				
			}
			
			if(!empty($src_key))
			 $arr_search[] = $src_key ;
			
			//$arr_search[] =" (n.s_keyword LIKE '%".get_formatted_string($sessArrTmp['src_job_keyword'])."%') ";
		}
		if($sessArrTmp['src_job_fulltext_src']!="")
		{
			 $arr_search[] =" (n.s_title LIKE '%".get_formatted_string($sessArrTmp['src_job_fulltext_src'])."%' OR n.s_description LIKE '%".get_formatted_string($sessArrTmp['src_job_fulltext_src'])."%' OR n.s_keyword LIKE '%".get_formatted_string($sessArrTmp['src_job_fulltext_src'])."%') ";
		}			
		if(!empty($sessArrTmp['src_job_fulladd_src']) && $sessArrTmp['src_job_fulladd_src']!=addslashes(t('Where ?')))
		{
			$src_city = '';
			//$src_zip = '';
			$arr_src = explode(',',$sessArrTmp['src_job_fulladd_src']);
			if(!empty($arr_src) && is_array($arr_src))
			{
				foreach($arr_src as $val)
				{
					$src_city .= ($src_city) ? " OR c.city LIKE '%".trim($val)."%' OR z.postal_code = '".trim($val)."' OR s.province LIKE '%".trim($val)."%' " : " c.city LIKE '%".trim($val)."%' OR z.postal_code = '".trim($val)."' OR s.province LIKE '%".trim($val)."%' ";
					
				}
				$src_city = ($src_city) ? '('.$src_city.')' : '';
				
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
		
		/* different job status */
		if(!empty($sessArrTmp['src_job_status']))
		{
			foreach($sessArrTmp['src_job_status'] as $val)
			{
				if($val==1)  
				{
					$arr_search[] =" n.i_status =1 ";
				}
				if($val==2)  
				{
					$arr_search[] =" (n.i_status=3 OR n.i_status=8) ";
				}
				if($val==3)  
				{
					$arr_search[] =" (n.i_status=4 OR n.i_status=5 OR n.i_status=9 OR n.i_status=11) ";
				}
				if($val==4)  
				{
					$arr_search[] =" n.i_status=6 ";
				}
			}
		}
		/* different job status */
		
		
		$s_where .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';

		$limit	=  $this->i_fe_page_limit;
		//echo $s_where;
		$this->data['job_list']	= $this->mod_->fetch_multi_completed($s_where,intval($start),$limit);		
		
		$total_rows = $this->mod_->gettotal_info($s_where);	
		
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'job/pagination_ajax/';
		$paging_div = 'job_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		//$this->load->view('fe/job/ajax_job_list.tpl.php', $this->data);
		if(empty($param))
			$job_vw = $this->load->view('fe/job/ajax_job_list.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/job/ajax_job_list.tpl.php',$this->data,TRUE).'^'.$total_rows;
		echo $job_vw;
		/* pagination end */

	
	}	
	
	
	
	function job_details($job_id='')
	{
		try
		{
			
			$job_id = decrypt($job_id);
			$this->data['breadcrumb'] = array(addslashes(t('Job Details'))=>'');
			$this->s_meta_type = 'job_details';
			
			$this->data['job_details'] = $this->mod_->fetch_this($job_id);
			//pr($this->data['job_details'],1);
			$this->load->model('manage_buyers_model');
			if(empty($this->data['job_details']))
			{
				$this->session->set_userdata(array('message'=>$this->cls_msg["job_find_err"],'message_type'=>'err'));
				redirect(base_url().'home/message');
			}
			$s_where = " WHERE n.i_city_id={$this->data['job_details']['i_city_id']} AND n.id!={$job_id} AND n.i_status=1 AND n.i_is_deleted!=1 "; 
			$this->data['similar_jobs'] = $this->mod_->fetch_multi_completed($s_where,0,5);	
			//pr($this->data['similar_jobs']);	
			$s_wh	= " WHERE n.i_job_id = ".$job_id." ";
			$this->data['latest_quotes'] = $this->mod_->fetch_quote_multi($s_wh,0,5);
			//pr($this->data['latest_quotes'],1);	
			
			/*$this->data['user_details'] = $this->manage_buyers_model->fetch_this($this->data['job_details']['i_buyer_user_id']);			
			$s_cond = " WHERE n.i_buyer_user_id=".$this->data['job_details']['i_buyer_user_id']." And n.i_status>=4 ";
			$this->data['i_total_awarded_job'] = $this->job_model->gettotal_info($s_cond);
			$this->data['user_path'] = $this->config->item('user_profile_image_thumb_upload_path');
			$this->data['user_url_path'] = $this->config->item('user_profile_image_thumb_path');*/
			
			$this->data['job_id']	=	$job_id ;
            
            
           
			
			$this->render();	
			unset($s_cond,$s_where,$s_wh);	
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	
	}
	
	
	function save_quote_job()
	{
		if($_POST)
		{
			$posted=array();
            $posted["txt_quote"] 	= trim($this->input->post("txt_quote"));
			$posted["ta_message"] 	= trim($this->input->post("ta_message"));
			$i_job_id 				= $this->input->post("h_job_id");
		   	$i_tradesman_user_id 	=  decrypt($this->data['loggedin']['user_id']);
			
			// Remove email address from content......
			 $posted["ta_message"] = preg_replace('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/','',$posted["ta_message"]); 
			// Remove website address from content......
             $posted["ta_message"] = preg_replace('/([a-z0-9_-]+\.)*[a-z0-9_-]+(\.[a-z]{2,6}){1,2}/','',$posted["ta_message"]);  
			
			//pr($this->data['loggedin'],1);
			if(!empty($this->data['loggedin']) && decrypt($this->data['loggedin']['user_type_id'])==2)
			{
				$s_table = $this->db->TRADESMAN_MEMBERSHIP;
				$arr_where = array('i_tradesman_id'=>$i_tradesman_user_id,'i_status'=>1);
				$res_arr = $this->mod_common->common_fetch($s_table,$arr_where,0,1);
				$i_remain_quote = ($res_arr[0]['i_quotes']-$res_arr[0]['i_quotes_placed']);
				if($i_remain_quote>0)  // checking if quotes remain for the tradesman or not
				{
				$s_where = " WHERE i_tradesman_user_id={$i_tradesman_user_id} AND i_job_id={$i_job_id} AND i_status=1";
				$i_quote = $this->mod_->gettotal_job_quote_info($s_where);
				if($i_quote)
				{
					$msg = '2|'.$this->cls_msg["exists_quote_err"];
				}
				else
				{
					
					$info=array();
					$info["i_tradesman_user_id"]	=	$i_tradesman_user_id;
					$info["i_job_id"]				=	$i_job_id;
					$info["d_quote"]				=	$posted["txt_quote"];
					$info["s_comment"]				=	$posted["ta_message"];
					$info["i_created_date"]			=	time();	
					//pr($info,1);				
					$i_newid = $this->mod_->job_quote($info);
					//$i_newid = true;
					if($i_newid)////saved successfully
					{
						/* insert data to job history and status change*/
						$arr1 = array();
						$arr1['i_job_id']  =  $i_job_id;
						$arr1['i_user_id'] =  $i_tradesman_user_id;
						$arr1['s_message'] =  'job_placed_quote';
						$arr1['i_created_date'] =  time();
						$table = $this->db->JOB_HISTORY;
						$this->mod_->set_data_insert($table,$arr1);	
						/* end insert data to job history and stattus change */	
						
						/* update tradesman member table with total quote placed */
						$i_placed_quote = $this->mod_->update_tradesman_member_placed_quote($i_tradesman_user_id);
						/* end update tradesman member table with total quote placed */
						
						
						/* insert data tradesman action history table */
						$arr2 = array();
						$arr2['i_user_id'] 		= $i_tradesman_user_id;
						$arr2['i_job_id'] 		= $i_job_id;
						$arr2['s_action']  		= 'quote_placed';
						$arr2['i_created_date']	= time();
						$table_history = $this->db->TRADESMANHISTORY;
						$this->mod_->set_data_insert($table_history,$arr2);
						unset($table_history,$arr2);						
						/* insert data tradesman action history table */
						
						
						$this->load->model('tradesman_model','mod_td');
					    $this->load->model('manage_buyers_model');
					    $job_details 		= $this->mod_->fetch_this($i_job_id);
					    $tradesman_details 	= $this->mod_td->fetch_this($i_tradesman_user_id);
					    $buyer_details 		= $this->manage_buyers_model->fetch_this($job_details['i_buyer_user_id']);
						
						
						$tablename  =   $this->db->JOBS ;
						$s_where    =   " WHERE i_tradesman_id=".$i_tradesman_user_id." AND i_status!=8 "  ;  
						$won_jobs   =   $this->mod_common->common_count_rows($tablename,$s_where);
						
						$s_table  =   $this->db->JOBFEEDBACK;
						$s_wh = " WHERE i_receiver_user_id = ".$i_tradesman_user_id." AND i_status !=0 "; 
						$feedback = $this->mod_common->common_count_rows($s_table,$s_wh);
					   //print_r($tradesman_details); 
					   //print_r($buyer_details); exit;
					  /**************************** Send a notification to admin ************************/
						$admin_notification	= array();
						$admin_notification['i_user_id'] 			= $i_tradesman_user_id;
						$admin_notification['i_user_type'] 			= 1;
						$admin_notification['dt_created_on'] 		= time();
						$admin_notification['i_notification_type'] 	= 2;  
						$admin_notification['s_data1'] 				= $tradesman_details['s_username'];
						$admin_notification['s_data2'] 				= $job_details['s_title'];
						$admin_notification['s_data3'] 				= date($this->config->item('notification_date_format')) ;
						$admin_notification['i_is_read'] 			= 0;
						
						$a_tablename = $this->db->ADMIN_NOTIFICATIONS; 
						$this->load->model('common_model');
						$i_notify = $this->common_model->common_add_info($a_tablename, $admin_notification);
						unset($admin_notification,$a_tablename,$i_notify);
						 /**************************** End Send a notification to admin ************************/
					  
					  
					    $this->load->model('manage_buyers_model');	
					    $s_wh_id = " WHERE n.i_user_id=".$job_details['i_buyer_user_id']." ";
					    $email_key = $this->manage_buyers_model->fetch_email_keys($s_wh_id);
					    $is_mail_need = in_array('tradesman_placed_quote',$email_key);
						
						if($is_mail_need)
						{
						     $this->load->model('auto_mail_model');
							 $lang_prefix = $this->data['loggedin']['signup_lang_prefix'];
						     $content = $this->auto_mail_model->fetch_mail_content('tradesman_placed_quote','buyer',$lang_prefix);
							 $filename 	= $this->config->item('EMAILBODYHTML')."common.html";
							 $handle 	= @fopen($filename, "r");
							 $mail_html = @fread($handle, filesize($filename));	
							 $s_subject = $content['s_subject'];					
							//print_r($content); exit;
							if(!empty($content))
							{			
								$description = $content["s_content"];
								$description = str_replace("[BUYER_NAME]",$job_details['s_buyer_name'],$description);
								$description = str_replace("[JOB_TITLE]",$job_details['s_title'],$description);	
								$description = str_replace("[TRADESMAN_NAME]",$tradesman_details['s_username'],$description);
								$description = str_replace("[LOGIN_URL]",base_url().'user/login/TVNOaFkzVT0',$description);		
								$description = str_replace("[TRADE_URL]",base_url().'tradesman-profile/'.encrypt($tradesman_details['id']),$description);	
								$description = str_replace("[SERVICE_CITY]",$tradesman_details['s_city_name'],$description);	
								$description = str_replace("[REGISTRATION_DATE]",$tradesman_details['dt_created_on'],$description);	
								$description = str_replace("[JOB_WON]",$won_jobs,$description);
								$description = str_replace("[FEEDBACKS]",$feedback,$description);		
								$description = str_replace("[ABOUT_TRADESMAN]",$tradesman_details['s_about_me'],$description);	
								$description = str_replace("[site_url]",base_url(),$description);						
							}
							//unset($content);
							
							$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
							$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
							//echo "<br>DESC".$mail_html;	exit;
							
							/// Mailing code...[start]
							$site_admin_email = $this->s_admin_email;	
							$this->load->helper('mail');										
							$i_newid = sendMail($buyer_details['s_email'],$s_subject,$mail_html);	
							/// Mailing code...[end]
							
							/* end job quote mail to the user */									
						}	
											
						$msg = '1|'.$this->cls_msg["save_quote"];
					}
					else	///Not saved, show the form again
					{
						$msg = '2|'.$this->cls_msg["save_quote_err"];
					}
				}
				}
				else
				{
					$msg = '2|'.$this->cls_msg["quote_exceed"];
				}
			} // loggedin and tradesman checking end
			
			else   // login and not a tradesman error
			{
				$msg = '2|'.$this->cls_msg["buyer_quote_err"];
			}
		}
		echo $msg;	
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
	function download_job_files($s_file_name)
	{
		try
		{
			$this->load->helper('download');
			$data = $this->config->item('job_file_upload_path'); // Read the file's contents
			$name = decrypt($s_file_name);			
			$fullpath = file_get_contents($data.$name);
			//echo $fullpath;
			force_download($name, $fullpath); 			
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	}
    
    function ajax_buy_contact()
    {
        try
        {
            if($_POST)
            {
                $buyer_id       =   trim($this->input->post('buyer_id'));
                
                $user_details   =   $this->data['loggedin'] ;
                
                if(empty($user_details) || decrypt($user_details['user_type_id'])!=2)
                {
                    echo 'login_error';
                }
                else
                {
                    $tablename  =   $this->db->TRADESMAN_CONTACTLIST ;
                    $s_where    =   " WHERE i_tradesman_id=".decrypt($user_details['user_id'])." AND i_buyer_id=".decrypt($buyer_id) ;
                    $total_rows                 = $this->mod_common->common_count_rows($tablename,$s_where);
                    if($total_rows>0)
                    {
                        echo 'error_exist' ;
                        
                    }
                    else
                    {
                        $i_tradesma_id  =   decrypt($user_details['user_id']) ;
                        $s_table = $this->db->TRADESMAN_MEMBERSHIP;
                        $arr_where = array('i_tradesman_id'=>$i_tradesma_id,'i_status'=>1);
                        $info_membership = $this->mod_common->common_fetch($s_table,$arr_where);
                       

                        if(!empty($info_membership) && count($info_membership))
                        {
                            $i_remain_quote = ($info_membership[0]['i_contact_info']-$info_membership[0]['i_contact_purchased']);
                            if($i_remain_quote==0)
                            {
                                echo 'no_left_error';    
                            }
                            else
                            {
                                $info       =   array();
                                $info['i_tradesman_id']     =   $i_tradesma_id;
                                $info['i_buyer_id']         =   decrypt($buyer_id);
                                $info['i_payment_type']     =   1;
                                $info['i_status']           =   1;
                                $info['dt_created_on']      =   time();
                                
                                $this->load->model('tradesman_model','mod_td');
                                   
                                $i_aff  =   $this->mod_td->add_contactlist($info) ;
                                if($i_aff)
                                {
                                    echo 'ok' ;
                                }

                            }
                        }
                        else
                        {
                            echo 'error';
                        }

                        unset($s_table,$arr_where,$info_membership);
                    }
                }
              
                
            }
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    
    public function payment_tradesman_contactlist($enc_buyer_id='')
    {
        try
        {
                //echo 'i m here'.$enc_buyer_id ;
                
                $user_details   =   $this->data['loggedin'] ;
                
                $this->load->model('tradesman_model','mod_td');
                $s_where    =   ' WHERE tm.i_tradesman_id='.decrypt($user_details['user_id']).' AND tm.i_status=1 ';
                $info_membership    =   $this->mod_td->fetch_tradesman_membership_plan($s_where);
                
                if(!empty($info_membership) && count($info_membership))
                {
                    $d_amount   =   $info_membership[0]['d_additional_contact_price'];
                }
                
                if($d_amount>0)
                {
                    $user_details   =   $this->data['loggedin'] ;
                    $this->load->model('site_setting_model');
                    $site_settings = $this->site_setting_model->fetch_this(1);
                    include_once(APPPATH.'libraries/paypal_IPN/paypal.class.php');    
                    $data['title'] = t("Payment");
                    
                    $PAYPAL_ENVIRONMENT = 'test';
                    $LOGGED_USR_ID = $user_details['user_id'];
                    $TOTAL_AMOUNT  = $d_amount;  // Fetched Amount 
                    $SHIPPING_AMOUNT = 0;
                    
                    $IPN_OBJ = new paypal_class;     // initiate an instance of the IPN class...
                    $IPN_OBJ->paypal_url = $this->config->item('paypal_url');//$this->site_settings_model->getPaypalURL($PAYPAL_ENVIRONMENT);
                    $IPN_OBJ->add_field('cmd', '_cart');
                    $IPN_OBJ->add_field('upload', 1);
                    $IPN_OBJ->add_field('business', $site_settings['s_paypal_email']);
                    
                    
                    $data['paypal_obj'] = $IPN_OBJ;
                    $data['cart_contents'] = $CART_CONTENTS_ARR;

                    # fixing shipping amount etc...
                    
                    $TOTAL_AMOUNT = $TOTAL_AMOUNT + $SHIPPING_AMOUNT;
                    $data['total_charge'] = $TOTAL_AMOUNT;
                    $data['shipping_charge'] = $SHIPPING_AMOUNT;
                    $data['paypal_account'] = $site_settings['s_paypal_email'];
                    $data['user_id']    = $LOGGED_USR_ID;
                    $data['buyer_id']   = $enc_buyer_id;

                    $data['item_name'] = 'Contact info payment';
                    
                    $data['currency'] = $this->config->item('default_currency_code');
                    $this->session->set_userdata(array('ses_data_temp'=>$data));
                    //print_r($this->session->userdata('ses_data_temp')); exit;
                    $this->load->view('fe/job/place_paypal_order.tpl.php', $data);
                }
           
                
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    function payment_success_contact()
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
            
                    $payment_details   =   $this->session->userdata('ses_data_temp') ;
                    
                 
                    $info       =   array();
                    $info['i_tradesman_id']     =   decrypt($payment_details['user_id']);
                    $info['i_buyer_id']         =   decrypt($payment_details['buyer_id']);
                    $info['i_payment_type']     =   1;
                    $info['i_status']           =   1;
                    $info['dt_created_on']      =   time();
                    
                    $this->load->model('tradesman_model','mod_td');
                       
                    $i_aff  =   $this->mod_td->add_contactlist($info,false) ;
                   
                    if($i_aff)
                    {
                        
                        $info       =   array();
                        $info['i_contactlist_id']   =   $i_aff ;
                        $info['d_amount']           =   $payment_details['total_charge'] ;  
                        $info['dt_created_on']      =   time();
                        
                        $tablename  =   $this->db->CONTACTLIST_PAYMENT ;
                        $this->mod_common->common_add_info($tablename,$info) ;
                        
                        $this->session->set_userdata(array('message'=>$this->cls_msg["contact_payment_succ"],'message_type'=>'succ'));
                       
                        redirect(base_url().'tradesman/dashboard'); 
                    }

      
	
	}
	
	
	/** 
    * This is a ajax function to fetch profile details of buyer
    * and display in a light box
    * added by mrinmoy
    *  
    */
    public function ajax_fetch_buyer_profile()
    {
        try
        {
           if($_POST)
           {
               $enc_buyer_id  =   trim($this->input->post('buyer_id'));
			   $this->load->model('manage_buyers_model','mod_buyer');      
               $buyer_details = $this->mod_buyer->fetch_this(decrypt($enc_buyer_id)); 
               //pr($buyer_details,1);
               if(!empty($buyer_details)) 
               {
			   	   $img = showThumbImageDefault('user_profile',$buyer_details['s_image'],'no_image_man.png',65,65);
				   
                   $str =   '';
                       
				   $str .=   ' <div class="lable02">'.addslashes(t('Buyer')).' </div>
				  <div class="textfell">'.$img.'</div>
				  <div class="spacer"></div>
				  <div class="lable02"></div>
				  <div class="textfell"><strong>'.$buyer_details['s_username'].'</strong></div>
				  <div class="spacer"></div>
				  <div class="lable02">'.addslashes(t('Member since')).' </div>
				  <div class="textfell">'.$buyer_details['dt_created_on'].'</div>
				  <div class="spacer"></div>
				  <div class="lable02">'.addslashes(t('Total no of job posted')).' </div>
				  <div class="textfell">'.$buyer_details['i_total_job_posted'].'</div>
				  <div class="spacer"></div>
				  <div class="lable02">'.addslashes(t('Total number of job awarded')).' </div>
				  <div class="textfell">'.$buyer_details['i_total_job_awarded'].'</div>' ;
                  
               }
               else
               {
                   $str =   ' <p> '.addslashes(t('No item found')).'</p>' ;
               }
               unset($buyer_details,$s_where,$enc_buyer_id);
               echo $str ;

           }
		   
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    function ajax_delete_invitation()
    {
        try
        {
            if($_POST)
            {
                $posted['i_job_id']   =   decrypt(trim($this->input->post('job_id'))) ;
                
                $i_aff  =   0 ;
                if(!empty($this->data['loggedin']))
                {
                    $posted['i_tradesman_id'] =   decrypt($this->data['loggedin']['user_id']) ;
                    $i_aff  =   $this->mod_->delete_invitation($posted);
                }
                if($i_aff)
                {
                    $this->session->set_userdata(array('message'=>$this->cls_msg["invitation_delete_succ"],'message_type'=>'succ'));
                    echo 'ok';
                }
                else
                {
                    echo 'error';
                }
                unset($posted);

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
			
    public function __destruct()

    {}           

}



/* End of file welcome.php */

/* Location: ./system/application/controllers/welcome.php */

