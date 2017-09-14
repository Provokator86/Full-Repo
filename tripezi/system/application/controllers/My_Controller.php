<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*********
* Author: Sahinul Haque
* Date  : 24 April 2012
* Modified By: Koushik ,Mrinmoy
* Modified Date: 24 April 2012 
* Purpose:
*  Custom Controller 
*  Common Language conversion template wise
* 
* @include infController.php
*/


//included here so that we can directly implement it into models without inclusion
include_once INFPATH."InfController.php";
include_once INFPATH."InfControllerFe.php";

class MY_Controller extends Controller
{
  
    protected $data = array();
    protected $s_controller_name;
    protected $s_action_name;
    protected $ses_user = array('loggedin'=>'', 'user_id'=>'', 'user_role'=>'', 'email'=>'', 'user_name'=>'');
    public $include_files=array();
    public $s_message_type;
    public $s_message;
    public $i_menu_id='';
	public $i_footer_menu='';
    public $i_admin_page_limit=20;
	public $i_fe_page_limit=10;
	public $i_fe_uri_segment=3;
	public $i_default_language;
	public $i_admin_language;
	public $i_main_default_language;
	public $s_admin_email;
	public $s_gmap2_key;
	public $s_gmap3_key;	
	public $s_facebook_link;
	//public $s_default_currency = 'CAD';
	public $s_meta_type = 'default';
	
	public $s_default_lang_name;
	public $site_default_lang_prefix;



    protected $js_files    = array();
    public $dt_india_time  = '';    
    public $i_uri_seg;
    
    private $controller_admin=array();
	
	public $product_menu_category=array();
	
	
    
