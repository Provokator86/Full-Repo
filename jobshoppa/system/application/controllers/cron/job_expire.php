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
class Job_expire extends My_Controller
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
			$cur_date = time();
			//$s_where = " WHERE FROM_UNIXTIME( n.i_expire_date , '%Y-%m-%d' )=date_format(curdate(), '%Y-%m-%d') AND n.i_status=1";
			$s_where = " WHERE {$cur_date} >  n.i_expire_date AND n.i_status=1";
			
			$info = $this->manage_jobs_model->fetch_multi($s_where);
			$total_db_records=$this->manage_jobs_model->gettotal_info($s_where);
			
			if($total_db_records>0)
			{
				for($i=0;$i<$total_db_records;$i++)
				{
					
					$i_status = 7;  // Expired
					$i_job_id = $info[$i]['id'];
					if($this->manage_jobs_model->update_status($i_job_id,$i_status))
					{
						$this->manage_jobs_model->job_accept_reject($i_job_id,$i_status);
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
