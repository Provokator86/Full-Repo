<?php
/* * *******
 * Author: MM 
 * Date  : 9apr 2014
 * Modified By: 
 * Modified Date:
 * Purpose:
 * Controller For manage users
 * @package Cashback
 * @subpackage site_setting
 * @link InfController.php 
 * @link My_Controller.php
 * @link model/manage_cashback_model.php
 * @link views/admin/manage_cashback/
 */

class Manage_Cashback extends My_Controller {

    public $cls_msg; //////All defined error messages. 
    public $pathtoclass;
    public $uploaddir;
    public $allowedExt;
    //public $user_type = 2;
    public $couponObj;

    public function __construct() {
        try {
		
            parent::__construct();
            ////////Define Errors Here//////
            $this->data['title'] = "Manage Cashback"; ////Browser Title
            ////////Define Errors Here//////			
			$this->cls_msg = array();
          	$this->cls_msg["no_result"]="No information found about manage_user.";
          	$this->cls_msg["save_err"]="Information about user failed to save.";
         	$this->cls_msg["save_succ"]="Information about user saved successfully.";
          	$this->cls_msg["delete_err"]="Information about user failed to remove.";
          	$this->cls_msg["delete_succ"]="Information about user removed successfully.";

            $this->pathtoclass = admin_base_url() . $this->router->fetch_class() . "/";

            $this->data['action_allowed']["Status"] = TRUE; ///////////////////////////////////////////exp

            $this->load->model("coupon_model");
            $this->load->model("store_model");
            $this->load->model("brand_model");
            $this->load->model("category_model");
            $this->load->model("common_model", "mod_common");
            $this->load->model("cashback_model");
            $this->load->model("user_model");
            $this->load->model("user_deals_model");
            // $this->data['category']= $this->store_model->get_category();
            //$this->data['brand']	= $this->store_model->get_brand();
            // $this->data['offer']	= $this->store_model->get_offer();
            // $this->data['store']	= $this->store_model->get_store();
            //$this->data['location']	= $this->get_all_location();

            //////// end loading default model here //////////////		 

        } catch (Exception $err_obj) {

            show_error($err_obj->getMessage());

        }

    }



    public function index() {
        try {

            $this->data['title'] = "Manage Deal"; ////Browser Title
            $this->data['heading'] = "Manage Deal";
            redirect(base_url() . 'admin_panel/manage_cashback/show_user_list');
        } catch (Exception $err_obj) {

            show_error($err_obj->getMessage());

        }

    }



