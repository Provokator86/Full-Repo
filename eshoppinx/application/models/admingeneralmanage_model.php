<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admingeneralmanage_model extends MY_Model 
{

   function __construct()
   {
        parent::__construct();
       $this->load->database();
   }
   function getAdminGeneralManageDetails($paraArr=array(),$tableName)
   {
  // 	print_r($paraArr); die;
   		return $this->selectRecordsFromTableNew($tableName,$paraArr);
   }
   
   function commonActiveInactive($tableName,$fieldName,$userList,$updateValues)
	{
		return $this->doActiveInactive($tableName,$fieldName,$userList,$updateValues);
	}
	
	function CommonGeneralDelete($tableName,$fieldName='',$whereCondition=array())
	{
		return $this->deleteRecords($tableName,$fieldName,$whereCondition);
	}
	
	function insertEditValues($getAddEditDetails,$tableName,$saveMode,$editDetailsId,$fieldName)
	{
		return $this->commonInsertEdit($getAddEditDetails,$tableName,$saveMode,$editDetailsId,$fieldName);
	}
	
	function getDataAvailability($tableName,$checkFieldName,$value,$whereFieldName,$editDetailsId)
	{
	
		return $this->commonDuplicateCheck($tableName,$checkFieldName,$value,$whereFieldName,$editDetailsId);
	}
	function get_sku_code($q){
		$this->db->select('studio_location,studio_id');
		$this->db->like('studio_location', $q);
		$query = $this->db->get('vfx_studio');
		$autocomplete = $query->result_array();
		return $autocomplete; 
	}
	function getLastInserted() {
        return $this->db->insert_id();
    }
	
	function getJobDetails($q){
		$this->db->select('*');
		$this->db->where('jobs_id', $q); 
		$query = $this->db->get('vfx_jobs');
		$getJobDetails = $query->result_array();
		return $getJobDetails; 
	}
	//////////Delte Job Department ////////////
	
	function delJobDepartment($job_id){
      $query = $this->db->where('job_id', $job_id);
      $query = $this->db->delete('vfx_job_department');
	 return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	//////////Insert Job Department ////////////
	function insertJobDepartment($jobId='',$depart_id=''){
		for($i=0;$i<sizeof($depart_id);$i++)
		{
			$insertJobDeptDetails = array('job_id'=>$jobId,'depart_id'=>$depart_id[$i]);
			//print_r($insertJobDeptDetails);
			$this->db->insert('vfx_job_department', $insertJobDeptDetails);
		}
		 return 1;
	}
	
	//////////Insert Job Software ////////////
	function insertJobSoftware($jobId=''){
	    $soft_id = $this->input->post('jobs_specialisation');
		for($i=0;$i<sizeof($soft_id);$i++)
		{
			$insertJobSoftDetails = array('job_id'=>$jobId,'special_id'=>$soft_id[$i]);
			//print_r($insertJobSoftDetails); die;
			$this->db->insert('vfx_job_software', $insertJobSoftDetails);
		}
		 return 1;
	}
	
	//////////Delete Job Software ////////////
	function delJobSoftware($job_id)
	{
		  $query = $this->db->where('job_id', $job_id);
		  $query = $this->db->delete('vfx_job_software');
		  return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

	function getlocationId(){
		$this->db->select('*');
		$this->db->where('studio_location', $this->input->post('jobs_location')); 
		$query = $this->db->get('vfx_studio');
		$getlocationId = $query->row_array();
		return $getlocationId; 
		
	}
	function getOtherDetails($getViewDetails)
	{
		//$this->db->select(LANGUAGE.'.language_id,'.LANGUAGE.'.language_name,count(language_name) AS languageCounts');
		$this->db->select(JOB.'.jobs_employer,'.STUDIO.'.studio_location,'.WORK.'.work_name');
		$this->db->join(STUDIO, JOB.'.jobs_location='.STUDIO.'.studio_id');
		$this->db->join(WORK, JOB.'.jobs_worktype='.WORK.'.work_id');
		$this->db->where(JOB.'.jobs_id',$getViewDetails[0]['jobs_id']); 
		$query = $this->db->get(JOB);
		$getJobDetails = $query->result_array();
		return $getJobDetails; 
		
	}
	function getdocumentName($engName){
		$this->db->select('contact_uploadfile');
		$this->db->where('contact_uploadfile_encryptname',$engName); 
		$query = $this->db->get(CONTACT);
		$getlocationId = $query->row_array();
		return $getlocationId; 
		 
	}
	function getNewsDetail($newsId){
		$this->db->select('*');
		$this->db->where('news_id',$newsId); 
		$query = $this->db->get(NEWS);
		$getNews = $query->row_array();
		return $getNews; 
		
	}
		function editjobDetails($getJobId='')
	{
		//$this->db->select(LANGUAGE.'.language_id,'.LANGUAGE.'.language_name,count(language_name) AS languageCounts');
		//echo '<pre>';
		$this->db->select(JOB.'.*,'.STUDIO.'.studio_location');
		$this->db->from(STUDIO);
		$this->db->join(JOB,JOB.'.jobs_location='.STUDIO.'.studio_id');
		$this->db->where(JOB.'.jobs_id',$getJobId); 
		$query = $this->db->get();
		$getJobDetails = $query->result_array();
		return $getJobDetails; 
		
	}
	
	function getUserProductList($productType='')
	{
		$this->db->select(PAYMENTS.'.id as paymentId,'.PAYMENTS.'.created as paymentDate,'.PAYMENTS.'.dealCodeNumber,'.PAYMENTS.'.total,'.PAYMENTS.'.shipping_status as shippingStatus,'.CUSTOMERS.'.emailAddress,'.CUSTOMERS.'.id as customerId');
		$this->db->from(PAYMENTS);
		$this->db->join(PRODUCTS,PRODUCTS.'.id='.PAYMENTS.'.product_id','INNER');
		
		$this->db->join(CUSTOMERS,CUSTOMERS.'.id='.PAYMENTS.'.user_id','INNER');
		
		
	
		/* get Awaiting payment status orders only start*/
		
		if($productType == 'awaitPayment')
		{
			$this->db->where(PAYMENTS.'.status','Pending');
		}
		/* get Awaiting payment status orders only end*/
		
		/* get Awaiting shipment status orders only start*/
		
		if($productType == 'awaitShipment')
		{
		
			$this->db->where(PAYMENTS.'.status','paid');
			$this->db->where(PAYMENTS.'.shipping_status','Shipment');
		}
		/* get Awaiting shipment status orders only end*/
		
		/* get Cancelled payment status orders only start*/
		
		if($productType == 'cancelPayment')
		{
			$this->db->where(PAYMENTS.'.shipping_status','Cancelled');
		}
		/* get Cancelled payment status orders only end*/
		
		/* get view shipments status orders only start*/
		
		if($productType == 'shippedOrders')
		{
			$this->db->where(PAYMENTS.'.shipping_status','Shipped');
		}
		/* get view shipments status orders only end*/
		
		
		
		$this->db->group_by(PAYMENTS.'.dealCodeNumber');
		
		$query = $this->db->get();
		$getOrderResult = $query->result_array();
		//echo count($getOrderResult)."<br>"; 
		return $getOrderResult; 
	}
	
	function updateOrderStatus()
	{
		$selectedStatus = $this->input->post('selectedStatus');
		$dealCodeNumber = $this->input->post('dealCodeNumber');
		 
		
		
		$statusUpdteData = array('shipping_status' => $selectedStatus);
		
		 
		$this->db->where('dealCodeNumber', $dealCodeNumber);
		$this->db->update(PAYMENTS, $statusUpdteData); 
		return 1;
		
	}
	
	function orderManageExcelExport()
	{	
		$this->db->select(PAYMENTS.'.*,'.CUSTOMERS.'.fname,lname,emailAddress,address,phoneNo,'.PRODUCTS.'.product_name as productName,'.PAYMENTS.'.status as paymentStatus');
		$this->db->from(PAYMENTS);
		$this->db->join(PRODUCTS,PRODUCTS.'.id='.PAYMENTS.'.product_id');		
		$this->db->join(CUSTOMERS,CUSTOMERS.'.id='.PAYMENTS.'.user_id');
		$this->db->where(PAYMENTS.'.status','Paid');
		$this->db->order_by(PAYMENTS.'.id','desc');
		$paymentQuery = $this->db->get();
		$paymentResult = $paymentQuery->result_array();	
		return $paymentResult;		
	}
	
	function insertEditSliderValues()
	{
	
		$linkName = strtolower(trim(addslashes(htmlentities($this->input->post('slider_name')))));
		$linkName = preg_replace("/[^a-z0-9_\s-]/", "", $linkName);
		$linkName = preg_replace("/[\s-]+/", " ", $linkName);
		$linkName = preg_replace("/[\s_]/", "-", $linkName);
		$sliderAddEditVal = array('slider_name' => trim(addslashes(htmlentities($this->input->post('slider_name')))),
								'slider_text' => trim(addslashes(htmlentities($this->input->post('slider_text')))),
								'seourl'=>$linkName
								);					
								
		$sliderFileDetails = $this->session->userdata('brand_sliderFileDetails');		 
		if(!empty($sliderFileDetails))
		{
			$sliderDet = array('slider_orig_name' => $sliderFileDetails[0]['orig_name'],
						      'slider_encrypt_name' => $sliderFileDetails[0]['file_name']
							 );
							 
							 
			$sliderAddEditVal = array_merge($sliderAddEditVal,$sliderDet);			
						
		}
		
		$sliderEditNo = $this->input->post('sliderEditNo');//die;
		
		if($sliderEditNo == '')
		{
			 
			$this->db->insert(SLIDER,$sliderAddEditVal);			
			return 1;
		}
		else
		{
			//edit slider values
		//	echo "<pre>";print_r($sliderAddEditVal);die;
			$this->db->where('id', $sliderEditNo);
			$this->db->update(SLIDER, $sliderAddEditVal); 
			return 1;
			
		}
		
	}
	
	function getSingleSliderVals($sliderVal = '')
	{
			$this->db->select('*');
			$this->db->from(SLIDER);
			if($sliderVal != '')
			{
				$this->db->where(SLIDER.'.id',$sliderVal);
			}
			else
			{
				$this->db->where(SLIDER.'.id',0);
			}
			$sliderQuery = $this->db->get();
			return $sliderResult = $sliderQuery->row_array();
			
	}
	
	function insertEditCategoryValues()
	{
	
		$linkName = strtolower(trim(addslashes(htmlentities($this->input->post('cat_name')))));
		$linkName = preg_replace("/[^a-z0-9_\s-]/", "", $linkName);
		$linkName = preg_replace("/[\s-]+/", " ", $linkName);
		$linkName = preg_replace("/[\s_]/", "-", $linkName);
		
	
		$categoryAddEditVal = array('cat_name' => trim(addslashes(htmlentities($this->input->post('cat_name')))),
								'description' => trim(addslashes(htmlentities($this->input->post('description')))),
								'seourl'=>$linkName,
								'seo_title' => trim(addslashes(htmlentities($this->input->post('seo_title')))),
								'seo_keyword' => trim(addslashes(htmlentities($this->input->post('seo_keyword')))),
								'seo_description' => trim(addslashes(htmlentities($this->input->post('seo_description'))))
								);
								
								
		$category_FileDetails = $this->session->userdata('category_FileDetails');
		
		if(!empty($category_FileDetails))
		{
			$brandDet = array('category_image_ori' => $category_FileDetails[0]['orig_name'],
						      'category_image_encrypt' => $category_FileDetails[0]['file_name']
							 );
							 
							 
			$categoryAddEditVal = array_merge($categoryAddEditVal,$brandDet);			
						
		}
		//echo "<pre>";print_r($categoryAddEditVal);die;
		
		$categoryEdiVal = $this->input->post('categoryEdiVal');//die;
		//echo $categoryEdiVal;die;
		if($categoryEdiVal == '')
		{
			//insert slider values
			$this->db->insert(CATEGORIES,$categoryAddEditVal);			
			return 1;
		}
		else
		{
			//edit slider values
			//echo "<pre>";print_r($categoryAddEditVal);die;
			$this->db->where('id', $categoryEdiVal);
			$this->db->update(CATEGORIES, $categoryAddEditVal); 
			return 1;
			
		}
		
	}
	
	function getSingleCategoryVals($categoryVal = '')
	{
	//echo $categoryVal;die;
			$this->db->select('*');
			$this->db->from(CATEGORIES);
			if($categoryVal != '')
			{
				$this->db->where(CATEGORIES.'.id',$categoryVal);
			}
			else
			{
				$this->db->where(CATEGORIES.'.id',0);
			}
			$sliderQuery = $this->db->get();
			$sliderResult = $sliderQuery->row_array();			
			return $sliderResult;
			
	}
	
	function getSingleModelVals($modelVal = '')
	{
			$this->db->select('*');
			$this->db->from(BRAND_MODEL);
			if($modelVal != '')
			{
				$this->db->where(BRAND_MODEL.'.id',$modelVal);
			}
			else
			{
				$this->db->where(BRAND_MODEL.'.id',0);
			}
			$mdodelQuery = $this->db->get();
			return $modelResult = $mdodelQuery->row_array();
			
	}
	
	function insertEditModelValues()
	{
	
		$linkName = strtolower(trim(addslashes(htmlentities($this->input->post('model_name')))));
		$linkName = preg_replace("/[^a-z0-9_\s-]/", "", $linkName);
		$linkName = preg_replace("/[\s-]+/", " ", $linkName);
		$linkName = preg_replace("/[\s_]/", "-", $linkName);
		
	
		$modelAddEditVal = array('model_name' => trim(addslashes(htmlentities($this->input->post('model_name')))),
								'description' => trim(addslashes(htmlentities($this->input->post('description')))),
								'seourl'=>$linkName,
								'seo_title' => trim(addslashes(htmlentities($this->input->post('seo_title')))),
								'seo_keyword' => trim(addslashes(htmlentities($this->input->post('seo_keyword')))),
								'seo_description' => trim(addslashes(htmlentities($this->input->post('seo_description'))))
								);
								
								
		$modelFileDetails = $this->session->userdata('model_FileDetails');
		
		
		if(!empty($modelFileDetails))
		{
			$modelDet = array('model_orig_name' => $modelFileDetails[0]['orig_name'],
						      'model_encrypt_name' => $modelFileDetails[0]['file_name']
							 );
							 
							 
			$modelAddEditVal = array_merge($modelAddEditVal,$modelDet);			
				//echo "<pre>";print_r($modelFileDetails);die;		
		}
		
		$modelEdiVal = $this->input->post('modelEdiVal');//die;
		
		if($modelEdiVal == '')
		{
			$this->db->insert(BRAND_MODEL,$modelAddEditVal);			
			return 1;
		}
		else
		{
			$this->db->where('id', $modelEdiVal);
			$this->db->update(BRAND_MODEL, $modelAddEditVal); 
			return 1;
		}
		
	}
	
	
	function insertEditProductValues()
	{	
	
		$productEdiVal = $this->input->post('productEdiVal');
		
		if($this->input->post('product_discount') != '')
		{
			$productDiscountAmount = ($this->input->post('initial_amount'))*($this->input->post('product_discount')/100);
			$productNetAmount = $this->input->post('initial_amount') - $productDiscountAmount;
		}
		else
		{
			$productNetAmount = $this->input->post('initial_amount');
		}
		
		
		$linkName = strtolower(trim(addslashes(htmlentities($this->input->post('product_name')))));
		$linkName = preg_replace("/[^a-z0-9_\s-]/", "", $linkName);
		$linkName = preg_replace("/[\s-]+/", " ", $linkName);
		$linkName = preg_replace("/[\s_]/", "-", $linkName);
		
	
		$productAddEditVal = array('product_category' => trim(addslashes(htmlentities($this->input->post('product_category')))),								
								'product_name' => trim(addslashes(htmlentities($this->input->post('product_name')))),
								'description' => trim(addslashes(htmlentities($this->input->post('description')))),								 						
								'initial_amount' => trim(addslashes(htmlentities($this->input->post('initial_amount')))),
								'product_discount' => trim(addslashes(htmlentities($this->input->post('product_discount')))),
								'net_amount' => $productNetAmount,
								'price_per_letter' => trim(addslashes(htmlentities($this->input->post('price_per_letter')))),
								'seourl'=>$linkName,
								'seo_title' => trim(addslashes(htmlentities($this->input->post('seo_title')))),
								'seo_keyword' => trim(addslashes(htmlentities($this->input->post('seo_keyword')))),
								'seo_description' => trim(addslashes(htmlentities($this->input->post('seo_description'))))
								);
			
								
		 $productFileDetails = $this->session->userdata('product_ImageName_orig_name');
		
		if($productEdiVal == '')
		{
			$this->db->insert(PRODUCTS,$productAddEditVal);	
			$lastPRoductId = $this->db->insert_id();		
		}
		else
		{
		//echo "here1";die;
			$this->db->where('id', $productEdiVal);
			$this->db->update(PRODUCTS, $productAddEditVal);
			
			$lastPRoductId =  $productEdiVal;
			
		}
		
		$logoDirectory = $this->config->item('product_path');
			if(!is_dir($logoDirectory))
			{
				mkdir($logoDirectory,0777); 
			}
			//$config['overwrite'] = FALSE;
			$config['remove_spaces'] = FALSE;
			$config['upload_path'] = $logoDirectory;
			$config['allowed_types'] = $this->config->item('product_path_allowedtypes');
			
			$this->upload->initialize($config);
			$this->load->library('upload', $config);
			
			 $file_element_name = 'productImage';
			 $ImageName_orig_name ='';
			$ImageName_encrypt_name ='';
			
		$file_element_name = 'productImage';
		
		$filePRoductUploadData = array();
		$setPriority = 0;
		$imgtitle = $this->input->post('imgtitle');
		
		 if ( $this->upload->do_multi_upload('productImage'))
		 {
			
			
			}
			
			$logoDetails = $this->upload->get_multi_upload_data();
				
		foreach($logoDetails as $fileVal)
		{
			if (!$this->upload->do_upload($file_element_name[$setPriority]))
			{
			
				$error = array('error' => $this->upload->display_errors());
			}
			else
			{
				$sliderUploadedData = array($this->upload->data());
				
				
				
			}
			 $imagePriority = $this->input->post('imgPriority');			
			$filePRoductUploadData = array('product_id'=>$lastPRoductId,'prod_image_title'=>$imgtitle[$setPriority],'prod_image_enc_nam'=>$fileVal['file_name'],'prod_image_priority'=>$imagePriority[$setPriority]);
				
			$this->db->insert(PRODUCTIMAGES,$filePRoductUploadData);					
			$setPriority = $setPriority + 1;
		}
		
		$attribute_id_list = $this->input->post('attribute_id');
		$attribute_value_list = $this->input->post('attribute_value');
		$attribute_price_list = $this->input->post('attribute_price');
		$attribute_quantity_list = $this->input->post('attribute_quantity');		
		$atttribute_id_count = 0;
		
		foreach($attribute_id_list as $attributeIds)
		{
			$attribute_id = $attribute_id_list[$atttribute_id_count];
			$attribute_value = $attribute_value_list[$atttribute_id_count];
			$attribute_price = $attribute_price_list[$atttribute_id_count];
			$attribute_quantity = $attribute_quantity_list[$atttribute_id_count];
			
			if($attribute_value != '')
			{
				$productAttributeListVals = array('product_id'=>$lastPRoductId,'attribute_id'=>$attribute_id,'attribute_value'=>$attribute_value,'attribute_price'=>$attribute_price,'attribute_quantity'=>$attribute_quantity);
			
			$this->db->insert(PRODUCT_ATTRIBUTES,$productAttributeListVals);	
			}			 
			$atttribute_id_count = $atttribute_id_count+1;
		}
		
		return 1;
		
		
	}
	
	function getCommonDetails($brandTableName='',$whereField='',$whereVal='',$soryKey='',$sortVal='')
	{
		$this->db->select('*');
		$this->db->from($brandTableName);
		$this->db->where($brandTableName.'.'.$whereField,$whereVal);
		$this->db->order_by($soryKey,$sortVal);
		$commonQuery = $this->db->get();
		//echo $this->db->last_query();die;
		return $commonQuery->result_array();
		
	}
	
	function productDuplicateCheck($editDetailsId='')
	{
		$this->db->select('id');
		$this->db->from(PRODUCTS);
		$this->db->where('product_name',trim(addslashes($this->input->post('product_name'))));
		$this->db->where('product_category',trim(addslashes($this->input->post('product_category'))));
		 
		if($editDetailsId != '')
		{
			$this->db->where('id'.' !=',$editDetailsId);
		}
		$duplicateQuery = $this->db->get();
		//echo $this->db->last_query();die;
		return $duplicateResult = $duplicateQuery->num_rows();
	}
	
	function getSingleProductVals($productId = '')
	{
			$this->db->select('*');
			$this->db->from(PRODUCTS);
			if($productId != '')
			{
				$this->db->where(PRODUCTS.'.id',$productId);
			}
			else
			{
				$this->db->where(PRODUCTS.'.id',0);
			}
			$productQuery = $this->db->get();
			return $productResult = $productQuery->row_array();
			
	}
	
	function removeProductImage($imageName='')
	{
		$prod_image_id = $this->input->post('prod_image_id');
		
		 $this->db->delete(PRODUCTIMAGES, array('prod_image_id' => $prod_image_id)); 
		return 1;		
	}

	function getProductDetails($dealCodeNumber='')
	{
		$this->db->select('*');
		$this->db->from(PAYMENTS);
		$this->db->join(PRODUCTS,PRODUCTS.'.id='.PAYMENTS.'.product_id');
		
		$this->db->join(CUSTOMERS,CUSTOMERS.'.id='.PAYMENTS.'.user_id');
		
		$this->db->where(PAYMENTS.'.dealCodeNumber',$dealCodeNumber);
		 
		
		$this->db->group_by(PAYMENTS.'.dealCodeNumber');
		
		$query = $this->db->get();
		$getOrderResult = $query->result_array();
		//echo "<pre>";print_r($getOrderResult);die;
		//echo count($getOrderResult)."<br>"; 
		return $getOrderResult; 
	}	
	
	function getProdCustomerDetails($customerId = '')
	{
		$this->db->select('*');
		$this->db->from(CUSTOMERS);
		$this->db->where('id',$customerId);
		$prodCustQuery = $this->db->get();
		$prodCustresult = $prodCustQuery->row_array();
		return $prodCustresult;
		
	}
	
	
	
	function updateImageProduct($prod_image_priority='')
	{
		$productId = $this->input->post('productId');
		$updateVal = $this->input->post('updateVal');
		$captionName = $this->input->post('captionName');
		
		$prod_image_id = $this->input->post('prod_image_id');
		
		$updateCaptionName = array('prod_image_title'=>$captionName);
		//echo $prod_image_priority;die;
		
		$this->db->where('prod_image_id',$prod_image_id);
		$this->db->update(PRODUCTIMAGES, $updateCaptionName); 
		
		
		
		
		
		$updateCurrentRow = array('prod_image_priority'=>$updateVal);
		
		$this->db->where('prod_image_id',$prod_image_id);
		
		
		$this->db->update(PRODUCTIMAGES,$updateCurrentRow);
		
		
		
		return 1;
		
	
	}
	
	function getSingleCouponDetials($couponId = '')
	{
			$this->db->select('*');
			$this->db->from(COUPONS);
			if($couponId != '')
			{
				$this->db->where(COUPONS.'.id',$couponId);
			}
			else
			{
				$this->db->where(COUPONS.'.id',0);
			}
			$couponQuery = $this->db->get();
			return $couponResult = $couponQuery->row_array();
			
	}
	
	function getCategoryList()
	{
		$this->db->select('*');
		$this->db->from(CATEGORIES);
		$this->db->where(CATEGORIES.'.status','active');
		$this->db->group_by(CATEGORIES.'.cat_name');
		$this->db->order_by('cat_name','asc');
		$couponQuery = $this->db->get();
		return $couponResult = $couponQuery->result_array();
	}
	
	function getProductList()
	{
		$this->db->select('*');
		$this->db->from(PRODUCTS);
		
		$this->db->where(PRODUCTS.'.status','active');
 		$this->db->order_by('product_name','asc');
		$productQuery = $this->db->get();
		return $productResult = $productQuery->result_array();
	}
	
	function insertEditCouponVals($insertVals=array(),$couponEdiVal='')
	{
		if($couponEdiVal != '')
		{
			$this->db->where('id',$couponEdiVal);
			$this->db->update(COUPONS,$insertVals);
		}	
		else
		{
			$this->db->insert(COUPONS,$insertVals);
		}
		return 1;
	}
	
	function getCouponProductData($category_id='')
	{
		$this->db->select('product_id');
		$this->db->from(COUPONS);		
		$this->db->where(COUPONS.'.category_id',$category_id);
 		$productQuery = $this->db->get();
		return $productResult = $productQuery->row_array();
	}
	
	function get_existing_prod_selected($editCouponId='',$category_id='')
	{
		$this->db->select('product_id');
		$this->db->from(COUPONS);		
		$this->db->where(COUPONS.'.id',$editCouponId);
		if($category_id != '')
			$this->db->where(COUPONS.'.category_id',$category_id);
 		$productQuery = $this->db->get();
		return $productResult = $productQuery->row_array();
	}
	
	function getPromotionalValues()
	{
		$this->db->select('*');
		$this->db->from(COUPONS);		
		$this->db->where(COUPONS.'.status','active');		 
		$this->db->where(COUPONS.'.code_type','promo');
 		$productQuery = $this->db->get();
		return $productResult = $productQuery->result_array();
	}
	
	function removeProductAttribute($prod_attribute_id='')
	{				 		
		 $this->db->delete(PRODUCT_ATTRIBUTES, array('id' => $prod_attribute_id)); 
		return 1;		
	}
	
	function updateProductAttribute($prod_attribute_id='')
	{
		$productId = $this->input->post('productId');
		
		$updateAttributeName = $this->input->post('updateAttributeName');
		$updateAttrValue = $this->input->post('updateAttrValue');
		$updateAttrPrice = $this->input->post('updateAttrPrice');
		$updateAttrQuantity = $this->input->post('updateAttrQuantity');
		
		$updateProductAttirbts = array('attribute_id'=>$updateAttributeName,'attribute_value'=>$updateAttrValue,'attribute_price'=>$updateAttrPrice,'attribute_quantity'=>$updateAttrQuantity);
		
		$this->db->where('id',$prod_attribute_id);
		$this->db->update(PRODUCT_ATTRIBUTES, $updateProductAttirbts); 
		
		return 1;
		
	
	}
	
	function getSingleAttributeVals($attributeId = '')
	{
	//echo $categoryVal;die;
			$this->db->select('*');
			$this->db->from(ATTRIBUTES);
			if($attributeId != '')
			{
				$this->db->where(ATTRIBUTES.'.id',$attributeId);
			}
			else
			{
				$this->db->where(ATTRIBUTES.'.id',0);
			}
			$sliderQuery = $this->db->get();
			$sliderResult = $sliderQuery->row_array();			
			return $sliderResult;
			
	}
	
	function insertEditAttributeValues($categoryAddEditVal = array())
	{
	
		$linkName = strtolower(trim(addslashes(htmlentities($this->input->post('cat_name')))));
		$linkName = preg_replace("/[^a-z0-9_\s-]/", "", $linkName);
		$linkName = preg_replace("/[\s-]+/", " ", $linkName);
		$linkName = preg_replace("/[\s_]/", "-", $linkName);
		 
		
		
					
		$attributeEditVal = $this->input->post('attributeEditVal');//die;
		//echo $categoryEdiVal;die;
		if($attributeEditVal == '')
		{
			//insert slider values
			$this->db->insert(ATTRIBUTES,$categoryAddEditVal);			
			return 1;
		}
		else
		{
			//edit slider values
			//echo "<pre>";print_r($categoryAddEditVal);die;
			$this->db->where('id', $attributeEditVal);
			$this->db->update(ATTRIBUTES, $categoryAddEditVal); 
			return 1;
			
		}
		
	}
	
}