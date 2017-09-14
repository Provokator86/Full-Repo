<?php
class pagination_model extends CI_Model
{
   
    function __construct()
    {
        parent::__construct();
    }
	
	function get_jpagination($s_rq_url, $i_total_no, $i_per_page=10, $i_uri_seg="",$div_id='div_paging')
    {
		$ci=get_instance();
	
		$ci->load->library('jquery_pagination');
		
		$config['base_url'] = $s_rq_url;

		$config['total_rows'] = $i_total_no;
		$config['per_page'] = $i_per_page;

		//$config['uri_segment'] = ($i_uri_seg?$i_uri_seg:$ci->i_uri_seg);
		
		if($i_uri_seg=="")
			$config['uri_segment'] = 0;
		else
			$config['uri_segment'] = $i_uri_seg;

		$config['num_links'] = 2;
		$config['page_query_string'] = false;		

		$config['first_link'] = '&lsaquo; '.addslashes(t("First"));
		$config['last_link'] =  addslashes(t("Last")).' &rsaquo;';

		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="next">';
		$config['next_tag_close'] = '</li>';
		
		$config['prev_tag_open'] = '<li class="previous">';
		$config['prev_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo;'.addslashes(t("Previous"));
		$config['next_link'] = addslashes(t("Next")).'&raquo;';
		
		

		$config['cur_tag_open'] = ' <li class="active"><a href="javascript:void(0);">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['div'] = '#'.$div_id;
		//pr($config);
		$ci->jquery_pagination->initialize($config);
		//unset($s_rq_url,$i_total_no,$i_per_page,$i_uri_seg,$config);
		return $ci->jquery_pagination->create_links();
    }
	
	function get_jpagination_frontend($url,$total,$perpage,$page,$uri_seg="",$div_id='div_paging')
    {
		$ci=get_instance();
		
        $ci->load->library('jquery_pagination');
		$config['base_url'] = $url;
		
		$config['total_rows'] = $total;
		$config['per_page'] = $perpage;
		
		if($uri_seg=="")
			$config['uri_segment'] = 0;
		else
			$config['uri_segment'] = 0;
			
		$config['cur_page'] = $page;
		
		$config['num_links'] = 2;
		$config['page_query_string'] = false;
                
		$config['prev_link'] = '&laquo;'.addslashes(t("Previous"));
		$config['next_link'] = addslashes(t("Next")).'&raquo;';
                
		$config['first_link'] = '&lsaquo; '.addslashes(t("First"));
		$config['last_link'] =  addslashes(t("Last")).' &rsaquo;';
		$config['cur_tag_open'] = '<a class="select">';
  		$config['cur_tag_close'] = '</a>';

		$config['next_tag_open'] = '';
		$config['next_tag_close'] = '';

		$config['prev_tag_open'] = '';
		$config['prev_tag_close'] = '';

		$config['num_tag_open'] = ' ';
  		$config['num_tag_close'] = ' ';
		
		//$config['custom_paging']		= '';
		//$config['ui_unblock']		= '';

		$config['div'] = '#'.$div_id;
		//$config['js_rebind'] = 'tiny_init(\''.$textareas_id.'\');';

		$ci->jquery_pagination->initialize($config);
		$page_links = preg_replace('/<delete>.*?<\/delete>/s','',$this->jquery_pagination->create_links());	
		
		return $page_links;
    }	
	
		
}