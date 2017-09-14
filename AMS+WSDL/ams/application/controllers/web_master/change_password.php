<?php
/*********
* Author: SWI
* Date  : 03 June 2015
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
            $this->cls_msg["no_result"]	= addslashes(t("No information found about user."));
            $this->cls_msg["save_err"]	= addslashes(t("Information about user failed to save."));
            $this->cls_msg["save_succ"]	= addslashes(t("Information about user saved successfully."));
            $this->cls_msg["delete_err"]	= addslashes(t("Information about user failed to remove."));
            ////////end Define Errors Here//////
            $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
            $this->load->model("my_account_model","mod_rect");
            $this->load->model('user_model');

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
			$this->data['title']=addslashes(t("Change password"));////Browser Title
            $this->data['heading']=addslashes(t("Change password"));
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
			$this->data['title'] = addslashes(t("Change password"));// Browser Title
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
	
	
	/*public function authentication_check($pass)
	{
		
		$mix_data = $this->session->userdata('admin_loggedin');
		
					
		if(decrypt($mix_data['user_type_id'])==0)
		{
			$i_res  = $this->mod_rect->auth_pass($pass);
		}
		else
		{			
			//$i_res  = $this->user_model->ckeck_password($pass);
		}
		
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
	*/
    
	/* manage user employee account */
	public function account_information($i_id)
    {
        try
        {
            $this->data['title']=addslashes(t("Edit Account Details"));
            $this->data['heading']=addslashes(t("Edit Account"));
            $this->data['pathtoclass']=$this->pathtoclass;
            $loggedin = $this->session->userdata('admin_loggedin');
			
			// check if the user only can edit his information or super admin can do it
			redirect($this->pathtoclass);
			$arr_where = array('i_id'=>decrypt($i_id));
			
            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
				$posted["s_first_name"]	  = trim($this->input->post("s_first_name"));
				$posted["s_last_name"]	   = trim($this->input->post("s_last_name"));
				$posted["s_email"]	 	   = trim($this->input->post("s_email"));
				$posted["s_address"]	 	   = trim($this->input->post("s_address"));
                $this->form_validation->set_rules('s_first_name', addslashes(t('first name')), 'required');
				$this->form_validation->set_rules('s_last_name', addslashes(t('last name')), 'required');
				$this->form_validation->set_rules('s_email', addslashes(t('Email')), 'required');
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["s_first_name"]	=	$posted["s_first_name"];
					$info["s_last_name"]	 =	$posted["s_last_name"];
					$info["s_email"]		 =	$posted["s_email"];
					$info["s_address"]		 =	$posted["s_address"];
					
					$user_table = $this->db->USER;
					$arr_where = array('i_id'=>decrypt($posted["h_id"]));
                    $i_aff = $this->acs_model->edit_data($user_table,$info, $arr_where);
                    if($i_aff)////saved successfully
                    {
						set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."account_information/".$i_id);
                    }
                    else///Not saved, show the form again
                    {
						$this->data["posted"]=$posted;
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    unset($info,$posted, $i_aff);
                }
            }
            else
            {
				$info=$this->user_model->fetch_this(decrypt($i_id));				
                $posted=array();				
				$posted = $info;
				$posted["h_id"]        = $i_id;
				$posted["i_id"]		= decrypt($i_id);
                $this->data["posted"]  = $posted;       
                unset($info,$posted);      
            }
            ////////////end Submitted Form///////////
            $this->render("my_account/account-edit");
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
	/***
    * Checks duplicate value using ajax call
    */
   /* public function ajax_checkduplicate()
    {
        try
        {
            $posted=array();
            ///is the primary key,used for checking duplicate in edit mode
            $posted["id"]				= decrypt($this->input->post("h_id"));/*don't change
            $posted["duplicate_value"]	= trim($this->input->post("h_duplicate_value"));
			
					
            if($posted["duplicate_value"]!="")
            {
                $qry=" WHERE ".(intval($posted["id"])>0 ? " n.id!=".intval($posted["id"])." And " : "" )
                    ." n.email='".$posted["duplicate_value"]."'" ;
					
					
                //$info=$this->mod_rect->fetch_multi($qry,$start,$limit); /*don't change
				$info=$this->user_model->fetch_multi($qry); /*don't change
				
                if(!empty($info))/////Duplicate eists
                {
                    echo "Duplicate exists";
                }
                else
                {
                    echo "valid";/*don't change
                }
                unset($qry,$info);
            }   
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }   */
    public function __destruct()
    {}
}