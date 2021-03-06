<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	http://example.com/
|
| If this is not set then CodeIgniter will guess the protocol, domain and
| path to your installation.
|
*/
if(ENVIRONMENT == 'production')//For Live site (ENVIRONMENT defined at index.php)
{
    //$config['base_url']    = "http://".$_SERVER['SERVER_NAME']."/";
    $config['base_url']	= "http://".$_SERVER['SERVER_NAME']."/";
}
else
    $config['base_url']    = "http://".$_SERVER['SERVER_NAME']."/ams/";

/*
|--------------------------------------------------------------------------
| Index File
|--------------------------------------------------------------------------
|
| Typically this will be your index.php file, unless you've renamed it to
| something else. If you are using mod_rewrite to remove the page set this
| variable so that it is blank.
|
*/
//$config['index_page'] = 'index.php';
$config['index_page'] = '';

/*
|--------------------------------------------------------------------------
| URI PROTOCOL
|--------------------------------------------------------------------------
|
| This item determines which server global should be used to retrieve the
| URI string.  The default setting of 'AUTO' works for most servers.
| If your links do not seem to work, try one of the other delicious flavors:
|
| 'AUTO'			Default - auto detects
| 'PATH_INFO'		Uses the PATH_INFO
| 'QUERY_STRING'	Uses the QUERY_STRING
| 'REQUEST_URI'		Uses the REQUEST_URI
| 'ORIG_PATH_INFO'	Uses the ORIG_PATH_INFO
|
*/

$config['uri_protocol']	= 'AUTO';

/*
|--------------------------------------------------------------------------
| URL suffix
|--------------------------------------------------------------------------
|
| This option allows you to add a suffix to all URLs generated by CodeIgniter.
| For more information please see the user guide:
|
| http://codeigniter.com/user_guide/general/urls.html
*/

#$config['url_suffix'] = '.html';
$config['url_suffix'] = '';

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| This determines which set of language files should be used. Make sure
| there is an available translation if you intend to use something other
| than english.
|
*/
$config['language']	= 'english';

/*
|--------------------------------------------------------------------------
| Default Character Set
|--------------------------------------------------------------------------
|
| This determines which character set is used by default in various methods
| that require a character set to be provided.
|
*/
$config['charset'] = 'UTF-16';

/*
|--------------------------------------------------------------------------
| Enable/Disable System Hooks
|--------------------------------------------------------------------------
|
| If you would like to use the 'hooks' feature you must enable it by
| setting this variable to TRUE (boolean).  See the user guide for details.
|
*/
$config['enable_hooks'] = false;


/*
|--------------------------------------------------------------------------
| Class Extension Prefix
|--------------------------------------------------------------------------
|
| This item allows you to set the filename/classname prefix when extending
| native libraries.  For more information please see the user guide:
|
| http://codeigniter.com/user_guide/general/core_classes.html
| http://codeigniter.com/user_guide/general/creating_libraries.html
|
*/
$config['subclass_prefix'] = 'MY_';


/*
|--------------------------------------------------------------------------
| Allowed URL Characters
|--------------------------------------------------------------------------
|
| This lets you specify with a regular expression which characters are permitted
| within your URLs.  When someone tries to submit a URL with disallowed
| characters they will get a warning message.
|
| As a security measure you are STRONGLY encouraged to restrict URLs to
| as few characters as possible.  By default only these are allowed: a-z 0-9~%.:_-
|
| Leave blank to allow all characters -- but only if you are insane.
|
| DO NOT CHANGE THIS UNLESS YOU FULLY UNDERSTAND THE REPERCUSSIONS!!
|
*/
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-=?';


