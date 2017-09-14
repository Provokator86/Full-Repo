<?php
/*********
* Author:Koushik Rout
* Date  : 29 Mar 2012
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  Controller For Faq
* 
* @package Content Management
* @subpackage faq
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/faq_model.php
* @link views/admin/faq/
*/


class Faq extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public $uploaddir;
	public $allowedExt;
    public $add_info_link; // declare to change the add_information function name
    public $edit_info_link; // declare to change the edit_information function name
    public $remove_info_link; // declare to change the edit_information function name
    public $lang_prefix;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="FAQ Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]="No information found about FAQ.";
          $this->cls_msg["save_err"]="Information about FAQ failed to save.";
          $this->cls_msg["save_succ"]="Information about FAQ saved successfully.";
          $this->cls_msg["delete_err"]="Information about FAQ failed to remove.";
          $this->cls_msg["delete_succ"]="Information about FAQ removed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("faq_model","mod_rect");
          
          
          $this->lang_prefix=   $this->session->userdata('lang_prefix');  //Default language prefix.     

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
            redirect($this->pathtoclass."buyers_show_list");
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
    public function show_list()
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
    * Method to Display and Save New information
    * This have to sections: 
    *  >>Displaying Blank Form for new entry.
    *  >>Saving the new information into DB
    * After Posting the form, the posted values must be
    * shown in the form if any error occurs to avoid re-entry of the form.
    * 
    * On Success redirect to the showList interface else display error here.
    */
    public function add_information($type='')           
    {
        //echo $this->router->fetch_method();exit();
		try
        {
            $this->data['title']="FAQ Management";////Browser Title
            $this->data['heading']="Add FAQ";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="add";
            $this->data['s_language']   =   $this->s_default_lang_name;  //Show in the label
            $this->data['s_lang_prefix']=   $this->lang_prefix; 
            $this->data['type']  =  $type;
            ////////////Submitted Form///////////
            if($_POST)
            {
                $posted=array();
                $posted["txt_faq_question"]       =    trim($this->input->post("txt_faq_question"));
                $posted["txt_faq_answer"]         =    trim($this->input->post("txt_faq_answer"));
                $posted["opt_category"]           =    trim($this->input->post("opt_category"));
                $i_active_val                     =    trim($this->input->post("i_faq_is_active"));
                $posted["i_faq_is_active"]        =    ($i_active_val==1)?$i_active_val:2;
                $posted["h_mode"]                 =    $this->data['mode'];
                $posted["h_id"]= "";    

                $this->form_validation->set_rules('txt_faq_question', 'question', 'required');
                $this->form_validation->set_rules('txt_faq_answer', 'answer', 'required');
                $this->form_validation->set_rules('opt_category', 'category', 'required');
                
                $s_where        =   ' WHERE '.$this->lang_prefix.'_s_question = "'.$posted["txt_faq_question"].'"';
                $ret_           =   $this->mod_rect->fetch_multi($s_where);
                if(!empty($ret_) && count($ret_)==1)
                {
                    $data_exist_id = $ret_[0]['id'];
                }
                
                
                $info    =    array();

                if($this->form_validation->run() == FALSE )/////invalid
                {                
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                
                    if($type=='buyers')
                    {
                        $info["i_user_type"]        =    1;
                    }
                    else if($type=='tradesmen')
                    {
                        $info["i_user_type"]        =    2;
                    }
                    $info["s_lang_prefix"]          =   $this->lang_prefix;//For the default language case of add information    
                    $info["s_question"]         =    $posted["txt_faq_question"];
                    $info["s_answer"]           =    $posted["txt_faq_answer"];
                    $info["i_status"]           =    $posted["i_faq_is_active"];
                    $info["i_faq_cat"]          =    decrypt($posted["opt_category"]);
                    $info["dt_entry_date"]      =    time();
                    

                    if(empty($ret_))  //  INSERTING NEW  RECORD IF NOT EXIST AFTER CHECKING 
                        {
                            $i_newid = $this->mod_rect->add_info($info);
                            if($i_newid)////saved successfully
                            {
                                set_success_msg($this->cls_msg["save_succ"]);
                                  if($type!='')
                                    {
                                        redirect($this->pathtoclass.$type."_show_list");
                                    }
                            }
                            else///Not saved, show the form again
                            {
                                set_error_msg($this->cls_msg["save_err"]);
                            }
                        }
                    else            //  DATA UPDATED IF DATA ALREADY EXIST
                        {    
                            $i_aff=$this->mod_rect->edit_info($info,$data_exist_id);
                            if($i_aff)////saved successfully
                            {
                                set_success_msg($this->cls_msg["save_succ"]);
                                  if($type!='')
                                  {
                                        redirect($this->pathtoclass.$type."_show_list");
                                  }
                            }
                            else///Not saved, show the form again
                            {
                                $this->data["posted"]=$posted;
                                set_error_msg($this->cls_msg["save_err"]);
                            }
                            
                        }
                    
                }
            }
            ////////////end Submitted Form///////////
            
            if($type=='buyers')
            {
                $this->data['arr_cat'] = $this->db->ARR_CATEGORY['BUYER_FAQ'];
            }
            else if($type=='tradesmen')
            {
                $this->data['arr_cat'] = $this->db->ARR_CATEGORY['TRADESMAN_FAQ'];
            }
            
            
            $this->render("faq/add-edit");
           
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
    public function modify_information($type='',$i_id=0)
    {
          
        try
        {
            
            $this->data['title']="Edit FAQ Details";////Browser Title
            $this->data['heading']="Edit FAQ";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";
            $this->data['type']=$type;

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]				= 	$this->data['mode'];
				$posted["opt_language"]			=	trim($this->input->post("opt_language"));
                $posted["opt_category"]         =    trim($this->input->post("opt_category"));
                $posted["txt_faq_question"]		=	trim($this->input->post("txt_faq_question"));
				$posted["txt_faq_answer"]		= 	trim($this->input->post("txt_faq_answer"));
				$i_active_val 					= 	trim($this->input->post("i_faq_is_active"));
                $posted["i_faq_is_active"]		= 	($i_active_val==1)?$i_active_val:2;
                $posted["h_id"]					= 	trim($this->input->post("h_id"));
				
				
                $this->form_validation->set_rules('opt_language', 'language', 'required');
				$this->form_validation->set_rules('txt_faq_question', 'question', 'required');
                $this->form_validation->set_rules('txt_faq_answer', 'answer', 'required');
                $this->form_validation->set_rules('opt_category', 'category', 'required');
			
				
             
                $info	=	array();
				
				
                if($this->form_validation->run() == FALSE )/////invalid
                {
					
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                  
					if($type=='buyers')
                    {
                        $info["i_user_type"]        =    1;
                    }
                    else if($type=='tradesmen')
                    {
                        $info["i_user_type"]        =    2;
                    }
                    $info["s_lang_prefix"]  =   $posted["opt_language"] ; 
                    $info["s_question"]		=	$posted["txt_faq_question"];
                    $info["s_answer"]		=	$posted["txt_faq_answer"];
                    $info["i_status"]		=	$posted["i_faq_is_active"];
                    $info["i_faq_cat"]      =    decrypt($posted["opt_category"]);
                    $info["dt_entry_date"]	=	time();


					$i_aff=$this->mod_rect->edit_info($info,decrypt($posted["h_id"]));
					if($i_aff)////saved successfully
					{
						set_success_msg($this->cls_msg["save_succ"]);
                        if($type!='')
                        {
                            redirect($this->pathtoclass.$type."_show_list");
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
                $info=$this->mod_rect->fetch_this(decrypt($i_id));	
						
                $posted=array();
                $posted["h_mode"]           = $this->data['mode'];
				$posted["txt_faq_question"]	= trim($info["s_question"]);
				$posted["txt_faq_answer"]	= trim($info["s_answer"]);
				$posted["dt_created_on"]	= trim($info["dt_created_on"]);
				$posted["i_faq_is_active"]	= trim($info["i_is_active"]);
                $posted["opt_category"]     = encrypt($info["i_faq_cat"]);
				$posted["h_id"]= $i_id;
                
                // Added 24 april
                $posted["opt_language"]     =   $this->lang_prefix;

                $this->data["posted"]=$posted;  
                if($type=='buyers')
                {
                    $this->data['arr_cat'] = $this->db->ARR_CATEGORY['BUYER_FAQ'];
                }
                else if($type=='tradesmen')
                {
                    $this->data['arr_cat'] = $this->db->ARR_CATEGORY['TRADESMAN_FAQ'];
                }     
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////

            $this->render("faq/add-edit");
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
    public function remove_information($type='',$i_id=0)
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
            if($type!='')
            {
                redirect($this->pathtoclass.$type."_show_list".($pageno?"/".$pageno:""));
            }
            else
            {
                redirect($this->pathtoclass."show_list".($pageno?"/".$pageno:""));
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
					$temp["s_question"]= trim($info["s_question"]);
					$temp["s_answer"]= trim($info["s_answer"]);
					$temp["s_faq_cat"]= trim($info["s_faq_cat"]);
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
            
            $this->render("faq/show_detail",TRUE);
            unset($i_id);
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
            $info   =   $this->mod_rect->fetch_this($posted["id"],$posted["s_lang_prefix"]);
            echo json_encode($info);
            
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
                    ." n.s_question='".$posted["duplicate_value"]."' And n.i_user_type=1 ";
					
					
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
    
    public function new_show_list($start=0)
    {
        try
        {
            echo "it is new show list"  ;
            $this->render('faq/show_list');
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    public function tradesmen_show_list($order_name='',$order_by='asc',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="FAQ For Tradesman";////Package Name[@package] Panel Heading
            $this->add_info_link        =   'add_information/tradesmen/';
            $this->edit_info_link       =   'modify_information/tradesmen/';
            $this->remove_info_link    =   'remove_information/tradesmen/';

            ///////////generating search query///////
            
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_faq_title=($this->input->post("h_search")?$this->input->post("txt_faq_title"):$this->session->userdata("txt_faq_title")); 
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where="WHERE i_del_status != 2 AND i_user_type=2 ";
            if($s_search=="basic")
            {
                $s_where.=" AND n.{$this->lang_prefix}_s_question LIKE '%".get_formatted_string($s_faq_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_faq_title",$s_faq_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_faq_title"]=$s_faq_title;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
                if(trim($s_faq_title))
                {
                    $s_where.=" AND n.s_question LIKE '%".get_formatted_string($s_faq_title)."%' ";
                }    
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.dt_entry_date , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_faq_title",$s_faq_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_faq_title"]=$s_faq_title;                
                $this->data["txt_created_on"]=$dt_created_on;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where="WHERE i_del_status != 2 And i_user_type=2 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_faq_title");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_faq_title"]="";                
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
            
            $arr_sort = array(2=>'dt_entry_date',3=>'i_status'); 
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[2]:$arr_sort[2];
            
            
            $limit    = $this->i_admin_page_limit;
            //$info    = $this->mod_rect->fetch_multi($s_where,intval($start),$limit);
             $info    = $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array(); 
            $order_name = empty($order_name)?encrypt($arr_sort[2]):$order_name;  
                      
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="FAQ";
            $table_view["total_rows"]=count($info);
            $table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
            $table_view["order_name"]=$order_name;
            $table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method(); 
            
                        
            $table_view["headers"][0]["width"]    ="24%";
            $table_view["headers"][0]["align"]    ="left";
            $table_view["headers"][0]["val"]    ="Question";
            $table_view["headers"][1]["val"]    ="Answer";
            $table_view["headers"][2]["width"]    ="20%";
            $table_view["headers"][2]["sort"]    = array('field_name'=>encrypt($arr_sort[2]));
            $table_view["headers"][2]["val"]    ="Created On"; 
            $table_view["headers"][3]["width"]    ="8%"; 
            $table_view["headers"][3]["sort"]    = array('field_name'=>encrypt($arr_sort[3]));
            $table_view["headers"][3]["val"]    ="Status"; 
            //////end Table Headers, with width,alignment///////
            
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]    = encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]    =$info[$i]["s_question"];
                $table_view["tablerows"][$i][$i_col++]    =$info[$i]["s_answer"];
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
            
            $this->render('faq/show_list');          
            unset($table_view,$info);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    } 
    
      public function buyers_show_list($order_name='',$order_by='asc',$start=NULL,$limit=NULL)
      {
        try
        {
            $this->data['heading']="FAQ";////Package Name[@package] Panel Heading
            $this->add_info_link        =   'add_information/buyers/'    ;
            $this->edit_info_link       =   'modify_information/buyers/';
            $this->remove_info_link     =   'remove_information/buyers/';

            ///////////generating search query///////
            
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_faq_title=($this->input->post("h_search")?$this->input->post("txt_faq_title"):$this->session->userdata("txt_faq_title")); 
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where="WHERE i_del_status != 2 AND i_user_type=1 ";
            if($s_search=="basic")
            {
                $s_where.=" AND n.s_question LIKE '%".get_formatted_string($s_faq_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_faq_title",$s_faq_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_faq_title"]=$s_faq_title;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
                if(trim($s_faq_title))
                {
                    $s_where.=" AND n.{$this->lang_prefix}_s_question LIKE '%".get_formatted_string($s_faq_title)."%' ";
                }    
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.dt_entry_date , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_faq_title",$s_faq_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_faq_title"]=$s_faq_title;                
                $this->data["txt_created_on"]=$dt_created_on;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where="WHERE i_del_status != 2 And i_user_type=1 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_faq_title");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_faq_title"]="";                
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
            
            $arr_sort = array(2=>'dt_entry_date',3=>'i_status'); 
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[2]:$arr_sort[2];
            
            
            $limit    = $this->i_admin_page_limit;
            //$info    = $this->mod_rect->fetch_multi($s_where,intval($start),$limit);
             $info    = $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array(); 
            $order_name = empty($order_name)?encrypt($arr_sort[2]):$order_name; 
                      
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="FAQ";
            $table_view["total_rows"]=count($info);
            $table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
            $table_view["order_name"]=$order_name;
            $table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method(); 
            
                        
            $table_view["headers"][0]["width"]    ="20%";
            $table_view["headers"][0]["align"]    ="left";
            $table_view["headers"][0]["val"]    ="Question";
            $table_view["headers"][1]["val"]    ="Answer";
            $table_view["headers"][2]["width"]    ="20%";
            $table_view["headers"][2]["sort"]    = array('field_name'=>encrypt($arr_sort[2]));
            $table_view["headers"][2]["val"]    ="Created On"; 
            $table_view["headers"][3]["width"]    ="8%"; 
            $table_view["headers"][3]["sort"]    = array('field_name'=>encrypt($arr_sort[3]));
            $table_view["headers"][3]["val"]    ="Status"; 
            //////end Table Headers, with width,alignment///////
            
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]    = encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]    =$info[$i]["s_question"];
                $table_view["tablerows"][$i][$i_col++]    =$info[$i]["s_answer"];
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
            
            $this->render('faq/show_list');          
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