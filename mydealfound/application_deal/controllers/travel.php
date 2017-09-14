<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
					
class Travel extends MY_Controller {

    //put your code here
	 public $cls_msg;
	 
    public function __construct() 
	{
        parent::__construct();	
		$this->cls_msg["no_result"]    = "No result found.";	
    }
	
    public function index() 
	{
        $data['title'] = 'Travel';
		
		if($_SERVER['HTTP_REFERER']=='')
			$this->session->unset_userdata('travel_list_where');
		else if (strpos($_SERVER['HTTP_REFERER'],'/travel/')== false) {
			$this->session->unset_userdata('travel_list_where');
		}
		$bank_where = "WHERE i_status = 1 ";
		$data["bank_offer"] = $this->manage_deals_model->get_bank_offer($bank_where);
		
		$s_where = " WHERE i_is_active=1";
		$data["all_store"] = $this->travel_model->fetch_multi_store_list($s_where,'s_store_title','ASC');
		$data["offer_zone"] = $this->travel_model->fetch_multi_offer_list($s_where,'s_offer','ASC');
		
		$s_where = " WHERE i_status = 1 AND i_parent_id=0 ";
		$data["main_category"] = $this->travel_category_model->fetch_multi_sorted_list($s_where,'s_category','ASC');
		
		ob_start();
			$this->ajax_pagination_travel(0,0);
			$travel_list	= ob_get_contents();
		ob_end_clean();
		$travel_list = explode('|^|',$travel_list);
		
		$data['travel_list'] = $travel_list[0];
		$data['total_cnt'] 	= $travel_list[1];
        
		$this->render($data);
    }
	
	 /**
    * This function is ajax pegination function 
    * make the list all pros
    * 
    * @param mixed $start
    * @param mixed $param
    */
    function ajax_pagination_travel($start=0,$param=0) 
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
				$arr_store 			= $this->input->post('arr_store'); 					
				$discount_checkboxes = $this->input->post('discount_checkboxes');
				$discount_arr 		= explode(",",$discount_checkboxes);
				$str_zone 			= $this->input->post('str_zone'); 						
				$str_cat			= $this->input->post('str_cat');
				$str_bank 			= $this->input->post('str_bank'); 
				
				$srch_cat_str 		= $this->input->post('srch_cat_str');
				
				if($s_type=='where') 
                {
                    $this->session->unset_userdata('travel_list_where');
                }
				
				// search by bank offer
				$condition  =   '' ;
                if (!empty($str_bank)) 
                {
                    $condition  .= " AND p.i_bank_offer IN ({$str_bank}) ";
                }
                $s_where    .= trim($condition).'  ' ;
				// search by category tree structure new 15 july
				$condition  =   '' ;
                if(!empty($srch_cat_str)) 
                {
					$category_all_str = '';
					$category_id_str = '';
					$arr_cat = explode(',',$srch_cat_str);
					if($arr_cat)
					{
						foreach($arr_cat as $val)
						{
							$category_id_str = select_travel_under_category($val);
							$category_id_str = trim($category_id_str,',');
							$category_all_str .= $category_id_str.',';							
						}
					}
                    //$condition  .= " AND p.i_cat_id IN ({$str_cat}) ";
					$category_all_str = rtrim($category_all_str,',');
					$condition  .= " AND p.i_cat_id IN ({$category_all_str}) ";
                }
                $s_where    .= trim($condition).'  ' ;
				
				// search by category 
				/*
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
							$category_id_str = select_travel_under_category($val);
							$category_id_str = trim($category_id_str,',');
							$category_all_str .= $category_id_str.',';							
						}
					}
                    //$condition  .= " AND p.i_cat_id IN ({$str_cat}) ";
					$category_all_str = rtrim($category_all_str,',');
					$condition  .= " AND p.i_cat_id IN ({$category_all_str}) ";
                }
                $s_where    .= trim($condition).'  ' ;
				*/
				
				// search by offer zone
				$condition  =   '' ;
                if (!empty($str_zone)) 
                {
                    $condition  .= " AND p.i_type IN ({$str_zone}) ";
                }
                $s_where    .= trim($condition).'  ' ;			
				
