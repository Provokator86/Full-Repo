<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class Invited_users extends MY_Controller
{
	public $upload_path = '';
    function __construct()
    {
		parent::__construct();
		$this->upload_path = BASEPATH.'../images/uploaded/temp/';
		$this->check_user_page_access('registered');
        $this->load->model('users_model');
		$this->menu_id  = 3;
	}

	function index($order_name='cuisine',$order_type='asc',$page=0)
    {
       
	   /* $sessArrTmp = array();
        $this->data['title'] = 'Cuisine Page';
        if($this->input->post('go'))
        {
            $sessArrTmp['src_cuisine_title']=$this->input->post('title');
            $sessArrTmp['src_cuisine_status']=$this->input->post('status');
        }
        else
        {
            $sessArrTmp['src_cuisine_title']=$this->get_session_data('src_cuisine_title');
            $sessArrTmp['src_cuisine_status']=$this->get_session_data('src_cuisine_status');
        }

        $this->data['txtArray']   = array("title"=>"Title");
        $this->data['txtValue']   = array($sessArrTmp['src_cuisine_title']);
        $this->data['optArray']   = array("status"=>"Status");
        $this->data['optValue']   = array(
            makeOption(array("1"=>"Enable","0"=>"Disable"),$sessArrTmp['src_cuisine_status']),
            makeOption($this->cuisine_model->cuisine_category,$sessArrTmp['src_cuisine_category'])
        );
		$arr = array('cuisine'=>$sessArrTmp['src_cuisine_title'],'status'=>$sessArrTmp['src_cuisine_status']);
        $this->data['cuisine']=$this->cuisine_model->get_cuisine_list($arr,$this->admin_page_limit,($page)?$page:0,$order_name,$order_type);
        $totRow = $this->cuisine_model->get_cuisine_list_count($arr);
        if(!$this->data['cuisine'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/cuisine/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/cuisine/index/'.$order_name.'/'.$order_type,
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
        $sessArrTmp['redirect_url']=base_url().'admin/cuisine/index/'.$order_name.'/'.$order_type.'/'.$page;
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','cuisine/cuisine_list'));
		$this->render();*/
		
	}

    function add_invited_users()
    {
        $this->data['title'] = 'Add Invited Users Page';
        $this->data['table_title'] = 'Add Invited Users';

        $this->add_js(array('tinymce/jscripts/tiny_mce/tiny_mce','tinymce_load','fromvalidation'));
        $this->set_include_files(array('common/admin_menu','invited_users/add_invited_users'));
		$this->render();
    }

    function insert_invited_users()
    {
		if( isset($_FILES['csv_file']['name']) && $_FILES['csv_file']['name']!='' )
        {
			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], $this->upload_path.$file_name);
			
			$arr = array("email_provided_by"=>'Self',
						 "source_name"=>htmlspecialchars($this->input->post('source_name'), ENT_QUOTES, 'utf-8'),
						 "email_opt_in"=> 'Y',
						 "invite_accepted"=>'Y',				
						 "invited_date"=>time(),
						 "user_id"=>0,
						 "user_type_id"=>0
			            );
			$row = 1;
			if (($handle = fopen($this->upload_path.$file_name, "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					$num = count($data);
					//echo "<p> $num fields in line $row: <br /></p>\n";
					$row++;
					for ($c=0; $c < $num; $c++) {
						$chk = $this->users_model->get_invite_user_list(-1,0,array('invited_email'=>$data[$c]));
						$arr['invited_email'] = $data[$c];
						//echo $data[$c] . "<br />\n";
					}
					if(count($chk) == 0)
					  $this->users_model->set_data_insert('mailing_list',$arr);	
					
				}
				fclose($handle);
			}
					
			@unlink($this->upload_path.$file_name);
			$this->session->set_userdata(array('message'=>'Invited Users added successfully..','message_type'=>'succ'));
			header('location:'.base_url().'admin/invited_users/add_invited_users');
			exit();
		}
		$this->session->set_userdata(array('message'=>'Unable to add invited users..','message_type'=>'err'));
		header('location:'.base_url().'admin/invited_users');
		
	
/*        $arr= array("cuisine"=>htmlspecialchars($this->input->post('cuisine'), ENT_QUOTES, 'utf-8'),
					"status"=>$this->input->post('status'),
                    "cr_date"=>time(),
					"cr_by"=>$this->session->userdata('user_id')
        );
        if($this->cuisine_model->set_data_insert('cuisine',$arr))
            $this->session->set_userdata(array('message'=>'Invited Users add successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to add invited users..','message_type'=>'err'));
        header('location:'.base_url().'admin/invited_users');
        exit;*/
    }
    
	
}
