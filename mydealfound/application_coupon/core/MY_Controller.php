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
    
    private $controller_admin=array();
	
    public function __construct() {
        parent::__construct();
        global $CI;
	if( empty( $CI) )
            {
                $CI         =   get_instance();
               
            }
            else
            {
                echo 'Some error occurred';
            }
             //$this->output->cache(1);
        //custome loading files
            
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
            $passedData['site_title'] = 'Mydealfo';
            $passedData['site_meta_keywords'] = '';
            $passedData['site_meta_description'] = '';
            $passedData['site_meta_tags'] = '';
            $passedData['site_copyright'] = '© Deal Aggregator';
            
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

    
}

?>
