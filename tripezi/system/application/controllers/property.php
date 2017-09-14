<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 06 July 2012
* Modified By: koushik
* Modified Date: 
* 
* This controler deals with property this controller contains 
* the details of the property .
* It is a public page for site
* it contain booking also ,for booking one need to login to the site
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class Property extends My_Controller
{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public function __construct()
    {
        try
        { 
          parent::__construct(); 
          $this->data['title'] = "Property List";////Browser Title
		  $this->data['ctrlr'] = "property";

          $this->cls_msg=array();
          $this->cls_msg["booking_succ"]  	= "Your booking request successfully received. Check your email.";    
          $this->cls_msg["booking_login"]  	= "Please login for booking.";    
          $this->cls_msg["booking_own"]     = "Sorry you can not book your own property.";    
          $this->cls_msg["request_err"]   	= "Sorry, we can not take this request.";    
		  $this->cls_msg["no_result"]		= "No information found about latest property."; 
		  $this->cls_msg["log_err"]  		= "Please login for this feature.";    
          $this->cls_msg["owner_err"]     	= "Sorry you can not add to favourite your own property.";    
          $this->cls_msg["exist_err"]   	= "You hav already been add this property to your favourite.";    
		  $this->cls_msg["fav_succ"]		= "Property successfully added to your favourite list.";
		  $this->cls_msg["fav_del_succ"]	= "This roperty successfully deleted from your favourite list.";
		  
          $this->pathtoclass				= base_url().$this->router->fetch_class()."/";//for redirecting from this class
          
          $this->load->model("property_model","mod_rect");
		  $this->load->model("assets_model","mod_asset");
		
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
			redirect(base_url().'search');		
			/*$this->s_meta_type = 'property';
			$this->data['breadcrumb'] = array('Property'=>'');
			
			ob_start();
			$this->ajax_property_list(0,1);
			$contents = ob_get_contents();
			ob_end_clean();
			$property = explode('^',$contents);
			
			$this->data['property'] 		= $property[0];
			$this->data['total_property']	= $property[1];*/
			
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/* ajax call to get property with paginatin */
	function ajax_property_list($start=0,$param=0) {	
	
		$s_where='';		
		$arr_search[] = " p.i_status =1 "; 
		
		$s_where .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';

		$limit	=  4;
		//echo $s_where;
		$this->data['property_list']	= $this->mod_rect->fetch_multi($s_where,intval($start),$limit);	
		$total_rows 					= $this->mod_rect->gettotal_info($s_where);	
		//pr($this->data['property_list'],1);
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'property/ajax_property_list/';
		$paging_div = 'property_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		if(empty($param))
			$job_vw = $this->load->view('fe/property/ajax_property_list.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/property/ajax_property_list.tpl.php',$this->data,TRUE).'^'.$total_rows;
		echo $job_vw;
		/* pagination end */

	
	}	
	
    /**
    * This is the function for property details page.
    *
    * 
    * @param mixed $enc_property_id
    * @param mixed $tab_index
    * 
    * tabindex need open the tab which need to open time of redirecting default it open 
    */
	
	public function details($enc_property_id,$tab_index,$s_property_name='')
    {
        try
        {
         
            //$this->session->unset_userdata('session_request'); 
			$this->s_meta_type = 'property_details';
			$this->data['breadcrumb'] = array('Property'=>base_url().'search','Property Details'=>'');
            
            $i_property_id  =   decrypt($enc_property_id);
            
           
			
           $array_request   =   array();
           $info_booked     =   array(); 
           
			if($_POST)
            {
                $txt_check_in    =   $this->input->post("txt_check_in");
                $txt_check_out   =   $this->input->post("txt_check_out");
                $selected_month  =   $this->input->post('selectmonth');
                
                
                if($selected_month!='')
                {
                    $arr_month  =   explode('_',$selected_month);
                    $this_month =   $arr_month[0];
                    $this_year  =   $arr_month[1];

                }
                if($txt_check_in!='' && $txt_check_out!='')
                {
                    $arr_check_in   =   explode('-',$txt_check_in);
                    $arr_check_out  =   explode('-',$txt_check_out);
                    $ses_check_in   =   array('date'=>(int)($arr_check_in[0]),
                                                'month'=>(int)($arr_check_in[1]),
                                                'year'=>(int)($arr_check_in[2]));
                    $ses_check_out  =   array('date'=>(int)($arr_check_out[0]),
                                                'month'=>(int)($arr_check_out[1]),
                                                'year'=>(int)($arr_check_out[2]));
                 
                                                
                    $check_in_time   =   strtotime($ses_check_in['date'].'-'.$ses_check_in['month'].'-'.$ses_check_in['year']) ;  
                    $check_out_time  =   strtotime($ses_check_out['date'].'-'.$ses_check_out['month'].'-'.$ses_check_out['year']) ;  
                                                
                    $s_where    =     " WHERE i_property_id=".decrypt($enc_property_id)." AND e_status!='Not Paid' AND (dt_booked_from BETWEEN ".$check_in_time." AND ".($check_out_time-1)." OR ( dt_booked_to-3600*24 BETWEEN ".$check_in_time." AND ".$check_out_time.' )) ';  
                    
                    $info_booked    =   $this->mod_rect->fetch_booked_date($s_where);

                     
                     
                    $s_where    =     " WHERE i_property_id=".decrypt($enc_property_id)." AND dt_blocked_date BETWEEN ".$check_in_time." AND ".($check_out_time-1)  ;
                    
                    $info_blocked   =   $this->mod_rect->property_booked_date($s_where);
                  
                  
                     
                    if(count($info_blocked)>0 || count($info_booked)>0)
                    {
                        $this->session->unset_userdata('session_request');
                        $this->session->set_userdata(array('message'=>$this->cls_msg["request_err"],'message_type'=>'err'));
                        redirect(base_url().'property/details/'.$enc_property_id.'/availability/'.$s_property_name);
                        
                    }
                    
                    
                         
                    $info_property  =   $this->mod_rect->fetch_property_info(decrypt($enc_property_id));
                   
                    $no_of_days     =   $this->get_no_of_days($txt_check_in,$txt_check_out) ;
                    
                    if($no_of_days<$info_property['i_minimum_night_stay'] || $no_of_days>$info_property['i_maximum_night_stay'])
                    {
                        $this->session->unset_userdata('session_request');
                        $this->session->set_userdata(array('message'=>" Number of night stay must be greater than ".$info_property['i_minimum_night_stay']." days and less than ".$info_property['i_maximum_night_stay']." days.",'message_type'=>'err'));
                        redirect(base_url().'property/details/'.$enc_property_id.'/availability/'.$s_property_name);  
                        
                    }
                                            
                    
                    $this->session->set_userdata('session_request',array('ses_check_in'=>$ses_check_in,
                                                                        'ses_check_out'=>$ses_check_out,
                                                                        'property_id'=>$enc_property_id,
                                                                        'check_in_date'=>$txt_check_in,
                                                                        'check_out_date'=>$txt_check_out));
                    
                     $this_month =   $arr_check_in[1];
                     $this_year  =   $arr_check_in[2];
                        
                     $selected_month    =   ltrim($arr_check_in[1],'0').'_'.$arr_check_in[2] ;                                                      
                    
                }
               // Time of Booking
               // The check in date and check out date in session ll booked to the user for the property
               // Booking status set to Request Send
                if($this->input->post('h_form'))  
                {
                    if($this->session->userdata("session_request"))  // If session is set then show color of request of booking
                    {
                        $session_request    =   $this->session->userdata("session_request") ;
                        $this->loggedin     =   $this->data['loggedin'] ;
                        if(!empty($this->loggedin)) // check whether any one logwd in or not
                        {
                            $this->load->model('common_model','mod_common');
                         
                            $info_property  =   $this->mod_rect->fetch_property_info(decrypt($enc_property_id));
                           
                            if(!empty($info_property))
                            {
                                $i_owner_id     =   $info_property['i_owner_user_id'] ;
                                
                                if($i_owner_id  ==  decrypt($this->loggedin['user_id'])) //owner can not book his own property
                                {
                                    $this->session->unset_userdata("session_request");
                                     $this->session->set_userdata(array('message'=>$this->cls_msg["booking_own"],'message_type'=>'err'));
                                     redirect(base_url().'property/details/'.$enc_property_id.'/availability/'.$s_property_name); 
                                    
                                }
                            }
                            // Time of booking checking if property booked already not
                            
                            $check_in_time   =   strtotime($session_request['ses_check_in']['date'].'-'.$session_request['ses_check_in']['month'].'-'.$session_request['ses_check_in']['year']) ;  
                            $check_out_time  =   strtotime($session_request['ses_check_out']['date'].'-'.$session_request['ses_check_out']['month'].'-'.$session_request['ses_check_out']['year']) ;  
                                                        
                            $s_where    =     " WHERE i_property_id=".decrypt($enc_property_id)." AND e_status!='Not Paid' AND (dt_booked_from BETWEEN ".$check_in_time." AND ".($check_out_time-1)." OR ( dt_booked_to-3600*24 BETWEEN ".$check_in_time." AND ".$check_out_time.' )) ';  
                            
                            $info_booked    =   $this->mod_rect->fetch_booked_date($s_where);

                             
                             
                            $s_where    =     " WHERE i_property_id=".decrypt($enc_property_id)." AND dt_blocked_date BETWEEN ".$check_in_time." AND ".($check_out_time-1)  ;
                            
                            $info_blocked   =   $this->mod_rect->property_booked_date($s_where);
                          
                          
                             
                            if(count($info_blocked)>0 || count($info_booked)>0)
                            {
                                $this->session->unset_userdata('session_request');
                                $this->session->set_userdata(array('message'=>$this->cls_msg["request_err"],'message_type'=>'err'));
                                redirect(base_url().'property/details/'.$enc_property_id.'/availability/'.$s_property_name);
                                
                            }
                            
                            
                          
                             
                            if($session_request['property_id']==$enc_property_id)// If the property in session is same as requested property 
                            {
                    
                                $info   =   array();
                                $info['s_booking_id']           =   generateRandomId();
                                $info['i_traveler_user_id']     =   decrypt($this->loggedin['user_id']);
                                $info['i_property_id']          =   decrypt($enc_property_id);
                                $info['dt_booked_on']           =   time();
                                $info['dt_booked_from']         =   strtotime($session_request['ses_check_in']['date'].'-'.$session_request['ses_check_in']['month'].'-'.$session_request['ses_check_in']['year']);
                                $info['dt_booked_to']           =   strtotime($session_request['ses_check_out']['date'].'-'.$session_request['ses_check_out']['month'].'-'.$session_request['ses_check_out']['year']);
                                
                                
                                
                                $info['e_status']               =   'Request sent';
                                
                                $i_new_id   =   $this->mod_rect->booking_property($info); // add booking request

                                if($i_new_id)
                                {
                                    
                                   
                                    $h_message  =   trim($this->input->post('h_message'));
                                    
                                    /* Booking request mail send to the property owner */
                                   $this->load->model("auto_mail_model","mod_auto");
                                   $content         =   $this->mod_auto->fetch_mail_content('booking_request');    
                                   $filename        =   $this->config->item('EMAILBODYHTML')."common.html";
                                   $handle          =   @fopen($filename, "r");
                                   $mail_html       =   @fread($handle, filesize($filename));    
                                   $s_subject       =   $content['s_subject'];        
                                    //print_r($content); exit;    
                                                    
                                    if(!empty($content))
                                    {                    
                                        $description = $content["s_content"];
                                        
                                        $description = str_replace("###OWNER###",ucfirst($info_property['s_first_name']).' '.ucfirst($info_property['s_last_name']),$description);    
                                        $description = str_replace("###PROPERTY###",$info_property['s_property_name'],$description);        
                                        $description = str_replace("###TRAVELER###",ucfirst($this->loggedin['user_first_name']).' '.ucfirst($this->loggedin['user_last_name']),$description);                        
                                        $description = str_replace("###TRAVELER_PIC###",showThumbImageDefault('user_image',$this->loggedin["user_image"],'thumb',100,100),$description);                        
                                        $description = str_replace("###OPTIONAL_MESSAGE###",nl2br($h_message),$description);                        
                                    }
                                        
                                    $mail_html = str_replace("###SITE_URL###",base_url(),$mail_html);    
                                    $mail_html = str_replace("###MAIL_BODY###",$description,$mail_html);    
                                   
                                   
                                    /// Mailing code...[start]
                                    $site_admin_email = $this->s_admin_email;    
                                    $this->load->helper('mail');                                        
                                    $i_sent = sendMail($info_property['s_email'],$s_subject,$mail_html);
                                    
                                    unset($mail_html,$description,$s_subject,$content,$info_property);
                                    if($i_sent)
                                    {
                                        $this->session->unset_userdata("session_request");
                                        $this->session->set_userdata(array('message'=>$this->cls_msg["booking_succ"],'message_type'=>'succ'));
                                    
                                        redirect(base_url().'property/details/'.$enc_property_id.'/availability/'.$s_property_name); 
                                        
                                    }
                                    
                                }

                            }
                            
                        }
                        else
                        {
                             $this->session->set_userdata(array('message'=>$this->cls_msg["booking_login"],'message_type'=>'err'));
                            redirect(base_url().'user/login');
                        }
                        
                    }           
                    
                }
                
                $this->data['selected_month']   =   $selected_month ; 
               
               $tab_index   =   'availability';
                
                
            }
            else // if nothing posted then select current month and year
            {
                 $this_month =   date('m');
                 $this_year  =   date('Y');
             
            }
            $info   =   $this->mod_rect->fetch_this($i_property_id);            
            $this->data['info'] =   $info ;
			
            if(!empty($info))
            {
            $this->load->model('user_model','mod_user');
            $owner_info                 = $this->mod_user->fetch_this($info["i_owner_user_id"]);
            $this->data['owner_info']    = $owner_info;
            }
			
			// for fetch this property is in favourite list of loggedin user
			if(!empty($this->data["loggedin"]))
			{
				$i_user_id = decrypt($this->data["loggedin"]["user_id"]);
				$s_where = " WHERE f.i_property_id = ".$i_property_id." AND f.i_user_id = ".$i_user_id." ";
				$this->data["i_favourite"] = $this->mod_rect->count_favourite_exist($s_where);
			}
			else
			{
				$this->data["i_favourite"] = 0;
			}
            // end for fetch this property is in favourite list of loggedin user
			
            // fetch the all amenity of a property
            $s_where        =   " WHERE pa.i_property_id= ".$i_property_id." AND a.i_status=1";
            $info_amenity   =   $this->mod_rect->fetch_property_amenity($s_where) ;
            $this->data['info_amenity'] =   $info_amenity;
            /***************************** FETCH PROPERTY IMAGES   *******************************/
            $s_where        =   " WHERE pi.i_property_id= ".$i_property_id." " ;
            $info_image     =   $this->mod_rect->fetch_property_image($s_where) ;
            
            $arr_image   =   array();
            if(!empty($info_image))
            {
                $i  =   0;
                foreach($info_image as $val)
                {
                    $file_name  =   getFilenameWithoutExtension($val["s_property_image"]);
                    $arr_image[$i]["large"]  =   $file_name."_large.jpg";
                    $arr_image[$i]["min"]       =   $file_name."_min.jpg";
                    $i++; 
                }
            }
            $this->data["arr_image"]    =   $arr_image ;
            /***************************** FETCH PROPERTY IMAGES   *******************************/
            
            /***************************** FETCH OTHER PROPERTY   *******************************/
            $s_where = " WHERE p.i_id!=".$i_property_id." AND p.i_status =1 AND p.i_city_id = ".$info["i_city_id"]." AND u.i_phone_verified = 1 ";
			if(!empty($this->data["loggedin"]))
			{
				$login_id = decrypt($this->data["loggedin"]["user_id"]);
			}
			else
			{
				$login_id = '';
			}
            $other_property = $this->mod_rect->fetch_multi($s_where,0,2,$login_id);
			//pr($other_property,1);
            $this->data["other_property"]    =    $other_property;
            $this->data['enable_request_btn']   =   0 ;
            //pr($other_property,1);
            /***************************** FETCH OTHER PROPERTY   *******************************/
           
             unset($info,$info_image,$info_amenity,$owner_info);
            
			/***************************** START GENERATE CALENDER   *******************************/
			
            if($this->session->userdata("session_request"))  // If session is set then show color of request of booking
            {
                
                $session_request    =   $this->session->userdata("session_request") ;
              
              
                $this->data['enable_request_btn']   =   1 ;

            
             if($session_request['property_id']==$enc_property_id)
                {
                // If selected month is equal to session  month and year
                    if($session_request['ses_check_in']['year']==$this_year && $session_request['ses_check_in']['year']==$session_request['ses_check_out']['year'])
                    {
                            if($session_request['ses_check_in']['month']==$this_month)
                            {
                                // if check in date and check out date are in between current month
                                if($session_request['ses_check_in']['month']==$session_request['ses_check_out']['month'] )
                                {
                                    $array_request  =   range($session_request['ses_check_in']['date'],$session_request['ses_check_out']['date']-1);
                                }
                                // in check in date in current month but check out date other than this month
                                else if($session_request['ses_check_in']['month']!=$session_request['ses_check_out']['month'] )
                                {
                                    $array_request  =   range($session_request['ses_check_in']['date'],get_total_days_in_month($session_request['ses_check_in']['month'],$session_request['ses_check_in']['year']));
                                }
                            } 
                                // If check out month is the current month then select upto the date .
                            else if($session_request['ses_check_out']['month']==$this_month && $session_request['ses_check_out']['date']>1)
                            {
                                $array_request  =   range(1,$session_request['ses_check_out']['date']-1);
                                
                            }
                            // If check out month is greater than current month select the whole month
                            else if($session_request['ses_check_in']['month']<$this_month && $session_request['ses_check_out']['month']>$this_month)
                            {
                                $array_request  =   range(1,get_total_days_in_month($this_month,$this_year));
                            }
                      
                      }
                      if($session_request['ses_check_in']['year']<$session_request['ses_check_out']['year'])
                      {
                          if($session_request['ses_check_in']['year']==$this_year)
                          {
                               if($session_request['ses_check_in']['month']==$this_month)
                               {
                                    $array_request  =   range($session_request['ses_check_in']['date'],get_total_days_in_month($this_month,$this_year));
                               } 
                               else if($session_request['ses_check_in']['month']<$this_month)
                               {
                                    $array_request  =   range(1,get_total_days_in_month($this_month,$this_year));
                               }
                          }
                          if($session_request['ses_check_out']['year']==$this_year)
                          {
                               if($session_request['ses_check_out']['month']==$this_month && $session_request['ses_check_out']['date']>1)
                               {
                                    $array_request  =   range(1,$session_request['ses_check_out']['date']-1);
                               } 
                               else if($session_request['ses_check_out']['month']>$this_month)
                               {
                                    $array_request  =   range(1,get_total_days_in_month($this_month,$this_year));
                               }
                          }
                         
                          
                      }
                        
                    $this->data['txt_check_in']  =  $session_request['check_in_date']; 
                    $this->data['txt_check_out'] =  $session_request['check_out_date']; 

                }


            }
            
            $this->data['array_request']    =   $array_request ; // to select the month in the select box
            $this->data["start_day"]        =   get_first_day($this_month,$this_year); // Get first the day of the month
            $this->data["total_days"]       =   get_total_days_in_month($this_month,$this_year);  // get total days in a month
            /***************************** END GENERATE CALENDER   *******************************/
			
           
            /************* Start Finding  the blocked date and booked date of the selected month ************/
            if($this_month==12)
            {
                $next_month =   1;
                $next_year  =   $this_year +1 ;
            }
            else
            {
                $next_month =   $this_month+1;
                $next_year  =   $this_year ;
            }
         
            // Finding the block date 
            $s_where    = " WHERE i_property_id=".$i_property_id." AND dt_blocked_date >=".strtotime('01-'.$this_month.'-'.$this_year)." AND dt_blocked_date <".strtotime('01-'.$next_month.'-'.$next_year) ;
            
          
            $info_blocked    =   $this->mod_rect->property_booked_date($s_where); // fetching block date
           
            // Finding the booked date
            $s_where    = " WHERE i_property_id=".$i_property_id." AND  e_status!='Not Paid' AND ( dt_booked_from BETWEEN ".strtotime('01-'.$this_month.'-'.$this_year)." AND ".strtotime('01-'.$next_month.'-'.$next_year)." OR ( dt_booked_to BETWEEN ".strtotime('01-'.$this_month.'-'.$this_year)." AND ".strtotime('01-'.$next_month.'-'.$next_year)." )) " ;
            
            $info_booked    =   $this->mod_rect->fetch_booked_date($s_where); // Fetching the booked date
           
           
           
           // In booked array we find only the interval so we need to find array of dates
           // ex 15-07-2012 to 18-07-2012 (15,16,17,18)
            $arr_booked     =   array();
          
            if(!empty($info_booked))
            {
                foreach($info_booked as $val)
                {
                    if(($val['booked_from_year']==$this_year || $val['booked_to_year']==$this_year) )
                    {
                        if($val['booked_from_month']==$val['booked_to_month'] && $val['booked_from_month']==$this_month) // If check in and check out month are equal
                        {
                            $arr_booked =   array_merge($arr_booked,range($val['booked_from_date'],$val['booked_to_date']-1));
                        }
                        else // If check in months are unequal
                        {
                            if($val['booked_from_month']==$this_month) // If check in month is current selected month
                            {
                                $arr_booked =   array_merge($arr_booked,range($val['booked_from_date'],$this->data["total_days"]));
                            }
                            else if($val['booked_to_month']==$this_month && $val['booked_to_date']>1) // If check out month is in current selected month
                            {
                                $arr_booked =   array_merge($arr_booked,range(1,$val['booked_to_date']-1));
                            }
                        }
                        
                    }
                    
                    
                }
            } 
            // Marge both  booked date and blocked date to show in color
            $this->data['info_blocked']  =   array_merge($arr_booked,$info_blocked) ;
            unset($arr_booked,$info_blocked,$info_booked,$s_where);
            /************* End Finding  the blocked date and booked date of the selected month ************/
            
            
            $this->data['index']            =   $tab_index ; // To selecting the tab
          
			/***************************** TO GENERATE CALENDER*******************************/
			
			/***************************** FETCH REVIEWS OF THIS PROPERTY *******************************/
			$s_where = " WHERE b.i_property_id = ".$i_property_id." ";
			$this->data["reviews"] = $this->mod_rect->fetch_reviews_of_property($s_where,0,3);
			//pr($this->data["reviews"],1);
			/***************************** END FETCH REVIEWS OF THIS PROPERTY*******************************/

           
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/* this function get the cancellation policy detail */
	public function ajax_fetch_policy()
    {
        try
        {
           if($_POST)
           {
                 $policy_id	=   $this->input->post('policy_id');                 
                 // Fetch policy details.....               
                 $info_policy  =   $this->mod_asset->fetch_this_cancellation_policy($policy_id);
				// pr($info_policy,1);
                 $str    =   '';
                 if(!empty($info_policy))
                 {
                   
                    $str .= '<div class="spacer"></div>
							<div class="lable07">Policy Name :</div>
							<div class="lable09">'.$info_policy['s_name'].'</div>
							<div class="spacer"></div>
							<div class="lable07">Policy Description :</div>
							<div class="lable09">'.nl2br($info_policy['s_description']).'</div>
							<div class="spacer"></div>							
							<div class="lable07">Cancellation Charge :</div>
							<div class="lable09">'.$info_policy['d_cancellation_charge'].' %'.'</div>' ;
                
                 }
				 else
				{
					$str .= 'no policy detail found';
				}
				
				echo $str; 
                   
           }
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	
	
	/* this ajax function is to add the favorites property */
	public function ajax_add_favourite()
    {
        try
        {
			$property_id= $this->input->post('property_id');			
			$user_id 	= decrypt($this->data["loggedin"]["user_id"]);
			$info   	=   $this->mod_rect->fetch_this($property_id); 
			if(!empty($this->data["loggedin"]))
			{
			if($info["i_owner_user_id"] == $user_id)
			{
				//$this->session->set_userdata(array('message'=>$this->cls_msg["owner_err"],'message_type'=>'err'));
				//redirect(base_url().'property/details/'.encrypt($property_id));
				echo 'owner_error';
			}
			else
			{
				$s_where = " WHERE f.i_property_id = ".$property_id." AND f.i_user_id = ".$user_id." ";
				$i_favourite_count = $this->mod_rect->count_favourite_exist($s_where);
				if($i_favourite_count>0)
				{
					//$this->session->set_userdata(array('message'=>$this->cls_msg["exist_err"],'message_type'=>'err'));
					//redirect(base_url().'property/details/'.encrypt($property_id));
					echo 'exist';
				}
				else
				{
					$s_table = $this->db->FAVOURITES;
					$arr	 = array();
					$arr["i_user_id"]		=	$user_id;
					$arr["i_property_id"]	=	$property_id;
					$arr["dt_created_on"]	=	time();
					$this->load->model('common_model','mod_common');
					$i_favourite = $this->mod_common->common_add_info($s_table,$arr);	
					if($i_favourite)
					{
						//$this->session->set_userdata(array('message'=>$this->cls_msg["fav_succ"],'message_type'=>'succ'));
						//redirect(base_url().'property/details/'.encrypt($property_id));
						echo 'ok';
					}					
				}
				
			}
			}
			else
			{
				echo 'login_error';
			}
           
            unset($s_table,$arr,$s_where,$i_favourite_count,$i_favourite,$info,$user_id,$property_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	/* end function is to add the favorites property */
	
	/* this ajax function is to remove the favorites property */
	public function ajax_remove_favourite()
    {
        try
        {
			$property_id= $this->input->post('property_id');			
			$user_id 	= decrypt($this->data["loggedin"]["user_id"]);
			$info   	=   $this->mod_rect->fetch_this($property_id); 
			if($info["i_owner_user_id"] == $user_id)
			{
				echo 'owner_error';
			}
			else
			{
				$s_where = " WHERE f.i_property_id = ".$property_id." AND f.i_user_id = ".$user_id." ";
				$i_favourite_count = $this->mod_rect->count_favourite_exist($s_where);
				if($i_favourite_count>0)
				{
					$s_table = $this->db->FAVOURITES;
					$arr_where = array('i_property_id'=>$property_id,'i_user_id'=>$user_id);
					$this->load->model('common_model','mod_common');
					$i_deleted = $this->mod_common->common_delete_info($s_table,$arr_where);	
					if($i_deleted)
					{
						echo 'ok';
					}
					else
					{
						echo 'error';
					}	
				}
				else
				{
					echo 'not exist';
				}
			}
           
            unset($s_table,$arr,$s_where,$i_favourite_count,$i_favourite,$info,$user_id,$property_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	/* end function is to add the favorites property */
	
	
    
    function get_no_of_days($start_date,$end_date)
    {
        try
        {
            return (int)((strtotime($end_date)-strtotime($start_date))/(60*60*24)) ;
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	public function favourites()
    {
        try
        {			
			if(empty($this->data["loggedin"]))
			{
				redirect(base_url().'user/login');
			}
			$this->s_meta_type = 'property';
			$this->data['breadcrumb'] = array('Favourite Property'=>'');
			
			ob_start();
			$this->ajax_favourites_property_list(0,1);
			$contents = ob_get_contents();
			ob_end_clean();
			$property = explode('^',$contents);
			
			$this->data['property'] 		= $property[0];
			$this->data['total_property']	= $property[1];
			
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/* ajax call to get property with paginatin */
	function ajax_favourites_property_list($start=0,$param=0) {	
	
		$s_where='';	
		
		$user_id = decrypt($this->data["loggedin"]["user_id"]);
		$arr_search[] = " fp.i_user_id = ".$user_id." AND p.i_status =1 "; 
		
		$s_where .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';

		$limit	=  10;
		//echo $s_where;
		$this->data['property_list']	= $this->mod_rect->fetch_favourite_property_list($s_where,intval($start),$limit,$user_id);	
		$total_rows 					= $this->mod_rect->gettotal_favourite_property_info($s_where);	
		//pr($this->data['property_list'],1);
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'property/ajax_favourites_property_list/';
		$paging_div = 'property_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		if(empty($param))
			$job_vw = $this->load->view('fe/property/ajax_favourites_property_list.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/property/ajax_favourites_property_list.tpl.php',$this->data,TRUE).'^'.$total_rows;
		echo $job_vw;
		/* pagination end */

	
	}
 
    public function __destruct()

    {}           

}



/* End of file welcome.php */

/* Location: ./system/application/controllers/welcome.php */

