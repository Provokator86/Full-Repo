<?php
/*********
* Author: Arka 
* Date  : jan 2013
* Modified By: 
* Modified Date:
* 
* Purpose:
* Controller For manage stores
* 
* @package Content Management
* @subpackage site_setting
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/manage_stores_model.php
* @link views/admin/manage_stores/
*/

class Manage_store_comments extends My_Controller implements InfController
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
          $this->cls_msg["delete_err"]				= "Comments failed to remove.";
          $this->cls_msg["delete_succ"]				= "Comments removed successfully.";
		  $this->cls_msg["img_upload_err"]			= "Image cannot be uploded.";
		  $this->cls_msg["database_err"]			= "Failed to insert in the database.Try Again";
		  
          ////////end Define Errors Here//////
			$this->pathtoclass 					= admin_base_url().$this->router->fetch_class()."/";
			
			$this->session->unset_userdata("s_category");
		  			  
		 	$this->data['action_allowed']["Status"]	= TRUE;///////////////////////////////////////////exp
			
          	$this->load->model("comment_model");
			$this->load->model("store_model");
			$this->load->model("store_comment_model");
		  
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
    {}

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
			
            $this->data['title']		="Edit Store Comment";////Browser Title
            $this->data['heading']		="Edit Store Comment";
            $this->data['pathtoclass']	=$this->pathtoclass;
            $this->data['mode']			="edit";
			
            ////////////Submitted Form///////////
            if($_POST)
            {	
				$posted=array();
                                $posted["h_mode"]				= $this->data['mode'];
				$posted["i_store_id"]				= trim($this->input->post("i_store_id"));	
				$posted["s_comments"]				= trim($this->input->post("s_comments"));
				$posted["s_commented_by_email"]		= trim($this->input->post("s_commented_by_email"));
				//$posted["s_commented_by"]			= trim($this->input->post("s_commented_by"));
				//$posted["dt_entry_date"]			= trim($this->input->post("dt_entry_date"));
				$posted["i_is_active"]				= trim($this->input->post("i_is_active"));
				//$posted["i_status"]					= trim($this->input->post("i_status"));
				$posted["h_id"]						= trim($this->input->post("h_id"));
				
				//print_r($posted);
				$this->form_validation->set_rules('s_comments',' Comments','required');
				
                if($this->form_validation->run() == FALSE)////invalid
                {
                    //////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;       
                }
                else///validated, now save into DB
                {
                    $info	=	array();
                    $info["i_store_id"]			=	$posted["i_store_id"];
                    $info["s_comments"]			=	$posted["s_comments"];
                    $info["s_commented_by_email"]			=	$posted["s_commented_by_email"];
                    //$info["s_commented_by"]			=	$posted["s_commented_by"];
                    $info["dt_entry_date"]			=	$posted["dt_entry_date"];
                    $info["i_is_active"]			=	$posted["i_is_active"];
					
                   

                    
                    $i_aff=$this->store_comment_model->edit_info($info, decrypt($posted["h_id"]));
					
                    if($i_aff)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list/");
                    }
                    else///Not saved, show the form again
                    {
                        $this->data["posted"]=$posted;
                        //set_error_msg($this->cls_msg["save_err"]);
						redirect($this->pathtoclass."show_list/");
                    }
                    unset($info,$posted, $i_aff);
                    
                }
            }
            else
            { 
                $info=$this->store_comment_model->fetch_this(decrypt($i_id));		
				
                $posted=array();
				$posted["i_store_id"]				= trim($info[0]["i_store_id"]);
				$posted["s_comments"]				= trim($info[0]["s_comments"]);
				$posted["s_commented_by_email"]                 = trim($info[0]["s_commented_by_email"]);
				$posted["s_commented_by"]			= trim($info[0]["s_commented_by"]);
				$posted["dt_entry_date"]			= trim($info[0]["dt_entry_date"]);
				$posted["i_is_active"]				= trim($info[0]["i_is_active"]);
				$posted['store_name']				= trim($info[0]["store_name"]);
				$posted["h_id"]= $i_id;
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("manage_store_comments/add-edit");
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
							$i_ret_=$this->store_comment_model->delete_info(-1);
							break;
				default: 		///Deleting selected,page ///
							//////First consider the posted ids, if found then take $i_id value////
							$id=(!$i_id?$this->input->post("chk_del"):$i_id);///may be an array of IDs or single id
							//pr($id,1);
							if(is_array($id) && !empty($id))///Deleting Multi Records
							{
							///////////Deleting Information///////
							$tot=count($id)-1;
							while($tot>=0)
							{
							$i_ret_=$this->store_comment_model->delete_info(decrypt($id[$tot]));
							$tot--;
							}
							}
							elseif($id>0)///Deleting single Records
							{
							$i_ret_=$this->store_comment_model->delete_info(decrypt($id));
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
            //redirect($this->pathtoclass."show_comments".($pageno?"/".$pageno:""));
			//redirect(admin_base_url().'manage_store');
			echo '<script>history.back(-1)</script>';
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
                $info=$this->comment_model->fetch_this(decrypt($i_id));
				
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
	
	
    public function filter_stores($i_store_id = 6){
        $this->session->set_userdata("i_store_id",$i_store_id);
        redirect($this->pathtoclass."show_list/");
    }
	
   	
	public function show_list($order_name='',$order_by='desc',$start=NULL,$limit=NULL)
	{
            try
                {
           
                    $this->data['heading']="Manage Store";////Package Name[@package] Panel Heading
                    $this->session->unset_userdata('store_controller');// to redirect to show list after delete
                    ///////////generating search query///////

                    ////////Getting Posted or session values for search///
                  /*  $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));

                    $s_store=($this->input->post("h_search")?$this->input->post("s_store"):$this->session->userdata("s_store")); 
                    $s_is_active=($this->input->post("h_search")?$this->input->post("s_is_active"):$this->session->userdata("s_is_active")); 
                    $s_category=($this->input->post("h_search")?$this->input->post("s_category"):$this->session->userdata("s_category"));
                    $s_store=($this->input->post("h_search")?$this->input->post("s_store"):$this->session->userdata("s_store"));
                    $txt_expiry_dt=($this->input->post("h_search")?$this->input->post("txt_expiry_dt"):$this->session->userdata("txt_expiry_dt"));
                   */
                    ////////end Getting Posted or session values for search///
            
			
                    //$s_where=" WHERE dt_exp_date>=now() ";/////////////////////////1====
                   // $s_where=" WHERE CONCAT(DATE(dt_exp_date),' 23:59:59')>=now() ";
		
           /* if($s_search=="basic")
            {
                $s_where.=" AND (s_store_title LIKE '%".my_receive_like($s_store)."%' )";
                if(trim($s_is_active)!="")
                {
                    $s_where.=" And i_is_active=".$s_is_active." ";
                    
                }
				
                if(trim($s_category)!="")
                {	
                    $cat_id=$this->store_model->get_cat_id($s_category);
                    //pr($cat_id);
                    foreach($cat_id as $id)
                    {
                        $ci .=($ci == '')?$id['i_id']:','.$id['i_id'];
                    }

                    //echo $ci;exit;
                    if($ci)
                    {
                            //echo "212";
                        $s_where.=" And i_cat_id IN (".$ci.")";
                    }
                    else
                    {
                             $s_where.=" And i_cat_id=0";
                    }

                }

		if(trim($s_store)!="")
                {	
                    $s_where.=" AND i_store_id= '".$s_store."'";
                }
				
		if(trim($txt_expiry_dt)!="")
                {
                    $s_where.=" And DATE(dt_exp_date)= '".$txt_expiry_dt."' ";
                    
                }
				
				
				
				
                /////Storing search values into session///
                $this->session->set_userdata("s_store",$s_store);
                $this->session->set_userdata("s_is_active",$s_is_active);
                $this->session->set_userdata("s_category",$s_category);
                $this->session->set_userdata("s_store",$s_store);
                $this->session->set_userdata("txt_expiry_dt",$txt_expiry_dt);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_store"]=$s_store;
                $this->data["s_category"]=$s_category;
                $this->data["s_store"]=$s_store;
                $this->data["txt_expiry_dt"]=$txt_expiry_dt;
                $this->data["s_is_active"]=$s_is_active;
				
                /////end Storing search values into session///
            }
            
            else////List all records, **not done*/
            //{
            //$s_where=" WHERE n.id!=1 ";
            /////Releasing search values from session///
            //$this->session->unset_userdata("s_store");
            //$this->session->unset_userdata("s_is_active");
            // $this->session->unset_userdata("s_category");
            //$this->session->unset_userdata("txt_expiry_dt");

            //$this->session->unset_userdata("s_store");
            // $this->session->unset_userdata("h_search");

            //$this->data["h_search"]=$s_search;
            // $this->data["s_store"]=""; 
            //                $this->data["s_category"]="";
            //                $this->data["s_store"]="";
            //                $this->data["txt_expiry_dt"]="";               
            //$this->data["s_is_active"]="";             
                /////end Storing search values into session///
            //}
            //unset($s_search,$s_user_type,$dt_created_on);
            ///Setting Limits, If searched then start from 0////
            $i_uri_seg =6;
			
				
			
           /* if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {*/
                $start=$this->uri->segment($i_uri_seg);
           /* }*/
            $i_store_id =      $this->session->userdata("i_store_id");
            
	    $s_where=" WHERE i_store_id=$i_store_id ";	
            ///////////end generating search query///////
            $arr_sort = array(0=>'i_id',1=>'s_store_title');
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
            
            
            $limit	= $this->i_admin_page_limit;

            $info	= $this->store_comment_model->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);///////////test
            //$name=
            //print_r ($info);
            /////////Creating List view for displaying/////////
            $table_view=array(); 
            $order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 

            //////Table Headers, with width,alignment///////
            $table_view["caption"]     		=	"Store";
            $table_view["total_rows"]		=	count($info);
            $table_view["total_db_records"]	=	$this->store_comment_model->gettotal_info($s_where);
            $table_view["order_name"]		=	$order_name;
            $table_view["order_by"]  		=	$order_by;
            $table_view["src_action"]		= 	$this->pathtoclass.$this->router->fetch_method(); 
            // $table_view["detail_view"]		=   FALSE;          
            $table_view["headers"][0]["width"]	=	"20%";
            $table_view["headers"][0]["align"]	=	"left";
            $table_view["headers"][0]["val"]	=	"Store Name";
            $table_view["headers"][1]["align"]	=	"center";
            $table_view["headers"][1]["val"]	=	"Comments";
            $table_view["headers"][2]["val"]	=	"Status"; 
			
            //////end Table Headers, with width,alignment///////
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {	
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_store_title"];
                $table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_comments"];



                if($this->data['action_allowed']["Status"])
                {
                     if($info[$i]["i_is_active"] == 1)
                     {

                        /*$action ='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_inactive">
                        <img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/tick.png"></a>';*/
                        $action = 'Active';
                     }
                     else
                     { 
                        /*$action ='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_active">
                        <img width="12" height="12" title="Active" alt="Active" src="images/admin/reject.png"></a>';*/
                                     $action = 'Inactive';
                     }
                    //$table_view["tablerows"][$i][$i_col++]	=($info[$i]["i_status"] == 1)?"Active":"Inactive";
                    $table_view["tablerows"][$i][$i_col++]	= $action;
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
                $i_rect=$this->comment_model->change_status($info,$posted["id"]); /*don't change*/				
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
	

	
	
	
	public function show_store_comments($order_name='',$order_by='desc',$start=NULL,$limit=NULL,$id=99)
    {
        try
        {
			
			$this->data['heading']				=	'Store comments';	
			$info								=	$this->store_comment_model->fetch_comments_for_store($id);
			//pr($info);
			$table_view["caption"]     			=	"Store Comments";
                        $table_view["total_rows"]			=	count($info);
			$table_view["total_db_records"]		=	$this->store_comment_model->gettotal_comment_for_store($id);
			$table_view["order_name"]			=	$order_name;
			$table_view["order_by"]  			=	$order_by;
                        $table_view["src_action"]			= 	$this->pathtoclass.$this->router->fetch_method(); 
                        $table_view["detail_view"]			=   FALSE;          
                        $table_view["headers"][0]["width"]	=	"20%";
                        $table_view["headers"][0]["align"]	=	"left";
                        $table_view["headers"][0]["val"]	=	"Store Name";
			$table_view["headers"][1]["align"]	=	"center";
			$table_view["headers"][1]["val"]	=	"Comments";
			$table_view["headers"][2]["val"]	=	"Status"; 
			
			
			for($i=0; $i<$table_view["total_rows"]; $i++)
                        {
                
				$info[$i]["s_is_active"] = ($info[$i]["i_status"]==1)?'Active':'Inactive';
				$name_store=$this->store_model->fetch_this($info[$i]['i_store_code']);
				
				$name=$name_store[0]['s_store_title'];
				$i_col=0;
                                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);////Index 0 must be the encrypted PK 
                
				$table_view["tablerows"][$i][$i_col++]	=	$info[$i]["s_store_title"];
				$table_view["tablerows"][$i][$i_col++]	=	$info[$i]["s_comments"];
				
				if($this->data['action_allowed']["Status"])
				{
				 	if($info[$i]["i_is_active"] == 1)
					{
				
                        /*$action ='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_inactive">
                        <img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/tick.png"></a>';*/
                         $action = 'Active';
					}
					else
					{ 
                        /*$action ='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_active">
                        <img width="12" height="12" title="Active" alt="Active" src="images/admin/reject.png"></a>';*/
						$action = 'Inactive';
					}
				 //$table_view["tablerows"][$i][$i_col++]	=($info[$i]["i_status"] == 1)?"Active":"Inactive";
				 $table_view["tablerows"][$i][$i_col++]	= $action;
				}

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit,$action); 
            
            //$this->data["table_view"]=$this->admin_showin_table($table_view);
			$this->data["table_view"]=$this->admin_showin_order_table_2($table_view);
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
	
	
	
	
	    
	public function __destruct()
    {}
}