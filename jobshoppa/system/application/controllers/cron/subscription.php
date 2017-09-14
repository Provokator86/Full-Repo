<?php
class Subscription extends My_Controller
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  //$this->load->model('manage_jobs_model');

        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    }



    /***
    * 

    * 

    */

    public function index()
    {
        try
		{	
			if($this->data['site_setting']['i_subscrption_status']==1)
			{	
				$this->load->model('manage_tradesman_model');
				
				
				$s_where = " WHERE (DATE_SUB(FROM_UNIXTIME( n.i_account_expire_date , '%Y-%m-%d' ),INTERVAL 7 DAY)= date_format(curdate(), '%Y-%m-%d') OR DATE_SUB(FROM_UNIXTIME( n.i_account_expire_date , '%Y-%m-%d' ),INTERVAL 2 DAY)= date_format(curdate(), '%Y-%m-%d') ) AND n.i_role=2";			
				
				$info = $this->manage_tradesman_model->fetch_multi($s_where);
				//pr($info);exit;
				if($info)
				{
					foreach($info as $val)
					{
						
					   $this->load->model('auto_mail_model');
					   $content = $this->auto_mail_model->fetch_contact_us_content('tradesman_subscription_expire','tradesman');
					   $mail_subject = $content['s_subject'];
					   
					   $filename = $this->config->item('EMAILBODYHTML')."common.html";
					   $handle = @fopen($filename, "r");
					   $mail_html = @fread($handle, filesize($filename));						
						//print_r($content); exit;
						
						if(!empty($content))
						{							
																	
							$description = $content["s_content"];
							$description = str_replace("[service professional name]",$val['s_username'],$description);
							$description = str_replace("[Expire Date]",$val['dt_account_expire_date'],$description);
							$description = str_replace("[site_url]",base_url(),$description);
							$description = str_replace("%EMAIL_DISCLAMER%","",$description);							
						}
						//unset($content);
						
						$mail_html = str_replace("[site url]",base_url(),$mail_html);	
						$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
						//echo $this->data['loggedin']['user_email'];	
						//echo "<br>DESC".$description.'<br/>';	
						
						/// Mailing code...[start]
						$site_admin_email = $this->s_admin_email;
						//echo $site_admin_email; exit;
						$this->load->library('email');
						$config['protocol'] = 'sendmail';
						$config['mailpath'] = '/usr/sbin/sendmail';
						$config['charset'] = 'utf-8';
						$config['wordwrap'] = TRUE;
						$config['mailtype'] = 'html';
											
						$this->email->initialize($config);					
						$this->email->clear();                    
						
						$this->email->from($site_admin_email);	
										
						$this->email->to($val['s_email']);
						$this->email->subject($content['s_subject']);
						$this->email->message($mail_html);
						
						if(SITE_FOR_LIVE)///For live site
						{				
							$i_nwid = $this->email->send();	
																	
						}
						else{
							$i_nwid = TRUE;				
						}					
						
						
					}
				}
			}	
			
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	 	    
    }    

  
    /****
    * Display the static contents For this controller
    * 

    */

            

    public function __destruct()

    {}           

}
