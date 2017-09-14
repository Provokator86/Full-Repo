<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * Trending related functions
 * @author Teamtweaks
 *
 */

class Category extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email','text'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('product_model','product');
		
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->product->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];
		
		if($_SESSION['sColorLists'] == ''){
			$_SESSION['sColorLists'] = $this->product->get_all_details(LIST_VALUES,array('list_id'=>'1'));
		}
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];
		
		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['likedProducts'] = array();
	 	if ($this->data['loginCheck'] != ''){
	 		$this->data['likedProducts'] = $this->product->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
	 	}
    }
  
	public function display_category(){
		$this->data['heading'] = 'Category';
		$catseo = $this->uri->segment(2,0);
		$this->data['categotyDetail'] = $this->product->get_all_details(CATEGORY,array('seourl'=>$catseo));
		
		
		
		if($this->data['categotyDetail']->row()->id !=''){
			if($this->input->get('pg') != ''){
					$paginationVal = $this->input->get('pg')*300;
					$limitPaging = $paginationVal.',300 ';
			} else {
					$limitPaging = ' 0,300';
			}
			
			$condition = " where p.status='Publish' and u.group='Seller' and u.status='Active' and p.category_id='".$this->data['categotyDetail']->row()->id."' or p.status='Publish' and p.user_id=0 and p.category_id='".$this->data['categotyDetail']->row()->id."' order by p.likes desc limit ".$limitPaging;
			$products_list_s = $this->product->view_product_details($condition);
	
			$condition = " where p.status='Publish' and p.category_id='".$this->data['categotyDetail']->row()->id."' order by p.likes desc limit ".$limitPaging;
			$products_list_u = $this->product->view_notsell_product_details($condition);
			
			$products_list = $this->product->get_sorted_array($products_list_s,$products_list_u,'likes','desc');
			if (count($products_list)>0){
				foreach ($products_list as $key => $row) {
					$likes[$key] = $row->likes;
					$created[$key]  = $row->created;
				}
				
				array_multisort($likes, SORT_DESC, $created, SORT_DESC, $products_list);
			}
	
			$this->data['products_list'] = $products_list;
			
			$newPage = $this->input->get('pg')+1;
			$qry_str = '?pg='.$newPage;
			$url = base_url().'trending'.$qry_str;
			if (count($products_list)==0) $url = '';
			$paginationDisplay  = '<a title="'.$newPage.'" class="btn-more" href="'.$url.'" style="display: none;">See More Products</a>'; 
			$this->data['paginationDisplay'] = $paginationDisplay;
	
			$this->load->view('site/trending/display_category',$this->data);
		}else{
			redirect(base_url());
		}
	}
  
	public function recent(){
		$this->data['heading'] = 'Recent Products';
		
		if($this->input->get('pg') != ''){
				$paginationVal = $this->input->get('pg')*300;
				$limitPaging = $paginationVal.',300 ';
		} else {
				$limitPaging = ' 0,300';
		}
		
		$condition = " where p.status='Publish' and u.group='Seller' and u.status='Active' or p.status='Publish' and p.user_id=0 order by p.created desc limit ".$limitPaging;
		$products_list_s = $this->product->view_product_details($condition);
		
		$condition = " where p.status='Publish' order by p.created desc limit ".$limitPaging;
		$products_list_u = $this->product->view_notsell_product_details($condition);
		
		$this->data['products_list'] = $this->product->get_sorted_array($products_list_s,$products_list_u,'created','desc');
		
		$newPage = $this->input->get('pg')+1;
 		$qry_str = '?pg='.$newPage;
 		$url = base_url().'recent'.$qry_str;
 		if (count($this->data['products_list'])==0) $url = '';
		$paginationDisplay  = '<a title="'.$newPage.'" class="btn-more" href="'.$url.'" style="display: none;">See More Products</a>'; 
		$this->data['paginationDisplay'] = $paginationDisplay;
		
		$this->load->view('site/trending/recent',$this->data);
	}
}
/*End of file trending.php */
/* Location: ./application/controllers/site/trending.php */