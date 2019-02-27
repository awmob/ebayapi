<?php

//error_reporting(0);
	require_once 'config/constants/constants.inc.php';
	require_once FILE_SYSTEM_HTML_OUTPUT_CALLER;


	$display = $html_output->headermain("Felix Management Tools HOME");




		$display .= "<div class='wrappermain'>";

			$display .= "<h1>Main Menu - Token Expires 3 Mar 2019!!</h1>";






			$display .= "<div class='leftmenu'>";



				$display .= $html_output->linermain();




				$display .= "<h2>eBay Management</h2>";

				$pageb[0][0] = "eBay Management";
				$pageb[0][1] = "ebay.php";



				$display .= $html_output->list_element($pageb);

				$display .= $html_output->linermain();



			



			$display .= "</div>";


			//show news - get from dbase later but set [0] to main notice
			$newsarray = array();

			$newsarray[0]['date'] = "<span style='color:red;'>NO NEWS</span>";
			$newsarray[0]['news'] = "";



			$display .= "<div class='rightmenu'>";
			$display .= $html_output->newsmain($newsarray, "NOTICES");
			$display .= "</div>";


		$display .= "</div>";



	$display .="</body></html>";


	echo $display;






?>
