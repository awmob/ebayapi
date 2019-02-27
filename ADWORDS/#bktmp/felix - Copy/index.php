<?php

error_reporting(0);
	require_once 'config/constants/constants.inc.php';
	require_once FILE_SYSTEM_HTML_OUTPUT_CALLER;


	$display = $html_output->headermain("Felix Management Tools HOME");


	

		$display .= "<div class='wrappermain'>";

			$display .= "<h1>Main Menu</h1>";



			
			

			$display .= "<div class='leftmenu'>";

				$display .= $html_output->linermain();

				$display .= "<h2>Stock & Dropshipper Management</h2>";

				

				//create list of entries
				$pagea[0][0] = "KD, Dropshipper Feeds & Froogle Imports";
				$pagea[0][1] = "kdimport.php";

				$pagea[1][0] = "Manage Types";
				$pagea[1][1] = "stocktypes.php?showds=1";


				$pagea[2][0] = "Product & Stock Information";
				$pagea[2][1] = "productinfo.php";


				$display .= $html_output->list_element($pagea);

				$display .= $html_output->linermain();

				


				$display .= "<h2>eBay Management</h2>";

				$pageb[0][0] = "eBay Management";
				$pageb[0][1] = "ebay.php";



				$display .= $html_output->list_element($pageb);

				$display .= $html_output->linermain();



				$display .= "<h2>Marketing Management</h2>";

				$pageb[0][0] = "Adwords";
				$pageb[0][1] = "adwordsmain.php";

				$pageb[1][0] = "Google Shopping";
				$pageb[1][1] = "gshop.php";

				$pageb[2][0] = "Newsletter Maker";
				$pageb[2][1] = "newsmaker.php";


				$display .= $html_output->list_element($pageb);

				$display .= $html_output->linermain();

				

			$display .= "</div>";
			

			//show news - get from dbase later but set [0] to main notice
			$newsarray = array();

			$newsarray[0]['date'] = "<span style='color:red;'>** IMPORTANT NOTE **</span>";
			$newsarray[0]['news'] = "To ensure you are using latest data, start every session with Froogle, Dropshipper & Kerp Download KD Imports. Also, after every stock change on KERP, perform KD Import before using Felix Management Tools.";


			$newsarray[1]['date'] = "5 Sep 2014";
			$newsarray[1]['news'] = "<h2>Ta ta!</h2><img src='http://www.phptutes.com/felix/polar.jpg'>";



			$newsarray[2]['date'] = "25 Aug 2014";
			$newsarray[2]['news'] = "SS Replenishment added to eBay section. Auction listings added to eBay section.";


			$newsarray[3]['date'] = "22 Aug 2014";
			$newsarray[3]['news'] = "Dr. Carl Added to DS Feeds.";

			$newsarray[4]['date'] = "13 Aug 2014";
			$newsarray[4]['news'] = "Simply Wholesale Added to DS Feeds.";


			$newsarray[5]['date'] = "15 June 2014";
			$newsarray[5]['news'] = "Felix Management Tools implementation.";

			$display .= "<div class='rightmenu'>";
			$display .= $html_output->newsmain($newsarray, "NOTICES");
			$display .= "</div>";
			

		$display .= "</div>";
	


	$display .="</body></html>";


	echo $display;






?>