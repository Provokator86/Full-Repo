<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This model contains all db functions related to product management
 * @author Teamtweaks
 *
 */
class Product_model extends My_Model
{

	public function add_product($dataArr=''){
		$this->db->insert(PRODUCT,$dataArr);
	}


	public function edit_product($dataArr='',$condition=''){
		$this->db->where($condition);
		$this->db->update(PRODUCT,$dataArr);
	}


	public function view_product($condition=''){
		return $this->db->get_where(PRODUCT,$condition);
			
	}

	public function add_subproduct_insert($dataArr=''){
		$this->db->insert(SUBPRODUCT,$dataArr);
	}

	public function edit_subproduct_update($dataArr='',$condition=''){
		$this->db->where($condition);
		$this->db->update(SUBPRODUCT,$dataArr);
	}


	public function view_product_details($condition = ''){
		$select_qry = "select p.*,u.full_name,u.id as sellerid,u.email as selleremail,u.user_name,u.thumbnail,u.feature_product from ".PRODUCT." p
		LEFT JOIN ".USERS." u on (u.id=p.user_id) ".$condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	public function view_product_details_trending($condition = ''){
		$select_qry = "select p.*,u.full_name,u.id as sellerid,u.email as selleremail,u.user_name,u.thumbnail,u.feature_product from ".PRODUCT." p
		LEFT JOIN ".USERS." u on (u.id=p.user_id) ".$condition." order by likes desc";
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	public function view_notsell_product_details_trending($condition = ''){
		$select_qry = "select p.*,u.full_name,u.user_name,u.thumbnail,u.feature_product from ".USER_PRODUCTS." p LEFT JOIN ".USERS." u on u.id=p.user_id ".$condition." order by likes desc";
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	public function view_product_atrribute_details(){
		$select_qry = "select * from ".PRODUCT_ATTRIBUTE." where status='Active'";
		return $attList = $this->ExecuteQuery($select_qry);
	}

	public function view_subproduct_details($prdId=''){
		$select_qry = "select * from ".SUBPRODUCT." where product_id = '".$prdId."'";
		return $attList = $this->ExecuteQuery($select_qry);

	}

	public function view_subproduct_details_join($prdId=''){
		$select_qry = "select a.*,b.attr_name as attr_type from ".SUBPRODUCT." a join ".PRODUCT_ATTRIBUTE." b on a.attr_id = b.id where a.product_id = '".$prdId."'";
		return $attList = $this->ExecuteQuery($select_qry);

	}

	public function user_liked_prod_details($pid='0')
	{

		$this->db->select('u.*');
		$this->db->from(PRODUCT_LIKES.' as pl');
		$this->db->join(USERS.' as u' , 'u.id = pl.user_id');
		$this->db->where('pl.product_id', $pid);

		$query = $this->db->get();

		return $query;
	}
	public function get_user_product_details($uid='0'){
		$this->db->select('up.*,u.user_name');
		$this->db->from(PRODUCT_LIKES.' as pl');
		$this->db->join(USER_PRODUCTS.' as up' , 'up.seller_product_id = pl.product_id');
		$this->db->join(USERS.' as u' , 'u.id = up.user_id','left');
		$this->db->where('pl.user_id', $uid);

		$query = $this->db->get();
		return $query;
	}

	public function get_product_details($uid='0'){
		$this->db->select('p.*');
		$this->db->from(PRODUCT_LIKES.' as pl');
		$this->db->join(PRODUCT.' as p' , 'p.seller_product_id = pl.product_id');
		$this->db->where('pl.user_id', $uid);

		$query = $this->db->get();
		return $query;
	}

	public function get_product_feedback_details()
	{
		$this->db->select(USERS.'.id as userId,'.USERS.'.user_name as userName,'.PRODUCT.'.id as productId,'.PRODUCT.'.product_name,image as image,'.PRODUCT_FEEDBACK.'.*');
		$this->db->from(PRODUCT);
		$this->db->join(PRODUCT_FEEDBACK,PRODUCT_FEEDBACK.'.product_id='.PRODUCT.'.id','inner');
		$this->db->join(USERS,USERS.'.id='.PRODUCT_FEEDBACK.'.voter_id','inner');
		$this->db->order_by(PRODUCT_FEEDBACK.'.id','desc');
		return $feedback_query = $this->db->get();
	}

	public function get_productfeed_details($condition='')
	{

		$this->db->select('u.id as userId,u.user_name as userName,s.email as seller_email,p.id as productId,p.product_name,image as image,pf.*');
		$this->db->from(PRODUCT.' as p');
		$this->db->join(PRODUCT_FEEDBACK.' as pf','pf.product_id=p.id','inner');
		$this->db->join(USERS.' as u','u.id='.'pf.voter_id','inner');
		$this->db->join(USERS.' as s','s.id='.'pf.seller_id','inner');
		$this->db->order_by('pf.id','desc');
		$this->db->where('pf.id',$condition);
		return $feedback_query = $this->db->get();
	}

	public function get_featured_details($pid='0'){
		$Query = "select p.*,u.full_name,u.user_name,u.thumbnail,u.feature_product from ".PRODUCT." p LEFT JOIN ".USERS." u on u.id=p.user_id where p.seller_product_id=".$pid." and p.status='Publish'";
		$productList = $this->ExecuteQuery($Query);
		$productList->mode = 'sell_product';
		if ($productList->num_rows() != 1){
			$Query = "select p.*,u.full_name,u.user_name,u.thumbnail,u.feature_product from ".USER_PRODUCTS." p LEFT JOIN ".USERS." u on u.id=p.user_id where p.seller_product_id=".$pid." and p.status='Publish'";
			$productList = $this->ExecuteQuery($Query);
			$productList->mode = 'user_product';
		}
		return $productList;
	}

	public function get_wants_product($wantList){
		$productList = '';
		if ($wantList->num_rows() == 1){
			$productIds = array_filter(explode(',', $wantList->row()->product_id));
			if (count($productIds)>0){
				$this->db->where_in('p.seller_product_id',$productIds);
				$this->db->where('p.status','Publish');
				$this->db->select('p.*,u.full_name,u.user_name,u.thumbnail,u.feature_product');
				$this->db->from(PRODUCT.' as p');
				$this->db->join(USERS.' as u','u.id=p.user_id');
				$productList = $this->db->get();
			}
		}
		return $productList;
	}

	public function get_notsell_wants_product($wantList){
		$productList = '';
		if ($wantList->num_rows() == 1){
			$productIds = array_filter(explode(',', $wantList->row()->product_id));
			if (count($productIds)>0){
				$this->db->where_in('p.seller_product_id',$productIds);
				$this->db->where('p.status','Publish');
				$this->db->select('p.*,u.full_name,u.user_name,u.thumbnail,u.feature_product');
				$this->db->from(USER_PRODUCTS.' as p');
				$this->db->join(USERS.' as u','u.id=p.user_id');
				$productList = $this->db->get();
			}
		}
		return $productList;
	}

	public function view_notsell_product_details($condition = ''){
		$select_qry = "select p.*,u.full_name,u.user_name,u.thumbnail,u.feature_product from ".USER_PRODUCTS." p LEFT JOIN ".USERS." u on u.id=p.user_id ".$condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
			
	}

	public function view_atrribute_details(){
		$select_qry = "select * from ".ATTRIBUTE." where status='Active'";
		return $attList = $this->ExecuteQuery($select_qry);

	}


	public function view_category_details(){

		$select_qry = "select * from ".CATEGORY." where rootID=0";
		$categoryList = $this->ExecuteQuery($select_qry);
		$catView='';$Admpriv = 0;$SubPrivi = '';

		foreach ($categoryList->result() as $CatRow){

			$catView .= $this->view_category_list($CatRow,'1');

			$sel_qry = "select * from ".CATEGORY." where rootID='".$CatRow->id."'  ";
			$SubList = $this->ExecuteQuery($sel_qry);

			foreach ($SubList->result() as $SubCatRow){
					
				$catView .= $this->view_category_list($SubCatRow,'2');
					
				$sel_qry1 = "select * from ".CATEGORY." where rootID='".$SubCatRow->id."'  ";
				$SubList1 = $this->ExecuteQuery($sel_qry1);
					
				foreach ($SubList1->result() as $SubCatRow1){
					$catView .= $this->view_category_list($SubCatRow1,'3');

					$sel_qry2 = "select * from ".CATEGORY." where rootID='".$SubCatRow1->id."'  ";
					$SubList2 = $this->ExecuteQuery($sel_qry2);

					foreach ($SubList2->result() as $SubCatRow2){
						$catView .= $this->view_category_list($SubCatRow2,'4');

					}
				}
			}
		}
			
		return $catView;
	}

	public function view_category_list($CatRow,$val){
		$SubcatView ='';
		$SubcatView .= '<span class="cat'.$val.'"><input name="category_id[]" class="checkbox" type="checkbox" value="'.$CatRow->id.'" tabindex="7"><strong>'.$CatRow->cat_name.' &nbsp;</strong></span>';
		return $SubcatView;
	}

	public function get_category_details($catList=''){
		$catListArr = explode(',', $catList);
		$select_qry = "select * from ".CATEGORY." where rootID=0";
		$categoryList = $this->ExecuteQuery($select_qry);
		$catView='';$Admpriv = 0;$SubPrivi = '';

		foreach ($categoryList->result() as $CatRow){

			$catView .= $this->get_category_list($CatRow,'1',$catListArr);

			$sel_qry = "select * from ".CATEGORY." where rootID='".$CatRow->id."'  ";
			$SubList = $this->ExecuteQuery($sel_qry);

			foreach ($SubList->result() as $SubCatRow){
					
				$catView .= $this->get_category_list($SubCatRow,'2',$catListArr);
					
				$sel_qry1 = "select * from ".CATEGORY." where rootID='".$SubCatRow->id."'  ";
				$SubList1 = $this->ExecuteQuery($sel_qry1);
					
				foreach ($SubList1->result() as $SubCatRow1){
					$catView .= $this->get_category_list($SubCatRow1,'3',$catListArr);

					$sel_qry2 = "select * from ".CATEGORY." where rootID='".$SubCatRow1->id."'  ";
					$SubList2 = $this->ExecuteQuery($sel_qry2);

					foreach ($SubList2->result() as $SubCatRow2){
						$catView .= $this->get_category_list($SubCatRow2,'4',$catListArr);

					}
				}
			}
		}
		return $catView;
	}

	public function get_category_list($CatRow,$val,$catListArr=''){
		$SubcatView ='';
		if (in_array($CatRow->id, $catListArr)){
			$checkStr = 'checked="checked"';
		}else {
			$checkStr = '';
		}
		$SubcatView .= '<span class="cat'.$val.'"><input name="category_id[]" '.$checkStr.' class="checkbox" type="checkbox" value="'.$CatRow->id.'" tabindex="7"><strong>'.$CatRow->cat_name.' &nbsp;</strong></span>';
		return $SubcatView;
	}

	public function get_cat_list($ids=''){
		$this->db->where_in('id',explode(',', $ids));
		return $this->db->get(CATEGORY);
	}

	public function get_top_users_in_category($cat=''){
		$productArr = array();
		$userArr = array();
		$userCountArr = array();
		$condition = " where p.category_id like '".$cat.",%' AND p.status = 'Publish' OR p.category_id like '%,".$cat."' AND p.status = 'Publish' OR p.category_id like '%,".$cat.",%' AND p.status = 'Publish' OR p.category_id='".$cat."' AND p.status = 'Publish'";
		$productDetails = $this->view_product_details($condition);
		if ($productDetails->num_rows()>0){
			foreach ($productDetails->result() as $productRow){
				if (!in_array($productRow->id, $productArr)){
					array_push($productArr, $productRow->id);
					if ($productRow->user_id != ''){
						if (!in_array($productRow->user_id, $userArr)){
							array_push($userArr, $productRow->user_id);
							$userCountArr[$productRow->user_id] = 1;
						}else {
							$userCountArr[$productRow->user_id]++;
						}
					}
				}
			}
		}
		arsort($userCountArr);
		return $userCountArr;
	}

	public function get_recent_like_users($pid='',$limit='10',$sort='desc'){
		$Query = 'select pl.*, p.product_name, p.likes, u.full_name, u.user_name,u.thumbnail from '.PRODUCT_LIKES.' pl
					JOIN '.PRODUCT.' p on p.seller_product_id=pl.product_id 
					JOIN '.USERS.' u on u.id=pl.user_id and u.status="Active"
					where pl.product_id="'.$pid.'" order by pl.id '.$sort.' limit '.$limit;
		return $this->ExecuteQuery($Query);
	}

	public function get_recent_user_likes($uid='',$pid='',$limit='3',$sort='desc'){
		$condition = '';
		if ($pid!=''){
			$condition = ' and pl.product_id != "'.$pid.'" ';
		}
		$Query = 'select pl.*,u.user_name,u.full_name,u.thumbnail,p.product_name,p.id as PID,p.created,p.sale_price,p.image from '.PRODUCT_LIKES.' pl
					JOIN '.USERS.' u on u.id=pl.user_id 
					JOIN '.PRODUCT.' p on p.seller_product_id=pl.product_id
					JOIN '.USERS.' u1 on u1.id=p.user_id and u1.group="Seller" and u1.status="Active"
					where pl.user_id = "'.$uid.'" '.$condition.' order by pl.id '.$sort.' limit '.$limit;
		return $this->ExecuteQuery($Query);
	}

	public function get_like_user_full_details($pid='0'){
		$Query = "select u.* from ".PRODUCT_LIKES.' p
					JOIN '.USERS.' u on u.id=p.user_id
					where p.product_id='.$pid;
		return $this->ExecuteQuery($Query);
	}

	public function getCategoryValues($selVal,$whereCond) {
		$sel = 'select '.$selVal.' from '.CATEGORY.' c LEFT JOIN '.CATEGORY.' sbc ON c.id = sbc.rootID '.$whereCond.' ';
		return $this->ExecuteQuery($sel);
	}

	public function getCategoryResults($selVal,$whereCond) {
		$sel = 'select '.$selVal.' from '.CATEGORY.' '.$whereCond.' ';
		return $this->ExecuteQuery($sel);
	}

	public function searchShopyByCategory($whereCond) {
		$sel = 'select p.* from '.PRODUCT.' p
		 		LEFT JOIN '.USERS.' u on u.id=p.user_id 
		 		'.$whereCond.' ';
		return $this->ExecuteQuery($sel);
	}

	public function add_user_product($uid=''){
		$returnStr = array();
		$seller_product_id = mktime();
		$checkId = $this->check_product_id($seller_product_id);
		while ($checkId->num_rows()>0){
			$seller_product_id = mktime();
			$checkId = $this->check_product_id($seller_product_id);
		}
		$returnStr['pid'] = $seller_product_id;
		$returnStr['image'] = '';
		$image_name = $this->input->post('image');
		if ($this->input->post('tag_url') && $this->input->post('photo_url')!=''){

			/****----------Move image to server-------------****/

			$image_url = trim(addslashes($this->input->post('photo_url')));

			$img_data = file_get_contents($image_url);

			$img_full_name = substr($image_url, strrpos($image_url, '/')+1);
			$img_name_arr = explode('.', $img_full_name);
			$img_name = $img_name_arr[0];
			$ext = $img_name_arr[1];
			$new_name = str_replace(',', '', $img_name.mktime().'.'.$ext);
			$new_name = str_replace('?', '', $new_name);
			$new_img = 'images/product/'.$new_name;

			file_put_contents($new_img, $img_data);
			$returnStr['image'] = $new_name;

			/****----------Move image to server-------------****/

			$image_name = $new_name;

		}

		$seo_url = url_title($this->input->post('name'),'-');
		if ($seo_url == ''){
			$seo_url = str_replace(' ', '-', $this->input->post('name'));
		}
		$store_url = prep_url($this->input->post('link'));
		$store_name = parse_url($store_url,PHP_URL_HOST);

		$dataArr = array(
			'product_name'	=>	$this->input->post('name'),
			'seourl'		=>	$seo_url,
			'web_link'		=>	$this->input->post('link'),
			'category_id'	=>	$this->input->post('category'),
			'excerpt'		=>	$this->input->post('note'),
			'image'			=>	$image_name,
			'user_id'		=>	$uid,
			'price'			=>	$this->input->post('price'),
			'seller_product_id' => $seller_product_id,
			'affiliate_code'	=>	$this->input->post('affiliate_code'),
			'affiliate_script'	=>	$this->input->post('affiliate_script'),
			'store_name'	=>	$store_name
		);
		$this->simple_insert(USER_PRODUCTS,$dataArr);
		if ($store_name){
			$check_store_name = $this->get_all_details(SHOPS,array('store_url'=>$store_name));
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
				$this->update_details(SHOPS,$dataArr,$condArr);
			}else {
				$dataArr = array('store_name'=>$store_name,'store_url'=>$store_name,'products'=>$seller_product_id,'products_count'=>1);
				$this->simple_insert(SHOPS,$dataArr);
			}
		}
		return $returnStr;
	}

	public function check_product_id($pid=''){
		$checkId = $this->get_all_details(USER_PRODUCTS,array('seller_product_id'=>$pid));
		if ($checkId->num_rows()==0){
			$checkId = $this->get_all_details(PRODUCT,array('seller_product_id'=>$pid));
		}
		return $checkId;
	}

	public function check_product_weblink($weblinkk=''){
		$checkWeblink = $this->get_all_details(USER_PRODUCTS,array('web_link'=>$weblinkk));
		/*if ($checkWeblink->num_rows()==0){
			$checkWeblink = $this->get_all_details(PRODUCT,array('web_link'=>$weblinkk));
			}*/
		return $checkWeblink;
	}

	public function get_products_by_category($categoryid='',$sort='desc'){
		$Query = "select p.*,u.user_name,u.full_name,u.thumbnail from ".PRODUCT." p
			LEFT JOIN ".USERS." u on u.id=p.user_id
			where p.status='Publish' and FIND_IN_SET('".$categoryid."',p.category_id) order by p.`created` ".$sort;
		return $this->ExecuteQuery($Query);
	}

	/*public function view_product_comments_details($condition = ''){
		$select_qry = "select p.product_name,c.product_id,u.full_name,u.user_name,u.thumbnail,c.comments ,u.email,c.id,c.status,c.dateAdded,c.user_id as CUID
		from ".PRODUCT_COMMENTS." c
		LEFT JOIN ".USERS." u on u.id=c.user_id
		LEFT JOIN ".PRODUCT." p on p.seller_product_id=c.product_id ".$condition;
		$productComment = $this->ExecuteQuery($select_qry);
		return $productComment;
		}*/

	public function view_product_comments_details($condition = ''){
		$select_qry = "select p.product_name,c.product_id,u.full_name,u.user_name,u.thumbnail,c.comments ,u.email,c.id,c.status,c.dateAdded,c.user_id as CUID
		from ".PRODUCT_COMMENTS." c 
		LEFT JOIN ".USERS." u on u.id=c.user_id 
		LEFT JOIN ".PRODUCT." p on p.seller_product_id=c.product_id ".$condition;
		$productComment = $this->ExecuteQuery($select_qry);
		return $productComment;
	}

	public function Update_Product_Comment_Count($product_id){

		$Query = "UPDATE ".PRODUCT." SET comment_count=(comment_count + 1) WHERE seller_product_id='".$product_id."'";
		$this->ExecuteQuery($Query);
	}
	public function Update_Product_Comment_Count_Reduce($product_id){

		$Query = "UPDATE ".PRODUCT." SET comment_count=(comment_count - 1) WHERE seller_product_id='".$product_id."'";
		return $this->ExecuteQuery($Query);
	}
	public function get_products_search_results($search_key='',$limit='5'){
		$Query = 'select p.* from '.PRODUCT.' p
				LEFT JOIN '.USERS.' u on u.id=p.user_id
				where p.product_name like "%'.$search_key.'%" and p.status="Publish" and p.quantity>0 and u.status="Active" and u.group="Seller"
				or p.product_name like "%'.$search_key.'%" and p.status="Publish" and p.quantity>0 and p.user_id=0
				limit '.$limit;
		return $this->ExecuteQuery($Query);
	}
	public function get_user_search_results($search_key='',$limit='5'){
		$Query = 'select * from '.USERS.' where full_name like "%'.$search_key.'%" and status="Active" OR user_name like "%'.$search_key.'%" and status="Active" limit '.$limit;
		return $this->ExecuteQuery($Query);
	}

	public function get_product_full_details($pid='0'){
		$Query = "select p.*,u.full_name,u.user_name,u.thumbnail,u.feature_product,u.email,u.email_notifications,u.notifications from ".PRODUCT." p LEFT JOIN ".USERS." u on u.id=p.user_id where p.seller_product_id='".$pid."'";
		$productDetails = $this->ExecuteQuery($Query);
		if ($productDetails->num_rows() == 0){
			$Query = "select p.*,u.full_name,u.user_name,u.thumbnail,u.feature_product,u.email,u.email_notifications,u.notifications from ".USER_PRODUCTS." p LEFT JOIN ".USERS." u on u.id=p.user_id where p.seller_product_id='".$pid."'";
			$productDetails = $this->ExecuteQuery($Query);
			$productDetails->prodmode = 'user';
		}else {
			$productDetails->prodmode = 'seller';
		}
		return $productDetails;
	}

	public function get_user_created_lists($pid='0'){
		$Query = "select * from ".LISTS_DETAILS." where FIND_IN_SET('".$pid."',product_id)";
		return $this->ExecuteQuery($Query);
	}

	public function get_user_product_lists($pid='0'){

		$Query = "select * from ".PRODUCT." WHERE seller_product_id IN ('".$pid."')";
		//$Query = "select * from ".LISTS_DETAILS." where FIND_IN_SET('".$pid."',user_id)";
		return $this->ExecuteQuery($Query);
	}
	public function get_slider_details($condition=''){
		$Query = " select * from ".SLIDER." ".$condition;
		return $this->ExecuteQuery($Query);
	}
	public function get_activity_details($uid='0',$limit='5',$sort='desc'){
		$Query = 'select a.*,p.product_name,p.id as productID,up.product_name as user_product_name,u.full_name,u.user_name from '.USER_ACTIVITY.' a
   					LEFT JOIN '.PRODUCT.' p on a.activity_id=p.seller_product_id
   					LEFT JOIN '.USER_PRODUCTS.' up on a.activity_id=up.seller_product_id
   					LEFT JOIN '.USERS.' u on a.activity_id=u.id
   					where a.user_id='.$uid.' order by a.activity_time '.$sort.' limit '.$limit;
		return $this->ExecuteQuery($Query);
	}

	public function get_top_stores(){
		$returnCnt = array();
		$returnCnt['store_lists'] = $store_lists = $this->get_all_details(SHOPS,array(),array(array('field'=>'followers_count','type'=>'desc')),'20');
		if ($store_lists->num_rows()>0){
			foreach ($store_lists->result() as $store_lists_row){
				$product_ids = array_filter(explode(',', $store_lists_row->products));
				if (count($product_ids)>0){
					$this->db->select('p.*,u.user_name,u.full_name,u.thumbnail');
					$this->db->where_in('p.seller_product_id',$product_ids);
					$this->db->from(USER_PRODUCTS.' as p');
					$this->db->join(USERS.' as u','u.id=p.user_id','left');
					$affilProdDetails = $this->db->get();

					$returnCnt['prodDetails'][$store_lists_row->id] = $affilProdDetails;
				}else {
					$returnCnt['prodDetails'][$store_lists_row->id] = '';
				}
			}
		}
		return $returnCnt;
	}

	public function get_top_people(){
		$returnCnt = array();
		$returnCnt['store_lists'] = $store_lists = $this->get_all_details(USERS,array('group'=>'User','status'=>'Active'),array(array('field'=>'followers_count','type'=>'desc')),'20');
		if ($store_lists->num_rows()>0){
			foreach ($store_lists->result() as $store_lists_row){
				//				$returnCnt['prodDetails'][$store_lists_row->id] = $this->get_recent_user_likes($store_lists_row->id,'','8','desc');
				$returnCnt['prodDetails'][$store_lists_row->id] = $this->get_all_details(USER_PRODUCTS,array('status'=>'Publish','user_id'=>$store_lists_row->id),array(array('field'=>'created','type'=>'desc')),'8');
			}
		}
		return $returnCnt;
	}

	public function get_products_by_userid($uid='0',$status='',$field='created',$type='desc'){
		$cond_arr['user_id'] = $uid;
		if ($status != ''){
			$cond_arr['status'] = $status;
		}
		$sell_products = $this->get_all_details(PRODUCT,$cond_arr);
		$affl_products = $this->get_all_details(USER_PRODUCTS,$cond_arr);
		return $this->get_sorted_array($sell_products,$affl_products,$field,$type);
	}

	public function get_people($key=''){
		if ($key != ''){
			$Query = "select * from ".USERS." where user_name like '%".$key."%' and status='Active' and `group`='User' or full_name like '%".$key."%' and status='Active' and `group`='User'";
			return $this->ExecuteQuery($Query);
		}
	}

	public function get_sellers($key=''){
		if ($key != ''){
			$Query = "select * from ".SHOPS." where store_name like '%".$key."%'";
			return $this->ExecuteQuery($Query);
		}
	}

	public function get_both_products($uid='',$status='Publish'){
		$condition = ' where p.status="'.$status.'"';
		if ($uid!=''){
			$condition .= ' and p.user_id = "'.$uid.'"';
		}
		$Query = "
			select p.id,p.seller_product_id,p.user_id,p.product_name,p.price,p.sale_price,p.image,'None' as web_link,p.category_id,
				u.user_name,u.full_name,u.thumbnail,u.email
				from ".PRODUCT." p
				left join ".USERS." u on p.user_id=u.id
				".$condition."
			UNION
			select p.id,p.seller_product_id,p.user_id,p.product_name,'None' as price,'None' as sale_price,p.image,p.web_link,p.category_id,
				u.user_name,u.full_name,u.thumbnail,u.email
				from ".USER_PRODUCTS." p
				left join ".USERS." u on p.user_id=u.id
				".$condition."
		";
		return $this->ExecuteQuery($Query);
	}

	/*public function get_category_product($prod_cate,$prod_seller_id)
	 {
		$query="select * from ".USER_PRODUCTS." where category_id='".$prod_cate."' and seller_product_id!='".$prod_seller_id."'";
		return $this->ExecuteQuery($query);
		}*/

	public function get_category_product($prod_cate,$prod_seller_id)
	{

		$cat_cond = '';
		$cat_id_arr = array_filter(explode(',',$prod_cate));
		if(count($cat_id_arr)>0){
			foreach($cat_id_arr as $cat_id_row){
				if($cat_cond != ''){
					$cat_cond .= ' or ';
				}else{
					$cat_cond = ' and ( ';
				}
				$cat_cond .= ' FIND_IN_SET("'.$cat_id_row.'",p.category_id) ';
			}
			$cat_cond .= ' ) ';
		}

		$condition = ' where p.seller_product_id!="'.$prod_seller_id.'" '.$cat_cond;
		//echo $condition;die;
		$query = "select p.id,p.seller_product_id,p.user_id,p.product_name,p.likes,p.price,'None' as sale_price,p.image,p.web_link,p.category_id,
				u.user_name,u.full_name,u.thumbnail,u.email
				from ".USER_PRODUCTS." p
				left join ".USERS." u on p.user_id=u.id
				".$condition."
			UNION
			select p.id,p.seller_product_id,p.user_id,p.product_name,p.likes,p.price,p.sale_price,p.image,'None' as web_link,p.category_id,
				u.user_name,u.full_name,u.thumbnail,u.email
				from ".PRODUCT." p
				left join ".USERS." u on p.user_id=u.id
				".$condition."
		";

		return $this->ExecuteQuery($query);
	}

	public function get_username($usernamee)
	{
		$query="select * from ".USERS." where id='".$usernamee."'";
		return $this->ExecuteQuery($query);
	}

	public function get_product_save($product_idd)
	{
		/*$this->db->select('u.*');
		 $this->db->from(PRODUCT_LIKES.' as pl');
		 $this->db->join(USERS.' as u' , 'u.id = pl.user_id');
		 $this->db->where('pl.product_id', $product_idd);
		 $query = $this->db->get();
		 return $query;*/

		//$query = "select u.* from ".PRODUCT_LIKES.' p JOIN '.USERS.' u on u.id=p.user_id where p.product_id='.$product_idd;
		//$query = "select u.* from ".PRODUCT_LIKES.' p JOIN '.USERS.' u on u.id=p.user_id where p.product_id='.$product_idd.' limit 0,6';
		$query="select COUNT(*) as count from ".PRODUCT_LIKES." where product_id='$product_idd'";
		return $this->ExecuteQuery($query);
	}

	public function get_user_image($product_idd)
	{
		//$query = "select u.* from ".PRODUCT_LIKES.' p JOIN '.USERS.' u on u.id=p.user_id where p.product_id='.$product_idd.' order by id desc limit 0,6';
		$query = "select u.* from ".PRODUCT_LIKES.' p JOIN '.USERS.' u on u.id=p.user_id where p.product_id='.$product_idd.' order by p.id desc limit 0,6';
		return $this->ExecuteQuery($query);
	}

	public function get_hotness_products($whereCond,$limit=''){
		if ($limit != '')$limit = 'limit '.$limit;
		$Query = "(SELECT
					p.id,p.seller_product_id,p.user_id,p.product_name,p.image,p.likes,p.price,p.sale_price,'None' as web_link, 
					LOG10(p.likes + 1) * 287015 + UNIX_TIMESTAMP(p.created) AS Hotness,
					u.full_name,u.user_name,u.thumbnail,u.feature_product
					FROM ".PRODUCT." p 
					LEFT JOIN ".USERS." u on (u.id=p.user_id) 
					".$whereCond.")
				UNION
					(SELECT
					p.id,p.seller_product_id,p.user_id,p.product_name,p.image,p.likes,p.price,'None' as sale_price,p.web_link, 
					LOG10(p.likes + 1) * 287015 + UNIX_TIMESTAMP(p.created) AS Hotness,
					u.full_name,u.user_name,u.thumbnail,u.feature_product
					FROM ".USER_PRODUCTS." p 
					LEFT JOIN ".USERS." u on (u.id=p.user_id) 
					".$whereCond.")
				ORDER BY Hotness DESC ".$limit;
		return $this->ExecuteQuery($Query);
	}

