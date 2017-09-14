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
    $db['default']['database'] = "hizmetuzmani";    
	
}

$db['default']['dbdriver'] = "mysqli";
$db['default']['dbprefix'] = "";
$db['default']['tableprefix'] = "hizmetuzmani_";
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";


/*************DB TABLE NAMES********************/
$s_tblPre=$db['default']['tableprefix'];


$db['default']["ADMIN"]                 =    $s_tblPre."admin";
$db['default']["MST_USER"]              =    $s_tblPre."user"; 
$db['default']["ADMIN_NOTIFICATIONS"]   =  $s_tblPre."admin_notifications"; 

$db['default']["MENU"]					=	$s_tblPre."menu";
$db['default']["MENUPERMIT"]			=	$s_tblPre."menu_permit";
///////////////////////////////////////////////////////////////////////
$db['default']["USER_TYPE"]						=	$s_tblPre."mst_user_type";
$db['default']["USER_TYPE_ACCESS"]				=	$s_tblPre."user_type_access";
$db['default']["PROVINCE"]						=	$s_tblPre."province";
$db['default']["CITY"]							=	$s_tblPre."city";
$db['default']["ZIPCODE"]						=	$s_tblPre."zipcode";
$db['default']["LANGUAGE"]						=	$s_tblPre."language";
$db['default']["NEWS"]							=	$s_tblPre."news";
$db['default']["NEWSLETTER"]					=	$s_tblPre."newsletter";
$db['default']["NEWSLETTERSUBCRIPTION"]			=	$s_tblPre."newsletter_subscription";
$db['default']["CMS"]							=	$s_tblPre."cms";
$db['default']["CMSMASTERTYPE"]					=	$s_tblPre."cms_master_type";
$db['default']["AUTOMAIL"]						=	$s_tblPre."auto_mail";
$db['default']["SITESETTING"]					=	$s_tblPre."admin_site_settings";
$db['default']["TESTIMONIAL"]					=	$s_tblPre."testimonials";
$db['default']["CATEGORY"]						=	$s_tblPre."category";

$db['default']["SLAB"]							=	$s_tblPre."admin_commission_setting";
$db['default']["WAIVERCOMM"]					=	$s_tblPre."admin_waiver_commission";
$db['default']["CAROUSEL"]              		=    $s_tblPre."carousel_images";
$db['default']["METATAGS"]						=	$s_tblPre."meta_tag";
$db['default']["FAQ"]							=	$s_tblPre."faq";
$db['default']["HOWITWORKS"]					=	$s_tblPre."how_it_works";
$db['default']["HELP"]							=	$s_tblPre."help";
$db['default']["MEMBERSHIPPLAN"]				=	$s_tblPre."membership_plan";

/* tables using for jobs */
$db['default']["JOBS"]							=	$s_tblPre."jobs";
$db['default']["JOBS_FILES"]					=	$s_tblPre."job_files";
$db['default']["JOBFEEDBACK"]					=	$s_tblPre."job_feedback";
$db['default']["JOBQUOTES"]						=	$s_tblPre."job_quotes";
$db['default']["JOB_INVITATION"]				=	$s_tblPre."job_invitation";
$db['default']["PMB"]							=	$s_tblPre."msg_board";
$db['default']["PMBDETAILS"]					=	$s_tblPre."msg_board_details";
$db['default']["JOB_HISTORY"]					=	$s_tblPre."job_history";
$db['default']["JOB_STATUS_HISTORY"]			=	$s_tblPre."job_status_history";
$db['default']["JOBSACCEPTDENY"]				=	$s_tblPre."job_accept_deny";  // added by mrinmoy on 17-05-2012
$db['default']["JOBSCLOUDSEARCH"]				=	$s_tblPre."job_cloud_search"; // added by mrinmoy on 30-05-2012
/* tables using for jobs */

$db['default']["USREIMAGE"]						=	$s_tblPre."user_image";
$db['default']["BUYERDETAILS"]					=	$s_tblPre."buyer_details";
$db['default']["AUTOMAILRIGHT"]					=	$s_tblPre."user_automail_right";
$db['default']["REFERRER"]						=	$s_tblPre."user_referrer";
$db['default']["JOB_PAYMENT_HISTORY"]			=	$s_tblPre."payment_history";
$db['default']["WAIVER_PAYMENT"]				=	$s_tblPre."waiver_payment";
$db['default']["RADAR"]							=	$s_tblPre."radar";
$db['default']["RADAR_CAT"]						=	$s_tblPre."radar_cat";

