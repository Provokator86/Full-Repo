<?php
class Automail_model extends Automail_base_model
{
    public function __construct()
    {
        parent::__construct();
    }

    function send_registration_mail($email,$mail_type)
    {
    	if(!$email || $email=='')
    		return false;
    	$this->load->model('users_model');
    	$row	= $this->users_model->get_user_list(1,0,array('email'=>$email));
    	if(!$row || !isset($row[0]))
    		return false;
    	$row[0]['verification_code']	= '<a href="'.base_url().'user/verify_user/'.$row[0]["id"].'/'.$row[0]["verification_code"].'">Click here</a>';
    	return $this->send_automail_to_user('users',$row[0],$mail_type,$email);
    }
	
	
	function send_yuva_registration_mail($email,$mail_type)
    {
    	if(!$email || $email=='')
    		return false;
    	$this->load->model('users_model');
    	$row	= $this->users_model->get_user_list(1,0,array('email'=>$email));
    	if(!$row || !isset($row[0]))
    		return false;
    	$row[0]['verification_code']	= '<a href="'.base_url().'project_yuva/verify_yuva_user/'.$row[0]["id"].'/'.$row[0]["verification_code"].'">Click here</a>';
    	return $this->send_automail_to_user('users',$row[0],$mail_type,$email);
    }
	
    function send_admin_added_registration_mail($email,$mail_type,$password='')
    {
    	if(!$email || $email=='' || !$password || $password=='' )
    		return false;
    	$this->load->model('users_model');
    	$row	= $this->users_model->get_user_list(1,0,array('email'=>$email));
    	if(!$row || !isset($row[0]))
    		return false;
    	$row[0]['password']	= $password;
    	return $this->send_automail_to_user('users',$row[0],$mail_type,$email);
    }	
	
	

	function send_forget_password_mail($email='')
    {
    	if(!$email || $email=='')
    		return false;
    	$this->load->model('users_model');
		$arr = array('email'=>$email);
    	$row	= $this->users_model->get_user_list(1,0,$arr);
    	if(!$row || !isset($row[0]))
    		return false;
    	$newPassword	= get_rendom_code();
    	$row[0]['password']	= $newPassword;
    	$arr= array("password"=>get_salted_password($newPassword));
    	if($this->users_model->set_user_password_update($arr,$row[0]['id']))
    		return $this->send_automail_to_user('users',$row[0],'forgot_password',$email);
    	return false;
    }
	
	function send_party_invitation_mail($email,$mail_type,$party_id='',$invite_id)
	{
    	
		if(!$email || $email=='')
    		return false;
    	$this->load->model('party_model');
    	$row	= $this->party_model->get_party_list(array('id'=>$party_id),1,0);
    	if(!$row || !isset($row[0]))
    		return false;
    	$row[0]['cr_by']	= $row[0]['f_name'];
    	$row[0]['notify_guest_reply'] = '<a href="'.base_url().'party/verify_invitation/'.$invite_id.'"><img src="http://www.urbanzing.com/images/front/envelope.jpg" alt="Party invitation" border="0" /></a>';
		$row[0]['start_date'] = date('jS F, Y H:ia', $row[0]['start_date']);
		
    	return $this->send_automail_to_user('party',$row[0],$mail_type,$email);	
	}
	
	function send_reply_mail_against_party_invitation($email,$mail_type,$invite_id='')
	{
    	if(!$email || $email=='')
    		return false;
    	$this->load->model('party_model');
    	$row	=  $this->party_model->get_party_invitation_list(1,0,array('id'=>$invite_id));
    	if(!$row || !isset($row[0]))
    		return false;
    	$row[0]['cr_by']	= $row[0]['f_name'];
		$row[0]['comment']	= $row[0]['event_title'];
		//var_dump($row[0]);
		//die();
    	return $this->send_automail_to_user('invites',$row[0],$mail_type,$email);	
	}	
	
	
    function send_business_claim_mail($email,$mail_type,$business_id)
    {
    	if(!$email || $email=='')
    		return false;
    	$this->load->model('business_model');
    	$row	= $this->business_model->get_business_list(array('id'=>$business_id),1,0);
    	if(!$row || !isset($row[0]))
    		return false;

    	return $this->send_automail_to_user('business',$row[0],$mail_type,$email);
    }	
	
	function send_invite_user_mail($email,$mail_type)
	{
		global $CI;
    	if(!$email || $email=='')
    		return false;
    	$CI->load->model('users_model');
    	$row	= $CI->users_model->get_invite_user_list(1,0,array('invited_email'=>$email));
    	if(!$row || !isset($row[0]))
    		return false;
    	$row[0]['invited_email'] = '<a href="'.base_url().'">Click here</a>';
    	return $this->send_automail_to_user('mailing_list',$row[0],$mail_type,$email);		
		
	}
	
