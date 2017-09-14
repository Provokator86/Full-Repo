<?php
/*********
* Author: Koushik rout
* Date  : 29 March 2012
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  Controller For Category
* 
* @package General
* @subpackage Category
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/category_model.php
* @link views/admin/category/
*/


class Category extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public $lang_prefix;
	public $uploaddir;
    public $showimgdir;
	public $thumbdir;
	public $thumbDisplayPath;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="Category Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	=	"No information found about Category.";
          $this->cls_msg["save_err"]	=	"Information about Category failed to save.";
          $this->cls_msg["save_succ"]	=	"Information about Category saved successfully.";
          $this->cls_msg["delete_err"]	=	"Information about Category failed to remove.";
          $this->cls_msg["delete_succ"]	=	"Information about Category removed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
          
          //////// loading default model here //////////////
          $this->load->model("category_model","mod_cat");
          //////// end loading default model here //////////////

          $this->lang_prefix=   $this->session->userdata('lang_prefix');  //Default language prefix.    
		  
		  /* for uploading category icon */
		  $this->allowedExt 		= 'jpg|jpeg|png';
		  $this->uploaddir 			= $this->config->item('category_icon_upload_path');	
		  $this->showimgdir 		= $this->config->item('category_icon_path');
		  $this->thumbdir 			= $this->config->item('category_icon_thumb_upload_path');
		  $this->thumbDisplayPath 	= $this->config->item('category_icon_thumb_path');
		  $this->newHeight			= $this->config->item('category_icon_upload_thumb_height');
		  $this->newWidth			= $this->config->item('category_icon_upload_thumb_width');
		
		   
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
           
            $this->data['heading']="Category";////Package Name[@package] Panel Heading

            ///////////generating search query///////
            
            ////////Getting Posted or session values for search///
            $s_search		= (isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_category_name= ($this->input->post("h_search")?$this->input->post("txt_category_name"):$this->session->userdata("txt_category_name")); 
            
            
			////////end Getting Posted or session values for search///

            $s_where=" ";

            if($s_search=="advanced")
            {

            $s_where.=" WHERE  n.{$this->lang_prefix}_s_category_name LIKE '%".get_formatted_string($s_category_name)."%' ";
    
                
			/////Storing search values into session///
			$this->session->set_userdata("txt_category_name",$s_category_name);
			$this->session->set_userdata("opt_type_id",$i_type_id);
			$this->session->set_userdata("h_search",$s_search);
			
			$this->data["h_search"]=$s_search;
			$this->data["txt_category_name"]=$s_category_name;                
			$this->data["opt_type_id"]=$i_type_id;             
			/////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" ";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_category_name");
                $this->session->unset_userdata("opt_type_id");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_category_name"]="";                
                $this->data["opt_type_id"]="";             
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_category_name,$i_type_id);
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
            
            $arr_sort = array(0=>$this->lang_prefix.'_s_category_name',1=>$this->lang_prefix.'_s_name',2=>'dt_created_on',3=>'i_status'); 
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[2]:$arr_sort[2];
            
            
            $limit    = $this->i_admin_page_limit;
            
            $info    = $this->mod_cat->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array(); 
            $order_name = empty($order_name)?encrypt($arr_sort[2]):$order_name; 
                      
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Category";
            $table_view["total_rows"]=count($info);
            $table_view["total_db_records"]=$this->mod_cat->gettotal_info($s_where);
            $table_view["order_name"]=$order_name;
            $table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method(); 
            
                        
            $table_view["headers"][0]["width"]    ="20%";
            $table_view["headers"][0]["align"]    ="left";
            $table_view["headers"][0]["val"]    ="Name";
            $table_view["headers"][0]["sort"]    = array('field_name'=>encrypt($arr_sort[0]));
            
			$table_view["headers"][1]["width"]    ="20%";
            $table_view["headers"][1]["sort"]    = array('field_name'=>encrypt($arr_sort[2]));
            $table_view["headers"][1]["val"]    ="Created On"; 
			
            $table_view["headers"][2]["width"]    ="15%"; 
            $table_view["headers"][2]["sort"]    = array('field_name'=>encrypt($arr_sort[3]));
            $table_view["headers"][2]["val"]    ="Status"; 
            //////end Table Headers, with width,alignment///////
            
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]    = encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]    = $info[$i]["s_category_name"];
                $table_view["tablerows"][$i][$i_col++]    = $info[$i]["dt_created_on"];
                $table_view["tablerows"][$i][$i_col++]    = $info[$i]["s_is_active"];

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
           
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            
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
            $this->data['title']        =   "Category Management";////Browser Title
            $this->data['heading']      =   "Add Category";
            $this->data['pathtoclass']  =   $this->pathtoclass;
            $this->data['mode']         =   "add";
            $this->data['s_language']   =   $this->s_default_lang_name;  //Show in the label
            $this->data['s_lang_prefix']=   $this->lang_prefix; 
            


            ////////////Submitted Form///////////
            if($_POST)
            {
                $posted=array();
                $posted["txt_category_name"]         =    trim($this->input->post("txt_category_name"));
                
                $posted["h_mode"]                    =    $this->data['mode'];
                $posted["h_id"]= "";    
                 
                $this->form_validation->set_rules('txt_category_name', 'Category name', 'required');
				
				if(isset($_FILES['f_icon']) && !empty($_FILES['f_icon']['name']))
				{
				$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'f_icon','','',$this->allowedExt);				
				$arr_upload_res = explode('|',$s_uploaded_filename);
				}
                
                $info    =    array();

                if($this->form_validation->run() == FALSE || ($arr_upload_res[0]==='err'))/////invalid
                {                
					if($arr_upload_res[0]==='err')
					{
						set_error_msg($arr_upload_res[2]);
					}
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info["s_lang_prefix"]          =   $this->lang_prefix;//For the default language case of add information    
                    //$info["i_type_id"]              =   decrypt($posted["opt_type_id"]); 
                    $info["s_category_name"]        =   $posted["txt_category_name"];
					$info["s_icon"]					=	$arr_upload_res[2];
                    $info["dt_created_on"]          =   time();

                    $i_newid = $this->mod_cat->add_info($info);
                    if($i_newid)////saved successfully
                    {
						if($arr_upload_res[0]==='ok')
						{
							get_image_thumb($this->uploaddir.$info["s_icon"], $this->thumbdir, 'thumb_'.$info["s_icon"],$this->newHeight,$this->newWidth);
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
            
            $this->render("category/add-edit");
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
            $this->data['title']="Category Management";////Browser Title
            $this->data['heading']="Edit Category";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";

            ////////////Submitted Form///////////
            if($_POST)
            {
                $posted=array();
                $posted["h_mode"]                    =    $this->data['mode'];
                $posted["opt_language"]              =    trim($this->input->post("opt_language"));  
                $posted["txt_category_name"]         =    trim($this->input->post("txt_category_name"));
				$posted["h_icon"]					 = 	trim($this->input->post("h_icon"));
                $posted["h_mode"]                    =    $this->data['mode'];
                $posted["h_id"]                      =    trim($this->input->post("h_id"));
                
                
                $this->form_validation->set_rules('opt_language', 'language', 'required'); 
                $this->form_validation->set_rules('txt_category_name', 'Category name', 'required');
				
				if(isset($_FILES['f_icon']) && !empty($_FILES['f_icon']['name']))
				{
				$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'f_icon','','',$this->allowedExt);				
				$arr_upload_res = explode('|',$s_uploaded_filename);
				}
                
                $info    =    array();

                if($this->form_validation->run() == FALSE || ($arr_upload_res[0]==='err') )/////invalid
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
                    
                    
                    $info["s_lang_prefix"]          =   $posted["opt_language"] ; 
                    $info["s_category_name"]        =   $posted["txt_category_name"];
					if(count($arr_upload_res)==0)
					{
						$info["s_icon"] = 	$posted['h_icon'];
					}
					else
					{
						$info["s_icon"] = 	$arr_upload_res[2];
					}

                    $i_aff=$this->mod_cat->edit_info($info,decrypt($posted["h_id"]));
                    if($i_aff)////saved successfully
                    {
						if($arr_upload_res[0]==='ok')
						{
							get_image_thumb($this->uploaddir.$info["s_icon"], $this->thumbdir, 'thumb_'.$info["s_icon"],$this->newHeight,$this->newWidth);
							get_file_deleted($this->uploaddir,$posted['h_icon']);
							get_file_deleted($this->thumbdir,'thumb_'.$posted['h_icon']);
						}
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list");
                    }
                    else///Not saved, show the form again
                    {
                        $this->data["posted"]=$posted;
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                }
            unset($info,$posted, $i_aff);
            }
            else
            {
                
                
               
                $info=$this->mod_cat->fetch_this(decrypt($i_id));    
                        
                $posted=array();
                $posted["opt_language"]         = $this->lang_prefix;
                $posted["txt_category_name"]    = $info["s_category_name"];
                $posted["txt_price_factor"]     = $info["s_price_factor"];
                $posted["opt_type_id"]          = encrypt($info["i_type_id"]);
				$posted['f_icon']	=	$info['s_icon'];
                $posted["h_mode"]               = $this->data['mode']; 
                $posted["h_id"]                 = $i_id;

                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("category/add-edit");
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
                            $i_ret_=$this->mod_cat->delete_info(-1);
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
                            $i_ret_=$this->mod_cat->delete_info(decrypt($id[$tot]));
                            $tot--;
                            }
                            }
                            elseif($id>0)///Deleting single Records
                            {
                            $i_ret_=$this->mod_cat->delete_info(decrypt($id));
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
                $info=$this->mod_cat->fetch_this(decrypt($i_id));

                if(!empty($info))
                {
                    $temp=array();
                    $temp["s_id"]               =   encrypt($info["id"]);////Index 0 must be the encrypted PK 
                    $temp["s_category_name"]    =   $info["s_category_name"];
                    $temp["s_is_active"]        =   $info["s_is_active"];
                    $temp["s_name"]             =   $info["s_name"];
                    $temp["s_price_factor"]     =   $info["s_price_factor"];  
                    $temp["dt_created_on"]      =   $info["dt_created_on"];

                    $this->data["info"]         =   $temp;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            
            $this->render("category/show_detail",TRUE);
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
            $posted["lang_prefix"]    = htmlspecialchars(trim($this->input->post("h_lang_prefix")),ENT_QUOTES);  
            //$posted["i_cat_type"]     = trim($this->input->post("i_cat_type")) ;
            
            //$s_qry  =   ($posted["i_cat_type"]!="")?" AND n.i_type_id= ".decrypt($posted["i_cat_type"]):"";  
			$s_qry	=	"";
            
            if($posted["duplicate_value"]!="")
            {
                $qry=" Where ".(intval($posted["id"])>0 ? " n.i_id!=".intval($posted["id"])." AND " : "" )
                    ." n.{$posted["lang_prefix"]}_s_category_name='".$posted["duplicate_value"]."'".$s_qry;
    
                
                $info=$this->mod_cat->fetch_multi($qry,'',''); /*don't change*/
                
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
    /**
    * This ajax function is used to fetch contains of faq in selected language.
    * posted data is language prefix and id. 
    * 
    */
    public function ajax_fetch_contains()
    {
        try
        {
            $posted                     = array();
            $posted["id"]               = decrypt(trim($this->input->post("h_id")));
            $posted["s_lang_prefix"]    = trim($this->input->post("s_lang_prefix"));
            $info   =   $this->mod_cat->fetch_this($posted["id"],$posted["s_lang_prefix"]);
            echo $info['s_category_name'];
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