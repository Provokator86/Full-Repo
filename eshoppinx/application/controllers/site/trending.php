<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Trending related functions
 * @author Teamtweaks
 *
 */

class Trending extends MY_Controller {
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

	public function index(){

		$cate_split=array_filter(explode('-',$this->input->get('c')));

		$price_split = array_filter(explode('-',$this->input->get('p')));

		$this->data['heading'] = 'Trending';

		if($this->input->get('pg') != ''){
			$paginationVal = $this->input->get('pg')*50;
			$limitPaging = $paginationVal.',50 ';
		} else {
			$limitPaging = ' 0,50';
		}

		$filter_condition = '';
		$cat_id_arr = array();
		if (count($cate_split)>0){
			foreach ($cate_split as $cat_row){
				$cateResult = $this->product->get_all_details(CATEGORY,array('seourl'=>$cat_row));
				if ($cateResult->num_rows()>0){
					$cat_id_arr[] = $cateResult->row()->id;
				}
			}
		}
		if (count($cat_id_arr)>0){
			foreach ($cat_id_arr as $cat_id_row){
				if ($filter_condition!=''){
					$filter_condition .= ' or ';
				}else {
					$filter_condition = ' and (';
				}
				$filter_condition .= ' FIND_IN_SET("'.$cat_id_row.'",p.category_id)';
			}
		}
		if ($filter_condition!=''){
			$filter_condition .= ')';
		}

		$price_condition = '';
		$low_price=1000;
		$medium_price=1500;
		$high_price=5000;
		if (count($price_split)>0){
			foreach ($price_split as $price_row){
				if ($price_condition!=''){
					$price_condition .= ' or ';
				}else {
					$price_condition = ' and (';
				}
				if ($price_row == 'low'){
					$price_condition .= ' p.price < '.$low_price;
				}elseif ($price_row == 'medium'){
					$price_condition .= ' ( p.price > '.$low_price.' and p.price < '.$medium_price.' ) ';
				}elseif ($price_row == 'high') {
					$price_condition .= ' p.price > '.$medium_price;
				}
			}
		}
		if ($price_condition!=''){
			$price_condition .= ')';
		}
		$condition = " where p.status='Publish' and u.status='Active' ".$filter_condition.$price_condition." or p.status='Publish' and p.user_id=0 ".$filter_condition.$price_condition;

		$products_list = $this->product->get_hotness_products($condition,$limitPaging);
		$this->data['products_list'] = $products_list;

		//echo "<pre>";print_r($products_list->result()); die;

		$newPage = $this->input->get('pg')+1;
		$qry_str = '?pg='.$newPage;
		$url = base_url().'trending'.$qry_str;
		if (count($products_list)==0) $url = '';
		$paginationDisplay  = '<a title="'.$newPage.'" class="btn-more" href="'.$url.'" style="display: none;">See More Products</a>';
		$this->data['paginationDisplay'] = $paginationDisplay;
		
		/**Hash Tags**/
		$this->data['hashtags'] = $this->product->get_trending_hashtags();
		/**Hash Tags**/

		$this->load->view('site/trending/trending_home',$this->data);
	}

	public function recent(){
		$this->data['heading'] = 'Recent Products';
        $this->data['nav_menu'] = 2;

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

	public function popular(){
		$this->data['heading'] = 'Recent Products';
        $this->data['nav_menu'] = 6;

		if($this->input->get('pg') != ''){
			$paginationVal = $this->input->get('pg')*20;
			$limitPaging = $paginationVal.',20 ';
		} else {
			$limitPaging = ' 0,20';
		}

		$condition = " where p.status='Publish' and u.group='Seller' and u.status='Active' or p.status='Publish' and p.user_id=0 order by p.created desc limit ".$limitPaging;
		$products_list_s = $this->product->view_product_details($condition);

		$condition = " where p.status='Publish' order by p.created desc limit ".$limitPaging;
		$products_list_u = $this->product->view_notsell_product_details($condition);

		$this->data['products_list'] = $this->product->get_sorted_array($products_list_s,$products_list_u,'likes','desc');

		$newPage = $this->input->get('pg')+1;
		$qry_str = '?pg='.$newPage;
        //$url = base_url().'recent'.$qry_str;
		$url = base_url().'popular'.$qry_str;
		if (count($this->data['products_list'])==0) $url = '';
		$paginationDisplay  = '<a title="'.$newPage.'" class="btn-more" href="'.$url.'" style="display: none;">See More Products</a>';
		$this->data['paginationDisplay'] = $paginationDisplay;

		$this->load->view('site/trending/popular',$this->data);
	}
	
	public function display_magic(){
		if ($this->checkLogin('U')!=''){

		if($this->input->get('pg') != ''){
			$paginationVal = $this->input->get('pg')*300;
			$limitPaging = $paginationVal.',300 ';
		} else {
			$limitPaging = ' 0,300';
		}
		
		$sql = "select * from ".USERS." where id='".$this->checkLogin('U')."'";
		$query = $this->db->query($sql);
		$magicResult = $query->row_array();
		$magic_cat = $magicResult['magic_cat'];
		
		$sqll = "select * from ".USERS." where id='".$this->checkLogin('U')."' and magic_cat!=''";
		$queryy = $this->db->query($sqll);
		$magicResultt = $queryy->row_array();
		
		//$this->data['magic_queryy']=$this->product_model->get_products_category($magic_cat,$limitPaging);
		
		$this->data['magic_cat_val'] = $queryy->num_rows();
		
		//$products_cate_list = $this->product->get_products_category($magic_cat,$limitPaging);
		
		$this->data['products_cate_list']=$this->product_model->get_products_category($magic_cat,$limitPaging);
		
		$this->load->view('site/trending/display_magic',$this->data);
		
		}else {
			redirect('login?next=magic');
		}
	}
}
/*End of file trending.php */
/* Location: ./application/controllers/site/trending.php */