<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
 * Description of home
 * @author Kallol
 */

class User extends MY_Controller {

    //put your code here
	public $cls_msg;
    public $filter_access = array('user' => 'profile');
	public $left_mnu;

    public function __construct() {

        parent::__construct();

         $this->load->model('user_model');
         $this->load->model('user_fav_deals_model');
         $this->load->model('user_sub_deals_model');
		 
		 $this->cls_msg["invite_succ"] 	= 'Invitation send successfully.';
		 $this->cls_msg["invite_err"] 	= 'Invitation sending failed.';

    }



    public function index($paging = 0) {

        $data = array('title' => 'Title');
       // pr($this->session->userdata('current_user_session'));
        $this->render($data);
    }



    public function profile($paging = 0) {

		$user_meta = $this->session->userdata('current_user_session');
		
		$sess_ads_url_click = $this->session->userdata('sess_ads_url_click');
		if($sess_ads_url_click)
		{
			$new_url = str_replace('MYDEALFOUNDXXX',$user_meta[0]['s_uid'],$sess_ads_url_click);		
			$this->session->unset_userdata('sess_ads_url_click');	
			redirect($new_url);
		}
		
		$sess_store_url_click = $this->session->userdata('sess_store_url_click');
		if($sess_store_url_click)
		{
			$uid = $user_meta[0]['s_uid'];
			$sess_store_url_click = str_replace('MYDEALFOUNDXXX',$uid,$sess_store_url_click);
			$new_url = $sess_store_url_click."&UID=$uid";	
			
			$this->session->unset_userdata('sess_store_url_click');	
			redirect($new_url);
		}
		
        $choosen_deal_id = $this->session->userdata('choosen_deal_id');
        $choosen_type = $this->session->userdata('choosen_type');
        if ($choosen_type == 'fav') {
            $this->add_favourite($choosen_deal_id);
        }
        if ($choosen_type == 'sub') {
             $this->add_subscribe($choosen_deal_id);
        }

        $this->session->unset_userdata('choosen_deal_id');
        $this->session->unset_userdata('choosen_type');
        $cashback_deal_id = $this->session->userdata('cash_back_request');
        $cashback_deal_id = $this->session->userdata('cash_back_request');

        if ($cashback_deal_id) {
            $this->session->unset_userdata('cash_back_request');
            redirect(base_url() . 'track/' . $cashback_deal_id);
        }
        $data = array('title' => 'Profile');

        
        /*** left section of my earning ***/		
		// 16Apr 2014 , data comes from cashback_earned and cashback_paid tables
		$condition = " WHERE user_id='".$user_meta[0]['i_id']."' AND i_status=1 ";
		$earningData = $this->user_model->cashback_earned($condition); 
        $data['earningData']['Cashback Earned'] = 'Rs '.($earningData[0]['tot_earn']?number_format($earningData[0]['tot_earn'],2):"0.00").'';  
		
		$paidData = $this->user_model->cashback_paid($condition); 
        $data['earningData']['Paid Cashback'] = 'Rs '.($paidData[0]['tot_paid']?number_format($paidData[0]['tot_paid'],2):"0.00").'';
		 
		$available = ($earningData[0]['tot_earn']-$paidData[0]['tot_paid']);
		$data['earningData']['Available For Withdraw'] = 'Rs '.($available?number_format($available,2):"0.00");
		
		$condition = " WHERE user_id='".$user_meta[0]['i_id']."' AND i_status=0 ";
		//$pendingData = $this->user_model->cashback_paid($condition);
		$pendingData = $this->user_model->cashback_earned($condition);
		$data['earningData']['Pending Cashback'] = 'Rs '.($pendingData[0]['tot_earn']?number_format($pendingData[0]['tot_earn'],2):"0.00").'';  
		
		$condition = " WHERE user_id='".$user_meta[0]['i_id']."' AND i_status=1 AND earning_type=1 ";
		$ref = $this->user_model->cashback_earned($condition); 
		$data['earningData']['Referral Earning'] = 'Rs '.($ref[0]['tot_earn']?number_format($ref[0]['tot_earn'],2):"0.00").'';  
		/*** left section of my earning ***/	
    
		
        $cms = $this->cms_model->get_list(array('i_id'=>8),'en_s_description as s_description,en_s_title as s_title',1);
        $data['earningCms'] = $cms[0];

        $data['user_meta']['s_name'] = $user_meta[0]['s_name'];
        $data['user_meta']['s_email'] = $user_meta[0]['s_email'];
        $data['user_meta']['transaction_details'] = $user_meta[0]['txt_transaction_details'];
        $data['display_favour_listing'] = $this->favourite_listing($paging, TRUE);
        $data['display_subs_listing'] = $this->subscribed_list($paging, TRUE);
        //$data['display_tracked_listing'] = $this->tracked_listing($paging, TRUE);
        $this->render($data);

    }



    public function update_details() {

        $data = array('title' => 'Profile');

        $user_meta = $this->session->userdata('current_user_session');

        $postedData = $this->input->post();

        if ($postedData) {

            $userData = array(

                's_email' => trim($postedData['email']),

                's_name' => trim($postedData['name']),

                'txt_transaction_details' => trim($postedData['transaction_details']),

                'txt_password' => trim($postedData['password'])

            );

            $this->user_model->update_data($userData, array('i_id' => $user_meta[0]['i_id']));

            if (true) {

                $userData = $this->user_model->get_list(array('i_id' => $user_meta[0]['i_id']));

                $this->session->set_userdata('current_user_session', $userData);

                echo json_encode(array('status' => 'success', 'message' => 'Success'));

            } else {

                echo json_encode(array('status' => 'error', 'message' => 'Fatal Error'));

            }

        } else {

            echo json_encode(array('status' => 'error', 'message' => 'Another Fatal Error'));

        }

    }


    public function tracked_cashback_listing($paging = 0, $returnData = false) {

        $search_condition = array();

        $user_meta = $this->session->userdata('current_user_session');

        /*         * generate ajax view of filtered list* */

        $generatedData = $this->process_tracked_deal_list($search_condition, 'Tracked Listing', $paging, 6, base_url() . 'user/subscribed_list/', 3, NULL, TRUE);

        if ($returnData)

            return $generatedData;

        else

            echo $generatedData;

    }


    public function login_old_backup_b4_3Apr2014() {

        $postedData = $this->input->post();

        if (isset($postedData['choosen_deal_id'])) {

            $this->session->set_userdata('choosen_deal_id', $postedData['choosen_deal_id']);
            $this->session->set_userdata('choosen_type', $postedData['choosen_type']);
        }

        $userData = $this->user_model->get_list(
                array(
                    's_email' => trim($postedData['email']),
                    'txt_password' => md5(trim($postedData['password']))
                ));
	
        if ($userData) {
            $this->session->set_userdata('current_user_session', $userData);
            if (!isset($postedData['choosen'])) {

            }

            echo json_encode(array('status' => 'success', 'message' => 'Success'));

        } else {

            echo json_encode(array('status' => 'error', 'message' => 'Login Failed'));

        }

    }
	
	
	/* modified on april 2014 
	* can login after user account activation 
	* previously it was just login automatically after regn.
	*/
	public function login() {
		
		$user_meta = $this->session->userdata('current_user_session');
		if(!empty($user_meta))
			redirect(base_url().'user/profile');

        $postedData = $this->input->post();
		if($postedData)
		{

			if (isset($postedData['choosen_deal_id'])) {
				$this->session->set_userdata('choosen_deal_id', $postedData['choosen_deal_id']);
				$this->session->set_userdata('choosen_type', $postedData['choosen_type']);
			}
	
			$userData = $this->user_model->get_list(
					array(
						's_email' => trim($postedData['email']),
						'txt_password' => md5(trim($postedData['password']))
					));
		
			if ($userData) {
				//$this->session->set_userdata('current_user_session', $userData);
				if (!isset($postedData['choosen'])) {
	
				}
				if($userData[0]["i_active"]==1)
				{
					$this->session->set_userdata('current_user_session', $userData);
					echo json_encode(array('status' => 'success', 'message' => 'Success'));
				}
				else
				{
					echo json_encode(array('status' => 'error', 'message' => 'User not activated.'));
				}
	
			} else {
	
				echo json_encode(array('status' => 'error', 'message' => 'Wrong information.'));
	
			}
			
		
		}		
		else {
            $this->render($data);
        }

    }



