<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Notifications related functions
 * @author Teamtweaks
 *
 */

class Notify extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper(array('cookie','date','email'));
		$this->load->model('notify_model');
		$this->load->model('product_model','notify');

		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->notify_model->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];

		if($_SESSION['sColorLists'] == ''){
			$_SESSION['sColorLists'] = $this->notify_model->get_all_details(LIST_VALUES,array('list_id'=>'1'));
		}
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];

		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['likedProducts'] = array();
		if ($this->data['loginCheck'] != ''){
			$this->data['likedProducts'] = $this->notify_model->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
		}
	}

	public function getlatest(){
		if($this->lang->line('notify_follows_you') != '')
		$notify_follows_you =  stripslashes($this->lang->line('notify_follows_you'));
		else
		$notify_follows_you =  "follows you";
			
		if($this->lang->line('notify_featured') != '')
		$notify_featured =  stripslashes($this->lang->line('notify_featured'));
		else
		$notify_featured =  "featured";

		if($this->lang->line('notify_commented_on') != '')
		$notify_commented_on =  stripslashes($this->lang->line('notify_commented_on'));
		else
		$notify_commented_on =  "commented on";

		if($this->lang->line('notify_no_notify') != '')
		$notify_no_notify =  stripslashes($this->lang->line('notify_no_notify'));
		else
		$notify_no_notify =  "No Notifications";

		if($this->lang->line('notify_sell_all') != '')
		$notify_sell_all =  stripslashes($this->lang->line('notify_sell_all'));
		else
		$notify_sell_all =  "See all notifications";
			
		if($this->lang->line('notify_ago') != '')
		$notify_ago =  stripslashes($this->lang->line('notify_ago'));
		else
		$notify_ago =  "ago";
			
		if($this->lang->line('notify_no_avail') != '')
		$notify_no_avail =  stripslashes($this->lang->line('notify_no_avail'));
		else
		$notify_no_avail =  "No notifications available";

		if($this->lang->line('notify_log_require') != '')
		$notify_log_require =  stripslashes($this->lang->line('notify_log_require'));
		else
		$notify_log_require =  "Login required";
		
		if($this->lang->line('notify_tagged_you') != '')
		$notify_tagged_you =  stripslashes($this->lang->line('notify_tagged_you'));
		else
		$notify_tagged_you =  " tagged you on ";

		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U') == ''){
			$returnStr['message'] = $notify_log_require;
		}else {
			$notifications = array_filter(explode(',', $this->data['userDetails']->row()->notifications));
			$searchArr = array();
			if (count($notifications)>0){
				if (in_array('wmn-follow', $notifications)){
					array_push($searchArr, 'follow');
				}
				if (in_array('wmn-comments_on_fancyd', $notifications)){
					array_push($searchArr, 'comment');
				}
				if (in_array('wmn-fancyd', $notifications)){
					array_push($searchArr, 'like');
				}
				if (in_array('wmn-featured', $notifications)){
					array_push($searchArr, 'featured');
				}
				if (in_array('wmn-comments', $notifications)){
					array_push($searchArr, 'own-product-comment');
				}
				
				//For comments in own story
				array_push($searchArr, 'own-story-comment');
				$storyIdsArr = array();
				$own_story_list = $this->notify_model->get_all_details(STORIES,array('user_id'=>$this->checkLogin('U')));
				if ($own_story_list->num_rows()>0){
					foreach ($own_story_list->result() as $own_story_row){
						array_push($storyIdsArr, $own_story_row->id);
					}
					array_filter($storyIdsArr);
				}
				////////////////////////
				
				//Notification for tag name
				array_push($searchArr, 'tag-approved');
				//////////////////////////
				
				$likedProductsIdArr = array();
				if ($this->data['likedProducts']->num_rows()>0){
					foreach ($this->data['likedProducts']->result() as $likeProdRow){
						array_push($likedProductsIdArr, $likeProdRow->product_id);
					}
					array_filter($likedProductsIdArr);
				}
				//		 		$fieldsArr = array('product_name');
				//   	 			$likedProductsDetails = $this->notify_model->get_fields_from_many(PRODUCT,$fieldsArr,'seller_product_id',$likedProductsIdArr);
				if (count($likedProductsIdArr)>0){
					$fields = " p.product_name,p.id,p.seller_product_id,p.image,u.full_name,u.user_name,u.thumbnail,u.feature_product ";
					$condition = ' where p.status="Publish" and u.status="Active" and p.seller_product_id in ('.implode(',', $likedProductsIdArr).')
			 						or p.status="Publish" and p.user_id=0 and p.seller_product_id in ('.implode(',', $likedProductsIdArr).') ';
					$likedProductsDetails = $this->notify_model->get_active_sell_products($condition,$fields);
				}else {
					$likedProductsDetails = '';
				}
				$addedSellProducts = $this->notify_model->get_all_details(PRODUCT,array('user_id'=>$this->checkLogin('U'),'status'=>'Publish'));
				$addedUserProducts = $this->notify_model->get_all_details(USER_PRODUCTS,array('user_id'=>$this->checkLogin('U'),'status'=>'Publish'));
				$addedSellProductsArr = array();
				$addedUserProductsArr = array();
				$addedProductsArr = array();
				if ($addedSellProducts->num_rows()>0){
					foreach ($addedSellProducts->result() as $addedSellProductsRow){
						array_push($addedSellProductsArr, $addedSellProductsRow->seller_product_id);
						array_push($addedProductsArr, $addedSellProductsRow->seller_product_id);
					}
				}
				if ($addedUserProducts->num_rows()>0){
					foreach ($addedUserProducts->result() as $addedUserProductsRow){
						array_push($addedUserProductsArr, $addedUserProductsRow->seller_product_id);
						array_push($addedProductsArr, $addedUserProductsRow->seller_product_id);
					}
				}
				$activityArr = array_merge($likedProductsIdArr,$addedProductsArr);
				array_push($activityArr, $this->checkLogin('U'));
				
				//For comments in own story
				if (count($storyIdsArr)>0){
					foreach ($storyIdsArr as $story_id_row){
						array_push($activityArr, $story_id_row);
					}
				}
				///////////
				
				$allNoty = $this->notify_model->get_latest_notifications($searchArr,$activityArr,$this->checkLogin('U'));
				if ($allNoty->num_rows()>0){
					$notyCount = 0;
					$notyFinal = array();
					foreach ($allNoty->result() as $allRow){
						//		if ($notyCount>4)break;
						if ($allRow->activity == 'like'){
							if (in_array($allRow->activity_id, $addedProductsArr)){
								array_push($notyFinal, array('user_id'=>$allRow->user_id,'activity'=>'like','activity_id'=>$allRow->activity_id));
								$notyCount++;
							}
						}else if ($allRow->activity == 'featured'){
							if (in_array($allRow->activity_id, $addedProductsArr)){
								array_push($notyFinal, array('user_id'=>$allRow->user_id,'activity'=>'featured','activity_id'=>$allRow->activity_id));
								$notyCount++;
							}
						}else if ($allRow->activity == 'follow'){
							if ($this->checkLogin('U') == $allRow->activity_id){
								array_push($notyFinal, array('user_id'=>$allRow->user_id,'activity'=>'follow','activity_id'=>$allRow->activity_id));
								$notyCount++;
							}
						}else if ($allRow->activity == 'comment'){
							if (in_array($allRow->activity_id, $likedProductsIdArr)){
								array_push($notyFinal, array('user_id'=>$allRow->user_id,'activity'=>'comment','activity_id'=>$allRow->activity_id));
								$notyCount++;
							}
						}else if ($allRow->activity == 'own-product-comment'){
							if (in_array($allRow->activity_id, $addedProductsArr)){
								array_push($notyFinal, array('user_id'=>$allRow->user_id,'activity'=>'own-product-comment','activity_id'=>$allRow->activity_id));
								$notyCount++;
							}
						}else
						
						//For comments in own story
						if ($allRow->activity == 'own-story-comment'){
							if (in_array($allRow->activity_id, $storyIdsArr)){
								array_push($notyFinal, array('user_id'=>$allRow->user_id,'activity'=>'own-story-comment','activity_id'=>$allRow->activity_id,'created'=>$allRow->created,'comment_id'=>$allRow->comment_id));
								$notyCount++;
							}
						}else
						/////////////////
						
						//Notification for tag name
						if ($allRow->activity == 'tag-approved'){
							array_push($notyFinal, array('user_id'=>$allRow->user_id,'activity'=>'tag-approved','activity_id'=>$allRow->activity_id,'created'=>$allRow->created,'comment_id'=>$allRow->comment_id));
							$notyCount++;
						}
						//////////////////////////
					}
					if ($notyCount>0){
						//	   	 				$returnStr['content'] = '<ul>';
						$returnStr['content'] = '<li style="padding: 0;"><span class="arrow_icon2"><img src="images/drop_arrow.png"/></span></li>';
						$total_count = 0;
						foreach ($notyFinal as $notyFinalRow){
							if ($total_count>4)break;
							$activityUserDetails = $this->notify_model->get_all_details(USERS,array('id'=>$notyFinalRow['user_id']));
							if ($activityUserDetails->num_rows()>0){
								$userImg = 'user-thumb1.png';
								if ($activityUserDetails->row()->thumbnail != ''){
									$userImg = $activityUserDetails->row()->thumbnail;
								}
								$activityUserLink = '<a style="float:left;" href="user/'.$activityUserDetails->row()->user_name.'">
			   	 					<img style="position: relative;top:0px;left:0px;" src="images/users/'.$userImg.'" class="photo"/>
									</a>';
								$activityUserName = $activityUserDetails->row()->full_name;
								if ($activityUserName == '') $activityUserName=$activityUserDetails->row()->user_name;
								if ($notyFinalRow['activity'] != 'follow'){
									if (in_array($notyFinalRow['activity_id'], $addedSellProductsArr)){
										$prodTbl = PRODUCT;
									}else if (in_array($notyFinalRow['activity_id'], $addedUserProductsArr)){
										$prodTbl = USER_PRODUCTS;
									}else {
										$prodTbl = '';
									}
									if ($notyFinalRow['activity'] == 'comment'){
										$prodTbl = 'comment';
									}
									if ($prodTbl == PRODUCT){
										foreach ($addedSellProducts->result() as $addedSellProductsRow){
											if ($addedSellProductsRow->seller_product_id == $notyFinalRow['activity_id']){
												$imgArr = array_filter(explode(',', $addedSellProductsRow->image));
												if (count($imgArr)>0){
													$prodImg = $imgArr[0];
												}else {
													$prodImg = 'dummyProductImage.jpg';
												}
												$activityProdName = $addedSellProductsRow->product_name;
												$activityProdLink = '<a style="float:right;" href="things/'.$addedSellProductsRow->id.'/'.url_title($addedSellProductsRow->product_name,'-').'">
													<img src="images/product/'.$prodImg.'" class="thing" width="30px"/>
													</a>';
												break;
											}
										}
									}else if ($prodTbl == USER_PRODUCTS){
										foreach ($addedUserProducts->result() as $addedUserProductsRow){
											if ($addedUserProductsRow->seller_product_id == $notyFinalRow['activity_id']){
												$imgArr = array_filter(explode(',', $addedUserProductsRow->image));
												if (count($imgArr)>0){
													$prodImg = $imgArr[0];
												}else {
													$prodImg = 'dummyProductImage.jpg';
												}
												$activityProdName = $addedUserProductsRow->product_name;
												$activityProdLink = '<a style="float:right;" href="user/'.$this->data['userDetails']->row()->user_name.'/things/'.$addedUserProductsRow->seller_product_id.'/'.url_title($addedUserProductsRow->product_name,'-').'">
													<img src="images/product/'.$prodImg.'" class="thing"/>
													</a>';
												break;
											}
										}
									}else if ($prodTbl == 'comment'){
										if ($likedProductsDetails!='' && count($likedProductsDetails)>0){
											foreach ($likedProductsDetails as $likedProductsDetailsRow){
												if ($likedProductsDetailsRow->seller_product_id == $notyFinalRow['activity_id']){
													$imgArr = array_filter(explode(',', $likedProductsDetailsRow->image));
													if (count($imgArr)>0){
														$prodImg = $imgArr[0];
													}else {
														$prodImg = 'dummyProductImage.jpg';
													}
													$activityProdName = $likedProductsDetailsRow->product_name;
													if (isset($likedProductsDetailsRow->web_link)){
														$activityProdLink = '<a style="float:right;" href="user/'.$likedProductsDetailsRow->user_name.'/things/'.$likedProductsDetailsRow->seller_product_id.'/'.url_title($likedProductsDetailsRow->product_name,'-').'">
															<img style="float:right;" src="images/product/'.$prodImg.'" class="thing" />
															</a>';
														break;
													}else {
														$activityProdLink = '<a style="float:right;" href="things/'.$likedProductsDetailsRow->id.'/'.url_title($likedProductsDetailsRow->product_name,'-').'">
															<img style="float:right;" src="images/product/'.$prodImg.'" class="thing" />
															</a>';
														break;
													}
												}
											}
										}
									}else {
										$activityProdName = '';
										$activityProdLink = '';
									}
								}
								
								//Notification for tag name
								if ($notyFinalRow['activity']=='tag-approved'){
									$cmtDetails = $this->notify_model->get_all_details(PRODUCT_COMMENTS,array('id'=>$notyFinalRow['comment_id']));
									$product_details = $this->notify_model->get_all_details(PRODUCT,array('seller_product_id'=>$cmtDetails->row()->product_id));
									if ($product_details->num_rows()==0){
										$product_details = $this->notify->view_notsell_product_details(' where `seller_product_id` = "'.$cmtDetails->row()->product_id.'"');
										if ($product_details->num_rows == 1){
											$imgArr = array_filter(explode(',', $product_details->row()->image));
											if (count($imgArr)>0){
												$prodImg = $imgArr[0];
											}else {
												$prodImg = 'dummyProductImage.jpg';
											}
											$activityProdLink = '<a style="float:right;" href="user/'.$product_details->row()->user_name.'/things/'.$product_details->row()->seller_product_id.'/'.url_title($product_details->row()->product_name,'-').'">
															<img style="float:right;" src="images/product/'.$prodImg.'" class="thing" />
															</a>';
											$activityProdName = $product_details->row()->product_name;
										}
									}else {
										$imgArr = array_filter(explode(',', $product_details->row()->image));
										if (count($imgArr)>0){
											$prodImg = $imgArr[0];
										}else {
											$prodImg = 'dummyProductImage.jpg';
										}
										$activityProdLink = '<a style="float:right;" href="things/'.$product_details->row()->id.'/'.url_title($product_details->row()->product_name,'-').'">
														<img style="float:right;" src="images/product/'.$prodImg.'" class="thing" />
														</a>';
										$activityProdName = $product_details->row()->product_name;
									}
								}
								////////////////////
								
								$li_count = 0;
								if ($notyFinalRow['activity'] == 'follow'){
									if ($activityUserLink != ''){
										$userImg = 'user-thumb1.png';
										if ($activityUserDetails->row()->thumbnail != ''){
											$userImg = $activityUserDetails->row()->thumbnail;
										}
										$returnStr['content'] .= '<li style="padding: 0;">'.$activityUserLink.$activityUserName.' '.$notify_follows_you.'.
				   	 					</li>';
										$li_count++;
										$total_count++;
									}
								}else if ($notyFinalRow['activity'] == 'like'){
									if ($activityUserLink != '' && $activityProdLink != ''){
										$returnStr['content'] .= '<li style="padding: 0;">'.$activityUserLink.$activityProdLink.$activityUserName.' '.LIKED_BUTTON.' '.$activityProdName.'</li>';
										$li_count++;
										$total_count++;
										$total_count++;
									}
								}else if ($notyFinalRow['activity'] == 'featured'){
									if ($activityUserLink != '' && $activityProdLink != ''){
										$returnStr['content'] .= '<li style="padding: 0;">'.$activityUserLink.$activityProdLink.$activityUserName.' '.$notify_featured.' '.$activityProdName.'</li>';
										$li_count++;
										$total_count++;
									}
								}else if ($notyFinalRow['activity'] == 'comment'){
									if ($activityUserLink != '' && $activityProdLink != ''){
										$returnStr['content'] .= '<li style="padding: 0;">'.$activityUserLink.$activityProdLink.$activityUserName.' '.$notify_commented_on.' '.$activityProdName.'</li>';
										$li_count++;
										$total_count++;
									}
								}else if ($notyFinalRow['activity'] == 'own-product-comment'){
									if ($activityUserLink != '' && $activityProdLink != ''){
										$returnStr['content'] .= '<li style="padding: 0;">'.$activityUserLink.$activityProdLink.$activityUserName.' '.$notify_commented_on.' '.$activityProdName.'</li>';
										$li_count++;
										$total_count++;
									}
								}else 
								
								//For comments in own story
								if ($notyFinalRow['activity'] == 'own-story-comment'){
									if ($activityUserLink != ''){
										$returnStr['content'] .= '<li style="padding: 0;">'.$activityUserLink.$activityUserName.' '.$notify_commented_on.' your story</li>';
										$li_count++;
										$total_count++;
									}
								}else 
								//////////

								//Notification for tag name
								if ($notyFinalRow['activity'] == 'tag-approved'){
									if ($activityUserLink != ''){
										$returnStr['content'] .= '<li style="padding: 0;">'.$activityUserLink.$activityProdLink.$activityUserName.' '.$notify_tagged_you.' '.$activityProdName.'</span>
			   	 						</li>';
										$li_count++;$total_count++;
									}
								}
								//////////
							}
						}
						if ($li_count==0){
							$returnStr['status_code'] = 2;
							$returnStr['content'] .= '<li style="padding-right:0px;padding-left:100px;width:180px;">'.$notify_no_notify.'</li>';
						}else {
							$returnStr['content'] .= '<li style="padding: 0;"><a href="'.base_url().'notifications">'.$notify_sell_all.'</a></li>';
							$returnStr['status_code'] = 1;
						}
						//	 				$returnStr['content'] .= '</ul>';
					}else {
						$returnStr['status_code'] = 2;
						$returnStr['content'] = '<li style="padding-right:0px;padding-left:100px;width:180px;">'.$notify_no_notify.'</li>';
					}
				}else {
					$returnStr['status_code'] = 2;
					$returnStr['content'] = '<li style="padding-right:0px;padding-left:100px;width:180px;">'.$notify_no_notify.'</li>';
				}
			}else {
				$returnStr['status_code'] = 2;
				$returnStr['content'] = '<li style="padding-right:0px;padding-left:100px;width:180px;">'.$notify_no_notify.'</li>';
			}
				
		}
		echo json_encode($returnStr);

	}

	public function display_notifications(){


		if($this->lang->line('notify_follows_you') != '')
		$notify_follows_you =  stripslashes($this->lang->line('notify_follows_you'));
		else
		$notify_follows_you =  "follows you";
			
		if($this->lang->line('notify_featured') != '')
		$notify_featured =  stripslashes($this->lang->line('notify_featured'));
		else
		$notify_featured =  "featured";

		if($this->lang->line('notify_commented_on') != '')
		$notify_commented_on =  stripslashes($this->lang->line('notify_commented_on'));
		else
		$notify_commented_on =  "commented on";

		if($this->lang->line('notify_no_notify') != '')
		$notify_no_notify =  stripslashes($this->lang->line('notify_no_notify'));
		else
		$notify_no_notify =  "No Notifications";

		if($this->lang->line('notify_sell_all') != '')
		$notify_sell_all =  stripslashes($this->lang->line('notify_sell_all'));
		else
		$notify_sell_all =  "See all notifications";
			
		if($this->lang->line('notify_ago') != '')
		$notify_ago =  stripslashes($this->lang->line('notify_ago'));
		else
		$notify_ago =  "ago";
			
		if($this->lang->line('notify_no_avail') != '')
		$notify_no_avail =  stripslashes($this->lang->line('notify_no_avail'));
		else
		$notify_no_avail =  "No notifications available";

		if($this->lang->line('notify_log_require') != '')
		$notify_log_require =  stripslashes($this->lang->line('notify_log_require'));
		else
		$notify_log_require =  "Login required";

		if($this->lang->line('referrals_notification') != '')
		$referrals_notification =  stripslashes($this->lang->line('referrals_notification'));
		else
		$referrals_notification =  "Notifications";

		if($this->lang->line('notify_tagged_you') != '')
		$notify_tagged_you =  stripslashes($this->lang->line('notify_tagged_you'));
		else
		$notify_tagged_you =  " tagged you on ";



		if ($this->checkLogin('U') == ''){
			show_404();
		}else {

			$notifications = array_filter(explode(',', $this->data['userDetails']->row()->notifications));
			$searchArr = array();
			if (count($notifications)>0){
				if (in_array('wmn-follow', $notifications)){
					array_push($searchArr, 'follow');
				}
				if (in_array('wmn-comments_on_fancyd', $notifications)){
					array_push($searchArr, 'comment');
				}
				if (in_array('wmn-fancyd', $notifications)){
					array_push($searchArr, 'like');
				}
				if (in_array('wmn-featured', $notifications)){
					array_push($searchArr, 'featured');
				}
				if (in_array('wmn-comments', $notifications)){
					array_push($searchArr, 'own-product-comment');
				}
				
				//For comments in own story
				array_push($searchArr, 'own-story-comment');
				$storyIdsArr = array();
				$own_story_list = $this->notify_model->get_all_details(STORIES,array('user_id'=>$this->checkLogin('U')));
				if ($own_story_list->num_rows()>0){
					foreach ($own_story_list->result() as $own_story_row){
						array_push($storyIdsArr, $own_story_row->id);
					}
					array_filter($storyIdsArr);
				}
				////////////////////////
				
				
				//Notification for tag name
				array_push($searchArr, 'tag-approved');
				//////////////////////////
				
				$likedProductsIdArr = array();
				if ($this->data['likedProducts']->num_rows()>0){
					foreach ($this->data['likedProducts']->result() as $likeProdRow){
						array_push($likedProductsIdArr, $likeProdRow->product_id);
					}
					array_filter($likedProductsIdArr);
				}
				//		 		$fieldsArr = array('product_name','id','seller_product_id','image');
				//   	 			$likedProductsDetails = $this->notify_model->get_fields_from_many(PRODUCT,$fieldsArr,'seller_product_id',$likedProductsIdArr);
				if (count($likedProductsIdArr)>0){
					$fields = " p.product_name,p.id,p.seller_product_id,p.image,u.full_name,u.user_name,u.thumbnail,u.feature_product ";
					$condition = ' where p.status="Publish" and u.status="Active" and p.seller_product_id in ('.implode(',', $likedProductsIdArr).')
			 						or p.status="Publish" and p.user_id=0 and p.seller_product_id in ('.implode(',', $likedProductsIdArr).') ';
					$likedProductsDetails = $this->notify_model->get_active_sell_products($condition,$fields);
				}else {
					$likedProductsDetails = '';
				}
				$addedSellProducts = $this->notify_model->get_all_details(PRODUCT,array('user_id'=>$this->checkLogin('U'),'status'=>'Publish'));
				$addedUserProducts = $this->notify_model->get_all_details(USER_PRODUCTS,array('user_id'=>$this->checkLogin('U'),'status'=>'Publish'));
				$addedSellProductsArr = array();
				$addedUserProductsArr = array();
				$addedProductsArr = array();
				if ($addedSellProducts->num_rows()>0){
					foreach ($addedSellProducts->result() as $addedSellProductsRow){
						array_push($addedSellProductsArr, $addedSellProductsRow->seller_product_id);
						array_push($addedProductsArr, $addedSellProductsRow->seller_product_id);
					}
				}
				if ($addedUserProducts->num_rows()>0){
					foreach ($addedUserProducts->result() as $addedUserProductsRow){
						array_push($addedUserProductsArr, $addedUserProductsRow->seller_product_id);
						array_push($addedProductsArr, $addedUserProductsRow->seller_product_id);
					}
				}
				$activityArr = array_merge($likedProductsIdArr,$addedProductsArr);
				array_push($activityArr, $this->checkLogin('U'));
				
				//For comments in own story
				if (count($storyIdsArr)>0){
					foreach ($storyIdsArr as $story_id_row){
						array_push($activityArr, $story_id_row);
					}
				}
				///////////
				
				$allNoty = $this->notify_model->get_latest_notifications($searchArr,$activityArr,$this->checkLogin('U'));
				if ($allNoty->num_rows()>0){
					$notyCount = 0;
					$notyFinal = array();
					foreach ($allNoty->result() as $allRow){
						if ($allRow->activity == 'like'){
							if (in_array($allRow->activity_id, $addedProductsArr)){
								array_push($notyFinal, array('user_id'=>$allRow->user_id,'activity'=>'like','activity_id'=>$allRow->activity_id,'created'=>$allRow->created));
								$notyCount++;
							}
						}else if ($allRow->activity == 'featured'){
							if (in_array($allRow->activity_id, $addedProductsArr)){
								array_push($notyFinal, array('user_id'=>$allRow->user_id,'activity'=>'featured','activity_id'=>$allRow->activity_id,'created'=>$allRow->created));
								$notyCount++;
							}
						}else if ($allRow->activity == 'follow'){
							if ($this->checkLogin('U') == $allRow->activity_id){
								array_push($notyFinal, array('user_id'=>$allRow->user_id,'activity'=>'follow','activity_id'=>$allRow->activity_id,'created'=>$allRow->created));
								$notyCount++;
							}
						}else if ($allRow->activity == 'comment'){
							if (in_array($allRow->activity_id, $likedProductsIdArr)){
								array_push($notyFinal, array('user_id'=>$allRow->user_id,'activity'=>'comment','activity_id'=>$allRow->activity_id,'created'=>$allRow->created,'comment_id'=>$allRow->comment_id));
								$notyCount++;
							}
						}else if ($allRow->activity == 'own-product-comment'){
							if (in_array($allRow->activity_id, $addedProductsArr)){
								array_push($notyFinal, array('user_id'=>$allRow->user_id,'activity'=>'own-product-comment','activity_id'=>$allRow->activity_id,'created'=>$allRow->created,'comment_id'=>$allRow->comment_id));
								$notyCount++;
							}
						}else
						
						//For comments in own story
						if ($allRow->activity == 'own-story-comment'){
							if (in_array($allRow->activity_id, $storyIdsArr)){
								array_push($notyFinal, array('user_id'=>$allRow->user_id,'activity'=>'own-story-comment','activity_id'=>$allRow->activity_id,'created'=>$allRow->created,'comment_id'=>$allRow->comment_id));
								$notyCount++;
							}
						}else
						/////////////////
						
						//Notification for tag name
						if ($allRow->activity == 'tag-approved'){
							array_push($notyFinal, array('user_id'=>$allRow->user_id,'activity'=>'tag-approved','activity_id'=>$allRow->activity_id,'created'=>$allRow->created,'comment_id'=>$allRow->comment_id));
							$notyCount++;
						}
						//////////////////////////
						
					}
					if ($notyCount>0){
						$returnStr['content'] = '<ul class="notify-list">';
						foreach ($notyFinal as $notyFinalRow){
							$activityUserDetails = $this->notify_model->get_all_details(USERS,array('id'=>$notyFinalRow['user_id']));
							if ($activityUserDetails->num_rows()>0){
								$userImg = 'user-thumb1.png';
								if ($activityUserDetails->row()->thumbnail != ''){
									$userImg = $activityUserDetails->row()->thumbnail;
								}
								$activityUserLink = '<a style="float:left;" href="user/'.$activityUserDetails->row()->user_name.'">
			   	 					<img src="images/users/'.$userImg.'" class="avartar" style="float:left;position:static;"/>
									</a>';
								$activityUserDetails_name = $activityUserDetails->row()->full_name;
								if ($activityUserDetails_name == ''){
									$activityUserDetails_name = $activityUserDetails->row()->user_name;
								}
								$activityUserNameLink = '<a href="user/'.$activityUserDetails->row()->user_name.'" class="user">'.$activityUserDetails_name.'</a>';
								$activityTime = strtotime($notyFinalRow['created']);
								$actTime = timespan($activityTime).' '.$notify_ago.'';
								if ($notyFinalRow['activity'] != 'follow'){
									if (in_array($notyFinalRow['activity_id'], $addedSellProductsArr)){
										$prodTbl = PRODUCT;
									}else if (in_array($notyFinalRow['activity_id'], $addedUserProductsArr)){
										$prodTbl = USER_PRODUCTS;
									}else {
										$prodTbl = '';
									}
									if ($notyFinalRow['activity'] == 'comment'){
										$prodTbl = 'comment';
									}
									if ($prodTbl == PRODUCT){
										foreach ($addedSellProducts->result() as $addedSellProductsRow){
											if ($addedSellProductsRow->seller_product_id == $notyFinalRow['activity_id']){
												$imgArr = array_filter(explode(',', $addedSellProductsRow->image));
												if (count($imgArr)>0){
													$prodImg = $imgArr[0];
												}else {
													$prodImg = 'dummyProductImage.jpg';
												}
												$activityProdName = $addedSellProductsRow->product_name;
												$activityProdLink = '<a style="float:left;" href="things/'.$addedSellProductsRow->id.'/'.url_title($addedSellProductsRow->product_name,'-').'">
													<img src="images/site/blank.gif" style="background-image:url(\'images/product/'.$prodImg.'\');float: right;background-position: 50% 50%;  background-size: cover;" class="u"/>
													</a>';
												$activityProdNameLink = '<a href="things/'.$addedSellProductsRow->id.'/'.url_title($addedSellProductsRow->product_name,'-').'">'.$activityProdName.'</a>.';
												break;
											}
										}
									}else if ($prodTbl == USER_PRODUCTS){
										foreach ($addedUserProducts->result() as $addedUserProductsRow){
											if ($addedUserProductsRow->seller_product_id == $notyFinalRow['activity_id']){
												$imgArr = array_filter(explode(',', $addedUserProductsRow->image));
												if (count($imgArr)>0){
													$prodImg = $imgArr[0];
												}else {
													$prodImg = 'dummyProductImage.jpg';
												}
												$activityProdName = $addedUserProductsRow->product_name;
												$activityProdLink = '<a style="float:left;" href="user/'.$this->data['userDetails']->row()->user_name.'/things/'.$addedUserProductsRow->seller_product_id.'/'.url_title($addedUserProductsRow->product_name,'-').'">
													<img src="images/site/blank.gif" style="background-image:url(\'images/product/'.$prodImg.'\');float: right;background-position: 50% 50%;  background-size: cover;" class="u"/>
													</a>';
												$activityProdNameLink = '<a href="user/'.$this->data['userDetails']->row()->user_name.'/things/'.$addedUserProductsRow->seller_product_id.'/'.url_title($addedUserProductsRow->product_name,'-').'">'.$activityProdName.'</a>.';
												break;
											}
										}
									}else if ($prodTbl == 'comment'){
										if ($likedProductsDetails!='' && count($likedProductsDetails)>0){
											foreach ($likedProductsDetails as $likedProductsDetailsRow){
												if ($likedProductsDetailsRow->seller_product_id == $notyFinalRow['activity_id']){
													$imgArr = array_filter(explode(',', $likedProductsDetailsRow->image));
													if (count($imgArr)>0){
														$prodImg = $imgArr[0];
													}else {
														$prodImg = 'dummyProductImage.jpg';
													}
													$activityProdName = $likedProductsDetailsRow->product_name;
													if (isset($likedProductsDetailsRow->web_link)){
														$activityProdLink = '<a style="float:left;" href="user/'.$likedProductsDetailsRow->user_name.'/things/'.$likedProductsDetailsRow->seller_product_id.'/'.url_title($likedProductsDetailsRow->product_name,'-').'">
															<img src="images/site/blank.gif" style="background-image:url(\'images/product/'.$prodImg.'\');float: right;background-position: 50% 50%;  background-size: cover;" class="u"/>
															</a>';
														$activityProdNameLink = '<a href="user/'.$likedProductsDetailsRow->user_name.'/things/'.$likedProductsDetailsRow->seller_product_id.'/'.url_title($likedProductsDetailsRow->product_name,'-').'">'.$activityProdName.'</a>.';
														break;
													}else {
														$activityProdLink = '<a style="float:left;" href="things/'.$likedProductsDetailsRow->id.'/'.url_title($likedProductsDetailsRow->product_name,'-').'">
															<img src="images/site/blank.gif" style="background-image:url(\'images/product/'.$prodImg.'\');float: right;background-position: 50% 50%;  background-size: cover;" class="u"/>
															</a>';
														$activityProdNameLink = '<a href="things/'.$likedProductsDetailsRow->id.'/'.url_title($likedProductsDetailsRow->product_name,'-').'">'.$activityProdName.'</a>.';
														break;
													}
												}
											}
										}
									}else {
										$activityProdName = '';
										$activityProdLink = '';
									}
								}
								if ($notyFinalRow['comment_id'] != '0' && $notyFinalRow['activity']!='own-story-comment'){
									$cmtDetails = $this->notify_model->get_all_details(PRODUCT_COMMENTS,array('id'=>$notyFinalRow['comment_id']));
									$comment = '';
									if ($cmtDetails->num_rows()>0){
										$comment = $cmtDetails->row()->comments;
										$activityTime = strtotime($cmtDetails->row()->dateAdded);
										$actTime = timespan($activityTime).' '.$notify_ago.'';
									}
								}else 
								
								/////For comments in own story
								if ($notyFinalRow['comment_id'] != '0' && $notyFinalRow['activity']=='own-story-comment'){
									$cmtDetails = $this->notify_model->get_all_details(STORIES_COMMENTS,array('id'=>$notyFinalRow['comment_id']));
									$comment = '';
									if ($cmtDetails->num_rows()>0){
										$comment = $cmtDetails->row()->comments;
										$activityTime = strtotime($cmtDetails->row()->dateAdded);
										$actTime = timespan($activityTime).' '.$notify_ago.'';
									}
								}
								////////////////////
								
								//Notification for tag name
								if ($notyFinalRow['activity']=='tag-approved'){
									$product_details = $this->notify_model->get_all_details(PRODUCT,array('seller_product_id'=>$cmtDetails->row()->product_id));
									if ($product_details->num_rows()==0){
										$product_details = $this->notify->view_notsell_product_details(' where `seller_product_id` = "'.$cmtDetails->row()->product_id.'"');
										if ($product_details->num_rows == 1){
											$imgArr = array_filter(explode(',', $product_details->row()->image));
											if (count($imgArr)>0){
												$prodImg = $imgArr[0];
											}else {
												$prodImg = 'dummyProductImage.jpg';
											}
											$activityProdLink = '<a style="float:left;" href="user/'.$product_details->row()->user_name.'/things/'.$product_details->row()->seller_product_id.'/'.url_title($product_details->row()->product_name,'-').'">
															<img src="images/site/blank.gif" style="background-image:url(\'images/product/'.$prodImg.'\');float: right;background-position: 50% 50%;  background-size: cover;" class="u"/>
															</a>';
											$activityProdNameLink = '<a href="user/'.$product_details->row()->user_name.'/things/'.$product_details->row()->seller_product_id.'/'.url_title($product_details->row()->product_name,'-').'">'.$product_details->row()->product_name.'</a>.';
										}
									}else {
										$imgArr = array_filter(explode(',', $product_details->row()->image));
										if (count($imgArr)>0){
											$prodImg = $imgArr[0];
										}else {
											$prodImg = 'dummyProductImage.jpg';
										}
										$activityProdLink = '<a style="float:left;" href="things/'.$product_details->row()->id.'/'.url_title($product_details->row()->product_name,'-').'">
														<img src="images/site/blank.gif" style="background-image:url(\'images/product/'.$prodImg.'\');float: right;background-position: 50% 50%;  background-size: cover;" class="u"/>
														</a>';
										$activityProdNameLink = '<a href="things/'.$product_details->row()->id.'/'.url_title($product_details->row()->product_name,'-').'">'.$product_details->row()->product_name.'</a>.';
									}
								}
								////////////////////
								
								$li_count=0;
								if ($notyFinalRow['activity'] == 'follow'){
									if ($activityUserLink != ''){
										$userImg = 'user-thumb1.png';
										if ($activityUserDetails->row()->thumbnail != ''){
											$userImg = $activityUserDetails->row()->thumbnail;
										}
										$returnStr['content'] .=  '<li
										 class="notification-item" style="width:850px;">'.$activityUserLink.'
			   	 						<p class="right" style="width:350px;"><span class="title"> '.$activityUserNameLink.' '.$notify_follows_you.'</span>
			   	 						<span class="activity-reply">'.$actTime.'</span></p>
			   	 						</li>';
										$li_count++;
									}
								}else if ($notyFinalRow['activity'] == 'like'){
									if ($activityUserLink != '' && $activityProdLink != ''){
										$returnStr['content'] .= '<li class="notification-item" style="width:850px;">'.$activityUserLink.'
			   	 						<p class="right" style="width:350px;"><span class="title"> '.$activityUserNameLink.' '.LIKED_BUTTON.' '.$activityProdNameLink.'</span>
			   	 						<span class="activity-reply">'.$actTime.'</span></p>'.$activityProdLink.'
			   	 						</li>';
										$li_count++;
									}
								}else if ($notyFinalRow['activity'] == 'featured'){
									if ($activityUserLink != '' && $activityProdLink != ''){
										$returnStr['content'] .= '<li class="notification-item" style="width:850px;">'.$activityUserLink.'
			   	 						<p class="right" style="width:350px;"><span class="title"> '.$activityUserNameLink.' '.$notify_featured.' '.$activityProdNameLink.'</span>
			   	 						<span class="activity-reply">'.$actTime.'</span></p>'.$activityProdLink.'
			   	 						</li>';
										$li_count++;
									}
								}else if ($notyFinalRow['activity'] == 'comment'){
									if ($activityUserLink != '' && $activityProdLink != ''){
										$returnStr['content'] .= '<li class="notification-item" style="width:850px;">'.$activityUserLink.'
			   	 						<p class="right" style="width:350px;"><span class="title"> '.$activityUserNameLink.' '.$notify_commented_on.' '.$activityProdNameLink.'</span>
			   	 						<span class="cmt">'.$comment.'</span><br/>
			   	 						<span class="activity-reply">'.$actTime.'</span></p>'.$activityProdLink.'
			   	 						</li>';
										$li_count++;
									}
								}else if ($notyFinalRow['activity'] == 'own-product-comment'){
									if ($activityUserLink != '' && $activityProdLink != ''){
										$returnStr['content'] .= '<li class="notification-item" style="width:850px;">'.$activityUserLink.'
			   	 						<p class="right" style="width:350px;"><span class="title"> '.$activityUserNameLink.' '.$notify_commented_on.' '.$activityProdNameLink.'</span>
			   	 						<span class="cmt">'.$comment.'</span><br/>
			   	 						<span class="activity-reply">'.$actTime.'</span></p>'.$activityProdLink.'
			   	 						</li>';
										$li_count++;
									}
								}else

								//For comments in own story
								if ($notyFinalRow['activity'] == 'own-story-comment'){
									if ($activityUserLink != ''){
										$returnStr['content'] .= '<li class="notification-item" style="width:850px;">'.$activityUserLink.'
			   	 						<p class="right" style="width:350px;"><span class="title"> '.$activityUserNameLink.' '.$notify_commented_on.' your story.</span>
			   	 						<span class="cmt">'.$comment.'</span><br/>
			   	 						<span class="activity-reply">'.$actTime.'</span></p>
			   	 						</li>';
										$li_count++;
									}
								}else 
								//////////

								//Notification for tag name
								if ($notyFinalRow['activity'] == 'tag-approved'){
									if ($activityUserLink != ''){
										$returnStr['content'] .= '<li class="notification-item" style="width:850px;">'.$activityUserLink.'
			   	 						<p class="right" style="width:350px;"><span class="title"> '.$activityUserNameLink.' '.$notify_tagged_you.' '.$activityProdNameLink.'</span>
			   	 						<span class="cmt">'.$comment.'</span><br/>
			   	 						<span class="activity-reply">'.$actTime.'</span></p>'.$activityProdLink.'
			   	 						</li>';
										$li_count++;
									}
								}
								//////////
							}
						}
						if ($li_count==0){
							$returnStr['content'] .= '<li class="notification-item" style="width:850px;">'.$notify_no_avail.'</li>';
							$returnStr['status_code'] = 2;
						}else {
							$returnStr['status_code'] = 1;
						}
						$returnStr['content'] .= '</ul>';
					}else {
						$returnStr['status_code'] = 2;
						$returnStr['content'] = '<ul class="notify-list"><li class="notification-item" style="width:850px;">'.$notify_no_avail.'</li></ul>';
					}
				}else {
					$returnStr['status_code'] = 2;
					$returnStr['content'] = '<ul class="notify-list"><li class="notification-item" style="width:850px;">'.$notify_no_avail.'</li></ul>';
				}
			}else {
				$returnStr['status_code'] = 2;
				$returnStr['content'] = '<ul class="notify-list"><li class="notification-item" style="width:850px;">'.$notify_no_avail.'</li></ul>';
			}
		}
		$this->data['notyList'] = $returnStr['content'];
		$this->data['heading'] = $referrals_notification;
		$this->data['topStores'] = $this->notify->get_top_stores();
		$this->data['topPeople'] = $this->notify->get_top_people();
		$this->load->view('site/notification/display_notification',$this->data);
	}
}

/*End of file notify.php */
/* Location: ./application/controllers/site/notify.php */