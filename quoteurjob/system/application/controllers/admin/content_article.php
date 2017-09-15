<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 20 Aug 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
* Controller For Content Article Management
* 
* @package Content Management
* @subpackage Content 
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/Content_article_model.php
* @link views/admin/content_article/
*/


class Content_article extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public $uploaddir;
    public $thumbdir;
    public $showimgdir;
	public $showthmimgdir;

    public function __construct()
	{
		try
		{
			parent::__construct();
			$this->data['title']			=	"Content Article Management System";////Browser Title
			
			////////Define Errors Here//////
			$this->cls_msg = array();
			$this->cls_msg["no_result"]		=	"No information found about content article.";
			$this->cls_msg["save_err"]		=	"Information about content article failed to save.";
			$this->cls_msg["save_succ"]		=	"Information about content article saved successfully.";
			$this->cls_msg["delete_err"]	=	"Information about content article failed to remove.";
			$this->cls_msg["delete_succ"]	=	"Information about content article removed successfully.";
			////////end Define Errors Here//////
			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
			
			//////// loading default model here //////////////
			$this->load->model("content_article_model","mod_rect");
			//////// end loading default model here //////////////
			
		    $this->allowedExt = 'jpg|jpeg|png';
		    $this->uploaddir = $this->config->item('admin_cms_image_upload_path');		
		    //for uploading images to this folder
		  
		    $this->thumbdir = $this->config->item('admin_cms_image_thumb_upload_path');	
		    //for uploading image thumbnails to this folder
		  
		    $this->showthmimgdir = $this->config->item('cms_image_thumb_path');	
		    //for display thumbnails image 
			
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
            $this->data['heading']	=	"Content Article Management ";
			////Package Name[@package] Panel Heading

            ///////////generating search query///////
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_content_article_title=($this->input->post("h_search")?$this->input->post("txt_content_article_title"):$this->session->userdata("txt_content_article_title"));
			$s_content_article_type=($this->input->post("h_search")?$this->input->post("txt_content_article_type"):$this->session->userdata("txt_content_article_type"));
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
			////////end Getting Posted or session values for search///
            
            $s_where="WHERE i_del_status=1 ";
            if($s_search=="basic")
            {
                $s_where.=" AND c.s_title LIKE '%".get_formatted_string($s_content_article_title)."%'";
				if($s_content_article_type!='')
				{
					$s_where.="  AND m.s_name LIKE '%".get_formatted_string($s_content_article_type)."%'";	
				}
                /////Storing search values into session///
                $this->session->set_userdata("txt_content_article_title",$s_content_article_title);
				$this->session->set_userdata("txt_content_article_type",$s_content_article_type);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]						=	$s_search;
                $this->data["txt_content_article_title"]	=	$s_content_article_title;
				$this->data["txt_content_article_type"]		=	$s_content_article_type;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
                $s_where.=" AND c.s_title LIKE '%".get_formatted_string($s_content_article_title)."%'";
				if($s_content_article_type!='')
				{
					$s_where.="  AND m.s_name LIKE '%".get_formatted_string($s_content_article_type)."%'";	
				}
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( c.dt_entry_date , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_content_article_title",$s_content_article_title);
				$this->session->set_userdata("txt_content_article_type",$s_content_article_type);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);				
                
                $this->data["h_search"]						=	$s_search;
                $this->data["txt_content_article_title"]	=	$s_content_article_title;
				$this->data["txt_content_article_type"]		=	$s_content_article_type;                
                $this->data["txt_created_on"]				=	$dt_created_on;           
                /////end Storing search values into session///                
            }
            else////List all records, **not done
            {
              	$s_where="WHERE i_del_status != 2 ";
				
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_content_article_title");
				$this->session->unset_userdata("txt_content_article_type");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
				$this->data["h_search"]						=	$s_search;
                $this->data["txt_content_article_title"]	=	""; 
				$this->data["txt_content_article_type"]		=	"";                
                $this->data["txt_created_on"]				=	"";    
                /////end Storing search values into session///                 
            }
            unset($s_search,$s_content_article_title,$dt_created_on);
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
            $table_view["caption"]			=	"Content Article";
            $table_view["total_rows"]		=	count($info);
			$table_view["total_db_records"]	=	$this->mod_rect->gettotal_info($s_where);
                        
            $table_view["headers"][0]["width"]	=	"25%";
            $table_view["headers"][0]["align"]	=	"left";
            $table_view["headers"][0]["val"]	=	"Article Title";
			$table_view["headers"][1]["width"]	=	"12%";  
            $table_view["headers"][1]["val"]	=	"Article Type";
			$table_view["headers"][2]["width"]	=	"35%";
			$table_view["headers"][2]["val"]	=	"Short Description";
            $table_view["headers"][3]["val"]	=	"Created On"; 
            $table_view["headers"][4]["val"]	=	"Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= 	encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=	$info[$i]["s_title"];
				$table_view["tablerows"][$i][$i_col++]	=	$info[$i]["cms_type_name"];
                $table_view["tablerows"][$i][$i_col++]	=	$info[$i]["s_description"];
                $table_view["tablerows"][$i][$i_col++]	=	$info[$i]["dt_created_on"];
                $table_view["tablerows"][$i][$i_col++]	=	$info[$i]["s_is_active"];

            } 
            /////////end Table Data/////////
			
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]		=	$this->admin_showin_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]	=	$this->pathtoclass.$this->router->fetch_method();///used for search form action

			$this->render("content_article/show_list");
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
            $this->data['title']		=	"Content Article Management System";////Browser Title
            $this->data['heading']		=	"Add Content Article";
            $this->data['pathtoclass']	=	$this->pathtoclass;
            $this->data['mode']			=	"add";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
				$posted["opt_type_id"]						= 	trim($this->input->post("opt_type_id"));
                $posted["txt_content_article_title"]		= 	trim($this->input->post("txt_content_article_title"));
                $posted["txt_content_short_description"]	= 	trim($this->input->post("txt_content_short_description"));
				$posted["txt_content_long_description"]		= 	trim($this->input->post("txt_content_long_description"));
				$i_active_val 								= 	trim($this->input->post("i_content_is_active"));
                $posted["i_content_is_active"]				= 	($i_active_val==1)?$i_active_val:2;
                $posted["h_mode"]							= 	$this->data['mode'];
                $posted["h_id"]								= 	"";
               
                $this->form_validation->set_rules('opt_type_id', 'content article type', 'required');
				$this->form_validation->set_rules('txt_content_article_title', 'content article title', 'required');
                $this->form_validation->set_rules('txt_content_short_description', 'content article short description', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
					$info["i_cms_type_id"]			=	$posted["opt_type_id"];
                    $info["s_title"]				=	$posted["txt_content_article_title"];
                    $info["s_short_description"]	=	$posted["txt_content_short_description"];
					$info["s_long_description"]		=	$posted["txt_content_long_description"];
                    $info["i_status"]				=	$posted["i_content_is_active"];
                    $info["dt_entry_date"]			=	strtotime(date("Y-m-d H:i:s"));
                    
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
            $this->render("content_article/add-edit");
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
			$this->data['title']		=	"Edit Content Article Details";////Browser Title
            $this->data['heading']		=	"Edit Content Article";
            $this->data['pathtoclass']	=	$this->pathtoclass;
            $this->data['mode']			=	"edit";
			$this->data['thumbDir']		= 	$this->showthmimgdir;

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
				$posted["opt_type_id"]						= 	trim($this->input->post("opt_type_id"));
                $posted["txt_content_article_title"]		= 	trim($this->input->post("txt_content_article_title"));
                $posted["txt_content_short_description"]	= 	trim($this->input->post("txt_content_short_description"));
				$posted["txt_content_long_description"]		= 	trim($this->input->post("txt_content_long_description"));
				$i_active_val 								= 	trim($this->input->post("i_content_is_active"));
                $posted["i_content_is_active"]				= 	($i_active_val==1)?$i_active_val:2;
                $posted["h_id"]= trim($this->input->post("h_id"));
				
                $this->form_validation->set_rules('opt_type_id', 'content article type', 'required');
				$this->form_validation->set_rules('txt_content_article_title', 'content article title', 'required');
                $this->form_validation->set_rules('txt_content_short_description', 'content short description', 'required');
             
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["i_cms_type_id"]			=	$posted["opt_type_id"];
					$info["s_title"]				=	$posted["txt_content_article_title"];
					$info["s_short_description"]	=	$posted["txt_content_short_description"];
					$info["s_long_description"]		=	$posted["txt_content_long_description"];
                    $info["i_status"]				=	$posted["i_content_is_active"];
                    $info["dt_entry_date"]			=	strtotime(date("Y-m-d H:i:s"));
					
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
                    unset($info,$posted);
                    
                }
            }
            else
            {
                $info=$this->mod_rect->fetch_this(decrypt($i_id));
                $posted=array();
				$posted["opt_type_id"]						= 	trim($info["i_cms_type_id"]);
				$posted["txt_content_article_title"]		= 	trim($info["s_title"]);
				$posted["txt_content_short_description"]	= 	trim($info["s_short_description"]);
				$posted["txt_content_long_description"]		= 	trim($info["s_long_description"]);
				$posted["dt_created_on"]					= 	trim($info["dt_created_on"]);
				$posted["i_content_is_active"]				= 	trim($info["i_status"]);
				$posted["h_id"]								= 	$i_id;
				$posted["i_id"]								=	decrypt($i_id);
				//echo "<pre>";print_r($posted);echo "</pre>";exit;
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("content_article/add-edit");
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
							$i_ret_=$this->mod_rect->delete_all_info($i_content_type);
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
			/*if($this->i_content_type==1)////for page content type
			{
				redirect($this->pathtoclass."show_list".($pageno?"/".$pageno:""));
			}
			else////for email content type
			{
				redirect($this->pathtoclass."show_email_content".($pageno?"/".$pageno:""));
			}	*/		
			
			
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
                    $temp["s_id"]							= 	encrypt($info["id"]);////Index 0 must be the encrypted PK 
					$temp["s_content_type_name"]			= 	trim($info["s_name"]);
					$temp["s_content_title"]				= 	trim($info["s_title"]);
					$temp["s_content_short_description"]	= 	trim($info["s_short_description"]);
					$temp["s_is_active"]					= 	trim($info["s_is_active"]);
					$temp["dt_created_on"]					= 	trim($info["dt_created_on"]);

					$this->data["info"]=$temp;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            
            $this->render("content_article/show_detail",TRUE);
            unset($i_id);
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