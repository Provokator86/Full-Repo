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
//$route['category/(:any)'] = "category/index/$1";
$route['invite_tradesman/(:any)'] ="find_tradesman/invite_tradesman/$1";  // Added by sam on 20/10/2011

$route['find_tradesman/pagination_ajax/(:any)'] ="find_tradesman/pagination_ajax/$1";  // Added by sam on 20/10/2011
$route['pagination_feedback_ajax/(:any)'] ="find_tradesman/pagination_feedback_ajax/$1";  // Added by sam on 20/10/2011
$route['find-tradesman/(:any)'] ="find_tradesman/index/$1";  // Added by sam on 18/10/2011
$route['tradesman_profile/(:any)'] ="find_tradesman/tradesman_profile/$1";  // Added by sam on 18/10/2011


$route['tradesman_invite'] ="find_tradesman/do_tradesman_invite";  // Added by sam on 20/10/2011

//$route['feedback_received'] ="tradesman/feedback_received";  // Added by sam on 20/10/2011


/*Making the urls french*/
/* End of file routes.php */
/* Location: ./system/application/config/routes.php */


//$route['idmtblgs'] = "mngblgs/index";