<?php 
/***
File Name: manage_questions.php 
Created By: SWI Dev 
Created On: Sept 11, 2017
Purpose: CURD for manage_questions 
*/

class Manage_questions extends MY_Controller 
{
	public $patchtoclass, $cls_msg, $tbl, $tbl_exam;
	public function __construct(){
		parent::__construct();
		$this->data["title"] 		= 'Manage Questions & Answers';//Browser Title 
		$this->pathtoclass 			= admin_base_url().$this->router->fetch_class()."/";
        
		$this->tbl 					= $this->db->EXAM_QUESTION_ANSWER;// Default Table
		$this->tbl_exam 			= $this->db->EXAM;// Default Table
        $this->data['BREADCRUMB'] 	= array('Manage Questions & Answers');
		
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
			
            $this->data['heading'] = "Manage Questions & Answers"; //Package Name[@package] Panel Heading
            
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
			$search_variable["s_name"] = ($this->input->post("h_search")?$this->input->post("s_name"):$arr_session_data["s_name"]);
			$search_variable["exam_name"] = ($this->input->post("h_search")?$this->input->post("exam_name"):$arr_session_data["exam_name"]);
            //end Getting Posted or session values for search//            
            
            $s_where = " n.i_id != 0 AND n.i_is_deleted=0 AND ex.i_is_deleted = 0 AND ex.i_status=1 ";
            if($s_search == "advanced")
            {
                $arr_session = array();
                $arr_session["searching_name"] = $this->data['heading'];
                
				if(trim($search_variable["s_name"])!="")
				{
					$s_where .= " AND n.s_question LIKE '%".my_receive($search_variable["s_name"])."%' ";
				}
				if(trim($search_variable["exam_name"])!="")
				{
					$s_where .= " AND ex.s_name LIKE '%".my_receive($search_variable["exam_name"])."%' ";
				}
				$arr_session["exam_name"] 	= $search_variable["exam_name"];
				$arr_session["s_name"] 		= $search_variable["s_name"];
				$this->data["s_name"] 		= $search_variable["s_name"];
				$this->data["exam_name"] 	= $search_variable["exam_name"];
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
                $this->data["s_name"] = ''; 
                $this->data["exam_name"] = ''; 
                //end Storing search values into session//                 
            }
            
            unset($s_search,$arr_session,$search_variable);
              
            //Setting Limits, If searched then start from 0//
            $i_uri_seg = 6;
            $start = $this->input->post("h_search") ? 0 : $this->uri->segment($i_uri_seg);
            //end generating search query//
            
            // List of fields for sorting
            $arr_sort = array('0'=>'n.dt_created_on');   
            $order_by =!empty($order_by)?in_array(decrypt($order_by),$arr_sort)?decrypt($order_by):$arr_sort[0]:$arr_sort[0];
            
            $limit = $this->i_admin_page_limit;
            
            $tbl[0] = array(
                'tbl' => $this->tbl.' AS n',
                'on' =>''
            );

            $tbl[1] = array(
                'tbl' => $this->tbl_exam.' AS ex',
                'on' => 'n.i_exam_id = ex.i_id'
            );

			$s_where .= " GROUP BY n.i_exam_id "; 
            /*$s_where .= " ORDER BY $order_by $sort_type"; 
            $info = $this->acs_model->fetch_data($this->tbl.' AS n', $s_where, '', intval($start), $limit);
            $total = $this->acs_model->count_info($this->tbl.' AS n', $s_where, 'n.');*/
            
            $conf = array(
                'select' => 'n.i_id, n.i_exam_id, n.s_question, n.s_option1, n.s_option2, n.s_option3, n.s_option4, n.dt_created_on, n.i_status, ex.s_name AS exam_name',
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
            $table_view["caption"]                 = "Manage Questions & Answers";
            $table_view["total_rows"]              = count($info);
            $table_view["total_db_records"]        = $total;
            $table_view["detail_view"]             = false;  // to disable show details. 
            $table_view["order_name"]              = encrypt($order_by);
            $table_view["order_by"]                = $sort_type;
            $table_view["src_action"]              = $this->pathtoclass.$this->router->fetch_method();
            
            $j = -1;
            
			$table_view["headers"][++$j]["width"]   = "30%";
			$table_view["headers"][$j]["align"]     = "left";
			$table_view["headers"][$j]["val"]       = "Examination";
			
			$table_view["headers"][++$j]["width"]   = "25%";
			$table_view["headers"][$j]["align"]     = "center";
			$table_view["headers"][$j]["val"]       = "Total Question";
			
			$table_view["headers"][++$j]["width"]   = "25%";
			$table_view["headers"][$j]["align"]     = "left";
			$table_view["headers"][$j]["val"]       = "Date";
			$table_view["headers"][$j]["sort"]      = array('field_name'=>encrypt($arr_sort[0]));
            //end Table Headers, with width,alignment//
            
            //Table Data//
            for($i = 0; $i< $table_view["total_rows"]; $i++)
            {
                $i_col = 0;
                $table_view["tablerows"][$i][$i_col++] = encrypt($info[$i]["i_exam_id"]);                
                
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["exam_name"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["i_exam_id"] ? _total_question($info[$i]["i_exam_id"]) : "";
				$table_view["tablerows"][$i][$i_col++] = admin_date($info[$i]["dt_created_on"]);
				
                /*$info[$i]["s_status"] = $info[$i]["i_status"]==1?"Active":"Inactive";
                if($info[$i]["i_status"] == 1)
                {
                    $table_view["tablerows"][$i][$i_col++] = make_label($info[$i]["s_status"], 'success', array('id'=>'status_label_'.$info[$i]["i_id"]));
                    $action = '<a id="change_status_'.$i.'" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Change Status" class="glyphicon glyphicon-check" data-original-title="Change Status"  status="Inactive">&nbsp;</a>';
                }
                else
                {
                    $table_view["tablerows"][$i][$i_col++] = make_label($info[$i]["s_status"], 'warning', array('id'=>'status_label_'.$info[$i]["i_id"])); 
                    $action = '<a id="change_status_'.$i.'" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Change Status" class="glyphicon glyphicon-unchecked" data-original-title="Change Status" status="Active">&nbsp;</a>';
                }*/
                    
                // create question options
                $action .= '&nbsp;<a id="create_set_'.$i.'" data-id="'.$info[$i]["i_exam_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Create Questions" class="fa fa-plus-circle" data-original-title="Create Questions"></a>';
                           
                $table_view["rows_action"][$i] = $action;     
            } 
            //end Table Data//
            unset($i, $i_col, $start, $limit, $s_where); 
            
            $this->data['action_allowed']['Add'] = FALSE; // off add action button in this page
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
    public function add_information($number_set= 'TVRBallXTjE=', $exam_id='')
    {
        $this->data['heading']      = "Add Question";
        $this->data['pathtoclass']  = $this->pathtoclass;
        $this->data['BREADCRUMB']   = array('Add Question');
        $this->data['mode']         = 'add';
        
        if(!decrypt($number_set) || !decrypt($exam_id))
        {
			redirect(base_url('web_master/manage_question/show_list'));
		}
        
        //$sess_exam_id = $this->session->userdata('sess_exam_id');
        $sess_exam_id = decrypt($exam_id);
        $this->data['sess_exam_id'] =  $sess_exam_id;
        
        $number_set = decrypt($number_set);
        $this->data['number_set'] =  $number_set;       
                
        if($_POST)
        {
            $posted = array();            
			$posted['s_question']   = $this->input->post("s_question");
			$posted['s_option1']    = $this->input->post("s_option1");
			$posted['s_option2']    = $this->input->post("s_option2");
			$posted['s_option3']    = $this->input->post("s_option3");
			$posted['s_option4']    = $this->input->post("s_option4");
            
			$this->form_validation->set_rules('h_exam_id', 'exam', 'required|xss_clean');
            if($this->form_validation->run() == FALSE)//invalid
            {
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {
				$info = array();
                if(!empty($posted['s_question']))
                {
					for($j =0; $j < count($posted['s_question']); $j++)
					{
						if($posted['s_question'][$j] != '')
						{
							$info[$j]['i_exam_id']  = $sess_exam_id;
							$info[$j]['s_question'] = $posted['s_question'][$j];
							$info[$j]['s_option1'] 	= $posted['s_option1'][$j];
							$info[$j]['s_option2'] 	= $posted['s_option2'][$j];
							$info[$j]['s_option3'] 	= $posted['s_option3'][$j];
							$info[$j]['s_option4'] 	= $posted['s_option4'][$j];
						}
					}
				}
				
				$qry = "DELETE FROM {$this->tbl} WHERE i_exam_id = '".my_receive($sess_exam_id)."' ";
				//$qry = "UPDATE {$this->tbl} SET i_is_deleted=1 WHERE i_exam_id = '".my_receive($sess_exam_id)."' ";
				$this->acs_model->exc_query($qry, false);
					
                //$i_newid = $this->acs_model->add_data($this->tbl, $posted);
                $i_newid = $this->acs_model->add_multiple_data($this->tbl, $info);
                if($i_newid)//saved successfully
                {
					$qry = "UPDATE {$this->tbl_exam} SET s_set1='', s_set2='', s_set3='', s_set4='', s_set5='', s_set6='' WHERE iid = '".my_receive($sess_exam_id)."' ";
					$this->acs_model->exc_query($qry, false);
                    set_success_msg(get_message("save_success"));
                    //redirect($this->pathtoclass."show_list");
                    redirect(base_url("web_master/manage_examination/show_list"));
                }
                else//Not saved, show the form again
                {
                    set_error_msg(get_message("save_failed"));
                }
			}
        }
        //end Submitted Form//
        else
        {
			 $tmp = $this->acs_model->fetch_data($this->tbl,array('i_exam_id'=>decrypt($exam_id)));  
			 $this->data['qa_set'] =  $tmp; 
			 //pr($this->data['qa_set']);
		}
        $this->render("manage_questions/add-edit");
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
        $this->data['heading']      = "Edit Question";
        $this->data['pathtoclass']  = $this->pathtoclass;
        $this->data['BREADCRUMB']   = array('Edit Question');
        $this->data['mode']         = 'edit';   
        
        $sess_exam_id = decrypt($i_id);     
        $this->data['sess_exam_id'] =  $sess_exam_id;
        
        if($_POST)
        {            
            $posted = array();            
			$posted['s_question']   = $this->input->post("s_question");
			$posted['s_option1']    = $this->input->post("s_option1");
			$posted['s_option2']    = $this->input->post("s_option2");
			$posted['s_option3']    = $this->input->post("s_option3");
			$posted['s_option4']    = $this->input->post("s_option4");
			$posted['h_id']    		= $this->input->post("h_id");
            
			$this->form_validation->set_rules('h_id', 'exam', 'required|xss_clean');
            if($this->form_validation->run() == FALSE)//invalid
            {
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {
                $i_id = decrypt($posted["h_id"]);
                unset($posted["h_id"]);
                
				$info = array();
                if(!empty($posted['s_question']))
                {
					for($j =0; $j < count($posted['s_question']); $j++)
					{
						if($posted['s_question'][$j] != '')
						{
							$info[$j]['i_exam_id']  = $sess_exam_id;
							$info[$j]['s_question'] = $posted['s_question'][$j];
							$info[$j]['s_option1'] 	= $posted['s_option1'][$j];
							$info[$j]['s_option2'] 	= $posted['s_option2'][$j];
							$info[$j]['s_option3'] 	= $posted['s_option3'][$j];
							$info[$j]['s_option4'] 	= $posted['s_option4'][$j];
						}
					}
				}
                
                if(count($info) > 1)
                {
					// first remove the old data
					$qry = "DELETE FROM {$this->tbl} WHERE i_exam_id = '".my_receive($sess_exam_id)."' ";
					//$qry = "UPDATE {$this->tbl} SET i_is_deleted=1 WHERE i_exam_id = '".my_receive($sess_exam_id)."' ";
					$this->acs_model->exc_query($qry, false);
					
					$i_newid = $this->acs_model->add_multiple_data($this->tbl, $info);                
					//$i_aff = $this->acs_model->edit_data($this->tbl,$posted, array('i_id'=>$i_id));
				}
                if($i_newid)//saved successfully
                {
					$qry = "UPDATE {$this->tbl_exam} SET s_set1='', s_set2='', s_set3='', s_set4='', s_set5='', s_set6='' WHERE iid = '".my_receive($sess_exam_id)."' ";
					$this->acs_model->exc_query($qry, false);
					
                    set_success_msg(get_message("save_success"));
                    //redirect($this->pathtoclass."show_list");                    
                    redirect(base_url("web_master/manage_examination/show_list"));
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
            //$tmp = $this->acs_model->fetch_data($this->tbl,array('i_id'=>decrypt($i_id)));
            $tmp = $this->acs_model->fetch_data($this->tbl,array('i_exam_id'=>decrypt($i_id), 'i_is_deleted'=>0));  
            $this->data['number_set'] =  count($tmp);         
            $posted                 = $tmp;
            $posted['h_id']         = $i_id;
            $this->data['posted']   = $posted;
            $posted['h_mode']       = $this->data['mode'];
        }
        
        $this->render("manage_questions/add-edit");
    }

    /***
    * Shows details of a single record.
    * 
    * @param int $i_id, Primary key
    */
    public function view_detail($i_id = 0)
    {
        
    }
    
    
    // ajax set no of questions answer
    public function ajax_set_number_of_qa()
    {
        $response = array('red_link' =>'', 'status' =>'error');
        $exam_id = $this->input->post('exam_id', true); 
        $i_number = $this->input->post('i_number', true); 
        if( intval($i_number))
        {
			$this->session->unset_userdata('sess_exam_id');
			$this->session->unset_userdata('sess_no_qa');
			
			//$this->session->set_userdata('sess_exam_id', $exam_id);
			//$this->session->set_userdata('sess_no_qa', $i_number);
			
            $red_link = base_url('web_master/manage_questions/add_information').'/'.encrypt($i_number).'/'.encrypt($exam_id);
			$response['red_link']	= $red_link;
			$response['status']		= 'success';
        }
        echo json_encode($response);
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
            $update = array();
            $update['i_is_deleted'] = 1;
            echo $this->acs_model->edit_data($this->tbl,$update, array('i_exam_id'=>$i_id))? 'ok' : 'error';
            unset($i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
    
    /*public function ajax_change_status()
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
    }*/


	public function __destruct(){}
}
