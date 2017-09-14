<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 02 May 2012
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


class Tradesman_profile_view extends My_Controller implements InfController
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
          $this->data['title']="Tradesman Profile";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]="No information found about Tradesman.";
          $this->cls_msg["save_err"]="Information about Tradesman failed to save.";
          $this->cls_msg["save_succ"]="Information about Tradesman saved successfully.";
          $this->cls_msg["delete_err"]="Information about Tradesman failed to remove.";
          $this->cls_msg["delete_succ"]="Information about Tradesman removed successfully.";
		  $this->cls_msg["send_err"]="Message not delivered.";
          $this->cls_msg["send_succ"]="Message delivered successfully.";
          ////////end Define Errors Here//////
           $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          //$this->load->model("manage_tradesman_model","mod_rect");
		  $this->load->model("tradesman_model","mod_td");
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
			
			$this->session->set_userdata("i_tradesman_id",decrypt($s_id));
		
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
		//	echo $this->session->userdata("i_tradesman_id");
			
            	$i_id = $this->session->userdata('i_tradesman_id');
			
                //$info=$this->mod_rect->fetch_this($i_id);
				$info=$this->mod_td->fetch_tradesman_details($i_id);
				//pr($info,1);
				/* Job list*/
				$this->load->model("job_model",'mod_job');
				$s_where = " WHERE n.i_is_deleted = 0 AND i_tradesman_id = ".$i_id." ";
				$ordername=" n.i_status, n.i_created_date";
				$orderby ="DESC";
				$this->data['job_list'] = $this->mod_job->fetch_multi_sorted_list($s_where,$ordername,$orderby);
				unset($s_where,$ordername,$orderby);
				
				/* Feedback list*/
				$this->load->model("manage_feedback_model");
				$s_where = " WHERE n.i_status = 1 AND i_receiver_user_id = ".$i_id." ";
				$ordername=" n.i_status, n.i_created_date";
				$orderby ="DESC";
				$this->data['feedback_list'] = $this->manage_feedback_model->fetch_multi_sorted_list($s_where,$ordername,$orderby);
				//pr($this->data['feedback_list']);
				unset($s_where,$ordername,$orderby);
				
				/* Referral list */
				$this->load->model("recommend_model");
				$s_wh_recommend = " WHERE n.i_referrer_id = $i_id ";
				$ordername=" n.i_created_date";
				$orderby ="DESC";
				$this->data['rec_list']	=	$this->recommend_model->fetch_multi_sorted_list($s_wh_recommend,$ordername,$orderby);
				unset($s_wh_recommend,$ordername,$orderby);
				//pr($info);
                if(!empty($info))
                {
					
                    $temp=array();
                    $temp["s_id"]							= 	encrypt($info["id"]);////Index 0 must be the encrypted PK 
					$temp["s_username"]						= 	trim($info["s_username"]);
					$temp["s_name"]							= 	trim($info["s_name"]);
					$temp["s_email"]						=	trim($info["s_email"]);
					$temp["s_profile_pic"]					= 	$info['s_image'];
					//$temp["s_user_image"]					= 	$info['s_user_image'];
					//$temp["s_skype_id"]						=	trim($info["s_skype_id"]);
					$temp["i_sm"]							=	trim($info["i_sm"]);
					$temp["s_type_sm"]						=	trim($info["s_type_sm"]);
					$temp["s_sm"]							=	trim($info["s_sm"]);
					
                    $temp["s_keyword"]      				=    trim($info["s_keyword"]);
                    $temp["s_about_me"]     				=    trim($info["s_about_me"]);
                    $temp["s_gsm_no"]        				=    trim($info["s_gsm_no"]);
                    $temp["s_taxoffice_name"]				=    trim($info["s_taxoffice_name"]);
                    $temp["s_tax_no"]        				=    trim($info["s_tax_no"]);
					$temp["i_trade_type"]		    		=	 intval($info["i_type"]);
					$temp["s_type"]		    				=	(intval($info["i_type"])==1)?'Freelancer':'Firm';
                    $temp_array             				=   array(1=>'Outside city',2=>'Inside city',3=>'Both Inside and Outside city');
                    $temp["s_work_place"]   				=   $temp_array[intval($info["i_work_place"])];
					$temp["s_contact_no"]					=	trim($info["s_gsm_no"]);
					$temp["s_city"]							=	trim($info["s_city"]);
					$temp["s_state"]						=	trim($info["s_province"]);
					$temp["s_zip"]							=	trim($info["s_postal_code"]);
					$temp["s_address"]						=	trim($info["s_address"]);
					$temp["s_address2"]						=	trim($info["s_address2"]);
					$temp["s_address_file"]					=	trim($info["s_address_file"]);
					$temp["s_address_file_path"]			=	$this->config->item('tradesman_address_proof_upload_path');
					
					
					$temp["category"]						=	$info['category'];
					$temp["workplace"]						=	$info['workplace'];
					$temp["payment_unit"]					=	$info['payment_unit'];
					
					$temp["s_is_active"]					= 	trim($info["s_is_active"]);
					$temp["dt_created_on"]					= 	trim($info["dt_created_on"]);
					$temp["i_jobs_won"]						= 	trim($info["i_jobs_won"]);
					
					$this->data['image_path'] 		= $this->config->item("user_profile_image_thumb_path");
					$this->data['image_up_path'] 	= $this->config->item("user_profile_image_thumb_upload_path");
					
					$this->data["info"]=$temp;
					//pr($this->data["info"],1);
                    unset($temp);
                }
                unset($info);
            
           
            
            $this->render("tradesman_profile_view/show_detail");
            unset($i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
   
	/* Download job file*/
	function download_address($s_file_name)
	{
		try
		{
			$this->load->helper('download');
			$data = $this->config->item('tradesman_address_proof_upload_path'); // Read the file's contents
			$name = decrypt($s_file_name);	
			$fullpath = @file_get_contents($data.$name);
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