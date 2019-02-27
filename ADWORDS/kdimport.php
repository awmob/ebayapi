

<?php
	
	
	set_time_limit(0);
	//error_reporting(0);

	require_once 'config/constants/constants.inc.php';
	require_once FILE_SYSTEM_HTML_OUTPUT_CALLER;
	require_once FILE_SYSTEM_FEED_READER_CALLER;
	require_once FILE_SYSTEM_FILE_UPLOADING_CALLER;
	require_once FILE_SYSTEM_DBASE_CALL;




	$display = $html_output->headermain("KD, DROPSHIPPER FEEDS & FROOGLE IMPORTS - Felix Management Tools");

	echo $display;
	flush();
	ob_flush();

	//show processing_data
	if (isset($_POST['uploadfile']) || isset($_POST['dlfile'])){
		echo "<div class='show_running'>";
		flush();
		ob_flush();
	}
	

		$display = "<div class='wrappermain'>";
			
			if (!isset($_GET['import'])){
				$display .= "<h1>KD, DROPSHIPPER FEEDS & FROOGLE IMPORTS - Main Menu</h1>";
			}
			else{
				//dropshipper import
				if ($_GET['import'] == 1){
					$display .= "<h1>KD, DROPSHIPPER FEEDS & FROOGLE IMPORTS - Dropshipper KD Import</h1>";				

				}

				//ss import
				else if ($_GET['import'] == 2){
					$display .= "<h1>KD, DROPSHIPPER FEEDS & FROOGLE IMPORTS - SoldSmart KD Import</h1>";				

				}
				//froogle import
				else if ($_GET['import'] == 3){
					$display .= "<h1>KD, DROPSHIPPER FEEDS & FROOGLE IMPORTS - Froogle Import</h1>";				

				}
				//Short Des import
				else if ($_GET['import'] == 4){
					$display .= "<h1>KD, DROPSHIPPER FEEDS & FROOGLE IMPORTS - Soldsmart Short Description & Keywords Import</h1>";				

				}

				//Short Des import
				else if ($_GET['import'] == 5){
					$display .= "<h1>KD, DROPSHIPPER FEEDS & FROOGLE IMPORTS - Update Dropshipper Feeds</h1>";				

				}


				//froogle import
				else if ($_GET['import'] == 6){
					$display .= "<h1>KD, DROPSHIPPER FEEDS & FROOGLE IMPORTS - Froogle Category Import</h1>";				

				}




								//Short Des import
				else if ($_GET['import'] == 99){
					$display .= "<h1>KD, DROPSHIPPER FEEDS & FROOGLE IMPORTS - File Download Centre</h1>";				

				}
			}



			$display .= "<div class='leftmenu'>";

				//create list of entries
				$page[0][0] = "KD, Dropshipper Feeds & Froogle Imports Main Menu";
				$page[0][1] = "kdimport.php";

				$display .= $html_output->list_element($page);
				

				$display .= $html_output->linermain();

				$pageb[0][0] = "KD Dropshipper Items Import";
				$pageb[0][1] = "kdimport.php?import=1";
				$pageb[1][0] = "KD SoldSmart Items Import";
				$pageb[1][1] = "kdimport.php?import=2";
				$pageb[2][0] = "SS Short Desc & Keywords Import";
				$pageb[2][1] = "kdimport.php?import=4";
				

				$display .= "<h2>KD File Imports</h2>";

				$display .= $html_output->list_element($pageb,false,1);

				$display .= $html_output->linermain();


				$pageh[0][0] = "Froogle Import";
				$pageh[0][1] = "kdimport.php?import=3";
				$pageh[1][0] = "Froogle Category Import";
				$pageh[1][1] = "kdimport.php?import=6";				


				$display .= "<h2>Froogle File Imports</h2>";

				$display .= $html_output->list_element($pageh,false,1);

				$display .= $html_output->linermain();



				
				$pagez[0][0] = "Update Dropshipper Feed Data";
				$pagez[0][1] = "kdimport.php?import=5";



				$display .= "<h2>Dropshipper File Imports</h2>";

				$display .= $html_output->list_element($pagez,false,1);

				$display .= $html_output->linermain();




				$pagex[0][0] = "KD File Download Centre";
				$pagex[0][1] = "kdimport.php?import=99";

				$display .= "<h2>File Downloads</h2>";

				$display .= $html_output->list_element($pagex,false,0);


			$display .= "</div>";

			
			

			if (!isset($_GET['import'])){
				//HOME PAGE
				
				$newsarray = array();
				$newsarray[0]['date'] = "Order of Processes";
				$newsarray[0]['news'] = "<ul><li style='color:red; font-weight:bold;'>ALWAYS IMPORT INDIVIDUAL DROPSHIPPER FEEDS AFTER KD IMPORTS. KD IMPORTS will set the DS stock levels to 0. These must be replenished by data feed import before you proceed.</li><li style='color:red; font-weight:bold;'>Files should be imported following the same numerical order of the menu to the left.</li></ul>";

				$newsarray[1]['date'] = "General Upload Info";
				$newsarray[1]['news'] = "<ul><li>OnMarket Status of all existing entries will be set to 0 at the beginning of new KD uploads, and will be set to their correct values as the upload progresses. Because of this, you must upload the FULL FILE for all KD imports in order to correctly set the on market status for all items.</li></ul>";

				$newsarray[2]['date'] = "How to Import Dropshipper Kerp Download File (KD0)";
				$newsarray[2]['news'] = "<ul><li>Convert KD File to TAB delimited file by copying all cells in Excel and pasting into Editplus. Do not alter the order of cells.</li><li>Import using upload facility on this page.</li><li>Remember to include the header names.</li></ul>";
				$newsarray[3]['date'] = "How to Import SoldSmart Kerp Download File (KD6)";
				$newsarray[3]['news'] = "<ul><li>Convert KD File to TAB delimited file by copying all cells in Excel and pasting into Editplus. Do not alter the order of cells.</li><li>Import using upload facility on this page.</li><li>Remember to include the header names.</li></ul>";
				$newsarray[4]['date'] = "How to Import Froogle File";
				$newsarray[4]['news'] = "<ul>
				
				<li>Obtain file by:
				
					<ul>
					
						<li>Kerp->Marketplaces->SoldSmart.com.au.</li>
						<li>Click Froogle button at bottom-left had corner.</li>
						<li>Retrieve file from main Kerp page -&#62; File Centre at top-right of page.</li>

					</ul>
				
				</li><li>Import the file directly. There is no need to modify the file prior to importing.</li></ul>";

				$newsarray[5]['date'] = "How to Import SoldSmart Description File (KD5)";
				$newsarray[5]['news'] = "<ul><li>Convert KD Description File to TAB delimited file by copying all cells in Excel and pasting into Editplus. Do not alter the order of cells.</li><li>Import using upload facility on this page.</li><li>Remember to include the header names.</li></ul>";


				$newsarray[6]['date'] = "How to Import Dropshipper Feed Data";
				$newsarray[6]['news'] = "<ul>
				
				<li>Connect to each dropshipper FTP account and download their respective feeds to local drive. Import the dropshipper feeds via Management Tools. Upload the file which Management Tools produces to the SoldSmartUse folder for the respective dropshipper.</li>
				
				<li>When the import is successful, you must visit Kerp-&#62;Dropship and select the Dropshipper's name from the Kerp menu. Then you must click <i>Check Datafeed</i>. Since this is only a test, no data on Kerp will be modified.</li>
				
				<li>When checking is complete and no errors appear on Kerp, you must then click \"Process Datafeed\" in Kerp to process the feed. This will modify the data on Kerp based on the data in your feed.</li>
				</ul>";

				$display .= "<div class='rightmenu'>";

					$display .= $html_output->newsmain($newsarray, "Useful Information");

				$display .= "</div>";
			}
			
			//show imports
			else{
				$display .= "<div class='rightmenu'>";




				//show file management centre
				if ($_GET['import'] == 99){

					$display .= "<div class='newshow'>";

						$display .= "<h2>Dropshipper Rapid Publisher Files</h2>";


						$pagedr[0][0] = "Unitex - OnMarket Status RP File";
						$pagedr[0][1] = DS_RP_UNITEX_FILE_HTTP;
						$pagedr[1][0] = "Newaim - OnMarket Status RP File";
						$pagedr[1][1] = DS_RP_NEWAIM_FILE_HTTP;
						$pagedr[2][0] = "Onescent - OnMarket Status RP File";
						$pagedr[2][1] = DS_RP_ONESCENT_FILE_HTTP;
						$pagedr[3][0] = "Trinity - OnMarket Status RP File";
						$pagedr[3][1] = DS_RP_TRINITY_FILE_HTTP;
						$pagedr[4][0] = "Powerhouse - OnMarket Status RP File";
						$pagedr[4][1] = DS_RP_PWR_FILE_HTTP;
						$pagedr[5][0] = "Simply Wholesale - OnMarket Status RP File";
						$pagedr[5][1] = DS_RP_SIMPLY_FILE_HTTP;
						$pagedr[6][0] = "DR CARL - OnMarket Status RP File";
						$pagedr[6][1] = DS_RP_DRCARL_HTTP;
						$pagedr[7][0] = "MITTONI - OnMarket Status RP File";
						$pagedr[7][1] = DS_RP_MITTONI_HTTP;
						$pagedr[8][0] = "SERRANO - OnMarket Status RP File";
						$pagedr[8][1] = DS_RP_SERRANO_HTTP;


						$display .= $html_output->list_element($pagedr,false,0);

						$display .= $html_output->linermain();

						$display .= "<h2>Dropshipper Items Not on Kerp</h2>";


						$pagedr[0][0] = "Unitex";
						$pagedr[0][1] = DS_RP_UNITEX_MISSING_FILE_HTTP;
						$pagedr[1][0] = "Newaim";
						$pagedr[1][1] = DS_RP_NEWAIM_MISSING_FILE_HTTP;
						$pagedr[2][0] = "Onescent";
						$pagedr[2][1] = DS_RP_ONESCENT_MISSING_FILE_HTTP;
						$pagedr[3][0] = "Trinity";
						$pagedr[3][1] = DS_RP_TRINITY_MISSING_FILE_HTTP;
						$pagedr[4][0] = "Powerhouse";
						$pagedr[4][1] = DS_RP_PWR_MISSING_FILE_HTTP;
						$pagedr[5][0] = "Simply Wholesale";
						$pagedr[5][1] = DS_RP_SIMPLY_MISSING_FILE_HTTP;
						$pagedr[6][0] = "Dr Carl";
						$pagedr[6][1] = DS_RP_DRCARL_MISSING_FILE_HTTP;
						$pagedr[7][0] = "Mittoni";
						$pagedr[7][1] = DS_RP_MITTONI_MISSING_FILE_HTTP;
						$pagedr[8][0] = "Serrano";
						$pagedr[8][1] = DS_RP_SERRANO_MISSING_FILE_HTTP;

						$display .= $html_output->list_element($pagedr,false,0);

					$display .= "</div>";

				}


				//dropshipper import
				if ($_GET['import'] == 1){
					
					//settings for file upload
					if (isset($_POST['uploadfile'])){

						echo "Uploading <b>" . basename($_FILES['uploadfilename']['name']) . "</b>. . .  ";
						flush();
						ob_flush();

						$tmpfile = $_FILES['uploadfilename']['tmp_name'];
						
						if ($tmpfile == ""){

							$mb = MAX_FILE_UPLOAD_SIZE / 1000000;

							$display .= "<div class='alerterror'>Either the size of your file <b>exceeds ".$mb."mb</b>, or you didn't choose a file to upload. Please try again.</div>";
							
						}
						
						//file is okay
						else{
							
							//get the contents of the file and set into a variable
							$tmpfile_data = file_get_contents($tmpfile);
							echo "Uploaded. Extracting file contents. . .  ";
							flush();
							ob_flush();

							//upload received for 1 - dropshipper file
							if ($_POST['uploadfile'] == 1){

								echo "Checking file for compatability. . .  ";
								flush();
								ob_flush();
								$upload_error = kdimpone($dshead, $feed_reader, $tmpfile_data, UPLOAD_TYPE_DROPSHIPPER, TABDELIM, $dbase_getters, $dbase_setters, $db_itemfields);

								if ($upload_error[0]){
									$display .= "<div class='alerterror'>";
										$display .= $upload_error[1];
									$display .= "</div>";
								}

								else{
									$display .= "<div class='alertok'>";
										$display .= $upload_error[1];
									$display .= "</div>";
								}
								
							}

							
						}
					}

					$display .= "<div class='newshow'>";
						$display .= "<h2>Browse for Dropshipper KD File to upload.</h2>";
						$display .= "<p>Ensure the file is in .txt tab delimited format pasted from Excel to Text file. Headers must be included.</p>";

						$form_elements = $html_output->file_uploader("uploadfilename", MAX_FILE_UPLOAD_SIZE);
						$form_elements .= $html_output->hidden_element("uploadfile", 1);
						$form_elements .= "<p>" .$html_output->create_submit("Import File") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(1, "kdimport.php?import=1", $form_elements) . "</fieldset>";

					$display .= "</div>";

				}//END DROPSHIPPER IMPORT





	//SOLDSMART import
				if ($_GET['import'] == 2){
					
					//settings for file upload
					if (isset($_POST['uploadfile'])){

						echo "Uploading <b>" . basename($_FILES['uploadfilename']['name']) . "</b>. . .  ";
						flush();
						ob_flush();

						$tmpfile = $_FILES['uploadfilename']['tmp_name'];
						
						if ($tmpfile == ""){

							$mb = MAX_FILE_UPLOAD_SIZE / 1000000;

							$display .= "<div class='alerterror'>Either the size of your file <b>exceeds ".$mb."mb</b>, or you didn't choose a file to upload. Please try again.</div>";
							
						}
						
						//file is okay
						else{
							
							//get the contents of the file and set into a variable
							$tmpfile_data = file_get_contents($tmpfile);
							
							echo "Uploaded. Extracting file contents. . .  ";
							flush();
							ob_flush();

							//upload received for 1 - dropshipper file
							if ($_POST['uploadfile'] == 1){

								echo "Checking file for compatability. . .  ";
								flush();
								ob_flush();

								$upload_error = kdimpone($sshead, $feed_reader, $tmpfile_data, UPLOAD_TYPE_SS, TABDELIM, $dbase_getters, $dbase_setters, $db_itemfields);


								if ($upload_error[0]){
									$display .= "<div class='alerterror'>";
										$display .= $upload_error[1];
									$display .= "</div>";
								}

								else{
									$display .= "<div class='alertok'>";
										$display .= $upload_error[1];
									$display .= "</div>";
								}
								
							}

							
						}
					}

					$display .= "<div class='newshow'>";
						$display .= "<h2>Browse for SOLDSMART Standard Items KD File to upload.</h2>";
						$display .= "<p>Ensure the file is in .txt tab delimited format pasted from Excel to Text file. Headers must be included.</p>";

						$form_elements = $html_output->file_uploader("uploadfilename", MAX_FILE_UPLOAD_SIZE);
						$form_elements .= $html_output->hidden_element("uploadfile", 1);
						$form_elements .= "<p>" .$html_output->create_submit("Import File") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(1, "kdimport.php?import=2", $form_elements) . "</fieldset>";

					$display .= "</div>";

				}//END SOLDSMART IMPORT






	//FRROGLE import
				if ($_GET['import'] == 3){
					
					//settings for file upload
					if (isset($_POST['uploadfile'])){

						require_once FILE_SYSTEM_DSFEEDFUNC_INC;
						require_once FILE_SYSTEM_CURL_CALLER;
						$dsfeed_funcs = new dsfeed_funcs($dbase_getters, $dbase_setters, $curler);


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
								$upload_error = $dsfeed_funcs->importcheck($frooglemainshead, $feed_reader, $tmpfile_data, PIPDELIM);

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

										$sku = trim($lines_and_bits[$i][$feed_header_check['Goods']]);
										$frg_cat = trim($lines_and_bits[$i][$feed_header_check['category']]);
										$frg_image_url = trim($lines_and_bits[$i][$feed_header_check['image_url']]);

										/*if ($sku ==  "YG5024YB"){
											
											echo "<h1>" . $frg_cat . "</h1><br/>";
										}*/

										echo $sku . " ------ " . $frg_cat . "<br/>";

										
										//check category exists
										$select_cols_ct[0] = SS_CATS_ID;

										$where_cols_ct[0][0] = SS_CATS_NAME;
										$where_cols_ct[0][1] = $frg_cat;

										$cat_on_froog_final = $dbase_getters->basic_get(SS_CATS_TBL, $select_cols_ct, $where_cols_ct, false, false);

										//check sku exists on froogle
										$select_cols_sku[0] = SS_FROOGLE_SKU;

										$where_cols_sku[0][0] = SS_FROOGLE_SKU;
										$where_cols_sku[0][1] = $sku;

										$sku_on_froog_final = $dbase_getters->basic_get(SS_FROOGLE_TBL, $select_cols_sku, $where_cols_sku, false, false);




										//if sku exists then update
										if (sizeof($sku_on_froog_final[SS_FROOGLE_SKU]) > 0 ){

											if (sizeof($cat_on_froog_final[SS_CATS_ID]) > 0){
												
												$skufroogcols[0][0] = SS_FROOGLE_CAT;
												$skufroogcols[0][1] = $cat_on_froog_final[SS_CATS_ID][0];
												$skufroogcols[1][0] = SS_FROOGLE_IMG_URL;
												$skufroogcols[1][1] = $frg_image_url;

												$wherefroog[0][0] = SS_FROOGLE_SKU;
												$wherefroog[0][1] = $sku;


												$dbase_setters->update_query(SS_FROOGLE_TBL, $skufroogcols, $wherefroog);
											}
											//item not added
											else{
												echo "<p style='color:red;background-color:black;padding:3px;'>Line " . $count .": - " . $sku . " not added because category <b>".$frg_cat."</b> does not exist in froogle category table of database. Add the category & try again.</p>";
											}


										}
										//if not then add
										else{

											//only add if cat is valid

											if (sizeof($cat_on_froog_final[SS_CATS_ID]) > 0){
												$skufroogcols[0][0] = SS_FROOGLE_SKU;
												$skufroogcols[0][1] = $sku;
												$skufroogcols[1][0] = SS_FROOGLE_IMG_URL;
												$skufroogcols[1][1] = $frg_image_url;
												$skufroogcols[2][0] = SS_FROOGLE_CAT;
												$skufroogcols[2][1] = $cat_on_froog_final[SS_CATS_ID][0];
												$dbase_setters->insert_query(SS_FROOGLE_TBL,  $skufroogcols);
											}
											//item not added
											else{
												echo "<p style='color:red;background-color:black;padding:3px;'>Line " . $count .": - " . $sku . " not added because category <b>".$frg_cat."</b> does not exist in froogle category table of database. Add the category & try again.</p>";
											}

										}
										//end add new froogle item



										


										

									}// end for


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
						$display .= "<h2>Browse for FROOGLE file to upload.</h2>";
						$display .= "<p>Do not alter the file. Upload the file as it is.</p>";

						$form_elements = $html_output->file_uploader("uploadfilename", MAX_FILE_UPLOAD_SIZE);
						$form_elements .= $html_output->hidden_element("uploadfile", 1);
						$form_elements .= "<p>" .$html_output->create_submit("Import File") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(1, "kdimport.php?import=3", $form_elements) . "</fieldset>";

					$display .= "</div>";

				}//END FROOGLE IMPORT






	//FRROGLE CATEGORY import
				if ($_GET['import'] == 6){
					
					//settings for file upload
					if (isset($_POST['uploadfile'])){

						require_once FILE_SYSTEM_DSFEEDFUNC_INC;
						require_once FILE_SYSTEM_CURL_CALLER;
						$dsfeed_funcs = new dsfeed_funcs($dbase_getters, $dbase_setters, $curler);

						echo "Uploading <b>" . basename($_FILES['uploadfilename']['name']) . "</b>. . .  ";
						flush();
						ob_flush();

						$tmpfile = $_FILES['uploadfilename']['tmp_name'];
						
						if ($tmpfile == ""){

							$mb = MAX_FILE_UPLOAD_SIZE / 1000000;

							$display .= "<div class='alerterror'>Either the size of your file <b>exceeds ".$mb."mb</b>, or you didn't choose a file to upload. Please try again.</div>";
							
						}
						
						//file is okay
						else{
							
							//get the contents of the file and set into a variable
							$tmpfile_data = file_get_contents($tmpfile);

							echo "Uploaded. Extracting file contents. . .  ";
							flush();
							ob_flush();

							//upload received for 1 - dropshipper file
							if ($_POST['uploadfile'] == 1){

								echo "Checking file for compatability. . .  ";
								flush();
								ob_flush();

								$upload_error = $dsfeed_funcs->importcheck($frooglecatshead, $feed_reader, $tmpfile_data, TABDELIM);

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

										
										$froogcat = trim($lines_and_bits[$i][$feed_header_check['cat']]);

										//check if cat exists in table. If not exists then insert. Ignore if exists
										$catcols[0] = SS_CATS_ID;

										$catwhere[0][0] = SS_CATS_NAME;
										$catwhere[0][1] = $froogcat;

										$catfinal = $dbase_getters->basic_get(SS_CATS_TBL, $catcols, $catwhere, "", "");

										if ($froogcat != ""){
											if (sizeof($catfinal[SS_CATS_ID]) > 0){
												//ignore
												$oldcount++;
											
											}
											else{
												//enter into the table
												$insertcols[0][0] = SS_CATS_NAME;
												$insertcols[0][1] = $froogcat;

												$dbase_setters->insert_query(SS_CATS_TBL, $insertcols);

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
						$display .= "<h2>Browse for FROOGLE CATEGORY file to upload.</h2>";
						$display .= "<p>One column only. Header name is: <b>cat</b></p>";
						$display .= "<p>Categories in froogle format ie. <b>Home & Garden > Garden Furniture & Fittings</b></p>";

						$form_elements = $html_output->file_uploader("uploadfilename", MAX_FILE_UPLOAD_SIZE);
						$form_elements .= $html_output->hidden_element("uploadfile", 1);
						$form_elements .= "<p>" .$html_output->create_submit("Import File") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(1, "kdimport.php?import=6", $form_elements) . "</fieldset>";

					$display .= "</div>";

				}//END FROOGLE CATEGORY IMPORT








	//SHORT DESC import
				if ($_GET['import'] == 4){
					
					//settings for file upload
					if (isset($_POST['uploadfile'])){

						require_once FILE_SYSTEM_CURL_CALLER;

						require_once FILE_SYSTEM_DSFEEDFUNC_INC;
						$dsfeed_funcs = new dsfeed_funcs($dbase_getters, $dbase_setters, $curler);

						echo "Uploading <b>" . basename($_FILES['uploadfilename']['name']) . "</b>. . .  ";
						flush();
						ob_flush();

						$tmpfile = $_FILES['uploadfilename']['tmp_name'];
						
						if ($tmpfile == ""){

							$mb = MAX_FILE_UPLOAD_SIZE / 1000000;

							$display .= "<div class='alerterror'>Either the size of your file <b>exceeds ".$mb."mb</b>, or you didn't choose a file to upload. Please try again.</div>";
							
						}
						
						//file is okay
						else{
							
							//get the contents of the file and set into a variable
							$tmpfile_data = file_get_contents($tmpfile);

							echo "Uploaded. Extracting file contents. . .  ";
							flush();
							ob_flush();

							//upload received for 1 - dropshipper file
							if ($_POST['uploadfile'] == 1){

								echo "Checking file for compatability. . .  ";
								flush();
								ob_flush();

								$upload_error = $dsfeed_funcs->importcheck($shortdeshead, $feed_reader, $tmpfile_data, TABDELIM);

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

										$sku = trim($lines_and_bits[$i][$feed_header_check['Goods']]);
										$shortdes = trim($lines_and_bits[$i][$feed_header_check['ShortDesc']]);
										$keywords = trim($lines_and_bits[$i][$feed_header_check['Keywords']]);



										//update with description
										//first check if item exists on items
										$db_itemfields[0] = ITEM_SS_SKU;
										$skufinal = $dbase_getters->get_ss_line($sku, $db_itemfields);


										if (sizeof($skufinal[ITEM_SS_SKU]) > 0){
											//update item if on table
											$upcols[0][0] = ITEM_SHORT_DES;
											$upcols[0][1] = $shortdes;
											$upcols[1][0] = ITEM_KEYWORDS;
											$upcols[1][1] = $keywords;

											$whereupcols[0][0] = ITEM_SS_SKU;
											$whereupcols[0][1] = $sku;

											$dbase_setters->update_query(ITEM_MAIN_TABLE, $upcols,$whereupcols);
										}	


									}

									$display .= "<div class='alertok'>";
										$display .= "Successfully imported " . $count . " descriptions & keywords.";
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
						$display .= "<h2>Browse for SS Items Short Description KD5 file to upload.</h2>";
						$display .= "<p>Copy from Excel. Paste cells into text file. Save as text delimited.</p>";

						$form_elements = $html_output->file_uploader("uploadfilename", MAX_FILE_UPLOAD_SIZE);
						$form_elements .= $html_output->hidden_element("uploadfile", 1);
						$form_elements .= "<p>" .$html_output->create_submit("Import File") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(1, "kdimport.php?import=4", $form_elements) . "</fieldset>";

					$display .= "</div>";

				}//END SHORT DESC IMPORT




				//DROPSHIPPER FEED IMPORT
				if ($_GET['import'] == 5){
					require_once FILE_SYSTEM_CURL_CALLER;

					require_once FILE_SYSTEM_DSFEEDFUNC_INC;
					$dsfeed_funcs = new dsfeed_funcs($dbase_getters, $dbase_setters, $curler);
					
					


//PROCESS FORM INPUT ----------------------------------------------------------------------------------------------
					if (isset($_POST['ds'])){
						$ds = $_POST['ds'];
						
						//get ds name
						$namefinal = $dbase_getters->get_ds_details($ds);
						echo "Processing " . $namefinal[DS_TYPES_TABLE_NAME][0] . " . . . <br/>";

						
						$error_main = false;
						//settings for file upload - not all require file upload
						if (isset($_POST['uploadfile'])){
							
							//if error returns [0] error [1] error msg else [1] is the feed data
							$error_shower = $dsfeed_funcs->file_import_processing(basename($_FILES['uploadfilename']['name']), $_FILES['uploadfilename']['tmp_name']);
							
							if ($error_shower[0]){
								$error_main = true;
								$display .= $error_shower[1];
							}
							else{
								//set simpler variable for the feed data
								$feed_data = $error_shower[1];
								$error_shower[1] = "";
							}
							
						}
	

						if (!$error_main){
							if ($ds == DS_TYPE_UNITEX){
								
								$error = $dsfeed_funcs->process_feeds_gen($unitexhead, $feed_reader, TABDELIM, $db_itemfields, $feed_data, DS_TYPE_UNITEX);

								//stop if error exists
								if($error[0]){
									$display .= "<div class='alerterror'><b>".$error[1]."</b></div>";
								}

								else{
									//create rp feed.
									echo "Writing Rapid Publisher File . . . ";
									flush();
									ob_flush();

									$dsfeed_funcs->create_rp_stockonly_feed($ds, DS_RP_UNITEX_FILE, $rphead);

									//update the last feed update time
									$dsfeed_funcs->dsfeed_time_update($ds);

									$display .= "<div class='alertok'>";
									
									$display .= "<p>" . $error[1]. "</p>";

									$display .= "<p>Download the Rapid Publisher file <a href='".DS_RP_UNITEX_FILE_HTTP."'>HERE</a>. You then need to upload the feed to the Unitex FTP SoldSmartUse folder.</p>";

									$display .= "<p>Download the file of items that aren't on Kerp <a href='".DS_RP_UNITEX_MISSING_FILE_HTTP."'>HERE</a>.</p>";

									$display .= "<p>Alternatively you may download the files from the File Download Centre.</p>";
										
									$display .= "</div>";
								}

							}

							else if ($ds == DS_TYPE_NEWAIM){
								$error = $dsfeed_funcs->process_feeds_gen($newaimhead, $feed_reader, COMMADELIM, $db_itemfields, $feed_data, DS_TYPE_NEWAIM);

								//stop if error exists
								if($error[0]){
									$display .= "<div class='alerterror'><b>".$error[1]."</b></div>";
								}

								else{
									//create rp feed.
									echo "Writing Rapid Publisher File . . . ";
									flush();
									ob_flush();

									$dsfeed_funcs->create_rp_stockonly_feed($ds, DS_RP_NEWAIM_FILE, $rphead);

									//update the last feed update time
									$dsfeed_funcs->dsfeed_time_update($ds);

									$display .= "<div class='alertok'>";
									
									$display .= "<p>" . $error[1]. "</p>";

									$display .= "<p>Download the Rapid Publisher file <a href='".DS_RP_NEWAIM_FILE_HTTP."'>HERE</a>. You then need to upload the feed to the Newaim FTP SoldSmartUse folder.</p>";

									$display .= "<p>Download the file of items that aren't on Kerp <a href='".DS_RP_NEWAIM_MISSING_FILE_HTTP."'>HERE</a>.</p>";

									$display .= "<p>Alternatively you may download the files from the File Download Centre.</p>";
										
									$display .= "</div>";
								}
							}

							else if($ds == DS_TYPE_ONESCENT){
								$error = $dsfeed_funcs->onescent_process($onehead, $feed_reader, COMMADELIM, $db_itemfields);
								
								//stope if error exists
								if($error[0]){
									$display .= "<div class='alerterror'><b>".$error[1]."</b></div>";
								}

								else{
									//create rp feed.
									echo "Writing Rapid Publisher File . . . ";
									flush();
									ob_flush();

									$dsfeed_funcs->create_rp_stockonly_feed($ds, DS_RP_ONESCENT_FILE, $rphead);

									//update the last feed update time
									$dsfeed_funcs->dsfeed_time_update($ds);

									$display .= "<div class='alertok'>";
									
									$display .= "<p>" . $error[1]. "</p>";

									$display .= "<p>Download the Rapid Publisher file <a href='".DS_RP_ONESCENT_FILE_HTTP."'>HERE</a>. You then need to upload the feed to the Onescent FTP SoldSmartUse folder.</p>";

									$display .= "<p>Download the file of items that aren't on Kerp <a href='".DS_RP_ONESCENT_MISSING_FILE_HTTP."'>HERE</a>.</p>";

									$display .= "<p>Alternatively you may download the files from the File Download Centre.</p>";
										
									$display .= "</div>";
								}


							}



							else if ($ds == DS_TYPE_TRINITY){
								$error = $dsfeed_funcs->process_feeds_gen($trinityhead, $feed_reader, TABDELIM, $db_itemfields, $feed_data, DS_TYPE_TRINITY);

								//stop if error exists
								if($error[0]){
									$display .= "<div class='alerterror'><b>".$error[1]."</b></div>";
								}

								else{
									//create rp feed.
									echo "Writing Rapid Publisher File . . . ";
									flush();
									ob_flush();

									$dsfeed_funcs->create_rp_stockonly_feed($ds, DS_RP_TRINITY_FILE, $rphead);

									//update the last feed update time
									$dsfeed_funcs->dsfeed_time_update($ds);

									$display .= "<div class='alertok'>";
									
									$display .= "<p>" . $error[1]. "</p>";

									$display .= "<p>Download the Rapid Publisher file <a href='".DS_RP_TRINITY_FILE_HTTP."'>HERE</a>. You then need to upload the feed to the Newaim FTP SoldSmartUse folder.</p>";

									$display .= "<p>Download the file of items that aren't on Kerp <a href='".DS_RP_TRINITY_MISSING_FILE_HTTP."'>HERE</a>.</p>";

									$display .= "<p>Alternatively you may download the files from the File Download Centre.</p>";
										
									$display .= "</div>";
								}
							}




							else if ($ds == DS_TYPE_POWERHOUSE){
								$error = $dsfeed_funcs->process_feeds_gen($pwrhsehead, $feed_reader, TABDELIM, $db_itemfields, $feed_data, DS_TYPE_POWERHOUSE);

								//stop if error exists
								if($error[0]){
									$display .= "<div class='alerterror'><b>".$error[1]."</b></div>";
								}

								else{
									//create rp feed.
									echo "Writing Rapid Publisher File . . . ";
									flush();
									ob_flush();

									$dsfeed_funcs->create_rp_stockonly_feed($ds, DS_RP_PWR_FILE, $rphead);

									//update the last feed update time
									$dsfeed_funcs->dsfeed_time_update($ds);

									$display .= "<div class='alertok'>";
									
									$display .= "<p>" . $error[1]. "</p>";

									$display .= "<p>Download the Rapid Publisher file <a href='".DS_RP_PWR_FILE_HTTP."'>HERE</a>. You then need to upload the feed to the Newaim FTP SoldSmartUse folder.</p>";

									$display .= "<p>Download the file of items that aren't on Kerp <a href='".DS_RP_PWR_MISSING_FILE_HTTP."'>HERE</a>.</p>";

									$display .= "<p>Alternatively you may download the files from the File Download Centre.</p>";
										
									$display .= "</div>";
								}
							}



							else if($ds == DS_TYPE_SIMPLYWHOLESALE){
								$error = $dsfeed_funcs->simplywholesale_process($simplyhead, $feed_reader, TABDELIM, $db_itemfields);
								
								//stope if error exists
								if($error[0]){
									$display .= "<div class='alerterror'><b>".$error[1]."</b></div>";
								}

								else{
									//create rp feed.
									echo "Writing Rapid Publisher File . . . ";
									flush();
									ob_flush();

									$dsfeed_funcs->create_rp_stockonly_feed($ds, DS_RP_SIMPLY_FILE, $rphead);

									//update the last feed update time
									$dsfeed_funcs->dsfeed_time_update($ds);

									$display .= "<div class='alertok'>";
									
									$display .= "<p>" . $error[1]. "</p>";

									$display .= "<p>Download the Rapid Publisher file <a href='".DS_RP_SIMPLY_FILE_HTTP."'>HERE</a>. You then need to upload the feed to the Simply Wholesale FTP SoldSmartUse folder.</p>";

									$display .= "<p>Download the file of items that aren't on Kerp <a href='".DS_RP_SIMPLY_MISSING_FILE_HTTP."'>HERE</a>.</p>";

									$display .= "<p>Alternatively you may download the files from the File Download Centre.</p>";
										
									$display .= "</div>";
								}


							}


							else if($ds == DS_TYPE_DRCARL){
								$error = $dsfeed_funcs->process_feeds_gen($drcarlhead, $feed_reader, TABDELIM, $db_itemfields, $feed_data, DS_TYPE_DRCARL);

								//stop if error exists
								if($error[0]){
									$display .= "<div class='alerterror'><b>".$error[1]."</b></div>";
								}

								else{
									//create rp feed.
									echo "Writing Rapid Publisher File . . . ";
									flush();
									ob_flush();

									$dsfeed_funcs->create_rp_stockonly_feed($ds, DS_RP_DRCARL_FILE, $rphead);

									//update the last feed update time
									$dsfeed_funcs->dsfeed_time_update($ds);

									$display .= "<div class='alertok'>";
									
									$display .= "<p>" . $error[1]. "</p>";

									$display .= "<p>Download the Rapid Publisher file <a href='".DS_RP_DRCARL_HTTP."'>HERE</a>. You then need to upload the feed to the Dr Carl FTP SoldSmartUse folder.</p>";

									$display .= "<p>Download the file of items that aren't on Kerp <a href='".DS_RP_DRCARL_MISSING_FILE_HTTP."'>HERE</a>.</p>";

									$display .= "<p>Alternatively you may download the files from the File Download Centre.</p>";
										
									$display .= "</div>";
								}

							}


							else if($ds == DS_TYPE_SERRANO){
								$error = $dsfeed_funcs->serrano_process($serranohead, $feed_reader, TABDELIM, $db_itemfields);
								
								//stope if error exists
								if($error[0]){
									$display .= "<div class='alerterror'><b>".$error[1]."</b></div>";
								}

								else{
									//create rp feed.
									echo "Writing Rapid Publisher File . . . ";
									flush();
									ob_flush();

									$dsfeed_funcs->create_rp_stockonly_feed($ds, DS_RP_SERRANO_FILE, $rphead);

									//update the last feed update time
									$dsfeed_funcs->dsfeed_time_update($ds);

									$display .= "<div class='alertok'>";
									
									$display .= "<p>" . $error[1]. "</p>";

									$display .= "<p>Download the Rapid Publisher file <a href='".DS_RP_SERRANO_HTTP."'>HERE</a>. You then need to upload the feed to the Serrano FTP SoldSmartUse folder.</p>";

									$display .= "<p>Download the file of items that aren't on Kerp <a href='".DS_RP_SERRANO_MISSING_FILE_HTTP."'>HERE</a>.</p>";

									$display .= "<p>Alternatively you may download the files from the File Download Centre.</p>";
										
									$display .= "</div>";
								}


							}





						}

					}
//END PROCESS FORM INPUT ----------------------------------------------------------------------------------------------



					$display .= "<div class='newshow'>";
						$display .= "<h2>Select Dropshipper to Process.</h2>";
								



///////////////////////////////////UNITEX/////////////////////////////////////////////////////////////////
								$lstupdate = $dsfeed_funcs->get_last_update(DS_TYPE_UNITEX);


								$display .= "<div class='div_inner_left'>";
						
									$display .= "<fieldset>";
									$display .= "<h3>Unitex</h3>";
									$display .= $lstupdate . "<br/>";
										
										$form_elements = "<p>Import Unitex Datafeed - first download manually from FTP. Open in Excel. Copy all cells. Paste into text file. Save as TAB Delimited. Remember to update in kerp interface manually.</p>
										
										<p>Datafeed may be downloaded by logging in <a href='ftp://001:effecifa$@www.soldsmart.com.au:21000/Datafeed Update/' target='_blank'>HERE</a></p>
										
										";
										
										$form_elements .= $html_output->file_uploader("uploadfilename", MAX_FILE_UPLOAD_SIZE);
										$form_elements .= $html_output->hidden_element("uploadfile", 1);
										$form_elements .= $html_output->hidden_element("ds", DS_TYPE_UNITEX);
										$form_elements .= "<p>" .$html_output->create_submit("Import & Process Feed") ."</p>";

										$display .= $html_output->create_form(1, "kdimport.php?import=5", $form_elements);
									
									$display .= "</fieldset>";
								
								$display .= "</div>";





///////////////////////////////////NewAim/////////////////////////////////////////////////////////////////
								$lstupdate = $dsfeed_funcs->get_last_update(DS_TYPE_NEWAIM);
								
								$display .= "<div class='div_inner_left'>";
									$display .= "<fieldset>";
									$display .= "<h3>NewAim</h3>";

									$hash = urlencode("#");

									$display .= $lstupdate . "<br/>";

										$form_elements = "<p>Import Newaim Datafeed - first download manually from FTP. Remember to update in kerp interface manually.</p>

										<p>Datafeed may be downloaded by logging in <a href='ftp://002:vatimade".$hash."@www.soldsmart.com.au:21000/Datafeed/')' target='_blank'>HERE</a></p>
										
										";
										
										$form_elements .= $html_output->file_uploader("uploadfilename", MAX_FILE_UPLOAD_SIZE);
										$form_elements .= $html_output->hidden_element("uploadfile", 1);
										$form_elements .= $html_output->hidden_element("ds", DS_TYPE_NEWAIM);
										$form_elements .= "<p>" .$html_output->create_submit("Import & Process Feed") ."</p>";

										$display .= $html_output->create_form(1, "kdimport.php?import=5", $form_elements);
									
									$display .= "</fieldset>";
								$display .= "</div>";

				
								
								
								
								
								$display .= "<div class='clearme'></div>";






///////////////////////////////////OneScent/////////////////////////////////////////////////////////////////
								$lstupdate = $dsfeed_funcs->get_last_update(DS_TYPE_ONESCENT);

								$display .= "<div class='div_inner_left'>";

									$display .= "<fieldset>";
									$display .= "<h3>OneScent</h3>";

									$display .= "<p>Feed will download automatically via web. No need to manually upload. Remember to update in kerp interface manually.</p>";

									$display .= $lstupdate . "<br/>";

										$form_elements = "<div class= 'linersub'></div>";

										$form_elements .= $html_output->hidden_element("dlfile", 1);
										$form_elements .= $html_output->hidden_element("ds", DS_TYPE_ONESCENT);
//$_POST['uploadfile']
										$form_elements .= $html_output->create_submit("Download & Process Feed");
										$display .= $html_output->create_form(0, "kdimport.php?import=5", $form_elements);
									
									$display .= "</fieldset>";
								$display .= "</div>";



////////////////////////TRINITY ///////////////////////////////////////////////////////////

							$lstupdate = $dsfeed_funcs->get_last_update(DS_TYPE_TRINITY);

							$display .= "<div class='div_inner_left'>";
									$display .= "<fieldset>";
									$display .= "<h3>Trinity</h3>";

									$display .= $lstupdate . "<br/>";

										$form_elements = "<p>Import Trinity Datafeed - first download manually from FTP. Open in Excel. Copy all cells. Paste into text file. Save as TAB Delimited. Remember to update in kerp interface manually.</p>
										
										
										<p>Datafeed may be downloaded by logging in <a href='ftp://011:lebalipe18@www.soldsmart.com.au:21000/Datafeed/' target='_blank'>HERE</a></p>
												
												
												";
										
										$form_elements .= $html_output->file_uploader("uploadfilename", MAX_FILE_UPLOAD_SIZE);
										$form_elements .= $html_output->hidden_element("uploadfile", 1);
										$form_elements .= $html_output->hidden_element("ds", DS_TYPE_TRINITY);
										$form_elements .= "<p>" .$html_output->create_submit("Import & Process Feed") ."</p>";

										$display .= $html_output->create_form(1, "kdimport.php?import=5", $form_elements);
									
									$display .= "</fieldset>";
								$display .= "</div>";





								$display .= "<div class='clearme'></div>";

//////////////////POWER HOUSE PC /////////////////////////////////////////////////////////////
								$lstupdate = $dsfeed_funcs->get_last_update(DS_TYPE_POWERHOUSE);

								$display .= "<div class='div_inner_left'>";
									$display .= "<fieldset>";
									$display .= "<h3>Powerhouse PC</h3>";

									$display .= $lstupdate . "<br/>";

										$form_elements = "<p>Import Powerhouse PC Datafeed - first download manually from FTP. Open in Excel. Copy all cells. Paste into text file. Save as TAB Delimited. Remember to update in kerp interface manually.</p>
										
										
										<p>Datafeed may be downloaded by logging in <a href='ftp://004:xju6wztfj@www.soldsmart.com.au:21000/' target='_blank'>HERE</a></p>
												
												
												";
										
										$form_elements .= $html_output->file_uploader("uploadfilename", MAX_FILE_UPLOAD_SIZE);
										$form_elements .= $html_output->hidden_element("uploadfile", 1);
										$form_elements .= $html_output->hidden_element("ds", DS_TYPE_POWERHOUSE);
										$form_elements .= "<p>" .$html_output->create_submit("Import & Process Feed") ."</p>";

										$display .= $html_output->create_form(1, "kdimport.php?import=5", $form_elements);
									
									$display .= "</fieldset>";
								$display .= "</div>";





//////////////////SIMPLY WHOLESALE /////////////////////////////////////////////////////////////
								$lstupdate = $dsfeed_funcs->get_last_update(DS_TYPE_SIMPLYWHOLESALE);

									$display .= "<div class='div_inner_left'>";

										$display .= "<fieldset>";
										$display .= "<h3>SIMPLY WHOLESALE</h3>";

										$display .= "<p>Feed will download automatically via web. No need to manually upload. Remember to update in kerp interface manually.</p>";

										$display .= $lstupdate . "<br/>";

											$form_elements = "<div class= 'linersub'></div>";

											$form_elements .= $html_output->hidden_element("dlfile", 1);
											$form_elements .= $html_output->hidden_element("ds", DS_TYPE_SIMPLYWHOLESALE);
	//$_POST['uploadfile']
											$form_elements .= $html_output->create_submit("Download & Process Feed");
											$display .= $html_output->create_form(0, "kdimport.php?import=5", $form_elements);
										
										$display .= "</fieldset>";
									$display .= "</div>";



								$display .= "<div class='clearme'></div>";

///////////////// DR CARL /////////////////////////////////////////////////////////////
								$lstupdate = $dsfeed_funcs->get_last_update(DS_TYPE_DRCARL);

									$display .= "<div class='div_inner_left'>";

										$display .= "<fieldset>";
										$display .= "<h3>DR CARL</h3>";

										$display .= $lstupdate . "<br/>";

											$form_elements = "<p>Import DR CARL Datafeed - first download manually from FTP. Open in Excel. Copy all cells. Paste into text file. Save as TAB Delimited. Remember to update in kerp interface manually.</p>
										
										
										<p>Datafeed may be downloaded by logging in <a href='ftp://007:rumurafu14@www.soldsmart.com.au:21000/Datafeed/' target='_blank'>HERE</a></p>
												
												
												";
										
										$form_elements .= $html_output->file_uploader("uploadfilename", MAX_FILE_UPLOAD_SIZE);
										$form_elements .= $html_output->hidden_element("uploadfile", 1);
										$form_elements .= $html_output->hidden_element("ds", DS_TYPE_DRCARL);
										$form_elements .= "<p>" .$html_output->create_submit("Import & Process Feed") ."</p>";

										$display .= $html_output->create_form(1, "kdimport.php?import=5", $form_elements);
										
										$display .= "</fieldset>";
									$display .= "</div>";


								




////////////////// SERRANO /////////////////////////////////////////////////////////////
								$lstupdate = $dsfeed_funcs->get_last_update(DS_TYPE_SERRANO);

								$display .= "<div class='div_inner_left'>";

										$display .= "<fieldset>";
										$display .= "<h3>SERRANO</h3>";

										$display .= "<p>Feed will download automatically via web. No need to manually upload. Remember to update in kerp interface manually.</p>";

										$display .= "<p><b>FTP DETAILS</b><pre>Address: www.soldsmart.com.au

Port: 21000

Login details

User: 016A

password: vireccid32</pre></p>";

										$display .= $lstupdate . "<br/>";

											$form_elements = "<div class= 'linersub'></div>";

											$form_elements .= $html_output->hidden_element("dlfile", 1);
											$form_elements .= $html_output->hidden_element("ds", DS_TYPE_SERRANO);
	//$_POST['uploadfile']
											$form_elements .= $html_output->create_submit("Download & Process Feed");
											$display .= $html_output->create_form(0, "kdimport.php?import=5", $form_elements);
										
										$display .= "</fieldset>";
									$display .= "</div>";


					$display .= "<div class='clearme'></div>";





					$display .= "</div>";


					

				}//END DROPSHIPPER FEED IMPORT


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

	function kdimpone($head, $feed_reader, $data, $type, $delim, $dbase_getters, $dbase_setters, $db_itemfields = false){
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
			
			if ($type == UPLOAD_TYPE_DROPSHIPPER){
				//run database entry stuff
				upload_ds($head, $feed_header_check, $bits, $dbase_getters, $dbase_setters, $db_itemfields);
			}

			else if ($type == UPLOAD_TYPE_SS){
				//run database entry stuff
				
				upload_ss($head, $feed_header_check, $bits, $dbase_getters, $dbase_setters, $db_itemfields);
			}
			
			$error[0] = false;
			$error[1] = FORM_SUBMIT_OKMSG;
		}
		else{
			$error[0] = true;
			$error[1] = $errmsg;
		}

		return $error;
		
	}


	function upload_ds($headers, $header_check, $lines_and_bits, $dbase_getters, $dbase_setters, $db_itemfields){
		//loop through bits
		//for lines_and_bits, data starts at [2]
		echo "Entering data into system. . . ";
		flush();
		ob_flush();

		//first set all dropshipper market status to 0
		$update_zero_cols = array();
		$update_zero_where = array();

		$update_zero_cols[0][0] = ITEM_ON_MARKET;
		$update_zero_cols[0][1] = 0;

		$update_zero_where[0][0] = ITEM_STOCK_TYPE;
		$update_zero_where[0][1] = STOCK_TYPE_DROPSHIPPER;


		$dbase_setters->update_query(ITEM_MAIN_TABLE,  $update_zero_cols, $update_zero_where);

		
		for ($i=2; $i < sizeof($lines_and_bits)  ;$i++){
			if ($i % 20 == 0){
				echo ". ";
				flush();
				ob_flush();
			}

			//assign variables
			$Goods = trim($lines_and_bits[$i][$header_check['Goods']]);
			$ManufacturerPartNum = trim($lines_and_bits[$i][$header_check['ManufacturerPartNum']]);
			$WebTitle = trim($lines_and_bits[$i][$header_check['WebTitle']]);
			$SubTitle = trim($lines_and_bits[$i][$header_check['SubTitle']]);
			$mod_URL = trim($lines_and_bits[$i][$header_check['mod_URL']]);
			$ListPrice = trim($lines_and_bits[$i][$header_check['ListPrice']]);
			$SellPrice = trim($lines_and_bits[$i][$header_check['SellPrice']]);
			$BuyPrice = trim($lines_and_bits[$i][$header_check['BuyPrice']]);
			$Points = trim($lines_and_bits[$i][$header_check['Points']]);
			$Keywords = trim($lines_and_bits[$i][$header_check['Keywords']]);
			$ShortDesc = trim($lines_and_bits[$i][$header_check['ShortDesc']]);
			$OnMarket = trim($lines_and_bits[$i][$header_check['OnMarket']]);
			$width = trim($lines_and_bits[$i][$header_check['width']]);
			$height = trim($lines_and_bits[$i][$header_check['height']]);
			$depth = trim($lines_and_bits[$i][$header_check['depth']]);
			$weight = trim($lines_and_bits[$i][$header_check['weight']]);
			$DateCreated = trim($lines_and_bits[$i][$header_check['DateCreated']]);


			//cols shared by update and insert
			$cols = array();

			$cols[0][0] = ITEM_SS_SKU;
			$cols[1][0] = ITEM_MPN_SKU;
			$cols[2][0] = ITEM_WEBTITLE;
			$cols[3][0] = ITEM_SUBTITLE;
			$cols[4][0] = ITEM_MOD_URL;
			$cols[5][0] = ITEM_ACTUAL_LIST_PRICE;
			$cols[6][0] = ITEM_ACTUAL_SELL_PRICE;
			$cols[7][0] = ITEM_COST_AUD;
			$cols[8][0] = ITEM_POINTS;
			$cols[9][0] = ITEM_KEYWORDS;
			$cols[10][0] = ITEM_SHORT_DES;
			$cols[11][0] = ITEM_ON_MARKET;
			$cols[12][0] = ITEM_WIDTH;
			$cols[13][0] = ITEM_HEIGHT;
			$cols[14][0] = ITEM_DEPTH;
			$cols[15][0] = ITEM_WEIGHT;
			$cols[16][0] = ITEM_SS_DATE_CREATED;
			$cols[0][1] = $Goods;
			$cols[1][1] = $ManufacturerPartNum;
			$cols[2][1] = $WebTitle;
			$cols[3][1] = $SubTitle;
			$cols[4][1] = $mod_URL;
			$cols[5][1] = $ListPrice;
			$cols[6][1] = $SellPrice;
			$cols[7][1] = $BuyPrice;
			$cols[8][1] = $Points;
			$cols[9][1] = $Keywords;
			$cols[10][1] = $ShortDesc;
			$cols[11][1] = $OnMarket;
			$cols[12][1] = $width;
			$cols[13][1] = $height;
			$cols[14][1] = $depth;
			$cols[15][1] = $weight;
			$cols[16][1] = $DateCreated;


			//check ds mpn against our database to see if duplicated
			$mpn_final = $dbase_getters->get_mpn_line($ManufacturerPartNum, $db_itemfields);
			
			//if item exists, update
			if (sizeof($mpn_final[ITEM_ID]) > 0){
				$cols[17][0] = ITEM_DISPRICE;
				$cols[17][1] = $SellPrice;

				$upd_where[0][0] = ITEM_SS_SKU;
				$upd_where[0][1] = $Goods;
			


				$dbase_setters->update_query(ITEM_MAIN_TABLE, $cols, $upd_where);
				
			}
			//if item doesn't exist, add
			else{
				//$cols = multidimensional array of column names then entries [0] = col name [1] = entry
				

				$cols[17][0] = ITEM_STOCK_TYPE;
				$cols[17][1] = STOCK_TYPE_DROPSHIPPER;

				//get ds id - first separate first three chars
				$dscode = substr($Goods, 0, 3);

				$dsselect_cols = array();
				$dsselect_cols[0] = DS_TYPES_TABLE_ID;

				$dswhere_cols = array();
				$dswhere_cols[0][0] = DS_TYPES_TABLE_PREFIX;
				$dswhere_cols[0][1] = $dscode;

				$dscode_final = $dbase_getters->basic_get(DS_TYPES_TABLE, $dsselect_cols, $dswhere_cols, "", "");

				if(sizeof($dscode_final[DS_TYPES_TABLE_ID]) > 0){
					$cols[18][0] = ITEM_DROPSHIPPER_ID;
					$cols[18][1] = $dscode_final[DS_TYPES_TABLE_ID][0];
					$cols[19][0] = ITEM_STOCK_LEVEL;
					$cols[19][1] = 0;
					$cols[20][0] = ITEM_DISPRICE;
					$cols[20][1] = $SellPrice;

					$dbase_setters->insert_query(ITEM_MAIN_TABLE, $cols);
				}
				else{
					echo "<p><strong>Line Error: Dropshipper with code: ".$dscode." does not exist in types table.</strong></p>";
					flush();
					ob_flush();

				}

			}



		}
	
		

	}//end ds




	function upload_ss($headers, $header_check, $lines_and_bits, $dbase_getters, $dbase_setters, $db_itemfields){
		//loop through bits
		//for lines_and_bits, data starts at [2]
		echo "Entering data into system. . . ";
		flush();
		ob_flush();

		//first set all dropshipper market status to 0
		$update_zero_cols = array();
		$update_zero_where = array();
		

		//update to 0 standard SS items
		$update_zero_cols[0][0] = ITEM_ON_MARKET;
		$update_zero_cols[0][1] = 0;
		$update_zero_where[0][0] = ITEM_STOCK_TYPE;
		$update_zero_where[0][1] = STOCK_TYPE_STANDARD;

		$dbase_setters->update_query(ITEM_MAIN_TABLE,  $update_zero_cols, $update_zero_where);

		//update to 0 postock SS items
		$update_zero_cols[0][0] = ITEM_ON_MARKET;
		$update_zero_cols[0][1] = 0;
		$update_zero_where[0][0] = ITEM_STOCK_TYPE;
		$update_zero_where[0][1] = STOCK_TYPE_POSTOCK;

		$dbase_setters->update_query(ITEM_MAIN_TABLE,  $update_zero_cols, $update_zero_where);

		
		for ($i=2; $i < sizeof($lines_and_bits)  ;$i++){
			if ($i % 20 == 0){
				echo ". ";
				flush();
				ob_flush();
			}

			//assign variables
			$Goods = trim($lines_and_bits[$i][$header_check['Goods']]);
			$WebTitle = trim($lines_and_bits[$i][$header_check['WebTitle']]);
			$SubTitle = trim($lines_and_bits[$i][$header_check['SubTitle']]);
			$mod_URL = trim($lines_and_bits[$i][$header_check['mod_URL']]);
			$ListPrice = trim($lines_and_bits[$i][$header_check['ListPrice']]);
			$SellPrice = trim($lines_and_bits[$i][$header_check['SellPrice']]);
			$BuyPrice = trim($lines_and_bits[$i][$header_check['BuyPrice']]);
			$Points = trim($lines_and_bits[$i][$header_check['Points']]);
			$OnMarket = trim($lines_and_bits[$i][$header_check['OnMarket']]);
			$width = trim($lines_and_bits[$i][$header_check['Width']]);
			$height = trim($lines_and_bits[$i][$header_check['Height']]);
			$depth = trim($lines_and_bits[$i][$header_check['Depth']]);
			$weight = trim($lines_and_bits[$i][$header_check['Weight']]);
			$DateCreated = trim($lines_and_bits[$i][$header_check['DateCreated']]);
			$shipping = trim($lines_and_bits[$i][$header_check['ShipCharge']]);
			$stocklevel = trim($lines_and_bits[$i][$header_check['InStock_and_transit']]);
			$disprice = trim($lines_and_bits[$i][$header_check['DisPrice']]);
			$postock = trim($lines_and_bits[$i][$header_check['Postock']]);


			$dstype = DS_TYPE_SS;


			//cols shared by update and insert
			$cols = array();

			$cols[0][0] = ITEM_SS_SKU;
			$cols[1][0] = ITEM_SS_DATE_CREATED;
			$cols[2][0] = ITEM_WEBTITLE;
			$cols[3][0] = ITEM_SUBTITLE;
			$cols[4][0] = ITEM_MOD_URL;
			$cols[5][0] = ITEM_ACTUAL_LIST_PRICE;
			$cols[6][0] = ITEM_ACTUAL_SELL_PRICE;
			$cols[7][0] = ITEM_COST_AUD;
			$cols[8][0] = ITEM_POINTS;
			$cols[9][0] = ITEM_DISPRICE;
			$cols[10][0] = ITEM_WEIGHT;
			$cols[11][0] = ITEM_ON_MARKET;
			$cols[12][0] = ITEM_WIDTH;
			$cols[13][0] = ITEM_HEIGHT;
			$cols[14][0] = ITEM_DEPTH;
			$cols[15][0] = ITEM_SHIPPRICE;
			$cols[16][0] = ITEM_STOCK_LEVEL;
			$cols[17][0] = ITEM_DROPSHIPPER_ID;
			
			
			
			$cols[0][1] = $Goods;
			$cols[1][1] = $DateCreated;
			$cols[2][1] = $WebTitle;
			$cols[3][1] = $SubTitle;
			$cols[4][1] = $mod_URL;
			$cols[5][1] = $ListPrice;
			$cols[6][1] = $SellPrice;
			$cols[7][1] = $BuyPrice;
			$cols[8][1] = $Points;
			$cols[9][1] = $disprice;
			$cols[10][1] = $weight;
			$cols[11][1] = $OnMarket;
			$cols[12][1] = $width;
			$cols[13][1] = $height;
			$cols[14][1] = $depth;
			$cols[15][1] = $shipping;
			$cols[16][1] = $stocklevel;
			$cols[17][1] = $dstype;
			
			
			


			//check ds mpn against our database to see if duplicated
			$mpn_final = $dbase_getters->get_ss_line($Goods, $db_itemfields);
			
			//if item exists, update
			if (sizeof($mpn_final[ITEM_ID]) > 0){
				

				$upd_where[0][0] = ITEM_SS_SKU;
				$upd_where[0][1] = $Goods;
			


				$dbase_setters->update_query(ITEM_MAIN_TABLE, $cols, $upd_where);
				
			}
			//if item doesn't exist, add
			else{
				//$cols = multidimensional array of column names then entries [0] = col name [1] = entry
				if ($postock == "True"){
					$cols[17][0] = ITEM_STOCK_TYPE;
					$cols[17][1] = STOCK_TYPE_POSTOCK;
				}
				else{
					$cols[17][0] = ITEM_STOCK_TYPE;
					$cols[17][1] = STOCK_TYPE_STANDARD;
				}

				$dbase_setters->insert_query(ITEM_MAIN_TABLE, $cols);
				

			}



		}
	
		

	}//end ss






?>

