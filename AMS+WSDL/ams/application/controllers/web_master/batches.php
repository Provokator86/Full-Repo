<?php 
/***
File Name: batches.php 
Created By: SWI Dev 
Created On: Oct 6, 2016 
Purpose: CURD for batches 
*/

class Batches extends MY_Controller 
{
	public $patchtoclass, $cls_msg, $tbl, $login_data, $user_role, $user_id, $user_type, $user_name;
	public $tbl_user, $tbl_payer, $tbl_payee, $tbl_history, $tbl_form, $tbl_batch_status_history, $tbl_batch_ascii_file, $tbl_batch_files_download_mapping ;
	public $tbl_ref_use, $tbl_amt_codes;
	public function __construct(){
		parent::__construct();
		$this->data["title"] 	= addslashes(t('Manage Batches'));//Browser Title 
		$this->pathtoclass 		= admin_base_url().$this->router->fetch_class()."/";
		$this->tbl 									= $this->db->BATCH_MASTER;// Default Table
		$this->tbl_user 							= $this->db->USER;
		//$this->tbl_amt_codes	= $this->db->AMOUNT_CODES;
		$this->tbl_payer 							= $this->db->PAYER_INFO;
		$this->tbl_payee 							= $this->db->PAYEE_INFO;
		$this->tbl_history 							= $this->db->FORMS_PAYER_PAYEE_HISTORY;
		$this->tbl_form 							= $this->db->FORM_MASTER;
		$this->tbl_batch_status_history 			= $this->db->BATCH_STATUS_HISTORY;
		$this->tbl_batch_ascii_file 				= $this->db->BATCH_ASCII_FILE;
		$this->tbl_batch_files_download_mapping 	= $this->db->BATCH_ASCII_FILE_MAP;
		$this->tbl_payee_others_info 				= $this->db->PAYEE_OTHERS_INFO;
		
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
            $this->data['heading'] = addslashes(t("Manage Batches")); //Package Name[@package] Panel Heading
            $this->session->unset_userdata('sess_form_id');
            //echo '========='._batchStatus(1);
            
            //phpinfo();
            /*$from = 'projects@codeuridea.com';
            $to = "mrinsss@gmail.com";
            $subject = "hi";
            $message = "hi";            
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";							 
			// Create email headers
			$headers .= 'From: '.$from."\r\n".
				'Reply-To: '.$from."\r\n" .
				'X-Mailer: PHP/' . phpversion();							
						
            mail($to, $subject, $message);*/
            /*$to = "mrinsss@gmail.com";
            $subject = "hi";
            $message = "hi";
            sendEmail($to, $subject, $message);*/
            
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
            
            $s_where = " n.i_status != 0 ";
            
            if($this->user_type > 4 &&  $this->user_name != '')
				$s_where .= " AND n.s_username='".addslashes($this->user_name)."' "; // for user type greater than admin
				
            //$s_where = " n.i_processed = 0 ";
            if($s_search == "advanced")
            {
                $arr_session = array();
                //$arr_session["searching_name"] = $this->data['heading'];
                $search_variable["searching_name"] = $this->data['heading'];
                
                if($search_variable["s_batch_id"]!="")
                    $s_where .= " AND n.s_batch_id LIKE '%".addslashes($search_variable["s_batch_id"])."%' ";
                
                if($search_variable["i_status"]!="")
                    $s_where .= " AND n.i_status = '".addslashes($search_variable["i_status"])."' ";
                    
                if($search_variable["dt_from"] != '' && $search_variable["dt_to"] !='')
                {
                    $s_where .= ' AND (DATE_FORMAT(n.dt_created, "%Y-%m-%d") >="'.make_db_date($search_variable["dt_from"]).'" AND DATE_FORMAT(n.dt_created, "%Y-%m-%d") <= "'.make_db_date($search_variable["dt_to"]).'") ';
                }
                else if($search_variable["dt_from"] != '')
                    $s_where .= ' AND DATE_FORMAT(n.dt_created, "%Y-%m-%d") >="'.make_db_date($search_variable["dt_from"]).'" ';
                else if($search_variable["dt_to"] != '')
                    $s_where .= ' AND DATE_FORMAT(n.dt_created, "%Y-%m-%d") <= "'.make_db_date($search_variable["dt_to"]).'" ';
                
                
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
            $arr_sort = array('0'=>'n.s_batch_id','1'=>'n.dt_created');   
            $order_by= !empty($order_by)?in_array(decrypt($order_by),$arr_sort)?decrypt($order_by):$arr_sort[0]:$arr_sort[0];
            
            $limit = $this->i_admin_page_limit ;            
            $info = $this->acs_model->fetch_data( $this->tbl.' AS n', $s_where,'', $start, $limit, $order_by, $sort_type);
            $total =  $this->acs_model->count_info($this->tbl.' AS n', $s_where );
            //pr($info,1);
                  
            //Creating List view for displaying//
            $table_view = array();  
            
            //Table Headers, with width,alignment//
            $table_view["caption"]                 = addslashes(t("Manage Batches"));
            $table_view["total_rows"]              = count($info);
            $table_view["total_db_records"]        = $total;
            $table_view["detail_view"]             = true;  // to disable show details. 
            $table_view["chkbox_view"]             = true;  // to disable show checkbox. 
            $table_view["order_name"]              = encrypt($order_by);
            $table_view["order_by"]                = $sort_type;
            $table_view["src_action"]              = $this->pathtoclass.$this->router->fetch_method();
            
            $j = -1;
            
			$table_view["headers"][++$j]["width"] = "20%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("Batch Number"));
            
			$table_view["headers"][++$j]["width"] = "20%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("Username"));
			
			$table_view["headers"][++$j]["width"] = "20%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("Date"));
			
			$table_view["headers"][++$j]["width"] = "20%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("Status"));
            //end Table Headers, with width,alignment//
            
            //Table Data//
            for($i = 0; $i< $table_view["total_rows"]; $i++)
            {
                $i_col = 0;
                $table_view["tablerows"][$i][$i_col++] = $info[$i]["i_id"];  
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_batch_id"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_username"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["dt_created"]?date("m/d/Y H:i:s", strtotime($info[$i]["dt_created"])):"N/A";
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["i_status"]?_batchStatus($info[$i]["i_status"]):"";
				if($this->data["action_allowed"]["Status"])
				{
					$action = '<a id="change_status_'.$i.'" data-id="'.$info[$i]["i_id"].'" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Change Status" class="glyphicon glyphicon-check change_batch_status" data-original-title="Change Status" >&nbsp;</a>';
					$table_view["rows_action"][$i] = $action;
				}
				
            } 
            //end Table Data//
            unset($i, $i_col, $start, $limit, $s_where); 
            //pr($this->data["action_allowed"]["Status"]);
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
    
    
    public function ajax_download_ascii_file()
    {
        $batch_ids 	= $_POST['s_batch_id'];
       
        //if($batch_ids)
		$s_where = " n.i_id IN({$batch_ids}) AND s_username NOT LIKE 'tst%' AND (i_processed=0 OR i_status=2)";
        $batch_info = $this->acs_model->fetch_data($this->tbl.' AS n', $s_where,'');  
        //pr($batch_info,1);
        $batchs=array(); 
        //$batchsOwnerIds=array(); 
        if(!empty($batch_info)) 
        {
			foreach($batch_info as $val)
			{
				$batchs[] = $val['s_batch_id'];
				//$batchsOwnerIds[] = $val['s_username'] ? _getUserId($val['s_username']): 0; // 21 July, 2017 to see user wise records NOT USED
			}
		}
        if(!empty($batchs))
		{
			//$posted		= array();
			//$posted 	= $_POST;	           
			//$batchs 	= $posted['s_batch_id'];				
			$s_where = " WHERE 1 ";
			$batchIds = implode(',', $batchs);
			$condition = '';
			if(!empty($batchs))
			{
				$arr_where = '';
				foreach($batchs as $b)
				{
					$arr_search[] = " s_batch_code ='".addslashes($b)."' ";
				}
				$arr_where .= (count($arr_search) !=0)?' AND ('.implode('OR',$arr_search).' )':'';
				$condition  .= $arr_where;
			}
			$s_where .= trim($condition).'  ' ;  
			
			$sql = "SELECT s_form_type FROM {$this->tbl_payer} {$s_where}  GROUP BY s_form_type ";
			$forms = $this->acs_model->exc_query($sql, true); // forms info 
			
			$sql = "SELECT * FROM {$this->tbl_payer} {$s_where}  ";
			$a_info = $this->acs_model->exc_query($sql, true); // payer info
			$tot_payer = count($a_info); // total payer
			
			$sql = "SELECT i_id FROM {$this->tbl_payee} {$s_where}  ";
			$tot_payee_info = $this->acs_model->exc_query($sql, true); 
			$tot_payee = count($tot_payee_info); // total payee
			
					
			//echo $tot_payer;
			//pr($batch_info,1);
			//exit;				
			
			/*if($this->form_validation->run() == FALSE)///invalid
			{
				$this->data["posted"]=$posted;
			}
			else///validated, now save into DB
			{*/						
				$t_info = $this->acs_model->fetch_data($this->db->SITESETTING, array('i_id'=>1));	
				//$org_name = 'MULTI-SW-efile.txt';
				$org_name = 'Submission'.time().'.txt';
				$file = $this->config->item('TEXTFILEAMS').$org_name;					
				$myfile = fopen($file, "w") or die("Unable to open file!");
				fclose($myfile);
				$content = ''; //Start New Content
				// *************************** START TRANSMITTER (T) RECORD  ********************** //
				$content .= 'T2015';
				//Prior Year Data Indicator. Required. Enter “P” only if reporting prior year data; otherwise, enter a blank. 
				//Do not enter a “P” if the tax year is 2015.
				$content .= add_blank_space(1);				
						
				//Transmitters TIN
				$content .= pad_blank_space($t_info[0]["s_tin"],9);
				$content .= pad_blank_space($t_info[0]["s_tcc"],5);
				$content .= add_blank_space(7);
				//Test File Indicator T->test file else balnk
				$content .= pad_blank_space('T',1);
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
				$content .= addZeroLeft($tot_payee,8);
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
				$vendor_ind = 'V';
				$content .= $vendor_ind;
				if($vendor_ind=='V')
				{						
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
				}
				else
				{					
					//Vendor Name
					$content .= add_blank_space(40);
					//Vendor Mailing Address (need to discuss with sir)
					$content .= add_blank_space(40);
					//Vendor City
					$content .= add_blank_space(40);
					//Vendor State
					$content .= add_blank_space(2);
					//Vendor ZIP Code
					$content .= add_blank_space(9);
					//Vendor Contact Name
					$content .= add_blank_space(40);
					//Contact Telephone Number & Extension
					$content .= add_blank_space(15);
					
					$content .= add_blank_space(35);
					//Vendor Foreign Entity Indicator
					$content .= add_blank_space(1);
				}
				
				$content .= add_blank_space(8);
				$content .= "\r";
				//$content .= add_blank_space(2);
				// ********************** END TRANSMITTER (T) RECORD  ********************** //
				
				// NOW CHECK FOR FORMS
				if($forms)
				{
					foreach($forms as $f)
					{				
							
						#$formTitle 	= _form_title($f);
						$formTitle 	= _form_title($f['s_form_type']);
						$formDet 	= array();
						$formID 	= $f['s_form_type'];
						$formDet 	= $this->acs_model->fetch_data($this->tbl_form, array('i_id'=>$f['s_form_type']));
						// *************************** START PAYER (A) RECORD  ********************** //
						if($formDet[0]["s_type_of_return"]==940 || $formDet[0]["s_type_of_return"]==941 || $formDet[0]["s_type_of_return"]==944 )
						{
						}
						else
						{
						// start with payer records
						for($i=0; $i < count($a_info); $i++)
						{
							$content .= 'A2015';
							//Combined Federal / State Filing Program
							$content .= pad_blank_space($a_info[$i]["i_cf_sf"], 1);
							$content .= add_blank_space(5);
							//Payers Taxpayer Identification Number (TIN)
							$content .= pad_blank_space($a_info[$i]["s_payer_tin"],9);
							//Payer Name Control
							$content .= add_blank_space(4);
							//Last Filing Indicator (need to discuss with sir)
							$content .= add_blank_space(1);
							//Type of Return
							$content .= pad_blank_space($formDet[0]["s_type_of_return"],2);
							//Amount Codes 
							#$amount_codes = $a_info[$i]["s_amount_codes"]?$a_info[$i]["s_amount_codes"]:"24";
							$amount_codes = $formDet[0]["s_amount_codes"]?$formDet[0]["s_amount_codes"]:"";
							$content .= pad_blank_space($amount_codes,16);
							$content .= add_blank_space(8);
							//Foreign Entity Indicator
							$content .= add_blank_space(1);
							//First Payer Name Line
							$content .= pad_blank_space($a_info[$i]["s_first_payer_name_line"],40);
							//Second Payer Name Line
							$content .= pad_blank_space($a_info[$i]["s_second_payer_name_line"],40);
							//Transfer Agent Indicator
							$content .= pad_blank_space('0',1);
							//Payer Shipping Address
							$content .= pad_blank_space($a_info[$i]["s_payer_shipping_address"],40);
							//Payer City
							$content .= pad_blank_space($a_info[$i]["s_payer_city"],40);
							//Payer State
							$content .= pad_blank_space($a_info[$i]["s_payer_state"],2);
							//Payer Zip Code
							$content .= pad_blank_space($a_info[$i]["s_payer_zip_code"],9);
							//Payers Telephone Number and Extension
							$phn = str_replace("-","",$a_info[$i]["s_payers_telephone_number_and_extension"]);
							$content .= pad_blank_space($phn,15);
							$content .= add_blank_space(260);
							//Record Sequence Number
							$record_seq_no = addZeroLeft(($record_seq_no+1),8);
							$content .=$record_seq_no;
							$content .= add_blank_space(241);
							$content .= "\r";
							
							// NOW GET PAYEE LIST WHO DOES NOT HAVE PRINT THIS FORM YET
							$k_record_str = '';
							$b_info = array();
							if($a_info[$i]['s_batch_code'])
							{	
								/*$sql = "SELECT p.*, det.*, n.s_form_id, n.dt_added, n.i_status, n.i_payee_id AS payee_id FROM {$this->tbl_history} AS n
										LEFT JOIN {$this->tbl_payee} AS p ON p.i_id = n.i_payee_id
										LEFT JOIN {$this->tbl_payee_others_info} AS det ON det.i_payee_id = p.i_id
										WHERE n.s_batch_code='".$a_info[$i]['s_batch_code']."' AND n.i_payer_id='".$a_info[$i]['i_id']."' AND n.s_form_id='".$formID."' 
										GROUP BY n.i_payee_id ";*/
										
								$sql = "SELECT p.*, n.s_form_id, n.dt_added, n.i_status, n.i_payee_id FROM {$this->tbl_history} AS n
										LEFT JOIN {$this->tbl_payee} AS p ON p.i_id = n.i_payee_id
										WHERE n.s_batch_code='".$a_info[$i]['s_batch_code']."' AND n.i_payer_id='".$a_info[$i]['i_id']."' AND n.s_form_id='".$formID."' 
										GROUP BY n.i_payee_id ";
										
								$b_info = $this->acs_model->exc_query($sql, true);	
								//pr($b_info,1);									
								if(!empty($b_info))
								{				
									$k_record_arr = array();						
									$tot_payee_this_form = 0; 
									$c_rec_amount1 = $c_rec_amount2 = $c_rec_amount3 = $c_rec_amount4 = $c_rec_amount5 = $c_rec_amount6 = $c_rec_amount7 = $c_rec_amount8 = 0;
									$c_rec_amount9 = $c_rec_amount10 = $c_rec_amount11 = $c_rec_amount12 = $c_rec_amount13 = $c_rec_amount14 = $c_rec_amount15 = $c_rec_amount16 = 0;
									foreach($b_info as $payee)
									{
										$k_record_str .= ','.$payee['i_id'];
										$sql2='';
										$sql2=" SELECT * FROM {$this->tbl_history} WHERE i_payer_id='".$a_info[$i]['i_id']."' AND s_form_id = '".$formID."' AND i_payee_id= '".$payee["i_id"]."'  ";
										$payee_exist = array();
										//$payee_exist = $this->acs_model->exc_query($sql2, true);
										if(empty($payee_exist) || TRUE)
										{
											$k_record_arr[] = $payee;
											$tot_payee_this_form = $tot_payee_this_form+1; // increase total count
											$c_rec_amount1 	= $c_rec_amount1+$payee["s_payment_amount1"];
											$c_rec_amount2 	= $c_rec_amount2+$payee["s_payment_amount2"];
											$c_rec_amount3 	= $c_rec_amount3+$payee["s_payment_amount3"];
											$c_rec_amount3 	= $c_rec_amount3+$payee["s_payment_amount4"];
											$c_rec_amount5 	= $c_rec_amount5+$payee["s_payment_amount5"];
											$c_rec_amount6 	= $c_rec_amount6+$payee["s_payment_amount6"];
											$c_rec_amount7 	= $c_rec_amount7+$payee["s_payment_amount7"];
											$c_rec_amount8 	= $c_rec_amount8+$payee["s_payment_amount8"];
											$c_rec_amount9 	= $c_rec_amount9+$payee["s_payment_amount9"];
											$c_rec_amount10 = $c_rec_amount10+$payee["s_payment_amount10"];
											$c_rec_amount11 = $c_rec_amount11+$payee["s_payment_amount11"];
											$c_rec_amount12 = $c_rec_amount12+$payee["s_payment_amount12"];
											$c_rec_amount13	= $c_rec_amount13+$payee["s_payment_amount13"];
											$c_rec_amount14 = $c_rec_amount14+$payee["s_payment_amount14"];
											$c_rec_amount15 = $c_rec_amount15+$payee["s_payment_amount15"];
											$c_rec_amount16 = $c_rec_amount16+$payee["s_payment_amount16"];
											
											// *************************** START PAYEE (B) RECORD  ********************** //
											$content .= 'B2015';
											//Corrected Return Indicator (See Note.)
											$content .= add_blank_space(1);
											// Name Control
											$namec = $payee["s_last_payee_name_line"]?substr($payee["s_last_payee_name_line"],0,4):"";
											$content .= pad_blank_space($namec,4);
											//Type of TIN
											$content .= pad_blank_space($payee["s_type_of_tin"],1);
											// Payees Taxpayer Identification Number (TIN)
											$content .= pad_blank_space($payee["s_payee_tin"],9);
											// Payers Account Number For Payee
											$content .= pad_blank_space($payee["s_payer_account_number"],20);
											//Payers Office Code
											$content .= pad_blank_space($payee["s_payer_office_code"],4);
											$content .= add_blank_space(10);
											// payemtn amount need to discuss with sir
											$content .= addZeroLeftPrice($payee["s_payment_amount1"],12);
											$content .= addZeroLeftPrice($payee["s_payment_amount2"],12);
											$content .= addZeroLeftPrice($payee["s_payment_amount3"],12);
											$content .= addZeroLeftPrice($payee["s_payment_amount4"],12);
											$content .= addZeroLeftPrice($payee["s_payment_amount5"],12);
											$content .= addZeroLeftPrice($payee["s_payment_amount6"],12);
											$content .= addZeroLeftPrice($payee["s_payment_amount7"],12);
											$content .= addZeroLeftPrice($payee["s_payment_amount8"],12);
											$content .= addZeroLeftPrice($payee["s_payment_amount9"],12);
											$content .= addZeroLeftPrice($payee["s_payment_amount10"],12);
											$content .= addZeroLeftPrice($payee["s_payment_amount11"],12);
											$content .= addZeroLeftPrice($payee["s_payment_amount12"],12);
											$content .= addZeroLeftPrice($payee["s_payment_amount13"],12);
											$content .= addZeroLeftPrice($payee["s_payment_amount14"],12);
											$content .= addZeroLeftPrice($payee["s_payment_amount15"],12);
											$content .= addZeroLeftPrice($payee["s_payment_amount16"],12);
											
											//Foreign Country Indicator
											$content .= add_blank_space(1);
											//First Payee Name Line
											$fullname = $payee["s_first_payee_name_line"].($payee["s_last_payee_name_line"]?' '.$payee["s_last_payee_name_line"]:"");
											$content .= pad_blank_space($fullname,40);
											//Second Payee Name Line
											$content .= pad_blank_space($payee["s_second_payee_name_line"],40);
											$content .= add_blank_space(40);
											//Payee Mailing Address
											$content .= pad_blank_space($payee["s_payee_shipping_address"],40);
											$content .= add_blank_space(40);
											//Payee City
											$content .= pad_blank_space($payee["s_payee_city"],40);
											//Payee State
											$content .= pad_blank_space($payee["s_payee_state"],2);
											//Payee ZIP Code
											$content .= pad_blank_space($payee["s_payee_zip_code"],9);
											$content .= add_blank_space(1);
											//Record Sequence Number
											$record_seq_no = addZeroLeft(($record_seq_no+1),8);
											$content .=$record_seq_no;
											$content .= add_blank_space(36);
											
												//+++++++ FORM WISE DIFFERENT line no 544 - 750 +++++++
											// for 544-750 form 1099A go to page no 74
											if($formDet[0]["s_type_of_return"]=='4')
											{
												$content .= add_blank_space(3);
												//Personal Liability Indicator
												$content .= pad_blank_space($payee["s_personal_liability"],1);
												//Date of Lenders Acquisition or Knowledge of Abandonment
												$date = $payee["dt_lender_aquisition"]?date("Ymd",strtotime($payee["dt_lender_aquisition"])):"";
												$content .= pad_blank_space($date,8);
												//Description of Property
												$content .= pad_blank_space($payee["s_description_property"],39);
												$content .= add_blank_space(68);
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												$content .= add_blank_space(26);
												$content .= "\r";
											}
											// for 544-750 form 1099B go to page no 74
											else if($formDet[0]["s_type_of_return"]=='B')
											{
												//Second TIN Notice (Optional) either 2 or left blank
												$content .= pad_blank_space(2,1);
												//Noncovered Security Indicator
												$content .= pad_blank_space('',1);
												//Type of Gain or Loss Indicator
												$content .= pad_blank_space('',1);
												//Gross Proceeds Indicator
												$content .= pad_blank_space('',1);
												//Date Sold or Disposed
												$content .= pad_blank_space('',8);
												//CUSIP Number
												$content .= pad_blank_space('',13);
												//Description of Property
												$content .= pad_blank_space($payee["s_description_property"],39);
												//Date Acquired
												$content .= pad_blank_space('',8);
												//Loss Not Allowed Indicator
												$content .= pad_blank_space('',1);
												//Applicable check box of Form 8949
												$content .= pad_blank_space('',1);
												//Code, if any
												$content .= pad_blank_space('',1);
												$content .= add_blank_space(44);
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												//State Income Tax Withheld
												$content .= addZeroLeftPrice(0,12);
												//Local Income Tax Withheld
												$content .= addZeroLeftPrice(0,12);
												//Combined Federal/State Code
												$content .= pad_blank_space('',2);
												$content .= "\r";
												
											}
											// for 544-750 form 1099C go to page no 79
											else if($formDet[0]["s_type_of_return"]=='5')
											{
												$content .= add_blank_space(3);
												//Identifiable Event Code
												$content .= pad_blank_space('',1);
												//Date of Identifiable Event
												$content .= pad_blank_space('',8);
												//Debt Description
												$content .= pad_blank_space('',39);
												//Personal Liability Indicator
												$content .= pad_blank_space('',1);
												//Blank
												$content .= add_blank_space(67);
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												//Blank
												$content .= add_blank_space(26);
												$content .= "\r";
												
											}
											// for 544-750 form 1099CAP go to page no 80
											else if($formDet[0]["s_type_of_return"]=='P')
											{
												$content .= add_blank_space(4);
												//Date of Sale or Exchange
												$content .= pad_blank_space('',8);
												//Blank
												$content .= add_blank_space(52);
												//Number of Shares Exchanged
												$content .= addZeroLeft('',8);
												//Classes of Stock Exchanged
												$content .= pad_blank_space('',8);
												// Blank
												$content .= add_blank_space(37);
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												//Blank
												$content .= add_blank_space(26);
												$content .= "\r";
												
											}
											// for 544-750 form 1099DIV go to page no 81
											else if($formDet[0]["s_type_of_return"]=='1')
											{
												//Second TIN Notice (Optional)
												$content .= pad_blank_space('',1);
												//Blank
												$content .= add_blank_space(2);
												//Foreign Country or U.S. Possession
												$content .= pad_blank_space('',40);
												//FATCA Filing Requirement Indicator
												$content .= pad_blank_space('',1);
												// Blank
												$content .= add_blank_space(75);
												// Special data
												$content .= pad_blank_space($payee["s_special_data"],60);
												//State Income Tax Withheld													
												$content .= addZeroLeftPrice(0,12);
												//Local Income Tax Withheld
												$content .= addZeroLeftPrice(0,12);
												//Combined Federal/State Code
												$content .= pad_blank_space('',2);
												$content .= "\r";
												
											}
											// for 544-750 form 1099G go to page no 83
											else if($formDet[0]["s_type_of_return"]=='F')
											{
												//Blank
												$content .= add_blank_space(3);
												//Trade or Business Indicator
												$content .= pad_blank_space('',1);
												//Tax Year of Refund (need to check with other params)
												$content .= pad_blank_space('',4);													
												//Blank
												$content .= add_blank_space(111);
												// Special data
												$content .= pad_blank_space($payee["s_special_data"],60);
												//State Income Tax Withheld													
												$content .= addZeroLeftPrice(0,12);
												//Local Income Tax Withheld
												$content .= addZeroLeftPrice(0,12);
												//Combined Federal/State Code
												$content .= pad_blank_space('',2);
												$content .= "\r";
												
											}
											// for 544-750 form 1099INT go to page no 84
											else if($formDet[0]["s_type_of_return"]=='6')
											{
												//Second TIN Notice (Optional) either 2 or left blank
												$content .= pad_blank_space('',1);
												$content .= add_blank_space(2);
												//Foreign Country or U.S. Possession
												$content .= pad_blank_space('',40);
												//CUSIP Number
												$content .= pad_blank_space('',13);
												//FATCA Filing Requirement Indicator
												$content .= pad_blank_space('',1);
												$content .= add_blank_space(62);
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												//State Income Tax Withheld
												$content .= addZeroLeftPrice(0,12);
												//Local Income Tax Withheld
												$content .= addZeroLeftPrice(0,12);
												//Combined Federal/State Code
												$content .= pad_blank_space('',2);
												$content .= "\r";
												
											}
											// for 544-750 form 1099K/1099KT go to page no 85
											else if($formDet[0]["s_type_of_return"]=='MC')
											{
												//Second TIN Notice (Optional)
												$content .= pad_blank_space('',1);
												//Blank
												$content .= add_blank_space(2);
												//Type of Filer Indicator (need to  check)
												$content .= pad_blank_space('',1);
												//Type of Payment Indicator
												$content .= pad_blank_space('',1);
												//Number of Payment Transactions
												$content .= addZeroLeft(0,13);
												// Blank
												$content .= add_blank_space(3);
												//Payment Settlement Entity’s Name and Phone Number
												$content .= pad_blank_space('',40);
												//Merchant Category Code (MCC)
												$content .= addZeroLeft(0,4);
												// Blank
												$content .= add_blank_space(54);
												// Special data
												$content .= pad_blank_space($payee["s_special_data"],60);
												//State Income Tax Withheld													
												$content .= addZeroLeftPrice(0,12);
												//Local Income Tax Withheld
												$content .= addZeroLeftPrice(0,12);
												//Combined Federal/State Code
												$content .= pad_blank_space('',2);
												$content .= "\r";
												
											}
											// for 544-750 form 1099LTC go to page no 87
											else if($formDet[0]["s_type_of_return"]=='T')
											{
												//Blank
												$content .= add_blank_space(3);
												//Type of Payment Indicator (need to  check)
												$content .= pad_blank_space('',1);
												//Social Security Number of Insured
												$content .= pad_blank_space($payee["s_payee_tin"],9);
												//Name of Insured
												$content .= pad_blank_space($fullname,40);
												//Address of Insured
												$content .= pad_blank_space($payee["s_payee_shipping_address"],40);
												// City of Insured
												$content .= pad_blank_space($payee["s_payee_city"],40);
												//State of Insured
												$content .= pad_blank_space($payee["s_payee_state"],2);
												//Insured ZIP Code
												$content .= pad_blank_space($payee["s_payee_zip_code"],9);
												//Status of Illness Indicator (need to  check)
												$content .= pad_blank_space('',1);
												//Date Certified
												$content .= pad_blank_space('',8);
												//Qualified Contract Indicator
												$content .= pad_blank_space('',1);
												//Blank
												$content .= add_blank_space(25);
												//State Income Tax Withheld													
												$content .= addZeroLeftPrice(0,12);
												//Local Income Tax Withheld
												$content .= addZeroLeftPrice(0,12);
												//Combined Federal/State Code
												$content .= pad_blank_space('',2);
												$content .= "\r";
												
											}												
											// for 544-750 form 1099MISC go to page no 89
											else if($formDet[0]["s_type_of_return"]=='A')
											{
												//Second TIN Notice (Optional)
												$content .= pad_blank_space('',1);
												//Blank
												$content .= add_blank_space(2);
												//Direct Sales Indicator (need to  check)
												$content .= pad_blank_space('',1);
												//FATCA Filing Requirement Indicator
												$content .= pad_blank_space('',1);
												// Blank
												$content .= add_blank_space(114);
												// Special data
												$content .= pad_blank_space($payee["s_special_data"],60);
												//State Income Tax Withheld													
												$content .= addZeroLeftPrice(0,12);
												//Local Income Tax Withheld
												$content .= addZeroLeftPrice(0,12);
												//Combined Federal/State Code
												$content .= pad_blank_space('',2);
												$content .= "\r";
												
											}	
											// for 544-750 form 1099OID go to page no 90
											else if($formDet[0]["s_type_of_return"]=='D')
											{
												//Second TIN Notice (Optional)
												$content .= pad_blank_space('',1);
												//Blank
												$content .= add_blank_space(2);
												//Description (need to check)
												$content .= pad_blank_space('',39);
												//FATCA Filing Requirement Indicator
												$content .= pad_blank_space('',1);
												//Blank
												$content .= add_blank_space(76);
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												//State Income Tax Withheld													
												$content .= addZeroLeftPrice(0,12);
												//Local Income Tax Withheld
												$content .= addZeroLeftPrice(0,12);
												//Combined Federal/State Code
												$content .= pad_blank_space('',2);
												$content .= "\r";
												
											}	
											// for 544-750 form 1099PATR go to page no 92
											else if($formDet[0]["s_type_of_return"]=='7')
											{
												//Second TIN Notice (Optional)
												$content .= pad_blank_space('',1);
												//Blank
												$content .= add_blank_space(118);
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												//State Income Tax Withheld													
												$content .= addZeroLeftPrice(0,12);
												//Local Income Tax Withheld
												$content .= addZeroLeftPrice(0,12);
												//Combined Federal/State Code
												$content .= pad_blank_space('',2);
												$content .= "\r";
												
											}	
											// for 544-750 form 1099Q go to page no 93
											else if($formDet[0]["s_type_of_return"]=='Q')
											{
												//Blank
												$content .= add_blank_space(3);
												// Trustee to Trustee Transfer Indicator (need to check all)
												$content .= pad_blank_space('',1);
												//Type of Tuition Payment
												$content .= pad_blank_space('',1);
												//Designated Beneficiary
												$content .= pad_blank_space('',1);
												//Blank
												$content .= add_blank_space(113);
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												//Blank
												$content .= add_blank_space(26);
												$content .= "\r";
												
											}		
											// for 544-750 form 1099R go to page no 94
											else if($formDet[0]["s_type_of_return"]=='9')
											{
												//Blank
												$content .= add_blank_space(1);
												// Distribution Code (need to check all)
												$content .= pad_blank_space('',2);
												// Taxable Amount Not Determined Indicator
												$content .= pad_blank_space('',1);
												//IRA/SEP/SIMPLE Indicator
												$content .= pad_blank_space('',1);
												//Total Distribution Indicator
												$content .= pad_blank_space('',1);
												//Percentage of Total Distribution
												$content .= pad_blank_space('',2);
												//First Year of Designated Roth Contribution
												$content .= pad_blank_space('',4);
												//Blank
												$content .= add_blank_space(107);
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												//State Income Tax Withheld													
												$content .= addZeroLeftPrice(0,12);
												//Local Income Tax Withheld
												$content .= addZeroLeftPrice(0,12);
												//Combined Federal/State Code
												$content .= pad_blank_space('',2);
												$content .= "\r";
												
											}	
											// for 544-750 form 1099S go to page no 99
											else if($formDet[0]["s_type_of_return"]=='S')
											{
												//Blank
												$content .= add_blank_space(3);
												// Distribution Code (need to check all)
												$content .= pad_blank_space('',2);
												
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												//State Income Tax Withheld													
												$content .= addZeroLeftPrice(0,12);
												//Local Income Tax Withheld
												$content .= addZeroLeftPrice(0,12);
												//Blank
												$content .= add_blank_space(2);
												$content .= "\r";
												
											}	
											// for 544-750 form 5498 go to page no 112 nearly
											else if($formDet[0]["s_type_of_return"]=='L')
											{
												//Blank
												$content .= add_blank_space(3);
												// IRA Indicator (Individual Retirement Account) (need to check all)
												$content .= pad_blank_space('',1);
												// SEP Indicator (Simplified Employee Pension) (need to check all)
												$content .= pad_blank_space('',1);
												// SIMPLE Indicator (Savings Incentive Match Plan for Employees) (need to check all)
												$content .= pad_blank_space('',1);
												// Roth IRA Indicator (need to check all)
												$content .= pad_blank_space('',1);
												// RMD Indicator put 1 if 2017 (need to check all)
												$content .= pad_blank_space('',1);
												// Year of Postponed Contribution (need to check all)
												$content .= pad_blank_space('',4);
												//Postponed Contribution Code // check needed
												$content .= pad_blank_space('',2);
												//Postponed Contribution Reason
												$content .= pad_blank_space('',6);
												//Repayment Code 
												$content .= pad_blank_space('',2);
												//RMD Date YYYYMMDD
												$content .= pad_blank_space('',8);
												//Codes
												$content .= pad_blank_space('',2);
												//Blank
												$content .= pad_blank_space('',87);												
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												//Blank
												$content .= pad_blank_space('',24);	
												//Combined Federal/State Code
												$content .= pad_blank_space('',2);
												//Blank
												$content .= "\r";
												
											}	
											// for 544-750 form 5498ESA go to page no 114 nearly
											else if($formDet[0]["s_type_of_return"]=='V')
											{
												//Blank
												$content .= add_blank_space(119);											
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												//Blank
												$content .= pad_blank_space('',26);	
												//Combined Federal/State Code
												$content .= pad_blank_space('',2);
												//Blank
												$content .= "\r";
												
											}	
											// for 544-750 form 5498SA go to page no 115 nearly
											else if($formDet[0]["s_type_of_return"]=='K')
											{
												//Blank
												$content .= add_blank_space(3);	
												//Medicare Advantage MSA Indicator
												$content .= pad_blank_space('',1); // need to check all		
												//HSA Indicator
												$content .= pad_blank_space('',1); 
												//Archer MSA Indicator
												$content .= pad_blank_space('',1); 	
												//Blank
												$content .= add_blank_space(113);								
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												//Blank
												$content .= pad_blank_space('',26);	
												//Combined Federal/State Code
												$content .= pad_blank_space('',2);
												//Blank
												$content .= "\r";
												
											}		
											// for 544-750 form 1098 go to page no 72 nearly
											else if($formDet[0]["s_type_of_return"]=='3')
											{												
												//Mortgage Origination Date
												$content .= pad_blank_space('',8); // need to check all		
												//Property Securing Mortgage Indicator
												$content .= pad_blank_space('',1); 
												//Property Address Securing Mortgage
												$content .= pad_blank_space('',39); 	
												//Description of Property
												$content .= pad_blank_space('',39); 
												//Other	
												$content .= pad_blank_space('',39); 							
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												//Blank
												$content .= pad_blank_space('',26);	
												//Combined Federal/State Code
												//$content .= pad_blank_space('',2);
												//Blank
												$content .= "\r";
												
											}	
											// for 544-750 form 1098-C go to page no 74 nearly
											else if($formDet[0]["s_type_of_return"]=='X')
											{			
												//Blank
												$content .= add_blank_space(2);	
												//Transaction Indicator	
												$content .= pad_blank_space('',1); // need to check all	
												// Transfer After Improvements Indicator	
												$content .= pad_blank_space('',1); 	
												//Transfer Below Fair Market Value Indicator
												$content .= pad_blank_space('',1); 	
												//Year
												$content .= pad_blank_space('',4); 	
												//Make
												$content .= pad_blank_space('',13); 	
												//Model
												$content .= pad_blank_space('',22); 	
												//Vehicle or Other Identification Number
												$content .= pad_blank_space('',25); 
												//Vehicle Description	
												$content .= pad_blank_space('',39); 
												//Date of Contribution	
												$content .= pad_blank_space('',8); 	
												//Donee Indicator
												$content .= pad_blank_space('1',1); // need to check again 	
												//Intangible Religious Benefits Indicator
												$content .= pad_blank_space('',1);
												//Deduction $500 or Less Indicator
												$content .= pad_blank_space('',1);							
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												//Date of Sale
												$content .= pad_blank_space('',8);	
												//Goods and Services
												$content .= pad_blank_space('',16);
												//Blank
												$content .= add_blank_space(2);
												//Blank
												$content .= "\r";
												
											}		
											// for 544-750 form 1098-E go to page no 76 nearly
											else if($formDet[0]["s_type_of_return"]=='2')
											{			
												//Blank
												$content .= add_blank_space(3);	
												//Origination Fees/Capitalized Interest Indicator	
												$content .= pad_blank_space('',1); // need to check all													
												//Blank
												$content .= add_blank_space(115);							
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												//Blank
												$content .= add_blank_space(26);
												//Blank
												$content .= "\r";
												
											}		
											// for 544-750 form 1098-T go to page no 78 nearly
											else if($formDet[0]["s_type_of_return"]=='8')
											{			
												//TIN Certification
												$content .= pad_blank_space('',1); // need to check all	
												//Blank
												$content .= add_blank_space(2);	
												//Half-time Student Indicator	
												$content .= pad_blank_space('',1); 		
												//Graduate Student Indicator										
												$content .= pad_blank_space('',1); 	
												// Academic Period Indicator											
												$content .= pad_blank_space('',1); 	
												//Method of Reporting Amounts Indicator											
												$content .= pad_blank_space('',1); 												
												//Blank
												$content .= add_blank_space(112);							
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												//Blank
												$content .= add_blank_space(26);
												//Blank
												$content .= "\r";
												
											}			
											// for 544-750 form W-2G go to page no 116 nearly
											else if($formDet[0]["s_type_of_return"]=='W' || $formDet[0]["s_type_of_return"]=='W2C' || $formDet[0]["s_type_of_return"]=='W2' )
											{	
												//Blank
												$content .= add_blank_space(3);	
												//Type of Wager Code	
												$content .= pad_blank_space('', 1); 		
												//Date Won										
												$content .= pad_blank_space('', 8); 	
												// Transaction											
												$content .= pad_blank_space('', 15); 	
												//Race											
												$content .= pad_blank_space('', 5); 												
												//Cashier
												$content .= pad_blank_space('', 5);	
												//Window						
												$content .= pad_blank_space('', 5);	
												//First ID						
												$content .= pad_blank_space('', 15);	
												//Second ID						
												$content .= pad_blank_space('', 15);	
												//Blank
												$content .= add_blank_space(47);							
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												//State Income Tax Withheld Total
												$content .=addZeroLeft(0,12);
												//Local Income Tax Withheld Total
												$content .=addZeroLeft(0,12);
												//Blank
												$content .= add_blank_space(2);	
												//Blank
												$content .= "\r";
												
											}	
											else if($formDet[0]["s_type_of_return"]==940 || $formDet[0]["s_type_of_return"]==941 || $formDet[0]["s_type_of_return"]==944 )
											{
												// 94X series do nothing for now
											}					
											// default 1099A
											else 
											{
												$content .= add_blank_space(3);
												//Personal Liability Indicator
												$content .= pad_blank_space($payee["s_personal_liability"],1);
												//Date of Lenders Acquisition or Knowledge of Abandonment
												$date = $payee["dt_lender_aquisition"]?date("Ymd",strtotime($payee["dt_lender_aquisition"])):"";
												$content .= pad_blank_space($date,8);
												//Description of Property
												$content .= pad_blank_space($payee["s_description_property"],39);
												$content .= add_blank_space(68);
												//Special Data Entries
												$content .= pad_blank_space($payee["s_special_data"],60);
												$content .= add_blank_space(26);
												$content .= "\r";
											}
											
											//+++++++ FORM WISE DIFFERENT line no 544 - 750 +++++++
											// *************************** END PAYEE (B) RECORD  ********************** //
											
										}
									
										// update table with change status
										$arr_cond = array();
										$arr_cond = array('i_payer_id'=>$a_info[$i]['i_id'], 's_form_id'=>$formID, 'i_payee_id='=>$payee["i_id"]);
										$chng_arr = array();
										$chng_arr['i_status'] = 1;
										$chng_arr['dt_updated'] = now();
										//$i_aff = $this->acs_model->edit_data($this->tbl_history, $chng_arr, $arr_cond);
									
									}
									
								}
							}
							// NOW GET PAYEE LIST WHO DOES NOT HAVE PRINT THIS FORM YET
							
							
						
							// *************************** END OF PAYER (C) RECORD START  ********************** //
							$content .= 'C';
							//$tot_payee = count($b_info);
							$content .= addZeroLeft($tot_payee_this_form,8);
							$content .= add_blank_space(6);
							
							// control total. please calculate later page 110 in pdf				
							$content .=addZeroLeftPrice($c_rec_amount1,18);
							$content .=addZeroLeftPrice($c_rec_amount2,18);
							$content .=addZeroLeftPrice($c_rec_amount3,18);
							$content .=addZeroLeftPrice($c_rec_amount4,18);
							$content .=addZeroLeftPrice($c_rec_amount5,18);
							$content .=addZeroLeftPrice($c_rec_amount6,18);
							$content .=addZeroLeftPrice($c_rec_amount7,18);
							$content .=addZeroLeftPrice($c_rec_amount8,18);
							$content .=addZeroLeftPrice($c_rec_amount9,18);
							$content .=addZeroLeftPrice($c_rec_amount10,18);
							$content .=addZeroLeftPrice($c_rec_amount11,18);
							$content .=addZeroLeftPrice($c_rec_amount12,18);
							$content .=addZeroLeftPrice($c_rec_amount13,18);
							$content .=addZeroLeftPrice($c_rec_amount14,18);
							$content .=addZeroLeftPrice($c_rec_amount15,18);
							$content .=addZeroLeftPrice($c_rec_amount16,18);
							
							
							$content .= add_blank_space(196);
							//Record Sequence Number				
							$record_seq_no = addZeroLeft(($record_seq_no+1),8);
							$content .=$record_seq_no;
							
							$content .= add_blank_space(241);
							$content .= "\r";
							// *************************** END OF PAYER (C) RECORD END  ********************** //
							
							// *************************** STATE (K) RECORD START  ********************** //
							$k_record_str = trim($k_record_str, ',');
							$k_record_tot_rec = explode(',', $k_record_str);
							if($k_record_str!='')
							{									
								$sql_k = "SELECT s_payee_state, COUNT(i_id) AS total_state, SUM(s_payment_amount1) AS amount1, SUM(s_payment_amount2) AS amount2, 
										SUM(s_payment_amount3) AS amount3, SUM(s_payment_amount4) AS amount4, SUM(s_payment_amount5) AS amount5, 
										SUM(s_payment_amount6) AS amount6, SUM(s_payment_amount7) AS amount7, SUM(s_payment_amount8) AS amount8,
										SUM(s_payment_amount9) AS amount9, SUM(s_payment_amount10) AS amount10, SUM(s_payment_amount11) AS amount11,
										SUM(s_payment_amount12) AS amount12, SUM(s_payment_amount13) AS amount13, SUM(s_payment_amount14) AS amount14,
										SUM(s_payment_amount15) AS amount15, SUM(s_payment_amount16) AS amount16
										FROM  {$this->tbl_payee} 
										WHERE i_id IN(".$k_record_str.") GROUP BY s_payee_state ";
							
								$k_info = $this->acs_model->exc_query($sql_k, true);
								for($k = 0; $k < count($k_info) ; $k++)
								{										
									$content .= 'K';
									//Number of Payees State wise
									$content .=addZeroLeft($k_info[$k]['total_state'],8);
									$content .= add_blank_space(6);
									
									// control total. please calculate later page 112 in pdf				
									$content .=addZeroLeftPrice($k_info[$k]['amount1'],18);
									$content .=addZeroLeftPrice($k_info[$k]['amount2'],18);
									$content .=addZeroLeftPrice($k_info[$k]['amount3'],18);
									$content .=addZeroLeftPrice($k_info[$k]['amount4'],18);
									$content .=addZeroLeftPrice($k_info[$k]['amount5'],18);
									$content .=addZeroLeftPrice($k_info[$k]['amount6'],18);
									$content .=addZeroLeftPrice($k_info[$k]['amount7'],18);
									$content .=addZeroLeftPrice($k_info[$k]['amount8'],18);
									$content .=addZeroLeftPrice($k_info[$k]['amount9'],18);
									$content .=addZeroLeftPrice($k_info[$k]['amount10'],18);
									$content .=addZeroLeftPrice($k_info[$k]['amount11'],18);
									$content .=addZeroLeftPrice($k_info[$k]['amount12'],18);
									$content .=addZeroLeftPrice($k_info[$k]['amount13'],18);
									$content .=addZeroLeftPrice($k_info[$k]['amount14'],18);
									$content .=addZeroLeftPrice($k_info[$k]['amount15'],18);
									$content .=addZeroLeftPrice($k_info[$k]['amount16'],18);
									// balcnk space 196
									$content .= add_blank_space(196);
									//Record Sequence Number				
									$record_seq_no = addZeroLeft(($record_seq_no+1),8);
									$content .=$record_seq_no;
									$content .= add_blank_space(199);
									//State Income Tax Withheld Total
									$content .=addZeroLeft(0,18);
									//Local Income Tax Withheld Total
									$content .=addZeroLeft(0,18);
									$content .= add_blank_space(4);
									//Combined Federal/ State Code
									$state = '27';
									$content .= pad_blank_space($state,15);
									$content .= "\r";
									
								}
							}
							
							// *************************** STATE (K) RECORD END  ********************** //
						
							
							
						}
						// *************************** END PAYER (A) RECORD  ********************** //
						}
					}
				} // end if not empty forms
				// NOW CHECK FOR FORMS
				
				// *************************** END OF TANSMITTER (F) RECORD START  ********************** //
				$content .= 'F';
				//Number of “A” Records
				//$tot_payer = 1;
				$content .= addZeroLeft($tot_payer,8);
				//Zero
				$content .= addZeroLeft(0,21);
				$content .= add_blank_space(19);
				//Total Number of Payees
				//$tot_payee = count($k_record_tot_rec);
				$content .= addZeroLeft($tot_payee,8);
				$content .= add_blank_space(442);
				//Record Sequence Number				
				$record_seq_no = addZeroLeft(($record_seq_no+1),8);
				$content .=$record_seq_no;
				
				$content .= add_blank_space(241);
				$content .= "\r";
				// *************************** END OF TANSMITTER (F) RECORD END  ********************** //					
				//exit;
				$content = file_put_contents($file, $content);
				
				// START store downloaded file history information like batch ids, date etc.
				if(!empty($batchs))
				{
					$batchStr = implode(',', $batchs);					
					$fileArr = array();
					$fileArr["s_batch_ids"] 	= $batchStr;
					$fileArr["s_file"] 			= basename($file);
					$fileArr["i_created_by"]	= $this->user_id;
					//$fileArr["i_owner_id"]		= $this->user_id; // 21 July, 2017 to see user wise records NOT USED
					
					$i_file_pk = $this->acs_model->add_data($this->tbl_batch_ascii_file, $fileArr);
					if($i_file_pk)
					{
						$mapArr = array();
						$mapArr["i_file_pk"]	= $i_file_pk;
						foreach($batchs as $fv)
						{
							$mapArr["s_batch_id"]	= $fv;
							$this->acs_model->add_data($this->tbl_batch_files_download_mapping, $mapArr);
							$this->acs_model->edit_data($this->tbl,array('i_processed'=>1), array('s_batch_id' => $fv));
						}
					}
				}
				// END store downloaded file history information like batch ids, date etc.
					
				// for force download
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename($org_name));
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file));
				readfile($file);
				exit;				
				
				#set_success_msg($this->cls_msg["save_succ"]);
				#redirect($this->pathtoclass."modify_information");
				
			//}  // end else validation
		}
	
