<?php
/*********
* Author: SWI
* Date  : 2 June 2017
* Modified By: SWI
* Modified Date: 20 July 2017
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
            $this->load->model("User_login","mod_ul");  
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
			
			
			/*$this->load->library('Zip');
			$dwn_url = '/banner_image-2017';
			$folder_in_zip = FCPATH."uploaded/"; //root directory of the new zip file
			//$path = FCPATH.'uploaded/banner_image/';
			$path = FCPATH.'uploaded'.$dwn_url.'/';
			$this->zip->read_dir($path, FALSE);
			//$this->zip->archive($folder_in_zip.'myarchive.zip');
			$this->zip->download('my_bk.zip');*/


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
							set_success_msg(addslashes(t('Thanks for login ! Please change your current password')));	
                        //redirect(admin_base_url()."home/nap_select_default_role");
                        redirect(admin_base_url()."dashboard/");
                        //$this->nap_select_default_role(); // commented on 15nov as there is no multiple role
                        
                        #redirect(admin_base_url()."home/select_role");
                        //redirect(admin_base_url()."dashboard/");
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
	
    public function select_role()
    {
        $login_data = $this->session->userdata("admin_loggedin");

        // select user role
        $tbl[0] = array(
            'tbl' => $this->db->USERROLE.' AS ur',
            'on' =>''
        );
        $tbl[1] = array(
            'tbl' => $this->db->USER_TYPE.' AS ut',
            'on' => 'ut.id = ur.i_role_id'
        );
        
        $conf = array(
            'select' => 'ur.*, ut.s_user_type,ut.s_key',
            'where' => 'ur.i_user_id = '.intval(decrypt($login_data['user_id'])),
            'order_by' => 'ur.i_role_id'
        );
        $info = $this->acs_model->fetch_data_join($tbl, $conf);
        //pr($info,1);
        if(count($info) > 1 || (count($info) == 0 && intval(decrypt($login_data['user_type_id'])) != 1))
        {
            $this->data['role_info'] = $info;            
            $this->data['login_data'] = $login_data;
            $this->render("select_role", true);
        }
        else if(count($info) == 1)
            $this->nap_set_role(encrypt($info[0]['i_role_id']), encrypt($info[0]['i_region_id']), encrypt($info[0]['i_franchise_id']));// Set default role
        else if(intval(decrypt($login_data['user_type_id'])) == 1)
            $this->nap_set_role($login_data['user_type_id'], encrypt('admin'), encrypt('admin'));// Set role for dev
        
        
        if(!empty($login_status))
            redirect(admin_base_url()."dashboard/");
        
    }
    
    public function nap_set_role($role_id, $region_id = NULL, $franchise_id = NULL)
    {   
        $login_data = $this->session->userdata("admin_loggedin");
        if(empty($login_data)) redirect(admin_base_url()."home/logout");
        
        $region_id = decrypt($region_id);
        $franchise_id = decrypt($franchise_id);
        $role_id  = intval(decrypt($role_id));
        
        // Fetch user type key
        $tmp = $this->acs_model->fetch_data($this->db->USER_TYPE, array('id'=>$role_id), 's_key');
        $login_data['role_selected'] = 'yes';
        if($role_id <= 4)
        {
            $login_data['region_id'] = encrypt('admin');
            $login_data['franchise_id'] = encrypt('admin');
            $login_data['user_type_id'] = encrypt($role_id);
            $login_data['user_type_key'] = $tmp[0]['s_key'];
            $this->session->unset_userdata("admin_loggedin");
            $this->session->set_userdata("admin_loggedin", $login_data);
        }
        else if($region_id > 0 && $role_id > 4)
        {
            $login_data['region_id'] = encrypt($region_id);
            $login_data['franchise_id'] = encrypt($franchise_id);
            $login_data['user_type_id'] = encrypt($role_id);
            $login_data['user_type_key'] = $tmp[0]['s_key'];
            $this->session->unset_userdata("admin_loggedin");
            $this->session->set_userdata("admin_loggedin", $login_data);
        }
        
        unset($tmp, $region_id, $franchise_id, $role_id, $login_data);
        redirect(admin_base_url()."dashboard/");  
    }
    
    // Unset previously selected tole
    public function nap_unset_role()
    {
        $login_data = $this->session->userdata("admin_loggedin");
        if(empty($login_data)) redirect(admin_base_url()."home/logout");

        $login_data['role_selected'] = 'no';
        $login_data['region_id'] = '';
        $login_data['franchise_id'] = '';
        $login_data['user_type_id'] = '';
        $login_data['user_type_key'] = '';
        
        $this->session->unset_userdata("admin_loggedin");
        $this->session->set_userdata("admin_loggedin", $login_data);
        
        redirect(admin_base_url()."home/nap_select_default_role");
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
    
    public function nap_select_default_role()
    {
        
        $login_data = $this->session->userdata("admin_loggedin");
        #pr($login_data,1);
        // select user role
        $tbl[0] = array(
            'tbl' => $this->db->USERROLE.' AS ur',
            'on' =>''
        );
        $tbl[1] = array(
            'tbl' => $this->db->USER_TYPE.' AS ut',
            'on' => 'ut.id = ur.i_role_id'
        );
        
        $conf = array(
            'select' => 'ur.*, ut.s_user_type,ut.s_key',
            'where' => 'ur.i_user_id = '.intval(decrypt($login_data['user_id'])),
            'order_by' => 'ur.i_role_id'
        );
        $info = $this->acs_model->fetch_data_join($tbl, $conf);
        #pr($info,1);
        if(count($info) > 1 || (count($info) == 0 && intval(decrypt($login_data['user_type_id'])) != 1))
        {
            $this->data['role_info'] = $info;
            // ~~~~~~~~~~~~~~ below new code on 28 aug 2015 as per requirement ~~~~~~~~~~~~~~~~~~~~~~~~~
            if(!empty($info))
            {
                $str_user_role = '';
                $str_access_type = '';
                $str_region_ids = '';
                $str_farnchise_ids = '';
                $str_user_type_key = '';
                foreach($info as $val)
                {
                    if($val['i_role_id'])
                        $str_user_role.=','.$val['i_role_id'];
                    else
                        $str_user_role.=',0';
                        
                    if($val['e_access_type'])
                        $str_access_type.=','.$val['e_access_type'];
                    else
                        $str_access_type.=',0';
                        
                    if($val['i_region_id'])
                        $str_region_ids.=','.$val['i_region_id'];
                    else
                        $str_region_ids.=',0';
                        
                    if($val['i_franchise_id'])
                        $str_farnchise_ids.=','.$val['i_franchise_id'];
                    else
                        $str_farnchise_ids.=',0';
                        
                    if($val['s_key'])
                        $str_user_type_key.=','.$val['s_key'];
                    else
                        $str_user_type_key.=',0';
                }
            }
            
            $str_user_role      = trim($str_user_role,',');
            $str_access_type    = trim($str_access_type,',');
            $str_region_ids     = trim($str_region_ids,',');
            $str_farnchise_ids  = trim($str_farnchise_ids,',');
            $str_user_type_key  = trim($str_user_type_key,',');
            
            $login_data['str_user_role']        = $str_user_role;
            $login_data['str_access_type']      = $str_access_type;
            $login_data['str_region_ids']       = $str_region_ids;
            $login_data['str_farnchise_ids']    = $str_farnchise_ids;
            $login_data['str_user_type_key']    = $str_user_type_key;
            
            $this->session->unset_userdata("admin_loggedin");
            $this->session->set_userdata("admin_loggedin", $login_data);
            
            #$arr = explode(',',$str_user_role);
            #pr($login_data);
            $this->nap_set_default_role();
            // ~~~~~~~~~~~~~~~ end new code on 28 aug 2015 as per requirement ~~~~~~~~~~~~~~~~~~~~~~~~~~
            
            $this->data['login_data'] = $login_data;
            $this->render("select_role", true);
        }
        else if(count($info) == 1)
            $this->nap_set_role(encrypt($info[0]['i_role_id']), encrypt($info[0]['i_region_id']), encrypt($info[0]['i_franchise_id']));// Set default role
        else if(intval(decrypt($login_data['user_type_id'])) == 1)
            $this->nap_set_role($login_data['user_type_id'], encrypt('admin'), encrypt('admin'));// Set role for dev
        
        
        if(!empty($login_status))
            redirect(admin_base_url()."dashboard/");
        
    }
    
    public function nap_set_default_role()
    {   
        $login_data = $this->session->userdata("admin_loggedin");
        if(empty($login_data)) redirect(admin_base_url()."home/logout");
        #pr($login_data,1);
        
        $all_role = $login_data['str_user_role'];
        $arr_all_role = explode(',',$all_role);
        
        $all_access = $login_data['str_access_type'];
        $arr_all_access = explode(',',$all_access);
        
        $all_region = $login_data['str_region_ids'];
        $arr_all_region = explode(',',$all_region);
        
        $all_franchise = $login_data['str_farnchise_ids'];
        $arr_all_franchise = explode(',',$all_franchise);
        
        $all_key = $login_data['str_user_type_key'];
        $arr_all_key = explode(',',$all_key);
        
        $role_id = min($arr_all_role);
        $min_key = array_search($role_id, $arr_all_role);
        $region_id      = $arr_all_region[$min_key];
        $franchise_id   = $arr_all_franchise[$min_key];
        /*pr($arr_all_role);
        pr($arr_all_franchise);
        echo $min_key; exit;*/
        
        if($role_id <= 4)
        {
            $login_data['region_id']        = encrypt('admin');
            $login_data['franchise_id']     = encrypt('admin');
            $login_data['user_type_id']     = encrypt($role_id);
            $login_data['user_type_key']    = $arr_all_key[$min_key];
            $this->session->unset_userdata("admin_loggedin");
            $this->session->set_userdata("admin_loggedin", $login_data);
        }
        else if($region_id > 0 && $role_id > 4)
        {
            $login_data['region_id']        = encrypt($region_id);
            $login_data['franchise_id']     = encrypt($franchise_id);
            $login_data['user_type_id']     = encrypt($role_id);
            $login_data['user_type_key']    = $arr_all_key[$min_key];
            $this->session->unset_userdata("admin_loggedin");
            $this->session->set_userdata("admin_loggedin", $login_data);
        }
        unset($tmp, $region_id, $franchise_id, $role_id, $login_data);
        redirect(admin_base_url()."dashboard/");  
        pr($login_data);
            
        
    }

    public function __destruct()
    {}   
}	// end class
