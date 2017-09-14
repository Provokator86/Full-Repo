<?php
/********** 
Author: 
* Date  : 22 nov 2012
* Modified By: 
* Modified Date: 
* 
* Purpose:
* Controller For Manage Advertisement
* 
* @package Content Management
* @subpackage State
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/advertisement_model.php
* @link views/admin/manage_advertisement/
*/
class Manage_report extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
		public $table;
 
		public function __construct()
    {
      try
      {
			parent::__construct();
			$this->data['title']	= "Report Management"; // Browser Title
			
			// Table used
			$this->table = $this->db->REPORT;
			$this->data['action_allowed']["Status"]=TRUE;
			$this->data['action_allowed']["Add"]=FALSE;
			$this->data['action_allowed']["Edit"]=FALSE;
			//$this->data['action_allowed']["Delete"]=FALSE;
			// Define Errors Here 
			$this->cls_msg = array();
			$this->cls_msg["no_result"]			= "No information found about advertisement.";
			$this->cls_msg["save_err"]			= "Information about advertisement failed to save.";
			$this->cls_msg["save_succ"]			= "Information about advertisement saved successfully.";
			$this->cls_msg["delete_err"]		= "Information about advertisement failed to remove.";
			$this->cls_msg["delete_succ"]		= "Information about advertisement removed successfully.";
			$this->cls_msg["img_upload_err"]	= "Image cannot be uploded.";
		  	$this->cls_msg["database_err"]		= "Failed to insert in the database.Try Again";
			// end Define Errors Here
			
			$this->allowedExt									= 'jpg|jpeg|png|gif';
			$this->uploaddir 									= $this->config->item('ADVERTISEMENT_IMAGE_UPLOAD_PATH');	
			$this->thumbdir  									= $this->config->item('ADVERTISEMENT_THUMB_IMAGE_UPLOAD_PATH');
			$this->thumb_ht										= 138;
			$this->thumb_wd										= 308;
			
			 
			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/"; //for redirecting from this class
			
			$this->load->model("advertisement_model");
			$this->load->model("report_model");// loading default model here
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
 public function show_list($order_name = '', $order_by = 'asc', $start = NULL, $limit = NULL)
    {
        try
        {
            $this->data['heading'] 			= "Report Management"; // Package Name[@package] Panel Heading
			$this->data['pathtoclass']		= $this->pathtoclass; 
            $s_where = "";
			
			
			
			 $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_milestones_title=($this->input->post("h_search")?$this->input->post("txt_subject"):$this->session->userdata("txt_subject")); 
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
           
            if($s_search=="basic")
            {
                $s_where.=" AND n.s_subject LIKE '%".get_formatted_string($s_milestones_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_subject",$s_milestones_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_subject"]=$s_milestones_title;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
			}
            else////List all records, **not done
            {
                //$s_where="WHERE i_del_status != 2 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_subject");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_subject"]="";                
                $this->data["txt_created_on"]="";             
                /////end Storing search values into session///                 
                
            }
			
			
           
            unset($s_search,$s_user_type,$dt_created_on);
            ///Setting Limits, If searched then start from 0 
						$i_uri_seg 	= 6;
						$start 			= $this->uri->segment($i_uri_seg);
						// end generating search query 
						$limit			= $this->i_admin_page_limit;
						$info			= $this->report_model->fetch_multi($s_where, intval($start), $limit);
						
						//pr($info);
						
						// Creating List view for displaying 
            $table_view = array();  
			          
            // Table Headers, with width,alignment 
            $table_view["caption"]						= "Report Management";
            $table_view["total_rows"]					= count($info);
			$table_view["total_db_records"]				= $this->report_model->gettotal_info($s_where);
			$table_view["order_name"]					= $order_name;
			$table_view["order_by"]  					= $order_by;
			$table_view["src_action"]					= $this->pathtoclass.$this->router->fetch_method();   
			$table_view["detail_view"]  				= false;
			
			
           
						$j_col= 0;   
			
						$table_view["headers"][0]["width"]			= "30%";
						$table_view["headers"][0]["align"]			= "left";
						$table_view["headers"][0]["val"]			= "Coupon ";
						$table_view["headers"][1]["val"]			= "IP ";
						$table_view["headers"][3]["val"]			= "No. of hits";
            //////end Table Headers, with width,alignment///////
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {			
						
						
						$i_col=0;
						$table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);////Index 0 must be the encrypted PK 
						$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_title"];
						$table_view["tablerows"][$i][$i_col++]	= $info[$i]["i_ip"];
						$table_view["tablerows"][$i][$i_col++]	=  $info[$i]["i_no_of_hit"];
						
						} 
			
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"] = $this->admin_showin_order_table($table_view);
			
            /////////Creating List view for displaying/////////
            $this->data["search_action"] = $this->pathtoclass.$this->router->fetch_method();///used for search form action
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
		try
        {
				
						$this->data['title']			= "Advertisement Management";////Browser Title
						$this->data['heading']			= "Add Advertisement";
						$this->data['pathtoclass']		= $this->pathtoclass;
						$this->data['mode']					= "add";
						
						if($_POST)
							{	
								//print_r($_POST);exit;
								$this->form_validation->set_rules('s_description','Description','required');
								$this->data['posted'] = $_POST;
								if ($this->form_validation->run() == TRUE)
									{
										
										
										if(isset($_FILES['s_images']) && !empty($_FILES['s_images']['name']))
											{
												$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'s_images','','',$this->allowedExt);    
												$arr_upload_res = explode('|',$s_uploaded_filename);
											}
										if(($arr_upload_res[0]==='err'))/////invalid
											{
												$this->session->set_userdata(array('message'=>$this->cls_msg["img_upload_err"],'message_type'=>'err'));
												redirect(base_url().'manage_advertisement/add_information');	
											}
										else
											{
												if($arr_upload_res[0]==='ok')
													{
														get_image_thumb($this->uploaddir.$arr_upload_res[2], $this->thumbdir, 'thumb_'.$arr_upload_res[2],$this->thumb_ht,$this->thumb_wd);  // get thumb image								
													}
											}
										
										
										
										
										$info	= array(										
										"s_description"					=> $this->input->post("s_description"),
										"i_is_active"					=> $this->input->post("i_is_active"),
										"s_title"						=> $this->input->post("s_title"),
										"s_url"							=> $this->input->post("s_url"),
										"s_images"						=> $arr_upload_res[2]
										);
										//pr($info,1);
										$inserted_user_id	= $this->advertisement_model->add_info($info);										
										
										if($inserted_user_id)////saved successfully
										{
											set_success_msg($this->cls_msg["save_succ"]);
											redirect($this->pathtoclass."show_list");
										}
										else
										{	
											get_file_deleted($this->uploaddir,$arr_upload_res[2]);
											get_file_deleted($this->thumbdir,'thumb_'.$arr_upload_res[2]);
											set_error_msg($this->cls_msg["database_err"]);
										}
									}
							}
						////////////end Submitted Form///////////
						$this->render("manage_advertisement/add-edit");
					
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
						$this->data['title']					= "Edit advertisement Details";////Browser Title
            $this->data['heading']				= "Edit advertisement";
            $this->data['pathtoclass']		= $this->pathtoclass;
            $this->data['mode']						= "edit";
			
            ////////////Submitted Form///////////
				if($_POST)
				{	//pr($_POST,1);
				$posted=array();
        		$posted["h_mode"]								= $this->data['mode'];
				$posted["s_description"]				= trim($this->input->post("s_description"));	
				$i_active_val 							= trim($this->input->post("i_is_active"));
				$posted["s_title"] 						= trim($this->input->post("s_title"));
				$posted["s_url"] 						= trim($this->input->post("s_url"));
				$posted["s_images"] 					= trim($this->input->post("s_images"));
				$posted["h_s_images"] 					= trim($this->input->post("h_s_images"));
				$posted["i_is_active"]					= ($i_active_val==1)?$i_active_val:2;
				$posted["h_id"]							= trim($this->input->post("h_id"));
				
				
				$this->form_validation->set_rules('s_description','Description','required');
				
				if($this->form_validation->run() == FALSE)/////invalid
				{
						////////Display the add form with posted values within it////
						$this->data["posted"]	= $posted;
				}
				else///validated, now save into DB
				{	
					
					
					if(isset($_FILES['s_images']) && !empty($_FILES['s_images']['name']))
											{
												$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'s_images','','',$this->allowedExt);    
												$arr_upload_res = explode('|',$s_uploaded_filename);
											}
										if(($arr_upload_res[0]==='err'))/////invalid
											{
												$this->session->set_userdata(array('message'=>$this->cls_msg["img_upload_err"],'message_type'=>'err'));
												redirect(base_url().'manage_advertisement/modify_information');	
											}
										else
											{
												if($arr_upload_res[0]==='ok')
													{
														get_image_thumb($this->uploaddir.$arr_upload_res[2], $this->thumbdir, 'thumb_'.$arr_upload_res[2],$this->thumb_ht,$this->thumb_wd);  // get thumb image								
													}
											}
				
				
				
					
					$info	=	array();
					$info["s_description"]	=	$posted["s_description"];
					$info["i_is_active"]	=	$posted["i_is_active"];
					$info["s_title"]		=	$posted["s_title"];
					$info["s_url"]			=	$posted["s_url"];
					$info["s_images"]		=	$posted["s_images"];
					if(count($arr_upload_res)>0)
										{
											$info["s_images"]					=	$arr_upload_res[2];
											//echo (base_url()."uploaded/advertisement/".$posted["h_s_images"]);
											//echo (BASEPATH."../uploaded/advertisement/".$posted["h_s_images"]);exit;
											unlink(BASEPATH."../uploaded/advertisement/".$posted["h_s_images"]);
											unlink(BASEPATH."../uploaded/advertisement/thumb/thumb_".$posted["h_s_images"]);
										}
										else
										{
											$info["s_images"]					=	$posted["h_s_images"];
										}
					//spr($info);
					$i_aff			= $this->advertisement_model->edit_info($info, decrypt($posted["h_id"]));
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
				$info=$this->advertisement_model->fetch_this(decrypt($i_id));					
			
				$posted=array();
				$posted["s_description"]		= trim($info[0]["s_description"]);
				$posted["i_is_active"]			= trim($info[0]["i_is_active"]);
				$posted["s_title"]				= trim($info[0]["s_title"]);
				$posted["s_url"]				= trim($info[0]["s_url"]);
				$posted["s_images"]				= trim($info[0]["s_images"]);
				$posted["h_id"]					= $i_id;
				
				$this->data["posted"]=$posted;       
				unset($info,$posted);      
        }
            ////////////end Submitted Form///////////
        $this->render("manage_advertisement/add-edit");
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
							$i_ret_=$this->advertisement_model->delete_all_info($i_content_type);
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
									$i_ret_=$this->advertisement_model->delete_info(decrypt($id[$tot]));
									$tot--;
								}
							}
							elseif($id>0)///Deleting single Records
							{
							$i_ret_=$this->advertisement_model->delete_info(decrypt($id));
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
		
		
		
		public function ajax_change_status()
    {
        try
        {
            
					$posted["id"]           = decrypt(trim($this->input->post("h_id")));
					$posted["i_status"]     = trim($this->input->post("i_status"));
					$info = array();
					$info['i_is_active']    = $posted["i_status"]  ;
					$i_rect									= $this->advertisement_model->change_status($info,$posted["id"]); /*don't change*/				
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
