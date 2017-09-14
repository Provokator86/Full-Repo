<?php
/*********
* Author: SWI
* Date  : 20 June 2015
* Modified By: 
* 
* Purpose:
*  Controller For User Type Master. 
* 
* @package User
* @subpackage User Type Master
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/User_type_master/
*/
class User_type_master extends MY_Controller
{
    public $cls_msg; //All defined error messages. 
    public $tbl, $pathtoclass, $remove_info_link;
    public function __construct()
    {
        try
        {
            parent::__construct();
            $this->data['title'] = addslashes(t("User Type"));// Browser Title

            // Define Errors Here//
            $this->cls_msg = array();
            $this->cls_msg["no_result"] = addslashes(t("No information found about ".strtolower($this->data['title'])."."));
            $this->cls_msg["save_err"] = addslashes(t("Information about ".strtolower($this->data['title'])." failed to save."));
            $this->cls_msg["save_succ"] = addslashes(t("Information about ".strtolower($this->data['title'])." saved successfully."));
            $this->cls_msg["delete_err"] = addslashes(t("Information about ".strtolower($this->data['title'])." failed to remove."));
            $this->cls_msg["delete_succ"] = addslashes(t("Information about ".strtolower($this->data['title'])." removed successfully."));
            // End Define Errors Here//

            $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/"; // For redirecting from this class
            
            // Loading the common model//
            $this->load->model("User_type_model","obj_mod");
            $this->load->model("menu_model","mod_menu");
            // End Loading the common model//
            
            $this->data['BREADCRUMB'] =	array(addslashes(t('User Type Master')));
            $this->remove_info_link = 'remove_information';
            $this->tbl = $this->db->USER_TYPE;
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
            $this->data['heading']=addslashes(t("User Type Master"));//Package Name[@package] Panel Heading

            //generating search query//
            //Getting Posted or session values for search//
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_user_type=($this->input->post("h_search")?$this->input->post("txt_user_type"):$this->session->userdata("txt_user_type")); 
            //end Getting Posted or session values for search//
			$user_type_id = decrypt($this->data['admin_loggedin']['user_type_id']); 
            $arr_search = array();            
            $arr_search[] = " id >= {$user_type_id} AND id>1 "; // Added to restrict the access of dev type user            
            if($user_type_id >= 3)
                $arr_search[] = " e_is_deleted = 'No'";
            
            if($s_search == "advanced")
            {
				if(trim($s_user_type)!="")
                	$arr_search[] =" s_user_type LIKE '%".get_formatted_string($s_user_type)."%' ";
                
                //Storing search values into session//
                $this->session->set_userdata("txt_user_type",$s_user_type);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"] = $s_search;
                $this->data["txt_user_type"] = $s_user_type;                
                //end Storing search values into session//                
                
            }
            else//List all records, **not done
            {
                //Releasing search values from session//
                $this->session->unset_userdata("txt_user_type");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_user_type"]="";                
                //end Storing search values into session//                 
            }
            $s_where = count($arr_search) > 0 ? implode(' AND ', $arr_search):'';        
            unset($s_search,$s_user_type);

            //Setting Limits, If searched then start from 0//
            $start = $this->input->post("h_search") ? 0 : $this->uri->segment($this->i_uri_seg);
            //end generating search query//
            
            $limit	= $this->i_admin_page_limit;
            $info = $this->acs_model->fetch_data($this->tbl, $s_where, '', $start, $limit, 'i_display_order');

            //Creating List view for displaying//
            $table_view = array();  
			          
            //Table Headers, with width,alignment//
            $table_view["caption"]=addslashes(t("User Type"));
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"] = $this->acs_model->count_info($this->tbl, $s_where);
                        
            $table_view["headers"][0]["width"]	= "25%";
            $table_view["headers"][0]["align"]	= "left";
            $table_view["headers"][0]["val"]	= addslashes(t("User Type"));
            if($this->data['action_allowed']['Access Control'] == 1){
			    $table_view["headers"][1]["val"]	= addslashes(t("Access Control"));
                $table_view["headers"][1]["align"]  = "center";  
            }
            
            if($user_type_id <= 2){
                $table_view["headers"][2]["val"]= t("Deleted"); 
                $table_view["headers"][2]["align"] = "center";
            }
            //end Table Headers, with width,alignment//
			
            //Table Data//
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);//Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_user_type"];
                
                if($this->data['action_allowed']['Access Control'] == 1){ // Check for permission
				    $table_view["tablerows"][$i][$i_col++]	= '<a class="btn btn-xs btn-warning" href="'.admin_base_url().'user_type_master/access_control/'.encrypt($info[$i]["id"]).'" data-toggle="tooltip" data-placement="bottom" title="Access Control"><i class="fa fa-gears"></i></a>';
                }
                if($user_type_id <=2)
                    $table_view["tablerows"][$i][$i_col++] = '<span class="label label-'.($info[$i]["e_is_deleted"] == 'Yes' ? 'danger' : 'success').'">'.$info[$i]["e_is_deleted"].'</span>';
            } 
            //end Table Data//
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_table($table_view);
            //Creating List view for displaying//
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();//used for search form action
            $this->render();          
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
        try
        {
            $this->data['heading']="Add New ".ucwords($this->data['title']);/*don't change*/
            $this->data['pathtoclass']=$this->pathtoclass;/*don't change*/
            $this->data['mode']="add";/*don't change*/

            //Submitted Form//
            if($_POST)
            {
                $posted=array();
                $posted["h_mode"]= $this->data['mode'];/*don't change*/
                $posted["h_id"]= "";/*don't change*/                
                $posted["txt_user_type"] = trim($this->input->post("txt_user_type"));
                
                $this->form_validation->set_rules('txt_user_type', 'user type name', 'required');
              
                if($this->form_validation->run() == FALSE)//invalid/*don't change*/
                {
                    //Display the add form with posted values within it//
                    $this->data["posted"]=$posted;/*don't change*/
                }
                else//validated, now save into DB
                {                    
                    $info=array();
                    $info["s_user_type"]=$posted["txt_user_type"];
                    $info["dt_created_on"]=time();
                    
                    $i_newid = $this->obj_mod->add_info($info);/*don't change*/
                    if($i_newid)//saved successfully
                    {
						// Add default setting for every user type like dashboard and my-account
						$tmp[0] = array('i_menu_id'=>2, 's_action'=>'Edit','s_link'=>'dashboard/modify_information/','i_user_type'=>$i_newid);
						$tmp[1] = array('i_menu_id'=>3, 's_action'=>'Edit','s_link'=>'my_account/modify_information/','i_user_type'=>$i_newid);
						#$this->dw_model->add_multiple_data($this->db->MENUPERMIT, $tmp);
						unset($tmp);
                        set_success_msg($this->cls_msg["save_succ"]);/*don't change*/
                        //Releasing search values from session//
                        $this->session->unset_userdata($this->s_search_var);/*don't change*/                          
                        redirect($this->pathtoclass."show_list");/*don't change*/
                    }
                    else//Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["save_err"]);/*don't change*/
                    }
                }
            }
            //end Submitted Form//
            $this->render($this->router->fetch_class()."/add-edit");/*don't change*/
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
            $this->data['heading']="Edit ".ucwords($this->data['title']);/*don't change*/
            $this->data['pathtoclass']=$this->pathtoclass;/*don't change*/
            $this->data['mode']="edit";/*don't change*/

