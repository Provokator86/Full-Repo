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
			$this->i_menu_id = 2;		
			$this->data['breadcrumb'] = array('Post a Job'=>'');
			$this->add_css('css/fe/dd.css');
			$this->add_js('js/fe/jquery.dd.js');
			$o_ci = &get_config();	
			////////////Submitted Form///////////
			$user_id = decrypt($this->data['loggedin']['user_id']);	
			
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
			
               
                $this->form_validation->set_rules('txt_title', 'job title', 'required');
				$this->form_validation->set_rules('opd_category_id', 'select category', 'required');
                $this->form_validation->set_rules('opt_state', 'select province', 'required');
				$this->form_validation->set_rules('opt_city', 'select city', 'required');
				$this->form_validation->set_rules('opt_zip', 'select postal code', 'required');
				$this->form_validation->set_rules('txt_description', 'select description', 'required');
				$this->form_validation->set_rules('txt_keyword', 'select keyword', 'required');
				$this->form_validation->set_rules('opd_quoting_period_days', 'select quote period days', 'required');

              
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
					$job_id = $this->mod_->set_job_insert_all($jobtotArr);	
					if($job_id)
						redirect($this->pathtoclass."sucess_job_post");
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
			$this->data['breadcrumb'] = array('Find Job'=>'');	
			$this->add_css('css/fe/dd.css');
			$this->add_js('js/fe/jquery.dd.js');
			$this->load->model('zipcode_model');

			/**fetch job category **/
		    $this->load->model('category_model');
		    $s_where = " WHERE s_category_type='job' and i_status=1"; 
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
			else
			{
				$sessArrTmp['src_job_fulltext_src'] = $this->get_session_data('src_job_fulltext_src');
				$sessArrTmp['src_job_fulladd_src']  = $this->get_session_data('src_job_fulladd_src');
				$sessArrTmp['src_job_category_id']  = (decrypt($i_category_id)) ? $i_category_id : $this->get_session_data('src_job_category_id');
				$sessArrTmp['src_job_radius'] 		= $this->get_session_data('src_job_radius');
				$sessArrTmp['src_job_city_id'] 		= $this->get_session_data('src_job_city_id');
				$sessArrTmp['src_job_postal_code']  = $this->get_session_data('src_job_postal_code');
				$sessArrTmp['src_job_status'] 		= $this->get_session_data('opt_job_status');
				$sessArrTmp['src_job_record'] 		= $this->get_session_data('opt_job_record');
			}
			
			$this->data['i_category_id'] = $sessArrTmp['src_job_category_id'];
			$s_where="";
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
			if($sessArrTmp['src_job_status'])
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
			$this->data['posted'] = $sessArrTmp;
			
			$start = 0;
			$limit	= ($sessArrTmp['src_job_record']) ? decrypt($sessArrTmp['src_job_record']) : $this->i_admin_page_limit;
            $this->data['job_list']	= $this->mod_->fetch_multi($s_where,intval($start),$limit);		
			$this->data['tot_job']	= count($this->data['job_list']	);		
			
			//$this->session->set_userdata(array('model_session'=>$sessArrTmp));	
			$this->render();
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	
	}
	
	public function sucess_job_post()
	{	
		$this->i_menu_id = 2;		
		$this->data['breadcrumb'] = array('Confirmation Page'=>'');	
		$this->render();
	}
		
    public function __destruct()

    {}           

}



/* End of file welcome.php */

/* Location: ./system/application/controllers/welcome.php */

