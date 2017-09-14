<?php

/*********
* Author: Mrinmoy
* Date  : 05 Mar 2014
* Modified By: 
* Modified Date:
* Purpose:
* Controller For manage affiliates
* @package Master settting
* @subpackage Manage Affiliates
* @link InfController.php 
* @link My_Controller.php
* @link model/affiliates_model.php
* @link views/admin/manage_affiliates/
*/

class Manage_affiliates extends My_Controller implements InfController
{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
	public $uploaddir;
	public $allowedExt;	
	

    public function __construct()
    {
        try
        {

          parent::__construct();
          ////////Define Errors Here//////
          $this->data['title']="Manage Affiliates";////Browser Title
          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]				= "No information found about affiliates.";
          $this->cls_msg["save_err"]				= "Affiliates failed to save.";
          $this->cls_msg["save_succ"]				= "Saved successfully.";
          $this->cls_msg["delete_err"]				= "Affiliates failed to remove.";
          $this->cls_msg["delete_succ"]				= "Affiliates removed successfully.";
		  $this->cls_msg["img_upload_err"]			= "Image cannot be uploded.";
		  $this->cls_msg["database_err"]			= "Failed to insert in the database.Try Again";

		  $this->cls_msg["img_upload_err"]			= "Image cannot be uploded.";

          ////////end Define Errors Here//////

			$this->pathtoclass 					= admin_base_url().$this->router->fetch_class()."/";
		 	//$this->data['action_allowed']["Status"]	= TRUE;

          	$this->load->model("affiliates_model","mod_aff");
			$this->load->model("common_model","mod_com");
		  	//////// end loading default model here //////////////		
			
			$this->allowedExt	= 'jpg|jpeg|png|gif';
			$this->uploaddir	= $this->config->item('AFFILIATES_LOGO_IMAGE_UPLOAD_PATH');	
			$this->thumbdir		= $this->config->item('AFFILIATES_LOGO_THUMB_IMAGE_UPLOAD_PATH');
			$this->thumb_ht		= 58;
			$this->thumb_wd		= 97; 

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
            $this->data['title']		=	"Manage Affiliates";////Browser Title
            $this->data['heading']		=	"Manage Affiliates";	
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
          	$this->data['title']				= "Manage Affiliates";////Browser Title
            $this->data['heading']				= "Add Affiliates ";
            $this->data['pathtoclass']			= $this->pathtoclass;
            $this->data['mode']					= "add";

			if($_POST)
        	{
				
				$this->form_validation->set_rules('s_name','Affiliates name','required');
				//$this->form_validation->set_rules('s_link','Affiliates link','required');
				//$this->form_validation->set_rules('s_partner_id','Partner ID','required');
				
				if(isset($_FILES['s_logo']) && !empty($_FILES['s_logo']['name']))
				{
					$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'s_logo','','',$this->allowedExt);  
					$arr_upload_res = explode('|',$s_uploaded_filename);
				}

				if($this->form_validation->run() == FALSE || ($arr_upload_res[0]==='err'))		
				{		
					$this->data['posted'] = $_POST;	
					if($arr_upload_res[0]==='err')
					{
						set_error_msg($arr_upload_res[2]);
					}
				}	
				else
				{	
				
					if($arr_upload_res[0]==='ok')
					{
						get_image_thumb($this->uploaddir.$arr_upload_res[2], $this->thumbdir, 'thumb_'.$arr_upload_res[2],$this->thumb_ht,$this->thumb_wd);  // get thumb image							

					}
				
					$info	= array(
										"s_name"=> trim($this->input->post("s_name")),				
										"i_status"=> $this->input->post("i_status"),				
										"s_link"=> $this->input->post("s_link"),
										"s_partner_id"=> trim($this->input->post("s_partner_id")),	
										"s_logo" => $arr_upload_res[2],
										"dt_create"=> now()
				
									);
					
					$inserted_user_id	= $this->mod_com->common_add_info($this->db->AFFILIATES,$info);	
					if($inserted_user_id)////saved successfully
					{				
						set_success_msg($this->cls_msg["save_succ"]);				
						redirect($this->pathtoclass."show_list");				
					}				
					else				
					{	
						$this->data["posted"] = $_POST;
					}
				
				}

            }

