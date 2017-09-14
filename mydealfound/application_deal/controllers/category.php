<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
						
class Category extends MY_Controller {

    //put your code here
	 public $cls_msg;
	 
    public function __construct() 
	{
        parent::__construct();	
		$this->cls_msg["no_result"]    = "No result found.";	
		
		//UpdateCategoryUrl();	
    }
	
    public function index($s_url = '') 
	{
        $data = array('title' => 'Category');
		
		
		if($_SERVER['HTTP_REFERER']=='')
			$this->session->unset_userdata('product_list_where');
		else if (strpos($_SERVER['HTTP_REFERER'],'/category/')== false) {
			$this->session->unset_userdata('product_list_where');
		}
		else if("http://".$_SERVER['SERVER_NAME'].$_SERVER['REDIRECT_URL'] != $_SERVER['HTTP_REFERER']){
			$this->session->unset_userdata('product_list_where');
		}
		
		$this->session->unset_userdata('product_list_where');
		$this->session->unset_userdata('category_id_src');
		
		$cat_id = get_category_id($s_url);
		if($cat_id)
			$this->session->set_userdata('category_id_src',$cat_id);
		else
			redirect(base_url());
		$data['category_id'] 	= $cat_id;
		$data['category_breadcrumb'] 	= get_category_breadcrumb($cat_id);
		
		$s_where = "WHERE i_parent_id = '".$cat_id."' ";
		$data["sub_category"] = $this->product_model->get_sub_category($s_where);
		
		$s_where = "WHERE p.i_cat_id = '".$cat_id."' AND p.i_is_hot =1 ";
		$data["topDealsUnderCat"] = $this->manage_deals_model->get_deals_offers_list($s_where);
		
		
		$all_category_str = select_product_under_category($cat_id);
		$s_where  = " WHERE p.i_is_active = 1 AND p.i_cat_id IN($all_category_str) ";
		
		$all_store = $this->product_model->get_distinct_store_from_product($s_where);
		$data["all_store"]  = array();
		if($all_store!="")
		{
			$s_con = "WHERE i_is_active =1 AND i_id IN ({$all_store}) ";
			$data["all_store"] = $this->product_model->get_all_store($s_con);
		}
		
		$all_brand = $this->product_model->get_distinct_brand_from_product($s_where);
		
		$data["all_brand"] = array();
		if(!empty($all_brand))
		{
			//$s_con = "WHERE i_is_active =1 AND i_id IN ({$all_brand}) ";
			//$data["all_brand"] = $this->product_model->get_all_brand($s_con);
			$data["all_brand"] = $all_brand;
		}
		
		// fetch get parameter values	
		$this->session->unset_userdata('get_param_price');
		$this->session->unset_userdata('get_param_store');
		$this->session->unset_userdata('get_param_brand');
		$this->session->unset_userdata('get_param_subcat');	
		$this->session->unset_userdata('get_param_discount');	
		$this->session->unset_userdata('get_param_deals');	
				
		if($_GET['price']!='')
		{
			$get_param = $_GET['price'];
			$this->session->set_userdata('get_param_price',$get_param);
		}
		else if($_GET['store']!='')
		{
			$get_param = $_GET['store'];
			$this->session->set_userdata('get_param_store',$get_param);
		}
		else if($_GET['brand']!='')
		{
			$get_param = $_GET['brand'];
			$this->session->set_userdata('get_param_brand',$get_param);
		}
		else if($_GET['discount']!='')
		{
			$get_param = $_GET['discount'];
			$this->session->set_userdata('get_param_discount',$get_param);
		}
		else if($_GET['subcat']!='')
		{
			$get_param = $_GET['subcat'];
			$data['category_breadcrumb'] 	= get_category_breadcrumb($get_param);
			$data['sub_category_id']  = $get_param;			
			$s_where = "WHERE i_parent_id = '".$data['sub_category_id']."' ";
			$data["sub_sub_category"] = $this->product_model->get_sub_category($s_where);
		
			$this->session->set_userdata('get_param_subcat',$get_param);
		}
		else if($_GET['deals']!='')
		{
			$get_param = $_GET['deals'];
			$this->session->set_userdata('get_param_deals',$get_param);
		}
		else
		{
			$this->session->unset_userdata('get_param_price');
			$this->session->unset_userdata('get_param_store');
			$this->session->unset_userdata('get_param_brand');
			$this->session->unset_userdata('get_param_subcat');	
			$this->session->unset_userdata('get_param_discount');	
			$this->session->unset_userdata('get_param_deals');			
		}
		// end fetch get parameter values	
		
		ob_start();
			$this->ajax_pagination_product_list(0,0);
			$product_list	= ob_get_contents();
		ob_end_clean();
		$product_list = explode('|^|',$product_list);
		
		$data['product_list'] = $product_list[0];
		$data['total_cnt'] 	= $product_list[1];
        
		$this->render($data);
		//$this->load->view('category/index.tpl.php',$this->data);
    }
	
