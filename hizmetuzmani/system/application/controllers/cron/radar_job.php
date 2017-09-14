<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 29 May 2012
* Modified By: 
* Modified Date: 
* 
* Purpose: radar jobs alert
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
		  $this->load->model('radar_model','mod_radar');
		  $this->load->model('tradesman_model','mod_td');
		  $this->load->model('job_model','mod_job');	
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    }

    /***
    * index function called by default
    * 
    */

    public function index()
    {
        try
        {
			
			$s_where = '';
			$info = $this->mod_radar->fetch_multi($s_where);
			$total_db_records=$this->mod_radar->gettotal_info($s_where);
			//pr($info,1);
			//echo '--------------------------------------------<br>';
			
			if($total_db_records>0)
			{
				for($i=0;$i<$total_db_records;$i++)
				{
					
					//echo $info[$i]['i_user_id'];
					$radar_category = $this->mod_radar->get_radar_cat($info[$i]['id']);
					//pr($radar_category,1);
					if(count($radar_category)>0)
					{
						$arr_search = array();
						foreach($radar_category as $val)
							$cat_arr[]=$val['i_category_id'];
						
						$arr_search[] =" n.i_category_id IN(".implode(",",$cat_arr).") ";
					}
					
					$arr_search[] = " n.i_status=1 AND n.i_is_deleted!=1 ";
					//$arr_search[] = " n.i_is_deleted!=1 ";  // for testing
					
					/* checking with city and province */
					$arr_search[] = " n.i_province_id=".$info[$i]['i_province']." ";
					$arr_search[] = " n.i_city_id=".$info[$i]['i_city']." ";
					/* end checking with city and province */
					
					$s_where = (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
					
                     //echo $s_where.'<br>';
					 //$job_list	= $this->mod_job->fetch_multi_completed($s_where,0,10);
					$job_list	= $this->mod_job->fetch_multi_completed_for_radar_cron($s_where,0,5);
					//pr($job_list); 

					if(count($job_list)>0)
					{
						
						$job_contents = $this->job_list($job_list);
						$i_tradesman_id = $info[$i]['i_user_id'];
						/* for job quote mail to the user */
					   
					   
					   //echo '==========='.$i_tradesman_id;exit;
					   $tradesman_details = $this->mod_td->fetch_tradesman_details($i_tradesman_id);
					   $s_where    		=   " WHERE tm.i_tradesman_id= {$i_tradesman_id} AND tm.i_status=1 " ;
          			   $i_membership    =   $this->mod_td->fetch_tradesman_membership_plan($s_where);
					   
					 	//pr($tradesman_details,1);
					   $this->load->model('auto_mail_model');
					   $content = $this->auto_mail_model->fetch_mail_content('tradesman_radar_jobs','tradesman',$tradesman_details['lang_prefix']);					
						//print_r($content); exit;
						//pr($tradesman_details);
						$filename = $this->config->item('EMAILBODYHTML')."common.html";
						$handle = @fopen($filename, "r");
						$mail_html = @fread($handle, filesize($filename));
						$s_subject = $content['s_subject'];
						if(!empty($content))
						{		
							$description = $content["s_content"];
							$description = str_replace("[TRADESMAN_NAME]",$tradesman_details['s_username'],$description);
							$description = str_replace("[JOB_LIST]",$job_contents,$description);	
							$description = str_replace("[SITE_URL]",base_url(),$description);							
						}
						unset($content);
						
						$mail_html = str_replace("[SITE_URL]",base_url(),$mail_html);	
						$mail_html = str_replace("[##MAIL_BODY##]",$description,$mail_html);
						//echo "<br>".$mail_html.'<br/>';
						/// Mailing code...[start]
						$site_admin_email = $this->s_admin_email;	
						$this->load->helper('mail');
						if($i_membership[0]['i_plan_type']!=2)
						{										
						$i_newid = sendMail($tradesman_details['s_email'],$s_subject,$mail_html);	
						}
						/// Mailing code...[end]
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
			  	$job_url	=	make_my_url($val['s_title']).'/'.encrypt($val['id']) ;
			  	$class = ($i%2 == 0)?'style="background-color:#F6F6F6"':'';
		  ?>
			  
			  <tr <?php echo $class ?>>
					<td style="border-bottom:1px dotted #CCCCCC; border-right:1px dotted #CCCCCC; border-left:1px dotted #CCCCCC; border-top:1px dotted #CCCCCC;padding:10px 0px;"><p style="padding:0px; margin:0px;"><strong><a href="<?php echo base_url().'job-details/'.$job_url?>" style="color:#199ad1; text-decoration:none;font-size:14px;"><?php echo $val['s_title']?></a></strong></p>
				<p style="padding:0px; margin:0px; color:#666666; font-family:Arial, Helvetica, sans-serif; font-size:12px;"><?php echo $val['s_province'].', '.$val['s_city'].', '.$val['s_postal_code']?></p>
				<p style="padding:0px; margin:0px;color:#666666; font-family:Arial, Helvetica, sans-serif; font-size:12px;"><?php echo $val['s_category_name']?></p>
				<p style="padding:0px; margin:0px;color:#666666; font-family:Arial, Helvetica, sans-serif; font-size:12px;"><?php echo $val['s_description']?></p>
				<p style="padding:0px; margin:0px;color:#666666; font-family:Arial, Helvetica, sans-serif; font-size:12px;"><?php echo 'Time left'?>: <?php echo $val['s_days_left']?> <?php echo ', Budget'?>: <span class="light_grey_txt"><?php echo $val['s_budget_price']?></span></p>
				</td>
				  
			  </tr>
		<?php  
			}
			?>
			</table>
			
			<?php 
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}


    public function __destruct()

    {}           

}
