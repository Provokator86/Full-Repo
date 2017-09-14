<?php
/*********

* Author: Samarendu Ghosh

* Date  : 04 Nov 11

* Modified By: 

* Modified Date: 

* 

* Purpose: 

*  Frontend Knowledge_bank Page
* 

* @includes My_Controller.php

* @implements InfControllerFe.php

*/
class Quote_approve_day_expire extends My_Controller
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  $this->load->model('manage_jobs_model');
		  $this->load->model('manage_buyers_model');
		  $this->load->model('job_model');
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    }



    /***
    * 

    * 

    */

    public function index()
    {
        try
        {
			$before_days = $this->config->item('day_allowed_to_approve_quote');
			$s_where = " WHERE n.i_status=8";
			//$s_where .= " AND FROM_UNIXTIME( n.i_expire_date , '%Y-%m-%d' )=date_format(curdate(), '%Y-%m-%d')";
			$s_where .= " AND FROM_UNIXTIME( n.i_expire_date , '%Y-%m-%d' )=DATE_ADD(curdate(), INTERVAL {$before_days} DAY)";
			
			
			$info = $this->manage_jobs_model->fetch_multi($s_where);
			//pr($info,1);
			$total_db_records=$this->manage_jobs_model->gettotal_info($s_where);
			
			if($total_db_records>0)
			{
				for($i=0;$i<$total_db_records;$i++)
				{
					
					
					$i_job_id = $info[$i]['id'];
					$i_tradesman_id = $info[$i]['i_tradesman_id'];
					/* for job quote mail to the user */
				   $this->load->model('tradesman_model');
				   $s_where = " WHERE n.i_tradesman_user_id={$i_tradesman_id} AND n.i_job_id={$i_job_id} AND n.i_status=1";
				   $job_details = $this->job_model->fetch_quote_multi($s_where,0,1);
				   //echo '==========='.$i_tradesman_id;exit;
				   $tradesman_details = $this->tradesman_model->fetch_this($i_tradesman_id);
				   
				   $s_wh_id = " WHERE n.i_user_id=".$i_tradesman_id." ";
				   $buyer_email_key = $this->manage_buyers_model->fetch_email_keys($s_wh_id);
				   $is_mail_need = in_array('buyer_awarded_job',$buyer_email_key);
				   
				   if($is_mail_need)
				  {
				   $this->load->model('auto_mail_model');
				   $content = $this->auto_mail_model->fetch_contact_us_content('buyer_awarded_job','tradesman');
				   
				   $filename = $this->config->item('EMAILBODYHTML')."common.html";
				   $handle = @fopen($filename, "r");
				   $mail_html = @fread($handle, filesize($filename));						
					//print_r($content); exit;
					if(!empty($content))
					{							
						if($tradesman_details['i_signup_lang'] == 2) // for those tradesman who registered in french version.
						{
							$description = $content["s_content_french"];
						}
						else
						{											
							$description = $content["s_content"];
						}
						$description = str_replace("[service professional name]",$tradesman_details['s_username'],$description);
						$description = str_replace("[Buyer name]",$job_details[0]['job_details']['s_buyer_name'],$description);
						$description = str_replace("[job title]",$job_details[0]['job_details']['s_title'],$description);	
						$description = str_replace("[quote amount]",$job_details[0]['s_quote'],$description);	
						$description = str_replace("[login url]",base_url().'user/login/TVNOaFkzVT0',$description);	
						$description = str_replace("[site_url]",base_url(),$description);
						$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
					}
					//unset($content);
					
					$mail_html = str_replace("[site url]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					//echo $this->data['loggedin']['user_email'];	
					//echo "<br>DESC".$description;	exit;
					
					/// Mailing code...[start]
					$site_admin_email = $this->s_admin_email;
					//echo $site_admin_email; exit;
					$this->load->library('email');
					$config['protocol'] = 'sendmail';
					$config['mailpath'] = '/usr/sbin/sendmail';
					$config['charset'] = 'utf-8';
					$config['wordwrap'] = TRUE;
					$config['mailtype'] = 'html';
										
					$this->email->initialize($config);					
					$this->email->clear();                    
					
					$this->email->from($site_admin_email);	
									
					$this->email->to($tradesman_details['s_email']);
					
					if($tradesman_details['i_signup_lang'] == 2)
					{
						$this->email->subject($content['s_subject_french']);
					}
					else
					{
						$this->email->subject('::: Buyer Awarded Job :::');
					}
					unset($content);
					$this->email->message($mail_html);
					
					if(SITE_FOR_LIVE)///For live site
					{				
						$i_nwid = $this->email->send();	
																
					}
					else{
						$i_nwid = TRUE;				
					}
					//echo $this->data['loggedin']['user_email'];
					//echo "<br>DESC".$description;	exit;	
					
					/// Mailing code...[end]	
					
				/* end job quote mail to the user */					
					}
                    unset($i_status,$i_job_id);
				}
			}
			unset($s_where,$info,$total_db_records);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	 	    
    }    

  
    /****
    * Display the static contents For this controller
    * 

    */

            

    public function __destruct()

    {}           

}
