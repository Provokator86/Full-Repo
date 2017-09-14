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
  
	public function display_category_BKUP_old13jan2015(){
		$this->data['heading'] = 'Category';
		$catseo = $this->uri->segment(2,0);
		$this->data['categotyDetail'] = $this->product->get_all_details(CATEGORY,array('seourl'=>$catseo));
		// on jan 2015
        $this->data['parent_cat_url'] = $catseo;
		
		
		if($this->data['categotyDetail']->row()->id !=''){
            // on jan 2015 sub categories
            $parent_cat_id = $this->data['categotyDetail']->row()->id;
            $subCatList = $this->db->query('select seourl,cat_name,id from '.CATEGORY.' where `status`="Active" AND rootID="'.$parent_cat_id.'" ');
            $this->data['sub_cat'] = $subCatList->result_array();
            //pr($this->data['sub_cat']);
            
            $allStores = $this->product->get_top_stores();            
            $this->data['allStores'] = $allStores['store_lists']->result();
            //pr($this->data['allStores'],1);
            
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
			//$url = base_url().'trending'.$qry_str;
            $url = base_url().'category/'.$catseo.$qry_str;
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
    
    
    public function display_category(){
        $this->data['heading'] = 'Category';
        $catseo = $this->uri->segment(2,0);
        $this->data['categotyDetail'] = $this->product->get_all_details(CATEGORY,array('seourl'=>$catseo));
        // on jan 2015
        $this->data['parent_cat_url'] = $catseo;
        
        
        if($this->data['categotyDetail']->row()->id !=''){
            // on jan 2015 sub categories
            $parent_cat_id = $this->data['categotyDetail']->row()->id;
            $subCatList = $this->db->query('select seourl,cat_name,id from '.CATEGORY.' where `status`="Active" AND rootID="'.$parent_cat_id.'" ');
            $this->data['sub_cat'] = $subCatList->result_array();
            //pr($this->data['sub_cat']);
            
            $allStores = $this->product->get_top_stores();            
            $this->data['allStores'] = $allStores['store_lists']->result();
            //pr($this->data['allStores'],1);
            
            $allBrands = array();
            if($parent_cat_id)
            {
                $category_id_str = select_chain_category_ids($parent_cat_id);
                $category_id_str = ltrim($category_id_str,',');
                if($category_id_str)
                {
                    $cat_where = " WHERE p.category_id IN({$category_id_str}) AND p.brand_name IS NOT NULL ";
                    $allBrands = $this->product->get_distinct_brand_list($cat_where); 
                }     
            }
            $this->data['allBrands'] = $allBrands;            
            //pr($this->data['allBrands'],1);
            
            $this->session->unset_userdata('product_list_where');
            ob_start();
                $this->ajax_pagination_product_list($parent_cat_id, 0,0);
                $product_list    = ob_get_contents();
            ob_end_clean();
            $this->data['product_list']=$product_list;
    
            $this->load->view('site/trending/display_category',$this->data);
        }else{
            redirect(base_url());
        }
    }
    
    function ajax_pagination_product_list($c_id=0, $start=0,$param=0)
    {
        $IF_POSTED_FLAG = false;             
        # NEW
        $this->data['next_record_pointer'] = ( !empty($start) )? $start+1: $start+2;        
        #$start--;
        $start = ( !empty($start) )? $start-1: 0;
        #echo "--". $start;
        $start = $start * 20;
        #echo "++". $start;
        $s_where        = "";
        $s_order        = "";
        $limit          = 20; 
        //echo $c_id.'===start==='.$start;
        $current_cat_id = $c_id; 
        $prev_cat_id = $this->session->userdata('prev_cat_id');
        if( !empty($c_id) ) 
        {
           $category_id_str = select_chain_category_ids($c_id);
           $category_id_str = ltrim($category_id_str,',');
           
           $this->session->set_userdata('prev_cat_id',$c_id);
           if($prev_cat_id!=$c_id)
           {
               //$this->session->unset_userdata('product_list_where');
           }           
           if($category_id_str)
           $cat_where = " AND p.category_id IN({$category_id_str}) ";
       }       
        
       
        /************************ START POSTED/NON-POSTED VALUES **********************/
        if($_POST && !in_array('t',$_POST))
        {
            $IF_POSTED_FLAG = true;
            
            $posted                 =    array();                            
            $str_category           = $this->input->post('str_category'); 
            $arr_store              = $this->input->post('arr_store');  
             
            $chk_price              = $this->input->post('arr_price'); 
            $arr_price              = explode(",",$chk_price); 
            
            $str_brand              = $this->input->post('str_brand');  
            $arr_brand              = explode(",",$str_brand);  
            //pr($arr_price);
            if($s_type=='where') 
            {
                $this->session->unset_userdata('product_list_where');                    
            }
            
            // search by brand
            $condition  =   '' ;
            if (!empty($arr_brand) && $arr_brand[0]!='') 
            {
                 //$condition  .= "AND p.brand_name IN ('".$arr_brand."') ";
                 $brand_where = "";
                 foreach($arr_brand as $bv)
                 {
                     $brnd_search[] = " p.brand_name='".$bv."' ";
                 }
                 $brand_where .= (count($brnd_search) !=0)?' AND ('.implode('OR',$brnd_search).' )':'';
                 $condition  .= $brand_where;
            }
            $s_where    .= trim($condition).'  ' ;  
            
            // search by store
            $condition  =   '' ;
            if (!empty($arr_store)) 
            {
                 //$condition  .= "AND p.i_store_id IN ({$arr_store}) ";
                 $condition  .= "AND b.id IN ({$arr_store}) ";
            }
            $s_where    .= trim($condition).'  ' ;  
            
            if(trim($s_where)!='') 
            {
                $this->session->set_userdata('product_list_where',$s_where);
            }
            
            // search by price
            $condition  =   '' ;
            if(!empty($arr_price) && $arr_price[0]!='')                
            {
                $arr_where = '';
                foreach($arr_price as $val)
                {
                    $range_arr = explode('-',$val);
                    //pr($range_arr);
                    if(!empty($range_arr))    
                    {
                            if($range_arr[0]=='5001')
                                $arr_search[] =" p.price >=5001 ";
                            else
                            {
                                $arr_search[]  = " p.price >= {$range_arr[0]} AND p.price<= {$range_arr[1]} ";
                            }
                    }
                }
                $arr_where .= (count($arr_search) !=0)?' AND ('.implode('OR',$arr_search).' )':'';                
                $condition  .= $arr_where;
                //echo $arr_where.'</br>';
            }
            $s_where    .= trim($condition).'  ' ;
            
            
            
            
        }
        else if($_POST && in_array('t',$_POST))
        {
            $s_where = $this->session->userdata('product_list_where');            
        }
        else 
        {  
           if($this->session->userdata('product_list_where'))
            {
                $s_where    =   $this->session->userdata('product_list_where'); 
            }                    
        }
        /************************ END POSTED/NON-POSTED VALUES **********************/
        
        if($s_where)        
        {
            $this->session->set_userdata('product_list_where',$s_where);
        }        
        if($this->session->userdata('product_list_where') && trim($s_where)=='')
        {
            $s_where    =   $this->session->userdata('product_list_where');
        }
        
        $s_where  = " AND p.status = 'Publish' ".$s_where.$cat_where;  // testing purpose
        $s_where   = preg_replace('/^AND/','WHERE ',trim($s_where));    
        //echo $s_where.'<br/>==>';            
                    
        $this->data['product_list']= $this->product->get_product_list($s_where, intval($start), $limit);        
        $total_rows = $this->product->count_product_list($s_where);
        //pr($this->data['product_list'],1);                
        /* pagination start @ defined in common-helper */
        $ctrl_path                    = base_url().'category/ajax_pagination_product_list/';
        $paging_div                   = 'product_ajax';
        $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
        $this->data['total_rows']     = $total_rows;
        $this->data['start']          = $start;            
        $this->data['category_id_src']= $c_id;
        //$list_vw = $this->load->view('fe/category/ajax_product_list.tpl.php',$this->data,TRUE);
        $list_vw = $this->load->view('site/trending/ajax_pagination_product_list',$this->data,TRUE);
        
        echo $list_vw;
    }
}
/*End of file trending.php */
/* Location: ./application/controllers/site/trending.php */