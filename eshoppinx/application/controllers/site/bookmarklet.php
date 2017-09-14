<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * Bookmarklet related functions
 * @author Teamtweaks
 *
 */

class Bookmarklet extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('product_model','product');
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->product->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];
		
		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['likedProducts'] = array();
	 	if ($this->data['loginCheck'] != ''){
	 		$this->data['likedProducts'] = $this->product->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
	 	}
    }
    
	public function index(){
		$uid = $this->input->get('u');
		$this->data['uid'] = $uid;
   		$this->load->view('site/bookmarklet/display_bookmarklet',$this->data);
    }
    
    public function display_bookmarklet(){
    	if ($this->checkLogin('U')==''){
    		redirect('login');
    	}else {
    		//if ($this->data['userDetails']->row()->group == 'Seller'){
		    	$this->data['heading'] = 'Bookmarklet';
    			$this->load->view('site/bookmarklet/display_bookmarklet_button',$this->data);
    		/*}else {
    			redirect('create-brand');
    		}*/
    	}
    }
    
    public function add_bookmarklet_product(){
    	$returnStr['status_code'] = 0;
    	$returnStr['message'] = '';
    	$img_details = getimagesize($this->input->post('photo_url'));
    	if (is_array($img_details)){
    		if($img_details[0]>149 || $img_details[1]>149){
    		 
		    	$seller_product_id = mktime();
				$checkId = $this->check_product_id($seller_product_id);
				while ($checkId->num_rows()>0){
					$seller_product_id = mktime();
					$checkId = $this->check_product_id($seller_product_id);
				}
				$image_name = $this->input->post('photo_url');
				if ($this->input->post('photo_url')!=''){
					
					/****----------Move image to server-------------****/
									
					$image_url = trim(addslashes($this->input->post('photo_url')));
					
					$img_data = file_get_contents($image_url);
					
					$img_full_name = substr($image_url, strrpos($image_url, '/')+1);
					$img_name_arr = explode('.', $img_full_name);
					$img_name = $img_name_arr[0];
					$ext = $img_name_arr[1];
					$ext_arr = explode('?', $ext);
					$ext = $ext_arr[0];
					if ($ext == ''){
						$ext = 'jpg';
					}
					$str_arr = array(',','$','(',')','`','~');
					$new_name = str_replace($str_arr, '', $img_name.mktime().'.'.$ext);
					$new_img = 'images/product/'.$new_name;
			
					file_put_contents($new_img, $img_data);
					
					/****----------Move image to server-------------****/
					
					$image_name = $new_name;
					
					//$this->imageResizeWithSpace(200, 200, $image_name, './images/product/');
					$this->crop_and_resize_image(200, 200, './images/product/', $image_name, './images/product/thumb/');
					
				}else {
					$image_name = 'dummyProductImage.jpg';
				}
				$dataArr = array(
					'product_name'	=>	$this->input->post('name'),
					'seourl'		=>	url_title($this->input->post('name'),'-'),
					'web_link'		=>	$this->input->post('link'),
					'category_id'	=>	$this->input->post('category'),
					'image'			=>	$image_name,
					'price'			=>	$this->input->post('price'),
					'user_id'		=>	$this->input->post('uid'),
					'seller_product_id' => $seller_product_id
				);
				$this->product->simple_insert(USER_PRODUCTS,$dataArr);
				$returnStr['status_code'] = 1;
				$userDetails = $this->product->get_all_details(USERS,array('id'=>$this->input->post('uid')));
				$total_added = $userDetails->row()->products;
				$total_added++;
				$this->product->update_details(USERS,array('products'=>$total_added),array('id'=>$this->input->post('uid')));
				$returnStr['thing_url'] = base_url().'user/'.$userDetails->row()->user_name.'/things/'.$seller_product_id.'/'.url_title($this->input->post('name'),'-');
    		}else {
    			$returnStr['message'] = 'Selected image is too small. Please choose another image';
    		}
    	}else {
    		$returnStr['message'] = 'Can\'t able to upload image. Please choose another image';
    	}
		echo json_encode($returnStr);
    }
    
	public function check_product_id($pid=''){
		$checkId = $this->product->get_all_details(USER_PRODUCTS,array('seller_product_id'=>$pid));
		if ($checkId->num_rows()==0){
			$checkId = $this->product->get_all_details(PRODUCT,array('seller_product_id'=>$pid));
		}
		return $checkId;
	}
    
}
/*End of file bookmarklet.php */
/* Location: ./application/controllers/site/bookmarklet.php */