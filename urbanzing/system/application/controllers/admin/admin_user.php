<?php
//for MLM
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class admin_user extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_user_model');
    }

    function index($order_name='name',$order_type='asc',$page=0)
    {
        $this->check_user_page_access('registered');
        $sessArrTmp = array();
        $this->menu_id  = 2;
        $this->data['title'] = 'Admin user Page';
        if($this->input->post('go'))
        {
            $sessArrTmp['src_admin_user_name']=$this->input->post('name');
            $sessArrTmp['src_admin_user_username']=$this->input->post('username');
            $sessArrTmp['src_admin_user_restricted']=$this->input->post('restricted');
        }
        else
        {
            $sessArrTmp['src_admin_user_name']=$this->get_session_data('src_admin_user_name');
            $sessArrTmp['src_admin_user_username']=$this->get_session_data('src_admin_user_username');
            $sessArrTmp['src_admin_user_restricted']=$this->get_session_data('src_admin_user_restricted');
        }
        $this->data['txtArray']   = array("name"=>"Name","username"=>"User ID");
        $this->data['txtValue']   = array($sessArrTmp['src_admin_user_name'], $sessArrTmp['src_admin_user_username']);
        $this->data['optArray']   = array("restricted"=>"Status");
        $this->data['optValue']   = array(makeOption(array("1"=>"Enable","0"=>"Disable"),$sessArrTmp['src_admin_user_restricted']));
        $arr    = array('name'=>$sessArrTmp['src_admin_user_name'], 'username'=>$sessArrTmp['src_admin_user_username'],'restricted'=>$sessArrTmp['src_admin_user_restricted']);
        $this->data['admin_user']=$this->admin_user_model->get_user_list($this->admin_page_limit,($page)?$page:0,$arr,$order_name,$order_type);
        $totRow = $this->admin_user_model->get_user_list_count($arr);
        if(!$this->data['admin_user'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/admin_user/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/admin_user/index/'.$order_name.'/'.$order_type,
                    'total_row'=>$totRow,
                    'per_page'=>$this->admin_page_limit,
                    'uri_segment'=>6,
                    'next_link'=>'Next&gt;',
                    'prev_link'=>'&lt;Prev'
                )
            );

        $this->data['order_name']=$order_name;
        $this->data['order_type']=$order_type;
        $this->data['page']=$page;
		
        $sessArrTmp['redirect_url']=base_url().'admin/admin_user/index/'.$order_name.'/'.$order_type.'/'.$page;
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','admin_user/admin_user_list'));
	$this->render();
    }

    function add_admin_user()
    {
        $this->check_user_page_access('registered');
        $this->menu_id  = 2;
        $this->data['title'] = 'Admin Add User Page';
        $this->data['table_title'] = 'Add Admin User';
        $this->add_js(array('ajax_helper','fromvalidation','common_js'));
        $this->set_include_files(array('common/admin_menu','admin_user/add_admin_user'));
	$this->render();
    }

    function add_new_user_check()
    {
        $dataArr    = array('username'=>$this->input->post('username'),'email'=>$this->input->post('email'));
        $id = $this->input->post('id');
        echo $this->admin_user_model->get_admin_duplicate($dataArr,($id)?$id:-1);
    }

    function insert_admin_user()
    {
        $this->check_user_page_access('registered');
        $arr= array("name"=>htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
                    "email"=>htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8'),
                    "username"=>htmlspecialchars($this->input->post('username'), ENT_QUOTES, 'utf-8'),
                    "password"=>get_salted_password($this->input->post('password')),
                    "restricted"=>1
        );
        if($this->admin_user_model->set_user_insert($arr,get_salt()))
            $this->session->set_userdata(array('message'=>'User add successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to add user..','message_type'=>'err'));
        header('location:'.base_url().'admin/admin_user');
        exit;
    }

    function ajax_change_status()
    {
        $restricted   = $this->input->post('restricted');
        $id   = $this->input->post('id');
        if($this->admin_user_model->change_user_status($id,$restricted))
        {
            $this->load->model('automail_model');
            $txt     = " Disable";
            $style='';
            $mailType	= 'block_user_admin';
            $restricted=1-$restricted;
            if($restricted==1)
            {
                $style  = "color:green;";
                $txt     = " Enable";
                $mailType	= 'unblock_user_admin';
            }
            $this->automail_model->send_block_unblock_admin_user_mail($id,$mailType);
            $jsnArr = json_encode(array('id'=>$id,'restricted'=>$restricted));
            echo "<a onclick='call_ajax_status_change(\"".base_url()."admin/admin_user/ajax_change_status\",".$jsnArr.",\"status".$id."\");' style='cursor:pointer; ".$style."'> ".$txt."</a>";
        }
    }

    function delete_user($id)
    {
        if($this->admin_user_model->delete_user($id))
            $this->session->set_userdata(array('message'=>'User deleted successfully..','message_type'=>'err'));
        else
            $this->session->set_userdata(array('message'=>'Unable to delete user..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }

    function edit_admin_user($id=-1)
    {
        $this->check_user_page_access('registered');
	if(!$id||!is_numeric($id)||$id==-1 || !$this->admin_user_model->is_valid_user($id))
        {
            $this->session->set_userdata(array('message'=>'Data not found for this user..','message_type'=>'err'));
            header("Location: ".$this->get_redirect_url());
            exit(0);
        }
        $this->data['admin_user']=$this->admin_user_model->get_user_list(1,0,array('id'=>$id));
        $this->menu_id  = 2;
        $this->data['title'] = 'Admin Edit User Page';
        $this->data['table_title'] = 'Edit Admin User';
        $this->data['admin_user_id']=$id;
        $this->data['redirect_url']=$this->get_redirect_url();

        $this->add_js(array('ajax_helper','fromvalidation','common_js'));
        $this->set_include_files(array('common/admin_menu','admin_user/edit_admin_user'));
        $this->render();
    }

    function update_admin_user()
    {
        $this->check_user_page_access('registered');
        $arr= array("name"=>htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
                    "email"=>htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8'),
                    "username"=>htmlspecialchars($this->input->post('username'), ENT_QUOTES, 'utf-8')
        );
        if($this->admin_user_model->set_user_update($arr,$this->input->post('id')))
            $this->session->set_userdata(array('message'=>'User update successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to update user..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }

    function change_password()
    {
    	$this->check_user_page_access('registered');
    	if($this->input->post('submit_button', true)!="")
    	{
            $isProper   = $this->admin_user_model->authenticate($this->session->userdata('admin_user_username'),get_salted_password($this->input->post('old_password', true)));
            if(isset($isProper) && is_array($isProper))
            {
                $arr= array("password"=>get_salted_password($this->input->post('password')));
                if($this->admin_user_model->set_user_password_update($arr,$this->session->userdata('admin_user_id')))
                    $this->session->set_userdata(array('message'=>'Password change successfully..','message_type'=>'succ'));
                else
                    $this->session->set_userdata(array('message'=>'Unable to change password..','message_type'=>'err'));
                header('location:'.base_url().'admin/admin_user');
                exit;
            }
            else
            {
                $this->message_type ='err';
                $this->message  ='Give proper old password..';
            }
    	}
        $this->menu_id  = 2;
        $this->data['title'] = 'Admin Change Password Page';
        $this->data['table_title'] = 'Change password';
        $this->add_js(array('fromvalidation'));
        $this->set_include_files(array('common/admin_menu','admin_user/change_password'));
        $this->render();
    }
}