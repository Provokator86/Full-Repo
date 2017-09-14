<?php
/*********
* Author: ACS
* Date  : 31 March 2014 
* Purpose:
*  Controller For Manage user
* 
* @package General
* @subpackage Manage user
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/manage_user_model.php
* @link views/admin/Manage_user/
*/

class Manage_user extends MY_Controller
{
    public $cls_msg;//All defined error messages. 
    public $pathtoclass, $tbl, $user_type;  
	public $allowedExt, $uploaddir, $thumbdir, $showImgDir, $thumbHeight, $thumbWidth;
	 
    public function __construct()
    {            
        try
        {
			parent::__construct();
			$this->data['title'] = addslashes(t("Manage User"));//Browser Title
			
			//Define Errors Here//
			$this->cls_msg = array();
			$this->cls_msg["no_result"]			= get_message('no_result');
			$this->cls_msg["save_failed"]		= get_message('save_failed');
			$this->cls_msg["save_success"]		= get_message('save_success');
			$this->cls_msg["del_failed"]		= get_message('del_failed');
			$this->cls_msg["del_success"]		= get_message('del_success');
			
			//end Define Errors Here//
			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
			
			// loading default model here //
			$this->load->model("manage_user_model","mod_rect");
			// end loading default model here //
			
			//$this->tbl = $this->db->EMPLOYEE;
			$this->tbl = $this->db->USER;
			$this->user_type = $this->mod_rect->fetch_all_user_type();
			$this->data['user_type'] = $this->user_type;
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
			$this->data['heading'] = addslashes(t("Manage User"));//Package Name[@package] Panel Heading
			
			//generating search query//
			$arr_session_data    =    $this->session->userdata("arr_session");
			if($arr_session_data['searching_name'] != $this->data['heading'])
			{
				$this->session->unset_userdata("arr_session");
				$arr_session_data   =   array();
			}
			$search_variable     =    array();
			
			//Getting Posted or session values for search//        
			$s_search 	=(isset($_GET["h_search"])?$this->input->get("h_search"):$this->session->userdata("h_search"));
			$search_variable["s_first_name"] = ($this->input->get("h_search")?$this->input->get("s_first_name"):$arr_session_data["s_first_name"]);
			$search_variable["s_last_name"] = ($this->input->get("h_search")?$this->input->get("s_last_name"):$arr_session_data["s_last_name"]);
			$search_variable["s_email"] = ($this->input->get("h_search")?$this->input->get("s_email"):$arr_session_data["s_email"]);	
			$search_variable["i_user_type"] = ($this->input->get("h_search")?$this->input->get("i_user_type"):$arr_session_data["i_user_type"]);	
			//end Getting Posted or session values for search//            
			//$s_where = " i_id > 1 "; // id 1 is reserve for Super Admin
			$s_where = " WHERE u.i_user_type IN(2,3,4) "; // id 1 is reserve for Super Admin
			
			if($s_search == "advanced")
			{				
				if($search_variable["s_first_name"]!="")
				{
					$s_where .= " AND s_first_name LIKE '%".addslashes($search_variable["s_first_name"])."%' ";
				}if($search_variable["s_last_name"]!="")
				{
					$s_where .= " AND s_last_name LIKE '%".addslashes($search_variable["s_last_name"])."%' ";
				}if($search_variable["s_email"]!="")
				{
					$s_where .= " AND s_email LIKE '%".addslashes($search_variable["s_email"])."%' ";
				}if($search_variable["i_user_type"]!="")
				{
					$s_where .= " AND i_user_type = '".addslashes($search_variable["i_user_type"])."' ";
				}
				$arr_session = array();                
				$arr_session["searching_name"] = $this->data['heading'] ;        
				$arr_session["s_first_name"] = $search_variable["s_first_name"] ;       
				$arr_session["s_last_name"] = $search_variable["s_last_name"] ;       
				$arr_session["i_user_type"] = $search_variable["i_user_type"] ;
				$arr_session["s_email"] = $search_variable["s_email"] ;
				$this->session->set_userdata("arr_session",$arr_session);
				$this->session->set_userdata("h_search",$s_search);
				$this->data["h_search"] = $s_search;
				$this->data["s_first_name"] = $search_variable["s_first_name"];  
				$this->data["s_last_name"] = $search_variable["s_last_name"];  
				$this->data["i_user_type"] = $search_variable["i_user_type"];  
				$this->data["s_email"] = $search_variable["s_email"];  
			}
			else//List all records, **not done
			{
				//$s_where = " u.i_user_type IN(2,3,4) "; // id 1 is reserve for Super Admin
				//Releasing search values from session//
				$this->session->unset_userdata("arr_session");
				$this->session->unset_userdata("h_search");
				
				$this->data["h_search"] = $s_search;
				$this->data["s_first_name"] 	= ""; 
				$this->data["s_last_name"] 	= ""; 
				$this->data["s_email"] 	= ""; 
				$this->data["i_user_type"] 	= ""; 
				//end Storing search values into session//                 
			}
			unset($s_search,$arr_session,$search_variable);
			//Setting Limits, If searched then start from 0//
			if($this->input->post("h_search"))
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
			$info	= $this->mod_rect->fetch_multi($s_where, intval($start),$limit);
			
			//Creating List view for displaying//
			$table_view=array();  
			
			//Table Headers, with width,alignment//
			$table_view["caption"]				= addslashes(t("Manage User"));
			$table_view["total_rows"]		  	= count($info);
			$table_view["total_db_records"]		= $this->mod_rect->gettotal_info($s_where);
			$table_view["detail_view"]         	= false;  // to disable show details. 
			$j = 0;
			$table_view["headers"][$j]["width"] = "20%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"]	= addslashes(t("Name"));
			
			$table_view["headers"][++$j]["val"]	= addslashes(t("Email"));
			$table_view["headers"][$j]["width"]	= "20%";
			$table_view["headers"][$j]["align"]	= "left";
			
			$table_view["headers"][++$j]["val"]	= addslashes(t("Company"));
			$table_view["headers"][$j]["width"]	= "15%";
			$table_view["headers"][$j]["align"]	= "left";
            
             $table_view["headers"][++$j]["val"]    = addslashes(t("Status"));
            $table_view["headers"][$j]["width"]    = "10%";
            $table_view["headers"][$j]["align"]    = "center";
			
			//end Table Headers, with width,alignment//
			
			//Table Data//
			for($i = 0; $i<$table_view["total_rows"]; $i++)
			{
				$i_col = 0;
				$table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_first_name"].' '.$info[$i]["s_last_name"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_email"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_company_name"];
                //$table_view["tablerows"][$i][$i_col++] = ($info[$i]["i_status"] == 1) ? make_label('Active') : make_label('Inactive', 'warning');
                
                $action ='';
                if($this->data["action_allowed"]["Status"]) {
				if($info[$i]["i_status"] == 1)				
				{
					$table_view["tablerows"][$i][$i_col++] = '<span class="label label-success" id="status_row_id_'.$info[$i]["i_id"].'">Active</span>';
                    $action .='<a data-toggle="tooltip" data-placement="bottom" title="Make Inactive" class="glyphicon glyphicon-ok" id="status_img_id_'.$info[$i]["i_id"].'_inactive" href="javascript:void(0);" rel="make_inactive"></a>';
				}
				else
				{
					$table_view["tablerows"][$i][$i_col++] = '<span class="label label-warning" id="status_row_id_'.$info[$i]["i_id"].'">Inactive</span>';
                    $action .='<a data-toggle="tooltip" data-placement="bottom" title="Make Active" class="glyphicon glyphicon-ban-circle" id="status_img_id_'.$info[$i]["i_id"].'_active" href="javascript:void(0);" rel="make_active"></a>';
				}
				}
                if($action!='')
                {
                    $table_view["rows_action"][$i]    = $action;     
                }
			} 
			//end Table Data//
			unset($i,$i_col,$start,$limit); 
			
			$this->data["table_view"] = $this->admin_showin_table($table_view,TRUE);
			//Creating List view for displaying//
			$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();//used for search form action
			
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
            $this->data['title']		= addslashes(t("Manage User"));//Browser Title
            $this->data['heading']		= (t("Add Information"));
            $this->data['pathtoclass']	= $this->pathtoclass;
			$this->data['BREADCRUMB']	= array(addslashes(t('Add Information')));
			$this->data['mode']			= "add";			
		
           
            if($_POST)
            {
				$posted = array();
                $posted["s_first_name"]		= trim($this->input->post("s_first_name", true));
				$posted["s_last_name"]		= trim($this->input->post("s_last_name", true));
				$posted["s_email"]			= trim($this->input->post("s_email", true));
				$posted["i_user_type"]		= $this->input->post("i_user_type");
				$posted["s_password"] 		= trim($this->input->post("s_password"));
				$posted["s_company_name"] 	= trim($this->input->post("s_company_name", true));
				$posted["s_company_address"]= trim($this->input->post("s_company_address", true));
				
				$this->form_validation->set_rules('s_first_name', addslashes(t('user first name')), 'required|xss_clean');
				$this->form_validation->set_rules('s_last_name', addslashes(t('user last name')), 'required|xss_clean');
				//$this->form_validation->set_rules('s_email', addslashes(t('user email')), 'required|xss_clean|valid_email|is_unique['.$this->tbl.'.s_email]');
				$this->form_validation->set_rules('s_email', addslashes(t('user email')), 'required|xss_clean|valid_email|callback_unique_email_check');
				$this->form_validation->set_rules('s_password', addslashes(t('user password')), 'required|xss_clean|min_length[6]|max_length[20]|matches[s_con_password]');
				
                if($this->form_validation->run() == FALSE)//invalid
                {					
                    //Display the add form with posted values within it//
                    $this->data["posted"] = $posted;
                }
                else//validated, now save into DB
                {
					$s_password = $posted["s_password"];
					$posted["s_password"]		= md5(trim($posted["s_password"]).$this->config->item("security_salt"));
					$posted["dt_created_on"]	= now();
					$posted["s_user_name"]		= $posted["s_email"];
					$i_newid = $this->acs_model->add_data($this->tbl, $posted);
					if($i_newid > 0)//saved successfully
                    {
						// send mail start
						$to  = $posted["s_email"]; // note the comma
						//$from = 'projects@codeuridea.com';
						$from = 'devmyefiler@dev.myefiler.com';
						// subject
						$subject = 'Account has been created successfully';

						// message
						$message = '
						<html>
						<head>
						  <title>Your account details</title>
						</head>
						<body>
						  <p>Here are the details!</p>
						  <table border="0" cellspacing="2" cellpading="2" width="50%">
							<tr>
							  <th>Login Email</th><th>Password</th>
							</tr>
							<tr>
							  <td align="center">'.$posted["s_email"].'</td><td align="center">'.$s_password.'</td>
							</tr>
						  </table>
						</body>
						</html>
						';
						
						//if($_SERVER['SERVER_NAME']=='stagingapi.ams.com')
						if($_SERVER['SERVER_NAME']=='test.myefiler.com')
						{
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";							 
							// Create email headers
							$headers .= 'From: '.$from."\r\n".
								'Reply-To: '.$from."\r\n" .
								'X-Mailer: PHP/' . phpversion();							
							
							
							//@mail($to, $subject, $message);
							@mail($to, $subject, $message, $headers);
							
						}
						else
						{
							$i_sent = sendEmail($to, $subject, $message, $from);
						}
						// send mail end
						unset($posted);
						set_success_msg($this->cls_msg["save_success"]);
                        redirect($this->pathtoclass."show_list");
                    }
                    else//Not saved, show the form again
                    {
						set_error_msg($this->cls_msg["save_failed"]);
						$this->data["posted"] = $posted;
                    }
                }
            }
            //end Submitted Form//
			
			// Fetch User Type
			$this->data['USER_TYPE'] = $this->user_type;
            $this->render("manage_user/add-edit");
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }

