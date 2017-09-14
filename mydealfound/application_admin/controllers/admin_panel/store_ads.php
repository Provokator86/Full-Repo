<?php

/********** 
Author: 
* Date  : 13 May 2014
* Modified By: 
* Modified Date: 
* 
* Purpose:
* Controller For Store_ads
* 
* @package  Master Setting
* @subpackage Store_ads
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/store_ads_model.php
* @link views/admin/Store_ads/
*/


class Store_ads extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
	public $table;
	public $ad_where, $order_ad, $order_by_ad;

	public function __construct()
    {
      try
      {

			parent::__construct();
			$this->data['title']	= "Store Ads Management"; // Browser Title

			$this->data['action_allowed']["Status"]	=FALSE;
			//$this->data['action_allowed']["Add"]	=FALSE;
			//$this->data['action_allowed']["Edit"]	=FALSE;
			//$this->data['action_allowed']["Delete"]	=FALSE;

			// Define Errors Here 
			$this->cls_msg = array();
			$this->cls_msg["no_result"]			= "No information found about store ads.";
			$this->cls_msg["save_err"]			= "Information about  store ads failed to save.";
			$this->cls_msg["save_succ"]			= "Information about  store ads saved successfully.";
			$this->cls_msg["delete_err"]		= "Store ads failed to remove.";
			$this->cls_msg["delete_succ"]		= "Store ads removed successfully.";

			// end Define Errors Here

			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/"; //for redirecting from this class
			$this->load->model('store_ads_model','mod_pay');
			

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
    */

	public function show_list($order_name = '', $order_by = 'desc', $start = NULL, $limit = NULL)
    {
		try
        {           

			$this->data['heading']="Store Ads Management";////Package Name[@package] Panel Heading

            ///////////generating search query///////		

           $arr_session_data    =    $this->session->userdata("arr_session");
            if($arr_session_data['searching_name']!=$this->data['heading'])
            {
                $this->session->unset_userdata("arr_session");
                $arr_session_data   =   array();
            }
            
            $search_variable     =    array();
            
            ////////Getting Posted or session values for search///
            $s_search 	=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
			$search_variable["s_title"] = ($this->input->post("h_search")?$this->input->post("s_title"):$arr_session_data["s_title"]);
			$search_variable["store_name"] = ($this->input->post("h_search")?$this->input->post("store_name"):$arr_session_data["store_name"]);
			$search_variable["date_start"] = ($this->input->post("h_search")?$this->input->post("date_start"):$arr_session_data["date_start"]);
			$search_variable["date_end"] = ($this->input->post("h_search")?$this->input->post("date_end"):$arr_session_data["date_end"]);
		
			

            ////////end Getting Posted or session values for search///

            // $s_where=" WHERE i_user_type=2 ";/////////////////////////
			$s_where=" WHERE 1";
            if($s_search=="basic")
            {
			  	
				if(trim($search_variable["store_name"])!="")
				{
					$s_where.=" AND s.s_store_title LIKE '%".my_receive_text($search_variable["store_name"])."%' ";
				}
				if(trim($search_variable["s_title"])!="")
				{
					$s_where.=" AND n.s_title LIKE '%".my_receive_text($search_variable["s_title"])."%' ";
				}
				if(trim($search_variable["date_start"])!="")
				{
					$dt_start=date("Y-m-d",strtotime(trim($search_variable["date_start"]." "))) ; 
                    $s_where.=" AND DATE( n.dt_entry_date) >='".$dt_start."' ";
                    unset($dt_start);
				}
				if(trim($search_variable["date_end"])!="")
				{
					$dt_end=date("Y-m-d",strtotime(trim($search_variable["date_end"]." "))) ; 
                    $s_where.=" AND DATE( n.dt_entry_date) <='".$dt_end."' ";
                    unset($dt_end);
				}
				
                /////Storing search values into session///

                $arr_session    =   array();                
                $arr_session["searching_name"] 	= $this->data['heading'] ;                  
                $arr_session["s_title"]			= $search_variable["s_title"] ;
				$arr_session["store_name"] 		= $search_variable["store_name"] ;
				$arr_session["date_start"] 	   	= $search_variable["date_start"];
				$arr_session["date_end"] 	    = $search_variable["date_end"];
				
                $this->session->set_userdata("arr_session",$arr_session);
                $this->session->set_userdata("h_search",$s_search);
				
                $this->data["h_search"]	   		= $s_search;
                $this->data["s_title"]	 		= $search_variable["s_title"];            
				$this->data["store_name"]	  	= $search_variable["store_name"]; 
				$this->data["date_start"]  		= $search_variable["date_start"]; 
				$this->data["date_end"]    		= $search_variable["date_end"]; 
                /////end Storing search values into session///
            }
            else////List all records, **not done
            {
                $s_where=" WHERE 1 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("arr_session");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]	   	= $s_search;
                $this->data["s_title"]	= "";       
				$this->data["store_name"]	= "";   
				$this->data["date_start"]  	= ""; 
				$this->data["date_end"]    	= "";  
                /////end Storing search values into session///

            }
           unset($s_search,$arr_session,$search_variable);
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
			$arr_sort = array(0=>'dt_entry_date',1=>'i_is_active');
			$s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
            //$s_order_name="dt_of_payment";
            $limit	= $this->i_admin_page_limit;
			$info	= $this->mod_pay->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			//print_r ($info);

            /////////Creating List view for displaying/////////

			$table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 			          

            //////Table Headers, with width,alignment///////

            $table_view["caption"]     		=	"Store Ads";
            $table_view["total_rows"]		=	count($info);
			$table_view["total_db_records"]	=	$this->mod_pay->gettotal_info($s_where);

			$table_view["order_name"]		=	$order_name;
			$table_view["order_by"]  		=	$order_by;

            $table_view["src_action"]		= 	$this->pathtoclass.$this->router->fetch_method(); 
            $table_view["details_view"]		=   FALSE;          

            $table_view["headers"][0]["width"]	="20%";
            $table_view["headers"][0]["align"]	="left";
			$table_view["headers"][0]["val"]	="Name";
			$table_view["headers"][1]["width"]	="15%";
			$table_view["headers"][1]["val"]	="Store";
			$table_view["headers"][2]["width"]	="15%";
			$table_view["headers"][2]["val"]	="Status";
			$table_view["headers"][3]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][3]["width"]	="12%";
			$table_view["headers"][3]["val"]	="Date";	
            //////end Table Headers, with width,alignment///////

            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
				$status = $info[$i]["i_is_active"]==1?"Active":"Inactive";
				$i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);////Index 0 must be the encrypted PK 

				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_title"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_store_title"];
				$table_view["tablerows"][$i][$i_col++]	= $status;
				$table_view["tablerows"][$i][$i_col++]	= date("Y-m-d",strtotime($info[$i]["dt_entry_date"]));

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit,$action); 
            //$this->data["table_view"]=$this->admin_showin_table($table_view);
			$this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
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

            $this->data['title']="Store Ads Management";////Browser Title
            $this->data['heading']="Add Store Ads";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="add";
            ////////////Submitted Form///////////
            if($_POST)
            {

				$posted=array();
                $posted["s_title"]		= trim($this->input->post("s_title"));	
				$posted["s_html"]		= trim($this->input->post("s_html"));	
				$posted["i_is_active"]	= $this->input->post("i_is_active");	
				$posted["i_store_id"]	= $this->input->post("i_store_id");	
                $posted["h_mode"]			= $this->data['mode'];
                $posted["h_id"]= "";				

                $this->form_validation->set_rules('s_title', 'title', 'required');
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {

                    $info=array();
                    $info["s_title"]		= $posted["s_title"];
                    $info["s_html"]			= $posted["s_html"];
                    $info["i_is_active"]	= $posted["i_is_active"];
                    $info["i_store_id"]		= $posted["i_store_id"];
                    $info["dt_entry_date"]	= now();
					//pr($info,1); i_store_id
                    $i_newid = $this->mod_pay->add_info($info);

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

            $this->render("store_ads/add-edit");

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

    public function modify_information($i_id = 0)
    {          

        try
        {

            $this->data['title']		="Edit Automail Details";////Browser Title
            $this->data['heading']		="Edit automail";
            $this->data['pathtoclass']	=$this->pathtoclass;
            $this->data['mode']			="edit";	
            //$this->data['type']			=$type;		

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["s_title"]		= trim($this->input->post("s_title"));	
				$posted["s_html"]		= trim($this->input->post("s_html"));	
				$posted["i_is_active"]	= $this->input->post("i_is_active");	
				$posted["i_store_id"]	= $this->input->post("i_store_id");	
                $posted["h_mode"]		= $this->data['mode'];
                $posted["h_id"]			= trim($this->input->post("h_id"));	

                $this->form_validation->set_rules('s_title', 'title', 'required');
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {

                    $info=array();
                    $info["s_title"]		= $posted["s_title"];
                    $info["s_html"]			= $posted["s_html"];
                    $info["i_is_active"]	= $posted["i_is_active"];
                    $info["i_store_id"]		= $posted["i_store_id"];
                    $info["dt_entry_date"]	= now();
					//pr($info,1); i_store_id
                    $i_aff=$this->mod_pay->edit_info($info,decrypt($posted["h_id"]));

                    if($i_aff)////saved successfully
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

            else
            {	
                $tmp=$this->mod_pay->fetch_this(decrypt($i_id));////////
				$info = $tmp[0];
				
                $posted=array();

				$posted["s_title"]				= trim($info["s_title"]);
				$posted["s_html"]				= trim($info["s_html"]);
				$posted["i_is_active"]			= trim($info["i_is_active"]);
				$posted["i_store_id"]			= trim($info["i_store_id"]);
                $posted['h_mode']               = $this->data['mode'];
				$posted["h_id"]= $i_id;

                $this->data["posted"]			= $posted;    
                unset($info,$posted);   
            }
            ////////////end Submitted Form///////////
            $this->render("store_ads/add-edit");

        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }  
	}

    

	/***
    * Shows details of a single record.
    * @param int $i_id, Primary key
    */
    public function show_detail($i_id=0)
    {}

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
							$i_ret_=$this->mod_pay->delete_info(-1);
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
									$i_ret_=$this->mod_pay->delete_info(decrypt($id[$tot]));	
									$tot--;
								}

							}

							elseif($id>0)///Deleting single Records
							{
								$i_ret_=$this->mod_pay->delete_info(decrypt($id));
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


	public function __destruct()

    {}

}