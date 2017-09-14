<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 03 July 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For Currency
* 
* @package General
* @subpackage currency rate
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/currency_model.php
* @link views/admin/currency/
*/


class Currency extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="Currency Rate Management";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	= "No information found about currency.";
          $this->cls_msg["save_err"]	= "Information about currency failed to save.";
          $this->cls_msg["save_succ"]	= "Information about currency saved successfully.";
          $this->cls_msg["delete_err"]	= "Information about currency failed to remove.";
          $this->cls_msg["delete_succ"]	= "Information about currency removed successfully.";
		   $this->cls_msg["status_succ"]= "Status of currency saved successfully.";
		   $this->cls_msg["status_err"]	= "Status of currency failed to save.";
          ////////end Define Errors Here//////
          $this->pathtoclass 			= admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("currency_model","mod_rect");
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
    public function show_list($order_name='',$order_by='asc',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Currency Rate";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search =(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));           
			$s_code	  =($this->input->post("h_search")?$this->input->post("txt_currency"):$this->session->userdata("txt_currency")); 

			////////end Getting Posted or session values for search///

            $s_where=" WHERE n.i_status!=2 ";
            
            if($s_search=="advanced")
            {
				
                if(trim($s_code)!='')
				{
					$s_where.=" And n.s_currency_code LIKE '%".get_formatted_string($s_code)."%' ";
				}
                /////Storing search values into session///					
				$this->session->set_userdata("txt_currency",$s_code);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]		= $s_search;
				$this->data["txt_currency"]	= get_unformatted_string($s_code);    
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_status!=2 ";
                /////Releasing search values from session///
				
				$this->session->unset_userdata("txt_currency");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]		= $s_search;
				$this->data["txt_currency"]	= "";          
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_code);
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
			
			$arr_sort = array(0=>'s_currency_code',2=>'i_status'); 
			$s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
            
            
            $limit	= $this->i_admin_page_limit;
			$info	= $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			
            /////////Creating List view for displaying/////////
            $table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]				= "Currency Rate";
            $table_view["total_rows"]			= count($info);
			$table_view["total_db_records"]		= $this->mod_rect->gettotal_info($s_where);
			$table_view["order_name"]			= $order_name;
			$table_view["order_by"]  			= $order_by;
            $table_view["src_action"]			= $this->pathtoclass.$this->router->fetch_method(); 
			$table_view["detail_view"]			= false;
                        
            $table_view["headers"][0]["width"]	="30%";
            $table_view["headers"][0]["align"]	="left";			
            $table_view["headers"][0]["val"]	="Currency Code";
			$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][2]["val"]	="Currency Rate";
			$table_view["headers"][3]["val"]	="Currency Symbol";
			$table_view["headers"][4]["val"]	="Status";

			
			
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_currency_code"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["d_currency_rate"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_currency_symbol"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_status"];

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
		try
        {
            $this->data['title']="Currency Management";////Browser Title
            $this->data['heading']="Add Currency";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="add";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
				$posted["txt_currency_code"]		=	trim($this->input->post("txt_currency_code"));
				$posted["txt_currency_symbol"]		=	trim($this->input->post("txt_currency_symbol"));
				$posted["d_currency_rate"]			=	trim($this->input->post("d_currency_rate"));
                $posted["h_mode"]					=	$this->data['mode'];
                $posted["h_id"]                     = 	"";
				
				
               
                $this->form_validation->set_rules('txt_currency_symbol', 'currency symbol', 'required');
				$this->form_validation->set_rules('txt_currency_code', 'currency code', 'required');
				$this->form_validation->set_rules('d_currency_rate', 'currency rate', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
                    $info["s_currency_symbol"]			=	$posted["txt_currency_symbol"];
					$info["s_currency_code"]			=	$posted["txt_currency_code"];
					$info["d_currency_rate"]			=	$posted["d_currency_rate"];
                    
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
            $this->render("currency/add-edit");
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
            $this->data['title']="Edit Currency Details";////Browser Title
            $this->data['heading']="Edit currency rate";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                
                $posted["txt_currency_symbol"]		=	trim($this->input->post("txt_currency_symbol"));
				$posted["txt_currency_code"]		=	trim($this->input->post("txt_currency_code"));
				$posted["d_currency_rate"]			=	trim($this->input->post("d_currency_rate"));
                $posted["h_id"]						=   trim($this->input->post("h_id"));
				
				
                $this->form_validation->set_rules('txt_currency_symbol', 'currency symbol', 'required');
				$this->form_validation->set_rules('txt_currency_code', 'currency code', 'required');
				$this->form_validation->set_rules('d_currency_rate', 'currency rate', 'required');
             
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["s_currency_symbol"]			=	$posted["txt_currency_symbol"];
					$info["s_currency_code"]			=	$posted["txt_currency_code"];
					$info["d_currency_rate"]			=	$posted["d_currency_rate"];
                    //$info["i_status"]                =    $posted["i_state_is_active"];
                    

                    
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
				$posted["txt_currency_symbol"]		= trim($info["s_currency_symbol"]);
				$posted["txt_currency_code"]		= trim($info["s_currency_code"]);
				$posted["d_currency_rate"]			= $info["d_currency_rate"];
				$posted['i_default']				= trim($info['i_default']);	
				$posted["h_id"]                     = $i_id;
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("currency/add-edit");
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
        {}
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
            $posted["id"]				= decrypt($this->input->post("h_id"));/*don't change*/
            $posted["duplicate_value"]	= get_formatted_string($this->input->post("h_duplicate_value"));
            
            if($posted["duplicate_value"]!="")
            {
                $qry=" WHERE ".(intval($posted["id"])>0 ? " n.i_id!=".intval($posted["id"])." And " : "" )
                    ." n.s_currency_code='".$posted["duplicate_value"]."'";
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
	public function __destruct()
    {}
	
	
}
?>