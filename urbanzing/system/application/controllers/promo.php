<?php
include BASEPATH.'application/controllers/MY_Controller'.EXT;
class promo extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        
    }

    function page($url)
    {   
		
		$this->load->model('static_page_model');
		$result = $this->static_page_model->get_static_page_details(0,-1,$url);
		
		$this->data['meta_desc']  = $result[0]['meta_description'];
		$this->data['meta_keywords']  = $result[0]['meta_keywords'];  	
		$this->data['title_content']  = $result[0]['title'];
		$this->add_css('tinymce');
		$this->data['title']  = $result[0]['page_title']; // page title, ie. browsers title
		$this->data['page_content']  =  html_entity_decode($result[0]['page_content']);
		$this->set_include_files(array('static_page_show/show_static_page'));
        $this->render();

	}	
	

}
/*This controller is for showing static pages, which are made by admin.....*/
/* controllers/promo.php*/