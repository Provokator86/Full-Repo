<?php
/*********
* Author: SW
* Date  : 3 June 2016
* Purpose:
*  Controller For Manage User
* 
* @package General
* @subpackage Manage User
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/site_model.php
* @link views/admin/Manage_admin_user/
*/
//require_once APPPATH."/third_party/rs/OAuth.php";

class Manage_admin_user extends MY_Controller
{
    public $cls_msg;//All defined error messages. 
    public $pathtoclass, $tbl, $tbl_role, $tbl_menu,$tbl_menu_permit, $tbl_user_menu, $tbl_user_type, $user_img_width, $user_img_height, $allowedImgExt, $uploadImgdir, $thumbImgdir, $showImgDir, $thumbImgHt, $thumbImgWd ;   
    public function __construct()
    {            
        try
        {
			parent::__construct();
			$this->data['title'] = addslashes(t("Manage Users"));//Browser Title
			
			//Define Errors Here//
			$this->cls_msg = array();
			$this->cls_msg["no_result"]		= addslashes(t("No information found about User."));
			$this->cls_msg["save_err"]		= addslashes(t("Information about User failed to save."));
			$this->cls_msg["save_succ"]		= addslashes(t("Information about User saved successfully."));
			$this->cls_msg["delete_err"]	= addslashes(t("Information about User failed to remove."));
			$this->cls_msg["delete_succ"]	= addslashes(t("Information about User removed successfully."));
			
			//end Define Errors Here//
			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
            
            
            $loggedin   = $this->session->userdata('admin_loggedin');
            $this->user_type  = decrypt($loggedin["user_type_id"]);
			
			//table info
            $this->tbl = $this->db->USER;
            $this->tbl_role = $this->db->USERROLE;
            $this->tbl_menu = $this->db->MENU;
            $this->tbl_menu_permit = $this->db->MENUPERMIT;
            $this->tbl_user_menu = $this->db->USERMENU;
			$this->tbl_user_type = $this->db->USER_TYPE;
			
			// loading default model here //
			$this->load->model("user_login","mod_rect");
			$this->load->model("user_type_model","mod_utype");
			// end loading default model here //
			
			$this->data['BREADCRUMB'] = array(addslashes(t('Manage User')));
            $this->allowedImgExt   = 'jpg|png|jpeg';
            //for uploading images to this folder
            $this->uploadImgdir    = $this->config->item('user_image_upload_path');        
            //for uploading image thumbnails to this folder
            $this->thumbImgdir     = $this->config->item('user_image_thumb_upload_path');    
            //for display thumbnails image 
            $this->showImgDir      = $this->config->item('user_image_display_path');
            // Thumb Height
            $this->thumbImgHt  = $this->config->item('user_image_thumb_height');    
            // Thumb Width
            $this->thumbImgWd   = $this->config->item('user_image_thumb_width');             
            $this->user_img_width   = $this->config->item('profile_img_width');   
            $this->user_img_height  = $this->config->item('profile_img_height');
            
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
    public function show_list($order_by = '', $sort_type = 'ASC', $start=NULL,$limit=NULL)
    {
        try
		{
			$this->data['heading'] = addslashes(t("Manage Users"));//Package Name[@package] Panel Heading
			$this->session->unset_userdata('last_uri');
            //_update_total_active_business_post();
			//generating search query//
			$arr_session_data    =    $this->session->userdata("arr_session");
			if($arr_session_data['searching_name'] != $this->data['heading'])
			{
				$this->session->unset_userdata("arr_session");
				$arr_session_data   =   array();
			}
			$search_variable     =    array();
			
			//Getting Posted or session values for search//        
			$s_search 	=(isset($_GET["h_search"])?$this->input->get("h_search"):$this->session->userdata("h_search"));
            $search_variable["s_user_name"] = ($this->input->get("h_search")?$this->input->get("s_user_name"):$arr_session_data["s_user_name"]);
            $search_variable["role_id"] = ($this->input->get("h_search")?$this->input->get("role_id"):$arr_session_data["role_id"]);
            $search_variable["alphabate_pagination"] = ($this->input->get("h_search")?$this->input->get("alphabate_pagination"):$arr_session_data["alphabate_pagination"]);
            
			$search_variable["s_user_email"] = ($this->input->get("h_search")?$this->input->get("s_user_email"):$arr_session_data["s_user_email"]);
			//end Getting Posted or session values for search//  
            if(decrypt($this->data['admin_loggedin']['user_type_id'])>1)          
			    $s_where = " WHERE n.i_user_type != 1 AND n.e_deleted = 'No' ";
			else
                $s_where = " WHERE n.i_user_type != 1 AND n.e_deleted = 'No' ";
            #$s_where.= " AND n.i_id NOT IN(1,2)"; // do not show system admin
			if($s_search=="advanced")
			{
                if($search_variable["alphabate_pagination"]!="")
                    $s_where .= " AND CONCAT_WS(' ',n.s_last_name,n.s_first_name) LIKE '".addslashes($search_variable["alphabate_pagination"])."%' ";
				if($search_variable["s_user_name"]!="")
                    $s_where .= " AND CONCAT_WS(' ',n.s_first_name,n.s_last_name) LIKE '%".addslashes($search_variable["s_user_name"])."%' ";
                if($search_variable["s_user_email"]!="")
					$s_where .= " AND s_email LIKE '%".addslashes($search_variable["s_user_email"])."%' ";
                if($search_variable["role_id"] != "")
                    $s_where .= " AND (SELECT COUNT(1) FROM {$this->tbl_role} AS r WHERE r.i_user_id = n.i_id AND r.i_role_id = ".decrypt($search_variable["role_id"])." LIMIT 1) >= 1";
				
				$arr_session    =   array();                
				$arr_session["searching_name"]  = $this->data['heading'] ;        
                $arr_session["s_user_name"]     = $search_variable["s_user_name"] ;
                $arr_session["s_user_email"]    = $search_variable["s_user_email"] ;
                $arr_session["role_id"]         = $search_variable["role_id"] ;
				$arr_session["alphabate_pagination"] = $search_variable["alphabate_pagination"] ;
				$this->session->set_userdata("arr_session",$arr_session);
				$this->session->set_userdata("h_search",$s_search);
				$this->data["h_search"]     = $s_search;
                $this->data["s_user_name"]  = $search_variable["s_user_name"];                
                $this->data["s_user_email"] = $search_variable["s_user_email"];                
                $this->data["role_id"]         = $search_variable["role_id"];                
				$this->data["alphabate_pagination"] = $search_variable["alphabate_pagination"];                
			}
			else//List all records, **not done
			{
				//Releasing search values from session//
				$this->session->unset_userdata("arr_session");
				$this->session->unset_userdata("h_search");
				
				$this->data["h_search"]		= $s_search;
                $this->data["s_user_name"]  = "";                            
                $this->data["s_user_email"] = "";                            
                $this->data["role_id"]      = "";                            
				$this->data["alphabate_pagination"] = "";                            
				//end Storing search values into session//                 
			}
			unset($s_search,$arr_session,$search_variable);

			//Setting Limits, If searched then start from 0//
            $this->i_uri_seg = 6;
            $start = $this->input->post("h_search") ? 0 : $this->uri->segment($this->i_uri_seg);
			//end generating search query//
			
			$limit	= $this->i_admin_page_limit;
            $arr_sort = array(0=>'s_last_name', 1=>'s_email', 2=>'s_user_type', 3 => 'i_user_type', 4=> 'i_sort_order');
            #$order_by= !empty($order_by)?in_array(decrypt($order_by),$arr_sort)?decrypt($order_by):$arr_sort[4]:$arr_sort[4];
            $order_by= !empty($order_by)?in_array(decrypt($order_by),$arr_sort)?decrypt($order_by):$arr_sort[0]:$arr_sort[0];
            if($order_by != '')
                $s_where .= " ORDER BY $order_by $sort_type ";
			$info = $this->mod_rect->fetch_multi($s_where, intval($start),$limit );
			
			
			$this->session->set_userdata('last_uri',$start);
			
			//Creating List view for displaying//
			$table_view=array();  
			
			//Table Headers, with width,alignment//
			$table_view["caption"]				= addslashes(t("Manage User"));
			$table_view["total_rows"]		  	= count($info);
			$table_view["total_db_records"]		= $this->mod_rect->gettotal_info($s_where);
			$table_view["detail_view"]         	= false;  //   to disable show details. 
            $table_view["order_name"]           = encrypt($order_by);
            $table_view["order_by"]             = $sort_type;
            $table_view["src_action"]           = $this->pathtoclass.$this->router->fetch_method();
            
			$j = 0;
			$table_view["headers"][$j]["width"]		="30%";
			$table_view["headers"][$j]["align"]		="left";
			$table_view["headers"][$j]["val"]		= addslashes(t("Name"));
            $table_view["headers"][$j]["sort"]      = array('field_name'=>encrypt($arr_sort[0]));
			
			$table_view["headers"][++$j]["val"]		= addslashes(t("Email"));
			$table_view["headers"][$j]["width"]		= "30%";
			$table_view["headers"][$j]["align"]		= "left";
            $table_view["headers"][$j]["sort"]      = array('field_name'=>encrypt($arr_sort[1]));
			
			/*$table_view["headers"][++$j]["val"]		= "User Role";
			$table_view["headers"][$j]["width"]    	="15%";
			$table_view["headers"][$j]["align"]    	="left";*/
          
            /*if($this->data['action_allowed']['Customize User Access'] === 1) // User type access check
            {
                $table_view["headers"][++$j]["val"]     = "Customize Permission/Status";
                $table_view["headers"][$j]["width"]     = "15%";
                $table_view["headers"][$j]["align"]     = "center";
            }*/
            
			/*$table_view["headers"][++$j]["val"]		= addslashes(t("Status"));
			$table_view["headers"][$j]["width"]		= "10%";
			$table_view["headers"][$j]["align"]		= "left";*/
			//end Table Headers, with width,alignment//
			
			//Table Data//
			for($i=0; $i<$table_view["total_rows"]; $i++)
			{
				$i_col = 0;
                $role_info = $this->ajax_get_user_role(encrypt($info[$i]["i_id"]), true);
                if(count($role_info) > 0)
                {
                    for($role = 0; $role < count($role_info); $role++)
                    {
                        //$text[] = $role_info[$role]['s_user_type'];
                        $str = $role_info[$role]['s_user_type'];
                        if($role_info[$role]['i_role_id'] == 8)
                            $str.=' <i class="fa fa-chevron-right"></i> '.$role_info[$role]['i_office_number'].'-'.$role_info[$role]['s_franchise_name'];
                        else if($role_info[$role]['region'] != '')
                            $str.=' <i class="fa fa-chevron-right"></i> '.$role_info[$role]['i_region_number'].'-'.$role_info[$role]['region'];
                        $text[] = $str;
                    }
                    $user_role = '<span class="label label-danger label-custom">'.implode('</span> <span class="label label-danger label-custom">', $text).'</span>';
                }
                else $user_role = '--';
                unset($text, $role_info);
                // phone numbers string
                $phone_str = '';
                $phn_br = '';
                if($info[$i]["s_telephone"]!='')
                {
                    $phone_str.='</br>'.'Ph1: '.$info[$i]["s_telephone"];
                    $phn_br = '</br>';
                }
                if($info[$i]["s_cell_phone"]!='')
                    $phone_str.=$phn_br.'Ph2: '.$info[$i]["s_cell_phone"];
                // status button
                $stat_btn=  '';
                if($info[$i]["i_status"] == 1)  
                    $stat_btn ='</br>'.'<span style="margin-top:5px; display:inline-block;" class="label label-success" id="status_row_id_'.$info[$i]["i_id"].'">Active</span>';
                else
                    $stat_btn ='</br>'.'<span style="margin-top:5px; display:inline-block;"  class="label label-warning" id="status_row_id_'.$info[$i]["i_id"].'">Inactive</span>';
                    
                if($info[$i]["i_front_display"] == 1)  
                    $stat_btn .='</br>'.'<span style="margin-top:5px; display:inline-block;" class="label label-success" id="display_row_id_'.$info[$i]["i_id"].'">Display in Frontend</span>';
                else
                    $stat_btn .='</br>'.'<span style="margin-top:5px; display:inline-block;"  class="label label-warning" id="display_row_id_'.$info[$i]["i_id"].'">No Display in Frontend</span>';
                
                
				$table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);
				$table_view["tablerows"][$i][$i_col++]	= trim($info[$i]["s_last_name"].', '.$info[$i]["s_first_name"],',').'</br>'.$info[$i]["s_email"].$phone_str;
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_email"];
                //$table_view["tablerows"][$i][$i_col++]  = $user_role;
                //$table_view["tablerows"][$i][$i_col++]  = 'Post: <a class="cnt_link" href="javascript:">'.$info[$i]["i_total_post"].'</a></br>Active: <a class="cnt_link" href="javascript:">'.$info[$i]["i_total_active"].'</a></br>Expired: <a class="cnt_link" href="javascript:">'.$info[$i]["i_total_expired"].'</a>';
                /*if($this->data['action_allowed']['Customize User Access'] === 1) // User type access check
                {
                    if(decrypt($this->data['admin_loggedin']['user_type_id']) <= 3 && $info[$i]["i_id"] != $this->data['admin_details']['i_id'] && $info[$i]["i_id"] > 3) 
                    {	
                        $table_view["tablerows"][$i][$i_col++]	= '<a data-toggle="tooltip" data-placement="bottom" title="Customize User Access Permission" class="ajax btn btn-xs btn-warning user-access-permission" href="'.$this->pathtoclass.'ajax_get_user_role/'.encrypt($info[$i]["i_id"]).'"><i class="fa fa-gears"></i></a>'.$stat_btn;
                    }
                    else
                    {
                        $table_view["tablerows"][$i][$i_col++] = '<a data-toggle="tooltip" data-placement="bottom" title="You cannot customize this Access Permission" class="btn btn-danger btn-xs" href="javascript:;"><i class="fa fa-gears"></i></a>'.$stat_btn;
                    }
                }
                */
				
                $action ='';
				if($info[$i]["i_status"] == 1)				
				{
					//$table_view["tablerows"][$i][$i_col++] = '<span class="label label-success" id="status_row_id_'.$info[$i]["i_id"].'">Active</span>';
                    $action .='<a data-toggle="tooltip" data-placement="bottom" title="Make Inactive" class="glyphicon glyphicon-ok" id="approve_img_id_'.$info[$i]["i_id"].'_inactive" href="javascript:void(0);" rel="make_inactive"></a>';
				}
				else
				{
					//$table_view["tablerows"][$i][$i_col++] = '<span class="label label-warning" id="status_row_id_'.$info[$i]["i_id"].'">Inactive</span>';
                    $action .='<a data-toggle="tooltip" data-placement="bottom" title="Make Active" class="glyphicon glyphicon-ban-circle" id="approve_img_id_'.$info[$i]["i_id"].'_active" href="javascript:void(0);" rel="make_active"></a>';
				}
                
                
                if($info[$i]["i_front_display"] == 1)                
                {
                    $action .='&nbsp;<a data-toggle="tooltip" data-placement="bottom" title="Remove Display Frontend" class="glyphicon glyphicon-eye-open" id="front_img_id_'.$info[$i]["i_id"].'_inactive" href="javascript:void(0);" rel="make_inactive"></a>';
                }
                else
                {
                    $action .='&nbsp;<a data-toggle="tooltip" data-placement="bottom" title="Display Frontend" class="glyphicon glyphicon-eye-close" id="front_img_id_'.$info[$i]["i_id"].'_active" href="javascript:void(0);" rel="make_active"></a>';
                }
				
				if($action!='')
					$table_view["rows_action"][$i] = $action;     
			} 
			//end Table Data//
			unset($i,$i_col,$start,$limit); 
            
			// Show alphabate pagination
            $table_view['show_alphabate_pagination'] = 'yes';
            $table_view['alphabate_pagination'] = $this->data["alphabate_pagination"];
            
			$this->data["table_view"] = $this->admin_showin_order_table($table_view,TRUE);
			//Creating List view for displaying//
			$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();//used for search form action
			//echo $this->data["search_action"];
			
            // Get all the user type
            $param['user_type_id'] = decrypt($this->data['admin_loggedin']['user_type_id']);
            $this->data['user_type'] = $this->mod_utype->get_all_user_type($param);
            
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
            $this->data['title']		= addslashes(t("Manage Users"));//Browser Title
            $this->data['heading']		= (t("Add Information"));
            $this->data['pathtoclass']	= $this->pathtoclass;
			$this->data['BREADCRUMB']	= array(addslashes(t('Add Information')));
			$this->data['mode']			= "add";
           
            if($_POST)
            {
				$posted = array();
                $posted["s_first_name"]	    = $this->input->post("txt_first_name", true);
				$posted["s_last_name"]      = $this->input->post("txt_last_name", true);
				$posted["s_email"]          = $this->input->post("txt_email", true);
				//$posted["s_user_name"]      = $this->input->post("txt_user_name", true);
				$posted["s_password"]       = trim($this->input->post("txt_password"));
				$posted["i_user_type"]      = decrypt($this->input->post("opt_user_type", true));
                
                $posted["s_title"]                  = trim($this->input->post("s_title"));
                $posted["s_credentials"]            = trim($this->input->post("s_credentials"));
                $posted["s_display_name"]           = trim($this->input->post("s_display_name"));
                $posted["s_company_name"]           = trim($this->input->post("s_company_name"));
                $posted["s_unit"]                   = trim($this->input->post("s_unit"));
                $posted["s_street"]                 = trim($this->input->post("s_street"));
                $posted["i_country_id"]             = trim($this->input->post("i_country_id"));
                $posted["i_time_zone"]              = trim($this->input->post("i_time_zone"));
                $posted["i_region"]                 = trim($this->input->post("i_region"));
                $posted["s_web_site"]               = trim($this->input->post("s_web_site"));
                $posted["i_city_id"]                = trim($this->input->post("i_city_id"));
                $posted["s_postal_code"]            = trim($this->input->post("s_postal_code"));
                $posted["s_telephone"]              = trim($this->input->post("s_telephone"));
                $posted["s_cell_phone"]             = trim($this->input->post("s_cell_phone"));
                $posted["s_bio"]                    = trim($this->input->post("s_bio"));
                $posted["s_expertise"]              = trim($this->input->post("s_expertise"));
                $posted["i_corporate_sort_order"]   = trim($this->input->post("i_corporate_sort_order"));
                $posted["i_regional_sort_order"]    = trim($this->input->post("i_regional_sort_order"));
                $posted["i_ottawa_sort_order"]      = trim($this->input->post("i_ottawa_sort_order"));
                $posted["i_local_sort_order"]       = trim($this->input->post("i_local_sort_order"));
                $posted["i_ma_sort_order"]          = trim($this->input->post("i_ma_sort_order"));
                $posted["i_sf_bay_area_sort_order"] = trim($this->input->post("i_sf_bay_area_sort_order"));
                $posted["i_cema_sort_order"]        = trim($this->input->post("i_cema_sort_order"));
                $posted["s_professional_partner"]   = trim($this->input->post("s_professional_partner"));
                $posted["s_personal_fax"]           = trim($this->input->post("s_personal_fax"));
                $posted["s_personal_phone"]         = trim($this->input->post("s_personal_phone"));
                $posted["s_personal_unit"]          = trim($this->input->post("s_personal_unit"));
                $posted["s_personal_street"]        = trim($this->input->post("s_personal_street"));
                $posted["i_personal_country_id"]    = trim($this->input->post("i_personal_country_id"));
                $posted["i_personal_state_id"]      = trim($this->input->post("i_personal_state_id"));
                $posted["i_personal_city_id"]       = trim($this->input->post("i_personal_city_id"));
                $posted["s_personal_postal_code"]   = trim($this->input->post("s_personal_postal_code"));
                $posted["s_city"]                   = trim($this->input->post("s_city"));
                $dt_start                           = $this->input->post("dt_start");
                $dt_termination                     = $this->input->post("dt_termination");
				
                // Role
                $region_id = $this->input->post('region_id');
                $role_id = $this->input->post('role_id');
                $franchise_id = $this->input->post('franchise_id');
                $flag = true;
                if(intval(decrypt($role_id[0])) == 0)
                {
                    $flag = false;
                    set_error_msg(get_message('usr_typ_emt'));
                }
                
				$this->form_validation->set_rules('txt_first_name', addslashes(t('User first name')), 'required|xss_clean');
				$this->form_validation->set_rules('txt_last_name', addslashes(t('User last name')), 'required|xss_clean');
				$this->form_validation->set_rules('txt_email', addslashes(t('User email')), 'required|xss_clean|valid_email|is_unique['.$this->tbl.'.s_email]');
				$this->form_validation->set_rules('txt_password', addslashes(t('User password')), 'required|xss_clean|matches[txt_con_password]');
				/*$this->form_validation->set_rules('txt_user_name', addslashes(t('User username')), 'required|xss_clean|is_unique['.$this->tbl.'.s_user_name]');*/
                
                
                // password validation @see - common_helper.php
                $msg = '';
                if(!empty($posted["s_password"]))
                {
                    $chk_pwd = chkPasswordValidation($posted["s_password"]);                    
                    if($chk_pwd!=1 && !empty($chk_pwd))
                    {                        
                        foreach($chk_pwd as $key=>$val)
                        {
                            $msg .=$val.'</br>';
                        }
                    }
                }
                
                $err_msg = '';
                //below code for check image width and height on 1 July
                if(isset($_FILES['s_profile_image']) && !empty($_FILES['s_profile_image']['name']))
                {
                    list($width, $height, $type, $attr) = getimagesize($_FILES["s_profile_image"]["tmp_name"]);
                    if($width>0 && $width<$this->user_img_width)
                        $err_msg .= "Minimum image width should be {$this->user_img_width}px ".'</br>';
                    if($height>0 && $height<$this->user_img_height)
                        $err_msg .= "Minimum image height should be {$this->user_img_height}px ".'</br>';
                }
                
				
                if($this->form_validation->run() == FALSE || $flag == false || $msg!='' || $err_msg!='')// invalid
                {					
                    //Display the add form with posted values within it//
                    if($msg!='')
                        set_error_msg($msg);
                        
                    if($err_msg!='')
                        set_error_msg($err_msg);
                        
                    $this->data["posted"] = $posted;
                    
                    // Generate user role data
                    for($i = 0; $i <count($role_id); $i++)
                    {
                        $user_role[] = array(
                            'i_region_id' => $region_id[$i],
                            'i_franchise_id' => $franchise_id[$i],
                            'i_role_id' => decrypt($role_id[$i])
                        ); 
                    }
                    $this->data['user_role'] = $user_role;
                }
                else//validated, now save into DB
                {
					$info = array();
                    $info = $posted;
					$info["s_first_name"]	= $posted['s_first_name'];
					$info["s_last_name"]	= $posted['s_last_name'];
					$info["s_email"]		= $posted['s_email'];
					$info["s_user_name"]	= $posted['s_email'];
					$info["s_password"]		= md5(trim($posted["s_password"]).$this->config->item("security_salt"));
					$info["i_user_type"]	= $posted['i_user_type'];
					$info["i_created_by"]	= decrypt($this->admin_loggedin['user_id']);
                    $info["dt_created_on"]  = now();
                    $info["dt_start"]       = $dt_start?date("Y-m-d H:i:s",strtotime($dt_start)):"";
					$info["dt_termination"]	= $dt_termination?date("Y-m-d H:i:s",strtotime($dt_termination)):"";
					$info["i_status"]		= 1;
                    
                    if(isset($_FILES['s_profile_image']) && !empty($_FILES['s_profile_image']['name']))
                    {
                        $s_filename= get_file_uploaded($this->uploadImgdir,'s_profile_image','','',$this->allowedImgExt);
                        $arr_upload_res = explode('|',$s_filename);
                        if($arr_upload_res[0] ==='ok')
                        {                            
                            get_image_thumb($this->uploadImgdir.$arr_upload_res[2], $this->thumbImgdir, $arr_upload_res[2], $this->thumbImgHt, $this->thumbImgWd);
                            $info['s_profile_image'] = $arr_upload_res[2];
                        }
                    }
                    
					$i_newid = $this->acs_model->add_data($this->tbl,$info);
					
					if($i_newid)//saved successfully
                    {
                        // Add keyword to main table
                        if($posted["s_expertise"] != '')
                        {
                            $keyword = explode(',', $posted["s_expertise"]);
                            for($i = 0; $i < count($keyword); $i++)
                                $_key[]['s_keyword'] = $keyword[$i];
                            @$this->acs_model->add_multiple_data_insert_ignore($this->db->KEYWORD, $_key);
                            unset($_key, $keyword);
                        }
                        
                        // Add new seperately as to check the duplicates
                        $role = array();
                        for($i = 0; $i <count($role_id); $i++)
                        {
                            if($role_id[$i] != '')
                            {
                                $where = array(
                                    'i_user_id' => $user_id, 
                                    'i_region_id'=>$region_id[$i], 
                                    'i_role_id' => decrypt($role_id[$i])
                                );
                                if(intval($franchise_id[$i]) > 0)
                                    $where['i_franchise_id'] = $franchise_id[$i];
                                    
                                // Check duplicates
                                $tmp = $this->acs_model->fetch_data($this->tbl_role, $where);
                                if(empty($tmp)) // Add this new role
                                {
                                    $role = array(
                                        'i_user_id' => $i_newid,
                                        'i_region_id'=> $region_id[$i],
                                        'i_franchise_id'=> $franchise_id[$i],
                                        'i_role_id' => decrypt($role_id[$i]),
                                        'i_created_by' => decrypt($this->admin_loggedin['user_id']),
                                        'i_creator_user_type_id' => decrypt($this->data['admin_loggedin']['user_type_id'])
                                    );
                                    // Insert in to data base
                                    $this->acs_model->add_data($this->tbl_role, $role);
                                } else {
                                    set_error_msg(get_message('dup_rc_rm'));
                                }
                                unset($tmp, $role);
                            }
                        }
                        unset($role_id, $region_id, $franchise_id, $i_newid);
                        
						set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list");
                    }
                    else//Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                }
            }
            //end Submitted Form//
			
			// Get all the user type
            $param['user_type_id'] = decrypt($this->data['admin_loggedin']['user_type_id']);
			$this->data['user_type'] = $this->mod_utype->get_all_user_type($param);
            $this->render("manage_admin_user/add-edit");
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
			$this->data['title']=addslashes(t("Manage Users"));//Browser Title
            $this->data['heading']=addslashes(t("Edit User"));
            $this->data['pathtoclass']=$this->pathtoclass;
			$this->data['BREADCRUMB']	=	array(addslashes(t('Edit Information')));
            $this->data['mode']="edit";	
            $user_id = decrypt($i_id);
            //Submitted Form//
            if($_POST)
            {
                //pr($_POST,1);
				$posted = array();
                // Basic information
                $posted["s_first_name"]	            = $this->input->post("txt_first_name", true);
				$posted["s_last_name"]              = $this->input->post("txt_last_name", true);
				$posted["s_email"]                  = $this->input->post("txt_email", true);
				//$posted["s_user_name"]              = $this->input->post("txt_user_name", true);
				//$posted["i_user_type"]              = decrypt($this->input->post("opt_user_type", true));
				$posted["h_id"]	                    = $this->input->post("h_id", true);
                
                $posted["s_title"]                  = trim($this->input->post("s_title"));
                $posted["s_credentials"]            = trim($this->input->post("s_credentials"));
                $posted["s_display_name"]           = trim($this->input->post("s_display_name"));
                $posted["s_company_name"]           = trim($this->input->post("s_company_name"));
                $posted["s_unit"]                   = trim($this->input->post("s_unit"));
                $posted["s_street"]                 = trim($this->input->post("s_street"));
                $posted["i_country_id"]             = trim($this->input->post("i_country_id"));
                $posted["i_time_zone"]              = trim($this->input->post("i_time_zone"));
                $posted["i_region"]                 = trim($this->input->post("i_region"));
                $posted["s_web_site"]               = trim($this->input->post("s_web_site"));
                $posted["i_city_id"]                = trim($this->input->post("i_city_id"));
                $posted["s_postal_code"]            = trim($this->input->post("s_postal_code"));
                $posted["s_telephone"]              = trim($this->input->post("s_telephone"));
                $posted["s_cell_phone"]             = trim($this->input->post("s_cell_phone"));
                $posted["s_bio"]                    = trim($this->input->post("s_bio"));
                $posted["s_expertise"]              = trim($this->input->post("s_expertise"));
                $posted["i_corporate_sort_order"]   = trim($this->input->post("i_corporate_sort_order"));
                $posted["i_regional_sort_order"]    = trim($this->input->post("i_regional_sort_order"));
                $posted["i_ottawa_sort_order"]      = trim($this->input->post("i_ottawa_sort_order"));
                $posted["i_local_sort_order"]       = trim($this->input->post("i_local_sort_order"));
                $posted["i_ma_sort_order"]          = trim($this->input->post("i_ma_sort_order"));
                $posted["i_sf_bay_area_sort_order"] = trim($this->input->post("i_sf_bay_area_sort_order"));
                $posted["i_cema_sort_order"]        = trim($this->input->post("i_cema_sort_order"));
                $posted["s_professional_partner"]   = trim($this->input->post("s_professional_partner"));
                $posted["s_personal_fax"]           = trim($this->input->post("s_personal_fax"));
                $posted["s_personal_phone"]         = trim($this->input->post("s_personal_phone"));
                $posted["s_personal_unit"]          = trim($this->input->post("s_personal_unit"));
                $posted["s_personal_street"]        = trim($this->input->post("s_personal_street"));
                $posted["i_personal_country_id"]    = trim($this->input->post("i_personal_country_id"));
                $posted["i_personal_state_id"]      = trim($this->input->post("i_personal_state_id"));
                $posted["i_personal_city_id"]       = trim($this->input->post("i_personal_city_id"));
                $posted["s_personal_postal_code"]   = trim($this->input->post("s_personal_postal_code"));
                $posted["s_city"]                   = trim($this->input->post("s_city"));
                $dt_start                           = $this->input->post("dt_start");
                $dt_termination                     = $this->input->post("dt_termination");
                
				$posted['h_profile_image']          = $this->input->post("h_profile_image");
                
                // Role
                $region_id = $this->input->post('region_id');
                $role_id = $this->input->post('role_id');
                $franchise_id = $this->input->post('franchise_id');
                $flag = true;
                if(intval(decrypt($role_id[0])) == 0)
                {
                    $flag = false;
                    set_error_msg(get_message('usr_typ_emt'));
                }
				$this->form_validation->set_rules('txt_first_name', addslashes(t('User first name')), 'required|xss_clean');
                $this->form_validation->set_rules('txt_last_name', addslashes(t('User last name')), 'required|xss_clean');
                $this->form_validation->set_rules('txt_email', addslashes(t('User email')), 'required|xss_clean|valid_email|is_unique['.$this->tbl.'.s_email.i_id.'.decrypt($posted["h_id"]).']');
                /*$this->form_validation->set_rules('txt_user_name', addslashes(t('User username')), 'required|xss_clean|is_unique['.$this->tbl.'.s_user_name.i_id.'.decrypt($posted["h_id"]).']');*/
				$user_id = decrypt($posted["h_id"]); // User id
                
                $err_msg = '';
                //below code for check image width and height on 1 July
                if(isset($_FILES['s_profile_image']) && !empty($_FILES['s_profile_image']['name']))
                {
                    list($width, $height, $type, $attr) = getimagesize($_FILES["s_profile_image"]["tmp_name"]);
                    if($width>0 && $width<$this->user_img_width)
                        $err_msg .= "Minimum image width should be {$this->user_img_width}px ".'</br>';
                    if($height>0 && $height<$this->user_img_height)
                        $err_msg .= "Minimum image height should be {$this->user_img_height}px ".'</br>';
                }
                
                
                if($this->form_validation->run() == FALSE || $flag == FALSE || $err_msg!='')//invalid
                {					
                    //Display the add form with posted values within it//
                    $this->data["posted"] = $posted; 
                                      
                    if($err_msg!='')
                        set_error_msg($err_msg);
                        
                    // Generate user role data
                    for($i = 0; $i <count($role_id); $i++)
                    {
                        $user_role[] = array(
                            'i_region_id' => $region_id[$i],
                            'i_franchise_id' => $franchise_id[$i],
                            'i_role_id' => decrypt($role_id[$i])
                        ); 
                    }
                    $this->data['user_role'] = $user_role;
                }
                else//validated, now save into DB
                {
                    if(isset($_FILES['s_profile_image']) && !empty($_FILES['s_profile_image']['name']))
                    {
                        $s_filename= get_file_uploaded($this->uploadImgdir,'s_profile_image','','',$this->allowedImgExt);
                        $arr_upload_res = explode('|',$s_filename);
                        if($arr_upload_res[0] ==='ok')
                        {
                            
                            get_image_thumb($this->uploadImgdir.$arr_upload_res[2], $this->thumbImgdir, $arr_upload_res[2], $this->thumbImgHt, $this->thumbImgWd);
                            $posted['s_profile_image'] = $arr_upload_res[2];
                        }
                    }
                    $posted['s_profile_image'] = $posted['s_profile_image']?$posted['s_profile_image']:$posted['h_profile_image'];
                    //pr($posted,1);
                    $info = array();
                    $i_id = decrypt($posted["h_id"]);
                    unset($posted["h_id"],$posted['h_profile_image']);
                    $info = $posted;
                
                    // Add keyword to main table
                    if($posted["s_expertise"] != '')
                    {
                        $keyword = explode(',', $posted["s_expertise"]);
                        for($i = 0; $i < count($keyword); $i++)
                            $_key[]['s_keyword'] = $keyword[$i];
                        @$this->acs_model->add_multiple_data_insert_ignore($this->db->KEYWORD, $_key);
                        unset($_key, $keyword);
                    } 
                    
					/*$info["s_first_name"]	= $posted['s_first_name'];
					$info["s_last_name"]	= $posted['s_last_name'];
					$info["s_email"]		= $posted['s_email'];
					$info["i_user_type"]	= $posted['i_user_type'];*/
                    
                    $info["s_user_name"]    = $posted['s_email'];
					$info["i_created_by"]	= decrypt($this->admin_loggedin['user_id']);
					$info["i_status"]		= 1;                    
                    $info["dt_start"]       = $dt_start?date("Y-m-d H:i:s",strtotime($dt_start)):"";
                    $info["dt_termination"] = $dt_termination?date("Y-m-d H:i:s",strtotime($dt_termination)):"";
                    
                    $i_aff = $this->acs_model->edit_data($this->tbl, $info,array('i_id'=>$user_id));
                    if($i_aff)//saved successfully
                    {                      
                        // Update user role
                        // Delete old role
                        $this->acs_model->delete_data($this->tbl_role, array('i_user_id'=> $user_id));
                        
                        // Add new seperately as to check the duplicates
                        $role = array();
                        for($i = 0; $i <count($role_id); $i++)
                        {
                            if($role_id[$i] != '')
                            {
                                $where = array(
                                    'i_user_id' => $user_id, 
                                    'i_role_id' => decrypt($role_id[$i])
                                );
                                if(intval($region_id[$i]) > 0)
                                    $where['i_region_id'] = $region_id[$i];  
                                if(intval($franchise_id[$i]) > 0)
                                    $where['i_franchise_id'] = $franchise_id[$i];

                                // Check duplicates
                                $tmp = $this->acs_model->fetch_data($this->tbl_role, $where);
                                if(empty($tmp)) // Add this new role
                                {
                                    $role = array(
                                        'i_user_id' => $user_id,
                                        'i_region_id'=> $region_id[$i],
                                        'i_franchise_id'=> $franchise_id[$i],
                                        'i_role_id' => decrypt($role_id[$i]),
                                        'i_created_by' => decrypt($this->admin_loggedin['user_id']),
                                        'i_creator_user_type_id' => decrypt($this->data['admin_loggedin']['user_type_id'])
                                    );
                                    // Insert in to data base
                                    $this->acs_model->add_data($this->tbl_role, $role);
                                } else {
                                    set_error_msg(get_message('dup_rc_rm'));
                                }
                                unset($tmp, $role);
                            }
                        }
                        unset($role_id, $region_id, $franchise_id, $user_id);
                        
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list/".$this->session->userdata('last_uri'));

                    }
                    else//Not saved, show the form again
                    {
                        $this->data["posted"]=$posted;
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    unset($info,$posted, $i_aff);
                }
            }
            else
            {
                $user_id = decrypt($i_id);
				$info = $this->mod_rect->fetch_this($user_id);
				$posted = $info[0];
                $posted['h_mode'] = $this->data['mode'];
				$posted["h_id"] = $i_id;
                $this->data["posted"] = $posted;       
                unset($info,$posted); 
                
                // Fetch user role
                $this->data['user_role'] = $this->acs_model->fetch_data($this->tbl_role, array('i_user_id' => $user_id));     
            }
            // end Submitted Form//
            
			// Get all the user type
            $param['user_type_id'] = decrypt($this->data['admin_loggedin']['user_type_id']);
            $this->data['user_type'] = $this->mod_utype->get_all_user_type($param);
            
            $this->render("manage_admin_user/add-edit");
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    public function customize_user_access($user_id = '', $role_id = '')
    {
        $this->load->model('menu_model');
        $this->data['user_id'] = $user_id = intval(decrypt($user_id));
        $this->data['role_id'] = $role_id = intval(decrypt($role_id));
        if($_POST)
        {
            $this->data['user_id'] = $user_id = intval(decrypt($this->input->post('user_id')));
            $this->data['role_id'] = $role_id = intval(decrypt($this->input->post('role_id')));
        }
        if($user_id === 0)
            throw new Exception(t('Seems some error. User not found.'));
            
        // Fetch user account details
        $this->data['user_info'] = $this->acs_model->fetch_data($this->tbl, array('i_id' => $user_id));
        $this->data['user_role_info'] = $this->acs_model->fetch_data($this->tbl_role, array('i_user_id' => $user_id, 'i_role_id' => $role_id));
        
        if($_POST)
        {
            //pr($_POST,1);
            $posted = array();
            $posted['opt_actions'] = $this->input->post('opt_actions');
            $posted['h_action_permit'] = $this->input->post('h_action_permit');
            $posted['h_first_label_menu_id'] = $this->input->post('h_first_label_menu_id');
            $posted['first_label_menu_id'] = $this->input->post('first_label_menu_id');
            $posted['access_type'] = $this->input->post('access_type');
            
            // Delete all the previous data and add al the new record
            if(!empty($posted['h_action_permit']) && intval($user_id) > 0)
            {
                // Delete all
                $this->acs_model->delete_data($this->tbl_user_menu, array('i_user_id' => $user_id));
                
                // Generate new menu
                $new_menu = array();
                foreach($posted['h_action_permit'] as $menu_id)
                {
                    // Fetch all the menu
                    $action_list = $menu_list = '';
                    if(!empty($posted['opt_actions'][$menu_id][0]))
                    {
                        $action_list = implode("','", $posted['opt_actions'][$menu_id]);
                        
                        // Fetch 
                        if(trim($action_list) !== '')
                        {
                            $action_list = "'".$action_list."'";
                            $menu_list = $this->menu_model->get_all_menu_set($menu_id, $action_list); 
                        }
                    }
                    
                    // Generate menu array
                    $new_menu[] = array(
                        'i_menu_id' => $menu_id,
                        'i_parent_id' => $posted['first_label_menu_id'][$menu_id][0],
                        'i_user_id' => $user_id,
                        'i_role_id' => $role_id,
                        's_set_of_action' => $action_list,
                        's_set_of_menu' => $menu_list,
                    );   
                    unset($action_list, $menu_list);
                } // End of action_permit foreach
                
                // Insert in to the database
                if(!empty($new_menu))
                {
                    // Change the user role type 
                    // [Note: Bit confusing about this, may cause some error somehow, need a careful testing]
                    if($this->acs_model->add_multiple_data($this->tbl_user_menu, $new_menu)) // DB insert
                        $this->acs_model->edit_data($this->tbl_role, array('e_access_type' => 'customize'), array('i_user_id' => $user_id, 'i_role_id' => $role_id)); // Update user access type
                    set_success_msg($this->cls_msg["save_succ"]);
                    redirect($this->pathtoclass."customize_user_access/".encrypt($user_id)."/".encrypt($role_id));
                }
                unset($new_menu, $posted);
            } // End of if
        }
        else
        {
            $this->data['heading'] = "Customize User Access Control";
            $this->data['pathtoclass'] = $this->pathtoclass;
            $this->data['mode'] = "edit";
            
            // Fetch all the access permission 
            $this->data['action_list'] = $this->menu_model->fetch_all_the_action_permission();
            
            if($this->data['user_role_info'][0]['e_access_type'] == 'default') // Load default access data
            {
                $this->data['menu_action'] = $this->menu_model->fetch_access_control($this->data['user_role_info'][0]['i_role_id']);
            }
            else // Load customize access data
            {
                $this->data['menu_action'] = $this->menu_model->fetch_customize_access_control($user_id, $this->data['user_role_info'][0]['i_role_id']);
            }
            $this->render();
        }
    } 
    
    public function nap_restore_to_default($user_id, $role_id)
    {
        $user_id  = intval(decrypt($user_id));
        $role_id  = intval(decrypt($role_id));
        if($user_id === 0)
            throw new Exception('Seem some error');
        // Change user main tabel setting
        if($this->acs_model->edit_data($this->tbl_role, array('e_access_type' =>'default'), array('i_user_id' => $user_id, 'i_role_id' => $role_id)))
        {
            // Delete all of this user's custome menu
            $this->acs_model->delete_data($this->tbl_user_menu, array('i_user_id' => $user_id, 'i_role_id' => $role_id));
            set_success_msg(get_message('save_success'));
            redirect($this->pathtoclass.'customize_user_access/'.encrypt($user_id).'/'.encrypt($role_id));
        }
    }
	
    public function ajax_remove_information()
    {
        try
        {
			$i_id = decrypt($this->input->post("temp_id"));
			$i_rect	= $this->mod_rect->delete_info($i_id); /*don't change*/  
			              
			if($i_rect)////saved successfully
			{
				set_success_msg($this->cls_msg['delete_succ']);
				echo "ok";                
			}
			else///Not saved, show the form again
			{
				set_error_msg($this->cls_msg['delete_err']);
				echo "error" ;
			}
			unset($info,$i_rect);
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
			$posted["id"] = trim($this->input->post("h_id"));
			$posted["i_status"] = trim($this->input->post("i_status"));
			$info = array();
			$info['i_status'] = $posted["i_status"]  ;
			$i_rect = $this->mod_rect->change_status($info,$posted["id"]); /*don't change*/				
			echo $i_rect? 'ok' : 'error';
			unset($info,$i_rect);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }   
    
     
    public function ajax_change_display_status()
    {
        try
        {
            $posted["id"] = trim($this->input->post("h_id"));
            $posted["i_status"] = trim($this->input->post("i_status"));
            $info = array();
            $info['i_front_display'] = $posted["i_status"]  ;
            $i_rect = $this->mod_rect->change_display_status($info,$posted["id"]); /*don't change*/                
            echo $i_rect? 'ok' : 'error';
            unset($info,$i_rect);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }   
    
    // ajax get franchise
    public function ajax_get_franchise()
    {
        $ret = array('data' => '', 'status' => '');
        $region_id = intval($this->input->post('region_id'));
        if($region_id > 0)
        {
            $ret['data'] = make_option_franchise($region_id);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }
    
    // Fetch all the user roles 
    public function ajax_get_user_role($user_id, $return = false)
    {
        $user_id = intval(decrypt($user_id));
        if($user_id > 0)
        {
            // Select user role
            $tbl[0] = array(
                'tbl' => $this->db->USERROLE.' AS ur',
                'on' =>''
            );
            $tbl[1] = array(
                'tbl' => $this->db->USER_TYPE.' AS ut',
                'on' => 'ut.id = ur.i_role_id'
            );
            
            $conf = array(
                'select' => 'ur.*, ut.s_user_type',
                'where' => 'ur.i_user_id = '.$user_id,
                'order_by' => 'ur.i_id'
            );
            $data['role_info'] = $this->acs_model->fetch_data_join($tbl, $conf);
            /*if(count($data['role_info']) >= 1 )
                echo $html = $this->load->view("web_master/manage_admin_user/select_role.tpl.php", $data, true);*/
            if($return)
                return $data['role_info'];
            else
                echo $html = $this->load->view("web_master/manage_admin_user/select_role.tpl.php", $data, true);
        }
    }
    
    public function ajax_add_new_county()
    {
        $res = array('html' =>'', 'status' => 'error');
        $country_id = intval($this->input->post('country_id'));
        $state_id = intval($this->input->post('state_id'));
        $county = trim($this->input->post('county', true));
        if($county != '')
        {
            // Check duplicate
            $where = array('name' => "'".$county."'", 'i_state_id' => $state_id, 'i_country_id' => $country_id);
            $tmp = $this->acs_model->fetch_data($this->db->CITY, $where, 'i_id');
            if(intval($tmp[0]['i_id']) == 0) // Does not exist
            {
                $where['name'] = $where['Code'] = $county;
                //$where['i_status'] = 'Active';
                //$where['i_is_deleted'] = 'No';
                $i_newid = $this->acs_model->add_data($this->db->CITY, $where); // Save
                if($i_newid) // Fetch the new list
                {
                    $res['html'] = '<option value="">Select County</option>'.$this->acs_model->get_city_selectlist($state_id, $i_newid);
                    $res['status'] = 'success';
                }
            }
            else // Exist, ignore it
                $res['status'] = 'exist';
        }
        echo json_encode($res);
    }
    
    public function ajax_get_keyword($t)
    {
        $res = array();
        $term = $this->input->get('term', true);
        if(trim($term) != '')
        {
            $tmp = $this->acs_model->fetch_data($this->db->KEYWORD, "s_keyword LIKE '%{$term}%'", 'GROUP_CONCAT(s_keyword) AS `key`', 0, 10); 
            if($tmp[0]['key'] != '')
                $res = explode(',', $tmp[0]['key']);
            unset($tmp);
        }
        echo json_encode($res);
    }
    
    public function ajax_change_order()
    {
        try
        {
            $id_arr = $_POST['tableSort'];
            unset($id_arr[0]);
            $this->acs_model->change_sorting_order($id_arr,$this->tbl);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }    
    }
    
    public function nap_basic_rs()
    {
        // Call RS
        $param = array(
            'consumer_key' => $this->config->item('rs_consumer_key'),
            'consumer_secret' => $this->config->item('rs_consumer_secret'),
            'oauth_callback' => $this->config->item('rs_oauth_callback'),
        ); // It must be retrive from user database (I hope)
        
        $this->load->library('right_signature', $param); // Call library
        
        
        // Tries to retrieve access token and verifier from DB
        $tmp = $this->acs_model->fetch_data($this->tbl, array('i_id' => decrypt($this->admin_loggedin['user_id'])), 'rs_oauth_token, rs_oauth_verifier');
        
        $this->right_signature->access_token = $tmp[0]['rs_oauth_token'];
        $this->right_signature->oauth_verifier = $tmp[0]['rs_oauth_verifier'];
        
        // Now we retrieve a request token. It will be set as $rightsignature->request_token
        $this->right_signature->getRequestToken();
    }
    
    public function nap_basic_rs_access_token()
    {
        // Call RS
        $param = array(
            'consumer_key' => $this->config->item('rs_consumer_key'),
            'consumer_secret' => $this->config->item('rs_consumer_secret'),
            'oauth_callback' => $this->config->item('rs_oauth_callback'),
        ); // It must be retrive from user database (I hope)
        
        $this->load->library('right_signature', $param); // Call library
        
        // Tries to retrieve access token and verifier from DB
        $tmp = $this->acs_model->fetch_data($this->tbl, array('i_id' => decrypt($this->admin_loggedin['user_id'])), 'rs_oauth_access_key, rs_oauth_access_secret');
        
        $oauth_at = $tmp[0]['rs_oauth_access_key'];
        $oauth_as = $tmp[0]['rs_oauth_access_secret'];
        
        // If access token key and secret was found, load it
        if (!empty($oauth_at) && !empty($oauth_as)) {
            $this->right_signature->access_token = new OAuthConsumer($oauth_at, $oauth_as, 1);
        }
    }
    
    public function nap_manage_rs_oauth()
    {
        // Call RS
        $param = array(
            'consumer_key' => $this->config->item('rs_consumer_key'),
            'consumer_secret' => $this->config->item('rs_consumer_secret'),
            'oauth_callback' => $this->config->item('rs_oauth_callback'),
        ); // It must be retrive from user database (I hope)
        
        $this->load->library('right_signature', $param); // Call library
        
        parse_str($_SERVER['QUERY_STRING'], $response_params);
        
        $oauth_request_token = $response_params["oauth_token"];
        $oauth_verifier = $response_params["oauth_verifier"];
        if($oauth_request_token && $oauth_verifier)
        {
            $tmp = $this->acs_model->fetch_data($this->tbl, array('i_id' => decrypt($this->admin_loggedin['user_id'])), 'rs_oauth_request_key, rs_oauth_request_secret');  
            $request_key = $tmp[0]['rs_oauth_request_key'];
            $request_secret = $tmp[0]['rs_oauth_request_secret'];
            if(!empty($request_key) && $request_key == $oauth_request_token) 
            {
                // Use request token from settings
                $this->right_signature->request_token = new OAuthConsumer($request_key, $request_secret, 1);
                $this->right_signature->oauth_verifier = $oauth_verifier;
                $this->right_signature->getAccessToken();

                // Saves access token key and secret
                $info = array(
                    'rs_oauth_access_key' => $this->right_signature->access_token->key,
                    'rs_oauth_access_secret' => $this->right_signature->access_token->secret,
                    'rs_oauth_verifier' => $oauth_verifier
                );
                $this->acs_model->edit_data($this->tbl, $info, array('i_id' => decrypt($this->admin_loggedin['user_id'])));
                
            }
        }
    }
    
    public function nap_generate_api_tokens()
    {
        // Call RS
        $param = array(
            'consumer_key' => $this->config->item('rs_consumer_key'),
            'consumer_secret' => $this->config->item('rs_consumer_secret'),
            'oauth_callback' => $this->config->item('rs_oauth_callback'),
        ); // It must be retrive from user database (I hope)
        
        $this->load->library('right_signature', $param); // Call library
        
        
        // Tries to retrieve access token and verifier from DB
        $tmp = $this->acs_model->fetch_data($this->tbl, array('i_id' => decrypt($this->admin_loggedin['user_id'])), 'rs_oauth_token, rs_oauth_verifier');
        
        $this->right_signature->access_token = $tmp[0]['rs_oauth_token'];
        $this->right_signature->oauth_verifier = $tmp[0]['rs_oauth_verifier'];
        
        // Now we retrieve a request token. It will be set as $rightsignature->request_token
        $this->right_signature->getRequestToken();
        
        $this->nap_basic_rs();
       
        $this->acs_model->edit_data($this->tbl, array('rs_oauth_request_key' => $this->right_signature->request_token->key, 'rs_oauth_request_secret' => $this->right_signature->request_token->secret), array('i_id' => decrypt($this->admin_loggedin['user_id'])));
        
        $url = $this->right_signature->generateAuthorizeUrl();
        redirect($url);
    }
    
    public function nap_send_document()
    {
        // Call RS
        $this->nap_basic_rs_access_token();
        
        // Create a document here dynamically and replace its path by this below path
        $document_path = 'http://codeuridea.net/murphy/uploaded/doc_master/sdlc_quick_guide.pdf'; // Document path
        $signer_email = 'ban2demo@gmail.com';
        $signer_name = 'Bunty Roy';
        $sender_email = 'mmondal@codeuridea.com';
        $sender_name = 'Mrinmoy Mondal';
        $subject = 'Murphy NDA'; // Subject
        $action = 'send'; // redirect|send
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                   <document>
                     <subject>'.$subject.'</subject>
                     <document_data>
                       <type>url</type>
                       <value>'.$document_path.'</value>
                     </document_data>
                     <recipients>
                       <recipient>
                        <name>'.$sender_name.'</name>
                        <email>'.$sender_email.'</email>
                        <role>cc</role>
                      </recipient>
                      <recipient>
                        <name>'.$signer_name.'</name>
                        <email>'.$signer_email.'</email>
                        <role>signer</role>
                        <locked>true</locked>
                      </recipient>
                      <recipient>
                        <is_sender>true</is_sender>
                        <role>signer</role>
                      </recipient>
                    </recipients>
                    <tags>
                      <tag>
                        <name>sent_from_api</name>
                      </tag>
                      <tag>
                        <name>mutual_nda</name>
                      </tag>
                      <tag>
                        <name>user_id</name>
                        <value>1</value>
                      </tag>
                    </tags>
                    <expires_in>30 days</expires_in>
                   <action>'.$action.'</action>
                    <callback_location>http://codeuridea.com/murphy/callcack/</callback_location>
                    <use_text_tags>false</use_text_tags>
                  </document>';
        
        echo $guid = $this->right_signature->mpSendDocument($xml);
        
        // Now save the document details
    }
    
	public function __destruct()
    {}

}
