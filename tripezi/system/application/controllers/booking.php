<?php
/*********
* Author: Koushik
* Email: koushik.r@acumencs.info
* Date  : 02 Aug 2012
* Modified By: 
* Modified Date: 
*
* This controler is for comunicate with paypal and site
* notify function and successful function and failed function are here  
* 
* @includes My_Controller.php
*/

class Booking extends My_Controller
{
    public function __construct()
    {
        try
        { 
          parent::__construct(); 

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
            //$this->s_meta_type = 'home';
            redirect(base_url().'paypal_ipn/ipn_successful');
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
    
    
    public function ipn_successful()
    {
        try
        {

                # loading meta-data and header-data...
                include_once(APPPATH.'libraries/paypal_IPN/Paypal.php');    
                $data = $this->data;
                $data['title'] = "Payment Success";

                # processing all IPN data...
                $PAYPAL_ENVIRONMENT = 'test';
                //$this->load->model('site_settings_model');
                
                $IPN_OBJ = new paypal;     // initiate an instance of the IPN class...
                $IPN_OBJ->paypal_url = $this->config->item('paypal_url');//$this->site_settings_model->getPaypalURL($PAYPAL_ENVIRONMENT);
      

                if ($IPN_OBJ->validate_ipn()) {

                    
                /************* DATABASE UPDATE ****************/
                
                 $this->load->model('common_model','mod_common');
                 $s_tablename  =    $this->db->TEMPORARY_PAYMENT ;
                 $payment_id   =    $IPN_OBJ->ipn_data['custom']; 
                 $arr_where    =    array('i_id'=>$payment_id);
                 $info_payment =    $this->mod_common->common_fetch($s_tablename,$arr_where);
                 
                 $this->mod_common->common_delete_info($s_tablename,$arr_where);   
                 
                 if($info_payment)
                 {
                     $booking_details   =    $info_payment[0];
                 } 

                 $all_guest     =    explode('||',$booking_details['s_all_guest']) ;     
                 $this->load->model('currency_model','mod_cur');
                 //set the current currency rate
                 $info_currency =   $this->mod_cur->fetch_multi();

                 if(!empty($info_currency))
                 {
                     foreach($info_currency as $cur)
                     {
                         switch($cur['s_currency_code'])
                         {
                             case 'USD':
                                        $d_currency_rate_usd    =   $cur['d_currency_rate'] ;
                                        break;
                             case 'GBP':
                                        $d_currency_rate_gbp    =   $cur['d_currency_rate'] ;
                                        break;
                             case 'EURO':
                                        $d_currency_rate_euro   =   $cur['d_currency_rate'] ;
                                        break;
                             default:
                                        break;
                                        
                         }
                         
                         if($cur['id']==$booking_details['i_currency_id'])
                         {
                             $curSymbol =   $cur['s_currency_symbol'];
                         }
                         
                         
                     }
                 }
                 
                 $this->load->model('assets_model');
                 // fetch the current cancellation percentage      
                 $info_cancellation    =   $this->assets_model->fetch_this_cancellation_policy($booking_details['i_cancellation_policy_id']);
                 //sendMail('mrinsss@gmail.com','data1111',$booking_details['total_amount']);  
                 $info_update       =   array();
                    
                 $info_update['e_status']       =   'Amount paid' ; 
                 $info_update['i_currency_id']  =   $booking_details['i_currency_id']; // currency id in session  
                 $info_update['d_currency_rate_gbp']  =   $d_currency_rate_gbp ; 
                 $info_update['d_currency_rate_usd']  =   $d_currency_rate_usd ;    
                 $info_update['d_currency_rate_euro'] =   $d_currency_rate_euro ;   
                 $info_update['dt_paid_on']           =   time() ;   
                 $info_update['s_transaction_details']=   $IPN_OBJ->ipn_data['txn_id']; // Transaction id return by paypal
                 $info_update['i_total_guest']        =   count($all_guest) ;
                 $info_update['d_service_charge_amount']  =   ($booking_details['d_booking_price']*$this->data['d_service_charge_percentage'])/100;
                 $info_update['d_site_commission_amount'] =   ($booking_details['d_booking_price']*$this->data['d_site_comission_percentage'])/100 ;
                 $info_update['d_amount_paid']            =   $booking_details['d_total_amount'] ; 
                 $info_update['d_host_amount']            =   $booking_details['d_booking_price']-$info_update['d_site_commission_amount'] ;
                 
                 $info_update['i_cancellation_id']        =   $booking_details['i_cancellation_policy_id'];
                 $info_update['d_cancellation_percentage']=   $info_cancellation['d_cancellation_charge'];

                 // Update booking table all transaction details
                 $table_name    =   $this->db->BOOKING ;
                 $arr_where     =   array('i_id'=>$booking_details['i_booking_id']) ;  
                 $i_aff         =   $this->mod_common->common_edit_info($table_name,$info_update,$arr_where); 
                 
                 if($i_aff) 
                 {
                     //add all guest to the booking guest table
                      $arr_guest =   array();
                     if(!empty($all_guest))
                     {
                         $info_guest    =   array();
                         $info_guest['i_booking_id']    =   $booking_details['i_booking_id'];
                         $tablename =   $this->db->BOOKINGGUESTS ;
                        
                         foreach($all_guest as $name)
                         {
                             $info_guest['s_name']      =   base64_decode($name);
                             $arr_guest[]               =   $info_guest['s_name'];
                             $this->mod_common->common_add_info($tablename,$info_guest); 
                         }
                      }
                      
                    unset($info_guest,$all_guest) ;                                   
                     
                      
                      
                   $this->load->model('property_model','mod_property') ;  
                   $s_where    =   " WHERE b.i_id=".$booking_details['i_booking_id']." " ;
                   $info_booking   =   $this->mod_property->fetch_booking_order_list($s_where);

                      
                   /************************ START SENDING EMAIL *************************/
                   $this->load->helper('mail'); 
                   
                   $s_booking_details   = '<u><strong>Booking Details</strong></u><br/>'.
                                'Booking Id : '.$info_booking[0]['s_booking_id'].'<br/>'.
                                'Total Guest :'.$info_booking[0]['i_total_guest'].'<br/>'.
                                'Guest Name :'.implode(', ',$arr_guest).'<br/>'.
                                'From Date :'.$info_booking[0]['dt_booked_from'].' To '.$info_booking[0]['dt_booked_to'].'<br/><br/>';
                                
                                   
                 //Create payment details for sending as mail.
                 $s_payment_details   =   '<u><strong>Payment Details</strong></u><br/>'.
                                        'Booking Price :'.$curSymbol.number_format(($info_booking[0]['d_host_amount']+$info_booking[0]['d_site_commission_amount']),2).'<br/>'.
                                        'Service Tax :'.$curSymbol.number_format($info_booking[0]['d_service_charge_amount'],2).'<br/>'.
                                        'Total Amount :'.$curSymbol.number_format($info_booking[0]['d_amount_paid'],2).'<br/>'.
                                        'Transaction Id :'.$info_booking[0]['s_transaction_details'].'<br/><br/>';
                 
                 $traveler_name     =   ucfirst($info_booking[0]['s_first_name']).' '.ucfirst($info_booking[0]['s_last_name']);
                 $owner_name        =   ucfirst($info_booking[0]['owner_first_name']).' '.ucfirst($info_booking[0]['owner_last_name']);
                 
                  /****************** After payment done send email to traveller ******************/ 
                   $this->load->model("auto_mail_model","mod_auto");
                   $content         =   $this->mod_auto->fetch_mail_content('payment_receipt');    
                   $filename        =   $this->config->item('EMAILBODYHTML')."common.html";
                   $handle          =   @fopen($filename, "r");
                   $mail_html       =   @fread($handle, filesize($filename));    
                   $s_subject       =   $content['s_subject'];        
                    //print_r($content); exit;    
                                    
                    if(!empty($content))
                    {                    
                        $description = $content["s_content"];
                        
                        $description = str_replace("###TRAVELER###",$traveler_name,$description);    
                        $description = str_replace("###PROPERTY###",$info_booking[0]['s_property_name'],$description);        
                        $description = str_replace("###BOOKING_DETAIL###",$s_booking_details,$description);        
                        $description = str_replace("###PAYMENT_DETAILS###",$s_payment_details,$description);        
                    }
                        
                    $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);    
                    $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);    
                   
                    
                    /// Mailing code...[start]
                    $site_admin_email = $this->s_admin_email;    
                                                           
                    $i_sent = sendMail($info_booking[0]['s_email'],$s_subject,$mail_html);
                    /////////// End of sending email /////////////
                    
                   /****************** After payment done send email to owner ******************/ 

                   $this->load->model("auto_mail_model","mod_auto");
                   $content         =   $this->mod_auto->fetch_mail_content('payment_confirm_owner');    
                   $filename        =   $this->config->item('EMAILBODYHTML')."common.html";
                   $handle          =   @fopen($filename, "r");
                   $mail_html       =   @fread($handle, filesize($filename));    
                   $s_subject       =   $content['s_subject'];        
                    //print_r($content); exit;    
                                    
                    if(!empty($content))
                    {                    
                        $description = $content["s_content"];
                        
                        $description = str_replace("###OWNER###",$owner_name,$description);    
                        $description = str_replace("###TRAVELER###",$traveler_name,$description);    
                        $description = str_replace("###PROPERTY###",$info_booking[0]['s_property_name'],$description);        
                        $description = str_replace("###BOOKING_DETAIL###",$s_booking_details,$description);                 
                    }
                    $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);    
                    $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);    
                   
                    
                    /// Mailing code...[start]
                    $site_admin_email = $this->s_admin_email;    
                                                           
                    $i_sent = sendMail($info_booking[0]['owner_email'],$s_subject,$mail_html);
                   
                    /////////// End of sending email /////////////  
                    
                    
                    unset($description,$mail_html,$s_subject,$content,$info_booking,$arr_guest,$s_booking_details,$s_payment_details);
                     

                }// End of $i_aff true

            }// End of validate IPN  

        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }// End of ipn_successful
    
    
    
    public function booking_successful($s_booking_id)
    {
        try
        {
           
                    
                   
             //booking done successfully redirect to travell booking page
             $this->session->set_userdata(array('message'=>'Booking payment done successfully.','message_type'=>'succ'));
             redirect(base_url().'my-travel-booking');

        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
        
        
    }
    
    
    /**
    * This frunction call time of booking failed or wrong paypal details
    * 
    */
    public function booking_failed()
    {
        try
        {
             $this->session->set_userdata(array('message'=>'Booking payment failed.','message_type'=>'err'));
             redirect(base_url().'my-travel-booking');
            
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