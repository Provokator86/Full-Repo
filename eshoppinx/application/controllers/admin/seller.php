<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This controller contains the functions related to seller management
 * @author Teamtweaks
 *
 */

class Seller extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('seller_model');
		if ($this->checkPrivileges('seller',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
    
    /**
     * 
     * This function loads the seller requests page
     */
   	public function index(){	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			redirect('admin/seller/display_seller_dashboard');
		}
	}
	
	/**
	 * 
	 * This function loads the sellers dashboard
	 */
	public function display_seller_dashboard(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Sellers Dashboard';
			$condition = array('group'=>'Seller');
			$this->data['sellerList'] = $this->seller_model->get_all_details(USERS,$condition);
			$Query = "select p.sell_id,MAX(p.total) as topAmt,sum(p.quantity) as totQty, u.user_name,u.full_name from ".PAYMENT." p 
						LEFT JOIN ".USERS." u on u.id=p.sell_id
						Where p.status='Paid'
						group by p.dealCodeNumber
						order by p.total+0 desc";
			$this->data['topSellDetails'] = $this->seller_model->ExecuteQuery($Query);
			$condition = array('request_status'=>'Pending','group'=>'User');
			$this->data['pendingList'] = $this->seller_model->get_all_details(USERS,$condition);
			$this->load->view('admin/seller/display_seller_dashboard',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the seller requests page
	 */
	 //$this->data['userconversation'] = $this->user_model->get_all_details(RFQ_CONVERSATION,array('con_rfq_id'=>$this->data['contact_seller_status']->row()->id));

	/*public function display_seller_requests(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Claim Requests';
			$condition = array('status' => 'pending');
			$this->data['sellerRequests'] = $this->seller_model->get_all_details(STORE_CLAIMS,$condition);
			$this->data['getuserDetails'] = $this->seller_model->get_all_details(USERS,array('id'=>$this->data['sellerRequests']->row()->user_id));
			$this->load->view('admin/seller/display_seller_requests',$this->data);
		}
	}*/
	
	public function display_seller_requests(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Claim Requests';
			$condition = array('status' => 'pending');
			//$this->data['sellerRequests'] = $this->seller_model->get_all_details(STORE_CLAIMS,$condition);
			//$Query = "select c.*,s.store_url from ".STORE_CLAIMS." c LEFT JOIN ".SHOPS." s on(c.store_id=s.id) and c.status='pending'";
			$Query = "select c.*,s.store_url from ".STORE_CLAIMS." c LEFT JOIN ".SHOPS." s on(c.store_id=s.id) where c.status='pending'";
			$this->data['storeDetails'] = $this->seller_model->ExecuteQuery($Query);
			
			$this->data['getuserDetails'] = $this->seller_model->get_all_details(USERS,array('id'=>$this->data['storeDetails']->row()->user_id));
			$this->load->view('admin/seller/display_seller_requests',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the sellers list page
	 */
	public function display_seller_list(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		} else {
			$this->data['heading'] = 'Store List';
			$this->data['sellersList'] = $this->seller_model->get_all_details(SHOPS,$condition);
			$this->load->view('admin/seller/display_sellerlist',$this->data);
		}
	}
	
	/**
	 * 
	 * This function insert and edit a seller
	 */
	 
	public function insertEditStore(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			//$store_id = $this->uri->segment(4,0);
			//print_r($store_id); die;
			$seller_id = $this->input->post('seller_id');
			$excludeArr = array("seller_id");
			$dataArr = array();
			$condition = array('id' => $seller_id);
			if ($seller_id == ''){
				$this->setErrorMessage('success','Seller added successfully');
			}else {
				$this->seller_model->commonInsertUpdate(STORE_CLAIMS,'update',$excludeArr,$dataArr,$condition);
				$this->setErrorMessage('success','Store updated successfully');
			}
			redirect('admin/seller/edit_seller');
		}
	}
	
	/*public function insertEditSeller(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$seller_id = $this->input->post('seller_id');
			$store_name = $this->input->post('store_name');
			$store_id = $this->input->post('store_id');
			$condition1 = array('id' => $store_id);
			
			$excludeArr = array("seller_id");
			$dataArr = array();
			$condition = array('id' => $seller_id);
			if ($seller_id == ''){
				$this->setErrorMessage('success','Seller added successfully');
			}else {
				$this->seller_model->commonInsertUpdate(STORE_CLAIMS,'update',$excludeArr,$dataArr,$condition);
				
				$config['overwrite'] = FALSE;
				$config['allowed_types'] = 'jpg|jpeg|gif|png';
				$config['max_size'] = 2000;
				$config['upload_path'] = './images/store';
				$this->load->library('upload', $config);
				if ( $this->upload->do_upload('store_logo')){
					$imgDetails = $this->upload->data();
					$dataArr['store_logo'] = $imgDetails['file_name'];
				}
				
				$excludeArr = array('address','city','state','country','postal_code','phone_no','seller_id','store_id');
				$dataArr['store_name'] =$store_name;
				$this->product_model->commonInsertUpdate(SHOPS,'update',$excludeArr,$dataArr,array('id'=>$store_id),$condition1);	
				//$this->product_model->commonInsertUpdate(SHOPS,'update',$excludeArr,$dataArr,array('seller_product_id'=>$pid));
				
				$this->setErrorMessage('success','Store updated successfully');
			}
			redirect('admin/seller/display_seller_list');
		}
	}*/
	
	public function insertEditSeller(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$seller_id = $this->input->post('seller_id');
			$store_name = $this->input->post('store_name');
			$store_id = $this->input->post('store_id');
			$condition1 = array('id' => $store_id);
			
			$condition3 = array('id' => $seller_id);
			
			$excludeArr = array("seller_id");
			$dataArr = array();
			$condition = array('id' => $seller_id);
			if ($seller_id == ''){
				$this->setErrorMessage('success','Seller added successfully');
			}else {
				
				if($store_id!='') {
					$this->seller_model->commonInsertUpdate(STORE_CLAIMS,'update',$excludeArr,$dataArr,$condition);
				}
				
				$config['overwrite'] = FALSE;
				$config['allowed_types'] = 'jpg|jpeg|gif|png';
				$config['max_size'] = 2000;
				$config['upload_path'] = './images/store';
				$this->load->library('upload', $config);
				if ( $this->upload->do_upload('store_logo')){
					$imgDetails = $this->upload->data();
					$dataArr['store_logo'] = $imgDetails['file_name'];
				}
				
				$excludeArr = array('address','city','state','country','postal_code','phone_no','seller_id','store_id');
				$dataArr['store_name'] =$store_name;
				
				//print_r($dataArr); die;
				
				if($store_id!='') {
					$this->product_model->commonInsertUpdate(SHOPS,'update',$excludeArr,$dataArr,array('id'=>$store_id),$condition1);
				} else { 
					$this->product_model->commonInsertUpdate(SHOPS,'update',$excludeArr,$dataArr,array('id'=>$seller_id),$condition3);
				}
				
				$this->setErrorMessage('success','Store updated successfully');
			}
			redirect('admin/seller/display_seller_list');
		}
	}
	
	/**
	 * 
	 * This function change the seller request status
	 */
	public function change_seller_request(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$user_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'Rejected':'Approved';
			$newdata = array('status' => $status);
			
			$condition = array('id' => $user_id);
			$this->seller_model->update_details(STORE_CLAIMS,$newdata,$condition);
			$this->setErrorMessage('success','Claim Request '.$status.' Successfully');
			redirect('admin/seller/display_seller_requests');
		}
	}
	
	/**
	 * 
	 * This function change the seller status
	 */
	public function change_seller_status(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$user_id = $this->uri->segment(5,0);
			$store_id = $this->uri->segment(6,0);
			$status = ($mode == '0')?'Rejected':'Approved';
			$newdata = array('status' => $status);
			$condition = array('id' => $user_id);
			
			$rej_status=array('status' => 'rejected');
			$condition3=array('store_id'=>$store_id);
			
			$this->seller_model->update_details(STORE_CLAIMS,$rej_status,$condition3);
			
			$this->seller_model->update_details(STORE_CLAIMS,$newdata,$condition);
			
			$condition1 = array('store_id' => $store_id);
			$condition2 = array('id' => $store_id);
			
			//$this->data['approvedDetails'] = $this->seller_model->get_all_details(STORE_CLAIMS,$condition1);
			
			//print_r($condition);
			
			$this->data['approvedDetails'] = $this->seller_model->get_all_details(STORE_CLAIMS,$condition);
			
			$newdata1 = array(
	               'store_name' => $this->data['approvedDetails']->row()->store_name,
				   'user_id' => $this->data['approvedDetails']->row()->user_id,
				   'description' => $this->data['approvedDetails']->row()->description
				   );		   
			//print_r($newdata1); exit;
			$this->seller_model->update_details(SHOPS,$newdata1,$condition2);
			$this->setErrorMessage('success','Claim Status Changed Successfully');
			//redirect('admin/seller/display_seller_list');
			redirect('admin/seller/display_seller_requests');
		}
	}
	
	public function view_seller(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'View Claim Request';
			$seller_id = $this->uri->segment(4,0);
			$condition = array('id' => $seller_id);
			$this->data['seller_details'] = $this->seller_model->get_all_details(STORE_CLAIMS,$condition);
			$this->data['getuserDetails'] = $this->seller_model->get_all_details(USERS,array('id'=>$this->data['seller_details']->row()->user_id));
			if ($this->data['seller_details']->num_rows() == 1){
				$this->load->view('admin/seller/view_seller',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	/*public function view_store(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'View Store';
			$seller_id = $this->uri->segment(4,0);
			$condition = array('id' => $seller_id);
			
			$query = "select c.*,s.store_url,s.products_count,s.followers_count,s.store_logo from ".STORE_CLAIMS." c join ".SHOPS." s on(c.store_id=s.id) where c.store_id=".$seller_id."";
			$this->data['storeDetails'] = $this->seller_model->ExecuteQuery($query);
			$this->data['getuserDetails'] = $this->seller_model->get_all_details(USERS,array('id'=>$this->data['storeDetails']->row()->user_id));
			//if ($this->data['storeDetails']->num_rows() == 1){
				$this->load->view('admin/seller/view_store',$this->data);
			//}else {
				//redirect('admin');
			//}
		}
	}*/
	
	public function view_store(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'View Store';
			$seller_id = $this->uri->segment(4,0);
			$condition = array('id' => $seller_id);
			
			//$query = "select c.*,s.store_url,s.products_count,s.followers_count,s.store_logo from ".STORE_CLAIMS." c join ".SHOPS." s on(c.store_id=s.id) where c.store_id=".$seller_id.""; 
			//$this->data['storeDetails'] = $this->seller_model->ExecuteQuery($query);
			
			$query = "select c.*,s.store_url,s.products_count,s.followers_count,s.store_logo from ".STORE_CLAIMS." c join ".SHOPS." s on(c.store_id=s.id) where c.store_id=".$seller_id." and status='approved'"; 
			
			$query_shop = "select * from ".SHOPS." where id='".$seller_id."'";
			
			$this->data['storeDetails'] = $this->seller_model->ExecuteQuery($query_shop);
			
			if($this->data['storeDetails']->row()->user_id>0) {
				$this->data['storeDetails'] = $this->seller_model->ExecuteQuery($query);
			} else {
				$this->data['storeDetails'] = $this->seller_model->ExecuteQuery($query_shop);
			}
			
			$this->data['getuserDetails'] = $this->seller_model->get_all_details(USERS,array('id'=>$this->data['storeDetails']->row()->user_id));
			$this->load->view('admin/seller/view_store',$this->data);
		}
	}
	
	/*public function edit_seller_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			
			$this->data['heading'] = 'Edit Store Details';
			$seller_id = $this->uri->segment(4,0);
			$condition = array('id' => $seller_id);
			
			$query = "select c.*,s.store_url,s.products_count,s.followers_count,s.store_logo from ".STORE_CLAIMS." c join ".SHOPS." s on(c.store_id=s.id) where c.store_id=".$seller_id."";
			$this->data['storeDetails'] = $this->seller_model->ExecuteQuery($query);
			$this->data['getuserDetails'] = $this->seller_model->get_all_details(USERS,array('id'=>$this->data['storeDetails']->row()->user_id));
			//if ($this->data['storeDetails']->num_rows() == 1){
				$this->load->view('admin/seller/edit_seller',$this->data);
			//}else {
				//redirect('admin');
			//}
		}
	}*/
	
	public function edit_seller_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			
			$this->data['heading'] = 'Edit Store Details';
			$seller_id = $this->uri->segment(4,0);
			$condition = array('id' => $seller_id);
			
			/*$query = "select c.*,s.store_url,s.products_count,s.followers_count,s.store_logo from ".STORE_CLAIMS." c join ".SHOPS." s on(c.store_id=s.id) where c.store_id=".$seller_id."";
			$this->data['storeDetails'] = $this->seller_model->ExecuteQuery($query);*/
			
			$query = "select c.*,s.store_url,s.products_count,s.followers_count,s.store_logo from ".STORE_CLAIMS." c join ".SHOPS." s on(c.store_id=s.id) where c.store_id=".$seller_id." and status='approved'"; 
			
			$query_shop = "select * from ".SHOPS." where id='".$seller_id."'";
			
			$this->data['storeDetails'] = $this->seller_model->ExecuteQuery($query_shop);
			
			if($this->data['storeDetails']->row()->user_id>0)
			{
				$this->data['storeDetails'] = $this->seller_model->ExecuteQuery($query);
			}
			else
			{
				$this->data['storeDetails'] = $this->seller_model->ExecuteQuery($query_shop);
			}
			
			$this->data['getuserDetails'] = $this->seller_model->get_all_details(USERS,array('id'=>$this->data['storeDetails']->row()->user_id));
			$this->load->view('admin/seller/edit_seller',$this->data);
		}
	}
	
	/**
	 * 
	 * This function delete the seller record from db
	 */
	public function delete_seller(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$seller_id = $this->uri->segment(4,0);
			$condition = array('id' => $seller_id);
			$this->seller_model->commonDelete(SHOPS,$condition);
			
			$condition1 = array('store_id' => $seller_id);
			$this->seller_model->commonDelete(STORE_CLAIMS,$condition1);
			
			$this->setErrorMessage('success','Store deleted successfully');
			redirect('admin/seller/display_seller_list');
		}
	}
	
	/**
	 * 
	 * This function delete the seller request records
	 */
	public function change_seller_status_global(){
		if(count($_POST['checkbox_id']) > 0 &&  $_POST['statusMode'] != ''){
			$this->seller_model->activeInactiveCommon(USERS,'id');
			if (strtolower($_POST['statusMode']) == 'delete'){
				$this->setErrorMessage('success','Seller records deleted successfully');
			}else {
				$this->setErrorMessage('success','Seller records status changed successfully');
			}
			redirect('admin/seller/display_seller_list');
		}
	}
	
	/**
	 * 
	 * This function change the user status
	 */
	public function change_user_status(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$user_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'Inactive':'Active';
			$newdata = array('status' => $status);
			$condition = array('id' => $user_id);
			$this->seller_model->update_details(USERS,$newdata,$condition);
			$this->setErrorMessage('success','Seller Status Changed Successfully');
			redirect('admin/seller/display_seller_list');
		}
	}
	
	public function update_refund(){
		if ($this->checkLogin('A') != ''){
			$uid = $this->input->post('uid');
			$refund_amount = $this->input->post('amt');
			if ($uid != ''){
				$this->seller_model->update_details(USERS,array('refund_amount'=>$refund_amount),array('id'=>$uid));
			}
		}
	}
}

/* End of file seller.php */
/* Location: ./application/controllers/admin/seller.php */