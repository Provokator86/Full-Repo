<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This model contains all db functions related to tags management
 * @author Teamtweaks
 *
 */
class Tags_model extends My_Model
{
	public function __construct() 
	{
		parent::__construct();
	}
	
	
	public function view_tag_seller_products($condition = ''){
		$select_qry = "select p.*,u.full_name,u.id as sellerid,u.email as selleremail,u.user_name,u.thumbnail,u.feature_product from ".PRODUCT." p
		LEFT JOIN ".USERS." u on (u.id=p.user_id) ".$condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}
	public function view_tag_user_products($condition = ''){
		$select_qry = "select p.*,u.full_name,u.user_name,u.thumbnail,u.feature_product from ".USER_PRODUCTS." p LEFT JOIN ".USERS." u on u.id=p.user_id ".$condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}
	public function view_tag_stories_products($condition = ''){
		$select_qry = "select p.*,u.full_name,u.id as sellerid,u.email as selleremail,u.user_name,u.thumbnail,u.feature_product from ".PRODUCT." p
		LEFT JOIN ".USERS." u on (u.id=p.user_id) ".$condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}
	public function view_tag_stories_user_products($condition = ''){
		$select_qry = "select p.*,u.full_name,u.user_name,u.thumbnail,u.feature_product from ".USER_PRODUCTS." p LEFT JOIN ".USERS." u on u.id=p.user_id ".$condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}
	public function get_stories_details($stories_id_str = ''){
			$stories_id_str = explode(',', $stories_id_str);
			$this->db->select('s.*,u.user_name,u.full_name,u.thumbnail'); 
			$this->db->from(STORIES.' as s');
			$this->db->join(USERS.' as u', 'u.id = s.user_id');
			$this->db->where_in('s.id', $stories_id_str);
			$query = $this->db->get();
			return $query;
		}
		
		
	public function get_all_StoriesProduct($Pid){
	$Pidarr=array_filter(explode(',',$Pid));
	foreach($Pidarr as $Pidvar){
		$Query = "select p.*,p.id as PID,u.user_name,u.full_name,u.email,u.thumbnail from ".PRODUCT." as p LEFT JOIN ".USERS." u on u.id=p.user_id  where p.seller_product_id ='".$Pidvar."' order by p.id desc";
		$StoriesProduct = $this->ExecuteQuery($Query);
		if($StoriesProduct->num_rows()>0){
			$ret['StoriesProduct'][] = $StoriesProduct->result();
		}else{
			$Query = "select p.*,u.user_name,u.full_name,u.email,u.thumbnail from ".USER_PRODUCTS." as p LEFT JOIN ".USERS." u on u.id=p.user_id
		 where p.seller_product_id ='".$Pidvar."' order by p.id desc";
			$StoriesUserProduct = $this->ExecuteQuery($Query);
			if($StoriesUserProduct->num_rows()>0){
				$ret['StoriesUserProduct'][] = $StoriesUserProduct->result();
			}
		}
	}	//echo '<pre>';print_r($ret['StoriesProduct']);die;
	return $ret;
	}	
	
	public function view_stories_comments_details($condition = ''){
		$select_qry = "select c.comments ,c.id,c.status,c.dateAdded,c.user_id as CUID,u.user_name as UserName,u.full_name,u.thumbnail
		from ".STORIES_COMMENTS." c 
		LEFT JOIN ".USERS." u on u.id=c.user_id
		LEFT JOIN ".STORIES." p on p.id=c.stories_id ".$condition;
		$productComment = $this->ExecuteQuery($select_qry);
		return $productComment;
			
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
	
	
	/*public function tag_seller_product_followers($tag_followers_id_str = ''){
			$followers_id_str = explode(',', $tag_followers_id_str);
			$this->db->select('tg.*,u.user_name,u.full_name,u.thumbnail,p.seller_product_id,p.id,p.product_name,p.image'); 
			$this->db->from(TAGS_PRODUCT.' as tg');
			$this->db->join(USERS.' as u', 'u.id = tg.user_id');
			$this->db->join(PRODUCT.' as p', 'p.seller_product_id = tg.products');
			$this->db->where_in('tg.followers', $followers_id_str);
			$query = $this->db->get();
			return $query;
		}		
	public function tag_user_product_followers($tag_followers_id_str = ''){
			$followers_id_str = explode(',', $tag_followers_id_str);
			$this->db->select('tg.*,u.user_name,u.full_name,u.thumbnail,up.seller_product_id,up.id,up.product_name,up.image,up.web_link'); 
			$this->db->from(TAGS_PRODUCT.' as tg');
			$this->db->join(USERS.' as u', 'u.id = tg.user_id');
			$this->db->join(USER_PRODUCTS.' as up', 'up.seller_product_id = tg.products');
			$this->db->where_in('tg.followers', $followers_id_str);
			$query = $this->db->get();
			return $query;
		}*/
}