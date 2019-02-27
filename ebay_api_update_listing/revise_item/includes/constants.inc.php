<?php


//INCLUDES
define('HTTP', 'http://');


define('SERVER_NAME', '127.0.0.1');
define('ROOT', SERVER_NAME . '/ebay_api/');

//filesystem
define('FILE_LISTINGS','../files/freelistingsupdate.csv');
define('FILE_LOGS','logs/logs.csv');
define('TEST_LOGS','logs/test_logs.csv');


define('NS','|');
define('TAB_DELIM',"	");
define('NEWLINE',"\n");

//Ebay specifics
define('AUSTRALIA_SITE_ID', '15');
define('AUSTRALIA_COUNTRY_CODE', 'AU');
define('AUSTRALIA_CURRENCY', 'AUD');

define('DURATION_THREE', 'Days_3');
define('DURATION_TEN', 'Days_10');
define('DURATION_GTC', 'GTC');

define('AU_STANDARD_DELIVERY', 'AU_RegularParcelWithTracking');


define('PAYPAL_EMAIL', 'payments@soldsmart.biz');

define('POSTCODE', '2164');

define('CONDITION', '1000');

define('DISPATCH_TIME_DAYS', '1');

//listing types
define('LISTING_TYPE_FIXED_PRICE', 'FixedPriceItem');
define('LISTING_TYPE_CHINESE', 'Chinese');



//Call Names
define('CALL_NAME_REVISEITEM', 'ReviseFixedPriceItem');
define('CALL_NAME_GET_EBAY_DETAILS', 'GeteBayDetails');


//Call returns
define('ACK_SUCCESS', 'Success');



//DOM ELEMENTS
define('DOM_ELEMENT_ACK', 'Ack');


define('DOM_ELEMENT_SHIPPING_SERVICE_DETAILS', 'ShippingServiceDetails');
define('DOM_ELEMENT_SHIPPING_SERVICE', 'ShippingService');


define('DOM_ELEMENT_ADD_ITEM_RESPONSE', 'ReviseFixedPriceItemResponse');
define('DOM_ELEMENT_ADD_ITEM_TIMESTAMP', 'Timestamp');


define('DOM_ELEMENT_ERRORS', 'Errors');
define('DOM_ELEMENT_SHORT_ERROR_MSG', 'ShortMessage');
define('DOM_ELEMENT_ITEM_ID', 'ItemID');

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

define('MACRO_TOPLINKER', '%%TopLinker%%');
define('MACRO_TOPIMAGE', '%%TopImage%%');








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