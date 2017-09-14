<?php 

/***

File Name: cms_advertisement.php 
Created By: SWI Dev 
Created On: October 09, 2015 
Purpose: CURD for Cms Advertisement 

*/

class Cms_advertisement extends MY_Controller 
{
	public $patchtoclass, $cls_msg, $tbl;
	protected $tbl_ref_cms;
	public function __construct(){
		parent::__construct();
		$this->data["title"]= 'Page Advertisement';//Browser Title 
		$this->pathtoclass  = admin_base_url().$this->router->fetch_class()."/";
		$this->tbl          = $this->db->CMS_CALLTOACTION;// Default Table
		$this->tbl_ref_cms  = $this->db->CMS;
        
        
            
        $this->data['BREADCRUMB'] = 'Page Advertisement';
        $this->allowedImgExt    = 'jpg|png|jpeg';
        $this->uploadImgdir     = $this->config->item('cta_image_upload_path'); 
        $this->thumbImgdir      = $this->config->item('cta_image_thumb_upload_path'); 
        $this->showImgDir       = $this->config->item('cta_image_display_path');
        $this->thumbImgHt       = $this->config->item('cta_image_thumb_height');  
        $this->thumbImgWd       = $this->config->item('cta_image_thumb_width');             
        $this->user_img_width   = 201;   
        $this->user_img_height  = 279;
	}

	//Default method (index)
	public function index()
	{
		redirect($this->pathtoclass.'show_list');
	}