	public function get_prodcuts_from_user_ids($uidArr='',$cond_arr='',$table=PRODUCT,$limitPaging=''){
		if ($uidArr!='' && is_array($uidArr) && count($uidArr)>0){
			$this->db->where_in('user_id', $uidArr);
			if ($cond_arr!=''){
				$this->db->where($cond_arr);
			}
			if ($limitPaging!=''){
				$this->db->limit($limitPaging);
			}
			$this->db->from($table);
			return $this->db->get();
		}
	}

	/*public function add_report($dataArr=''){
		$this->db->insert(REPORT_ISSUES,$dataArr);
		}*/

	/*function insertEditCustomerValues($getAddEditDetails=array())
	 {
		print_r($getAddEditDetails); die;
		$this->db->insert(REPORT_ISSUES,$getAddEditDetails);
		return 1;
		}*/

	public function add_report($report_values){
		$dataArr = array();
			
		$name=$this->input->post('name');
		$user_id=$this->input->post('sellerid');
		$product_id=$this->input->post('productid');
			
		$dataArr = array(
			'name'	=>	$name,
			'user_id'	=>	$user_id,
			'product_id' =>	$product_id,
			'created'	=>	mdate($this->data['datestring'],time())
		);
		//$this->simple_insert(REPORT_ISSUES,$dataArr);
		$this->db->simple_insert('REPORT_ISSUES',$dataArr);
	}

