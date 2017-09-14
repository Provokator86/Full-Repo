<?php
require_once "./connection.php";
/*
$username 	= "root";
$password 	= "shld123";
$hostname 	= "localhost"; 
$dbname 	= "ams";

//connection to the database  
$con = mysqli_connect($hostname, $username, $password);
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

mysqli_select_db($con, $dbname) or die ("no database");  
*/

//++++++++++++++++++++++++++ START ERROR RELATED FUNCTIONS ++++++++++++++++++++++++++++
// to show xml output
function _success_output($successArr)
{		
	$obj = new stdClass();
	$obj -> ResponseCode	= 200;
	$obj -> ResponseDetail 	= 'Information saved successfully';
	$obj -> batchId 		= $successArr["batchId"];
	$obj -> NoofForms 		= $successArr["no_of_forms"];
	$obj -> totalPayer 		= $successArr["total_payer"];
	$obj -> totalPayee 		= $successArr["total_payee"];
	$obj -> totalCost 		= _price_format($successArr["total_cost"]);
	return $obj;	
}

// to show xml output
function _error_xml_output($ERR=array())
{	
	
	$obj = new stdClass();
	$obj -> ResponseCode	= $ERR[0]['error_code'];
	$obj -> ResponseDetail 	= $ERR[0]['error_msg'];
	//$obj -> batchId 		= 'XXXXXX';
	//$obj -> NoofForms 		= 1;
	//$obj -> totalPayer 		= 1;
	//$obj -> totalPayee 		= 1;
	//$obj -> totalCost 		= 1.25;
	return $obj;
	//return json_decode(json_encode($obj));
	
}

function _success_output_as_obj($successArr) {
	
	$return_obj = array();	
	if( !empty($successArr) ) {
		
		$return_obj['batchId'] = $successArr['batchId'];
		$return_obj['ResponseCode'] = 100;
		$return_obj['ResponseDetail'] = "Information saved successfully";
		$return_obj['NoofForms'] = $successArr['no_of_forms'];
		$return_obj['totalPayer'] = $successArr['total_payer'];
		$return_obj['totalPayee'] = $successArr['total_payee'];		
		$return_obj['totalCost'] = _price_format($successArr['total_cost']);
	}
	
	return $return_obj;
}

function _error_output_as_obj($ERR) {
	
	/*$return_obj = new stdClass();	
	if( !empty($ERR) ) {
		
		$return_obj->ResponseCode = $ERR[0]['error_code'];
		$return_obj->ResponseDetail = $ERR[0]['error_msg'];
	}*/
	
	$return_obj = array();	
	if( !empty($ERR) ) {		
		//$return_obj['batch_id'] = '';
		$return_obj['ResponseCode'] = $ERR[0]['error_code'];
		$return_obj['ResponseDetail'] = $ERR[0]['error_msg'];
		//$return_obj['total_cost'] 	= 0;
	}
	
	return $return_obj;
}

//to format error-codes...
function _format_error_code($number, $leading_digit='0', $places=3) {    
    try {
        $digit = sprintf("%{$leading_digit}{$places}d", $number);
        
        return $digit;
    } catch(Exception $err_obj) {
        show_error($err_obj->getMessage());
    }
}

// ++++++++++++ start payment functions error messgae +++++++++++++++


function _info_forms_payee_payment($where='')
{
	global $con;
	if($where!=='')
	{		
		$tmp = array();
		$sql = "SELECT COUNT(i_payer_id) AS total_payee, s_form_id FROM ams_payee_info {$where} ";
		$result = mysqli_query($con, $sql);	
		
		while ($row = mysqli_fetch_assoc($result)) {
			$tmp[] = $row;
		}			
		return $tmp;
	}
	else
		return FALSE;
}

function _info_price_set_details($i_master_id='')
{
	global $con;
	if($i_master_id)
	{		
		$tmp = array();
		$sql = "SELECT * FROM ams_forms_price_set_details WHERE i_master_id = '".addslashes($i_master_id)."' ";
		$result = mysqli_query($con, $sql);	
		
		while ($row = mysqli_fetch_assoc($result)) {
			$tmp[] = $row;
		}			
		return $tmp;
	}
	else
		return FALSE;
}



function _paymentSuccess_output_as_obj($successArr) {
	$return_obj = array();	
	if( !empty($successArr) ) {
		$return_obj['ResponseCode'] 			= 100;
		$return_obj['ResponseDetail'] 			= "Payment done successfully successfully";
		$return_obj['paidAmount'] 				= $successArr['paidAmount'];
		$return_obj['transactionId'] 			= $successArr['transactionId'];
		$return_obj['transactionCode'] 			= $successArr['transactionCode'];
		$return_obj['transactionDescription']	= $successArr['transactionDescription'];
		$return_obj['customerName']				= $successArr['customerName'];
		$return_obj['customerAddress']			= $successArr['customerAddress'];
		$return_obj['customerCity']				= $successArr['customerCity'];
		$return_obj['customerState']			= $successArr['customerState'];
		$return_obj['customerZip']				= $successArr['customerZip'];
		$return_obj['invoiceNo']				= $successArr['invoiceNo'];
		
		
	}
	
	return $return_obj;
}


function _paymentError_output_as_obj($successArr) {
	
	$return_obj = array();	
	if( !empty($successArr) ) {
		$return_obj['ResponseCode'] 			= $successArr['transactionCode']? _format_error_code($successArr['transactionCode']) :'011';
		$return_obj['ResponseDetail'] 			= $successArr['transactionDescription']? $successArr['transactionDescription'] :"Transactions Failed";
		$return_obj['paidAmount'] 				= $successArr['paidAmount'];
		$return_obj['transactionId'] 			= $successArr['transactionId'];
		$return_obj['transactionCode'] 			= $successArr['transactionCode'];
		$return_obj['transactionDescription']	= $successArr['transactionDescription'];
		
	}
	
	return $return_obj;
}


function _paymentNoResponse_output_as_obj($successArr) {
	
	$return_obj = array();	
	if( !empty($successArr) ) {
		$return_obj['ResponseCode'] 			= '012';
		$return_obj['ResponseDetail'] 			= "No response returned";
		$return_obj['paidAmount'] 				= $successArr['paidAmount'];
		$return_obj['transactionId'] 			= $successArr['transactionId'];
		$return_obj['transactionCode'] 			= $successArr['transactionCode'];
		$return_obj['transactionDescription']	= $successArr['transactionDescription'];
		
	}
	
	return $return_obj;
}


