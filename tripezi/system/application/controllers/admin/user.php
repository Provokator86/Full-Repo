<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 04 July 2012
* Modified By: 
* Modified Date:  
* Purpose:
*  Controller For user
* @package Users
* @subpackage Manage user
* @link InfController.php 
* @link My_Controller.php
* @link model/user_model.php
* @link views/admin/user/
*/


class User extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
	public $uploaddir;
    public $showimgdir;
	public $thumbdir;
	public $thumbDisplayPath;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']			=	"User Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	=	"No information found about user.";
          $this->cls_msg["save_err"]	=	"Information about user failed to save.";
          $this->cls_msg["save_succ"]	=	"Information about user saved successfully.";
          $this->cls_msg["delete_err"]	=	"Information about user failed to remove.";
          $this->cls_msg["delete_succ"]	=	"Information about user removed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass 			= 	admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("user_model","mod_user");
		  $this->load->model("common_model","mod_common");
		  //////// end loading default model here //////////////
		  /* for uploading category icon */
		  $this->allowedExt 			= 'jpg|jpeg|png';
		  $this->user_image				= $this->config->item('user_image');
		  //pr($user_image,1);
		  
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }

    public function index()
    {
        try
        {
            redirect($this->pathtoclass."show_list");
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/****
    * Display the list of records
    * 
    */
    public function show_list($order_name='',$order_by='desc',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="User";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			$arr_session_data    =    $this->session->userdata("arr_session");
            if($arr_session_data['searching_name']!=$this->data['heading'])
            {
                $this->session->unset_userdata("arr_session");
                $arr_session_data   =   array();
            }
            
			$search_variable     =    array();
            ////////Getting Posted or session values for search///
            $s_search 	   	= (isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
			
			$search_variable["s_first_name"]= ($this->input->post("h_search")?$this->input->post("txt_first_name"):$arr_session_data["txt_first_name"]);
			 
			$search_variable["s_last_name"]	= ($this->input->post("h_search")?$this->input->post("txt_last_name"):$arr_session_data["txt_last_name"]); 
			  
			$search_variable["s_email"]		= ($this->input->post("h_search")?$this->input->post("txt_email"):$arr_session_data["txt_email"]);     
			    	
			$search_variable["dt_from"]		= ($this->input->post("h_search")?$this->input->post("txt_date_from"):$arr_session_data["txt_date_from"]); 
			
			$search_variable["dt_to"]		= ($this->input->post("h_search")?$this->input->post("txt_date_to"):$arr_session_data["txt_date_to"]);  
			
			$search_variable["opt_phone"]	= ($this->input->post("h_search")?$this->input->post("opt_phone"):$arr_session_data["opt_phone"]);       
            
			////////end Getting Posted or session values for search///
            
            $s_where=" WHERE n.i_status!=2 ";
           
            if($s_search=="advanced")
            {
				if(trim($search_variable["s_first_name"])!='')
				{
                	$s_where.=" AND n.s_first_name LIKE '%".get_formatted_string($search_variable["s_first_name"])."%' ";
				}
				if(trim($search_variable["s_last_name"])!='')
				{
                	$s_where.=" AND n.s_last_name LIKE '%".get_formatted_string($search_variable["s_last_name"])."%' ";
				}
				if(trim($search_variable["s_email"])!='')
				{
                	$s_where.=" AND n.s_email LIKE '%".get_formatted_string($search_variable["s_email"])."%' ";
				}
				if(trim($search_variable["dt_from"])!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($search_variable["dt_from"]." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.dt_created_on , '%Y-%m-%d' ) >='".$dt_start."' ";
                    unset($dt_start);
                }
				if(trim($search_variable["dt_to"])!="")
                {
                    $dt_end=date("Y-m-d",strtotime(trim($search_variable["dt_to"]." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.dt_created_on , '%Y-%m-%d' ) <='".$dt_end."' ";
                    unset($dt_end);
                }
				
				if(trim($search_variable["opt_phone"])==2)
				{
                	$s_where.=" AND n.i_phone_verified = 0 ";
				}
				if(trim($search_variable["opt_phone"])==3)
				{
                	$s_where.=" AND n.s_phone_number = '' ";
				}
				

                /////Storing search values into session///
				$arr_session	=	array();
                $arr_session["searching_name"]  = $this->data['heading'] ;  
				$arr_session["txt_first_name"]	=	$search_variable["s_first_name"];
				$arr_session["txt_last_name"]	=	$search_variable["s_last_name"];
				$arr_session["txt_email"]		=	$search_variable["s_email"];
				$arr_session["txt_date_from"]	=	$search_variable["dt_from"];
				$arr_session["txt_date_to"]		=	$search_variable["dt_to"];
				$arr_session["opt_phone"]		=	$search_variable["opt_phone"];
				
				$this->session->set_userdata('arr_session',$arr_session);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]			= $s_search;
                $this->data["txt_first_name"]	= get_unformatted_string($search_variable["s_first_name"]);  
				$this->data["txt_last_name"]	= get_unformatted_string($search_variable["s_last_name"]);
				$this->data["txt_email"]		= $search_variable["s_email"];  
				$this->data["txt_date_from"]	= $search_variable["dt_from"];
				$this->data["txt_date_to"]		= $search_variable["dt_to"];
				$this->data["opt_phone"]		= $search_variable["opt_phone"]; 
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_status!=2 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("arr_session");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]			= $s_search;
                $this->data["txt_first_name"]	= "";  
				$this->data["txt_last_name"]	= "";
				$this->data["txt_email"]		= "";  
				$this->data["txt_date_from"]	= "";
				$this->data["txt_date_to"]		= "";   
				$this->data["opt_phone"]		= "";                  
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$arr_session,$search_variable);
            ///Setting Limits, If searched then start from 0////
			$i_uri_seg =6;
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
                $start=$this->uri->segment($i_uri_seg);
            }
            ///////////end generating search query///////
			$arr_sort 		= array(0=>'n.dt_created_on'); 
			$s_order_name 	= !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];          
            $limit			= $this->i_admin_page_limit;
			$info			= $this->mod_user->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			
            /////////Creating List view for displaying/////////
            $table_view		= array();  
			$order_name 	= empty($order_name)?encrypt($arr_sort[0]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]				= "User";
            $table_view["total_rows"]			= count($info);
			$table_view["total_db_records"]		= $this->mod_user->gettotal_info($s_where);
			$table_view["order_name"]			= $order_name;
			$table_view["order_by"]  			= $order_by;
            $table_view["src_action"]			= $this->pathtoclass.$this->router->fetch_method(); 
			$table_view["detail_view"]  		= false;
                        
            $table_view["headers"][0]["width"]	= "12%";
            $table_view["headers"][0]["align"]	= "left";			
            $table_view["headers"][0]["val"]	= "First Name";
			$table_view["headers"][1]["width"]	= "12%";
			$table_view["headers"][1]["val"]	= "Last Name";
			$table_view["headers"][2]["width"]	= "23%";
			$table_view["headers"][2]["val"]	= "Email";
			$table_view["headers"][3]["width"]	= "10%";
			$table_view["headers"][3]["val"]	= "Phone";
			$table_view["headers"][4]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][4]["width"]	= "15%";
			$table_view["headers"][4]["val"]	= "Registration Date";
			$table_view["headers"][5]["width"]	= "12%";
			$table_view["headers"][5]["val"]	= "Status ";
 
			
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_first_name"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_last_name"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_email"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_phone_number"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["dt_created_on"];
                $table_view["tablerows"][$i][$i_col++]	= '<span id="status_row_id_'.encrypt($info[$i]["id"]).'">'.$info[$i]["s_status"].'</span>';
				
				$action ='';
				if($info[$i]["i_phone_verified"]==0 && $info[$i]["s_phone_number"]!='')  // if phone number is not veerified
				{
				$action .= '<a style="text-decoration:none;" href="javascript:void(0);" id="verify_phone_id_'.encrypt($info[$i]["id"]).'_verify"><img width="12" height="12" title="Verify Phone" alt="Verify Phone" src="images/admin/cellphone.png">&nbsp;</a>';
				}
				
				// details view of user
                $action .= '<a  href="javascript:void(0);" id="view_details_id_'.encrypt($info[$i]["id"]).'" class="view_details"><img width="12" height="12" title="View Details" alt="View Details" src="images/admin/view.png"></a>&nbsp;';
				
				if($this->data['action_allowed']["Status"])
                 {
					if($info[$i]["i_status"] == 1)
					{
                        $action .='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["id"]).'_inactive"><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/inactive.png"></a>';
					}
					else
					{
                       
						 $action .='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["id"]).'_active"><img width="12" height="12" alt="Active" title="Active" src="images/admin/active.png"></a>';
					}
				
				}
                if($action!='')
                {
                    $table_view["rows_action"][$i]    = $action;     
                }

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit);
            
			$this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
                        
            $this->render();          
            unset($table_view,$info,$arr_sort,$s_order_name,$order_name);
          
        }
        catch(Exception $err_obj)
        {
        	show_error($err_obj->getMessage());
        }          
    }    

    /***
    * Method to Display and Save New information
    * This have to sections: 
    *  >>Displaying Blank Form for new entry.
    *  >>Saving the new information into DB
    * After Posting the form, the posted values must be
    * shown in the form if any error occurs to avoid re-entry of the form.
    * 
    * On Success redirect to the showList interface else display error here.
    */
    public function add_information()           
    {
        //echo $this->router->fetch_method();exit();
		try
        {}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }

    /***
    * Method to Display and Save Updated information
    * This have to sections: 
    *  >>Displaying Values in Form for modifying entry.
    *  >>Saving the new information into DB    
    * After Posting the form, the posted values must be
    * shown in the form if any error occurs to avoid re-entry of the form.
    * 
    * On Success redirect to the showList interface else display error here. 
    * @param int $i_id, id of the record to be modified.
    */      
    public function modify_information($i_id=0)
    {
          
        try
        {
            $this->data['title']="Edit User Details";////Browser Title
            $this->data['heading']="Edit User";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]			= $this->data['mode'];				
                $posted["h_id"]				= trim($this->input->post("h_id"));
				
				$posted["txt_first_name"]	= trim($this->input->post("txt_first_name"));
				$posted["txt_last_name"]	= trim($this->input->post("txt_last_name"));
				$posted["txt_email"]		= trim($this->input->post("txt_email"));
				$posted["txt_phone"]		= trim($this->input->post("txt_phone"));
				$posted["txt_facebook"]		= trim($this->input->post("txt_facebook"));
				$posted["txt_twitter"]		= trim($this->input->post("txt_twitter"));
				$posted["txt_linkedin"]		= trim($this->input->post("txt_linkedin"));
				$posted["ta_about"]		    = trim($this->input->post("ta_about"));
				$posted["h_image"]			= trim($this->input->post("h_image"));
                $posted["opt_country"]      = $this->input->post("opt_country") ;
                $posted["opt_state"]        = $this->input->post("opt_state") ;
                $posted["txt_city"]         = $this->input->post("txt_city") ;
                $posted["ta_address"]       = trim($this->input->post("ta_address")) ;
                $posted["ta_paypal_details"]= trim($this->input->post("ta_paypal_details")) ;
				//pr($this->user_image,1);
				
				if(isset($_FILES['f_image']) && !empty($_FILES['f_image']['name']))
				{
				$UploadDir			= $this->user_image['general']['upload_path'];
				$newfile_name		= 'user_'.time().'.jpg';
				$img_source			= $_FILES['f_image']['tmp_name'];
				$s_uploaded_file 	= upload_image_file($img_source,$UploadDir,$newfile_name);	
				$file_to_deleted	= getFilenameWithoutExtension($posted['h_image']);
				
					   
				}
				
				//echo $newfile_name; exit;
                $this->form_validation->set_rules('txt_first_name', 'first name', 'required');
				$this->form_validation->set_rules('txt_last_name', 'last name', 'required');
                $this->form_validation->set_rules('txt_email', 'email|valid_email', 'required');
				$this->form_validation->set_rules('txt_phone', 'phone number', 'required');
				$this->form_validation->set_rules('ta_about', 'about user', 'required');
                $this->form_validation->set_rules('opt_country','country', 'required|trim');
                $this->form_validation->set_rules('opt_state','state', 'required|trim');
                $this->form_validation->set_rules('txt_city','city', 'required|trim');
                $this->form_validation->set_rules('ta_address','address', 'required|trim');

                if($this->form_validation->run() == FALSE )/////invalid
                {
					////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["s_first_name"]		= $posted["txt_first_name"];
					$info["s_last_name"]		= $posted["txt_last_name"];
					$info["s_email"]			= $posted["txt_email"];
					$info["s_phone_number"]		= $posted["txt_phone"];
					$info["s_facebook_address"]	= $posted["txt_facebook"];
					$info["s_twitter_address"]	= $posted["txt_twitter"];
					$info["s_linkedin_address"]	= $posted["txt_linkedin"];
					$info["s_about_me"]			= $posted["ta_about"];
                    $info["i_country_id"]       = decrypt($posted["opt_country"]) ;
                    $info["i_state_id"]         = decrypt($posted["opt_state"]) ;
                    $info["s_city"]             = $posted["txt_city"] ;
                    $info["s_address"]          = $posted["ta_address"] ;
                    $info["s_paypal_details"]   = $posted["ta_paypal_details"] ;
					
					$info["s_image"] 			= $newfile_name?$newfile_name:$posted['h_image'];
					
                    //print_r($info); exit;
					//pr($this->user_image,1);
                    $i_aff=$this->mod_user->edit_info_admin($info,decrypt($posted["h_id"]));
					//$i_aff = true;
                    if($i_aff)////saved successfully
                    {
						if($newfile_name)
						{
							$tmp_file			=	getFilenameWithoutExtension($newfile_name);
							$file_to_deleted	=	getFilenameWithoutExtension($posted['h_image']); // file previously uploaded
							foreach($this->user_image as $key=>$val)
							{
								if($key!='general')
								{
								$ThumbDir			= $val['upload_path'];
								$thumbfile			= $tmp_file.'_'.$key.'.jpg';
								$img_source			= $_FILES['f_image']['tmp_name'];
								$width				= $val['width'];
								$height				= $val['height'];
								$s_uploaded_file 	= upload_image_file($img_source,$ThumbDir,$thumbfile,$height,$width);
								
								}
							}
                            $i_deleted  =   delete_images_from_system('user_image',$file_to_deleted);
						
						}
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list");
                    }
                    else///Not saved, show the form again
                    {
                        $this->data["posted"]=$posted;
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    unset($info,$posted, $i_aff);
                    
                }
            }
            else
            {
                $info=$this->mod_user->fetch_this(decrypt($i_id));				
                $posted=array();	
				
				$posted["txt_first_name"]  	= $info["s_first_name"];
				$posted["txt_last_name"]  	= $info["s_last_name"];
				$posted["txt_email"]  		= $info["s_email"];
				$posted["txt_phone"]  		= $info["s_phone_number"];
				$posted["txt_facebook"]  	= $info["s_facebook_address"];
				$posted["txt_twitter"]  	= $info["s_twitter_address"];
				$posted["txt_linkedin"]  	= $info["s_linkedin_address"];
				$posted["f_image"]  		= $info["s_image"];
				$posted["ta_about"]  		= $info["s_about_me"];
                $posted["opt_country"]      = ($info['i_country_id'])?encrypt($info['i_country_id']):''; 
                $posted["opt_state"]        = ($info['i_state_id'])?encrypt($info['i_state_id']):''; 
                $posted["txt_city"]         = $info['s_city']; 
                $posted["ta_address"]       = $info['s_address']; 
				$posted["ta_paypal_details"] = $info['s_paypal_details'];
				
				$posted["h_id"]             = $i_id;
				$posted["i_id"]			    = decrypt($i_id);
                $this->data["posted"]		= $posted;    
 
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("user/add-edit");
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    

    /***
    * Method to Delete information
    * This have no interface but db operation 
    * will be done here.
    * 
    * On Success redirect to the showList interface else display error in showList interface. 
    * @param int $i_id, id of the record to be modified.
    */      
    public function remove_information($i_id=0)
    {
        try
        {}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    } 
    
    /***
    * Shows details of a single record.
    * 
    * @param int $i_id, Primary key
    */
    public function show_detail($i_id=0)
    {}
	
	public function user_details($i_id='')
    {
        try
        {
			if(decrypt($i_id))
			{
			$this->data['info'] = $this->mod_user->fetch_this(decrypt($i_id));
			$this->data['profile_image'] = getFilenameWithoutExtension($this->data['info']['s_image']);
			
			}
            //$this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_js("images/slide/jquery.ad-gallery.js");///include main css
            //$this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
           
            $this->render("user/user_details",TRUE);
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
     /***
    * Checks duplicate value using ajax call
    */
    public function ajax_checkduplicate()
    {
        try
        {
            $posted=array();
            ///is the primary key,used for checking duplicate in edit mode
            $posted["id"]				= decrypt($this->input->post("h_id"));/*don't change*/
            $posted["duplicate_value"]	= get_formatted_string($this->input->post("h_duplicate_value"));
			
						
            if($posted["duplicate_value"]!="")
            {
                $qry=" WHERE ".(intval($posted["id"])>0 ? " n.i_id!=".intval($posted["id"])." And " : "" )
                    ." n.s_email='".$posted["duplicate_value"]."' ";
                
				$info=$this->mod_user->fetch_multi($qry); /*don't change*/
				
                if(!empty($info))/////Duplicate eists
                {
                    echo "Duplicate exists";
                }
                else
                {
                    echo "valid";/*don't change*/
                }
                unset($qry,$info);
            }   
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }    
	
	/***
    * Change status of the user 
    * @author Mrinmoy 
    */
    public function ajax_change_status()
    {
        try
        {
            $posted				= array();
			$posted["id"]       = decrypt(trim($this->input->post("h_id")));
			$posted["i_status"] = trim($this->input->post("i_status"));
			//pr($posted,1);
			$info 				= array();
			//$info['i_status']   = $posted["i_status"];
			$info['i_disabled']	= $posted["i_status"];
			$arr_where          = array('i_id'=>$posted["id"]);
			$i_rect				= $this->mod_common->common_edit_info($this->db->USER,$info,$arr_where); /*don't change*/                
			if($i_rect)////saved successfully
			{
				echo "ok";                
			}
			else///Not saved, show the form again
			{
				echo "error" ;
			}
			
			unset($info,$i_rect);
              
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	
	/***
    * Change phone verified
    * @author Mrinmoy 
    */
    public function ajax_verify_phone()
    {
        try
        {
            $posted				= array();
			$posted["id"]       = decrypt(trim($this->input->post("h_id")));
			$posted["i_status"] = trim($this->input->post("i_status"));
			//pr($posted,1);
			$info 				= array();
			$info['i_phone_verified']   = $posted["i_status"];
			$arr_where          = array('i_id'=>$posted["id"]);
			$i_rect				= $this->mod_common->common_edit_info($this->db->USER,$info,$arr_where); /*don't change*/                
			if($i_rect)////saved successfully
			{
				echo "ok";                
			}
			else///Not saved, show the form again
			{
				echo "error" ;
			}
			
			unset($info,$i_rect);
              
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	
	
	/***
    * delete profile image
    * @author Mrinmoy 
    */
    public function ajax_delete_image()
    {
        try
        {
            $posted					= array();
			$posted["id"]       	= $this->input->post("h_id");
			$posted["image_name"]	= $this->input->post("image_name");
			//pr($posted,1);
			
			$info 				= array();
			$info['s_image']   	= '';
			$arr_where          = array('i_id'=>$posted["id"]);
			$i_rect				= $this->mod_common->common_edit_info($this->db->USER,$info,$arr_where); /*don't change*/
			
			$i_deleted			= delete_images_from_system('user_image',$posted["image_name"]); // delete all images from system
			          
			if($i_rect)////saved successfully
			{
				echo "ok";                
			}
			else///Not saved, show the form again
			{
				echo "error" ;
			}
			
			unset($info,$i_rect);
              
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	
	
	
	public function __destruct()
    {}
	
	
}
?>