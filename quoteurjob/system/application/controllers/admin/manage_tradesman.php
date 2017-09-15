<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 21 Sep 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For user
* 
* @package Content Management
* @subpackage user
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/user_model.php
* @link views/admin/user/
*/


class Manage_tradesman extends My_Controller implements InfController
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
          $this->data['title']="Tradesman User Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]="No information found about tradesman.";
          $this->cls_msg["save_err"]="Information about tradesman failed to save.";
          $this->cls_msg["save_succ"]="Information about tradesman saved successfully.";
          $this->cls_msg["delete_err"]="Information about tradesman failed to remove.";
          $this->cls_msg["delete_succ"]="Information about tradesman removed successfully.";
		  $this->cls_msg["send_err"]="Message not delivered.";
          $this->cls_msg["send_succ"]="Message delivered successfully.";
		   $this->cls_msg["status_err"]="Tradesman status change failed.";
          $this->cls_msg["status_succ"]="Tradesman status changed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("manage_tradesman_model","mod_rect");
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
    public function show_list($order_name='',$order_by='asc',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Tradesman";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_email=($this->input->post("h_search")?$this->input->post("txt_email"):$this->session->userdata("txt_email")); 
			$s_user=($this->input->post("h_search")?$this->input->post("txt_user_name"):$this->session->userdata("txt_user_name"));
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_role=2 ";
            if($s_search=="basic")
            {
                $s_where.=" And n.s_username LIKE '%".get_formatted_string($s_user)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_email",$s_email);
				$this->session->set_userdata("txt_user_name",$s_user);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_email"]=$s_email;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
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
                $s_where=" WHERE n.i_role=2 ";
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
			// echo $order_name.'---';
			//  echo decrypt($order_name);
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
            $limit	= $this->i_admin_page_limit;
           //$info	= $this->mod_rect->fetch_multi($s_where,intval($start),$limit);
		    $info	= $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			//$info	= $this->mod_rect->fetch_featured_latest($s_where,$s_order_name,$order_by,intval($start),$limit);


            /////////Creating List view for displaying/////////
            $table_view=array();  
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name;         
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Tradesman";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method();  
			$table_view["detail_view"]  =FALSE;    
			
             $j_col= 0;            
            $table_view["headers"][$j_col]["width"]	="10%";
            $table_view["headers"][$j_col]["align"]	="left";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][$j_col]["val"]	="Username";
			$table_view["headers"][++$j_col]["val"]	="Name";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[1]));
			$table_view["headers"][++$j_col]["width"]	="25%";
			$table_view["headers"][$j_col]["val"]	="Address";
			//$table_view["headers"][2]["width"]	="10%";
			//$table_view["headers"][2]["val"]	="Username";
		//	$table_view["headers"][3]["width"]	="25%";
			$table_view["headers"][++$j_col]["val"]	="Email";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[3]));
			//$table_view["headers"][4]["width"]	="15%";
            $table_view["headers"][++$j_col]["val"]	="Created On"; 
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[4]));
            $table_view["headers"][++$j_col]["val"]	="Status"; 
			$table_view["headers"][++$j_col]["val"]	="Action";  
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
				//$address = "Address : ".$info[$i]["s_address"]."<br>State : ".$info[$i]["s_state"].'<br>City : '.$info[$i]["s_city"]."<br>Zipcode : ".$info[$i]["s_postal_code"];
				
				$address = '<table id="tbl_address" width="600" border="0" cellspacing="0" cellpadding="0">';	
				$address .= '<tr>';	
				$address .= 	'<td width="30%">Address</td>';
				$address .= 		'<td width="70%" >'.$info[$i]["s_address"].'</td>';
				$address .= '</tr>';	
				$address .= '<tr>';	
				$address .= 	'<td width="30%">State</td>';
				$address .= 		'<td width="70%">'.$info[$i]["s_state"].'</td>';
				$address .= '</tr>';	
				$address .= '<tr>';	
				$address .= 	'<td width="30%">City</td>';
				$address .= 		'<td width="70%">'.$info[$i]["s_city"].'</td>';
				$address .= '</tr>';
				$address .= '<tr>';	
				$address .= 	'<td width="30%">Postalcode</td>';
				$address .= 		'<td width="70%">'.$info[$i]["s_postal_code"].'</td>';
				$address .= '</tr>';				
				$address .='</table>';		
			
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_username"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_name"];
				$table_view["tablerows"][$i][$i_col++]	=$address;
				
				//$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_username"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_email"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_is_active"];
				$action = '<a href="'.admin_base_url().'manage_tradesman/send_message/'.encrypt($info[$i]["id"]).'">'.'<img src="images/admin/send.png" title="Send Message" alt="Send Message" />'.'</a>'.' <a href="'.admin_base_url().'tradesman_profile_view/index/'.encrypt($info[$i]["id"]).'">'.'<img src="images/admin/view.png" title="View" alt="View" />'.'</a>';
				if($info[$i]["i_is_active"] == 1)
				{
					$action .='<a  href="'.admin_base_url().'manage_tradesman/change_status/'.encrypt($info[$i]["id"]).'/0">
					<img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/reject.png"></a>';
				}
				else
				{
					$action .=' <a  href="'.admin_base_url().'manage_tradesman/change_status/'.encrypt($info[$i]["id"]).'/1">
					<img width="12" height="12" alt="Active" title="Active" src="images/admin/tick.png"></a>';
				}
				$table_view["tablerows"][$i][$i_col++]	= $action;

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
    {
        //echo $this->router->fetch_method();exit();
		try
        {
            $this->data['title']="Tradesman Management";////Browser Title
            $this->data['heading']="Add Tradesman";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="add";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
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
				$posted["opt_role"]		=	2;	
				
				$i_verified_val 		= trim($this->input->post("i_verified"));
                $posted["i_verified"]	= ($i_verified_val==1)?$i_verified_val:0;
				$i_active_val 			= trim($this->input->post("i_is_active"));
                $posted["i_is_active"]	= ($i_active_val==1)?$i_active_val:0;
                $posted["h_mode"]= $this->data['mode'];
                $posted["h_id"]= "";
				
				
               
                $this->form_validation->set_rules('s_username', 'username', 'required');
                $this->form_validation->set_rules('s_name', 'name', 'required');
				$this->form_validation->set_rules('s_email', 'username', 'required|valid_email');
				$this->form_validation->set_rules('s_skype_id', 'skype id', 'required');
				$this->form_validation->set_rules('s_msn_id', 'msn id', 'required');
				$this->form_validation->set_rules('s_yahoo_id', 'yahoo id', 'required');
				$this->form_validation->set_rules('s_contact_no', 'contact no', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
                    $info["s_username"]		=	$posted["s_username"];
                    $info["s_name"]			=	$posted["s_name"];
					$info["s_email"]		=	$posted["s_email"];
                    $info["s_skype_id"]		=	$posted["s_skype_id"];
					$info["s_msn_id"]		=	$posted["s_msn_id"];
                    $info["s_yahoo_id"]		=	$posted["s_yahoo_id"];
					$info["s_contact_no"]	=	$posted["s_contact_no"];
					$info["s_lat"]			=	$posted["s_lat"];
					$info["s_lng"]			=	$posted["s_lng"];
					
					$info["i_province"]		=	$posted["opt_state"];
                    $info["i_city"]			=	$posted["opt_city"];
					$info["i_zipcode"]		=	$posted["opt_zip"];
					$info["i_role"]			=	$posted["opt_role"];
					
                    $info["s_verified"]		=	$posted["i_verified"];
					$info["i_is_active"]	=	$posted["i_is_active"];
                    $info["i_created_date"]	=	strtotime(date("Y-m-d H:i:s"));
					
                    $i_newid = $this->mod_rect->add_info($info);
                    if($i_newid)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list");
                    }
                    else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    
                }
            }
            ////////////end Submitted Form///////////
			$this->data['arr_role'] = $this->db->USERROLE;
            $this->render("manage_tradesman/add-edit");
        }
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
            $this->data['title']="Edit Tradesman Details";////Browser Title
            $this->data['heading']="Edit Tradesman";
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
				//$posted["s_lat"]		=	trim($this->input->post("s_lat"));
				//$posted["s_lng"]		=	trim($this->input->post("s_lng"));	
				//$posted["opt_role"]		=	trim($this->input->post("opt_role"));	
				$posted["opt_role"]		=	2;	
				
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
                    $info["i_created_date"]	=	strtotime(date("Y-m-d H:i:s"));

                    
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
				
				//print_r($info); exit;			
                $posted=array();
				$posted["s_username"]	=	trim($info["s_username"]);
				$posted["s_name"]		=	trim($info["s_name"]);
				$posted["s_email"]		=	trim($info["s_email"]);
				$posted["s_skype_id"]	=	trim($info["s_skype_id"]);
				$posted["s_msn_id"]		=	trim($info["s_msn_id"]);
				$posted["s_yahoo_id"]	=	trim($info["s_yahoo_id"]);
				$posted["s_contact_no"]	=	trim($info["s_contact_no"]);
				$posted["s_lat"]		=	trim($info["s_lat"]);
				$posted["s_lng"]		=	trim($info["s_lng"]);
				
				$posted["opt_state"]	=	trim($info["opt_state"]);
				$posted["opt_city"]		=	encrypt(trim($info["opt_city"]));
				$posted["opt_zip"]		=	trim($info["opt_zip"]);
				
				
				$posted["i_verified"]	=	trim($info["i_verified"]);
				$posted["i_is_active"]	=	trim($info["i_is_active"]);
					
				$posted["h_id"]= $i_id;
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("manage_tradesman/add-edit");
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
        {
            $i_ret_=0;
            $pageno=$this->input->post("h_pageno");///the pagination page no, to return at the same page
            
            /////Deleting What?//////
            $s_del_these=$this->input->post("h_list");
            switch($s_del_these)
			{
				case "all":
							$i_ret_=$this->mod_rect->delete_info(-1);
							break;
				default: 		///Deleting selected,page ///
							//////First consider the posted ids, if found then take $i_id value////
							$id=(!$i_id?$this->input->post("chk_del"):$i_id);///may be an array of IDs or single id
							if(is_array($id) && !empty($id))///Deleting Multi Records
							{
							///////////Deleting Information///////
							$tot=count($id)-1;
							while($tot>=0)
							{
							$i_ret_=$this->mod_rect->delete_info(decrypt($id[$tot]));
							$tot--;
							}
							}
							elseif($id>0)///Deleting single Records
							{
							$i_ret_=$this->mod_rect->delete_info(decrypt($id));
							}                
							break;
			}
            unset($s_del_these, $id, $tot);
            
            if($i_ret_)
            {
                set_success_msg($this->cls_msg["delete_succ"]);
            }
            else
            {
                set_error_msg($this->cls_msg["delete_err"]);
            }
            redirect($this->pathtoclass."show_list".($pageno?"/".$pageno:""));
        }
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
    {
        try
        {
            if(trim($i_id)!="")
            {
                $info=$this->mod_rect->fetch_this(decrypt($i_id));

                if(!empty($info))
                {
                    $temp=array();
                    $temp["s_id"]			= 	encrypt($info["id"]);////Index 0 must be the encrypted PK 
					$temp["s_name"]			= 	trim($info["s_name"]);
					$temp["s_email"]		=	trim($info["s_email"]);
					$temp["s_skype_id"]		=	trim($info["s_skype_id"]);
					$temp["s_msn_id"]		=	trim($info["s_msn_id"]);
					$temp["s_yahoo_id"]		=	trim($info["s_yahoo_id"]);
					$temp["s_contact_no"]	=	trim($info["s_contact_no"]);
					$temp["s_lat"]			=	trim($info["s_lat"]);
					$temp["s_lng"]			=	trim($info["s_lng"]);
					$temp["s_is_active"]	= 	trim($info["s_is_active"]);
					$temp["dt_created_on"]	= 	trim($info["dt_created_on"]);

					$this->data["info"]=$temp;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            
            $this->render("manage_tradesman/show_detail",TRUE);
            unset($i_id);
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
            $posted["id"]= decrypt($this->input->post("h_id"));/*don't change*/
            $posted["duplicate_value"]= htmlspecialchars(trim($this->input->post("h_duplicate_value")),ENT_QUOTES);
            
            if($posted["duplicate_value"]!="")
            {
                $qry=" Where ".(intval($posted["id"])>0 ? " n.id!=".intval($posted["id"])." And " : "" )
                    ." n.s_email='".$posted["duplicate_value"]."'";
                $info=$this->mod_rect->fetch_multi($qry,$start,$limit); /*don't change*/
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
	
	
	public function send_message($id)
	{
		
		try
		{
			
            $this->data['title']="Tradesman Management";////Browser Title
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
					//$info = $this->mod_rect->fetch_this(decrypt($posted["h_id"]));
					$fetch = $this->mod_rect->fetch_this(decrypt($id));
					
                    $info["s_email"]	=$fetch["s_email"];
					
					$info["s_subject"] = $posted["s_subject"];
                    $info["s_content"]	=$posted["s_message"];
					$info["s_email_from"] = $this->s_admin_email;
					
					
					// Send Email starts
					$this->load->library('email');
					$config['protocol'] = 'sendmail';
					$config['mailpath'] = '/usr/sbin/sendmail';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					$config['mailtype'] = 'html';
					
					$this->email->initialize($config);
					
					 $this->email->clear();

					$this->email->to($info["s_email"]);
					$this->email->from($info["s_email_from"]);
					$this->email->subject($info["s_subject"]);
					$this->email->message($info["s_content"]);
					if(SITE_FOR_LIVE)///For live site
					{
						$i_newid = $this->email->send();
					}
					else{
						$i_newid = TRUE;				
					}
					
					// End Send Email starts
                   
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
            $this->render("manage_tradesman/send_message");
        
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	
	}
	
	
	
	/*** ajax call to get city dropdown ***/
	
	 function ajax_change_city_option()
    {
        $state_id  = decrypt($this->input->post('state_id'));
		$parent_city_option = $this->mod_rect->get_city_selectlist($state_id);
        echo '<select id="opt_city" name="opt_city" style="width:200px;" onchange="call_ajax_get_zipcode(\'ajax_change_zipcode_option\',this.value,'.$state_id.',\'parent_zip\');">
              <option>select</option>'.$parent_city_option.'</select>';
    }
	
	/*** ajax call to get zip code dropdown ***/
	function ajax_change_zipcode_option()
	{
		$state_id  = $this->input->post('state_id');
		$city_id  = decrypt($this->input->post('city_id'));
		$parent_zip_option = $this->mod_rect->get_zip_selectlist($state_id,$city_id);
		 echo '<select id="opt_zip" name="opt_zip" style="width:200px;" >
              <option>select</option>'.$parent_zip_option.'</select>';
		
	}
	 /***
    * Change status value using ajax call
    */
    public function change_status($s_id,$type)
    {
        try
        {
           
          
            
            if(decrypt($s_id)>0)
            {
                $info = array();
				
				$info['i_is_active'] = ($type==1)?1:0;
                $i_rect=$this->mod_rect->change_status($info,decrypt($s_id)); /*don't change*/
                if($i_rect)////saved successfully
				{
					$mail_send = $this->mod_rect->account_activate_deactivate(decrypt($s_id),$info);
					set_success_msg($this->cls_msg["status_succ"]);
					
				}
				else///Not saved, show the form again
				{
					set_error_msg($this->cls_msg["status_err"]);
				}
				redirect($this->pathtoclass."show_list");
                unset($info,$i_rect);
            }   
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }    
	
	public function setfeedback()
	{
		$s_where=" WHERE n.i_role=2 ";
		$info	= $this->mod_rect->fetch_multi_sorted_list($s_where,'s_username','ASC');
		$this->load->model('manage_feedback_model');
		$this->load->model('job_model');
		//pr($info);
		if(count($info)>0) {
			for($i=0; $i<count($info); $i++)
			{
				/* calcution for update tradesman details table */
			pr($info[$i]);
			/**Accepted feedback*/
			$s_where = " WHERE i_receiver_user_id =".$info[$i]['id']." AND n.i_status=1 AND cat_c.i_lang_id =1";
			$tot_accepted_feedback = $this->manage_feedback_model->gettotal_info($s_where);
			/**Total feelback*/
			$s_where = " WHERE i_receiver_user_id =".$info[$i]['id']." AND n.i_status !=0 AND cat_c.i_lang_id =1"; 
			$tot_feedback = $this->manage_feedback_model->gettotal_info($s_where);
			
			$s_where = " WHERE i_receiver_user_id =".$info[$i]['id']." AND n.i_status !=0 " ;
			$feedback_details = $this->manage_feedback_model->fetch_feedback_rating($s_where);
			$s_where = " WHERE i_receiver_user_id =".$info[$i]['id']." AND n.i_status !=0 AND n.i_positive=1" ;
			$i_positive = $this->manage_feedback_model->fetch_feedback_positive($s_where);
		//	echo $i_positive['i_positive'].'--';
			$info1 = array();
			$info1['i_feedback_rating'] = round($feedback_details['i_rating']);
			$info1['f_positive_feedback_percentage'] = ($tot_feedback!=0)?round(($i_positive['i_positive']/$tot_feedback)*100):0;
			$info1['i_jobs_won'] = $tot_accepted_feedback;
			$info1['i_feedback_received'] = $tot_feedback;
			//$table = $this->db->TRADESMANDETAILS;
			//$cond = array('i_user_id'=>$info1[$i]['id']);
			//pr($info1);
			//continue;
			if($this->manage_feedback_model->set_tradesman_update($info1,$info[$i]['id']))
			{
				echo 'sam<br>';
			}
			}
		}
	}
	
	public function __destruct()
    {}
	
	
}
?>