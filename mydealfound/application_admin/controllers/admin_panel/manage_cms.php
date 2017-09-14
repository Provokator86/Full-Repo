<?php

/*********

* Author: Mrinmoy Mondal

* Date  : 10 Jan 2012

* Modified By: 

* Modified Date: 

* 

* Purpose:

*  Controller For Content Management

* 

* @package Content Management

* @subpackage Content 

* 

* @link InfController.php 

* @link My_Controller.php

* @link model/content_model.php

* @link views/admin/content/

*/





class Manage_cms extends My_Controller implements InfController

{

    public $cls_msg;//////All defined error messages. 

    public $pathtoclass;

    public $i_content_type = 1; // This is for contenty type;  1=> page content 2=> email [ DEFAULT VALUE IS 1 ]

    public $lang_prefix;

    public function __construct()

	{

		try

		{

			parent::__construct();

			$this->data['title']			=	"Content Management System";////Browser Title

			

			////////Define Errors Here//////

			$this->cls_msg = array();

			$this->cls_msg["no_result"]		=	"No information found about content.";

			$this->cls_msg["save_err"]		=	"Information about content failed to save.";

			$this->cls_msg["save_succ"]		=	"Information about content saved successfully.";

			$this->cls_msg["delete_err"]	=	"Information about content failed to remove.";

			$this->cls_msg["delete_succ"]	=	"Information about content removed successfully.";

			////////end Define Errors Here//////

			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class

			

			//////// loading default model here //////////////

			$this->load->model("cms_model","mod_rect");

			//////// end loading default model here //////////////

			

			

			///////////assigning content type/////////

			$this->i_content_type		=	($this->session->userdata("h_content_type")?$this->session->userdata("h_content_type"):1);

			///////////end assigning content type/////////

            

			//$this->lang_prefix=   $this->session->userdata('lang_prefix');

			$this->lang_prefix=  "en";  //Default language prefix.

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

			/*$this->i_content_type = 1;

			$this->session->set_userdata("h_content_type",$this->i_content_type); 			*/

			redirect($this->pathtoclass."modify_information");

			//redirect($this->pathtoclass."add_information");

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

            $this->data['heading']=($this->i_content_type==1?"Content Management ":"Email Templates");////Package Name[@package] Panel Heading



            ///////////generating search query///////

            ////////Getting Posted or session values for search///

            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));

            $s_content_title=($this->input->post("h_search")?$this->input->post("txt_content_title"):$this->session->userdata("txt_content_title")); 

            $dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_on"):$this->session->userdata("txt_created_on"));

			$i_content_type	=	($_POST["h_search"]?$this->input->post("h_content_type"):$this->i_content_type);

			$this->session->set_userdata("h_content_type",$i_content_type); 

			////////end Getting Posted or session values for search///

            

            

            $s_where="";

            if($s_search=="basic")

            {

                $s_where=" WHERE c.s_title LIKE '%".get_formatted_string($s_content_title)."%' AND c.i_type = $i_content_type";

                /////Storing search values into session///

                $this->session->set_userdata("txt_content_title",$s_content_title);

                $this->session->set_userdata("h_search",$s_search);

                

                $this->data["h_search"]=$s_search;

                $this->data["txt_content_title"]=	$s_content_title;

				$this->data["h_content_type"]	=	$i_content_type;

                /////end Storing search values into session///

            }

            elseif($s_search=="advanced")

            {

                $s_where=" WHERE c.s_title LIKE '%".get_formatted_string($s_content_title)."%' AND c.i_type = $i_content_type";

                if(trim($dt_created_on)!="")

                {

                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 

                    $s_where.=" And FROM_UNIXTIME( c.dt_entry_date , '%Y-%m-%d' ) ='".$dt_start."' ";

                    unset($dt_start);

                }

                

                /////Storing search values into session///

                $this->session->set_userdata("txt_content_title",$s_content_title);

                $this->session->set_userdata("txt_created_on",$dt_created_on);

                $this->session->set_userdata("h_search",$s_search);				

                

                $this->data["h_search"]=$s_search;

                $this->data["txt_content_title"]=$s_content_title;                

                $this->data["txt_created_on"]=$dt_created_on;   

				$this->data["h_content_type"]=$i_content_type;          

                /////end Storing search values into session///                

                

            }

