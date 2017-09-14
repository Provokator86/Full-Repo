<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the "Database Connection"
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the "default" group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = "default";
$active_record = TRUE;

if(SITE_FOR_LIVE)///For live site (SITE_FOR_LIVE defined at index.php)
{
    $db['default']['hostname'] = "localhost";
    $db['default']['username'] = "acumencs_jbshopa";
    $db['default']['password'] = "acumencs_jbshopa";
    $db['default']['database'] = "acumencs_jobshoppa";    
}
else
{
    $db['default']['hostname'] = "localhost";
    $db['default']['username'] = "root";
    $db['default']['password'] = "";
    $db['default']['database'] = "jobshoppa";    
}

$db['default']['dbdriver'] = "mysql";
$db['default']['dbprefix'] = "";
$db['default']['tableprefix'] = "jobshoppa_";
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";


/*************DB TABLE NAMES********************/
$s_tblPre=$db['default']['tableprefix'];
$db['default']["USER"]					=	$s_tblPre."admin";
$db['default']["USERMANAGE"]			=	$s_tblPre."user";
$db['default']["USERIMAGE"]				=	$s_tblPre."user_image";
///////////////////////////////////////////////////////////////////////
$db['default']["USER_TYPE"]				=	$s_tblPre."mst_user_type";
$db['default']["USER_TYPE_ACCESS"]		=	$s_tblPre."user_type_access";
$db['default']["COUNTRY"]				=	$s_tblPre."country";
$db['default']["STATE"]					=	$s_tblPre."state";
$db['default']["CITY"]					=	$s_tblPre."city";
$db['default']["ZIPCODE"]				=	$s_tblPre."zipcode";
$db['default']["LANGUAGE"]				=	$s_tblPre."language";
$db['default']["MASTERROLE"]			=	$s_tblPre."user_role_master";

$db['default']["NEWS"]					=	$s_tblPre."news";
$db['default']["NEWSLETTER"]			=	$s_tblPre."newsletter";
$db['default']["NEWSLETTERSUBCRIPTION"]	=	$s_tblPre."newsletter_subscription";

$db['default']["CMS"]					=	$s_tblPre."cms";
$db['default']["CMSMASTERTYPE"]			=	$s_tblPre."cms_master_type";
$db['default']["CMSARTICLE"]			=	$s_tblPre."cms_article";


$db['default']["AUTOMAIL"]				=	$s_tblPre."auto_mail";
$db['default']["AUTOALERT"]				=	$s_tblPre."auto_alert";
$db['default']["HOMEPAGEIMAGES"]		=	$s_tblPre."admin_homepage_images";
$db['default']["SITESETTING"]			=	$s_tblPre."admin_site_settings";

$db['default']["TESTIMONIAL"]			=	$s_tblPre."testimonials";

$db['default']["CATEGORY"]				=	$s_tblPre."category";
$db['default']["CATEGORYCHILD"]			=	$s_tblPre."category_lang";

$db['default']["SLAB"]					=	$s_tblPre."admin_commission_setting";
$db['default']["WAIVERCOMM"]			=	$s_tblPre."admin_waiver_commission";
$db['default']["METATAGS"]				=	$s_tblPre."meta_tag";

$db['default']["JOBS"]					=	$s_tblPre."jobs";
$db['default']["JOBS_FILES"]			=	$s_tblPre."job_files";
$db['default']["JOBFEEDBACK"]			=	$s_tblPre."job_feedback";
$db['default']["JOBQUOTES"]				=	$s_tblPre."job_quotes";
$db['default']["JOB_INVITATION"]		=	$s_tblPre."job_invitation";
$db['default']["PMB"]					=	$s_tblPre."msg_board";
$db['default']["PMBDETAILS"]			=	$s_tblPre."msg_board_details";
$db['default']["JOB_HISTORY"]			=	$s_tblPre."job_history";
$db['default']["JOB_STATUS_HISTORY"]	=	$s_tblPre."job_status_history";
$db['default']["JOB_WATCHLIST"]			=	$s_tblPre."job_watchlist";
 



