<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 10 Dec 2012
* Modified By: 
* Modified Date: 
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/
//include dirname(BASEPATH)."/paint/php/page_template.php";

class Home extends My_Controller
{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public function __construct()
    {
        try
        { 
          parent::__construct(); 
          $this->data['title'] = "Home";////Browser Title
		  $this->data['ctrlr'] = "home";		
          $this->cls_msg=array();
		  $this->cls_msg["no_result"]				= "No information found."; 
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		 
		  $this->load->model('common_model','mod_common');		 
		  $this->load->model('site_setting_model','mod_setting'); 
		  $this->load->model('user_model','mod_user');		  
		  $this->load->model('book_category_model','mod_book_cat');		  
		  //redirect(base_url().'admin/home/');
		  //redirect(base_url().'show_book/');
		  //echo makeOptionFontFamilyPaint();exit;
		  //echo makeOptionFontSizePaint();exit;
		 /* $ljson = '{"width":320,"height":480,"backgroundColor":"#f5f5f5","elements":[{"type":"imagebox","param":{"src":"images/small_plus.png","border":"1px black solid","width":24,"height":24,"cx":12,"cy":12,"doNotShowCount":true,"html":"<IMG src=\"########\"/>","angle":0,"dragable":true,"overAllAspectRatio":false,"diagonalAspectRatio":false,"zoomEnabled":false,"zIndex":100100,"Dx":0,"Dy":0}}],"elementTypes":{"dummystart":0,"imagebox":1,"dummyend":0}}';		  
		  
		  $rjson = '{"width":320,"height":480,"backgroundColor":"#f5f5f5","elements":[{"type":"imagebox","param":{"src":"images/small_plus.png","border":"1px black solid","width":24,"height":24,"cx":308,"cy":12,"doNotShowCount":true,"html":"<IMG src=\"########\"/>","angle":0,"dragable":true,"overAllAspectRatio":false,"diagonalAspectRatio":false,"zoomEnabled":false,"zIndex":100100,"Dx":0,"Dy":0}}],"elementTypes":{"dummystart":0,"imagebox":1,"dummyend":0}}';
		  	$pt = new PageTemplate();
			$result_im = $pt->get_image_rs($rjson);
			$s_file_name = '222.png';
			if($result_im)
			{
				header('Content-type: image/png');
				imagepng($result_im,$s_file_name);
				imagedestroy($result_im);
			}*/
		 
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	public function category($category_name, $start = "")
	{
		$this->index($start,"category", $category_name);
	}
	
	public function popular($type, $start = "")
	{
		$this->index($start,$type );
	}
	
	public function search($keyword, $start = "")
	{
		if(trim($keyword)=='')
			redirect(base_url());
			
		$this->index($start,'search', '', $keyword);
	}
	
	public function curl_done()
	{
		$_SESSION['show_curl_done']= true;
	}
	
    public function index($start = "",$type = "",  $category_name="", $keywords = "")
    {
		
		
		/*echo $type,$start,$category_name;
		//exit;*/
		if($keywords=$this->input->get('keyword')){
			$type='search';
		}
		if($paging=$this->input->get('paging')){
			$start=str_replace('/','',$paging);
		}
		$this->data['show_curl'] = false;
		if(!$_SESSION['show_curl_done'])
		{
			$this->data['show_curl'] = true;
		}
		
		
        try
        {	
			$this->session->unset_userdata('model_session');
			$this->data['category_menu_available'] = 1;	// to show category menu on left panel
			
			
			$this->data['broadcast_message'] = $this->mod_setting->fetch_this("NULL");
			//pr($this->data['broadcast_message']);
			
			/*************** FETCH ALL BOOK CATEGORY ****************/
			$s_where = " WHERE c.i_status = 1 ";
			$this->data["book_category"] = $this->mod_book_cat->fetch_multi($s_where);
			$this->data["total_cat"]	 =	count($this->data["book_category"]);
			
			/*************** END FETCH ALL BOOK CATEGORY ****************/
			
			ob_start();			
				//$this->ajax_pagination_book_list(0,1);
				$this->ajax_pagination_book_list($start,0,$type,$category_name,$keywords);
				$contents = ob_get_contents();
			ob_end_clean();
			
			//$book_list = explode('^',$contents);			
			//$this->data['book_list'] = $book_list[0];
			$this->data['book_list'] = $contents;
			
			//$this->load->view('fe/home/index.tpl.php',$this->data);		
			$this->render('home/index');
			ob_flush();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/* ajax call to get books data */
	function ajax_pagination_book_list($start=0,$param=0,$type="",$category_name="",$keywords="") 
	{			
		$s_where = '';		
		$s_order = '';
		//$arr_search[] = " d.i_status=1 AND d.i_pages>2 ";
		$arr_search[] = " d.i_status=1 AND d.user_status = 1 ";
		
		$this->data['loggedin'] = $this->session->userdata('loggedin');
		
		/*************************** NORMAL PAGINATION QUERY ************************/
		if($type=='category' && $category_name!='')
		{
			$cat_arr = $this->mod_book_cat->fetch_category_id($category_name);
		
			if(!empty($cat_arr))
			{
				$arr_search[] = " d.i_book_category = '".$cat_arr['id']."' ";
				$this->data['srch_category'] = $cat_arr['s_category'];
				$this->data['type'] = $type;
			}
			else
			{
				$type = "";
				$category_name = "";
				redirect(base_url());
			}
		}
		else if($type=='search')
		{
			if(trim($keywords))
			{				
				$keywords = urldecode($keywords);
				$this->data['srch_keyword'] = $keywords;
				
				$arr_key_compound = create_compound_keywords_for_search($keywords,4);
				
				$tmp_search = " ( 0 ";
				foreach($arr_key_compound as $k => $v)
				{
					$tmp_search .= 	"  OR (d.s_category LIKE '%".my_receive_text($v)."%')
										OR (d.s_keyword LIKE '%".my_receive_text($v)."%')
										OR (d.s_username LIKE '%".my_receive_text($v)."%')
										OR (d.s_name LIKE '%".my_receive_text($v)."%')
										OR (d.s_full_name LIKE '%".my_receive_text($v)."%')
									 ";
				}
				$tmp_search .= " ) ";
				
				$arr_search[] = $tmp_search;
			}
			else
			{
				redirect(base_url());
			}
		}
		else if($type!='')
		{
			if($type=='most-sparkled')
			{
				$s_order .= " ORDER BY d.i_likes DESC, d.i_featured DESC, d.dt_created DESC ";
				$this->data['srch_type'] = "Most Sparkled";
			}
			else if($type=='most-commented')
			{
				$s_order .= " ORDER BY d.i_comments DESC, d.i_featured DESC, d.dt_created DESC ";
				$this->data['srch_type'] = "Most Commented";
			}
			else if($type=='most-viewed')
			{
				//$s_order .= " ORDER BY d.i_comments DESC ";
				$s_order .= " ORDER BY d.i_most_view DESC, d.i_featured DESC, d.dt_created DESC ";
				$this->data['srch_type'] = "Most Viewed";
			}
			else
			{
				//$s_order = "ORDER BY d.i_likes DESC, d.dt_created DESC";
				$s_order = "ORDER BY d.i_featured DESC, d.dt_created DESC";
			}
			$this->data['type'] = "popular";
			
		}
		else
		{
			$type = "";
			$category_name = "";
		}
		
		/*************************** NORMAL PAGINATION QUERY ************************/
		
		
		$s_where .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
		if($s_order)
		{
			$s_order = $s_order;
		}
		else
		{
			$s_order =  " ORDER BY d.i_featured DESC, d.dt_created DESC ";
		}
		
		//$limit				   = 6; 
		$limit				   = 30; 
		$this->data['book_list'] = $this->mod_user->fetch_all_collections($s_where,intval($start),$limit,$s_order);
		//$total_rows 			  = count($this->mod_user->gettotal_collections($s_where));
		$total_rows 			  = ($this->mod_user->gettotal_collections($s_where,true));
		
		//pr($this->data['book_list'],1);
		/* pagination start @ defined in common-helper */
		//$ctrl_path 	= base_url().'home/ajax_pagination_book_list/';
		if($type=="" && $category_name=="")		
			$ctrl_path 	= base_url().'';
		else if($type=="category")
			$ctrl_path 	= base_url().'category/'.$category_name.'/';
		else if($type=="search")
			$ctrl_path 	= base_url().'search/?keyword='.$keywords.'&paging=';	
		else
			$ctrl_path 	= base_url().$type.'/';	
			
		$paging_div = 'book_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div, false);
		$this->data['total_rows'] 	= $total_rows;
		$this->data['start'] 		= $start;
		
		if(empty($param))
			$job_vw = $this->load->view('fe/home/ajax_pagination_book_list.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/home/ajax_pagination_book_list.tpl.php',$this->data,TRUE).'^'.$total_rows;
		echo $job_vw;
		/* pagination end */

	
	}
	
	public function cms($param)
    {
        try
        {	
			switch($param)
			{
				case "about":								
					$i_cms_id = 1;	
					break;	
				
				case "privacy-policy":
					$i_cms_id = 2;	
					break;
				
				default :	
					$i_cms_id = 1;	
			}	
			
			$this->load->model('cms_model','mod_cms');	
			$this->data['info'] = $this->mod_cms->fetch_this($i_cms_id);  // fetch cms contents
			$this->data['i_cms_type'] = $i_cms_id;
			//$this->load->view('fe/home/cms.tpl.php',$this->data);			
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	public function faq()
    {
        try
        {
			$this->load->model('faq_model','mod_faq');	
			$s_where = " WHERE n.i_status = 1 ";
			$this->data['faq'] = $this->mod_faq->fetch_multi($s_where);  // fetch cms contents
			
			//$this->load->view('fe/home/faq.tpl.php',$this->data);			
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	/* end faq */
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/home.php */

