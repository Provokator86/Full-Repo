<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 06 July 2012
* Modified By: 
* Modified Date: 
* 
* Purpose:
* Controller For Testimonial
* 
* @package Content Management
* @subpackage Testimonial
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/testimonial_model.php
* @link views/admin/testimonial/
*/


class Testimonial extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']				=	"Testimonial Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]		=	"No information found about testimonial.";
          $this->cls_msg["save_err"]		=	"Information about testimonial failed to save.";
          $this->cls_msg["save_succ"]		=	"Information about testimonial saved successfully.";
          $this->cls_msg["delete_err"]		=	"Information about testimonial failed to remove.";
          $this->cls_msg["delete_succ"]		=	"Information about testimonial removed successfully.";
          ////////end Define Errors Here//////
		  
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("testimonial_model","mod_rect");
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
    public function show_list($order_name='',$order_by='desc',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Testimonial";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			$arr_session_data    =    $this->session->userdata("arr_session");
			$search_variable     =    array();
			
			
            ////////Getting Posted or session values for search///
            $s_search		= (isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $search_variable["s_name"]= ($this->input->post("h_search")?$this->input->post("txt_name"):$arr_session_data["txt_name"]);
            $search_variable["dt_created_on"]= ($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where="WHERE n.i_status != 2 ";
            if($s_search=="advanced")
            {
				if(trim($search_variable["s_name"]))
				{
                	$s_where.=" AND u.s_first_name LIKE '%".get_formatted_string($search_variable["s_name"])."%' ";
				}	
                if(trim($search_variable["dt_created_on"])!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($search_variable["dt_created_on"]." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.dt_created_on , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
				$arr_session	=	array();
				$arr_session["txt_name"]		=	$search_variable["s_name"];
				$arr_session["txt_created_on"]	=	$search_variable["dt_created_on"];
				
                $this->session->set_userdata('arr_session',$arr_session);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]			=	$s_search;
                $this->data["txt_name"]			=	$search_variable["s_name"];                
                $this->data["txt_created_on"]	=	$search_variable["dt_created_on"];             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where="WHERE n.i_status != 2 ";
                /////Releasing search values from session///
               $this->session->unset_userdata("arr_session");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]			=	$s_search;
                $this->data["txt_name"]			=	"";                
                $this->data["txt_created_on"]	=	"";             
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$search_variable);
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
			$arr_sort = array(0=>'dt_created_on'); 
			$s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
            
            
            $limit	= $this->i_admin_page_limit;            
			$info	= $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			//pr($info,1);
            /////////Creating List view for displaying/////////
            $table_view=array();  
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]			= "Testimonial";
            $table_view["total_rows"]		= count($info);
			$table_view["total_db_records"]	= $this->mod_rect->gettotal_info($s_where);
			$table_view["order_name"]		= $order_name;
			$table_view["order_by"]  		= $order_by;
			$table_view["detail_view"]  	= false;
            $table_view["src_action"]		= $this->pathtoclass.$this->router->fetch_method(); 
			
                        
            $table_view["headers"][0]["width"]	=	"15%";
            $table_view["headers"][0]["align"]	=	"left";
            $table_view["headers"][0]["val"]	=	"Name";
			$table_view["headers"][1]["width"]	=	"45%";
			$table_view["headers"][1]["val"]	=	"Description";
			$table_view["headers"][2]["width"]	=	"20%";
			$table_view["headers"][2]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][2]["val"]	=	"Created On"; 
			$table_view["headers"][3]["width"]	=	"8%";
            $table_view["headers"][3]["val"]	=	"Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= 	encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=	$info[$i]["s_full_name"];
				$table_view["tablerows"][$i][$i_col++]	=	$info[$i]["s_content"];
                $table_view["tablerows"][$i][$i_col++]	=	$info[$i]["dt_created_on"];
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
        {}
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
            $this->data['title']		=	"Edit Testimonial Details";////Browser Title
            $this->data['heading']		=	"Edit Testimonial";
            $this->data['pathtoclass']	=	$this->pathtoclass;
			$this->data['action_url']	=	$this->pathtoclass.'modify_information';
            $this->data['mode']			=	"edit";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]				= 	$this->data['mode'];
				//$posted["txt_person_name"]		= 	trim($this->input->post("txt_person_name"));
				$posted["txt_content"]			= 	trim($this->input->post("txt_content"));
                $posted["h_id"]					= 	trim($this->input->post("h_id"));
				
				
                $this->form_validation->set_rules('txt_content', 'testimonial description', 'required');				
				
             
                if($this->form_validation->run() == FALSE )/////invalid
                {					
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					
                    $info["s_content"]			=	$posted["txt_content"];
					
					
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
				//$posted["opt_language"]  		=   trim($info["i_lang_id"]);
				$posted["txt_person_name"]		=	trim($info["s_person_name"]);
				$posted["txt_content"]			=	trim($info["s_content"]);				
				$posted["opt_test_state"]		=	encrypt($info["i_is_active"]);	
				
				$posted["h_id"]					= 	$i_id;
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
			$this->data['arr_state'] = $this->db->TESTIMONIALSTATE;
            $this->render("testimonial/add-edit");
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
        {}
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
        {}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }    
	
	/***
    * Change status of the testimonial 
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
			$i_rect				= $this->mod_common->common_edit_info($this->db->TESTIMONIALS,$info,$arr_where); /*don't change*/                
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