<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 29 May 2012
* Modified By: 
* Modified Date: 
* 
* Purpose: send alert for jobs expire
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
			$cur_date = time();
			
			$s_where = " WHERE {$cur_date} >  n.i_expire_date AND n.i_status=1";			
			$info = $this->mod_job->fetch_multi($s_where);
			$total_db_records=$this->mod_job->gettotal_info($s_where);
			
			if($total_db_records>0)
			{
				for($i=0;$i<$total_db_records;$i++)
				{
					
					$i_status = 7;  // Expired
					$i_job_id = $info[$i]['id'];
					$s_table = $this->db->JOBS;
					$arr1 = array();
					$arr1['i_status'] = $i_status;
					$this->mod_job->set_data_update($s_table,$arr1,$i_job_id);
					
                    unset($i_status,$i_job_id,$s_table,$arr1);
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
