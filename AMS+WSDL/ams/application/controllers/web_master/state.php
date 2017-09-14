<?php 
/***
File Name: state.php 
Created By: ACS Dev 
Created On: May 29, 2015 
Purpose: CURD for State 
*/

class State extends MY_Controller 
{
	public $patchtoclass, $cls_msg, $tbl;
	protected $tbl_ref_cou;
	public function __construct(){
		parent::__construct();
		$this->data["title"] = addslashes(t('Manage State'));//Browser Title 
		$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
		$this->tbl = $this->db->STATE;// Default Table
		$this->tbl_ref_cou = $this->db->COUNTRY;
        $this->data['BREADCRUMB'] = array(addslashes(t('Manage State')));
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
            $this->data['heading'] = addslashes(t("Manage State")); //Package Name[@package] Panel Heading
            
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
			$search_variable["i_country_id"] = ($this->input->post("h_search")?$this->input->post("i_country_id"):$arr_session_data["i_country_id"]);
			$search_variable["name"] = ($this->input->post("h_search")?$this->input->post("name"):$arr_session_data["name"]);
            //end Getting Posted or session values for search//            
            
            $s_where = " n.i_id != 0 AND n.i_is_deleted=0 AND n.i_country_id!=113 ";
            if($s_search == "advanced")
            {
                $arr_session = array();
                $arr_session["searching_name"] = $this->data['heading'];
                
				if(intval($search_variable["i_country_id"])>0)
				{
					$s_where .= " AND cou.i_id = '".addslashes($search_variable["i_country_id"])."' ";
				}
				$arr_session["i_country_id"] = $search_variable["i_country_id"];
				$this->data["i_country_id"] = $search_variable["i_country_id"];
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
            
			#$this->data['dd_val']=$this->generate_drodown('mp_country', 'name', $search_variable["i_country_id"], 'array');

            unset($s_search,$arr_session,$search_variable);
              
            //Setting Limits, If searched then start from 0//
            $i_uri_seg = 6;
            $start = $this->input->post("h_search") ? 0 : $this->uri->segment($i_uri_seg);
            //end generating search query//
            
            // List of fields for sorting
            //$arr_sort = array('0'=>'n.name', '1'=>'n.i_country_id');   
            //$order_by =!empty($order_by)?in_array(decrypt($order_by),$arr_sort)?decrypt($order_by):$arr_sort[0]:$arr_sort[0];
            
            #unset($order_by);
            if($order_by=='')
            {
							
				$order_by[] = array('order_by'=>'n.i_country_id',
								'order_type'=>'DESC');
				$order_by[] = array('order_by'=>'n.name',
							'order_type'=>'ASC');
			}
			else
			{				
				$arr_sort = array('0'=>'n.name', '1'=>'n.i_country_id');   
				$order_by =!empty($order_by)?in_array(decrypt($order_by),$arr_sort)?decrypt($order_by):$arr_sort[0]:$arr_sort[0];
			}
							
            $limit = $this->i_admin_page_limit;
			

            $tbl[0] = array(
                'tbl' => $this->tbl.' AS n',
                'on' =>''
            );

            $tbl[1] = array(
                'tbl' => $this->tbl_ref_cou.' AS cou',
                'on' => 'n.i_country_id = cou.i_id'
            );
            $conf = array(
                'select' => 'n.i_id, n.i_country_id, n.name, n.i_status, n.i_is_deleted, cou.name AS country',
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
            $table_view["caption"]                 = addslashes(t("Manage State"));
            $table_view["total_rows"]              = count($info);
            $table_view["total_db_records"]        = $total;
            $table_view["detail_view"]             = false;  // to disable show details. 
            $table_view["order_name"]              = encrypt($order_by);
            $table_view["order_by"]                = $sort_type;
            $table_view["src_action"]              = $this->pathtoclass.$this->router->fetch_method();
            
            $j = -1;
            
			$table_view["headers"][++$j]["width"]   = "25%";
			$table_view["headers"][$j]["align"]     = "left";
			$table_view["headers"][$j]["val"]       = addslashes(t("Country"));
			#$table_view["headers"][$j]["sort"]      = array('field_name'=>encrypt($arr_sort[1]));
			$table_view["headers"][++$j]["width"]   = "25%";
			$table_view["headers"][$j]["align"]     = "left";
			$table_view["headers"][$j]["val"]       = addslashes(t("State/Province"));
			$table_view["headers"][$j]["sort"]      = array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][++$j]["width"]   = "25%";
			$table_view["headers"][$j]["align"]     = "left";
			$table_view["headers"][$j]["val"]       = addslashes(t("Status"));
			/*$table_view["headers"][++$j]["width"]   = "25%";
			$table_view["headers"][$j]["align"]     = "left";
			$table_view["headers"][$j]["val"]       = addslashes(t("Is Deleted"));*/
            //end Table Headers, with width,alignment//
            
            //Table Data//
            for($i = 0; $i< $table_view["total_rows"]; $i++)
            {
                $i_col = 0;
                $table_view["tablerows"][$i][$i_col++] = encrypt($info[$i]["i_id"]);                
                
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["country"];
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
				#$table_view["tablerows"][$i][$i_col++] = $info[$i]["i_is_deleted"];
            } 
            //end Table Data//
            unset($i, $i_col, $start, $limit, $s_where); 
            
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
		#$this->data['dd_val'] = $this->generate_drodown('mp_country', 'name', $search_variable["i_country_id"], 'array');
        
        if($_POST)
        {
            $posted = array();
            
			$posted["i_country_id"]         = $this->input->post("i_country_id", true);
			$posted["name"]                 = $this->input->post("name", true);
			/*$posted["Code"]               = $this->input->post("Code", true);
			$posted["ADM1Code"]             = $this->input->post("ADM1Code", true);*/
			$posted["i_status"]             = $this->input->post("i_status", true);
			#$posted["i_is_deleted"]        = $this->input->post("i_is_deleted", true); 
            $posted["s_identification_no"]  = $this->input->post("s_identification_no", true);
            
			$this->form_validation->set_rules('i_country_id', addslashes(t('country')), 'required|xss_clean');
			$this->form_validation->set_rules('name', addslashes(t('state')), 'required|xss_clean');
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
                    set_success_msg(get_message('save_success'));
                    redirect($this->pathtoclass."show_list");
                }
                else//Not saved, show the form again
                {
                    set_error_msg(get_message('save_failed'));
                }
			}
        }
        //end Submitted Form//
        
