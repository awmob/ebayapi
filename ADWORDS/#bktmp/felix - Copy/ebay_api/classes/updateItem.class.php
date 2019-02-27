<?php


	Class updateItem{

		public static $live_item_number = "test";
		public static $curpage = 1;
		public static $numlistings = 0;
/*
//



<ReviseInventoryStatusRequest xmlns="urn:ebay:apis:eBLBaseComponents">
<RequesterCredentials>
<eBayAuthToken>" . $credentials . "</eBayAuthToken>
</RequesterCredentials>
  <InventoryStatus> InventoryStatusType
    <ItemID> ItemIDType (string) </ItemID>
    <Quantity> int </Quantity>
    <SKU> SKUType (string) </SKU>
    <StartPrice> AmountType (double) </StartPrice>
  </InventoryStatus>
  <!-- ... more InventoryStatus nodes allowed here ... -->
  <!-- Standard Input Fields -->
  <ErrorLanguage> string </ErrorLanguage>
  <MessageID> string </MessageID>
  <Version> string </Version>
  <WarningLevel> WarningLevelCodeType </WarningLevel>
</ReviseInventoryStatusRequest>

*/

		public function modifydate($date){
			//2013-08-22T13:59:51.000Z
			$pattern = "#T.+#";
			$short_date = preg_replace($pattern, "", $date);

			//add 10 hours to cater to time differential
			$tempdate = strtotime($short_date) + TEN_HRS_SECS;


			$endten = $tempdate + DAYS_TEN_SECS;
			
			$short_date = date("d-M-y",$tempdate);
			$end_date = date("d-M-y",$endten);

			$daters = array();

			$daters['start'] = $short_date;
			$daters['end'] = $end_date;

			return $daters;
		}



		public function modifydateflexi($date, $length){
			//2013-08-22T13:59:51.000Z
			//$pattern = "#T.+#";
			//$pattern = "#T.+#";
			//$short_date = preg_replace($pattern, "", $date);
			$short_date = str_replace(".000Z","",$date);

//2014-04-02T00:34:44 
			//add 10 hours to cater to time differential
			$tempdate = strtotime($short_date) + TEN_HRS_SECS;
			
			$endten = $tempdate + $length;
			
			
			$short_date = date("d-M-y",$tempdate);
			$end_date = date("d-M-y",$endten);

			$daters = array();

			$daters['start'] = $short_date;
			$daters['end'] = $end_date;

			return $daters;
		}




		//add <GalleryURL>![CDATA[".$gall_img_url."]]</GalleryURL> in live version
		public function update_price_and_stock($credentials, $itemid, $stock, $price){

			if(trim($stock=="")){
				$stock_bool = false;
			}
			else{
				$stock_bool = true;
			}

			if(trim($price=="")){
				$price_bool = false;
			}
			else{
				$price_bool = true;
			}

			if ($price_bool == false && $stock_bool == false){
				$process = false;
			}
			else{
				$process = true;
			}

			if ($process){

				if ($price_bool){
					$price_show = "<StartPrice>".$price."</StartPrice>";
				}
				else{
					$price_show = "";
				}

				if ($stock_bool){
					$stock_show = "<Quantity>".$stock."</Quantity>";
				}
				else{
					$stock_show = "";
				}

			


				$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
						<ReviseInventoryStatusRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
						<RequesterCredentials>
						<eBayAuthToken>" . $credentials . "</eBayAuthToken>
						</RequesterCredentials>


						  <InventoryStatus>
							<ItemID>".$itemid."</ItemID>".$stock_show.$price_show."
						  </InventoryStatus>";

				 $xml .="<ErrorLanguage>en_AU</ErrorLanguage>
						</ReviseInventoryStatusRequest>";
			}
			else{
				$xml = false;
			}

			return $xml;

		}




	public function revise_title($credentials, $itemid, $title){
		$title = trim($title);
		$itemid = trim($itemid);
	
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<ReviseFixedPriceItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
				<RequesterCredentials>
				<eBayAuthToken>" . $credentials . "</eBayAuthToken>
				</RequesterCredentials>


				  <Item>
					<ItemID>".$itemid."</ItemID>
					<Title>".$title."</Title>
				  </Item>";

		 $xml .="<ErrorLanguage>en_AU</ErrorLanguage>
				</ReviseFixedPriceItemRequest>";
	

		return $xml;

	}

	public function revise_cats($credentials, $itemid, $cata, $catb){

		if (trim($catb) != ""){
			$catbshow = "
					<SecondaryCategory>
					  <CategoryID>".trim($catb)."</CategoryID>
					</SecondaryCategory>
			";
		}
		else{
			$catbshow = "";
		}

		$catshowa = "
				<PrimaryCategory>
					<CategoryID>".trim($cata)."</CategoryID>
				</PrimaryCategory>	
		";

		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<ReviseFixedPriceItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
				<RequesterCredentials>
				<eBayAuthToken>" . $credentials . "</eBayAuthToken>
				</RequesterCredentials>


				  <Item>
					<ItemID>".$itemid."</ItemID>
					

					".$catshowa.$catbshow."
				  </Item>";

		 $xml .="<ErrorLanguage>en_AU</ErrorLanguage>
				</ReviseFixedPriceItemRequest>";
	

		return $xml;
	}

	/*
 <PrimaryCategory> CategoryType
      <CategoryID> string </CategoryID>
    </PrimaryCategory>
	<SecondaryCategory> CategoryType
      <CategoryID> string </CategoryID>
    </SecondaryCategory>

	*/



	public function revise_stock_control($credentials, $itemid){
	
		$itemid = trim($itemid);
	
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<ReviseFixedPriceItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
				<RequesterCredentials>
				<eBayAuthToken>" . $credentials . "</eBayAuthToken>
				</RequesterCredentials>


				  <Item>
					<ItemID>".$itemid."</ItemID>
					<OutOfStockControl>true</OutOfStockControl>
				  </Item>";

		 $xml .="<ErrorLanguage>en_AU</ErrorLanguage>
				</ReviseFixedPriceItemRequest>";
	

		return $xml;

	}



	public function end_item($credentials, $itemid){
		$itemid = trim($itemid);
	
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<EndItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
				<RequesterCredentials>
				<eBayAuthToken>" . $credentials . "</eBayAuthToken>
				</RequesterCredentials>

					<ItemID>".$itemid."</ItemID>
					<EndingReason>NotAvailable</EndingReason>";

		 $xml .="<ErrorLanguage>en_AU</ErrorLanguage>
				</EndItemRequest>";
	

		return $xml;

	}


	public function get_ship_costs($credentials, $itemid){
		$itemid = trim($itemid);
	
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<GetItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
				<RequesterCredentials>
				<eBayAuthToken>" . $credentials . "</eBayAuthToken>
				</RequesterCredentials>

					<ItemID>".$itemid."</ItemID>";

		 $xml .="<ErrorLanguage>en_AU</ErrorLanguage>
				</GetItemRequest>";
	

		return $xml;

	}


	public function set_markdown($credentials, $itemid, $promo_id){
		$itemid = trim($itemid);
		$promo_id = trim($promo_id);

  

		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<SetPromotionalSaleListingsRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
				<RequesterCredentials>
				<eBayAuthToken>" . $credentials . "</eBayAuthToken>
				</RequesterCredentials>

				<Action>Add</Action>
				  <PromotionalSaleID>".$promo_id."</PromotionalSaleID>
				  <PromotionalSaleItemIDArray>
					<ItemID>".$itemid."</ItemID>
				  </PromotionalSaleItemIDArray>";

		 $xml .="<ErrorLanguage>en_AU</ErrorLanguage>
				</SetPromotionalSaleListingsRequest>";
	

		return $xml;
	}







	public function del_from_markdown($credentials, $itemid, $promo_id){
		$itemid = trim($itemid);
		$promo_id = trim($promo_id);

  

		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<SetPromotionalSaleListingsRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
				<RequesterCredentials>
				<eBayAuthToken>" . $credentials . "</eBayAuthToken>
				</RequesterCredentials>

				<Action>Delete</Action>
				  <PromotionalSaleID>".$promo_id."</PromotionalSaleID>
				  <PromotionalSaleItemIDArray>
					<ItemID>".$itemid."</ItemID>
				  </PromotionalSaleItemIDArray>";

		 $xml .="<ErrorLanguage>en_AU</ErrorLanguage>
				</SetPromotionalSaleListingsRequest>";
	

		return $xml;
	}







	public function revise_dispatch_time($credentials, $itemid, $time){

		

		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<ReviseFixedPriceItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
				<RequesterCredentials>
				<eBayAuthToken>" . $credentials . "</eBayAuthToken>
				</RequesterCredentials>


				  <Item>
					<ItemID>".$itemid."</ItemID>
					<DispatchTimeMax>".$time."</DispatchTimeMax>
				  </Item>";

		 $xml .="<ErrorLanguage>en_AU</ErrorLanguage>
				</ReviseFixedPriceItemRequest>";
	

		return $xml;
	}




	public function getactivelistings($credentials, $page){
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<GetMyeBaySellingRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
				<RequesterCredentials>
				<eBayAuthToken>" . $credentials . "</eBayAuthToken>
				</RequesterCredentials>


				<ActiveList>
					
					<Include>true</Include>

					<Pagination>

						<EntriesPerPage>".GETMYEBAYSELLING_ENTRIES_PER_PAGE."</EntriesPerPage>
						<PageNumber>".$page."</PageNumber>

					</Pagination>

				</ActiveList>




				<ErrorLanguage>en_AU</ErrorLanguage>
				</GetMyeBaySellingRequest>";
	

		return $xml;

	}





	}




?>