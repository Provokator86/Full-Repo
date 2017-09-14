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
    $db['default']['username'] = "acumencs_quotejb";
    $db['default']['password'] = "quotejb";
    $db['default']['database'] = "acumencs_quoteurjob";    
}
else
{
    $db['default']['hostname'] = "localhost";
    $db['default']['username'] = "root";
    $db['default']['password'] = "";
    $db['default']['database'] = "format";    
}

$db['default']['dbdriver'] = "mysql";
$db['default']['dbprefix'] = "";
$db['default']['tableprefix'] = "quoteurjob_";
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";


/*************DB TABLE NAMES********************/
$s_tblPre=$db['default']['tableprefix'];
$db['default']["USER"]					=	$s_tblPre."admin";
$db['default']["USERMANAGE"]            =    $s_tblPre."user"; 

$db['default']["MENU"]					=	$s_tblPre."menu";
$db['default']["MENUPERMIT"]			=	$s_tblPre."menu_permit";
///////////////////////////////////////////////////////////////////////
$db['default']["USER_TYPE"]				=	$s_tblPre."mst_user_type";
$db['default']["USER_TYPE_ACCESS"]		=	$s_tblPre."user_type_access";
$db['default']["STATE"]					=	$s_tblPre."state";
$db['default']["CITY"]					=	$s_tblPre."city";
$db['default']["ZIPCODE"]				=	$s_tblPre."zipcode";
$db['default']["LANGUAGE"]				=	$s_tblPre."language";
$db['default']["NEWS"]					=	$s_tblPre."news";
$db['default']["NEWSLETTER"]			=	$s_tblPre."newsletter";
$db['default']["NEWSLETTERSUBCRIPTION"]	=	$s_tblPre."newsletter_subscription";
$db['default']["CMS"]					=	$s_tblPre."cms";
$db['default']["CMSMASTERTYPE"]			=	$s_tblPre."cms_master_type";
$db['default']["AUTOMAIL"]				=	$s_tblPre."auto_mail";
$db['default']["SITESETTING"]			=	$s_tblPre."admin_site_settings";
$db['default']["TESTIMONIAL"]			=	$s_tblPre."testimonials";
$db['default']["CATEGORY"]				=	$s_tblPre."category";
$db['default']["CATEGORYCHILD"]			=	$s_tblPre."category_lang";
$db['default']["SLAB"]					=	$s_tblPre."admin_commission_setting";
$db['default']["METATAGS"]				=	$s_tblPre."meta_tag";
$db['default']["FAQ"]					=	$s_tblPre."faq";
$db['default']["HOWITWORKS"]			=	$s_tblPre."how_it_works";
$db['default']["HELP"]					=	$s_tblPre."help";

unset($s_tblPre);


/*************end DB TABLE NAMES********************/





/* **********
 Author: Koushik Rout
 Date  : 28 DEC 2011
 Modified By: 
 Modified Date:
********* */

$db['default']["PAGINATION"]   = array('5'=>'5','10'=>'10','15'=>'15'); // Iman


$db['default']["AUTOMAIL_KEY"]= array(  
										
										
										'registration_mail'=>'Registration_mail',
										'referral_mail'=>'Referral Mail',
										'forget_password'=>'Forget Password', 
										'contact_us'=>'Contact Us',
										'account_deactivate'=>'Account Deactivate',
										'account_reactivate'=>'Account Reactivate',
										'abuse_report'=>'Abuse Report');  // Iman
										


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
*/

//////////All Menus

