<?php
	error_reporting(E_ALL ^ E_NOTICE);
	//error_reporting(1);
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
	

	$server = new nusoap_server;
	$server->configureWSDL('server', 'urn:server');
	$server->wsdl->schemaTargetNamespace = 'urn:server';
	
	//------------------------------- ADD COMPLEXTYPE FOR DIFFERENT FUNCTIONS ----------------------------------------
		
	// SOAP complex type for transmit 
	$server->wsdl->addComplexType(
		'transmitResponse',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'batchId' => array('name' => 'batchId', 'type' => 'xsd:string'),
			'ResponseCode' => array('name' => 'ResponseCode', 'type' => 'xsd:string'),
			'ResponseDetail' => array('name' => 'ResponseDetail', 'type' => 'xsd:string'),
			'NoofForms' => array('name' => 'NoofForms', 'type' => 'xsd:int'),
			'totalPayer' => array('name' => 'totalPayer', 'type' => 'xsd:int'),
			'totalPayee' => array('name' => 'totalPayee', 'type' => 'xsd:int'),
			'totalCost' => array('name' => 'totalCost', 'type' => 'xsd:string')
		)
	);
	
	//SOAP complex type return type (an array/struct)
	$server->wsdl->addComplexType(
		'Person',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'id_user' => array('name' => 'id_user', 'type' => 'xsd:string'),
			'fullname' => array('name' => 'fullname', 'type' => 'xsd:string'),
			'email' => array('name' => 'email', 'type' => 'xsd:string'),
			'ResponseCode' => array('name' => 'ResponseCode', 'type' => 'xsd:string'),
			'ResponseDetail' => array('name' => 'ResponseDetail', 'type' => 'xsd:string')
		)
	);
	
	
	//SOAP complex type return type for change password
	$server->wsdl->addComplexType(
		'PasswordChange',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'id_user' => array('name' => 'id_user', 'type' => 'xsd:string'),
			//'email' => array('name' => 'email', 'type' => 'xsd:string'),
			'ResponseCode' => array('name' => 'ResponseCode', 'type' => 'xsd:string'),
			'ResponseDetail' => array('name' => 'ResponseDetail', 'type' => 'xsd:string')
		)
	);
	
	//SOAP complex type return type for request new password
	$server->wsdl->addComplexType(
		'PasswordRequest',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'id_user' => array('name' => 'id_user', 'type' => 'xsd:string'),
			'email' => array('name' => 'email', 'type' => 'xsd:string'),
			'ResponseCode' => array('name' => 'ResponseCode', 'type' => 'xsd:string'),
			'ResponseDetail' => array('name' => 'ResponseDetail', 'type' => 'xsd:string')
		)
	);
	
	//SOAP complex type return type for getBatchLogHistory
	$server->wsdl->addComplexType(
		'getBatchLogHistory',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'batchId' => array('name' => 'batchId', 'type' => 'xsd:string'),
			'ResponseCode' => array('name' => 'ResponseCode', 'type' => 'xsd:string'),
			'ResponseDetail' => array('name' => 'ResponseDetail', 'type' => 'xsd:string')
		)
	);
	
	
	//SOAP complex type return type for getAllBatchNumbersDateRange
	$server->wsdl->addComplexType(
		'getAllBatchNumbersDateRange',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'batchNumbers' => array('name' => 'batchNumbers', 'type' => 'xsd:string'),
			'ResponseCode' => array('name' => 'ResponseCode', 'type' => 'xsd:string'),
			'ResponseDetail' => array('name' => 'ResponseDetail', 'type' => 'xsd:string')
		)
	);
	
	//SOAP complex type return type for getBatchDetailsInfo
	$server->wsdl->addComplexType(
		'getBatchDetailsInfo',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'dateSubmitted' => array('name' => 'dateSubmitted', 'type' => 'xsd:string'),
			'totalForms' => array('name' => 'totalForms', 'type' => 'xsd:string'),
			'totalCost' => array('name' => 'totalCost', 'type' => 'xsd:string'),
			'ResponseCode' => array('name' => 'ResponseCode', 'type' => 'xsd:string'),
			'ResponseDetail' => array('name' => 'ResponseDetail', 'type' => 'xsd:string')
		)
	);
	
	
	//SOAP complex type return type for getCurrentPriceInfo
	$server->wsdl->addComplexType(
		'getCurrentPriceInfo',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'totalForms' => array('name' => 'totalForms', 'type' => 'xsd:int'),
			'oldCost' => array('name' => 'oldCost', 'type' => 'xsd:string'),
			'newCost' => array('name' => 'newCost', 'type' => 'xsd:string'),
			'ResponseCode' => array('name' => 'ResponseCode', 'type' => 'xsd:string'),
			'ResponseDetail' => array('name' => 'ResponseDetail', 'type' => 'xsd:string')
		)
	);
	
	
	
	//SOAP complex type return type for getPayerRecipientDetailsInfo
	/*$server->wsdl->addComplexType(
		'getPayerRecipientDetailsInfo',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'informations' => array('name' => 'informations', 'type' => 'xsd:string'),
			'ResponseCode' => array('name' => 'ResponseCode', 'type' => 'xsd:string'),
			'ResponseDetail' => array('name' => 'ResponseDetail', 'type' => 'xsd:string')
		)
	);*/
	
	// NEW COMPLEXTYPE DEFINITION FOR getPayerRecipientDetailsInfo SOAP
	// 2nd process	
	
	$server->wsdl->addComplexType(
		'payeeDataList',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'PayeeName' => array('name' => 'PayeeName', 'type' => 'xsd:string'),
			'PayeeEIN' => array('name' => 'PayeeEIN', 'type' => 'xsd:string')
		)
	);	
	
	
	$server->wsdl->addComplexType(
		'ArrayOfPayee',
		'complexType',
		'array',
		'',
		'SOAP-ENC:Array',
		array(),
		array(
			array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:payeeDataList[]')
		),
		'tns:payeeDataList'
	);
	
	$server->wsdl->addComplexType(
		'payerDataList',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'Form' => array('name' => 'Form', 'type' => 'xsd:string'),
			'PayerName' => array('name' => 'PayerName', 'type' => 'xsd:string'),
			'PayerEIN' => array('name' => 'PayerEIN', 'type' => 'xsd:string'),
			'PayeeList' => array('name' => 'PayeeList', 'type'=>'tns:ArrayOfPayee')
		)
	);
	
	
	$server->wsdl->addComplexType(
		'ArrayOfPayers',
		'complexType',
		'array',
		'',
		'SOAP-ENC:Array',
		array(),
		array(
			array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:payerDataList[]')
		),
		'tns:payerDataList'
	);


	$server->wsdl->addComplexType(
		'getPayerRecipientDetailsInfo',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'ResponseCode' => array('name' => 'ResponseCode', 'type' => 'xsd:string'),
			'ResponseDetail' => array('name' => 'ResponseDetail', 'type' => 'xsd:string'),
			'informations' => array('name'=>'informations','type'=>'tns:ArrayOfPayers')
		)
	);


	// NEW COMPLEXTYPE DEFINITION FOR getPayerRecipientDetailsInfo SOAP
	

	$server->wsdl->addComplexType(
		'makeBatchPaymentInfo',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'customerName' => array('name' => 'customerName', 'type' => 'xsd:string'),
			'customerAddress' => array('name' => 'customerAddress', 'type' => 'xsd:string'),
			'customerCity' => array('name' => 'customerCity', 'type' => 'xsd:string'),
			'customerState' => array('name' => 'customerState', 'type' => 'xsd:string'),
			'customerZip' => array('name' => 'customerZip', 'type' => 'xsd:string'),
			'invoiceNo' => array('name' => 'invoiceNo', 'type' => 'xsd:string'),
			'paidAmount' => array('name' => 'paidAmount', 'type' => 'xsd:string'),
			'transactionCode' => array('name' => 'transactionCode', 'type' => 'xsd:string'),
			'transactionId' => array('name' => 'transactionId', 'type' => 'xsd:string'),
			'transactionDescription' => array('name' => 'transactionDescription', 'type' => 'xsd:string'),
			'ResponseCode' => array('name' => 'ResponseCode', 'type' => 'xsd:string'),
			'ResponseDetail' => array('name' => 'ResponseDetail', 'type' => 'xsd:string')
		)
	);



	//first simple function
	/*$server->register('hello',
				array('username' => 'xsd:string'),  //parameter
				array('return' => 'xsd:string'),  //output
				'urn:server',   //namespace
				'urn:server#helloServer',  //soapaction
				'rpc', // style
				'encoded', // use
				'Just say hello');  //description */

	//------------------------------- END COMPLEXTYPE FOR DIFFERENT FUNCTIONS ----------------------------------------
	
	//------------------------------- START REGISTER FOR DIFFERENT FUNCTIONS ----------------------------------------
				
	// this is the register of transmit function
	$server->register('transmit',
				array('xmlstring' => 'xsd:string'),  //parameters
				array('return' => 'tns:transmitResponse'),  //output
				'urn:server',   //namespace
				'urn:server#transmitServer',  //soapaction
				'rpc', // style
				'encoded', // use
				'This is transmit data');  //description

	
	//this is the register of createUserAccount function 
	$server->register('createUserAccount',
				array('username' => 'xsd:string', 'password'=>'xsd:string', 'customername' => 'xsd:string', 
					'companyname'=>'xsd:string', 'companyfeinnumber'=>'xsd:string', 'companyaddress' => 'xsd:string', 
					'companycity'=>'xsd:string', 'companystate'=>'xsd:string', 'companyzip' => 'xsd:string', 
					'companyphone'=>'xsd:string', 'useremail'=>'xsd:string','autoemail'=>'xsd:string'),  //parameters
				array('return' => 'tns:Person'),  //output
				'urn:server',   //namespace
				'urn:server#createUserAccountServer',  //soapaction
				'rpc', // style
				'encoded', // use
				'Create new user account');  //description 

	
	
	//this is the register of changePassword function 
	$server->register('changePassword',
				array('username' => 'xsd:string', 'password'=>'xsd:string', 'newpassword' => 'xsd:string' ),  //parameters
				array('return' => 'tns:PasswordChange'),  //output
				'urn:server',   //namespace
				'urn:server#changePasswordServer',  //soapaction
				'rpc', // style
				'encoded', // use
				'Change user account password');  //description 
	
	//this is the register of changePassword function 
	$server->register('requestNewPassword',
				array('username' => 'xsd:string'),  //parameters
				array('return' => 'tns:PasswordRequest'),  //output
				'urn:server',   //namespace
				'urn:server#requestNewPasswordServer',  //soapaction
				'rpc', // style
				'encoded', // use
				'Request for new password');  //description 
	
	//this is the register of changePassword function 
	$server->register('getBatchStatus',
				array('batchid' => 'xsd:string'),  //parameters
				array('return' => 'tns:getBatchLogHistory'),  //output
				'urn:server',   //namespace
				'urn:server#getBatchStatusServer',  //soapaction
				'rpc', // style
				'encoded', // use
				'Btach status history');  //description 
	
	//this is the register of get all batch numbers from date range function 
	$server->register('getAllBatchNumbers',
				array('username' => 'xsd:string', 'password'=>'xsd:string', 'datefrom' => 'xsd:string', 
					'dateto'=>'xsd:string'),  //parameters
				array('return' => 'tns:getAllBatchNumbersDateRange'),  //output
				'urn:server',   //namespace
				'urn:server#getAllBatchNumbersServer',  //soapaction
				'rpc', // style
				'encoded', // use
				'Btach Numbers in The Date Range');  //description 


	
	//this is the register of get all batch numbers from date range function 
	$server->register('getBatchDetails',
				array('username' => 'xsd:string', 'password'=>'xsd:string', 'batchid' => 'xsd:string'),  //parameters
				array('return' => 'tns:getBatchDetailsInfo'),  //output
				'urn:server',   //namespace
				'urn:server#getBatchDetailsServer',  //soapaction
				'rpc', // style
				'encoded', // use
				'Batch Details Information');  //description 


	
	//this is the register of get all payer and recipient info of a batch id 
	$server->register('getPayerRecipientDetails',
				array('username' => 'xsd:string', 'password'=>'xsd:string', 'batchid' => 'xsd:string'),  //parameters
				array('return' => 'tns:getPayerRecipientDetailsInfo'),  //output
				'urn:server',   //namespace
				'urn:server#getPayerRecipientDetailsServer',  //soapaction
				'rpc', // style
				'encoded', // use
				'Payer and Recipient Informations of a Batch');  //description 


	
	
	//this is the register of get all payer and recipient info of a batch id 
	$server->register('makeBatchPayment',
				array('username' => 'xsd:string', 'password'=>'xsd:string', 'batchId' => 'xsd:string', 'cardNumber'=>'xsd:string', 'expiryMonthYear' => 'xsd:string', 'cvvNumber' => 'xsd:string'),  //parameters
				array('return' => 'tns:makeBatchPaymentInfo'),  //output
				'urn:server',   //namespace
				'urn:server#makeBatchPaymentServer',  //soapaction
				'rpc', // style
				'encoded', // use
				'Payment Informations of a Batch');  //description 


	
	
	//this is the register of get all batch numbers from date range function 
	$server->register('getCurrentPrice',
				array('username' => 'xsd:string', 'password'=>'xsd:string', 'batchid' => 'xsd:string'),  //parameters
				array('return' => 'tns:getCurrentPriceInfo'),  //output
				'urn:server',   //namespace
				'urn:server#CurrentPriceServer',  //soapaction
				'rpc', // style
				'encoded', // use
				'Current Price of a Batch');  //description 


	//first function implementation
	/*function hello($username) {
			return 'Howdy, '.$username.'!';
	}*/
	//------------------------------- END REGISTER FOR DIFFERENT FUNCTIONS ----------------------------------------

	//------------------------------- START DEFINE DIFFERENT FUNCTIONS ----------------------------------------
	
	//getCurrentPrice function implementation 
	function getCurrentPrice($username, $password, $batchId) {
			//should do some database query here
			$output = array(); $ERR = array(); $arr = array();
			$arr['username']	= $username;			
			$arr['password'] 	= $password;
			$arr['batchId'] 	= $batchId;
			
			$username = $arr['username'];
			$password = $arr['password'];			
			
			if($username!='' && $password!='')
			{
				// username exist now check if the password match or not
				$pwddata = _info_by_userName_N_passWord($username, $password);				
				if(empty($pwddata )) // password does not match... 
				{    
					$ERR = acnt_info_no_match_response();	
					$output = _error_output_as_obj($ERR);
				}
				else // username & password match now check the date range
				{
					if($batchId!='' )
					{	
						$batch_info = _info_batch_details_information($batchId);						
						if(!empty($batch_info)) // batch_info validated
						{
							$successArr = array();	
							$successArr["oldCost"] 		= $batch_info[0]["d_paid_price"];			
							$successArr["totalForms"] 	= $batch_info[0]["total_form"];		
							//$successArr["newCost"] 		= _priceFormat($batchPrice); 
							// start calculating the new price	
							$userId = _getUserIdFromUsername($username);		
							$formsCount = _info_batch_forms_count($batchId);
							$newCost = 0;
							$formTypeWithCountArr = array();
							if(!empty($formsCount))
							{
								foreach($formsCount as $key=>$val)
								{
									$formTypeWithCountArr[$val["s_form_id"]] = $val["total_payee"];
								}								
							
								$newCost = _newCalculateFormPrice($formTypeWithCountArr, $userId, $batch_info[0]["s_dataProcessFor"]);
							}
							$successArr["newCost"] 		= _priceFormat($newCost); 
							$dtUpdate = date('Y-m-d H:i:s');
							mysql_exc_qry("UPDATE ams_batch_master SET d_updated_price = '".addslashes($newCost)."', dt_updated_price ='".addslashes($dtUpdate)."' WHERE  s_batch_id= '".$batchId."' ");
							$output = _batchCurrentPrice_output_as_obj($successArr);
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
			
			//just some dummy result
			/*return array(
			'id_user'=>1,
			'fullname'=>'John Reese',
			'email'=>'john@reese.com'
			);*/
			return $output;
			
	}	
	
	
	// function makeBatchPayment for payment of a batch
	function makeBatchPayment($username, $password, $batchId='', $cardNumber='', $expiryMonthYear='', $cvvNumber='')
	{
		$output = array(); $ERR = array(); $arr = array();
		$arr['username']		= $username ;			
		$arr['password'] 		= $password ;
		$arr['batchId'] 		= $batchId ;
		$arr['batchId'] 		= $batchId ;
		$arr['cardNumber'] 		= $cardNumber;
		$arr['expiryMonthYear']	= $expiryMonthYear;
		$arr['cvvNumber'] 		= $cvvNumber;
		
		$username = $arr['username'];
		$password = $arr['password'];
		
		
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
						#$tot_price = _calculateBatchPrice($batchId); #messages/631589 posted on 23 feb
						$tot_price = $batch_info[0]["d_updated_price"] ? $batch_info[0]["d_updated_price"]: $batch_info[0]["d_paid_price"];
						
						## CHECK IF THE BATCH ALREADY PAID 
						$checkArr = _chk_payment_history($batchId);
						
						if(empty($checkArr[0]))
						{
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
											$successArr["paidAmount"] 				= _priceFormat($tot_price);		
											$successArr["transactionId"]			= $tresponse->getTransId();		
											$successArr["transactionCode"]			= $tresponse->getResponseCode();		
											$successArr["transactionDescription"]	= $tresponse->getMessages()[0]->getDescription();		
											$successArr["customerName"]				= $pwddata["s_customer_name"];
											$successArr["customerAddress"]			= $pwddata["s_company_address"];				
											$successArr["customerCity"]				= $pwddata["s_company_city"];				
											$successArr["customerState"]			= $pwddata["s_company_state"];				
											$successArr["customerZip"]				= $pwddata["s_company_zip"];				
											$successArr["invoiceNo"]				= $batchId;				
															
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
											
											mysql_exc_qry("UPDATE ams_batch_master SET i_status=2 WHERE s_batch_id= '".addslashes($batchId)."' ");
											
											// Add batch history
											$logArr = array();
											$logArr["s_batch_id"] 	= $batchId;
											$logArr["s_action"] 	= 'Invoice Paid';
											$logArr["s_comment"] 	= 'Invoice Paid';
											$logArr["i_status"] 	= 2; // first status
											$logArr["i_created_by"] = $pwddata["i_id"]; // loggedin users id
											mysql_insert_array('ams_batch_status_history', $logArr);
											
											// again change status to invoice feeling see@https://shieldwatch.teamwork.com/index.cfm#messages/631589
											mysql_exc_qry("UPDATE ams_batch_master SET i_status=3 WHERE s_batch_id= '".addslashes($batchId)."' ");
											
											// Add batch history
											$logArr = array();
											$logArr["s_batch_id"] 	= $batchId;
											$logArr["s_action"] 	= 'Filing Queued';
											$logArr["s_comment"] 	= 'Filing Queued';
											$logArr["i_status"] 	= 3; 
											$logArr["i_created_by"] = $pwddata["i_id"]; // loggedin users id
											mysql_insert_array('ams_batch_status_history', $logArr);
											
											
									
										}
										else
										{
											//echo "Transaction Failed \n";
											if($tresponse->getErrors() != null)
											{
												//echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
												//echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";   
												$successArr = array();		
												$successArr["paidAmount"] 				= _priceFormat('0');	
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
											$successArr["paidAmount"] 				= _priceFormat('0');	
											$successArr["transactionId"]			= "";		
											$successArr["transactionCode"]			= $tresponse->getErrors()[0]->getErrorCode();		
											$successArr["transactionDescription"]	= $tresponse->getErrors()[0]->getErrorText();	
											$output = _paymentError_output_as_obj($successArr);                          
										}										
										else if($tresponse == null)
										{ 
											$successArr = array();		
											$successArr["paidAmount"] 				= _priceFormat('0');		
											$successArr["transactionId"]			= "";		
											$successArr["transactionCode"]			= 8;		
											$successArr["transactionDescription"]	= "Credit card cvv number is invalid.";	
											$output = _paymentError_output_as_obj($successArr);   
											
										}
										else
										{
											//echo " Error code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
											//echo " Error message : " . $response->getMessages()->getMessage()[0]->getText() . "\n";  
											$successArr = array();		
											$successArr["paidAmount"] 				= _priceFormat('0');		
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
									$successArr["paidAmount"] 				= _priceFormat('0');	
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
							//echo  "No response returned \n";
							$successArr = array();		
							$successArr["paidAmount"] 				= _priceFormat('0');	
							$successArr["transactionId"]			= "";		
							$successArr["transactionCode"]			= "";		
							$successArr["transactionDescription"]	= "This batch has been already paid.";	
							$output = _alreadyPaid_batchid_error_response($successArr);  
							
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
		
		return $output;
	
	}
	
	
	//getPayerRecipientDetails function implementation 
	function getPayerRecipientDetails($username, $password, $batchId) {
			//should do some database query here
			$output = array(); $ERR = array(); $arr = array();
			$arr['username']	= $username;			
			$arr['password'] 	= $password;
			$arr['batchId'] 	= $batchId;
			
			$username = $arr['username'];
			$password = $arr['password'];			
			
			if($username!='' && $password!='')
			{
				// username exist now check if the password match or not
				$pwddata = _info_by_userName_N_passWord($username, $password);				
				if(empty($pwddata )) // password does not match... 
				{    
					$ERR = acnt_info_no_match_response();	
					$output = _error_output_as_obj($ERR);
				}
				else // username & password match now check the date range
				{
					if($batchId!='' )
					{	
						$batch_info = _info_batch_details_information($batchId);
						if(!empty($batch_info)) // batch_info validated
						{
							// first check if there is any form against this batch
							$where = " WHERE n.s_batch_code = '".addslashes($batchId)."' GROUP BY n.s_form_id ";
							$forms = _info_forms_payer_payee($where);
							
							$ret_msg_ = '';
							$receipientsArr = array();
							if(!empty($forms))
							{
								foreach($forms as $fval)
								{
									$form_id = $fval['s_form_id'];
									$ret_msg_ .= 'Form: '.$fval["s_form_title"].' || ';
									
									$p_where = " WHERE n.s_batch_code = '".addslashes($batchId)."' AND n.s_form_id = '".addslashes($form_id)."' 
												GROUP BY n.i_payer_id ";
									$payer = _info_forms_payer_payee($p_where);									
									//echo '<pre>'; print_r($payer); exit;
									
									$payerObj = array();
									$payeeObj = array();
									$payeeObjNw = array();
									
									if(!empty($payer))
									{
										$j = 0;
										foreach($payer as $pval)
										{
											$object = new stdClass();
											$payerArr = array();
											/////////////
											//$payer_id = $pval["payer_id"];
											$payer_id = $pval["i_payer_id"];
										
											// new object
											$object->Form 		= $pval["s_form_title"];
											$object->PayerName 	= $pval["s_first_payer_name_line"];
											$object->PayerEIN 	= $pval["s_payer_tin"];
											
											// new array
											$payerArr['Form']		= $pval["s_form_title"];
											$payerArr['PayerName']	= $pval["s_first_payer_name_line"];
											$payerArr['PayerEIN']	= $pval["s_payer_tin"];
																				
											$r_where = " WHERE n.s_batch_code = '".addslashes($batchId)."' AND n.s_form_id = '".addslashes($form_id)."' 
														AND n.i_payer_id = '".addslashes($payer_id)."' GROUP BY n.i_payee_id ";
											$payee = _info_forms_payer_payee($r_where);											
											//echo '<pre>'; print_r($payee);
											if(!empty($payee))
											{
												$i = 0;												
												foreach($payee as $rval)
												{
													//$payee_id = $fval["payee_id"];
													$payee_id = $fval["i_payee_id"];
													$name = $rval["s_first_payee_name_line"].(($rval["s_first_payee_name_line"])?" ".$rval["s_last_payee_name_line"]:"");
													//object
													$obj = new stdClass();
													$obj->PayeeName = $name;
													$obj->PayeeEIN 	= $rval["s_payee_tin"];
													
													// array
													$payeeArr = array();
													$payeeArr['PayeeName']	= $name;
													$payeeArr['PayeeEIN']	= $rval["s_payee_tin"];
													
													$payeeObj[$i] = $obj;												
													$payeeObjNw[$i] = $payeeArr;
													
													$i++;
													unset($obj);
																	
												}
												//echo '<pre>'; print_r($payeeObj); exit;
												$object->PayeeList = $payeeObj;
												$payerArr['PayeeList'] = $payeeObjNw;
											} // end of payee loop
											
											$j++;
											//$receipientsArr[] = $object;
											$receipientsArr[] = $payerArr;
											unset($object);
											unset($payerArr);
										}
										
									} // end of payers loop
										
									
									$ret_msg_ = trim($ret_msg_, ' || ');
									$tmp[]= $ret_msg_; 
									$ret_msg_ ='';
								}
								
							} // end of forms loop
							
							//$ret_msg_ = trim($ret_msg_, '<br>');							
							$successArr = array();									
							//$successArr["informations"] = json_encode($receipientsArr);					
							$successArr["informations"] = $receipientsArr;					
							$output = _getPayerRecipientDetailsInfo_output_as_obj($successArr);
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
			return $output;
			
	}	
		
	//getBatchDetails function implementation 
	function getBatchDetails($username, $password, $batchId) {
			//should do some database query here
			$output = array(); $ERR = array(); $arr = array();
			$arr['username']	= $username;			
			$arr['password'] 	= $password;
			$arr['batchId'] 	= $batchId;
			
			$username = $arr['username'];
			$password = $arr['password'];
			
			
			if($username!='' && $password!='')
			{
				// username exist now check if the password match or not
				$pwddata = _info_by_userName_N_passWord($username, $password);				
				if(empty($pwddata )) // password does not match... 
				{    
					$ERR = acnt_info_no_match_response();	
					$output = _error_output_as_obj($ERR);
				}
				else // username & password match now check the date range
				{
					if($batchId!='' )
					{	
						//$cond = " s_batch_id='".addslashes($batchId)."' ";
						$batch_info = _info_batch_details_information($batchId);						
						if(!empty($batch_info)) // batch_info validated
						{
							//$batchPrice = _calculateBatchPrice($batchId); // old code
							$batchPrice = $batch_info[0]["d_updated_price"]>0?$batch_info[0]["d_updated_price"]:$batch_info[0]["d_paid_price"];
							$successArr = array();		
							$successArr["dateSubmitted"] 	= date("m/d/Y", strtotime($batch_info[0]["dt_created"]));		
							#$successArr["totalForms"] 		= count($batch_info);		
							$successArr["totalForms"] 		= $batch_info[0]["total_form"];		
							$successArr["totalCost"] 		= _priceFormat($batchPrice); // please change it later as per required					
							$output = _batchDetails_output_as_obj($successArr);
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
			
			//just some dummy result
			/*return array(
			'id_user'=>1,
			'fullname'=>'John Reese',
			'email'=>'john@reese.com'
			);*/
			return $output;
			
	}	
	
	
	//getAllBatchNumbers function implementation 
	function getAllBatchNumbers($username, $password, $datefrom='', $dateto='') {
			//should do some database query here
			$output = array(); $ERR = array(); $arr = array();
			$arr['username']	= $username;			
			$arr['password'] 	= $password;
			$arr['datefrom'] 	= $datefrom;
			$arr['dateto'] 		= $dateto;
			
			$username = $arr['username'];
			$password = $arr['password'];
			
			
			if($username!='' && $password!='')
			{
				// username exist now check if the password match or not
				$pwddata = _info_by_userName_N_passWord($username, $password);
				/*echo '<pre>';
				print_r($pwddata);
				echo '</pre>'; exit;*/
				
				if(empty($pwddata )) // password does not match... 
				{    
					$ERR = acnt_info_no_match_response();	
					$output = _error_output_as_obj($ERR);
				}
				else // username & password match now check the date range
				{
					if($datefrom!='' && $dateto!='')
					{	
						/*$datefrom_validated = _validate_Date($datefrom);				
						$dateto_validated 	= _validate_Date($dateto);
						//if($datefrom_validated && $dateto_validated) // date format validated
						if($datefrom && $dateto) // see @https://shieldwatch.teamwork.com/#messages/679965
						{*/
							$from = date("Y-m-d", strtotime($datefrom));
							$to = date("Y-m-d", strtotime($dateto));
							$where = " s_username = '".addslashes($username)."' AND DATE_FORMAT(dt_created, '%Y-%m-%d') >= '".$from."' AND DATE_FORMAT(dt_created, '%Y-%m-%d')<='".$to."' ";
							$batch_info = _info_batch_created($where);
							$msg = '';
							if(!empty($batch_info)){
								foreach($batch_info as $val){
									$msg.= $val["s_batch_id"].', ';
								}
							}
							$msg = trim($msg, ', ');
							$successArr = array();
							$successArr["msg"] 		= $msg?$msg:"No record found.";							
							$output = _batchNumbers_output_as_obj($successArr);
						/*}		
						else
						{
							$ERR = _date_format_error_response();	
							$output = _error_output_as_obj($ERR);							
						}	*/	
					}
					else
					{
						//$ERR = _no_daterange_error_response();	
						//$output = _error_output_as_obj($ERR);	
							$where = " s_username = '".addslashes($username)."' ";
							$batch_info = _info_batch_created($where);
							$msg = '';
							if(!empty($batch_info)){
								foreach($batch_info as $val){
									$msg.= $val["s_batch_id"].', ';
								}
							}
							$msg = trim($msg, ', ');
							$successArr = array();
							$successArr["msg"] 		= $msg?$msg:"No record found.";							
							$output = _batchNumbers_output_as_obj($successArr);					
					}
				}
				
			}
			else
			{
				$ERR = acnt_no_user_pwd_response();	
				$output = _error_output_as_obj($ERR);				
			}
			
			//just some dummy result
			/*return array(
			'id_user'=>1,
			'fullname'=>'John Reese',
			'email'=>'john@reese.com'
			);*/
			return $output;
			
	}	
	
	
	//getBatchStatus function implementation 
	function getBatchStatus($batchid) {
			//should do some database query here
			$output = array(); $ERR = array(); $arr = array();
			$arr['batchid'] = $batchid;	
			$batchid 		= $arr['batchid'];		
			
			if($batchid!='')
			{	
				$batch_data = _info_by_batchid_only($batchid);
				if(empty( $batch_data )) {    // batchid not exist...					
					$ERR = _error_batchid_exist_response();	
					$output = _error_output_as_obj($ERR);					
				}
				else
				{
					$batch_info = _info_batch_status_history($batchid);
					
					$msg = '';
					if(!empty($batch_info))
					{
						foreach($batch_info as $val)
						{
							$userInfo = _info_by_userID_only($val['i_created_by']);
							//$date = $val['dt_created']?' on '.date("m/d/Y H:i:s", strtotime($val['dt_created'])):"";
							//$date = $val['dt_created']?' '.date("m/d/y H:i:s", strtotime($val['dt_created'])):""; // C by JS on 14/06/2017
							$date = $val['dt_created']?''.date("H:i:s,m/d/Y", strtotime($val['dt_created'])):""; // By JS on 14/06/2017
							$name = $userInfo['s_first_name']?$userInfo['s_first_name'].' '.$userInfo['s_last_name']:"Admin";
							//$msg.= $val["s_action"].' by '.$name.$date.'</br>';
							$s_action = '';
							if($val["s_action"]=='created')
								$s_action = 'Invoice Pending';
							else
								$s_action = $val["s_action"];
							$status_number = _get_batch_status_number($s_action);
							$msg.= $status_number.','.$s_action.','.$date.'|';// JS 06 June 2017
						}
						$msg = trim($msg, '|');// By JS on 14/06/2017
					}
					
					$successArr = array();
					$successArr["batchid"] 	= $batchid;
					$successArr["msg"] 		= $msg?$msg:"No record found."; //Commented by JS 06 June 2017
					$output = _batchStatus_history_output_as_obj($successArr);
				}
				
			}
			else
			{
				$ERR = _error_batchid_empty_response();	
				$output = _error_output_as_obj($ERR);				
			}
			
			//just some dummy result
			/*return array(
			'id_user'=>1,
			'fullname'=>'John Reese',
			'email'=>'john@reese.com'
			);*/
			return $output;
			
	}	
	
	//change user account password function implementation 
	function requestNewPassword($username) {
			//should do some database query here
			$output = array(); $ERR = array(); $arr = array();
			$arr['username'] = $username;	
			//$username 		= $arr['username'];		
			
			if($username!='')
			{
				$user_data = _info_by_userName_only($username);
				if(empty( $user_data )) {    // userName not exist...					
					$ERR = _error_username_failed_response();	
					$output = _error_output_as_obj($ERR);					
				}
				else
				{
					// username exist now set a random password and send email
					$genPassword = genPassword();
					$updateArr = array();
					if($genPassword!='')
					{
						$updateArr['s_password'] = get_salted_password($genPassword);
						// now send an email to the email registered
						if($user_data['s_email']!='')
						{
							mysql_exc_qry("UPDATE ams_user SET s_password = '".$updateArr['s_password']."' WHERE  s_user_name= '".$username."' ");
							// update email in the oauth table also
							mysql_exc_qry("UPDATE oauth_users SET s_password='".$updateArr['s_password']."' WHERE  s_username= '".$username."' ");
						
						
							#$user_data['s_email'] = 'mmondal@codeuridea.com';
							$to  = $user_data['s_email']; // note the comma
							$from = 'projects@codeuridea.com';
							// subject
							$subject = 'New password request';

							// message
							$message = '
							<html>
							<head>
							  <title>New password request</title>
							</head>
							<body>
							  <p>Here are the details!</p>
							  <table border="0" cellspacing="2" cellpading="2" width="50%">
								<tr>
								  <th>Username</th><th>New Password</th>
								</tr>
								<tr>
								  <td align="center">'.$username.'</td><td align="center">'.$genPassword.'</td>
								</tr>
							  </table>
							</body>
							</html>
							';
							
							//if($_SERVER['SERVER_NAME']=='stagingapi.codeuridea.com')
							if($_SERVER['SERVER_NAME']=='1099.codeuridea.net')
							{
								$headers  = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";							 
								// Create email headers
								$headers .= 'From: '.$from."\r\n".
									'Reply-To: '.$from."\r\n" .
									'X-Mailer: PHP/' . phpversion();							
								
								
								//@mail($to, $subject, $message);
								@mail($to, $subject, $message, $headers);
								
								$sucArr = array();
								$sucArr["id_user"] 	= $username;
								$sucArr["fullname"] = $user_data['s_first_name'].' '. $user_data['s_last_name'];
								$sucArr["email"] 	= $user_data['s_email'];							
								$output = _pwd_new_output_as_obj($sucArr);
							}
							else
							{
								// open below code whenever you got the smtp settings							
								// phpmailer start
								require('class.phpmailer.php');

								$mail = new PHPMailer;
								//$mail->SMTPDebug = 3;                         // Enable verbose debug output
								$mail->isSMTP();                                // Set mailer to use SMTP
								$mail->Host = 'mail.codeuridea.com';  			// Specify main and backup SMTP servers
								$mail->SMTPAuth = true;   						// Enable SMTP authentication
								//$mail->SetLanguage('en','PHPMailer-master/language/');                             
								$mail->Username = 'projects@codeuridea.com';    // SMTP username
								$mail->Password = '$h1eld687#';  				// SMTP password
								$mail->From    = 'projects@codeuridea.com';
								$mail->FromName   = 'Advanced Micro Solutions';                         
								//$mail->SMTPSecure = 'tls';                    // Enable TLS encryption, `ssl` also accepted
								$mail->Port = 25;     

								//$mail->setFrom('projects@codeuridea.com', 'Shield Watch');
								$mail->addAddress($to, $username);     // Add a recipient
								#$mail->addReplyTo('info@example.com', 'Information');
								$mail->isHTML(true);                                  // Set email format to HTML
								$mail->Subject = $subject;
								#$mail->Body    = $message;
								$mail->MsgHTML($message);
								if(!$mail->send()) {
									//echo 'Message could not be sent.';
									//echo 'Mailer Error: ' . $mail->ErrorInfo;
									$ERR = acnt_no_user_response();	
									$output = _error_output_as_obj($ERR);	
								} else {
									//echo 'Message has been sent';
									$sucArr = array();
									$sucArr["id_user"] 	= $username;
									$sucArr["fullname"] = $user_data['s_first_name'].' '. $user_data['s_last_name'];
									$sucArr["email"] 	= $user_data['s_email'];							
									$output = _pwd_new_output_as_obj($sucArr);
								}
								
								// Mail it
								//@mail($to, $subject, $message, $headers);
								#@mail('mmondal@codeuridea.com', 'hi', 'hello');
							}
													
						}
						
						else
						{
							$ERR = acnt_no_email_response();	
							$output = _error_output_as_obj($ERR);				
						}
							
					}
					
				} // end else for username not exist...
				
			}
			else
			{
				$ERR = acnt_no_user_response();	
				$output = _error_output_as_obj($ERR);				
			}
			
			//just some dummy result
			/*return array(
			'id_user'=>1,
			'fullname'=>'John Reese',
			'email'=>'john@reese.com'
			);*/
			return $output;
			
	}	
	
	
	//change user account password function implementation 
	function changePassword($username, $password, $newpassword) {
			//should do some database query here
			$output = array(); $ERR = array(); $arr = array();
			$arr['username'] 			= $username;			
			$arr['password'] 			= $password;
			$arr['newpassword'] 		= $newpassword;
			
			$username 		= $arr['username'];
			$password 		= $arr['password'];
			$newpassword 	= $arr['newpassword'];			
			
			if($username!='' && $password!='')
			{
				$user_data = _info_by_userName_only($username);
				if(empty( $user_data )) {    // userName not exist...					
					$ERR = _error_username_failed_response();	
					$output = _error_output_as_obj($ERR);					
				}
				else
				{
					// username exist now check if the password match or not
					$pwddata = _info_by_userName_N_passWord($username, $password);					
					if(empty($pwddata )) // password does not match... 
					{    
						$ERR = acnt_pwd_no_match_response();	
						$output = _error_output_as_obj($ERR);
					}
					else // username & password match now update the other records if provided
					{
						// now check for new passowrd
						if($newpassword!='')
						{
							$msg = _password_validation($newpassword);							
							if($msg!='')
							{
								$ERR = _password_validation_error_response($msg);
								$output = _error_output_as_obj($ERR);
							}
							else
							{
								// perfect new password
								$updateArr = array(); $oauthArr = array();
								//$newArr['s_user_name'] = $oauthArr['s_username']	= $username;
								$updateArr['s_password']  = $oauthArr['s_password']	= get_salted_password($newpassword);// now update
								if(!empty($updateArr)){
									
									mysql_exc_qry("UPDATE ams_user SET s_password = '".$updateArr['s_password']."' WHERE  s_user_name= '".$username."' ");
									// update email in the oauth table also
									mysql_exc_qry("UPDATE oauth_users SET s_password='".$updateArr['s_password']."' WHERE  s_username= '".$username."' ");
									
									$sucArr = array();
									$sucArr["id_user"] 	= $username;
									$sucArr["fullname"] = $pwddata['s_first_name'].' '. $pwddata['s_last_name'];
									//$sucArr["email"] 	= $pwddata['s_email'];							
									$output = _pwd_changed_output_as_obj($sucArr);	
								}
						
							}
						}
						else
						{
							$ERR = _nwpwd_empty_response();	
							$output = _error_output_as_obj($ERR);
						}
						// now update
						
					}
					
					
				}
				
			}
			else
			{
				$ERR = acnt_no_user_pwd_response();	
				$output = _error_output_as_obj($ERR);				
			}
			
			//just some dummy result
			/*return array(
			'id_user'=>1,
			'fullname'=>'John Reese',
			'email'=>'john@reese.com'
			);*/
			return $output;
			
	}	
	
	
	//create user account function implementation 
	function createUserAccount($username, $password, $customername='', $companyname='', $companyfeinnumber='', $companyaddress='', $companycity='', $companystate='', $companyzip='', $companyphone='', $useremail='', $autoemail=true) {
			//should do some database query here
			$output = array(); $ERR = array(); $arr = array();
			$arr['username'] 			= $username;			
			$arr['password'] 			= $password;
			$arr['customername'] 		= $customername;
			$arr['companyname'] 		= $companyname;
			$arr['companyfeinnumber'] 	= $companyfeinnumber;
			$arr['companyaddress'] 		= $companyaddress;
			$arr['companycity'] 		= $companycity;
			$arr['companystate'] 		= $companystate;
			$arr['companyzip'] 			= $companyzip;
			$arr['companyphone'] 		= $companyphone;
			$arr['useremail'] 			= $useremail;
			$arr['autoemail'] 			= $autoemail;
			//i_auto_email
			$username = $arr['username'];
			$password = $arr['password'];
			
		
			if($username!='' && $password!='')
			{
				$user_data = _info_by_userName_only($username);
				
				if(empty( $user_data )) {    // userName not exist... 
					
					// Validate user name length // by JS 15 June 2017
					$username = trim($username);
					// minimum of 10 characters containing  atleast one upper case, one lower case, and one number
					$pattern = '/^.*(?=.{10,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/';
					#$password = 'asdadasWE0';
					$t = false;
					$t = preg_match($pattern,$password);
					$error_flag = true;
					if(strlen($username) < 6)
					{
						$error_flag = false;
						$ERR = acnt_username_invalid_response();	
						$output = _error_output_as_obj($ERR);
					}
					else if($t == false)
					{
						$error_flag = false;
						$ERR = acnt_password_invalid_response();	
						$output = _error_output_as_obj($ERR);
					}
					
					if($error_flag)
					{
						// entry new user data in ams_user table
						$newArr = array(); $oauthArr = array();
						$newArr['s_user_name'] = $oauthArr['s_username']	= $username;
						$newArr['s_password']  = $oauthArr['s_password']	= get_salted_password($password);
						if($arr['customername']!=''){
							$name = $arr['customername'];
							list($firstname, $lastname) 	= explode(' ', $name);
							$newArr['s_first_name'] 	= $firstname;
							$newArr['s_last_name'] 		= $lastname;
							$newArr['s_customer_name'] 	= $name;
						}
						if($arr['companyname']!=''){							
							$newArr['s_company_name'] 		= $arr['companyname'];
						}
						if($arr['companyfeinnumber']!=''){							
							$newArr['s_company_fein_number']	= $arr['companyfeinnumber'];
						}
						if($arr['companyaddress']!=''){							
							$newArr['s_company_address'] 	= $arr['companyaddress'];
						}
						if($arr['companycity']!=''){							
							$newArr['s_company_city'] 		= $arr['companycity'];
						}
						if($arr['companystate']!=''){							
							$newArr['s_company_state'] 		= $arr['companystate'];
						}
						if($arr['companyzip']!=''){							
							$newArr['s_company_zip'] 		= $arr['companyzip'];
						}
						if($arr['companyphone']!=''){							
							$newArr['s_company_phone'] 		= $arr['companyphone'];
						}
						if($arr['useremail']!=''){							
							$newArr['s_email'] 				= $arr['useremail'];
							$oauthArr['s_email'] 			= $arr['useremail'];
						}					
							
						if(!$arr['autoemail']){
							$newArr['i_auto_email'] = 2;													
						}
						
						
						$userInsert = mysql_insert_array('ams_user', $newArr);
						
						$i_pk = $userInsert['mysql_insert_id'];
								
						if($i_pk>0)
						{
							
							mysql_insert_array('oauth_users', $oauthArr);
							
							$sucArr = array();
							$sucArr["id_user"] 	= $username;
							$sucArr["fullname"] = $arr['customername'];
							$sucArr["email"] 	= $arr['useremail'];							
							$output = _acnt_success_output_as_obj($sucArr);							
						}
						else
						{
							$ERR = acnt_entry_failed_response();	
							$output = _error_output_as_obj($ERR);
						}
					}
					
				}
				else
				{
					// username exist now check if the password match or not
					$pwddata = _info_by_userName_N_passWord($username, $password);
					/*echo '<pre>';
					print_r($pwddata);
					echo '</pre>'; exit;*/
					
					if(empty($pwddata )) // password does not match... 
					{    
						$ERR = acnt_pwd_no_match_response();	
						$output = _error_output_as_obj($ERR);
					}
					else // username & password match now update the other records if provided
					{
						$updateArr = array();
						$sql ='';
						$sqlArr = array();
						if($arr['customername']!=''){
							$name = $arr['customername'];
							list($firstname, $lastname) 	= explode(' ', $name);
							$updateArr['s_first_name'] 		= $firstname;
							$updateArr['s_last_name'] 		= $lastname;
							$updateArr['s_customer_name'] 	= $name;
							$sqlArr[]=" s_first_name= '".addslashes($updateArr['s_first_name'])."', s_last_name= '".addslashes($updateArr['s_last_name'])."', s_customer_name= '".addslashes($updateArr['s_customer_name'])."' ";
							
						}
						if($arr['companyname']!=''){							
							$updateArr['s_company_name'] 		= $arr['companyname'];
							$sqlArr[]=" s_company_name= '".addslashes($updateArr['s_company_name'])."' ";
						}
						if($arr['companyfeinnumber']!=''){							
							$updateArr['s_company_fein_number']	= $arr['companyfeinnumber'];
							$sqlArr[]=" s_company_fein_number= '".addslashes($updateArr['s_company_fein_number'])."' ";
						}
						if($arr['companyaddress']!=''){							
							$updateArr['s_company_address'] 	= $arr['companyaddress'];
							$sqlArr[]=" s_company_address= '".addslashes($updateArr['s_company_address'])."' ";
						}
						if($arr['companycity']!=''){							
							$updateArr['s_company_city'] 		= $arr['companycity'];
							$sqlArr[]=" s_company_city= '".addslashes($updateArr['s_company_city'])."' ";
						}
						if($arr['companystate']!=''){							
							$updateArr['s_company_state'] 		= $arr['companystate'];
							$sqlArr[]=" s_company_state= '".addslashes($updateArr['s_company_state'])."' ";
						}
						if($arr['companyzip']!=''){							
							$updateArr['s_company_zip'] 		= $arr['companyzip'];
							$sqlArr[]=" s_company_zip= '".addslashes($updateArr['s_company_zip'])."' ";
						}
						if($arr['companyphone']!=''){							
							$updateArr['s_company_phone'] 		= $arr['companyphone'];
							$sqlArr[]=" s_company_phone= '".addslashes($updateArr['s_company_phone'])."' ";
						}
						if($arr['useremail']!=''){							
							$updateArr['s_email'] 				= $arr['useremail'];
							$sqlArr[]=" s_email= '".addslashes($updateArr['s_email'])."' ";
						}
						
						if(!$arr['autoemail']){
							$updateArr['i_auto_email'] = 2;
							$sqlArr[]=" i_auto_email = 2 ";							
						}
						
						$sql = implode(',', $sqlArr);
						
						// now update
						if(!empty($updateArr)){
							#mysql_update_array('ams_user', $updateArr, " s_user_name= '".$username."' ");
							$fsql = trim($sql,',');							
							if($fsql)
							{								
								mysql_exc_qry("UPDATE ams_user SET {$fsql} WHERE  s_user_name= '".$username."' ");
							}
							
							// update email in the oauth table also
							$oauthArr = array();
							if($arr['useremail']!=''){							
								$oauthArr['s_email']	= $arr['useremail'];
								//mysql_update_array('oauth_users', $oauthArr, " s_username= '".$username."' ");
								mysql_exc_qry("UPDATE oauth_users SET s_email='".addslashes($oauthArr['s_email'])."' WHERE  s_username= '".$username."' ");
							}
							
							$sucArr = array();
							$sucArr["id_user"] 	= $username;
							$sucArr["fullname"] = $arr['customername'];
							$sucArr["email"] 	= $arr['useremail'];							
							$output = _acnt_success_output_as_obj($sucArr);	
						}
						
					}
					
					
				}
				
			}
			else
			{
				$ERR = acnt_no_user_pwd_response();	
				$output = _error_output_as_obj($ERR);				
			}
			
			//just some dummy result
			/*return array(
			'id_user'=>1,
			'fullname'=>'John Reese',
			'email'=>'john@reese.com'
			);*/
			return $output;
			
	}	
	
	
	//datat transmit function implementation 
	function transmit($data) {
			//should do some database query here
			// first declare used variables
			$output = array(); $i_pk=0; $payeeFullArr = array(); $payeeOthersFullArr = array(); $payerValidationErrArr = array(); $payeeValidationErrArr = array();
			$payee2FullArr = array(); 
			$total_payer=0; $total_payee=0; $no_of_forms=0; $totalPrice=0; $ERR = array();
			$formTypeWithCountArr = array(); $cnt = 0;
			
			// .... ..... ..... ..... XML DATA PART START .... ..... ..... .....
			$xml = html_entity_decode(file_get_contents('php://input'));
			$xml = $data;			
			//$output['ResponseCode'] = 123;
			//$output['ResponseDetail'] = $xml;
		
			#return $xml;		
			$format= 'xml';			
			// get the userName & passWord
			preg_match_all('/<item>(.*?)<\/item>/s',$xml,$item);
			preg_match_all('/<userName>(.*?)<\/userName>/s',$item[1][0],$userName);
			preg_match_all('/<passWord>(.*?)<\/passWord>/s',$item[1][0],$passWord);
			preg_match_all('/<dataProcessFor>(.*?)<\/dataProcessFor>/s',$item[1][0],$dataProcessFor); // new added see@https://shieldwatch.teamwork.com/tasks/9355648
			//return '<pre>userName==>'.$userName[1][0].'+++passWord==>'.$passWord[1][0].'</pre>';
			$user = $userName[1][0]?$userName[1][0]:"";
			$pass = $passWord[1][0]?$passWord[1][0]:"";
			if($user!='' && $pass!='')
			{
				$user_data = _info_by_userName_N_passWord($user, $pass);
				$user_email = $user_data["s_email"];
				$auto_email_feature = $user_data["i_auto_email"];
				if(empty( $user_data )) {    // no valid userName & PassWord...  
					$ERR = form_name_N_pwd_error_response();
					$output = _error_output_as_obj($ERR);		
				}
				else
				{
					/******************* XML READING STARTS ********************/
					#preg_match_all('/<Company>(.*?)<\/Company>/s',$xml,$val);
					preg_match_all('/<Company FormType=(\'|\")(.*?)(\'|\")>(.*?)<\/Company>/s',$xml,$val); 
					#echo '<pre>'.print_r($val).'</pre>============</br>';
						
					
					$output='';
					$no_of_forms=0;
					$prev_form_id='';
					$total_payer = 0;
					$total_payee = 0;
					$own_payee = 0;
					$form_price = 0;
					$all='';
					$formId='';
					$payeeValidationErrArr = array();
					$payerValidationErrArr = array();
					$arr_1099 = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);
					//if(!empty($val[1])){
					if(!empty($val[4])){
						// start insert batch record
						
						//$batchId = genBatchNumber();	
						$batchId = _getLastBatchNumber(); // modified on 16 Nov see@ https://shieldwatch.teamwork.com/messages/575669?scrollTo=pmp1660076
						if($batchId)
						{
							$bArr = array();
							$bArr['s_batch_id'] = $batchId;
							$bArr['s_username'] = $user;
							//$bArr['s_dataProcessFor'] = trim($dataProcessFor)?trim($dataProcessFor):"electronic filling";
							$bArr['s_dataProcessFor'] = $dataProcessFor[1][0];
							$batchNoRet = mysql_insert_array('ams_batch_master', $bArr);
							//echo '*****<pre>'.print_r($batchNoRet).'</pre>';
						}
						
						
						foreach($val[4] as $key=>$cmp){
							
							//print_r($cmp);
							preg_match_all('/<PayerInfo>(.*?)<\/PayerInfo>/s',$cmp,$payer);
							//echo '*****<pre>'.print_r($payer).'</pre>';
							//print_r($payer[1]);
							// PAYER INFO STARTS
							preg_match_all('/<TIN>(.*?)<\/TIN>/s',$payer[1][0],$tin);
							preg_match_all('/<Year>(.*?)<\/Year>/s',$payer[1][0],$Year);
							preg_match_all('/<FormType>(.*?)<\/FormType>/s',$payer[1][0],$FormType);
							preg_match_all('/<TypeOfTIN>(.*?)<\/TypeOfTIN>/s',$payer[1][0],$TypeOfTIN);
							//preg_match_all('/<AmountCode>(.*?)<\/AmountCode>/s',$payer[1][0],$AmountCode);
							preg_match_all('/<TransferAgentIndicator>(.*?)<\/TransferAgentIndicator>/s',$payer[1][0],$TransferAgentIndicator);
							preg_match_all('/<CompanyName>(.*?)<\/CompanyName>/s',$payer[1][0],$CompanyName);
							preg_match_all('/<CompanyNameLine2>(.*?)<\/CompanyNameLine2>/s',$payer[1][0],$CompanyNameLine2);
							preg_match_all('/<CompanyAddress>(.*?)<\/CompanyAddress>/s',$payer[1][0],$CompanyAddress);
							preg_match_all('/<City>(.*?)<\/City>/s',$payer[1][0],$City);
							preg_match_all('/<State>(.*?)<\/State>/s',$payer[1][0],$State);
							preg_match_all('/<Zipcode>(.*?)<\/Zipcode>/s',$payer[1][0],$Zipcode);
							preg_match_all('/<Phone>(.*?)<\/Phone>/s',$payer[1][0],$Phone);
							//echo '*****<pre>'.print_r($FormType).'</pre>';
							//echo '*****tin:'.$tin[1][0].'**********<br>';
							$year = $Year[1][0];
							//$formId = getFormId($TypeOfTIN[1][0]); // get from formmaster tbl
							#$formId = getFormId($FormType[1][0]); // get from formmaster tbl 
							$formId = getFormId($val[2][$key]); // get from formmaster tbl 
							
							//$form_price = getFormPrice($val[2][$key]);
							//$totalPrice = $totalPrice + $form_price; // 12 Jan, 2016							
							//$totalPrice = $totalPrice; // 08 Feb, 2016
							$no_of_forms = $no_of_forms+1;
							if($prev_form_id!=$formId)
							{
								//$no_of_forms = $no_of_forms+1;
								$prev_form_id = $formId;
							}
							
							// New Array For Form Count 10 Feb, 2017 see@https://shieldwatch.teamwork.com/index.cfm#messages/616199 Message Posted On 9 Feb, 2017
							/*if(array_key_exists($formId, $formTypeWithCountArr))
							{
								$cnt = $formTypeWithCountArr[$formId];
								$formTypeWithCountArr[$formId] = $cnt + 1;
							}
							else
								$formTypeWithCountArr[$formId] = 1;*/
							
							
							$payerArr = array();
							$payerArr['e_record_type'] 								= 'A'; // payer records
							$payerArr['s_form_type'] 								= $formId;
							$payerArr['s_payer_tin'] 								= $tin[1][0];
							$payerArr['s_batch_code'] 								= $batchId;
							$payerArr['i_payment_year'] 							= $Year[1][0];
							$payerArr['s_type_of_return'] 							= $TypeOfTIN[1][0];
							//$payerArr['s_amount_codes'] 							= $AmountCode[1][0];
							$payerArr['s_first_payer_name_line'] 					= $CompanyName[1][0];
							$payerArr['s_second_payer_name_line'] 					= $CompanyNameLine2[1][0];
							$payerArr['s_payer_shipping_address'] 					= $CompanyAddress[1][0];
							$payerArr['s_payer_city'] 								= $City[1][0];
							$payerArr['s_payer_state'] 								= $State[1][0];
							$payerArr['s_payer_zip_code'] 							= $Zipcode[1][0];
							$payerArr['s_payers_telephone_number_and_extension']	= $Phone[1][0];
							//echo '*****<pre>'.print_r($payerArr).'</pre>';
							//if(!empty($payerArr) && $tin[1][0]!='')
							if(!empty($payerArr))
							{
								// start payer info validation
								$payer_val_msg = _chk_payer_validation($payerArr);
								if($payer_val_msg=='')
								{
									$payerFullArr[] = $payerArr;
								}
								else
								{
									$payerValidationErrArr[] = $payer_val_msg;
								}
								// not error in payer records
								
								if($payer_val_msg=='')
								{					
									$total_payer = $total_payer + 1;
									$payerInsRet= mysql_insert_array('ams_payer_info', $payerArr);
									//echo '*****<pre>'.print_r($payerInsRet).'</pre>';
									$i_ins = $payerInsRet['mysql_insert_id'];
									if($i_ins>0)
									{
										//preg_match_all('/<Recipient id=\'(.*?)\'>(.*?)<\/Recipient>/s',$cmp,$rec);
										preg_match_all('/<Recipient id=(\'|\")(.*?)(\'|\")>(.*?)<\/Recipient>/s',$cmp,$rec);
										//echo '<pre>'.print_r($rec).'</pre>';					
										//if(!empty($rec[2]) && $rec[2][0])
										if(!empty($rec[4]) && $rec[4][0])
										{
											foreach($rec[4] as $rmp)
											{
												//echo '*****<pre>'.print_r($rmp).'</pre>';	1099A
												preg_match_all('/<PayeeTIN>(.*?)<\/PayeeTIN>/s',$rmp,$PayeeTIN);							
												preg_match_all('/<PayeeAccount>(.*?)<\/PayeeAccount>/s',$rmp,$PayeeAccount);							
												preg_match_all('/<PayeeTypeOfTIN>(.*?)<\/PayeeTypeOfTIN>/s',$rmp,$PayeeTypeOfTIN);
												preg_match_all('/<PayeeName>(.*?)<\/PayeeName>/s',$rmp,$PayeeName);
												preg_match_all('/<PayeeName2>(.*?)<\/PayeeName2>/s',$rmp,$PayeeName2);
												preg_match_all('/<PayeeAddr>(.*?)<\/PayeeAddr>/s',$rmp,$PayeeAddr);
												preg_match_all('/<PayeeCity>(.*?)<\/PayeeCity>/s',$rmp,$PayeeCity);
												preg_match_all('/<PayeeState>(.*?)<\/PayeeState>/s',$rmp,$PayeeState);
												preg_match_all('/<PayeeZipcode>(.*?)<\/PayeeZipcode>/s',$rmp,$PayeeZipcode);
												preg_match_all('/<Box1>(.*?)<\/Box1>/s',$rmp,$Box1);
												preg_match_all('/<Box2>(.*?)<\/Box2>/s',$rmp,$Box2);
												preg_match_all('/<Box3>(.*?)<\/Box3>/s',$rmp,$Box3);
												preg_match_all('/<Box4>(.*?)<\/Box4>/s',$rmp,$Box4);
												preg_match_all('/<Box5>(.*?)<\/Box5>/s',$rmp,$Box5);
												preg_match_all('/<Box6>(.*?)<\/Box6>/s',$rmp,$Box6);
												preg_match_all('/<Box7>(.*?)<\/Box7>/s',$rmp,$Box7);
												preg_match_all('/<Box8>(.*?)<\/Box8>/s',$rmp,$Box8);
												preg_match_all('/<Box9>(.*?)<\/Box9>/s',$rmp,$Box9);
												preg_match_all('/<Box10>(.*?)<\/Box10>/s',$rmp,$Box10);
												preg_match_all('/<Box11>(.*?)<\/Box11>/s',$rmp,$Box11);
												preg_match_all('/<Box12>(.*?)<\/Box12>/s',$rmp,$Box12);
												preg_match_all('/<Box13>(.*?)<\/Box13>/s',$rmp,$Box13);
												preg_match_all('/<Box14>(.*?)<\/Box14>/s',$rmp,$Box14);
												preg_match_all('/<Box15>(.*?)<\/Box15>/s',$rmp,$Box15);
												preg_match_all('/<Box16>(.*?)<\/Box16>/s',$rmp,$Box16);	
												preg_match_all('/<AcctNumber>(.*?)<\/AcctNumber>/s',$rmp,$AcctNumber);
												
												// other 1099 series forms starts below
												
												if(in_array($formId, $arr_1099))	
												{
													// https://shieldwatch.teamwork.com/#messages/665695 commented on 20July By Wes
													if($formId == 1)
													{
														preg_match_all('/<BalOfPrincipal>(.*?)<\/BalOfPrincipal>/s',$rmp,$Box2);
														preg_match_all('/<FairMktProperty>(.*?)<\/FairMktProperty>/s',$rmp,$Box4);
													}
													preg_match_all('/<DateofAcquisition>(.*?)<\/DateofAcquisition>/s',$rmp,$DateofAcquisition);
													preg_match_all('/<LongTermLossInd>(.*?)<\/LongTermLossInd>/s',$rmp,$LongTermLossInd);
													preg_match_all('/<CusipNumber>(.*?)<\/CusipNumber>/s',$rmp,$CusipNumber);
													preg_match_all('/<StocksBonds>(.*?)<\/StocksBonds>/s',$rmp,$StocksBonds);
													preg_match_all('/<NetProceedsInd>(.*?)<\/NetProceedsInd>/s',$rmp,$NetProceedsInd);
													preg_match_all('/<CostOrOtherBasis>(.*?)<\/CostOrOtherBasis>/s',$rmp,$CostOrOtherBasis);
													preg_match_all('/<WCDCode>(.*?)<\/WCDCode>/s',$rmp,$WCDCode);
													preg_match_all('/<FITWithh>(.*?)<\/FITWithh>/s',$rmp,$s_FITWithh);
													preg_match_all('/<BarteringAmt>(.*?)<\/BarteringAmt>/s',$rmp,$BarteringAmt);
													if($formId == 2)
													{
														preg_match_all('/<ProceedsFwdContracts>(.*?)<\/ProceedsFwdContracts>/s',$rmp,$Box2);
														preg_match_all('/<CostOrOtherBasis>(.*?)<\/CostOrOtherBasis>/s',$rmp,$Box3);
														preg_match_all('/<FederalIncTaxWtHeld>(.*?)<\/FederalIncTaxWtHeld>/s',$rmp,$Box4);
														preg_match_all('/<AdjustmentAmt>(.*?)<\/AdjustmentAmt>/s',$rmp,$Box5);
														preg_match_all('/<BarteringAmt>(.*?)<\/BarteringAmt>/s',$rmp,$Box7);
														preg_match_all('/<ProfitLossRealized>(.*?)<\/ProfitLossRealized>/s',$rmp,$Box9);
														preg_match_all('/<ProfitLossUnrealizedOne>(.*?)<\/ProfitLossUnrealizedOne>/s',$rmp,$Box10);
														preg_match_all('/<ProfitLossUnrealizedTwo>(.*?)<\/ProfitLossUnrealizedTwo>/s',$rmp,$Box11);
														preg_match_all('/<AggProfitLoss>(.*?)<\/AggProfitLoss>/s',$rmp,$Box12);
													}
													
													preg_match_all('/<DateCanceled>(.*?)<\/DateCanceled>/s',$rmp,$DateCanceled);
													preg_match_all('/<AmtOfDebtCanceled>(.*?)<\/AmtOfDebtCanceled>/s',$rmp,$AmtOfDebtCanceled);
													preg_match_all('/<InterestIncluded>(.*?)<\/InterestIncluded>/s',$rmp,$InterestIncluded);
													preg_match_all('/<DebtDescrOne>(.*?)<\/DebtDescrOne>/s',$rmp,$DebtDescrOne);
													preg_match_all('/<BorrowerLiabInd>(.*?)<\/BorrowerLiabInd>/s',$rmp,$BorrowerLiabInd);
													preg_match_all('/<IdentifiableEventCode>(.*?)<\/IdentifiableEventCode>/s',$rmp,$IdentifiableEventCode);
													if($formId == 3)
													{
														preg_match_all('/<AmtOfDebtDischarged>(.*?)<\/AmtOfDebtDischarged>/s',$rmp,$Box2);
														preg_match_all('/<InterestIncluded>(.*?)<\/InterestIncluded>/s',$rmp,$Box3);
														preg_match_all('/<FairMktProperty>(.*?)<\/FairMktProperty>/s',$rmp,$Box4);
														preg_match_all('/<AggregateAmtRec>(.*?)<\/AggregateAmtRec>/s',$rmp,$Box2);														
													}
													
													preg_match_all('/<DateofSale>(.*?)<\/DateofSale>/s',$rmp,$DateofSale);
													preg_match_all('/<NumSharesExchanged>(.*?)<\/NumSharesExchanged>/s',$rmp,$NumSharesExchanged);
													preg_match_all('/<ClassesStockExchanged>(.*?)<\/ClassesStockExchanged>/s',$rmp,$ClassesStockExchanged);
													preg_match_all('/<AggregateAmtRec>(.*?)<\/AggregateAmtRec>/s',$rmp,$AggregateAmtRec);
													if($formId == 4)
													{
														preg_match_all('/<AggregateAmtRec>(.*?)<\/AggregateAmtRec>/s',$rmp,$Box2);														
													}
													
													preg_match_all('/<ForeignCountryOrUSPoss>(.*?)<\/ForeignCountryOrUSPoss>/s',$rmp,$ForeignCountryOrUSPoss);
													preg_match_all('/<OrdinaryDiv>(.*?)<\/OrdinaryDiv>/s',$rmp,$OrdinaryDiv);
													preg_match_all('/<QualifiedDiv>(.*?)<\/QualifiedDiv>/s',$rmp,$QualifiedDiv);
													preg_match_all('/<NonTaxDist>(.*?)<\/NonTaxDist>/s',$rmp,$NonTaxDist);
													preg_match_all('/<InvestmentExp>(.*?)<\/InvestmentExp>/s',$rmp,$InvestmentExp);
													preg_match_all('/<ForeignTaxPaid>(.*?)<\/ForeignTaxPaid>/s',$rmp,$ForeignTaxPaid);
													preg_match_all('/<CashLiquidDistr>(.*?)<\/CashLiquidDistr>/s',$rmp,$CashLiquidDistr);
													preg_match_all('/<SpecPrivateActivityBondInterestDiv>(.*?)<\/SpecPrivateActivityBondInterestDiv>/s',$rmp,$SpecPrivateActivityBondInterestDiv);													
													if($formId == 5)
													{
														preg_match_all('/<OrdinaryDiv>(.*?)<\/OrdinaryDiv>/s',$rmp,$Box1);												
														preg_match_all('/<QualifiedDiv>(.*?)<\/QualifiedDiv>/s',$rmp,$Box2)	;											
														preg_match_all('/<TotCapGainDistr>(.*?)<\/TotCapGainDistr>/s',$rmp,$Box3);
														preg_match_all('/<UnRecapturedGain>(.*?)<\/UnRecapturedGain>/s',$rmp,$Box6);											
														preg_match_all('/<SectionGain>(.*?)<\/SectionGain>/s',$rmp,$Box7);											
														preg_match_all('/<CollectiblesGain>(.*?)<\/CollectiblesGain>/s',$rmp,$Box8);											
														preg_match_all('/<NonDivDistr>(.*?)<\/NonDivDistr>/s',$rmp,$Box9);											
														preg_match_all('/<FederalIncTaxWtHeld>(.*?)<\/FederalIncTaxWtHeld>/s',$rmp,$Box10);											
														preg_match_all('/<InvestmentExp>(.*?)<\/InvestmentExp>/s',$rmp,$Box11);											
														preg_match_all('/<ForeignTaxPaid>(.*?)<\/ForeignTaxPaid>/s',$rmp,$Box12);											
														preg_match_all('/<CashLiquidDistr>(.*?)<\/CashLiquidDistr>/s',$rmp,$Box13);											
														preg_match_all('/<NonCashLiquidDistr>(.*?)<\/NonCashLiquidDistr>/s',$rmp,$Box14);											
														preg_match_all('/<ExemptInterestDiv>(.*?)<\/ExemptInterestDiv>/s',$rmp,$Box15);											
														preg_match_all('/<SpecPrivateActivityBondInterestDiv>(.*?)<\/SpecPrivateActivityBondInterestDiv>/s',$rmp,$Box16);											
													}
													
													preg_match_all('/<StateLocalRefund>(.*?)<\/StateLocalRefund>/s',$rmp,$StateLocalRefund);
													preg_match_all('/<RefundTaxYr>(.*?)<\/RefundTaxYr>/s',$rmp,$RefundTaxYr);
													preg_match_all('/<TaxableGrants>(.*?)<\/TaxableGrants>/s',$rmp,$TaxableGrants);
													preg_match_all('/<MarketGain>(.*?)<\/MarketGain>/s',$rmp,$MarketGain);
													preg_match_all('/<PayersRTN>(.*?)<\/PayersRTN>/s',$rmp,$PayersRTN);
													preg_match_all('/<TaxExemptBondCusipNum>(.*?)<\/TaxExemptBondCusipNum>/s',$rmp,$TaxExemptBondCusipNum);
													preg_match_all('/<InterestIncome>(.*?)<\/InterestIncome>/s',$rmp,$InterestIncome);
													preg_match_all('/<EarlyWithdrawal>(.*?)<\/EarlyWithdrawal>/s',$rmp,$EarlyWithdrawal);
													preg_match_all('/<IntOnUSTreas>(.*?)<\/IntOnUSTreas>/s',$rmp,$IntOnUSTreas);
													preg_match_all('/<InvestmentExpenses>(.*?)<\/InvestmentExpenses>/s',$rmp,$InvestmentExpenses);
													preg_match_all('/<TaxExemptInterest>(.*?)<\/TaxExemptInterest>/s',$rmp,$TaxExemptInterest);
													if($formId == 6)
													{
														preg_match_all('/<UnemploymentComp>(.*?)<\/UnemploymentComp>/s',$rmp,$Box1);												
														preg_match_all('/<StateLocalRefund>(.*?)<\/StateLocalRefund>/s',$rmp,$Box2)	;											
														preg_match_all('/<FederalIncTaxWtHeld>(.*?)<\/FederalIncTaxWtHeld>/s',$rmp,$Box4);
														preg_match_all('/<RTAAProg>(.*?)<\/RTAAProg>/s',$rmp,$Box5);											
														preg_match_all('/<TaxableGrants>(.*?)<\/TaxableGrants>/s',$rmp,$Box6);											
														preg_match_all('/<AgricultureAmt>(.*?)<\/AgricultureAmt>/s',$rmp,$Box7);											
														preg_match_all('/<MarketGain>(.*?)<\/MarketGain>/s',$rmp,$Box9);		
													}
													
													if($formId == 7)
													{
														preg_match_all('/<InterestIncomeNotIncl>(.*?)<\/InterestIncomeNotIncl>/s',$rmp,$Box1);												
														preg_match_all('/<EarlyWithdrawal>(.*?)<\/EarlyWithdrawal>/s',$rmp,$Box2)	;											
														preg_match_all('/<IntOnUSTreas>(.*?)<\/IntOnUSTreas>/s',$rmp,$Box3);
														preg_match_all('/<FedIncomeWtHeld>(.*?)<\/FedIncomeWtHeld>/s',$rmp,$Box4);											
														preg_match_all('/<InvestmentExpenses>(.*?)<\/InvestmentExpenses>/s',$rmp,$Box5);											
														preg_match_all('/<ForeignTaxPaid>(.*?)<\/ForeignTaxPaid>/s',$rmp,$Box6);											
														preg_match_all('/<TaxExemptInterest>(.*?)<\/TaxExemptInterest>/s',$rmp,$Box8);											
														preg_match_all('/<SpecPvtBond>(.*?)<\/SpecPvtBond>/s',$rmp,$Box9);		
														preg_match_all('/<MarketDiscount>(.*?)<\/MarketDiscount>/s',$rmp,$Box10);		
														preg_match_all('/<BondPremium>(.*?)<\/BondPremium>/s',$rmp,$Box11);		
														preg_match_all('/<BondPremiumTaxExempt>(.*?)<\/BondPremiumTaxExempt>/s',$rmp,$Box13);		
													}
													
													preg_match_all('/<GrossLTBenefitsPd>(.*?)<\/GrossLTBenefitsPd>/s',$rmp,$GrossLTBenefitsPd);
													preg_match_all('/<AccelDeathBenPd>(.*?)<\/AccelDeathBenPd>/s',$rmp,$AccelDeathBenPd);
													preg_match_all('/<ReimbursedAmtInd>(.*?)<\/ReimbursedAmtInd>/s',$rmp,$ReimbursedAmtInd);
													preg_match_all('/<InsuredsSSN>(.*?)<\/InsuredsSSN>/s',$rmp,$InsuredsSSN);
													preg_match_all('/<InsuredsNameOne>(.*?)<\/InsuredsNameOne>/s',$rmp,$InsuredsNameOne);
													preg_match_all('/<InsuredsStreetAddr>(.*?)<\/InsuredsStreetAddr>/s',$rmp,$InsuredsStreetAddr);
													preg_match_all('/<InsuredsCity>(.*?)<\/InsuredsCity>/s',$rmp,$InsuredsCity);
													preg_match_all('/<InsuredsState>(.*?)<\/InsuredsState>/s',$rmp,$InsuredsState);
													preg_match_all('/<InsuredsZip>(.*?)<\/InsuredsZip>/s',$rmp,$InsuredsZip);
													preg_match_all('/<ChronicallyillInd>(.*?)<\/ChronicallyillInd>/s',$rmp,$ChronicallyillInd);
													preg_match_all('/<DateCertified>(.*?)<\/DateCertified>/s',$rmp,$DateCertified);
													if($formId == 9)
													{
														preg_match_all('/<RentsAmt>(.*?)<\/RentsAmt>/s',$rmp,$Box1);												
														preg_match_all('/<GrossLTBenefitsPd>(.*?)<\/GrossLTBenefitsPd>/s',$rmp,$Box1);												
														preg_match_all('/<AccelDeathBenPd>(.*?)<\/AccelDeathBenPd>/s',$rmp,$Box2);		
													}
													
													preg_match_all('/<StateNameOne>(.*?)<\/StateNameOne>/s',$rmp,$s_StateNameOne);
													preg_match_all('/<StateIdOne>(.*?)<\/StateIdOne>/s',$rmp,$s_StateIdOne);
													preg_match_all('/<OtherIncome>(.*?)<\/OtherIncome>/s',$rmp,$OtherIncome);
													preg_match_all('/<NonEmpComp>(.*?)<\/NonEmpComp>/s',$rmp,$NonEmpComp);
													preg_match_all('/<GrossAttorneyProc>(.*?)<\/GrossAttorneyProc>/s',$rmp,$GrossAttorneyProc);
													preg_match_all('/<StateTaxWithhOne>(.*?)<\/StateTaxWithhOne>/s',$rmp,$s_StateTaxWithhOne);
													preg_match_all('/<StateIncomeOne>(.*?)<\/StateIncomeOne>/s',$rmp,$s_StateIncomeOne);
													preg_match_all('/<Form1099MISCAgencies>(.*?)<\/Form1099MISCAgencies>/s',$rmp,$Form1099MISCAgencies);
													if($formId == 10)
													{
														preg_match_all('/<RentsAmt>(.*?)<\/RentsAmt>/s',$rmp,$Box1);												
														preg_match_all('/<RoyaltiesAmt>(.*?)<\/RoyaltiesAmt>/s',$rmp,$Box2);												
														preg_match_all('/<OtherIncome>(.*?)<\/OtherIncome>/s',$rmp,$Box3);		
														preg_match_all('/<FederalIncTaxWtHeld>(.*?)<\/FederalIncTaxWtHeld>/s',$rmp,$Box4);		
														preg_match_all('/<FishingBoatProceeds>(.*?)<\/FishingBoatProceeds>/s',$rmp,$Box5);		
														preg_match_all('/<MedicalHealthAmt>(.*?)<\/MedicalHealthAmt>/s',$rmp,$Box6);		
														preg_match_all('/<NonEmpComp>(.*?)<\/NonEmpComp>/s',$rmp,$Box7);		
														preg_match_all('/<SubPayDivInterest>(.*?)<\/SubPayDivInterest>/s',$rmp,$Box8);		
														preg_match_all('/<CropInsuranceProc>(.*?)<\/CropInsuranceProc>/s',$rmp,$Box10);		
														preg_match_all('/<ExcessGoldenParaAmt>(.*?)<\/ExcessGoldenParaAmt>/s',$rmp,$Box11);		
														preg_match_all('/<GrossProcAttorney>(.*?)<\/GrossProcAttorney>/s',$rmp,$Box12);		
														preg_match_all('/<Sec409ADeferrals>(.*?)<\/Sec409ADeferrals>/s',$rmp,$Box13);		
														preg_match_all('/<Sec409AIncome>(.*?)<\/Sec409AIncome>/s',$rmp,$Box14);		
													}
																										
													preg_match_all('/<OIDForThisYrAmt>(.*?)<\/OIDForThisYrAmt>/s',$rmp,$OIDForThisYrAmt);
													preg_match_all('/<OtherPeriodicInt>(.*?)<\/OtherPeriodicInt>/s',$rmp,$OtherPeriodicInt);
													preg_match_all('/<AcquisitionPremium>(.*?)<\/AcquisitionPremium>/s',$rmp,$AcquisitionPremium);
													preg_match_all('/<DescrOne>(.*?)<\/DescrOne>/s',$rmp,$DescrOne);
													preg_match_all('/<DescrTwo>(.*?)<\/DescrTwo>/s',$rmp,$DescrTwo);
													if($formId == 11)
													{
														preg_match_all('/<OrgIssueDiscount>(.*?)<\/OrgIssueDiscount>/s',$rmp,$Box1);												
														preg_match_all('/<OtherPeriodicInt>(.*?)<\/OtherPeriodicInt>/s',$rmp,$Box2);												
														preg_match_all('/<EarlyWithdrawal>(.*?)<\/EarlyWithdrawal>/s',$rmp,$Box3);		
														preg_match_all('/<FederalIncTaxWtHeld>(.*?)<\/FederalIncTaxWtHeld>/s',$rmp,$Box4);	
														preg_match_all('/<OrgIssueDiscountOnUSTreas>(.*?)<\/OrgIssueDiscountOnUSTreas>/s',$rmp,$Box6);		
														preg_match_all('/<InvestmentExpenses>(.*?)<\/InvestmentExpenses>/s',$rmp,$Box7);	
														preg_match_all('/<MarketDiscount>(.*?)<\/MarketDiscount>/s',$rmp,$Box10);		
														preg_match_all('/<AcquisitionPremium>(.*?)<\/AcquisitionPremium>/s',$rmp,$Box11);	
													}
													
													preg_match_all('/<NonPatrDistrib>(.*?)<\/NonPatrDistrib>/s',$rmp,$NonPatrDistrib);
													preg_match_all('/<RedemptionOfNonQualAmt>(.*?)<\/RedemptionOfNonQualAmt>/s',$rmp,$RedemptionOfNonQualAmt);
													preg_match_all('/<OtherCredits>(.*?)<\/OtherCredits>/s',$rmp,$OtherCredits);
													preg_match_all('/<InvestmentCredit>(.*?)<\/InvestmentCredit>/s',$rmp,$InvestmentCredit);
													preg_match_all('/<WorkOppCredit>(.*?)<\/WorkOppCredit>/s',$rmp,$WorkOppCredit);
													if($formId == 12)
													{
														preg_match_all('/<PatronageDiv>(.*?)<\/PatronageDiv>/s',$rmp,$Box1);												
														preg_match_all('/<NonPatrDistrib>(.*?)<\/NonPatrDistrib>/s',$rmp,$Box2);												
														preg_match_all('/<PerUnitRetainAlloc>(.*?)<\/PerUnitRetainAlloc>/s',$rmp,$Box3);		
														preg_match_all('/<FederalIncTaxWtHeld>(.*?)<\/FederalIncTaxWtHeld>/s',$rmp,$Box4);	
														preg_match_all('/<RedemptionOfNonQualAmt>(.*?)<\/RedemptionOfNonQualAmt>/s',$rmp,$Box5);		
														preg_match_all('/<DeductionDomesticProdInc>(.*?)<\/DeductionDomesticProdInc>/s',$rmp,$Box6);	
														preg_match_all('/<InvestmentCredit>(.*?)<\/InvestmentCredit>/s',$rmp,$Box7);	
														preg_match_all('/<WorkOppCredit>(.*?)<\/WorkOppCredit>/s',$rmp,$Box8);		
														preg_match_all('/<PatronAMTAdjust>(.*?)<\/PatronAMTAdjust>/s',$rmp,$Box9);		
														preg_match_all('/<PassThrCreditDeduct>(.*?)<\/PassThrCreditDeduct>/s',$rmp,$Box10);	
													}
													
													preg_match_all('/<GrossDistrib>(.*?)<\/GrossDistrib>/s',$rmp,$GrossDistrib);
													preg_match_all('/<Earnings>(.*?)<\/Earnings>/s',$rmp,$Earnings);
													preg_match_all('/<Basis>(.*?)<\/Basis>/s',$rmp,$Basis);
													preg_match_all('/<TrustToTrustRolloverInd>(.*?)<\/TrustToTrustRolloverInd>/s',$rmp,$TrustToTrustRolloverInd);
													preg_match_all('/<PrivateInd>(.*?)<\/PrivateInd>/s',$rmp,$PrivateInd);
													if($formId == 13)
													{
														preg_match_all('/<GrossDistrib>(.*?)<\/GrossDistrib>/s',$rmp,$Box1);												
														preg_match_all('/<Earnings>(.*?)<\/Earnings>/s',$rmp,$Box2);												
														preg_match_all('/<Basis>(.*?)<\/Basis>/s',$rmp,$Box3);		
													}
													
													preg_match_all('/<WrongAmountOrFiling>(.*?)<\/WrongAmountOrFiling>/s',$rmp,$WrongAmountOrFiling);
													preg_match_all('/<DistributionCode>(.*?)<\/DistributionCode>/s',$rmp,$DistributionCode);
													preg_match_all('/<OtherPercent>(.*?)<\/OtherPercent>/s',$rmp,$OtherPercent);
													preg_match_all('/<GrossDistribution>(.*?)<\/GrossDistribution>/s',$rmp,$GrossDistribution);
													preg_match_all('/<TaxableAmt>(.*?)<\/TaxableAmt>/s',$rmp,$TaxableAmt);
													preg_match_all('/<Other>(.*?)<\/Other>/s',$rmp,$s_Other);
													preg_match_all('/<StateDistribOne>(.*?)<\/StateDistribOne>/s',$rmp,$StateDistribOne);
													preg_match_all('/<DateOfClosing>(.*?)<\/DateOfClosing>/s',$rmp,$DateOfClosing);
													preg_match_all('/<GrossProceeds>(.*?)<\/GrossProceeds>/s',$rmp,$GrossProceeds);
													preg_match_all('/<DescrThree>(.*?)<\/DescrThree>/s',$rmp,$DescrThree);
													if($formId == 14)
													{
														preg_match_all('/<GrossDistribution>(.*?)<\/GrossDistribution>/s',$rmp,$Box1);												
														preg_match_all('/<TaxableAmt>(.*?)<\/TaxableAmt>/s',$rmp,$Box2);												
														preg_match_all('/<CapitailGain>(.*?)<\/CapitailGain>/s',$rmp,$Box3);		
														preg_match_all('/<FederalIncTaxWtHeld>(.*?)<\/FederalIncTaxWtHeld>/s',$rmp,$Box4);	
														preg_match_all('/<EmplContribution>(.*?)<\/EmplContribution>/s',$rmp,$Box5);		
														preg_match_all('/<NetUnrealApprEmpSecurity>(.*?)<\/NetUnrealApprEmpSecurity>/s',$rmp,$Box6);	
														preg_match_all('/<OtherAmt>(.*?)<\/OtherAmt>/s',$rmp,$Box8);		
														preg_match_all('/<TotalEmpContribution>(.*?)<\/TotalEmpContribution>/s',$rmp,$Box9);		
														preg_match_all('/<TradDistribution>(.*?)<\/TradDistribution>/s',$rmp,$Box10);		
														preg_match_all('/<AmtAllocableIRR>(.*?)<\/AmtAllocableIRR>/s',$rmp,$Box11);		
													}
													
													if($formId == 15)
													{												
														preg_match_all('/<GrossProceeds>(.*?)<\/GrossProceeds>/s',$rmp,$Box2);												
														preg_match_all('/<BuyerRealEstTax>(.*?)<\/BuyerRealEstTax>/s',$rmp,$Box5);		
													}
												}
												
												// other 1099 series forms
												
												// for 5498 series forms		
												if($formId ==17 || $formId == 18 || $formId == 19 )	
												{												
													preg_match_all('/<EmployeeContrib>(.*?)<\/EmployeeContrib>/s',$rmp,$EmployeeContrib);	
													preg_match_all('/<TotalContribReturnYr>(.*?)<\/TotalContribReturnYr>/s',$rmp,$TotalContribReturnYr);	
													preg_match_all('/<FairMarketValue>(.*?)<\/FairMarketValue>/s',$rmp,$FairMarketValue);	
													preg_match_all('/<ArcherMSAInd>(.*?)<\/ArcherMSAInd>/s',$rmp,$ArcherMSAInd);	
													preg_match_all('/<CoverdellESAContribAmt>(.*?)<\/CoverdellESAContribAmt>/s',$rmp,$CoverdellESAContribAmt);
												}
												
												// for 5498 series forms	
												
												// for 1098 series forms	
												if($formId ==20 || $formId == 21 || $formId == 22 || $formId == 23 || $formId == 24 )	
												{				
													preg_match_all('/<MortgageInt>(.*?)<\/MortgageInt>/s',$rmp,$MortgageInt);	
													preg_match_all('/<PointsInDollarsAmt>(.*?)<\/PointsInDollarsAmt>/s',$rmp,$PointsInDollarsAmt);	
													preg_match_all('/<RefundOfOverpaidInt>(.*?)<\/RefundOfOverpaidInt>/s',$rmp,$RefundOfOverpaidInt);	
													preg_match_all('/<DateOfContribution>(.*?)<\/DateOfContribution>/s',$rmp,$DateOfContribution);	
													preg_match_all('/<Year>(.*?)<\/Year>/s',$rmp,$Year);										
													preg_match_all('/<Make>(.*?)<\/Make>/s',$rmp,$Make);										
													preg_match_all('/<Model>(.*?)<\/Model>/s',$rmp,$Model);										
													preg_match_all('/<IDNumber>(.*?)<\/IDNumber>/s',$rmp,$IDNumber);										
													preg_match_all('/<LessFMVInd>(.*?)<\/LessFMVInd>/s',$rmp,$LessFMVInd);										
													preg_match_all('/<ProvideGoodsSvcsInExchInd>(.*?)<\/ProvideGoodsSvcsInExchInd>/s',$rmp,$ProvideGoodsSvcsInExchInd);										
													preg_match_all('/<ValueOfGoodsAndSvcsProvided>(.*?)<\/ValueOfGoodsAndSvcsProvided>/s',$rmp,$ValueOfGoodsAndSvcsProvided);										
													preg_match_all('/<DescrGoodsSvcsOne>(.*?)<\/DescrGoodsSvcsOne>/s',$rmp,$DescrGoodsSvcsOne);										
													preg_match_all('/<IntangibleReligiousBenefitsCk>(.*?)<\/IntangibleReligiousBenefitsCk>/s',$rmp,$IntangibleReligiousBenefitsCk);										
													preg_match_all('/<StudentLoanInt>(.*?)<\/StudentLoanInt>/s',$rmp,$StudentLoanInt);	
												}									
												
												// for 1098 series forms												
												
												// W2 Form Series
												if($formId == 25 || $formId == 26 || $formId == 27)
												{
													// W2G form starts												
													preg_match_all('/<TypeOfWagerCode>(.*?)<\/TypeOfWagerCode>/s',$rmp,$TypeOfWagerCode);	
													preg_match_all('/<TypeOfWagerCategory>(.*?)<\/TypeOfWagerCategory>/s',$rmp,$TypeOfWagerCategory);	
													preg_match_all('/<DateWon>(.*?)<\/DateWon>/s',$rmp,$DateWon);	
													preg_match_all('/<GrossWinnings>(.*?)<\/GrossWinnings>/s',$rmp,$GrossWinnings);	
													preg_match_all('/<FITWithh>(.*?)<\/FITWithh>/s',$rmp,$FITWithh);	
													preg_match_all('/<StateNameOne>(.*?)<\/StateNameOne>/s',$rmp,$StateNameOne);	
													preg_match_all('/<StateIdOne>(.*?)<\/StateIdOne>/s',$rmp,$StateIdOne);	
													preg_match_all('/<StateTaxWithhOne>(.*?)<\/StateTaxWithhOne>/s',$rmp,$StateTaxWithhOne);	
													preg_match_all('/<StateWinningsOne>(.*?)<\/StateWinningsOne>/s',$rmp,$StateWinningsOne);								
													// W2G form ends	
													
													// W2 form starts												
													preg_match_all('/<EmploymentType>(.*?)<\/EmploymentType>/s',$rmp,$EmploymentType);	
													preg_match_all('/<Box14TextOne>(.*?)<\/Box14TextOne>/s',$rmp,$Box14TextOne);	
													preg_match_all('/<Code_a>(.*?)<\/Code_a>/s',$rmp,$Code_a);	
													preg_match_all('/<Amt_a>(.*?)<\/Amt_a>/s',$rmp,$Amt_a);	
													preg_match_all('/<StatutoryInd>(.*?)<\/StatutoryInd>/s',$rmp,$StatutoryInd);	
													preg_match_all('/<RetirementPlanInd>(.*?)<\/RetirementPlanInd>/s',$rmp,$RetirementPlanInd);	
													preg_match_all('/<ThirdPartySickPayInd>(.*?)<\/ThirdPartySickPayInd>/s',$rmp,$ThirdPartySickPayInd);	
													preg_match_all('/<W2ControlNumber>(.*?)<\/W2ControlNumber>/s',$rmp,$W2ControlNumber);	
													preg_match_all('/<MedicareWithh>(.*?)<\/MedicareWithh>/s',$rmp,$MedicareWithh);								
													preg_match_all('/<MedWagesAndTips>(.*?)<\/MedWagesAndTips>/s',$rmp,$MedWagesAndTips);								
													preg_match_all('/<SocSecWages>(.*?)<\/SocSecWages>/s',$rmp,$SocSecWages);								
													preg_match_all('/<SocSecWithh>(.*?)<\/SocSecWithh>/s',$rmp,$SocSecWithh);								
													preg_match_all('/<StateWagesTipsEtcOne>(.*?)<\/StateWagesTipsEtcOne>/s',$rmp,$StateWagesTipsEtcOne);								
													preg_match_all('/<WagesTipsOtherComp>(.*?)<\/WagesTipsOtherComp>/s',$rmp,$WagesTipsOtherComp);								
													// W2 form ends		
													
													// W2C form starts											
													preg_match_all('/<YearFormCorrected>(.*?)<\/YearFormCorrected>/s',$rmp,$YearFormCorrected);	
													preg_match_all('/<CorrectedNameInd>(.*?)<\/CorrectedNameInd>/s',$rmp,$CorrectedNameInd);	
													preg_match_all('/<EmployeesIncorrectSSN>(.*?)<\/EmployeesIncorrectSSN>/s',$rmp,$EmployeesIncorrectSSN);	
													preg_match_all('/<EmployeesFirstNamePreviouslyReported>(.*?)<\/EmployeesFirstNamePreviouslyReported>/s',$rmp,$EmployeesFirstNamePreviouslyReported);	
													preg_match_all('/<EmployeesMiddleInitialPreviouslyReported>(.*?)<\/EmployeesMiddleInitialPreviouslyReported>/s',$rmp,$EmployeesMiddleInitialPreviouslyReported);	
													preg_match_all('/<EmployeesLastNamePreviouslyReported>(.*?)<\/EmployeesLastNamePreviouslyReported>/s',$rmp,$EmployeesLastNamePreviouslyReported);	
													preg_match_all('/<EmploymentTypePreviouslyReported>(.*?)<\/EmploymentTypePreviouslyReported>/s',$rmp,$EmploymentTypePreviouslyReported);	
													preg_match_all('/<WagesTipsPreviouslyReported>(.*?)<\/WagesTipsPreviouslyReported>/s',$rmp,$WagesTipsPreviouslyReported);	
													preg_match_all('/<WagesTipsCorrected>(.*?)<\/WagesTipsCorrected>/s',$rmp,$WagesTipsCorrected);
													preg_match_all('/<FITWithhPreviouslyReported>(.*?)<\/FITWithhPreviouslyReported>/s',$rmp,$FITWithhPreviouslyReported);
													preg_match_all('/<FITWithhCorrected>(.*?)<\/FITWithhCorrected>/s',$rmp,$FITWithhCorrected);
													preg_match_all('/<SocialSecurityWagesPreviouslyReported>(.*?)<\/SocialSecurityWagesPreviouslyReported>/s',$rmp,$SocialSecurityWagesPreviouslyReported);
													preg_match_all('/<SocialSecurityWagesCorrected>(.*?)<\/SocialSecurityWagesCorrected>/s',$rmp,$SocialSecurityWagesCorrected);
													preg_match_all('/<SocialSecurityTaxWithhPreviouslyReported>(.*?)<\/SocialSecurityTaxWithhPreviouslyReported>/s',$rmp,$SocialSecurityTaxWithhPreviouslyReported);
													preg_match_all('/<SocialSecurityTaxWithhCorrected>(.*?)<\/SocialSecurityTaxWithhCorrected>/s',$rmp,$SocialSecurityTaxWithhCorrected);
													preg_match_all('/<MedicareWagesAndTipsPreviouslyReported>(.*?)<\/MedicareWagesAndTipsPreviouslyReported>/s',$rmp,$MedicareWagesAndTipsPreviouslyReported);
													preg_match_all('/<MedicareWagesAndTipsCorrected>(.*?)<\/MedicareWagesAndTipsCorrected>/s',$rmp,$MedicareWagesAndTipsCorrected);
													preg_match_all('/<MedicareTaxWithhPreviouslyReported>(.*?)<\/MedicareTaxWithhPreviouslyReported>/s',$rmp,$MedicareTaxWithhPreviouslyReported);
													preg_match_all('/<MedicareTaxWithhCorrected>(.*?)<\/MedicareTaxWithhCorrected>/s',$rmp,$MedicareTaxWithhCorrected);
													preg_match_all('/<AllocatedTipsPreviouslyReported>(.*?)<\/AllocatedTipsPreviouslyReported>/s',$rmp,$AllocatedTipsPreviouslyReported);
													preg_match_all('/<AllocatedTipsCorrected>(.*?)<\/AllocatedTipsCorrected>/s',$rmp,$AllocatedTipsCorrected);
													preg_match_all('/<DependentCarePreviouslyReported>(.*?)<\/DependentCarePreviouslyReported>/s',$rmp,$DependentCarePreviouslyReported);
													preg_match_all('/<DependentCareCorrected>(.*?)<\/DependentCareCorrected>/s',$rmp,$DependentCareCorrected);
													preg_match_all('/<Code_aPreviouslyReported>(.*?)<\/Code_aPreviouslyReported>/s',$rmp,$Code_aPreviouslyReported);
													preg_match_all('/<Code_aCorrected>(.*?)<\/Code_aCorrected>/s',$rmp,$Code_aCorrected);
													preg_match_all('/<Amt_aPreviouslyReported>(.*?)<\/Amt_aPreviouslyReported>/s',$rmp,$Amt_aPreviouslyReported);
													preg_match_all('/<Amt_aCorrected>(.*?)<\/Amt_aCorrected>/s',$rmp,$Amt_aCorrected);
													preg_match_all('/<RetirementPlanCorrectedInd>(.*?)<\/RetirementPlanCorrectedInd>/s',$rmp,$RetirementPlanCorrectedInd);
													// W2C form starts	
													
												}	
												
												
												// others field used for forms like 940, 941, 944
												if($formId == 28 || $formId == 29 || $formId == 30)
												{
													preg_match_all('/<TaxPeriodEndDate>(.*?)<\/TaxPeriodEndDate>/s',$rmp,$TaxPeriodEndDate);	
													preg_match_all('/<DepositStateCode>(.*?)<\/DepositStateCode>/s',$rmp,$DepositStateCode);	
													preg_match_all('/<TotalFUTAWages>(.*?)<\/TotalFUTAWages>/s',$rmp,$TotalFUTAWages);	
													preg_match_all('/<TotalExemptFUTAWages>(.*?)<\/TotalExemptFUTAWages>/s',$rmp,$TotalExemptFUTAWages);	
													preg_match_all('/<FringeBenefitsInd>(.*?)<\/FringeBenefitsInd>/s',$rmp,$FringeBenefitsInd);
													preg_match_all('/<DependentCareInd>(.*?)<\/DependentCareInd>/s',$rmp,$DependentCareInd);
													preg_match_all('/<TotalExcessFUTAWages>(.*?)<\/TotalExcessFUTAWages>/s',$rmp,$TotalExcessFUTAWages);
													preg_match_all('/<TotalExemptAndExcessFUTAWages>(.*?)<\/TotalExemptAndExcessFUTAWages>/s',$rmp,$TotalExemptAndExcessFUTAWages);
													preg_match_all('/<TotalTxblFUTAWages>(.*?)<\/TotalTxblFUTAWages>/s',$rmp,$TotalTxblFUTAWages);
													preg_match_all('/<TotalFUTATaxBeforeAdj>(.*?)<\/TotalFUTATaxBeforeAdj>/s',$rmp,$TotalFUTATaxBeforeAdj);
													preg_match_all('/<AdjToTax>(.*?)<\/AdjToTax>/s',$rmp,$AdjToTax);
													preg_match_all('/<CreditAmt>(.*?)<\/CreditAmt>/s',$rmp,$CreditAmt);
													preg_match_all('/<TotalFUTATaxAfterAdj>(.*?)<\/TotalFUTATaxAfterAdj>/s',$rmp,$TotalFUTATaxAfterAdj);
													preg_match_all('/<TotalFUTATaxDeposited>(.*?)<\/TotalFUTATaxDeposited>/s',$rmp,$TotalFUTATaxDeposited);
													preg_match_all('/<OverpaymentAmt>(.*?)<\/OverpaymentAmt>/s',$rmp,$OverpaymentAmt);
													preg_match_all('/<RefundOrCredit>(.*?)<\/RefundOrCredit>/s',$rmp,$RefundOrCredit);
													preg_match_all('/<TaxWithhQtr1>(.*?)<\/TaxWithhQtr1>/s',$rmp,$TaxWithhQtr1);
													preg_match_all('/<TaxWithhQtr2>(.*?)<\/TaxWithhQtr2>/s',$rmp,$TaxWithhQtr2);
													preg_match_all('/<TaxWithhQtr3>(.*?)<\/TaxWithhQtr3>/s',$rmp,$TaxWithhQtr3);
													preg_match_all('/<TaxWithhQtr4>(.*?)<\/TaxWithhQtr4>/s',$rmp,$TaxWithhQtr4);
													preg_match_all('/<TotalTaxWithh>(.*?)<\/TotalTaxWithh>/s',$rmp,$TotalTaxWithh);
													preg_match_all('/<FinalReturnInd>(.*?)<\/FinalReturnInd>/s',$rmp,$FinalReturnInd);
													preg_match_all('/<DateFinalWagesPaid>(.*?)<\/DateFinalWagesPaid>/s',$rmp,$DateFinalWagesPaid);
													preg_match_all('/<NumberOfEmployees>(.*?)<\/NumberOfEmployees>/s',$rmp,$NumberOfEmployees);
													preg_match_all('/<TotalWages>(.*?)<\/TotalWages>/s',$rmp,$TotalWages);
													preg_match_all('/<TotalIncomeTaxWithh>(.*?)<\/TotalIncomeTaxWithh>/s',$rmp,$TotalIncomeTaxWithh);
													preg_match_all('/<TaxableSocialSecurityWages>(.*?)<\/TaxableSocialSecurityWages>/s',$rmp,$TaxableSocialSecurityWages);
													
													preg_match_all('/<TaxOnSocialSecurityWages>(.*?)<\/TaxOnSocialSecurityWages>/s',$rmp,$TaxOnSocialSecurityWages);
													preg_match_all('/<TaxableMedicareWagesTips>(.*?)<\/TaxableMedicareWagesTips>/s',$rmp,$TaxableMedicareWagesTips);
													preg_match_all('/<TaxOnMedicareTips>(.*?)<\/TaxOnMedicareTips>/s',$rmp,$TaxOnMedicareTips);
													preg_match_all('/<AddedMedicareWagesTips>(.*?)<\/AddedMedicareWagesTips>/s',$rmp,$AddedMedicareWagesTips);
													preg_match_all('/<TaxOnAddedMedicareWagesTips>(.*?)<\/TaxOnAddedMedicareWagesTips>/s',$rmp,$TaxOnAddedMedicareWagesTips);
													preg_match_all('/<TotalSocialSecurityMedTaxes>(.*?)<\/TotalSocialSecurityMedTaxes>/s',$rmp,$TotalSocialSecurityMedTaxes);
													preg_match_all('/<SickPayAdjustment>(.*?)<\/SickPayAdjustment>/s',$rmp,$SickPayAdjustment);
													preg_match_all('/<FractionsOfCentsAdjustment>(.*?)<\/FractionsOfCentsAdjustment>/s',$rmp,$FractionsOfCentsAdjustment);
													preg_match_all('/<TotalDepositsOverpaymentForQtr>(.*?)<\/TotalDepositsOverpaymentForQtr>/s',$rmp,$TotalDepositsOverpaymentForQtr);
													preg_match_all('/<TaxOnUnreportedTips>(.*?)<\/TaxOnUnreportedTips>/s',$rmp,$TaxOnUnreportedTips);
													preg_match_all('/<TotalTax>(.*?)<\/TotalTax>/s',$rmp,$TotalTax);
													preg_match_all('/<Amount>(.*?)<\/Amount>/s',$rmp,$Amount);
													preg_match_all('/<Refund>(.*?)<\/Refund>/s',$rmp,$Refund);
													preg_match_all('/<SemiWeeklyScheduleDepositor>(.*?)<\/SemiWeeklyScheduleDepositor>/s',$rmp,$SemiWeeklyScheduleDepositor);
													preg_match_all('/<TotalTaxesBeforeAdjustmentsAmt>(.*?)<\/TotalTaxesBeforeAdjustmentsAmt>/s',$rmp,$TotalTaxesBeforeAdjustmentsAmt);
													preg_match_all('/<DateQuarterEnding>(.*?)<\/DateQuarterEnding>/s',$rmp,$DateQuarterEnding);
													preg_match_all('/<Name>(.*?)<\/Name>/s',$rmp,$Name);
													preg_match_all('/<Title>(.*?)<\/Title>/s',$rmp,$Title);
													preg_match_all('/<Phone>(.*?)<\/Phone>/s',$rmp,$Phone);
													preg_match_all('/<Signature>(.*?)<\/Signature>/s',$rmp,$Signature);
													preg_match_all('/<EmailAddress>(.*?)<\/EmailAddress>/s',$rmp,$EmailAddress);
													preg_match_all('/<DateSigned>(.*?)<\/DateSigned>/s',$rmp,$DateSigned);
													preg_match_all('/<Month1Day3>(.*?)<\/Month1Day3>/s',$rmp,$Month1Day3);
													preg_match_all('/<Month1Day10>(.*?)<\/Month1Day10>/s',$rmp,$Month1Day10);
													preg_match_all('/<Month1Day17>(.*?)<\/Month1Day17>/s',$rmp,$Month1Day17);
													preg_match_all('/<Month1Day24>(.*?)<\/Month1Day24>/s',$rmp,$Month1Day24);
													preg_match_all('/<Month1Day31>(.*?)<\/Month1Day31>/s',$rmp,$Month1Day31);
													preg_match_all('/<Month2Day7>(.*?)<\/Month2Day7>/s',$rmp,$Month2Day7);
													preg_match_all('/<Month2Day14>(.*?)<\/Month2Day14>/s',$rmp,$Month2Day14);
													preg_match_all('/<Month2Day21>(.*?)<\/Month2Day21>/s',$rmp,$Month2Day21);
													preg_match_all('/<Month2Day28>(.*?)<\/Month2Day28>/s',$rmp,$Month2Day28);
													preg_match_all('/<Month3Day7>(.*?)<\/Month3Day7>/s',$rmp,$Month3Day7);
													preg_match_all('/<Month3Day14>(.*?)<\/Month3Day14>/s',$rmp,$Month3Day14);
													preg_match_all('/<Month3Day21>(.*?)<\/Month3Day21>/s',$rmp,$Month3Day21);
													preg_match_all('/<Month3Day28>(.*?)<\/Month3Day28>/s',$rmp,$Month3Day28);
													preg_match_all('/<TotalMonth1Liab>(.*?)<\/TotalMonth1Liab>/s',$rmp,$TotalMonth1Liab);
													preg_match_all('/<TotalMonth2Liab>(.*?)<\/TotalMonth2Liab>/s',$rmp,$TotalMonth2Liab);
													preg_match_all('/<TotalMonth3Liab>(.*?)<\/TotalMonth3Liab>/s',$rmp,$TotalMonth3Liab);
													preg_match_all('/<TotalQuarterLiab>(.*?)<\/TotalQuarterLiab>/s',$rmp,$TotalQuarterLiab);
													preg_match_all('/<TotalDepositsOverpaymentForYr>(.*?)<\/TotalDepositsOverpaymentForYr>/s',$rmp,$TotalDepositsOverpaymentForYr);
													preg_match_all('/<MonthlyDepositorCheckbox>(.*?)<\/MonthlyDepositorCheckbox>/s',$rmp,$MonthlyDepositorCheckbox);
													preg_match_all('/<Month1Liability>(.*?)<\/Month1Liability>/s',$rmp,$Month1Liability);
													preg_match_all('/<Month2Liability>(.*?)<\/Month2Liability>/s',$rmp,$Month2Liability);
													preg_match_all('/<Month3Liability>(.*?)<\/Month3Liability>/s',$rmp,$Month3Liability);
													preg_match_all('/<Month4Liability>(.*?)<\/Month4Liability>/s',$rmp,$Month4Liability);
													preg_match_all('/<Month5Liability>(.*?)<\/Month5Liability>/s',$rmp,$Month5Liability);
													preg_match_all('/<Month6Liability>(.*?)<\/Month6Liability>/s',$rmp,$Month6Liability);
													preg_match_all('/<Month7Liability>(.*?)<\/Month7Liability>/s',$rmp,$Month7Liability);
													preg_match_all('/<Month8Liability>(.*?)<\/Month8Liability>/s',$rmp,$Month8Liability);
													preg_match_all('/<Month9Liability>(.*?)<\/Month9Liability>/s',$rmp,$Month9Liability);
													preg_match_all('/<Month10Liability>(.*?)<\/Month10Liability>/s',$rmp,$Month10Liability);
													preg_match_all('/<Month11Liability>(.*?)<\/Month11Liability>/s',$rmp,$Month11Liability);
													preg_match_all('/<Month12Liability>(.*?)<\/Month12Liability>/s',$rmp,$Month12Liability);
													preg_match_all('/<TotalYearLiability>(.*?)<\/TotalYearLiability>/s',$rmp,$TotalYearLiability);
												}
												
												//echo '*****<pre>'.print_r($Box2).'</pre>';
												$name = $PayeeName['1']['0'];
												$last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
												$first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
												
												$payeeArr = array();
												$payeeArr['i_payer_id'] 				= $i_ins;
												$payeeArr['s_form_id'] 					= $formId;
												$payeeArr['e_record_type'] 				= 'B'; // payee records
												$payeeArr['s_batch_code'] 				= $batchId;
												$payeeArr['i_payment_year'] 			= $year;
												$payeeArr['s_payee_tin'] 				= $PayeeTIN[1][0];
												$payeeArr['s_type_of_tin'] 				= $PayeeTypeOfTIN[1][0];
												$payeeArr['s_first_payee_name_line'] 	= $first_name;
												$payeeArr['s_last_payee_name_line'] 	= $last_name;
												$payeeArr['s_second_payee_name_line'] 	= $PayeeName2[1][0];
												$payeeArr['s_payee_shipping_address'] 	= $PayeeAddr[1][0];
												$payeeArr['s_payee_city'] 				= $PayeeCity[1][0];
												$payeeArr['s_payee_state'] 				= $PayeeState[1][0];
												$payeeArr['s_payee_zip_code'] 			= $PayeeZipcode[1][0];
												$payeeArr['s_payment_amount1'] 			= $Box1[1][0];
												$payeeArr['s_payment_amount2'] 			= $Box2[1][0];
												$payeeArr['s_payment_amount3'] 			= $Box3[1][0];
												$payeeArr['s_payment_amount4'] 			= $Box4[1][0];
												$payeeArr['s_payment_amount5'] 			= $Box5[1][0];
												$payeeArr['s_payment_amount6'] 			= $Box6[1][0];
												$payeeArr['s_payment_amount7'] 			= $Box7[1][0];
												$payeeArr['s_payment_amount8'] 			= $Box8[1][0];
												$payeeArr['s_payment_amount9'] 			= $Box9[1][0];
												$payeeArr['s_payment_amount10'] 		= $Box10[1][0];
												$payeeArr['s_payment_amount11'] 		= $Box11[1][0];
												$payeeArr['s_payment_amount12'] 		= $Box12[1][0];
												$payeeArr['s_payment_amount13'] 		= $Box13[1][0];
												$payeeArr['s_payment_amount14'] 		= $Box14[1][0];
												$payeeArr['s_payment_amount15'] 		= $Box15[1][0];
												$payeeArr['s_payment_amount16'] 		= $Box16[1][0];
												//echo '<pre>'.print_r($payeeArr).'</pre>';
												$payeeArr['s_AcctNumber'] 				= $AcctNumber[1][0];
												////////////// Others 1099 form series starts 	
												if(in_array($formId, $arr_1099))	
												{										
												$payeeArr['DateofAcquisition']	= $DateofAcquisition[1][0];	
												$payeeArr['LongTermLossInd']	= $LongTermLossInd[1][0];	
												$payeeArr['CusipNumber']		= $CusipNumber[1][0];	
												$payeeArr['StocksBonds']		= $StocksBonds[1][0];	
												$payeeArr['NetProceedsInd']		= $NetProceedsInd[1][0];	
												$payeeArr['CostOrOtherBasis']	= $CostOrOtherBasis[1][0];	
												$payeeArr['WCDCode']			= $WCDCode[1][0];	
												$payeeArr['s_FITWithh']			= $s_FITWithh[1][0];	
												$payeeArr['BarteringAmt']		= $BarteringAmt[1][0];	
												
												$payeeArr['DateCanceled']			= $DateCanceled[1][0];	
												$payeeArr['AmtOfDebtCanceled']		= $AmtOfDebtCanceled[1][0];	
												$payeeArr['InterestIncluded']		= $InterestIncluded[1][0];	
												$payeeArr['DebtDescrOne']			= $DebtDescrOne[1][0];	
												$payeeArr['BorrowerLiabInd']		= $BorrowerLiabInd[1][0];	
												$payeeArr['IdentifiableEventCode']	= $IdentifiableEventCode[1][0];	
												$payeeArr['DateofSale']				= $DateofSale[1][0];	
												$payeeArr['NumSharesExchanged']		= $NumSharesExchanged[1][0];	
												$payeeArr['ClassesStockExchanged']	= $ClassesStockExchanged[1][0];	
												$payeeArr['AggregateAmtRec']		= $AggregateAmtRec[1][0];	
												
												$payeeArr['ForeignCountryOrUSPoss']	= $ForeignCountryOrUSPoss[1][0];	
												$payeeArr['OrdinaryDiv']			= $OrdinaryDiv[1][0];	
												$payeeArr['QualifiedDiv']			= $QualifiedDiv[1][0];	
												$payeeArr['NonTaxDist']				= $NonTaxDist[1][0];	
												$payeeArr['InvestmentExp']			= $InvestmentExp[1][0];	
												$payeeArr['ForeignTaxPaid']			= $ForeignTaxPaid[1][0];	
												$payeeArr['CashLiquidDistr']		= $CashLiquidDistr[1][0];	
												$payeeArr['SpecPrivateActivityBondInterestDiv']	= $SpecPrivateActivityBondInterestDiv[1][0];	
												
												$payeeArr['StateLocalRefund']		= $StateLocalRefund[1][0];	
												$payeeArr['RefundTaxYr']			= $RefundTaxYr[1][0];	
												$payeeArr['TaxableGrants']			= $TaxableGrants[1][0];	
												$payeeArr['MarketGain']				= $MarketGain[1][0];	
												
												$payeeArr['PayersRTN']				= $PayersRTN[1][0];	
												$payeeArr['TaxExemptBondCusipNum']	= $TaxExemptBondCusipNum[1][0];	
												$payeeArr['InterestIncome']			= $InterestIncome[1][0];	
												$payeeArr['EarlyWithdrawal']		= $EarlyWithdrawal[1][0];	
												$payeeArr['IntOnUSTreas']			= $IntOnUSTreas[1][0];	
												$payeeArr['InvestmentExpenses']		= $InvestmentExpenses[1][0];	
												$payeeArr['EarlyWithdrawal']		= $EarlyWithdrawal[1][0];	
												$payeeArr['TaxExemptInterest']		= $TaxExemptInterest[1][0];	
												
												$payeeArr['GrossLTBenefitsPd']		= $GrossLTBenefitsPd[1][0];	
												$payeeArr['AccelDeathBenPd']		= $AccelDeathBenPd[1][0];	
												$payeeArr['ReimbursedAmtInd']		= $ReimbursedAmtInd[1][0];	
												$payeeArr['InsuredsSSN']			= $InsuredsSSN[1][0];	
												$payeeArr['InsuredsNameOne']		= $InsuredsNameOne[1][0];	
												$payeeArr['InsuredsStreetAddr']		= $InsuredsStreetAddr[1][0];	
												$payeeArr['InsuredsCity']			= $InsuredsCity[1][0];	
												$payeeArr['InsuredsState']			= $InsuredsState[1][0];	
												$payeeArr['InsuredsZip']			= $InsuredsZip[1][0];	
												$payeeArr['ChronicallyillInd']		= $ChronicallyillInd[1][0];	
												$payeeArr['DateCertified']			= $DateCertified[1][0];	
												
												$payeeArr['s_StateNameOne']			= $s_StateNameOne[1][0];	
												$payeeArr['s_StateIdOne']			= $s_StateIdOne[1][0];	
												$payeeArr['OtherIncome']			= $OtherIncome[1][0];	
												$payeeArr['NonEmpComp']				= $NonEmpComp[1][0];	
												$payeeArr['GrossAttorneyProc']		= $GrossAttorneyProc[1][0];	
												$payeeArr['s_StateTaxWithhOne']		= $s_StateTaxWithhOne[1][0];	
												$payeeArr['s_StateIncomeOne']		= $s_StateIncomeOne[1][0];	
												$payeeArr['Form1099MISCAgencies']	= $Form1099MISCAgencies[1][0];	
												
												$payeeArr['OIDForThisYrAmt']	= $OIDForThisYrAmt[1][0];	
												$payeeArr['OtherPeriodicInt']	= $OtherPeriodicInt[1][0];	
												$payeeArr['AcquisitionPremium']	= $AcquisitionPremium[1][0];	
												$payeeArr['DescrOne']			= $DescrOne[1][0];	
												$payeeArr['DescrTwo']			= $DescrTwo[1][0];
													
												$payeeArr['NonPatrDistrib']			= $NonPatrDistrib[1][0];	
												$payeeArr['RedemptionOfNonQualAmt']	= $RedemptionOfNonQualAmt[1][0];	
												$payeeArr['OtherCredits']			= $OtherCredits[1][0];	
												$payeeArr['InvestmentCredit']		= $InvestmentCredit[1][0];	
												$payeeArr['WorkOppCredit']			= $WorkOppCredit[1][0];	
												
												$payeeArr['GrossDistrib']		= $GrossDistrib[1][0];	
												$payeeArr['Earnings']			= $Earnings[1][0];	
												$payeeArr['Basis']				= $Basis[1][0];	
												$payeeArr['TrustToTrustRolloverInd']= $TrustToTrustRolloverInd[1][0];	
												$payeeArr['PrivateInd']			= $PrivateInd[1][0];	
												
												$payeeArr['WrongAmountOrFiling']= $WrongAmountOrFiling[1][0];	
												$payeeArr['DistributionCode']	= $DistributionCode[1][0];	
												$payeeArr['OtherPercent']		= $OtherPercent[1][0];	
												$payeeArr['GrossDistribution']	= $GrossDistribution[1][0];	
												$payeeArr['TaxableAmt']			= $TaxableAmt[1][0];	
												$payeeArr['s_Other']			= $s_Other[1][0];	
												$payeeArr['StateDistribOne']	= $StateDistribOne[1][0];	
												
												$payeeArr['DateOfClosing']		= $DateOfClosing[1][0];	
												$payeeArr['GrossProceeds']		= $GrossProceeds[1][0];	
												$payeeArr['DescrThree']			= $DescrThree[1][0];													
												}
												
												////////////// Others 1099 form series ends 
												
												// for 5498 series forms
												$payeeArr['s_EmployeeContrib'] 			= $EmployeeContrib[1][0];
												$payeeArr['s_TotalContribReturnYr'] 	= $TotalContribReturnYr[1][0];
												$payeeArr['s_FairMarketValue'] 			= $FairMarketValue[1][0];
												$payeeArr['s_ArcherMSAInd'] 			= $ArcherMSAInd[1][0];
												$payeeArr['s_CoverdellESAContribAmt'] 	= $CoverdellESAContribAmt[1][0];												
												// for 5498 series forms
												// for 1098 series forms
												$payeeArr['s_MortgageInt'] 				= $MortgageInt[1][0];
												$payeeArr['s_PointsInDollarsAmt'] 		= $PointsInDollarsAmt[1][0];
												$payeeArr['s_RefundOfOverpaidInt'] 		= $RefundOfOverpaidInt[1][0];
												$payeeArr['s_DateOfContribution'] 		= $DateOfContribution[1][0];
												$payeeArr['s_Year'] 					= $Year[1][0];												
												$payeeArr['s_Make'] 					= $Make[1][0];												
												$payeeArr['s_Model'] 					= $Model[1][0];												
												$payeeArr['s_IDNumber'] 				= $IDNumber[1][0];												
												$payeeArr['e_LessFMVInd'] 				= $LessFMVInd[1][0];												
												$payeeArr['e_ProvideGoodsSvcsInExchInd']= $ProvideGoodsSvcsInExchInd[1][0];												
												$payeeArr['s_ValueOfGoodsAndSvcsProvided']= $ValueOfGoodsAndSvcsProvided[1][0];											
												$payeeArr['s_DescrGoodsSvcsOne'] 		= $DescrGoodsSvcsOne[1][0];												
												$payeeArr['e_IntangibleReligiousBenefitsCk']= $IntangibleReligiousBenefitsCk[1][0];										
												$payeeArr['s_StudentLoanInt'] 			= $StudentLoanInt[1][0];												
												// for 1098 series forms
												//echo '=============== ===================================== =====================</br>';
												
												// others field used for different forms
												$payeeOthersArr = array();
												$payeeOthersArr['s_batchId'] 				= $batchId;
												$payeeOthersArr['TypeOfWagerCode'] 			= $TypeOfWagerCode[1][0];
												$payeeOthersArr['TypeOfWagerCategory'] 		= $TypeOfWagerCategory[1][0];
												$payeeOthersArr['DateWon'] 					= $DateWon[1][0];
												$payeeOthersArr['GrossWinnings'] 			= $GrossWinnings[1][0];
												$payeeOthersArr['FITWithh'] 				= $FITWithh[1][0];
												$payeeOthersArr['StateNameOne'] 			= $StateNameOne[1][0];
												$payeeOthersArr['StateIdOne'] 				= $StateIdOne[1][0];
												$payeeOthersArr['StateTaxWithhOne'] 		= $StateTaxWithhOne[1][0];
												$payeeOthersArr['StateWinningsOne'] 		= $StateWinningsOne[1][0];
												
												$payeeOthersArr['EmploymentType'] 			= $EmploymentType[1][0];
												$payeeOthersArr['Box14TextOne'] 			= $Box14TextOne[1][0];
												$payeeOthersArr['Code_a'] 					= $Code_a[1][0];
												$payeeOthersArr['Amt_a'] 					= $Amt_a[1][0];
												$payeeOthersArr['StatutoryInd'] 			= $StatutoryInd[1][0];
												$payeeOthersArr['RetirementPlanInd'] 		= $RetirementPlanInd[1][0];
												$payeeOthersArr['ThirdPartySickPayInd'] 	= $ThirdPartySickPayInd[1][0];
												$payeeOthersArr['W2ControlNumber'] 			= $W2ControlNumber[1][0];
												$payeeOthersArr['MedicareWithh'] 			= $MedicareWithh[1][0];
												$payeeOthersArr['MedWagesAndTips'] 			= $MedWagesAndTips[1][0];
												$payeeOthersArr['SocSecWages'] 				= $SocSecWages[1][0];
												$payeeOthersArr['SocSecWithh'] 				= $SocSecWithh[1][0];
												$payeeOthersArr['StateWagesTipsEtcOne'] 	= $StateWagesTipsEtcOne[1][0];
												$payeeOthersArr['WagesTipsOtherComp'] 		= $WagesTipsOtherComp[1][0];
												
												$payeeOthersArr['YearFormCorrected'] 						= $YearFormCorrected[1][0];
												$payeeOthersArr['CorrectedNameInd'] 						= $CorrectedNameInd[1][0];
												$payeeOthersArr['EmployeesIncorrectSSN'] 					= $EmployeesIncorrectSSN[1][0];
												$payeeOthersArr['EmployeesFirstNamePreviouslyReported'] 	= $EmployeesFirstNamePreviouslyReported[1][0];
												$payeeOthersArr['EmployeesMiddleInitialPreviouslyReported']	= $EmployeesMiddleInitialPreviouslyReported[1][0];
												$payeeOthersArr['EmployeesLastNamePreviouslyReported'] 		= $EmployeesLastNamePreviouslyReported[1][0];
												$payeeOthersArr['EmploymentTypePreviouslyReported'] 		= $EmploymentTypePreviouslyReported[1][0];
												$payeeOthersArr['WagesTipsPreviouslyReported'] 				= $WagesTipsPreviouslyReported[1][0];
												$payeeOthersArr['WagesTipsCorrected'] 						= $WagesTipsCorrected[1][0];
												$payeeOthersArr['FITWithhPreviouslyReported'] 				= $FITWithhPreviouslyReported[1][0];
												$payeeOthersArr['FITWithhCorrected'] 						= $FITWithhCorrected[1][0];
												$payeeOthersArr['SocialSecurityWagesPreviouslyReported'] 	= $SocialSecurityWagesPreviouslyReported[1][0];
												$payeeOthersArr['SocialSecurityWagesCorrected'] 			= $SocialSecurityWagesCorrected[1][0];
												$payeeOthersArr['SocialSecurityTaxWithhPreviouslyReported'] = $SocialSecurityTaxWithhPreviouslyReported[1][0];
												$payeeOthersArr['SocialSecurityTaxWithhCorrected'] 			= $SocialSecurityTaxWithhCorrected[1][0];
												$payeeOthersArr['MedicareWagesAndTipsPreviouslyReported'] 	= $MedicareWagesAndTipsPreviouslyReported[1][0];
												$payeeOthersArr['MedicareWagesAndTipsCorrected'] 			= $MedicareWagesAndTipsCorrected[1][0];
												$payeeOthersArr['MedicareTaxWithhPreviouslyReported'] 		= $MedicareTaxWithhPreviouslyReported[1][0];
												$payeeOthersArr['MedicareTaxWithhCorrected'] 				= $MedicareTaxWithhCorrected[1][0];
												$payeeOthersArr['AllocatedTipsPreviouslyReported'] 			= $AllocatedTipsPreviouslyReported[1][0];
												$payeeOthersArr['AllocatedTipsCorrected'] 					= $AllocatedTipsCorrected[1][0];
												$payeeOthersArr['DependentCarePreviouslyReported'] 			= $DependentCarePreviouslyReported[1][0];
												$payeeOthersArr['DependentCareCorrected'] 					= $DependentCareCorrected[1][0];
												$payeeOthersArr['Code_aPreviouslyReported'] 				= $Code_aPreviouslyReported[1][0];
												$payeeOthersArr['Code_aCorrected'] 							= $Code_aCorrected[1][0];
												$payeeOthersArr['Amt_aPreviouslyReported'] 					= $Amt_aPreviouslyReported[1][0];
												$payeeOthersArr['Amt_aCorrected'] 							= $Amt_aCorrected[1][0];
												$payeeOthersArr['RetirementPlanCorrectedInd'] 				= $RetirementPlanCorrectedInd[1][0];
												
												// others field used for forms like 940, 941, 944
												$payee2Arr = array();
												$payee2Arr['s_BatchId'] 					= $batchId;
												if($formId == 28 || $formId == 29 || $formId == 30)
												{
													$payee2Arr['TaxPeriodEndDate']				= $TaxPeriodEndDate[1][0];
													$payee2Arr['DepositStateCode']				= $DepositStateCode[1][0];
													$payee2Arr['TotalFUTAWages']				= $TotalFUTAWages[1][0];
													$payee2Arr['TotalExemptFUTAWages']			= $TotalExemptFUTAWages[1][0];
													$payee2Arr['FringeBenefitsInd']				= $FringeBenefitsInd[1][0];
													$payee2Arr['DependentCareInd']				= $DependentCareInd[1][0];
													$payee2Arr['TotalExcessFUTAWages']			= $TotalExcessFUTAWages[1][0];
													$payee2Arr['TotalExemptAndExcessFUTAWages']	= $TotalExemptAndExcessFUTAWages[1][0];
													$payee2Arr['TotalTxblFUTAWages']			= $TotalTxblFUTAWages[1][0];
													$payee2Arr['TotalFUTATaxBeforeAdj']			= $TotalFUTATaxBeforeAdj[1][0];
													$payee2Arr['AdjToTax']						= $AdjToTax[1][0];
													$payee2Arr['CreditAmt']						= $CreditAmt[1][0];
													$payee2Arr['TotalFUTATaxAfterAdj']			= $TotalFUTATaxAfterAdj[1][0];
													$payee2Arr['TotalFUTATaxDeposited']			= $TotalFUTATaxDeposited[1][0];
													$payee2Arr['OverpaymentAmt']				= $OverpaymentAmt[1][0];
													$payee2Arr['RefundOrCredit']				= $RefundOrCredit[1][0];
													$payee2Arr['TaxWithhQtr1']					= $TaxWithhQtr1[1][0];
													$payee2Arr['TaxWithhQtr2']					= $TaxWithhQtr2[1][0];
													$payee2Arr['TaxWithhQtr3']					= $TaxWithhQtr3[1][0];
													$payee2Arr['TaxWithhQtr4']					= $TaxWithhQtr4[1][0];
													$payee2Arr['TotalTaxWithh']					= $TotalTaxWithh[1][0];
													$payee2Arr['FinalReturnInd']				= $FinalReturnInd[1][0];
													$payee2Arr['DateFinalWagesPaid']			= $DateFinalWagesPaid[1][0];
													$payee2Arr['NumberOfEmployees']				= $NumberOfEmployees[1][0];
													$payee2Arr['TotalWages']					= $TotalWages[1][0];
													$payee2Arr['TotalIncomeTaxWithh']			= $TotalIncomeTaxWithh[1][0];
													$payee2Arr['TaxableSocialSecurityWages']	= $TaxableSocialSecurityWages[1][0];
													$payee2Arr['TaxOnSocialSecurityWages']		= $TaxOnSocialSecurityWages[1][0];
													$payee2Arr['TaxableMedicareWagesTips']		= $TaxableMedicareWagesTips[1][0];
													$payee2Arr['TaxOnMedicareTips']				= $TaxOnMedicareTips[1][0];
													$payee2Arr['AddedMedicareWagesTips']		= $AddedMedicareWagesTips[1][0];
													$payee2Arr['TaxOnAddedMedicareWagesTips']	= $TaxOnAddedMedicareWagesTips[1][0];
													$payee2Arr['TotalSocialSecurityMedTaxes']	= $TotalSocialSecurityMedTaxes[1][0];
													$payee2Arr['SickPayAdjustment']				= $SickPayAdjustment[1][0];
													$payee2Arr['FractionsOfCentsAdjustment']	= $FractionsOfCentsAdjustment[1][0];
													$payee2Arr['TotalDepositsOverpaymentForQtr']= $TotalDepositsOverpaymentForQtr[1][0];
													$payee2Arr['TaxOnUnreportedTips']			= $TaxOnUnreportedTips[1][0];
													$payee2Arr['TotalTax']						= $TotalTax[1][0];
													$payee2Arr['Amount']						= $Amount[1][0];
													$payee2Arr['Refund']						= $Refund[1][0];
													$payee2Arr['SemiWeeklyScheduleDepositor']	= $SemiWeeklyScheduleDepositor[1][0];
													$payee2Arr['TotalTaxesBeforeAdjustmentsAmt']= $TotalTaxesBeforeAdjustmentsAmt[1][0];
													$payee2Arr['DateQuarterEnding']				= $DateQuarterEnding[1][0];
													$payee2Arr['Name']							= $Name[1][0];
													$payee2Arr['Title']							= $Title[1][0];
													$payee2Arr['Phone']							= $Phone[1][0];
													$payee2Arr['Signature']						= $Signature[1][0];
													$payee2Arr['EmailAddress']					= $EmailAddress[1][0];
													$payee2Arr['DateSigned']					= $DateSigned[1][0];
													$payee2Arr['Month1Day3']					= $Month1Day3[1][0];
													$payee2Arr['Month1Day10']					= $Month1Day10[1][0];
													$payee2Arr['Month1Day17']					= $Month1Day17[1][0];
													$payee2Arr['Month1Day24']					= $Month1Day24[1][0];
													$payee2Arr['Month1Day31']					= $Month1Day31[1][0];
													$payee2Arr['Month2Day7']					= $Month2Day7[1][0];
													$payee2Arr['Month2Day14']					= $Month2Day14[1][0];
													$payee2Arr['Month2Day21']					= $Month2Day21[1][0];
													$payee2Arr['Month2Day28']					= $Month2Day28[1][0];
													$payee2Arr['Month3Day7']					= $Month3Day7[1][0];
													$payee2Arr['Month3Day14']					= $Month3Day14[1][0];
													$payee2Arr['Month3Day21']					= $Month3Day21[1][0];
													$payee2Arr['Month3Day28']					= $Month3Day28[1][0];
													$payee2Arr['TotalMonth1Liab']				= $TotalMonth1Liab[1][0];
													$payee2Arr['TotalMonth2Liab']				= $TotalMonth2Liab[1][0];
													$payee2Arr['TotalMonth3Liab']				= $TotalMonth3Liab[1][0];
													$payee2Arr['TotalQuarterLiab']				= $TotalQuarterLiab[1][0];
													$payee2Arr['TotalDepositsOverpaymentForYr']	= $TotalDepositsOverpaymentForYr[1][0];
													$payee2Arr['MonthlyDepositorCheckbox']		= $MonthlyDepositorCheckbox[1][0];
													$payee2Arr['Month1Liability']				= $Month1Liability[1][0];
													$payee2Arr['Month2Liability']				= $Month2Liability[1][0];
													$payee2Arr['Month3Liability']				= $Month3Liability[1][0];
													$payee2Arr['Month4Liability']				= $Month4Liability[1][0];
													$payee2Arr['Month5Liability']				= $Month5Liability[1][0];
													$payee2Arr['Month6Liability']				= $Month6Liability[1][0];
													$payee2Arr['Month7Liability']				= $Month7Liability[1][0];
													$payee2Arr['Month8Liability']				= $Month8Liability[1][0];
													$payee2Arr['Month9Liability']				= $Month9Liability[1][0];
													$payee2Arr['Month10Liability']				= $Month10Liability[1][0];
													$payee2Arr['Month11Liability']				= $Month11Liability[1][0];
													$payee2Arr['Month12Liability']				= $Month12Liability[1][0];
													$payee2Arr['TotalYearLiability']			= $TotalYearLiability[1][0];
													
												}
												
												// others field used for forms like 940, 941, 944
												
												//if(!empty($payeeArr) && $PayeeTIN[1][0]!='')
												if(!empty($payeeArr))
												{
													// start payee info validation
													$payee_val_msg = _chk_payee_validation($payeeArr);
													if($payee_val_msg=='')
													{
														$payeeFullArr[] 		= $payeeArr;
														$payeeOthersFullArr[] 	= $payeeOthersArr ; // new others field 29Nov
														$payee2FullArr[] 		= $payee2Arr ; // new others field for 94X series 19dec
													}
													else
													{
														$payeeValidationErrArr[] = $payee_val_msg;
													}
													
													$own_payee = $own_payee + 1;
													$total_payee = $total_payee + 1;
													
													// New Array For Form Count 21 Feb, 2017 see@https://shieldwatch.teamwork.com/index.cfm#messages/616199 Message Posted On 17 Feb, 2017
													if(array_key_exists($formId, $formTypeWithCountArr))
													{
														$cnt = $formTypeWithCountArr[$formId];
														$formTypeWithCountArr[$formId] = $cnt + 1;
													}
													else
														$formTypeWithCountArr[$formId] = $total_payee;
							
													
														
												} // end payee info inserted	
												else
												{
													$ERR = form_payeeInfo_error_response();	
													$output = _error_output_as_obj($ERR);		
												}									
												
											} // end foreach payee records
											
											
										} // end not empty payee
										else
										{
											$ERR = form_empty_payee_error_response();	
											$output = _error_output_as_obj($ERR);		
										}									
												
										
									} // end payer info inserted
									
								}
								
							}
							else
							{
								$ERR = form_payerInfo_error_response();	
								$output = _error_output_as_obj($ERR);	
							}	
							
							
							
						} // end foreach records
					
					}				
					else
					{
						$ERR = form_company_tag_error_response();
						$output = _error_output_as_obj($ERR);		
					}
					/******************* XML READING END ********************/
					
				} // not emty user details
			
			} // username / password empty
			else
			{
				$ERR = form_no_user_pwd_response();			
				//return json_encode($ERR); 		
				$output = _error_output_as_obj($ERR);	
			}
			
			// Forms Price Calculations 10 Feb, 2017
			if(!empty($formTypeWithCountArr))
			{
				//insert in the user form count table @https://shieldwatch.teamwork.com/index.cfm#messages/616199 commment on 10feb by WES
				foreach($formTypeWithCountArr as $key => $val)		
				{
					$FormId = $key; $tot_cnt = $val;
					$insArr = array();
					$insArr["s_batch_id"] 			= $batchId;
					$insArr["s_user"] 				= $user;
					$insArr["i_filling_type"]		= $dataProcessFor[1][0];
					$insArr["i_user_id"]	 		= _getUserIdFromUsername($user);
					$insArr["i_forms_no"]	 		= $tot_cnt;
					
					if($FormId<=16) // for 1099 category
						$insArr["s_form_type"]	 	= 1;
					if($FormId<=27 && $FormId>=25) // for W2 category
						$insArr["s_form_type"]	 	= 2;
					if($FormId<=30 && $FormId>=28) // for 941 category
						$insArr["s_form_type"]	 	= 3;
					
					$resInsRet= mysql_insert_array('ams_user_forms_paid_count', $insArr);
					unset($insArr);
						
				}
				//insert in the user form count table
				
				$userIdd = _getUserIdFromUsername($user); // new code for price
				$totalPrice = _newCalculateFormPrice($formTypeWithCountArr, $userIdd, $dataProcessFor[1][0]);
				
				// update batch price paid at the time of transmit
				mysql_exc_qry("UPDATE ams_batch_master SET d_paid_price = '".addslashes($totalPrice)."' WHERE  s_batch_id= '".addslashes($batchId)."' ");
			}
		
			// if no validation error found for any of the payer records
			if(!empty($payerValidationErrArr))
			{
				$ERR = form_payer_validation_error_response($payerValidationErrArr);
				$output = _error_output_as_obj($ERR);	
				// as got error delete the batch records from all tables
				$i_batch_Del 	= mysql_delete_array('ams_batch_master', " s_batch_id='".$batchId."' ");
				$i_payer_Del 	= mysql_delete_array('ams_payer_info', " s_batch_code='".$batchId."' ");
				$i_payee_Del 	= mysql_delete_array('ams_payee_info', " s_batch_code='".$batchId."' ");
				$i_history_Del	= mysql_delete_array('ams_forms_payer_payee_history', " s_batch_code='".$batchId."' ");
			}// if no validation error found for any of the payee records
			else if(!empty($payeeValidationErrArr))
			{
				//$payeeValMsg = implode(', ',$payeeValidationErrArr);
				$ERR = form_payee_validation_error_response($payeeValidationErrArr);
				$output = _error_output_as_obj($ERR);
				// as got error delete the batch records from all tables
				$i_batch_Del = mysql_delete_array('ams_batch_master', " s_batch_id='".$batchId."' ");
				$i_payer_Del = mysql_delete_array('ams_payer_info', " s_batch_code='".$batchId."' ");
				$i_payee_Del = mysql_delete_array('ams_payee_info', " s_batch_code='".$batchId."' ");
				$i_history_Del	= mysql_delete_array('ams_forms_payer_payee_history', " s_batch_code='".$batchId."' ");
			}
			else // insert the payee records
			{
				for($i=0; $i < count($payeeFullArr); $i++)
				{
					$payeeInsRet= mysql_insert_array('ams_payee_info', $payeeFullArr[$i]);
					$i_pk = $payeeInsRet['mysql_insert_id'];
					$formId = $payeeFullArr[$i]['s_form_id'];
					$i_payer_id = $payeeFullArr[$i]['i_payer_id'];
					
					$payeeOthersFullArrInfo = array();
					$payeeOthersFullArrInfo = $payeeOthersFullArr[$i];
					
					$payee2FullArrInfo = array();
					$payee2FullArrInfo = $payee2FullArr[$i];
					
					
					if($i_pk>0)
					{
						$frmArr = array();
						$frmArr['s_batch_code'] = $batchId;
						$frmArr['s_form_id'] 	= $formId;
						$frmArr['i_payer_id'] 	= $i_payer_id;
						$frmArr['i_payee_id'] 	= $i_pk;
						mysql_insert_array('ams_forms_payer_payee_history', $frmArr);	
						
						$payeeOthersFullArrInfo['i_payee_id'] = $i_pk;		
						mysql_insert_array('ams_payee_others_info', $payeeOthersFullArrInfo);	// new others field 29Nov
						
						$payee2FullArrInfo['i_Payee_Id'] = $i_pk;		
						mysql_insert_array('ams_payee_others_info_94seies', $payee2FullArrInfo);	// new others field 94X series 19dec
											
					}
				}
				
				if($i_pk>0) // if payee information added success
				{
					//insert record in batch log table
					$logArr = array();
					$logArr["s_batch_id"] 	= $batchId;
					$logArr["s_action"] 	= "created";
					$logArr["i_status"] 	= 1; // first status
					$logArr["i_created_by"] = 2; // loggedin users please call function _getUserId($user)
					mysql_insert_array('ams_batch_status_history', $logArr);
					
					//*********** send email to the customer sending him the batch number and current status 10 Nov, 2016 **********//
					// see @https://shieldwatch.teamwork.com/messages/568694?scrollTo=pmp1634382
					if($user_email!='' && $auto_email_feature==1) // see @https://shieldwatch.teamwork.com/messages/575669?scrollTo=pmp1660076
					{							
						#$user_email = 'mmondal@codeuridea.com';
						$to  = $user_email; // note the comma
						$from = 'projects@codeuridea.com';
						// subject
						$subject = 'New Batch Information Added';

						// message
						$message = '
						<html>
						<head>
						  <title>New Batch Information Added</title>
						</head>
						<body>
						  <p>Here are the details!</p>
						  <table border="0" cellspacing="2" cellpading="2" width="50%">
							<tr>
							  <th>Batch Number</th><th>Current Status</th>
							</tr>
							<tr>
							  <td align="center">'.$batchId.'</td><td align="center">Invoice Pending</td>
							</tr>
						  </table>
						</body>
						</html>
						';
						
						//if($_SERVER['SERVER_NAME']=='stagingapi.codeuridea.com')
						if($_SERVER['SERVER_NAME']=='1099.codeuridea.net')
						{
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";							 
							// Create email headers
							$headers .= 'From: '.$from."\r\n".
								'Reply-To: '.$from."\r\n" .
								'X-Mailer: PHP/' . phpversion();							
							
							
							//@mail($to, $subject, $message);
							@mail($to, $subject, $message, $headers);
							
						}
						else
						{
							// open below code whenever you got the smtp settings							
							// phpmailer start
							require('class.phpmailer.php');

							$mail = new PHPMailer;
							//$mail->SMTPDebug = 3;                         // Enable verbose debug output
							$mail->isSMTP();                                // Set mailer to use SMTP
							$mail->Host = 'mail.codeuridea.com';  			// Specify main and backup SMTP servers
							$mail->SMTPAuth = true;   						// Enable SMTP authentication
							//$mail->SetLanguage('en','PHPMailer-master/language/');                             
							$mail->Username = 'projects@codeuridea.com';    // SMTP username
							$mail->Password = '$h1eld687#';  				// SMTP password
							$mail->From    = 'projects@codeuridea.com';
							$mail->FromName   = 'Advanced Micro Solutions';                         
							//$mail->SMTPSecure = 'tls';                    // Enable TLS encryption, `ssl` also accepted
							$mail->Port = 25;     

							//$mail->setFrom('projects@codeuridea.com', 'Shield Watch');
							$mail->addAddress($to, $username);     // Add a recipient
							#$mail->addReplyTo('info@example.com', 'Information');
							$mail->isHTML(true);                                  // Set email format to HTML
							$mail->Subject = $subject;
							#$mail->Body    = $message;
							$mail->MsgHTML($message);
							$mail->send();
							
							// Mail it
							//@mail($to, $subject, $message, $headers);
							#@mail('mmondal@codeuridea.com', 'hi', 'hello');
						}
												
					}
					
					//*********** end send email to the customer sending him the batch number and current status **********//				
					
					$sucArr = array();
					$sucArr["batchId"] 		= $batchId;
					#$sucArr["no_of_forms"] 	= $no_of_forms;
					$sucArr["no_of_forms"] 	= $total_payee;
					$sucArr["total_payer"] 	= $total_payer;
					$sucArr["total_payee"] 	= $total_payee;
					//$sucArr["total_cost"] = 200;
					$sucArr["total_cost"] 	= _priceFormat($totalPrice);
					
					$output = _success_output_as_obj($sucArr);		
				}
			}	
			return $output;
			// .... ..... ..... ..... XML DATA PART END .... ..... ..... .....
			//just some dummy result
			/*return array(
			'batch_id'=>1,
			'responseCode'=>'200',
			'responseDetail'=>'Success',
			'total_cost'=>99
			);*/
	}

	//------------------------------- END DEFINE DIFFERENT FUNCTIONS ----------------------------------------
	
	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';

	$server->service($HTTP_RAW_POST_DATA);
	
?>