	 /**
    * This function is ajax pegination function 
    * make the list all pros
    * 
    * @param mixed $start
    * @param mixed $param
    */
    function ajax_pagination_product_list($start=0,$param=0) 
    {
        try
        {
			 # NEW
            #$this->data['next_record_pointer'] = ( !empty($start) )? $start-1: $start+1;
            $this->data['next_record_pointer'] = ( !empty($start) )? $start+1: $start+2;
            #echo "next-record-pointer = {$start}##". $this->data['next_record_pointer'];
            
            #$start--;
            $start = ( !empty($start) )? $start-1: 0;
           	#echo "--". $start;
            $start = $start * 20;
            #echo "++". $start;
            $s_where        = "";
			$s_order		= "";
            $limit          = 20; 
			
            $s_where        = "";
			$s_order		= "";
            $limit          = 20; 
			
			$category_id_src = $this->session->userdata('category_id_src');
			$category_id_str = select_product_under_category($category_id_src);
			if($category_id_str && $this->session->userdata('get_param_subcat')=='')
			{
				$category_id_str = ltrim($category_id_str,',');
				$f_where = " AND p.i_cat_id IN({$category_id_str}) ";
				/*if($this->session->userdata('product_list_where')=='')
					$this->session->set_userdata('product_list_where',$f_where);*/
				
			}
			
			if($_POST && !in_array('t',$_POST))
			{
				$posted		 		=	array();							
				$str_category		= $this->input->post('str_category');  
				$str_price_range	= $this->input->post('str_price_range');  
				$str_price_from		= $this->input->post('str_price_from');  
				$str_price_to		= $this->input->post('str_price_to');  
				$arr_brand 			= $this->input->post('arr_brand');  
				$arr_store 			= $this->input->post('arr_store'); 	
				$d_discount			= $this->input->post('d_discount');			         
                $s_type      		= trim($this->input->post('type'));
				
				$discount_checkboxes = $this->input->post('discount_checkboxes');
				$discount_arr = explode(",",$discount_checkboxes);
				
				$price_checkboxes = $this->input->post('price_checkboxes');
				$price_arr = explode(",",$price_checkboxes);
				//pr($price_arr,1);
				if($s_type=='where') 
                {
                    $this->session->unset_userdata('product_list_where');
                }
				// search by category
				$condition  =   '' ;
                if (!empty($str_category)) 
                {
					$this->session->unset_userdata('category_id_src');
					$this->session->set_userdata('category_id_src',$str_category);
					$category_id_str = select_product_under_category($str_category);
					$category_id_str = ltrim($category_id_str,',');
                    $condition  .= " AND p.i_cat_id IN ({$category_id_str}) ";
                }
				else if($this->session->userdata('get_param_subcat')!='')
				{
					$str_category = my_receive_text($this->session->userdata('get_param_subcat'));
					$category_id_str = select_product_under_category($str_category);
					if($category_id_str!='')
						$s_where  .= " AND p.i_cat_id IN ({$category_id_str}) ";
				}
				else
				{
					if($category_id_str)
						$condition = " AND p.i_cat_id IN({$category_id_str}) ";					
				}
                $s_where    .= trim($condition).'  ' ;
				
				// search by price range
				$condition  =   '' ;
                if (!empty($str_price_range)) 
                {
					if($str_price_range==2501)
					{
						$condition  .= " AND p.d_selling_price>= {$str_price_range}  ";
					}
					else
					{
						$price_arr = explode('-',$str_price_range);
						$condition  .= " AND (p.d_selling_price>= {$price_arr[0]} AND p.d_selling_price<= {$price_arr[1]}) ";
					}
                }
                $s_where    .= trim($condition).'  ' ;
				
				// search by price from input box
				$condition  =   '' ;
                if (!empty($str_price_from)) 
                {
						$condition  .= " AND p.d_selling_price>= {$str_price_from}  ";
                }
                $s_where    .= trim($condition).'  ' ;
				// search by price to input box
				$condition  =   '' ;
                if (!empty($str_price_to)) 
                {
						$condition  .= " AND p.d_selling_price<= {$str_price_to}  ";
                }
                $s_where    .= trim($condition).'  ' ;
				
				// search by brand
				$condition  =   '' ;
                if (!empty($arr_brand)) 
                {
                     //$condition  .= "AND p.i_brand_id IN ({$arr_brand}) ";
					 
					 $arr_brand = explode(',',addslashes($arr_brand));
					 if(is_array($arr_brand))
					 	$arr_brand = "'".implode("','",$arr_brand)."'";
					else
						$arr_brand = "'".my_receive_text($arr_brand)."'";
					 $condition  .= "AND p.s_brand_name IN ({$arr_brand}) ";
                }
                $s_where    .= trim($condition).'  ' ;
				
				// search by store
				$condition  =   '' ;
                if (!empty($arr_store)) 
                {
                     $condition  .= "AND p.i_store_id IN ({$arr_store}) ";
                }
                $s_where    .= trim($condition).'  ' ;
				
				// search by discount
				$condition  =   '' ;
                if (!empty($d_discount)) 
                {
					if($d_discount=='none')
					 	$condition .='';
					else
                     	$condition  .= "AND p.d_discount >= {$d_discount} ";
                }
                $s_where    .= trim($condition).'  ' ;
				
				// new discount by checkboxex
				$condition  =   '' ;
				if(!empty($discount_arr) && $discount_arr[0]!='')				
				{
					$arr_where = '';
					foreach($discount_arr as $val)
					{
						if($val=='none')
					 		$arr_search[] =" p.d_discount >=0 ";
						else
                     		$arr_search[]  = " p.d_discount >= {$val} ";
					}
					$arr_where .= (count($arr_search) !=0)?' AND ('.implode('OR',$arr_search).' )':'';
					
					$condition  .= $arr_where;
					//echo $arr_where.'</br>';
				}
				$s_where    .= trim($condition).'  ' ;  
				
				// new price by checkboxex
				$condition  =   '' ;
				if(!empty($price_arr) && $price_arr[0]!='')				
				{
					$c_where = '';
					foreach($price_arr as $val)
					{
						$str_price_range = $val;
						if($str_price_range==2501)
						{
							$pr_search[]  = " p.d_selling_price>= {$str_price_range}  ";
						}
						else
						{
							$range_arr = explode('-',$str_price_range);
							$pr_search[]  = " (p.d_selling_price>= {$range_arr[0]} AND p.d_selling_price<= {$range_arr[1]}) ";
						}
					}
					$c_where .= (count($pr_search) !=0)?' AND ('.implode('OR',$pr_search).' )':'';					
					$condition  .= $c_where;
					//echo $arr_where.'</br>';
				}
				$s_where    .= trim($condition).'  ' ;
				
				if(trim($s_where)!='') 
                {
                    $this->session->set_userdata('product_list_where',$s_where);
                }
				
			}
			else if($this->session->userdata('get_param_price')!='')
			{
				// fetch get param datas
				$str_price_range = $this->session->userdata('get_param_price');
				if (!empty($str_price_range)) 
				{
					if($str_price_range==2501)
					{
						$s_where  .= " AND p.d_selling_price>= {$str_price_range}  ";
					}
					else
					{
						$price_arr = explode('-',$str_price_range);
						if(is_array($price_arr))
							$s_where  .= " AND (p.d_selling_price>= {$price_arr[0]} AND p.d_selling_price<= {$price_arr[1]}) ";
					}
				}
				$this->data['str_price_range'] = $str_price_range;
			}
			else if($this->session->userdata('get_param_store')!='')
			{
				// fetch get param datas
				$str_store = $this->session->userdata('get_param_store');
				if($str_store)
					$s_where  .= "AND p.i_store_id IN ({$str_store}) ";
					
				$this->data['str_store'] = $str_store;
			}
			else if($this->session->userdata('get_param_brand')!='')
			{
				// fetch get param datas
				$str_brand = $this->session->userdata('get_param_brand');
				$arr_brand = explode(',',addslashes($str_brand));
				 if(is_array($arr_brand))
					$arr_brand = "'".implode("','",$arr_brand)."'";
				else
					$arr_brand = "'".my_receive_text($arr_brand)."'";
					
				if($arr_brand)
					$s_where  .= "AND p.s_brand_name IN ({$arr_brand}) ";
					
				$this->data['str_brand'] = $str_brand;
			}
			else if($this->session->userdata('get_param_subcat')!='')
			{
				$str_category = my_receive_text($this->session->userdata('get_param_subcat'));
				$category_id_str = select_product_under_category($str_category);
				if($category_id_str!='')
                	$s_where  .= " AND p.i_cat_id IN ({$category_id_str}) ";
			}
			else if($this->session->userdata('get_param_discount')!='')
			{
				$d_discount = $this->session->userdata('get_param_discount');
				if ($d_discount!='') 
                {
					if($d_discount=='none')
					 	$s_where .='';
					else
                     	$s_where  .= "AND p.d_discount >= {$d_discount} ";
                }
				$this->data['str_discount'] = $d_discount;
			}
			else if($this->session->userdata('get_param_deals')!='')
			{
				$d_deals = $this->session->userdata('get_param_deals');
				$this->data['str_deals'] = $d_deals;
			}else {
                $s_where = $this->session->userdata('product_list_where');
            }
			
			
			if($this->session->userdata('product_list_where') && trim($s_where)=='')
			{
				$s_where    =   $this->session->userdata('product_list_where');
				//echo '</br>**********';				
			}
			else
			{
				$s_where =$f_where.' '.$s_where;
			}
			//pr($this->session->userdata('product_list_where'));
			
			if($s_where)		
			{
				$this->session->set_userdata('product_list_where',$s_where);
			}		
			if($this->session->userdata('product_list_where') && trim($s_where)=='')
			{
				$s_where    =   $this->session->userdata('product_list_where');
			}
			
			$s_where  = " AND p.i_is_active = 1 ".$s_where;  // testing purpose
			$s_where   = preg_replace('/^AND/','WHERE ',trim($s_where));	
			//echo $s_where.'<br/>==>';			
            $this->data['product_list']= $this->product_model->get_product_list($s_where,intval($start),$limit,$s_order);          
            $total_rows            = $this->product_model->count_product_list($s_where);
			//pr($this->data['product_list']);
			
            $ctrl_path     = base_url().'category/ajax_pagination_product_list/';
            $paging_div = 'product_ajax';
            $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
            $this->data['total_rows']     = $total_rows;
            $this->data['start']          = $start;
          
			if(empty($param))
				$prod_vw = $this->load->view('category/ajax_product_list.tpl.php',$this->data,TRUE);
			else
				$prod_vw = $this->load->view('category/ajax_product_list.tpl.php',$this->data,TRUE).'|^|'.$total_rows;
			echo $prod_vw;
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }                
    }
	
