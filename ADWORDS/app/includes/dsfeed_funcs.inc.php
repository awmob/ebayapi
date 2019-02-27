<?php


	Class dsfeed_funcs{

		private $dbase_getters;
		private $dbase_setters;
		private $curler;


		function __construct($dbase_getters, $dbase_setters, $curler){
			//set the array with the config settings
			$this->dbase_getters = $dbase_getters;
			$this->dbase_setters = $dbase_setters;
			$this->curler = $curler;
		}
		

		public function get_last_update($dsid){

			$select_cols[0] = DS_TYPES_LAST_FEED;
			$where_cols[0][0] = DS_TYPES_TABLE_ID;
			$where_cols[0][1] = $dsid;

			$final = $this->dbase_getters->basic_get(DS_TYPES_TABLE, $select_cols, $where_cols, "", "");
			//get last feed time, parse if exists, send never if don't exist
			if (sizeof($final[DS_TYPES_LAST_FEED]) > 0){

				if ($final[DS_TYPES_LAST_FEED][0] == NULL){
					$return = "<span style='color:red'>Feed has never been updated!</span>";
				}
				else{
					$timeraw = $final[DS_TYPES_LAST_FEED][0];

					//work time differential
					$now = time();
					$timediff = $now - $timeraw;

					$convert_to_std = date("d-m-Y @ H:i", $timeraw);


				

					if ($timediff > FEED_UPDATE_TIME_LIMIT){
						$return = "<span style='color:red;'>Last Update: " . $convert_to_std . " - Over 24 Hours Since Last Updated!</span>";
					}
					else {
						$return = "<span style='color:green;'>Last Update: " . $convert_to_std . "</span>";
					}	
				}
				 
			}

			else{
				$return = "<span style='color:red'>Feed has never been updated!</span>";
			}

			return $return;
			

		
		}



		public function onescent_process($head, $feed_reader, $delim, $db_itemfields){
			$feed_url = "http://118.127.33.254/xmlfeed/datafeed.csv";

			//get feed
			$data = $this->curler->curl_getter($feed_url);

			if(strlen($data) < 10000){
				$error[0] = true;
				$error[1] = "Feed Download Error. Check feed exists at the following location and try again: <a href='http://118.127.33.254/xmlfeed/datafeed.csv'>CHECK FEED HERE</a>";

				return $error;
			}
			else {
				$error = $this->process_feeds_gen($head, $feed_reader, $delim, $db_itemfields, $data, DS_TYPE_ONESCENT);
				return $error;
			}
			
			
		}





		public function simplywholesale_process($head, $feed_reader, $delim, $db_itemfields){
			$feed_url = "http://www.simplywholesale.com.au/media/feed/simplywholesale_soldsmart.csv";

			//get feed
			$data = $this->curler->curl_getter($feed_url);

			if(strlen($data) < 1000){
				$error[0] = true;
				$error[1] = "Feed Download Error. Check feed exists at the following location and try again: <a href='http://www.simplywholesale.com.au/media/feed/simplywholesale_soldsmart.csv'>CHECK FEED HERE</a>";

				return $error;
			}
			else {
				$error = $this->process_feeds_gen($head, $feed_reader, $delim, $db_itemfields, $data, DS_TYPE_SIMPLYWHOLESALE);
				return $error;
			}
			
			
		}



		public function serrano_process($head, $feed_reader, $delim, $db_itemfields){
			$feed_url = "http://feeds.serranoaustralia.com.au/customer.2763987.txt";

			//get feed
			$data = $this->curler->curl_getter($feed_url);

			if(strlen($data) < 1000){

				$randomnum = rand(5, 15);

				$error[0] = true;
				$error[1] = "Feed Download Error. Check feed exists at the following location and try again: <a href='http://feeds.serranoaustralia.com.au/customer.2763987.txt?".$randomnum."'>CHECK FEED HERE</a>";

				return $error;
			}
			else {
				$error = $this->process_feeds_gen($head, $feed_reader, $delim, $db_itemfields, $data, DS_TYPE_SERRANO);
				return $error;
			}
			
			
		}


/****************************GENERAL FEED CHECKER********************************************************/


		public function process_feeds_gen($head, $feed_reader, $delim, $db_itemfields, $data, $ds_id){
			$success = true;
			$errmsg = "";
			$error = array();

			//separate into lines
			$lines = $feed_reader->break_feed_lines($data, NLPARTONLY);

			if(sizeof($lines) <= 1){
				$success = false;
				$errmsg = "There are no lines in your data.";
			}

			else{
				//separate into bits
				
				$lines_and_bits = $feed_reader->break_up_feed_lines_and_clean($lines, $delim, 0);

				if(sizeof($lines_and_bits) <= 2){
					$success = false;
					$errmsg = $lines_and_bits[0]['error_message'];
				}
				
				else{
				
					//check headers - returns positioning of elements
					$feed_header_check = $feed_reader->check_feed_headers($head, $lines_and_bits[1]);

					if(!$feed_header_check){
						$success = false;
						$errmsg = "<p>Not All Required Headers Exist in Your Data. Not Imported.</p>
						
						<p>The following headers are required:</p><p>";
						
						for ($i=0; $i < sizeof($head)  ;$i++){
							$errmsg .=  $head[$i] . "<br/>";

						}
						$errmsg .= "</p>";
					}
				}
			
			}


			if ($success){
				
				//run database entry stuff
				$this->upload_ds($head, $feed_header_check, $lines_and_bits, $db_itemfields, $ds_id);
				
				
				$error[0] = false;
				$error[1] = FORM_SUBMIT_OKMSG;
			}
			else{
				$error[0] = true;
				$error[1] = $errmsg;
			}

			return $error;
			


		}








		public function importcheck($head, $feed_reader, $data, $delim){
			$success = true;
			$errmsg = "";
			$error = array();

			//separate into lines
			$lines = $feed_reader->break_feed_lines($data, NLMAIN);

			

			if(sizeof($lines) <= 1){
				$success = false;
				
				$errmsg = "There are no lines in your data.";
			}

			else{
			
				//separate into bits
				
				$bits = $feed_reader->break_up_feed_lines_and_clean($lines, $delim, 0);

				if(sizeof($bits) <= 2){
					$success = false;
					$errmsg = $bits[0]['error_message'];
				}
				
				else{
				
					//check headers - returns positioning of elements
					$feed_header_check = $feed_reader->check_feed_headers($head, $bits[1]);

					if(!$feed_header_check){
						$success = false;
						$errmsg = "<p>Not All Required Headers Exist in Your Data. Not Imported.</p>
						
						<p>The following headers are required:</p><p>";
						
						for ($i=0; $i < sizeof($head)  ;$i++){
							$errmsg .=  $head[$i] . "<br/>";

						}
						$errmsg .= "</p>";
					}
				}
			
			}



			if ($success){
				$error[0] = false;
				$error[1] = FORM_SUBMIT_OKMSG;
				$error[2] = $bits;
				$error[3] = $feed_header_check;
			}

			else{
				$error[0] = true;
				$error[1] = $errmsg;

			}


			return $error;
		}






/****************************END GENERAL FEED CHECKER********************************************************/

		



		public function upload_ds($head, $feed_header_check, $lines_and_bits, $db_itemfields, $ds){

			//set stock and onmarket to zero for this ds.
			$this->set_ds_stock_mkt_zero($ds);


			//reset missing item files
			if($ds == DS_TYPE_ONESCENT){
				$miss_filename = DS_RP_ONESCENT_MISSING_FILE;
			}
			else if($ds == DS_TYPE_UNITEX){
				$miss_filename = DS_RP_UNITEX_MISSING_FILE;
			}
			else if($ds == DS_TYPE_NEWAIM){
				$miss_filename = DS_RP_NEWAIM_MISSING_FILE;
			}
			else if($ds == DS_TYPE_TRINITY){
				$miss_filename = DS_RP_TRINITY_MISSING_FILE;
			}
			else if($ds == DS_TYPE_POWERHOUSE){
				$miss_filename = DS_RP_PWR_MISSING_FILE;
			}
			else if($ds == DS_TYPE_SIMPLYWHOLESALE){
				$miss_filename = DS_RP_SIMPLY_MISSING_FILE;
			}
			else if($ds == DS_TYPE_DRCARL){
				$miss_filename = DS_RP_DRCARL_MISSING_FILE;
			}
			else if($ds == DS_TYPE_MITTONI){
				$miss_filename = DS_RP_MITTONI_MISSING_FILE;
			}
			else if($ds == DS_TYPE_SERRANO){
				$miss_filename = DS_RP_SERRANO_MISSING_FILE;
			}

			$fh = fopen($miss_filename, 'w');
			fclose($fh);


			//loop through bits
			//for lines_and_bits, data starts at [2]
			echo "Entering data into system. . . ";
			flush();
			ob_flush();

			

			
			for ($i=2; $i < sizeof($lines_and_bits)  ;$i++){
				if ($i % 10 == 0){
					echo ". ";
					flush();
					ob_flush();
				}

				
				if($ds == DS_TYPE_ONESCENT){

					if (sizeof($lines_and_bits[$i]) > 0){



						//assign variables
						$ManufacturerPartNum = trim($lines_and_bits[$i][$feed_header_check['code']]);
						$stocklevel = trim($lines_and_bits[$i][$feed_header_check['stock level']]);
						$suggested_list_price = trim($lines_and_bits[$i][$feed_header_check['rrp']]);
						$suggested_sell_price = trim($lines_and_bits[$i][$feed_header_check['sell']]);

						
					
						//set onmarket status variable depending on stock level
						$min_stock = $this->calculate_on_market($ds);
						$OnMarket = $this->set_onmarket_level($stocklevel, $min_stock);


						//cols shared by update and insert
						$cols = array();

						$cols[0][0] = ITEM_MPN_SKU;
						$cols[1][0] = ITEM_STOCK_LEVEL;
						$cols[2][0] = ITEM_ON_MARKET;
						$cols[3][0] = ITEM_SUGGESTED_LIST_PRICE;
						$cols[4][0] = ITEM_SUGGESTED_SELL_PRICE;
						
						$cols[0][1] = $ManufacturerPartNum;
						$cols[1][1] = $stocklevel;
						$cols[2][1] = $OnMarket;
						$cols[3][1] = $suggested_list_price;
						$cols[4][1] = $suggested_sell_price;
					}
					else{
						continue;
					}

					
				}

				else if($ds == DS_TYPE_UNITEX){
					if (sizeof($lines_and_bits[$i]) > 0){
						//assign variables
						$ManufacturerPartNum = trim($lines_and_bits[$i][$feed_header_check['Product_Code']]);
						$stocklevel = trim($lines_and_bits[$i][$feed_header_check['Stock']]);
						$suggested_list_price = trim($lines_and_bits[$i][$feed_header_check['RRP']]);
						$suggested_sell_price = trim($lines_and_bits[$i][$feed_header_check['Sell']]);

						
					
						//set onmarket status variable depending on stock level
						$min_stock = $this->calculate_on_market($ds);
						$OnMarket = $this->set_onmarket_level($stocklevel, $min_stock);


						//cols shared by update and insert
						$cols = array();

						$cols[0][0] = ITEM_MPN_SKU;
						$cols[1][0] = ITEM_STOCK_LEVEL;
						$cols[2][0] = ITEM_ON_MARKET;
						$cols[3][0] = ITEM_SUGGESTED_LIST_PRICE;
						$cols[4][0] = ITEM_SUGGESTED_SELL_PRICE;
						
						$cols[0][1] = $ManufacturerPartNum;
						$cols[1][1] = $stocklevel;
						$cols[2][1] = $OnMarket;
						$cols[3][1] = $suggested_list_price;
						$cols[4][1] = $suggested_sell_price;
					}
					else{
						continue;
					}

				}

				else if($ds == DS_TYPE_NEWAIM){
					
					if (sizeof($lines_and_bits[$i]) > 0){
						//assign variables
						$ManufacturerPartNum = trim($lines_and_bits[$i][$feed_header_check['SKU']]);
						$stocklevel = trim($lines_and_bits[$i][$feed_header_check['QOH']]);
						$suggested_list_price = trim($lines_and_bits[$i][$feed_header_check['RRP']]);
						$suggested_sell_price = trim($lines_and_bits[$i][$feed_header_check['Selling Price']]);

						
					
						//set onmarket status variable depending on stock level
						$min_stock = $this->calculate_on_market($ds);
						$OnMarket = $this->set_onmarket_level($stocklevel, $min_stock);


						//cols shared by update and insert
						$cols = array();

						$cols[0][0] = ITEM_MPN_SKU;
						$cols[1][0] = ITEM_STOCK_LEVEL;
						$cols[2][0] = ITEM_ON_MARKET;
						$cols[3][0] = ITEM_SUGGESTED_LIST_PRICE;
						$cols[4][0] = ITEM_SUGGESTED_SELL_PRICE;
						
						$cols[0][1] = $ManufacturerPartNum;
						$cols[1][1] = $stocklevel;
						$cols[2][1] = $OnMarket;
						$cols[3][1] = $suggested_list_price;
						$cols[4][1] = $suggested_sell_price;
					}
					else{
						continue;
					}


					
				}



				else if($ds == DS_TYPE_TRINITY){
					
					if (sizeof($lines_and_bits[$i]) > 0){
						//assign variables
						$ManufacturerPartNum = trim($lines_and_bits[$i][$feed_header_check['Product_Code']]);
						$stocklevel = trim($lines_and_bits[$i][$feed_header_check['Stock']]);
						$suggested_list_price = trim($lines_and_bits[$i][$feed_header_check['RRP']]);
						$suggested_sell_price = trim($lines_and_bits[$i][$feed_header_check['Sell']]);

						
					
						//set onmarket status variable depending on stock level
						$min_stock = $this->calculate_on_market($ds);
						$OnMarket = $this->set_onmarket_level($stocklevel, $min_stock);


						//cols shared by update and insert
						$cols = array();

						$cols[0][0] = ITEM_MPN_SKU;
						$cols[1][0] = ITEM_STOCK_LEVEL;
						$cols[2][0] = ITEM_ON_MARKET;
						$cols[3][0] = ITEM_SUGGESTED_LIST_PRICE;
						$cols[4][0] = ITEM_SUGGESTED_SELL_PRICE;
						
						$cols[0][1] = $ManufacturerPartNum;
						$cols[1][1] = $stocklevel;
						$cols[2][1] = $OnMarket;
						$cols[3][1] = $suggested_list_price;
						$cols[4][1] = $suggested_sell_price;

						
					}
					else{
						continue;
					}

				}



				else if($ds == DS_TYPE_POWERHOUSE){
					
					if (sizeof($lines_and_bits[$i]) > 0){
						//assign variables
						$ManufacturerPartNum = trim($lines_and_bits[$i][$feed_header_check['Product_Code']]);
						$stocklevel = trim($lines_and_bits[$i][$feed_header_check['Stock']]);
						$suggested_list_price = trim($lines_and_bits[$i][$feed_header_check['RRP']]);
						$suggested_sell_price = trim($lines_and_bits[$i][$feed_header_check['Sell']]);

						
					
						//set onmarket status variable depending on stock level
						$min_stock = $this->calculate_on_market($ds);
						$OnMarket = $this->set_onmarket_level($stocklevel, $min_stock);


						//cols shared by update and insert
						$cols = array();

						$cols[0][0] = ITEM_MPN_SKU;
						$cols[1][0] = ITEM_STOCK_LEVEL;
						$cols[2][0] = ITEM_ON_MARKET;
						$cols[3][0] = ITEM_SUGGESTED_LIST_PRICE;
						$cols[4][0] = ITEM_SUGGESTED_SELL_PRICE;
						
						$cols[0][1] = $ManufacturerPartNum;
						$cols[1][1] = $stocklevel;
						$cols[2][1] = $OnMarket;
						$cols[3][1] = $suggested_list_price;
						$cols[4][1] = $suggested_sell_price;

					}
					else{
						continue;
					}

				}


				else if($ds == DS_TYPE_SIMPLYWHOLESALE){
					
					if (sizeof($lines_and_bits[$i]) > 0){
						//assign variables
						$ManufacturerPartNum = trim($lines_and_bits[$i][$feed_header_check['Code']]);
						$stocklevel = trim($lines_and_bits[$i][$feed_header_check['Stock Level']]);
						$suggested_list_price = trim($lines_and_bits[$i][$feed_header_check['RRP']]);
						$suggested_sell_price = trim($lines_and_bits[$i][$feed_header_check['Suggested Sell Price']]);

						
					
						//set onmarket status variable depending on stock level
						$min_stock = $this->calculate_on_market($ds);
						$OnMarket = $this->set_onmarket_level($stocklevel, $min_stock);


						//cols shared by update and insert
						$cols = array();

						$cols[0][0] = ITEM_MPN_SKU;
						$cols[1][0] = ITEM_STOCK_LEVEL;
						$cols[2][0] = ITEM_ON_MARKET;
						$cols[3][0] = ITEM_SUGGESTED_LIST_PRICE;
						$cols[4][0] = ITEM_SUGGESTED_SELL_PRICE;
						
						$cols[0][1] = $ManufacturerPartNum;
						$cols[1][1] = $stocklevel;
						$cols[2][1] = $OnMarket;
						$cols[3][1] = $suggested_list_price;
						$cols[4][1] = $suggested_sell_price;
					}
					else{
						continue;
					}

					
				}




				else if($ds == DS_TYPE_DRCARL){
					
					if (sizeof($lines_and_bits[$i]) > 0){
						//assign variables
						$ManufacturerPartNum = trim($lines_and_bits[$i][$feed_header_check['Code']]);
						$stocklevel = trim($lines_and_bits[$i][$feed_header_check['Stock Level']]);
						$suggested_list_price = trim($lines_and_bits[$i][$feed_header_check['RRP']]);
						$suggested_sell_price = trim($lines_and_bits[$i][$feed_header_check['Suggested Sell Price']]);

						
					
						//set onmarket status variable depending on stock level
						$min_stock = $this->calculate_on_market($ds);
						$OnMarket = $this->set_onmarket_level($stocklevel, $min_stock);


						//cols shared by update and insert
						$cols = array();

						$cols[0][0] = ITEM_MPN_SKU;
						$cols[1][0] = ITEM_STOCK_LEVEL;
						$cols[2][0] = ITEM_ON_MARKET;
						$cols[3][0] = ITEM_SUGGESTED_LIST_PRICE;
						$cols[4][0] = ITEM_SUGGESTED_SELL_PRICE;
						
						$cols[0][1] = $ManufacturerPartNum;
						$cols[1][1] = $stocklevel;
						$cols[2][1] = $OnMarket;
						$cols[3][1] = $suggested_list_price;
						$cols[4][1] = $suggested_sell_price;

					}
					else{
						continue;
					}

				}

				//DO NOT USE FOR OTHERS - stock level is unique. Use another DS for template
				else if($ds == DS_TYPE_SERRANO){
					
					if (sizeof($lines_and_bits[$i]) > 0){
						//assign variables
						$ManufacturerPartNum = trim($lines_and_bits[$i][$feed_header_check['id']]);
						$stockavail = trim($lines_and_bits[$i][$feed_header_check['availability']]);
						$suggested_list_price = trim($lines_and_bits[$i][$feed_header_check['rrp']]);
						$suggested_sell_price = trim($lines_and_bits[$i][$feed_header_check['price']]);
		

						if($stockavail == "Yes"){
							$stocklevel = 6;
						}
						else{
							$stocklevel = 0;
						}
					
						//set onmarket status variable depending on stock level
						$min_stock = $this->calculate_on_market($ds);


						$OnMarket = $this->set_onmarket_level($stocklevel, $min_stock);


						//cols shared by update and insert
						$cols = array();

						$cols[0][0] = ITEM_MPN_SKU;
						$cols[1][0] = ITEM_STOCK_LEVEL;
						$cols[2][0] = ITEM_ON_MARKET;
						$cols[3][0] = ITEM_SUGGESTED_LIST_PRICE;
						$cols[4][0] = ITEM_SUGGESTED_SELL_PRICE;
						
						$cols[0][1] = $ManufacturerPartNum;
						$cols[1][1] = $stocklevel;
						$cols[2][1] = $OnMarket;
						$cols[3][1] = $suggested_list_price;
						$cols[4][1] = $suggested_sell_price;
					}
					else{
						continue;
					}

					
				}

				//check ds mpn against our database to see if duplicated
				$mpn_final = $this->dbase_getters->get_mpn_line($ManufacturerPartNum, $db_itemfields);
				
				//if item exists, update
				if (sizeof($mpn_final[ITEM_ID]) > 0){

					$upd_where[0][0] = ITEM_DROPSHIPPER_ID;
					$upd_where[0][1] = $ds;
					$upd_where[1][0] = ITEM_MPN_SKU;
					$upd_where[1][1] = $ManufacturerPartNum;
					
					$this->dbase_setters->update_query(ITEM_MAIN_TABLE, $cols, $upd_where);
					
				}
				else{
					//if item doesn't exist then add to the missed items file
					$liner_add = "";
					for ($z=0; $z < sizeof($lines_and_bits[$i]) ;$z++){
						
						$liner_add .= $lines_and_bits[$i][$z];

						if ($z < (sizeof($lines_and_bits[$i]) - 1)){
							$liner_add .= TABDELIM;
						}

					}

					$liner_add .= NLMAIN;

					//write entry to file
					$fh = fopen($miss_filename, 'a');
					fwrite($fh, $liner_add);
					fclose($fh);
				}

				
			}


		}



		public function set_ds_stock_mkt_zero($ds_id){
			//update stock level and market status for the dropshipper to zero

			$cols[0][0] = ITEM_ON_MARKET;
			$cols[0][1] = 0;
			$cols[1][0] = ITEM_STOCK_LEVEL;
			$cols[1][1] = 0;

			$where[0][0] = ITEM_DROPSHIPPER_ID;
			$where[0][1] = $ds_id;

			$this->dbase_setters->update_query(ITEM_MAIN_TABLE, $cols, $where);


		}

		//type is 0 for ss on market set, and 1 for ebay on market set
		public function calculate_on_market($dsid, $type = false){
			//get the stock level set
				/*
			$table = string name of table
			$select_cols = single dimension array of column names to select. 
			$where_cols = multi dimensional array of column names and values to select. [0] = column name, [1] = value . if false leave blank
			$order = multi dimension array of column names and asc or desc type [0] = col name [1] = asc / desc (0 or 1)
			$limit = single dimension array ['lower'] = start num  ['upper'] = end num

			*/

			if($type == 1){
				$select_cols[0] = DS_TYPES_MIN_EBAY_STOCK;
			}
			else{
				$select_cols[0] = DS_TYPES_MIN_SS_STOCK;
			}

			$where_cols[0][0] = DS_TYPES_TABLE_ID;
			$where_cols[0][1] = $dsid;

			$final = $this->dbase_getters->basic_get(DS_TYPES_TABLE, $select_cols, $where_cols, "", "");
			
			return $final[$select_cols[0]][0];


		}


		public function set_onmarket_level($stocklevel, $minstocklevel){
			if ($stocklevel > $minstocklevel){
				$onmarket = 1;
			}
			else{
				$onmarket = 0;
			}

			return $onmarket;


		}

		//$rphead is from feed_reader_config file
		public function create_rp_stockonly_feed($dsid, $filename, $rphead){
			//prep the file - set to empty
			$fh = fopen($filename, 'w');
			fclose($fh);

			//get the dropshipper item data from kerp
				
			$select_cols[0] = ITEM_SS_SKU;
			$select_cols[1] = ITEM_MPN_SKU;
			$select_cols[2] = ITEM_ON_MARKET;

			$where_cols[0][0] = ITEM_DROPSHIPPER_ID;
			$where_cols[0][1] = $dsid;
			$where_cols[1][0] = ITEM_STOCK_TYPE;
			$where_cols[1][1] = STOCK_TYPE_DROPSHIPPER;

			$feed_final = $this->dbase_getters->basic_get(ITEM_MAIN_TABLE, $select_cols, $where_cols, "", "");

			//set headers
			$head_data = $rphead[0] . TABDELIM . $rphead[1] . TABDELIM . $rphead[2] . NLMAIN;

			//write headers to the file
			$fh = fopen($filename, 'a');
			fwrite($fh, $head_data);
			fclose($fh);

			//loop and write to the file
			for ($i=0; $i < sizeof($feed_final[ITEM_SS_SKU])  ;$i++){

				if ($i % 10 == 0){
					echo " . ";
					flush();
					ob_flush();
				}

				if ($i == (sizeof($feed_final[ITEM_SS_SKU]) - 1)){
					$nl = "";
				}
				else{
					$nl = NLMAIN;
				}

				$stringData = $feed_final[ITEM_SS_SKU][$i] . TABDELIM . $feed_final[ITEM_MPN_SKU][$i] . TABDELIM . $feed_final[ITEM_ON_MARKET][$i] . $nl;

				$fh = fopen($filename, 'a');
				fwrite($fh, $stringData);
				fclose($fh);

			}

		}

		public function dsfeed_time_update($ds){

			$upd_where[0][0] = DS_TYPES_TABLE_ID;
			$upd_where[0][1] = $ds;

			$cols[0][0] = DS_TYPES_LAST_FEED;
			$cols[0][1] = time();
			
			$this->dbase_setters->update_query(DS_TYPES_TABLE, $cols, $upd_where);		
		}



		public function file_import_processing($file_name, $tmpfile){

			echo "Uploading <b>" . $file_name . "</b>. . .  ";
			flush();
			ob_flush();

			
			if ($tmpfile == ""){

				$mb = MAX_FILE_UPLOAD_SIZE / 1000000;
				
				$error[0] = true;
				$error[1] = "<div class='alerterror'>Either the size of your file <b>exceeds ".$mb."mb</b>, or you didn't choose a file to upload. Please try again.</div>";
				
			}
			
			//file is okay
			else{
				
				//get the contents of the file and set into a variable
				$tmpfile_data = file_get_contents($tmpfile);
				echo "Uploaded.<br/>Extracting file contents. . .  ";
				flush();
				ob_flush();

				$error[0] = false;
				$error[1] = $tmpfile_data;
			}

			return $error;




		}
	}



?>