/*16-09-2011 faq,how it works for buyers and tradesman*/
$db['default']["FAQ"]					=	$s_tblPre."faq_did_you_know";
$db['default']["HOWITWORKSBUYER"]		=	$s_tblPre."how_it_works_buyer";
$db['default']["HOWITWORKSTRADESMAN"]	=	$s_tblPre."how_it_works_tradesman";
/* 17-09-2011 for help management*/
$db['default']["HELP"]					=	$s_tblPre."help";

$db['default']["USREIMAGE"]				=	$s_tblPre."user_image";
$db['default']["TRADESMANDETAILS"]		=	$s_tblPre."tradesman_details";
$db['default']["TRADESMANCAT"]			=	$s_tblPre."tradesman_category";
$db['default']["BUYERDETAILS"]			=	$s_tblPre."buyer_details";
/* 19-10-2011 */
$db['default']["AUTOMAILRIGHT"]			=	$s_tblPre."user_automail_right";

$db['default']["TRADESALBUM"]			=	$s_tblPre."tradesman_album";

$db['default']["REFERRER"]				=	$s_tblPre."user_referrer";

$db['default']["RADAR"]					=	$s_tblPre."radar";

$db['default']["JOB_PAYMENT_HISTORY"]	=	$s_tblPre."payment_history";

$db['default']["WAIVER_PAYMENT"]		=	$s_tblPre."waiver_payment";
$db['default']["RADAR_CAT"]				=	$s_tblPre."radar_cat";
$db['default']["SUBSCRIPTION_PAYMENT"]	=	$s_tblPre."subcription_payment";
$db['default']["TRADESMAN_VERIFICATION"]=	$s_tblPre."tradesman_verification";
$db['default']["CREDENTIAL_FILE"]       =	$s_tblPre."credentials_file";



/* mrinmoy 05-12-2011 */
$db['default']["HOMEPAGEIMAGES"]		=	$s_tblPre."admin_homepage_images";


/*
+-----------------------------+
| Added by Jagannath Samanta  |
+-----------------------------+
*/
$db['default']["ARTICLE"]				=	$s_tblPre."article_story";
/*
+-----------------------------+
| Added by Koushik Rout       |
+-----------------------------+
*/
$db['default']["MANAGE_BLOG"]           =   $s_tblPre."manage_blog";  
$db['default']["CUSTOMER_SUPPORT"]      =   $s_tblPre."customer_support";
$db['default']["BLOG_COMMENT"]          =   $s_tblPre."blog_comment";     

unset($s_tblPre);


/*************end DB TABLE NAMES********************/





/* **********
 Author: Iman Biswas
 Date  : 9 Sep 2011
 Modified By: 
 Modified Date:
********* */

$db['default']["CATEGORY_TYPE"]= array('job'=>'Job','tradesman_faq'=>'Tradesman Faq','buyer_faq'=>'Buyer Faq','news_article'=>'News Article','help'=>'Help');  // Iman

$db['default']["ALERTTYPE"]   = array('registration'=>'Registartion','forget_password'=>'Forget Password'); // Mrinmoy Mondal

$db['default']["FAQCATEGORYBUYER"]   = array('1'=>'About Tradesman','2'=>'General','3'=>'Posting Jobs'); // Mrinmoy Mondal

$db['default']["FAQCATEGORYTRADE"]   = array('1'=>'Doing Jobs','2'=>'Fees','3'=>'General'); // Mrinmoy Mondal

$db['default']["TESTIMONIALSTATE"]   = array('1'=>'Pending','2'=>'Approved','3'=>'Reject'); // Mrinmoy Mondal

$db['default']["USERROLE"]   = array('1'=>'Client','2'=>'Professional','3'=>'Both','4'=>'General'); // Mrinmoy Mondal

$db['default']["FEEDBACKRATING"]   = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5'); // Mrinmoy Mondal
$db['default']["POSITIVE_FEEDBACK_RATING"]   = array('3'=>'3','4'=>'4','5'=>'5'); // Mrinmoy Mondal
$db['default']["NEGATIVE_FEEDBACK_RATING"]   = array('1'=>'1','2'=>'2'); // Mrinmoy Mondal

//$db['default']["RADIUS"]   = array('5'=>'5','10'=>'10','15'=>'15'); // Iman
$db['default']["RADIUS"]   = range(10, 100, 10); // Iman

$db['default']["PAGINATION"]   = array('5'=>'5','10'=>'10','15'=>'15'); // Iman

