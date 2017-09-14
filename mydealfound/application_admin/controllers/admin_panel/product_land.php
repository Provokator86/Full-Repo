<?php
/*********
* Author: Arka
* Date  : 
* Modified By: 
* Modified Date: 
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class Product_land extends My_Controller
{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public function __construct()
    {
        try
        { 
          parent::__construct(); 
          $this->data['title'] 				= "Home";////Browser Title
		  $this->data['ctrlr'] 				= "home";		
          $this->cls_msg=array();
		  $this->cls_msg["no_result"]		= "No information found."; 
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  $this->load->model("store_model");
		  $this->load->model("coupon_model");
		  $this->load->model("brand_model");
		  $this->load->model("report_model");
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
    public function index($store_url='',$coupon_id='')
    {	
		
		
		
		
		/*********************** TOP COUPON STORE STARTS ***********************************/
				$this->data['store']   			= $this->store_model->fetch_this_with_url($store_url);
				if(empty($this->data['store']))
				{
					redirect(base_url());
				}
				$id									= $this->data['store'][0]['i_id'];
				$this->data['store_image_path']		= base_url()."uploaded/store/main_thumb/thumb_";
				$this->data['fb_store_image_path']	= base_url()."uploaded/store/fbthumb/thumb_";
				//pr($this->data['store'],1);
			/*********************** TOP COUPON STORE ENDS **************************************/
			
			$count	= $this->coupon_model->count_no_of_coupon_under_this_store($id);
			$this->data['total_coupons']	= $count[0]['total_coupons'];
			//pr($count,1);
			
			/*******************COUPON LISTING UNDER THIS STORE STARTS***************************/
			
			$where	= " WHERE (cdc.i_store_id	= $id AND cdc.i_is_active	= 1 AND cdc.dt_of_live_coupons <= now() 
						AND cdc.dt_exp_date >= now()) ORDER BY rand()";
			$this->data['top_coupons_list']   			= $this->coupon_model->fetch_multi_top_latest_coupons($where);
			$this->data['top_coupons_store_image_path']	= base_url()."uploaded/store/thumb/thumb_";
			//pr($this->data['top_coupons_list'],1);
			/*******************COUPON LISTING UNDER THIS STORE ENDS***************************/
			
			//----------------------Current coupon-----------------------------------//
			$coupon_id_from_url  	= $this->coupon_model->fetch_this_with_url($coupon_id);
			$current_coupon=$this->coupon_model->fetch_this($coupon_id_from_url[0]['i_id']);
			$this->data['current_coupon']=$current_coupon;
			//pr($current_coupon);
			
			//-----------------------------------------------------------------------------
			
			$this->data['fb_title']			= $current_coupon[0]['s_title'];
			$this->data['fb_description']	= exclusive_strip_tags($current_coupon[0]['s_summary']);
			$this->data['url']				= base_url().'product_land/index/'.$store_url.'/'.$coupon_id;
			$this->data['logo']				= $this->data['fb_store_image_path'].$this->data['top_coupons_list'][0]['s_store_logo'];
			$this->render("product_land/product_land");			
		    //$this->load->view("fe/product_land/product_land.tpl.php",$this->data);
		
		}
	
	
	
	
	
	
	
	
}

/* End of file welcome.php */
/* Location: /application/controllers/home.php */

