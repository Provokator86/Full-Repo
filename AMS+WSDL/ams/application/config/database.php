<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
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

$active_group = 'default';
$active_record = TRUE;

if(ENVIRONMENT == 'testing')//For codeuridea site (ENVIRONMENT defined at index.php)
{
    //$db['default']['hostname'] = "localhost";
    $db['default']['hostname'] = "162.144.195.204";
	$db['default']['username'] = "cuiuser_ci";
	$db['default']['password'] = "y.6H2sl+OakJ";
	$db['default']['database'] = "cuiuser_advanced_micro_solutions"; 
	//$db['default']['hostname'] = "162.144.195.204";
	//$db['default']['username'] = "cuiuser_main";
	//$db['default']['password'] = "EDHe*8tT6z5$";
}
else if(ENVIRONMENT == 'production')//For live site (ENVIRONMENT defined at index.php)
{
    $db['default']['hostname'] = "localhost";
    $db['default']['username'] = "root";
    $db['default']['password'] = "shld123";
    $db['default']['database'] = "ams";  
}
else
{
    $db['default']['hostname'] = "localhost";
    $db['default']['username'] = "root";
    $db['default']['password'] = "shld123";
    $db['default']['database'] = "ams";    
}
   
$db['default']['dbdriver'] = 'mysqli';
//$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;


$db['default']['tableprefix'] = "ams_";

/*************DB TABLE NAMES********************/
$tableprefix	=	$db['default']['tableprefix'];

// Table for general tab
//$db['default']["ADMIN"]				    = $tableprefix."admin";
$db['default']["SITESETTING"]		        = $tableprefix."admin_site_settings";
$db['default']["USER_TYPE"]                 = $tableprefix."admin_user_type";
$db['default']["USER"]                      = $tableprefix."user";
$db['default']["USERROLE"]                  = $tableprefix."user_role";
$db['default']["MENU"]				        = $tableprefix."menu";
$db['default']["MENUPERMIT"]                = $tableprefix."menu_permit";
$db['default']["USERMENU"]		            = $tableprefix."user_menu";
$db['default']["EMAIL_TEMPLATE"]            = $tableprefix."email_template";
$db['default']["BATCH_MASTER"]            	= $tableprefix."batch_master";

$db['default']["CMS_MASTER"]                = $tableprefix."cms_master";
$db['default']["CMS"]                       = $tableprefix."cms";
$db['default']["MENU_LIST"]                 = $tableprefix."menu_list";    
$db['default']["MENU_PAGE"]                 = $tableprefix."menu_page";  

$db['default']["FAQ"]                       = $tableprefix."faq";
$db['default']["NEWS"]			            = $tableprefix."news";

$db['default']["COUNTRY"]                   = $tableprefix."country";
$db['default']["STATE"]                     = $tableprefix."state";
$db['default']["CITY"]			            = $tableprefix."city";
$db['default']["CATEGORY"]                  = $tableprefix."category";
$db['default']["ZIPCODE"]                   = $tableprefix."zipcode";

// New Tables Start Below
$db['default']["FORM_MASTER"]               = $tableprefix."forms_master";
$db['default']["FORM_DETAILS"]              = $tableprefix."forms_details";
$db['default']["FORMS_PRICE_SET_MASTER"]    = $tableprefix."forms_price_set_master"; // added on jan 19,2017
$db['default']["FORMS_PRICE_SET_DETAILS"]   = $tableprefix."forms_price_set_details"; // added on jan 19,2017
$db['default']["AMOUNT_CODES"]              = $tableprefix."amount_codes";
$db['default']["PAYER_INFO"]              	= $tableprefix."payer_info";
$db['default']["PAYEE_INFO"]              	= $tableprefix."payee_info";
$db['default']["FORMS_PAYER_PAYEE_HISTORY"] = $tableprefix."forms_payer_payee_history";
$db['default']["BATCH_STATUS_HISTORY"]      = $tableprefix."batch_status_history";
$db['default']["BATCH_ASCII_FILE"]      	= $tableprefix."batch_files_downloaded";
$db['default']["BATCH_ASCII_FILE_MAP"]      = $tableprefix."batch_files_download_mapping"; // one to many relation with file download tbl

$db['default']["PAYEE_OTHERS_INFO"]         = $tableprefix."payee_others_info";

$db['default']["PAYEE_OTHERS_INFO_94SERIES"]= $tableprefix."payee_others_info_94seies";
$db['default']["FOMRS_PAID_COUNT"]          = $tableprefix."user_forms_paid_count";
$db['default']["PAYMENT_HISTORY"]          	= $tableprefix."payment_history";



// Used in source data entry
$db['default']["RECORD_TYPE"]= array(    
    'T'=>'T',
	'A'=>'A',
	'B'=>'B'
); 
 
// batches status see@ efile services workflow.docx
$db['default']["BATCH_STATS"]= array(   
    '1'=>'Invoice Pending',
	'2'=>'Invoice Paid',
	'3'=>'Filing Queued',
	'4'=>'Filing Complete',
	'5'=>'Filing Accepted',
	'6'=>'Filing Rejected'
); 
 

/* End of file database.php */
/* Location: ./application/config/database.php */
/**********************************************************/
