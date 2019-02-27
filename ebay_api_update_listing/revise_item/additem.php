<?php
	
	set_time_limit(0);
	header( 'Content-type: text/html; charset=utf-8' );
	//adds new item

	

	require_once('includes/constants.inc.php');

	// Load configuration file
	require_once('includes/config.inc.php');
	require_once('classes/addItem.class.php');
	require_once('classes/call_functions.class.php');
	require_once('classes/domFunctions.class.php');
	//temporary template - use database in proper version
	require_once('includes/template.inc.php');


	$addItem = new addItem();
	$call_functions = new call_functions();
	$dom_functions = new domFunctions();

	/* INPUT_FILE_DEFINITION
	
	sku
	title
	description
	cat_id
	price
	img1
	img2
	img3
	img4
	img5
	img6
	shipping
	storeid
	quantity
	listing_type
	listing_duration
	description type (blank or 0 is standard, 1 is modified)
	| - delimits end of line with pipe

	*/

	//read the input file
	$fileread = file_get_contents(FILE_LISTINGS);
	//separate into lines
	$file_bits = explode(NS,$fileread);

	echo "Running... Please wait...";
	flush();
	ob_flush();

	echo "<hr/>";
	flush();
	ob_flush();

	for ($i=0; $i < sizeof($file_bits) ;$i++){
		

		//only do if line is not empty
		if (trim($file_bits[$i]) != ""){
			//need to add error checking

			//separate bits into more bits
			$file_segments = explode(TAB_DELIM,$file_bits[$i]);


			//end title hack
			
			$country_letter_code = AUSTRALIA_COUNTRY_CODE;
			$currency = AUSTRALIA_CURRENCY;
			$dispatch_time = DISPATCH_TIME_DAYS;
			$paypal_email = PAYPAL_EMAIL;
			$postcode = POSTCODE;
			$returns_msg = utf8_encode(RETURNS_MSG);
			$site = "Australia";
			$ship_service = AU_STANDARD_DELIVERY;

			$sku = "XXX";
			
			$item_id = trim($file_segments[0]);




			//get the xml for a new auction
			$xml_request = $addItem->update_auction($auth_token, $item_id, $ship_service, $currency);

			//Create headers to send with CURL request.
			$headers = $call_functions->headersmain($compat_level, $dev_id, $app_id, $cert_id, CALL_NAME_REVISEITEM, AUSTRALIA_SITE_ID);

			// Send request to eBay and load response in $response
			$response = $call_functions->curler($api_endpoint, $headers, $xml_request);
			

			// Create DOM object and load eBay response
			$dom = new DOMDocument();
			$dom->loadXML($response);

			$listing_type = "";
			
			//now show the returned details
			$item_add_return_array = $dom_functions->get_item_return_details($dom, $sku, $listing_type);
			
			//write return messages to log (later add to database
			if ($test){
				$my_file = TEST_LOGS;
			}
			else{
				$my_file = FILE_LOGS;
			}

			$fh = fopen($my_file, 'a');
			fwrite($fh, NEWLINE);

			
			
			echo "<p>";
			for ($x=0; $x < sizeof($item_add_return_array)  ;$x++){
				fwrite($fh, $item_add_return_array[$x]);
				fwrite($fh, TAB_DELIM);
				echo $item_add_return_array[$x] . "	";

			}
			fclose($fh);
			echo "<hr/>";
			echo "</p>";
			
			flush();
			ob_flush();
			
		}
	}

	ob_end_flush();

	

















?>