<?php
/*********
* Author: SWI
* Date  : 11 Sept 2017
* Modified By: SWI
* Modified 
* 
* Purpose:
*  Common Model formats 
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/user_login.php
* @link views/admin/dashboard/
*/

class Home extends MY_Controller
{
    public $cls_msg, $conf;//All defined error messages. 
    public $pathtoclass;    

    public function __construct()
    {
        try
        {
			parent::__construct();
			//Define Errors Here//
			$this->cls_msg = array();
			
			$this->cls_msg["invalid_login"] = "Invalid user name or password. Please try again.";
            $this->cls_msg["success_login"] = "Successfully logged in.";
			$this->cls_msg["invalid_user"]  = "This user does not exist.";
			//end Define Errors Here//
			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
            $this->load->model("user_model","mod_ul");  
            $this->load->helper("email");  
                 
            $this->conf=&get_config();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
    /* forgot password*/
    public function forgot_password()
    {
        try
        {
            // If a logged in user type the login url then redirect him to the dashboard page.
            $login_status = $this->session->userdata("admin_loggedin");
            if(!empty($login_status))
            {
                redirect(admin_base_url()."dashboard/");
            }
            //Posted login form//

            if($_POST)
            {
                $posted = array();
                $posted["s_email"] = trim($this->input->post("s_email"));                
                $this->form_validation->set_rules('s_email', 'email', 'required');
                
                if($this->form_validation->run() == FALSE)//invalid
                {
                    //Display the add form with posted values within it//
                    $this->data["posted"]=$posted;
                }   
                else//validated, now save into DB
                {
                    
                    $info = array();
                    $info["s_email"] = $posted["s_email"];
                    $loggedin = $this->mod_ul->backend_chk_user($info);    
                    if(!empty($loggedin))   //saved successfully
                    {                        
                        $rand_no    = rand(99,mktime());
                        $org_pass   = (trim($rand_no)); 
                        //$org_pass   = 'admin123';
                        $info['s_password'] = md5($org_pass.$this->conf["security_salt"]);
                        //$s_where=" Where s_email='".get_formatted_string($s_email)."' ";  
                        $arr_cond = array('s_email'=>$posted["s_email"]);
                        #pr($info,1);
                        $i_aff = $this->acs_model->edit_data($this->db->USER,$info,$arr_cond);
                        if($i_aff)
                        {
                            $s_where = " s_key='forgot' ";
                            $content  = $this->acs_model->fetch_data($this->db->EMAIL_TEMPLATE,$s_where);
                            $info     = $content[0];
                            $filename = $this->config->item('EMAILBODYHTML')."common.html";
                            $handle   = @fopen($filename, "r");
                            $mail_html= @fread($handle, filesize($filename));

                            if(!empty($info))
                            {                            
                                $description = $info["s_content"];
                                $description = str_replace("##EMAIL##",$posted["s_email"],$description);   
                                $description = str_replace("##PASSWORD##",$org_pass,$description); 
                                $description = str_replace("##SITE_URL##",admin_base_url(),$description); 
                            }
                            //unset($info);
                            //echo "<br>DESC".$description;    exit;
                            $mail_html = str_replace("##SITE_URL##",base_url(),$mail_html);    
                            $mail_html = str_replace("##MAIL_BODY##",$description,$mail_html);
                            //echo "<br>DESC".$mail_html;    exit;
                            
                            $email = $posted["s_email"];
                            //$email = 'mmondal@codeuridea.com';
                            //$email = 'mrinsss@gmail.com';
                            //echo $email;
                            $i_sent =sendEmail($email,$info['s_subject'],$mail_html,$this->s_admin_email);
                            if($i_sent)
                                set_success_msg('Please check your email to get the new password');    
                            else
                                set_error_msg('Please try again');  
                            $this->data["posted"]=$posted;
                        }
                        //redirect(admin_base_url()."dashboard/");
                    }
                    else//Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["invalid_user"]);
                        $this->data["posted"]=$posted;
                    }
                }
            }
            //end Posted login form//
            unset($loggedin);
            $this->render("forgot_password",true);            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
    
    /***
    * Login Admin
    */

    public function index()
    {
        try
        {
			// If a logged in user type the login url then redirect him to the dashboard page.
			$login_status = $this->session->userdata("admin_loggedin");
			if(!empty($login_status))
			{
				redirect(admin_base_url()."dashboard/");
			}
			//Posted login form//

            if($_POST)
            {
                $posted = array();
                $posted["txt_user_name"] = trim($this->input->post("txt_user_name"));
                $posted["txt_password"] = trim($this->input->post("txt_password"));
                $chk_remember = $this->input->post("chk_remember");
                
                $this->form_validation->set_rules('txt_user_name', 'user name', 'required');
                $this->form_validation->set_rules('txt_password', 'password', 'required');
                
                if($this->form_validation->run() == FALSE)//invalid
                {
                    //Display the add form with posted values within it//
                    $this->data["posted"]=$posted;
                }   
                else//validated, now save into DB
                {
                    #$this->load->model("User_login","mod_ul");  
                    $info = array();
                    $info["s_user_name"] = $posted["txt_user_name"];
                    $info["s_password"] = $posted["txt_password"];   
					$loggedin = $this->mod_ul->backend_user_login($info);	
					
                    if(!empty($loggedin))   //saved successfully
                    {
						$mix_data = $this->session->userdata('admin_loggedin');
						if($chk_remember)
						{								
							setcookie('acs_login_username',$info["s_user_name"], time()+(60*60*24*365), '/', '', '');
							setcookie('acs_login_password',$info["s_password"], time()+(60*60*24*365), '/', '', '');
						}
						else
						{
							setcookie('acs_login_username','', time()+(60*60*24*365), '/', '', '');
							setcookie('acs_login_password','', time()+(60*60*24*365), '/', '', '');
						}
						if(decrypt($mix_data['user_type'])!=0)
							set_success_msg('Thanks for login ! Please change your current password');	
                        //redirect(admin_base_url()."home/nap_select_default_role");
                        redirect(admin_base_url()."dashboard/");                       
                    }
                    else//Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["invalid_login"]);
                        $this->data["posted"]=$posted;
                    }
                }
            }
            //end Posted login form//
            unset($loggedin);
            $this->render("index",true);            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
   
    /***
    * Logout Admin
    * 
    */
    public function logout()
    {
        try
        { 
            //log report//
            #$this->load->model("User_login","mod_ul");
            $logi["msg"]="Logged out as ".$this->data['loggedin']["user_fullname"]
                        ."[".$this->data['loggedin']["user_name"]."] at ".date("Y-M-d H:i:s") ;

            $this->mod_ul->log_info($logi); 
            unset($logi);  
            //end log report//                

            //$this->session->sess_destroy();  
			$this->session->destroy(); 
            redirect(admin_base_url().'home/');
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }  

    /***
    * Tracking Menu clicked
    * 
    */
    public function ajax_menu_track()
    {
        try
        { 
            /*if($this->input->post("h_menu"))
            {
				//removing the search and session set messages when new page is called//
                $this->session->set_userdata($this->s_search_var,array());
                $array_items = array('success_msg' => '', 'error_msg' => '');
                $this->session->unset_userdata($array_items);
                unset($array_items);                
                //end removing the search and session set messages //
                $this->session->set_userdata("s_menu",$this->input->post("h_menu"));
                echo "done";
            }
            else
            {
                echo "not done";
            }*/
            $this->session->unset_userdata('parent_menu_id');
            $this->session->unset_userdata('child_menu_id');
            $this->session->set_userdata('parent_menu_id',$this->input->post('parent_id'));
            $this->session->set_userdata('child_menu_id',$this->input->post('child_id'));
            echo 'success';
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    } 
    
    /*public function set_menu_session()
    {
        $this->session->unset_userdata('parent_menu_id');
        $this->session->unset_userdata('child_menu_id');
        $this->session->set_userdata('parent_menu_id',$this->input->post('parent_id'));
        $this->session->set_userdata('child_menu_id',$this->input->post('child_id'));
        echo 'success';
    }*/
    
    
    /* ~~~~~~~~~~~~~~~ new code on 28 aug 2015 as per requirement~~~~~~~~~~~
    * set maximum role as default login 
    */
   
    public function __destruct()
    {}   
}	// end class
