<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 07 Jan 2013
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  Controller For Admin My_account. "i_user_type_id"=0 is for super admin
* 
* @package General
* @subpackage My account
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/my_account_model.php
* @link views/admin/my_account/
*/

class My_account extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    
    public function __construct()
    {
            
        try
        {
          parent::__construct();
          ////////Define Errors Here//////
          $this->cls_msg=array();
          $this->cls_msg["no_result"]	= "No information found about user.";
          $this->cls_msg["save_err"]	= "Information about user failed to save.";
          $this->cls_msg["save_succ"]	= "Information about user saved successfully.";
          $this->cls_msg["delete_err"]	= "Information about user failed to remove.";
          ////////end Define Errors Here//////
		  $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
          $this->load->model("my_account_model","mod_rect");
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
            $this->data['title']="My Account";////Browser Title
            $this->data['heading']="My Account of Admin Panel";
            
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
			$this->data['title']="My Account";////Browser Title
            $this->data['heading']="My Account of Admin Panel";
			
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";
           
			$mix_data = $this->session->userdata('admin_loggedin');
		
            ////////////Submitted Form///////////
            if($_POST)
            {

				$posted=array();
				$posted["h_id"] 				= $mix_data['user_id'];
				
				$posted["txt_user_name"]		= trim($this->input->post("txt_user_name"));
				$posted["s_email"]				= trim($this->input->post("s_email"));
				$posted["txt_password"]			= trim($this->input->post("txt_password"));
                $posted["txt_new_password"]		= trim($this->input->post("txt_new_password"));
                $posted["txt_confirm_password"]	= trim($this->input->post("txt_confirm_password"));

              
                $this->form_validation->set_rules('txt_user_name', 'Username', 'required');
				 $this->form_validation->set_rules('s_email', 'Email', 'required');
				
				
				 
				if(!empty($posted["txt_password"]) || !empty($posted["txt_new_password"]) || !empty($posted["txt_confirm_password"]))
				{
				$this->form_validation->set_rules('txt_password', 'Old password', 'required|callback_authentication_check');
				$this->form_validation->set_rules('txt_new_password', 'New password', 'required|matches[txt_confirm_password]');
				$this->form_validation->set_rules('txt_confirm_password', 'Confirm password', 'required');
				}
             	
                if($this->form_validation->run() == FALSE)/////invalid
                {                  
					////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
				
                else///validated, now save into DB
                {
                   
					$info	=	array();
                    $info["s_user_name"]	= $posted["txt_user_name"];	
					 $info["s_email"]		= $posted["s_email"];					
					if(!empty($posted["txt_password"]) && !empty($posted["txt_new_password"]))
					{
						$info["s_password"]	=$posted["txt_new_password"];
					}
                   
					
                    $i_aff = $this->mod_rect->edit_info($info,decrypt($mix_data['user_id']));
					
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
                
                $info=$this->mod_rect->fetch_this(decrypt($mix_data['user_id']));
                //pr($info,1);
                $posted=array();
				$posted["txt_first_name"]= trim($info["s_first_name"]);
				$posted["txt_last_name"]= trim($info["s_last_name"]);
				$posted["txt_user_name"]= trim($info["s_user_name"]);
				$posted["s_email"]= trim($info["s_email"]);
				$posted["h_id"]= trim(encrypt($info["id"]));
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
		  	$this->render('my_account/my_account');
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