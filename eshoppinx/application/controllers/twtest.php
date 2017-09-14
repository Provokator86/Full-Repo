<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Twtest extends MY_Controller {
	public function index() {

		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));
		$this->load->model(array('user_model','product_model'));

		$this->load->library('twconnect');
		$this->load->helper('url');

		echo '<p><a href="' . base_url() . 'twtest/redirect">Connect to Twitter</a></p>';
		echo '<p><a href="' . base_url() . 'twtest/clearsession">Clear session</a></p>';

		echo 'Session data:<br/><pre>';
		print_r($this->session->all_userdata());
		echo '</pre>';
	}

	/* redirect to Twitter for authentication */
	public function redirect() {

		$twitter_data = $this->session->userdata('tw_access_token');
		$twitter_data_status = $this->session->userdata('tw_status');
		$fc_session_temp_id = $this->session->userdata('fc_session_temp_id');
		$this->session->unset_userdata($twitter_data);
		$this->session->unset_userdata($twitter_data_status);
		$this->session->unset_userdata($fc_session_temp_id);
		//echo "<pre>";print_r($this->session->all_userdata);
		//redirect('twtest/redirect');
		$this->load->library('twconnect');

		/* twredirect() parameter - callback point in your application */
		/* by default the path from config file will be used */
		$ok = $this->twconnect->twredirect('twtest/callback');
		$ok = $this->twconnect->twredirect('twtest/callback');

		if (!$ok) {
			echo 'Could not connect to Twitter. Refresh the page or try again later.';
		}
	}


	/* return point from Twitter */
	/* you have to call $this->twconnect->twprocess_callback() here! */
	public function callback() {
		$this->load->library('twconnect');

		$ok = $this->twconnect->twprocess_callback();

		if ( $ok ) { redirect('twtest/success'); }
		else redirect ('twtest/failure');
	}


	/* authentication successful */
	/* it should be a different function from callback */
	/* twconnect library should be re-loaded */
	/* but you can just call this function, not necessarily redirect to it */
	public function success() {

		echo 'Twitter connect succeded<br/>';
		echo '<p><a href="' . base_url() . 'twtest/clearsession">Do it again!</a></p>';

		$this->load->library('twconnect');
		$this->load->library('session');
		// saves Twitter user information to $this->twconnect->tw_user_info
		// twaccount_verify_credentials returns the same information
		$this->twconnect->twaccount_verify_credentials();



		echo 'Authenticated user info ("GET account/verify_credentials"):<br/><pre>';


		$twConnectId = $this->twconnect->tw_user_info;

		$twitterId = $twConnectId->id;
		$this->load->model('user_model');
		$twitterCountById = $this->user_model->social_network_login_check($twitterId);

		$a = $this->session->all_userdata();


		$aa= $this->session->userdata('tw_access_token');

		if($twitterCountById != 0)
		{

			//echo "redirect to login success page";
			$getLoginDetails = $this->user_model->get_social_login_details($twitterId);
			$userdata = array(
							'fc_session_user_id' => $getLoginDetails['id'],
							'session_user_name' => $getLoginDetails['user_name'], 
							'session_user_email' => $getLoginDetails['email'] 
			);
			$this->session->set_userdata($userdata);

			$this->setErrorMessage('success','Login successfully');
			redirect(base_url());

		}
		else
		{

			$getFileNameArray = explode('/',$twConnectId->profile_image_url);

			$fileNameDetails = $getFileNameArray[5];

			if($fileNameDetails != '')
			{
				$fileNameDetails = $getFileNameArray[5];
			}
			else
			{
				$fileNameDetails = '';
			}

			$twitter_login_details = array('social_login_name'=>$twConnectId->name,'social_login_unique_id'=>$twConnectId->id,'screen_name'=>$twConnectId->screen_name,'social_image_name'=>$fileNameDetails);


			$url = $twConnectId->profile_image_url;
			$img = 'images/users/'.$fileNameDetails ;
			file_put_contents($img, file_get_contents($url));


			//echo "redirect to registration page";
			$social_login_name = $twConnectId->name;
			$this->session->set_userdata($twitter_login_details);
			//echo $a =$this->session->userdata($twise);
			redirect('signup');


			//redirect("signup#");
		}
		//echo "<br>".count($twitterQueryDetails);





	}


	/* authentication un-successful */
	public function failure() {

		//echo '<p>Twitter connect failed</p>';
		//echo '<p><a href="' . base_url() . 'twtest/clearsession">Try again!</a></p>';
		redirect('signup');
	}


	/* clear session */
	public function clearsession() {

		//$this->session->sess_destroy();

		redirect('/twtest');
	}
	public function find_friends(){
		$this->clearsession();
		$ok = $this->twconnect->twredirect('twtest/find_friends_callback');
		if (!$ok) {
			echo 'Could not connect to Twitter. Refresh the page or try again later.';
		}
	}
	public function find_friends_callback(){
		$ok = $this->twconnect->twprocess_callback();
		if ( $ok )
		redirect('twtest/find_friends_success');
		else
		redirect ('twtest/find_friends_failure');
	}
	public function find_friends_success(){
		$this->twconnect->twaccount_verify_credentials();
		$tw_user_info = $this->twconnect->tw_user_info;
		$twitterId = $tw_user_info->id;
		$twitter_id = $this->user_model->get_all_details(USERS,array('id'=>$this->checkLogin('U')));
		if($twitter_id->num_rows()==1){
		}else{
			$condition = array('id'=>$this->checkLogin('U'));
			$this->user_model->update_details(USERS,array('twitter'=>$twitter_id),$condition);
		}
		$twitterName = $tw_user_info->screen_name;
		$twitterFriends = $tw_user_info->friends_count;
		if ($twitterFriends>0){
			$param_arr = array(
			'screen_name'=>$twitterName
			);
			$tw_friends_list = $this->twconnect->tw_get('https://api.twitter.com/1.1/friends/ids.json',$param_arr);
			$tw_friends_list_arr = $tw_friends_list->ids;
			if(count($tw_friends_list_arr)>0){
				foreach($tw_friends_list_arr as $tw_friend_id){
					$title = "Unkown Name";
					$friends_id = $tw_friend_id;
					$twitterDetails = $this->user_model->get_all_details(USERS,array('twitter'=>$friends_id,'status'=>'Active'));
					if($twitterDetails->num_rows() ==1){
						$followClass = 'follow_btn';
						$followText = 'Follow';
						if ($this->checkLogin('U')!= ''){
							$followingListArr = explode(',', $userDetails->row()->following);
							if (in_array($twitterDetails->row()->id, $followingListArr)){
								$followClass = 'following_btn';
								$followText = 'Following';
							}
						}
						$html .= '<li title="'.$title.'"><a><div class="img-wrap"><img src="images/users/default_user.jpg" style="width:150px; height:150px;"/><div>'.$title.'</div></div></a><a class="'.$followClass.'" data-uid="'.$twitterDetails->row()->id.'" onclick="javascript:store_follow(this);">'.$followText.'</a></li>';
					}else{
						$html .= '<li title="'.$title.'"><a><div class="img-wrap"><img src="images/users/default_user.jpg" style="width:150px; height:150px;"/><div>'.$title.'</div></div></a><input type="button" id="'.$friends_id.'" value ="Invite" onclick="javascript:twitter_notify(this.id);"></li>';
					}
				}
			}else{
				$html .='<h2>No Users Found</h2>';
			}
		}else{
			$html .='<h2>No Users Found</h2>';
		}
		echo "
		<script type='text/javascript' src='".base_url()."js/site/jquery-1.9.0.min.js'></script>
		<script type='text/javascript'>
			window.opener.document.getElementById('friend_select_type').style.display = 'none';
			window.opener.document.getElementById('find_selected_google').innerHTML = '$html';
			window.close();
		</script>";
	}
	public function find_friends_failure(){
		echo "<script type='text/javascript'>
				window.close();
			</script>";
	}
	public function twitter_invite(){
		$invite_text = 'Invites you to join on '.$this->data['siteTitle'].' ('.base_url().'?ref='.$this->data['userDetails']->row()->user_name.')';
		$param_arr = array(
				'text'=>$invite_text,
				'user_id'=>$this->input->post('id'),
		);
		$msg_res = $this->twconnect->tw_post('https://api.twitter.com/1.1/direct_messages/new.json',$param_arr);
	}
	public function get_twitter_user(){
		$this->clearsession();
		$ok = $this->twconnect->twredirect('twtest/get_user_callback');
		if (!$ok) {
			echo 'Could not connect to Twitter. Refresh the page or try again later.';
		}
	}
	public function get_user_callback(){
		$ok = $this->twconnect->twprocess_callback();
		if($ok)
		redirect('twtest/get_user_success');
		else
		redirect ('twtest/get_user_failure');
	}
	public function get_user_success(){
		$this->twconnect->twaccount_verify_credentials();
		$tw_user_info = $this->twconnect->tw_user_info;
		$twitterId = $tw_user_info->id;
		$twitterName = $tw_user_info->screen_name;
		if($twitterId!=''){
			$condition = "select * from ".USERS." where twitter=".$twitterId." and id != ".$this->checkLogin('U')."";
			$user_details = $this->user_model->ExecuteQuery($condition);
			if($user_details->num_rows()==1){
				echo "<script type='text/javascript'>
					alert('This Twitter account is already Exists');
					window.close();
				</script>";
			}else{
				$condition = array('id'=>$this->checkLogin('U'));
				$dataArr = array('twitter'=> $twitterId);
				$this->user_model->update_details(USERS,$dataArr,$condition);
				echo "<script type='text/javascript'>
					window.opener.location.href = '".base_url()."stories/new';
					window.close();
				</script>";
			}
		}
	}
	public function get_user_failure(){
		echo "<script type='text/javascript'> window.close(); </script>";
	}
	
	/********************************For Invite Friends Start***************Vinu***********Nov-5-2013**************/

	public function invite_friends(){

	//	$this->clearsession();
		$ok = $this->twconnect->twredirect('twtest/invite_callback');

		if (!$ok) {
			echo 'Could not connect to Twitter. Refresh the page or try again later.';
		}
	}

	public function invite_callback(){

		$ok = $this->twconnect->twprocess_callback();

		if ( $ok )
		redirect('twtest/invite_success');
		else
		redirect ('twtest/invite_failure');
	}

	public function invite_success(){
		$this->twconnect->twaccount_verify_credentials();
		$tw_user_info = $this->twconnect->tw_user_info;
		$twitterId = $tw_user_info->id;
		$twitterName = $tw_user_info->screen_name;
		$twitterFriends = $tw_user_info->friends_count;
		if ($twitterFriends>0){
			$param_arr = array(
			'screen_name'=>$twitterName
			);
			$tw_friends_list = $this->twconnect->tw_get('https://api.twitter.com/1.1/followers/ids.json',$param_arr);
			$tw_friends_list_arr = $tw_friends_list->ids;
			if (count($tw_friends_list_arr)>0){
				$invite_text = 'Invites you to join on '.$this->data['siteTitle'].' ('.base_url().'?ref='.$this->data['userDetails']->row()->user_name.')';
				foreach ($tw_friends_list_arr as $tw_friend_id){
					if ($tw_friend_id != ''){
						$param_arr = array(
						'text'=>$invite_text,
						'user_id'=>$tw_friend_id
						);
						$msg_res = $this->twconnect->tw_post('https://api.twitter.com/1.1/direct_messages/new.json',$param_arr);
					}
				}
				echo "
				<script>
					alert('Invitations sent successfully');
					window.close();
				</script>
				";
			}
		}else {
			echo "
			<script>
				alert('No followers in your twitter account');
				window.close();
			</script>
			";
		}
	}

	public function invite_failure(){
		echo "
		<script>
			window.close();
		</script>
		";
	}
	
	/********************************For Invite Friends End***************Vinu***********Nov-5-2013**************/
}