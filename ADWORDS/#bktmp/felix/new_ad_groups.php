<?php


	require_once 'config/constants/constants.inc.php';
	require_once FILE_SYSTEM_HTML_OUTPUT_CALLER;


	$display = $html_output->headermain("ADWORDS - Upload New Ad Groups - SoldSmart Management Tools");


	

		$display .= "<div class='wrappermain'>";

			$display .= "<h1>ADWORDS - Upload New Ad Groups</h1>";

	$display .= "<div>This outputs new ad groups, ads, and keywords for entering into Adwords Editor.</div>";


	//create list of entries
	$page[0][0] = "Back to Adwords Main Menu";
	$page[0][1] = ADWORDS_MAIN;	
	$page[1][0] = "Create ad groups output, ads output, and keywords output";
	$page[1][1] = "new_ad_groups.php?type=1";


	$display .= "<div>";
	$display .= $html_output->list_element($page);
	$display .= "</div>";

	$display .= $html_output->linermain();

	if (isset($_POST['upload'])){
		//adgroup etc upload
		if ($_POST['upload'] == 1){
			//check mime
			require_once FILE_SYSTEM_FILE_UPLOADING_CALLER;
			$tmpfile = $_FILES['file_upload']['tmp_name'];
			if ($tmpfile == ""){
				$display .= "You didn't choose a file to upload";
			}
			else{

				$tmpfile_data = file_get_contents($tmpfile);

				$mime = $file_uploading->get_mime($tmpfile);
				$mime_allowed = $file_uploading->check_mime_allowed_general($mime, $feed_mime_types_config);
				if ($mime_allowed['error_exists']){
					$display .= $mime_allowed['error_message'];
				}

				else {
					//check feed
					require_once FILE_SYSTEM_FEED_READER_CALLER;
					$lines = $feed_reader->break_feed_lines($tmpfile_data, $feed_reader_config['line_delimiter'][0]);
					$feed_line_bits = $feed_reader->break_up_feed_lines_and_clean($lines, $feed_reader_config['element_delimiter'][0], 1);

					//if there are errors, show them, otherwise continue
					if ($feed_line_bits[0]['error_ends_upload']){
						$display .= $feed_line_bits[0]['error_message'];
					}
					else{

						//set the data for the files
						$adgroups_file = "Campaign	Ad Group	Max CPC	Display Network Max CPC	Placement Max CPC	Max CPM	CPA Bid	Status\r\n";
						$keywords_file = "Campaign	Ad Group	Keyword	Keyword Type	Max CPC	Keyword Status\r\n";
						$ads_file = "Campaign	Ad Group	Headline	Description Line 1	Description Line 2	Display_URL	Destination URL	Ad Status\r\n";

						//read the feed - only from line 2 onwards
						for ($i=2; $i < sizeof($feed_line_bits) ;$i++){
							//only allow 1 entry per line
							if (sizeof($feed_line_bits[$i]) != 4){
								$display .= "Your feed must have 4 elements per line<br>";
								break;

							}
							//if okay then perform dbase upload
							else{
								

								require_once FILE_SYSTEM_DBASE_CALL;
								//check if entry exists
								$select_cols[0] = ADGROUPS_TABLE_ID;

								$where_cols[0][0] = ADGROUPS_TABLE_ADGROUP_NAME;
								$where_cols[0][1] = $feed_line_bits[$i][0];

								$data = $dbase_getters->basic_get(ADGROUPS_TABLE, $select_cols, $where_cols, false, false);
								
								//enter if doesn't exist
								if (isset($data[ADGROUPS_TABLE_ID])){
									$display .= "Adgroup " . $feed_line_bits[$i][0] . " already exists in the database! Not uploaded.<br>";
								}

								else{
									
									//get campaign name
									$select_c_cols[0] = CAMPAIGNS_TABLE_NAME;
									$where_c_cols[0][0] = CAMPAIGNS_TABLE_ID;
									$where_c_cols[0][1] = $_POST['campaigns'];
									$campaign_data = $dbase_getters->basic_get(CAMPAIGNS_TABLE, $select_c_cols, $where_c_cols, false, false);

									$campaign_name = $campaign_data[CAMPAIGNS_TABLE_NAME][0];

									//add data to adgroups file
									$adgroups_file .= $campaign_name . "	" . trim($feed_line_bits[$i][0]) . "	0.2	0.2	0	0	0	Active\r\n";
									
									//create ads file and add data
									$our_price_text = "Our Price $".ceil($feed_line_bits[$i][3])." Rrp $".ceil($feed_line_bits[$i][2])." Cheap Ship";
									$link = "http://www.soldsmart.com.au/l3.aspx?goods=".trim($feed_line_bits[$i][0])."&cam=26";
									$display_url = "SoldSmart.com.au/" . str_replace(" ","_", trim($feed_line_bits[$i][1]));

									$ads_file .= $campaign_name . "	" . trim($feed_line_bits[$i][0]) . "	" . trim($feed_line_bits[$i][1]) . "	" . $our_price_text . "	" . trim($feed_line_bits[$i][1]) . "	" . $display_url . "	" . $link . "	Active\r\n";

									//create keywords file and add data
									$keywords_file .= $campaign_name . "	" . trim($feed_line_bits[$i][0]) . "	" . trim($feed_line_bits[$i][1]) . "	" . "Broad	0.2	Active\r\n";

									//create more empty entries
									for ($p=0; $p < 8  ;$p++){
										$keywords_file .= $campaign_name . "	" . trim($feed_line_bits[$i][0]) . "		" . "Broad	0.2	Active\r\n";

									}

									//enter into database
									$enter_cols[0][0] = ADGROUPS_TABLE_ADGROUP_NAME;
									$enter_cols[0][1] = trim($feed_line_bits[$i][0]);
									$enter_cols[1][0] = ADGROUPS_TABLE_CAMP_ID;
									$enter_cols[1][1] = $_POST['campaigns'];

									if ($enter_cols[0][1] != "" && $enter_cols[1][1] != ""){
										$dbase_setters->insert_query(ADGROUPS_TABLE, $enter_cols);
									}


									
								}
								
								



							}
						}

						if (isset($adgroups_file)){
							//write the file
							$fh = fopen(ADGROUPS_OUTPUT_FILE, 'w');
							fwrite($fh, $adgroups_file);
							fclose($fh);
						}
						if (isset($ads_file)){
							//write the file
							$fh = fopen(ADS_OUTPUT_FILE, 'w');
							fwrite($fh, $ads_file);
							fclose($fh);
						}
						if (isset($keywords_file)){
							//write the file
							$fh = fopen(KEYWORDS_OUTPUT_FILE, 'w');
							fwrite($fh, $keywords_file);
							fclose($fh);
						}

						$display .= "Finished! Output files are available in the output folder.";
					}
				}


			}

		}

	}

	if (isset($_GET['type'])){
	//adgroups etc upload
		if ($_GET['type'] == 1){
			require_once FILE_SYSTEM_DBASE_CALL;
			//get campaigns from dbase
			$select_cols[0] = CAMPAIGNS_TABLE_ID;
			$select_cols[1] = CAMPAIGNS_TABLE_NAME;
			$table = CAMPAIGNS_TABLE;

			$campaigns_final = $dbase_getters->basic_get($table, $select_cols, false, false, false);
			//set for select
			$campaign_values = array();
			for ($i=0; $i < sizeof($campaigns_final[CAMPAIGNS_TABLE_ID]) ;$i++){
				$campaign_values[$i][0] = $campaigns_final[CAMPAIGNS_TABLE_ID][$i];
				$campaign_values[$i][1] = $campaigns_final[CAMPAIGNS_TABLE_NAME][$i];
				$campaign_values[$i][2] = false;
				$campaign_values[$i][3] = false;
			}

			$display .=	"<h2>Upload Adgroups etc</h2>";

			$display .= "<div>";
			
			$form_elements = $html_output->file_uploader("file_upload", 5000000);
			$form_elements .= " Upload feed file. .txt only. Format: Adgroup name TAB Product name TAB List Price TAB Disprice. REMEMBER TO INCLUDE HEADERS!<br>";
			$form_elements .= "<p>" . $html_output->create_dropdown($campaign_values, "campaigns", false) . "</p>";
			$form_elements .= " Select Campaign<br>";
			$form_elements .= $html_output->create_submit("Upload Ad Group File");
			$form_elements .= $html_output->hidden_element("upload", 1);

			$display .= $html_output->create_form(1, "new_ad_groups.php", $form_elements);
			$display .= "</div>";


			


		}



	}




	$display .="</div></body></html>";
	echo $display;



?>