            ////////////end Submitted Form///////////

            $this->render("manage_affiliates/add-edit");

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
            $this->data['title']		="Edit Affiliate";////Browser Title
            $this->data['heading']		="Edit Affiliate";
            $this->data['pathtoclass']	=$this->pathtoclass;
            $this->data['mode']			="edit";

            ////////////Submitted Form///////////
            if($_POST)

            {	

				$posted=array();
                $posted["h_mode"]				= $this->data['mode'];
				$posted["s_name"]				= trim($this->input->post("s_name"));	
				$posted["i_status"]				= trim($this->input->post("i_status"));
				$posted["s_link"]				= trim($this->input->post("s_link"));
				$posted["s_partner_id"]			= trim($this->input->post("s_partner_id"));
				$posted["h_id"]					= trim($this->input->post("h_id"));
				$posted["h_logo"]				= trim($this->input->post("h_logo"));

				$this->form_validation->set_rules('s_name','Affiliates name','required');
				//$this->form_validation->set_rules('s_link','Affiliates link','required');
				//$this->form_validation->set_rules('s_partner_id','Partner ID','required');
				
				if(isset($_FILES['s_logo']) && !empty($_FILES['s_logo']['name']))
				{
					$s_uploaded_filename = get_file_uploaded( $this->uploaddir,'s_logo','','',$this->allowedExt);  
					$arr_upload_res = explode('|',$s_uploaded_filename);
				}

				if($this->form_validation->run() == FALSE || ($arr_upload_res[0]==='err'))		
				{		
					$this->data['posted'] = $_POST;	
					if($arr_upload_res[0]==='err')
					{
						set_error_msg($arr_upload_res[2]);
					}
					else
					{
						get_file_deleted($this->uploaddir,$arr_upload_res[2]);
					}
				}
                else///validated, now save into DB
                {
					$info				= array();
					$info["s_name"]		= $posted["s_name"];
					$info["i_status"]	= $posted["i_status"];
					$info["s_link"]		= $posted["s_link"];
					$info["s_partner_id"]		= $posted["s_partner_id"];
					if(count($arr_upload_res)==0)
					{
						$info["s_logo"] = 	$posted['h_logo'];
					}
					else
					{
						$info["s_logo"] = 	$arr_upload_res[2];
					}
					
					$arr_wh = array('i_id'=> decrypt($posted["h_id"]));
                    $i_aff=$this->mod_com->common_edit_info($this->db->AFFILIATES,$info,$arr_wh);

                    if($i_aff)////saved successfully
                    {
						if($arr_upload_res[0]==='ok')
						{
							get_image_thumb($this->uploaddir.$arr_upload_res[2], $this->thumbdir, 'thumb_'.$arr_upload_res[2],$this->thumb_ht,$this->thumb_wd);  
							get_file_deleted($this->uploaddir,$posted['h_logo']);
							get_file_deleted($this->thumbdir,'thumb_'.$posted['h_logo']);
						}
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list");
                    }
                    else///Not saved, show the form again
                    {
                        $this->data["posted"]=$posted;
						redirect($this->pathtoclass."show_list");
                    }
                    unset($info,$posted, $i_aff);

                }

            }

            else

