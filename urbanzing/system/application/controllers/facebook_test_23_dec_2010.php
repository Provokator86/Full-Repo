<?php
include BASEPATH.'application/controllers/MY_Controller'.EXT;
class Facebook_test extends MY_Controller
{		function __construct()
        {
	    parent::__construct();
        $display       =       array();
		//$this->load->library("Facebook");
               
               
	}

function index() 
 {

	$this->load->library('user_agent');  //loading this library for getting previous url     
	$previous_url = $this->agent->referrer();
	if (!preg_match("/facebook/i", $previous_url))
	{
		 #=========  PREPARARING WALL MESSAGE TO BE POSTED [start] =====================
		 $date = $this->input->post('visiting_date');
		 if($date == '')
		 {
		  $this->session->set_userdata(array('message'=>"You have to select a date.",'message_type'=>'err'));
		  header("location:".$previous_url);exit();
		  }
		$id = $this->input->post('business_id');
		$this->load->model('business_profile_model');
		$business_details = $this->business_profile_model->get_business_detail(array('id'=>$id));
		//var_dump($business_details);exit;
		//$wall_message = $business_details[0]['address']."\""."\n";
		$business_name = $business_details[0]['name']."( ".$business_details[0]['address']." )";
		$wall_message .= " I Plan to be @ ";
		$wall_message .= $business_details[0]['name'].', ';
		$wall_message .= $business_details[0]['address'].', ';
		$wall_message .= $business_details[0]['land_mark'].", Kolkata"."-".$business_details[0]['zipcode'];
		$hour = $this->input->post('hour');
		$minute = $this->input->post('minute');
		$am_pm = ($hour>=12)?'pm':'am';
		$wall_message .= " on ".$date;
		$wall_message .= " at ".$hour.': '.$minute.' '.$am_pm."\n";
		$message = htmlspecialchars($this->input->post('wallMessage'), ENT_QUOTES, 'utf-8')."\n";
		//$wall_message .= urlencode($previous_url);
		 if($business_details[0]['img_name'] != '') 
			$image[src]  = "http://www.urbanzing.com/images/uploaded/business/thumb/".$business_details[0]['img_name'];
		 else 
		 	$image[src]  = "http://www.urbanzing.com/images/front/img_03.jpg";	
		//$image[src] =  "http://www.acumencs.com/urbanzing/images/uploaded/business/thumb/".$business_details[0]['img_name'];
		#=========  PREPARARING WALL MESSAGE TO BE POSTED [end]  =====================
		//$this->session->set_userdata(array('wallMessage'=>$wall_message,'previous_url'=>$previous_url,'img_src'=>$image[src] ));
	$this->session->set_userdata(array('business_name'=>$business_name,'wallMessage'=>$wall_message,'previous_url'=>$previous_url,'img_src'=>$image[src] ,'message1'=>$message));
	//print_r($this->session->userdata(''));exit;	
		
	}
	
	  
	$fb = new Facebook( $this->data['api_key'], $this->data['secret_key'] );
	//$fb_user = $fb->get_loggedin_user();
    $fb_user = $this->data['FACEBOOKLOGIN'] ;
	if($fb_user)
	{
	
		try{
				//MESSAGE POST
			   $message = $this->session->userdata('wallMessage');
			   $image = array();
			  
       		   	$image[type]="image";
       		  	$image[src]  =	$this->session->userdata('img_src');
       			$image[href] =  $this->session->userdata('previous_url');
        
       			$attachment = array();
       			$attachment[name] 		= $this->session->userdata('business_name'); 
       			$attachment[href] 		= $this->session->userdata('previous_url');
       			$attachment[caption] 	= $this->session->userdata('wallMessage');
       			$attachment[description] = $this->session->userdata('message1');
       			$attachment[media] = array($image);
			  if( $fb->api_client->stream_publish('', $attachment, $action_links = null, $target_id = $fb_user,$uid = $fb_user))
			  {
					$fbpost='success';
					$previous_url = $this->session->userdata('previous_url');
					//$this->session->unset_userdata(array('wallMessage'=>'','previous_url'=>''));
					// Do additional db operation on success...
					header("location:".$previous_url);exit();
				}
				else
				{
					
					$previous_url = $this->session->userdata('previous_url');
					//$this->session->unset_userdata(array('wallMessage'=>'','previous_url'=>''));
					header("location:".$previous_url);exit();  
				} 	
		  }
		catch(Exception $e)
		{
		  $previous_url = $this->session->userdata('previous_url');
					//$this->session->unset_userdata(array('wallMessage'=>'','previous_url'=>''));
					header("location:".$previous_url);exit(); //print_r($e);exit;
		  
		}
	}
	
	else
	{
	
		$fb->require_login("read_stream,offline_access,publish_stream");
	}
 }
				
	

}