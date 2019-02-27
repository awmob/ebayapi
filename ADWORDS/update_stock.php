<?php
	set_time_limit(120);

	require_once 'config/constants/constants.inc.php';
	require_once FILE_SYSTEM_HTML_OUTPUT_CALLER;
	require_once FILE_SYSTEM_DBASE_CALL;

	$display = $html_output->headermain("ADWORDS - Update Stock Levels - SoldSmart Management Tools");


	$okshow = "";
	echo $display;
	flush();
	ob_flush();

	$display = "";



	//show processing_data
	if (isset($_POST['uploadfile'])){
		echo "<div class='show_running'>";
		flush();
		ob_flush();
		echo "Running... Please wait...";
		flush();
		ob_flush();
	}



	if (isset($_POST['uploadfile'])){

		//prep the file
		$adgroups_update_file = "Campaign	Ad Group	AdGroup Status	Display Network Max CPC\r\n";

		$fh = fopen(ADGROUPS_STOCK_UPDATE_OUTPUT_FILE,'w');
		fwrite($fh, $adgroups_update_file);
		fclose($fh);

		echo "<br>Prepping file. . .";
		flush();
		ob_flush();

		$campaign = $_POST['campaigns'];

		//get the database name
		$select_cols[0] = CAMPAIGNS_TABLE_NAME;

		$where_cols[0][0] = CAMPAIGNS_TABLE_ID;
		$where_cols[0][1] = $campaign;

		$campaign_data = $dbase_getters->basic_get(CAMPAIGNS_TABLE, $select_cols, $where_cols, false, false);
		$campaign_name = $campaign_data[CAMPAIGNS_TABLE_NAME][0];

		
		//get the skus from the database using only the selected campaign
		$select_cols[0] = ADGROUPS_TABLE_ADGROUP_NAME;
		$where_cols[0][0] = ADGROUPS_TABLE_CAMP_ID;
		$where_cols[0][1] = $campaign;

		$adgroups_data = $dbase_getters->basic_get(ADGROUPS_TABLE, $select_cols, $where_cols, false, false);

		$thedata = "";

		//loop through the skus, search database for the skus. Set if stock level is higher than one, or if onmarket is higher than 1.
		for ($i=0; $i <  sizeof($adgroups_data[ADGROUPS_TABLE_ADGROUP_NAME]) ;$i++){
			if (($i % 10) == 0){
				echo " .";
				flush();
				ob_flush();
			}
			//get stock level and status

			$sku = $adgroups_data[ADGROUPS_TABLE_ADGROUP_NAME][$i];
			$on_status = $dbase_getters->is_kd_item_over_one_on_market($sku);

			if ($on_status){
				$thedata .= $campaign_name . TABDELIM . $sku . TABDELIM . ACTIVE_TEXT . TABDELIM . "0.0" . NLMAIN;
			}
			else{
				$thedata .= $campaign_name . TABDELIM . $sku . TABDELIM . PAUSED_TEXT .   TABDELIM . "0.0" . NLMAIN;
			}

		}

		echo " Writing to output file . . .";
		flush();
		ob_flush();
		
		//after looping, write the data to file.

		$fh = fopen(ADGROUPS_STOCK_UPDATE_OUTPUT_FILE,'a');
		fwrite($fh, $thedata);
		fclose($fh);

		


		$okshow = "<div class='alertok'>";
		$okshow .= "Adwords Stock Update file created. Download it <a href='".ADGROUPS_STOCK_UPDATE_OUTPUT_FILE_HTTP."'>HERE</a>";
		$okshow .= "</div>";


		//update time
		$cols[0][0] = EB_ADW_UPD_STOCK;
		$cols[0][1] = time();
		$dbase_setters->update_query(EB_UPD_TRACKING, $cols);

		
	}

	//end ad groups upload


	
	$display .= "<div class='wrappermain'>";

	$display .= "<div class='leftmenu'>";

		$display .= "<h1>ADWORDS - Update Stock Levels</h1>";

		$display .= "<div>This allows you to update stock levels.</div>";


		//create list of entries
		$page[0][0] = "Back to Adwords Main Menu";
		$page[0][1] = ADWORDS_MAIN;	


		$display .= "<div>";
		$display .= $html_output->list_element($page);
		$display .= "</div>";

		$display .= $html_output->linermain();


	$display .= "</div>";

	
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




	$display .= "<div class='rightmenu'>";

		$display .= $okshow;

		$display .=	"<h2>Upload Ad Groups and stock levels</h2>";

		$display .= "<div>";
		
		$form_elements = "<p>Select a Campaign for which to produce Ad Group Status file.</p>";
		$form_elements .= "<p style='color:red;'>NOTE: You need to update Kerp Download files for both SS and Dropshippers beforehand, otherwise the data produced here will not reflect correct stock levels.</p>";
		$form_elements .= "<p>" . $html_output->create_dropdown($campaign_values, "campaigns", false) . "";
		$form_elements .= " Select Campaign<br></p>";
		$form_elements .= $html_output->create_submit("Create Ad Group Update File");
		$form_elements .= $html_output->hidden_element("uploadfile", 1);

		$display .= $html_output->create_form(0, "update_stock.php", $form_elements);
		$display .= "</div>";


		
	
		$display .= "</div>";



	$display .="</div></body></html>";



		//for processing display
	if (isset($_POST['uploadfile'])){
		echo " <p><strong>FINISHED</strong></p>";
		flush();
		ob_flush();
		echo "</div>";
		flush();
		ob_flush();
	}




	echo $display;



?>