/*
|--------------------------------------------------------------------------
| Enable Query Strings
|--------------------------------------------------------------------------
|
| By default CodeIgniter uses search-engine friendly segment based URLs:
| example.com/who/what/where/
|
| By default CodeIgniter enables access to the $_GET array.  If for some
| reason you would like to disable it, set 'allow_get_array' to FALSE.
|
| You can optionally enable standard query string based URLs:
| example.com?who=me&what=something&where=here
|
| Options are: TRUE or FALSE (boolean)
|
| The other items let you set the query string 'words' that will
| invoke your controllers and its functions:
| example.com/index.php?c=controller&m=function
|
| Please note that some of the helpers won't work as expected when
| this feature is enabled, since CodeIgniter is designed primarily to
| use segment based URLs.
|
*/
$config['allow_get_array']		= TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger']	= 'c';
$config['function_trigger']		= 'm';
$config['directory_trigger']	= 'd'; // experimental not currently in use

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
| If you have enabled error logging, you can set an error threshold to
| determine what gets logged. Threshold options are:
| You can enable error logging by setting a threshold over zero. The
| threshold determines what gets logged. Threshold options are:
|
|	0 = Disables logging, Error logging TURNED OFF
|	1 = Error Messages (including PHP errors)
|	2 = Debug Messages
|	3 = Informational Messages
|	4 = All Messages
|
| For a live site you'll usually only enable Errors (1) to be logged otherwise
| your log files will fill up very fast.
|
*/
$config['log_threshold'] = 0;

/*
|--------------------------------------------------------------------------
| Error Logging Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/logs/ folder. Use a full server path with trailing slash.
|
*/
$config['log_path'] = '';

/*
|--------------------------------------------------------------------------
| Date Format for Logs
|--------------------------------------------------------------------------
|
| Each item that is logged has an associated date. You can use PHP date
| codes to set your own date formatting
|
*/
$config['log_date_format'] = 'Y-m-d H:i:s';

/*
|--------------------------------------------------------------------------
| Cache Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| system/cache/ folder.  Use a full server path with trailing slash.
|
*/
$config['cache_path'] = '';

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| If you use the Encryption class or the Session class you
| MUST set an encryption key.  See the user guide for info.
|
*/
$config['encryption_key'] = 'acs#';

/*
|--------------------------------------------------------------------------
| Session Variables
|--------------------------------------------------------------------------
|
| 'sess_cookie_name'		= the name you want for the cookie
| 'sess_expiration'			= the number of SECONDS you want the session to last.
|   by default sessions last 7200 seconds (two hours).  Set to zero for no expiration.
| 'sess_expire_on_close'	= Whether to cause the session to expire automatically
|   when the browser window is closed
| 'sess_encrypt_cookie'		= Whether to encrypt the cookie
| 'sess_use_database'		= Whether to save the session data to a database
| 'sess_table_name'			= The name of the session database table
| 'sess_match_ip'			= Whether to match the user's IP address when reading the session data
| 'sess_match_useragent'	= Whether to match the User Agent when reading the session data
| 'sess_time_to_update'		= how many seconds between CI refreshing Session Information
|
*/
$config['sess_cookie_name']		= 'ci_session';
$config['sess_expiration']		= 72000;
$config['sess_expire_on_close']	= FALSE;
$config['sess_encrypt_cookie']	= FALSE;
$config['sess_use_database']	= FALSE;
$config['sess_table_name']		= 'ci_sessions';
$config['sess_match_ip']		= FALSE;
$config['sess_match_useragent']	= TRUE;
$config['sess_time_to_update']	= 300000;

/*
|--------------------------------------------------------------------------
| Cookie Related Variables
|--------------------------------------------------------------------------
|
| 'cookie_prefix' = Set a prefix if you need to avoid collisions
| 'cookie_domain' = Set to .your-domain.com for site-wide cookies
| 'cookie_path'   =  Typically will be a forward slash
| 'cookie_secure' =  Cookies will only be set if a secure HTTPS connection exists.
|
*/
$config['cookie_prefix']	= "";
$config['cookie_domain']	= "";
$config['cookie_path']		= "/";
$config['cookie_secure']	= FALSE;

/*
|--------------------------------------------------------------------------
| Global XSS Filtering
|--------------------------------------------------------------------------
|
| Determines whether the XSS filter is always active when GET, POST or
| COOKIE data is encountered
|
*/
$config['global_xss_filtering'] = FALSE;

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery
|--------------------------------------------------------------------------
| Enables a CSRF cookie token to be set. When set to TRUE, token will be
| checked on a submitted form. If you are accepting user data, it is strongly
| recommended CSRF protection be enabled.
|
| 'csrf_token_name' = The token name
| 'csrf_cookie_name' = The cookie name
| 'csrf_expire' = The number in seconds the token should expire.
*/
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;

