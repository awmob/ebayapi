<?php

	//prep the dropshipper deplete stock file

	echo "Running. Please wait. . . ";

	$fileheader = "SKU	EBAY ID	STOCK ON EBAY	STOCK LEVEL TO SET TO" . NLMAIN;

	$fh = fopen(DEPLETE_EB_DS , 'w');
	fwrite($fh,$fileheader);
	fclose($fh);


	//get listings from active listings table above 0

	$active_final = $dbase_getters->get_ds_active_listings_stock_over_x(1);

	//loop through the items
	for ($i=0; $i < sizeof($active_final[EB_ACT_ITEM_ID])  ;$i++){

		$ds_details = $dbase_getters->get_ds_details($active_final[EB_ACT_DROPSHIP_ID][$i]);

		if (sizeof($ds_details[DS_TYPES_MIN_EBAY_STOCK]) > 0){
			$min_eb_stock = $ds_details[DS_TYPES_MIN_EBAY_STOCK][0];
		}
		else{
			$min_eb_stock = DEFAULT_EBAY_BUFFER;
		}

		

		//get stock level from item table
		$select_cols[0] = ITEM_STOCK_LEVEL;
		$select_cols[1] = ITEM_ON_MARKET;


		$where_cols[0][0] = ITEM_SS_SKU;
		$where_cols[0][1] = $active_final[EB_ACT_SKU][$i];
		$where_cols[1][0] = ITEM_DROPSHIPPER_ID;
		$where_cols[1][1] = $active_final[EB_ACT_DROPSHIP_ID][$i];

		$item_final = $dbase_getters->basic_get(ITEM_MAIN_TABLE, $select_cols, $where_cols, "", "");

		if (sizeof($item_final[ITEM_STOCK_LEVEL]) > 0){
			//enter into the file if exists

			//stock level
			$kerp_stock_level = $item_final[ITEM_STOCK_LEVEL][0];
			$kerp_onmarket = $item_final[ITEM_ON_MARKET][0];
			
			//add if kerp stock level is below the required amount
			if (($kerp_stock_level < $min_eb_stock) || ($kerp_onmarket == ITEM_OFF_MARKET_STATUS_SET)){
				$data_entry = $active_final[EB_ACT_SKU][$i];
				$data_entry .= TABDELIM;
				$data_entry .= $active_final[EB_ACT_ITEM_ID][$i];
				$data_entry .= TABDELIM;
				$data_entry .= $active_final[EB_ACT_QUANTITY][$i];
				$data_entry .= TABDELIM;
				$data_entry .= "0";
				$data_entry .= NLMAIN;

				$fh = fopen(DEPLETE_EB_DS , 'a');
				fwrite($fh,$data_entry);
				fclose($fh);

				echo " .";
			}


		}






	}


?>