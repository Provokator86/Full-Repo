<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
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
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = "default";
$active_record = TRUE;

if(SITE_FOR_LIVE) ///For live site (SITE_FOR_LIVE defined at index.php)
{
    $db['default']['hostname'] = "localhost";
    $db['default']['username'] = "mydealfo_deal";
    $db['default']['password'] = "#acumen";
    $db['default']['database'] = "mydealfo_deal";    
}
else
{
    $db['default']['hostname'] = "localhost";
    $db['default']['username'] = "root";
    $db['default']['password'] = "";
    $db['default']['database'] = "mydealfo_deal";     
	
}

$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['tableprefix'] = "cd_";
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

/*************DB TABLE NAMES********************/
$s_tblPre=$db['default']['tableprefix'];

// Table for general tab
$db['default']["ADMIN"]                                 =   $s_tblPre."admin";
$db['default']["MENU"]					=	$s_tblPre."menu";
$db['default']["MENUPERMIT"]                            =	$s_tblPre."menu_permit";
// others used tables
$db['default']["BOOKPAGETEMPLATE"]                      =   $s_tblPre."book_page_template";
$db['default']["COLLAGETEMPLATE"]                       =   $s_tblPre."collage_template";
$db['default']["COUNTRY"]			    	=	$s_tblPre."country";
$db['default']["STATE"]			    		=	$s_tblPre."state";
$db['default']["CITY"]			    		=	$s_tblPre."city";
$db['default']["LOCATION_SUGGESTION"]                   =   $s_tblPre."location_suggestion";
$db['default']["BOOK_CATEGORY"]                         =   $s_tblPre."book_category";
$db['default']["CATEGORY"]       			=   $s_tblPre."category";
$db['default']["BRAND"]       				=   $s_tblPre."brand";
$db['default']["ADVERTISEMENT"]                         =   $s_tblPre."advertisement";
$db['default']["CMS"]       				=   $s_tblPre."cms";
$db['default']["CMSMASTERTYPE"]                         =   $s_tblPre."cms_master_type";
$db['default']["NEWSLETTER"]       			=   $s_tblPre."newsletter";
$db['default']["NEWSLETTERSUBCRIPTION"]                 =   $s_tblPre."newsletter_subscription";
$db['default']["SITESETTING"]     			=   $s_tblPre."admin_site_settings";
$db['default']["STORE"]     				=   $s_tblPre."store";
$db['default']["COUPON"]     				=   $s_tblPre."coupon";
$db['default']["OFFER"]     				=   $s_tblPre."offer";
$db['default']["VOTE"]     					=   $s_tblPre."vote";
$db['default']["COMMENT"]     				=   $s_tblPre."comments";
$db['default']["REPORT"]     				=   $s_tblPre."report";

$db['default']["COUPONBRAND"]     			=   $s_tblPre."coupon_brand";
$db['default']["BANNER"]     				=   $s_tblPre."banner";
$db['default']["METATAGS"]					=   $s_tblPre."meta_tag";
$db['default']["HOME_BANNER"]				=   $s_tblPre."home_banner";
$db['default']["AUTOMAIL"]					=   $s_tblPre."auto_mail";
$db['default']["AD_PAGE"]				=   $s_tblPre."ad_page";
$db['default']["MAIL_RECIEVED"]				=   $s_tblPre."mail_recived";

$db['default']["STORE_COMMENT"]     		=   $s_tblPre."store_comment";
$db['default']["AFFILIATES"]     			=   $s_tblPre."affialiates";

$db['default']["DEAL_ALERT"]     			=   $s_tblPre."deal_alert";
$db['default']["CATEGORY_STORE_MAP"]     	=   $s_tblPre."category_store_map";

$db['default']["DEALS"]     				=   $s_tblPre."deals";
$db['default']["DEALSBRAND"]     			=   $s_tblPre."deals_brand";

/* new entry on 4 June 2014 */
$db['default']["BANK_OFFER"]     			=   $s_tblPre."bank_offer";

$db['default']["FOOD_STORE"]     			=   $s_tblPre."store_food_dining";
$db['default']["FOOD_OFFER"]     			=   $s_tblPre."offer_food_dining";
$db['default']["FOOD"]     					=   $s_tblPre."food_dining";

$db['default']["TRAVEL_STORE"]     			=   $s_tblPre."store_travel";
$db['default']["TRAVEL_OFFER"]     			=   $s_tblPre."offer_travel";
$db['default']["TRAVEL"]     				=   $s_tblPre."travel";
$db['default']["TRAVEL_CAT"]     			=   $s_tblPre."category_travel";


unset($s_tblPre);


/* 
* access control features available in the site.
* @see table menu_permit , column s_action. these are enum fields 
*  
*/

$db['default']["ACTIONS"] = array(
								'Default'=>0,
								'Add'=>0,
								'Edit'=>0,
								'Delete'=>0,
								'View List'=>0,
								'View Detail'=>0,
								'Approve'=>0,
								'Status'=>0	
								);

$db['default']["AUTOMAIL_KEY"] = array( 'contact_us'			=> 'Contact Us',
										'feedback'				=> 'Feedback',
										'deal_alert'			=> 'Deal Alert',
										'welcome'				=> 'Welcome',
										'submit_a_deal' 		=> 'Submit A Deal',
										'activate_mail'			=> 'Activate Mail',
										'forget_password'		=> 'Forget Password',
										'cashback_confirm' 		=> 'Cashback Confirm',
										'share_mydeal' 			=> 'Share mydealfound.com',
										'join_mydeal' 			=> 'Come join me on Mydealfound'
										);

/* End of file database.php */
/* Location: ./application/config/database.php */