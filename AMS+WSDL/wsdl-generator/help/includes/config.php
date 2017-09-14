<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

// ~~~~~~ For Documentation [Begin] ~~~~~~
	$menu_parent_links = array('overview'        => 'Overview',
							   'server-req'      => 'Server Requirement(s)',
							   'sample-call'    => 'Sample API Call',
							   'public-api-calls'=> 'Public API Calls');
	$menu_sub_links = array('soap-transmit-response' => 'transmit',
						    'soap-create-user-account' => 'createUserAccount',
						    'soap-change-password' => 'changePassword',
						    'soap-request-new-password' => 'requestNewPassword',
						    'soap-get-batch-status' => 'getBatchStatus',
						    'soap-get-all-batch-numbers' => 'getAllBatchNumbers',
						    'soap-get-batch-details' => 'getBatchDetails',
						    'soap-get-payer-recipient-details' => 'getPayerRecipientDetails',
						    'soap-make-batch-payment' => 'makeBatchPayment'
				    	   );
// ~~~~~~ For Documentation [End] ~~~~~~
