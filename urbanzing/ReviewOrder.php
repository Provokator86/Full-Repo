<?php
session_start();
$rootdir = dirname(__FILE__).'/../';

require_once $rootdir.'system/application/libraries/CallerService111.php';


/********************************************
ReviewOrder.php

This file is called after the user clicks on a button during
the checkout process to use PayPal's Express Checkout. The
user logs in to their PayPal account.

This file is called twice.

On the first pass, the code executes the if statement:

if (! isset ($token))

The code collects transaction parameters from the form
displayed by SetExpressCheckout.html then constructs and
sends a SetExpressCheckout request string to the PayPal
server. The paymentType variable becomes the PAYMENTACTION
parameter of the request string. The RETURNURL parameter
is set to this file; this is how ReviewOrder.php is called
twice.

On the second pass, the code executes the else statement.

On the first pass, the buyer completed the authorization in
their PayPal account; now the code gets the payer details
by sending a GetExpressCheckoutDetails request to the PayPal
server. Then the code calls GetExpressCheckoutDetails.php.

Note: Be sure to check the value of PAYPAL_URL. The buyer is
sent to this URL to authorize payment with their PayPal
account. For testing purposes, this should be set to the
PayPal sandbox.

Called by SetExpressCheckout.html.

Calls GetExpressCheckoutDetails.php, CallerService.php,
and APIError.php.

********************************************/
echo 1;
header("Location: abc.php");

$callerservice = new CallerService111();

//+++++++++++++++++++++++++++++++++++
$currencyID = urlencode("USD");	
//+++++++++++++++++++++++++++++++++++
/* An express checkout transaction starts with a token, that
   identifies to PayPal your transaction
   In this example, when the script sees a token, the script
   knows that the buyer has already authorized payment through
   paypal.  If no token was found, the action is to send the buyer
   to PayPal to first authorize payment
   */
var_dump($_REQUEST);die();
$token = $_REQUEST['token'];

$getAuthModeFromConstantFile = true;
//$getAuthModeFromConstantFile = false;
$nvpHeader = "";

