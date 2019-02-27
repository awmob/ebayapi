<?php


	Class addItem{


/*
//
listing duration Days_7

cat 2034

set ---- var ? : ---- for buy it now to appear or disappear 

Use CDATA for description with html

For the AddItem family of calls: Use calls like GetCategories to check if valid category before listing
*/

		//add <GalleryURL>![CDATA[".$gall_img_url."]]</GalleryURL> in live version
		public function add_new_auction($credentials, $sku, $title, $description, $catid, $start_price, $country_letter_code, $currency, $dispatch_time, $listing_duration, $paypal_email, $gall_img_url, $postcode, $returns_msg, $shipping_fee, $store_cat_id, $site, $ship_service, $condition, $quantity, $listing_type){

			$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
			<AddItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
			  <RequesterCredentials>
				<eBayAuthToken>" . $credentials . "</eBayAuthToken>
			  </RequesterCredentials>
			  <ErrorLanguage>en_US</ErrorLanguage>
			  <WarningLevel>High</WarningLevel>
			  <Item>
				<SKU>".$sku."</SKU>
				<Title>".$title."</Title>
				<Description>
				  <![CDATA[".$description."]]>
				</Description>
				<PrimaryCategory>
				  <CategoryID>".$catid."</CategoryID>
				</PrimaryCategory>
				<StartPrice>".$start_price."</StartPrice>
				<CategoryMappingAllowed>true</CategoryMappingAllowed>
				<Country>".$country_letter_code."</Country>
				<Currency>".$currency."</Currency>
				<DispatchTimeMax>".$dispatch_time."</DispatchTimeMax>
				<ListingDuration>".$listing_duration."</ListingDuration>
				<ListingType>".$listing_type."</ListingType>
				<PaymentMethods>PayPal</PaymentMethods>
				<PaymentMethods>MOCC</PaymentMethods>				
				<PaymentMethods>PersonalCheck</PaymentMethods>
				<PaymentMethods>MoneyXferAccepted</PaymentMethods>
				<PayPalEmailAddress>".$paypal_email."</PayPalEmailAddress>
				<PictureDetails>
				  <GalleryType>Gallery</GalleryType>
				  <PictureURL><![CDATA[".$gall_img_url."]]></PictureURL>
				</PictureDetails>
				<PostalCode>".$postcode."</PostalCode>
				<Quantity>1</Quantity>
				<ReturnPolicy>
				  <ReturnsAcceptedOption>ReturnsAccepted</ReturnsAcceptedOption>
				  <RefundOption>MoneyBack</RefundOption>
				  <ReturnsWithinOption>Days_7</ReturnsWithinOption>
				  <Description>".$returns_msg."</Description>
				  <ShippingCostPaidByOption>Buyer</ShippingCostPaidByOption>
				</ReturnPolicy>
				<ShippingDetails>
				  <ShippingType>Flat</ShippingType>
				  <ShippingServiceOptions>
					<ShippingServicePriority>1</ShippingServicePriority>
					<ShippingService>".$ship_service."</ShippingService>
					<ShippingServiceCost currency_id=\"".$currency."\">".$shipping_fee."</ShippingServiceCost>";
					
					//only show if more than one item sold
					$xml .= $quantity > 1 ? "<ShippingServiceAdditionalCost currencyID=\"".$currency."\">".$shipping_fee."</ShippingServiceAdditionalCost>" : ""; 

				  $xml.= "</ShippingServiceOptions>
				</ShippingDetails>
				<Site>".$site."</Site>
				<Storefront>
				  <StoreCategoryID>".$store_cat_id."</StoreCategoryID>
				</Storefront>
				<ConditionID>".$condition."</ConditionID>";
				//add quantity if greater than 1
				$xml .= $quantity > 1 ? "<Quantity>".$quantity."</Quantity>" : ""; 
				
			 $xml .= "</Item>
			</AddItemRequest>";

			return $xml;

		}



	}



