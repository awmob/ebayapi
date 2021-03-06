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

	/* INPUT_FILE_DEFINITION
	
	sku
	ebay_item_id_number
	stock_level
	price
	
	| - delimits end of line with pipe

	*/

	//read the input file
	$fileread = file_get_contents(MARKSHIPPED);
	//separate into lines
	$file_bits = explode(NS,$fileread);
	echo "<h2>Mark Items as Shipped & Leave Feedback</h2>";
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

			$transid = $file_segments[0];
			$item_id = $file_segments[1];
			$multiorder = $file_segments[2];  //order number. If none set to false

			if (trim($multiorder) == ""){
				$multiorder = false;
			}
			$username = $file_segments[3];
			


			//DISPLAY INFO
			$linenumber = $i+1;
			echo "Line " . $linenumber . " : <b>Trans ID#</b> " . $transid . "... <b>ITEM ID#</b> " . $item_id . "... <b>ORDER ID#</b> (Blank if single item) " . $multiorder . "... <b>USERNAME:</b> " . $username; 
		
			//END DISPLAY INFO

			//get the xml for a new auction
			//$xml_request = $updateItem->update_price_and_stocksku($auth_token, $ebay_id, $stock_level, $item_price, $sku);

			$xml_request = $updateItem->mark_shipped($auth_token, $item_id, $username, $multiorder,  $transid);

			//Create headers to send with CURL request.
			$headers = $call_functions->headersmain($compat_level, $dev_id, $app_id, $cert_id, CALL_COMPLETESALE, AUSTRALIA_SITE_ID);

			// Send request to eBay and load response in $response
			$response = $call_functions->curler($api_endpoint, $headers, $xml_request);
			

			// Create DOM object and load eBay response
			$dom = new DOMDocument();
			$dom->loadXML($response);

			//now show the returned details
			$item_add_return_array = $dom_functions->get_mark_shipped_details($dom, $username, $transid);
			
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