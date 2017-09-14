<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
					
class Products extends MY_Controller {

    //put your code here
	 public $cls_msg;
	 
    public function __construct() 
	{
        parent::__construct();	
		$this->cls_msg["no_result"]    = "No result found.";	
		
		//UpdateCategoryUrl();	
    }
	
    public function index($s_store="") 
	{
        $data['title'] = 'Products';
		
		if($_SERVER['HTTP_REFERER']=='')
			$this->session->unset_userdata('product_list_where');
		else if (strpos($_SERVER['HTTP_REFERER'],'/products/')== false) {
			$this->session->unset_userdata('product_list_where');
		}
		
		$s_where = "WHERE i_parent_id = 0 AND i_status = 1 ";
		$data["main_category"] = $this->manage_deals_model->get_category($s_where);
		
		/* get store and brands */
		$s_where  = " WHERE p.i_is_active = 1 ";
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
			$data["all_brand"] = $all_brand;
		}
		/* get store and brands */
		
		if($s_store!="")
		{
			$where = " WHERE s_url='".my_receive_text($s_store)."' ";
			$data["srch_store"] = $this->product_model->get_all_store($where);
			//pr($data["srch_store"]);
			if(!empty($data["srch_store"]))
			{
				$this->session->set_userdata('product_srch_store_id',$data["srch_store"][0]["i_id"]);
				$this->session->unset_userdata('product_srch_brand');
			}
			else
			{
				$this->session->unset_userdata('product_srch_store_id');
				
				$where_cond = " WHERE p.s_brand_name='".my_receive_text($s_store)."' ";
				$data["srch_brand"] = $this->product_model->get_distinct_brand_from_product($where_cond);
				
				if(!empty($data["srch_brand"]))
				{
					$this->session->set_userdata('product_srch_brand',$data["srch_brand"][0]["s_brand_name"]);
					$this->session->unset_userdata('product_srch_store_id');
				}
				else
				{
					$this->session->unset_userdata('product_srch_store_id');
					//$this->session->unset_userdata('product_srch_brand');					
					$this->session->set_userdata('product_srch_brand',$s_store);
				}
			
			}
		}
		else
		{
			$this->session->unset_userdata('product_srch_store_id');
			$this->session->unset_userdata('product_srch_brand');
		}
		
		
		ob_start();
			$this->ajax_pagination_product_list(0,0);
			$offer_list	= ob_get_contents();
		ob_end_clean();
		
		$offer_list = explode('|^|',$offer_list);		
		$data['offer_list'] = $offer_list[0];
		$data['total_cnt'] 	= $offer_list[1];
		
		/*$offer_list = json_decode($offer_list);		
		$data['offer_list'] = $offer_list->html;
		$data['total_cnt'] 	= $offer_list->total_row;*/
        
		$this->render($data);
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
			
			if($_POST && !in_array('t',$_POST))
			{
				$posted		 		=	array();							
				$str_cat			= $this->input->post('str_cat'); 
				$arr_store 			= $this->input->post('arr_store'); 			         
                $s_type      		= trim($this->input->post('type'));	
				$d_discount			= $this->input->post('d_discount');	
				
				$str_price_range	= $this->input->post('str_price_range');  
				$str_price_from		= $this->input->post('str_price_from');  
				$str_price_to		= $this->input->post('str_price_to');  
				$arr_brand 			= $this->input->post('arr_brand'); 
				
				$discount_checkboxes = $this->input->post('discount_checkboxes');
				$discount_arr = explode(",",$discount_checkboxes);
				
				$price_checkboxes = $this->input->post('price_checkboxes');
				$price_arr = explode(",",$price_checkboxes);
				
				if($s_type=='where') 
                {
                    $this->session->unset_userdata('product_list_where');
                }
				
				
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
						$price_array = explode('-',$str_price_range);
						$condition  .= " AND (p.d_selling_price>= {$price_array[0]} AND p.d_selling_price<= {$price_array[1]}) ";
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
				
				// search by category
				$condition  =   '' ;
                if (!empty($str_cat)) 
                {
					$category_all_str = '';
					$category_id_str = '';
					$arr_cat = explode(',',$str_cat);
					if($arr_cat)
					{
						foreach($arr_cat as $val)
						{
							$category_id_str = select_product_under_category($val);
							$category_id_str = ltrim($category_id_str,',');
							$category_all_str .= $category_id_str.',';							
						}
					}
                    //$condition  .= " AND p.i_cat_id IN ({$str_cat}) ";
					$category_all_str = rtrim($category_all_str,',');
					$condition  .= " AND p.i_cat_id IN ({$category_all_str}) ";
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
				
				if(trim($s_where)!='') 
                {
                    $this->session->set_userdata('product_list_where',$s_where);
                }
				
				
			}
			else if($_POST && in_array('t',$_POST))
			{
				$s_where = $this->session->userdata('product_list_where');
			}else {
                $s_where = $this->session->userdata('product_list_where');
            }
			
			
			$product_srch_store_id = $this->session->userdata('product_srch_store_id');			
			if($product_srch_store_id!="" && $product_srch_store_id>0 && empty($_POST) && $this->session->userdata('product_list_where')=='')
			{
				$s_where .=" AND p.i_store_id IN( '".$product_srch_store_id."') ";				
				$this->data['str_store'] = $product_srch_store_id;
			}
			
			$product_srch_brand = $this->session->userdata('product_srch_brand');
			if($product_srch_brand!="" && empty($arr_brand) && empty($_POST) && $this->session->userdata('product_list_where')=='')
			{
				//$s_where .=" AND p.s_brand_name = '".$product_srch_brand."' ";				
				$s_where .=" AND p.s_brand_name IN('".$product_srch_brand."') ";
				$this->data['str_brand'] = $product_srch_brand;
			}
			
			$s_where  = $s_where." AND p.i_is_active = 1 ";  // testing purpose
			$s_where   = preg_replace('/^AND/','WHERE ',trim($s_where));	
			
			//echo $s_where.'<br/>==>'.$product_srch_store_id;	
			if($s_where)		
			{
				$this->session->set_userdata('product_list_where',$s_where);
			}
			if($this->session->userdata('product_list_where') && trim($s_where)=='')
			{
				$s_where    =   $this->session->userdata('product_list_where');
			}
			
            $this->data['offer_list']= $this->manage_deals_model->get_product_deal_list($s_where,intval($start),$limit,$s_order);
            $total_rows            = $this->manage_deals_model->count_product_deal_list($s_where);
			//pr($this->data['offer_list']);
			
            $ctrl_path     = base_url().'products/ajax_pagination_product_list/';
            $paging_div = 'product_ajax';
            $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
            $this->data['total_rows']     = $total_rows;
            $this->data['start']          = $start;
          
			if(empty($param))
				$prod_vw = $this->load->view('products/ajax_offer_list.tpl.php',$this->data,TRUE);
			else
				$prod_vw = $this->load->view('products/ajax_offer_list.tpl.php',$this->data,TRUE).'|^|'.$total_rows;
			echo $prod_vw; 
			
			/*if(empty($param))
				$prod_vw = $this->load->view('products/ajax_offer_list.tpl.php',$this->data,TRUE);
			else
				$prod_vw = $this->load->view('products/ajax_offer_list.tpl.php',$this->data,TRUE);
			echo json_encode(array('total_row'=>$total_rows,'html'=>$prod_vw));*/
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }                
    }
	
	
	function ajax_clear_store_session()
	{
		$this->session->unset_userdata('product_srch_store_id');
		echo 'ok';
	}
	
}