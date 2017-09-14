<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invitefriend extends MY_Controller {

	public function __construct(){
		parent::__construct();
		//session_start();
		$this->load->model('product_model','product');
	}
	public function twitter_friends(){
		$returnStr['status_code'] = 1;
		$returnStr['url'] = base_url().'site/invitefriend/get_twitter';
		$returnStr['message'] = '';
		echo json_encode($returnStr);
	}
	public function twitter_request(){
		$userDetails = $this->product->get_all_details(USERS,array('id'=>$this->checkLogin('U')));
		$link = base_url();
		$invite_text = 'Invites you to join on '.$this->data['siteTitle'].' ('.base_url().'?ref='.$userDetails->row()->user_name.')';
		require_once('twitter/codebird.php');
		require "twitter/config.php";
		\Codebird\Codebird::setConsumerKey(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET);
		$cb = \Codebird\Codebird::getInstance();
		$cb->setToken($this->config->item('twitter_access_token'), $this->config->item('twitter_access_token_secret'));
		$reply = $cb->directMessages_new(array(
			'text' => $invite_text,
			'user_id'=>$this->input->post('twid'),
		));
		if($reply->httpstatus == 200){
			echo "send";
		}else{
			echo $reply->errors[0]->message;
		}
	}
	public function get_twitter(){
		require("twitter/twitteroauth.php");
		require "twitter/config.php";
		session_start();
		$twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET);
		$request_token = $twitteroauth->getRequestToken(base_url().'site/invitefriend/getTwitterData');
		$_SESSION['oauth_token'] = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
		if ($twitteroauth->http_code == 200) {
			$url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);
			header('Location: ' . $url);
		} else {
			die('Something wrong happened.');
		}
	}
	public function getTwitterData(){
		require("twitter/twitteroauth.php");
		require "twitter/config.php";
		session_start();
		if(!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {
			$twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
			$access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
			$_SESSION['access_token'] = $access_token;
			$user_info = $twitteroauth->get('account/verify_credentials');
			$uid = $user_info->id;
			$username = $user_info->name;
			$friends = $user_info->friends_count;
			if($friends>0){
				$param_arr = array(
				'screen_name'=>$user_info->screen_name
				);
				$tw_friends_list = $twitteroauth->get('https://api.twitter.com/1.1/friends/list.json',$param_arr);
				$html = "<html><body><div style='height:520px; text-align:center; overflow-y:scroll;'>";
				foreach($tw_friends_list->users as $tw_friends_detail){
					$html .= '<div style="float:left; width:100%; height:75px; border-bottom:1px solid #ddd; padding-top:5px; padding-bottom:5px;">';
					$html .= '<div style="float:left; width:11%"><img style="float:left; height:75px; width:75px;" src="'.$tw_friends_detail->profile_image_url.'" /></div>';
					$html .= '<div style="text-align:left;float:left; width:30%; margin:20px 0 0 20px">'.$tw_friends_detail->name.'</div>';
					$html .= '<div style="float:right; margin:20px 0 0 20px"><input style="cursor:pointer; width:100px; color:white; font-size:17px; border-radius:5px; background:rgb(58, 126, 199); border:none; height:40px; margin-right:20px;" type="button" id="'.$tw_friends_detail->id.'" onclick="TwitterInvite(this);" value="Invite"></div>';
					$html .= '</div>';
				}
				$html .= '<input class="twitter_done" type="button" value="Done" style="cursor:pointer;width:100px; color:white; font-size:13px; background:rgb(58, 126, 199); border:none; height:40px; margin-top:10px; border-radius:5px;">';
				$html .= '</div></body></html>';
			}
			echo $html;
			echo "<script type='text/javascript' src='".base_url()."js/site/jquery-1.7.1.min.js'></script>
			<script type='text/javascript'>
				function TwitterInvite(evt){
					if($(evt).hasClass('processing')) return;
					$(evt).addClass('processing');
					$(evt).parent().append('<img src=\'".base_url()."images/twit_loader.gif\'>');
					var id =evt.id;
					var url = '".base_url()."site/invitefriend/twitter_request';
					$.post(url,{'twid':id},function(data){
						if(data == 'send'){
							$(evt).parent().find('img:last').remove();
							$(evt).val('Invited');
						}else{
							alert(data);
							$(evt).parent().find('img:last').remove();
						}
					});
				}
				$('.twitter_done').click(function(){
					window.close();
				});
			</script>";
		}else{
			echo "<script type='text/javascript'>
					window.close();
				</script>";
		}
	}
	public function gmail_friends(){
		$returnStr['status_code'] = 1;
		error_reporting(0);
		include_once './gmail/config.php';
		$returnStr['url'] = "https://accounts.google.com/o/oauth2/auth?client_id=".$clientid."&redirect_uri=".$redirecturi."&scope=https://www.google.com/m8/feeds/&response_type=code";
		$returnStr['message'] = '';
		echo json_encode($returnStr);
	}
	public function gmail_list_callback(){
		session_start();
		include_once './gmail/config.php';
		//$userDetails = $this->product->get_all_details(USERS,array('id'=>$this->checkLogin('U')));
		$authcode = $_GET["code"];
		$fields=array(
			'code'=>  urlencode($authcode),
			'client_id'=>  urlencode($clientid),
			'client_secret'=>  urlencode($clientsecret),
			'redirect_uri'=>  urlencode($redirecturi),
			'grant_type'=>  urlencode('authorization_code')
		);
		$fields_string = '';
		foreach($fields as $key=>$value){ $fields_string .= $key.'='.$value.'&'; }
		$fields_string	=	rtrim($fields_string,'&');
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,'https://accounts.google.com/o/oauth2/token'); //set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_POST,5);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Set so curl_exec returns the result instead of outputting it.
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //to trust any ssl certificates
		$result = curl_exec($ch); //execute post
		curl_close($ch); //close connection
		$response   =  json_decode($result);
		$accesstoken = $response->access_token;
		if( $accesstoken!='')
		$_SESSION['token']= $accesstoken;
		$xmlresponse=  file_get_contents('https://www.google.com/m8/feeds/contacts/default/full?max-results='.$maxresults.'&oauth_token='. $_SESSION['token']);
		$xml=  new SimpleXMLElement($xmlresponse);
		$xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
		$result = $xml->xpath('//gd:email');
		$html = "<html><body><div style='height:520px; text-align:center; overflow-y:scroll;'>";
		foreach($result as $title){
			$html .= '<div style="float:left; width:100%; height:75px; border-bottom:1px solid #ddd; padding-top:5px; padding-bottom:5px;">';
			$html .= '<div style="text-align:left;float:left; width:30%; margin:20px 0 0 20px">'.$title->attributes()->address.'</div>';
			$html .= '<div style="float:right; margin:20px 0 0 20px"><input style="cursor:pointer; width:100px; color:white; font-size:17px; border-radius:5px; background:rgb(58, 126, 199); border:none; height:40px; margin-right:20px;" type="button" id="'.$title->attributes()->address.'" onclick="GmailInvite(this);" value="Invite"></div>';
			$html .= '</div>';
		}
		$html .= '<input class="twitter_done" type="button" value="Done" style="cursor:pointer;width:100px; color:white; font-size:13px; background:rgb(58, 126, 199); border:none; height:40px; margin-top:10px; border-radius:5px;">';
		$html .= '</div></body></html>';
		echo $html;
		echo "<script type='text/javascript' src='".base_url()."js/site/jquery-1.7.1.min.js'></script>
		<script type='text/javascript'>
			function GmailInvite(evt){
				if($(evt).hasClass('processing')) return;
				$(evt).addClass('processing');
				$(evt).parent().append('<img src=\'".base_url()."images/twit_loader.gif\'>');
				var email =evt.id;
				var url = '".base_url()."site/invitefriend/gmail_request';
				$.post(url,{'email':email},function(data){
					if(data.trim() == 'send'){
						$(evt).parent().find('img:last').remove();
						$(evt).val('Invited');
					}
				});
			}
			$('.twitter_done').click(function(){
				window.close();
			});
		</script>";
	}
	public function gmail_request(){
		$userDetails = $this->product->get_all_details(USERS,array('id'=>$this->checkLogin('U')));
		$to = $this->input->post('email');
		$from = $userDetails->row()->full_name;
		$split = explode('@',$to);
		$fullname = $split[0];
		$site = $this->config->item('email_title');
		if ($to != ''){
			$newsid='18';
			$template_values=$this->product->get_newsletter_template_details($newsid);
			$adminnewstemplateArr=array('logo'=> $this->data['logo'],'siteTitle'=>$this->data['siteTitle'],'meta_title'=>$this->config->item('meta_title'),'full_name'=>$this->data['userDetails']->row()->full_name,'user_name'=>$this->data['userDetails']->row()->user_name);
			extract($adminnewstemplateArr);
			$subject = $template_values['news_subject'];
			$message .= '<!DOCTYPE HTML>
					<html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<meta name="viewport" content="width=device-width"/>
					<title>'.$template_values['news_subject'].'</title><body>';
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
									'to_mail_id'=>$to,
									'subject_message'=>$subject,
									'body_messages'=>$message
			);
			$email_send_to_common = $this->product->common_email_send($email_values);
			if($email_send_to_common){
				echo "send";
			}
		}
	}
}

