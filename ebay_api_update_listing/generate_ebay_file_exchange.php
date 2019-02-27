<?php


		
	set_time_limit(0);
	header( 'Content-type: text/html; charset=utf-8' );
	
	//prep the main string
	$stringData = "";

	//prep_output_file
	$date_for_filename = date("Y_m_d_h_i_sa"); 
	$file_to_write = "output/" . $date_for_filename . "_ebay_filexchange_output.txt";

	//create the file
	$fh = fopen($file_to_write, 'w') or die("can't open file");
	fwrite($fh, $stringData);
	fclose($fh);





		
	//adds new item
	$titles['User ID'] = "User ID";
	$titles['Buyer Fullname'] = "Buyer Fullname";
	$titles['Buyer Email'] = "Buyer Email";
	$titles['Order ID'] = "Order ID";
	$titles['Item ID'] = "Item ID";
	$titles['Transaction ID'] = "Transaction ID";
	$titles['Quantity'] = "Quantity";
	$titles['Sale Price'] = "Sale Price";
	$titles['Postage and Handling'] = "Postage and Handling";
	$titles['Sale Date'] = "Sale Date";
	$titles['Custom Label'] = "Custom Label";
	$titles['Variation Details'] = "Variation Details";
	$titles['Post To Address 1'] = "Post To Address 1";
	$titles['Post To Address 2'] = "Post To Address 2";
	$titles['Post To City'] = "Post To City";
	$titles['Post To State'] = "Post To State";
	$titles['Post To Postcode'] = "Post To Postcode";
	$titles['Post To Country'] = "Post To Country";
	$titles['Paid on Date'] = "Paid on Date";
	


	require_once('includes/constants.inc.php');

	$fileread = file_get_contents("files/ebayfilexchange.csv");


	$file_bits = explode(NEWLINE,$fileread);

	$top_line_bits = explode(NS,$file_bits[0]);
	$toplinebitssize = sizeof($top_line_bits);
	
	//loop through titles and set keys
	for ($i=0; $i < $toplinebitssize; $i++){
		foreach ($titles as $titlevalue){
			//get the key of the entry in the file
			if (trim($top_line_bits[$i]) == trim($titlevalue)){

				//set the array key in the relative title
				$titles[$titlevalue] = $i;
				
			}
		}
	}

	$order_on = false;
	$numlines = sizeof($file_bits);

