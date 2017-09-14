<?php 
/***
File Name: manage_forms.php 
Created By: SWI Dev 
Created On: June 6, 2016 
Purpose: CURD for manage_forms 
*/

class Manage_forms extends MY_Controller 
{
	public $patchtoclass, $cls_msg, $tbl;
	protected $tbl_ref_use;
	public function __construct(){
		parent::__construct();
		$this->data["title"] 	= addslashes(t('Manage Forms'));//Browser Title 
		$this->pathtoclass 		= admin_base_url().$this->router->fetch_class()."/";
		$this->tbl 				= $this->db->FORM_MASTER;// Default Table
		$this->tbl_ref_use 		= $this->db->USER;
		$this->tbl_amt_codes	= $this->db->AMOUNT_CODES;
        $login_data 			= $this->session->userdata("admin_loggedin");
        $this->login_data 		= $login_data;
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
    public function show_list($order_by = '', $sort_type = 'DESC',$start = NULL, $limit = NULL)
    {
        try
        {
            $this->data['heading'] = addslashes(t("Forms")); //Package Name[@package] Panel Heading
            $this->session->unset_userdata('sess_form_id');
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
            $search_variable["s_form_title"] = ($this->input->get("h_search")?$this->input->get("s_form_title"):$arr_session_data["s_form_title"]);
                        
            $search_variable["dt_from"]= ($this->input->get("h_search")?$this->input->get("dt_from"):$arr_session_data["dt_from"]);
            $search_variable["dt_to"]= ($this->input->get("h_search")?$this->input->get("dt_to"):$arr_session_data["dt_to"]);
            //end Getting Posted or session values for search//            
            
            $s_where = " n.i_status != 2 ";
            if($s_search == "advanced")
            {
                $arr_session = array();
                //$arr_session["searching_name"] = $this->data['heading'];
                $search_variable["searching_name"] = $this->data['heading'];
                
                if($search_variable["s_form_title"]!="")
                {
                    $s_where .= " AND n.s_form_title LIKE '%".addslashes($search_variable["s_form_title"])."%' ";
                }              
                if($search_variable["dt_from"] != '' && $search_variable["dt_to"] !='')
                {
                    $s_where .= ' AND (DATE_FORMAT(n.dt_add, "%Y-%m-%d") >="'.make_db_date($search_variable["dt_from"]).'" AND DATE_FORMAT(n.dt_add, "%Y-%m-%d") <= "'.make_db_date($search_variable["dt_to"]).'") ';
                }
                else if($search_variable["dt_from"] != '')
                    $s_where .= ' AND DATE_FORMAT(n.dt_add, "%Y-%m-%d") >="'.make_db_date($search_variable["dt_from"]).'" ';
                else if($search_variable["dt_to"] != '')
                    $s_where .= ' AND DATE_FORMAT(n.dt_add, "%Y-%m-%d") <= "'.make_db_date($search_variable["dt_to"]).'" ';
                
                
                if(!empty($search_variable))
                {
                    foreach($search_variable as $k=>$v)
                        $this->data[$k] = $v;
                }                
                
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
            $arr_sort = array('0'=>'n.s_form_title','1'=>'n.dt_add');   
            $order_by= !empty($order_by)?in_array(decrypt($order_by),$arr_sort)?decrypt($order_by):$arr_sort[0]:$arr_sort[0];
            
            $limit = $this->i_admin_page_limit = 50; // 50 for this page only           
            $info = $this->acs_model->fetch_data( $this->tbl.' AS n', $s_where,'', $start, $limit, $order_by, $sort_type);
            $total =  $this->acs_model->count_info($this->tbl.' AS n', $s_where );
            
                  
            //Creating List view for displaying//
            $table_view = array();  
            
            //Table Headers, with width,alignment//
            $table_view["caption"]                 = addslashes(t("Forms"));
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
			$table_view["headers"][$j]["val"] = addslashes(t("Amount Codes"));
			
			$table_view["headers"][++$j]["width"] = "15%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("Date"));
            //end Table Headers, with width,alignment//
            
            //Table Data//
            for($i = 0; $i< $table_view["total_rows"]; $i++)
            {
                $i_col = 0;
                $table_view["tablerows"][$i][$i_col++] = encrypt($info[$i]["i_id"]);  
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_form_title"];
				$table_view["tablerows"][$i][$i_col++] = string_part($info[$i]["s_form_description"],200);
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_amount_codes"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["dt_add"]?admin_date($info[$i]["dt_add"]):"N/A";
				
				/*$action='';
                #pr($this->data['action_allowed']); // for team list
				$det_url = admin_base_url().'manage_forms/view_detail/'.$info[$i]["i_id"];
				$action .='<a id="form_det_'.$i.'" data-id="'.$info[$i]["i_id"].'" href="'.$det_url.'" data-placement="bottom" title="Details" class="fa fa-search-plus" data-original-title="Details"></a> ';
                  
                $table_view["rows_action"][$i] = $action;*/
				
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
            
			$posted["s_form_title"]         = trim($this->input->post("s_form_title", true));
			$posted["s_form_description"]   = trim($this->input->post("s_form_description"));			
			$posted["d_form_price"]   		= trim($this->input->post("d_form_price"));			
			$posted["dt_add"]         		= now();	      
			     
            $amount_codes					= trim($this->input->post("amount_codes"));
            $amount_codes_arr = explode(',',$amount_codes);
            if(!empty($amount_codes_arr))
				$amount_codes_arr = array_values(array_unique($amount_codes_arr, SORT_REGULAR));
           
			$this->form_validation->set_rules('s_form_title', addslashes(t('title')), 'required|xss_clean');
			//$this->form_validation->set_rules('s_description', addslashes(t('description')), 'required|xss_clean');
            if($this->form_validation->run() == FALSE)//invalid
            {
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {                
                $i_newid = $this->acs_model->add_data($this->tbl, $posted);
                if($i_newid)//saved successfully
                {
					// now update with amount codes
					if(!empty($amount_codes_arr))         
					{
						$amount_codes_str = '';
						$this->acs_model->delete_data($this->tbl_amt_codes, array('s_form_id'=>$i_newid));
						foreach($amount_codes_arr as $val)
						{
							$amt_code_arr = array();
							if(intval(trim($val))>0)
							{
								$amount_codes_str .= $val.',';
								$amt_code_arr["s_amount_codes"] = trim($val);
								$amt_code_arr["s_form_id"] 		= $i_newid;
								$this->acs_model->add_data($this->tbl_amt_codes, $amt_code_arr);
							}
						}
						
						$amount_codes_str = trim($amount_codes_str,',');
						if($amount_codes_str!='') // update form table
							$this->acs_model->edit_data($this->tbl,array('s_amount_codes'=>$amount_codes_str), array('i_id'=>$i_newid));
							
					}
					// end update with amount codes
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
        
        $this->render("manage_forms/add-edit");
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
        
			$posted["s_form_title"]         = trim($this->input->post("s_form_title", true));
			$posted["s_form_description"]   = trim($this->input->post("s_form_description"));	           
            $amount_codes					= trim($this->input->post("amount_codes"));			
			$posted["d_form_price"]   		= trim($this->input->post("d_form_price"));			
            //$amount_codes_arr = explode(',',$amount_codes);
            //if(!empty($amount_codes_arr))
				//$amount_codes_arr = array_values(array_unique($amount_codes_arr, SORT_REGULAR));
            $amount_codes_arr = str_split($amount_codes);
           
            $posted["h_id"]         		= $this->input->post("h_id", true);
			$this->form_validation->set_rules('s_form_title', addslashes(t('title')), 'required|xss_clean');
			//$this->form_validation->set_rules('s_description', addslashes(t('description')), 'required');
            if($this->form_validation->run() == FALSE )//invalid
            {                
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
					// now update with amount codes
					if(!empty($amount_codes_arr))         
					{
						$amount_codes_str = '';
						$this->acs_model->delete_data($this->tbl_amt_codes, array('s_form_id'=>$i_id));
						foreach($amount_codes_arr as $val)
						{
							$amt_code_arr = array();
							if($val)
							{
								$amount_codes_str .= $val.',';
								$amt_code_arr["s_amount_codes"] = $val;
								$amt_code_arr["s_form_id"] 		= $i_id;
								$this->acs_model->add_data($this->tbl_amt_codes, $amt_code_arr);
							}
						}
						
						$amount_codes_str = trim($amount_codes_str,',');
						if($amount_codes!='') // update form table
							$this->acs_model->edit_data($this->tbl,array('s_amount_codes'=>$amount_codes), array('i_id'=>$i_id));
							
					}
					// end update with amount codes
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
        
        $this->render("manage_forms/add-edit");
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
                //$this->data["info"] = $this->acs_model->fetch_data($this->tbl,array('i_id'=>$i_id));
                $this->session->unset_userdata('sess_form_id');
                $this->session->set_userdata('sess_form_id',$i_id);
                redirect(base_url().'web_master/form_details/show_list');
            }
            //$this->load->view('web_master/manage_forms/show_detail.tpl.php', $this->data); 
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }

    
    
    public function form_details($i_id = 0)
    {
        try
        {
            if(!empty($i_id))
            {
                //$this->data["info"] = $this->acs_model->fetch_data($this->tbl,array('i_id'=>$i_id));
                $this->session->unset_userdata('sess_form_id');
                $this->session->set_userdata('sess_form_id',$i_id);
                redirect(base_url().'web_master/form_details/show_list');
            }
            //$this->load->view('web_master/manage_forms/form_details.tpl.php', $this->data); 
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

	
	/*
	 * generate text file
	 * */
	
    public function nap_generate_txt($s_id = '')
    {
        try
        {
			$t_info = $this->acs_model->fetch_data($this->db->SITESETTING, array('i_id'=>1));		
			$a_info = $this->acs_model->fetch_data($this->db->PAYER_INFO,'','');	
			$b_info = $this->acs_model->fetch_data($this->db->PAYEE_INFO,'','');	
			//pr($b_info,1);	
			//echo addZeroLeft('',12);
			// FORM 1099A
			if($s_id=='1099A')
			{
				//$org_name = '1099A-SW-'.time().'-form.txt';
				$org_name = '1099A-SW-efile.txt';
				$file = $this->config->item('TEXTFILEAMS').$org_name;
				
				$myfile = fopen($file, "w") or die("Unable to open file!");
				fclose($myfile);
				$content = ''; //New
				
				// *************************** START TRANSMITTER (T) RECORD  ********************** //
				$content .= 'T2015';
				//Prior Year Data Indicator. Required. Enter “P” only if reporting prior year data; otherwise, enter a blank. 
				//Do not enter a “P” if the tax year is 2015.
				$content .= add_blank_space(1);				
						
				//Transmitters TIN
				$content .= pad_blank_space($t_info[0]["s_tin"],9);
				$content .= pad_blank_space($t_info[0]["s_tcc"],5);
				$content .= add_blank_space(7);
				//Test File Indicator T->Foreign else balnk
				$content .= add_blank_space(1);
				//Foreign Entity Indicator
				$content .= add_blank_space(1);
				//Transmitter Name
				$content .= pad_blank_space($t_info[0]["s_tm_name"],40);
				$content .= pad_blank_space($t_info[0]["s_tm_name_cont"],40);
				//Company Name
				$content .= pad_blank_space($t_info[0]["s_company_name"],40);
				$content .= pad_blank_space($t_info[0]["s_company_name_cont"],40);
				//Company Mailing Address
				$content .= pad_blank_space($t_info[0]["s_company_address"],40);
				//Company City
				$content .= pad_blank_space($t_info[0]["s_company_city"],40);
				//Company State
				$content .= pad_blank_space($t_info[0]["s_company_state"],2);
				//Company ZIP Code
				$content .= pad_blank_space($t_info[0]["s_company_zip"],9);
				$content .= add_blank_space(15);
				//Total Number of Payees 
				$content .= addZeroLeft(3,8);
				//Contact Name
				$content .= pad_blank_space($t_info[0]["s_contact_name"],40);
				//Contact Telephone Number & Extension
				$phn = str_replace("-","",$t_info[0]["s_contact_number"]);
				$content .= pad_blank_space($phn,15);
				//Contact Email Address
				$content .= pad_blank_space($t_info[0]["s_contact_email"],50);
				$content .= add_blank_space(91);
				//Record Sequence Number For T record starts from 1 And then increased for Payer record and payee record
				$record_seq_no = addZeroLeft(1,8);
				$content .= $record_seq_no;
				$content .= add_blank_space(10);
				//Vendor Indicator
				$content .= 'V';
				//Vendor Name
				$content .= pad_blank_space($t_info[0]["s_vendor_name"],40);
				//Vendor Mailing Address (need to discuss with sir)
				$content .= pad_blank_space($t_info[0]["s_vendor_address"],40);
				//Vendor City
				$content .= pad_blank_space($t_info[0]["s_vendor_city"],40);
				//Vendor State
				$content .= pad_blank_space($t_info[0]["s_vendor_state"],2);
				//Vendor ZIP Code
				$content .= pad_blank_space($t_info[0]["s_vendor_zip"],9);
				//Vendor Contact Name
				$content .= pad_blank_space($t_info[0]["s_vendor_contact_name"],40);
				//Contact Telephone Number & Extension
				$phn = str_replace("-","",$t_info[0]["s_vendor_contact_number"]);
				$content .= pad_blank_space($phn,15);
				
				$content .= add_blank_space(35);
				//Vendor Foreign Entity Indicator
				$content .= add_blank_space(1);
				$content .= add_blank_space(8);
				$content .= "\r";
				//$content .= add_blank_space(2);
				// ********************** END TRANSMITTER (T) RECORD  ********************** //
				
				// *************************** START PAYER (A) RECORD  ********************** //
				$content .= 'A2015';
				//Combined Federal / State Filing Program
				$content .= add_blank_space(1);
				$content .= add_blank_space(5);
				//Payers Taxpayer Identification Number (TIN)
				$content .= pad_blank_space($a_info[0]["s_payer_tin"],9);
				//Payer Name Control
				$content .= add_blank_space(4);
				//Last Filing Indicator (need to discuss with sir)
				$content .= add_blank_space(1);
				//Type of Return
				$content .= pad_blank_space(4,2);
				//Amount Codes 
				$amount_codes = $a_info[0]["s_amount_codes"]?$a_info[0]["s_vendor_contact_name"]:"24";
				$content .= pad_blank_space($amount_codes,16);
				$content .= add_blank_space(8);
				//Foreign Entity Indicator
				$content .= add_blank_space(1);
				//First Payer Name Line
				$content .= pad_blank_space($a_info[0]["s_first_payer_name_line"],40);
				//Second Payer Name Line
				$content .= pad_blank_space($a_info[0]["s_second_payer_name_line"],40);
				//Transfer Agent Indicator
				$content .= pad_blank_space('0',1);
				//Payer Shipping Address
				$content .= pad_blank_space($a_info[0]["s_payer_shipping_address"],40);
				//Payer City
				$content .= pad_blank_space($a_info[0]["s_payer_city"],40);
				//Payer State
				$content .= pad_blank_space($a_info[0]["s_payer_state"],2);
				//Payer Zip Code
				$content .= pad_blank_space($a_info[0]["s_payer_zip_code"],9);
				//Payers Telephone Number and Extension
				$phn = str_replace("-","",$a_info[0]["s_payers_telephone_number_and_extension"]);
				$content .= pad_blank_space($phn,15);
				$content .= add_blank_space(260);
				//Record Sequence Number
				$record_seq_no = addZeroLeft(($record_seq_no+1),8);
				$content .=$record_seq_no;
				$content .= add_blank_space(241);
				$content .= "\r";
				//$content .= add_blank_space(2);
				// *************************** END PAYER (A) RECORD  ********************** //
				
				// *************************** START PAYEE (B) RECORD  ********************** //
				if(!empty($b_info))
				{
					foreach($b_info as $val)
					{
						$content .= 'B2015';
						//Corrected Return Indicator (See Note.)
						$content .= add_blank_space(1);
						// Name Control
						$namec = $val["s_last_payee_name_line"]?substr($val["s_last_payee_name_line"],0,4):"";
						$content .= pad_blank_space($namec,4);
						//Type of TIN
						$content .= pad_blank_space($val["s_type_of_tin"],1);
						// Payees Taxpayer Identification Number (TIN)
						$content .= pad_blank_space($val["s_payee_tin"],9);
						// Payers Account Number For Payee
						$content .= pad_blank_space($val["s_payer_account_number"],20);
						//Payers Office Code
						$content .= pad_blank_space($val["s_payer_office_code"],4);
						$content .= add_blank_space(10);
						// payemtn amount need to discuss with sir
						$content .= addZeroLeft($val["s_payment_amount1"],12);
						$content .= addZeroLeft($val["s_payment_amount2"],12);
						$content .= addZeroLeft($val["s_payment_amount3"],12);
						$content .= addZeroLeft($val["s_payment_amount4"],12);
						$content .= addZeroLeft($val["s_payment_amount5"],12);
						$content .= addZeroLeft($val["s_payment_amount6"],12);
						$content .= addZeroLeft($val["s_payment_amount7"],12);
						$content .= addZeroLeft($val["s_payment_amount8"],12);
						$content .= addZeroLeft($val["s_payment_amount9"],12);
						$content .= addZeroLeft($val["s_payment_amount10"],12);
						$content .= addZeroLeft($val["s_payment_amount11"],12);
						$content .= addZeroLeft($val["s_payment_amount12"],12);
						$content .= addZeroLeft($val["s_payment_amount13"],12);
						$content .= addZeroLeft($val["s_payment_amount14"],12);
						$content .= addZeroLeft($val["s_payment_amount15"],12);
						$content .= addZeroLeft($val["s_payment_amount16"],12);
						
						//Foreign Country Indicator
						$content .= add_blank_space(1);
						//First Payee Name Line
						$fullname = $val["s_first_payee_name_line"].($val["s_last_payee_name_line"]?' '.$val["s_last_payee_name_line"]:"");
						$content .= pad_blank_space($fullname,40);
						//Second Payee Name Line
						$content .= pad_blank_space($val["s_second_payee_name_line"],40);
						$content .= add_blank_space(40);
						//Payee Mailing Address
						$content .= pad_blank_space($val["s_payee_shipping_address"],40);
						$content .= add_blank_space(40);
						//Payee City
						$content .= pad_blank_space($val["s_payee_city"],40);
						//Payee State
						$content .= pad_blank_space($val["s_payee_state"],2);
						//Payee ZIP Code
						$content .= pad_blank_space($val["s_payee_zip_code"],9);
						$content .= add_blank_space(1);
						//Record Sequence Number
						$record_seq_no = addZeroLeft(($record_seq_no+1),8);
						$content .=$record_seq_no;
						$content .= add_blank_space(36);
						
						// for 544-750 go to page no 74
						$content .= add_blank_space(3);
						//Personal Liability Indicator
						$content .= pad_blank_space($val["s_personal_liability"],1);
						//Date of Lenders Acquisition or Knowledge of Abandonment
						$date = $val["dt_lender_aquisition"]?date("Ymd",strtotime($val["dt_lender_aquisition"])):"";
						$content .= pad_blank_space($date,8);
						//Description of Property
						$content .= pad_blank_space($val["s_description_property"],39);
						$content .= add_blank_space(68);
						//Special Data Entries
						$content .= pad_blank_space($val["s_special_data"],60);
						$content .= add_blank_space(26);
						$content .= "\r";
						
					}
				}
				
				// *************************** END PAYEE (B) RECORD  ********************** //
				
				
				// *************************** END OF PAYER (C) RECORD START  ********************** //
				$content .= 'C';
				$tot_payee = count($b_info);
				$content .= addZeroLeft($tot_payee,8);
				$content .= add_blank_space(6);
				
				// control total. please calculate later page 110 in pdf				
				$content .=addZeroLeft(0,18);
				$content .=addZeroLeft(0,18);
				$content .=addZeroLeft(0,18);
				$content .=addZeroLeft(0,18);
				$content .=addZeroLeft(0,18);
				$content .=addZeroLeft(0,18);
				$content .=addZeroLeft(0,18);
				$content .=addZeroLeft(0,18);
				$content .=addZeroLeft(0,18);
				$content .=addZeroLeft(0,18);
				$content .=addZeroLeft(0,18);
				$content .=addZeroLeft(0,18);
				$content .=addZeroLeft(0,18);
				$content .=addZeroLeft(0,18);
				$content .=addZeroLeft(0,18);
				$content .=addZeroLeft(0,18);
				
				
				$content .= add_blank_space(196);
				//Record Sequence Number				
				$record_seq_no = addZeroLeft(($record_seq_no+1),8);
				$content .=$record_seq_no;
				
				$content .= add_blank_space(241);
				$content .= "\r";
				// *************************** END OF PAYER (C) RECORD END  ********************** //
				
				
				// *************************** END OF TANSMITTER (F) RECORD START  ********************** //
				$content .= 'F';
				//Number of “A” Records
				$tot_payer = 1;
				$content .= addZeroLeft($tot_payer,8);
				//Zero
				$content .= addZeroLeft(0,21);
				$content .= add_blank_space(19);
				//Total Number of Payees
				$tot_payee = count($b_info);
				$content .= addZeroLeft($tot_payee,8);
				$content .= add_blank_space(442);
				//Record Sequence Number				
				$record_seq_no = addZeroLeft(($record_seq_no+1),8);
				$content .=$record_seq_no;
				
				$content .= add_blank_space(241);
				$content .= "\r";
				// *************************** END OF TANSMITTER (F) RECORD END  ********************** //
				
				$content = file_put_contents($file, $content);
				
				// for force download
				/*header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename($org_name));
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file));
				readfile($file);
				exit;*/

			}
        
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }

	
	public function __destruct(){}
}