/*
|--------------------------------------------------------------------------
| Output Compression
|--------------------------------------------------------------------------
|
| Enables Gzip output compression for faster page loads.  When enabled,
| the output class will test whether your server supports Gzip.
| Even if it does, however, not all browsers support compression
| so enable only if you are reasonably sure your visitors can handle it.
|
| VERY IMPORTANT:  If you are getting a blank page when compression is enabled it
| means you are prematurely outputting something to your browser. It could
| even be a line of whitespace at the end of one of your scripts.  For
| compression to work, nothing can be sent before the output buffer is called
| by the output class.  Do not 'echo' any values with compression enabled.
|
*/
$config['compress_output'] = FALSE;

/*
|--------------------------------------------------------------------------
| Master Time Reference
|--------------------------------------------------------------------------
|
| Options are 'local' or 'gmt'.  This pref tells the system whether to use
| your server's local time as the master 'now' reference, or convert it to
| GMT.  See the 'date helper' page of the user guide for information
| regarding date handling.
|
*/
$config['time_reference'] = 'local';


/*
|--------------------------------------------------------------------------
| Rewrite PHP Short Tags
|--------------------------------------------------------------------------
|
| If your PHP installation does not have short tag support enabled CI
| can rewrite the tags on-the-fly, enabling you to utilize that syntax
| in your view files.  Options are TRUE or FALSE (boolean)
|
*/
$config['rewrite_short_tags'] = FALSE;


/*
|--------------------------------------------------------------------------
| Reverse Proxy IPs
|--------------------------------------------------------------------------
|
| If your server is behind a reverse proxy, you must whitelist the proxy IP
| addresses from which CodeIgniter should trust the HTTP_X_FORWARDED_FOR
| header in order to properly identify the visitor's IP address.
| Comma-delimited, e.g. '10.0.1.200,10.0.1.201'
|
*/
$config['proxy_ips'] = '';


/************ Extra config setting start **************/


// Language
/********** Language *************/

/* xml that contains translations */
$config['multilanguage_xml'] = 'multilanguage/tmx.xml';
/* cache of serialized TranslationContainer object that contains translations */
$config['multilanguage_object'] = 'multilanguage/translations.tc'; 

//For multiple Languages
$config['default_language'] = 'en';
$config['languages'] = array('en', 'ar');

// Added to show default user type for dev admin in murphy project
$config['dev_user_type'] = 1;

$config['images_url']    =    $config['base_url']."resource/images/";
$config['css_url']       =    $config['base_url']."resource/css/";
$config['js_url']        =    $config['base_url']."resource/js/";

$config['admin_base_url']=    $config['base_url']."web_master/";

$config['dbf_file_upload_path']        = BASEPATH.'../uploaded/dbf_file/';

/* End of file config.php */
/* Location: ./application/config/config.php */


$config['uri_seg'] = 4;///Used for pagination in get_admin_pagination(),Changed for live
$config['fe_uri_seg']=3;///Used for pagination in get_fe_pagination(),Changed for live

// Salt has been changed 25 Jan 2014
$config['security_salt']	= "_acs#13_";///for encrypting Password

$config['site_date_format'] = "m-d-Y"; // US FORMAT  
$config['us_date_format'] 	= "m-d-Y"; // US FORMAT  
$config['uk_date_format'] 	= "m-d-Y"; // UK FORMAT  

$config['admin_file_upload_max_size']    = 1115*1024;///for File upload

$config['USER_SMS_ACCOUNT']="";
$config['USER_SMS_PASSWORD']="";

$config['admin_email'] = "info@ams.com";
$config['EMAILBODYHTML'] = BASEPATH.'../resource/mail_body/';

// doc 2 pdf added on 21st sept 2015
$config['doc2pdf_api_key']	= 'lsxi4k2dtpr4br'; // mrinsss@gmail
$config['doc2pdf_up_path']  = FCPATH.'uploaded/doc_pdf/';
$config['doc2pdf_down_path']= $config['base_url']."uploaded/doc_pdf/";   

