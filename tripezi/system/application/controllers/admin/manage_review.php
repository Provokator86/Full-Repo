<?php
/*********
* Author: Mrinmoy Mondal 
* Date  : 25 July 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For Review
* 
* @package User
* @subpackage manage_review
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/property_model.php
* @link views/admin/manage_review/
*/
class Manage_review extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->data['title']="Reviews / Rating";////Browser Title
           
          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	= "No information found about review.";
          $this->cls_msg["save_err"]	= "Information about review failed to save.";
          $this->cls_msg["save_succ"]	= "Information about review saved successfully.";
          $this->cls_msg["delete_err"]	= "Information about review failed to remove.";
          $this->cls_msg["delete_succ"]	= "Information about review removed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
          
          //////// loading default model here //////////////
          $this->load->model("review_model","mod_rect");
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
           
           
            $this->data['heading']="Manage Review & Rating";////Package Name[@package] Panel Heading

            ///////////generating search query///////
            
            ////////Getting Posted or session values for search///
            $arr_session_data    =    $this->session->userdata("arr_session");
            $search_variable     =    array();
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
        
            $search_variable["s_property_name"]	= ($this->input->post("h_search")?$this->input->post("txt_property"):$arr_session_data["txt_property"]); 
            $search_variable["s_reviewer_name"]	= ($this->input->post("h_search")?$this->input->post("txt_name"):
$arr_session_data["txt_name"]); 
			 $search_variable["s_comment"]		= ($this->input->post("h_search")?$this->input->post("txt_comment"):$arr_session_data["txt_comment"]);
            
            $search_variable["dt_from"]        	= ($this->input->post("h_search")?$this->input->post("txt_date_from"):$arr_session_data["txt_date_from"]);
            $search_variable["dt_to"]          	= ($this->input->post("h_search")?$this->input->post("txt_date_to"):$arr_session_data["txt_date_to"]);
           
            ////////end Getting Posted or session values for search///

            $s_where=" WHERE r.i_id!=0 ";
            
            if($s_search=="advanced")
            {
              
                if(trim($search_variable["s_comment"]))
                {
                    $s_where.=" And r.s_comment LIKE '%".get_formatted_string($search_variable["s_comment"])."%' ";
                } 
				if(trim($search_variable["s_property_name"]))
                {
                    $s_where.=" And p.s_property_name LIKE '%".get_formatted_string($search_variable["s_property_name"])."%' ";
                } 
                if(trim($search_variable["s_reviewer_name"]))
                {
                    $s_where.=" And (u.s_first_name LIKE '%".get_formatted_string($search_variable["s_reviewer_name"])."%' OR u.s_last_name LIKE '%".get_formatted_string($search_variable["s_reviewer_name"])."%') ";
                }                
             
                if(trim($search_variable["dt_from"])!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($search_variable["dt_from"]." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( r.dt_created_on , '%Y-%m-%d' ) >='".$dt_start."' ";
                    unset($dt_start);
                }
                if(trim($search_variable["dt_to"])!="")
                {
                    $dt_end=date("Y-m-d",strtotime(trim($search_variable["dt_to"]." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( r.dt_created_on , '%Y-%m-%d' ) <='".$dt_end."' ";
                    unset($dt_start);
                }
               
                
                /////Storing search values into session///
                $arr_session    =   array();  
                $arr_session["txt_property"] 		= $search_variable["s_property_name"] ;  
                $arr_session["txt_name"] 			= $search_variable["s_reviewer_name"] ; 
				$arr_session["txt_comment"] 		= $search_variable["s_comment"] ;  
                $arr_session["txt_date_from"] 		= $search_variable["dt_from"]  ;  
                $arr_session["txt_date_to"] 		= $search_variable["dt_to"]  ;  
                
          
                
                $this->session->set_userdata("arr_session",$arr_session);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]				= $s_search;               
                $this->data["txt_property"]			= get_unformatted_string($search_variable["s_property_name"]);                
                $this->data["txt_name"]				= get_unformatted_string($search_variable["s_reviewer_name"]);  
				$this->data["txt_comment"]			= get_unformatted_string($search_variable["s_comment"]);        
                $this->data["txt_date_from"]		= $search_variable["dt_from"];                
                $this->data["txt_date_to"]			= $search_variable["dt_to"];                
                             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE r.i_id!=0 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("arr_session");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]				= $s_search;
                $this->data["txt_property_name"]	= "";
                $this->data["txt_owner_name"]		= "";
                $this->data["txt_date_from"]		= "";
                $this->data["txt_date_to"]			= "";
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
            $arr_sort = array(1=>'s_comment',2=>'dt_created_on');
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[2]:$arr_sort[2];
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			
            /////////Creating List view for displaying/////////
            $table_view=array(); 
            $order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
                     
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Manage Review & Rating";
            $table_view["total_rows"]=count($info);
            $table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
            $table_view["order_name"]=$order_name;
            $table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method(); 
            $table_view["detail_view"]=false; 
                    
             $table_view["headers"][0]["width"]  ="30%";
             $table_view["headers"][0]["align"]  ="left";
             $table_view["headers"][0]["val"]    ="Proprety Information";
             $table_view["headers"][1]["width"]  ="30%";
			 $table_view["headers"][1]["align"]  ="center";
             $table_view["headers"][1]["val"]    ="Comment";
             $table_view["headers"][2]["width"]  ="10%";
			 $table_view["headers"][2]["align"]  ="center";
             $table_view["headers"][2]["val"]    ="Rating";
			 $table_view["headers"][3]["width"]  ="12%";
             $table_view["headers"][3]["val"]    ="Reviewed by";
             $table_view["headers"][4]["width"]  ="10%";
			 $table_view["headers"][4]["sort"]	= array('field_name'=>encrypt($arr_sort[2]));
             $table_view["headers"][4]["val"]    ="Reviewed on";
            //////end Table Headers, with width,alignment///////
            
           
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $enc_id                                   = encrypt($info[$i]["id"]) ;  
                $table_view["tablerows"][$i][$i_col++]    = $enc_id;////Index 0 must be the encrypted PK 
               
                $table_view["tablerows"][$i][$i_col++]    = "<table><tr><td width=\"30%\">Property ID</td><td>".$info[$i]["s_property_id"]."</td></tr>
                                                                <tr><td width=\"35%\">Property Name</td><td>".$info[$i]["s_property_name"]."</td></tr>
                                                                <tr><td rowspan=\"2\">Location</td><td>".$info[$i]["s_city"].",".$info[$i]["s_state"]."</td></tr>
                                                                <tr><td>".$info[$i]["s_country"].",".$info[$i]["s_zipcode"]."</td></tr></table>";
                                                                
                $table_view["tablerows"][$i][$i_col++]    = $info[$i]["s_comment"];
				$table_view["tablerows"][$i][$i_col++]    = $info[$i]["i_rating"];       
                $table_view["tablerows"][$i][$i_col++]    = $info[$i]["s_reviewer_name"];   
                $table_view["tablerows"][$i][$i_col++]    = $info[$i]["dt_created_on"];
                
                

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
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
        //echo $this->router->fetch_method();exit();
        try
        {
           
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
            $this->data['title']="Edit Review Rating";////Browser Title
            $this->data['heading']="Edit Review Rating";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]		= $this->data['mode'];
				$posted["opt_rating"]	= trim($this->input->post("opt_rating"));
                $posted["ta_comment"]	= trim($this->input->post("ta_comment"));
                $posted["h_id"]			= trim($this->input->post("h_id"));

                //pr($posted,1);
                $this->form_validation->set_rules('opt_rating', 'rating', 'required');
                $this->form_validation->set_rules('ta_comment', 'comment', 'required');
             
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["i_rating"]      	=   $posted["opt_rating"];
                    $info["s_comment"]  	=   $posted["ta_comment"];
                    //pr($info,1);
					
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
				$posted["ta_comment"]	= trim($info["s_comment"]);
				$posted["opt_rating"]	= trim($info["i_rating"]);
				$posted["h_id"]			= $i_id;
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("manage_review/add-edit");
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


    public function __destruct()
    {}
    
    
}