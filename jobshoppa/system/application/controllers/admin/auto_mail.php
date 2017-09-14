<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 20 Aug 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For Automail
* 
* @package Content Management
* @subpackage automail
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/auto_mail_model.php
* @link views/admin/automail/
*/


class Auto_mail extends My_Controller implements InfController
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
          $this->data['title']="Automail Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]="No information found about automail.";
          $this->cls_msg["save_err"]="Information about automail failed to save.";
          $this->cls_msg["save_succ"]="Information about automail saved successfully.";
          $this->cls_msg["delete_err"]="Information about automail failed to remove.";
          $this->cls_msg["delete_succ"]="Information about automail removed successfully.";
		  $this->cls_msg["send_err"]="automail not delivered.";
          $this->cls_msg["send_succ"]="automail delivered successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("auto_mail_model","mod_rect");
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
            $this->data['heading']="Automail";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_milestones_title=($this->input->post("h_search")?$this->input->post("txt_subject"):$this->session->userdata("txt_subject")); 
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where="";
            if($s_search=="basic")
            {
                $s_where=" WHERE n.s_subject LIKE '%".get_formatted_string($s_milestones_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_subject",$s_milestones_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_subject"]=$s_milestones_title;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
                $s_where=" WHERE n.s_subject LIKE '%".get_formatted_string($s_milestones_title)."%' ";
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.dt_entry_date , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_subject",$s_milestones_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_subject"]=$s_milestones_title;                
                $this->data["txt_created_on"]=$dt_created_on;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where="";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_subject");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_subject"]="";                
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
            
            //$this->i_admin_page_limit = 1;
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_multi($s_where,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Automail";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
                        
            $table_view["headers"][0]["width"]	="25%";
            $table_view["headers"][0]["align"]	="left";
            $table_view["headers"][0]["val"]	="Subject";
			$table_view["headers"][1]["val"]	="";
			$table_view["headers"][2]["val"]	="Key";
			$table_view["headers"][3]["val"]	="Type";
			//$table_view["headers"][4]["val"]	="Edit";
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_subject"];
				$table_view["tablerows"][$i][$i_col++]	='';
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_key_dispaly"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_type"];
				//$table_view["tablerows"][$i][$i_col++]	='<a alt="Edit Information" value="'.encrypt($info[$i]["id"]).'" id="btn_edit_'.$info[$i]["id"].'" href="'.$this->pathtoclass.'modify_information'.'/0/'.encrypt($info[$i]["id"]).'"><img width="12" height="12" alt="Edit" src="images/admin/edit_inline.gif"></a>';;

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
        //echo $this->router->fetch_method();exit();
		try
        {
            $this->data['title']="Automail Management";////Browser Title
            $this->data['heading']="Add automail";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="add";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["txt_subject"]= trim($this->input->post("txt_subject"));
				$posted["txt_content"]= trim($this->input->post("txt_content"));
				$i_active_val = trim($this->input->post("i_automail_is_active"));
                $posted["i_automail_is_active"]= ($i_active_val==1)?$i_active_val:2;
                $posted["h_mode"]= $this->data['mode'];
                $posted["h_id"]= "";
				
				
                $this->form_validation->set_rules('txt_subject', 'automail Subject', 'required');
                $this->form_validation->set_rules('txt_content', 'automail description', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
                    $info["s_subject"]=$posted["txt_subject"];
                    $info["s_content"]=$posted["txt_content"];
					$info["i_status"]=$posted["i_automail_is_active"];
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
            $this->render("auto_mail/add-edit");
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
    public function modify_information($type=NULL,$i_id=0)
    {
          
        try
        {
            $this->data['title']="Edit Automail Details";////Browser Title
            $this->data['heading']="Edit automail";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]= $this->data['mode'];
				$posted["txt_subject"]= trim($this->input->post("txt_subject"));
                $posted["txt_content"]= trim($this->input->post("txt_content"));
				$i_active_val = trim($this->input->post("i_automail_is_active"));
                $posted["i_automail_is_active"]= ($i_active_val==1)?$i_active_val:2;
				
                $posted["h_id"]= trim($this->input->post("h_id"));
				
				
                //$this->form_validation->set_rules('txt_milestones_year', 'Newsletter year', 'required|integer|max_length[4]');
                $this->form_validation->set_rules('txt_subject', 'Automail subject', 'required');
                $this->form_validation->set_rules('txt_content', 'Automail description', 'required');
             
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["s_subject"]=$posted["txt_subject"];
                    $info["s_content"]=$posted["txt_content"];
					$info["i_status"]=$posted["i_automail_is_active"];
                    $info["dt_entry_date"]=strtotime(date("Y-m-d H:i:s"));

                    
                    $i_aff=$this->mod_rect->edit_info($info,decrypt($posted["h_id"]));
                    if($i_aff)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
						
						if(decrypt($type))
							redirect($this->pathtoclass."show_param_list/".$type);
						else
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
				
				$this->data["edit_action"]= (decrypt($type)) ? $this->pathtoclass.'modify_information'.'/'.$type : '';
                $info=$this->mod_rect->fetch_this(decrypt($i_id));
                $posted=array();
				$posted["txt_subject"]= trim($info["s_subject"]);
				$posted["txt_content"]= trim($info["s_content"]);
				$posted["i_automail_is_active"]= trim($info["i_is_active"]);
				$posted["dt_created_on"]= trim($info["dt_created_on"]);
				$posted["h_id"]= $i_id;
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("auto_mail/add-edit");
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
					$temp["s_subject"]= trim($info["s_subject"]);
					$temp["s_content"]= trim($info["s_content"]);
					$temp["dt_created_on"]= trim($info["dt_created_on"]);
					$temp["s_status"]= trim($info["s_is_active"]);

					$this->data["info"]=$temp;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            
            $this->render("auto_mail/show_detail",TRUE);
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
                    ." n.s_subject='".$posted["duplicate_value"]."'";
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
	
	public function send($id)
	{
		try
		{
			
            $this->data['title']="Newsletter Management";////Browser Title
            $this->data['heading']="Send Newsletter";
            $this->data['pathtoclass']=$this->pathtoclass;
			$this->data['maxEmailAllowed'] = $this->config->item('max_email_allowed_in_newsletter');
            $this->data['mode']="send";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
				
                $posted["txt_to"]= trim($this->input->post("txt_to"));
                $posted["h_mode"]= $this->data['mode'];
                $posted["h_id"]= trim($this->input->post("h_id"));
				
                $this->form_validation->set_rules('txt_to', 'to email address', 'txt_to');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
					$info = $this->mod_rect->fetch_this(decrypt($posted["h_id"]));
					
                    $info["s_subject"]=$info["s_subject"];
                    $info["s_content"]=$info["s_content"];
					
					// Send Email starts
					$this->load->library('email');
					$config['protocol'] = 'sendmail';
					$config['mailpath'] = '/usr/sbin/sendmail';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					$config['mailtype'] = 'html';
					
					$this->email->initialize($config);
					
					 $this->email->clear();

					$this->email->to($posted["txt_to"]);
					$this->email->from('your@example.com');
					$this->email->subject($info["s_subject"]);
					$this->email->message($info["s_content"]);
					if(SITE_FOR_LIVE)///For live site
					{
						$i_newid = $this->email->send();
					}
					else{
						$i_newid = TRUE;				
					}
					
					// End Send Email starts
                   
                    if($i_newid)////saved successfully
                    {
                        set_success_msg($this->cls_msg["send_succ"]);
                        redirect($this->pathtoclass."show_list");
                    }
                    else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["send_err"]);
                    }
                    
                }
            }
            ////////////end Submitted Form///////////
			$this->data["h_id"]= $id;
            $this->render("newsletter/send");
        
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
			//echo encrypt('professional');
			if(decrypt($type)=='buyer')
			{
				$this->data['heading']= "Client's"." Automail";
			}
			else if(decrypt($type)=='tradesman')
			{
				$this->data['heading']= "Service Professional's"." Automail";
			}
			else
            $this->data['heading']= ucfirst(decrypt($type))." Automail";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_milestones_title=($this->input->post("h_search")?$this->input->post("txt_subject"):$this->session->userdata("txt_subject")); 
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.s_type='".decrypt($type)."' And n.i_status=1 ";
            if($s_search=="basic")
            {
                $s_where .=" AND n.s_subject LIKE '%".get_formatted_string($s_milestones_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_subject",$s_milestones_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_subject"]=$s_milestones_title;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
                $s_where .=" AND n.s_subject LIKE '%".get_formatted_string($s_milestones_title)."%' ";
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.dt_entry_date , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_subject",$s_milestones_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_subject"]=$s_milestones_title;                
                $this->data["txt_created_on"]=$dt_created_on;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_subject");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_subject"]="";                
                $this->data["txt_created_on"]="";             
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
			
			/* need to reassign the following value for extra param i.e $type*/
			
            $this->i_uri_seg = intval($this->i_uri_seg + 1);
            //$this->i_admin_page_limit = 2;
			
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
            $table_view["caption"]="Automail";
            $table_view["total_rows"]=count($info);
			$table_view["param_type"]=$type; // need to send to create baseurl for pagination

			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
                        
            $table_view["headers"][0]["width"]	="25%";
            $table_view["headers"][0]["align"]	="left";
            $table_view["headers"][0]["val"]	="Subject";
			//$table_view["headers"][1]["val"]	="";
			$table_view["headers"][2]["val"]	="Key";
			$table_view["headers"][3]["val"]	="Type";
			$table_view["headers"][4]["val"]	="Edit";
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_subject"];
				//$table_view["tablerows"][$i][$i_col++]	='';
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_key_dispaly"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_type"];
				$table_view["tablerows"][$i][$i_col++]	='<a alt="Edit Information" value="'.encrypt($info[$i]["id"]).'" id="btn_edit_'.$info[$i]["id"].'" href="'.$this->pathtoclass.'modify_information'.'/'.$type.'/'.encrypt($info[$i]["id"]).'"><img width="12" height="12" alt="Edit" src="images/admin/edit_inline.gif"></a>';
				//$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_is_active"];

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_param_table($table_view,TRUE);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method().'/'.$type;///used for search form action
            //$this->data["edit_action"]=$this->pathtoclass.'modify_information'.'/'.$type;///used for search form action
            
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