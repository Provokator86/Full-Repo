<?php
/*********
* Author: Iman Biswas
* Date  : 22 Sep 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Controller For news
* 
* @package Content Management
* @subpackage News
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/news_model.php
* @link views/admin/news/
*/


class Job_live_report extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="Auctions Report";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]="No information found.";
          $this->cls_msg["save_err"]="Information failed to save.";
          $this->cls_msg["save_succ"]="Information saved successfully.";
          $this->cls_msg["delete_err"]="Information failed to remove.";
          $this->cls_msg["delete_succ"]="Information removed successfully.";
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  //////// loading default model here //////////////
          $this->load->model("job_posted_model","mod_rect");
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
            $this->data['heading']="Live Auctions";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			//echo encrypt(10); exit;
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
			$dt_to=($this->input->post("h_search")?$this->input->post("txt_to"):$this->session->userdata("txt_to"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status=1 ";
            if($s_search=="basic")
            {
/*                $s_where=" WHERE n.s_title LIKE '%".get_formatted_string($s_news_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_news_title",$s_news_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_news_title"]=$s_news_title;
                /////end Storing search values into session///
*/            }
            elseif($s_search=="advanced")
            {
                
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    //$s_where.=" WHERE FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) >='".$dt_start."' ";
					$arr_search[]="  FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) >='".$dt_start."' ";
                    unset($dt_start);
                }
				if(trim($dt_to)!="")
				{
					$dt_end = date("Y-m-d",strtotime(trim($dt_to." "))) ; 
					//$s_where.=" And FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) <='".$dt_end."' ";
					$arr_search[]="  FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) <='".$dt_end."' ";
                    unset($dt_end);
				}
				$s_where .= (count($arr_search) !=0)?' AND '.implode('AND',$arr_search):'';	
                //echo $s_where; exit;
                /////Storing search values into session///
                $this->session->set_userdata("txt_created_on",$dt_created_on);
				$this->session->set_userdata("txt_to",$dt_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_created_on"]=$dt_created_on; 
				$this->data["txt_to"]=$dt_to;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_status=1 ";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_created_on");
				$this->session->unset_userdata("txt_to");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_created_on"]="";   
				$this->data["txt_to"]="";           
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
            $table_view["caption"]="Job Live";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
                        
            $table_view["headers"][0]["width"]	="25%";
            $table_view["headers"][0]["align"]	="left";
            $table_view["headers"][0]["val"]	="Title";
			$table_view["headers"][1]["val"]	="Description";
            $table_view["headers"][2]["val"]	="Posted On"; 
            $table_view["headers"][3]["val"]	="Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_title"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_description"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_entry_date"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_is_active"];

            } 
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
    {}
    

    /***
    * Method to Delete information
    * This have no interface but db operation 
    * will be done here.
    * 
    * On Success redirect to the showList interface else display error in showList interface. 
    * @param int $i_id, id of the record to be modified.
    */      
    public function remove_information($i_id=0)
    {} 
    
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
					$temp["s_title"]= trim($info["s_title"]);
					$temp["s_description"]= trim($info["s_description"]);
					$temp["s_buyer"]= trim($info["s_buyer_name"]);
					$temp["s_category"] = trim($info["s_category"]);
					$temp["s_is_active"]= trim($info["s_is_active"]);
					$temp["dt_created_on"]= trim($info["dt_entry_date"]);
					$temp["dt_approved_on"]= trim($info["dt_approval_date"]);
					$temp["dt_expired_on"]= trim($info["dt_expire_date"]);

					$this->data["info"]=$temp;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            
            $this->render("job_live_report/show_detail",TRUE);
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
    {}    
	
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
			
			if(decrypt($type)==3){ $job_type = "Won";}
			else if(decrypt($type)==10){ $job_type = "Closed";}
			
            $this->data['heading']= "Job ".$job_type;////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
			$dt_to=($this->input->post("h_search")?$this->input->post("txt_to"):$this->session->userdata("txt_to"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status=".decrypt($type)." ";
            if($s_search=="basic")
            {
/*                $s_where=" WHERE n.s_title LIKE '%".get_formatted_string($s_news_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_news_title",$s_news_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_news_title"]=$s_news_title;
                /////end Storing search values into session///
*/            }
            elseif($s_search=="advanced")
            {
                
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    //$s_where.=" WHERE FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) >='".$dt_start."' ";
					$arr_search[]="  FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) >='".$dt_start."' ";
                    unset($dt_start);
                }
				if(trim($dt_to)!="")
				{
					$dt_end = date("Y-m-d",strtotime(trim($dt_to." "))) ; 
					//$s_where.=" And FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) <='".$dt_end."' ";
					$arr_search[]="  FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) <='".$dt_end."' ";
                    unset($dt_end);
				}
				$s_where .= (count($arr_search) !=0)?' AND '.implode('AND',$arr_search):'';	
                //echo $s_where; exit;
                /////Storing search values into session///
                $this->session->set_userdata("txt_created_on",$dt_created_on);
				$this->session->set_userdata("txt_to",$dt_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_created_on"]=$dt_created_on; 
				$this->data["txt_to"]=$dt_to;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_status=".decrypt($type)." ";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_created_on");
				$this->session->unset_userdata("txt_to");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_created_on"]="";   
				$this->data["txt_to"]="";           
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
            $table_view["caption"]="Job ".$job_type;
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
                        
            $table_view["headers"][0]["width"]	="25%";
            $table_view["headers"][0]["align"]	="left";
            $table_view["headers"][0]["val"]	="Title";
			$table_view["headers"][1]["val"]	="Description";
            $table_view["headers"][2]["val"]	="Posted On"; 
            $table_view["headers"][3]["val"]	="Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_title"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_description"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_entry_date"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_is_active"];

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
	
	/****
    * Display the list of records
    * 
    */
    public function show_report_list($order_name='',$order_by='DESC',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Live Auctions";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			//echo encrypt(10); exit;
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            
            $s_cat=($this->input->post("h_search")?$this->input->post("s_cat"):$this->session->userdata("s_cat")); 
			
			$opt_buyer_id=($this->input->post("h_search")?$this->input->post("opt_buyer_id"):$this->session->userdata("opt_buyer_id")); 
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status=1  AND n.i_is_deleted=0 ";
            if($s_search=="basic")
            {
/*                $s_where=" WHERE n.s_title LIKE '%".get_formatted_string($s_news_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_news_title",$s_news_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_news_title"]=$s_news_title;
                /////end Storing search values into session///
*/            }
            elseif($s_search=="advanced")
            {
                if($s_title)
				{
                	$arr_search[]="  n.s_title LIKE '%".get_formatted_string($s_title)."%' ";
				}
				if($s_cat!="")
				{
					$arr_search[]="  n.i_category_id=".decrypt($s_cat)." ";
				}
				
				if($opt_buyer_id!="")
				{
					$arr_search[]="  n.i_buyer_user_id=".decrypt($opt_buyer_id)." ";
				}
               
				$s_where .= (count($arr_search) !=0)?' AND '.implode('AND',$arr_search):'';	
                //echo $s_where; exit;
                /////Storing search values into session///
				 $this->session->set_userdata("s_title",$s_title);
				$this->session->set_userdata("s_cat",$s_cat);
				$this->session->set_userdata("opt_buyer_id",$opt_buyer_id);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
				$this->session->set_userdata("txt_to",$dt_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
				$this->data["s_title"]=$s_title;   
				$this->data["s_cat"]=$s_cat;     
				$this->data["opt_buyer_id"]=$opt_buyer_id;  
                $this->data["txt_created_on"]=$dt_created_on; 
				$this->data["txt_to"]=$dt_to;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_status=1  AND n.i_is_deleted=0 ";
                /////Releasing search values from session///
				$this->session->unset_userdata("s_title");
				$this->session->unset_userdata("s_cat");
				$this->session->unset_userdata("opt_buyer_id");
                $this->session->unset_userdata("txt_created_on");
				$this->session->unset_userdata("txt_to");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
				$this->data["s_title"]="";      
				$this->data["s_cat"]="";        
				$this->data["opt_buyer_id"]='';  
                $this->data["txt_created_on"]="";   
				$this->data["txt_to"]="";           
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
			$i_uri_seg = 6;
            ///Setting Limits, If searched then start from 0////
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
                $start=$this->uri->segment($i_uri_seg);
            }
            ///////////end generating search query///////
             
            // List of fields for sorting
			$arr_sort = array(0=>'n.i_created_date',1=>'n.s_title');   
			// echo $order_name.'---';
			//  echo decrypt($order_name);
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name;
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_report_multi($s_where,$s_order_name,$order_by,intval($start),$limit);
			

            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Job Live";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method();
			$table_view["detail_view"] = FALSE;
            $j_col=0;
		//	$table_view["headers"][$j_col]["width"]	="15%";            
            $table_view["headers"][$j_col]["val"]	="Title";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[1]));
			$table_view["headers"][++$j_col]["val"]	="Client";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Category";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Budget Price";
			$table_view["headers"][$j_col]["width"]	="9%";
			$table_view["headers"][$j_col]["align"]	="right";
			$table_view["headers"][++$j_col]["val"]	="Total Quote";
			$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="8%"; 
		//	$table_view["headers"][++$j_col]["val"]	="City";
		//	$table_view["headers"][++$j_col]["val"]	="Postalcode";			
            $table_view["headers"][++$j_col]["val"]	="Posted On"; 
			$table_view["headers"][$j_col]["width"]	="9%"; 
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][++$j_col]["val"]	="Action"; 
			$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="5%"; 
          //  $table_view["headers"][++$j_col]["val"]	="Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_title"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_username"];  
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_category_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["d_budget_price"].' '. $this->config->item('default_currency');
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_quotes"];
				//$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_city"];
			//	$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_postal_code"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_entry_date"];
           		$table_view["tablerows"][$i][$i_col++]	=' <a title="View" href="'.admin_base_url().'job_overview/index/'.encrypt($info[$i]["id"]).'" target="_blank">'.'<img src="images/admin/view.png" alt="View" />';

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            //echo $this->data["search_action"];
            $this->data['order_name'] = $order_name;
			$this->data['order_by'] = $order_by;
            $this->render();          
            unset($table_view,$info);
          
        }
        catch(Exception $err_obj)
        {
        	show_error($err_obj->getMessage());
        }          
    }  
	
	 public function show_frozen($order_name='',$order_by='DESC',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Frozen Auctions";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			//echo encrypt(10); exit;
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            
            $s_cat=($this->input->post("h_search")?$this->input->post("s_cat"):$this->session->userdata("s_cat")); 
			
			$opt_buyer_id=($this->input->post("h_search")?$this->input->post("opt_buyer_id"):$this->session->userdata("opt_buyer_id")); 
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status=8  AND n.i_is_deleted=0 ";
            if($s_search=="basic")
            {
/*                $s_where=" WHERE n.s_title LIKE '%".get_formatted_string($s_news_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_news_title",$s_news_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_news_title"]=$s_news_title;
                /////end Storing search values into session///
*/            }
            elseif($s_search=="advanced")
            {
                if($s_title)
				{
                	$arr_search[]="  n.s_title LIKE '%".get_formatted_string($s_title)."%' ";
				}
				
				if($opt_buyer_id!="")
				{
					$arr_search[]="  n.i_buyer_user_id=".decrypt($opt_buyer_id)." ";
				}
               
				$s_where .= (count($arr_search) !=0)?' AND '.implode('AND',$arr_search):'';	
                //echo $s_where; exit;
                /////Storing search values into session///
				 $this->session->set_userdata("s_title",$s_title);
				$this->session->set_userdata("s_cat",$s_cat);
				$this->session->set_userdata("opt_buyer_id",$opt_buyer_id);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
				$this->session->set_userdata("txt_to",$dt_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
				$this->data["s_title"]=$s_title;   
				$this->data["s_cat"]=$s_cat;     
				$this->data["opt_buyer_id"]=$opt_buyer_id;  
                $this->data["txt_created_on"]=$dt_created_on; 
				$this->data["txt_to"]=$dt_to;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_status=8  AND n.i_is_deleted=0 ";
                /////Releasing search values from session///
				$this->session->unset_userdata("s_title");
				$this->session->unset_userdata("s_cat");
				$this->session->unset_userdata("opt_buyer_id");
                $this->session->unset_userdata("txt_created_on");
				$this->session->unset_userdata("txt_to");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
				$this->data["s_title"]="";      
				$this->data["s_cat"]="";        
				$this->data["opt_buyer_id"]='';  
                $this->data["txt_created_on"]="";   
				$this->data["txt_to"]="";           
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
			$i_uri_seg = 6;
            ///Setting Limits, If searched then start from 0////
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
                $start=$this->uri->segment($i_uri_seg);
            }
            ///////////end generating search query///////
             
            // List of fields for sorting
			$arr_sort = array(0=>'n.i_assigned_date',1=>'n.s_title');   
			// echo $order_name.'---';
			//  echo decrypt($order_name);
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name;
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_report_multi($s_where,$s_order_name,$order_by,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Job Live";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method();
			$table_view["detail_view"] = FALSE;
            $j_col=0;
		//	$table_view["headers"][$j_col]["width"]	="15%";       
		  $table_view["headers"][$j_col]["val"]	="Title";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[1]));
			$table_view["headers"][++$j_col]["val"]	="Client";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Category";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Professional";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Quoted Amount";
			$table_view["headers"][$j_col]["align"]	="right";
			$table_view["headers"][$j_col]["width"]	="11%"; 
            $table_view["headers"][++$j_col]["val"]	="Selected On"; 
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][$j_col]["width"]	="9%"; 
			
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_title"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_username"];  
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_category_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_tradesman_name"];
				$ar_quote = $info[$i]["ar_quote"];
				$table_view["tablerows"][$i][$i_col++]	=$ar_quote[0]["d_quote"].' '. $this->config->item('default_currency');
				//$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_city"];
			//	$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_postal_code"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_assigned_date"];
           //		$table_view["tablerows"][$i][$i_col++]	=' <a title="View" href="'.admin_base_url().'job_overview/index/'.encrypt($info[$i]["id"]).'" target="_blank">'.'<img src="images/admin/view.png" alt="View" />';

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            //echo $this->data["search_action"];
            $this->data['order_name'] = $order_name;
			$this->data['order_by'] = $order_by;
            $this->render();          
            unset($table_view,$info);
          
        }
        catch(Exception $err_obj)
        {
        	show_error($err_obj->getMessage());
        }          
    }  
	
	public function show_expired($order_name='',$order_by='DESC',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Expired Auctions";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			//echo encrypt(10); exit;
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            
            $s_cat=($this->input->post("h_search")?$this->input->post("s_cat"):$this->session->userdata("s_cat")); 
			
			$opt_buyer_id=($this->input->post("h_search")?$this->input->post("opt_buyer_id"):$this->session->userdata("opt_buyer_id")); 
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status=7  AND n.i_is_deleted=0 ";
            if($s_search=="basic")
            {
/*                $s_where=" WHERE n.s_title LIKE '%".get_formatted_string($s_news_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_news_title",$s_news_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_news_title"]=$s_news_title;
                /////end Storing search values into session///
*/            }
            elseif($s_search=="advanced")
            {
                if($s_title)
				{
                	$arr_search[]="  n.s_title LIKE '%".get_formatted_string($s_title)."%' ";
				}
				
				if($opt_buyer_id!="")
				{
					$arr_search[]="  n.i_buyer_user_id=".decrypt($opt_buyer_id)." ";
				}
               
				$s_where .= (count($arr_search) !=0)?' AND '.implode('AND',$arr_search):'';	
                //echo $s_where; exit;
                /////Storing search values into session///
				 $this->session->set_userdata("s_title",$s_title);
				$this->session->set_userdata("s_cat",$s_cat);
				$this->session->set_userdata("opt_buyer_id",$opt_buyer_id);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
				$this->session->set_userdata("txt_to",$dt_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
				$this->data["s_title"]=$s_title;   
				$this->data["s_cat"]=$s_cat;     
				$this->data["opt_buyer_id"]=$opt_buyer_id;  
                $this->data["txt_created_on"]=$dt_created_on; 
				$this->data["txt_to"]=$dt_to;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_status=7  AND n.i_is_deleted=0 ";
                /////Releasing search values from session///
				$this->session->unset_userdata("s_title");
				$this->session->unset_userdata("s_cat");
				$this->session->unset_userdata("opt_buyer_id");
                $this->session->unset_userdata("txt_created_on");
				$this->session->unset_userdata("txt_to");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
				$this->data["s_title"]="";      
				$this->data["s_cat"]="";        
				$this->data["opt_buyer_id"]='';  
                $this->data["txt_created_on"]="";   
				$this->data["txt_to"]="";           
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
			$i_uri_seg = 6;
            ///Setting Limits, If searched then start from 0////
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
                $start=$this->uri->segment($i_uri_seg);
            }
            ///////////end generating search query///////
             
            // List of fields for sorting
			$arr_sort = array(0=>'n.i_expire_date',1=>'n.s_title');   
			// echo $order_name.'---';
			//  echo decrypt($order_name);
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name;
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_report_multi($s_where,$s_order_name,$order_by,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Job Live";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method();
			$table_view["detail_view"] = FALSE;
            $j_col=0;
		
		     
            $table_view["headers"][$j_col]["val"]	="Title";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[1]));
			$table_view["headers"][++$j_col]["val"]	="Client";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Category";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Budget";
			$table_view["headers"][$j_col]["width"]	="9%";
			$table_view["headers"][$j_col]["align"]	="right";
			$table_view["headers"][++$j_col]["val"]	="Total Quote";
			$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="8%"; 
		//	$table_view["headers"][++$j_col]["val"]	="City";
		//	$table_view["headers"][++$j_col]["val"]	="Postalcode";			
            $table_view["headers"][++$j_col]["val"]	="Expired On"; 
			$table_view["headers"][$j_col]["width"]	="9%"; 
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][++$j_col]["val"]	="Action"; 
			$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="5%"; 
          //  $table_view["headers"][++$j_col]["val"]	="Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_title"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_username"];  
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_category_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["d_budget_price"].' '. $this->config->item('default_currency');
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_quotes"];

			//	$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_postal_code"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_expire_date"];
           		$table_view["tablerows"][$i][$i_col++]	=' <a  href="'.admin_base_url().'job_overview/index/'.encrypt($info[$i]["id"]).'/'.encrypt(2).'" target="_blank">'.'<img src="images/admin/view.png" title="View" alt="View" />';

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            //echo $this->data["search_action"];
            $this->data['order_name'] = $order_name;
			$this->data['order_by'] = $order_by;
            $this->render();          
            unset($table_view,$info);
          
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
    public function show_report_param_list($type=NULL,$order_name='i_created_date',$order_by='DESC',$start=NULL,$limit=NULL)
    {
        try
        {
			if(empty($type))
			{
				 redirect($this->pathtoclass."show_report_list");
				 exit;
			}	 
			
			if(decrypt($type)==3){ $job_type = "Won";}
			else if(decrypt($type)==10){ $job_type = "Closed";}
			
            $this->data['heading']= "Job ".$job_type;////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
			$dt_to=($this->input->post("h_search")?$this->input->post("txt_to"):$this->session->userdata("txt_to"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status=".decrypt($type)." ";
            if($s_search=="basic")
            {
/*                $s_where=" WHERE n.s_title LIKE '%".get_formatted_string($s_news_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_news_title",$s_news_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_news_title"]=$s_news_title;
                /////end Storing search values into session///
*/            }
            elseif($s_search=="advanced")
            {                
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    //$s_where.=" WHERE FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) >='".$dt_start."' ";
					$arr_search[]="  FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) >='".$dt_start."' ";
                    unset($dt_start);
                }
				if(trim($dt_to)!="")
				{
					$dt_end = date("Y-m-d",strtotime(trim($dt_to." "))) ; 
					//$s_where.=" And FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) <='".$dt_end."' ";
					$arr_search[]="  FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) <='".$dt_end."' ";
                    unset($dt_end);
				}
				$s_where .= (count($arr_search) !=0)?' AND '.implode('AND',$arr_search):'';	
                //echo $s_where; exit;
                /////Storing search values into session///
                $this->session->set_userdata("txt_created_on",$dt_created_on);
				$this->session->set_userdata("txt_to",$dt_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_created_on"]=$dt_created_on; 
				$this->data["txt_to"]=$dt_to;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_status=".decrypt($type)." ";
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_created_on");
				$this->session->unset_userdata("txt_to");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_created_on"]="";   
				$this->data["txt_to"]="";           
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
            ///Setting Limits, If searched then start from 0////
           $i_uri_seg = 7;
            ///Setting Limits, If searched then start from 0////
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
                $start=$this->uri->segment($i_uri_seg);
            }
            ///////////end generating search query///////
            
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_report_multi($s_where,$order_name,$order_by,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Job ".$job_type;
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
                        
            $table_view["headers"][0]["val"]	="Title";
			$table_view["headers"][1]["val"]	="Job Won";
			$table_view["headers"][2]["val"]	="Category";
			$table_view["headers"][3]["val"]	="Budget Price";
			$table_view["headers"][4]["val"]	="State";
			$table_view["headers"][5]["val"]	="City";
			$table_view["headers"][6]["val"]	="Postalcode";
            $table_view["headers"][7]["val"]	="Posted On"; 
            $table_view["headers"][8]["val"]	="Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_title"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_tradesman_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_category_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["d_budget_price"].' '. $this->config->item('default_currency');
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_state"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_city"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_postal_code"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_entry_date"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_is_active"];

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_report_showin_table($table_view,TRUE);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method().'/'.$type;///used for search form action
            //$this->data["edit_action"]=$this->pathtoclass.'modify_information'.'/'.$type;///used for search form action
            $this->data['order_name'] = $order_name;
			$this->data['order_by'] = $order_by;
            $this->render();          
            unset($table_view,$info);
          
        }
        catch(Exception $err_obj)
        {
        	show_error($err_obj->getMessage());
        }          
    } 	
	  	
	
	public function show_closed_list($order_name='',$order_by='DESC',$start=NULL,$limit=NULL)
    {
        try
        {
			if(empty($type))
			
            $this->data['heading']= "Closed Auctions";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
             $s_title=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            
            $s_cat=($this->input->post("h_search")?$this->input->post("s_cat"):$this->session->userdata("s_cat")); 
			
			$opt_buyer_id=($this->input->post("h_search")?$this->input->post("opt_buyer_id"):$this->session->userdata("opt_buyer_id"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE (n.i_status=10 || n.i_status=6 || n.i_status=7)  AND n.i_is_deleted=0 AND cat_c.i_lang_id=".$this->i_admin_language;
			
            if($s_search=="advanced")
            {                
                if(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
                    //$s_where.=" WHERE FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) >='".$dt_start."' ";
					$arr_search[]="  FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) >='".$dt_start."' ";
                    unset($dt_start);
                }
				if(trim($dt_to)!="")
				{
					$dt_end = date("Y-m-d",strtotime(trim($dt_to." "))) ; 
					//$s_where.=" And FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) <='".$dt_end."' ";
					$arr_search[]="  FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) <='".$dt_end."' ";
                    unset($dt_end);
				}
				$s_where .= (count($arr_search) !=0)?' AND '.implode('AND',$arr_search):'';	
                //echo $s_where; exit;
                /////Storing search values into session///
               $this->session->set_userdata("s_title",$s_title);
				$this->session->set_userdata("s_cat",$s_cat);
				$this->session->set_userdata("opt_buyer_id",$opt_buyer_id);
                $this->session->set_userdata("h_search",$s_search);
                
				$this->data["s_title"]=$s_title;   
				$this->data["s_cat"]=$s_cat;     
				$this->data["opt_buyer_id"]=$opt_buyer_id;
                $this->data["h_search"]=$s_search;
                $this->data["txt_created_on"]=$dt_created_on; 
				$this->data["txt_to"]=$dt_to;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE (n.i_status=10 || n.i_status=6 || n.i_status=7) AND n.i_is_deleted=0 AND cat_c.i_lang_id=".$this->i_admin_language;
                /////Releasing search values from session///
                $this->session->unset_userdata("txt_created_on");
				$this->session->unset_userdata("txt_to");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
				$this->data["s_title"]="";      
				$this->data["s_cat"]="";        
				$this->data["opt_buyer_id"]='';  
                $this->data["txt_created_on"]="";   
				$this->data["txt_to"]="";           
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
            ///Setting Limits, If searched then start from 0////
            $i_uri_seg = 6;
            ///Setting Limits, If searched then start from 0////
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
                $start=$this->uri->segment($i_uri_seg);
            }
            ///////////end generating search query///////
             // List of fields for sorting
			$arr_sort = array(0=>'n.i_expire_date',1=>'n.s_title');
			// echo $order_name.'---';
			//  echo decrypt($order_name);
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name;
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_report_multi($s_where,$s_order_name,$order_by,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Job ".$job_type;
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method() ;  
			$table_view["detail_view"] = FALSE;
            $j_col =0 ;           
            $table_view["headers"][$j_col]["val"]	="Title";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[1]));
			$table_view["headers"][++$j_col]["val"]	="Job Won";
			$table_view["headers"][$j_col]["width"]	="10%"; 
			$table_view["headers"][++$j_col]["val"]	="Category";
			$table_view["headers"][$j_col]["width"]	="10%"; 
			$table_view["headers"][++$j_col]["val"]	="Buyer";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Budget Price";
			$table_view["headers"][$j_col]["width"]	="9%"; 
            $table_view["headers"][++$j_col]["val"]	="Closed On"; 
			$table_view["headers"][$j_col]["width"]	="9%"; 
			$table_view["headers"][++$j_col]["val"]	="Status"; 
			$table_view["headers"][$j_col]["width"]	="9%"; 
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][++$j_col]["val"]	="Action"; 
			$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="5%"; 
        //    $table_view["headers"][++$j_col]["val"]	="Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_title"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_tradesman_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_category_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_username"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["d_budget_price"].' '. $this->config->item('default_currency');
				//$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_state"];
				//$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_city"];
				
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_expire_date"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_is_active"];
               $table_view["tablerows"][$i][$i_col++]	=' <a title="View" href="'.admin_base_url().'job_overview/index/'.encrypt($info[$i]["id"]).'" target="_blank">'.'<img src="images/admin/view.png" alt="View" />';

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            //$this->data["edit_action"]=$this->pathtoclass.'modify_information'.'/'.$type;///used for search form action
            $this->render();          
            unset($table_view,$info);
          
        }
        catch(Exception $err_obj)
        {
        	show_error($err_obj->getMessage());
        }          
    } 
	
	public function show_won_list($order_name='',$order_by='DESC',$start=NULL,$limit=NULL)
    {
        
        try
        {
            $this->data['heading']="Won Auctions";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			//echo encrypt(10); exit;
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            
            $s_cat=($this->input->post("h_search")?$this->input->post("s_cat"):$this->session->userdata("s_cat")); 
			
			$opt_buyer_id=($this->input->post("h_search")?$this->input->post("opt_buyer_id"):$this->session->userdata("opt_buyer_id")); 
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status IN(4,9,5,6,11)  AND n.i_is_deleted=0 ";
            if($s_search=="basic")
            {
/*                $s_where=" WHERE n.s_title LIKE '%".get_formatted_string($s_news_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_news_title",$s_news_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_news_title"]=$s_news_title;
                /////end Storing search values into session///
*/            }
            elseif($s_search=="advanced")
            {
                if($s_title)
				{
                	$arr_search[]="  n.s_title LIKE '%".get_formatted_string($s_title)."%' ";
				}
				
				if($opt_buyer_id!="")
				{
					$arr_search[]="  n.i_buyer_user_id=".decrypt($opt_buyer_id)." ";
				}
               
				$s_where .= (count($arr_search) !=0)?' AND '.implode('AND',$arr_search):'';	
                //echo $s_where; exit;
                /////Storing search values into session///
				 $this->session->set_userdata("s_title",$s_title);
				$this->session->set_userdata("s_cat",$s_cat);
				$this->session->set_userdata("opt_buyer_id",$opt_buyer_id);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
				$this->session->set_userdata("txt_to",$dt_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
				$this->data["s_title"]=$s_title;   
				$this->data["s_cat"]=$s_cat;     
				$this->data["opt_buyer_id"]=$opt_buyer_id;  
                $this->data["txt_created_on"]=$dt_created_on; 
				$this->data["txt_to"]=$dt_to;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_status IN(4,9,5,6,11) AND n.i_is_deleted=0 ";
                /////Releasing search values from session///
				$this->session->unset_userdata("s_title");
				$this->session->unset_userdata("s_cat");
				$this->session->unset_userdata("opt_buyer_id");
                $this->session->unset_userdata("txt_created_on");
				$this->session->unset_userdata("txt_to");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
				$this->data["s_title"]="";      
				$this->data["s_cat"]="";        
				$this->data["opt_buyer_id"]='';  
                $this->data["txt_created_on"]="";   
				$this->data["txt_to"]="";           
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
			$i_uri_seg = 6;
            ///Setting Limits, If searched then start from 0////
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
                $start=$this->uri->segment($i_uri_seg);
            }
            ///////////end generating search query///////
             
            // List of fields for sorting
			$arr_sort = array(0=>'n.i_assigned_date',1=>'n.s_title');   
			// echo $order_name.'---';
			//  echo decrypt($order_name);
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name;
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_in_progress_report($s_where,$s_order_name,$order_by,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Job Live";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_in_progress_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method();
			$table_view["detail_view"] = FALSE;
            $j_col=0;
		//	$table_view["headers"][$j_col]["width"]	="15%";            
            $table_view["headers"][$j_col]["val"]	="Title";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[1]));
			$table_view["headers"][++$j_col]["val"]	="Client";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Job Won BY";
			$table_view["headers"][$j_col]["width"]	="12%";
			$table_view["headers"][++$j_col]["val"]	="Category";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Quote Amount";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][$j_col]["align"]	="right";
			$table_view["headers"][++$j_col]["val"]	="Commission Amount";
			$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="14%"; 
		//	$table_view["headers"][++$j_col]["val"]	="City";
		//	$table_view["headers"][++$j_col]["val"]	="Postalcode";			
            $table_view["headers"][++$j_col]["val"]	="Assigned ON"; 
			$table_view["headers"][$j_col]["width"]	="9%"; 
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][++$j_col]["val"]	="Action"; 
			$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="5%"; 
          //  $table_view["headers"][++$j_col]["val"]	="Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_job_title"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_buyer_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_tradesman_name"];    
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_category_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["d_quote_amount"].' '. $this->config->item('default_currency');
				$d_comm_amt = ($info[$i]["d_pay_amount"]!=0)?$info[$i]["d_pay_amount"].' '. $this->config->item('default_currency'):'Waivered';
				$table_view["tablerows"][$i][$i_col++]	=$d_comm_amt;
				
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_assigned_date"];
           		$table_view["tablerows"][$i][$i_col++]	=' <a  href="'.admin_base_url().'job_overview/index/'.encrypt($info[$i]["id"]).'/'.encrypt(2).'" target="_blank">'.'<img src="images/admin/view.png" alt="View" title="View" />';

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            //echo $this->data["search_action"];
            $this->data['order_name'] = $order_name;
			$this->data['order_by'] = $order_by;
            $this->render();          
            unset($table_view,$info);
          
        }
        catch(Exception $err_obj)
        {
        	show_error($err_obj->getMessage());
        }          
	}
	
	/******* Show In Progress**********/
	public function show_in_progress($order_name='',$order_by='DESC',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="In Progress Auctions";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			//echo encrypt(10); exit;
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            
            $s_cat=($this->input->post("h_search")?$this->input->post("s_cat"):$this->session->userdata("s_cat")); 
			
			$opt_buyer_id=($this->input->post("h_search")?$this->input->post("opt_buyer_id"):$this->session->userdata("opt_buyer_id")); 
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status IN(4,11)  AND n.i_is_deleted=0 ";
            if($s_search=="basic")
            {
/*                $s_where=" WHERE n.s_title LIKE '%".get_formatted_string($s_news_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_news_title",$s_news_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_news_title"]=$s_news_title;
                /////end Storing search values into session///
*/            }
            elseif($s_search=="advanced")
            {
                if($s_title)
				{
                	$arr_search[]="  n.s_title LIKE '%".get_formatted_string($s_title)."%' ";
				}
				
				if($opt_buyer_id!="")
				{
					$arr_search[]="  n.i_buyer_user_id=".decrypt($opt_buyer_id)." ";
				}
               
				$s_where .= (count($arr_search) !=0)?' AND '.implode('AND',$arr_search):'';	
                //echo $s_where; exit;
                /////Storing search values into session///
				 $this->session->set_userdata("s_title",$s_title);
				$this->session->set_userdata("s_cat",$s_cat);
				$this->session->set_userdata("opt_buyer_id",$opt_buyer_id);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
				$this->session->set_userdata("txt_to",$dt_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
				$this->data["s_title"]=$s_title;   
				$this->data["s_cat"]=$s_cat;     
				$this->data["opt_buyer_id"]=$opt_buyer_id;  
                $this->data["txt_created_on"]=$dt_created_on; 
				$this->data["txt_to"]=$dt_to;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_status IN(4,11)  AND n.i_is_deleted=0 ";
                /////Releasing search values from session///
				$this->session->unset_userdata("s_title");
				$this->session->unset_userdata("s_cat");
				$this->session->unset_userdata("opt_buyer_id");
                $this->session->unset_userdata("txt_created_on");
				$this->session->unset_userdata("txt_to");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
				$this->data["s_title"]="";      
				$this->data["s_cat"]="";        
				$this->data["opt_buyer_id"]='';  
                $this->data["txt_created_on"]="";   
				$this->data["txt_to"]="";           
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
			$i_uri_seg = 6;
            ///Setting Limits, If searched then start from 0////
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
                $start=$this->uri->segment($i_uri_seg);
            }
            ///////////end generating search query///////
             
            // List of fields for sorting
			$arr_sort = array(0=>'n.i_assigned_date',1=>'n.s_title');   
			// echo $order_name.'---';
			//  echo decrypt($order_name);
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name;
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_in_progress_report($s_where,$s_order_name,$order_by,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Job Live";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_in_progress_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method();
			$table_view["detail_view"] = FALSE;
            $j_col=0;
		//	$table_view["headers"][$j_col]["width"]	="15%";            
            $table_view["headers"][$j_col]["val"]	="Title";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[1]));
			$table_view["headers"][++$j_col]["val"]	="Client";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Job Won BY";
			$table_view["headers"][$j_col]["width"]	="12%";
			$table_view["headers"][++$j_col]["val"]	="Category";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Quote Amount";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][$j_col]["align"]	="right";
			$table_view["headers"][++$j_col]["val"]	="Commission Amount";
			$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="14%"; 
		//	$table_view["headers"][++$j_col]["val"]	="City";
		//	$table_view["headers"][++$j_col]["val"]	="Postalcode";			
            $table_view["headers"][++$j_col]["val"]	="Assigned ON"; 
			$table_view["headers"][$j_col]["width"]	="9%"; 
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][++$j_col]["val"]	="Action"; 
			$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="5%"; 
          //  $table_view["headers"][++$j_col]["val"]	="Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_job_title"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_buyer_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_tradesman_name"];    
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_category_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["d_quote_amount"].' '. $this->config->item('default_currency');
				$d_comm_amt = !empty($info[$i]["d_pay_amount"])?$info[$i]["d_pay_amount"].' '. $this->config->item('default_currency'):'Waivered';
				$table_view["tablerows"][$i][$i_col++]	=$d_comm_amt;
				
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_assigned_date"];
           		$table_view["tablerows"][$i][$i_col++]	=' <a  href="'.admin_base_url().'job_overview/index/'.encrypt($info[$i]["id"]).'" target="_blank">'.'<img src="images/admin/view.png" alt="View" title="View" />';

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            //echo $this->data["search_action"];
            $this->data['order_name'] = $order_name;
			$this->data['order_by'] = $order_by;
            $this->render();          
            unset($table_view,$info);
          
        }
        catch(Exception $err_obj)
        {
        	show_error($err_obj->getMessage());
        }          
    } 
	
	/******* Show Complete**********/
	public function show_complete($order_name='',$order_by='DESC',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Completed Auctions";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			//echo encrypt(10); exit;
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            
            $s_cat=($this->input->post("h_search")?$this->input->post("s_cat"):$this->session->userdata("s_cat")); 
			
			$opt_buyer_id=($this->input->post("h_search")?$this->input->post("opt_buyer_id"):$this->session->userdata("opt_buyer_id")); 
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status=6  AND n.i_is_deleted=0 ";
            if($s_search=="basic")
            {
/*                $s_where=" WHERE n.s_title LIKE '%".get_formatted_string($s_news_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_news_title",$s_news_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_news_title"]=$s_news_title;
                /////end Storing search values into session///
*/            }
            elseif($s_search=="advanced")
            {
                if($s_title)
				{
                	$arr_search[]="  n.s_title LIKE '%".get_formatted_string($s_title)."%' ";
				}
				
				if($opt_buyer_id!="")
				{
					$arr_search[]="  n.i_buyer_user_id=".decrypt($opt_buyer_id)." ";
				}
               
				$s_where .= (count($arr_search) !=0)?' AND '.implode('AND',$arr_search):'';	
                //echo $s_where; exit;
                /////Storing search values into session///
				 $this->session->set_userdata("s_title",$s_title);
				$this->session->set_userdata("s_cat",$s_cat);
				$this->session->set_userdata("opt_buyer_id",$opt_buyer_id);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
				$this->session->set_userdata("txt_to",$dt_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
				$this->data["s_title"]=$s_title;   
				$this->data["s_cat"]=$s_cat;     
				$this->data["opt_buyer_id"]=$opt_buyer_id;  
                $this->data["txt_created_on"]=$dt_created_on; 
				$this->data["txt_to"]=$dt_to;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_status=6  AND n.i_is_deleted=0 ";
                /////Releasing search values from session///
				$this->session->unset_userdata("s_title");
				$this->session->unset_userdata("s_cat");
				$this->session->unset_userdata("opt_buyer_id");
                $this->session->unset_userdata("txt_created_on");
				$this->session->unset_userdata("txt_to");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
				$this->data["s_title"]="";      
				$this->data["s_cat"]="";        
				$this->data["opt_buyer_id"]='';  
                $this->data["txt_created_on"]="";   
				$this->data["txt_to"]="";           
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
			$i_uri_seg = 6;
            ///Setting Limits, If searched then start from 0////
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
                $start=$this->uri->segment($i_uri_seg);
            }
            ///////////end generating search query///////
             
            // List of fields for sorting
			$arr_sort = array(0=>'n.i_completed_date',1=>'n.s_title');   
			// echo $order_name.'---';
			//  echo decrypt($order_name);
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name;
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_in_progress_report($s_where,$s_order_name,$order_by,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Job Live";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_in_progress_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method();
			$table_view["detail_view"] = FALSE;
            $j_col=0;
		//	$table_view["headers"][$j_col]["width"]	="15%";            
            $table_view["headers"][$j_col]["val"]	="Title";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[1]));
			$table_view["headers"][++$j_col]["val"]	="Client";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Job Won BY";
			$table_view["headers"][$j_col]["width"]	="12%";
			$table_view["headers"][++$j_col]["val"]	="Category";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Quote Amount";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][$j_col]["align"]	="right";
			$table_view["headers"][++$j_col]["val"]	="Commission Amount";
			$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="14%"; 
		//	$table_view["headers"][++$j_col]["val"]	="City";
		//	$table_view["headers"][++$j_col]["val"]	="Postalcode";			
            $table_view["headers"][++$j_col]["val"]	="Completed ON"; 
			$table_view["headers"][$j_col]["width"]	="11%"; 
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][++$j_col]["val"]	="Action"; 
			$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="5%"; 
          //  $table_view["headers"][++$j_col]["val"]	="Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_job_title"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_buyer_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_tradesman_name"];    
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_category_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["d_quote_amount"].' '. $this->config->item('default_currency');
				$d_comm_amt = !empty($info[$i]["d_pay_amount"])?$info[$i]["d_pay_amount"].' '. $this->config->item('default_currency'):'Waivered';
				$table_view["tablerows"][$i][$i_col++]	=$d_comm_amt;
				
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_completed_date"];
           		$table_view["tablerows"][$i][$i_col++]	=' <a  href="'.admin_base_url().'job_overview/index/'.encrypt($info[$i]["id"]).'" target="_blank">'.'<img src="images/admin/view.png" alt="View" title="View" />';

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            //echo $this->data["search_action"];
            $this->data['order_name'] = $order_name;
			$this->data['order_by'] = $order_by;
            $this->render();          
            unset($table_view,$info);
          
        }
        catch(Exception $err_obj)
        {
        	show_error($err_obj->getMessage());
        }          
    } 
	
		/******* Show Complete**********/
	public function show_terminated($order_name='',$order_by='DESC',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Terminated Auctions";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			//echo encrypt(10); exit;
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            
             $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
			$dt_to=($this->input->post("h_search")?$this->input->post("txt_to"):$this->session->userdata("txt_to"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE n.i_status=9  AND n.i_is_deleted=0 ";
            if($s_search=="basic")
            {
/*                $s_where=" WHERE n.s_title LIKE '%".get_formatted_string($s_news_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_news_title",$s_news_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_news_title"]=$s_news_title;
                /////end Storing search values into session///
*/            }
            elseif($s_search=="advanced")
            {
                if($s_title)
				{
                	$arr_search[]="  n.s_title LIKE '%".get_formatted_string($s_title)."%' ";
				}
				
				if(trim($dt_created_on)!="" && trim($dt_to)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
					$dt_end = date("Y-m-d",strtotime(trim($dt_to." "))) ;
                    //$s_where.=" WHERE FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) >='".$dt_start."' ";
					$arr_search[]="  FROM_UNIXTIME( i_payment_date , '%Y-%m-%d' ) BETWEEN '".$dt_start."' AND '".$dt_end."'";
                    unset($dt_start);
                }
               
				$s_where .= (count($arr_search) !=0)?' AND '.implode('AND',$arr_search):'';	
                //echo $s_where; exit;
                /////Storing search values into session///
				 $this->session->set_userdata("s_title",$s_title);
				$this->session->set_userdata("txt_created_on",$dt_created_on);
				$this->session->set_userdata("txt_to",$dt_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
				$this->data["s_title"]=$s_title;   
				$this->data["s_cat"]=$s_cat;     
				$this->data["opt_buyer_id"]=$opt_buyer_id;  
                $this->data["txt_created_on"]=$dt_created_on; 
				$this->data["txt_to"]=$dt_to;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE n.i_status=9  AND n.i_is_deleted=0 ";
                /////Releasing search values from session///
				$this->session->unset_userdata("s_title");
				$this->session->unset_userdata("s_cat");
				$this->session->unset_userdata("opt_buyer_id");
                $this->session->unset_userdata("txt_created_on");
				$this->session->unset_userdata("txt_to");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
				$this->data["s_title"]="";      
				$this->data["s_cat"]="";        
				$this->data["opt_buyer_id"]='';  
                $this->data["txt_created_on"]="";   
				$this->data["txt_to"]="";           
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
			$i_uri_seg = 6;
            ///Setting Limits, If searched then start from 0////
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
                $start=$this->uri->segment($i_uri_seg);
            }
            ///////////end generating search query///////
             
            // List of fields for sorting
			$arr_sort = array(0=>'n.i_terminate_date',1=>'n.s_title');   
			// echo $order_name.'---';
			//  echo decrypt($order_name);
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name;
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_in_progress_report($s_where,$s_order_name,$order_by,intval($start),$limit);

            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Job Live";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_in_progress_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method();
			$table_view["detail_view"] = FALSE;
            $j_col=0;
		//	$table_view["headers"][$j_col]["width"]	="15%";            
            $table_view["headers"][$j_col]["val"]	="Title";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[1]));
			$table_view["headers"][++$j_col]["val"]	="Client";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Job Won BY";
			$table_view["headers"][$j_col]["width"]	="12%";
			$table_view["headers"][++$j_col]["val"]	="Category";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Quote Amount";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][$j_col]["align"]	="right";
			$table_view["headers"][++$j_col]["val"]	="Commission Amount";
			$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="14%"; 
		//	$table_view["headers"][++$j_col]["val"]	="City";
		//	$table_view["headers"][++$j_col]["val"]	="Postalcode";			
            $table_view["headers"][++$j_col]["val"]	="Terminated On"; 
			$table_view["headers"][$j_col]["width"]	="12%"; 
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][++$j_col]["val"]	="Action"; 
			$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="5%"; 
          //  $table_view["headers"][++$j_col]["val"]	="Status"; 
            //////end Table Headers, with width,alignment///////
		//	pr($info);
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_job_title"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_buyer_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_tradesman_name"];    
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_category_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["d_quote_amount"].' '. $this->config->item('default_currency');
				//echo $info[$i]["d_pay_amount"];
				$d_comm_amt = ($info[$i]["d_pay_amount"]!=0)?$info[$i]["d_pay_amount"]:$info[$i]["d_waiver_amt"];
				$table_view["tablerows"][$i][$i_col++]	= doubleval($d_comm_amt).' '. $this->config->item('default_currency');
				
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_terminate_date"];
           		//$table_view["tablerows"][$i][$i_col++]	=' <a  href="'.admin_base_url().'job_overview/index/'.encrypt($info[$i]["id"]).'" target="_blank">'.'<img src="images/admin/view.png" alt="View" title="View" />';
				$table_view["tablerows"][$i][$i_col++]	=' <a  href="'.admin_base_url().'job_overview/show_terminate_detail/'.encrypt($info[$i]["id"]).'" target="_blank">'.'<img src="images/admin/view.png" alt="View" title="View" />';

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            //echo $this->data["search_action"];
            $this->data['order_name'] = $order_name;
			$this->data['order_by'] = $order_by;
            $this->render();          
            unset($table_view,$info);
          
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
    public function show_qoute_list($order_name='',$order_by='DESC',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Per Job Bidding Status";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			//echo encrypt(10); exit;
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            
            $s_cat=($this->input->post("h_search")?$this->input->post("s_cat"):$this->session->userdata("s_cat")); 
			
			$opt_buyer_id=($this->input->post("h_search")?$this->input->post("opt_buyer_id"):$this->session->userdata("opt_buyer_id")); 
            ////////end Getting Posted or session values for search///
            
            
            $s_where=" WHERE  (n.i_status=1 OR n.i_status=8) AND n.i_is_deleted=0 ";
            if($s_search=="basic")
            {
/*                $s_where=" WHERE n.s_title LIKE '%".get_formatted_string($s_news_title)."%' ";
                /////Storing search values into session///
                $this->session->set_userdata("txt_news_title",$s_news_title);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["txt_news_title"]=$s_news_title;
                /////end Storing search values into session///
*/            }
            elseif($s_search=="advanced")
            {
                if($s_title)
				{
                	$arr_search[]="  n.s_title LIKE '%".get_formatted_string($s_title)."%' ";
				}
				if($s_cat!="")
				{
					$arr_search[]="  n.i_category_id=".decrypt($s_cat)." ";
				}
				
				if($opt_buyer_id!="")
				{
					$arr_search[]="  n.i_buyer_user_id=".decrypt($opt_buyer_id)." ";
				}
               
				$s_where .= (count($arr_search) !=0)?' AND '.implode('AND',$arr_search):'';	
                //echo $s_where; exit;
                /////Storing search values into session///
				 $this->session->set_userdata("s_title",$s_title);
				$this->session->set_userdata("s_cat",$s_cat);
				$this->session->set_userdata("opt_buyer_id",$opt_buyer_id);
                $this->session->set_userdata("txt_created_on",$dt_created_on);
				$this->session->set_userdata("txt_to",$dt_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
				$this->data["s_title"]=$s_title;   
				$this->data["s_cat"]=$s_cat;     
				$this->data["opt_buyer_id"]=$opt_buyer_id;  
                $this->data["txt_created_on"]=$dt_created_on; 
				$this->data["txt_to"]=$dt_to;             
                /////end Storing search values into session///                
                
            }
            else////List all records, **not done
            {
                $s_where=" WHERE (n.i_status=1 OR n.i_status=8)  AND n.i_is_deleted=0 ";
                /////Releasing search values from session///
				$this->session->unset_userdata("s_title");
				$this->session->unset_userdata("s_cat");
				$this->session->unset_userdata("opt_buyer_id");
                $this->session->unset_userdata("txt_created_on");
				$this->session->unset_userdata("txt_to");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
				$this->data["s_title"]="";      
				$this->data["s_cat"]="";        
				$this->data["opt_buyer_id"]='';  
                $this->data["txt_created_on"]="";   
				$this->data["txt_to"]="";           
                /////end Storing search values into session///                 
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
			$i_uri_seg = 6;
            ///Setting Limits, If searched then start from 0////
            if($this->input->post("h_search"))
            {
                $start=0;
            }
            else
            {
                $start=$this->uri->segment($i_uri_seg);
            }
            ///////////end generating search query///////
             
            // List of fields for sorting
			$arr_sort = array(0=>'n.i_created_date',1=>'n.s_title');   
			// echo $order_name.'---';
			//  echo decrypt($order_name);
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name;
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_quote_multi($s_where,$s_order_name,$order_by,intval($start),$limit);
			
            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Job Live";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_quote_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method();
			$table_view["detail_view"] = FALSE;
            $j_col=0;
		//	$table_view["headers"][$j_col]["width"]	="15%";            
            $table_view["headers"][$j_col]["val"]	="Title";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[1]));
			$table_view["headers"][++$j_col]["val"]	="Category";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Client";
			$table_view["headers"][$j_col]["width"]	="11%";
			$table_view["headers"][++$j_col]["val"]	="Budget Price";
			$table_view["headers"][$j_col]["width"]	="9%";
			$table_view["headers"][$j_col]["align"]	="right";
			$table_view["headers"][++$j_col]["val"]	="Total Quote";
			$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="8%"; 
		//	$table_view["headers"][++$j_col]["val"]	="City";
		//	$table_view["headers"][++$j_col]["val"]	="Postalcode";			
            $table_view["headers"][++$j_col]["val"]	="Posted On"; 
			$table_view["headers"][$j_col]["width"]	="9%"; 
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][++$j_col]["val"]	="Action"; 
			$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="5%"; 
          //  $table_view["headers"][++$j_col]["val"]	="Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_title"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_category_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_username"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["d_budget_price"].' '. $this->config->item('default_currency');
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_quotes"];
				//$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_city"];
			//	$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_postal_code"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_entry_date"];
           		$table_view["tablerows"][$i][$i_col++]	=' <a title="View" href="'.admin_base_url().'quote_overview/index/'.encrypt($info[$i]["id"]).'" target="_blank">'.'<img src="images/admin/view.png" alt="View" />';

            } 
            /////////end Table Data/////////
            unset($i,$i_col,$start,$limit); 
            
            $this->data["table_view"]=$this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action
            //echo $this->data["search_action"];
            $this->data['order_name'] = $order_name;
			$this->data['order_by'] = $order_by;
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
