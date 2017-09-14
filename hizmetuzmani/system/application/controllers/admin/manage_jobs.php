<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 29 March 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For manage_jobs
* 
* @package Content Management
* @subpackage user
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/job_model.php
* @link views/admin/manage_jobs/
*/


class Manage_jobs extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="Job Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	=	"No information found about Job.";
          $this->cls_msg["save_err"]	=	"Information about Job failed to save.";
          $this->cls_msg["save_succ"]	=	"Information about job saved successfully.";
          $this->cls_msg["delete_err"]	=	"Information about job failed to remove.";
          $this->cls_msg["delete_succ"]	=	"Information about job removed successfully.";
		  
		  $this->cls_msg["update_err"]	=	"Information about job failed to update.";
          $this->cls_msg["update_succ"]	=	"Information about job update successfully.";
		   $this->cls_msg["status_err"]	=	"Job status change failed.";
          $this->cls_msg["status_succ"] =    "Job status changed successfully.";

          

          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
		  
		  //////// loading default model here //////////////
		  $this->load->model('job_model','mod_job');
          
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
    public function show_list($order_name='',$order_by='DESC',$start=NULL,$limit=NULL)
    {
        try
        {
			
            $this->data['heading']="New Jobs";////Package Name[@package] Panel Heading
			$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
			$this->edit_info_link       =   'modify_information/new/';
			
            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search		=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title		=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            $dt_created_to	=($this->input->post("h_search")?$this->input->post("txt_created_to"):$this->session->userdata("txt_created_to"));
			$dt_created_on	=($this->input->post("h_search")?$this->input->post("txt_created_frm"):$this->session->userdata("txt_created_frm"));
            $s_cat			=($this->input->post("h_search")?$this->input->post("s_cat"):$this->session->userdata("s_cat")); 
			
			$opt_buyer_id	=($this->input->post("h_search")?$this->input->post("opt_buyer_id"):$this->session->userdata("opt_buyer_id")); 
			////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status=0 AND n.i_is_deleted =0 ";
			
            
            if($s_search=="advanced")
            {
				if($s_title)
				{
                	$s_where.=" And n.s_title LIKE '%".get_formatted_string($s_title)."%' ";
				}
				if($s_cat!="")
				{
					$s_where.=" And cat_c.i_cat_id=".decrypt($s_cat)." ";
				}
				
				if($opt_buyer_id!="")
				{
					$s_where.=" And n.i_buyer_user_id=".decrypt($opt_buyer_id)." ";
				}
				
                if(trim($dt_created_on)!="" && trim($dt_created_to)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
					$dt_to=date("Y-m-d",strtotime(trim($dt_created_to." "))) ;
                    $s_where.=" AND FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) BETWEEN '".$dt_start."' AND '".$dt_to."'";
                    unset($dt_start,$dt_to);
                }
				elseif(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
					
                    $s_where.=" AND FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) >='".$dt_start."'";
                    unset($dt_start);
                }
				elseif(trim($dt_created_to)!="")
                {
					$dt_to=date("Y-m-d",strtotime(trim($dt_created_to." "))) ;
                    $s_where.=" AND FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) <='".$dt_to."'";
                    unset($dt_to);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("s_title",$s_title);
				$this->session->set_userdata("s_cat",$s_cat);
				$this->session->set_userdata("opt_buyer_id",$opt_buyer_id);
                $this->session->set_userdata("txt_created_frm",$dt_created_on);
				$this->session->set_userdata("txt_created_to",$dt_created_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]=$s_title;   
				$this->data["s_cat"]=$s_cat;     
				$this->data["opt_buyer_id"]=$opt_buyer_id;                   
                $this->data["txt_created_frm"]=$dt_created_on;  
				$this->data["txt_created_to"]=$dt_created_to;                
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_status=0 AND n.i_is_deleted =0 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("s_title");
				 $this->session->unset_userdata("s_cat");
                $this->session->unset_userdata("txt_created_frm");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]="";      
				$this->data["s_cat"]="";              
                $this->data["txt_created_frm"]="";      
				$this->data["txt_created_to"]='';        
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
            ///Setting Limits, If searched then start from 0////
			$i_uri_seg = 6;
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
               $start=$this->uri->segment($i_uri_seg );
            }
            ///////////end generating search query///////
            
            // List of fields for sorting
			$arr_sort = array(0=>'s_title',2=>'i_buyer_user_id',3=>'i_category_id',6=>'i_created_date',7=>'i_expire_date');   
			
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[6]:$arr_sort[6];
			$order_name = empty($order_name)?encrypt($arr_sort[6]):$order_name;
            $limit	= $this->i_admin_page_limit;
			//echo $s_where;
            $info	= $this->mod_job->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			
            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="New Jobs";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_job->gettotal_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->data["search_action"] ;     
			$table_view["status_update"]  =FALSE; 
			$table_view["status_arr"]  =  $this->db->JOBSTATUS; 
			$table_view["detail_view"] = FALSE;
			
            $j_col=0;          
           
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][$j_col]["align"]	="left";
            $table_view["headers"][$j_col]["val"]	="Title";
			
			$table_view["headers"][++$j_col]["val"]	="Buyer";
			$table_view["headers"][$j_col]["width"]	="15%";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[2]));
			$table_view["headers"][++$j_col]["val"]	="Category";
			$table_view["headers"][$j_col]["width"]	="9%";
			
			$table_view["headers"][++$j_col]["val"]	="Detail";
			$table_view["headers"][$j_col]["width"]	="20%";
	
            $table_view["headers"][++$j_col]["val"]	="Posted Date"; 
			$table_view["headers"][$j_col]["width"]	="9%";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[6]));
            $table_view["headers"][++$j_col]["val"]	="Location"; 
			$table_view["headers"][$j_col]["width"]	="18%";

		
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
				
				$address = '<table id="tbl_address" width="100%" border="0" cellspacing="0" cellpadding="0">';	
				$address .= '<tr>';	
				$address .= 	'<td width="60%">Budget Price: </td>';
				$address .= 		'<td>'.$info[$i]["d_budget_price"].'</td>';
				$address .= '</tr>';	
				$address .= '<tr>';	
				$address .= 	'<td width="60%">Quoting Period: </td>';
				$address .= 		'<td>'.$info[$i]["i_quoting_period_days"].' Week(s)</td>';
				$address .= '</tr>';	
				$address .='</table>';
				$detail = $address;
				$address = '';
				$address = '<table id="tbl_address" width="100%" border="0" cellspacing="0" cellpadding="0">';	

				$address .= '<tr>';	
				$address .= 	'<td width="30%">Province: </td>';
				$address .= 		'<td>'.$info[$i]["s_province"].'</td>';
				$address .= '</tr>';	
				$address .= '<tr>';	
				$address .= 	'<td width="30%">City: </td>';
				$address .= 		'<td>'.$info[$i]["s_city"].'</td>';
				$address .= '</tr>';
				$address .= '<tr>';	
				$address .= 	'<td width="30%">Zip code: </td>';
				$address .= 		'<td>'.$info[$i]["s_postal_code"].'</td>';
				$address .= '</tr>';
				
				$address .='</table>';

                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_part_title"];
				
				$link = "<a alt='Click here to view profile' href='".admin_base_url().'buyers_profile/index/'.encrypt($info[$i]["i_buyer_id"])."' target='_blank'>".$info[$i]["s_buyer_name"].'</a>';
				$table_view["tablerows"][$i][$i_col++]	= $link;
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_category_name"];
				$table_view["tablerows"][$i][$i_col++]	= $detail;
						
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];
				$table_view["tablerows"][$i][$i_col++]	= $address;		
                $action   =   '';
                if($this->data['action_allowed']["Status"])
                {
				    $action  .=   ' <a onClick="javascript:jobAcceptReject(\''.encrypt($info[$i]["id"]).'\',\'approve\');"  href="javascript:void(0);"><img width="12" height="12" alt="Approve" title="Approve" src="images/admin/tick.png"></a>'.' <a  onClick="javascript:jobAcceptReject(\''.encrypt($info[$i]["id"]).'\',\'reject\');"  href="javascript:void(0);"><img width="12" height="12" alt="Reject" title="Reject" src="images/admin/reject.png"></a>';
                }
                $action .=  ' <a  href="'.admin_base_url().'job_overview/index/'.encrypt($info[$i]["id"]).'">'.'<img src="images/admin/view.png" title="View" alt="View" />'.'</a>';
			
                if($action!='')
                {
                    $table_view["rows_action"][$i]    = $action;     
                }
				

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
			$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();
           
            //echo $this->data["search_action"];
            
            $this->render();          
            unset($table_view,$info);
          
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
    public function show_active($order_name='',$order_by='DESC',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Active Jobs";////Package Name[@package] Panel Heading
			$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
			$this->edit_info_link       =   'modify_information/active/';
            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search		= (isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title		= ($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            $dt_created_to	= ($this->input->post("h_search")?$this->input->post("txt_created_to"):$this->session->userdata("txt_created_to"));
			$dt_created_on	= ($this->input->post("h_search")?$this->input->post("txt_created_frm"):$this->session->userdata("txt_created_frm"));
            $s_cat			= ($this->input->post("h_search")?$this->input->post("s_cat"):$this->session->userdata("s_cat")); 
			
			$opt_buyer_id	= ($this->input->post("h_search")?$this->input->post("opt_buyer_id"):$this->session->userdata("opt_buyer_id")); 
			$opt_status_id 	= ($this->input->post("h_search")?$this->input->post("opt_status_id"):$this->session->userdata("opt_status_id")); 
			////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE (n.i_status=1 || n.i_status=8) AND n.i_is_deleted =0 ";
			
            if($s_search=="basic")
            {
                $s_where.=" And n.s_title LIKE '%".get_formatted_string($s_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("s_title",$s_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]=$s_title;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
				if($s_title)
				{
                	$s_where.=" And n.s_title LIKE '%".get_formatted_string($s_title)."%' ";
				}
				if($s_cat!="")
				{
					$s_where.=" And cat_c.i_cat_id=".decrypt($s_cat)." ";
				}
				
				if($opt_buyer_id!="")
				{
					$s_where.=" And n.i_buyer_user_id=".decrypt($opt_buyer_id)." ";
				}
				
				if($opt_status_id!="")
				{
					$s_where.=" And n.i_status=".decrypt($opt_status_id)." ";
				}
				else
				{
					$s_where.=" And (n.i_status=1 || n.i_status=8) ";
				}
                if(trim($dt_created_on)!="" && trim($dt_created_to)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
					$dt_to=date("Y-m-d",strtotime(trim($dt_created_to." "))) ;
                    $s_where.=" AND FROM_UNIXTIME( n.i_admin_approval_date , '%Y-%m-%d' ) BETWEEN '".$dt_start."' AND '".$dt_to."'";
                    unset($dt_start,$dt_to);
                }
				elseif(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
					
                    $s_where.=" AND FROM_UNIXTIME( n.i_admin_approval_date , '%Y-%m-%d' ) >='".$dt_start."'";
                    unset($dt_start);
                }
				elseif(trim($dt_created_to)!="")
                {
					$dt_to=date("Y-m-d",strtotime(trim($dt_created_to." "))) ;
                    $s_where.=" AND FROM_UNIXTIME( n.i_admin_approval_date , '%Y-%m-%d' ) <='".$dt_to."'";
                    unset($dt_to);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("s_title",$s_title);
				$this->session->set_userdata("s_cat",$s_cat);
				$this->session->set_userdata("opt_buyer_id",$opt_buyer_id);
				$this->session->set_userdata("opt_status_id",$opt_status_id);
                $this->session->set_userdata("txt_created_frm",$dt_created_on);
				$this->session->set_userdata("txt_created_to",$dt_created_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]=$s_title;   
				$this->data["s_cat"]=$s_cat;     
				$this->data["opt_buyer_id"]=$opt_buyer_id;   
				$this->data["opt_status_id"]=$opt_status_id;                
                $this->data["txt_created_frm"]=$dt_created_on;  
				$this->data["txt_created_to"]=$dt_created_to;                
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where = " WHERE (n.i_status=1 || n.i_status=8) AND n.i_is_deleted =0 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("s_title");
				 $this->session->unset_userdata("s_cat");
                $this->session->unset_userdata("txt_created_frm");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]="";      
				$this->data["s_cat"]="";        
				$this->data["opt_buyer_id"]='';   
				$this->data["opt_status_id"]='';       
                $this->data["txt_created_frm"]="";      
				$this->data["txt_created_to"]='';        
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
            ///Setting Limits, If searched then start from 0////
			$i_uri_seg = 6;
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
			$arr_sort = array(0=>'s_title',2=>'i_buyer_user_id',3=>'i_category_id',6=>'i_admin_approval_date',7=>'i_expire_date');   
			
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[6]:$arr_sort[6];
			$order_name = empty($order_name)?encrypt($arr_sort[6]):$order_name;
            $limit	= $this->i_admin_page_limit;
			//echo $s_where;
			
			//echo $s_where; exit;
            $info	= $this->mod_job->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			
			//pr($info,1);
            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Active Jobs";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_job->gettotal_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->data["search_action"] ;     
			$table_view["status_update"]  =FALSE; 
			$table_view["status_arr"]  =  $this->db->JOBSTATUS; 
			$table_view["detail_view"] = FALSE;
			
                   $j_col = 0;     
            $table_view["headers"][$j_col]["width"]	="20%";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][$j_col]["align"]	="left";
            $table_view["headers"][$j_col]["val"]	="Title";
		
			$table_view["headers"][++$j_col]["val"]	="Buyer";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[2]));
			$table_view["headers"][++$j_col]["val"]	="Category";
			$table_view["headers"][$j_col]["width"]	="10%";
			//$table_view["headers"][3]["sort"]	= array('field_name'=>encrypt($arr_sort[3]));
			$table_view["headers"][++$j_col]["val"]	="Detail";
			$table_view["headers"][$j_col]["width"]	="20%";
	
            $table_view["headers"][++$j_col]["val"]	="Date Approved"; 
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[6]));
            $table_view["headers"][++$j_col]["val"]	="Location"; 
			$table_view["headers"][$j_col]["width"]	="20%";
 			$table_view["headers"][++$j_col]["val"]	="Quotes";
			$table_view["headers"][$j_col]["align"]	="middle";

            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
				
				$address = '<table id="tbl_address" width="100%" border="0" cellspacing="0" cellpadding="0">';	
				$address .= '<tr>';	
				$address .= 	'<td width="60%">Budget Price: </td>';
				$address .= 		'<td>'.$info[$i]["d_budget_price"].'</td>';
				$address .= '</tr>';	
				$address .= '<tr>';	
				$address .= 	'<td width="60%">Quoting Period: </td>';
				$address .= 		'<td>'.$info[$i]["i_quoting_period_days"].' Week(s)</td>';
				$address .= '</tr>';	
				$address .='</table>';
				$detail = $address;
				$address = '';
				$address = '<table id="tbl_address" width="100%" border="0" cellspacing="0" cellpadding="0">';	

				$address .= '<tr>';	
				$address .= 	'<td width="30%">Province: </td>';
				$address .= 		'<td>'.$info[$i]["s_province"].'</td>';
				$address .= '</tr>';	
				$address .= '<tr>';	
				$address .= 	'<td width="30%">City: </td>';
				$address .= 		'<td>'.$info[$i]["s_city"].'</td>';
				$address .= '</tr>';
				$address .= '<tr>';	
				$address .= 	'<td width="30%">Zip code: </td>';
				$address .= 		'<td>'.$info[$i]["s_postal_code"].'</td>';
				$address .= '</tr>';
				
				$address .='</table>';

                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                 $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_part_title"];
				//$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_part_description"];
				$link = "<a alt='Click here to view profile' href='".admin_base_url().'buyers_profile/index/'.encrypt($info[$i]["i_buyer_id"])."' target='_blank'>".$info[$i]["s_buyer_name"].'</a>';
				$table_view["tablerows"][$i][$i_col++]	= $link;
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_category_name"];
				$table_view["tablerows"][$i][$i_col++]	= $detail;
						
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_admin_approval_date"];
				$table_view["tablerows"][$i][$i_col++]	= $address;	
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_quotes"];	
				$pmb_link = admin_base_url().'manage_private_message/job_message_board/'.encrypt($info[$i]["id"]);
                $action     =   '';
				$action 	=   '<a title="History" href="javascript:void(0);" id="disp_his_'.$i.'" value="'.encrypt($info[$i]["id"]).'"><img  alt="History" src="images/admin/history.png"></a>'.' <a title="Private message board" href="'.$pmb_link.'"><img alt="Private message board" src="images/admin/pmb.png" title="Private message board"></a>'.' <a title="View" href="'.admin_base_url().'job_overview/index/'.encrypt($info[$i]["id"]).'">'.'<img src="images/admin/view.png" alt="View" title="View"/>';
				
                if($action!='')
                {
                    $table_view["rows_action"][$i]    = $action;     
                }

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
			$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();
           	$this->data['arr_status'] = array(1=>'Active',8=>'Frozen');
            //echo $this->data["search_action"];
            
            $this->render();          
            unset($table_view,$info);
          
        }
        catch(Exception $err_obj)
        {
        	show_error($err_obj->getMessage());
        }          
    }   
	
		/****
    * Display the list of completed records
    * 
    */
    public function show_complete($order_name='',$order_by='DESC',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data["action_allowed"]['Edit']   =   false;
            $this->data['heading']="Completed Jobs";////Package Name[@package] Panel Heading
			$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search		=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title		=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            $dt_created_to	=($this->input->post("h_search")?$this->input->post("txt_created_to"):$this->session->userdata("txt_created_to"));
			$dt_created_on	=($this->input->post("h_search")?$this->input->post("txt_created_frm"):$this->session->userdata("txt_created_frm"));
            $s_cat			=($this->input->post("h_search")?$this->input->post("s_cat"):$this->session->userdata("s_cat")); 
			
			$opt_buyer_id	=($this->input->post("h_search")?$this->input->post("opt_buyer_id"):$this->session->userdata("opt_buyer_id")); 
			////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status=6 AND n.i_is_deleted =0 ";
			
            if($s_search=="advanced")
            {
				if($s_title)
				{
                	$s_where.=" And n.s_title LIKE '%".get_formatted_string($s_title)."%' ";
				}
				if($s_cat!="")
				{
					$s_where.=" And cat_c.i_cat_id=".decrypt($s_cat)." ";
				}
				
				if($opt_buyer_id!="")
				{
					$s_where.=" And n.i_buyer_user_id=".decrypt($opt_buyer_id)." ";
				}
				
                if(trim($dt_created_on)!="" && trim($dt_created_to)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
					$dt_to=date("Y-m-d",strtotime(trim($dt_created_to." "))) ;
                    $s_where.=" AND FROM_UNIXTIME( n.i_completed_date , '%Y-%m-%d' ) BETWEEN '".$dt_start."' AND '".$dt_to."'";
                    unset($dt_start,$dt_to);
                }
				elseif(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
					
                    $s_where.=" AND FROM_UNIXTIME( n.i_completed_date , '%Y-%m-%d' ) >='".$dt_start."'";
                    unset($dt_start);
                }
				elseif(trim($dt_created_to)!="")
                {
					$dt_to=date("Y-m-d",strtotime(trim($dt_created_to." "))) ;
                    $s_where.=" AND FROM_UNIXTIME( n.i_completed_date , '%Y-%m-%d' ) <='".$dt_to."'";
                    unset($dt_to);
                }
              
                /////Storing search values into session///
                $this->session->set_userdata("s_title",$s_title);
				$this->session->set_userdata("s_cat",$s_cat);
				$this->session->set_userdata("opt_buyer_id",$opt_buyer_id);
                $this->session->set_userdata("txt_created_frm",$dt_created_on);
				$this->session->set_userdata("txt_created_to",$dt_created_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]=$s_title;   
				$this->data["s_cat"]=$s_cat;     
				$this->data["opt_buyer_id"]=$opt_buyer_id;                   
                $this->data["txt_created_frm"]=$dt_created_on;  
				$this->data["txt_created_to"]=$dt_created_to;                
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_status=6 AND n.i_is_deleted =0 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("s_title");
				 $this->session->unset_userdata("s_cat");
                $this->session->unset_userdata("txt_created_frm");
                $this->session->unset_userdata("h_search");
				$this->session->unset_userdata("opt_buyer_id");
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]="";      
				$this->data["s_cat"]="";              
                $this->data["txt_created_frm"]="";      
				$this->data["txt_created_to"]='';    
				$this->data["opt_buyer_id"]='';    
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
            ///Setting Limits, If searched then start from 0////
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
                $start=$this->uri->segment($this->i_uri_seg);
            }
            ///////////end generating search query///////
            
            // List of fields for sorting
			$arr_sort = array(0=>'s_title',2=>'i_buyer_user_id',3=>'i_category_id',6=>'i_completed_date',7=>'i_expire_date');   
			
            $s_order_name 	= !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
			$order_name 	= empty($order_name)?encrypt($arr_sort[0]):$order_name;
            $limit			= $this->i_admin_page_limit;
			
            $info	= $this->mod_job->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			
            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Completed Jobs";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_job->gettotal_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->data["search_action"] ;     
			$table_view["status_update"]  =FALSE; 
			$table_view["status_arr"]  =  $this->db->JOBSTATUS; 
			$table_view["detail_view"] = FALSE;
			
            $j_col = 0; 
           
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][$j_col]["align"]	="left";
            $table_view["headers"][$j_col]["val"]	="Title";
		
			$table_view["headers"][++$j_col]["val"]	="Buyer";
			$table_view["headers"][$j_col]["width"]	="13%";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[2]));
			$table_view["headers"][++$j_col]["val"]	="Category";
			$table_view["headers"][$j_col]["width"]	="10%";
			
			$table_view["headers"][++$j_col]["val"]	="Detail";
			$table_view["headers"][$j_col]["width"]	="20%";
	
            $table_view["headers"][++$j_col]["val"]	="Posted Date"; 
			$table_view["headers"][$j_col]["width"]	="10%";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[6]));
            $table_view["headers"][++$j_col]["val"]	="Location"; 
			$table_view["headers"][$j_col]["width"]	="18%";
			
			
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
				
				$address = '<table id="tbl_address" width="100%" border="0" cellspacing="0" cellpadding="0">';	
				$address .= '<tr>';	
				$address .= 	'<td width="60%">Budget Price: </td>';
				$address .= 		'<td>'.$info[$i]["d_budget_price"].'</td>';
				$address .= '</tr>';	
				$address .= '<tr>';	
				$address .= 	'<td width="60%">Quoting Period: </td>';
				$address .= 		'<td>'.$info[$i]["i_quoting_period_days"].' Week(s)</td>';
				$address .= '</tr>';	
				$address .='</table>';
				$detail = $address;
				$address = '';
				$address = '<table id="tbl_address" width="100%" border="0" cellspacing="0" cellpadding="0">';	

				$address .= '<tr>';	
				$address .= 	'<td width="30%">Province: </td>';
				$address .= 		'<td>'.$info[$i]["s_province"].'</td>';
				$address .= '</tr>';	
				$address .= '<tr>';	
				$address .= 	'<td width="30%">City: </td>';
				$address .= 		'<td>'.$info[$i]["s_city"].'</td>';
				$address .= '</tr>';
				$address .= '<tr>';	
				$address .= 	'<td width="30%">Zip code: </td>';
				$address .= 		'<td>'.$info[$i]["s_postal_code"].'</td>';
				$address .= '</tr>';
				
				$address .='</table>';

                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_part_title"];
				
				$link = "<a alt='Click here to view profile' href='".admin_base_url().'buyers_profile/index/'.encrypt($info[$i]["i_buyer_id"])."' target='_blank'>".$info[$i]["s_buyer_name"].'</a>';
				$table_view["tablerows"][$i][$i_col++]	= $link;
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_category_name"];
				$table_view["tablerows"][$i][$i_col++]	= $detail;
						
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];
				$table_view["tablerows"][$i][$i_col++]	= $address;		
				$pmb_link = admin_base_url().'manage_private_message/job_message_board/'.encrypt($info[$i]["id"]);
                $action     =   '';
				$action	    =   '<a title="History" href="javascript:void(0);" id="disp_his_'.$i.'" value="'.encrypt($info[$i]["id"]).'"><img  alt="History" src="images/admin/history.png"></a>'.' <a title="Private message board" href="'.$pmb_link.'"><img alt="Private message board" src="images/admin/pmb.png"></a>'.' <a title="View" href="'.admin_base_url().'job_overview/index/'.encrypt($info[$i]["id"]).'">'.'<img src="images/admin/view.png" alt="View" />'.'</a>';
				
                if($action!='')
                {
                    $table_view["rows_action"][$i]    = $action;     
                }

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
			$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();
         
            $this->render();          
            unset($table_view,$info);
          
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
    public function show_in_progress($order_name='',$order_by='DESC',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data["action_allowed"]['Edit']   =   false;
            $this->data['heading']="In Progress Jobs";////Package Name[@package] Panel Heading
			$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search		=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title		=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            $dt_created_to	=($this->input->post("h_search")?$this->input->post("txt_created_to"):$this->session->userdata("txt_created_to"));
			$dt_created_on	=($this->input->post("h_search")?$this->input->post("txt_created_frm"):$this->session->userdata("txt_created_frm"));
            $s_cat			=($this->input->post("h_search")?$this->input->post("s_cat"):$this->session->userdata("s_cat")); 
			
			$opt_buyer_id	=($this->input->post("h_search")?$this->input->post("opt_buyer_id"):$this->session->userdata("opt_buyer_id")); 
			$opt_status_id 	= ($this->input->post("h_search")?$this->input->post("opt_status_id"):$this->session->userdata("opt_status_id")); 
			////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE  n.i_is_deleted =0 ";
			
            if($s_search=="basic")
            {
                $s_where.=" And n.s_title LIKE '%".get_formatted_string($s_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("s_title",$s_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]=$s_title;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
				if($s_title)
				{
                	$s_where.=" And n.s_title LIKE '%".get_formatted_string($s_title)."%' ";
				}
				if($s_cat!="")
				{
					$s_where.=" And cat_c.i_cat_id=".decrypt($s_cat)." ";
				}
				
				if($opt_buyer_id!="")
				{
					$s_where.=" And n.i_buyer_user_id=".decrypt($opt_buyer_id)." ";
				}
				
				if($opt_status_id!="")
				{
					$s_where.=" And n.i_status=".decrypt($opt_status_id)." ";
				}
				else
				{
					$s_where.=" And (n.i_status=4 || n.i_status=5 || n.i_status=11 || n.i_status=8) ";
				}
                if(trim($dt_created_on)!="" && trim($dt_created_to)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
					$dt_to=date("Y-m-d",strtotime(trim($dt_created_to." "))) ;
                    $s_where.=" AND FROM_UNIXTIME( n.i_admin_approval_date , '%Y-%m-%d' ) BETWEEN '".$dt_start."' AND '".$dt_to."'";
                    unset($dt_start,$dt_to);
                }
				elseif(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
					
                    $s_where.=" AND FROM_UNIXTIME( n.i_admin_approval_date , '%Y-%m-%d' ) >='".$dt_start."'";
                    unset($dt_start);
                }
				elseif(trim($dt_created_to)!="")
                {
					$dt_to=date("Y-m-d",strtotime(trim($dt_created_to." "))) ;
                    $s_where.=" AND FROM_UNIXTIME( n.i_admin_approval_date , '%Y-%m-%d' ) <='".$dt_to."'";
                    unset($dt_to);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("s_title",$s_title);
				$this->session->set_userdata("s_cat",$s_cat);
				$this->session->set_userdata("opt_buyer_id",$opt_buyer_id);
				$this->session->set_userdata("opt_status_id",$opt_status_id);
                $this->session->set_userdata("txt_created_frm",$dt_created_on);
				$this->session->set_userdata("txt_created_to",$dt_created_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]=$s_title;   
				$this->data["s_cat"]=$s_cat;     
				$this->data["opt_buyer_id"]=$opt_buyer_id;   
				$this->data["opt_status_id"]=$opt_status_id;                
                $this->data["txt_created_frm"]=$dt_created_on;  
				$this->data["txt_created_to"]=$dt_created_to;                
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where = " WHERE (n.i_status=4 || n.i_status=5 || n.i_status=11 || n.i_status=8) AND n.i_is_deleted =0 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("s_title");
				$this->session->unset_userdata("s_cat");
				$this->session->unset_userdata("opt_buyer_id");
				$this->session->unset_userdata("opt_status_id");
                $this->session->unset_userdata("txt_created_frm");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]="";      
				$this->data["s_cat"]="";        
				$this->data["opt_buyer_id"]='';   
				$this->data["opt_status_id"]='';       
                $this->data["txt_created_frm"]="";      
				$this->data["txt_created_to"]='';        
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
            ///Setting Limits, If searched then start from 0////
			$i_uri_seg = 6;
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
			$arr_sort = array(0=>'s_title',2=>'i_buyer_user_id',3=>'i_category_id',6=>'i_admin_approval_date',7=>'i_expire_date');   
			// echo $order_name.'---';
			//  echo decrypt($order_name);
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[6]:$arr_sort[6];
			$order_name = empty($order_name)?encrypt($arr_sort[6]):$order_name;
            $limit	= $this->i_admin_page_limit;
			//echo $s_where;
            $info	= $this->mod_job->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			
			
			//print_r($info);
            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="In Progress Jobs";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_job->gettotal_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->data["search_action"] ;     
			$table_view["status_update"]  =FALSE; 
			$table_view["status_arr"]  =  $this->db->JOBSTATUS; 
			$table_view["detail_view"] = FALSE;
			
                        $j_col=0;
           // $table_view["headers"][$j_col]["width"]	="20%";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][$j_col]["align"]	="left";
            $table_view["headers"][$j_col]["val"]	="Title";
		
			$table_view["headers"][++$j_col]["val"]	="Buyer";
			$table_view["headers"][$j_col]["width"]	="12%";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[2]));
			$table_view["headers"][++$j_col]["val"]	="Tradesman";
			$table_view["headers"][$j_col]["width"]	="12%";
			$table_view["headers"][++$j_col]["val"]	="Category";
			$table_view["headers"][$j_col]["width"]	="10%";
			
			$table_view["headers"][++$j_col]["val"]	="Detail";
			$table_view["headers"][$j_col]["width"]	="20%";
	
            $table_view["headers"][++$j_col]["val"]	="Date Approved"; 
			$table_view["headers"][$j_col]["width"]	="10%";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[6]));
            $table_view["headers"][++$j_col]["val"]	="Location"; 
			$table_view["headers"][$j_col]["width"]	="18%";
 			$table_view["headers"][++$j_col]["val"]	="Quotes";
			$table_view["headers"][$j_col]["width"]	="5%";
			$table_view["headers"][$j_col]["align"]	="middle";
			
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
				
				$address = '<table id="tbl_address" width="100%" border="0" cellspacing="0" cellpadding="0">';	
				$address .= '<tr>';	
				$address .= 	'<td width="60%">Budget Price: </td>';
				$address .= 		'<td>'.$info[$i]["d_budget_price"].'</td>';
				$address .= '</tr>';	
				$address .= '<tr>';	
				$address .= 	'<td width="60%">Quoting Period: </td>';
				$address .= 		'<td>'.$info[$i]["i_quoting_period_days"].' Week(s)</td>';
				$address .= '</tr>';	
				$address .='</table>';
				$detail = $address;
				$address = '';
				$address = '<table id="tbl_address" width="100%" border="0" cellspacing="0" cellpadding="0">';	

				$address .= '<tr>';	
				$address .= 	'<td width="30%">Province: </td>';
				$address .= 		'<td>'.$info[$i]["s_province"].'</td>';
				$address .= '</tr>';	
				$address .= '<tr>';	
				$address .= 	'<td width="30%">City: </td>';
				$address .= 		'<td>'.$info[$i]["s_city"].'</td>';
				$address .= '</tr>';
				$address .= '<tr>';	
				$address .= 	'<td width="30%">Zip code: </td>';
				$address .= 		'<td>'.$info[$i]["s_postal_code"].'</td>';
				$address .= '</tr>';
				
				$address .='</table>';

                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
               $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_part_title"];
			//	$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_part_description"];
				$link = "<a alt='Click here to view profile' href='".admin_base_url().'buyers_profile/index/'.encrypt($info[$i]["i_buyer_id"])."' target='_blank'>".$info[$i]["s_buyer_name"].'</a>';
				$table_view["tablerows"][$i][$i_col++]	= $link;
				$link2 = "<a alt='Click here to view profile' href='".admin_base_url().'tradesman_profile_view/index/'.encrypt($info[$i]["i_tradesman_id"])."' target='_blank'>".$info[$i]["s_tradesman_name"].'</a>';
				$table_view["tablerows"][$i][$i_col++]	= $link2;
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_category_name"];
				$table_view["tablerows"][$i][$i_col++]	= $detail;
						
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_admin_approval_date"];
				$table_view["tablerows"][$i][$i_col++]	= $address;	
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_quotes"];	
				$pmb_link = admin_base_url().'manage_private_message/job_message_board/'.encrypt($info[$i]["id"]);
                $action =   '';
				$action =   '<a title="History" href="javascript:void(0);" id="disp_his_'.$i.'" value="'.encrypt($info[$i]["id"]).'"><img  alt="History" src="images/admin/history.png"></a>'.' <a title="Private message board" href="'.$pmb_link.'"><img alt="Private message board" src="images/admin/pmb.png"></a>'.' <a title="View" href="'.admin_base_url().'job_overview/index/'.encrypt($info[$i]["id"]).'">'.'<img src="images/admin/view.png" alt="View" />'.'</a>';
				
                if($action!='')
                {
                    $table_view["rows_action"][$i]    = $action;     
                }

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
			$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();
           	$this->data['arr_status'] = array(4=>'In Progress',5=>'Feedback Asked',11=>'Pending');
            //echo $this->data["search_action"];
            
            $this->render();          
            unset($table_view,$info);
          
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
    public function show_all($order_name='',$order_by='DESC',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data["action_allowed"]['Edit']   =   false;
            $this->data['heading']="All Jobs";////Package Name[@package] Panel Heading
			$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search		=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title		=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            $dt_created_to	=($this->input->post("h_search")?$this->input->post("txt_created_to"):$this->session->userdata("txt_created_to"));
			$dt_created_on	=($this->input->post("h_search")?$this->input->post("txt_created_frm"):$this->session->userdata("txt_created_frm"));
            $s_cat			=($this->input->post("h_search")?$this->input->post("s_cat"):$this->session->userdata("s_cat")); 
			
			$opt_buyer_id	=($this->input->post("h_search")?$this->input->post("opt_buyer_id"):$this->session->userdata("opt_buyer_id")); 
			$opt_status_id	=($this->input->post("h_search")?$this->input->post("opt_status_id"):$this->session->userdata("opt_status_id")); 
			////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE  n.i_is_deleted =0 ";
			
           if($s_search=="advanced")
            {
				if($s_title)
				{
                	$s_where.=" And n.s_title LIKE '%".get_formatted_string($s_title)."%' ";
				}
				if($s_cat!="")
				{
					$s_where.=" And cat_c.i_cat_id=".decrypt($s_cat)." ";
				}
				if($opt_status_id!="")
				{
					$s_where.=" And n.i_status=".decrypt($opt_status_id)." ";
				}
				if($opt_buyer_id!="")
				{
					$s_where.=" And n.i_buyer_user_id=".decrypt($opt_buyer_id)." ";
				}
				
                if(trim($dt_created_on)!="" && trim($dt_created_to)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
					$dt_to=date("Y-m-d",strtotime(trim($dt_created_to." "))) ;
                    $s_where.=" AND FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) BETWEEN '".$dt_start."' AND '".$dt_to."'";
                    unset($dt_start,$dt_to);
                }
				elseif(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
					
                    $s_where.=" AND FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) >='".$dt_start."'";
                    unset($dt_start);
                }
				elseif(trim($dt_created_to)!="")
                {
					$dt_to=date("Y-m-d",strtotime(trim($dt_created_to." "))) ;
                    $s_where.=" AND FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) <='".$dt_to."'";
                    unset($dt_to);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("s_title",$s_title);
				$this->session->set_userdata("s_cat",$s_cat);
				$this->session->set_userdata("opt_buyer_id",$opt_buyer_id);
                $this->session->set_userdata("txt_created_frm",$dt_created_on);
				$this->session->set_userdata("txt_created_to",$dt_created_to);
				$this->session->set_userdata("opt_status_id",$opt_status_id);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]=$s_title;   
				$this->data["s_cat"]=$s_cat;     
				$this->data["opt_buyer_id"]=$opt_buyer_id;                   
                $this->data["txt_created_frm"]=$dt_created_on;  
				$this->data["txt_created_to"]=$dt_created_to;   
				$this->data["opt_status_id"]=$opt_status_id;                 
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
               $s_where=" WHERE  n.i_is_deleted =0 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("s_title");
				 $this->session->unset_userdata("s_cat");
                $this->session->unset_userdata("txt_created_frm");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]="";      
				$this->data["s_cat"]="";              
                $this->data["txt_created_frm"]="";      
				$this->data["txt_created_to"]='';        
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
            ///Setting Limits, If searched then start from 0////
			$i_uri_seg = 6;
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
               $start=$this->uri->segment($i_uri_seg );
            }
            ///////////end generating search query///////
            
            // List of fields for sorting
			$arr_sort = array(0=>'s_title',2=>'i_buyer_user_id',3=>'i_category_id',6=>'i_created_date',7=>'i_expire_date');   
			
            $s_order_name 	= !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[6]:$arr_sort[6];
			$order_name 	= empty($order_name)?encrypt($arr_sort[6]):$order_name;
            $limit			= $this->i_admin_page_limit;
			
            $info	= $this->mod_job->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			
            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="New Jobs";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_job->gettotal_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->data["search_action"] ;     
			$table_view["status_update"]  =FALSE; 
			$table_view["status_arr"]  =  $this->db->JOBSTATUS; 
			$table_view["detail_view"] = FALSE;
            $j_col=0;           
           
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][$j_col]["align"]	="left";
            $table_view["headers"][$j_col]["val"]	="Title";
			$table_view["headers"][++$j_col]["val"]	="Buyer";
			$table_view["headers"][$j_col]["width"]	="12%";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[2]));
			$table_view["headers"][++$j_col]["val"]	="Category";
			$table_view["headers"][$j_col]["width"]	="12%";
			$table_view["headers"][++$j_col]["val"]	="Detail";
			$table_view["headers"][$j_col]["width"]	="20%";
            $table_view["headers"][++$j_col]["val"]	="Posted Date"; 
			$table_view["headers"][$j_col]["width"]	="10%";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[6]));
            $table_view["headers"][++$j_col]["val"]	="Location"; 
			$table_view["headers"][$j_col]["width"]	="18%";

            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
				
				$address = '<table id="tbl_address" width="100%" border="0" cellspacing="0" cellpadding="0">';	
				$address .= '<tr>';	
				$address .= 	'<td width="60%">Budget Price: </td>';
				$address .= 		'<td>'.$info[$i]["d_budget_price"].'</td>';
				$address .= '</tr>';	
				$address .= '<tr>';	
				$address .= 	'<td width="60%">Quoting Period: </td>';
				$address .= 		'<td>'.$info[$i]["i_quoting_period_days"].' Week(s)</td>';
				$address .= '</tr>';	
				$address .= '<tr>';	
				$address .= 	'<td width="60%">Status: </td>';
				$address .= 		'<td>'.$info[$i]["s_is_active"].'</td>';
				$address .= '</tr>';	
				$address .='</table>';
				$detail = $address;
				$address = '';
				$address = '<table id="tbl_address" width="100%" border="0" cellspacing="0" cellpadding="0">';	

				$address .= '<tr>';	
				$address .= 	'<td width="30%">Province: </td>';
				$address .= 		'<td>'.$info[$i]["s_province"].'</td>';
				$address .= '</tr>';	
				$address .= '<tr>';	
				$address .= 	'<td width="30%">City: </td>';
				$address .= 		'<td>'.$info[$i]["s_city"].'</td>';
				$address .= '</tr>';
				$address .= '<tr>';	
				$address .= 	'<td width="30%">Zip code: </td>';
				$address .= 		'<td>'.$info[$i]["s_postal_code"].'</td>';
				$address .= '</tr>';
				
				$address .='</table>';

                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_part_title"];
				
				$link = "<a alt='Click here to view profile' href='".admin_base_url().'buyers_profile/index/'.encrypt($info[$i]["i_buyer_id"])."' target='_blank'>".$info[$i]["s_buyer_name"].'</a>';
				$table_view["tablerows"][$i][$i_col++]	= $link;
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_category_name"];
				$table_view["tablerows"][$i][$i_col++]	= $detail;
						
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];
				$table_view["tablerows"][$i][$i_col++]	= $address;		
             
			 	$pmb_link = admin_base_url().'manage_private_message/job_message_board/'.encrypt($info[$i]["id"]);
                $action   = '';
				$action	= ' <a title="View" href="'.admin_base_url().'job_overview/index/'.encrypt($info[$i]["id"]).'">'.'<img src="images/admin/view.png" alt="View" />'.'</a>'.' <a title="Private message board" href="'.$pmb_link.'"><img alt="Private message board" src="images/admin/pmb.png"></a>';
			    
                if($action!='')
                {
                    $table_view["rows_action"][$i]    = $action;     
                }
				

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
			$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();
            $this->data['arr_status'] = $this->db->JOBSTATUS;
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
    public function modify_information($type='',$i_id=0)
    {
          
        try
        {
            $this->data['title']="Edit Job Details";////Browser Title
            $this->data['heading']="Edit Job";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";
			$this->data['type']=$type;
			//echo encrypt('new');
			
            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]= $this->data['mode'];
				
				//$posted["i_is_active"]				=	trim($this->input->post("i_is_active"));
				$posted["s_title"]					=	trim($this->input->post("s_title"));
				$posted["s_description"]			=	trim($this->input->post("s_description"));
				//$posted["i_quoting_period_days"]	=	trim($this->input->post("i_quoting_period_days"));
				$posted["s_keyword"]				=	trim($this->input->post("s_keyword"));
                $posted["h_id"]						=   trim($this->input->post("h_id"));
				
				
                
				$this->form_validation->set_rules('s_title', 'title', 'required');
				$this->form_validation->set_rules('s_description', 'description', 'required');
				$this->form_validation->set_rules('s_keyword', 'keyword', 'required');
             
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					
					$info["s_title"]				=	$posted["s_title"];
					$info["s_description"]			=	$posted["s_description"];
					//$info["i_quoting_period_days"]	=	intval($posted["i_quoting_period_days"]);
					$info["s_keyword"]				=	$posted["s_keyword"];					
					//$info["i_is_active"]			=	1;					
											
					//print_r($info); echo '<br/>'.$type; exit;
                    
                    $i_aff=$this->mod_job->edit_info($info,decrypt($posted["h_id"]));
                    if($i_aff)////saved successfully
                    {
						
                        set_success_msg($this->cls_msg["save_succ"]);
						if($type=='new')
						{
                        redirect($this->pathtoclass."show_list");
						}
						if($type=='active')
						{
                        redirect($this->pathtoclass."show_active");
						}
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
				//echo decrypt($i_id);
                $info=$this->mod_job->fetch_this(decrypt($i_id));	
						
                $posted=array();
				$posted["s_title"]				=	trim($info["s_title"]);
				$posted["s_description"]		=	trim($info["s_description"]);
				//$posted["s_buyer_name"]			=	trim($info["s_buyer_name"]);				
				//$posted["s_contact_no"]			=	trim($info["s_contact_no"]);				
				//$posted["opt_state"]			=	trim($info["opt_state"]);
				//$posted["opt_city"]				=	trim($info["opt_city"]);
				//$posted["opt_zip"]				=	trim($info["opt_zip"]);					
				$posted["d_budget_price"]		=	trim($info["d_budget_price"]);
				$posted["i_quoting_period_days"]=	trim($info["i_quoting_period_days"]);
				$posted["s_keyword"]			=	trim($info["s_keyword"]);
				
				$posted["i_supply_material"]	=	trim($info["i_supply_material"]);
				$posted["i_is_active"]			=	encrypt(trim($info["i_is_active"]));
				
				//print_r($posted); exit;
					
				$posted["h_id"]= $i_id;
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
			$this->data['arr_status'] = $this->db->JOBSTATUS;
            $this->render("manage_jobs/add-edit");
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
							$i_ret_=$this->mod_job->delete_info(-1);
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
							$i_ret_=$this->mod_job->delete_info(decrypt($id[$tot]));
							$tot--;
							}
							}
							elseif($id>0)///Deleting single Records
							{
							$i_ret_=$this->mod_job->delete_info(decrypt($id));
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
	
	
	
    
    /**
    * this ajax function is for job accept reject
    * 
    */
    public function ajax_approve_reject()
    {
        try
        {
            $id           =   trim($this->input->post('i_id'));
            $i_status     =   intval($this->input->post('i_status'));
            
            $i_ret_       = $this->mod_job->update_status(decrypt($id),$i_status);
			$job_details  = $this->mod_job->fetch_this(decrypt($id));
			
			if($i_status==1) // Active
			{
				$s_message = 'job_approved';
				$s_status = 'Active';
				$this->mod_job->update_buyer_posted_job($job_details['i_buyer_user_id']);
			}
			else
			{
				$s_message = 'job_rejected';
				$s_status = 'Rejected';
			}
			
			/* change job history table and job status*/
			$arr1 = array();
			$arr1['i_job_id'] =  decrypt($id);
			$arr1['i_user_id'] =  0;
			$arr1['s_message'] =  $s_message;
			$arr1['i_created_date'] =  time();
			$table = $this->db->JOB_HISTORY;
			$this->mod_job->set_data_insert($table,$arr1);					
			/*============*/
			$table = $this->db->JOB_STATUS_HISTORY;
			$arr1 = array();
			$arr1['i_job_id'] =  decrypt($id);
			$arr1['i_user_id'] =  0;
			$arr1['s_status'] =  $s_status;		
			$arr1['i_created_date'] =  time();			
			$this->mod_job->set_data_insert($table,$arr1);
			/* end */
			
            if($i_ret_)
            {
                set_success_msg($this->cls_msg["status_succ"]);
                echo 'ok';
            }
            else
            {
               echo 'error';
            }
            
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
    {}
	
	
	 /***
    * Shows History of a single record.
    * 
    * @param int $i_id, Primary key
    */
    public function show_history($i_id=0)
    {
        try
        {
            if(trim($i_id)!="")
            {
                $s_whe = " WHERE n.i_job_id=".decrypt($i_id)." ";
				//$this->load->model('job_model');
				$this->data['history_details'] = $this->mod_job->fetch_job_history($s_whe);               
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            $this->add_js("js/jquery.tinyscrollbar.min.js");
            
            $this->render("manage_jobs/show_history",TRUE);
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
    {}    
	
	
	
	
	
	public function __destruct()
    {}
	
	
}
?>