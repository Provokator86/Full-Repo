<?php 
require_once('constants.php');
//session_start();
/****************************************************
CallerService.php

This file uses the constants.php to get parameters needed 
to make an API call and calls the server.if you want use your
own credentials, you have to change the constants.php

****************************************************/
class callerservice
{
	private $API_UserName;
	private $API_Password;
	private $API_Signature;
	private $API_Endpoint;
	private $version;
	
	 function __construct()
	 {	 
			$this->API_UserName=API_USERNAME;
			
			
			$this->API_Password=API_PASSWORD;
			
			
			$this->API_Signature=API_SIGNATURE;
			
			
			$this->API_Endpoint =API_ENDPOINT;
			
			
			$this->version=VERSION;
			
			
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
	//declaring of global variables
	//global $API_Endpoint,$version,$API_UserName,$API_Password,$API_Signature,$nvp_Header;
	
	//$CI		= &get_instance();
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

	//NVPRequest for submitting to server
	$nvpreq="METHOD=".urlencode($methodName)."&VERSION=".urlencode($this->version)."&PWD=".urlencode($this->API_Password)."&USER=".urlencode($this->API_UserName)."&SIGNATURE=".urlencode($this->API_Signature).$nvpStr;
	
	//echo $nvpreq;exit;

	//setting the nvpreq as POST FIELD to curl
	curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);

	//getting response from server
	$response = curl_exec($ch);

	//convrting NVPResponse to an Associative Array
	$nvpResArray=$this->deformatNVP($response);
	$nvpReqArray=$this->deformatNVP($nvpreq);
	//$CI->session->set_userdata(array('nvpReqArray'=>$nvpReqArray));
	$_SESSION['nvpReqArray'] = $nvpReqArray;
	if (curl_errno($ch)) {
		// moving to display page to display curl errors
		 // print_r($CI->session->userdata('pay_price'));die();
		  //if(false!=$CI->session->userdata('pay_price'))
		  //{
			  //$CI->session->set_userdata(array('curl_error_no'=>curl_errno($ch)));
			  //$CI->session->set_userdata(array('curl_error_msg'=>curl_error($ch)));
			  //$location = base_url()."user/failure";
			  $_SESSION['curl_error_no'] = curl_errno($ch);
			  $_SESSION['curl_error_msg'] = curl_error($ch);
			  
		 // }
		  //print_r($CI->session->userdata('curl_error_no'));exit;
		  //else
		  //{
		  
		  //}
		  header("Location: $location");
	 } else {
		 //closing the curl
			curl_close($ch);
	  }

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
