<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 18 Jan 2013
* Modified By: 
* Modified Date:  
* Purpose:
*  Controller For city
* @package Genral
* @subpackage City
* @link InfController.php 
* @link My_Controller.php
* @link model/city_model.php
* @link views/admin/city/
*/


class manage_category extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="City Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	=	"No information found about city.";
          $this->cls_msg["save_err"]	=	"Information about city failed to save.";
          $this->cls_msg["save_succ"]	=	"Information about city saved successfully.";
          $this->cls_msg["delete_err"]	=	"Information about city failed to remove.";
          $this->cls_msg["delete_succ"]	=	"Information about city removed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass 			= 	admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("city_model","mod_rect");
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
            $this->data['heading']="City";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			$arr_session_data    =    $this->session->userdata("arr_session");
			
			if($arr_session_data['searching_name']!=$this->data['heading'])
            {
                $this->session->unset_userdata("arr_session");
                $arr_session_data   =   array();
            }
			
			$search_variable     =    array();
			
			
            ////////Getting Posted or session values for search///
            $s_search 						=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $search_variable["s_city"]	  	=($this->input->post("h_search")?$this->input->post("txt_city"):$arr_session_data["txt_city"]);  
			$search_variable["s_state"]		=($this->input->post("h_search")?$this->input->post("opt_state"):$arr_session_data["opt_state"]);
			$search_variable["s_country"]  	=($this->input->post("h_search")?$this->input->post("opt_country"):$arr_session_data["opt_country"]);    
			
			////////end Getting Posted or session values for search///
            
            $s_where=" WHERE c.i_status!=2 ";
           
            if($s_search=="advanced")
            {
				if($search_variable["s_city"])
				{
                	$s_where.=" AND c.s_city LIKE '%".my_receive_text($search_variable["s_city"])."%' ";
				}
				if(decrypt($search_variable["s_country"]))
				{
                	$s_where.=" AND c.i_country_id =".decrypt($search_variable["s_country"])." ";
				}
				if(decrypt($search_variable["s_state"]))
				{
                	$s_where.=" AND c.i_state_id =".decrypt($search_variable["s_state"])." ";
				}
				

                /////Storing search values into session///
				$arr_session    =   array();
                
                $arr_session["searching_name"]  = $this->data['heading'] ;                  
                $arr_session["txt_city"] 		= $search_variable["s_city"] ;
				$arr_session["opt_state"] 		= $search_variable["s_state"] ;
				$arr_session["opt_country"] 	= $search_variable["s_country"] ;
				
				
				$this->session->set_userdata("arr_session",$arr_session);                			
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]		= $s_search;
                $this->data["txt_city"]		= $search_variable["s_city"]; 
				$this->data["opt_state"]	= $search_variable["s_state"];  
				$this->data["opt_country"]	= $search_variable["s_country"];           
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE c.i_status!=2 ";
                /////Releasing search values from session///
				$this->session->unset_userdata("arr_session");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]		= $s_search;
                $this->data["txt_city"]		= "";  
				$this->data["opt_state"]	= "";                    
				$this->data["opt_country"]	= "";                    
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_city,$dt_created_on);
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
			$arr_sort 		= array(0=>'s_city'); 
			$s_order_name 	= !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];          
            $limit			= $this->i_admin_page_limit;
			$info			= $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			
            /////////Creating List view for displaying/////////
            $table_view		= array();  
			$order_name 	= empty($order_name)?encrypt($arr_sort[0]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]				= "City";
            $table_view["total_rows"]			= count($info);
			$table_view["total_db_records"]		= $this->mod_rect->gettotal_info($s_where);
			$table_view["order_name"]			= $order_name;
			$table_view["order_by"]  			= $order_by;
            $table_view["src_action"]			= $this->pathtoclass.$this->router->fetch_method(); 
			$table_view["detail_view"]  		= false;
                        
            $table_view["headers"][0]["width"]	= "30%";
            $table_view["headers"][0]["align"]	= "left";
			//$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][0]["val"]	= "City Name";
			$table_view["headers"][1]["val"]	= "State Name";
			$table_view["headers"][2]["val"]	= "Country Name";
			$table_view["headers"][3]["val"]	= "Status";
 
			
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_city"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_state"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_country"];
                $table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_status"];
				
            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit);
            
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
            $this->data['title']="City Management";////Browser Title
            $this->data['heading']="Add City";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="add";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["txt_city"]			= trim($this->input->post("txt_city"));
				$posted["opt_country"]		= trim($this->input->post("opt_country"));
				$posted["opt_state"]		= trim($this->input->post("opt_state"));				
                $posted["h_mode"]			= $this->data['mode'];
                $posted["h_id"]= "";
				
				
               
			    $this->form_validation->set_rules('opt_country', 'country name', 'required');
				$this->form_validation->set_rules('opt_state', 'state name', 'required');
                $this->form_validation->set_rules('txt_city', 'city name', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
                    $info["s_city"]			= $posted["txt_city"];
                    $info["i_country_id"]	= decrypt($posted["opt_country"]);
					$info["i_state_id"]		= decrypt($posted["opt_state"]);
					
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
            $this->render("city/add-edit");
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
            $this->data['title']="Edit City Details";////Browser Title
            $this->data['heading']="Edit City";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]		= $this->data['mode'];
				$posted["txt_city"]		= trim($this->input->post("txt_city"));
				$posted["opt_country"]	= trim($this->input->post("opt_country"));
				$posted["opt_state"]	= trim($this->input->post("opt_state"));
                $posted["h_id"]			= trim($this->input->post("h_id"));
				
				
                $this->form_validation->set_rules('opt_country', 'country name', 'required');
				$this->form_validation->set_rules('opt_state', 'state name', 'required');
                $this->form_validation->set_rules('txt_city', 'city name', 'required');

                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["s_city"]			= $posted["txt_city"];
                    $info["i_country_id"]	= decrypt($posted["opt_country"]);
					$info["i_state_id"]		= decrypt($posted["opt_state"]);

                    //print_r($info); exit;
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
				
				$posted["txt_city"]  		= trim($info["s_city"]);
				$posted["opt_country"]		= encrypt($info["i_country_id"]);
				$posted["opt_state"]		= encrypt($info["i_state_id"]);
				$posted["h_id"]             = $i_id;
				$posted["i_id"]			    = decrypt($i_id);
                $this->data["posted"]		= $posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("city/add-edit");
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
                    $temp["s_id"]		= encrypt($info["id"]);////Index 0 must be the encrypted PK 
					$temp["s_city"]		= trim($info["s_city"]);
					$temp["s_country"]	= trim($info["s_country"]);
					$temp["s_state"]	= trim($info["s_state"]);	
					$temp["s_status"]	= trim($info["s_status"]);

					$this->data["info"]=$temp;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            
            $this->render("city/show_detail",TRUE);
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
            $posted["duplicate_value"]	= my_receive_text($this->input->post("h_duplicate_value"));
			$posted["i_country_id"]		= decrypt($this->input->post("i_country_id"));
			$posted["i_state_id"]		= decrypt($this->input->post("i_state_id"));
			
						
            if($posted["duplicate_value"]!="")
            {
                $qry=" WHERE ".(intval($posted["id"])>0 ? " c.i_id!=".intval($posted["id"])." And " : "" )
                    ." c.s_city='".$posted["duplicate_value"]."' AND c.i_country_id=".$posted["i_country_id"]." AND c.i_state_id = ".$posted["i_state_id"] ;
                
				$info=$this->mod_rect->fetch_multi($qry); /*don't change*/
				
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
    * Change status of the city 
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
			$i_rect				= $this->mod_common->common_edit_info($this->db->CITY,$info,$arr_where); /*don't change*/                
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