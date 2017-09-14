<?php
/*********
* Author: Koushik Rout
* Date  : 03 July 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
* Controller For Site Setting
* 
* @package Content Management
* @subpackage site_setting
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/site_setting_model.php
* @link views/admin/site_setting/
*/

class Site_setting extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
   
	
    public function __construct()
    {
            
        try
        {
          parent::__construct();
          ////////Define Errors Here//////
          $this->data['title']="Admin Site Setting";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	=	"No information found about admin site setting.";
          $this->cls_msg["save_err"]	=	"Admin site setting failed to save.";
          $this->cls_msg["save_succ"]	=	"Admin site setting saved successfully.";
          $this->cls_msg["delete_err"]	=	"Admin site setting failed to remove.";
          $this->cls_msg["delete_succ"]	=	"Admin site setting removed successfully.";
          ////////end Define Errors Here//////
		  $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
          $this->load->model("site_setting_model","mod_rect");
		  //////// end loading default model here //////////////
		  
		 
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
            $this->data['title']	=	"Admin Site Setting";////Browser Title
            $this->data['heading']	=	"Admin Site Setting";
			
            //In case of site setting there no list tpl admin can only edit the data .
            //so modify information function call directly
			$this->modify_information();
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
            $this->data['pathtoclass']	=	$this->pathtoclass;
            $this->data['mode']			=	"edit";
            $this->data['heading']		=	"Admin Site Setting";
            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
				$posted["h_id"] 					= 	trim($this->input->post("h_id"));
                $posted["txt_admin_email"]          =   trim($this->input->post("txt_admin_email"));
				$posted["txt_paypal_email"]			= 	trim($this->input->post("txt_paypal_email"));
                $posted["txt_facebook_address"]     =   trim($this->input->post("txt_facebook_address"));
                $posted["txt_twitter_address"]      =   trim($this->input->post("txt_twitter_address"));
                $posted["txt_linkedin_address"]     =   trim($this->input->post("txt_linkedin_address"));
				$posted["txt_google_plus_address"]	=   trim($this->input->post("txt_google_plus_address"));
				$posted["txt_youtube_address"]     	=   trim($this->input->post("txt_youtube_address"));
				
				$posted["txt_sms_gateway_key"]		= 	trim($this->input->post("txt_sms_gateway_key"));
                $posted["txt_google_map_key"]       =   trim($this->input->post("txt_google_map_key")); 
				$posted["txt_google_map_key_gmap3"] =   trim($this->input->post("txt_google_map_key_gmap3"));
				$posted["d_service_charge"]       	=   trim($this->input->post("d_service_charge"));
				$posted["d_commission_charge"]      =   trim($this->input->post("d_commission_charge")); 
				$posted["s_youtube_snippet"]      	=   $this->input->post("s_youtube_snippet");
                $posted["txt_smtp_host"]            =   trim($this->input->post("txt_smtp_host"));
                $posted["txt_smtp_password"]        =     trim($this->input->post("txt_smtp_password"));
                $posted["txt_smtp_userid"]          =   trim($this->input->post("txt_smtp_userid")); 
                
               
                $this->form_validation->set_rules('txt_admin_email', 'admin email', 'required');
                $this->form_validation->set_rules('txt_paypal_email', 'paypal email', 'required');
                $this->form_validation->set_rules('txt_facebook_address', 'Facebook address', 'required');
                $this->form_validation->set_rules('txt_twitter_address', 'Twitter address', 'required');
                $this->form_validation->set_rules('txt_linkedin_address', 'Linkedin address', 'required');
				$this->form_validation->set_rules('txt_google_plus_address', 'Google+ address', 'required');
				$this->form_validation->set_rules('txt_youtube_address', 'youtube address', 'required');
                //$this->form_validation->set_rules('txt_sms_gateway_key', 'Sms gateway key', 'required');
				$this->form_validation->set_rules('txt_google_map_key', 'Google map key', 'required');
				$this->form_validation->set_rules('txt_google_map_key_gmap3', 'Google map key version 3', 'required');
				$this->form_validation->set_rules('d_service_charge', 'service charge percentage', 'required');
				$this->form_validation->set_rules('d_commission_charge', 'site commission percentage', 'required');
                $this->form_validation->set_rules('s_youtube_snippet', 'youtube snippet', 'required');
                $this->form_validation->set_rules('txt_smtp_host', 'smtp host', 'required');
                $this->form_validation->set_rules('txt_smtp_password', 'smtp password', 'required');
				$this->form_validation->set_rules('txt_smtp_userid', 'smtp user id', 'required');
				
				$info	=	array();
				
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
					$info["s_admin_email"]					=	$posted["txt_admin_email"];
					$info["s_paypal_email"]					=	$posted["txt_paypal_email"];
                    $info["s_facebook_address"]     		=   $posted["txt_facebook_address"];
                    $info["s_twitter_address"]      		=   $posted["txt_twitter_address"];
                    $info["s_linkedin_address"]     		=   $posted["txt_linkedin_address"];
					$info["s_google_plus_address"]     		=   $posted["txt_google_plus_address"];
					$info["s_youtube_address"]     			=   $posted["txt_youtube_address"];
					
					$info["s_sms_gateway_key"]				=	$posted["txt_sms_gateway_key"];
					$info["s_google_map_key"]       		=   $posted["txt_google_map_key"];
					$info["s_google_map_key_gmap3"]       	=   $posted["txt_google_map_key_gmap3"];
					$info["d_service_charge_percentage"]    =   $posted["d_service_charge"];
					$info["d_site_comission_percentage"]    =   $posted["d_commission_charge"];
					$info["s_youtube_snippet_for_how_it_works"]    =   $posted["s_youtube_snippet"];
                    $info["s_smtp_host"]                    =   $posted["txt_smtp_host"];
                    $info["s_smtp_password"]                =   $posted["txt_smtp_password"];
                    $info["s_smtp_userid"]                  =   $posted["txt_smtp_userid"];
                    
                    $i_aff = $this->mod_rect->edit_info($info,decrypt($posted['h_id']));
					
                    if($i_aff)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."modify_information");
                    }
                    else///Not saved, show the form again
                    {
                        $this->data["posted"]=$posted;
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    unset($info,$posted);
                    
                }
            }
            else
            {
               
				$info=$this->mod_rect->fetch_this("NULL");  // This method id modified by Jagannath Samanta on 24 June 2011
				
                $posted=array();
				
				$posted["i_id"]						= 	$info["i_id"];
				$posted["txt_admin_email"]			= 	$info["s_admin_email"];
				$posted["txt_paypal_email"]			= 	$info["s_paypal_email"];
                $posted["txt_facebook_address"]     =   $info["s_facebook_address"];
                $posted["txt_twitter_address"]      =   $info["s_twitter_address"];
                $posted["txt_linkedin_address"]     =   $info["s_linkedin_address"];
				$posted["txt_google_plus_address"]	=   $info["s_google_plus_address"];
				$posted["txt_youtube_address"]     	=   $info["s_youtube_address"];
				
                $posted["txt_sms_gateway_key"]      =   $info["s_sms_gateway_key"];
                $posted["txt_google_map_key"]       =   $info["s_google_map_key"];
				$posted["txt_google_map_key_gmap3"] =   $info["s_google_map_key_gmap3"];
				$posted["d_service_charge"]       	=   $info["d_service_charge_percentage"];
				$posted["d_commission_charge"]      =   $info["d_site_comission_percentage"];
				$posted["s_youtube_snippet"]      	=   $info["s_youtube_snippet_for_how_it_works"];
                $posted["txt_smtp_host"]            =   $info["s_smtp_host"];
                $posted["txt_smtp_password"]        =   $info["s_smtp_password"];
                $posted["txt_smtp_userid"]          =   $info["s_smtp_userid"];

				$posted["h_id"]						= 	trim(encrypt($info["i_id"]));
				
                $this->data["posted"]				=	$posted;       
                unset($info,$posted);      
                
            }
		  	$this->render('site_setting/site_setting');
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