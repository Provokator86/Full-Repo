<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */



/**

 * Description of home

 *

 * @author Kallol

 */

class Start extends MY_Controller {



    //put your code here

    public function __construct() {

        parent::__construct();

    }

    public function index($paging = 0) {

		$posted_filter	= $this->session->userdata('posted_filter');
		
		pr($posted_filter);exit;
        $data = array('title' => 'Title');

        $data['popular_store'] = $this->store_model->get_list(array('i_is_active' => '1', 'i_is_hot' => 1), 'i_id,s_store_title,s_url,s_store_logo', 16);

        $data['store_list'] = $this->store_model->get_list(array('i_is_active' => '1'), 'i_id,s_store_title,s_url,s_store_logo', NULL);
        $featured_deals = $this->deal_model->get_active_deal_list(" i_is_featured=1 AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ", 'i_id,s_title,s_image_url,s_seo_url');
		
        $popular_deals = $this->deal_model->get_active_deal_list(" i_is_popular=1 AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ",'i_id,s_title,s_url,s_image_url,s_meta_description,s_seo_url,s_summary');

        //pr($popular_deals);Thursday, 13th June, 2013 		
		
		if(isset($posted_filter) && !empty($posted_filter))
		{			
			 $display_homepage_listing = $this->filter_list_for_home($paging);
		}
		else
		{
        	$display_homepage_listing = $this->list_daily_deal($paging);				
		}

        $data['featured_deals'] = $featured_deals;
		$data['display_homepage_listing'] = $display_homepage_listing;
        $data['popular_deals'] = $popular_deals;

        $this->render($data);
    }

    public function list_daily_deal($paging = 0) {

        //return $this->process_deal_list(array('i_is_daily' => 1, 'dt_exp_date >=' => date('Y-m-d', time())), date('l, jS M,Y', time()), $paging, 6, base_url() . 'home/index/');
		
		$where	= " i_is_daily=1 AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ";
		
		//$where	= " (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ";
		
		return $this->process_deal_list($where, "Latest Deals", $paging, 36, base_url() . 'home/index/');
    }

