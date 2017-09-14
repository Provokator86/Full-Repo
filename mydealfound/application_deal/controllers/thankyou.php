<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Thankyou
 */

class Thankyou extends MY_Controller   {
    //put your code here
    public function __construct() {
        parent::__construct();
        //$this->load->model('user_deals_model');
    }

    

   	public function index($product_id = 0) {
        $data = array('title'=>'Thankyou');
		if(is_numeric($product_id))
		{
			$this->session->unset_userdata('product_url_clicked');
			$details = $this->product_model->get_this_product_details($product_id);
		}
		else
		{
			//redirect(base_url().'user/login');			
			redirect(base_url().'user/signup');	
		}
		$user_meta = $this->session->userdata('current_user_session');
		if(empty($user_meta))
		{
			$this->session->set_userdata('sess_ads_url_click',$details[0]["s_url"]);
			$this->session->set_userdata('product_url_clicked',$details[0]["s_url"]);
			//redirect(base_url().'user/login');	
			redirect(base_url().'user/signup');	
		}
       	if(is_numeric($product_id))
		{
			
			$data['details'] = $details[0];
			if(!empty($details))
			{
				$this->session->unset_userdata('product_url_clicked');
				// increase view count here$uid = $user_meta[0]['i_id'];
				$uid = $user_meta[0]['s_uid'];
				$data['details']["s_url"] = str_replace('MYDEALFOUNDXXX',$uid,$data['details']["s_url"]);
			
				$i_true = $this->product_model->increase_view_count($product_id);
			}
			else
				redirect(base_url());   // product not found
		}
		else
			redirect(base_url());
		
	   	$this->render($data);
    }
	
	
	public function shopdeal($deal_id = 0) {
        $data = array('title'=>'Thankyou');
		
		$details = $this->manage_deals_model->get_this_deal_details($deal_id);
		$data['details'] = $details[0];
		if($data['details']["s_url"]!='')
		{
			$this->session->set_userdata('sess_ads_url_click',$data['details']["s_url"]);
			$this->session->set_userdata('product_url_clicked',$data['details']["s_url"]);
		}
		$user_meta = $this->session->userdata('current_user_session');
		if(empty($user_meta))
		{
			redirect(base_url().'user/login');
		}
		
       	if(is_numeric($deal_id))
		{
			
			$uid = $user_meta[0]['s_uid'];
			$data['details']["s_url"] = str_replace('MYDEALFOUNDXXX',$uid,$data['details']["s_url"]);
			//pr($data['details'],1);
			if(!empty($details))
			{
				// increase view count here
				$i_true = $this->manage_deals_model->increase_deal_view_count($deal_id);
			}
			else
				redirect(base_url().'top-offers/'); 
		}
		else
			redirect(base_url().'top-offers/');
		
	   	$this->render($data);
    }
	
	
	public function shopads($store_id='', $ref_url='') {
        $data = array('title'=>'Thankyou');
		
		$ref_url = $_GET['ref_url'];
		if($ref_url)
		{
			//$this->session->set_userdata('sess_ads_url_click',$ref_url);
			$this->session->set_userdata('sess_ads_url_click',$ref_url);
			$this->session->set_userdata('product_url_clicked',$ref_url);
		}
		//echo 	$ref_url; exit;
		$user_meta = $this->session->userdata('current_user_session');
		if(empty($user_meta))
		{
			redirect(base_url().'user/login');
		}
		
       	if(is_numeric($store_id))
		{
			$uid = $user_meta[0]['s_uid'];
			//echo $ref_url;
			$data['details']["s_url"] = str_replace('MYDEALFOUNDXXX',$uid,$ref_url);
			//pr($data['details'],1);
			//redirect($data['details']["s_url"]); 
		}
		else
			redirect(base_url().'user/login/');
		
	   	$this->render($data);
    }
	
	
	public function shopnowstore($ref_url='') {
        $data = array('title'=>'Thankyou');
		$ref_url = $_GET['ref_url'];
		if($ref_url)
		{
			$this->session->set_userdata('sess_store_url_click',$ref_url);
			$this->session->set_userdata('product_url_clicked',$ref_url);
		}
		redirect(base_url().'user/login');
      
	   	$this->render($data);
    }
	
	
	public function shoptravel($deal_id = 0) {
        $data = array('title'=>'Thankyou');
		
		$details = $this->travel_model->fetch_this($deal_id);
		$data['details'] = $details[0];
		if($data['details']["s_url"]!='')
		{
			$this->session->set_userdata('sess_ads_url_click',$data['details']["s_url"]);
			$this->session->set_userdata('product_url_clicked',$data['details']["s_url"]);
		}
		$user_meta = $this->session->userdata('current_user_session');
		if(empty($user_meta))
		{
			redirect(base_url().'user/login');
		}
		
       	if(is_numeric($deal_id))
		{
			
			$uid = $user_meta[0]['s_uid'];
			$data['details']["s_url"] = str_replace('MYDEALFOUNDXXX',$uid,$data['details']["s_url"]);
			//pr($data['details'],1);
			if(!empty($details))
			{
				// increase view count here
				//$i_true = $this->manage_deals_model->increase_deal_view_count($deal_id);
			}
			else
				redirect(base_url().'travel/'); 
		}
		else
			redirect(base_url().'travel/');
		
	   	$this->render($data);
    }
	
	
	public function shopfooddining($deal_id = 0) {
        $data = array('title'=>'Thankyou');
		
		$details = $this->food_dining_model->fetch_this($deal_id);
		$data['details'] = $details[0];
		
		if($data['details']["s_url"]!='')
		{
			$this->session->set_userdata('sess_ads_url_click',$data['details']["s_url"]);
			$this->session->set_userdata('product_url_clicked',$data['details']["s_url"]);
		}
		$user_meta = $this->session->userdata('current_user_session');
		if(empty($user_meta))
		{
			redirect(base_url().'user/login');
		}
		
       	if(is_numeric($deal_id))
		{
			
			$uid = $user_meta[0]['s_uid'];
			$data['details']["s_url"] = str_replace('MYDEALFOUNDXXX',$uid,$data['details']["s_url"]);
			//pr($data['details'],1);
			if(!empty($details))
			{
				// increase view count here
				//$i_true = $this->manage_deals_model->increase_deal_view_count($deal_id);
			}
			else
				redirect(base_url().'food-dining/'); 
		}
		else
			redirect(base_url().'food-dining/');
		
	   	$this->render($data);
    }

	// end functions
}

?>