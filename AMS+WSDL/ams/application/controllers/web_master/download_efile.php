<?php
/*********
* Author: SWI
* Date  : 22 June 2016
* Modified By: 
* Modified Date:
* Purpose:
* Controller For Download eFile
* @package Content Management
* @subpackage Download_efile
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/Download_efile/
*/

class Download_efile extends MY_Controller
{
    public $cls_msg;//All defined error messages. 
    public $pathtoclass;
    public $tbl_history, $tbl_payee, $tbl_payer, $tbl_form;
   
	
    public function __construct()
    {
            
		try
		{
			parent::__construct();
			//Define Errors Here//
			$this->data['title']=addslashes(t("Download File"));//Browser Title
			$this->tbl_payer 	= $this->db-> PAYER_INFO;
			$this->tbl_payee 	= $this->db-> PAYEE_INFO;
			$this->tbl_history 	= $this->db-> FORMS_PAYER_PAYEE_HISTORY;
			$this->tbl_form 	= $this->db-> FORM_MASTER;

			//Define Errors Here//
			$this->cls_msg = array();
			$this->cls_msg["no_result"] 	= get_message('no_result');
			$this->cls_msg["save_err"] 		= get_message('save_failed');
			$this->cls_msg["save_succ"] 	= get_message('save_success');
			$this->cls_msg["delete_err"] 	= get_message('del_failed');
			$this->cls_msg["delete_succ"] 	= get_message('del_success');

			//end Define Errors Here//
			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
			//$this->load->model("site_setting_model","mod_rect");
			// end loading default model here //
		 
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
            $this->data['title']	=	addslashes(t("Download"));//Browser Title
            $this->data['heading']	=	addslashes(t("Download"));
			
            //In case of site setting there no list tpl admin can only edit the data .
            //so modify information function call directly
			$this->modify_information();
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
    public function show_list()
    {
        try
        {
          //Put the select statement here
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
          //Put the select statement here
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
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
            $this->data['pathtoclass']	=	$this->pathtoclass;
            $this->data['mode']			=	"edit";
            $this->data['heading']		=	addslashes(t("Download"));
			
			$this->data['BREADCRUMB']	=	array('Download');
            //Submitted Form//
            if($_POST)
            {
				$posted		= array();
                $posted 	= $_POST;	           
                $batchs 	= $posted['s_batch_id'];
                               				 
                $this->form_validation->set_rules('h_set',addslashes(t('number')),'trim|required');   
                
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
                
						
				//pr($forms,1);
				//exit;				
				
                if($this->form_validation->run() == FALSE)///invalid
                {
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {						
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
						
					// for force download
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename='.basename($org_name));
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));
					readfile($file);
					exit;				
					
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
    
        
    public function modify_information_bk27sept2016($i_id=0)
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
                //$this->form_validation->set_rules('i_form_id',addslashes(t('form')),'required');      
                //$this->form_validation->set_rules('i_payer_id',addslashes(t('payer')),'required'); 
				
				//$org_form_id = $posted['i_form_id'];
				//$posted['i_form_id'] ='1099A';
				$forms 	= $posted['i_form_id'];
				$payers = $posted['i_payer_id'];
				$payees = $posted['i_payee_id'];
				$posted['payer_ids'] 	= implode(',', $posted['i_payer_id']);
				$posted['payee_ids'] 	= implode(',', $posted['i_payee_id']);
				$posted['form_ids'] 	= implode(',', $posted['i_form_id']);
				$info	=	array();
				//$tot_payee = count($payees);
				$tot_payer = count($payers);
				$sql = "SELECT COUNT(n.i_id) AS tot_payee FROM {$this->tbl_history} AS n
						WHERE n.i_id IN(".$posted['payee_ids'].")  
						GROUP BY n.i_payee_id ";
				$tot_payee_info = $this->acs_model->exc_query($sql, true);
				$tot_payee = count($tot_payee_info);
				
                if($this->form_validation->run() == FALSE)///invalid
                {
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {						
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
					if($posted['payer_ids'])
					{
						$sql = "SELECT * FROM {$this->tbl_payer} WHERE i_id IN(".$posted['payer_ids'].") ";	
						$a_info = $this->acs_model->exc_query($sql, true);	
						//pr($a_info,1);
					}
					
					if($forms)
					{
						foreach($forms as $f)
						{							
							$formTitle 	= _form_title($f);
							$formDet 	= array();
							$formID 	= $f;
							$formDet 	= $this->acs_model->fetch_data($this->tbl_form, array('i_id'=>$f));
							// *************************** START PAYER (A) RECORD  ********************** //
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
								$amount_codes = $a_info[$i]["s_amount_codes"]?$a_info[$i]["s_amount_codes"]:"24";
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
								if($posted['payee_ids'])
								{										
									#$sql = "SELECT * FROM {$this->tbl_payee} WHERE i_id IN(".$posted['payee_ids'].") ";	
									$sql = "SELECT p.*, n.s_form_id, n.dt_added, n.i_status, n.i_payee_id FROM {$this->tbl_history} AS n
											LEFT JOIN {$this->tbl_payee} AS p ON p.i_id = n.i_payee_id
											WHERE n.i_id IN(".$posted['payee_ids'].") AND n.i_payer_id='".$a_info[$i]['i_id']."' AND n.s_form_id='".$formID."' 
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
												else // default 1099A
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
						
					// for force download
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename='.basename($org_name));
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));
					readfile($file);
					exit;				
					
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
    
    function ajax_get_all_payee_AJAX()
    {
        $payerID = $this->input->post('payerID');
        $formsID = $this->input->post('formsID');
        //pr($formsID);        
        // test query   
		$forms_str = implode(',', $formsID);
		$payer_str = implode(',', $payerID);
		
		if($payer_str)
		{
			$s_qry="SELECT n.i_id, n.s_form_id, n.i_payer_id, n.i_payee_id, n.i_status, n.dt_added, p.i_id AS payee_id, p.s_first_payee_name_line, p.s_last_payee_name_line, f.s_form_title "				
                ."FROM {$this->tbl_history} AS n "
                ." LEFT JOIN {$this->tbl_payee} AS p ON p.i_id = n.i_payee_id "
                ." LEFT JOIN {$this->tbl_form} AS f ON f.i_id = n.s_form_id "
                ." WHERE n.i_status = 0 AND n.i_payer_id IN(".$payer_str.") AND n.s_form_id IN(".$forms_str.")
                ORDER BY p.s_first_payee_name_line ";
            
            $res=$this->db->query($s_qry); 
			$mix_value = $res->result_array();
			if($mix_value)
			{
				foreach ($mix_value as $val)
				{
					$s_select = '';
					if($val["i_id"] == $s_id)
						$s_select = " selected ";
					$name = $val["s_first_payee_name_line"].($val["s_last_payee_name_line"]?' '.$val["s_last_payee_name_line"].' ('.$val["s_form_title"].')':"");
					$s_option .= "<option $s_select value='".$val["i_id"]."' >".$name."</option>";
				}
			}
			
			echo   ''.$s_option ;			
		}
		/*
		if($payer_str)
		{
			$s_qry="SELECT i_id, s_first_payee_name_line, s_last_payee_name_line "
                ."FROM {$this->tbl_payee} "
                ." WHERE i_status = 1 AND i_payer_id IN(".$payer_str.") 
                AND i_id NOT IN
                (
					SELECT i_payee_id FROM {$this->tbl_history} WHERE i_payer_id IN(".$payer_str.") AND s_form_id IN(".$forms_str.")
                )
                ORDER BY s_first_payee_name_line";
            
            $res=$this->db->query($s_qry); 
			$mix_value = $res->result_array();
			if($mix_value)
			{
				foreach ($mix_value as $val)
				{
					$s_select = '';
					if($val["i_id"] == $s_id)
						$s_select = " selected ";
					$name = $val["s_first_payee_name_line"].($val["s_last_payee_name_line"]?' '.$val["s_last_payee_name_line"]:"");
					$s_option .= "<option $s_select value='".$val["i_id"]."' >".$name."</option>";
				}
			}
			
			echo   ''.$s_option ;
		}*/
       
    }


    /***
    * Method to Delete information
    * This have no interface but db operation 
    * will be done here.
    * 
    * On Success redirect to the showList interface else display error in showList interface. 
    * @param int $i_id, id of the record to be modified.
    */      
    public function remove_information($i_id=0)
    {
        try
        {
          
          //Put the select statement here
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
    public function show_detail($i_id=0)
    {
        try
        {

			//Put the select statement here
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }   
	
	  
    
	public function __destruct()
    {}
}
