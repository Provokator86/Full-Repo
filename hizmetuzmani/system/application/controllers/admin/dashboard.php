<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 04 April 2012
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
		  $this->load->model("manage_notification_model","mod_noti");
		  $this->load->model('job_model');
		  $this->load->model('manage_private_message_model');
		  $this->load->model('comm_payment_model');
          
          $this->indian_symbol  =   '<span class=WebRupee>Rs.</span>';
          $this->data['indian_symbol']  =   $this->indian_symbol;
		  
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
			
			$this->data['i_total_buyer']	= $this->mod_rect->gettotal_user_info(" Where n.i_role=1 And n.i_is_active=1 ");
			$this->data['i_total_tradesman']= $this->mod_rect->gettotal_user_info(" Where n.i_role=2 And n.i_is_active=1 ");
			
			$this->data['i_total_user_to_approve']	= $this->mod_rect->gettotal_user_info(" Where n.i_is_active=0 ");
			
			$s_where = " WHERE FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d')= CURDATE() ";
		    $this->data['i_tot_quotes'] = $this->job_model->gettotal_quote_dashboard_info($s_where);
			
			$s_where = " WHERE FROM_UNIXTIME( n.i_date , '%Y-%m-%d')= CURDATE() ";
		    $this->data['i_tot_msg_post'] = $this->manage_private_message_model->gettotal_msg_info($s_where);
			
			$s_where = " WHERE n.i_payment_type=1 AND n.i_payment_date BETWEEN {$today} AND {$tomorrow} ";
		    $this->data['total_pay_amount'] = $this->comm_payment_model->gettotal_amount($s_where).' '.$this->config->item("default_currency");
			
			$s_where = " WHERE n.i_status=0 AND n.i_is_deleted!=1 "; 
		    $this->data['new_jobs'] = $this->job_model->fetch_multi_completed($s_where,0,5);
			$this->data['new_jobs_to_approve'] = $this->job_model->gettotal_info($s_where);
			//pr($this->data['new_jobs']);
			$s_where = " WHERE n.i_status=1 AND n.i_is_deleted!=1 "; 
		    $this->data['active_jobs'] = $this->job_model->fetch_multi_completed($s_where,0,5);
			//pr($this->data['active_jobs']);
			$s_where = " WHERE n.i_status=6 AND n.i_is_deleted!=1 "; 
		    $this->data['completed_jobs'] = $this->job_model->fetch_multi_completed($s_where,0,5);
            
			//pr($this->data['completed_jobs']);
			// Latest 5 notifications list
			$s_where = " WHERE n.i_user_type = 1 ";
			$this->data['latest_notification'] = $this->mod_noti->fetch_multi_sorted_list($s_where,'dt_created_on','DESC',0,5);
			//pr($this->data['latest_notification'],1);
			
            unset($admin_loggedin);
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