	/*
	*  generate sub category for 2nd labae;l 
	*/
	public function ajax_generate_sub_category_list()
	{
		$response = array();
		$html = '';
		$main_cat_html = '';
		$breadcrumb = '';
		$catId = $this->input->post('catId');
		
		if($catId)
		{
			
			$main_cat = getCategoryName($catId);
			$main_cat_url = base_url().'category/'.getCategoryUrl($catId);
			$main_cat_html = '<div class="catTreeLvl1"><a rel="'.$catId.'" href="'.$main_cat_url.'" onclick="return false;">'.$main_cat.'</a ></div>';
			
			$breadcrumb = get_category_breadcrumb($catId);
				
			$where = " WHERE i_parent_id = '".$catId."' ";
			$arr_cat = $this->product_model->get_sub_category($where);
			
			if(!empty($arr_cat))
			{
				
				foreach($arr_cat as $val)
				{
					$cat_url = base_url().'category/'.$val['s_url'];
					$html .='<div class="catTreeLvl2"><a rel="'.$val["i_id"].'" href="'.$cat_url.'" onclick="return false;">'.$val["s_category"].'</a></div>';
				}
				
				
				$response["status"] 	= 'success';
				$response["html"] 		= $html;
				$response["main_cat"] 	= $main_cat_html;
				$response["breadcrumb"] = $breadcrumb;
				echo json_encode($response);
			}
			else
			{
				$response["status"] 	= 'success';
				$response["html"] 		= $html;
				$response["main_cat"] 	= $main_cat_html;
				$response["breadcrumb"] = $breadcrumb;
				echo json_encode($response);
			}
		}
		else
		{
			$response["status"] 	= 'error';
			$response["html"] 		= $html;
			$response["main_cat"] 	= $main_cat_html;
			$response["breadcrumb"] = $breadcrumb;
			echo json_encode($response);
		}
	}
	
