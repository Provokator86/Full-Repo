<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * Fancybox related functions
 * @author Teamtweaks
 *
 */

class Fancybox extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email','text'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('fancybox_model');
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->fancybox_model->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];
		
		if($_SESSION['sColorLists'] == ''){
			$_SESSION['sColorLists'] = $this->fancybox_model->get_all_details(LIST_VALUES,array('list_id'=>'1'));
		}
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];
		
		$this->data['loginCheck'] = $this->checkLogin('U');
    }
    
  
	/**
	 * 
	 * Loading fancy box page
	 */
	
	public function index(){
	 	$this->data['heading'] = 'Fancyy Box'; 
	 	$sortArr1 = array('field'=>'created','type'=>'desc');
	 	$sortArr = array($sortArr1);
	 	$this->data['fancyboxList'] = $this->fancybox_model->get_all_details(FANCYYBOX,array('status'=>'Publish'),$sortArr);
	 	$this->load->view('site/fancybox/display_all_fancyybox.php',$this->data);
	}
	
	
	
	public function display_fancybox(){
		$fid = $this->uri->segment(2,0);
		$this->data['heading'] = 'Fancyy Box'; 
		$sortArr1 = array('field'=>'created','type'=>'desc');
	 	$sortArr = array($sortArr1);
	 	$this->data['relatedProductsArr'] = $this->fancybox_model->get_all_details(FANCYYBOX,array('status'=>'Publish'),$sortArr);
	 	$this->data['fancyboxDetail'] = $this->fancybox_model->get_all_details(FANCYYBOX,array('id'=>$fid));
		if ($this->data['fancyboxDetail']->num_rows == 1){
		 	$this->load->view('site/fancybox/display_fancyybox.php',$this->data);
		}else {
			redirect(base_url());
		}
	}
	
	
	public function cartsubscribe(){
	
		$dataArrVal = array();
		foreach($this->input->post() as $key => $val){
			if(!(in_array($key,$excludeArr))){
				$dataArrVal[$key] = trim(addslashes($val));
			}
		}

		$datestring = date('Y-m-d H:i:s',now());
		$indTotal = ( $this->input->post('price') + $this->input->post('fancy_shipping_cost') + $this->input->post('fancy_tax_cost') ) * $this->input->post('quantity');
		
		$dataArry_data = array('created' => $datestring, 'indtotal' => $indTotal, 'total' => $indTotal);
		$dataArr = array_merge($dataArrVal,$dataArry_data);
		
		//$this->data['SubscribeVal'] = $this->fancybox_model->get_all_details(FANCYYBOX_TEMP,array( 'user_id' => $this->data['common_user_id'],'fancybox_id' => $this->input->post('fancybox_id')));	
		
		
//		if($this->data['SubscribeVal']->num_rows == 0){
			$this->fancybox_model->simple_insert(FANCYYBOX_TEMP,$dataArr);
//		}
		
//		echo '<pre>'; print_r($_POST); die;
		if ( $this->checkLogin('U')!= ''){
			echo $this->fancybox_model->mini_cart_view($this->data['common_user_id']); 
		}else{
			echo 'login';
		}	
	}
	
	public function language_change(){ 
	 
		$language_code= $this->uri->segment('2');
		$selectedLangCode = $this->session->set_userdata('language_code',$language_code);
		redirect('');
		  
	}
	

}

/* End of file user.php */
/* Location: ./application/controllers/site/user.php */