    public function show_user_list($order_name = '', $order_by = 'desc', $start = NULL, $limit = NULL) 
	{

        try {

            $this->data['heading'] = "Manage Cashback Users"; ////Package Name[@package] Panel Heading
            ///////////generating search query///////
            ////////Getting Posted or session values for search///
            $s_search = (isset($_POST["h_search"]) ? $this->input->post("h_search") : $this->session->userdata("h_search"));
            $s_uid = ($this->input->post("h_search") ? $this->input->post("s_uid") : $this->session->userdata("s_uid"));
            $i_active = ($this->input->post("h_search") ? $this->input->post("i_active") : $this->session->userdata("i_active"));

            ////////end Getting Posted or session values for search///
            //$s_where=" WHERE dt_exp_date>=now() ";/////////////////////////1====
            $s_where = "s_name !='0' ";

            if ($s_search == "basic") {

                if (trim($s_uid) != "") {
                    $s_where.=" AND (s_name LIKE '%" . my_receive_like($s_uid) . "%' OR s_uid LIKE '%" . my_receive_like($s_uid) . "%' OR s_email LIKE '%" . my_receive_like($s_uid) . "%'   )";

                }
                if (trim($i_active) != "") {
                    $s_where.=" And i_active=" . $i_active . " ";
                }

                /////Storing search values into session///

                //$this->session->set_userdata("s_uid",$s_uid);
                //$this->session->set_userdata("i_active",$i_active);
                //$this->session->set_userdata("h_search",$s_search);
                $this->data["h_search"] = $s_search;
                $this->data["s_uid"] = $s_uid;
                $this->data["i_active"] = $i_active;
                /////end Storing search values into session///

            } else {////List all records, **not done

                //$s_where=" WHERE n.id!=1 ";
                /////Releasing search values from session///
                // $this->session->unset_userdata("s_uid");
                //$this->session->unset_userdata("i_active");
                //$this->session->unset_userdata("h_search");
                $this->data["h_search"] = $s_search;
                $this->data["s_uid"] = "";
                $this->data["i_active"] = "";
                $this->data["s_uid"] = "";
                $this->data["s_name"] = "";
                /////end Storing search values into session///
            }
            unset($s_search, $s_user_type, $dt_created_on);
            ///Setting Limits, If searched then start from 0////
            $i_uri_seg = 6;

            if ($this->input->post("h_search")) {
                $start = 0;
            } else {
                $start = $this->uri->segment($i_uri_seg);
            }
            ///////////end generating search query///////
            $arr_sort = array(0 => 'i_id', 1 => 's_name', 's_email', 's_uid', 't_timestamp');
            $s_order_name = !empty($order_name) ? in_array(decrypt($order_name), $arr_sort) ? decrypt($order_name) : $arr_sort[0]  : $arr_sort[0];
            $limit = $this->i_admin_page_limit;
            $info = $this->user_model->get_list($s_where, NULL, intval($limit), intval($start), $s_order_name, $order_by); 
            //print_r ($info);
			//echo $this->db->last_query();
            /////////Creating List view for displaying/////////

            $table_view = array();
            $order_name = empty($order_name) ? encrypt($arr_sort[0]) : $order_name;
            //////Table Headers, with width,alignment///////
            $table_view["caption"] = "User";
            $table_view["total_rows"] = count($info);
            $table_view["total_db_records"] = $this->user_model->count_total($s_where);
            $table_view["order_name"] = $order_name;
            $table_view["order_by"] = $order_by;
            $table_view["src_action"] = $this->pathtoclass . $this->router->fetch_method();
            // $table_view["detail_view"]		=   FALSE;         

            $table_view["headers"][0]["width"] = "20%";
            $table_view["headers"][0]["align"] = "left";
            //$table_view["headers"][0]["val"]	="Serial Number";
            //$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
            $table_view["headers"][0]["val"] = "User Name";
            $table_view["headers"][1]["val"] = "Email";
            $table_view["headers"][2]["val"] = "Added On";
            $table_view["headers"][3]["val"] = "Uid";
            $table_view["headers"][4]["val"] = "Status";
            //////end Table Headers, with width,alignment///////
            /////////Table Data/////////
            for ($i = 0; $i < $table_view["total_rows"]; $i++) {
                $i_col = 0;
				$table_view["tablerows"][$i][$i_col++] = encrypt($info[$i]["i_id"]); ////Index 0 must be the encrypted PK 
                //$table_view["tablerows"][$i][$i_col++]	= $info[$i]["i_id"];
                $table_view["tablerows"][$i][$i_col++] = $info[$i]["s_name"];
                $table_view["tablerows"][$i][$i_col++] = $info[$i]["s_email"];
                $table_view["tablerows"][$i][$i_col++] = $info[$i]["t_timestamp"];
                $table_view["tablerows"][$i][$i_col++] = $info[$i]["s_uid"];

                if ($info[$i]["i_active"] == 1) {
                    $action = '<a  href="javascript:void(0);" id="approve_img_id_' . encrypt($info[$i]["i_id"]) . '_inactive">
                        <img width="12" height="12" title="Make Inactive" alt="Inactive" src="images/admin/tick.png"></a>';

                } else {
                    $action = '<a  href="javascript:void(0);" id="approve_img_id_' . encrypt($info[$i]["i_id"]) . '_active">
                        <img width="12" height="12" title="Make Active" alt="Active" src="images/admin/reject.png"></a>';
                }
				
				 $action .= '&nbsp;<a  href="javascript:void(0);" onclick="view_user_detail('.$info[$i]["i_id"].')"><img width="12" height="12" title="View Detail" alt="View Detail" src="images/admin/view.png"></a>';
                $table_view["tablerows"][$i][$i_col++] = $action;

            }

            /////////end Table Data/////////

            unset($i, $i_col, $start, $limit, $action);
            //$this->data["table_view"]=$this->admin_showin_table($table_view);

            $this->data["table_view"] = $this->admin_showin_order_table($table_view);
            /////////Creating List view for displaying/////////
            $this->data["search_action"] = $this->pathtoclass . $this->router->fetch_method(); ///used for search form action
            //echo $this->data["search_action"];
            $this->render();
            unset($table_view, $info);

        } catch (Exception $err_obj) {

            show_error($err_obj->getMessage());

        }

    }



