<?php
/*********
* Author: SWI
* Date  : 11 sept 2017
* Modified By: 
* Modified Date:
* Purpose:
* Controller For Site Setting
* @package Content Management
* @subpackage site_setting
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/site_setting_model.php
* @link views/admin/site_setting/
*/

class Site_setting extends MY_Controller implements InfController
{
    public $cls_msg, $tbl;//All defined error messages. 
    public $pathtoclass;
   
	
    public function __construct()
    {
            
        try
        {
			parent::__construct();
			//Define Errors Here//
			$this->data['title']="Site Setting";//Browser Title
			$this->tbl = $this->db->SITESETTING;
			//Define Errors Here//
			$this->cls_msg = array();
			$this->cls_msg["no_result"] = get_message('no_result');
			$this->cls_msg["save_err"] = get_message('save_failed');
			$this->cls_msg["save_succ"] = get_message('save_success');
			$this->cls_msg["delete_err"] = get_message('del_failed');
			$this->cls_msg["delete_succ"] = get_message('del_success');

			//end Define Errors Here//
			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
			$this->load->model("site_setting_model","mod_rect");
			// end loading default model here //
		  
		 
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
            $this->data['title']	=	"Site Setting";//Browser Title
            $this->data['heading']	=	"Site Setting";
			
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
          //Put the select statement here
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
          //Put the select statement here
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
            $this->data['heading']		=	"Site Setting";			
			$this->data['BREADCRUMB']	=	array('Site Setting');
            //Submitted Form//
            if($_POST)
            {
				$posted=array();
                $posted = $_POST;	         
                //pr($posted,1);
                $this->form_validation->set_rules('s_admin_email', 'admin email','trim|required|valid_email');  				 
                $this->form_validation->set_rules('i_records_per_page', 'number of records per page','trim|required');       
				
				$info	=	array();
				
                if($this->form_validation->run() == FALSE)///invalid
                {
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {					
                    $i_id = decrypt($posted["h_id"]);
                    unset($posted["h_id"]);
                    //$i_aff = $this->mod_rect->edit_info($posted,$i_id);					
                    $i_aff = $this->acs_model->edit_data($this->tbl, $posted, array('i_id'=>$i_id));					
                    if($i_aff)//saved successfully
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
				//$info=$this->mod_rect->fetch_this("NULL"); 
				$tmp=$this->acs_model->fetch_data($this->tbl, array('i_id'=>1)); 
				$info = $tmp[0];
                $posted=array();
                $posted = $info;	
				$posted["h_id"]         = 	trim(encrypt($info["i_id"]));
                $this->data["posted"]   =	$posted;       
                unset($info,$posted);      
                
            }
		  	$this->render('site_setting/site_setting');
          //Put the select statement here
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
          
          //Put the select statement here
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

			//Put the select statement here
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }   
	
	  
    
	public function __destruct()
    {}
}
