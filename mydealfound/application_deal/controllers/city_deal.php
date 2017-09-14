<?php
if (!defined('BASEPATH'))

    exit('No direct script access allowed');
/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */
/**

 * Description of home

 *

 * @author Kallol

 */

class City_deal extends MY_Controller {

    //put your code here

    public function __construct() {

        parent::__construct();
    }   

    public function city_deals($city_url, $paging = 0) 
	{	
	   $city_url			= explode('-',$city_url);
	   $city				= $city_url[0];
	   $location_details	= $this->location_model->get_list(array('s_name' => $city));
	   	   
	   $where	= " cd_coupon.i_location_id='".$location_details[0]['i_id']."' AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ";	   
	   $data['dealList'] = $this->process_deal_list($where, $location_details[0]['s_name'].' Deals', $paging, 8, base_url() . 'top-deals/', 2);	   

        $this->render($data, 'home/listing.tpl.php');
    }
}