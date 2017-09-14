<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This model contains all db functions related to user management
 * @author Teamtweaks
 *
 */
class Stories_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function UpdateActiveStatus($table='',$data=''){
		$query =  $this->db->get_where($table,$data);
		return $result = $query->result_array();
	}
	public function SelectAllCountry(){
		//print_r($OrderAsc);die;

		$this->db->select('*');
		$this->db->from(COUNTRY_LIST);
		//$this->db->where('status','Active');
		$this->db->order_by('name','asc');
		$query =  $this->db->get();

		//echo $this->db->last_query();die;
		return $result = $query->result_array();
	}
	public function get_all_StoresDetails($condition){
		$Query = "select s.*,u.user_name,u.full_name,u.thumbnail
					from ".STORIES." s LEFT JOIN ".USERS." u on u.id=s.user_id 
					where ".$condition." order by s.id desc";
		return $storiesList = $this->ExecuteQuery($Query);
	}


	/*public function get_all_AdminProductdetails($condition){
		$Query = "select p.*,u.user_name
		from ".STORIES." s LEFT JOIN ".USERS." u on u.id=s.user_id
		where ".$condition."";
		return $storiesList = $this->ExecuteQuery($Query);
		}*/

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

	public function get_collection_product($Pid){
		$Query = "select * from ".PRODUCT." where seller_product_id in (".$Pid.")";
		$StoriesProduct = $this->ExecuteQuery($Query);
		$Query = "select * from ".USER_PRODUCTS." where seller_product_id in (".$Pid.")";
		$affilProduct = $this->ExecuteQuery($Query);
		return $this->get_sorted_array($StoriesProduct,$affilProduct,'created','desc');
	}


	public function view_stories_comments_details($condition = ''){
		$select_qry = "select c.comments ,c.id,c.status,c.dateAdded,c.user_id as CUID,u.user_name as UserName,u.full_name,u.thumbnail
		from ".STORIES_COMMENTS." c 
		LEFT JOIN ".USERS." u on u.id=c.user_id
		LEFT JOIN ".STORIES." p on p.id=c.stories_id ".$condition;
		$productComment = $this->ExecuteQuery($select_qry);
		return $productComment;
			
	}

	public function get_collection_products($cid='all',$uid='0'){
		$returnStr['list_details'] = $list_details = '';
		$returnStr['list_products'] = $list_products = '';
		$pid_str = '';
		$pid_arr = array();
		if ($cid == 'all'){
			$conditionArr = array();
			if ($uid > 0) $conditionArr['user_id']=$uid;
			$list_details = $this->get_all_details(LISTS_DETAILS,$conditionArr);
			if ($list_details->num_rows()>0){
				foreach ($list_details->result() as $list_details_row){
					$Pid = '';
					$Pid = $list_details_row->product_id;
					if ($Pid != ''){
						$pid_arr_new = array_filter(explode(',', $Pid));
						if (count($pid_arr_new)>0){
							$pid_arr = array_merge($pid_arr,$pid_arr_new);
						}
					}
				}
			}
		}else {
			$list_details = $this->get_all_details(LISTS_DETAILS,array('id'=>$cid));
			if ($list_details->num_rows()==1){
				$Pid = '';
				$Pid = $list_details->row()->product_id;
				if ($Pid != ''){
					$pid_arr_new = array_filter(explode(',', $Pid));
					if (count($pid_arr_new)>0){
						$pid_arr = array_merge($pid_arr,$pid_arr_new);
					}
				}
			}
		}
		if(count($pid_arr)>0){
			foreach ($pid_arr as $pid_row){
				if ($pid_row != ''){
					$pid_str .= $pid_row.',';
				}
			}
			$pid_str = substr($pid_str, 0,-1);
			$list_products = $this->get_collection_product($pid_str);
		}
		$returnStr['list_details'] = $list_details;
		$returnStr['list_products'] = $list_products;

		return $returnStr;
	}
}