// agent and buyer bli
$config['bli_up_path']  = FCPATH.'uploaded/bli/';
$config['bli_down_path']= $config['base_url']."uploaded/bli/";   

// below width, height for checking image upload
#$config['profile_img_width']    = 150;
#$config['profile_img_height']   = 185;
//changed on 27 jan as per requirement on MOMS Testing 01252016
$config['profile_img_width']    = 127;
$config['profile_img_height']   = 164;

// call to cation/advertisement images for cms
$config['resource_img_upload_path']         = FCPATH.'uploaded/cms_resources/';   
$config['resource_img_thumb_upload_path']   = $config['resource_img_upload_path'].'thumb/';  
$config['resource_img_display_path']        = $config['base_url']."uploaded/cms_resources/";   
$config['resource_img_thumb_display_path']  = $config['base_url']."uploaded/cms_resources/thumb/";
$config['resource_img_thumb_height']        = 120;
$config['resource_img_thumb_width']         = 180; 

// call to cation/advertisement images for cms
$config['cta_image_upload_path']            = FCPATH.'uploaded/cta_image/';   
$config['cta_image_thumb_upload_path']      = $config['cta_image_upload_path'].'thumb/';  
$config['cta_image_display_path']           = $config['base_url']."uploaded/cta_image/";   
$config['cta_image_thumb_display_path']    = $config['base_url']."uploaded/cta_image/thumb/";
$config['cta_image_thumb_height']           = 280;
$config['cta_image_thumb_width']            = 210;  

// images for user profile
$config['user_image_upload_path']            = FCPATH.'uploaded/user_image/';   
$config['user_image_thumb_upload_path']      = $config['user_image_upload_path'].'thumb/';  
$config['user_image_display_path']           = $config['base_url']."uploaded/user_image/";   
$config['user_image_thumb_display_path']     = $config['base_url']."uploaded/user_image/thumb/";
$config['user_image_thumb_height']           = 100;
$config['user_image_thumb_width']            = 150;   

// Business Picture
$config['biz_img_upload_path']               = FCPATH.'uploaded/business_image/';   
$config['biz_img_thumb_upload_path']         = $config['biz_img_upload_path'].'thumb/';  
$config['biz_img_display_path']              = $config['base_url']."uploaded/business_image/";   
$config['biz_img_thumb_display_path']        = $config['base_url']."uploaded/business_image/thumb/";
$config['biz_img_thumb_height']              = 150;
$config['biz_img_thumb_width']               = 225;   
// End

// demo
$config['customer_image_upload_path']					= FCPATH.'uploaded/customer/';   
$config['customer_image_thumb_upload_path']				= $config['customer_image_upload_path'].'thumb/';  
$config['customer_image_small_thumb_upload_path']		= $config['customer_image_upload_path'].'small_thumb/'; 
$config['customer_image_display_path']					= $config['base_url']."uploaded/customer/";   
$config['customer_image_thumb_display_path']			= $config['base_url']."uploaded/customer/thumb/";   
$config['customer_image_small_thumb_display_path']		= $config['base_url']."uploaded/customer/small_thumb/"; 
 
$config['customer_image_thumb_height']					= 174;
$config['customer_image_thumb_width']					= 355;
$config['customer_image_small_thumb_height']			= 103;
$config['customer_image_small_thumb_width']				= 103;
// End

$config['acubid_upload_path']                           = FCPATH.'uploaded/acubid_file/';  
$config['acubid_display_path']                          = $config['base_url'].'uploaded/acubid_file/'; 



$config['bann_er_img_upload_path']               = FCPATH.'uploaded/banner_image/';
$config['bann_er_img_display_path']              = $config['base_url']."uploaded/banner_image/";
$config['bann_er_img_height']                    = 416;
$config['bann_er_img_width']                     = 1280; 



 

$config['PRINT_PAGE_FOOTER_TEXT']  = '';


// master documents upload path
$config['doc_master_upload_path']   = FCPATH.'uploaded/doc_master/';               
$config['doc_master_display_path']  = $config['base_url'].'uploaded/doc_master/';   

