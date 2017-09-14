<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Shop related functions
 * @author Teamtweaks
 *
 */

class Store extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));
		$this->load->model('store_model','store');
		$this->load->model('product_model','product');
		$this->load->model('user_model','user');
		$this->load->model('stories_model','stories');
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->store->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];

		if($_SESSION['sColorLists'] == ''){
			$_SESSION['sColorLists'] = $this->store->get_all_details(LIST_VALUES,array('list_id'=>'1'));
		}
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];

		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['likedProducts'] = array();
		if ($this->data['loginCheck'] != ''){
			$this->data['likedProducts'] = $this->store->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
		}
	}

	public function display_store($store_url=''){
		$this->data['heading'] = 'Stores';
		if ($store_url != ''){
			$this->data['store_details'] = $this->store->get_store_details($store_url);
			if ($this->data['store_details']->num_rows()>0){
				if ($this->data['store_details']->row()->user_id==0 && $this->checkLogin('U')!=''){
					$this->data['checkReq'] = $this->store->get_all_details(STORE_CLAIMS,array('user_id'=>$this->checkLogin('U'),'store_id'=>$this->data['store_details']->row()->id));
				}else {
					$this->data['checkReq'] = '';
				}

				$this->data['storelogoDetails'] = $this->store->get_all_details(SHOPS,array('id'=>$this->data['store_details']->row()->id));

				$this->data['claimDetails'] = $this->store->get_all_details(STORE_CLAIMS,array('store_id'=>$this->data['store_details']->row()->id));

				$product_ids = array_filter(explode(',', $this->data['store_details']->row()->products));
				if (count($product_ids)>0){
					$this->data['product_details'] = $this->store->get_product_details($product_ids);
				}
			}
		}
		//		echo "<pre>";print_r($this->data['store_details']->result());die;
		$this->load->view('site/store/display_store',$this->data);
	}

	/*public function claim_update()
	{
		$store_id = $this->uri->segment(4,0);
		$this->data['claimDetails'] = $this->store->get_all_details(STORE_CLAIMS,array('store_id'=>$store_id));
		$this->data['shopsDetails'] = $this->store->get_all_details(SHOPS,array('id'=>$store_id));
		$this->load->view('site/store/claim_store_edit',$this->data);
	}*/
	
	public function claim_update()
	{
		$store_id = $this->uri->segment(4,0);
		$this->data['shopsDetails'] = $this->store->get_all_details(SHOPS,array('id'=>$store_id));
		//$this->data['claimDetails'] = $this->store->get_all_details(STORE_CLAIMS,array('store_id'=>$store_id));
		$this->data['claimDetails'] = $this->store->get_all_details(STORE_CLAIMS,array('store_id'=>$store_id,'status'=>'approved'));
		$this->load->view('site/store/claim_store_edit',$this->data);
	}

	public function claim_edit_function()
	{
		//$store_id = $this->uri->segment(4,0);
		$store_id = $this->input->post('store_id'); //die;
		$store_name = $this->input->post('store_name');
		$excludeArr = array("seller_id");
		$dataArr = array();
		$condition = array('store_id' => $store_id);
		$condition1 = array('id' => $store_id);

		$this->data['shopsDetails'] = $this->store->get_all_details(SHOPS,array('id'=>$store_id));

		$this->store->commonInsertUpdate(STORE_CLAIMS,'update',$excludeArr,$dataArr,$condition);

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
		$dataArr['store_name'] = $store_name;
		$this->store->commonInsertUpdate(SHOPS,'update',$excludeArr,$dataArr,$condition1);
		//$this->load->view('site/store/claim_store_edit',$this->data);
		//echo $this->data['shopsDetails']->row()->store_url; die;
		redirect('store/'.$this->data['shopsDetails']->row()->store_url);
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
			$follow_id = $this->input->post('store_id');
			$followUserDetails = $this->store->get_all_details(SHOPS,array('id'=>$follow_id));
			if ($followUserDetails->num_rows() == 1){
				$followersListArr = explode(',', $followUserDetails->row()->followers);
				if (!in_array($this->checkLogin('U'), $followersListArr)){
					$followersListArr[] = $this->checkLogin('U');
					$newFollowersList = implode(',', $followersListArr);
					$followersCount = $followUserDetails->row()->followers_count;
					$followersCount++;
					$dataArr = array('followers'=>$newFollowersList,'followers_count'=>$followersCount);
					$condition = array('id'=>$follow_id);
					$this->store->update_details(SHOPS,$dataArr,$condition);
				}
			}
			$actArr = array(
					'activity_name'	=>	'follow-store',
					'activity_id'	=>	$follow_id,
					'user_id'		=>	$this->checkLogin('U'),
					'activity_ip'	=>	$this->input->ip_address()
			);
			$this->store->simple_insert(USER_ACTIVITY,$actArr);
			$datestring = "%Y-%m-%d %h:%i:%s";
			$time = time();
			$createdTime = mdate($datestring,$time);
			$actArr = array(
					'activity'	=>	'follow-store',
					'activity_id'	=>	$follow_id,
					'user_id'		=>	$this->checkLogin('U'),
					'activity_ip'	=>	$this->input->ip_address(),
					'created'		=>	$createdTime
			);
			$this->store->simple_insert(NOTIFICATIONS,$actArr);
			$returnStr['status_code'] = 1;
		}
		echo json_encode($returnStr);
	}

	public function delete_follow(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U') != ''){
			$follow_id = $this->input->post('store_id');
			$followUserDetails = $this->store->get_all_details(SHOPS,array('id'=>$follow_id));
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
					$condition = array('id'=>$follow_id);
					$this->store->update_details(SHOPS,$dataArr,$condition);
				}
			}
			$actArr = array(
					'activity_name'	=>	'unfollow-store',
					'activity_id'	=>	$follow_id,
					'user_id'		=>	$this->checkLogin('U'),
					'activity_ip'	=>	$this->input->ip_address()
			);
			$this->store->simple_insert(USER_ACTIVITY,$actArr);
			$returnStr['status_code'] = 1;
		}else {
			$returnStr['status_code'] = 1;
		}
		echo json_encode($returnStr);
	}

	public function display_trending_products($store_url=''){
		$this->data['heading'] = 'Stores';
		if ($store_url != ''){
			$this->data['store_details'] = $this->store->get_all_details(SHOPS,array('store_url'=>$store_url));
			if ($this->data['store_details']->num_rows()>0){
				if ($this->data['store_details']->row()->user_id==0 && $this->checkLogin('U')!=''){
					$this->data['checkReq'] = $this->store->get_all_details(STORE_CLAIMS,array('user_id'=>$this->checkLogin('U'),'store_id'=>$this->data['store_details']->row()->id));
				}else {
					$this->data['checkReq'] = '';
				}
				$product_ids = array_filter(explode(',', $this->data['store_details']->row()->products));
                
				$this->data['storelogoDetails'] = $this->store->get_all_details(SHOPS,array('id'=>$this->data['store_details']->row()->id));
				$this->data['claimDetails'] = $this->store->get_all_details(STORE_CLAIMS,array('store_id'=>$this->data['store_details']->row()->id));

				if (count($product_ids)>0){
					$this->data['product_details'] = $this->store->get_trending_products($product_ids);
				}
			}
		}
		$this->load->view('site/store/display_trending_products',$this->data);
	}

	/*public function display_trending_products($store_url=''){
		$this->data['heading'] = 'Stores';
		if ($store_url != ''){
		$this->data['store_details'] = $this->store->get_all_details(SHOPS,array('store_url'=>$store_url));
		if ($this->data['store_details']->num_rows()>0){
		$product_ids = array_filter(explode(',', $this->data['store_details']->row()->products));

		$this->data['storelogoDetails'] = $this->store->get_all_details(SHOPS,array('id'=>$this->data['store_details']->row()->id));
		$this->data['claimDetails'] = $this->store->get_all_details(STORE_CLAIMS,array('store_id'=>$this->data['store_details']->row()->id));

		if (count($product_ids)>0){
		$this->data['product_details'] = $this->store->get_trending_products($product_ids);
		}
		}
		}
		//		echo "<pre>";print_r($this->data['store_details']->result());die;
		$this->load->view('site/store/display_trending_products',$this->data);
		}*/

	public function display_collections($store_url='')
	{
		//echo $this->uri->segment(2,0); exit;
		$store_url =  $this->uri->segment(2,0);

		$this->data['store_details'] = $this->store->get_all_details(SHOPS,array('store_url'=>$store_url));
		$userProfileDetails = $this->store->get_all_details(USERS,array('id'=>$this->data['store_details']->row()->user_id));
		//$userProfileDetails = $this->user_model->get_all_details(USERS,array('user_name'=>$username));
		if ($userProfileDetails->num_rows()==1){
			if ($userProfileDetails->row()->visibility == 'Only you' && $userProfileDetails->row()->id != $this->checkLogin('U')){
				$this->load->view('site/user/display_user_profile_private',$this->data);
			}else {
				$this->data['heading'] = $username;
				$this->data['userProfileDetails'] = $userProfileDetails;
				$this->data['recentActivityDetails'] = $this->user->get_activity_details($userProfileDetails->row()->id);

				$this->data['storelogoDetails'] = $this->store->get_all_details(SHOPS,array('id'=>$this->data['store_details']->row()->id));
				$this->data['claimDetails'] = $this->store->get_all_details(STORE_CLAIMS,array('store_id'=>$this->data['store_details']->row()->id));

				$this->data['listDetails'] = $this->product_model->get_all_details(LISTS_DETAILS,array('user_id'=>$userProfileDetails->row()->id));
				if ($this->data['listDetails']->num_rows()>0){
					foreach ($this->data['listDetails']->result() as $listDetailsRow){
						$this->data['listImg'][$listDetailsRow->id] = '';
						if ($listDetailsRow->product_id != ''){
							$returnCnt['product_lists'] = $pidArr = array_filter(explode(',', $listDetailsRow->product_id));

							$returnCnt['prodDetails'][$listDetailsRow->id] = '';

							if (count($pidArr)>0){
								$product_id_str = '';
								foreach ($pidArr as $pid_row){
									if ($pid_row != ''){
										$product_id_str .= $pid_row.',';
									}
								}
								$product_id_str = substr($product_id_str, 0,-1);

								$addedProductDetails = $this->product_model->view_product_details(" where p.status='Publish' and p.seller_product_id in (".$product_id_str.")");
								$notSellProducts = $this->product_model->view_notsell_product_details(" where p.status='Publish' and p.seller_product_id in (".$product_id_str.")");
								$returnCnt['prodDetails'][$listDetailsRow->id] = $this->product_model->get_sorted_array($addedProductDetails,$notSellProducts,'created','desc');
							}
						}
					}
				}
				$this->data['product_lists']=$returnCnt['product_lists'];
				$this->data['prodDetails']=$returnCnt['prodDetails'];
				$this->load->view('site/store/display_collections',$this->data);
			}
		}else {
			redirect(base_url());
		}
		//$this->load->view('site/store/display_collections',$this->data);
	}

	public function display_stories($store_url='')
	{
		$store_url =  $this->uri->segment(2,0);
		$this->data['store_details'] = $this->store->get_all_details(SHOPS,array('store_url'=>$store_url));
		//$userProfileDetails = $this->store->get_all_details(USERS,array('user_name'=>urldecode($username)));
		$userProfileDetails = $this->store->get_all_details(USERS,array('id'=>$this->data['store_details']->row()->user_id));
		if ($userProfileDetails->num_rows()==1){
			if ($userProfileDetails->row()->visibility == 'Only you' && $userProfileDetails->row()->id != $this->checkLogin('U')){
				$this->load->view('site/user/display_user_profile_private',$this->data);
			}else {
				$this->data['heading'] = urldecode($username);
				$this->data['userProfileDetails'] = $userProfileDetails;
				$this->data['recentActivityDetails'] = $this->user->get_activity_details($userProfileDetails->row()->id);
				$condition='s.status ="Publish" and s.user_id="'.$userProfileDetails->row()->id.'"';
				$this->data['stories_details'] = $this->stories->get_all_StoresDetails($condition);

				$this->data['storelogoDetails'] = $this->store->get_all_details(SHOPS,array('id'=>$this->data['store_details']->row()->id));
				$this->data['claimDetails'] = $this->store->get_all_details(STORE_CLAIMS,array('store_id'=>$this->data['store_details']->row()->id));

				if ($this->data['stories_details']->num_rows()>0){
					foreach($this->data['stories_details']->result() as $getstories_details){

						$this->data['ProductDetails'][$getstories_details->id] = '';
						if ($getstories_details->seller_product_id != ''){
							$this->data['ProductDetails'][$getstories_details->id]= $this->stories->get_all_StoriesProduct($getstories_details->seller_product_id);
						}

						$this->data['storiesComment'][$getstories_details->id] = '';

						$this->data['storiesComment'][$getstories_details->id] = $this->stories->view_stories_comments_details('where c.stories_id='.$getstories_details->id.' order by c.dateAdded desc ');

					}
				}
				$users_list = $this->stories->get_all_details(USERS,array('status'=>'Active'));
				$users_list_arr = array();
				if ($users_list->num_rows()>0){
					foreach ($users_list->result() as $row){
						$users_list_arr[] = $row->user_name;
					}
				}
				$this->data['users_list'] = $users_list_arr;
				//echo "<pre>"; print_r($this->data['users_list']);die;
				$this->load->view('site/store/display_stories',$this->data);
			}
		}else {
			redirect(base_url());
		}
	}

	public function display_store_claim($store_url=''){
		if ($this->checkLogin('U') != ''){
			$this->data['heading'] = 'Claim Store';
			if ($store_url != ''){
				$this->data['store_details'] = $this->store->get_all_details(SHOPS,array('store_url'=>$store_url));
				if ($this->data['store_details']->num_rows()>0){
					if ($this->data['store_details']->row()->user_id == 0){
						$check_request = $this->store->get_all_details(STORE_CLAIMS,array('user_id'=>$this->checkLogin('U'),'store_id'=>$this->data['store_details']->row()->id));
						if ($check_request->num_rows()==0){
							$this->load->view('site/store/claim_store',$this->data);
						}else {
							$this->setErrorMessage('error','You already requested');
							redirect('store/'.$this->data['store_details']->row()->store_url);
						}
					}else {
						$this->setErrorMessage('error','Someone already claimed this store');
						redirect('store/'.$this->data['store_details']->row()->store_url);
					}
				}else {
					$this->setErrorMessage('error','Store not found');
					redirect('stores');
				}
			}
		}else {
			redirect('login');
		}
	}

	public function claim_store(){
		if ($this->checkLogin('U')!=''){
			$store_id = $this->input->post('store_id');
			if ($store_id!=''){
				$check_availability = $this->store->get_all_details(SHOPS,array('id'=>$store_id));
				if ($check_availability->num_rows()>0){
					if ($check_availability->row()->user_id == 0){
						$check_request = $this->store->get_all_details(STORE_CLAIMS,array('user_id'=>$this->checkLogin('U'),'store_id'=>$store_id));
						if ($check_request->num_rows()==0){
							$dataArr = array('status'=>'pending','user_id'=>$this->checkLogin('U'));
							$excludeArr = array('documentation','full_name');
								
							//Upload document
							$config['overwrite'] = FALSE;
							$config['remove_spaces'] = TRUE;
							$config['allowed_types'] = '*';
							//$config['max_size'] = 2000;
							$config['upload_path'] = './store';
							$this->load->library('upload', $config);
							if ( $this->upload->do_upload('documentation')){
								$docDetails = $this->upload->data();
								$dataArr['document'] = $docDetails['file_name'];
								$this->store->commonInsertUpdate(STORE_CLAIMS,'insert',$excludeArr,$dataArr);
								$this->store->update_details(USERS,array('full_name'=>$this->input->post('full_name')),array('id'=>$this->checkLogin('U')));
								//$this->send_claim_request_notification_to_admin();
								$this->setErrorMessage('success','We received your request and will contact you shortly');
								redirect('store/'.$check_availability->row()->store_url);
							}else {
								$this->setErrorMessage('error',strip_tags($this->upload->display_errors()));
								redirect('store/'.$check_availability->row()->store_url.'/claim');
							}

						}else {
							$this->setErrorMessage('error','You already requested');
							redirect('store/'.$check_availability->row()->store_url);
						}
					}else {
						$this->setErrorMessage('error','Someone already claimed this store.');
						redirect('store/'.$check_availability->row()->store_url);
					}
				}else {
					$this->setErrorMessage('error','Something went wrong. Clear your browser cache and try again');
					redirect('stores');
				}
			}else {
				$this->setErrorMessage('error','Something went wrong. Clear your browser cache and try again');
				redirect('stores');
			}
		}else {
			redirect('login');
		}
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