function _alreadyPaid_batchid_error_response($successArr) {
	
	$return_obj = array();	
	if( !empty($successArr) ) {
		$return_obj['ResponseCode'] 			= '013';
		$return_obj['ResponseDetail'] 			= "This batch has been already paid.";
		$return_obj['paidAmount'] 				= $successArr['paidAmount'];
		$return_obj['transactionId'] 			= $successArr['transactionId'];
		$return_obj['transactionCode'] 			= $successArr['transactionCode'];
		$return_obj['transactionDescription']	= $successArr['transactionDescription'];
		
	}
	
	return $return_obj;
}


// ++++++++++++ end payment functions error messgae +++++++++++++++

// ++++++++++++ start transmit functions error messgae +++++++++++++++

//1 function for username or password not provided

function form_no_user_pwd_response() {	
	try {		
		$err_msg = array();
		$err_msg = _chk_no_user_pwd_err_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _chk_no_user_pwd_err_msg() 
{            
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(1);
		$ERR[$arr_index]['error_msg'] = 'Please provide username and password.';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}

//2 : function to trap & report userName/Passsword error...

function form_name_N_pwd_error_response() {	
	try {		
		$err_msg = array();			
		$err_msg = _chk_name_N_pwd_err_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}
  
//// function to check for valid userName/Password...
function _chk_name_N_pwd_err_msg() {	
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(2);
		$ERR[$arr_index]['error_msg'] = 'Invalid username or password';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}

//3: form_company_tag_error_response

function form_company_tag_error_response()
{
	try {		
		$err_msg = array();			
		$err_msg = _chk_company_tag_err_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _chk_company_tag_err_msg() {	
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(3);
		$ERR[$arr_index]['error_msg'] = 'Please provide payer & payee information within Company tag in xml string';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}

//4 form_payerInfo_error_response

function form_payerInfo_error_response()
{
	try {		
		$err_msg = array();			
		$err_msg = _chk_payerInfo_err_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _chk_payerInfo_err_msg() {	
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(4);
		$ERR[$arr_index]['error_msg'] = 'Please provide proper payer information';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}

//5 form_payeeInfo_error_response

function form_payeeInfo_error_response()
{
	try {		
		$err_msg = array();			
		$err_msg = _chk_payeeInfo_err_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _chk_payeeInfo_err_msg() {	
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(5);
		$ERR[$arr_index]['error_msg'] = 'Please provide proper payee information';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}

//6 form_empty_payee_error_response

function form_empty_payee_error_response()
{
	try {		
		$err_msg = array();			
		$err_msg = _chk_empty_payee_err_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _chk_empty_payee_err_msg() {	
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(6);
		$ERR[$arr_index]['error_msg'] = 'No payee information given';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}


// payee info validation for 1099A
function _chk_payer_validation($info=array())
{
	$ret='';
	$full_msg = '';
	if(!empty($info))
	{
		$msg=array();
		if($info['s_payer_tin']==''){
			$msg[] = 'TIN';
		}
		if($info['i_payment_year']==''){
			$msg[] = 'payment year';
		}
		if($info['i_payment_year']!='' && (!preg_match("/^[1-9]\d*$/",$info['i_payment_year']) || strlen($info['i_payment_year'])!=4)){
			$msg[] = 'valid payment year';
		}		
		
		if($info['s_first_payer_name_line']==''){
			$msg[] = 'first payer name line';
		}
		if($info['s_type_of_return']==''){
			$msg[] = 'type of return';
		}
		if($info['s_payer_shipping_address']==''){
			$msg[] = 'payer shipping address';
		}		
		if($info['s_payer_city']==''){
			$msg[] = 'payer city';
		}
		if($info['s_payer_state']==''){
			$msg[] = 'payer state';
		}
		if($info['s_payer_zip_code']==''){
			$msg[] = 'payer zipcode';
		}
		
		if(!empty($msg))
			$full_msg = implode(', ',$msg);
		$name = $info['s_first_payer_name_line'];
		
		$ret = 	$full_msg?$full_msg.' for payer '.$name.' ':"";
	}
	return $ret;
}

//10 form_payee_validation_error_response

function form_payer_validation_error_response($payerValidationErrArr)
{
	$ERR = array();
	$ret_msg='';
	for($i=0; $i< count($payerValidationErrArr); $i++)
	{
		$ret_msg .= $payerValidationErrArr[$i].' & ';
	}
	$ret_msg = trim($ret_msg, ' & ');
	
	$arr_index = 0;		
	$ERR[$arr_index]['error_code'] = _format_error_code(10);
	$ERR[$arr_index]['error_msg'] = $ret_msg?'Error found in '.$ret_msg:"";
	return $ERR;	
}

// payee info validation for 1099A
function _chk_payee_validation($info=array())
{
	$ret='';
	$full_msg = '';
	if(!empty($info))
	{
		$msg=array();
		if($info['s_payee_tin']==''){
			$msg[] = 'TIN';
		}
		if($info['i_payment_year']==''){
			$msg[] = 'payment year';
		}
		if($info['s_first_payee_name_line']=='' && $info['s_last_payee_name_line']==''){
			$msg[] = 'first payee name line';
		}
		if($info['s_first_payee_name_line']!='' && !preg_match("/^[a-zA-Z'-]+$/",$info['s_first_payee_name_line']))
		{
			$msg[] = 'valid payee name line';
		}		
		if($info['s_payee_shipping_address']==''){
			$msg[] = 'payee mailing address';
		}
		if($info['s_payee_city']==''){
			$msg[] = 'payee city';
		}
		if($info['s_payee_state']==''){
			$msg[] = 'payee state';
		}
		if($info['s_payee_zip_code']==''){
			$msg[] = 'payee zipcode';
		}		
		if($info['s_payment_amount1']!='' && !preg_match("/^\d+(?:\.\d{2})?$/",$info['s_payment_amount1']))
		{
			$msg[] = 'valid price in Box1';
		}
		if($info['s_payment_amount2']!='' && !preg_match("/^\d+(?:\.\d{2})?$/",$info['s_payment_amount2']))
		{
			$msg[] = 'valid price in Box2';
		}
		
		if(!empty($msg))
			$full_msg = implode(', ',$msg);
		$name = $info['s_first_payee_name_line'].($info['s_last_payee_name_line']?' '.$info['s_last_payee_name_line']:"");
		
		$ret = 	$full_msg?$full_msg.' for recipient '.$name.' ':"";
	}
	return $ret;
}

//11 form_payee_validation_error_response

function form_payee_validation_error_response($payeeValidationErrArr)
{
	$ERR = array();
	$ret_msg='';
	for($i=0; $i< count($payeeValidationErrArr); $i++)
	{
		$ret_msg .= $payeeValidationErrArr[$i].' & ';
	}
	$ret_msg = trim($ret_msg, ' & ');
	
	$arr_index = 0;		
	$ERR[$arr_index]['error_code'] = _format_error_code(11);
	$ERR[$arr_index]['error_msg'] = $ret_msg?'Error found in '.$ret_msg:"";
	return $ERR;	
}

// ++++++++++++ end transmit functions error messgae +++++++++++++++

//+++++++++++++++++++ start account create user related functions ++++++++++++++++++++++++

//1 function for username or password not provided
function acnt_no_user_pwd_response() {	
	try {		
		$err_msg = array();
		$err_msg = _acnt_no_user_pwd_err_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _acnt_no_user_pwd_err_msg() 
{            
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(1);
		$ERR[$arr_index]['error_msg'] = 'Please provide username and password.';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}

//2 function for password not match
function acnt_pwd_no_match_response() {	
	try {		
		$err_msg = array();
		$err_msg = _acnt_no_match_pwd_err_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}


function acnt_username_invalid_response() {	
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(13);
		$ERR[$arr_index]['error_msg'] = 'Username should be minimum of 6 characters.';		
		return $ERR;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function acnt_password_invalid_response() {	
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(14);
		$ERR[$arr_index]['error_msg'] = 'Password should be minimum of 10 characters containing atleast one upper case, one lower case, and one number.';		
		return $ERR;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _acnt_no_match_pwd_err_msg() 
{            
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(2);
		$ERR[$arr_index]['error_msg'] = 'Password does not match with provided username.';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}

//3 function for data entry failed try again
function acnt_entry_failed_response() {	
	try {		
		$err_msg = array();
		$err_msg = _acnt_entry_failed_err_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _acnt_entry_failed_err_msg() 
{            
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(6);
		$ERR[$arr_index]['error_msg'] = 'Failed to save information ! please try again.';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}


// success object
function _acnt_success_output_as_obj($successArr) {
	$return_obj = array();	
	if( !empty($successArr) ) {
		
		$return_obj['id_user'] = $successArr['id_user'];
		$return_obj['ResponseCode'] = 100;
		$return_obj['ResponseDetail'] = "Information saved successfully";
		$return_obj['fullname'] = $successArr['fullname'];
		$return_obj['email'] = $successArr['email'];
	}
	
	return $return_obj;
}

// error object
function _acnt_error_output_as_obj($ERR) {
	
	$return_obj = array();	
	if( !empty($ERR) ) {	
		$return_obj['ResponseCode'] 	= $ERR[0]['error_code'];
		$return_obj['ResponseDetail'] 	= $ERR[0]['error_msg'];
	}	
	return $return_obj;
}

// ++++++++++++++++++++++++++ end account create user related functions +++++++++++++++

// ++++++++++++++ start password error functions +++++++++++++


function genPassword_old($length = 6)
{    
    $length = 6;
    //$string='123456789ABCDE123456789FGHJKL!#$%&*^MNPQRSTUVWXYZ1234567!#$%&*^89abcdefghijkl123456789mnopqrstuvwxyz!8789789#$%&*^';
    $string='123abc456qrst789abcde456fghijkl123456789mnopq198rstuvwxyz';
    $code = '';
    $i = 0;
    while ($i < $length)
    {
        $code .= substr($string, mt_rand(0, strlen($string)-1), 1);
        $i++;
    }
    return $code;
}

function genPassword($length = 10, $add_dashes = false, $available_sets = 'lud')//luds
{
	$sets = array();
	if(strpos($available_sets, 'l') !== false)
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	if(strpos($available_sets, 'u') !== false)
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	if(strpos($available_sets, 'd') !== false)
		$sets[] = '23456789';
	if(strpos($available_sets, 's') !== false)
		$sets[] = '!@#$%&*?';
	$all = '';
	$password = '';
	foreach($sets as $set)
	{
		$password .= $set[array_rand(str_split($set))];
		$all .= $set;
	}
	$all = str_split($all);
	for($i = 0; $i < $length - count($sets); $i++)
		$password .= $all[array_rand($all)];
	$password = str_shuffle($password);
	if(!$add_dashes)
		return $password;
	$dash_len = floor(sqrt($length));
	$dash_str = '';
	while(strlen($password) > $dash_len)
	{
		$dash_str .= substr($password, 0, $dash_len) . '-';
		$password = substr($password, $dash_len);
	}
	$dash_str .= $password;
	return $dash_str;
}


//1 function for wrong username/userid
function _error_username_failed_response() {	
	try {		
		$err_msg = array();
		$err_msg = _error_username_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _error_username_msg() 
{            
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(1);
		$ERR[$arr_index]['error_msg'] = 'Username does not exist.';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}

//2 function for new password
function _nwpwd_empty_response() {	
	try {		
		$err_msg = array();
		$err_msg = _nwpwd_empty_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _nwpwd_empty_msg() 
{            
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(2);
		$ERR[$arr_index]['error_msg'] = 'Please provide new password.';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}

//3 password validation
function _password_validation_old($password='')
{
	$ret='';
	$full_msg = '';
	if($password!='')
	{
		$msg=array();
		$pattern = '/^[a-z]+([a-z0-9._]*)?[a-z0-9]+$/i';
		$allowed = array(".", "-", "_","*","?","&","%","$","@","!","^");

		//if(!preg_match($pattern, $password) || strlen($password)<6){
		if(!ctype_alnum( str_replace($allowed, '', $password ) ) || strlen($password)<6){
		//if(!preg_match($pattern, $password) || strlen($password)<6){
			$msg[] = 'Provide alphanumeric password with minimum of 6 characters length';
		}	
		
		if(!empty($msg))
			$full_msg = implode(', ',$msg);
		
		$ret = 	$full_msg?$full_msg:"";
	}
	return $ret;
}
function _password_validation($password='')
{
	$ret='';
	$full_msg = '';
	if($password!='')
	{
		$msg=array();
		$pattern = '/^.*(?=.{10,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/';
		$t = false;
		$t = preg_match($pattern,$password);
		if($t == false)
			$full_msg = 'Provide password with minimum of 10 characters containing  atleast one upper case, one lower case, and one number';
		$ret = 	$full_msg?$full_msg:"";
	}
	return $ret;
}

function _password_validation_error_response($msg)
{
	$ERR = array();
	$arr_index = 0;		
	$ERR[$arr_index]['error_code'] = _format_error_code(3);
	$ERR[$arr_index]['error_msg'] = $msg?$msg:"";
	return $ERR;	
}


//4 function for no email
function acnt_no_email_response() {	
	try {		
		$err_msg = array();
		$err_msg = _no_email_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _no_email_msg() 
{            
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(4);
		$ERR[$arr_index]['error_msg'] = 'There is no email for this user';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}

function _pwd_changed_output_as_obj($successArr) {
	$return_obj = array();	
	if( !empty($successArr) ) {
		
		$return_obj['id_user'] = $successArr['id_user'];
		$return_obj['ResponseCode'] = 100;
		$return_obj['ResponseDetail'] = "Password changed successfully";
		$return_obj['fullname'] = $successArr['fullname'];
		//$return_obj['email'] = $successArr['email'];
	}
	
	return $return_obj;
}


function _pwd_new_output_as_obj($successArr) {
	$return_obj = array();	
	if( !empty($successArr) ) {
		
		$return_obj['id_user'] = $successArr['id_user'];
		$return_obj['ResponseCode'] = 100;
		$return_obj['ResponseDetail'] = "New password has been sent to your registered email.";
		$return_obj['fullname'] = $successArr['fullname'];
		$return_obj['email'] = $successArr['email'];
	}
	
	return $return_obj;
}

//4 function for username not provided
function acnt_no_user_response() {	
	try {		
		$err_msg = array();
		$err_msg = _acnt_no_user_err_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _acnt_no_user_err_msg() 
{            
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(4);
		$ERR[$arr_index]['error_msg'] = 'Please provide username.';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}


// ++++++++++++++ end  password error functions +++++++++++++

// ++++++++++++++ start getBatchStatus error functions +++++++++++++

//1 function for empty batch
function _error_batchid_empty_response() {	
	try {		
		$err_msg = array();
		$err_msg = _error_batchid_empty_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _error_batchid_empty_msg() 
{            
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(1);
		$ERR[$arr_index]['error_msg'] = 'Please provide batch id.';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}

//2 function for batch not exist
function _error_batchid_exist_response() {	
	try {		
		$err_msg = array();
		$err_msg = _error_batchid_exist_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _error_batchid_exist_msg() 
{            
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(2);
		$ERR[$arr_index]['error_msg'] = 'This batch id does not exist.';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}

function _batchStatus_history_output_as_obj($successArr) {
	$return_obj = array();	
	if( !empty($successArr) ) {
		
		$return_obj['batchId'] = $successArr['batchid'];
		$return_obj['ResponseCode'] = 100;
		$return_obj['ResponseDetail'] = $successArr['msg'];
	}
	
	return $return_obj;
}



// ++++++++++++++ end getBatchStatus error functions +++++++++++++

// getBatchNumber in a date range errors start

//2 function for username/password not match
function acnt_info_no_match_response() {	
	try {		
		$err_msg = array();
		$err_msg = _acnt_no_match_info_err_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _acnt_no_match_info_err_msg() 
{            
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(2);
		$ERR[$arr_index]['error_msg'] = 'Wrong username and password given.';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}



//3 : function for no date range give...

function _no_daterange_error_response() {	
	try {		
		$err_msg = array();			
		$err_msg = _no_daterange_err_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}
  
function _no_daterange_err_msg() {	
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(3);
		$ERR[$arr_index]['error_msg'] = 'Provide a valid date range in mm/dd/yyyy format';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}

// 4 date format error

function _date_format_error_response() {	
	try {		
		$err_msg = array();			
		$err_msg = _no_dateformat_err_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}
  
function _no_dateformat_err_msg() {	
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(4);
		$ERR[$arr_index]['error_msg'] = 'Provide a valid date range in mm/dd/yyyy format';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}


// date validation
function _validate_Date($mydate,$format = 'MM/DD/YYYY') {

    if ($format == 'YYYY-MM-DD') list($year, $month, $day) = explode('-', $mydate);
    if ($format == 'YYYY/MM/DD') list($year, $month, $day) = explode('/', $mydate);
    if ($format == 'YYYY.MM.DD') list($year, $month, $day) = explode('.', $mydate);

    if ($format == 'DD-MM-YYYY') list($day, $month, $year) = explode('-', $mydate);
    if ($format == 'DD/MM/YYYY') list($day, $month, $year) = explode('/', $mydate);
    if ($format == 'DD.MM.YYYY') list($day, $month, $year) = explode('.', $mydate);

    if ($format == 'MM-DD-YYYY') list($month, $day, $year) = explode('-', $mydate);
    if ($format == 'MM/DD/YYYY') list($month, $day, $year) = explode('/', $mydate);
    if ($format == 'MM.DD.YYYY') list($month, $day, $year) = explode('.', $mydate);       

    if (is_numeric($year) && is_numeric($month) && is_numeric($day))
        return true;
        //return checkdate($month,$day,$year);
    return false;           
}        

// _batchNumbers_output_as_obj

function _batchNumbers_output_as_obj($successArr) {
	$return_obj = array();	
	if( !empty($successArr) ) {
		$return_obj['ResponseCode'] 	= 100;
		$return_obj['ResponseDetail'] 	= "Batch numbers are shown successfully";
		$return_obj['batchNumbers'] 	= $successArr['msg'];
	}
	
	return $return_obj;
}


// getBatchNumber in a date range errors end


// getBatchDetails errors start

//3 function for _no_batchid_error_response
function _no_batchid_error_response() {	
	try {		
		$err_msg = array();
		$err_msg = _no_batchid_info_err_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _no_batchid_info_err_msg() 
{            
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(3);
		$ERR[$arr_index]['error_msg'] = 'Please provide batch id.';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}

//9 function for username/password not match
function _wrong_batchid_error_response() {	
	try {		
		$err_msg = array();
		$err_msg = _wrong_batchid_info_err_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _wrong_batchid_info_err_msg() 
{            
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(9);
		$ERR[$arr_index]['error_msg'] = 'This batch id does not exist.';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
	
}
// 5 _info_batch_details_information
function _info_batch_details_information($batchid)
{
	global $con;
	if($batchid!=='')
	{		
		$tmp = array();
		/*$result = mysqli_query($con, "SELECT n.i_id, n.dt_created, n.i_created_by
									FROM ams_batch_status_history AS n 
									WHERE n.s_batch_id ='".addslashes($batchid)."' ORDER BY dt_created ASC ");	*/
									
		//~ $result2 = mysqli_query($con, "SELECT COUNT(t.i_id) AS totalForms FROM(SELECT s_form_id FROM ams_forms_payer_payee_history 
										//~ WHERE s_batch_code = '".addslashes($batchid)."' GROUP BY n.s_form_id) AS t ");		
		
		
		$result = mysqli_query($con, "SELECT count(n.i_id) AS total_form,n.s_batch_code, n.s_form_id, p.dt_created, bm.d_paid_price, bm.d_updated_price, bm.dt_updated_price,bm.s_dataProcessFor FROM ams_forms_payer_payee_history AS n
										LEFT JOIN ams_batch_status_history AS p ON p.s_batch_id = n.s_batch_code
										LEFT JOIN ams_batch_master AS bm ON bm.s_batch_id = n.s_batch_code
										WHERE n.s_batch_code = '".addslashes($batchid)."' GROUP BY n.s_form_id");	
		
		while ($row = mysqli_fetch_assoc($result)) {
			$tmp[] = $row;
		}
		
		
			
		return $tmp;
	}
	else
		return FALSE;
}


// 6 _info_batch_details_information
function _info_batch_forms_count($batchid)
{
	global $con;
	if($batchid!=='')
	{		
		$tmp = array();		
		
		$result = mysqli_query($con, "SELECT count(i_payer_id) AS total_payee, s_form_id FROM ams_forms_payer_payee_history WHERE s_batch_code = '".addslashes($batchid)."' GROUP BY s_form_id ");		
		
		while ($row = mysqli_fetch_assoc($result)) {
			$tmp[] = $row;
		}			
		return $tmp;
	}
	else
		return FALSE;
}


// _batchDetails_output_as_obj
function _batchDetails_output_as_obj($successArr) {
	$return_obj = array();	
	if( !empty($successArr) ) {
		$return_obj['ResponseCode'] 	= 100;
		$return_obj['ResponseDetail'] 	= "Batch details shown successfully";
		$return_obj['dateSubmitted'] 	= $successArr['dateSubmitted'];
		$return_obj['totalForms'] 		= $successArr['totalForms'];
		$return_obj['totalCost'] 		= $successArr['totalCost'];
		
	}
	
	return $return_obj;
}


// _batchDetails_output_as_obj
function _batchCurrentPrice_output_as_obj($successArr) {
	$return_obj = array();	
	if( !empty($successArr) ) {
		$return_obj['ResponseCode'] 	= 100;
		$return_obj['ResponseDetail'] 	= "Batch current price shown successfully";
		$return_obj['oldCost'] 			= $successArr['oldCost'];
		$return_obj['totalForms'] 		= $successArr['totalForms'];
		$return_obj['newCost'] 			= $successArr['newCost'];
		
	}
	
	return $return_obj;
}



// getPayerRecipientDetails error functions start

//5 function for  not match
function _wrong_error_response() {	
	try {		
		$err_msg = array();
		$err_msg = _wrong_info_err_msg();		
		return $err_msg;		
	}  catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}
}

function _wrong_info_err_msg() 
{            
	try {		
		$ERR = array();
		$arr_index = 0;		
		$ERR[$arr_index]['error_code'] = _format_error_code(5);
		$ERR[$arr_index]['error_msg'] = 'This batch id does not exist.';		
		return $ERR;
		
	} catch(Exception $err_obj) {
		show_error($err_obj->getMessage());
	}	
}

function _info_forms_payer_payee($where='')
{
	global $con;
	if($where!=='')
	{		
		$tmp = array();
		$sql = "SELECT n.i_id,n.s_form_id, n.i_payer_id, n.i_payee_id, n.i_status, f.s_form_title, 
				p.i_id AS payer_id, p.s_payer_tin, p.s_first_payer_name_line, p.s_second_payer_name_line, 
				r.i_id AS payee_id, r.s_payee_tin, r.s_first_payee_name_line, r.s_last_payee_name_line
				FROM ams_forms_payer_payee_history AS n 
				LEFT JOIN ams_forms_master AS f ON n.s_form_id = f.i_id 
				LEFT JOIN ams_payer_info AS p ON n.i_payer_id = p.i_id 
				LEFT JOIN ams_payee_info AS r ON n.i_payee_id = r.i_id 
				{$where} ";
		$result = mysqli_query($con, $sql);	
		
		while ($row = mysqli_fetch_assoc($result)) {
			$tmp[] = $row;
		}			
		return $tmp;
	}
	else
		return FALSE;
}


function _getPayerRecipientDetailsInfo_output_as_obj($successArr) {
	$return_obj = array();	
	if( !empty($successArr) ) {
		$return_obj['ResponseCode'] 	= 100;
		$return_obj['ResponseDetail'] 	= "Batch information displayed successfully.";
		$return_obj['informations'] 	= $successArr["informations"];
		//$return_obj['BatchDetailsResponse'] 	= $successArr["BatchDetailsResponse"];
		
	}	
	return $return_obj;
	
}

// getPayerRecipientDetails error functions end

//++++++++++++++++++++++++++ END ERROR RELATED FUNCTIONS ++++++++++++++++++++++++++++   
// for two decimal format of price
function _price_format($price = '0')
{
	if($price == '') 
		return '0.00';
	else 
		return number_format((float)$price, 2, '.', '');
}

// for salted password...
function get_salted_password($password) {
	global $con;
    //$ci = get_instance();
    #$salt = md5('spicentea_oauth');
    #return sha1($salt.$password);    
    $salt = "_acs#13_";
    return md5(trim($password).$salt);
}

function _info_by_userName_N_passWord($user, $pass)
{
	global $con;
	if($user!='' && $pass!='')
	{
		//$result = mysqli_query($con, "SELECT * FROM oauth_users WHERE s_username ='".addslashes($user)."' AND s_password='".get_salted_password($pass)."' ");
		$result = mysqli_query($con, "SELECT * FROM ams_user WHERE s_user_name ='".addslashes($user)."' AND s_password='".get_salted_password($pass)."' ");
		while ($row = mysqli_fetch_array($result)) {
			return $row;
		}
	}
	else
		return FALSE;
}


function _getUserIdFromUsername($user)
{
	global $con;
	if($user!=='')
	{
		$tmp = array();
		//$result = mysqli_query($con, "SELECT * FROM oauth_users WHERE s_username ='".addslashes($user)."' ");
		$result = mysqli_query($con, "SELECT * FROM ams_user WHERE s_user_name ='".addslashes($user)."' ");
		while ($row = mysqli_fetch_array($result)) {
			$tmp[] = $row;
		}
		return $tmp[0]["i_id"];
	}
	else
		return FALSE;
}

function _info_by_userName_only($user)
{
	global $con;
	if($user!=='')
	{
		//$result = mysqli_query($con, "SELECT * FROM oauth_users WHERE s_username ='".addslashes($user)."' ");
		$result = mysqli_query($con, "SELECT * FROM ams_user WHERE s_user_name ='".addslashes($user)."' ");
		while ($row = mysqli_fetch_array($result)) {
			return $row;
		}
	}
	else
		return FALSE;
}

function _info_by_userID_only($user)
{
	global $con;
	if($user!=='')
	{
		//$result = mysqli_query($con, "SELECT * FROM oauth_users WHERE s_username ='".addslashes($user)."' ");
		$result = mysqli_query($con, "SELECT * FROM ams_user WHERE i_id ='".addslashes($user)."' ");
		$tmp = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$tmp[] = $row;
		}
			return $tmp[0];
	}
	else
		return FALSE;
}



function _info_by_batchid_only($batchid)
{
	global $con;
	if($batchid!=='')
	{		
		$result = mysqli_query($con, "SELECT * FROM ams_batch_master WHERE s_batch_id ='".addslashes($batchid)."' ");
		while ($row = mysqli_fetch_array($result)) {
			return $row;
		}
	}
	else
		return FALSE;
}
// Added by SWI Dev on 6 June 2017
//https://shieldwatch.teamwork.com/#messages/679965
function _get_batch_status_number($txt = '')
{
	if(trim($txt) == '') return '000';
	$status_number = array(
		'created' => '101',
		'Invoice Pending'  => '101',
		'Invoice Paid'  => '102',
		'Batch Queued'  => '103',
		'Filing Accepted'  => '104',
		'Filing Complete'  => '105',
		'Filing Queued'  => '106',
		'Filing Rejected' => '107',
	);
	return $status_number[$txt];
}

function _info_batch_status_history($batchid)
{
	global $con;
	if($batchid!=='')
	{		
		$result = mysqli_query($con, "SELECT * FROM ams_batch_status_history WHERE s_batch_id ='".addslashes($batchid)."' ORDER BY dt_created ASC ");		
		$tmp = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$tmp[] = $row;
		}
		return $tmp;
	}
	else
		return FALSE;
}


// get all the batch info
function _info_batch_created($where)
{
	global $con;
	if($where!=='')
	{		
		$result = mysqli_query($con, "SELECT * FROM ams_batch_master WHERE {$where} ORDER BY dt_created ASC ");		
		$tmp = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$tmp[] = $row;
		}
		return $tmp;
	}
	else
		return FALSE;
}

// check a batch is already paid or not
function _chk_payment_history($batchid)
{
	global $con;
	if($batchid!=='')
	{		
		$result = mysqli_query($con, "SELECT * FROM ams_payment_history WHERE s_batch ='".addslashes($batchid)."' AND i_status=1 ");		
		$tmp = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$tmp[] = $row;
		}
		return $tmp;
	}
	else
		return FALSE;
}



// generate next batch number 16Nov, 2016 see@ https://shieldwatch.teamwork.com/messages/575669?scrollTo=pmp1660076
function _getLastBatchNumber() 
{			
	$code = '';
	global $con;	
	$start_batch='';
	$result = mysqli_query($con, "SELECT i_starting_batch_no FROM ams_admin_site_settings");	
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$start_batch = $row['i_starting_batch_no'];
	}
	if($start_batch)
	{
		$i_exist = 0;
		$result2 = mysqli_query($con, "SELECT * FROM ams_batch_master WHERE s_batch_id='".addslashes($start_batch)."' ");
		while ($row2 = mysqli_fetch_array($result2)) {
			$i_exist =  $row2['i_id'];
		}
		if($i_exist > 0)
		{
			$result3 = mysqli_query($con, "SELECT * FROM ams_batch_master ORDER BY i_id DESC LIMIT 0,1");
			while ($row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
				$batch 	= $row3['s_batch_id'];
				$numStr	= str_replace('BATCH-', '', $batch);
				$new 	= $numStr +1;
				$code 	= $new;
			}
		}
		else
			$code = $start_batch;
	}
	return $code;
}



// generate next batch number
function genBatchNumber() 
{			
	$code = '';
	global $con;
	//$result = mysql_query("SELECT * FROM ams_batch_master");
	$result = mysqli_query($con, "SELECT * FROM ams_batch_master");
	//fetch tha data from the database 
	//if (mysql_num_rows($result)==0)
	if (mysqli_num_rows($result)==0)
	{
		$num_batch = '1000000001';
		#$code = 'BATCH-'.'1000000001';
		$code = '1000000001';
	}
	else
	{
		//while ($row = mysql_fetch_array($result)) {
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			//echo "ID:".$row{'id'}." Name:".$row{'model'}."Year: ". //display the results
			//$row{'year'}."<br>";
			$batch = $row['s_batch_id'];
			$numStr = str_replace('BATCH-', '', $batch);

			$new = $numStr +1;
			//$code = 'BATCH-'.$new;
			$code = $new;
		}
	}
	return $code;
}

// insert records
function mysql_insert_array($table, $data, $exclude = array()) {
	global $con;
    $fields = $values = array();
    if( !is_array($exclude) ) $exclude = array($exclude);
    foreach( array_keys($data) as $key ) {
        if( !in_array($key, $exclude) ) {
            $fields[] = "`$key`";
            //$values[] = "'" . mysql_real_escape_string($data[$key]) . "'";
            $values[] = "'" . mysqli_real_escape_string($con, $data[$key]) . "'";
        }
    }
    $fields = implode(",", $fields);
    $values = implode(",", $values);
    //~ if( mysql_query("INSERT INTO `$table` ($fields) VALUES ($values)") ) {
        //~ return array( "mysql_error" => false,
                      //~ "mysql_insert_id" => mysql_insert_id(),
                      //~ "mysql_affected_rows" => mysql_affected_rows(),
                      //~ "mysql_info" => mysql_info()
                    //~ );
    //~ } else {
        //~ return array( "mysql_error" => mysql_error() );
    //~ }
    //mysqli_query($con, 'SET sql_mode = ""');
    mysqli_query($con, "SET SESSION sql_mode = ''");
    if( mysqli_query($con, "INSERT INTO `$table` ($fields) VALUES ($values)") ) {
        return array( "mysql_error" => false,
                      "mysql_insert_id" => mysqli_insert_id($con),
                      "mysql_affected_rows" => mysqli_affected_rows($con),
                      "mysql_info" => mysqli_info($con)
                    );
    } else {
        return array( "mysql_error" => mysqli_error($con) );
    }
}

function mysql_exc_qry($qry) {
	global $con;
    
    mysqli_query($con, "SET SESSION sql_mode = ''");
    if( mysqli_query($con, $qry) ) {
		
        return array( "mysql_error" => false,
                      "mysql_insert_id" => mysqli_insert_id($con),
                      "mysql_affected_rows" => mysqli_affected_rows($con),
                      "mysql_info" => mysqli_info($con)
                    );
    } else {
        return array( "mysql_error" => mysqli_error($con) );
    }
}

// update records
function mysql_update_array($table, $data, $s_cond='', $exclude = array()) {
	global $con;
    $fields = $values = array();
    $valStr = '';
    if( !is_array($exclude) ) $exclude = array($exclude);
    foreach( array_keys($data) as $key ) {
        if( !in_array($key, $exclude) ) {
            $fields[] = "`$key`";
            $values[] = "'" . mysqli_real_escape_string($con, $data[$key]) . "'";
            
            $valStr .= " {$key} = '".mysqli_real_escape_string($con, $data[$key])."',";
        }
    }
    
    $valStr = trim(",", $valStr);
    return $valStr;
    if( mysqli_query($con, "UPDATE `$table` SET  {$valStr} WHERE {$s_cond} ") ) {
		
        return array( "mysql_error" => false,
                      "mysql_insert_id" => mysqli_insert_id($con),
                      "mysql_affected_rows" => mysqli_affected_rows($con),
                      "mysql_info" => mysqli_info($con)
                    );
    } else {
        return array( "mysql_error" => mysqli_error($con) );
    }
}

// delete records
function mysql_delete_array($table, $cond='')
{
	global $con;
	mysqli_query($con, "SET SESSION sql_mode = ''");
	if( mysqli_query($con, "DELETE FROM `$table` WHERE($cond) ") ) {
        return array( "mysql_error" => false,
                      "mysql_insert_id" => mysqli_insert_id($con),
                      "mysql_affected_rows" => mysqli_affected_rows($con),
                      "mysql_info" => mysqli_info($con)
                    );
    } else {
        return array( "mysql_error" => mysqli_error($con) );
    }
}

// get the form id	
/*
function getFormId($typeOfTIN='') 
{	
	global $con;
	//$CI = & get_instance();
	if($typeOfTIN)
	{
		$result = mysqli_query($con, "SELECT * FROM ams_forms_master WHERE s_type_of_return ='".addslashes($typeOfTIN)."' ");
		while ($row = mysqli_fetch_array($result)) {
			return $row{'i_id'};
		}
	}
	else
		return FALSE;
	
}
*/

function getFormId($FormType='') 
{	
	global $con;
	//$CI = & get_instance();
	if($FormType)
	{
		$result = mysqli_query($con, "SELECT * FROM ams_forms_master WHERE s_form_title ='".addslashes($FormType)."' ");
		while ($row = mysqli_fetch_array($result)) {
			return $row{'i_id'};
		}
	}
	else
		return FALSE;
	
}

// Form Price
function getFormPrice($FormType='') 
{	
	global $con;
	//$CI = & get_instance();
	if($FormType)
	{
		$result = mysqli_query($con, "SELECT d_form_price FROM ams_forms_master WHERE s_form_title ='".addslashes($FormType)."' ");
		while ($row = mysqli_fetch_array($result)) {
			return $row{'d_form_price'};
		}
	}
	else
		return FALSE;
	
}

function _price_batch_details($batchid)
{
	global $con;
	$totalPrice = 0;
	if($batchid!=='')
	{		
		$tmp = array();		
		$result = mysqli_query($con, "SELECT s_form_id, COUNT(i_payee_id) AS tot_payee FROM ams_forms_payer_payee_history WHERE s_batch_code = '".addslashes($batchid)."' GROUP BY s_form_id");	
		
		while ($row = mysqli_fetch_assoc($result)) {
			//$tmp[] = $row;
			$form_price = 0;
			$form_price = getMultiFormPrice($row{"s_form_id"}, $row{"tot_payee"});
			
			$totalPrice = $totalPrice + $form_price;
		}
			
	}
	
	return $totalPrice;
}


// function for price format
function _priceFormat($price=0)
{
	global $con;
	//$totalPrice = 0;
	return number_format((float)$price, 2, '.', '');
}


// Get forms Price for a batch
function _calculateBatchPrice($batchid)
{
	global $con;
	$tot_price = 0;
	
	if($batchid!=='')
	{		
		$tmp = array();		
		$result = mysqli_query($con, "SELECT COUNT(s_form_type) AS total, s_form_type FROM ams_payer_info WHERE s_batch_code = '".addslashes($batchid)."' GROUP BY  s_form_type;");	
		
		while ($row = mysqli_fetch_assoc($result)) {
			
			$FormId = $row["s_form_type"]; $tot_cnt = $row["total"];			
			
			if($FormId<=16) // for 1099 category
			{
				$price_set_details = _info_price_set_details(1);
				$tot_rec = count($price_set_details); 
				for($j=0; $j < $tot_rec; $j++)
				{				
					if($tot_cnt>= $price_set_details[$tot_rec-1]['i_start'] && !$price_set_details[$tot_rec-1]['i_end']) // max
					{
						//$tot_price = $tot_price + $price_set_details[$tot_rec-1]['d_price'];
						$tot_price = $tot_price + ($price_set_details[$tot_rec-1]['d_price']*$tot_cnt);
						break;
					}
					else
					{
						if($tot_cnt>= $price_set_details[$j]['i_start'] && $tot_cnt<= $price_set_details[$j]['i_end'])
						{
							//$tot_price = $tot_price + $price_set_details[$j]['d_price'];	
							$tot_price = $tot_price + ($price_set_details[$j]['d_price']*$tot_cnt);
							break;
						}
					}
				}
			}
				
			// for W2 form series
			if($FormId<=27 && $FormId>=25) // for W2 category
			{
				$price_set_details = _info_price_set_details(2);
				$tot_rec = count($price_set_details); 
				for($j=0; $j < $tot_rec; $j++)
				{
					if($tot_cnt>= $price_set_details[$tot_rec-1]['i_start'] && !$price_set_details[$tot_rec-1]['i_end']) // max
					{
						//$tot_price = $tot_price + $price_set_details[$tot_rec-1]['d_price'];						
						$tot_price = $tot_price + ($price_set_details[$tot_rec-1]['d_price']*$tot_cnt);
						break;
					}
					else
					{
						if($tot_cnt>= $price_set_details[$j]['i_start'] && $tot_cnt<= $price_set_details[$j]['i_end'])
						{
							//$tot_price = $tot_price + $price_set_details[$j]['d_price'];										
							$tot_price = $tot_price + ($price_set_details[$j]['d_price']*$tot_cnt);
							break;
						}
					}
				}
			}
			
			// for 941 form series
			if($FormId<=30 && $FormId>=28) // for 941 category
			{
				$price_set_details = _info_price_set_details(3);
				$tot_rec = count($price_set_details); 
				for($j=0; $j < $tot_rec; $j++)
				{
					if($tot_cnt>= $price_set_details[$tot_rec-1]['i_start'] && !$price_set_details[$tot_rec-1]['i_end']) // max
					{
						//$tot_price = $tot_price + $price_set_details[$tot_rec-1]['d_price'];
						$tot_price = $tot_price + ($price_set_details[$tot_rec-1]['d_price']*$tot_cnt);
						break;
					}
					else
					{
						if($tot_cnt>= $price_set_details[$j]['i_start'] && $tot_cnt<= $price_set_details[$j]['i_end'])
						{
							//$tot_price = $tot_price + $price_set_details[$j]['d_price'];										
							$tot_price = $tot_price + ($price_set_details[$j]['d_price']*$tot_cnt);
							break;
						}
					}
				}
			}
			
			// end form price calculation

		}
			
	}
	
	return $tot_price;
}


// function to get old submitted forms count for different types 
function _getTotalFormsDetails($userid='', $i_filling_type=1)
{
	global $con;
	$ret = array();
	
	if($userid!=='')
	{		
		$tmp = array();		
		$result = mysqli_query($con, "SELECT SUM(i_forms_no) AS tot_forms,  s_form_type FROM ams_user_forms_paid_count WHERE i_user_id = '".addslashes($userid)."' AND i_filling_type = '".addslashes($i_filling_type)."' AND i_status=1 GROUP BY  s_form_type;");	
		
		while ($row = mysqli_fetch_assoc($result)) {
			$tmp[$row['s_form_type']] = $row['tot_forms'];
			// end form price calculation
		}		
		$ret = $tmp;			
	}
	
	return $ret;
}

// Form Price @param ana array with key as Form id and val as no of that type forms, i_user_id, i_filling_type
// e.g. array('1099A'=>3, '1099B'=>2, '940'=>'C'); //where 1099A will be replaced by the PK of 1099A
function _newCalculateFormPrice($FormArr=array(), $i_user_id='', $i_filling_type=1) 
{
	global $con;
	//$CI = & get_instance();
	$tot_price = 0;
	if(!empty($FormArr))
	{
		$formDetails = _getTotalFormsDetails($i_user_id, $i_filling_type);
		//print_r($formDetails);
		foreach($FormArr as $key => $val)		
		{
			$FormId = $key; $tot_cnt = $val;
			
			if($FormId<=16) // for 1099 category
			{
				// get total count from above line 1849
				$tot_form_cnt = $formDetails[1] ? $formDetails[1] : $val;				
			
				$price_set_details = _info_price_set_details(1);
				$tot_rec = count($price_set_details); 
				for($j=0; $j < $tot_rec; $j++)
				{				
					if($tot_form_cnt>= $price_set_details[$tot_rec-1]['i_start'] && !$price_set_details[$tot_rec-1]['i_end']) // max
					{
						//$tot_price = $tot_price + $price_set_details[$tot_rec-1]['d_price'];
						$tot_price = $tot_price + ($price_set_details[$tot_rec-1]['d_price']*$tot_cnt);
						break;
					}
					else
					{
						if($tot_form_cnt>= $price_set_details[$j]['i_start'] && $tot_form_cnt<= $price_set_details[$j]['i_end'])
						{
							//echo '<br>111--price=='.$price_set_details[$j]['d_price'].'=='.$tot_cnt;
							//$tot_price = $tot_price + $price_set_details[$j]['d_price'];	
							$tot_price = $tot_price + ($price_set_details[$j]['d_price']*$tot_cnt);
							break;
						}
					}
				}
			}
				
			// for W2 form series
			if($FormId<=27 && $FormId>=25) // for W2 category
			{
				// get total count from above line 1849
				$tot_form_cnt = $formDetails[2] ? $formDetails[2] : $val;
				
				$price_set_details = _info_price_set_details(2);
				$tot_rec = count($price_set_details); 
				for($j=0; $j < $tot_rec; $j++)
				{
					if($tot_form_cnt>= $price_set_details[$tot_rec-1]['i_start'] && !$price_set_details[$tot_rec-1]['i_end']) // max
					{
						//$tot_price = $tot_price + $price_set_details[$tot_rec-1]['d_price'];						
						$tot_price = $tot_price + ($price_set_details[$tot_rec-1]['d_price']*$tot_cnt);
						break;
					}
					else
					{
						if($tot_form_cnt>= $price_set_details[$j]['i_start'] && $tot_form_cnt<= $price_set_details[$j]['i_end'])
						{
							//echo '<br>222--price=='.$price_set_details[$j]['d_price'].'=='.$tot_cnt;
							//$tot_price = $tot_price + $price_set_details[$j]['d_price'];										
							$tot_price = $tot_price + ($price_set_details[$j]['d_price']*$tot_cnt);
							break;
						}
					}
				}
			}
			
			// for 941 form series
			if($FormId<=30 && $FormId>=28) // for 941 category
			{
				// get total count from above line 1849
				$tot_form_cnt = $formDetails[3] ? $formDetails[3] : $val;
				
				$price_set_details = _info_price_set_details(3);
				$tot_rec = count($price_set_details); 
				for($j=0; $j < $tot_rec; $j++)
				{
					if($tot_form_cnt>= $price_set_details[$tot_rec-1]['i_start'] && !$price_set_details[$tot_rec-1]['i_end']) // max
					{
						//$tot_price = $tot_price + $price_set_details[$tot_rec-1]['d_price'];
						$tot_price = $tot_price + ($price_set_details[$tot_rec-1]['d_price']*$tot_cnt);
						break;
					}
					else
					{
						if($tot_form_cnt>= $price_set_details[$j]['i_start'] && $tot_form_cnt<= $price_set_details[$j]['i_end'])
						{
							//$tot_price = $tot_price + $price_set_details[$j]['d_price'];										
							$tot_price = $tot_price + ($price_set_details[$j]['d_price']*$tot_cnt);
							break;
						}
					}
				}
			}
			
			// end form price calculation

		}
	}
	return $tot_price;
}




?>
