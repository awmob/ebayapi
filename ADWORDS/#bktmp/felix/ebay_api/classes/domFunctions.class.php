<?php


	Class domFunctions{


		
		public function ack_success($dom){
			$ack = $dom->getElementsByTagName(DOM_ELEMENT_ACK)->length > 0 ? $dom->getElementsByTagName(DOM_ELEMENT_ACK)->item(0)->nodeValue : false;

			return $ack;

		}






		//GeteBayDetails dom functions
		public function get_shipping_methods($dom){
			$ShippingServiceDetails = $dom->getElementsByTagName(DOM_ELEMENT_SHIPPING_SERVICE_DETAILS);
			
			$service_array = array();
			foreach ($ShippingServiceDetails as $item){
				array_push($service_array, $item->getElementsByTagName(DOM_ELEMENT_SHIPPING_SERVICE)->item(0)->nodeValue);
			}

			return $service_array;


		}

		//get returns after a listing has been made
		public function get_item_return_details($dom, $sku, $item_id){	
			//push each entry into new array
			$update_item_array = array();

			$update_item_response = $dom->getElementsByTagName(DOM_ELEMENT_REVISE_INV_RESPONSE);

			foreach ($update_item_response as $item){
				//ad sku to first entry of array
				array_push($update_item_array, $sku);
				
				
				array_push($update_item_array, $item_id);


				//errors
				$error_messages = $item->getElementsByTagName(DOM_ELEMENT_ERRORS);

				foreach ($error_messages as $errormsg){
					$error = trim($errormsg->getElementsByTagName(DOM_ELEMENT_SHORT_ERROR_MSG)->item(0)->nodeValue) != "" ? trim($errormsg->getElementsByTagName(DOM_ELEMENT_SHORT_ERROR_MSG)->item(0)->nodeValue) : "No Error";
					array_push($update_item_array, $error);
				}
				
				

			}

			return $update_item_array;
			
			


			//DOM_ELEMENT_SHORT_ERROR_MSG
		}



		//get returns after a listing has been made
		public function get_item_title_details($dom, $sku, $item_id){	
			//push each entry into new array
			$update_item_array = array();

			$update_item_response = $dom->getElementsByTagName(DOM_ELEMENT_REVISE_ITEM_RESPONSE);

			foreach ($update_item_response as $item){
				//ad sku to first entry of array
				array_push($update_item_array, $sku);
				
				
				array_push($update_item_array, $item_id);


				//errors
				$error_messages = $item->getElementsByTagName(DOM_ELEMENT_ERRORS);

				foreach ($error_messages as $errormsg){
					$error = trim($errormsg->getElementsByTagName(DOM_ELEMENT_SHORT_ERROR_MSG)->item(0)->nodeValue) != "" ? trim($errormsg->getElementsByTagName(DOM_ELEMENT_SHORT_ERROR_MSG)->item(0)->nodeValue) : "No Error";
					array_push($update_item_array, $error);
				}
				
				

			}

			return $update_item_array;
			
			//DOM_ELEMENT_SHORT_ERROR_MSG
		}



		//get returns after a listing has been made
		public function get_item_remove_details($dom, $sku, $item_id){	
			//push each entry into new array
			$update_item_array = array();

			$update_item_response = $dom->getElementsByTagName(DOM_ELEMENT_END_ITEM_RESPONSE);

			foreach ($update_item_response as $item){
				//ad sku to first entry of array
				array_push($update_item_array, $sku);
				
				
				array_push($update_item_array, $item_id);


				//errors
				$error_messages = $item->getElementsByTagName(DOM_ELEMENT_ERRORS);

				foreach ($error_messages as $errormsg){
					$error = trim($errormsg->getElementsByTagName(DOM_ELEMENT_SHORT_ERROR_MSG)->item(0)->nodeValue) != "" ? trim($errormsg->getElementsByTagName(DOM_ELEMENT_SHORT_ERROR_MSG)->item(0)->nodeValue) : "No Error";
					array_push($update_item_array, $error);
				}
				
				

			}

			return $update_item_array;
			
			


			//DOM_ELEMENT_SHORT_ERROR_MSG
		}

//get returns after a listing has been made
		public function get_shipcost_details($dom, $sku, $item_id){	
			//push each entry into new array
			$update_item_array = array();

			$update_item_response = $dom->getElementsByTagName(DOM_ELEMENT_SHIPCOST_RESPONSE);

			foreach ($update_item_response as $item){
				//ad sku to first entry of array
				array_push($update_item_array, $sku);
				
				
				array_push($update_item_array, $item_id);

				$costs = $item->getElementsByTagName(DOM_ELEMENT_SHIP_DETAILS);
				
				foreach ($costs as $costsmsg){
					
					$serv_opts = $costsmsg->getElementsByTagName(DOM_ELEMENT_SHIP_SERVICE_OPTIONS);
					foreach($serv_opts as $serv){
						
						$costers = trim($serv->getElementsByTagName(DOM_ELEMENT_SHIP_SERVICE_CST)->item(0)->nodeValue) != "" ? trim($serv->getElementsByTagName(DOM_ELEMENT_SHIP_SERVICE_CST)->item(0)->nodeValue) : "No Cost Entered - Error";
						array_push($update_item_array, $costers);

					}



					
				}		


				//errors
				$error_messages = $item->getElementsByTagName(DOM_ELEMENT_ERRORS);

				foreach ($error_messages as $errormsg){
					$error = trim($errormsg->getElementsByTagName(DOM_ELEMENT_SHORT_ERROR_MSG)->item(0)->nodeValue) != "" ? trim($errormsg->getElementsByTagName(DOM_ELEMENT_SHORT_ERROR_MSG)->item(0)->nodeValue) : "No Error";
					array_push($update_item_array, $error);
				}

				
				
				

			}

			return $update_item_array;

		//DOM_ELEMENT_SHORT_ERROR_MSG
		}







			
			//get returns after a listing has been made
		public function get_promo_update_details($dom, $sku, $item_id){	
			//push each entry into new array
			$update_item_array = array();

			$update_item_response = $dom->getElementsByTagName(DOM_ELEMENT_ADD_PROMO_RESPONSE);

			foreach ($update_item_response as $item){
				//ad sku to first entry of array
				array_push($update_item_array, $sku);
				
				
				array_push($update_item_array, $item_id);


				//errors
				$error_messages = $item->getElementsByTagName(DOM_ELEMENT_ERRORS);

				foreach ($error_messages as $errormsg){
					$error = trim($errormsg->getElementsByTagName(DOM_ELEMENT_SHORT_ERROR_MSG)->item(0)->nodeValue) != "" ? trim($errormsg->getElementsByTagName(DOM_ELEMENT_SHORT_ERROR_MSG)->item(0)->nodeValue) : "No Error";
					array_push($update_item_array, $error);
				}
				
				

			}

			return $update_item_array;
			
			//DOM_ELEMENT_SHORT_ERROR_MSG
		}






		//get returns after a listing has been made
		public function get_listings_details($dom){	
			//push each entry into new array
			$update_item_array = array();
			$update_item_array['itemnumber'] = array();
			$update_item_array['customlabel'] = array();
			$update_item_array['quantity'] = array();
			$update_item_array['quantitysoldandavailable'] = array();
			$update_item_array['sellprice'] = array();
			$update_item_array['starttime'] = array();
			$update_item_array['endtime'] = array();
			$update_item_array['itemtitle'] = array();
			$update_item_array['stockcntrl'] = array();
			$update_item_array['listingtype'] = array();


			$update_item_response = $dom->getElementsByTagName(DOM_ELEMENT_LISTINGSSHOW_RESPONSE);



			foreach ($update_item_response as $item){
	 			

				$activelist = $item->getElementsByTagName(DOM_ELEMENT_LISTINGS_ACTIVELIST);

				
				
				foreach ($activelist as $activelistshow){
					
					$itemarrays = $activelistshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_ITEMARRAY);


					foreach($itemarrays as $itemarray){

						$inditems = $itemarray->getElementsByTagName(DOM_ELEMENT_LISTINGS_ITEMSS);
						
					
						foreach($inditems as $inditemshow){

							$costers = trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_LISTINGTYPE)->item(0)->nodeValue) != "" ? trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_LISTINGTYPE)->item(0)->nodeValue) : "Listing Type - Error";

							array_push($update_item_array['listingtype'], $costers);

							

							$costers = trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_ITEMID)->item(0)->nodeValue) != "" ? trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_ITEMID)->item(0)->nodeValue) : "Item Num - Error";

							array_push($update_item_array['itemnumber'], $costers);

							$costers = trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_SKU)->item(0)->nodeValue) != "" ? trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_SKU)->item(0)->nodeValue) : "SKU - Error";

							array_push($update_item_array['customlabel'], $costers);
				
							$costers = trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_QUANTITY)->item(0)->nodeValue) != "" ? trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_QUANTITY)->item(0)->nodeValue) : "0";

							array_push($update_item_array['quantity'], $costers);

							$costers = trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_TOTALQUANTITY)->item(0)->nodeValue) != "" ? trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_TOTALQUANTITY)->item(0)->nodeValue) : "0";

							array_push($update_item_array['quantitysoldandavailable'], $costers);



							$costers = trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_CURRENTPRICE)->item(0)->nodeValue) != "" ? trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_CURRENTPRICE)->item(0)->nodeValue) : "price sold - Error";

							array_push($update_item_array['sellprice'], $costers);	



							$costers = trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_STARTTIME)->item(0)->nodeValue) != "" ? trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_STARTTIME)->item(0)->nodeValue) : "0";


							array_push($update_item_array['starttime'], $costers);

						
									
							$costers = trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_ENDTIME)->item(0)->nodeValue) != "" ? trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_ENDTIME)->item(0)->nodeValue) : "";


							array_push($update_item_array['endtime'], $costers);

											
							$costers = trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_ITEMTITLE)->item(0)->nodeValue) != "" ? trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_ITEMTITLE)->item(0)->nodeValue) : "";


							array_push($update_item_array['itemtitle'], $costers);				

											
							$costers = trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_STOCKCNTRL)->item(0)->nodeValue) != "" ? trim($inditemshow->getElementsByTagName(DOM_ELEMENT_LISTINGS_STOCKCNTRL)->item(0)->nodeValue) : "FALSE";


							array_push($update_item_array['stockcntrl'], $costers);		

						}
						
						

					}



					
				}		


				//errors
				$error_messages = $item->getElementsByTagName(DOM_ELEMENT_ERRORS);

				foreach ($error_messages as $errormsg){
					$error = trim($errormsg->getElementsByTagName(DOM_ELEMENT_SHORT_ERROR_MSG)->item(0)->nodeValue) != "" ? trim($errormsg->getElementsByTagName(DOM_ELEMENT_SHORT_ERROR_MSG)->item(0)->nodeValue) : "No Error";
					array_push($update_item_array, $error);
				}

				
				
				

			}

			return $update_item_array;

		//DOM_ELEMENT_SHORT_ERROR_MSG
		}


			
	}



?>