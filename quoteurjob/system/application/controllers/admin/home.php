<?php

/*********

* Author: Mrinmoy Mondal

* Date  : 20 Aug 2011

* Modified By: 

* Modified Date:

* 

* Purpose:

*  Common Model formats 

* 

* @link InfController.php 

* @link My_Controller.php

* @link model/user_login.php

* @link views/admin/dashboard/

*/



class Home extends My_Controller implements InfController

{

    public $cls_msg;//////All defined error messages. 

    public $pathtoclass;

    

    public function __construct()
    {
        try
        {
			parent::__construct();
			////////Define Errors Here//////
			$this->cls_msg=array();
			$this->cls_msg["invalid_login"]="Invalid user name or password. Please try again.";
			$this->cls_msg["success_login"]="Successfully logged in.";
			////////end Define Errors Here//////
			$this->pathtoclass=admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
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

                $posted["txt_user_name"]= trim($this->input->post("txt_user_name"));

                $posted["txt_password"]= trim($this->input->post("txt_password"));

                
                $this->form_validation->set_rules('txt_user_name', 'user name', 'required');

                $this->form_validation->set_rules('txt_password', 'password', 'required');

              

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

                    

                    $loggedin=$this->mod_ul->login($info);

										

                    if(!empty($loggedin))   ////saved successfully

                    {

                        //set_success_msg($this->cls_msg["success_login"]);

                        redirect(admin_base_url()."dashboard/");

                    }

                    else///Not saved, show the form again

                    {

                        set_error_msg($this->cls_msg["invalid_login"]);

                        $this->data["posted"]=$posted;

                    }

                    

                }

            }

            ///end Posted login form///

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

            //////////log report///

            $this->load->model("User_login","mod_ul");                    

            $logi["msg"]="Logged out as ".$this->data['loggedin']["user_fullname"]

                        ."[".$this->data['loggedin']["user_name"]."] at ".date("Y-M-d H:i:s") ;

            $this->mod_ul->log_info($logi); 

            unset($logi);  

            //////////end log report///            

            

            $this->session->sess_destroy();             

            

            redirect(admin_base_url());

            

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
            if($this->input->post("h_menu"))
            {
				/////removing the search and session set messages when new page is called////
                $this->session->set_userdata($this->s_search_var,array());
                $array_items = array('success_msg' => '', 'error_msg' => '');
                $this->session->unset_userdata($array_items);
                unset($array_items);                
                /////end removing the search and session set messages ////
                $this->session->set_userdata("s_menu",$this->input->post("h_menu"));
                echo "done";
            }
            else
            {
                echo "not done";
            }
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

          

          ////Put the select statement here

        }

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

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




