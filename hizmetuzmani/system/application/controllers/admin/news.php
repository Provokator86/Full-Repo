<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 12 Sep 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For news
* 
* @package Content Management
* @subpackage News
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/news_model.php
* @link views/admin/news/
*/


class News extends My_Controller implements InfController
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
          $this->data['title']="News Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]="No information found about news.";
          $this->cls_msg["save_err"]="Information about news failed to save.";
          $this->cls_msg["save_succ"]="Information about news saved successfully.";
          $this->cls_msg["delete_err"]="Information about news failed to remove.";
          $this->cls_msg["delete_succ"]="Information about news removed successfully.";
		   $this->cls_msg["status_succ"]="Status of news saved successfully.";
		   $this->cls_msg["status_err"]="Status of news failed to save.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("news_model","mod_rect");
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
            $this->data['heading']="News";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_news_title=($this->input->post("h_search")?$this->input->post("txt_news_title"):$this->session->userdata("txt_news_title")); 
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status!=0 ";
            if($s_search=="basic")
            {
                $s_where.=" And n.s_title LIKE '%".get_formatted_string($s_news_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_news_title",$s_news_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_news_title"]=$s_news_title;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
                if(trim($s_news_title))
				{
					$s_where.=" And n.s_title LIKE '%".get_formatted_string($s_news_title)."%' ";
				}	
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.dt_entry_date , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_news_title",$s_news_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_news_title"]=$s_news_title;                
                $this->data["txt_created_on"]=$dt_created_on;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where="";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_news_title");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_news_title"]="";                
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
			$arr_sort = array(0=>'s_title',2=>'dt_entry_date',3=>'i_status');
			$s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
            
            
            $limit	= $this->i_admin_page_limit;
            //$info	= $this->mod_rect->fetch_multi($s_where,intval($start),$limit);
			$info	= $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);

            /////////Creating List view for displaying/////////
			$table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="News";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method(); 
			
                        
            $table_view["headers"][0]["width"]	="15%";
            $table_view["headers"][0]["align"]	="left";
			$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][0]["val"]	="News Title";
			$table_view["headers"][1]["width"]	=	"45%";
			$table_view["headers"][1]["val"]	="Description";
			$table_view["headers"][2]["width"]	=	"20%";
			$table_view["headers"][2]["sort"]	= array('field_name'=>encrypt($arr_sort[2]));
            $table_view["headers"][2]["val"]	="Created On"; 
			$table_view["headers"][3]["width"]	=	"8%";
			$table_view["headers"][3]["sort"]	= array('field_name'=>encrypt($arr_sort[3]));
            $table_view["headers"][3]["val"]	="Status"; 
			if($this->data['action_allowed']["Status"])
			{
			 $table_view["headers"][4]["val"]	="Action";
			}
			
            //////end Table Headers, with width,alignment///////
			
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_title"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_description"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_is_active"];
				if($this->data['action_allowed']["Status"])
				{
				 	if($info[$i]["i_is_active"] == 1)
					{
						$action ='<a  href="'.admin_base_url().'news/change_status/'.encrypt($info[$i]["id"]).'/0">
						<img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/reject.png"></a>';
					}
					else
					{
						$action =' <a  href="'.admin_base_url().'news/change_status/'.encrypt($info[$i]["id"]).'/1">
						<img width="12" height="12" alt="Active" title="Active" src="images/admin/tick.png"></a>';
					}
				 $table_view["tablerows"][$i][$i_col++]	=$action;
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
            $this->data['title']="Edit News Details";////Browser Title
            $this->data['heading']="Edit news";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]= $this->data['mode'];
				$posted["txt_news_title"]= trim($this->input->post("txt_news_title"));
				$posted["txt_news_description"]= trim($this->input->post("txt_news_description"));
				$i_active_val = trim($this->input->post("i_news_is_active"));
                $posted["i_news_is_active"]= ($i_active_val==1)?$i_active_val:2;
                $posted["h_id"]= trim($this->input->post("h_id"));
				
				
                $this->form_validation->set_rules('txt_news_title', 'news title', 'required');
                $this->form_validation->set_rules('txt_news_description', 'news description', 'required');
             
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["s_title"]=$posted["txt_news_title"];
                    $info["s_description"]=$posted["txt_news_description"];
                    $info["i_status"]=$posted["i_news_is_active"];
                    $info["dt_entry_date"]=strtotime(date("Y-m-d H:i:s"));

                    
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
                $posted=array();
				$posted["txt_news_title"]= trim($info["s_title"]);
				$posted["txt_news_description"]= trim($info["s_description"]);
				$posted["dt_created_on"]= trim($info["dt_created_on"]);
				$posted["i_news_is_active"]= trim($info["i_is_active"]);
				$posted["h_id"]= $i_id;
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
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
                    $temp["s_id"]= encrypt($info["id"]);////Index 0 must be the encrypted PK 
					$temp["s_news_title"]= trim($info["s_title"]);
					$temp["s_news_description"]= trim($info["s_description"]);
					$temp["s_is_active"]= trim($info["s_is_active"]);
					$temp["dt_created_on"]= trim($info["dt_created_on"]);

					$this->data["info"]=$temp;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            
            $this->render("news/show_detail",TRUE);
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