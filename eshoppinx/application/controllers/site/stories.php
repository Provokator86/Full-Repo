<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Stories related functions
 * @author Teamtweaks
 *
 */

class Stories extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));
		$this->load->model('stories_model');
		$this->load->model('product_model');
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->stories_model->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];
/*		$report_issues = $this->product_model->get_all_details(REPORT_LINKS,array('status'=>'Active'));
			if($report_issues->num_rows() >0){
				$this->data['report_issues'] = $report_issues;
			}
*/		if($_SESSION['sColorLists'] == ''){
			$_SESSION['sColorLists'] = $this->stories_model->get_all_details(LIST_VALUES,array('list_id'=>'1'));
		}
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];

		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['likedProducts'] = array();
		if ($this->data['loginCheck'] != ''){
			$this->data['likedProducts'] = $this->stories_model->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
			$this->data['collectionProducts'] = $this->stories_model->get_collection_products('all',$this->data['loginCheck']);
			//	 		echo "<pre>";print_r($this->data['collectionProducts']);die;
		}
	}

	public function index(){
		$this->data['heading'] = 'Stories';
		$condition='s.status ="Publish"';
		$this->data['stories_details'] = $this->stories_model->get_all_StoresDetails($condition);

		//echo '<pre>';print_r($this->data['stories_details']->result());die;
		foreach($this->data['stories_details']->result() as $getstories_details){

			$this->data['ProductDetails'][$getstories_details->id] = '';
			if ($getstories_details->seller_product_id != ''){
				$this->data['ProductDetails'][$getstories_details->id]= $this->stories_model->get_all_StoriesProduct($getstories_details->seller_product_id);
			}

			$this->data['storiesComment'][$getstories_details->id] = '';

			$this->data['storiesComment'][$getstories_details->id] = $this->stories_model->view_stories_comments_details('where c.stories_id='.$getstories_details->id.' order by c.dateAdded desc');

		}
		$this->data['topStores'] = $this->product_model->get_top_stores();
		$this->data['topPeople'] = $this->product_model->get_top_people();
		$this->load->view('site/stories/display_stories_list',$this->data);

	}

	public function insert_stories_comment(){
		$uid= $this->checkLogin('U');
		$returnStr['status_code'] = 0;
		$comments = $this->input->post('comments');
		$product_id = $this->input->post('cproduct_id');
		$datestring = "%Y-%m-%d %h:%i:%s";
		$time = time();
		$conditionArr = array('comments'=>$comments,'user_id'=>$uid,'stories_id'=>$product_id,'status'=>'InActive','dateAdded'=>mdate($datestring,$time));
		$this->stories_model->simple_insert(STORIES_COMMENTS,$conditionArr);
		$cmtID = $this->stories_model->get_last_insert_id();
		$datestring = "%Y-%m-%d %h:%i:%s";
		 $time = time();
		 $createdTime = mdate($datestring,$time);
		 $actArr = array(
		 'activity'		=>	'own-story-comment',
		 'activity_id'	=>	$product_id,
		 'user_id'		=>	$this->checkLogin('U'),
		 'activity_ip'	=>	$this->input->ip_address(),
		 'created'		=>	$createdTime,
		 'comment_id'	=> $cmtID
		 );
		 $this->stories_model->simple_insert(NOTIFICATIONS,$actArr);
		 //$this->send_comment_noty_mail($cmtID,$product_id);
		$returnStr['status_code'] = 1;
		echo json_encode($returnStr);
	}


	public function add_stories_form(){
		if ($this->checkLogin('U')==''){
			redirect('login');
		}else {
			$this->data['heading'] = 'Stories';
			$this->load->view('site/stories/add_new_story',$this->data);
		}
	}

	public function get_collection_products(){
		$cid = $this->input->post(cid);
		$returnStr['content'] = '';
		if ($cid != ''){
			$collection_details = $this->stories_model->get_collection_products($cid);
			$pid_count = 0;
			if ($collection_details['list_products'] != '' && count($collection_details['list_products'])>0){
				foreach ($collection_details['list_products'] as $list_product_row){
					$pid_count++; //if ($pid_count>9)break;
					$prodImg = 'dummyProductImage.jpg';
					$prodImgArr = array_filter(explode(',', $list_product_row->image));
					if (count($prodImgArr)>0){
						foreach ($prodImgArr as $prodImgRow){
							if (file_exists('images/product/'.$prodImgRow)){
								$prodImg = $prodImgRow;break;
							}
						}
					}
					$returnStr['content'].='<div onclick="javascript:select_product(this)" data-pid="'.$list_product_row->seller_product_id.'" class="stories-new-save">
	                                                <img width="200" height="200"  src="images/product/'.$prodImg.'" itemprop="image" class="product-image product-x200" alt="'.$list_product_row->product_name.'">
	                                                <span class="stories-new-icon round-selector">
	                                                <i class="icon-ok"></i>
	                                                <i class="icon-remove"></i>
	                                                </span>
                                                </div>';
				}
			}
		}
		echo json_encode($returnStr);
	}

	public function delete_comment(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U')!=''){
			$cid = $this->input->post('cid');
			$this->stories_model->commonDelete(STORIES_COMMENTS,array('id'=>$cid));
			$this->stories_model->commonDelete(NOTIFICATIONS,array('comment_id'=>$cid,'activity'=>'own-story-comment'));
			$returnStr['status_code'] = 1;
		}
		echo json_encode($returnStr);
	}
	
	
	
	public function delete_full_stories(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U')!=''){
			$story_id = $this->input->post('sid');
			$this->stories_model->commonDelete(STORIES,array('id'=>$story_id));
			$this->stories_model->commonDelete(STORIES_COMMENTS,array('stories_id'=>$story_id));
			$returnStr['status_code'] = 1;
		}
		echo json_encode($returnStr);
	}
	
	public function add_new_story(){
		if ($this->checkLogin('U')!=''){
			$uid = $this->checkLogin('U');
			$description = $this->input->post('story_body');
			if ($description == ''){
				$this->setErrorMessage('error','Please say something about description');
				echo "<script>window.history.go(-1);</script>";
			}else{
				$prodArr = $this->input->post('story_pid');
				$prodArr = array_filter(array_unique($prodArr));
				$product_id = '';
				if (count($prodArr)>0){
					$product_id = implode(',', $prodArr);
				}
				$dataArr = array(
							'description'=>$description,
							'user_id'=>$uid,
							'seller_product_id'=>$product_id,
							'status'=>'Publish'
							);
				$this->stories_model->simple_insert(STORIES,$dataArr);
				$story_id = $this->stories_model->get_last_insert_id();
				$condition = array('id'=>$story_id);
				$get_storeid = $this->stories_model->get_all_details(STORIES,$condition);
				
				$sellercondition = "select * from ".PRODUCT." where seller_product_id IN (".$get_storeid->row()->seller_product_id.")";
				$sellerproduct_details = $this->stories_model->ExecuteQuery($sellercondition);
				$usercondition = "select * from ".USER_PRODUCTS." where seller_product_id IN (".$get_storeid->row()->seller_product_id.")";
				$userproduct_details = $this->stories_model->ExecuteQuery($usercondition);
				$picture_details = $this->product_model->get_sorted_array($sellerproduct_details,$userproduct_details,'created','desc');
				if($get_storeid->num_rows() ==1){
					if($this->input->post('publish_to_facebook')=='true'){
						
					}elseif($this->input->post('publish_to_twitter')=='true'){
						require_once('twitter/codebird.php');
					\Codebird\Codebird::setConsumerKey("rwwYAAEKLBNWhW5BoHhTkas9S", "Fbu6ZwSA3aZXEvF7VsVOpaVKU4bTOAfLIyyeh8jt69xOmsg0Zl");
					$cb = \Codebird\Codebird::getInstance();
					$cb->setToken("2388397494-jx4C9z2iUceD4J7zlA57yHid3C1PuCSYHzsB3Jh", "WHAQevMaaAIla7NWCIYqEfMA8kznx79VvZdNP9alGHYyX");
					$link = base_url().'s/'.$get_storeid->row()->id;
					$media_files =array();
					if(count($picture_details)>0){
						foreach($picture_details as $_picturedetails){
							$media_files[] = 'images/product/'.$_picturedetails->image;
						}
					} 
					$media_ids = array();
					foreach ($media_files as $file) {
						$reply = $cb->media_upload(array(
							'media' => $file
						));
						$media_ids[] = $reply->media_id_string;
					}
					$media_ids = implode(',', $media_ids);
					$reply = $cb->statuses_update(array(
						'status' => $description.' '.$link,
						'media_ids' => $media_ids
					));
					}
				} 
				$this->setErrorMessage('success','Story added successfully');
                //redirect('stories');
				redirect('myfeed');
			}
		}
	}
	public function view_story(){
		$this->data['heading'] = 'Stories';
		$condition= 's.id="'.$this->uri->segment(2,0).'"';
		$this->data['stories_details'] = $this->stories_model->get_all_StoresDetails($condition);
		//echo '<pre>';print_r($this->data['stories_details']->result());die;
		foreach($this->data['stories_details']->result() as $getstories_details){
			$this->data['ProductDetails'][$getstories_details->id] = '';
			if ($getstories_details->seller_product_id != ''){
				$this->data['ProductDetails'][$getstories_details->id]= $this->stories_model->get_all_StoriesProduct($getstories_details->seller_product_id);
			}
			$this->data['storiesComment'][$getstories_details->id] = '';
			$this->data['storiesComment'][$getstories_details->id] = $this->stories_model->view_stories_comments_details('where c.stories_id='.$getstories_details->id.' order by c.dateAdded desc');
		}
		$this->data['topStores'] = $this->product_model->get_top_stores();
		$this->data['topPeople'] = $this->product_model->get_top_people();
		$this->load->view('site/stories/view_stories',$this->data);
	}
	public function get_facebook_id(){
		$id = $this->input->post('fb_id');
		$condition = "select * from ".USERS." where facebook=".$id." and id != ".$this->checkLogin('U')."";
		   $get_details = $this->product_model->ExecuteQuery($condition);
		if($get_details->num_rows() ==1){
			echo "1";
		}else{
			echo "0";
		}
	}
	public function connect_twitter(){
		$returnStr['status_code'] = 1;
		$returnStr['url'] = base_url().'twtest/get_twitter_user';
		$returnStr['message'] = '';
		echo json_encode($returnStr);
	}
}
/*End of file cms.php */
/* Location: ./application/controllers/site/product.php */