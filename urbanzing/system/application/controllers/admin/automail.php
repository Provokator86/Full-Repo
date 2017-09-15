<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class automail extends MY_Controller
{
	function __construct()
    {
		parent::__construct();
        $this->load->model('automail_model');
	}

	function index($item_type='')
    {
        $this->check_user_page_access('registered');

        $this->menu_id  = 4;
        $this->data['title'] = 'Automail Page';
        $this->data['table_title'] = 'Automail';

        $this->data['automail']=$this->automail_model->get_automail_all($item_type);

        $this->data['automail_type_option'] = makeOption($this->automail_model->automail_type,$item_type);
        $this->data['automail_field_option'] = $this->automail_model->get_dynamic_options_html_for_cms();

        $this->add_js(array('fromvalidation','tinymce/jscripts/tiny_mce/tiny_mce','tinymce_load'));
        $this->set_include_files(array('common/admin_menu','automail/automail'));
		$this->render();
	}

    function update_automail()
    {
        $this->check_user_page_access('registered');
        $arr= array("item_type"=>$this->db->escape_str($this->input->post('item_type')),
                            "subject"=>$this->db->escape_str($this->input->post('subject')),
                            "description"=>base64_encode(htmlspecialchars($this->input->post('description'), ENT_QUOTES, 'utf-8'))
        );
        if($this->automail_model->set_automail_update($arr,$this->input->post('id')))
            $this->session->set_userdata(array('message'=>$this->automail_model->automail_type[$this->input->post('item_type')].' updated successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to update '.$this->automail_model->automail_type[$this->input->post('item_type')],'message_type'=>'err'));
        header('location:'.base_url().'admin/automail/index/'.$this->input->post('item_type'));
        exit;
    }
}
?>