<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 29 May 2012
* Modified By: 
* Modified Date: 
* 
* Purpose: send alert for frozen jobs
* @includes My_Controller.php
* @implements InfControllerFe.php
*/
class Frozen_job_alert extends My_Controller
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  $this->load->model('job_model','mod_job');
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    }


    /***
    * index funxtion called default
    */

    public function index()
    {
        try
        {
			
			$s_where = " WHERE n.i_status=8 And n.i_is_deleted=0";				
			$s_where.=" AND NOW() > DATE_ADD(FROM_UNIXTIME(n.i_assigned_date, '%Y-%m-%d H:i:s'), INTERVAL 24 HOUR)";			
			
			$info = $this->mod_job->fetch_multi($s_where);
			//pr($info,1);			
			$total_db_records=count($info);
			if($total_db_records>0)
			{
				for($i=0;$i<$total_db_records;$i++)
				{	
				   $i_job_id = $info[$i]['id'];
				   $i_tradesman_id = $info[$i]['i_tradesman_id'];
					/* for job quote mail to the user */
				   $this->load->model('tradesman_model','mod_td');
				   $s_where = " WHERE n.i_tradesman_id={$i_tradesman_id} AND n.id={$i_job_id} ";
				   
				   $job_details = $this->mod_job->fetch_multi_completed($s_where);		   
			       //pr($job_details); exit;
				   //echo '==========='.$i_tradesman_id;exit;
				   $tradesman_details = $this->mod_td->fetch_tradesman_details($i_tradesman_id);
				   
				   $s_wh_quote = " WHERE n.i_tradesman_user_id={$i_tradesman_id} AND n.i_job_id={$i_job_id} ";
				   $quote_details = $this->mod_job->fetch_quote_multi($s_wh_quote);
				   //pr($quote_details);
				 
				   $this->load->model('auto_mail_model');
				   $content 	= $this->auto_mail_model->fetch_mail_content('buyer_awarded_job','tradesman',$tradesman_details['lang_prefix']);
				   $filename 	= $this->config->item('EMAILBODYHTML')."common.html";
				   $handle 		= @fopen($filename, "r");
				   $mail_html 	= @fread($handle, filesize($filename));
				   $s_subject 	= $content['s_subject'];				
					//print_r($content); exit;
					if(!empty($content))
					{	
						$description = $content["s_content"];
						$description = str_replace("[TRADESMAN_NAME]",$tradesman_details['s_username'],$description);
						$description = str_replace("[BUYER_NAME]",$job_details[0]['job_details']['s_buyer_name'],$description);
						$description = str_replace("[JOB_TITLE]",$job_details[0]['job_details']['s_title'],$description);	
						$description = str_replace("[QUOTE_AMOUNT]",$job_details[0]['s_quote'],$description);	
						$description = str_replace("[LOGIN_URL]",base_url().'user/login/TVNOaFkzVT0',$description);	
					}
					unset($content);
					
					$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					
					//echo "<br>DESC".$description.'<br/>';	exit;
					
					/// Mailing code...[start]
					$site_admin_email = $this->s_admin_email;	
					$this->load->helper('mail');										
					$i_newid = sendMail($tradesman_details['s_email'],$s_subject,$mail_html);	
                    /// Mailing code...[end]				
					
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
