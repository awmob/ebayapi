<?php


	define('CAMPAIGNS_TABLE','campaigns');

	define('CAMPAIGNS_TABLE_ID','id');
	define('CAMPAIGNS_TABLE_NAME','name');


	define('ADGROUPS_TABLE','adgroups');

	define('ADGROUPS_TABLE_ID','id');
	define('ADGROUPS_TABLE_CAMP_ID','campaign_id');
	define('ADGROUPS_TABLE_ADGROUP_NAME','adgroupname');



	define('DS_TYPES_TABLE','dropshipper_types');

	define('DS_TYPES_TABLE_ID','id');
	define('DS_TYPES_TABLE_PREFIX','prefix');
	define('DS_TYPES_TABLE_NAME','name');
	define('DS_TYPES_ACTIVE','active');
	define('DS_TYPES_MIN_SS_STOCK','min_ss_stock');
	define('DS_TYPES_MIN_EBAY_STOCK','min_ebay_stock');
	define('DS_TYPES_EBAY_LIST','ebay_list');
	define('DS_TYPES_LAST_FEED','last_feed');
	

	
	
	define('DS_STOCK_TYPES_TABLE','stock_type');

	define('DS_STOCK_TYPES_ID','stock_type_id');
	define('DS_STOCK_TYPES_NAME','stock_type_name');

	


	define('ITEM_MAIN_TABLE' , 'item_main_table');

	define('ITEM_ID' , 'item_id');
	define('ITEM_STOCK_TYPE' , 'item_stock_type');
	define('ITEM_DROPSHIPPER_ID' , 'item_dropshipper_id');
	define('ITEM_SS_SKU' , 'item_ss_sku');
	define('ITEM_MPN_SKU' , 'item_mpn_sku');
	define('ITEM_WEBTITLE' , 'item_webtitle');
	define('ITEM_SUBTITLE' , 'item_subtitle');
	define('ITEM_MOD_URL' , 'item_mod_url');
	define('ITEM_ACTUAL_LIST_PRICE' , 'item_actual_list_price');
	define('ITEM_SUGGESTED_LIST_PRICE' , 'item_suggested_list_price');
	define('ITEM_ACTUAL_SELL_PRICE' , 'item_actual_sell_price');
	define('ITEM_DISPRICE' , 'item_disprice');
	define('ITEM_SUGGESTED_SELL_PRICE' , 'item_suggested_sell_price');
	define('ITEM_COST_AUD' , 'item_cost_aud');
	define('ITEM_POINTS' , 'item_points');
	define('ITEM_SHORT_DES' , 'item_short_des');
	define('ITEM_ON_MARKET' , 'item_on_market');
	define('ITEM_STOCK_LEVEL' , 'item_stock_level');
	define('ITEM_WIDTH' , 'item_width');
	define('ITEM_HEIGHT' , 'item_height');
	define('ITEM_DEPTH' , 'item_depth');
	define('ITEM_WEIGHT' , 'item_weight');
	define('ITEM_SS_DATE_CREATED' , 'item_ss_date_created');
	define('ITEM_DATE_ENTERED' , 'item_date_last_update');
	define('ITEM_KEYWORDS' , 'item_keywords');
	define('ITEM_SHIPPRICE' , 'item_shipprice');
	define('ITEM_COUPONCODE' , 'item_couponcode');
	define('ITEM_COUPONVALUE' , 'item_couponvalue');
	define('ITEM_COUPON_EXPIRE' , 'item_coupon_expire');
	define('ITEM_BRAND' , 'item_brand');
	define('ITEM_COLOUR' , 'item_colour');
	define('ITEM_SIZE' , 'item_size');
	define('ITEM_MATERIAL' , 'item_material');

	

	//ebay listing report
	define('EBAY_LISTING_REPORT_TABLE' , 'ebay_listing_report');
	define('EBAY_LIST_REP_ID' , 'ebay_listrep_id');
	define('EBAY_LIST_REP_SKU' , 'ebay_listrep_sku');
	define('EBAY_LIST_REP_AVAIL' , 'ebay_listrep_avail');



	//ebay ship prices
	define('EBAY_SHIP_PRICE_TABLE' , 'ebay_ship_prices');
	define('EBAY_SHIP_PRICE_ID' , 'eb_ship_id');
	define('EBAY_SHIP_PRICE_SKU' , 'eb_ship_sku');
	define('EBAY_SHIP_PRICE_PRICE' , 'eb_ship_ship_price');


	
	//ebay active listings
	define('EB_ACT_EBAY_ACTIVE','ebay_active');
	define('EB_ACT_ID','id');
	define('EB_ACT_ITEM_ID','item_id');
	define('EB_ACT_SKU','sku');
	define('EB_ACT_QUANTITY','quantity');
	define('EB_ACT_PURCHASES','purchases');
	define('EB_ACT_PRICE','price');
	define('EB_ACT_START_DATE','start_date');
	define('EB_ACT_END_DATE','end_date');
	define('EB_ACT_TITLE','title');
	define('EB_ACT_OS_CONTROL','os_control');
	define('EB_ACT_STOCK_TYPE','stock_type');
	define('EB_ACT_DROPSHIP_ID','dropshipper_id');
	define('EB_ACT_LIST_TYPE','list_type');

	//ebay active Variation listings
	define('EB_ACT_EBAY_ACTIVEVAR','varebay_active');
	define('EB_ACT_IDVAR','varid');
	define('EB_ACT_ITEM_IDVAR','varitem_id');
	define('EB_ACT_SKUVAR','varsku');
	define('EB_ACT_QUANTITYVAR','varquantity');
	define('EB_ACT_PURCHASESVAR','varpurchases');
	define('EB_ACT_PRICEVAR','varprice');
	define('EB_ACT_START_DATEVAR','varstart_date');
	define('EB_ACT_END_DATEVAR','varend_date');
	define('EB_ACT_TITLEVAR','vartitle');
	define('EB_ACT_OS_CONTROLVAR','varos_control');
	define('EB_ACT_STOCK_TYPEVAR','varstock_type');
	define('EB_ACT_DROPSHIP_IDVAR','vardropshipper_id');
	define('EB_ACT_LIST_TYPEVAR','varlist_type');




	//ebay time updates
	define('EB_UPD_TRACKING','ebay_updatestracking');
	define('EB_UPD_ID','id');
	define('EB_UPD_LIST_REP','listing_report');
	define('EB_UPD_ACT_LIST','active_list');
	define('EB_UPD_ACT_VAR_LIST','active_var_list');
	define('EB_DROPSHIP_DEPLETE_LIST','ds_deplete_list');
	define('EB_DROPSHIP_REPLENISH_LIST','ds_replenish_list');
	define('EB_SS_TENDAY_LIST','ss_tenday_list');	
	define('EB_ADW_UPD_STOCK','adw_update_stock');	
	define('GS_NOT_ON_FILE_UPD','gs_not_on_file');
	define('GS_MAIN_FEED_UPD','gs_main_feed_upd');
	define('EB_SS_REPLENISH','ss_zero_replenish');
	define('EB_SS_AUCTION_ADD','ss_auction_add');

	//google shopping feeds
	define('GS_TBLE_GSHOP_FEED','gshop_feed');
	define('GS_TBLE_ID','gs_id');
	define('GS_TBLE_SKU','gs_sku');
	define('GS_TBLE_CAT','gs_google_cat');
	define('GS_TBLE_SHIP','gs_shipping');

	//google shopping cats
	define('GS_CATS_TBL','gshop_cats');
	define('GS_CATS_ID','gcats_id');
	define('GS_CATS_NAME','gcats_name');
	
	

	//sscats
	define('SS_CATS_TBL','ssmain_cats');
	define('SS_CATS_ID','ssmain_cats_id');
	define('SS_CATS_NAME','ssmain_cats_name');	


	//froogle
	define('SS_FROOGLE_TBL','ss_froogle');
	define('SS_FROOGLE_ID','ssfrg_id');
	define('SS_FROOGLE_SKU','ssfrg_sku');
	define('SS_FROOGLE_IMG_URL','image_url');
	define('SS_FROOGLE_CAT','category');	


?>