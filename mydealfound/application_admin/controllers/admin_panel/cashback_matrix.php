<?php
/*********
* Author: Author
* Date  : 27 June 2014
* Modified By: 
* Modified Date: 
* Purpose:
*  Controller For Cashback Matrix
* @package Coupon & Deals
* @subpackage Manage Cashback Matrix 
* @link InfController.php 
* @link My_Controller.php
* @link model/cashback_model.php
* @link views/admin/cashback_matrix/
*/



class Cashback_matrix extends My_Controller implements InfController

{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
	{
		try
		{
			parent::__construct();
			$this->data['title']			=	"Cashback Matrix Management";////Browser Title
			////////Define Errors Here//////
			$this->cls_msg = array();
			$this->cls_msg["no_result"]		=	"No information found about cashback matrix.";
			$this->cls_msg["save_err"]		=	"Information about cashback matrix failed to save.";
			$this->cls_msg["save_succ"]		=	"Information about cashback matrix saved successfully.";
			$this->cls_msg["delete_err"]	=	"Information about cashback matrix failed to remove.";
			$this->cls_msg["delete_succ"]	=	"Information about cashback matrix removed successfully.";
			////////end Define Errors Here//////
			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
			//////// loading default model here //////////////
			$this->load->model("cashback_model","mod_rect");
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
			redirect($this->pathtoclass."add_information");
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
    public function show_list($start=NULL,$limit=NULL)
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
    * On Success redirect to the showList interface else display error here.
    */
    public function add_information()   
    {
		try
        {
            $this->data['title']="Add cashback matrix";////Browser Title
            $this->data['heading']="Add cashback matrix";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="add";
			
			
            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
				$posted	=	$this->input->post();
				//pr($posted,1);				

                $this->form_validation->set_rules('h_mode', 'add mode', 'required');				
				
                if($this->form_validation->run() == FALSE )/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    if(!empty($posted["i_cat_id"]))
					{
						foreach($posted["i_cat_id"] as $k=>$v)
						{
							$info = array();
							$info["i_cat_id"] 	= $v;
							$info["0-499"] 		= $posted['0_499'][$k];
							$info["500-999"] 	= $posted['500_999'][$k];
							$info["1000-1499"] 	= $posted['1000_1499'][$k];
							$info["1500-1999"] 	= $posted['1500_1999'][$k];
							$info["2000+"] 		= $posted['2000'][$k];
							
							$cond = array('i_cat_id'=>$v);
							$i_aff=$this->mod_rect->update_matrix_data($info,$cond);
							//$this->mod_rect->update_product_cashback_txt($v,$info);							
							if($i_aff)
							{
								$this->mod_rect->update_product_cashback_txt($v,$info);
							}
							
						}
					}

                    set_success_msg($this->cls_msg["save_succ"]);
					redirect($this->pathtoclass."add_information");
                    unset($info,$posted);

                }
            }
            else
            {
				$i_chk = insert_matrix_wrt_category(); // first insert record for new category see@common_helper
				
				$info=$this->mod_rect->fetch_categorywise_cashback_matrix();				
                $posted=array();				
                $this->data["info"]=$info;  
				//pr($info); 
                unset($info,$posted);     
            }
            ////////////end Submitted Form///////////
            $this->render("cashback_matrix/add-edit");
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
    * On Success redirect to the showList interface else display error here. 
    * @param int $i_id, id of the record to be modified.
    */  
    public function modify_information($i_id=0)
    {   
        try
        {
            $this->data['title']="Edit cashback matrix";////Browser Title
            $this->data['heading']="Edit cashback matrix";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";
            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
				$posted["opt_title"]				=	trim($this->input->post("opt_title"));
				$posted["opt_language"]				=	trim($this->input->post("opt_language"));	
                $posted["txt_content_title"]		= 	trim($this->input->post("txt_content_title"));
                $posted["txt_content_description"]	= 	trim($this->input->post("txt_content_description"));	
                $posted["h_id"]						=   trim($this->input->post("h_id"));
				$posted["h_mode"]					= 	$this->data['mode'];				

                $this->form_validation->set_rules('txt_content_description', 'content description', 'required');				

             	$info	=	array();	 

                if($this->form_validation->run() == FALSE )/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info["i_cms_type_id"]			=	$posted["opt_title"];
					$info["i_lang_id"]				=	$posted["opt_language"];
					$info["s_title"]				=	$posted["txt_content_title"];
                    $info["s_description"]			=	$posted["txt_content_description"];		
                    $info["i_status"]				=	$posted["i_content_is_active"];
                    $info["i_type"]					=	$posted["i_content_type"];
                    $info["dt_entry_date"]			=	strtotime(date("Y-m-d H:i:s"));

                    $i_aff=$this->mod_rect->edit_info($info,decrypt($posted["h_id"]));
                    if($i_aff)////saved successfully
                    {
                        //$this->session->set_userdata('success_msg', $this->cls_msg["save_succ"]);
                        set_success_msg($this->cls_msg["save_succ"]);
                        if($this->i_content_type==1)////for page content type
						{
							redirect($this->pathtoclass."modify_information");
						}
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
                $info=$this->mod_rect->fetch_this(decrypt($i_id));
                $posted=array();
				$posted["txt_name"]= trim($info["s_name"]);
				$posted["txt_content_title"]= trim($info["s_title"]);
				$posted["txt_content_description"]= trim($info["s_description"]);
				$posted["dt_created_on"]= trim($info["dt_created_on"]);
				$posted["h_content_type"]= $info["i_cms_type_id"];
				$posted["h_id"]= $i_id;
				$posted["i_id"]= decrypt($i_id);
                $this->data["posted"]=$posted;   
                unset($info,$posted);     
            }
            ////////////end Submitted Form///////////
            $this->render("cashback_matrix/add-edit");
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
    * On Success redirect to the showList interface else display error in showList interface. 
    * @param int $i_id, id of the record to be modified.
    */      
    public function remove_information($i_id=0)
    {} 
    /***
    * Shows details of a single record.
    * @param int $i_id, Primary key
    */
    public function show_detail($i_id=0)
    {}
	
	public function __destruct()

    {}           

}

?>