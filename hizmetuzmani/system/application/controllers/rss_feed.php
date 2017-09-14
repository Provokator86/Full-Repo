<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 20 June 2012
* Modified By: 
* Modified Date: 
* 
* Purpose: 
* Frontend rss_feed Page
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class Rss_feed extends My_Controller 
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
	
    public function __construct()
    {
        try
        {
			parent::__construct();
			$this->data['title'] = "Rss Feed";
			$this->load->helper('xml');  
        	$this->load->helper('text');  
		
			$this->cls_msg=array();
			
			$this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
			$this->load->model('news_model','mod_news');
			$this->load->model('job_model','mod_job');
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
			$this->data['heading'] 		= 	"";
			$this->data['bread_cum']	=	" &raquo; Rss Feed";//
			$this->data['ctrlr'] 		= 	"rss_feed";
			
			$s_where = " WHERE n.i_status = 1 ";
			$this->data['news']	=	$this->mod_news->fetch_multi_rss_news($s_where,0,5);
			
			
		    $s_where = " WHERE n.i_status=1 AND n.i_is_deleted!=1 AND n.i_created_date >= ".strtotime('-15 days')." "; 
		    $this->data['new_jobs'] 	=  $this->mod_job->fetch_multi_completed($s_where,0,5);
			/*echo "<pre>";print_r($this->data['news']);exit;*/
			/*header("Content-Type: application/rss+xml; charset=ISO-8859-1");*/
			header("Content-Type: text/xml; charset=utf-8");
			$rssfeed = '<?xml version="1.0" encoding="utf-8"?>';
			$rssfeed .= '<rss version="2.0">';
			$rssfeed .= '<channel>';
			$rssfeed .= '<title>'.addslashes(t('HizmetUzmani RSS feed')).'</title>';
			$rssfeed .= '<link>http://www.acumencs.com/hizmetuzmani/</link>';
			$rssfeed .= '<description>'.addslashes(t('This is an RSS feed of Hizmetuzmani News')).'</description>';
			$rssfeed .= '<language>en-us</language>';
			$rssfeed .= '<copyright> '.addslashes(t('Copyright 2012 All Rights Reserved')).'</copyright>';
			
			ob_start();
			foreach($this->data['news'] as $val)
			{
				echo '<item>';
				echo '<title>' .htmlspecialchars($val["rss_title"]). '</title>';
				echo '<description> Description : '.substr_replace(htmlspecialchars($val["rss_long_description"]),'..',150).'</description>';
				echo '<link> ' . htmlspecialchars($val["rss_desc_link"]).'</link>';
				echo '</item>';
			
			}
			$rssfeed .=	ob_get_contents();
			ob_end_clean();
			ob_end_flush();
			
			ob_start();
			foreach($this->data['new_jobs'] as $val)
			{
				$make_url   =   make_my_url($val['s_category_name']).'/'.encrypt($val['i_category_id']) ;
                $job_url    =   make_my_url($val['s_title']).'/'.encrypt($val['id']) ;
				
				$rss_link	=	base_url().'job-details/'.$job_url;
				
				echo '<item>';
				echo '<title>' .htmlspecialchars($val["s_title"]). '</title>';
				echo '<description> Description : '.substr_replace(htmlspecialchars($val["s_description"]),'..',150).'</description>';
				echo '<link> ' . $rss_link.'</link>';
				echo '</item>';
			
			}
			$rssfeed .=	ob_get_contents();
			ob_end_clean();
			ob_end_flush();
			
			$rssfeed .= '</channel>';
    		$rssfeed .= '</rss>';
			
			echo $rssfeed;
			//$this->render('rss_feed/index.tpl.php', $this->data);
			
			unset($s_where,$start,$limit);
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

    public function show_cms()
    {

    } 

    public function __destruct()
    {}           
}
