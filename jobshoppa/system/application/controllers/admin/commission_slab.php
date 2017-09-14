<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 20 Sep 2011
* Modified By: 
* Modified Date: 
* 
* Purpose:
* Controller For Commission Slab
* 
* @package Content Management
* @subpackage Commission Slab
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/commission_slab_model.php
* @link views/admin/commission_slab/
*/


class Commission_slab extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']				=	"Commission Slab Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]		=	"No information found about commission slab.";
          $this->cls_msg["save_err"]		=	"Information about commission slab failed to save.";
          $this->cls_msg["save_succ"]		=	"Information about commission slab saved successfully.";
          $this->cls_msg["delete_err"]		=	"Information about commission slab failed to remove.";
          $this->cls_msg["delete_succ"]		=	"Information about commission slab removed successfully.";
          ////////end Define Errors Here//////
		  
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("commission_slab_model","mod_rect");
		  
		  

		  
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
            //redirect($this->pathtoclass."show_list");
			redirect($this->pathtoclass."modify_information");
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
    * 
    * On Success redirect to the showList interface else display error here.
    */
    public function add_information()           
    {
        //echo $this->router->fetch_method();exit();
		try
        {
            $this->data['title']		=	"Testimonial Management";////Browser Title
            $this->data['heading']		=	"Add Testimonial";
            $this->data['pathtoclass']	=	$this->pathtoclass;
            $this->data['mode']			=	"add";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
				//$posted["opt_language"]			=	trim($this->input->post("opt_language"));
                $posted["txt_person_name"]		= 	trim($this->input->post("txt_person_name"));
				$posted["txt_content"]			= 	trim($this->input->post("txt_content"));
				$posted["txt_person_address"]	= 	trim($this->input->post("txt_person_address"));
				$posted["txt_person_phone"]		= 	trim($this->input->post("txt_person_phone"));
				$posted["txt_person_email"]		= 	trim($this->input->post("txt_person_email"));
				$posted["opt_test_state"]		=	trim($this->input->post("opt_test_state"));
				
				$i_active_val 					= 	trim($this->input->post("i_is_active"));
                $posted["i_is_active"]			= 	($i_active_val==1)?$i_active_val:2;
			    $posted["h_mode"]				= 	$this->data['mode'];
                $posted["h_id"]					= 	"";
				
								
               	if(isset($_FILES['txt_person_image']) && !empty($_FILES['txt_person_image']['name']))
				{
					$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'txt_person_image','','',$this->allowedExt);
					
					$arr_upload_res = explode('|',$s_uploaded_filename);
				}
			   
                $this->form_validation->set_rules('txt_person_name', 'person name', 'required');
                $this->form_validation->set_rules('txt_content', 'testimonial description', 'required');
				$this->form_validation->set_rules('txt_person_address', 'address', 'required');
				$this->form_validation->set_rules('txt_person_phone', 'phone no.', 'required');
				$this->form_validation->set_rules('txt_person_email', 'email', 'trim|required|valid_email');
				
				
				
              
                if($this->form_validation->run() == FALSE || ($arr_upload_res[0]==='err'))/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
					//$info["i_lang_id"]			=	$posted["opt_language"];
                    $info["s_person_name"]		=	$posted["txt_person_name"];
                    $info["s_content"]			=	$posted["txt_content"];
					$info["s_person_address"]	=	$posted["txt_person_address"];
                    $info["s_person_phone"]		=	$posted["txt_person_phone"];
					$info["s_person_email"]		=	$posted["txt_person_email"];
                    $info["s_person_image"]		=	$arr_upload_res[2];//$posted["txt_person_image"];	
					$info["i_status"]			=	$posted["opt_test_state"];
									
                    //$info["i_status"]			=	$posted["i_is_active"];
                    $info["dt_entry_date"]		=	strtotime(date("Y-m-d H:i:s"));
					
					
					
                    $i_newid = $this->mod_rect->add_info($info);
                    if($i_newid)////saved successfully
                    {
                        if($arr_upload_res[0]==='ok')
						{
							get_image_thumb($this->uploaddir.$info["s_person_image"], $this->thumbdir, 'thumb_'.$info["s_person_image"]);
						}
						set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list");
                    }
                    else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                }
            }
            ////////////end Submitted Form///////////
			$this->data['arr_state'] = $this->db->TESTIMONIALSTATE;
            $this->render("testimonial/add-edit");
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
            $this->data['title']		=	"Edit Commission Slab Details";////Browser Title
            $this->data['heading']		=	"Edit Commission Slab";
            $this->data['pathtoclass']	=	$this->pathtoclass;
            $this->data['mode']			=	"edit";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]				= 	$this->data['mode'];
				$posted["txt_upper_slab"]		=	trim($this->input->post("txt_upper_slab"));
				$posted["txt_below_slab"]		=	trim($this->input->post("txt_below_slab"));
				
				$i_active_val 					=   trim($this->input->post("i_is_active"));				
                $posted["i_is_active"]			= 	($i_active_val==1)?$i_active_val:2;
                $posted["h_id"]					= 	trim($this->input->post("h_id"));
				
				
                $this->form_validation->set_rules('txt_below_slab', 'commission', 'required');
               // $this->form_validation->set_rules('txt_upper_slab', 'commission%(>100)', 'required');
				//$this->form_validation->set_rules('i_is_active', 'active status', 'checkbox|checked|required');
				
				
             
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["s_up_slab"]			=	$posted["txt_upper_slab"];
                    $info["s_below_slab"]		=	$posted["txt_below_slab"];
                    $info["i_status"]			=	1;
                    $info["dt_entry_date"]		=	strtotime(date("Y-m-d H:i:s"));
					
					
                    $i_aff=$this->mod_rect->add_info($info,decrypt($posted["h_id"]));
					
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
                    unset($info,$posted, $i_aff);
                    
                }
            }
            else
            {
                //$info=$this->mod_rect->fetch_this(decrypt($i_id));				
				$info=$this->mod_rect->get_to_show_default();
                $posted=array();
				$posted["txt_below_slab"]		=	trim($info["s_commission_slab_100"]);
				$posted["txt_upper_slab"]		=	trim($info["s_commission_greater_than_100"]);				
				$posted["i_is_active"]			=	$info["i_is_active"];
				$posted["h_id"]					= 	$i_id;
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("commission_slab/add-edit");
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
            $i_ret_=0;
            $pageno=$this->input->post("h_pageno");///the pagination page no, to return at the same page
            
            /////Deleting What?//////
            $s_del_these=$this->input->post("h_list");
            switch($s_del_these)
			{
				case "all":
							$i_ret_=$this->mod_rect->delete_info(-1);
							break;
				default: 		///Deleting selected,page ///
							//////First consider the posted ids, if found then take $i_id value////
							$id=(!$i_id?$this->input->post("chk_del"):$i_id);///may be an array of IDs or single id
							if(is_array($id) && !empty($id))///Deleting Multi Records
							{
								///////////Deleting Information///////
								$tot=count($id)-1;
								while($tot>=0)
								{
									$i_ret_=$this->mod_rect->delete_info(decrypt($id[$tot]));
									$tot--;
								}
							}
							elseif($id>0)///Deleting single Records
							{
								$i_ret_=$this->mod_rect->delete_info(decrypt($id));
							}                
							break;
			}
            unset($s_del_these, $id, $tot);
            
            if($i_ret_)
            {
                set_success_msg($this->cls_msg["delete_succ"]);
            }
            else
            {
                set_error_msg($this->cls_msg["delete_err"]);
            }
            redirect($this->pathtoclass."show_list".($pageno?"/".$pageno:""));
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
            if(trim($i_id)!="")
            {
                $info=$this->mod_rect->fetch_this(decrypt($i_id));

                if(!empty($info))
                {
                    $temp=array();
                    $temp["s_id"]				= 	encrypt($info["id"]);////Index 0 must be the encrypted PK 
					$temp["s_person_name"]		=	trim($info["s_person_name"]);
					$temp["s_content"]			=	trim($info["s_content"]);
					$temp["s_person_address"]	=	trim($info["s_person_address"]);
					$temp["s_person_phone"]		=	trim($info["s_person_phone"]);
					$temp["s_person_email"]		=	trim($info["s_person_email"]);
					$temp["s_person_image"]		=	trim($info["s_person_image"]);
					$temp["s_is_active"]		= 	trim($info["s_is_active"]);
					$temp["dt_entry_date"]		= 	trim($info["dt_created_on"]);
					
					$this->data["info"]=$temp;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            
            $this->render("testimonial/show_detail",TRUE);
            unset($i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
     /***
    * Checks duplicate value using ajax call
    */
    public function ajax_checkduplicate()
    {
        try
        {
            $posted=array();
            ///is the primary key,used for checking duplicate in edit mode
            $posted["id"]= decrypt($this->input->post("h_id"));/*don't change*/
            $posted["duplicate_value"]= htmlspecialchars(trim($this->input->post("h_duplicate_value")),ENT_QUOTES);
			$posted["language_id"] = decrypt($this->input->post("lang_id"));
            
            if($posted["duplicate_value"]!="")
            {
                $qry=" Where ".(intval($posted["id"])>0 ? " n.i_id!=".intval($posted["id"])." And " : "" )
                    ." n.s_content='".$posted["duplicate_value"]."' And n.i_lang_id='".$posted['language_id']."' ";
                $info=$this->mod_rect->fetch_multi($qry,$start,$limit); /*don't change*/
                if(!empty($info))/////Duplicate eists
                {
                    echo "Duplicate exists";
                }
                else
                {
                    echo "valid";/*don't change*/
                }
                unset($qry,$info);
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
?>