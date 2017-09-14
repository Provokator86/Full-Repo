<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author Kallol
 */
class Cashback extends MY_Controller   {
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('user_deals_model');
    }
    
   public function index($id = 0) {
        $data = array('title'=>'Title');
        $current_user_session = $this->session->userdata('current_user_session');
        $deal_meta = $this->deal_model->get_joined_list(array('cd_coupon.i_id'=>$id),'cd_coupon.i_id,cd_coupon.s_url,s_store_url,');
        $UID = isset($current_user_session[0]['s_uid'])?$current_user_session[0]['s_uid']:'GUEST';
        $URL = $deal_meta[0]['s_store_url'].'&UID='.$current_user_session[0]['s_uid'].'&redirect='.urlencode($deal_meta[0]['s_url']);
        $dataToSave = array(
                    'i_user_id'=>$current_user_session[0]['i_id'],
                    'i_deal_id'=>$deal_meta[0]['i_id'],
                    'txt_extra'=>  json_encode(array('SERVER'=>$_SERVER,'URL'=>$URL))
                    );
        $this->user_deals_model->insert_data($dataToSave);
        redirect($URL);
    }
   
  
   
}

?>
