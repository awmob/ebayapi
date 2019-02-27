<?php

	//adds new item

	require_once('includes/constants.inc.php');

	// Load configuration file
	require_once('includes/config.inc.php');
	require_once('classes/GeteBayDetails.class.php');
	require_once('classes/call_functions.class.php');
	require_once('classes/domFunctions.class.php');

	
	$call_functions = new call_functions();
	$getebaydetails = new GeteBayDetails();
	$dom_functions = new domFunctions();


	//get the xml for shipping details
	$xml_request = $getebaydetails->shipping_service_details($auth_token);

	//Create headers to send with CURL request.
	$headers = $call_functions->headersmain($compat_level, $dev_id, $app_id, $cert_id, CALL_NAME_GET_EBAY_DETAILS, AUSTRALIA_SITE_ID);

	// Send request to eBay and load response in $response
	$response = $call_functions->curler($api_endpoint, $headers, $xml_request);


	// Create DOM object and load eBay response
	$dom = new DOMDocument();
	$dom->loadXML($response);

	// Parse data accordingly.
	$ack = $dom_functions->ack_success($dom);
	
	//only perform if returned successfully
	if ($ack == ACK_SUCCESS){
		//ShippingService


		$shipping_methods_array = $dom_functions->get_shipping_methods($dom);

		for ($i=0; $i < sizeof($shipping_methods_array)  ;$i++){
			echo $shipping_methods_array[$i] . "<br/>";

		}

	}






















?>