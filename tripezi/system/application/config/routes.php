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
| 	example.com/class/method/id/
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
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you set a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.   The reserved 
| routes must come before any wildcard or regular expression routes.
|
*/

//$route['default_controller'] = "admin/home";
$route['default_controller'] = "home";
$route['scaffolding_trigger'] = "";

/* added by mrinmoy on 06 July 2012 */
$route['about-us'] 								= "home/cms/0";
$route['terms-privacy'] 						= "home/cms/2";
$route['testimonials'] 							= "home/cms/1";

$route['how-it-works'] 							= "home/how_it_works/0";
$route['why-to-book'] 							= "home/how_it_works/1";
$route['why-to-host'] 							= "home/how_it_works/2";

$route['site-map'] 								= "home/site_map";
$route['terms-conditions'] 						= "home/terms_condition";
$route['contact-us'] 							= "home/contact_us";
$route['contact-us-success'] 					= "home/contact_us_success";
$route['blog'] 									= "home/blog";
$route['job'] 									= "home/job";
$route['press']                                 = "home/press";
$route['faq'] 									= "home/faq";
$route['blog-comments/(:any)'] 					= "home/blog_comments/$1";
$route['unsubscribe/(:any)'] 					= "home/unsubscribe/$1";


$route['forgot-password']                       = "user/forgot_password";
$route['user/active-account/(:any)']			= "user/active_account/$1";
$route['user/change-password/(:any)']			= "user/change_password/$1";
$route['profile/(:any)']						= "user/profile/$1";
//account section
$route['dashboard']                             = "account/dashboard";
$route['change-password'] 					    = "account/change_password";
$route['manage-account'] 					    = "account/manage_account";
$route['my-property-booking']                   = "account/my_property_booking";
$route['booking-details/(:any)']                = "account/booking_details/$1";
$route['my-travel-booking']                     = "account/my_travel_booking";
$route['manage-internal-messaging']             = "account/manage_internal_messaging";
$route['manage-property'] 					    = "account/manage_property";
$route['list-your-place'] 					    = "account/list_your_place";
$route['list-your-place/(:any)'] 				= "account/list_your_place/$1";
$route['property-calender/(:any)']              = "account/property_calender/$1";
$route['write-a-message/(:any)']                = "account/write_message/$1";
$route['booking-successful']                    = "account/booking_successful";
$route['booking-failed'] 	                    = "account/booking_failed";

/* for proerty listing and pagination */
$route['search/ajax_property_list']				= "search/ajax_property_list";
$route['search/ajax_property_list/(:any)']		= "search/ajax_property_list/$1";
$route['search/(:any)']							= "search/index/$1";

$route['add-to-favourite/(:any)']				= "property/add_to_favourite/$1";
$route['remove-from-favourite/(:any)']			= "property/remove_from_favourite/$1";


$route['auto-suggest/city/(:any)']              = "auto_suggest/city/$1";
$route['auto-suggest/search']                  	= "auto_suggest/search";

 
/*Making the urls french*/
/* End of file routes.php */
/* Location: ./system/application/config/routes.php */

//$route['idmtblgs'] = "mngblgs/index";