<?php
/*********

* Author: Samarendu Ghosh

* Date  : 04 Nov 11

* Modified By: 

* Modified Date: 

* 

* Purpose: Newsletter cron

*  Frontend Knowledge_bank Page
* 

* @includes My_Controller.php

* @implements InfControllerFe.php

*/
class Newsletter extends My_Controller
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  $this->load->model('newsletter_subscribers_model');
		  $this->load->model('newsletter_model');
		  $this->load->helper('mail');

        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    }



    /***
    * 
    * newsletter send setting
    */

    public function index()
    {
        try
        {
			
			$s_where = " WHERE n.i_del_status=1";			
			//$s_where.=" AND FROM_UNIXTIME( n.i_send_date , '%Y-%m-%d' )= date_format(curdate(),'%Y-%m-%d')";
			$s_where.=" AND DATE_FORMAT(NOW(),'%Y-%m-%d')= FROM_UNIXTIME(n.i_send_date , '%Y-%m-%d')";
			//$s_where.=" AND n.i_id=22";
			
			$info = $this->newsletter_model->fetch_multi($s_where);
			$total_db_records=$this->newsletter_model->gettotal_info($s_where);	
					
			//pr($info);
			//pr($user_type_id,1);
			if($total_db_records>0)
			{
				for($i=0;$i<$total_db_records;$i++)
				{
					$user_type_id = explode(',',$info[$i]['i_user_type']);
					$arr_search = array();
					if(count($user_type_id) ===0)
						continue;
						
					foreach($user_type_id as $key=>$param)
					{
						switch($param)
						{
							case "1":
								$arr_search[] = " SELECT id,s_name,s_email FROM {$this->db->USERMANAGE} WHERE i_role=1 AND i_is_active=1 AND i_inform_news =1 ";
								
								break;
								
							case "2":
								$arr_search[] = " SELECT id,s_name,s_email FROM {$this->db->USERMANAGE} WHERE i_role=2 AND i_is_active=1 AND i_inform_news =1 ";
								break;
								
							case "4":
								$arr_search[] = " SELECT 0 AS id, s_name,s_email FROM {$this->db->NEWSLETTERSUBCRIPTION} WHERE i_subscribe_status=1 ";
								break;	
								
							default :	
								$arr_search[] ="";	
									
						}
						
					}
					
					$sql = count($arr_search)>1? implode(" UNION ",$arr_search):$arr_search[0];
					//echo $sql; exit;
					$rs			  =	$this->db->query($sql);
					$rowUser      =   $rs->result_array();
					//pr($rowUser);
					$filename = $this->config->item('EMAILBODYHTML')."common.html";
					$handle = @fopen($filename, "r");
					$mail_html = @fread($handle, filesize($filename));
					if(count($rowUser)>0)
					{
						foreach( $rowUser AS $key_user => $q_data_user )		
						{									
							 $to = $q_data_user["s_email"];
							 $newsletter_subject = $info[$i]["s_subject"];
							 $newsletter_msg = $info[$i]["s_full_content"];		
							 $html = str_replace("[site url]",base_url(),$mail_html);	
							 $html = str_replace("[##MAIL_BODY##]",$newsletter_msg,$html);							
							sendMail($to, $newsletter_subject, $html );
							
						}
						
						/*$data["i_is_send"]	=	"1";
						$wh	=	"i_id='".$info[$i]["id"]."'";
						$this->db->update($this->db->NEWSLETTER, $data, $wh);*/
					}
					
                    
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

    public function __destruct()

    {}           

}