        $this->render("state/add-edit");
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
        
		#$this->data['dd_val'] = $this->generate_drodown('mp_country', 'name', $search_variable["i_country_id"], 'array');

        
        if($_POST)
        {
            $posted = array();
        
			$posted["i_country_id"]         = $this->input->post("i_country_id", true);
			$posted["name"]                 = $this->input->post("name", true);
			/*$posted["Code"]               = $this->input->post("Code", true);
			$posted["ADM1Code"]             = $this->input->post("ADM1Code", true);*/
			$posted["i_status"]             = $this->input->post("i_status", true);
            #$posted["i_is_deleted"]        = $this->input->post("i_is_deleted", true);
			$posted["s_identification_no"]  = $this->input->post("s_identification_no", true);

            $posted["h_id"] = $this->input->post("h_id", true);
			$this->form_validation->set_rules('i_country_id', addslashes(t('country')), 'required|xss_clean');
			$this->form_validation->set_rules('name', addslashes(t('state')), 'required|xss_clean');
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
        
        $this->render("state/add-edit");
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
            $this->load->view('web_master/state/show_detail.tpl.php', $this->data); 
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
            if(intval($i_id) > 0)
                echo $this->acs_model->delete_data($this->tbl, array('i_id'=>$i_id)) ? 'ok' : 'error';
            else
                echo 'error';
            
            /*$update['i_is_deleted'] = 1;
            if(intval($i_id) > 0)
                echo $this->acs_model->edit_data($this->tbl, $update, array('i_id'=>$i_id)) ? 'ok' : 'error';
            else
                echo 'error';*/
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
