<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 20 July 2012
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  Controller For Admin Dashboard. "i_user_type_id"=0 is for super admin
* 
* @package Admin
* @subpackage 
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/dashboard_model.php
* @link views/admin/dashboard/
*/

class Dashboard extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $indian_symbol;
     
    public function __construct()
    {
            
        try
        {
          parent::__construct();
          ////////Define Errors Here//////
          $this->cls_msg=array();

          ////////end Define Errors Here//////
		  $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
          $this->load->model("dashboard_model","mod_rect");
		  $this->load->model("user_model","mod_user");
		  $this->load->model('property_model','mod_property');
		  $this->load->model('newsletter_subscribers_model','mod_subscriber');		 
        
		  
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
            $this->data['title']        =   "Dashboard";////Browser Title
            $this->data['heading']      =   "Dashboard of Admin Panel";
            $admin_loggedin             =   $this->session->userdata('admin_loggedin');
            $this->data['user_type_id'] =   decrypt($admin_loggedin['user_type_id']);
			$this->data['user_id'] 		=   decrypt($admin_loggedin['user_id']);
			
			$today = strtotime(date("Y-m-d"));
			$tomorrow = strtotime(date("Y-m-d",time()+86400));
			
			/********************************** FETCH LATEST USERS  **********************************/
			$s_where = "WHERE n.i_status =1 ORDER BY n.dt_created_on DESC ";
			$this->data["users"] = $this->mod_user->fetch_multi($s_where,0,5);
			//pr($this->data["users"]);
			/********************************** FETCH LATEST USERS  **********************************/
			
			/********************************** FETCH LATEST PROPERTY  **********************************/
			$s_where = "WHERE p.i_status =1 ";
			$this->data["property"] = $this->mod_property->fetch_multi($s_where,0,5);
			//pr($this->data["property"],1);
			/********************************** FETCH LATEST PROPERTY  **********************************/
			
			/********************************** FETCH LATEST BOOKING INFORMATION  **********************************/
			$s_where = "WHERE b.e_status !='' ";
			$this->data["booking"] = $this->mod_property->fetch_booking_list($s_where,0,5);
			//pr($this->data["booking"],1);
			/********************************** FETCH LATEST BOOKING INFORMATION  **********************************/
			
			/********************************** FETCH LATEST LATEST SUBSCRIBERS  **********************************/
			$s_where = "WHERE n.i_id !=0 ";
			$this->data["subscribers"] = $this->mod_subscriber->fetch_multi($s_where,0,5);
			//pr($this->data["subscribers"],1);
			/********************************** FETCH LATEST LATEST SUBSCRIBERS  **********************************/
			
            unset($admin_loggedin,$s_where);
			$this->render('dashboard/dashboard');  
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