$config['rs_consumer_key'] = "wU0LJ3kaJwLIkhqTpWRBBZxGO3YbPqDEmeovwebp";
$config['rs_consumer_secret'] = "4I0ixTEgjG4H5VGKt6tbN5MIe9IKofmJFz3GryuG";
$config['rs_oauth_callback'] = $config['base_url']."web_master/manage_admin_user/nap_manage_rs_oauth"; // An out-of-band oauth_callback
$config['rs_token'] = "rLtORSjL7cUrWJoR39qrl4DmFjqApVmCEkB7qwKl"; // JS     

// BOV :: Step 10, Buyer Method
$config['DOWNPAYMENT_AS_PRICE'] = 25; // Downpayment as % of Price (%)
$config['ANNUAL_CAPITAL_EXPENSE'] = 10; // Estimated Annual Capital Expense as a Percent of Fixed Asset Value at Cost (%)
$config['LOAN_INTEREST_RATE'] = 6.75 ; // Loan Interest Rate
$config['LOAN_PERIOD'] = 84; // Loan Period (Number of Months)
$config['DEBT_COVERAGE_RATIO'] = 1.25; // Debt Coverage Ratio

// BOV :: Step 11, Valuation Summary
$config['MULTIPLE_EARNING_METHOD_WEIGHT'] = 15;
$config['BUYER_TEST_METHOD_WEIGHT'] = 35;
$config['MARKET_MULTIPLE_METHOD_WEIGHT'] = 50;

       
// Set for business field validation  
$required_field_list['business_brokerage'] = array(
    's_seller_name','s_seller_mobile','s_seller_email','s_seller_address_one','s_seller_zipcode','i_seller_city_id','i_seller_state_id','s_seller_county','i_seller_country_id','s_business_name','s_business_dba_name','s_listing_title','s_address','s_zipcode','i_city_id','i_state_id','s_city','i_country_id','i_region_id','i_franchise_id','s_listing_agent_name','i_type_location','i_organization_type','s_years_established','s_years_owned','i_listing_type','i_listing_office','s_sic','s_naics','s_days_hrs_operation','s_owner_hrs_worked_per_week','s_employees_ft','s_employees_pt','s_employees_manager','s_franchise','e_home_based','e_relocatable','s_train_weeks','s_train_cost', 's_source_of_listing');

$required_field_list['commercial_real_estate'] = array(
    's_seller_name','s_seller_mobile','s_seller_email','s_seller_address_one','s_seller_zipcode','i_seller_city_id','i_seller_state_id','s_seller_county','i_seller_country_id','i_region_id','i_franchise_id','s_listing_agent_name','dt_listing_date','dt_engagement_expired','s_building_size','d_price','s_sale_terms','s_display_title','s_address','s_address','s_zipcode','i_city_id','i_state_id','i_country_id','s_property_use'
);

$required_field_list['machinery_equipment'] = array(
    's_seller_name','s_seller_mobile','s_seller_email','s_seller_address_one','s_seller_zipcode','i_seller_city_id','i_seller_state_id','s_seller_county','i_seller_country_id','i_region_id','i_franchise_id','s_listing_agent_name','dt_listing_date','dt_engagement_expired','e_equipment_type','s_manufacturer','s_model','s_county','s_zipcode','i_city_id','i_state_id','i_country_id','d_price','s_terms','e_new_condition'
);

$required_field_list['franchise'] = array(
    'i_region_id','i_franchise_id','s_listing_agent_name','s_business_name','s_public_name','s_title','s_address','s_county','s_zipcode','i_city_id','i_state_id'
);

$config['required_field_list'] = $required_field_list;
// End

// Basic Business Status
//$config['LISTING_STATUS'] = array(0=>'Prospect',  21=>'Active', 31=>'Under Contract', 33=>'Withdrawn', 35=>'Sold', 37=>'Expired', 40=>'Closed');
$config['LISTING_STATUS'] = array(0=>'Prospect',  21=>'Active', 31=>'Under Contract', 33=>'Withdrawn', 37=>'Expired', 40=>'Sold');
#$config['LISTING_STATUS'] = array(33=>'Withdrawn', 37=>'Expired', 40=>'Sold');
// End

// below used in add edit cms page
$config['CMS_SUB_PAGES'] = array('mp_faq'=>'FAQ', 'mp_news'=>'News');
// End