        else
        {
			redirect($this->pathtoclass."show_list?h_search=");
		}
        //pr($batch_info);    
    }
    
 // Fetch batch status to change it manually
    public function ajax_fetch_batch_current_status()
    {
        $res = array('status' => 'error', 'html' => '', 'msg' => 'Something going wrong.');
        $batch_id = intval($this->input->post('batch_id', true));
        if($batch_id > 0)
        {
            // Info details
            $status = $this->acs_model->fetch_data($this->tbl, array('i_id' => $batch_id), 'i_status, s_batch_id, s_username');            
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
        $info['i_status'] = $st = intval($this->input->post('status', true));
        if($batch_id > 0)
        {
			$info["dt_change_status"] = date("Y-m-d H:i:s");
            if($this->acs_model->edit_data($this->tbl, $info, array('i_id' => $batch_id)))
			{
				$res['status'] 	= 'success';
				$res['msg'] 	= get_message('save_success');				
				$res['href'] 	= $this->pathtoclass.'show_list';

				// Add batch history
				$logArr = array();
				$logArr["s_batch_id"] 	= _getBatchIdCode($batch_id);
				//$logArr["s_action"] 	= 'Batch status change to '._batchStatus($info['i_status']);
				$logArr["s_action"] 	= _batchStatus($info['i_status']);
				$logArr["s_comment"] 	= $comment;
				$logArr["i_status"] 	= $info['i_status']; // first status
				$logArr["i_created_by"] = $this->user_id ; // loggedin users id
				
				$this->acs_model->add_data($this->tbl_batch_status_history, $logArr);				
					
				//*********** send email to the customer sending him the batch number and current status 10 Nov, 2016 **********//
				// see @https://shieldwatch.teamwork.com/messages/568694?scrollTo=pmp1634382
				$user_email = '';
				$batchInfo = $this->acs_model->fetch_data( $this->tbl,  array('i_id' => $batch_id));
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
					
					if($_SERVER['SERVER_NAME']=='stagingapi.ams.com')
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
			unset($info, $comment, $batch_id, $status,$tmp);
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