    /****
    * Display the list of records 
    */
    public function show_list($order_by = '', $sort_type = 'desc',$start = NULL, $limit = NULL)
    {
        try
        {
            $this->data['heading'] = 'Page Advertisement'; //Package Name[@package] Panel Heading
            
            //generating search query//
            $arr_session_data = $this->session->userdata("arr_session");
            if($arr_session_data['searching_name'] != $this->data['heading'])
            {
                $this->session->unset_userdata("arr_session");
                $arr_session_data = array();
            }
            
            $search_variable = array();
            //Getting Posted or session values for search//        
            $s_search = (isset($_GET["h_search"])?$this->input->get("h_search"):$this->session->userdata("h_search"));
            //end Getting Posted or session values for search// 
            $search_variable["dt_from"]= ($this->input->get("h_search")?$this->input->get("dt_from"):$arr_session_data["dt_from"]);
            $search_variable["dt_to"]= ($this->input->get("h_search")?$this->input->get("dt_to"):$arr_session_data["dt_to"]);       
            
            $s_where = " n.i_id != 0 AND n.e_status!='Deleted' ";
            //$s_where = " n.i_id != 0 ";
            if($s_search == "advanced")
            {
                $arr_session = array();
                $arr_session["searching_name"] = $this->data['heading'];                
                
                if($search_variable["dt_from"] != '' && $search_variable["dt_to"] !='')
                {
                    $s_where .= ' AND (DATE_FORMAT(n.dt_created, "%Y-%m-%d") >="'.make_db_date($search_variable["dt_from"]).'" AND DATE_FORMAT(n.dt_created, "%Y-%m-%d") <= "'.make_db_date($search_variable["dt_to"]).'") ';
                }
                else if($search_variable["dt_from"] != '')
                    $s_where .= ' AND DATE_FORMAT(n.dt_created, "%Y-%m-%d") >="'.make_db_date($search_variable["dt_from"]).'" ';
                else if($search_variable["dt_to"] != '')
                    $s_where .= ' AND DATE_FORMAT(n.dt_created, "%Y-%m-%d") <= "'.make_db_date($search_variable["dt_to"]).'" ';
                                
                $arr_session    =   array();                
                $arr_session["searching_name"] = $this->data['heading'] ;
                $arr_session["dt_from"] = $search_variable["dt_from"] ;
                $arr_session["dt_to"] = $search_variable["dt_to"] ;
                $this->session->set_userdata("arr_session",$arr_session);
                $this->session->set_userdata("h_search",$s_search);
                $this->data["h_search"] = $s_search;
                $this->data["dt_from"]     = $search_variable["dt_from"];                
                $this->data["dt_to"]     = $search_variable["dt_to"];                
                
                $this->session->set_userdata("arr_session",$arr_session);
                $this->session->set_userdata("h_search",$s_search);
                $this->data["h_search"] = $s_search;                            
            }
            else //List all records, **not done
            {
                //Releasing search values from session//
                $this->session->unset_userdata("arr_session");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"] = $s_search;
                $this->data["Array"] = '';                       
                $this->data["dt_from"]     = "";                            
                $this->data["dt_to"]     = "";                            
                //end Storing search values into session//                 
            }
            
            unset($s_search,$arr_session,$search_variable);
              
            //Setting Limits, If searched then start from 0//
            $i_uri_seg = 6;
            $start = $this->input->get("h_search") ? 0 : $this->uri->segment($i_uri_seg);
            //end generating search query//
            // List of fields for sorting
            $arr_sort = array();   
            $order_by=!empty($order_by)?in_array(decrypt($order_by),$arr_sort)?decrypt($order_by):$arr_sort[0]:$arr_sort[0];
            
            $limit = $this->i_admin_page_limit;
			

            $tbl[0] = array(
                'tbl' => $this->tbl.' AS n',
                'on' =>''
            );

            $tbl[1] = array(
                'tbl' => $this->tbl_ref_cms.' AS cms',
                'on' => 'n.i_cms_id = cms.i_id'
            );
            $conf = array(
                'select' => 'n.i_id, n.i_cms_id, n.s_image, n.s_url, n.dt_created, n.e_status, cms.s_title',
                'where' => $s_where,
                'limit' => $limit,
                'offset' => $start,
                'order_by' => $order_by,
                'order_type' => $sort_type
            );
            $info = $this->acs_model->fetch_data_join($tbl, $conf);
            
            $conf2 = array(
                'select' => 'count(n.i_id) AS total',
                'where' => $s_where
            );
            $tmp =  $this->acs_model->fetch_data_join($tbl, $conf2);
            //echo $this->db->last_query();
            $total = $tmp[0]['total'];
            unset($tmp);

                  
            //Creating List view for displaying//
            $table_view = array();  
            
            //Table Headers, with width,alignment//
            $table_view["caption"]                 = 'Page Advertisement';
            $table_view["total_rows"]              = count($info);
            $table_view["total_db_records"]        = $total;
            $table_view["detail_view"]             = false;  // to disable show details. 
            $table_view["order_name"]              = encrypt($order_by);
            $table_view["order_by"]                = $sort_type;
            $table_view["src_action"]              = $this->pathtoclass.$this->router->fetch_method();
            
            $j = -1;
            
			$table_view["headers"][++$j]["width"] = "20%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("Page"));
			/*$table_view["headers"][++$j]["width"] = "20%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("Image"));*/
			$table_view["headers"][++$j]["width"] = "35%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("URL"));
			$table_view["headers"][++$j]["width"] = "20%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("Created On"));
			$table_view["headers"][++$j]["width"] = "15%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("Status"));
            //end Table Headers, with width,alignment//
            
            //Table Data//
            for($i = 0; $i< $table_view["total_rows"]; $i++)
            {
                $i_col = 0;
                // status button
                $stat_btn=  '';
                if($info[$i]["e_status"] == 'Active')  
                    $stat_btn ='<span style="margin-top:5px; display:inline-block;" class="label label-success" id="status_row_id_'.$info[$i]["i_id"].'">Active</span>';
                else
                    $stat_btn ='<span style="margin-top:5px; display:inline-block;"  class="label label-warning" id="status_row_id_'.$info[$i]["i_id"].'">Inactive</span>';
                    
                $table_view["tablerows"][$i][$i_col++] = encrypt($info[$i]["i_id"]);                
                
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_title"];
				#$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_image"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_url"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["dt_created"];
				//$table_view["tablerows"][$i][$i_col++] = $info[$i]["e_status"];
                ///$info[$i]["s_status"] = $info[$i]["i_status"]==1?"Active":"Inactive";
                if($info[$i]["e_status"] == 'Active')
                {
                    $table_view["tablerows"][$i][$i_col++] = $stat_btn;                    
                    $action .='<a data-toggle="tooltip" data-placement="bottom" title="Make Inactive" class="glyphicon glyphicon-ok" id="stat_chnage_id_'.$info[$i]["i_id"].'_inactive" href="javascript:void(0);" rel="make_inactive"></a>';
                }
                else
                {
                    $table_view["tablerows"][$i][$i_col++] = $stat_btn;                    
                    $action .='<a data-toggle="tooltip" data-placement="bottom" title="Make Active" class="glyphicon glyphicon-ban-circle" id="stat_chnage_id_'.$info[$i]["i_id"].'_active" href="javascript:void(0);" rel="make_active"></a>';
                }                               
                $table_view["rows_action"][$i] = $action;
            } 
            //end Table Data//
            unset($i, $i_col, $start, $limit, $s_where); 
            
            //$this->data["table_view"] = $this->admin_showin_table($table_view,TRUE);
            $this->data['total_record'] = $table_view["total_db_records"];
            $this->data["table_view"] = $this->admin_showin_order_table($table_view,TRUE);
            
            //Creating List view for displaying//
            $this->data["search_action"] = $this->pathtoclass.$this->router->fetch_method();//used for search form action
            
            $this->render();          
            unset($table_view, $info);
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
        $this->data['heading'] = (t("Add Information"));
        $this->data['pathtoclass'] = $this->pathtoclass;
        $this->data['BREADCRUMB'] = array(addslashes(t('Add Information')));
        $this->data['mode'] = 'add';
        
        
        if($_POST)
        {
            $posted = array();
            
			$posted["i_cms_id"]         = $this->input->post("i_cms_id", true);

            /*if(isset($_FILES['s_image']) && !empty($_FILES['s_image']['name']))
            {
                $s_uploaded= get_file_uploaded($this->uploadImgdir,'s_image','','',$this->allowedImgExt);
                $arr_upload = explode('|',$s_uploaded);    
            }
            
            if($arr_upload[0] == 'ok')
            {
                get_image_thumb($this->uploadImgdir.$arr_upload[2], $this->thumbImgdir, $arr_upload[2], $this->thumbImgHt, $this->thumbImgWd);
                $posted["s_image"] = $arr_upload[2];                    
            }*/
            
			$posted["s_url"]            = $this->input->post("s_url", true);
			$posted["dt_created"]       = now();
			$posted["e_status"]         = $this->input->post("e_status", true); 
            
            $err_msg = '';
            //below code for check image width and height
            if(isset($_FILES['s_image']) && !empty($_FILES['s_image']['name']))
            {
                list($width, $height, $type, $attr) = getimagesize($_FILES["s_image"]["tmp_name"]);
                if($width>0 && $width<$this->user_img_width)
                    $err_msg .= "Minimum image width should be {$this->user_img_width}px ".'</br>';
                if($height>0 && $height<$this->user_img_height)
                    $err_msg .= "Minimum image height should be {$this->user_img_height}px ".'</br>';
            }
            if($err_msg=='')
            {
                if(isset($_FILES['s_image']) && !empty($_FILES['s_image']['name']))
                {
                    $s_filename= get_file_uploaded($this->uploadImgdir,'s_image','','',$this->allowedImgExt);
                    $arr_upload = explode('|',$s_filename);
                }
                if($arr_upload[0] == 'ok')
                {
                    get_image_thumb($this->uploadImgdir.$arr_upload[2], $this->thumbImgdir, $arr_upload[2], $this->thumbImgHt, $this->thumbImgWd);
                    $posted["s_image"] = $arr_upload[2];
                }
            }
                
            
			$this->form_validation->set_rules('i_cms_id', 'select page', 'required|xss_clean');
            
            if($this->form_validation->run() == FALSE || $err_msg!='' || $arr_upload[0]==='err')//invalid
            {
                if($arr_upload[0]==='err')
                    set_error_msg($arr_upload[2]);
                else
                    get_file_deleted($this->uploadImgdir,$arr_upload[2]);
                                       
                if($err_msg!='')
                    set_error_msg($err_msg);
                
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {
                
                $i_newid = $this->acs_model->add_data($this->tbl, $posted);
                if($i_newid)//saved successfully
                {
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
        
        $this->render("cms_advertisement/add-edit");
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
        $this->data['heading'] = (t("Edit Information"));
        $this->data['pathtoclass'] = $this->pathtoclass;
        $this->data['BREADCRUMB'] = array(addslashes(t('Edit Information')));
        $this->data['mode'] = 'edit';
        
        
        if($_POST)
        {
            $posted = array();
        
            $posted["i_cms_id"] = $this->input->post("i_cms_id", true);
			$h_image = $this->input->post("h_image");

            /*if(isset($_FILES['s_image']) && !empty($_FILES['s_image']['name']))
            {
                $s_uploaded= get_file_uploaded($this->uploadImgdir,'s_image','','',$this->allowedImgExt);
                $arr_upload = explode('|',$s_uploaded);    
            }
            
            if($arr_upload[0] == 'ok')
            {
                get_image_thumb($this->uploadImgdir.$arr_upload[2], $this->thumbImgdir, $arr_upload[2], $this->thumbImgHt, $this->thumbImgWd);
                get_file_deleted($this->uploadImgdir,$h_image);
                get_file_deleted($this->thumbImgdir,$h_image);
                $posted["s_image"] = $arr_upload[2];                    
            }
            else*/
            $posted["s_image"] = $h_image;
            
			$posted["s_url"]    = $this->input->post("s_url", true);
			$posted["e_status"] = $this->input->post("e_status", true);
            $posted["h_id"]     = $this->input->post("h_id", true);
			$this->form_validation->set_rules('i_cms_id', 'select page', 'required');
            
            $err_msg = '';
            //below code for check image width and height
            if(isset($_FILES['s_image']) && !empty($_FILES['s_image']['name']))
            {
                list($width, $height, $type, $attr) = getimagesize($_FILES["s_image"]["tmp_name"]);
                if($width>0 && $width<$this->user_img_width)
                    $err_msg .= "Minimum image width should be {$this->user_img_width}px ".'</br>';
                if($height>0 && $height<$this->user_img_height)
                    $err_msg .= "Minimum image height should be {$this->user_img_height}px ".'</br>';
            }
            if($err_msg=='')
            {
                if(isset($_FILES['s_image']) && !empty($_FILES['s_image']['name']))
                {
                    $s_filename= get_file_uploaded($this->uploadImgdir,'s_image','','',$this->allowedImgExt);
                    $arr_upload = explode('|',$s_filename);
                }
                if($arr_upload[0] == 'ok')
                {
                    get_image_thumb($this->uploadImgdir.$arr_upload[2], $this->thumbImgdir, $arr_upload[2], $this->thumbImgHt, $this->thumbImgWd);
                    get_file_deleted($this->uploadImgdir,$h_image);
                    get_file_deleted($this->thumbImgdir,$h_image);
                    $posted["s_image"] = $arr_upload[2];
                }
            }
            
            if($this->form_validation->run() == FALSE || $err_msg!='' || $arr_upload[0]==='err')//invalid
            {
                if($arr_upload[0]==='err')
                    set_error_msg($arr_upload[2]);
                else
                    get_file_deleted($this->uploaddir,$arr_upload[2]);
                                       
                if($err_msg!='')
                    set_error_msg($err_msg);
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {
                
                $i_id = decrypt($posted["h_id"]);
                unset($posted["h_id"]);
                $i_aff = $this->acs_model->edit_data($this->tbl,$posted, array('i_id'=>$i_id));
                if($i_aff)//saved successfully
                {  
                    set_success_msg($this->cls_msg["save_succ"]);
                    redirect($this->pathtoclass."show_list");
                }
                else//Not saved, show the form again
                {
                    set_error_msg($this->cls_msg["save_err"]);
                }
			}
        }//end Submitted Form//
        else
        {
            // Fetch all the data
            $tmp = $this->acs_model->fetch_data($this->tbl,array('i_id'=>decrypt($i_id)));
            $posted = $tmp[0];
            $posted['h_id'] = $i_id;
            $this->data['posted'] = $posted;
            $posted['h_mode'] = $this->data['mode'];
        }
        
        $this->render("cms_advertisement/add-edit");
    }

    /***
    * Shows details of a single record.
    * 
    * @param int $i_id, Primary key
    */
    public function view_detail($i_id = 0)
    {
        try
        {
            if(!empty($i_id))
            {
                $this->data["info"] = $this->acs_model->fetch_data($this->tbl,array('i_id'=>$i_id));
            }
            $this->load->view('web_master/cms_advertisement/show_detail.tpl.php', $this->data); 
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
    public function ajax_remove_information()
    {
        try
        {
            $i_id = decrypt($this->input->post("temp_id"));
            $tmp = $this->acs_model->fetch_data($this->tbl,array('i_id'=>$i_id));
            $posted = $tmp[0];
            if($posted['s_image'])
            {                
                get_file_deleted($this->uploadImgdir,$posted['s_image']);
                get_file_deleted($this->thumbImgdir,$posted['s_image']);
            }
            
            echo $this->acs_model->delete_data($this->tbl, array('i_id'=>$i_id)) ? 'ok' : 'error';
            unset($i_id);
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
            $info['e_status'] = $posted["i_status"]  ;
            //$i_rect = $this->mod_rect->change_status($info,$posted["id"]); /*don't change*/    
            $i_rect = $this->acs_model->edit_data($this->tbl,$info, array('i_id'=>$posted["id"]));  
            //$i_rect = 'ok'          ;
            echo $i_rect? 'ok' : 'error';
            unset($info,$i_rect);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }


    // Generate a method for drop down
    protected function generate_drodown($table, $field, $s_id = '', $return_type = 'html')
    {
        $tmp = $this->acs_model->fetch_data($table, '',"i_id, $field");
        if(!empty($tmp))
        {
            if($return_type == 'array')
                $value[0] = 'Select';
            else
                $value = '<option value="">Select</option>';
            foreach($tmp as $v)
            {
                if($return_type == 'array')
                    $value[$v['i_id']] = $v[$field];
                else
                {
                    $selected = $s_id == $v['i_id'] ? 'selected' : '';
                    $value .= '<option value="'.$v['i_id'].'" '.$selected.'>'.$v[$field].'</option>';
                }
            }
        }
        unset($tmp, $table, $field, $s_id, $return_type);
        return $value;
    }

	public function __destruct(){}
}