<?php




	//create the first file
	$fh = fopen(ACTIVE_OUTPUT, 'w') or die("can't open file");
	fclose($fh);

	
	require_once EBAY_API_FILESYSTEM_CONSTANTS;
	require_once(EBAY_API_FILESYSTEM_CONFIG);
	require_once(EBAY_API_FILESYSTEM_UPDATE_ITEM);
	require_once(EBAY_API_FILESYSTEM_CALL_FUNCTIONS);
	require_once(EBAY_API_FILESYSTEM_DOM_FUNCTIONS);


	$reviseItem = new updateItem();
	$call_functions = new call_functions();
	$dom_functions = new domFunctions();


	//loop settings
	$continueloop = true;

	$writemestring = "Item ID	Custom Label	Quantity Available	Purchases	Bids	Price	Start Date	End Date	Condition	Type	Item Title	Category Leaf Name	Category Number	Private Notes	Site Listed	Download Date	Variation Details	Product Reference ID	Condition ID	OutOfStockControl	LISTING TYPE (DELETE THIS COLUMN IF PERFORMING KERP IMPORT)" . NEWLINEMAIN;


	//write header to file
	$fh = fopen(ACTIVE_OUTPUT, 'a') or die("can't open file");
	fwrite($fh, $writemestring);
	fclose($fh);

	//clear the table
	$dbase_setters->clear_table(EB_ACT_EBAY_ACTIVE);

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
					//echo "TEST";
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



///////////////////////////enter into database
			$ebay_itemnumber = $item_add_return_array['itemnumber'][$x];
			$ebay_sku = trim($item_add_return_array['customlabel'][$x]);
			$ebay_quantity = $item_add_return_array['quantity'][$x];
			$quantity_sold = $item_add_return_array['quantitysoldandavailable'][$x] - $item_add_return_array['quantity'][$x];
			$price = $item_add_return_array['sellprice'][$x];

			/*echo $item_add_return_array['starttime'][$x];
			echo " | ";
			echo $ebay_sku;
			echo "<br/>";*/


			

			
			$list_type_add = $item_add_return_array['listingtype'][$x];
			$enddate = $item_add_return_array['endtime'][$x];



			if (trim($enddate) == EBAY_DAYS_TEN){
				$startdate = $reviseItem->modifydateflexi($item_add_return_array['starttime'][$x], DAYS_TEN_SECS);
				$enddate = $startdate['end'];
			}
			else if (trim($enddate) == EBAY_DAYS_FIVE){
				$startdate = $reviseItem->modifydateflexi($item_add_return_array['starttime'][$x], DAYS_FIVE_SECS);
				$enddate = $startdate['end'];
			}
			else if (trim($enddate) == EBAY_DAYS_THREE){
				$startdate = $reviseItem->modifydateflexi($item_add_return_array['starttime'][$x], DAYS_THREE_SECS);
				$enddate = $startdate['end'];
			}
			else{
				$startdate = $reviseItem->modifydateflexi($item_add_return_array['starttime'][$x], DAYS_TEN_SECS);
				$enddate = "";
			}

			
			$ittitle = str_replace("	","",trim($item_add_return_array['itemtitle'][$x]));

			$stock_cntrl = strtoupper($item_add_return_array['stockcntrl'][$x]);

			if ($stock_cntrl == "TRUE"){
				 $stock_cntrl_binary = 1;
			}
			else{
				$stock_cntrl_binary = 0;
			}
			 
			//check item database for sku details
			$db_itemfields[0] = ITEM_STOCK_TYPE;
			$db_itemfields[1] = ITEM_DROPSHIPPER_ID; 
			$db_item_final = $dbase_getters->get_ss_line($ebay_sku, $db_itemfields);

			if (sizeof($db_item_final[ITEM_STOCK_TYPE]) > 0){
				$stock_type = $db_item_final[ITEM_STOCK_TYPE][0];
				$ds_id = $db_item_final[ITEM_DROPSHIPPER_ID][0];

				//insert into database
				$active_insert_cols = array();

				$active_insert_cols[0][0] = EB_ACT_ITEM_ID;
				$active_insert_cols[0][1] = $ebay_itemnumber;
				$active_insert_cols[1][0] = EB_ACT_SKU;
				$active_insert_cols[1][1] = $ebay_sku;
				$active_insert_cols[2][0] = EB_ACT_QUANTITY;
				$active_insert_cols[2][1] = $ebay_quantity;
				$active_insert_cols[3][0] = EB_ACT_PURCHASES;
				$active_insert_cols[3][1] = $quantity_sold;
				$active_insert_cols[4][0] = EB_ACT_PRICE;
				$active_insert_cols[4][1] = $price;
				$active_insert_cols[5][0] = EB_ACT_START_DATE;
				$active_insert_cols[5][1] = $startdate['start'];
				$active_insert_cols[6][0] = EB_ACT_END_DATE;
				$active_insert_cols[6][1] = $enddate;
				$active_insert_cols[7][0] = EB_ACT_TITLE;
				$active_insert_cols[7][1] = $ittitle;
				$active_insert_cols[8][0] = EB_ACT_OS_CONTROL;
				$active_insert_cols[8][1] = $stock_cntrl_binary;
				$active_insert_cols[9][0] = EB_ACT_STOCK_TYPE;
				$active_insert_cols[9][1] = $stock_type;
				$active_insert_cols[10][0] = EB_ACT_DROPSHIP_ID;
				$active_insert_cols[10][1] = $ds_id;
				$active_insert_cols[11][0] = EB_ACT_LIST_TYPE;
				$active_insert_cols[11][1] = $list_type_add;


				$dbase_setters->insert_query(EB_ACT_EBAY_ACTIVE, $active_insert_cols);
			}

			else{
				if ($ebay_quantity > 0){
					echo "<p><b>" . $ebay_sku . "</b> has " .$ebay_quantity. " units available on eBay but is not on latest KD. Investigate the reason.</p>";
				}
			}

			

