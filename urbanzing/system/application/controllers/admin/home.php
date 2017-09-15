<?php
//for MLM
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;

class home extends MY_Controller
{
    function __construct()
    {
	parent::__construct();
        $this->load->model('admin_user_model');
    }

    function index()
    {
        $this->check_user_page_access('non_registered');
        $this->data['title'] = 'Admin user';
        if($this->input->post('submit_button', true)!="") 
        {
            $data_arr   = $this->admin_user_model->authenticate($this->input->post('uid', true),get_salted_password($this->input->post('pwd', true)));
            if(isset($data_arr) && is_array($data_arr))
            {
                if( $data_arr['status']=='0')
                {
                    $this->message_type ='err';
                    $this->message  ='Your account hasbeen blocked..';
                }
                else
                {
                    $this->admin_user_model->log_this_login($data_arr);
                    header('location:'.base_url().'admin/home/display');
                    exit;
                }
            }
            else
            {
                $this->message_type ='err';
                $this->message  ='Give proper login detail..';
            }
        }

		header("location:".base_url().'home/login');

        $this->set_include_files(array('admin_login'));
        $this->render();
    }
	
    function forget_password()
    {
        $this->check_user_page_access('non_registered');
        $this->data['title'] = 'Admin user';
        if($this->input->post('submit_button', true)!="") 
        {
            $this->load->model('automail_model');
            if($this->automail_model->send_forget_password_mail_admin($this->input->post('email')))
            {
                $this->message_type ='succ';
                $this->message  ='New password has been send successfully..';
            }
            else
            {
                $this->message_type ='err';
                $this->message  ='Unable to send email..';
            }
        }
        $this->set_include_files(array('admin_forget_password'));
	$this->render();
    }

    function display()
    {
        $this->data['title'] = 'Home Page';
        $this->menu_id  = 1;
        $this->check_user_page_access('registered');
        $this->set_include_files(array('common/admin_menu','home_body'));
        $this->render();
    }

    function general()
    {
        $this->data['title'] = 'General Page';
        $this->menu_id  = 2;
        $this->check_user_page_access('registered');
        $this->set_include_files(array('common/admin_menu','general_body'));
        $this->render();
    }

    function master()
    {
        $this->data['title'] = 'Master Page';
        $this->menu_id  = 3;
        $this->check_user_page_access('registered');
        $this->set_include_files(array('common/admin_menu','master_body'));
        $this->render();
    }

    function cms()
    {
        $this->data['title'] = 'CMS Page';
        $this->menu_id  = 4;
        $this->check_user_page_access('registered');
        $this->set_include_files(array('common/admin_menu','cms_body'));
        $this->render();
    }
    
    function deals()
    {
        $this->data['title'] = 'Manage Deals';
        $this->menu_id  = 5;
        $this->check_user_page_access('registered');
        $this->set_include_files(array('common/admin_menu','deals_body'));
        $this->render();
    }
    
    function report()
    {
        $this->data['title'] = 'Report Page';
        $this->menu_id  = 5;
        $this->check_user_page_access('registered');
        $this->set_include_files(array('common/admin_menu','report_body'));
        $this->render();
    }
    
    function logout()
    {
        $this->data['title'] = 'Home Page';
        $this->check_user_page_access('registered');
        $this->admin_user_model->logout_this_login();
        header('location:'.base_url().'admin');
        exit;
    }
}
