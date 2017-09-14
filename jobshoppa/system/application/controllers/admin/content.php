<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 20 Aug 2011
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  Controller For Content Management
* 
* @package Content Management
* @subpackage Content 
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/content_model.php
* @link views/admin/content/
*/


class Content extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public $uploaddir;
    public $thumbdir;
    public $showimgdir;
	public $showthmimgdir;
	
	public $allowedExt_video;
    public $i_content_type = 1; // This is for contenty type;  1=> page content 2=> email [ DEFAULT VALUE IS 1 ]

    public function __construct()
	{
		try
		{
			parent::__construct();
			$this->data['title']			=	"Content Management System";////Browser Title
			
			////////Define Errors Here//////
			$this->cls_msg = array();
			$this->cls_msg["no_result"]		=	"No information found about content.";
			$this->cls_msg["save_err"]		=	"Information about content failed to save.";
			$this->cls_msg["save_succ"]		=	"Information about content saved successfully.";
			$this->cls_msg["delete_err"]	=	"Information about content failed to remove.";
			$this->cls_msg["delete_succ"]	=	"Information about content removed successfully.";
			////////end Define Errors Here//////
			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
			
			//////// loading default model here //////////////
			$this->load->model("content_model","mod_rect");
			//////// end loading default model here //////////////
			
			$this->allowedExt 			= 	'jpg|jpeg|png';
			$this->allowedExt_video 	= 	'flv';
			
			$this->uploaddir 			= 	$this->config->item('admin_cms_image_upload_path');		
			//for uploading images to this folder
			
			$this->thumbdir 			= 	$this->config->item('admin_cms_image_thumb_upload_path');	
			//for uploading image thumbnails to this folder
			
			$this->showthmimgdir 		= 	$this->config->item('cms_image_thumb_path');	
			//for display thumbnails image 
			
			///////////assigning content type/////////
			$this->i_content_type		=	($this->session->userdata("h_content_type")?$this->session->userdata("h_content_type"):1);
			///////////end assigning content type/////////
			
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
			$this->i_content_type = 1;
			$this->session->set_userdata("h_content_type",$this->i_content_type); 
			/*These two lines for unset search text show that listing can show freshly*/
			/*$this->session->unset_userdata("txt_content_title");
			$this->session->unset_userdata("txt_created_on");*/
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
            $this->data['heading']=($this->i_content_type==1?"Content Management ":"Email Templates");////Package Name[@package] Panel Heading

            ///////////generating search query///////
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_content_title=($this->input->post("h_search")?$this->input->post("txt_content_title"):$this->session->userdata("txt_content_title")); 
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
			$i_content_type	=	($_POST["h_search"]?$this->input->post("h_content_type"):$this->i_content_type);
			$this->session->set_userdata("h_content_type",$i_content_type); 
			////////end Getting Posted or session values for search///
            
            
            $s_where="";
            if($s_search=="basic")
            {
                $s_where=" WHERE c.s_title LIKE '%".get_formatted_string($s_content_title)."%' AND c.i_type = $i_content_type";
                /////Storing search values into session///
                $this->session->set_userdata("txt_content_title",$s_content_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_content_title"]=	$s_content_title;
				$this->data["h_content_type"]	=	$i_content_type;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
                $s_where=" WHERE c.s_title LIKE '%".get_formatted_string($s_content_title)."%' AND c.i_type = $i_content_type";
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( c.dt_entry_date , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_content_title",$s_content_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);				
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_content_title"]=$s_content_title;                
                $this->data["txt_created_on"]=$dt_created_on;   
				$this->data["h_content_type"]=$i_content_type;          
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
				
              	$s_where=" WHERE c.i_type = $i_content_type";
				
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_content_title");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
				$this->data["h_search"]=$s_search;
                $this->data["txt_content_title"]="";                
                $this->data["txt_created_on"]="";    
				$this->data["h_content_type"]=$i_content_type;         
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_content_title,$dt_created_on,$i_content_type);
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
			//echo count($info);
			//echo "<pre>";print_r($info);echo "</pre>";exit;
            /////////Creating List view for displaying/////////
            $table_view=array();     
			       
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Content";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
                        
            $table_view["headers"][0]["width"]	="20%";
            $table_view["headers"][0]["align"]	="left";
            $table_view["headers"][0]["val"]	="Page Title";
			$table_view["headers"][1]["width"]	="50%";  
            $table_view["headers"][1]["val"]	="Description";
            $table_view["headers"][2]["val"]	="Created On"; 
           // $table_view["headers"][3]["val"]	="Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_db_records"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_title"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_description"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];
               // $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_is_active"];

            } 
            /////////end Table Data/////////
			
            unset($i,$i_col,$start,$limit); 
   
            $this->data["table_view"]=$this->admin_showin_table($table_view,TRUE);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action

			$this->render("content/show_list");
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
            $this->data['title']			=	"Content Management";////Browser Title
            $this->data['heading']			=	"Add Content";
            $this->data['pathtoclass']		=	$this->pathtoclass;
            $this->data['mode']				=	"add";
			$this->data['i_content_type']	=	$this->i_content_type;
			

            ////////////Submitted Form///////////
            if($_POST)
            {

				$posted=array();
                $posted["txt_content_title"]		= 	trim($this->input->post("txt_content_title"));
                $posted["txt_content_description"]	= 	trim($this->input->post("txt_content_description"));
				
				$posted["s_youtube_link"]			= 	trim($this->input->post("video_code"));
				$posted["s_flv_video"]				= 	trim($this->input->post("h_upload_video_div"));
				
				$posted["s_doc_mgnt_features"]		= 	trim($this->input->post("txt_doc_mgnt_features"));
				$i_active_val 						= 	trim($this->input->post("i_content_is_active"));
                $posted["i_content_is_active"]		= 	($i_active_val==1)?$i_active_val:2;
				$posted["i_content_type"]			= 	intval($this->i_content_type);
				
                $posted["h_mode"]= $this->data['mode'];
                $posted["h_id"]= "";
               
                $this->form_validation->set_rules('txt_content_title', 'content title', 'required');
                $this->form_validation->set_rules('txt_content_description', 'content description', 'required');
				
              	$info	=	array();
				if($posted["h_video"]== 'video')
				{
					if(isset($_FILES['upload_video']) && !empty($_FILES['upload_video']['name']))
					{
						$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'upload_video','','',$this->allowedExt_video);
						
						$arr_upload_res = explode('|',$s_uploaded_filename);						
					}
					
					if(count($arr_upload_res)==0)
					{
						$info["s_flv_video"] = $posted['h_upload_video_div'];
					}
					else
					{
						$info["s_flv_video"] = $arr_upload_res[2];
					}
					$info["s_youtube_link"]	="";
				}
				if($posted["h_video"]== 'code')
				{
					$info["s_youtube_link"]		=$posted["s_youtube_link"];
					$info["s_flv_video"] 		="";
				}
				
                if($this->form_validation->run() == FALSE || ($arr_upload_res[0]==='err'))/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info["s_title"]				=	$posted["txt_content_title"];
                    $info["s_description"]			=	$posted["txt_content_description"];
					$info["s_doc_mgnt_features"]	=	$posted["s_doc_mgnt_features"];
                    $info["i_is_active"]			=	$posted["i_content_is_active"];
                    $info["i_type"]					=	$posted["i_content_type"];
                    $info["dt_cr_date"]				=	strtotime(date("Y-m-d H:i:s"));
                    
                    $i_newid = $this->mod_rect->add_info($info);
                    if($i_newid)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
                        if($this->i_content_type==1)////for page content type
						{
							redirect($this->pathtoclass."show_list");
						}
						else////for email content type
						{
							redirect($this->pathtoclass."show_email_content");
						}	
                    }
                    else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    
                }
            }
            ////////////end Submitted Form///////////
            $this->render("content/add-edit");
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
			$this->data['title']="Edit Content Details";////Browser Title
            $this->data['heading']="Edit content";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";
			$this->data['i_content_type']	=	$this->i_content_type;
			$this->data['thumbDir']= $this->showthmimgdir;

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
				$posted["s_title"]= trim($this->input->post("s_title"));
				$posted["txt_name"]= trim($this->input->post("txt_name"));
				$posted["txt_designation"]= trim($this->input->post("txt_designation"));
				
                $posted["txt_content_description"]= trim($this->input->post("txt_content_description"));
				$posted["s_doc_mgnt_features"]= trim($this->input->post("txt_doc_mgnt_features"));
				
				$posted["s_youtube_link"]= trim($this->input->post("video_code"));
				$posted["h_upload_video_div"]= trim($this->input->post("h_upload_video_div"));
			    $posted["h_video"]= trim($this->input->post("h_video"));
				$i_active_val = trim($this->input->post("i_content_is_active"));
                $posted["i_content_is_active"]= ($i_active_val==1)?$i_active_val:2;
				$posted["i_content_type"]= intval($this->i_content_type);
                $posted["h_id"]= trim($this->input->post("h_id"));
				$posted["h_image_name"]= trim($this->input->post("h_image_name"));
				$posted["h_video_name"]= trim($this->input->post("h_video_name"));
				
				if(isset($_FILES['txt_image_name']) && !empty($_FILES['txt_image_name']['name']))
				{
					$s_uploaded_filename_i = get_file_uploaded( $this->uploaddir,'txt_image_name','','',$this->allowedExt);
					
					$arr_upload_res_i = explode('|',$s_uploaded_filename_i);						
					
				}
			   
              //  $this->form_validation->set_rules('txt_content_title', 'content title', 'required');
                $this->form_validation->set_rules('txt_content_description', 'content description', 'required');
				
             	$info	=	array();
				
				//  VIDEO UPLOAD //
				if($posted["h_video"]== 'video')
				{
					if(isset($_FILES['upload_video']) && !empty($_FILES['upload_video']['name']))
					{
						$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'upload_video','','',$this->allowedExt_video);
						
						$arr_upload_res = explode('|',$s_uploaded_filename);				
					}
					//Enable this portion to upload flv video
					if(count($arr_upload_res)==0)
					{
						//$info["s_flv_video"] = $_FILES['upload_video']['name'];
						
						$info["s_flv_video"] = $posted['h_upload_video_div'];
						//if video upload is enable
					}
					else
					{
						$info["s_flv_video"] = $arr_upload_res[2];
					}
					$info["s_youtube_link"]	=	"";
				}
				if($posted["h_video"]== 'code')
				{
					$info["s_youtube_link"]	=	$posted["s_youtube_link"];
					$info["s_flv_video"] 	=	"";
				}
				
				//  END VIDEO UPLOAD  //
			 
                if($this->form_validation->run() == FALSE || ($arr_upload_res[0]==='err'))/////invalid
                {
					if($arr_upload_res[0]==='err')
					{
						set_error_msg($arr_upload_res[2]);
					}
					else
					{
						get_file_deleted($this->uploaddir,$arr_upload_res[2]);
					}
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
				
				
                else///validated, now save into DB
                {
                    $info["s_title"]=$posted["s_title"];
					$info["s_description"]=$posted["txt_content_description"];
					$info["s_doc_mgnt_features"]=$posted["s_doc_mgnt_features"];
                    $info["i_status"]=$posted["i_content_is_active"];
                    $info["dt_entry_date"]=strtotime(date("Y-m-d H:i:s"));
					
					if(count($arr_upload_res_i)==0)
					{
						$info["s_image"] = $posted['h_image_name'];
					}
					else
					{
						$info["s_image"] = $arr_upload_res_i[2];
					}
                    $i_aff=$this->mod_rect->edit_info($info,decrypt($posted["h_id"]));
                    if($i_aff)////saved successfully
                    {
						if($arr_upload_res_i[0]==='ok')
						{
							get_image_thumb($this->uploaddir.$info["s_image"], $this->thumbdir, 'thumb_'.$info["s_image"]);
							get_file_deleted($this->uploaddir,$posted['h_image_name']);
							get_file_deleted($this->thumbdir,'thumb_'.$posted['h_image_name']);
						}
						
                        //$this->session->set_userdata('success_msg', $this->cls_msg["save_succ"]);
                        set_success_msg($this->cls_msg["save_succ"]);
                        if($this->i_content_type==1)////for page content type
						{
							redirect($this->pathtoclass."show_list");
						}
						else////for email content type
						{
							redirect($this->pathtoclass."show_email_content");
						}						
						
                    }
                    else///Not saved, show the form again
                    {
                        //$this->session->set_userdata('error_msg', $this->cls_msg["save_err"]);
                        $this->data["posted"]=$posted;
                        //$this->data["error_msg"]=$this->cls_msg["save_err"];
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    unset($info,$posted);
                    
                }
            }
            else
            {
                $info=$this->mod_rect->fetch_this(decrypt($i_id));
                $posted=array();
				$posted["txt_name"]= trim($info["s_name"]);
				$posted["txt_content_title"]= trim($info["s_title"]);
				$posted["txt_designation"]= trim($info["s_designation"]);
				$posted["txt_content_description"]= trim($info["s_description"]);
				$posted["s_youtube_link"]= trim(htmlspecialchars($info["s_youtube_link"], ENT_QUOTES, 'utf-8'));
				$posted["s_flv_video"]= trim(htmlspecialchars($info["s_flv_video"], ENT_QUOTES, 'utf-8'));
				$posted["txt_doc_mgnt_features"]= trim($info["s_doc_mgnt_features"]);
				$posted["dt_created_on"]= trim($info["dt_created_on"]);
				$posted["h_content_type"]= $info["i_type"];
				$posted["txt_image_name"]= trim($info["s_image_name"]);
				$posted["h_id"]= $i_id;
				$posted["i_id"]= decrypt($i_id);
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("content/add-edit");
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
			}*/			
			
			
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
					$temp["s_content_title"]= trim($info["s_title"]);
					$temp["s_content_description"]= trim($info["s_description"]);
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
            
            $this->render("content/show_detail",TRUE);
            unset($i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	
	public function show_email_content()
	{
		try
        {
			$this->i_content_type = 2;
			$this->session->set_userdata("h_content_type",$this->i_content_type); 
			$this->show_list();
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