<?php
public function modify_information_bk24june2016($i_id=0)
    {
        try
        {
            $this->data['pathtoclass']	=	$this->pathtoclass;
            $this->data['mode']			=	"edit";
            $this->data['heading']		=	addslashes(t("Download"));
			
			$this->data['BREADCRUMB']	=	array('Download');
            //Submitted Form//
            if($_POST)
            {
				$posted=array();
                $posted = $_POST;	        
                               				 
                $this->form_validation->set_rules('h_set',addslashes(t('number')),'trim|required');      
                $this->form_validation->set_rules('i_form_id',addslashes(t('form')),'trim|required');      
                $this->form_validation->set_rules('i_payer_id',addslashes(t('payer')),'trim|required'); 
				
				$org_form_id = $posted['i_form_id'];
				$posted['i_form_id'] ='1099A';
				$posted['payee_ids'] = implode(',', $posted['i_payee_id']);
				$info	=	array();
				//pr($posted,1);
                if($this->form_validation->run() == FALSE)///invalid
                {
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {	
					
					$t_info = $this->acs_model->fetch_data($this->db->SITESETTING, array('i_id'=>1));
					
					$sql = "SELECT * FROM {$this->db->PAYER_INFO} WHERE i_id='".$posted['i_payer_id']."' ";	
					$a_info = $this->acs_model->exc_query($sql, true);	
					//$a_info = $this->acs_model->fetch_data($this->db->PAYER_INFO,'','');	
					if($posted['payee_ids'])
					{
						//$b_info = $this->acs_model->fetch_data($this->db->PAYEE_INFO,'','');
						$sql2 = "SELECT * FROM {$this->db->PAYEE_INFO} WHERE i_id IN(".$posted['payee_ids'].") ";	
						$b_info = $this->acs_model->exc_query($sql2, true);	
					}	
					//pr($a_info);
					//pr($b_info,1);
					//echo 'Done==='; exit;
					// FORM 1099A
					if($posted['i_form_id'] =='1099A')
					{
						//$org_name = '1099A-SW-'.time().'-form.txt';
						//$org_name = '1099A-SW-efile.txt';
						$org_name = $org_form_id.'-SW-efile.txt';
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
						$amount_codes = $a_info[0]["s_amount_codes"]?$a_info[0]["s_amount_codes"]:"24";
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
						header('Content-Type: application/octet-stream');
						header('Content-Disposition: attachment; filename='.basename($org_name));
						header('Expires: 0');
						header('Cache-Control: must-revalidate');
						header('Pragma: public');
						header('Content-Length: ' . filesize($file));
						readfile($file);
						exit;

					}
				
								
                    /*$i_id = decrypt($posted["h_id"]);
                    unset($posted["h_id"]);
                    $i_aff = $this->mod_rect->edit_info($posted,$i_id);					
                    if($i_aff)//saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."modify_information");
                    }
                    else///Not saved, show the form again
                    {
                        $this->data["posted"]=$posted;
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    unset($info,$posted);*/
                    set_success_msg($this->cls_msg["save_succ"]);
                    redirect($this->pathtoclass."modify_information");
                    
                }
            }
            else
            {               
				//$info=$this->mod_rect->fetch_this("NULL"); 
                $posted=array();
                $posted = $info;	
				$posted["h_id"]         = 	trim(encrypt($info["i_id"]));
                $this->data["posted"]   =	$posted;       
                unset($info,$posted);      
                
            }
		  	$this->render('download_efile/add-edit');
		  	//$this->render();
          //Put the select statement here
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
