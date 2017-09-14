<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author Kallol
 */
class Home extends MY_Controller   {
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('location_model');
        $this->load->model('category_model');
        $this->load->model('store_model');
        $this->load->model('ad_model');
        $this->load->model('site_settings_model');
        $this->load->model('cms_model');
    }
    public function index() {
        $data = array('title'=>'Title');
        $data['deal_location'] = $this->location_model->get_list();
        $data['categoryData'] = $this->category_model->get_list(array('e_show_in_frontend'=>'1'));
        foreach ($data['categoryData'] as $key => $catValue) {
            $data['categoryData'][$key]['store'] = $this->store_model->get_list(array('i_is_active'=>'1','i_cat_id'=>$catValue['i_id']),'i_id,s_store_title,s_url');
        }
//        /pr($data['categoryData']);
   
        $data['popular_store'] = $this->store_model->get_list(array('i_is_active'=>'1','i_is_hot'=>1),'i_id,s_store_title,s_url,s_store_logo',16);
        
        $data['ads'] = $this->ad_model->get_list(array('i_is_active'=>'1','i_page_id'=>8),'s_description');
        $cms = $this->cms_model->get_list(array('i_id'=>7),'en_s_description as s_description,en_s_title as s_title',1);
        $site_settings = $this->site_settings_model->get_list(array('i_id'=>1),'s_google_analitics_deal,s_pinterest_url,s_google_plus_url,s_facebook_url,s_twitter_url,s_copyrite as s_copyright',1);
        
        $data['cms_social'] = $cms[0];
        $data['site_settings'] = $site_settings[0];
        $this->render($data);
    }
}

?>
