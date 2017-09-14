<?php

/*********
* Author: Arka 
* Date  : 
* Modified By: 
* Modified Date:
* Purpose:
* Controller For manage coupons
* @package Coupons & Deals
* @subpackage site_setting
* @link InfController.php 
* @link My_Controller.php
* @link model/manage_coupons_model.php
* @link views/admin/manage_coupons/
*/

class Manage_food_dining extends My_Controller implements InfController
{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public $uploaddir;
	public $allowedExt;	
	//public $user_type = 2;	

    public function __construct()
    {
        try
        {
          parent::__construct();
          ////////Define Errors Here//////
          $this->data['title']="Manage Travel";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]				= "No information found about travel.";
          $this->cls_msg["save_err"]				= "Travel information failed to save.";
          $this->cls_msg["save_succ"]				= "Saved successfully.";
          $this->cls_msg["delete_err"]				= "Travel setting failed to remove.";
          $this->cls_msg["delete_succ"]				= "Travel removed successfully.";
		  $this->cls_msg["img_upload_err"]			= "Image cannot be uploded.";
		  $this->cls_msg["database_err"]			= "Failed to insert in the database.Try Again";
          ////////end Define Errors Here//////
		  $this->pathtoclass 						= admin_base_url().$this->router->fetch_class()."/";
	  
			$this->allowedExt									= 'jpg|jpeg|png|gif';
            $this->uploaddir 									= FCPATH.'/uploaded/deal/';	
			
			$this->thumbdir  									= $this->config->item('STORE_LOGO_THUMB_IMAGE_UPLOAD_PATH');
			$this->thumb_ht										= 50;
			$this->thumb_wd										= 50;	

		 	//$this->data['action_allowed']["Status"]	= TRUE;///////////////////////////////////////////exp
          	
			
			//$this->load->model("travel_model");
			//$this->load->model("travel_category_model");
			$this->load->model("common_model","mod_common");
			
			$this->load->model("food_dining_model");
			
			//$this->data['category']	= $this->travel_model->get_category();	
			$this->data['offer']	= $this->food_dining_model->get_offer();
			$this->data['store']	= $this->food_dining_model->get_store();
            $this->data['location']	= $this->get_all_location();
			$this->data['i_coupon_type']	= 2;			
		  //////// end loading default model here //////////////		 

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
            $this->data['title']		=	"Manage Travel";////Browser Title
            $this->data['heading']		=	"Manage Travel";		
			redirect($this->pathtoclass.'show_list');
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    

    }
	
	public function get_all_location() {
        $query = $this->db->get('cd_location');
        return $query->result_array();
    }

	

	/***
    * Method to Display and Save New information
    * This have to sections: 
    *  >>Displaying Blank Form for new entry.
    *  >>Saving the new information into DB
    * After Posting the form, the posted values must be
    * shown in the form if any error occurs to avoid re-entry of the form.
    * On Success redirect to the showList interface else display error here.
    */

