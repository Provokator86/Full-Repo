<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
			
class Home extends MY_Controller {

    //put your code here
	 public $cls_msg;
	 public $i_cms_type_id;
	 
    public function __construct() 
	{
        parent::__construct();	
		
		$this->cls_msg["deal_submit_succ"]   = "Your request has been sent to Administrator. We will get back to you soon.";
		$this->cls_msg["deal_submit_err"]    = "Mail sending failed";
		$this->cls_msg["contact_succ"]   	 = "Your contact request has been sent. We will get back to you soon.";
		$this->cls_msg["contact_err"]        = "Your contact request has been failed.";	
		
		$this->load->model('cms_model');
		$this->load->model('manage_deals_model');
		//$this->session->unset_userdata('srch_key');
		
    }
	
	/* functions for cmspages and contact us*/
	public function cms($param)
    {
        try
        {	
			switch($param)
			{
				case "about_us":
					$i_cms_type_id = 1;
					break;
				case "privacy_policy":
					$i_cms_type_id = 3;
					break;
				case "terms_condition":
					$i_cms_type_id = 2;
					break;
				case "contact_us":
					$i_cms_type_id = 4;
					break;				
				default :	
					$i_cms_type_id = 1;
					break;
			}
			
			//$s_where 					= " WHERE c.i_cms_type_id={$i_cms_type_id} And c.i_status=1 ";
			$s_where	= array('i_cms_type_id'=>$i_cms_type_id,'i_status'=>1);
			$data['info']		= $this->cms_model->get_list($s_where);
			//pr($data,1);
			$this->render($data);			
			
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
			$this->data['heading']	= "Contact Us";
			$this->data['title'] 	= "Contact Us";// /Browser Title
			
			$s_where	= array('i_cms_type_id'=>4,'i_status'=>1);
			$this->data['info']		= $this->cms_model->get_list($s_where);
						
			if($_POST)
			{
					$posted = array();
					$posted['name'] 		= trim($this->input->post("name"));
					$posted['email'] 		= trim($this->input->post("email"));
					$posted['subject'] 		= trim($this->input->post("subject"));
					$posted['message'] 		= trim($this->input->post("message"));
					
					
					$this->form_validation->set_rules('name', 'name', 'required|trim');
					$this->form_validation->set_rules('email', 'email', 'required|valid_email');
					$this->form_validation->set_rules('subject', 'subject', 'required|trim');
					$this->form_validation->set_rules('message',' message', 'required|trim');
				
				if($this->form_validation->run() == FALSE ) // validation false (error occur)
				{              
					$this->data["posted"]   =   $posted ;
				}
				else
				{				
					$this->load->model('auto_mail_model','mod_auto');
					$this->load->model('site_settings_model','mod_rect');
					
					$info			= $this->mod_rect->fetch_this(NULL);
					//pr($info,1);
					
					$admin_email	= $info['s_admin_email'];
					$content 		= $this->mod_auto->fetch_mail_content('contact_us','general');   
					//$s_subject 	= $content['s_subject'];		
					$s_subject 		= $posted['subject'];				
					$filename   	= $this->config->item('EMAILBODYHTML')."common.html";
					$handle     	= @fopen($filename, "r");
					$mail_html  	= @fread($handle, filesize($filename));  
					
					if(!empty($content))
					{                            
						$description = $content["s_content"];
						$description = str_replace("[EMAIL]",$posted['email'],$description);
						$description = str_replace("[NAME]",$posted['name'],$description); 
						$description = str_replace("[SUBJECT]",$posted['subject'],$description);
						$description = str_replace("[MESSAGE]",$posted['message'],$description);
					}
					
				  unset($content);
				  
				  $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);					 
				  $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);
								  				  
				  //pr($mail_html,1);
				  //$admin_email = 'submit@mydealfound.com';
				  $i_sent = sendMail($admin_email,$s_subject,$mail_html,$posted['email']);
				
				  if($i_sent || TRUE)
				  {
					$msg = array();
					$msg['message'] = $this->cls_msg["contact_succ"];
					$msg['message_type'] = 'succ';
					$this->session->set_userdata('msg_session', $msg);
	
					echo json_encode(array('status' => 'success', 'message' => 'Success'));
				  }
				  else
				  {
					$msg = array();
					$msg['message'] = $this->cls_msg["contact_err"];
					$msg['message_type'] = 'err';
					$this->session->set_userdata('msg_session', $msg);
					
					echo json_encode(array('status' => 'error', 'message' => 'Fatal Error'));
				  }					
				}   // end of else part
			}
			else {
            	$this->render($this->data);
        	}
		    //$this->render($this->data, 'home/contact_us.tpl.php'); 		
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
	}
	
	/* end functions for cmspages and contact us*/
	
	
    public function index($paging = 0) 
	{		
		$posted_filter	= $this->session->userdata('posted_filter');
		
        $data = array('title' => 'Title');
		
		//$aff = update_category_count(0);	// update for each total product count in cd_category table		
		//$str = select_product_under_category(40);

        /*$data['popular_store'] = $this->store_model->get_list(array('i_is_active' => '1', 'i_is_hot' => 1), 'i_id,s_store_title,s_url,s_store_logo', 18);*/
		$data['popular_store'] = $this->store_model->get_list(array('i_is_active' => '1'), 'i_id,s_store_title,s_url,s_store_logo', 18);

        $data['store_list'] = $this->store_model->get_list(array('i_is_active' => '1'), 'i_id,s_store_title,s_url,s_store_logo', NULL,0,'s_store_title','asc');
        $featured_deals = $this->deal_model->get_active_deal_list(" i_is_featured=1 AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ", 'i_id,s_title,s_image_url,s_seo_url');
		
        $popular_deals = $this->deal_model->get_active_deal_list(" i_is_popular=1 AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ",'i_id,s_title,s_url,s_image_url,s_meta_description,s_seo_url,s_summary');

        //pr($popular_deals);Thursday, 13th June, 2013 	
		
		if(isset($posted_filter) && !empty($posted_filter))
		{		
			//$display_homepage_listing = $this->filter_list_for_home($paging);			 
			/*ob_start();
				$this->filter_list_for_home($paging); #$current_page
				$display_homepage_listing = ob_get_contents(); //pr($data['result_content']);
        	ob_end_clean();*/
		}
		else
		{	
			/*ob_start();
				$this->list_daily_deal($paging); #$current_page
				$display_homepage_listing = ob_get_contents(); //pr($data['result_content']);
        	ob_end_clean();
		
        	$display_homepage_listing = $this->list_daily_deal($paging);*/				
		}

        $data['featured_deals'] = $featured_deals;
		$data['display_homepage_listing'] = $display_homepage_listing;
        $data['popular_deals'] = $popular_deals;
		
		/* 12 March 2014 MM top stores and just added coupons*/
		$s_cond = " WHERE i_is_active=1 AND i_is_top=1 ";
		//$s_cond = " WHERE i_is_top=1 ";
		$order_name = " s_store_title ";
		$order_by = " Desc ";
		$data['top_store'] = $this->store_model->fetch_multi_sorted_list($s_cond,$order_name,$order_by,0,15);
		$data['total_top_store'] = count($data['top_store']);
		//pr($data['top_store'],1);
		$lmt = 5;  // fetch only 5 last added coupons
		/*$data["just_added"] = $this->deal_model->get_active_deal_list(" i_is_active=1 AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ",'i_id,s_title,i_store_id,s_url',$lmt);*/
		$start_from = 0;
		$s_where_cond = "WHERE p.i_is_active=1 AND (CONCAT(DATE(p.dt_exp_date),' 23:59:59')>='".now()."' OR p.dt_exp_date = 0) ";
		$s_order = " ORDER BY p.dt_date_of_entry DESC ";
		$data["just_added"] = $this->manage_deals_model->get_deals_offers_list($s_where_cond,intval($start_from),$lmt,$s_order);
		
		//pr($data['just_added'],1);
		/* 12 March 2014 MM top stores and just added coupons */
		
		$b_cond = "WHERE i_is_active=1";
		$data["all_brand"] = $this->product_model->get_all_brand($b_cond);
		//pr($data["all_brand"],1);
		/***************** 21 Mar 2014 generate category wise product/deal ************************/
		
		ob_start();
			$this->filter_category_wise_product_list($paging); #$current_page
			$display_product_listing = ob_get_contents(); 
		ob_end_clean();
		
		$data['display_product_listing'] = $display_product_listing;
		/***************** 21 Mar 2014 generate category wise product/deal ************************/
		
		$trending_now = $this->deal_model->get_active_deal_list(" i_is_featured=1 AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ", 'i_id,s_title,s_image_url,s_seo_url',10);
		//$trending_now = array_merge($trending_now,$trending_now,$trending_now);
		$data['trending_now'] = $trending_now;
		
		
		
		$data['cntrlr'] = 'home';
		$this->session->set_userdata('home_viewed',1);
        $this->render($data);
    }
	
	/* 21 March 2014 */
	
	 public function filter_category_wise_product_list($paging = 0) {
       
		$posted_filter	= $this->session->userdata('posted_filter');
		$search_condition =" WHERE i_status = 1 AND e_show_in_frontend = '1' AND i_parent_id=0 AND i_total_product>0 ";
       
	    $data['dealList'] = $this->process_category_wise_product_list($search_condition, 'Advance Search', $paging,6, base_url() . 'home/filter_category_wise_product_list/', 3, NULL, TRUE);	
		//echo $this->db->last_query();exit;
		
        
        echo $this->load->view('elements/home_product_list.tpl.php', $data, true);		
    }
	
	
	

    public function list_daily_deal($paging = 0) {

        //return $this->process_deal_list(array('i_is_daily' => 1, 'dt_exp_date >=' => date('Y-m-d', time())), date('l, jS M,Y', time()), $paging, 6, base_url() . 'home/index/');
		
		$where	= " i_is_daily=1 AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ";
		
		//$where	= " (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ";
		
		$data['dealList'] = $this->process_deal_list($where, 'Latest Deals', $paging, 36, base_url() . 'home/list_daily_deal/', 3, NULL);		
		//echo $data['dealList'];
		
		return $this->process_deal_list($where, "Latest Deals", $paging, 36, base_url() . 'home/index/');
    }
	
	
	

    private function detail($seo_url = '') 
	{
        $dealListCondition = array('s_seo_url' => $seo_url);

        /*$dealListData = $this->deal_model->get_joined_active_deal_list($dealListCondition, 'cd_coupon.i_id,cd_coupon.s_summary ,s_title,s_store_title,s_store_logo,s_store_logo,cd_coupon.s_url,cd_coupon.s_video,cd_coupon.s_url,s_store_url,s_image_url,cd_store.s_about_us ,cd_coupon.s_meta_description as coupon_meta,d_list_price,d_selling_price,d_discount,s_discount_txt,i_cashback,dt_date_of_entry,cd_category.s_category', 1, 0);	*/	

		$dealListData = $this->deal_model->get_joined_active_deal_list($dealListCondition, 'cd_coupon.i_id,cd_coupon.s_summary ,s_sku,s_product_id,s_attributes,dt_exp_date,i_store_id,cd_coupon.i_cat_id,s_title,s_store_title,s_store_logo,s_store_logo,cd_coupon.s_url,cd_coupon.s_video,cd_coupon.s_url,s_store_url,s_image_url,cd_store.s_about_us ,cd_coupon.s_meta_description as coupon_meta,d_list_price,d_selling_price,d_discount,s_discount_txt,i_cashback,dt_date_of_entry,cd_category.s_category,cd_category.i_parent_id', 1, 0);	
        $data['dealMeta'] = $dealListData[0];
		//echo '<pre>'; print_r($dealListData[0]); echo '</pre>'; exit;
		//print_r($data['dealMeta']);
		//echo '========'.getCategoryPath($data['dealMeta']['i_parent_id'],$data['dealMeta']['s_category']);
		$data['CategoryPath'] =  $this->deal_model->getCategoryPath($data['dealMeta']['i_parent_id'],$data['dealMeta']['s_category']);
		
		$data['deal_store_id']	=  $dealListData[0]["i_store_id"];
		if($dealListData[0]["i_store_id"]==318)
		{
		$attributes = json_decode($dealListData[0]["s_attributes"],true);
		//pr($attributes,1);		
		//$data["attributes"] = $attributes->Attribute;
		$data["attributes"] = $attributes;
		//echo '<pre>'; print_r($data["attributes"]); echo '</pre>'; exit;
		}
		else
		{
			$attributes = json_decode($dealListData[0]["s_attributes"]);
			//pr($attributes,1);		
			$data["attributes"] = $attributes->Attribute;
		}
		
        $data['dealMeta']['rateit_status'] = $this->rateit_status($dealListData[0]['i_id'],FALSE);
		
		$data['coupon_title']	=  $data['dealMeta']['s_title'];
		
		$data['fb_description']	=  exclusive_strip_tags($data['dealMeta']['s_summary']);
		
		$data['url']			=  base_url().$seo_url;
		
		$data['deal_logo']		=  base_url().'uploaded/deal/'.$data['dealMeta']['s_image_url'];

        return $this->render($data, 'home/detail.tpl.php', TRUE);
    }

    public function router() {

        $seo_url = $this->uri->segment(1);

        $paging = $this->uri->segment(2);

        if ($this->deal_model->count_active_deal_total(array('s_seo_url' => $seo_url)))
            echo $this->detail($seo_url);

        else {

            if ($this->store_model->count_total(array('s_url' => $seo_url)))

                $this->list_deal_in_store($seo_url, $paging);

            else {

                $data['url'] = $seo_url;

                echo $this->render($data, '404.tpl.php', TRUE);

            }
        }
    }

    public function top_deals__before31Mar2014($paging = 0) {	
		
       /* $data['dealList'] = $this->process_deal_list(array('cd_coupon.i_is_hot' => 1, 'dt_exp_date >=' => date('Y-m-d', time())), 'Top Deals', $paging, 8, base_url() . 'top-deals/', 2);*/
	   
	   $where	= " cd_coupon.i_is_hot=1 AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ";
	   $data['dealList'] = $this->process_deal_list($where, 'Top Deals', $paging, 8, base_url() . 'top-deals/', 2);	   

        $this->render($data, 'home/listing.tpl.php');
    }
	
	/* new top deals from cd_deals table 31Mar 2014 */
	 public function top_deals($paging = 0) {	
	 
	   $where	= " cd_deals.i_is_hot=1 AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ";
	   $data['dealList'] = $this->process_new_deal_list($where, 'Top Deals', $paging, 20, base_url() . 'top-deals/', 2,true);	   

       $this->render($data, 'home/listing.tpl.php');
    }

    public function daily_deals($paging = 0) {

        /*$data['dealList'] = $this->process_deal_list(array('i_is_daily' => 1, 'dt_exp_date >=' => date('Y-m-d', time())), 'Daily Deals', $paging, 8, base_url() . 'daily-deals/', 2,'','', array('dt_exp_date' => 0));*/
		
		$where	= " i_is_daily=1 AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ";
	    $data['dealList'] = $this->process_deal_list($where, 'Daily Deals', $paging, 8, base_url() . 'daily-deals/', 2);	

        $this->render($data, 'home/listing.tpl.php');
    }
	
    public function popular_deals__before31Mar2014($paging = 0) {

        /*$data['dealList'] = $this->process_deal_list(array('i_is_popular' => 1, 'dt_exp_date >=' => date('Y-m-d', time())), 'Popular Deals', $paging, 8, base_url() . 'popular-deals/', 2,'','', array('dt_exp_date' => 0));*/
		
		$where	= " i_is_popular=1 AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ";
		
		$data['dealList'] = $this->process_deal_list($where, 'Popular Deals', $paging, 8, base_url() . 'popular-deals/', 2);

        $this->render($data, 'home/listing.tpl.php');
    }
	
	/* new popular deals from cd_deals table 31Mar 2014 */
	public function popular_deals($paging = 0) {

		$where	= " i_is_popular=1 AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ";
		
		$data['dealList'] = $this->process_new_deal_list($where, 'Popular Deals', $paging,20, base_url() . 'popular-deals/', 2,true);

        $this->render($data, 'home/listing.tpl.php');
    }

    public function search() {

        $location = intval($this->input->post('location'));
		
        $paging = intval($this->uri->segment(3));

        $keyword = $this->input->post('keyword');
		$data["srch_key"] = $keyword;
		
        if (!$keyword) {

            $keyword = $this->uri->segment(2);
        }

        if ($keyword || $location) {

            $searchTitle = "Search Result: $keyword";

            $likeCondition = array('s_title' => $keyword);
           /* 
		   $data['dealList'] = $this->process_deal_list(array('i_location_id' => $location, 'dt_exp_date >=' => date('Y-m-d', time())), $searchTitle, $paging, 1, base_url() . 'search/' . $keyword, 3, $likeCondition);*/
			
			/*$where	= " i_location_id = '".$location."' AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ";			
			$data['dealList'] = $this->process_deal_list($where, $searchTitle, $paging, 20, base_url() . 'search/' . $keyword, 3, $likeCondition,true);
			
			$this->render($data, 'home/listing.tpl.php');
			*/
			
			/* modified on 14 Apr 2014 only title match implemented future logic will be later*/
			$this->session->unset_userdata('srch_key');
			$this->session->set_userdata('srch_key',$keyword);
			
			/* get store and brands implemented 13 May 2014 */
			
			$s_where = "WHERE i_parent_id = 0 AND i_status = 1 ";
			$data["main_category"] = $this->manage_deals_model->get_category($s_where);
		
			$s_where  = " WHERE p.i_is_active = 1 ";
			$all_store = $this->product_model->get_distinct_store_from_product($s_where);		
			$data["all_store"]  = array();
			if($all_store!="")
			{
				$s_con = "WHERE i_is_active =1 AND i_id IN ({$all_store}) ";
				$data["all_store"] = $this->product_model->get_all_store($s_con);
			}
			
			//$s_where .= "AND (p.s_title LIKE '%".my_receive_text($this->session->userdata('srch_key'))."%' OR p.s_summary LIKE '%".my_receive_text($this->session->userdata('srch_key'))."%') ";
			$all_brand = $this->product_model->get_distinct_brand_from_product($s_where);		
			$data["all_brand"] = array();
			if(!empty($all_brand))
			{
				$data["all_brand"] = $all_brand;
			}
			
			/* end get store and brands implemented 13 May 2014 */
			
			ob_start();
				$this->ajax_pagination_search_list(0,0);
				$search_list	= ob_get_contents();
			ob_end_clean();
			$search_list = explode('|^|',$search_list);
			
			$data['search_list'] = $search_list[0];
			$data['total_cnt'] 	= $search_list[1];

            $this->render($data, 'home/search.tpl.php');
			
			/* modified on 14 Apr 2014 only title match implemented future logic will be later*/
		

        } else {

            $data['url'] = 'Please Search Again';
            echo $this->render($data, '404.tpl.php', TRUE);
        }
    }
	
	
	 /**
    * This function is ajax pegination function 
    * make the list all pros
	* modified on 14 Apr 2014 only title match implemented future logic will be later
    * 
    * @param mixed $start
    * @param mixed $param
    */
    function ajax_pagination_search_list($start=0,$param=0) 
    {
        try
        {
			# NEW
            #$this->data['next_record_pointer'] = ( !empty($start) )? $start-1: $start+1;
            $this->data['next_record_pointer'] = ( !empty($start) )? $start+1: $start+2;
            #echo "next-record-pointer = {$start}##". $this->data['next_record_pointer'];
            
            #$start--;
            $start = ( !empty($start) )? $start-1: 0;
           	#echo "--". $start;
            $start = $start * 20;
            #echo "++". $start;
			
            $s_where        = " AND p.i_is_active = 1 ";
			$s_order		= "";
            $limit          = 20; 
			
			$srch_key = $this->session->userdata('srch_key');
			if($srch_key)
			{
				$extra_or = "";
				$store = $this->product_model->get_all_store(" WHERE s_url='".my_receive_text($srch_key)."' ",0,1);
				if(!empty($store))
				{
					$store_id = $store[0]["i_id"];
					if($store_id>0)
					{
						$this->session->set_userdata('product_srch_store_id');
						$extra_or .= " OR p.i_store_id='".$store_id."' ";
						$this->data["str_store"] = $store_id;
					}
				}
				else
				{
					$this->session->unset_userdata('product_srch_store_id');
					$this->data["str_store"] = '';
					
				}
				$s_where .=" AND (p.s_title LIKE '%".my_receive_text($srch_key)."%' OR p.s_summary LIKE '%".my_receive_text($srch_key)."%' {$extra_or}) ";
				
				$this->session->set_userdata('srch_key',$srch_key);
			}
			
			
			if($_POST && !in_array('t',$_POST))
			{
				$posted		 		=	array();							
				$str_cat			= $this->input->post('str_cat'); 
				$arr_store 			= $this->input->post('arr_store'); 			         
                $s_type      		= trim($this->input->post('type'));	
				$d_discount			= $this->input->post('d_discount');	
				
				$discount_checkboxes = $this->input->post('discount_checkboxes');
				$discount_arr = explode(",",$discount_checkboxes);
				$arr_brand 			= $this->input->post('arr_brand'); 
				
				if($s_type=='where') 
                {
                    //$this->session->unset_userdata('session_srch_where');
                }
				
				// search by category
				/*$condition  =   '' ;
                if (!empty($str_cat)) 
                {
                    $condition  .= " AND p.i_cat_id IN ({$str_cat}) ";
                }
                $s_where    .= trim($condition).'  ' ;*/
				$condition  =   '' ;
                if (!empty($str_cat)) 
                {
					$category_all_str = '';
					$category_id_str = '';
					$arr_cat = explode(',',$str_cat);
					if($arr_cat)
					{
						foreach($arr_cat as $val)
						{
							$category_id_str = select_product_under_category($val);
							$category_id_str = ltrim($category_id_str,',');
							$category_all_str .= $category_id_str.',';							
						}
					}
                    //$condition  .= " AND p.i_cat_id IN ({$str_cat}) ";
					$category_all_str = rtrim($category_all_str,',');
					$condition  .= " AND p.i_cat_id IN ({$category_all_str}) ";
                }
                $s_where    .= trim($condition).'  ' ;
				
				// search by store
				$condition  =   '' ;
                if (!empty($arr_store)) 
                {
                     $condition  .= "AND p.i_store_id IN ({$arr_store}) ";
                }
                $s_where    .= trim($condition).'  ' ;
				
				// search by brand
				$condition  =   '' ;
                if (!empty($arr_brand)) 
                {
                     //$condition  .= "AND p.i_brand_id IN ({$arr_brand}) ";
					 
					 $arr_brand = explode(',',addslashes($arr_brand));
					 if(is_array($arr_brand))
					 	$arr_brand = "'".implode("','",$arr_brand)."'";
					else
						$arr_brand = "'".my_receive_text($arr_brand)."'";
					 $condition  .= "AND p.s_brand_name IN ({$arr_brand}) ";
                }
                $s_where    .= trim($condition).'  ' ;
				
				// search by discount
				$condition  =   '' ;
                if (!empty($d_discount)) 
                {
					if($d_discount=='none')
					 	$condition .='';
					else
                     	$condition  .= "AND p.d_discount >= {$d_discount} ";
                }
                $s_where    .= trim($condition).'  ' ;
				
				// new discount by checkboxex
				$condition  =   '' ;
				if(!empty($discount_arr) && $discount_arr[0]!='')				
				{
					$arr_where = '';
					foreach($discount_arr as $val)
					{
						if($val=='none')
					 		$arr_search[] =" p.d_discount >=0 ";
						else
                     		$arr_search[]  = " p.d_discount >= {$val} ";
					}
					$arr_where .= (count($arr_search) !=0)?' AND ('.implode('OR',$arr_search).' )':'';
					
					$condition  .= $arr_where;
					//echo $arr_where.'</br>';
				}
				$s_where    .= trim($condition).'  ' ;
				
				if(trim($s_where)!='') 
                {
                    $this->session->set_userdata('session_srch_where',$s_where);
                }
				
				
			}
			else if($_POST && in_array('t',$_POST))
			{
				$s_where = $this->session->userdata('session_srch_where');
			}else {
                $s_where = $this->session->userdata('session_srch_where');
            }
			//echo '+++++'.$s_where.'+++++';
			
			if($this->session->userdata('session_srch_where') && trim($s_where)=='')
			{
				$s_where    =   $this->session->userdata('session_srch_where');
			}
			//$s_where  = " AND p.i_is_active = 1 ".$s_where;  // testing purpose			
			$s_where   = preg_replace('/^AND/','WHERE ',trim($s_where));
			//echo '<br/>==>'.$s_where.'<br/>==>'.$this->data["str_store"];		
					
            $this->data['product_list']= $this->product_model->get_product_list($s_where,intval($start),$limit,$s_order);          	
            $total_rows            = $this->product_model->count_product_list($s_where);
			
            $ctrl_path     = base_url().'home/ajax_pagination_search_list/';
            $paging_div = 'srch_list';
            $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
            $this->data['total_rows']     = $total_rows;
            $this->data['start']          = $start;
          
			if(empty($param))
				$prod_vw = $this->load->view('home/ajax_search_product_list.tpl.php',$this->data,TRUE);
			else
				$prod_vw = $this->load->view('home/ajax_search_product_list.tpl.php',$this->data,TRUE).'|^|'.$total_rows;
			echo $prod_vw;
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }                
    }
	
	function ajax_clear_srch_store_session()
	{
		$this->session->unset_userdata('offers_srch_store_id');
		echo 'ok';
	}
	
	
	/* end search store products */

    public function list_deal_in_store($seo_url = NULL, $paging = 0) {
	
		$this->load->model('vote_model');
	
        //$searchTitle = ucfirst($seo_url) . ' Deals';
		
		$data['store_details']	 = $this->store_model->fetch_multi_sorted_list(" WHERE s_url = '".$seo_url."'",'s_store_title','asc');
		//pr($data['store_details'],1);
		$data["loggedin_details"] = $this->session->userdata('current_user_session');
		$id	= $data['store_details'][0]['i_id'];
		
		$searchTitle = $data['store_details'][0]['s_store_title'] . ' Offers';
		
		/****************************NO OF VOTES************************************/

		$s_where1					= " WHERE i_store_id=".$id;

		$total						= $this->vote_model->gettotal_info($s_where1);

		$data['total_no_of_votes']	= $total;

        /****************************NO OF VOTES************************************/
		
		/****************************AVG RATING************************************/

            $s_where1=" WHERE i_store_id=".$id;

            $avg=$this->vote_model->getavg_info($s_where1);
            $check_if_voted=$this->vote_model->check_whether_voted($_SERVER['REMOTE_ADDR'],$id);

            $data['isRated'] = $check_if_voted;
            $data['avg_rate']=round($avg['i_total']);

        /****************************AVG RATING*************************************/	
		
		/****************************Popular Stores************************************/         

            $data['popular_store'] = $this->store_model->get_list(array('i_is_active' => '1', 'i_is_hot' => 1), 'i_id,s_store_title,s_url,s_store_logo,s_cash_back',5);
			
			foreach($data['popular_store'] as $key=>$val)
			{
				$data['popular_store'][$key]['deal_count']	= $this->store_model->get_store_deal_count(" WHERE (CONCAT(DATE(dt_exp_date),' 23:59:59')> now() OR dt_exp_date = 0) AND i_coupon_type = 1 AND i_is_active=1 AND i_store_id={$val['i_id']}");
			}

        /****************************Popular Stores************************************/
		
		/****************************Top Stores************************************/         

            $data['top_store'] = $this->store_model->get_list(array('i_is_active' => '1', 'i_is_top' => 1), 'i_id,s_store_title,s_url,s_store_logo,s_cash_back',5);
			
			foreach($data['top_store'] as $key=>$val)
			{
				$data['top_store'][$key]['deal_count']	= $this->store_model->get_store_deal_count(" WHERE (CONCAT(DATE(dt_exp_date),' 23:59:59')> now() OR dt_exp_date = 0) AND i_coupon_type = 1 AND i_is_active=1 AND i_store_id={$val['i_id']}");
			}

        /****************************Top Stores************************************/
		
		/****************************Max Discounted************************************/         

            $data['max_discount_store'] = $this->store_model->get_list(array('i_is_active' => '1', 'i_is_discount' => 1), 'i_id,s_store_title,s_url,s_store_logo,s_cash_back',5);
			
			foreach($data['max_discount_store'] as $key=>$val)
			{
				$data['max_discount_store'][$key]['deal_count']	= $this->store_model->get_store_deal_count(" WHERE (CONCAT(DATE(dt_exp_date),' 23:59:59')> now() OR dt_exp_date = 0) AND i_coupon_type = 1 AND i_is_active=1 AND i_store_id={$val['i_id']} ");
			}

        /****************************Max Discounted************************************/
		
		
        /*$data['dealList'] = $this->process_deal_list(array('cd_store.s_url' => $seo_url, 'dt_exp_date >=' => date('Y-m-d', time())), $searchTitle, $paging, 10, base_url() . "$seo_url/", 2);*/
		
		$where	= " cd_store.s_url = '".$seo_url."' AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ";
		
		//$data['dealList'] = $this->process_deal_list($where, $searchTitle, $paging, 12, base_url() . "$seo_url/", 2);
		/*
		 * New changes On 28 March 2014
		 * two new table cd_deals , cd_deals_brand created for deals only which
		 * data added from backend  manage_coupon.php controllers
		 * so new deal list fetched from cd_deals table
		*/
		
		$data['dealList'] = $this->process_new_deal_list($where, $searchTitle, $paging, 12, base_url() . "$seo_url/", 2);
		
		/* changed as per on 13 May 2014 , data taken from cd_store_ads table*/
		$store_ads_cond = "WHERE n.i_store_id = '".$id."' AND n.i_is_active=1 ";
		$data['store_ads_list'] = $this->store_model->fetch_store_ads_recent($store_ads_cond);
		
		$data['searchTitle'] = $searchTitle;
		//pr($data['store_ads_list'],1);
		
        $this->render($data, 'home/store_listing.tpl.php');
    }

    public function subscribe_newsletter() {

        $postedData = $this->input->post();

        $result = $this->newsletter_subscription_model->get_list(array('s_email' => $postedData['email']), 's_email', $limit = 1);

        if (!count($result)) {

            if ($this->newsletter_subscription_model->insert_data(array('s_email' => $postedData['email'],
																			'dt_entry_date'=>time()
																		)
																  ))

                echo json_encode(array('message' => 'Subscription Successful<br/>Thanks', 'status' => 'success'));
				
            else {echo $this->db->last_query();

                echo json_encode(array('message' => 'Unable to subscribe<br>Try Later', 'status' => 'error'));
            }

        } else{

            echo json_encode(array('message' => 'Already subscribed<br>Thanks', 'status' => 'error'));
        }
    }

    public function store_suggest() {

        $keyword = trim($this->input->post('keyword'));

        $store_list = NULL;

        if ($keyword != '')
		{
            $store_list = $this->store_model->get_list(NULL, NULL, 10, 0, "s_store_title",'',"s_store_title|$keyword|after");
			//pr($store_list,1);
			if(!empty($store_list))
			{
				foreach($store_list as $key=>$val)
				{
					$store_list[$key]['deal_count']	= $this->store_model->get_store_deal_count(" WHERE (CONCAT(DATE(dt_exp_date),' 23:59:59')> now() OR dt_exp_date = 0) AND i_coupon_type = 1 AND i_is_active=1 AND i_store_id={$val['i_id']} ");
					
					$store_list[$key]['txt_off'] = string_part($val["s_cash_back"],15);
				}
			}			
		}

        echo json_encode(array('status' => 'success', 'keyword' => $keyword, 'store_data' => $store_list));
    }
	
	public function product_suggest() 
	{
        $keyword = trim($this->input->post('keyword'));
        $product_list = NULL;
        if ($keyword != '')
		{
			//$condition = " WHERE (p.s_title LIKE '%".my_receive_text($keyword)."%' OR p.s_summary LIKE '%".my_receive_text($keyword)."%') ";
            //$product_list = $this->store_model->get_list(NULL, NULL, 10, 0, "s_store_title",'',"s_store_title|$keyword|after");
			
			$condition = " WHERE p.s_title LIKE '%".my_receive_text($keyword)."%' ";
			$product_list = $this->product_model->get_product_list($condition,0,10);
			
			$condition = " WHERE (u.s_title LIKE '%".my_receive_text($keyword)."%') ";
			$product_list = $this->product_model->get_product_and_store_list($condition,0,10);
		}
        echo json_encode(array('status' => 'success', 'keyword' => $keyword, 'product_data' => $product_list));
    }

    public function feedback() {

        $feedbackData = $this->input->post();

        //sleep(10);

        $mailMeta['to'] = 'kallol.b@acumensoft.info,binaysamanta@gmail.com';

        $mailMeta['from']['email'] = 'server@acumencs.com';

        $mailMeta['from']['name'] = 'Acumen Server';

        $mailMeta['subject'] = 'Visitor Feedback';

        $mailMeta['body'] = 'hi there<br>' . str_replace(array('[', '{', '}', ']'), ' ', json_encode($feedbackData));

        $this->sendmail($mailMeta);

        echo json_encode(array('status' => 'success', 'message' => 'Thank You For Your Feedback', 'data' => $feedbackData));
    }
	
	public function clear_sess()
	{
		$this->session->unset_userdata('posted_filter');		
	}
	
    public function filter_list($paging = 0) {

        /*  * grab all post data* */

        $posted_filter = $this->input->post();
		
		//print_r($posted_filter);
		
        /*  * set it to session basicalliy used for pagination only* */

        if (isset($posted_filter['chk_post']) && $posted_filter['chk_post'] == 1) {		
			$this->session->set_userdata('posted_filter', $posted_filter);           
        } else {		
			   $posted_filter = $this->session->userdata('posted_filter');
           // $this->session->set_userdata('posted_filter', $posted_filter);
        }
		
		$posted_filter	= $this->session->userdata('posted_filter');
		
		//exit;
		
        //$search_condition = array();
		 
		$search_condition = ' 1';
		
		 /* * if have to show the product expired or not* */

        $show_expired = intval(isset($posted_filter['show_expired']) && $posted_filter['show_expired']!='' ? $posted_filter['show_expired'] : 0);

        //$search_condition = array_merge($search_condition, array('dt_exp_date >=' => date('Y-m-d', $show_expired ? 0 : time())));
		
		if(isset($posted_filter['show_expired']) && $posted_filter['show_expired']!='' )
		{
			$non_expired_cond	= '';
		
			if($show_expired==1)
			{
				//$search_condition = array_merge($search_condition, array("CONCAT(DATE(dt_exp_date),' 23:59:59')<" => now()));
				
				$search_condition .= " AND (CONCAT(DATE(dt_exp_date),' 23:59:59') < '".now()."'  AND dt_exp_date != 0)";			
			}
			else
			{
				//$search_condition = array_merge($search_condition, array("CONCAT(DATE(dt_exp_date),' 23:59:59')>=" => now()));
				
				$search_condition .= " AND (CONCAT(DATE(dt_exp_date),' 23:59:59') >= '".now()."' OR dt_exp_date = 0)";			
			}
		}
		else
		{
			$non_expired_cond	= "  AND (CONCAT(DATE(dt_exp_date),' 23:59:59') >= '".now()."' OR dt_exp_date = 0)";
		}
		

        /* * grab the price range from ; seperated format* */

        //$price_range = explode(';', $posted_filter['price_range']);
		
				
		
		if(isset($posted_filter['discount_range']) && $posted_filter['discount_range']!='')
		{
			$discount_range = explode(',', $posted_filter['discount_range']);
	
			if(is_array($discount_range)) 
			{
				/*$search_condition = array_merge($search_condition, array(
	
					'd_selling_price <=' => ($price_range[1] != '30000') ? $price_range[1] : 10000000000,
	
					'd_selling_price >=' => $price_range[0],));*/
					
				/*$search_condition .= " AND d_selling_price <= '".(($price_range[1] != '30000') ? $price_range[1] : 10000000000)."' AND d_selling_price >= '".$price_range[0]."' ";*/
				$search_condition .= " AND d_discount <= '".($discount_range[1])."' AND d_discount >= '".$discount_range[0]."'".$non_expired_cond;
			}
		
		}
       
		
        /* * grab all list of selected stores* */

        if (isset($posted_filter['selected_stores']) && $posted_filter['selected_stores']!= '') 
		{
            $choosen_store = implode(',', $posted_filter['selected_stores']);

            //$search_condition = array_merge($search_condition, array("i_store_id in($choosen_store) AND 1 >=" => '1'));
			
			$search_condition .= " AND i_store_id in($choosen_store)".$non_expired_cond;
        }
		
		 /* * grab all list of selected categories* */

        if (isset($posted_filter['selected_categories']) && $posted_filter['selected_categories']!= '') {

            $choosen_cat = implode(',', $posted_filter['selected_categories']);

            //$search_condition = array_merge($search_condition, array("cd_coupon.i_cat_id in($choosen_cat) AND 1 >=" => '1'));
			
			$search_condition .= " AND cd_coupon.i_cat_id in($choosen_cat) ".$non_expired_cond;

        }
		
		if (isset($posted_filter['dt_date_of_entry']) && $posted_filter['dt_date_of_entry']!= '') {
			
            //$choosen_cat = implode(',', $posted_filter['selected_categories']);
			
			//$search_condition = array_merge($search_condition, array("DATE(dt_date_of_entry)" => $posted_filter['dt_date_of_entry']));
			$search_condition .= " AND DATE(dt_date_of_entry) = '".$posted_filter['dt_date_of_entry']."' ".$non_expired_cond;
        }

        /* * if show expired coupon* */

        /* * if show expired coupon* */

        /* create pagination data structure */
				
	    $data['dealList'] = $this->process_deal_list($search_condition, 'Advance Search', $paging, 36, base_url() . 'home/filter_list/', 3, NULL, TRUE);		

        /* * generate ajax view of filtered list */

        //$this->load->view('elements/deal_list.tpl.php', $data);
		echo $data['dealList'];
    }
	
	 public function filter_list_for_home($paging = 0) {

        /*         * grab all post data* */
		$posted_filter	= $this->session->userdata('posted_filter');
		 
        //$posted_filter = $this->input->post();
		
        /*         * set it to session basicalliy used for pagination only* */

        /*if ($posted_filter == NULL) {
            $posted_filter = $this->session->userdata('posted_filter');
        } else {

            $this->session->set_userdata('posted_filter', $posted_filter);
        }*/
		 
		//$search_condition = array();
		
		$search_condition = ' 1';
		
		 /* * if have to show the product expired or not* */

        $show_expired = intval(isset($posted_filter['show_expired']) && $posted_filter['show_expired']!='' ? $posted_filter['show_expired'] : 0);

        //$search_condition = array_merge($search_condition, array('dt_exp_date >=' => date('Y-m-d', $show_expired ? 0 : time())));
		
		if(isset($posted_filter['show_expired']) && $posted_filter['show_expired']!='' )
		{
			$non_expired_cond	= '';
		
			if($show_expired==1)
			{
				//$search_condition = array_merge($search_condition, array("CONCAT(DATE(dt_exp_date),' 23:59:59')<" => now()));				
				$search_condition .= " AND (CONCAT(DATE(dt_exp_date),' 23:59:59') < '".now()."'  AND dt_exp_date != 0)";			
			}
			else
			{
				//$search_condition = array_merge($search_condition, array("CONCAT(DATE(dt_exp_date),' 23:59:59')>=" => now()));				
				$search_condition .= " AND (CONCAT(DATE(dt_exp_date),' 23:59:59') >= '".now()."' OR dt_exp_date = 0)";			
			}
		}
		else
		{
			$non_expired_cond	= "  AND (CONCAT(DATE(dt_exp_date),' 23:59:59') >= '".now()."' OR dt_exp_date = 0)";
		}		

        /* * grab the price range from ; seperated format* */

        //$price_range = explode(';', $posted_filter['price_range']);				
		
		if(isset($posted_filter['discount_range']) && $posted_filter['discount_range']!='')
		{
			$discount_range = explode(',', $posted_filter['discount_range']);
	
			if(is_array($discount_range)) 
			{
				/*$search_condition = array_merge($search_condition, array(
	
					'd_selling_price <=' => ($price_range[1] != '30000') ? $price_range[1] : 10000000000,
	
					'd_selling_price >=' => $price_range[0],));*/
					
				/*$search_condition .= " AND d_selling_price <= '".(($price_range[1] != '30000') ? $price_range[1] : 10000000000)."' AND d_selling_price >= '".$price_range[0]."' ";*/
				$search_condition .= " AND d_discount <= '".($discount_range[1])."' AND d_discount >= '".$discount_range[0]."'".$non_expired_cond;
			}		
		}       
		
        /* * grab all list of selected stores* */

        if (isset($posted_filter['selected_stores']) && $posted_filter['selected_stores']!= '') 
		{
            $choosen_store = implode(',', $posted_filter['selected_stores']);

            //$search_condition = array_merge($search_condition, array("i_store_id in($choosen_store) AND 1 >=" => '1'));
			
			$search_condition .= " AND i_store_id in($choosen_store)".$non_expired_cond;
        }
		
		 /* * grab all list of selected categories* */

        if (isset($posted_filter['selected_categories']) && $posted_filter['selected_categories']!= '') {

            $choosen_cat = implode(',', $posted_filter['selected_categories']);

            //$search_condition = array_merge($search_condition, array("cd_coupon.i_cat_id in($choosen_cat) AND 1 >=" => '1'));
			
			$search_condition .= " AND cd_coupon.i_cat_id in($choosen_cat) ".$non_expired_cond;
        }
		
		if (isset($posted_filter['dt_date_of_entry']) && $posted_filter['dt_date_of_entry']!= '') {
			
            //$choosen_cat = implode(',', $posted_filter['selected_categories']);
			
			//$search_condition = array_merge($search_condition, array("DATE(dt_date_of_entry)" => $posted_filter['dt_date_of_entry']));
			$search_condition .= " AND DATE(dt_date_of_entry) = '".$posted_filter['dt_date_of_entry']."' ".$non_expired_cond;
        }

        /* * if show expired coupon* */

        /* * if show expired coupon* */

        /* create pagination data structure */
		
	    $data['dealList'] = $this->process_deal_list($search_condition, 'Advance Search', $paging, 36, base_url() . 'home/filter_list_for_home/', 3, NULL, TRUE);		

		//echo $this->db->last_query();exit;

        /* * generate ajax view of filtered list */

        echo $this->load->view('elements/deal_list.tpl.php', $data, true);		
    }
	
	
    public function track_url($id) {

        $data = array('title' => 'Title');

        $current_user_session = $this->session->userdata('current_user_session');

        $deal_meta = $this->deal_model->get_joined_list(array('cd_coupon.i_id' => $id), 'cd_coupon.i_id,cd_coupon.s_url,s_store_url,i_cashback');

        if ($deal_meta[0]['i_cashback']) {

            if (!$current_user_session) {

                $this->session->set_userdata('cash_back_request', $id);

                redirect(base_url() . 'user/signup');
            }

        }

        $UID = isset($current_user_session[0]['s_uid']) ? $current_user_session[0]['s_uid'] : 'GUEST';

        $URL = $deal_meta[0]['s_store_url'] . '&UID=' . $current_user_session[0]['s_uid'] . '&redirect=' . urlencode($deal_meta[0]['s_url']);
        $dataToSave = array(

            'i_user_id' => $current_user_session[0]['i_id'],

            'i_deal_id' => $deal_meta[0]['i_id'],

            'i_is_cashback' => $deal_meta[0]['i_cashback'] ? 1 : 0,

            'txt_extra' => json_encode(array('SERVER' => $_SERVER, 'URL' => $URL))

        );

        $this->user_deals_model->insert_data($dataToSave);

//       /pr($URL);

        redirect($URL);

    }



    public function rateit() {

        $i_deal_id = $this->input->post('id');

        $f_value = $this->input->post('value');

        $i_ip = $this->input->ip_address();



        $dataToSave = array(

            'i_deal_id' => $i_deal_id,

            'f_value' => $f_value,

            'i_ip' => $i_ip,

        );

        $this->load->model('rateit_model');

        $this->rateit_model->insert_data($dataToSave);

    }



    public function rateit_status($i_deal_id,$echoOutput = true) {

        $this->load->model('rateit_model');

        $rateData = $this->rateit_model->get_groupby_rate($i_deal_id);

        $rateProcessedData = array();

        $rateProcessedData['total'] = 0;

        $rateProcessedData['totalPoint'] = 0;

        $totalPoint = 0;

        foreach ($rateData as  $value) {

            $rateProcessedData['data'][$value['f_value']] = $value['total_count'];

            $rateProcessedData['total'] += $value['total_count'];

            $rateProcessedData['totalPoint'] += $value['f_value']*$value['total_count'];

            

        }

        $rateProcessedData['average'] = $rateProcessedData['total']?($rateProcessedData['totalPoint']/$rateProcessedData['total']):0;

        $rateProcessedData['data'] = array_replace(array(1=>0,2=>0,3=>0,4=>0,5=>0),isset($rateProcessedData['data'])?$rateProcessedData['data']:array());

        if($echoOutput){

            echo json_encode($rateProcessedData);

        }
        return $rateProcessedData;
    }
	
	//------------------------------Submit Deal Starts---------------------------------------------//	
	
	public function submit_a_deal_old6Mar2014()
	{
		try
		{			
			$this->data['heading']	= "Submit a Deal";
			$this->data['title'] 	= "Submit a Deal";// /Browser Title
						
			if($_POST)
			{
					$posted = array();
					$posted['deal_url'] 		= trim($this->input->post("deal_url"));
					$posted['deal_title'] 		= trim($this->input->post("deal_title"));
					$posted['deal_price'] 		= trim($this->input->post("deal_price"));
					$posted['email'] 			= trim($this->input->post("email"));
					$posted['deal_exp_date'] 	= trim($this->input->post("deal_exp_date"));
					$posted['deal_description'] = trim($this->input->post("deal_description"));
					
					$this->form_validation->set_rules('deal_url', 'deal url', 'required|callback__url_valid');
					$this->form_validation->set_rules('deal_title', 'deal title', 'required');
					$this->form_validation->set_rules('deal_price', 'deal price', 'required');
					$this->form_validation->set_rules('email', 'email', 'required|valid_email');
					$this->form_validation->set_rules('deal_description', 'deal description', 'required');
					$this->form_validation->set_rules('txt_captcha',' captcha', 'required|trim|callback__captcha_valid');
				
				if($this->form_validation->run() == FALSE ) // validation false (error occur)
				{              
					$this->data["posted"]   =   $posted ;
				}
				else
				{				
					$this->load->model('auto_mail_model','mod_auto');
					$this->load->model('site_settings_model','mod_rect');
					
					$info			= $this->mod_rect->fetch_this(NULL);
					
					$admin_email	= $info['s_admin_email'];
					$content 		= $this->mod_auto->fetch_mail_content('submit_a_deal','general');    
					
					$s_subject 		= $content['s_subject'];						
					$filename   	= $this->config->item('EMAILBODYHTML')."common.html";
					$handle     	= @fopen($filename, "r");
					$mail_html  	= @fread($handle, filesize($filename));  
					
					if(!empty($content))
					{                            
						$description = $content["s_content"];
						$description = str_replace("[DEAL_URL]",$posted['deal_url'],$description);
						$description = str_replace("[DEAL_TITLE]",$posted['deal_title'],$description);
						$description = str_replace("[DEAL_PRICE]",$posted['deal_price'],$description);
						$description = str_replace("[EMAIL]",$posted['email'],$description);
						$description = str_replace("[EXPIRY_DATE]",$posted['deal_exp_date'],$description);
						$description = str_replace("[DEAL_DESCRIPTION]",nl2br($posted['deal_description']),$description);	 
					}
					
				  unset($content);
				  
				  $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);					 
				  $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);
								  
				  //$admin_email = $this->s_admin_email; 			  
				  //echo $mail_html;exit;
				  //$i_sent = sendMail($admin_email,$s_subject,$mail_html,$posted['txt_email_address']);
				  
				  //pr($mail_record,1);
				  
				  $i_sent = sendMail($admin_email,$s_subject,$mail_html,$posted['email']);
				
				  if($i_sent)
				  {
					  /*$info_mail=array();
					  $info_mail['s_subject']	= $s_subject;
					  $info_mail['s_message']	= $posted['txt_comments'];
					  $info_mail['s_from']	 	= $posted['txt_email_address'];
					  $info_mail['dt_date']  	= now();
					  $mail_record				= $this->mail_recieved_model->add_info($info_mail);*/
					  
					  $this->session->set_userdata(array('message'=>$this->cls_msg["deal_submit_succ"],'message_type'=>'succ'));
					  redirect(base_url()."home/submit_a_deal");
				  }
				  else
				  {
					$this->session->set_userdata(array('message'=>$this->cls_msg["deal_submit_err"],'message_type'=>'err'));
					redirect(base_url()."home/submit_a_deal");
				  }					
				}   // end of else part
			}
			
		    $this->render($this->data, 'home/submit_a_deal.tpl.php'); 		
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
	}
	
	public function submit_a_deal()
	{
		try
		{			
			$this->data['heading']	= "Submit a Deal";
			$this->data['title'] 	= "Submit a Deal";// /Browser Title
						
			if($_POST)
			{
					$posted = array();
					$posted['deal_url'] 		= trim($this->input->post("deal_url"));
					$posted['deal_email'] 		= trim($this->input->post("deal_email"));
					$posted['deal_description'] = trim($this->input->post("deal_description"));
					
					$posted['deal_store'] 		= ($this->input->post("deal_store"));
					$posted['deal_code'] 		= trim($this->input->post("deal_code"));
					$posted['deal_date_start'] 	= trim($this->input->post("deal_date_start"));
					$posted['deal_date_end'] 	= trim($this->input->post("deal_date_end"));
					$posted['deal_price'] 		= trim($this->input->post("deal_price"));
					$posted['deal_list_price']	= trim($this->input->post("deal_list_price"));
					$posted['deal_discount']	= trim($this->input->post("deal_discount"));
					$posted['deal_description'] = trim($this->input->post("deal_description"));
					
					$this->form_validation->set_rules('deal_url', 'deal url', 'required|callback__url_valid');
					$this->form_validation->set_rules('deal_email', 'email', 'required|valid_email');
					$this->form_validation->set_rules('deal_description', 'deal description', 'required');
					$this->form_validation->set_rules('txt_captcha',' captcha', 'required|trim|callback__captcha_valid');
				
				if($this->form_validation->run() == FALSE ) // validation false (error occur)
				{              
					$this->data["posted"]   =   $posted ;
				}
				else
				{				
					$this->load->model('auto_mail_model','mod_auto');
					$this->load->model('site_settings_model','mod_rect');
					
					$info			= $this->mod_rect->fetch_this(NULL);
					
					$admin_email	= $info['s_admin_email'];
					$content 		= $this->mod_auto->fetch_mail_content('submit_a_deal','general');    
					
					$s_subject 		= $content['s_subject'];						
					$filename   	= $this->config->item('EMAILBODYHTML')."common.html";
					$handle     	= @fopen($filename, "r");
					$mail_html  	= @fread($handle, filesize($filename));  
					
					if(!empty($content))
					{                            
						$description = $content["s_content"];
						$description = str_replace("[DEAL_URL]",$posted['deal_url'],$description);
						$description = str_replace("[DEAL_STORE]",getStoreTitles($posted['deal_store']),$description);
						$description = str_replace("[DEAL_CODE]",$posted['deal_code'],$description);
						$description = str_replace("[EMAIL]",$posted['deal_email'],$description);
						$description = str_replace("[DEAL_START]",$posted['deal_date_start'],$description);
						$description = str_replace("[DEAL_END]",$posted['deal_date_end'],$description);
						
						$description = str_replace("[DEAL_PRICE]",$posted['deal_price'],$description);
						$description = str_replace("[DEAL_LIST]",$posted['deal_list_price'],$description);
						$description = str_replace("[DEAL_DISCOUNT]",$posted['deal_discount'],$description);
						$description = str_replace("[DEAL_DESCRIPTION]",nl2br($posted['deal_description']),$description);	 
					}
					
				  unset($content);
				  
				  $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);					 
				  $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);
								  				  
				  //pr($mail_html,1);
				  $admin_email = 'submit@mydealfound.com';
				  $i_sent = sendMail($admin_email,$s_subject,$mail_html,$posted['deal_email']);
				
				  if($i_sent)
				  {
					  /*$info_mail=array();
					  $info_mail['s_subject']	= $s_subject;
					  $info_mail['s_message']	= $posted['txt_comments'];
					  $info_mail['s_from']	 	= $posted['txt_email_address'];
					  $info_mail['dt_date']  	= now();
					  $mail_record				= $this->mail_recieved_model->add_info($info_mail);*/
					  
					  $this->session->set_userdata(array('message'=>$this->cls_msg["deal_submit_succ"],'message_type'=>'succ'));
					  redirect(base_url()."home/submit_a_deal");
				  }
				  else
				  {
					$this->session->set_userdata(array('message'=>$this->cls_msg["deal_submit_err"],'message_type'=>'err'));
					redirect(base_url()."home/submit_a_deal");
				  }					
				}   // end of else part
			}
			
		    $this->render($this->data, 'home/submit_a_deal.tpl.php'); 		
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
	}
	
	//------------------------------Submit Deal ends---------------------------------------------//	
	
	function _captcha_valid($s_captcha)
    {
        if($s_captcha!=$_SESSION["captcha"])
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
	
	function _url_valid($s_url)
    {
		if(preg_match( '/^(http|https):\/\/[a-z0-9_]+([\-\.]{1}[a-z_0-9]+)*\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\/.*)?$/i' ,$s_url))
		{
			return true;
		}
	    else
        {
			$this->form_validation->set_message('_url_valid', 'Please provide valid URL.');
			unset($s_captcha);
            return false;
        }
    }
	
	
	public function add_vote()
    {
        try
        {	
			$this->load->model('vote_model');
            if($_POST){
                $info = array();
                $info['i_vote'] 	=$this->input->post('rating');
                $info['i_ip']	  =     $_SERVER['REMOTE_ADDR'];
                $info['i_store_id']= trim($this->input->post('store_id'));
                if(!$check_if_voted)
                {
                    $vote=$this->vote_model->add_info($info);
                    if($vote)
                    {
                        $s_where=" WHERE i_store_id=".$info['i_store_id'];
                        $total=$this->vote_model->gettotal_info($s_where);
                        $s_where1=" WHERE i_store_id=".$info['i_store_id'];
                        $avg=$this->vote_model->getavg_info($s_where1);
                        //echo $total.'|'.round($avg['i_total']).'|'.'Thanks for voting';
                        echo  json_encode(array('total'=>$total,'avg'=>round($avg['i_total']),'msg'=>'Thanks for voting','status'=>'success','current_vote'=>  intval($info['i_vote'])));
                    } else {
                        echo  json_encode(array('msg'=>'Something went wrong','status'=>'error'));
                    }
                } else {
                    $s_where=" WHERE i_store_id=".$info['i_store_id'];
                    $total=$this->vote_model->gettotal_info($s_where);
                    $s_where1=" WHERE i_store_id=".$info['i_store_id'];
                    $avg=$this->vote_model->getavg_info($s_where1);
                    echo json_encode(array('total'=>$total,'avg'=>round($avg['i_total']),'msg'=>'You have already voted for this store','status'=>'error'));
                }

            }

        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    

    }
	
	public function comment_post2()
	{
		$this->load->model('coupon_comment_model');
		$this->load->model('store_comment_model');	
		
		try
		{		
			$name		=	$this->input->post('name');
			$comment	=	$this->input->post('comment');
			$i_id       =	$this->input->post('id');
			$type       =	$this->input->post('type');
	
			$id = 0;
			//echo $name.$comment;
			$info= array();
			$info['s_commented_by_email']      =	$name;
			$info['s_comments']		   		   =	$comment;
			$info['i_is_active']       		   =	0;
			
			if($type=='coupon')
			{
				 $info['i_coupon_id']	   	=	$i_id;
				 $id						=	$this->coupon_comment_model->add_coupon_comment($info); 
			} 
			
			if($type=='store')
			{
			 	$info['i_store_id']			=	$i_id;
			 	$id							=	$this->store_comment_model->add_store_comment($info); 
			}
			
			if($id)
			{
				echo trim('ok');
			}
			else
			{
				echo trim('err');
			}
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	}
	
	/* MM Mar 2014 */
	public function fetch_deal_detail() 
	{
		$deal_id = $this->input->post('dealID');
        $dealListCondition = array('i_id' => $deal_id);

        $dealListData = $this->deal_model->get_active_deal_list($dealListCondition, 'cd_coupon.i_id,s_title,cd_coupon.s_url,s_image_url,d_list_price,d_selling_price,d_discount', 1, 0);		

        echo json_encode($dealListData[0]);
    }
	
	
    public function save_price_alert() {

        $postedData = $this->input->post();
        $listData = $this->deal_model->count_total_deal_alert(
                array(
                    's_email' => trim($postedData['email']),
                    'i_deal_id' => trim($postedData['h_deal_id']),
					'd_price' => trim($postedData['less_price'])
                ));
				
		

        if ($listData*1>0) {
            echo json_encode(array('status' => 'error', 'message' => 'This deal alert already exist'));

        } else if($listData*1==0) {
			$new_arr = array();
			$new_arr['s_email'] = $postedData['email'];
			$new_arr['i_deal_id'] = $postedData['h_deal_id'];
			$new_arr['d_price'] = $postedData['less_price'];
			$new_arr['dt_create'] = date("Y-m-d H:i:s",time());
			
			$i_ins = $this->deal_model->insert_deal_alert($new_arr);
			if($i_ins)
            	echo json_encode(array('status' => 'success', 'message' => 'Data saved'));
			else
				echo json_encode(array('status' => 'error', 'message' => 'Data failed to save'));
        }else {
            echo json_encode(array('status' => 'error', 'message' => 'Data failed to save'));
        }

    }


	/* cron for data entry from feeds
	* https://admin.omgpm.com/v2/reports/affiliate/leads/leadsummaryexport.aspx?Contact=519376&Country=26&Agency=95&Status=-1&Year=2014&Month=3&Day=1&EndYear=2014&EndMonth=3&EndDay=18&DateType=0&Sort=CompletionDate&Login=7EF2CBA5FD38DEC5D11B2BE81AD47190&Format=XML&RestrictURL=0
	* dynamically generate yesterday date as &Year=2014&Month=3&Day=1&
	* dynamically generate today date as &EndYear=2014&EndMonth=3&EndDay=18&
	*/
	
	
	public function cashback_master()
	{
		$this->load->model('cron_model');
		$endDate = date('Y-m-d H:i:s');
		$endY = date('Y', strtotime($endDate));
		$endM = date('n', strtotime($endDate));
		$endD = date('j', strtotime($endDate));
		
		$startDate = date('Y-m-d H:i:s',strtotime("-1 days"));
		$startY = date('Y', strtotime($startDate));
		$startM = date('n', strtotime($startDate));
		$startD = date('j', strtotime($startDate));
		
		$str = "&Year=$startY&Month=$startM&Day=$startD&EndYear=$endY&EndMonth=$endM&EndDay=$endD&";		
		$generatedUrl = "https://admin.omgpm.com/v2/reports/affiliate/leads/leadsummaryexport.aspx?Contact=519376&Country=26&Agency=95&Status=-1".$str."DateType=0&Sort=CompletionDate&Login=7EF2CBA5FD38DEC5D11B2BE81AD47190&Format=XML&RestrictURL=0";		
		//echo $generatedUrl;
		
		//$generatedUrl = "http://feeds.omgeu.com/data/feed.aspx?hash=a72d4fed604a46c6b44cd495537b62f5&page=1";
		//$generatedUrl = "https://admin.omgpm.com/v2/reports/affiliate/leads/leadsummaryexport.aspx?Contact=519376&Country=26&Agency=95&Status=-1&Year=2014&Month=3&Day=1&EndYear=2014&EndMonth=3&EndDay=18&DateType=0&Sort=CompletionDate&Login=7EF2CBA5FD38DEC5D11B2BE81AD47190&Format=XML&RestrictURL=0";
		$url=$generatedUrl;
		
		/* help url for 
		* https http://stackoverflow.com/questions/11883575/problems-getting-xml-content-via-https-using-simplexml-and-php
		*/
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents		
		$data = curl_exec($ch); // execute curl request
		curl_close($ch);		
		$xml_data = simplexml_load_string($data);
		/*echo '<pre>';
		print_r($xml); 
		echo '</pre>';exit;*/
		if(!empty($xml_data))
		{
			$prod_arr = $xml_data->Report->Report_Details_Group_Collection->Report_Details_Group;
			//echo '<pre>';	print_r($prod_arr); 	echo '</pre>';						
			if(!empty($prod_arr))
			{
				foreach($prod_arr as $key=>$val)
				{
					$elem_obj = $val;  // object for a single product
					$ProductAttr 	= (array)$elem_obj;
					//echo '<pre>';	print_r($ProductAttr); 	echo '</pre>';	
					
					if(!empty($ProductAttr))
					{
						foreach($ProductAttr as $val)
						{
							$new_arr = array();
							$new_Arr["TransactionId"] 		= $val["TransactionId"];
							$new_Arr["UID"] 				= $val["UID"];
							$new_Arr["MID"] 				= $val["MID"];
							$new_Arr["Merchant"] 			= $val["Merchant"];
							$new_Arr["PID"] 				= $val["PID"];
							$new_Arr["Product"] 			= $val["Product"];
							$new_Arr["SR"] 					= $val["SR"];
							$new_Arr["VR"] 					= $val["VR"];
							$new_Arr["NVR"] 				= $val["NVR"];
							$new_Arr["Status"] 				= $val["Status"];
							$new_Arr["Paid"] 				= $val["Paid"];
							$new_Arr["UKey"] 				= $val["UKey"];
							$new_Arr["TransactionValue"] 	= $val["TransactionValue"];
							$new_Arr["Completed"] 			= date("Y-m-d H:i:s",strtotime($val["Completed"]));
							$new_Arr["ClickTime"] 			= date("Y-m-d H:i:s",strtotime($val["ClickTime"]));
							$new_Arr["TransactionTime"] 	= date("Y-m-d H:i:s",strtotime($val["TransactionTime"]));
							
							$i_ins = $this->cron_model->insert_cashback($new_Arr);
							
						}
					}
					
				}
				echo 'Data inserted succesfully';
			}
		}
					
	}
	
	
}