    function ajax_change_status() {

        $dataToUpdate['i_active'] = intval(trim($this->input->post('i_status')));
		$userId = decrypt(trim($this->input->post('h_id')));
		$cond = array('i_id'=>$userId);
        $resp = $this->user_model->update_data($dataToUpdate, $cond);

        echo 'ok';
        //$this->user_model->update_data($dataToUpdate);
    }



    public function show_applied_cashback_list($order_name = '', $order_by = 'desc', $start = NULL, $limit = NULL) {

        try {



            $this->data['heading'] = "Manage Applied Cashback"; ////Package Name[@package] Panel Heading

            ///////////generating search query///////

            ////////Getting Posted or session values for search///

            $s_search = (isset($_POST["h_search"]) ? $this->input->post("h_search") : $this->session->userdata("h_search"));



            $s_uid = ($this->input->post("h_search") ? $this->input->post("s_uid") : $this->session->userdata("s_uid"));

            $i_active = ($this->input->post("h_search") ? $this->input->post("i_active") : $this->session->userdata("i_active"));

            ////////end Getting Posted or session values for search///

            //$s_where=" WHERE dt_exp_date>=now() ";/////////////////////////1====

            $s_where = "i_is_cashback =1 ";

            //$s_where = NULL;



            if ($s_search == "basic") {

                if (trim($s_uid) != "") {

                    $s_where.=" AND (s_name LIKE '%" . my_receive_like($s_uid) . "%' OR s_uid LIKE '%" . my_receive_like($s_uid) . "%' OR s_email LIKE '%" . my_receive_like($s_uid) . "%'   )";

                }



                if (trim($i_active) != "") {

                    $s_where.=" And i_active=" . $i_active . " ";

                }



                /////Storing search values into session///

                //$this->session->set_userdata("s_uid",$s_uid);

                //$this->session->set_userdata("i_active",$i_active);

                //$this->session->set_userdata("h_search",$s_search);

                $this->data["h_search"] = $s_search;

                $this->data["s_uid"] = $s_uid;

                $this->data["i_active"] = $i_active;

                /////end Storing search values into session///

            } else {////List all records, **not done

                //$s_where=" WHERE n.id!=1 ";

                /////Releasing search values from session///

                // $this->session->unset_userdata("s_uid");

                //$this->session->unset_userdata("i_active");

                //$this->session->unset_userdata("h_search");

                $this->data["h_search"] = $s_search;

                $this->data["s_uid"] = "";

                $this->data["i_active"] = "";

                $this->data["s_uid"] = "";

                $this->data["s_name"] = "";

                /////end Storing search values into session///
            }

            unset($s_search, $s_user_type, $dt_created_on);

            ///Setting Limits, If searched then start from 0////

            $i_uri_seg = 6;
			
            if ($this->input->post("h_search")) {

                $start = 0;

            } else {

                $start = $this->uri->segment($i_uri_seg);

            }

            ///////////end generating search query///////

            $arr_sort = array(0 => 'user_deals_ID');

            $s_order_name = !empty($order_name) ? in_array(decrypt($order_name), $arr_sort) ? decrypt($order_name) : $arr_sort[0]  : $arr_sort[0];

            $limit = $this->i_admin_page_limit;

            $info = $this->user_deals_model->get_joined_list($s_where, NULL, intval($limit), intval($start), $s_order_name, $order_by); ///////////test

			///pr($info[0]['d_cashback_amount']);

            //$name=

            //print_r ($info);

            /////////Creating List view for displaying/////////

            $table_view = array();

            $order_name = empty($order_name) ? encrypt($arr_sort[0]) : $order_name;

            //////Table Headers, with width,alignment///////

            $table_view["caption"] = "User";

            $table_view["total_rows"] = count($info);

            $table_view["total_db_records"] = $this->user_deals_model->count_total_joined_list($s_where);

            $table_view["order_name"] = $order_name;

            $table_view["order_by"] = $order_by;

            $table_view["src_action"] = $this->pathtoclass . $this->router->fetch_method();

            // $table_view["detail_view"]		=   FALSE;          

            $table_view["headers"][0]["width"] = "20%";

            $table_view["headers"][0]["align"] = "left";

            //$table_view["headers"][0]["val"]	="Serial Number";

            //$table_view["headers"][0]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));

            $table_view["headers"][0]["val"] = "User Name";

            $table_view["headers"][1]["val"] = "Cashback Name";

            $table_view["headers"][2]["val"] = "Email";

            $table_view["headers"][3]["val"] = "Tracked On";

            $table_view["headers"][4]["val"] = "Uid";

            $table_view["headers"][5]["val"] = "Payback Status";

            //////end Table Headers, with width,alignment///////

            /////////Table Data/////////

            for ($i = 0; $i < $table_view["total_rows"]; $i++) {

                $i_col = 0;

                $_TMP_DATA = json_decode($info[$i]['txt_extra'], TRUE);



                $table_view["tablerows"][$i][$i_col++] = encrypt($info[$i]["i_id"]); ////Index 0 must be the encrypted PK 

                //$table_view["tablerows"][$i][$i_col++]	= $info[$i]["i_id"];

                $table_view["tablerows"][$i][$i_col++] = $info[$i]["s_name"];

                $table_view["tablerows"][$i][$i_col++] = $info[$i]["s_title"];

                $table_view["tablerows"][$i][$i_col++] = $info[$i]["s_email"];

                $table_view["tablerows"][$i][$i_col++] = date('Y-m-d H:m:s', $_TMP_DATA['SERVER']['REQUEST_TIME']);

                $table_view["tablerows"][$i][$i_col++] = $info[$i]["s_uid"];





                $table_view["tablerows"][$i][$i_col++] = '<input name="' . $info[$i]["user_deals_ID"] . '" onclick="saveAmount(this)" readonly="readonly" type="text" value="' . $info[$i]['d_cashback_amount'] . '">';

            }

            /////////end Table Data/////////

            unset($i, $i_col, $start, $limit, $action);

            //$this->data["table_view"]=$this->admin_showin_table($table_view);

            $this->data["table_view"] = $this->admin_showin_order_table($table_view);

            /////////Creating List view for displaying/////////

            $this->data["search_action"] = $this->pathtoclass . $this->router->fetch_method(); ///used for search form action

            //echo $this->data["search_action"];

            $this->render();

            unset($table_view, $info);

        } catch (Exception $err_obj) {

            show_error($err_obj->getMessage());

        }
    }

