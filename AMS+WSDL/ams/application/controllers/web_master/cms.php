<?php
/*********
* Author: Mrinmoy MOndal
* Date  : 03 Feb 2014* * Purpose:
*  Controller For Manage admin user
* 
* @package General
* @subpackage Manage admin user
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/site_model.php
* @link views/admin/Manage_admin_user/
*/

class Cms extends MY_Controller
{
    public $cls_msg;//All defined error messages. 
    public $pathtoclass, $tbl, $tbl_menu_pg;   
    public function __construct()
    {            
        try
        {
			parent::__construct();
			$this->data['title']= addslashes("Content Management");//Browser Title
			
			//Define Errors Here//
			$this->cls_msg = array();
			
			$this->cls_msg["no_result"]			= get_message('no_result');
			$this->cls_msg["save_failed"]		= get_message('save_failed');
			$this->cls_msg["save_success"]	= get_message('save_success');
			$this->cls_msg["del_failed"]		= get_message('del_failed');
			$this->cls_msg["del_success"]		= get_message('del_success');
			
			//end Define Errors Here//
			$this->pathtoclass 			= admin_base_url().$this->router->fetch_class()."/";
			//pr($this->admin_loggedin);
			// loading default model here //
			#$this->load->model("customer_model","mod_rect");
			$this->load->model("user_type_model","mod_utype");
			// end loading default model here //
			
			$this->load->model("cms_model","mod_cms");
            $this->tbl = $this->db->CMS;
			$this->tbl_menu_pg = $this->db->MENU_PAGE;
			
			$this->data['BREADCRUMB']	=	array( addslashes('Manage Content'));

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
    public function show_list($order_by = '', $sort_type = 'desc',$start = NULL, $limit = NULL)
    {
        try
		{
			$this->data['heading'] = addslashes("Manage CMS");//Package Name[@package] Panel Heading
			
			//generating search query//
			$arr_session_data    =    $this->session->userdata("arr_session");
			if($arr_session_data['searching_name'] != $this->data['heading'])
			{
				$this->session->unset_userdata("arr_session");
				$arr_session_data   =   array();
			}
			$search_variable     =    array();
			
			//Getting Posted or session values for search//        
			$s_search 	=(isset($_GET["h_search"])?$this->input->get("h_search"):$this->session->userdata("h_search"));
			$search_variable["s_title"] = ($this->input->get("h_search")?$this->input->get("s_title"):$arr_session_data["s_title"]);
            $search_variable["dt_from"]= ($this->input->get("h_search")?$this->input->get("dt_from"):$arr_session_data["dt_from"]);
            $search_variable["dt_to"]= ($this->input->get("h_search")?$this->input->get("dt_to"):$arr_session_data["dt_to"]);
			//end Getting Posted or session values for search//            
			$s_where = " n.i_id !=0 AND n.i_cms_type IN(1,2) ";
			
			if($s_search=="advanced")
			{
				if($search_variable["s_title"]!="")
				{
					$s_where .= " AND n.s_title LIKE '%".addslashes($search_variable["s_title"])."%' ";
				}
                if($search_variable["dt_from"] != '' && $search_variable["dt_to"] !='')
                {
                    $s_where .= ' AND (DATE_FORMAT(n.dt_published_on, "%Y-%m-%d") >="'.make_db_date($search_variable["dt_from"]).'" AND DATE_FORMAT(n.dt_published_on, "%Y-%m-%d") <= "'.make_db_date($search_variable["dt_to"]).'") ';
                }
                else if($search_variable["dt_from"] != '')
                    $s_where .= ' AND DATE_FORMAT(n.dt_published_on, "%Y-%m-%d") >="'.make_db_date($search_variable["dt_from"]).'" ';
                else if($search_variable["dt_to"] != '')
                    $s_where .= ' AND DATE_FORMAT(n.dt_published_on, "%Y-%m-%d") <= "'.make_db_date($search_variable["dt_to"]).'" ';
				                
				$arr_session    =   array();                
				$arr_session["searching_name"] = $this->data['heading'] ;        
                $arr_session["s_title"] = $search_variable["s_title"] ;
                $arr_session["dt_from"] = $search_variable["dt_from"] ;
				$arr_session["dt_to"] = $search_variable["dt_to"] ;
				$this->session->set_userdata("arr_session",$arr_session);
				$this->session->set_userdata("h_search",$s_search);
				$this->data["h_search"] = $s_search;
                $this->data["s_title"]     = $search_variable["s_title"];                
                $this->data["dt_from"]     = $search_variable["dt_from"];                
				$this->data["dt_to"] 	= $search_variable["dt_to"];                
			}
			else//List all records, **not done
			{
				//$s_where = " n.i_id !=0 AND n.i_cms_type=1 ";
				//Releasing search values from session//
				$this->session->unset_userdata("arr_session");
				$this->session->unset_userdata("h_search");
				
				$this->data["h_search"]		= $s_search;
                $this->data["s_title"]     = "";                            
                $this->data["dt_from"]     = "";                            
				$this->data["dt_to"] 	= "";                            
				//end Storing search values into session//                 
			}
			unset($s_search,$arr_session,$search_variable);
			//Setting Limits, If searched then start from 0//
            $i_uri_seg = 6;
            $start = $this->input->post("h_search") ? 0 : $this->uri->segment($i_uri_seg);
			//end generating search query//
			// List of fields for sorting
            $arr_sort = array('0'=>'n.dt_created_on');   
            $order_by =!empty($order_by)?in_array(decrypt($order_by),$arr_sort)?decrypt($order_by):$arr_sort[0]:$arr_sort[0];
            
			//$this->i_admin_page_limit = 1;
			$limit	= $this->i_admin_page_limit;
            #$info    = $this->mod_cms->fetch_multi($s_where, intval($start),$limit);
			$s_where .= " ORDER BY $order_by $sort_type"; 
            $info = $this->acs_model->fetch_data($this->tbl.' AS n', $s_where, '', intval($start), $limit);
            $total = $this->acs_model->count_info($this->tbl.' AS n', $s_where, 'n.');
            
			//Creating List view for displaying//
			$table_view=array();  
			
			//Table Headers, with width,alignment//
			$table_view["caption"]				= addslashes("Manage Content");
			$table_view["total_rows"]		  	= count($info);
            #$table_view["total_db_records"]    = $this->mod_cms->gettotal_info($s_where);
			$table_view["total_db_records"]		= $total;
			$table_view["detail_view"]         	= false;  //   to disable show details. 
            $table_view["order_name"]           = encrypt($order_by);
            $table_view["order_by"]             = $sort_type;
            $table_view["src_action"]           = $this->pathtoclass.$this->router->fetch_method();
            
			$j = 0;
			$table_view["headers"][$j]["width"]		="15%";
			$table_view["headers"][$j]["align"]		="left";
			$table_view["headers"][$j]["val"]		= addslashes("Title");
			
			$table_view["headers"][++$j]["val"]		= addslashes("Description");
			$table_view["headers"][$j]["width"]		= "35%";
			$table_view["headers"][$j]["align"]		= "left";
            
            $table_view["headers"][++$j]["val"]     = addslashes("Date Added");
            $table_view["headers"][$j]["width"]     = "18%";
            $table_view["headers"][$j]["align"]     = "left";
            
            $table_view["headers"][++$j]["val"]     = addslashes("Date Published");
            $table_view["headers"][$j]["width"]     = "18%";
            $table_view["headers"][$j]["align"]     = "left";
			
			
			//end Table Headers, with width,alignment//
			
			//Table Data//
			for($i=0; $i<$table_view["total_rows"]; $i++)
			{
				$i_col=0;
				$table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_title"];
                $table_view["tablerows"][$i][$i_col++]  = string_part($info[$i]["s_description"],200);
                $table_view["tablerows"][$i][$i_col++]    = ($info[$i]["dt_created_on"] && $info[$i]["dt_created_on"]!='0000-00-00 00:00:00')?admin_date($info[$i]["dt_created_on"]):"N/A";
				$table_view["tablerows"][$i][$i_col++]	= ($info[$i]["dt_published_on"] && $info[$i]["dt_published_on"]!='0000-00-00 00:00:00')?admin_date($info[$i]["dt_published_on"]):"N/A";
				
				$action ='';
				if($info[$i]["e_status"] =='Published')
				{
                    $action .='&nbsp;<a class="btn btn-sm btn-default" href="javascript:void(0);">Published</a>';
				}
				else
				{    
                    $action .='&nbsp;<a title="Publish Content" class="btn btn-mini btn-success" id="publish_id_'.$info[$i]["i_id"].'" href="javascript:void(0);"><i class=" fa-arrow-circle-right icon-white"></i></a>';  
				}
				
				if($action!='')
				{
					$table_view["rows_action"][$i] = $action;     
				}
			} 
			//end Table Data//
			unset($i,$i_col,$start,$limit); 
			
			#$this->data["table_view"] = $this->admin_showin_table($table_view,TRUE);            
            $this->data['total_record'] = $table_view["total_db_records"];
            $this->data["table_view"] = $this->admin_showin_order_table($table_view,TRUE);            
			//Creating List view for displaying//
			$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();//used for search form action
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
       
        //echo $this->router->fetch_method();exit();
		try
        {
            
            $this->data['title']= addslashes("Add Content");//Browser Title
            $this->data['heading']= addslashes("Add Information");
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['BREADCRUMB']    =    array( addslashes('Add Information'));
            $this->data['mode']="add";    
            
            //Submitted Form//
            if($_POST)
            {
               
                $posted = array();
                $posted["s_title"]          = $this->input->post("s_title", true);
                $posted["s_description"]    = $this->input->post("s_description");
                $posted["i_parent_id"]      = $this->input->post("i_parent_id", true);
                
                $posted["s_summary"]        = $this->input->post("s_summary", true);
                $posted["s_url"]            = $this->input->post("s_url", true);
                #$posted["s_keywords"]       = $this->input->post("s_keywords", true);
                $posted["s_redirect_url"]   = $this->input->post("s_redirect_url");
                $posted["s_meta_title"]     = $this->input->post("s_meta_title", true);
                $posted["s_meta_keyword"]   = $this->input->post("s_meta_keyword", true);
                $posted["s_meta_description"] = $this->input->post("s_meta_description", true);
                $posted["s_additional_page"]= $this->input->post("s_additional_page", true);
                $posted["e_status"]         = $this->input->post("e_status", true);
                if($posted["e_status"]=='Published')                
                    $posted['dt_published_on'] = now();
                
                $this->form_validation->set_rules('s_title', addslashes('title'), 'required|xss_clean');
                $this->form_validation->set_rules('s_description', addslashes('description'), 'required|xss_clean');
                $this->form_validation->set_rules('i_parent_id', addslashes('parent'), 'required|xss_clean');
                $this->form_validation->set_rules('s_url', addslashes('url'), 'required');
                $this->form_validation->set_rules('s_meta_title', addslashes('meta title'), 'required');
                
                
                if($this->form_validation->run() == FALSE)//invalid
                {                    
                    //Display the add form with posted values within it//
                    $this->data["posted"] = $posted;
                }
                else//validated, now save into DB
                {
                    $info = array();
                    $posted['dt_created_on'] = now();
                    $posted["i_cms_type"] = 1;
                    if($posted["i_parent_id"]>0)
						$posted["i_cms_type"] = 1;
                    $info = $posted;
                    /*$info["s_title"]        = $posted['s_title'];
                    $info["s_description"]  = $posted['s_description'];
                    $info["i_parent_id"]    = $posted['i_parent_id'];*/ 
                    $i_newid = $this->acs_model->add_data($this->tbl,$info);
                    if($i_newid)//saved successfully
                    {
                        set_success_msg(get_message("save_success"));
                        redirect($this->pathtoclass."show_list");
                        //redirect($this->pathtoclass."modify_information/".encrypt($i_newid));
                    }
                    else//Not saved, show the form again
                    {
                        $this->data["posted"]=$posted;
                        set_error_msg(get_message('save_failed'));
                    }
                    unset($info,$posted, $i_newid);
                }
            }    
            
            $this->render("cms/add-edit"); 
            
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
			$this->data['title']= addslashes("Edit Content");//Browser Title
            $this->data['heading']= addslashes("Edit Information");
            $this->data['pathtoclass']=$this->pathtoclass;
			$this->data['BREADCRUMB']	=	array( addslashes('Edit Information'));
            $this->data['mode']="edit";	
            
            //Submitted Form//
            if($_POST)
            {
				 //pr($_POST,1);
                 
                 
                  
                   
                 
				$posted = array();
                $posted["s_title"]	        = $this->input->post("s_title", true);
				$posted["s_description"]    = $this->input->post("s_description");
                $posted["i_parent_id"]      = $this->input->post("i_parent_id", true); 
				$posted["h_id"]	            = $this->input->post("h_id", true);
                
                $posted["s_summary"]        = $this->input->post("s_summary", true);
                $posted["s_url"]            = $this->input->post("s_url", true);
                #$posted["s_keywords"]       = $this->input->post("s_keywords", true);
                $posted["s_redirect_url"]   = $this->input->post("s_redirect_url");
                $posted["s_meta_title"]     = $this->input->post("s_meta_title", true);
                $posted["s_meta_keyword"]   = $this->input->post("s_meta_keyword", true);
                $posted["s_meta_description"] = $this->input->post("s_meta_description", true);
                $posted["s_additional_page"]= $this->input->post("s_additional_page", true);
                $posted["e_status"]         = $this->input->post("e_status", true);
                if($posted["e_status"]=='Draft')                
                    $posted['dt_published_on'] = '0000-00-00 00:00:00';
                    
                    
                $posted["s_parent_url"] = "";                   
                if ($posted["i_parent_id"] != 'Root')
                 {                     
                     $data_parent = $this->acs_model->fetch_data($this->db->CMS,array('i_id'=>"'".$posted['i_parent_id']."'"),'s_url',NULL,NULL,'','');
                     //pr($data_parent,1); 
                     $posted["s_parent_url"] = $data_parent[0]['s_url'];
                 }    
                
				
				$this->form_validation->set_rules('s_title', addslashes('title'), 'required|xss_clean');
				$this->form_validation->set_rules('s_description', addslashes('description'), 'required|xss_clean');
                $this->form_validation->set_rules('i_parent_id', addslashes('parent'), 'required|xss_clean');
                $this->form_validation->set_rules('s_url', addslashes('url'), 'required');
                $this->form_validation->set_rules('s_meta_title', addslashes('meta title'), 'required');
				
				
                if($this->form_validation->run() == FALSE)//invalid
                {					
                    //Display the add form with posted values within it//
                    $this->data["posted"] = $posted;
                }
                else//validated, now save into DB
                {                    
                    $info = array();
                    $h_id = decrypt($posted["h_id"]); unset($posted["h_id"]);
                    if($posted["i_parent_id"]>0)
						$posted["i_cms_type"] = 1;
                    $info = $posted;
                    
                    $i_aff = $this->acs_model->edit_data($this->tbl,$info,array('i_id'=>$h_id));
                    if($i_aff)//saved successfully
                    {
                        set_success_msg(get_message("save_success"));
                        redirect($this->pathtoclass."show_list");
                    }
                    else//Not saved, show the form again
                    {
                        $posted['h_id'] = encrypt($h_id);
                        $this->data["posted"]=$posted;
                        set_error_msg(get_message('save_failed'));
                    }
                    unset($info,$posted, $i_aff);
                }
            }
            else
            {	
                $info = $this->mod_cms->fetch_this(decrypt($i_id));
				$posted = $info[0];
                // new code on 14 Oct, 2015: fetch parent id from menu page tbl                
                $pg =$this->acs_model->fetch_data($this->tbl_menu_pg,array('page_id'=>decrypt($i_id)),'i_parent_id','',1);
                $parent_id = $pg[0]['i_parent_id']?$pg[0]['i_parent_id']:0;                
                if($parent_id)
                {
                    $mnu_pg =$this->acs_model->fetch_data($this->tbl_menu_pg,array('i_id'=>$parent_id),'page_id','',1);
                    $i_parent_id = $mnu_pg[0]['page_id']?$mnu_pg[0]['page_id']:0;
                }
                $posted['i_parent_id'] = $i_parent_id?$i_parent_id:$posted['i_parent_id'];
                // new code on 14 Oct, 2015: fetch parent id from menu page tbl end              
                
                $posted['h_mode'] = $this->data['mode'];
				$posted["h_id"] = $i_id;
                $this->data["posted"] = $posted;       
                unset($info,$posted);      
            }
            //end Submitted Form//
			// Get all the user type
			//$this->data['user_type'] = $this->mod_utype->get_all_user_type();
            $this->render("cms/add-edit");
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
			echo $i_id;
			exit;
            $i_ret_=0;
            $pageno=$this->input->post("h_pageno");//the pagination page no, to return at the same page
            
            //Deleting What?//
            $s_del_these=$this->input->post("h_list");
            switch($s_del_these)
			{
				case "all":
							$i_ret_=$this->mod_rect->delete_info(-1);
							break;
				default: 		//Deleting selected,page //
							//First consider the posted ids, if found then take $i_id value//
							$id=(!$i_id?$this->input->post("chk_del"):$i_id);//may be an array of IDs or single id
							if(is_array($id) && !empty($id))//Deleting Multi Records
							{
								//Deleting Information//
								$tot=count($id)-1;
								while($tot>=0)
								{
									$i_ret_=$this->mod_rect->delete_info(decrypt($id[$tot]));
									$tot--;
								}
							}
							elseif($id>0)//Deleting single Records
							{
								$i_ret_=$this->mod_rect->delete_info(decrypt($id));
							}                
							break;
			}
            unset($s_del_these, $id, $tot);
            
            if($i_ret_)
            {
                set_success_msg(get_message("del_success"));
            }
            else
            {
                set_error_msg(get_message("del_failed"));
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
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	 
	public function ajax_remove_information()
    {
        try
        {
			$i_id = decrypt($this->input->post("temp_id"));
			$i_rect	= $this->mod_rect->delete_info($i_id); /*don't change*/                
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
	 
	public function ajax_change_status()
    {
        try
        {
			$h_id       = trim($this->input->post("h_id"));
			$s_status   = trim($this->input->post("s_status"));
			$info = array();
            $info['e_status']        = $s_status;
			$info['dt_published_on'] = now();
            
            if($this->acs_model->edit_data($this->tbl, $info, array('i_id' => $h_id)))
                echo 'ok';
            else
                echo 'error';
            
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
