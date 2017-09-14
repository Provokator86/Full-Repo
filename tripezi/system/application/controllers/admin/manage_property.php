<?php
/*********
* Author: Koushik 
* Email: koushik.r@acumensoft.info   
* Date  : 16 Nov 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For property
* 
* @package User
* @subpackage manage_property
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/property_model.php
* @link views/admin/property/
*/
class Manage_property extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->data['title']="Property";////Browser Title

           
          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]="No information found about property.";
          $this->cls_msg["save_err"]="Information about  property failed to save.";
          $this->cls_msg["save_succ"]="Information about  property saved successfully.";
          $this->cls_msg["delete_err"]="Information about  property failed to remove.";
          $this->cls_msg["delete_succ"]="Information about  property removed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
          
          //////// loading default model here //////////////
          $this->load->model("property_model","mod_rect");
		  $this->load->model("common_model","mod_common");
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
           
           
            $this->data['heading']="Manage Property";////Package Name[@package] Panel Heading

            ///////////generating search query///////
            
            
            
            ////////Getting Posted or session values for search///
            $arr_session_data    =    $this->session->userdata("arr_session");
            if($arr_session_data['searching_name']!=$this->data['heading'])
            {
                $this->session->unset_userdata("arr_session");
                $arr_session_data   =   array();
            }
            
            $search_variable     =    array();
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $search_variable["s_property_id"]  =($this->input->post("h_search")?$this->input->post("txt_property_id"):$arr_session_data["txt_property_id"]); 
            $search_variable["s_property_name"]=($this->input->post("h_search")?$this->input->post("txt_property_name"):$arr_session_data["txt_property_name"]); 
            $search_variable["s_owner_name"]   =($this->input->post("h_search")?$this->input->post("txt_owner_name"):$arr_session_data["txt_owner_name"]); 
            $search_variable["s_owner_email"]  =($this->input->post("h_search")?$this->input->post("txt_owner_email"):$arr_session_data["txt_owner_email"]);
            $search_variable["d_price"]        =($this->input->post("h_search")?$this->input->post("txt_price"):$arr_session_data["txt_price"]);
            $search_variable["i_amenity"]      =($this->input->post("h_search")?$this->input->post("opt_amenity"):$arr_session_data["opt_amenity"]);
            $search_variable["i_country"]      =($this->input->post("h_search")?$this->input->post("opt_country"):$arr_session_data["opt_country"]);
            $search_variable["i_state"]        =($this->input->post("h_search")?$this->input->post("opt_state"):$arr_session_data["opt_state"]);
            $search_variable["i_city"]         =($this->input->post("h_search")?$this->input->post("opt_city"):$arr_session_data["opt_city"]);
            $search_variable["s_zipcode"]      =($this->input->post("h_search")?$this->input->post("txt_zipcode"):$arr_session_data["txt_zipcode"]);
            $search_variable["dt_from"]        =($this->input->post("h_search")?$this->input->post("txt_date_from"):$arr_session_data["txt_date_from"]);
            $search_variable["dt_to"]          =($this->input->post("h_search")?$this->input->post("txt_date_to"):$arr_session_data["txt_date_to"]);
           
            ////////end Getting Posted or session values for search///

            $s_where=" WHERE 1 ";
            
            if($s_search=="advanced")
            {
                if(trim($search_variable["s_property_id"]))
                {
                    $s_where.=" And p.s_property_id LIKE '%".get_formatted_string($search_variable["s_property_id"])."%' ";
                } 
                if(trim($search_variable["s_property_name"]))
                {
                    $s_where.=" And p.s_property_name LIKE '%".get_formatted_string($search_variable["s_property_name"])."%' ";
                } 
                if(trim($search_variable["s_owner_name"]))
                {
                    $s_where.=" And CONCAT(u.s_first_name,' ',u.s_last_name) LIKE '%".get_formatted_string($search_variable["s_owner_name"])."%' ";
                } 
                if(trim($search_variable["s_owner_email"]))
                {
                    $s_where.=" And u.s_email LIKE '%".get_formatted_string($search_variable["s_owner_email"])."%' ";
                } 
                if(trim($search_variable["d_price"]))
                {
                    $s_where.=" And p.d_standard_price =".$search_variable["d_price"]." ";
                }
                 if(trim($search_variable["i_amenity"]))
                {
                    $s_where.=" And pa.i_amenity_id =".decrypt($search_variable["i_amenity"])." ";
                }
                if(trim($search_variable["i_country"]))
                {
                    $s_where.=" And p.i_country_id =".decrypt($search_variable["i_country"])." ";
                }
                if(trim($search_variable["i_state"]))
                {
                    $s_where.=" And p.i_state_id =".decrypt($search_variable["i_state"])." ";
                }
                if(trim($search_variable["i_city"]))
                {
                    $s_where.=" And p.i_city_id =".decrypt($search_variable["i_city"])." ";
                }
                if(trim($search_variable["s_zipcode"]))
                {
                    $s_where.=" And p.s_zipcode LIKE '%".get_formatted_string($search_variable["s_zipcode"])."%' ";
                }
                if(trim($search_variable["dt_from"])!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($search_variable["dt_from"]." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( p.dt_created_on , '%Y-%m-%d' ) >='".$dt_start."' ";
                    unset($dt_start);
                }
                if(trim($search_variable["dt_to"])!="")
                {
                    $dt_end=date("Y-m-d",strtotime(trim($search_variable["dt_to"]." "))) ; 
                    $s_where.=" And FROM_UNIXTIME( p.dt_created_on , '%Y-%m-%d' ) <='".$dt_end."' ";
                    unset($dt_start);
                }
               
                
                /////Storing search values into session///
                $arr_session    =   array();
                
                $arr_session["searching_name"]  = $this->data['heading'] ;
                  
                $arr_session["txt_property_id"] = $search_variable["s_property_id"] ;  
                $arr_session["txt_property_name"] = $search_variable["s_property_name"] ;  
                $arr_session["txt_owner_name"] = $search_variable["s_owner_name"] ;  
                $arr_session["txt_owner_email"] = $search_variable["s_owner_email"] ;  
                $arr_session["txt_price"] = $search_variable["d_price"]  ;  
                $arr_session["opt_amenity"] = $search_variable["i_amenity"]  ;  
                $arr_session["opt_country"] = $search_variable["i_country"]  ;  
                $arr_session["opt_state"] = $search_variable["i_state"]  ;  
                $arr_session["opt_city"] = $search_variable["i_city"]  ;  
                $arr_session["txt_zipcode"] = $search_variable["s_zipcode"]  ;  
                $arr_session["txt_date_from"] = $search_variable["dt_from"]  ;  
                $arr_session["txt_date_to"] = $search_variable["dt_to"]  ;  
                
          
                
                $this->session->set_userdata("arr_session",$arr_session);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_property_id"]=get_unformatted_string($search_variable["s_property_id"]);                
                $this->data["txt_property_name"]=get_unformatted_string($search_variable["s_property_name"]);                
                $this->data["txt_owner_name"]=get_unformatted_string($search_variable["s_owner_name"]);                
                $this->data["txt_owner_email"]=get_unformatted_string($search_variable["s_owner_email"]);                
                $this->data["txt_price"]=get_unformatted_string($search_variable["d_price"]);                
                $this->data["opt_amenity"]=$search_variable["i_amenity"];                
                $this->data["opt_country"]=$search_variable["i_country"];                
                $this->data["opt_state"]=$search_variable["i_state"];                
                $this->data["opt_city"]=$search_variable["i_city"];                
                $this->data["txt_zipcode"]=get_unformatted_string($search_variable["s_zipcode"]);                
                $this->data["txt_date_from"]=$search_variable["dt_from"];                
                $this->data["txt_date_to"]=$search_variable["dt_to"];                
                             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where="  WHERE 1 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("arr_session");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_property_id"]="";
                $this->data["txt_property_name"]="";
                $this->data["txt_owner_name"]="";
                $this->data["txt_owner_email"]="";
                $this->data["txt_price"]="";
                $this->data["opt_amenity"]="";
                $this->data["opt_country"]="";
                $this->data["opt_state"]="";
                $this->data["opt_city"]="";
                $this->data["txt_zipcode"]="";
                $this->data["txt_date_from"]="";
                $this->data["txt_date_to"]="";
                $this->data["txt_created_on"]="";
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$arr_session,$search_variable);
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
            $arr_sort = array(1=>'s_title',2=>'dt_created_on');
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[2]:$arr_sort[2];
            
            
            $limit    = $this->i_admin_page_limit;
            //$info    = $this->mod_rect->fetch_multi($s_where,intval($start),$limit);
            $info    = $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);

           

            /////////Creating List view for displaying/////////
            $table_view=array(); 
            $order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
                     
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Manage property";
            $table_view["total_rows"]=count($info);
            $table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
            $table_view["order_name"]=$order_name;
            $table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method(); 
            $table_view["detail_view"]=false; 
                    
             $table_view["headers"][0]["width"]  ="30%";
             $table_view["headers"][0]["align"]  ="left";
             $table_view["headers"][0]["val"]    ="Proprety Information";
             $table_view["headers"][1]["width"]  ="30%";
             $table_view["headers"][1]["val"]    ="Owner Information";
             $table_view["headers"][2]["width"]  ="20%";
             $table_view["headers"][2]["val"]    ="Price";
             $table_view["headers"][3]["width"]  ="8%";
             $table_view["headers"][3]["val"]    ="Created on";
            //////end Table Headers, with width,alignment///////
            
           
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $enc_id                                  = encrypt($info[$i]["id"]) ;  
                $table_view["tablerows"][$i][$i_col++]    = $enc_id;////Index 0 must be the encrypted PK 
               
                $table_view["tablerows"][$i][$i_col++]    = "<table><tr><td width=\"35%\">Property ID</td><td>".$info[$i]["s_property_id"]."</td></tr>
                                                                <tr><td width=\"35%\">Property Name</td><td>".$info[$i]["s_property_name"]."</td></tr>
                                                                <tr><td rowspan=\"2\">Location</td><td>".$info[$i]["s_city"].",".$info[$i]["s_state"]."</td></tr>
                                                                <tr><td>".$info[$i]["s_country"].",".$info[$i]["s_zipcode"]."</td></tr></table>";
                                                                
                $table_view["tablerows"][$i][$i_col++]    = "<table><tr><td width=\"35%\">Property Owner</td><td>".$info[$i]["s_first_name"]." ".$info[$i]["s_last_name"]."</td></tr>
                                                                <tr><td>Email</td><td>".$info[$i]["s_email"]."</td></tr>
                                                            </table>";
      
                $table_view["tablerows"][$i][$i_col++]    = "<table><tr><td width=\"60%\">Standard Price</td><td>".$info[$i]["s_currency_symbol"].$info[$i]["d_standard_price"]."</td></tr>
                                                                <tr><td>Weekly Rate</td><td>".$info[$i]["s_currency_symbol"].$info[$i]["d_weekly_price"]."</td></tr>
                                                                <tr><td>Monthly Rate</td><td>".$info[$i]["s_currency_symbol"].$info[$i]["d_monthly_price"]."</td></tr>
                                                                <tr><td>Additional Guests</td><td>".$info[$i]["s_currency_symbol"].$info[$i]["d_additional_price"]."</td></tr></table>";   
                $table_view["tablerows"][$i][$i_col++]    = $info[$i]["dt_created_on"];
                
                $action =   '';
				if($this->data['action_allowed']["Status"])
                 {
					if($info[$i]["i_status"]==1)
					{
						 $action .= '<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["id"]).'_inactive"><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/inactive.png"></a>&nbsp;';
					}
					else
					{
						$action .= '<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["id"]).'_active"><img width="12" height="12" title="Active" alt="Active" src="images/admin/active.png"></a>';
					}
				}
                $action .= '<a  href="javascript:void(0);" onclick="show_property_details(\''.$enc_id.'\')" ><img width="12" height="12" title="View Details" alt="View Details" src="images/admin/view.png"></a>';
               
               
              
                if($action!='')
                {
                    $table_view["rows_action"][$i]    = $action;           
                }

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
     /***
    * Checks duplicate value using ajax call
    */
    public function ajax_checkduplicate()
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
    * Change status of the property 
    * @author Mrinmoy 
    */
    public function ajax_change_status()
    {
        try
        {
            $posted				= array();
			$posted["id"]       = decrypt(trim($this->input->post("h_id")));
			$posted["i_status"] = trim($this->input->post("i_status"));
			//pr($posted,1);
			$info 				= array();
			$info['i_status']   = $posted["i_status"];
			$arr_where          = array('i_id'=>$posted["id"]);
			$i_rect				= $this->mod_common->common_edit_info($this->db->PROPERTY,$info,$arr_where); /*don't change*/                
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
    
    public function property_details($enc_id)
    {
        try
        {
            // fetch the details of property
            $info   =   $this->mod_rect->fetch_this(decrypt(trim($enc_id)));
            $this->data["info"] =   $info ;
            
            // fetch the all amenity of a property
            $s_where        =   " WHERE pa.i_property_id= ".decrypt(trim($enc_id))." AND a.i_status=1";
            $info_amenity   =   $this->mod_rect->fetch_property_amenity($s_where) ;
            
            $arr_amenity    =   array(); 
            if(!empty($info_amenity))
            {
                
                foreach($info_amenity as $val)
                {
                    $arr_amenity[]    =   $val['s_name'];
                }
            }
            $this->data['s_amenities']  =   implode(', ',$arr_amenity); // Make a string of amenities separated by ,
            
            $s_where        =   " WHERE pi.i_property_id= ".decrypt(trim($enc_id))." " ;
            $info_image     =   $this->mod_rect->fetch_property_image($s_where) ;
            
            $arr_image   =   array();
            if(!empty($info_image))
            {
                $i  =   0;
                foreach($info_image as $val)
                {
                    $file_name  =   getFilenameWithoutExtension($val["s_property_image"]);
                    $arr_image[$i]["large"]  =   $file_name."_large.jpg";
                    $arr_image[$i]["min"]  =   $file_name."_min.jpg";
                    $i++; 
                }
            }
            $this->data["arr_image"]    =   $arr_image ;
           
            unset($info,$info_amenity,$arr_amenity,$enc_id);
            

            $this->add_css("css/admin/slider.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");
            $this->add_js("js/admin/jquery.ad-gallery.js");
            //$this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
           
            $this->render("manage_property/property_details",TRUE);
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }   
    public function __destruct()
    {}
    
    
}