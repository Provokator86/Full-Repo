<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Shop related functions
 * @author Teamtweaks
 *
 */

class Brand extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));
        $this->load->model('store_model','store');
		$this->load->model('brands_model','mod_brand');
		$this->load->model('product_model','product');
		$this->load->model('user_model','user');
		$this->load->model('stories_model','stories');
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->mod_brand->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];
        /*
		if($_SESSION['sColorLists'] == ''){
			$_SESSION['sColorLists'] = $this->store->get_all_details(LIST_VALUES,array('list_id'=>'1'));
		}
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];

		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['likedProducts'] = array();
		if ($this->data['loginCheck'] != ''){
			$this->data['likedProducts'] = $this->store->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
		}
        */
	}

	public function display_brand($brand_url=''){
		$this->data['heading'] = 'Brands';
		if ($brand_url != ''){
			$this->data['brand_details'] = $this->mod_brand->get_brand_details($brand_url);
            
			if ($this->data['brand_details']->num_rows()>0){
                
                $this->data['checkReq'] = '';

                $this->data['brandlogoDetails'] = $this->mod_brand->get_all_details(BRANDS,array('i_id'=>$this->data['brand_details']->row()->i_id));

                if($this->input->get('pg') != ''){
                    $paginationVal = $this->input->get('pg')*20;
                    $limitPaging = $paginationVal.',20 ';
                } else {
                    $limitPaging = ' 0,20';
                }
                
                $this->data['brandStores'] = $this->mod_brand->get_store_for_brand($this->data['brand_details']->row()->brand_url);
                //pr($this->data['brandStores']);

				$product_ids = array_filter(explode(',', $this->data['brand_details']->row()->products));
                $this->data['tot_products'] = count($product_ids);
				if (count($product_ids)>0){
					$this->data['product_details'] = $this->mod_brand->get_product_details($product_ids,$limitPaging);
				}
                
                
                
                $newPage = $this->input->get('pg')+1;
                $qry_str = '?pg='.$newPage;
                //$url = base_url().'recent'.$qry_str;
                $url = base_url().'brand/'.$brand_url.$qry_str;
                if (count($product_ids)==0) $url = '';
                $paginationDisplay  = '<a title="'.$newPage.'" class="btn-more" href="'.$url.'" style="display: none;">See More Products</a>';
                $this->data['paginationDisplay'] = $paginationDisplay;
                
			}
		}
		//		echo "<pre>";print_r($this->data['store_details']->result());die;
		$this->load->view('site/brand/display_brand',$this->data);
	}

	

	public function display_store_followers($store_url=''){
		$this->data['heading'] = 'Followers';
		if ($store_url != ''){
			$this->data['store_details'] = $this->store->get_all_details(SHOPS,array('store_url'=>$store_url));
				
			$this->data['storelogoDetails'] = $this->store->get_all_details(SHOPS,array('id'=>$this->data['store_details']->row()->id));
			$this->data['claimDetails'] = $this->store->get_all_details(STORE_CLAIMS,array('store_id'=>$this->data['store_details']->row()->id));
				
			if ($this->data['store_details']->row()->user_id==0 && $this->checkLogin('U')!=''){
				$this->data['checkReq'] = $this->store->get_all_details(STORE_CLAIMS,array('user_id'=>$this->checkLogin('U'),'store_id'=>$this->data['store_details']->row()->id));
			}else {
				$this->data['checkReq'] = '';
			}
				
			if ($this->data['store_details']->num_rows()>0){
				$follower_ids = array_filter(explode(',', $this->data['store_details']->row()->followers));
				$this->data['follower_details'] = '';
				if (count($follower_ids)>0){
					$this->data['follower_details'] = $this->store->get_follower_details($follower_ids);
					if ($this->data['follower_details']->num_rows()>0){
						foreach ($this->data['follower_details']->result() as $fid){
							$this->data['follower_product_details'][$fid->id] = $this->product->get_products_by_userid($fid->id,'publish');
						}
					}
				}
			}
		}
		$this->load->view('site/store/display_store_followers',$this->data);
	}

	public function add_follow(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U') != ''){
			$follow_id = $this->input->post('brand_id');
			$followUserDetails = $this->mod_brand->get_all_details(BRANDS,array('i_id'=>$follow_id));
			if ($followUserDetails->num_rows() == 1){
				$followersListArr = explode(',', $followUserDetails->row()->followers);
				if (!in_array($this->checkLogin('U'), $followersListArr)){
					$followersListArr[] = $this->checkLogin('U');
					$newFollowersList = implode(',', $followersListArr);
					$followersCount = $followUserDetails->row()->followers_count;
					$followersCount++;
					$dataArr = array('followers'=>$newFollowersList,'followers_count'=>$followersCount);
					$condition = array('i_id'=>$follow_id);
					$this->mod_brand->update_details(BRANDS,$dataArr,$condition);
				}
			}
			$actArr = array(
					'activity_name'	=>	'follow-brand',
					'activity_id'	=>	$follow_id,
					'user_id'		=>	$this->checkLogin('U'),
					'activity_ip'	=>	$this->input->ip_address()
			);
			$this->mod_brand->simple_insert(USER_ACTIVITY,$actArr);
			$datestring = "%Y-%m-%d %h:%i:%s";
			$time = time();
			$createdTime = mdate($datestring,$time);
			$actArr = array(
					'activity'	=>	'follow-brand',
					'activity_id'	=>	$follow_id,
					'user_id'		=>	$this->checkLogin('U'),
					'activity_ip'	=>	$this->input->ip_address(),
					'created'		=>	$createdTime
			);
			$this->mod_brand->simple_insert(NOTIFICATIONS,$actArr);
			$returnStr['status_code'] = 1;
		}
		echo json_encode($returnStr);
	}

	public function delete_follow(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U') != ''){
			$follow_id = $this->input->post('brand_id');
			$followUserDetails = $this->mod_brand->get_all_details(BRANDS,array('i_id'=>$follow_id));
			if ($followUserDetails->num_rows() == 1){
				$followersListArr = explode(',', $followUserDetails->row()->followers);
				if (in_array($this->checkLogin('U'), $followersListArr)){
					if(($key = array_search($this->checkLogin('U'), $followersListArr)) !== false) {
						unset($followersListArr[$key]);
					}
					$newFollowersList = implode(',', $followersListArr);
					$followersCount = $followUserDetails->row()->followers_count;
					$followersCount--;
					if ($followersCount<0){
						$followersCount = 0;
					}
					$dataArr = array('followers'=>$newFollowersList,'followers_count'=>$followersCount);
					$condition = array('i_id'=>$follow_id);
					$this->mod_brand->update_details(BRANDS,$dataArr,$condition);
				}
			}
			$actArr = array(
					'activity_name'	=>	'unfollow-brand',
					'activity_id'	=>	$follow_id,
					'user_id'		=>	$this->checkLogin('U'),
					'activity_ip'	=>	$this->input->ip_address()
			);
			$this->mod_brand->simple_insert(USER_ACTIVITY,$actArr);
			$returnStr['status_code'] = 1;
		}else {
			$returnStr['status_code'] = 1;
		}
		echo json_encode($returnStr);
	}

	

	public function update_store_name(){
		$product_details = $this->store->get_all_details(USER_PRODUCTS,array('store_name'=>''));
		if ($product_details->num_rows()>0){
			foreach ($product_details->result() as $row){
				$seller_product_id = $row->seller_product_id;
				$store_url = prep_url($row->web_link);
				$store_name = parse_url($store_url,PHP_URL_HOST);
				if ($store_name){
					$check_store_name = $this->store->get_all_details(SHOPS,array('store_url'=>$store_name));
					if ($check_store_name->num_rows()>0){
						$store_products = explode(',', $check_store_name->row()->products);
						$products_count = $check_store_name->row()->products_count;
						if ($products_count<0){
							$products_count = 0;;
						}
						if (!in_array($seller_product_id, $store_products)){
							$store_products[] = $seller_product_id;
							$products_count++;
						}
						$dataArr = array('products'=>implode(',', $store_products),'products_count'=>$products_count);
						$condArr = array('store_url'=>$store_name);
						$this->store->update_details(SHOPS,$dataArr,$condArr);
					}else {
						$dataArr = array('store_name'=>$store_name,'store_url'=>$store_name,'products'=>$seller_product_id,'products_count'=>1);
						$this->store->simple_insert(SHOPS,$dataArr);
					}
					$this->store->update_details(USER_PRODUCTS,array('store_name'=>$store_name),array('seller_product_id'=>$seller_product_id));
					echo $store_name.'<p>';
				}
			}
		}
		echo("done");
	}

	public function update_store_url(){
		$store_list = $this->store->get_all_details(SHOPS,array('store_url'=>'','store_name !='=>''));
		if ($store_list->num_rows()>0){
			foreach ($store_list->result() as $row){
				$this->store->update_details(SHOPS,array('store_url'=>$row->store_name),array('id'=>$row->id));
			}
			echo 'Updated';
		}else {
			echo 'No records';
		}
	}
}
/*End of file store.php */
/* Location: ./application/controllers/site/store.php */