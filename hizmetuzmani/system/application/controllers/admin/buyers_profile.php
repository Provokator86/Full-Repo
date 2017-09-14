<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 30 March 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For buyers_profile
* 
* @package Content Management
* @subpackage user
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/user_model.php
* @link views/admin/buyers_profile/
*/


class Buyers_profile extends My_Controller implements InfController
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
          $this->data['title']="Buyers User Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	= "No information found about buyers.";
          $this->cls_msg["save_err"]	= "Information about buyers failed to save.";
          $this->cls_msg["save_succ"]	= "Information about buyers saved successfully.";
          $this->cls_msg["delete_err"]	= "Information about buyers failed to remove.";
          $this->cls_msg["delete_succ"]	= "Information about buyers removed successfully.";
		  $this->cls_msg["send_err"]	= "Message not delivered.";
          $this->cls_msg["send_succ"]	= "Message delivered successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("manage_buyers_model","mod_rect");
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
    
    /*** @ author : Mrinmoy
    * Shows details of a single record.
    * @param int $i_id, Primary key
    */
    public function show_detail($i_id = 0)
    {
        try
        {
			
            	$i_id = $this->session->userdata('i_buyer_id');
			
                $info=$this->mod_rect->fetch_this($i_id);
				//pr($info,1);				
				/* to get total job awarded */
				$s_cond = " WHERE n.i_buyer_user_id=".$i_id." And n.i_status>=4 ";
				$this->data['i_total_awarded_job'] = $this->job_model->gettotal_info($s_cond);
				/* Job list*/
				$this->load->model("job_model",'mod_job');
				$s_where = " WHERE n.i_is_deleted = 0 AND i_buyer_user_id = $i_id";
				$ordername=" n.i_status, n.i_created_date";
				$orderby ="DESC";
				$this->data['job_list'] = $this->mod_job->fetch_multi_sorted_list($s_where,$ordername,$orderby);
				unset($s_where,$ordername,$orderby);
				
				/* Feedback list*/
				$this->load->model("manage_feedback_model");
				$s_where = " WHERE n.i_status = 1 AND i_sender_user_id = $i_id";
				$ordername=" n.i_status, n.i_created_date";
				$orderby ="DESC";
				$this->data['feedback_list'] = $this->manage_feedback_model->fetch_multi_sorted_list($s_where,$ordername,$orderby);
				$this->data['i_total_feedback'] = $this->manage_feedback_model->gettotal_info($s_where);
				unset($s_where,$ordername,$orderby);
				
				/* Referral list */
				$this->load->model("recommend_model");
				$s_wh_recommend = " WHERE n.i_referrer_id = $i_id ";
				$ordername=" n.i_created_date";
				$orderby ="DESC";
				$this->data['rec_list']	=	$this->recommend_model->fetch_multi_sorted_list($s_wh_recommend,$ordername,$orderby);
				unset($s_wh_recommend,$ordername,$orderby);
				//pr($this->data['feedback_list']);
                if(!empty($info))
                {
					
                    $temp=array();
                    $temp["s_id"]							= 	encrypt($info["id"]);////Index 0 must be the encrypted PK 
					$temp["s_username"]						= 	trim($info["s_username"]);
					$temp["s_name"]							= 	trim($info["s_name"]);
					$temp["s_email"]						=	trim($info["s_email"]);
					$temp["image"]							= 	trim($info['s_image']);
					
					$temp["i_sm"]							=	$this->db->SOCIALMEDIA[trim($info["i_sm"])];
					$temp["i_sm2"]							=	$this->db->SOCIALMEDIA[trim($info["i_sm2"])];
					$temp["i_sm3"]							=	$this->db->SOCIALMEDIA[trim($info["i_sm3"])];
					$temp["s_sm"]							=	$temp["i_sm"]!=''?trim($info["s_sm"])."(".$temp["i_sm"].")":"";
					$temp["s_sm2"]							=	$temp["i_sm2"]!=''?trim($info["s_sm2"])."(".$temp["i_sm2"].")":"";
					$temp["s_sm3"]							=	$temp["i_sm3"]!=''?trim($info["s_sm3"])."(".$temp["i_sm3"].")":"";
					
					$temp["s_contact_no"]					=	trim($info["s_contact_no"]);
					
					$temp["s_city"]							=	trim($info["s_city"]);
					$temp["s_state"]						=	trim($info["s_province"]);
					$temp["s_zip"]							=	trim($info["s_zip"]);
					$temp["s_address"]						=	trim($info["s_address"]);
					$temp["i_total_job_posted"]				=	trim($info["i_job_post"]);
					$temp["i_total_job_awarded"]			=	trim($info["i_total_job_awarded"]);
					$temp["i_feedback_rating"]				=	trim($info["i_feedback_rating"]);
					$temp["f_positive_feedback_percentage"]	=	trim($info["f_positive_feedback_percentage"]);
					$temp["i_feedback_received"]			=	trim($info["i_feedback_received"]);
					
					$temp["s_is_active"]					= 	trim($info["s_is_active"]);
					$temp["dt_created_on"]					= 	trim($info["dt_created_on"]);
					
					$this->data['image_path'] = $this->config->item("user_profile_image_thumb_path");
					$this->data['image_up_path'] = $this->config->item("user_profile_image_thumb_upload_path");
					
					$this->data["info"]=$temp;
                    unset($temp);
                }
                unset($info);
            
           
            
            $this->render("buyers_profile/show_detail");
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