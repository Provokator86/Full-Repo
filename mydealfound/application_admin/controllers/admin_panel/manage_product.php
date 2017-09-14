<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 17 Mar 2014
* Modified By: 
* Modified Date:
* Purpose:
*  controller For OMGP Product Manage
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/manage_product.php
* @link views/admin/manage_product/
*/

class Manage_product extends My_Controller implements InfController
{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public $uploaddir;
	public $allowedExt;	
	
    public function __construct()
    {
        try
        {
          parent::__construct();
          ////////Define Errors Here//////
          $this->data['title']="Manage Product";////Browser Title
          ////////Define Errors Here//////
          $this->cls_msg = array();

          $this->cls_msg["no_result"]				= "No information found about product.";
          $this->cls_msg["save_err"]				= "product failed to save.";
          $this->cls_msg["save_succ"]				= "Saved successfully.";
          $this->cls_msg["delete_err"]				= "product setting failed to remove.";
          $this->cls_msg["delete_succ"]				= "product removed successfully.";

          ////////end Define Errors Here//////
		  $this->pathtoclass 						= admin_base_url().$this->router->fetch_class()."/";
		 
		  $this->load->model("product_model_omgp");
		  $this->load->model("common_model","mod_common");
		  $this->load->model("store_model");
		  $this->data['store']	= $this->store_model->get_store();
		  
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
            $this->data['title']		=	"Manage Product";////Browser Title
            $this->data['heading']		=	"Manage Product";
			//redirect($this->pathtoclass.'show_list');
			redirect($this->pathtoclass.'add_information');
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
    * On Success redirect to the showList interface else display error here.
    */
    public function add_information_old_19Mar2014()   
    {
		try
        {

          	$this->data['title']				= "Manage Product";////Browser Title
            $this->data['heading']				= "Manage Product ";
            $this->data['pathtoclass']			= $this->pathtoclass;
            $this->data['mode']					= "add";
			
			$DiscountedPrice	= 0; // used later			
			$discount = 0;		
			$total_insert	 =0;
			
			/*$url="http://feeds.omgeu.com/data/feed.aspx?hash=638cde3785bf4158aa8b644e9b2a02c3&page=1";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents		
			$data = curl_exec($ch); // execute curl request
			curl_close($ch);		
			$xml = simplexml_load_string($data);
			echo '<pre>';
			print_r($xml); 
			echo '</pre>';exit;*/
			/*$tmp_xml = @file_get_contents("http://feeds.omgeu.com/data/feed.aspx?hash=bb0ed8a0ec194e989ae480cf6b6f2375&page=1");
     		$xml_array = xml2array($tmp_xml,0);
			pr($xml_array,1);*/

			if($_POST)
        	{
				$posted["s_url"]			= 	$this->input->post("s_url");
				$this->form_validation->set_rules('s_url','URL','required');
				if($this->form_validation->run() == FALSE)		
				{		
					$this->data['posted'] = $_POST;	
				}
				else		
				{	
					$url = $posted["s_url"];
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents		
					$data = curl_exec($ch); // execute curl request
					curl_close($ch);
					$xml_data = simplexml_load_string($data); // data object
					//$json = json_decode(json_encode($xml_data),TRUE);
					
					
					if(!empty($xml_data))
					{
						$tot_rec = $xml_data->attributes["TotalRecordsAvailable"];
						$prod_arr = $xml_data->Products->Product;
						
						if(!empty($prod_arr))
						{
							foreach($prod_arr as $key=>$val)
							{
								$elem_obj = $val;  // object for a single product
								//pr($elem_obj,1);
								$ProductAttr 	= (array)$elem_obj;
								//pr($ProductAttr["@attributes"],1);
								$ProductID 		= $ProductAttr["@attributes"]["ProductID"]; 
								$SKU 			= (string)$elem_obj->SKU;		
													
								$Name 			= (string)$elem_obj->Name;
								$Description 	= (string)$elem_obj->Description;
								$URL 			= (string)$elem_obj->URL;
								$Price 			= (string)$elem_obj->Price;
								$Currency 		= (string)$elem_obj->Currency;
								$MediumImage 	= (string)$elem_obj->MediumImage;
								$Merchant 		= (string)$elem_obj->Merchant;
								$StartDate 		= (string)$elem_obj->StartDate;
								$ExpirationDate	= (string)$elem_obj->ExpirationDate; // format 2014-12-20T02:01:37
								
								$Categories 	= $elem_obj->Categories; // object Categories
								$cat_name 		= (string)$Categories->Category->Name; 
								$catId 			= $Categories->Category->attributes["Id"]; //this category id in merchant side.
								$cat_path 		= (string)$Categories->Category->Path;
								
								$categoryId 	= $this->product_model_omgp->getCategoryId($cat_path);								
								$Attributes 	= $elem_obj->Attributes;
								$attr_arr 		= $Attributes->Attribute;
								//var_dump($attr_arr[2]);exit;
								
								for($i=0;$i<count($attr_arr); $i++)
								{									
									if((string)$attr_arr[$i]->Name==='DiscountedPrice')
									{
										$DiscountedPrice = (string)$attr_arr[$i]->Value; 
									}
								}
								
								if($DiscountedPrice==0)
								{
									$DiscountedPrice = $Price;
								}							
								$discount = ceil(($Price-$DiscountedPrice)/$Price*100);
								$StartDate =  date("Y-m-d H:i:s",strtotime("$StartDate"));
								$ExpirationDate =  date("Y-m-d H:i:s",strtotime("$ExpirationDate"));
								
								$seo_url	= getSeoUrl_for_coupon($this->db->COUPON,$Name);
								$storeId	= $this->product_model_omgp->getStoreId($Merchant);
								// now make the product array to be insert
								$info	= array(
									"i_cat_id"				=> $categoryId,
									"i_store_id"			=> $storeId,
									"s_product_id"			=> $ProductID,
									"s_sku"					=> $SKU,
									"s_title"				=> $Name,
									"s_summary"				=> $Description,
									"s_url"					=> $URL,
									"d_list_price"			=> $Price,
									"s_image_url"			=> $MediumImage,
									"s_merchant"			=> $Merchant,
									"dt_of_live_coupons"	=> $StartDate,
									"dt_exp_date"			=> $ExpirationDate,
									"dt_date_of_entry"		=> $StartDate,
									"d_selling_price"		=> $DiscountedPrice,
									"d_discount"			=> $discount,
									"s_attributes"			=> json_encode($Attributes),
									"s_seo_url"				=> $seo_url,
									"i_is_active"			=> 1,
									"i_coupon_type"			=> 1,
									"i_is_daily"			=> 1
									);
								
								
								// checking for duplicacy	
								$s_where = " WHERE i_store_id ='".$storeId."' AND s_sku='".$SKU."' ";
								$chk = $this->product_model_omgp->gettotal_info($s_where);
								if($chk>0)
								{
								}
								else if($DiscountedPrice!=$Price)
								{
									$inserted_rec	= $this->product_model_omgp->add_info($info);	
									$total_insert++;
								}
								else
								{
								}
								
							}
						}
						
					}
					
					//$total_insert." record inserted out of ".count($prod_arr);
					set_success_msg($this->cls_msg["save_succ"]);
                    redirect($this->pathtoclass."add_information");
					
				
				}
            }

            ////////////end Submitted Form///////////

            $this->render("manage_product/add-edit");
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
    * On Success redirect to the showList interface else display error here.
    */
	
	function process_xml_array_data($data_arr=array(),$storeId=0)
	{		
		if(!empty($data_arr))
		{
			//pr($data_arr);
			//pr($data_arr);
			//echo count($data_arr);		
			$start_key = $this->session->userdata('unprocessed_key')?$this->session->userdata('unprocessed_key'):1;
			//pr($data_arr);
			for($i=$start_key;$i<count($data_arr); $i++)
			{
				$info = array();				
				$arr = $data_arr[$i];
				
				$categories 				= $arr['category_path'];	
				//$img_url = explode(',',$arr[2]);				
				$info["s_product_id"] 		= $arr['s_product_id'];
				$info["s_sku"] 				= $arr['s_sku'];
				$info["s_title"] 			= $arr['s_title'];
				$info["s_image_url"] 		= $arr['s_image_url'];				
				$info["d_list_price"] 		= $arr['d_list_price'];
				$info["d_selling_price"]	= $arr['d_selling_price'];
				$info["s_summary"] 			= $arr['s_summary'];
				$info["s_url"] 				= $arr['s_url'].'&AffExtParam1=MYDEALFOUNDXXX';
				$info["s_attributes"]		= $arr['s_attributes'];				
				$info["i_is_active"] 		= 1;
				$info["i_coupon_type"] 		= 1;
				$info["i_is_daily"] 		= 1;
				$info["i_store_id"] 		= $storeId;  // 318 for flipkart in live
				$info["s_merchant"] 		= $arr['s_merchant'];
				
				$info["dt_of_live_coupons"]	= $arr['dt_of_live_coupons'];
				$info["dt_exp_date"] 		= $arr['dt_exp_date'];
				$info["dt_date_of_entry"]	= $arr['dt_date_of_entry'];				
				//$seo_url	= getSeoUrl_for_coupon($this->db->COUPON,$info["s_title"]);				
				$info["s_seo_url"]			= $arr['s_seo_url'];				
				//$discount = ceil(($info["d_list_price"]-$info["d_selling_price"])/$info["d_list_price"]*100);
				$info["d_discount"]			= $arr['d_discount'];
				$info["s_brand_name"]		= $arr['s_brand_name'];
				
				//pr($info,1);
				// first check for category store skip table
				$condition = " WHERE s_store_category ='".my_receive_text($categories)."' AND i_store_id='".$storeId."' ";
				$chk_cat_skip =  $this->product_model_omgp->fetch_category_skip($condition,0,1);
				
				if(empty($chk_cat_skip))
				{
						// check category record here
						$condition = " WHERE s_store_category ='".my_receive_text($categories)."' AND i_store_id='".$storeId."' ";
						$chk_cat =  $this->product_model_omgp->fetch_category_map($condition,0,1);
						//pr($chk_cat,1);
						if(!empty($chk_cat))
						{
							$info["i_cat_id"] 		= $chk_cat[0]["i_original_cat_id"];
							/*if($info["d_list_price"]!=$info["d_selling_price"])
							{*/
								$inserted_rec	= $this->product_model_omgp->add_jabong_product($info);
								//pr($info,1);
								$this->session->unset_userdata('unprocessed_key');
								$this->session->unset_userdata('category_not_found');
							/*}*/
						}
						else
						{					
							// halt the process here					
							$msg = $categories;
							if($msg)
								set_error_msg($msg.' Category Does not Found.');
							$this->session->set_userdata('unprocessed_key',$i);
							$this->session->set_userdata('category_not_found',$categories);
							redirect(base_url().'admin_panel/manage_product/add_information');
							
						}
				
				}
				
			}
			
			//echo $this->session->userdata('unprocessed_key'); exit;
			
		}
	}
	
	
	function process_array_data($data_arr=array(),$storeId=0)
	{		
		if(!empty($data_arr))
		{
			//pr($data_arr,1);
			//pr($data_arr);
			//echo count($data_arr);		
			$start_key = $this->session->userdata('unprocessed_key')?$this->session->userdata('unprocessed_key'):1;
			
			for($i=$start_key;$i<count($data_arr); $i++)
			{
				$info = array();				
				$arr = $data_arr[$i];
				
				$attributes = array();				
				$attributes["Brand Name"] = $arr[7];		
				$attributes["Delivery Time"] = $arr[8];		
				$attributes["In Stock"] 		= $arr[9];		
				$attributes["COD Available"] = $arr[10];		
				$attributes["EMI Available"] = $arr[11]; 
				$attributes["Offers"] 		= $arr[12];
				$attributes["Discount"] 	= $arr[13];
				//$attributes["cashBack"] 	= $arr[13];
				
				$categories 				= $arr[6];				
				
				$img_url = explode(',',$arr[2]);
				
				$info["s_product_id"] 		= $arr[0];
				$info["s_sku"] 				= $arr[0];
				$info["s_title"] 			= $arr[1];
				$info["s_image_url"] 		= $img_url[8];				
				$info["d_list_price"] 		= $arr[3];
				$info["d_selling_price"]	= $arr[4];
				$info["s_summary"] 			= "";
				//$info["s_url"] 				= $arr[5].'&AffExtParam1=MYDEALFOUNDXXX';
				$info["s_url"] 				= $arr[5].getStoreTrackingParam($storeId);
				$info["s_attributes"]		= json_encode($attributes);				
				$info["i_is_active"] 		= 1;
				$info["i_coupon_type"] 		= 1;
				$info["i_is_daily"] 		= 1;
				$info["i_store_id"] 		= $storeId;  // 318 for flipkart in live getStoreTrackingParam
				$info["s_merchant"] 		= getStoreTitles($storeId);;
				
				$info["dt_of_live_coupons"]	= "";
				$info["dt_exp_date"] 		= "";
				$info["dt_date_of_entry"]	= ""; 
				$info["s_brand_name"] 		= $arr[7];
				
				$seo_url	= getSeoUrl_for_coupon($this->db->COUPON,$info["s_title"]);				
				$info["s_seo_url"]			= $seo_url;
				
				$discount = ceil(($info["d_list_price"]-$info["d_selling_price"])/$info["d_list_price"]*100);
				$info["d_discount"]	= $discount;
				//pr($info,1);
				// first check for category store skip table
				$condition = " WHERE s_store_category ='".my_receive_text($categories)."' AND i_store_id='".$storeId."' ";
				$chk_cat_skip =  $this->product_model_omgp->fetch_category_skip($condition,0,1);
				
				if(empty($chk_cat_skip))
				{
						// check category record here
						$condition = " WHERE s_store_category ='".my_receive_text($categories)."' AND i_store_id='".$storeId."' ";
						$chk_cat =  $this->product_model_omgp->fetch_category_map($condition,0,1);
						//pr($chk_cat,1);
						if(!empty($chk_cat))
						{
							$info["i_cat_id"] 		= $chk_cat[0]["i_original_cat_id"];
							/*if($info["d_list_price"]!=$info["d_selling_price"])
							{*/
								$inserted_rec	= $this->product_model_omgp->add_flipkart_product($info);
								//pr($info,1);
								$this->session->unset_userdata('unprocessed_key');
								$this->session->unset_userdata('category_not_found');
							/*}*/
						}
						else
						{					
							// halt the process here					
							$msg = $categories;
							if($msg)
								set_error_msg($msg.' Category Does not Found.');
							$this->session->set_userdata('unprocessed_key',$i);
							$this->session->set_userdata('category_not_found',$categories);
							redirect(base_url().'admin_panel/manage_product/add_information');
							
						}
						
				}
				
			}
			
			//echo $this->session->userdata('unprocessed_key'); exit;
			
		}
	}
	
	public function add_information()   
    {
		try
        {

          	$this->data['title']				= "Manage Product";////Browser Title
            $this->data['heading']				= "Manage Product ";
            $this->data['pathtoclass']			= $this->pathtoclass;
            $this->data['mode']					= "add";
			
			$referrer_link = $_SERVER['HTTP_REFERER'];
			if($referrer_link!='')
			{
				$pos = strpos($referrer_link, 'manage_product');
				
				if ($pos >= 0 && $pos*1!='') {
					//$this->session->unset_userdata('sess_store_id');
					//$this->session->unset_userdata('sess_file_path');
				} else { 
					$this->session->unset_userdata('sess_store_id');
					$this->session->unset_userdata('sess_file_path');
					$this->session->unset_userdata('unprocessed_key');
					$this->session->unset_userdata('category_not_found');
					$this->session->unset_userdata('h_import_type');
				}
			}
			
			$DiscountedPrice	= 0; // used later			
			$discount = 0;		
			$total_insert	 =0;
			//pr($_FILES,1);
			//$this->session->unset_userdata('unprocessed_key');
			//$this->session->unset_userdata('category_not_found');

			if($_POST)
        	{				
				$posted['i_store_id'] 		= $this->input->post('i_store_id');
				$posted['file_path'] 		= $this->input->post('file_path');
				$posted['h_import_type'] 	= $this->input->post('h_import_type');
				//pr($posted,1);
				
				if($posted["i_store_id"]!=$this->session->userdata('sess_store_id'))
				{
					// unset session values
					$this->session->unset_userdata('unprocessed_key');
					$this->session->unset_userdata('category_not_found');
					$this->session->unset_userdata('sess_store_id');
					$this->session->unset_userdata('sess_file_path');
					$this->session->unset_userdata('h_import_type');
				}
				
				$this->session->set_userdata('sess_store_id',$posted['i_store_id']);
				$this->session->set_userdata('sess_file_path',$posted['file_path']);
				$this->session->set_userdata('h_import_type',$posted['h_import_type']);
				
				ini_set('memory_limit', '512M');
				ini_set('max_execution_time', '6000');
				
				if($posted['file_path']!='')
				{
					if($posted['h_import_type']=='csv')
					{
						//echo 'csv';exit;
						//$tmp_name = "sd.csv";
						$tmp_name = $posted['file_path'];
						if (($handle = fopen($tmp_name, "r")) !== FALSE) {
						
							$nn = 0;
							while (($data = fgetcsv($handle)) !== FALSE) { 					
								# Count the total keys in the row.
								//echo 'here';exit;
								$c = count($data);
								 // testing purpose
								//echo '<pre>'; pr($data); echo '</pre>'; exit;
								# Populate the multidimensional array.
								$cnt = 0;
								for ($x=0;$x<$c;$x++)
								{
									//echo $x.'==></br>';
									$csvarray[$nn][$x] = $data[$x];	
																									
																
								}	
								$csv_data[] = $csvarray[$nn];	
								if($nn%15==0)				
								{
									$processed = $this->process_array_data($csv_data,$posted['i_store_id']);	
									$cnt = -1;								
									unset($data);									
									unset($csv_data);									
								}						
								//$cnt++;
								$nn++;											
							}
							
							# Close the File.
							fclose($handle);
							/*$data = array();
							exit;
							for($i=1;$i<count($csvarray);$i++)
							{
								$data[$i] = $csvarray[$i];	
								if($i%15==0)				
								{
									//pr($data,1);
									//echo 'done';exit;
									$processed = $this->process_array_data($data,$posted['i_store_id']);
									
								}
							}*/
							
						}				
						else
						{
							set_error_msg('File not found');
							//redirect(base_url().'admin_panel/manage_product/add_information');
							$this->data["posted"] = $posted;
						}
					}
					if($posted['h_import_type']=='xml')
					{
						$url = $posted["file_path"];
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents		
						$data = curl_exec($ch); // execute curl request
						curl_close($ch);
						$xml_data = simplexml_load_string($data); // data object
						//$json = json_decode(json_encode($xml_data),TRUE);
						
						
						if(!empty($xml_data))
						{
							$tot_rec = $xml_data->attributes["TotalRecordsAvailable"];
							$prod_arr = $xml_data->Products->Product;
							
							if(!empty($prod_arr))
							{
								$jj = 1;  // array index of $info
								foreach($prod_arr as $key=>$val)
								{
									
									$elem_obj = $val;  // object for a single product
									//pr($elem_obj,1);
									$ProductAttr 	= (array)$elem_obj;
									//pr($ProductAttr["@attributes"],1);
									$ProductID 		= $ProductAttr["@attributes"]["ProductID"]; 
									$SKU 			= (string)$elem_obj->SKU;		
														
									$Name 			= (string)$elem_obj->Name;
									$Description 	= (string)$elem_obj->Description;
									$URL 			= (string)$elem_obj->URL;
									$Price 			= (string)$elem_obj->Price;
									$Currency 		= (string)$elem_obj->Currency;
									$MediumImage 	= (string)$elem_obj->MediumImage;
									$Merchant 		= (string)$elem_obj->Merchant;
									$StartDate 		= (string)$elem_obj->StartDate;
									$ExpirationDate	= (string)$elem_obj->ExpirationDate; // format 2014-12-20T02:01:37
									
									$Categories 	= $elem_obj->Categories; // object Categories
									$cat_name 		= (string)$Categories->Category->Name; 
									$catId 			= $Categories->Category->attributes["Id"]; //this category id in merchant side.
									$cat_path 		= (string)$Categories->Category->Path;
									
									//$categoryId 	= $this->product_model_omgp->getCategoryId($cat_path);								
									$Attributes 	= $elem_obj->Attributes;
									$attr_arr 		= $Attributes->Attribute;
									//var_dump($attr_arr[2]);exit;
									
									$BrandName = '';
									
									for($i=0;$i<count($attr_arr); $i++)
									{									
										if((string)$attr_arr[$i]->Name==='DiscountedPrice')
										{
											$DiscountedPrice = (string)$attr_arr[$i]->Value; 
										}
										if((string)$attr_arr[$i]->Name==='Brand')
										{
											$BrandName = (string)$attr_arr[$i]->Value; 
										}
									}
									
									if($DiscountedPrice==0)
									{
										$DiscountedPrice = $Price;
									}							
									$discount = ceil(($Price-$DiscountedPrice)/$Price*100);
									$StartDate =  date("Y-m-d H:i:s",strtotime("$StartDate"));
									$ExpirationDate =  date("Y-m-d H:i:s",strtotime("$ExpirationDate"));
									
									$seo_url	= getSeoUrl_for_coupon($this->db->COUPON,$Name);
									$storeId	= $this->product_model_omgp->getStoreId($Merchant);
									// now make the product array to be insert
									$info[$jj]	= array(
										"i_cat_id"				=> $categoryId,
										"i_store_id"			=> $storeId,
										"s_product_id"			=> $ProductID,
										"s_sku"					=> $SKU,
										"s_title"				=> $Name,
										"s_summary"				=> $Description,
										"s_url"					=> $URL,
										"d_list_price"			=> $Price,
										"s_image_url"			=> $MediumImage,
										"s_merchant"			=> $Merchant,
										"dt_of_live_coupons"	=> $StartDate,
										"dt_exp_date"			=> $ExpirationDate,
										"dt_date_of_entry"		=> $StartDate,
										"d_selling_price"		=> $DiscountedPrice,
										"d_discount"			=> $discount,
										"s_attributes"			=> json_encode($Attributes),
										"s_seo_url"				=> $seo_url,
										"i_is_active"			=> 1,
										"i_coupon_type"			=> 1,
										"i_is_daily"			=> 1,
										"category_path"			=> $cat_path,
										"s_brand_name"			=> $BrandName
										);
										
									if($jj%10==0 && $jj>0)				
									{
										$processed = $this->process_xml_array_data($info,$posted['i_store_id']);
									}
									$jj++;
									
								}
							}
							
						}
					}
					if($posted['h_import_type']=='xml_link')
					{
						$url = $posted["file_path"];
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents		
						$data = curl_exec($ch); // execute curl request
						curl_close($ch);
						$xml_data = simplexml_load_string($data); // data object
						//$json = json_decode(json_encode($xml_data),TRUE);
						
						if(!empty($xml_data))
						{
							//$tot_rec = $xml_data->attributes["TotalRecordsAvailable"];
							$prod_arr = $xml_data->channel->item;
							$merchant = (string)$xml_data->channel->title;
							if(!empty($prod_arr))
							{
								$jj = 1;  // array index of $info
								foreach($prod_arr as $key=>$val)
								{
									
									$elem_obj = $val;  // object for a single product
									//pr($elem_obj,1);
									$ProductAttr 	= (array)$elem_obj;
									//pr($ProductAttr["@attributes"],1);
									$ProductID 		= (string)$elem_obj->id; 
									$SKU 			= (string)$elem_obj->id;		
														
									$Name 			= (string)$elem_obj->title;
									$Description 	= (string)$elem_obj->description;
									$Description = ""; // did not store for now send blank
									$URL 			= (string)$elem_obj->link;	
									$new_url = '';								
									if (strpos($URL, "vcommission.com")!==false){
										if (strpos($URL, 'MYDEALFOUNDXXX') !== false)
											$new_url = $URL;
										else
											$new_url = str_replace("aff_id=26194","aff_id=26194&aff_sub=MYDEALFOUNDXXX",$URL);
									}
									else {
									   $new_url = $URL;
									}
									$URL			= $new_url;
									
									$Price 			= (string)$elem_obj->price;									
									$Price 			= trim(str_replace('INR','',$Price));
									//$Currency 		= (string)$elem_obj->Currency;
									$MediumImage 	= (string)$elem_obj->image;
									
									$Merchant 		= (string)$elem_obj->Merchant?(string)$elem_obj->Merchant:$merchant;									
									$cat_name 		= (string)$elem_obj->categoryname;
									$catId 			= (string)$elem_obj->categoryid; //this category id in merchant side.
									$cat_path 		= (string)$elem_obj->sociocategory;
									
									//$categoryId 	= $this->product_model_omgp->getCategoryIdForSeperator($cat_path);								
									//$Attributes 	= $elem_obj->Attributes;
									//$attr_arr 		= $Attributes->Attribute;									
									$attributes = array();				
									$attributes["New"] = (string)$elem_obj->new;		
									$attributes["Ranking"] = (string)$elem_obj->ranking;	
									$attr_arr = 	$attributes;
									
									$BrandName = '';									
									$DiscountedPrice = 	(string)$elem_obj->discounted_price;
															
									$discount = ceil(($Price-$DiscountedPrice)/$Price*100);
									$StartDate =  date("Y-m-d H:i:s",time());
									$ExpirationDate =  date("Y-m-d H:i:s",strtotime("+10 years",strtotime($StartDate)));
									
									$seo_url	= getSeoUrl_for_coupon($this->db->COUPON,$Name);
									$storeId	= $this->product_model_omgp->getStoreId($Merchant);
									// now make the product array to be insert
									$info[$jj]	= array(
										"i_cat_id"				=> $categoryId,
										"i_store_id"			=> $storeId,
										"s_product_id"			=> $ProductID,
										"s_sku"					=> $SKU,
										"s_title"				=> $Name,
										"s_summary"				=> $Description,
										"s_url"					=> $URL,
										"d_list_price"			=> $Price,
										"s_image_url"			=> $MediumImage,
										"s_merchant"			=> $Merchant,
										"dt_of_live_coupons"	=> $StartDate,
										"dt_exp_date"			=> $ExpirationDate,
										"dt_date_of_entry"		=> $StartDate,
										"d_selling_price"		=> $DiscountedPrice,
										"d_discount"			=> $discount,
										"s_attributes"			=> json_encode($Attributes),
										"s_seo_url"				=> $seo_url,
										"i_is_active"			=> 1,
										"i_coupon_type"			=> 1,
										"i_is_daily"			=> 1,
										"category_path"			=> $cat_path,
										"s_brand_name"			=> $BrandName
										);
									
									if($jj%10==0 && $jj>0)				
									{
										$processed = $this->process_xml_link_array_data($info,$posted['i_store_id']);
									}
									$jj++;
									
								}
							}
							
						}
					}
					
					redirect(base_url().'admin_panel/manage_product/add_information');
				}
				else
				{
					set_error_msg('Give proper file path');
					//redirect(base_url().'admin_panel/manage_product/add_information');
					$this->data["posted"] = $posted;
				}
            }

            ////////////end Submitted Form///////////

            $this->render("manage_product/add-edit");
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          

    }


	
	function process_xml_link_array_data($data_arr=array(),$storeId=0)
	{		
		if(!empty($data_arr))
		{
			//pr($data_arr);
			//echo count($data_arr);		
			$start_key = $this->session->userdata('unprocessed_key')?$this->session->userdata('unprocessed_key'):1;
			//echo $start_key;
			//pr($data_arr,1);
			for($i=$start_key;$i<count($data_arr); $i++)
			{
				$info = array();				
				$arr = $data_arr[$i];
				
				$categories 				= $arr['category_path'];	
				//$img_url = explode(',',$arr[2]);				
				$info["s_product_id"] 		= $arr['s_product_id'];
				$info["s_sku"] 				= $arr['s_sku'];
				$info["s_title"] 			= $arr['s_title'];
				$info["s_image_url"] 		= $arr['s_image_url'];				
				$info["d_list_price"] 		= $arr['d_list_price'];
				$info["d_selling_price"]	= $arr['d_selling_price'];
				$info["s_summary"] 			= $arr['s_summary'];
				$info["s_url"] 				= $arr['s_url'];
				$info["s_attributes"]		= "";	// left blank			
				$info["i_is_active"] 		= 1;
				$info["i_coupon_type"] 		= 1;
				$info["i_is_daily"] 		= 1;
				$info["i_store_id"] 		= $storeId; 
				$info["s_merchant"] 		= $arr['s_merchant'];
				
				$info["dt_of_live_coupons"]	= $arr['dt_of_live_coupons'];
				$info["dt_exp_date"] 		= $arr['dt_exp_date'];
				$info["dt_date_of_entry"]	= $arr['dt_date_of_entry'];				
				//$seo_url	= getSeoUrl_for_coupon($this->db->COUPON,$info["s_title"]);				
				$info["s_seo_url"]			= $arr['s_seo_url'];				
				//$discount = ceil(($info["d_list_price"]-$info["d_selling_price"])/$info["d_list_price"]*100);
				$info["d_discount"]			= $arr['d_discount'];
				$info["s_brand_name"]		= $arr['s_brand_name'];
				
				
				// first check for category store skip table
				$condition = " WHERE s_store_category ='".my_receive_text($categories)."' AND i_store_id='".$storeId."' ";
				$chk_cat_skip =  $this->product_model_omgp->fetch_category_skip($condition,0,1);
				
				if(empty($chk_cat_skip))
				{
					// check category record here
					$condition = " WHERE s_store_category ='".my_receive_text($categories)."' AND i_store_id='".$storeId."' ";
					$chk_cat =  $this->product_model_omgp->fetch_category_map($condition,0,1);
					//pr($chk_cat,1);
					if(!empty($chk_cat))
					{
						$info["i_cat_id"] 		= $chk_cat[0]["i_original_cat_id"];
						/*if($info["d_list_price"]!=$info["d_selling_price"])
						{*/
							$inserted_rec	= $this->product_model_omgp->add_jabong_product($info);
							//pr($info,1);
							$this->session->unset_userdata('unprocessed_key');
							$this->session->unset_userdata('category_not_found');
						/*}*/
					}
					else
					{					
						// halt the process here					
						$msg = $categories;
						if($msg)
							set_error_msg($msg.' Category Does not Found.');
						$this->session->set_userdata('unprocessed_key',$i);
						$this->session->set_userdata('category_not_found',$categories);
						redirect(base_url().'admin_panel/manage_product/add_information');
						
					}
					
				}  // if check category skip
				
			}
			
			//echo $this->session->userdata('unprocessed_key'); exit;
			
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
    {}

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
	
	
	
	/* new category add */
	public function add_new_category()   
    {
		try
        {

          	$this->data['title']				= "Manage Product";////Browser Title
            $this->data['heading']				= "Manage Product ";
            $this->data['pathtoclass']			= $this->pathtoclass;
            $this->data['mode']					= "add";
			$this->load->model('category_model');
			
			if($_POST)
        	{
				$posted["i_parent_id"] = $this->input->post('i_parent_id');
				$posted["s_category"]  = trim($this->input->post('s_category'));
				
				$this->form_validation->set_rules('s_category','Category Name','required');
				if($this->form_validation->run() == FALSE)	
				{		
					$this->data['posted'] = $posted;	
				}
				else
				{
					$category_url	= getSeoUrl($this->db->CATEGORY,$this->input->post("s_category"));	
					$info	= array(			
								"s_category"	=> $posted["s_category"],
								"i_parent_id"	=> decrypt($posted["i_parent_id"]),
								"i_status"		=> 1,
								"s_thumb"		=> "no-image.png",
								"e_show_in_frontend"	=> '1',
								"s_url"			=> $category_url
								);
					
					$inserted_id	= $this->category_model->add_info($info);
					if($inserted_id)////saved successfully
					{
						set_success_msg($this->cls_msg["save_succ"]);
						redirect($this->pathtoclass."add_information");
					}
				}
			}

            ////////////end Submitted Form///////////

            $this->render("manage_product/add-edit");
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          

    }
	
	/* insert into category_store_map */
	public function ajax_category_store_map()
    {
        try
        {
            $posted=array();
            $posted["catId"]	= decrypt(trim($this->input->post("catId")));
			$posted["catStr"]	= $this->input->post("catStr");
			$posted["storeId"]	= trim($this->input->post("storeId"));
			
            if($posted["catId"]!="")
            {
                $arr_info = array();
				$arr_info["s_store_category"] 	= $posted["catStr"];
				$arr_info["i_original_cat_id"]	= $posted["catId"];
				$arr_info["i_store_id"] 		= $posted["storeId"];
				//pr($arr_info,1);
                $i_add = $this->product_model_omgp->add_category_store_map($arr_info); /*don't change*/

                if($i_add)/////Duplicate eists
                {
                    echo json_encode(array("msg"=>"valid"));
                }
                else
                {
                    echo json_encode(array("msg"=>"not valid"));
                }
                unset($qry,$info);
            }   
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
    {}	

	public function show_list($order_name='',$order_by='desc',$start=NULL,$limit=NULL)
	{
		try
        {     
			redirect($this->pathtoclass.'add_information'); // for now      

			$this->data['heading']="Manage Product";////Package Name[@package] Panel Heading
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_coupon=($this->input->post("h_search")?$this->input->post("s_coupon"):$this->session->userdata("s_coupon")); 
			$s_is_active=($this->input->post("h_search")?$this->input->post("s_is_active"):$this->session->userdata("s_is_active")); 

			$s_category=($this->input->post("h_search")?$this->input->post("s_category"):$this->session->userdata("s_category"));
			$s_store=($this->input->post("h_search")?$this->input->post("s_store"):$this->session->userdata("s_store"));
			$txt_expiry_dt=($this->input->post("h_search")?$this->input->post("txt_expiry_dt"):$this->session->userdata("txt_expiry_dt"));
            ////////end Getting Posted or session values for search///

			 $s_where=" WHERE CONCAT(DATE(dt_exp_date),' 23:59:59')>=now() AND i_coupon_type=2 ";
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
			$info	= $this->product_model_omgp->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			//print_r ($info);
            /////////Creating List view for displaying/////////
			$table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 

            //////Table Headers, with width,alignment///////
            $table_view["caption"]     		=	"Product";
            $table_view["total_rows"]		=	count($info);
			$table_view["total_db_records"]	=	$this->product_model_omgp->gettotal_info($s_where);
			$table_view["order_name"]		=	$order_name;
			$table_view["order_by"]  		=	$order_by;
            $table_view["src_action"]		= 	$this->pathtoclass.$this->router->fetch_method(); 
           // $table_view["detail_view"]		=   FALSE; 
            $table_view["headers"][0]["width"]	="20%";
            $table_view["headers"][0]["align"]	="left";

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
				$i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_title"];
				$table_view["tablerows"][$i][$i_col++]	= '<a href="'.make_valid_url($info[$i]["s_url"]).'" target="_blank">'.string_part($info[$i]["s_url"],30).'</a>';
				$table_view["tablerows"][$i][$i_col++]	= $store_name;
				$table_view["tablerows"][$i][$i_col++]	= $cat_name;	
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
	
	
	/* fetch store details */
	public function ajax_fetch_store_detail()
    {
        try
        {
            $info = array();
			$posted=array();
			$posted["StoreId"]	= $this->input->post("StoreId");
			
            if($posted["StoreId"]!="")
            {
                $info = $this->product_model_omgp->fetch_store_detail($posted["StoreId"]);
                echo json_encode($info[0]);
            }   
			else
			{
                echo json_encode($info);				
			}
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         

    }
	
	/* insert into category_store_skip */
	public function ajax_category_store_skip()
    {
        try
        {
            $posted=array();
            //$posted["catId"]	= decrypt(trim($this->input->post("catId")));
			$posted["catStr"]	= $this->input->post("catStr");
			$posted["storeId"]	= trim($this->input->post("storeId"));
			
            if($posted["catStr"]!="")
            {
                $arr_info = array();
				$arr_info["s_store_category"] 	= $posted["catStr"];
				//$arr_info["i_original_cat_id"]	= $posted["catId"];
				$arr_info["i_store_id"] 		= $posted["storeId"];
				//pr($arr_info,1);
                $i_add = $this->product_model_omgp->add_category_store_skip($arr_info); /*don't change*/

                if($i_add)/////Duplicate eists
                {
                    echo json_encode(array("msg"=>"valid"));
                }
                else
                {
                    echo json_encode(array("msg"=>"not valid"));
                }
                unset($qry,$info);
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
