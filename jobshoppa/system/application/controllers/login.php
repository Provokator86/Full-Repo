<?php
/*********
* Author: Arnab Chattopadhyay
* Date  : 07 Jan 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Frontend Login, This is Iframed page
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class Login extends My_Controller 
{
    public $cls_msg;			//////All defined error messages. 
    public $pathtoclass;		
    
    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="Login";////Browser Title
		  $this->data['ctrlr'] = "login";
          
          ////////Define Errors Here//////
          $this->cls_msg=array();
		  $this->cls_msg["invalid_login"]="Invalid user name or password. Please try again.";
		  $this->cls_msg["success_login"]="Successfully logged in.";
          ////////end Define Errors Here//////
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  //$this->load->model();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }

    /***
    * Catalogue Product
    * 
    */
    public function index()
    {
        try
        {
			/// this variable denotes that the page will display an Iframe
			//$this->data['b_is_iframe'] = TRUE;
			$this->i_menu_id = 1;
			if($_POST)
			{				

                $posted=array();

                $posted["txt_user_name"]= trim($this->input->post("txt_user_name"));
                $posted["txt_password"]= trim($this->input->post("txt_password"));
                
                $this->form_validation->set_rules('txt_user_name', 'user name', 'required');
                $this->form_validation->set_rules('txt_password', 'password', 'required');

              	//print_r($posted); exit;

                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }

                else///validated, now save into DB
                {

                    $this->load->model("User_login","mod_ul");   

                    $info=array();

                    $info["s_user_name"]=$posted["txt_user_name"];
                    $info["s_password"]=$posted["txt_password"];

                    $loggedin=$this->mod_ul->front_login($info);
					
					//print_r($loggedin); exit;

                    if(!empty($loggedin))   ////saved successfully
                    {
                        //set_success_msg($this->cls_msg["success_login"]);
                        redirect(base_url()."buyer_dashboard/");
                    }

                    else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["invalid_login"]);
                        $this->data["posted"]=$posted;
						redirect($_SERVER['HTTP_REFERER']);
                    }

                }

            
			}
			unset($loggedin);
            //$this->render("index",true);
            $this->render("user/login",true);
            
        }
		
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	 	    
    }    
    
    
    /****
    * Display the static contents For this controller
    * 
    */
    public function show_cms()
    {
        try
        {
          	/***
			$i_id = $this->config->item('cms_company_id');
		  	$this->data['bread_cum']=" &raquo; Company ";//
			$this->load->model('content_model','mod');
			//$this->data['cms'] = $this->mod->fetch_this($i_id);
			//$this->render('view/fe/company/show_cms');
			return $this->mod->fetch_this($i_id);
          	////Put the select statement her
		  	***/
        }
        catch(Exception $err_obj)
        {
        show_error($err_obj->getMessage());
        }          
    } 
            
    public function __destruct()
    {}           
}


