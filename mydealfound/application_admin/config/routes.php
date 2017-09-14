<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

//$route['default_controller'] = "welcome";

$route['default_controller'] 	 	= "admin_panel/home";
$route['scaffolding_trigger'] 		= "";

$route['privacy-policy']		 	= "cms/index/privacy_policy";
$route['t-n-c']		 		  		= "cms/index/terms_and_condition";
$route['help']		 		   		= "cms/index/help";
$route['offer/detail/(:any)'] 		= "offer/offer_detail/$1";
$route['category/detail/(:any)'] 	= "category/category_detail/$1";
$route['brand/detail/(:any)'] 		= "product_detail/brand_detail/$1";
$route['product-detail/(:any)'] 	= "product_detail/just_redirect/$1";
//$route['product-detail/(:any)'] 	= "$1-coupons";
$route['(:any)-coupons'] 			= "product_detail/index/$1";
//$route['product-detail/([a-zA-Z0-9-_]+\.com)'] 	= "product_detail/index/$1";
$route['top-coupon']             	= "top_coupon";
$route['new-coupon']             	= "top_coupon/new_coupon";
$route['home/fav-coupon']           = "home/lets_guess_your_fav_cpn";
$route['home/search']               = "home/search_result";
//$route['(:any)-coupons'] 			= "product_detail/index/$1";
//$route['.[a-z]+$'] 			        = "product_detail/brand_detail/$1";
//$route['([a-zA-Z0-9-_]).[a-z]+$'] 			        = "product_detail/brand_detail/$1";
//$route['([[:alnum:].[:alnum:]]+)'] 			        = "product_detail/index/$1";
//$route['^[^.]+$'] 			        = "product_detail/index/$1";

//$route['404_override'] 				= 'not_found';

//


/* End of file routes.php */
/* Location: ./application/config/routes.php */