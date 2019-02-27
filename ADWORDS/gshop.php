<?php

	
	set_time_limit(0);
	error_reporting(0);
	header( 'Content-type: text/html; charset=utf-8' );

	require_once 'config/constants/constants.inc.php';
	require_once FILE_SYSTEM_HTML_OUTPUT_CALLER;
	require_once FILE_SYSTEM_FEED_READER_CALLER;
	require_once FILE_SYSTEM_FILE_UPLOADING_CALLER;
	require_once FILE_SYSTEM_DBASE_CALL;
	require_once FILE_SYSTEM_DSFEEDFUNC_INC;
	require_once FILE_SYSTEM_CURL_CALLER;
	require_once FILE_SYSTEM_EBAY_API_INC;

	require_once EBAY_API_FILESYSTEM_CONSTANTS;
	

	$ebay_api_class = new ebay_api_class($dbase_getters, $dbase_setters, $curler);
	$dsfeed_funcs = new dsfeed_funcs($dbase_getters, $dbase_setters, $curler);


	$display = $html_output->headermain("Google Shopping - Felix Management Tools");

	echo $display;
	flush();
	ob_flush();

	//show processing_data
	if (isset($_POST['uploadfile']) || isset($_POST['dlfile'])){
		echo "<div class='show_running'>";
		flush();
		ob_flush();
		echo "Running... Please wait...";
		flush();
		ob_flush();
	}
	

		$display = "<div class='wrappermain'>";
			
			if (!isset($_GET['import'])){
				$display .= "<h1>Google Shopping - Main Menu</h1>";
			}
			else{
				//GSHOP Item import
				if ($_GET['import'] == 1){
					$display .= "<h1>Google Shopping - Import Google Shopping Items</h1>";				

				}

				//GSHOP Category Import
				if ($_GET['import'] == 2){
					$display .= "<h1>Google Shopping - Import Categories</h1>";				

				}		

				//GSHOP Generate Files

				if ($_GET['import'] == 10){
					$display .= "<h1>Google Shopping - Generate Merchant Center File</h1>";				

				}		

				if ($_GET['import'] == 11){
					$display .= "<h1>Google Shopping - Show Items in KD but not on GSHOP</h1>";				

				}		


				//files download
				else if ($_GET['import'] == 99){
					$display .= "<h1>Google Shopping - File Download Centre</h1>";				

				}
			
			}



			$display .= "<div class='leftmenu'>";

				

				//create list of entries
				$page[0][0] = "Google Shopping Main Menu";
				$page[0][1] = "gshop.php";

				$display .= $html_output->list_element($page);
				

				$display .= $html_output->linermain();

				$display .= "<h2>Import Data</h2>";


				$pageb[0][0] = "Google Shopping Items File Import";
				$pageb[0][1] = "gshop.php?import=1";
				$pageb[1][0] = "Google Shopping Import Categories";
				$pageb[1][1] = "gshop.php?import=2";



				$display .= $html_output->list_element($pageb,false,1);


				$display .= $html_output->linermain();

	
				


				$display .= "<h2>Generate Files and Data</h2>";


				$pageb[0][0] = "Generate GSHOP Merchant Center File";
				$pageb[0][1] = "gshop.php?import=10";
				$pageb[1][0] = "Show Items Not on Gshop";
				$pageb[1][1] = "gshop.php?import=11";



				$display .= $html_output->list_element($pageb,false,1);


				$display .= $html_output->linermain();




				$pagex[0][0] = "Gshop File Download Centre";
				$pagex[0][1] = "gshop.php?import=99";

				$display .= "<h2>File Downloads</h2>";

				$display .= $html_output->list_element($pagex,false,0);


			$display .= "</div>";

			
			

			if (!isset($_GET['import'])){
				//HOME PAGE
				
				$newsarray = array();
				$newsarray[0]['date'] = "<span style='color:red;'>**IMPORTANT**</span>";
				$newsarray[0]['news'] = "Make sure to import KD and Froogle files before managing Google Shopping. If these are not updated beforehand, stock levels will be incorrect.";


				$display .= "<div class='rightmenu'>";

					$display .= $html_output->newsmain($newsarray, "Useful Information");

				$display .= "</div>";
			}
			
			//show imports
			else{
				$display .= "<div class='rightmenu'>";






///////////////////////GSHOP FEED import -----------------------------------------------------------------------------------------
				if ($_GET['import'] == 1){
					
					//settings for file upload
					if (isset($_POST['uploadfile'])){

						$error_shower = $dsfeed_funcs->file_import_processing(basename($_FILES['uploadfilename']['name']), $_FILES['uploadfilename']['tmp_name']);
						
						if ($error_shower[0]){


							$display .= $error_shower[1];
							
						}
						
						//file is okay
						else{
							
							//get the contents of the file and set into a variable
							$tmpfile_data = $error_shower[1];
							

							//upload received for 
							if ($_POST['uploadfile'] == 1){

								echo "Checking file for compatability. . .  ";
								flush();
								ob_flush();
								$upload_error = $dsfeed_funcs->importcheck($gshoppricehead, $feed_reader, $tmpfile_data, TABDELIM);

								if (!$upload_error[0]){
									$lines_and_bits = $upload_error[2];
									$feed_header_check = $upload_error[3];
								


									echo "Entering data into system. . . ";
									flush();
									ob_flush();




									$count = 0;
									$totalcount = sizeof($lines_and_bits) - 2;
									
									//start entering data
									for ($i=2; $i < sizeof($lines_and_bits)  ;$i++){
										if ($i % 10 == 0){
											echo ". ";
											flush();
											ob_flush();
										}

										$count++;

										$sku = trim($lines_and_bits[$i][$feed_header_check['id']]);
										$gshopcat = trim($lines_and_bits[$i][$feed_header_check['google_product_category']]);
										$gshopship = trim($lines_and_bits[$i][$feed_header_check['shipping']]);

										

										//check if sku exists in kd. If not exists, skip line and go to next
										$sku_get_col[0] = ITEM_SS_SKU;
										$sku_exists = $dbase_getters->get_ss_line($sku, $sku_get_col);

										//check sku exists on the gshop database
										$select_cols_g[0] = GS_TBLE_ID;
										$where_cols_g[0][0] = GS_TBLE_SKU;
										$where_cols_g[0][1] = $sku;

										$sku_on_gshop_final = $dbase_getters->basic_get(GS_TBLE_GSHOP_FEED, $select_cols_g, $where_cols_g, false, false);

										//check category exists
										$select_cols_ct[0] = GS_CATS_ID;
										$where_cols_ct[0][0] = GS_CATS_NAME;
										$where_cols_ct[0][1] = $gshopcat;

										$cat_on_gshop_final = $dbase_getters->basic_get(GS_CATS_TBL, $select_cols_ct, $where_cols_ct, false, false);


										if (sizeof($sku_exists[ITEM_SS_SKU]) > 0){
											//if sku exists already on gshop feed file

											if (sizeof($sku_on_gshop_final[GS_TBLE_ID]) > 0){

												$runupdate = true;
												//update if the sku already exists on the database
												if (is_numeric($gshopship)){
													$updatecols[0][0] = GS_TBLE_SHIP;
													$updatecols[0][1] = $gshopship;
													
													//update the category as well.
													if (sizeof($cat_on_gshop_final[GS_CATS_ID]) > 0){
														$updatecols[1][0] = GS_TBLE_CAT;
														$updatecols[1][1] = $cat_on_gshop_final[GS_CATS_ID][0];
													}
												}
												else{
													//update the category 
													if (sizeof($cat_on_gshop_final[GS_CATS_ID]) > 0){
														$updatecols[0][0] = GS_TBLE_CAT;
														$updatecols[0][1] = $cat_on_gshop_final[GS_CATS_ID][0];

														echo "<p style='color:red;background-color:black;padding:3px;'>Line " . $count .": - " . $sku . " already exists. Category successfully updated. Shipping price in wrong format and not updated.</p>";
													}
													else{
														$runupdate = false;

													}
												}
												

												if ($runupdate){
													
													$whereupdate[0][0] = GS_TBLE_SKU;
													$whereupdate[0][1] = $sku;

													$dbase_setters->update_query(GS_TBLE_GSHOP_FEED, $updatecols, $whereupdate);

												}
												else{
													echo "<p style='color:red;background-color:black;padding:3px;'>Line " . $count .": - " . $sku . " already exists. Not updated because shipping price format is incorrect and category does not exist.</p>";
												}

											}//end if exists on gshop feed

											else{

												//insert
												if (is_numeric($gshopship)){

													if (sizeof($cat_on_gshop_final[GS_CATS_ID]) > 0){
														//insert
														$insert_cols[0][0] = GS_TBLE_SKU;
														$insert_cols[0][1] = $sku;
														$insert_cols[1][0] = GS_TBLE_CAT;
														$insert_cols[1][1] = $cat_on_gshop_final[GS_CATS_ID][0];
														$insert_cols[2][0] = GS_TBLE_SHIP;
														$insert_cols[2][1] = $gshopship;

														$dbase_setters->insert_query(GS_TBLE_GSHOP_FEED, $insert_cols);

													}
													
													//do not add
													else{
														echo "<p style='color:red;background-color:black;padding:3px;'>Line " . $count .": - " . $sku . " not added because category does not exist.</p>";
													}

												}
												
												
												else{


													echo "<p style='color:red;background-color:black;padding:3px;'>Line " . $count .": - " . $sku . " not added because shipping price format is incorrect and category does not exist.</p>";


												}

											}

											
										}//end if sku existson kd

										//do not update or add if sku is not on kd dbase
										else{

											if (sizeof($sku_on_gshop_final[GS_TBLE_ID]) > 0){

												$runupdate = true;
												//update if the sku already exists on the database
												if (is_numeric($gshopship)){
													$updatecols[0][0] = GS_TBLE_SHIP;
													$updatecols[0][1] = $gshopship;
													
													//update the category as well.
													if (sizeof($cat_on_gshop_final[GS_CATS_ID]) > 0){
														$updatecols[1][0] = GS_TBLE_CAT;
														$updatecols[1][1] = $cat_on_gshop_final[GS_CATS_ID][0];
													}
												}
												else{
													//update the category 
													if (sizeof($cat_on_gshop_final[GS_CATS_ID]) > 0){
														$updatecols[0][0] = GS_TBLE_CAT;
														$updatecols[0][1] = $cat_on_gshop_final[GS_CATS_ID][0];

														echo "<p style='color:red;background-color:black;padding:3px;'>Line " . $count .": - " . $sku . " already exists. Category successfully updated. Shipping price in wrong format and not updated.</p>";
													}
													else{
														$runupdate = false;

													}
												}
												

												if ($runupdate){
													
													$whereupdate[0][0] = GS_TBLE_SKU;
													$whereupdate[0][1] = $sku;

													$dbase_setters->update_query(GS_TBLE_GSHOP_FEED, $updatecols, $whereupdate);

												}
												else{
													echo "<p style='color:red;background-color:black;padding:3px;'>Line " . $count .": - " . $sku . " already exists. Not updated because shipping price format is incorrect and category does not exist.</p>";
												}

											}//end if exists on gshop feed

											else {
												echo "<p style='color:red;background-color:black;padding:3px;'>Line " . $count .": - " . $sku . " not added because it does not exist on KD Files.</p>";
											
											}
											//echo "<br>" . $sku . " does not exist in Kerp Download imports item database.";
										}

									}


									$display .= "<div class='alertok'>";
									$display .= $upload_error[1] . "... " . $count . " of ". $totalcount . " skus processed.";
									$display .= "</div>";

								}



								else if ($upload_error[0]){
									$display .= "<div class='alerterror'>";
										$display .= $upload_error[1];
									$display .= "</div>";
								}

							}

							
						}
					}

					$display .= "<div class='newshow'>";
						$display .= "<h2>Browse for Google Shopping Data File to upload.</h2>";
						$display .= "<p>File is tab delimited. 3 columns. Header Names are:</p>";

						$display .= "<ol><li>id</li><li>google_product_category</li><li>shipping</li></ol>";

						$display .= "<p>Example format of the data is:</p>";

						$display .= "<ol><li>LB5012GE</li><li>Home & Garden > Linens & Bedding > Bedding > Blankets > Throw Blankets</li><li>9.95</li></ol>";

						$form_elements = $html_output->file_uploader("uploadfilename", MAX_FILE_UPLOAD_SIZE);
						$form_elements .= $html_output->hidden_element("uploadfile", 1);
						$form_elements .= "<p>" .$html_output->create_submit("Import File") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(1, "gshop.php?import=1", $form_elements) . "</fieldset>";

					$display .= "</div>";

				}//END GSHOP ITEMS IMPORT
///////////////////////END GSHOP FEED import -----------------------------------------------------------------------------------------

				
				//IMPORT GSHOP CATEGORIES
				if ($_GET['import'] == 2){
					
					//settings for file upload
					if (isset($_POST['uploadfile'])){

						$error_shower = $dsfeed_funcs->file_import_processing(basename($_FILES['uploadfilename']['name']), $_FILES['uploadfilename']['tmp_name']);
						
						if ($error_shower[0]){


							$display .= $error_shower[1];
							
						}
						
						//file is okay
						else{
							
							//get the contents of the file and set into a variable
							$tmpfile_data = $error_shower[1];
							

							//upload received for 
							if ($_POST['uploadfile'] == 1){

								echo "Checking file for compatability. . .  ";
								flush();
								ob_flush();
								$upload_error = $dsfeed_funcs->importcheck($gshopcatshead, $feed_reader, $tmpfile_data, TABDELIM);

								if (!$upload_error[0]){
									$lines_and_bits = $upload_error[2];
									$feed_header_check = $upload_error[3];
								


									echo "Entering data into system. . . ";
									flush();
									ob_flush();




									$count = 0;
									$oldcount = 0;
									$nullcount = 0;
									$totalcount = sizeof($lines_and_bits) - 2;
									
									//start entering data
									for ($i=2; $i < sizeof($lines_and_bits)  ;$i++){
										if ($i % 10 == 0){
											echo ". ";
											flush();
											ob_flush();
										}

										
										$gshopcat = trim($lines_and_bits[$i][$feed_header_check['cat']]);

										//check if cat exists in table. If not exists then insert. Ignore if exists
										$catcols[0] = GS_CATS_ID;

										$catwhere[0][0] = GS_CATS_NAME;
										$catwhere[0][1] = $gshopcat;

										$catfinal = $dbase_getters->basic_get(GS_CATS_TBL, $catcols, $catwhere, "", "");

										if ($gshopcat != ""){
											if (sizeof($catfinal[GS_CATS_ID]) > 0){
												//ignore
												$oldcount++;
											
											}
											else{
												//enter into the table
												$insertcols[0][0] = GS_CATS_NAME;
												$insertcols[0][1] = $gshopcat;

												$dbase_setters->insert_query(GS_CATS_TBL, $insertcols);

												$count++;
											}
										}
										else{
											$nullcount++;
										}
									

										

									}


									$display .= "<div class='alertok'>";
									$display .= "<p>" . $upload_error[1] . "... </p><p>" . $totalcount . " entries were in your file.</p><p>" . $count . " new categories were added to the database.</p><p>" . $oldcount . " categories aleady existed, and were ignored. </p><p>" . $nullcount . " entry consisted of an empty line.";
									$display .= "</div>";

								}



								else if ($upload_error[0]){
									$display .= "<div class='alerterror'>";
										$display .= $upload_error[1];
									$display .= "</div>";
								}

							}

							
						}
					}

					$display .= "<div class='newshow'>";
						$display .= "<h2>Browse for Google Shopping Categories File to upload.</h2>";
						$display .= "<p>File is only 1 column. Header Name:</p>";

						$display .= "<ul><li>cat</li></ul>";

						$display .= "<p>Example format of the data is:</p>";

						$display .= "<ul><li>Home & Garden > Linens & Bedding > Bedding > Blankets > Throw Blankets</li></ul>";

						$form_elements = $html_output->file_uploader("uploadfilename", MAX_FILE_UPLOAD_SIZE);
						$form_elements .= $html_output->hidden_element("uploadfile", 1);
						$form_elements .= "<p>" .$html_output->create_submit("Import File") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(1, "gshop.php?import=2", $form_elements) . "</fieldset>";

					$display .= "</div>";

				}//END GSHOP CATS IMPORT



				// GENERATE MAIN GSHOP FEED
				if ($_GET['import'] == 10){
					
					if (isset($_POST['uploadfile'])){

						//update time
						$cols[0][0] = GS_MAIN_FEED_UPD;
						$cols[0][1] = time();
						$dbase_setters->update_query(EB_UPD_TRACKING, $cols);


						//prep the file ------------------------------------------
						//header 
						$gshopheader = "id	title	description	google_product_category	product_type	link	image_link	condition	availability	price	shipping	brand	mpn" . NLMAIN;
						$fh = fopen(GSHOP_MAIN_FEED, 'w');
						fwrite($fh, $gshopheader);
						fclose($fh);
					
						//get all onmarket non aag SKUS from items table
						

						$itemfinal = $dbase_getters->getonmarketnonpostockitemsoverone();
						
						$count = 0;
						$errorcount = 0;
						//loop through and find details on gshop, froogle cats, and froogle main
						echo "Finding onmarket skus and items with stock over " . GSHOPMINSTOCK . " units on gshop feed...";
						flush();
						ob_flush();
						for ($i=0; $i < sizeof($itemfinal[ITEM_SS_SKU])  ;$i++){

							if ($i % 10 == 0){
								echo ". ";
								flush();
								ob_flush();
							}

							$sku = $itemfinal[ITEM_SS_SKU][$i];
							$title = $itemfinal[ITEM_WEBTITLE][$i];
							$description = $itemfinal[ITEM_SHORT_DES][$i];
							$url = $itemfinal[ITEM_MOD_URL][$i];
							$disprice = $itemfinal[ITEM_DISPRICE][$i];


							$continue = true;
							$error = "";

							
							//find item cat on froogle	
							$gcol[0] = SS_FROOGLE_CAT;
							$gwhere[0][0] = SS_FROOGLE_SKU;
							$gwhere[0][1] = $sku;

							$gfinal = $dbase_getters->basic_get(SS_FROOGLE_TBL, $gcol, $gwhere, false, false);

							if (sizeof($gfinal[SS_FROOGLE_CAT]) < 1){
								$continue = false;
								$error .= "No Froogle Category Exists for item... ";
							}
							

							//now get item category name from previous result
							$catfcol[0] = SS_CATS_NAME;
							$catfwhere[0][0] = SS_CATS_ID;
							$catfwhere[0][1] = $gfinal[SS_FROOGLE_CAT][0];

							$catffinal = $dbase_getters->basic_get(SS_CATS_TBL, $catfcol, $catfwhere, false, false);
							$catname = $catffinal[SS_CATS_NAME][0];


							if (sizeof($catffinal[SS_CATS_NAME]) < 1){
								$continue = false;
								$error .= "No SS Category Exists for item... ";
							}





							//get google products details
							$googcol[0] = GS_TBLE_CAT;
							$googcol[1] = GS_TBLE_SHIP;
							$googwhere[0][0] = GS_TBLE_SKU;
							$googwhere[0][1] = $sku;

							$googfinal = $dbase_getters->basic_get(GS_TBLE_GSHOP_FEED, $googcol, $googwhere, false, false);

							$shippingprice = $googfinal[GS_TBLE_SHIP][0];
							$googcatid = $googfinal[GS_TBLE_CAT][0];


							if (sizeof($googfinal[GS_TBLE_CAT]) < 1){
								$continue = false;
								$error .= "No GSHOP entry in database for this item... ";
							}




							//get google category name
							$googcatcol[0] = GS_CATS_NAME;
							$googcatwhere[0][0] = GS_CATS_ID;
							$googcatwhere[0][1] = $googcatid;

							$googcatfinal = $dbase_getters->basic_get(GS_CATS_TBL, $googcatcol, $googcatwhere, false, false);

							$googcatname = $googcatfinal[GS_CATS_NAME][0];

							if (sizeof($googcatfinal[GS_CATS_NAME]) < 1){
								$continue = false;
								$error .= "No Google category exists for this item... ";
							}

							if ($continue){
								//now generate data

								$line = $sku;
								$line .= TABDELIM;
								$line .= $title;
								$line .= TABDELIM;
								$line .= $description;
								$line .= TABDELIM;
								$line .= $googcatname;
								$line .= TABDELIM;
								$line .= $catname;
								$line .= TABDELIM;
								$line .= "http://www.soldsmart.com.au/" .  $url;
								$line .= TABDELIM;
								$line .= "http://www.soldsmart.com.au/files/" .  $sku  ."/".  $sku."_gshop_img.jpg";
								$line .= TABDELIM;
								$line .= "new";
								$line .= TABDELIM;
								$line .= "in stock";
								$line .= TABDELIM;
								$line .= $disprice . " AUD";
								$line .= TABDELIM;
								$line .= "AU:::".$shippingprice." AUD";
								$line .= TABDELIM;
								$line .= "Soldsmart";
								$line .= TABDELIM;
								$line .= $sku;
								$line .= NLMAIN;

								//add to the file
								$fh = fopen(GSHOP_MAIN_FEED, 'a');
								$datawrite = $line;
								fwrite($fh, $datawrite);
								fclose($fh);

								$count++;
							}

							else{
								$errorcount++;

								echo "<p style='color:red;background-color:black;padding:3px;'>Line " . $count .": - " . $sku . " " . $error . ". Please make changes and try adding this item later.</p>";

								
							}



						}

						$display .= "<div class='alertok'>";
							$display .= "<p>" . ($count + $errorcount). " items with stock over ".GSHOPMINSTOCK." units were processed for GSHOP Main Feed.</p>";
							$display .= "<p>" . $count . " were successfully added to the feed with no errors.</p>";
							$display .= "<p>" . $errorcount . " items were not added to the feed due to errors.</p>";
							$display .= "<p>Download the file <a href='".GSHOP_MAIN_FEED_HTTP."'>HERE</a></p>";
						$display .= "</div>";


					}


					$display .= "<div class='newshow'>";
						$display .= "<h2>Generate GSHOP FEED</h2>";

						$display .= "<p style='color:red;font-weight:bold;'>** IMPORTANT ** Remember to import KD files BEFORE running otherwise you will receive incorrect data.</p>";	
						
						$display .= "<p>This will generate the Google Shopping Feed with updated stock levels for uploading into Google Merchant Center.</p>";

						$form_elements = $html_output->hidden_element("uploadfile", 1);
						$form_elements .= "<p>" .$html_output->create_submit("Generate GSHOP Feed") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(0, "gshop.php?import=10", $form_elements) . "</fieldset>";

						
					$display .= "</div>";	



				}

				//END GENERATE MAIN GSHOP FEED




				//SHOW ITEMS NOT ON GSHOP
				if ($_GET['import'] == 11){
					
					if (isset($_POST['uploadfile'])){

						//update time
						$cols[0][0] = GS_NOT_ON_FILE_UPD;
						$cols[0][1] = time();
						$dbase_setters->update_query(EB_UPD_TRACKING, $cols);


						//prep the file
						$fh = fopen(GSHOP_NOT_ON, 'w');
						$datawrite = "SKU" . NLMAIN;
						fwrite($fh, $datawrite);
						fclose($fh);
					
						//get all onmarket non aag SKUS from items table
						

						$itemfinal = $dbase_getters->getonmarketnonpostockitems();
						
						$count = 0;
						//loop through and check if on gshop
						echo " Finding skus not on gshop file...";
						flush();
						ob_flush();
						for ($i=0; $i < sizeof($itemfinal[ITEM_SS_SKU])  ;$i++){

							if ($i % 10 == 0){
								echo ". ";
								flush();
								ob_flush();
							}

							$sku = $itemfinal[ITEM_SS_SKU][$i];
								
							$gcol[0] = GS_TBLE_ID;
							$gwhere[0][0] = GS_TBLE_SKU;
							$gwhere[0][1] = $sku;

							$gfinal = $dbase_getters->basic_get(GS_TBLE_GSHOP_FEED, $gcol, $gwhere, false, false);

							if (sizeof($gfinal[GS_TBLE_ID]) > 0){
								//ignore
							}
							else{
								//add to the file
								$fh = fopen(GSHOP_NOT_ON, 'a');
								$datawrite = $sku . NLMAIN;
								fwrite($fh, $datawrite);
								fclose($fh);

								$count++;
							}


						}

						$display .= "<div class='alertok'>";
							$display .= "<p>" . $count . " Onmarket skus were found not on GSHOP.</p>";
							$display .= "<p>Download the file <a href='".GSHOP_NOT_ON_HTTP."'>HERE</a></p>";
						$display .= "</div>";


					}


					$display .= "<div class='newshow'>";
						$display .= "<h2>Show Items Not on GSHOP</h2>";

						$display .= "<p style='color:red;font-weight:bold;'>** IMPORTANT ** Remember to import KD files BEFORE running otherwise you will receive incorrect data.</p>";	
						
						$display .= "<p>This will show all On Market SS & Dropshipper items that are in KD but not on the GSHOP feed. Excludes Postock items.</p>";

						$form_elements = $html_output->hidden_element("uploadfile", 1);
						$form_elements .= "<p>" .$html_output->create_submit("Show Items not on GSHOP") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(0, "gshop.php?import=11", $form_elements) . "</fieldset>";

						
					$display .= "</div>";	



				}

				//END SHOW ITEMS NOT ON GSHOP




				if ($_GET['import'] == 99){

					$display .= "<div class='newshow'>";
						$display .= "<h2>Download eBay Files</h2>";

						$selcols[0] = GS_NOT_ON_FILE_UPD;
						$selcols[1] = GS_MAIN_FEED_UPD;
						

						//need to download last update
						$lastupdate = $dbase_getters->basic_get(EB_UPD_TRACKING, $selcols, false, false, false);



						$pagedr[0][0] = "<b>On Market Items Not on GSHOP</b>  ____ (Last Update ____<i>" . date("d-M-Y____H:i:m", $lastupdate[GS_NOT_ON_FILE_UPD][0]) ."</i>)";
						$pagedr[0][1] = GSHOP_NOT_ON_HTTP;

						$pagedr[1][0] = "<b>GSHOP MAIN FEED</b>  ____ (Last Update ____<i>" . date("d-M-Y____H:i:m", $lastupdate[GS_MAIN_FEED_UPD][0]) ."</i>)";
						$pagedr[1][1] = GSHOP_MAIN_FEED_HTTP;

						$display .= $html_output->list_element($pagedr,false,0);
						
					$display .= "</div>";	



				}


				


				$display .= "</div>";

			}





			

		$display .= "</div>";
	


	$display .="</body></html>";
	

	//for processing display
	if (isset($_POST['uploadfile']) || isset($_POST['dlfile'])){
		echo " <p><strong>FINISHED</strong></p>";
		flush();
		ob_flush();
		echo "</div>";
		flush();
		ob_flush();
	}


	echo $display;
	flush();
	ob_flush();


	ob_end_flush();








?>




