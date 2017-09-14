<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 20 Aug 2011
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
		  $this->load->model("coupon_model");
		  //$this->load->model("newsletter_subscribers_model");
		  //$this->load->model("manage_notification_model","mod_noti");
          
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
            $this->data['heading']      =   "Dashboard Of Admin Panel";
            $admin_loggedin             =   $this->session->userdata('admin_loggedin');
            $this->data['user_type_id'] =   decrypt($admin_loggedin['user_type_id']);
			$this->data['user_id'] 		=   decrypt($admin_loggedin['user_id']);
			$s_where = "";
			$where	= " WHERE (cdc.i_is_active	= 1 AND cdc.dt_of_live_coupons <= now() 
							AND cdc.dt_exp_date >= now()) 
							ORDER BY cdc.dt_date_of_entry DESC";
			//$info = $this->coupon_model->fetch_multi_sorted_list($s_where,'dt_date_of_entry','desc','','');
			$info =$this->coupon_model->fetch_multi_top_latest_coupons($where,intval(0),20);
			//$s_where.="WHERE i_del_status=1";
			$coupon_latest= $this->coupon_model->fetch_max_hit();
			//pr($info,1);
			
			$this->data['coupon'] 		= $info;
			$this->data['coupon_latest']	= $coupon_latest;
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