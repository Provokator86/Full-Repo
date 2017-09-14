<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 15 Sep 2011
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  Controller For Faq
* 
* @package Content Management
* @subpackage faq
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/faq_model.php
* @link views/admin/faq/
*/


class How_it_works_tradesman extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public $uploaddir;
	public $allowedExt;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="How It Works Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]="No information found about How It Works.";
          $this->cls_msg["save_err"]="Information about How It Works failed to save.";
          $this->cls_msg["save_succ"]="Information about How It Works saved successfully.";
          $this->cls_msg["delete_err"]="Information about How It Works failed to remove.";
          $this->cls_msg["delete_succ"]="Information about How It Works removed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("how_it_works_tradesman_model","mod_rect");
		  //////// end loading default model here //////////////
		  $this->allowedExt	=	'flv';
		  $this->uploaddir = $this->config->item('admin_faq_video_upload_path');	
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
            $this->data['heading']="How It Works For Professional";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_faq_title=($this->input->post("h_search")?$this->input->post("txt_faq_title"):$this->session->userdata("txt_faq_title")); 
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_deleted!=2 ";
            if($s_search=="basic")
            {
                $s_where.=" AND n.s_basic_content LIKE '%".get_formatted_string($s_faq_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_faq_title",$s_faq_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_faq_title"]=$s_faq_title;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
				if(trim($s_faq_title))
				{
                	$s_where.=" AND n.s_basic_content LIKE '%".get_formatted_string($s_faq_title)."%' ";
				}	
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.dt_entry_date , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_faq_title",$s_faq_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_faq_title"]=$s_faq_title;                
                $this->data["txt_created_on"]=$dt_created_on;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_deleted!=2  ";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_faq_title");
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
            $info	= $this->mod_rect->fetch_multi($s_where,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="How It Works";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
                        
            $table_view["headers"][0]["width"]	="40%";
            $table_view["headers"][0]["align"]	="left";
            $table_view["headers"][0]["val"]	="Basic Content";
            $table_view["headers"][1]["val"]	="Created On"; 
            $table_view["headers"][2]["val"]	="Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_basic_cont_str"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_is_active"];

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
        //echo $this->router->fetch_method();exit();
		try
        {
            $this->data['title']="How It Works Management";////Browser Title
            $this->data['heading']="Add Content";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="add";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
				$posted["opt_language"]					=	trim($this->input->post("opt_language"));
                //$posted["txt_home_content"]				=	trim($this->input->post("txt_home_content"));
				$posted["txt_basic_content"]			= 	trim($this->input->post("txt_basic_content"));
				$posted["txt_search_job_content"]		=	trim($this->input->post("txt_search_job_content"));
				$posted["txt_post_queries_content"]		=	trim($this->input->post("txt_post_queries_content"));
				$posted["txt_quote_on_job_content"]		=	trim($this->input->post("txt_quote_on_job_content"));
				
				
				$i_active_val 					=   trim($this->input->post("i_is_active"));
                $posted["i_is_active"]		= 	($i_active_val==1)?$i_active_val:2;
				//$posted["h_video"]				=	trim($this->input->post("h_video"));
                $posted["h_mode"]				=	$this->data['mode'];
                $posted["h_id"]= "";	
				
                
				$this->form_validation->set_rules('opt_language', 'language', 'required');
				//$this->form_validation->set_rules('txt_home_content', 'home content', 'required');
                $this->form_validation->set_rules('txt_basic_content', ' basic content', 'required');
				$this->form_validation->set_rules('txt_search_job_content', 'search job', 'required');
				$this->form_validation->set_rules('txt_post_queries_content', 'post queries', 'required');
				$this->form_validation->set_rules('txt_quote_on_job_content', 'quote on job', 'required');
				
              	
				$is_data_exist = $this->mod_rect->fetch_data_exist_using_lang_id(decrypt($posted['opt_language']));
				$data_exist_id = $is_data_exist['id'];
				
				
                if($this->form_validation->run() == FALSE )/////invalid
                {
										
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
					$info	=	array();
					$info["i_lang_id"]							=	$posted["opt_language"];
                    //$info["s_home_content"]						=	$posted["txt_home_content"];
					$info["s_basic_content"]					=	$posted["txt_basic_content"];
					$info["s_search_job_content"]				=	$posted["txt_search_job_content"];
					$info["s_post_queries_content"]				=	$posted["txt_post_queries_content"];
					$info["s_quote_on_job_content"]				=	$posted["txt_quote_on_job_content"];
					
                    $info["i_status"]		=	$posted["i_is_active"];
                    $info["dt_entry_date"]	=	strtotime(date("Y-m-d H:i:s"));
					
					
					
					
					if(!$is_data_exist)  //  INSERTING NEW  RECORD
						{
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
						
					else
						{
							 
								$i_aff=$this->mod_rect->edit_info($info,$data_exist_id);
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
								
							
						}
					
                   
                }
            }
            ////////////end Submitted Form///////////
            $this->render("how_it_works_tradesman/add-edit");
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
            $this->data['title']="Edit How It Works Details";////Browser Title
            $this->data['heading']="Edit How It Works For Professional";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]				= 	$this->data['mode'];
				$posted["opt_language"]					=	trim($this->input->post("opt_language"));
                //$posted["txt_home_content"]				=	trim($this->input->post("txt_home_content"));
				$posted["txt_basic_content"]			= 	trim($this->input->post("txt_basic_content"));
				$posted["txt_search_job_content"]		=	trim($this->input->post("txt_search_job_content"));
				$posted["txt_post_queries_content"]		=	trim($this->input->post("txt_post_queries_content"));
				$posted["txt_quote_on_job_content"]		=	trim($this->input->post("txt_quote_on_job_content"));
				//$posted["txt_faq_video"]= trim($this->input->post("txt_faq_video"));
				$i_active_val 					= 	trim($this->input->post("i_is_active"));
                $posted["i_is_active"]		= 	($i_active_val==1)?$i_active_val:2;
                $posted["h_id"]					= 	trim($this->input->post("h_id"));
				
				
                //$this->form_validation->set_rules('opt_language', 'language', 'required');
				//$this->form_validation->set_rules('txt_home_content', 'home content', 'required');
                $this->form_validation->set_rules('txt_basic_content', ' basic content', 'required');
				/*$this->form_validation->set_rules('txt_search_job_content', 'search job', 'required');
				$this->form_validation->set_rules('txt_post_queries_content', 'post queries', 'required');
				$this->form_validation->set_rules('txt_quote_on_job_content', 'quote on job', 'required');*/
				
				//$is_data_exist = $this->mod_rect->fetch_data_exist_using_lang_id(decrypt($posted['opt_language']));
				//$data_exist_id = $is_data_exist['id'];
                
				
				
                if($this->form_validation->run() == FALSE )/////invalid
                {					
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                  
				  	$info	=	array();
					
					$info["i_lang_id"]					=	$posted["opt_language"];
                   //$info["s_home_content"]				=	$posted["txt_home_content"];
					$info["s_basic_content"]			=	$posted["txt_basic_content"];
					$info["s_search_job_content"]		=	$posted["txt_search_job_content"];
					$info["s_post_queries_content"]		=	$posted["txt_post_queries_content"];
					$info["s_quote_on_job_content"]		=	$posted["txt_quote_on_job_content"];
					
                    $info["i_status"]		=	$posted["i_is_active"];
                    $info["dt_entry_date"]	=	strtotime(date("Y-m-d H:i:s"));
					
					/* if(!$is_data_exist)  //  INSERTING NEW  RECORD
						{
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
						}*/
						
							$i_aff=$this->mod_rect->edit_info($info,decrypt($posted["h_id"]	));
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
				//$posted["txt_home_content"]				= trim($info["s_home_content"]);
				$posted["txt_basic_content"]			= trim($info["s_basic_content"]);
				$posted["txt_search_job_content"]		= trim($info["s_search_job_content"]);
				$posted["txt_post_queries_content"]		= trim($info["s_post_queries_content"]);
				$posted["txt_quote_on_job_content"]		= trim($info["s_quote_on_job_content"]);
				
				$posted["opt_language"]  				= encrypt(trim($info["i_lang_id"]));				
				$posted["dt_created_on"]				= trim($info["dt_created_on"]);
				$posted["i_is_active"]					= trim($info["i_is_active"]);
				$posted["h_id"]= $i_id;
				
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("how_it_works_tradesman/add-edit");
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
                    $temp["s_id"]= encrypt($info["id"]);////Index 0 must be the encrypted PK 
					$temp["s_home_content"]= trim($info["s_home_content"]);
					$temp["s_basic_content"]= trim($info["s_basic_content"]);
					$temp["s_faq_cat"]= trim($info["s_faq_cat"]);
					$temp["s_is_active"]= trim($info["s_is_active"]);
					$temp["dt_created_on"]= trim($info["dt_created_on"]);

					$this->data["info"]=$temp;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            
            $this->render("how_it_works_tradesman/show_detail",TRUE);
            unset($i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	
	
	
	function ajax_get_content()
	{
		
		$language_id = $this->input->post("language_id");
		$info = $this->mod_rect->fetch_data_exist_using_lang_id(decrypt($language_id));
		if(!empty($info))
		{
			echo json_encode($info);			
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
            //$posted["duplicate_value"]= htmlspecialchars(trim($this->input->post("h_duplicate_value")),ENT_QUOTES);          
			$posted["duplicate_value"]= decrypt($this->input->post("h_duplicate_value"));          
			
			
            if($posted["duplicate_value"]!="")
            {
                $qry=" Where ".(intval($posted["id"])>0 ? " n.i_id!=".intval($posted["id"])." And " : "" )
                    ." n.i_lang_id='".$posted["duplicate_value"]."' ";
					
				
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