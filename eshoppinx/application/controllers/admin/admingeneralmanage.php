<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class Admingeneralmanage extends MY_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->library('pagination');
		$this->load->helper('download');
		$this->load->model('admingeneralmanage_model');
		$this->load->library('upload');
		$this->load->helper('download');
		$this->load->helper('xml');
    }
	public function index()
	{
		if($this->checkLogin('A') !='')
		{
			$this->departmentManage();
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Common manage start */
	function adminCommonManagement($typeUser,$paginationNo,$orderName,$orderBy,$tableId,$tableName,$redirectTo,$editId,$getDetails1=array(),$getDetails2=array(),$getDetails3=array(),$getDetails4=array())
	{
		$searchField1 = trim(addslashes(htmlentities($this->input->post('searchField1'))));
		$searchField2 = trim(addslashes(htmlentities($this->input->post('searchField2'))));
		
		if($searchField1 != '' && $searchField2 != '' && $searchField2 != 'Search Text' )
		{
			$this->session->set_userdata($redirectTo.'SearchField1',$searchField1);
			$this->session->set_userdata($redirectTo.'SearchField2',$searchField2);
		}
		
		$searchString1 = $this->session->userdata($redirectTo.'SearchField1');//die;
		$searchString2 = $this->session->userdata($redirectTo.'SearchField2');//die;
		
		$likeQuery = array();
		
		if($searchString1 != '')
		{
			$likeQuery = array($searchString1=>$searchString2);		
		}
		else
		{
			$likeQuery = array();
		}
		
		if($orderBy == 'desc')
		{
			
			$sortArray = array($orderName=>'desc');
		}
		else if($orderBy == 'asc')
		{
			$sortArray = array($orderName=>'asc');
		}
		else
		{
		
			$sortArray = array($tableId=>'desc');
		}
	
	
		/* Where condtion start */
		if($typeUser == 'active')
		{
			$whereCondition = array('status'=>'active'); //Get only active 
		}
		else if($typeUser == 'inactive')
		{
			$whereCondition = array('status'=>'inactive'); //Get only inactive 
		}
		else if($typeUser == 'all')
		{
			$whereCondition = array(); //Get all 
		}
		else
		{
			$whereCondition = array();
		}
		/* where condition end */
		
		/* Common part start */
			if($paginationNo == '')
			{
				$paginationNo = 0;
			}
			else
			{
				$paginationNo = $paginationNo;
			}
			//echo "<pre>";print_r($sortArray);die;
			$seekerArray['selectValues']= '*';
			$seekerArray['whereCondition']= $whereCondition;
			$seekerArray['sortArray']= $sortArray;
			$seekerArray['join']= '';
			$seekerArray['perpage'] = $this->config->item('admin_pagination_per_page');
			$seekerArray['start'] = $paginationNo;
			$seekerArray['likeQuery'] = $likeQuery;
			
			$getAdminGeneralManageDetails = $this->admingeneralmanage_model->getAdminGeneralManageDetails($seekerArray,$tableName);
			//echo "<pre>";print_r($getAdminGeneralManageDetails);die;
			/* get job seekers full details end */
			
			/*get counts for active/inactive/all  start */
			
			/*Get active  count start*/
			$activeWhereCondition = array('status'=>'active');
			$activeCount['selectValues'] = $tableId;
			$activeCount['whereCondition'] = $activeWhereCondition;
			$activeCount['perpage'] ='';
			$activeCount['start'] = '';
			$activeCount['likeQuery'] = $likeQuery;

			$getActiveUserCounts = $this->admingeneralmanage_model->getAdminGeneralManageDetails($activeCount,$tableName);
			/*Get active  count end*/
			
			/*Get inactive  count start*/
			$inActiveWhereCondition = array('status'=>'inactive');
			
			$inactiveCount['selectValues'] = $tableId;
			$inactiveCount['whereCondition'] = $inActiveWhereCondition;
			$inactiveCount['perpage'] = '';
			$inactiveCount['start'] = '';
			$inactiveCount['likeQuery'] = $likeQuery;			
			$getInactiveUserCounts = $this->admingeneralmanage_model->getAdminGeneralManageDetails($inactiveCount,$tableName);
			/*Get inactive  count end*/
			
			/*Get all  count start*/
			$allWhereCondition = array();
			$allCount['selectValues'] = $tableId;
			$allCount['whereCondition'] = $allWhereCondition;
			$allCount['perpage'] = '';
			$allCount['start'] = '';
			$allCount['likeQuery'] = $likeQuery;
			
			$getAllUserCounts = $this->admingeneralmanage_model->getAdminGeneralManageDetails($allCount,$tableName);
			/*Get all  count end*/
	
			/*Get this week  count end*/
			
			/*get counts for active/inactive/all  end */	
			
			
			/* check if type of (active/inactive/all) is empty then assign $type value as all; otherwise assign type values as it is-start */
			if($typeUser == '')
			{
				$typeUser = 'all';
			}
			else
			{
				$typeUser = $typeUser;
			}
			/* check if type of (active/inactive/all) is empty then assign $typeUser value as all ; otherwise assign typeuser values as it is. -end */
			
			
			$seekerArrayPagination['selectValues']= '*';
			$seekerArrayPagination['whereCondition']= $whereCondition;
			$seekerArrayPagination['sortArray']= $sortArray;
			$seekerArrayPagination['join']= '';
			$seekerArrayPagination['perpage'] = '';
			$seekerArrayPagination['start'] = '';
			$seekerArrayPagination['likeQuery'] = $likeQuery;
			
			
			$getSeekerCount = $this->admingeneralmanage_model->getAdminGeneralManageDetails($seekerArrayPagination,$tableName);
		//	$config['base_url'] = base_url().'admin/admingeneralmanage/jobSeekerManagement/'.$typeUser.'/'.$paginationNo.'/'.$orderName.'/'.$orderBy;
			$config['base_url'] = base_url().'admin/admingeneralmanage/'.$redirectTo.'/'.$typeUser;
			$config['total_rows'] = count($getSeekerCount);
			$config["per_page"] = $this->config->item('admin_pagination_per_page');
  			$config["uri_segment"] = 5;
			$this->pagination->initialize($config); 
			$paginationLink = $this->pagination->create_links();
			
			/*get edit details */
			if($editId != '')
			{
				$editWereCondition = array($tableId=>$editId); 
				$editDetails['selectValues']= '*';
				$editDetails['whereCondition']= $editWereCondition;
				$editDetails['sortArray']= array();
				$editDetails['join']= '';
				$editDetails['perpage'] = '';
				$editDetails['start'] = '';
				$editDetails['likeQuery'] = array();
				
				
				$getEditDetails = $this->admingeneralmanage_model->getAdminGeneralManageDetails($editDetails,$tableName);
			}
			else
			{
				$getEditDetails = array();
			}
			
	    if($this->uri->segment(3) == 'adminJobManage' && $editId != '')	
			{
				$getEditDetails = $this->admingeneralmanage_model->editjobDetails($editId);
			}
			
			
			
			
			
			
			
			/*get edit details */
			//echo "<pre>";print_r($getAdminGeneralManageDetails);die;
			$data = array('getAdminGeneralManageDetails'=>$getAdminGeneralManageDetails,
						  'activeUserCounts'=>$getActiveUserCounts,
						  'inactiveUsersCount'=>$getInactiveUserCounts,
						  'allUsersCount'=>$getAllUserCounts,
						  'paginationNo'=>$paginationNo,
						  'typeUser'=>$typeUser,
						  'orderName'=>$orderName,
						  'orderBy'=>$orderBy,
						  'paginationLink'=>$paginationLink,
						  'sessionPrefix'=>$redirectTo,
						  'getEditDetails'=>$getEditDetails,
						  'getDetails1'=>$getDetails1,
						  'getDetails2'=>$getDetails2,
						  'getDetails3'=>$getDetails3,
						  'getDetails4'=>$getDetails4
						  );
		$this->load->view('admin/'.$redirectTo,$data);
			
		/* common part end */
	}
	
	function commonManageActiveInactive($changeMode,$jobSeekerId,$userType,$paginationNo,$fieldName,$redirectTo,$tableName)
	{
	//echo $changeMode."sdfsad</br>";die;
	//echo $tableName."sdfsad</br>";die;
		/* active/inactive/delete for single  start */
			if($changeMode != '' && $jobSeekerId != '') 
			{
				$userList = array($jobSeekerId);
				
				if($changeMode == 'active')
				{
					$value = 'inactive';
				}
				else if($changeMode == 'inactive')
				{
					$value = 'active';
				}
				else
				{
					$value = 'delete';
				}
				
				$updateValues = array('status'=>$value);
				
				if($value != 'delete')
				{
			//print_r($userList);die;
					$commonActiveInactive = $this->admingeneralmanage_model->commonActiveInactive($tableName,$fieldName,$userList,$updateValues);
					//echo $this->db->last_query();die;
					
					$type == 'success';
					$message = ucfirst($value).' Successfully';
					$this->setFlashDataCommon($type,$message);
					
					redirect('admin/admingeneralmanage/'.$redirectTo.'/'.$userType.'/'.$paginationNo);
					
				}
				else
				{
					//delete
					$commonDelete = $this->admingeneralmanage_model->CommonGeneralDelete($tableName,$fieldName,$userList);
					
					$type == 'success';
					$message = 'Deleted Successfully';
					$this->setFlashDataCommon($type,$message);
					
					redirect('admin/admingeneralmanage/'.$redirectTo.'/'.$userType.'/'.$paginationNo);
				}
				
			}
			/* active/inactive/delete for single  end */
			/* active/inactive/delete for multiple  start*/
			else
			{
				$statusMode = $this->input->post('statusMode');
				$seekerCheckbox = $this->input->post('seekerCheckbox');
				//echo $statusMode;
				//echo "<pre>";print_r($seekerCheckbox);die;die;
				if($statusMode == 'active')
				{
					$value = 'active';
				}
				else if($statusMode == 'inactive')
				{
					$value = 'inactive';
				}
				else
				{
					$value = 'delete';
				}
				
				$updateValues = array('status'=>$value);
				$userList = $seekerCheckbox;
				if($value != 'delete')
				{
					$commonActiveInactive = $this->admingeneralmanage_model->commonActiveInactive($tableName,$fieldName,$userList,$updateValues);
					
					$type == 'success';
					$message = ucfirst($value).' Successfully';
					$this->setFlashDataCommon($value,$message);
					
					redirect('admin/admingeneralmanage/'.$redirectTo.'/'.$userType.'/'.$paginationNo);
					
				}
				else
				{
					$commonDelete = $this->admingeneralmanage_model->CommonGeneralDelete($tableName,$fieldName,$userList);
					
					$type == 'success';
					$message = 'Deleted Successfully';
					$this->setFlashDataCommon($type,$message);
					
					redirect('admin/admingeneralmanage/'.$redirectTo.'/'.$userType.'/'.$paginationNo);
				}
			}
			/* active/inactive/delete for multiple  end*/
	}
	
	function commonViewDetails($paraArr,$redirectTo,$tableName)
	{
			/* get single  full details start */
			$paraArr['selectValues'] = '*';
			$join = '';
			$paraArr['perpage'] = '';
			$paraArr['start'] = '';
			
			$getViewDetails = $this->admingeneralmanage_model->getAdminGeneralManageDetails($paraArr,$tableName);
			//print_r($getViewDetails); die;
		     	$data['getViewDetails'] = $getViewDetails;
					
			$this->load->view('admin/'.$redirectTo,$data);
	}
	
	/* Common manage End */
		
	


	
		
  /* Contact Manage start */
	function adminContactManage($typeUser='',$paginationNo='',$orderName='',$orderBy='',$editId='')
	{
		//$editId = $this->uri->segent(5);die;
		if($this->checkLogin('A') !='')
		{
			$this->session->unset_userdata('contactFileDetails');
		
			$tableName = CONTACT;			
			$redirectTo = 'contacts/adminContactManage';	//This redirectTo variable value must be same as this function view file name.(Here view file name is "adminNewsManage"	
			$data = $this->adminCommonManagement($typeUser,$paginationNo,$orderName,$orderBy,'id',$tableName,$redirectTo,$editId); //Call common function name "adminCommonManagement"
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Contact  Active/Inactive/Delete function start*/
	function contactActiveInactiveDeleteFunction($changeMode='',$jobSeekerId='',$userType='',$paginationNo='')
	{
	
		if($this->checkLogin('A') !='')
		{
			$fieldName = 'id';
			$redirectTo = 'adminContactManage';
			$tableName = CONTACT;
			$this->commonManageActiveInactive($changeMode,$jobSeekerId,$userType,$paginationNo,$fieldName,$redirectTo,$tableName);
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Contact  Active/Inactive/Delete function end*/
	/* Contact reset start*/
	function resetContactSearch($sessionPrefixName = '')
	{
		$this->session->unset_userdata($sessionPrefixName.'SearchField1');
		$this->session->unset_userdata($sessionPrefixName.'SearchField2');
		
		redirect('admin/admingeneralmanage/adminContactManage/all');
	}
	/* Contact reset end*/
	/* Contact view start */
	function viewContactDetails($viewId = '')
	{
	
		if($this->checkLogin('A') !='')
		{
			/* get single job seekers full details start */
			$paraArr = array();
			$paraArr['whereCondition'] = array('id'=>$viewId);
			$redirectTo = 'contacts/viewcontactdetails';
			$tableName = CONTACT;

			$callViewDetails = $this->commonViewDetails($paraArr,$redirectTo,$tableName);
			
			/* get single job seekers full details end */
			
			//$data['getSingleJobSeekerDetails'] = $getSingleJobSeekerDetails;
				
			//$this->load->view('admin/viewjobseekerdetails',$data);
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Contact view end */
	
	function contactdocument()
	{
		$encryptfileName = $this->uri->segment(4);
	   
			$getcontactDocument = $this->admingeneralmanage_model->getdocumentName($encryptfileName);
			
		$data = file_get_contents("uploadedfiles/contactdocument/".$encryptfileName); // Read the file's contents
		$name = $getcontactDocument['contact_uploadfile'];
		
		force_download($name, $data);
	}
	////////////////////////IBRAND ///////////////////////////////
		function viewSlider(){
       if($this->checkLogin('A') == '')
		{
                redirect('admin/adminlogin/loginPage');
		}else
		 {
			$paraArr = array();
			$paraArr['whereCondition'] = array('status'=>'Active');
			
			$redirectTo = 'viewSlider';
			$tableName = SLIDER;

			$callViewDetails = $this->commonViewDetails($paraArr,$redirectTo,$tableName);
		 	//print_r($callViewDetails); die;
		 
			//$this->load->view('admin/viewSlider');
		 }

	}
	
	function listOfSliders($typeUser='',$paginationNo='',$orderName='',$orderBy='',$editId='')
	{
		if($this->checkLogin('A') !='')
		{
		
			$tableName = SLIDER;			
			$redirectTo = 'sliders/adminslidermanage';	//This redirectTo variable value must be same as this function view file name.(Here view file name is "adminNewsManage"	
			$data = $this->adminCommonManagement($typeUser,$paginationNo,$orderName,$orderBy,'id',$tableName,$redirectTo,$editId); //Call common function name "adminCommonManagement"
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}

	function sliderAddEdit($sliderId = '')
	{
	   	if($this->checkLogin('A') == '')
		{
			redirect('admin/adminlogin/loginPage');
		}
		else
		 {
		 	$getSingleSliderVals = $this->admingeneralmanage_model->getSingleSliderVals($sliderId);
		 	$data['slider_path'] = $this->config->item('slider_path');
			$data['getSingleSliderVals'] = $getSingleSliderVals;
			$this->load->view('admin/sliders/adminAddSlider',$data);
		 }

	}
	

    /* Silder view add edit function start */
	function sliderAddEditValues()
	{
		//echo "hi";
		if($this->checkLogin('A') !='')
		{
			$this->session->unset_userdata('brand_sliderFileDetails');
			/* slider file upload end */
			$file_element_name = 'sliderImage';
			
			$logoDirectory = $this->config->item('slider_path');
			if(!is_dir($logoDirectory))
			{
				mkdir($logoDirectory,0777); 
			}
			
			$config['upload_path'] = $logoDirectory;
			$config['allowed_types'] = $this->config->item('slider_path_allowedtypes');
			
			$this->upload->initialize($config);
			$this->load->library('upload', $config);
			 
			if (!$this->upload->do_upload($file_element_name))
			{
			
				$error = array('error' => $this->upload->display_errors());
				//echo "<pre>";print_r($error);die;
			}
			else
			{
				$sliderUploadedData = array($this->upload->data());
				//echo "<pre>";print_r($logoUploadedData);die;
				$this->session->set_userdata('brand_sliderFileDetails', $sliderUploadedData);
			}
			
			/* slider file upload end */
			
			 $sliderFileDetails = $this->session->userdata('brand_sliderFileDetails');
			//echo "<pre>";print_r($sliderFileDetails);die;
			$insertEditSliderValues = $this->admingeneralmanage_model->insertEditSliderValues();
			
			$type == 'success';
			$message = 'Slider Saved Successfully';
			$this->setFlashDataCommon($type,$message);
			
			redirect('admin/admingeneralmanage/listOfSliders');
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* slider view add edit function end */
	
	
	
	
	 /* Feedback Manage start */
	function adminFeedbackManage($typeUser='',$paginationNo='',$orderName='',$orderBy='',$editId='')
	{
	
		//$editId = $this->uri->segent(5);die;
		if($this->checkLogin('A') !='')
		{
		
			$tableName = FEEDBACK;			
			$redirectTo = 'feedbacks/adminfeedbackmanage';	//This redirectTo variable value must be same as this function view file name.(Here view file name is "adminNewsManage"	
			$data = $this->adminCommonManagement($typeUser,$paginationNo,$orderName,$orderBy,'id',$tableName,$redirectTo,$editId); //Call common function name "adminCommonManagement"
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Feedback  Active/Inactive/Delete function start*/
	function feedbackActiveInactiveDeleteFunction($changeMode='',$jobSeekerId='',$userType='',$paginationNo='')
	{
	//echo $jobSeekerId;die;
	//echo $changeMode;die;
		if($this->checkLogin('A') !='')
		{
			$fieldName = 'id';
			$redirectTo = 'adminfeedbackmanage';
			$tableName = FEEDBACK;
			$this->commonManageActiveInactive($changeMode,$jobSeekerId,$userType,$paginationNo,$fieldName,$redirectTo,$tableName);
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Feedback  Active/Inactive/Delete function end*/
	
	/* Feedback view start */
	function viewFeedbackDetails($viewId = '')
	{
	
		if($this->checkLogin('A') !='')
		{
			/* get single job seekers full details start */
			$paraArr = array();
			$paraArr['whereCondition'] = array('id'=>$viewId);
			$redirectTo = 'viewfeedbackdetails';
			$tableName = FEEDBACK;

			$callViewDetails = $this->commonViewDetails($paraArr,$redirectTo,$tableName);
			
			/* get single job seekers full details end */
			
			//$data['getSingleJobSeekerDetails'] = $getSingleJobSeekerDetails;
				
			//$this->load->view('admin/viewjobseekerdetails',$data);
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Feedback view end */
	
	
	function userOrders($productType='')
	{ 
		if($this->checkLogin('A') !='')
		{			
			$getUserProductList = $this->admingeneralmanage_model->getUserProductList($productType);			
			$getAwaitPaymentCount =  $this->admingeneralmanage_model->getUserProductList('awaitPayment');			
			$getAwaitShipmentCount =  $this->admingeneralmanage_model->getUserProductList('awaitShipment');
			$getShippedCount =  $this->admingeneralmanage_model->getUserProductList('shippedOrders');
			$getTotalPaymentCount =  $this->admingeneralmanage_model->getUserProductList('totalPayment');
			$data['getUserProductList'] = $getUserProductList;
			$data['getAwaitPaymentCount'] = $getAwaitPaymentCount;
			$data['getAwaitShipmentCount'] = $getAwaitShipmentCount;
			$data['getShippedCount'] = $getShippedCount;
			$data['getTotalPaymentCount'] = $getTotalPaymentCount;			
			$this->load->view('admin/orders/ordermanagement',$data);
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	
	function changeOrderStatusAjax()
	{
		if($this->checkLogin('A') !='')
		{
			$selectedStatus = $this->input->post('selectedStatus');
			$dealCodeNumber = $this->input->post('dealCodeNumber');
			if($selectedStatus!='' && $dealCodeNumber !='')
			{
				$updateOrderStatus = $this->admingeneralmanage_model->updateOrderStatus();
				echo $selectedStatus;
			}
			else
			{
				echo "sorry";
			}
		}
		else
		{
			echo "sorry";
		}
			
		
	}
	
	function orderManageExcelExport() 
	{
	 	$getOrderDetails = $this->admingeneralmanage_model->orderManageExcelExport();		
		$data['getOrderDetails'] = $getOrderDetails;
		$this->load->view('admin/orders/orderExportExcel',$data);		
	}
	
	
	/* Feedback  Active/Inactive/Delete function start*/
	function slidersActiveInactiveDeleteFunction($changeMode='',$jobSeekerId='',$userType='',$paginationNo='')
	{	
		if($this->checkLogin('A') !='')
		{
			$fieldName = 'id';
			$redirectTo = 'listOfSliders';
			$tableName = SLIDER;
			$this->commonManageActiveInactive($changeMode,$jobSeekerId,$userType,$paginationNo,$fieldName,$redirectTo,$tableName);
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Feedback  Active/Inactive/Delete function end*/
	
	
	 /* Category Manage start */
	function adminCategoryManage($typeUser='',$paginationNo='',$orderName='',$orderBy='',$editId='')
	{	
		if($this->checkLogin('A') !='')
		{
		
			$tableName = CATEGORIES;			
			$redirectTo = 'categories/admincategorymanage';	//This redirectTo variable value must be same as this function view file name.(Here view file name is "adminNewsManage"	
			$data = $this->adminCommonManagement($typeUser,$paginationNo,$orderName,$orderBy,'id',$tableName,$redirectTo,$editId); //Call common function name "adminCommonManagement"
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Category  Active/Inactive/Delete function start*/
	function categoryActiveInactiveDeleteFunction($changeMode='',$jobSeekerId='',$userType='',$paginationNo='')
	{	
		if($this->checkLogin('A') !='')
		{
			$fieldName = 'id';
			$redirectTo = 'adminCategoryManage';
			$tableName = CATEGORIES;
			$this->commonManageActiveInactive($changeMode,$jobSeekerId,$userType,$paginationNo,$fieldName,$redirectTo,$tableName);
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Category  Active/Inactive/Delete function end*/
	
	/* Category view start */
	function viewBrandDetails($viewId = '')
	{
	
		if($this->checkLogin('A') !='')
		{
			/* get single job seekers full details start */
			$paraArr = array();
			$paraArr['whereCondition'] = array('id'=>$viewId);
			$redirectTo = 'categories/viewcategorydetails';
			$tableName = CATEGORIES;

			$callViewDetails = $this->commonViewDetails($paraArr,$redirectTo,$tableName);
			
			/* get single job seekers full details end */
			
			//$data['getSingleJobSeekerDetails'] = $getSingleJobSeekerDetails;
				
			//$this->load->view('admin/viewjobseekerdetails',$data);
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Brand view end */
	
	
	
	function categoryAddEdit($categoryId = '')
	{
	
	   	if($this->checkLogin('A') == '')
		{
			redirect('admin/adminlogin/loginPage');
		}
		else
		 {
		
		 	$getSingleCategoryVals = $this->admingeneralmanage_model->getSingleCategoryVals($categoryId);
		 	$data['brand_path'] = $this->config->item('categories_path');
			$data['getSingleCategoryVals'] = $getSingleCategoryVals;
			$this->load->view('admin/categories/adminaddcategory',$data);
		 }

	}
	

    /* Brand view add edit function start */
	function categoryAddEditValues()
	{
	//echo $this->input->post('brandEdiVal');die;
		if($this->checkLogin('A') !='')
		{
		$categoryAddEdit = $this->input->post('categoryAddEdit');
			$this->session->unset_userdata('category_FileDetails');
			/* slider file upload end */
			$file_element_name = 'categoryImage';
			
			$logoDirectory = $this->config->item('categories_path');
			if(!is_dir($logoDirectory))
			{
				mkdir($logoDirectory,0777); 
			}
			
			$config['upload_path'] = $logoDirectory;
			$config['allowed_types'] = $this->config->item('brand_path_allowedtypes');
			
			$this->upload->initialize($config);
			$this->load->library('upload', $config);
			 
			if (!$this->upload->do_upload($file_element_name))
			{
			
				$error = array('error' => $this->upload->display_errors());
				//echo "<pre>";print_r($error);die;
			}
			else
			{
				$categoryUploadedData = array($this->upload->data());
				//echo "<pre>";print_r($categoryUploadedData);die;
				$this->session->set_userdata('category_FileDetails', $categoryUploadedData);
			}
			
			/* slider file upload end */
			
			 $sliderFileDetails = $this->session->userdata('category_FileDetails');
			//echo "<pre>";print_r($sliderFileDetails);die;
			$insertEditSliderValues = $this->admingeneralmanage_model->insertEditCategoryValues();
			
			$type == 'success';
			$message = 'Category Saved Successfully';
			$this->setFlashDataCommon($type,$message);
			
			redirect('admin/admingeneralmanage/adminCategoryManage');
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Brand view add edit function end */
	
	
	
	
	
	 /* Model Manage start */
	function adminModelManage($typeUser='',$paginationNo='',$orderName='',$orderBy='',$editId='')
	{
	
		if($this->checkLogin('A') !='')
		{
		
			$tableName = BRAND_MODEL;			
			$redirectTo = 'prodmodels/adminmodelmanage';	
			$data = $this->adminCommonManagement($typeUser,$paginationNo,$orderName,$orderBy,'id',$tableName,$redirectTo,$editId); 
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Model  Active/Inactive/Delete function start*/
	function modelActiveInactiveDeleteFunction($changeMode='',$jobSeekerId='',$userType='',$paginationNo='')
	{
		if($this->checkLogin('A') !='')
		{
			$fieldName = 'id';
			$redirectTo = 'adminmodelmanage';
			$tableName = BRAND_MODEL;
			$this->commonManageActiveInactive($changeMode,$jobSeekerId,$userType,$paginationNo,$fieldName,$redirectTo,$tableName);
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Model  Active/Inactive/Delete function end*/
	
	/* Model view start */
	function viewModelDetails($viewId = '')
	{
	
		if($this->checkLogin('A') !='')
		{
			/* get single job seekers full details start */
			$paraArr = array();
			$paraArr['whereCondition'] = array('id'=>$viewId);
			$redirectTo = 'viewmodelsdetails';
			$tableName = BRAND_MODEL;

			$callViewDetails = $this->commonViewDetails($paraArr,$redirectTo,$tableName);
			
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Model view end */
	
	function modelAddEdit($modelId = '')
	{
	   	if($this->checkLogin('A') == '')
		{
			redirect('admin/adminlogin/loginPage');
		}
		else
		 {
		
		 	$getSingleModelVals = $this->admingeneralmanage_model->getSingleModelVals($modelId);
		 	$data['model_path'] = $this->config->item('model_path');
			$data['getSingleModelVals'] = $getSingleModelVals;
			$this->load->view('admin/prodmodels/adminaddmodels',$data);
		 }

	}
	

    /* Model view add edit function start */
	function modelAddEditValues()
	{
	//echo $this->input->post('brandEdiVal');die;
		if($this->checkLogin('A') !='')
		{
		$brandEdiVal = $this->input->post('modelEdiVal');
			$this->session->unset_userdata('model_FileDetails');
			/* slider file upload end */
			$file_element_name = 'modelImage';
			
			$logoDirectory = $this->config->item('model_path');
			if(!is_dir($logoDirectory))
			{
				mkdir($logoDirectory,0777); 
			}
			
			$config['upload_path'] = $logoDirectory;
			$config['allowed_types'] = $this->config->item('model_path_allowedtypes');
			
			$this->upload->initialize($config);
			$this->load->library('upload', $config);
			 
			if (!$this->upload->do_upload($file_element_name))
			{
			
				$error = array('error' => $this->upload->display_errors());
				//echo "<pre>";print_r($error);die;
			}
			else
			{
				$modelUploadedData = array($this->upload->data());
				//echo "<pre>";print_r($logoUploadedData);die;
				$this->session->set_userdata('model_FileDetails', $modelUploadedData);
			}
			
			/* slider file upload end */
			
			 $modelFileDetails = $this->session->userdata('model_FileDetails');
			//echo "<pre>";print_r($sliderFileDetails);die;
			$insertEditModelValues = $this->admingeneralmanage_model->insertEditModelValues();
			
			$type == 'success';
			$message = 'Model Saved Successfully';
			$this->setFlashDataCommon($type,$message);
			
			redirect('admin/admingeneralmanage/adminModelManage');
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Model view add edit function end */
	
	/* slider duplicate check start */
	
	
	/*common duplicate check funciton start*/
	function commonDuplicateCheck($tableName,$checkFieldName,$value,$whereFieldName,$editDetailsId)
	{
	
	
		 $getDataAvailability = $this->admingeneralmanage_model->getDataAvailability($tableName,$checkFieldName,$value,$whereFieldName,$editDetailsId);
		//echo $this->db->last_query();die;
		if($getDataAvailability >= 1)
		{
			echo "duplicate";
		}
		else
		{
			echo "new";
		}
		
	}
	/*common duplicate check funciton end*/
	
	
	
	
	 /* Product Manage start */
	function adminProductManage($typeUser='',$paginationNo='',$orderName='',$orderBy='',$editId='')
	{
	
		if($this->checkLogin('A') !='')
		{
		
			$tableName = PRODUCTS;			
			$redirectTo = 'products/adminproductmanage';	
			$data = $this->adminCommonManagement($typeUser,$paginationNo,$orderName,$orderBy,'id',$tableName,$redirectTo,$editId); 
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Model  Active/Inactive/Delete function start*/
	function productActiveInactiveDeleteFunction($changeMode='',$jobSeekerId='',$userType='',$paginationNo='')
	{
		if($this->checkLogin('A') !='')
		{
			$fieldName = 'id';
			$redirectTo = 'adminproductmanage';
			$tableName = PRODUCTS;
			$this->commonManageActiveInactive($changeMode,$jobSeekerId,$userType,$paginationNo,$fieldName,$redirectTo,$tableName);
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Model  Active/Inactive/Delete function end*/
	
	/* Model view start */
	function viewProductDetails($viewId = '')
	{
	
		if($this->checkLogin('A') !='')
		{
			/* get single job seekers full details start */
			$paraArr = array();
			$paraArr['whereCondition'] = array('id'=>$viewId);
			$redirectTo = 'viewproductdetails';
			$tableName = PRODUCTS;

			$callViewDetails = $this->commonViewDetails($paraArr,$redirectTo,$tableName);
			
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Model view end */
	
	function productAddEdit($productId = '')
	{
	   	if($this->checkLogin('A') == '')
		{
			redirect('admin/adminlogin/loginPage');
		}
		else
		 {
		
		 	$getSingleProductVals = $this->admingeneralmanage_model->getSingleProductVals($productId);
			//echo "<pre>";print_r($getSingleProductVals);die;
			$brandTableName = CATEGORIES;
			$whereField = 'status';
			$whereVal = 'active';
			$soryKey = 'cat_name';
			$sortVal = 'asc';
			$getCategoryDetails = $this->admingeneralmanage_model->getCommonDetails($brandTableName,$whereField,$whereVal,$soryKey,$sortVal);
			
		//	echo "<pre>";print_r($getCategoryDetails);die;
			
			
			
			$imageTableName = PRODUCTIMAGES;
			$imagewhereField = 'product_id';
			$imagewhereVal = $productId;
			$imageSoryKey = 'prod_image_priority';
			$imageSortVal = 'asc';
			
			$getProductImageDetails = $this->admingeneralmanage_model->getCommonDetails($imageTableName,$imagewhereField,$imagewhereVal,$imageSoryKey,$imageSortVal);
			
			
			$attributeTableName = ATTRIBUTES;
			$attributewhereField = 'status';
			$attributewhereVal = 'active';
			$attributesoryKey = 'attr_name';
			$attributesortVal = 'asc';
			
			$getProductAttrDetails = $this->admingeneralmanage_model->getCommonDetails($attributeTableName,$attributewhereField,$attributewhereVal,$attributesoryKey,$attributesortVal);
			//echo "<pre>";print_r($getProductAttrDetails);die;
			
			
			$attrSelectedTableName = PRODUCT_ATTRIBUTES;
			$attrSelectedwhereField = 'product_id';
			$attrSelectedwhereVal = $productId;
			$attrSelectedSoryKey = 'id';
			$attrSelectedSortVal = 'desc';
			
			$getAttributeSelVal = $this->admingeneralmanage_model->getCommonDetails($attrSelectedTableName,$attrSelectedwhereField,$attrSelectedwhereVal,$attrSelectedSoryKey,$attrSelectedSortVal);
			
		//	echo "<pre>";print_R($getAttributeSelVal);die;
			
			
			$data['getCategoryDetails'] = $getCategoryDetails;			 
		 	$data['product_path'] = $this->config->item('product_path');
			$data['getSingleProductVals'] = $getSingleProductVals;
			$data['getProductImageDetails'] = $getProductImageDetails;
			$data['getProductAttrDetails'] = $getProductAttrDetails;
			$data['getAttributeSelVal'] = $getAttributeSelVal;
			$this->load->view('admin/products/adminaddproducts',$data);
		 }

	}
	

    /* Product view add edit function start */
	function productAddEditValues()
	{
	
		if($this->checkLogin('A') !='')
		{
		
			$brandEdiVal = $this->input->post('productEdiVal');
			$this->session->unset_userdata('product_FileDetails');
			
			 $modelFileDetails = $this->session->userdata('product_FileDetails');
			$insertEditProductValues = $this->admingeneralmanage_model->insertEditProductValues();
			
			$type == 'success';
			$message = 'Product Saved Successfully';
			$this->setFlashDataCommon($type,$message);
			
			if($this->input->post('redirectPage') == 'editPage')
				redirect('admin/admingeneralmanage/productAddEdit/'.$brandEdiVal);
			else
				redirect('admin/admingeneralmanage/adminProductManage');
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Model view add edit function end */
	
	/* slider duplicate check start */
	function sliderDuplicateCheck()
	{
		$slider_name = addslashes($this->input->post('slider_name'));
		$editDetailsId = $this->input->post('sliderEditNo');
		
		if($slider_name != '')
		{
			$tableName = SLIDER;
			$checkFieldName = 'slider_name';
			$whereFieldName = 'id';
			
			$duplicateCheck = $this->commonDuplicateCheck($tableName,$checkFieldName,$slider_name,$whereFieldName,$editDetailsId);
		}
		
	}
	
	function productDuplicateCheck()
	{
		 $product_name = $this->input->post('product_name');
		$editDetailsId = $this->input->post('productEdiVal');
		//echo "dsf";die;
		if($product_name != '')
		{
		//echo "hi";die;
			$duplicateCheck = $this->admingeneralmanage_model->productDuplicateCheck($editDetailsId);
			
			if($duplicateCheck >= 1)
			{
				echo "duplicate";
			}
			else
			{
				echo "new";
			}
		}
		
	}
	
	function deleteProductImage()
	{
		$prod_image_id = $this->input->post('prod_image_id');
		$imageName = $this->input->post('imageName');
		if($prod_image_id != '')
		{
			$removeProductImage = $this->admingeneralmanage_model->removeProductImage($imageName);
			echo "Deleted successfully";
		}
	}
	
	function viewProductsDetls()
	{
		if($this->checkLogin('A') !='')
		{
			
			 $dealCodeNumber = $this->uri->segment(4);
			 $customerId = $this->uri->segment(5);
			  $dealCodeNumber = $this->uri->segment(6);
			$getProdCustomerDetails = $this->admingeneralmanage_model->getProdCustomerDetails($customerId);
			
			
			$getProductDetails = $this->admingeneralmanage_model->getProductDetails($dealCodeNumber);
			//echo "<pre>";print_r($getProductDetails);die;
			$data['getProdCustomerDetails'] = $getProdCustomerDetails;
			$data['getProductDetails'] = $getProductDetails;
			$data['PRODUCT_PATH'] = $this->config->item('product_path');
			
			$this->load->view('admin/orders/vieworders',$data);
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
			
	}
	
	
	function updateImageProduct()
	{
		$prod_image_priority = $this->input->post('prod_image_priority');
		$prod_image_id = $this->input->post('prod_image_id');//die;
		if($prod_image_id != '')
		{
			$updateImageProduct = $this->admingeneralmanage_model->updateImageProduct($prod_image_priority);
			echo "Updated successfully";
		}
	}
	
	function categoryDuplicateCheck()
	{
		$cat_name = addslashes($this->input->post('cat_name'));
		$editDetailsId = $this->input->post('categoryEdiVal');
		
		if($cat_name != '')
		{
			$tableName = CATEGORIES;
			$checkFieldName = 'cat_name';
			$whereFieldName = 'id';
			
			$duplicateCheck = $this->commonDuplicateCheck($tableName,$checkFieldName,$cat_name,$whereFieldName,$editDetailsId);
		}
		
	}
	
	function modelDuplicateCheck()
	{
		$model_name = addslashes($this->input->post('model_name'));
		$editDetailsId = $this->input->post('modelEdiVal');
		
		if($model_name != '')
		{
			$tableName = BRAND_MODEL;
			$checkFieldName = 'model_name';
			$whereFieldName = 'id';
			
			$duplicateCheck = $this->commonDuplicateCheck($tableName,$checkFieldName,$model_name,$whereFieldName,$editDetailsId);
		}
		
	}
	
	
	
	/* Coupon Manage start */
	function adminCouponManage($typeUser='',$paginationNo='',$orderName='',$orderBy='',$editId='')
	{
	
		//$editId = $this->uri->segent(5);die;
		if($this->checkLogin('A') !='')
		{
		
			$tableName = COUPONS;			
			$redirectTo = 'coupons/admincouponmanage';	//This redirectTo variable value must be same as this function view file name.(Here view file name is "adminNewsManage"	
			$data = $this->adminCommonManagement($typeUser,$paginationNo,$orderName,$orderBy,'id',$tableName,$redirectTo,$editId); //Call common function name "adminCommonManagement"
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Coupon  Active/Inactive/Delete function start*/
	function couponActiveInactiveDeleteFunction($changeMode='',$jobSeekerId='',$userType='',$paginationNo='')
	{
		if($this->checkLogin('A') !='')
		{
			$fieldName = 'id';
			$redirectTo = 'adminCouponManage';
			$tableName = COUPONS;
			$this->commonManageActiveInactive($changeMode,$jobSeekerId,$userType,$paginationNo,$fieldName,$redirectTo,$tableName);
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Coupon  Active/Inactive/Delete function end*/
	
	/* Coupon view start */
	function viewCouponDetails($viewId = '')
	{
	
		if($this->checkLogin('A') !='')
		{
			/* get single job seekers full details start */
			$paraArr = array();
			$paraArr['whereCondition'] = array('id'=>$viewId);
			$redirectTo = 'coupons/viewcoupondetails';
			$tableName = COUPONS;

			$callViewDetails = $this->commonViewDetails($paraArr,$redirectTo,$tableName);
			
			/* get single job seekers full details end */
			
			//$data['getSingleJobSeekerDetails'] = $getSingleJobSeekerDetails;
				
			//$this->load->view('admin/viewjobseekerdetails',$data);
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Coupon view end */
	
	
	
	function couponAddEdit($couponId = '')
	{
	   	if($this->checkLogin('A') == '')
		{
			redirect('admin/adminlogin/loginPage');
		}
		else
		 {
			$getCategoryList = $this->admingeneralmanage_model->getCategoryList();
			$getProductList = $this->admingeneralmanage_model->getProductList();
		 	$getSingleCouponDetials = $this->admingeneralmanage_model->getSingleCouponDetials($couponId);
		 	$data['brand_path'] = $this->config->item('brand_path');
			$data['getSingleCouponDetials'] = $getSingleCouponDetials;
			//echo "<pre>";print_r($getSingleCouponDetials);die;
			$product_data_values = unserialize($getSingleCouponDetials['product_id']);
			
			$data['getCategoryList'] = $getCategoryList;
			$data['getProductList'] = $getProductList;
			$data['product_data_values'] = $product_data_values;
			$this->load->view('admin/coupons/adminaddcoupon',$data);
		 }

	}
	

    /* Brand view add edit function start */
	function couponAddEditValues()
	{
	//echo $this->input->post('couponEdiVal');die;
		if($this->checkLogin('A') !='')
		{
		
			$couponEdiVal = $this->input->post('couponEdiVal');
			$existing_prod_array = array();
			if($couponEdiVal != '')
			{
			 
				$couponProductExistingData = $this->admingeneralmanage_model->get_existing_prod_selected($couponEdiVal);
				$existing_prod_array =  unserialize($couponProductExistingData['product_id']);
 				//echo "<pre>sdf";print_r($existing_prod_array);die;
				$product_id = $_POST['product_id'];
				if($this->input->post('changePRoductHidden') ==1)
				{
					$productIdList = array_merge($product_id,$existing_prod_array);
				}
				else
				{
					$productIdList = $_POST['product_id'];	
				}
				$product_id = serialize($productIdList);	
						
			}
			else
			{
				$product_id = serialize($_POST['product_id']);			
			}
			$excludeArray = array("couponAddEdit","product_id","seoPurpose","couponEdiVal","imageValPurpose","changePRoductHidden");
			$insertVals  = $this->getAddEditDetails($excludeArray);
			
			$product_id_list = implode(",", unserialize($product_id));
			 
			
			$othersDetails = array('product_id'=>$product_id,'product_id_list'=>$product_id_list);
			$insertVals = array_merge($insertVals,$othersDetails);
			
			$insertEditSliderValues = $this->admingeneralmanage_model->insertEditCouponVals($insertVals,$couponEdiVal);
			
			/**************************** coupon product id file create start ************************/
			$getPromotionalValues = $this->admingeneralmanage_model->getPromotionalValues();
		 
			$promocodelist = '<?php';
			
				$promocodelist .= "\n\$config['promovalues'] = ".serialize($getPromotionalValues)."; ";
			
			
			$promocodelist .= ' ?>';
			$file = 'uesca_promosettings.php';
			file_put_contents($file, $promocodelist);
			
			
			/**************************** coupon product id file create end ************************/
			
			
			
			
			
			
			$type == 'success';
			$message = 'Promotional Saved Successfully';
			$this->setFlashDataCommon($type,$message);
			
			redirect('admin/admingeneralmanage/adminCouponManage');
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Coupon view add edit function end */
	
	function get_product_list()
	{
		$category_id = $this->input->post('category_id');
		$editCouponId = $this->input->post('editCouponId');
		
		$get_product_list = $this->admingeneralmanage_model->getProductList();
		$getCouponProductData = $this->admingeneralmanage_model->getCouponProductData($category_id);
		$get_existing_prod_selected = $this->admingeneralmanage_model->get_existing_prod_selected($editCouponId,$category_id);
			
		//echo $this->db->last_query();die;
		 $product_data_values = unserialize($getCouponProductData['product_id']);	
		 $product_existing_values = unserialize($get_existing_prod_selected['product_id']);	
		
	//print_r($product_existing_values);die;	
		$data['get_product_list'] = $get_product_list;
		$data['product_data_values'] = $product_data_values;
		$data['product_existing_values'] = $product_existing_values;
		$data['editCouponId'] = $editCouponId;
 		$this->load->view('admin/coupons/productlist',$data);			
	}
	
	function deleteProductAttribute()
	{
		$prod_attribute_id = $this->input->post('prod_attribute_id');
 		if($prod_attribute_id != '')
		{
			$removeProductAttribute = $this->admingeneralmanage_model->removeProductAttribute($prod_attribute_id);
			echo "Deleted successfully";
		}
	}
	
	function updateProductAttribute()
	{
		$prod_attribute_id = $this->input->post('prod_attribute_id');
 		if($prod_attribute_id != '')
		{
			$updateProductAttribute = $this->admingeneralmanage_model->updateProductAttribute($prod_attribute_id);
			echo "Updated successfully";
		}
	}
	
	
	
	 /* Attribute Manage start */
	function adminAttributeManage($typeUser='',$paginationNo='',$orderName='',$orderBy='',$editId='')
	{	
		if($this->checkLogin('A') !='')
		{
		
			$tableName = ATTRIBUTES;			
			$redirectTo = 'attributes/adminattributesmanage';	//This redirectTo variable value must be same as this function view file name.(Here view file name is "adminNewsManage"	
			$data = $this->adminCommonManagement($typeUser,$paginationNo,$orderName,$orderBy,'id',$tableName,$redirectTo,$editId); //Call common function name "adminCommonManagement"
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Attribute  Active/Inactive/Delete function start*/
	function attributeActiveInactiveDeleteFunction($changeMode='',$jobSeekerId='',$userType='',$paginationNo='')
	{	
		if($this->checkLogin('A') !='')
		{
			$fieldName = 'id';
			$redirectTo = 'adminAttributeManage';
			$tableName = ATTRIBUTES;
			$this->commonManageActiveInactive($changeMode,$jobSeekerId,$userType,$paginationNo,$fieldName,$redirectTo,$tableName);
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Attribute  Active/Inactive/Delete function end*/
	
	
	
	function attributeAddEdit($attributeId = '')
	{
	
	   	if($this->checkLogin('A') == '')
		{
			redirect('admin/adminlogin/loginPage');
		}
		else
		 {
		
		 	$getSingleAttributeVals = $this->admingeneralmanage_model->getSingleAttributeVals($attributeId);
		 	$data['brand_path'] = $this->config->item('categories_path');
			$data['getSingleAttributeVals'] = $getSingleAttributeVals;
			$this->load->view('admin/attributes/adminaddattributes',$data);
		 }

	}
	

    /* Attribute view add edit function start */
	function attributeAddEditValues()
	{
	//echo $this->input->post('brandEdiVal');die;
		if($this->checkLogin('A') !='')
		{
		$categoryAddEdit = $this->input->post('categoryAddEdit');
			
			$excludeArray = array("seoPurpose","attributeEditVal","imageValPurpose","attributeAddEdit");
		$categoryAddEditVal  = $this->getAddEditDetails($excludeArray);
			$insertEditSliderValues = $this->admingeneralmanage_model->insertEditAttributeValues($categoryAddEditVal);
			
			$type == 'success';
			$message = 'Attribute Saved Successfully';
			$this->setFlashDataCommon($type,$message);
			
			redirect('admin/admingeneralmanage/adminAttributeManage');
		}
		else
		{
			redirect('admin/adminlogin/loginPage');
		}
	}
	/* Attribute view add edit function end */

}