	/*
	*  generate sub category for fiest label
	*/
	public function ajax_generate_sub_category_label_one()
	{
		$response = array();
		$html = '';
		$main_cat_html = '';
		$catId = $this->input->post('catId');
		$breadcrumb = '';
		if($catId)
		{
			
			$main_cat = getCategoryName($catId);
			$main_cat_url = base_url().'category/'.getCategoryUrl($catId);
			$main_cat_html = '<div class="catTreeLvl0"><a rel="'.$catId.'" href="'.$main_cat_url.'" onclick="return false;">'.$main_cat.'</a ></div>';
			
			$breadcrumb = get_category_breadcrumb($catId);
				
			$where = " WHERE i_parent_id = '".$catId."' ";
			$arr_cat = $this->product_model->get_sub_category($where,0,10);
			if(!empty($arr_cat))
			{
				
				foreach($arr_cat as $val)
				{
					$cat_url = base_url().'category/'.$val['s_url'];
					$html .='<div class="catTreeLvl1"><a rel="'.$val["i_id"].'" href="'.$cat_url.'" onclick="return false;">'.$val["s_category"].'</a></div>';
				}
				
				
				$response["status"] 	= 'success';
				$response["html"] 		= $html;
				$response["main_cat"] 	= $main_cat_html;
				$response["breadcrumb"] = $breadcrumb;
				echo json_encode($response);
			}
			else
			{
				$response["status"] 	= 'success';
				$response["html"] 		= $html;
				$response["main_cat"] 	= $main_cat_html;
				$response["breadcrumb"] = $breadcrumb;
				echo json_encode($response);
			}
		}
		else
		{
			$response["status"] 	= 'error';
			$response["html"] 		= $html;
			$response["main_cat"] 	= $main_cat_html;
			$response["breadcrumb"] = $breadcrumb;
			echo json_encode($response);
		}
	}
	
	 /**
    * This function is ajax fetch breadcrumb
    * make the list all pros
    * 
    * @param mixed $start
    * @param mixed $param
    */
    function ajax_fetch_breadcrumb($cat_id=0) 
    {
		$response = array();
		$breadcrumb = '';
		$catId = $this->input->post('catId');
		
		if($catId)
		{
			$breadcrumb = get_category_breadcrumb($catId);
			$response["breadcrumb"] = $breadcrumb;
			echo json_encode($response);
		}
		else
		{
			$response["breadcrumb"] = $breadcrumb;
			echo json_encode($response);
		}
	          
    }
	
}