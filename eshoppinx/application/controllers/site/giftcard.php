<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * User related functions
 * @author Teamtweaks
 *
 */

class Giftcard extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model(array('giftcards_model','product_model'));
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->giftcards_model->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];
		
		if($_SESSION['sColorLists'] == ''){
			$_SESSION['sColorLists'] = $this->giftcards_model->get_all_details(LIST_VALUES,array('list_id'=>'1'));
		}
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];
		
		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['likedProducts'] = array();
	 	if ($this->data['loginCheck'] != ''){
	 		$this->data['likedProducts'] = $this->product_model->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
	 	}
    }
    
  
	/**
	 * 
	 * 
	 */
	
	public function index(){
	 	$this->data['heading'] = 'Giftcard'; 
	 	$relatedProducts = $this->product_model->view_product_details(" where p.quantity>0 and p.status='Publish' and u.group='Seller' and u.status='Active' or p.status='Publish' and p.quantity > 0 and p.user_id=0");
		$this->data['relatedProductsArr'] = $relatedProducts->result();
	 	$this->load->view('site/giftcards/giftcards.php',$this->data);
	}
	
	
	/****************** Insert the cart to user********************/
	
	public function insertEditGiftcard(){
	
		
		$dataArrVal = array();
		foreach($this->input->post() as $key => $val){
			if(!(in_array($key,$excludeArr))){
				$dataArrVal[$key] = trim(addslashes($val));
			}
		}

		$datestring = "%Y-%m-%d 23:59:59";
		$code = $this->get_rand_str('10');
		$exp_days = $this->config->item('giftcard_expiry_days');

		$dataArry_data = array('expiry_date' => mdate($datestring,strtotime($exp_days.' days')), 'code' => $code,'user_id' => $this->data['common_user_id']);
		$dataArr = array_merge($dataArrVal,$dataArry_data);
		
		$this->giftcards_model->simple_insert(GIFTCARDS_TEMP,$dataArr);
		
		if ($this->data['loginCheck'] != ''){
			echo $this->giftcards_model->mini_cart_view($this->data['common_user_id']); 
	 	}else{
			echo 'login';
		}
	}
	

}

/* End of file user.php */
/* Location: ./application/controllers/site/user.php */