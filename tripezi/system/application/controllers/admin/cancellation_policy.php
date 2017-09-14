<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 03 July 2012
* Modified By: 
* Modified Date:  
* Purpose:
*  Controller For Manage Cancellation Policy
* @package Manage Assets
* @subpackage Manage Cancellation Policy
* @link InfController.php 
* @link My_Controller.php
* @link model/Assets_model.php
* @link views/admin/assets/
*/


class Cancellation_policy extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="Cancellation Policy Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	=	"No information found about cancellation policy.";
          $this->cls_msg["save_err"]	=	"Information about cancellation policy failed to save.";
          $this->cls_msg["save_succ"]	=	"Information about cancellation policy saved successfully.";
          $this->cls_msg["delete_err"]	=	"Information about cancellation policy failed to remove.";
          $this->cls_msg["delete_succ"]	=	"Information about cancellation policy removed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass 			= 	admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("assets_model","mod_rect");
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
    public function show_list($order_name='',$order_by='asc',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Cancellation Policy";////Package Name[@package] Panel Heading
			
			
            ///////////generating search query///////
			
              ////////Getting Posted or session values for search/// 
            $s_search     =(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title    =($this->input->post("h_search")?$this->input->post("txt_title"):$this->session->userdata("txt_title"));            
            ////////end Getting Posted or session values for search///            
            $s_where    =" WHERE c.i_status!=2 ";
           
            if($s_search=="advanced")
            {
                $s_where.=" AND c.s_name LIKE '%".get_formatted_string($s_title)."%' ";

                /////Storing search values into session///
                
                $this->session->set_userdata("txt_title",$s_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]        = $s_search;
                $this->data["txt_title"]    = get_unformatted_string($s_title);           
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE c.i_status!=2 ";
                /////Releasing search values from session///

                $this->session->unset_userdata("txt_title");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]        = $s_search;
                $this->data["txt_title"]    = "";                          
                /////end Storing search values into session///                    
            }
            unset($s_search,$s_title);
            ///Setting Limits, If searched then start from 0////
			$i_uri_seg =6;
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
                $start=$this->uri->segment($i_uri_seg);
            }
            ///////////end generating search query///////
			$arr_sort = array(0=>'c.s_name'); 
			$s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
          
            $limit	= $this->i_admin_page_limit;
			$info	= $this->mod_rect->fetch_multi_sorted_cancellation_policy($s_where,$s_order_name,$order_by,intval($start),$limit);
			
			
            /////////Creating List view for displaying/////////
            $table_view=array();  
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]				= "Cancellation Policy";
            $table_view["total_rows"]			= count($info);
			$table_view["total_db_records"]		= $this->mod_rect->gettotal_cancellation_policy_info($s_where);
			$table_view["order_name"]			= $order_name;
			$table_view["order_by"]  			= $order_by;
            $table_view["src_action"]			= $this->pathtoclass.$this->router->fetch_method(); 
			$table_view["detail_view"]  		= false;
                        
            $table_view["headers"][0]["width"]	= "25%";
            $table_view["headers"][0]["align"]	= "left";
			$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][0]["val"]	= "Cancellation Policy";
			$table_view["headers"][1]["width"]	= "15%";
			$table_view["headers"][1]["val"]	= "Cancellation Charge(%)";
			$table_view["headers"][2]["width"]	= "35%";
			$table_view["headers"][2]["val"]	= "Description ";
			$table_view["headers"][3]["val"]	= "Status";
 
			
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_name"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["d_cancellation_charge_percentage"];
				$table_view["tablerows"][$i][$i_col++]	= string_part($info[$i]["s_description"],150);
                $table_view["tablerows"][$i][$i_col++]	= '<span id="status_row_id_'.encrypt($info[$i]["id"]).'">'.$info[$i]["s_status"].'</span>';
				
				$action ='';
				if($this->data['action_allowed']["Status"])
                 {
					if($info[$i]["i_status"] == 1)
					{
                        $action .='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["id"]).'_inactive"><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/inactive.png"></a>';
					}
					else
					{
                       
						 $action .='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["id"]).'_active"><img width="12" height="12" alt="Active" title="Active" src="images/admin/active.png"></a>';
					}
				
				}
                if($action!='')
                {
                    $table_view["rows_action"][$i]    = $action;     
                }
				

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit);             
            
			$this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            
            $this->render('assets/cancellation-policy-show-list');          
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
            $this->data['title']="Cancellation Policy Management";////Browser Title
            $this->data['heading']="Add Cancellation Policy";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="add";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["txt_policy"]		= trim($this->input->post("txt_policy"));
				$posted["txt_cancel_charge"]= trim($this->input->post("txt_cancel_charge"));	
				$posted["ta_description"]	= trim($this->input->post("ta_description"));		
                $posted["h_mode"]			= $this->data['mode'];
                $posted["h_id"]= "";
				
				
                $this->form_validation->set_rules('txt_policy', 'cancellation policy name', 'required');
				$this->form_validation->set_rules('ta_description', 'description', 'required');
				$this->form_validation->set_rules('txt_cancel_charge', 'cancellation charge', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
                    $info["s_name"]								= $posted["txt_policy"];
					$info["s_description"]						= $posted["ta_description"];
					$info["d_cancellation_charge_percentage"]	= doubleval($posted["txt_cancel_charge"]);
					
					$s_tablename	=	$this->db->PROPERTYCANCELLATIONPOLICY;
					$i_newid = $this->mod_common->common_add_info($s_tablename,$info);
					unset($s_tablename);
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
            $this->render("assets/cancellation-policy-add-edit");
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
            $this->data['title']="Edit Cancellation Policy Details";////Browser Title
            $this->data['heading']="Edit Cancellation Policy";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]			= $this->data['mode'];
				$posted["txt_policy"]		= trim($this->input->post("txt_policy"));
				$posted["txt_cancel_charge"]= trim($this->input->post("txt_cancel_charge"));	
				$posted["ta_description"]	= trim($this->input->post("ta_description"));
                $posted["h_id"]				= trim($this->input->post("h_id"));
				
				
                $this->form_validation->set_rules('txt_policy', 'cancellation policy name', 'required');
				$this->form_validation->set_rules('ta_description', 'description', 'required');
				$this->form_validation->set_rules('txt_cancel_charge', 'cancellation charge', 'required');

                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["s_name"]								= $posted["txt_policy"];
					$info["s_description"]						= $posted["ta_description"];
					$info["d_cancellation_charge_percentage"]	= doubleval($posted["txt_cancel_charge"]);
					
					$s_tablename= $this->db->PROPERTYCANCELLATIONPOLICY;
					$arr_where	= array('i_id'=>decrypt($posted["h_id"]));
					$i_aff		= $this->mod_common->common_edit_info($s_tablename,$info,$arr_where);
					unset($s_tablename,$arr_where);
                    if($i_aff)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list");
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
                $info=$this->mod_rect->fetch_this_cancellation_policy(decrypt($i_id));				
                $posted=array();				
				
				$posted["txt_policy"] 			= trim($info["s_name"]);
				$posted["ta_description"] 		= trim($info["s_description"]);
				$posted["txt_cancel_charge"] 	= $info["d_cancellation_charge"];
				$posted["h_id"]         		= $i_id;
				$posted["i_id"]					= decrypt($i_id);
                $this->data["posted"]			= $posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("assets/cancellation-policy-add-edit");
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
    {}
	
     /***
    * Checks duplicate value using ajax call
    */
    public function ajax_checkduplicate()
    {
        try
        {
            $posted=array();
            ///is the primary key,used for checking duplicate in edit mode
            $posted["id"]				= decrypt($this->input->post("h_id"));/*don't change*/
            $posted["duplicate_value"]	= get_formatted_string($this->input->post("h_duplicate_value"));
			
						
            if($posted["duplicate_value"]!="")
            {
                $qry=" WHERE ".(intval($posted["id"])>0 ? " c.i_id!=".intval($posted["id"])." And " : "" )
                    ." c.s_name='".$posted["duplicate_value"]."'" ;
					
				
				$info=$this->mod_rect->gettotal_cancellation_policy_info($qry); /*don't change*/
				
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
	
	/***
    * Change status of the country 
    * @author Mrinmoy 
    */
    public function ajax_change_status()
    {
        try
        {
            $posted				= array();
			$posted["id"]       = decrypt(trim($this->input->post("h_id")));
			$posted["i_status"] = trim($this->input->post("i_status"));
			//pr($posted,1);
			$info 				= array();
			$info['i_status']   = $posted["i_status"];
			$arr_where          = array('i_id'=>$posted["id"]);
			$i_rect				= $this->mod_common->common_edit_info($this->db->PROPERTYCANCELLATIONPOLICY,$info,$arr_where); /*don't change*/                
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