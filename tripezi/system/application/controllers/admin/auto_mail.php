<?php
/*********
* Author: Koushik Rout
* Date  : 03 July 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For Automail
* 
* @package Content Management
* @subpackage automail
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/auto_mail_model.php
* @link views/admin/automail/
*/


class Auto_mail extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;   
    public function __construct()
    {            
        try
        {
          parent::__construct();
          $this->data['title']="Automail Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	= "No information found about automail.";
          $this->cls_msg["save_err"]	= "Information about automail failed to save.";
          $this->cls_msg["save_succ"]	= "Information about automail saved successfully.";
          $this->cls_msg["delete_err"]	= "Information about automail failed to remove.";
          $this->cls_msg["delete_succ"]	= "Information about automail removed successfully.";
		  $this->cls_msg["send_err"]	= "automail not delivered.";
          $this->cls_msg["send_succ"]	= "automail delivered successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass 			= admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("auto_mail_model","mod_rect");
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
            $this->data['heading']="Automail";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title=($this->input->post("h_search")?$this->input->post("txt_title"):$this->session->userdata("txt_title")); 
           
            ////////end Getting Posted or session values for search///

            $s_where="";
           
            if($s_search=="advanced")
            {
                $s_where=" WHERE n.s_subject LIKE '%".get_formatted_string($s_title)."%' ";
               
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_title",$s_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]     =   $s_search;
                $this->data["txt_title"]    =   get_unformatted_string($s_title);                
              
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where="";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_title");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]     =   $s_search;
                $this->data["txt_title"]    =   "";                           
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_title);
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
            
            //$this->i_admin_page_limit = 1;
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_multi($s_where,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array();  
			 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Automail";
            $table_view["total_rows"]		= count($info);
			$table_view["total_db_records"]	= $this->mod_rect->gettotal_info($s_where);
			$table_view["detail_view"]      = false;  //   to disable show details. 
                        
             $table_view["headers"][0]["width"]    ="75%";
             $table_view["headers"][0]["align"]    ="left";
             $table_view["headers"][0]["val"]      ="Subject";
			//$table_view["headers"][4]["val"]	="Edit";
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_subject"];

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_table($table_view,TRUE);
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
            $this->data['title']="Edit Automail Details";////Browser Title
            $this->data['heading']="Edit automail";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";	
            $this->data['type']=$type;		

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]		= $this->data['mode'];
				$posted["txt_subject"]	= trim($this->input->post("txt_subject"));
                $posted["ta_content"]	= trim($this->input->post("ta_content"));
                $posted["h_id"]			= trim($this->input->post("h_id"));
                
                $this->form_validation->set_rules('txt_subject', 'automail subject', 'required');
                $this->form_validation->set_rules('ta_content', 'automail description', 'required');
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["s_subject"]			=	$posted["txt_subject"];
                    $info["s_content"]			=	$posted["ta_content"];
					$info["i_status"]			=	1;
                    $info["dt_updated_on"]		=	time();

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
				$posted["txt_subject"]			= $info["s_subject"];
				$posted["ta_content"]			= $info["s_content"];
                $posted['h_mode']               = $this->data['mode'];
				$posted["h_id"]                 = $i_id;

                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("auto_mail/add-edit");
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

	public function __destruct()
    {}

}