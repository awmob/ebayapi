<?php


	require_once 'config/constants/constants.inc.php';
	require_once FILE_SYSTEM_HTML_OUTPUT_CALLER;
	require_once FILE_SYSTEM_DBASE_CALL;


	$display = $html_output->headermain("ADWORDS MAIN - SoldSmart Management Tools");


	

		$display .= "<div class='wrappermain'>";

			$display .= "<div class='leftmenu'>";

			$display .= "<h1>ADWORDS Main Menu</h1>";





	//create list of entries
	$page[0][0] = "Create New Ad Groups, keywords, and ads";
	$page[0][1] = "new_ad_groups.php";	

	$page[1][0] = "Update Stock Levels";
	$page[1][1] = "update_stock.php";

	$page[2][0] = "Enter Data into Database";
	$page[2][1] = "enter_data.php";


	$display .= "<div>";
	$display .= $html_output->list_element($page);
	$display .= "</div>";
	
	$display .= $html_output->linermain();




	$pageb[0][0] = "File Download Centre";
	$pageb[0][1] = "adwordsmain.php?go=1";	



	$display .= "<div>";
	$display .= $html_output->list_element($pageb);
	$display .= "</div>";
	
	$display .= $html_output->linermain();


	$display .= "</div>";


	if (isset($_GET['go'])){

		$selcols[0] = EB_ADW_UPD_STOCK;

		//need to download last update
		$lastupdate = $dbase_getters->basic_get(EB_UPD_TRACKING, $selcols, false, false, false);


		$newsarray = array();
		$newsarray[0]['date'] = "<b>Adwords Stock Update File</b> <span style='color:red;'>(Last Update <i>" . date("d-M-Y @ H:i:m", $lastupdate[EB_ADW_UPD_STOCK][0]) ."</i>)</span>";

		$newsarray[0]['news'] = "<ul><li><a href='".ADGROUPS_STOCK_UPDATE_OUTPUT_FILE_HTTP."'>Adwords Editor Stock Update File</a></li></ul>";


		$display .= "<div class='rightmenu'>";

			$display .= $html_output->newsmain($newsarray, "DOWNLOAD FILES");

		$display .= "</div>";

	}














	$display .="</div></body></html>";


	echo $display;






?>