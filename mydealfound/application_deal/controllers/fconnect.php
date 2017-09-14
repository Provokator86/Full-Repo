<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 7 APr 2014
* Modified By: 
* Modified Date: 
* 
* @includes My_Controller.php
*/

class Fconnect extends My_Controller
{

    public $cls_msg;//////All defined error messages. 
    public function __construct()
    {
        try
        { 
          parent::__construct(); 
          $this->load->model('user_model');
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
    public function index() {
        try
        {
            $this->render();            
	    }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
    /**
    * Authenticate code by fb access token
    * @param string $access_token_val The access token returned by fb login 
    * either popup or general login
    *
    */
    public function authenticate($access_token_val='')
    {   
        /**********make the access token Extended by extend_access_token() and get extended token********/
        $extended_access_token_val = $this->extend_access_token($access_token_val);
        if($extended_access_token_val==''){
            $access_token_val = $extended_access_token_val;
        } 

        
        /***running FQL to fetch data from facebook ****/
        // $fql = urlencode("SELECT post_id,viewer_id,source_id,updated_time,created_time,actor_id,message,attachment,permalink ,type FROM stream WHERE source_id = me() AND actor_id = me() order by created_time desc LIMIT 5");
        $fql = urlencode("SELECT uid,about_me, birthday, current_location, first_name, has_added_app, hometown_location, last_name, locale,  birthday_date, pic, pic_with_logo, pic_big, pic_big_with_logo, pic_small, pic_small_with_logo, pic_square, pic_square_with_logo, profile_url, proxied_email, email, contact_email, sex, meeting_sex, status, timezone, website, education_history, work_history, work, education, hs_info, religion, relationship_status, political, activities, interests, family, music, tv, movies, books, username, quotes, sports, favorite_teams, favorite_athletes, inspirational_people, languages FROM user WHERE uid = me()");
        $content = $this->process_fql($fql,$access_token_val);
        
        //pr($content['data'][0],1);
        
        $user_meta = $this->session->userdata('current_user_session');  // get current user data loggedin
		
		/*pr($content['data'][0]);
		pr($content,1);
		exit;*/
                
            if(isset($content->error))
                    echo 'A user of access token '.$access_token_val. ' got following error while fetching user details'.$temp_ret_graph;
            else
            {  
				if(empty($user_meta)) { 
					
				   if($this->login_by_facebook($content['data'][0],$access_token_val)){
						redirect(base_url().'user/profile');                                
						
				   } else {
						if($this->register_by_facebook($content['data'][0],$access_token_val)){
							if($this->login_by_facebook($content['data'][0],$access_token_val)){
									redirect(base_url().'user/profile');
							} else {
									echo 'login failed!';
							}
						}
						//echo 'registration failed!';
					   set_error_msg(message_line('fb_reg_fail'));  // either user email is not verified in fb 
																	// or kept private, so goto signup page
					   redirect(base_url('user/signup'));
					}

				} 
				else {
					if($user_meta[0]['s_email'] == $content['data'][0]['email'] ){
						$content['data'][0]['access_token'] = $access_token_val;
						$this->user_model->update_data(array("s_facebook_credential"=>serialize($content['data'][0])),
								array("i_id"=>  $user_meta[0]['i_id'])
					 );  
						set_success_msg('facebook account add success');
					} else {
						set_error_msg('facebook account email not match');
					}
					
					redirect(base_url()."user/profile");
				}
            }   

		} 			
    /**
     * Generate extended fb token from general small short term access token
     * @param string $access_token_val short term access token to extend
     * @return string offline extended access token value
     * incase of faliour return empty string.
     */

    private function extend_access_token($access_token_val = NULL){
	
		$this->data['fb_app_id'] = '788272717851332';
		$this->data['fb_app_secret'] = '2d170f2cb1e86b9d1330a76284d74b89';
		
        $fb_access_token_detail = $this->get_url_data('https://graph.facebook.com/oauth/access_token?client_id='.$this->data['fb_app_id'].'&client_secret='.$this->data['fb_app_secret'].'&grant_type=fb_exchange_token&fb_exchange_token=' . $access_token_val); 
        $offline_access_token_val = '';
        $matches = explode('access_token=',$fb_access_token_detail);
        if(!empty($matches)){  
            $match = explode('&expires=',$matches[1]);
        }
        if(!empty($match)){
            $offline_access_token_val=$match[0];
        }
        return $offline_access_token_val;   
    }
    
    /**
     * Login By Facebook
     * @param string $fb_email Email Address from facebook
     * @return bool false on faliour Else return true
     */
   // public function login_by_facebook($facebookData,$access_token_val,$facebookData) {           
    
      public function login_by_facebook($facebookData,$access_token_val) {  
    
        if(empty($facebookData['email']))
        	return false;  
        else   
        	$fb_email = $facebookData['email'];
			
		$condition = array('s_email'=>$fb_email);
        $user=$this->user_model->get_list($condition);
		 
        //pr($user,1);        
        if(!empty($user))
        {
            //pr($facebookData,1);
            $facebookData['access_token'] = $access_token_val;          
            $this->user_model->update_data(array("s_facebook_credential"=>serialize($facebookData)),
                        array("i_id"=>$user[0]["i_id"])
             );
			$this->session->set_userdata('current_user_session', $user);
            return true;
        }

        return false;     
    }
     
     
    /**
     * Registration By Facebook
     * @param mix $facebookData Data from facebok
     * @param string $access_token_val Access token
     * @return bool false on faliour Else return true
     */
     public function register_by_facebook($facebookData = NULL,$access_token_val = NULL){
         
        //pr($facebookData,1);
        if(empty($facebookData['email']))
        return false;
		    
		
		$uniqId = genRandomUserId();	  // @see common_helper.php
		$activation_code = genActivationCode(); // @see common_helper.php
		$referrerId = '';
		if($this->session->userdata('user_referrerId')!="")
		{
			$referrerId = $this->session->userdata('user_referrerId');
		}
        
		$userData=array();
        $userData["s_name"]         		= $facebookData['first_name'].' '.$facebookData['last_name'];
        $userData["s_email"]        		= $facebookData['email'];
        $userData["s_uid"]  				= $uniqId;
        $userData["s_org_pwd"]      		= $uniqId;
        $userData["txt_password"]			= md5(trim($uniqId));
		$userData["i_active"]  				= 1;
        $userData["s_referrer_id"]  		= $referrerId;
        $userData['s_facebook_credential']	= serialize($facebookData);
        $userData['s_activation_code']		= $activation_code;
		//pr($userData,1);exit;
        $ret=$this->user_model->insert_data($userData);
                        
        if($ret)
        {
		    $condition = array('i_active'=>1,
								's_email'=>$userData["s_email"],
								'txt_password'=>$userData["txt_password"]
							);
           	$user=$this->user_model->get_list($condition);
			
			// insert into cd_cashback_earned table for 50/- after registration
			$cb_arr = array();
			$cb_arr['user_id'] 	= $user[0]["i_id"];				
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
			
			// update invitation tbl
			if($referrerId!='')
			{
				$arr_invite["i_status"]= 1;
				$cond_arr = array('s_referrer_code'=>$referrerId,'s_email'=>trim($userData["s_email"]));
				$i_aff = $this->user_model->update_invitation_info($arr_invite,$cond_arr);
			}
			
          	$this->session->set_userdata('current_user_session', $user);
			$this->session->unset_userdata('user_referrerId');
			$_SESSION['user_referrerId'] = 	"";	
            return true;
       }
       else
       {
           set_error_msg("invalid user");
           return false;

       } 

        return false;
}

/////////////sh ajax Json for any array to use into JS//////////
    /**
     * Perform Curl Operation on specific url
     * @param url string $url Url to perform operation
     * @return string Responce String
     */
    private function get_url_data($url,    $internal_call_count=0){
        //$url = str_replace('access_token=','access_token2=',$url); // for force error testing
        log_message('info', basename(__FILE__).' : '.'get_url_data fetching: '.$url. ' no. of try: '.($internal_call_count+1));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 600); // originally 5 secs
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Connection: close'));
        $tmp = curl_exec($ch);
        $http_ret_code=curl_getinfo($ch, CURLINFO_HTTP_CODE).'';
        curl_close($ch);    

        $tmp_data=@json_decode($tmp);             

        if(
            ($http_ret_code!='200') ||
            ($tmp=='') ||
            isset($tmp_data->error)
        )
        {
            log_message('debug', basename(__FILE__).' : '.'get_url_data fetching error: '.$tmp.' return status code: '.$http_ret_code.' for url: '.$url);

            $internal_call_count++;
            if($internal_call_count<3)
            {
                sleep(3);
                return $this->get_url_data($url,$internal_call_count);
            }    
        }

        return $tmp;     
    }
     
    /**
     * Perform FQL Operation on specific accesstoken
     * @param String $fql FQL to perform operation by
     * @param String $access_token Access Token to perform operation on
     * @return array Responce
     */
    private function process_fql($fql=NULL,$access_token =NULL) {
        $content = array();
        $content = @json_decode($temp_ret_graph=($this->get_url_data('https://graph.facebook.com/fql?q='.$fql.'&access_token='.$access_token)),true);
        return $content;
    }
    
   
       
 }

/* End of file fconnect.php */
/* Location: ./system/application/controllers/home.php */