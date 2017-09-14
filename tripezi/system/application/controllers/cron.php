<?php

class Cron extends My_Controller {

	function __construct()
	{
		parent::__construct();
		
      	//$this->load->model('automail_model');
		
		$this->load->model('cron_model');
	}
	
	function send_logged_email()
	{	
        set_time_limit(0);
		$i_max_execution_time=59;////in seconds
        $data=$this->data;
		$start_time	=	time();
        
       
        $fp=fopen(BASEPATH.'../lock_email/email_log_lock.txt','w');
        if(!$fp)
            return;
		
        if(!flock($fp, LOCK_EX))
            return;
        
        $current_time    =    time();
        if($current_time-$start_time >$i_max_execution_time)
            return;
        
        ftruncate($fp, 0); // truncate file
        fwrite($fp, date('Y-m-d H:i:s')."\n");
        
		while(1)
		{
			
			$email_results	=	$this->cron_model->fetch_multi();  // get all email logs from email-log table
			//pr($email_results,1);			
			if(!empty($email_results))
			{
				foreach($email_results as $email_result_row)
				{
					$to					=   $email_result_row['s_to_emails'];
					$from				=	$email_result_row['s_from_email'];
					$subject    		=	$email_result_row['s_subject'];
					$content    		=   $email_result_row['s_body'];
					$dt_posted_in_log 	=   $email_result_row['dt_posted_in_log'];
					
					/*echo '<br />to :'.$to			;
					echo '<br />From :'.$from		;
					echo '<br />Subject :'.$subject ;
					echo '<br />Content :'.$content ;
					echo '<br />Date :'.$dt_posted_in_log ;					
					exit;*/
                  
                    $this->load->helper('mail'); 
					//$i_send = sendMail($to,$subject,$content,$from);
					
                    //removing mails which are delayed for more than 24hrs.
                   /* if(strtotime(now())-strtotime($dt_posted_in_log)>3600*24)
                    {
                        $this->cron_model->delete_email_log($email_result_row['i_id']);
                    }
					elseif($this->automail_model->send_mail($to,$from,$subject,$content))
					{
						$this->cron_model->delete_email_log($email_result_row['i_id']);
						//echo "<br />Sent : ". $email_result_row['i_id']."<br /><hr/>";
					}*/	
					
					$date = date("Y-m-d H:i:s");
					//removing mails which are delayed for more than 24hrs.
					/*if(strtotime('-1 day')<strtotime($dt_posted_in_log))*/
					if(strtotime($date)-strtotime($dt_posted_in_log)>3600*24)
                    {
                        $this->cron_model->delete_email_log($email_result_row['i_id']);
                    }
					elseif(sendMail($to,$subject,$content,$from))
					{
						$this->cron_model->delete_email_log($email_result_row['i_id']);
						//echo "<br />Sent : ". $email_result_row['i_id']."<br /><hr/>";
					}
					
					$current_time	=	time();
					if($current_time-$start_time >$i_max_execution_time)
					{						
						break;
					}
				}
			}
			
			$current_time	=	time();
			if($current_time-$start_time >$i_max_execution_time)
			{
				break;
			}
			sleep(1);
		}	
		
		echo  "Done";
		flock($fp, LOCK_UN); // release the lock
        fclose($fp);
	}
    
    function check_booking_payment()
    {
        try
        {
            
           $this->load->model('common_model','mod_common');
           $s_tablename     =   $this->db->BOOKING ;
           $arr_where       =   array('e_status'=>'Approve by user','dt_approved_on <'=>strtotime('-1 days')) ; 
           
           $info_booking    =   $this->mod_common->common_fetch($s_tablename,$arr_where);
           
          if(!empty($info_booking))
          {
              $info_update  =   array('e_status'=>'Not Paid');
              foreach($info_booking as $val)
              {
                    $arr_where  =   array('i_id'=>$val['i_id']) ;
                    $i_ret      =   $this->mod_common->common_edit_info($s_tablename,$info_update,$arr_where);      
                  
              }
          }
            
          unset($s_tablename,$arr_where,$info_booking,$info_update) ; 
            
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    
    function check_in_date_passed()
    {
        try
        {
           
             $this->load->model('property_model','mod_property');
             $s_where   =   " WHERE e_status='Amount paid' AND dt_booked_from<".strtotime('-1 day')." AND i_paid_to_host=0 "  ;
             
             $info  =   $this->mod_property->fetch_booking_front_end($s_where);

             if(!empty($info))
             {
                  /****************** After payment done send email to traveller ******************/ 
                   $this->load->model("auto_mail_model","mod_auto");
                   $content         =   $this->mod_auto->fetch_mail_content('check_in_date_passed');    
                   $filename        =   $this->config->item('EMAILBODYHTML')."common.html";
                   $handle          =   @fopen($filename, "r");
                   $mail_html       =   @fread($handle, filesize($filename));    
                   $s_subject       =   $content['s_subject'];        
                    //print_r($content); exit;    
                    foreach($info as $val)
                    {
                        if(!empty($content))
                        {                    
                            $description = $content["s_content"];
                            
                            $description = str_replace("###BOOKING_ID###",$val['s_booking_id'],$description);    
                            $description = str_replace("###CHECK_IN_DATE###",$val['dt_booked_from'],$description);        
                            $description = str_replace("###OWNER###",ucfirst($val['owner_first_name']).' '.ucfirst($val['owner_last_name']),$description);        
                            $description = str_replace("###HOST_AMOUNT###",$val['s_currency_symbol'].$val['d_host_amount'],$description);        
                        }
                            
                        $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);    
                        $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);    
                       
                        
                        /// Mailing code...[start]
                        $site_admin_email = $this->s_admin_email;    
                        $this->load->helper('mail');                                        
                        $i_sent = sendMail($this->s_admin_email,$s_subject,$mail_html);
                        /////////// End of sending email /////////////
                        
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
	

   /* function execute_logged_sql()
    {    
        set_time_limit(0);
        $i_max_execution_time=59;////in seconds
        $data=$this->data;
        $start_time    =    time();
        
        $fp=fopen(BASEPATH.'../dynfiles/lock/sql_log_lock.txt','w');
        if(!$fp)
            return;
        
        if(!flock($fp, LOCK_EX))
            return;
        
        $current_time    =    time();
        if($current_time-$start_time >$i_max_execution_time)
            return;
        
        ftruncate($fp, 0); // truncate file
        fwrite($fp, date('Y-m-d H:i:s')."\n");
        
        while(1)
        {
            $results    =    $this->cron_model->get_all_sql_log();
            
            if(!empty($results))
            {
                foreach($results as $result_row)
                {
                    $sqls= @unserialize($result_row['s_serial_sql']);
                    if(!empty($sqls))
                    {
                        foreach($sqls as $sql)
                        {
                            $this->db->simple_query($sql);
                        }
                        unset($sqls,$sql);
                    }
                    $this->cron_model->delete_sql_log($result_row['i_id']);    
                     
                    $current_time    =    time();
                    if($current_time-$start_time >$i_max_execution_time)
                    {                        
                        break;
                    }
                }///end for
                unset($results,$result_row);
            }
            
            $current_time    =    time();
            if($current_time-$start_time >$i_max_execution_time)
            {
                break;
            }
            sleep(1);
        }    
        
        echo  "Done";
        flock($fp, LOCK_UN); // release the lock
        fclose($fp);        
    }*/
		
   
}
