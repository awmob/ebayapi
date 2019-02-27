<?php
	
	set_time_limit(0);
	error_reporting(E_ALL ^ E_NOTICE);
	header( 'Content-type: text/html; charset=utf-8' );
	//adds new item

	require_once('includes/constants.inc.php');

	// Load configuration file
	require_once('includes/config.inc.php');
	require_once('classes/updateItem.class.php');
	require_once('classes/call_functions.class.php');
	require_once('classes/domFunctions.class.php');
	
	$reviseItem = new updateItem();
	$call_functions = new call_functions();
	$dom_functions = new domFunctions();
	

	
	echo "Running... Please wait...";
	flush();
	ob_flush();

	echo "<hr/>";
	flush();
	ob_flush();

	
	$fileread = file_get_contents("files/send_note.csv");

	//file_read_lines
	$lines = explode(NS,$fileread);
	

	for ($i=0; $i<sizeof($lines); $i++){

		$bits = explode(TAB_DELIM, $lines[$i]);
		
		//temprorray trans id
		$transid = trim(preg_replace('/\s\s+/', ' ',$bits[0]));
		$itemtempid = trim(preg_replace('/\s\s+/', ' ',$bits[1]));
		$note = trim(preg_replace('/\s\s+/', ' ',$bits[2]));
		

		//get the xml for a new auction
		$xml_request = $reviseItem->setnote($auth_token, $transid,$itemtempid, $note);

		//Create headers to send with CURL request.
		$headers = $call_functions->headersmain($compat_level, $dev_id, $app_id, $cert_id, CALL_NAME_ADD_USER_NOTE, AUSTRALIA_SITE_ID);

		// Send request to eBay and load response in $response
		$response = $call_functions->curler($api_endpoint, $headers, $xml_request);
		
		
		// Create DOM object and load eBay response
		$dom = new DOMDocument();
		$dom->loadXML($response);

		$item_add_return_array = $dom_functions->set_notes_dom($dom);
		
		echo $transid ." ... ";
		echo $itemtempid." ... ";
		echo $note." ... ";
		echo $item_add_return_array['error'];
	
	}
	







?>