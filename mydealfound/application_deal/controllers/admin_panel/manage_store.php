<?php
/*********
* Author: Arka , Mousudha
* Date  : 07 nov 2012
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

class Manage_store extends My_Controller implements InfController
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
			$this->cls_msg["save_err"]				= "Admin site setting failed to save.";
			$this->cls_msg["save_succ"]				= "Saved successfully.";
			$this->cls_msg["delete_err"]			= "Store failed to remove.";
			$this->cls_msg["delete_succ"]			= "Store removed successfully.";
			$this->cls_msg["img_upload_err"]		= "Image cannot be uploded.";
			$this->cls_msg["database_err"]			= "Failed to insert in the database.Try Again";
			////////end Define Errors Here//////
			$this->pathtoclass 						= admin_base_url().$this->router->fetch_class()."/";
			$this->session->unset_userdata("s_store");
		  
			$this->allowedExt						= 'jpg|jpeg|png|gif';
			$this->uploaddir 						= $this->config->item('STORE_LOGO_IMAGE_UPLOAD_PATH');	
			$this->thumbdir  						= $this->config->item('STORE_LOGO_THUMB_IMAGE_UPLOAD_PATH');
			$this->thumbdirmain  					= $this->config->item('STORE_LOGO_MAIN_THUMB_IMAGE_UPLOAD_PATH');
			$this->thumbdir_fb					 = $this->config->item('STORE_LOGO_FB_THUMB_IMAGE_UPLOAD_PATH');
			$this->thumb_ht							= 58;
			$this->thumb_wd							= 97;
			$this->thumb_ht_main					= 67;
			$this->thumb_wd_main					= 163;
			$this->thumb_ht_banner					= 240;
			$this->thumb_wd_banner					= 321;
		  
		  			  
		 	$this->data['action_allowed']["Status"]	= TRUE;///////////////////////////////////////////exp
          	$this->load->model("store_model");
			$this->data['category']	= $this->store_model->get_category();
			$this->data['brand']	= $this->store_model->get_brand();
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
			
            $this->data['title']		=	"Manage Store";////Browser Title
            $this->data['heading']		=	"Manage Store";
			
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
          	$this->data['title']				= "Store Management";////Browser Title
            $this->data['heading']				= "Add Store ";
            $this->data['pathtoclass']			= $this->pathtoclass;
            $this->data['mode']					= "add";
			
			if($_POST)
        	{
				$this->form_validation->set_rules('s_store_title','Store Title','required');
				$this->form_validation->set_rules('s_store_url','Store URL','required');
				$this->form_validation->set_rules('i_is_active','Status','required');
				$this->form_validation->set_rules('s_about_us','About store','required');
				
			 if($this->form_validation->run() == FALSE)	
			 {	
				$this->data['posted'] = $_POST;
			 }
              
        else
           {		
			if(isset($_FILES['s_store_logo']) && !empty($_FILES['s_store_logo']['name']))
				{
					$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'s_store_logo','','',$this->allowedExt);    
					$arr_upload_res = explode('|',$s_uploaded_filename);
				}
			if(($arr_upload_res[0]==='err'))/////invalid
				{
					$this->session->set_userdata(array('message'=>$this->cls_msg["img_upload_err"],'message_type'=>'err'));
					redirect(admin_base_url().'manage_store/add_information');	
				}
			else
				{
					if($arr_upload_res[0]==='ok')
						{
							get_image_thumb($this->uploaddir.$arr_upload_res[2], $this->thumbdir, 'thumb_'.$arr_upload_res[2],$this->thumb_ht,$this->thumb_wd);  // get thumb image
							get_image_thumb($this->uploaddir.$arr_upload_res[2], $this->thumbdirmain, 'thumb_'.$arr_upload_res[2],$this->thumb_ht_main,$this->thumb_wd_main); 
							get_image_thumb($this->uploaddir.$arr_upload_res[2], $this->thumbdir_fb, 'thumb_'.$arr_upload_res[2],'200','200');								
						}
				}
				
				
				if(isset($_FILES['s_store_banner']) && !empty($_FILES['s_store_banner']['name']))
				{
					$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'s_store_banner','','',$this->allowedExt);    
					$arr_upload_res2 = explode('|',$s_uploaded_filename);
				}
			if(($arr_upload_res2[0]==='err'))/////invalid
				{
					$this->session->set_userdata(array('message'=>$this->cls_msg["img_upload_err"],'message_type'=>'err'));
					redirect(admin_base_url().'manage_store/add_information');	
				}
			else
				{
					if($arr_upload_res2[0]==='ok')
						{
							get_image_thumb($this->uploaddir.$arr_upload_res2[2], $this->thumbdir, 'thumb_'.$arr_upload_res2[2],$this->thumb_ht_banner,$this->thumb_wd_banner);  // get thumb image
															
						}
				}
				
					/*$prefix_url=array("www.","http://","http://www.");
					$entered_store_url=$this->input->post("s_store_url");
					$store_url=str_replace($prefix_url,"",$entered_store_url);*/
					$store_url	= getSeoUrl($this->db->STORE,$this->input->post("s_store_title"));
					
                    $info	= array(										
										"s_store_title"						=> $this->input->post("s_store_title"),
										"s_store_url"						=> $this->input->post("s_store_url"),
										"i_is_active"						=> $this->input->post("i_is_active"),
										"i_cat_id"							=> $this->input->post("i_cat_id"),
										"s_store_logo"						=> $arr_upload_res[2],
										"s_store_banner"					=> $arr_upload_res2[2],
										"s_about_us"						=> $this->input->post("s_about_us"),
										"s_address"							=> $this->input->post("s_address"),
										"i_cat_id"							=> $this->input->post("i_cat_id"),
										"s_meta_title"						=> $this->input->post("s_meta_title"),
										"s_meta_description"				=> $this->input->post("s_meta_description"),
										"s_meta_keyword"					=> $this->input->post("s_meta_keyword"),
										"s_url"								=> $store_url,
										
									);
									//pr($info,1);
					$inserted_user_id	= $this->store_model->add_info($info);					
					
					
					if($inserted_user_id)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list");
                    }
					else
					{
						get_file_deleted($this->uploaddir,$arr_upload_res[2]);
						get_file_deleted($this->thumbdir,'thumb_'.$arr_upload_res[2]);
						get_file_deleted($this->thumbdirmain,'thumb_'.$arr_upload_res[2]);
						get_file_deleted($this->thumbdir,'thumb_'.$arr_upload_res2[2]);
						set_error_msg($this->cls_msg["database_err"]);
					}
					
                }
                
            }
            ////////////end Submitted Form///////////
            $this->render("manage_store/add-edit");
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
    { //echo $i_id;
          
        try
        { //echo "12"."$i_td";
			
            $this->data['title']		="Edit Store";////Browser Title
            $this->data['heading']		="Edit Store";
            $this->data['pathtoclass']	=$this->pathtoclass;
            $this->data['mode']			="edit";
			
            ////////////Submitted Form///////////
            if($_POST)
            {	
				$posted=array();
                $posted["h_mode"]				= $this->data['mode'];
				$posted["s_store_title"]		= trim($this->input->post("s_store_title"));
				$posted["s_store_url"]			= trim($this->input->post("s_store_url"));	
				$posted["i_is_active"]			= trim($this->input->post("i_is_active"));
				$posted["i_cat_id"]				= $this->input->post("i_cat_id");
				$posted["s_about_us"]			= $this->input->post("s_about_us");
				$posted["s_address"]			= $this->input->post("s_address");
				$posted["i_cat_id"]				= $this->input->post("i_cat_id");
				$posted["h_s_image"]			= trim($this->input->post("h_s_image"));
				$posted["h_s_image_banner"]		= trim($this->input->post("h_s_image_banner"));
				$posted["h_id"]					= trim($this->input->post("h_id"));
				//$posted["h_s_brand_logo"] 		= trim($this->input->post("h_s_brand_logo"));
				$posted["s_meta_title"]			= trim($this->input->post("s_meta_title"));
				$posted["s_meta_description"]	= trim($this->input->post("s_meta_description"));
				$posted["s_meta_keyword"]		= trim($this->input->post("s_meta_keyword"));
				//print_r($posted);
				$this->form_validation->set_rules('s_store_title',' Title','required');
				$this->form_validation->set_rules('s_store_url',' URL','required');
				$this->form_validation->set_rules('i_is_active',' Status','required');
				$this->form_validation->set_rules('s_about_us',' About Store','required');
				//$this->form_validation->set_rules('s_address','Store Address','required');
				
                if($this->form_validation->run() == FALSE)////invalid
                {
                    //////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;       
                }
                else///validated, now save into DB
                {	
					if(isset($_FILES['s_store_logo']) && !empty($_FILES['s_store_logo']['name']))
					{
						$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'s_store_logo','','',$this->allowedExt);    
						 $arr_upload_res = explode('|',$s_uploaded_filename);
					}
					if(($arr_upload_res[0]==='err'))/////invalid
					{
						$this->session->set_userdata(array('message'=>$this->cls_msg["img_upload_err"],'message_type'=>'err'));
						redirect(base_url().'manage_store/modify_information');	
					}
					else
					{
						if($arr_upload_res[0]==='ok')
						{
							get_image_thumb($this->uploaddir.$arr_upload_res[2], $this->thumbdir, 'thumb_'.$arr_upload_res[2],$this->thumb_ht,$this->thumb_wd);  // get thumb image
							get_image_thumb($this->uploaddir.$arr_upload_res[2], $this->thumbdirmain, 'thumb_'.$arr_upload_res[2],$this->thumb_ht_main,$this->thumb_wd_main); 
							get_image_thumb($this->uploaddir.$arr_upload_res[2], $this->thumbdir_fb, 'thumb_'.$arr_upload_res[2],'200','200'); 								
						}
					}
					
					
					
					if(isset($_FILES['s_store_banner']) && !empty($_FILES['s_store_banner']['name']))
					{
						$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'s_store_banner','','',$this->allowedExt);    
						 $arr_upload_res2 = explode('|',$s_uploaded_filename);
					}
					if(($arr_upload_res2[0]==='err'))/////invalid
					{
						$this->session->set_userdata(array('message'=>$this->cls_msg["img_upload_err"],'message_type'=>'err'));
						redirect(base_url().'manage_store/modify_information');	
					}
					else
					{
						if($arr_upload_res2[0]==='ok')
						{
							get_image_thumb($this->uploaddir.$arr_upload_res2[2], $this->thumbdir, 'thumb_'.$arr_upload_res2[2],$this->thumb_ht_banner,$this->thumb_wd_banner);  // get thumb image
							 								
						}
					}
					
					/*$prefix_url=array("www.","http://","http://www.");
					$entered_store_url=$posted["s_store_url"];
					$store_url=str_replace($prefix_url,"",$entered_store_url);*/
					$store_url						= getSeoUrl($this->db->STORE,$posted["s_store_title"],$posted["h_id"]);
					$info							= array();
					$info["s_store_title"]			= $posted["s_store_title"];
					$info["s_store_url"]			= $posted["s_store_url"];
					$info["i_is_active"]			= $posted["i_is_active"];
					$info["s_about_us"]				= $posted["s_about_us"];
					$info["s_address"]				= $posted["s_address"];
					$info["i_cat_id"]				= $posted["i_cat_id"];
					$info["s_meta_title"]			= $posted["s_meta_title"];
					$info["s_meta_description"]		= $posted["s_meta_description"];
					$info["s_meta_keyword"]			= $posted["s_meta_keyword"];
					$info["s_url"]					= $store_url;					
					if(count($arr_upload_res)>0)
					{
						$info["s_store_logo"]		= $arr_upload_res[2];
					}
					else
					{
						$info["s_store_logo"]		= $posted["h_s_image"];
					}
					
					
					
					if(count($arr_upload_res2)>0)
					{
						$info["s_store_banner"]		= $arr_upload_res2[2];
					}
					else
					{
						$info["s_store_banner"]		= $posted["h_s_image_banner"];
					}
					
                    $i_aff=$this->store_model->edit_info($info, decrypt($posted["h_id"]));
                    if($i_aff)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list");
                    }
                    else///Not saved, show the form again
                    {
                        $this->data["posted"]=$posted;
                        //set_error_msg($this->cls_msg["save_err"]);
						redirect($this->pathtoclass."show_list");
                    }
                    unset($info,$posted, $i_aff);
                    
                }
            }
            else
            { 
                $info=$this->store_model->fetch_this(decrypt($i_id));		
				//pr($info,1);	
                $posted=array();
				$posted["s_store_title"]		= trim($info[0]["s_store_title"]);
				$posted["s_store_url"]			= trim($info[0]["s_store_url"]);
				$posted["i_is_active"]			= trim($info[0]["i_is_active"]);
				$posted["s_store_logo"]			= trim($info[0]["s_store_logo"]);
				$posted["s_store_banner"]		= trim($info[0]["s_store_banner"]);
				$posted["i_cat_id"]				= trim($info[0]["i_cat_id"]);
				$posted["s_about_us"]			= trim($info[0]["s_about_us"]);
				$posted["s_address"]			= trim($info[0]["s_address"]);
				$posted["s_meta_title"]			= trim($info[0]["s_meta_title"]);
				$posted["s_meta_description"]	= trim($info[0]["s_meta_description"]);
				$posted["s_meta_keyword"]		= trim($info[0]["s_meta_keyword"]);
				$posted["h_id"]				= $i_id;
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("manage_store/add-edit");
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
							//$i_ret_=$this->store_model->delete_info(-1);
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
								$if_exist= $this->store_model->check_in_cpn_table(decrypt($id[$tot]));
								if(!$if_exist)
								{
									$i_ret_=$this->store_model->delete_info(decrypt($id[$tot]));
								}
								$tot--;
							}
							}
							elseif($id>0)///Deleting single Records
							{
								$if_exist= $this->store_model->check_in_cpn_table(decrypt($id[$tot]));
								if(!$if_exist)
								{
								$i_ret_=$this->store_model->delete_info(decrypt($id));
								}
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
                $info=$this->store_model->fetch_this(decrypt($i_id));
				
                if(!empty($info))
                {
                    $temp=array();
                    $temp["i_id"]= encrypt($info[0]["i_id"]);////Index 0 must be the encrypted PK 
					$temp["s_store_title"]	= trim($info[0]["s_store_title"]);
					$temp["s_store_logo"]	= trim($info[0]["s_store_logo"]);
					$temp["s_status"]		= trim($info[0]["i_is_active"])==1?'Active':'Deactive';
					//pr($temp);
					$this->data["info"]=$temp;
                    unset($temp);
					
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.7.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
          
            $this->render("manage_store/show_detail",TRUE);
            unset($i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }	
	
	
	
	
	public function show_list($order_name='s_store_title',$order_by='asc',$start=NULL,$limit=NULL)
	{
		try
        {
           
			$this->data['heading']="Manage Store";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
			
            $s_store=($this->input->post("h_search")?$this->input->post("s_store"):$this->session->userdata("s_store")); 
			//$srch_username=($this->input->post("h_search")?$this->input->post("srch_username"):$this->session->userdata("srch_username")); 
            //$srch_dt=($this->input->post("h_search")?$this->input->post("srch_dt"):$this->session->userdata("srch_dt"));
            ////////end Getting Posted or session values for search///
            
			
            // $s_where=" WHERE i_user_type=2 ";/////////////////////////1====
		
            if($s_search=="basic")
            {
                $s_where =" WHERE (s_store_title LIKE '%".my_receive_like($s_store)."%' )";
				
                /////Storing search values into session///
                $this->session->set_userdata("s_store",$s_store);
				//$this->session->set_userdata("srch_username",$srch_username);
				//$this->session->set_userdata("srch_dt",$srch_dt);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_store"]=$s_store;
				//$this->data["srch_username"]=$srch_username;
				//$this->data["srch_dt"]=$srch_dt;
				//echo $s_where;*/
                /////end Storing search values into session///
            }
           
            else////List all records, **not done
            {
               //$s_where=" WHERE n.id!=1 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("s_store");
                //$this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["s_store"]="";                
               // $this->data["txt_created_on"]="";             
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
			$arr_sort = array(0=>'i_id',1=>'s_title');
			$s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
            $s_order_name='s_store_title';//added to make store alphabaically sorted
            
            $limit	= $this->i_admin_page_limit;
            
			$info	= $this->store_model->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);///////////test
				//print_r ($info);
            /////////Creating List view for displaying/////////
			$table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]     		=	"Store";
            $table_view["total_rows"]		=	count($info);
			$table_view["total_db_records"]	=	$this->store_model->gettotal_info($s_where);
			$table_view["order_name"]		=	$order_name;
			$table_view["order_by"]  		=	$order_by;
            $table_view["src_action"]		= 	$this->pathtoclass.$this->router->fetch_method(); 
            $table_view["detail_view"]		=   TRUE;          
            $table_view["headers"][0]["width"]	="25%";
            $table_view["headers"][0]["align"]	="left";
            //$table_view["headers"][0]["val"]	="Serial Number";
			//$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][0]["val"]	="Logo";
			$table_view["headers"][1]["val"]	="Store Name";
			 $table_view["headers"][1]["align"]	="center";
			 $table_view["headers"][2]["align"]	="center";
			$table_view["headers"][2]["val"]	="Vote";
			$table_view["headers"][3]["val"]	="Status"; 
			 $table_view["headers"][3]["align"]	="center";
			  $table_view["headers"][4]["align"]	="center";
			 $table_view["headers"][4]["val"]	="Popular Store";
			  $table_view["headers"][5]["align"]	="center";
			 $table_view["headers"][5]["val"]	="Max Discounted Store";
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {	
				$sql= "SELECT COUNT(*) as total FROM cd_vote WHERE i_store_id = ".$info[$i]["i_id"];
				$vote = $this->db->query($sql);
				$vote1=$vote->result_array();
				//pr($vote1);
                $img = $info[$i]["s_store_logo"] != ''? '<img src="'.base_url().'uploaded/store/thumb/thumb_'.$info[$i]['s_store_logo'].'" />' : '<img src="'.base_url().'uploaded/img/no_image.jpg"/>';
				$info[$i]["s_is_active"] = ($info[$i]["i_status"]==1)?'Active':'Inactive';
				
				$i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);////Index 0 must be the encrypted PK 
                //$table_view["tablerows"][$i][$i_col++]	= $info[$i]["i_id"];
				$table_view["tablerows"][$i][$i_col++]	=  $img;
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_store_title"];
				$table_view["tablerows"][$i][$i_col++]	='<a href="'.admin_base_url().'manage_vote/show_vote/'.$info[$i]["i_id"].' " target="_blank">'.$vote1[0]['total'].'</a>';
				
				if($this->data['action_allowed']["Status"])
				{
				 	if($info[$i]["i_is_active"] == 1)
					{
				
                        $action ='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_inactive">
                        <img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/tick.png"></a>';
                         
					}
					else
					{ 
                        $action ='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_active">
                        <img width="12" height="12" title="Active" alt="Active" src="images/admin/reject.png"></a>';
					}
				// $table_view["tablerows"][$i][$i_col++]	=($info[$i]["i_is_active"] == 1)?$action."  "."Active":$action." "."Inactive";
				 $table_view["tablerows"][$i][$i_col++]	= $action;
				 $is_hot_checked = $info[$i]["i_is_hot"];
						
						if($is_hot_checked==1)
							$chk	= 'checked="checked"';
						else
							$chk	= "";
							$is_hot = '<input type = "checkbox" '.$chk.' id="i_is_hot_'.($info[$i]["i_id"]).'" name="i_is_hot" onclick=" return hot_status_check('.($info[$i]["i_id"]).' );" />';
				 $table_view["tablerows"][$i][$i_col++]	= $is_hot;
				 
				 $is_max_discount = $info[$i]["i_is_discount"];
						
						if($is_max_discount==1)
							$chk	= 'checked="checked"';
						else
							$chk	= "";
							$is_discount = '<input type = "checkbox" '.$chk.' id="is_discount'.($info[$i]["i_id"]).'" name="i_is_hot" onclick=" return discount_status_check('.($info[$i]["i_id"]).' );" />';
				 $table_view["tablerows"][$i][$i_col++]	= $is_discount;
				 
				}
			
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
				$if_exist= $this->store_model->check_in_cpn_table($posted["id"]);
				if(!$if_exist)
				{
					$posted["i_status"]     = trim($this->input->post("i_status"));
					$info = array();
					$info['i_is_active']    = $posted["i_status"]  ;
					$i_rect=$this->store_model->change_status($info,$posted["id"]); /*don't change*/				
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
				else
				{
					echo "cpn_exist_error";
				}
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }  
	
	public	function get_coupon_hot_status()
	{
		$current_store_id	= $this->input->post('current_coupon_id');
		
		$store_details		= $this->store_model->fetch_this($current_store_id);		
		
		if($store_details[0]['i_is_active']==1)
			echo $this->store_model->get_coupon_hot_status($current_store_id);
		else
			echo 0;
		
	}	
	
	public function change_hot_status()
	{
		try
		{
			$current_coupon_id	= $this->input->post('current_coupon_id');
			$current_coupon_status	= $this->input->post('current_coupon_status');
			echo $this->store_model->update_hot_coupon_status($current_coupon_id, $current_coupon_status);
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
	}
	
	
	public	function get_coupon_discount_status()
	{
		$current_store_id	= $this->input->post('current_coupon_id');
		
		$store_details		= $this->store_model->fetch_this($current_store_id);		
		
		if($store_details[0]['i_is_active']==1)
			echo $this->store_model->get_coupon_discount_status($current_store_id);
		else
			echo 0;
		
	}	
	
	
	
public function change_discount_status()
	{
		try
		{
			$current_coupon_id	= $this->input->post('current_coupon_id');
			$current_coupon_status	= $this->input->post('current_coupon_status');
			echo $this->store_model->update_discount_coupon_status($current_coupon_id, $current_coupon_status);
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
	}
	
	    
	public function __destruct()
    {}
}