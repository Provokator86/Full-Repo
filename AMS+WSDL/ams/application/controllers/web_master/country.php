<?php 
/***
File Name: country.php 
Created By: ACS Dev 
Created On: May 29, 2015 
Purpose: CURD for Country 
*/

class Country extends MY_Controller 
{
	public $patchtoclass, $cls_msg, $tbl;
	public function __construct(){
		parent::__construct();
		$this->data["title"] = addslashes(t('Manage Country'));//Browser Title 
		$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
        #$this->tbl = 'mp_country';// Default Table
		$this->tbl = $this->db->COUNTRY;// Default Table
        $this->data['BREADCRUMB'] = array(addslashes(t('Manage Country')));
		
	}

	//Default method (index)
	public function index()
	{
		redirect($this->pathtoclass.'show_list');
	}

    /****
    * Display the list of records 
    */
    public function show_list($order_by = '', $sort_type = 'asc',$start = NULL, $limit = NULL)
    {
        try
        {
            $this->data['heading'] = addslashes(t("Manage Country")); //Package Name[@package] Panel Heading
            
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
			$search_variable["name"] = ($this->input->post("h_search")?$this->input->post("name"):$arr_session_data["name"]);
            //end Getting Posted or session values for search//            
            
            $s_where = " n.i_id != 0 AND n.i_is_deleted=0 ";
            if($s_search == "advanced")
            {
                $arr_session = array();
                $arr_session["searching_name"] = $this->data['heading'];
                
				if(trim($search_variable["name"])!="")
				{
					$s_where .= " AND n.name LIKE '%".addslashes(trim($search_variable["name"]))."%' ";
				}
				$arr_session["name"] = $search_variable["name"];
				$this->data["name"] = $search_variable["name"];
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
            $arr_sort = array('0'=>'n.name');   
            $order_by =!empty($order_by)?in_array(decrypt($order_by),$arr_sort)?decrypt($order_by):$arr_sort[0]:$arr_sort[0];
            
            $limit = $this->i_admin_page_limit;

            $s_where .= " ORDER BY $order_by $sort_type"; 
            $info = $this->acs_model->fetch_data($this->tbl.' AS n', $s_where, '', intval($start), $limit);
            $total = $this->acs_model->count_info($this->tbl.' AS n', $s_where, 'n.');
                  
            //Creating List view for displaying//
            $table_view = array();  
            
            //Table Headers, with width,alignment//
            $table_view["caption"]                 = addslashes(t("Manage Country"));
            $table_view["total_rows"]              = count($info);
            $table_view["total_db_records"]        = $total;
            $table_view["detail_view"]             = false;  // to disable show details. 
            $table_view["order_name"]              = encrypt($order_by);
            $table_view["order_by"]                = $sort_type;
            $table_view["src_action"]              = $this->pathtoclass.$this->router->fetch_method();
            
            $j = -1;
            
			$table_view["headers"][++$j]["width"]   = "40%";
			$table_view["headers"][$j]["align"]     = "left";
			$table_view["headers"][$j]["val"]       = addslashes(t("Country"));
			$table_view["headers"][$j]["sort"]      = array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][++$j]["width"]   = "30%";
			$table_view["headers"][$j]["align"]     = "left";
			$table_view["headers"][$j]["val"]       = addslashes(t("Status"));
            //end Table Headers, with width,alignment//
            
            //Table Data//
            for($i = 0; $i< $table_view["total_rows"]; $i++)
            {
                $i_col = 0;
                $table_view["tablerows"][$i][$i_col++] = encrypt($info[$i]["i_id"]);                
                
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["name"];
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
        $this->data['heading']      = (t("Add Information"));
        $this->data['pathtoclass']  = $this->pathtoclass;
        $this->data['BREADCRUMB']   = array(addslashes(t('Add Information')));
        $this->data['mode']         = 'add';
                
        if($_POST)
        {
            $posted = array();
            
			$posted["name"]     = $this->input->post("name", true);
            $posted["i_status"] = $this->input->post("i_status", true);
			
			$this->form_validation->set_rules('name', addslashes(t('name')), 'required|xss_clean|callback_chk_unique_name');
            if($this->form_validation->run() == FALSE)//invalid
            {
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {
                $posted["i_status"] = ($posted["i_status"]==1)?1:0;
                $i_newid = $this->acs_model->add_data($this->tbl, $posted);
                if($i_newid)//saved successfully
                {
                    set_success_msg(get_message("save_success"));
                    redirect($this->pathtoclass."show_list");
                }
                else//Not saved, show the form again
                {
                    set_error_msg(get_message("save_failed"));
                }
			}
        }
        //end Submitted Form//
        
        $this->render("country/add-edit");
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
        
			$posted["name"]     = $this->input->post("name", true);
            $posted["i_status"] = $this->input->post("i_status", true);

            $posted["h_id"] = $this->input->post("h_id", true);
			$this->form_validation->set_rules('name', addslashes(t('name')), 'required|xss_clean|callback_chk_unique_name');
            if($this->form_validation->run() == FALSE)//invalid
            {
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {
                $posted["i_status"] = ($posted["i_status"]==1)?1:0;
                $i_id = decrypt($posted["h_id"]);
                unset($posted["h_id"]);
                $i_aff = $this->acs_model->edit_data($this->tbl,$posted, array('i_id'=>$i_id));
                if($i_aff)//saved successfully
                {
                    set_success_msg(get_message("save_success"));
                    redirect($this->pathtoclass."show_list");
                }
                else//Not saved, show the form again
                {
                    set_error_msg(get_message("save_failed"));
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
        
        $this->render("country/add-edit");
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
            $this->load->view('web_master/country/show_detail.tpl.php', $this->data); 
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
            //echo $this->acs_model->delete_data($this->tbl, array('i_id'=>$i_id)) ? 'ok' : 'error';
            $update = array();
            $update['i_is_deleted'] = 1;
            echo $this->acs_model->edit_data($this->tbl,$update, array('i_id'=>$i_id))? 'ok' : 'error';
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
    
    public function chk_unique_name()
    {
        $str = $this->input->post("name", true);
        $h_id = $this->input->post("h_id", true);
        if($str)
        {
            $sql = "SELECT name FROM ".$this->tbl." WHERE name = '".addslashes($str)."' AND i_is_deleted=0 ";
            if(decrypt($h_id))
            {
                $sql.=" AND i_id!=".decrypt($h_id)." ";
            }
            $result = $this->db->query($sql)->result_array();
            if(!empty($result))
            {
                $this->form_validation->set_message('chk_unique_name', 'The country name already exist');
                return FALSE;                
            }
            return $result;
        }
    }


	public function __destruct(){}
}