/*
	$total_quantity = 0;
	//loop through and get total counts
	for ($a=1;$a<($numlines -1);$a++){
		$linebits = explode(NS,$file_bits[$a]);
		//only do if no order number is set
		if (trim($linebits[$titles['Order ID']]) == ""){
			$total_quantity +=  trim($linebits[$titles['Quantity']]);

			echo trim($linebits[$titles['Quantity']]) . "<br/>";
		}
	}
*/

	//loop through each line, display on screen, and save in a file
	for ($i=1; $i < ($numlines); $i++){

		


		$stringData = "";
		
		//break line into bits
		$linebits = explode(NS,$file_bits[$i]);

		//Now perform the line operations
		//first check if there is an order number
		if (trim($linebits[$titles['Order ID']]) != ""){

			


			$order_on = true;
			$order_key = 0;

			//get the information
			$order_order_id = trim($linebits[$titles['Order ID']]);
			$order_user_id = trim($linebits[$titles['User ID']]);
			$order_fullname = trim($linebits[$titles['Buyer Fullname']]);
			$order_email = trim($linebits[$titles['Buyer Email']]);
			$order_order_quantity = trim($linebits[$titles['Quantity']]);
			$order_paid_date = trim($linebits[$titles['Paid on Date']]);
			$order_post_addr_one = trim($linebits[$titles['Post To Address 1']]);
			$order_post_addr_two = trim($linebits[$titles['Post To Address 2']]);
			$order_post_city = trim($linebits[$titles['Post To City']]);
			$order_post_state = trim($linebits[$titles['Post To State']]);
			$order_post_postcode = trim($linebits[$titles['Post To Postcode']]);
			$order_post_country = trim($linebits[$titles['Post To Country']]);

			
			$order_post_shipping = str_replace("AU $","",trim($linebits[$titles['Postage and Handling']]));
			
			
			$address = strtoupper($order_fullname) . COMMA . strtoupper($order_post_addr_one) . COMMA .  strtoupper($order_post_addr_two) . COMMA . strtoupper($order_post_city)  . COMMA . strtoupper($order_post_state)  . "      " . $order_post_postcode;

			if ($order_post_country != "Australia" && $order_post_country != "AUSTRALIA" && $order_post_country != "AU"){
				$address .= strtoupper($order_post_country);
			}
			
			continue;
		}

		//loop through remaining lines of order. 
		if ($order_on){
			//only continue if order items is less than order quantity
			if ($order_key < $order_order_quantity){
				
				//check number of lines of item
				$quantity_sub = trim($linebits[$titles['Quantity']]);
				//display the details
				for ($x=0; $x < $quantity_sub; $x++){

					echo $i . " --- ";
					echo trim($linebits[$titles['Custom Label']]) . "<br>";
					
					$order_key++;
				
					//display the lines
					$stringData = "";

					$stringData .= $i . TAB_DELIM;
					$stringData .=  trim($linebits[$titles['Sale Date']]) . TAB_DELIM;
					$stringData .=  trim($linebits[$titles['Transaction ID']]) .TAB_DELIM;
					$stringData .=  trim($linebits[$titles['Item ID']]) . TAB_DELIM;
					$stringData .=  $order_order_id . TAB_DELIM;
					$stringData .= trim($linebits[$titles['Variation Details']]) . TAB_DELIM;
					$stringData .=  trim($linebits[$titles['Custom Label']])  . TAB_DELIM;
					$stringData .=  "" . TAB_DELIM;
					$stringData .=  "1" . TAB_DELIM;
					$stringData .=  $order_email . TAB_DELIM;
					$stringData .=  $order_user_id . TAB_DELIM;
					$stringData .=  $address . TAB_DELIM;
					$stringData .=  str_replace("AU $","",trim($linebits[$titles['Sale Price']]))  . TAB_DELIM;
					$stringData .=  str_replace("AU $","",trim($linebits[$titles['Sale Price']])) . TAB_DELIM;

					if ($order_key == 0){
						$stringData .=  $order_post_shipping . TAB_DELIM;
					}
					else{
						$stringData .=  "" . TAB_DELIM;
					}

					$stringData .=  $order_paid_date . TAB_DELIM;

					$stringData .= NEWLINEMAIN;


					//add to the file
					$fh = fopen($file_to_write, 'a') or die("can't open file");
					fwrite($fh, $stringData);
					fclose($fh);


				}
			}
			else {
				$order_on = false;
				$order_key = 0;
				
			}

		}
		
		//standard lines
		if (!$order_on){
		
			$user_id = trim($linebits[$titles['User ID']]);
			$fullname = trim($linebits[$titles['Buyer Fullname']]);
			$email = trim($linebits[$titles['Buyer Email']]);
			$quantity = trim($linebits[$titles['Quantity']]);
			$paid_date = trim($linebits[$titles['Paid on Date']]);
			$post_addr_one = trim($linebits[$titles['Post To Address 1']]);
			$post_addr_two = trim($linebits[$titles['Post To Address 2']]);
			$post_city = trim($linebits[$titles['Post To City']]);
			$post_state = trim($linebits[$titles['Post To State']]);
			$post_postcode = trim($linebits[$titles['Post To Postcode']]);
			$post_country = trim($linebits[$titles['Post To Country']]);
			$sale_price = str_replace("AU $","",trim($linebits[$titles['Sale Price']]));
			$item_id = trim($linebits[$titles['Item ID']]);
			$trans_id = trim($linebits[$titles['Transaction ID']]);
			$shipping = str_replace("AU $","",trim($linebits[$titles['Postage and Handling']]));
			$saledate = trim($linebits[$titles['Sale Date']]);
			$sku = trim($linebits[$titles['Custom Label']]);
			$item_details = trim($linebits[$titles['Variation Details']]);
			

			//parse the address 
			$address = strtoupper($fullname) . COMMA . strtoupper($post_addr_one) . COMMA .  strtoupper($post_addr_two) . COMMA . strtoupper($post_city)  . COMMA . strtoupper($post_state)  . "      " . $post_postcode;

			if ($post_country != "Australia" && $post_country != "AUSTRALIA" && $post_country != "AU"){
				$address .= COMMA . strtoupper($post_country);
			}
			



			for ($p=0; $p < $quantity; $p++){
echo $i . " --- ";
					echo trim($linebits[$titles['Custom Label']]) . "<br>";

				//display the lines


				$stringData = "";

				$stringData .= $i . TAB_DELIM;
				$stringData .=  $saledate . TAB_DELIM;
				$stringData .=  $trans_id . TAB_DELIM;
				$stringData .=  $item_id . TAB_DELIM;
				$stringData .=  "" . TAB_DELIM;
				$stringData .=  $item_details . TAB_DELIM;
				$stringData .=  $sku . TAB_DELIM;
				$stringData .=  "" . TAB_DELIM;
				$stringData .=  "1" . TAB_DELIM;
				$stringData .=  $email . TAB_DELIM;
				$stringData .=  $user_id . TAB_DELIM;
				$stringData .=  $address . TAB_DELIM;
				$stringData .=  $sale_price . TAB_DELIM;
				$stringData .=  $sale_price . TAB_DELIM;
				$stringData .=  $shipping . TAB_DELIM;

				$stringData .=  $paid_date . TAB_DELIM;

				$stringData .= NEWLINEMAIN;


				//add to the file
				$fh = fopen($file_to_write, 'a') or die("can't open file");
				fwrite($fh, $stringData);
				fclose($fh);
			}
		}



	}
	

?>