if(!$getAuthModeFromConstantFile) {
	//$AuthMode = "3TOKEN"; //Merchant's API 3-TOKEN Credential is required to make API Call.
	//$AuthMode = "FIRSTPARTY"; //Only merchant Email is required to make EC Calls.
	$AuthMode = "THIRDPARTY"; //Partner's API Credential and Merchant Email as Subject are required.
} else {
	if(!empty($callerservice->API_UserName) && !empty($callerservice->API_Password) && !empty($callerservice->API_Signature) && !empty($callerservice->subject)) {
		$AuthMode = "THIRDPARTY";
	}else if(!empty($callerservice->API_UserName) && !empty($callerservice->API_Password) && !empty($callerservice->API_Signature)) {
		$AuthMode = "3TOKEN";
	}else if(!empty($callerservice->subject)) {
		$AuthMode = "FIRSTPARTY";
	}
}
switch($AuthMode) {
	
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

if(! isset($token)) {

		/* The servername and serverport tells PayPal where the buyer
		   should be directed back to after authorizing payment.
		   In this case, its the local webserver that is running this script
		   Using the servername and serverport, the return URL is the first
		   portion of the URL that buyers will return to after authorizing payment
		   */
		   $serverName = $_SERVER['SERVER_NAME'];
		   $serverPort = $_SERVER['SERVER_PORT'];
		   $url=dirname('http://'.$serverName.':'.$serverPort.$_SERVER['REQUEST_URI']);


		   $currencyCodeType='USD';//$_REQUEST['currencyCodeType'];
		   $paymentType="Sale";
   

           /*$personName        = $_REQUEST['PERSONNAME'];
		   $SHIPTOSTREET      = $_REQUEST['SHIPTOSTREET'];
		   $SHIPTOCITY        = $_REQUEST['SHIPTOCITY'];
		   $SHIPTOSTATE	      = $_REQUEST['SHIPTOSTATE'];
		   $SHIPTOCOUNTRYCODE = $_REQUEST['SHIPTOCOUNTRYCODE'];
		   $SHIPTOZIP         = $_REQUEST['SHIPTOZIP'];
		   $L_NAME0           = $_REQUEST['L_NAME0'];
		   $L_AMT0            = $_REQUEST['L_AMT0'];
		   $L_QTY0            =	$_REQUEST['L_QTY0'];
		   $L_NAME1           =	$_REQUEST['L_NAME1'];
		   $L_AMT1            = $_REQUEST['L_AMT1'];
		   $L_QTY1            =	$_REQUEST['L_QTY1'];*/



		 /* The returnURL is the location where buyers return when a
			payment has been succesfully authorized.
			The cancelURL is the location buyers are sent to when they hit the
			cancel button during authorization of payment during the PayPal flow
			*/

		   $amt = 0.01;//$_SESSION['pay_price'];
		   
		   $returnURL =urlencode('paypal/ReviewOrder.php?currencyCodeType='.$currencyCodeType.'&paymentType='.$paymentType.'&amount='.$amt);
		   //$cancelURL =urlencode("$url/SetExpressCheckout.php?paymentType=$paymentType" );
		   
		   $cancelURL =urlencode("../user/registration");
		 
		 /* Construct the parameter string that describes the PayPal payment
			the varialbes were set in the web form, and the resulting string
			is stored in $nvpstr
			*/
           //$itemamt = 0.00;
           //$itemamt = //$L_QTY0*$L_AMT0+$L_AMT1*$L_QTY1;
           //$amt = $_REQUEST['amount'];//5.00+2.00+1.00+$itemamt;
           //$maxamt= $amt+25.00;
           $nvpstr="";
		   
           /*
            * Setting up the Shipping address details
            */
           //$shiptoAddress = "&SHIPTONAME=$personName&SHIPTOSTREET=$SHIPTOSTREET&SHIPTOCITY=$SHIPTOCITY&SHIPTOSTATE=$SHIPTOSTATE&SHIPTOCOUNTRYCODE=$SHIPTOCOUNTRYCODE&SHIPTOZIP=$SHIPTOZIP";
           
           //$nvpstr="&ADDRESSOVERRIDE=1$shiptoAddress&L_NAME0=".$L_NAME0."&L_NAME1=".$L_NAME1."&L_AMT0=".$L_AMT0."&L_AMT1=".$L_AMT1."&L_QTY0=".$L_QTY0."&L_QTY1=".$L_QTY1."&MAXAMT=".(string)$maxamt."&AMT=".(string)$amt."&ITEMAMT=".(string)$itemamt."&CALLBACKTIMEOUT=4&L_SHIPPINGOPTIONAMOUNT1=8.00&L_SHIPPINGOPTIONlABEL1=UPS Next Day Air&L_SHIPPINGOPTIONNAME1=UPS Air&L_SHIPPINGOPTIONISDEFAULT1=true&L_SHIPPINGOPTIONAMOUNT0=3.00&L_SHIPPINGOPTIONLABEL0=UPS Ground 7 Days&L_SHIPPINGOPTIONNAME0=Ground&L_SHIPPINGOPTIONISDEFAULT0=false&INSURANCEAMT=1.00&INSURANCEOPTIONOFFERED=true&CALLBACK=https://www.ppcallback.com/callback.pl&SHIPPINGAMT=8.00&SHIPDISCAMT=-3.00&TAXAMT=2.00&L_NUMBER0=1000&L_DESC0=Size: 8.8-oz&L_NUMBER1=10001&L_DESC1=Size: Two 24-piece boxes&L_ITEMWEIGHTVALUE1=0.5&L_ITEMWEIGHTUNIT1=lbs&ReturnUrl=".$returnURL."&CANCELURL=".$cancelURL ."&CURRENCYCODE=".$currencyCodeType."&PAYMENTACTION=".$paymentType;
		   
		   $nvpstr="&AMT=".(string)$amt."&ReturnUrl=".$returnURL."&CANCELURL=".$cancelURL ."&CURRENCYCODE=".$currencyCodeType."&PAYMENTACTION=".$paymentType;
		   
           $nvpstr = $nvpHeader.$nvpstr;
           
		 	/* Make the call to PayPal to set the Express Checkout token
			If the API call succeded, then redirect the buyer to PayPal
			to begin to authorize payment.  If an error occured, show the
			resulting errors
			*/
		   $resArray=$callerservice->hash_call("SetExpressCheckout",$nvpstr);
		   $_SESSION['reshash']=$resArray;
		   
		  $ack = strtoupper($resArray["ACK"]);

		   if($ack=="SUCCESS"){
					// Redirect to paypal.com here
					$token = urldecode($resArray["TOKEN"]);
					$payPalURL = $callerservice->payPalURL.$token;
					header("Location: ".$payPalURL);
				  } else  {
					 //Redirecting to APIError.php to display errors.
						$location = "../user/registration";;
						header("Location: $location");
					}
} else {
		 /* At this point, the buyer has completed in authorizing payment
			at PayPal.  The script will now call PayPal with the details
			of the authorization, incuding any shipping information of the
			buyer.  Remember, the authorization is not a completed transaction
			at this state - the buyer still needs an additional step to finalize
			the transaction
			*/

		   $token =urlencode( $_REQUEST['token']);

		 /* Build a second API request to PayPal, using the token as the
			ID to get the details on the payment authorization
			*/
		   $nvpstr="&TOKEN=".$token;

		   $nvpstr = $nvpHeader.$nvpstr;
		 /* Make the API call and store the results in an array.  If the
			call was a success, show the authorization details, and provide
			an action to complete the payment.  If failed, show the error
			*/
		   $resArray=$callerservice->hash_call("GetExpressCheckoutDetails",$nvpstr);
		   $_SESSION['reshash']=$resArray;
		   $ack = strtoupper($resArray["ACK"]);

		   if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING')
		   {
					//require_once "GetExpressCheckoutDetails1.php";
					$_SESSION['token']=$_REQUEST['token'];
					$_SESSION['payer_id'] = $_REQUEST['PayerID'];
					$_SESSION['paymentAmount']=$_REQUEST['paymentAmount'];
					$_SESSION['currCodeType']=$_REQUEST['currencyCodeType'];
					$_SESSION['paymentType']=$_REQUEST['paymentType'];

					$resArray=$_SESSION['reshash'];
					//$_SESSION['TotalAmount']= $resArray['AMT'];
					
					header('location:../user/final_pay_page');
			  } 
			  else  
			  {
				//Redirecting to APIError.php to display errors.
				$location = "../user/registration";
				header("Location: $location");
			  }
}
?>