    public function add_information()   
    {
		try
        {
          	$this->data['title']				= "Food & Dining Management";////Browser Title
            $this->data['heading']				= "Add Food & Dining ";
            $this->data['pathtoclass']			= $this->pathtoclass;
            $this->data['mode']					= "add";			

			if($_POST)
        	{
				$posted["chk_brand"]			= 	$this->input->post("chk_brand");
				//pr($_POST);exit;
				/*
				$this->form_validation->set_rules('dt_exp_date','Expiry date','required');
				$this->form_validation->set_rules('dt_of_live_coupons','Coupon live date','required');
				$this->form_validation->set_rules('i_type','Type of product','required');
				$this->form_validation->set_rules('i_cat_id','Category','required');
				$this->form_validation->set_rules('i_is_active','Status','required');
				//$this->form_validation->set_rules('i_brand_id','Brand','required');
				$this->form_validation->set_rules('s_title','Title','required');
				$this->form_validation->set_rules('s_summary','Summary','required');
				$this->form_validation->set_rules('s_url','URL','required');
				//$this->form_validation->set_rules('s_discount_txt','Offer text','required');
				*/
				$this->form_validation->set_rules('s_title','Title','required');
				
				if($this->form_validation->run() == FALSE)	
				{	
					$this->data['posted'] = $_POST;
				}			  

        		else
			    {		
					
					if(isset($_FILES['s_image_url']) && !empty($_FILES['s_image_url']['name']))
                    {
                        $s_uploaded_filename = get_file_uploaded( $this->uploaddir,'s_image_url','','',$this->allowedExt);   
                        $arr_upload_img = explode('|',$s_uploaded_filename);
                    }
					
					$time_now = date('H:i:s');
					$dt_exp_date = $this->input->post("dt_exp_date").' '.$time_now;	
					$dt_of_live_coupons = $this->input->post("dt_of_live_coupons").' '.$time_now;
	
					$coupon_url	= getSeoUrl_for_coupon($this->db->FOOD,$this->input->post("s_title"));
	
					$info	= array(										
	
									"i_type"						=> $this->input->post("i_type"),	
									"i_cat_id"						=> decrypt($this->input->post("i_cat_id")),	
									"i_is_active"					=> $this->input->post("i_is_active"),	
									"i_brand_id"					=> $this->input->post("i_brand_id"),	
									"i_store_id"					=> $this->input->post("i_store_id"),	
									"s_title"						=> $this->input->post("s_title"),	
									"s_summary"						=> $this->input->post("s_summary"),	
									"i_coupon_type"					=> $this->input->post("i_coupon_type"),	
									"i_coupon_code"					=> strtoupper($this->input->post("i_coupon_code")),	
									"s_url"							=> $this->input->post("s_url"),	
									"dt_date_of_entry"				=> now(),	
									"dt_exp_date"					=> $dt_exp_date,	
									"dt_of_live_coupons"			=> $dt_of_live_coupons,	
                        			"i_location_id"					=> intval($this->input->post("i_location_id")),
									"s_meta_title"					=> $this->input->post("s_meta_title"),	
									"s_meta_description"			=> $this->input->post("s_meta_description"),	
									"s_meta_keyword"				=> $this->input->post("s_meta_keyword"),	
									"s_seo_url"						=> $coupon_url,									
                        			"s_image_url"               	=> ($arr_upload_img[2])?$arr_upload_img[2]:'',
									"s_discount_txt"				=> $this->input->post("s_discount_txt"),
									"d_discount"					=> $this->input->post("d_discount"),
									"d_list_price"					=> $this->input->post("d_list_price"),
									"d_selling_price"				=> $this->input->post("d_selling_price"),
									"d_shipping"					=> $this->input->post("d_shipping"),
									"s_terms"						=> $this->input->post("s_terms"),
									"i_cashback"					=> $this->input->post("i_cashback")
	
									);
	
						
						$inserted_user_id	= $this->food_dining_model->add_info($info);							
						
						if($inserted_user_id)////saved successfully	
						{	
							/* insert coupon brand in coupon brand table */	
							/*if(!empty($posted["chk_brand"]))	
							{	
								$cat_arr = array();	
								foreach($posted["chk_brand"] as $val)	
								{
									$cat_arr["i_brand_id"] = $val;	
									$cat_arr["i_coupon_id"] = $inserted_user_id;
	
									$s_table = $this->db->DEALSBRAND;	
									$i_insert = $this->mod_common->common_add_info($s_table,$cat_arr);
	
								}	
							}*/	
							/* insert coupon brand in coupon brand table */
	
							set_success_msg($this->cls_msg["save_succ"]);	
							redirect($this->pathtoclass."show_list");	
						}	
						else	
						{
							$this->data["posted"] = $_POST;
						}
	
					}

            }

            ////////////end Submitted Form///////////
            $this->render("manage_food_dining/add-edit");
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          

    }



    /***
    * Method to Display and Save Updated information
    * This have to sections: 
    *  >>Displaying Values in Form for modifying entry.
    *  >>Saving the new information into DB    
    * After Posting the form, the posted values must be
    * shown in the form if any error occurs to avoid re-entry of the form.
    * On Success redirect to the showList interface else display error here. 
    * @param int $i_id, id of the record to be modified.
    */      

    public function modify_information($i_id=0)
    { 
        try
        { 
            $this->data['title']		= "Edit Deals";////Browser Title
            $this->data['heading']		= "Edit Deals";
            $this->data['pathtoclass']	= $this->pathtoclass;
            $this->data['mode']			= "edit";

            ////////////Submitted Form///////////
            if($_POST)
            {	

				/*$dt_exp_date = $this->input->post("dt_exp_date").' '.$this->input->post("exp_date_hr").':'.$this->input->post("exp_date_min").':'.$this->input->post("exp_date_sec");
				$dt_of_live_coupons = $this->input->post("dt_of_live_coupons").' '.$this->input->post("live_date_hr").':'.$this->input->post("live_date_min").':'.$this->input->post("live_date_sec");*/
				
				$time_now = date('H:i:s');
				$dt_exp_date = $this->input->post("dt_exp_date").' '.$time_now;	
				$dt_of_live_coupons = $this->input->post("dt_of_live_coupons").' '.$time_now;


				$posted=array();
				$posted["chk_brand"]			= 	$this->input->post("chk_brand");
                $posted["h_mode"]				= $this->data['mode'];
				$posted["i_type"]				= trim($this->input->post("i_type"));
				$posted["i_brand_id"]			= $this->input->post("i_brand_id");	
				$posted["i_is_active"]			= trim($this->input->post("i_is_active"));
				$posted["i_store_id"]			= trim($this->input->post("i_store_id"));
				$posted["i_cat_id"]				= $this->input->post("i_cat_id");
				$posted["s_title"]				= trim($this->input->post("s_title"));
				$posted["dt_exp_date"]			= $dt_exp_date;	
				$posted["dt_of_live_coupons"]	= $dt_of_live_coupons;
				$posted["s_summary"]			= trim($this->input->post("s_summary"));
				$posted["s_url"]				= trim($this->input->post("s_url"));
				$posted["i_coupon_type"	]		= $this->input->post("i_coupon_type");
				$posted["i_coupon_code"]		= trim($this->input->post("i_coupon_code"));
				$posted["dt_date_of_entry"]		= now();
				$posted["s_meta_title"]			= trim($this->input->post("s_meta_title"));
				$posted["s_meta_description"]	= trim($this->input->post("s_meta_description"));
				$posted["s_meta_keyword"]		= trim($this->input->post("s_meta_keyword"));
				$posted["coupon_type_exp"]		= trim($this->input->post("coupon_type_exp"));
				$posted["h_id"]					= trim($this->input->post("h_id"));
				//$posted["h_s_brand_logo"] 		= trim($this->input->post("h_s_brand_logo"));
				$posted["s_discount_txt"]		= trim($this->input->post("s_discount_txt"));
				$posted["d_discount"]			= trim($this->input->post("d_discount"));
				
				$posted["d_list_price"]			= trim($this->input->post("d_list_price"));
				$posted["d_selling_price"]		= trim($this->input->post("d_selling_price"));
				$posted["d_shipping"]			= trim($this->input->post("d_shipping"));
				$posted["s_terms"]				= trim($this->input->post("s_terms"));
				$posted["i_cashback"]			= trim($this->input->post("i_cashback"));

				//print_r($posted);
				
				if(isset($_FILES['s_image_url']) && !empty($_FILES['s_image_url']['name']))
				{
					$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'s_image_url','','',$this->allowedExt);    
					$arr_upload_img = explode('|',$s_uploaded_filename);
				}
				if(($arr_upload_img[0]==='err'))/////invalid
				{
					  $this->session->set_userdata(array('message'=>$this->cls_msg["img_upload_err"],'message_type'=>'err'));
				}

				/*$this->form_validation->set_rules('i_type',' Type of product','required');
				//$this->form_validation->set_rules('i_brand_id',' brand','required');
				$this->form_validation->set_rules('i_is_active',' Status','required');
				$this->form_validation->set_rules('i_cat_id',' Category','required');
				$this->form_validation->set_rules('s_title',' Title','required');
				$this->form_validation->set_rules('s_summary',' Summary','required');
				$this->form_validation->set_rules('s_url',' URL','required');
				$this->form_validation->set_rules('dt_exp_date','Expiry date','required');
				$this->form_validation->set_rules('dt_of_live_coupons','Coupon live date','required');
				//$this->form_validation->set_rules('s_discount_txt','Offer text','required');*/
				$this->form_validation->set_rules('s_title','Title','required');

                if($this->form_validation->run() == FALSE)////invalid
                {
                    //////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;       
                }
                else///validated, now save into DB
                {	

					$coupon_url	= getSeoUrl_for_coupon($this->db->FOOD,$posted["s_title"],$posted["h_id"]);					

					$info	=	array();
					$info["i_type"]					= $posted["i_type"];
					$info["i_brand_id"]				= $posted["i_brand_id"];
					$info["i_is_active"]			= $posted["i_is_active"];
					$info["i_cat_id"]				= decrypt($posted["i_cat_id"]);
					$info["i_store_id"]				= $posted["i_store_id"];
					$info["s_title"]				= $posted["s_title"];
					$info["s_summary"]				= $posted["s_summary"];
					$info["s_url"]					= $posted["s_url"];
					$info["i_coupon_type"]			= $posted["i_coupon_type"];
					$info["i_coupon_code"]			= $posted["i_coupon_code"];
					$info["dt_date_of_entry"]		= $posted["dt_date_of_entry"];
					$info["dt_exp_date"]			= $posted["dt_exp_date"];
					$info["dt_of_live_coupons"]		= $posted["dt_of_live_coupons"];
					$info["s_meta_title"]			= $posted["s_meta_title"];
					$info["s_meta_description"]		= $posted["s_meta_description"];
					$info["s_meta_keyword"]			= $posted["s_meta_keyword"];
					$info["s_seo_url"]				= $coupon_url;					
					$info["s_image_url"]            = ($arr_upload_img[2])?$arr_upload_img[2]:$this->input->post("s_image_url");
					//i_store_id				
                	$info["i_location_id"]			= intval($this->input->post("i_location_id"));	
					
					$info["s_discount_txt"]			= $posted["s_discount_txt"];
					$info["d_discount"]				= $posted["d_discount"];
					$info["d_list_price"]			= $posted["d_list_price"];
					$info["d_selling_price"]		= $posted["d_selling_price"];
					$info["d_shipping"]				= $posted["d_shipping"];
					$info["s_terms"]				= $posted["s_terms"];
					$info["i_cashback"]				= $posted["i_cashback"];

					if(count($arr_upload_res)>0)
					{
						//$info["s_store_logo"]					=	$arr_upload_res[2];
						unlink(BASEPATH."../uploaded/store/".$posted["h_s_brand_logo"]);
						unlink(BASEPATH."../uploaded/store/thumb/thumb_".$posted["h_s_brand_logo"]);
					}
					else
					{
						//$info["s_store_logo"]					=	$posted["h_s_brand_logo"];
					}	                  

					//echo decrypt($posted["h_id"]);exit;
                   
                    $i_aff=$this->food_dining_model->edit_info($info, decrypt($posted["h_id"]));
                    if($i_aff)////saved successfully
                    {
						set_success_msg($this->cls_msg["save_succ"]);
						redirect($this->pathtoclass."show_list");
                    }
                    else///Not saved, show the form again
                    {
                        $this->data["posted"]=$posted;
                        //set_error_msg($this->cls_msg["save_err"]);
						redirect($this->pathtoclass."show_list");
                    }
                    unset($info,$posted, $i_aff);                    

                }

            }
            else
            { 

                $info=$this->food_dining_model->fetch_this(decrypt($i_id));		
					//pr($info,1);	

                $posted=array();
				$posted["i_type"]					= trim($info[0]["i_type"]);
				$posted["i_brand_id"]				= trim($info[0]["i_brand_id"]);
				$posted["i_is_active"]				= trim($info[0]["i_is_active"]);
				$posted["i_cat_id"]					= trim($info[0]["i_cat_id"]);
				$posted["i_store_id"]				= trim($info[0]["i_store_id"]);
				$posted["s_title"]					= trim($info[0]["s_title"]);
				$posted["s_summary"]				= trim($info[0]["s_summary"]);
				$posted["s_url"]					= trim($info[0]["s_url"]);
				$posted["i_coupon_type"]			= $info[0]["i_coupon_type"];
				$posted["i_coupon_code"]			= trim($info[0]["i_coupon_code"]);
				$posted["dt_exp_date"]				= $info[0]["dt_exp_date"]!="0000-00-00 00:00:00"?date('Y-m-d',strtotime(trim($info[0]["dt_exp_date"]))):"";
				$posted["dt_of_live_coupons"]		= $info[0]["dt_of_live_coupons"]!="0000-00-00 00:00:00"?date('Y-m-d',strtotime(trim($info[0]["dt_of_live_coupons"]))):"";
				$posted["s_meta_title"]				= trim($info[0]["s_meta_title"]);
				$posted["s_meta_description"]		= trim($info[0]["s_meta_description"]);
				$posted["s_meta_keyword"]			= trim($info[0]["s_meta_keyword"]);
				$posted["h_id"]						= $i_id;	
				$posted["i_location_id"]            = $info[0]["i_location_id"];	
				$posted["s_image_url"]             	= $info[0]["s_image_url"];	
				
				$posted["s_discount_txt"]			= $info[0]["s_discount_txt"];
				$posted["d_discount"]				= $info[0]["d_discount"];	
				$posted["i_cashback"]				= $info[0]["i_cashback"];
				
				$posted["d_list_price"]				= $info[0]["d_list_price"];
				$posted["d_selling_price"]			= $info[0]["d_selling_price"];
				$posted["d_shipping"]				= $info[0]["d_shipping"];
				$posted["s_terms"]					= $info[0]["s_terms"];

				 $s_table_name = $this->db->DEALSBRAND;
				 $arr_where = array('i_coupon_id'=>decrypt($i_id));
				 $info_cat	=	$this->mod_common->common_fetch($s_table_name,$arr_where,'',10000); 				 

				 $arr_cat = array();
				 if($info_cat)
				 {
					foreach($info_cat as $val)
					{
						$arr_cat[] = $val["i_brand_id"];
					}
				 }
				 $posted["chk_brand"]				=	$arr_cat;

                $this->data["posted"]=$posted;  
                unset($info,$posted);   
            }
            ////////////end Submitted Form///////////
            $this->render("manage_food_dining/add-edit");

        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }     

    }


