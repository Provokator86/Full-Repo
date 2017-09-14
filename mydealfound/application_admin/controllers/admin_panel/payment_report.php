<?php
/********** 
Author: 
* Date  : 13 May 2014
* Modified By: 
* Modified Date: 
* 
* Purpose:
* Controller For Manage Payment Report
* 
* @package Content Management
* @subpackage State
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/user_model.php
* @link views/admin/payment_report/
*/


class Payment_report extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
	public $table;
	public $tbl_cashbk_earn;

	public function __construct()
    {
      try
      {

			parent::__construct();
			$this->data['title']	= "Payment Report Management"; // Browser Title
			$this->tbl_cashbk_earn = 'cd_cashback_earned';
			//$this->data['action_allowed']["Status"]	=FALSE;
			$this->data['action_allowed']["Add"]	=FALSE;
			$this->data['action_allowed']["Edit"]	=FALSE;
			$this->data['action_allowed']["Delete"]	=FALSE;

			// Define Errors Here 
			$this->cls_msg = array();
			$this->cls_msg["no_result"]			= "No information found about report.";
			$this->cls_msg["save_err"]			= "Information about report failed to save.";
			$this->cls_msg["save_succ"]			= "Information about report saved successfully.";
			$this->cls_msg["delete_err"]		= "Report failed to remove.";
			$this->cls_msg["delete_succ"]		= "Report removed successfully.";
			$this->cls_msg["no_file"]			= "Please select a file to import.";
			// end Define Errors Here

			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/"; //for redirecting from this class
			$this->data['pathtoclass'] = $this->pathtoclass;
			$this->load->model('payment_report_model','mod_pay');
			$this->load->model('common_model','mod_common');
			
			$this->load->model("store_model");			
			$this->data['store']	= $this->store_model->get_store();

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
            //redirect($this->pathtoclass."show_list");
			echo '<script type="text/javascript">';
            echo ' window.location.href="'. $this->pathtoclass.'show_list' .'"; ';
            echo '</script>';
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    

    }


	/****
    * Display the list of records
    */

	public function show_list($order_name = '', $order_by = 'desc', $start = NULL, $limit = NULL)
    {
		try
        {           

			$this->data['heading']="Report Management";////Package Name[@package] Panel Heading

            ///////////generating search query///////		

           $arr_session_data    =    $this->session->userdata("arr_session");
            if($arr_session_data['searching_name']!=$this->data['heading'])
            {
                $this->session->unset_userdata("arr_session");
                $arr_session_data   =   array();
            }
            
            $search_variable     =    array();
            
            ////////Getting Posted or session values for search///
            $s_search 	=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
			$search_variable["product_name"] = ($this->input->post("h_search")?$this->input->post("product_name"):$arr_session_data["product_name"]);
			$search_variable["user_name"] = ($this->input->post("h_search")?$this->input->post("user_name"):$arr_session_data["user_name"]);
			$search_variable["date_start"] = ($this->input->post("h_search")?$this->input->post("date_start"):$arr_session_data["date_start"]);
			$search_variable["date_end"] = ($this->input->post("h_search")?$this->input->post("date_end"):$arr_session_data["date_end"]);
			$search_variable["i_store_id"] = ($this->input->post("h_search")?$this->input->post("i_store_id"):$arr_session_data["i_store_id"]);
		
			

            ////////end Getting Posted or session values for search///

            // $s_where=" WHERE i_user_type=2 ";/////////////////////////
			$s_where=" WHERE 1 AND e.product_name!='Cashback Earned From Registration' ";
            if($s_search=="basic")
            {
			  	
				if(trim($search_variable["product_name"])!="")
				{
					$s_where.=" AND e.product_name LIKE '%".my_receive_text($search_variable["product_name"])."%' ";
				}
				if(trim($search_variable["user_name"])!="")
				{
					//$s_where.=" AND u.s_name LIKE '%".my_receive_text($search_variable["user_name"])."%' ";
					$s_where.=" AND (u.s_name LIKE '%".my_receive_text($search_variable["user_name"])."%' OR u.s_uid LIKE '%".my_receive_text($search_variable["user_name"])."%' ) ";
				}
				if(trim($search_variable["date_start"])!="")
				{
					$dt_start=date("Y-m-d",strtotime(trim($search_variable["date_start"]." "))) ; 
                    $s_where.=" AND DATE( e.dt_of_payment) >='".$dt_start."' ";
                    unset($dt_start);
				}
				if(trim($search_variable["date_end"])!="")
				{
					$dt_end=date("Y-m-d",strtotime(trim($search_variable["date_end"]." "))) ; 
                    $s_where.=" AND DATE( e.dt_of_payment) <='".$dt_end."' ";
                    unset($dt_end);
				}
				if(trim($search_variable["i_store_id"])!="")
				{	
					$s_where.=" AND p.i_store_id = '".$search_variable["i_store_id"]."' ";
				}
				
                /////Storing search values into session///

                $arr_session    =   array();                
                $arr_session["searching_name"] 	= $this->data['heading'] ;                  
                $arr_session["product_name"]	= $search_variable["product_name"] ;
				$arr_session["user_name"] 		= $search_variable["user_name"] ;
				$arr_session["date_start"] 	   	= $search_variable["date_start"];
				$arr_session["date_end"] 	    = $search_variable["date_end"];
				$arr_session["i_store_id"] 	    = $search_variable["i_store_id"];
				
                $this->session->set_userdata("arr_session",$arr_session);
                $this->session->set_userdata("h_search",$s_search);
				
                $this->data["h_search"]	   		= $s_search;
                $this->data["product_name"]	 	= $search_variable["product_name"];            
				$this->data["user_name"]	  	= $search_variable["user_name"]; 
				$this->data["date_start"]  		= $search_variable["date_start"]; 
				$this->data["date_end"]    		= $search_variable["date_end"]; 
				$this->data["i_store_id"]    	= $search_variable["i_store_id"]; 
                /////end Storing search values into session///
            }
            else////List all records, **not done
            {
                $s_where=" WHERE 1 AND e.product_name!='Cashback Earned From Registration' ";
                /////Releasing search values from session///
                $this->session->unset_userdata("arr_session");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]	   	= $s_search;
                $this->data["product_name"]	= "";       
				$this->data["user_name"]	= "";   
				$this->data["date_start"]  	= ""; 
				$this->data["date_end"]    	= "";  
				$this->data["i_store_id"]    	= ""; 
                /////end Storing search values into session///

            }
           unset($s_search,$arr_session,$search_variable);
            ///Setting Limits, If searched then start from 0////
            $i_uri_seg =6;
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
                $start=$this->uri->segment($i_uri_seg);
            }

            ///////////end generating search query///////
			$arr_sort = array(0=>'i_id',1=>'dt_of_payment',2=>'i_status');
			$s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
            //$s_order_name="dt_of_payment";
            $limit	= $this->i_admin_page_limit;
			$info	= $this->mod_pay->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			//print_r ($info);

            /////////Creating List view for displaying/////////

			$table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 			          

            //////Table Headers, with width,alignment///////

            $table_view["caption"]     		=	"Payment Report";
            $table_view["total_rows"]		=	count($info);
			$table_view["total_db_records"]	=	$this->mod_pay->gettotal_info($s_where);

			$table_view["order_name"]		=	$order_name;
			$table_view["order_by"]  		=	$order_by;

            $table_view["src_action"]		= 	$this->pathtoclass.$this->router->fetch_method(); 
            $table_view["details_view"]		=   FALSE;          

            $table_view["headers"][0]["width"]	="20%";
            $table_view["headers"][0]["align"]	="left";
			//$table_view["headers"][0]["val"]	="Product";
			//$table_view["headers"][1]["width"]	="15%";
			$table_view["headers"][0]["val"]	="User";
			$table_view["headers"][1]["width"]	="15%";
			$table_view["headers"][1]["val"]	="Referral";
			$table_view["headers"][2]["val"]	="Amount";
			$table_view["headers"][3]["val"]	="Cashback";
			$table_view["headers"][4]["val"]	="Store";
			$table_view["headers"][5]["val"]	="Earning Type";
			$table_view["headers"][6]["sort"]	= array('field_name'=>encrypt($arr_sort[1]));
			$table_view["headers"][6]["width"]	="12%";
			$table_view["headers"][6]["val"]	="Date";	
            //////end Table Headers, with width,alignment///////

            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
				$earning_type = $info[$i]["earning_type"]==1?"Referral":"Direct";

				$i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["user_name"].'</br>( '.$info[$i]["s_uid"].' )';
				//$table_view["tablerows"][$i][$i_col++]	= $info[$i]["referral_id"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["referral_user_id"]?$info[$i]["referral_user_id"]:"";
				$table_view["tablerows"][$i][$i_col++]	= 'Rs '.$info[$i]["d_amount"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["cashback_amount"]?'Rs '.$info[$i]["cashback_amount"]:"";
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["i_store_id"]?getStoreTitles($info[$i]["i_store_id"]):$info[$i]["s_merchant_name"];
				$table_view["tablerows"][$i][$i_col++]	= $earning_type;
				$table_view["tablerows"][$i][$i_col++]	= date("Y-m-d",strtotime($info[$i]["dt_of_payment"]));
				
				$action = '';
				if($this->data['action_allowed']["Status"])
                 {
					if($info[$i]["i_status"] == 2)
					{
						$action .= 'Paid to user';
					}
					else if($info[$i]["i_status"] == 1)
					{
                        $action .='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_inactive"><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/reject.png"></a>';
						
						$action .='&nbsp;<a  href="javascript:void(0);" id="pay_user_id_'.$info[$i]["i_id"].'_pay"><img width="16" height="16" title="Pay to User" alt="Pay to User" src="images/admin/money.png"></a>';
					}
					else
					{
                       
						 $action .='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_active"><img width="12" height="12" alt="Active" title="Active" src="images/admin/tick.png"></a>';
					}				
				}
                if($action!='')
                {
                    $table_view["rows_action"][$i]    = $action;     
                }

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit,$action); 
            //$this->data["table_view"]=$this->admin_showin_table($table_view);
			$this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
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
    {}
	
	
    public function import_payment() 
    {
		$this->data["search_action"]= $this->pathtoclass.'import_csv_payment';
		$this->data["heading"]		= 'Payment Information Import';		
		$this->render("payment_report/import_csv");
	}

	public function old_import_csv_payment()
	{
		if($_POST)
		{
			//$this->form_validation->set_rules('s_file', addslashes(t('select file')), 'required');
			ini_set('memory_limit','-1');    // used for big file upload
			set_time_limit(0);
			
			
			$allowedType = array('text/x-tab-separated-values', 'text/tab-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel','text/x-csv','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			
			if(isset($_FILES['s_file']) && !empty($_FILES['s_file']['name']))
			{				
				$tmp_name           =  $_FILES['s_file']['tmp_name']; 
				$files           	=  $_FILES['s_file']['name'];	
				$filesize           =  $_FILES['s_file']['size'];	
				$filetype           =  $_FILES['s_file']['type'];	
			}
			else
            {					
                ////////Display the add form with posted values within it////
                set_error_msg($this->cls_msg["no_file"]);
				redirect($this->pathtoclass.'import_payment');
            }
			
			//if(!in_array($filetype, $allowedType))		
			if($filesize >70240000 || !in_array($filetype, $allowedType))
			{
				set_error_msg("upload a proper csv file which is smaller than 60 MB");
				redirect($this->pathtoclass.'import_payment');
			}
			else
            {				
				if (($handle = fopen($tmp_name, "r")) !== FALSE) 
				{
					# Set the parent multidimensional array key to 0.
					$nn = 0;
					while (($data = fgetcsv($handle, 1500, ",")) !== FALSE) 
					{ 
						# Count the total keys in the row.
						$c = count($data);
						# Populate the multidimensional array.
						for ($x = 0; $x < $c; $x++)
						{
							$csvarray[$nn][$x] = $data[$x];					
						}
						$nn++;
						//if($nn == 6) break;
					}
					# Close the File.
					fclose($handle);
				}
				//echo '<pre>';print_r($csvarray);exit;		
				for($i = 1; $i <count($csvarray); $i++)
				{
					$data = $csvarray[$i];
					//pr($data,1);
					
					$pay_arr = array();
					$pay_arr["user_id"]			= $data[0];
					$pay_arr["referral_id"]		= $data[1];
					$pay_arr["product_name"]	= $data[2];
					$pay_arr["product_id"]		= $data[3];
					$pay_arr["d_amount"]		= $data[4];
					$pay_arr["cashback_amount"]	= $data[5];
					$pay_arr["s_merchant_name"]	= $data[6];
					$pay_arr["dt_of_payment"]	= date("Y-m-d H:i:s",strtotime($data[7]));
					
					$pay_arr["earning_type"]	= 0;
					$pay_arr["s_particulars"]	= $data[2];
					$pay_arr["i_status"]		= 1;					
					if($pay_arr["referral_id"]!='')
					{
						$ref_user_id = getUserIdByCondn("WHERE s_uid='".my_receive_text($pay_arr["referral_id"])."' ");
						$pay_arr["referral_user_id"]		= $ref_user_id;
					}
					
					$i_insert = $this->mod_pay->add_cashback_earn($pay_arr);
					if($i_insert && $pay_arr["referral_user_id"]>0)
					{
						$this->load->model("site_setting_model","mod_rect");
						$info=$this->mod_rect->fetch_this(NULL);
						$cashback_per = trim($info["d_cashback"]);
						
						$pay_arr_ref = array();
						$pay_arr_ref["user_id"]			= $pay_arr["referral_user_id"];
						//$pay_arr_ref["referral_id"]		= $data[1];
						$pay_arr_ref["product_name"]	= $data[2];
						$pay_arr_ref["product_id"]		= $data[3];
						$pay_arr_ref["d_amount"]		= $data[4];
						$pay_arr_ref["cashback_amount"]	= ($data[5]*$cashback_per)/100;
						$pay_arr_ref["s_merchant_name"]	= $data[6];
						$pay_arr_ref["dt_of_payment"]	= date("Y-m-d H:i:s",strtotime($data[7]));
						
						$pay_arr_ref["earning_type"]	= 1;
						$pay_arr_ref["s_particulars"]	= $data[2];
						$pay_arr_ref["i_status"]		= 1;
						
						$i_ref_insert = $this->mod_pay->add_cashback_earn($pay_arr_ref);
					}
				}
				
				set_success_msg($this->cls_msg["save_succ"]);
				redirect($this->pathtoclass.'import_payment');
				
				///////////////////////// END FILE READ AND IMPORT  /////////////////////////
			} // end else
		}
	}
	
	
	/* cnaged on 19 june 2014 and also database changed
	* two more field added s_network & s_transaction_id
	*/
	public function import_csv_payment()
	{
		if($_POST)
		{
			//$this->form_validation->set_rules('s_file', addslashes(t('select file')), 'required');
			ini_set('memory_limit','-1');    // used for big file upload
			set_time_limit(0);
			
			
			$allowedType = array('text/x-tab-separated-values', 'text/tab-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel','text/x-csv','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			
			if(isset($_FILES['s_file']) && !empty($_FILES['s_file']['name']))
			{				
				$tmp_name           =  $_FILES['s_file']['tmp_name']; 
				$files           	=  $_FILES['s_file']['name'];	
				$filesize           =  $_FILES['s_file']['size'];	
				$filetype           =  $_FILES['s_file']['type'];	
			}
			else
            {					
                ////////Display the add form with posted values within it////
                set_error_msg($this->cls_msg["no_file"]);
				redirect($this->pathtoclass.'import_payment');
            }
			
			//if(!in_array($filetype, $allowedType))		
			if($filesize >70240000 || !in_array($filetype, $allowedType))
			{
				set_error_msg("upload a proper csv file which is smaller than 60 MB");
				redirect($this->pathtoclass.'import_payment');
			}
			else
            {				
				if (($handle = fopen($tmp_name, "r")) !== FALSE) 
				{
					# Set the parent multidimensional array key to 0.
					$nn = 0;
					while (($data = fgetcsv($handle, 1500, ",")) !== FALSE) 
					{ 
						# Count the total keys in the row.
						$c = count($data);
						# Populate the multidimensional array.
						for ($x = 0; $x < $c; $x++)
						{
							$csvarray[$nn][$x] = $data[$x];					
						}
						$nn++;
						//if($nn == 6) break;
					}
					# Close the File.
					fclose($handle);
				}
				//echo '<pre>';print_r($csvarray);exit;		
				for($i = 1; $i <count($csvarray); $i++)
				{
					$data = $csvarray[$i];
					//pr($data,1);
					
					$pay_arr = array();
					/*$pay_arr["user_id"]		= $data[0];
					$pay_arr["referral_id"]		= $data[1];
					$pay_arr["product_name"]	= $data[2];
					$pay_arr["product_id"]		= $data[3];
					$pay_arr["d_amount"]		= $data[4];
					$pay_arr["cashback_amount"]	= $data[5];
					$pay_arr["s_merchant_name"]	= $data[6];*/
					
					$pay_arr["referral_id"]		= $data[0];
					$pay_arr["product_name"]	= $data[1];
					$pay_arr["d_amount"]		= $data[2];
					$pay_arr["commission_amount"]= $data[3];
					$pay_arr["cashback_amount"]	= $data[4];
					$pay_arr["s_merchant_name"]	= $data[5];
					$pay_arr["dt_of_payment"]	= date("Y-m-d H:i:s",strtotime($data[6]));
					$pay_arr["s_network"]		= $data[7];
					$pay_arr["s_transaction_id"]= $data[8];
					
					$pay_arr["earning_type"]	= 0;
					$pay_arr["s_particulars"]	= $data[1];
					$pay_arr["i_status"]		= 0;	
					
					// check condition for mandatory fields
					if($pay_arr["referral_id"] && $pay_arr["cashback_amount"] 
						&& $pay_arr["dt_of_payment"] && $pay_arr["s_merchant_name"]
					)
					{				
						if($pay_arr["referral_id"]!='')
						{
							$user_id = getUserIdByCondn("WHERE s_uid='".my_receive_text($pay_arr["referral_id"])."' ");
							$pay_arr["user_id"]		= $user_id;
							
							if($user_id>0)
							{
								$ref_user_id = getUserRefIdByCondn("WHERE i_id='".my_receive_text($user_id)."' ");
								$pay_arr["referral_user_id"]		= $ref_user_id;
							}
						}
						//pr($pay_arr,1);exit;
						$i_insert = $this->mod_pay->add_cashback_earn($pay_arr);						
						//$i_insert = true;
						if($i_insert && $pay_arr["referral_user_id"]!='')
						{
							$this->load->model("site_setting_model","mod_rect");
							$info=$this->mod_rect->fetch_this(NULL);
							$cashback_per = trim($info["d_cashback"]);
							
							$ref_userId = getUserIdByCondn("WHERE s_uid='".my_receive_text($pay_arr["referral_user_id"])."' ");
							
							$pay_arr_ref = array();
							$pay_arr_ref["user_id"]			= $ref_userId;
							$pay_arr_ref["referral_id"]		= $pay_arr["referral_user_id"];
							$pay_arr_ref["product_name"]	= $data[1];
							$pay_arr_ref["d_amount"]		= $data[2];
							$pay_arr_ref["cashback_amount"]	= ($data[4]*$cashback_per)/100;
							$pay_arr_ref["s_merchant_name"]	= $data[5];
							$pay_arr_ref["dt_of_payment"]	= date("Y-m-d H:i:s",strtotime($data[6]));
							$pay_arr_ref["s_network"]		= $data[7];
							$pay_arr_ref["s_transaction_id"]= $data[8];
							
							$pay_arr_ref["earning_type"]	= 1;
							$pay_arr_ref["s_particulars"]	= $data[1];
							$pay_arr_ref["i_status"]		= 0;
							
							$i_ref_insert = $this->mod_pay->add_cashback_earn($pay_arr_ref);
						}
					}
					// end check condition for mandatory fields
				}
				
				set_success_msg($this->cls_msg["save_succ"]);
				//redirect($this->pathtoclass.'import_payment');
				echo '<script type="text/javascript">';
				echo ' window.location.href="'. $this->pathtoclass.'import_payment' .'"; ';
				echo '</script>';
				
				///////////////////////// END FILE READ AND IMPORT  /////////////////////////
			} // end else
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

    public function modify_information($i_id = 0)
    {}

    

	/***
    * Shows details of a single record.
    * @param int $i_id, Primary key
    */
    public function show_detail($i_id=0)
    {}

	public function remove_information($i_id=0)
    {} 
	
	/***
    * Change status of the user 
    * @author Koushik 
    */
    public function ajax_change_status()
    {
        try
        {            
			$posted["id"]           = decrypt($this->input->post("h_id"));
			$posted["i_status"]     = trim($this->input->post("i_status"));
			
			$info = array();
			$info['i_status']    	= $posted["i_status"]  ;
			$arr_where              = array('i_id'=>$posted["id"]);
			$i_rect=$this->mod_common->common_edit_info($this->tbl_cashbk_earn,$info,$arr_where); /*don't change*/  
			            
			if($i_rect)////saved successfully
			{
				echo "ok";                
			}
			else///Not saved, show the form again
			{
				echo "error" ;
			}
			
			unset($info,$i_rect);
              
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	
	/***
    * Change pay status of the user 
    */
    public function ajax_pay_status()
    {
        try
        {            
			$posted["id"]           = $this->input->post("h_id");
			$posted["i_status"]     = trim($this->input->post("i_status"));
			
			$info = array();
			$info['i_status']    	= $posted["i_status"]  ;
			$arr_where              = array('i_id'=>$posted["id"]);
			$i_rect=$this->mod_common->common_edit_info($this->tbl_cashbk_earn,$info,$arr_where); /*don't change*/  
			            
			if($i_rect)////saved successfully
			{
				echo "ok";                
			}
			else///Not saved, show the form again
			{
				echo "error" ;
			}
			
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