            //Submitted Form//
            if($_POST)
            {
                $posted=array();
                $posted["h_mode"]= $this->data['mode'];/*don't change*/
                $posted["h_id"]= trim($this->input->post("h_id"));/*don't change*/       
                $posted["txt_user_type"]= trim($this->input->post("txt_user_type"));
                
                $this->form_validation->set_rules('txt_user_type', 'user type name', 'required');
             
                if($this->form_validation->run() == FALSE)//invalid/*don't change*/
                {
                    //Display the add form with posted values within it//
                    $this->data["posted"]=$posted;/*don't change*/
                }
                else//validated, now save into DB
                {
                    $info=array();
                    $info["s_user_type"]=$posted["txt_user_type"];
                    #$info["i_created_by"]=decrypt($this->data['loggedin']["user_id"]) ;//defined in MY_Controller
                    $info["dt_created_on"]=date("Y-m-d H:i:s");
                    
                    $i_aff=$this->obj_mod->edit_info($info,decrypt($posted["h_id"]));/*don't change*/
                    if($i_aff)//saved successfully/*don't change*/
                    {
                        set_success_msg($this->cls_msg["save_succ"]);/*don't change*/
                        redirect($this->pathtoclass."show_list");/*don't change*/
                    }
                    else//Not saved, show the form again/*don't change*/
                    {
                        $this->data["posted"]=$posted;/*don't change*/
                        set_error_msg($this->cls_msg["save_err"]);/*don't change*/
                    }
                    unset($info,$posted);/*don't change*/
                }
            }
            else
            {
                $info=$this->obj_mod->fetch_this_user(decrypt($i_id));/*don't change*/
				
                $posted=array();
                $posted["h_mode"]= $this->data['mode'];/*don't change*/
                $posted["h_id"]= $i_id;/*don't change*/                  
                $posted["txt_user_type"]= trim($info["s_user_type"]);
 
                $this->data["posted"]=$posted;/*don't change*/       
                unset($info,$posted);/*don't change*/      
            }
            //end Submitted Form//
            $this->render($this->router->fetch_class()."/add-edit");/*don't change*/
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
            //is the primary key,used for checking duplicate in edit mode
            $posted["id"]= decrypt($this->input->post("h_id"));/*don't change*/
            $posted["duplicate_value"]= get_formatted_string($this->input->post("h_duplicate_value"));
            
