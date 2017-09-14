<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*********
* Author: SWI
* Date  : 2 June 2015
* Modified By: 
* Modified Date: 
* Purpose:
* Custom Controller 
* Common Language conversion template wise
* 
* @include infController.php
*/

// Included here so that we can directly implement it into models without inclusion
include_once INFPATH."InfController.php";
include_once INFPATH."InfControllerFe.php";

class MY_Controller extends CI_Controller
{
    protected $data = array(), $s_controller_name, $s_action_name; // Important
	
	public $i_admin_page_limit = 10, $i_max_listing_no , $i_fe_page_limit = 4, $i_default_language, $s_admin_email, $i_uri_seg, $s_footer_text;
    public $fe_uri_seg, $admin_datepicker_format = 'mm/dd/yy', $s_default_lang_prefix	=	'en';
    public $s_current_lang_prefix='en',$admin_loggedin = '', $fe_loggedin = '', $is_fe_loggedin = false,$site_setting_info;
	public $reffer_url = 'home';
    public $allowedExt = 'jpeg|jpg|png|doc|docx|csv|xls|xlsx|pdf|txt';
    public $additional_info = '', $comment = '', $business_id = '', $business_type = '';
    /*****
    *  Failsafe loading parent constructor
    */
    public function __construct()
    {
        try
		{
            parent::__construct();
		   	header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Pragma: no-cache");
            
            // Increase mysql group_concat limit
            $this->db->simple_query('SET GLOBAL group_concat_max_len=150000');
            
            // Fe Login data
            $this->data['fe_loggedin'] = $this->fe_loggedin = $this->session->userdata("fe_loggedin");
            if(decrypt($this->fe_loggedin['user_id']) > 0)
            {
                $this->data['buyer_logged_in'] = true;
                $this->is_fe_loggedin = true;
            }
            
			// Assign Selected Menu //
            $this->data['h_menu'] = ($this->session->userdata("s_menu")?$this->session->userdata("s_menu"):"mnu_0");
			$this->data['admin_loggedin'] = $this->admin_loggedin = $this->session->userdata("admin_loggedin");
            
            
            
            
			/**************** ADMIN AVATAR *******************************/
            $admin_id = decrypt($this->data['admin_loggedin']['user_id']);
            $role_id = decrypt($this->data['admin_loggedin']['user_type_id']);
            if($admin_id > 0 && $role_id > 0)
            {
                $tmp = $this->acs_model->fetch_data($this->db->USER, array('i_id'=> $admin_id));
                $user_role_info = $this->acs_model->fetch_data($this->db->USERROLE, array('i_user_id' => $admin_id, 'i_role_id' => $role_id),'e_access_type', 0,1,'i_id');
                $this->data['admin_details'] = $tmp[0];
                $this->data['admin_details']['e_access_type'] = $user_role_info[0][e_access_type];
                if($this->data['admin_details']['s_avatar']!='')
			        $this->data['admin_avatar']	= base_url('uploaded/user_image/thumb').'/'.$this->data['admin_details']['s_avatar'];						
                else
                    $this->data['admin_avatar']    = base_url('uploaded/user_image/thumb/avatar.png');      
            }
            unset($tmp, $admin_id);
			/************************************************************/
			
			$s_router_directory = $this->router->fetch_directory();
				//echo $s_router_directory.'==============>here'; exit;
			/****** check admin login to access language section *******/
			if($s_router_directory == "language/")
			{
				if(empty($this->data['admin_loggedin']) || decrypt($this->data['admin_loggedin']['user_type_id'])!=0)
				{					
					redirect(admin_base_url());
				}
			}
			
            // Login check
            //commeted as user will have only one type of role 15 Nov
            /*if($s_router_directory == ADMIN_DIR."/" && empty($this->data['admin_loggedin']) && $this->router->fetch_class() != 'home')
            {
                redirect(admin_base_url());
            } else if($s_router_directory == ADMIN_DIR."/" 
            && $this->router->fetch_class() != 'home'
            && !empty($this->data['admin_loggedin'])
            )
            {
                if(decrypt($this->data['admin_loggedin']['region_id']) != 'admin' && intval(decrypt($this->data['admin_loggedin']['region_id'])) == 0)
                {
                    redirect(admin_base_url()."home/select_role"); 
                }
            }*/
            // End


            //if no Directory Found then, Set folder "fe" for views only//
		    if($s_router_directory != "" && $s_router_directory != "language/")//For forntend views
			{         		
				// Checking Access Control//
            	$this->chk_access_control();
            	// End Checking Access Control//
            }  
          
            $this->load_defaults();
           
            $this->load->helper('my_language_helper'); // needed in server as t() function is used
            $this->_set_timezone();
            
            $o_ci = &get_config();
            if($this->router->fetch_directory() == '') // for front_end
			{
				$this->i_uri_seg = $o_ci["fe_uri_seg"]; //Number of segments to cutoff for pagination
			}
			else // for admin and others
			{
				$this->i_uri_seg=$o_ci["uri_seg"];//Number of segments to cutoff for pagination
			}				
            
			unset($o_ci);
            
            //Managing Validators//
            $this->load->library('form_validation') ;
        	if($this->router->fetch_directory() == '') // for front_end
			{
				$this->form_validation->set_error_delimiters('<div class="error_message">','</div>');
			}	
			else
			{
				$this->form_validation->set_error_delimiters('<div id="err_msg" class="alert alert-error"><button data-dismiss="alert" class="close" type="button">×</button>', '</div>');	
				$this->form_validation->set_message('required', 'Please provide %s');
				
			}
            $this->form_validation->set_message('matches', 'Please check fields, %s has not matched');
            $this->form_validation->set_message('is_unique', 'Please check fields, %s value already exist ');
            $this->form_validation->set_message('unique_email_check', 'Please check fields, %s value already exist ');
            //end Managing Validators//
			 
			/*=====================  FETCH SITE SETTINGS DETAILS [BEGIN] ======================= */
			$this->load->model('site_setting_model','mod_site_setting');
			$info = $this->mod_site_setting->fetch_this("NULL");			
			$this->s_admin_email  		= $info["s_admin_email"];
            $this->i_admin_page_limit   = $info['i_records_per_page'];
            $this->i_max_listing_no   	= $info['i_max_listing']; // for next maximum business brokerage listing number to be start with
			$this->s_footer_text        = $info['s_footer_text'];
			$this->config->set_item('CONF_EMAIL_ID', $info["s_admin_email"]);
            $this->site_setting_info        = $info;
            $this->data['site_setting_info'] = $info;
           /*=====================  FETCH SITE SETTING DETAILS [END] ======================= */
           
           
						
			/*added by mrinmoy to show error message*/
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
			
			
			$this->_set_language($this->i_default_language);
			//$this->_set_translations();
			
			$this->i_default_language = 1;
			$this->s_default_lang_prefix;
			$this->s_current_lang_prefix = ($this->session->userdata('current_language')) ? $this->session->userdata('current_language') : $this->site_default_lang_prefix;
            
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
            $this->data['heading'] = '';
            $this->data['content'] = '';
            $this->data['css'] = '';
            $this->data['js'] = '';
            $this->data['php'] = '';
            $this->data['title'] = '';
            $this->s_controller_name = $this->router->fetch_directory() . $this->router->fetch_class();			
            $this->s_action_name = $this->router->fetch_method();
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
    protected function render($s_template='', $b_popup=FALSE)
    {
        try
        {
			$this->set_meta(); // to create dynamic meta tags during rendering the page
            $s_view_path = $this->s_controller_name . '/' . $this->s_action_name . '.tpl.php';
            $s_router_directory=$this->router->fetch_directory();
            //if no Directory Found then, Set folder "fe" for views only//
            if($s_router_directory=="")//For forntend views
            {
                $s_router_directory="fe/";
				$s_view_path=$s_router_directory.$s_view_path;
            }
            //end if no Directory Found then, Set folder "fe" for views only//
            if (file_exists(APPPATH . 'views/'.$s_router_directory.$s_template.'.tpl.php'))
            {
                $this->data['content'] .= $this->load->view($s_router_directory. '/'.$s_template.'.tpl.php', $this->data, true);
            } 
            elseif(file_exists(APPPATH . 'views/'.$s_view_path))
            {
                $this->data['content'] .= $this->load->view($s_view_path, $this->data, true);
            }    
			
            //rendering the Main Tpl//
            if(!$b_popup)//If not opening in popup window
            {  
                $locallang = $this->load->view($s_router_directory . '/'."main.tpl.php", $this->data,TRUE);
                //Displaying the converted language//
                echo $this->parse_lang($locallang);
                unset($locallang);
                //end Displaying the converted language//
            }
            else//Rendering for popup window
            {
                echo $this->parse_lang($this->data['content']);
            }
            //end rendering the Main Tpl//
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
    * $tbldata["total_rows"]=200 //used for pagination
    * 
    */
    protected function admin_showin_table($tbldata, $no_action = FALSE)
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
				
                $tbldata["i_pageno"]=$this->uri->segment($this->i_uri_seg);//current page number
				$tbldata['no_action'] = $no_action;
                //pr($tbldata);exit;
				
                //Access control for Insert, Edit, Delete//
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
				
                $tbldata["i_pageno"]=$this->uri->segment($i_uri_seg);//current page number
				$tbldata['no_action'] = $no_action;
                //pr($tbldata);exit;
				
                //Access control for Insert, Edit, Delete//
                $tbldata["action_allowed"] = $this->data["action_allowed"];
				
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
    
    /* below function admin_showin_extra_param_order_table()
    * for extra parameter after method list 
    * on 26 June,2015
    * for region/franchise team and partners
    */
    protected function admin_showin_extra_param_order_table($tbldata,$no_action= FALSE,$i_uri_seg=7)
    {
        try
        {    
            //$this->data['php'] .= $this->load->view("php.tpl.php", array('filename' => $s_filename), true);
            $s_ret_="";
            $extra_param = $this->session->userdata('teamRegionId');
            if(!empty($tbldata))
            {
                
                #$s_pageurl= admin_base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
                $s_pageurl= admin_base_url().$this->router->fetch_class() . '/' . $this->s_action_name.'/'.$extra_param;
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
                
                $tbldata["i_pageno"]=$this->uri->segment($i_uri_seg);//current page number
                $tbldata['no_action'] = $no_action;
                //pr($tbldata);exit;
                
                //Access control for Insert, Edit, Delete//
                $tbldata["action_allowed"] = $this->data["action_allowed"];
                
                #$s_ret_=$this->load->view($this->router->fetch_directory() . '/'."list.tpl.php",$tbldata,TRUE);
                $s_ret_=$this->load->view($this->router->fetch_directory() . '/'."list_extra_param.tpl.php",$tbldata,TRUE);
            }
            unset($tbldata,$s_pageurl);
            return $s_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }   
    }      
    
	
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
			
			
			$config['first_link'] = '&lsaquo;'.addslashes(t('First'));
            $config['last_link'] = addslashes(t('Last')).' &rsaquo;';
            //$config['first_link'] = $config['last_link'] = false;
            

            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
			
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li class="next">';
            $config['next_tag_close'] = '</li>';
            //$config['prev_tag_open'] = '<li class="previous-off">';
			$config['prev_tag_open'] = '<li class="prev">';
            $config['prev_tag_close'] = '</li>';
            $config['prev_link'] = '&laquo;'.addslashes(t("Previous"));
            $config['next_link'] = addslashes(t('Next')).'&raquo;';
			
			

            $config['cur_tag_open'] = ' <li class="active"><a href="javascript:void(0);">';
            $config['cur_tag_close'] = '</a></li>';
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
				$dir	=  ($this->i_default_language==1)?'english':'arbic';
                $lng	=	$this->lang->load('common', $dir,TRUE);
            }
            else
            {
                $lng	=	$this->lang->load('common', 'english',TRUE);
            }

            //$this->lang->line('be_invalid_connection_str')
            if(!empty($lng))
            {
                /***
                * ex- in the raw content the language key must be used like :-  ###LBL_CITY###
                */
                foreach($lng as $s_lng_key=>$s_lng_content)
                {
                    $s_locallang	=	str_replace("###".strtoupper($s_lng_key)."###",$s_lng_content,$s_locallang);
                }//end for
            }
            unset($s_raw_content,$lng);
            return $s_locallang;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }   
    }    
	
	protected function _set_translations() {
		$ci = get_instance();
		//$this->load->helper('my_language_helper');
		$this->data['current_language'] = get_current_language();
	
		if( is_readable(BASEPATH.'../'.$ci->config->item('multilanguage_object')) ) {
			$this->translation_container = unserialize(BASEPATH.'../'.$ci->config->item('multilanguage_object'));
		}
		else if( is_readable(BASEPATH.'../'.$ci->config->item('multilanguage_xml')) ) {
			$ci->load->library('multilanguage/TMXParser');
			$ci->tmxparser->setXML(BASEPATH.'../'.$ci->config->item('multilanguage_xml'));
			$ci->tmxparser->setMasterLanguage($ci->config->item('master_language'));
			$tc = $ci->tmxparser->doParse();
	
			$this->translation_container = $tc;
			
		} 
		
	}

	public function get_translations() {
		return $this->translation_container;
	}

	protected function _set_language($lang_id) 
    {
        $this->load->helper('cookie');
        $user_pref_lang_default = $this->config->item('default_language');
        $user_pref_lang_cookie = $this->input->cookie('seu_lang', TRUE);
        $user_pref_lang_session = $this->session->userdata('current_language');
        if(trim($user_pref_lang_cookie)=="")
        {
           if(trim($user_pref_lang_session)==""){
                /*default it is asper config*/
                $user_pref_lang = $user_pref_lang_default;
           } 
           else 
           {
               /*setting it is as per session*/
               $user_pref_lang = $user_pref_lang_session;
           }
            
        } 
        else 
        {
            /*setting it is as per cookie*/
            $user_pref_lang = $user_pref_lang_cookie;
        }
        $this->session->set_userdata('current_language', $user_pref_lang);           
	}	
	
	/***
    * Access checking based on user type Done Here.User type fetched from session
    */
	public function chk_access_control()
	{
        try
        {
			$this->load->model("Permission_model","mod_permit");
			//pr($this->data['admin_details']);
            if($this->data['admin_details']['e_access_type'] === 'customize')
            {
                $can_access = $this->mod_permit->can_user_access_custom(
                    $this->data['admin_loggedin']["i_id"],
                    $this->data['admin_loggedin']["i_user_type"],
                    $this->uri->uri_string()
                );
            } 
            else
            {
                $can_access = $this->mod_permit->can_user_access(
                    decrypt($this->data['admin_loggedin']["user_type_id"]),
                    $this->uri->uri_string()
                );
            }
			                           
			if(!$can_access)
			{
				throw new Exception('Public Access Restricted. <a href="'.admin_base_url()."home/".'">Please login.</a>');
			}
			else
			{
                
				//checking admin login//
				$allow = array('home', 'forgot_password','send_logged_email');
				
				if(empty($this->data['admin_loggedin']) && !in_array($this->uri->rsegment(1),$allow))
				{
					redirect(admin_base_url());
					return false; 
				}
			}
			
			//now fetching controls within the page.
			// ex. add button, edit button, delete button, etc.
            /**
            * When routes.php is used to re route some controllers.
            * Used to display in menus and access control, but in physical 
            * the controller doesnot exists. It simply redirects to other controller.
            * ex- New_customer_life_insurance controller doesnot exists, 
            *     It is redirected to Customer controller in routes.php  
            */
            $pre_route_controller = $this->uri->segment(2);
            $post_route_controller = $this->uri->rsegment(1);
			
			if($this->data['admin_details']['e_access_type'] === 'customize')
            {
                $this->data["action_allowed"] = $this->mod_permit->fetching_custom_access_control(
                    array(
                        'user_id' => $this->data['admin_details']["i_id"],
                        "i_user_type_id" => $this->data['admin_details']["i_user_type"],
                        "pre_route_controller" => $pre_route_controller,
                        "post_route_controller" => $post_route_controller
                    )
                );
            }
			else
            {
			    $this->data["action_allowed"] = $this->mod_permit->fetching_access_control(
												    array(
													    "i_user_type_id"=>decrypt($this->data['admin_loggedin']["user_type_id"]),
													    "controller"=>$pre_route_controller,
													    "alias_controller"=>$post_route_controller
												    ));
            }
			//pr($this->data["action_allowed"],1);
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }             
	}
	
	/** To store search data for jobs **/
    protected function get_session_data($key,$tmpArr=array())
    {
        $arr = $this->session->userdata('model_session');
        if(isset($arr[$key]))
            return $arr[$key];
        elseif(isset($tmpArr[$key]))
            return $tmpArr[$key];
        else
            return '';
    }
	
	
	public function _login_check($url = '')
	{
		try
		{
			if($this->data['fe_loggedin']) return true;
			if($url != '') $this->session->set_userdata('REFERER_URL', $url);
			redirect('home');// login
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	}
	
	public function _set_current_url()
	{
		$this->session->set_userdata('REFERER_URL', current_url());
	}
	
    // Set business creator data
    protected function _set_creator_data(&$posted)
    {
        $posted["i_created_by"] = decrypt($this->admin_loggedin['user_id']);
        $posted["i_role_id"] = decrypt($this->admin_loggedin['user_type_id']);
        #$posted["i_region_id"] = decrypt($this->admin_loggedin['region_id']);
        #$posted["i_franchise_id"] = decrypt($this->admin_loggedin['franchise_id']);
        $posted["s_approved_by"] = decrypt($this->admin_loggedin['user_type_id']);
        $posted["s_apply_for_approved"] = '';
        $posted["s_approved"] = $posted["i_role_id"] == 9 ? decrypt($this->admin_loggedin['user_type_id']) : '';
        $posted["dt_approved_date"] = now();
        //return $posted;
    }
    
    /*
    * Fetch all the user id list who can access the business
    * Can access business
    *   1. Own business (Added by him self)
    *   2. Business added by all of his lower level 
    */
    protected function _can_access_business()
    {
        $ret = '';
        $user_type_key = $this->admin_loggedin['user_type_key'];
        $user_type = decrypt($this->admin_loggedin['user_type_id']);
        $user_id = decrypt($this->admin_loggedin['user_id']);
        //echo 'user id=>'.$user_id.'===>user type==>'.$user_type;
        if($user_type == 7 || $user_type == 8) // Access for Franchise
        {
            $franchise_id = decrypt($this->admin_loggedin['franchise_id']);
            $region_id = decrypt($this->admin_loggedin['region_id']);
			//echo 'franchise id=>'.$franchise_id.'==>region id==>'.$region_id;
            // Find all the agent under this franchise
            $tmp = $this->acs_model->fetch_data($this->db->USERROLE, array('i_franchise_id' => $franchise_id, 'i_role_id' => 9), 'GROUP_CONCAT(i_user_id) as agent_list');
            
            $agent_list = $tmp[0]['agent_list']; 
            unset($tmp);
            if($agent_list != '')
            {
                //$agent = ' OR (n.i_created_by IN('.$agent_list.') AND (n.i_listing_status >=1 AND n.i_listing_status <= 21))';
                $agent = ' OR (n.i_created_by IN('.$agent_list.') AND (n.i_listing_status >=1))';
            }
        } 
        else if ($user_type == 5 || $user_type == 6) // Access for RD
        {
            $franchise_id = decrypt($this->admin_loggedin['franchise_id']);
            $region_id = decrypt($this->admin_loggedin['region_id']);
            
            // Fetch all the franchise and agents of this RD
            $tmp = $this->acs_model->fetch_data($this->db->USERROLE, 'i_region_id = '.$region_id.' AND i_role_id IN(9,7,8)', 'GROUP_CONCAT(i_user_id) as user_list');
            $user_list = $tmp[0]['user_list'];
            unset($tmp);
            if($user_list != '')
            {
                //$agent = ' OR (n.i_created_by IN('.$user_list.') AND (n.i_listing_status >=5 AND n.i_listing_status <= 21))';
                $agent = ' OR (n.i_created_by IN('.$user_list.') AND (n.i_listing_status >=5))';
            }
        }
        else if ($user_type == 3 || $user_type == 4) // Access for Corporate Management
        {
            //$agent = ' OR (n.i_listing_status >= 9 AND n.i_listing_status <= 21)';
            $agent = ' OR (n.i_listing_status >= 9)';
        }
        else if ($user_type == 2) // Access for Corporate Admin
        {
            //$agent = ' OR (n.i_listing_status >= 13 AND n.i_listing_status <= 21)';
            $agent = ' OR (n.i_listing_status >= 13)';
        }
        else if ($user_type == 1) // Access for Super Admin
        {
            $agent = ' OR (n.i_listing_status >= 17)';
        }
        return ' AND (( n.i_created_by = '.$user_id.' '.$agent.') OR (n.s_listing_agent_name = '.$user_id.' AND n.i_listing_status = 21))'; // Or part added because if this agent has been assign to a business then he must view the bisness after active to sell or to add buyer.
    }
    
    
    /* date 2nd Nov 2015
    * Fetch all the user id list who can access the business for report section
    * Report Can access business
    *   1. Own business (Added by him self)
    *   2. Business added by all of his lower level 
    */
    protected function _report_can_access_business()
    {
        $ret = '';
        $user_type_key = $this->admin_loggedin['user_type_key'];
        $user_type = decrypt($this->admin_loggedin['user_type_id']);
        $user_id = decrypt($this->admin_loggedin['user_id']);
        //echo 'user id=>'.$user_id.'===>user type==>'.$user_type;
        if($user_type == 7 || $user_type == 8) // Access for Franchise
        {
            $franchise_id = decrypt($this->admin_loggedin['franchise_id']);
            $region_id = decrypt($this->admin_loggedin['region_id']);
			//echo 'franchise id=>'.$franchise_id.'==>region id==>'.$region_id;
            // Find all the agent under this franchise
            $tmp = $this->acs_model->fetch_data($this->db->USERROLE, array('i_franchise_id' => $franchise_id, 'i_role_id' => 9), 'GROUP_CONCAT(i_user_id) as agent_list');
            
            $agent_list = $tmp[0]['agent_list']; 
            unset($tmp);
            if($agent_list != '')
            {
                //$agent = ' OR (n.i_created_by IN('.$agent_list.') AND (n.i_listing_status >=1 AND n.i_listing_status <= 21))';
                $agent = ' OR (n.i_created_by IN('.$agent_list.') AND (n.i_listing_status >=1))';
            }
        } 
        else if ($user_type == 5 || $user_type == 6) // Access for RD
        {
            $franchise_id = decrypt($this->admin_loggedin['franchise_id']);
            $region_id = decrypt($this->admin_loggedin['region_id']);
            
            // Fetch all the franchise and agents of this RD
            $tmp = $this->acs_model->fetch_data($this->db->USERROLE, 'i_region_id = '.$region_id.' AND i_role_id IN(9,7,8)', 'GROUP_CONCAT(i_user_id) as user_list');
            $user_list = $tmp[0]['user_list'];
            unset($tmp);
            if($user_list != '')
            {
                //$agent = ' OR (n.i_created_by IN('.$user_list.') AND (n.i_listing_status >=5 AND n.i_listing_status <= 21))';
                $agent = ' OR (n.i_created_by IN('.$user_list.') AND (n.i_listing_status >=5))';
            }
        }
        else if ($user_type == 3 || $user_type == 4) // Access for Corporate Management
        {
            //$agent = ' OR (n.i_listing_status >= 9 AND n.i_listing_status <= 21)';
            $agent = ' OR (n.i_listing_status >= 9)';
        }
        else if ($user_type == 2) // Access for Corporate Admin
        {
            //$agent = ' OR (n.i_listing_status >= 13 AND n.i_listing_status <= 21)';
            $agent = ' OR (n.i_listing_status >= 13)';
        }
        else if ($user_type == 1) // Access for Super Admin
        {
            $agent = ' OR (n.i_listing_status >= 17)';
        }
        return ' AND (( n.i_created_by = '.$user_id.' '.$agent.') OR (n.s_listing_agent_name = '.$user_id.'))'; // Or part added because if this agent has been assign to a business then he must view the bisness after active to sell or to add buyer.
    }
    
    // Get agent id list corresponding to a frenchise and its office
    private function _get_agent_id_list($region_id = 0, $user_id = 0)
    {
        $sql = "SELECT GROUP_CONCAT(i_user_id) AS created_id 
                    FROM `{$this->db->USERROLE}` 
                WHERE (i_role_id = 7 OR i_role_id = 8 OR i_role_id = 9) AND i_region_id = {$region_id} 
                AND i_franchise_id = (
                    SELECT i_franchise_id 
                        FROM `{$this->db->USERROLE}` 
                        WHERE (i_role_id = 7 OR i_role_id = 8 OR i_role_id = 9) 
                        AND i_region_id = {$region_id} AND i_user_id = {$user_id}
                        LIMIT 1
                ) AND i_user_id != {$user_id}";
        $tmp = $this->db->query($sql)->result_array();
        return $tmp[0]['created_id'];
    }
    
    // Get franchise id and agent id list corresponding to a regional developer and its office
    private function _get_franchise_agent_id_list($user_id = 0)
    {
        $sql = "SELECT GROUP_CONCAT(i_user_id) AS created_id 
                FROM `{$this->db->USERROLE}`
                WHERE i_role_id IN(6,7,9) AND i_region_id = (
                    SELECT i_region_id 
                    FROM `{$this->db->USERROLE}`
                    WHERE i_user_id = {$user_id} AND (i_role_id = 5 OR i_role_id = 6)
                ) AND i_user_id != {$user_id}";
        $tmp = $this->db->query($sql)->result_array();
        return $tmp[0]['created_id'];
    }
    
    protected function _save_action($additional_info = '', $comment = '')
    {
        $additional_info = trim($additional_info); 
        $comment = trim($comment);
        $find = array('nap','_', 'ajax');
        $replace = array(' ',' ', ' ');
        $action["i_user_id"] = intval(decrypt($this->admin_loggedin['user_id']));
        $action["i_role_id"] = intval(decrypt($this->admin_loggedin['user_type_id']));
        $action["i_region_id"] = intval(decrypt($this->admin_loggedin['region_id']));
        $action["i_franchise_id"] = intval(decrypt($this->admin_loggedin['franchise_id']));
        $action["s_name"] = $this->admin_loggedin['user_fullname'] != '' ? $this->admin_loggedin['user_fullname'] : 'Anonymous User';
        $action["s_user_name"] = $this->admin_loggedin['user_name'];
        $action["s_ip"] = $_SERVER['REMOTE_ADDR'];
        $action["i_business_id"] = intval($this->business_id);
        $action["e_business_type"] = $this->business_type;
        $action["s_comment"] = $comment != '' ? $comment : trim($this->comment);
        $action["s_additional_information"] = $additional_info != '' ? $additional_info : trim($this->additional_info);
        $action["s_action_taken"] = $this->data["title"].': '.ucwords(str_replace($find, $replace, $this->router->fetch_method()));
        $this->acs_model->add_data($this->db->ACTION_HISTORY, $action);
        unset($additional_info, $comment, $find, $replace, $action, $this->additional_info, $this->comment);
    }
    
    protected function _get_pending_business_list()
    {
        $user_type = decrypt($this->admin_loggedin['user_type_id']);
        
        if($user_type == 1 ) // Super Admin
            $where = "n.i_listing_status = 17";
        else if($user_type == 2) // Corporate Admin
            $where = "n.i_listing_status = 13";
        else if($user_type == 3 || $user_type == 4) // Corporate Management
            $where = "n.i_listing_status = 9";
        else if($user_type == 5 || $user_type == 6) // Regional Developer
            $where = "n.i_listing_status = 5";
        else if($user_type == 7 || $user_type == 8) // Franchise 
            $where = "n.i_listing_status = 1"; 
        else if($user_type == 9) // Agent
            $where = "n.i_listing_status = 0";
       
        $where .= $this->_can_access_business();
                
        $this->data['pending_business_list'] = $this->db->get_where($this->db->BUSINESS_LISTING.' AS n ',$where)->num_rows();
        $this->data['pending_me_list'] = $this->db->get_where($this->db->BUSINESS_MCIN_EQUIP.' AS n ', $where)->num_rows();
        $this->data['pending_fr_list'] = $this->db->get_where($this->db->BUSINESS_FRANCHISE.' AS n ', $where)->num_rows();
        $this->data['pending_cre_list'] = $this->db->get_where($this->db->BUSINESS_REAL_ESTATE.' AS n ', $where)->num_rows();
    }
    
    
     // get auto url from title
    public function ajax_get_url_from_title()
    {
        try
        {
            $txt    = trim($this->input->post("txt"));
            #$sugg_url = make_seo_friendly_url('mrin moy');
            $sugg_url = make_seo_friendly_url($txt);
            $res = array();
            $res['msg']     ='success';
            $res['urls']    = $sugg_url;
            echo json_encode($res);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }   


	/**@param: business id, sold date
	* function returns days on market value(sold/closed date - listing date)
	* @return json_encode($arr)
	*/
	public function ajax_get_days_on_market()
    {
        $businessId = intval($this->input->post('businessId'));
        $soldDate = $this->input->post('soldDate');
        $res = $this->acs_model->fetch_data($this->tbl, array('i_id' => $businessId), 'dt_listing_date');
        $dtListingDate = $res[0]['dt_listing_date'];
        $dom='';
        if($dtListingDate!='')
        {	
	        if($soldDate)		
	        {				
	        	$soldDate = $soldDate?$soldDate:date('Y-m-d');		
	        	$curTimestr = strtotime($soldDate);
	        	$listTimestr = strtotime($dtListingDate);
	        	$datediff = $curTimestr - $listTimestr; 
	        	if($datediff>0)
	        		$daysonmarket= floor($datediff/(60*60*24));
	        	else 
	        		$daysonmarket = '';
	        	
			}
			else
				$daysonmarket='';
		}
        $res['daysonmarket']= $daysonmarket;
        $res['msg']		= 'success';
        echo json_encode($res);
    }
    
    /* get all office under a region*/
    public function ajax_regions_franchise_AJAX()
    {
        $rID = $this->input->post('rID');
        
        $str_opt = '<option value="">Select</option>';
        if($rID)
        {
            $loggedin_data = $this->session->userdata("admin_loggedin");
            $userRole = decrypt($loggedin_data['user_type_id']);
            $logUserId = decrypt($loggedin_data['user_id']);
            $regionId = decrypt($loggedin_data['region_id']);
            $wh = " WHERE n.i_region_id='".addslashes($rID)."' ";
            if($regionId!='admin')
            {
                //$wh.= " AND n.i_user_id='".$logUserId."' ";  
            }
            $res = get_franchise_from_user_roles($wh);
            $str_opt.=$res;
        }
        echo $str_opt;
        //echo json_encode($res);
    }
    
    
    /*
    * This functions are used for ajax change of dropdowns in search form for Location & Category
    */
    
    function ajax_get_srch_city_AJAX()
    {
        $stateID = $this->input->post('stateID');
        $parent_city_option = $this->acs_model->get_city_selectlist($stateID);
           #echo   '<option value="">Select County</option>'.$parent_city_option ;
           echo   '<option value="">All Cities</option>'.$parent_city_option ;
    }
    
    function ajax_get_all_sub_category_AJAX()
    {
        $parentID = $this->input->post('parentID');
        $parent_cat_option = $this->acs_model->get_category_selectlist($parentID);
                                   
        echo  '<option value="">All Sub Categories</option>'.$parent_cat_option ;
    }
    
			
    public function __destruct()
    {
        
    } 
}
//end of class

