<?php
/*********
* Author: SWI
* Date  : 11 sept 2017
* Modified By: 
* Modified Date: 
* Purpose:
*  Controller For Admin Change_password. "i_user_type_id"=0 is for super admin
* 
* @package General
* @subpackage My account
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/my_account_model.php
* @link views/admin/my_account/
*/

class Change_password extends MY_Controller
{
    public $cls_msg, $tbl, $user_img_width, $user_img_height;//////All defined error messages. 
    
    public function __construct()
    {
            
        try
        {
            parent::__construct();
            ////////Define Errors Here//////
            $this->cls_msg=array();
			$this->cls_msg["no_result"] = get_message('no_result');
			$this->cls_msg["save_err"] = get_message('save_failed');
			$this->cls_msg["save_succ"] = get_message('save_success');
			$this->cls_msg["delete_err"] = get_message('del_failed');
			$this->cls_msg["delete_succ"] = get_message('del_success');
			
            ////////end Define Errors Here//////
            $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
            $this->load->model('user_model', 'mod_rect');

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
			$this->data['title']="Change password";////Browser Title
            $this->data['heading']="Change password";
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
			$this->data['title'] = "Change password";// Browser Title
			$this->data['BREADCRUMB'] =	array(addslashes(t('Change password')));
			$loggedin = $this->data['admin_loggedin'];
            $this->data['heading'] = "Edit information";
            $this->data['pathtoclass'] = $this->pathtoclass;
			$mix_data = $this->session->userdata('admin_loggedin');
            // Submitted Form 
            if($_POST)
            {
				$posted = array();
				$posted["h_id"] 				= $mix_data['user_id'];
				#$posted["txt_user_name"]		= trim($this->input->post("txt_user_name"));
				$posted["txt_password"]			= trim($this->input->post("txt_password"));
                $posted["txt_new_password"]		= trim($this->input->post("txt_new_password"));
                $posted["txt_confirm_password"]	= trim($this->input->post("txt_confirm_password"));
              
                //$this->form_validation->set_rules('txt_password', addslashes(t('Old password')), 'required|callback_authentication_check');
                $this->form_validation->set_rules('txt_new_password', addslashes(t('New password')), 'required');
                $this->form_validation->set_rules('txt_confirm_password', addslashes(t('Confirm password')), 'required|matches[txt_new_password]');
               
                $msg = '';
                if(!empty($posted["txt_new_password"]))
                {
                    $chk_pwd = chkPasswordValidation($posted["txt_new_password"]);                    
                    if($chk_pwd!=1 && !empty($chk_pwd))
                    {                        
                        foreach($chk_pwd as $key=>$val)
                        {
                            $msg .=$val.'</br>';
                        }
                    }
                }
             
                if($this->form_validation->run() == FALSE || $msg!='')// invalid
                {
                    // Display the add form with posted values within it 
                    if($msg!='')
                    {
                        set_error_msg($msg);
                    }
                    $posted['s_avatar'] = $posted["h_avatar"];
                    $this->data["posted"]=$posted;
                }				
                else// validated, now save into DB
                {   
                
                    $info	=	array();
                    #$info["s_user_name"]    = $posted["txt_user_name"];
					#$info["s_user_name"]	= $posted["s_email"];
                    //if(!empty($posted["txt_password"]) && !empty($posted["txt_new_password"]))
					if(!empty($posted["txt_new_password"]))
                    $info["s_password"]     = trim($posted["txt_new_password"]);
					#pr($info,1);
                    #$i_aff = $this->acs_model->edit_data($this->tbl, $info, array('i_id' => decrypt($mix_data['user_id'])));
	                $i_aff = $this->mod_rect->change_password_info($info, decrypt($mix_data['user_id']));
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
				$info = $this->mod_rect->fetch_this(decrypt($mix_data['user_id']));
				$posted = array();
				//$posted["s_chat_im"]    = trim($info["s_chat_im"]);
				$posted["h_id"]         = trim(encrypt($info["i_id"]));   
                $this->data["posted"] = $posted;       
                unset($info,$posted);      
            }
		  	$this->render('my_account/change_password');
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
