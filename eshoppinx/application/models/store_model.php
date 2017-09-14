<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This model contains all db functions related to seller requests
 * @author Teamtweaks
 *
 */
class Store_model extends My_Model
{
	public function __construct() 
	{
		parent::__construct();
	}
	
	
	public function get_product_details($pids=''){
		if ($pids != ''){
			/*$Query = "select p.*,u.user_name,u.full_name,u.thumbnail from ".USER_PRODUCTS." p 
						JOIN ".USERS." u on u.id=p.user_id
						where p.seller_product_id in (".implode(',', $pids).")
						";*/
            $Query = "select p.*,u.user_name,u.full_name,u.thumbnail from ".USER_PRODUCTS." p 
                        LEFT JOIN ".USERS." u on u.id=p.user_id
                        where p.seller_product_id in (".implode(',', $pids).")
                        ";
			return $this->ExecuteQuery($Query);
		}
	}
	
	public function get_trending_products($pids=''){
		if ($pids != ''){
			$Query = "select p.*,u.user_name,u.full_name,u.thumbnail,
						LOG10(p.likes + 1) * 287015 + UNIX_TIMESTAMP(p.created) AS Hotness
						from ".USER_PRODUCTS." p 
						JOIN ".USERS." u on u.id=p.user_id
						where p.seller_product_id in (".implode(',', $pids).")
						ORDER BY Hotness DESC
						";
			return $this->ExecuteQuery($Query);
		}
	}
	
	public function get_follower_details($follower_ids=''){
		if ($follower_ids != ''){
			$Query = "select * from ".USERS." 
						where id in (".implode(',', $follower_ids).")
						";
			return $this->ExecuteQuery($Query);
		}
	}
	
	public function get_store_details($store_url=''){
		if ($store_url != ''){
			$Query = 'select s.*,u.user_name,u.full_name,u.email
						from '.SHOPS.' s
						left join '.USERS.' u on u.id=s.user_id
						where s.store_url="'.$store_url.'"';
			return $this->ExecuteQuery($Query);
		}
	}
}