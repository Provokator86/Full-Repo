<?php
//for MLM
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class site_settings extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->check_user_page_access('registered');
       // $this->load->model('language_model');
        $this->menu_id  = 2;
        $this->data['title'] = 'Site Settings Page';
        $this->data['table_title'] = 'Site Settings';
        $this->data['site_settings']=$this->site_settings_model->get_site_settings_all();
        $this->data['default_currency_option']	= makeOption($this->site_settings_model->default_currency_array,$this->data['site_settings'][0]['default_currency']);
        $this->data['paypal_currency']	= makeOption($this->site_settings_model->paypal_cuency,$this->data['site_settings'][0]['paypal_currency']);
        $this->data['mail_protocol_option']= makeOption(array('mail'=>'Mail','sendmail'=>'Sendmail','smtp'=>'SMTP'),$this->data['site_settings'][0]['mail_protocol']);
        //$this->data['default_language_option']=$this->language_model->get_language_list_option('',$this->data['site_settings'][0]['default_language'],1);
        $this->add_js(array('fromvalidation'));
        $this->set_include_files(array('common/admin_menu','site_settings/site_settings'));
        $this->render();
    }

    function update_site_settings()
    {
        $this->check_user_page_access('registered');
        $arr= array("max_image_file_size"=>htmlspecialchars($this->input->post('max_image_file_size'), ENT_QUOTES, 'utf-8'),
					"google_api_key"=>htmlspecialchars($this->input->post('google_api_key'), ENT_QUOTES, 'utf-8'),
                    "site_name"=>htmlspecialchars($this->input->post('site_name'), ENT_QUOTES, 'utf-8'),
                    "site_moto"=>htmlspecialchars($this->input->post('site_moto'), ENT_QUOTES, 'utf-8'),
                    "admin_email"=>htmlspecialchars($this->input->post('admin_email'), ENT_QUOTES, 'utf-8'),
                    "paypal_email"=>htmlspecialchars($this->input->post('paypal_email'), ENT_QUOTES, 'utf-8'),
                    "default_language"=>htmlspecialchars($this->input->post('default_language'), ENT_QUOTES, 'utf-8'),
                    "admin_page_limit"=>htmlspecialchars($this->input->post('admin_page_limit'), ENT_QUOTES, 'utf-8'),
                    "default_currency"=>htmlspecialchars($this->input->post('default_currency'), ENT_QUOTES, 'utf-8'),
                    "mail_from_name"=>htmlspecialchars($this->input->post('mail_from_name'), ENT_QUOTES, 'utf-8'),
                    "mail_from_email"=>htmlspecialchars($this->input->post('mail_from_email'), ENT_QUOTES, 'utf-8'),
                    "mail_replay_name"=>htmlspecialchars($this->input->post('mail_replay_name'), ENT_QUOTES, 'utf-8'),
                    "mail_replay_email"=>htmlspecialchars($this->input->post('mail_replay_email'), ENT_QUOTES, 'utf-8'),
                    "mail_protocol"=>htmlspecialchars($this->input->post('mail_protocol'), ENT_QUOTES, 'utf-8'),
                    "registration_charge"=>htmlspecialchars($this->input->post('registration_charge'), ENT_QUOTES, 'utf-8'),
                    "conversion_rate"=>htmlspecialchars($this->input->post('conversion_rate'), ENT_QUOTES, 'utf-8'),
                    "paypal_charge"=>htmlspecialchars($this->input->post('paypal_charge'), ENT_QUOTES, 'utf-8'),
                    "smtp_host"=>htmlspecialchars($this->input->post('smtp_host'), ENT_QUOTES, 'utf-8'),
                    "smtp_user"=>htmlspecialchars($this->input->post('smtp_user'), ENT_QUOTES, 'utf-8'),
                    "smtp_pass"=>htmlspecialchars($this->input->post('smtp_pass'), ENT_QUOTES, 'utf-8'),
                    "sms_gateway_username"=>htmlspecialchars($this->input->post('sms_gateway_username'), ENT_QUOTES, 'utf-8'),
                    "sms_gateway_password"=>htmlspecialchars($this->input->post('sms_gateway_password'), ENT_QUOTES, 'utf-8'),
                    "sms_gateway_senderid"=>htmlspecialchars($this->input->post('sms_gateway_senderid'), ENT_QUOTES, 'utf-8'),
                    "paypal_currency"=>htmlspecialchars($this->input->post('paypal_currency'), ENT_QUOTES, 'utf-8')
        );
        if($this->site_settings_model->set_site_settings_update($arr))
            $this->session->set_userdata(array('message'=>'Site settings updated successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to update site settings..','message_type'=>'err'));
        header('location:'.base_url().'admin/site_settings');
        exit;
    }
	
	function truncate_all()
	{
		$this->site_settings_model->truncate_table();
        $this->session->set_userdata(array('message'=>'tables truncated successfully..','message_type'=>'err'));
        header('location:'.base_url().'admin/site_settings');
        exit;
		
	
	}
	
	
	
}
?>