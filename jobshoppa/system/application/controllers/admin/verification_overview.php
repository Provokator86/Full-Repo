<?php
/*********
* Author: Samarendu Ghosh
* Date  : 31 Oct 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For user
* 
* @package Content Management
* @subpackage user
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/user_model.php
* @link views/admin/user/
*/


class Verification_overview extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public $uploaddir;
    public $thumbdir;
    public $showimgdir;

    public function __construct()
    {            
        try
        {
          parent::__construct();
          $this->data['title']="Job Overview";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]="No information found about buyers.";
          $this->cls_msg["save_err"]="Information about buyers failed to save.";
          $this->cls_msg["save_succ"]="Information about buyers saved successfully.";
          $this->cls_msg["delete_err"]="Information about buyers failed to remove.";
          $this->cls_msg["delete_succ"]="Information about buyers removed successfully.";
		  $this->cls_msg["send_err"]="Message not delivered.";
          $this->cls_msg["send_succ"]="Message delivered successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("manage_tradesman_model","mod_rect");
		  //////// end loading default model here //////////////
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }

    public function index($s_id)
    {
        try
        {
			//echo decrypt($s_id);
			
		//	$this->session->set_userdata("i_buyer_id",decrypt($s_id));
			$this->session->set_userdata("i_verify_id",decrypt($s_id));
		
            redirect($this->pathtoclass."show_detail");
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
    public function show_detail($i_id = 0)
    {
        try
        {
			//echo $this->session->userdata("i_buyer_id");
            	$i_id = $this->session->userdata('i_verify_id');
			
                $info=$this->mod_rect->fetch_this_verification($i_id);
				
				//pr( $info);
                if(!empty($info))
                {
					
                    $temp=array();
                    $temp["s_id"]			= 	encrypt($info["id"]);////Index 0 must be the encrypted PK 
					
					$temp["s_username"]				=	trim($info["s_username"]);
					$temp["s_name"]					=	trim($info["s_name"]);	
					$temp["s_email"]				=	trim($info["s_email"]);	
					$temp["s_name"]					=	trim($info["s_name"]);								
					$temp["s_contact_no"]			=	trim($info["s_contact_no"]);
					
					$temp["s_verify_status"]		=	trim($info["s_verify_status"]);
					$temp["s_verify_type"]			=	trim($info["s_verify_type"]);
					$temp["dt_created_on"]			=	trim($info["dt_created_on"]);
					$temp["cred_files"]				= 	$info[0]["cred_files"];
					
					$this->data['cred_file_path'] = $this->config->item("user_profile_image_thumb_path");
					$this->data['cred_file_up_path'] = $this->config->item("user_profile_image_thumb_upload_path");
					
					$this->data["info"]=$temp;
                    unset($temp);
                }
                unset($info);
            
           
            
            $this->render("verification_overview/show_detail");
            unset($i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	
	function download_cred_files($s_file_name)
	{
		try
		{
			$this->load->helper('download');
			$data = $this->config->item('credentials_file_upload_path'); // Read the file's contents
			$name = decrypt($s_file_name);			
			$fullpath = file_get_contents($data.$name);
			//echo $fullpath;
			force_download($name, $fullpath); 			
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	}
   
	
	
	
	public function __destruct()
    {}
	
	
}
?>