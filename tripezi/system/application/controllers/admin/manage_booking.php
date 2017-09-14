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


class Manage_booking extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public $thumbDisplayPath;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']            =    "Manage Booking";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]    =    "No information found about booking.";
       
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
            $this->data['heading']="Manage Booking";////Package Name[@package] Panel Heading

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
            
            $search_variable["e_status"]            = ($this->input->post("h_search")?$this->input->post("opt_status"):$arr_session_data["opt_status"]); 
            
            $search_variable["s_booking_id"]        = ($this->input->post("h_search")?$this->input->post("txt_booking_id"):$arr_session_data["txt_booking_id"]); 
            
            $search_variable["s_property_id"]       = ($this->input->post("h_search")?$this->input->post("txt_property_id"):$arr_session_data["txt_property_id"]); 
            
            $search_variable["d_check_in_date"]     = ($this->input->post("h_search")?$this->input->post("txt_check_in_date"):$arr_session_data["txt_check_in_date"]); 
            $search_variable["d_check_out_date"]    = ($this->input->post("h_search")?$this->input->post("txt_check_out_date"):$arr_session_data["txt_check_out_date"]); 
            
            $search_variable["d_date_from"]         = ($this->input->post("h_search")?$this->input->post("txt_date_from"):$arr_session_data["txt_date_from"]); 
            
            $search_variable["d_date_to"]         = ($this->input->post("h_search")?$this->input->post("txt_date_to"):$arr_session_data["txt_date_to"]); 
            
         
            
            ////////end Getting Posted or session values for search///
            
            $s_where=" WHERE 1  ";
           
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
                if(trim($search_variable["e_status"])!='')
                {
                    $s_where.=" AND e_status  = '".get_formatted_string($search_variable["e_status"])."' ";
                }
                if(trim($search_variable["s_property_id"])!='')
                {
                    $s_where.=" AND s_property_id  ='".get_formatted_string($search_variable["s_property_id"])."' ";
                }
                
                
                if(trim($search_variable["d_check_in_date"])!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($search_variable["d_check_in_date"]." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( dt_booked_from , '%Y-%m-%d' ) >='".$dt_start."' ";
                    unset($dt_start);
                }
                if(trim($search_variable["d_check_out_date"])!="")
                {
                    $dt_end=date("Y-m-d",strtotime(trim($search_variable["dt_to"]." "))) ; 
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
                $arr_session["opt_status"]           =    $search_variable["e_status"];
                $arr_session["txt_check_in_date"]    =    $search_variable["d_check_in_date"];
                $arr_session["txt_check_out_date"]   =    $search_variable["d_check_out_date"];
                $arr_session["txt_date_from"]        =    $search_variable["d_date_from"];
                $arr_session["txt_date_to"]          =    $search_variable["d_date_to"];
                
                
                $this->session->set_userdata('arr_session',$arr_session);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]             =    $s_search;
                $this->data["txt_traveler_name"]    =    get_unformatted_string($search_variable["s_traveler_name"]);
                $this->data["txt_traveler_email"]   =    get_unformatted_string($search_variable["s_traveler_email"]);
                $this->data["txt_owner_name"]       =    get_unformatted_string($search_variable["s_owner_name"]);
                $this->data["txt_owner_email"]      =    get_unformatted_string($search_variable["s_owner_email"]);
                $this->data["txt_property_name"]    =    get_unformatted_string($search_variable["s_property_name"]);
                $this->data["txt_booking_id"]       =    get_unformatted_string($search_variable["s_booking_id"]);
                $this->data["opt_status"]           =    get_unformatted_string($search_variable["e_status"]);
                $this->data["txt_property_id"]      =    get_unformatted_string($search_variable["s_property_id"]);
                $this->data["txt_check_in_date"]    =    $search_variable["d_check_in_date"];
                $this->data["txt_check_out_date"]   =    $search_variable["d_check_out_date"];
                $this->data["txt_date_from"]        =    $search_variable["d_date_from"];
                $this->data["txt_date_to"]          =    $search_variable["d_date_to"]; 
                
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE 1  ";
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
                $this->data["opt_status"]           =    "";
                $this->data["txt_property_id"]      =    "";
                $this->data["txt_check_in_date"]    =    "";
                $this->data["txt_check_out_date"]   =    "";
                $this->data["txt_date_from"]        =    "";
                $this->data["txt_date_to"]          =    "";                    
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
            $arr_sort         = array(0=>'b.dt_booked_on'); 
            $s_order_name     = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];          
            $limit            = $this->i_admin_page_limit;
            $info             = $this->mod_property->fetch_booking_order_list($s_where,$s_order_name,$order_by,intval($start),$limit);
            
            /////////Creating List view for displaying/////////
            $table_view        = array();  
            $order_name        = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
                      
            //////Table Headers, with width,alignment///////
            $table_view["caption"]                = "Booking Details";
            $table_view["total_rows"]             = count($info);
            $table_view["total_db_records"]       = $this->mod_property->gettotal_property_booking_order($s_where);
            $table_view["order_name"]             = $order_name;
            $table_view["order_by"]               = $order_by;
            $table_view["src_action"]             = $this->pathtoclass.$this->router->fetch_method(); 
            $table_view["detail_view"]            = false;
                        
            $table_view["headers"][0]["width"]    = "30%";
            $table_view["headers"][0]["align"]    = "left";            
            $table_view["headers"][0]["val"]      = "Proprety Name";
            $table_view["headers"][1]["width"]    = "30%";
            $table_view["headers"][1]["val"]      = "Booking Information";
            $table_view["headers"][2]["sort"]     = array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][2]["width"]    = "10%";
            $table_view["headers"][2]["val"]      = "Booked On";
            $table_view["headers"][3]["width"]    = "10%";
            $table_view["headers"][3]["val"]      = "Status";

           
            
            //////end Table Headers, with width,alignment///////
            
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]    = encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                
                $table_view["tablerows"][$i][$i_col++]    = "<table><tr><td width='30%'>Property Id</td><td>".$info[$i]["s_property_id"]."</td></tr>
                                                                    <tr><td>Property Name</td><td><a  href='javascript:void(0);' onclick='show_property_details(\"".encrypt($info[$i]["i_property_id"])."\");' >".$info[$i]["s_property_name"]."</a></td></tr>
                                                                    <tr><td>Owner Name</td><td><a  href='javascript:void(0);' onclick='show_user_details(\"".encrypt($info[$i]["i_owner_user_id"])."\");' >".ucfirst($info[$i]["owner_first_name"])." ".ucfirst($info[$i]["owner_last_name"])."</a></td></tr>
                                                                    <tr><td>Email</td><td>".$info[$i]["owner_email"]."</td></tr></table>" ;
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
                                                                    <tr><td colspan=\"2\" >from ".$info[$i]["dt_booked_from"]." to ".$info[$i]["dt_booked_to"]." ,&nbsp;&nbsp;&nbsp;&nbsp; No of ".$booking_link."Guests(".$info[$i]["i_total_guests"].")".$end_link."</td></tr>
                                                                    </table>" ;
                                                                    
                $table_view["tablerows"][$i][$i_col++]    = $info[$i]["dt_booked_on"];   
                 
                
                
                $action ='';
               
                
                // details view of user
                

                if($info[$i]["e_status"] == 'Cancelled')
                {
                    $action .='<br/><br/><a id="testing" href="javascript:void(0);" style="text-decoration: none;"  onclick="cancellationApproval(\''.encrypt($info[$i]["id"]).'\',\'reject\',this);"><img width="12" height="12" title="Reject" alt="Reject" src="images/admin/inactive.png">&nbsp;&nbsp;Reject</a>';
                    $action .='<br/><a  href="javascript:void(0);" style="text-decoration: none;" onclick="cancellationApproval(\''.encrypt($info[$i]["id"]).'\',\'approve\',this);"><img width="12" height="12" alt="Approve" title="Approve" src="images/admin/active.png">&nbsp;&nbsp;Approve</a>';
                }

               $table_view["tablerows"][$i][$i_col++]    = '<strong>'.$info[$i]["e_status"].'</strong>'.$action;     

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit);
            
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            
            
            $this->data['arr_booking_status']   =   $this->db->BOOKING_STATUS ;
                        
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
    
    function ajax_cancellation()
    {
        try
        {
            if($_POST)
            {
                $booking_id     =   trim($this->input->post("booking_id"));
                $status         =   trim($this->input->post("status"));
                
                $s_where        =   " WHERE b.i_id=".decrypt($booking_id) ;
                $info_booking   =   $this->mod_property->fetch_booking_order_list($s_where);
                
                $s_tablename    =   $this->db->BOOKING ;
                $arr_where      =   array('i_id'=>decrypt($booking_id));
                $info_update    =   array();
                if($status=="reject")
                {
                    $info_update['e_status']    =   'Amount paid' ;
                }
                else if($status=="approve")
                {
                    $info_update['e_status']                    =   'Cancelled and Approved by admin' ;
                    $info_update['d_cancellation_amount']       =   (($info_booking[0]['d_host_amount']+$info_booking[0]['d_site_commission_amount'])*$info_booking[0]['d_cancellation_percentage'])/100;
                    $info_update['d_refund_amount']             =   (($info_booking[0]['d_host_amount']+$info_booking[0]['d_site_commission_amount'])-$info_update['d_cancellation_amount']);
                    $info_update['dt_cancellation_approve_date']=   time();
                }
               
                
                $i_aff  =   $this->mod_common->common_edit_info($s_tablename,$info_update,$arr_where);
               
                if($i_aff)
                {
                      $booking_details    = "BOOKING ID : ".$info_booking[0]['s_booking_id']."<br/>".
                                            "BOOKED ON : ".$info_booking[0]['dt_booked_on']."<br/>".
                                            "BOOKING FROM : ".$info_booking[0]['dt_booked_from']." TO ".$info_booking[0]['dt_booked_to'] ;
                                            
                      $this->load->model('assets_model');
                      
                      $info_cancellation    =   $this->assets_model->fetch_this_cancellation_policy($info_booking[0]['i_cancellation_id']);
                                            
                      $cancellation_details=    'Refund Price : '.$info_booking[0]['s_currency_symbol'].$info_update['d_refund_amount'].'<br/>'
                                                .'Cancellation Percentage : '.$info_booking[0]['d_cancellation_percentage'].'%'
                                                .'&nbsp;&nbsp;&nbsp;&nbsp;Cancellation Policy : '.$info_cancellation['s_name'].'<br/>'.$info_cancellation['s_description'] ;
                                                 
                   
                      if($status=="reject")
                      {
                          /* for cancellation rejected to the traveler */
                           $this->load->model("auto_mail_model","mod_auto");
                           $content         =   $this->mod_auto->fetch_mail_content('booking_cancel_rejected');    
                           $filename        =   $this->config->item('EMAILBODYHTML')."common.html";
                           $handle          =   @fopen($filename, "r");
                           $mail_html       =   @fread($handle, filesize($filename));    
                           $s_subject       =   $content['s_subject'];        
                            //print_r($content); exit;    
                                            
                            if(!empty($content))
                            {                    
                                $description = $content["s_content"];
                                $description = str_replace("###OWNER###",ucfirst($info['owner_first_name']).' '.ucfirst($info['owner_last_name']),$description);    
                                $description = str_replace("###TRAVELER###",ucfirst($info_booking[0]['s_first_name']).' '.ucfirst($info_booking[0]['s_last_name']),$description);    
                                $description = str_replace("###PROPERTY###",$info_booking[0]['s_property_name'],$description);        
                                $description = str_replace("###CANCELATION_DATE###",$info_booking[0]['dt_canceled_on'],$description);
                                $description = str_replace("###BOOKING_DETAILS###",$booking_details,$description);
                               
                            }
                                
                            $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);    
                            $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);    
                            
                             
                             $email_address   =   $info_booking[0]['s_email'] ;
                             
                            
                            /// Mailing code...[start]
                            $site_admin_email = $this->s_admin_email;    
                            $this->load->helper('mail');                                        
                            $i_sent = sendMail($email_address,$s_subject,$mail_html);

                      }
                      else if($status=="approve")
                      {
                          /************* EMAIL TO OWNER ************/   
                          
                          /* for booking cancelation mail to the owner */
                           $this->load->model("auto_mail_model","mod_auto");
                           $content         =   $this->mod_auto->fetch_mail_content('booking_cancel_owner');    
                           $filename        =   $this->config->item('EMAILBODYHTML')."common.html";
                           $handle          =   @fopen($filename, "r");
                           $mail_html       =   @fread($handle, filesize($filename));    
                           $s_subject       =   $content['s_subject'];        
                            //print_r($content); exit;    
                                            
                            if(!empty($content))
                            {                    
                                $description = $content["s_content"];
                                $description = str_replace("###OWNER###",ucfirst($info['owner_first_name']).' '.ucfirst($info['owner_last_name']),$description);    
                                $description = str_replace("###PROPERTY###",$info_booking[0]['s_property_name'],$description);        
                                $description = str_replace("###TRAVELER###",ucfirst($info_booking[0]['s_first_name']).' '.ucfirst($info_booking[0]['s_last_name']),$description);                        
                                $description = str_replace("###BOOKING_DETAILS###",$booking_details,$description);                        
                                $description = str_replace("###CANCELATION_DATE###",$info_booking[0]['dt_canceled_on'],$description);                        
                                $description = str_replace("###ADMIN_CONFIRM_CANCELATION_DATE###",date('d-m-Y',$info_update['dt_cancellation_approve_date']),$description); 
                                $description = str_replace("###CANCELLATION_DETAILS###",$cancellation_details,$description); 
                            }
                                
                            $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);    
                            $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);    
                           
                            $email_address   =   $info_booking[0]['owner_email'] ; 

                            
                            
                            /// Mailing code...[start]
                            $site_admin_email = $this->s_admin_email;    
                            $this->load->helper('mail');                                        
                            $i_sent = sendMail($email_address,$s_subject,$mail_html);
                            
                           
                            /************* EMAIL TO TRAVELER ************/
                            
                           // Booking cancelation mail to the traveler 
                           $this->load->model("auto_mail_model","mod_auto");
                           $content         =   $this->mod_auto->fetch_mail_content('booking_cancel_traveler');    
                           $filename        =   $this->config->item('EMAILBODYHTML')."common.html";
                           $handle          =   @fopen($filename, "r");
                           $mail_html       =   @fread($handle, filesize($filename));    
                           $s_subject       =   $content['s_subject'];        
                            //print_r($content); exit;    
                                            
                            if(!empty($content))
                            {                    
                                $description = $content["s_content"];
                                $description = str_replace("###PROPERTY###",$info_booking[0]['s_property_name'],$description);        
                                $description = str_replace("###TRAVELER###",ucfirst($info_booking[0]['s_first_name']).' '.ucfirst($info_booking[0]['s_last_name']),$description);                        
                                $description = str_replace("###BOOKING_DETAILS###",$booking_details,$description);                        
                                $description = str_replace("###CANCELATION_DATE###",$info_booking[0]['dt_canceled_on'],$description);                                               
                                $description = str_replace("###ADMIN_CONFIRM_CANCELATION_DATE###",date('d-m-Y',$info_update['dt_cancellation_approve_date']),$description); 
                                $description = str_replace("###CANCELLATION_DETAILS###",$cancellation_details,$description);
                            }
                                
                            $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);    
                            $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);    
                           
                            $email_address   =   $info_booking[0]['s_email'] ;
                           
                            /// Mailing code...[start]
                            $site_admin_email = $this->s_admin_email;    
                            $this->load->helper('mail');                                        
                            $i_sent = sendMail($email_address,$s_subject,$mail_html);
                      }
                      
                      echo 'ok';
                       
                }
                
                
            }
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
 
    
    public function __destruct()
    {}
    
    
}