    /***
    * Method to Delete information
    * This have no interface but db operation 
    * will be done here.
    * On Success redirect to the showList interface else display error in showList interface. 
    * @param int $i_id, id of the record to be modified.
    */      
    public function remove_information($i_id=0)
    {
        try
        { 

            $i_ret_=0;
            $pageno=$this->input->post("h_pageno");///the pagination page no, to return at the same page
            /////Deleting What?//////
            $s_del_these=$this->input->post("h_list");
            switch($s_del_these)
			{
				case "all":
							$i_ret_=$this->food_dining_model->delete_info(-1);
							break;
				default: 		///Deleting selected,page ///
							//////First consider the posted ids, if found then take $i_id value////
							$id=(!$i_id?$this->input->post("chk_del"):$i_id);///may be an array of IDs or single id
							if(is_array($id) && !empty($id))///Deleting Multi Records
							{
								///////////Deleting Information///////
								$tot=count($id)-1;
								while($tot>=0)
								{
									$i_ret_=$this->food_dining_model->delete_info(decrypt($id[$tot]));
									//$del_cpn_brnd=$this->travel_model->del_cpn_brand(decrypt($id[$tot]));
									$tot--;
								}
							}
							elseif($id>0)///Deleting single Records
							{
								$i_ret_=$this->food_dining_model->delete_info(decrypt($id));
								//$del_cpn_brnd=$this->travel_model->del_cpn_brand(decrypt($id[$tot]));
							} 
							break;

			}
            unset($s_del_these, $id, $tot);
            if($i_ret_)
            {
                set_success_msg($this->cls_msg["delete_succ"]);
            }
            else
            {
                set_error_msg($this->cls_msg["delete_err"]);
            }			
			redirect($this->pathtoclass."show_list".($pageno?"/".$pageno:""));
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          

    } 

    

    /***
    * Shows details of a single record.
    * @param int $i_id, Primary key
    */
    public function show_detail($i_id=0)
    {
        try
        {
            if(trim($i_id)!="")
            {
                $info=$this->travel_model->fetch_this(decrypt($i_id));
				//pr($info);
                if(!empty($info))
                {
                    $temp=array();
                    $temp["i_id"]= encrypt($info[0]["i_id"]);////Index 0 must be the encrypted PK 
					$temp["s_title"]	= trim($info[0]["s_title"]);
					$temp["s_store_logo"]	= trim($info[0]["s_store_logo"]);
					$temp["s_status"]		= trim($info[0]["i_is_active"])==1?'Active':'Deactive';
					$temp["s_summary"]		=trim($info[0]["s_summary"]);
					//pr($temp);
					$this->data["info"]=$temp;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.7.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            $this->render("manage_travel/show_detail",TRUE);
            unset($i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }        

    }	
	

	public function show_list($order_name='',$order_by='desc',$start=NULL,$limit=NULL)
	{
		try
        {           

			$this->data['heading']="Manage Food & Dining";////Package Name[@package] Panel Heading
			
            ///////////generating search query///////

            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_coupon=($this->input->post("h_search")?$this->input->post("s_coupon"):$this->session->userdata("s_coupon")); 
			$s_is_active=($this->input->post("h_search")?$this->input->post("s_is_active"):$this->session->userdata("s_is_active")); 
			$s_category=($this->input->post("h_search")?$this->input->post("s_category"):$this->session->userdata("s_category"));

			$s_store=($this->input->post("h_search")?$this->input->post("s_store"):$this->session->userdata("s_store"));
			$txt_expiry_dt=($this->input->post("h_search")?$this->input->post("txt_expiry_dt"):$this->session->userdata("txt_expiry_dt"));
            //$srch_dt=($this->input->post("h_search")?$this->input->post("srch_dt"):$this->session->userdata("srch_dt"));

            ////////end Getting Posted or session values for search///			

             //$s_where=" WHERE dt_exp_date>=now() ";/////////////////////////1====
			 //$s_where=" WHERE CONCAT(DATE(dt_exp_date),' 23:59:59')>=now() AND i_coupon_type=2 ";
			 $s_where=" WHERE i_coupon_type=2 ";

            if($s_search=="basic")
            {

                $s_where.=" AND (s_title LIKE '%".my_receive_like($s_coupon)."%' )";		
				if(trim($s_is_active)!="")
                {
                    $s_where.=" And i_is_active=".$s_is_active." ";
                }				
				if(trim($s_store)!="")
				{	
					$s_where.=" AND i_store_id= '".$s_store."'";
				}

				if(trim($txt_expiry_dt)!="")
                {
                    $s_where.=" And DATE(dt_exp_date)>= '".$txt_expiry_dt."' ";                    

                }
				

                /////Storing search values into session///

                $this->session->set_userdata("s_coupon",$s_coupon);
				$this->session->set_userdata("s_is_active",$s_is_active);
				$this->session->set_userdata("s_category",$s_category);
				$this->session->set_userdata("s_store",$s_store);
				$this->session->set_userdata("txt_expiry_dt",$txt_expiry_dt);
                $this->session->set_userdata("h_search",$s_search);                

                $this->data["h_search"]=$s_search;
                $this->data["s_coupon"]=$s_coupon;
				$this->data["s_category"]=$s_category;
				$this->data["s_store"]=$s_store;
				$this->data["txt_expiry_dt"]=$txt_expiry_dt;
				$this->data["s_is_active"]=$s_is_active;
				//$this->data["srch_dt"]=$srch_dt;
				//echo $s_where;*/
                /////end Storing search values into session///
            }        
            else////List all records, **not done
            {
               //$s_where=" WHERE n.id!=1 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("s_coupon");
                $this->session->unset_userdata("s_is_active");
				$this->session->unset_userdata("s_category");
				$this->session->unset_userdata("txt_expiry_dt");
				$this->session->unset_userdata("s_store");
                $this->session->unset_userdata("h_search");
				
                $this->data["h_search"]=$s_search;
                $this->data["s_coupon"]=""; 
				$this->data["s_category"]="";
				$this->data["s_store"]="";
				$this->data["txt_expiry_dt"]="";  
                $this->data["s_is_active"]="";   
                /////end Storing search values into session///
            }
            unset($s_search,$s_user_type,$dt_created_on);
            ///Setting Limits, If searched then start from 0////
            $i_uri_seg =6;

            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
                $start=$this->uri->segment($i_uri_seg);
            }

            ///////////end generating search query///////
			
			$arr_sort = array(0=>'i_id',1=>'s_title');
			$s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];

            $limit	= $this->i_admin_page_limit;
			$info	= $this->food_dining_model->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			//print_r ($info);

            /////////Creating List view for displaying/////////

			$table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 

            //////Table Headers, with width,alignment///////

            $table_view["caption"]     		=	"Travel";
            $table_view["total_rows"]		=	count($info);

			$table_view["total_db_records"]	=	$this->food_dining_model->gettotal_info($s_where);
			$table_view["order_name"]		=	$order_name;
			$table_view["order_by"]  		=	$order_by;
            $table_view["src_action"]		= 	$this->pathtoclass.$this->router->fetch_method(); 
           // $table_view["detail_view"]		=   FALSE;         

            $table_view["headers"][0]["width"]	="20%";
            $table_view["headers"][0]["align"]	="left";
            //$table_view["headers"][0]["val"]	="Serial Number";
			//$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][0]["val"]	="Travel";
			$table_view["headers"][1]["val"]	="URL";
			$table_view["headers"][2]["val"]	="Store";
			//$table_view["headers"][3]["val"]	="Category";
			$table_view["headers"][3]["align"]	="center";
			$table_view["headers"][3]["val"]	="Status";
			//$table_view["headers"][5]["val"]	="Comments";	
			$table_view["headers"][4]["val"]	="Food code";
			$table_view["headers"][4]["align"]	="center";
			$table_view["headers"][5]["val"]	="Expiry date";
			$table_view["headers"][5]["align"]	="center"; 
					
            //////end Table Headers, with width,alignment///////			

            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {	
				$store=$this->food_dining_model->fetch_this_store($info[$i]["i_store_id"]);
				$store_name=$store[0]['s_store_title'];			

				/*$cat=$this->travel_category_model->fetch_this($info[$i]["i_cat_id"]);
				$cat_name=$cat[0]['s_category'];		
*/
                $img = $info[$i]["s_store_logo"] != ''? '<img src="'.base_url().'uploaded/store/thumb/thumb_'.$info[$i]['s_store_logo'].'" />' : 'No Image';
				$info[$i]["s_is_active"] = ($info[$i]["i_status"]==1)?'Active':'Inactive';				

				

				$i_col=0;

                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);////Index 0 must be the encrypted PK 
                //$table_view["tablerows"][$i][$i_col++]	= $info[$i]["i_id"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_title"];
				//$table_view["tablerows"][$i][$i_col++]	= exclusive_strip_tags_more_view($brand_name,40);

				$table_view["tablerows"][$i][$i_col++]	= '<a href="'.make_valid_url($info[$i]["s_url"]).'" target="_blank">'.string_part($info[$i]["s_url"],30).'</a>';
				$table_view["tablerows"][$i][$i_col++]	= $store_name;
				//$table_view["tablerows"][$i][$i_col++]	= $cat_name;				

				if($this->data['action_allowed']["Status"])
				{
				 	if($info[$i]["i_is_active"] == 1)
					{
                        $action ='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_inactive">
                        <img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/tick.png"></a>';
					}
					else
					{ 
                        $action ='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_active">
                        <img width="12" height="12" title="Active" alt="Active" src="images/admin/reject.png"></a>';
					}
				
				 	$table_view["tablerows"][$i][$i_col++]	= $action;				 
				}
				

				$code_of_coupon=($info[$i]["i_coupon_code"])?$info[$i]["i_coupon_code"]:"N/A";
				$table_view["tablerows"][$i][$i_col++]	=  $code_of_coupon;
				$table_view["tablerows"][$i][$i_col++]	=  $info[$i]["dt_exp_date"]!="0000-00-00 00:00:00"?date('d-m-Y',strtotime($info[$i]["dt_exp_date"])):"N/A";

            } 

            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit,$action); 
            //$this->data["table_view"]=$this->admin_showin_table($table_view);
			$this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action           

            $this->render();         
            unset($table_view,$info);

        }
        catch(Exception $err_obj)
        {
        	show_error($err_obj->getMessage());
        }  

	}


	 /***
    * Checks duplicate value using ajax call
    */

    public function ajax_checkduplicate()
    {}

	///////////////user change status/////////

	public function ajax_change_status()
    {
        try
        {
                $posted["id"]           = decrypt(trim($this->input->post("h_id")));
                $posted["i_status"]     = trim($this->input->post("i_status"));
                $info = array();
                $info['i_is_active']    = $posted["i_status"]  ;
                $i_rect=$this->food_dining_model->change_status($info,$posted["id"]); /*don't change*/	
                if($i_rect)////saved successfully
				{
					echo "ok";		
				}
				else///Not saved, show the form again
				{
					echo "error" ;
				}
                unset($info,$i_rect);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }        

    }  

	
	public function __destruct()

    {}

}