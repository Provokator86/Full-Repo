<?php 

/***

File Name: news.php 
Created By: SWI Dev 
Created On: September 28, 2015 
Purpose: CURD for News 

*/

class News extends MY_Controller 
{
	public $patchtoclass, $cls_msg, $tbl;
	protected $tbl_ref_use;
	public function __construct(){
		parent::__construct();
		$this->data["title"] = addslashes(t('News'));//Browser Title 
		$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
		$this->tbl = $this->db->NEWS;// Default Table
		$this->tbl_ref_use = $this->db->USER;
        $login_data = $this->session->userdata("admin_loggedin");
        $this->login_data = $login_data;
        //pr($login_data);
        if(!empty($login_data))
        {
            $log_user_id        = decrypt($login_data['user_id']);
            $log_user_role      = decrypt($login_data['user_type_id']);
            $this->user_role    = $log_user_role;
            $this->user_id      = $log_user_id;
        }
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
            $this->data['heading'] = addslashes(t("News")); //Package Name[@package] Panel Heading
            
            /*$up = FCPATH.'doc/September-30-2015/agent 092915.pdf';
            $dn = FCPATH.'doc/September-30-2015/agent 092915.html';
            $url = "https://api.cloudconvert.com/convert?apikey=gCLVeV9ff4aXpaIY1NQ7-UkmCUg-gXaInFg8yJI10Hmx3m3zB9cG2izMBlVaUDnPYAo-JeVURJA1szHvUMdpkA&input='".$up."'&download='".$dn."'&inputformat=pdf&outputformat=html";
            exec($url);*/
            
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
            $search_variable["s_title"] = ($this->input->get("h_search")?$this->input->get("s_title"):$arr_session_data["s_title"]);
            $search_variable["s_description"] = ($this->input->get("h_search")?$this->input->get("s_description"):$arr_session_data["s_description"]);
            $search_variable["s_author"] = ($this->input->get("h_search")?$this->input->get("s_author"):$arr_session_data["s_author"]);
            
            $search_variable["dt_from"]= ($this->input->get("h_search")?$this->input->get("dt_from"):$arr_session_data["dt_from"]);
            $search_variable["dt_to"]= ($this->input->get("h_search")?$this->input->get("dt_to"):$arr_session_data["dt_to"]);
            //end Getting Posted or session values for search//            
            
            $s_where = " n.e_deleted = 'No' ";
            if($s_search == "advanced")
            {
                $arr_session = array();
                $arr_session["searching_name"] = $this->data['heading'];
                if($search_variable["s_title"]!="")
                {
                    $s_where .= " AND n.s_title LIKE '%".addslashes($search_variable["s_title"])."%' ";
                }
                $arr_session["s_title"] = $search_variable["s_title"];
                $this->data["s_title"] = $search_variable["s_title"];
                
                if($search_variable["s_author"]!="")
                {
                    $s_where .= " AND n.s_author LIKE '%".addslashes($search_variable["s_author"])."%' ";
                }
                $arr_session["s_author"] = $search_variable["s_author"];
                $this->data["s_author"] = $search_variable["s_author"];
                
                if($search_variable["s_description"]!="")
                {
                    $s_where .= " AND n.s_description LIKE '%".addslashes($search_variable["s_description"])."%' ";
                }
                $arr_session["s_description"] = $search_variable["s_description"];
                $this->data["s_description"] = $search_variable["s_description"];
                
                if($search_variable["dt_from"] != '' && $search_variable["dt_to"] !='')
                {
                    $s_where .= ' AND (DATE_FORMAT(n.dt_published, "%Y-%m-%d") >="'.make_db_date($search_variable["dt_from"]).'" AND DATE_FORMAT(n.dt_published, "%Y-%m-%d") <= "'.make_db_date($search_variable["dt_to"]).'") ';
                }
                else if($search_variable["dt_from"] != '')
                    $s_where .= ' AND DATE_FORMAT(n.dt_published, "%Y-%m-%d") >="'.make_db_date($search_variable["dt_from"]).'" ';
                else if($search_variable["dt_to"] != '')
                    $s_where .= ' AND DATE_FORMAT(n.dt_published, "%Y-%m-%d") <= "'.make_db_date($search_variable["dt_to"]).'" ';
                
                
                $arr_session["dt_from"] = $search_variable["dt_from"] ;
                $arr_session["dt_to"] = $search_variable["dt_to"] ;                
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
            $arr_sort = array('0'=>'n.i_sort_order','1'=>'n.dt_added');   
            $order_by= !empty($order_by)?in_array(decrypt($order_by),$arr_sort)?decrypt($order_by):$arr_sort[0]:$arr_sort[0];
            
            $limit = $this->i_admin_page_limit;
			

            $tbl[0] = array(
                'tbl' => $this->tbl.' AS n',
                'on' =>''
            );

            $tbl[1] = array(
                'tbl' => $this->tbl_ref_use.' AS u',
                'on' => 'n.i_user_id = u.i_id'
            );
            $conf = array(
                'select' => 'n.i_id, n.i_user_id, n.s_title, n.s_description, n.s_url, n.dt_added, n.dt_updated, n.dt_published, u.s_first_name',
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
            $table_view["caption"]                 = addslashes(t("News"));
            $table_view["total_rows"]              = count($info);
            $table_view["total_db_records"]        = $total;
            $table_view["detail_view"]             = false;  // to disable show details. 
            $table_view["order_name"]              = encrypt($order_by);
            $table_view["order_by"]                = $sort_type;
            $table_view["src_action"]              = $this->pathtoclass.$this->router->fetch_method();
            
            $j = -1;
            
			$table_view["headers"][++$j]["width"] = "20%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("Title"));
			$table_view["headers"][++$j]["width"] = "40%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("Description"));
			$table_view["headers"][++$j]["width"] = "20%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("Url"));
			$table_view["headers"][++$j]["width"] = "15%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("Published"));
            //end Table Headers, with width,alignment//
            
            //Table Data//
            for($i = 0; $i< $table_view["total_rows"]; $i++)
            {
                $i_col = 0;
                $table_view["tablerows"][$i][$i_col++] = encrypt($info[$i]["i_id"]);  
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_title"];
				$table_view["tablerows"][$i][$i_col++] = string_part($info[$i]["s_description"],200);
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_url"];
                #$table_view["tablerows"][$i][$i_col++] = $info[$i]["dt_added"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["dt_published"]?admin_date($info[$i]["dt_published"]):"N/A";
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
            
			$posted["s_title"]          = $this->input->post("s_title", true);
			$posted["s_description"]    = $this->input->post("s_description");
			$posted["s_url"]            = $this->input->post("s_url", true);
			$posted["dt_added"]         = now();
            
            $posted["s_summary"]    = $this->input->post("s_summary", true);
            $posted["s_author"]     = $this->input->post("s_author", true);
            $posted["dt_published"] = $this->input->post("dt_published");
            $posted["e_status"]     = $this->input->post("e_status");
            
            $posted["i_user_id"]        = $this->user_id;
			$this->form_validation->set_rules('s_title', addslashes(t('title')), 'required|xss_clean');
			$this->form_validation->set_rules('s_description', addslashes(t('description')), 'required|xss_clean');
            if($this->form_validation->run() == FALSE)//invalid
            {
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {
                $posted["dt_published"] = $posted["dt_published"]?date("y-m-d H:i:s",strtotime($posted["dt_published"])):"";
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
        
        $this->render("news/add-edit");
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
        
			$posted["s_title"]      = $this->input->post("s_title", true);
			$posted["s_description"]= $this->input->post("s_description");
            $posted["s_url"]        = $this->input->post("s_url", true);
            $posted["s_summary"]    = $this->input->post("s_summary", true);
            $posted["s_author"]     = $this->input->post("s_author", true);
			$posted["dt_published"] = $this->input->post("dt_published");
            $posted["dt_updated"]   = now();
			$posted["e_status"]     = $this->input->post("e_status");
            
            
            $posted["h_id"]         = $this->input->post("h_id", true);
			$this->form_validation->set_rules('s_title', addslashes(t('title')), 'required|xss_clean');
			$this->form_validation->set_rules('s_description', addslashes(t('description')), 'required');
            if($this->form_validation->run() == FALSE )//invalid
            {                
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {
                $posted["dt_published"] = $posted["dt_published"]?date("y-m-d H:i:s",strtotime($posted["dt_published"])):"";
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
        
        $this->render("news/add-edit");
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
            $this->load->view('web_master/news/show_detail.tpl.php', $this->data); 
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
            echo $this->acs_model->edit_data($this->tbl, array('e_deleted'=> 'Yes'), array('i_id' => $i_id)) ? 'ok':'error';
            #echo $this->acs_model->delete_data($this->tbl, array('i_id'=>$i_id)) ? 'ok' : 'error';
            unset($i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	
    // change sorting order
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