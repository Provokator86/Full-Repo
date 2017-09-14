<?php
/*********
* Author: SWI
* Date  : 11 Sept 2017
* Modified By: 
* Modified Date: 
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class Home extends MY_Controller
{
    public $cls_msg, $tbl, $tbl_ref_cou, $tbl_ref_sta, $tbl_ref_zip; // All defined error messages. 
    public $pathtoclass;
    
    # constructor definition...
    public function __construct()
    {
        try
        {           
            parent::__construct(); 
            $this->data['title'] = "Project Name"; // Browser Title
            $this->data['ctrlr'] = "home";		
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
    
    # index function definition...
    public function index()
    {
        try
        {	
			$this->data['home_page'] = TRUE;  
			redirect(base_url('web_master'));    // for now
            # loading view part...                        
			$this->render();
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }	
	
	
    public function __destruct()
    {}          

}

/* End of file home.php */