$db['default']["CONTROLLER_NAME"] = array(


                                         /************Master / General ****************/
                                         /* 'Dashboard'=>array('label'=>'Dashboard',
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
															 
                                        																 
											 'Category'=>array('label'=>'Category',
 															 'top_menu'=>'General',
															 'menu_name'=>'Category',
															 'menu_link'=>'category/show_list' ),					 
															 */
										  'State'=>array('label'=>'State',
 															 'top_menu'=>'General',
															 'menu_name'=>'State',
															 'menu_link'=>'state/show_list' ),
															 
										  'City'=>array('label'=>'City',
 															 'top_menu'=>'General',
															 'menu_name'=>'City',
															 'menu_link'=>'city/show_list' ),
															 
										  'Postal_code'=>array('label'=>'Postal Code',
 															 'top_menu'=>'General',
															 'menu_name'=>'Postal Code',
															 'menu_link'=>'postal_code/show_list' ),
															 
										  /*'My_account'=>array('label'=>'My Account',
 															 'top_menu'=>'General',
															 'menu_name'=>'My Account',
															 'menu_link'=>'my_account/' ),
                                                             
                                                           
                                          'User_admin'=>array('label'=>'Admin User',
                                                             'top_menu'=>'General',
                                                             'menu_name'=>'Admin User',
                                                             'menu_link'=>'user_admin/show_list' ),        
                                                             
                                          'User_type_master'=>array('label'=>'User Type Master',
                                                             'top_menu'=>'General',
                                                             'menu_name'=>'User Type Master',
                                                             'menu_link'=>'user_type_master/show_list' ),  */      				 
									   
										 /************User****************/  	
                                          /*'Manage_user'=>array('label'=>'Manage User',
                                                              'top_menu'=>'User',
                                                             'menu_name'=>'Manage User',
                                                             'menu_link'=>'manage_user/show_list' ),*/
															 
										/************CMS****************/ 										
										
										 'Cms'=>array('label'=>'Static Pages',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'Static Pages',
                                                             'menu_link'=>'cms/add_information' ),
									
										 'News'=>array('label'=>'News',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'News',
															 'menu_link'=>'news/show_list', ),
										     
                                          /*'Faq'=>array('label'=>'FAQ',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'FAQ',
                                                             'menu_link'=>'faq/show_list',
															  ),
										
														  
										 'How_it_works'=>array('label'=>'How It Works',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'How It Works',
                                                             'menu_link'=>'how_it_works/show_list',
															 
															  ),
											
														  
                                          'Testimonial'=>array('label'=>'Testimonial',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'Testimonial',
                                                             'menu_link'=>'testimonial/show_list' ),
															 
															  
										  
										  'Help'=>array('label'=>'Help',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'Help',
                                                            'menu_link'=>'help/show_list',
                                                            ),

															  
															  
										 'Auto_mail'=>array('label'=>'Auto Mail',
                                                             'top_menu'=>'CMS',
                                                             'menu_name'=>'Automail',
                                                             'menu_link'=>'auto_mail/show_list/',
                                                             //'menu_link'=>'auto_mail/show_param_list/WjJWdVpYSmhiQ05oWTNVPQ==',
															 //'sub_menu_name'=>'General Automail',
															 //'sub_menu_link'=>'auto_mail/show_param_list/WjJWdVpYSmhiQ05oWTNVPQ==',
															  ),	*/

										/*********** Manage SEO **********/										
																									  
									    'Meta_tags'=>array('label'=>'Page Title & Meta Tags',
														 'top_menu'=>'SEO',
														 'menu_name'=>'Page Title & Meta Tags',
														 'menu_link'=>'meta_tags/show_list' ),	

															  
										/************manage Emails****************/  
										
                                          'Newsletter'=>array('label'=>'Newsletter',
                                                             'top_menu'=>'Email',
                                                             'menu_name'=>'Newsletter',
                                                             'menu_link'=>'newsletter/show_list' ),
															 
                                          'Newsletter_subscribers'=>array('label'=>'Newsletter Subscriber',
                                                             'top_menu'=>'Email',
                                                             'menu_name'=>'Newsletter Subscribers',
                                                             'menu_link'=>'newsletter_subscribers/show_list' )
															 
										/***********Reports****************/ 
															 															 
                                         /* 'Site_summary_report'=>array('label'=>'Site Summary Report',
                                                             'top_menu'=>'Report',
                                                             'menu_name'=>'Site Summary Report',
                                                             'menu_link'=>'site_summary_report/show_list'),*/
										
										); 	
										
										
									


										

// Iman
$db['default']["CONTROLLER_NO_ACCESS_REQUIRED"] = array("Home","Forgot_password","Language","My_account","Manage_user");

/* End of file database.php */
/* Location: ./system/application/config/database.php */