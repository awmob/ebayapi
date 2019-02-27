<?php

	
	set_time_limit(0);
	//error_reporting(0);
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


	$display = $html_output->headermain("eBay Management - Felix Management Tools");

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
				$display .= "<h1>eBay Management - Main Menu</h1>";
			}
			else{
				//listing rep import
				if ($_GET['import'] == 1){
					$display .= "<h1>eBay Management - Listing Report Import</h1>";				

				}

				//listing rep import
				else if ($_GET['import'] == 2){
					$display .= "<h1>eBay Management - Download Active eBay Listings</h1>";				

				}

				//Ship Price Import
				else if ($_GET['import'] == 3){
					$display .= "<h1>eBay Management - Shipping Price Imports</h1>";				

				}


				//replenish ds
				else if ($_GET['import'] == 10){
					$display .= "<h1>eBay Management - Generate Replenish Sold Out Dropship File</h1>";				

				}

				//deplete ds
				else if ($_GET['import'] == 11){
					$display .= "<h1>eBay Management - Generate Deplete Off Mkt Dropship File</h1>";				

				}

				else if ($_GET['import'] == 12){
					$display .= "<h1>eBay Management - Generate List 10 Day SS Items File</h1>";				

				}

				else if ($_GET['import'] == 13){
					$display .= "<h1>eBay Management - Generate Replenish Sold Out SoldSmart Items File</h1>";				

				}

				else if ($_GET['import'] == 14){
					$display .= "<h1>eBay Management - Generate SoldSmart Items Auctions File</h1>";				

				}


				//ss import
				else if ($_GET['import'] == 99){
					$display .= "<h1>eBay Management - File Download Centre</h1>";				

				}
			
			}



			$display .= "<div class='leftmenu'>";

				

				//create list of entries
				$page[0][0] = "Ebay Management Main Menu";
				$page[0][1] = "ebay.php";

				$display .= $html_output->list_element($page);
				

				$display .= $html_output->linermain();

				$display .= "<h2>Import Data</h2>";


				$pageb[0][0] = "Listing Report Import";
				$pageb[0][1] = "ebay.php?import=1";
				$pageb[1][0] = "Download Active Listings on Ebay";
				$pageb[1][1] = "ebay.php?import=2";
				$pageb[2][0] = "Import eBay Shipping Prices";
				$pageb[2][1] = "ebay.php?import=3";

				$display .= $html_output->list_element($pageb,false,1);


				$display .= $html_output->linermain();

				$display .= "<h2>Manage Listings</h2>";


				$pagec[0][0] = "Generate Replenish Sold Out DS File";
				$pagec[0][1] = "ebay.php?import=10";

				$pagec[1][0] = "Generate Deplete Off Market DS File";
				$pagec[1][1] = "ebay.php?import=11";


				$pagec[2][0] = "Generate Replenish Sold Out SoldSmart Stock File";
				$pagec[2][1] = "ebay.php?import=13";

				$pagec[3][0] = "Generate List 10 Day SS Items File";
				$pagec[3][1] = "ebay.php?import=12";

				$pagec[4][0] = "Generate SoldSmart Items Auction File";
				$pagec[4][1] = "ebay.php?import=14";


				$display .= $html_output->list_element($pagec,false,1);




				$display .= $html_output->linermain();

				$pagex[0][0] = "eBay File Download Centre";
				$pagex[0][1] = "ebay.php?import=99";

				$display .= "<h2>File Downloads</h2>";

				$display .= $html_output->list_element($pagex,false,0);


			$display .= "</div>";

			
			

			if (!isset($_GET['import'])){
				//HOME PAGE
				
				$newsarray = array();
				$newsarray[0]['date'] = "Process Order";
				$newsarray[0]['news'] = "<ul><li>Files should be imported following the same numerical order of the menu to the left.</li></ul>";


				$display .= "<div class='rightmenu'>";

					$display .= $html_output->newsmain($newsarray, "Useful Information");

				$display .= "</div>";
			}
			
			//show imports
			else{
				$display .= "<div class='rightmenu'>";






///////////////////////LISTING REPORT import
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
								$upload_error = $dsfeed_funcs->importcheck($ebaylistrephead, $feed_reader, $tmpfile_data, TABDELIM);

								if (!$upload_error[0]){
									$lines_and_bits = $upload_error[2];
									$feed_header_check = $upload_error[3];
								


									echo "Entering data into system. . . ";
									flush();
									ob_flush();




									//upload data to system. First clear listrep.
									$dbase_setters->clear_table(EBAY_LISTING_REPORT_TABLE);

									echo "Clearing previous data. . . ";
									flush();
									ob_flush();

									$count = 0;
									$totalcount = sizeof($lines_and_bits) - 1;
									
									//start entering data
									for ($i=2; $i < sizeof($lines_and_bits)  ;$i++){
										if ($i % 10 == 0){
											echo ". ";
											flush();
											ob_flush();
										}

										$sku = trim($lines_and_bits[$i][$feed_header_check['SKU']]);
										$avail = trim($lines_and_bits[$i][$feed_header_check['Avail']]);

										//check if sku exists in kd. If not exists, skip line and go to next
										$sku_get_col[0] = ITEM_SS_SKU;
										$sku_exists = $dbase_getters->get_ss_line($sku, $sku_get_col);

										if (sizeof($sku_exists) > 0){
											$count++;
											//now set col and insert into db
											$cols = array();

											$cols[0][0] = EBAY_LIST_REP_SKU;
											$cols[1][0] = EBAY_LIST_REP_AVAIL;
											
											$cols[0][1] = $sku;
											$cols[1][1] = $avail;

											$dbase_setters->insert_query(EBAY_LISTING_REPORT_TABLE, $cols);
										}

									}


									$display .= "<div class='alertok'>";
									$display .= $upload_error[1] . "... " . $count . " of ". $totalcount . " skus entered.";
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
						$display .= "<h2>Browse for Listing Report File to upload.</h2>";
						$display .= "<p>Obtain eBay listing report from kerp marketplaces:-ebay. Copy and paste into text editor with headers. Save as tab delimited.</p>";

						$form_elements = $html_output->file_uploader("uploadfilename", MAX_FILE_UPLOAD_SIZE);
						$form_elements .= $html_output->hidden_element("uploadfile", 1);
						$form_elements .= "<p>" .$html_output->create_submit("Import File") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(1, "ebay.php?import=1", $form_elements) . "</fieldset>";

					$display .= "</div>";

				}//END DROPSHIPPER IMPORT


///////////////////////////////////import Active listings from ebay
				if ($_GET['import'] == 2){

					






					if (isset($_POST['uploadfile'])){

						require_once "getlistings.php";



						$display .= "<div class='alertok'>";
							$display .= "<p>Active listings successfully downloaded.</p><p>You may download the active listings file <a href='".ACTIVE_OUTPUT_HTTP."'>HERE</a></p>";
						$display .= "</div>";

						//update time
						$cols[0][0] = EB_UPD_ACT_LIST;
						$cols[0][1] = time();
						$dbase_setters->update_query(EB_UPD_TRACKING, $cols);

					}




					$display .= "<div class='newshow'>";
						$display .= "<h2>Download Active Listings.</h2>";
						$display .= "<p>All current active listings will be downloaded from eBay and entered into the database and saved to a file.</p>";

						$form_elements = $html_output->hidden_element("uploadfile", 1);
						$form_elements .= "<p>" .$html_output->create_submit("Download Active Listings") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(0, "ebay.php?import=2", $form_elements) . "</fieldset>";

					$display .= "</div>";				

				}





///////////////////////////////////import Active listings from ebay
				if ($_GET['import'] == 3){

					






					if (isset($_POST['uploadfile'])){

						require_once "import_eb_ship_prices.php";

					}




					$display .= "<div class='newshow'>";
						$display .= "<h2>Import Shipping Prices.</h2>";
						$display .= "<p>Import shipping prices for 10 day non-free ship listings.</p>";
						$display .= "<p>Tab Delimited. Header 1: <b>SKU</b>. Header 2: <b>Shipprice</b>.</p>";

						$form_elements = $html_output->file_uploader("uploadfilename", MAX_FILE_UPLOAD_SIZE);
						$form_elements .= $html_output->hidden_element("uploadfile", 1);
						$form_elements .= "<p>" .$html_output->create_submit("Update Shipping Prices") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(1, "ebay.php?import=3", $form_elements) . "</fieldset>";

					$display .= "</div>";				

				}





				if ($_GET['import'] == 10){

					if (isset($_POST['uploadfile'])){
						

						//depleting stock information
						require_once "dsebayreplenish.php";

						

						$display .= "<div class='alertok'>";
							$display .= "<p>Dropshipper stock replenishment file created.</p><p>You may download the dropshipper stock replenishment file <a href='".REPLENISH_EB_DS_HTTP."'>HERE</a></p>";
						$display .= "</div>";

						//update time
						$cols[0][0] = EB_DROPSHIP_REPLENISH_LIST;
						$cols[0][1] = time();
						$dbase_setters->update_query(EB_UPD_TRACKING, $cols);
		

					}


					$display .= "<div class='newshow'>";
						$display .= "<h2>Replenish Sold Out Dropshipper Listings</h2>";

						$display .= "<p style='color:red;font-weight:bold;'>** IMPORTANT ** Remember to import KD files and download active ebay listings BEFORE attempting to replenish sold out DS listings. Replenishing sold out DS listings before importing latest KD files and downloading latest active ebay listings will result in incorrect stock replenishment levels.</p>";	
						
						$form_elements = $html_output->hidden_element("uploadfile", 1);
						$form_elements .= "<p>" .$html_output->create_submit("Replenish Listings") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(0, "ebay.php?import=10", $form_elements) . "</fieldset>";



					$display .= "</div>";	



				}


				if ($_GET['import'] == 11){

					
					if (isset($_POST['uploadfile'])){
						

						//depleting stock information
						require_once "depletelistings.php";

						

						$display .= "<div class='alertok'>";
							$display .= "<p>Dropshipper stock depletion file created.</p><p>You may download the dropshipper stock depletion file <a href='".DEPLETE_EB_DS_HTTP."'>HERE</a></p>";
						$display .= "</div>";

						//update time
						$cols[0][0] = EB_DROPSHIP_DEPLETE_LIST;
						$cols[0][1] = time();
						$dbase_setters->update_query(EB_UPD_TRACKING, $cols);
						

					}



					$display .= "<div class='newshow'>";
						$display .= "<h2>Deplete Off Market Dropshipper Listings</h2>";

						$display .= "<p style='color:red;font-weight:bold;'>** IMPORTANT ** Remember to import KD files and download active ebay listings BEFORE attempting to deplete off market DS listings. Depleting off market DS listings before importing latest KD files and downloading latest active ebay listings will result in incorrect data.</p>";						
						$form_elements = $html_output->hidden_element("uploadfile", 1);
						$form_elements .= "<p>" .$html_output->create_submit("Deplete Listings") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(0, "ebay.php?import=11", $form_elements) . "</fieldset>";

						
					$display .= "</div>";	



				}



//Replenish SS Listings
				if ($_GET['import'] == 13){

					
					if (isset($_POST['uploadfile'])){
						

						require_once "replenishzeross.php";

						

						$display .= "<div class='alertok'>";
							$display .= "<p>SS Listings Replenishment file created.</p><p>You may download the file <a href='".EB_SS_REPLENISHFILE_HTTP."'>HERE</a></p>";
						$display .= "</div>";

						//update time
						$cols[0][0] = EB_SS_REPLENISH;
						$cols[0][1] = time();
						$dbase_setters->update_query(EB_UPD_TRACKING, $cols);
						

					}



					$display .= "<div class='newshow'>";
						$display .= "<h2>Replenish Depleted SS Items</h2>";

						$display .= "<p style='color:red;font-weight:bold;'>** IMPORTANT ** Remember to import KD files and download active ebay listings BEFORE attempting to replenish SS items. Generating this file before importing latest KD files and downloading latest active ebay listings will result in incorrect data.</p>";
						
						

						$form_elements = $html_output->hidden_element("uploadfile", 1);
						$form_elements .= "<p>" .$html_output->create_submit("Generate SS Listings Replenishment file") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(0, "ebay.php?import=13", $form_elements) . "</fieldset>";

						
					$display .= "</div>";	



				}







//ADD SS ACUTIONS
				if ($_GET['import'] == 14){

					
					if (isset($_POST['uploadfile'])){
						

						require_once "ebaddauction.php";

						

						$display .= "<div class='alertok'>";
							$display .= "<p>SS Auctions file created.</p><p>You may download the file <a href='".EB_AUCTION_ADDFILE_HTTP."'>HERE</a></p>";
						$display .= "</div>";

						//update time
						$cols[0][0] = EB_SS_AUCTION_ADD;
						$cols[0][1] = time();
						$dbase_setters->update_query(EB_UPD_TRACKING, $cols);
						

					}



					$display .= "<div class='newshow'>";
						$display .= "<h2>Add New SoldSmart Item Auctions to eBay</h2>";

						$display .= "<p style='color:red;font-weight:bold;'>** IMPORTANT ** Remember to import KD files and download active ebay listings BEFORE attempting to add SS Auction items. Generating this file before importing latest KD files and downloading latest active ebay listings will result in incorrect data.</p>";
						
						$display .= "<ol><li>Upload files to ebay using Master file and upload using wamp. In Master file remember to modify listing length and listing TYPE to auction.</li><li>Remember to upload new listings to kerp using kerp api.</li></ol>";


						$form_elements = $html_output->hidden_element("uploadfile", 1);
						$form_elements .= "<p>" .$html_output->create_submit("Generate SS Auctions file") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(0, "ebay.php?import=14", $form_elements) . "</fieldset>";

						
					$display .= "</div>";	



				}





//do ten day listings
				if ($_GET['import'] == 12){

					
					if (isset($_POST['uploadfile'])){
						

						require_once "tendaylist.php";

						

						$display .= "<div class='alertok'>";
							$display .= "<p>10 Day SS listings created.</p><p>You may download the file <a href='".EB_TEN_DAY_LIST_HTTP."'>HERE</a></p>";
						$display .= "</div>";

						//update time
						$cols[0][0] = EB_SS_TENDAY_LIST;
						$cols[0][1] = time();
						$dbase_setters->update_query(EB_UPD_TRACKING, $cols);
						

					}



					$display .= "<div class='newshow'>";
						$display .= "<h2>List 10 Day SS Items</h2>";

						$display .= "<p style='color:red;font-weight:bold;'>** IMPORTANT ** Remember to import KD files and download active ebay listings BEFORE attempting to list 10 day SS items. Generating this file before importing latest KD files and downloading latest active ebay listings will result in incorrect data.</p>";						
						$form_elements = $html_output->hidden_element("uploadfile", 1);
						$form_elements .= "<p>" .$html_output->create_submit("Generate 10 Day Listings") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(0, "ebay.php?import=12", $form_elements) . "</fieldset>";

						
					$display .= "</div>";	



				}



				if ($_GET['import'] == 99){

					$display .= "<div class='newshow'>";
						$display .= "<h2>Download eBay Files</h2>";

						$selcols[0] = EB_UPD_LIST_REP;
						$selcols[1] = EB_UPD_ACT_LIST;
						$selcols[2] = EB_DROPSHIP_DEPLETE_LIST;
						$selcols[3] = EB_DROPSHIP_REPLENISH_LIST;
						$selcols[4] = EB_SS_TENDAY_LIST;
						$selcols[5] = EB_SS_REPLENISH;
						$selcols[6] = EB_SS_AUCTION_ADD;

						//need to download last update
						$lastupdate = $dbase_getters->basic_get(EB_UPD_TRACKING, $selcols, false, false, false);



						$pagedr[0][0] = "<b>Active Listings</b>  ____ (Last Update ____<i>" . date("d-M-Y____H:i:m", $lastupdate[EB_UPD_ACT_LIST][0]) ."</i>)";
						$pagedr[0][1] = ACTIVE_OUTPUT_HTTP;

						$pagedr[1][0] = "<b>Dropshipper Depletion File</b>  ____ (Last Update ____<i>" . date("d-M-Y____H:i:m", $lastupdate[EB_DROPSHIP_DEPLETE_LIST][0]) ."</i>)";
						$pagedr[1][1] = DEPLETE_EB_DS_HTTP;	
						

						$pagedr[2][0] = "<b>Dropshipper Replenishment File</b>  ____ (Last Update ____<i>" . date("d-M-Y____H:i:m", $lastupdate[EB_DROPSHIP_REPLENISH_LIST][0]) ."</i>)";
						$pagedr[2][1] = REPLENISH_EB_DS_HTTP;


						$pagedr[3][0] = "<b>eBay SS 10 Day Listings</b>  ____ (Last Update ____<i>" . date("d-M-Y____H:i:m", $lastupdate[EB_SS_TENDAY_LIST][0]) ."</i>)";
						$pagedr[3][1] = EB_TEN_DAY_LIST_HTTP;	


						
						$pagedr[4][0] = "<b>eBay SS Replenish Empty Listings</b>  ____ (Last Update ____<i>" . date("d-M-Y____H:i:m", $lastupdate[EB_SS_REPLENISH][0]) ."</i>)";
						$pagedr[4][1] = EB_SS_REPLENISHFILE_HTTP;

						$pagedr[5][0] = "<b>eBay SS Auctions to Add</b>  ____ (Last Update ____<i>" . date("d-M-Y____H:i:m", $lastupdate[EB_SS_AUCTION_ADD][0]) ."</i>)";
						$pagedr[5][1] = EB_AUCTION_ADDFILE_HTTP;	






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




