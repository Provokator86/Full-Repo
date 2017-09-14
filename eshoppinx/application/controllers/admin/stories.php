<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This controller contains the functions related to user management 
 * @author Teamtweaks
 *
 */

class Stories extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('stories_model');
		if ($this->checkPrivileges('stories',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
    
    /**
     * 
     * This function loads the stories list page
     */
   	public function index(){	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			redirect('admin/stories/display_stories_list');
		}
	}
	
	/**
	 * 
	 * This function loads the stories list page
	 */
	public function display_stories_list(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Stories List';
			$condition = "s.status<>''";
			$this->data['storiesList']= $this->stories_model->get_all_StoresDetails($condition);

			$this->load->view('admin/stories/display_stories',$this->data);
		}
	}
	
	
	
	/**
	 * 
	 * This function loads the add new stories form
	 */
	public function add_stories_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$condition = array('user_id' => '0');
			$this->data['added_product'] = $this->stories_model->get_all_details(PRODUCT,$condition);
			$this->data['heading'] = 'Add New stories';
			$this->load->view('admin/stories/add_stories',$this->data);
		}
	}
	/**
	 * 
	 * This function insert and edit a user
	 */
	public function insertEditStories(){
	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$stories_id = $this->input->post('stories_id');
			$seller_product_id=implode(',',$this->input->post('seller_product_id'));
			
			$excludeArr = array("stories_id","status","seller_product_id");
			
			if ($this->input->post('status') != ''){
				$stories_status = 'Publish';
			}else {
				$stories_status = 'UnPublish';
			}
			$stories_data=array();
			$this->load->helper('text');
			$inputArr = array('status' => $stories_status,'seller_product_id'=>$seller_product_id);
			
			$dataArr = array_merge($inputArr,$stories_data);
			
			
			$condition = array('id' => $stories_id);
			if ($stories_id == ''){
				$this->stories_model->commonInsertUpdate(STORIES,'insert',$excludeArr,$dataArr,$condition);
				$this->setErrorMessage('success','Stories added successfully');
			}else {
				//echo $curency_default;die;
				
				if($curency_default=='Yes'){
				//echo '<pre>';print_r($dataArr);die;
					$dataArr1=array('currency_default'=>'No');
					$this->stories_model->update_details(COUNTRY_LIST,$dataArr1,array());
					//$conditionArr=array('id'=>$stories_id);
					//$this->stories_model->update_details(COUNTRY_LIST,$dataArr1,$conditionArr);
				}
				
//				$this->stories_model->updateCurrencyDetails($excludeArr,$dataArr,$condition);
				$this->stories_model->commonInsertUpdate(COUNTRY_LIST,'update',$excludeArr,$dataArr,$condition);
				$this->stories_model->saveCurrencySettings();
				$this->setErrorMessage('success','Country updated successfully');
			}
			redirect('admin/stories/display_stories_list');
		}
	}
	
	/**
	 * 
	 * This function loads the edit user form
	 */
	public function edit_stories_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Edit Stories';
			$stories_id = $this->uri->segment(4,0);
			$condition = array('id' => $stories_id);
			$this->data['stories_details'] = $this->stories_model->get_all_details(COUNTRY_LIST,$condition);
			if ($this->data['stories_details']->num_rows() == 1){
				$this->load->view('admin/stories/edit_stories',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	/**
	 * 
	 * This function change the user status
	 */
	public function change_stories_status(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$user_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'UnPublish':'Publish';
			$newdata = array('status' => $status);
			$condition = array('id' => $user_id);
			$this->stories_model->update_details(STORIES,$newdata,$condition);
			$this->setErrorMessage('success','Stories Status Changed Successfully');
			redirect('admin/stories/display_stories_list');
		}
	}
	
	/**
	 * 
	 * This function loads the user view page
	 */
	public function view_stories(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'View Stories';
			$stories_id = $this->uri->segment(4,0);
			$condition = " s.id = '".$stories_id."'";
			$this->data['stories_details'] = $this->stories_model->get_all_StoresDetails($condition);
			$ProductDetails='';
			
			if($this->data['stories_details']->row()->seller_product_id !=''){
			$ProductDetails= $this->stories_model->get_all_StoriesProduct($this->data['stories_details']->row()->seller_product_id);
			}
			
			$this->data['ProductDetails']=$ProductDetails;
			$this->load->view('admin/stories/view_stories',$this->data);
			
		}
	}
	
	/**
	 * 
	 * This function delete the user record from db
	 */
	public function delete_stories(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$stories_id = $this->uri->segment(4,0);
			$condition = array('id' => $stories_id);
			$this->stories_model->commonDelete(STORIES,$condition);
			$this->setErrorMessage('success','Stories deleted successfully');
			redirect('admin/stories/display_stories_list');
		}
	}
	
	/**
	 * 
	 * This function change the user status, delete the user record
	 */
	public function change_stories_status_global(){
		if($_POST['checkboxID']!=''){
		
			if($_POST['checkboxID']=='0'){
				redirect('admin/stories/add_stories_form/0');
			}else{
				redirect('admin/stories/add_stories_form/'.$_POST['checkboxID']);			
			}
	
		}else{
			if(count($_POST['checkbox_id']) > 0 &&  $_POST['statusMode'] != ''){
				$data =  $_POST['checkbox_id'];
				if (strtolower($_POST['statusMode']) == 'delete'){
					for ($i=0;$i<count($data);$i++){  
						if($data[$i] == 'on'){
							unset($data[$i]);
						}
					}
					foreach ($data as $product_id){
						if ($product_id!=''){
							$old_product_details = $this->stories_model->get_all_details(STORIES,array('id'=>$product_id));
							$this->update_old_list_values($product_id,array(),$old_product_details);
							$this->update_user_product_count($old_product_details);
						}
					}
				}
				$this->stories_model->activeInactiveCommon(STORIES,'id');
				if (strtolower($_POST['statusMode']) == 'delete'){
					$this->setErrorMessage('success','Stories records deleted successfully');
				}else {
					$this->setErrorMessage('success','Stories records status changed successfully');
				}
				redirect('admin/stories/display_stories_list');
			}
		}
	}
	
	
	
	
	
	
	
	
}

/* End of file stories.php */
/* stories: ./application/controllers/admin/stories.php */