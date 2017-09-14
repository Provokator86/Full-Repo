<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 06 July 2012
* Modified By: 
* Modified Date: 
* 
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class User extends My_Controller
{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public function __construct()
    {
        try
        { 
          parent::__construct(); 
          $this->data['title']="User";////Browser Title
		  $this->data['ctrlr'] = "user";

          $this->cls_msg=array();

		  $this->cls_msg["no_result"]				= "No information found about latest news.";		  
		  $this->cls_msg["contact_send_err"]		= "Contact us mail not delivered.";
          $this->cls_msg["contact_send_succ"]       = "Contact us mail delivered successfully.";
          $this->cls_msg["create_acc_succ"]         = "Your account has been created successfully,Check your email to activate.";
          $this->cls_msg["create_acc_err"]		    = "Account  creation failed.";
          $this->cls_msg["invalid_login"]           = "Invalid email address or password. Please try again.";
          $this->cls_msg["success_login"]           = "Successfully logged in.";
          $this->cls_msg["accout_activated_succ"]   = "Your account has been activated successfully, Please login .";
		  $this->cls_msg["forgot_pwd_succ"]			= "An email has been sent to your email address to change your password";
		  $this->cls_msg["forgot_pwd_err"]			= "This email address is not registered";
		  $this->cls_msg["save_pwd"]				= "password changed successfully";
          $this->cls_msg["save_pwd_err"]            = "password changed could not saved";
		  $this->cls_msg["err_account_disable"]		= "Your account has been inactive.";
          
		  
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  $this->load->model('cms_model','mod_cms');
          $this->load->model('user_model','mod_user');	
		  $this->load->model('property_model','mod_property');	  
		   $this->load->model('common_model','mod_common');
		  //redirect(base_url().'admin/home/');
		  
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
			$this->s_meta_type = 'home';
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
    public function fconnect($access_token)
    {
        $qry = urlencode("SELECT first_name, last_name, email FROM user WHERE uid = me()");
        $content = @json_decode(get_url_fb('https://graph.facebook.com/fql?q='.$qry.'&access_token='.$access_token));
        //print_r($content);
        
        //$content->data[0]->email
        //$content->data[0]->first_name
        //$content->data[0]->last_name
        $info_login['s_email']  =   $content->data[0]->email ;
        $this->load->model("User_login","mod_ul");   
        $ret_   =   $this->mod_ul->front_login($info_login,true); // second parameter true for face book login..
        if($ret_=='account_disable')
        {
            
            $this->session->set_userdata(array('message'=>$this->cls_msg["err_account_disable"],'message_type'=>'err'));
            redirect(base_url()."user/login");
        }
        else if($ret_) 
        {
            redirect(base_url().'account/dashboard');
        }
        else
        {
            $info   =   array();
            $info["s_first_name"]       =    $content->data[0]->first_name ;  
            $info["s_last_name"]        =    $content->data[0]->last_name ;  
            $info["s_email"]            =    $content->data[0]->email ;  
            $info["s_verification_code"]=    $this->mod_user->genVerificationCode(); 
            $info["i_status"]           =    1 ;               
            $info["dt_created_on"]      =    time() ;
            
            $i_aff  =   $this->mod_ul->create_an_account_by_fconnect($info); 
            if($i_aff)
            {
                $ret_   =   $this->mod_ul->front_login($info_login,true); // second parameter true for face book login.. 
                redirect(base_url().'account/dashboard');
            }
            
             
        }
        
        
    }
	
	public function login()
    {
        try
        {					
			$this->data['breadcrumb'] = array('Login'=>'');
			$this->s_meta_type = 'login';
			$this->i_footer_menu = 10;
            if($_POST)
            {
                $posted     =   array();
                $posted["txt_email"]    =   $this->input->post("txt_email");
                $posted["txt_password"] =   $this->input->post("txt_password");
                
                $this->form_validation->set_rules('txt_email','your email address', 'valid_email|required|trim');
                $this->form_validation->set_rules('txt_password','password', 'required|trim');
                
                if($this->form_validation->run() == FALSE) // validation false (error occur)
                {
                    $this->data["posted"]   =   $posted ;
                }
                else
                {
                    $info["s_email"]    =   $posted["txt_email"]   ;
                    $info["s_password"] =   $posted["txt_password"]   ;
                    
                    $this->load->model("User_login","mod_ul");   
                    $loggedin = $this->mod_ul->front_login($info);
                    
                    if($loggedin=='account_disable')
                    {
                        $this->session->set_userdata(array('message'=>$this->cls_msg["err_account_disable"],'message_type'=>'err'));
                        redirect(base_url()."user/login");
                        
                    }
                    else if($loggedin)
                    {
                        $this->session->set_userdata(array('message'=>$this->cls_msg["success_login"],'message_type'=>'succ'));
                        redirect(base_url()."dashboard");
                        
                    }
                    else
                    {
                        $this->session->set_userdata(array('message'=>$this->cls_msg["invalid_login"],'message_type'=>'err'));
                        redirect(base_url()."user/login");
                    }
                }
                
            }
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	public function registration()
    {
        try
        {				
			$this->data['breadcrumb'] = array('Registration'=>'');	
			$this->s_meta_type = 'registration';
			$this->i_footer_menu = 9;
            
            if($_POST)
            {
                $posted     =   array();
                $posted["txt_first_name"]           =   $this->input->post("txt_first_name") ;
                $posted["txt_last_name"]            =   $this->input->post("txt_last_name") ;
                $posted["txt_email"]                =   $this->input->post("txt_email") ;
                $posted["txt_password"]             =   $this->input->post("txt_password") ;
                $posted["txt_confirm_password"]     =   $this->input->post("txt_confirm_password") ;
                $posted["txt_captcha"]              =   $this->input->post("txt_captcha") ;
                
                $this->form_validation->set_rules('txt_first_name','your first name', 'required|trim');
                $this->form_validation->set_rules('txt_last_name','your last name', 'required|trim');
                $this->form_validation->set_rules('txt_email','your email address', 'valid_email|required|trim|callback__email_exist');
                $this->form_validation->set_rules('txt_password','password', 'required|trim|matches[txt_confirm_password]');
                $this->form_validation->set_rules('txt_confirm_password','confirm password', 'required|trim');
                $this->form_validation->set_rules('txt_captcha','security code', 'required|callback__captcha_valid');
                
                if($this->form_validation->run() == FALSE) // validation false (error occur)
                {
                    $this->data["posted"]   =   $posted ;
                }
                else // no error
                {
                    $info   =   array();
                    $info["s_first_name"]       =    $posted["txt_first_name"] ;  
                    $info["s_last_name"]        =    $posted["txt_last_name"] ;  
                    $info["s_email"]            =    $posted["txt_email"] ;  
                    $info["s_password"]         =    $posted["txt_password"] ; 
                    $info["i_status"]           =    0 ; 
                    $info["dt_created_on"]      =    time() ; 
                    $info["s_verification_code"]=    $this->mod_user->genVerificationCode();
                    
                    $i_new_id   =   $this->mod_user->create_an_account($info);
                    if($i_new_id)
                    {
                        
                   /* for registration verification mail to the user */
                   $this->load->model("auto_mail_model","mod_auto");
                   $content         =   $this->mod_auto->fetch_mail_content('registration_mail');    
                   $filename        =   $this->config->item('EMAILBODYHTML')."common.html";
                   $handle          =   @fopen($filename, "r");
                   $mail_html       =   @fread($handle, filesize($filename));    
                   $s_subject       =   $content['s_subject'];        
                    //print_r($content); exit;    
                                    
                    if(!empty($content))
                    {                    
                        $description = $content["s_content"];
                        
                        $description = str_replace("###NAME###",ucfirst($info['s_first_name']).' '.ucfirst($info['s_last_name']),$description);    
                        $description = str_replace("###EMAIL###",$info['s_email'],$description);        
                        $description = str_replace("###VERIFY_LINK###",base_url().'user/active-account/'.$info["s_verification_code"],$description);                        
                    }
                        
                    $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);    
                    $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);    
                   
                    
                    /// Mailing code...[start]
                    $site_admin_email = $this->s_admin_email;    
                    $this->load->helper('mail');                                        
                    $i_sent = sendMail($info['s_email'],$s_subject,$mail_html);
                        if($i_sent)
                        {
                            $this->session->set_userdata(array('message'=>$this->cls_msg["create_acc_succ"],'message_type'=>'succ'));
                            redirect(base_url()."user/login");
                        }
                        
                        
                    }
                    else
                    {
                        $this->session->set_userdata(array('message'=>$this->cls_msg["create_acc_err"],'message_type'=>'err'));
                        redirect(base_url()."user/registration");
                    }  
                }
            }
            
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	
	/* this function for forgot password 
	*  send an email with a link to change the password.
	*/
	public function forgot_password()
    {
        try
        {				
			$this->data['breadcrumb'] = array('Forgot Password'=>'');	
			$this->s_meta_type = 'forgot_password';            
            if($_POST)
            {
                $posted     =   array();             
                $posted["txt_email"]                =   $this->input->post("enteraddress") ;
                $posted["txt_captcha"]              =   $this->input->post("txt_captcha") ;
                //pr($posted,1);
                $this->form_validation->set_rules('enteraddress','your email address', 'valid_email|required|trim');
                $this->form_validation->set_rules('txt_captcha','security code', 'required|callback__captcha_valid');
                
                if($this->form_validation->run() == FALSE) // validation false (error occur)
                {
                    $this->data["posted"]   =   $posted ;
                }
                else // no error
                {
                    $info   =   array();
                    $info["s_email"]            =    $posted["txt_email"] ;  
                    
                    //$i_new_id   =   true;
					$s_where		=	"WHERE n.s_email='".$info["s_email"]."' ";
					$user_detail 	= $this->mod_user->fetch_multi($s_where,0,1);
                    if($user_detail)
                    {
                         /* for forgot password mail to the user */
                    $this->load->model("auto_mail_model","mod_auto");
                    $content         =   $this->mod_auto->fetch_mail_content('forget_password');    
                    $filename        =   $this->config->item('EMAILBODYHTML')."common.html";
                    $handle          =   @fopen($filename, "r");
                    $mail_html       =   @fread($handle, filesize($filename));    
                    $s_subject       =   $content['s_subject'];        
                    //print_r($content); exit;    
                                    
                    if(!empty($content))
                    {                    
                        $description = $content["s_content"];                        
                        $description = str_replace("###NAME###",ucfirst($user_detail[0]['s_first_name']).' '.ucfirst($user_detail[0]['s_last_name']),$description);    
                        $description = str_replace("###EMAIL###",$info['s_email'],$description);        
                        $description = str_replace("###CHANGE_PASSWORD_LINK###",base_url().'user/change-password/'.encrypt($info["s_email"]),$description);                        
                    }
                        
                    $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);    
                    $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);    
                   
                    //echo $mail_html; exit;
                    /// Mailing code...[start]
                    $site_admin_email = $this->s_admin_email;    
                    $this->load->helper('mail');                                        
                    $i_sent = sendMail($info['s_email'],$s_subject,$mail_html);
					if($i_sent)
					{
						$this->session->set_userdata(array('message'=>$this->cls_msg["forgot_pwd_succ"],'message_type'=>'succ'));
						redirect(base_url()."forgot-password");
					}  
                        
                    }
                    else
                    {
                        $this->session->set_userdata(array('message'=>$this->cls_msg["forgot_pwd_err"],'message_type'=>'err'));
                        redirect(base_url()."forgot-password");
                    }  
                }
            }
            
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/* this function change password after click on 
	* the email send through forgot password 
	* $author Mrinmoy
	*/
	public function change_password()
    {
        try
        {					
			$this->data['breadcrumb'] = array('Change Password'=>'');
			$this->s_meta_type = 'change_password';
			$this->data['s_email']	=	$this->uri->segment(3);
            if($_POST)
            {
                $posted=array();
				$posted["txt_new_password"]		= trim($this->input->post("txt_new_password"));
				$posted["txt_confirm_password"]	= trim($this->input->post("txt_confirm_password"));
				
				if(!empty($posted["txt_new_password"]) || !empty($posted["txt_confirm_password"]))
				{
					$this->form_validation->set_rules('txt_new_password', 'New password', 'required');
					$this->form_validation->set_rules('txt_confirm_password', 'Confirm password', 'required|matches[txt_new_password]');
				}
                
                if($this->form_validation->run() == FALSE) // validation false (error occur)
                {
                    $this->data["posted"]   =   $posted ;
                }
                else
                {
                    
                    $info=array();
					if(!empty($posted["txt_new_password"]) && !empty($posted["txt_confirm_password"]))
					{
						$info["s_password"]	=$posted["txt_new_password"];
					}
					$s_email	=	decrypt($this->data['s_email']);
                    
                    $i_newid = $this->mod_user->set_new_password($info,$s_email);
					if($i_newid)////saved successfully
					{
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_pwd"],'message_type'=>'succ'));	
						redirect(base_url().'user/change-password/'.$this->data['s_email']);
					}
					else///Not saved, show the form again
					{
						$this->session->set_userdata(array('message'=>$this->cls_msg["save_pwd_err"],'message_type'=>'err'));
						$this->render('user/change-password/'.$this->data['s_email']);
					}
                }
                
            }
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/*==================== end change password date: 09-07-2012 =====================*/
	
	
	/* this function shows the profile details 
	*  for public pages
	* @param $i_id 
	*/
	public function profile($i_id,$s_user_name='')
    {
        try
        {					
			$this->s_meta_type = 'profile';
			$user_id	=	decrypt($i_id);
			if($user_id)
			{
				$this->data["user"]	  =	$this->mod_user->fetch_user_profile($user_id);
			}
			//pr($this->data["user"],1);
			$s_where	=	" WHERE p.i_owner_user_id = ".$user_id." ";
			$this->data["properties"] =	$this->mod_property->fetch_random_property_and_images($s_where,0,4);			
			/* checking that loggedin user have any paid booking on this property */ 
			//$this->data["all_properties"] =	$this->mod_property->fetch_random_property_and_images($s_where);
			$this->data["all_properties"] =	$this->mod_property->fetch_multi($s_where);
			//pr($this->data["all_properties"]);
			/*=================================  START ================================================*/
			// if the user is owner then also can see contact details
			$login_user_id = decrypt($this->data['loggedin']["user_id"]);	
			
			if($login_user_id!='')	
			{	
			$arr_booking	= array();
			if(count($this->data["all_properties"])>0)
			{
				$i  =   0;
				foreach($this->data["all_properties"] as $key=>$val)
					{
						$s_where = " WHERE b.i_property_id = ".$val["id"]." AND b.i_traveler_user_id = ".$login_user_id." AND b.e_status = 'Amount paid' ";
						$arr_booking[$key]["booking"] = $this->mod_property->fetch_booking_list($s_where);
						$i++;
					}
					
			}
			
			$this->data["arr_booking"] =	$arr_booking;
			//pr($arr_booking,1);
		
			$paid_flag = 0;
			foreach($arr_booking as $k=>$v)
			{ 
				if(!empty($v))
				{
					foreach($v as $k=>$value)
					{
						foreach($value as $vall)
						{
							
							if(strtotime('-1 day',strtotime($vall["dt_booked_to"]))>=time())
							{
								 $paid_flag = 1;
								 $this->data["paid_flag"] = $paid_flag;
								 break;
							}
						}	
						
					}
				}
			}
			
			//$this->data["paid_flag"] = $paid_flag;
			}
			// end if the user is owner then lso can see contact details
			
			// if the user is traveler then lso can see contact details
			$arr_booking1	= array();
			if(count($this->data["all_properties"])>0)
			{
				$i  =   0;
				foreach($this->data["all_properties"] as $key=>$val)
					{
						$s_where = " WHERE b.i_property_id = ".$val["id"]." AND b.i_traveler_user_id = ".$user_id." AND b.e_status = 'Amount paid' ";
						$arr_booking1[$key]["booking"] = $this->mod_property->fetch_booking_list($s_where);
						$i++;
					}
			}
			$this->data["arr_booking1"] =	$arr_booking1;
			//pr($this->data["arr_booking"],1);
			$paid_flag1 = 0;
			foreach($arr_booking1 as $k=>$v)
			{
				if(!empty($v))
				{
					foreach($v as $val)
					{
						foreach($val as $key=>$val2)
						{
							if(strtotime('-1 day',strtotime($val2["dt_booked_to"]))>=time())
							{
								 $paid_flag1 = 1;
								 $this->data["paid_flag1"] = $paid_flag1;
								 break;
							}	
						}	
						
					}
				}	
			}
			
			// if the user is traveler then lso can see contact details
			/* end checking that loggedin user have any paid booking on this property */
			/*=================================  END ================================================*/
			/* below code is for checking verified host 
			* when the user have minimum three reviews with rating greater 5 
			*/
			$s_table_name	= $this->db->REVIEWSRATING;
			$s_where = "WHERE i_property_owner_id = ".$user_id." AND i_rating = 5 ";
			$i_total_positive_rating = $this->mod_common->common_count_rows($s_table_name,$s_where);
			$this->data["i_total_positive_rating"] = $i_total_positive_rating;
							
			$this->render();
			unset($arr_booking,$s_where,$s_table_name,$i_total_positive_rating);
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
    
    /**
    * This is a callback function for ci form validation for chcking email existance
    * if email exist it return false for showing error
    * 
    * @param mixed $s_email
    */
    function _email_exist($s_email)
    {
        if($s_email!='')
        {
            $s_where    =   " WHERE n.s_email = '".$s_email."'" ;
            $i_cnt      =   $this->mod_user->gettotal_info($s_where);
            if($i_cnt>0)
            {
                $this->form_validation->set_message('_email_exist', 'This %s already exist.');
                return false;
            }
            else
            {
                return true;
            }
            
        }
        else
        {
            return true;
        }
    }
    
    /**
    * This is a callback private function for ci form validation
    * check captcha correct or not
    * 
    * @param mixed $s_captcha
    */
    function _captcha_valid($s_captcha)
    {
        if($s_captcha!=$this->session->userdata('captcha'))
        {
             $this->form_validation->set_message('_captcha_valid', 'Please provide correct %s.');
             
             unset($s_captcha);
             return false;
        }
        else
        {
            return true;
        }
    }
	
    
    /** 
    * This function call for sign out 
    * the session loggedin will destroy
    * 
    */
	public function logout()
    {
        try
        {
            $this->session->set_userdata(array("loggedin"=> ''));
            redirect(base_url().'home');            
            
        }
        
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }              
    
    }
    
    /**
    * This function use to active account when a user click in email link  for first time
    *  It is done by unique verification code
    * 
    * @param mixed $s_verification_code
    */
    public function active_account($s_verification_code='')
    {
        try
        {
            if($s_verification_code!='')
            {
                $i_aff  =   $this->mod_user->active_account(trim($s_verification_code));
                
                if($i_aff)
                {
                    $this->session->set_userdata(array('message'=>$this->cls_msg["accout_activated_succ"],'message_type'=>'succ'));
                    redirect(base_url()."user/login");  
                }
                else
                {
                    $this->session->set_userdata(array('message'=>$this->cls_msg["accout_activated_err"],'message_type'=>'err'));
                    redirect(base_url()."user/login");
                }
            }
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
  
	
    public function __destruct()

    {}           

}



/* End of file welcome.php */

/* Location: ./system/application/controllers/welcome.php */

