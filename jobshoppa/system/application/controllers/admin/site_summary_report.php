<?php
/*********
* Author: Iman Biswas
* Date  : 22 Sep 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For news
* 
* @package Content Management
* @subpackage News
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/news_model.php
* @link views/admin/news/
*/


class Site_summary_report extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public $uploaddir;
    public $thumbdir;
    public $showimgdir;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->data['title']="Site Summary Report ";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]="No information found.";
          $this->cls_msg["save_err"]="Information failed to save.";
          $this->cls_msg["save_succ"]="Information saved successfully.";
          $this->cls_msg["delete_err"]="Information failed to remove.";
          $this->cls_msg["delete_succ"]="Information removed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          //$this->load->model("commission_slab_model","mod_rect");
		  //////// end loading default model here //////////////
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }

    public function index()
    {
        try
        {
            redirect($this->pathtoclass."show_list");
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/****
    * Display the list of records
    * 
    */
    public function show_list($start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Site Summary Report";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
			$this->data["search_action"]=$this->pathtoclass.'show_report';///used for search form action
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
		    $this->pathtoclass=admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class/*don't change*/   
            $this->render();          
            unset($table_view,$info);
          
        }
        catch(Exception $err_obj)
        {
        	show_error($err_obj->getMessage());
        }          
    }    

    /***
    * Method to Display and Save New information
    * This have to sections: 
    *  >>Displaying Blank Form for new entry.
    *  >>Saving the new information into DB
    * After Posting the form, the posted values must be
    * shown in the form if any error occurs to avoid re-entry of the form.
    * 
    * On Success redirect to the showList interface else display error here.
    */
    public function add_information()           
    {}

    /***
    * Method to Display and Save Updated information
    * This have to sections: 
    *  >>Displaying Values in Form for modifying entry.
    *  >>Saving the new information into DB    
    * After Posting the form, the posted values must be
    * shown in the form if any error occurs to avoid re-entry of the form.
    * 
    * On Success redirect to the showList interface else display error here. 
    * @param int $i_id, id of the record to be modified.
    */      
    public function modify_information($i_id=0)
    {}
    

    /***
    * Method to Delete information
    * This have no interface but db operation 
    * will be done here.
    * 
    * On Success redirect to the showList interface else display error in showList interface. 
    * @param int $i_id, id of the record to be modified.
    */      
    public function remove_information($i_id=0)
    {} 
    
    /***
    * Shows details of a single record.
    * 
    * @param int $i_id, Primary key
    */
    public function show_detail($i_id=0)
    {}
     /***
    * Checks duplicate value using ajax call
    */
    public function ajax_checkduplicate()
    {}
	/* Dispaly summary report */
	public function show_report()
	{
		$this->data['pathtoclass']=$this->pathtoclass;
		$this->render('site_summary_report/show_detail');          
	    
	}	
	public function __destruct()
    {}
	
	
}
?>