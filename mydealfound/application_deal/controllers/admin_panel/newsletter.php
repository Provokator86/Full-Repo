<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 23 Sept 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For Newsletter
* 
* @package Content Management
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
    public $uploaddir;
    public $thumbdir;
    public $showimgdir;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="Newsletter Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]="No information found about newsletter.";
          $this->cls_msg["save_err"]="Information about newsletter failed to save.";
          $this->cls_msg["save_succ"]="Information about newsletter saved successfully.";
          $this->cls_msg["delete_err"]="Information about newsletter failed to remove.";
          $this->cls_msg["delete_succ"]="Information about newsletter removed successfully.";
		  $this->cls_msg["send_err"]="Newsletter not delivered.";
          $this->cls_msg["send_succ"]="Newsletter delivered successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("newsletter_model","mod_rect");
		  $this->load->model("store_model");
		  $this->load->model("newsletter_subscribers_model");
		  //////// end loading default model here //////////////
		  $this->allowedExt									= 'csv';
		  $this->uploaddir 									= $this->config->item('CSV_UPLOAD_PATH');
		  
		  $this->data['store']	= $this->store_model->get_store();
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
            $s_milestones_title=($this->input->post("h_search")?$this->input->post("txt_subject"):$this->session->userdata("txt_subject")); 
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where="WHERE i_del_status != 2 ";
            if($s_search=="basic")
            {
                $s_where.=" AND n.s_subject LIKE '%".get_formatted_string($s_milestones_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_subject",$s_milestones_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_subject"]=$s_milestones_title;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
                $s_where.=" AND n.s_subject LIKE '%".get_formatted_string($s_milestones_title)."%' ";
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
                $s_where="WHERE i_del_status != 2 ";
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
            
            $arr_sort = array(0=>'s_subject',1=>'dt_entry_date',2=>'i_status',3=>'i_send_date'); 
			$s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
            
            
            $limit	= $this->i_admin_page_limit;
            //$info	= $this->mod_rect->fetch_multi($s_where,intval($start),$limit);
			$info	= $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			//pr($info);
            /////////Creating List view for displaying/////////
            $table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Newsletter";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method(); 
            $table_view["detail_view"]= FALSE; 
			            
            $table_view["headers"][0]["width"]	="30%";
            $table_view["headers"][0]["align"]	="left";
			$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][0]["val"]	="Newsletter Title";
			$table_view["headers"][1]["sort"]	= array('field_name'=>encrypt($arr_sort[1]));
            $table_view["headers"][1]["val"]	="Created On"; 
			$table_view["headers"][2]["val"]	="Send On";
			$table_view["headers"][2]["sort"]	= array('field_name'=>encrypt($arr_sort[3]));
			$table_view["headers"][3]["val"]	="Store"; 
			//$table_view["headers"][3]["val"]	="";  
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {	
				$store_name=$this->store_model->fetch_this($info[$i]["i_store_id"]);
				//pr($store_name);
				$store=$store_name[0]['s_store_title'];
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_subject"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_send_on"];
				$table_view["tablerows"][$i][$i_col++]	=($store=='')?'N/A':$store;
				//$table_view["tablerows"][$i][$i_col++]	= '<a title="Send newsletter" href="'.admin_base_url().'newsletter/send/'.encrypt($info[$i]["id"]).'">'.'SEND'.'</a>';

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
            $this->data['title']="Newsletter Management";////Browser Title
            $this->data['heading']="Add Newsletter";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="add";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["txt_subject"]	=	trim($this->input->post("txt_subject"));
                $posted["txt_content"]	=	trim($this->input->post("txt_content"));
                $posted["i_all"]		=	trim($this->input->post("i_all"));
                $posted["i_user"]		=	trim($this->input->post("i_user"));
                $posted["i_general"]            =	trim($this->input->post("i_general"));
                $posted["i_send_date"]          =	trim($this->input->post("i_send_date"));
				$posted["i_store_id"]          	=	trim($this->input->post("i_store_id"));
				$posted["i_send_to"]          	=	trim($this->input->post("i_send_to"));
                $posted["h_mode"]= $this->data['mode'];
                $posted["h_id"]= "";
                if(!empty($posted["i_all"]))
                {
                        $str = "1,2";
                }
                else
                {
                        $array = array($posted["i_user"],$posted["i_general"]);
                        $str = implode(",", $array);
                }
                $comma_separated = format_csv_string($str); // to get the like 1,2,3 i.e.

                $this->form_validation->set_rules('txt_subject', 'newsletter Subject', 'required');
                $this->form_validation->set_rules('txt_content', 'newsletter description', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
                    $info["s_subject"]		=	$posted["txt_subject"];
                    $info["s_content"]		=	$posted["txt_content"];
					$info["i_store_id"]		=	$posted["i_store_id"];
					$info["i_send_to"]		=	$posted["i_send_to"];
					
					$info["i_user_type"] 	=	$comma_separated;
					
					$info["i_send_date"]	=	strtotime($posted["i_send_date"]);
                    $info["dt_entry_date"]	=	strtotime(date("Y-m-d H:i:s"));
					$send_date=$info["dt_entry_date"];
                    $i_newid = $this->mod_rect->add_info($info);
					
					
                    if($i_newid)////saved successfully
                    {	
						if($info['i_store_id']=='k' && $_FILES)
						{
						$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'s_file','','',$this->allowedExt);
						$this->upload_csv($i_newid,$send_date);
						
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
				$posted["txt_subject"]	= 	trim($this->input->post("txt_subject"));
				$posted["txt_content"]	= 	trim($this->input->post("txt_content"));
				$posted["i_store_id"]	= 	trim($this->input->post("i_store_id"));
				$posted["i_send_to"]	= 	trim($this->input->post("i_send_to"));
				
				$posted["i_all"]		=	trim($this->input->post("i_all"));
				$posted["i_user"]		=	trim($this->input->post("i_user"));
				$posted["i_general"]	=	trim($this->input->post("i_general"));
				
				$posted["i_send_date"]	=	trim($this->input->post("i_send_date"));
				$posted["h_id"]			= 	trim($this->input->post("h_id"));
				
				if(!empty($posted["i_all"]))
				{
					$str = "1,2";
				}
				else
				{
				$array = array($posted["i_user"],$posted["i_general"]);
				$str = implode(",", $array);
				}
				
				$comma_separated = format_csv_string($str); // to get the values like 1,2,3 i.e.
                
                $this->form_validation->set_rules('txt_subject', 'Newsletter title', 'required');
                $this->form_validation->set_rules('txt_content', 'Newsletter description', 'required');
             
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
                    $info["s_subject"]		=$posted["txt_subject"];
                    $info["s_content"]		=$posted["txt_content"];
					$info["i_store_id"]		=$posted["i_store_id"];
					$info["i_send_to"]		=$posted["i_send_to"];
                    $info["dt_entry_date"]	=	time();
                    $info["i_user_type"] 	=	$comma_separated;					
                    $info["i_send_date"]	=	strtotime($posted["i_send_date"]);

                    $send_date = $info["i_send_date"];
                    $i_aff=$this->mod_rect->edit_info($info,decrypt($posted["h_id"]));
                    if($i_aff)////saved successfully
                    {   
					    if($info['i_store_id']=='k')
						{
						$this->update_csv_upload(decrypt($posted["h_id"]),$send_date);
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
				$posted["txt_subject"]	= trim($info["s_subject"]);
				$posted["txt_content"]	= trim($info["s_content"]);
				$posted["i_store_id"]	= trim($info["i_store_id"]);
				$posted["i_send_to"]		= trim($info["i_send_to"]);
				
				$posted["i_user_type"] = trim($info["i_user_type"]);
				
				$comma_separated = explode(',',$posted["i_user_type"]);
                                $i_all=count($comma_separated);
                                if($i_all==2)
				$posted["i_all"] = 3;
				foreach($comma_separated as $val)
				{
					if($val==1){$posted["i_user"]=1;}
					if($val==2){$posted["i_general"]=2;}
				}				
				
				$posted["dt_send_on"]	= trim($info["send_on"]);
				$posted["dt_created_on"]= trim($info["dt_created_on"]);
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
					$temp["dt_send_on"]= trim($info["dt_send_on"]);

					$this->data["info"]=$temp;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            
            $this->render("newsletter/show_detail",TRUE);
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
	
	
	
public function upload_csv($i_nl_id,$date)
    {
		
        try
        {
			
           if($_POST && $_FILES)
		   {
			     $tmp_name           =  $_FILES['s_file']['tmp_name']; // temp path
				 $files           	 =  $_FILES['s_file']['name'];		// name of file with extension
				 $filesize           =  $_FILES['s_file']['size'];		// size of file
				 $filetype           =  $_FILES['s_file']['type'];
				 
				 $allowedType = array('text/x-tab-separated-values', 'text/tab-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel','text/x-csv');
				$ct = 0;
				$files_ext=end(explode('.',$files));
				
				if($filesize >70240000 || $files_ext!='csv' )
				{
					if($filesize >70240000)
					{
					set_error_msg ('upload a file which is smaller than 60 MB');
					}
					if($files_ext!='csv')
					{
						set_error_msg ('Please upload a csv file');
					}
					redirect(admin_base_url().'newsletter/show_list');
				}
	
				else
				{
					 if (($handle = fopen($tmp_name, "r")) !== FALSE) {
						# Set the parent multidimensional array key to 0.
						$nn = 0;
						while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { 
							# Count the total keys in the row.
							$c = count($data);
							# Populate the multidimensional array.
							for ($x=0;$x<$c;$x++)
							{
								$csvarray[$nn][$x] = $data[$x];					
							}
							$nn++;
						}
						# Close the File.
						fclose($handle);
					}
					
					for($i=1;$i<count($csvarray);$i++)
					{ 
						 	$data = $csvarray[$i];
							$info=array();
						
						
						
						$info["s_mail_id"]				= $data[0];
						$info["i_newsletter_id"] 		= $i_nl_id;
						$info["dt_date_of_send"]  		= $date;
						
						
						 
							if(!empty($info["i_newsletter_id"]))
							{
									
									if(!empty($info["i_newsletter_id"]))
									{
										$sql = "INSERT INTO cd_newsletter_csv_mail_list
												 (s_mail_id,dt_date_of_send,i_newsletter_id) 
												VALUES ('".addslashes(trim($info["s_mail_id"]))."','".$info["dt_date_of_send"]."',
												'".$info["i_newsletter_id"]."'
												)";						
									
										$res	=	$this->db->query($sql);
										$i_id   = $this->db->insert_id();
											
									}
									else
									{								
										$row	=	mysql_fetch_assoc($result);
										$ins_id	=	$row['i_id'];					
									}
							}
					}	// end of for loop
					
						
					set_success_msg('File uploaded');		
						redirect(admin_base_url().'newsletter/show_list');	
				}	// end of else part
		   }
		   set_error_msg('Upload a File');
		   redirect(admin_base_url().'newsletter/show_list');
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    
		
		
		
		
		}
	
	

public function update_csv_upload($i_nl_id,$date)
{	
	try
	{
		
	   if($_POST && $_FILES)
	   {
			 $tmp_name           =  $_FILES['s_file']['tmp_name']; // temp path
			 $files           	 =  $_FILES['s_file']['name'];		// name of file with extension
			 $filesize           =  $_FILES['s_file']['size'];		// size of file
			 $filetype           =  $_FILES['s_file']['type'];
			 
			 $allowedType = array('text/x-tab-separated-values', 'text/tab-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel','text/x-csv');
			$ct = 0;
			$files_ext=end(explode('.',$files));
			
			if($filesize >70240000 || $files_ext!='csv' )
			{
				if($filesize >70240000)
				{
				set_error_msg ('upload a file which is smaller than 60 MB');
				}
				if($files_ext!='csv')
				{
					set_error_msg ('Please upload a csv file');
				}
				redirect(admin_base_url().'newsletter/show_list');
			}

			else
			{
				 if (($handle = fopen($tmp_name, "r")) !== FALSE) {
					# Set the parent multidimensional array key to 0.
					$nn = 0;
					while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { 
						# Count the total keys in the row.
						$c = count($data);
						# Populate the multidimensional array.
						for ($x=0;$x<$c;$x++)
						{
							$csvarray[$nn][$x] = $data[$x];					
						}
						$nn++;
					}
					# Close the File.
					fclose($handle);
				}
				
				
				$sql = "DELETE FROM cd_newsletter_csv_mail_list WHERE i_newsletter_id = '".$i_nl_id."' ";
						
				$rs = $this->db->query($sql);
				
				for($i=1;$i<count($csvarray);$i++)
				{ 
					$data = $csvarray[$i];
					$info=array();
					
					
					$info["s_mail_id"]				= $data[0];
					$info["i_newsletter_id"] 		= $i_nl_id;
					$info["dt_date_of_send"]  		= $date;
					 
					if(!empty($info["i_newsletter_id"]))
					{
						
						
						/*$sq = "SELECT i_id FROM cd_newsletter_csv_mail_list WHERE s_mail_id = '".addslashes(trim($info["s_mail_id"]))."' AND i_newsletter_id = '".$info["i_newsletter_id"]."' ";
						
						$rs = $this->db->query($sql);
						$rslt = $rs->result_array();
						
						if(count($rslt)==0)
						{*/
							
							if(!empty($info["s_mail_id"]))
							{
								$sql = "INSERT INTO cd_newsletter_csv_mail_list
										 (s_mail_id,dt_date_of_send,i_newsletter_id) 
										VALUES ('".addslashes(trim($info["s_mail_id"]))."','".$info["dt_date_of_send"]."',
										'".$info["i_newsletter_id"]."'
										)";						
							
								$res	=	$this->db->query($sql);
								$i_id   = $this->db->insert_id();
									
							}
							else
							{								
								$row	=	mysql_fetch_assoc($result);
								$ins_id	=	$row['i_id'];					
							}
						/*}
						else
						{
							$i_id = $rslt[0]["i_id"];
							
							$up_sql = "UPDATE cd_newsletter_csv_mail_list SET s_mail_id = '".addslashes(trim($info["s_mail_id"]))."' WHERE i_id = '".$i_id."' ";
							
							$res	=	$this->db->query($up_sql);
						}*/
					}
				}	// end of for loop
				
					
				set_success_msg('File uploaded');		
					redirect(admin_base_url().'newsletter/show_list');	
			}	// end of else part
	   }
	   set_error_msg('Upload a File');
	   redirect(admin_base_url().'newsletter/show_list');
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}         

	
	
	
	
	}
		

	
	public function send()
	{
		try
		{
			
            $this->data['title']="Newsletter Management";////Browser Title
            $this->data['heading']="Send Newsletter";
            $this->data['pathtoclass']=$this->pathtoclass;
			$this->data['maxEmailAllowed'] = $this->config->item('max_email_allowed_in_newsletter');
            $this->data['mode']="send";
			
			

            ////////////Submitted Form///////////
			//pr($_POST);exit;
            if($_POST)
            {	
			
				$posted=array();
				
                $posted["i_store_id"]= trim($this->input->post("i_store_id"));
				$posted["txt_subject"]= trim($this->input->post("txt_subject"));
				$posted["txt_content"]= trim($this->input->post("txt_content"));
				$posted["i_send_to"]= trim($this->input->post("i_send_to"));
				$posted["i_store_id"]= trim($this->input->post("i_store_id"));
				
				
				//pr($posted,1);
				if(isset($_FILES['s_file']) && !empty($_FILES['s_file']['name']))
				{
					$tmp_name           =  $_FILES['s_file']['tmp_name'];
				 if (($handle = fopen($tmp_name, "r")) !== FALSE) {
						# Set the parent multidimensional array key to 0.
						$nn = 0;
						while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { 
							# Count the total keys in the row.
							$c = count($data);
							# Populate the multidimensional array.
							for ($x=0;$x<$c;$x++)
							{
								$csvarray[$nn][$x] = $data[$x];					
							}
							$nn++;
						}
					# Close the File.
					fclose($handle);
					
				}
				
					//pr($data);
					
				$send_to	=	array();	
					for($i=1;$i<count($csvarray);$i++)
				{ 
					
					
					
					$send_to[]	= $csvarray[$i][0];
					
					
				
				}
						$newsletter_msg = $posted['txt_content'];
						$filename 	= $this->config->item('EMAILBODYHTML')."common.html";
						$handle 	= @fopen($filename, "r");
						$mail_html 	= @fread($handle, filesize($filename));
						$send_status=0;
						//echo 'Hello<br>=='; 
						 //sendMail("arkamitra01@gmail.com",'hii','helo');
						 //exit;
					//pr($send_to,1);
					for($i=0;$i<count($send_to);$i++)
					{
						
							$to = $send_to[$i];
							 $newsletter_subject = $posted["txt_subject"];
							 $newsletter_msg 	 = $posted["txt_content"];	
							 							 
							 $html = str_replace("###SITE_URL###",base_url(),$mail_html);	
							 $html = str_replace("###MAIL_BODY###",$newsletter_msg,$html);		
							 //echo $html;exit;
							// mail($to, $newsletter_subject, $html);
							//echo $to."<br>".$newsletter_subject."<br>".$html;exit;
							//$i_sent=sendMail("mrinsss@gmail.com", $newsletter_subject, $html);
							//pr($i_sent,1);
							//echo '===>'.$i_sent; exit;
							// exit;
							 if(sendMail($to, $newsletter_subject, $html))
							 {
							 	$send_status=1;
							 }
							else
							 {
								 set_error_msg("Mail sending failed to".$to);
							 }
							 
							 
					}
					if($send_status)
					 {
						 set_success_msg("Mail sent");
					 }
					
					
				
			}
				
				
			
				
				if($posted["i_store_id"]!=0)
				{
					$mail_id=$this->newsletter_subscribers_model->get_mail_id_for_store($posted["i_store_id"]);
					//pr($mail_id,1);
					if(!empty($mail_id))
					{
						$newsletter_msg = $posted['txt_content'];
						$filename 	= $this->config->item('EMAILBODYHTML')."common.html";
						$handle 	= @fopen($filename, "r");
						$mail_html 	= @fread($handle, filesize($filename));
						//pr()
						$send_status=0;
						foreach($mail_id as $val)
						{
							 $to = $val["s_email"];
							 $newsletter_subject = $posted["txt_subject"];
							 $newsletter_msg 	 = $posted["txt_content"];	
							 							 
							 $html = str_replace("###SITE_URL###",base_url(),$mail_html);	
							 $html = str_replace("###MAIL_BODY###",$newsletter_msg,$html);		
							 
							 sendMail($to, $newsletter_subject, $html);
							 if(sendMail)
							 {
							 	$send_status=1;
							 }
							else
							 {
								 set_error_msg("Mail sending failed to".$to);
							 }
							 
						}
							if($send_status)
							 {
								 set_success_msg("Mail sent");
							 }
						
					}
				}
					
					if($posted["i_send_to"]==1)
					{		
						//pr($posted,1);
						$mail_id=$this->newsletter_subscribers_model->get_all_mail_id();
						//pr($mail_id,1);
						if(!empty($mail_id))
						{
							$newsletter_msg = $posted['txt_content'];
							$filename 	= $this->config->item('EMAILBODYHTML')."common.html";
							$handle 	= @fopen($filename, "r");
							$mail_html 	= @fread($handle, filesize($filename));
							$send_status=0;
							foreach($mail_id as $val)
							{
								 $to = $val["s_email"];
								 $newsletter_subject = $posted["txt_subject"];
								 $newsletter_msg 	 = $posted["txt_content"];	
															 
								 $html = str_replace("[###SITE_URL###]",base_url(),$mail_html);	
								 $html = str_replace("[###MAIL_BODY###]",$newsletter_msg,$html);		
								 
								 sendMail($to, $newsletter_subject, $html);
								 if(sendMail)
								 {
									$send_status=1;
								 }
								else
								 {
									 set_error_msg("Mail sending failed to".$to);
								 }
								 
							}
							if($send_status)
							 {
								 set_success_msg("Mail sent");
							 }
							
							
							
						}
					
					
					
				
				
				}
			}
            
            ////////////end Submitted Form///////////
			$this->data["h_id"]= $id;
            //$this->render("newsletter/show_list");
			redirect(base_url().'coupondesh_controlpanel/newsletter');
        
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