<?php



/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */



/**

 * Description of My_Controler

 *

 * @author Kallol

 */

class MY_Controller  extends CI_Controller {

    

    protected $data = array();

    protected $s_controller_name;

    protected $s_action_name;

    protected $ses_user = array('loggedin'=>'', 'user_id'=>'', 'user_role'=>'', 'email'=>'', 'user_name'=>'');

    public $include_files=array();

    public $s_message_type;

    public $s_message;

    public $i_admin_page_limit=20;

    public $i_fe_page_limit=10;

    public $i_fe_uri_segment=3;

    public $i_default_language;

    public $i_admin_language;

    public $s_admin_email;

    public $s_meta_type = 'default';

    protected $js_files    = array();

    public $dt_india_time  = '';    

    public $i_uri_seg;

    protected $filter_access;

    protected $allow_access  = true;





    private $controller_admin=array();

	

    public function __construct() {

        parent::__construct();

        global $CI;
		
	if( empty( $CI) )
	{
		$CI	=   get_instance();
		$this->allow_access = $this->is_authorised($this->filter_access);
	}
	else
	{
		echo 'Some error occurred';
	}

             //$this->output->cache(1);

        //custome loading files
		
		$this->load->library('Form_validation');
		
		if($this->session->userdata('message'))
		{
			$this->message = $this->session->userdata('message');
			$this->session->unset_userdata(array('message' => ''));
		}

		if($this->session->userdata('message_type'))
		{
			$this->message_type = $this->session->userdata('message_type');
			$this->session->unset_userdata(array('message_type' => ''));
		}
   }

    /***

    * Rendering default template and others.

    * Default : application/views/admin/controller_name/method_name.tpl.php

    * For Popup window needs to include the main css and jquery exclusively.

    * 

    * @param string $view_file, ex- dashboard/report then looks like application/views/admin/.$view_file.tpl.php

    * @param array $passedData, pass the data to view

    * @param boolean $returnData, ex- true if return the data as variable string , false to render general

    * @param string header view name  $header_tpl, ex- default is 'header.tpl'

    * @param string footer view name  $footer_tpl, ex- default is 'footer.tpl'

    */

