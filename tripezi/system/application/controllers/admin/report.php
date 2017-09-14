<?php
/*********
* Author: Koushik 
* Date  : 19 July 2012
* Modified By: 
* Modified Date:  
* Purpose:
*  Controller For User
* @package Users
* @subpackage manage_booking
* @link InfController.php 
* @link My_Controller.php
* @link model/property_model.php
* @link views/admin/manage_booking/
*/


class Report extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public $thumbDisplayPath;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']            =    "Payment Report";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]    =    "No information found about report.";
       
          ////////end Define Errors Here//////
          $this->pathtoclass             =     admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
          
          //////// loading default model here //////////////
          $this->load->model("property_model","mod_property");
          $this->load->model("common_model","mod_common");
          //////// end loading default model here //////////////
          /* for uploading category icon */
          $this->allowedExt             = 'jpg|jpeg|png';
          $this->user_image                = $this->config->item('user_image');
          //pr($user_image,1);
          
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
    public function show_list($order_name='',$order_by='desc',$start=NULL,$limit=NULL)
    {
        try
        {
            
            $this->data['heading']="Payment Report";////Package Name[@package] Panel Heading

            ///////////generating search query///////
            $arr_session_data    =    $this->session->userdata("arr_session");
            
            if($arr_session_data['searching_name']!=$this->data['heading'])
            {
                $this->session->unset_userdata("arr_session");
                $arr_session_data   =   array();
            }
            $search_variable     =    array();
            ////////Getting Posted or session values for search///
            $s_search            = (isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            
            $search_variable["s_traveler_name"]= ($this->input->post("h_search")?$this->input->post("txt_traveler_name"):$arr_session_data["txt_traveler_name"]);
             
            $search_variable["s_traveler_email"]    = ($this->input->post("h_search")?$this->input->post("txt_traveler_email"):$arr_session_data["txt_traveler_email"]); 
              
            $search_variable["s_owner_name"]        = ($this->input->post("h_search")?$this->input->post("txt_owner_name"):$arr_session_data["txt_owner_name"]);     
            $search_variable["s_owner_email"]       = ($this->input->post("h_search")?$this->input->post("txt_owner_email"):$arr_session_data["txt_owner_email"]);     
                    
            $search_variable["s_property_name"]     = ($this->input->post("h_search")?$this->input->post("txt_property_name"):$arr_session_data["txt_property_name"]); 
            
            $search_variable["s_booking_id"]        = ($this->input->post("h_search")?$this->input->post("txt_booking_id"):$arr_session_data["txt_booking_id"]); 
            
            $search_variable["s_property_id"]       = ($this->input->post("h_search")?$this->input->post("txt_property_id"):$arr_session_data["txt_property_id"]); 
            
            $search_variable["d_check_in_date"]     = ($this->input->post("h_search")?$this->input->post("txt_check_in_date"):$arr_session_data["txt_check_in_date"]); 
            $search_variable["d_check_out_date"]    = ($this->input->post("h_search")?$this->input->post("txt_check_out_date"):$arr_session_data["txt_check_out_date"]); 
            
            $search_variable["d_date_from"]         = ($this->input->post("h_search")?$this->input->post("txt_date_from"):$arr_session_data["txt_date_from"]); 
            
            $search_variable["d_date_to"]           = ($this->input->post("h_search")?$this->input->post("txt_date_to"):$arr_session_data["txt_date_to"]); 
            
            $search_variable["s_pay_host"]          = ($this->input->post("h_search")?$this->input->post("opt_pay_host"):$arr_session_data["opt_pay_host"]); 
            
            $search_variable["s_tax_withdraw"]      = ($this->input->post("h_search")?$this->input->post("opt_tax_withdraw"):$arr_session_data["opt_tax_withdraw"]); 
            
            $search_variable["s_commission_withdraw"]= ($this->input->post("h_search")?$this->input->post("opt_commission_withdraw"):$arr_session_data["opt_commission_withdraw"]); 
            
            
            ////////end Getting Posted or session values for search///
            
            $s_where=" WHERE e_status='Amount paid'  ";
           
            if($s_search=="advanced")
            {
                if(trim($search_variable["s_traveler_name"])!='')
                {
                    $s_where.=" AND u.s_first_name LIKE '%".get_formatted_string($search_variable["s_traveler_name"])."%' ";
                }
                if(trim($search_variable["s_traveler_email"])!='')
                {
                    $s_where.=" AND u.s_email LIKE '%".get_formatted_string($search_variable["s_traveler_email"])."%' ";
                }
                if(trim($search_variable["s_owner_name"])!='')
                {
                    $s_where.=" AND us.s_first_name LIKE '%".get_formatted_string($search_variable["s_owner_name"])."%' ";
                }
                if(trim($search_variable["s_owner_email"])!='')
                {
                    $s_where.=" AND us.s_email LIKE '%".get_formatted_string($search_variable["s_owner_email"])."%' ";
                }
                if(trim($search_variable["s_property_name"])!='')
                {
                    $s_where.=" AND s_property_name LIKE '%".get_formatted_string($search_variable["s_property_name"])."%' ";
                }
                if(trim($search_variable["s_booking_id"])!='')
                {
                    $s_where.=" AND s_booking_id  = '".get_formatted_string($search_variable["s_booking_id"])."' ";
                }
                if(trim($search_variable["s_property_id"])!='')
                {
                    $s_where.=" AND s_property_id  = '".get_formatted_string($search_variable["s_property_id"])."' ";
                }
                if(trim($search_variable["d_check_in_date"])!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($search_variable["d_check_in_date"]." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( dt_booked_from , '%Y-%m-%d' ) >='".$dt_start."' ";
                    unset($dt_start);
                }
                if(trim($search_variable["d_check_out_date"])!="")
                {
                    $dt_end=date("Y-m-d",strtotime(trim($search_variable["d_check_out_date"]." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( dt_booked_to , '%Y-%m-%d' ) <='".$dt_end."' ";
                    unset($dt_end);
                }
                
                if(trim($search_variable["d_date_from"])!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($search_variable["d_date_from"]." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( dt_booked_on , '%Y-%m-%d' ) >='".$dt_start."' ";
                    unset($dt_start);
                }
                if(trim($search_variable["d_date_to"])!="")
                {
                    $dt_end=date("Y-m-d",strtotime(trim($search_variable["d_date_to"]." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( dt_booked_on , '%Y-%m-%d' ) <='".$dt_end."' ";
                    unset($dt_end);
                }
                if(trim($search_variable["s_pay_host"])!='all')
                {
                    $s_where.=" AND i_paid_to_host =".(($search_variable["s_pay_host"]=="no")?0:1);
                }
                if(trim($search_variable["s_tax_withdraw"])!='all')
                {
                    $s_where.=" AND i_tax_withdrawn =".(($search_variable["s_tax_withdraw"]=="no")?0:1);
                }
                if(trim($search_variable["s_commission_withdraw"])!='all')
                {
                    $s_where.=" AND i_site_commision_withdrawn =".(($search_variable["s_commission_withdraw"]=="no")?0:1);
                }
                

                /////Storing search values into session///
                $arr_session    =    array();
                $arr_session["searching_name"]       =    $this->data['heading'] ;  
                $arr_session["txt_traveler_name"]    =    $search_variable["s_traveler_name"];
                $arr_session["txt_traveler_email"]   =    $search_variable["s_traveler_email"];
                $arr_session["txt_owner_name"]       =    $search_variable["s_owner_name"];
                $arr_session["txt_owner_email"]      =    $search_variable["s_owner_email"];
                $arr_session["txt_property_name"]    =    $search_variable["s_property_name"];
                $arr_session["txt_booking_id"]       =    $search_variable["s_booking_id"];
                $arr_session["txt_property_id"]      =    $search_variable["s_property_id"];
                $arr_session["txt_check_in_date"]    =    $search_variable["d_check_in_date"];
                $arr_session["txt_check_out_date"]   =    $search_variable["d_check_out_date"];
                $arr_session["txt_date_from"]        =    $search_variable["d_date_from"];
                $arr_session["txt_date_to"]          =    $search_variable["d_date_to"];
                $arr_session["opt_pay_host"]         =    $search_variable["s_pay_host"];
                $arr_session["opt_tax_withdraw"]     =    $search_variable["s_tax_withdraw"];
                $arr_session["opt_commission_withdraw"]=    $search_variable["s_commission_withdraw"];
                
                
                $this->session->set_userdata('arr_session',$arr_session);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]             =    $s_search;
                $this->data["txt_traveler_name"]    =    get_unformatted_string($search_variable["s_traveler_name"]);
                $this->data["txt_traveler_email"]   =    get_unformatted_string($search_variable["s_traveler_email"]);
                $this->data["txt_owner_name"]       =    get_unformatted_string($search_variable["s_owner_name"]);
                $this->data["txt_owner_email"]      =    get_unformatted_string($search_variable["s_owner_email"]);
                $this->data["txt_property_name"]    =    get_unformatted_string($search_variable["s_property_name"]);
                $this->data["txt_booking_id"]       =    get_unformatted_string($search_variable["s_booking_id"]);
                $this->data["txt_property_id"]      =    get_unformatted_string($search_variable["s_property_id"]);
                $this->data["txt_check_in_date"]    =    $search_variable["d_check_in_date"];
                $this->data["txt_check_out_date"]   =    $search_variable["d_check_out_date"];
                $this->data["txt_date_from"]        =    $search_variable["d_date_from"];
                $this->data["txt_date_to"]          =    $search_variable["d_date_to"]; 
                $this->data["opt_pay_host"]         =    $search_variable["s_pay_host"]; 
                $this->data["opt_tax_withdraw"]     =    $search_variable["s_tax_withdraw"]; 
                $this->data["opt_commission_withdraw"]=  $search_variable["s_commission_withdraw"]; 
                
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE e_status='Amount paid'  ";
                /////Releasing search values from session///
                $this->session->unset_userdata("arr_session");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]             = $s_search;
                $this->data["txt_traveler_name"]    =    "";
                $this->data["txt_traveler_email"]   =    "";
                $this->data["txt_owner_name"]       =    "";
                $this->data["txt_owner_email"]      =    "";
                $this->data["txt_property_name"]    =    "";
                $this->data["txt_booking_id"]       =    "";
                $this->data["txt_property_id"]      =    "";
                $this->data["txt_check_in_date"]    =    "";
                $this->data["txt_check_out_date"]   =    "";
                $this->data["txt_date_from"]        =    "";
                $this->data["txt_date_to"]          =    "";                    
                $this->data["opt_pay_host"]         =    "all";                    
                $this->data["opt_tax_withdraw"]     =    "all";                    
                $this->data["opt_commission_withdraw"]=    "all";                    
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
            $arr_sort         = array(0=>'b.dt_paid_on'); 
            $s_order_name     = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];          
            $limit            = $this->i_admin_page_limit;
            $info             = $this->mod_property->fetch_booking_order_list($s_where,$s_order_name,$order_by,intval($start),$limit);
            
            /////////Creating List view for displaying/////////
            $table_view        = array();  
            $order_name        = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
            
            $info_report       = $this->mod_property->fetch_booking_order_list($s_where) ;
            
            $this->data['total_booking']    =    count($info_report); // number of records
            
            // Start Calculating total price 
            
            $total_amount_paid              =   array() ;
            $total_amount_service_charge    =   array() ;
            $total_amount_site_commission   =   array() ;
            $total_amount_host              =   array() ;
           
            if(!empty($info_report))
            {
                foreach($info_report as $itt)
                {
                    $ratio_amount_paid              =   $itt['d_amount_paid']/$itt['currency_charges'][$itt['i_currency_id']] ;
                    $ratio_amount_service_charge    =   $itt['d_service_charge_amount']/$itt['currency_charges'][$itt['i_currency_id']] ;
                    $ratio_amount_site_commission   =   $itt['d_site_commission_amount']/$itt['currency_charges'][$itt['i_currency_id']] ;
                    $ratio_amount_host              =   $itt['d_host_amount']/$itt['currency_charges'][$itt['i_currency_id']] ;
                    for($i=1;$i<=3;$i++)
                    {   
                            $total_amount_paid[$i]              +=    $ratio_amount_paid*$itt['currency_charges'][$i]  ;
                            $total_amount_service_charge[$i]    +=    $ratio_amount_service_charge*$itt['currency_charges'][$i]  ;
                            $total_amount_site_commission[$i]   +=    $ratio_amount_site_commission*$itt['currency_charges'][$i]  ;
                            $total_amount_host[$i]              +=    $ratio_amount_host*$itt['currency_charges'][$i]  ;
                    } 
                    
                }
            }
            
            $this->data['total_amount_paid']                =   $total_amount_paid ;
            $this->data['total_amount_service_charge']      =   $total_amount_service_charge ;
            $this->data['total_amount_site_commission']     =   $total_amount_site_commission ;
            $this->data['total_amount_host']                =   $total_amount_host ;

            // End Calculating total price  
         
                      
            //////Table Headers, with width,alignment///////
            $table_view["caption"]                = "Booking Details";
            $table_view["total_rows"]             = count($info);
            $table_view["total_db_records"]       = $this->data['total_booking'] ;
            $table_view["order_name"]             = $order_name;
            $table_view["order_by"]               = $order_by;
            $table_view["src_action"]             = $this->pathtoclass.$this->router->fetch_method(); 
            $table_view["detail_view"]            = false;
                        
            $table_view["headers"][0]["width"]    = "32%";
            $table_view["headers"][0]["align"]    = "left";            
            $table_view["headers"][0]["val"]      = "Proprety Name";
            $table_view["headers"][1]["width"]    = "32%";
            $table_view["headers"][1]["val"]      = "Booking Information";
            $table_view["headers"][2]["sort"]     = array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][2]["width"]    = "26%";
            $table_view["headers"][2]["val"]      = "Payment Details";
            $table_view["headers"][3]["width"]    = "10%";
            $table_view["headers"][3]["val"]      = "Status";

           
            
            //////end Table Headers, with width,alignment///////
            
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]    = encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                
                $table_view["tablerows"][$i][$i_col++]    = "<table><tr><td width='40%'>Property Id :</td><td>".$info[$i]["s_property_id"]."</td></tr>
                                                                    <tr><td>Property Name :</td><td><a  href='javascript:void(0);' onclick='show_property_details(\"".encrypt($info[$i]["i_property_id"])."\");' >".$info[$i]["s_property_name"]."</a></td></tr>
                                                                    <tr><td>Owner Name :</td><td><a  href='javascript:void(0);' onclick='show_user_details(\"".encrypt($info[$i]["i_owner_user_id"])."\");' >".ucfirst($info[$i]["owner_first_name"])." ".ucfirst($info[$i]["owner_last_name"])."</a></td></tr>
                                                                    <tr><td>Owner Email :</td><td>".$info[$i]["owner_email"]."</td></tr></table>" ;
                $booking_link  = '';
                $end_link      = '';
                if($info[$i]["e_status"]=='Amount paid')
                {
                    $booking_link   =    "<a  href='javascript:void(0);' onclick='show_booking_details(\"".encrypt($info[$i]["id"])."\");' >" ;
                    $end_link       =    "</a>";
                }
                                                                    
                $table_view["tablerows"][$i][$i_col++]    = "<table>
                                                                    <tr><td width='30%'>Booking Id :</td><td>".$info[$i]["s_booking_id"]."</td></tr>
                                                                    <tr><td>Booked By :</td><td><a  href='javascript:void(0);' onclick='show_user_details(\"".encrypt($info[$i]["i_traveler_user_id"])."\");' >".ucfirst($info[$i]["s_first_name"])." ".ucfirst($info[$i]["s_last_name"])."</a></td></tr>
                                                                    <tr><td>Email :</td><td>".$info[$i]["s_email"]."</td></tr>
                                                                    <tr><td colspan=\"2\" >from ".$info[$i]["dt_booked_from"]." to ".$info[$i]["dt_booked_to"]."&nbsp;No of ".$booking_link."Guests(".$info[$i]["i_total_guests"].")".$end_link."</td></tr>
                                                                    </table>" ;
                                                                    
                $table_view["tablerows"][$i][$i_col++]    = "<table>
                                                                    <tr><td width='50%'>Payment Date :</td><td>".$info[$i]["dt_paid_on"]."</td></tr>
                                                                    <tr><td>Paid Amount :</td><td>".$info[$i]["s_currency_symbol"].$info[$i]["d_amount_paid"]."</td></tr>
                                                                    <tr><td>Service Charge :</td><td>".$info[$i]["s_currency_symbol"].$info[$i]["d_service_charge_amount"]."</td></tr>
                                                                    <tr><td >Site Commission :</td><td>".$info[$i]["s_currency_symbol"].$info[$i]["d_site_commission_amount"]."</td></tr>
                                                                   
                                                                    </table>" ;

                
                $action     =   '';
                if($info[$i]["i_paid_to_host"])
                {
                    $action     .=   '<br/><br/><span>Paid to host</span>' ;
                }
                else
                {
                    $action     .=   '<br/><br/><span><a href="javascript:void(0);" onclick="reportAction(\''.encrypt($info[$i]["id"]).'\',\'pay_to_host\',this);">Pay to host</a></span>' ; 
                }
                if($info[$i]["i_tax_withdrawn"])
                {
                    $action     .=   '<br/><br/><span>Tax withdrawn</span>' ;
                }
                else
                {
                    $action     .=   '<br/><br/><span><a href="javascript:void(0);" onclick="reportAction(\''.encrypt($info[$i]["id"]).'\',\'withdraw_tax\',this);">Withdraw tax</a></span>' ; 
                }
                if($info[$i]["i_site_commision_withdrawn"])
                {
                    $action     .=   '<br/><br/><span>Commission withdrawn</span>' ;
                }
                else
                {
                    $action     .=   '<br/><br/><span><a href="javascript:void(0);" onclick="reportAction(\''.encrypt($info[$i]["id"]).'\',\'withdraw_commission\',this);" >Withdraw Commission</a></span>' ;  
                }  
               
               $table_view["tablerows"][$i][$i_col++]    = '<strong>'.$info[$i]["e_status"].'</strong>'.$action;  

        }   

            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit);
            
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            
            $this->data['arr_status']   =   array('all'=>'All','yes'=>'Yes','no'=>'No');
                        
            $this->render();          
            unset($table_view,$info,$arr_sort,$s_order_name,$order_name);
          
        }                     
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
     public function cancellation_show_list($order_name='',$order_by='desc',$start=NULL,$limit=NULL)
     {
         try
         {
               $this->session->unset_userdata("arr_session"); 
                $this->data['heading']="Cancellation Report";////Package Name[@package] Panel Heading

                ///////////generating search query///////
                $arr_session_data    =    $this->session->userdata("arr_session");
                if($arr_session_data['searching_name']!=$this->data['heading'])
                {
                    $this->session->unset_userdata("arr_session");
                    $arr_session_data   =   array();
                }
                $search_variable     =    array();
                ////////Getting Posted or session values for search///
                $s_search            = (isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
                
                $search_variable["s_traveler_name"]= ($this->input->post("h_search")?$this->input->post("txt_traveler_name"):$arr_session_data["txt_traveler_name"]);
                 
                $search_variable["s_traveler_email"]    = ($this->input->post("h_search")?$this->input->post("txt_traveler_email"):$arr_session_data["txt_traveler_email"]); 
                  
                $search_variable["s_owner_name"]        = ($this->input->post("h_search")?$this->input->post("txt_owner_name"):$arr_session_data["txt_owner_name"]);     
                $search_variable["s_owner_email"]       = ($this->input->post("h_search")?$this->input->post("txt_owner_email"):$arr_session_data["txt_owner_email"]);     
                        
                $search_variable["s_property_name"]     = ($this->input->post("h_search")?$this->input->post("txt_property_name"):$arr_session_data["txt_property_name"]); 
                
                $search_variable["s_booking_id"]        = ($this->input->post("h_search")?$this->input->post("txt_booking_id"):$arr_session_data["txt_booking_id"]); 
                
                $search_variable["s_property_id"]       = ($this->input->post("h_search")?$this->input->post("txt_property_id"):$arr_session_data["txt_property_id"]); 

                $search_variable["d_date_from"]         = ($this->input->post("h_search")?$this->input->post("txt_date_from"):$arr_session_data["txt_date_from"]); 
                
                $search_variable["d_date_to"]           = ($this->input->post("h_search")?$this->input->post("txt_date_to"):$arr_session_data["txt_date_to"]); 
                
                $search_variable["s_pay_host"]          = ($this->input->post("h_search")?$this->input->post("opt_pay_host"):$arr_session_data["opt_pay_host"]); 
                
                $search_variable["s_pay_traveler"]          = ($this->input->post("h_search")?$this->input->post("opt_pay_traveler"):$arr_session_data["opt_pay_traveler"]); 
                
                $search_variable["s_tax_withdraw"]      = ($this->input->post("h_search")?$this->input->post("opt_tax_withdraw"):$arr_session_data["opt_tax_withdraw"]); 
                
                $search_variable["s_commission_withdraw"]= ($this->input->post("h_search")?$this->input->post("opt_commission_withdraw"):$arr_session_data["opt_commission_withdraw"]); 
                
                $search_variable["d_check_in_date"]     = ($this->input->post("h_search")?$this->input->post("txt_check_in_date"):$arr_session_data["txt_check_in_date"]); 
                $search_variable["d_check_out_date"]    = ($this->input->post("h_search")?$this->input->post("txt_check_out_date"):$arr_session_data["txt_check_out_date"]); 
            
                 
                
                ////////end Getting Posted or session values for search///
                
                $s_where=" WHERE e_status='Cancelled and Approved by admin'  ";
               
                if($s_search=="advanced")
                {
                    if(trim($search_variable["s_traveler_name"])!='')
                    {
                        $s_where.=" AND u.s_first_name LIKE '%".get_formatted_string($search_variable["s_traveler_name"])."%' ";
                    }
                    if(trim($search_variable["s_traveler_email"])!='')
                    {
                        $s_where.=" AND u.s_email LIKE '%".get_formatted_string($search_variable["s_traveler_email"])."%' ";
                    }
                    if(trim($search_variable["s_owner_name"])!='')
                    {
                        $s_where.=" AND us.s_first_name LIKE '%".get_formatted_string($search_variable["s_owner_name"])."%' ";
                    }
                    if(trim($search_variable["s_owner_email"])!='')
                    {
                        $s_where.=" AND us.s_email LIKE '%".get_formatted_string($search_variable["s_owner_email"])."%' ";
                    }
                    if(trim($search_variable["s_property_name"])!='')
                    {
                        $s_where.=" AND s_property_name LIKE '%".get_formatted_string($search_variable["s_property_name"])."%' ";
                    }
                    if(trim($search_variable["s_booking_id"])!='')
                    {
                        $s_where.=" AND s_booking_id  = '".get_formatted_string($search_variable["s_booking_id"])."' ";
                    }
                    if(trim($search_variable["s_property_id"])!='')
                    {
                        $s_where.=" AND s_property_id = '".get_formatted_string($search_variable["s_property_id"])."' ";
                    }

                    if(trim($search_variable["d_date_from"])!="")
                    {
                        $dt_start=date("Y-m-d",strtotime(trim($search_variable["d_date_from"]." "))) ; 
                        $s_where.=" And FROM_UNIXTIME( dt_cancellation_approve_date , '%Y-%m-%d' ) >='".$dt_start."' ";
                        unset($dt_start);
                    }
                    if(trim($search_variable["d_date_to"])!="")
                    {
                        $dt_end=date("Y-m-d",strtotime(trim($search_variable["d_date_to"]." "))) ; 
                        $s_where.=" And FROM_UNIXTIME( dt_cancellation_approve_date , '%Y-%m-%d' ) <='".$dt_end."' ";
                        unset($dt_end);
                    }
                    if(trim($search_variable["s_pay_host"])!='all' && trim($search_variable["s_pay_host"])!='')
                    {
                        $s_where.=" AND i_paid_to_host =".(($search_variable["s_pay_host"]=="no")?0:1);
                    }
                    if(trim($search_variable["s_pay_traveler"])!='all' && trim($search_variable["s_pay_traveler"])!='')
                    {
                        $s_where.=" AND i_paid_to_traveler =".(($search_variable["s_pay_traveler"]=="no")?0:1);
                    }
                    if(trim($search_variable["s_tax_withdraw"])!='all' && trim($search_variable["s_tax_withdraw"])!='')
                    {
                        $s_where.=" AND i_tax_withdrawn =".(($search_variable["s_tax_withdraw"]=="no")?0:1);
                    }
                    if(trim($search_variable["s_commission_withdraw"])!='all' && trim($search_variable["s_commission_withdraw"])!='')
                    {
                        $s_where.=" AND i_site_commision_withdrawn =".(($search_variable["s_commission_withdraw"]=="no")?0:1);
                    }
                    if(trim($search_variable["d_check_in_date"])!="")
                    {
                        $dt_start=date("Y-m-d",strtotime(trim($search_variable["d_check_in_date"]." "))) ; 
                        $s_where.=" And FROM_UNIXTIME( dt_booked_from , '%Y-%m-%d' ) >='".$dt_start."' ";
                        unset($dt_start);
                    }
                    if(trim($search_variable["d_check_out_date"])!="")
                    {
                        $dt_end=date("Y-m-d",strtotime(trim($search_variable["d_check_out_date"]." "))) ; 
                        $s_where.=" And FROM_UNIXTIME( dt_booked_to , '%Y-%m-%d' ) <='".$dt_end."' ";
                        unset($dt_end);
                    }
                    
                    //echo $s_where.'<br/><br/>';
                    /////Storing search values into session///
                    $arr_session    =    array();
                    $arr_session["searching_name"]       =    $this->data['heading'] ;  
                    $arr_session["txt_traveler_name"]    =    $search_variable["s_traveler_name"];
                    $arr_session["txt_traveler_email"]   =    $search_variable["s_traveler_email"];
                    $arr_session["txt_owner_name"]       =    $search_variable["s_owner_name"];
                    $arr_session["txt_owner_email"]      =    $search_variable["s_owner_email"];
                    $arr_session["txt_property_name"]    =    $search_variable["s_property_name"];
                    $arr_session["txt_property_id"]      =    $search_variable["s_property_id"];
                    $arr_session["txt_booking_id"]       =    $search_variable["s_booking_id"]; 
                    $arr_session["txt_date_from"]        =    $search_variable["d_date_from"];
                    $arr_session["txt_date_to"]          =    $search_variable["d_date_to"];
                    $arr_session["opt_pay_host"]         =    $search_variable["s_pay_host"];
                    $arr_session["opt_pay_traveler"]     =    $search_variable["s_pay_traveler"];
                    $arr_session["opt_tax_withdraw"]     =    $search_variable["s_tax_withdraw"];
                    $arr_session["opt_commission_withdraw"]=    $search_variable["s_commission_withdraw"];
                    $arr_session["txt_check_in_date"]    =    $search_variable["d_check_in_date"];
                    $arr_session["txt_check_out_date"]   =    $search_variable["d_check_out_date"];
                    
                    
                    $this->session->set_userdata('arr_session',$arr_session);
                    $this->session->set_userdata("h_search",$s_search);
                    
                    $this->data["h_search"]             =    $s_search;
                    $this->data["txt_traveler_name"]    =    get_unformatted_string($search_variable["s_traveler_name"]);
                    $this->data["txt_traveler_email"]   =    get_unformatted_string($search_variable["s_traveler_email"]);
                    $this->data["txt_owner_name"]       =    get_unformatted_string($search_variable["s_owner_name"]);
                    $this->data["txt_owner_email"]      =    get_unformatted_string($search_variable["s_owner_email"]);
                    $this->data["txt_property_name"]    =    get_unformatted_string($search_variable["s_property_name"]);
                    $this->data["txt_booking_id"]       =    get_unformatted_string($search_variable["s_booking_id"]);
                    $this->data["txt_property_id"]      =    get_unformatted_string($search_variable["s_property_id"]);
                    $this->data["txt_check_in_date"]    =    $search_variable["d_check_in_date"];
                    $this->data["txt_check_out_date"]   =    $search_variable["d_check_out_date"];
                    $this->data["txt_date_from"]        =    $search_variable["d_date_from"];
                    $this->data["txt_date_to"]          =    $search_variable["d_date_to"]; 
                    $this->data["opt_pay_host"]         =    $search_variable["s_pay_host"]; 
                    $this->data["opt_pay_traveler"]     =    $search_variable["s_pay_traveler"]; 
                    $this->data["opt_tax_withdraw"]     =    $search_variable["s_tax_withdraw"]; 
                    $this->data["opt_commission_withdraw"]=  $search_variable["s_commission_withdraw"]; 
                    
                    /////end Storing search values into session///                
                    
                }
                else////List all records, **not done
                {
                    $s_where=" WHERE e_status='Cancelled and Approved by admin'  ";
                    /////Releasing search values from session///
                    $this->session->unset_userdata("arr_session");
                    $this->session->unset_userdata("h_search");
                    
                    $this->data["h_search"]             = $s_search;
                    $this->data["txt_traveler_name"]    =    "";
                    $this->data["txt_traveler_email"]   =    "";
                    $this->data["txt_owner_name"]       =    "";
                    $this->data["txt_owner_email"]      =    "";
                    $this->data["txt_property_name"]    =    "";
                    $this->data["txt_booking_id"]       =    "";
                    $this->data["txt_property_id"]      =    "";
                    $this->data["txt_check_in_date"]    =    "";
                    $this->data["txt_check_out_date"]   =    "";
                    $this->data["txt_date_from"]        =    "";
                    $this->data["txt_date_to"]          =    "";                    
                    $this->data["opt_pay_host"]         =    "all";                    
                    $this->data["opt_pay_traveler"]     =    "all";                    
                    $this->data["opt_tax_withdraw"]     =    "all";                    
                    $this->data["opt_commission_withdraw"]=    "all";                    
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
                $arr_sort         = array(0=>'b.dt_cancellation_approve_date'); 
                
                
                $s_order_name     = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];          
                $limit            = $this->i_admin_page_limit;
                $info             = $this->mod_property->fetch_cancellation_order_list($s_where,$s_order_name,$order_by,intval($start),$limit);
                
                /////////Creating List view for displaying/////////
                $table_view        = array();  
                $order_name        = empty($order_name)?encrypt($arr_sort[0]):$order_name; 

                
                $this->data['total_booking']    =    $this->mod_property->gettotal_property_booking_order($s_where); // number of records

                          
                //////Table Headers, with width,alignment///////
                $table_view["caption"]                = "Booking Details";
                $table_view["total_rows"]             = count($info);
                $table_view["total_db_records"]       = $this->data['total_booking'] ;
                $table_view["order_name"]             = $order_name;
                $table_view["order_by"]               = $order_by;
                $table_view["src_action"]             = $this->pathtoclass.$this->router->fetch_method(); 
                $table_view["detail_view"]            = false;
                            
                $table_view["headers"][0]["width"]    = "40%";
                $table_view["headers"][0]["align"]    = "left";            
                $table_view["headers"][0]["val"]      = "Booking Information";
                $table_view["headers"][1]["sort"]     = array('field_name'=>encrypt($arr_sort[0])); 
                $table_view["headers"][1]["width"]    = "45%";
                $table_view["headers"][1]["val"]      = "Cancellation Detals";
             

                $table_view["headers"][2]["width"]    = "15%";
                $table_view["headers"][2]["val"]      = "Status";

               
                
                //////end Table Headers, with width,alignment///////
                
                /////////Table Data/////////
                for($i=0; $i<$table_view["total_rows"]; $i++)
                {
                    $i_col=0;
                    $table_view["tablerows"][$i][$i_col++]    = encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                    
                    $table_view["tablerows"][$i][$i_col++]    = "<table><tr><td width='30%'>Booking Id :</td><td>"."<a  href='javascript:void(0);' onclick='show_booking_details(\"".encrypt($info[$i]["id"])."\");' >".$info[$i]["s_booking_id"]."</a></td></tr>
                                                                        <tr><td >Property Name :</td><td colspan='3'><a  href='javascript:void(0);' onclick='show_property_details(\"".encrypt($info[$i]["i_property_id"])."\");' >".$info[$i]["s_property_name"]."</a></td></tr>
                                                                        <tr><td >Owner Name :</td><td colspan='3'><a  href='javascript:void(0);' onclick='show_user_details(\"".encrypt($info[$i]["i_owner_user_id"])."\");' >".ucfirst($info[$i]["owner_first_name"])." ".ucfirst($info[$i]["owner_last_name"])."</a></td></tr>
                                                                        <tr><td >Owner Email :</td><td colspan='3'>".$info[$i]["owner_email"]."</td></tr>
                                                                        <tr><td >Traveler Name :</td><td colspan='3'><a  href='javascript:void(0);' onclick='show_user_details(\"".encrypt($info[$i]["i_traveler_user_id"])."\");' >".ucfirst($info[$i]["s_first_name"])." ".ucfirst($info[$i]["s_last_name"])."</a></td></tr>
                                                                        <tr><td >Traveler Email :</td><td colspan='3'>".$info[$i]["s_email"]."</td></tr>   </table>" ;
                    $booking_link  = '';
                    $end_link      = '';
                    if($info[$i]["e_status"]=='Amount paid')
                    {
                        $booking_link   =    "<a  href='javascript:void(0);' onclick='show_booking_details(\"".encrypt($info[$i]["id"])."\");' >" ;
                        $end_link       =    "</a>";
                    }
                                                                        
                    $table_view["tablerows"][$i][$i_col++]    = "<table>
                                                                        <tr><td width='52%'  >Cancellation Approve Date :</td><td >".$info[$i]["dt_cancellation_approve_date"]."</td></tr>
                                                                        <tr><td>Cancellation Name /Percentage :</td><td>".$info[$i]["cancellation_policy_name"].' ('.$info[$i]["d_cancellation_percentage"].'%)'."</td></tr>
                                                                       
                                                                        
                                                                        <tr><td colspan='2'>   
                                                                            <table>
                                                                            <tr><td width='35%'>Cancellation Charge :</td><td>".$info[$i]["s_currency_symbol"].$info[$i]["d_cancellation_amount"]."</td>
                                                                            <td width='30%'>Pay to Host :</td><td>".$info[$i]["s_currency_symbol"].$info[$i]["d_host_amount"]."</td></tr>
                                                                            
                                                                            <tr><td>Service Tax :</td><td>".$info[$i]["s_currency_symbol"].$info[$i]["d_service_charge_amount"]."</td>
                                                                            <td>Site Commission :</td><td>".$info[$i]["s_currency_symbol"].$info[$i]["d_site_commission_amount"]."</td></tr>
                                                                            
                                                                        
                                                                          </table>
                                                                        </td></tr>
                                                                         <tr><td>Refund Amount to traveler:</td><td>".$info[$i]["s_currency_symbol"].$info[$i]["d_refund_amount"]."</td></tr>
                                                                        <tr><td>Total Amount Paid :</td><td>".$info[$i]["s_currency_symbol"].$info[$i]["d_amount_paid"]."</td></tr>
                                                                        </table>" ;
                                                                        
                   /* $table_view["tablerows"][$i][$i_col++]    = "<table>
                                                                        <tr><td width='50%'>Payment Date :</td><td>".$info[$i]["dt_paid_on"]."</td></tr>
                                                                        <tr><td>Paid Amount :</td><td>".$info[$i]["s_currency_symbol"].$info[$i]["d_amount_paid"]."</td></tr>
                                                                        <tr><td>Service Charge :</td><td>".$info[$i]["s_currency_symbol"].$info[$i]["d_service_charge_amount"]."</td></tr>
                                                                        <tr><td >Site Commission :</td><td>".$info[$i]["s_currency_symbol"].$info[$i]["d_site_commission_amount"]."</td></tr>
                                                                       
                                                                        </table>" ;            */
                      
                    
                    $action     =   '';
                    if($info[$i]["i_paid_to_host"])
                    {
                        $action     .=   '<br/><br/><span>Paid to host</span>' ;
                    }
                    else
                    {
                        $action     .=   '<br/><br/><span><a href="javascript:void(0);" onclick="reportAction(\''.encrypt($info[$i]["id"]).'\',\'pay_to_host\',this);">Pay to host</a></span>' ; 
                    }
                    if($info[$i]["i_paid_to_traveler"])
                    {
                        $action     .=   '<br/><br/><span>Paid to traveler</span>' ;
                    }
                    else
                    {
                        $action     .=   '<br/><br/><span><a href="javascript:void(0);" onclick="reportAction(\''.encrypt($info[$i]["id"]).'\',\'pay_to_traveler\',this);">Pay to traveler</a></span>' ; 
                    }
                    if($info[$i]["i_tax_withdrawn"])
                    {
                        $action     .=   '<br/><br/><span>Tax withdrawn</span>' ;
                    }
                    else
                    {
                        $action     .=   '<br/><br/><span><a href="javascript:void(0);" onclick="reportAction(\''.encrypt($info[$i]["id"]).'\',\'withdraw_tax\',this);">Withdraw tax</a></span>' ; 
                    }
                    if($info[$i]["i_site_commision_withdrawn"])
                    {
                        $action     .=   '<br/><br/><span>Commission withdrawn</span>' ;
                    }
                    else
                    {
                        $action     .=   '<br/><br/><span><a href="javascript:void(0);" onclick="reportAction(\''.encrypt($info[$i]["id"]).'\',\'withdraw_commission\',this);" >Withdraw Commission</a></span>' ;  
                    }  
                   
                   $table_view["tablerows"][$i][$i_col++]    = '<strong>'.$info[$i]["e_status"].'</strong>'.$action;  

               }   

                /////////end Table Data/////////
                unset($i,$i_col,$start,$limit);
                
                $this->data["table_view"]=$this->admin_showin_order_table($table_view);
                /////////Creating List view for displaying/////////
                $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
                
                $this->data['arr_status']   =   array('all'=>'All','yes'=>'Yes','no'=>'No');
                            
                $this->render();          
                unset($table_view,$info,$arr_sort,$s_order_name,$order_name);
             
             
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
        //echo $this->router->fetch_method();exit();
        try
        {}
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
    public function remove_information($i_id=0)
    {
        try
        {}
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
    {}
    
    public function booking_details($booking_id='')
    {
        try
        {
            if($booking_id)
            {
                $this->data['info_booking']  =   $this->mod_property->fetch_booking_details(decrypt($booking_id));;
                $s_tablename    =   $this->db->BOOKINGGUESTS ;
                $arr_where      =   array('i_booking_id'=>decrypt($booking_id));
                $this->data['info_guest']    =   $this->mod_common->common_fetch($s_tablename,$arr_where);
                
                //pr($this->data['info_booking']);
                //pr($this->data['info_guest']);
            
            }
            //$this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_js("images/slide/jquery.ad-gallery.js");///include main css
            //$this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
           
            $this->render("manage_booking/booking_details",TRUE);
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    /**
    * This is a ajax function to update the status
    * 
    */
    function ajax_report_status()
    {
        try
        {
            $booking_id    =    trim($this->input->post('booking_id'));   
            $status        =    trim($this->input->post('status'));
            
            $s_tablename    =   $this->db->BOOKING ;
            $arr_where      =   array('i_id'=>decrypt($booking_id));
            $info_update    =   array();
            if($status=='pay_to_host')
            {
                $info_update['i_paid_to_host']  =   1;
                
            }
            else if($status=='withdraw_tax')
            {
                $info_update['i_tax_withdrawn']  =   1;
            }
            else if($status=='withdraw_commission')
            {
                $info_update['i_site_commision_withdrawn']  =   1;
            }
            else if($status=='pay_to_traveler')
            {
                $info_update['i_paid_to_traveler']  =   1;
            }
            
            $i_aff  =   $this->mod_common->common_edit_info($s_tablename,$info_update,$arr_where);
            
            if($i_aff)
            {
                echo 'ok'; 
            }
            else
            {
                echo 'error';
            }
            unset($booking_id,$status,$s_tablename,$arr_where,$info_update);

        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
   
 
    
    public function __destruct()
    {}
    
    
}
?>