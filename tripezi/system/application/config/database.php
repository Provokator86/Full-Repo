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
    $db['default']['username'] = "acumencs_hizmet";
    $db['default']['password'] = "acumencs_hizmet";
    $db['default']['database'] = "acumencs_hizmetuzmani";    
}
else
{
    $db['default']['hostname'] = "localhost";
    $db['default']['username'] = "root";
    $db['default']['password'] = "";
    $db['default']['database'] = "property_space";    
	
}

$db['default']['dbdriver'] = "mysqli";
$db['default']['dbprefix'] = "";
$db['default']['tableprefix'] = "propertyspace_";
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";


/*************DB TABLE NAMES********************/
$s_tblPre=$db['default']['tableprefix'];

// Table for general tab
$db['default']["ADMIN"]                     =   $s_tblPre."admin";
$db['default']["SITESETTING"]               =   $s_tblPre."admin_site_settings";
$db['default']["MENU"]					    =	$s_tblPre."menu";
$db['default']["MENUPERMIT"]			    =	$s_tblPre."menu_permit";
$db['default']["COUNTRY"]				    =	$s_tblPre."country";
$db['default']["STATE"]						=	$s_tblPre."state";
$db['default']["CITY"]                      =   $s_tblPre."city";
$db['default']["CURRENCY"]					=	$s_tblPre."currency";

// Table for user tab
$db['default']["USER"]                      =   $s_tblPre."user";
$db['default']["PROPERTY"]                  =   $s_tblPre."property";
$db['default']["PROPERTYCANCELLATIONPOLICY"]=   $s_tblPre."cancellation_policy"; 
$db['default']["PROPERTYIMAGE"]             =   $s_tblPre."property_image"; 
$db['default']["REVIEWSRATING"]             =   $s_tblPre."reviews_rating"; 
$db['default']["BOOKING"]                   =   $s_tblPre."booking"; 
$db['default']["BOOKINGGUESTS"]             =   $s_tblPre."booking_guests"; 
$db['default']["FAVOURITES"]             	=   $s_tblPre."favourite_property";

//Table for Asset
$db['default']["AMENITY"]                  	=   $s_tblPre."amenity";
$db['default']["PROPERTYAMENITY"]          	=   $s_tblPre."property_amenity";
$db['default']["PROPERTYBEDTYPE"]           =   $s_tblPre."bed_type";
$db['default']["PROPERTYTYPE"]              =   $s_tblPre."property_type";  

//Table name for CMS

$db['default']["TESTIMONIALS"]              =   $s_tblPre."testimonials";
$db['default']["METATAGS"]                  =   $s_tblPre."meta_tag";
$db['default']["PRESS"]                     =   $s_tblPre."press"; 
$db['default']["CMS"]                       =   $s_tblPre."cms";
$db['default']["AUTOMAIL"]                  =   $s_tblPre."auto_mail";
$db['default']["AUTOSMS"]                   =   $s_tblPre."auto_sms";
$db['default']["BLOG"]                      =   $s_tblPre."blog";
$db['default']["BLOGCOMMENT"]               =   $s_tblPre."blog_comment";
$db['default']["JOBS"]                      =   $s_tblPre."jobs";
$db['default']["FAQ"]						=	$s_tblPre."faq";
   
//Table name for Newsletter
$db['default']["EMAILLOG"]                  =   $s_tblPre."email_log";
$db['default']["NEWSLETTER"]                =   $s_tblPre."newsletter";
$db['default']["NEWSLETTERSUBCRIPTION"]     =   $s_tblPre."newsletter_subscription";
$db['default']["PROPERTYBLOCKED"]           =   $s_tblPre."property_blocked";
$db['default']["MESSAGE"]                   =   $s_tblPre."message";
$db['default']["TEMPORARY_PAYMENT"]         =   $s_tblPre."temporary_payment";

unset($s_tblPre);


/*************end DB TABLE NAMES********************/

$db['default']["ARR_NUMBER"]		= range(1,30,1);
$db['default']["TESTIMONIALSTATE"] 	= array('1'=>'Pending','2'=>'Approved','3'=>'Reject'); // Mrinmoy Mondal
$db['default']["ROOMTYPE"] 			= array('1'=>'Private room','2'=>'Shared room','3'=>'Entire home/appartment');  

$db['default']["AUTOMAIL_KEY"]		= array( 
										'registration_mail'=>'Registration Mail',
										'facebook_ragistration'=>'Facebook Registration Mail',
										'forget_password'=>'Forget Password', 
										'contact_us'=>'Contact Us',
										'booking_request'=>'Booking request received by owner',
										'booking_confirmed'=>'Booking request confirmation to traveler',
										'payment_receipt'=>'Payment receipt to traveler',
										'payment_confirm_owner'=>'Payment confirmation to owner',
										'booking_cancel_owner'=>'Booking cancellation confirmation to owner',
										'booking_cancel_traveler'=>'Booking cancellation confirmation to traveler',
										'booking_cancel_rejected'=>'Booking cancellation rejected to traveler',
										'send_message'=>'Message Send',
										'edit_accout'=>'Edit Account',
										'check_in_date_passed'=>'Check in date passed'
										);  // Mrinmoy


$db['default']["BOOKING_STATUS"]    =   array(
                                                'Request sent'=>'Request sent',
                                                'Approve by user'=>'Approve by user',
                                                'Amount paid'=>'Amount paid',
                                                'Cancelled'=>'Cancelled',
                                                'Cancelled and Approved by admin'=>'Cancelled and Approved by admin',
                                                'Not Paid'=>'Not Paid'
                                                );//koushik

$db['default']["CURRENCY_CODE"]    =   array(
                                                'USD'=>'USD',
                                                'GBP'=>'GBP',
                                                'EURO'=>'EUR'
                                                
                                                );//koushik												
										




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

                                
                             
 // Mrinmoy	

/* End of file database.php */
/* Location: ./system/application/config/database.php */

