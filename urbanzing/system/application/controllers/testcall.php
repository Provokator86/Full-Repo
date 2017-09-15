<?php
include BASEPATH.'application/controllers/MY_Controller'.EXT;

class Testcall extends MY_Controller
{
	function __construct()
        {
	    parent::__construct();
        $display       =       array();
		
               
               
	}

	function index()
        {
           
		   echo '<a href="'.base_url().'facebook_test/index/" >FACEBOOK WALL POST</a>';        
		   
        }
	function success()
        {
           
		   	echo 'Successfully message posted to facebook :-) ';        
		   
        }	
	function fail()
        {
           
		   	echo 'NO message posted to facebook :-) ';        
		   
        }	
		
		
		
	
	

}
