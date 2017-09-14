<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 29 May 2012
* Modified By: 
* Modified Date: 
* 
* Purpose: frozen jobs to active
* @includes My_Controller.php
* @implements InfControllerFe.php
*/
class Frozen_job_to_active extends My_Controller
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  $this->load->model('tradesman_model','mod_td');
		  $this->load->model('manage_buyers_model','mod_buyer');
		  $this->load->model('job_model','mod_job');
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    }


    /***
    * status change for frozen jobs which are not accept by tradesman within the remailning days 
    * 
    */

    public function index()
    {
        try
        {
			$s_where 	= " WHERE n.i_status=8 And n.i_is_deleted=0 ";			
			$s_where 	.= " AND NOW() >= DATE_ADD(FROM_UNIXTIME(n.i_assigned_date, '%Y-%m-%d H:i:s'), INTERVAL 72 HOUR)";
			//$s_where 	= " WHERE 1";
			$info = $this->mod_job->fetch_multi($s_where);
			$total_db_records=$this->mod_job->gettotal_info($s_where);
			//pr($info,1);
			if($total_db_records>0)
			{
				for($i=0;$i<$total_db_records;$i++)
				{
					/* change job status to active */
					$i_status = 1;  // Active
					$i_job_id = $info[$i]['id'];	
					$i_tradesman_id = $info[$i]['i_tradesman_id'];	
					$job_stat['i_status'] = $i_status;
					$job_stat['i_assigned_date'] = '';
					$job_stat['i_tradesman_id'] = '';
					$table = $this->db->JOBS;
					$cond = array('id'=>$i_job_id);
					$i_aff = $this->mod_job->set_data_update($table,$job_stat,$cond);				
					
					if($i_aff)
					{
						$detail = array();
						$detail['i_status'] = 3;
						$cond = array('i_tradesman_user_id '=>$i_tradesman_id ,'i_job_id'=>$i_job_id);
						$table = $this->db->JOBQUOTES;						
						$i_newid = $this->mod_job->set_data_update($table,$detail,$cond);
						
						$this->load->model('auto_mail_model');
						$trade_detail = $this->mod_td->fetch_tradesman_details($i_tradesman_id);
						$buyer_detail = $this->mod_buyer->fetch_this($info[$i]['i_buyer_user_id']);
						//pr($buyer_detail);
						$content 	= $this->auto_mail_model->fetch_mail_content('tradesman_deny_job_offer','buyer',$buyer_detail['s_lang_prefix']);	
						$s_subject 	= $content['s_subject'];						
						$filename 	= $this->config->item('EMAILBODYHTML')."common.html";
						$handle 	= @fopen($filename, "r");
						$mail_html 	= @fread($handle, filesize($filename));					
						//print_r($content); exit;
						if(!empty($content))
							{							
								$description = $content["s_content"];
								$description = str_replace("[BUYER_NAME]",$info[$i]['s_buyer_name'],$description);	
								$description = str_replace("[TRADESMAN_NAME]",$trade_detail['s_username'],$description);	
								$description = str_replace("[JOB_TITLE]",$info[$i]['s_title'],$description);
								$description = str_replace("[BUDGET]",$info[$i]['s_budget_price'],$description);
								$description = str_replace("[SITE_URL]",base_url(),$description);						
							}
						unset($content);
					
						$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
						$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
					
						//echo "<br>DESC".$mail_html.'<br/>';	
						
						/// Mailing code...[start]
						$site_admin_email = $this->s_admin_email;	
						$this->load->helper('mail');										
						$i_newid = sendMail($buyer_detail['s_email'],$s_subject,$mail_html);	
						/// Mailing code...[end]	
						
						
						
					}				
					
                    unset($i_job_id);
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
