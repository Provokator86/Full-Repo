<?php
/*********
* Author: SW 
* Date  : 
* Purpose:
* Controller For Manging Menus With Cms Pages With  Drag Drop Sortable Custom Links
*/


class Menu_list extends MY_Controller
{
    public $cls_msg;//All defined error messages. 
    public $pathtoclass, $tbl;   
    public function __construct()
    {            
        try
        {
			parent::__construct();
			$this->data['title']= addslashes(custom_lang_display("Manage Menu"));//Browser Title
			
			//Define Errors Here//
			$this->cls_msg = array();
			$this->cls_msg["no_result"]		= get_message('no_result');
			$this->cls_msg["save_err"]		= get_message('save_failed');
			$this->cls_msg["save_succ"]		= get_message('save_success');
			$this->cls_msg["delete_err"]	= get_message('del_failed');
			$this->cls_msg["delete_succ"]	= get_message('del_success');
			//end Define Errors Here//
			
			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";                                                                                			
			$this->load->model('cs_model');
			$this->tbl = $this->db->MENU_LIST;
            $this->tbl_cms = $this->db->CMS;  
            $this->tbl_menu_page = $this->db->MENU_PAGE;  			
			
			$this->data['BREADCRUMB'] = array( addslashes(custom_lang_display('Manage Menu')));

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
			$this->data['heading'] =  addslashes(custom_lang_display("Menu List"));
			
			//generating search query//
			$arr_session_data    =    $this->session->userdata("arr_session");
			if($arr_session_data['searching_name'] != $this->data['heading'])
			{
				$this->session->unset_userdata("arr_session");
				$arr_session_data   =   array();
			}
			$search_variable = array();
			
			//Getting Posted or session values for search//        
			$s_search 	=(isset($_GET["h_search"])?$this->input->get("h_search"):$this->session->userdata("h_search"));
			$search_variable["s_name"] = ($this->input->get("h_search")?$this->input->get("s_name"):$arr_session_data["s_name"]);
           
            
			//end Getting Posted or session values for search//            
			$s_where = " WHERE n.i_status=1 ";
			
			if($s_search=="advanced")
			{
				
				if($search_variable["s_name"]!="")
				{
					//$s_where .= " AND CONCAT(n.s_first_name,' ',n.s_last_name) LIKE '%".addslashes($search_variable["s_customer_name"])."%' ";
					$s_where .= " AND n.s_name LIKE '%".addslashes($search_variable["s_name"])."%' ";
				}
				
				$arr_session    =   array();                
				$arr_session["searching_name"] = $this->data['heading'] ;        
				$arr_session["s_name"] = $search_variable["s_name"] ;
				$this->session->set_userdata("arr_session",$arr_session);
				$this->session->set_userdata("h_search",$s_search);
				$this->data["h_search"] = $s_search;
				$this->data["s_name"] 	= $search_variable["s_name"]; 
               
			}
			else//List all records, **not done
			{
				$s_where = " WHERE n.i_status=1 ";
				//Releasing search values from session//
				$this->session->unset_userdata("arr_session");
				$this->session->unset_userdata("h_search");
				
				$this->data["h_search"]			= $s_search;
				$this->data["s_name"] 	= "";   
                
				//end Storing search values into session//                 
			}
			unset($s_search,$arr_session,$search_variable);
			//Setting Limits, If searched then start from 0//
			if($this->input->get("h_search"))
			{
				$start = 0;
			}
			else
			{
				$start = $this->uri->segment($this->i_uri_seg);
			}
			//end generating search query//
			
			//$this->i_admin_page_limit = 1;
			$limit	= $this->i_admin_page_limit; 			
            $info   = $this->cs_model->fetch_multi($this->tbl,$s_where, intval($start),$limit);
			
			//Creating List view for displaying//
			$table_view=array();  
			
			$table_view["add_text"] 	       	= custom_lang_display("Add Menu");
			$table_view["list_text"] 	       	= custom_lang_display("Menu");
			
			//Table Headers, with width,alignment//
			$table_view["caption"]				=  addslashes(custom_lang_display("Manage Menu"));
			$table_view["total_rows"]		  	= count($info);
			$table_view["total_db_records"]		= $this->cs_model->gettotal_info($this->tbl,$s_where);
			$table_view["detail_view"]         	= false;  //   to disable show details. 
			$j = 0;
            
			$table_view["headers"][$j]["width"]		="25%";
			$table_view["headers"][$j]["align"]		="left";
			$table_view["headers"][$j]["val"]		=  addslashes(custom_lang_display("Name"));
            
            $table_view["headers"][++$j]["width"]     ="25%";
            $table_view["headers"][$j]["align"]     ="left";
            $table_view["headers"][$j]["val"]       =  addslashes(custom_lang_display("Details"));                
			
			$table_view["headers"][++$j]["val"]		=  addslashes(custom_lang_display("Status"));
			$table_view["headers"][$j]["width"]		= "25%";
			$table_view["headers"][$j]["align"]		= "left";
			
			//end Table Headers, with width,alignment//
			
			//Table Data//
			for($i=0; $i<$table_view["total_rows"]; $i++)
			{
				$i_col=0;
				$table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);
				
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_name"];
                
                $table_view["tablerows"][$i][$i_col++]  = $info[$i]["s_details"];
				
				
				if($info[$i]["i_status"] == 1)				
				{
					$table_view["tablerows"][$i][$i_col++] = '<span class="label label-success" id="status_row_id_'.$info[$i]["i_id"].'">Active</span>';
				}
				else
				{
					$table_view["tablerows"][$i][$i_col++] = '<span class="label" id="status_row_id_'.$info[$i]["i_id"].'">Inactive</span>';
				}
				
				//$action ='';
                
                $action='<a data-rel="tooltip" data-original-title="Manage Pages" class="btn btn-mini btn-primary" href="javascript:void(0);" id="btn_view_menu_page_'.encrypt($info[$i]["i_id"]).'" value="'.encrypt($info[$i]["i_id"]).'" ><i class="glyphicon-zoom-in glyphicon"></i></a>&nbsp;';
				
				/*if($info[$i]["i_status"] == 1)
				{
					$action .='<a class="btn btn-mini btn-warning" id="approve_img_id_'.$info[$i]["i_id"].'_inactive" href="javascript:void(0);" rel="make_inactive"><i class="icon-refresh icon-white"></i>'. addslashes(custom_lang_display("Make Inactive")).'</a>&nbsp;';
				}
				else
				{                       
					 $action .='<a class="btn btn-mini btn-success" id="approve_img_id_'.$info[$i]["i_id"].'_active" href="javascript:void(0);" rel="make_active"><i class="icon-refresh icon-white"></i>'. addslashes(custom_lang_display("Make Active")).'</a>&nbsp;';
				}*/
								
				if($action!='')
				{
					$table_view["rows_action"][$i] = $action;     
				}
				
				
			} 
			//end Table Data//
			unset($i,$i_col,$start,$limit); 
			
			$this->data["table_view"] = $this->admin_showin_table($table_view,TRUE);
			//Creating List view for displaying//
			$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();//used for search form action
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
            $this->data['title']		= addslashes(custom_lang_display("Add Menu"));//Browser Title
            $this->data['heading']		= addslashes(custom_lang_display("Add Information"));
            $this->data['pathtoclass']	= $this->pathtoclass;
			$this->data['BREADCRUMB']	= array('list'=>array('link'=>$this->pathtoclass,'text'=>custom_lang_display('Manage Menu')),custom_lang_display('Add Information'));
			$this->data['mode']			= "add";
            $posted = array();
            if($_POST)
            {
				
                $posted = $this->input->post(NULL, TRUE);   
					
                $this->form_validation->set_rules('s_name', addslashes(custom_lang_display('Name')), 'required|xss_clean|is_unique['.$this->tbl.'.s_name]');                
				 
                if($this->form_validation->run() == FALSE)//invalid
                {					
                    //Display the add form with posted values within it//
                    $this->data["posted"] = $posted;
                }
                else//validated, now save into DB
                {
					$info = array();    
                    $info = $posted;   
                    $info["i_status"] = 1;     
                    unset($info["h_id"]);  
					
					$i_newid = $this->cs_model->add_data($this->tbl,$info); 
					
					if($i_newid)//saved successfully
                    {
						set_success_msg($this->cls_msg["save_succ"]);
                        //redirect($this->pathtoclass."show_list");
                        redirect($this->pathtoclass."modify_information/".encrypt($i_newid));
                    }
                    else//Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                }
            }
            //end Submitted Form//			
			
            $this->render("menu_list/add-edit");
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
			$this->data['title'] =  addslashes(custom_lang_display("Edit Menu"));//Browser Title
            $this->data['heading']=  addslashes(custom_lang_display("Edit Information"));
            $this->data['pathtoclass']=$this->pathtoclass;
			$this->data['BREADCRUMB']	= array('list'=>array('link'=>$this->pathtoclass,'text'=>custom_lang_display('Manage Menu')),custom_lang_display('Edit Information'));
            $this->data['mode']="edit";	
            
            //Submitted Form//
            if($_POST)
            {
				
				$posted = array();
                $posted = $this->input->post(NULL, TRUE);                                                
                				
				$this->form_validation->set_rules('s_name', addslashes(custom_lang_display('Name')), 'required|xss_clean|is_unique['.$this->tbl.'.s_name.i_id.'.decrypt($posted["h_id"]).']'); 
                
                  
                if($this->form_validation->run() == FALSE)//invalid
                {					
                    //Display the add form with posted values within it//
                    $this->data["posted"] = $posted;
                }
                else//validated, now save into DB
                {
					$info = array();
                    $info = $posted;
                    unset($info["h_id"]);  
					
                    $i_aff = $this->cs_model->edit_data($this->tbl,$info,array('i_id'=>decrypt($posted["h_id"])));
                    if($i_aff)//saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
                        //redirect($this->pathtoclass."show_list");
                        redirect($this->pathtoclass."modify_information/".$posted["h_id"]); 
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
                $info = $this->cs_model->fetch_this($this->tbl,'i_id',decrypt($i_id));         
				$posted = $info[0];
                $posted['h_mode'] = $this->data['mode'];
				$posted["h_id"] = $i_id;
                $this->data["posted"] = $posted;       
                unset($info,$posted);      
            }
            //end Submitted Form//
            $this->render("menu_list/add-edit");
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    } 
    
    /*Assign Pages*/
	public function assign_pages($i_id=0)
    {
          
        try
        {
            $this->data['title'] =  addslashes(custom_lang_display("Assign Pages To Menu"));//Browser Title
            $this->data['heading']=  addslashes(custom_lang_display("Assign Pages"));
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['BREADCRUMB']    = array('list'=>array('link'=>$this->pathtoclass,'text'=>custom_lang_display('Manage Menu')),custom_lang_display('Assign Pages'));
            $this->data['mode']="assign";    
                
                   
                $info = $this->cs_model->fetch_this($this->tbl,'i_id',decrypt($i_id));         
                $posted = $info[0];
                $posted['h_mode'] = $this->data['mode'];
                $posted["h_id"] = $i_id;
                
                
                $this->data['assigned_pages'] = $this->cs_model->fetch_this($this->tbl_menu_page,'menu_id',decrypt($i_id),' ORDER BY page_order ASC, page_title ASC');   
                
                //$this->data['assigned_pages_1'] = getCheckMenus(0,decrypt($i_id));
                
                //$posted["content"] = $this->load->view("web_master/menu_list/assign_pages.tpl.php",$this->data,true);    
                $posted["content"] = getCheckMenus(0,decrypt($i_id));
                #pr($posted["content"],1);
                $this->data["posted"] = $posted;    
                    
                unset($info,$posted);      
            
            
            $this->render("menu_list/assign");
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }              
	
	public function ajax_assign_pages(){
            try
            {    
               
                $menu_id = $this->input->post('menu_id',true);
                $cms = $this->input->post('cms',true);
                $link_url = $this->input->post('link_url',true);
                $link_text = $this->input->post('link_text',true);
                
                
                //pr($cms,1);
                //$cms_1 = array_map(array('Menu_list','cb_cms'),$cms);
                //echo 1;pr($cms_1);echo 2;exit;
                $data = array();
                if(!empty($cms)){
                    foreach($cms as $val){
                        $info = $this->cs_model->fetch_this($this->tbl_cms,'i_id',$val);
                        //pr($info);
                        if(!empty($info)){$page_title = $info[0]['s_title'];}
                        else $page_title = '';
                        if(!empty($info)){$page_key = $info[0]['s_url'];}
                        else $page_key = '';
                        /*$data[] = array('menu_id'=>decrypt($menu_id),'page_id'=>$val,'page_title_default'=>$page_title,'page_title'=>$page_title,'page_link'=>base_url().'cms/'.$page_key,'page_target'=>"_self");*/
                        $data[] = array('menu_id'=>decrypt($menu_id),'page_id'=>$val,'page_title_default'=>$page_title,'page_title'=>$page_title,'page_link'=>$page_key,'page_target'=>"_self");
                    }
                } 
                
                if(!empty($data)){  
               
                $this->cs_model->add_multiple_data($this->tbl_menu_page,$data); 
                
                }
                
                
                if(filter_var($link_url, FILTER_VALIDATE_URL) && !empty($link_url) && !empty($link_text)) {  
                    
                    
                    $i_newid = $this->cs_model->add_data($this->tbl_menu_page,array("menu_id"=>decrypt($menu_id),"page_id"=>0,"page_title"=>$link_text,"page_link"=>$link_url,'page_target'=>"_self"));
                    
                }

                //$info = $this->cs_model->fetch_like_this($this->tbl_type,"i_id",$this->input->post('i_id',true));     
                //$this->data['assigned_pages'] = $this->cs_model->fetch_this($this->tbl_menu_page,'menu_id',decrypt($menu_id),' ORDER BY page_order ASC, i_id ASC'); 
                //$this->data['assigned_pages_1'] = getCheckMenus(0,decrypt($menu_id));  
               
                $content = getCheckMenus(0,decrypt($menu_id));    
                $content = str_replace('</li>','',$content);
                
                
                die(json_encode(array('content'=>$content)));
              
                if(!empty($this->data['assigned_pages_1'])){
                /*foreach($posted as $val){
               
                $content .= '<li class="ui-state-default" id="'.$val['i_id'].'" itemid="'.$val['i_id'].'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'. $val['page_title'].'</li>';
                
                }*/
                //$content = $this->load->view("web_master/menu_list/assign_pages.tpl.php",$this->data,true); 
                $content = $this->load->view("web_master/menu_list/assign_pages.tpl.php",$this->data,true);    
                die(json_encode(array('content'=>$content)));
                }
                                      
              
                
            }
            catch(Exception $err_obj)
            {
                show_error($err_obj->getMessage());
            }
    }
    
    public function ajax_save_pages(){
            try
            {    
               
                $menu_id = $this->input->post('menu_id',true);
                $i_id = $this->input->post('i_id',true);
                $page_target = $this->input->post('page_target',true);
                $page_title = $this->input->post('page_title',true);
                $page_class = $this->input->post('page_class',true);
                
                $info = array();
                foreach($i_id as $ind=>$val){                    
                   
                    $info = array('page_target'=>$page_target[$ind],'page_title'=>$page_title[$ind],'page_class'=>$page_class[$ind]);
                    $i_aff = $this->cs_model->edit_data($this->tbl_menu_page,$info,array('i_id'=>decrypt($val)));
                     
                    
                }
               
                //$this->data['assigned_pages'] = $this->cs_model->fetch_this($this->tbl_menu_page,'menu_id',decrypt($menu_id),' ORDER BY page_order ASC, i_id DESC');
                
                $this->data['assigned_pages_1'] = getCheckMenus(0,decrypt($menu_id));     
               
              
                if(!empty( $this->data['assigned_pages_1'])){
                    /*foreach( $this->data['assigned_pages'] as $val){
                   
                    $content .= '<li class="ui-state-default" id="'.$val['i_id'].'" itemid="'.$val['i_id'].'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'. $val['page_title'].'</li>';                    
                    
                    }*/
                    
                    $content = $this->load->view("web_master/menu_list/assign_pages.tpl.php",$this->data,true); 
                    die(json_encode(array('content'=>$content)));
                }
                                      
                
                
            }
            catch(Exception $err_obj)
            {
                show_error($err_obj->getMessage());
            }
    }
    
    public function ajax_delete_pages(){
        
        try
        {
                
        $i_id = decrypt($this->input->post('i_id',true));
        $i_ret   = $this->cs_model->delete_info($this->tbl_menu_page,$i_id);   
        // new code on 14 Oct, 2015. Make the immediate child parent id to 0;
        $edit_Arr = array();
        $edit_Arr['i_parent_id']=0;
        $cond = array('i_parent_id'=>$i_id);
        $i_aff = $this->acs_model->edit_data($this->tbl_menu_page,$edit_Arr,$cond);
        //echo 'Menu Pk=>'.$i_id; exit;
        die(json_encode(array('ret'=>$i_ret)));
        
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
        
    } 
    
    
    public function ajax_sort_level_pages($menu_id='')
    {
        try
        {
            $res = array('status' => 'error', 'msg' => get_message('save_failed'));
            $new_order = $this->input->post('list');
            $menu_id = decrypt($this->input->post('menu_id', true));
            if(!empty($new_order))
            {
                foreach($new_order as $k => $v)
                {
                    if($k > 0) // Update this new order
                    {
                        // for sorting order get help from 
                        #http://stackoverflow.com/questions/12546039/how-to-update-database-from-nestedsortable-to-hierachical
                        $parentId = ($v === null) ? 0 : $v;
                        // init the sort order value to 1 if this element is on a new level
                        if (!array_key_exists($parentId, $sort)) {
                            $sort[$parentId] = 1;
                        }
        
                        if($this->acs_model->edit_data($this->tbl_menu_page, array('page_order' => $sort[$parentId], 'i_parent_id' => intval($v)), array('i_id' => $k, 'menu_id' => $menu_id)))
                        {
                            $res['status'] = 'success';
                            $res['msg'] = get_message('save_success');
                        }
                        $sort[$parentId]++;
                    }
                }
            }
            
            /*$arr = explode("~",$_REQUEST['test']);
            unset($arr[0],$arr[1]);
            $new = array();
            if(!empty($arr))
            {
                unset($arr[0],$arr[1]);
                #pr($arr);
                foreach($arr as $ind=>$val){
                    $inner = explode("=>",$val);
                    $sub_inner = explode(",",$inner['1']);
                    $new[] = array('item_id'=>str_replace('parent_id','',$inner['1']),'parent_id'=>$inner['2']);
                }
            }
            //print_r($new);                
            #pr($new);
            foreach($new as $ind=>$val)
            {                    
                if(!empty($val)){
                    $info = array();
                    $info = array('page_order'=>($ind+1),'i_parent_id'=>$val['parent_id']);
                    $i_aff = $this->acs_model->edit_data($this->tbl_menu_page,$info,array('i_id'=>$val['item_id']));
                }                                
            }*/
            echo json_encode($res);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    public function ajax_sort_pages($menu_id=''){
            try
            {
                ///
                
                
                if(isset($_POST['sort_pages']) && $_POST['sort_pages'] == 1 && isset($_POST['data']) && isset($_POST['menu_id'])){

                    $pages = explode("-",$_POST['data']);
                    
                        
                    if(!empty($pages)){
  
                        foreach($pages as $ind=>$val){
                                
                                if(!empty($val)){
                                $info = array('page_order'=>($ind+1));
                                                                
                                $i_aff = $this->cs_model->edit_data($this->tbl_menu_page,$info,array('i_id'=>$val));
                                }                                
                                   
                        }

                    }

                }

                ///
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
     /***
    * Checks duplicate value using ajax call
    */
    public function ajax_checkduplicate()
    {
        try
        {
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	 
	public function ajax_remove_information()
    {
        try
        {
			$i_id = decrypt($this->input->post("temp_id"));
			$i_rect	= $this->cs_model->delete_info($this->tbl,$i_id); /*don't change*/       
            $i_rect_rel = $this->cs_model->delete_data($this->tbl_menu_page,array('menu_id'=>$i_id)); 
                     
			if($i_rect && $i_rect_rel)////saved successfully
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
			$i_rect = $this->cs_model->change_status($this->tbl,$info,$posted["id"]); /*don't change*/				
			echo $i_rect? 'ok' : 'error';
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