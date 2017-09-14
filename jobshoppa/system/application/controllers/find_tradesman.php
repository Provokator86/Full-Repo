<?php
/********* 
* Author: Samarendu Ghosh
* Date  : 18 Oct 2011
* Modified By: 
* Modified Date: 
* 
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class Find_tradesman extends My_Controller  
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
        try
        { 
          parent::__construct(); 
          $this->data['title']="Find a Professional";////Browser Title
		  $this->data['ctrlr'] = "home";
		  
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  $this->load->model('tradesman_model','mod_');
		  $this->load->model('zipcode_model');
		  $this->load->model("Manage_feedback_model","mod_feed");
		  $this->cls_msg["job_find_err"] = "Professional not found.";
		  $this->cls_msg["tradesman_tradesman_post_err"] = 'Only Client can post job.';
		  $this->data['i_lang_id'] = $this->i_default_language;
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
    public function index($i_category_id='')
    {
        try
        {
			$this->i_menu_id = 4;		
			$this->data['breadcrumb'] = array('Find a Professional'=>'');	
			$this->s_meta_type = 'find_professional';
			$this->add_css('css/fe/dd.css');
			$this->add_js('js/fe/jquery.dd.js');

			/**fetch job category **/
		    $this->load->model('category_model');
		    //$s_where = " WHERE s_category_type='job' and i_status=1  AND cc.i_lang_id =".$this->i_default_language;  
			$s_where = " WHERE s_category_type='job' and i_status=1  ";  
		    $this->data['category_list'] =  $this->category_model->fetch_multi($s_where,0,20);
		    /**end fetch job category **/
			
			$sessArrTmp = array();
			if(decrypt($i_category_id))
			{
				$sessArrTmp['src_tradesman_category_id']  = $i_category_id;
			}
			elseif($_POST)
			{
				$sessArrTmp['src_tradesman_fulltext_src'] = trim($this->input->post('txt_fulltext_src'));
				$sessArrTmp['src_tradesman_fulladd_src']  = trim($this->input->post('txt_fulladd_src'));
				
				$sessArrTmp['src_tradesman_category_id']  = (decrypt($i_category_id))? $i_category_id : trim($this->input->post('i_category_id'));	
				$sessArrTmp['src_tradesman_radius'] 		= trim($this->input->post('opt_radius'));					
				$sessArrTmp['src_tradesman_city_id']		= trim($this->input->post('opt_city_id'));
				$sessArrTmp['txt_city']						= trim($this->input->post('txt_city'));
				$sessArrTmp['src_tradesman_postal_code'] 	= trim($this->input->post('txt_postal_code'));
				$sessArrTmp['src_tradesman_status'] 	 	= trim($this->input->post('opt_status'));
				$sessArrTmp['src_tradesman_record'] 	 	= trim($this->input->post('opt_record'));	
				$sessArrTmp['src_tradesman_sort'] 	 		= trim($this->input->post('opt_sort'));	
			}
			//pr($_POST); exit;
			$this->session->set_userdata(array('model_session'=>$sessArrTmp));	// to store data in session
			$this->data['posted'] = $sessArrTmp;
			//pr($this->data['posted']); exit;
			

			ob_start();
			$this->pagination_ajax(0,1);
			$contents = ob_get_contents();
			ob_end_clean();
			$job_contents = explode('^',$contents);
			
			$this->data['job_contents'] = $job_contents[0];
			$this->data['tot_job'] 		= $job_contents[1];
			
			
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	

	
	
	
	
	function pagination_ajax($start=0,$param=0) {
		$s_where='';
		$orderbyArry = array(0=>'n.s_name',1=>'td.i_feedback_rating',2=>'td.i_jobs_won');
		$sessArrTmp['src_tradesman_fulltext_src'] = $this->get_session_data('src_tradesman_fulltext_src');
		$sessArrTmp['src_tradesman_fulladd_src']  = $this->get_session_data('src_tradesman_fulladd_src');
		$sessArrTmp['src_tradesman_category_id']  = $this->get_session_data('src_tradesman_category_id');
		$sessArrTmp['src_tradesman_radius'] 		= $this->get_session_data('src_tradesman_radius');
		$sessArrTmp['src_tradesman_city_id'] 		= $this->get_session_data('src_tradesman_city_id');
		$sessArrTmp['src_tradesman_postal_code']  = $this->get_session_data('src_tradesman_postal_code');
		$sessArrTmp['src_tradesman_status'] 		= $this->get_session_data('src_tradesman_status');
		$sessArrTmp['src_tradesman_record'] 		= $this->get_session_data('src_tradesman_record');
		$sessArrTmp['src_tradesman_sort'] 			= $this->get_session_data('src_tradesman_sort');
		
		$arr_search[] = " n.id!=0 AND n.i_is_active=1";
		if($sessArrTmp['src_tradesman_fulltext_src']!="")
		{
			 $arr_search[] =" (n.s_name LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_fulltext_src'])."%' OR n.s_username LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_fulltext_src'])."%' OR td.s_qualification LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_fulltext_src'])."%' OR td.s_skills LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_fulltext_src'])."%' OR td.s_about_me LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_fulltext_src'])."%') ";
		}			
		if(!empty($sessArrTmp['src_tradesman_fulladd_src']))
		{
			$src_city = '';
			//$src_zip = '';
			$arr_src = explode(',',$sessArrTmp['src_tradesman_fulladd_src']);
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
		
		if($sessArrTmp['src_tradesman_category_id'] && $sessArrTmp['src_tradesman_category_id']!=t('All'))
		{
			$arr_search[] =" tc.i_category_id=".decrypt($sessArrTmp['src_tradesman_category_id']);
		}	
		if($sessArrTmp['src_tradesman_city_id'])
		{
			$arr_search[] =" n.i_city=".decrypt($sessArrTmp['src_tradesman_city_id']);
		}	
		/*if($sessArrTmp['src_tradesman_status'])
		{
			$arr_search[] =" n.i_status=".decrypt($sessArrTmp['src_tradesman_status']);
		}*/
		if($sessArrTmp['src_tradesman_radius'] && $sessArrTmp['src_tradesman_postal_code'])
		{
			$zipcode = $this->zipcode_model->fetch_multi(" WHERE n.postal_code='{$sessArrTmp['src_tradesman_postal_code']}'");
			if(!empty($zipcode))
			 {
				$lat = $zipcode[0]['latitude'];
				$lng = $zipcode[0]['longitude'];
				//$job_radius = intval(decrypt($sessArrTmp['src_tradesman_radius']));
				$job_radius = (intval(decrypt($sessArrTmp['src_tradesman_radius']))*10)+10;
				//echo $job_radius.'======'.decrypt($sessArrTmp['src_tradesman_radius']);
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
				$arr_search[] =" z.postal_code='{$sessArrTmp['src_tradesman_postal_code']}'";						
		}	
		elseif($sessArrTmp['src_tradesman_postal_code'])
		{
			$arr_search[] =" z.postal_code='{$sessArrTmp['src_tradesman_postal_code']}'";
		}
	 	$s_where .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
		

		$limit	= ($sessArrTmp['src_tradesman_record']) ? decrypt($sessArrTmp['src_tradesman_record']) : $this->i_fe_page_limit;
			
		
		$orderby = !empty($sessArrTmp['src_tradesman_sort'])?$orderbyArry[$sessArrTmp['src_tradesman_sort']]:$orderbyArry[1];		
		
		//echo $s_where;
		$tradesman_list	= $this->mod_->fetch_featured($s_where,$orderby,intval($start),$limit);		
		
		//print_r($tradesman_list);exit;
		
		$total_rows = $this->mod_->gettotal_info($s_where);	
		
		
		if($total_rows > 0)
		{
			for($i = 0;$i<count($tradesman_list);$i++) 
			{
				$s_where = " WHERE n.i_receiver_user_id = ".$tradesman_list[$i]['id']." AND n.i_status !=0 "; 
				$feedback = $this->mod_feed->fetch_multi($s_where,$i_start=0,$i_limit=1);
			
				$tradesman_list[$i]['feedback'] = $feedback[0];
			}
		
		}
		
	//	echo $limit.'--'. $start;
		$this->data['tradesman_list'] = $tradesman_list;
		
		//pr($this->data['tradesman_list']);exit;
		
		$this->data['tot_prof'] = $total_rows;
		
		//pr($this->data['tradesman_list']);
		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'find_tradesman/pagination_ajax/';
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
	
		$config['div'] = '#tradesman_list';
		//$config['js_bind'] = "showLoading();";
		//$config['js_rebind'] = "hideLoading();";
		//$config['js_rebind'] = "alert(data);";

		$this->jquery_pagination->initialize($config);
		//$this->data['page_links'] = preg_replace('/<delete>.*?<\/delete>/s','',$this->jquery_pagination->create_links());
		$this->data['page_links'] = $this->jquery_pagination->create_links();
		$this->data['total_rows'] = $total_rows;
		//$this->data['current_page'] = $page;
		
		$this->data['image_path'] = $this->config->item("user_profile_image_thumb_path");
		$this->data['image_up_path'] = $this->config->item("user_profile_image_thumb_upload_path");
		//$this->data['current_page'] = $page;
		if(empty($param))
			$job_vw = $this->load->view('fe/find_tradesman/ajax_tradesman_list.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/find_tradesman/ajax_tradesman_list.tpl.php',$this->data,TRUE).'^'.$total_rows;
		echo $job_vw;		
	}	
	
	
	
	public function tradesman_profile($id)
	{
		try
		{
			if(empty($id))
				redirect(base_url());
				
			$this->data['breadcrumb'] = array('Professional Profile'=>'');	
			/**fetch job category **/
		    $this->load->model('category_model');
		    $s_where = " WHERE s_category_type='job' and i_status=1  ";  
		    $this->data['category_list'] =  $this->category_model->fetch_multi($s_where);
		    /**end fetch job category **/
			
			$info = $this->mod_->fetch_this(decrypt($id),$this->i_default_language);
			
			//pr($info,1);
			/********** Trades man album **************/
			$this->load->model('Manage_tradesman_model',"mod_trade");
			$s_where = " WHERE n.i_user_id = ".decrypt($id);
			$album_list = $this->mod_trade->get_album_images($s_where,0,5);
			//pr($album_list);
			$this->data['album_list'] = $album_list;
			$this->data['album_image_thumb_path'] = $this->config->item("trades_album_image_thumb_path");
			$this->data['album_image_path'] = $this->config->item("trades_album_image_path");
			$this->data['album_image_up_path'] = $this->config->item("trades_album_image_thumb_upload_path");	

			/********** END Trades man album **************/
			$s_where = " WHERE n.i_receiver_user_id = ".decrypt($id)." AND n.i_status != 0 "; 
			$feedback = $this->mod_feed->fetch_multi($s_where);
			//pr($feedback);
			$this->data['profile_info'] = $info;
			//pr($this->data['profile_info']);
			$this->data['feedback_info'] = $feedback;
			//pr($this->data['feedback_info']);
			$this->data['img_path'] = $this->config->item("user_profile_image_path");
			$this->data['image_path'] = $this->config->item("user_profile_image_thumb_path");
			$this->data['image_up_path'] = $this->config->item("user_profile_image_thumb_upload_path");	
			$this->data['origin_image_path'] = $this->config->item("user_profile_image_upload_path");
			$this->data['slider_image_up_path'] = base_url().'uploaded/user/thumb/';		
			//pr($this->data['profile_info']);
			
			ob_start();
			$this->pagination_feedback_ajax($id,0,1);
			$contents = ob_get_contents();
			ob_end_clean();
			
			
			$this->data['feedback_contents'] = $contents;
			
			//var_dump(count($this->data['feedback_contents'] ));exit;
				
			$this->render();
			
		}
		catch(Exception $e)
		{
			show_error($e->getMessage());
		}
	}
	
	
	public function pagination_feedback_ajax($s_id,$start=0,$param=0) {
		$limit	= $this->i_fe_page_limit;
	//	$limit = 2;
		$s_where = " WHERE n.i_receiver_user_id = ".decrypt($s_id)." AND n.i_status != 0 AND n.i_feedback_complete_status=1"; 
		$feedback = $this->mod_feed->fetch_multi($s_where,intval($start),$limit);
		
		$total_rows = $this->mod_feed->gettotal_info($s_where);	
		//pr($feedback);
		//echo $total_rows;
		
		$this->data['feedback_list'] = $feedback;
		//pr($this->data['feedback_list']);
		$this->load->library('jquery_pagination');
		$config['base_url'] = base_url().'find_tradesman/pagination_feedback_ajax/'.$s_id.'/';
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
	
		$config['div'] = '#div22';
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
	
	
	
	
	
	
	
	
	
	
	public function invite_tradesman($id)
	{
		/******* Invite Tradesman **********/
			$loggedin = FALSE;
			$is_buyer = FALSE;
			
			if($this->data['loggedin'])
			{
				$loggedin = TRUE;
				if(decrypt($this->data['loggedin']['user_type_id']) == 1)
				{
					$this->load->model("manage_jobs_model","mod_job");
					$s_where = " WHERE  n.i_is_deleted != 1 AND n.i_status = 1 AND n.i_buyer_user_id = ".decrypt($this->data['loggedin']['user_id']) ;
					$this->data['jobs'] = $this->mod_job->fetch_multi($s_where);
					//pr($this->data['jobs']);
					$is_buyer = TRUE;
				}
				
			}
			$this->data['is_loggedin'] = $loggedin;
			$this->data['is_buyer'] = $is_buyer;
			$this->data['tradesman_id'] = decrypt($id);
			
			$invite_vw = $this->load->view('fe/find_tradesman/invite_tradesman.tpl.php',$this->data,TRUE);
		//	$this->render();
			echo $invite_vw;
			/****************/
	}
	public function do_tradesman_invite()
	{
		try
		{
			if($_POST)
			{
				
				$arr_jobs_id = explode(",",$this->input->post('h_jobs_id'));
				$buyer_id = decrypt($this->data['loggedin']['user_id']);
				//print_r($this->data['loggedin']); exit;
				$buyer_name = $this->data['loggedin']['user_fullname'];
				$tradesman_id = $this->input->post('tradesman_id'); 				
				
				$ret = false;
				$count = 0;
				$arr_jb = array();
				$send = false;
				foreach($arr_jobs_id as $job_id)
				{	
					$ret = false;
					if($this->mod_->check_invitation_exist(decrypt($job_id),$tradesman_id))
					{
						$ret = $this->mod_->invite_mail(decrypt($job_id),$buyer_id,$tradesman_id,$buyer_name);
						$count++;
						$send = true; // means send atleast one
					}
					else{
						$arr_jb[] = decrypt($job_id);
						
					}
					
				}
				$s_part = '';
				if(count($arr_jb)>0)
				{
					$i_failed = count($arr_jb);
					$s_part = ' '.$i_failed.' '.addslashes(t('job(s) invitaion failed due to earlier invitation'));
				}
				
				$msg = $send? $count.' '.addslashes(t(" Job(s) invitation send successfully.")).$s_part:addslashes(t("You have already sent an invitation to this tradesman for the jobs selected."));
				echo json_encode(array('flag'=>$send,'msg'=>$msg));
				exit;
			}
			else
			{
				//echo 'Hi';
				redirect(base_url());
			}
		}
		catch(Exception $e)
		{
			show_error($e->getMessage());
		}
	}

		
	 
    public function __destruct()

    {}           

}



/* End of file welcome.php */

/* Location: ./system/application/controllers/welcome.php */

