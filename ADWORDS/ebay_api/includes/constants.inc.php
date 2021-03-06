<?php





//filesystem
define('FILE_LISTINGS','files/items_to_update.csv');
define('FILE_REVISE_TITLE','files/reviseitemtitle.csv');
define('FILE_OS_CONTROL','files/outofstockcontrol.csv');
define('FILE_ENDITEM','files/enditem.csv');
define('FILE_GETSHIPCOSTS','files/shipcostitemnums.csv');
define('FILE_CATS','files/cats_to_update.csv');
define('FILE_PROMOS','files/promos_to_update.csv');
define('DELETE_FILE_PROMOS','files/promos_to_delete.csv');
define('UPDATE_DISPATCH_TIMER','files/update_time.csv');


define('FILE_LOGS','logs/logs.csv');
define('TEST_LOGS','logs/test_logs.csv');


define('NS','|');
define('TAB_DELIM',"	");
define('STRING_DELIM',"##");

define('NEWLINE',"\n");
define('NEWLINEMAIN',"\r\n");

//Ebay specifics
define('AUSTRALIA_SITE_ID', '15');
define('AUSTRALIA_COUNTRY_CODE', 'AU');
define('AUSTRALIA_CURRENCY', 'AUD');

define('DURATION_THREE', 'Days_3');
define('DURATION_TEN', 'Days_10');
define('DURATION_GTC', 'GTC');

define('AU_STANDARD_DELIVERY', 'AU_StandardDelivery');


define('PAYPAL_EMAIL', 'payments@soldsmart.biz');

define('POSTCODE', '2164');

define('CONDITION', '1000');

define('DISPATCH_TIME_DAYS', '1');

//listing types
define('LISTING_TYPE_FIXED_PRICE', 'FixedPriceItem');
define('LISTING_TYPE_CHINESE', 'Chinese');



//Call Names
define('CALL_NAME_ADDITEM', 'AddItem');
define('CALL_NAME_GET_EBAY_DETAILS', 'GeteBayDetails');
define('CALL_NAME_UPDATEITEM', 'ReviseInventoryStatus');
define('CALL_NAME_REVISEITEM', 'ReviseFixedPriceItem');
define('CALL_NAME_ADDPROMO', 'SetPromotionalSaleListings');
define('CALL_NAME_ENDITEM', 'EndItem');
define('CALL_GETSHIPCOSTS', 'GetItem');
define('CALL_GETMYEBAYSELLING', 'GetMyeBaySelling');

define('GETMYEBAYSELLING_ENTRIES_PER_PAGE', '200');

//Call returns
define('ACK_SUCCESS', 'Success');



//DOM ELEMENTS
define('DOM_ELEMENT_ACK', 'Ack');


define('DOM_ELEMENT_SHIPPING_SERVICE_DETAILS', 'ShippingServiceDetails');
define('DOM_ELEMENT_SHIPPING_SERVICE', 'ShippingService');


define('DOM_ELEMENT_ADD_ITEM_RESPONSE', 'AddItemResponse');
define('DOM_ELEMENT_ADD_ITEM_TIMESTAMP', 'Timestamp');

define('DOM_ELEMENT_REVISE_INV_RESPONSE', 'ReviseInventoryStatusResponse');
define('DOM_ELEMENT_REVISE_ITEM_RESPONSE', 'ReviseFixedPriceItemResponse');
define('DOM_ELEMENT_ADD_PROMO_RESPONSE', 'SetPromotionalSaleListingsResponse');
define('DOM_ELEMENT_END_ITEM_RESPONSE', 'EndItemResponse');
define('DOM_ELEMENT_SHIPCOST_RESPONSE', 'GetItemResponse');
define('DOM_ELEMENT_LISTINGSSHOW_RESPONSE', 'GetMyeBaySellingResponse');


define('DOM_ELEMENT_ERRORS', 'Errors');
define('DOM_ELEMENT_SHORT_ERROR_MSG', 'LongMessage');
define('DOM_ELEMENT_ITEM_ID', 'ItemID');

define('DOM_ELEMENT_SHIP_DETAILS', 'ShippingDetails');
define('DOM_ELEMENT_SHIP_SERVICE_OPTIONS', 'ShippingServiceOptions');
define('DOM_ELEMENT_SHIP_SERVICE_CST', 'ShippingServiceCost');

