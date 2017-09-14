<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Tags related functions
 * @author Teamtweaks
 *
 */

class Tags extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));
		$this->load->model('tags_model');
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->tags_model->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];

		if($_SESSION['sColorLists'] == ''){
			$_SESSION['sColorLists'] = $this->tags_model->get_all_details(LIST_VALUES,array('list_id'=>'1'));
		}
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];

		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['likedProducts'] = array();
		if ($this->data['loginCheck'] != ''){
			$this->data['likedProducts'] = $this->tags_model->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
		}
	}

	public function tag_follow(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U') != ''){
			$follow_id = $this->input->post('tid');
			$this->data['tagDetails'] = $this->tags_model->get_all_details(TAGS_PRODUCT,array('tag_id'=>$follow_id));
			$followingListArr = explode(',', $this->data['tagDetails']->row()->followers);
			if (!in_array($this->checkLogin('U'), $followingListArr)){
				$followingListArr[] = $this->checkLogin('U');
				$newFollowingList = implode(',', $followingListArr);
				$followingCount = $this->data['tagDetails']->row()->followers_count;
				$followingCount++;
				$dataArr = array('followers'=>$newFollowingList,'followers_count'=>$followingCount);
				$condition = array('tag_id'=>$follow_id);
				$this->tags_model->update_details(TAGS_PRODUCT,$dataArr,$condition);
					
				$returnStr['status_code'] = 1;
			}else {
				$returnStr['status_code'] = 1;
			}
		}
		echo json_encode($returnStr);
	}


	public function tag_unfollow(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U') != ''){
			$follow_id = $this->input->post('tid');
			$this->data['tagDetails'] = $this->tags_model->get_all_details(TAGS_PRODUCT,array('tag_id'=>$follow_id));
			$followingListArr = explode(',', $this->data['tagDetails']->row()->followers);
			if (in_array($this->checkLogin('U'), $followingListArr)){
				if(($key = array_search($this->checkLogin('U'), $followingListArr)) !== false) {
					unset($followingListArr[$key]);
				}
				$newFollowingList = implode(',', $followingListArr);
				$followingCount = $this->data['tagDetails']->row()->followers_count;
				$followingCount--;
				$dataArr = array('followers'=>$newFollowingList,'followers_count'=>$followingCount);
				$condition = array('tag_id'=>$follow_id);
				$this->tags_model->update_details(TAGS_PRODUCT,$dataArr,$condition);
				$returnStr['status_code'] = 1;
			}else {
				$returnStr['status_code'] = 1;
			}
		}
		echo json_encode($returnStr);
	}

	public function display_tag_stories(){
		$tag_name =  $this->uri->segment(2,0);
		$this->data['tag_details'] = $tagDetails = $this->tags_model->get_all_details(TAGS_PRODUCT,array('tag_name'=>'#'.$tag_name));
		// echo "<pre>"; print_r($tagDetails->result());die;

		// only for stories  start
		if ($tagDetails->num_rows()==1){
				
			$this->data['heading'] = 'Tag/Stories';
			$this->data['tagDetails'] = $tagDetails;
			$stories_idArr = explode(',', $this->data['tagDetails']->row()->stories);
			if (count($stories_idArr)>0){
				$stories_id_str = '';
				foreach ($stories_idArr as $sid_row){
					if ($sid_row != ''){
						$stories_id_str .= $sid_row.',';
					}
				}
				$stories_id_str = substr($stories_id_str, 0,-1);
				$this->data['stories_details'] = $stories_details = $this->tags_model->get_stories_details($stories_id_str);
				if ($this->data['stories_details']->num_rows()>0){
					foreach($this->data['stories_details']->result() as $getstories_details){
						$this->data['ProductDetails'][$getstories_details->id] = '';
						if ($getstories_details->seller_product_id != ''){
							$this->data['ProductDetails'][$getstories_details->id]= $this->tags_model->get_all_StoriesProduct($getstories_details->seller_product_id);
						}
						$this->data['storiesComment'][$getstories_details->id] = '';
						$this->data['storiesComment'][$getstories_details->id] = $this->tags_model->view_stories_comments_details('where c.stories_id='.$getstories_details->id.' order by c.dateAdded desc ');
					}
				}
					
			}
			$users_list = $this->tags_model->get_all_details(USERS,array('status'=>'Active'));
			$users_list_arr = array();
			if ($users_list->num_rows()>0){
				foreach ($users_list->result() as $row){
					$users_list_arr[] = $row->user_name;
				}
			}
			$this->data['users_list'] = $users_list_arr;
			//echo "<pre>"; print_r($this->data['users_list']);die;
			$this->load->view('site/tag/display_tag_stories',$this->data);
		}else {
			redirect(base_url());
		}
	}

	public function display_tag_products(){
		$tag_name = $this->uri->segment(2);
		if ($tag_name != ''){
			$this->data['tag_details'] = $tag_details = $this->tags_model->get_all_details(TAGS_PRODUCT,array('tag_name'=>'#'.$tag_name));
			$pidArr = array_filter(explode(',', $tag_details->row()->products));
			if (count($pidArr)>0){
				$product_id_str = '';
				foreach ($pidArr as $pid_row){
					if ($pid_row != ''){
						$product_id_str .= $pid_row.',';
					}
				}
				$product_id_str = substr($product_id_str, 0,-1);
				$tagSellerProducts = $this->tags_model->view_tag_seller_products(" where p.status='Publish' and p.seller_product_id in (".$product_id_str.")");
				$tagUserProducts = $this->tags_model->view_tag_user_products(" where p.status='Publish' and p.seller_product_id in (".$product_id_str.")");
				$this->data['tagProdDetails'] = $this->tags_model->get_sorted_array($tagSellerProducts,$tagUserProducts,'created','desc');
					
				//only for stories and stories count
				$stories_idArr = explode(',', $this->data['tag_details']->row()->stories);
				if (count($stories_idArr)>0){
					$stories_id_str = '';
					foreach ($stories_idArr as $sid_row){
						if ($sid_row != ''){
							$stories_id_str .= $sid_row.',';
						}
					}
					$stories_id_str = substr($stories_id_str, 0,-1);
					$this->data['stories_details'] = $stories_details = $this->tags_model->get_stories_details($stories_id_str);
				}
				//end
			}
			$this->load->view('site/tag/display_tag_products',$this->data);
		}else {
			$this->setErrorMessage('error','Tag doesnot exists');
			redirect(base_url());
		}
	}
	public function display_tag_followers(){

		$tag_name = $this->uri->segment(2);
		if ($tag_name != ''){
			$this->data['tag_details'] = $tag_details = $this->tags_model->get_all_details(TAGS_PRODUCT,array('tag_name'=>'#'.$tag_name));
			$fieldsArr = array('*');
			$searchName = 'id';
			$searchArr = explode(',', $this->data['tag_details']->row()->followers);
			$joinArr = array();
			$sortArr = array();
			$limit = '';
			$this->data['followingUserDetails'] = $followingUserDetails = $this->tags_model->get_fields_from_many(USERS,$fieldsArr,$searchName,$searchArr,$joinArr,$sortArr,$limit);
			$this->data['followersCount'] = $followingUserDetails->num_rows();
			//echo $this->data['followersCount'];die;
			if ($followingUserDetails->num_rows()>0){
				foreach ($followingUserDetails->result() as $followingUserRow){
					$this->data['followingUserLikeDetails'][$followingUserRow->id] = $this->tags_model->get_products_by_userid($followingUserRow->id,'publish');
				}
			}
			//	echo '<pre>';print_r($this->data['followingUserLikeDetails']);die;
				
			$this->load->view('site/tag/display_tag_followers',$this->data);
				
		}else {
			$this->setErrorMessage('error','Tag doesnot exists');
			redirect(base_url());
		}
	}
}
/*End of file tags.php */
/* Location: ./application/controllers/site/tags.php */