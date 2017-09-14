<?php
/*********
* Author:Jagannath Samanta 
* Date  : 15 July 2011
* Modified By: 
* Modified Date: 
* 
* Purpose: 
* Frontend under_construction Page
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class Under_construction extends My_Controller implements InfControllerFe
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
        try
        {
          parent::__construct();

			$this->data['title'] = "Under Construction";

          ////////Define Errors Here//////

          $this->cls_msg=array();
		 // $this->cls_msg["no_result"] = "No information found for this section.";

          ////////end Define Errors Here//////

          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }

    /***
    * 
    * 
    */
    public function index()
    {
        try
        {
			$this->data['heading'] = "";
			$this->data['bread_cum']="  &raquo; Under Construction";//
			$this->data['ctrlr'] = "home";
			$this->render();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	 	    
    }    
  
    /****
    * Display the static contents For this controller
    * 
    */
    public function show_cms()
    {
			//content here
    } 

    public function __destruct() //unload constructor
    {}           
}
