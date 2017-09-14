<?php
/*********

* Author: Samarendu Ghosh

* Date  : 04 Nov 11

* Modified By: 

* Modified Date: 

* 

* Purpose: 

*  Frontend Knowledge_bank Page
* 

* @includes My_Controller.php

* @implements InfControllerFe.php

*/
class Radar_job extends My_Controller
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  $this->load->model('radar_model');
		  $this->load->model('zipcode_model');
		  $this->load->model('manage_tradesman_model','mod_trades');	
		  $this->load->model('job_model');	
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
			//$s_where = " WHERE FROM_UNIXTIME( n.i_expire_date , '%Y-%m-%d' )=date_format(curdate(), '%Y-%m-%d')";
			$s_where = '';
			$info = $this->radar_model->fetch_multi($s_where);
			$total_db_records=$this->radar_model->gettotal_info($s_where);
			//pr($info,1);
			//echo '--------------------------------------------<br>';
			
			if($total_db_records>0)
			{
				for($i=0;$i<$total_db_records;$i++)
				{
					
					//echo $info[$i]['i_user_id'];
					$radar_category = $this->radar_model->get_radar_cat($info[$i]['id']);
					//pr($radar_category,1);
					if(count($radar_category)>0)
					{
						$arr_search = array();
						foreach($radar_category as $val)
							$cat_arr[]=$val['i_category_id'];
						
						$arr_search[] =" n.i_category_id IN(".implode(",",$cat_arr).") ";
					}
					
					//$arr_search[] = " n.i_status=1 AND n.i_is_deleted!=1  AND cat_c.i_lang_id =1 ";
					$arr_search[] = " n.i_status=1 AND n.i_is_deleted!=1  ";
			    	$this->load->model("zipcode_model");
				    $zipcode = $this->zipcode_model->fetch_multi(" WHERE n.postal_code='{$info[$i]['i_postal_code']}'");
					
				if(!empty($zipcode))
				 {
				 	
					$lat = $zipcode[0]['latitude'];
					$lng = $zipcode[0]['longitude'];
					//$job_radius = intval($info[$i]['i_radius']);
					$job_radius = (intval($info['i_radius'])*10)+10;
					$mile= ($job_radius*1.6093);
					//$mile= 100;
					$arr_search[] =" (
										(
										  (
										  acos( sin( ( {$lat} * pi( ) /180 ) ) * sin( (
										  `latitude` * pi( ) /180 ) ) + cos( ( {$lat} * pi( ) /180 ) ) * cos( (
										  `latitude` * pi( ) /180 ) 
										  ) * cos( (
										  (
										  {$lng} - `longitude` 
										  ) * pi( ) /180 ) 
										  )
										  )
										  ) *180 / pi( ) 
										 ) *60 * 1.1515 * 1.609344
										)  <= $mile";	
				}
				else
					$arr_search[] =" z.postal_code='{$info[$i]['i_postal_code']}'";		
					
					
					 $s_where = (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
					
                   //  echo $s_where.'<br>';
					 //$job_list	= $this->job_model->fetch_multi_completed($s_where,0,10);
					 $job_list	= $this->job_model->fetch_multi_completed_for_radar_cron($s_where,0,10);
					 //pr($job_list); exit;
					//continue;
								

					if(count($job_list)>0)
					{
						
						$job_contents = $this->job_list($job_list);
						$i_tradesman_id = $info[$i]['i_user_id'];
						/* for job quote mail to the user */
					   $this->load->model('tradesman_model');
					   
					   //echo '==========='.$i_tradesman_id;exit;
					   $tradesman_details = $this->tradesman_model->fetch_this($i_tradesman_id);
					   
					 	//pr($tradesman_details,1);
					   $this->load->model('auto_mail_model');
					   $content = $this->auto_mail_model->fetch_contact_us_content('tradesman_radar_jobs','tradesman');					
						//print_r($content); exit;
						//pr($tradesman_details);
						$filename = $this->config->item('EMAILBODYHTML')."common.html";
						$handle = @fopen($filename, "r");
						$mail_html = @fread($handle, filesize($filename));
						if(!empty($content))
						{		
							$description = $content["s_content"];
							$description = str_replace("[service professional name]",$tradesman_details['s_name'],$description);
							$description = str_replace("[job list]",$job_contents,$description);	
							$description = str_replace("[site_url]",base_url(),$description);							
						}
						//unset($content);
						//echo $this->data['loggedin']['user_email'];	
						//echo "<br>DESC".$description;	exit;
						$mail_html = str_replace("[site url]",base_url(),$mail_html);	
						$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
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
										
						$this->email->to($tradesman_details['s_email']);						
						
						$this->email->subject($content['s_subject']);
					
						unset($content);
						$this->email->message($mail_html);
						
						if(SITE_FOR_LIVE)///For live site
						{				
							$i_nwid = $this->email->send();	
																	
						}
						else{
							//echo $mail_html;
							$i_nwid = TRUE;				
						}
					}
					unset($arr_search);
					
			}
			}
			unset($s_where,$info,$total_db_records);
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

    public function job_list($job_list)
	{
		ob_start();
			$i=1;
				?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0"><?php
			  foreach($job_list as $val)
			  {
		  ?>
			  
			  <tr>
					<td style="border-bottom:1px dotted #9de0fc; padding:10px 0px;"><p style="padding:0px; margin:0px;"><strong><a href="<?php echo base_url().'job/job_details/'.encrypt($val['id'])?>" style="color:#199ad1; text-decoration:none;"><?php echo $val['s_title']?></a></strong></p>
				<p style="padding:0px; margin:0px;"><?php echo $val['s_state'].', '.$val['s_city'].', '.$val['s_postal_code']?></p>
				<p style="padding:0px; margin:0px;"><?php echo $val['s_category_name']?></p>
				<p style="padding:0px; margin:0px;"><?php echo $val['s_description']?></p>
				<p style="padding:0px; margin:0px;"><?php echo 'Time left'?>: <?php echo $val['s_days_left']?> <?php echo 'Budget'?>: <span class="light_grey_txt"><?php echo $val['s_budget_price']?></span></p></p>
				</td>
				  
			  </tr>
		<?php  
			}
			?></table>
			<?php 
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}

    public function __destruct()

    {}           

}