$db['default']["JOB_MATERIAL"]   = array('0'=>'Does not matter','1'=>'Yes','2'=>'No'); // Iman

$db['default']["AVAILABLE_TIME"]   = array('1'=>'-next few days-',
											'2'=>'-next few weeks-',
											'3'=>'-any time-'); // Iman

$db['default']["JOBSTATUS"]   = array('0'=>'New',
									  '1'=>'Active',
									  '2'=>'Rejected',
									  '3'=>'Assigned',
									  '4'=>'In Progress',
									  '5'=>'Feedback Asked',
									  '6'=>'Completed',
									  '7'=>'Expired',
									  '8'=>'Frozen',
									  '9'=>'Terminated',
									  '10'=>'Cancelled',
									  '11'=>'Pending'); // Mrinmoy Mondal
									  
$db['default']["ALIAS_JOBSTATUS"]   = array('0'=>'Pending for approval from admin', //new
									  '1'=>'Active',
									  '2'=>'Rejected',
									  '3'=>'Assigned',
									  '4'=>'In Progress',
									  '5'=>'Professional declared this job as completed', //'Feedback Asked',
									  '6'=>'Completed',
									  '7'=>'Expired',
									  '8'=>'Frozen',
									  '9'=>'Terminated',
									  '10'=>'Cancelled',
									  '11'=>'Pending'); // Mrinmoy Mondal									  
									  

$db['default']["PMBSTATUS"]   = array('0'=>'Pending','1'=>'Approved','2'=>'Rejected'); // Mrinmoy Mondal

$db['default']["FINDJOBTYPE"]   = array('1'=>'Open','3'=>'Assigned','4'=>'Hired'); // Mrinmoy Mondal

$db['default']["AUTOMAIL_KEY"]= array(  'job_posted'=>'Job Posted Mail',
										'job_approved'=>'Job Approved Mail',
										'job_rejected'=>'Job Rejected Mail',
										'tradesman_placed_quote'=>'Professional Placed Quote', 
										'tradesman_post_msg'=>'Professional Post Message', 
										'tradesman_completed_job'=>'Professional Completed Job',										
										'tradesman_feedback'	=> 'Professional Feedback Mail', // mrinmoy
										'tradesman_interest_in_job'=>'Professional Interest In Job', //mrinmoy
										'tradesman_denied_job_offer'=>'Professional Denied Job Offer', //mrinmoy
										'tradesman_did_not_accept_job'=>'Professional did not accept job within time',
										
										'job_invitation'=>'Job Invitation from Client', 
										'buyer_post_msg'=>'Client Post Message', 
										'job_match_criteria'=>'Job Match Your criteria',										 
										'buyer_awarded_job'=>'Client Awarded Job',
										'buyer_provided_feedback'=>'Client Provided Feedback', 
										'buyer_terminate_job'=>'Client terminated Job',
										'buyer_cancell_job'=>'Client Cancelled Job',
										'tradesman_radar_jobs'	=> 'Professional Radar Jobs Mail', // Sam
										'tradesman_subscription_expire'	=> 'Professional Subscription Expire',
										'tradesman_payment_subscription'	=> 'Professional Payment Subscription',
										'verification_check'=>'Professional Profile Verification',
										
										'payment_sucess'=>'Payment Success',
										'waiver_payment_sucess'=>'Waiver Payment Success',
										'registration_mail'=>'Registration_mail',
										'forgot_password'=>'Forgot Password',
										'referral_mail'=>'Referral Mail',
										'admin_buyer_terminated_job'=>'For Admin Client Terminated Job',
										'admin_buyer_cancel_job'=>'For Admin Client Cancelled Job', 
										'forget_password'=>'Forget Password', 
										'contact_us'=>'Contact Us',
										'account_deactivate'=>'Account Deactivate',
										'account_reactivate'=>'Account Reactivate',
										'abuse_report'=>'Abuse Report',
										'customer_support'=>'Customer Support',
										'phone_number_verification'=>'Phone Number Verification',
										'credential_verification'=>'Credential Verification'										
										);  // Iman
										
										