				// search by store
				$condition  =   '' ;
                if (!empty($arr_store)) 
                {
                     $condition  .= "AND p.i_store_id IN ({$arr_store}) ";
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
                    $this->session->set_userdata('travel_list_where',$s_where);
                }
				
				
			}
			else if($_POST && in_array('t',$_POST))
			{
				$s_where = $this->session->userdata('travel_list_where');
			} else {
                $s_where = $this->session->userdata('travel_list_where');
            }
			
			
			
			$s_where  = $s_where." AND p.i_is_active = 1 ";  // testing purpose
			$s_where   = preg_replace('/^AND/','WHERE ',trim($s_where));	
			// CONCAT(DATE(p.dt_exp_date),' 23:59:59')>=now() AND p.i_coupon_type=2
			//echo $s_where.'<br/>==>';	
			
			if($s_where)		
			{
				$this->session->set_userdata('travel_list_where',$s_where);
			}		
			if($this->session->userdata('travel_list_where') && trim($s_where)=='')
			{
				$s_where    =   $this->session->userdata('travel_list_where');
			}
			
            $this->data['travel_list']= $this->travel_model->fetch_multi($s_where,intval($start),$limit);
            $total_rows            = $this->travel_model->gettotal_info($s_where);
			//pr($this->data['travel_list']);
			
            $ctrl_path     = base_url().'travel/ajax_pagination_travel/';
            $paging_div = 'travel_ajax';
            $this->data['page_links']     = fe_ajax_pagination($ctrl_path, $total_rows, $start, $limit, $paging_div);
            $this->data['total_rows']     = $total_rows;
            $this->data['start']          = $start;
            
            
			if(empty($param))
				$prod_vw = $this->load->view('travel/ajax_pagination_travel.tpl.php',$this->data,TRUE);
			else
				$prod_vw = $this->load->view('travel/ajax_pagination_travel.tpl.php',$this->data,TRUE).'|^|'.$total_rows;
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
			$main_cat = getTravelCategoryName($catId);
			$main_cat_url = base_url().'category/'.getTravelCategoryUrl($catId);
			$main_cat_html = '<div class="catTreeLvl1"><a rel="'.$catId.'" href="'.$main_cat_url.'" onclick="return false;">'.$main_cat.'</a ></div>';
			
			$breadcrumb = get_travel_category_breadcrumb($catId);
				
			$where = " WHERE i_parent_id = '".$catId."' ";
			$arr_cat = $this->travel_category_model->fetch_multi_sorted_list($where,'s_category','ASC');
			
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
	public function ajax_generate_category_label_one()
	{
		$response = array();
		$html = '';
		$main_cat_html = '';
		$catId = $this->input->post('catId');
		$breadcrumb = '';
		/*if($catId)
		{*/
			
			$main_cat = getTravelCategoryName($catId);
			$main_cat_url = base_url().'category/'.getTravelCategoryUrl($catId);
			$main_cat_html = '<div class="catTreeLvl0"><a rel="'.$catId.'" href="'.$main_cat_url.'" onclick="return false;">'.$main_cat.'</a ></div>';
			
			$breadcrumb = get_travel_category_breadcrumb($catId);
				
			$where = " WHERE i_parent_id = 0 ";
			$arr_cat = $this->travel_category_model->fetch_multi_sorted_list($where,'s_category','ASC');
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
		/*}
		else
		{
			$response["status"] 	= 'error';
			$response["html"] 		= $html;
			$response["main_cat"] 	= $main_cat_html;
			$response["breadcrumb"] = $breadcrumb;
			echo json_encode($response);
		}*/
	}
	
	
	function ajax_fetch_category($cat_id=0) 
    {
		$response = array();
		$catName = '';
		$catId = $this->input->post('catId');		
		if($catId)
		{
			$catName = getTravelCategoryName($catId);
			$response["catName"] = $catName;
			echo json_encode($response);
		}
		else
		{
			$response["catName"] = $catName;
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
	
	function ajax_clear_srch_store_session()
	{
		$this->session->unset_userdata('offers_srch_store_id');
		echo 'ok';
	}
	
	
	/* details page*/
	public function details($s_seo_url='') 
	{
        $data['title'] = 'Travel Details';
		
		if($s_seo_url)
		{
			$s_where = " WHERE p.s_seo_url = '".my_receive_text($s_seo_url)."' ";
			$details = $this->travel_model->fetch_multi($s_where,0,1);
			if(empty($details))
			{
				redirect(base_url().'travel');
			}
		}
		else
		{
			redirect(base_url().'travel');
		}
		$data["details"] 	= $details[0];
		//pr($data["details"],1);
		//$data['offer_list'] 	= $offer_list[0];
		//$data['total_cnt'] 	= $offer_list[1];
		
		$data["prev_deal_link"] = "javascript:void(0);";
		$data["next_deal_link"] = "javascript:void(0);";
		
		$cur_deal_id = $details[0]["i_id"];
		$cond_where = " WHERE p.i_id > '".$cur_deal_id."' ";
		$prev_deal = $this->travel_model->fetch_multi($cond_where,0,1);
		if(!empty($prev_deal))
		{
			$data["prev_deal_link"] = base_url().'travel/details/'.$prev_deal[0]["s_seo_url"];
		}
		
		$cond_where = " WHERE p.i_id < '".$cur_deal_id."' ";
		$next_deal = $this->travel_model->fetch_multi($cond_where,0,1);
		if(!empty($next_deal))
		{
			$data["next_deal_link"] = base_url().'travel/details/'.$next_deal[0]["s_seo_url"];
		}
        
		$this->render($data);
    }
	
}