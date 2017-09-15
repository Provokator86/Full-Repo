<?php
include BASEPATH.'application/controllers/MY_Controller'.EXT;

class Facebook_call extends MY_Controller
{
	function __construct()
        {
	    parent::__construct();
        $display       =       array();
		//$this->load->library("Facebook");
               
               
	}

	function index()
        {
                   
		  //$fb->config_facebook($this->config->item("FB_API_KEY") , $this->config->item("FB_SECRET"));
		  $fb			=	new Facebook( $this->data['api_key'] , $this->data['secret_key'] );
		  $fb_user	=	$fb->get_loggedin_user();	
		   if($fb_user)
		   {
		   	
                        try{

                            //SAVE TO DB START
                          
			     			//SAVE TO DB END

				header("location:".base_url()."account");exit;
				 
				 
			 	 }catch(Exception $e)
				 {
					$this->data['is_facebook_loggedin'] =FALSE;
				}
		   }else
                   {
                       $fb->require_login("read_stream,offline_access,publish_stream");
                   }
        }
	
	

}
