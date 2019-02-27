<?php


	/* Generate queries for getting data from database */


	Class dbase_getters{
		private $connection;

		
		function __construct($connector){

			$this->connection = $connector;
			
			
		}
		

		/*
			$table = string name of table
			$select_cols = single dimension array of column names to select. 
			$where_cols = multi dimensional array of column names and values to select. [0] = column name, [1] = value . if false leave blank
			$order = multi dimension array of column names and asc or desc type [0] = col name [1] = asc / desc (0 or 1)
			$limit = single dimension array ['lower'] = start num  ['upper'] = end num

		*/

		public function basic_get($table, $select_cols, $where_cols, $order, $limit){

			$query = "SELECT " ;

			
			
			for ($i=0; $i < sizeof($select_cols) ;$i++){
				//first
				if ($i == 0 && sizeof($select_cols) > 1){
					$cols_show = $select_cols[$i] . ", ";
				}

				else if ($i == 0 && sizeof($select_cols) == 1){
					$cols_show = $select_cols[$i] . " ";
				}

				//last
				else if ($i== sizeof($select_cols)-1){
					$cols_show .= $select_cols[$i] . " ";	
				}
				//middle
				else{
					$cols_show .= $select_cols[$i] . ", ";
					
				}

			}	
			
			
			$query .= $cols_show;
		

			$query .= " FROM " . $table . " ";


			if (!empty($where_cols)){
				for ($i=0; $i < sizeof($where_cols) ;$i++){
					//first
					if ($i == 0 && sizeof($where_cols) > 1){
						$cols_show = " WHERE " . $where_cols[$i][0] . " = '" . addslashes($where_cols[$i][1]) . "' AND ";
					}

					else if ($i == 0 && sizeof($where_cols) == 1){
						$cols_show = " WHERE " . $where_cols[$i][0] . " = '" . addslashes($where_cols[$i][1]) . "' ";
					}

					//last
					else if ($i== sizeof($where_cols) - 1){
						$cols_show .= $where_cols[$i][0] . " = '" . addslashes($where_cols[$i][1]) . "' ";	
					}
					//middle
					else{
						$cols_show .= $where_cols[$i][0] . " = '" . addslashes($where_cols[$i][1]) . "' AND ";
						
					}

				}	
				
				$query .= $cols_show;

			}



			if (!empty($order)){

				for ($i=0; $i < sizeof($order) ;$i++){
					//set ascending or descending
					if ($order[$i][1] == 0){
						$order_status = " ASC ";
					}
					else if ($order[$i][1] == 1){
						$order_status = " DESC ";
					}
					else{
						$order_status = " ASC ";
					}

					//first
					if ($i == 0 && sizeof($order) > 1){
						$cols_show = " ORDER BY " . $order[$i][0] . $order_status . ", ";
					}

					else if ($i == 0 && sizeof($order) == 1){
						$cols_show = " ORDER BY " . $order[$i][0] . $order_status . " ";
					}

					//last
					else if ($i== sizeof($order) - 1){
						$cols_show .= $order[$i][0] . $order_status . " ";	
					}
					//middle
					else{
						$cols_show .= $order[$i][0] . $order_status . ", ";
						
					}

				}

				$query .= $cols_show;

			}



			if (!empty($limit)){
				
				$query .= " LIMIT " . $limit['lower'] . ", " . $limit['upper'];
				


			}

			

			$result = $this->connection->connectreturn($query);
			$namesarray = array();
			foreach ($select_cols as $value) {
				array_push($namesarray, $value);
			}
			
			$final = $this->connection->dbaseloopback($result, $namesarray);
			return $final;
		
		}


		public function get_last_id($table){
			$query = "SELECT LAST_INSERT_ID() as last_id FROM " . $table;
			$result = $this->connection->connectreturn($query);
			$namesarray[0] = "last_id";

			$final = $this->connection->dbaseloopback($result, $namesarray);

			$lastid = $final['last_id'][0];

			return $lastid;
		}







		public function get_mpn_line($ManufacturerPartNum, $db_itemfields){

			$where_cols[0][0] = ITEM_MPN_SKU;
			$where_cols[0][1] = $ManufacturerPartNum;

			$final = $this->basic_get(ITEM_MAIN_TABLE, $db_itemfields, $where_cols, "", "");

			return $final;
		}

		public function get_ss_line($sku, $db_itemfields){

			$where_cols[0][0] = ITEM_SS_SKU;
			$where_cols[0][1] = $sku;

			$final = $this->basic_get(ITEM_MAIN_TABLE, $db_itemfields, $where_cols, "", "");

			return $final;
		}






		public function get_ship_line($sku, $db_itemfields){

			$where_cols[0][0] = EBAY_SHIP_PRICE_SKU;
			$where_cols[0][1] = $sku;

			$final = $this->basic_get(EBAY_SHIP_PRICE_TABLE, $db_itemfields, $where_cols, "", "");

			return $final;
		}



		public function get_ds_details($ds){

			$cols[0] = DS_TYPES_TABLE_ID;
			$cols[1] = DS_TYPES_TABLE_PREFIX;
			$cols[2] = DS_TYPES_TABLE_NAME;
			$cols[3] = DS_TYPES_ACTIVE;
			$cols[4] = DS_TYPES_MIN_SS_STOCK;
			$cols[5] = DS_TYPES_MIN_EBAY_STOCK;
			$cols[6] = DS_TYPES_EBAY_LIST;
			$cols[7] = DS_TYPES_LAST_FEED;

			$where_cols[0][0] = DS_TYPES_TABLE_ID;
			$where_cols[0][1] = $ds;

			$final = $this->basic_get(DS_TYPES_TABLE, $cols, $where_cols, "", "");

			return $final;
		}


		//type -> 0 is 0 stock level, 1 is 1 or greater stock level
		public function get_ds_active_listings_stock_over_x($type){
			if ($type == 0){
				$query = "SELECT * FROM " . EB_ACT_EBAY_ACTIVE . " WHERE " . EB_ACT_DROPSHIP_ID . " > '".DS_TYPE_SS."' AND " . EB_ACT_QUANTITY . " = '0'";
			}
			else if($type == 1){
				$query = "SELECT * FROM " . EB_ACT_EBAY_ACTIVE . " WHERE " . EB_ACT_DROPSHIP_ID . " > '".DS_TYPE_SS."' AND " . EB_ACT_QUANTITY . " >= '1'";
			}

			$result = $this->connection->connectreturn($query);

			$select_cols = array();

			$select_cols[0] = EB_ACT_ITEM_ID;
			$select_cols[1] = EB_ACT_SKU;
			$select_cols[2] = EB_ACT_QUANTITY;
			$select_cols[3] = EB_ACT_DROPSHIP_ID;

			$final = $this->connection->dbaseloopback($result, $select_cols);
			return $final;

		}



		public function get_list_rep(){
			$query = "SELECT * FROM " . EBAY_LISTING_REPORT_TABLE . " WHERE " . EBAY_LIST_REP_AVAIL . " > 0";

			$result = $this->connection->connectreturn($query);

			$select_cols = array();

			$select_cols[0] = EBAY_LIST_REP_ID;
			$select_cols[1] = EBAY_LIST_REP_SKU;
			$select_cols[2] = EBAY_LIST_REP_AVAIL;	

			$final = $this->connection->dbaseloopback($result, $select_cols);
			return $final;
		}


		public function is_kd_item_over_one_on_market($sku){
			$query = "SELECT * FROM " . ITEM_MAIN_TABLE . " WHERE " . ITEM_SS_SKU . " = '" . $sku . "' AND " . ITEM_ON_MARKET . " = '" . ITEM_ON_MARKET_STATUS_SET . "' AND " . ITEM_STOCK_LEVEL . " >= '1'";

			$result = $this->connection->connectreturn($query);

			$select_cols = array();

			$select_cols[0] = ITEM_ID;

			$final = $this->connection->dbaseloopback($result, $select_cols);
			
			if (sizeof($final[ITEM_ID]) > 0){
				return true;
			}
			else{
				return false;
			}
		}


		public function getonmarketnonpostockitems(){
			$query = "SELECT * FROM " . ITEM_MAIN_TABLE . " WHERE " . ITEM_ON_MARKET . " = '" . ITEM_ON_MARKET_STATUS_SET . "' AND (" . ITEM_STOCK_TYPE . " = '".STOCK_TYPE_STANDARD."' OR " . ITEM_STOCK_TYPE . " = '".STOCK_TYPE_DROPSHIPPER."' )";

			$result = $this->connection->connectreturn($query);

			$select_cols = array();

			$select_cols[0] = ITEM_SS_SKU;


			$final = $this->connection->dbaseloopback($result, $select_cols);
			
			return $final;
		}



		public function getonmarketnonpostockitemsoverone(){
			$query = "SELECT * FROM " . ITEM_MAIN_TABLE . " WHERE " . ITEM_ON_MARKET . " = '" . ITEM_ON_MARKET_STATUS_SET . "' AND " . ITEM_STOCK_LEVEL . " >= '".GSHOPMINSTOCK."' AND (" . ITEM_STOCK_TYPE . " = '".STOCK_TYPE_STANDARD."' OR " . ITEM_STOCK_TYPE . " = '".STOCK_TYPE_DROPSHIPPER."' )";

			$result = $this->connection->connectreturn($query);

			$select_cols = array();

			$select_cols[0] = ITEM_SS_SKU;
			$select_cols[1] = ITEM_WEBTITLE;
			$select_cols[2] = ITEM_SHORT_DES;
			$select_cols[3] = ITEM_MOD_URL;
			$select_cols[4] = ITEM_DISPRICE;


			$final = $this->connection->dbaseloopback($result, $select_cols);
			
			return $final;
		}


		public function run_cat_search($search){

			$searcher = $this->connection->linker->real_escape_string($search);

			$select_cols[0] = SS_FROOGLE_CAT;

			$where_cols[0][0] = SS_FROOGLE_SKU;
			$where_cols[0][1] = $searcher;

			$final = $this->basic_get(SS_FROOGLE_TBL, $select_cols, $where_cols, false, false);

			if (sizeof($final[SS_FROOGLE_CAT]) > 0){

				$catid = $final[SS_FROOGLE_CAT][0];




				//get the category name and the title
				$select_cols[0] = SS_CATS_NAME;

				$where_cols[0][0] = SS_CATS_ID;
				$where_cols[0][1] = $catid;

				$finalcats = $this->basic_get(SS_CATS_TBL, $select_cols, $where_cols, false, false);

				if (sizeof($finalcats[SS_CATS_NAME]) > 0){
					$catname = $finalcats[SS_CATS_NAME][0];
				}
				else{
					$catname = "No Category Assigned";
				}



				//get the category name and the title
				$select_cols[0] = ITEM_WEBTITLE;

				$where_cols[0][0] = ITEM_SS_SKU;
				$where_cols[0][1] = $searcher;

				$finaltitle = $this->basic_get(ITEM_MAIN_TABLE, $select_cols, $where_cols, false, false);

				if (sizeof($finaltitle[ITEM_WEBTITLE]) > 0){
					$title = $finaltitle[ITEM_WEBTITLE][0];
				}

				else{
					$title = "Item Not in Items Database";
				}

				$send[0] = $search;
				$send[1] = $catname;
				$send[2] = $title;

				return $send;



			}


			else{
					
				return false;

			}

		}
			
		
	}



?>