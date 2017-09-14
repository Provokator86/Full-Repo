<?php
  error_reporting(E_ALL ^ E_NOTICE);
	require_once('lib/nusoap.php');
	require_once "./utils.php";	//just include utils to use it
	
	require 'vendor/autoload.php';
	/*use net\authorize\api\contract\v1 as AnetAPI;
	use net\authorize\api\controller as AnetController;
	use net\authorize\api\constants\ANetEnvironment;
	use constants\Constants;*/
	use authorizenet\authorizenet\lib\net\authorize\api\lib as AnetLib;
	use authorizenet\authorizenet\lib\net\authorize\api\contract\v1 as AnetAPI;
	use authorizenet\authorizenet\lib\net\authorize\api\controller as AnetController;
	use net\authorize\api\contract\v1\MerchantAuthenticationType;
	use net\authorize\api\contract\v1\CreditCardType;
	use net\authorize\api\contract\v1\TransactionRequestType;
	use net\authorize\api\contract\v1\CreateTransactionRequest;
	use net\authorize\api\controller\CreateTransactionController;
	use net\authorize\api\contract\v1\PaymentType;
	use net\authorize\api\contract\v1\OrderType;
	use net\authorize\api\constants\ANetEnvironment;
	use constants\Constants;
	
	define("AUTHORIZENET_LOG_FILE", "phplog");
	


	//This is your webservice server WSDL URL address
	$wsdl = "http://192.168.1.38/wsdl-generator/test_server.php?wsdl"; // for local
	$wsdl = "http://1099.codeuridea.net/wsdl-generator/wsdl_server.php?wsdl"; // for server

	//create client object
	$client = new nusoap_client($wsdl, 'wsdl');

	$err = $client->getError();
	if ($err) {
		// Display the error
		echo '<h2>Constructor error</h2>' . $err;
		// At this point, you know the call that follows will fail
		exit();
	}

	//calling our first simple entry point
	//$result1=$client->call('hello', array('username'=>'achmad'));
	//print_r($result1); 

	//call second function which return complex type
	#$result2 = $client->call('login', array('username'=>'john', 'password'=>'doe') );
	//$result2 would be an array/struct
	#var_dump($result2);
	
	
    $xml = <<<XML
    <?xml version="1.0" encoding="UTF-8"?>
<item>
<userName>shieldwatch</userName>
<passWord>test123</passWord>
<dataProcessFor>1</dataProcessFor>
<Company FormType='1099A'>
	<PayerInfo>
		<TIN>56679988</TIN>
		<Year>2015</Year>	
		<TypeOfTIN>4</TypeOfTIN>
		<TransferAgentIndicator>0</TransferAgentIndicator>
		<CompanyName>ABC Company</CompanyName>
		<CompanyNameLine2>ABC Company</CompanyNameLine2>
		<CompanyAddress>123 Some Street</CompanyAddress>
		<City>Some City</City>
		<State>ST</State>
		<Zipcode>123445</Zipcode>
		<Phone>8152264352</Phone>
	</PayerInfo>
	<Recipient id="11">
		<PayeeTIN>374476543</PayeeTIN>
		<PayeeTypeOfTIN>1</PayeeTypeOfTIN>
		<PayeeName>RONALDO TRUEDOE</PayeeName>
		<PayeeName2>RE</PayeeName2>
		<PayeeAddr>111 S PALMTREE CT</PayeeAddr>
		<PayeeCity>SOMECITY</PayeeCity>
		<PayeeState>OK</PayeeState>
		<PayeeZipcode>743451111</PayeeZipcode>
		<Box1>452.67</Box1>
		<Box2>125.51</Box2>
	</Recipient>
	<Recipient id='22'>
		<PayeeTIN>387576982</PayeeTIN>
		<PayeeTypeOfTIN>1</PayeeTypeOfTIN>
		<PayeeName>ALLENO CAPSTONE</PayeeName>
		<PayeeName2>AC</PayeeName2>
		<PayeeAddr>222 W STONEWAY PL</PayeeAddr>
		<PayeeCity>RIGHTHERE</PayeeCity>
		<PayeeState>OK</PayeeState>
		<PayeeZipcode>733452222</PayeeZipcode>
		<Box1>4520.67</Box1>
		<Box2>1250.51</Box2>
	</Recipient>
