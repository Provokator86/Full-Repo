<?php
/*********
* Author: Koushik
* Email: koushik.r@acumensoft.info
* Date  : 04 July 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For Newsletter
* 
* @package Email
* @subpackage Newsletter
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/newsletter_model.php
* @link views/admin/newsletter/
*/


class Newsletter extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
   
    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="Newsletter Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	= "No information found about newsletter.";
          $this->cls_msg["save_err"]	= "Information about newsletter failed to save.";
          $this->cls_msg["save_succ"]	= "Information about newsletter saved successfully.";
          $this->cls_msg["delete_err"]	= "Information about newsletter failed to remove.";
          $this->cls_msg["delete_succ"]	= "Information about newsletter removed successfully.";
		  $this->cls_msg["send_err"]	= "Newsletter not delivered.";
          $this->cls_msg["send_succ"]	= "Newsletter delivered successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("newsletter_model","mod_rect");
		  $this->load->model("newsletter_subscribers_model","mod_subscribers");
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
            $this->data['heading']="Newsletter";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title=($this->input->post("h_search")?$this->input->post("txt_title"):$this->session->userdata("txt_title")); 
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE 1 ";
            if($s_search=="advanced")
            {
                if($s_title)
                {
                    $s_where.=" AND n.s_subject LIKE '%".get_formatted_string($s_title)."%' ";
                }
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.dt_created_on , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_title",$s_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_title"]=$s_title;                
                $this->data["txt_created_on"]=$dt_created_on;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" ";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_title");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_title"]="";                
                $this->data["txt_created_on"]="";             
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_title,$dt_created_on);
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
            
            $arr_sort = array(0=>'s_subject',1=>'dt_created_on'); 
			$s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[1]:$arr_sort[1];
            
            
            $limit	= $this->i_admin_page_limit;
			$info	= $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			//pr($info,1);
            /////////Creating List view for displaying/////////
            $table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[1]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Newsletter";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method(); 
            $table_view["detail_view"]           =  false;  //   to disable show details.   
                        
                       
            $table_view["headers"][0]["width"]    = "20%";
            $table_view["headers"][0]["align"]    = "left";
            $table_view["headers"][0]["sort"]     = array('field_name'=>encrypt($arr_sort[0]));     
            $table_view["headers"][0]["val"]      = "Subject";
            $table_view["headers"][1]["val"]      = "Content";
            $table_view["headers"][2]["sort"]    = array('field_name'=>encrypt($arr_sort[1])); 
            $table_view["headers"][2]["val"]      = "Created On"; 
			
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	=   encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]  =   $info[$i]["s_subject"];
                $table_view["tablerows"][$i][$i_col++]	=   $info[$i]["s_content"];
                $table_view["tablerows"][$i][$i_col++]	=   $info[$i]["dt_created_on"];
				
				$action ='';
				$action .= '<a target="_blank"  href="'.admin_base_url().'newsletter/broadcast/'.encrypt($info[$i]["id"]).'"><img width="12" height="12" title="Broadcast" alt="Broadcast" src="images/admin/broadcast.png"></a>&nbsp;';
				
				if($action!='')
                {
                    $table_view["rows_action"][$i]    = $action;     
                }

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            
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
            $this->data['title']="Newsletter Management";////Browser Title
            $this->data['heading']="Add Newsletter";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="add";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["txt_subject"]	=	trim($this->input->post("txt_subject"));
                $posted["ta_content"]    =    trim($this->input->post("ta_content"));

                $posted["h_mode"]= $this->data['mode'];
                $posted["h_id"]= "";
				

				
                $this->form_validation->set_rules('txt_subject', 'newsletter Subject', 'required');
                $this->form_validation->set_rules('ta_content', 'newsletter description', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
                    $info["s_subject"]		=	$posted["txt_subject"];
                    $info["s_content"]		=	$posted["ta_content"];	
					$info["i_status"]	    =	1  ;
                    $info["dt_created_on"]	=	time() ;

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
			
			
            $this->render("newsletter/add-edit");
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
            $this->data['title']="Edit Newsletter Details";////Browser Title
            $this->data['heading']="Edit Newsletter";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]= $this->data['mode'];
				$posted["txt_subject"]= trim($this->input->post("txt_subject"));
                $posted["ta_content"]= trim($this->input->post("ta_content"));
                $posted["h_id"]= trim($this->input->post("h_id"));

                
                $this->form_validation->set_rules('txt_subject', 'Newsletter title', 'required');
                $this->form_validation->set_rules('ta_content', 'Newsletter description', 'required');
             
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["s_subject"]      =   $posted["txt_subject"];
                    $info["s_content"]      =   $posted["ta_content"];
					$info["i_status"] 	    =	1;					
					$info["dt_updated_on"]	=	time();

                    
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
				$posted["txt_subject"]	= trim($info["s_subject"]);
				$posted["ta_content"]	= trim($info["s_content"]);
				$posted["h_id"]= $i_id;
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("newsletter/add-edit");
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
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	
	/** broadcast of a newsletter
	 *
	 * @param int $i_newsletter_id
	 */
	public function broadcast($i_id=0)
    {
        try
        {
			$this->data['title']  ="Newsletter Broadcast";////Browser Title
            $this->data['heading']="Broadcast Newsletter";
            $this->data['pathtoclass']=$this->pathtoclass;
			
            $i_newsletter_id = decrypt($i_id);
			$newsletter_content = $this->mod_rect->fetch_this($i_newsletter_id);
			//pr($newsletter_content,1);
			$s_where 		= " WHERE n.i_failure_count<=10 ";
			$subscribers	=	$this->mod_subscribers->fetch_multi($s_where);
			
			$filename		=   $this->config->item('EMAILBODYHTML')."newsletter.html";
		    $handle			=   @fopen($filename, "r");
		    $mail_html		=   @fread($handle, filesize($filename));  
			
			$s_subject		=	$newsletter_content["s_subject"];
			
			$mail_html 		= str_replace("###SITE_URL###",base_url(),$mail_html);    
            $mail_html 		= str_replace("###MAIL_BODY###",$newsletter_content["s_content"],$mail_html);
			
			if(!empty($subscribers))
			{
				$this->load->model('common_model','mod_common');
				foreach($subscribers as $val)
					{
						$to_email 	= $val["s_email"];						
						$mail_html	= str_replace("###UNSUBSCRIBE_URL###",base_url().'unsubscribe/'.encrypt($to_email),$mail_html);
						
						$arr	= array();
						$arr["s_from_email"] 	= $this->s_admin_email;
						$arr["s_to_emails"] 	= $val["s_email"];
						$arr["s_subject"]		= $s_subject;
						$arr["s_body"]			= $mail_html;
						$arr["dt_posted_in_log"]= date("Y-m-d H:i:s");
						//pr($arr,1);
						$s_table 				= $this->db->EMAILLOG;
						//$arr_where				= array('s_to_emails'=>$val["s_email"]);
						$arr_where				= " WHERE s_to_emails = '".$val["s_email"]."' ";
						$i_exist 				= $this->mod_common->common_count_rows($s_table,$arr_where);
						if(!$i_exist)
						{
							$i_newid			= $this->mod_common->common_add_info($s_table,$arr);
							if($i_newid)
							{
								 set_success_msg($this->cls_msg["save_succ"]);
							}
						}
						
					}
			}
			
			$this->render("newsletter/broadcast");
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