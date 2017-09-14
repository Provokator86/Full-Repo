<?php 
/***
File Name: file_downloaded.php 
Created By: SWI Dev 
Created On: Oct 6, 2016 
Purpose: CURD for file_downloaded 
*/

class File_downloaded extends MY_Controller 
{
	public $patchtoclass, $cls_msg, $login_data, $user_role, $user_id, $user_type, $user_name;
	public $tbl, $tbl_payer, $tbl_payee, $tbl_history, $tbl_form, $tbl_batch_status_history, $tbl_batch_ascii_file, $tbl_batch_files_download_mapping ;
	protected $tbl_ref_use, $down_path;
	public function __construct(){
		parent::__construct();
		$this->data["title"] 	= addslashes(t('Manage Files'));//Browser Title 
		$this->pathtoclass 		= admin_base_url().$this->router->fetch_class()."/";
		$this->tbl 				= $this->db->BATCH_MASTER;
		$this->tbl_payer 		= $this->db->PAYER_INFO;
		$this->tbl_payee 		= $this->db->PAYEE_INFO;
		$this->tbl_history 		= $this->db->FORMS_PAYER_PAYEE_HISTORY;
		$this->tbl_form 		= $this->db->FORM_MASTER;
		$this->tbl_batch_status_history 	= $this->db->BATCH_STATUS_HISTORY;
		$this->tbl_batch_ascii_file 	= $this->db->BATCH_ASCII_FILE; // Default table
		$this->tbl_batch_files_download_mapping 	= $this->db->BATCH_ASCII_FILE_MAP;
		
        $login_data 			= $this->session->userdata("admin_loggedin");
        $this->login_data 		= $login_data;
        //pr($login_data);
        if(!empty($login_data))
        {
            $log_user_id        = decrypt($login_data['user_id']);
            $log_user_role      = decrypt($login_data['user_type_id']);
            $this->user_role    = $log_user_role;
            $this->user_id      = $log_user_id;
            $this->user_type    = decrypt($login_data["user_type_id"]);
            $this->user_name    = $login_data['user_name'];
        }
        
        $this->down_path = $this->config->item('ASCII_FILE_PATH_DOWN');
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
            $this->data['heading'] = addslashes(t("Manage Files")); //Package Name[@package] Panel Heading
            $this->session->unset_userdata('sess_form_id');
            //echo '========='._batchStatus(1);
            
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
            $search_variable["s_batch_id"] 	= ($this->input->get("h_search")?$this->input->get("s_batch_id"):$arr_session_data["s_batch_id"]);
            $search_variable["i_status"] 	= ($this->input->get("h_search")?$this->input->get("i_status"):$arr_session_data["i_status"]);
            $search_variable["dt_from"]		= ($this->input->get("h_search")?$this->input->get("dt_from"):$arr_session_data["dt_from"]);
            $search_variable["dt_to"]		= ($this->input->get("h_search")?$this->input->get("dt_to"):$arr_session_data["dt_to"]);
            //end Getting Posted or session values for search//            
            
            $s_where = " n.i_id > 0 ";
            
            if($this->user_type > 4 &&  $this->user_name != '')
				$s_where .= " AND n.i_created_by='".addslashes($this->user_id)."' "; // for user type greater than admin
				
            if($s_search == "advanced")
            {
                $arr_session = array();
                //$arr_session["searching_name"] = $this->data['heading'];
                $search_variable["searching_name"] = $this->data['heading'];
                
                if($search_variable["s_batch_id"]!="")
                    //$s_where .= " AND m.s_batch_id LIKE '%".addslashes($search_variable["s_batch_id"])."%' ";
                    $s_where .= " AND m.s_batch_id = '".addslashes($search_variable["s_batch_id"])."' ";
                
                if($search_variable["i_status"]!="")
                    $s_where .= " AND n.i_status = '".addslashes($search_variable["i_status"])."' ";
                    
                if($search_variable["dt_from"] != '' && $search_variable["dt_to"] !='')
                {
                    $s_where .= ' AND (DATE_FORMAT(n.dt_download, "%Y-%m-%d") >="'.make_db_date($search_variable["dt_from"]).'" AND DATE_FORMAT(n.dt_download, "%Y-%m-%d") <= "'.make_db_date($search_variable["dt_to"]).'") ';
                }
                else if($search_variable["dt_from"] != '')
                    $s_where .= ' AND DATE_FORMAT(n.dt_download, "%Y-%m-%d") >="'.make_db_date($search_variable["dt_from"]).'" ';
                else if($search_variable["dt_to"] != '')
                    $s_where .= ' AND DATE_FORMAT(n.dt_download, "%Y-%m-%d") <= "'.make_db_date($search_variable["dt_to"]).'" ';
                
                
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
                
                $this->data["h_search"] 	= $s_search;              
                $this->data["s_batch_id"]   = "";                            
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
            $arr_sort = array('0'=>'n.dt_download');   
            $order_by= !empty($order_by)?in_array(decrypt($order_by),$arr_sort)?decrypt($order_by):$arr_sort[0]:$arr_sort[0];
            
            $limit = $this->i_admin_page_limit ;            
            //$info = $this->acs_model->fetch_data( $this->tbl_batch_ascii_file.' AS n', $s_where,'', $start, $limit, $order_by, $sort_type);
            //$total =  $this->acs_model->count_info($this->tbl_batch_ascii_file.' AS n', $s_where );
            //pr($info,1);
            
            if($s_where)
				$s_where .= " GROUP BY m.i_file_pk ";
            
            $tbl = array(																										
				0 => array(																										
					'tbl' => $this->tbl_batch_ascii_file.' AS n',																			
					'on' => '',	                                                                                                
					'join' => 'left' // 'inner', 'right' default 'left'															
				), 																												
				1 => array(																										
					'tbl' => $this->tbl_batch_files_download_mapping.' AS m',																			
					'on' => 'm.i_file_pk = n.i_id'																				
				)																											
			);		
			
			$conf = array(																										
				'select' => 'n.*, m.s_batch_id',																	
				'where' => $s_where,																						
				'limit' => $limit,																									
				'offset' => $start,																									
				'order_by' => $order_by,																						
				'order_type' => $sort_type // default ASC																			
			);	
			
			$conf_count = array(																										
				'select' => ' COUNT(n.i_id) AS total',																	
				'where' => $s_where																			
			);	
			
			$info = $this->acs_model->fetch_data_join($tbl, $conf);	
			$totalInfo =  $this->acs_model->fetch_data_join($tbl, $conf_count );	
			$total = $totalInfo[0]['total'];
                  
            //Creating List view for displaying//
            $table_view = array();  
            
            //Table Headers, with width,alignment//
            $table_view["caption"]                 = addslashes(t("Manage Files"));
            $table_view["total_rows"]              = count($info);
            $table_view["total_db_records"]        = $total;
            $table_view["detail_view"]             = true;  // to disable show details. 
            $table_view["chkbox_view"]             = false;  // to disable show checkbox. 
            $table_view["order_name"]              = encrypt($order_by);
            $table_view["order_by"]                = $sort_type;
            $table_view["src_action"]              = $this->pathtoclass.$this->router->fetch_method();
            
            $j = -1;
            
			$table_view["headers"][++$j]["width"] = "40%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("File Name"));
			
			$table_view["headers"][++$j]["width"] = "20%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("Date Downloaded"));
			
			//~ $table_view["headers"][++$j]["width"] = "20%";
			//~ $table_view["headers"][$j]["align"] = "left";
			//~ $table_view["headers"][$j]["val"] = addslashes(t("Status"));
            //end Table Headers, with width,alignment//
            
            //Table Data//
            for($i = 0; $i< $table_view["total_rows"]; $i++)
            {
                $i_col = 0;
                $table_view["tablerows"][$i][$i_col++] = $info[$i]["i_id"];  
				//$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_batch_ids"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_file"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["dt_download"]?date("m/d/Y H:i:s", strtotime($info[$i]["dt_download"])):"N/A";
				//$table_view["tablerows"][$i][$i_col++] = $info[$i]["i_status"]?_batchStatus($info[$i]["i_status"]):"Downloaded";
				
				//$action = '<a id="change_status_'.$i.'" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Change Status" class="glyphicon glyphicon-check change_batch_status" data-original-title="Change Status" >&nbsp;</a>';
				//$table_view["rows_action"][$i] = $action;
				$action = '';
				$action .= '<a id="dwn_ascii_'.$i.'" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Download ASCII" class="glyphicon glyphicon-download dwn_ascii" data-original-title="Download ASCII" >&nbsp;</a>';
				
				$view_detail = $this->pathtoclass.'nap_view_detail/'.$info[$i]["i_id"];
				if($this->data["action_allowed"]["View Detail"])
				$action .= '<a id="view_detail_'.$i.'" data-id="'.$info[$i]["i_id"].'" href="javascript:" data-toggle="tooltip" data-placement="bottom" title="View Details" class="glyphicon glyphicon-zoom-in file_view_detail" data-original-title="View Details" >&nbsp;</a>';
				
				if($this->data["action_allowed"]["Status"])
				$action .= '<a id="change_status_'.$i.'" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Change Status" class="glyphicon glyphicon-check change_batch_status" data-original-title="Change Status" >&nbsp;</a>';
				
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
    
    
    
	// download the ASCII file downloaded
    public function ajax_get_downloaded()
    {
        //$res = array('status' => 'error', 'html' => '', 'msg' => 'Something going wrong.');
        $file_id = intval($this->input->post('file_id', true));
        if($file_id > 0)
        {
            // Info details
            $status = $this->acs_model->fetch_data($this->tbl_batch_ascii_file, array('i_id' => $file_id), 's_batch_ids, s_file');            
			
			$s_file_name = $status[0]['s_file'];
			$this->load->helper('download');
            $data = $this->config->item('ASCII_FILE_PATH_DOWN'); 
            $name = $s_file_name;            
            $fullpath = @file_get_contents($data.$name);
            //echo $fullpath;
            force_download($name, $fullpath);             
        }
        else
        {
			redirect($this->pathtoclass.'show_list');
		}
			
        //echo json_encode($res);
    }
    
    
    
    
 // Fetch batch status to change it manually
    public function ajax_fetch_batch_current_status()
    {
        $res = array('status' => 'error', 'html' => '', 'msg' => 'Something going wrong.');
        $batch_id = intval($this->input->post('batch_id', true));
        if($batch_id > 0)
        {
            // Info details
            $status = $this->acs_model->fetch_data($this->tbl_batch_ascii_file, array('i_id' => $batch_id), 'i_status, s_batch_ids');            
			$res['html'] = form_dropdown('batch_status', $this->db->BATCH_STATS, array($status[0]['i_status']), 'data-rel="chosen" id="batch_status"');
            $res['status'] = 'success';
        }
        echo json_encode($res);
    }
    
    // Change batch status manually
    public function ajax_batch_change_status()
    {
        $res = array('status' => 'error', 'msg' => get_message('save_failed'), 'href' => '');
        $this->batch_id = $batch_id = intval($this->input->post('batch_id', true));
        $comment = trim($this->input->post('comment', true));
        $info['i_status'] = $st = intval($this->input->post('status'));        
        //pr($info,1);
        
        $batchIdsArr = array();
        $file_info = $this->acs_model->fetch_data($this->tbl_batch_ascii_file, array('i_id' => $batch_id), 's_batch_ids'); 
        $batchIdsArr = explode(',', $file_info[0]["s_batch_ids"]);
        
        $sql_t = " UPDATE ".$this->tbl_batch_ascii_file." SET i_status= '".$info['i_status']."' WHERE i_id = '".addslashes($batch_id)."' ";
        $this->acs_model->exc_query($sql_t, false);
        //pr($batchIdsArr,1);
        /*if($batch_id > 0)
        {           
			unset($info, $comment, $batch_id, $status,$tmp);
        }*/
        if(!empty($batchIdsArr))
        {
			$res['status'] 	= 'success';
			$res['msg'] 	= get_message('save_success');				
			$res['href'] 	= $this->pathtoclass.'show_list';

			foreach($batchIdsArr as $val)
			{
				#$sqry = " UPDATE ".$this->tbl." SET i_status= '".$info['i_status']."' WHERE s_batch_id = '".addslashes($val)."' ";
				$sqry = " UPDATE ".$this->tbl." SET i_status= '".$info['i_status']."', dt_change_status = '".date("Y-m-d H:i:s")."' WHERE s_batch_id = '".addslashes($val)."' ";
				//if($this->acs_model->edit_data($this->tbl, $info, array('i_id' => $val)))
				if($this->acs_model->exc_query($sqry, false))
				{
					// Add batch history
					$logArr = array();
					$logArr["s_batch_id"] 	= $val;
					//$logArr["s_action"] 	= 'Batch status change to '._batchStatus($info['i_status']);
					$logArr["s_action"] 	= _batchStatus($info['i_status']);
					$logArr["s_comment"] 	= $comment;
					$logArr["i_status"] 	= $info['i_status']; // first status
					$logArr["i_created_by"] = $this->user_id ; // loggedin users id
					
					$this->acs_model->add_data($this->tbl_batch_status_history, $logArr);				
					
					//*********** send email to the customer sending him the batch number and current status 10 Nov, 2016 **********//
					// see @https://shieldwatch.teamwork.com/messages/568694?scrollTo=pmp1634382
					$user_email = '';
					//$batchInfo = $this->acs_model->fetch_data( $this->tbl,  array('i_id' => $batch_id));
					$qry = " SELECT * FROM ".$this->tbl." WHERE s_batch_id= '".addslashes($val)."' ";
					$batchInfo = $this->acs_model->exc_query($qry, true);
					$batchCode = $batchInfo[0]["s_batch_id"];
					$userInfo = _get_user_details($batchInfo[0]["s_username"]); // see@ common_helper.php
					$user_email = $userInfo["s_email"];
					$auto_email_feature = $userInfo["i_auto_email"];
					
					if($user_email!='' && $auto_email_feature==1)
					{							
						//$user_email = 'mmondal@codeuridea.com';
						$to  = $user_email; // note the comma
						$from = 'projects@codeuridea.com';
						// subject
						$subject = 'Batch Status Updated';

						// message
						$message = '
						<html>
						<head>
						  <title>Batch Status Updated</title>
						</head>
						<body>
						  <p>Here are the details!</p>
						  <table border="0" cellspacing="2" cellpading="2" width="50%">
							<tr>
							  <th>Batch Number</th><th>Current Status</th>
							</tr>
							<tr>
							  <td align="center">'.$batchCode.'</td><td align="center">'._batchStatus($info['i_status']).'</td>
							</tr>
						  </table>
						</body>
						</html>
						';
						
						//if($_SERVER['SERVER_NAME']=='stagingapi.spiceandtea.com')
						if($_SERVER['SERVER_NAME']=='1099.codeuridea.net')
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
												
					}
					
					//*********** end send email to the customer sending him the batch number and current status **********//	
					
				}
			}
		}
        echo json_encode($res);
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
    }

    /***
    * Shows details of a single record.
    * 
    * @param int $i_id, Primary key
    */
    public function view_detail($i_id = 0)
    {	
    }
    
   // Fetch batch status to change it manually
    public function ajax_fetch_file_detail()
    {
        $res = array('status' => 'error', 'html' => '', 'msg' => 'Something going wrong.');
        $batch_id = intval($this->input->post('batch_id', true));
        if($batch_id > 0)
        {
            // Info details
            $tmp = $this->acs_model->fetch_data($this->tbl_batch_ascii_file, array('i_id' => $batch_id));   
            $info = $tmp[0];
            //pr($status);   
            if(!empty($info))      
            {
				$str='';
				$batch_arr = explode(',', $info["s_batch_ids"]);
				if(!empty($batch_arr))
				{
					$str = implode(', ',$batch_arr);
				}
				$date = $info["dt_download"]?date("m/d/Y H:i:s", strtotime($info["dt_download"])):"N/A";
				$html .='<div class="form-group"><label>File Name: </label>'.$info["s_file"].'</div>';
				$html .='<div class="form-group"><label>Batch Numbers: </label>'.trim($str).'</div>';
				$html .='<div class="form-group"><label>Date Downloaded: </label>'.$date.'</div>';
			}
			$res['html'] = $html;
            $res['status'] = 'success';
        }
        echo json_encode($res);
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
	
   
	
	public function __destruct(){}
}
