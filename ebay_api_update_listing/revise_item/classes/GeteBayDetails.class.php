<?php


	Class GeteBayDetails{


		
		public function shipping_service_details($token){
			$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?> 
			<GeteBayDetailsRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\"> 
			  <RequesterCredentials> 
				<eBayAuthToken>".$token."</eBayAuthToken> 
			  </RequesterCredentials> 
			  <DetailName>ShippingServiceDetails</DetailName> 
			</GeteBayDetailsRequest>";

			return $xml;

		}



	}



?>