</Company>
</item>
XML;
	
	//$result3 = $client->call('transmit', array('xmlstring'=>$xml) );
	//print_r($result3);
		
	// ++++++++++++++++++++++++++++++++
	
	/*$result3 = $client->call('createUserAccount', 
							array('username'=>'test_user', 'password'=>'test12345','customername'=>'mrinmoy mondal','companyname'=>'shieldwatch',  
							'companyfeinnumber'=>'', 'companyaddress'=>'test123','companyaddress'=>'test',  
							'companycity'=>'', 'companystate'=>'','companyzip'=>'',  
							'companyphone'=>'', 'useremail'=>'test_user@gmail.com'  ) );
	print_r($result3);*/
	
	/*$result3 = $client->call('changePassword', 
							array('username'=>'test_user', 'password'=>'test@1234','newpassword'=>'test123'));
	print_r($result3);*/
	
	#$result3 = $client->call('requestNewPassword', array('username'=>'test_user123'));
	#print_r($result3);
	
	#$result3 = $client->call('getBatchStatus', array('batchid'=>'BATCH-1000000001'));
	#print_r($result3);
	
	#$result3 = $client->call('getAllBatchNumbers', array('username'=>'shieldwatch', 'password'=>'test123','datefrom'=>'09/23/2016','dateto'=>'09/24/2016' ));
	#print_r($result3);
	
	//$result3 = $client->call('getBatchDetails', array('username'=>'shieldwatch', 'password'=>'test123','batchid'=>'BATCH-1000000001'));
	//print_r($result3);
	
	#$result3 = $client->call('getPayerRecipientDetails', array('username'=>'shieldwatch', 'password'=>'test123','batchid'=>'BATCH-1000000001'));
	#$result3 = $client->call('getPayerRecipientDetails', array('username'=>'shieldwatch', 'password'=>'test123','batchid'=>'100025'));
	#print_r($result3);
	
		
			
	
	//echo '====>';
	//echo _getLastBatchNumber(); exit;
	
	$output = array(); $ERR = array(); $arr = array();
	$arr['username']	= $username = 'shieldwatch';			
	$arr['password'] 	= $password = 'test123';
	$arr['batchId'] 	= $batchId = '100025';
	$arr['batchId'] 	= $batchId = 'BATCH-1000000001';
	$arr['cardNumber'] 	= $cardNumber = '370000000000002';
	$arr['expiryMonthYear'] 	= $expiryMonthYear = '1226';
	$arr['cvvNumber'] 	= $cvvNumber = '123';
	
	$username = $arr['username'];
	$password = $arr['password'];
	
	/*
	define("MERCHANT_LOGIN_ID", "6cn2RX35");
	define("MERCHANT_TRANSACTION_KEY", "743Vh9w8bU9J48d4");
	// Common setup for API credentials
	$amount = '1.25';
	#$merchantAuthentication = new MerchantAuthenticationType();
	$merchantAuthentication = new MerchantAuthenticationType();
	$merchantAuthentication->setName(MERCHANT_LOGIN_ID);
	$merchantAuthentication->setTransactionKey(MERCHANT_TRANSACTION_KEY);
	$refId = 'ref' . time();

	// Create the payment data for a credit card
	$creditCard = new CreditCardType();
	//$creditCard->setCardNumber("4111111111111111");
	$creditCard->setCardNumber("370000000000002");
	$creditCard->setExpirationDate("1226");
	$creditCard->setCardCode("123");
	$paymentOne = new PaymentType();
	$paymentOne->setCreditCard($creditCard);

	$order = new OrderType();
	$order->setDescription("New Item");

	//create a transaction
	$transactionRequestType = new TransactionRequestType();
	$transactionRequestType->setTransactionType( "authCaptureTransaction"); 
	$transactionRequestType->setAmount($amount);
	$transactionRequestType->setOrder($order);
	$transactionRequestType->setPayment($paymentOne);


	$request = new CreateTransactionRequest();
	$request->setMerchantAuthentication($merchantAuthentication);
	$request->setRefId( $refId);
	$request->setTransactionRequest( $transactionRequestType);
	$controller = new CreateTransactionController($request);
	$response = $controller->executeWithApiResponse( ANetEnvironment::SANDBOX);
	
	
	
	if ($response != null)
	{
		//if($response->getMessages()->getResultCode() == RESPONSE_OK)
		if($response->getMessages()->getResultCode() === 'Ok')
		{
			//echo '333<pre>'; print_r($response); echo '</pre>'; exit;
		  $tresponse = $response->getTransactionResponse();
		  
			if ($tresponse != null && $tresponse->getMessages() != null)   
			{
				echo " Transaction Response code : " . $tresponse->getResponseCode() . "\n";
				echo "Charge Credit Card AUTH CODE : " . $tresponse->getAuthCode() . "\n";
				echo "Charge Credit Card TRANS ID  : " . $tresponse->getTransId() . "\n";
				echo " Code : " . $tresponse->getMessages()[0]->getCode() . "\n"; 
				echo " Description : " . $tresponse->getMessages()[0]->getDescription() . "\n";
			}
			else
			{
				echo "Transaction Failed \n";
				if($tresponse->getErrors() != null)
				{
				  echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
				  echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";            
				}
			}
		}
		else
		{
			//echo '222<pre>'; print_r($response); echo '</pre>'; exit;
			echo "Transaction Failed \n";
			$tresponse = $response->getTransactionResponse();
			if($tresponse != null && $tresponse->getErrors() != null)
			{
				echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
				echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";                      
			}
			else
			{
				echo " Error code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
				echo " Error message : " . $response->getMessages()->getMessage()[0]->getText() . "\n";
			}
		}      
	
	}
	else
	{
		echo  "No response returned \n";
	}
		
echo '222<pre>'; print_r($response); echo '</pre>'; exit;*/
		
	//echo '<pre>'; print_r($arr); echo '</pre>'; exit;
	
	if($username!='' && $password!='')
	{
		// username exist now check if the password match or not
		$pwddata = _info_by_userName_N_passWord($username, $password);		
		//echo '<pre>';print_r($pwddata); exit;	
		if(empty($pwddata )) // password does not match... 
		{    
			$ERR = acnt_info_no_match_response();	
			$output = _error_output_as_obj($ERR);
		}
		else // username & password match now check the date range
		{
			if($batchId!='')
			{
				$batch_info = _info_batch_details_information($batchId);
				if(!empty($batch_info)) // batch_info validated
				{
					// first check if there is any form against this batch
					$tot_price = 0;
					$where = " WHERE s_batch_code = '".addslashes($batchId)."' GROUP BY s_form_id ";
					$forms_info = _info_forms_payee_payment($where);
					//echo '<pre>'; print_r($forms_info); echo '</pre>'; exit;
					for($i = 0; $i < count($forms_info); $i++)
					{
						if($forms_info[$i]['s_form_id']<=16) // for 1099 category
						{
							$tot_payee = $forms_info[$i]['total_payee'];
							$price_set_details = _info_price_set_details(1);
							$tot_rec = count($price_set_details); 
							for($j=0; $j < $tot_rec; $j++)
							{
								if($tot_payee>= $price_set_details[$tot_rec-1]['i_start'] && !$price_set_details[$tot_rec-1]['i_end']) // max
								{
									$tot_price = $tot_price + $price_set_details[$tot_rec-1]['d_price'];
									break;
								}
								else
								{
									if($tot_payee>= $price_set_details[$j]['i_start'] && $tot_payee<= $price_set_details[$j]['i_end'])
									{
										$tot_price = $tot_price + $price_set_details[$j]['d_price'];										
										break;
									}
								}
							}
						}
					
					} // end finding total amount for the full batch
					
					//echo '<pre>'; print_r($tot_price); echo '</pre>'; exit;
					// total price greater than zero
					if($tot_price > 0)
					{
						define("MERCHANT_LOGIN_ID", "6cn2RX35");
						define("MERCHANT_TRANSACTION_KEY", "743Vh9w8bU9J48d4");
						// Common setup for API credentials
						$amount = $tot_price;
						#$merchantAuthentication = new MerchantAuthenticationType();
						$merchantAuthentication = new MerchantAuthenticationType();
						$merchantAuthentication->setName(MERCHANT_LOGIN_ID);
						$merchantAuthentication->setTransactionKey(MERCHANT_TRANSACTION_KEY);
						$refId = 'ref' . time();

						// Create the payment data for a credit card
						$creditCard = new CreditCardType();
						$creditCard->setCardNumber($cardNumber);
						//$creditCard->setCardNumber("370000000000002");
						$creditCard->setExpirationDate($expiryMonthYear);
						//$creditCard->setExpirationDate("1226");
						$creditCard->setCardCode($cvvNumber);
						//$creditCard->setCardCode("123");
						$paymentOne = new PaymentType();
						$paymentOne->setCreditCard($creditCard);

						$order = new OrderType();
						$order->setDescription("New Item");

						//create a transaction
						$transactionRequestType = new TransactionRequestType();
						$transactionRequestType->setTransactionType( "authCaptureTransaction"); 
						$transactionRequestType->setAmount($amount);
						$transactionRequestType->setOrder($order);
						$transactionRequestType->setPayment($paymentOne);


						$request = new CreateTransactionRequest();
						$request->setMerchantAuthentication($merchantAuthentication);
						$request->setRefId( $refId);
						$request->setTransactionRequest( $transactionRequestType);
						$controller = new CreateTransactionController($request);
						$response = $controller->executeWithApiResponse( ANetEnvironment::SANDBOX);
								
						if ($response != null)
						{
							//if($response->getMessages()->getResultCode() == RESPONSE_OK)
							if($response->getMessages()->getResultCode() === 'Ok')
							{
								//echo '333<pre>'; print_r($response); echo '</pre>'; exit;
								$tresponse = $response->getTransactionResponse();
							  
								if ($tresponse != null && $tresponse->getMessages() != null)   
								{
									//echo " Transaction Response code : " . $tresponse->getResponseCode() . "\n";
									//echo "Charge Credit Card AUTH CODE : " . $tresponse->getAuthCode() . "\n";
									//echo "Charge Credit Card TRANS ID  : " . $tresponse->getTransId() . "\n";
									//echo " Code : " . $tresponse->getMessages()[0]->getCode() . "\n"; 
									//echo " Description : " . $tresponse->getMessages()[0]->getDescription() . "\n";
									$successArr = array();		
									$successArr["paidAmount"] 				= $tot_price;		
									$successArr["transactionId"]			= $tresponse->getTransId();		
									$successArr["transactionCode"]			= $tresponse->getResponseCode();		
									$successArr["transactionDescription"]	= $tresponse->getMessages()[0]->getDescription();		
													
									$output = _paymentSuccess_output_as_obj($successArr);
									
									// insert payment history
									$payArr = array();
									$payArr["s_batch"]						= $batchId;
									$payArr["s_transaction_id"]				= $successArr["transactionId"];
									$payArr["s_transaction_description"]	= $successArr["transactionDescription"];
									$payArr["s_user"]						= $username;
									$payArr["i_user_id"]					= $pwddata["i_id"];
									$payArr["d_amount"]						= $tot_price;
									mysql_insert_array('ams_payment_history', $payArr);
									
									// update batch status change and insert batch status history to Invoice Paid
									//'1'=>'Invoice Pending','2'=>'Invoice Paid','3'=>'Filing Queued','4'=>'Filing Complete','5'=>'Filing Accepted','6'=>'Filing Rejected'
									#mysql_exc_qry("UPDATE ams_batch_master SET i_status=2 WHERE s_batch_id= '".addslashes($batchId)."' ");
									
									// Add batch history
									$logArr = array();
									$logArr["s_batch_id"] 	= $batchId;
									$logArr["s_action"] 	= 'Invoice Paid';
									$logArr["s_comment"] 	= 'Invoice Paid';
									$logArr["i_status"] 	= 2; // first status
									$logArr["i_created_by"] = $pwddata["i_id"]; // loggedin users id
									#mysql_insert_array('ams_batch_status_history', $payArr);
									
							
								}
								else
								{
									//echo "Transaction Failed \n";
									if($tresponse->getErrors() != null)
									{
										//echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
										//echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";   
										$successArr = array();		
										$successArr["paidAmount"] 				= "0";		
										$successArr["transactionId"]			= "";		
										$successArr["transactionCode"]			= $tresponse->getErrors()[0]->getErrorCode();		
										$successArr["transactionDescription"]	= $tresponse->getErrors()[0]->getErrorText();	  
										$output = _paymentError_output_as_obj($successArr);       
									}
								}
							}
							else
							{
								//echo '222<pre>'; print_r($response); echo '</pre>'; exit;
								//echo "Transaction Failed \n";
								$tresponse = $response->getTransactionResponse();
								if($tresponse != null && $tresponse->getErrors() != null)
								{
									//echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
									//echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";    
									$successArr = array();		
									$successArr["paidAmount"] 				= "0";		
									$successArr["transactionId"]			= "";		
									$successArr["transactionCode"]			= $tresponse->getErrors()[0]->getErrorCode();		
									$successArr["transactionDescription"]	= $tresponse->getErrors()[0]->getErrorText();	
									$output = _paymentError_output_as_obj($successArr);                          
								}
								else
								{
									//echo " Error code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
									//echo " Error message : " . $response->getMessages()->getMessage()[0]->getText() . "\n";  
									$successArr = array();		
									$successArr["paidAmount"] 				= "0";		
									$successArr["transactionId"]			= "";		
									$successArr["transactionCode"]			= $tresponse->getErrors()[0]->getErrorCode();		
									$successArr["transactionDescription"]	= $tresponse->getErrors()[0]->getErrorText();	
									$output = _paymentError_output_as_obj($successArr);   
								}
							}      
						
						}
						else
						{
							//echo  "No response returned \n";
							$successArr = array();		
							$successArr["paidAmount"] 				= "0";		
							$successArr["transactionId"]			= "";		
							$successArr["transactionCode"]			= "";		
							$successArr["transactionDescription"]	= "No response returned";	
							//$output = _paymentNoResponse_output_as_obj($successArr);   
							$output = _paymentNoResponse_output_as_obj($successArr);   
						}
						
					}
						
				}
				else
				{
					$ERR = _wrong_batchid_error_response();	
					$output = _error_output_as_obj($ERR);
				}
			}
			else
			{
				$ERR = _no_batchid_error_response();	
				$output = _error_output_as_obj($ERR);						
			}
			
		}
		
	}
	else
	{
		$ERR = acnt_no_user_pwd_response();	
		$output = _error_output_as_obj($ERR);				
	}
	echo '<pre>'; print_r($output); echo '</pre>'; exit;
		
			
	
	/*$password = 'admin123'; // test123=>9beac2e4c0f847a4f752a1036e08f194 , admin123=>adb8835820ebfbfb94d78a5023ba2e03
	$salt = md5('spicentea_oauth'); // test123=>e9a52c47dee27b6439be0019b0cb01a4b9fb3f59 , admin123=>8a062f504e337c3eae8589c763e7a1168edbc5c9
    echo sha1($salt.$password).'<===>';
    
    echo '</br>Normal Password: '.md5(trim($password).'_acs#13_');*/
    
	// ++++++++++++++++++++++++++++++++
	/*preg_match_all('/<Company FormType=(\'|\")(.*?)(\'|\")>(.*?)<\/Company>/s',$xml,$val); 
	if(!empty($val[4])){	
		foreach($val[4] as $key=>$cmp){							
			//print_r($cmp);
			preg_match_all('/<PayerInfo>(.*?)<\/PayerInfo>/s',$cmp,$payer);
			echo '<pre>';
			print_r($payer);
			echo '</pre>';
			
		}
	}*/
	// ++++++++++++++++++++++++++++++++
    

?>
