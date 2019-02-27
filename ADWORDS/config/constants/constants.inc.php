<?php




	//HTTP System
	define('ROOT', 'http://127.0.0.1/EBAY_API/ADWORDS/');//change this to your server details
	define('HTTPS_ROOT', 'https://127.0.0.1/EBAY_API/ADWORDS/');//change this to your server details
/*
	define('ROOT', 'http://www.phptutes.com/felix/');//change this to your server details
	define('HTTPS_ROOT', 'https://www.phptutes.com/felix/');//change this to your server details
*/



	define('HTTP_CAPTCHCA', ROOT . 'captchca/');

	//ebay api http
	define('EBAY_API_ROOT', ROOT . 'ebay_api/');


	//FILESYSTEM
	define('FILE_SYSTEM_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/');
	define('FILE_SYSTEM_MAIN', FILE_SYSTEM_ROOT . 'KOKO_LIVING_EBAY_API/ADWORDS/'); //change this to your server details

	//define('FILE_SYSTEM_MAIN', FILE_SYSTEM_ROOT . '/felix/'); //change this to your server details
	define('UPDATE_INCLUDES_DIR','../ebay_api_update_listing/includes/');


	//regular filesystem files

	define('FILE_SYSTEM_APP', FILE_SYSTEM_MAIN . 'app/');
	define('FILE_SYSTEM_CONFIG', FILE_SYSTEM_MAIN . 'config/');

	define('FILE_SYSTEM_APP_DBASE', FILE_SYSTEM_APP . 'dbase/');
	define('FILE_SYSTEM_APP_PAGINATION', FILE_SYSTEM_APP . 'pagination/');

	define('FILE_SYSTEM_APP_CALLS', FILE_SYSTEM_APP . 'calls/');
	define('FILE_SYSTEM_APP_LOGS', FILE_SYSTEM_APP . 'logs/');
	define('FILE_SYSTEM_LOGS', FILE_SYSTEM_MAIN . 'logs/');
	define('FILE_SYSTEM_CURL', FILE_SYSTEM_APP . 'curl/');
	define('FILE_SYSTEM_IMAGING', FILE_SYSTEM_APP . 'imaging/');
	define('FILE_SYSTEM_HTML_OUTPUT', FILE_SYSTEM_APP . 'html/');
	define('FILE_SYSTEM_HELPERS', FILE_SYSTEM_APP . 'helpers/');
	define('FILE_SYSTEM_CAPTCHCA', FILE_SYSTEM_APP . 'captchca/');
	define('FILE_SYSTEM_FILE_UPLOADING', FILE_SYSTEM_APP . 'file_uploading/');
	define('FILE_SYSTEM_FEED_READER', FILE_SYSTEM_APP . 'feed_reader/');



	define('FILE_SYSTEM_IMAGES', FILE_SYSTEM_MAIN . 'images/');
	define('FILE_SYSTEM_CAPTCHCA_IMAGES', FILE_SYSTEM_MAIN . 'captchca/');




	define('FILE_SYSTEM_CONFIG_IMAGING', FILE_SYSTEM_CONFIG . 'imaging/');
	define('FILE_SYSTEM_CONFIG_DBASE', FILE_SYSTEM_CONFIG . 'dbase/');
	define('FILE_SYSTEM_CONFIG_CURLER', FILE_SYSTEM_CONFIG . 'curler/');
	define('FILE_SYSTEM_CONFIG_HELPERS', FILE_SYSTEM_CONFIG . 'helpers/');
	define('FILE_SYSTEM_CONFIG_FILE_UPLOAD', FILE_SYSTEM_CONFIG . 'file_uploading/');
	define('FILE_SYSTEM_CONFIG_FEED_READER', FILE_SYSTEM_CONFIG . 'feed_reader/');



	//dbase files
	define('FILE_SYSTEM_DBASE_CALL', FILE_SYSTEM_APP_CALLS . 'dbase_call.php');
	define('FILE_SYSTEM_DBASE_GETTERS', FILE_SYSTEM_APP_DBASE . 'dbase_getters.inc.php');
	define('FILE_SYSTEM_DBASE_SETTERS', FILE_SYSTEM_APP_DBASE . 'dbase_setters.inc.php');
	define('FILE_SYSTEM_DBASE_FUNCS', FILE_SYSTEM_APP_DBASE . 'sqlidbasefuncs.inc.php');
	define('FILE_SYSTEM_DBASE_CONFIG', FILE_SYSTEM_CONFIG_DBASE . 'dbase_config.php');
	define('FILE_SYSTEM_DBASE_TABLES_CONSTANTS', FILE_SYSTEM_CONFIG . "constants/dbase_tables.inc.php");

	//pagination files
	define('FILE_SYSTEM_PAGINATION_CLASS', FILE_SYSTEM_APP_PAGINATION . 'pagination.inc.php');
	define('FILE_SYSTEM_PAGINATION_CALL', FILE_SYSTEM_APP_CALLS . 'pagination_call.php');

	//log files
	define('FILE_SYSTEM_LOGS_FILE', FILE_SYSTEM_LOGS . 'logs.txt');
	define('FILE_SYSTEM_LOGS_CLASS', FILE_SYSTEM_APP_LOGS . 'logs.inc.php');
	define('FILE_SYSTEM_LOGS_CALL', FILE_SYSTEM_APP_CALLS . 'logs_call.php');

	//curl files
	define('FILE_SYSTEM_CURL_CLASS', FILE_SYSTEM_CURL . 'curler.inc.php');
	define('FILE_SYSTEM_CURL_CALLER', FILE_SYSTEM_APP_CALLS . 'curler_call.php');
	define('FILE_SYSTEM_CURL_CONFIG_FILE', FILE_SYSTEM_CONFIG_CURLER . 'curler_config.php');

	//imaging files
	define('FILE_SYSTEM_IMAGING_CLASS', FILE_SYSTEM_IMAGING . 'imaging.inc.php');
	define('FILE_SYSTEM_IMAGING_CALLER', FILE_SYSTEM_APP_CALLS . 'imaging_call.php');
	define('FILE_SYSTEM_IMAGING_CONFIG_FILE', FILE_SYSTEM_CONFIG_IMAGING . 'imaging_config.php');

	//html output files
	define('FILE_SYSTEM_HTML_OUTPUT_CLASS', FILE_SYSTEM_HTML_OUTPUT . 'html_output.inc.php');
	define('FILE_SYSTEM_HTML_OUTPUT_CALLER', FILE_SYSTEM_APP_CALLS . 'html_output_call.php');

	//helper files
	define('FILE_SYSTEM_INPUT_HELPER_CLASS', FILE_SYSTEM_HELPERS . 'input_helper.inc.php');
	define('FILE_SYSTEM_INPUT_HELPER_CONFIG_FILE', FILE_SYSTEM_CONFIG_HELPERS . 'helper_config.php');

	//main caller - auto-loaded at startup
	define('FILE_SYSTEM_MAIN_CALLER', FILE_SYSTEM_APP_CALLS . 'main_caller.php');


	//captchca fles
	define('FILE_SYSTEM_CAPTCHCA_CLASS', FILE_SYSTEM_CAPTCHCA . 'captchca.inc.php');
	define('FILE_SYSTEM_CAPTCHCA_CALLER', FILE_SYSTEM_APP_CALLS . 'captchca_call.php');
	//raw captchca image
	define('FILE_SYSTEM_CAPTCHCA_RAW_IMAGE', FILE_SYSTEM_CAPTCHCA . 'captchca_raw.png');

	//file uploading files
	define('FILE_SYSTEM_FILE_UPLOADING_CLASS', FILE_SYSTEM_FILE_UPLOADING . 'file_uploading.inc.php');
	define('FILE_SYSTEM_FILE_UPLOADING_CALLER', FILE_SYSTEM_APP_CALLS . 'file_uploading_call.php');
	define('FILE_SYSTEM_FILE_UPLOADING_CONFIG_FILE', FILE_SYSTEM_CONFIG_FILE_UPLOAD . 'file_uploading_config.php');

	//Feed reader
	define('FILE_SYSTEM_FEED_READER_CLASS', FILE_SYSTEM_FEED_READER . 'feed_reader.inc.php');
	define('FILE_SYSTEM_FEED_READER_CALLER', FILE_SYSTEM_APP_CALLS . 'feed_reader_call.php');
	define('FILE_SYSTEM_FEED_READER_CONFIG_FILE', FILE_SYSTEM_CONFIG_FEED_READER . 'feed_reader_config.php');




	define('FILE_SYSTEM_INCLUDES', FILE_SYSTEM_APP . 'includes/');

	define('FILE_SYSTEM_DSFEEDFUNC_INC', FILE_SYSTEM_INCLUDES . 'dsfeed_funcs.inc.php');
	define('FILE_SYSTEM_EBAY_API_INC', FILE_SYSTEM_INCLUDES . 'ebay_api_class.inc.php');





	//ebay api
	define('EBAY_API_FILESYSTEM', FILE_SYSTEM_MAIN . 'ebay_api/');

	define('EBAY_API_FILESYSTEM_INCLUDES', EBAY_API_FILESYSTEM . 'includes/');
	define('EBAY_API_FILESYSTEM_CLASSES', EBAY_API_FILESYSTEM . 'classes/');

	define('EBAY_API_FILESYSTEM_CONSTANTS', EBAY_API_FILESYSTEM . 'includes/constants.inc.php');


	define('EBAY_API_FILESYSTEM_CONFIG', UPDATE_INCLUDES_DIR . 'config.inc.php');
	define('EBAY_API_FILESYSTEM_UPDATE_ITEM', EBAY_API_FILESYSTEM_CLASSES . 'updateItem.class.php');
	define('EBAY_API_FILESYSTEM_CALL_FUNCTIONS', EBAY_API_FILESYSTEM_CLASSES . 'call_functions.class.php');
	define('EBAY_API_FILESYSTEM_DOM_FUNCTIONS', EBAY_API_FILESYSTEM_CLASSES . 'domFunctions.class.php');

	//END FILESYSTEM


