<?php



	//get listing report and do against fixed price
	$listrep_final = $dbase_getters->get_list_rep();

	//loop through listing report and search active listings for existing skus which are fixed price, onmarket, and 1 or more units in stock.

	$fh = fopen(EB_TEN_DAY_LIST, 'w') or die("can't open file");
	fwrite($fh,"SKU	QUANTITY TO LIST	DIS PRICE	SHIP PRICE	FREE SHIP SELL PRICE	DAYS	LISTING TYPE" . NLMAIN);
	fclose($fh);

	echo "<br/>SKU	QUANTITY TO LIST	DIS PRICE	SHIP PRICE	FREE SHIP SELL PRICE	DAYS	LISTING TYPE";

	for ($z=0; $z < sizeof($listrep_final[EBAY_LIST_REP_ID]) ;$z++){
		$sku = $listrep_final[EBAY_LIST_REP_SKU][$z];
		$list_quantity = $listrep_final[EBAY_LIST_REP_AVAIL][$z];
		
		//check sku is on ebay
		$select_acols[0]  = EB_ACT_ID;

		//check for sku and listings type. 
		$where_acols[0][0] = EB_ACT_SKU;
		$where_acols[0][1] = $sku;
		$where_acols[1][0] = EB_ACT_LIST_TYPE;
		$where_acols[1][1] = EBAY_TYPE_CODE_FIXED;

		$activefinals = $dbase_getters->basic_get(EB_ACT_EBAY_ACTIVE, $select_acols, $where_acols, "", "");

		//add the listing if no result is returned for the sku and fixed price listings

		if (sizeof($activefinals[EB_ACT_ID]) <= 0){

			//get dis price & stock level
			$select_cols[0]  = ITEM_DISPRICE;
			$select_cols[1]  = ITEM_STOCK_LEVEL;

			$where_cols[0][0] = ITEM_SS_SKU;
			$where_cols[0][1] = $sku;

			$itemfinals = $dbase_getters->basic_get(ITEM_MAIN_TABLE, $select_cols, $where_cols, "", "");

			//only continue if dis price exists and stock level is over >= 1
			if (sizeof($itemfinals[ITEM_DISPRICE]) > 0){
				
				if ($itemfinals[ITEM_STOCK_LEVEL][0] > 2){
					$disprice = $itemfinals[ITEM_DISPRICE][0];

					//get ship price
					$select_xcols[0]  = EBAY_SHIP_PRICE_PRICE;

					$where_xcols[0][0] = EBAY_SHIP_PRICE_SKU;
					$where_xcols[0][1] = $sku;

					$shipfinals = $dbase_getters->basic_get(EBAY_SHIP_PRICE_TABLE, $select_xcols, $where_xcols, "", "");
					

					if (sizeof($shipfinals[EBAY_SHIP_PRICE_PRICE]) > 0){
						$shipprice = $shipfinals[EBAY_SHIP_PRICE_PRICE][0];

						echo "<br/>" . $sku . "	1	" . $disprice . "	" . $shipprice . "	". ($disprice + $shipprice) ."	Days_10	" . EBAY_TYPE_CODE_FIXED;


						$fh = fopen(EB_TEN_DAY_LIST, 'a') or die("can't open file");
						fwrite($fh,$sku . "	1	" . $disprice . "	" . $shipprice . "	".($disprice + $shipprice) . "	Days_10	" . EBAY_TYPE_CODE_FIXED . NLMAIN);
						fclose($fh);

					}
				}


			}



			
		}

	}






?>