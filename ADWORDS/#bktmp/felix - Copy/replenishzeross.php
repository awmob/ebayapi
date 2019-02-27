<?php



	//get listing report and do against fixed price
	$listrep_final = $dbase_getters->get_list_rep();

	//loop through listing report and search active listings for existing skus which are fixed price, onmarket, and 0 units in stock.

	$fh = fopen(EB_SS_REPLENISHFILE, 'w') or die("can't open file");
	fwrite($fh,"SKU	EBAY ID	STOCK TO ADD	" . NLMAIN);
	fclose($fh);

	echo "<br/>SKU	EBAY ID	STOCK TO ADD	";

	for ($z=0; $z < sizeof($listrep_final[EBAY_LIST_REP_ID]) ;$z++){

		$sku = $listrep_final[EBAY_LIST_REP_SKU][$z];
		$list_quantity = $listrep_final[EBAY_LIST_REP_AVAIL][$z];

		
		//check sku is on ebay
		$select_acols[0]  = EB_ACT_ID;
		$select_acols[1]  = EB_ACT_ITEM_ID;
		$select_acols[2]  = EB_ACT_PURCHASES;

		//check for sku and listings type.  - fixed price, blank end date, Quantity is 0
		$where_acols[0][0] = EB_ACT_SKU;
		$where_acols[0][1] = $sku;
		$where_acols[1][0] = EB_ACT_LIST_TYPE;
		$where_acols[1][1] = EBAY_TYPE_CODE_FIXED;
		$where_acols[2][0] = EB_ACT_END_DATE;
		$where_acols[2][1] = "";
		$where_acols[3][0] = EB_ACT_QUANTITY;
		$where_acols[3][1] = 0;

		$activefinals = $dbase_getters->basic_get(EB_ACT_EBAY_ACTIVE, $select_acols, $where_acols, "", "");

		//update the listing if a result exists and stock level is greater than 2
		if (sizeof($activefinals[EB_ACT_ID]) >= 1){

			$ebayid = $activefinals[EB_ACT_ITEM_ID][0];
			$purchases = $activefinals[EB_ACT_PURCHASES][0];

			//get stock level
			$select_cols[0]  = ITEM_STOCK_LEVEL;

			$where_cols[0][0] = ITEM_SS_SKU;
			$where_cols[0][1] = $sku;

			$itemfinals = $dbase_getters->basic_get(ITEM_MAIN_TABLE, $select_cols, $where_cols, "", "");

			//only continue if item exists and stock level is over >= 1
			if (sizeof($itemfinals[ITEM_STOCK_LEVEL]) > 0){
				
				if ($itemfinals[ITEM_STOCK_LEVEL][0] > 1){

					
					//set level to add.
					$stocklevel = $itemfinals[ITEM_STOCK_LEVEL][0];

					if ($list_quantity > $stocklevel){
						$stocklevelhalf = ceil($stocklevel/2);
					}
					else{
						$stocklevelhalf = ceil($list_quantity/2);
					}

					$stocklevelhalf = ceil($stocklevel/2);

					if ($stocklevelhalf >= 1){

						if ($stocklevelhalf > 5){
							$stocktoadd = 5;
						}
						else{
							$stocktoadd = $stocklevelhalf;
						}

						if ($purchases <= 5){
							if ($stocktoadd >= 4){
								$stocktoadd = 2;
							}
						}



						echo "<br/>" . $sku . "	" . $ebayid . "	" . $stocktoadd . " |";


						$fh = fopen(EB_SS_REPLENISHFILE, 'a') or die("can't open file");
						fwrite($fh,$sku . "	" . $ebayid . "	" . $stocktoadd . " |" . NLMAIN);
						fclose($fh);

					}

				}


			}



			
		}

	}






?>