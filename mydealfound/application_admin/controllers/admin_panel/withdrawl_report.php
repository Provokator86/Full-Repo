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


class Withdrawl_report extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
	public $table, $tbl_cashbk_paid;

	public function __construct()
    {
      try
      {

			parent::__construct();
			$this->data['title']	= "Withdrawl Report Management"; // Browser Title

			// Table used
			$this->table = $this->db->REPORT;
			$this->tbl_cashbk_paid = 'cd_cashback_paid';

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

			// end Define Errors Here

			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/"; //for redirecting from this class
			$this->load->model('payment_report_model','mod_pay');
			$this->load->model('common_model','mod_common');

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
    */

	public function show_list($order_name = '', $order_by = 'desc', $start = NULL, $limit = NULL)
    {
		try
        {           

			$this->data['heading']="Withdrawl Management";////Package Name[@package] Panel Heading

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
			$search_variable["i_status"] = ($this->input->post("h_search")?$this->input->post("i_status"):$arr_session_data["i_status"]);
			$search_variable["user_name"] = ($this->input->post("h_search")?$this->input->post("user_name"):$arr_session_data["user_name"]);
			$search_variable["date_start"] = ($this->input->post("h_search")?$this->input->post("date_start"):$arr_session_data["date_start"]);
			$search_variable["date_end"] = ($this->input->post("h_search")?$this->input->post("date_end"):$arr_session_data["date_end"]);
		
			

            ////////end Getting Posted or session values for search///

            // $s_where=" WHERE i_user_type=2 ";/////////////////////////
			$s_where=" WHERE 1";
            if($s_search=="basic")
            {
			  	
				if(trim($search_variable["product_name"])!="")
				{
					$s_where.=" AND p.s_title LIKE '%".my_receive_text($search_variable["product_name"])."%' ";
				}
				if(trim($search_variable["i_status"]).'a'!="a")
				{
					$s_where.=" AND e.i_status ='".my_receive_text($search_variable["i_status"])."' ";
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
				
                /////Storing search values into session///

                $arr_session    =   array();                
                $arr_session["searching_name"] 	= $this->data['heading'] ;                  
                $arr_session["product_name"]	= $search_variable["product_name"] ;         
                $arr_session["i_status"]		= $search_variable["i_status"] ;
				$arr_session["user_name"] 		= $search_variable["user_name"] ;
				$arr_session["date_start"] 	   	= $search_variable["date_start"];
				$arr_session["date_end"] 	    = $search_variable["date_end"];
				
                $this->session->set_userdata("arr_session",$arr_session);
                $this->session->set_userdata("h_search",$s_search);
				
                $this->data["h_search"]	   		= $s_search;
                $this->data["product_name"]	 	= $search_variable["product_name"];          
                $this->data["i_status"]			= $search_variable["i_status"] ;          
				$this->data["user_name"]	  	= $search_variable["user_name"]; 
				$this->data["date_start"]  		= $search_variable["date_start"]; 
				$this->data["date_end"]    		= $search_variable["date_end"]; 
                /////end Storing search values into session///
            }
            else////List all records, **not done
            {
                $s_where=" WHERE 1 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("arr_session");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]	   	= $s_search;
                $this->data["product_name"]	= "";               
                $this->data["i_status"]		= "";     
				$this->data["user_name"]	= "";   
				$this->data["date_start"]  	= ""; 
				$this->data["date_end"]    	= "";  
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
			$arr_sort = array(0=>'dt_of_payment',1=>'i_status');
			$s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
            //$s_order_name="dt_of_payment";
            $limit	= $this->i_admin_page_limit;
			$info	= $this->mod_pay->fetch_multi_withdraw_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			//print_r ($info);

            /////////Creating List view for displaying/////////

			$table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 			          

            //////Table Headers, with width,alignment///////

            $table_view["caption"]     		=	"Withdrawl Report";
            $table_view["total_rows"]		=	count($info);
			$table_view["total_db_records"]	=	$this->mod_pay->gettotal_withdraw_list($s_where);

			$table_view["order_name"]		=	$order_name;
			$table_view["order_by"]  		=	$order_by;

            $table_view["src_action"]		= 	$this->pathtoclass.$this->router->fetch_method(); 
            $table_view["details_view"]		=   FALSE;          

            $table_view["headers"][0]["width"]	="40%";
            $table_view["headers"][0]["align"]	="left";
			$table_view["headers"][0]["val"]	="Details";
			$table_view["headers"][1]["width"]	="15%";
			$table_view["headers"][1]["val"]	="User";
			/*$table_view["headers"][2]["width"]	="15%";
			$table_view["headers"][2]["val"]	="Merchant";*/
			$table_view["headers"][2]["val"]	="Amount";
			$table_view["headers"][3]["val"]	="Status";
			$table_view["headers"][4]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][4]["width"]	="12%";
			$table_view["headers"][4]["val"]	="Date";	
            //////end Table Headers, with width,alignment///////

            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
				$s_status = $info[$i]["i_status"]==1?"Approved":"Pending";
				
				$bank_info 	= json_decode($info[$i]["s_particulars"]);
				$pay_mode 	= $info[$i]["s_pay_mode"];
				$address = '';
				//pr($bank_info);
				if($pay_mode=='cheque')
				{
					$address = '<table id="tbl_address" width="100%" border="0" cellspacing="0" cellpadding="0">';
					$address .= '<tr>';	
					$address .= 	'<td width="30%">Payment Mode</td>';
					$address .= 		'<td>Cheque</td>';
					$address .= '</tr>';	
					$address .= '<tr>';	
					$address .= 	'<td width="30%">Name</td>';
					$address .= 		'<td>'.$bank_info->s_cheque_name.'</td>';
					$address .= '</tr>';	
					$address .= '<tr>';	
					$address .= 	'<td width="30%">Address</td>';
					$address .= 		'<td>'.$bank_info->s_address.'</td>';
					$address .= '</tr>';
					$address .= '<tr>';	
					$address .= 	'<td width="30%">State</td>';
					$address .= 		'<td>'.$bank_info->s_state.'</td>';
					$address .= '</tr>';	
					$address .= '<tr>';	
					$address .= 	'<td width="30%">City</td>';
					$address .= 		'<td>'.$bank_info->s_city.'</td>';
					$address .= '</tr>';
					$address .= '<tr>';	
					$address .= 	'<td width="30%">Postal code</td>';
					$address .= 		'<td>'.$bank_info->s_postal_code.'</td>';
					$address .= '</tr>';
					$address .= '<tr>';	
					$address .= 	'<td width="30%">Contact Number</td>';
					$address .= 		'<td>'.$bank_info->s_contact_number.'</td>';
					$address .= '</tr>';
					
					$address .='</table>';
				}
				else if($pay_mode=='neft')
				{
					$address = '<table id="tbl_address" width="100%" border="0" cellspacing="0" cellpadding="0">';
					$address .= '<tr>';	
					$address .= 	'<td width="30%">Payment Mode</td>';
					$address .= 		'<td>Online</td>';
					$address .= '</tr>';	
					$address .= '<tr>';	
					$address .= 	'<td width="30%">Name</td>';
					$address .= 		'<td>'.$bank_info->s_neft_name.'</td>';
					$address .= '</tr>';	
					$address .= '<tr>';	
					$address .= 	'<td width="30%">Bank Name</td>';
					$address .= 		'<td>'.$bank_info->s_neft_bank_name.'</td>';
					$address .= '</tr>';
					$address .= '<tr>';	
					$address .= 	'<td width="30%">Branch Name</td>';
					$address .= 		'<td>'.$bank_info->s_neft_branch_name.'</td>';
					$address .= '</tr>';	
					$address .= '<tr>';	
					$address .= 	'<td width="30%">Account No.</td>';
					$address .= 		'<td>'.$bank_info->s_neft_account.'</td>';
					$address .= '</tr>';
					$address .= '<tr>';	
					$address .= 	'<td width="30%">IFSC</td>';
					$address .= 		'<td>'.$bank_info->s_neft_ifsc.'</td>';
					$address .= '</tr>';
					
					$address .='</table>';
				}

				$i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);////Index 0 must be the encrypted PK 

				//$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_title"];
				$table_view["tablerows"][$i][$i_col++]	= $address;
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["user_name"].'</br>( '.$info[$i]["s_uid"].' )';
				//$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_merchant_name"];
				$table_view["tablerows"][$i][$i_col++]	= 'Rs '.$info[$i]["d_price"];
				$table_view["tablerows"][$i][$i_col++]	= $s_status;
				$table_view["tablerows"][$i][$i_col++]	= date("Y-m-d",strtotime($info[$i]["dt_of_payment"]));
				
				$action = '';
				if($this->data['action_allowed']["Status"])
                 {
					if($info[$i]["i_status"] == 1)
					{
                        $action .='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_inactive"><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/reject.png"></a>';
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
			$i_rect=$this->mod_common->common_edit_info($this->tbl_cashbk_paid,$info,$arr_where); /*don't change*/  
			            
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