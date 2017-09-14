<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 28 March 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For Manage Buyers
* 
* @package Content Management
* @subpackage user
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/manage_buyers_model.php
* @link views/admin/manage_buyers/
*/


class Manage_buyers extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public $uploaddir;
    public $thumbdir;
    public $showimgdir;

    public function __construct()
    {            
        try
        {
          parent::__construct();
          $this->data['title']="Buyers User Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	="No information found about buyers.";
          $this->cls_msg["save_err"]	="Information about buyers failed to save.";
          $this->cls_msg["save_succ"]	="Information about buyers saved successfully.";
          $this->cls_msg["delete_err"]	="Information about buyers failed to remove.";
          $this->cls_msg["delete_succ"]	="Information about buyers removed successfully.";
		  $this->cls_msg["send_err"]	="Message not delivered.";
          $this->cls_msg["send_succ"]	="Message delivered successfully.";
		  $this->cls_msg["status_err"]	="Buyer status change failed.";
          $this->cls_msg["status_succ"]	="Buyer status changed successfully.";
		  
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("manage_buyers_model","mod_rect");
          $this->load->model('common_model','mod_common');
		  //////// end loading default model here //////////////
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
            $this->data['heading']="Buyers";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search		=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_email		=($this->input->post("h_search")?$this->input->post("txt_email"):$this->session->userdata("txt_email")); 
			$s_user			=($this->input->post("h_search")?$this->input->post("txt_user_name"):$this->session->userdata("txt_user_name")); 
            $dt_created_on	=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_role=1 ";
            if($s_search=="advanced")
            {
                if(trim($s_user))
				{	
					$s_where.=" And n.s_username LIKE '%".get_formatted_string($s_user)."%' ";
				}
				if($s_email!="")
				{
					$s_where.=" And n.s_email LIKE '%".get_formatted_string($s_email)."%' ";
				}
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_email",$s_email);
				$this->session->set_userdata("txt_user_name",$s_user);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_email"]=$s_email;  
				$this->data["txt_user_name"]=$s_user;              
                $this->data["txt_created_on"]=$dt_created_on;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_role=1";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_email");
				$this->session->unset_userdata("txt_user_name");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_email"]="";  
				$this->data["txt_user_name"]="";               
                $this->data["txt_created_on"]="";             
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
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
             // List of fields for sorting
			$arr_sort = array(0=>'s_username',1=>'s_name',3=>'s_email',4=>'i_created_date');   
			
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[4]:$arr_sort[4];
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array();  
			$order_name = empty($order_name)?encrypt($arr_sort[4]):$order_name;           
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Buyers";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method();  
			$table_view["detail_view"]  =FALSE;   

            $j_col= 0;         
         
		  	$table_view["headers"][$j_col]["width"]	="10%";
			$table_view["headers"][$j_col]["val"]	="Username";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));

            $table_view["headers"][++$j_col]["align"]	="left";
            $table_view["headers"][$j_col]["val"]	="Name";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[1]));
			$table_view["headers"][++$j_col]["width"]	="25%";
			$table_view["headers"][$j_col]["val"]	="Address";
			$table_view["headers"][++$j_col]["width"]	="20%";
			$table_view["headers"][$j_col]["val"]	="Email";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[3]));
			$table_view["headers"][++$j_col]["width"]	="11%";
            $table_view["headers"][$j_col]["val"]	="Created On"; 
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[4]));
			$table_view["headers"][$j_col]["align"]	="center"; 
            $table_view["headers"][++$j_col]["val"]	="Status"; 
			$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="5%";
			
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
				//$address = "Address : ".$info[$i]["s_address"]."<br>State : ".$info[$i]["s_province"].'<br>City : '.$info[$i]["s_city"]."<br>Zipcode : ".$info[$i]["s_postal_code"];
				
				$address = '<table id="tbl_address" width="100%" border="0" cellspacing="0" cellpadding="0">';	
				$address .= '<tr>';	
				$address .= 	'<td width="30%">Address</td>';
				$address .= 		'<td>'.$info[$i]["s_address"].'</td>';
				$address .= '</tr>';	
				$address .= '<tr>';	
				$address .= 	'<td width="30%">Province</td>';
				$address .= 		'<td>'.$info[$i]["s_province"].'</td>';
				$address .= '</tr>';	
				$address .= '<tr>';	
				$address .= 	'<td width="30%">City</td>';
				$address .= 		'<td>'.$info[$i]["s_city"].'</td>';
				$address .= '</tr>';
				$address .= '<tr>';	
				$address .= 	'<td width="30%">Zip code</td>';
				$address .= 		'<td>'.$info[$i]["s_postal_code"].'</td>';
				$address .= '</tr>';
				
				$address .='</table>';			
		
			
                $i_col=0;
				
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_username"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_name"];
				$table_view["tablerows"][$i][$i_col++]	=$address;
				
				
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_email"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];
                $table_view["tablerows"][$i][$i_col++]	='<span id="status_row_id_'.encrypt($info[$i]["id"]).'">'.$info[$i]["s_is_active"].'</span>';
                
				$action = '<a  href="'.admin_base_url().'manage_buyers/send_message/'.encrypt($info[$i]["id"]).'">'.'<img src="images/admin/send.png" title="Send Message" alt="Send Message" />'.'</a>'.' <a  href="'.admin_base_url().'buyers_profile/index/'.encrypt($info[$i]["id"]).'">'.'<img src="images/admin/view.png" title="View" alt="View" />'.'</a>';
				if($this->data['action_allowed']["Status"])
                 {
					if($info[$i]["i_is_active"] == 1)
					{
                        $action .='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["id"]).'_inactive"><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/reject.png"></a>';
					}
					else
					{
                       
						 $action .='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["id"]).'_active"><img width="12" height="12" alt="Active" title="Active" src="images/admin/tick.png"></a>';
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
            //echo $this->data["search_action"];
            
            $this->render();          
            unset($table_view,$info);
          
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
    {}

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
            $this->data['title']="Edit Buyers Details";////Browser Title
            $this->data['heading']="Edit Buyers Details";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]= $this->data['mode'];
				$posted["s_username"]	= 	trim($this->input->post("s_username"));
				$posted["s_name"]		= 	trim($this->input->post("s_name"));
				$posted["s_email"]		= 	trim($this->input->post("s_email"));
				$posted["s_skype_id"]	= 	trim($this->input->post("s_skype_id"));
				$posted["s_msn_id"]		= 	trim($this->input->post("s_msn_id"));
				$posted["s_yahoo_id"]	= 	trim($this->input->post("s_yahoo_id"));
				$posted["s_contact_no"]	= 	trim($this->input->post("s_contact_no"));
				$posted["opt_state"]	=	trim($this->input->post("opt_state"));
				$posted["opt_city"]		=	trim($this->input->post("opt_city"));
				$posted["opt_zip"]		=	trim($this->input->post("opt_zip"));	
				$posted["s_lat"]		=	trim($this->input->post("s_lat"));
				$posted["s_lng"]		=	trim($this->input->post("s_lng"));	
				//$posted["opt_role"]		=	trim($this->input->post("opt_role"));	
				$posted["opt_role"]		=	1;	
				
				$i_verified_val 		= trim($this->input->post("i_verified"));
                $posted["i_verified"]	= ($i_verified_val==1)?$i_verified_val:0;
				$i_active_val 			= trim($this->input->post("i_is_active"));
                $posted["i_is_active"]	= ($i_active_val==1)?$i_active_val:0;
                $posted["h_id"]			= trim($this->input->post("h_id"));
				
				
                $this->form_validation->set_rules('s_username', 'username', 'required');
                $this->form_validation->set_rules('s_name', 'name', 'required');
				$this->form_validation->set_rules('s_email', 'username', 'required|valid_email');
				$this->form_validation->set_rules('s_contact_no', 'contact no', 'required');
             
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["s_username"]		=	$posted["s_username"];
                    $info["s_name"]			=	$posted["s_name"];
					$info["s_email"]		=	$posted["s_email"];
                    $info["s_skype_id"]		=	$posted["s_skype_id"];
					$info["s_msn_id"]		=	$posted["s_msn_id"];
                    $info["s_yahoo_id"]		=	$posted["s_yahoo_id"];
					$info["s_contact_no"]	=	$posted["s_contact_no"];
					//$info["s_lat"]			=	$posted["s_lat"];
					//$info["s_lng"]			=	$posted["s_lng"];
					
					$info["i_province"]		=	$posted["opt_state"];
                    $info["i_city"]			=	$posted["opt_city"];
					$info["i_zipcode"]		=	$posted["opt_zip"];
					$info["i_role"]			=	$posted["opt_role"];
					
                    $info["s_verified"]		=	$posted["i_verified"];
					$info["i_is_active"]	=	$posted["i_is_active"];
                    $info["i_edited_date"]	=	time();

                    
                    $i_aff=$this->mod_rect->edit_info($info,decrypt($posted["h_id"]));
                    if($i_aff)////saved successfully
                    {
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
                $info=$this->mod_rect->fetch_this(decrypt($i_id));	
				//echo decrypt($i_id).'<br/>';
				//pr($info,1);		
                $posted=array();
				$posted["s_username"]	=	trim($info["s_username"]);
				$posted["s_name"]		=	trim($info["s_name"]);
				$posted["s_email"]		=	trim($info["s_email"]);
				$posted["s_skype_id"]	=	trim($info["s_skype_id"]);
				$posted["s_msn_id"]		=	trim($info["s_msn_id"]);
				$posted["s_yahoo_id"]	=	trim($info["s_yahoo_id"]);
				$posted["s_contact_no"]	=	trim($info["s_contact_no"]);
				//$posted["s_lat"]		=	trim($info["s_lat"]);
				//$posted["s_lng"]		=	trim($info["s_lng"]);
				$posted["i_total_job_posted"]			=	trim($info["i_total_job_posted"]);
				$posted["i_total_job_awarded"]			=	trim($info["i_total_job_awarded"]);
				$posted["i_feedback_rating"]			=	trim($info["i_feedback_rating"]);
				$posted["f_positive_feedback_percentage"] =	trim($info["f_positive_feedback_percentage"]);
				$posted["i_feedback_received"]			=	trim($info["i_feedback_received"]);

				
				$posted["opt_state"]	=	encrypt($info["opt_province"]);
				$posted["opt_city"]		=	encrypt($info["opt_city"]);
				$posted["opt_zip"]		=	encrypt($info["opt_zip"]);
				
				
				$posted["i_verified"]	=	trim($info["i_verified"]);
				$posted["i_is_active"]	=	trim($info["i_is_active"]);
					
				$posted["h_id"]= $i_id;
				//pr($posted,1);
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                //pr($this->data["posted"],1);
            }
            ////////////end Submitted Form///////////
            $this->render("manage_buyers/add-edit");
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
    {} 
    
    /***
    * Shows details of a single record.
    * 
    * @param int $i_id, Primary key
    */
    public function show_detail($i_id=0)
    {}
    
	
	
	public function send_message($id)
	{
		try
		{
			
            $this->data['title']="Buyers Management";////Browser Title
            $this->data['heading']="Send Message";
            $this->data['pathtoclass']=$this->pathtoclass;
			$this->data['maxEmailAllowed'] = $this->config->item('max_email_allowed_in_newsletter');
            $this->data['mode']="send";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
				
                $posted["s_subject"]= trim($this->input->post("s_subject"));
				$posted["s_message"]= trim($this->input->post("s_message"));
                $posted["h_mode"]= $this->data['mode'];
                $posted["h_id"]= trim($this->input->post("h_id"));
				
                $this->form_validation->set_rules('s_subject', 'subject', 'required');
				$this->form_validation->set_rules('s_message', 'message', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
					
					$fetch = $this->mod_rect->fetch_this(decrypt($id));
					
                    $info["s_email"]	=$fetch["s_email"];					
					$info["s_subject"] = $posted["s_subject"];
                    $info["s_content"]	=$posted["s_message"];
					$info["s_email_from"] = $this->s_admin_email;	
					
					/* fetch mail body */
					$filename = $this->config->item('EMAILBODYHTML')."common.html";
					$handle = @fopen($filename, "r");
					$mail_html = @fread($handle, filesize($filename));
					
					$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
					$mail_html = str_replace("[##MAIL_BODY##]",$info["s_content"],$mail_html);
					/* end fetch mail body */
					
					/// Mailing code...[start]
					$site_admin_email = $this->s_admin_email;	
					$this->load->helper('mail');										
					$i_newid = sendMail($info["s_email"],$info["s_subject"],$mail_html);	
                    /// Mailing code...[end]
                   
                    if($i_newid)////saved successfully
                    {
                        set_success_msg($this->cls_msg["send_succ"]);
                        redirect($this->pathtoclass."show_list");
                    }
                    else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["send_err"]);
                    }
                    
                }
            }
            ////////////end Submitted Form///////////
			$this->data["h_id"]= $id;
            $this->render("manage_buyers/send_message");
        
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	}
	
    
    
     /***
    * Change status of the user 
    * @author Koushik 
    */
    public function ajax_change_status()
    {
        try
        {
            
                $posted["id"]           = decrypt(trim($this->input->post("h_id")));
                $posted["i_status"]     = trim($this->input->post("i_status"));
                $info = array();
                $info['i_is_active']    = $posted["i_status"]  ;
                $arr_where              = array('id'=>$posted["id"]);
                $i_rect=$this->mod_common->common_edit_info($this->db->MST_USER,$info,$arr_where); /*don't change*/                
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
	
	
	/*** ajax call to get province dropdown ***/
	
	function ajax_change_province_option()
    {	$this->load->model('province_model');
        $city_id  = decrypt($this->input->post('city_id'));
        $parent_province_option = $this->province_model->get_province_selectlist($city_id);
        
        echo '<select id="opt_state" name="opt_state" style="width:192px;" onchange="call_ajax_get_zipcode(\'ajax_change_zipcode_option\',this.value,'.$city_id.',\'parent_zip\');">
              <option value="">Select Province</option>'.$parent_province_option.'</select>';
	}
	
	/*** ajax call to get zip code dropdown ***/
	function ajax_change_zipcode_option()
	{
		$this->load->model('zipcode_model');
		$state_id = decrypt($this->input->post('state_id'));
		$city_id  = $this->input->post('city_id');
		$parent_zip_option = $this->zipcode_model->get_zip_selectlist($state_id,$city_id);
		echo '<select id="opt_zip" name="opt_zip" style="width:192px;" >
              <option value="">Select Zipcode</option>'.$parent_zip_option.'</select>';		
	}
	
	
	
	
	public function __destruct()
    {}
	
	
}
?>