	public function get_prodcuts_from_ids($pidArr='',$cond_arr='',$table=PRODUCT,$limitPaging=''){
		if ($pidArr!='' && is_array($pidArr) && count($pidArr)>0){
			$this->db->where_in('seller_product_id', $pidArr);
			if ($cond_arr!=''){
				$this->db->where($cond_arr);
			}
			if ($limitPaging!=''){
				$this->db->limit($limitPaging);
			}
			$this->db->from($table);
			return $this->db->get();
		}
	}

	public function get_products_category($magic_cat,$limitPaging)
	{
		$cat_cond = '';
		$cat_id_arr = array_filter(explode(',',$magic_cat));
		if(count($cat_id_arr)>0){
			foreach($cat_id_arr as $cat_id_row){
				if($cat_cond != ''){
					$cat_cond .= ' or ';
				}else{
					$cat_cond = ' ( ';
				}
				$cat_cond .= ' FIND_IN_SET("'.$cat_id_row.'",p.category_id) ';
			}
			$cat_cond .= ' ) ';
		}

		/*if($magic_cat!='') {
			$condition = ' where '.$cat_cond; }*/
			
		//$condition = ' where p.seller_product_id!="'.$prod_seller_id.'" '.$cat_cond;
			
		if($magic_cat!='') {
			$condition = ' where '.$cat_cond;
		} else {
			$condi_none = ' '; }

			$query = "select p.id,p.seller_product_id,p.user_id,p.product_name,p.likes,p.price,'None' as sale_price,p.image,p.web_link,p.category_id,
				u.user_name,u.full_name,u.thumbnail,u.email
				from ".USER_PRODUCTS." p
				left join ".USERS." u on p.user_id=u.id
				".$condition."
			UNION
			select p.id,p.seller_product_id,p.user_id,p.product_name,p.likes,p.price,p.sale_price,p.image,'None' as web_link,p.category_id,
				u.user_name,u.full_name,u.thumbnail,u.email
				from ".PRODUCT." p
				left join ".USERS." u on p.user_id=u.id
				".$condition."
		"; 

			return $this->ExecuteQuery($query);
	}