//////////////////////OUTPUT FILES////////////////////////////////////////////////////////////////
	define('UPLOADS_FOLDER', FILE_SYSTEM_MAIN . 'uploads/');
	define('OUTPUT_FOLDER', FILE_SYSTEM_MAIN . 'output/');


	define('HTMLNEWSOUTPUT_FOLDER', FILE_SYSTEM_MAIN . 'output/htmlnewsletter/');
	define('TEXTNEWSOUTPUT_FOLDER', FILE_SYSTEM_MAIN . 'output/textnewsletter/');
	define('EBAYOUTPUT_FOLDER', FILE_SYSTEM_MAIN . 'output/ebay/');

	define('HTTP_HTMLNEWSOUTPUT_FOLDER', ROOT  . "output/htmlnewsletter/");
	define('HTTP_TEXTNEWSOUTPUT_FOLDER', ROOT  . "output/textnewsletter/");
	define('HTTP_EBAYOUTPUT_FOLDER', ROOT  . "output/ebay/");

	//EBAY FILES
	define('ACTIVE_OUTPUT', EBAYOUTPUT_FOLDER . 'activelistings.txt');
	define('ACTIVE_OUTPUT_HTTP', HTTP_EBAYOUTPUT_FOLDER . 'activelistings.txt');
	define('ACTIVE_VAR_OUTPUT', EBAYOUTPUT_FOLDER . 'activevarlistings.txt');
	define('ACTIVE_VAR_OUTPUT_HTTP', HTTP_EBAYOUTPUT_FOLDER . 'activevarlistings.txt');
	define('DEPLETE_EB_DS', EBAYOUTPUT_FOLDER . 'deplete_ds.txt');
	define('DEPLETE_EB_DS_HTTP', HTTP_EBAYOUTPUT_FOLDER . 'deplete_ds.txt');
	define('REPLENISH_EB_DS', EBAYOUTPUT_FOLDER . 'replenish_ds.txt');
	define('REPLENISH_EB_DS_HTTP', HTTP_EBAYOUTPUT_FOLDER . 'replenish_ds.txt');
	define('EB_TEN_DAY_LIST', EBAYOUTPUT_FOLDER . 'ebay_ten_day_list.txt');
	define('EB_TEN_DAY_LIST_HTTP', HTTP_EBAYOUTPUT_FOLDER . 'ebay_ten_day_list.txt');
	define('EB_SS_REPLENISHFILE', EBAYOUTPUT_FOLDER . 'ebay_ss_replenish_list.txt');
	define('EB_SS_REPLENISHFILE_HTTP', HTTP_EBAYOUTPUT_FOLDER . 'ebay_ss_replenish_list.txt');
	define('EB_AUCTION_ADDFILE', EBAYOUTPUT_FOLDER . 'ebay_auction_add.txt');
	define('EB_AUCTION_ADDFILE_HTTP', HTTP_EBAYOUTPUT_FOLDER . 'ebay_auction_add.txt');


	//ADWORDS FILES
	define('ADGROUPS_OUTPUT_FILE', OUTPUT_FOLDER . "adgroups.txt");
	define('ADS_OUTPUT_FILE', OUTPUT_FOLDER . "ads.txt");
	define('KEYWORDS_OUTPUT_FILE', OUTPUT_FOLDER . "keywords.txt");
	define('ADGROUPS_STOCK_UPDATE_OUTPUT_FILE', OUTPUT_FOLDER . "adgroups_stock_update.txt");

	define('ADGROUPS_STOCK_UPDATE_OUTPUT_FILE_HTTP',ROOT . 'output/adgroups_stock_update.txt');

	//GSHOP FILES
	define('GSHOP_NOT_ON', OUTPUT_FOLDER . 'gshopnoton.txt');
	define('GSHOP_NOT_ON_HTTP', ROOT . 'output/gshopnoton.txt');
	define('GSHOP_MAIN_FEED', OUTPUT_FOLDER . 'gshopmainfeed.txt');
	define('GSHOP_MAIN_FEED_HTTP', ROOT . 'output/gshopmainfeed.txt');


	//DROPSHIPPER RAPID PUBLISHER FILES
	//filesystem
	define('DS_RP_ONESCENT_FILE', OUTPUT_FOLDER . "datafeed_OneScent.txt");
	define('DS_RP_UNITEX_FILE', OUTPUT_FOLDER . "datafeed_Unitex.txt");
	define('DS_RP_NEWAIM_FILE', OUTPUT_FOLDER . "datafeed_newaim.txt");
	define('DS_RP_TRINITY_FILE', OUTPUT_FOLDER . "datafeed_TrinityTrade.txt");
	define('DS_RP_PWR_FILE', OUTPUT_FOLDER . "datafeed_power.txt");
	define('DS_RP_SIMPLY_FILE', OUTPUT_FOLDER . "datafeed_SimplyWholesale.txt");
	define('DS_RP_DRCARL_FILE', OUTPUT_FOLDER . "datafeed_drCarl.txt");
	define('DS_RP_SERRANO_FILE', OUTPUT_FOLDER . "datafeed_serrano.txt");
	define('DS_RP_MITTONI_FILE', OUTPUT_FOLDER . "datafeed_Mittoni.txt");



	define('DS_RP_ONESCENT_MISSING_FILE', OUTPUT_FOLDER . "missing_OneScent.txt");
	define('DS_RP_UNITEX_MISSING_FILE', OUTPUT_FOLDER . "missing_Unitex.txt");
	define('DS_RP_NEWAIM_MISSING_FILE', OUTPUT_FOLDER . "missing_newaim.txt");
	define('DS_RP_TRINITY_MISSING_FILE', OUTPUT_FOLDER . "missing_trinity.txt");
	define('DS_RP_PWR_MISSING_FILE', OUTPUT_FOLDER . "missing_powerhouse.txt");
	define('DS_RP_SIMPLY_MISSING_FILE', OUTPUT_FOLDER . "missing_simply.txt");
	define('DS_RP_DRCARL_MISSING_FILE', OUTPUT_FOLDER . "missing_drcarl.txt");
	define('DS_RP_SERRANO_MISSING_FILE', OUTPUT_FOLDER . "missing_serrano.txt");
	define('DS_RP_MITTONI_MISSING_FILE', OUTPUT_FOLDER . "missing_mittoni.txt");

	//http
	define('DS_RP_ONESCENT_FILE_HTTP', ROOT  . "output/datafeed_OneScent.txt");
	define('DS_RP_UNITEX_FILE_HTTP', ROOT  . "output/datafeed_Unitex.txt");
	define('DS_RP_NEWAIM_FILE_HTTP', ROOT  . "output/datafeed_newaim.txt");
	define('DS_RP_TRINITY_FILE_HTTP', ROOT  . "output/datafeed_TrinityTrade.txt");
	define('DS_RP_PWR_FILE_HTTP', ROOT  . "output/datafeed_power.txt");
	define('DS_RP_SIMPLY_FILE_HTTP', ROOT  . "output/datafeed_SimplyWholesale.txt");
	define('DS_RP_DRCARL_HTTP', ROOT  . "output/datafeed_drCarl.txt");
	define('DS_RP_SERRANO_HTTP', ROOT  . "output/datafeed_serrano.txt");
	define('DS_RP_MITTONI_HTTP', ROOT  . "output/datafeed_Mittoni.txt");


	define('DS_RP_ONESCENT_MISSING_FILE_HTTP', ROOT  . "output/missing_OneScent.txt");
	define('DS_RP_UNITEX_MISSING_FILE_HTTP', ROOT  . "output/missing_Unitex.txt");
	define('DS_RP_NEWAIM_MISSING_FILE_HTTP', ROOT  . "output/missing_newaim.txt");
	define('DS_RP_TRINITY_MISSING_FILE_HTTP', ROOT  . "output/missing_trinity.txt");
	define('DS_RP_PWR_MISSING_FILE_HTTP', ROOT  . "output/missing_powerhouse.txt");
	define('DS_RP_SIMPLY_MISSING_FILE_HTTP', ROOT  . "output/missing_simply.txt");
	define('DS_RP_DRCARL_MISSING_FILE_HTTP', ROOT  . "output/missing_drcarl.txt");
	define('DS_RP_SERRANO_MISSING_FILE_HTTP', ROOT . "output/missing_serrano.txt");
	define('DS_RP_MITTONI_MISSING_FILE_HTTP', ROOT . "output/missing_mittoni.txt");


