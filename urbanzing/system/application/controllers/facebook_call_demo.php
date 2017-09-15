<?php
include BASEPATH.'application/controllers/MY_Controller'.EXT;

class Facebook_call_demo extends MY_Controller
{
    function __construct()
    {
       parent::__construct();
       $this->load->library("Facebook");
    }

    function facebook_wall_post()
    {
       // $this->check_user_page_access('non_registered');
	   
	    
	    $message = "hiiii".time();
		
	   	$this->facebook->config_facebook($this->config->item("FB_API_KEY") , $this->config->item("FB_SECRET"));
		$fb_user	=	$this->facebook->get_loggedin_user();	 // RETURNS THE LOGGED IN FACEBOOK USER ID
	   
		if($fb_user)
		   {
		   	
            try{

   						if( $this->facebook->api_client->stream_publish($message, $attachment = null, $action_links = null, $target_id = $fb_user,$uid = $fb_user))
                      {
                          $fbpost='success';
                      }       

					//header("location:".base_url());
					echo "heyyy";
					exit;
								 
				 
			 	 }catch(Exception $e)
				 {
						
							exit;
				 }
		   	}else
                   {
                      $this->facebook->require_login("read_stream,offline_access,publish_stream");
					 
                   }	
           
		
       
        
    }
	
}
