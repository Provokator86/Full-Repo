<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 02 Apr 2012
* Modified By: 
* Modified Date: 
* 
* Purpose:
* Controller For Content Management
* 
* @package Content Management
* @subpackage Content 
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/content_model.php
* @link views/admin/content/
*/


class Membership_plan extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
  
    public function __construct()
	{
		try
		{
			parent::__construct();
			$this->data['title']			=	"Membership Plan";////Browser Title
			
			////////Define Errors Here//////
			$this->cls_msg = array();
			$this->cls_msg["no_result"]		=	"No information found about membership plan.";
			$this->cls_msg["save_err"]		=	"Information about membership plan failed to save.";
			$this->cls_msg["save_succ"]		=	"Information about membership plan saved successfully.";
			$this->cls_msg["delete_err"]	=	"Information about membership plan failed to remove.";
			$this->cls_msg["delete_succ"]	=	"Information about membership plan removed successfully.";
			
			$this->cls_msg["status_err"]	=	"status change failed.";
            $this->cls_msg["status_succ"] 	=   "status changed successfully.";
			////////end Define Errors Here//////
			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
			
			//////// loading default model here //////////////
			$this->load->model("membership_model","mod_rect");
			$this->load->model("common_model","mod_common");
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
			redirect($this->pathtoclass."show_list");
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
        {
            $this->data['heading']="Membership Plan Management";////Package Name[@package] Panel Heading

            ///////////generating search query///////
            ////////Getting Posted or session values for search///
            $s_search		=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_type			=($this->input->post("h_search")?$this->input->post("opt_type"):$this->session->userdata("opt_type")); 
            $dt_created_on	=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
			
			////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE 1 ";
          	if($s_search=="advanced")
            {
                if($s_type!='')
				{
					$s_where .= " AND n.i_type = ".decrypt($s_type)." ";
				}
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.dt_created_on , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("opt_type",$s_type);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);				
                
                $this->data["h_search"]=$s_search;
                $this->data["opt_type"]=$s_type;                
                $this->data["txt_created_on"]=$dt_created_on;   
				$this->data["h_content_type"]=$i_content_type;          
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
				
              	$s_where=" WHERE 1 ";
				
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_content_title");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
				$this->data["h_search"]=$s_search;
                $this->data["opt_type"]="";                
                $this->data["txt_created_on"]="";        
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_type,$dt_created_on);
            ///Setting Limits, If searched then start from 0////
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
                $start=$this->uri->segment($this->i_uri_seg);
            }
            ///////////end generating search query///////
            
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_multi($s_where,intval($start),$limit);
			
            /////////Creating List view for displaying/////////
            $table_view=array();     
			       
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Content";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
			$table_view["detail_view"]=FALSE;
                        
            $table_view["headers"][0]["width"]	="20%";
            $table_view["headers"][0]["align"]	="left";
            $table_view["headers"][0]["val"]	="Type";
			$table_view["headers"][1]["width"]	="10%";  
            $table_view["headers"][1]["val"]	="Quotes";
			$table_view["headers"][2]["width"]	="10%";  
            $table_view["headers"][2]["val"]	="Contacts";
			$table_view["headers"][3]["width"]	="10%";  
            $table_view["headers"][3]["val"]	="Duration";
			$table_view["headers"][4]["width"]	="10%";  
            $table_view["headers"][4]["val"]	="Price";
            $table_view["headers"][5]["val"]	="Created On"; 
			$table_view["headers"][6]["width"]	="10%";  
            $table_view["headers"][6]["val"]	="Status";
           
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_db_records"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_type"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_quotes"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_contact_info"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_duration"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["d_price"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"]; 
				$table_view["tablerows"][$i][$i_col++]	='<span id="status_row_id_'.encrypt($info[$i]["id"]).'">'.$info[$i]["s_is_active"].'</span>';  
				$action   =   '';
                if($this->data['action_allowed']["Status"])
                {
				   if($info[$i]["i_is_active"] == 1)
					{						
                        $action .='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["id"]).'_inactive"><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/reject.png"></a>';
					}
					else
					{
						 $action .='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["id"]).'_active"><img width="12" height="12" alt="Active" title="Active" src="images/admin/tick.png"></a>';
					}
                }
				if($action!='')
                {
                    $table_view["rows_action"][$i]    = $action;     
                }            

            } 
            /////////end Table Data/////////
			
            unset($i,$i_col,$start,$limit); 
   
            $this->data["table_view"]=$this->admin_showin_table($table_view,TRUE);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
			
			$this->data['arr_type'] = $this->db->MEMBERPLAN;
			$this->render("membership_plan/show_list");
            unset($table_view,$info);
          
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
        //echo $this->router->fetch_method();exit();
		try
        {
            $this->data['title']="Membership Management";////Browser Title
            $this->data['heading']="Add Membership Plan";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="add";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["opt_type"]			= trim($this->input->post("opt_type"));
				$posted["txt_quotes"]		= trim($this->input->post("txt_quotes"));
				$posted["txt_contact"]		= trim($this->input->post("txt_contact"));
				$posted["txt_duration"]		= trim($this->input->post("txt_duration"));
				$posted["txt_price"]		= trim($this->input->post("txt_price"));
				$posted["txt_add_price"]	= trim($this->input->post("txt_add_price"));
				
                $posted["h_mode"]= $this->data['mode'];
                $posted["h_id"]= "";
				
				
               
                $this->form_validation->set_rules('opt_type', 'select membership type', 'required');
                $this->form_validation->set_rules('txt_quotes', 'provide quotes', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
                    $info["i_type"]						=	decrypt($posted["opt_type"]);
                    $info["i_quotes"]					=	$posted["txt_quotes"];
                    $info["i_contact_info"]				=	$posted["txt_contact"];
					$info["d_price"]					=	$posted["txt_price"];
					$info["i_duration"]					=	$posted["txt_duration"];
					$info["d_additional_contact_price"]	=	$posted["txt_add_price"];					
                    $info["dt_created_on"]				=	time();
					
                    $i_newid = $this->mod_rect->add_info($info);
                    if($i_newid)////saved successfully
                    {
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
			$this->data['arr_type'] = $this->db->MEMBERPLAN;
            $this->render("membership_plan/add-edit");
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
			$this->data['title']="Edit Content Details";////Browser Title
            $this->data['heading']="Edit content";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";
			$info=$this->mod_rect->fetch_this(decrypt($i_id));
			
            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["opt_type"]			= trim($this->input->post("opt_type"));
				$posted["txt_quotes"]		= trim($this->input->post("txt_quotes"));
				$posted["txt_contact"]		= trim($this->input->post("txt_contact"));
				$posted["txt_duration"]		= trim($this->input->post("txt_duration"));
				$posted["txt_price"]		= trim($this->input->post("txt_price"));
				$posted["txt_add_price"]	= trim($this->input->post("txt_add_price"));
				
                $posted["h_mode"]= $this->data['mode'];
                $posted["h_id"]= trim($this->input->post("h_id"));
				
				
               
                //$this->form_validation->set_rules('opt_type', 'select membership type', 'required');
                $this->form_validation->set_rules('txt_quotes', 'provide quotes', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
				
				
                else///validated, now save into DB
                {
                    $info=array();
                    //$info["i_type"]						=	decrypt($posted["opt_type"]);
                    $info["i_quotes"]					=	$posted["txt_quotes"];
                    $info["i_contact_info"]				=	$posted["txt_contact"];
					$info["d_price"]					=	$posted["txt_price"];
					$info["i_duration"]					=	$posted["txt_duration"];
					$info["d_additional_contact_price"]	=	$posted["txt_add_price"];					
                    $info["dt_created_on"]				=	time();
					
					
                    $i_aff=$this->mod_rect->edit_info($info,decrypt($posted["h_id"]));
                    if($i_aff)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);                       
						redirect($this->pathtoclass."show_list");						
                    }
                    else///Not saved, show the form again
                    {
                        //$this->session->set_userdata('error_msg', $this->cls_msg["save_err"]);
                        $this->data["posted"]=$posted;
                        //$this->data["error_msg"]=$this->cls_msg["save_err"];
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    unset($info,$posted);
                    
                }
            }
            else
            {
                
                $posted=array();
				$posted["opt_type"]			= trim($info["i_type"]);
                $posted["s_type"]           = trim($info["s_type"]);
				$posted["txt_quotes"]		= trim($info["i_quotes"]);
				$posted["txt_contact"]		= trim($info["i_contact_info"]);
				$posted["txt_duration"]		= trim($info["i_duration"]);
				$posted["txt_price"]		= trim($info["d_price"]);
				$posted["txt_add_price"]	= trim($info["add_price"]);
				
				$posted["h_id"]				= $i_id;
				$posted["i_id"]				= decrypt($i_id);
				$posted["h_mode"]			= $this->data['mode'];
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("membership_plan/add-edit");
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
							$i_ret_=$this->mod_rect->delete_all_info($i_content_type);
							break;
				default: ///Deleting selected,page ///
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
            unset($s_del_these,$id,$tot);
            
            if($i_ret_)
            {
                set_success_msg($this->cls_msg["delete_succ"]);
            }
            else
            {
                set_error_msg($this->cls_msg["delete_err"]);
            }
            redirect($this->pathtoclass."show_list".($pageno?"/".$pageno:""));
			/*if($this->i_content_type==1)////for page content type
			{
				redirect($this->pathtoclass."show_list".($pageno?"/".$pageno:""));
			}
			else////for email content type
			{
				redirect($this->pathtoclass."show_email_content".($pageno?"/".$pageno:""));
			}*/			
			
			
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
                    $temp["opt_type"]			= trim($info["i_type"]);
					$temp["txt_quotes"]		= trim($info["i_quotes"]);
					$temp["txt_contact"]		= trim($info["i_contact_info"]);
					$temp["txt_duration"]		= trim($info["i_duration"]);
					$temp["txt_price"]		= trim($info["d_price"]);
					$temp["txt_add_price"]	= trim($info["add_price"]);
					
					$temp["h_id"]						= $i_id;
					$temp["i_id"]						= decrypt($i_id);

					$this->data["info"]=$temp;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            
            $this->render("membership_plan/show_detail",TRUE);
            unset($i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	
	
	/**
    * this ajax function is for job accept reject
    * 
    */
    public function ajax_change_status()
    {
        try
        {
			$posted["id"]           = decrypt(trim($this->input->post("h_id")));
			$posted["i_status"]     = trim($this->input->post("i_status"));
			$info = array();
			$info['i_status']    = $posted["i_status"]  ;
			$arr_where              = array('i_id'=>$posted["id"]);
			//pr($info,1);
			$i_rect=$this->mod_common->common_edit_info($this->db->MEMBERSHIPPLAN,$info,$arr_where); /*don't change*/                
			if($i_rect)////saved successfully
			{
				echo "ok";                
			}
			else///Not saved, show the form again
			{
				echo "error" ;
			}
			
			unset($info,$i_rect);
            
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