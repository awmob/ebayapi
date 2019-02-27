<?php
	
	

	do {
    


		//get the xml for a new auction
		$xml_request = $reviseItem->getactivelistings($auth_token, updateItem::$curpage);

		//Create headers to send with CURL request.
		$headers = $call_functions->headersmain($compat_level, $dev_id, $app_id, $cert_id, CALL_GETMYEBAYSELLING, AUSTRALIA_SITE_ID);

		// Send request to eBay and load response in $response
		$response = $call_functions->curler($api_endpoint, $headers, $xml_request);
		

		// Create DOM object and load eBay response
		$dom = new DOMDocument();
		$dom->loadXML($response);

		//now show the returned details
		$item_add_return_array = $dom_functions->get_listings_details($dom);
		
		

		
		
		echo "<p>";

		$num_of_listings = sizeof($item_add_return_array['itemnumber']);

		for ($x=0; $x < $num_of_listings ;$x++){

			//compare item numbers for pagination. Do not continue if first item number already exists.
			if ($x==0){
				if ($item_add_return_array['itemnumber'][$x] == updateItem::$live_item_number){
					$continueloop = false;
					break;
					//exit
				}
				else{
					updateItem::$live_item_number = $item_add_return_array['itemnumber'][$x];
					//page up

					updateItem::$curpage++;

					updateItem::$numlistings += $num_of_listings;

				}
			}

		
			$stringoutput = $item_add_return_array['itemnumber'][$x] . TAB_DELIM;
			$stringoutput .= $item_add_return_array['customlabel'][$x] . TAB_DELIM;
			$stringoutput .= $item_add_return_array['quantity'][$x] . TAB_DELIM;

			$quantity_sold = $item_add_return_array['quantitysoldandavailable'][$x] - $item_add_return_array['quantity'][$x];

			

			$stringoutput .= $quantity_sold . TAB_DELIM;

			$stringoutput .= "" . TAB_DELIM;

			$stringoutput .= $item_add_return_array['sellprice'][$x] . TAB_DELIM;

			$startdate = $reviseItem->modifydate($item_add_return_array['starttime'][$x]);

			$stringoutput .= $startdate['start'] . TAB_DELIM;

			$enddate = $item_add_return_array['endtime'][$x];

			if (trim($enddate == "Days_10")){
				$enddate = $startdate['end'];
			}
			else{
				$enddate = "";
			}


			$stringoutput .= $enddate . TAB_DELIM;	
			


			
			$stringoutput .= "Brand New" . TAB_DELIM;

			$stringoutput .= "9" . TAB_DELIM;

			$ittitle = str_replace("	","",trim($item_add_return_array['itemtitle'][$x]));
			
			$stringoutput .= $ittitle . TAB_DELIM;	

			$stringoutput .= "" . TAB_DELIM;	

			$stringoutput .= "0" . TAB_DELIM;	

			$stringoutput .= "" . TAB_DELIM;

			$stringoutput .= "15" . TAB_DELIM;

			$stringoutput .= "18-Jun-14 07:29:40 AEST" . TAB_DELIM;	

			$stringoutput .= "" . TAB_DELIM;
			
			$stringoutput .= "" . TAB_DELIM;

			$stringoutput .= "1000" . TAB_DELIM;




			$stringoutput .= strtoupper($item_add_return_array['stockcntrl'][$x]);

			$stringoutput .= NEWLINEMAIN;

			echo $x ."... ";	
			flush();
			ob_flush();


			//add the line to the file
			$fh = fopen(ACTIVE_OUTPUT, 'a') or die("can't open file");
			
			fwrite($fh, $stringoutput);
			fclose($fh);

			flush();
			ob_flush();

		}



		echo "Imported Page " . (updateItem::$curpage - 1) ."..." . $num_of_listings . " listings...";
		echo "</p>";
		flush();
		ob_flush();
	
	} while ($continueloop == true);////while (updateItem::$curpage < 1);

	echo "<p><strong>TOTAL ACTIVE LISTINGS: " . updateItem::$numlistings . "</strong></p>";

	echo "<p>Output is available at: <strong><a href='".ACTIVE_OUTPUT."'>".ACTIVE_OUTPUT."</a></strong></p>";
	

	ob_end_flush();

	

















?>