<?php

/*********
* Author: Mrinmoy Mondal
* Date  : 03 July 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Common Model formats 
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/user_login.php
* @link views/admin/dashboard/
*/



class Page_not_found extends MY_Controller
{
    public $cls_msg;//All defined error messages. 
    public $pathtoclass;    

    public function __construct()
    {
        try
        {
			parent::__construct();
			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
    /***
    * Login Admin
    * 
    */

    public function index()
    {
        try
        {
			if($this->uri->segment(1) == 'web_master')
				redirect(admin_base_url().'error_404/');
			$this->load->view('page_not_found.php');
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    

    }
	
    public function __destruct()

    {}   

    

}	// end class




