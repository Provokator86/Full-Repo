<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class newsletter extends MY_Controller
{
	function __construct()
    {
		parent::__construct();
		$this->check_user_page_access('registered');
		$this->data['title'] = 'Admin Newsletter';
		$this->load->model('newsletter_model');
		$this->load->model('users_model');
		$this->menu_id = 4;
	}

	function index($order_name='add_date',$order_type='desc',$page=0)
    {
        $this->load->library('generat_calender');
        $sessArrTmp = array();
        
        if($this->input->post('go'))
        {
            $sessArrTmp['src_name']=trim(htmlentities($this->input->post('name'),ENT_QUOTES, 'utf-8'));
            $sessArrTmp['src_subject']=trim(htmlentities($this->input->post('subject'),ENT_QUOTES, 'utf-8'));
            $sessArrTmp['src_from_date']=$this->input->post('from_date');
            $sessArrTmp['src_to_date']=$this->input->post('to_date');
			$page = 0;
        }
        else
        {
            $sessArrTmp['src_name']=$this->get_session_data('src_name');
            $sessArrTmp['src_subject']=$this->get_session_data('src_subject');
            $sessArrTmp['src_from_date']=$this->get_session_data('src_from_date');
            $sessArrTmp['src_to_date']=$this->get_session_data('src_to_date');
        }
        $dateFrom	= $this->generat_calender->calender('from_date',$sessArrTmp['src_from_date']);
        $dateTo	= $this->generat_calender->calender('to_date',($sessArrTmp['src_to_date'])?$sessArrTmp['src_to_date']:add_date());
        
        $this->data['txtArray']   = array("name"=>"Name","subject"=>"Subject");
        $this->data['txtValue']   = array($sessArrTmp['src_name'],$sessArrTmp['src_subject']);
        $this->data['dateArray']   = array($dateFrom,$dateTo);
        $this->data['dateCaption']   = array("Date From","To");
        $this->data['newsletter']=$this->newsletter_model->get_newsletter($this->admin_page_limit,($page)?$page:0,-1,$sessArrTmp['src_name'], $sessArrTmp['src_subject'],$sessArrTmp['src_from_date'],$sessArrTmp['src_to_date'],$order_name,$order_type);
        $totRow = $this->newsletter_model->get_newsletter_count(-1,$sessArrTmp['src_name'],$sessArrTmp['src_subject'],$sessArrTmp['src_from_date'],$sessArrTmp['src_to_date']);
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        if(!$this->data['newsletter'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/newsletter/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/newsletter/index/'.$order_name.'/'.$order_type,
                    'total_row'=>$totRow,
                    'per_page'=>$this->admin_page_limit,
                    'uri_segment'=>6,
                    'next_link'=>'Next&gt;',
                    'prev_link'=>'&lt;Prev'
                )
            );

        $this->data['order_name']=$order_name;
        $this->data['order_type']=$order_type;
        $this->data['page']=$page;
		
        $sessArrTmp['admin_newsletter_url']=base_url().'admin/newsletter/index/'.$order_name.'/'.$order_type.'/'.$page;
        //$this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->session->set_userdata(array('newsletter_session'=>''));
        $this->add_js(array('ajax_helper','jasons_date_input_calendar/calendarDateInput'));
        $this->set_include_files(array('common/admin_menu','newsletter/newsletter'));
		$this->render();
	}
	
	function add_newsletter($nid = '')
	{
		$this->session->unset_userdata('newsletter_session');
		$newsletter = '';
		$sessArrTmp = $this->session->userdata('newsletter_session');
		if(isset($nid) && $nid != "")
		{
			$sessArrTmp['nid'] = $nid;
			$this->session->set_userdata(array('newsletter_session' => $sessArrTmp));
			$newsletter = $this->newsletter_model->get_newsletter(-1, 0, $nid);
		}

		$campaign_name = $sessArrTmp['txtcampaign_name'];
		if($campaign_name && $campaign_name != '')
			$this->data['campaign_name'] = $campaign_name;
		else
			$this->data['campaign_name'] = ($newsletter) ? $newsletter[0]['campaign_name'] : '';

		$subject = $sessArrTmp['txtSubject'];
		if($subject && $subject != '')
			$this->data['subject'] = $subject;
		else
			$this->data['subject'] = ($newsletter) ? $newsletter[0]['subject'] : '';

		$from_name = $sessArrTmp['txtcampaign_fromname'];
		if($from_name && $from_name != '')
			$this->data['from_name'] = $from_name;
		else
			$this->data['from_name'] = ($newsletter) ? $newsletter[0]['from_name'] : '';

		$this->data['email'] = $this->site_settings_model->get_site_settings('mail_from_email');
		$this->data['replies_email'] = $this->site_settings_model->get_site_settings('mail_replay_email');
		$this->data['nid'] = $nid;

		$this->set_include_files(array('common/admin_menu', 'newsletter/add_newsletter'));
		$this->render();
	}
	
	function newsletter_create2($nid = '')
	{
		$this->data['nid']= $nid;
		$sessArrTmp = $this->session->userdata('newsletter_session');

		if($sessArrTmp["nid"] != "")
		{
			$newsletter = $this->newsletter_model->get_newsletter(-1, 0, $sessArrTmp["nid"]);
			$this->data['textytpe'] = $newsletter[0]["mail_type"];
		}

		if($sessArrTmp["client"] == "")
		{
			if($this->input->post("client") != "")
			{
				$sep = "";
				foreach($this->input->post("client") as $client)
				{
					$sessArrTmp["client"] .= $sep.$client;
					$sep = ',';
				}
			}
		}
		
		if($this->input->post("mode") == "save")
		{
			$sessArrTmp["mailtype"] = $this->input->post("mailtype");
			$sessArrTmp["txtSubject"] = $this->input->post("txtSubject");
			$sessArrTmp["txtcampaign_name"] = $this->input->post("txtcampaign_name");
			$sessArrTmp["txtcampaign_fromname"] = $this->input->post("txtcampaign_fromname");
			$sessArrTmp["txtEmail"] = $this->input->post("txtEmail");
			$sessArrTmp["txtreplyEmail"] = $this->input->post("txtreplyEmail");
			$sessArrTmp["newsletter_image"] = $this->input->post("newsletter_image");
		}
		
		if($this->input->post("mailtype") != $sessArrTmp["mailtype"])
			$sessArrTmp["mailtype"] = $this->input->post("mailtype");
		$this->session->set_userdata(array('newsletter_session' => $sessArrTmp));

		if($this->input->post('Btnnext'))
		{
			if($this->input->post("mailtype") == 0)
			{
				header("location: ".base_url()."admin/newsletter/newsletter_create3/$nid");
				exit(0);
			}
			else if($this->input->post("mailtype") == 1)
			{
				header("location: ".base_url()."admin/newsletter/newsletter_create3a/$nid");
				exit(0);
			}
		}

		if($this->input->post('prev'))
		{
			header("location: ".base_url()."admin/newsletter/add_newsletter/$nid");
			exit(0);
		}

		$this->data['newsletter_session'] = $sessArrTmp;
		$this->set_include_files(array('common/admin_menu', 'newsletter/newsletter_create2'));
		$this->render();
	}
	
	function newsletter_create3($nid='')
	{
		$this->data['nid']	= $nid;
		$sessArrTmp = $this->session->userdata('newsletter_session');
        if($sessArrTmp["nid"]!="")
        {
            $newsletter =$this->newsletter_model->get_newsletter(-1,0,$sessArrTmp["nid"]);
            $sessArrTmp["htmltype"]=$newsletter[0]["htmltype"];
        }

        if($this->input->post('Btnnext'))
        {
           if($this->input->post('htmltype')==1)
           {
                if(!isset($sessArrTmp["htmltype"]))
                    $sessArrTmp["htmltype"]=$this->input->post("htmltype");
                else if($this->input->post("htmltype")!=$sessArrTmp["htmltype"])
                    $sessArrTmp["htmltype"]=$this->input->post("htmltype");
                $this->session->set_userdata(array('newsletter_session'=>$sessArrTmp));
                header("location: ".base_url()."admin/newsletter/newsletter_create4/$nid");
                exit(0);
           }
           else if($this->input->post('htmltype')==2)
           {
                if(!isset($sessArrTmp["htmltype"]))
                    $sessArrTmp["htmltype"]=$this->input->post("htmltype");
                else if($this->input->post("htmltype")!=$sessArrTmp["htmltype"])
                    $sessArrTmp["htmltype"]=$this->input->post("htmltype");
                $this->session->set_userdata(array('newsletter_session'=>$sessArrTmp));
                header("location: ".base_url()."admin/newsletter/newsletter_create4a/$nid");
                exit(0);
           }
        }
        if($this->input->post('prev'))
        {
            if(!isset($sessArrTmp["htmltype"]))
                $sessArrTmp["htmltype"]=$this->input->post("htmltype");
            $this->session->set_userdata(array('newsletter_session'=>$sessArrTmp));
            header("location: ".base_url()."admin/newsletter/newsletter_create2/$nid");
            exit(0);
        }
        $this->data['newsletter_session']=$sessArrTmp;
    	$this->set_include_files(array('common/admin_menu','newsletter/newsletter_create3'));
		$this->render();
	}
	
	function newsletter_create4($nid='')
	{
		$this->data['nid']	= $nid;
		$sessArrTmp = $this->session->userdata('newsletter_session');
        if($sessArrTmp["nid"]!="")
        {
            $newsletter =$this->newsletter_model->get_newsletter(-1,0,$sessArrTmp["nid"]);
            $sessArrTmp["txturl"]=$newsletter[0]["website_link"];
        }
        if($this->input->post('Btnnext'))
        {
             if($sessArrTmp['txturl']!=$this->input->post("txturl"))
                $sessArrTmp["txturl"]=$this->input->post("txturl");
             $this->session->set_userdata(array('newsletter_session'=>$sessArrTmp));
             header("location: ".base_url()."admin/newsletter/newsletter_create5/$nid");
            exit(0);
        }
        if($this->input->post('prev'))
        {
            if(!isset($sessArrTmp["txturl"]))
                $sessArrTmp["txturl"]=$this->input->post("txturl");
            $this->session->set_userdata(array('newsletter_session'=>$sessArrTmp));
            header("location: ".base_url()."admin/newsletter/newsletter_create3/$nid");
            exit(0);
        }
        $this->data['newsletter_session']=$sessArrTmp;
    	$this->set_include_files(array('common/admin_menu','newsletter/newsletter_create4'));
		$this->render();
	}
	
	function newsletter_create5($nid='')
	{
		$this->data['nid']	= $nid;
		$sessArrTmp = $this->session->userdata('newsletter_session');
//        if($sessArrTmp["nid"]!="")
//        {
//           	$newsletter =$this->newsletter_model->get_newsletter(-1,0,$sessArrTmp["nid"]);
//            $sub=$newsletter[0]["newsletter_sub"];
//            $bd=$newsletter[0]["newsletter_body"];
//        }

        if($this->input->post('Btnnext'))
        {
            header("location: ".base_url()."admin/newsletter/newsletter_snapshot/$nid");
            exit(0);
        }
        $this->data['newsletter_session']=$sessArrTmp;
    	$this->set_include_files(array('common/admin_menu','newsletter/newsletter_create5'));
		$this->render();
	}
	
	function newsletter_create5b($nid='')
	{
		$this->data['nid']	= $nid;
		$sessArrTmp = $this->session->userdata('newsletter_session');
//        if($sessArrTmp["nid"]!="")
//        {
//             $newsletter =$this->adminNewsletter->get_newsletter($id);
//            $sub=$newsletter[0]["newsletter_sub"];
//            $bd=$newsletter[0]["newsletter_body"];
//        }

        if($sessArrTmp["txturl"]!="")
        {
        	$content=file_get_contents($sessArrTmp['txturl']);
			$pos=strrpos($sessArrTmp['txturl'],"/");
			$sitelink=substr($sessArrTmp['txturl'],0,$pos);
			$pos_imglink=strpos($content,'src="http://');
			if($pos_imglink==0)
				$content=str_replace('src="','src="'.$sitelink.'/',$content);
			$content=str_replace('<param name="movie" value="','<param name="movie" value="'.$sitelink.'/',$content);
			$content=str_replace('<link href="','<link href="'.$sitelink.'/',$content);
            $sessArrTmp['website_content']=$content;
        }
        $this->session->set_userdata(array('newsletter_session'=>$sessArrTmp));
        if($this->input->post('Btnnext'))
        {
            header("location: ".base_url()."admin/newsletter/newsletter_user/$nid");
            exit(0);
        }
        $this->data['newsletter_session']=$sessArrTmp;
    	$this->set_include_files(array('common/admin_menu','newsletter/newsletter_create5b'));
		$this->render();
	}
	
	function newletter_campaign_preview($nid='')
	{
		$this->data['nid']	= $nid;
		$sessArrTmp = $this->session->userdata('newsletter_session');
	 	if(isset($sessArrTmp['file_upload_path']))
        	@include("{$sessArrTmp['file_upload_path']}");
       	if(isset($sessArrTmp["emailbody_plain"]))
        	$this->data['preview']	= $sessArrTmp["emailbody_plain"];
        if($sessArrTmp['txturl']!="")
        {
			$content=file_get_contents($sessArrTmp['txturl']);
			$pos=strrpos($sessArrTmp['txturl'],"/");
			$sitelink=substr($sessArrTmp['txturl'],0,$pos);
			$pos_imglink=strpos($content,'src="http://');
			if($pos_imglink==0)
				$content=str_replace('src="','src="'.$sitelink.'/',$content);
			$content=str_replace('<param name="movie" value="','<param name="movie" value="'.$sitelink.'/',$content);
			$content=str_replace('<link href="','<link href="'.$sitelink.'/',$content);
			$this->data['preview']	= $content;
		}
		$this->load->view("admin/newsletter/newletter_campaign_preview.tpl.php", $this->data);
	}
	
	function newsletter_user($nid = '')
	{
		$this->load->model('users_model');
		$this->data['nid'] = $nid;
		$sessArrTmp = $this->session->userdata('newsletter_session');

		if($this->input->post('Btnnext'))
		{
			header("location: ".base_url()."admin/newsletter/newsletter_schedule_delivary/$nid");
			exit(0);
		}

		$this->data['user_type_list'] = makeOption($this->users_model->user_type);

		//$this->data['newsUser'] = $this->newsletter_model->get_newsletter_user();
		$this->data['newsUser'] = $this->users_model->get_invite_user_list(-1, 0, array('email_opt_in' => 'Y', 'invite_accepted' => 'Y'));

		$this->data['newsletter_session'] = $sessArrTmp;
		$this->add_js(array('jquery.blockUI', 'thickbox', 'jquery.form', 'json'));
		$this->add_css(array('thickbox'));
		$this->set_include_files(array('common/admin_menu', 'newsletter/newsletter_user'));
		$this->render();
	}
	
	function newsletter_snapshot($nid='')
	{
		$this->data['nid']	= $nid;
		$sessArrTmp = $this->session->userdata('newsletter_session');

//        if($nid!="")
//        {
//            $sessArrTmp['nid']=$nid;
//            $newsletter =$newsletter =$this->newsletter_model->get_newsletter(-1,0,$sessArrTmp["nid"]);
//        }
        if($this->input->post('Btnnext'))
        {
			
            header("location: ".base_url()."admin/newsletter/newsletter_schedule_delivary/$nid");
            exit(0);
        }
        else
		//elseif($this->input->post('bttnUser',true))
        {
            $sessArrTmp['recevier_type']=$this->input->post('recevier_type');
            $sessArrTmp['nuser_id']='';
            $sessArrTmp['member_list']='';
			$sessArrTmp['nuser_id']=$this->input->post('user_id');
            /*if($this->input->post('recevier_type')==2)
                $sessArrTmp['nuser_id']=$this->input->post('user_id');
            elseif($this->input->post('recevier_type')==3)
                $sessArrTmp['member_list']=$this->input->post('select_search_id');*/
        }
        if($sessArrTmp['nuser_id'])
            $this->data['totalmember'] = count($sessArrTmp['nuser_id']);
        else
        {
            $rcpUsr   = $this->newsletter_model->get_newsletter_user();
            $this->data['totalmember'] = count($rcpUsr);
        }
		
		//var_dump($sessArrTmp);
        $this->session->set_userdata(array('newsletter_session'=>$sessArrTmp));
        $this->data['newsletter_session']=$sessArrTmp;
        $this->set_include_files(array('common/admin_menu','newsletter/newsletter_snapshot'));
		$this->render();
	}
	
	function newsletter_schedule_delivary($nid='')
	{
		$this->data['nid']	= $nid;
		$sessArrTmp = $this->session->userdata('newsletter_session');
//        if($nid!="")
//        {
//            $_SESSION['nid']=$_REQUEST["nid"];
//            $id=$_REQUEST["nid"];
//            $newsletter =$this->adminNewsletter->get_newsletter($id);
//        }
        if($this->input->post('Btnnext'))
        {
              if($this->input->post("send_type")==2)
              {
                if($sessArrTmp["send_date"]=="" && $sessArrTmp["sent_time"]=="" && $sessArrTmp["time_zone"]=="")
                {
                    $send_date=$this->input->post('year')."-".$this->input->post('month')."-".$this->input->post('day');
                    $send_time=$this->input->post('hour').":".$this->input->post('min');
                    $sessArrTmp["send_date"]=$send_date;
                    //$sessArrTmp["add_date"]=date("Y-m-d");
					$sessArrTmp["add_date"]=time();
                    $sessArrTmp["sent_time"]=$send_time;
                    $sessArrTmp["time_zone"]=$this->input->post("timezone");
                    $sessArrTmp['status']=0;
                    $sessArrTmp['time_status']=$this->input->post('timestatus');
                }
                $this->session->set_userdata(array('newsletter_session'=>$sessArrTmp));
                header("location: ".base_url()."admin/newsletter/newsletter_update/$nid");
                exit(0);
            }
            else if($this->input->post("send_type")==1)
              {
                if($sessArrTmp["sent_time"]=="")
                {
                    $sessArrTmp["send_date"]=date("Y-m-d");
                    //$sessArrTmp["add_date"]=date("Y-m-d");
					$sessArrTmp["add_date"]=time();
                    $sessArrTmp['status']=1;
                }
				
                $this->session->set_userdata(array('newsletter_session'=>$sessArrTmp));
                header("location: ".base_url()."admin/newsletter/newsletter_update/$nid");
                exit(0);
            }
        }
        elseif($this->input->post('prev'))
        {
            header("location: ".base_url()."admin/newsletter/newsletter_snapshot/$nid");
            exit(0);
        }
        if(isset($sessArrTmp['nid']))
        {
        	$newsletter =$newsletter =$newsletter =$this->newsletter_model->get_newsletter(-1,0,$sessArrTmp["nid"]);;
			$sessArrTmp["month"]=substr($newsletter[0]["sent_date"],5,2);
            $sessArrTmp["year"]=substr($newsletter[0]["sent_date"],0,4);
            $sessArrTmp["day"]=substr($newsletter[0]["sent_date"],8,2);
            $sessArrTmp["timestatus"]=$newsletter[0]["time_status"];
            $sessArrTmp["hour"]=substr($newsletter[0]["sent_time"],0,2);
            $sessArrTmp["min"]=substr($newsletter[0]["sent_time"],3,2);
            $sessArrTmp['timezone']=$newsletter[0]["time_zone"];
            $sessArrTmp["send_type"]=$newsletter[0]["status"];
      	}
		if(isset($sessArrTmp["txtEmail"]))
        {
            $sessArrTmp['send_confermation_email2']=$sessArrTmp["txtEmail"];
            $sessArrTmp['send_confermation_email']=$sessArrTmp["txtEmail"];
        }
		$this->session->set_userdata(array('newsletter_session'=>$sessArrTmp));
        $this->data['newsletter_session']=$sessArrTmp;
        $this->set_include_files(array('common/admin_menu','newsletter/newsletter_schedule_delivary'));
		$this->render();
	}
	
	function newsletter_create4a($nid='')
	{
		$dir_name = BASEPATH.'../images/uploaded/newsletter/';
		$this->data['nid']	= $nid;
		$sessArrTmp = $this->session->userdata('newsletter_session');
        if($sessArrTmp["nid"]!="")
        {
            $newsletter =$this->newsletter_model->get_newsletter(-1,0,$sessArrTmp["nid"]);
            $html_file=$newsletter[0]["file_path_link"];
            $this->data['html_file']	= $html_file;
        }
        if($this->input->post('Btnnext'))
        {
            if(!isset($html_file)){
                $upload_dir=$dir_name.mktime();
                if($_FILES['import_file']['name']!="")
                {
                    $pos=strrpos($_FILES['import_file']['name'],'.');
                    $ext=substr($_FILES['import_file']['name'],$pos+1);
                    if($ext=="html" || $ext=="htm")
                    {
                        $upload_file_name=$upload_dir.basename($_FILES['import_file']['name']);
						
                        if(move_uploaded_file($_FILES['import_file']['tmp_name'],$upload_file_name))
                        {
                            $sessArrTmp['file_upload_path']=$upload_file_name;
                            $this->session->set_userdata(array('newsletter_session'=>$sessArrTmp));
                            header("location: ".base_url()."admin/newsletter/newsletter_create5a/$nid");
                            exit(0);
                        }
                        else
                        {
                        	$this->message_type ='err';
                    		$this->message  ='Your file can not be upload..';
                        }
                    }
                    else
                    {
                    	$this->message_type ='err';
                    	$this->message  ='File type is mismatch. please select only .html or .htm file...';
                    }
                }
                else
                {
                	$this->message_type ='err';
                    $this->message  ='Please browse any html file.It is can not be blank...';
                }
            }
            else
            {
                $sessArrTmp['file_upload_path']=$html_file;
                $this->session->set_userdata(array('newsletter_session'=>$sessArrTmp));
                header("location: ".base_url()."admin/newsletter/newsletter_create5a/$nid");
                exit(0);
            }
        }
        elseif($this->input->post('prev'))
        {
            header("location: ".base_url()."admin/newsletter/newsletter_create3/$nid");
            exit(0);
        }
        $this->session->set_userdata(array('newsletter_session'=>$sessArrTmp));
        $this->data['newsletter_session']=$sessArrTmp;
        $this->set_include_files(array('common/admin_menu','newsletter/newsletter_create4a'));
		$this->render();
	}
	
	function newsletter_create5a($nid = '')
	{
		$this->data['nid'] = $nid;
		$sessArrTmp = $this->session->userdata('newsletter_session');

		/*if($sessArrTmp["nid"] != "")
		{
			$newsletter = $this->adminNewsletter->get_newsletter($id);
			$sub = $newsletter[0]["newsletter_sub"];
			$bd = $newsletter[0]["newsletter_body"];
		}*/

		if($this->input->post('Btnnext'))
		{
			header("location: ".base_url()."admin/newsletter/newsletter_user/$nid");
			exit(0);
		}

		$this->session->set_userdata(array('newsletter_session' => $sessArrTmp));
		$this->data['newsletter_session'] = $sessArrTmp;
		$this->set_include_files(array('common/admin_menu', 'newsletter/newsletter_create5a'));
		$this->render();
	}
	
	function newsletter_create3a($nid = '')
	{
		$this->data['nid'] = $nid;
		$sessArrTmp = $this->session->userdata('newsletter_session');

		if($_SESSION["nid"] != "")
		{
			$newsletter = $this->newsletter_model->get_newsletter(-1, 0, $sessArrTmp["nid"]);
			$this->data['bd'] = $newsletter[0]["newsletter_body"];
		}

		if($this->input->post('Btnnext'))
		{
			$sessArrTmp["emailbody_plain"] = $this->input->post("emailbody_plain");
			$this->session->set_userdata(array('newsletter_session' => $sessArrTmp));
			header("location: ".base_url()."admin/newsletter/newsletter_create5a/$nid");
			exit(0);
		}

		if($this->input->post('prev'))
		{
			$sessArrTmp["emailbody_plain"] = $this->input->post("emailbody_plain");
			$this->session->set_userdata(array('newsletter_session' => $sessArrTmp));
			header("location: ".base_url()."admin/newsletter/newsletter_create2/$nid");
			exit(0);
		}

		$this->session->set_userdata(array('newsletter_session' => $sessArrTmp));
		$this->data['newsletter_session'] = $sessArrTmp;
		$this->add_js(array('tinymce/jscripts/tiny_mce/tiny_mce', 'tinymce_load'));
		$this->set_include_files(array('common/admin_menu', 'newsletter/newsletter_create3a'));
		$this->render();
	}
	
	function newsletter_update($nid='')
	{
		$config	= array();
		$this->data['nid']	= $nid;
		$sessArrTmp = $this->session->userdata('newsletter_session');

		$config['site_name']    =$this->site_settings_model->get_site_settings('site_name');
		if(1==$sessArrTmp['status'])
            $sendmail=1;
        $arr	= array('subject'=>htmlspecialchars($sessArrTmp["txtSubject"], ENT_QUOTES, 'utf-8'),
        				'body'=>htmlspecialchars($sessArrTmp["emailbody_plain"], ENT_QUOTES, 'utf-8'),
        				'add_date'=>htmlspecialchars($sessArrTmp["add_date"], ENT_QUOTES, 'utf-8'),
        				'sent_date'=>htmlspecialchars($sessArrTmp["send_date"], ENT_QUOTES, 'utf-8'),
        				'status'=>htmlspecialchars($sessArrTmp["status"], ENT_QUOTES, 'utf-8'),
        				'mail_type'=>htmlspecialchars($sessArrTmp["mailtype"], ENT_QUOTES, 'utf-8'),
        				'campaign_name'=>htmlspecialchars($sessArrTmp["txtcampaign_name"], ENT_QUOTES, 'utf-8'),
        				'from_name'=>htmlspecialchars($sessArrTmp["txtcampaign_fromname"], ENT_QUOTES, 'utf-8'),
        				'email'=>htmlspecialchars($sessArrTmp["txtEmail"], ENT_QUOTES, 'utf-8'),
        				'replies_email'=>htmlspecialchars($sessArrTmp["txtreplyEmail"], ENT_QUOTES, 'utf-8'),
        				'file_path_link'=>htmlspecialchars($sessArrTmp["file_upload_path"], ENT_QUOTES, 'utf-8'),
        				'newsletter_image'=>htmlspecialchars($sessArrTmp["newsletter_image"], ENT_QUOTES, 'utf-8'),
        				'other_website_content'=>htmlspecialchars($sessArrTmp["website_content"], ENT_QUOTES, 'utf-8'),
        				'sent_time'=>htmlspecialchars($sessArrTmp["sent_time"], ENT_QUOTES, 'utf-8'),
        				'time_zone'=>htmlspecialchars($sessArrTmp["time_zone"], ENT_QUOTES, 'utf-8'),
        				'website_link'=>htmlspecialchars($sessArrTmp["txturl"], ENT_QUOTES, 'utf-8'),
        				'time_status'=>htmlspecialchars($sessArrTmp["time_status"], ENT_QUOTES, 'utf-8'),
        				'htmltype'=>htmlspecialchars($sessArrTmp["htmltype"], ENT_QUOTES, 'utf-8')
        );
						
        $last_newsletter_id= $this->newsletter_model->set_newsletter_update($arr,($nid)?$nid:-1);
    	//var_dump($sessArrTmp);
        $sent_count=0;
        if($sendmail==1)
            $sent_count= $this->newsletter_model->set_send_newsletter_mail($last_newsletter_id,$sessArrTmp,$config);
        
       	$this->newsletter_model->set_newsletter_update(array('sent_count'=>$sent_count),$last_newsletter_id);
        $this->session->set_userdata(array('newsletter_session'=>''));
        $this->session->set_userdata(array('message'=>'Newsletter posted successfully..','message_type'=>'succ'));
        header("location: ".base_url()."admin/newsletter/newsletter");
        exit(0);
	}
	
	function view_pending_newsletter($id=-1)
    {
        if($id!="")
            $newsletter =$this->newsletter_model->get_newsletter(-1,0,$id);
        else
        {
            header("location: ".base_url().'admin/newsletter');
            exit(0);
        }
		//var_dump($newsletter);
       	if($newsletter[0]['file_path_link']!="")
			$body=file_get_contents($newsletter[0]['file_path_link']);
		else if($newsletter[0]['other_website_content']!="")
		{
			$content=stripslashes($newsletter[0]['other_website_content']);
			$pos=strrpos($newsletter[0]['website_link'],"/");
			$sitelink=substr($newsletter[0]['website_link'],0,$pos);
			$pos_imglink=strpos($content,'src="');
			if($pos_imglink==0)
				$content=str_replace('src="','src="'.$sitelink.'/',$content);
			$content=str_replace('<param name="movie" value="','<param name="movie" value="'.$sitelink.'/',$content);
			$content=str_replace('<link href="','<link href="'.$sitelink.'/',$content);
			$body=$content;
		}
		else
		{
			$content=html_entity_decode( stripslashes($newsletter[0]['body']));
			$pos=strrpos($newsletter[0]['website_link'],"/");
			$sitelink=substr($newsletter[0]['website_link'],0,$pos);
			$pos_imglink=strpos($content,'src="http://');
			if($pos_imglink==0)
				$content=str_replace('src="','src="'.$sitelink.'/',$content);
			$content=str_replace('<param name="movie" value="','<param name="movie" value="'.$sitelink.'/',$content);
			$content=str_replace('<link href="','<link href="'.$sitelink.'/',$content);
			$body=$content;
		}
		$this->data['body']=$body;
        $this->set_include_files(array('common/admin_menu','newsletter/view_pending_newsletter'));
		$this->render();
	}

	function newletter_delete($id=-1)
	{
		if($this->newsletter_model->set_delete_newsletter($id))
        	$this->session->set_userdata(array('message'=>'Newsletter deleted successfully..','message_type'=>'succ'));
        else
        	$this->session->set_userdata(array('message'=>'Unable to delete newsletter..','message_type'=>'err'));
        header("Location: ".base_url().'admin/newsletter');
	}
	
	function resend_newsletter($id=-1)
	{
        if(!$id || !is_numeric($id))
        {
            header("location: ".base_url().'admin/newsletter');
            exit(0);
        }
        $config	= array();
		$config['site_name']    =$this->site_settings_model->get_site_settings('site_name');
        $newsletter =$newsletter =$this->newsletter_model->get_newsletter(-1,0,$id);
        $arr	= array();
        //$arr['body']=$newsletter[0]["newsletter_body"];
		$arr['body']=html_entity_decode( $newsletter[0]["body"]);
        $arr['emailbody_plain']	= $newsletter[0]["emailbody_plain"];
        $arr['file_upload_path']=$newsletter[0]['file_path_link'];
        $arr['txturl']=$newsletter[0]["website_link"];
        $arr['txtcampaign_fromname']=$newsletter[0]['campaign_name'];
        $arr['txtEmail']=$newsletter[0]['email'];
        $arr['txtSubject']=$newsletter[0]["newsletter_sub"];
        $arr['recevier_type']=2;
        $tmp	= $this->newsletter_model->get_newsletter_old_user($id);
        foreach ($tmp as $key=>$value)
        	$arr['nuser_id'][$key]	= $value['email']; 
        if($this->newsletter_model->set_send_newsletter_mail($id,$arr,$config))
        	$this->session->set_userdata(array('message'=>'Newsletter resend successfully..','message_type'=>'succ'));
        else
        	$this->session->set_userdata(array('message'=>'Unable to resend newsletter..','message_type'=>'err'));
        header("Location: ".base_url().'admin/newsletter');
	}
	
	function newletter_publiched($id=-1)
	{
		if(!$id || !is_numeric($id))
        {
            header("location: ".base_url().'admin/newsletter');
            exit(0);
        }
		if($this->newsletter_model->set_publish_newsletter($id))
        	$this->session->set_userdata(array('message'=>'Newsletter publish status changed successfully..','message_type'=>'succ'));
        else
        	$this->session->set_userdata(array('message'=>'Unable to change newsletter publiched status..','message_type'=>'err'));
        header("Location: ".base_url().'admin/newsletter');
	}
	
	function newsletter_report($id=-1,$email='')
    {
        ob_implicit_flush(TRUE);
        // keep running after browser closes connection
        @ignore_user_abort(true);
        sendGIF();
        // Browser is now gone...
        // Switch off implicit flush again - we don't want to send any more output
        ob_implicit_flush(FALSE);
        // Catch any possible output (e.g. errors)
        // - probably not needed but better safe...
//        $rand=mktime();
        if($id)
        	$this->newsletter_model->set_update_open_count($_REQUEST["id"]);
    }
    
    function testnewsletter($url='')
    {
    	$url	= base64_decode($url);
		if ($fp = fopen($url, 'r')) 
		{
   			$content = '';
	   // keep reading until there's nothing left 
			while ($line = fread($fp, 1024)) 
		    	$content .= $line;
 			$content=str_replace('<img src=\"images/','<img src=\"$url/images/',stripslashes($content));
 			$content=str_replace('<img src=\"image/','<img src=\"$url/image/',$content);
		} 
		else
   			echo "error"; 
		echo base64_encode($content);
    }
	
	function show_invites_users($user_type_id='')
	{
		$this->load->model('users_model');	
		$this->data['inites_users'] = $this->users_model->get_invite_user_list(-1,0,array('user_type_id'=>$user_type_id));	
		$this->load->view('admin/newsletter/thick_box_invites_users.tpl.php',$this->data);
	}
	
	function import_users_mail()
	{
		$this->data['ck']	= $this->input->post('chk');
		$this->load->view('admin/newsletter/ajax_invites_user_list.tpl.php',$this->data);
	
	}
}