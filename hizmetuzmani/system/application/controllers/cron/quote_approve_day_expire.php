<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 29 May 2012
* Modified By: 
* Modified Date: 
* 
* Purpose: alert for quote approve day
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
		 
		  $this->load->model('manage_buyers_model','mod_buyer');
		  $this->load->model('job_model','mod_job');
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    }



    /***
    * index function called by default
    * 
    */

    public function index()
    {
        try
        {
			$before_days = 3;
			$s_where = " WHERE n.i_status=8";			
			$s_where .= " AND FROM_UNIXTIME( n.i_expire_date , '%Y-%m-%d' )=DATE_ADD(curdate(), INTERVAL {$before_days} DAY)";
			
			$info 				= $this->mod_job->fetch_multi($s_where);
			$total_db_records 	= $this->mod_job->gettotal_info($s_where);
			
			if($total_db_records>0)
			{
				for($i=0;$i<$total_db_records;$i++)
				{
					
					
				   $i_job_id = $info[$i]['id'];
				   $i_tradesman_id = $info[$i]['i_tradesman_id'];
					/* for job quote mail to the user */
				   $this->load->model('tradesman_model','mod_td');
				   $s_where = " WHERE n.i_tradesman_user_id={$i_tradesman_id} AND n.i_job_id={$i_job_id} AND n.i_status=1";
				   $job_details = $this->mod_job->fetch_quote_multi($s_where,0,1);
				   //echo '==========='.$i_tradesman_id;exit;
				   $tradesman_details = $this->mod_td->fetch_tradesman_details($i_tradesman_id);
				   
				   $s_wh_id = " WHERE n.i_user_id=".$i_tradesman_id." ";
				   $buyer_email_key = $this->mod_buyer->fetch_email_keys($s_wh_id);
				   $is_mail_need = in_array('buyer_awarded_job',$buyer_email_key);
				   
				   if($is_mail_need)
				  {
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
					//echo "<br>DESC".$description;	exit;
					
					/// Mailing code...[start]
					$site_admin_email = $this->s_admin_email;	
					$this->load->helper('mail');										
					$i_newid = sendMail($tradesman_details['s_email'],$s_subject,$mail_html);	
                    /// Mailing code...[end]
					
								
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

              

    public function __destruct()

    {}           

}