            else////List all records, **not done

            {

				

              	$s_where=" WHERE c.i_type = $i_content_type";

				

                /////Releasing search values from session///

                $this->session->unset_userdata("txt_content_title");

                $this->session->unset_userdata("txt_created_on");

                $this->session->unset_userdata("h_search");

                

				$this->data["h_search"]=$s_search;

                $this->data["txt_content_title"]="";                

                $this->data["txt_created_on"]="";    

				$this->data["h_content_type"]=$i_content_type;         

                /////end Storing search values into session///                 

                

            }

            unset($s_search,$s_content_title,$dt_created_on,$i_content_type);

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

			//echo count($info);

			//echo "<pre>";print_r($info);echo "</pre>";exit;

            /////////Creating List view for displaying/////////

            $table_view=array();     

			       

            //////Table Headers, with width,alignment///////

            $table_view["caption"]="Content";

            $table_view["total_rows"]=count($info);

			$table_view["total_db_records"]=$this->mod_rect->gettotal_info($s_where);

                        

            $table_view["headers"][0]["width"]	="20%";

            $table_view["headers"][0]["align"]	="left";

            $table_view["headers"][0]["val"]	="Page Title";

			$table_view["headers"][1]["width"]	="50%";  

            $table_view["headers"][1]["val"]	="Description";

            $table_view["headers"][2]["val"]	="Created On"; 

           // $table_view["headers"][3]["val"]	="Status"; 

            //////end Table Headers, with width,alignment///////

			

            /////////Table Data/////////

            for($i=0; $i<$table_view["total_db_records"]; $i++)

            {

                $i_col=0;

                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 

                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_title"];

                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_description"];

                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_created_on"];

               // $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_is_active"];



            } 

            /////////end Table Data/////////

			

            unset($i,$i_col,$start,$limit); 

   

            $this->data["table_view"]=$this->admin_showin_table($table_view,TRUE);

            /////////Creating List view for displaying/////////

            $this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();///used for search form action



			$this->render("manage_cms/show_list");

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

        //echo 'politique de confidentialit&eacute;';

		try