$db['default']["TRADESMANDETAILS"]      		=    $s_tblPre."tradesman_details";
$db['default']["TRADESALBUM"]					=	$s_tblPre."tradesman_album";
$db['default']["TRADESMANCAT"]					=	$s_tblPre."tradesman_category"; 
$db['default']["TRADESMAN_PAYMENT_TYPE"]        =    $s_tblPre."tradesman_payment_type";
$db['default']["TRADESMAN_PAYMENT_TIME"]        =    $s_tblPre."tradesman_payment_times";
$db['default']["TRADESMAN_WORKING_DAYS"]      	=    $s_tblPre."tradesman_working_days";
$db['default']["TRADESMAN_WORKING_PLACE"]       =    $s_tblPre."tradesman_working_place";
$db['default']["TRADESMAN_MEMBERSHIP"]          =    $s_tblPre."tradesman_membership";
$db['default']["CONTACTLIST_PAYMENT"]           =    $s_tblPre."contactlist_payment";
$db['default']["TRADESMAN_CONTACTLIST"]         =    $s_tblPre."tradesman_contactlist";
$db['default']["TRADESMANHISTORY"]              =    $s_tblPre."tradesman_action_history";
$db['default']["MEMBERSHIP_BANK_TRANSFER"]      =    $s_tblPre."membership_bank_transfer";

unset($s_tblPre);


/*************end DB TABLE NAMES********************/

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
									  '11'=>'Pending'); // Mrinmoy Mondal on 28 March 2012									  


$db['default']["RADIUS"]   			= range(10, 100, 10); // Mrinmoy
$db['default']["PAGINATION"]   		= array('5'=>'5','10'=>'10','15'=>'15'); // Mrinmoy
$db['default']["PMBSTATUS"]   		= array('0'=>'Pending','1'=>'Approved','2'=>'Rejected'); // Mrinmoy Mondal
$db['default']["FEEDBACKRATING"]   	= array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5'); // Mrinmoy Mondal
$db['default']["TESTIMONIALSTATE"] 	= array('1'=>'Pending','2'=>'Approved','3'=>'Reject'); // Mrinmoy Mondal
$db['default']["USERTYPE"]   		= array('1'=>'Buyer','2'=>'Tradesman','4'=>'General'); // Mrinmoy @used in newsletter 
$db['default']["JOB_MATERIAL"]   	= array('0'=>'Does not matter','1'=>'Yes','2'=>'No'); // mrinmoy
//subscriber
$db['default']["QUOTESTATE"]   		= array('1'=>'Not Awarded','2'=>'Awarded','3'=>'Rejected'); // Mrinmoy Mondal
$db['default']["FINDJOBTYPE"]   	= array('1'=>'Open','3'=>'Assigned','4'=>'Hired'); // Mrinmoy Mondal
$db['default']["MEMBERPLAN"]		= array('1'=>'Trial','2'=>'Free','3'=>'1 Month Premium','4'=>'3 Month Premium'); // Mrinmoy 

$db['default']["SOCIALMEDIA"]		= array('1'=>'Skype ID','2'=>'MSN ID','3'=>'Facebook','4'=>'Gmail');
$db['default']["WORKINGDAYS"]		= array('1'=>'Weekdays','2'=>'Weekend','3'=>'Holidays');

$db['default']["PAYMENTMETHOD"]		= array('1'=>'Cash','2'=>'Credit card','3'=>'Bank wire',4=>'Paypal');



$db['default']["AUTOMAIL_KEY"]= array(  'job_posted'=>'Job Posted Mail',
										'job_approved'=>'Job Approved Mail',
										'job_rejected'=>'Job Rejected Mail',
										'tradesman_placed_quote'=>'Tradesman Placed Quote', 
										'tradesman_post_msg'=>'Tradesman Post Message', 
										'tradesman_completed_job'=>'Tradesman Completed Job',
										
										'tradesman_feedback'	=> 'Tradesman Feedback Mail', // mrinmoy
										'tradesman_interest_in_job'=>'Tradesman Interest In Job', //mrinmoy
										'tradesman_accepted_job_offer'=>'Tradesman Accepted Job Offer', //mrinmoy
										'tradesman_deny_job_offer'=>'Tradesman denied Job Offer',
										'tradesman_edit_quote'=>'Tradesman edit quote',
										
										'job_invitation'=>'Job Invitation from Buyer', 
										'buyer_post_msg'=>'Buyer Post Message', 
										'job_match_criteria'=>'Job Match Your criteria',										 
										'buyer_awarded_job'=>'Buyer Awarded Job',
										'buyer_provided_feedback'=>'Buyer Provided Feedback', 
										'buyer_terminate_job'=>'Buyer terminated Job',
										'buyer_cancell_job'=>'Buyer Cancelled Job',
										'tradesman_radar_jobs'	=> 'Tradesman Radar Jobs Mail', 
										'membership_payment_success'=> 'Tradesman Membership Payment',
										'buyer_reject_quote'=>'Buyer Reject Quote',
										
										'payment_sucess'=>'Payment Success',
										'waiver_payment_sucess'=>'Waiver Payment Success',
										'registration_mail'=>'Registration Mail',
										'forgot_password'=>'Forgot Password',
										'referral_mail'=>'Referral Mail',
										'admin_buyer_terminated_job'=>'For Admin Buyer Terminated Job',
										'admin_buyer_cancel_job'=>'For Admin Buyer Cancelled Job', 
										'forget_password'=>'Forget Password', 
										'contact_us'=>'Contact Us',
										'account_deactivate'=>'Account Deactivate',
										'account_reactivate'=>'Account Reactivate',
										'abuse_report'=>'Abuse Report');  // Mrinmoy