    protected function render($passedData =array(),$view_file= '',$returnData=FALSE,$header_tpl='common/header.tpl.php',$footer_tpl='common/footer.tpl.php')
    {
        try
        {
            $returnViewData = '';

            if($view_file==''){

                $view_file .= $this->router->class;

                $view_file .='/'.$this->router->method.'.tpl.php'; 
            }

            $site_settings = $this->site_settings_model->get_list(array('i_id'=>1),'s_google_analitics_deal,s_pinterest_url,s_google_plus_url,s_facebook_url,s_twitter_url,s_copyrite as s_copyright',1);

            $cms = $this->cms_model->get_list(array('i_id'=>7),'en_s_description as s_description,en_s_title as s_title',1);  
			
			
			// fetch category with parent category
			$s_where = " WHERE n.e_show_in_frontend = '1' ";  
			$categorys =  $this->category_model->fetch_category_chain($s_where);
			$category_parent_arr	=	array();
			if(!empty($categorys))
			{
				$parent_id = $categorys[0]["i_parent_id"];
				$i = 0;
				foreach($categorys as $key=>$val)
				{				
					if($parent_id == $val["i_parent_id"])	
					{
						$category_parent_arr[$val["parent_category"]][$i++] = array('i_id'=>$val["i_id"],'sub_category'=>$val["s_category"]);		
					}
					else
					{
						$i = 0;
						$parent_id = $val["i_parent_id"];
						$category_parent_arr[$val["parent_category"]][$i++] = array('i_id'=>$val["i_id"],'sub_category'=>$val["s_category"]);
					}		
				}
			}
			
			$data["category_parent_arr"]	= $category_parent_arr;
			/*echo '<pre>';
			print_r($category_parent_arr);
			echo '<pre>';*/
			     

            $passedData['categoryData'] = $this->category_model->get_list(array('e_show_in_frontend'=>'1'));
			
			foreach ($passedData['categoryData'] as $key => $catValue) {

                $passedData['categoryData'][$key]['store'] = $this->store_model->get_list(array('i_is_active'=>'1','i_cat_id'=>$catValue['i_id']),'i_id,s_store_title,s_url');

            }            

            $passedData['ads'] = $this->ad_model->get_list(array('i_is_active'=>'1','i_page_id'=>8),'s_description');            

           // $latest_deals = $this->deal_model->get_active_deal_list(array('i_is_hot'=>1,'dt_exp_date >='=>date('Y-m-d',time())),'i_id,s_title,s_url,s_image_url,s_meta_description,s_seo_url');            
		   
		   $latest_deals = $this->deal_model->get_active_deal_list(" i_is_hot=1 AND (CONCAT(DATE(dt_exp_date),' 23:59:59')>='".now()."' OR dt_exp_date = 0) ",'i_id,s_title,s_url,s_image_url,s_meta_description,s_seo_url,s_summary');

            $passedData['deal_location'] = $this->location_model->get_list();

            $passedData['site_title'] = 'MydealFound';

            $passedData['site_meta_keywords'] = '';

            $passedData['site_meta_description'] = '';

            $passedData['site_meta_tags'] = '';

            $passedData['site_settings'] = $site_settings[0];

            $passedData['cms_social'] = $cms[0];

            $passedData['latest_deals'] = $latest_deals;

            $passedData['site_copyright'] = '&copy; Deal Aggregator';

            $passedData['current_user_session'] = $this->session->userdata('current_user_session');            

            $passedData['captchaImage'] = $this->refresh_captcha(true);

            $returnViewData .= $this->load->view($header_tpl,$passedData,$returnData);

            $returnViewData .= $this->load->view($view_file,$passedData,$returnData);

            $returnViewData .= $this->load->view($footer_tpl,$passedData,$returnData);

            return $returnViewData;

        }

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }         



    }

    protected function sendmail($mailMeta,$printDebug = FALSE,$use_defined_config= NULL){



        $this->load->library('email');

         /**send mail config**/

        $config['protocol'] = 'sendmail';

        $config['mailpath'] = '/usr/sbin/sendmail';

        $config['wordwrap'] = TRUE;

        $config['mailtype'] = 'html';

        if(is_array($use_defined_config))

            $config = array_merge($config,$use_defined_config);

        $this->email->initialize($config);

        /**send mail config**/

        /**mail formating**/

        $this->email->from($mailMeta['from']['email'],isset($mailMeta['from']['name'])?$mailMeta['from']['name']:NULL);

        if(isset($mailMeta['reply_to']['email']))

            $this->email->reply_to($mailMeta['reply_to']['email'],isset($mailMeta['reply_to']['name'])?$mailMeta['reply_to']['name']:NULL);



        if(isset($mailMeta['to']))

            $this->email->to($mailMeta['to']); 



        if(isset($mailMeta['cc']))

        $this->email->cc($mailMeta['cc']); 



        if(isset($mailMeta['bcc']))

            $this->email->bcc($mailMeta['bcc']); 



        $this->email->subject(isset($mailMeta['subject'])?$mailMeta['subject']:'');

        $this->email->message(isset($mailMeta['body'])?$mailMeta['body']:'');	



        $sendMailStatus = $this->email->send();

        if($printDebug)

            echo $this->email->print_debugger();

        return $sendMailStatus;



   }

    

   protected function is_authorised($filter_access = NULL) {

       if(isset($filter_access)){

            if(array_search($this->router->method, $filter_access)===FALSE){

                return TRUE;

            } else {

                $usrData = $this->session->userdata('current_user_session');

                if($usrData){

                    return true;

                } else {

                    redirect(base_url());

                   // show_error('You Are Not Allowed!',403,'Access Deny');

                    return false;

                }



            }

       }

   }

      

   /**
    * Process deal list and show as per requirement 
    * @author MM 
    * @param array $dealListCondition filter condition on which the list is showing
    * @param string $dealListTitle Title of the list to show in top gray box
    * @param int $paging Next element offset
    * @param int $limit number of element to show per page
    * @param string $base_url base url used for pagination
    * @example http://site/home/filter_list/ as a base url
    * @param int $uri_segment uri segment used for pagination
    * @example http://site/home/filter_list/16 so the $uri_segment =3
    * @param array $likeCondition If any supporting like condition needed
    * @param bool $ajax_pagination set true for ajax pagination|Default flase
    * basically all over the site the structure is 
    * same
    */ 

   protected function process_deal_list($dealListCondition = '',$dealListTitle = '',$paging = 0,$limit = 36,$base_url= null,$uri_segment = 3,$likeCondition = null,$ajax_pagination=false) {

        $start = $paging;

        $totalData = $this->deal_model->count_joined_active_deal_total($dealListCondition,$likeCondition);

        $config['base_url'] = $base_url;

        $config['total_rows'] = $totalData;

        $config['per_page'] = $limit;           

        $config['uri_segment'] = $uri_segment;

        $config['is_ajax'] = $ajax_pagination;

        $dealListData['title'] = $dealListTitle;        

        //$config['use_page_numbers'] = TRUE;

        $dealListData['dealList'] = $this->deal_model->get_joined_active_deal_list($dealListCondition,'cd_coupon.i_id,cd_coupon.i_cat_id ,s_title,s_store_title,s_store_logo,s_store_logo,s_seo_url,i_cashback,dt_exp_date,cd_coupon.s_url,cd_coupon.s_url,s_store_url,s_image_url,cd_store.s_meta_description as store_meta,cd_coupon.s_meta_description as coupon_meta,d_list_price,d_selling_price,d_discount,s_discount_txt',$limit,$start,$likeCondition);
		//echo $this->db->last_query(); 
		
		/* testing for local*/
		/*if(!SITE_FOR_LIVE)
		{
			$dealListCondition = array();
			$dealListData['dealList'] = $this->deal_model->get_joined_active_deal_list($dealListCondition,'cd_coupon.i_id,cd_coupon.i_cat_id ,s_title,s_store_title,s_store_logo,s_store_logo,s_seo_url,i_cashback,dt_exp_date,cd_coupon.s_url,cd_coupon.s_url,s_store_url,s_image_url,cd_store.s_meta_description as store_meta,cd_coupon.s_meta_description as coupon_meta,d_list_price,d_selling_price,d_discount,s_discount_txt',$limit,$start,$likeCondition);
			
		}*/
		
		//echo $this->db->last_query();

        return $this->load->view('elements/deal_list.tpl.php',array('dealListData'=>$dealListData,'config'=>$config),true);

    }

   
   
    /** 21 Mar 2014
    * Process deal list and show as per requirement 
    * @author MM 
    * @param array $dealListCondition filter condition on which the list is showing
    * @param string $dealListTitle Title of the list to show in top gray box
    * @param int $paging Next element offset
    * @param int $limit number of element to show per page
    * @param string $base_url base url used for pagination
    * @example http://site/home/filter_list/ as a base url
    * @param int $uri_segment uri segment used for pagination
    * @example http://site/home/filter_list/16 so the $uri_segment =3
    * @param array $likeCondition If any supporting like condition needed
    * @param bool $ajax_pagination set true for ajax pagination|Default flase
    * basically all over the site the structure is 
    * same
    */ 
	
	
   protected function process_category_wise_product_list($dealListCondition = '',$dealListTitle = '',$paging = 0,$limit = 36,$base_url= null,$uri_segment = 3,$likeCondition = null,$ajax_pagination=false) {

	
        $start = $paging;
		//$this->load->model('product_model');
        //$totalData = $this->product_model->count_joined_active_deal_total($dealListCondition,$likeCondition);
		$totalData = $this->product_model->count_total_root_category($dealListCondition);
		
        $config['base_url'] 	= $base_url;
        $config['total_rows'] 	= $totalData;
        $config['per_page'] 	= $limit;        
        $config['uri_segment'] 	= $uri_segment;
        $config['is_ajax'] 		= $ajax_pagination;
        $dealListData['title'] 	= $dealListTitle;       

        //$config['use_page_numbers'] = TRUE;
       
		
		$order_name = " i_total_product ";
		$order_by = " DESC ";
		$dealListData['dealList'] = $this->product_model->get_category_with_product_list($dealListCondition,$order_name,$order_by,$start,$limit);
		///echo $this->db->last_query(); 
		//pr($dealListData['dealList'],1);
        return $this->load->view('elements/home_product_list.tpl.php',array('dealListData'=>$dealListData,'config'=>$config),true);

    }



    public function captcha_check() {

                    // First, delete old captchas

            $expiration = time()-7200; // Two hour limit

            $this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);	



                    // Then see if a captcha exists:

            $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";

            $binds = array($this->input->post('captcha'), $this->input->ip_address(), $expiration);

            $query = $this->db->query($sql, $binds);

            $row = $query->row();



            if ($row->count == 0){

                echo json_encode(array('status'=>'failed'));

            } else {

                echo json_encode(array('status'=>'success'));

            }

                

    }

   

    public function refresh_captcha($returnData = false) {

          $this->load->helper('captcha');

            $vals = array(

            //'word'	 => 'test',

            'img_path'	 => BASEPATH.'../images/captcha/',

            'img_url'	 => base_url().'images/captcha/',

            //'font_path'	 => './path/to/fonts/texb.ttf',

            'img_width'	 => '150',

            'img_height' => 30,

            'expiration' => 7200

            );

            



        $cap = create_captcha($vals);

        $data = array(

            'captcha_time'	=> $cap['time'],

            'ip_address'	=> $this->input->ip_address(),

            'word'	 => $cap['word']

            );



        $query = $this->db->insert_string('captcha', $data);

        $this->db->query($query);



        if($returnData)

            return $cap['image'];

        else

            echo $cap['image'];

    }

    

}