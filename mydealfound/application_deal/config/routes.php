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

$route['default_controller'] = "home";

$route['404_override']       = 'home/router/';


$route['about-us']                	= 'home/cms/about_us';
$route['terms-condition']			= 'home/cms/terms_condition';
$route['privacy-policy']            = 'home/cms/privacy_policy';
//$route['contact-us']                = 'home/cms/contact_us';
$route['contact-us']                = 'home/contact_us';

$route['top-deals/(:any)']          = 'home/top_deals/$1';

$route['top-deals']                = 'home/top_deals/';

$route['daily-deals/(:any)']        = 'home/daily_deals/$1';

$route['daily-deals']        = 'home/daily_deals/';

$route['popular-deals/(:any)']      = 'home/popular_deals/$1';

$route['popular-deals']            = 'home/popular_deals/';

$route['track/(:any)']      = 'home/track_url/$1';

$route['search/(:any)']      = 'home/search/$1';

$route['search']            = 'home/search/';

$route['(:any)-deals'] 		= "city_deal/city_deals/$1";

$route['home/ajax_pagination_search_list/page/(:num)']      = 'home/ajax_pagination_search_list/$1';

$route['category/ajax_pagination_product_list/page/(:num)'] = 'category/ajax_pagination_product_list/$1';
$route['category/ajax_pagination_product_list/(:num)']      = 'category/ajax_pagination_product_list/$1';
$route['category/ajax_pagination_product_list']      		= 'category/ajax_pagination_product_list';
$route['category/ajax_generate_sub_category_list']      	= 'category/ajax_generate_sub_category_list';
$route['category/ajax_generate_sub_category_label_one']     = 'category/ajax_generate_sub_category_label_one';
$route['category/ajax_fetch_breadcrumb']     				= 'category/ajax_fetch_breadcrumb';
$route['category/(:any)']      								= 'category/index/$1';


$route['testing/ajax-pagination-offer-list/page/(:num)'] = "testing/ajax_pagination_offer_list/$1";
/*$route['testing/ajax_pagination_product_list/(:any)']      = 'testing/ajax_pagination_product_list/$1';
$route['testing/ajax_pagination_product_list']      		= 'testing/ajax_pagination_product_list';
$route['testing/ajax_generate_sub_category_list']      	= 'testing/ajax_generate_sub_category_list';
$route['testing/ajax_generate_sub_category_label_one']     = 'testing/ajax_generate_sub_category_label_one';
$route['testing/ajax_fetch_breadcrumb']     				= 'testing/ajax_fetch_breadcrumb';
$route['testing/(:any)']    								= 'testing/index/$1';  */

$route['top_offers/ajax_pagination_offer_list/page/(:num)'] = "top_offers/ajax_pagination_offer_list/$1";
$route['top_offers/ajax_clear_srch_store_session']      	= 'top_offers/ajax_clear_srch_store_session';
$route['top-offers/details/(:any)']        					= 'top_offers/details/$1';
$route['top_offers/ajax_pagination_offer_list/(:num)']      = 'top_offers/ajax_pagination_offer_list/$1';
$route['top_offers/ajax_pagination_offer_list']      		= 'top_offers/ajax_pagination_offer_list';
$route['top-offers/(:any)']        							= 'top_offers/index/$1';
$route['top-offers']        								= 'top_offers/index';


$route['products/ajax_pagination_product_list/page/(:num)'] = "products/ajax_pagination_product_list/$1";
$route['products/ajax_clear_store_session']      			= 'products/ajax_clear_store_session';
$route['products/ajax_pagination_product_list/(:num)']      = 'products/ajax_pagination_product_list/$1';
$route['products/ajax_pagination_product_list']      		= 'products/ajax_pagination_product_list';
$route['products/(:any)']        							= 'products/index/$1';
$route['products']        									= 'products/index';



$route['food_dining/ajax_pagination_food_list/page/(:num)'] = "food_dining/ajax_pagination_food_list/$1";
$route['food_dining/ajax_clear_srch_store_session']      	= 'food_dining/ajax_clear_srch_store_session';
$route['food-dining/details/(:any)']        				= 'food_dining/details/$1';
$route['food-dining/ajax_pagination_food_list/(:num)']      = 'food_dining/ajax_pagination_food_list/$1';
$route['food-dining/ajax_pagination_food_list']      		= 'food_dining/ajax_pagination_food_list';
//$route['food-dining/(:any)']        						= 'food_dining/index/$1';
$route['food-dining']        								= 'food_dining/index';

$route['travel/ajax_pagination_travel/page/(:num)'] 		= "travel/ajax_pagination_travel/$1";
$route['travel/ajax_clear_srch_store_session']      		= 'travel/ajax_clear_srch_store_session';
$route['travel/details/(:any)']        						= 'travel/details/$1';
$route['travel/ajax_pagination_travel/(:num)']      		= 'travel/ajax_pagination_travel/$1';
$route['travel/ajax_pagination_travel']      				= 'travel/ajax_pagination_travel';
//$route['travel/(:any)']        							= 'travel/index/$1';
$route['travel']        									= 'travel/index';

/* End of file routes.php */

/* Location: ./application/config/routes.php */