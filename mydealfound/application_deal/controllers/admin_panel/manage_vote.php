<?php
/*********
* Author: Arka 
* Date  : jan 2013
* Modified By: 
* Modified Date:
* 
* Purpose:
* Controller For manage coupons
* 
* @package Content Management
* @subpackage site_setting
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/manage_coupons_model.php
* @link views/admin/manage_coupons/
*/

class Manage_vote extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public $uploaddir;
	public $allowedExt;	
	//public $user_type = 2;
	
    public function __construct()
    {
        try
        {
          parent::__construct();
          ////////Define Errors Here//////
          $this->data['title']="Manage ";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]				= "No information found about admin site setting.";
          $this->cls_msg["save_err"]				= "Admin site setting failed to save.";
          $this->cls_msg["save_succ"]				= "Saved successfully.";
          $this->cls_msg["delete_err"]				= "Vote failed to remove.";
          $this->cls_msg["delete_succ"]				= "Vote removed successfully.";
		  $this->cls_msg["img_upload_err"]			= "Image cannot be uploded.";
		  $this->cls_msg["database_err"]			= "Failed to insert in the database.Try Again";
          ////////end Define Errors Here//////
		  		$this->pathtoclass 					= admin_base_url().$this->router->fetch_class()."/";
		  		$this->session->unset_userdata("s_category");
		  			  
		 	$this->data['action_allowed']["Status"]	= TRUE;///////////////////////////////////////////exp
          	$this->load->model("vote_model");
			$this->load->model("coupon_model");
			$this->load->model("store_model");
		  
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
			
            $this->data['title']		=	"Manage ";////Browser Title
            $this->data['heading']		=	"Manage ";
			
			redirect($this->pathtoclass.'show_list');
            
            
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
		try
        {
          	$this->data['title']				= "Category Management";////Browser Title
            $this->data['heading']				= "Add category ";
            $this->data['pathtoclass']			= $this->pathtoclass;
            $this->data['mode']					= "add";
			
			if($_POST)
        {
				//print_r($_POST);
				$this->form_validation->set_rules('s_category','category name','required');
				
			 if($this->form_validation->run() == FALSE)	
			 {	
				$this->data['posted'] = $_POST;
			 }
              
			  
        else
           {
					
                    $info	= array(										
										"s_category"									=> $this->input->post("s_category"),
										"i_status"										=> $this->input->post("i_status")
										
									);
					$inserted_user_id	= $this->vote_model->add_info($info);					
					
					
					if($inserted_user_id)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list");
                    }
					else
					{
						
					}
					
                }
                
            }
            ////////////end Submitted Form///////////
            $this->render("manage_category/add-edit");
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
    { //echo $i_id;
          
        try
        { //echo "12"."$i_td";
			
            $this->data['title']		="Edit category";////Browser Title
            $this->data['heading']		="Edit category";
            $this->data['pathtoclass']	=$this->pathtoclass;
            $this->data['mode']			="edit";
			
            ////////////Submitted Form///////////
            if($_POST)
            {	
				$posted=array();
                $posted["h_mode"]				= $this->data['mode'];
				$posted["s_category"]			= trim($this->input->post("s_category"));	
				$posted["i_status"]				= trim($this->input->post("i_status"));
				$posted["h_id"]					= trim($this->input->post("h_id"));
				
				//print_r($posted);
				$this->form_validation->set_rules('s_category',' Title','required');
				
                if($this->form_validation->run() == FALSE)////invalid
                {
                    //////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;       
                }
                else///validated, now save into DB
                {
					$info	=	array();
					$info["s_category"]			=	$posted["s_category"];
					$info["i_status"]			=	$posted["i_status"];
					
                   

                    
                    $i_aff=$this->vote_model->edit_info($info, decrypt($posted["h_id"]));
                    if($i_aff)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list");
                    }
                    else///Not saved, show the form again
                    {
                        $this->data["posted"]=$posted;
                        //set_error_msg($this->cls_msg["save_err"]);
						redirect($this->pathtoclass."show_list");
                    }
                    unset($info,$posted, $i_aff);
                    
                }
            }
            else
            { 
                $info=$this->vote_model->fetch_this(decrypt($i_id));		
						
                $posted=array();
				$posted["s_category"]	= trim($info[0]["s_category"]);
				$posted["i_status"]		= trim($info[0]["i_status"]);
				$posted["h_id"]= $i_id;
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("manage_category/add-edit");
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
							$i_ret_=$this->vote_model->delete_info(-1);
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
							$i_ret_=$this->vote_model->delete_info(decrypt($id[$tot]));
							$tot--;
							}
							}
							elseif($id>0)///Deleting single Records
							{
							$i_ret_=$this->vote_model->delete_info(decrypt($id));
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
			//redirect (admin_base_url().'manage_store');
			echo '<script>history.back(-1)</script>';
            //redirect($this->pathtoclass."show_list".($pageno?"/".$pageno:""));
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
                $info=$this->vote_model->fetch_this(decrypt($i_id));
				
                if(!empty($info))
                {
                    $temp=array();
                    $temp["i_id"]= encrypt($info[0]["i_id"]);////Index 0 must be the encrypted PK 
					$temp["s_category"]= trim($info[0]["s_category"]);
					$temp["i_status"]= trim($info[0]["i_status"]);
					$temp["s_status"]= trim($info[0]["i_status"])==1?'Active':'Deactive';
				
					$this->data["info"]=$temp;
                    unset($temp);
					
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.7.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
          
            $this->render("manage_industry/show_detail",TRUE);
            unset($i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }	
	
	
	
	
	public function show_list($order_name='',$order_by='desc',$start=NULL,$limit=NULL)
	{
		try
        {
           
			$this->data['heading']="Voting Details";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
			
            $s_category=($this->input->post("h_search")?$this->input->post("s_category"):$this->session->userdata("s_category")); 
			//$srch_username=($this->input->post("h_search")?$this->input->post("srch_username"):$this->session->userdata("srch_username")); 
            //$srch_dt=($this->input->post("h_search")?$this->input->post("srch_dt"):$this->session->userdata("srch_dt"));
            ////////end Getting Posted or session values for search///
            
			
            // $s_where=" WHERE i_user_type=2 ";/////////////////////////1====
		
            if($s_search=="basic")
            {
                //$s_where =" WHERE (s_category LIKE '%".my_receive_like($s_category)."%' )";
				
                /////Storing search values into session///
                $this->session->set_userdata("s_category",$s_category);
				//$this->session->set_userdata("srch_username",$srch_username);
				//$this->session->set_userdata("srch_dt",$srch_dt);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_category"]=$s_category;
				//$this->data["srch_username"]=$srch_username;
				//$this->data["srch_dt"]=$srch_dt;
				//echo $s_where;*/
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
               /* $s_where .=" AND n.s_email LIKE '%".get_formatted_string($s_user_title)."%' ";
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( n.dt_created_on , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("txt_user_title",$s_user_title);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_user_title"]=$s_user_title;                
                $this->data["txt_created_on"]=$dt_created_on;     */        
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
               //$s_where=" WHERE n.id!=1 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("s_category");
                //$this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["s_category"]="";                
               // $this->data["txt_created_on"]="";             
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
			$arr_sort = array(0=>'i_id',1=>'s_title');
			$s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
            
            
            $limit	= $this->i_admin_page_limit;
            
			$info	= $this->vote_model->fetch_multi($s_where,$order_by,intval($start),$limit);///////////test
				//print_r ($info);
            /////////Creating List view for displaying/////////
			$table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]     		=	"Start up Role";
            $table_view["total_rows"]		=	count($info);
			$table_view["total_db_records"]	=	$this->vote_model->gettotal_info($s_where);
			$table_view["order_name"]		=	$order_name;
			$table_view["order_by"]  		=	$order_by;
            $table_view["src_action"]		= 	$this->pathtoclass.$this->router->fetch_method(); 
            $table_view["detail_view"]		=   FALSE;          
            $table_view["headers"][0]["width"]	="50%";
            $table_view["headers"][0]["align"]	="left";
            //$table_view["headers"][0]["val"]	="Serial Number";
			//$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][0]["val"]	="Coupon Name";
			$table_view["headers"][1]["align"]	="center";
			$table_view["headers"][1]["val"]	="IP";
			$table_view["headers"][2]["val"]	="Vote"; 
			
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                
				$info[$i]["s_is_active"] = ($info[$i]["i_status"]==1)?'Active':'Inactive';
				$name_coupon=$this->coupon_model->fetch_this($info[$i]['i_coupon_code']);
				//pr($name_coupon);
				$name=$name_coupon[0]['s_title'];
				$i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);////Index 0 must be the encrypted PK 
                //$table_view["tablerows"][$i][$i_col++]	= $info[$i]["i_id"];
				$table_view["tablerows"][$i][$i_col++]	= $name;
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_ip"];
				
				if($this->data['action_allowed']["Status"])
				{
				 	if($info[$i]["i_status"] == 1)
					{
				
                        $action ='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_inactive">
                        <img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/tick.png"></a>';
                         
					}
					else
					{ 
                        $action ='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_active">
                        <img width="12" height="12" title="Active" alt="Active" src="images/admin/reject.png"></a>';
					}
				 //$table_view["tablerows"][$i][$i_col++]	=($info[$i]["i_status"] == 1)?"Active":"Inactive";
				 $table_view["tablerows"][$i][$i_col++]	= $info[$i]["i_vote"];
				}

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit,$action); 
            
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
                $qry=" Where ".(intval($posted["id"])>0 ? " i_id!=".intval($posted["id"])." And " : "" )
                    ." s_user_email='".$posted["duplicate_value"]."'";
                $info=$this->faq_model->fetch_multi($qry,$start,$limit); /*don't change*/
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
	
	///////////////user change status/////////
	
	public function ajax_change_status()
    {
        try
        {
            
                $posted["id"]           = decrypt(trim($this->input->post("h_id")));
                $posted["i_status"]     = trim($this->input->post("i_status"));
                $info = array();
                $info['i_status']    = $posted["i_status"]  ;
                $i_rect=$this->vote_model->change_status($info,$posted["id"]); /*don't change*/				
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
	
public function show_vote($store_id)
{
	try
	{
		if(empty($store_id))
			redirect(base_url().'admin/manage_store/show_list');
		else
		{
			$this->session->set_userdata('i_store_id',$store_id);
			redirect($this->pathtoclass."show_vote_list");
		}
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	} 
}	
	
public function show_vote_list($start=0,$limit=0)
    {
        try
        {   
		    
			$this->data['title']		="Vote Details";////Browser Title
            $this->data['heading']		="Voting Details";
			
			$id = $this->session->userdata('i_store_id');
			
			$limit	= $this->i_admin_page_limit;
			//$limit	= 5;
			//$i_uri_seg =6;
			$this->i_uri_seg = 5;
			if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
               $start=$this->uri->segment($this->i_uri_seg);
            }
			
			//echo $id;exit;
			
			$info=$this->vote_model->get_vote_details($id,$start,$limit);
			//pr($info,1);
			
            			//-----------------------------------------------------------------------------------------
			
			$table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]     		 =	"Start up Role";
            $table_view["total_rows"]		  =	count($info);
			$table_view["total_db_records"]	=	$this->vote_model->gettotal_vote($id);
			$table_view["order_name"]		  =	$order_name;
			$table_view["order_by"]  		    =	$order_by;
            $table_view["src_action"]		  = 	$this->pathtoclass.$this->router->fetch_method(); 
            $table_view["detail_view"]		 =    FALSE;          
            $table_view["headers"][0]["width"] =    "25%";
            $table_view["headers"][0]["align"] =    "left";
            $table_view["headers"][0]["val"]   =    "Store Name";
			$table_view["headers"][1]["align"] =    "center";
			$table_view["headers"][1]["val"]   =    "IP";
			$table_view["headers"][2]["val"]   =    "Vote"; 
			//pr($table_view,1);
			
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                
				$info[$i]["s_is_active"] = ($info[$i]["i_status"]==1)?'Active':'Inactive';
				$name_coupon=$this->store_model->fetch_this($info[$i]['i_store_id']);
				//pr($name_coupon);
				$name=$name_coupon[0]['s_store_title'];
				$i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	= $name;
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_ip"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["i_vote"];
				
            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit,$action); 
            
            $this->data["table_view"]=$this->admin_showin_table($table_view);
			//$this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            //echo $this->data["search_action"];
            
            $this->render("manage_vote/show_list");       
            unset($table_view,$info);
			
			
			
			//-------------------------------------------------------------------------------------
			
            
                
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }  
	
	
	
	
	
	
	
	
	    
	public function __destruct()
    {}
}