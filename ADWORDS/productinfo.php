


<?php


	require_once 'config/constants/constants.inc.php';
	require_once FILE_SYSTEM_HTML_OUTPUT_CALLER;
	require_once FILE_SYSTEM_DBASE_CALL;

	$display = $html_output->headermain("Product & Stock Info - SoldSmart Management Tools");


	

		$display .= "<div class='wrappermain'>";

			$display .= "<h1>Product & Stock Info</h1>";

			
			

			$display .= "<div class='leftmenu'>";

				
				
				
				//stock types
				//create list of entries
				$pagea[0][0] = "Product Info & Stock Main";
				$pagea[0][1] = "productinfo.php";

				


				$display .= $html_output->list_element($pagea);
				$display .= $html_output->linermain();


			//stock types

				$display .= "<h2>Display Information</h2>";
				//create list of entries
				$pagea[0][0] = "Show Categories of Items";
				$pagea[0][1] = "productinfo.php?import=1";

				


				$display .= $html_output->list_element($pagea);
				$display .= $html_output->linermain();



			$display .= "</div>";
			

			$display .= "<div class='rightmenu'>";



			if (isset($_GET['import'])){

				if ($_GET['import'] == 1){

					if (isset($_POST['uploadfile'])){
						if ($_POST['uploadfile'] == 1){

							//conduct search
							$search = trim($_POST['searchterm']);

							if (strlen($search) < 3){

								$display .= "<div class='alerterror'>You didn't enter a valid search term</div>";

							}

							else{
								$catresults = $dbase_getters->run_cat_search($search);

								if ($catresults){
									$showresults = "<table cellpadding='4' border='1'><tr><td>SKU</td><td>NAME</td><td>CATEGORY</td></tr>";

									$showresults .= "<tr><td>".$catresults[0]."</td><td>".$catresults[1]."</td><td>".$catresults[2]."</td></tr>";
								}
								else{
									$display .= "<div class='alerterror'>No Results for <b>".$search."</b></div>";
								}
			
							}


						}
					}

					


					$display .= "<div class='newshow'>";
						$display .= "<h2>Enter SKU to search for.</h2>";

						$form_elements = $html_output->hidden_element("uploadfile", 1);
						$form_elements .= $html_output->textbox_element("searchterm");
						$form_elements .= "<p>" .$html_output->create_submit("Search") ."</p>";

						$display .= "<fieldset>" . $html_output->create_form(0, "productinfo.php?import=1", $form_elements) . "</fieldset>";




					$display .= "</div>";


					if (isset($_POST['uploadfile']) && isset($showresults)){
						if ($_POST['uploadfile'] == 1){
							$display .= "<div class='newshow'>";

								$display .= "<h2>Search Results</h2>";
								$display .= $showresults;

							$display .= "</div>";
						}
					}


				}




			}
				






			$display .= "</div>";
			

		$display .= "</div>";
	


	$display .="</body></html>";


	echo $display;


?>