        {

            $this->data['title']			=	"Content Management";////Browser Title

            $this->data['heading']			=	"CMS";

            $this->data['pathtoclass']		=	$this->pathtoclass;

            $this->data['mode']				=	"add";

			$this->data['i_content_type']	=	$this->i_content_type;

			$posted=array();

            $posted["opt_language"]         =   $this->lang_prefix;

                

            $this->data["posted"]           =   $posted;

            ////////////Submitted Form///////////

            if($_POST)

            {



				$posted=array();

				$posted["opt_title"]				=	trim($this->input->post("opt_title"));

				$posted["opt_language"]				=	(trim($this->input->post("opt_language"))?trim($this->input->post("opt_language")):'en');

				

                $posted["txt_content_title"]		= 	trim($this->input->post("txt_content_title"));

                $posted["txt_content_description"]	= 	trim($this->input->post("txt_content_description"));				

				

				$posted["i_content_type"]			= 	intval($this->i_content_type);

				

                $posted["h_mode"]= $this->data['mode'];

                $posted["h_id"]= "";

				

				

               

                $this->form_validation->set_rules('opt_title', 'select type', 'required');

				//$this->form_validation->set_rules('opt_language', 'select language', 'required');

				$this->form_validation->set_rules('txt_content_title', 'content title', 'required');

                $this->form_validation->set_rules('txt_content_description', 'content description', 'required');

				

              	$info	=	array();				

				

				$is_data_exist = $this->mod_rect->fetch_content_using_cms_type_id(decrypt($posted["opt_title"]),decrypt($posted["opt_language"]));

				

				$data_exist_id = $is_data_exist['id'];  // to get the id for update if data exist

				

				

				

                if($this->form_validation->run() == FALSE )/////invalid

                {

                    ////////Display the add form with posted values within it////

                    $this->data["posted"]=$posted;

                }

                else///validated, now save into DB

                {

                    $info["i_cms_type_id"]			=	$posted["opt_title"];

					//$info["i_lang_id"]				=	$posted["opt_language"];

					$info["s_lang_prefix"]			=	$posted["opt_language"];

					$info["s_title"]				=	$posted["txt_content_title"];

                    $info["s_description"]			=	$posted["txt_content_description"];					

                    //$info["i_status"]				=	$posted["i_content_is_active"];

                    $info["i_type"]					=	$posted["i_content_type"];

                    $info["dt_entry_date"]			=	time();	

					

									

					

                    if(!$is_data_exist)  //  INSERTING NEW CMS RECORD

						{

							$i_newid = $this->mod_rect->add_info($info);

							if($i_newid)////saved successfully

							{

								set_success_msg($this->cls_msg["save_succ"]);

								if($this->i_content_type==1)////for page content type

								{

									//redirect($this->pathtoclass."show_list");

									redirect($this->pathtoclass."add_information");

								}

								else////for email content type

								{

									redirect($this->pathtoclass."show_email_content");

								}	

							}

							else///Not saved, show the form again

							{

								set_error_msg($this->cls_msg["save_err"]);

							}

						}

						

					else		//  UPDATIMG THE EXISTING CMS RECORD

						{ 

							

							$i_aff=$this->mod_rect->edit_info($info,$data_exist_id);

							if($i_aff)////saved successfully

								{

									set_success_msg($this->cls_msg["save_succ"]);

									//redirect($this->pathtoclass."show_list");

									redirect($this->pathtoclass."add_information");

								}

							else///Not saved, show the form again

								{

									$this->data["posted"]=$posted;

									set_error_msg($this->cls_msg["save_err"]);

								}

							

						}	

                    

                }

            }

            ////////////end Submitted Form///////////

            $this->render("manage_cms/add-edit");

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

            $this->data['title']="Edit Content Details";////Browser Title

            $this->data['heading']="Edit content";

            $this->data['pathtoclass']=$this->pathtoclass;

            $this->data['mode']="edit";

            $this->data['i_content_type']	=	$this->i_content_type;

            $this->data['thumbDir']= $this->showthmimgdir;

			

            ////////////Submitted Form///////////

            if($_POST)

            {

				$posted=array();

				$posted["opt_title"]				=	trim($this->input->post("opt_title"));

				$posted["opt_language"]				=	trim($this->input->post("opt_language"));				

                $posted["txt_content_title"]		= 	trim($this->input->post("txt_content_title"));

                $posted["txt_content_description"]	= 	trim($this->input->post("txt_content_description"));				

				

				$i_active_val 						= 	trim($this->input->post("i_content_is_active"));

                $posted["i_content_is_active"]		= 	($i_active_val==1)?$i_active_val:2;

				$posted["i_content_type"]			= 	intval($this->i_content_type);

				

                $posted["h_id"]						=   trim($this->input->post("h_id"));

				$posted["h_mode"]					= 	$this->data['mode'];

				

				

                $this->form_validation->set_rules('opt_title', 'select type', 'required');

				//$this->form_validation->set_rules('opt_language', 'select language', 'required');

				$this->form_validation->set_rules('txt_content_title', 'content title', 'required');

                $this->form_validation->set_rules('txt_content_description', 'content description', 'required');

				

             	$info	=	array();

				

			 

                if($this->form_validation->run() == FALSE )/////invalid

                {

                    ////////Display the add form with posted values within it////

                    $this->data["posted"]=$posted;

                }

				

				

                else///validated, now save into DB

                {

                    $info["i_cms_type_id"]			=	$posted["opt_title"];

					$info["i_lang_id"]				=	$posted["opt_language"];

					$info["s_title"]				=	$posted["txt_content_title"];

                    $info["s_description"]			=	$posted["txt_content_description"];					

                    $info["i_status"]				=	$posted["i_content_is_active"];

                    $info["i_type"]					=	$posted["i_content_type"];

                    $info["dt_entry_date"]			=	strtotime(date("Y-m-d H:i:s"));

					

					

                    $i_aff=$this->mod_rect->edit_info($info,decrypt($posted["h_id"]));

                    if($i_aff)////saved successfully

                    {

						

                        //$this->session->set_userdata('success_msg', $this->cls_msg["save_succ"]);

                        set_success_msg($this->cls_msg["save_succ"]);

                        if($this->i_content_type==1)////for page content type

						{

							redirect($this->pathtoclass."modify_information");

						}

                    }

                    else///Not saved, show the form again

                    {

                        //$this->session->set_userdata('error_msg', $this->cls_msg["save_err"]);

                        $this->data["posted"]=$posted;

                        //$this->data["error_msg"]=$this->cls_msg["save_err"];

                        set_error_msg($this->cls_msg["save_err"]);

                    }

                    unset($info,$posted);

                    

                }

            }

            else

            {

                $info=$this->mod_rect->fetch_this(decrypt($i_id));

                $posted=array();

				$posted["txt_name"]= trim($info["s_name"]);

				$posted["txt_content_title"]= trim($info["s_title"]);

				$posted["txt_content_description"]= trim($info["s_description"]);

				

				$posted["dt_created_on"]= trim($info["dt_created_on"]);

				$posted["h_content_type"]= $info["i_cms_type_id"];

				$posted["h_id"]= $i_id;

				$posted["i_id"]= decrypt($i_id);

				

                $this->data["posted"]=$posted;       

                unset($info,$posted);      

                

            }

            ////////////end Submitted Form///////////

            $this->render("manage_cms/add-edit");

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

			echo "here";

            $i_ret_=0;

            $pageno=$this->input->post("h_pageno");///the pagination page no, to return at the same page

            

            /////Deleting What?//////

            $s_del_these=$this->input->post("h_list");

			

            switch($s_del_these)

			{

				case "all":

							$i_ret_=$this->mod_rect->delete_all_info($i_content_type);

							break;

				default: ///Deleting selected,page ///

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

            unset($s_del_these,$id,$tot);

            

            if($i_ret_)

            {

                set_success_msg($this->cls_msg["delete_succ"]);

            }

            else

            {

                set_error_msg($this->cls_msg["delete_err"]);

            }

            redirect($this->pathtoclass."show_list".($pageno?"/".$pageno:""));

			/*if($this->i_content_type==1)////for page content type

			{

				redirect($this->pathtoclass."show_list".($pageno?"/".$pageno:""));

			}

			else////for email content type

			{

				redirect($this->pathtoclass."show_email_content".($pageno?"/".$pageno:""));

			}*/			

			

			

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

                $info=$this->mod_rect->fetch_this(decrypt($i_id));



                if(!empty($info))

                {

                    $temp=array();

                    $temp["s_id"]= encrypt($info["id"]);////Index 0 must be the encrypted PK 

					$temp["s_content_title"]= trim($info["s_title"]);

					$temp["s_content_description"]= trim($info["s_description"]);

					$temp["s_is_active"]= trim($info["s_is_active"]);

					$temp["dt_created_on"]= trim($info["dt_created_on"]);



					$this->data["info"]=$temp;

                    unset($temp);

                }

                unset($info);

            }

            $this->add_css("css/admin/style.css");///include main css

            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css

            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css

            

            $this->render("manage_cms/show_detail",TRUE);

            unset($i_id);

        }

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }         

    }

	

	public function show_email_content()

	{

		try

        {

			$this->i_content_type = 2;

			$this->session->set_userdata("h_content_type",$this->i_content_type); 

			$this->show_list();

		}

	  	catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }

	}

	

	

	 /**
    * This ajax function is used to fetch contains of faq in selected language.
    * posted data is language prefix and cms type id. 
    */

	function ajax_get_content()
	{
		$type_id = $this->input->post("type_id");
		$lang_id = $this->input->post("lang_id");
		$info = array();
		$info = $this->mod_rect->fetch_content_using_cms_type_id(decrypt($type_id),$lang_id);
		//print_r($info);exit;
		//echo ($info['s_title']).'^'.($info['s_description']);
		echo json_encode($info);
		/*if(!empty($info))
		{
			echo json_encode($info);
		}*/
	}

	

	public function __destruct()

    {}           

}

?>