/*

$xml_input = 
						"<?xml version=\"1.0\" encoding=\"utf-8\"?>
			<AddItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
			  <!-- Call-specific Input Fields -->
			  
			  <Item>
				
				<AutoPay>false</AutoPay>


				<BuyerRequirementDetails>

				  <MaximumBuyerPolicyViolations>
					<Count> int </Count>
					<Period> PeriodCodeType </Period>
				  </MaximumBuyerPolicyViolations>
				 
				  <MaximumItemRequirements>
					<MaximumItemCount> int </MaximumItemCount>
					<MinimumFeedbackScore> int </MinimumFeedbackScore>
				  </MaximumItemRequirements>

				  <MaximumUnpaidItemStrikesInfo>
					<Count> int </Count>
					<Period> PeriodCodeType </Period>
				  </MaximumUnpaidItemStrikesInfo>

				  
				  <ShipToRegistrationCountry> boolean </ShipToRegistrationCountry>
	
				</BuyerRequirementDetails>



				<BuyItNowPrice currencyID=\"CurrencyCodeType\"> AmountType (double) </BuyItNowPrice>



				<CategoryMappingAllowed> boolean </CategoryMappingAllowed>

				<ConditionDescription> string </ConditionDescription>

				<ConditionID> int </ConditionID>

				<Country> CountryCodeType </Country>


				<Currency> CurrencyCodeType </Currency>

				<Description> string </Description>



				<DispatchTimeMax> int </DispatchTimeMax>

				<GiftIcon>0</GiftIcon>
				
			

				<ListingDuration> token </ListingDuration>

	
				<ListingType> ListingTypeCodeType </ListingType>

				<Location> string </Location>



				
				<PaymentMethods> BuyerPaymentMethodCodeType </PaymentMethods>
				<!-- ... more PaymentMethods values allowed here ... -->
				<PayPalEmailAddress> string </PayPalEmailAddress>

				<PictureDetails> PictureDetailsType
				  <ExternalPictureURL> anyURI </ExternalPictureURL>
				  <GalleryDuration> token </GalleryDuration>
				  <GalleryType> GalleryTypeCodeType </GalleryType>
				  <GalleryURL> anyURI </GalleryURL>
				  <PhotoDisplay> PhotoDisplayCodeType </PhotoDisplay>
				  <PictureURL> anyURI </PictureURL>
				  <!-- ... more PictureURL values allowed here ... -->
				</PictureDetails>

				<PostalCode> string </PostalCode>

				<PrimaryCategory> CategoryType
				  <CategoryID> string </CategoryID>
				</PrimaryCategory>


				
				<Quantity> int </Quantity>



				<ReturnPolicy> ReturnPolicyType
				  <Description> string </Description>		
				  <RefundOption> token </RefundOption>
				  <ReturnsAcceptedOption> token </ReturnsAcceptedOption>
				  <ReturnsWithinOption> token </ReturnsWithinOption>
				  <ShippingCostPaidByOption> token </ShippingCostPaidByOption>
				 
				</ReturnPolicy>


				<ScheduleTime> dateTime </ScheduleTime>
		

				<SellerProfiles> SellerProfilesType
				  <SellerPaymentProfile> SellerPaymentProfileType
					<PaymentProfileID> long </PaymentProfileID>
					<PaymentProfileName> string </PaymentProfileName>
				  </SellerPaymentProfile>
				  <SellerReturnProfile> SellerReturnProfileType
					<ReturnProfileID> long </ReturnProfileID>
					<ReturnProfileName> string </ReturnProfileName>
				  </SellerReturnProfile>
				  <SellerShippingProfile> SellerShippingProfileType
					<ShippingProfileID> long </ShippingProfileID>
					<ShippingProfileName> string </ShippingProfileName>
				  </SellerShippingProfile>
				</SellerProfiles>


				<ShippingDetails> ShippingDetailsType
				  <CalculatedShippingRate> CalculatedShippingRateType
					
					<MeasurementUnit> MeasurementSystemCodeType </MeasurementUnit>
					<OriginatingPostalCode> string </OriginatingPostalCode>
					<PackageDepth unit=\"token\" measurementSystem=\"MeasurementSystemCodeType\"> MeasureType (decimal) </PackageDepth>
					<PackageLength unit=\"token\" measurementSystem=\"MeasurementSystemCodeType\"> MeasureType (decimal) </PackageLength>
					<PackageWidth unit=\"token\" measurementSystem=\"MeasurementSystemCodeType\"> MeasureType (decimal) </PackageWidth>
					<PackagingHandlingCosts currencyID=\"CurrencyCodeType\"> AmountType (double) </PackagingHandlingCosts>
					<ShippingIrregular> boolean </ShippingIrregular>
					<ShippingPackage> ShippingPackageCodeType </ShippingPackage>
					<WeightMajor unit=\"token\" measurementSystem=\"MeasurementSystemCodeType\"> MeasureType (decimal) </WeightMajor>
					<WeightMinor unit=\"token\" measurementSystem=\"MeasurementSystemCodeType\"> MeasureType (decimal) </WeightMinor>
				  </CalculatedShippingRate>
				  <CODCost currencyID=\"CurrencyCodeType\"> AmountType (double) </CODCost>
				  <ExcludeShipToLocation> string </ExcludeShipToLocation>
				  <!-- ... more ExcludeShipToLocation values allowed here ... -->
				  <GlobalShipping> boolean </GlobalShipping>
				  <InsuranceDetails> InsuranceDetailsType
					<InsuranceFee currencyID=\"CurrencyCodeType\"> AmountType (double) </InsuranceFee>
					<InsuranceOption> InsuranceOptionCodeType </InsuranceOption>
				  </InsuranceDetails>
				  <InsuranceFee currencyID=\"CurrencyCodeType\"> AmountType (double) </InsuranceFee>
				  <InsuranceOption> InsuranceOptionCodeType </InsuranceOption>
				  <InternationalInsuranceDetails> InsuranceDetailsType
					<InsuranceFee currencyID=\"CurrencyCodeType\"> AmountType (double) </InsuranceFee>
					<InsuranceOption> InsuranceOptionCodeType </InsuranceOption>
				  </InternationalInsuranceDetails>
				  <InternationalPromotionalShippingDiscount> boolean </InternationalPromotionalShippingDiscount>
				  <InternationalShippingDiscountProfileID> string </InternationalShippingDiscountProfileID>
				  <InternationalShippingServiceOption> InternationalShippingServiceOptionsType
					<ShippingService> token </ShippingService>
					<ShippingServiceAdditionalCost currencyID=\"CurrencyCodeType\"> AmountType (double) </ShippingServiceAdditionalCost>
					<ShippingServiceCost currencyID=\"CurrencyCodeType\"> AmountType (double) </ShippingServiceCost>
					<ShippingServicePriority> int </ShippingServicePriority>
					<ShipToLocation> string </ShipToLocation>
					<!-- ... more ShipToLocation values allowed here ... -->
				  </InternationalShippingServiceOption>
				  <!-- ... more InternationalShippingServiceOption nodes allowed here ... -->
				  <PaymentInstructions> string </PaymentInstructions>
				  <PromotionalShippingDiscount> boolean </PromotionalShippingDiscount>
				  <RateTableDetails> RateTableDetailsType
					<DomesticRateTable> string </DomesticRateTable>
					<InternationalRateTable> string </InternationalRateTable>
				  </RateTableDetails>
				  <SalesTax> SalesTaxType
					<SalesTaxPercent> float </SalesTaxPercent>
					<SalesTaxState> string </SalesTaxState>
					<ShippingIncludedInTax> boolean </ShippingIncludedInTax>
				  </SalesTax>
				  <ShippingDiscountProfileID> string </ShippingDiscountProfileID>
				  <ShippingServiceOptions> ShippingServiceOptionsType
					<FreeShipping> boolean </FreeShipping>
					<ShippingService> token </ShippingService>
					<ShippingServiceAdditionalCost currencyID=\"CurrencyCodeType\"> AmountType (double) </ShippingServiceAdditionalCost>
					<ShippingServiceCost currencyID=\"CurrencyCodeType\"> AmountType (double) </ShippingServiceCost>
					<ShippingServicePriority> int </ShippingServicePriority>
					<ShippingSurcharge currencyID=\"CurrencyCodeType\"> AmountType (double) </ShippingSurcharge>
				  </ShippingServiceOptions>
				  <!-- ... more ShippingServiceOptions nodes allowed here ... -->
				  <ShippingType> ShippingTypeCodeType </ShippingType>
				</ShippingDetails>
				<ShippingPackageDetails> ShipPackageDetailsType
				  <MeasurementUnit> MeasurementSystemCodeType </MeasurementUnit>
				  <PackageDepth unit=\"token\" measurementSystem=\"MeasurementSystemCodeType\"> MeasureType (decimal) </PackageDepth>
				  <PackageLength unit=\"token\" measurementSystem=\"MeasurementSystemCodeType\"> MeasureType (decimal) </PackageLength>
				  <PackageWidth unit=\"token\" measurementSystem=\"MeasurementSystemCodeType\"> MeasureType (decimal) </PackageWidth>
				  <ShippingIrregular> boolean </ShippingIrregular>
				  <ShippingPackage> ShippingPackageCodeType </ShippingPackage>
				  <WeightMajor unit=\"token\" measurementSystem=\"MeasurementSystemCodeType\"> MeasureType (decimal) </WeightMajor>
				  <WeightMinor unit=\"token\" measurementSystem=\"MeasurementSystemCodeType\"> MeasureType (decimal) </WeightMinor>
				</ShippingPackageDetails>
				<ShippingTermsInDescription> boolean </ShippingTermsInDescription>
				<ShipToLocations> string </ShipToLocations>
				<!-- ... more ShipToLocations values allowed here ... -->
				<Site> SiteCodeType </Site>
				<SKU> SKUType (string) </SKU>
				<SkypeContactOption> SkypeContactOptionCodeType </SkypeContactOption>
				<!-- ... more SkypeContactOption values allowed here ... -->
				<SkypeEnabled> boolean </SkypeEnabled>
				<SkypeID> string </SkypeID>
				<StartPrice currencyID=\"CurrencyCodeType\"> AmountType (double) </StartPrice>
				<Storefront> StorefrontType
				  <StoreCategory2ID> long </StoreCategory2ID>
				  <StoreCategoryID> long </StoreCategoryID>
				</Storefront>
				<SubTitle> string </SubTitle>
				<TaxCategory> string </TaxCategory>
				<ThirdPartyCheckout> boolean </ThirdPartyCheckout>
				<ThirdPartyCheckoutIntegration> boolean </ThirdPartyCheckoutIntegration>
				<Title> string </Title>
				<UseRecommendedProduct> boolean </UseRecommendedProduct>
				<UseTaxTable> boolean </UseTaxTable>
				<UUID> UUIDType (string) </UUID>
				<VATDetails> VATDetailsType
				  <BusinessSeller> boolean </BusinessSeller>
				  <RestrictedToBusiness> boolean </RestrictedToBusiness>
				  <VATPercent> float </VATPercent>
				</VATDetails>
				<VIN> string </VIN>
				<VRM> string </VRM>
			  </Item>
			  <!-- Standard Input Fields -->
			  <ErrorHandling> ErrorHandlingCodeType </ErrorHandling>
			  <ErrorLanguage> string </ErrorLanguage>
			  <MessageID> string </MessageID>
			  <Version> string </Version>
			  <WarningLevel> WarningLevelCodeType </WarningLevel>
			</AddItemRequest>";

			*/


?>