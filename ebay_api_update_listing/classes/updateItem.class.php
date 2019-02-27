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


			$tempdate = strtotime($short_date);
			$endten = $tempdate + 864000;
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


	//add <GalleryURL>![CDATA[".$gall_img_url."]]</GalleryURL> in live version
		public function update_price_and_stocksku($credentials, $itemid, $stock, $price, $sku){

			if(trim($sku=="")){
				$sku_bool = false;
			}
			else{
				$sku_bool = true;
			}


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

			if ($sku_bool == false){
				$process = false;
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

				$skushow = "<SKU>".trim($sku)."</SKU>";

			


				$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
						<ReviseInventoryStatusRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
						<RequesterCredentials>
						<eBayAuthToken>" . $credentials . "</eBayAuthToken>
						</RequesterCredentials>


						  <InventoryStatus>
							<ItemID>".$itemid."</ItemID>".$stock_show.$skushow.$price_show."
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



	public function revise_return($credentials, $itemid){
		//ReturnsWithinOption
		$itemid = trim($itemid);
	
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<ReviseItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
				<RequesterCredentials>
				<eBayAuthToken>" . $credentials . "</eBayAuthToken>
				</RequesterCredentials>


				  <Item>
					<ItemID>".$itemid."</ItemID>

					<ReturnPolicy>
						<ReturnsWithinOption>Days_30</ReturnsWithinOption>
						<ReturnsAcceptedOption>ReturnsAccepted</ReturnsAcceptedOption>
					</ReturnPolicy>
				  </Item>";

		 $xml .="<ErrorLanguage>en_AU</ErrorLanguage>
				</ReviseItemRequest>";
	

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





		public function mark_shipped($credentials, $itemid, $username, $multiorder, $transid){
			$itemid = trim($itemid);
			$transid = trim($transid);
			$username = trim($username);

			$orderlineitemid = $itemid ."-".$transid;

		
			$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
					<CompleteSaleRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
					<RequesterCredentials>
					<eBayAuthToken>" . $credentials . "</eBayAuthToken>
					</RequesterCredentials>

					<WarningLevel>High</WarningLevel>
							<FeedbackInfo>
						<CommentText>Thanks for ordering engraved products from KokoPetArt!</CommentText>
							<CommentType>Positive</CommentType>
							<TargetUser>".$username."</TargetUser>
						</FeedbackInfo>";

			$xml .=	"<ItemID>".$itemid."</ItemID>";

			if ($multiorder){
				$multiorder = trim($multiorder);
				$xml .=	"<OrderID>".$multiorder."</OrderID>";   //only inlude if actual order
			}

			$xml .=	"<OrderLineItemID>".$orderlineitemid."</OrderLineItemID>";  //only include if not order
			$xml .= "<TransactionID>".$transid."</TransactionID>";


			$xml .= "<Shipped>true</Shipped>";

			$xml .="<ErrorLanguage>en_AU</ErrorLanguage>
					</CompleteSaleRequest>";
		

			return $xml;

		}





		public function sendshippedmsg($credentials, $itemid, $username, $message){
			$itemid = trim($itemid);
			$username = trim($username);

			

		
			$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
					<AddMemberMessageAAQToPartnerRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
					<RequesterCredentials>
					<eBayAuthToken>" . $credentials . "</eBayAuthToken>
					</RequesterCredentials>

					<WarningLevel>High</WarningLevel>";
							

			$xml .=	"<ItemID>".$itemid."</ItemID>";

			

			 $xml .=	"<MemberMessage>
				<Subject>Your Order Has Been Posted</Subject>
				<Body>".$message."</Body>
				<QuestionType>Shipping</QuestionType>
				<RecipientID>".$username."</RecipientID>
			  </MemberMessage>";
			

			$xml .="<ErrorLanguage>en_AU</ErrorLanguage>
					</AddMemberMessageAAQToPartnerRequest>";
		

			return $xml;

		}




	public function getitemtrans($credentials, $transactionid,$itemid){
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<GetItemTransactionsRequest  xmlns=\"urn:ebay:apis:eBLBaseComponents\">
					<RequesterCredentials>
					<eBayAuthToken>" . $credentials . "</eBayAuthToken>
					</RequesterCredentials>

					
					  

							<ItemID>".$itemid."</ItemID>
							<TransactionID>".$transactionid."</TransactionID>
							
					


					<ErrorLanguage>en_AU</ErrorLanguage>
				</GetItemTransactionsRequest>";
	


		return $xml;


	}


	public function setnote($credentials, $transactionid,$itemid,$note){
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<SetUserNotesRequest   xmlns=\"urn:ebay:apis:eBLBaseComponents\">
					<RequesterCredentials>
					<eBayAuthToken>" . $credentials . "</eBayAuthToken>
					</RequesterCredentials>

					
					  
							<Action>AddOrUpdate</Action>
							<ItemID>".$itemid."</ItemID>
							<TransactionID>".$transactionid."</TransactionID>
							<NoteText> ".$note." </NoteText>
					


					<ErrorLanguage>en_AU</ErrorLanguage>
				</SetUserNotesRequest>";
	


		return $xml;


	}





	}




?>