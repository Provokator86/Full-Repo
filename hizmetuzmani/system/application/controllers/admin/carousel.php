<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 07 June 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For carousel images
* 
* @package Gallery
* @subpackage banner
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/carousel_model.php
* @link views/admin/carousel/
*/


class Carousel extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public $uploaddir;
    public $thumbdir;
    public $showimgdir;
	public $thumbDisplayPath;
    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="Images Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	="No information found about image.";
          $this->cls_msg["save_err"]	="Information about image failed to save.";
          $this->cls_msg["save_succ"]	="Information about image saved successfully.";
          $this->cls_msg["delete_err"]	="Information about image failed to remove.";
          $this->cls_msg["delete_succ"]	="Information about image removed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("carousel_model","mod_rect");
		  //////// end loading default model here //////////////
		  
		  $this->allowedExt = 'jpg|jpeg|png';
		  $this->uploaddir = $this->config->item('carousel_image_upload_path');		//for uploading images to this folder
		  $this->thumbdir = $this->config->item('carousel_image_thumb_upload_path');	//for uploading image thumbnails  
		  $this->thumbDisplayPath = $this->config->item('carousel_image_thumb_path');	//for display thumbnails image 
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
            $this->data['heading']="Carousel Images";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search		=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title		=($this->input->post("h_search")?$this->input->post("txt_banner_title"):$this->session->userdata("txt_banner_title")); 
            $dt_created_on	=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where="";
			$arr_where = array();
            if($s_search=="advanced")
            {
				if(trim($txt_banner_title)!="")
                {
                    $arr_where[]="n.s_title LIKE '%".get_formatted_string($txt_banner_title)."%' ";
                    
                }
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $arr_where[] ="  FROM_UNIXTIME( n.dt_entry_date , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_banner_title",$txt_banner_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
				//$this->session->set_userdata("opt_album_id",$opt_album_id);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_banner_title"]=$txt_banner_title;                
                $this->data["txt_created_on"]=$dt_created_on;  
				//$this->data["opt_album_id"]=$opt_album_id;           
                /////end Storing search values into session///                
                 $s_where = count($arr_where)!=0?"WHERE ".implode('AND ',$arr_where):'';
            }
            else////List all records, **not done
            {
                $s_where="";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_banner_title");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_banner_title"]="";                
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
            $info	= $this->mod_rect->fetch_multi($s_where,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Images";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
            $table_view["detail_view"]=false;            
            $table_view["headers"][0]["width"]	=	"30%";
            $table_view["headers"][0]["align"]	=	"left";
            $table_view["headers"][0]["val"]	=	"Tab name"; 
            $table_view["headers"][1]["val"]	=	"Created On"; 
            $table_view["headers"][2]["val"]	=	"Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= 	encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=	$info[$i]["s_title"];	
                $table_view["tablerows"][$i][$i_col++]	=	$info[$i]["dt_created_on"];
                $table_view["tablerows"][$i][$i_col++]	=	$info[$i]["s_is_active"];

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
            $this->data['title']="Images Management";////Browser Title
            $this->data['heading']="Add Homepage Image";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="add";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["txt_banner_title"]= trim($this->input->post("txt_banner_title"));	
				$posted['txt_is_active'] = trim($this->input->post("txt_is_active"));
                $posted["i_is_active"]= ($posted['txt_is_active']==1)?$posted['txt_is_active']:2;
                $posted["h_mode"]= $this->data['mode'];
                $posted["h_id"]= "";
				
				if(isset($_FILES['txt_image_name']) && !empty($_FILES['txt_image_name']['name']))
				{
					$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'txt_image_name','','',$this->allowedExt);
					
					$arr_upload_res = explode('|',$s_uploaded_filename);						
					
				}
				$this->form_validation->set_rules('txt_banner_title', 'banner title', 'required');
				
              
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
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
					$info["s_title"] 		= $posted["txt_banner_title"];
                    //$info["i_status"]		= $posted["i_is_active"];
					$info["s_image"]		= $arr_upload_res[2];
                    $info["dt_entry_date"]	= time();
                    $i_newid = $this->mod_rect->add_info($info);
                    if($i_newid)////saved successfully
                    {
						if($arr_upload_res[0]==='ok')
						{
							get_image_thumb($this->uploaddir.$info["s_image"], $this->thumbdir, 'thumb_'.$info["s_image"]);
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
            $this->render("carousel/add-edit");
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
            $this->data['title']="Edit Images Details";////Browser Title
            $this->data['heading']="Edit Carousel Image";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";
			$this->data['thumbDir']= $this->thumbDisplayPath;
		
            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]= $this->data['mode'];
				$posted["txt_banner_title"]		= trim($this->input->post("txt_banner_title"));
				$posted["h_image_name"]			= trim($this->input->post("h_image_name"));
                $posted["h_id"]					= trim($this->input->post("h_id"));
				
				if(isset($_FILES['txt_image_name']) && !empty($_FILES['txt_image_name']['name']))
				{
				$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'txt_image_name','','',$this->allowedExt);				
				$arr_upload_res = explode('|',$s_uploaded_filename);	
				}
				
               //pr($posted,1);
				//$this->form_validation->set_rules('txt_banner_title', 'title', 'required');
             
				if($arr_upload_res[0]==='err')/////invalid
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
                    $info	=	array();
					//$info["s_title"] 			= $posted["txt_banner_title"];
                    //$info["i_status"]			= $posted["i_is_active"];
                    $info["dt_entry_date"]		= time();
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
							get_image_thumb($this->uploaddir.$info["s_image"], $this->thumbdir, 'thumb_'.$info["s_image"]);
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
				$posted["txt_banner_title"]	= trim($info["s_title"]);
				$posted["txt_image_name"]	= trim($info["s_image"]);
				$posted["h_id"]= $i_id;
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("carousel/add-edit");
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
    {} 
    
    /***
    * Shows details of a single record.
    * 
    * @param int $i_id, Primary key
    */
    public function show_detail($i_id=0)
    {}
     /***
    * Checks duplicate value using ajax call
    */
    public function ajax_checkduplicate()
    {}    
	public function __destruct()
    {}
	
	
}
?>