    public function unique_email_check()
    {
		$email = $this->input->post("s_email");
		$h_id = $this->input->post("h_id");		
		$i_id = trim($h_id) ? decrypt($h_id) :"";
		
        $sql = " SELECT i_id FROM {$this->tbl} WHERE i_user_type IN(1,2,3,4) AND s_email = '".addslashes($email)."' ";
        if(intval($i_id) > 0)
        $sql .= " AND i_id != '".addslashes(intval($i_id))."' ";
        
        $info = $this->acs_model->exc_query($sql, true);
        if ($info[0]["i_id"] > 0)
        {
            $this->form_validation->set_message('unique_email_check', "Please check fields, %s value already exist.");
            return FALSE;
        }
        else
        {
            return TRUE;
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
			$this->data['title'] 		= addslashes(t("Manage User"));//Browser Title
            $this->data['heading']		= addslashes(t("Edit Information"));
            $this->data['pathtoclass']	= $this->pathtoclass;
			$this->data['BREADCRUMB']	= array(addslashes(t('Edit Information')));
            $this->data['mode']			= "edit";	
            
            //Submitted Form//
            if($_POST)
            {
				
				$posted = array();
				$posted["h_id"]				= $this->input->post("h_id", true);
                $posted["s_first_name"]		= trim($this->input->post("s_first_name", true));
				$posted["s_last_name"]		= trim($this->input->post("s_last_name", true));
				$posted["s_email"]			= trim($this->input->post("s_email", true));
				$posted["i_user_type"]		= $this->input->post("i_user_type");
				$posted["s_company_name"] 	= trim($this->input->post("s_company_name", true));
				$posted["s_company_address"]= trim($this->input->post("s_company_address", true));
				//$posted["s_password"] 	= trim($this->input->post("s_password"));
				
             
				//$this->form_validation->set_rules('s_email', addslashes(t('user email')), 'required|xss_clean|valid_email|is_unique['.$this->tbl.'.s_email.i_id.'.decrypt($posted["h_id"]).']');
				$this->form_validation->set_rules('s_email', addslashes(t('user email')), 'required|xss_clean|valid_email|callback_unique_email_check');
				$this->form_validation->set_rules('s_first_name', addslashes(t('user first name')), 'required|xss_clean');
				$this->form_validation->set_rules('s_last_name', addslashes(t('user last name')), 'required|xss_clean');				
				//$this->form_validation->set_rules('s_password', addslashes(t('user password')), 'required|xss_clean|matches[s_con_password]');
				
                if($this->form_validation->run() == FALSE)//invalid
                {					
                    //Display the add form with posted values within it//
                    $this->data["posted"] = $posted;
                }
                else//validated, now save into DB
                {
					$i_id = decrypt($posted["h_id"]);
					unset($posted["h_id"]);
                    $i_aff = $this->acs_model->edit_data($this->tbl, $posted, array('i_id'=>$i_id));
                    if($i_aff)//saved successfully
                    {
                        set_success_msg(get_message("save_success"));
                        redirect($this->pathtoclass."show_list");
                    }
                    else//Not saved, show the form again
                    {
                        $this->data["posted"] = $posted;
                        set_error_msg(get_message('save_failed'));
                    }
                    unset($i_id, $posted, $i_aff);
                }
            }
            else
            {	
                $posted = $this->mod_rect->fetch_this(decrypt($i_id));
                $posted['h_mode'] = $this->data['mode'];
				$posted["h_id"] = $i_id;
                $this->data["posted"] = $posted;       
                unset($info,$posted);      
            }
            //end Submitted Form//
			
			// Fetch User Type
			$this->data['USER_TYPE'] = $this->user_type;
            $this->render("manage_user/add-edit");
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
    public function view_detail($i_id = 0)
    {
        try
        {
			if(!empty($i_id))
			{
				$this->data["info"] = $this->mod_rect->fetch_this($i_id);
			}
			$this->load->view('web_master/manage_user/show_detail.tpl.php', $this->data); 
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
			echo $this->acs_model->delete_data($this->tbl, array('i_id'=>$i_id)) ? 'ok' : 'error';
			unset($i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    } 
	 
	// Change status of any content
	public function bkup_ajax_change_status()
    {
        try
        {
			$res = array();
            $posted["id"]		= trim($this->input->post("id"));
			$posted["i_status"]	= trim($this->input->post("status"));
			if($this->acs_model->edit_data($this->tbl, array('i_status'=>$posted["i_status"]), array('i_id'=>$posted["id"])))
			{
                if($posted["i_status"] == 0)
                {
                    $res['title'] = 'Make Active';
                    $res['status'] = 1;
                    $res['class'] = 'icon-check';
                    $res['label'] = '<span class="label label-warning">Inactive</span>';
                }
                else
                {
                    $res['title'] = 'Make Inactive';
                    $res['status'] = 0;
                    $res['class'] = 'icon-cancel';
                    $res['label'] = '<span class="label label-success">Active</span>';
                }
            }
            unset($posted);
            echo json_encode($res);
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
			//$i_rect = $this->mod_rect->change_status($info,$posted["id"]); /*don't change*/				
			$i_rect = $this->acs_model->edit_data($this->tbl, array('i_status'=>$posted["i_status"]), array('i_id'=>$posted["id"]));			
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
