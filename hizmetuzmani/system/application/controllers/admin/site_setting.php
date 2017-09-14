<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 29 March 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
* Controller For Site Setting
* 
* @package Content Management
* @subpackage site_setting
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/site_setting_model.php
* @link views/admin/site_setting/
*/

class Site_setting extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    /*public $uploaddir;
	public $uploaddir_fla;
	public $allowedExt;
	public $allowedExt_fla;*/
	
    public function __construct()
    {
            
        try
        {
          parent::__construct();
          ////////Define Errors Here//////
          $this->data['title']="Admin Site Setting";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	=	"No information found about admin site setting.";
          $this->cls_msg["save_err"]	=	"Admin site setting failed to save.";
          $this->cls_msg["save_succ"]	=	"Admin site setting saved successfully.";
          $this->cls_msg["delete_err"]	=	"Admin site setting failed to remove.";
          $this->cls_msg["delete_succ"]	=	"Admin site setting removed successfully.";
          ////////end Define Errors Here//////
		  $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
          $this->load->model("site_setting_model","mod_rect");
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
            $this->data['title']	=	"Admin Site Setting";////Browser Title
            $this->data['heading']	=	"Admin Site Setting";
            
            ////////////Fetching the users count info//////
            //$this->data['i_no_active_user']=$this->mod_rect->gettotal_info(" Where n.i_user_type_id!=0 And n.i_is_deleted=0 ");
            //$this->data['i_no_inactive_user']=$this->mod_rect->gettotal_info(" Where n.i_user_type_id!=0 And n.i_is_deleted=1 ");
            ////////////end Fetching the users count info//////
			
			$this->modify_information();
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
    public function show_list()
    {
        try
        {
          ////Put the select statement here
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
        try
        {
          ////Put the select statement here
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
            $this->data['pathtoclass']	=	$this->pathtoclass;
            $this->data['mode']			=	"edit";
            $this->data['heading']		=	"Admin Site Setting";
            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
				$posted["h_id"] 					= 	trim($this->input->post("h_id"));
				$posted["s_admin_email"]			= 	trim($this->input->post("s_admin_email"));
				$posted["s_paypal_email"]			= 	trim($this->input->post("s_paypal_email"));
				$posted["s_site_address"]			= 	trim($this->input->post("s_site_address"));
				$posted["s_facebook_address"]		= 	trim($this->input->post("s_facebook_address"));
				
				$posted["i_records_per_page"]		= 	trim($this->input->post("i_records_per_page"));
               
                $this->form_validation->set_rules('s_admin_email', 'admin email', 'required');
                $this->form_validation->set_rules('s_paypal_email', 'paypal email', 'required');
				$this->form_validation->set_rules('i_records_per_page', 'records per page', 'required');
				$this->form_validation->set_rules('s_facebook_address', 'facebook address', 'required');
				
				$info	=	array();
				
                if($this->form_validation->run() == FALSE || ($arr_upload_res[0]==='err'))/////invalid
                {
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
					$info["s_admin_email"]			=	$posted["s_admin_email"];
					$info["s_paypal_email"]			=	$posted["s_paypal_email"];
					//$info["s_contact_us_email"]		=	$posted["s_contact_us_email"];
					$info["s_site_address"]			=	$posted["s_site_address"];
					$info["s_facebook_address"]		=	$posted["s_facebook_address"];
					$info["i_records_per_page"]		=	$posted["i_records_per_page"];
					//$info["i_default_language"]		=	decrypt($posted["i_default_language"]);
 					//var_dump($info);exit;
                    $i_aff = $this->mod_rect->edit_info($info,decrypt($posted['h_id']));
					
                    if($i_aff)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."modify_information");
                    }
                    else///Not saved, show the form again
                    {
                        $this->data["posted"]=$posted;
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    unset($info,$posted);
                    
                }
            }
            else
            {
                //$info=$this->mod_rect->fetch_this(decrypt($mix_data['user_id']));
				
				$info=$this->mod_rect->fetch_this("NULL");  // This method id modified by Jagannath Samanta on 24 June 2011
				
                $posted=array();
				
				$posted["i_id"]						= 	trim($info["i_id"]);
				$posted["s_admin_email"]			= 	trim($info["s_admin_email"]);
				$posted["s_paypal_email"]			= 	trim($info["s_paypal_email"]);
				$posted["s_site_address"]			= 	trim($info["s_site_address"]);
				$posted["s_facebook_address"]		= 	trim($info["s_facebook_address"]);
				
				$posted["s_contact_us_email"]		= 	trim($info["s_contact_us_email"]);
				$posted["i_records_per_page"]		= 	trim($info["i_records_per_page"]);
				$posted["i_default_language"]		= 	encrypt(trim($info["i_default_language"]));
				$posted["s_sitename"]				= 	trim($info["s_sitename"]);
				$posted["s_title"]					= 	trim($info["s_title"]);
				$posted["h_id"]						= 	trim(encrypt($info["i_id"]));
				
                $this->data["posted"]				=	$posted;       
                unset($info,$posted);      
                
            }
		  	$this->render('site_setting/site_setting');
          ////Put the select statement here
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
	
	public function authentication_check($pass)
	{
		$i_res  = $this->mod_rect->auth_pass($pass);
		if ($i_res == 0)
		{
			$this->form_validation->set_message('authentication_check', 'You have typed incorrect password! Please type again..');
			return FALSE;
		}
		else
		{
			return TRUE;
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
          
          ////Put the select statement here
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

			////Put the select statement here
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }   
	
	  
    
	public function __destruct()
    {}
}