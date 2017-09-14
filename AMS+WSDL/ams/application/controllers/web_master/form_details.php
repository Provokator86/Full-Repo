<?php 
/***
File Name: form_details.php 
Created By: SWI Dev 
Created On: June 6, 2016 
Purpose: CURD for News 

*/

class Form_details extends MY_Controller 
{
	public $patchtoclass, $cls_msg, $tbl;
	protected $tbl_ref_use;
	public function __construct(){
		parent::__construct();
		$this->data["title"] 	= addslashes(t('Form Details'));//Browser Title 
		$this->pathtoclass 		= admin_base_url().$this->router->fetch_class()."/";
		$this->tbl 				= $this->db->FORM_DETAILS;// Default Table
		$this->tbl_master 		= $this->db->FORM_MASTER;
        $login_data 			= $this->session->userdata("admin_loggedin");
        $this->login_data 		= $login_data;
        //pr($login_data);
        if(!empty($login_data))
        {
            $log_user_id        = decrypt($login_data['user_id']);
            $log_user_role      = decrypt($login_data['user_type_id']);
            $this->user_role    = $log_user_role;
            $this->user_id      = $log_user_id;
        }
	}

	//Default method (index)
	public function index()
	{
		redirect($this->pathtoclass.'show_list');
	}

    /****
    * Display the list of records 
    */
    public function show_list($order_by = '', $sort_type = 'asc',$start = NULL, $limit = NULL)
    {
        try
        {
			//error_reporting(E_ALL);
			//ini_set('display_errors', 1);
			/*$xml		= simplexml_load_file(FCPATH."uploaded/xml/data.xml") or die("Error: Cannot create object");			
			$json 		= json_encode($xml);
			$xml_fixed 	= json_decode($json);
			//pr($xml_fixed);
			$payerInfo = $xml_fixed->PayerInfo;
			$rec = $xml_fixed->Recipient;
			//pr($payerInfo);
			if(!empty($rec))
			{
				foreach($rec as $val)
				{
					//echo 'Id: '.$val['id'].'</br>';
					echo 'Name: '.$val->Rname.'</br>';
					echo 'Addr: '.$val->Raddr.'</br>';
					echo 'Box1: '.$val->Box1.'</br>';
					echo 'Box2: '.$val->Box2.'</br>';
					echo '--------- --------------- ----'.'</br>';
				}
			}*/
			
			/*//############################### READ XML TEST START ######################//
			$xml=simplexml_load_file(FCPATH."uploaded/xml/books.xml") or die("Error: Cannot create object");
			$books = $xml->children();			
			if(!empty($books))
			{
				foreach($books as $val)
				{
					echo 'Category: '.$val['category'].'</br>';
					echo 'Title: '.$val->title.'</br>';
					echo 'Title: '.$val->author.'</br>';
					echo 'Title: '.$val->year.'</br>';
					echo 'Title: '.$val->price.'</br>';
					echo '--------- --------------- ----'.'</br>';
				}
			}*/
			//############################### READ XML TEST END ######################//
			
			$form_id = $this->session->userdata('sess_form_id');
			
            $this->data['heading'] = addslashes(t("Form Details")); //Package Name[@package] Panel Heading           
            //generating search query//
            $arr_session_data = $this->session->userdata("arr_session");
            if($arr_session_data['searching_name'] != $this->data['heading'])
            {
                $this->session->unset_userdata("arr_session");
                $arr_session_data = array();
            }
            
            $search_variable = array();
            //Getting Posted or session values for search//     
            $s_search = (isset($_GET["h_search"])?$this->input->get("h_search"):$this->session->userdata("h_search"));
            $search_variable["i_form_id"] 	= ($this->input->get("h_search")?$this->input->get("i_form_id"):$arr_session_data["i_form_id"]);            
            $search_variable["dt_from"]		= ($this->input->get("h_search")?$this->input->get("dt_from"):$arr_session_data["dt_from"]);
            $search_variable["dt_to"]		= ($this->input->get("h_search")?$this->input->get("dt_to"):$arr_session_data["dt_to"]);
            //end Getting Posted or session values for search//            
            
            $s_where = " n.i_id>0 ";
            if($form_id)
            {
				$s_where .= " AND n.i_form_id = '".addslashes($form_id)."' ";
				$s_search = "advanced";
				$search_variable["i_form_id"] = $form_id;
			}
			else
				redirect(base_url().'web_master/manage_forms/show_list');
				
            if($s_search == "advanced")
            {
                $arr_session = array();
                //$arr_session["searching_name"] = $this->data['heading'];
                $search_variable["searching_name"] = $this->data['heading'];
                if($search_variable["i_form_id"]!="")
                {
                    $s_where .= " AND n.i_form_id = '".addslashes($search_variable["i_form_id"])."' ";
                }
                //$arr_session["i_form_id"] = $search_variable["i_form_id"];
                //$this->data["i_form_id"] = $search_variable["i_form_id"];
                
                
                if($search_variable["dt_from"] != '' && $search_variable["dt_to"] !='')
                {
                    $s_where .= ' AND (DATE_FORMAT(n.dt_added, "%Y-%m-%d") >="'.make_db_date($search_variable["dt_from"]).'" AND DATE_FORMAT(n.dt_added, "%Y-%m-%d") <= "'.make_db_date($search_variable["dt_to"]).'") ';
                }
                else if($search_variable["dt_from"] != '')
                    $s_where .= ' AND DATE_FORMAT(n.dt_added, "%Y-%m-%d") >="'.make_db_date($search_variable["dt_from"]).'" ';
                else if($search_variable["dt_to"] != '')
                    $s_where .= ' AND DATE_FORMAT(n.dt_added, "%Y-%m-%d") <= "'.make_db_date($search_variable["dt_to"]).'" ';
                
                
                /*$arr_session["dt_from"] = $search_variable["dt_from"] ;
                $arr_session["dt_to"] = $search_variable["dt_to"] ;                
                $this->data["dt_from"]     = $search_variable["dt_from"];                
                $this->data["dt_to"]     = $search_variable["dt_to"];                
                
                $this->session->set_userdata("arr_session",$arr_session);
                $this->session->set_userdata("h_search",$s_search);
                $this->data["h_search"] = $s_search;  */
                
                if(!empty($search_variable))
                {
                    foreach($search_variable as $k=>$v)
                        $this->data[$k] = $v;
                }
                $this->session->set_userdata("arr_session",$search_variable);
                $this->session->set_userdata("h_search",$s_search);
                $this->data["h_search"] = $s_search;                 
                                          
            }      
            else //List all records, **not done
            {
                //Releasing search values from session//
                $this->session->unset_userdata("arr_session");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"] 	= $s_search;
                $this->data["arr_session"] 	= '';                        
                $this->data["dt_from"]     	= "";                            
                $this->data["dt_to"]     	= "";                            
                //end Storing search values into session//                 
            }
            
            unset($s_search,$arr_session,$search_variable);
              
            //Setting Limits, If searched then start from 0//
            $i_uri_seg = 6;
            $start = $this->input->get("h_search") ? 0 : $this->uri->segment($i_uri_seg);
            //end generating search query//
            
            // List of fields for sorting
            $arr_sort = array('0'=>'n.dt_added');   
            $order_by= !empty($order_by)?in_array(decrypt($order_by),$arr_sort)?decrypt($order_by):$arr_sort[0]:$arr_sort[0];
            
            $limit = $this->i_admin_page_limit = 100;
			

            $tbl[0] = array(
                'tbl' => $this->tbl.' AS n',
                'on' =>''
            );

            $tbl[1] = array(
                'tbl' => $this->tbl_master.' AS u',
                'on' => 'n.i_form_id = u.i_id'
            );
            $conf = array(
                'select' => 'n.i_id, n.i_form_id, n.e_record_type, n.i_field_pos_start, n.i_field_pos_end, n.dt_added, n.s_purpose_fileds, n.s_xml_tag, u.s_form_title',
                'where' => $s_where,
                'limit' => $limit,
                'offset' => $start,
                'order_by' => $order_by,
                'order_type' => $sort_type
            );
            $info = $this->acs_model->fetch_data_join($tbl, $conf);
            
            $conf2 = array(
                'select' => 'count(n.i_id) AS total',
                'where' => $s_where
            );
            $tmp =  $this->acs_model->fetch_data_join($tbl, $conf2);
            $total = $tmp[0]['total'];
            unset($tmp);

                  
            //Creating List view for displaying//
            $table_view = array();  
            
            //Table Headers, with width,alignment//
            $table_view["caption"]                 = addslashes(t("Form Details"));
            $table_view["total_rows"]              = count($info);
            $table_view["total_db_records"]        = $total;
            $table_view["detail_view"]             = false;  // to disable show details. 
            $table_view["order_name"]              = encrypt($order_by);
            $table_view["order_by"]                = $sort_type;
            $table_view["src_action"]              = $this->pathtoclass.$this->router->fetch_method();
            
            $j = -1;
            
			$table_view["headers"][++$j]["width"] 	= "20%";
			$table_view["headers"][$j]["align"] 	= "left";
			$table_view["headers"][$j]["val"] 		= addslashes(t("Form ID"));
			
			$table_view["headers"][++$j]["width"] 	= "20%";
			$table_view["headers"][$j]["align"] 	= "left";
			$table_view["headers"][$j]["val"] 		= addslashes(t("XML Tag"));
			
			$table_view["headers"][++$j]["width"] 	= "18%";
			$table_view["headers"][$j]["align"] 	= "center";
			$table_view["headers"][$j]["val"] 		= addslashes(t("Start Position"));
			
			$table_view["headers"][++$j]["width"] 	= "18%";
			$table_view["headers"][$j]["align"] 	= "center";
			$table_view["headers"][$j]["val"] 		= addslashes(t("End Position"));
						
						
			$table_view["headers"][++$j]["width"] 	= "12%";
			$table_view["headers"][$j]["align"] 	= "center";
			$table_view["headers"][$j]["val"] 		= addslashes(t("Type"));
			
			$table_view["headers"][++$j]["width"] 	= "12%";
			$table_view["headers"][$j]["align"] 	= "left";
			$table_view["headers"][$j]["val"] 		= addslashes(t("Date Added"));
            //end Table Headers, with width,alignment//
            
            //Table Data//
            for($i = 0; $i< $table_view["total_rows"]; $i++)
            {
                $i_col = 0;
                $table_view["tablerows"][$i][$i_col++] = encrypt($info[$i]["i_id"]);  
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_form_title"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_xml_tag"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["i_field_pos_start"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["i_field_pos_end"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["e_record_type"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["dt_added"]?admin_date($info[$i]["dt_added"]):"N/A";
            } 
            //end Table Data//
            unset($i, $i_col, $start, $limit, $s_where); 
            
            //$this->data["table_view"] = $this->admin_showin_table($table_view,TRUE);
            $this->data['total_record'] = $table_view["total_db_records"];
            $this->data["table_view"] = $this->admin_showin_order_table($table_view,TRUE);
            
            //Creating List view for displaying//
            $this->data["search_action"] = $this->pathtoclass.$this->router->fetch_method();//used for search form action
            
            $this->render();          
            unset($table_view, $info);
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
        $this->data['heading'] = (t("Add Information"));
        $this->data['pathtoclass'] = $this->pathtoclass;
        $this->data['BREADCRUMB'] = array(addslashes(t('Add Information')));
        $this->data['mode'] = 'add';
        
        $form_id = $this->session->userdata('sess_form_id');
        $this->data['i_form_id'] = $form_id;
        
        if($_POST)
        {
            $posted = array();
            
			$posted["i_form_id"]        	= $this->input->post("i_form_id", true);
			$posted["e_record_type"]    	= $this->input->post("e_record_type");
			$posted["i_field_pos_start"]	= $this->input->post("i_field_pos_start", true);
			$posted["i_field_pos_end"]		= $this->input->post("i_field_pos_end", true);
			$posted["s_xml_tag"]			= $this->input->post("s_xml_tag", true);
			$posted["s_purpose_fileds"]		= $this->input->post("s_purpose_fileds", true);
			$posted["s_validation_rules"]	= $this->input->post("s_validation_rules", true);
            //$posted["i_status"]     		= $this->input->post("i_status");
            
            
			$this->form_validation->set_rules('i_form_id', addslashes(t('form ID')), 'required|xss_clean');
			$this->form_validation->set_rules('e_record_type', addslashes(t('record type')), 'required|xss_clean');
			$this->form_validation->set_rules('i_field_pos_start', addslashes(t('start position')), 'required|xss_clean');
			$this->form_validation->set_rules('i_field_pos_end', addslashes(t('end position')), 'required|xss_clean');
			//$this->form_validation->set_rules('i_field_pos_end', addslashes(t('length')), 'required|xss_clean');
            if($this->form_validation->run() == FALSE)//invalid
            {
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {
                $posted["dt_added"] = now();
                $i_newid = $this->acs_model->add_data($this->tbl, $posted);
                if($i_newid)//saved successfully
                {
                    set_success_msg($this->cls_msg["save_succ"]);
                    redirect($this->pathtoclass."show_list");
                }
                else//Not saved, show the form again
                {
                    set_error_msg($this->cls_msg["save_err"]);
                }
			}
        }
        //end Submitted Form//
        
        $this->render("form_details/add-edit");
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
        $this->data['heading'] = (t("Edit Information"));
        $this->data['pathtoclass'] = $this->pathtoclass;
        $this->data['BREADCRUMB'] = array(addslashes(t('Edit Information')));
        $this->data['mode'] = 'edit';        
        
        $form_id = $this->session->userdata('sess_form_id');
        $this->data['i_form_id'] = $form_id;
        
        if($_POST)
        {
            $posted = array();            
            $posted["h_id"]         		= $this->input->post("h_id", true);
            $posted["i_form_id"]        	= $this->input->post("i_form_id", true);
			$posted["e_record_type"]    	= $this->input->post("e_record_type");
			$posted["i_field_pos_start"]	= $this->input->post("i_field_pos_start", true);
			$posted["i_field_pos_end"]		= $this->input->post("i_field_pos_end", true);
			$posted["s_xml_tag"]			= $this->input->post("s_xml_tag", true);
			$posted["s_purpose_fileds"]		= $this->input->post("s_purpose_fileds", true);
			$posted["s_validation_rules"]	= $this->input->post("s_validation_rules", true);
            $posted["i_status"]     		= $this->input->post("i_status");
            
            
			$this->form_validation->set_rules('i_form_id', addslashes(t('form ID')), 'required|xss_clean');
			$this->form_validation->set_rules('e_record_type', addslashes(t('record type')), 'required|xss_clean');
			$this->form_validation->set_rules('i_field_pos_start', addslashes(t('start position')), 'required|xss_clean');
			$this->form_validation->set_rules('i_field_pos_end', addslashes(t('end position')), 'required|xss_clean');
			//$this->form_validation->set_rules('i_field_pos_end', addslashes(t('length')), 'required|xss_clean');
			
            if($this->form_validation->run() == FALSE)//invalid
            {
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {                
                $i_id = decrypt($posted["h_id"]);
                unset($posted["h_id"]);
                $i_aff = $this->acs_model->edit_data($this->tbl,$posted, array('i_id'=>$i_id));
                if($i_aff)//saved successfully
                {                    
                    set_success_msg($this->cls_msg["save_succ"]);
                    redirect($this->pathtoclass."show_list");
                }
                else//Not saved, show the form again
                {
                    set_error_msg($this->cls_msg["save_err"]);
                }
			}
        }//end Submitted Form//
        else
        {
            // Fetch all the data
            $tmp = $this->acs_model->fetch_data($this->tbl,array('i_id'=>decrypt($i_id)));
            $posted 				= $tmp[0];
            $posted['h_id'] 		= $i_id;
            $this->data['posted'] 	= $posted;
            $posted['h_mode'] 		= $this->data['mode'];
        }
        
        $this->render("form_details/add-edit");
    }

    /***
    * Shows details of a single record.
    * 
    * @param int $i_id, Primary key
    */
    public function view_detail($i_id = 0)
    {
			
			/*
			$doc = new DOMDocument(); 
			$doc->formatOutput = true;
			$doc->encoding = "utf-8";

			$r = $doc->createElement( "channel" ); 
			$doc->appendChild( $r ); 

			   //$i=0;		   
			
			//foreach( $rss_table as $rss ) 
			for ($i = 1; $i <= 8; ++$i) 
			{ 
				$b = $doc->createElement( "item" );
				
				$title = $doc->createElement( "title" ); 
				//$title->appendChild( $doc->createTextNode( $rss['title'] ) ); 
				$title->appendChild( $doc->createTextNode( "song$i.mp3" ) ); 
				$b->appendChild( $title ); 


				$description = $doc->createElement( "description" ); 
				$description->appendChild( $doc->createTextNode( "Track $i - Track Title" ) ); 
				$b->appendChild( $description );

				$link = $doc->createElement( "link" ); 
				$link->appendChild( $doc->createTextNode( "http://www.test.com" ) ); 
				$b->appendChild( $link );
				$r->appendChild( $b );
			}
			//echo $doc->saveXML();
			$doc->save(FCPATH."uploaded/xml/rssfeeds.xml") ;
			*/
			//--------------------------------
			
			$xml = new SimpleXMLElement('<xml/>');
			$transmitter = $xml->addChild('Payer');
			$transmitter->addAttribute('PayerId',"1");			
			$transmitter->addChild('TIN','526464659');
			$transmitter->addChild('TypeOfTIN','E');
			$payer = $transmitter->addChild('PayerCompany');
			$payer->addChild('Name1','LENDING TREE MORTGAGE COMPANY');
			$payer->addChild('Name2','LENDING TREE OF ILLINOIS');
			$payer->addChild('City','ROCKFORD');
			$payer->addChild('USState','IL');
			$payer->addChild('USZipCode','61104');
			$payer->addChild('Phone','8152264352');
			
			$payee = $transmitter->addChild('Payee');
			$payee->addAttribute('PayeeId',"1");	
			
			for ($i = 1; $i <= 8; ++$i) {
				//$track = $payee->addChild('track');
				//$track->addChild('path', "song$i.mp3");
				//$track->addAttribute('id',"update $i");
				//$track->addChild('title', "Track $i - Track Title");
				$tin = $i*11111111;
				$acn = $i*1111111111;
				//$track = $payee->addChild('TIN',"$i");
				$payee->addChild('TIN',"$i");
				$payee->addChild('TypeOfTIN', "S");
				$payee->addChild('NameLine2', "Name $i");
				$payee->addChild('AssociationName', "Name $i");
				$payee->addChild('Addr1', "Street $i");
				
				$payeeforms = $payee->addChild('PayeeForms');
				$form = $payeeforms->addChild('Form1099A');
				$form->addAttribute('Occurrence',"$i");
				$form->addChild('AcctNumber', "$acn");
			}

			Header('Content-type: text/xml');
			//print($xml->asXML());
			$xml->asXML(FCPATH.'uploaded/xml/test.xml');
			system('chmod 777 '.FCPATH.'uploaded/xml/test.xml');
			
			//$this->load->helper('download');
			//force_download(FCPATH.'uploaded/xml/test.xml', $xml);
			
			header('Content-type: text/xml');
			// It will be called downloaded.pdf
			header('Content-Disposition: attachment; filename="1099A.xml"');
			// The PDF source is in original.pdf
			readfile(FCPATH.'uploaded/xml/test.xml');
			exit;
			
			//-------------------------------------- 
			
			/*
			// Generate XML Dynamically
			$domtree = new DOMDocument('1.0', 'UTF-8');

			/// create the root element of the xml tree 
			$xmlRoot = $domtree->createElement("xml");
			/// append it to the document created 
			$xmlRoot = $domtree->appendChild($xmlRoot);

			$currentTrack = $domtree->createElement("track");
			//$currentTrack = $domtree->track->addAttribute('id', 'bar');
			$currentTrack = $xmlRoot->appendChild($currentTrack);

			/// you should enclose the following two lines in a cicle 
			$currentTrack->appendChild($domtree->createElement('path','song1.mp3'));
			$currentTrack->appendChild($domtree->createElement('title','title of song1.mp3'));

			$currentTrack->appendChild($domtree->createElement('path','song2.mp3'));
			$currentTrack->appendChild($domtree->createElement('title','title of song2.mp3'));

			/// get the xml printed 
			//echo $domtree->saveXML();
			$domtree->save(FCPATH.'uploaded/xml/xmlfile.xml');
			//$domtree->save('xml/xmlfile.xml');
			*/
			
            /*if(!empty($i_id))
            {
                $this->data["info"] = $this->acs_model->fetch_data($this->tbl,array('i_id'=>$i_id));
            }
            $this->load->view('web_master/form_details/show_detail.tpl.php', $this->data); */
              
    }

    /***
    * Method to Delete information
    * This have no interface but db operation 
    * will be done here.
    * 
    * On Success redirect to the showList interface else display error in showList interface. 
    * @param int $i_id, id of the record to be modified.
    */  
    public function ajax_remove_information()
    {
        try
        {
            $i_id = decrypt($this->input->post("temp_id"));
            echo $this->acs_model->edit_data($this->tbl, array('e_deleted'=> 'Yes'), array('i_id' => $i_id)) ? 'ok':'error';
            #echo $this->acs_model->delete_data($this->tbl, array('i_id'=>$i_id)) ? 'ok' : 'error';
            unset($i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	
    // change sorting order
    public function ajax_change_order()
    {
        try
        {
            $id_arr = $_POST['tableSort'];
            unset($id_arr[0]);
            $this->acs_model->change_sorting_order($id_arr,$this->tbl);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }    
    }
    
   

    // Generate a method for drop down
    protected function generate_drodown($table, $field, $s_id = '', $return_type = 'html')
    {
        $tmp = $this->acs_model->fetch_data($table, '',"i_id, $field");
        if(!empty($tmp))
        {
            if($return_type == 'array')
                $value[0] = 'Select';
            else
                $value = '<option value="">Select</option>';
            foreach($tmp as $v)
            {
                if($return_type == 'array')
                    $value[$v['i_id']] = $v[$field];
                else
                {
                    $selected = $s_id == $v['i_id'] ? 'selected' : '';
                    $value .= '<option value="'.$v['i_id'].'" '.$selected.'>'.$v[$field].'</option>';
                }
            }
        }
        unset($tmp, $table, $field, $s_id, $return_type);
        return $value;
    }

	public function __destruct(){}
}
