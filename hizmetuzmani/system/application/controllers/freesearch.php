<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 29 May 2012
* Modified By: 
* Modified Date: 
* 
* Purpose: 
* Frontend Freesearch
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class Freesearch extends My_Controller implements InfControllerFe
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
        try
        {
          parent::__construct();

			$this->data['title'] = "keyword match";

          ////////Define Errors Here//////

          $this->cls_msg=array();
		  $this->cls_msg["no_result"] = addslashes(t("No information found for this section."));

          ////////end Define Errors Here//////
		  $this->load->model('category_model','mod_cat');
		  $this->load->model('city_model','mod_city');

          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  $this->s_lang_prefix=   $this->session->userdata('lang_prefix');   // language prifix 
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
			$this->data['breadcrumb']  = array(addslashes(t('Post a job for free'))=>'');
			$this->data['txt_service'] = trim($this->input->post('txt_service'));
			$this->data['txt_where']   = trim($this->input->post('txt_where'));
			
			$s_where = " WHERE n.{$this->s_lang_prefix}_s_category_name LIKE '%".$this->data['txt_service']."%'";
			$this->data['service_category'] = $this->mod_cat->fetch_multi($s_where,0,15);
			unset($s_where);
			
			$s_where = " WHERE c.city LIKE '%".$this->data['txt_where']."%'";
			$this->data['service_city'] = $this->mod_city->fetch_multi($s_where,0,15);
			unset($s_where);
			//pr($this->data['service_category'],1);
			$this->render();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	 	    
    }   
	
	public function show_cms()
    {}  

    public function __destruct() //unload constructor
    {}           
}
