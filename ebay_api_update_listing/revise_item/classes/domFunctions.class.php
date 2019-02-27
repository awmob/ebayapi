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
		public function get_item_return_details($dom, $sku, $type){	
			//push each entry into new array
			$add_item_array = array();

			$add_item_response = $dom->getElementsByTagName(DOM_ELEMENT_ADD_ITEM_RESPONSE);

			foreach ($add_item_response as $item){
				//ad sku to first entry of array
				array_push($add_item_array, $sku);
				
				//add auction type
				array_push($add_item_array, $type);
				
				//enter item id into second entry - only if exists, if not then push false
				if (isset($item->getElementsByTagName(DOM_ELEMENT_ITEM_ID)->item(0)->nodeValue)){
					$itemnum = trim($item->getElementsByTagName(DOM_ELEMENT_ITEM_ID)->item(0)->nodeValue);
				}
				else{
					$itemnum = "NOT LISTED";
				}
				array_push($add_item_array, $itemnum);

				//get the time of listing
				$timestamp = trim($item->getElementsByTagName(DOM_ELEMENT_ADD_ITEM_TIMESTAMP)->item(0)->nodeValue) != "" ? trim($item->getElementsByTagName(DOM_ELEMENT_ADD_ITEM_TIMESTAMP)->item(0)->nodeValue) : "No Timestamp";
				array_push($add_item_array, $timestamp);


				//errors
				$error_messages = $item->getElementsByTagName(DOM_ELEMENT_ERRORS);

				foreach ($error_messages as $errormsg){
					$error = trim($errormsg->getElementsByTagName(DOM_ELEMENT_SHORT_ERROR_MSG)->item(0)->nodeValue) != "" ? trim($errormsg->getElementsByTagName(DOM_ELEMENT_SHORT_ERROR_MSG)->item(0)->nodeValue) : "No Error";
					array_push($add_item_array, $error);
				}
				
				

			}

			return $add_item_array;
			
			


			//DOM_ELEMENT_SHORT_ERROR_MSG
		}

	}



?>