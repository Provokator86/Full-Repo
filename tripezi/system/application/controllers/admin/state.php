<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 02 July 2012
* Modified By: 
* Modified Date:
* Purpose:
*  Controller For state
* @package General
* @subpackage state
* @link InfController.php 
* @link My_Controller.php
* @link model/state_model.php
* @link views/admin/state/
*/


class State extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="State Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	= "No information found about state.";
          $this->cls_msg["save_err"]	= "Information about state failed to save.";
          $this->cls_msg["save_succ"]	= "Information about state saved successfully.";
          $this->cls_msg["delete_err"]	= "Information about state failed to remove.";
          $this->cls_msg["delete_succ"]	= "Information about state removed successfully.";
		  $this->cls_msg["status_succ"] = "Status of state saved successfully.";
		  $this->cls_msg["status_err"]	= "Status of state failed to save.";
          ////////end Define Errors Here//////
          $this->pathtoclass 			= admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("state_model","mod_rect");
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
            $this->data['heading']="State";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search	=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_state	=($this->input->post("h_search")?$this->input->post("txt_state"):$this->session->userdata("array_list_search","txt_state")); 
			$s_country  =($this->input->post("h_search")?$this->input->post("opt_country"):$this->session->userdata("array_list_search","opt_country"));
           
			////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status!=2 ";
            if($s_search=="advanced")
            {
				if(!empty($s_state))
				{
                	$s_where.=" AND n.s_state LIKE '%".get_formatted_string($s_state)."%' ";
				}
				if(decrypt($s_country))
				{
					$s_where.=" AND n.i_country_id = ".decrypt($s_country)." ";
				}
                
                /////Storing search values into session///
				$array_list_search = array('txt_state'   => $s_state,
										   'opt_country' => $s_country
										  );
				$this->session->set_userdata("array_list_search");
                //$this->session->set_userdata("txt_state",$s_state);				
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]		= $s_search;
                $this->data["txt_state"]	= $s_state; 
				$this->data["opt_country"]	= $s_country;               
          
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_status!=2 ";
                /////Releasing search values from session///
				$array_list_search = array('txt_state'  => '',
										   'opt_country'=> ''
										  );
				$this->session->unset_userdata("array_list_search");
                //$this->session->unset_userdata("txt_state");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]		= $s_search;
                $this->data["txt_state"]	= "";  
				$this->data["opt_country"]	= "";                        
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_state);
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
			
			$arr_sort = array(0=>'n.s_state',2=>'n.i_status'); 
			$s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
            
            $limit	= $this->i_admin_page_limit;
			$info	= $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]				= "State";
            $table_view["total_rows"]			= count($info);
			$table_view["total_db_records"]		= $this->mod_rect->gettotal_info($s_where);
			$table_view["order_name"]			= $order_name;
			$table_view["order_by"]  			= $order_by;
            $table_view["src_action"]			= $this->pathtoclass.$this->router->fetch_method(); 
			$table_view["detail_view"]  		= false;
                        
            $table_view["headers"][0]["width"]	= "40%";
            $table_view["headers"][0]["align"]	= "left";
			$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][0]["val"]	= "State Name";
            $table_view["headers"][1]["width"]  = "40%";
			$table_view["headers"][1]["val"]    = "Country Name";
			$table_view["headers"][2]["sort"]	= array('field_name'=>encrypt($arr_sort[2]));
			$table_view["headers"][2]["val"]	= "Status";
			
			
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]  = $info[$i]["s_state"];
                $table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_country"];                
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
            
            $this->render();          
            unset($table_view,$info,$s_order_name,$arr_sort,$order_name);
          
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
            $this->data['title']="State Management";////Browser Title
            $this->data['heading']="Add State";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="add";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["txt_state"]				=	trim($this->input->post("txt_state"));
				$posted["opt_country"]	            =	trim($this->input->post("opt_country"));
                $posted["h_mode"]					=	$this->data['mode'];
                $posted["h_id"]= "";
               
                $this->form_validation->set_rules('txt_state', 'state name', 'required');
                $this->form_validation->set_rules('opt_country', 'country', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
                    $info["s_state"]			=	$posted["txt_state"];
                    $info["i_country_id"]	    =	decrypt($posted["opt_country"]);
					
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
            $this->render("state/add-edit");
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
            $this->data['title']="Edit State Details";////Browser Title
            $this->data['heading']="Edit State";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]					= $this->data['mode'];
				$posted["txt_state"]				= trim($this->input->post("txt_state"));
				$posted["opt_country"]              = trim($this->input->post("opt_country"));
                $posted["h_id"]						= trim($this->input->post("h_id"));
				
				
                $this->form_validation->set_rules('txt_state', 'state name', 'required');
                $this->form_validation->set_rules('opt_country', 'country', 'required');
             
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["s_state"]			=	$posted["txt_state"];
                    $info["i_country_id"]       =   decrypt($posted["opt_country"]);
                    
                    $i_aff=$this->mod_rect->edit_info($info,decrypt($posted["h_id"]));
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
                $info=$this->mod_rect->fetch_this(decrypt($i_id));	
	
                $posted=array();
                $posted["txt_state"]        	= trim($info["s_state"]);
				$posted["opt_country"]		    = encrypt($info["i_country_id"]);
				$posted["h_id"]					= $i_id;
                $this->data["posted"]			= $posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("state/add-edit");
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
    * Change status value 
	*/
    public function change_status($s_id,$type)
    {
        try
        {
            
            if(decrypt($s_id)>0)
            {
                $info = array();
				
				$info['i_is_active'] = ($type==1)?1:0;
               $i_rect=$this->mod_rect->change_status($info,decrypt($s_id)); /*don't change*/				
                if($i_rect)////saved successfully
				{
					//$mail_send = $this->mod_rect->account_activate_deactivate(decrypt($s_id),$info);
					set_success_msg($this->cls_msg["status_succ"]);					
				}
				else///Not saved, show the form again
				{
					set_error_msg($this->cls_msg["status_err"]);
				}
				redirect($this->pathtoclass."show_list");
                unset($info,$i_rect);
            }   
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
                    $temp["s_id"]       	= encrypt($info["id"]);////Index 0 must be the encrypted PK 
                    $temp["s_state"] 		= trim($info["s_state"]);
					$temp["s_country"]  	= trim($info["s_country"]);
					$temp["s_status"]		= trim($info["s_status"]);

					$this->data["info"]		= $temp;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            
            $this->render("state/show_detail",TRUE);
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
            $posted["id"]				= decrypt($this->input->post("h_id"));/*don't change*/
            $posted["i_country_id"]		= decrypt($this->input->post("i_country_id"));
            $posted["duplicate_value"]	= get_formatted_string($this->input->post("h_duplicate_value"));
            
            if($posted["duplicate_value"]!="")
            {
                $qry=" Where ".(intval($posted["id"])>0 ? " n.i_id!=".intval($posted["id"])." And " : "" )
                    ." n.s_state='".$posted["duplicate_value"]."' AND n.i_country_id=".$posted["i_country_id"];
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
	
	
	/***
    * Change status of the state 
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
			$i_rect				= $this->mod_common->common_edit_info($this->db->STATE,$info,$arr_where); /*don't change*/                
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