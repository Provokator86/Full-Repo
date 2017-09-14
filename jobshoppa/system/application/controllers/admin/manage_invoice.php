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


class Manage_invoice extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
            
        try
        {
          parent::__construct();
          $this->data['title']="Invoice";////Browser Title

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
          $this->load->model("comm_payment_model","mod_rect");
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
    public function show_list($order_name='',$order_by='DESC',$start=NULL,$limit=NULL)
    {
        try
        {
            $this->data['heading']="Manage Invoice";////Package Name[@package] Panel Heading

            ///////////generating search query///////
			
            ////////Getting Posted or session values for search///
            $s_search=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
            $s_title=($this->input->post("h_search")?$this->input->post("s_title"):$this->session->userdata("s_title")); 
            $dt_created_to=($this->input->post("h_search")?$this->input->post("txt_created_to"):$this->session->userdata("txt_created_to"));
			$dt_created_on=($this->input->post("h_search")?$this->input->post("txt_created_frm"):$this->session->userdata("txt_created_frm"));
            $s_cat=($this->input->post("h_search")?$this->input->post("s_cat"):$this->session->userdata("s_cat")); 
			
			$opt_buyer_id=($this->input->post("h_search")?$this->input->post("opt_buyer_id"):$this->session->userdata("opt_buyer_id")); 
            ////////end Getting Posted or session values for search///
            
            // ******* below $s_where is done shortly to do not get any data as 
			//we have no database yet or any record === mrinmoy->28-09-2011
			
            $s_where=" WHERE j.i_is_deleted !=1 "; 
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
                	$s_where.=" And j.s_title LIKE '%".get_formatted_string($s_title)."%' ";
				}				
				if($s_cat!="")
				{
					$s_where.=" And j.i_category_id=".decrypt($s_cat)." ";
				}
				if($opt_buyer_id!="")
				{
					$s_where.=" And j.i_buyer_user_id=".decrypt($opt_buyer_id)." ";
				}
				
                if(trim($dt_created_on)!="" && trim($dt_created_to)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
					$dt_to=date("Y-m-d",strtotime(trim($dt_created_to." "))) ;
                    $s_where.=" AND FROM_UNIXTIME( n.i_payment_date , '%Y-%m-%d' ) BETWEEN '".$dt_start."' AND '".$dt_to."'";
                    unset($dt_start,$dt_to);
                }
				elseif(trim($dt_created_on)!="")
                {
                    $dt_start=date("Y-m-d",strtotime(trim($dt_created_on." "))) ; 
					
                    $s_where.=" AND FROM_UNIXTIME( n.i_payment_date , '%Y-%m-%d' ) >='".$dt_start."'";
                    unset($dt_start);
                }
				elseif(trim($dt_created_to)!="")
                {
					$dt_to=date("Y-m-d",strtotime(trim($dt_created_to." "))) ;
                    $s_where.=" AND FROM_UNIXTIME( n.i_payment_date , '%Y-%m-%d' ) <='".$dt_to."'";
                    unset($dt_to);
                }
                
                /////Storing search values into session///
                $this->session->set_userdata("s_title",$s_title);
				$this->session->set_userdata("s_cat",$s_cat);
				$this->session->set_userdata("opt_buyer_id",$opt_buyer_id);
                $this->session->set_userdata("txt_created_frm",$dt_created_on);
				$this->session->set_userdata("txt_created_to",$dt_created_to);
                $this->session->set_userdata("h_search",$s_search);
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]=$s_title;   
				$this->data["s_cat"]=$s_cat;     
				$this->data["opt_buyer_id"]=$opt_buyer_id;                   
                $this->data["txt_created_frm"]=$dt_created_on;  
				$this->data["txt_created_to"]=$dt_created_to;                
                /////end Storing search values into session///                 
                
            }
            else////List all records, **not done
            {
                
                /////Releasing search values from session///
                 /////Releasing search values from session///
                $this->session->unset_userdata("s_title");
				 $this->session->unset_userdata("s_cat");
                $this->session->unset_userdata("txt_created_frm");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"]=$s_search;
                $this->data["s_title"]="";      
				$this->data["s_cat"]="";              
                $this->data["txt_created_frm"]="";      
				$this->data["txt_created_to"]='';               
                /////end Storing search values into session///                  
                
            }
            unset($s_search,$s_user_type,$dt_created_on);
            ///Setting Limits, If searched then start from 0////
			$i_uri_seg = 6;
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
			$arr_sort = array(0=>'i_payment_date',1=>'i_invoice_no',6=>'i_rating');   
			// echo $order_name.'---';
			//  echo decrypt($order_name);
            $s_order_name = !empty($order_name)?in_array(decrypt($order_name),$arr_sort)?decrypt($order_name):$arr_sort[0]:$arr_sort[0];
			$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name;
            
            $limit	= $this->i_admin_page_limit;
            $info	= $this->mod_rect->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
			
			//pr($info);
            /////////Creating List view for displaying/////////
            $table_view=array();  
			          
            //////Table Headers, with width,alignment///////
            $table_view["caption"]="Commission Payment";
            $table_view["total_rows"]=count($info);
			$table_view["total_db_records"]=$this->mod_rect->gettotal_sort_info($s_where);
			$table_view["order_name"]=$order_name;
			$table_view["order_by"]  =$order_by;
            $table_view["src_action"]= $this->pathtoclass.$this->router->fetch_method();   
			$table_view["detail_view"] = FALSE;
             $j_col = 0;   
			$table_view["headers"][$j_col]["val"]	="Invoice No"; 
			$table_view["headers"][$j_col]["width"]	="9%";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[1]));        
            $table_view["headers"][++$j_col]["val"]	="Job Title";
		//	$table_view["headers"][++$j_col]["val"]	="Buyer Name";
			$table_view["headers"][++$j_col]["val"]	="Commission Paid By";
			$table_view["headers"][++$j_col]["val"]	="Invoice Date"; 
			$table_view["headers"][$j_col]["width"]	="12%";
			$table_view["headers"][$j_col]["sort"]	= array('field_name'=>encrypt($arr_sort[0]));
		///	$table_view["headers"][$j_col]["align"]	="right";
			$table_view["headers"][++$j_col]["val"]	="Commission Amount";
			$table_view["headers"][$j_col]["width"]	="14%";
			$table_view["headers"][$j_col]["align"]	="right";
		//	$table_view["headers"][++$j_col]["val"]	="Transaction ID";			
			$table_view["headers"][++$j_col]["val"]	="Action"; 
			$table_view["headers"][$j_col]["align"]	="center";
			$table_view["headers"][$j_col]["width"]	="7%";
            //$table_view["headers"][6]["val"]	="Status"; 
            //////end Table Headers, with width,alignment///////
			
            /////////Table Data/////////
			$d_total_quote = 0.00;
			$d_total_pay = 0.00;
            for($i=0; $i<$table_view["total_rows"]; $i++)
            {
                $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["id"]);////Index 0 must be the encrypted PK 
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["i_invoice_no"];
                $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_job_title"];
			//	$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_buyer_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_tradesman_name"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["dt_payment_date"];
			//	$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_quote_amount"];
				$table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_pay_amount"];
           //     $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_transaction_id"];
                
				
				
				$link = '<a href="'.$this->pathtoclass.'showPdfInvoice/'.encrypt($info[$i]['i_job_id']).'"><img src="images/fe/pdf_icon_small.gif" alt="Download Invoice" title="Download Invoice" /></a>';
				$table_view["tablerows"][$i][$i_col++]	=$link;
				$d_total_quote = doubleval($d_total_quote + $info[$i]["d_quote_amount"]);
				$d_total_pay = doubleval($d_total_pay + $info[$i]["d_pay_amount"]);

            } 
            /////////end Table Data/////////
			/***************
				 $i_col=0;
                $table_view["tablerows"][$i][$i_col++]	= '';////Index 0 must be the encrypted PK 
				//$table_view["tablerows"][$i][$i_col++]	='';
                $table_view["tablerows"][$i][$i_col++]	='';
				$table_view["tablerows"][$i][$i_col++]	='';
				
				$table_view["tablerows"][$i][$i_col++]	='';
				$table_view["tablerows"][$i][$i_col++]	= '';
			//	$table_view["tablerows"][$i][$i_col++]	= 'Total: '.$d_total_quote.' '.$this->config->item("default_currency");
          //      $table_view["tablerows"][$i][$i_col++]	=$info[$i]["s_transaction_id"];
                
				
				
				
				$table_view["tablerows"][$i][$i_col++]	='Total: '.$d_total_pay.' '.$this->config->item("default_currency");
				$table_view["tablerows"][$i][$i_col++]	='';
			/****************/
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
					pr($temp);
					$this->data["info"]=$temp;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
            
            $this->render("comm_payment_report/show_detail",TRUE);
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
	public function showPdfInvoice($s_job_id)
    {
		//$i_job_id = $this->uri->segment(3); 
		$this->load->model('job_model');
		$s_wh = " WHERE n.id=".decrypt($s_job_id)." ";
		$info	=	$this->job_model->fetch_invoice_details($s_wh);
		//pr($info,1);
		$this->load->library('Text_price_format');
		$currency_object = new Text_price_format();
		//$customer_name 	= $info[0]['s_username'];
		$customer_name 	= $info[0]['s_business_name'];
		$address 		= $info[0]['s_address'];
		$state 			= $info[0]['s_state'];
		$city 			= $info[0]['s_city'];
		$postal 		= $info[0]['s_postal_code'];
		$payment_date	= $info[0]['dt_payment_date'];
		$job_title 		= $info[0]['s_title'];
		$job_cost		= $info[0]['s_budget_price'];
		$quote_price	= $info[0]['s_quote_price'];	
		$paid_amount	= ($info[0]['s_paid_amount']);
		
		//$paid_amount_word = convert_number($info[0]['s_paid_amount']);
		$paid_amnt	= number_format($paid_amount, 2, '.', '');
		$paid_amount_word = convert_number($paid_amnt);
		$invoice_no	=	$info[0]['i_invoice_no'];
		
		$this->load->model('commission_slab_model');
		$s_where = " WHERE 	i_is_active=1";
		$comm = $this->commission_slab_model->fetch_multi($s_where);	
		$commission = $comm[0]['s_commission_slab_100'];
		
       
		$logo_path = BASEPATH.'../images/fe/logo.png';
		$right_image_path = BASEPATH.'../images/fe/grey_up.png';
		$left_image_path = BASEPATH.'../images/fe/grey_down.png';
		
        $html_n = '<html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
					<title>JobShoppa.com</title>
					</head>
					<body style="margin:0px; padding:0px;">
					<table style="width:600px; margin:0px auto; line-height:16px; background-color:#FFFFFF; color:#000;font-size:12px;font-family:Arial, Helvetica, sans-serif;" border="0" cellspacing="0" cellpadding="0">
						  <tr>
								<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												  <td width="60%" style="padding:5px 12px"><img src="'.$logo_path.'" alt="" style="margin-top:5px;" /></td>
												  <td width="40%" align="right" style="padding:5px 12px;color:#616161;"><br />
					<br />
					</td>
											</tr>
									  </table></td>
						  </tr>
						  <tr>
								<td style="border-bottom:1px solid #bfbfbf;border-top:1px solid #bfbfbf; text-transform:uppercase; font-size:16px; font-family:myriad Pro, arial;" align="right"><p style="padding:7px 12px; margin:0px;"><strong>INVOICE NO :</strong> <span style="color:#f87d33;"><strong>'.$invoice_no.'</strong></span></p></td>
						  </tr>
						  <tr>
								<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												  <td width="57%" style="padding:12px ;color:#616161;"><span style="color:#000;"><strong>'.$customer_name.'</strong></span><br />
														'.$address .',<br />
														'.$state.', '.$city.',<br />
														'.$postal.'</td>
												  <td width="43%" align="right" valign="top" style="color:#616161;padding:12px;"><span style="color:#000;"><strong>Date:</strong></span> '.$payment_date.'</td>
											</tr>
									  </table></td>
						  </tr>
						  <tr>
								<td  style="background-color:#f1f1f1;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												  <td align="right" valign="top"><img src="'.$right_image_path.'" alt="" /> </td>
											</tr>
											<tr>
												  <td style="padding:0px 30px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
															  <tr>
																	<td width="73%" style="border-bottom:1px solid #b5b5b5; font-size:14px;  text-transform:uppercase;padding:0px 12px 12px;" ><strong>Description</strong></td>
																	<td width="16%" style="border-bottom:1px solid #b5b5b5;font-size:14px; text-transform:uppercase;padding:0px 12px 12px;"><strong>Amount(s)</strong></td>
															  </tr>
															  <tr>
																	<td style="border-bottom:1px solid #b5b5b5; padding:8px;" height="80"   align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="4">
																				<tr>
																					  <td width="31%" align="left" valign="top">Job Type : </td>
																					  <td width="69%" valign="top" style="color:#616161;"> '.$job_title.' </td>
																				</tr>
																				<tr>
																					  <td valign="top" align="left"> Job Cost : </td>
																					  <td style="color:#616161;" valign="top"> '.$quote_price.' </td>
																				</tr>
																				<tr>
																					  <td valign="top" align="left"> Commission : </td>
																					  <td style="color:#616161;" valign="top">@ '.$commission.'% </td>
																				</tr>
																		  </table></td>
																	<td style="border-bottom:1px solid #b5b5b5;border-left:1px solid #b5b5b5;padding:12px;" align="center" valign="top">&#163; '.$paid_amount.'  </td>
															  </tr>
															  <tr>
																	<td style="border-bottom:1px solid #b5b5b5; font-size:14px;padding:12px 12px;"  align="right" valign="top"> Net Payable Amount</span> </td>
																	<td style="border-bottom:1px solid #b5b5b5;font-size:14px;color:#f87d33;border-left:1px solid #b5b5b5;padding:12px 12px;" align="center" valign="top"><strong>&#163; '.$paid_amount.' </strong> </td>
															  </tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="3" style="margin:10px 8px 0px;">															 
															  <tr>
																	<td width="30%" valign="top"> Payment Method  :</td>
																	<td width="70%" style="color:#616161;" valign="top"> PAYPAL </td>
															  </tr>
														</table></td>
											</tr>
											<tr>
												  <td align="left" valign="baseline"><p style="height:30px; overflow:hidden; padding:0px; margin:0px;background-color:#f1f1f1;"><img src="'.$left_image_path.'" alt="" /> </p></td>
											</tr>
									  </table></td>
						  </tr>
						  <tr>
								<td colspan="2" style=" color:#aaa; padding-top:10px; font-size:11px; text-align:center; font-family:Georgia, Times New Roman, Times, serif; ">Waterway Enterprise Ltd, 19 Waterloo Crescent, Wigston, Leicester, LE183QJ, UK
									  <p style="padding:0px; margin:0px; color:#666">Registration Number: 7521953</p></td>
						  </tr>
						  <tr>
								<td colspan="2" style=" color:#09c7e4; padding-top:5px; font-size:11px; text-align:center; font-family:Georgia, Times New Roman, Times, serif; "><em><strong>JobShoppa.com</strong></em></td>
						  </tr>
					</table>
					</body>
					</html>'; 
        
       $this->load->plugin('to_pdf');
       $ffname = 'invoice_'.time();
       pdf_create($html_n, $ffname);



    }
	public function __destruct()
    {}
	
	
}
?>