<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 03 April 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For quote overview
* 
* @package Content Management
* @subpackage user
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/user_model.php
* @link views/admin/user/
*/


class Quote_overview extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
   

    public function __construct()
    {            
        try
        {
          parent::__construct();
          $this->data['title']="Quote Overview";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	=	"No information found about buyers.";
          $this->cls_msg["save_err"]	=	"Information about buyers failed to save.";
          $this->cls_msg["save_succ"]	=	"Information about buyers saved successfully.";
          $this->cls_msg["delete_err"]	=	"Information about buyers failed to remove.";
          $this->cls_msg["delete_succ"]	=	"Information about buyers removed successfully.";
		  $this->cls_msg["send_err"]	=	"Message not delivered.";
          $this->cls_msg["send_succ"]	=	"Message delivered successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
         $this->load->model("job_model","mod_rect");
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
			$this->session->set_userdata("i_buyer_id",decrypt($s_id));
		
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
    {
        try
        {}
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
            	$i_id = $this->session->userdata('i_buyer_id');			
                $info=$this->mod_rect->fetch_this($i_id);
				//pr($info,1);
				/* Job list*/
				$this->load->model("job_model");
				$s_where = " WHERE i_job_id = $i_id";				
				$this->data['quote_list'] = $this->job_model->fetch_quote_multi($s_where);
				//pr($this->data['quote_list'],1);
				unset($s_where);
				$s_whe = " WHERE n.i_job_id=".$i_id." ";
					
				$this->data['history_details'] = $this->job_model->fetch_job_history($s_whe);
				
				
				/* Feedback list*/
				$this->load->model("manage_feedback_model");
				$s_where = " WHERE n.i_status = 1 AND n.i_job_id = $i_id";
				$ordername=" n.i_status, n.i_created_date";
				$orderby ="DESC";
				$this->data['feedback_list'] = $this->manage_feedback_model->fetch_multi_sorted_list($s_where,$ordername,$orderby);
				unset($s_where,$ordername,$orderby);
				
				//pr( $info);
                if(!empty($info))
                {
					
                    $temp=array();
                    $temp["s_id"]			= 	encrypt($info["id"]);////Index 0 must be the encrypted PK 
					$temp["s_title"]				=	trim($info["s_title"]);
					$temp["s_description"]			=	trim($info["s_description"]);
					$temp["s_buyer_name"]			=	trim($info["s_buyer_name"]);				
					$temp["s_contact_no"]			=	trim($info["s_contact_no"]);
					
					$temp["opt_state"]				=	trim($info["opt_state"]);
					$temp["opt_city"]				=	trim($info["opt_city"]);
					$temp["opt_zip"]				=	trim($info["opt_zip"]);	
					
					$temp["s_category_name"]		=	trim($info["s_category"]);
					$temp["s_lat"]			=	trim($info["s_lat"]);
					$temp["s_lng"]			=	trim($info["s_lng"]);
					$temp["s_city"]			=	trim($info["s_city"]);
					$temp["s_state"]		=	trim($info["s_state"]);
					$temp["s_zip"]			=	trim($info["s_postal_code"]);

					$temp["d_budget_price"]			=	trim($info["d_budget_price"]);
					$temp["i_quoting_period_days"]	=	trim($info["i_quoting_period_days"]);
					$temp["s_keyword"]				=	trim($info["s_keyword"]);
					
					$temp["s_supply_material"]		=	trim($info["s_supply_material"]);
					$temp["i_is_active"]			=	trim($info["i_is_active"]);
					$temp["s_is_active"]			= 	trim($info["s_is_active"]);
					$temp["dt_created_on"]			= 	trim($info["dt_entry_date"]);
					$temp["dt_expired_on"]			= 	trim($info["dt_expire_date"]);
					$temp["dt_admin_approval_date"]	= 	date('d.m.Y',trim($info["i_approval_date"]));
					$temp["dt_assigned_date"]		= 	trim($info["dt_assigned_date"]);
					$temp["tradesman_name"]			= 	trim($info["s_tradesman_name"]);
					$temp["job_files"]				= 	$info["job_files"];
					
					$this->data['image_path'] = $this->config->item("user_profile_image_thumb_path");
					$this->data['image_up_path'] = $this->config->item("user_profile_image_thumb_upload_path");
					
					$this->data["info"]=$temp;
                    unset($temp);
                }
                unset($info);
            
           
            
            $this->render("quote_overview/show_detail");
            unset($i_id);
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