    private function detail($seo_url = '') 
	{
        $dealListCondition = array('s_seo_url' => $seo_url);

        $dealListData = $this->deal_model->get_joined_active_deal_list($dealListCondition, 'cd_coupon.i_id,cd_coupon.s_summary ,s_title,s_store_title,s_store_logo,s_store_logo,cd_coupon.s_url,cd_coupon.s_video,cd_coupon.s_url,s_store_url,s_image_url,cd_store.s_about_us ,cd_coupon.s_meta_description as coupon_meta,d_list_price,d_selling_price,d_discount,i_cashback,dt_date_of_entry,cd_category.s_category', 1, 0);

        $data['dealMeta'] = $dealListData[0];

        $data['dealMeta']['rateit_status'] = $this->rateit_status($dealListData[0]['i_id'],FALSE);

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

    public function top_deals($paging = 0) {	
		
       /* $data['dealList'] = $this->process_deal_list(array('cd_coupon.i_is_hot' => 1, 'dt_exp_date >=' => date('Y-m-d', time())), 'Top Deals', $paging, 8, base_url() . 'top-deals/', 2);*/
	   
	   $where	= " cd_coupon.i_is_hot=1 AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ";
	   $data['dealList'] = $this->process_deal_list($where, 'Top Deals', $paging, 8, base_url() . 'top-deals/', 2);	   

        $this->render($data, 'home/listing.tpl.php');
    }

    public function daily_deals($paging = 0) {

        /*$data['dealList'] = $this->process_deal_list(array('i_is_daily' => 1, 'dt_exp_date >=' => date('Y-m-d', time())), 'Daily Deals', $paging, 8, base_url() . 'daily-deals/', 2,'','', array('dt_exp_date' => 0));*/
		
		$where	= " i_is_daily=1 AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ";
	    $data['dealList'] = $this->process_deal_list($where, 'Daily Deals', $paging, 8, base_url() . 'daily-deals/', 2);	

        $this->render($data, 'home/listing.tpl.php');
    }
	
    public function popular_deals($paging = 0) {

        /*$data['dealList'] = $this->process_deal_list(array('i_is_popular' => 1, 'dt_exp_date >=' => date('Y-m-d', time())), 'Popular Deals', $paging, 8, base_url() . 'popular-deals/', 2,'','', array('dt_exp_date' => 0));*/
		
		$where	= " i_is_popular=1 AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ";
		
		$data['dealList'] = $this->process_deal_list($where, 'Popular Deals', $paging, 8, base_url() . 'popular-deals/', 2);

        $this->render($data, 'home/listing.tpl.php');

    }



    public function search() {

        $location = intval($this->input->post('location'));

        $paging = intval($this->uri->segment(3));

        $keyword = $this->input->post('keyword');

        if (!$keyword) {

            $keyword = $this->uri->segment(2);

        }

        if ($keyword || $location) {

            $searchTitle = "Search Result: $keyword";

            $likeCondition = array('s_title' => $keyword);

           /* $data['dealList'] = $this->process_deal_list(array('i_location_id' => $location, 'dt_exp_date >=' => date('Y-m-d', time())), $searchTitle, $paging, 1, base_url() . 'search/' . $keyword, 3, $likeCondition);*/
			
			$where	= " i_location_id = '".$location."' AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ";
			
			 $data['dealList'] = $this->process_deal_list($where, $searchTitle, $paging, 1, base_url() . 'search/' . $keyword, 3, $likeCondition);

            $this->render($data, 'home/listing.tpl.php');

        } else {

            $data['url'] = 'Please Search Again';

            echo $this->render($data, '404.tpl.php', TRUE);

        }

    }



    public function list_deal_in_store($seo_url = NULL, $paging = 0) {

        $searchTitle = ucfirst($seo_url) . ' Deals';

        /*$data['dealList'] = $this->process_deal_list(array('cd_store.s_url' => $seo_url, 'dt_exp_date >=' => date('Y-m-d', time())), $searchTitle, $paging, 10, base_url() . "$seo_url/", 2);*/
		
		$where	= " cd_store.s_url = '".$seo_url."' AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ";
		
		$data['dealList'] = $this->process_deal_list($where, $searchTitle, $paging, 12, base_url() . "$seo_url/", 2);

        $this->render($data, 'home/listing.tpl.php');

    }



    public function subscribe_newsletter() {

        $postedData = $this->input->post();

        $result = $this->newsletter_subscription_model->get_list(array('s_email' => $postedData['email']), 's_email', $limit = 1);

        if (!count($result)) {

            if ($this->newsletter_subscription_model->insert_data(array('s_email' => $postedData['email'])))

                echo json_encode(array('message' => 'Subscription Successful<br/>Thanks', 'status' => 'success'));

            else {

                echo json_encode(array('message' => 'Unable to subscribe<br>Try Later', 'status' => 'error'));

            }

        } else {

            echo json_encode(array('message' => 'Already subscribed<br>Thanks', 'status' => 'error'));
        }
    }

    public function store_suggest() {

        $keyword = trim($this->input->post('keyword'));

        $store_list = NULL;

        if ($keyword != '')
		{
            $store_list = $this->store_model->get_list(NULL, NULL, 10, 0, "s_store_title",'',"s_store_title|$keyword|after");
			
			foreach($store_list as $key=>$val)
			{
				$store_list[$key]['deal_count']	= $this->store_model->get_store_deal_count(" WHERE (CONCAT(DATE(dt_exp_date),' 23:59:59')> now() OR dt_exp_date = 0) AND i_coupon_type = 1 AND i_is_active=1 AND I_store_id={$val['i_id']} ");
			}			
		}

        echo json_encode(array('status' => 'success', 'keyword' => $keyword, 'store_data' => $store_list));
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
	
    public function filter_list($paging = 0) {

        /*  * grab all post data* */

        $posted_filter = $this->input->post();
		
        /*  * set it to session basicalliy used for pagination only* */

        if ($posted_filter == NULL) {
            $posted_filter = $this->session->userdata('posted_filter');
        } else {

            $this->session->set_userdata('posted_filter', $posted_filter);
        }
		
		$posted_filter	= $this->session->userdata('posted_filter');
		
		pr($posted_filter);
		exit;
		
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
		
	    $data['dealList'] = $this->process_deal_list($search_condition, 'Advance Search', $paging, 6, base_url() . 'home/filter_list/', 3, NULL);		

		//echo $this->db->last_query();exit;

        /* * generate ajax view of filtered list */

        return $this->load->view('elements/deal_list.tpl.php', $data);
    }
	
	 public function filter_list_for_home($paging = 0) {

        /*         * grab all post data* */

        $posted_filter = $this->input->post();
		
        /*         * set it to session basicalliy used for pagination only* */

        if ($posted_filter == NULL) {
            $posted_filter = $this->session->userdata('posted_filter');
        } else {

            $this->session->set_userdata('posted_filter', $posted_filter);
        }

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
		
	    $data['dealList'] = $this->process_deal_list($search_condition, 'Advance Search', $paging, 6, base_url() . 'home/filter_list/', 3, NULL, TRUE);		

		//echo $this->db->last_query();exit;

        /* * generate ajax view of filtered list */

        return $this->load->view('elements/deal_list.tpl.php', $data, true);
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
}