            { 

                $info=$this->mod_aff->fetch_this(decrypt($i_id));	

                $posted=array();
				$posted["s_name"]			= trim($info[0]["s_name"]);
				$posted["i_status"]			= trim($info[0]["i_status"]);
				$posted["s_link"]			= trim($info[0]["s_link"]);
				$posted["s_partner_id"]		= trim($info[0]["s_partner_id"]);
				$posted["s_logo"]			= trim($info[0]["s_logo"]);

				$posted["h_id"]= $i_id;
                $this->data["posted"]=$posted;  
                unset($info,$posted);                  

            }
            ////////////end Submitted Form///////////
            $this->render("manage_affiliates/add-edit");
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
							$i_ret_=$this->mod_aff->delete_info(-1);
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
							$i_ret_=$this->mod_aff->delete_info(decrypt($id[$tot]));
							$tot--;
							}

							}
							elseif($id>0)///Deleting single Records
							{
							$i_ret_=$this->mod_aff->delete_info(decrypt($id));
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
    * @param int $i_id, Primary key
    */

    public function show_detail($i_id=0)
    {
        try
        {
            if(trim($i_id)!="")
            {
                $info=$this->mod_aff->fetch_this(decrypt($i_id));
                if(!empty($info))
                {
                    $temp=array();
                    $temp["i_id"]= encrypt($info[0]["i_id"]);////Index 0 must be the encrypted PK 
					$temp["s_name"]= trim($info[0]["s_name"]);
					$temp["s_link"]= trim($info[0]["s_link"]);
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
            $this->render("manage_affiliates/show_detail",TRUE);
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
           

			$this->data['heading']="Manage Affiliates";////Package Name[@package] Panel Heading

            ///////////generating search query///////
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_name=($this->input->post("h_search")?$this->input->post("s_name"):$this->session->userdata("s_name")); 

            if($s_search=="basic")
            {

                $s_where =" WHERE (s_name LIKE '%".my_receive_like($s_name)."%' )";

                /////Storing search values into session///

                $this->session->set_userdata("s_name",$s_name);
                $this->session->set_userdata("h_search",$s_search);

                $this->data["h_search"]=$s_search;
                $this->data["s_name"]=$s_name;

            }
            elseif($s_search=="advanced")
            {

            }
            else////List all records, **not done
            {
                $this->session->unset_userdata("s_name");
                //$this->session->unset_userdata("txt_created_on");
                $this->session->unset_userdata("h_search");                

                $this->data["h_search"]=$s_search;
                $this->data["s_name"]="";    
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

			$arr_sort = array(0=>'i_id',1=>'s_name');
			$s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];            

            $limit	= $this->i_admin_page_limit;
			$info	= $this->mod_aff->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			//print_r ($info);

            /////////Creating List view for displaying/////////

			$table_view=array(); 
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 

            //////Table Headers, with width,alignment///////

            $table_view["caption"]     		=	"Affiliates";
            $table_view["total_rows"]		=	count($info);
			$table_view["total_db_records"]	=	$this->mod_aff->gettotal_info($s_where);
			$table_view["order_name"]		=	$order_name;
			$table_view["order_by"]  		=	$order_by;
            $table_view["src_action"]		= 	$this->pathtoclass.$this->router->fetch_method(); 
            $table_view["details_view"]		=   FALSE;          

            $table_view["headers"][0]["width"]	="40%";
            $table_view["headers"][0]["align"]	="left";

			$table_view["headers"][0]["val"]	="Name";
			$table_view["headers"][1]["val"]	="Logo";
			$table_view["headers"][2]["val"]	="Partner ID"; 
            //////end Table Headers, with width,alignment///////

            /////////Table Data/////////

            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
				$img = $info[$i]["s_logo"] != ''? '<img src="'.base_url().'uploaded/affiliates/thumb/thumb_'.$info[$i]['s_logo'].'" />' : '<img src="'.base_url().'uploaded/img/no_image.jpg"/>';				
				$info[$i]["s_is_active"] = ($info[$i]["i_status"]==1)?'Active':'Inactive';
				
				$i_col=0;

                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);////Index 0 must be the encrypted PK 
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_name"];
				//$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_link"];
				$table_view["tablerows"][$i][$i_col++]	= $img;
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_partner_id"];
				//$table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_is_active"];
            } 

            /////////end Table Data/////////

            unset($i,$i_col,$start,$limit,$action); 

            //$this->data["table_view"]=$this->admin_showin_table($table_view);
			$this->data["table_view"]=$this->admin_showin_order_table($table_view);

            /////////Creating List view for displaying/////////
            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action

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

                    ." s_name='".$posted["duplicate_value"]."'";

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

	

	

	public function __destruct()

    {}

}