<?php

/*********
* Author: Arka
* Date  : Feb 2013
* Modified By:  
* Modified Date
* Purpose: 
* Frontend Test Menu Page
* @includes My_Controller.php
*/
//include_once(APPPATH.'helpers/mail_helper.php');

class store extends My_Controller
{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;

    public function __construct()
    {
        try
        {
			parent::__construct();
			$this->conf       	                =   & get_config();
			$this->data['title']                = "All Store";	
			$this->pathtoclass = base_url().$this->router->fetch_class()."/";//for redirecting from this class
			$this->cls_msg["contact_us_succ"]   ="Your contact information has been sent to us. We will comming to you soon.";
			$this->load->model('store_model');	
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
			$this->data['title'] 		= "Store";
			$this->data['header']		= 3;
			$this->data['footer']		= 3;
			/*$s_where = " WHERE s_store_title  LIKE 'a%'";
			$start=0;
			$limit=6;
			$order_by='s_store_title';*/
			
			$this->data['popular_store'] = $this->store_model->get_list(array('i_is_active' => '1', 'i_is_hot' => 1), 'i_id,s_store_title,s_url,s_store_logo,s_cash_back');
			
			ob_start();
				$this->ajax_store_list();
				$contents = ob_get_contents();
			ob_end_clean();

            $this->data['result']=$contents;			
			$this->render($this->data, 'store/store.tpl.php');
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
	}

	function ajax_store_list()
	{
		$charecter= $this->input->post('data');	

		$start=0;			
		$limit = '';
		$s_order_name='s_store_title';			
		$order_by	= 'asc';
		if($_POST)
		{
			if($charecter=='1')
			{
				$s_where =" WHERE i_is_active=1 AND s_store_title REGEXP '^[0-9]+'";
			}
			else
			{
				$s_where = " WHERE i_is_active=1 AND s_store_title  LIKE '".$charecter."%'";
			}
		}
		else
		{
			$s_where		= " WHERE i_is_active=1";
		}
		
		$store_list	 = $this->store_model->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);

		//pr($store_list,1);

		$arr_alphabet	= array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

		$i=0;	

		foreach($store_list as $alpha_key=>$alphabet)
		{
			$cur_letter							= strtoupper(substr($alphabet['s_store_title'],0,1));
			$store_list[$alpha_key]['alpha']	=	$cur_letter ;	
		}		

		$this->data['store_list']	= $store_list;	

		//pr($this->data['store_list']);		
		
		if(!empty($this->data['store_list']))
		{
			foreach($this->data['store_list'] as $key=>$val)
			{
				$meta_title			= $val['s_meta_title'];
				$meta_description	= $val['s_meta_description'];
				$meta_keyword 		= $val['s_meta_keyword'];
			}		
	
			$this->data['meta_title']			  = $meta_title;
			$this->data['meta_description']		  = $meta_description;
			$this->data['meta_keyword']			  = $meta_keyword;
		}

		//pr($this->data['meta_title']);

		echo $this->load->view('store/ajax_store_list.tpl.php',$this->data);
	}
	

    public function __destruct()
    {}           

}