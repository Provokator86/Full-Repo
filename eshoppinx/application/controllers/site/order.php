<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * User related functions
 * @author Teamtweaks
 *
 */

class Order extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));
		$this->load->model('order_model');
		$this->load->model('product_model');
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->order_model->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];

		if($_SESSION['sColorLists'] == ''){
			$_SESSION['sColorLists'] = $this->order_model->get_all_details(LIST_VALUES,array('list_id'=>'1'));
		}
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];

		$this->data['loginCheck'] = $this->checkLogin('U');
	}


	/**
	 *
	 * Loading Order Page
	 */

	public function index(){

		if ($this->data['loginCheck'] != ''){
			$this->data['heading'] = 'Order Confirmation';
			if($this->uri->segment(2) == 'giftsuccess'){
				if($this->uri->segment(4)==''){
					$transId = $_REQUEST['txn_id'];
					$Pray_Email = $_REQUEST['payer_email'];
				}else{
					$transId = $this->uri->segment(4);
					$Pray_Email = '';
				}
				$this->data['Confirmation'] = $this->order_model->PaymentGiftSuccess($this->uri->segment(3),$transId,$Pray_Email);
				redirect("order/confirmation/gift");
			}elseif($this->uri->segment(2) == 'subscribesuccess'){
				$transId = $this->uri->segment(4);
				$Pray_Email = '';

				$this->data['Confirmation'] = $this->order_model->PaymentSubscribeSuccess($this->uri->segment(3),$transId);
				redirect("order/confirmation/subscribe");

			}elseif($this->uri->segment(2) == 'success'){
				if($this->uri->segment(5)==''){
					$transId = $_REQUEST['txn_id'];
					$Pray_Email = $_REQUEST['payer_email'];
				}else{
					$transId = $this->uri->segment(5);
					$Pray_Email = '';
				}
				$this->data['Confirmation'] = $this->order_model->PaymentSuccess($this->uri->segment(3),$this->uri->segment(4),$transId,$Pray_Email);
				redirect("order/confirmation/cart");
				//$this->load->view('site/order/order.php',$this->data);
					
			}elseif($this->uri->segment(2) == 'successgift'){

				$transId = 'GIFT'.$this->uri->segment(4);
				$Pray_Email = '';
				$this->data['Confirmation'] = $this->order_model->PaymentSuccess($this->uri->segment(3),$this->uri->segment(4),$transId,$Pray_Email);
				redirect("order/confirmation");
					
			}elseif($this->uri->segment(2) == 'failure'){
				$this->data['Confirmation'] = 'Failure';
				$this->data['errors'] = $this->uri->segment(3);
				$this->load->view('site/order/order.php',$this->data);
			}elseif($this->uri->segment(2) == 'notify'){
				$this->data['Confirmation'] = 'Failure';
				$this->load->view('site/order/order.php',$this->data);
			}elseif($this->uri->segment(2) == 'confirmation'){
				$this->data['Confirmation'] = 'Success';
				$this->load->view('site/order/order.php',$this->data);
			}
				
				
		}else{
			redirect('login');
		}
	}

	public function insert_product_comment(){
		$uid= $this->checkLogin('U');
		$returnStr['status_code'] = 0;
		$comments = $this->input->post('comments');
		$product_id = $this->input->post('cproduct_id');
		$datestring = "%Y-%m-%d %h:%i:%s";
		$time = time();
		$conditionArr = array('comments'=>$comments,'user_id'=>$uid,'product_id'=>$product_id,'status'=>'InActive','dateAdded'=>mdate($datestring,$time));
		$this->order_model->simple_insert(PRODUCT_COMMENTS,$conditionArr);
		
		//Find hash tags
		preg_match_all("/(#\w+)/", $comments, $hash_tags);
		if (count($hash_tags[0])>0){
			foreach ($hash_tags[0] as $row){
				if ($row != ''){
					$dup_check = $this->order_model->get_all_details(TAGS_PRODUCT,array('tag_name'=>$row));
					if ($dup_check->num_rows() == 0){
						$dataArr = array(
							'tag_name' 	=> $row,
							'user_id'	=> $uid,
							'products'	=> $product_id,
							'products_count'	=> 1
						);
						$this->order_model->simple_insert(TAGS_PRODUCT,$dataArr);
					}else {
						$product_id_arr = array_unique(array_filter(explode(',', $dup_check->row()->products)));
						if (!in_array($product_id, $product_id_arr)){
							$product_id_arr[] = $product_id;
							$products_count = count($product_id_arr);
							$dataArr = array(
								'products'	=>	implode(',', $product_id_arr),
								'products_count' => $products_count
							);
							$this->order_model->update_details(TAGS_PRODUCT,$dataArr,array('tag_name'=>$row));
						}
					}
				}
			}
		}
		
		$cmtID = $this->order_model->get_last_insert_id();
		$datestring = "%Y-%m-%d %h:%i:%s";
		$time = time();
		$createdTime = mdate($datestring,$time);
		$actArr = array(
					'activity'		=>	'own-product-comment',
					'activity_id'	=>	$product_id,
					'user_id'		=>	$this->checkLogin('U'),
					'activity_ip'	=>	$this->input->ip_address(),
					'created'		=>	$createdTime,
					'comment_id'	=> $cmtID
		);
		$this->order_model->simple_insert(NOTIFICATIONS,$actArr);
		$this->send_comment_noty_mail($cmtID,$product_id);
		$returnStr['status_code'] = 1;
		echo json_encode($returnStr);
	}

	public function insert_tag_comment(){
		$uid= $this->checkLogin('U');
		$returnStr['status_code'] = 0;
		$comments = $this->input->post('comments');
		$product_id = $this->input->post('cproduct_id');
		$datestring = "%Y-%m-%d %h:%i:%s";
		$time = time();
		$conditionArr = array('comments'=>$comments,'user_id'=>$uid,'product_id'=>$product_id,'status'=>'InActive','dateAdded'=>mdate($datestring,$time));
		$this->order_model->simple_insert(PRODUCT_COMMENTS,$conditionArr);
		$cmtID = $this->order_model->get_last_insert_id();
		$datestring = "%Y-%m-%d %h:%i:%s";
		$time = time();
		$createdTime = mdate($datestring,$time);
		$actArr = array(
					'activity'		=>	'own-product-comment',
					'activity_id'	=>	$product_id,
					'user_id'		=>	$this->checkLogin('U'),
					'activity_ip'	=>	$this->input->ip_address(),
					'created'		=>	$createdTime,
					'comment_id'	=> $cmtID
		);
		$this->order_model->simple_insert(NOTIFICATIONS,$actArr);
		$this->send_comment_noty_mail($cmtID,$product_id);
		if (strpos($comments, '@') !== false){
			$username_str = substr($comments, strpos($comments, '@')+1);
			if ($username_str != '' && $username_str !== false){
				if (strpos($username_str, ' ') !== false){
					$mentioned_user = substr($username_str,0,strpos($username_str, ' '));
				}else {
					$mentioned_user = substr($username_str,0);
				}
			}else {
				$mentioned_user = '';
			}
		}else {
			$mentioned_user = '';
		}
		if ($mentioned_user != ''){
			$returnStr['user'] = $mentioned_user;
			$userCheck = $this->product_model->get_all_details(USERS,array('user_name'=>$mentioned_user,'status'=>'Active'));
			if ($userCheck->num_rows()==1){
				$actArr = array(
					'activity'		=>	'tagged',
					'activity_id'	=>	$userCheck->row()->id,
					'user_id'		=>	$this->checkLogin('U'),
					'activity_ip'	=>	$this->input->ip_address(),
					'created'		=>	$createdTime,
					'comment_id'	=> $cmtID
				);
				$this->order_model->simple_insert(NOTIFICATIONS,$actArr);
				$this->send_tag_noty_mail($userCheck,$product_id,$uid);
			}
		}
		$returnStr['status_code'] = 1;
		echo json_encode($returnStr);
	}

	public function send_comment_noty_mail($cmtID='0',$pid='0'){
		if ($this->checkLogin('U')!=''){
			if ($cmtID != '0' && $pid != '0'){
				$productUserDetails = $this->product_model->get_product_full_details($pid);
				if ($productUserDetails->num_rows()==1){
					$emailNoty = explode(',', $productUserDetails->row()->email_notifications);
					if (in_array('comments', $emailNoty)){
						$commentDetails = $this->product_model->view_product_comments_details('where c.id='.$cmtID);
						if ($commentDetails->num_rows() == 1){
							if ($productUserDetails->prodmode == 'seller'){
								$prodLink = base_url().'things/'.$productUserDetails->row()->id.'/'.url_title($productUserDetails->row()->product_name,'-');
							}else {
								$prodLink = base_url().'user/'.$productUserDetails->row()->user_name.'/things/'.$productUserDetails->row()->seller_product_id.'/'.url_title($productUserDetails->row()->product_name,'-');
							}
								
							$newsid='1';
							$template_values=$this->order_model->get_newsletter_template_details($newsid);
							$adminnewstemplateArr=array('email_title'=> $this->config->item('email_title'),'logo'=> $this->data['logo'],'full_name'=>$commentDetails->row()->full_name,'product_name'=>$productUserDetails->row()->product_name,'user_name'=>$commentDetails->row()->user_name);
							extract($adminnewstemplateArr);
							$subject = $template_values['news_subject'];
								
							$message .= '<!DOCTYPE HTML>
								<html>
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
								<meta name="viewport" content="width=device-width"/>
								<title>'.$template_values['news_subject'].'</title>
								<body>';
							include('./newsletter/registeration'.$newsid.'.php');
								
							$message .= '</body>
								</html>';
								
							if($template_values['sender_name']=='' && $template_values['sender_email']==''){
								$sender_email=$this->data['siteContactMail'];
								$sender_name=$this->data['siteTitle'];
							}else{
								$sender_name=$template_values['sender_name'];
								$sender_email=$template_values['sender_email'];
							}

							$email_values = array('mail_type'=>'html',
												'from_mail_id'=>$sender_email,
												'mail_name'=>$sender_name,
												'to_mail_id'=>$productUserDetails->row()->email,
												'subject_message'=>$subject,
												'body_messages'=>$message
							);
							$email_send_to_common = $this->product_model->common_email_send($email_values);
						}
					}
				}
			}
		}
	}

	public function send_tag_noty_mail($userCheck='',$pid='',$uid=''){
		if ($this->checkLogin('U')!='' || $uid != ''){
			if ($userCheck != '' && $pid != ''){
				$productUserDetails = $this->product_model->get_product_full_details($pid);
				if ($productUserDetails->num_rows()==1){
					$emailNoty = explode(',', $userCheck->row()->email_notifications);
					//					if (in_array('tag', $emailNoty)){
					if ($productUserDetails->prodmode == 'seller'){
						$prodLink = base_url().'things/'.$productUserDetails->row()->id.'/'.url_title($productUserDetails->row()->product_name,'-');
					}else {
						$prodLink = base_url().'user/'.$productUserDetails->row()->user_name.'/things/'.$productUserDetails->row()->seller_product_id.'/'.url_title($productUserDetails->row()->product_name,'-');
					}

					$newsid='11';
					$template_values=$this->order_model->get_newsletter_template_details($newsid);
					$adminnewstemplateArr=array(
						'email_title'=> $this->config->item('email_title'),
						'logo'=> $this->data['logo'],
						'full_name'=>$this->data['userDetails']->row()->full_name,
						'product_name'=>$productUserDetails->row()->product_name,
						'user_name'=>$this->data['userDetails']->row()->user_name
					);
					extract($adminnewstemplateArr);
					$subject = $template_values['news_subject'];

					$message .= '<!DOCTYPE HTML>
							<html>
							<head>
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
							<meta name="viewport" content="width=device-width"/>
							<title>'.$template_values['news_subject'].'</title>
							<body>';
					include('./newsletter/registeration'.$newsid.'.php');

					$message .= '</body>
							</html>';

					$email_values = array('mail_type'=>'html',
											'from_mail_id'=>$this->data['siteContactMail'],
											'mail_name'=>$this->data['siteTitle'],
											'to_mail_id'=>$userCheck->row()->email,
											'subject_message'=>$subject,
											'body_messages'=>$message
					);
					$email_send_to_common = $this->product_model->common_email_send($email_values);
					//					}
				}
			}
		}
	}

}

