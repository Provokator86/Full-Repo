<?php 
/***
File Name: category.php 
Created By: ACS Dev 
Created On: June 02, 2015 
Purpose: CURD for Category 
*/
class Sub_category extends MY_Controller 
{
	public $patchtoclass, $cls_msg, $tbl;
	public function __construct(){
		parent::__construct();
		$this->data["title"] = addslashes(t('Manage Sub Category'));//Browser Title 
		$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
        //$this->tbl = 'mp_category';// Default Table
		$this->tbl = $this->db->CATEGORY;// Default Table
        $this->data['BREADCRUMB'] = array(addslashes(t('Manage Sub Category')));
		
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
            $this->data['heading'] = addslashes(t("Manage Sub Category")); //Package Name[@package] Panel Heading            
            //generating search query//
            $arr_session_data = $this->session->userdata("arr_session");
            if($arr_session_data['searching_name'] != $this->data['heading'])
            {
                $this->session->unset_userdata("arr_session");
                $arr_session_data = array();
            }
            
            
            
            $search_variable = array();
            //Getting Posted or session values for search//        
            $s_search = (isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $search_variable["s_category"] = ($this->input->post("h_search")?$this->input->post("s_category"):$arr_session_data["s_category"]);
			$search_variable["i_parent_id"] = ($this->input->post("h_search")?$this->input->post("i_parent_id"):$arr_session_data["i_parent_id"]);
            //end Getting Posted or session values for search//            
            
            $s_where = " n.i_parent_id != 0 AND n.e_deleted='No' ";
            if($s_search == "advanced")
            {
                $arr_session = array();
                $arr_session["searching_name"] = $this->data['heading'];
                
				if(trim($search_variable["s_category"])!="")
				{
					$s_where .= " AND n.s_category LIKE '%".addslashes(trim($search_variable["s_category"]))."%' ";
				}
                if(trim($search_variable["i_parent_id"])!="")
                {
                    $s_where .= " AND n.i_parent_id = '".addslashes(trim($search_variable["i_parent_id"]))."' ";
                }
                $arr_session["s_category"]  = $search_variable["s_category"];
				$arr_session["i_parent_id"] = $search_variable["i_parent_id"];
                $this->data["s_category"]   = $search_variable["s_category"];
				$this->data["i_parent_id"]  = $search_variable["i_parent_id"];
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
                //end Storing search values into session//                 
            }
            
            unset($s_search,$arr_session,$search_variable);
              
            //Setting Limits, If searched then start from 0//
            $i_uri_seg = 6;
            $start = $this->input->post("h_search") ? 0 : $this->uri->segment($i_uri_seg);
            //end generating search query//
            
            // List of fields for sorting
            $arr_sort = array('0'=>'n.s_category');   
            $order_by=!empty($order_by)?in_array(decrypt($order_by),$arr_sort)?decrypt($order_by):$arr_sort[0]:$arr_sort[0];
            
            $limit = $this->i_admin_page_limit;

            $tbl[0] = array(
                'tbl' => $this->tbl.' AS n',
                'on' =>''
            );

            $tbl[1] = array(
                'tbl' => $this->tbl.' AS sc',
                'on' => 'n.i_parent_id = sc.i_id'
            );

            /*$s_where .= " ORDER BY $order_by $sort_type"; 
            $info = $this->acs_model->fetch_data($this->tbl.' AS n', $s_where, '', intval($start), $limit);
            $total = $this->acs_model->count_info($this->tbl.' AS n', $s_where, 'n.');*/
            
            $conf = array(
                'select' => 'n.i_id, n.i_parent_id, n.s_category, n.i_status, n.e_deleted, sc.s_category AS root_cat',
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
            $total = $tmp[0]['total'];
            unset($tmp);
                  
            //Creating List view for displaying//
            $table_view = array();  
            
            //Table Headers, with width,alignment//
            $table_view["caption"]                 = addslashes(t("Category"));
            $table_view["total_rows"]              = count($info);
            $table_view["total_db_records"]        = $total;
            $table_view["detail_view"]             = false;  // to disable show details. 
            $table_view["order_name"]              = encrypt($order_by);
            $table_view["order_by"]                = $sort_type;
            $table_view["src_action"]              = $this->pathtoclass.$this->router->fetch_method();
            
            $j = -1;
            
			$table_view["headers"][++$j]["width"]   = "30%";
			$table_view["headers"][$j]["align"]     = "left";
			$table_view["headers"][$j]["val"]       = addslashes(t("Category"));
			$table_view["headers"][$j]["sort"]      = array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][++$j]["width"]   = "30%";
            $table_view["headers"][$j]["align"]     = "left";
            $table_view["headers"][$j]["val"]       = addslashes(t("Parent Category"));
			$table_view["headers"][++$j]["width"]   = "20%";
			$table_view["headers"][$j]["align"]     = "left";
			$table_view["headers"][$j]["val"]       = addslashes(t("Status"));
            //end Table Headers, with width,alignment//
            
            //Table Data//
            for($i = 0; $i< $table_view["total_rows"]; $i++)
            {
                $i_col = 0;
                $table_view["tablerows"][$i][$i_col++] = encrypt($info[$i]["i_id"]);                
                
                $table_view["tablerows"][$i][$i_col++] = $info[$i]["s_category"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["root_cat"];
				#$table_view["tablerows"][$i][$i_col++] = $info[$i]["i_status"]==1?"Active":"Inactive";
                $info[$i]["s_status"] = $info[$i]["i_status"]==1?"Active":"Inactive";
                if($info[$i]["i_status"] == 1)
                {
                    $table_view["tablerows"][$i][$i_col++] = make_label($info[$i]["s_status"], 'success', array('id'=>'status_label_'.$info[$i]["i_id"]));
                    
                    $action = '<a id="change_status_'.$i.'" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Change Status" class="glyphicon glyphicon-check" data-original-title="Change Status"  status="Inactive">&nbsp;</a>';
                }
                else
                {
                    $table_view["tablerows"][$i][$i_col++] = make_label($info[$i]["s_status"], 'warning', array('id'=>'status_label_'.$info[$i]["i_id"])); 
                    
                    $action = '<a id="change_status_'.$i.'" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Change Status" class="glyphicon glyphicon-unchecked" data-original-title="Change Status" status="Active">&nbsp;</a>';
                }
                               
                $table_view["rows_action"][$i] = $action;     
            } 
            //end Table Data//
            unset($i, $i_col, $start, $limit, $s_where); 
            
            //$this->data["table_view"] = $this->admin_showin_table($table_view,TRUE);
            $this->data['total_record'] = $table_view["total_db_records"];
            $this->data["table_view"]   = $this->admin_showin_order_table($table_view,TRUE);
            
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
            
			$posted["s_category"]       = $this->input->post("s_category", true);
			$posted["i_parent_id"]      = $this->input->post("i_parent_id", true);
			$posted["i_status"]         = $this->input->post("i_status", true);
			
            $this->form_validation->set_rules('i_parent_id', addslashes(t('parent category')), 'required');
			$this->form_validation->set_rules('s_category', addslashes(t('sub category')), 'required|xss_clean');
            if($this->form_validation->run() == FALSE )//invalid
            {
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {
                $posted["i_status"]     = ($posted["i_status"]==1)?1:0;
                $posted["i_parent_id"]  = ($posted["i_parent_id"])?$posted["i_parent_id"]:0;
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
        
        $this->render("sub_category/add-edit");
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
        $this->data['heading']      = (t("Edit Information"));
        $this->data['pathtoclass']  = $this->pathtoclass;
        $this->data['BREADCRUMB']   = array(addslashes(t('Edit Information')));
        $this->data['mode']         = 'edit';
        
        
        if($_POST)
        {
            $posted = array();
        
			$posted["s_category"]       = $this->input->post("s_category", true);
			$posted["i_parent_id"]    = $this->input->post("i_parent_id", true);
			$posted["i_status"]         = $this->input->post("i_status", true);
			//$posted["e_deleted"]      = $this->input->post("e_deleted", true);

            $posted["h_id"] = $this->input->post("h_id", true);
            $this->form_validation->set_rules('i_parent_id', addslashes(t('parent category')), 'required');
			$this->form_validation->set_rules('s_category', addslashes(t('category')), 'required|xss_clean');
            if($this->form_validation->run() == FALSE )//invalid
            {
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {
                $posted["i_status"] = ($posted["i_status"]==1)?1:0;                
                $posted["i_parent_id"] = ($posted["i_parent_id"])?$posted["i_parent_id"]:0;
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
            $posted                 = $tmp[0];
            $posted['h_id']         = $i_id;
            $this->data['posted']   = $posted;
            $posted['h_mode']       = $this->data['mode'];
        }
        
        $this->render("sub_category/add-edit");
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
            $this->load->view('web_master/sub_category/show_detail.tpl.php', $this->data); 
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
            #echo $this->acs_model->delete_data($this->tbl, array('i_id'=>$i_id)) ? 'ok' : 'error';
            $update = array();
            $update["e_deleted"] = 'Yes';
            echo $this->acs_model->edit_data($this->tbl,$update, array('i_id'=>$i_id)) ? 'ok' : 'error';
            unset($i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
    
    
    public function ajax_change_status()
    {
        $response = array('status_html'=>'', 'status_class' =>'', 'status' =>'');
        if($_POST)
        {
            $pId = $this->input->post('pId', true); 
            $status = $this->input->post('status', true); 
            
            $i_status = $status=='Active'?1:0;
            if($this->acs_model->edit_data($this->tbl, array('i_status'=> $i_status), array('i_id' => $pId)))
            {
                $response['status_html'] = make_label($status, ($status == 'Active' ? 'success' : 'warning'));
                $response['status_class'] = $status == 'Active' ? 'glyphicon-check' : 'glyphicon-unchecked';
                $response['status'] = $status == 'Active' ? 'Inactive' : 'Active';
            }
        }
        echo json_encode($response);
    }
    
	public function __destruct(){}
}