	function send_newsletter_mail($subject,$body,$mailTo,$mailBCC='')
    {
    	$this->project_send_mail($subject,$body,$mailTo,'',$mailBCC);
    }	
	
	

    function send_forget_password_mail_admin($email='')
    {
    	if(!$email || $email=='')
    		return false;
    	$this->load->model('admin_user_model');
    	$row	= $this->admin_user_model->get_user_list(1,0,array('email'=>$email));
    	if(!$row || !isset($row[0]))
    		return false;
    	$newPassword	= get_rendom_code();
    	$row[0]['password']	= $newPassword;
    	$arr= array("password"=>get_salted_password($newPassword));
    	if($this->admin_user_model->set_user_password_update($arr,$row[0]['id']))
    		return $this->send_automail_to_user('admin',$row[0],'forgot_password_admin',$email);
    	return false;
    }



    function send_block_unblock_admin_user_mail($id,$mailType)
    {
    	if(!$id || $id=='' || !is_numeric($id) || !$mailType || $mailType=='')
    		return false;
    	$this->load->model('admin_user_model');
    	$row	= $this->admin_user_model->get_user_list(1,0,array('id'=>$id),'name','asc');
    	if(!$row || !isset($row[0]))
    		return false;
    	return $this->send_automail_to_user('admin',$row[0],$mailType,$row[0]['email']);
    }

    function send_user_add_mail($row,$mailType,$manual)
    {
        if(!$row)
            return false;
        $this->manualArr    = $manual;
        return $this->send_automail_to_user('user',$row,$mailType,$row['email']);
    }

    function send_block_unblock_user_mail($id,$mailType)
    {
    	if(!$id || $id=='' || !is_numeric($id) || !$mailType || $mailType=='')
    		return false;
    	$this->load->model('users_model');
    	$row	= $this->users_model->get_user_list(1,0,array('id'=>$id),'name','asc');
    	if(!$row || !isset($row[0]))
    		return false;
    	return $this->send_automail_to_user('user',$row[0],$mailType,$row[0]['email']);
    }

    

    function send_compose_mail($subject,$body,$mailTo)
    {
    	$this->project_send_mail($subject,$body,$mailTo);
    }
	
	/**
	*
	* Author: Purnendu Shaw   ( 17.11.2010 )
	* For sending mail to admin whenever a user reports against a review
	*/
	function send_report_review_mail_to_admin($arr, $mail_type)
	{
		$this->load->model('review_model');
		$result 						=   $this->review_model->get_review_detail(-1,0,$arr);
		$result_admin 					=   $this->site_settings_model->get_site_settings_all();
		if( $arr['type'] == 'I')
			$arr['review_type']				=	'Inaccurate';
		else if( $arr['type'] == 'O')
			$arr['review_type']				=	'Offencive';
		else if( $arr['type'] == 'T')
			$arr['review_type']				=	'Other';
		//$arr['review_type']				=	$arr['type'];
		$arr['user_f_name']				= 	$this->session->userdata('user_username');
		$arr['business_name']         	=	$result[0]['b_name'];
		$arr['review_title']			=	$result[0]['review_title'];
		$arr['comment']					=	($arr['comment'])?$arr['comment']:'-';
		$email							=	$result_admin[0]['admin_email'];
		$mail_detail					=   $this->get_automail_all($mail_type);
		return $this->send_automail_to_user('review',$arr,$mail_type,$email);
		

	}

	function send_like_review_mail_to_admin($arr, $mail_type)
	{

		$arr['user_f_name']				= 	$this->session->userdata('user_username');
		$this->load->model('review_model');
		$result 						=   $this->review_model->get_review_detail(-1,0,$arr);
		$result_admin 					=   $this->site_settings_model->get_site_settings_all();
		$arr['business_name']         	=	$result[0]['b_name'];
		$arr['review_title']			=	$result[0]['review_title'];
		$email							=	$result_admin[0]['admin_email'];
		$mail_detail					=   $this->get_automail_all($mail_type);
		return $this->send_automail_to_user('review',$arr,$mail_type,$email);
	}
	
	function send_like_review_mail_to_review_writer($arr, $mail_type)
	{
		
		
		$this->load->model('review_model');
		$result 						=   $this->review_model->get_review_detail(-1,0,$arr);
		$arr['user_f_name']				= 	$this->session->userdata('user_username');
		$arr['review_writer']           = 	$result[0]['f_name'].' '.$result[0]['l_name'] ;
		$arr['business_name']         	=	$result[0]['b_name'];
		$arr['review_title']			=	$result[0]['review_title'];
		$email							=	$result[0]['email'];
		$mail_detail					=   $this->get_automail_all($mail_type);
		return $this->send_automail_to_user('review',$arr,$mail_type,$email);
	}
	
	
}