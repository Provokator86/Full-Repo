<?php
/*********
* Author: Iman Biswas
* Date  : 14 Sep 2010
* Modified By: Iman Biswas
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
class User_type_master extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->data['title']="User Type";////Browser Title
          
          ////////Define Errors Here//////
          /*don't change, you may add*/
          $this->cls_msg=array();
          $this->cls_msg["no_result"]="No information found about ".strtolower($this->data['title']).".";
          $this->cls_msg["save_err"]="Information about ".strtolower($this->data['title'])." failed to save.";
          $this->cls_msg["save_succ"]="Information about ".strtolower($this->data['title'])." saved successfully.";
          $this->cls_msg["delete_err"]="Information about ".strtolower($this->data['title'])." failed to remove.";
          $this->cls_msg["delete_succ"]="Information about ".strtolower($this->data['title'])." removed successfully.";
          ////////end Define Errors Here//////
         
          $this->pathtoclass=admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class/*don't change*/
          /////////Loading the common model///////////
          $this->load->model("User_type_model","obj_mod");
          /////////end Loading the common model///////////
		  
          //$this->data['controller_array'] = $this->db->CONTROLLER_NAME;
          /**
          * merging the finance and insurance menus
          * Common menus are not repeated. 
          * Sorted the final array such that the extra menus are 
          * fitted within at the same position in final array.
          */
          $this->data['controller_array']=$this->db->CONTROLLER_NAME;
/*          $mnulbl_0=array();
          $mnulbl_1=array();
          foreach($this->data['controller_array'] as $mnu=>$info)
          {
              //$temp[]
              $mnulbl_0[$mnu]=$info["top_menu"];
              $mnulbl_1[$mnu]=$info["menu_name"];
              //pr($mnulbl_0);//pr($mnulbl_1);
          }
*/          /**
          * Sorting the combined menus such that 
          * the extra menu in finance appears at 
          * the same position in the insurance menu.
          * ex- extra menu in report of finance "fin_customer_policy_report" 
          *     appears within "branch report", will appear with in the same 
          *     "branch report" menu in the combined menu array.
          */
