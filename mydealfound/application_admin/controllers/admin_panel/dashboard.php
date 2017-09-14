<?php

/*********
* Author: Mrinmoy Mondal
* Date  : 8 july 2014
* Modified By: 
* Modified Date: 
* Purpose:
*  Controller For Admin Dashboard. "i_user_type_id"=0 is for super admin
* @package Admin
* @subpackage 
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
		  $this->load->model("user_model");  
		  $this->load->model("store_model");
		  $this->load->model('payment_report_model','mod_pay');
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
					
			$s_where = "i_active = '1' ";
			$this->data["user_count"] = $this->user_model->count_total($s_where);
			
			$s_where = "i_active = '1' ";
			$s_order_name = "t_timestamp";
			$order_by = "desc";
			$user	= $this->user_model->get_list($s_where,NULL,NULL,0,$s_order_name,$order_by);
			$this->data["user"]  = $user;
			
			$where = " WHERE i_is_active = '1' ";
			$this->data["store_count"] = $this->store_model->gettotal_info($where);
			
			
			// last 30 days store report
			$s_where=" WHERE e.product_name!='Cashback Earned From Registration' ";			
			$dt_thirtyday = date("Y-m-d",strtotime("-30 days"));
			$s_where.=" AND DATE( e.dt_of_payment) >='".$dt_thirtyday."' ";
			unset($dt_thirtyday); 
			
			$s_order_name 	= 's_merchant_name';
			$order_by 		= 'desc';
			$store_report	= $this->mod_pay->fetch_store_performance_list($s_where,$s_order_name,$order_by,0,NULL);
			$this->data["store_report"] = $store_report;
			
			//$this->data["store_count"] = count($store_report);
			//pr($store_report);
            unset($s_where,$s_order_name,$order_by,$store_report,$user);
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
    {}



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