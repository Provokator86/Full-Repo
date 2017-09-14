<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This model contains all db functions related to seller requests
 * @author Teamtweaks
 *
 */
class Brands_model extends My_Model
{
	public function __construct() 
	{
		parent::__construct();
	}
	
	/**
    * 
    * Getting Sellers details
    * @param String $condition
    */
   public function get_sellers_details($condition=''){
   		$Query = " select * from ".BRANDS." ".$condition;
   		return $this->ExecuteQuery($Query);
   }
   
   public function get_product_details($pids='',$limit_str=''){
        if ($pids != ''){
            /*$Query = "select p.*,u.user_name,u.full_name,u.thumbnail from ".USER_PRODUCTS." p 
                        JOIN ".USERS." u on u.id=p.user_id
                        where p.seller_product_id in (".implode(',', $pids).")
                        ";*/
            $Query = "select p.*,u.user_name,u.full_name,u.thumbnail from ".USER_PRODUCTS." p 
                        LEFT JOIN ".USERS." u on u.id=p.user_id
                        where p.seller_product_id in (".implode(',', $pids).") ORDER BY p.id DESC
                        ".($limit_str!=""?" LIMIT ".$limit_str:"");
            return $this->ExecuteQuery($Query);
        }
    }
   
   public function get_brand_details($brand_url=''){
        if ($brand_url != ''){
            $Query = 'select s.*,u.user_name,u.full_name,u.email
                        from '.BRANDS.' s
                        left join '.USERS.' u on u.id=s.user_id
                        where s.brand_url="'.$brand_url.'"';
            return $this->ExecuteQuery($Query);
        }
    }
    
    public function get_store_for_brand($brand_url=''){
        if ($brand_url != ''){
           $Query = 'select DISTINCT(store_name)
                        from '.USER_PRODUCTS.' 
                        where brand_name="'.$brand_url.'"';
            return $this->ExecuteQuery($Query);
        }
    }
	
}