/*          array_multisort(
            $mnulbl_0, SORT_ASC, SORT_STRING,
            $mnulbl_1, SORT_ASC, SORT_STRING, 
            $this->data['controller_array']       
          );*/
          unset($mnu,$info,$mnulbl_0,$mnulbl_1);
          //pr($this->data['controller_array']);
          ///end merging the finance and insurance menus///
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
            $this->data['heading']="User Type";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_user_type=($this->input->post("h_search")?$this->input->post("txt_user_type"):$this->session->userdata("txt_user_type")); 
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///

            if($s_search=="basic")
            {
                $s_where.=" WHERE ut.s_user_type LIKE '%".get_formatted_string($s_user_type)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_user_type",$s_user_type);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_user_type"]=$s_user_type;
				$this->data["txt_created_on"]=$dt_created_on;  
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
				if(trim($s_user_type)!="")
				{
                	$arr_search[] =" ut.s_user_type LIKE '%".get_formatted_string($s_user_type)."%' ";
				}	
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $arr_search[]=" FROM_UNIXTIME( ut.dt_created_on , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                $s_where .= (count($arr_search) !=0)?' WHERE '.implode('AND',$arr_search):'';		
				
                /////Storing search values into session///
                $this->session->set_userdata("txt_faq_title",$s_faq_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_user_type"]=$s_user_type;                
                $this->data["txt_created_on"]=$dt_created_on;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_user_type");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_faq_title"]="";                
                $this->data["txt_created_on"]="";             
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
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
            $info	= $this->obj_mod->fetch_multi($s_where,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="User Type";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->obj_mod->gettotal_info($s_where);
                        
            $table_view["headers"][0]["width"]	="25%";
            $table_view["headers"][0]["align"]	="left";
            $table_view["headers"][0]["val"]	="User Type";
			$table_view["headers"][1]["val"]	="Access Control";  
            //$table_view["headers"][2]["val"]	="Created On"; 
            //$table_view["headers"][3]["val"]	="Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_user_type"];
				$table_view["tablerows"][$i][$i_col++]	= '<a href="'.admin_base_url().'user_type_master/access_control/'.encrypt($info[$i]["id"]).'"><img src="'.base_url().'images/admin/access_inline.gif" border="0" title="Access" /></a>';
                //$table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];
                //$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_active"];

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            //echo $this->data["search_action"];
            
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

            ////////////Submitted Form///////////
            if($_POST)
            {
                $posted=array();
                $posted["h_mode"]= $this->data['mode'];/*don't change*/
                $posted["h_id"]= "";/*don't change*/                
                $posted["txt_user_type"]= trim($this->input->post("txt_user_type"));
                
                $this->form_validation->set_rules('txt_user_type', 'user type name', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid/*don't change*/
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;/*don't change*/
                }
                else///validated, now save into DB
                {                    
                    $info=array();
                    $info["s_user_type"]=$posted["txt_user_type"];
                    $info["dt_created_on"]=time();
                    
                    $i_newid=$this->obj_mod->add_info($info);/*don't change*/
                    if($i_newid)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);/*don't change*/
                        /////Releasing search values from session///
                        $this->session->unset_userdata($this->s_search_var);/*don't change*/                          
                        redirect($this->pathtoclass."show_list");/*don't change*/
                    }
                    else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["save_err"]);/*don't change*/
                    }
                }
            }
            ////////////end Submitted Form///////////
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

            ////////////Submitted Form///////////
            if($_POST)
            {
                $posted=array();
                $posted["h_mode"]= $this->data['mode'];/*don't change*/
                $posted["h_id"]= trim($this->input->post("h_id"));/*don't change*/       
                $posted["txt_user_type"]= trim($this->input->post("txt_user_type"));
                
                $this->form_validation->set_rules('txt_user_type', 'user type name', 'required');
             
                if($this->form_validation->run() == FALSE)/////invalid/*don't change*/
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;/*don't change*/
                }
                else///validated, now save into DB
                {
                    $info=array();
                    $info["s_user_type"]=$posted["txt_user_type"];
                    $info["i_created_by"]=decrypt($this->data['loggedin']["user_id"]) ;///defined in MY_Controller
                    $info["dt_created_on"]=date("Y-m-d H:i:s");
                    
                    $i_aff=$this->obj_mod->edit_info($info,decrypt($posted["h_id"]));/*don't change*/
                    if($i_aff)////saved successfully/*don't change*/
                    {
                        set_success_msg($this->cls_msg["save_succ"]);/*don't change*/
                        redirect($this->pathtoclass."show_list");/*don't change*/
                    }
                    else///Not saved, show the form again/*don't change*/
                    {
                        $this->data["posted"]=$posted;/*don't change*/
                        set_error_msg($this->cls_msg["save_err"]);/*don't change*/
                    }
                    unset($info,$posted);/*don't change*/
                }
            }
            else
            {
                $info=$this->obj_mod->fetch_this(decrypt($i_id));/*don't change*/
                $posted=array();
                $posted["h_mode"]= $this->data['mode'];/*don't change*/
                $posted["h_id"]= $i_id;/*don't change*/                  
                $posted["txt_user_type"]= trim($info["s_user_type"]);
 
                $this->data["posted"]=$posted;/*don't change*/       
                unset($info,$posted);/*don't change*/      
            }
            ////////////end Submitted Form///////////
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
            ///is the primary key,used for checking duplicate in edit mode
            $posted["id"]= decrypt($this->input->post("h_id"));/*don't change*/
            $posted["duplicate_value"]= get_formatted_string($this->input->post("h_duplicate_value"));
            
            if($posted["duplicate_value"]!="")
            {
                $qry=" Where ".(intval($posted["id"])>0 ? " ut.id!=".intval($posted["id"])." And " : "" )
                    ." ut.s_user_type='".$posted["duplicate_value"]."'";
                $info=$this->obj_mod->fetch_multi($qry,$start,$limit); /*don't change*/
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
    * Method to Delete information
    * This have no interface but db operation 
    * will be done here. Don't change any thing here.
    * 
    * On Success redirect to the showList interface else display error in showList interface. 
    * @param int $i_id, id of the record to be modified.
    */      
    public function remove_information($i_id=0)
    {
        try
        {
            $i_ret_=0;/*don't change*/
            $pageno=$this->input->post("h_pageno");///the pagination page no, to return at the same page/*don't change*/
            
            /////Deleting What?//////
            $s_del_these=$this->input->post("h_list");
            switch($s_del_these)
            {
                case "all":
                    $i_ret_=$this->obj_mod->delete_info(-1);
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
                          $i_ret_=$this->obj_mod->delete_info(decrypt($id[$tot]));
                          $tot--;
                      }
                    }
                    elseif($id>0)///Deleting single Records
                    {
                        $i_ret_=$this->obj_mod->delete_info(decrypt($id));
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
                $info=$this->obj_mod->fetch_this(decrypt($i_id));/*don't change*/
                //pr($info);
                if(!empty($info))
                {
                    $temp=array();
                    $temp["id"]= encrypt($info["id"]);////Index 0 must be the encrypted PK /*don't change*/
                    $temp["s_user_type"]=$info["s_user_type"];
                    $temp["i_created_by"]=$info["i_created_by"];
                    $temp["s_created_by"]=$info["s_created_by"];
                    $temp["dt_created_on"]=$info["dt_created_on"];
                    $temp["s_is_deleted"]=$info["s_is_deleted"];   
				    $temp["access_info"]=$info["access_controll_array"];   
                 
                    $this->data["info"]=$temp;/*don't change*/
                    unset($temp);/*don't change*/
                }
                unset($info);/*don't change*/
            }
            $this->add_css("css/admin/style.css");///include main css,/*don't change*/
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css,/*don't change*/
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css,/*don't change*/
            
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

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]= $this->data['mode'];/*don't change*/
                $posted["h_id"]= trim($this->input->post("h_id"));/*don't change*/       
				
				//Add edit
				if(count($this->data['controller_array'])>0)
				{
				 $i_user_type_id = decrypt($posted["h_id"]);		
				 foreach($this->data['controller_array'] as $key=>$value )
				 {
					$info=array();
					$info["i_user_type_id"] = $i_user_type_id;
					$info["s_controller"] = $key;
					$info["i_action_add"] = trim($this->input->post("chk_action_add_".strtolower($key)));
					$info["i_action_edit"] = trim($this->input->post("chk_action_edit_".strtolower($key)));
					$info["i_action_delete"] = trim($this->input->post("chk_action_delete_".strtolower($key)));
                    $info["dt_created_on"]=date("Y-m-d H:i:s");
                    
                    $i_aff=$this->obj_mod->update_access($info,intval($this->input->post("txt_controller_".strtolower($key))));/*don't change*/
                    unset($info,$posted);/*don't change*/
                 	}
				 }
				
				   if($i_aff)////saved successfully/*don't change*/
                    {
                        set_success_msg($this->cls_msg["save_succ"]);/*don't change*/
                        redirect($this->pathtoclass."show_list");/*don't change*/
                    }
                    else///Not saved, show the form again/*don't change*/
                    {
                        
						redirect($this->pathtoclass."show_list");/*don't change*/
                        //set_error_msg($this->cls_msg["save_err"]);/*don't change*/
                    }
            }
            else
            {
                $info=$this->obj_mod->fetch_this(decrypt($i_id));/*don't change*/
				//$access_info=$this->obj_mod->fetch_controller_access(decrypt($i_id));/*don't change*/
				//var_dump($info);exit;
				$posted=array();
                $posted["h_mode"]= $this->data['mode'];/*don't change*/
                $posted["h_id"]= $i_id;/*don't change*/                  
                $posted["txt_user_type"]= trim($info["s_user_type"]);
 
                $this->data["posted"]=$posted;/*don't change*/  
				//$this->data["access_info"]=$access_info;     
                $this->data["access_info"]=$info["access_controll_array"];     
				//var_dump($info["access_controll_array"]);exit;
                unset($info,$posted);/*don't change*/      
            }
            ////////////end Submitted Form///////////
            $this->render($this->router->fetch_class()."/access-control");/*don't change*/
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
   
	public function __destruct()
    {}
}///end of class