///////////////////////////////create the output file

		
			$stringoutput = $item_add_return_array['itemnumber'][$x] . TAB_DELIM;
			$stringoutput .= $item_add_return_array['customlabel'][$x] . TAB_DELIM;
			$stringoutput .= $item_add_return_array['quantity'][$x] . TAB_DELIM;

			

			

			$stringoutput .= $quantity_sold . TAB_DELIM;

			$stringoutput .= "" . TAB_DELIM;

			$stringoutput .= $item_add_return_array['sellprice'][$x] . TAB_DELIM;

			

			$stringoutput .= $startdate['start'] . TAB_DELIM;



			$stringoutput .= $enddate . TAB_DELIM;	
			
			$stringoutput .= "Brand New" . TAB_DELIM;

			$stringoutput .= "9" . TAB_DELIM;

			
			$stringoutput .= $ittitle . TAB_DELIM;	

			$stringoutput .= "" . TAB_DELIM;	

			$stringoutput .= "0" . TAB_DELIM;	

			$stringoutput .= "" . TAB_DELIM;

			$stringoutput .= "15" . TAB_DELIM;

			$stringoutput .= date("d-M-y G:i:s"). " AEST" . TAB_DELIM;

			$stringoutput .= "" . TAB_DELIM;
			
			$stringoutput .= "" . TAB_DELIM;

			$stringoutput .= "1000" . TAB_DELIM;

			$stringoutput .= $stock_cntrl . TAB_DELIM;

			$stringoutput .= $list_type_add . TAB_DELIM;


			$stringoutput .= NEWLINEMAIN;

			echo " .";	
			flush();
			ob_flush();


			//add the line to the file
			$fh = fopen(ACTIVE_OUTPUT, 'a') or die("can't open file");
			
			fwrite($fh, $stringoutput);
			fclose($fh);

			flush();
			ob_flush();

		}

		if (!$continueloop){
			break;
		}

		echo "<br/><b>Imported Page " . (updateItem::$curpage - 1) .". . . " . $num_of_listings . " listings. . .</b>";
		echo "</p>";
		flush();
		ob_flush();
	
	//} while (updateItem::$curpage < 1);

	}while ($continueloop == true);



?>