<?php 
/***
File Name: examination.php 
Created By: SWI Dev 
Created On: Sept 11, 2017
Purpose: CURD for Examination 
*/

class Manage_examination extends MY_Controller 
{
	public $patchtoclass, $cls_msg, $tbl, $tbl_eqa;
	public function __construct(){
		parent::__construct();
		$this->data["title"] 		= 'Manage Examination';//Browser Title 
		$this->pathtoclass 			= admin_base_url().$this->router->fetch_class()."/";
        
		$this->tbl 					= $this->db->EXAM;// Default Table
		$this->tbl_eqa 				= $this->db->EXAM_QUESTION_ANSWER;
        $this->data['BREADCRUMB'] 	= array('Manage Examination');
		
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
            $this->data['heading'] = "Manage Examination"; //Package Name[@package] Panel Heading
            
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
            //end Getting Posted or session values for search//            
            
            $s_where = " n.i_id != 0 AND n.i_is_deleted=0 ";
            if($s_search == "advanced")
            {
                $arr_session = array();
                $arr_session["searching_name"] = $this->data['heading'];
                
				if(trim($search_variable["s_name"])!="")
				{
					$s_where .= " AND n.s_name LIKE '%".addslashes(trim($search_variable["s_name"]))."%' ";
				}
				$arr_session["s_name"] 	= $search_variable["s_name"];
				$this->data["s_name"] 	= $search_variable["s_name"];
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
                //end Storing search values into session//                 
            }
            
            unset($s_search,$arr_session,$search_variable);
              
            //Setting Limits, If searched then start from 0//
            $i_uri_seg = 6;
            $start = $this->input->post("h_search") ? 0 : $this->uri->segment($i_uri_seg);
            //end generating search query//
            
            // List of fields for sorting
            $arr_sort = array('0'=>'n.s_name');   
            $order_by =!empty($order_by)?in_array(decrypt($order_by),$arr_sort)?decrypt($order_by):$arr_sort[0]:$arr_sort[0];
            
            $limit = $this->i_admin_page_limit;

            $s_where .= " ORDER BY $order_by $sort_type"; 
            $info = $this->acs_model->fetch_data($this->tbl.' AS n', $s_where, '', intval($start), $limit);
            $total = $this->acs_model->count_info($this->tbl.' AS n', $s_where, 'n.');
                  
            //Creating List view for displaying//
            $table_view = array();  
            
            //Table Headers, with width,alignment//
            $table_view["caption"]                 = "Manage Examination";
            $table_view["total_rows"]              = count($info);
            $table_view["total_db_records"]        = $total;
            $table_view["detail_view"]             = false;  // to disable show details. 
            $table_view["order_name"]              = encrypt($order_by);
            $table_view["order_by"]                = $sort_type;
            $table_view["src_action"]              = $this->pathtoclass.$this->router->fetch_method();
            
            $j = -1;
            
			$table_view["headers"][++$j]["width"]   = "22%";
			$table_view["headers"][$j]["align"]     = "left";
			$table_view["headers"][$j]["val"]       = "Examination";
			$table_view["headers"][$j]["sort"]      = array('field_name'=>encrypt($arr_sort[0]));
			
			$table_view["headers"][++$j]["width"]   = "10%";
			$table_view["headers"][$j]["align"]     = "center";
			$table_view["headers"][$j]["val"]       = "# Questions";
			
			$table_view["headers"][++$j]["width"]   = "10%";
			$table_view["headers"][$j]["align"]     = "center";
			$table_view["headers"][$j]["val"]       = "Master Copy";
			
			$table_view["headers"][++$j]["width"]   = "8%";
			$table_view["headers"][$j]["align"]     = "center";
			$table_view["headers"][$j]["val"]       = "Set 1";
			
			$table_view["headers"][++$j]["width"]   = "8%";
			$table_view["headers"][$j]["align"]     = "center";
			$table_view["headers"][$j]["val"]       = "Set 2";
			
			$table_view["headers"][++$j]["width"]   = "8%";
			$table_view["headers"][$j]["align"]     = "center";
			$table_view["headers"][$j]["val"]       = "Set 3";
			
			$table_view["headers"][++$j]["width"]   = "8%";
			$table_view["headers"][$j]["align"]     = "center";
			$table_view["headers"][$j]["val"]       = "Set 4";
			
			$table_view["headers"][++$j]["width"]   = "8%";
			$table_view["headers"][$j]["align"]     = "center";
			$table_view["headers"][$j]["val"]       = "Set 5";
			
			$table_view["headers"][++$j]["width"]   = "8%";
			$table_view["headers"][$j]["align"]     = "center";
			$table_view["headers"][$j]["val"]       = "Set 6";
			
            //end Table Headers, with width,alignment//
            
            //Table Data//
            for($i = 0; $i< $table_view["total_rows"]; $i++)
            {
                $i_col = 0;
                $table_view["tablerows"][$i][$i_col++] = encrypt($info[$i]["i_id"]);                
                $total_question = $info[$i]["i_id"] ? _total_question($info[$i]["i_id"]) : "";
                
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_name"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["i_id"] ? _total_question($info[$i]["i_id"]) : "";				
				
				$table_view["tablerows"][$i][$i_col++] = '<a id="master_dwnld_pdf_'.$i.'" data-rel="master" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Generate Master Copy" class="fa fa-file-pdf-o" data-original-title="Generate Master Copy"></a>' ;
				
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_set1"] ? '<a id="dwnld_pdf_'.$i.'" data-rel="s_set1" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Download" class="fa fa-download" data-original-title="Download"></a>' : '';
				
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_set2"] ? '<a id="dwnld_pdf_'.$i.'" data-rel="s_set2" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Download" class="fa fa-download" data-original-title="Download"></a>' : '';
				
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_set3"] ? '<a id="dwnld_pdf_'.$i.'" data-rel="s_set3" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Download" class="fa fa-download" data-original-title="Download"></a>' : '';
				
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_set4"] ? '<a id="dwnld_pdf_'.$i.'" data-rel="s_set4" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Download" class="fa fa-download" data-original-title="Download"></a>' : '';
				
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_set5"] ? '<a id="dwnld_pdf_'.$i.'" data-rel="s_set5" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Download" class="fa fa-download" data-original-title="Download"></a>' : '';
				
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_set6"] ?  '<a id="dwnld_pdf_'.$i.'" data-rel="s_set6" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Download" class="fa fa-download" data-original-title="Download"></a>' : '';
				
				$action = '';
                /*$info[$i]["s_status"] = $info[$i]["i_status"]==1?"Active":"Inactive";
                if($info[$i]["i_status"] == 1)
                {
                    $table_view["tablerows"][$i][$i_col++] = make_label($info[$i]["s_status"], 'success', array('id'=>'status_label_'.$info[$i]["i_id"]));
                                        
                    $action = '<a id="change_status_'.$i.'" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Change Status" class="glyphicon glyphicon-check" data-original-title="Change Status"  status="Inactive"></a>';
                }
                else
                {
                    $table_view["tablerows"][$i][$i_col++] = make_label($info[$i]["s_status"], 'warning', array('id'=>'status_label_'.$info[$i]["i_id"])); 
                    
                    $action = '<a id="change_status_'.$i.'" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Change Status" class="glyphicon glyphicon-unchecked" data-original-title="Change Status" status="Active"></a>';
                }*/
                
                // create question options
                $action .= '&nbsp;<a id="create_set_'.$i.'" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-qa="'.$total_question.'" data-toggle="tooltip" data-placement="bottom" title="Create Questions" class="glyphicon glyphicon-plus-sign big-icon" data-original-title="Create Questions"></a>';                
				
				// Delete
                $action .= '&nbsp;<a data-toggle="tooltip" data-placement="bottom" title="Delete" class="glyphicon glyphicon-remove big-icon" href="javascript:void(0);" id="btn_delete_0" value="'.encrypt($info[$i]["i_id"]).'"></a>';
                
                 // Download question in pdf
                $action .= '&nbsp;<a id="generate_set_'.$i.'" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Generate Set" class="fa fa-file-pdf-o big-icon" data-original-title="Generate Set"></a>';
                               
                $table_view["rows_action"][$i] = $action;     
            } 
            //end Table Data//
            unset($i, $i_col, $start, $limit, $s_where); 
            
            $this->data['action_allowed']['Edit'] = FALSE;
            $this->data['action_allowed']['Delete'] = FALSE;
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
        $this->data['heading']      = "Add Information";
        $this->data['pathtoclass']  = $this->pathtoclass;
        $this->data['BREADCRUMB']   = array('Add Information');
        $this->data['mode']         = 'add';
                
        if($_POST)
        {
            $posted = array();
            
			$posted["s_name"]    = $this->input->post("s_name", true);
            $posted["i_status"] = $this->input->post("i_status", true);
			
			$this->form_validation->set_rules('s_name', 'name', 'required|xss_clean|callback_chk_unique_name');
            if($this->form_validation->run() == FALSE)//invalid
            {
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {
                $posted["i_status"] = ($posted["i_status"]==1)?1:0;
                $posted["s_key"]	= make_seo_friendly_url($posted["s_name"]);
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
        
        $this->render("manage_examination/add-edit");
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
        $this->data['heading']      = "Edit Information";
        $this->data['pathtoclass']  = $this->pathtoclass;
        $this->data['BREADCRUMB']   = array('Edit Information');
        $this->data['mode']         = 'edit';
        
        redirect(base_url('web_master/manage_questions/modify_information').'/'.$i_id);        
        
        if($_POST)
        {
            $posted = array();
        
			$posted["s_name"]    = $this->input->post("s_name", true);
            $posted["i_status"] = $this->input->post("i_status", true);

            $posted["h_id"] = $this->input->post("h_id", true);
			$this->form_validation->set_rules('s_name', 'name', 'required|xss_clean|callback_chk_unique_name');
            if($this->form_validation->run() == FALSE)//invalid
            {
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {
                $posted["i_status"] = ($posted["i_status"]==1)?1:0;
                $posted["s_key"]	= make_seo_friendly_url($posted["s_name"]);
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
        
        $this->render("manage_examination/add-edit");
    }

    /***
    * Shows details of a single record.
    * 
    * @param int $i_id, Primary key
    */
    public function view_detail($i_id = 0)
    {
        
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
    
    // ajax set no of questions answer
    public function ajax_set_number_of_qa()
    {
        $response = array('red_link' =>'', 'status' =>'error');
        $exam_id = $this->input->post('exam_id', true); 
        $i_number = $this->input->post('i_number', true); 
        
        $total_question = $exam_id ? _total_question($exam_id) : "";       
        if( intval($total_question))
        {
			$this->session->unset_userdata('sess_exam_id');
			$this->session->unset_userdata('sess_no_qa');
			
			//$this->session->set_userdata('sess_exam_id', $exam_id);
			//$this->session->set_userdata('sess_no_qa', $i_number);
			if(intval($i_number) == 0)
				$red_link = base_url('web_master/manage_questions/modify_information').'/'.encrypt($exam_id);
			else
				$red_link = base_url('web_master/manage_questions/add_information').'/'.encrypt($i_number).'/'.encrypt($exam_id);
			$response['red_link']	= $red_link;
			$response['status']		= 'success';
        }
        else if(!$total_question && $i_number)
        {
			$red_link = base_url('web_master/manage_questions/add_information').'/'.encrypt($i_number).'/'.encrypt($exam_id);
			$response['red_link']	= $red_link;
			$response['status']		= 'pass_qa';
		}
        else
        {
			$red_link = base_url('web_master/manage_questions/add_information').'/'.encrypt($i_number).'/'.encrypt($exam_id);
			$response['red_link']	= $red_link;
			$response['status']		= 'no_qa';
		}
        echo json_encode($response);
    }
    
    public function chk_unique_name()
    {
        $str = $this->input->post("s_name", true);
        $h_id = $this->input->post("h_id", true);
        if($str)
        {
            $sql = "SELECT s_name FROM ".$this->tbl." WHERE s_name = '".addslashes($str)."' AND i_is_deleted=0 ";
            if(decrypt($h_id))
            {
                $sql.=" AND i_id!=".decrypt($h_id)." ";
            }
            $result = $this->db->query($sql)->result_array();
            if(!empty($result))
            {
                $this->form_validation->set_message('chk_unique_name', 'The exam name already exist');
                return FALSE;                
            }
            return $result;
        }
    }


    // ajax download pdf
    public function nap_download_qaset()
    {
        $response = array('file_path' =>'', 'status' =>'error');
        $exam_id 	= $this->input->post('pId', true);  
        $set 		= $this->input->post('set', true);  
        if( intval($exam_id))
        {
			$set =$set ? $set : "s_set1";
			$tmp = $this->acs_model->fetch_data($this->tbl,array('i_id'=>$exam_id));
			$file_exist = $tmp[0][$set];
			
			if($file_exist == '')
			{			
				$qry = "SELECT * FROM {$this->tbl_eqa} WHERE i_exam_id = '".my_receive($exam_id)."' AND i_is_deleted = 0 AND i_status = 1 ORDER BY rand() ";
				$res = $this->acs_model->exc_query($qry, TRUE);
				$this->data['qa_res'] = $res;
				$this->data['page_arr'] = $res;
				
				$set_no = str_replace('s_set','', $set);
				$new_title_set = $res[0]['i_exam_id'];
				$new_title_set = $set_no;
				if(!empty($res))
				{
					#$html = $this->load->view('web_master/dashboard/qa-pdf.php',$this->data,TRUE);	// vertical
					$html = $this->load->view('web_master/dashboard/qa-pdf-horizontal.php',$this->data,TRUE);	 // horizontal		
					$this->load->helper('tcpdf_helper');
					$data = contact_pdf_create_tcpdf($html,$filename,FALSE, $config = array('title_set'=>$new_title_set));
					//$data = pdf_create_tcpdf($html,$filename,FALSE);
					// delete old files
					
					//$del_path = $this->config->item('qa_set_up_path').'*';
					//array_map('unlink', glob($del_path));   
				
					$dyn_file_name = 'question-answer-set-'.time().'.pdf' ; // dynamic file name				
					$file = $this->config->item('qa_set_up_path').$dyn_file_name;
					
					file_put_contents($file, $data);
					$downpath = $this->config->item('qa_set_down_path');
					
					if(file_exists($file))
					{
						$up_qry = "UPDATE {$this->tbl} SET {$set} = '".$dyn_file_name."' WHERE i_id = '".my_receive($exam_id)."' ";
						$this->acs_model->exc_query($up_qry, FALSE);
					}
					
					$response['status'] = 'success';
					$response['file_path'] = $downpath.$dyn_file_name;
				}
				unset($res, $qry);
			}
			else
			{
				$downpath = $this->config->item('qa_set_down_path');
				$response['status'] = 'success';
				$response['file_path'] = $downpath.$file_exist;
			}
			
        }
        echo json_encode($response);
    }
    
    
    // ajax generate qaset as pdf
    public function nap_generate_full_qaset()
    {
        $response = array('file_path' =>'', 'status' =>'error');
        $exam_id 	= $this->input->post('pId', true);  
         
        if( intval($exam_id))
        {	
			$exam_details = $this->acs_model->fetch_data($this->tbl,array('i_id'=>$exam_id));
			$this->load->helper('tcpdf_helper');
			for($i = 1; $i <= 6 ; $i++)
			{
				$qry = "SELECT * FROM {$this->tbl_eqa} WHERE i_exam_id = '".my_receive($exam_id)."' AND i_is_deleted = 0 AND i_status = 1 ORDER BY rand() ";
				$res = $this->acs_model->exc_query($qry, TRUE);
				$this->data['page_arr'] = $res;
				$titlerArr = array('title_set' => $i);
				
				if(!empty($res))
				{
					//$html = $this->load->view('web_master/dashboard/qa-pdf.php',$this->data,TRUE);	// vertical
					$html = $this->load->view('web_master/dashboard/qa-pdf-horizontal.php',$this->data,TRUE); // horizontal	
					$data = contact_pdf_create_tcpdf($html,$filename,FALSE, $titlerArr);					
					$dyn_file_name = make_seo_friendly_url($exam_details[0]['s_name']).'-set-'.$i.'-'.time().'.pdf' ; // dynamic file name				
					$file = $this->config->item('qa_set_up_path').$dyn_file_name;
					
					file_put_contents($file, $data);
					$downpath = $this->config->item('qa_set_down_path');
					
					if(file_exists($file))
					{
						$set = 's_set'.$i;
						$up_qry = "UPDATE {$this->tbl} SET {$set} = '".$dyn_file_name."' WHERE i_id = '".my_receive($exam_id)."' ";
						$this->acs_model->exc_query($up_qry, FALSE);
						unlink($del_path = $this->config->item('qa_set_up_path').$exam_details[0][$set]);
					}
					
					$response['status'] = 'success';
					//$response['file_path'] = $downpath.$dyn_file_name;
				}
				unset($res, $qry);
			
			}	
			$response['status'] = 'success';		
			
        }
        echo json_encode($response);
    }
    
    
    
    // ajax download pdf
    public function nap_download_master_qaset()
    {
        $response = array('file_path' =>'', 'status' =>'error');
        $exam_id 	= $this->input->post('pId', true);  
         
        if( intval($exam_id))
        {	
			$qry = "SELECT * FROM {$this->tbl_eqa} WHERE i_exam_id = '".my_receive($exam_id)."' AND i_is_deleted = 0 AND i_status = 1 ORDER BY i_id ASC ";
			$res = $this->acs_model->exc_query($qry, TRUE);
			$this->data['qa_res'] = $res;
			$this->data['page_arr'] = $res;
			
			$set_no = str_replace('s_set','', $set);
			$new_title_set = $res[0]['i_exam_id'];
			$new_title_set = 'Master';
			if(!empty($res))
			{
				#$html = $this->load->view('web_master/dashboard/qa-pdf.php',$this->data,TRUE);	// vertical
				$html = $this->load->view('web_master/dashboard/qa-pdf-horizontal.php',$this->data,TRUE);	 // horizontal		
				$this->load->helper('tcpdf_helper');
				$data = contact_pdf_create_tcpdf($html,$filename,FALSE, $config = array('title_set'=>$new_title_set));
				//$data = pdf_create_tcpdf($html,$filename,FALSE);
				// delete old files
				
				//$del_path = $this->config->item('qa_set_up_path').'*';
				//array_map('unlink', glob($del_path));   
			
				$dyn_file_name = 'question-answer-set-'.time().'.pdf' ; // dynamic file name				
				$file = $this->config->item('qa_set_up_path').$dyn_file_name;
				
				file_put_contents($file, $data);
				$downpath = $this->config->item('qa_set_down_path');
				
				if(file_exists($file))
				{
					//$up_qry = "UPDATE {$this->tbl} SET {$set} = '".$dyn_file_name."' WHERE i_id = '".my_receive($exam_id)."' ";
					//$this->acs_model->exc_query($up_qry, FALSE);
				}
				
				$response['status'] = 'success';
				$response['file_path'] = $downpath.$dyn_file_name;
			}
			unset($res, $qry);
		
			
        }
        echo json_encode($response);
    }
    
    // download as zip option
    public function nap_download_zip_qaset()
    {
		$response = array('file_path' =>'', 'status' =>'error');
        $exam_id 	= $this->input->post('pId', true);  
        $set 		= $this->input->post('set', true); 
        
        $qry = "SELECT * FROM {$this->tbl} WHERE i_id = '".my_receive($exam_id)."' AND i_is_deleted = 0 AND i_status = 1 ";
		$res = $this->acs_model->exc_query($qry, TRUE);
		$files = array();
		$downpath = $this->config->item('qa_set_up_path');
		if(!empty($res))
		{				
			if($res[0]["s_set1"] )
				$files[] = $downpath.$res[0]["s_set1"] ;
			if($res[0]["s_set2"] )
				$files[] = $downpath.$res[0]["s_set2"] ;
			if($res[0]["s_set3"] )
				$files[] = $downpath.$res[0]["s_set3"] ;
			if($res[0]["s_set4"] )
				$files[] = $downpath.$res[0]["s_set4"] ;
			if($res[0]["s_set5"] )
				$files[] = $downpath.$res[0]["s_set5"] ;
			if($res[0]["s_set6"] )
				$files[] = $downpath.$res[0]["s_set6"] ;
		}
		
		if(count($files) > 0)
		{	
			$zip = new ZipArchive();
			$zipname = $downpath.time().".zip"; // Zip name
			$zip->open($zipname,  ZipArchive::CREATE);
			foreach ($files as $file) {
			  $path = $file;
			  if(file_exists($path)){
			  $zip->addFromString(basename($path),  file_get_contents($path));  
			  }
			  
			}
			$zip->close();
			
			/*header('Content-Type: application/zip');
			header('Content-disposition: attachment; filename='.$zipname);
			header('Content-Length: ' . filesize($zipname));
			readfile($zipname);*/
			$uppath = $this->config->item('qa_set_down_path').basename($zipname);
			$response = array('file_path' =>$uppath, 'status' =>'success');

		}
		echo json_encode($response);
	}

	public function __destruct(){}
}
