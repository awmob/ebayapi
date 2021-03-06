<?php
	
	set_time_limit(0);
	header( 'Content-type: text/html; charset=utf-8' );
	//adds new item

	

	require_once('includes/constants.inc.php');

	// Load configuration file
	require_once('includes/config.inc.php');
	require_once('classes/updateItem.class.php');
	require_once('classes/call_functions.class.php');
	require_once('classes/domFunctions.class.php');
	

	$updateItem = new updateItem();
	$call_functions = new call_functions();
	$dom_functions = new domFunctions();

	

	//read the input file
	$fileread = file_get_contents(FILE_PROMOS);
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

			$sku = trim($file_segments[0]);
			$ebay_id = trim($file_segments[1]);
			$promo_id = trim($file_segments[2]);

			

			//get the xml for a new auction
			$xml_request = $updateItem->set_markdown($auth_token, $ebay_id, $promo_id);

			//Create headers to send with CURL request.
			$headers = $call_functions->headersmain($compat_level, $dev_id, $app_id, $cert_id, CALL_NAME_ADDPROMO, AUSTRALIA_SITE_ID);

			// Send request to eBay and load response in $response
			$response = $call_functions->curler($api_endpoint, $headers, $xml_request);
			

			// Create DOM object and load eBay response
			$dom = new DOMDocument();
			$dom->loadXML($response);

			//now show the returned details
			$item_add_return_array = $dom_functions->get_promo_update_details($dom, $sku, $ebay_id);
			
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
				echo $item_add_return_array[$x] . "<br/>";

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