    /*****
    *  Failsafe loading parent constructor
    */
    public function __construct()
    {
        try{
            parent::__construct();	
           
		   	header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Pragma: no-cache");
            
            global $CI;
			if( empty( $CI) )
            {
                $CI         =   get_instance();
            }
            else
            {
                echo 'Some error occurred';
            }
           /************ START CHANGE THE PREFIX OF THE CODE BY OPENING COMMENTING ************/
           // by koushik !dont open this code
            
          /*$rs =   $this->db->query('SHOW TABLES FROM property_space');
            $row    =   $rs->result_array();
          
            foreach($row as $value)
            {
               
              
                
                $old_table_name =   $value['Tables_in_property_space'];
                if(preg_match('/^property_/',$old_table_name))
                {
                    
                    $new_table_name =   preg_replace('/^property_/','propertyspace_',$old_table_name) ;
                    echo $new_table_name.'<br/>';
                    $this->db->query('RENAME TABLE '.$old_table_name.' To '.$new_table_name);
                }
                
            } */

           /************ END CHANGE THE PREFIX  ************/
           
           /************ Start Change Charecter set and collation ******/ 
            // by koushik !dont open this code
            
           /* $rs =   $this->db->query('SHOW TABLES FROM hizmetuzmani');
            $row    =   $rs->result_array();
            foreach($row as $value)
            {
            $old_table_name =   $value['Tables_in_hizmetuzmani'];
            $s_qry  =   "ALTER TABLE ".$old_table_name."  CHARACTER SET utf8 COLLATE utf8_general_ci ";
            $this->db->query($s_qry);
            echo $this->db->last_query().'<br/>';
            }*/
           /************ End Change Charecter set and collation ******/ 

			$this->i_admin_language = 1;
            /////Assign Selected Menu///
            $this->data['h_menu'] = ($this->session->userdata("s_menu")?$this->session->userdata("s_menu"):"mnu_0");

            /////loading session loggedin user data////
            $this->data['loggedin'] = $this->session->userdata("loggedin");			
			$this->data['admin_loggedin'] = $this->session->userdata("admin_loggedin");
			//pr($this->data['loggedin']); exit;
			$s_router_directory=$this->router->fetch_directory();
			/****** check admin login to access language section *******/
			if($s_router_directory=="language/")
			{
				if(empty($this->data['admin_loggedin']) || decrypt($this->data['admin_loggedin']['user_type_id'])!=0)
				{					
					redirect(admin_base_url());
				}
			}

            //////////if no Directory Found then, Set folder "fe" for views only////////
            if($s_router_directory!="" && $s_router_directory!="language/")///For forntend views
			{         		
			 	//////Checking Access Control////
            	$this->chk_access_control();
            	//////end Checking Access Control////
            }  
          
            $this->load_defaults();
           
           // $this->load->helper('my_language_helper');

            $this->_set_timezone();
            
            $o_ci=&get_config();
            if($this->router->fetch_directory() == '') // for front_end
			{
				$this->i_uri_seg=$o_ci["fe_uri_seg"];///Number of segments to cutoff for pagination
			}
			else // for admin and others
			{
				$this->i_uri_seg=$o_ci["uri_seg"];///Number of segments to cutoff for pagination
			}				
            
			unset($o_ci);
            
            ////////////Managing Validators/////////
            $this->load->library('form_validation');
        	if($this->router->fetch_directory() == '') // for front_end
			{
				$this->form_validation->set_error_delimiters('<div class="error"><span class="left"><strong>','</strong></span></div>');
			}	
			else
			{
				$this->form_validation->set_error_delimiters('<div id="err_msg" class="error_massage">', '</div>');	
			}
            //$this->lang->load('form_validation', 'turkish');	
			
			
			/*=====================  FETCH SITE SETTINGS DETAILS ======================= */
			$this->load->model('site_setting_model','mod_site_setting');
			$info = $this->mod_site_setting->fetch_this("NULL");			
			$this->s_admin_email  	= $info["s_admin_email"];
			$this->config->set_item('CONF_EMAIL_ID', $info["s_admin_email"]);
			
			$this->data["s_paypal_email"]				= $info["s_paypal_email"];
			$this->data["s_gmap2_key"]  				= $info["s_google_map_key"];
			$this->data["s_gmap3_key"]  				= $info["s_google_map_key_gmap3"];
			$this->data["d_service_charge_percentage"]	= $info["d_service_charge_percentage"];
            $this->data["d_site_comission_percentage"]	= $info["d_site_comission_percentage"];
            $this->data["s_facebook_address"]			= $info["s_facebook_address"];
			$this->data["s_twitter_address"]			= $info["s_twitter_address"];
			$this->data["s_linkedin_address"]			= $info["s_linkedin_address"];
			$this->data["s_google_plus_address"]		= $info["s_google_plus_address"];
			$this->data["s_youtube_address"]			= $info["s_youtube_address"];

            $_SESSION['fb_app_id'] = "378689575517541"; // FB App ID/API Key
            $_SESSION['fb_app_secret'] = "f949c5ce338a813632d26cd77f517de8"; // FB App Secret
            
             //$_SESSION['fb_app_id'] = "329226757171465"; // FB App ID/API Key
             //$_SESSION['fb_app_secret'] = "a48de548306bbd8e4eab25ee6145f15b"; // FB App Secret
            
			/*=====================  FETCH SITE SETTING DETAILS ======================= */
            
            
            
            ////////////end Managing Validators/////////
			$this->i_default_currency = 3;
			$this->data['i_default_currency'] = $this->i_default_currency;
			
			/************************* SET DEFAULT CURRENCY *************************************/
			$currecncy_session	=	$this->session->userdata('cur_id');
			$this->data['i_currency_id'] 		= $this->session->userdata('cur_id')?$this->session->userdata('cur_id'):$this->i_default_currency;
			if(!isset($currecncy_session) || empty($currecncy_session))
			{	//echo 'hi'; exit;
				setCurrecncy();
			}
			else
			{
				//echo 'hello';exit;
				setCurrecncy($this->session->userdata('cur_id'));
				
			}
			$this->curRate 		= $this->session->userdata('cur_rate');
			$this->curCode 		= $this->session->userdata('cur_iso_code');
			$this->curSymbol 	= $this->session->userdata('cur_symbol');
			$this->curId 		= $this->session->userdata('cur_id');
			
			/************************* SET DEFAULT CURRENCY *************************************/
			
			/********************* FETCH TOP DESTINATIONS BASED ON NUMBER OF PROPERTIES  ************************/
			/*$this->load->model('property_model','mod_property');			
			$s_where = " WHERE c.i_status = 1 ";
			$this->data["top_destinations"] = $this->mod_property->fetch_top_destinations($s_where,0,16);*/
			$this->load->model('city_model','mod_city');
			$s_where = " WHERE c.i_top_destination = 1 ";
			$this->data["top_destinations"] = $this->mod_city->fetch_multi($s_where,0,16);
			$this->data["i_count"]	=	count($this->data["top_destinations"]);
			//pr($this->data["top_destinations"],1);
			/********************* END FETCH TOP DESTINATIONS BASED ON NUMBER OF PROPERTIES  ************************/
			
			
			/*needed for news scroll*/
			$this->data['tot_news'] = 0;
			
			/*added by iman to show error message*/
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
                        
			
			// for language
			//$this->_set_language($this->i_default_language);            
			//$this->_set_translations();
                        
			
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
    }
    
    /**
    * Method Format
    * 
    * @param string $s_logmsg
    */
    public function load_defaults()
    {
        try
        {
            
            $this->data['heading'] = 'Page Heading';
            $this->data['content'] = '';
            $this->data['css'] = '';
            $this->data['js'] = '';
            $this->data['php'] = '';
            $this->data['title'] = 'Page Title';

            $this->s_controller_name = $this->router->fetch_directory() . $this->router->fetch_class();
			
			//This line is added by Jagannath Samanta on 22 June 2011 
			//Only for product_image module path. Note don't modify it.
			$this->s_controller_name_pro_img = $this->router->fetch_directory() . "product_image";
			
            $this->s_action_name = $this->router->fetch_method();
            
            //$this->india_time   = time()-19800;
            $this->dt_india_time   = time();
			
            
        }
        catch(Exception $err_obj)
        {
          show_error($err_obj->getMessage());
        }        
    }
	
	/*
	* Set meta realted tags here 
	*/
	public function set_meta()
	{
		try
		{
			/*$this->load->model('meta_tags_model');
			$s_where = " WHERE s_page='{$this->s_meta_type}'";
			$info = $this->meta_tags_model->fetch_multi($s_where);
			
			if(!empty($info))
			{
				$this->data['meta_page'] 			= $info[0]['s_page_title'];
				$this->data['meta_title'] 			= $info[0]['s_title'];
				$this->data['meta_keyword'] 		= $info[0]['s_keywords'];
				$this->data['meta_description'] 	= $info[0]['s_description'];
			}
			else
			{
				$s_where = " WHERE s_page='default'";
				$info = $this->meta_tags_model->fetch_multi($s_where);
				$this->data['meta_page'] 			= $info[0]['s_page_title'];
				$this->data['meta_title'] 			= $info[0]['s_title'];
				$this->data['meta_keyword'] 		= $info[0]['s_keywords'];
				this->data['meta_description'] 		= $info[0]['s_description'];
			}       */
			
			
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	}
    
    /****
    * put your comment there...
    * 
    * @param array $files
    */
    protected function set_include_files($files=array())
    {
        try
        {
            $this->include_files    = $files;
            unset($files);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
        
    }

    /***
    * Rendering default template and others.
    * Default : application/views/admin/controller_name/method_name.tpl.php
    * For Popup window needs to include the main css and jquery exclusively.
    * 
    * @param string $s_template, ex- dashboard/report then looks like application/views/admin/.$s_template.tpl.php
    * @param boolean $b_popup, ex- true if displaying popup, false to render within the main template
    */
    protected function render($s_template='',$b_popup=FALSE)
    {
        try
        {
			$this->set_meta(); // to create dynamic meta tags during rendering the page
		
            $s_view_path = $this->s_controller_name . '/' . $this->s_action_name . '.tpl.php';
            
            $s_router_directory=$this->router->fetch_directory();
            //////////if no Directory Found then, Set folder "fe" for views only////////
            if($s_router_directory=="")///For forntend views
            {
                $s_router_directory="fe/";
                $s_view_path=$s_router_directory.$s_view_path;
            }
            //////////end if no Directory Found then, Set folder "fe" for views only////////
            
            if (file_exists(APPPATH . 'views/'.$s_router_directory.$s_template.'.tpl.php'))
            {
                $this->data['content'] .= $this->load->view($s_router_directory. '/'.$s_template.'.tpl.php', $this->data, true);
            } 
            elseif(file_exists(APPPATH . 'views/'.$s_view_path))
            {
                $this->data['content'] .= $this->load->view($s_view_path, $this->data, true);
            }    

            ////////rendering the Main Tpl////
            if(!$b_popup)////If not opening in popup window
            {  
                $locallang=$this->load->view($s_router_directory . '/'."main.tpl.php", $this->data,TRUE);  
                
                /////////Displaying the converted language/////
                echo $this->parse_lang($locallang);
                unset($locallang);
                /////////end Displaying the converted language/////
            }
            else/////Rendering for popup window
            {
                echo $this->parse_lang($this->data['content']);
            }
            ////////end rendering the Main Tpl////
            unset($s_template,$s_view_path,$s_router_directory);    
		
		}
        catch(Exception $err_obj)
        {
          show_error($err_obj->getMessage());
        }         

    }

    /***
    * put your comment there...
    * 
    * @param string $s_filename, ex- css/admin/style.css
    */
    protected function add_css($s_filename)
    {
        try
        {
            $this->data['css'] .= $this->load->view("css.tpl.php", array('filename' => $s_filename), true);
            unset($s_filename);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
    
    /***
    * put your comment there...
    * 
    * @param string $s_filename
    */
    protected function add_php($s_filename)
    {
        try
        {
            $this->data['php'] .= $this->load->view("php.tpl.php", array('filename' => $s_filename), true);
            unset($s_filename);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
    
    /***
    * put your comment there...
    * 
    * @param string $s_filename, ex- js/jquery/jquery-1.4.2.js
    */
    protected function add_js($s_filename)
    {
        try
        {
            $this->data['js'] .= $this->load->view("js.tpl.php", array('filename' => $s_filename), true);
            unset($s_filename);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }   
    }

    /***
    * put your comment there...
    * 
    */
    public function _set_timezone()
    {
        try
        {
            date_default_timezone_set('Europe/London');    
			header('Content-Type: text/html; charset=utf-8'); 
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    /***
    * Display records in the template table 
    * 
    * @param array $tbldata 
    * $tbldata["headers"][0]["width"]="20%" or "30px"
    *   $tbldata["headers"][0]["align"]="left"
    *   $tbldata["headers"][0]["val"]="Account Name"  
    * 
    * $tbldata["tablerows"][i_row][i_col]=Value
    * $tbldata["tablerows"][i_row][0]=Value of primary key, Col Index 0 must be the encrypted PK
    * 
    * $tbldata["caption"]="Accounts"
    * $tbldata["total_rows"]=200 ///used for pagination
    * 
    */
    protected function admin_showin_table($tbldata,$no_action= FALSE)
    {
        try
        {	
            //$this->data['php'] .= $this->load->view("php.tpl.php", array('filename' => $s_filename), true);
            $s_ret_="";
            if(!empty($tbldata))
            {
                $s_pageurl= admin_base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
                $tbldata["pagination"]=$this->get_admin_pagination($s_pageurl, 
                                                                   $tbldata["total_db_records"],
                                                                   $this->i_admin_page_limit);
                                                                   
                $tbldata["s_controller_name"]=admin_base_url().$this->router->fetch_class() . '/';
				
				//This line is added by Jagannath Samanta on 22 June 2011 
				//Only for product_image module path. Note don't modify it.
				//$tbldata["s_controller_name_pro_img"]=admin_base_url()."product_image". '/';
				
                $tbldata["i_pageno"]=$this->uri->segment($this->i_uri_seg);///current page number
				$tbldata['no_action'] = $no_action;
                //pr($tbldata);exit;
				
                ///////////Access control for Insert, Edit, Delete/////
                $tbldata["action_allowed"]=$this->data["action_allowed"];
				
                $s_ret_=$this->load->view($this->router->fetch_directory() . '/'."list.tpl.php",$tbldata,TRUE);
            }
            unset($tbldata,$s_pageurl);
            return $s_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
    
	 protected function admin_showin_order_table($tbldata,$no_action= FALSE,$i_uri_seg=6)
	 {
        try
        {	
            //$this->data['php'] .= $this->load->view("php.tpl.php", array('filename' => $s_filename), true);
            $s_ret_="";
            if(!empty($tbldata))
            {
				
                $s_pageurl= admin_base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
				if(isset($tbldata['order_name']))
				{
					 $s_pageurl=  $s_pageurl.'/'.$tbldata['order_name'];
					 if(isset($tbldata['order_by']))
					 {
					 	 $s_pageurl=  $s_pageurl.'/'.$tbldata['order_by'];
					 }
					 
				}
                $tbldata["pagination"]=$this->get_admin_pagination($s_pageurl, 
                                                                   $tbldata["total_db_records"],
                                                                   $this->i_admin_page_limit,$i_uri_seg);
														   
                                                                   
                $tbldata["s_controller_name"]=admin_base_url().$this->router->fetch_class() . '/';
				
				//This line is added by Jagannath Samanta on 22 June 2011 
				//Only for product_image module path. Note don't modify it.
				//$tbldata["s_controller_name_pro_img"]=admin_base_url()."product_image". '/';
				
                $tbldata["i_pageno"]=$this->uri->segment($i_uri_seg);///current page number
				$tbldata['no_action'] = $no_action;
                //pr($tbldata);exit;
				
                ///////////Access control for Insert, Edit, Delete/////
                $tbldata["action_allowed"]=$this->data["action_allowed"];
				
                $s_ret_=$this->load->view($this->router->fetch_directory() . '/'."list.tpl.php",$tbldata,TRUE);
            }
            unset($tbldata,$s_pageurl);
            return $s_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }   
	}      
    
	
    /***
    * $rq_url is the redirect pagination url ex. http://localhost/tamanna/php/admin/user/user_list.
    * $total_no is the total number of records in database. 
    * $per_page is the number of records shown in page.
    * $uri_seg to be changed in live.
    */
    public function get_admin_pagination($s_rq_url, $i_total_no, $i_per_page=10, $i_uri_seg=NULL)
    {
        try
        {
			$this->load->library('pagination');
			
			$org_enable_query_strings = $this->config->item('enable_query_strings');
			$this->config->set_item('enable_query_strings',FALSE);
			
			
            $config['base_url'] = $s_rq_url;

            $config['total_rows'] = $i_total_no;
            $config['per_page'] = $i_per_page;

            $config['uri_segment'] = ($i_uri_seg?$i_uri_seg:$this->i_uri_seg);

            $config['num_links'] = 2;
            $config['page_query_string'] = false;
			
			
			$config['first_link'] = '&lsaquo; First';
            $config['last_link'] = 'Last &rsaquo;';

            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
			
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li class="next">';
            $config['next_tag_close'] = '</li>';
            //$config['prev_tag_open'] = '<li class="previous-off">';
			$config['prev_tag_open'] = '<li class="previous">';
            $config['prev_tag_close'] = '</li>';
            $config['prev_link'] = '&laquo;Previous';
            $config['next_link'] = 'Next&raquo;';
			
			

            $config['cur_tag_open'] = ' <li class="active">';
            $config['cur_tag_close'] = '</li>';
			//pr($config);
            $this->pagination->initialize($config);
            unset($s_rq_url,$i_total_no,$i_per_page,$i_uri_seg,$config);
            
			$return  = $this->pagination->create_links();
			$this->config->set_item('enable_query_strings',$org_enable_query_strings);
			return $return;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }        
    
	/* function require for extra parameter along with $start and $limit */
    protected function admin_showin_param_table($tbldata,$no_action= FALSE)
    {
        try
        {	
			//var_dump($tbldata);exit;
            //$this->data['php'] .= $this->load->view("php.tpl.php", array('filename' => $s_filename), true);
            $s_ret_="";
            if(!empty($tbldata))
            {
				
                $s_pageurl= admin_base_url().$this->router->fetch_class() . '/' . $this->s_action_name.'/'.$tbldata['param_type'];
                $tbldata["pagination"]=$this->get_admin_pagination($s_pageurl, 
                                                                   $tbldata["total_db_records"],
                                                                   $this->i_admin_page_limit);
                                                                   
                $tbldata["s_controller_name"]=admin_base_url().$this->router->fetch_class() . '/';
				
				//This line is added by Jagannath Samanta on 22 June 2011 
				//Only for product_image module path. Note don't modify it.
				//$tbldata["s_controller_name_pro_img"]=admin_base_url()."product_image". '/';
				
                $tbldata["i_pageno"]=$this->uri->segment($this->i_uri_seg);///current page number
				$tbldata['no_action'] = $no_action;
                //pr($tbldata);exit;
				
                ///////////Access control for Insert, Edit, Delete/////
                $tbldata["action_allowed"]=$this->data["action_allowed"];
				
                $s_ret_=$this->load->view($this->router->fetch_directory() . '/'."list.tpl.php",$tbldata,TRUE);
            }
            unset($tbldata,$s_pageurl);
            return $s_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }	
	
	
	
	
	
	
	
     /***
    * $rq_url is the redirect pagination url ex. http://localhost/tamanna/php/fe/news.html 
    * $total_no is the total number of records in database. 
    * $per_page is the number of records shown in page.
    * $uri_seg to be changed in live.
    */
 	public function get_fe_pagination($s_rq_url, $i_total_no, $i_per_page = NULL, $i_uri_seg=NULL)
    {
        try
        {
            
			$this->load->library('pagination');
			//$s_rq_url= base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
			
            $config['base_url'] = $s_rq_url;

            $config['total_rows'] = $i_total_no;
            $config['per_page'] = ($i_per_page?$i_per_page:$this->i_fe_page_limit) ;
            $config['uri_segment'] = ($i_uri_seg?$i_uri_seg:$this->i_uri_seg);

            $config['num_links'] = 2;
            $config['page_query_string'] = false;

            //$config['first_tag_open'] = '<a>';
            //$config['first_tag_close'] = '</a>';
            //$config['last_tag_open'] = '<a>';
            //$config['last_tag_close'] = '</a>';
			/***sh***
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li class="next">';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li class="previous-off">';
            $config['prev_tag_close'] = '</li>';
            $config['prev_link'] = '&laquo;Previous';
            $config['next_link'] = 'Next&raquo;';

            $config['cur_tag_open'] = ' <li class="active">';
            $config['cur_tag_close'] = '</li>';
			
			***/
	
            $config['prev_link'] = '###FE_PAGE_PREVIOUS###';
            $config['next_link'] = '###FE_PAGE_NEXT###';

			$config['cur_tag_open'] = '<a class="active">';
            $config['cur_tag_close'] = '</a>';
						

            $this->pagination->initialize($config);
            unset($s_rq_url,$i_total_no,$i_per_page,$i_uri_seg,$config);
            return $this->pagination->create_links();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }        
	
	
	
	
    /***
    * Language translation Done Here.
    * In the template all markers like ###LBL_CITY### will be translated into language.
    * If no conversation is found the marker will display like ###LBL_CITY###.
    * Markers in the template must be in uppercase.
    * 
    * @param $raw_content string, 
    * @return string of translated language
    */
    protected function parse_lang($s_raw_content)
    {
        try
        {
            $lng=array();
            $s_locallang=$s_raw_content;
			
            if(SITE_FOR_LIVE)
            {
				$dir =  ($this->i_default_language==1)?'english':'french';
                $lng= $this->lang->load('common', $dir,TRUE);
            }
            else
            {
                $lng= $this->lang->load('common', 'english',TRUE);
            }

            //$this->lang->line('be_invalid_connection_str')
            if(!empty($lng))
            {
                /***
                * ex- in the raw content the language key must be used like :-  ###LBL_CITY###
                */
                foreach($lng as $s_lng_key=>$s_lng_content)
                {
                    $s_locallang=str_replace("###".strtoupper($s_lng_key)."###",$s_lng_content,$s_locallang);
                }///end for
            }
            unset($s_raw_content,$lng);
            return $s_locallang;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }   
    }    
	
	protected function _set_translations() {/*
		$ci = get_instance();
		$this->data['current_language'] = get_current_language();
	
		if( is_readable(BASEPATH.$ci->config->item('multilanguage_object')) ) {
			$this->translation_container = unserialize(BASEPATH.$ci->config->item('multilanguage_object'));
		}
		else if( is_readable(BASEPATH.$ci->config->item('multilanguage_xml')) ) {
			$ci->load->library('multilanguage/TMXParser');
			$ci->tmxparser->setXML(BASEPATH.$ci->config->item('multilanguage_xml'));
			$ci->tmxparser->setMasterLanguage($ci->config->item('master_language'));
			$tc = $ci->tmxparser->doParse();
	
			$this->translation_container = $tc;
			
		} */
		
	}

	public function get_translations() {
		//return $this->translation_container;
	}

	protected function _set_language($lang_id) {
		/*$this->load->model('language_model');
		$lang = $this->language_model->fetch_this($lang_id);
		$lang_name =  $lang['s_short_name'];
		if( in_array( $lang_name, $this->config->item('languages')) ) {
			$this->session->set_userdata('current_language', $lang_name);
		}    */
	}	
	
	
    /***
    * Access checking based on user type Done Here.User type fetched from session
    */
	public function chk_access_control()
	{
        try
        {
			//echo $this->uri->uri_string();
			
			$this->load->model("Permission_model","mod_permit");
            $can_access=$this->mod_permit->can_user_access(
										decrypt($this->data['admin_loggedin']["user_type_id"]),
										$this->uri->uri_string()
										);
                                        
			if(!$can_access)
			{
				throw new Exception('Public Access Restricted. <a href="'.admin_base_url()."home/".'">Please login.</a>');
			}
			else
			{
				/*echo $this->uri->rsegment(1);
				pr($this->data['admin_loggedin'],1);*/
				///checking admin login///
				if(empty($this->data['admin_loggedin']) && ($this->uri->rsegment(1)!='home' && $this->uri->rsegment(1)!='forgot_password' && $this->uri->rsegment(1)!='send_logged_email'))
				{
					redirect(admin_base_url()."home/");
					return false; 
				}	
						
			}
			
			
			////now fetching controls within the page.
			//// ex. add button, edit button, delete button, etc.
            /**
            * When routes.php is used to re route some controllers.
            * Used to display in menus and access control, but in physical 
            * the controller doesnot exists. It simply redirects to other controller.
            * ex- New_customer_life_insurance controller doesnot exists, 
            *     It is redirected to Customer controller in routes.php  
            */
            $pre_route_controller=$this->uri->segment(2);
            $post_route_controller=$this->uri->rsegment(1);
            /*if($pre_route_controller!=$post_route_controller && $pre_route_controller!="")///re-routed
            {
                $load_controller=ucfirst($pre_route_controller);////donot delete this
            }
            else///Not re-routed
            {
                $load_controller=ucfirst($this->router->fetch_class());////donot delete this
            }
            unset($pre_route_controller,$post_route_controller);
			*/			
			
			
			$this->data["action_allowed"]=$this->mod_permit->fetching_access_control(
												array(
													"i_user_type_id"=>decrypt($this->data['admin_loggedin']["user_type_id"]),
													"controller"=>$pre_route_controller,
													"alias_controller"=>$post_route_controller
												));
                                                
                                                
			
			
			//pr($this->data["action_allowed"]);
			
            /////////end Fetching controllers from usertype access/////
             // var_dump($this->data["controllers_selected"]); 
            /*if(array_key_exists($load_controller,$this->controller_admin) 
                && str_replace("/","",$this->router->fetch_directory())=="admin")
				{
					 unset($load_controller);
					///checking admin login///
					if(empty($this->data['admin_loggedin']))
					{
						redirect(admin_base_url()."home/");
						return false; 
					}
				}*/
           
            //////end Checking Access Control////
			
			
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }             
	}
	
	
	
	/** To store search data for jobs **/
    protected function get_session_data($key,$tmpArr=array())
    {
        $arr    = $this->session->userdata('model_session');
        if(isset($arr[$key]))
            return $arr[$key];
        elseif(isset($tmpArr[$key]))
            return $tmpArr[$key];
        else
            return '';
    }
	
	/**** admin report*/
    protected function admin_report_showin_table($tbldata,$no_action= FALSE,$i_uri_seg=6)
    {
        try
        {	
			//echo $this->i_uri_seg;exit;
            //$this->data['php'] .= $this->load->view("php.tpl.php", array('filename' => $s_filename), true);
            $s_ret_="";
            if(!empty($tbldata))
            {
                $s_pageurl= admin_base_url().$this->router->fetch_class() . '/' . $this->s_action_name.'/'.$tbldata['order_name'].'/'.$tbldata['order_by'];
				//$s_pageurl= admin_base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
				//echo $s_pageurl; exit;
                $tbldata["pagination"]=$this->get_admin_pagination($s_pageurl, 
                                                                   $tbldata["total_db_records"],
                                                                   $this->i_admin_page_limit,
																   $i_uri_seg);
                 //var_dump($tbldata["pagination"]);                                                  
                $tbldata["s_controller_name"]=admin_base_url().$this->router->fetch_class() . '/';
				
				//This line is added by Jagannath Samanta on 22 June 2011 
				//Only for product_image module path. Note don't modify it.
				//$tbldata["s_controller_name_pro_img"]=admin_base_url()."product_image". '/';
				
                $tbldata["i_pageno"]=$this->uri->segment($this->i_uri_seg);///current page number
				$tbldata['no_action'] = $no_action;
                //pr($tbldata);exit;
				
                ///////////Access control for Insert, Edit, Delete/////
                $tbldata["action_allowed"]=$this->data["action_allowed"];
				
                $s_ret_=$this->load->view($this->router->fetch_directory() . '/'."list.tpl.php",$tbldata,TRUE);
            }
            unset($tbldata,$s_pageurl);
            return $s_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }	
	

			
    public function __destruct()
    {}
    
}
/////end of class

