<?php
	set_time_limit(120);

	require_once 'config/constants/constants.inc.php';
	require_once FILE_SYSTEM_HTML_OUTPUT_CALLER;

	$display = $html_output->headermain("ADWORDS - Upload Data - SoldSmart Management Tools");


	

		$display .= "<div class='wrappermain'>";

			$display .= "<h1>ADWORDS - Upload Data into Database</h1>";

	$display .= "<div>This allows you to upload data straight into the database with a feed.</div>";


	//create list of entries
	$page[0][0] = "Back to Adwords Main Menu";
	$page[0][1] = ADWORDS_MAIN;	
	$page[1][0] = "Enter Campaign Names";
	$page[1][1] = "enter_data.php?type=1";
	$page[2][0] = "Enter Ad Groups";
	$page[2][1] = "enter_data.php?type=2";

	$display .= "<div>";
	$display .= $html_output->list_element($page);
	$display .= "</div>";


	$display .= $html_output->linermain();


	//uploads are set
	if (isset($_POST['upload'])){
		//campaign upload
		if ($_POST['upload'] == 1){
			//check mime
			require_once FILE_SYSTEM_FILE_UPLOADING_CALLER;
			$tmpfile = $_FILES['upload_campaign']['tmp_name'];
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
						//read the feed - only from line 2 onwards
						for ($i=2; $i < sizeof($feed_line_bits) ;$i++){
							//only allow 1 entry per line
							if (sizeof($feed_line_bits[$i]) > 1){
								$display .= "Your feed may only have 1 element per line";

							}
							//if okay then perform dbase upload
							else{
								require_once FILE_SYSTEM_DBASE_CALL;
								//check if entry exists
								$select_cols[0] = CAMPAIGNS_TABLE_ID;

								$where_cols[0][0] = CAMPAIGNS_TABLE_NAME;
								$where_cols[0][1] = $feed_line_bits[$i][0];

								$data = $dbase_getters->basic_get(CAMPAIGNS_TABLE, $select_cols, $where_cols, false, false);
								
								//enter if doesn't exist
								if (isset($data[CAMPAIGNS_TABLE_ID])){
									$display .= "That campaign name already exists in the database! Not uploaded.";
								}
								else{
									if ($where_cols[0][1] != ""){
										$dbase_setters->insert_query(CAMPAIGNS_TABLE, $where_cols);
									}
								}	

							}
						}
					}
				}
			}
			$display .= "<p>Upload completed</p>";
		}

		//ad group upload
		if ($_POST['upload'] == 2){
			//check mime
			require_once FILE_SYSTEM_FILE_UPLOADING_CALLER;
			$tmpfile = $_FILES['upload_adgroups']['tmp_name'];
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
						//read the feed - only from line 2 onwards
						for ($i=2; $i < sizeof($feed_line_bits) ;$i++){
							//only allow 1 entry per line
							if (sizeof($feed_line_bits[$i]) > 1){
								$display .= "Your feed may only have 1 element per line";

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
									$display .= "The adgroup name " .$feed_line_bits[$i][0] . "already exists in the database! Not uploaded.<br/>";
								}
								else{	

									$enter_cols[0][0] = ADGROUPS_TABLE_ADGROUP_NAME;
									$enter_cols[0][1] = $feed_line_bits[$i][0];
									$enter_cols[1][0] = ADGROUPS_TABLE_CAMP_ID;
									$enter_cols[1][1] = $_POST['campaigns'];

									if ($enter_cols[0][1] != "" && $enter_cols[1][1] != ""){
										$dbase_setters->insert_query(ADGROUPS_TABLE, $enter_cols);
									}
									
								}	

							}
						}
					}
				}
			}
			$display .= "<p>Upload completed</p>";
		}
	}



	if (isset($_GET['type'])){
		//campaign upload
		if ($_GET['type'] == 1){
			$display .=	"<h2>Upload Campaign Names</h2>";

			$display .= "<div>";
			
			$form_elements = $html_output->file_uploader("upload_campaign", 1000000);
			$form_elements .= " Upload campaign feed file. .txt only. Format: Campaign name. REMEMBER TO INCLUDE HEADERS!<br>";
			$form_elements .= $html_output->create_submit("Upload Campaigns");
			$form_elements .= $html_output->hidden_element("upload", 1);

			$display .= $html_output->create_form(1, "enter_data.php", $form_elements);
			$display .= "</div>";


		}
		//ad groups upload
		else if ($_GET['type'] == 2){
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

			$display .=	"<h2>Upload Ad Groups</h2>";

			$display .= "<div>";
			
			$form_elements = $html_output->file_uploader("upload_adgroups", 5000000);
			$form_elements .= " Upload Ad Groups file. .txt only. Format: Ad Group. 1 per line. REMEMBER TO INCLUDE HEADERS!<br>";
			$form_elements .= "<p>" . $html_output->create_dropdown($campaign_values, "campaigns", false) . "</p>";
			$form_elements .= " Select Campaign<br>";
			$form_elements .= $html_output->create_submit("Upload Ad Groups");
			$form_elements .= $html_output->hidden_element("upload", 2);

			$display .= $html_output->create_form(1, "enter_data.php", $form_elements);
			$display .= "</div>";


		}
	}
	



	$display .="</div></body></html>";
	echo $display;



?>