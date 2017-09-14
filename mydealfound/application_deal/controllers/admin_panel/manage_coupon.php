<?php
/*********
* Author: Arka 
* Date  : 
* Modified By: 
* Modified Date:
* 
* Purpose:
* Controller For manage coupons
* 
* @package Content Management
* @subpackage site_setting
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/manage_coupons_model.php
* @link views/admin/manage_coupons/
*/

class Manage_coupon extends My_Controller implements InfController
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
          $this->data['title']="Manage ";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]				= "No information found about admin site setting.";
          $this->cls_msg["save_err"]				= "Admin site setting failed to save.";
          $this->cls_msg["save_succ"]				= "Saved successfully.";
          $this->cls_msg["delete_err"]				= "Coupon setting failed to remove.";
          $this->cls_msg["delete_succ"]				= "Coupon removed successfully.";
		  $this->cls_msg["img_upload_err"]			= "Image cannot be uploded.";
		  $this->cls_msg["database_err"]			= "Failed to insert in the database.Try Again";
          ////////end Define Errors Here//////
		  $this->pathtoclass 						= admin_base_url().$this->router->fetch_class()."/";
		  //$this->session->unset_userdata("s_category");
		  //$this->session->unset_userdata("s_is_active");
		  //$this->session->unset_userdata("s_coupon");
		 //$this->session->unset_userdata("s_store");
		  
			$this->allowedExt									= 'jpg|jpeg|png|gif';
			$this->uploaddir 									= $this->config->item('STORE_LOGO_IMAGE_UPLOAD_PATH');	
			$this->thumbdir  									= $this->config->item('STORE_LOGO_THUMB_IMAGE_UPLOAD_PATH');
			$this->thumb_ht										= 50;
			$this->thumb_wd										= 50;
			
		  
		  			  
		 	$this->data['action_allowed']["Status"]	= TRUE;///////////////////////////////////////////exp
          	$this->load->model("coupon_model");
			$this->load->model("store_model");
			$this->load->model("brand_model");
			$this->load->model("category_model");
			$this->load->model("common_model","mod_common");
			$this->data['category']= $this->store_model->get_category();
			
			$this->data['brand']	= $this->store_model->get_brand();
			$this->data['offer']	= $this->store_model->get_offer();
			$this->data['store']	= $this->store_model->get_store();
			$this->data['i_coupon_type']	= 2;
			//$this->load->model("startup_model");
			$make_exp_cpn_notop=$this->coupon_model->remove_top_status();
		  
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
			
            $this->data['title']		=	"Manage Coupon";////Browser Title
            $this->data['heading']		=	"Manage Coupon";
			
			redirect($this->pathtoclass.'show_list');
            
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/***
    * Method to Display and Save New information
    * This have to sections: 
    *  >>Displaying Blank Form for new entry.
    *  >>Saving the new information into DB
    * After Posting the form, the posted values must be
    * shown in the form if any error occurs to avoid re-entry of the form.
    * 
    * On Success redirect to the showList interface else display error here.
    */
    public function add_information()           
    {
		try
        {
          	$this->data['title']				= "Coupon Management";////Browser Title
            $this->data['heading']				= "Add Coupon ";
            $this->data['pathtoclass']			= $this->pathtoclass;
            $this->data['mode']					= "add";
			
			if($_POST)
        {
				
				$posted["chk_brand"]			= 	$this->input->post("chk_brand");
				//print_r($_POST);exit;
				
				$this->form_validation->set_rules('dt_exp_date','Expiry date','required');
				$this->form_validation->set_rules('dt_of_live_coupons','Coupon live date','required');
				$this->form_validation->set_rules('i_type','Type of product','required');
				$this->form_validation->set_rules('i_cat_id','Category','required');
				$this->form_validation->set_rules('i_is_active','Status','required');
				//$this->form_validation->set_rules('i_brand_id','Brand','required');
				$this->form_validation->set_rules('s_title','Title','required');
				$this->form_validation->set_rules('s_summary','Summary','required');
				$this->form_validation->set_rules('s_url','URL','required');
				
			 if($this->form_validation->run() == FALSE)	
			 {	
				$this->data['posted'] = $_POST;
			 }
              
			  
        else
           {		
		   				//pr($_FILES,1);
		   		if(isset($_FILES['s_store_logo']) && !empty($_FILES['s_store_logo']['name']))
				{
					$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'s_store_logo','','',$this->allowedExt);    
					$arr_upload_res = explode('|',$s_uploaded_filename);
				}
				if(($arr_upload_res[0]==='err'))/////invalid
					{
						$this->session->set_userdata(array('message'=>$this->cls_msg["img_upload_err"],'message_type'=>'err'));
						redirect(admin_base_url().'/manage_coupon/add_information');	
					}
				else
					{
						if($arr_upload_res[0]==='ok')
							{
								get_image_thumb($this->uploaddir.$arr_upload_res[2], $this->thumbdir, 'thumb_'.$arr_upload_res[2],$this->thumb_ht,$this->thumb_wd);  // get thumb image								
							}
					}
										
		   		$dt_exp_date = $this->input->post("dt_exp_date").' '.$this->input->post("exp_date_hr").':'.$this->input->post("exp_date_min").':'.$this->input->post("exp_date_sec");
									
				$dt_of_live_coupons = $this->input->post("dt_of_live_coupons").' '.$this->input->post("live_date_hr").':'.$this->input->post("live_date_min").':'.$this->input->post("live_date_sec");
				$coupon_url	= getSeoUrl_for_coupon($this->db->COUPON,$this->input->post("s_title"));
 				$info	= array(										
								"i_type"						=> $this->input->post("i_type"),
								"i_cat_id"						=> $this->input->post("i_cat_id"),
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
								"s_meta_title"					=> $this->input->post("s_meta_title"),
								"s_meta_description"			=> $this->input->post("s_meta_description"),
								"s_meta_keyword"				=> $this->input->post("s_meta_keyword"),
								"s_seo_url"								=> $coupon_url
								);
					//pr($info,1);
					$inserted_user_id	= $this->coupon_model->add_info($info);					
					
					
					if($inserted_user_id)////saved successfully
                    {
                        /* insert coupon brand in coupon brand table */
						if(!empty($posted["chk_brand"]))
						{							
							$cat_arr = array();
							foreach($posted["chk_brand"] as $val)
							{
									$cat_arr["i_brand_id"] = $val;
									$cat_arr["i_coupon_id"] = $inserted_user_id;
									
									$s_table = $this->db->COUPONBRAND;
									$i_insert = $this->mod_common->common_add_info($s_table,$cat_arr);
														
							}
						}
						/* insert coupon brand in coupon brand table */
						
						set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list");
                    }
					else
					{
						
					}
					
                }
                
            }
            ////////////end Submitted Form///////////
            $this->render("manage_coupon/add-edit");
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
    * 
    * On Success redirect to the showList interface else display error here. 
    * @param int $i_id, id of the record to be modified.
    */      
    public function modify_information($i_id=0)
    { //echo $i_id;
          
        try
        { //echo "12"."$i_td";
			
            $this->data['title']		= "Edit Coupon";////Browser Title
            $this->data['heading']		= "Edit Coupon";
            $this->data['pathtoclass']	= $this->pathtoclass;
            $this->data['mode']			= "edit";
			
            ////////////Submitted Form///////////
            if($_POST)
            {	
				
				
				$dt_exp_date = $this->input->post("dt_exp_date").' '.$this->input->post("exp_date_hr").':'.$this->input->post("exp_date_min").':'.$this->input->post("exp_date_sec");
									
				$dt_of_live_coupons = $this->input->post("dt_of_live_coupons").' '.$this->input->post("live_date_hr").':'.$this->input->post("live_date_min").':'.$this->input->post("live_date_sec");
						
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
				$posted["i_coupon_code"]		= strtoupper(trim($this->input->post("i_coupon_code")));
				$posted["dt_date_of_entry"]		= now();
				$posted["s_meta_title"]			= trim($this->input->post("s_meta_title"));
				$posted["s_meta_description"]	= trim($this->input->post("s_meta_description"));
				$posted["s_meta_keyword"]		= trim($this->input->post("s_meta_keyword"));
				$posted["coupon_type_exp"]		= trim($this->input->post("coupon_type_exp"));
				$posted["h_id"]					= trim($this->input->post("h_id"));
				//$posted["h_s_brand_logo"] 		= trim($this->input->post("h_s_brand_logo"));
				//print_r($posted);
				$this->form_validation->set_rules('i_type',' Type of product','required');
				//$this->form_validation->set_rules('i_brand_id',' brand','required');
				$this->form_validation->set_rules('i_is_active',' Status','required');
				$this->form_validation->set_rules('i_cat_id',' Category','required');
				$this->form_validation->set_rules('s_title',' Title','required');
				$this->form_validation->set_rules('s_summary',' Summary','required');
				$this->form_validation->set_rules('s_url',' URL','required');
				$this->form_validation->set_rules('dt_exp_date','Expiry date','required');
				$this->form_validation->set_rules('dt_of_live_coupons','Coupon live date','required');
				
                if($this->form_validation->run() == FALSE)////invalid
                {
                    //////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;       
                }
                else///validated, now save into DB
                {	
					//pr($_FILES,1);
				
					if(isset($_FILES['s_store_logo']) && !empty($_FILES['s_store_logo']['name']))
											{
												$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'s_store_logo','','',$this->allowedExt);    
												echo $arr_upload_res = explode('|',$s_uploaded_filename);
											}
										if(($arr_upload_res[0]==='err'))/////invalid
											{
												$this->session->set_userdata(array('message'=>$this->cls_msg["img_upload_err"],'message_type'=>'err'));
												redirect(base_url().'manage_store/modify_information');	
											}
										else
											{
												if($arr_upload_res[0]==='ok')
													{
														get_image_thumb($this->uploaddir.$arr_upload_res[2], $this->thumbdir, 'thumb_'.$arr_upload_res[2],$this->thumb_ht,$this->thumb_wd);  // get thumb image								
													}
											}
				
				
				
					
					
					
					$coupon_url						= getSeoUrl_for_coupon($this->db->COUPON,$posted["s_title"],$posted["h_id"]);
					$info	=	array();
					$info["i_type"]					= $posted["i_type"];
					$info["i_brand_id"]				= $posted["i_brand_id"];
					$info["i_is_active"]			= $posted["i_is_active"];
					$info["i_cat_id"]				= $posted["i_cat_id"];
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
					
					//i_store_id
					
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
                    //pr($info,1);
                    $i_aff=$this->coupon_model->edit_info($info, decrypt($posted["h_id"]));
                    if($i_aff)////saved successfully
                    {
                         /* insert coupon brand in coupon brand table */
						if(!empty($posted["chk_brand"]))
						{							
							$s_table = $this->db->COUPONBRAND;
							$arr_wh = array('i_coupon_id'=>decrypt($posted["h_id"]));
							$i_deleted = $this->mod_common->common_delete_info($s_table,$arr_wh);
							
							$cat_arr = array();
							foreach($posted["chk_brand"] as $val)
							{
									$cat_arr["i_brand_id"] = $val;
									$cat_arr["i_coupon_id"] = decrypt($posted["h_id"]);
									
									$i_insert = $this->mod_common->common_add_info($s_table,$cat_arr);
														
							}
						}/* insert coupon brand in coupon brand table */
						
						
						else   //------if unchecked then remove the brands----
						{	
							$s_table = $this->db->COUPONBRAND;
							$arr_wh = array('i_coupon_id'=>decrypt($posted["h_id"]));
							$i_deleted = $this->mod_common->common_delete_info($s_table,$arr_wh);
						}//------if unchecked then remove the brands----

						
						
						
					
						
						set_success_msg($this->cls_msg["save_succ"]);
						if($posted["coupon_type_exp"]=='expired')
						{
							 redirect($this->pathtoclass."show_list_expired_coupon");
						}
						else
						{
                        	redirect($this->pathtoclass."show_list");
						}
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
                $info=$this->coupon_model->fetch_this(decrypt($i_id));		
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
				$posted["dt_exp_date"]				= date('Y-m-d',strtotime(trim($info[0]["dt_exp_date"])));
				$posted["dt_of_live_coupons"]		= date('Y-m-d',strtotime(trim($info[0]["dt_of_live_coupons"])));
				$posted["s_meta_title"]			= trim($info[0]["s_meta_title"]);
				$posted["s_meta_description"]	= trim($info[0]["s_meta_description"]);
				$posted["s_meta_keyword"]		= trim($info[0]["s_meta_keyword"]);
				$posted["h_id"]						= $i_id;
				
				 $s_table_name = $this->db->COUPONBRAND;
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
            $this->render("manage_coupon/add-edit");
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
    * 
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
							$i_ret_=$this->coupon_model->delete_info(-1);
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
							$i_ret_=$this->coupon_model->delete_info(decrypt($id[$tot]));
							$del_cpn_brnd=$this->coupon_model->del_cpn_brand(decrypt($id[$tot]));
							$tot--;
							}
							}
							elseif($id>0)///Deleting single Records
							{
							$i_ret_=$this->coupon_model->delete_info(decrypt($id));
							$del_cpn_brnd=$this->coupon_model->del_cpn_brand(decrypt($id[$tot]));
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
			$whether_expired	= $this->session->userdata('coupon_controller');
			if($whether_expired=='expired')
			{
            	redirect($this->pathtoclass."show_list_expired_coupon".($pageno?"/".$pageno:""));
			}
			else
			{
				redirect($this->pathtoclass."show_list".($pageno?"/".$pageno:""));
			}
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    } 
    
    /***
    * Shows details of a single record.
    * 
    * @param int $i_id, Primary key
    */
    public function show_detail($i_id=0)
    {
        try
        {
            if(trim($i_id)!="")
            {
                $info=$this->coupon_model->fetch_this(decrypt($i_id));
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
          
            $this->render("manage_coupon/show_detail",TRUE);
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
           
			$this->data['heading']="Manage Coupon";////Package Name[@package] Panel Heading
			$this->session->unset_userdata('coupon_controller');// to redirect to show list after delete
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
			 $s_where=" WHERE CONCAT(DATE(dt_exp_date),' 23:59:59')>=now() AND i_coupon_type=2 ";
		
            if($s_search=="basic")
            {
                $s_where.=" AND (s_title LIKE '%".my_receive_like($s_coupon)."%' )";
				
				
				 if(trim($s_is_active)!="")
                {
                    $s_where.=" And i_is_active=".$s_is_active." ";
                    
                }
				
				 if(trim($s_category)!="")
				{	
					$cat_id=$this->coupon_model->get_cat_id($s_category);
					//pr($cat_id);
					foreach($cat_id as $id)
					{
						$ci .=($ci == '')?$id['i_id']:','.$id['i_id'];
					}
					
					//echo $ci;exit;
					if($ci)
					{
						//echo "212";
                    $s_where.=" And i_cat_id IN (".$ci.")";
					}
					else
					{
						 $s_where.=" And i_cat_id=0";
					}
                    
                }
				
				
				
				/* if(trim($s_store)!="")
				{	
					$cat_id=$this->coupon_model->get_store_id($s_store);
					//pr($cat_id);
					foreach($cat_id as $id)
					{
						$ci .=($ci == '')?$id['i_id']:','.$id['i_id'];
					}
					
					//echo $ci;exit;
					if($ci)
					{
						//echo "212";
                    $s_where.=" And i_store_id IN (".$ci.")";
					}
					else
					{
						 $s_where.=" And i_store_id=0";
					}
                    
                }*/
				
				
				if(trim($s_store)!="")
				{	
					$s_where.=" AND i_store_id= '".$s_store."'";
				}
				
				if(trim($txt_expiry_dt)!="")
                {
                    $s_where.=" And DATE(dt_exp_date)= '".$txt_expiry_dt."' ";
                    
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
            
			$info	= $this->coupon_model->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);///////////test
			//$name=
			//print_r ($info);
            /////////Creating List view for displaying/////////
			$table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]     		=	"Coupon";
            $table_view["total_rows"]		=	count($info);
			$table_view["total_db_records"]	=	$this->coupon_model->gettotal_info($s_where);
			$table_view["order_name"]		=	$order_name;
			$table_view["order_by"]  		=	$order_by;
            $table_view["src_action"]		= 	$this->pathtoclass.$this->router->fetch_method(); 
           // $table_view["detail_view"]		=   FALSE;          
            $table_view["headers"][0]["width"]	="20%";
            $table_view["headers"][0]["align"]	="left";
            //$table_view["headers"][0]["val"]	="Serial Number";
			//$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][0]["val"]	="Coupon Name";
			$table_view["headers"][1]["val"]	="URL";
			$table_view["headers"][2]["val"]	="Store";
			$table_view["headers"][3]["val"]	="Category";
			$table_view["headers"][4]["align"]	="center";
			$table_view["headers"][4]["val"]	="Status";
			//$table_view["headers"][5]["val"]	="Comments";
			$table_view["headers"][6]["val"]	="Top Coupon";
			$table_view["headers"][6]["align"]	="center";
			$table_view["headers"][7]["val"]	="Coupon code";
			$table_view["headers"][7]["align"]	="center";
			$table_view["headers"][8]["val"]	="Expiry date";
			$table_view["headers"][8]["align"]	="center"; 
			
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {	
				
				
				$sql= "SELECT COUNT(*) as total FROM cd_comments WHERE i_coupon_id = ".$info[$i]["i_id"];
				$vote = $this->db->query($sql);
				$vote1=$vote->result_array();
				
				$brand=$this->coupon_model->fetch_coupon_brand($info[$i]["i_id"]);
				//pr($brand);
					//$brand_name=$brand[0]['s_brand_title'];
					$brand_name = "";
					if(!empty($brand))
					{
						foreach($brand as $val)
						{
							$brand_name .= $val["s_brand_title"].', ' ;
						}
					}
					$brand_name = format_csv_string($brand_name);
					
				$store=$this->store_model->fetch_this($info[$i]["i_store_id"]);
				$store_name=$store[0]['s_store_title'];
				$cat=$this->category_model->fetch_this($info[$i]["i_cat_id"]);
				$cat_name=$cat[0]['s_category'];
				
                $img = $info[$i]["s_store_logo"] != ''? '<img src="'.base_url().'uploaded/store/thumb/thumb_'.$info[$i]['s_store_logo'].'" />' : 'No Image';
				$info[$i]["s_is_active"] = ($info[$i]["i_status"]==1)?'Active':'Inactive';
				
				$is_hot_checked = $info[$i]["i_is_hot"];
						
						if($is_hot_checked==1)
							$chk	= 'checked="checked"';
						else
							$chk	= "";
				
				$is_hot = '<input type = "checkbox" '.$chk.' id="i_is_hot_'.($info[$i]["i_id"]).'" name="i_is_hot" onclick=" return hot_status_check('.($info[$i]["i_id"]).' );" />';
				$i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);////Index 0 must be the encrypted PK 
                //$table_view["tablerows"][$i][$i_col++]	= $info[$i]["i_id"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_title"];
				//$table_view["tablerows"][$i][$i_col++]	= exclusive_strip_tags_more_view($brand_name,40);
				$table_view["tablerows"][$i][$i_col++]	= '<a href="'.make_valid_url($info[$i]["s_url"]).'" target="_blank">'.string_part($info[$i]["s_url"],30).'</a>';
				$table_view["tablerows"][$i][$i_col++]	= $store_name;
				$table_view["tablerows"][$i][$i_col++]	= $cat_name;
				
				
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
				// $table_view["tablerows"][$i][$i_col++]	=($info[$i]["i_is_active"] == 1)?$action."  "."Active":$action." "."Inactive";
				 $table_view["tablerows"][$i][$i_col++]	= $action;
				// $table_view["tablerows"][$i][$i_col++]	= '<a href="'.admin_base_url().'manage_comment/show_comments/'.$info[$i]["i_id"].' " target="_blank">'.$vote1[0]['total'].'</a>';
				 $is_hot_checked = $info[$i]["i_is_hot"];
						
						if($is_hot_checked==1)
							$chk	= 'checked="checked"';
						else
							$chk	= "";
				 $table_view["tablerows"][$i][$i_col++]	= $is_hot;
				}
			$code_of_coupon=($info[$i]["i_coupon_code"])?$info[$i]["i_coupon_code"]:"N/A";
			$table_view["tablerows"][$i][$i_col++]	=  $code_of_coupon;
			$table_view["tablerows"][$i][$i_col++]	=  date('d-m-Y',strtotime($info[$i]["dt_exp_date"]));
			
            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit,$action); 
            
            //$this->data["table_view"]=$this->admin_showin_table($table_view);
			$this->data["table_view"]=$this->admin_showin_order_table($table_view);
			
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            //echo $this->data["search_action"];
           
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
    {
        try
        {
            $posted=array();
            ///is the primary key,used for checking duplicate in edit mode
            $posted["id"]= decrypt($this->input->post("h_id"));/*don't change*/
            $posted["duplicate_value"]= htmlspecialchars(trim($this->input->post("h_duplicate_value")),ENT_QUOTES);
            
            if($posted["duplicate_value"]!="")
            {
                $qry=" Where ".(intval($posted["id"])>0 ? " i_id!=".intval($posted["id"])." And " : "" )
                    ." s_user_email='".$posted["duplicate_value"]."'";
                $info=$this->faq_model->fetch_multi($qry,$start,$limit); /*don't change*/
                if(!empty($info))/////Duplicate eists
                {
                    echo "Duplicate exists";
                }
                else
                {
                    echo "valid";/*don't change*/
                }
                unset($qry,$info);
            }   
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	
	///////////////user change status/////////
	
	public function ajax_change_status()
    {
        try
        {
            
                $posted["id"]           = decrypt(trim($this->input->post("h_id")));
                $posted["i_status"]     = trim($this->input->post("i_status"));
                $info = array();
                $info['i_is_active']    = $posted["i_status"]  ;
                $i_rect=$this->coupon_model->change_status($info,$posted["id"]); /*don't change*/				
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
	
	
	
	/***
    * upload csv file from here.
    */
   public function upload_csv()
    {
        try
        {
           if($_POST && $_FILES)
		   {
			     $tmp_name           =  $_FILES['csv_file']['tmp_name']; // temp path
				 $files           	 =  $_FILES['csv_file']['name'];		// name of file with extension
				 $filesize           =  $_FILES['csv_file']['size'];		// size of file
				 $filetype           =  $_FILES['csv_file']['type'];
				 //echo $filetype;exit;
				 //pr($_FILES,1);
				 //echo $tmp_name;exit;
				 $allowedType = array('text/x-tab-separated-values', 'text/tab-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel','text/x-csv');
				$ct = 0;
				$files_ext=end(explode('.',$files));
				//echo $files_ext;exit;
				if($filesize >70240000 || $files_ext!='csv' )
				{
					if($filesize >70240000)
					{
					set_error_msg ('upload a file which is smaller than 60 MB');
					}
					if($files_ext!='csv')
					{
						set_error_msg ('Please upload a csv file');
					}
					redirect(admin_base_url().'manage_coupon/show_list');
				}
	
				else
				{
					 if (($handle = fopen($tmp_name, "r")) !== FALSE) {
						# Set the parent multidimensional array key to 0.
						$nn = 0;
						while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { 
							# Count the total keys in the row.
							$c = count($data);
							# Populate the multidimensional array.
							for ($x=0;$x<$c;$x++)
							{
								$csvarray[$nn][$x] = $data[$x];					
							}
							$nn++;
						}
						# Close the File.
						fclose($handle);
					}
					//echo count($csvarray);
					
					$msg = "";
					$no_of_coupons_inserted=0;
					//pr(count($csvarray),1);
					for($i=1;$i<count($csvarray);$i++)
					{//echo "here";exit;
					$data = $csvarray[$i];
						//if(is_numeric($data[0]))
						//{
						
						$info=array();
						//$info["country"]			= $data[0];
						$date = str_replace('/','-',$data[7]);
						$tm = date('Y-m-d H:i:s',strtotime($date));
						$date_exp = str_replace('/','-',$data[11]);
						$dt_exp = date('Y-m-d H:i:s',strtotime($date_exp));
						
						//pr($date);pr($tm);pr($date_exp);pr($dt_exp,1);
						$info["i_type"]				= $data[0];
						$info["i_cat_id"]   		= $data[1];
						$info["i_brand_id"] 		= $data[2];
						$info["s_title"]			= $data[3];
						$info["s_summary"]  		= $data[4];
						$info["s_url"] 				= $data[5];
						$info["i_is_active"] 		= $data[6];
						//$info["i_no_of_hits"]		= $data[7];
						$info["dt_of_live_coupons"]  	= $tm;
						
						$info["i_coupon_code"] 		= $data[8];
						$info["i_store_id"] 		= $data[9];
						//$info["i_no_of_comments"] 	= $data[11];
						//$info["i_is_expired"] 		= $data[10];
						$info["i_coupon_type"] 		= $data[10];
						$info["dt_exp_date"] 		= $dt_exp;
						$info["s_meta_title"] 		= $data[12];
						$info["s_meta_description"] = $data[13];
						$info["s_meta_keyword"] 	= $data[14];
						
						$info["dt_date_of_entry"]  	= date('Y-m-d h-i-s',now());
						/*echo '<pre>'; 
						print_r($info); echo '</pre>'; 
						exit;*/
				if($info["i_type"]!='' && $info["i_cat_id"]!='' && $info["s_title"]!="" && $info["s_summary"]!='' && $info["dt_exp_date"]!='' && $info["i_coupon_type"]!='' && $info["i_store_id"]!='' && $info["i_is_active"]!='' && $info["dt_date_of_entry"]!='' && $info["dt_exp_date"]!='')
				{
					if(($info["i_coupon_code"]!="" && $info["i_coupon_type"]==2) || ($info["i_coupon_code"]=="" && $info["i_coupon_type"]==1))
					{
						
						if(!empty($info['i_store_id']) && !empty($info["i_cat_id"]))
						{
							//$sql = "SELECT * FROM cd_store WHERE s_store_title='".addslashes(trim($info['i_store_id']))."' AND i_cat_id='".$info["i_cat_id"]."' ";
							$sql = "SELECT * FROM cd_store WHERE s_store_title='".addslashes(trim($info['i_store_id']))."'";
							$res = $this->db->query($sql);							
							$num_rows	=	$res->num_rows();
							if(!$num_rows)
							{
								$sql1 = "INSERT INTO cd_store(s_store_title,i_cat_id,i_is_active) VALUES ('".addslashes(trim($info["i_store_id"]))."','".$info["i_cat_id"]."','1')";	
								$res1 		= $this->db->query($sql1);
								$store_id	= $this->db->insert_id();
							}
							else
							{						
								//$row	=	mysql_fetch_assoc($res);								
								$row	=	$res->result_array();
								$store_id	=	$row[0]['i_id'];
							}
							
							
							if($info["i_coupon_type"]==2)	
							{
								$sql4	=	"SELECT * FROM cd_coupon WHERE i_coupon_code = '".addslashes($info['i_coupon_code'])."'";
								$res4=$this->db->query($sql4);
								$num_rows	=	$res4->num_rows();
								//if(!$num_rows)
								if(1)
								{
								/* insert coupon here */
								$coupon_url	= getSeoUrl_for_coupon($this->db->COUPON,trim($info["s_title"]));
								 $sql5 = "INSERT INTO cd_coupon
										(i_type,i_cat_id,s_title,s_summary,s_url,i_is_active,i_no_of_hits,								   							    		dt_of_live_coupons,i_coupon_code,i_store_id,i_no_of_comment,i_is_expired,
										i_coupon_type,dt_exp_date,s_meta_title,s_meta_description,s_meta_keyword,s_seo_url) 
									VALUES 
									('".addslashes(trim($info["i_type"]))."','".$info["i_cat_id"]."',
									'".addslashes(trim($info["s_title"]))."','".addslashes(trim($info["s_summary"]))."',
								'".addslashes(trim($info["s_url"]))."','".$info["i_is_active"]."','".$info["i_no_of_hits"]."',
								'".$info["dt_of_live_coupons"]."','".addslashes($info["i_coupon_code"])."','".$store_id."',
								'".$info["i_no_of_comments"]."','".$info["i_is_expired"]."','".$info["i_coupon_type"]."',
								'".$info["dt_exp_date"]."','".$info["s_meta_title"]."','".$info["s_meta_description"]."','".$info["s_meta_keyword"]."','".$coupon_url."'
								   )";	
								   
								$res5	=	$this->db->query($sql5);
								$coupon_id   = $this->db->insert_id();
								/* insert coupon here */
								}
							}
							else if($info["i_coupon_type"]==1)
							{
								$sql4	=	"SELECT * FROM cd_coupon WHERE s_title = '".addslashes($info['s_title'])."' AND i_cat_id = '".$info["i_cat_id"]."' ";
								$res4=$this->db->query($sql4);
								$num_rows	=	$res4->num_rows();
								if(!$num_rows)
								{
								/* insert coupon here */
								$coupon_url	= getSeoUrl_for_coupon($this->db->COUPON,trim($info["s_title"]));
								$sql5 = "INSERT INTO cd_coupon
										(i_type,i_cat_id,s_title,s_summary,s_url,i_is_active,i_no_of_hits,								   							    		dt_of_live_coupons,i_store_id,i_no_of_comment,i_is_expired,
										i_coupon_type,dt_exp_date,s_meta_title,s_meta_description,s_meta_keyword,s_seo_url) 
									VALUES 
									('".addslashes(trim($info["i_type"]))."','".$info["i_cat_id"]."',
									'".addslashes(trim($info["s_title"]))."','".addslashes(trim($info["s_summary"]))."',
									'".addslashes(trim($info["s_url"]))."','".$info["i_is_active"]."','".$info["i_no_of_hits"]."',
									'".$info["dt_of_live_coupons"]."','".$store_id."','".$info["i_no_of_comments"]."',
									'".$info["i_is_expired"]."','".$info["i_coupon_type"]."',
									'".$info["dt_exp_date"]."','".$info["s_meta_title"]."','".$info["s_meta_description"]."','".$info["s_meta_keyword"]."','".$coupon_url."'
								   )";	
								   
								$res5	=	$this->db->query($sql5);
								$coupon_id   = $this->db->insert_id();
								/* insert coupon here */
								}
							}	
							
							
							if($coupon_id!="")
							{
								$no_of_coupons_inserted = $no_of_coupons_inserted+1;///---------------------counter
								/* insert into brand tables */
								if(!empty($info["i_brand_id"]))
								{
									$brands_arr = explode(',',$info["i_brand_id"]);
									if(count($brands_arr)>0)
									{
										foreach($brands_arr as $val)
										{
											$sql2 = "SELECT * FROM cd_brand WHERE s_brand_title='".addslashes(trim($val))."' ";
											$res2 = $this->db->query($sql2);
											$num_rows	=	$res2->num_rows();
											if(!$num_rows)
											{
												$sql2 = "INSERT INTO cd_brand(s_brand_title,i_is_active) VALUES ('".addslashes(trim($val))."','1')";	
												$res2 		= $this->db->query($sql2);
												$brand_id	= $this->db->insert_id();
											}
											else
											{
												//$row	=	mysql_fetch_assoc($res2);
												$row	=	$res2->result_array();
												$brand_id	=	$row[0]['i_id'];
											}
											
											/* insert coupon brand table */
											$sql6="INSERT INTO cd_coupon_brand (i_coupon_id,i_brand_id) VALUES ('".$coupon_id."','".$brand_id."')";
											$res6=$this->db->query($sql6);
											/* insert coupon brand table */
											
										}
									}
								}
								/* insert into brand tables */
							}
							else
							{
								$msg .= $info["s_title"].', ';
								//echo $info["s_title"].'<br> ';///------------------------TEST
							}
							
							
									
						}
						else
						{
							$msg .=$info["s_title"].', ';
						}
						
					}
					else
					{
						$msg .=$info["s_title"].', ';
						
					}	
				}  // end if all mandatory field
				else
				{
					$msg .=$info["s_title"].', ';
				}
						
			//}  // if numeric						
						
			}	// end of for loop
			//echo $msg;exit;
			$no_of_error= array();
			$no_of_error= explode(',',format_csv_string($msg));
			$no_error= count ($no_of_error);
			//echo $no_error;
			
			if($msg!="")		
				$msg = " But there is something wrong in these coupons titled ".((format_csv_string($msg)!='')?format_csv_string($msg):'Row with blank title');
			set_success_msg('File uploaded successfully.('.$no_of_coupons_inserted.'/'.($no_error+$no_of_coupons_inserted).') coupons inserted... MSG:'.$msg);		
			redirect(admin_base_url().'manage_coupon/show_list');	
		}	// end of else part
	   }
	   set_error_msg('Upload a File');
	   redirect(admin_base_url().'manage_coupon/show_list');
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}         
}
	
	public	function get_coupon_hot_status()
	{
		$current_coupon_id	= $this->input->post('current_coupon_id');
		
		$coupon_details		= $this->coupon_model->fetch_this($current_coupon_id);		
		
		if($coupon_details[0]['i_is_active']==1)
			echo $this->coupon_model->get_coupon_hot_status($current_coupon_id);
		else
			echo 0;
		
		//echo $this->coupon_model->get_coupon_hot_status($current_coupon_id);
		
	}	
	
public function change_hot_status()
	{
		try
		{
			$current_coupon_id	= $this->input->post('current_coupon_id');
			$current_coupon_status	= $this->input->post('current_coupon_status');
			echo $this->coupon_model->update_hot_coupon_status($current_coupon_id, $current_coupon_status);
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
	}	
	
	
public function show_list_expired_coupon($order_name='',$order_by='desc',$start=NULL,$limit=NULL)
	{
		try
        {
            $this->data['action_allowed']['Add']  =   0;// to remove add option in this particular show list
			$this->data['heading']="Manage Expired Coupon";////Package Name[@package] Panel Heading
			$this->data['coupon_type_exp']="expired";// for checking whether coupon is expired or not
			$this->session->set_userdata('coupon_controller','expired');//to redirect to expired show list after delete
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
            
			
           // $s_where=" WHERE dt_exp_date<now()";/////////////////////////1====
			$s_where=" WHERE CONCAT(DATE(dt_exp_date),' 23:59:59')<now() AND i_coupon_type = 2 ";
            if($s_search=="basic")
            {
                $s_where .= " AND s_title LIKE '%".my_receive_like($s_coupon)."%' ";
				
				
				 if(trim($s_is_active)!="")
                {
                    $s_where.=" And i_is_active=".$s_is_active." ";
                    
                }
				
				 if(trim($s_category)!="")
				{	
					$cat_id=$this->coupon_model->get_cat_id($s_category);
					//pr($cat_id);
					foreach($cat_id as $id)
					{
						$ci .=($ci == '')?$id['i_id']:','.$id['i_id'];
					}
					
					//echo $ci;exit;
					if($ci)
					{
						//echo "212";
                    $s_where.=" And i_cat_id IN (".$ci.")";
					}
					else
					{
						 $s_where.=" And i_cat_id=0";
					}
                    
                }
				
				
				
			/*	 if(trim($s_store)!="")
				{	
					$cat_id=$this->coupon_model->get_store_id($s_store);
					//pr($cat_id);
					foreach($cat_id as $id)
					{
						$ci .=($ci == '')?$id['i_id']:','.$id['i_id'];
					}
					
					//echo $ci;exit;
					if($ci)
					{
						//echo "212";
                    $s_where.=" And i_store_id IN (".$ci.")";
					}
					else
					{
						 $s_where.=" And i_store_id=0";
					}
                    
                }*/
				
				
				if(trim($s_store)!="")
				{	
					$s_where.=" AND i_store_id= '".$s_store."'";
				}
				
				
				
				if(trim($txt_expiry_dt)!="")
                {
                    $s_where.=" And DATE(dt_exp_date)= '".$txt_expiry_dt."' ";
                    
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
            elseif($s_search=="advanced")
            {
               /* $s_where .=" AND n.s_email LIKE '%".get_formatted_string($s_user_title)."%' ";
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.dt_created_on , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_user_title",$s_user_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_user_title"]=$s_user_title;                
                $this->data["txt_created_on"]=$dt_created_on;     */        
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
               //$s_where=" WHERE n.id!=1 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("s_coupon");
                $this->session->unset_userdata("s_is_active");
				$this->session->unset_userdata("s_category");
				$this->session->unset_userdata("s_store");
				$this->session->unset_userdata("txt_expiry_dt");
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
            
			$info	= $this->coupon_model->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);///////////test
			//$name=
				//print_r ($info);
            /////////Creating List view for displaying/////////
			$table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]     		=	"Coupon";
            $table_view["total_rows"]		=	count($info);
			$table_view["total_db_records"]	=	$this->coupon_model->gettotal_info($s_where);
			$table_view["order_name"]		=	$order_name;
			$table_view["order_by"]  		=	$order_by;
            $table_view["src_action"]		= 	$this->pathtoclass.$this->router->fetch_method(); 
           // $table_view["detail_view"]		=   FALSE;          
            $table_view["headers"][0]["width"]	="25%";
            $table_view["headers"][0]["align"]	="left";
            //$table_view["headers"][0]["val"]	="Serial Number";
			//$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][0]["val"]	="Coupon Name";
			$table_view["headers"][1]["val"]	="URL";
			$table_view["headers"][2]["val"]	="Store";
			$table_view["headers"][3]["val"]	="Category";
			$table_view["headers"][4]["align"]	="center";
			$table_view["headers"][4]["val"]	="Coupon code";
			$table_view["headers"][5]["val"]	="Exp. Date"; 
			
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {	
			
				$brand=$this->coupon_model->fetch_coupon_brand($info[$i]["i_id"]);
					//$brand_name=$brand[0]['s_brand_title'];
					$brand_name = "";
					if(!empty($brand))
					{
						foreach($brand as $val)
						{
							$brand_name .= $val["s_brand_title"].', ' ;
						}
					}
					$brand_name = format_csv_string($brand_name);
					
				$store=$this->store_model->fetch_this($info[$i]["i_store_id"]);
				$store_name=$store[0]['s_store_title'];
				$cat=$this->category_model->fetch_this($info[$i]["i_cat_id"]);
				$cat_name=$cat[0]['s_category'];
				
                $img = $info[$i]["s_store_logo"] != ''? '<img src="'.base_url().'uploaded/store/thumb/thumb_'.$info[$i]['s_store_logo'].'" />' : 'No Image';
				$info[$i]["s_is_active"] = ($info[$i]["i_status"]==1)?'Active':'Inactive';
				
				$i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);////Index 0 must be the encrypted PK 
                //$table_view["tablerows"][$i][$i_col++]	= $info[$i]["i_id"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_title"];
				//$table_view["tablerows"][$i][$i_col++]	= exclusive_strip_tags_more_view($brand_name,40);
				$table_view["tablerows"][$i][$i_col++]	= '<a href="'.make_valid_url($info[$i]["s_url"]).'" target="_blank">'.string_part($info[$i]["s_url"],20).'</a>';
				$table_view["tablerows"][$i][$i_col++]	= $store_name;
				$table_view["tablerows"][$i][$i_col++]	= $cat_name;
				
				
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
				// $table_view["tablerows"][$i][$i_col++]	=($info[$i]["i_is_active"] == 1)?$action."  "."Active":$action." "."Inactive";
				 //$table_view["tablerows"][$i][$i_col++]	= $action;
				// $table_view["tablerows"][$i][$i_col++]	= '<a href="'.admin_base_url().'manage_vote/show_comments/'.$info[$i]["i_id"].' " target="_blank">'.$info[$i]["i_no_of_comment"].'</a>';
				}
			$code_of_coupon=($info[$i]["i_coupon_code"])?$info[$i]["i_coupon_code"]:"N/A";
			$table_view["tablerows"][$i][$i_col++]	=  $code_of_coupon;
			$table_view["tablerows"][$i][$i_col++]	=   date('d-m-Y',strtotime($info[$i]["dt_exp_date"]));
            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit,$action); 
            
            //$this->data["table_view"]=$this->admin_showin_table($table_view);
			$this->data["table_view"]=$this->admin_showin_order_table($table_view);
			
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            //echo $this->data["coupon_type_exp"];
           
            $this->render("manage_coupon/show_list");          
            unset($table_view,$info);
          
        }
        catch(Exception $err_obj)
        {
        	show_error($err_obj->getMessage());
        }  
	}	
	    
	public function __destruct()
    {}
}