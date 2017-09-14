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
|	example.com/class/method/id/
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
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

#$route['default_controller']    = 'web_master/home';
$route['default_controller']    = 'home';
//$route['404_override']        = 'web_master/home';
$route['404_override']          = '';

#echo '<pre>';print_r($_SERVER);

# ======== Front-End Routing Rule(s) [Begin] ========  

################ ROUTING FOR REGIONS URL ##################### 
$route['corporate-information/locations']       = 'corporate_information/locations';
$route['corporate-information/our-people/our-brokers/(:num)/([0-9a-zA-Z\-]+)'] = 'home/our_people_details/$1';
$route['corporate-information/our-people']      = 'home/our_people/';
$route['corporate-information/buyer-program']      = 'home/buyer_program/';
$route['corporate-information/get-financing']      = 'home/get_financing/';

$route['ptest/read_data_addback']      = 'ptest/read_data_addback/';
$route['(:any)/business-brokerage/details/(:num)/(:any)']= 'corporate_information/business_details/$1/$2'; // NEW

//$route['(:any)/(:num)/business-brokerage/details-micro-website/(:num)/(:any)']= 'corporate_information/businesses_details_micro_website/$1/$3'; #new for micro wordpress
$route['(:any)/business-brokerage/details-micro-website/(:num)/(:any)']= 'corporate_information/businesses_details_micro_website/$1/$2'; #new for micro wordpress
$route['(:num)/(:any)/view-our-listings/businesses-for-sale']= 'corporate_information/brokerage_listings_micro_website/$1/$2'; #new for micro wordpress
$route['(:num)/view-our-listings/businesses-for-sale']= 'corporate_information/brokerage_listings_micro_website/$1/$2'; #new for micro wordpress

$route['(:any)/view-our-listings/businesses-for-sale']= 'corporate_information/businesses_for_sale/$1';
$route['(:any)/view-our-listings/m-a-listings']       = 'corporate_information/m_a_listings/$1';
$route['(:any)/view-our-listings/commercial-listings']= 'corporate_information/commercial_listings/$1';
$route['(:any)/view-our-listings/machinery-equipment-listings']= 'corporate_information/machinery_listings/$1';
$route['(:any)/view-our-listings/franchise-opportunities']= 'corporate_information/franchise_opportunities/$1';
$route['(:any)/contact-us']                     = 'corporate_information/contact_us/$1';
$route['(:any)/professional-partners']          = 'corporate_information/professional_partners/$1';
$route['(:any)/buyer-search']                   = 'corporate_information/buyer_search/$1';
$route['(:any)/meet-our-team/our-brokers/(:num)/([0-9a-zA-Z\-]+)']= 'corporate_information/our_brokers/$1/$2';
$route['(:any)/meet-our-team/our-murphy-brokers/(:num)/([0-9a-zA-Z\-]+)']= 'corporate_information/our_murphy_brokers/$1/$2';
$route['(:any)/meet-our-team']                  = 'corporate_information/meet_our_team/$1';
$route['(:any)/find-a-region']                  = 'corporate_information/find_a_region/$1';
$route['(:any)/find-local-office']              = 'corporate_information/find_local_office/$1';
$route['(:any)/find-local-office/(:num)']       = 'corporate_information/find_local_office/$1/$2';
$route['(:any)/find-a-local-office']            = 'corporate_information/find_a_local_office/$1';
$route['(:any)/services/buy-a-business']        = 'corporate_information/buy_a_business/$1';
$route['(:any)/services/sell-a-business']       = 'corporate_information/sell_a_business/$1';
################ ROUTING FOR REGIONS URL ##################### 

$route['cms/request-information']                            = 'corporate_information/request_information/request-information';
$route['cms/(:any)']                            = 'cms/index/$1';
$route['cms']                                   = 'cms/index';

$route['corporate-information/news/(:any)']     = 'news/details/$1';
$route['corporate-information/news']            = 'news/index';
  
