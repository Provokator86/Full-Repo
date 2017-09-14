<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 30 March 2012
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
			
            ////////Getting Posted or session values for search///
            $s_search		= (isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_person_name	= ($this->input->post("h_search")?$this->input->post("txt_person_name"):$this->session->userdata("txt_person_name")); 
            $dt_entry_date	= ($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where="WHERE i_del_status != 2 ";
            if($s_search=="advanced")
            {
				if(trim($s_person_name))
				{
                	$s_where.=" AND n.s_person_name LIKE '%".get_formatted_string($s_person_name)."%' ";
				}	
                if(trim($dt_entry_date)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_entry_date." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.dt_entry_date , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_person_name",$s_person_name);
                $this->session->set_userdata("txt_created_on",$dt_entry_date);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]			=	$s_search;
                $this->data["txt_person_name"]	=	$s_person_name;                
                $this->data["txt_created_on"]	=	$dt_entry_date;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where="WHERE i_del_status != 2 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_person_name");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]			=	$s_search;
                $this->data["txt_person_name"]	=	"";                
                $this->data["txt_created_on"]	=	"";             
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_entry_date);
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
			$arr_sort = array(0=>'s_person_name',2=>'dt_entry_date',3=>'i_status'); 
			$s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[2]:$arr_sort[2];
            
            
            $limit	= $this->i_admin_page_limit;            
			$info	= $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			//pr($info,1);
            /////////Creating List view for displaying/////////
            $table_view=array();  
			$order_name = empty($order_name)?encrypt($arr_sort[2]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]			= "Testimonial";
            $table_view["total_rows"]		= count($info);
			$table_view["total_db_records"]	= $this->mod_rect->gettotal_info($s_where);
			$table_view["order_name"]		= $order_name;
			$table_view["order_by"]  		= $order_by;
            $table_view["src_action"]		= $this->pathtoclass.$this->router->fetch_method(); 
			
                        
            $table_view["headers"][0]["width"]	=	"15%";
            $table_view["headers"][0]["align"]	=	"left";
			$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][0]["val"]	=	"Person Name";
			$table_view["headers"][1]["width"]	=	"45%";
			$table_view["headers"][1]["val"]	=	"Description";
			$table_view["headers"][2]["width"]	=	"20%";
			$table_view["headers"][2]["sort"]	= array('field_name'=>encrypt($arr_sort[2]));
            $table_view["headers"][2]["val"]	=	"Created On"; 
			$table_view["headers"][3]["width"]	=	"8%";
			$table_view["headers"][3]["sort"]	= array('field_name'=>encrypt($arr_sort[3]));
            $table_view["headers"][3]["val"]	=	"Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= 	encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=	$info[$i]["s_person_name"];
				$table_view["tablerows"][$i][$i_col++]	=	$info[$i]["s_content"];
                $table_view["tablerows"][$i][$i_col++]	=	$info[$i]["dt_entry_date"];
                $table_view["tablerows"][$i][$i_col++]	=	$info[$i]["s_is_active"];

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
            $this->data['title']		=	"Testimonial Management";////Browser Title
            $this->data['heading']		=	"Add Testimonial";
            $this->data['pathtoclass']	=	$this->pathtoclass;
			$this->data['action_url']	=	$this->pathtoclass.'add_information';
			
            $this->data['mode']			=	"add";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
				//$posted["opt_language"]			=	trim($this->input->post("opt_language"));
                $posted["txt_person_name"]		= 	trim($this->input->post("txt_person_name"));
				$posted["txt_content"]			= 	trim($this->input->post("txt_content"));
				$posted["opt_test_state"]		=	trim($this->input->post("opt_test_state"));
				
				$i_active_val 					= 	trim($this->input->post("i_is_active"));
                $posted["i_is_active"]			= 	($i_active_val==1)?$i_active_val:2;
			    $posted["h_mode"]				= 	$this->data['mode'];
                $posted["h_id"]					= 	"";
								
             
			   
                $this->form_validation->set_rules('txt_person_name', 'person name', 'required');
                $this->form_validation->set_rules('txt_content', 'testimonial description', 'required');			
				
				
              
                if($this->form_validation->run() == FALSE )/////invalid
                {					
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
					//$info["i_lang_id"]			=	$posted["opt_language"];
                    $info["s_person_name"]		=	$posted["txt_person_name"];
                    $info["s_content"]			=	$posted["txt_content"];                 
					$info["i_status"]			=	$posted["opt_test_state"];
					
                    $info["dt_entry_date"]		=	time();
					
					
					
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
			$this->data['arr_state'] = $this->db->TESTIMONIALSTATE;
            $this->render("testimonial/add-edit");
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
				$posted["txt_person_name"]		= 	trim($this->input->post("txt_person_name"));
				$posted["txt_content"]			= 	trim($this->input->post("txt_content"));
				//$posted["txt_person_email"]		= 	trim($this->input->post("txt_person_email"));
				$posted["opt_test_state"]		=	trim($this->input->post("opt_test_state"));				
				
				$i_active_val 					= 	trim($this->input->post("i_is_active"));
                $posted["h_id"]					= 	trim($this->input->post("h_id"));
				
				
                $this->form_validation->set_rules('txt_person_name', 'person name', 'required');
                $this->form_validation->set_rules('txt_content', 'testimonial description', 'required');
				//$this->form_validation->set_rules('txt_person_email', 'email', 'trim|required|valid_email');
				
				
             
                if($this->form_validation->run() == FALSE )/////invalid
                {					
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					//$info["i_lang_id"]			=	$posted["opt_language"];
					$info["s_person_name"]		=	$posted["txt_person_name"];
                    $info["s_content"]			=	$posted["txt_content"];
					$info["i_status"]			=	decrypt($posted["opt_test_state"]);
                    $info["dt_entry_date"]		=	time();
					
					
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
        {
            if(trim($i_id)!="")
            {
                $info=$this->mod_rect->fetch_this(decrypt($i_id));

                if(!empty($info))
                {
                    $temp=array();
                    $temp["s_id"]				= 	encrypt($info["id"]);////Index 0 must be the encrypted PK 
					$temp["s_person_name"]		=	trim($info["s_person_name"]);
					$temp["s_content"]			=	trim($info["s_content"]);
					$temp["s_person_address"]	=	trim($info["s_person_address"]);
					$temp["s_person_phone"]		=	trim($info["s_person_phone"]);
					$temp["s_person_email"]		=	trim($info["s_person_email"]);
					$temp["s_person_image"]		=	trim($info["s_person_image"]);
					$temp["s_is_active"]		= 	trim($info["s_is_active"]);
					$temp["dt_entry_date"]		= 	trim($info["dt_created_on"]);
					
					$this->data["info"]=$temp;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            
            $this->render("testimonial/show_detail",TRUE);
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
            $posted["id"]= decrypt($this->input->post("h_id"));/*don't change*/
            $posted["duplicate_value"]= htmlspecialchars(trim($this->input->post("h_duplicate_value")),ENT_QUOTES);
			$posted["language_id"] = decrypt($this->input->post("lang_id"));
            
            if($posted["duplicate_value"]!="")
            {
                $qry=" Where ".(intval($posted["id"])>0 ? " n.i_id!=".intval($posted["id"])." And " : "" )
                    ." n.s_content='".$posted["duplicate_value"]."' ";
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
	
	
	
	
	public function __destruct()
    {}
	
	
}
?>