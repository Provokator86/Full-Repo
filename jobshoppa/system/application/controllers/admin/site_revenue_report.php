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


class Site_revenue_report extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="Per month revenue report";////Browser Title

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
          $this->load->model("site_revenue_model","mod_rect");
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
            $this->data['heading']="Per month revenue report";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));
			$dt_to=($this->input->post("h_search")?$this->input->post("txt_to"):$this->session->userdata("txt_to"));
            ////////end Getting Posted or session values for search///
            
            
            $s_where="";
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
               
                if(trim($dt_created_on)!="" && trim($dt_to)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
					$dt_end = date("Y-m-d",strtotime(trim($dt_to." "))) ;
                    //$s_where.=" WHERE FROM_UNIXTIME( n.i_created_date , '%Y-%m-%d' ) >='".$dt_start."' ";
					$arr_search[]="  FROM_UNIXTIME( payment_date , '%Y-%m-%d' ) BETWEEN '".$dt_start."' AND '".$dt_end."'";
                    unset($dt_start);
                }
				$s_where .= (count($arr_search) !=0)?' WHERE '.implode('AND',$arr_search):'';	
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
                /*$s_where=" WHERE FROM_UNIXTIME( i_payment_date, '%Y-%m-%d' )
BETWEEN DATE( NOW( ) ) - INTERVAL( DAY( NOW( ) ) -1 )
DAY - INTERVAL 11
MONTH
AND NOW( )";*/
				$s_where=" WHERE FROM_UNIXTIME( payment_date, '%Y-%m-%d' )
BETWEEN DATE( NOW( ) ) - INTERVAL( DAY( NOW( ) ) -1 )
DAY - INTERVAL 11
MONTH
AND NOW( )";
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
            ///////////end generating search query///////fetch_multi_total_site_revenue
            
            
            $limit	= $this->i_admin_page_limit=10000;
            //$info	= $this->mod_rect->fetch_multi($s_where,intval($start),$limit);
			$info	= $this->mod_rect->fetch_multi_total_site_revenue($s_where,intval($start),$limit);
			//pr($info,1);

            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Site Revenue";
            $table_view["total_rows"]=count($info);
			//$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);
			$table_view["total_db_records"]=count($info);
			$table_view["detail_view"] = FALSE;
            $j_col = 0;            
            
            $table_view["headers"][$j_col]["val"]	="Payments made by Professional";
			$table_view["headers"][$j_col]["width"]	="23%";
			$table_view["headers"][++$j_col]["val"]	="Payment For";
			$table_view["headers"][++$j_col]["val"]	="Payment Date";
			//$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="15%";
            $table_view["headers"][++$j_col]["val"]	="Payment Amount"; 
			$table_view["headers"][$j_col]["width"]	="15%";
            $table_view["headers"][$j_col]["align"]	="right";
           // $table_view["headers"][3]["val"]	="Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
			$d_total_pay = 0.00;
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= 0;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_tradesman_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_job_title"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_payment_date"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_pay_amount"];
              //  $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_is_active"];
			  $d_total_pay = doubleval($d_total_pay + $info[$i]["d_pay_amount"]);

            } 
				 $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= '';////Index 0 must be the encrypted PK 
				$table_view["tablerows"][$i][$i_col++]	='';
				
				$table_view["tablerows"][$i][$i_col++]	='';
				$table_view["tablerows"][$i][$i_col++]	= '';
				
				$table_view["tablerows"][$i][$i_col++]	='Total: '.$d_total_pay.' '.$this->config->item("default_currency");
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
            
            $this->render("job_posted_report/show_detail",TRUE);
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
	public function __destruct()
    {}
	
	
}
?>