$route['corporate-information/contact-us']      = 'contactus/index';
$route['corporate-information/faq']             = 'faq/index';
#$route['request-information']          			= 'corporate_information/index/request-information';
$route['request-information']          			= 'corporate_information/request_information/request-information';
$route['corporate-information/request-information']          = 'corporate_information/request_information/request-information';
$route['corporate-information/(:any)']          = 'corporate_information/index/$1';
$route['corporate-information']                 = 'corporate_information/index';

$route['business-valuation-services/(:any)']    = 'business_valuation_services/index/$1';
$route['business-valuation-services']           = 'business_valuation_services/index';

$route['business-consulting/(:any)']            = 'business_consulting/index/$1';
$route['business-consulting']                   = 'business_consulting/index';


$route['business-brokerage/view-our-listings/(:any)']  = 'business_brokerage/view_our_listings/$1';
$route['business-brokerage/view-our-listings']  = 'business_brokerage/view_our_listings';
$route['business-brokerage/details/(:num)/(:any)']= 'business_brokerage/details/$1';
$route['business-brokerage/(:any)']             = 'business_brokerage/index/$1';
$route['business-brokerage']                    = 'business_brokerage/index';

$route['mergers-acquisitions/m-a-listings/(:any)']     = 'mergers_acquisitions/m_a_listings/$1';
$route['mergers-acquisitions/m-a-listings']     = 'mergers_acquisitions/m_a_listings';
$route['mergers-acquisitions/details/(:num)/(:any)']= 'mergers_acquisitions/details/$1';
$route['mergers-acquisitions/(:any)']           = 'mergers_acquisitions/index/$1';
$route['mergers-acquisitions']                  = 'mergers_acquisitions/index';

$route['franchise-sales/franchise-listings/(:any)'] = 'franchise_sales/franchise_listings/$1';
$route['franchise-sales/franchise-listings'] = 'franchise_sales/franchise_listings';
$route['franchise-sales/details/(:num)/(:any)']= 'franchise_sales/details/$1';
$route['franchise-sales/(:any)']                = 'franchise_sales/index/$1';
$route['franchise-sales']                       = 'franchise_sales/index';


$route['machinery-equipment-br-services/machinery-equipment-listings/(:any)']  = 'machinery_equipment_br_services/machinery_equipment_listings/$1';
$route['machinery-equipment-br-services/machinery-equipment-listings']  = 'machinery_equipment_br_services/machinery_equipment_listings';
$route['machinery-equipment-br-services/details/(:num)/(:any)']= 'machinery_equipment_br_services/details/$1';
$route['machinery-equipment-br-services/(:any)']= 'machinery_equipment_br_services/index/$1';
$route['machinery-equipment-br-services']       = 'machinery-machinery_equipment_br_services-br-services/index';


$route['commercial-real-estate/search-commercial-properties/(:any)'] = 'commercial_real_estate/search_commercial_properties/$1';
$route['commercial-real-estate/search-commercial-properties']  = 'commercial_real_estate/search_commercial_properties';
$route['commercial-real-estate/details/(:num)/(:any)']= 'commercial_real_estate/details/$1';
$route['commercial-real-estate/(:any)']         = 'commercial_real_estate/index/$1';
$route['commercial-real-estate']                = 'commercial_real_estate/index';


$route['closed-engagements/item-listings']      =   'closed_engagements/item_listings';

$route['buyers/my-saved-listing']               =   'buyers/my_saved_listing';
$route['buyers/saved-search/([0-9a-zA-Z\-]+)/(asc|desc)'] = 'buyers/saved_search/$1/$2';
$route['buyers/saved-search']                   =   'buyers/saved_search';

$route['graphreport/(:any)'] = "graphreport/index/$1";
$route['graphreport_cm/(:any)'] = "graphreport_cm/index/$1";

//$route['about-us'] = 'aboutus/index';
$route['contact-us'] = 'contactus/index';
$route['buyers-registration'] = 'buyers_registration/index';  
$route['logout'] = 'home/logout'; 
$route['forgot-password'] = 'home/forgot_password'; 
    
    

# ======== Front-End Routing Rule(s) [End] ========



/* End of file routes.php */
/* Location: ./application/config/routes.php */