    public function logout() {

        $this->session->unset_userdata('current_user_session');

        redirect(base_url());

    }
	
	/* modified on march 2014 
	* password made with md5# values, previously it was just a text
	*/
    public function signup_old_backup_b4_3Apr2014($referrerId='') {
	
		$data = array('title' => 'Sign up');		
        $postedData = $this->input->post();
		
        $this->session->set_userdata('choosen_deal_id', $postedData['choosen_deal_id']);

        if ($postedData) {
			
			$uniqId = genRandomUserId();			
			if($referrerId!="")
			{
				// check if referrer id exist or not
				$chk = $this->user_model->get_list(array('s_referrer_id' =>$referrerId));
				if(!empty($chk))
					$referrerId = $referrerId;
				else
					$referrerId = '';
			}
			
            $userData = array(
                's_email' => trim($postedData['email']),
                's_name' => trim($postedData['name']),
                'txt_password' => md5(trim($postedData['password'])),
                //'s_uid' => random_string('unique', 10)
				's_uid' => $uniqId,
				's_referrer_id'=>$referrerId

            );
			
            $last_inserted_id = $this->user_model->insert_data($userData);
			//echo $this->db->last_query();exit;;
            if ($last_inserted_id){

                $userData = $this->user_model->get_list(array('i_id' => $this->db->insert_id()));
                $this->session->set_userdata('current_user_session', $userData);
				/************* sent mail ****************/
				$this->load->model('auto_mail_model','mod_auto');
				$this->load->model('site_settings_model','mod_rect');
				$info			= $this->mod_rect->fetch_this(NULL);
				
				$admin_email	= $info['s_admin_email'];
				$content 		= $this->mod_auto->fetch_mail_content('welcome','general');    
				
				$s_subject 		= $content['s_subject'];						
				$filename   	= $this->config->item('EMAILBODYHTML')."common.html";
				$handle     	= @fopen($filename, "r");
				$mail_html  	= @fread($handle, filesize($filename));  
					
				if(!empty($content))
				{                            
					$description = $content["s_content"];
					$description = str_replace("[USER]",$postedData['email'],$description);
					$description = str_replace("[PASSWORD]",$postedData['password'],$description);
				}					
			  	unset($content);			  
			    $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);					 
			    $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);											  
			    //pr($mail_html,1);
			    $i_sent = sendMail($postedData['email'],$s_subject,$mail_html,$admin_email);
			    /************* sent mail end ****************/

                echo json_encode(array('status' => 'success', 'message' => 'Success'));
            } 
			else 
			{
                echo json_encode(array('status' => 'error', 'message' => 'Fatal Error'));
            }

        } else {
            $this->render($data);
        }
		
    }
	
	
	public function signup($referrerId='') {
	
		$user_meta = $this->session->userdata('current_user_session');
		if(!empty($user_meta))
			redirect(base_url().'user/profile');
	
		$ref_id=$referrerId;
		// check if referrer id exist or not
		//$chk = $this->user_model->get_list(array('s_referrer_id' =>$referrerId));
		$chk = $this->user_model->get_list(array('s_uid' =>$referrerId));		
		//$this->session->unset_userdata('user_referrerId');
		//$_SESSION['user_referrerId'] = 	"";
		if(!empty($chk))
		{
			$this->session->set_userdata('user_referrerId', $referrerId);
			$_SESSION['user_referrerId'] = 	$referrerId;		
		}
		 
		
		$data = array('title' => 'Sign up');	
			
        $postedData = $this->input->post();
		
        $this->session->set_userdata('choosen_deal_id', $postedData['choosen_deal_id']);
		
		
        if ($postedData) {
						
			$referrerId = $_SESSION['user_referrerId']?$_SESSION['user_referrerId']:""; 
			
			$uniqId = genRandomUserId();	  // @see common_helper.php
			$activation_code = genActivationCode(); // @see common_helper.php		
			if($referrerId!="")
			{
				// check if referrer id exist or not
				//$chk = $this->user_model->get_list(array('s_referrer_id' =>$referrerId));
				$chk = $this->user_model->get_list(array('s_uid' =>$referrerId));
				//echo '===>'.$referrerId; pr($chk);
				if(!empty($chk))
					$referrerId = $referrerId;
				else
					$referrerId = '';
			}
			
            $userData = array(
                's_email' => trim($postedData['email']),
                's_name' => trim($postedData['name']),
                'txt_password' => md5(trim($postedData['password'])),
                //'s_uid' => random_string('unique', 10)
				'i_active'=>0,
				's_uid' => $uniqId,
				's_referrer_id'=>$referrerId,
				's_activation_code'=>$activation_code,
				's_org_pwd'=>trim($postedData['password'])

            );
			
            $last_inserted_id = $this->user_model->insert_data($userData);
			//$last_inserted_id = true;
            if ($last_inserted_id){
			
				// insert into cd_cashback_earned table for 50/- after registration
				$cb_arr = array();
				$cb_arr['user_id'] 	= $last_inserted_id;				
				$cb_arr['d_amount'] = 50;
				$cb_arr['cashback_amount'] = 50;
				$cb_arr['product_name'] = 'Cashback Earned From Registration';
				$cb_arr['s_particulars'] = 'registration';
				$cb_arr['dt_of_payment'] = date("Y-m-d H:i:s",time());
				$cb_arr['i_status'] 		= 1;		
				if($referrerId!='')				
				{
					$ref_user_id = getUserIdByCondn("WHERE s_uid='".my_receive_text($referrerId)."' ");	 // @see common_helper.php
					$cb_arr['referral_id'] 		= $referrerId;	
					$cb_arr['referral_user_id']	= $ref_user_id;	
				}		
				$i_cb = $this->user_model->add_cashback_earned($cb_arr);
				

                //$userData = $this->user_model->get_list(array('i_id' => $this->db->insert_id()));
                //$this->session->set_userdata('current_user_session', $userData);
				
				// update invitation tbl
				if($referrerId!='')
				{
					$arr_invite["i_status"]= 1;
					$cond_arr = array('s_referrer_code'=>$referrerId,'s_email'=>trim($postedData['email']));
					$i_aff = $this->user_model->update_invitation_info($arr_invite,$cond_arr);
				}
				
				
				/************* sent mail ****************/
				$this->load->model('auto_mail_model','mod_auto');
				$this->load->model('site_settings_model','mod_rect');
				$info			= $this->mod_rect->fetch_this(NULL);
				
				$admin_email	= $info['s_admin_email'];
				$content 		= $this->mod_auto->fetch_mail_content('activate_mail','general');    
				
				$s_subject 		= $content['s_subject'];						
				$filename   	= $this->config->item('EMAILBODYHTML')."common.html";
				$handle     	= @fopen($filename, "r");
				$mail_html  	= @fread($handle, filesize($filename));  
					
				if(!empty($content))
				{                            
					$description = $content["s_content"];
					$description = str_replace("[NAME]",trim($postedData['name']),$description);
					$description = str_replace("[ACTIVATE_URL]",base_url().'user/activate/'.$activation_code,$description);
				}					
			  	unset($content);			  
			    $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);					 
			    $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);											  
			    //pr($mail_html,1);
			    $i_sent = sendMail($postedData['email'],$s_subject,$mail_html,$admin_email);
			    /************* sent mail end ****************/
				
				$msg = array();
				$msg['message'] = 'Your registration successfull. An activation email has been sent to registered mail.';
				$msg['message_type'] = 'succ';
				$this->session->set_userdata('msg_session', $msg);
				$_SESSION['user_referrerId'] = "";
                echo json_encode(array('status' => 'success', 'message' => 'Success'));
            } 
			else 
			{
				$msg = array();
				$msg['message'] = 'Your registration failed. Please try again!';
				$msg['message_type'] = 'err';
				$this->session->set_userdata('msg_session', $msg);
				
                echo json_encode(array('status' => 'error', 'message' => 'Fatal Error'));
            }

        } else {
            $this->render($data);
        }
		
    }


	/* activate registration account */
	public function activate($activation_code='')	
	{
		if($activation_code=='')
			redirect(base_url().'user/signup');
		else
		{
			$userData = $this->user_model->get_list(array('s_activation_code' => $activation_code));
			if(!empty($userData))
			{
				if($userData[0]['i_active']==1)
				{
					$msg = array();
					$msg['message'] = 'Your account already been activated.';
					$msg['message_type'] = 'succ';
					$this->session->set_userdata('msg_session', $msg);
					redirect(base_url().'user/message');
				}
				else
				{
					//pr($userData[0]);
					$update_data = array();
					$update_data['i_active'] = 1;
					$condition = array('s_activation_code' => $activation_code);
					$i_aff = $this->user_model->update_data($update_data,$condition);
					if($i_aff)
					{
						/************* sent mail ****************/
						$this->load->model('auto_mail_model','mod_auto');
						$this->load->model('site_settings_model','mod_rect');
						$info			= $this->mod_rect->fetch_this(NULL);
						$admin_email	= $info['s_admin_email'];
						$content 		= $this->mod_auto->fetch_mail_content('welcome','general');    
						//pr($content,1);
						$s_subject 		= $content['s_subject'];						
						$filename   	= $this->config->item('EMAILBODYHTML')."common.html";
						$handle     	= @fopen($filename, "r");
						$mail_html  	= @fread($handle, filesize($filename));  
							
						if(!empty($content))
						{                            
							$description = $content["s_content"];
							$description = str_replace("[NAME]",trim($userData[0]['s_name']),$description);
							$description = str_replace("[EMAIL]",$userData[0]['s_email'],$description);
							$description = str_replace("[PASSWORD]",$userData[0]['s_org_pwd'],$description);
						}					
						unset($content);			  
						$mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);					 
						$mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);											  
						//pr($mail_html,1);
						$i_sent = sendMail($userData[0]['s_email'],$s_subject,$mail_html,$admin_email);
						/************* sent mail end ****************/
						
						$msg = array();
						$msg['message'] = 'Your account has been activated successfully. You can now login.';
						$msg['message_type'] = 'succ';
						$this->session->set_userdata('msg_session', $msg);
						//echo $this->session->userdata('message'); exit;
						redirect(base_url().'user/message');
					}
					else
					{	
						$msg = array();
						$msg['message'] = 'Account activation failed.';
						$msg['message_type'] = 'err';
						$this->session->set_userdata('msg_session', $msg);	
						redirect(base_url().'user/message');
					}
				}
			}
			else			
			{		
				$msg = array();
				$msg['message'] = 'Your account does not exist.';
				$msg['message_type'] = 'err';
				$this->session->set_userdata('msg_session', $msg);	 		
				redirect(base_url().'user/message');
			}
		}
		
		//$this->render($data);
	}

	public function message()	
	{
		$msg = $this->session->userdata('msg_session');
		$data['title'] = 'Account Activation';
		$data['message'] = $msg['message'];
		$data['message_type'] = $msg['message_type'];
		$this->render($data);
	}
	
	/* end activate registration*/
	
	
    /*   
     * 
     * functionality need to be implemented
     * 
     */
    public function forget_password() {

        $data = array('title' => 'Forget Password');
        $postedData = $this->input->post();
        //pr($postedData);

        if ($postedData) {
			$userData = $this->user_model->get_list(array('s_email' => $postedData['email']));
            if ($userData) {
				$new_pwd = genRandomUserId();
				$new_arr = array();
				$new_arr['txt_password'] = md5(trim($new_pwd));
				$new_arr['s_org_pwd'] = trim($new_pwd);
				
				$condition = array('s_email' => $postedData['email']);
				$i_aff = $this->user_model->update_data($new_arr,$condition);
				if($i_aff)				
				{
					/************* sent mail ****************/
					$this->load->model('auto_mail_model','mod_auto');
					$this->load->model('site_settings_model','mod_rect');
					$info			= $this->mod_rect->fetch_this(NULL);
					$admin_email	= $info['s_admin_email'];
					$content 		= $this->mod_auto->fetch_mail_content('forget_password','general');    
					//pr($content,1);
					$s_subject 		= $content['s_subject'];						
					$filename   	= $this->config->item('EMAILBODYHTML')."common.html";
					$handle     	= @fopen($filename, "r");
					$mail_html  	= @fread($handle, filesize($filename));  
						
					if(!empty($content))
					{                            
						$description = $content["s_content"];
						$description = str_replace("[LOGIN_URL]",base_url().'user/signup',$description);
						$description = str_replace("[EMAIL]",$userData[0]['s_email'],$description);
						$description = str_replace("[PASSWORD]",$new_pwd,$description);
					}					
					unset($content);			  
					$mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);					 
					$mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);											  
					//pr($mail_html,1);
					$i_sent = sendMail($userData[0]['s_email'],$s_subject,$mail_html,$admin_email);
					/************* sent mail end ****************/
                	echo json_encode(array('status' => 'success', 'message' => 'Please check your mail for password'));
				}
				else
					echo json_encode(array('status' => 'error', 'message' => 'Oops! Please try again!'));
					
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'User does not exist'));
            }

        } else {
            $data['captchaImage'] = $this->refresh_captcha(true);
            $this->render($data);
        }

    }


	  
    /**
    * Validating captcha
    */
        
    public function captcha_valid()
    {
		$s_captcha = trim($this->input->post('captcha'));
        if($s_captcha!=$_SESSION["captcha"])
        {
           echo json_encode(array('status'=>'failed'));
        }
        else
        {
           echo json_encode(array('status'=>'success'));
        }
    }

    public function duplicate_check() {

        $postedItem = $this->input->post('duplicate');

        $isExist = $this->user_model->count_total(array('s_email' => trim($postedItem)));

        if ($isExist) {

            echo json_encode(array('status' => 'error', 'message' => 'Email is already registered'));

        } else {

            echo json_encode(array('status' => 'success', 'message' => 'Email is not registered'));

        }

    }


	/* 1Apr 2014 
	* called from top offers details pagge
	* new table for cd_deals
	*/
	
	 public function add_favourite_deal($i_deal_id = NULL) {       

        if ($this->input->post('choosen_deal_id')) {
            $i_deal_id = $this->input->post('choosen_deal_id');
        }
        $user_meta = $this->session->userdata('current_user_session');
		
		$s_cond = " WHERE i_user_id='".$user_meta[0]['i_id']."' AND i_deal_id='".my_receive_text($i_deal_id)."' AND i_type=2 ";
        $existing = $this->manage_deals_model->get_user_fav_deals($s_cond);
       // pr($existing,1);
        if (!empty($existing)) {
            if ($this->input->post('choosen_deal_id')) {
                echo json_encode(array('status' => 'success', 'message' => 'already exists'));
                return $existing[0];
            }
        }
        $insertData = array(
            'i_user_id' => $user_meta[0]['i_id'],
            'i_deal_id' => $i_deal_id,
			'i_type' => 2,  // 2->cd_deals table, 1->cd_coupon table
            'txt_extra' => json_encode($_SERVER)
        );

        $last_inserted_id = $this->manage_deals_model->insert_fav_deals($insertData);

        if ($this->input->post('choosen_deal_id') && $last_inserted_id) {
            echo json_encode(array('status' => 'success', 'message' => 'Added to your favourite list'));
        }
        return $last_inserted_id;

    }
	
	 public function add_subscribe_deal($i_deal_id = NULL) {       

        if ($this->input->post('choosen_deal_id')) {
            $i_deal_id = $this->input->post('choosen_deal_id');
        }
        $user_meta = $this->session->userdata('current_user_session');
		
		$s_cond = " WHERE i_user_id='".$user_meta[0]['i_id']."' AND i_deal_id='".my_receive_text($i_deal_id)."' AND i_type=2 ";
        $existing = $this->manage_deals_model->get_user_subscribe_deals($s_cond);
       // pr($existing,1);
        if (!empty($existing)) {
            if ($this->input->post('choosen_deal_id')) {
                echo json_encode(array('status' => 'success', 'message' => 'already exists'));
                return $existing[0];
            }
        }
        $insertData = array(
            'i_user_id' => $user_meta[0]['i_id'],
            'i_deal_id' => $i_deal_id,
			'i_type' => 2,  // 2->cd_deals table, 1->cd_coupon table
            'txt_extra' => json_encode($_SERVER)
        );

        $last_inserted_id = $this->manage_deals_model->insert_subscribe_deals($insertData);

        if ($this->input->post('choosen_deal_id') && $last_inserted_id) {
            echo json_encode(array('status' => 'success', 'message' => 'Added to your subscribe list'));
        }
        return $last_inserted_id;

    }

	/* end
	* called from top offers details pagge
	* new table for cd_deals
	*/
    
    

    public function add_favourite($i_deal_id = NULL) {
       

        if ($this->input->post('choosen_deal_id')) {
            $i_deal_id = $this->input->post('choosen_deal_id');
        }

        $user_meta = $this->session->userdata('current_user_session');
        $existing = $this->user_fav_deals_model->get_list(array('i_user_id' => $user_meta[0]['i_id'], 'i_deal_id' => $i_deal_id));

       // pr($existing,1);

        if (!empty($existing)) {
            if ($this->input->post('choosen_deal_id')) {
                echo json_encode(array('status' => 'success', 'message' => 'already exists'));
                return $existing[0];
            }
        }

        $insertData = array(
            'i_user_id' => $user_meta[0]['i_id'],
            'i_deal_id' => $i_deal_id,
            'txt_extra' => json_encode($_SERVER)
        );

        $last_inserted_id = $this->user_fav_deals_model->insert_data($insertData);

        if ($this->input->post('choosen_deal_id') && $last_inserted_id) {
            echo json_encode(array('status' => 'success', 'message' => 'Added to your favourite list'));
        }
        return $last_inserted_id;

    }

    public function add_subscribe($i_deal_id = NULL) {       

        if ($this->input->post('choosen_deal_id')) {
            $i_deal_id = $this->input->post('choosen_deal_id');
        }
        $user_meta = $this->session->userdata('current_user_session');
        $existing = $this->user_sub_deals_model->get_list(array('i_user_id' => $user_meta[0]['i_id'], 'i_deal_id' => $i_deal_id));
       //pr($existing,1);

        if (!empty($existing)) {
            if ($this->input->post('choosen_deal_id')) {
                echo json_encode(array('status' => 'success', 'message' => 'already exists'));
                return $existing[0];
            }
        }

        $insertData = array(
            'i_user_id' => $user_meta[0]['i_id'],
            'i_deal_id' => $i_deal_id,
            'txt_extra' => json_encode($_SERVER)
        );

        $last_inserted_id = $this->user_sub_deals_model->insert_data($insertData);

        if ($this->input->post('choosen_deal_id') && $last_inserted_id) {
            echo json_encode(array('status' => 'success', 'message' => 'Added to your subscribe list'));
        }

        return $last_inserted_id;

    }
	
	
	/* new functions after menu style changed 
	* 18Mar 2014
	*/
    public function details() {

       
        $data = array('title' => 'Personal Details');
        $user_meta = $this->session->userdata('current_user_session');
		$data["lft_mnu"] =1;
        /***
         * left section of my earning
         */
        $earningData = $this->user_deals_model->total_cashback_earned($user_meta[0]['i_id']); 
        $data['earningData']['Cashback Earned'] = 'Rs '.$earningData[0]['total'].'';  
		$data['earningData']['Paid Cashback'] = 'Rs 100';  
		$data['earningData']['Available For Withdraw'] = 'Rs 100';
		$data['earningData']['Pending Cashback:'] = 'Rs 100'; 
       
        $data['user_meta']['s_name'] = $user_meta[0]['s_name'];
        $data['user_meta']['s_email'] = $user_meta[0]['s_email'];
        $data['user_meta']['transaction_details'] = $user_meta[0]['txt_transaction_details'];
		
        $this->render($data);

    }
	
	public function update_personal_info() {

        $data = array('title' => 'Profile');
        $user_meta = $this->session->userdata('current_user_session');
        $postedData = $this->input->post();
        if ($postedData) {
            $userData = array(
                's_email' => trim($postedData['email']),
                's_name' => trim($postedData['name'])
            );
            $this->user_model->update_data($userData, array('i_id' => $user_meta[0]['i_id']));

            if (true) {

                $userData = $this->user_model->get_list(array('i_id' => $user_meta[0]['i_id']));
                $this->session->set_userdata('current_user_session', $userData);
                echo json_encode(array('status' => 'success', 'message' => 'Success'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Fatal Error'));
            }
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Another Fatal Error'));
        }

    }
	
	public function password() {

       
        $data = array('title' => 'Change Password');
		$data["lft_mnu"] =3;
        $user_meta = $this->session->userdata('current_user_session');
       		
        $this->render($data);

    }
	
	public function update_password() {

        $data = array('title' => 'Profile');
		$data["lft_mnu"] =3;
        $user_meta = $this->session->userdata('current_user_session');
        $postedData = $this->input->post();

        if ($postedData) {

            $userData = array(
                'txt_password' => md5(trim($postedData['password'])),				
				's_org_pwd'=> trim($postedData['password'])
            );

            $this->user_model->update_data($userData, array('i_id' => $user_meta[0]['i_id']));
            if (true) {
                $userData = $this->user_model->get_list(array('i_id' => $user_meta[0]['i_id']));
                $this->session->set_userdata('current_user_session', $userData);
                echo json_encode(array('status' => 'success', 'message' => 'Success'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Fatal Error'));
            }
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Another Fatal Error'));
        }

    }
	
	
	public function invite() {
        $data = array('title' => 'Invite Friend');
		$data["lft_mnu"] =7;
        $user_meta = $this->session->userdata('current_user_session');
		//pr($user_meta);
		if(empty($user_meta))
			redirect(base_url().'user/signup');
		
		$data["ref_id"] 	= $user_meta[0]["s_uid"];		
		$data["ref_name"]	= $user_meta[0]["s_name"];	
		$data["ref_id"] 	= base_url().'user/signup/'.$user_meta[0]["s_uid"];
		
		$msg = $this->session->userdata('invite_msg_session');
		$this->session->unset_userdata('invite_msg_session');
		$data['title'] = 'Account Activation';
		$data['message'] = $msg['message'];
		$data['message_type'] = $msg['message_type'];
		
		 if($_POST)
		 {
		  	$posted	=	array();
			foreach($_POST['email_arr'] as $emails)
			{			 
				$emails = trim($emails);
			 	if(!empty($emails))
			 	$all_mail[]	=	$emails;			 		 
			}			
			//print_r($all_mail); exit;			
			foreach($_POST['name_arr'] as $names)
			{
				$names = trim($names);
			 	if(!empty($names))
			 	$all_name[]	=	$names;				
			}
			
			$duplicate = false;
			$ar_recom = array();
			$ar_ext = array();
			$count = 0;
			for($i=0;$i<count($all_mail); $i++)
			{			
				$i_newid = false;	
				$info["dt_invite"] 			= date("Y-m-d H:i:s");	
				$info["s_email"] 			= $all_mail[$i];
				$info["s_name"] 			= $all_name[$i];
				$info["i_inviter"] 			= $user_meta[0]["i_id"];
				$info["s_referrer_code"]	= $user_meta[0]["s_uid"];				
				$s_referrer_code 			= $user_meta[0]["s_uid"];
				
				$chk_val = $this->user_model->check_invite($all_mail[$i],$user_meta[0]["i_id"]);
				//$i_newid =true;	
				if($chk_val==0)	
				{				
					//$i_newid	=	$this->user_model->add_invite($all_mail[$i],$all_name[$i],$info,$user_meta[0]["i_id"]);
					$i_newid	=	$this->user_model->add_invite($info);
				}
				else
				{
					$duplicate = true;
					if($chk_val==1)	
					{
						$ar_recom[] = $all_mail[$i];
					}				
					elseif($chk_val==2)
					{
						$ar_ext[] = $all_mail[$i];
					}
				}
				/************** for referred verification mail to the user ************/
				if($i_newid)
				{					
					$count++;
					$this->load->model('auto_mail_model','mod_auto');
					$this->load->model('site_settings_model','mod_rect');
					$admin_info			= $this->mod_rect->fetch_this(NULL);
					
					$admin_email	= $admin_info['s_admin_email'];
					//$content 		= $this->mod_auto->fetch_mail_content('share_mydeal','general');    
					$content 		= $this->mod_auto->fetch_mail_content('join_mydeal','general'); 
					
					$s_subject 		= $content['s_subject'];						
					$filename   	= $this->config->item('EMAILBODYHTML')."common.html";
					$handle     	= @fopen($filename, "r");
					$mail_html  	= @fread($handle, filesize($filename));  
						
					if(!empty($content))
					{                            
						$description = $content["s_content"];
						//$description = str_replace("[USER]",$info["s_name"],$description);
						$description = str_replace("[USERNAME]",$user_meta[0]["s_name"],$description);
						$description = str_replace("[JOIN_URL]",base_url().'user/signup/'.$s_referrer_code,$description);
					}					
					unset($content);			  
					$mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);					 
					$mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);										  
					//pr($mail_html,1);
					$i_nwid = sendMail($info["s_email"],$s_subject,$mail_html,$admin_email);	
					//$i_nwid = true;	
					//pr($mail_html,1);		
				}
				/************** for referred verification mail to the user ************/
				
				
			} // end for loop
			
			if($i_newid)////saved successfully
			{
				$msg =array();
				if($duplicate)
				{
					
					if(count($ar_recom)>0)
					{
						$s_email = implode(", ",$ar_recom);
						$msg[] = $s_email." email(s) are already recomended by you.";						
					}
					if(count($ar_ext)>0)
					{
						$s_email = implode(", ",$ar_ext);
						$msg[] = $s_email." email(s) are already registered.";						
					}
					
				}     
				if(count($msg)>0)      
					$s_part = implode(" <br/>",$msg).'<br/>';
				else
					$s_part = "";   
					
				$sess_msg = array();
				$sess_msg['message'] = $s_part.' '.$count.' '.$this->cls_msg["invite_succ"];
				$sess_msg['message_type'] = 'succ';
				$this->session->set_userdata('invite_msg_session', $sess_msg);	
				//$this->session->set_userdata(array('message'=>$s_part.' '.$count.' '.$this->cls_msg["invite_succ"],'message_type'=>'succ'));
				redirect(base_url().'user/invite');
			}
			else///Not saved, show the form again
			{
				$msg =array();
				if($duplicate)
				{
					if(count($ar_recom)>0)
					{
						$s_email = implode(", ",$ar_recom);
						$msg[] = $s_email." email(s) are already recomended by you.";
					
					}
					if(count($ar_ext)>0)
					{
						$s_email = implode(", ",$ar_ext);
						$msg []= $s_email." email(s) are already registered.";
					
					}
					
				}  
				if(count($msg)>0)      
					$s_part = implode(" <br/>",$msg).'<br/>';
				else
					$s_part = "";
					
				$sess_msg = array();
				$sess_msg['message'] = $s_part.$this->cls_msg["invite_err"];
				$sess_msg['message_type'] = 'err';
				$this->session->set_userdata('invite_msg_session', $sess_msg);				
				//$this->session->set_userdata(array('message'=>$s_part.$this->cls_msg["invite_err"],'message_type'=>'err'));
				redirect(base_url().'user/invite');
				
				//set_error_msg($this->cls_msg["save_recommend"]);
			}
			
		  }
       		
        $this->render($data);

    }
	
	
	public function referrals() {
        $data = array('title' => 'Invite Friend');
		$data["lft_mnu"] =8;
        $user_meta = $this->session->userdata('current_user_session');
		
		if(empty($user_meta))
			redirect(base_url().'user/signup');
		
		$data["ref_id"] = $user_meta[0]["s_uid"];
       	$condition = " WHERE i_inviter = '".$user_meta[0]["i_id"]."' ";
		$data["invites"] =  $this->user_model->get_invite_list($condition);
		
        $this->render($data);

    }
	
	public function payment() {
        $data = array('title' => 'Payment Setting');
		$data["lft_mnu"] =2;
        $user_meta = $this->session->userdata('current_user_session');
		
		if(empty($user_meta))
			redirect(base_url().'user/signup');
		
		$data["ref_id"] = $user_meta[0]["s_uid"];
       	$condition = " WHERE i_user_id = '".$user_meta[0]["i_id"]."' ";
		$data["pay_info"] =  $this->user_model->get_payment_info($condition);
		
		$msg = $this->session->userdata('invite_msg_session');
		$this->session->unset_userdata('invite_msg_session');
		$data['message'] = $msg['message'];
		$data['message_type'] = $msg['message_type'];
		
		$pay_type = 'neft';
		
		$withdrawl_session = $this->session->userdata('withdrawl_session'); // july 2014 
		if(!empty($withdrawl_session))
		{
			$pay_type = $withdrawl_session['withdrawl_mode'];
		}
		$data["withdrawl_session"] = !empty($withdrawl_session)?$withdrawl_session:"";
		
		if($_POST)
		{
			$pay_type = $_POST['pay_type'];
						
			if($pay_type=='neft')
			{
				$new_arr = array();
				$new_arr["s_neft_name"] 		= $_POST["s_neft_name"];
				$new_arr["s_neft_bank_name"] 	= $_POST["s_neft_bank_name"];
				$new_arr["s_neft_branch_name"] 	= $_POST["s_neft_branch_name"];
				$new_arr["s_neft_account"] 		= $_POST["s_neft_account"];
				$new_arr["s_neft_ifsc"] 		= $_POST["s_neft_ifsc"];
				$new_arr["dt_update"]			= date('Y-m-d H:i:s',time());
				$new_arr["i_user_id"]			= $user_meta[0]["i_id"];
				if(empty($data["pay_info"]))
				{
					$i_aff = $this->user_model->add_payment_info($new_arr);
				}
				else
				{
					$condition = array("i_user_id"=>$user_meta[0]["i_id"]);
					$i_aff = $this->user_model->update_payment_info($new_arr);
				}				
			}
			else if($pay_type=='cheque')
			{
				$new_arr = array();
				$new_arr["s_cheque_name"] 		= $_POST["s_cheque_name"];
				$new_arr["s_address"] 			= $_POST["s_address"];
				$new_arr["s_city"] 				= $_POST["s_city"];
				$new_arr["s_state"] 			= $_POST["s_state"];
				$new_arr["s_postal_code"] 		= $_POST["s_postal_code"];				
				$new_arr["s_contact_number"]	= $_POST["s_contact_number"];
				$new_arr["dt_update"]			= date('Y-m-d H:i:s',time());
				$new_arr["i_user_id"]			= $user_meta[0]["i_id"];
				if(empty($data["pay_info"]))
				{
					$i_aff = $this->user_model->add_payment_info($new_arr);
				}
				else
				{
					$condition = array("i_user_id"=>$user_meta[0]["i_id"]);
					$i_aff = $this->user_model->update_payment_info($new_arr);
				}				
			}
			
			if(!empty($withdrawl_session) && $withdrawl_session["withdrawl_amount"]!='')
			{
				unset($new_arr["dt_update"]);
				unset($new_arr["i_user_id"]);
				$withdrawArr = array();
				$withdrawArr["user_id"] 		= $user_meta[0]["i_id"];
				$withdrawArr["d_price"] 		= $withdrawl_session["withdrawl_amount"];
				$withdrawArr["s_pay_mode"] 		= $withdrawl_session["withdrawl_mode"];
				$withdrawArr["s_particulars"]	= !empty($new_arr)?json_encode($new_arr):"";
				$withdrawArr["dt_of_payment"]	= date('Y-m-d H:i:s',time());
				
				$i_aff = $this->user_model->add_withdrawl_info($withdrawArr);
				$this->session->unset_userdata('withdrawl_session');
				redirect(base_url('user/payment'));
								
			}
			
			/*$sess_msg = array();
			$sess_msg['message'] = "Data saved successfully";
			$sess_msg['message_type'] = 'succ';
			$this->session->set_userdata('invite_msg_session', $sess_msg);*/
		}
		$data["pay_type"] = $_POST['pay_type']?$_POST['pay_type']:$pay_type;
        $this->render($data);

    }
	
	/* function for user favourite deals list
	* from cd_deals table, i_type->2 for cd_deals table & 
	* i_type->1 for cd_coupon table
	* apr 2014
	*/
	
	public function favouritedeals($paging=0) {
       
        $data = array('title' => 'Favourite Deals');
		$data["lft_mnu"] =9;
        $user_meta = $this->session->userdata('current_user_session');
		
        $data['display_favour_listing'] = $this->favourite_listing($paging, TRUE);
		//print_r($data['display_favour_listing']); exit;
        $this->render($data);

    }
	
	public function favourite_listing($paging = 0, $returnData = false) {

        $search_condition = array();
		$userData = $this->session->userdata('current_user_session');
		if(empty($userData))
			redirect(base_url().'user/signup');
		
		$search_condition = array('user_fav_deals.i_type'=>2,'user_fav_deals.i_user_id'=>$userData[0]['i_id']);
        /* * generate ajax view of filtered list* */
        $generatedData = $this->process_favourite_deal_list($search_condition, 'Favourite Listing', $paging, 6, base_url() . 'user/favourite_listing/', 3, NULL, TRUE);

        if ($returnData)
            return $generatedData;
        else
            echo $generatedData;
    }	
	
    protected function process_favourite_deal_list($dealListCondition = '', $dealListTitle = '', $paging = 0, $limit = 3, $base_url = null, $uri_segment = 3, $likeCondition = null, $ajax_pagination = false) {


        $start = $paging;
        //$totalData = $this->user_fav_deals_model->count_total_joined_list($dealListCondition, $likeCondition);
		$totalData = $this->user_fav_deals_model->count_total_fav_deals($dealListCondition, $likeCondition);
        $config['base_url'] = $base_url;
        $config['total_rows'] = $totalData;
        $config['per_page'] = $limit;
        $config['uri_segment'] = $uri_segment;
        $config['is_ajax'] = $ajax_pagination;
        $dealListData['title'] = $dealListTitle;
        //$config['use_page_numbers'] = TRUE;

        /*$dealListData['dealList'] = $this->user_fav_deals_model->get_joined_list($dealListCondition, 'cd_coupon.i_id ,s_title,s_store_title,s_store_logo,s_store_logo,s_seo_url,i_cashback,dt_exp_date,cd_coupon.s_url,cd_coupon.s_url,s_store_url,s_image_url,cd_store.s_meta_description as store_meta,cd_coupon.s_meta_description as coupon_meta,d_list_price,d_selling_price,d_discount', $limit, $start, $likeCondition);*/
		
		$dealListData['dealList'] = $this->user_fav_deals_model->get_fav_deals_list($dealListCondition, 'cd_deals.i_id ,cd_deals.s_discount_txt,s_title,s_store_title,s_store_logo,s_store_logo,s_seo_url,i_cashback,dt_exp_date,cd_deals.s_url,cd_deals.s_url,s_store_url,s_image_url,cd_store.s_meta_description as store_meta,cd_deals.s_meta_description as coupon_meta,d_list_price,d_selling_price,d_discount', $limit, $start, $likeCondition);
		
        //return $this->load->view('elements/deal_list.tpl.php', array('dealListData' => $dealListData, 'config' => $config), true);
		return $this->load->view('elements/ajx_deals_list.tpl.php', array('dealListData' => $dealListData, 'config' => $config), true);

    }

   /* end function for user favourite deals list */
   
   
    /************************ new favourite deals starts 22 july 2014 *****************************/
    public function favouritelist() 
    {
        $data = array('title' => 'Favourite List'); 
        $data["lft_mnu"] =9;                                                 
        
        ob_start();
            $this->ajax_pagination_favourite_list(0,0);
            $product_list    = ob_get_contents();
        ob_end_clean();
        /* $product_list = explode('|^|',$product_list);
        
        $data['product_list']  = $product_list[0];
        $data['total_cnt']     = $product_list[1];
        */
        $data['favourite_list']  = $product_list;            
        $this->render($data);
        
    }
    
     /**
    * This function is ajax pegination function 
    * make the list all pros   
    * @param mixed $start
    * @param mixed $param
    */
    function ajax_pagination_favourite_list($start=0,$param=0) 
    {
        try
        {
             # NEW
            #$this->data['next_record_pointer'] = ( !empty($start) )? $start-1: $start+1;
            $this->data['next_record_pointer'] = ( !empty($start) )? $start+1: $start+2;
            #echo "next-record-pointer = {$start}##". $this->data['next_record_pointer'];
            
            #$start--;
            $start = ( !empty($start) )? $start-1: 0;
               #echo "--". $start;
            $start = $start * 20;
            #echo "++". $start;
            $s_where        = "";
            $s_order        = "";
            $limit          = 20;  
          
            
            $s_where  = " AND n.i_type = 1 ".$s_where;  // testing purpose
            $s_where   = preg_replace('/^AND/','WHERE ',trim($s_where));    
            
            $this->data['product_list'] = $this->user_fav_deals_model->get_favourite_product_list($s_where,intval($start),$limit,$s_order);          
            $total_rows                 = $this->user_fav_deals_model->count_favourite_product_list($s_where);
            
            $ctrl_path     = base_url().'user/ajax_pagination_favourite_list/';
            $paging_div = 'product_ajax';
            $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
            $this->data['total_rows']     = $total_rows;
            $this->data['start']          = $start;
          
            /*if(empty($param))
                $prod_vw = $this->load->view('user/ajax_pagination_favourite_list.tpl.php',$this->data,TRUE);
            else
                $prod_vw = $this->load->view('user/ajax_pagination_favourite_list.tpl.php',$this->data,TRUE).'|^|'.$total_rows;
                */
            $prod_vw = $this->load->view('user/ajax_pagination_favourite_list.tpl.php',$this->data,TRUE);
            echo $prod_vw;
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }                
    }
    
    /************************ new favourite deals ends 22 july 2014 *****************************/  
        
	
	/* function for user subscribe deals list
	* from cd_deals table, i_type->2 for cd_deals table & 
	* i_type->1 for cd_coupon table
	* apr 2014
	*/
	public function subscribedeals($paging=0) {
       
        $data = array('title' => 'Subscribed Deals');
		$data["lft_mnu"] =10;
        $user_meta = $this->session->userdata('current_user_session');
       
        $data['display_subs_listing'] = $this->subscribed_list($paging, TRUE);
		//print_r($data['display_favour_listing']); exit;
        $this->render($data);

    }	
	
    public function subscribed_list($paging = 0, $returnData = false) {

        $search_condition = array();
		$userData = $this->session->userdata('current_user_session');
		if(empty($userData))
			redirect(base_url().'user.signup');
		
		$search_condition = array('user_sub_deals.i_type'=>2,'user_sub_deals.i_user_id'=>$userData[0]['i_id']);
        /** generate ajax view of filtered list* */
        $generatedData = $this->process_subscribe_deal_list($search_condition, 'Subscribed Listing', $paging, 6, base_url() . 'user/subscribed_list/', 3, NULL, TRUE);
        if ($returnData)
            return $generatedData;
        else
            echo $generatedData;
    }
	
	protected function process_subscribe_deal_list($dealListCondition = '', $dealListTitle = '', $paging = 0, $limit = 3, $base_url = null, $uri_segment = 3, $likeCondition = null, $ajax_pagination = false) {

        $start = $paging;

        //$totalData = $this->user_sub_deals_model->count_total_joined_list($dealListCondition, $likeCondition);
		$totalData = $this->user_sub_deals_model->count_total_subscribe_deals($dealListCondition, $likeCondition);
        $config['base_url'] = $base_url;
        $config['total_rows'] = $totalData;
        $config['per_page'] = $limit;
        $config['uri_segment'] = $uri_segment;
        $config['is_ajax'] = $ajax_pagination;
        $dealListData['title'] = $dealListTitle;
        //$config['use_page_numbers'] = TRUE;

       /* $dealListData['dealList'] = $this->user_sub_deals_model->get_joined_list($dealListCondition, 'cd_coupon.i_id ,s_title,s_store_title,s_store_logo,s_store_logo,s_seo_url,i_cashback,dt_exp_date,cd_coupon.s_url,cd_coupon.s_url,s_store_url,s_image_url,cd_store.s_meta_description as store_meta,cd_coupon.s_meta_description as coupon_meta,d_list_price,d_selling_price,d_discount', $limit, $start, $likeCondition);*/

		$dealListData['dealList'] = $this->user_sub_deals_model->get_subscribe_deals_list($dealListCondition, 'cd_deals.i_id ,cd_deals.s_discount_txt,s_title,s_store_title,s_store_logo,s_store_logo,s_seo_url,i_cashback,dt_exp_date,cd_deals.s_url,cd_deals.s_url,s_store_url,s_image_url,cd_store.s_meta_description as store_meta,cd_deals.s_meta_description as coupon_meta,d_list_price,d_selling_price,d_discount', $limit, $start, $likeCondition);
		
        //return $this->load->view('elements/deal_list.tpl.php', array('dealListData' => $dealListData, 'config' => $config), true);
		return $this->load->view('elements/ajx_deals_list.tpl.php', array('dealListData' => $dealListData, 'config' => $config), true);
		
    }

	/* end function for user subscribe deals list */
	
	
	/* function for user tracked deals list
	* from cd_deals table, i_type->2 for cd_deals table & 
	* i_type->1 for cd_coupon table
	* apr 2014
	*/
	
	/* commented on 10 May 2014 
	
	public function trackdeals($paging=0) {
       
        $data = array('title' => 'Subscribed Deals');
        $user_meta = $this->session->userdata('current_user_session');
       
        $data['display_tracked_listing'] = $this->tracked_listing($paging, TRUE);
        $this->render($data);

    }
	

    public function tracked_listing($paging = 0, $returnData = false) {

        $user_meta = $this->session->userdata('current_user_session');
        $search_condition = array('user_deals.i_user_id' => $user_meta[0]['i_id']);
        
        $generatedData = $this->process_tracked_deal_list($search_condition, 'Tracking Listing', $paging, 6, base_url() . 'user/subscribed_list/', 3, NULL, TRUE);

        if ($returnData)
            return $generatedData;
        else
            echo $generatedData;

    }
	
	
    protected function process_tracked_deal_list($dealListCondition = '', $dealListTitle = '', $paging = 0, $limit = 3, $base_url = null, $uri_segment = 3, $likeCondition = null, $ajax_pagination = false) {

        $start = $paging;
        $totalData = $this->user_deals_model->count_total_joined_list($dealListCondition, $likeCondition);
        $config['base_url'] = $base_url;
        $config['total_rows'] = $totalData;
        $config['per_page'] = $limit;
        $config['uri_segment'] = $uri_segment;
        $config['is_ajax'] = $ajax_pagination;
        $dealListData['title'] = $dealListTitle;
        //$config['use_page_numbers'] = TRUE;
        $dealListData['dealList'] = $this->user_deals_model->get_joined_list($dealListCondition, 'cd_coupon.i_id ,s_title,s_store_title,s_store_logo,s_store_logo,s_seo_url,i_cashback,dt_exp_date,cd_coupon.s_url,cd_coupon.s_url,s_store_url,s_image_url,cd_store.s_meta_description as store_meta,cd_coupon.s_meta_description as coupon_meta,d_list_price,d_selling_price,d_discount', $limit, $start, $likeCondition);

        return $this->load->view('elements/deal_list.tpl.php', array('dealListData' => $dealListData, 'config' => $config), true);

    }
	
	*/

	
	/*
	* my earnings list 
	*/
	public function earning() {
        $data = array('title' => 'My Earning');
		$data["lft_mnu"] =4;
        $user_meta = $this->session->userdata('current_user_session');
		if(empty($user_meta))
			redirect(base_url().'user/signup');
		
		$userId = $user_meta[0]["i_id"];
       	$condition = " WHERE n.user_id = '".$userId."' AND n.earning_type =0 ";		
		$direct_earning = $this->user_model->get_earning_list($condition);
		$data["direct_earning"]	= $direct_earning;
		//pr($data["direct_earning"],1);
		
		$condition = " WHERE n.user_id = '".$userId."' AND n.earning_type =1 ";		
		$ref_earning = $this->user_model->get_earning_list($condition);
		$data["ref_earning"]	= $ref_earning;
		
		$condition = " WHERE n.user_id = '".$userId."' ";		
		$withdrawl_list = $this->user_model->get_withdrawl_list($condition);
		$data["withdrawl_list"]	= $withdrawl_list;
		
		
       	/*$condition = " WHERE user_id = '".$userId."' AND earning_type =0 ";
		$data["total_cashback_earn"] = $this->user_model->all_cashback_earning($condition);
				
		$condition = " WHERE user_id = '".$userId."' AND earning_type =1 ";
		$data["total_ref_earn"] = $this->user_model->all_cashback_earning($condition);
		
		$data["total_earn"] = number_format(($data["total_cashback_earn"] + $data["total_ref_earn"]),2);
		
		$condition = " WHERE user_id = '".$userId."' AND i_status =1 ";
		$data["total_paid_earn"] = $this->user_model->all_cashback_paid($condition);
		
		$data["total_pending_earn"] = number_format(($data["total_earn"] - $data["total_paid_earn"]),2);*/
		
		
		// 1July 2014 , data comes from cashback_earned and cashback_paid tables
		$condition = " WHERE user_id='".$user_meta[0]['i_id']."' AND i_status=1 ";
		$earningData = $this->user_model->cashback_earned($condition); 
        $data['earningData']['Cashback Earned'] = 'Rs '.($earningData[0]['tot_earn']?number_format($earningData[0]['tot_earn'],2):"0.00").'';  
		
		$paidData = $this->user_model->cashback_paid($condition); 
        $data['earningData']['Paid Cashback'] = 'Rs '.($paidData[0]['tot_paid']?number_format($paidData[0]['tot_paid'],2):"0.00").'';
		 
		$available = ($earningData[0]['tot_earn']-$paidData[0]['tot_paid']);
		$data['earningData']['Available For Withdraw'] = 'Rs '.($available?number_format($available,2):"0.00");
		
		$condition = " WHERE user_id='".$user_meta[0]['i_id']."' AND i_status=0 ";
		//$pendingData = $this->user_model->cashback_paid($condition);
		$pendingData = $this->user_model->cashback_earned($condition);
		$data['earningData']['Pending Cashback'] = 'Rs '.($pendingData[0]['tot_earn']?number_format($pendingData[0]['tot_earn'],2):"0.00").''; 
		
		$condition = " WHERE user_id='".$user_meta[0]['i_id']."' AND i_status=1 AND earning_type=1 ";
		$ref = $this->user_model->cashback_earned($condition); 
		$data['earningData']['Referral Earning'] = 'Rs '.($ref[0]['tot_earn']?number_format($ref[0]['tot_earn'],2):"0.00").'';  
		
        $this->render($data);

    }
	
	/*
	* my payment list 
	*/
	public function mypayment() {
        $data = array('title' => 'My Payment');
		$data["lft_mnu"] =6;
        $user_meta = $this->session->userdata('current_user_session');
		if(empty($user_meta))
			redirect(base_url().'user/signup');
		
		$userId = $user_meta[0]["i_id"];
       	$condition = " WHERE n.user_id = '".$userId."' AND n.earning_type =0 ";		
		$direct_earning = $this->user_model->get_earning_list($condition);
		$data["direct_earning"]	= $direct_earning;
		//pr($data["direct_earning"],1);
		
		$condition = " WHERE n.user_id = '".$userId."' AND n.earning_type =1 ";		
		$ref_earning = $this->user_model->get_earning_list($condition);
		$data["ref_earning"]	= $ref_earning;
		
		
       	$condition = " WHERE user_id = '".$userId."' AND earning_type =0 ";
		$data["total_cashback_earn"] = $this->user_model->all_cashback_earning($condition);
		
		$condition = " WHERE user_id = '".$userId."' AND earning_type =1 ";
		$data["total_ref_earn"] = $this->user_model->all_cashback_earning($condition);
		
		$data["total_earn"] = number_format(($data["total_cashback_earn"] + $data["total_ref_earn"]),2);
		
		$condition = " WHERE user_id = '".$userId."' AND i_status =1 ";
		$data["total_paid_earn"] = $this->user_model->all_cashback_paid($condition);
		
		$data["total_pending_earn"] = number_format(($data["total_earn"] - $data["total_paid_earn"]),2);
		
        $this->render($data);

    }
	
	/*
	* my payment list 
	*/
	public function withdraw() {
        $data = array('title' => 'Withdraw Money');
		$data["lft_mnu"] =5;
        $user_meta = $this->session->userdata('current_user_session');
		if(empty($user_meta))
			redirect(base_url().'user/signup');
		
		$userId = $user_meta[0]["i_id"];
       	$condition = " WHERE n.user_id = '".$userId."' AND n.earning_type =0 AND i_status=1 ";		
		$direct_earning = $this->user_model->get_earning_list($condition);
		$data["direct_earning"]	= $direct_earning;
		//pr($data["direct_earning"],1);
		
		$condition = " WHERE n.user_id = '".$userId."' AND n.earning_type =1 AND i_status=1 ";		
		$ref_earning = $this->user_model->get_earning_list($condition);
		$data["ref_earning"]	= $ref_earning;
		
       	$condition = " WHERE user_id = '".$userId."' AND earning_type =0 AND i_status=1 ";
		$data["total_cashback_earn"] = $this->user_model->all_cashback_earning($condition);
		
		$condition = " WHERE user_id = '".$userId."' AND earning_type =1 AND i_status=1 ";
		$data["total_ref_earn"] = $this->user_model->all_cashback_earning($condition);
		
		$data["total_earn"] = number_format(($data["total_cashback_earn"] + $data["total_ref_earn"]),2);
		
		$condition = " WHERE user_id = '".$userId."' AND i_status =1 ";
		$data["total_paid_earn"] = $this->user_model->all_cashback_paid($condition);
		
		$data["total_pending_earn"] = number_format(($data["total_earn"] - $data["total_paid_earn"]),2);
		
		$site_settings = $this->site_settings_model->get_list(array('i_id'=>1),'d_min_balance,d_cashback',1);
		$data["d_min_balance"] = $site_settings[0]["d_min_balance"];
		
		///withdrawl request july 2014
		$this->session->unset_userdata('withdrawl_session');
		if($_POST)
		{
			$posted = array();
			$posted = $this->input->post();
			
			$this->form_validation->set_rules('d_amount', 'withdraw amount', 'required'); 
			if($this->form_validation->run() == FALSE)
			{
				$this->data["posted"]=$posted;
			}
			else
			{
				$info = array();
				$info["withdrawl_amount"] 	= $posted["d_amount"];
				$info["withdrawl_mode"] 	= $posted["pay_mode"];
				
				$this->session->set_userdata('withdrawl_session',$info);
				
				$sess_msg = array();
				$sess_msg['message'] = "The payment should reach your account within 7-9 business days.";
				$sess_msg['message_type'] = 'succ';
				$this->session->set_userdata('invite_msg_session', $sess_msg);
				
				redirect(base_url('user/payment'));
			}
		}
		
        $this->render($data);

    }
	
	/* end of user new functions after menu style changed */
}

