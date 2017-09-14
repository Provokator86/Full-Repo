<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to Product management
 * @author Teamtweaks
 *
 */

class Product extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));
		$this->load->model('product_model');
		if ($this->checkPrivileges('product',$this->privStatus) == FALSE){
			redirect('admin');
		}
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->product_model->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];
	}

	/**
	 *
	 * This function loads the product list page
	 */
	public function index(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			redirect('admin/product/display_product_list');
		}
	}

	/**
	 *
	 * This function loads the selling product list page
	 */
	public function display_product_list(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Selling Product List';
			$this->data['productList'] = $this->product_model->view_product_details('  where u.group="Seller" and u.status="Active" or p.user_id=0 order by p.created desc');
			$this->load->view('admin/product/display_product_list',$this->data);
		}
	}

	/**
	 *
	 * This function loads the affiliate product list page
	 */
	public function display_user_product_list(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Affiliate Product List';
			$this->data['productList'] = $this->product_model->view_notsell_product_details();
			$this->load->view('admin/product/display_user_product_list',$this->data);
		}
	}

	/**
	 *
	 * This function loads the add new product form
	 */
	public function add_product_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add New Product';
			$this->data['Product_id'] = $this->uri->segment(4,0);
			$this->data['categoryView'] = $this->product_model->view_category_details();
			$this->data['atrributeValue'] = $this->product_model->view_atrribute_details();
			$this->data['PrdattrVal'] = $this->product_model->view_product_atrribute_details();
			$this->load->view('admin/product/add_product',$this->data);
		}
	}

	/**
	 *
	 * This function loads the add new product form
	 */
	public function add_affl_product_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add New Product';
			$this->data['Product_id'] = $this->uri->segment(4,0);
			$this->data['categoryView'] = $this->product_model->view_category_details();
			$this->data['atrributeValue'] = $this->product_model->view_atrribute_details();
			$this->data['PrdattrVal'] = $this->product_model->view_product_atrribute_details();
			$this->load->view('admin/product/add_affl_product',$this->data);
		}
	}

	/**
	 *
	 * This function insert and edit product
	 */
	public function insertEditProduct(){
		//		echo "<pre>";print_r($_POST);die;
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$product_name = $this->input->post('product_name');
			$product_id = $this->input->post('productID');
			if ($product_name == ''){
				$this->setErrorMessage('error','Product name required');
				//				redirect('admin/product/add_product_form');
				echo "<script>window.history.go(-1)</script>";exit();
			}
			$sale_price = $this->input->post('sale_price');
			if ($sale_price == ''){
				$this->setErrorMessage('error','Sale price required');
				//				redirect('admin/product/add_product_form');
				echo "<script>window.history.go(-1)</script>";exit();
			}else if ($sale_price <= 0){
				$this->setErrorMessage('error','Sale price must be greater than zero');
				echo "<script>window.history.go(-1)</script>";exit();
				//redirect('admin/product/add_product_form');
			}
			if ($product_id == ''){
				$old_product_details = array();
				$condition = array('product_name' => $product_name);
			}else {
				$old_product_details = $this->product_model->get_all_details(PRODUCT,array('id'=>$product_id));
				$condition = array('product_name' => $product_name,'id !=' => $product_id);
			}
			/*			$duplicate_name = $this->product_model->get_all_details(PRODUCT,$condition);
			 if ($duplicate_name->num_rows() > 0){
				$this->setErrorMessage('error','Product name already exists');
				echo "<script>window.history.go(-1)</script>";exit();
				}
				*/			$price_range = '';
			if ($sale_price>0 && $sale_price<21){
				$price_range = '1-20';
			}else if ($sale_price>20 && $sale_price<101){
				$price_range = '21-100';
			}else if ($sale_price>100 && $sale_price<201){
				$price_range = '101-200';
			}else if ($sale_price>200 && $sale_price<501){
				$price_range = '201-500';
			}else if ($sale_price>500){
				$price_range = '501+';
			}
			$excludeArr = array("gateway_tbl_length","imaged","productID","changeorder","status","category_id","attribute_name","attribute_val","attribute_weight","attribute_price","product_image","userID","product_attribute_name","product_attribute_val","attr_name1","attr_val1","attr_type1","product_attribute_type");

			if ($this->input->post('status') != ''){
				$product_status = 'Publish';
			}else {
				$product_status = 'UnPublish';
			}

			$seourl = url_title($product_name, '-', TRUE);
			$checkSeo = $this->product_model->get_all_details(PRODUCT,array('seourl'=>$seourl,'id !='=>$product_id));
			$seo_count = 1;
			while ($checkSeo->num_rows()>0){
				$seourl = $seourl.$seo_count;
				$seo_count++;
				$checkSeo = $this->product_model->get_all_details(PRODUCT,array('seourl'=>$seourl,'id !='=>$product_id));
			}
			if ($this->input->post('category_id') != ''){
				$category_id = implode(',', $this->input->post('category_id'));
			}else {
				$category_id = '';
			}
			$ImageName = '';
			$list_name_str = $list_val_str = '';
			$list_name_arr = $this->input->post('attribute_name');
			$list_val_arr = $this->input->post('attribute_val');
			if (is_array($list_name_arr) && count($list_name_arr)>0){
				$list_name_str = implode(',', $list_name_arr);
				$list_val_str = implode(',', $list_val_arr);
			}
			//			$option['attribute_name'] = $this->input->post('attribute_name');
			//			$option['attribute_val'] = $this->input->post('attribute_val');
			//			$option['attribute_weight'] = $this->input->post('attribute_weight');
			//			$option['attribute_price'] = $this->input->post('attribute_price');
			$datestring = "%Y-%m-%d %h:%i:%s";
			$time = time();
			if ($product_id == ''){
				$inputArr = array(
							'created' => mdate($datestring,$time),
							'seourl' => $seourl,
							'category_id' => $category_id,
							'status' => $product_status,
							'list_name' => $list_name_str,
							'list_value' => $list_val_str,
							'price_range'=> $price_range,
				//							'option' => serialize($option),
							'user_id' => $this->input->post('userID'),
							'seller_product_id'	=> mktime()
				);
			}else {
				$inputArr = array(
							'modified' => mdate($datestring,$time),
							'seourl' => $seourl,
							'category_id' => $category_id,
							'status' => $product_status,
							'price_range'=> $price_range,
							'list_name' => $list_name_str,
							'list_value' => $list_val_str
				//							'option' => serialize($option)
				);
			}
			//$config['encrypt_name'] = TRUE;
			$config['overwrite'] = FALSE;
			$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';
			$config['max_size'] = 2000;
			$config['upload_path'] = './images/product';

			$this->load->library('upload', $config);


			//$thumbimagepath= './images/product/thumb';


			//echo "<pre>";print_r($_FILES);die;
			if ( $this->upload->do_multi_upload('product_image')){
				$logoDetails = $this->upload->get_multi_upload_data();
				foreach ($logoDetails as $fileDetails){

					//$this->imageResizeWithSpace(196, 196, $fileDetails['file_name'], './images/product/');
					$this->crop_and_resize_image(200, 200, './images/product/', $fileDetails['file_name'], './images/product/thumb/');
					$ImageName .= $fileDetails['file_name'].',';
				}
			}

			if ($product_id == ''){
				$product_data = array( 'image' => $ImageName);
			}else {
				$existingImage = $this->input->post('imaged');

				$newPOsitionArr = $this->input->post('changeorder');
				$imagePOsit = array();
					
				for($p=0;$p<sizeof($existingImage);$p++) {
					$imagePOsit[$newPOsitionArr[$p]] = $existingImage[$p];
				}

				ksort($imagePOsit);
				foreach ($imagePOsit as $keysss => $vald) {
				 $imgArraypos[]=$vald;
				}
				$imagArraypo0 = @implode(",",$imgArraypos);
				$allImages = $imagArraypo0.','.$ImageName;

				$product_data = array( 'image' => $allImages);
			}
			if ($product_id != ''){
				$this->update_old_list_values($product_id,$list_val_arr,$old_product_details);
			}
			$dataArr = array_merge($inputArr,$product_data);
			if ($product_id == ''){
				$condition = array();
				$this->product_model->commonInsertUpdate(PRODUCT,'insert',$excludeArr,$dataArr,$condition);
				$this->setErrorMessage('success','Product added successfully');
				$product_id = $this->product_model->get_last_insert_id();

				$Attr_name_str = $Attr_val_str = '';
				$Attr_type_arr = $this->input->post('product_attribute_type');
				$Attr_name_arr = $this->input->post('product_attribute_name');
				$Attr_val_arr = $this->input->post('product_attribute_val');
				if (is_array($Attr_name_arr) && count($Attr_name_arr)>0){
					for($k=0;$k<sizeof($Attr_name_arr);$k++){
						$dataSubArr = '';
						$dataSubArr = array('product_id'=> $product_id,'attr_id'=>$Attr_type_arr[$k],'attr_name'=>$Attr_name_arr[$k],'attr_price'=>$Attr_val_arr[$k]);
						//echo '<pre>'; print_r($dataSubArr);
						$this->product_model->add_subproduct_insert($dataSubArr);
					}
				}

				$this->update_price_range_in_table('add',$price_range,$product_id,$old_product_details);
			}else {
				$condition = array('id'=>$product_id);
				$this->product_model->commonInsertUpdate(PRODUCT,'update',$excludeArr,$dataArr,$condition);
				$this->setErrorMessage('success','Product updated successfully');

				$Attr_name_str = $Attr_val_str = '';
				$Attr_type_arr = $this->input->post('product_attribute_type');
				$Attr_name_arr = $this->input->post('product_attribute_name');
				$Attr_val_arr = $this->input->post('product_attribute_val');
				if (is_array($Attr_name_arr) && count($Attr_name_arr)>0){
					for($k=0;$k<sizeof($Attr_name_arr);$k++){
						$dataSubArr = '';
						$dataSubArr = array('product_id'=> $product_id,'attr_id'=>$Attr_type_arr[$k],'attr_name'=>$Attr_name_arr[$k],'attr_price'=>$Attr_val_arr[$k]);
						//echo '<pre>'; print_r($dataSubArr);
						$this->product_model->add_subproduct_insert($dataSubArr);
					}
				}

				$this->update_price_range_in_table('edit',$price_range,$product_id,$old_product_details);
			}

			//Update the list table
			if (is_array($list_val_arr)){
				foreach ($list_val_arr as $list_val_row){
					$list_val_details = $this->product_model->get_all_details(LIST_VALUES,array('id'=>$list_val_row));
					if ($list_val_details->num_rows()==1){
						$product_count = $list_val_details->row()->product_count;
						$products_in_this_list = $list_val_details->row()->products;
						$products_in_this_list_arr = explode(',', $products_in_this_list);
						if (!in_array($product_id, $products_in_this_list_arr)){
							array_push($products_in_this_list_arr, $product_id);
							$product_count++;
							$list_update_values = array(
								'products'=>implode(',', $products_in_this_list_arr),
								'product_count'=>$product_count
							);
							$list_update_condition = array('id'=>$list_val_row);
							$this->product_model->update_details(LIST_VALUES,$list_update_values,$list_update_condition);
						}
					}
				}
			}

			//Update user table count
/*			if ($edit_mode == 'insert'){
				if ($this->checkLogin('U') != ''){
					$user_details = $this->product_model->get_all_details(USERS,array('id'=>$this->checkLogin('U')));
					if ($user_details->num_rows()==1){
						$prod_count = $user_details->row()->products;
						$prod_count++;
						$this->product_model->update_details(USERS,array('products'=>$prod_count),array('id'=>$this->checkLogin('U')));
					}
				}
			}
*/
			redirect('admin/product/display_product_list');
		}
	}


	/**
	 *
	 * Update the products_count and products in list_values table, when edit or delete products
	 * @param Integer $product_id
	 * @param Array $list_val_arr
	 * @param Array $old_product_details
	 */
	public function update_old_list_values($product_id,$list_val_arr,$old_product_details=''){
		if ($old_product_details == '' || count($old_product_details)==0){
			$old_product_details = $this->product_model->get_all_details(PRODUCT,array('id'=>$product_id));
		}
		$old_product_list_values = array_filter(explode(',', $old_product_details->row()->list_value));
		if (count($old_product_list_values)>0){
			if (!is_array($list_val_arr)){
				$list_val_arr = array();
			}
			foreach ($old_product_list_values as $old_product_list_values_row){
				if (!in_array($old_product_list_values_row, $list_val_arr)){
					$list_val_details = $this->product_model->get_all_details(LIST_VALUES,array('id'=>$old_product_list_values_row));
					if ($list_val_details->num_rows()==1){
						$product_count = $list_val_details->row()->product_count;
						$products_in_this_list = $list_val_details->row()->products;
						$products_in_this_list_arr = array_filter(explode(',', $products_in_this_list));
						if (in_array($product_id, $products_in_this_list_arr)){
							if (($key = array_search($product_id, $products_in_this_list_arr))!==false){
								unset($products_in_this_list_arr[$key]);
							}
							$product_count--;
							$list_update_values = array(
								'products'=>implode(',', $products_in_this_list_arr),
								'product_count'=>$product_count
							);
							$list_update_condition = array('id'=>$old_product_list_values_row);
							$this->product_model->update_details(LIST_VALUES,$list_update_values,$list_update_condition);
						}
					}
				}
			}
		}

		if ($old_product_details != '' && count($old_product_details)>0 && $old_product_details->num_rows()==1){

			/*** Delete product id from lists which was created by users ***/

			$user_created_lists = $this->product_model->get_user_created_lists($old_product_details->row()->seller_product_id);
			if ($user_created_lists->num_rows()>0){
				foreach ($user_created_lists->result() as $user_created_lists_row){
					$list_product_ids = array_filter(explode(',', $user_created_lists_row->product_id));
					if (($key=array_search($old_product_details->row()->seller_product_id,$list_product_ids )) !== false){
						unset($list_product_ids[$key]);
						$update_ids = array('product_id'=>implode(',', $list_product_ids));
						$this->product_model->update_details(LISTS_DETAILS,$update_ids,array('id'=>$user_created_lists_row->id));
					}
				}
			}

			/*** Delete product id from product likes table and decrease the user likes count ***/

			$like_list = $this->product_model->get_like_user_full_details($old_product_details->row()->seller_product_id);
			if ($like_list->num_rows()>0){
				foreach ($like_list->result() as $like_list_row){
					$likes_count = $like_list_row->likes;
					$likes_count--;
					if ($likes_count<0)$likes_count=0;
					$this->product_model->update_details(USERS,array('likes'=>$likes_count),array('id'=>$like_list_row->id));
				}
				$this->product_model->commonDelete(PRODUCT_LIKES,array('product_id'=>$old_product_details->row()->seller_product_id));
			}

			/*** Delete product id from activity, notification and product comment tables ***/

			$this->product_model->commonDelete(USER_ACTIVITY,array('activity_id'=>$old_product_details->row()->seller_product_id));
			$this->product_model->commonDelete(NOTIFICATIONS,array('activity_id'=>$old_product_details->row()->seller_product_id));
			$this->product_model->commonDelete(PRODUCT_COMMENTS,array('product_id'=>$old_product_details->row()->seller_product_id));

		}
	}

	public function update_price_range_in_table($mode='',$price_range='',$product_id='0',$old_product_details=''){
		$list_values = $this->product_model->get_all_details(LIST_VALUES,array('list_value'=>$price_range));
		if ($list_values->num_rows() == 1){
			$products = explode(',', $list_values->row()->products);
			$product_count = $list_values->row()->product_count;
			if ($mode == 'add'){
				if (!in_array($product_id, $products)){
					array_push($products, $product_id);
					$product_count++;
				}
			}else if ($mode == 'edit'){
				$old_price_range = '';
				if ($old_product_details!='' && count($old_product_details)>0 && $old_product_details->num_rows()==1){
					$old_price_range = $old_product_details->row()->price_range;
				}
				if ($old_price_range != '' && $old_price_range != $price_range){
					$old_list_values = $this->product_model->get_all_details(LIST_VALUES,array('list_value'=>$old_price_range));
					if ($old_list_values->num_rows() == 1){
						$old_products = explode(',', $old_list_values->row()->products);
						$old_product_count = $old_list_values->row()->product_count;
						if (in_array($product_id, $old_products)){
							if (($key=array_search($product_id, $old_products)) !== false){
								unset($old_products[$key]);
								$old_product_count--;
								$updateArr = array('products'=>implode(',', $old_products),'product_count'=>$old_product_count);
								$updateCondition = array('list_value'=>$old_price_range);
								$this->product_model->update_details(LIST_VALUES,$updateArr,$updateCondition);
							}
						}
					}
					if (!in_array($product_id, $products)){
						array_push($products, $product_id);
						$product_count++;
					}
				}else if ($old_price_range != '' && $old_price_range == $price_range){
					if (!in_array($product_id, $products)){
						array_push($products, $product_id);
						$product_count++;
					}
				}
			}
			$updateArr = array('products'=>implode(',', $products),'product_count'=>$product_count);
			$updateCondition = array('list_value'=>$price_range);
			$this->product_model->update_details(LIST_VALUES,$updateArr,$updateCondition);
		}
	}

	/**
	 *
	 * Ajax function for delete the product pictures
	 */
	public function editPictureProducts(){
		$ingIDD = $this->input->post('imgId');
		$currentPage = $this->input->post('cpage');
		$id = $this->input->post('val');
		$productImage = explode(',',$this->session->userdata('product_image_'.$ingIDD));
		if(count($productImage) < 2) {
			echo json_encode("No");exit();
		} else {
			$empImg = 0;
			foreach ($productImage as $product) {
				if ($product != ''){
					$empImg++;
				}
			}
			if ($empImg<2){
				echo json_encode("No");exit();
			}
			$this->session->unset_userdata('product_image_'.$ingIDD);
			$resultVar = $this->setPictureProducts($productImage,$this->input->post('position'));
			$insertArrayItems = trim(implode(',',$resultVar)); //need validation here...because the array key changed here

			$this->session->set_userdata(array('product_image_'.$ingIDD => $insertArrayItems));
			$dataArr = array('image' => $insertArrayItems);
			$condition = array('id' => $ingIDD);
			$this->product_model->update_details(PRODUCT,$dataArr,$condition);
			echo json_encode($insertArrayItems);
		}
	}

	/**
	 *
	 * This function loads the edit product form
	 */
	public function edit_product_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Edit Product';
			$product_id = $this->uri->segment(4,0);
			$condition = array('id' => $product_id);
			$this->data['product_details'] = $this->product_model->view_product($condition);
			if ($this->data['product_details']->num_rows() == 1){
				$this->data['categoryView'] = $this->product_model->get_category_details($this->data['product_details']->row()->category_id);
				$this->data['atrributeValue'] = $this->product_model->view_atrribute_details();
				$this->data['SubPrdVal'] = $this->product_model->view_subproduct_details($product_id);
				$this->data['PrdattrVal'] = $this->product_model->view_product_atrribute_details();
				$this->load->view('admin/product/edit_product',$this->data);
			}else {
				redirect('admin');
			}
		}
	}

	/**
	 *
	 * This function loads the edit affiliate product form
	 */
	public function edit_user_product_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Edit Affiliate Product';
			$product_id = $this->uri->segment(4,0);
			$condition = " where `seller_product_id` ='".$product_id."'";
			$this->data['product_details'] = $this->product_model->view_notsell_product_details($condition);
			$this->load->view('admin/product/edit_affiliate_product',$this->data);
		}
	}

	/**
	 *
	 * Edit affilate product
	 */
	public function edit_affiliate_product(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$excludeArr = array('image','pid','edit_affl');
			$product_name = $this->input->post('product_name');
			if ($product_name == ''){
				$this->setErrorMessage('error','Product name required');
				echo "<script>window.history.go(-1);</script>";
			}else {
				$dataArr = array();
				//$config['encrypt_name'] = TRUE;
				$config['overwrite'] = FALSE;
				$config['allowed_types'] = 'jpg|jpeg|gif|png';
				$config['max_size'] = 2000;
				$config['upload_path'] = './images/product';
				$this->load->library('upload',$config);
				if ( $this->upload->do_upload('image')){
					$imgDetails = $this->upload->data();
					$dataArr['image'] = $imgDetails['file_name'];
					//$this->imageResizeWithSpace(196, 196, $imgDetails['file_name'], './images/product/');
					$this->crop_and_resize_image(200, 200, './images/product/', $imgDetails['file_name'], './images/product/thumb/');
				}
				$condition = array('seller_product_id'=>$this->input->post('pid'));
				$this->product_model->commonInsertUpdate(USER_PRODUCTS,'update',$excludeArr,$dataArr,$condition);
				$this->setErrorMessage('success','Product updated successfully');
				redirect('admin/product/display_user_product_list');
			}
		}
	}

	/**
	 *
	 * Add affilate product
	 */
	public function add_affiliate_product(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$excludeArr = array('image','pid','edit_affl');
			$product_name = $this->input->post('product_name');
			if ($product_name == ''){
				$this->setErrorMessage('error','Product name required');
				echo "<script>window.history.go(-1);</script>";
			}else {
				$web_link = $this->input->post('web_link');
				$check_duplicate = $this->product_model->get_all_details(USER_PRODUCTS,array('web_link'=>$web_link));
				if ($check_duplicate->num_rows()>0){
					$this->setErrorMessage('error','Oops! Someone already posted it');
					redirect();
				}else {
					$dataArr = array();
					//$config['encrypt_name'] = TRUE;
					$config['overwrite'] = FALSE;
					$config['allowed_types'] = 'jpg|jpeg|gif|png';
					$config['max_size'] = 2000;
					$config['upload_path'] = './images/product';
					$this->load->library('upload',$config);
					if ( $this->upload->do_upload('image')){
						$imgDetails = $this->upload->data();
						$dataArr['image'] = $imgDetails['file_name'];
						//$this->imageResizeWithSpace(196, 196, $imgDetails['file_name'], './images/product/');
						$this->crop_and_resize_image(200, 200, './images/product/', $imgDetails['file_name'], './images/product/thumb/');
					}
					$this->product_model->commonInsertUpdate(USER_PRODUCTS,'insert',$excludeArr,$dataArr);
					$this->setErrorMessage('success','Product added successfully');
					redirect('admin/product/display_user_product_list');
				}
			}
		}
	}

	/**
	 *
	 * This function change the selling product status
	 */
	public function change_product_status(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$product_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'UnPublish':'Publish';
			$newdata = array('status' => $status);
			$condition = array('id' => $product_id);
			$this->product_model->update_details(PRODUCT,$newdata,$condition);
			$this->setErrorMessage('success','Product Status Changed Successfully');
			redirect('admin/product/display_product_list');
		}
	}

	/**
	 *
	 * This function change the affiliate product status
	 */
	public function change_user_product_status(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$product_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'UnPublish':'Publish';
			$newdata = array('status' => $status);
			$condition = array('seller_product_id' => $product_id);
			$this->product_model->update_details(USER_PRODUCTS,$newdata,$condition);
			$this->setErrorMessage('success','Product Status Changed Successfully');
			redirect('admin/product/display_user_product_list');
		}
	}

	/**
	 *
	 * This function loads the product view page
	 */
	public function view_product(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'View Product';
			$product_id = $this->uri->segment(4,0);
			$condition = array('id' => $product_id);
			$this->data['product_details'] = $this->product_model->get_all_details(PRODUCT,$condition);
			if ($this->data['product_details']->num_rows() == 1){
				$this->data['catList'] = $this->product_model->get_cat_list($this->data['product_details']->row()->category_id);
				$this->load->view('admin/product/view_product',$this->data);
			}else {
				redirect('admin');
			}
		}
	}

	/**
	 *
	 * This function delete the selling product record from db
	 */
	public function delete_product(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$product_id = $this->uri->segment(4,0);
			$condition = array('id' => $product_id);
			$old_product_details = $this->product_model->get_all_details(PRODUCT,array('id'=>$product_id));
			$this->update_old_list_values($product_id,array(),$old_product_details);
			$this->update_user_product_count($old_product_details);
			$this->product_model->commonDelete(PRODUCT,$condition);
			$this->setErrorMessage('success','Product deleted successfully');
			redirect('admin/product/display_product_list');
		}
	}

	/**
	 *
	 * This function delete the affiliate product record from db
	 */
	public function delete_user_product(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$product_id = $this->uri->segment(4,0);
			$condition = array('seller_product_id' => $product_id);
			$old_product_details = $this->product_model->get_all_details(USER_PRODUCTS,array('seller_product_id'=>$product_id));
			$this->update_user_created_lists($product_id);
			$this->update_user_likes($product_id);
			$this->update_user_product_count($old_product_details);
			$this->product_model->commonDelete(USER_PRODUCTS,$condition);
			$this->product_model->commonDelete(USER_ACTIVITY,array('activity_id'=>$product_id));
			$this->product_model->commonDelete(NOTIFICATIONS,array('activity_id'=>$product_id));
			$this->product_model->commonDelete(PRODUCT_COMMENTS,array('product_id'=>$product_id));
			$this->setErrorMessage('success','Product deleted successfully');
			redirect('admin/product/display_user_product_list');
		}
	}

	public function update_user_likes($product_id='0'){
		$like_list = $this->product_model->get_like_user_full_details($product_id);
		if ($like_list->num_rows()>0){
			foreach ($like_list->result() as $like_list_row){
				$likes_count = $like_list_row->likes;
				$likes_count--;
				if ($likes_count<0)$likes_count=0;
				$this->product_model->update_details(USERS,array('likes'=>$likes_count),array('id'=>$like_list_row->id));
			}
			$this->product_model->commonDelete(PRODUCT_LIKES,array('product_id'=>$product_id));
		}
	}

	public function update_user_created_lists($pid='0'){
		$user_created_lists = $this->product_model->get_user_created_lists($pid);
		if ($user_created_lists->num_rows()>0){
			foreach ($user_created_lists->result() as $user_created_lists_row){
				$list_product_ids = array_filter(explode(',', $user_created_lists_row->product_id));
				if (($key=array_search($pid,$list_product_ids )) !== false){
					unset($list_product_ids[$key]);
					$update_ids = array('product_id'=>implode(',', $list_product_ids));
					$this->product_model->update_details(LISTS_DETAILS,$update_ids,array('id'=>$user_created_lists_row->id));
				}
			}
		}
	}

	public function update_user_product_count($old_product_details){
		if ($old_product_details!='' && count($old_product_details)>0 && $old_product_details->num_rows()==1){
			if ($old_product_details->row()->user_id > 0){
				$user_details = $this->product_model->get_all_details(USERS,array('id'=>$old_product_details->row()->user_id));
				if ($user_details->num_rows()==1){
					$prod_count = $user_details->row()->products;
					$prod_count--;
					if ($prod_count<0){
						$prod_count = 0;
					}
					$this->product_model->update_details(USERS,array('products'=>$prod_count),array('id'=>$old_product_details->row()->user_id));
				}
			}
		}
	}

	/**
	 *
	 * This function change the selling product status, delete the selling product record
	 */
	public function change_product_status_global(){

		if($_POST['checkboxID']!=''){

			if($_POST['checkboxID']=='0'){
				redirect('admin/product/add_product_form/0');
			}else{
				redirect('admin/product/add_product_form/'.$_POST['checkboxID']);
			}

		}else{
			if(count($_POST['checkbox_id']) > 0 &&  $_POST['statusMode'] != ''){
				$data =  $_POST['checkbox_id'];
				if (strtolower($_POST['statusMode']) == 'delete'){
					for ($i=0;$i<count($data);$i++){
						if($data[$i] == 'on'){
							unset($data[$i]);
						}
					}
					foreach ($data as $product_id){
						if ($product_id!=''){
							$old_product_details = $this->product_model->get_all_details(PRODUCT,array('id'=>$product_id));
							$this->update_old_list_values($product_id,array(),$old_product_details);
							$this->update_user_product_count($old_product_details);
						}
					}
				}
				$this->product_model->activeInactiveCommon(PRODUCT,'id');
				if (strtolower($_POST['statusMode']) == 'delete'){
					$this->setErrorMessage('success','Product records deleted successfully');
				}else {
					$this->setErrorMessage('success','Product records status changed successfully');
				}
				redirect('admin/product/display_product_list');
			}
		}
	}

	/**
	 *
	 * This function change the affiliate product status, delete the affiliate product record
	 */
	public function change_user_product_status_global(){

		if(count($_POST['checkbox_id']) > 0 &&  $_POST['statusMode'] != ''){
			$data =  $_POST['checkbox_id'];
			if (strtolower($_POST['statusMode']) == 'delete'){
				for ($i=0;$i<count($data);$i++){
					if($data[$i] == 'on'){
						unset($data[$i]);
					}
				}
				foreach ($data as $product_id){
					if ($product_id!=''){
						$old_product_details = $this->product_model->get_all_details(USER_PRODUCTS,array('seller_product_id'=>$product_id));
						$this->update_user_created_lists($product_id);
						$this->update_user_likes($product_id);
						$this->update_user_product_count($old_product_details);
						$this->product_model->commonDelete(USER_ACTIVITY,array('activity_id'=>$product_id));
						$this->product_model->commonDelete(NOTIFICATIONS,array('activity_id'=>$product_id));
						$this->product_model->commonDelete(PRODUCT_COMMENTS,array('product_id'=>$product_id));
					}
				}
			}
			$this->product_model->activeInactiveCommon(USER_PRODUCTS,'seller_product_id');
			if (strtolower($_POST['statusMode']) == 'delete'){
				$this->setErrorMessage('success','Product records deleted successfully');
			}else {
				$this->setErrorMessage('success','Product records status changed successfully');
			}
			redirect('admin/product/display_user_product_list');
		}
	}

	public function loadListValues(){
		$returnStr['listCnt'] = '<option value="">--Select--</option>';
		$lid = $this->input->post('lid');
		$lvID = $this->input->post('lvID');
		if ($lid != ''){
			$listValues = $this->product_model->get_all_details(LIST_VALUES,array('list_id'=>$lid));
			if ($listValues->num_rows()>0){
				foreach ($listValues->result() as $listRow){
					$selStr = '';
					if ($listRow->id == $lvID){
						$selStr = 'selected="selected"';
					}
					$returnStr['listCnt'] .= '<option '.$selStr.' value="'.$listRow->id.'">'.$listRow->list_value.'</option>';
				}
			}
		}
		echo json_encode($returnStr);
	}

	/* Ajax update for edit product */
	public function ajaxProductAttributeUpdate(){

		$conditons = array('pid'=>$this->input->post('pid'));
		$dataArr = array('attr_id'=>$this->input->post('attId'),'attr_name'=>$this->input->post('attname'),'attr_price'=>$this->input->post('attprice'));
		$subproductDetails = $this->product_model->edit_subproduct_update($dataArr,$conditons);
	}

	public function remove_attr(){
		if ($this->checkLogin('A') != ''){
			$this->product_model->commonDelete(SUBPRODUCT,array('pid'=>$this->input->post('pid')));
		}
	}
    
    /*************** NEW CODE START FOR CSV IMPORT FILE **************/
    public function add_csv_product_form(){
        if ($this->checkLogin('A') == ''){
            redirect('admin');
        }else {
            
           /*$test = 'http://tracking.vcommission.com/aff_c?offer_id=414&aff_id=26194&aff_sub=MYDEALFOUNDXXX&url=http://www.amazon.in/Fighter-Mens-Sandals-23007-Synthetic/dp/B00IYPYEQE/ref=sr_1_4925?s=shoes&ie=UTF8&qid=1411135050&sr=1-4925';
           $web_link = str_replace('&UID=MYDEALFOUNDXXX','',$test);
           $web_links = explode('&r=',$web_link);
           echo urldecode($web_links[1]);
           pr($web_links);*/
           
            //$this->session->unset_userdata('unprocessed_key');
            /*$web_links = explode('http://','http://clk.omgt5.com/?AID=519376&PID=8420&WID=48100&UID=MYDEALFOUNDXXX&r=http://shopping.rediff.com/product/venice-sunglass-purple-vn-1905-with-glass-lenses/11767554?sc_cid=browse|search');
            $web_link = prep_url($web_links[2]);
            echo prep_url($web_link);
            pr($web_link);*/
            
            
            
            $uid = $this->checkLogin('A');      
            $this->data['heading'] = 'Add New Product';
            $this->data['Product_id'] = $this->uri->segment(4,0);
            $this->data['categoryView'] = $this->product_model->view_category_details();
            $this->data['atrributeValue'] = $this->product_model->view_atrribute_details();
            $this->data['PrdattrVal'] = $this->product_model->view_product_atrribute_details();
            $this->load->view('admin/product/add_csv_product_form',$this->data);
        }
    }

    /**
     * Add product from csv file
     */
    public function add_csv_product(){
        if ($this->checkLogin('A') == ''){
            redirect('admin');
        }else {
            ini_set('memory_limit', '512M');
            ini_set('max_execution_time', '6000');
            $posted = array();
            $posted['file_path']        = $this->input->post('file_path');
            $posted['h_import_type']    = $this->input->post('h_import_type')?$this->input->post('h_import_type'):"csv";
            if($posted['file_path']!='')
            {
                if($posted['h_import_type']=='csv')
                {   
                    $tmp_name = $posted['file_path'];
                    if (($handle = fopen($tmp_name, "r")) !== FALSE) {
                    
                        $nn = 0;
                        while (($data = fgetcsv($handle)) !== FALSE) {                     
                            # Count the total keys in the row.
                            $c = count($data);
                            # Populate the multidimensional array.
                            $cnt = 0;
                            for ($x=0;$x<$c;$x++)
                            {
                                //echo $x.'==></br>';
                                $csvarray[$nn][$x] = $data[$x];                                                              
                            }    
                            $csv_data[] = $csvarray[$nn];    
                            if($nn%10==0)                
                            {
                                $processed = $this->process_array_data($csv_data,$posted['i_store_id']);    
                                $cnt = -1;                                
                                unset($data);                                    
                                unset($csv_data);                                    
                            }                        
                            //$cnt++;
                            $nn++;                                            
                        }
                        
                        # Close the File.
                        fclose($handle);
                        
                    }                
                    else
                    {
                        $this->setErrorMessage('error','File not found');
                        $this->data["posted"] = $posted;
                    }
                }
                $this->setErrorMessage('success','Product added successfully');
                redirect('admin/product/add_csv_product_form');   
            }
            else
            {       
                $this->setErrorMessage('error','Product added failed');         
                $this->data["posted"] = $posted;
            }
            
        }
    }
    
    /*
    *  process 
    * @param array data
    */
    
    function process_array_data($data_arr=array(),$storeId=0)
    {        
        if(!empty($data_arr))
        {
            
            $uid = $this->checkLogin('A');      
            $start_key = $this->session->userdata('unprocessed_key')?$this->session->userdata('unprocessed_key'):1;
            //echo count($data_arr); exit;
            for($i=$start_key;$i<count($data_arr); $i++)
            {
                $info = array();                
                $arr = $data_arr[$i];
                //$arr[5] = str_replace('&affid=soumyadatt&AffExtParam1=MYDEALFOUNDXXX','',$arr[5]);
                //$web_link='';
                //$web_link = str_replace('&affid=soumyadatt&AffExtParam1=MYDEALFOUNDXXX','',$arr[5]); // flipkart
                
                // mens - womens clothing
                /*$prod_link = str_replace('&UID=MYDEALFOUNDXXX','',$arr[5]);
                $web_links = explode('&Redirect=',$prod_link);
                $web_link  = urldecode($web_links[1]);*/
                
                // children clothing
                /*$prod_link = str_replace('&aff_sub=MYDEALFOUNDXXX','',$arr[5]);
                $web_links = explode('?utm_source=',$prod_link);
                $web_link  = urldecode($web_links[0]);*/
                
                // mens footwear
                $prod_link = str_replace('&UID=MYDEALFOUNDXXX','',$arr[5]);
                $web_links = explode('&r=',$prod_link);
                if($web_links[1])
                $web_link  = urldecode($web_links[1]);
                else
                {
                    $prod_link = str_replace('&aff_sub=MYDEALFOUNDXXX','',$arr[5]);
                    $web_links = explode('&url=',$prod_link);
                    $web_link  = urldecode($web_links[1]);
                }
                
                
                /*pr($arr);
                exit;*/                
                /*$web_links = explode('http://',$arr[5]);
                $web_link = prep_url($web_links[2]);*/
                
                $sql_cnt= "select * from ".USER_PRODUCTS." where web_link='".prep_url($web_link)."' or web_link='".$web_link."'"; 
                $query_cnt = $this->db->query($sql_cnt);
                $likesResult = $query_cnt->row_array();
                if($query_cnt->num_rows()==0)
                {                
                    $seller_product_id = mktime();
                    $checkId = $this->check_product_id($seller_product_id);
                    while ($checkId->num_rows()>0){
                        $seller_product_id = mktime();
                        $checkId = $this->check_product_id($seller_product_id);
                    }
                    $image_name = '';
                    $img_url = explode(',',$arr[2]);
                    
                    $arr[2] = $img_url[8]?$img_url[8]:$img_url[0];
                    if ($arr[2] && $arr[2]!=''){
                        /****----------Move image to server-------------****/

                        $image_url = trim(addslashes($arr[2]));
                        $img_data = file_get_contents($image_url);

                        $img_full_name = substr($image_url, strrpos($image_url, '/')+1);
                        $img_name_arr = explode('.', $img_full_name);
                        $img_name = $img_name_arr[0];
                        $ext = $img_name_arr[1];
                        // below two line added on jan 15
                        $img_name = getFilenameWithoutExtension($img_full_name);
                        $ext = str_replace('.','',getExtension($img_full_name));
                        
                        $new_name = str_replace(',', '', $img_name.mktime().'.'.$ext);
                        $new_name = str_replace('?', '', $new_name);
                        $new_img = 'images/product/'.$new_name;

                        file_put_contents($new_img, $img_data);
                        $returnStr['image'] = $new_name;

                        /****----------Move image to server-------------****/
                        $image_name = $new_name;
                        $this->imageResizeWithSpace(200,200,$image_name, './images/product/');
                    }
                    
                    // work for category
                    $category_name = $arr[7];
                    //$category_name = "Fashion";
                    
                    
                    $condition = array('cat_name' => $category_name);
                    $duplicate_name = $this->product_model->get_all_details(CATEGORY,$condition);
                    if ($duplicate_name->num_rows() > 0){
                        $category_arr = $duplicate_name->row_array();
                        $category_id = $category_arr["id"];
                    }
                    else
                    {
                        $seourlBase = $seourl = url_title($category_name, '-', TRUE);
                        $seourl_check = '0';
                        $duplicate_url = $this->product_model->get_all_details(CATEGORY,array('seourl'=>$seourl));
                        if ($duplicate_url->num_rows()>0){
                            $seourl = $seourlBase.'-'.$duplicate_url->num_rows();
                        }else {
                            $seourl_check = '1';
                        }
                        $urlCount = $duplicate_url->num_rows();
                        while ($seourl_check == '0'){
                            $urlCount++;
                            $duplicate_url = $this->product_model->get_all_details(CATEGORY,array('seourl'=>$seourl));
                            if ($duplicate_url->num_rows()>0){
                                $seourl = $seourlBase.'-'.$urlCount;
                            }else {
                                $seourl_check = '1';
                            }
                        }
                        $inputArr = array(
                                    'cat_name' => $category_name,
                                    'seourl' => $seourl,
                                    'rootID' => 0,
                                    'status' => 'Active'
                        );
                        $this->load->model('category_model');
                        $this->category_model->add_category($inputArr);
                        $category_id = $this->category_model->get_last_insert_id();
                    }
                   //$category_id = 15; // men footwear
                    
                    $info["image"]              = $image_name;
                    $info["product_name"]       = $arr[1]?$arr[1]:"shoe Footwear";
                    $info["created"]            = date("Y-m-d H:i:s");
                    $info["price"]              = $arr[4];
                    //$info["web_link"]           = $arr[5];
                    $info["web_link"]           = $web_link;
                    $info["seller_product_id"]  = $seller_product_id;
                    //$info["category_id"]        = $arr[6];
                    $info["category_id"]        = $category_id;
                    
                    $seo_url = url_title($info["product_name"],'-');
                    if ($seo_url == ''){
                        $seo_url = str_replace(' ', '-', $info["product_name"]);
                    }
                    $info["seourl"]       = $seo_url;
                    
                    $store_name = '';
                    //$store_url = prep_url($arr[5]);
                    $store_url = prep_url($web_link);
                    $store_name = parse_url($store_url,PHP_URL_HOST);
                    $info["store_name"]       = $store_name?$store_name:""; 
                    
                    ##### brand entry code
                    $brand_name = $arr[8];
                    $info["brand_name"]   = $brand_name?url_title($brand_name,'-'):"";
                    
                    $this->product_model->simple_insert(USER_PRODUCTS,$info);
                    if ($store_name){
                        $check_store_name = $this->product_model->get_all_details(SHOPS,array('store_url'=>$store_name));
                        if ($check_store_name->num_rows()>0){
                            $store_products = explode(',', $check_store_name->row()->products);
                            $products_count = $check_store_name->row()->products_count;
                            if ($products_count<0){
                                $products_count = 0;;
                            }
                            if (!in_array($seller_product_id, $store_products)){
                                $store_products[] = $seller_product_id;
                                $products_count++;
                            }
                            $dataArr = array('products'=>implode(',', $store_products),'products_count'=>$products_count);
                            $condArr = array('store_url'=>$store_name);
                            $this->product_model->update_details(SHOPS,$dataArr,$condArr);
                        }else {
                            $dataArr = array('store_name'=>$store_name,'store_url'=>$store_name,'products'=>$seller_product_id,'products_count'=>1);
                            $this->product_model->simple_insert(SHOPS,$dataArr);
                        }
                    }
                    
                    ##### brand entry code
                    if(trim($brand_name)!=''){
                        $check_brand_name = $this->product_model->get_all_details(BRANDS,array('brand_url'=>url_title($brand_name,'-')));
                        if ($check_brand_name->num_rows()>0){
                            $store_products = explode(',', $check_brand_name->row()->products);
                            $products_count = $check_brand_name->row()->products_count;
                            if ($products_count<0){
                                $products_count = 0;;
                            }
                            if (!in_array($seller_product_id, $store_products)){
                                $store_products[] = $seller_product_id;
                                $products_count++;
                            }
                            $dataArr = array('products'=>implode(',', $store_products),'products_count'=>$products_count);
                            $condArr = array('brand_url'=>url_title($brand_name,'-'));
                            $this->product_model->update_details(BRANDS,$dataArr,$condArr);
                        }else {
                            $dataArr = array('brand_name'=>$brand_name,'brand_url'=>url_title($brand_name,'-'),'products'=>$seller_product_id,'products_count'=>1);
                            $this->product_model->simple_insert(BRANDS,$dataArr);
                        }
                    }
                    
                    $this->session->unset_userdata('unprocessed_key');
                    
                }
                else
                {
                    $this->session->set_userdata('unprocessed_key',$i);
                }
            }            
            //echo $this->session->userdata('unprocessed_key'); exit;
            //redirect(base_url('admin/product/add_csv_product_form'));
            
        }
    }
    
    
    public function check_product_id($pid=''){
        $checkId = $this->product_model->get_all_details(USER_PRODUCTS,array('seller_product_id'=>$pid));
        if ($checkId->num_rows()==0){
            $checkId = $this->product_model->get_all_details(PRODUCT,array('seller_product_id'=>$pid));
        }
        return $checkId;
    }
    
    /*************** NEW CODE END FOR CSV IMPORT FILE **************/
    
}

/* End of file product.php */
/* Location: ./application/controllers/admin/product.php */