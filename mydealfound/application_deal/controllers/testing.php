<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
					
class Testing extends MY_Controller {

    //put your code here
	 public $cls_msg;
	 
    public function __construct() 
	{
        parent::__construct();	
		$this->cls_msg["no_result"]    = "No result found.";	
		
		//UpdateCategoryUrl();	
    }
	
    public function index($s_store = '') 
	{
        $data['title'] = 'Top Offers';
		
		if($_SERVER['HTTP_REFERER']=='')
			$this->session->unset_userdata('offer_list_where');
		else if (strpos($_SERVER['HTTP_REFERER'],'/top_offers/')== false) {
			$this->session->unset_userdata('offer_list_where');
		}
		
		$zone_where = "WHERE i_is_active = 1 ";
		$data["offer_zone"] = $this->manage_deals_model->get_offer_type($zone_where);
		
		$s_where = "WHERE i_parent_id = 0 AND i_status = 1 ";
		$data["main_category"] = $this->manage_deals_model->get_category($s_where);
		
		$s_where  = " WHERE p.i_is_active = 1 ";
		$all_store = $this->manage_deals_model->get_distinct_store_from_offer($s_where);
		$data["all_store"]  = array();
		if($all_store!="")
		{
			$s_con = "WHERE i_is_active =1 AND i_id IN ({$all_store}) ";
			$data["all_store"] = $this->product_model->get_all_store($s_con);
		}
		
		if($s_store!="")
		{
			$where = " WHERE s_url='".my_receive_text($s_store)."' ";
			$data["srch_store"] = $this->product_model->get_all_store($where);
			if(!empty($data["srch_store"]))
			{
				$this->session->set_userdata('offers_srch_store_id',$data["srch_store"][0]["i_id"]);
			}
			else
			{
				$this->session->unset_userdata('offers_srch_store_id');
			}
		}
		else
		{
			$this->session->unset_userdata('offers_srch_store_id');
		}
		
		
		ob_start();
			$this->ajax_pagination_offer_list(0,0);
			$offer_list	= ob_get_contents();
		ob_end_clean();
		$offer_list = explode('|^|',$offer_list);
		
		$data['offer_list'] = $offer_list[0];
		$data['total_cnt'] 	= $offer_list[1];
        
		$this->render($data);
    }
	
	 /**
    * This function is ajax pegination function 
    * make the list all pros
    * 
    * @param mixed $start
    * @param mixed $param
    */
    function ajax_pagination_offer_list($start=0,$param=0) 
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
            $start = $start * 4;
            #echo "++". $start;
            $s_where        = "";
			$s_order		= "";
            $limit          = 4; 
			
			if($_POST && !in_array('t',$_POST))
			{
				$posted		 		=	array();							
				$str_cat			= $this->input->post('str_cat'); 
				$arr_store 			= $this->input->post('arr_store'); 			         
                $s_type      		= trim($this->input->post('type'));	
				$d_discount			= $this->input->post('d_discount');	
				
				$discount_checkboxes = $this->input->post('discount_checkboxes');
				$discount_arr = explode(",",$discount_checkboxes);
				$str_zone 			= $this->input->post('str_zone'); 
				
				if($s_type=='where') 
                {
                    $this->session->unset_userdata('offer_list_where');
                }
				
				// search by category
				$condition  =   '' ;
                if (!empty($str_zone)) 
                {
                    $condition  .= " AND p.i_type IN ({$str_zone}) ";
                }
                $s_where    .= trim($condition).'  ' ;
				
				// search by category
				$condition  =   '' ;
                if (!empty($str_cat)) 
                {
                    $condition  .= " AND p.i_cat_id IN ({$str_cat}) ";
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
                    $this->session->set_userdata('offer_list_where',$s_where);
                }
				
				
			}
			else if($_POST && in_array('t',$_POST))
			{
				$s_where = $this->session->userdata('offer_list_where');
			} else {
                $s_where = $this->session->userdata('offer_list_where');
            }
			
			
			
			$offers_srch_store_id = $this->session->userdata('offers_srch_store_id');
			if($offers_srch_store_id!="" && $offers_srch_store_id>0 && empty($_POST))
			{
				$s_where .=" AND p.i_store_id = '".$offers_srch_store_id."' ";				
				$this->data['str_store'] = $offers_srch_store_id;
			}
			
			$s_where  = $s_where." AND p.i_is_active = 1 ";  // testing purpose
			$s_where   = preg_replace('/^AND/','WHERE ',trim($s_where));	
			// CONCAT(DATE(p.dt_exp_date),' 23:59:59')>=now() AND p.i_coupon_type=2
			//echo $s_where.'<br/>==>';	
			
			if($s_where)		
			{
				$this->session->set_userdata('offer_list_where',$s_where);
			}		
			if($this->session->userdata('offer_list_where') && trim($s_where)=='')
			{
				$s_where    =   $this->session->userdata('offer_list_where');
			}
			
            $this->data['offer_list']= $this->manage_deals_model->get_deals_offers_list($s_where,intval($start),$limit,$s_order);
            $total_rows            = $this->manage_deals_model->count_deals_offers_list($s_where);
			//pr($this->data['offer_list']);
			
            $ctrl_path     = base_url().'testing/ajax_pagination_offer_list/';
            $paging_div = 'offer_ajax';
            $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
            $this->data['total_rows']     = $total_rows;
            $this->data['start']          = $start;
            
            
			if(empty($param))
				$prod_vw = $this->load->view('testing/ajax_offer_list.tpl.php',$this->data,TRUE);
			else
				$prod_vw = $this->load->view('testing/ajax_offer_list.tpl.php',$this->data,TRUE).'|^|'.$total_rows;
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
			$arr_cat = $this->product_model->get_sub_category($where,0,5);
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