<?php
require_once 'constantsDirect.php';
/****************************************************
CallerService.php

This file uses the constants.php to get parameters needed 
to make an API call and calls the server.if you want use your
own credentials, you have to change the constants.php

Called by TransactionDetails.php, ReviewOrder.php, 
DoDirectPaymentReceipt.php and DoExpressCheckoutPayment.php.

****************************************************/
class CallerServiceDirect
{
	public $API_UserName;
	public $API_Password;
	public $API_Signature;
	public $API_Endpoint;
	public $version;
	public $subject;
	
	 function __construct()
	 {	 
			$this->API_UserName=API_USERNAME;			
			
			$this->API_Password=API_PASSWORD;			
			
			$this->API_Signature=API_SIGNATURE;			
			
			$this->API_Endpoint =API_ENDPOINT;
			
			$this->payPalURL	= PAYPAL_URL;			
			
			$this->version=VERSION;
			$this->subject	= SUBJECT;			
	 }	

//session_start();

/**
  * hash_call: Function to perform the API call to PayPal using API signature
  * @methodName is name of API  method.
  * @nvpStr is nvp string.
  * returns an associtive array containing the response from the server.
*/


function hash_call($methodName,$nvpStr)
{
	//$CI	= &get_instance();
	//declaring of global variables
	//global $API_Endpoint,$version,$API_UserName,$API_Password,$API_Signature,$nvp_Header, $subject;

	//setting the curl parameters.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$this->API_Endpoint);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);

	//turning off the server and peer verification(TrustManager Concept).
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POST, 1);
    //if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
   //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php 
	if(USE_PROXY)
	curl_setopt ($ch, CURLOPT_PROXY, PROXY_HOST.":".PROXY_PORT); 

	//check if version is included in $nvpStr else include the version.
	if(strlen(str_replace('VERSION=', '', strtoupper($nvpStr))) == strlen($nvpStr)) {
		$nvpStr = "&VERSION=" . urlencode($this->version) . $nvpStr;	
	}
	
	$nvpreq="METHOD=".urlencode($methodName).$nvpStr;
	
	//setting the nvpreq as POST FIELD to curl
	curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);

	//getting response from server
	$response = curl_exec($ch);

	//convrting NVPResponse to an Associative Array
	$nvpResArray=$this->deformatNVP($response);
	$nvpReqArray=$this->deformatNVP($nvpreq);
	//$CI->session->set_userdata(array('nvpReqArray'=>$nvpReqArray));
	
	$_SESSION['nvpReqArray']=$nvpReqArray;

	if (curl_errno($ch)) {
	
		// moving to display page to display curl errors
		  
		  /*if(false!=$_SESSION['Bid_Price'])
		  {*/
			  $_SESSION['curl_error_no']=curl_errno($ch) ;
			  $_SESSION['curl_error_msg']=curl_error($ch);
			  $location = "purchase-bids-failed.php";
		  /*}
		  else if(false!=$_SESSION['Final_Price'])
		  {
		  	  $_SESSION['curl_error_no1']=curl_errno($ch) ;
			  $_SESSION['curl_error_msg1']=curl_error($ch);
			  $location = "purchase-won-auc-failed.php";
		  }
		  else
		  {
		  
		  }	*/	  		  
		  header("Location: $location");
	 } else {
		 //closing the curl
			curl_close($ch);
	  }
	  
	  //print_r($nvpResArray);exit;

return $nvpResArray;
}

/** This function will take NVPString and convert it to an Associative Array and it will decode the response.
  * It is usefull to search for a particular key and displaying arrays.
  * @nvpstr is NVPString.
  * @nvpArray is Associative Array.
  */

function deformatNVP($nvpstr)
{

	$intial=0;
 	$nvpArray = array();


	while(strlen($nvpstr)){
		//postion of Key
		$keypos= strpos($nvpstr,'=');
		//position of value
		$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);

		/*getting the Key and Value values and storing in a Associative Array*/
		$keyval=substr($nvpstr,$intial,$keypos);
		$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
		//decoding the respose
		$nvpArray[urldecode($keyval)] =urldecode( $valval);
		$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
     }
	return $nvpArray;
}
}
?>
