<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 29 May 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For Autosms
* 
* @package Content Management
* @subpackage autosms
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/auto_sms_model.php
* @link views/admin/autosms/
*/


class Auto_sms extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;   
    public function __construct()
    {            
        try
        {
          parent::__construct();
          $this->data['title']="Autosms Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]="No information found about autosms.";
          $this->cls_msg["save_err"]="Information about autosms failed to save.";
          $this->cls_msg["save_succ"]="Information about autosms saved successfully.";
          $this->cls_msg["delete_err"]="Information about autosms failed to remove.";
          $this->cls_msg["delete_succ"]="Information about autosms removed successfully.";
          $this->cls_msg["send_err"]="autosms not delivered.";
          $this->cls_msg["send_succ"]="autosms delivered successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
          
          //////// loading default model here //////////////
          $this->load->model("auto_sms_model","mod_rect");
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
            $this->data['heading']="Autosms";////Package Name[@package] Panel Heading

             ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title=($this->input->post("h_search")?$this->input->post("txt_title"):$this->session->userdata("txt_title")); 
           
            ////////end Getting Posted or session values for search///

            $s_where="";
           
            if($s_search=="advanced")
            {
                $s_where=" WHERE n.s_subject LIKE '%".get_formatted_string($s_title)."%' ";
               
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_title",$s_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]     =   $s_search;
                $this->data["txt_title"]    =   get_unformatted_string($s_title);                
              
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where="";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_title");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]     =   $s_search;
                $this->data["txt_title"]    =   "";                           
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_title);
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
            
            //$this->i_admin_page_limit = 1;
            $limit    = $this->i_admin_page_limit;
            $info    = $this->mod_rect->fetch_multi($s_where,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array();  
             
                      
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Autosms";
            $table_view["total_rows"]=count($info);
            $table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
            $table_view["detail_view"]           =  false;  //   to disable show details. 
                        
             $table_view["headers"][0]["width"]    ="75%";
             $table_view["headers"][0]["align"]    ="left";
             $table_view["headers"][0]["val"]      ="Subject";
            
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]    = encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]    =$info[$i]["s_subject"];
            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_table($table_view,TRUE);
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
            $this->data['title']="Edit Autosms Details";////Browser Title
            $this->data['heading']="Edit autosms";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";    
            $this->data['type']=$type;        

            ////////////Submitted Form///////////
            if($_POST)
            {
                $posted=array();
                $posted["h_mode"]= $this->data['mode'];
                $posted["txt_subject"]            =    trim($this->input->post("txt_subject"));
                $posted["ta_content"]             =    trim($this->input->post("ta_content"));

                $posted["h_id"]= trim($this->input->post("h_id"));
                
                
                //$this->form_validation->set_rules('txt_milestones_year', 'Newsletter year', 'required|integer|max_length[4]');
                $this->form_validation->set_rules('txt_subject', 'autosms subject', 'required');
                $this->form_validation->set_rules('ta_content', 'autosms description', 'required');
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info    =    array();
                    $info["s_subject"]            =    $posted["txt_subject"];
                    $info["s_content"]            =    $posted["ta_content"];
                    $info["i_status"]            =    1;
                    $info["dt_updated_on"]        =    time();

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
                $posted["txt_subject"]            = $info["s_subject"];
                $posted["ta_content"]            = $info["s_content"];
                $posted['h_mode']               = $this->data['mode'];
                $posted["h_id"]                 = $i_id;

                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("auto_sms/add-edit");
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
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }    

    public function __destruct()
    {}

}
