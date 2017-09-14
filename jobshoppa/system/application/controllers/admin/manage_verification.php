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


class Manage_verification extends My_Controller implements InfController
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
          $this->data['title']="Professional User Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]="No information found about professional.";
          $this->cls_msg["save_err"]="Information about professional failed to save.";
          $this->cls_msg["save_succ"]="Information about professional saved successfully.";
          $this->cls_msg["delete_err"]="Information about professional failed to remove.";
          $this->cls_msg["delete_succ"]="Information about professional removed successfully.";
		  $this->cls_msg["send_err"]="Message not delivered.";
          $this->cls_msg["send_succ"]="Message delivered successfully.";
		   $this->cls_msg["status_err"]="Professionals verification status change failed.";
          $this->cls_msg["status_succ"]="Professional verification status changed successfully.";
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
            redirect($this->pathtoclass."show_verification_list");
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
    {}    

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
    {}
    

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
    
	
	
	/* show verification request */
	public function show_verification_list($order_name='',$order_by='desc',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Professional Verification Request";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_email=($this->input->post("h_search")?$this->input->post("txt_email"):$this->session->userdata("txt_email")); 
			$s_user=($this->input->post("h_search")?$this->input->post("txt_user_name"):$this->session->userdata("txt_user_name"));
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE 1 ";
            if($s_search=="basic")
            {}
            elseif($s_search=="advanced")
            {
				if(trim($s_user))
				{
                	$s_where.=" And tradesman.s_username LIKE '%".get_formatted_string($s_user)."%' ";
				}
				if($s_email!="")
				{
					$s_where.=" And tradesman.s_email LIKE '%".get_formatted_string($s_email)."%' ";
				}
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.i_created_on , '%Y-%m-%d' ) ='".$dt_start."' ";
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
                $s_where=" ";
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
			$arr_sort = array(1=>'i_verifcation_status',4=>'i_created_on');   
			// echo $order_name.'---';
			//  echo decrypt($order_name);
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[4]:$arr_sort[4];
            $limit	= $this->i_admin_page_limit;
           // $info	= $this->mod_rect->fetch_multi($s_where,intval($start),$limit);
		    $info	= $this->mod_rect->fetch_multi_verification_list($s_where,$s_order_name,$order_by,intval($start),$limit);

			
            /////////Creating List view for displaying/////////
            $table_view=array();  
			$order_name = empty($order_name)?encrypt($arr_sort[4]):$order_name;         
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Professional";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_verification_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method(); 
			$table_view["detail_view"]  =FALSE;    
			
             $j_col= 0;            
            $table_view["headers"][$j_col]["width"]	="10%";
            $table_view["headers"][$j_col]["align"]	="left";
			//$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][$j_col]["val"]	="Username";
			$table_view["headers"][++$j_col]["val"]	="Name";
			//$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[1]));
			
			//$table_view["headers"][++$j_col]["width"]	="25%";
			//$table_view["headers"][$j_col]["val"]	="Address";
			
			$table_view["headers"][++$j_col]["val"]	="Email";
			//$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[3]));
			
			$table_view["headers"][++$j_col]["width"]	="25%";
			$table_view["headers"][$j_col]["val"]	="Request Type";
			//$table_view["headers"][4]["width"]	="15%";
            $table_view["headers"][++$j_col]["val"]	="Request On"; 
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[4]));
            $table_view["headers"][++$j_col]["val"]	="Status"; 
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[1]));
			$table_view["headers"][++$j_col]["val"]	="Action";  
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {	
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_username"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_name"];
				//$table_view["tablerows"][$i][$i_col++]	=$address;
				
				//$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_username"];
				
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_email"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_verify_type"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_verify_status"];
				$action = '<a href="'.admin_base_url().'verification_overview/index/'.encrypt($info[$i]["id"]).'">'.'<img src="images/admin/view.png" title="View" alt="View" />'.'</a>';
				if($info[$i]["i_verifcation_status"] == 1 && ($info[$i]["i_verify_type"]==1 || $info[$i]["i_verify_type"]==2))
				{
					$action .='<a  href="'.admin_base_url().'manage_verification/change_verification_status/'.encrypt($info[$i]["id"]).'/2/'.encrypt($info[$i]["i_verify_type"]).'/'.encrypt($info[$i]["i_user_id"]).'">
					<img width="12" height="12" title="Reject" alt="Reject" src="images/admin/reject.png"></a>';
				
					$action .=' <a  href="'.admin_base_url().'manage_verification/change_verification_status/'.encrypt($info[$i]["id"]).'/3/'.encrypt($info[$i]["i_verify_type"]).'/'.encrypt($info[$i]["i_user_id"]).'">
					<img width="12" height="12" alt="Approve" title="Approve" src="images/admin/tick.png"></a>';
				}
				$table_view["tablerows"][$i][$i_col++]	= $action;
				//$table_view["tablerows"][$i][$i_col++]	= $action;

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
    * Change status value using ajax call
    */
    public function change_verification_status($s_id,$type)
    {
        try
        {          
            
            if(decrypt($s_id)>0)
            {
                $info = array();
				
				//$info['i_is_active'] = ($type==1)?1:0;
				//echo $this->uri->segment(4).'<br>'.$this->uri->segment(5).'<br>'.$this->uri->segment(7); exit;
				$user_id = decrypt($this->uri->segment(7));
				$verify_type = decrypt($this->uri->segment(6)); 
				if($verify_type==2)
				{
					if($type==3)
					{
					$table = $this->db->TRADESMANDETAILS;
					$arr1 = array();
					$arr1['i_verify_phone'] = 1;
					$cond = array('i_user_id'=>$user_id);
					$this->mod_rect->set_data_update($table,$arr1,$cond);
					}
				}
				else if($verify_type==1)
				{
					if($type==3)
					{
					$table = $this->db->TRADESMANDETAILS;
					$arr1 = array();
					$arr1['i_verify_credentials'] = 1;
					$cond = array('i_user_id'=>$user_id);
					$this->mod_rect->set_data_update($table,$arr1,$cond);
					}
				}
				
				$info['i_is_active'] = $type;
                $i_rect=$this->mod_rect->change_verification_status($info,decrypt($s_id)); /*don't change*/
                if($i_rect)////saved successfully
				{					
					$mail_send = $this->mod_rect->verifiaction_approved_reject($user_id,$verify_type,$type);
					set_success_msg($this->cls_msg["status_succ"]);
					
				}
				else///Not saved, show the form again
				{
					set_error_msg($this->cls_msg["status_err"]);
				}
				redirect($this->pathtoclass."show_verification_list");
                unset($info,$i_rect);
            }   
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