///////////////////////END OUTPUT FILES////////////////////////////////////////////////////////////




	//INDIVIDUAL PAGES
	define('ADWORDS_MAIN', ROOT. 'adwordsmain.php');

	define('FORM_RESUBMIT_MSG','Please correct the errors and re-submit the form.');
	define('FORM_SUBMIT_OKMSG','Your data was successfully submitted.');



	//allow file uploads no larger than this
	define('MAX_FILE_UPLOAD_SIZE',5000000);

	define('GSHOPMINSTOCK',1);

	define('NLMAIN',"\r\n");
	define('TABDELIM',"	");
	define('COMMADELIM',",");
	define('PIPDELIM',"|");
	define('NLPARTONLY',"\n");

	define('DS_SET_ACTIVE',"1");
	define('DS_SET_INACTIVE',"0");

	define('ACTIVE_TEXT',"Active");
	define('PAUSED_TEXT',"Paused");
	//UPLOAD TYPES
	define('UPLOAD_TYPE_DROPSHIPPER',"1");
	define('UPLOAD_TYPE_SS',"2");
	define('UPLOAD_TYPE_FROOGLE',"3");
	define('UPLOAD_TYPE_SS_SHORT_DES',"4");

	//STOCK TYPES - TIED TO DBASE SO DO NOT ALTER
	define('STOCK_TYPE_STANDARD',"1");
	define('STOCK_TYPE_POSTOCK',"2");
	define('STOCK_TYPE_DROPSHIPPER',"3");


	//DS TYPES - TIED TO DBASE SO DO NOT ALTER
