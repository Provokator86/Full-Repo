<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 03 April 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For manage_quotes
* 
* @package Jobs
* @subpackage Manage Quotes
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/news_model.php
* @link views/admin/news/
*/


class Manage_quotes extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
  

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="Quotes Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	=	"No information found about quotes.";
          $this->cls_msg["save_err"]	=	"Information about quotes failed to save.";
          $this->cls_msg["save_succ"]	=	"Information about quotes saved successfully.";
          $this->cls_msg["delete_err"]	=	"Information about quotes failed to remove.";
          $this->cls_msg["delete_succ"]	=	"Information about quotes removed successfully.";
		  $this->cls_msg["status_succ"] =	"Status of quotes saved successfully.";
		  $this->cls_msg["status_err"]	=	"Status of quotes failed to save.";
		  $this->cls_msg["marked_succ"] =	"Quotes has been marked successfully";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("job_model","mod_rect");
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
            $this->data['heading']="Quotes";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search	= (isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_job_title= ($this->input->post("h_search")?$this->input->post("txt_title"):$this->session->userdata("txt_title")); 
			$s_comment	= ($this->input->post("h_search")?$this->input->post("txt_comment"):$this->session->userdata("txt_comment")); 
            $dt_from	= ($this->input->post("h_search")?$this->input->post("txt_created_from"):$this->session->userdata("txt_created_from"));
			$dt_to		= ($this->input->post("h_search")?$this->input->post("txt_created_to"):$this->session->userdata("txt_created_to"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status!=0 ";
            if($s_search=="advanced")
            {
                if(trim($s_job_title)!='')
				{
					$s_where.=" And j.s_title LIKE '%".get_formatted_string($s_job_title)."%' ";
				}	
				if(trim($s_comment)!='')
				{
					$s_where.=" And n.s_comment LIKE '%".get_formatted_string($s_comment)."%' ";
				}
                if(trim($dt_from)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_from." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) >='".$dt_start."' ";
                    unset($dt_start);
                }				
				if(trim($dt_to)!="")
				{
					$dt_end = date("Y-m-d",strtotime(trim($dt_to." "))) ;					
					$arr_search[]="  FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) <='".$dt_end."' ";
                    unset($dt_end);
				}
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_title",$s_job_title);
				$this->session->set_userdata("txt_comment",$s_comment);
                $this->session->set_userdata("txt_created_from",$dt_from);
				$this->session->set_userdata("txt_created_to",$dt_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]			= $s_search;
                $this->data["txt_title"]		= $s_job_title;   
				$this->data["txt_comment"]		= $s_comment; 	             
                $this->data["txt_created_from"]	= $dt_from; 
				$this->data["txt_created_to"]	= $dt_to;            
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where="";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_title");
				$this->session->unset_userdata("txt_comment");
                $this->session->unset_userdata("txt_created_from");
				$this->session->unset_userdata("txt_created_to");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]			=$s_search;
                $this->data["txt_title"]		="";  
				$this->data["txt_comment"]		="";               
                $this->data["txt_created_from"]	=""; 
				$this->data["txt_created_to"]	="";             
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_job_title,$s_comment,$dt_from,$dt_to);
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
			$arr_sort = array(0=>'s_title',2=>'i_created_date',3=>'i_status');
			$s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[2]:$arr_sort[2];
            
            
            $limit	= $this->i_admin_page_limit;            
			$info	= $this->mod_rect->fetch_multi_sorted_quote_list($s_where,$s_order_name,$order_by,intval($start));
			//pr($info,1);
			
            /////////Creating List view for displaying/////////
			$table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[2]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Quotes";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_quote_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method(); 
			$table_view["detail_view"]=FALSE;
			
                        
            $table_view["headers"][0]["width"]	="20%";
            $table_view["headers"][0]["align"]	="left";
			$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][0]["val"]	="Job Title";
			$table_view["headers"][1]["width"]	=	"20%";
			$table_view["headers"][1]["val"]	="Comment";
			$table_view["headers"][2]["width"]	=	"9%";
			$table_view["headers"][2]["val"]	="Quote(s)";
			$table_view["headers"][3]["width"]	=	"14%";
			$table_view["headers"][3]["val"]	="Tradesman";
			$table_view["headers"][4]["width"]	=	"14%";
			$table_view["headers"][4]["val"]	="Buyer";
			
			$table_view["headers"][5]["width"]	=	"10%";
			$table_view["headers"][5]["sort"]	= array('field_name'=>encrypt($arr_sort[2]));
            $table_view["headers"][5]["val"]	="Quoted On"; 
			
			$table_view["headers"][6]["width"]	=	"9%";
            $table_view["headers"][6]["val"]	="Status";
			
			
            //////end Table Headers, with width,alignment///////
			
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["job_title"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_comment"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["d_quote"].' '.$this->config->item('default_currency');
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["buyer_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_status"];
				$action = '';
				if($info[$i]["i_status"] != 2)
				{
					if($this->data['action_allowed']["Status"])
					 {
					  $action .='<a  href="javascript:void(0);" onclick="javascript:delete_quote(\''.encrypt($info[$i]["id"]).'\')"><img width="12" height="12" title="Delete" alt="Delete" src="images/admin/delete.png"></a>';
						  if($info[$i]["i_view"] == 0)
						  {
						  $action .='<a  href="javascript:void(0);" onclick="javascript:read_quote(\''.encrypt($info[$i]["id"]).'\')"><img width="12" height="12" title="Mark as read" alt="Mark as read" src="images/admin/marked.png"></a>';
						  }
					 }					
				}
				else
				{
					$action .='<span class="do_na"></span>';
				}
				//$action .=  ' <a  href="'.admin_base_url().'job_overview/index/'.encrypt($info[$i]["i_job_id"]).'">'.'<img src="images/admin/view.png" title="View" alt="View" />'.'</a>';
				if($action!='')
			    {
				$table_view["rows_action"][$i]    = $action;     
			    } 

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            //$this->data["table_view"]=$this->admin_showin_table($table_view);
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
    * Change status value 
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
					//$mail_send = $this->mod_rect->account_activate_deactivate(decrypt($s_id),$info);
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
            $this->data['title']="Edit Quote Details";////Browser Title
            $this->data['heading']="Edit Quote";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]		= $this->data['mode'];
				$posted["txt_comment"]	= trim($this->input->post("txt_comment"));
				$posted["txt_quote"]	= trim($this->input->post("txt_quote"));
                $posted["h_id"]			= trim($this->input->post("h_id"));
				
				
                $this->form_validation->set_rules('txt_comment', 'provide comment', 'required');
                $this->form_validation->set_rules('txt_quote', 'provide quote', 'required');
             
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["s_comment"]	= $posted["txt_comment"];
                    $info["d_quote"]	= $posted["txt_quote"];
					
					$this->load->model('common_model');
					$s_table = $this->db->JOBQUOTES;
					$arr_where = array('id'=>decrypt($posted["h_id"]));
                    
                    $i_aff=$this->common_model->common_edit_info($s_table,$info,$arr_where);
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
                    unset($info,$posted,$i_aff,$arr_where,$s_table);
                    
                }
            }
			
            else
            {
                $info=$this->mod_rect->fetch_this_quote(decrypt($i_id));				
                $posted=array();
				$posted["txt_comment"]	= trim($info["s_comment"]);
				$posted["txt_quote"]	= $info["d_quote"];
				$posted["h_id"]			= $i_id;
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("manage_quotes/add-edit");
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
    {}
	
	 /**
    * this ajax function is for quote delete
    * 
    */
    public function ajax_delete_quote()
    {
        try
        {
            $id           =   trim($this->input->post('i_id'));
            
            $i_ret_       =       $this->mod_rect->delete_quote(decrypt($id));
            if($i_ret_)
            {
                set_success_msg($this->cls_msg["delete_succ"]);
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
	
	 /**
    * this ajax function is for quote delete
    * 
    */
    public function ajax_read_quote()
    {
        try
        {
            $id           =   trim($this->input->post('i_id')); 
			$arr['i_view'] = 1;           
            $i_ret_       =   $this->mod_rect->read_quote($arr,decrypt($id));
            if($i_ret_)
            {
                set_success_msg($this->cls_msg["marked_succ"]);
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
    
        
	public function __destruct()
    {}
	
	
}
?>