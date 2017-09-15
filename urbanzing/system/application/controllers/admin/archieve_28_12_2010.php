<?php
//for MLM
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class archieve extends MY_Controller
{
   	function __construct()
	{
        parent::__construct();
    }

    function index($order_name = 'cr_date', $page=0 )
	{
		
		$this->check_user_page_access('registered');
		$this->load->model('archieve_model');
		$toshow = $this->admin_page_limit;
		$this->data['title'] = 'Archieve list';
		$this->data['order_name'] = $order_name;
		$totRow = $this->archieve_model->count_table_row('urban_archieve_master');
		$this->data['archieve_list'] = $this->archieve_model->get_archieve_list($page,$toshow,'',  $order_name);
		$this->session->set_userdata(array('page_no'=>$page,'order_name'=>$order_name));
		#====  Pagination [Starts] ===================================================================
		$this->load->library('pagination');
		$config['base_url'] = base_url()."admin/archieve/index/".$order_name;
		//$config['base_url'] = base_url()."archieve/index/".$order_name;
		$config['total_rows'] = $totRow;
		$config['per_page'] = $toshow;
		$config['uri_segment']=5;
		$this->pagination->initialize($config);
		$this->data['pagination_link'] = $this->pagination->create_links();
		#====  Pagination [End] ======================================================================
		$this->set_include_files(array('common/admin_menu','archieve/archieve_list'));
        $this->render();
	}
	
	function save_to_archieve()
	{
		
		$this->check_user_page_access('registered');
		$this->load->model('article_model');
		$this->load->model('business_model');
		$this->load->model('archieve_model');
		$home_page_text  			=	$this->article_model->get_article_list(-1, 0, -1, '', 1, 'home_page_text');
		$title 						=	$home_page_text[0]['title'];
		
		/*var_dump($home_page_text);
		echo $title;exit;*/
		#============== MAKING TITLE AS ASEO FRIENDLY URL====================================================================
		$splsearch = array(",",".","@","~","`","!","%","$","#","&","*","(",")",":",";"," ","'","+",">","<",".","?","+","-");
  		$splreplace = array("","","","","","","","","","","","","","","","_","","","","","","","","");
		$url = trim($title);
		$url = strtolower(str_replace($splsearch,$splreplace,$url));
		//echo $url;
		#============== MAKING TITLE AS ASEO FRIENDLY URL=====================================================================
		
		#============ Checking this url already exist of not     =================================
		$exist = $this->archieve_model->check_url_exist($url);
		$i = 1;
		$url_new = $url;
		while( $exist > 0 )
		{
			$url_new = $url.$i;
			$exist = $this->archieve_model->check_url_exist($url_new);
			$i++;
		}
		$url = $url_new;
		#=============================================================================================
		$description 				=	$home_page_text[0]['description'];
		$arr						=	array('title'=>$title,'url'=> $url,'home_text'=>$description,'cr_date'=>time());
		$archieve_id 				=	$this->archieve_model->set_data_insert('urban_archieve_master', $arr);
		$arr 						= 	array('status'=>1);
		$img_list					= 	$this->business_model->get_home_page_image_list($arr, 5, 0);
		
		foreach($img_list as $key=>$value)
		{
			$arr = array('archieve_id'=>$archieve_id,'img_description'=>$value['description'], 'img_name'=>'corousel_'.$key.time().$value['img_name']);
			
			  $source = BASEPATH.'../images/uploaded/business/thumb/'.$value['img_name'];
			  $destination = BASEPATH.'../images/archieve/'.$arr['img_name'];
			if(copy($source, $destination ))
			{
					
				$this->archieve_model->set_data_insert('urban_archieve_picture', $arr);
			}	
			
		}
		
		$arr = array('featured'=>'Y', 'status'=>1);
		$featured_business			= $this->business_model->get_business_list($arr, -1, 0);
		
		foreach($featured_business as $key)
		{
			$arr = array('archieve_id'=>$archieve_id,
							'business_id'=>$key['id'],
							'business_title'=>$key['name'],
							'cusine'=>$key['cuisine'],
							'editorial_comment'=>$key['editorial_comments'],
							'image_name'=>'features_'.$archieve_id.'_'.$key['cover_image']
							
			);
			
			
			$source = BASEPATH.'../images/uploaded/business/thumb/'.$key['cover_image'];
			$destination = BASEPATH.'../images/archieve/'.$arr['image_name'];
			if(copy($source, $destination ))
			{
				$this->archieve_model->set_data_insert('urban_archieve_business', $arr);
			}	
			
		}
		$this->session->set_userdata(array('message'=>"Archieved successfully.",'message_type'=>'succ'));
        header("location:".base_url().'admin/archieve/index');
        exit;
		
			
	}
	
	function delete_archieve( $id = -1)
	{
		
		$this->check_user_page_access('registered');
		$page_no 	= $this->session->userdata('page_no');
		$order_name = $this->session->userdata('order_name');
		$this->session->unset_userdata(array('page_no'=>'','order_name'=>''));
		//$this->data['order_name'] = $order_name;
		$arr = array('archieve_id'=>$id);
		$this->load->model('archieve_model');
		
		$image_list_corousel = $this->archieve_model->get_archieve_image_list('urban_archieve_picture', $arr);
		foreach($image_list_corousel as $key=>$value)
		@unlink(BASEPATH.'../images/archieve/'.$value['img_name']);
		
		$image_list_features = $this->archieve_model->get_archieve_image_list('urban_archieve_business', $arr);
		foreach($image_list_features as $key=>$value)
		@unlink(BASEPATH.'../images/archieve/'.$value['image_name']);
		
		$this->archieve_model->set_data_delete('urban_archieve_master', $id); 
		$this->archieve_model->set_data_delete('urban_archieve_picture', $arr); 
		$this->archieve_model->set_data_delete('urban_archieve_business', $arr); 
		
		$total_rows = $this->archieve_model->count_table_row('urban_archieve_master');
		if( $page_no >=  $total_rows && $page_no !=0)  $page_no = $page_no - $this->admin_page_limit; 
		$this->session->set_userdata(array('message'=>"Deleted Successfully",'message_type'=>'succ'));
		header("location:".base_url().'admin/archieve/index/'.$order_name);
        exit;
	}
	
}
