<?php
/********** 
Author: 
* Date  : 07 July 2014
* Modified By: 
* Modified Date: 
* 
* Purpose:
* Controller For Manage Cashout Report
* 
* @package Report
* @subpackage Cashout Report
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/user_model.php
* @link views/admin/cashback_report/
*/


class Cashout_report extends My_Controller implements InfController
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
			$this->data['title']	= "Cashout Report Management"; // Browser Title
			$this->tbl_cashbk_earn = 'cd_cashback_earned';
			$this->data['action_allowed']["Status"]	=FALSE;
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

			$this->data['heading']="Cashout Report";////Package Name[@package] Panel Heading

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
			$search_variable["s_keyword"] = ($this->input->post("h_search")?$this->input->post("s_keyword"):$arr_session_data["s_keyword"]);
			$search_variable["custom_periods"] = ($this->input->post("h_search")?$this->input->post("custom_periods"):$arr_session_data["custom_periods"]);
			$search_variable["date_start"] = ($this->input->post("h_search")?$this->input->post("date_start"):$arr_session_data["date_start"]);
			$search_variable["date_end"] = ($this->input->post("h_search")?$this->input->post("date_end"):$arr_session_data["date_end"]);
			$search_variable["i_status"] = ($this->input->post("h_search")?$this->input->post("i_status"):$arr_session_data["i_status"]);
            ////////end Getting Posted or session values for search///

			//$s_where=" WHERE 1 AND e.product_name!='Cashback Earned From Registration' ";
			$s_where=" WHERE e.i_status=2 ";
            if($s_search=="basic")
            {
			  	
				if(trim($search_variable["s_keyword"])!="")
				{
					$s_where.=" AND (e.product_name LIKE '%".my_receive_text($search_variable["s_keyword"])."%' OR u.s_name LIKE '%".my_receive_text($search_variable["s_keyword"])."%')  ";
				}
				if(trim($search_variable["custom_periods"])!="")
				{
					//$s_where.=" AND u.s_name LIKE '%".my_receive_text($search_variable["user_name"])."%' ";
					if($search_variable["custom_periods"]==2)  // today
					{
						$dt_today=date("Y-m-d",time()) ; 
						$s_where.=" AND DATE( e.dt_of_payment) ='".$dt_today."' ";
                    	unset($dt_today);
					}
					else if($search_variable["custom_periods"]==3) // yesterday
					{
						$dt_yesterday = date("Y-m-d",strtotime("-1 days"));
						$s_where.=" AND DATE( e.dt_of_payment) >='".$dt_yesterday."' ";
                    	unset($dt_yesterday); 
					}
					else if($search_variable["custom_periods"]==4) // last 7 days
					{
						$dt_sevenday = date("Y-m-d",strtotime("-7 days"));
						$s_where.=" AND DATE( e.dt_of_payment) >='".$dt_sevenday."' ";
                    	unset($dt_sevenday); 
					}
					else if($search_variable["custom_periods"]==5) // last 30 days
					{
						$dt_thirtyday = date("Y-m-d",strtotime("-30 days"));
						$s_where.=" AND DATE( e.dt_of_payment) >='".$dt_thirtyday."' ";
                    	unset($dt_thirtyday); 
					}
					else if($search_variable["custom_periods"]==1) // custom dates
					{
						
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
					}
				}
				if(trim($search_variable["i_status"])!="")
				{	
					$s_where.=" AND e.i_status = '".$search_variable["i_status"]."' ";
				}
				
                /////Storing search values into session///

                $arr_session    =   array();                
                $arr_session["searching_name"] 	= $this->data['heading'] ;                  
                $arr_session["s_keyword"]		= $search_variable["s_keyword"] ;
				$arr_session["custom_periods"] 	= $search_variable["custom_periods"] ;
				$arr_session["date_start"] 	   	= $search_variable["date_start"];
				$arr_session["date_end"] 	    = $search_variable["date_end"];
				$arr_session["i_status"] 	    = $search_variable["i_status"];
				
                $this->session->set_userdata("arr_session",$arr_session);
                $this->session->set_userdata("h_search",$s_search);
				
                $this->data["h_search"]	   		= $s_search;
                $this->data["s_keyword"]	 	= $search_variable["s_keyword"];            
				$this->data["custom_periods"]	= $search_variable["custom_periods"]; 
				$this->data["date_start"]  		= $search_variable["date_start"]; 
				$this->data["date_end"]    		= $search_variable["date_end"]; 
				$this->data["i_status"]    		= $search_variable["i_status"]; 
                /////end Storing search values into session///
            }
            else////List all records, **not done
            {
                //$s_where=" WHERE 1 AND e.product_name!='Cashback Earned From Registration' ";
				$s_where=" WHERE e.i_status=2 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("arr_session");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]	   		= $s_search;
                $this->data["s_keyword"]		= "";       
				$this->data["custom_periods"]	= "";   
				$this->data["date_start"]  		= ""; 
				$this->data["date_end"]    		= "";  
				$this->data["i_status"]    		= ""; 
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

            $table_view["caption"]     		=	"Cashout Report";
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
			$table_view["headers"][1]["val"]	="Status";
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

				//$table_view["tablerows"][$i][$i_col++]	= $info[$i]["product_name"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["user_name"].'</br>( '.$info[$i]["s_uid"].' )';
				//$table_view["tablerows"][$i][$i_col++]	= $info[$i]["referral_id"]; 
				$table_view["tablerows"][$i][$i_col++]	= getReportStatus($info[$i]["i_status"]);
				$table_view["tablerows"][$i][$i_col++]	= 'Rs '.number_format($info[$i]["d_amount"],2);
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["cashback_amount"]?'Rs '.number_format($info[$i]["cashback_amount"],2):"";
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["i_store_id"]?getStoreTitles($info[$i]["i_store_id"]):$info[$i]["s_merchant_name"];
				$table_view["tablerows"][$i][$i_col++]	= $earning_type;
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