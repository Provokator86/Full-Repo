<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Face_book extends MY_Controller {

	public function __construct(){
		parent::__construct();
		session_start();
		$this->load->model('product_model');
	}

	public function friend_list(){
	   $this->load->library('facebook', array(
            'appId' => $this->config->item('facebook_app_id'),
            'secret' => $this->config->item('facebook_app_secret'),
       ));
	   $search = $this->input->post('search');
	   if($_SESSION['fb_user_id']!=''){
	   $friends_list =array();
	   $friends = $this->facebook->api($_SESSION['fb_user_id'].'/friends');
	   foreach($friends['data'] as $key => $_friends){
	      
		   array_push($friends_list ,strtolower($_friends['name']));
		}
		$input = preg_quote($search, '~');
		$result = preg_grep('~' . $input . '~', $friends_list);
        foreach($result as $_result){
		   echo '<div class="show" align="left">';
           echo '<span class="name">@'.$_result.'</span>&nbsp;<br/></div>';
		}
		}else{
		 $Query = "SELECT * FROM ".USERS." WHERE user_name LIKE '%$search%' AND status ='Active' AND id !=".$this->checkLogin('U')." ";
	     $search_result = $this->product_model->ExecuteQuery($Query);
         if($search_result->num_rows() >0){
	       foreach($search_result->result() as $result){
		      echo '<div class="show" align="left">';
              echo '<span class="name">@'.$result->user_name.'</span>&nbsp;<br/></div>';
		   }
		}		 
		}
	}
	public function fb_friend_notification(){
	   
	   $notification_name = explode('@',$this->input->post('fri_id'));
	   $fri_name = ucwords($notification_name[1]);
	   $this->load->library('facebook', array(
            'appId' => $this->config->item('facebook_app_id'),
            'secret' => $this->config->item('facebook_app_secret'),
       ));
	   $friends = $this->facebook->api($_SESSION['fb_user_id'].'/friends');
	   foreach($friends['data'] as $key => $_friends){
		  if(in_array($fri_name, $_friends)){
		      $fb_id = $_friends['id'];
		  }
		}
	  $notification = $this->facebook->api($fb_id.'/notifications/','post',array(
        'href' => base_url().$this->input->post('pr_url'),
        'template' => $_SESSION['first_name'].' '.$_SESSION['last_name'].' tagged you in a product. To see product visit '.base_url().$this->input->post('pr_url'),
       ));
	}
}

