<?php
	error_reporting(E_ALL ^ E_NOTICE);
	//error_reporting(1);
	require_once('lib/nusoap.php'); 
	require_once "./utils.php";	//just include utils to use it
	
	// authorize.net payment gateway implementation
	require 'vendor/autoload.php';
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
			'paidAmount' => array('name' => 'paidAmount', 'type' => 'xsd:float'),
			'transactionCode' => array('name' => 'transactionCode', 'type' => 'xsd:float'),
			'transactionId' => array('name' => 'transactionId', 'type' => 'xsd:string'),
			'transactionDescription' => array('name' => 'transactionDescription', 'type' => 'xsd:string'),
			'ResponseCode' => array('name' => 'ResponseCode', 'type' => 'xsd:string'),
			'ResponseDetail' => array('name' => 'ResponseDetail', 'type' => 'xsd:string')
		)
	);

	//------------------------------- END COMPLEXTYPE FOR DIFFERENT FUNCTIONS ----------------------------------------
	
	//------------------------------- START REGISTER FOR DIFFERENT FUNCTIONS ----------------------------------------

	
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


	//first function implementation
	/*function hello($username) {
			return 'Howdy, '.$username.'!';
	}*/
	//------------------------------- END REGISTER FOR DIFFERENT FUNCTIONS ----------------------------------------

	//------------------------------- START DEFINE DIFFERENT FUNCTIONS ----------------------------------------
	
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
							//$successArr["informations"] = $ret_msg_;					
							#$successArr["informations"] = json_encode($tmp);					
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
	
	
	
	function makeBatchPayment($username, $password, $batchId, $cardNumber, $expiryMonthYear, $cvvNumber)
	{
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
			else
			{
				if($batchId!='')
				{
					$batch_info = _info_batch_details_information($batchId);
					if(!empty($batch_info)) // batch_info validated
					{
						// first check if there is any form against this batch
						$tot_price = 0;
						$where = " WHERE n.s_batch_code = '".addslashes($batchId)."' GROUP BY n.s_form_id ";
						$forms_info = _info_forms_payee_payment($where);
							
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
	//------------------------------- END DEFINE DIFFERENT FUNCTIONS ----------------------------------------
	
	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';

	$server->service($HTTP_RAW_POST_DATA);
	
?>
