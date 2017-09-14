<?php
/*********
* Author: Arka , Mousudha
* Date  : 07 nov 2012
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

class Manage_offer extends My_Controller implements InfController
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
          $this->cls_msg["delete_err"]				= "Offer failed to remove.";
          $this->cls_msg["delete_succ"]				= "Offer removed successfully.";
		  $this->cls_msg["img_upload_err"]			= "Image cannot be uploded.";
		  $this->cls_msg["database_err"]			= "Failed to insert in the database.Try Again";
          ////////end Define Errors Here//////
		  		$this->pathtoclass 					= admin_base_url().$this->router->fetch_class()."/";
		  		$this->session->unset_userdata("s_offer");
		  			  
		 	$this->data['action_allowed']["Status"]	= TRUE;///////////////////////////////////////////exp
          	$this->load->model("offer_model");
			//$this->load->model("startup_model");
		  
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
			
            $this->data['title']		=	"Manage Offer ";////Browser Title
            $this->data['heading']		=	"Manage Offer ";
			
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
          	$this->data['title']				= "Offer Management";////Browser Title
            $this->data['heading']				= "Add Offer ";
            $this->data['pathtoclass']			= $this->pathtoclass;
            $this->data['mode']					= "add";
			
			if($_POST)
        {
				//print_r($_POST);
				$this->form_validation->set_rules('s_offer','Offer name','required');
				
			 if($this->form_validation->run() == FALSE)	
			 {	
				$this->data['posted'] = $_POST;
			 }
              
			  
        else
           {		$offer_url	= getSeoUrl($this->db->OFFER,$this->input->post("s_offer"));
					
                    $info	= array(										
										"s_offer"									=> $this->input->post("s_offer"),
										"i_is_active"								=> $this->input->post("i_is_active"),
										"s_url"							=> $offer_url
										
									);
					$inserted_user_id	= $this->offer_model->add_info($info);					
					
					
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
            $this->render("manage_offer/add-edit");
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
			
            $this->data['title']		="Edit Offer";////Browser Title
            $this->data['heading']		="Edit Offer";
            $this->data['pathtoclass']	=$this->pathtoclass;
            $this->data['mode']			="edit";
			
            ////////////Submitted Form///////////
            if($_POST)
            {	
				$posted=array();
                $posted["h_mode"]				= $this->data['mode'];
				$posted["s_offer"]				= trim($this->input->post("s_offer"));	
				$posted["i_is_active"]			= trim($this->input->post("i_is_active"));
				$posted["s_meta_title"]			= trim($this->input->post("s_meta_title"));
				$posted["s_meta_description"]	= trim($this->input->post("s_meta_description"));
				$posted["s_meta_keyword"]		= trim($this->input->post("s_meta_keyword"));
				$posted["h_id"]					= trim($this->input->post("h_id"));
				
				//print_r($posted);
				$this->form_validation->set_rules('s_offer','Offer Name','required');
				
                if($this->form_validation->run() == FALSE)////invalid
                {
                    //////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;       
                }
                else///validated, now save into DB
                {
					$offer_url									= getSeoUrl($this->db->OFFER,$posted["s_offer"],$posted["h_id"]);
					$info						= array();
					$info["s_offer"]			= $posted["s_offer"];
					$info["i_is_active"]		= $posted["i_is_active"];
					$info["s_meta_title"]		= $posted["s_meta_title"];
					$info["s_meta_description"]	= $posted["s_meta_description"];
					$info["s_meta_keyword"]		= $posted["s_meta_keyword"];
					$info["s_url"]				= $offer_url;
                    
                    $i_aff=$this->offer_model->edit_info($info, decrypt($posted["h_id"]));
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
                $info=$this->offer_model->fetch_this(decrypt($i_id));		
						
                $posted=array();
				$posted["s_offer"]				= trim($info[0]["s_offer"]);
				$posted["i_is_active"]			= trim($info[0]["i_is_active"]);
				$posted["s_meta_title"]			= trim($info[0]["s_meta_title"]);
				$posted["s_meta_description"]	= trim($info[0]["s_meta_description"]);
				$posted["s_meta_keyword"]		= trim($info[0]["s_meta_keyword"]);
				$posted["h_id"]= $i_id;
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("manage_offer/add-edit");
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
							$i_ret_=$this->offer_model->delete_info(-1);
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
							$i_ret_=$this->offer_model->delete_info(decrypt($id[$tot]));
							$tot--;
							}
							}
							elseif($id>0)///Deleting single Records
							{
							$i_ret_=$this->offer_model->delete_info(decrypt($id));
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
                $info=$this->offer_model->fetch_this(decrypt($i_id));
				
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
           
			$this->data['heading']="Manage offer";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
			
            $s_offer=($this->input->post("h_search")?$this->input->post("s_offer"):$this->session->userdata("s_offer")); 
			
		
            if($s_search=="basic")
            {
                $s_where =" WHERE (s_offer LIKE '%".my_receive_like($s_offer)."%' )";
				
                /////Storing search values into session///
                $this->session->set_userdata("s_offer",$s_offer);
				
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_offer"]=$s_offer;
				
            }
            elseif($s_search=="advanced")
            {
                              
                
            }
            else////List all records, **not done
            {
               
                $this->session->unset_userdata("s_offer");
                //$this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["s_offer"]="";                
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
            
			$info	= $this->offer_model->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);///////////test
				//print_r ($info);
            /////////Creating List view for displaying/////////
			$table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]     		=	"Start up Role";
            $table_view["total_rows"]		=	count($info);
			$table_view["total_db_records"]	=	$this->offer_model->gettotal_info($s_where);
			$table_view["order_name"]		=	$order_name;
			$table_view["order_by"]  		=	$order_by;
            $table_view["src_action"]		= 	$this->pathtoclass.$this->router->fetch_method(); 
            $table_view["detail_view"]		=   FALSE;          
            $table_view["headers"][0]["width"]	="40%";
            $table_view["headers"][0]["align"]	="left";
            //$table_view["headers"][0]["val"]	="Serial Number";
			//$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][0]["val"]	="Offer Name";
			$table_view["headers"][1]["val"]	="Top Offer";
			$table_view["headers"][2]["align"]	="center";
			$table_view["headers"][2]["val"]	="Status"; 
			
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                
				$info[$i]["s_is_active"] = ($info[$i]["i_status"]==1)?'Active':'Inactive';
				
				$is_top_checked = $info[$i]["i_is_top"];
						
				if($is_top_checked==1)
					$chk	= 'checked="checked"';
				else
					$chk	= "";
				
				$is_top = '<input type = "checkbox" '.$chk.' id="i_is_top'.($info[$i]["i_id"]).'" name="i_is_top" onclick=" return top_status_check('.($info[$i]["i_id"]).' );" />';
				
				$i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);////Index 0 must be the encrypted PK 
                //$table_view["tablerows"][$i][$i_col++]	= $info[$i]["i_id"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_offer"];
				//$table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_is_active"];
				
				
				$is_top_checked = $info[$i]["i_is_top"];
						
						if($is_top_checked==1)
							$chk	= 'checked="checked"';
						else
							$chk	= "";
				 $table_view["tablerows"][$i][$i_col++]	= $is_top;
				 
				 
				if($this->data['action_allowed']["Status"])
				{
				 	if($info[$i]["i_is_active"] == 1)
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
				$if_exist= $this->offer_model->check_in_cpn_table($posted["id"]);
				
				if(!$if_exist)
				{
					$posted["i_status"]     = trim($this->input->post("i_status"));
					$info = array();
					$info['i_is_active']    = $posted["i_status"]  ;
					$i_rect=$this->offer_model->change_status($info,$posted["id"]); /*don't change*/				
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
				else
				{
					echo "cpn_exist_error" ;
				}
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }  
	
	
	public	function get_offer_top_status()
	{
		$current_offer_id	= $this->input->post('current_offer_id');
		
		$offer_details		= $this->offer_model->fetch_this($current_offer_id);		
		
		if($offer_details[0]['i_is_active']==1)
			echo $this->offer_model->get_offer_top_status($current_offer_id);
		else
			echo 0;
		
		//echo $this->coupon_model->get_coupon_hot_status($current_coupon_id);
		
	}	
	
	
	
	public function change_top_status()
	{
		try
		{
			$current_offer_id	= $this->input->post('current_offer_id');
			$current_offer_status	= $this->input->post('current_offer_status');
			echo $this->offer_model->update_top_offer_status($current_offer_id, $current_offer_status);
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}	
	}	
	
	    
	public function __destruct()
    {}
}