	/*public function product_feedback_view($seller_id){
		if ($seller_id == '')$seller_id=0;
		$this->db->select(array(PRODUCT_FEEDBACK.'.*',USERS.'.full_name',USERS.'.user_name',USERS.'.thumbnail',PRODUCT.'.product_name',PRODUCT.'.image'));
		$this->db->from(PRODUCT_FEEDBACK);
		$this->db->join(USERS, USERS.'.id = '.PRODUCT_FEEDBACK.'.voter_id');
		$this->db->join(PRODUCT, PRODUCT.'.id = '.PRODUCT_FEEDBACK.'.product_id');
		$this->db->where(array(PRODUCT_FEEDBACK.'.seller_id'=>$seller_id,PRODUCT_FEEDBACK.'.status'=>'Active'));
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
		}*/

	public function product_feedback_view($seller_id){
		if ($seller_id == '')$seller_id=0;
		$this->db->select(array(PRODUCT_FEEDBACK.'.*',USERS.'.full_name',USERS.'.user_name',USERS.'.thumbnail',PRODUCT.'.product_name',PRODUCT.'.image'));
		$this->db->from(PRODUCT_FEEDBACK);
		$this->db->join(USERS, USERS.'.id = '.PRODUCT_FEEDBACK.'.voter_id');
		$this->db->join(PRODUCT, PRODUCT.'.id = '.PRODUCT_FEEDBACK.'.product_id');
		$this->db->where(array(PRODUCT_FEEDBACK.'.seller_id'=>$seller_id,PRODUCT_FEEDBACK.'.status'=>'Active'));
		$this->db->order_by(PRODUCT_FEEDBACK.'.id','desc');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	public function get_trending_hashtags(){
		$Query = "select *, (products_count+stories_count+followers_count) as count from ".TAGS_PRODUCT." order by count desc";
		return $this->ExecuteQuery($Query);
	}
    
    
    /******************** START NEW CODE 4 JAN 2014 ********************/
    public function get_follows_stores($s_condn=''){
        $returnCnt = array();
        $sqry   = "SELECT * FROM ".SHOPS." ".($s_condn!=''?$s_condn:"");
        $rs     = $this->db->query($sqry);
        $returnCnt = $store_lists = $rs;
        return (object)$returnCnt;
    }
    
    public function get_follows_stores_products($product_ids='',$store_lists_row_id){
        $returnCnt = array();
      
        if (count($product_ids)>0){
            $this->db->select('p.*,u.user_name,u.full_name,u.thumbnail');
            $this->db->where_in('p.seller_product_id',$product_ids);
            $this->db->from(USER_PRODUCTS.' as p');
            $this->db->join(USERS.' as u','u.id=p.user_id','left');
            $affilProdDetails = $this->db->get();
            $returnCnt['prodDetails'][$store_lists_row_id] = $affilProdDetails;
        }else {
            $returnCnt['prodDetails'][$store_lists_row_id] = '';
        }
        return $returnCnt;
    }
    
    public function get_product_list($s_where=null,$i_start=null,$i_limit=null)
    {
        $ret_=array();
        $s_qry="SELECT p.*,brnd.brand_name AS s_brand,brnd.brand_url,u.full_name,u.id as sellerid,u.email as selleremail,
                u.user_name,u.thumbnail,u.feature_product,b.id FROM ".USER_PRODUCTS." AS p ".
                "LEFT JOIN ".USERS." AS u ON u.id = p.user_id "
                ." LEFT JOIN ".SHOPS." b ON FIND_IN_SET(p.seller_product_id,b.products) > 0 "
                ." LEFT JOIN ".BRANDS." brnd ON brnd.brand_url= p.brand_name "
                .($s_where!=""?$s_where:"" )." ORDER BY p.id DESC "
                .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
        
        $rs=$this->db->query($s_qry);
        $ret_ = $rs->result_array();
        return $ret_;
    }
    
    
    public function count_product_list($s_where=null) 
    {
        $ret_=0;
        $s_qry="SELECT COUNT(p.id) as i_total "
            ."FROM ".USER_PRODUCTS." p "
            ."LEFT JOIN ".USERS." AS u ON u.id = p.user_id "
            ." LEFT JOIN ".SHOPS." b ON FIND_IN_SET(p.seller_product_id,b.products) > 0 "
            .($s_where!=""?$s_where:"" );
        $rs=$this->db->query($s_qry);
        $i_cnt=0;
        if($rs->num_rows()>0)
        {
          foreach($rs->result() as $row)
          {
              $ret_=intval($row->i_total); 
          }   
          $rs->free_result(); 
        }
        unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit);
        return $ret_;
    }
    
    
    public function get_top_brands(){
        $returnCnt = array();
        $returnCnt['brand_lists'] = $brand_lists = $this->get_all_details(BRANDS,array(),array(array('field'=>'followers_count','type'=>'desc')),'20');
        if ($brand_lists->num_rows()>0){
            foreach ($brand_lists->result() as $brand_lists_row){
                
                $product_ids = array_filter(explode(',', $brand_lists_row->products));
                
                if (count($product_ids)>0){
                    $this->db->select('p.*,u.user_name,u.full_name,u.thumbnail');
                    $this->db->where_in('p.seller_product_id',$product_ids);
                    $this->db->from(USER_PRODUCTS.' as p');
                    $this->db->join(USERS.' as u','u.id=p.user_id','left');
                    $this->db->order_by('p.seller_product_id','desc');
                    $affilProdDetails = $this->db->get();

                    $returnCnt['prodDetails'][$brand_lists_row->i_id] = $affilProdDetails;
                }else {
                    $returnCnt['prodDetails'][$brand_lists_row->i_id] = '';
                }
            }
        }
        return $returnCnt;
    }
    
    
    public function get_distinct_brand_list($s_where=null,$i_start=null,$i_limit=null)
    {
        $ret_=array();
        $s_qry="SELECT DISTINCT(p.brand_name) AS s_brand,b.brand_name FROM ".USER_PRODUCTS." AS p "
                ." LEFT JOIN ".BRANDS." b ON b.brand_url = p.brand_name "
                .($s_where!=""?$s_where:"" )." ORDER BY b.brand_name ASC "
                .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
                
        $rs=$this->db->query($s_qry);
        $ret_ = $rs->result_array();
        return $ret_;
    }
    
    /******************** END NEW CODE 4 JAN 2014 ********************/
    
}
?>