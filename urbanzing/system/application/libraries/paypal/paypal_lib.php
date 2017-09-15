<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(BASEPATH.'application/libraries/paypal/CallerService.php');
require(BASEPATH.'application/libraries/paypal/CallerServiceDirect.php');
class Paypal_lib
{
    private $returnUrl;
    private $cancelUrl;
    private $messageUrl;
    function  __construct()
    {
        $this->returnUrl    = base_url().'paypal/ReviewOrder.php';
        $this->cancelUrl    = base_url();
        $this->messageUrl   = base_url();
    }

    function card_pay($arr=array())
    {
        $callerservice = new callerservice();
        $paymentType        = 'Sale';
        $firstName          = urlencode($arr['name']);
        $lastName           = '';
        $creditCardType     = urlencode($arr['creditCardType']);
        $creditCardNumber   = urlencode($arr['creditCardNumber']);
        $expDateMonth       = urlencode($arr['expDateMonth']);
        $padDateMonth       = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);// Month must be padded with leading zero
        $expDateYear        = urlencode($arr['expDateYear']);
        $cvv2Number         = urlencode($arr['cvv2Number']);
        $address1           = urlencode($arr['postal_address']);
        $address2           = '';
        $city               = urlencode($arr['city']);
        $state              = urlencode($arr['state']);
        $zip                = '';
        $amount             = $arr['amount'];
        $customercountry    = $arr['currency_code'];
        $currencyCode       = $arr['currency_code'];
/* Construct the request string that will be sent to PayPal.The variable $nvpstr contains all the variables and
 * is a name value pair string with & as a delimiter */
        $nvpstr             = "&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".$padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state&ZIP=$zip&COUNTRYCODE=$customercountry&CURRENCYCODE=$currencyCode";
/* Make the API call to PayPal, using API signature. The API response is stored in an associative array called
 * $resArray */
        $resArray           = $callerservice->hash_call("doDirectPayment",$nvpstr);
        $_SESSION['reshash'] = $resArray;
/* Display the API response back to the browser. If the response from PayPal was a success, display the response
 * parameters. If the response was an error, display the errors received using APIError.php.*/
        $ack                = strtoupper($resArray["ACK"]);
        if($ack=="SUCCESS")
            return true;
        return true;
    }

    private function get_nvpHeader()
    {
        $callerservice = new CallerServiceDirect();
        $getAuthModeFromConstantFile = true;
	$nvpHeader = "";
	if(!$getAuthModeFromConstantFile)
	{
            $AuthMode = "3TOKEN"; //Merchant's API 3-TOKEN Credential is required to make API Call.
            //$AuthMode = "FIRSTPARTY"; //Only merchant Email is required to make EC Calls.
            //$AuthMode = "THIRDPARTY"; //Partner's API Credential and Merchant Email as Subject are required.
	}
	else
	{
            if(!empty($callerservice->API_UserName) && !empty($callerservice->API_Password) && !empty($callerservice->API_Signature) && !empty($callerservice->subject))
                $AuthMode = "THIRDPARTY";
            else if(!empty($callerservice->API_UserName) && !empty($callerservice->API_Password) && !empty($callerservice->API_Signature))
                $AuthMode = "3TOKEN";
            else if(!empty($callerservice->subject))
                $AuthMode = "FIRSTPARTY";
	}
	switch($AuthMode)
        {
            case "3TOKEN" :
                $nvpHeader = "&PWD=".urlencode($callerservice->API_Password)."&USER=".urlencode($callerservice->API_UserName)."&SIGNATURE=".urlencode($callerservice->API_Signature);
                break;
            case "FIRSTPARTY" :
                $nvpHeader = "&SUBJECT=".urlencode($callerservice->subject);
                break;
            case "THIRDPARTY" :
                $nvpHeader = "&PWD=".urlencode($callerservice->API_Password)."&USER=".urlencode($callerservice->API_UserName)."&SIGNATURE=".urlencode($callerservice->API_Signature)."&SUBJECT=".urlencode($callerservice->subject);
            break;
	}
        return $nvpHeader;
    }
	
    function reviewOrder($default_currency='USD',$amt='0')
    {
	$callerservice = new CallerServiceDirect();
	$nvpHeader = $this->get_nvpHeader();
/* The servername and serverport tells PayPal where the buyer should be directed back to after authorizing
 * payment. In this case, its the local webserver that is running this script Using the servername and
 * serverport, the return URL is the first portion of the URL that buyers will return to after authorizing
 * payment*/
       $serverName = $_SERVER['SERVER_NAME'];
       $serverPort = $_SERVER['SERVER_PORT'];
       $url=dirname('http://'.$serverName.':'.$serverPort.$_SERVER['REQUEST_URI']);
       $currencyCodeType=$default_currency;
       $paymentType="Sale";
/*The returnURL is the location where buyers return when a payment has been succesfully authorized. The cancelURL
 * is the location buyers are sent to when they hit the cancel button during authorization of payment during the
 * PayPal flow*/
       $qry_str	= urlencode('currencyCodeType='.$currencyCodeType.'&paymentType='.$paymentType.'&amount='.$amt);
       $returnURL = $this->returnUrl.'?'.$qry_str;
       $cancelURL = $this->cancelUrl;
/* Construct the parameter string that describes the PayPal payment the varialbes were set in the web form, and
 * the resulting string is stored in $nvpstr*/
       $nvpstr="";
/*Setting up the Shipping address details*/
       $nvpstr="&AMT=".(string)$amt."&ReturnUrl=".$returnURL."&CANCELURL=".$cancelURL ."&CURRENCYCODE=".$currencyCodeType."&PAYMENTACTION=".$paymentType;
       $nvpstr = $nvpHeader.$nvpstr;
/* Make the call to PayPal to set the Express Checkout token If the API call succeded, then redirect the buyer to
 * PayPal to begin to authorize payment.  If an error occured, show the resulting errors*/
       $resArray=$callerservice->hash_call("SetExpressCheckout",$nvpstr);
       $_SESSION['reshash'] = $resArray;
       $ack = strtoupper($resArray["ACK"]);
       if($ack=="SUCCESS")
       {
            // Redirect to paypal.com here
            $token = urldecode($resArray["TOKEN"]);
            $payPalURL = $callerservice->payPalURL.$token;
            header("Location: ".$payPalURL);
        }
        else
        {
//Redirecting to APIError.php to display errors.
            $_SESSION['message']    = 'There are some problem at the time of payment.';
            $_SESSION['message_type']    = 'err';
            header('location:'.$this->messageUrl);
            exit();
        }
  }

  function paypal_return()
  {
      $token =urlencode( $_SESSION['paypal_return']['token']);
      if(!$token)
          return false;
      $callerservice = new CallerServiceDirect();
      $nvpHeader = $this->get_nvpHeader();
/* Build a second API request to PayPal, using the token as the ID to get the details on the payment authorization*/
       $nvpstr="&TOKEN=".$token;
       $nvpstr = $nvpHeader.$nvpstr;
/* Make the API call and store the results in an array.  If the	call was a success, show the authorization
 * details, and provide	an action to complete the payment.  If failed, show the error*/
       $resArray=$callerservice->hash_call("GetExpressCheckoutDetails",$nvpstr);
       $_SESSION['reshash']=$resArray;
       $ack = strtoupper($resArray["ACK"]);
       if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING')
       {
            $_SESSION['token']=$_SESSION['paypal_return']['token'];
            $_SESSION['payer_id'] = $_SESSION['paypal_return']['PayerID'];
            $_SESSION['paymentAmount']=$_SESSION['paypal_return']['paymentAmount'];
            $_SESSION['currCodeType']=$_SESSION['paypal_return']['currencyCodeType'];
            $_SESSION['paymentType']=$_SESSION['paypal_return']['paymentType'];
            $_SESSION['pay_price']=$_SESSION['paypal_return']['amount'];
            unset($_SESSION['paypal_return']);
            return $this->final_pay_process();
        }
      else
      {
	return false;
      }
    }

    function final_pay_process()
    {
	$callerservice = new CallerServiceDirect();
	ini_set('session.bug_compat_42',0);
	ini_set('session.bug_compat_warn',0);
/* Gather the information to make the final call to finalize the PayPal payment.  The variable nvpstr holds the
 * name value pairs */
	$token =urlencode($_SESSION['token']);
	$paymentAmount =urlencode ($_SESSION['pay_price']);
	$paymentType = urlencode($_SESSION['paymentType']);
	$currCodeType = urlencode($_SESSION['currCodeType']);
	$payerID = urlencode($_SESSION['payer_id']);
	$serverName = urlencode($_SERVER['SERVER_NAME']);
	$nvpstr='&TOKEN='.$token.'&PAYERID='.$payerID.'&PAYMENTACTION='.$paymentType.'&AMT='.$paymentAmount.'&CURRENCYCODE='.$currCodeType.'&IPADDRESS='.$serverName ;
        $nvpHeader = $this->get_nvpHeader();
        $nvpstr = $nvpHeader.$nvpstr;
 /* Make the call to PayPal to finalize payment If an error occured, show the resulting errors */
        $resArray=$callerservice->hash_call("DoExpressCheckoutPayment",$nvpstr);
        $_SESSION['reshash'] = $resArray;
/* Display the API response back to the browser.If the response from PayPal was a success, display the response
 * parameters' If the response was an error, display the errors received using APIError.php.*/
	$ack = strtoupper($resArray["ACK"]);
	if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING')
            return true;
	return false;
    }
}

?>