$db['default']["JOB_HISTORY_KEY"]= array('job_created'=>'##USERNAME## has created the Job on ##TIME##',
										 'job_approved'=>'##USERNAME## has approved the Job on ##TIME##',
										 'job_rejected'=>'##USERNAME## has rejected the Job on ##TIME##',
										 'job_edited'=>'##USERNAME## has edited the Job on ##TIME##',
										 'job_cancelled'=>'##USERNAME## has cancelled the Job on ##TIME##',
										 'job_assigned'=>'##USERNAME## has been assigned the Job on ##TIME##',
										 'job_placed_quote'=>'##USERNAME## has placed quote in the Job on ##TIME##',
										 'job_accepted'=>'##USERNAME## has accepted the Job on ##TIME##',
										 'job_not_accepted'=>'##USERNAME## has not accepted the Job on ##TIME##',
										 'job_expired'	   =>'Job has been expired on  ##TIME##',
										 'job_complete_confirmed'=>'##USERNAME## has  confirmed the completion of the Job and asked for Feedback on ##TIME##',
										 'job_feedback'=>'##USERNAME## has given feedback on the Job on ##TIME##',
										 'job_denied_complition'=>'##USERNAME## has denied completion of the Job on ##TIME##',
										 'job_terminate'=>'##USERNAME## has terminated the Job on ##TIME##'
										 
										);  // Iman
										
										
										

$db['default']["PAYMENT_TYPE"]   = array(3=>'Cash',1=>'Credit Cards',2=>'Cheques'); // Sam


$db['default']["VERIFICATIONTYPE"]   = array('1'=>'Credentials','2'=>'Phone','3'=>'Facebook'); // Mrinmoy Mondal
$db['default']["VERIFICATIONSTATUS"]   = array('1'=>'Pending','2'=>'Rejected','3'=>'Approved'); // Mrinmoy Mondal




$db['default']["TRADESMAN_SUBSCRIPTION"]  = array(
												  'quote_jobs',
												  'watch_list',	
												  'job_invitation',	
												  'tradesman_radar_job',	
												  'pending_jobs',
												  'progress_jobs',
												  'completed_jobs',
												  'frozen_jobs',
												  'feedback_received',
												  'feedback_provided',
												  'lost_jobs'
												  	);






/////////////////The below menus are used into user_type_master.php controller, user_login.php model///////
/**
*  EXAMPLE:-
*    '<Controller Class Name Or Virtual Controller>'=>array(
*                     'label'=>'<Displayed in Control Access, user_type. Mandatory>',
*                     'top_menu'=>'<Menu Name at layer 0. Mandatory>',
*                     'menu_name'=>'<Menu Name at layer 1. Mandatory>',
*                     'menu_link'=>'<Menu Link at layer 1. Optional>',
*                       -----If Sub Sub Menu exists----
*                     'sub_menu_name'=>'<Menu Name at layer 2. Optional>',
*                     'sub_menu_link'=>'<Menu Link at layer 2. Optional>',
*                     'alias_controller'=>'<Allow access to related controllers. Optional and Comma seperated>',
*                     'menu_title'=>'<tooltip when hovering the menu at layer 1>',  
*                     'sub_menu_title'=>'<tooltip when hovering the menu at layer 2>',   
*                     ), 
*   *Only for Virtual Controller use routes.php
* 
*/

//////////All Menus