$db['default']["JOB_HISTORY_KEY"]= array('job_created'=>'<span style="color:red;">##USERNAME##</span> has created the Job on <i>##TIME##</i>',
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
										 'job_terminate'=>'##USERNAME## has terminated the Job on ##TIME##',
										 'quote_rejected'=>'##USERNAME## has rejected a quote on ##TIME##'
										 
										 
										);  // Mrinmoy
								


$db['default']["ADMIN_NOTIFICATION_ARRAY"] = array(
							1=>'A job, <span class="notification_title">##VAR1##</span> has been posted by <span class="notification_name">##VAR2##</span> on <span class="notification_date">##VAR3##</span>.',
							2=>'A quote has been placed by <span class="notification_name">##VAR1##</span> on job, <span class="notification_title">##VAR2##</span> on <span class="notification_date">##VAR3##</span>.',
							3=>'A quote of <span class="notification_name">##VAR1##</span> for job, <span class="notification_title">##VAR2##</span> has been accepted on <span class="notification_date">##VAR3##</span>.',
							4=>'<span class="notification_name">##VAR1##</span> has accepted the job, <span class="notification_title">##VAR2##</span> on <span class="notification_date">##VAR3##</span>.',
							5=>'<span class="notification_name">##VAR1##</span> has denied the job, <span class="notification_title">##VAR2##</span> on <span class="notification_date">##VAR3##</span>.',
							6=>'<span class="notification_name">##VAR1##</span> has completed the job, <span class="notification_title">##VAR2##</span> on <span class="notification_date">##VAR3##</span> and asked for feedback.',
							7=>'<span class="notification_name">##VAR1##</span> has accept the job, <span class="notification_title">##VAR2##</span> as complete on <span class="notification_date">##VAR3##</span>.',
							8=>'<span class="notification_name">##VAR1##</span> has denied the job, <span class="notification_title">##VAR2##</span> as complete on <span class="notification_date">##VAR3##</span>.',
							9=>'<span class="notification_name">##VAR1##</span> has terminate the job, <span class="notification_title">##VAR2##</span> on <span class="notification_date">##VAR3##</span>.',
							10=>'A quote of <span class="notification_name">##VAR1##</span> for <span class="notification_title">##VAR2##</span> has been rejected on <span class="notification_date">##VAR3##</span>.'
							);




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

                                
$db['default']['ARR_CATEGORY']      =   array(
                                            'BUYER_FAQ'=>array(
                                                                0=>'About tradesman',
                                                                1=>'General',
                                                                2=>'Posting jobs'),
                                            'TRADESMAN_FAQ'=>array(
                                                                0=>'Doing jobs',
                                                                1=>'Fees',
                                                                2=>'General'),
                                            'HELP'=>array(
                                                                0=>'About tradesman',
                                                                1=>'General',
                                                                2=>'Posting jobs')                                        
                                            );   
											


$db['default']["GSM"]=array(1=>'530',2=>'532',3=>'533',4=>'534',5=>'535',6=>'536',7=>'537',8=>'538',9=>'539',10=>'540',
							11=>'541',12=>'542',13=>'543',14=>'544',15=>'545',16=>'546',17=>'547',18=>'548',19=>'549',20=>'505',
							21=>'506',22=>'507',23=>'551',24=>'552',25=>'553',26=>'554',27=>'555',28=>'556',29=>'557',30=>'558',
							31=>'559'); // Mrinmoy	
							
	
$db['default']["AREACODE"]	= array(1=>'322',2=>'416',3=>'272',4=>'472',5=>'382',6=>'358',7=>'312',8=>'242',9=>'478',10=>'466',
							11=>'256',12=>'266',13=>'378',14=>'488',15=>'458',16=>'228',17=>'426',18=>'434',19=>'374',20=>'248',
							21=>'224',22=>'286',23=>'376',24=>'364',25=>'258',26=>'412',27=>'380',28=>'284',29=>'424',30=>'446',
							31=>'442',32=>'222',33=>'342',34=>'454',35=>'456',36=>'438',37=>'326',38=>'476',39=>'246',40=>'216',
							41=>'212',42=>'232',43=>'344',44=>'370',45=>'338',46=>'474',47=>'366',48=>'352',49=>'318',50=>'288',
							51=>'386',52=>'348',53=>'262',54=>'332',55=>'392',56=>'274',57=>'422',58=>'236',59=>'482',60=>'324',
							61=>'252',62=>'436',63=>'384',64=>'388',65=>'452',66=>'328',67=>'464',68=>'264',69=>'362',70=>'484',
							71=>'368',72=>'346',73=>'414',74=>'486',75=>'282',76=>'356',77=>'462',78=>'428',79=>'276',80=>'432',
							81=>'226',82=>'354',83=>'372');
																	                             
 // Mrinmoy	

/* End of file database.php */
/* Location: ./system/application/config/database.php */

