<?php
/*********
* Author: Koushik 
* Email: koushik.r@acumensoft.info   
* Date  : 16 Nov 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For blog
* 
* @package Content Management
* @subpackage blog
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/blog_model.php
* @link views/admin/blog/
*/
class Blog extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
                                           

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->data['title']="Blog";////Browser Title

           
          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	= "No information found about blog.";
          $this->cls_msg["save_err"]	= "Information about  blog failed to save.";
          $this->cls_msg["save_succ"]	= "Information about  blog saved successfully.";
          $this->cls_msg["delete_err"]	= "Information about  blog failed to remove.";
          $this->cls_msg["delete_succ"]	= "Information about  blog removed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
          
          //////// loading default model here //////////////
          $this->load->model("blog_model","mod_rect");
		  $this->load->model("common_model","mod_common");
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
           
           
            $this->data['heading']="Manage blog";////Package Name[@package] Panel Heading

            ///////////generating search query///////
            
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_blog_title=($this->input->post("h_search")?$this->input->post("txt_blog_title"):$this->session->userdata("txt_blog_title")); 
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status!=0 ";
            
            if($s_search=="advanced")
            {
                if(trim($s_blog_title))
                {
                    $s_where.=" And n.s_title LIKE '%".get_formatted_string($s_blog_title)."%' ";
                }    
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.dt_created_on , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_blog_title",$s_blog_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_blog_title"]=get_unformatted_string($s_blog_title);                
                $this->data["txt_created_on"]=$dt_created_on;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where="  WHERE n.i_status!=0 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_blog_title");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_blog_title"]="";                
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
            $arr_sort = array(1=>'s_title',2=>'dt_created_on');
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[2]:$arr_sort[2];
            
            
            $limit    = $this->i_admin_page_limit;
            $info    = $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
         	
            /////////Creating List view for displaying/////////
            $table_view=array(); 
            $order_name = empty($order_name)?encrypt($arr_sort[2]):$order_name; 
                     
            //////Table Headers, with width,alignment///////
            $table_view["caption"]					="manage_blog";
            $table_view["total_rows"]				=count($info);
            $table_view["total_db_records"]			=$this->mod_rect->gettotal_info($s_where);
            $table_view["order_name"]				=$order_name;
            $table_view["order_by"]  				=$order_by;
            $table_view["src_action"]				= $this->pathtoclass.$this->router->fetch_method(); 
            $table_view["detail_view"]				=false; 
                        
             $table_view["headers"][0]["width"]    	="45%";
             $table_view["headers"][0]["align"]    	="left";
             $table_view["headers"][0]["align"]    	="left";
             $table_view["headers"][0]["sort"]    	= array('field_name'=>encrypt($arr_sort[1])); 
             $table_view["headers"][0]["val"]    	="Blog Title";
             $table_view["headers"][1]["sort"]    	= array('field_name'=>encrypt($arr_sort[2]));  
             $table_view["headers"][1]["val"]    	="Created On";
             $table_view["headers"][2]["val"]    	="No Of Comments";
             $table_view["headers"][3]["val"]    	="Status";
            //////end Table Headers, with width,alignment///////
            
           
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]    = encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]    =$info[$i]["s_title"];
                $table_view["tablerows"][$i][$i_col++]    =$info[$i]["dt_created_on"];  
                $table_view["tablerows"][$i][$i_col++]    =$info[$i]["i_comments"];
                $table_view["tablerows"][$i][$i_col++]    =$info[$i]["s_status"];
				
				$action ='';
				$action .= '<a target="_blank"  href="'.admin_base_url().'blog/show_comment_list/'.$info[$i]["id"].'" ><img width="12" height="12" title="See Comments" alt="See Comments" src="images/admin/comment.png"></a>';
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
            $this->data['title']="Blog Management";////Browser Title
            $this->data['heading']="Add Blog";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="add";

            ////////////Submitted Form///////////
            if($_POST)
            {
                $posted=array();
                $posted["txt_blog_title"]       = trim($this->input->post("txt_blog_title"));
                $posted["txt_blog_description"] = trim($this->input->post("txt_blog_description"));
                $posted["h_mode"]               = $this->data['mode'];
                $posted["h_id"]                 = "";
                
                 // This is for uploading image Blog

                $this->form_validation->set_rules('txt_blog_title', 'blog title', 'required');
                $this->form_validation->set_rules('txt_blog_description', 'blog description', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
                    $info["s_title"]        =   $posted["txt_blog_title"];
                    $info["s_description"]  =   $posted["txt_blog_description"];
                    $info["i_status"]       =   1;
                    $info["dt_created_on"]  =   time();
                    
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
            $this->render("blog/add-edit");
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
            $this->data['title']="Edit Blog Details";////Browser Title
            $this->data['heading']="Edit blog";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";
         

            ////////////Submitted Form///////////
            if($_POST)
            {
                $posted=array();
                $posted["h_mode"]= $this->data['mode'];
                $posted["txt_blog_title"]= trim($this->input->post("txt_blog_title"));
                $posted["txt_blog_description"]= trim($this->input->post("txt_blog_description"));
                $posted["h_id"]= trim($this->input->post("h_id"));

                $this->form_validation->set_rules('txt_blog_title', 'blog title', 'required');
                $this->form_validation->set_rules('txt_blog_description', 'blog description', 'required');
             
                if($this->form_validation->run() == FALSE)/////invalid
                {  
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info    =    array();
                    $info["s_title"]        =   $posted["txt_blog_title"];
                    $info["s_description"]  =   $posted["txt_blog_description"];
                    $info["i_status"]       =   1 ;
                    $info["dt_updated_on"]  =   time();
                    
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
                $posted["txt_blog_title"]           = $info["s_title"];
                $posted["txt_blog_description"]     = $info["s_description"];
                
                $posted["h_id"]= $i_id;
                 
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("blog/add-edit");
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
                default:         ///Deleting selected,page ///
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
            $posted["id"]               =   decrypt($this->input->post("h_id"));/*don't change*/
            $posted["duplicate_value"]  =   get_unformatted_string($this->input->post("h_duplicate_value"));
            
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
	
	/* show blog comment list */
	
	public function show_comment_list($s_blog_id='')
    {
        try
        {
			
			if(empty($s_blog_id))
            	redirect($this->pathtoclass."show_list");
			else
			{
				$this->session->set_userdata('i_main_blog_id',$s_blog_id);
				redirect($this->pathtoclass."show_blog_comment_list");
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
    public function show_blog_comment_list($start=NULL,$limit=NULL)
    {
        try
        {

            ///////////generating search query///////
            ////////Getting Posted or session values for search///
            $s_search		=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title		=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            $dt_created_on	=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            $i_blog_id 					= $this->session->userdata('i_main_blog_id');
			$this->data['blog_info'] 	= $this->mod_rect->fetch_this($i_blog_id);
			$this->data['heading']		= "Blog Comments for - '".$this->data['blog_info']["s_title"]."' ";    /// Panel Heading
			/**/
            $s_where=" WHERE c.i_blog_id =".$i_blog_id." ";
			
           if($s_search=="advanced")
            {
                //$s_where.=" And j.s_title LIKE '%".get_formatted_string($s_title)."%' ";
               
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
            $info	= $this->mod_rect->fetch_blog_comments($s_where,intval($start),$limit);
			//print_r($info);
            /////////Creating List view for displaying/////////
            $table_view=array();  
			$this->data['action_allowed']['Delete']  =   0;
            $this->data['action_allowed']['Add']  	 =   0;
			$this->data['action_allowed']['Edit']	 =   0;
			$this->data['action_allowed']["Status"]	 = 	 1;	
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Blog Comments";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_blog_comments($s_where);
			$table_view["detail_view"] = FALSE;
			
			
            
            $table_view["headers"][0]["width"]    	="45%";
            $table_view["headers"][0]["align"]    	="left";
            $table_view["headers"][0]["align"]    	="left";
            //$table_view["headers"][0]["sort"]    	= array('field_name'=>encrypt($arr_sort[1])); 
            $table_view["headers"][0]["val"]    	="Comment";
            //$table_view["headers"][1]["sort"]    	= array('field_name'=>encrypt($arr_sort[2]));  
            $table_view["headers"][1]["val"]    	="Comment by";
            $table_view["headers"][2]["val"]    	="Commented on";
			$table_view["headers"][3]["val"]    	="Status";
            //////end Table Headers, with width,alignment///////
            
           
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]    = encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]    = $info[$i]["s_comment"];
                $table_view["tablerows"][$i][$i_col++]    = $info[$i]["s_first_name"].' '.$info[$i]["s_last_name"];  
                $table_view["tablerows"][$i][$i_col++]    = $info[$i]["dt_created_on"];
				$table_view["tablerows"][$i][$i_col++]	= '<span id="status_row_id_'.encrypt($info[$i]["id"]).'">'.$info[$i]["s_status"].'</span>';
				
				$action ='';
				
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
	
	/***
    * Change status of the blog comments 
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
			$info['i_status']   = $posted["i_status"];
			$arr_where          = array('i_id'=>$posted["id"]);
			$i_rect				= $this->mod_common->common_edit_info($this->db->BLOGCOMMENT,$info,$arr_where); /*don't change*/                
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