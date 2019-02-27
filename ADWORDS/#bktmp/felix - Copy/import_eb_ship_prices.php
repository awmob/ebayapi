<?php

	$error_shower = $dsfeed_funcs->file_import_processing(basename($_FILES['uploadfilename']['name']), $_FILES['uploadfilename']['tmp_name']);
						
	if ($error_shower[0]){


		$display .= $error_shower[1];
		
	}
	
	//file is okay
	else{
		
		//get the contents of the file and set into a variable
		$tmpfile_data = $error_shower[1];
		

		//upload received for 
		if ($_POST['uploadfile'] == 1){

			echo "Checking file for compatability. . .  ";
			flush();
			ob_flush();
			$upload_error = $dsfeed_funcs->importcheck($ebayshippricehead, $feed_reader, $tmpfile_data, TABDELIM);
			


			if (!$upload_error[0]){



				$lines_and_bits = $upload_error[2];
				$feed_header_check = $upload_error[3];
				

				echo "Entering data into system. . . ";
				flush();
				ob_flush();

				$countadd = 0;
				$countupdate = 0;
				$totalcount = sizeof($lines_and_bits) - 1;
				
				//start entering data
				for ($i=2; $i < sizeof($lines_and_bits)  ;$i++){
					if ($i % 10 == 0){
						echo ". ";
						flush();
						ob_flush();
					}

					$sku = trim($lines_and_bits[$i][$feed_header_check['SKU']]);
					$shipprice = trim($lines_and_bits[$i][$feed_header_check['Shipprice']]);

					//check if sku exists in kd. If not exists, skip line and go to next
					$sku_get_col[0] = EBAY_SHIP_PRICE_SKU;
					$sku_get_col[1] = EBAY_SHIP_PRICE_PRICE;
					$sku_exists = $dbase_getters->get_ship_line($sku, $sku_get_col);

					if (sizeof($sku_exists) > 0){
						//update
						
						$cols[0][0] = EBAY_SHIP_PRICE_PRICE;
						$cols[0][1] = $shipprice;
						$where[0][0] = EBAY_SHIP_PRICE_SKU;
						$where[0][1] = $sku;

						$dbase_setters->update_query(EBAY_SHIP_PRICE_TABLE, $cols, $where);

						$countupdate++;
					}

					else{
						//insert
						$cols = array();

						$cols[0][0] = EBAY_SHIP_PRICE_SKU;
						$cols[1][0] = EBAY_SHIP_PRICE_PRICE;
						
						$cols[0][1] = $sku;
						$cols[1][1] = $shipprice;

						$dbase_setters->insert_query(EBAY_SHIP_PRICE_TABLE, $cols);
						$countadd++;
					}

				}




				$display .= "<div class='alertok'>";
					$display .= $upload_error[1] . "... " . $countupdate . " skus updated. ". $countadd . " new skus added. " . ($totalcount-1) . " skus were in the file.";
				$display .= "</div>";

			}


			//upload error
			else if ($upload_error[0]){
				$display .= "<div class='alerterror'>";
					$display .= $upload_error[1];
				$display .= "</div>";
			}

		}
	}











?>