define('DOM_ELEMENT_LISTINGS_ITEMID', 'ItemID');
define('DOM_ELEMENT_LISTINGS_ACTIVELIST', 'ActiveList');
define('DOM_ELEMENT_LISTINGS_ITEMARRAY', 'ItemArray');
define('DOM_ELEMENT_LISTINGS_ITEMSS', 'Item');
define('DOM_ELEMENT_LISTINGS_ITEM_SELLSTATUS', 'SellingStatus');

define('DOM_ELEMENT_LISTINGS_SKU', 'SKU');
define('DOM_ELEMENT_LISTINGS_QUANTITY', 'QuantityAvailable');
define('DOM_ELEMENT_LISTINGS_TOTALQUANTITY', 'Quantity');

define('DOM_ELEMENT_LISTINGS_CURRENTPRICE', 'CurrentPrice');

define('DOM_ELEMENT_LISTINGS_LISTINGTYPE', 'ListingType');
define('DOM_ELEMENT_LISTINGS_LISTING_DETAILS', 'ListingDetails');
define('DOM_ELEMENT_LISTINGS_STARTTIME', 'StartTime');
define('DOM_ELEMENT_LISTINGS_ENDTIME', 'ListingDuration');
define('DOM_ELEMENT_LISTINGS_ITEMTITLE', 'Title');
define('DOM_ELEMENT_LISTINGS_STOCKCNTRL', 'OutOfStockControl');

							//Variation DOM Elements
define('DOM_ELEMENT_LISTINGS_VARIATIONS', 'Variations');
define('DOM_ELEMENT_LISTINGS_VARIATION', 'Variation');
define('DOM_ELEMENT_LISTINGS_VARIATION_TITLE', 'VariationTitle');
define('DOM_ELEMENT_LISTINGS_VARIATION_SKU', 'SKU');
define('DOM_ELEMENT_LISTINGS_VARIATION_NAME', 'Name');
define('DOM_ELEMENT_LISTINGS_VARIATION_VALUE', 'Value');
define('DOM_ELEMENT_LISTINGS_VARIATION_STARTPRICE', 'StartPrice');
define('DOM_ELEMENT_LISTINGS_VARIATION_QUANTITY', 'Quantity');

define('DOM_ELEMENT_LISTINGS_VARIATION_SELLINGSTATUS', 'SellingStatus');
define('DOM_ELEMENT_LISTINGS_VARIATION_QUANTITYSOLD', 'QuantitySold');

///////////////////////////////////////////////////////////////////////////////////////////////////



//messages
define('RETURNS_MSG', 'If you have any issue with the item or if something goes wrong please contact us through eBay Messaging or email to support@soldsmart.biz before leaving feedback. Our dedicated customer support team will provide all necessary assistance to resolve the issue to your satisfaction. Returm shipping will be paid by us only when the item is dead on arrival or a wrong item has been sent. Thank you for your cooperation.');




//MACROS
define('MACRO_ITEM_TITLE', '%%ItemTitle%%');
define('MACRO_IMAGE_MAIN', '%%Image1%%');
define('MACRO_IMAGE_B', '%%Image2%%');
define('MACRO_IMAGE_C', '%%Image3%%');
define('MACRO_IMAGE_D', '%%Image4%%');
define('MACRO_IMAGE_E', '%%Image5%%');
define('MACRO_IMAGE_F', '%%Image6%%');
define('MACRO_ITEM_DESCRIPTION', '%%ItemDescription%%');
define('MACRO_INVENTORY_NUMBER', '%%InventoryNumber%%');
define('MACRO_SHIPPING_FEE', '%%ShippingFee%%');










//Full Call Reference
//http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/

//Calls
/*

AddFixedPriceItem


AddItem
---------------------------------------------------------------------------------------------------------------
Do not test item insertions with AddItem. Instead, use VerifyAddItem to test an item's definition before using making it live with AddItem. Also of note, testing with VerifyAddItem can reduce the number of item listing errors your application needs to handle. Do not, however, use VerifyAddItem if you are adding items in bulk.

A suspected error condition can occur when a user submits an AddItem request, but they do not receive a response. In this case, the user does not know whether or not the listing was successfully submitted. To prepare for this condition, submit the AddItem request with a UUID.
---------------------------------------------------------------------------------------------------------------

ItemType
---------------------------------------------------------------------------------------------------------------
http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/ItemType.html
---------------------------------------------------------------------------------------------------------------

GetCategories
GetItem



*/

?>