$db['default']["CONTROLLER_NAME"] = array(


                                         /************Master / General ****************/
                                          'Dashboard'=>array('label'=>'Dashboard',
 															 'top_menu'=>'General',
															 'menu_name'=>'Dashboard',
															 'menu_link'=>'dashboard/' ),
                                       
										  'Site_setting'=>array('label'=>'Site Settings',
 															 'top_menu'=>'General',
															 'menu_name'=>'Site Settings',
															 'menu_link'=>'site_setting' ),	
															 
										  'Commission_slab'=>array('label'=>'Commission Slab',
                                                             'top_menu'=>'General',
                                                             'menu_name'=>'Commission Slab',
                                                             'menu_link'=>'commission_slab/' ),			
															 
															 
										  'Commission_waiver'=>array('label'=>'Commission Waiver Setting',
                                                             'top_menu'=>'General',
                                                             'menu_name'=>'Commission Waiver Setting',
                                                             'menu_link'=>'commission_waiver/' ),
										
										 
															 
                                          'Comm_setting_history'=>array('label'=>'Commission Setting History',
                                                             'top_menu'=>'General',
                                                             'menu_name'=>'Commission History',
                                                             'menu_link'=>'comm_setting_history/show_list'),
															 
                                         /* 'Referral_setting_history'=>array('label'=>'Referral Setting History',
                                                             'top_menu'=>'General',
                                                             'menu_name'=>'Referral History',
                                                             'menu_link'=>'referral_setting_history/show_report_list'),	*/															 
										/*	 'Category'=>array('label'=>'Category',
 															 'top_menu'=>'General',
															 'menu_name'=>'Category',
															 'menu_link'=>'category/show_list' ),	*/				 
															 
										  'State'=>array('label'=>'County',
 															 'top_menu'=>'General',
															 'menu_name'=>'County',
															 'menu_link'=>'state/show_list' ),
															 
										  'City'=>array('label'=>'City',
 															 'top_menu'=>'General',
															 'menu_name'=>'City',
															 'menu_link'=>'city/show_list' ),
															 
										  'Postal_code'=>array('label'=>'Postal Code',
 															 'top_menu'=>'General',
															 'menu_name'=>'Postal Code',
															 'menu_link'=>'postal_code/show_list' ),
															 
										  'My_account'=>array('label'=>'My Account',
 															 'top_menu'=>'General',
															 'menu_name'=>'My Account',
															 'menu_link'=>'my_account/' ),				 
															 
/*															                                                              
															 
										  'User'=>array('label'=>'Manage User',
                                                             'top_menu'=>'General',
                                                             'menu_name'=>'Manage User',
                                                             'menu_link'=>'user/show_list' ),																 
															 */
															 

											/****  require for access control. not for codeurjob ****/				 
															 
/*										  'User_admin'=>array('label'=>'Admin User',
                                                             'top_menu'=>'General',
                                                             'menu_name'=>'Admin User',
                                                             'menu_link'=>'user_admin/show_list' ),		
															 
										  'User_type_master'=>array('label'=>'User Type Master',
                                                             'top_menu'=>'General',
                                                             'menu_name'=>'User Type Master',
                                                             'menu_link'=>'user_type_master/show_list' ),	
*/															 


										/*********** jobs ****************/
                                           'Job_category'=>array('label'=>'Manage Category',
                                                             'top_menu'=>'Jobs',
                                                             'menu_name'=>'Manage Category',
                                                             'menu_link'=>'job_category/show_list'),
															 
										  'Manage_new_jobs'=>array('label'=>'Manage Jobs',
                                                             'top_menu'=>'Jobs',
                                                             'menu_name'=>'Manage Jobs',
                                                             //'menu_link'=>'faq/show_list',
															 'sub_menu_name'=>'New',
															 'sub_menu_link'=>'manage_jobs/show_list'),	
										 'Manage_active_jobs'=>array('label'=>'Manage Jobs',
                                                             'top_menu'=>'Jobs',
                                                             'menu_name'=>'Manage Jobs',
                                                             //'menu_link'=>'faq/show_list',
															 'sub_menu_name'=>'Active',
															 'sub_menu_link'=>'manage_jobs/show_active'),		
											
										 'Manage_completed_jobs'=>array('label'=>'Manage Jobs',
                                                             'top_menu'=>'Jobs',
                                                             'menu_name'=>'Manage Jobs',
                                                             //'menu_link'=>'faq/show_list',
															 'sub_menu_name'=>'Completed',
															 'sub_menu_link'=>'manage_jobs/show_complete'),		
										'Manage_in_progress_jobs'=>array('label'=>'Manage Jobs',
                                                             'top_menu'=>'Jobs',
                                                             'menu_name'=>'Manage Jobs',
                                                             //'menu_link'=>'faq/show_list',
															 'sub_menu_name'=>'In Progress',
															 'sub_menu_link'=>'manage_jobs/show_in_progress'),						 
															 		 
										  'Manage_jobs'=>array('label'=>'Manage Jobs',
                                                             'top_menu'=>'Jobs',
                                                             'menu_name'=>'Manage Jobs',
                                                             //'menu_link'=>'faq/show_list',
															 'sub_menu_name'=>'All',
															 'sub_menu_link'=>'manage_jobs/show_all'),					 																	 											'Manage_private_message'=>array('label'=>'Manage Private Message',
 															 'top_menu'=>'Jobs',
															 'menu_name'=>'Manage Private Message',
															 'menu_link'=>'manage_private_message/show_list' ),
										  'Manage_feedback'=>array('label'=>'Manage Feedback',
 															 'top_menu'=>'Jobs',
															 'menu_name'=>'Manage Feedback',
															 'menu_link'=>'manage_feedback/show_list' ),
															 
										
										
															 
															 
										 /************User****************/  	
										 
										
										  'Manage_buyers'=>array('label'=>'Manage Buyers',
 															 'top_menu'=>'User',
															 'menu_name'=>'Manage Clients',
															 'menu_link'=>'manage_buyers/show_list' ),
															 
										  'Manage_tradesman'=>array('label'=>'Manage Tradesman',
 															 'top_menu'=>'User',
															 'menu_name'=>'Manage Professionals',
															 'menu_link'=>'manage_tradesman/show_list' ),
															 
															 
										  'Manage_verification'=>array('label'=>'Manage Verification',
 															 'top_menu'=>'User',
															 'menu_name'=>'Manage Verification',
															 'menu_link'=>'manage_verification/show_verification_list' ),					 
															 
															 
										/************CMS****************/ 										
										
										 'Cms'=>array('label'=>'Static Pages',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'Static Pages',
                                                             'menu_link'=>'cms/add_information' ),
															 
                                         /* 'News'=>array('label'=>'News',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'News',
                                                             'menu_link'=>'news/show_list' ),*/
                                                             
                                          'Manage_blog'=>array('label'=>'Manage Blog',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'Manage Blog',
                                                             'menu_link'=>'manage_blog/show_list' ),   
										  
                                          'Buyer_faq_category'=>array('label'=>'FAQ',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'FAQ',
                                                             //'menu_link'=>'faq/show_list',
                                                             'sub_menu_name'=>'Clients FAQ Category',
                                                             'sub_menu_link'=>'buyer_faq_category/show_list',
                                                              ),					 
                                          'Faq'=>array('label'=>'FAQ',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'FAQ',
                                                             //'menu_link'=>'faq/show_list',
															 'sub_menu_name'=>'Clients FAQ',
															 'sub_menu_link'=>'faq/show_list',
															  ),
                                           'Tradesman_faq_category'=>array('label'=>'FAQ',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'FAQ',
                                                             //'menu_link'=>'faq/show_list',
                                                             'sub_menu_name'=>'Professional FAQ Category',
                                                             'sub_menu_link'=>'tradesman_faq_category/show_list',
                                                              ),
                                          
										 'Faq_tradesmen'=>array('label'=>'FAQ',
														 'top_menu'=>'CMS',
														 'menu_name'=>'FAQ',
														 //'menu_link'=>'faq/show_list',
														 'sub_menu_name'=>'Professionals FAQ',
														 'sub_menu_link'=>'faq_tradesmen/show_list',
														  ),
														  
										 'How_it_works_buyer'=>array('label'=>'FAQ',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'How It Works',
                                                             //'menu_link'=>'faq/show_list',
															 'sub_menu_name'=>'Clients How It Work',
															 'sub_menu_link'=>'how_it_works_buyer/show_list',
															  ),
															  
										 'How_it_works_tradesman'=>array('label'=>'FAQ',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'How It Works',
                                                             //'menu_link'=>'faq/show_list',
															 'sub_menu_name'=>'Professionals How It Work',
															 'sub_menu_link'=>'how_it_works_tradesman/show_list',
															  ),
                                           /*'Customer_support'=>array(),   */
                                                              
                                         /*  'Customer_support'=>array('label'=>'About Professional',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'Customer Support',
                                                             //'menu_link'=>'faq/show_list',
                                                             'sub_menu_name'=>'About Professional',
                                                             'sub_menu_link'=>'customer_support/show_list/TVNOaFkzVT0=', 
                                                           // 'sub_menu_link'=>'about_professional/show_list/TVNOaFkzVT0=', 
                                                            // 'alias_controller'=>'Customer_support',  
                                                              ),*/
															  
                                           /*'General'=>array('label'=>'General',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'Customer Support',                                                             
                                                             'sub_menu_name'=>'General',
                                                             'sub_menu_link'=>'customer_support/show_list/TWlOaFkzVT0=',
                                                             'alias_controller'=>'Customer_support',   
                                                              ), */  
															  
                                          /* 'Posting_jobs'=>array('label'=>'Posting jobs',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'Customer Support',
                                                             'sub_menu_name'=>'Posting Jobs',
                                                             'sub_menu_link'=>'customer_support/show_list/TXlOaFkzVT0=',
                                                             'alias_controller'=>'Customer_support',    
                                                              ),  */                                       	
														  
                                          'Testimonial'=>array('label'=>'Testimonial',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'Testimonial',
                                                             'menu_link'=>'testimonial/show_list' ,),
															 
										  'Help_category'=>array('label'=>'Help Category',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'Help',
                                                             //'menu_link'=>'faq/show_list',
                                                             'sub_menu_name'=>'Help Category',
                                                             'sub_menu_link'=>'help_category/show_list',
                                                              ),					  
										  'Help'=>array('label'=>'Help',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'Help',
                                                             'sub_menu_name'=>'Help',
                                                             'sub_menu_link'=>'help/show_list' ),	
															 
														 
										 'Auto_mail_buyer'=>array('label'=>'Auto Mail',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'Automail',
                                                             //'menu_link'=>'faq/show_list',
															 'sub_menu_name'=>'Clients Automail',
															 'sub_menu_link'=>'auto_mail/show_param_list/WW5WNVpYSWpZV04x=',
															  ),	
															  
										 'Auto_mail_tradesman'=>array('label'=>'Auto Mail',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'Automail',
                                                             //'menu_link'=>'faq/show_list',
															 'sub_menu_name'=>'Professionals Automail',
															 'sub_menu_link'=>'auto_mail/show_param_list/ZEhKaFpHVnpiV0Z1STJGamRRPT0=',
															  ),	
															  
															  
										 'Auto_mail'=>array('label'=>'Auto Mail',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'Automail',
                                                             //'menu_link'=>'faq/show_list',
															 'sub_menu_name'=>'General Automail',
															 'sub_menu_link'=>'auto_mail/show_param_list/WjJWdVpYSmhiQ05oWTNVPQ==',
															  ),	

															 
															 
/*										 'Auto_alert'=>array('label'=>'Auto Alert',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'Auto Alert',
                                                             'menu_link'=>'auto_alert/show_list' ),	
															 				 
*/

										
										/* BANNER */
										'Banner'=>array('label'=>'Banner',
                                                             'top_menu'=>'Banner',
                                                             'menu_name'=>'Banner',
                                                             'menu_link'=>'banner/show_list' ),	
									
										
										/****** Invoice *****/		
									'Manage_invoice'=>array('label'=>'Manage Invoice',
												 'top_menu'=>'Invoice',
												 'menu_name'=>'Manage Invoice',
												 'menu_link'=>'manage_invoice/show_list' ),
												 
											/****** Payment *****/		
									'Payment_subscription'=>array('label'=>'Manage Subscription',
												 'top_menu'=>'Invoice',
												 'menu_name'=>'Manage Subscription',
												 'menu_link'=>'payment_subscription/show_list' ),			 
											 

										/*********** Manage SEO **********/										
																									  
									    'Meta_tags'=>array('label'=>'Page Title & Meta Tags',
														 'top_menu'=>'SEO',
														 'menu_name'=>'Page Title & Meta Tags',
														 'menu_link'=>'meta_tags/show_list' ),	
									
																 
															  
										/************manage Emails****************/  
										
                                          'Newsletter'=>array('label'=>'CMS',
                                                             'top_menu'=>'Email',
                                                             'menu_name'=>'Newsletter',
                                                             'menu_link'=>'newsletter/show_list' ),
															 
                                          'Newsletter_subscribers'=>array('label'=>'Newsletter Subscriber',
                                                             'top_menu'=>'Email',
                                                             'menu_name'=>'Newsletter Subscribers',
                                                             'menu_link'=>'newsletter_subscribers/show_list' ),
															 
										/***********Reports****************/ 
															 															 
                                         /* 'Site_summary_report'=>array('label'=>'Site Summary Report',
                                                             'top_menu'=>'Report',
                                                             'menu_name'=>'Site Summary Report',
                                                             'menu_link'=>'site_summary_report/show_list'),*/
															 
                                          'Job_posted_report'=>array('label'=>'Job Posted Report',
                                                             'top_menu'=>'Report',
                                                             'menu_name'=>'Auction Posted',
                                                             'menu_link'=>'job_posted_report/show_report_list'),
															 
                                          'Job_live_report'=>array('label'=>'Job Live Report',
                                                             'top_menu'=>'Report',
                                                             'menu_name'=>'Live Auctions',
                                                             'menu_link'=>'job_live_report/show_report_list'),
										  'Job_quote_report'=>array('label'=>'Job Live Report',
                                                             'top_menu'=>'Report',
                                                             'menu_name'=>'Per Job Bid Status',
                                                             'menu_link'=>'job_live_report/show_qoute_list'),
											'Job_frozen_report'=>array('label'=>'Job Frozen Report',
                                                             'top_menu'=>'Report',
                                                             'menu_name'=>'Frozen Auctions',
                                                             'menu_link'=>'job_live_report/show_frozen'),
											'Job_expire_report'=>array('label'=>'Job Expire Report',
                                                             'top_menu'=>'Report',
                                                             'menu_name'=>'Expired Auctions',
                                                             'menu_link'=>'job_live_report/show_expired'),	
											'Job_terminated_report'=>array('label'=>'Job Terminated Report',
                                                             'top_menu'=>'Report',
                                                             'menu_name'=>'Terminated Auctions',
                                                             'menu_link'=>'job_live_report/show_terminated'),			 
															 
                                          /*'Job_closed_report'=>array('label'=>'Job Closed Report',
                                                             'top_menu'=>'Report',
                                                             'menu_name'=>'Closed Auctions',
                                                             'menu_link'=>'job_live_report/show_closed_list'),*/
															 
                                          'Job_won_report'=>array('label'=>'Job Won Report',
                                                             'top_menu'=>'Report',
                                                             'menu_name'=>'Won Auctions',
                                                             'menu_link'=>'job_live_report/show_won_list'),
										'Job_complete_report'=>array('label'=>'Job Won Report',
                                                             'top_menu'=>'Report',
                                                             'menu_name'=>'Completed Auctions',
                                                             'menu_link'=>'job_live_report/show_complete'),
										 'Job_in_progress'=>array('label'=>'Job In Progress Report',
                                                             'top_menu'=>'Report',
                                                             'menu_name'=>'In Progress Auctions',
                                                             'menu_link'=>'job_live_report/show_in_progress'),
															 
                                          'Comm_payment_report'=>array('label'=>'Commission Payment Report',
                                                             'top_menu'=>'Report',
                                                             'menu_name'=>'Commission Payment Report',
                                                             'menu_link'=>'comm_payment_report/show_list'),
										 
										 'Subscribe_payment_report'=>array('label'=>'Subscription Payment Report',
                                                             'top_menu'=>'Report',
                                                             'menu_name'=>'Subscription Payment Report',
                                                             'menu_link'=>'subscribe_payment_report/show_list'),
										 
										 
										  'Waivered_report'=>array('label'=>'Waivered Report',
                                                             'top_menu'=>'Report',
                                                             'menu_name'=>'Waivered Report',
                                                             'menu_link'=>'waivered_report/show_list'),					 
											
											// AS both comm payment report and site revenue report are same=== MRINMOY 28-09-2011
															 
                                          'Site_revenue_report'=>array('label'=>'Site revenue Report',
                                                             'top_menu'=>'Report',
                                                             'menu_name'=>'Site Revenue Report',
                                                             'menu_link'=>'site_revenue_report/show_list')							
										
										
										); 	
										
										
									


										

// Iman
$db['default']["CONTROLLER_NO_ACCESS_REQUIRED"] = array("Home","Forgot_password","Language","My_account","Buyers_profile","Tradesman_profile_view","Job_overview","Quote_overview","Verification_overview",'Job_expire','Quote_approve_day_expire',"Radar_job","Frozen_job_to_active","Frozen_job_alert","Subscription");

/* End of file database.php */
/* Location: ./system/application/config/database.php */