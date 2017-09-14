<?php 
/*********
* Author: Mrinmoy Mondal
* Date  : 22 Sept 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For Region. 
* 
* @package 
* @subpackage 
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/region/
*/
class Forgot_password extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->data['title']="Forgot Password";////Browser Title
          
          ////////Define Errors Here//////
          /*don't change, you may add*/
          $this->cls_msg=array();
          $this->cls_msg["no_result"]="No information found about ".strtolower($this->data['title']).".";
          $this->cls_msg["save_err"]="Information about ".strtolower($this->data['title'])." failed to save.";
          $this->cls_msg["save_succ"]="A new password has been generated and send to #Email# successfully.";
          $this->cls_msg["delete_err"]="Information about ".strtolower($this->data['title'])." failed to remove.";
          $this->cls_msg["delete_succ"]="Information about ".strtolower($this->data['title'])." removed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass=admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class/*don't change*/
          /////////Loading the common model///////////
          $this->load->model("forgot_password_model","obj_mod_");		  
          /////////end Loading the common model///////////
		  
		  $this->load->model("auto_mail_model",'mod_mail');
		 /// Loading Content Model for fetching content of Forgot Password///
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }

    /***
    * Login Admin
    * 
    */
    public function index()
    {
        try
        { 
			///Posted login form///
            if($_POST)
            {
                $posted=array();
                /// INPUT GIVEN EMAIL ID whose PASSWORD needs to be sent ///
				$s_email = $posted["txt_email"]= trim($this->input->post("txt_email"));  
				
				$sender_email = $this->s_admin_email;             
                $this->form_validation->set_rules('txt_email', 'email', 'required');               
			 
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
					// GENERATE NEW PASSWORD and send it to mail///
					$rand_no		=	rand(99,mktime());
		  			$org_changed_pass	=	(trim($rand_no));          			
				
                    $s_where=" Where s_email='".get_formatted_string($s_email)."' ";              
                    
                 	$loggedin=$this->obj_mod_->change_password($s_where,$org_changed_pass);
					
					$info1	=	$this->obj_mod_->fetch_name($s_where);	/// getting USERNAME depending on EMAIL ///
					if(!empty($info1))
					{	
						$s_username	= $info1["s_username"];
					}
					unset($info1);	
							
                    if(!empty($loggedin))   ////saved successfully
                    {
						/// Fetching DESCRIPTION of Forgot Password and REPLACING VARIABLES///
						$info=$this->mod_mail->fetch_mail_content('forget_password','general');
						$filename = $this->config->item('EMAILBODYHTML')."common.html";
				   		$handle = @fopen($filename, "r");
				   		$mail_html = @fread($handle, filesize($filename));
						
						if(!empty($info))
						{							
							$description = $info["s_content"];
							$description = str_replace("[User name]",$s_username,$description);	// Changine USER FULLNAME
							$description = str_replace("[User username]",$s_username,$description);	// Changine MAIL SENDER NAME	
							$description = str_replace("[new password]",$org_changed_pass,$description); // Changine PASSWORD
							$description = str_replace("[site_url]",base_url(),$description); 
							$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
						}
						unset($info);
						//echo "<br>DESC".$description;	exit;
						
						$mail_html = str_replace("[site url]",base_url(),$mail_html);	
						$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
							
						//save_succ #Email#
                        set_success_msg(str_replace("#Email#",get_unformatted_string($s_email),$this->cls_msg["save_succ"]));
											
						/// Mail sending Process starts//				
						$this->load->library('email');
						$config['protocol'] = 'sendmail';
						$config['mailpath'] = '/usr/sbin/sendmail';
						$config['charset'] = 'iso-8859-1';
						$config['wordwrap'] = TRUE;
						$config['mailtype'] = 'html';
						
						$this->email->initialize($config);
						
						$this->email->clear();
						
						$this->email->from($sender_email);
						$this->email->to($s_email);								
						$this->email->subject('Your Password has been changed.');
						$this->email->message($mail_html);						
						$this->email->send();
						/// Mail sending Process ends//
                        ///redirect(admin_base_url()."home/");
                    }
                    else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["save_err"]);
                        $this->data["posted"]=$posted;
                    }
                }
            }
            ///end Posted login form///
            unset($loggedin);
            $this->render("forgot_password",true);
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

    /***
    * Method to Delete information
    * This have no interface but db operation 
    * will be done here.
    * 
    * On Success redirect to the showList interface else display error in showList interface. 
    * @param int $i_id, id of the record to be modified.
    */      
    public function remove_information($i_id=0)
    {}                 
    
    /***
    * Shows details of a single record.
    * 
    * @param int $i_id, Primary key
    */
    public function show_detail($i_id=0)
    {}     
            
    public function __destruct()
    {}   
}///End of class