<?php
/********* 
* Author: Mrinmoy Mondal
* Date  : 31 March 2012
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
	public $history_arr;

    public function __construct()
    {
        try
        { 
          parent::__construct(); 
          $this->data['title']="Find Tradesman";////Browser Title
		  $this->data['ctrlr'] = "find_tradesman";
		  
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
          $this->load->model('tradesman_model','mod_td');
		  $this->load->model('zipcode_model');
		  $this->load->model("Manage_feedback_model","mod_feed");
          $this->load->model('common_model','mod_common');
		  
		   /* start defined tradesman history array */
		  $this->history_arr = array(
		  		'quote_placed'	=>addslashes(t('Placed quote on job')).' - ##TITLE##',
		  		'awarded_job'  =>addslashes(t('Awarded job')).' - ##TITLE##',
				'accept_job'  =>addslashes(t('Accept job')).' - ##TITLE##',
				'deny_job'  =>addslashes(t('Deny job')).' - ##TITLE##',
				'post_message'  =>addslashes(t('Post message on')).' - ##TITLE##'											 
				);
		   /* end defined tradesman history array */	
		  
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
			$this->data['breadcrumb'] = array(addslashes(t('Find Tradesman'))=>'');	
			$this->s_meta_type = 'find_tradesman';

			/**fetch job category **/
		    $this->load->model('category_model');
		    $s_where = " WHERE i_status=1 ";  
		    $this->data['category_list'] =  $this->category_model->fetch_multi($s_where);
		    /**end fetch job category **/
			
			/* searching values get from header.tpl.php */
			$srch_str  = trim($this->input->post('txt_fulltext_src'));
			$srch_type = trim($this->input->post('job_select'));
			if($this->input->post('txt_service')!='' && ($this->input->post('txt_service')!=addslashes(t('What service do you need ?'))))
			{
			$srch_str	= trim($this->input->post('txt_service'));			
			}
			if (preg_match("/Hangi Hizmete/", $srch_str))
			{
			$srch_str = '';
			}
			/*$str_exp = 'Hangi Hizmete';
			if($str_exp.exist($srch_str))
			{
			$srch_str = '';
			}*/
			
			
			if($this->input->post('txt_where')!='' && $this->input->post('txt_where')!=addslashes(t('Where ?')))
			{
			$srch_where = trim($this->input->post('txt_where'));
			}
			$this->data['srch_str']  = $srch_str;
			$this->data['srch_type'] = $srch_type;
			
			/* searching values from header.tpl.php */
			
			
			$sessArrTmp = array();
			if(decrypt($i_category_id))
			{
				$sessArrTmp['src_tradesman_category_id']  = $i_category_id;
			}
			elseif($_POST)
			{
				$sessArrTmp['src_tradesman_fulltext_src'] = $srch_str?$srch_str:"";
				$sessArrTmp['src_tradesman_fulladd_src']  = $srch_where?$srch_where:"";
				
				$sessArrTmp['src_tradesman_category_id']  	= (decrypt($i_category_id))? $i_category_id : trim($this->input->post('category'));										
				$sessArrTmp['src_tradesman_city_id']		= trim($this->input->post('opt_city'));
				$sessArrTmp['src_tradesman_province_id']	= trim($this->input->post('opt_state'));
				$sessArrTmp['src_tradesman_keyword'] 		= trim($this->input->post('txt_keyword'));
				$sessArrTmp['src_tradesman_verified'] 		= trim($this->input->post('i_verify'));
				$sessArrTmp['src_tradesman_holiday'] 		= trim($this->input->post('i_holiday'));
				$sessArrTmp['src_tradesman_weekend'] 		= trim($this->input->post('i_weekend'));
				
			}
			
			$this->session->set_userdata(array('model_session'=>$sessArrTmp));	// to store data in session
			$this->data['posted'] = $sessArrTmp;

			ob_start();
			$this->pagination_ajax(0,1);
			$contents = ob_get_contents();
			ob_end_clean();
			$tradesman_list = explode('^',$contents);
			
			$this->data['tradesman_list'] = $tradesman_list[0];
			$this->data['tot_rows'] 	  = $tradesman_list[1];
			
			
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
		$sessArrTmp['src_tradesman_keyword']  		= $this->get_session_data('src_tradesman_keyword');
		$sessArrTmp['src_tradesman_category_id']  	= $this->get_session_data('src_tradesman_category_id');
		$sessArrTmp['src_tradesman_city_id'] 		= $this->get_session_data('src_tradesman_city_id');
		$sessArrTmp['src_tradesman_province_id']	= $this->get_session_data('src_tradesman_province_id');	
		$sessArrTmp['src_tradesman_verified'] 		= $this->get_session_data('src_tradesman_verified');	
		$sessArrTmp['src_tradesman_holiday'] 		= $this->get_session_data('src_tradesman_holiday');	
		$sessArrTmp['src_tradesman_weekend'] 		= $this->get_session_data('src_tradesman_weekend');		
		
		
		$arr_search[] = " n.id!=0 AND n.i_is_active=1 AND n.i_role=2";
		
	if($sessArrTmp['src_tradesman_fulltext_src']!="")
		{	
			 $arr_search[] =" (n.s_name LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_fulltext_src'])."%' OR n.s_username LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_fulltext_src'])."%' OR td.s_keyword LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_fulltext_src'])."%' OR td.s_about_me LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_fulltext_src'])."%') ";
		}	
		
		if($sessArrTmp['src_tradesman_verified'])
		{
			$arr_search[] =" (td.i_ssn_verified = 1 OR td.i_address_verified = 1 OR td.i_mobile_verified = 1 OR s_verified=1 ) ";
		}
		// search for workdays array defined  @ database.php 
		if($sessArrTmp['src_tradesman_weekend'])
		{
			$arr_search[] =" (w_days.i_work_days IN(2,3)) ";
		}
		if($sessArrTmp['src_tradesman_holiday'])
		{
			$arr_search[] =" (w_days.i_work_days IN(3)) ";
		}
		
		if($sessArrTmp['src_tradesman_keyword']!="")
		{
			$sessArrTmp['src_tradesman_keyword'] = preg_replace('/[\s]+/',',',$sessArrTmp['src_tradesman_keyword']);
			$src_key = '';
			$arr_src = explode(',',$sessArrTmp['src_tradesman_keyword']);
			//pr($arr_src);
			if(!empty($arr_src) && is_array($arr_src))
			{
				foreach($arr_src as $val)
				{
				$src_key .= ($src_key)? " OR (n.s_name LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_keyword'])."%' OR n.s_username LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_keyword'])."%' OR td.s_keyword LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_keyword'])."%' OR td.s_about_me LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_keyword'])."%') " :" (n.s_name LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_keyword'])."%' OR n.s_username LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_keyword'])."%' OR td.s_keyword LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_keyword'])."%' OR td.s_about_me LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_keyword'])."%') ";
					
				}
				$src_key = ($src_key) ? '('.$src_key.')' : '';
				
			}
			
			if(!empty($src_key))
			 $arr_search[] = $src_key ;
			
		
			 //$arr_search[] =" (n.s_name LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_keyword'])."%' OR n.s_username LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_keyword'])."%' OR td.s_keyword LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_keyword'])."%' OR td.s_about_me LIKE '%".get_formatted_string($sessArrTmp['src_tradesman_keyword'])."%') ";
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
		if($sessArrTmp['src_tradesman_province_id'])
		{
			$arr_search[] =" n.i_province=".decrypt($sessArrTmp['src_tradesman_province_id']);
		}
		
		
	 	$s_where .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
		$limit	 =  $this->i_fe_page_limit;		
		$orderby = $orderbyArry[1].' DESC ';
		
		$tradesman_list	= $this->mod_td->fetch_featured($s_where,$orderby,intval($start),$limit);	

        
		$total_rows 	= $this->mod_td->gettotal_info($s_where);
		
		if($total_rows > 0)
		{
			for($i = 0;$i<count($tradesman_list);$i++) 
			{
				$s_where = " WHERE n.i_receiver_user_id = ".$tradesman_list[$i]['id']." AND n.i_status !=0 "; 
				$feedback = $this->mod_feed->fetch_multi($s_where,$i_start=0,$i_limit=1);
			//	pr($feedback);
				$tradesman_list[$i]['feedback'] = $feedback[0];
			}
		
		}
		
		if($total_rows > 0)
		{
			for($i = 0;$i<count($tradesman_list);$i++) 
			{
				$s_wh = " WHERE n.i_user_id = ".$tradesman_list[$i]['id']." "; 
				$category = $this->mod_td->fetch_all_category($s_wh);
				//pr($category);
				 $cat_arr = array();
				if(!empty($category))
				{
				
				foreach($category as $val)
					{
						$cat_arr[] = $val['s_category_name'];
					}
					
				}
				$tradesman_list[$i]['category'] = implode(', ',$cat_arr);
			}
		
		}
		
		//echo $limit.'--'. $start;
		$this->data['tradesman_list'] = $tradesman_list;	
		//pr($this->data['tradesman_list'],1);	
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'find_tradesman/pagination_ajax/';
		$paging_div = 'trades_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		$this->data['image_path'] 	= $this->config->item("user_profile_image_thumb_path");
		$this->data['image_up_path']= $this->config->item("user_profile_image_thumb_upload_path");
		//$this->data['current_page'] = $page;
		if(empty($param))
			$job_vw = $this->load->view('fe/find_tradesman/ajax_tradesman_list.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/find_tradesman/ajax_tradesman_list.tpl.php',$this->data,TRUE).'^'.$total_rows;
		echo $job_vw;		
	}	
	
	public function tradesman_profile($enc_tradesman_id='')
	{
		try
		{ 
              
			if($enc_tradesman_id=='')
            {
                if(!empty($this->data['loggedin']))
                {
                    $user_details         =     $this->data['loggedin'];
                    $i_tradesman_id         =     decrypt($user_details['user_id']);
                }
                 
            }
            else
            {
                $i_tradesman_id         =     decrypt($enc_tradesman_id)  ; 
            }

			$this->data['breadcrumb'] = array(t('Tradesman Profile')=>'');	
			/**fetch job category **/
            
            $info_tradesman  =   $this->mod_td->fetch_this($i_tradesman_id);
           //pr($info_tradesman,1);
            $s_where    =   ' WHERE i_user_id='.$i_tradesman_id ;
            $info_album =   $this->mod_td->get_album_images($s_where);
            $this->data['info_album']   =   $info_album ;
			
			/* fetch payment method */
			$payment_arr = array();
			if(!empty($info_tradesman['payment_unit']))
			{
			foreach($info_tradesman['payment_unit'] as $val)
			{
				$payment_arr[] = $val['s_payment_unit'];
			}
			$this->data['payment_unit'] = implode(', ',$payment_arr);
			}
			unset($payment_arr);
            /* fetch payment method */ 
			
			/* fetch work days */
			$work_days = array();
			if(!empty($info_tradesman['work_days']))
			{
			foreach($info_tradesman['work_days'] as $val)
			{
				$work_days[] = $val['s_days'];
			}
			$this->data['work_days'] = implode(', ',$work_days);
			}
			unset($work_days);
            /* fetch work_days */ 
			        
            $this->data['arr_cat']      =   $info_tradesman['category'] ; 
            $this->data['work_place']   =   $info_tradesman['workplace'];			
			$this->data['payment_time'] =   $info_tradesman['payment_time'];
            $this->data['arr_keyword']  =   explode(', ',$info_tradesman['s_keyword']);
            
            $this->data['info_tradesman']   =   $info_tradesman ;
			//pr($this->data['info_tradesman'],1);
		    /**end fetch job category **/
			
			/*$info = $this->mod_td->fetch_this(decrypt($id),$this->i_default_language); */
			
			//pr($info,1);
			/********** Trades man album **************/
			/*$this->load->model('tradesman_model',"mod_td");
			$s_where = " WHERE n.i_user_id = ".decrypt($id);
			$album_list = $this->mod_td->get_album_images($s_where);
			
			$this->data['album_list'] = $album_list;
			$this->data['album_image_thumb_path'] = $this->config->item("trades_album_image_thumb_path");
			$this->data['album_image_path'] = $this->config->item("trades_album_image_path");
			$this->data['album_image_up_path'] = $this->config->item("trades_album_image_thumb_upload_path");*/	

			/********** END Trades man album **************/
			/*$s_where = " WHERE n.i_receiver_user_id = ".decrypt($id)." AND n.i_status != 0 "; 
			$feedback = $this->mod_feed->fetch_multi($s_where);
			
			$this->data['profile_info'] = $info;
			$this->data['feedback_info'] = $feedback;
			$this->data['image_path'] = $this->config->item("user_profile_image_thumb_path");
			$this->data['image_up_path'] = $this->config->item("user_profile_image_thumb_upload_path");	
			
			
			ob_start();
			$this->pagination_feedback_ajax($id,0,1);
			$contents = ob_get_contents();
			ob_end_clean();            */
			
            $s_where = " WHERE n.i_receiver_user_id = ".decrypt($enc_tradesman_id)." AND n.i_status != 0 "; 
            $feedback = $this->mod_feed->fetch_multi($s_where,0,5);
			
			$this->data['feedback_contents'] = $feedback; 
            
            
            
            $tablename  =   $this->db->JOBS ;
            $s_where    =   " WHERE i_tradesman_id=".decrypt($enc_tradesman_id)." AND i_status!=8 "  ;  
            $this->data['won_jobs']     =   $this->mod_common->common_count_rows($tablename,$s_where);
            
            $tablename  =   $this->db->JOBQUOTES ;
            $s_where    =   " WHERE i_tradesman_user_id=".decrypt($enc_tradesman_id) ;  
            $this->data['quote_placed']     =   $this->mod_common->common_count_rows($tablename,$s_where);
            
            /************** Start fetch similar type of category *************/
            if(!empty($info_tradesman['category']))
            {
                $arr_category   =   array();
                foreach($info_tradesman['category'] as $val)
                {
                   $arr_category[]    =   $val['id'] ; 
                }
            }
            //$s_where    =   " WHERE tc.i_category_id in (".implode(',',$arr_category).') AND tc.i_user_id!='.decrypt($enc_tradesman_id) ;
			$s_where = " WHERE tc.i_user_id!=".decrypt($enc_tradesman_id)." ";
			if(!empty($arr_category))
			{
			$s_where .= " AND tc.i_category_id in (".implode(',',$arr_category).")" ;
			}
            
            $this->data['similar_tradesman']    =   $this->mod_td->fetch_similar_tradesman($s_where,0,5);
            
            
            /************** End fetch similar type of category *************/
			
			/* fetch trademan history / news feed */
			$trade_where = " WHERE n.i_user_id = ".$i_tradesman_id." ";
			$this->data['tradesman_history'] = $this->mod_td->fetch_tradesman_history($trade_where,$this->history_arr,0,10);
			//pr($this->data['tradesman_history'],1);
			/* end fetch trademan history / news feed */
           
             unset($info_tradesman,$info_album,$s_where,$tablename);  
				
			$this->render('find_tradesman/tradesman_profile');
		}
		catch(Exception $e)
		{
			show_error($e->getMessage());
		}
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
					if($this->mod_td->check_invitation_exist(decrypt($job_id),$tradesman_id))
					{
						$ret = $this->mod_td->invite_mail(decrypt($job_id),$buyer_id,$tradesman_id,$buyer_name);
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
	public function pagination_feedback_ajax($s_id,$start=0,$param=0) {
		$limit	= $this->i_fe_page_limit;
	//	$limit = 2;
		$s_where = " WHERE n.i_receiver_user_id = ".decrypt($s_id)." AND n.i_status != 0 "; 
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
    
    public function ajax_fetch_active_jobs()
    {
        try
        {
            if($_POST)
            {
                $tradesman_id    =   $this->input->post('tradesman_id');
                $this->load->model('job_model');
                
                if(!empty($this->data['loggedin']))
                {
                    $user_id    =   decrypt($this->data['loggedin']['user_id']) ;                    
                }
                
				if(!empty($this->data['loggedin']))
				{
					$s_where    =   " WHERE i_buyer_user_id=".$user_id." AND i_status=1 " ;
					$job_list   =   $this->job_model->fetch_job_list($s_where,decrypt($tradesman_id));
				   
					if(!empty($job_list))
					{
						$job_ul =   '<input type="hidden" name="h_tradesman_id" value="'.$tradesman_id.'" /><ul>';
						foreach($job_list as $key=>$val)
						{
							//$float   =   ($key%2==0)?'float: left;':'float: right;' ;  
							//$job_ul    .= '<li style="'.$float.' width:50%;" ><input name="chk_jobs[]" type="checkbox" value="'.encrypt($val['id']).'" />'.$val['s_title'].'</li>';   
							$job_ul    .= '<li style="width:100%;" ><input name="chk_jobs[]" type="checkbox" value="'.encrypt($val['id']).'" />'.$val['s_title'].'</li>';      
						}
						
						$job_ul .=   '</ul><div class="spacer"></div><input  class="login_button flote02"  onclick="inviteTradesman();" type="button" value="'.addslashes(t('Invite')).'" />'; 
						echo $job_ul ;
					}
					
					else
					{
						echo "<ul><li>".addslashes(t('No job found'))."</li></ul>" ;
					}
				}	// checking user logged in
				else
				{
				echo "not_login" ;
				}
            }
            else
            {
                echo "<ul><li>".addslashes(t('No job found'))."</li></ul>" ;
            }
            
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

