<?php




	$feed_reader_config['line_delimiter'][0] = "\r\n"; //you may change this. Add new line delimiters to end of array as required
	$feed_reader_config['line_delimiter'][1] = "\n"; //you may change this. Add new line delimiters to end of array as required

	$feed_reader_config['element_delimiter'][0] = "	"; //TAB. you may change this. Add new element delimiters to end of array as required
	$feed_reader_config['element_delimiter'][1] = "|"; //you may change this. Add new element delimiters to end of array as required	
	$feed_reader_config['element_delimiter'][2] = ","; //you may change this. Add new element delimiters to end of array as required


	$feed_reader_config_error_messages['one_line'] = "Your feed must contain more than 1 line.";
	$feed_reader_config_error_messages['error_line_prefix'] = "Error: Line ";
	$feed_reader_config_error_messages['wrong_num_not_added_columns'] = " incorrect number of columns. Line not added.<br>";
	$feed_reader_config_error_messages['wrong_num_not_uploaded_columns'] = " incorrect number of columns. Feed upload cancelled.<br>";

	//success
	$feed_reader_config_error_messages['right_number_of_lines'] = "Success. All added lines contain the same number of elements.";
	$feed_reader_config_error_messages['right_number_of_lines_with_errors'] = "Errors. Some lines could not be added. All added lines contain the same number of elements.";



	//headers -------------------------------------------------------------
	//dropshipper headers
	$dshead[0] = "Goods";
	$dshead[1] = "ManufacturerPartNum";
	$dshead[2] = "WebTitle";
	$dshead[3] = "SubTitle";
	$dshead[4] = "mod_URL";
	$dshead[5] = "ListPrice";
	$dshead[6] = "SellPrice";
	$dshead[7] = "SellCur";
	$dshead[8] = "BuyPrice";
	$dshead[9] = "Points";
	$dshead[10] = "Keywords";
	$dshead[11] = "ShortDesc";
	$dshead[12] = "OnMarket";
	$dshead[13] = "width";
	$dshead[14] = "height";
	$dshead[15] = "depth";
	$dshead[16] = "weight";
	$dshead[17] = "DateCreated";


	//soldsmart headers
	$sshead[0] = 'Goods';
	$sshead[1] = 'WebTitle';
	$sshead[2] = 'SubTitle';
	$sshead[3] = 'mod_URL';
	$sshead[4] = 'ListPrice';
	$sshead[5] = 'SellPrice';
	$sshead[6] = 'BuyPrice';
	$sshead[7] = 'Points';
	$sshead[8] = 'OnMarket';
	$sshead[9] = 'InStock_and_transit';
	$sshead[10] = 'Width';
	$sshead[11] = 'Height';
	$sshead[12] = 'Depth';
	$sshead[13] = 'Weight';
	$sshead[14] = 'ShipCharge';
	$sshead[15] = 'Coupon';
	$sshead[16] = 'Expiry';
	$sshead[17] = 'CoupValue';
	$sshead[18] = 'DisPrice';
	$sshead[19] = 'Postock';
	$sshead[20] = 'DateCreated';

	//froogle headers
	$frooghead[0] = 'image_url';
	$frooghead[1] = 'category';
	$frooghead[2] = 'Goods';


	//onescent headers
	$onehead[0] = 'code';
	$onehead[1] = 'rrp';
	$onehead[2] = 'cost';
	$onehead[3] = 'sell';
	$onehead[4] = 'stock level';

	//unitex headers
	$unitexhead[0] = 'Product_Code';
	$unitexhead[1] = 'RRP';
	$unitexhead[2] = 'Cost';
	$unitexhead[3] = 'Sell';
	$unitexhead[4] = 'Stock';


	//newaim headers
	$newaimhead[0] = 'SKU';
	$newaimhead[1] = 'RRP';
	$newaimhead[2] = 'Cost';
	$newaimhead[3] = 'Selling Price';
	$newaimhead[4] = 'QOH';

	//trinity headers
	$trinityhead[0] = 'Product_Code';
	$trinityhead[1] = 'RRP';
	$trinityhead[2] = 'Cost';
	$trinityhead[3] = 'Sell';
	$trinityhead[4] = 'Stock';

	//powerhouse headers
	$pwrhsehead[0] = 'Product_Code';
	$pwrhsehead[1] = 'RRP';
	$pwrhsehead[2] = 'Cost';
	$pwrhsehead[3] = 'Sell';
	$pwrhsehead[4] = 'Stock';


	//simply wholesale headers
	$simplyhead[0] = 'Code';
	$simplyhead[1] = 'RRP';
	$simplyhead[2] = 'Buy Price';
	$simplyhead[3] = 'Suggested Sell Price';
	$simplyhead[4] = 'Stock Level';



	//Dr Carl headers
	$drcarlhead[0] = 'Code';
	$drcarlhead[1] = 'RRP';
	$drcarlhead[2] = 'Buy Price';
	$drcarlhead[3] = 'Suggested Sell Price';
	$drcarlhead[4] = 'Stock Level';


	//Serrano headers
	$serranohead[0] = 'id';
	$serranohead[1] = 'rrp';
	$serranohead[2] = 'member_price';
	$serranohead[3] = 'price';
	$serranohead[4] = 'availability';		



	//rapid publisher headers
	$rphead[0] = 'SKU';
	$rphead[1] = 'ManufacturerPartNum';
	$rphead[2] = 'OnMarket';




	//ebay
	//listing report headers
	$ebaylistrephead[0] = 'SKU';
	$ebaylistrephead[1] = 'Avail';


	//listing report headers
	$ebayshippricehead[0] = 'SKU';
	$ebayshippricehead[1] = 'Shipprice';


	//gshop item headers
	$gshoppricehead[0] = 'id';
	$gshoppricehead[1] = 'google_product_category';
	$gshoppricehead[2] = 'shipping';


	//gshop import category headers
	$gshopcatshead[0] = 'cat';


	//frogle import category headers
	$frooglecatshead[0] = 'cat';

	//frogle import main headers
	$frooglemainshead[0] = 'image_url';
	$frooglemainshead[1] = 'category';
	$frooglemainshead[2] = 'Goods';

	//short desc import
	$shortdeshead[0] = 'Goods';
	$shortdeshead[1] = 'ShortDesc';
	$shortdeshead[2] = 'Keywords';

	

	



?>