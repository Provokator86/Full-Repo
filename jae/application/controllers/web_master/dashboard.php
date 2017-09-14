<?php
/*********
* Author: SWI
* Date  : 11 Sept 2017
* Modified By: SWI
* Modified Date: 11 Sept 2017
* 
* Purpose:
*  Controller For Admin Dashboard. "i_user_type_id"=0 is for super admin
* 
* @package Admin
* @subpackage 
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/dashboard_model.php
* @link views/admin/dashboard/
*/
//error_reporting(E_ALL);
class Dashboard extends MY_Controller 
{
    public $cls_msg;//All defined error messages. 
    public $indian_symbol, $user_type, $user_id, $user_name, $tbl_user, $logged_in, $tbl_exam, $tbl_eqa;
     
    public function __construct()
    {            
        try
        {
            parent::__construct();
            //Define Errors Here//
            $this->cls_msg=array();

            //end Define Errors Here//
            $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
            $this->load->model("dashboard_model","mod_rect");
            
            $this->tbl_user = $this->db->USER;
            $this->tbl_exam = $this->db->EXAM;
            $this->tbl_eqa = $this->db->EXAM_QUESTION_ANSWER;
            

            $this->logged_in 	= $logged_in = $this->session->userdata("admin_loggedin");
            $this->user_type    = decrypt($logged_in["user_type_id"]);
            $this->user_id      = decrypt($logged_in["user_id"]);		  
            $this->user_name    = $logged_in['user_name'];		  
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
			//echo 'User Type==> '.$this->user_type.' ============== User ID==>'.$this->user_id.' ===== Username==> '.$this->user_name;
			//pr($this->logged_in);
			$this->data['pathtoclass']	=	$this->pathtoclass;			
			$this->data['BREADCRUMB']	=	array('Dashboard');			
            $this->data['title']        =   "Dashboard";////Browser Title
            $this->data['heading']      =   "Dashboard of Admin Panel";
            $this->data['user_type']    =   $this->user_type;
            $admin_loggedin             =   $this->session->userdata('admin_loggedin'); 
               
			// examinations
			$s_where = " i_is_deleted='0' AND i_status = 1 ORDER BY s_name ASC ";
			$info = $this->acs_model->fetch_data($this->tbl_exam, $s_where, '', intval($start), $limit);
			$this->data['exam'] = $info;
			unset($s_where, $info);
			
			// total questions
			$cond = array('i_is_deleted'=>0, 'i_status'=>1);
			$info = $this->acs_model->count_info($this->tbl_eqa, $cond);
			$this->data['total_questions'] = $info;
			unset($cond, $info);
			
			
			$this->render('dashboard/dashboard');  
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
    
    
    // ajax set no of questions answer
    public function ajax_set_number_of_qa()
    {
        $response = array('red_link' =>'', 'status' =>'error');
        $exam_id = $this->input->post('exam_id', true); 
        $i_number = $this->input->post('i_number', true); 
        if( intval($i_number))
        {
			$this->session->unset_userdata('sess_exam_id');
			$this->session->unset_userdata('sess_no_qa');
			
			//$this->session->set_userdata('sess_exam_id', $exam_id);
			//$this->session->set_userdata('sess_no_qa', $i_number);
			
            $red_link = base_url('web_master/manage_questions/add_information').'/'.encrypt($i_number).'/'.encrypt($exam_id);
			$response['red_link']	= $red_link;
			$response['status']		= 'success';
        }
        echo json_encode($response);
    }
	
	
	
	
	public function __destruct()
    {}
}
