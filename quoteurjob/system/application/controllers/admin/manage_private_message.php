<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 21 Sep 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For manage_private_message
* 
* @package Content Management
* @subpackage manage_private_message
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/manage_private_message_model.php
* @link views/admin/manage_private_message/
*/


class Manage_private_message extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="Private Message Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]="No information found about private message.";
          $this->cls_msg["save_err"]="Information about private message failed to save.";
          $this->cls_msg["save_succ"]="Information about private message saved successfully.";
          $this->cls_msg["delete_err"]="Information about private message failed to remove.";
          $this->cls_msg["delete_succ"]="Information about private message removed successfully.";
		   $this->cls_msg["status_err"]="Message status change failed.";
          $this->cls_msg["status_succ"]="Message status changed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("private_message_model","mod_rect");
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
    public function show_list($start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Private Message";////Package Name[@package] Panel Heading

            ///////////generating search query///////
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE j.i_status!=0";
            if($s_search=="basic")
            {
                $s_where.=" And n.s_message LIKE '%".get_formatted_string($s_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("s_title",$s_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]=$s_title;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
                $s_where.=" And j.s_title LIKE '%".get_formatted_string($s_title)."%' ";
               
			    if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("s_title",$s_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]=$s_title;                
                $this->data["txt_created_on"]=$dt_created_on;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
               $s_where=" WHERE j.i_status!=0";
                /////Releasing search values from session///
                $this->session->unset_userdata("s_title");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]="";                
                $this->data["txt_created_on"]="";             
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
            ///Setting Limits, If searched then start from 0////
			//$i_uri_seg = 6;
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
                $start=$this->uri->segment($this->i_uri_seg);
            }
            ///////////end generating search query///////
            
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_multi($s_where,intval($start),$limit);
			//print_r($info);
            /////////Creating List view for displaying/////////
            $table_view=array();  
			         // echo $s_where;
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="All Private Message";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_board_info($s_where);
			$table_view["detail_view"] = FALSE;
            $j_col = 0;            
            
            $table_view["headers"][$j_col]["val"]	="Job";
			$table_view["headers"][++$j_col]["val"]	="Buyer";
			$table_view["headers"][$j_col]["width"]	="15%";
			$table_view["headers"][++$j_col]["val"]	="New post";
			$table_view["headers"][$j_col]["width"]	="7%";
			$table_view["headers"][++$j_col]["val"]	="Total post";
			$table_view["headers"][$j_col]["width"]	="7%";
			$table_view["headers"][$j_col]["align"]	="center";
            $table_view["headers"][++$j_col]["val"]	="Post Date";
			$table_view["headers"][$j_col]["width"]	="10%"; 
          //  $table_view["headers"][++$j_col]["val"]	="Status"; 
			//$table_view["headers"][$j_col]["width"]	="9%";
			$table_view["headers"][++$j_col]["val"]	="Action"; 
			$table_view["headers"][$j_col]["width"]	="5%";
			$table_view["headers"][$j_col]["align"]	="center";
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_job_title"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_sender_user"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_new_pmb"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_total_pmb"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];
               // $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_status"];
				$table_view["tablerows"][$i][$i_col++]	= ' <a title="View" href="'.admin_base_url().'manage_private_message/job_message_board/'.encrypt($info[$i]["i_job_id"]).'">'.'<img src="images/admin/view.png" alt="View" />';
				

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_table($table_view);
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
	
	 public function job_message_board($s_job_id='')
    {
        try
        {
			
			if(empty($s_job_id))
            	redirect($this->pathtoclass."show_list");
			else
			{
				$this->session->set_userdata('i_msg_board_job_id',decrypt($s_job_id));
				//echo decrypt($s_job_id);
				redirect($this->pathtoclass."show_message_board");
			}
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
    public function show_message_board($start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Private Message";////Package Name[@package] Panel Heading

            ///////////generating search query///////
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            $i_msg_board_job_id = $this->session->userdata('i_msg_board_job_id');
			/* load Job Details*/
				$this->load->model('manage_jobs_model');
			$this->data['job_info'] = $this->manage_jobs_model->fetch_this($i_msg_board_job_id);
			//pr($this->data['job_info']);
			/**/
            $s_where=" WHERE n.i_job_id =$i_msg_board_job_id ";
			
            if($s_search=="basic")
            {
                $s_where.=" And n.s_message LIKE '%".get_formatted_string($s_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("s_title",$s_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]=$s_title;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
                $s_where.=" And j.s_title LIKE '%".get_formatted_string($s_title)."%' ";
               
			    if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("s_title",$s_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]=$s_title;                
                $this->data["txt_created_on"]=$dt_created_on;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
             //   $s_where=" WHERE n.i_status!=0 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("s_title");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]="";                
                $this->data["txt_created_on"]="";             
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
            
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_multi_msg_brd($s_where,intval($start),$limit);
			//print_r($info);
            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="All Private Message";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_msg_brd_info($s_where);
			$table_view["detail_view"] = FALSE;
            $j_col = 0;            
            
            $table_view["headers"][$j_col]["val"]	="Tradesman";
			//$table_view["headers"][++$j_col]["val"]	="Sender";
		//	$table_view["headers"][$j_col]["width"]	="15%";
			$table_view["headers"][++$j_col]["val"]	="New Post";
			$table_view["headers"][$j_col]["width"]	="15%";
			$table_view["headers"][++$j_col]["val"]	="Total post";
			$table_view["headers"][$j_col]["width"]	="7%";
			$table_view["headers"][$j_col]["align"]	="center";
            $table_view["headers"][++$j_col]["val"]	="Post Date";
			$table_view["headers"][$j_col]["width"]	="10%"; 
           // $table_view["headers"][++$j_col]["val"]	="Status"; 
			//$table_view["headers"][$j_col]["width"]	="9%";
			$table_view["headers"][++$j_col]["val"]	="Action"; 
			$table_view["headers"][$j_col]["width"]	="5%";
			$table_view["headers"][$j_col]["align"]	="center";
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
               $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_receiver_user"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_new_pmb"];
			//	$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_receiver_user"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_total_pmb"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];
              ///  $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_status"];
				$table_view["tablerows"][$i][$i_col++]	= ' <a title="View" href="'.admin_base_url().'manage_private_message/job_pmb/'.encrypt($info[$i]["id"]).'">'.'<img src="images/admin/view.png" alt="View" />';
				

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_table($table_view);
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
	/****
    * Display the list of records
    * 
    */
	 public function job_pmb($s_msg_board_id='')
    {
        try
        {
			if(empty($s_msg_board_id))
            	redirect($this->pathtoclass."show_list");
			else
			{
				$this->session->set_userdata('i_msg_board_id',decrypt($s_msg_board_id));
				redirect($this->pathtoclass."job_message");
			}
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
    public function job_message($start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Private Message";////Package Name[@package] Panel Heading

            ///////////generating search query///////
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
             
			/* load Job Details*/
				
		
			/**/
            $i_msg_board_id = $this->session->userdata('i_msg_board_id');
			$this->data['job_info'] = $this->mod_rect->fetch_this($i_msg_board_id);
			//pr($this->data['job_info']);
            $s_where=" WHERE pd.i_msg_board_id =$i_msg_board_id ";
            if($s_search=="basic")
            {
                $s_where.=" And n.s_message LIKE '%".get_formatted_string($s_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("s_title",$s_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]=$s_title;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
              //  $s_where.=" And j.s_title LIKE '%".get_formatted_string($s_title)."%' ";
               
			    if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( pd.i_date , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("s_title",$s_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]=$s_title;                
                $this->data["txt_created_on"]=$dt_created_on;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
              //  $s_where=" WHERE pd.i_status!=0 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("s_title");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]="";                
                $this->data["txt_created_on"]="";             
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
            
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_pmb($s_where,intval($start),$limit);
			//pr($info);
            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="All Private Message";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_pmb_info($s_where);
			$table_view["status_update"]  = TRUE; 
			//$table_view["status_arr"]  =  $this->db->JOBSTATUS;
            $j_col = 0;            
            
            $table_view["headers"][$j_col]["val"]	="Message";
			$table_view["headers"][++$j_col]["val"]	="Sender";
			$table_view["headers"][$j_col]["width"]	="15%";
			$table_view["headers"][++$j_col]["val"]	="Receiver";
			$table_view["headers"][$j_col]["width"]	="15%";
            $table_view["headers"][++$j_col]["val"]	="Post Date";
			$table_view["headers"][$j_col]["width"]	="10%"; 
            $table_view["headers"][++$j_col]["val"]	="Status"; 
			$table_view["headers"][$j_col]["width"]	="9%";
			$table_view["headers"][++$j_col]["val"]	="Action"; 
			$table_view["headers"][$j_col]["width"]	="7%";
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_content"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_sender_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_receiver_name"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_reply_on"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_status"];
				$link = '';
				if($info[$i]["i_status"] == 0)
				{
					$link = '<a title="Approve" onClick="javascript:approve('.$i.');"  href="javascript:void(0);"><img width="12" height="12" alt="Edit" src="images/admin/tick.png"></a>'.' <a title="Reject" onClick="javascript:reject('.$i.');"  href="javascript:void(0);"><img width="12" height="12" alt="Reject" src="images/admin/reject.png"></a>';
				}
				else
				{
					$link = 'NA';
				}
				$link .=' <a alt="Edit Information" value="'.encrypt($info[$i]["id"]).'" id="btn_edit_'.$info[$i]["id"].'" href="'.$this->pathtoclass.'modify_information'.'/'.encrypt($info[$i]["id"]).'"><img width="12" height="12" src="images/admin/edit_inline.gif"></a>';
				$table_view["tablerows"][$i][$i_col++]	=$link;
				

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_table($table_view);
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
	 public function change_status($i_id=0)
    {
        try
        {
            $i_ret_=0;
            $pageno=$this->input->post("h_pageno");///the pagination page no, to return at the same page
            
            /////Update What?//////
            $s_del_these=$this->input->post("h_list");
			
			 $i_status = decrypt($this->input->post("h_status")); 
			
            switch($s_del_these)
			{
				case "all":
							$i_ret_=$this->mod_rect->update_status(-1);
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
							$i_ret_=$this->mod_rect->update_status(decrypt($id[$tot]),$i_status);
							$tot--;
							}
							}
							elseif($id>0)///Deleting single Records
							{
							$i_ret_=$this->mod_rect->update_status(decrypt($id),$i_status);
							}                
							break;
			}
            unset($s_del_these, $id, $tot);
            
            if($i_ret_)
            {
                set_success_msg($this->cls_msg["status_succ"]);
            }
            else
            {
                set_error_msg($this->cls_msg["status_err"]);
            }
            redirect($this->pathtoclass."job_message".($pageno?"/".$pageno:""));
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
			redirect($this->pathtoclass."show_list");
			
			
            $this->data['title']="Job Management";////Browser Title
            $this->data['heading']="Add Job";
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
				$posted["opt_role"]		=	1;	
				
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
			$this->data['arr_status'] = $this->db->JOBSTATUS;
            $this->render("manage_jobs/add-edit");
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
            $this->data['title']="Edit Message Details";////Browser Title
            $this->data['heading']="Edit Message";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]= $this->data['mode'];
				
				$posted["i_status"]		=	trim($this->input->post("i_status"));
				$posted["s_content"]	= 	trim($this->input->post("s_content"));
                $posted["h_id"]			= 	trim($this->input->post("h_id"));
				
				
                $this->form_validation->set_rules('s_content', 'message', 'required');
             	
                if($this->form_validation->run() == FALSE)/////invalid
                {	
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					
				
					
					$info["s_content"]	=	$posted["s_content"];
					$info["i_status"]	=	decrypt($posted["i_status"]);
					$info["s_email_to"]	=	$user["s_receiver_user_email"];
					
					$info["s_subject"]	=	"private message";
					$info["s_email_from"]= $this->config->item('quoteurjob_admin_url');
					 $info["i_date"]	=	strtotime(date("Y-m-d H:i:s"));
					
                    $i_aff=$this->mod_rect->update_new_message_details($info,decrypt($posted["h_id"]));
				//	pr($i_aff,1);
                    if($i_aff)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
						
                        redirect($this->pathtoclass."job_message");
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
				$this->data["edit_action"]= (decrypt($type)) ? $this->pathtoclass.'modify_information'.'/'.$type : '';
                $info=$this->mod_rect->fetch_single_pmb(decrypt($i_id));	
				
				//print_r($info); exit;			
                $posted=array();
				$posted["s_job_title"]			=	trim($info["s_job_title"]);
				$posted["s_content"]			=	trim($info["s_content"]);
				$posted["i_status"]				=	encrypt(trim($info["i_status"]));
				
				//print_r($posted); exit;
					
				$posted["h_id"]= $i_id;
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
			$this->data['arr_status'] = $this->db->PMBSTATUS;
            $this->render("manage_private_message/add-edit");
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
                $info=$this->mod_rect->fetch_single_pmb(decrypt($i_id));
			//	print_r($info);
                if(!empty($info))
                {
                    $temp=array();
                    $temp["s_id"]			= 	encrypt($info["id"]);////Index 0 must be the encrypted PK 
					$temp["s_job_title"]		= 	trim($info["s_job_title"]);
					$temp["s_message"]			= 	htmlspecialchars_decode(trim($info["s_content"]));
					$temp["s_sender_user"]		= 	trim($info["s_sender_user"]);
					$temp["s_receiver_user"]	= 	trim($info["s_receiver_user"]);
										
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
            
            $this->render("manage_private_message/show_detail",TRUE);
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
	
	
	
	/****
    * Display the list of records when we need send extar param
    * 
    */
    public function show_param_list($type=NULL,$start=NULL,$limit=NULL)
    {
        try
        {
			if(empty($type))
			{
				 redirect($this->pathtoclass."show_list");
				 exit;
			}	 
		
            $this->data['heading']= "New Private Message";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status='".decrypt($type)."' ";
            if($s_search=="basic")
            {
                $s_where.=" AND n.s_message LIKE '%".get_formatted_string($s_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("s_title",$s_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]=$s_title;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
                if(trim($s_title))
				{
					$s_where.=" AND n.s_message LIKE '%".get_formatted_string($s_title)."%' ";
				}	
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("s_title",$s_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]=$s_title;                
                $this->data["txt_created_on"]=$dt_created_on;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                
                /////Releasing search values from session///
                $this->session->unset_userdata("s_title");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]="";                
                $this->data["txt_created_on"]="";             
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
			
			/* need to reassign the following value for extra param i.e $type*/
			
            $this->i_uri_seg = intval($this->i_uri_seg + 1);
            //$this->i_admin_page_limit = 1;
			
			/***************** End to reassign the config valus ***************/
			
			
			
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
			
			/********** added by iman on 21 sep 2011********************/
			
			
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_multi($s_where,intval($start),$limit);
			
            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="New Private Message";
            $table_view["total_rows"]=count($info);
			$table_view["param_type"]=$type; // need to send to create baseurl for pagination

			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
                        
            $table_view["headers"][0]["width"]	="15%";
            $table_view["headers"][0]["align"]	="left";
            $table_view["headers"][0]["val"]	="Job";
			$table_view["headers"][1]["val"]	="Message";
			$table_view["headers"][2]["val"]	="Sender";
			$table_view["headers"][3]["val"]	="Receiver";
            $table_view["headers"][4]["val"]	="Post Date"; 
            $table_view["headers"][5]["val"]	="Status"; 
			$table_view["headers"][6]["val"]	="Edit"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_job_title"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_message"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_sender_user"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_receiver_user"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_status"];
				$table_view["tablerows"][$i][$i_col++]	='<a alt="Edit Information" value="'.encrypt($info[$i]["id"]).'" id="btn_edit_'.$info[$i]["id"].'" href="'.$this->pathtoclass.'modify_information'.'/'.$type.'/'.encrypt($info[$i]["id"]).'"><img width="12" height="12" alt="Edit" src="images/admin/edit_inline.gif"></a>';
				

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_param_table($table_view,TRUE);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method().'/'.$type;///used for search form action
            //echo $this->data["search_action"];
            
            $this->render();          
            unset($table_view,$info);
          
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