            if($posted["duplicate_value"]!="")
            {
                $qry=" Where ".(intval($posted["id"])>0 ? " ut.id!=".intval($posted["id"])." And " : "" )
                    ." ut.s_user_type='".$posted["duplicate_value"]."'";
                $info=$this->obj_mod->fetch_multi($qry,$start,$limit); /*don't change*/
                if(!empty($info))//Duplicate eists
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
    * Method to Delete information
    * This have no interface but db operation 
    * will be done here. Don't change any thing here.
    * 
    * On Success redirect to the showList interface else display error in showList interface. 
    * @param int $i_id, id of the record to be modified.
    */      
    public function remove_information()
    {
        try
        {
            $i_rect = false;
            $i_id = intval(decrypt($this->input->post("temp_id")));
            if($i_id > 0)
            {
                $i_rect = $this->acs_model->edit_data($this->tbl, array('e_is_deleted' =>'Yes'), array('id' => $i_id));
                if($i_rect) // Deleted(soft) successfully
                {
                    set_success_msg($this->cls_msg['delete_succ']);
                    echo "ok";                
                }
            }
            if(!$i_rect) // Not saved, show the form again
            {
                    set_error_msg($this->cls_msg['delete_err']);
                    echo "error" ;
            }
            unset($i_id, $i_rect);
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
                $info=$this->obj_mod->fetch_this_user(decrypt($i_id));/*don't change*/
                //pr($info);
                if(!empty($info))
                {
                    $temp=array();
                    $temp["id"]				= 	encrypt($info["id"]);//Index 0 must be the encrypted PK /*don't change*/
                    $temp["s_user_type"]	=	$info["s_user_type"];
                    $temp["s_is_active"]	=	$info["s_status"];
                    $temp["dt_created_on"]	=	$info["dt_created_on"];
                 
                    $this->data["info"]=$temp;/*don't change*/
                    unset($temp);/*don't change*/
                }
                unset($info);/*don't change*/
            }
            $this->add_css("css/admin/style.css");//include main css,/*don't change*/
            $this->add_js("js/jquery/jquery-1.4.2.js");//include main css,/*don't change*/
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");//include jquery css,/*don't change*/
            
            $this->render($this->router->fetch_class()."/show_detail",TRUE);/*don't change*/
            unset($i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }

    public function access_control($i_id=0)
    {
        try
        {
            $this->data['heading']="Access control on ".ucwords($this->data['title']);/*don't change*/
            $this->data['pathtoclass']=$this->pathtoclass;/*don't change*/
            $this->data['mode']="edit";/*don't change*/
			
			$user_type_id = decrypt($i_id);
			
            
            //Submitted Form//
            if($_POST)
            {
                //pr($_POST,1);
				$posted = array();
                $posted['user_type_id'] = decrypt($this->input->post('user_type_id'));
				$posted['opt_actions'] = $this->input->post('opt_actions');
				$posted['h_action_permit'] = $this->input->post('h_action_permit');
                $posted['h_first_label_menu_id'] = $this->input->post('h_first_label_menu_id');
                $posted['first_label_menu_id'] = $this->input->post('first_label_menu_id');
				//pr($posted['h_action_permit']);
				//pr($posted['opt_actions'],1);
				
				if(!empty($posted['h_action_permit']))
				{
					foreach($posted['h_action_permit'] as $menu_id)
					{
						$action	= $posted['opt_actions'][$menu_id];					
						$assigned_link = $this->mod_menu->get_link_for_menu($menu_id,$user_type_id);		
						//pr($assigned_link);				
						//pr($action,1);
						if(!empty($assigned_link))
						{
							foreach($assigned_link as $key=>$value)
							{
								if(!isset($action))
									$action	=	array();
								if(!in_array($key,$action))
								{
									$s_where = " WHERE s_link='".$value."' AND i_user_type=".$user_type_id." ";
									$i_aff = $this->mod_menu->delete_old_menu_permission($s_where);
								}
							}
						}
						if(!empty($action))
						{
							// By default it will take from the dev user type 
							$all_link =	$this->mod_menu->get_link_for_menu($menu_id, $this->config->item('dev_user_type')); 
                            
							foreach($action as $value)
							{
								if($value!='' && !array_key_exists($value,$assigned_link))
								{
									$info =	array();
									$info['i_user_type']	=	$user_type_id ;	
									$info['i_menu_id']		=	$menu_id ;	
									$info['s_action']		=	$value ;	
									$info['s_link']			=	$all_link[$value] ;	
									$i_aff = $this->mod_menu->add_menu_permit($info);
								}
							}
						}
					}	
				}	
				 
                if($i_aff)//saved successfully
                {
                    set_success_msg($this->cls_msg["save_succ"]);
                    redirect($this->pathtoclass."access_control/".$i_id);
                }
                else//Not saved, show the form again
                {
                    //set_error_msg($this->cls_msg["save_err"]);
                    redirect($this->pathtoclass."show_list");
                }
            }
            else
            {
				$this->data['user_type_id'] = $user_type_id = decrypt($i_id);
                
                // Fetch user type details
                $info = $this->obj_mod->fetch_this_user($user_type_id);
                
				// Fetch all the access permission 
                $this->data['action_list'] = $this->mod_menu->fetch_all_the_action_permission();
                	
                // Load default access data
                $this->data['menu_action'] = $this->mod_menu->fetch_access_control($user_type_id);	
                
				$posted = array();
                $posted["h_mode"] = $this->data['mode'];
                $posted["h_id"] = $i_id;                  
                $posted["txt_user_type"] = trim($info["s_user_type"]);
                $this->data["posted"] = $posted;
                unset($info,$posted);     
            }
            //end Submitted Form//
            $this->render($this->router->fetch_class()."/access-control");
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
	
	/* update user access control ajax call 
    * 
    */
    public function ajax_update_user_access()
    {
        try
        {
            $posted=array();
			
			$posted["i_user_type_id"]       = $this->input->post("i_user_type_id");/*don't change*/
            $posted["i_menu_id"]            = $this->input->post("i_menu_id");
			$posted["s_action"]             = trim($this->input->post("s_action"));
			$posted["i_cur_status"]         = $this->input->post("cur_status")=="checked"?1:0;
            $posted["s_controler_name"]     = trim($this->input->post("s_controler_name"));
			
			
			switch($posted["s_action"])
                {
                    case 'add':
                            $info['s_action'] = 'Add';   
                            break;                            
                    case 'edit':
                            $info['s_action'] = 'Edit';                           
                            break;                            
                    case 'delete':
                            $info['s_action'] = 'Delete';                           
                            break;                            
                    case 'view':
                            $info['s_action'] = 'View List';                           
                            break;                            
                    case 'approve':
                            $info['s_action'] = 'Approve';                           
                            break;
                    case 'active':
                            $info['s_action'] = 'Status';                           
                            break;                                                        
                }
			
			
			 
            if($posted["i_cur_status"]==1) //Add  accsess with each checked
            {			
				 
                 
                 
                 //Fetch the link used for super admin ....
                 $arr_where  =   array('i_menu_id'=>intval($posted["i_menu_id"]),'s_action'=>$info['s_action'],'i_user_type'=>0); 
                 $info_super   =   $this->obj_mod->fetch_action_details($arr_where) ;
				 
				// echo $this->db->last_query();
				// pr($info_super);
				 
                
                if(!empty($info_super))
                {
                   $info['s_action']    =     $info_super[0]['s_action']    ;
                   $info['s_link']      =     $info_super[0]['s_link']    ;
                }
                
                //add fetched link to subadmin user access
                
                //$info=$this->obj_mod->fetch_multi($qry,$start,$limit); /*don't change*/
                 $i_aff  =  $this->obj_mod->add_control($info,$posted["i_user_type_id"],$posted["i_menu_id"]);/*don't change*/ 
                if($i_aff)
                {
                    echo "added";
                }
                else
                {
                    echo "error";
                } 
                unset($info,$i_aff);                          
                
            } //End of adding access
            else //Delete  accsess with each unchecked
            {
                $s_where    =   " WHERE i_menu_id={$posted['i_menu_id']} AND i_user_type={$posted['i_user_type_id']} AND s_action='".$info['s_action']."' " ;
                
                $i_delete_rows = $this->obj_mod->delete_existing_control($s_where);
                
                if($i_delete_rows)
                {
                    echo "deleted";
                } 
                else
                {
                    echo "error";  
                }
                
                
            }//End of deteting access  
            unset($posted);     
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }  	
   
	public function __destruct()
    {}
}//end of class
