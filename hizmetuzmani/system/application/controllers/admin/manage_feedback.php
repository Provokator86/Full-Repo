<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 29 March 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For manage_feedback
* 
* @package Content Management
* @subpackage Manage Feedback
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/manage_feedback_model.php
* @link views/admin/manage_feedback/
*/


class Manage_feedback extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="Feedback Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	="No information found about feedback.";
          $this->cls_msg["save_err"]	="Information about feedback failed to save.";
          $this->cls_msg["save_succ"]	="Information about feedback saved successfully.";
          $this->cls_msg["delete_err"]	="Information about feedback failed to remove.";
          $this->cls_msg["delete_succ"]	="Information about feedback removed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("manage_feedback_model","mod_rect");
		  $this->load->model("job_model","mod_job");
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
            $this->data['heading']="Job Feedback";////Package Name[@package] Panel Heading
			$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search		=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title		=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            $dt_created_to	=($this->input->post("h_search")?$this->input->post("txt_created_to"):$this->session->userdata("txt_created_to"));
			$dt_created_on	=($this->input->post("h_search")?$this->input->post("txt_created_frm"):$this->session->userdata("txt_created_frm"));
           			
			$opt_buyer_id	=($this->input->post("h_search")?$this->input->post("opt_buyer_id"):$this->session->userdata("opt_buyer_id")); 
			////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE j.i_is_deleted=0 ";
            if($s_search=="basic")
            {
                $s_where=" WHERE n.s_comments LIKE '%".get_formatted_string($s_job_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_job_title",$s_job_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_job_title"]=$s_job_title;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
				if($s_title)
				{
                	$s_where.=" And j.s_title LIKE '%".get_formatted_string($s_title)."%' ";
				}				
				
				if($opt_buyer_id!="")
				{
					$s_where.=" And n.i_sender_user_id=".decrypt($opt_buyer_id)." ";
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
				//$this->session->set_userdata("s_cat",$s_cat);
				$this->session->set_userdata("opt_buyer_id",$opt_buyer_id);
                $this->session->set_userdata("txt_created_frm",$dt_created_on);
				$this->session->set_userdata("txt_created_to",$dt_created_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]=$s_title;   
				//$this->data["s_cat"]=$s_cat;     
				$this->data["opt_buyer_id"]=$opt_buyer_id;                   
                $this->data["txt_created_frm"]=$dt_created_on;  
				$this->data["txt_created_to"]=$dt_created_to;                
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                //$s_where=" WHERE cat_c.i_lang_id=".$this->i_admin_language;
                /////Releasing search values from session///
                $this->session->unset_userdata("s_title");
				// $this->session->unset_userdata("s_cat");
                $this->session->unset_userdata("txt_created_frm");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]="";      
				//$this->data["s_cat"]="";              
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
			$arr_sort = array(0=>'s_title',2=>'i_buyer_user_id',3=>'i_created_date',6=>'i_rating');   
			
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[3]:$arr_sort[3];
			$order_name = empty($order_name)?encrypt($arr_sort[3]):$order_name;
            $limit	= $this->i_admin_page_limit;
			//echo $s_where;
            $info	= $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Job Feedback";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->data["search_action"] ;     
			$table_view["status_update"]  =FALSE; 
            $j_col = 0;
            $table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][$j_col]["val"]	="Job Title";
			$table_view["headers"][++$j_col]["val"]	="Buyer";
			$table_view["headers"][$j_col]["width"]	="15%";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[2]));
			$table_view["headers"][++$j_col]["val"]	="Tradesman";
			$table_view["headers"][$j_col]["width"]	="15%";
			$table_view["headers"][++$j_col]["val"]	="Type";
			$table_view["headers"][$j_col]["width"]	="7%";
            $table_view["headers"][++$j_col]["val"]	="Posted On";
			$table_view["headers"][$j_col]["width"]	="10%";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[3]));
			$table_view["headers"][++$j_col]["align"]	="left"; 
			$table_view["headers"][$j_col]["val"]	="Rating"; 
			$table_view["headers"][$j_col]["width"]	="10%";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[6]));
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_job_title"];
				$link = "<a alt='Click here to view profile' href='".admin_base_url().'buyers_profile/index/'.encrypt($info[$i]["i_sender_user_id"])."' target='_blank'>".$info[$i]["s_sender_user"].'</a>';
				$link2 = "<a alt='Click here to view profile' href='".admin_base_url().'tradesman_profile_view/index/'.encrypt($info[$i]["i_receiver_user_id"])."' target='_blank'>".$info[$i]["s_receiver_user"].'</a>';
				$table_view["tablerows"][$i][$i_col++]	=$link;
				$table_view["tablerows"][$i][$i_col++]	=$link2;
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_positive"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];
				$table_view["tablerows"][$i][$i_col++]	= show_star($info[$i]["i_rating"]);
                //$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_status"];

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
            $this->data['title']="News Management";////Browser Title
            $this->data['heading']="Add News";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="add";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["txt_news_title"]= trim($this->input->post("txt_news_title"));
				$posted["txt_news_description"]= trim($this->input->post("txt_news_description"));
				$i_active_val = trim($this->input->post("i_news_is_active"));
                $posted["i_news_is_active"]= ($i_active_val==1)?$i_active_val:2;
                $posted["h_mode"]= $this->data['mode'];
                $posted["h_id"]= "";
				
				
               
                $this->form_validation->set_rules('txt_news_title', 'news title', 'required');
                $this->form_validation->set_rules('txt_news_description', 'news description', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
                    $info["s_title"]=$posted["txt_news_title"];
                    $info["s_description"]=$posted["txt_news_description"];
                    $info["i_status"]=$posted["i_news_is_active"];
                    $info["dt_entry_date"]=strtotime(date("Y-m-d H:i:s"));
					
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
            $this->render("news/add-edit");
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
            $this->data['title']="Edit Feedback Details";////Browser Title
            $this->data['heading']="Edit Feedback";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]= $this->data['mode'];
				$posted["s_comments"]	= trim($this->input->post("s_comments"));
				$posted["opt_rate"]		= trim($this->input->post("opt_rate"));	
				//$posted["i_status"]		= trim($this->input->post("i_status"));
				$posted["i_positive"]	= trim($this->input->post("i_positive"));
				
                $posted["h_id"]= trim($this->input->post("h_id"));
				
				
                $this->form_validation->set_rules('s_comments', 'comments', 'required');
             
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["s_comments"]		=	$posted["s_comments"];
					$info["i_rating"]		=	$posted["opt_rate"];
					//$info["i_status"]		=	$posted["i_status"];
					$info["i_positive"]		=	$posted["i_positive"];

                    //print_r($info); exit;
                    $i_aff=$this->mod_rect->edit_info($info,decrypt($posted["h_id"]));
                   
					if($i_aff)////saved successfully
                    {
						$feed_back_deatils = $this->mod_rect->fetch_this(decrypt($posted["h_id"]));	
						//pr($feed_back_deatils);exit;
						$this->load->model('manage_buyers_model');
						$user_type = $this->manage_buyers_model->fetch_this($feed_back_deatils['i_receiver_user_id']);
						//var_dump($user_type);
						$s_where = " WHERE i_receiver_user_id ={$feed_back_deatils['i_receiver_user_id']} AND n.i_status=1 "; 
						$tot_accepted_feedback = $this->mod_rect->gettotal_info($s_where);
						
						$s_where = " WHERE i_receiver_user_id ={$feed_back_deatils['i_receiver_user_id']} AND n.i_status!=0 "; 				
						$tot_feedback = $this->mod_rect->gettotal_info($s_where);
						
						$s_where = " WHERE i_receiver_user_id ={$feed_back_deatils['i_receiver_user_id']} AND n.i_status !=0 "; 				
						$feedback_details = $this->mod_rect->fetch_feedback_rating($s_where);						
						
						$s_where = " WHERE i_receiver_user_id ={$feed_back_deatils['i_receiver_user_id']} AND n.i_status !=0 AND n.i_positive=1 " ;
						$i_positive = $this->mod_rect->fetch_feedback_positive($s_where);
						//pr($feed_back_deatils);
						//echo $user_type['i_role'];
						if($user_type['i_role'] == 2)
						{
							$arr1 = array();
							$arr1['i_feedback_rating'] = round($feedback_details['i_rating']);
							$arr1['f_positive_feedback_percentage'] = ($tot_feedback!=0)?round(($i_positive['i_positive']/$tot_feedback)*100):0;
							
							$arr1['i_feedback_received'] = $tot_feedback;
							$table = $this->db->TRADESMANDETAILS;
							$cond = array('i_user_id'=>$feed_back_deatils['i_receiver_user_id']);
							//var_dump($arr1); 
						}
						
						//pr($arr1);exit;
						$this->mod_job->set_data_update($table,$arr1,$cond);
					
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
							
                $posted=array();
				$posted["s_job_title"]		= trim($info["s_job_title"]);
				$posted["s_comments"]		= trim($info["s_comments"]);
				$posted["opt_rate"]			= trim($info["i_rating"]);
				$posted["i_status"]			= trim($info["i_status"]);
				$posted["i_positive"]		= trim($info["i_positive"]);
				$posted["dt_created_on"]	= trim($info["dt_created_on"]);
				$posted["i_is_active"]		= trim($info["i_status"]);
				$posted["h_id"]= $i_id;
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
			$this->data['arr_rating'] = $this->db->FEEDBACKRATING;
            $this->render("manage_feedback/add-edit");
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
                    $temp["s_id"]				= 	encrypt($info["id"]);////Index 0 must be the encrypted PK 
					$temp["s_job_title"]		= 	trim($info["s_job_title"]);
					$temp["s_comments"]			= 	trim($info["s_comments"]);
					$temp["s_sender_user"]		= 	trim($info["s_sender_user"]);
					$temp["s_receiver_user"]	= 	trim($info["s_receiver_user"]);
					$temp["i_rating"]			= 	trim($info["i_rating"]);
					$temp["s_positive"]			= 	trim($info["s_positive"]);
					
					$temp["s_status"]			= 	trim($info["s_status"]);
					$temp["dt_created_on"]		= 	trim($info["dt_created_on"]);

					$this->data["info"]=$temp;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            
            $this->render("manage_feedback/show_detail",TRUE);
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
                $qry=" Where ".(intval($posted["id"])>0 ? " n.i_id!=".intval($posted["id"])." And " : "" )
                    ." n.s_title='".$posted["duplicate_value"]."'";
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
	public function __destruct()
    {}
	
	
}
?>