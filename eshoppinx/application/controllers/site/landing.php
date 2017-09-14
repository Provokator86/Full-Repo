<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * Landing page functions
 * @author Teamtweaks
 *
 */

class Landing extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('product_model');
		
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->product_model->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];
		
		if($_SESSION['sColorLists'] == ''){
			$_SESSION['sColorLists'] = $this->product_model->get_all_details(LIST_VALUES,array('list_id'=>'1'));
		}
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];
		
		$this->data['loginCheck'] = $this->checkLogin('U');
//		echo $this->session->userdata('fc_session_user_id');die;
		$this->data['likedProducts'] = array();
	 	if ($this->data['loginCheck'] != ''){
	 		$this->data['likedProducts'] = $this->product_model->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
	 	}
	 	
    }
    
    /**
     * 
     * 
     */
   	public function index(){
   		if ($this->checkLogin('U')==''){
		 	$this->data['heading'] = '';
		 	$this->data['totalProducts'] = $this->product_model->get_total_records(PRODUCT);
			$this->data['SliderDisplay'] = $this->product_model->get_slider_details("Where status='Active'");
		 	$condition = " where p.status='Publish' and u.group='Seller' and u.status='Active' or p.status='Publish' and p.user_id=0 order by p.created desc limit 60";
			$products_list_s = $this->product_model->view_product_details($condition);
			
			$condition = " where p.status='Publish' limit 60";
			$products_list_u = $this->product_model->view_notsell_product_details($condition);
			
			$this->data['productDetails'] = $this->product_model->get_sorted_array($products_list_s,$products_list_u,'created','desc');        
            
            ############################### below new coding 22 dec #############################
            $this->data["flag_display_sub"] = TRUE; // to display sitename collection home page
            if($this->input->get('pg') != ''){
            $paginationVal = $this->input->get('pg')*100;
            $limitPaging = $paginationVal.',100 ';
            } else {
                $limitPaging = ' 0,100';
            }

            $condition = " where p.status='Publish' and u.group='Seller' and u.status='Active' or p.status='Publish' and p.user_id=0 order by p.created desc limit ".$limitPaging;
            $products_list_s = $this->product_model->view_product_details($condition);

            $condition = " where p.status='Publish' order by p.created desc limit ".$limitPaging;
            $products_list_u = $this->product_model->view_notsell_product_details($condition);

            $this->data['products_list'] = $this->product_model->get_sorted_array($products_list_s,$products_list_u,'likes','desc');

            $newPage = $this->input->get('pg')+1;
            $qry_str = '?pg='.$newPage;
            //$url = base_url().'recent'.$qry_str;
            $url = base_url('site/landing').$qry_str;
            if (count($this->data['products_list'])==0) $url = '';
            $paginationDisplay  = '<a title="'.$newPage.'" class="btn-more" href="'.$url.'" style="display: none;">See More Products</a>';
            $this->data['paginationDisplay'] = $paginationDisplay;
            
		 	$this->load->view('site/landing/landing',$this->data);
   		}else {
   			$this->session->keep_flashdata('sErrMSGType');
 			$this->session->keep_flashdata('sErrMSG');
   			redirect('trending');
   		}
	}
	
	public function load_onboard_stores(){
		$store_lists = $this->product_model->get_all_details(USERS,array('group'=>'Seller','status'=>'Active'));
		if ($store_lists->num_rows()>0){
			$returnCnt = '';
			foreach ($store_lists->result() as $store_lists_row){
				$prodDetails = $this->product_model->get_all_details(PRODUCT,array('status'=>'Publish','user_id'=>$store_lists_row->id,'quantity >'=>0));
				$userImg = 'default_user.jpg';
				if ($store_lists_row->thumbnail != ''){
					if (file_exists('images/users/'.$store_lists_row->thumbnail)){
						$userImg = $store_lists_row->thumbnail;
					}
				}
				$store_name = $store_lists_row->full_name;
				if ($store_name == ''){
					$store_name = $store_lists_row->user_name;
				}
				$returnCnt .= '
				<div class="follow_main">
                
                	<div class="left_follow">
                    
                    	<span class="follow_icon"><img src="images/users/'.$userImg.'" /></span>
                        
                        <a class="follow_icon_links">'.$store_name.'</a>
                        <div class="clear"></div>
                        
                        <span class="follow_count">'.$store_lists_row->followers_count.' followers</span>
                    
                    
                    </div>
                    
                    <div class="right_follow">
                    
                   	 	<a class="follow_btn" data-uid="'.$store_lists_row->id.'" onclick="javascript:onboard_store_follow(this);">Follow</a>
                        
	              	</div>	
                    
                    
     			<ul class="product_popup_follow">';
				if ($prodDetails->num_rows()>0){
					$limitCount = 0;
					foreach ($prodDetails->result() as $prodDetails_row){
						if ($limitCount==8)break;$limitCount++;
						$prodImg = 'dummyProductImage.jpg';
						$prodImgArr = array_filter(explode(',', $prodDetails_row->image));
						if (count($prodImgArr)>0){
							foreach ($prodImgArr as $prodImgArrRow){
								if (file_exists('images/product/'.$prodImgArrRow)){
									$prodImg = $prodImgArrRow;
									break;
								}
							}
						}
						$returnCnt .= '<li><a><img src="images/product/'.$prodImg.'" /></a></li>';
					}
				}
                
                      $returnCnt .= '</ul>
                
                </div>    
				';
			}
		}else {
			$returnCnt = '<p>No stores available</p>';
		}
		echo $returnCnt;
	}
	
	public function load_onboard_peoples(){
		$store_lists = $this->product_model->get_all_details(USERS,array('group'=>'User','status'=>'Active'));
		if ($store_lists->num_rows()>0){
			$returnCnt = '';
			foreach ($store_lists->result() as $store_lists_row){
				$saved_products = '';
				if ($store_lists_row->likes>0){
					$Qry = "select p.image from ".PRODUCT_LIKES." pl JOIN ".PRODUCT." p on p.seller_product_id=pl.product_id where pl.user_id=".$store_lists_row->id;
					$saved_products = $this->product_model->ExecuteQuery($Qry);
				}
				$userImg = 'default_user.jpg';
				if ($store_lists_row->thumbnail != ''){
					if (file_exists('images/users/'.$store_lists_row->thumbnail)){
						$userImg = $store_lists_row->thumbnail;
					}
				}
				$store_name = $store_lists_row->full_name;
				if ($store_name == ''){
					$store_name = $store_lists_row->user_name;
				}
				$returnCnt .= '
				<div class="follow_main">
                
                	<div class="left_follow">
                    
                    	<span class="follow_icon"><img src="images/users/'.$userImg.'" /></span>
                        
                        <a class="follow_icon_links">'.$store_name.'</a>
                        <div class="clear"></div>
                        
                        <span class="follow_count">'.$store_lists_row->followers_count.' followers</span>
                    
                    
                    </div>
                    
                    <div class="right_follow">
                    
                   	 	<a class="follow_btn" data-uid="'.$store_lists_row->id.'" onclick="javascript:onboard_user_follow(this);">Follow</a>
                        
	              	</div>	
                    
                    
     			<ul class="product_popup_follow">';
				if ($saved_products!='' && $saved_products->num_rows()>0){
					$limitCount = 0;
					foreach ($saved_products->result() as $prodDetails_row){
						if ($limitCount==8)break;$limitCount++;
						$prodImg = 'dummyProductImage.jpg';
						$prodImgArr = array_filter(explode(',', $prodDetails_row->image));
						if (count($prodImgArr)>0){
							foreach ($prodImgArr as $prodImgArrRow){
								if (file_exists('images/product/'.$prodImgArrRow)){
									$prodImg = $prodImgArrRow;
									break;
								}
							}
						}
						$returnCnt .= '<li><a><img src="images/product/'.$prodImg.'" /></a></li>';
					}
				}
                
                      $returnCnt .= '</ul>
                
                </div>    
				';
			}
		}else {
			$returnCnt = '<p>No peoples available</p>';
		}
		echo $returnCnt;
	}
	
}

/* End of file landing.php */
/* Location: ./application/controllers/site/landing.php */