/*
	//FELIX VALUES

	define('DS_TYPE_SS',"1");
	define('DS_TYPE_UNITEX',"2");
	define('DS_TYPE_NEWAIM',"3");
	define('DS_TYPE_ONESCENT',"4");
	define('DS_TYPE_POWERHOUSE',"5");
	define('DS_TYPE_BDIRECT',"6");
	define('DS_TYPE_TRINITY',"7");
	define('DS_TYPE_DRCARL',"8");
	define('DS_TYPE_SIMPLYWHOLESALE',"9");
*/


	define('DS_TYPE_SS',"1");
	define('DS_TYPE_UNITEX',"2");
	define('DS_TYPE_NEWAIM',"3");
	define('DS_TYPE_ONESCENT',"4");
	define('DS_TYPE_POWERHOUSE',"5");
	define('DS_TYPE_BDIRECT',"6");
	define('DS_TYPE_TRINITY',"7");
	define('DS_TYPE_SIMPLYWHOLESALE',"9");
	define('DS_TYPE_DRCARL',"8");
	define('DS_TYPE_MITTONI',"10");
	define('DS_TYPE_SERRANO',"11");

	//Stock buffer
	define('DEFAULT_SS_BUFFER',"5");
	define('DEFAULT_EBAY_BUFFER',"10");


	//market status
	define('ITEM_ON_MARKET_STATUS_SET',"1");
	define('ITEM_OFF_MARKET_STATUS_SET',"0");

	//FEED UPDATE time limit
	define('FEED_UPDATE_TIME_LIMIT',86400);




	//EBAY LISTING TYPES
	define('EBAY_TYPE_CODE_FIXED',"FixedPriceItem");
	define('EBAY_TYPE_CODE_AUCTION',"Chinese");

	//ebay auction multiplicator buffer
	define('EBAY_BUFFER', 0.9);

	define('EBAY_DAYS_TEN', "Days_10");
	define('EBAY_DAYS_FIVE', "Days_5");
	define('EBAY_DAYS_THREE', "Days_3");

	define('TEN_HRS_SECS', 36000);
	define('DAYS_TEN_SECS', 864000);
	define('DAYS_FIVE_SECS', 432000);
	define('DAYS_THREE_SECS', 259200);
?>
