<?php

	//adds new item

	require_once('includes/constants.inc.php');

	// Load configuration file
	require_once('includes/config.inc.php');
	require_once('classes/addItem.class.php');
	require_once('classes/call_functions.class.php');


	
	$call_functions = new call_functions();






	//get the xml for a new auction
	//$xml_request = $addItem->add_new_auction($auth_token, $sku, $title, $description, $catid, $start_price, $country_letter_code, $currency, $dispatch_time, $listing_duration, $paypal_email, $gall_img_url, $postcode, $returns_msg, $shipping_fee, $store_cat_id, $site, $ship_service);

	//Create headers to send with CURL request.
	$headers = $call_functions->headersmain($compat_level, $dev_id, $app_id, $cert_id, CALL_NAME_ADDITEM, AUSTRALIA_SITE_ID);

	// Send request to eBay and load response in $response
	$response = $call_functions->->curler($api_endpoint, $headers, $xml_request);

	echo $response;

	// Create DOM object and load eBay response
	$dom = new DOMDocument();
	$dom->loadXML($response);

	// Parse data accordingly.
	//get ebay time
	//$ack = $dom->getElementsByTagName('Ack')->length > 0 ? $dom->getElementsByTagName('Ack')->item(0)->nodeValue : '';
	//$eBay_official_time = $dom->getElementsByTagName('Timestamp')->length > 0 ? $dom->getElementsByTagName('Timestamp')->item(0)->nodeValue : '';

	//$current_price = $dom->getElementsByTagName('ConvertedCurrentPrice')->length > 0 ? $dom->getElementsByTagName('ConvertedCurrentPrice')->item(0)->nodeValue : '';

	//$description = $dom->getElementsByTagName('Description')->length > 0 ? $dom->getElementsByTagName('Description')->item(0)->nodeValue : '';

	//echo $description;
	//echo $current_price;





















?>