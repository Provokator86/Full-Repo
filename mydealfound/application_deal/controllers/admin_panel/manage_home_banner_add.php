<?php
/*********
* Author: Arka 
* Date  : 
* Modified By: 
* Modified Date:
* 
* Purpose:
* Controller For manage coupons
* 
* @package Content Management
* @subpackage site_setting
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/manage_coupons_model.php
* @link views/admin/manage_coupons/
*/

class Manage_home_banner_add extends My_Controller implements InfController
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
          ////////Define Errors Here//////
          $this->data['title']="Manage ";////Browser Title

          ////////Define Errors Here//////
			$this->cls_msg = array();
			$this->cls_msg["no_result"]				= "No information found about admin site setting.";
			$this->cls_msg["save_err"]				= "Banner failed to save.";
			$this->cls_msg["save_succ"]				= "Saved successfully.";
			$this->cls_msg["delete_err"]			= "Banner setting failed to remove.";
			$this->cls_msg["delete_succ"]			= "Banner Add removed successfully.";
			$this->cls_msg["img_upload_err"]		= "Image cannot be uploded.";
			$this->cls_msg["database_err"]			= "Failed to insert in the database.Try Again";
			////////end Define Errors Here//////
			$this->pathtoclass 						= admin_base_url().$this->router->fetch_class()."/";
		  
			$this->allowedExt						= 'jpg|jpeg|png|gif';
			$this->uploaddir 						= $this->config->item('HOME_BANNER_IMAGE_UPLOAD_PATH');	
			$this->thumbdir  						= $this->config->item('HOME_BANNER_IMAGE_THUMB_UPLOAD_PATH');
			$this->thumbdirBig  					= $this->config->item('HOME_BANNER_IMAGE_BIG_THUMB_UPLOAD_PATH');
			$this->thumb_ht							= 317;
			$this->thumb_wd							= 592;
			$this->thumb_big_ht						= 60;
			$this->thumb_big_wd						= 60;
			
		 	$this->load->model("home_banner_model");
			//$this->load->model("startup_model");
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
			
            $this->data['title']		=	"Manage Home Banner";////Browser Title
            $this->data['heading']		=	"Manage Home Banner";
			
			redirect($this->pathtoclass.'show_list');
            
            
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
            $this->data['title']						= "Home Banner Management";////Browser Title
            $this->data['heading']						= "Add Home Banner";
            $this->data['pathtoclass']					= $this->pathtoclass;
			$this->data['mode']							= "add";
			
            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
				
				$posted['s_url'] 						= trim($this->input->post("s_url"));
				$posted['i_is_active'] 	 				= trim($this->input->post("i_is_active"));
				$posted["h_mode"]						= $this->data['mode'];
				$posted["h_id"]							= "";
				$this->form_validation->set_rules('s_url', 'Url', 'required');
				
				
				if($this->form_validation->run() == FALSE )/////invalid
				{
					$this->data["posted"]=$posted;////////Display the add form with posted values within it////
				}
                else///validated, now save into DB
                {
					if(isset($_FILES['s_image']) && !empty($_FILES['s_image']['name']))
					{
						$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'s_image','','',$this->allowedExt);    
						$arr_upload_res = explode('|',$s_uploaded_filename);
					}
					if(($arr_upload_res[0]==='err'))/////invalid
						{
							set_error_msg("Image upload failed.");
							//pr($arr_upload_res,1);
							redirect(base_url().'coupondesh_controlpanel/manage_home_banner_add/add_information');	
						}
					else
						{
						if($arr_upload_res[0]==='ok')
							{
								get_image_thumb($this->uploaddir.$arr_upload_res[2], $this->thumbdir, 'thumb_'.$arr_upload_res[2],$this->thumb_ht,$this->thumb_wd);
								get_image_thumb($this->uploaddir.$arr_upload_res[2], $this->thumbdirBig, 'thumb_'.$arr_upload_res[2],$this->thumb_big_ht,$this->thumb_big_wd);  // get thumb image								
							}
						}		
					$info=array();
					$info["s_url"] 					= $posted["s_url"];
					$info["i_is_active"] 			= $posted["i_is_active"];			
					$info["s_image"]				= $arr_upload_res[2]; // Stores only the name of the image along with extension in the database
				
					$i_newid = $this->home_banner_model->add_info($info);
					if($i_newid)////saved successfully
					{
						set_success_msg($this->cls_msg["save_succ"]);
						redirect($this->pathtoclass."show_list");
	 				}
					else///Not saved, show the form again
					{
						get_file_deleted($this->uploaddir,$arr_upload_res[2]);
						get_file_deleted($this->thumbdir,'thumb_'.$arr_upload_res[2]);
						get_file_deleted($this->thumbdirBig,'thumb_'.$arr_upload_res[2]);
						set_error_msg($this->cls_msg["database_err"]);
					}
				}
            }
			 ////////////end Submitted Form///////////
		$this->render("manage_home_banner_add/add-edit");
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
   public function modify_information($id=0)
    {
          
        try
        {
            $this->data['title']							= "Home Banner Management";////Browser Title
            $this->data['heading']							= "Edit Home Banner";
            $this->data['pathtoclass']						= $this->pathtoclass;
			$this->data['mode']								= "edit";
			
		
            ////////////Submitted Form///////////
            if($_POST)
            {
				//pr($_POST,1);
				$posted=array();
				$posted["h_mode"]				= $this->data['mode'];
				$posted['s_url'] 				= trim($this->input->post("s_url"));
				$posted['i_is_active'] 	 		= trim($this->input->post("i_is_active"));
				$posted["h_s_image"]			= trim($this->input->post("h_s_image"));
				
				
				
				$posted["h_id"]							= trim($this->input->post("h_id"));
							
				$this->form_validation->set_rules('s_url', 'Url', 'required');
				
				if($this->form_validation->run() == FALSE )/////invalid
				{
					////////Display the add form with posted values within it////
					$this->data["posted"]=$posted;
				}
				else///validated, now save into DB
              	{
					if(isset($_FILES['s_image']) && !empty($_FILES['s_image']['name']))
					{
						$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'s_image','','',$this->allowedExt);    
						$arr_upload_res = explode('|',$s_uploaded_filename);
					}
					if(($arr_upload_res[0]==='err'))/////invalid
						{
							$this->session->set_userdata(array('message'=>$this->cls_msg["img_upload_err"],'message_type'=>'err'));
							redirect(base_url().'manage_gift/modify_information');	
						}
					else
						{
							if($arr_upload_res[0]==='ok')
								{
									get_image_thumb($this->uploaddir.$arr_upload_res[2], $this->thumbdir, 'thumb_'.$arr_upload_res[2],$this->thumb_ht,$this->thumb_wd);  // get thumb image	
									get_image_thumb($this->uploaddir.$arr_upload_res[2], $this->thumbdirBig, 'thumb_'.$arr_upload_res[2],$this->thumb_big_ht,$this->thumb_big_wd); 							
								}
						}	
					$info					= array();
					$info["s_url"] 			= $posted["s_url"];
					$info["i_is_active"] 	= $posted["i_is_active"];
					if(count($arr_upload_res)>0)
					{
						$info["s_image"]	= $arr_upload_res[2];
					}
					else
					{
						$info["s_image"]	= $posted["h_s_image"];
					}
					
				$i_aff=$this->home_banner_model->edit_info($info,decrypt($posted["h_id"]));
				
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
               	$info	= $this->home_banner_model->fetch_this(decrypt($id));
				//pr($info,1);
               	$posted=array();
										
				$posted["h_id"]				= trim(encrypt($info[0]["i_id"]));
				$posted['s_url'] 			= trim($info[0]["s_url"]);
				$posted["s_image"]			= trim($info[0]["s_image"]);
				$posted['i_is_active'] 		= trim($info[0]["i_is_active"]);
				
				
				$posted["h_id"]								= $id;
				//pr($posted,1);
                $this->data["posted"]=$posted; 
				$all_count	=	1;    
				unset($info,$posted);      
            }
            ////////////end Submitted Form///////////
						
			$this->render("manage_home_banner_add/add-edit");
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
							$i_ret_=$this->home_banner_model->delete_info(-1);
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
							$i_ret_=$this->home_banner_model->delete_info(decrypt($id[$tot]));
							$tot--;
							}
							}
							elseif($id>0)///Deleting single Records
							{
							$i_ret_=$this->home_banner_model->delete_info(decrypt($id));
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
         
    }	
	
	
	
	
	public function show_list($order_name='',$order_by='desc',$start=NULL,$limit=NULL)
	{
		try
        {
			$this->data['heading']="Manage Home Banner";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
			
            $srch_s_url=($this->input->post("h_search")?$this->input->post("srch_s_url"):$this->session->userdata("srch_s_url")); 
			 if($s_search=="basic")
            {
                $s_where =" WHERE (s_url LIKE '%".my_receive_like($srch_s_url)."%' )";
				
                /////Storing search values into session///
                $this->session->set_userdata("srch_s_url",$srch_s_url);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["srch_s_url"]=$srch_s_url;
                /////end Storing search values into session///
            }
            
            else////List all records, **not done
            {
                /////Releasing search values from session///
                $this->session->unset_userdata("srch_s_url");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["srch_s_url"]="";                
                /////end Storing search values into session///
            }
            unset($s_search,$s_user_type,$dt_created_on);
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
			$arr_sort = array(0=>'i_id',1=>'s_url');
			$s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
            
            $limit	= $this->i_admin_page_limit;
            
			$info	= $this->home_banner_model->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);///////////test
			//pr ($info,1);
            /////////Creating List view for displaying/////////
			$table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]     			= "Home Banner";
            $table_view["total_rows"]			= count($info);
			$table_view["total_db_records"]		= $this->home_banner_model->gettotal_info($s_where);
			$table_view["order_name"]			= $order_name;
			$table_view["order_by"]  			= $order_by;
            $table_view["src_action"]			= $this->pathtoclass.$this->router->fetch_method(); 
            $table_view["detail_view"]			= FALSE;          
            $table_view["headers"][0]["width"]	= "40%";
            $table_view["headers"][0]["align"]	= "left";
            $table_view["headers"][0]["val"]	= "URL";
			$table_view["headers"][1]["align"]	= "center";
			$table_view["headers"][1]["val"]	= "Image";
			
			if($this->data['action_allowed']["Status"])
			{
				$table_view["headers"][2]["val"]	= "Status";
				$table_view["headers"][2]["align"]  = "center";
			}
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $img = $info[$i]["s_image"] != ''? '<img src="'.base_url().'uploaded/home_banner_add/main_thumb/thumb_'.$info[$i]['s_image'].'" />' : '<img src="'.base_url().'uploaded/img/no_image.jpg"/>';
				
				$i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	= string_part($info[$i]["s_url"],60);
				$table_view["tablerows"][$i][$i_col++]	= $img ;
				$action = '';
				if($this->data['action_allowed']["Status"])
				{
				 	if($info[$i]["i_is_active"] == 1)
					{
                        $action .='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_inactive">
                        <img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/tick.png"></a>';
					}
					else
					{ 
                        $action .='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_active">
                        <img width="12" height="12" title="Active" alt="Active" src="images/admin/reject.png"></a>';
					}
				}
				
				$table_view["tablerows"][$i][$i_col++]	= $action;
			
            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit,$action); 
            
            //$this->data["table_view"]=$this->admin_showin_table($table_view);
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
            
            if($posted["duplicate_value"]!="")
            {
                $qry=" Where ".(intval($posted["id"])>0 ? " i_id!=".intval($posted["id"])." And " : "" )
                    ." s_user_email='".$posted["duplicate_value"]."'";
                $info=$this->faq_model->fetch_multi($qry,$start,$limit); /*don't change*/
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
	
	///////////////user change status/////////
	
	public function ajax_change_status()
    {
        try
        {
            
                $posted["id"]           = decrypt(trim($this->input->post("h_id")));
                $posted["i_status"]     = trim($this->input->post("i_status"));
                $info = array();
                $info['i_is_active']    = $posted["i_status"]  ;
                $i_rect=$this->home_banner_model->change_status($info,$posted["id"]); /*don't change*/				
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