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

/* added by mrinmoy on 26 April 2012 */
//$route['cms/(:any)'] 							= "home/cms/$1";
$route['feeds'] 								= "rss_feed";
$route['about-us'] 								= "home/cms/about-us";
$route['careers'] 								= "home/cms/careers";
$route['mission-vision'] 						= "home/cms/mission-vision";
$route['privacy-policy'] 						= "home/cms/privacy-policy";
$route['terms-condition'] 						= "home/cms/terms-condition";
$route['find-best-tradesman'] 					= "home/cms/find-best-tradesman";
$route['find-customer'] 						= "home/cms/find-customer";
//$route['articles'] 								= "home/cms/articles";
$route['articles'] 								= "home/articles";
$route['article-details/(:any)'] 				= "home/article_details/$1";

$route['buyer-how-it-works'] 					= "home/how_it_works/TVNOaFkzVT0=";
$route['tradesman-how-it-works'] 				= "home/how_it_works/TWlOaFkzVT0=";
$route['tradesman-faq'] 						= "home/faq/TWlOaFkzVT0=";
$route['buyer-faq'] 							= "home/faq/TVNOaFkzVT0=";
//$route['faq/(:any)'] 							= "home/faq/$1";
$route['contact-us'] 							= "home/contact_us";
$route['contact-us-success'] 					= "home/contact_us_success";
$route['abuse-report'] 							= "home/abuse_report";
$route['abuse-report-success'] 					= "home/abuse_report_success";
$route['help'] 									= "home/help";
$route['news/(:any)'] 							= "home/news/$1";
$route['testimonial-details/(:any)'] 			= "home/testimonial_details/$1";

$route['user/success-registration'] 			= "user/success_registration";
$route['user/success-buyer-registration'] 		= "user/success_buyer_registration";
$route['forget-password'] 						= "user/forget_password";

$route['job/job-post'] 							= "job/job_post";
$route['job/find-job'] 							= "job/find_job";
$route['job/find-job/(:any)/(:any)']            = "job/find_job/$2";
$route['job/find-job/(:any)'] 					= "job/find_job/$1";
$route['job-details/(:any)/(:any)'] 			    = "job/job_details/$2";


/* buyer account section */
$route['buyer/edit-job/(:any)'] 				= "buyer/edit_job/$1";
$route['buyer/change-password'] 				= "buyer/change_password";
$route['buyer/edit-profile'] 					= "buyer/edit_profile";
$route['buyer/contact-details']					= "buyer/contact_details";
$route['buyer/all-quotes']						= "buyer/all_quotes";
$route['buyer/all-jobs']						= "buyer/all_jobs";
$route['buyer/active-jobs']						= "buyer/active_jobs";
$route['buyer/assigned-jobs']					= "buyer/assigned_jobs";
$route['buyer/completed-jobs']					= "buyer/completed_jobs";
$route['buyer/expired-jobs']					= "buyer/expired_jobs";
$route['job-quotes/(:any)']						= "buyer/job_quotes/$1";
$route['buyer/private-message-board']			= "buyer/private_message_board";
$route['buyer/private-message-details/(:any)/(:any)']  = "buyer/private_message_details/$1/$2";
$route['buyer/email-settings']                  = "buyer/email_settings"; 
$route['buyer/recommend-us']                    = "buyer/recommend_us";  
$route['buyer/invite-tradesman']                = "buyer/invite_tradesman";   
/* buyer account section */

/* trademan account section */
$route['tradesman/change-password'] 			= "tradesman/change_password";
$route['tradesman/edit-profile'] 				= "tradesman/edit_profile";
$route['tradesman/professional-information']	= "tradesman/professional_information";
$route['tradesman/contact-details']				= "tradesman/contact_details";
$route['tradesman/quote-jobs']					= "tradesman/quote_jobs";
$route['tradesman/job-invitation']				= "tradesman/job_invitation";
$route['tradesman/my-won-jobs']					= "tradesman/my_won_jobs";
$route['tradesman/jobs-you-got']				= "tradesman/frozen_jobs";
$route['tradesman/progress-jobs']				= "tradesman/progress_jobs";
$route['tradesman/pending-jobs']				= "tradesman/pending_jobs";
$route['tradesman/completed-jobs']              = "tradesman/completed_jobs";
$route['tradesman/all-jobs']				    = "tradesman/all_jobs";
$route['tradesman/feedback-received']			= "tradesman/feedbacks";
$route['tradesman/membership-history']          = "tradesman/membership_history"; 
$route['tradesman/private-message-board']       = "tradesman/private_message_board"; 
$route['tradesman/private-message-details/(:any)/(:any)']= "tradesman/private_message_details/$1/$2";
$route['tradesman/email-settings']              = "tradesman/email_settings";  
$route['tradesman/recommend-us']                = "tradesman/recommend_us";  
$route['tradesman/radar-setting']               = "tradesman/radar_setting"; 
$route['tradesman/radar-jobs']               	= "tradesman/radar_jobs"; 
$route['tradesman/contact-list']                = "tradesman/contact_list"; 
/* trademan account section */

//$route['invite_tradesman/(:any)'] 				= "find_tradesman/invite_tradesman/$1"; 
//$route['find_tradesman/pagination_ajax/(:any)'] = "find_tradesman/pagination_ajax/$1";  
//$route['pagination_feedback_ajax/(:any)'] 		= "find_tradesman/pagination_feedback_ajax/$1";  
$route['find-tradesman'] 				        = "find_tradesman/index/$1"; 
$route['find-tradesman/(:any)'] 				= "find_tradesman/index/$1";
//$route['tradesman-profile/']                  = "find_tradesman/tradesman_profile/";
$route['tradesman-profile/(:any)'] 				= "find_tradesman/tradesman_profile/$1";  
$route['tradesman_invite']                      = "find_tradesman/do_tradesman_invite";  
 
/*Making the urls french*/
/* End of file routes.php */
/* Location: ./system/application/config/routes.php */

//$route['idmtblgs'] = "mngblgs/index";