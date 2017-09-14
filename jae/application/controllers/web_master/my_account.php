<?php
/*********
* Author: SWI
* Date  : 11 Sept 2017
* Modified By: 
* Modified Date: 
* Purpose:
*  Controller For Admin My_account. "i_user_type_id"=1 is for super admin
* 
* @package General
* @subpackage My account
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/my_account_model.php
* @link views/admin/my_account/
*/

class My_account extends MY_Controller
{
    public $cls_msg, $tbl, $user_img_width, $user_img_height;//////All defined error messages. 
    
    public function __construct()
    {
            
        try
        {
            parent::__construct();
            ////////Define Errors Here//////
            $this->cls_msg=array();
			$this->cls_msg["no_result"] 	= get_message('no_result');
			$this->cls_msg["save_err"] 		= get_message('save_failed');
			$this->cls_msg["save_succ"] 	= get_message('save_success');
			$this->cls_msg["delete_err"] 	= get_message('del_failed');
			$this->cls_msg["delete_succ"] 	= get_message('del_success');
            ////////end Define Errors Here//////
            $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";           
            $this->tbl = $this->db->USER;
		 
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
			$loggedin = $this->session->userdata('admin_loggedin');
			$user_type = decrypt($loggedin["user_type_id"]);
			$user_id = decrypt($loggedin["user_id"]);
			redirect($this->pathtoclass."modify_information/");
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
			$this->data['title'] = "My Account";// Browser Title
			$this->data['BREADCRUMB'] =	array(addslashes(t('My Account')));
			$loggedin = $this->data['admin_loggedin'];
            $this->data['heading'] = "Edit information";
            $this->data['pathtoclass'] = $this->pathtoclass;
			$mix_data = $this->session->userdata('admin_loggedin');
			
            // Submitted Form 
            if($_POST)
            {
				$posted = array();
				$posted = $_POST;
				$user_id= $mix_data['user_id'];
              
                $this->form_validation->set_rules('s_first_name', addslashes(t('First name')), 'required');
                $this->form_validation->set_rules('s_last_name', addslashes(t('L:ast name')), 'required');
                //$this->form_validation->set_rules('s_email', addslashes(t('email')), 'required|xss_clean|valid_email|is_unique['.$this->tbl.'.s_email.i_id.'.decrypt($user_id).']');
				
                if($this->form_validation->run() == FALSE)// invalid
                {
                    $this->data["posted"]=$posted;
                }				
                else// validated, now save into DB
                {                    
                    
                    $info	=	array();
                    $info["s_first_name"]    		= $posted["s_first_name"];
					$info["s_last_name"]			= $posted["s_last_name"];
					$info["s_customer_name"]		= $posted["s_customer_name"];
					$info["s_company_name"]			= $posted["s_company_name"];
					$info["s_company_fein_number"]	= $posted["s_company_fein_number"];
					$info["s_company_address"]		= $posted["s_company_address"];
					$info["i_auto_email"]			= $posted["i_auto_email"];
					//pr($info,1);
                    $i_aff = $this->acs_model->edit_data($this->tbl, $info, array('i_id' => decrypt($mix_data['user_id'])));
                    if($i_aff)// saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."modify_information");
                    }
                    else// Not saved, show the form again
                    {
                        $this->data["posted"]=$posted;
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    unset($info,$posted);
                }
            }
            else
            {   
				$info = $this->acs_model->fetch_data($this->tbl, array('i_id'=>decrypt($mix_data['user_id'])));
				$posted = array();
				$posted = $info[0];
				
				$posted["h_id"]= trim(encrypt($info["id"]));   
                $this->data["posted"] = $posted;       
                unset($info,$posted);      
            }
		  	$this->render('my_account/my_account');
            // Put the select statement here
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
	
    
    public function __destruct()
    {}
}
