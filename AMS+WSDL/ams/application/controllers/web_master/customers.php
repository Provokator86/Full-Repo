<?php 
/***
File Name: customers.php 
Created By: SWI Dev 
Created On: June 6, 2016 
Purpose: CURD for customers
*/

class Customers extends MY_Controller 
{
	public $patchtoclass, $cls_msg, $tbl;
	protected $tbl_ref_use;
	public function __construct(){
		parent::__construct();
		$this->data["title"] 	= addslashes(t('Manage Customers'));//Browser Title 
		$this->pathtoclass 		= admin_base_url().$this->router->fetch_class()."/";
		$this->tbl 				= $this->db->USER;// Default Table
		//$this->tbl_master 		= $this->db->FORM_MASTER;
		
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
        $this->conf=&get_config();
	}

	//Default method (index)
	public function index()
	{
		redirect($this->pathtoclass.'show_list?h_search=');
	}

    /****
    * Display the list of records 
    */
    public function show_list($order_by = '', $sort_type = 'asc',$start = NULL, $limit = NULL)
    {
        try
        {			
			
            $this->data['heading'] = addslashes(t("Manage Customers")); //Package Name[@package] Panel Heading           
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
            $search_variable["s_name"] 	= ($this->input->get("h_search")?$this->input->get("s_name"):$arr_session_data["s_name"]);            
            $search_variable["s_company_name"] 	= ($this->input->get("h_search")?$this->input->get("s_company_name"):$arr_session_data["s_company_name"]);            
            $search_variable["s_email"] 	= ($this->input->get("h_search")?$this->input->get("s_email"):$arr_session_data["s_email"]);            
            $search_variable["dt_from"]		= ($this->input->get("h_search")?$this->input->get("dt_from"):$arr_session_data["dt_from"]);
            $search_variable["dt_to"]		= ($this->input->get("h_search")?$this->input->get("dt_to"):$arr_session_data["dt_to"]);
            //end Getting Posted or session values for search//            
            
            //$s_where = " n.i_id>1 ";
            $s_where = " n.i_user_type IN(5) ";
            if($s_search == "advanced")
            {
                $arr_session = array();
                //$arr_session["searching_name"] = $this->data['heading'];
                $search_variable["searching_name"] = $this->data['heading'];
                if($search_variable["s_company_name"]!="")
                {
                    $s_where .= " AND n.s_company_name LIKE '%".addslashes($search_variable["s_company_name"])."%' ";
                } 
                if($search_variable["s_email"]!="")
                {
                    $s_where .= " AND n.s_email LIKE '%".addslashes($search_variable["s_email"])."%' ";
                }
                if($search_variable["s_name"]!="")
                {
                    $s_where .= " AND ( CONCAT(n.s_first_name,' ', n.s_last_name) LIKE '%".addslashes($search_variable["s_name"])."%' OR n.s_email LIKE '%".addslashes($search_variable["s_name"])."%') ";
                }
                
                if($search_variable["dt_from"] != '' && $search_variable["dt_to"] !='')
                {
                    $s_where .= ' AND (DATE_FORMAT(n.dt_created_on, "%Y-%m-%d") >="'.make_db_date($search_variable["dt_from"]).'" AND DATE_FORMAT(n.dt_created_on, "%Y-%m-%d") <= "'.make_db_date($search_variable["dt_to"]).'") ';
                }
                else if($search_variable["dt_from"] != '')
                    $s_where .= ' AND DATE_FORMAT(n.dt_created_on, "%Y-%m-%d") >="'.make_db_date($search_variable["dt_from"]).'" ';
                else if($search_variable["dt_to"] != '')
                    $s_where .= ' AND DATE_FORMAT(n.dt_created_on, "%Y-%m-%d") <= "'.make_db_date($search_variable["dt_to"]).'" ';
                
                if(!empty($search_variable))
                {
                    foreach($search_variable as $k=>$v)
                        $this->data[$k] = $v;
                }
                $this->session->set_userdata("arr_session",$search_variable);
                $this->session->set_userdata("h_search",$s_search);
                $this->data["h_search"] = $s_search;                 
                                          
            }      
            else //List all records, **not done
            {
                //Releasing search values from session//
                $this->session->unset_userdata("arr_session");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"] 	= $s_search;
                $this->data["arr_session"] 	= '';                        
                $this->data["dt_from"]     	= "";                            
                $this->data["dt_to"]     	= "";                            
                //end Storing search values into session//                 
            }
            
            unset($s_search,$arr_session,$search_variable);
              
            //Setting Limits, If searched then start from 0//
            $i_uri_seg = 6;
            $start = $this->input->get("h_search") ? 0 : $this->uri->segment($i_uri_seg);
            //end generating search query//
            
            // List of fields for sorting
            $arr_sort = array('0'=>'n.dt_created_on');   
            $order_by= !empty($order_by)?in_array(decrypt($order_by),$arr_sort)?decrypt($order_by):$arr_sort[0]:$arr_sort[0];
            $limit = $this->i_admin_page_limit;	
            
            $info = $this->acs_model->fetch_data( $this->tbl.' AS n', $s_where,'', $start, $limit, $order_by, $sort_type);
            $total =  $this->acs_model->count_info($this->tbl.' AS n', $s_where );
                  
            //Creating List view for displaying//
            $table_view = array();  
            
            //Table Headers, with width,alignment//
            $table_view["caption"]                 = addslashes(t("Manage Customers"));
            $table_view["total_rows"]              = count($info);
            $table_view["total_db_records"]        = $total;
            $table_view["detail_view"]             = false;  // to disable show details. 
            $table_view["order_name"]              = encrypt($order_by);
            $table_view["order_by"]                = $sort_type;
            $table_view["src_action"]              = $this->pathtoclass.$this->router->fetch_method();
            
            $j = -1;
            
			$table_view["headers"][++$j]["width"] 	= "25%";
			$table_view["headers"][$j]["align"] 	= "left";
			$table_view["headers"][$j]["val"] 		= addslashes(t("Name"));
			
			$table_view["headers"][++$j]["width"] 	= "25%";
			$table_view["headers"][$j]["align"] 	= "left";
			$table_view["headers"][$j]["val"] 		= addslashes(t("Email"));
			
			$table_view["headers"][++$j]["width"] 	= "25%";
			$table_view["headers"][$j]["align"] 	= "left";
			$table_view["headers"][$j]["val"] 		= addslashes(t("Company Name"));
						
			$table_view["headers"][++$j]["width"] 	= "25%";
			$table_view["headers"][$j]["align"] 	= "left";
			$table_view["headers"][$j]["val"] 		= addslashes(t("Company FEIN"));
			
            //end Table Headers, with width,alignment//
            
            //Table Data//
            for($i = 0; $i< $table_view["total_rows"]; $i++)
            {
                $i_col = 0;
                $table_view["tablerows"][$i][$i_col++] = encrypt($info[$i]["i_id"]);  
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_first_name"].' '.$info[$i]["s_last_name"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_email"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_company_name"].'</br>Address: '.$info[$i]["s_company_address"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_company_fein_number"];
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
			$posted["s_payer_tin"]        						= trim($this->input->post("s_payer_tin", true));
			$posted["s_first_payer_name_line"]        			= trim($this->input->post("s_first_payer_name_line", true));
			$posted["s_second_payer_name_line"]        			= trim($this->input->post("s_second_payer_name_line", true));
			$posted["s_payer_shipping_address"]        			= trim($this->input->post("s_payer_shipping_address", true));
			$posted["s_payer_city"]        						= trim($this->input->post("s_payer_city", true));
			$posted["s_payer_state"]        					= trim($this->input->post("s_payer_state", true));
			$posted["s_payer_zip_code"]        					= trim($this->input->post("s_payer_zip_code", true));
			$posted["s_payers_telephone_number_and_extension"]	= trim($this->input->post("s_payers_telephone_number_and_extension", true));
			
            
			$this->form_validation->set_rules('s_payer_tin', addslashes(t('payer TIN')), 'required|xss_clean');
			$this->form_validation->set_rules('s_first_payer_name_line', addslashes(t('first name')), 'required|xss_clean');
			$this->form_validation->set_rules('s_payer_shipping_address', addslashes(t('shipping address')), 'required|xss_clean');
			$this->form_validation->set_rules('s_payer_city', addslashes(t('city')), 'required|xss_clean');
			$this->form_validation->set_rules('s_payer_state', addslashes(t('state')), 'required|xss_clean');
			$this->form_validation->set_rules('s_payer_zip_code', addslashes(t('zip code')), 'required|xss_clean');
			
            if($this->form_validation->run() == FALSE)//invalid
            {
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {
                $posted["dt_created"] = now();
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
        
        $this->render("payer_record/add-edit");
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
            $posted = $_POST;
            $posted["h_id"] = $this->input->post("h_id", true);						
            
			$this->form_validation->set_rules('s_first_name', addslashes(t('first name')), 'required|xss_clean');
			$this->form_validation->set_rules('s_last_name', addslashes(t('last name')), 'required|xss_clean');
			//$this->form_validation->set_rules('s_email', addslashes(t('email')), 'required|xss_clean|valid_email|is_unique['.$this->tbl.'.s_email.i_id.'.decrypt($posted["h_id"]).']');
			$this->form_validation->set_rules('s_email', addslashes(t('email')), 'required|xss_clean|valid_email');
			$this->form_validation->set_rules('s_company_name', addslashes(t('company name')), 'required|xss_clean');
			$this->form_validation->set_rules('s_company_fein_number', addslashes(t('FEIN number')), 'required|xss_clean');
			
            if($this->form_validation->run() == FALSE)//invalid
            {
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {                
                $i_id = decrypt($posted["h_id"]);
                $h_user_name = $posted["h_user_name"];
                unset($posted["h_id"], $posted["h_user_name"]);
                $posted["s_user_name"] = $posted['s_email'];
                $posted["s_customer_name"] = trim($posted['s_first_name'].' '.$posted['s_last_name']);
                
                $mailSend = false;
                $prev_info = $this->acs_model->fetch_data($this->tbl,array('i_id'=>$i_id));
                //if($prev_info[0]["s_email"] != $posted["s_email"])
                
                if($posted['generate_password'] == 'generate_password') // Added on 06 June 2017 by SWI Dev
                {
					$mailSend = true;
					$org_pass = generate_password(10);
					$posted["s_password"] = md5($org_pass.$this->conf["security_salt"]);	
				}	
				unset($posted['generate_password']);			
                //pr($posted,1);
                $i_aff = $this->acs_model->edit_data($this->tbl,$posted, array('i_id'=>$i_id));
                
                if($i_aff)//saved successfully
                {                    
					$oauthArr = array();
					$oauthArr['s_username']	= $posted["s_user_name"];
					$oauthArr['s_password']	= $posted["s_password"];
					$oauthArr['s_email'] 	= $posted["s_email"];
					
					// send mail		
					if($mailSend)// set above
					{	
						$s_where = " s_key='forgot' ";
						$content  = $this->acs_model->fetch_data($this->db->EMAIL_TEMPLATE,$s_where);
						$info     = $content[0];
						$filename = $this->config->item('EMAILBODYHTML')."common.html";
						$handle   = @fopen($filename, "r");
						$mail_html= @fread($handle, filesize($filename));

						if(!empty($info))
						{                            
							$description = $info["s_content"];
							$description = str_replace("##EMAIL##",$posted["s_email"],$description);   
							$description = str_replace("##PASSWORD##",$org_pass,$description); 
							$description = str_replace("##SITE_URL##",admin_base_url(),$description); 
						}
						//unset($info);
						//echo "<br>DESC".$description;    exit;
						$mail_html = str_replace("##SITE_URL##",base_url(),$mail_html);    
						$mail_html = str_replace("##MAIL_BODY##",$description,$mail_html);
						//echo "<br>DESC".$mail_html;    exit;
						
						$email = $posted["s_email"];
						//$email = 'mmondal@codeuridea.com';
						//$email = 'mrinsss@gmail.com';
						//echo $email;
						$i_sent =sendEmail($email,"Your information details have been changed",$mail_html,$this->s_admin_email);					
						// send mail
					}
					
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
            $posted 				= $tmp[0];
            $posted['h_id'] 		= $i_id;
            $this->data['posted'] 	= $posted;
            $posted['h_mode'] 		= $this->data['mode'];
        }
        
        $this->render("customers/add-edit");
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
            if($i_id)
            echo $this->acs_model->edit_data($this->tbl, array('i_status'=> '2'), array('i_id' => $i_id)) ? 'ok':'error';
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