    public function apply_cashback() {

        $user_deals_ID = intval($this->input->post('user_deals_ID'));

        $d_cashback_amount = floatval($this->input->post('d_cashback_amount'));

        if ($user_deals_ID) {

            $this->user_deals_model->update_data(array(

                'user_deals_ID' => $user_deals_ID,

                'd_cashback_amount' => $d_cashback_amount

                    ), $condition = array('user_deals_ID' => $user_deals_ID));

            echo json_encode(array('status' => 'success', 'message' => 'Updated'));
        }
    }
	
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
							$i_ret_=$this->user_model->delete_info(-1);
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

								$i_ret_=$this->user_model->delete_info(decrypt($id[$tot]));

							$tot--;

							}

							}

							elseif($id>0)///Deleting single Records
							{
								$i_ret_=$this->user_model->delete_info(decrypt($id));
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

            redirect($this->pathtoclass);
        }

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }
	}  
	
	 /***
    * Shows details of a single record.
    * @param int $i_id, Primary key
    */
    public function user_detail($i_id=0)
    {
        try
        {
            if(trim($i_id)!="")
            {
				$cond = array('cd_user.i_id'=>intval($i_id));
                $info=$this->user_model->get_joined_user_detail($cond);
				//pr($info,1);
                if(!empty($info))
                {
                    $temp=array();
                    $temp = $info[0];
					$this->data["info"]		= $temp;
                    unset($temp);
                }
                unset($info);
            }

            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            $this->render("manage_cashback/user_detail",TRUE);
            unset($i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }        

    }
	
    public function __destruct() 
	{
	}
}