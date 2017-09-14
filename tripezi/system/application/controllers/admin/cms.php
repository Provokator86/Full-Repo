<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 10 Jan 2012
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  Controller For Content Management
* 
* @package Content Management
* @subpackage Content 
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/content_model.php
* @link views/admin/content/
*/


class Cms extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public function __construct()
	{
		try
		{
			parent::__construct();
			$this->data['title']			=	"Content Management System";////Browser Title
			
			////////Define Errors Here//////
			$this->cls_msg = array();
			$this->cls_msg["no_result"]		=	"No information found about content.";
			$this->cls_msg["save_err"]		=	"Information about content failed to save.";
			$this->cls_msg["save_succ"]		=	"Information about content saved successfully.";
			$this->cls_msg["delete_err"]	=	"Information about content failed to remove.";
			$this->cls_msg["delete_succ"]	=	"Information about content removed successfully.";
			////////end Define Errors Here//////
			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
			
			//////// loading default model here //////////////
			$this->load->model("cms_model","mod_rect");
			//////// end loading default model here //////////////
			
			
			///////////assigning content type/////////
			$this->i_content_type		=	($this->session->userdata("h_content_type")?$this->session->userdata("h_content_type"):1);
			///////////end assigning content type/////////

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
			$this->i_content_type = 1;
			$this->session->set_userdata("h_content_type",$this->i_content_type); 			
			
            //There is no listing page admin edit the content of cms pages 
			redirect($this->pathtoclass."add_information");
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
    {
        //echo 'politique de confidentialit&eacute;';
		try
        {
            $this->data['title']			=	"Content Management";////Browser Title
            $this->data['heading']			=	"CMS";
            $this->data['pathtoclass']		=	$this->pathtoclass;
            $this->data['mode']				=	"add";
			$posted=array();
                
            $this->data["posted"]           =   $posted;
            ////////////Submitted Form///////////
            if($_POST)
            {

				$posted=array();
				$posted["opt_title"]				=	trim($this->input->post("opt_title"));
                $posted["txt_content_description"]	= 	trim($this->input->post("txt_content_description"));							
                $posted["h_mode"]= $this->data['mode'];
                $posted["h_id"]= "";
				
				
               
                
                $this->form_validation->set_rules('txt_content_description', 'content description', 'required');
				
              	$info	=	array();				

                if($this->form_validation->run() == FALSE )/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $i_id       			        =	decrypt($posted["opt_title"]);
                    $info["s_description"]			=	$posted["txt_content_description"];					  
					$info["dt_updated_on"]          =    time();
                    
					$i_aff=$this->mod_rect->edit_info($info,$i_id);
					if($i_aff)////saved successfully
						{
							set_success_msg($this->cls_msg["save_succ"]);
							//redirect($this->pathtoclass."show_list");
							redirect($this->pathtoclass."add_information");
						}
					else///Not saved, show the form again
						{
							$this->data["posted"]=$posted;
							set_error_msg($this->cls_msg["save_err"]);
						}
						
                    
                }
            }
            ////////////end Submitted Form///////////
            $this->render("cms/add-edit");
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }

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
    {
          
        try
        {
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    

    /***
    * Method to Delete information
    * This have no interface but db operation 
    * will be done here.
    * 
    * On Success redirect to the showList interface else display error in showList interface. 
    * @param int $i_id, id of the record to be modified.
    */      
    public function remove_information($i_id=0)
    {
        try
        {
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    } 
    
    /***
    * Shows details of a single record.
    * 
    * @param int $i_id, Primary key
    */
    public function show_detail($i_id=0)
    {
        try
        {
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	
	public function show_email_content()
	{
		try
        {
		}
	  	catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
	}
	
	
	 /**
    * This ajax function is used to fetch contains of faq in selected language.
    * posted data is language prefix and cms type id. 
    * 
    */
	function ajax_get_content()
	{
        try
        {
            $i_id = trim($this->input->post("type_id"));
            $info = $this->mod_rect->fetch_this(decrypt($i_id));
            if(!empty($info))
            {
                 echo ($info['s_description']);
            }
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
	}
	
	
	
      
	
	
	
	public function __destruct()
    {}           
    
	
	
}
?>