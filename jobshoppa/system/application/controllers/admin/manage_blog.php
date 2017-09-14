<?php
/*********
* Author: Koushik Rout
* Date  : 16 Nov 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For manage_blog
* 
* @package Content Management
* @subpackage manage_blog
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/manage_blog_model.php
* @link views/admin/manage_blog/
*/
class Manage_blog extends My_Controller implements InfController
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
          $this->data['title']="Manage blog";////Browser Title

           
          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]="No information found about manage_blog.";
          $this->cls_msg["save_err"]="Information about manage blog failed to save.";
          $this->cls_msg["save_succ"]="Information about manage blog saved successfully.";
          $this->cls_msg["delete_err"]="Information about manage blog failed to remove.";
          $this->cls_msg["delete_succ"]="Information about manage blog removed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
          
          //////// loading default model here //////////////
          $this->load->model("manage_blog_model","mod_rect");
          //////// end loading default model here //////////////
                                                            
           ///////////manage_blog image upload path///////////
          $this->allowedExt         = 'jpg|jpeg|png|gif';    
          $this->uploaddir          = $this->config->item('manage_blog_image_upload_path');    
          $this->thumbdir           = $this->config->item('manage_blog_image_thumb_upload_path');
          $this->thumbDisplayPath   = $this->config->item('manage_blog_image_thumb_path');
          $this->nw_width           = $this->config->item('manage_blog_photo_upload_thumb_width');
          $this->nw_height          = $this->config->item('manage_blog_photo_upload_thumb_height');
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
           
           
            $this->data['heading']="Manage blog";////Package Name[@package] Panel Heading

            ///////////generating search query///////
            
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_blog_title=($this->input->post("h_search")?$this->input->post("txt_blog_title"):$this->session->userdata("txt_blog_title")); 
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status!=0 ";
            if($s_search=="basic")
            {
                $s_where.=" And n.s_title LIKE '%".get_formatted_string($s_blog_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_blog_title",$s_blog_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_blog_title"]=$s_blog_title;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
                if(trim($s_blog_title))
                {
                    $s_where.=" And n.s_title LIKE '%".get_formatted_string($s_blog_title)."%' ";
                }    
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.dt_entry_date , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_blog_title",$s_blog_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_blog_title"]=$s_blog_title;                
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
            $arr_sort = array(0=>'s_title',2=>'dt_entry_date',3=>'i_status');
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
            
            
            $limit    = $this->i_admin_page_limit;
            //$info    = $this->mod_rect->fetch_multi($s_where,intval($start),$limit);
            $info    = $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
         

            /////////Creating List view for displaying/////////
            $table_view=array(); 
            $order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
                     
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="manage_blog";
            $table_view["total_rows"]=count($info);
            $table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
            $table_view["order_name"]=$order_name;
            $table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method(); 
            
                        
            $table_view["headers"][0]["width"]    ="15%";
            $table_view["headers"][0]["align"]    ="left";
            $table_view["headers"][0]["sort"]    = array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][0]["val"]    ="Blog Title";
            $table_view["headers"][1]["width"]    =    "45%";
            $table_view["headers"][1]["val"]    ="Description";
            $table_view["headers"][2]["width"]    =    "20%";
            $table_view["headers"][2]["sort"]    = array('field_name'=>encrypt($arr_sort[2]));
            $table_view["headers"][2]["val"]    ="Created On"; 
            $table_view["headers"][3]["width"]    =    "8%";
            $table_view["headers"][3]["sort"]    = array('field_name'=>encrypt($arr_sort[3]));
            $table_view["headers"][3]["val"]    ="Status"; 
            //////end Table Headers, with width,alignment///////
            
           
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]    = encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]    =$info[$i]["s_title"];
                $s_desc= strip_tags($info[$i]["s_desc_full"]); 
                 if(strlen($s_desc)>50)
                      $s_desc = substr_replace($s_desc,'...',53);
                $table_view["tablerows"][$i][$i_col++]    = $s_desc;
                $table_view["tablerows"][$i][$i_col++]    =$info[$i]["dt_created_on"];
                $table_view["tablerows"][$i][$i_col++]    =$info[$i]["s_is_active"];

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
                $i_active_val                   = trim($this->input->post("i_blog_is_active"));
                $posted["i_blog_is_active"]     = ($i_active_val==1)?$i_active_val:2;
                $posted["h_mode"]               = $this->data['mode'];
                $posted["h_id"]                 = "";
                
                 // This is for uploading image Blog


                if(isset($_FILES['txt_image_name']) && !empty($_FILES['txt_image_name']['name']))
                {
                    $s_uploaded_filename = get_file_uploaded( $this->uploaddir,'txt_image_name','','',$this->allowedExt);
                    
                    $arr_upload_res = explode('|',$s_uploaded_filename);                        
                    
                }

               
                $this->form_validation->set_rules('txt_blog_title', 'blog title', 'required');
                $this->form_validation->set_rules('txt_blog_description', 'blog description', 'required');
              
                if($this->form_validation->run() == FALSE || ($arr_upload_res[0]==='err'))/////invalid
                {
                    // Display upload error
                    if($arr_upload_res[0]==='err')
                    {
                        set_error_msg($arr_upload_res[2]);
                    }
                    else
                    {
                        get_file_deleted($this->uploaddir,$arr_upload_res[2]);
                    }
                    ////////Display the add form with posted values within it////
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
                    $info["s_title"]=$posted["txt_blog_title"];
                    $info["s_description"]=$posted["txt_blog_description"];
                    $info["s_image"]    = $arr_upload_res[2];  
                    $info["i_status"]=$posted["i_blog_is_active"];
                    $info["dt_entry_date"]=strtotime(date("Y-m-d H:i:s"));
                    
                    $i_newid = $this->mod_rect->add_info($info);
                    if($i_newid)////saved successfully
                    {
                        if($arr_upload_res[0]==='ok')
                        {
                            get_image_thumb($this->uploaddir.$info["s_image"], $this->thumbdir, 'thumb_'.$info["s_image"],$this->thumbhght,$this->thumbwdth);
                        }
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
            $this->render("manage_blog/add-edit");
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
            $this->data['thumbDir']= $this->thumbDisplayPath;    

            ////////////Submitted Form///////////
            if($_POST)
            {
                $posted=array();
                $posted["h_mode"]= $this->data['mode'];
                $posted["txt_blog_title"]= trim($this->input->post("txt_blog_title"));
                $posted["txt_blog_description"]= trim($this->input->post("txt_blog_description"));
                $i_active_val = trim($this->input->post("i_blog_is_active"));
                $posted["h_image_name"]= trim($this->input->post("h_image_name")); 
                $posted["i_blog_is_active"]= ($i_active_val==1)?$i_active_val:2;
                $posted["h_id"]= trim($this->input->post("h_id"));
                
                if(isset($_FILES['txt_image_name']) && !empty($_FILES['txt_image_name']['name']))
                {
                    $s_uploaded_filename = get_file_uploaded( $this->uploaddir,'txt_image_name','','',$this->allowedExt);
                    
                    $arr_upload_res = explode('|',$s_uploaded_filename);                        
                    
                }
                
                
                $this->form_validation->set_rules('txt_blog_title', 'blog title', 'required');
                $this->form_validation->set_rules('txt_blog_description', 'blog description', 'required');
             
                if($this->form_validation->run() == FALSE || ($arr_upload_res[0]==='err'))/////invalid
                {
                    if($arr_upload_res[0]==='err')
                    {
                        set_error_msg($arr_upload_res[2]);
                    }
                    else
                    {
                        get_file_deleted($this->uploaddir,$arr_upload_res[2]);
                    }
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info    =    array();
                    $info["s_title"]=$posted["txt_blog_title"];
                    $info["s_description"]=$posted["txt_blog_description"];
                    $info["i_status"]=$posted["i_blog_is_active"];
                    $info["dt_entry_date"]=strtotime(date("Y-m-d H:i:s"));
                    if(count($arr_upload_res)==0)
                    {
                        $info["s_image"] = $posted['h_image_name'];
                    }
                    else
                    {
                        $info["s_image"] = $arr_upload_res[2];
                    }
                    
                    $i_aff=$this->mod_rect->edit_info($info,decrypt($posted["h_id"]));
                    if($i_aff)////saved successfully
                    {
                        if($arr_upload_res[0]==='ok')
                        {
                            get_image_thumb($this->uploaddir.$info["s_image"], $this->thumbdir, 'thumb_'.$info["s_image"],$this->thumbhght,$this->thumbwdth);
                            get_file_deleted($this->uploaddir,$posted['h_image_name']);
                            get_file_deleted($this->thumbdir,'thumb_'.$posted['h_image_name']);
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
                $info=$this->mod_rect->fetch_this(decrypt($i_id));  
                           
                $posted=array();
                $posted["txt_blog_title"]= trim($info["s_title"]);
                $posted["txt_blog_description"]= trim($info["s_desc_full"]);
                $posted["dt_created_on"]= trim($info["dt_created_on"]);
                $posted["i_blog_is_active"]= trim($info["i_is_active"]);
                $posted["txt_image_name"]= trim($info["s_image"]);  
                $posted["h_id"]= $i_id;
                 
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("manage_blog/add-edit");
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
            $this->data['thumbDir']= $this->thumbDisplayPath;    
            if(trim($i_id)!="")
            {
                $info=$this->mod_rect->fetch_this(decrypt($i_id));

                if(!empty($info))
                {
                    $temp=array();
                    $temp["s_id"]= encrypt($info["id"]);////Index 0 must be the encrypted PK 
                    $temp["s_blog_title"]= trim($info["s_title"]);
                    $temp["s_blog_description"]= trim($info["s_description"]);
                    $temp["s_image"]= trim($info["s_image"]);
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
            
            $this->render("manage_blog/show_detail",TRUE);
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
