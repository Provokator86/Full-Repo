<?php
/*********
* Author: Arka 
* Date  : 
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
* @link model/manage_cashback_model.php
* @link views/admin/manage_cashback/
*/

class Manage_Cashback extends My_Controller  
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public $uploaddir;
    public $allowedExt;	
    //public $user_type = 2;
    public $couponObj;
    public function __construct()
    {
        try
        {
            parent::__construct();
            ////////Define Errors Here//////
            $this->data['title']="Manage Cashback";////Browser Title
            ////////Define Errors Here//////
            $this->pathtoclass 						= admin_base_url().$this->router->fetch_class()."/";
            
            $this->data['action_allowed']["Status"]	= TRUE;///////////////////////////////////////////exp
            
            $this->load->model("coupon_model");
            $this->load->model("store_model");
            $this->load->model("brand_model");
            $this->load->model("category_model");
            $this->load->model("common_model","mod_common");
            $this->load->model("cashback_model");
            $this->load->model("user_deals_model");
            $this->load->model("user_model");
           // $this->data['category']= $this->store_model->get_category();
//
            //$this->data['brand']	= $this->store_model->get_brand();
           // $this->data['offer']	= $this->store_model->get_offer();
           // $this->data['store']	= $this->store_model->get_store();
            //$this->data['location']	= $this->get_all_location();;
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
			
            $this->data['title']		=	"Manage Deal";////Browser Title
            $this->data['heading']		=	"Manage Deal";
            redirect(base_url().'admin_panel/manage_cashback/show_user_list');
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
    
    
    
	public function show_user_list($order_name='',$order_by='desc',$start=NULL,$limit=NULL)
	{
            try
            {

                $this->data['heading']="Manage Cashback Users";////Package Name[@package] Panel Heading
                ///////////generating search query///////
                ////////Getting Posted or session values for search///
                $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));

                $s_uid=($this->input->post("h_search")?$this->input->post("s_uid"):$this->session->userdata("s_uid")); 
                $i_active=($this->input->post("h_search")?$this->input->post("i_active"):$this->session->userdata("i_active")); 
                ////////end Getting Posted or session values for search///


                 //$s_where=" WHERE dt_exp_date>=now() ";/////////////////////////1====
                $s_where= "s_name !='0' ";

                if($s_search=="basic")
                {
                    if(trim($s_uid)!=""){
                         $s_where.=" AND (s_name LIKE '%".my_receive_like($s_uid)."%' OR s_uid LIKE '%".my_receive_like($s_uid)."%' OR s_email LIKE '%".my_receive_like($s_uid)."%'   )";
                    }
                    
                    if(trim($i_active)!="")
                    {
                        $s_where.=" And i_active=".$i_active." ";

                    }

	
                    /////Storing search values into session///
                    //$this->session->set_userdata("s_uid",$s_uid);
                    //$this->session->set_userdata("i_active",$i_active);
                    //$this->session->set_userdata("h_search",$s_search);
                    $this->data["h_search"]=$s_search;
                    $this->data["s_uid"]=$s_uid;
                    $this->data["i_active"]=$i_active;
                    /////end Storing search values into session///
                }

                else////List all records, **not done
                {
                   //$s_where=" WHERE n.id!=1 ";
                    /////Releasing search values from session///
                   // $this->session->unset_userdata("s_uid");
                    //$this->session->unset_userdata("i_active");
                    //$this->session->unset_userdata("h_search");
                    $this->data["h_search"]=$s_search;
                    $this->data["s_uid"]=""; 
                    $this->data["i_active"]="";          
                    $this->data["s_uid"]=""; 
                    $this->data["s_name"]="";          
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
                $arr_sort = array(0=>'i_id',1=>'s_name','s_email','s_uid','t_timestamp');
                $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
                $limit	= $this->i_admin_page_limit;
                $info	= $this->user_model->get_list($s_where,NULL,intval($limit),intval($start),$s_order_name,$order_by);///////////test
                
                //$name=
                //print_r ($info);
                
                /////////Creating List view for displaying/////////
                $table_view=array(); 
                $order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 

                //////Table Headers, with width,alignment///////
                $table_view["caption"]     		=	"User";
                $table_view["total_rows"]		=	count($info);
                $table_view["total_db_records"]         =	$this->user_model->count_total($s_where);
                $table_view["order_name"]		=	$order_name;
                $table_view["order_by"]  		=	$order_by;
                $table_view["src_action"]		= 	$this->pathtoclass.$this->router->fetch_method(); 
               // $table_view["detail_view"]		=   FALSE;          
                $table_view["headers"][0]["width"]	="20%";
                $table_view["headers"][0]["align"]	="left";
                //$table_view["headers"][0]["val"]	="Serial Number";
                //$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
                $table_view["headers"][0]["val"]	="User Name";
                $table_view["headers"][1]["val"]	="Email";
                $table_view["headers"][2]["val"]	="Added On";
                $table_view["headers"][3]["val"]	="Uid";
                $table_view["headers"][4]["val"]	="Status";
              

                //////end Table Headers, with width,alignment///////

                /////////Table Data/////////
                for($i=0; $i<$table_view["total_rows"]; $i++)
                {	
                    $i_col=0;
                    
                    $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);////Index 0 must be the encrypted PK 
                    //$table_view["tablerows"][$i][$i_col++]	= $info[$i]["i_id"];
                    $table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_name"];
                    $table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_email"];
                    $table_view["tablerows"][$i][$i_col++]	= $info[$i]["t_timestamp"];
                    $table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_uid"];


                    if($info[$i]["i_active"] == 1)
                    {
                        $action ='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_inactive">
                        <img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/tick.png"></a>';
                    }
                    else
                    { 
                        $action ='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_active">
                        <img width="12" height="12" title="Active" alt="Active" src="images/admin/reject.png"></a>';
                    }
                        $table_view["tablerows"][$i][$i_col++]	= $action;
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
        
        public function show_applied_cashback_list($order_name='',$order_by='desc',$start=NULL,$limit=NULL)
	{
            try
            {

                $this->data['heading']="Manage Applied Cashback";////Package Name[@package] Panel Heading
                ///////////generating search query///////
                ////////Getting Posted or session values for search///
                $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));

                $s_uid=($this->input->post("h_search")?$this->input->post("s_uid"):$this->session->userdata("s_uid")); 
                $i_active=($this->input->post("h_search")?$this->input->post("i_active"):$this->session->userdata("i_active")); 
                ////////end Getting Posted or session values for search///


                 //$s_where=" WHERE dt_exp_date>=now() ";/////////////////////////1====
                $s_where= "s_name !='0' ";

                if($s_search=="basic")
                {
                    if(trim($s_uid)!=""){
                         $s_where.=" AND (s_name LIKE '%".my_receive_like($s_uid)."%' OR s_uid LIKE '%".my_receive_like($s_uid)."%' OR s_email LIKE '%".my_receive_like($s_uid)."%'   )";
                    }
                    
                    if(trim($i_active)!="")
                    {
                        $s_where.=" And i_active=".$i_active." ";

                    }

	
                    /////Storing search values into session///
                    //$this->session->set_userdata("s_uid",$s_uid);
                    //$this->session->set_userdata("i_active",$i_active);
                    //$this->session->set_userdata("h_search",$s_search);
                    $this->data["h_search"]=$s_search;
                    $this->data["s_uid"]=$s_uid;
                    $this->data["i_active"]=$i_active;
                    /////end Storing search values into session///
                }

                else////List all records, **not done
                {
                   //$s_where=" WHERE n.id!=1 ";
                    /////Releasing search values from session///
                   // $this->session->unset_userdata("s_uid");
                    //$this->session->unset_userdata("i_active");
                    //$this->session->unset_userdata("h_search");
                    $this->data["h_search"]=$s_search;
                    $this->data["s_uid"]=""; 
                    $this->data["i_active"]="";          
                    $this->data["s_uid"]=""; 
                    $this->data["s_name"]="";          
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
                $arr_sort = array(0=>'i_id',1=>'s_name','s_email','s_uid','t_timestamp');
                $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
                $limit	= $this->i_admin_page_limit;
                $info	= $this->user_deals_model->get_list($s_where,NULL,intval($limit),intval($start),$s_order_name,$order_by);///////////test
                pr($info);
                //$name=
                //print_r ($info);
                
                /////////Creating List view for displaying/////////
                $table_view=array(); 
                $order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 

                //////Table Headers, with width,alignment///////
                $table_view["caption"]     		=	"User";
                $table_view["total_rows"]		=	count($info);
                $table_view["total_db_records"]         =	$this->user_model->count_total($s_where);
                $table_view["order_name"]		=	$order_name;
                $table_view["order_by"]  		=	$order_by;
                $table_view["src_action"]		= 	$this->pathtoclass.$this->router->fetch_method(); 
               // $table_view["detail_view"]		=   FALSE;          
                $table_view["headers"][0]["width"]	="20%";
                $table_view["headers"][0]["align"]	="left";
                //$table_view["headers"][0]["val"]	="Serial Number";
                //$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
                $table_view["headers"][0]["val"]	="User Name";
                $table_view["headers"][1]["val"]	="Email";
                $table_view["headers"][2]["val"]	="Added On";
                $table_view["headers"][3]["val"]	="Uid";
                $table_view["headers"][4]["val"]	="Status";
              

                //////end Table Headers, with width,alignment///////

                /////////Table Data/////////
                for($i=0; $i<$table_view["total_rows"]; $i++)
                {	
                    $i_col=0;
                    
                    $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);////Index 0 must be the encrypted PK 
                    //$table_view["tablerows"][$i][$i_col++]	= $info[$i]["i_id"];
                    $table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_name"];
                    $table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_email"];
                    $table_view["tablerows"][$i][$i_col++]	= $info[$i]["t_timestamp"];
                    $table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_uid"];


                    if($info[$i]["i_active"] == 1)
                    {
                        $action ='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_inactive">
                        <img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/tick.png"></a>';
                    }
                    else
                    { 
                        $action ='<a  href="javascript:void(0);" id="approve_img_id_'.encrypt($info[$i]["i_id"]).'_active">
                        <img width="12" height="12" title="Active" alt="Active" src="images/admin/reject.png"></a>';
                    }
                        $table_view["tablerows"][$i][$i_col++]	= $action;
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
       
        
	public function ajax_change_status() {
            
            $dataToUpdate['i_active'] = intval(trim($this->input->post('i_status'))) ;
            $resp = $this->user_model->update_data($dataToUpdate,array('i_id'=>intval(decrypt(trim($this->input->post('h_id'))))));
              echo 'ok';
            //$this->user_model->update_data($dataToUpdate);
        }
        
        

    public function __destruct()
    {}
}