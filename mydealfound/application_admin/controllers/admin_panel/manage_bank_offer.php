<?php
/*********
* Author: ACS
* Date  : 04 June 2014
* Modified By: 
* Modified Date:
* Purpose:
* Controller For manage bank offer
* @package Travel
* @subpackage Manage Category
* @link InfController.php 
* @link My_Controller.php
* @link model/food_dining_model.php
* @link views/admin/food_dining_store/
*/
class Manage_bank_offer extends My_Controller implements InfController
{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass, $tbl;
	
    public function __construct()
    {            
        try
        {
          parent::__construct();
          $this->data['title']="Manage Bank Offer";////Browser Title
          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]		=	"No information found about bank offer.";
          $this->cls_msg["save_err"]		=	"Information about bank offer failed to save.";
          $this->cls_msg["save_succ"]		=	"Information about bank offer saved successfully.";
          $this->cls_msg["delete_err"]		=	"Information about bank offer failed to remove.";
          $this->cls_msg["delete_succ"]		=	"Information about bank offer removed successfully.";
          ////////end Define Errors Here//////

          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  //////// loading default model here //////////////
          $this->load->model("bank_offer_model","mod_rect");
		  //$this->load->model("common_model","mod_com");
		  $this->tbl = $this->db->BANK_OFFER;

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
    */
    public function show_list($start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Manage Bank Offer";////Package Name[@package] Panel Heading
            ///////////generating search query///////
            ////////Getting Posted or session values for search///

            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_bank=($this->input->post("h_search")?$this->input->post("s_bank"):$this->session->userdata("s_bank")); 
           
            ////////end Getting Posted or session values for search///  
            $s_where=" WHERE n.i_id >0 ";
            if($s_search=="basic")
            {
               // $s_where=" WHERE n.s_subject LIKE '%".my_receive($s_milestones_title)."%' ";
				if($s_bank)
				{
					$s_where .=" AND n.s_bank LIKE '%".addslashes($s_bank)."%' ";
				}
                /////Storing search values into session///
                $this->session->set_userdata("s_bank",$s_bank);
                $this->session->set_userdata("h_search",$s_search);                

                $this->data["h_search"]			=$s_search;
                $this->data["s_bank"]		=$s_bank;
                /////end Storing search values into session///
            }

            elseif($s_search=="advanced")
            {
               // $s_where=" WHERE n.{$this->lang_prefix}_s_subject LIKE '%".my_receive($s_milestones_title)."%' ";
				if($s_bank)
				{
					$s_where .=" AND n.s_bank LIKE '%".addslashes($s_bank)."%' ";
				}
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ;
                    $s_where.=" And FROM_UNIXTIME( n.dt_entry_date , '%Y-%m-%d' ) ='".$dt_start."' ";
                    unset($dt_start);
                }
                /////Storing search values into session///

                $this->session->set_userdata("s_bank",$s_bank);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
                $this->session->set_userdata("h_search",$s_search);

                $this->data["h_search"]			=$s_search;
                $this->data["s_bank"]		=$s_bank;   
                $this->data["txt_created_on"]	=$dt_created_on; 
                /////end Storing search values into session/// 

            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_id >0 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("s_bank");
                $this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");
                $this->data["h_search"]			=$s_search;
                $this->data["s_bank"]		="";  
                $this->data["txt_created_on"]	="";    
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
			//pr($info);
            /////////Creating List view for displaying/////////
            $table_view=array();  

            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Manage Bank Offer";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
			$table_view["details_view"]=FALSE;
            $table_view["headers"][0]["width"]	=	"50%";
            $table_view["headers"][0]["align"]	=	"center";
            $table_view["headers"][0]["val"]	=	"Bank";
			$table_view["headers"][0]["align"]	=	"center";
			$table_view["headers"][1]["align"]	=	"center";
			$table_view["headers"][1]["val"]	=	"Status";
			//$table_view["headers"][2]["val"]	=	"Type";
			//$table_view["headers"][4]["val"]	="Edit";
            //////end Table Headers, with width,alignment///////

            /////////Table Data/////////

            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= 	encrypt($info[$i]["i_id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=	$info[$i]["s_bank"];
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
				 	$table_view["tablerows"][$i][$i_col++]	= $action;

				}
            } 

            /////////end Table Data/////////

            unset($i,$i_col,$start,$limit); 
            $this->data["table_view"]		=		$this->admin_showin_table($table_view,TRUE);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]	=		$this->pathtoclass.$this->router->fetch_method();
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
    * On Success redirect to the showList interface else display error here.
    */
    public function add_information() 
    {  
        try
        {

            $this->data['title']		="Add Bank Offer Details";////Browser Title
            $this->data['heading']		="Add Bank Offer";
            $this->data['pathtoclass']	=$this->pathtoclass;
            $this->data['mode']			="add";	
            //$this->data['type']			=$type;		

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]			= $this->data['mode'];              
				$posted["s_bank"]			=    trim($this->input->post("s_bank"));
                $posted["txt_content"]		=    trim($this->input->post("txt_content"));
				$i_status 					=    trim($this->input->post("i_status"));
                $posted["i_status"]			= ($i_status==1)?$i_status:0;				

                $this->form_validation->set_rules('s_bank', 'bank offer', 'required');
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["s_bank"]			=	$posted["s_bank"];
					$info["i_status"]		=	$posted["i_status"];
                    $info["dt_entry"]		=	now();                
                    //pr($info,1);
                    $i_aff=$this->mod_rect->add_info($info);
					//echo "here";exit;
                    if($i_aff)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);		
                        redirect($this->pathtoclass."show_list");
                    }
                    else///Not saved, show the form again
                    {
                        $this->data["posted"]	=	$posted;
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    unset($info,$posted, $i_aff);

                }

            }
            ////////////end Submitted Form///////////

            $this->render("manage_bank_offer/add-edit");

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
    * On Success redirect to the showList interface else display error here. 
    * @param int $i_id, id of the record to be modified.
    */      
    public function modify_information($i_id=0)
    {          

        try
        {

            $this->data['title']		="Edit Manage Bank Offer Details";////Browser Title
            $this->data['heading']		="Edit Manage Bank Offer";
            $this->data['pathtoclass']	=$this->pathtoclass;
            $this->data['mode']			="edit";	
            //$this->data['type']			=$type;		

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]			= $this->data['mode'];              
				$posted["s_bank"]			=    trim($this->input->post("s_bank"));
                $posted["txt_content"]		=    trim($this->input->post("txt_content"));
				$i_status 					=    trim($this->input->post("i_status"));
                $posted["i_status"]			= ($i_status==1)?$i_status:0;		
				
				$posted["h_id"]				= $this->input->post("h_id");	

                $this->form_validation->set_rules('s_bank', 'bank offer', 'required');
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["s_bank"]			=	$posted["s_bank"];
					$info["i_status"]		=	$posted["i_status"];
                    $info["dt_entry"]		=	now();                
                    //print_r($info);////////////////////////////////////////////////////////////////////////

                    $i_aff=$this->mod_rect->edit_info($info,decrypt($posted["h_id"]));
					//echo "here";exit;
                    if($i_aff)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);		
                        redirect($this->pathtoclass."show_list");
                    }
                    else///Not saved, show the form again
                    {
                        $this->data["posted"]	=	$posted;
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    unset($info,$posted, $i_aff);
                }
            }
            else
            {	

                $info=$this->mod_rect->fetch_this(decrypt($i_id));////////
                $posted=array();
				$posted["s_bank"]				= trim($info[0]["s_bank"]);
				$posted["i_status"]				= trim($info[0]["i_status"]);
                $posted['h_mode']               = $this->data['mode'];
				$posted["h_id"]					= $i_id;
                $this->data["posted"]			= $posted;   
                unset($info,$posted);    

            }

            ////////////end Submitted Form///////////

            $this->render("manage_bank_offer/add-edit");
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
    {}
	
	

	public function ajax_change_status()
    {
        try
        {

                $posted["id"]           = decrypt(trim($this->input->post("h_id")));
				
				$posted["i_status"]     = trim($this->input->post("i_status"));
				$info = array();
				$info['i_status']    = $posted["i_status"]  ;
				$i_rect=$this->mod_rect->change_status($info,$posted["id"]); /*don't change*/	
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

     /***

    * Checks duplicate value using ajax call

    */

    public function ajax_checkduplicate()

    {}    

	

	public function __destruct()

    {}

	

	

}

?>