// BOV Steps
$config['BOV_STEPS'] = array(
    1 => 'User Preferences', 2 => 'Manage Clients', 3 => 'Manage Valuations', 4 => 'Income Statements', 5 => 'Recast Income Statements', 6 => 'Income Statement Summary', 7 => 'Balance Sheet', 8 => 'Market Method', 9 => 'Multiple of SDE Method', 10 => 'Buyer\'s Test Method', 11 => 'Valuation Summary', 12 => 'Valuation Report', 13 => 'Valuation Notes');
// End


// REGION AND FRANCHISE CMS PAGES
$cms_pages_list['region'] = array(
    /*'Home or Regional Landing'=>'name',*/
    //'Find an Office'=>'find-a-local-office',
    'Find an Office'=>'find-local-office',
    'Buy a Business'=>'services/buy-a-business',
    'Sell a Business'=>'services/sell-a-business',
    'Meet our Team'=>'meet-our-team',
    'Businesses for Sale'=>'view-our-listings/businesses-for-sale',
    'M & A Businesses for Sale'=>'view-our-listings/m-a-listings',
    'Commercial Listings'=>'view-our-listings/commercial-listings',
    'Machinery & Equipment'=>'view-our-listings/machinery-equipment-listings',
    'Franchise Opportunities'=>'view-our-listings/franchise-opportunities',
    'Buyer Search'=>'buyer-search',
    'Professional Partner'=>'professional-partners',
    'Contact Us'=>'contact-us',
    'Contact Confirmation'=>'contact-us-confirmation'
);

$cms_pages_list['franchise'] = array(
    /*'Home or Regional Landing'=>'name',*/
    'Buy a Business'=>'services/buy-a-business',
    'Sell a Business'=>'services/sell-a-business',
    'Meet our Team'=>'meet-our-team',
    'Businesses for Sale'=>'view-our-listings/businesses-for-sale',
    'M & A Businesses for Sale'=>'view-our-listings/m-a-listings',
    'Commercial Listings'=>'view-our-listings/commercial-listings',
    'Machinery & Equipment'=>'view-our-listings/machinery-equipment-listings',
    'Franchise Opportunities'=>'view-our-listings/franchise-opportunities',
    'Buyer Search'=>'buyer-search',
    'Professional Partner'=>'professional-partners',
    'Contact Us'=>'contact-us',
    'Contact Confirmation'=>'contact-us-confirmation'
);
$config['cms_pages_list'] = $cms_pages_list;
// END REGION AND FRANCHISE CMS PAGES


$config['email_preferences'] = array(
    'newsletter' => 'News Letter',
    'notification' => 'Notification',
);

// DOCUMENT NUMBER // JS
$config['DOCUMENT_NUMBER'] = array(
    'CM' => '0000', // Confidential Memorandum
    'NDA' => '0001', //–> NDA (Non Disclosure)
    'ENG_AGR' =>  '0002', //–> Engagement Agreement
    'PUR_AGR' => '0003', //–> Purchase Agreement
    'ENG_ADD' => '0004', //–> Engagement Addendum
    'PUR_ADD' => '0005', //–> Purchase Addendum
    'COU_OFF' => '0006', //–> Counter Offer
);
// END





            
/***
* Javascript Validation Rule
*/
// Email // acumen.testmail01@gmail.com
$config['valid_email'] = '/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/';

// Url // http://www.site-name.com
$config['valid_url'] = '/^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/';

// Phone Number // (123) 123 1234 or 123-123-1234 or 123123124
$config['valid_phone'] = '/(\W|^)[(]{0,1}\d{3}[)]{0,1}[\s-]{0,1}\d{3}[\s-]{0,1}\d{4}(\W|$)/';

// Digit Value // 456, 023 , 56
$config['digit'] = '/^\d+$/'; // /^\d{2,}$/ Any number of intereg length at least 2 

// Float/Double Number Value //(45.23, .2, 4.23, 4)
$config['floating_number'] = '/^\d{0,2}(\.\d{0,2}){0,1}$/'; 

// Date Format // dd/mm/yyyy
$config['date_format'] = '/^(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d$/';
/***
*  End
*/

