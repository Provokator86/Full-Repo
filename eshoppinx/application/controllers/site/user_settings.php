<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * User Settings related functions
 * @author Teamtweaks
 *
 */

class User_settings extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','pagination'));		
		$this->load->model('user_model');
		$this->load->model('commission_model','commission');
		
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->user_model->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];
		
		if($_SESSION['sColorLists'] == ''){
			$_SESSION['sColorLists'] = $this->user_model->get_all_details(LIST_VALUES,array('list_id'=>'1'));
		}
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];
		
		$this->data['loginCheck'] = $this->checkLogin('U');
    }
    
    public function index(){
        $this->data['side_menu'] = 1;
    	if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
	    	$this->data['heading'] = 'Settings';
    		$this->load->view('site/user/settings',$this->data);
    	}
    }
    
    public function update_profile(){
    	$inputArr = array();
    	$response['success'] = '0';
    	if ($this->checkLogin('U') == ''){
    		$response['msg'] = 'You must login';
    	}else {
	    	$update = '0';
	    	$email = $this->input->post('email');
	    	if ($email!=''){
	    		if (valid_email($email)){
	    			$condition = array('email'=>$email,'id !='=>$this->checkLogin('U'));
	    			$duplicateMail = $this->user_model->get_all_details(USERS,$condition);
	    			if ($duplicateMail->num_rows()>0){
						$response['msg'] = 'Email already exists';
	    			}else {
	    				$inputArr['email'] = $email;
	    				$update = '1';
	    			}
	    		}else {
	    			$response['msg'] = 'Invalid email';
	    		}
	    	}else {
	    		$update = '1';
	    	}
	    	if ($update == '1'){
	    		$birthday = $this->input->post('b_year').'-'.$this->input->post('b_month').'-'.$this->input->post('b_day');
	    		$excludeArr = array('b_year','b_month','b_day','email');
	    		$inputArr['birthday'] = $birthday;
	    		$condition = array('id'=>$this->checkLogin('U'));
	    		$this->user_model->commonInsertUpdate(USERS,'update',$excludeArr,$inputArr,$condition);
	    		$this->setErrorMessage('success','Done ! Your profile looks even better now');
	    		$response['success'] = '1';
	    	}
    	}
	    echo json_encode($response);
    }
    
    public function changePhoto(){
    	if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
	    	$config['overwrite'] = FALSE;
	    	$config['remove_spaces'] = TRUE;
	    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
	    	$config['max_size'] = 2000;
	    	$config['max_width']  = '600';
			$config['max_height']  = '600';
	    	$config['upload_path'] = './images/users';
	    	$this->load->library('upload', $config);
	    	if ( $this->upload->do_upload('upload-file')){
	    		$imgDetails = $this->upload->data();
	    		$dataArr['thumbnail'] = $imgDetails['file_name'];
	    		$condition = array('id'=>$this->checkLogin('U'));
	    		$this->user_model->update_details(USERS,$dataArr,$condition);
	    		redirect('image-crop/'.$this->checkLogin('U'));
	    	}else {
	    		$this->setErrorMessage('error',strip_tags($this->upload->display_errors()));
	    	}
	    	redirect(base_url().'settings');
    	}
    }
    
    public function delete_user_photo(){
    	$response['success'] = '0';
    	if ($this->checkLogin('U')==''){
    		$response['msg'] = 'You must login';
    	}else {
    		$condition = array('id'=>$this->checkLogin('U'));
    		$dataArr = array('thumbnail'=>'');
    		$this->user_model->update_details(USERS,$dataArr,$condition);
    		$this->setErrorMessage('success','Profile photo deleted successfully');
    		$response['success'] = '1';
    	}
    	echo json_encode($response);
    }
    
    public function delete_user_account(){
    	if ($this->checkLogin('U')!=''){
    		$datestring = "%Y-%m-%d %h:%i:%s";
			$time = time();
			$newdata = array(
	               'last_logout_date' => mdate($datestring,$time),
				   'status'=>'Inactive'
			);
			$condition = array('id' => $this->checkLogin('U'));
			$this->user_model->update_details(USERS,$newdata,$condition);
			$userdata = array(
							'fc_session_user_id'=>'',
							'session_user_name'=>'',
							'session_user_email'=>'',
							'fc_session_temp_id'=>''
						);
			$this->session->set_userdata($userdata);
    		$this->setErrorMessage('success','Your account inactivated successfully');
    	}
    }
    
    public function password_settings(){
        $this->data['side_menu'] =3;
    	if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
	    	$this->data['heading'] = 'Password Settings';
    		$this->load->view('site/user/changepassword',$this->data);
    	}
    }
    
    public function change_user_password(){
    	if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
    		$pwd = $this->input->post('pass');
    		$cfmpwd = $this->input->post('confirmpass');
    		if ($pwd != '' && $cfmpwd != '' && strlen($pwd) > 5){
    			if ($pwd == $cfmpwd){
    				$dataArr = array('password'=>md5($pwd));
    				$condition = array('id'=>$this->checkLogin('U'));
    				$this->user_model->update_details(USERS,$dataArr,$condition);
    				$this->setErrorMessage('success','Password changed successfully');
    			}else {
    				$this->setErrorMessage('error','Passwords does not match');
    			}
    		}else {
    			$this->setErrorMessage('error','Password and Confirm password fields required');
    		}
    		redirect(base_url().'settings/password');
    	}
    }
    
    public function preferences_settings(){
        $this->data['side_menu'] = 2;
    	if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
	    	$this->data['heading'] = 'Preference Settings';
	    	$this->data['languages'] = $this->user_model->get_all_details(LANGUAGES,array());
    		$this->load->view('site/user/change_preferences',$this->data);
    	}
    }
    
    public function update_preferences(){
    	if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
    		$this->user_model->commonInsertUpdate(USERS,'update',array(),array(),array('id'=>$this->checkLogin('U')));
    		$this->setErrorMessage('success','Preferences saved successfully');
    		redirect(base_url().'settings/preferences');
    	}
    }
    
	public function notifications_settings(){
        $this->data['side_menu'] = 4;
    	if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
	    	$this->data['heading'] = 'Notifications Settings';
	    	$this->data['languages'] = $this->user_model->get_all_details(LANGUAGES,array());
    		$this->load->view('site/user/change_notifications',$this->data);
    	}
    }
    
    public function update_notifications(){
    	if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
	    	$emailArr = $this->data['emailArr'];
	    	$notyArr = $this->data['notyArr'];
	    	$emailStr = '';
	    	$notyStr = '';
	    	foreach ($this->input->post() as $key=>$val){
	    		if (in_array($key, $emailArr)){
	    			$emailStr .= $key.',';
	    		}else if (in_array($key, $notyArr)){
	    			$notyStr .= $key.',';
	    		}
	    	}
	    	$updates = $this->input->post('updates');
	    	$updates = ($updates == '')?'0':'1';
	    	$emailStr = substr($emailStr, 0,strlen($emailStr)-1);
	    	$notyStr = substr($notyStr, 0,strlen($notyStr)-1);
	    	$dataArr = array(
	    		'email_notifications'	=>	$emailStr,
	    		'notifications'			=>	$notyStr,
	    		'updates'				=>	$updates
	    	);
	    	$condition = array('id'=>$this->checkLogin('U'));
	    	$this->user_model->update_details(USERS,$dataArr,$condition);
    		if ($updates == 1){
				$checkEmail = $this->user_model->get_all_details(SUBSCRIBERS_LIST,array('subscrip_mail'=>$this->data['userDetails']->row()->email));
				if ($checkEmail->num_rows()==0){
					$this->user_model->simple_insert(SUBSCRIBERS_LIST,array('subscrip_mail'=>$this->data['userDetails']->row()->email,'active'=>1,'status'=>'Active'));
				}
			}else {
				$this->user_model->commonDelete(SUBSCRIBERS_LIST,array('subscrip_mail'=>$this->data['userDetails']->row()->email));
			}
	    	$this->setErrorMessage('success','Notifications settings saved successfully');
	    	redirect(base_url().'settings/notifications');
    	}
    }
    
    public function user_purchases(){
        $this->data['side_menu'] = 5;
    	if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
    		$this->data['heading'] = 'Purchases';
	    	$this->data['purchasesList'] = $this->user_model->get_purchase_details($this->checkLogin('U'));
    		$this->load->view('site/user/user_purchases',$this->data);
    	}
    }
    
    public function user_orders(){
        $this->data['side_menu'] = 6;
    	if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
    		$this->data['heading'] = 'Orders';
	    	$this->data['ordersList'] = $this->user_model->get_user_orders_list($this->checkLogin('U'));
    		$this->load->view('site/user/user_orders_list',$this->data);
    	}
    }
    
    public function manage_fancyybox(){
    	if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
    		$this->data['heading'] = 'Subscriptions';
	    	$this->data['subscribeList'] = $this->user_model->get_subscriptions_list($this->checkLogin('U'));
    		$this->load->view('site/user/manage_fancyybox',$this->data);
    	}
    }
    
    public function shipping_settings(){
        $this->data['side_menu'] = 8;
    	if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
    		$this->data['heading'] = 'Shipping Address';
    		$this->data['countryList'] = $this->user_model->get_all_details(COUNTRY_LIST,array());
	    	$this->data['shippingList'] = $this->user_model->get_all_details(SHIPPING_ADDRESS,array('user_id'=>$this->checkLogin('U')));
    		$this->load->view('site/user/shipping_settings',$this->data);
    	}
    }
    
    public function insertEdit_shipping_address(){
    	if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
    		$shipID = $this->input->post('ship_id');
    		$is_default = $this->input->post('set_default');
    		if ($is_default == ''){
    			$primary = 'No';
    		}else{
    			$primary = 'Yes';
    		}
    		$checkAddrCount = $this->user_model->get_all_details(SHIPPING_ADDRESS,array('user_id'=>$this->checkLogin('U')));
    		if ($checkAddrCount->num_rows == 0){
    			$primary = 'Yes';
    		}
    		$excludeArr = array('ship_id','set_default');
    		$dataArr = array('primary'=>$primary);
    		$condition = array('id'=>$shipID);
    		if ($shipID==''){
    			$this->user_model->commonInsertUpdate(SHIPPING_ADDRESS,'insert',$excludeArr,$dataArr,$condition);
    			$shipID = $this->user_model->get_last_insert_id();
    			$this->setErrorMessage('success','Your Shipping address is added successfully !');
    		}else {
    			$this->user_model->commonInsertUpdate(SHIPPING_ADDRESS,'update',$excludeArr,$dataArr,$condition);
    			$this->setErrorMessage('success','Shipping address updated successfully');
    		}
    		if ($primary == 'Yes'){
	    		$condition = array('id !='=>$shipID,'user_id'=>$this->checkLogin('U'));
    			$dataArr = array('primary'=>'No');
    			$this->user_model->update_details(SHIPPING_ADDRESS,$dataArr,$condition);
    		}else {
    			$condition = array('primary'=>'Yes','user_id'=>$this->checkLogin('U'));
    			$checkPrimary = $this->user_model->get_all_details(SHIPPING_ADDRESS,$condition);
    			if ($checkPrimary->num_rows()==0){
    				$condition = array('id'=>$shipID,'user_id'=>$this->checkLogin('U'));
	    			$dataArr = array('primary'=>'Yes');
	    			$this->user_model->update_details(SHIPPING_ADDRESS,$dataArr,$condition);
    			}
    		}
    		redirect(base_url().'settings/shipping');
    	}
    }
    
    public function get_shipping(){
    	$shipID = $this->input->post('shipID');
    	$shipDetails = $this->user_model->get_all_details(SHIPPING_ADDRESS,array('id'=>$shipID));
    	$returnStr['full_name'] = $shipDetails->row()->full_name;
    	$returnStr['nick_name'] = $shipDetails->row()->nick_name;
    	$returnStr['address1'] = $shipDetails->row()->address1;
    	$returnStr['address2'] = $shipDetails->row()->address2;
    	$returnStr['city'] = $shipDetails->row()->city;
    	$returnStr['state'] = $shipDetails->row()->state;
    	$returnStr['country'] = $shipDetails->row()->country;
    	$returnStr['postal_code'] = $shipDetails->row()->postal_code;
    	$returnStr['phone'] = $shipDetails->row()->phone;
    	$returnStr['primary'] = $shipDetails->row()->primary;
    	echo json_encode($returnStr);
    }
    
    public function remove_shipping_addr(){
    	$returnStr['status_code'] = 0;
    	if ($this->checkLogin('U')==''){
    		$returnStr['message'] = 'You must login';
    	}else {
    		$shipID = $this->input->post('id');
    		$this->user_model->commonDelete(SHIPPING_ADDRESS,array('id'=>$shipID));
    		$returnStr['status_code'] = 1;
    	}
    	echo json_encode($returnStr);
    }

    public function user_credits(){
    	if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
    		$this->data['heading'] = 'My Earnings';
			$orderDetails = $this->data['orderDetails'] = $this->commission->get_total_order_amount($this->checkLogin('U'));
			$commission_to_admin = 0;
			$amount_to_vendor = 0;
			$total_amount = 0;
			$this->data['total_amount'] = $total_amount;
			$total_orders = 0;
			$this->data['except_refunded'] = 0;
    		if ($orderDetails->num_rows()==1){
				$commission_percentage = $this->data['userDetails']->row()->commision;
				$total_amount = $orderDetails->row()->TotalAmt;
				$this->data['total_amount'] = $total_amount;
				$total_amount = $total_amount-$this->data['userDetails']->row()->refund_amount;
				$this->data['except_refunded'] = $total_amount;
				$commission_to_admin = $total_amount*($commission_percentage*0.01);
				if ($commission_to_admin<0)$commission_to_admin=0;
				$amount_to_vendor = $total_amount-$commission_to_admin;
				if ($amount_to_vendor<0)$amount_to_vendor=0;
				$total_orders = $orderDetails->row()->orders;
			}
			$paidDetails = $this->commission->get_total_paid_details($this->checkLogin('U'));
			$paid_to = 0;
			if ($paidDetails->num_rows()==1){
				$paid_to = $paidDetails->row()->totalPaid;
				if ($paid_to<0)$paid_to=0;
			}
			$paid_to_balance = $amount_to_vendor-$paid_to;
			if ($paid_to_balance<0)$paid_to_balance=0;
			$this->data['commission_to_admin'] = $commission_to_admin;
			$this->data['amount_to_vendor'] = $amount_to_vendor;
			$this->data['total_orders'] = $total_orders;
			$this->data['paid_to'] = $paid_to;
			$this->data['paid_to_balance'] = $paid_to_balance;
			$sortArr1 = array('field'=>'date','type'=>'desc');
			$sortArr = array($sortArr1);
			$this->data['paidDetailsList'] = $this->commission->get_all_details(VENDOR_PAYMENT,array('vendor_id'=>$this->checkLogin('U'),'status'=>'success'),$sortArr);
    		$this->load->view('site/user/user_credits',$this->data);
    	}
    }

    public function user_referrals(){
    	if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
		//echo "hi";die;
		$paginationNo = $this->uri->segment('2');
		
		if($paginationNo == '')
		{
			$paginationNo = 0;
		}
		else
		{
			$paginationNo = $paginationNo;
		}
		
		$searchPerPage = $this->config->item('pagination_per_page');
		//echo "DSf".$this->uri->segment('2');die;
		
		$referalBaseUrl = base_url().'referrals';
		
		
		$getReferalListCount = $this->user_model->getReferalList();
		$getReferalList = $this->user_model->getReferalList($searchPerPage,$paginationNo);
		
		$config['base_url'] = $referalBaseUrl;
		$config['total_rows'] = count($getReferalListCount);
		$config["per_page"] = $searchPerPage;
		$config["uri_segment"] =2;
		$this->pagination->initialize($config); 
		$paginationLink = $this->pagination->create_links();//die;
		
		
		
		$this->data['heading'] = 'Referrals';
		$this->data['getReferalList'] = $getReferalList;
		$this->data['paginationLink'] = $paginationLink;
			
			
		//	echo "<pre>";print_r($getReferalList);die;
			
			
//	    	$this->data['purchasesList'] = $this->user_model->get_group_gifts_list($this->checkLogin('U'));
    		$this->load->view('site/user/user_referrals',$this->data);
    	}
    }

    public function user_giftcards(){
    	if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
    		$this->data['heading'] = 'Gift Cards';
	    	$this->data['giftcardsList'] = $this->user_model->get_gift_cards_list($this->data['userDetails']->row()->email);
    		$this->load->view('site/user/user_giftcards',$this->data);
    	}
    }
    
    public function change_photo(){
    	if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
	    	$config['overwrite'] = FALSE;
	    	$config['remove_spaces'] = TRUE;
	    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
	    	$config['max_size'] = 2000;
	    	$config['max_width']  = '600';
			$config['max_height']  = '600';
	    	$config['upload_path'] = './images/users';
	    	$this->load->library('upload', $config);
	    	if ( $this->upload->do_upload('upload-file')){
	    		$imgDetails = $this->upload->data();
	    		$dataArr['thumbnail'] = $imgDetails['file_name'];
	    		$condition = array('id'=>$this->checkLogin('U'));
	    		$this->user_model->update_details(USERS,$dataArr,$condition);
	    		redirect('image-crop/'.$this->checkLogin('U'));
	    	}else {
	    		$this->setErrorMessage('error',strip_tags($this->upload->display_errors()));
	    	}
	    	echo "<script>window.history.go(-1);</script>";
    	}
    }
}

/* End of file user_settings.php */
/* Location: ./application/controllers/site/user_settings.php */