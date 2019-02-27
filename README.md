# ebayapi
Some PHP scripts to help manage ebay listings and ebay messaging. The code is a VERY raw assembly of various scripts written over the years, for internal business use only. Use at your peril!

1. Install both folders in root server folder

2. In ADWORDS\config\constants\constants.inc.php change:
   Line 7)   define('ROOT', 'http://YOUR_SERVER/ADWORDS/');//change this (YOUR_SERVER) to your server details
	 Line 8)   define('HTTPS_ROOT', 'https://YOUR_SERVER/ADWORDS/');//change this (YOUR_SERVER) to your server details
   Line 24)  define('FILE_SYSTEM_MAIN', FILE_SYSTEM_ROOT . 'YOUR_SERVER/ADWORDS/'); //change this (YOUR_SERVER) to your server root folder

3. In ebay_api_update_listing\includes\constants.inc.php change:
   Line 7) define('SERVER_NAME', '127.0.0.1');  change to your server details
   Line 8) define('ROOT', SERVER_NAME . '/ebay_api/'); change to your server root folder
   
4. In ebay_api_update_listing\includes\config.inc.php:
    a) Enter your ebay API credentials into the various fields. 
    b) If using sandbox for testing, set $sandbox to true, otherwise set $sandbox to false
    c) Sandbox credentials appear to the left of each ternary operator. Live credentials appear to right of ternary operator. 
    d) If your sandbox and live credentials are identical, then enter the same credentials into both sides of the ternary operator,
        or simply replace the ternary operators with a string.

To use the scripts, enter the ADWORDS directory (Named so because at one point Adwords management had been integrated into this series
of scripts). In the adwords directory, click on 'Ebay Management' and follow the prompts. You can download CSV files of your latest
eBay listings here. 

To manage your listings, messaging etc. click the 'Manage Listings' link. The Manage Listings menu allows you to import various 
CSV files to allow you to manage stock levels, pricing, customer messaging, and payment statuses.
