<?php
/*********
* Author: Iman Biswas
* Date  : 9 Sep 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For state
* 
* @package Content Management
* @subpackage State
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/state_model.php
* @link views/admin/state/
*/


class Buyer_faq_category extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    //public $uploaddir;
    //public $thumbdir;
    //public $showimgdir;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="Buyer Faq Category Management";////Browser Title
		  $this->type = 'buyer_faq';

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]="No information found about category.";
          $this->cls_msg["save_err"]="Information about category failed to save.";
          $this->cls_msg["save_succ"]="Information about category saved successfully.";
          $this->cls_msg["delete_err"]="Information about category failed to remove.";
          $this->cls_msg["delete_succ"]="Information about category removed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("category_model","mod_rect");
		  $this->load->model("language_model");
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
            $this->data['heading']="Buyer Faq  Category";////Package Name[@package] Panel Heading
            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_category_name=($this->input->post("h_search")?$this->input->post("txt_category_name"):$this->session->userdata("txt_category_name")); 
            //$dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
            $s_category_type=($this->input->post("h_search")?$this->input->post("opd_category_type"):$this->session->userdata("opd_category_type"));
			////////end Getting Posted or session values for search///            
            
            $s_where="";
            if($s_search=="basic")
            {
                $s_where=" AND  cat_c.s_name LIKE '%".get_formatted_string($s_category_name)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_category_name",$s_category_name);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_category_name"]=$s_category_name;
                /////end Storing search values into session///
            }
            elseif($s_search=="advanced")
            {
				 $arr_search[] ="  c.s_category_type = '{$this->type}' AND cc.i_lang_id=".$this->i_admin_language." ";
				if(trim($s_category_name)!="")
                {
                	 $arr_search[] =" cc.s_name  LIKE '%".get_formatted_string($s_category_name)."%' ";
				}	
				
				
                $s_where .= (count($arr_search) !=0)?' WHERE '.implode('AND',$arr_search):'';	
				
				
                /////Storing search values into session///
                $this->session->set_userdata("txt_category_name",$s_category_name);
                //$this->session->set_userdata("txt_created_on",$dt_created_on);
				$this->session->set_userdata("txt_category_type",$s_category_type);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_category_name"]=$s_category_name;                
                //$this->data["txt_created_on"]=$dt_created_on;  
				$this->data["opd_category_type"]=$s_category_type;            
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE c.s_category_type = '$this->type'  AND cc.i_lang_id=".$this->i_admin_language;
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_category_name");
                //$this->session->unset_userdata("txt_created_on");
				$this->session->unset_userdata("opd_category_type");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_category_name"]="";                
                //$this->data["txt_created_on"]=""; 
				$this->data["opd_category_type"]="";            
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
            
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_multi($s_where,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Category";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
            
			$j_col = 0;            
            
           // $table_view["headers"][$j_col]["align"]	="left";
            $table_view["headers"][$j_col]["val"]	="Category Name";
			$table_view["headers"][++$j_col]["val"]	="Status";
			$table_view["headers"][$j_col]["width"]	="9%";
			$table_view["headers"][$j_col]["align"]	="center";
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_category_name"];
	//			$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_category_type"];
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_is_active"];
                //$table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];
                //$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_is_active"];

            } 
			//var_dump($table_view);exit;
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_table($table_view);
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
            $this->data['title']="Category Management";////Browser Title
            $this->data['heading']="Add Category";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="add";
			
			$s_where = " WHERE i_status=1";
			$language_detail = $this->language_model->fetch_multi($s_where);
			$this->data["language_detail"] =$language_detail;

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["txt_category_name"]	= trim($this->input->post("txt_category_name"));
				$posted["opd_category_type"]	= trim($this->input->post("opd_category_type"));
				$posted["opd_parent_id"]		= trim($this->input->post("opt_parent_id_2"));
				$posted["opt_language"]			= trim($this->input->post("opt_language"));

                $posted["chk_status"]= trim($this->input->post("chk_status"));
                $posted["h_mode"]= $this->data['mode'];
                $posted["h_id"]= "";
				$arr_lang_val = array();
				
				foreach($language_detail as $lang)
				{
					$arr_lang_val[$lang['id']] = trim($this->input->post("txt_category_name_".$lang['id']));
					$posted["txt_category_name_".$lang['id']]= trim($this->input->post("txt_category_name_".$lang['id']));
					$this->form_validation->set_rules("txt_category_name_".$lang['id'], 'category name for '.$lang['s_language'], 'required');
				}
				
               //pr($arr_lang_val,1);
                //$this->form_validation->set_rules('txt_category_name', 'category name', 'required');
			//	$this->form_validation->set_rules('opd_category_type', 'select category type', 'required');
              
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info=array();
                    $info["s_category_name"]	=	$posted["txt_category_name"];
                    $info["s_category_type"]	=	$this->type;;
					$info["i_parent_id"]		=	0;
					//$info["i_lang_id"]			=	decrypt($posted["opt_language"]);
					
                    $info["i_status"]=$posted["chk_status"];
                    $info["dt_created_on"]=time();
					
					//pr($info,1);
					
                    $i_newid = $this->mod_rect->add_info($info);
                    if($i_newid)////saved successfully
                    {
						$i_nw_child = $this->mod_rect->add_categories($arr_lang_val,$i_newid);
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list");
                    }
                    else///Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    
                }
            }
			
			
			
			//pr($this->data["language_detail"]);
		
            ////////////end Submitted Form///////////
            $this->render("buyer_faq_category/add-edit");
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
            $this->data['title']="Edit Category Details";////Browser Title
            $this->data['heading']="Edit Category";
            $this->data['pathtoclass']=$this->pathtoclass;
            $this->data['mode']="edit";
			
			$s_where = " WHERE i_status=1";
			$language_detail = $this->language_model->fetch_multi($s_where);
			$this->data["language_detail"] =$language_detail;

            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
                $posted["h_mode"]= $this->data['mode'];
				//$posted["txt_category_name"]= trim($this->input->post("txt_category_name"));
			//	$posted["opd_category_type"]= trim($this->input->post("opd_category_type"));
				$posted["opt_parent_id"]= trim($this->input->post("opt_parent_id"));
				
				
				$i_status = trim($this->input->post("chk_status"));
                $posted["i_active"]= ($i_status==1)?$i_status:0;
                $posted["h_id"]= trim($this->input->post("h_id"));
				$arr_lang_val = array();
				
				foreach($language_detail as $lang)
				{
					$arr_lang_val[$lang['id']] = trim($this->input->post("txt_category_name_".$lang['id']));
					$posted["txt_category_name_".$lang['id']]= trim($this->input->post("txt_category_name_".$lang['id']));
					$this->form_validation->set_rules("txt_category_name_".$lang['id'], 'category name for '.$lang['s_language'], 'required');
				}

				
				
                //$this->form_validation->set_rules('txt_category_name', 'category name', 'required');
            //    $this->form_validation->set_rules('opd_category_type', 'category type', 'required');
             
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					//$info["s_category_name"]=$posted["txt_category_name"];
                    $info["s_category_type"]=$this->type;
					$info["i_parent_id"]=0;
					$info["dt_created_on"]=time();
                    $info["i_status"]=$posted["i_active"];

                    //var_dump($info);exit;
                    $i_aff=$this->mod_rect->edit_info($info,decrypt($posted["h_id"]));
					
                    if($i_aff)////saved successfully
                    {
						$i_nw_child = $this->mod_rect->add_categories($arr_lang_val,decrypt($posted["h_id"]));
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
				$cat=$this->mod_rect->fetch_this_category(decrypt($i_id));
				//$arr_lang_val = array();
				
				$posted=array();
				foreach($cat as $lang)
				{								
					$posted["txt_category_name_".$lang['i_lang_id']]= $lang['s_name'];					
				}	
				//pr($posted);
               
				

				//$posted["txt_category_name"]= $info["s_category_name"];
				$posted["opd_category_type"]= encrypt($info["s_category_type"]);
				$posted["opd_parent_id"]= encrypt($info["i_parent_id"]);
				$posted["opd_parent_id"]=makeOption($this->mod_rect->get_cat_selectlist($info["s_category_type"],0,0,1),$posted["opd_parent_id"]);
				
				$posted["dt_created_on"]= trim($info["dt_created_on"]);
				$posted["i_active"]= trim($info["i_is_active"]);
				$posted["h_id"]= $i_id;
				//pr($posted);
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
			
            ////////////end Submitted Form///////////
            $this->render("buyer_faq_category/add-edit");
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
				$s_where = " WHERE c.id =".decrypt($i_id);
                $info=$this->mod_rect->fetch_multi($s_where);
				//pr($info);
                if(!empty($info))
                {
                    $temp=array();
                    $temp["s_id"]= encrypt($info["id"]);////Index 0 must be the encrypted PK 
					$temp["s_category_name"]= trim($info["s_category_name"]);
					$temp["s_category_type"]= trim($info["s_category_type"]);
					$temp["s_parent_category"]= trim($info["s_parent_category"]);
					
					$temp["i_status"]= trim($info["i_status"]);
					$temp["dt_created_on"]= trim($info["dt_created_on"]);

					$this->data["info"]=$info;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            
            $this->render("buyer_faq_category/show_detail",TRUE);
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
            $posted["duplicate_value"]= get_unformatted_string(trim($this->input->post("h_duplicate_value")));
			//$posted["i_parent_id"]= decrypt($this->input->post("i_parent_id"));
		//	$posted["i_type"]= decrypt($this->input->post("i_type"));				
		
						
            if($posted["duplicate_value"]!="")
            {
                $qry=" Where ".(intval($posted["id"])>0 ? " c.id!=".intval($posted["id"])." And " : "" )
                   ." cc.s_name='".$posted["duplicate_value"]."' AND c.s_category_type = '".$this->type."' AND cc.i_lang_id=".$this->i_admin_language." ";
					
					
                //$info=$this->mod_rect->fetch_multi($qry,$start,$limit); /*don't change*/
				$info=$this->mod_rect->fetch_multi($qry,$start=0,$limit=1); /*don't change*/
				
                if(!empty($info))/////Duplicate exists
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
	
    function ajax_change_parent_event()
    {
        $item_type  = decrypt($this->input->post('item_id'));
		$parent_detail_option=makeOption($this->mod_rect->get_cat_selectlist((isset($item_type))?$item_type:'',0,0,-1));
        echo '<select id="opt_parent_id" name="opt_parent_id" style="width:200px;">
              <option value="0">---None---</option>'.$parent_detail_option.'</select>';
    }
	
	
	public function multilangCat()
	{
		$info	= $this->mod_rect->fetch_multi('');
		 for($i=0; $i<count($info); $i++)
		{
			$arr = array();
			
			$arr['i_cat_id']	= $info[$i]["id"];
			$arr['s_name']	= $info[$i]["s_category_name"];
			$arr['i_lang_id']	= 1;
			$table = $this->db->CATEGORYCHILD;
			$this->mod_rect->set_data_insert($table,$arr);
			$arr['i_lang_id']	= 2;
			$this->mod_rect->set_data_insert($table,$arr);

		} 
	}
	  
	public function __destruct()
    {}
	
	
}
