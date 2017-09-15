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
		  $this->load->model('manage_jobs_model');
		  $this->load->model('job_model');
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
			$s_where = " WHERE n.i_status=8 And n.i_is_deleted=0 ";
			//$s_where .= " And FROM_UNIXTIME( n.i_expire_date , '%Y-%m-%d' )<=date_format(curdate(), '%Y-%m-%d')";
			$s_where .= " AND NOW() >= DATE_ADD(FROM_UNIXTIME(n.i_assigned_date, '%Y-%m-%d H:i:s'), INTERVAL 48 HOUR)";
			
			$info = $this->manage_jobs_model->fetch_multi($s_where);
			$total_db_records=$this->manage_jobs_model->gettotal_info($s_where);
			//pr($info,1);
			if($total_db_records>0)
			{
				for($i=0;$i<$total_db_records;$i++)
				{
					/* change job status to active */
					$i_status = 1;  // Active
					$i_job_id = $info[$i]['id'];	
					//$i_tradesman_id = $info[$i]['i_tradesman_id'];	
					$job_stat['i_status'] = $i_status;
					$job_stat['i_assigned_date'] = '';
					$job_stat['i_tradesman_id'] = '';
					$table = $this->db->JOBS;
					$cond = array('id '=>$i_job_id);
					$i_aff = $this->job_model->set_data_update($table,$job_stat,$cond);				
					
					if($i_aff)
					{
						$detail = array();
						$detail['i_status'] = 3;
						$cond = array('i_tradesman_user_id '=>$i_tradesman_id ,'i_job_id'=>$i_job_id);
						//pr($cond);
						$table = $this->db->JOBQUOTES;
						
						$i_newid = $this->job_model->set_data_update($table,$detail,$cond);
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

    public function test_cron()
	{
        try
        {
			
			/// Mailing code...[start]
			$attachment_pdf  = $this->config->item('ATTACHMENT_PDF_PATH').'invoice_1324986406.pdf';
			//echo $site_admin_email; exit;
			$this->load->library('email');
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
								
			$this->email->initialize($config);					
			$this->email->clear();                    
			
			$this->email->from('aa@aa.com');	
							
			$this->email->to('linktoiman@gmail.com');

			$this->email->subject('::: Sucessful Payment :::');
			unset($content);
			$this->email->message('test msg');
			
			$this->email->attach($attachment_pdf);
						
			$i_nwid = $this->email->send();	
			echo '======'.$i_nwid;
														
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	
	}        

    public function __destruct()

    {}           

}
