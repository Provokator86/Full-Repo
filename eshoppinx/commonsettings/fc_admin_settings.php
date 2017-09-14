<?php 
$config['id'] = '1'; 
$config['site_contact_mail'] = 'kishorela@gmail.com'; 
$config['site_contact_number'] = ''; 
$config['email_title'] = 'eshoppinx'; 
$config['google_verification'] = ''; 
$config['google_verification_code'] = ''; 
$config['facebook_link'] = 'http://www.facebook.com/'; 
$config['twitter_link'] = 'http://twitter.com/'; 
$config['pinterest'] = ''; 
$config['googleplus_link'] = 'http://google.com'; 
$config['linkedin_link'] = ''; 
$config['rss_link'] = ''; 
$config['youtube_link'] = ''; 
//$config['footer_content'] = '&copy;  2013 Rights Reserved'; 
$config['footer_content'] = '&copy Yourwebsitename.com All Right Reserved  Powered by Code UR Idea'; 
$config['logo_image'] = 'logo.png'; 
$config['logo_icon'] = ''; 
$config['meta_title'] = 'eshoppinx'; 
$config['meta_keyword'] = 'eshoppinx'; 
$config['meta_description'] = 'eshoppinx'; 
$config['fevicon_image'] = 'logo.png'; 
$config['facebook_api'] = ''; 
$config['facebook_secret_key'] = ''; 
$config['paypal_api_name'] = ''; 
$config['paypal_api_pw'] = ''; 
$config['paypal_api_key'] = ''; 
$config['authorize_net_key'] = ''; 
$config['paypal_id'] = ''; 
$config['paypal_live'] = ''; 
$config['smtp_port'] = '0'; 
$config['smtp_uname'] = ''; 
$config['smtp_password'] = ''; 
$config['consumer_key'] = ''; 
$config['consumer_secret'] = ''; 
$config['google_client_secret'] = ''; 
$config['google_client_id'] = ''; 
$config['google_redirect_url'] = ''; 
$config['google_developer_key'] = ''; 
$config['facebook_app_id'] = ''; 
$config['facebook_app_secret'] = ''; 
$config['like_text'] = 'Like'; 
$config['unlike_text'] = 'Unlike'; 
$config['liked_text'] = 'Like\'d'; 
$config['logo_icon_option'] = 'no'; 
$config['payment_details'] = ''; 
$config['created'] = '2014-10-23'; 
$config['modified'] = '2014-10-28'; 
$config['admin_name'] = 'adminesh'; 
$config['email'] = 'kishorela@gmail.com'; 
$config['admin_type'] = 'super'; 
$config['privileges'] = ''; 
$config['last_login_date'] = '2014-10-28 02:13:22'; 
$config['last_logout_date'] = '2014-10-23 12:18:00'; 
$config['last_login_ip'] = '115.118.153.47'; 
$config['is_verified'] = 'Yes'; 
$config['status'] = 'Active'; 
//$config['base_url'] = 'http://www.eshoppinx.com/';  
if(SITE_FOR_LIVE)///For live site defined in index.php
{   
    $config['base_url']    =    "http://www.eshoppinx.com/";
}
else
{
    //$config['base_url']    =    "http://192.168.88.107/eshoppinx/";
    $config['base_url']    =    "http://192.168.88.38/eshoppinx/";
    //$config['base_url']    =    "http://localhost/eshoppinx/";
}
?>