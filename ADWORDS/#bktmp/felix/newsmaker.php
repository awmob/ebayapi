<?php
	
	require_once 'config/constants/constants.inc.php';
	require_once FILE_SYSTEM_HTML_OUTPUT_CALLER;

	require_once('includes/text_template.php');


	define('INPUT_FILES','input_files/');
	define('INCLUDES_FOLDER','includes/');

	$textdoc = $text_top;

	define('TOP_FILE_PATH', INPUT_FILES. 'top_file.csv');
	define('CAT_FILE_PATH', INPUT_FILES. 'cat_file.csv');
	define('DOZ_FILE_PATH', INPUT_FILES. 'doz_file.csv');
	define('BOTTOM_ITEM_FILE_PATH', INPUT_FILES. 'bot_file.csv');
	define('DEAL_FILE_PATH', INPUT_FILES. 'deal_file.csv');

	define('DOZEN_TEMPLATE', INCLUDES_FOLDER. 'dozen_template.inc.php');
	define('MAIN_TEMPLATE', INCLUDES_FOLDER. 'main_template.inc.php');
	define('DEAL_TEMPLATE', INCLUDES_FOLDER. 'dealitems.inc.php');

	
	//define('MORE_DISCOUNTS_TEMPLATE', INCLUDES_FOLDER. 'more_discounts.inc.php');

	//for matching the extra items
	define('TEMPLATE_HELPER_LINK','http://www.soldsmart.com.au/test/test4.aspx');
	define('TEMPLATE_HELPER_PATTERN',"#<table style='FONT-FAMILY:arial;FONT-SIZE: 11px;'.+</td></tr></TBODY></TABLE></TD>#");
	
	
	define('NS',"\r\n");	
 	define('TAB_DELIM','	');

	//stores the link macros for categories
	$cat_link_macro_array[0] = "%CATALINK%";
	$cat_link_macro_array[1] = "%CATBLINK%";
	$cat_link_macro_array[2] = "%CATCLINK%";
	$cat_link_macro_array[3] = "%CATDLINK%";
	$cat_link_macro_array[4] = "%CATELINK%";

	//stores the name macros for categories
	$cat_name_macro_array[0] = "%CATANAME%";
	$cat_name_macro_array[1] = "%CATBNAME%";
	$cat_name_macro_array[2] = "%CATCNAME%";
	$cat_name_macro_array[3] = "%CATDNAME%";
	$cat_name_macro_array[4] = "%CATENAME%";
	
	//define top image constants
	define('ITEM_A_LINK','%ITEMALINK%');
	define('ITEM_A_IMG','%ITEMAIMG%');
	define('ITEM_A_ALT','%ITEMAALT%');
	define('TOPIMHT','%TOPIMHT%');
	
	//define feature constants

	
	define('FEAT_DEAL_ITEMS','%DEALITEMS%');

	define('FEAT_A_LINK','%FEATITEMALINK%');
	define('FEAT_A_IMG','%FEATITEMAIMG%');
	define('FEAT_A_TITLE','%FEATITEMATITLE%');
	define('FEAT_A_PRICE','%FEATITEMAPRICE%');

	define('FEAT_B_LINK','%FEATITEMBLINK%');
	define('FEAT_B_IMG','%FEATITEMBIMG%');
	define('FEAT_B_TITLE','%FEATITEMBTITLE%');
	define('FEAT_B_PRICE','%FEATITEMBPRICE%');



	//define dozen constants
	define('DOZEN_ITEMS','%DOZENITEMS%');

	define('DOZEN_LINK_A','%DOZEN_LINK_A%');
	define('DOZEN_LINK_B','%DOZEN_LINK_B%');
	define('DOZEN_LINK_C','%DOZEN_LINK_C%');

	define('DOZEN_IMG_A','%DOZEN_IMAGE_A%');
	define('DOZEN_IMG_B','%DOZEN_IMAGE_B%');
	define('DOZEN_IMG_C','%DOZEN_IMAGE_C%');

	define('DOZEN_ALT_A','%DOZEN_ALT_A%');
	define('DOZEN_ALT_B','%DOZEN_ALT_B%');
	define('DOZEN_ALT_C','%DOZEN_ALT_C%');

	define('DOZ_TOP_IMG_A','%DOZ_TOP_IMG_A%');
	define('DOZ_TOP_IMG_B','%DOZ_TOP_IMG_B%');
	define('DOZ_TOP_IMG_C','%DOZ_TOP_IMG_C%');

	define('DOZ_BOT_IMG_A','%DOZ_BOT_IMG_A%');
	define('DOZ_BOT_IMG_B','%DOZ_BOT_IMG_B%');
	define('DOZ_BOT_IMG_C','%DOZ_BOT_IMG_C%');

	define('ITEM_TITLE_A','%ITEM_TITLE_A%');
	define('ITEM_TITLE_B','%ITEM_TITLE_B%');
	define('ITEM_TITLE_C','%ITEM_TITLE_C%');

	define('ITEM_PRICE_A','%ITEM_PRICE_A%');
	define('ITEM_PRICE_B','%ITEM_PRICE_B%');
	define('ITEM_PRICE_C','%ITEM_PRICE_C%');
	
	define('ITEM_PRICE_AB','%ITEM_PRICE_AB%');
	define('ITEM_PRICE_BB','%ITEM_PRICE_BB%');
	define('ITEM_PRICE_CC','%ITEM_PRICE_CC%');

	
	define('ITEM_PRICE_DIFFA','%ITEM_PRICE_DIFFA%');
	define('ITEM_PRICE_DIFFB','%ITEM_PRICE_DIFFB%');
	define('ITEM_PRICE_DIFFC','%ITEM_PRICE_DIFFC%');
	
	

	define('BOT_HEAD','%BOT');


	define('MORE_DISCOUNTS','%MOREDISCOUNTS%');
	


	require_once(DOZEN_TEMPLATE);
	require_once(MAIN_TEMPLATE);
	require_once(DEAL_TEMPLATE);
	


	$display = $html_output->headermain("Newsletter Maker - SoldSmart Management Tools");

	echo $display;
	flush();
	ob_flush();





	$display = "<div class='wrappermain'>";


	if (isset($_GET['page'])){
		$display .= "<h1>Newsletter Maker - Download Centre</h1>";
	}
	else{
		$display .= "<h1>Newsletter Maker</h1>";
	}

	$display .= "<div class='leftmenu'>";

		//create list of entries
		$page[0][0] = "Main Newsletter Maker";
		$page[0][1] = "newsmaker.php";

		$display .= $html_output->list_element($page);
		

		$display .= $html_output->linermain();

		//create list of entries
		$pagex[0][0] = "Newsletter Download Centre";
		$pagex[0][1] = "newsmaker.php?page=2";	

		$display .= $html_output->list_element($pagex,false,0);




		
		$display .= "</div>";




		$display .= "<div class='rightmenu'>";

			if (isset($_GET['page'])){
				
				//clear the files from the folders if form has been posted
				if (isset($_POST['cleardl'])){
					$files = glob(HTMLNEWSOUTPUT_FOLDER.'*'); // get all file names
					foreach($files as $file){ // iterate files
					  if(is_file($file))
						unlink($file); // delete file
					}

					$files = glob(TEXTNEWSOUTPUT_FOLDER.'*'); // get all file names
					foreach($files as $file){ // iterate files
					  if(is_file($file))
						unlink($file); // delete file
					}

					$display .= "<div class='alertok'>All Files Have Been Deleted.</div>";
				}

				


				$display .= "<div class='newshow'>";

				$display .= "<h2>Clear the Download Centre</h2>";

				$form_elements = $html_output->hidden_element("cleardl", 1);
				$form_elements .= "<p>" .$html_output->create_submit("Delete all Files") ."</p>";

				$display .= $html_output->create_form(0, "newsmaker.php?page=2", $form_elements);



				$display .= $html_output->linermain();

				//file section
				$html_dircontents = scandir(HTMLNEWSOUTPUT_FOLDER);

				$pagedr = array();

				for ($i=2; $i < sizeof($html_dircontents);$i++){
					$z = $i-2;

					$pagedr[$z][0] = $html_dircontents[$i];
					$pagedr[$z][1] = HTTP_HTMLNEWSOUTPUT_FOLDER . $html_dircontents[$i];

				}
				
				$display .= "<h2>Newsletter HTML Files</h2>";

				if (sizeof($pagedr) < 1){
					$display .= "There are no files";
				}
				else{

					$display .= $html_output->list_element($pagedr,false,0);
				}

				$display .= $html_output->linermain();




				$txt_dircontents = scandir(TEXTNEWSOUTPUT_FOLDER);

				$pagedrb = array();

				for ($i=2; $i < sizeof($txt_dircontents);$i++){

					$z = $i-2;
					$pagedrb[$z][0] = $txt_dircontents[$i];
					$pagedrb[$z][1] = HTTP_TEXTNEWSOUTPUT_FOLDER . $txt_dircontents[$i];

				}

				$display .= "<h2>Newsletter Text Files</h2>";


				if (sizeof($pagedrb) < 1){
					$display .= "There are no files";
				}
				else{

					$display .= $html_output->list_element($pagedrb,false,0);
				}

				$display .= $html_output->linermain();


				$display .= "</div>";
			}

				
			//import section
			else{

				$newsarray = array();
				$newsarray[0]['date'] = "Process Order";
				$newsarray[0]['news'] = "<ul><li>Files should be imported following the same numerical order of the menu to the left.</li></ul>";


				$display .= $html_output->newsmain($newsarray, "Useful Information");

				
			}


	$display .= "</div>";


	

	//if there is no name entered do not process, otherwise perform all of the functions
	if (isset($_POST['process'])){
		if (trim($_POST['filename']) == ""){
			echo "<p style='color:red'>You need to enter a filename. File not created.</p>";
		}
		else{

			//set the filename 
			$mainfilename = $_POST['filename'] . ".html";

			$maintemplate = str_replace("#VIEWMAILER#", $mainfilename, $maintemplate);


			//#VIEWMAILER#

			//read the categories file:
			$cat_main_file = file_get_contents(CAT_FILE_PATH);
			$catlines = explode(NS, $cat_main_file);
			//loop trough each line

			$textdoc .= "Featured Categories\r\n\r\n";
			
			for ($i=0; $i < sizeof($catlines) ;$i++){
				$cat_bits = explode(TAB_DELIM, $catlines[$i]);

				//replace the macros in the main template
				$maintemplate = str_replace($cat_name_macro_array[$i], $cat_bits[0], $maintemplate);
				$maintemplate = str_replace($cat_link_macro_array[$i], $cat_bits[1], $maintemplate);

				//enter into text
				$textdoc .= "[%url:unique-count(action!1); \"".$cat_bits[1]."&cam=58\"; \"".$cat_bits[0]."\"]\r\n";

			}

			$textdoc .= $text_thick_line;

			//FINISHED ADDING CATEGORIES

			//NOW ADD THE TOP PROMO
			$topfile = file_get_contents(TOP_FILE_PATH);
			$top_file_bits = explode(TAB_DELIM, $topfile);

			$maintemplate = str_replace(ITEM_A_IMG, $top_file_bits[0], $maintemplate);
			$maintemplate = str_replace(ITEM_A_LINK, $top_file_bits[1], $maintemplate);
			$maintemplate = str_replace(ITEM_A_ALT, $top_file_bits[2], $maintemplate);

			$img = "http://www.soldsmart.com.au/files/" . $top_file_bits[0];

			//get and set image height
			$size = getimagesize($img);
			$topimgheight = $size[1];
			$maintemplate = str_replace(TOPIMHT, $topimgheight, $maintemplate);


//TOPIMHT
			//FINISHED ADDING TOP PROMO


			$textdoc .= "Featured Products";


			//NOW ADD THE FEATURED
			$deal_main_file = file_get_contents(DEAL_FILE_PATH);
			$deallines = explode(NS, $deal_main_file);

			//set main deal code
			$main_deals_code = "";
			$temp_deals_code = "";

			if (trim($deal_main_file) != ""){
				//loop trough each line
				for ($i=0; $i < sizeof($deallines)  ;$i++){
					$deal_bits = explode(TAB_DELIM, $deallines[$i]);

					$dealtitle = $deal_bits[0];
					$deallink = $deal_bits[1];
					$dealimg = $deal_bits[2];
					$dealprice = $deal_bits[3];


					//set text document details
					$textdoc .= $text_line ."\r\n";

					$textdoc .= $dealtitle . "\r\n";
					$textdoc .= "Our Price $" . $dealprice . "\r\n";
					$textdoc .= "[%url:unique-count(action!1); \"".$deallink."&cam=58\"]\r\n";

					//set the deals
					//use new template piece if 
					if ($i % 2 == 0){
						$temp_deals_code = $dealitemstemplate;

						$temp_deals_code = str_replace(FEAT_A_LINK,$deallink, $temp_deals_code);
						$temp_deals_code = str_replace(FEAT_A_TITLE,$dealtitle, $temp_deals_code);
						$temp_deals_code = str_replace(FEAT_A_IMG,$dealimg, $temp_deals_code);
						$temp_deals_code = str_replace(FEAT_A_PRICE,$dealprice, $temp_deals_code);
					}


					//set new line
					else if ($i % 2 == 1){
					
						$temp_deals_code = str_replace(FEAT_B_LINK,$deallink, $temp_deals_code);
						$temp_deals_code = str_replace(FEAT_B_TITLE,$dealtitle, $temp_deals_code);
						$temp_deals_code = str_replace(FEAT_B_IMG,$dealimg, $temp_deals_code);
						$temp_deals_code = str_replace(FEAT_B_PRICE,$dealprice, $temp_deals_code);

						$main_deals_code .= $temp_deals_code;

						
					}

					

					

				}

				//replace the dozen macro in main template with the main dozen code
				$maintemplate = str_replace(FEAT_DEAL_ITEMS,$main_deals_code, $maintemplate);
			}

			else{
				$maintemplate = str_replace(FEAT_DEAL_ITEMS,"", $maintemplate);
			}

			//NOW ADD THE DOZENS
			$doz_main_file = file_get_contents(DOZ_FILE_PATH);

			if (trim($doz_main_file) != ""){

			
				$dozlines = explode(NS, $doz_main_file);

				//set main dozen code
				$main_dozen_code = "";
				$temp_dozen_code = "";



				//loop trough each line		
				for ($i=0; $i < sizeof($dozlines)  ;$i++){
					$doz_bits = explode(TAB_DELIM, $dozlines[$i]);

					//set text document details
					$textdoc .= $text_line ."\r\n";

					$textdoc .= $doz_bits[6] . "\r\n";
					$textdoc .= "Our Price $" . $doz_bits[5] . "\r\n";
					$textdoc .= "RRP $" . $doz_bits[7] . "\r\n";
					$textdoc .= "Save $" . abs(round(($doz_bits[7] - $doz_bits[5]), 2, PHP_ROUND_HALF_UP)) . "\r\n";


					$textdoc .= "[%url:unique-count(action!1); \"".$doz_bits[0]."&cam=58\"]\r\n";

					//use new template piece if 
					if ($i % 3 == 0){
						$temp_dozen_code = $dozentemplate;
						$temp_dozen_code = str_replace(DOZEN_LINK_A,$doz_bits[0], $temp_dozen_code);
						$temp_dozen_code = str_replace(DOZEN_IMG_A,$doz_bits[1], $temp_dozen_code);
						$temp_dozen_code = str_replace(DOZEN_ALT_A,$doz_bits[2], $temp_dozen_code);
						$temp_dozen_code = str_replace(DOZ_BOT_IMG_A,$doz_bits[3], $temp_dozen_code);
						$temp_dozen_code = str_replace(DOZ_TOP_IMG_A,$doz_bits[4], $temp_dozen_code);

						$temp_dozen_code = str_replace(ITEM_TITLE_A,$doz_bits[6], $temp_dozen_code);
						$temp_dozen_code = str_replace(ITEM_PRICE_A,$doz_bits[5], $temp_dozen_code);

						$temp_dozen_code = str_replace(ITEM_PRICE_AB,$doz_bits[7], $temp_dozen_code);

						$temp_pricediff_a = abs(round(($doz_bits[7] - $doz_bits[5]), 2, PHP_ROUND_HALF_UP));
						$temp_dozen_code = str_replace(ITEM_PRICE_DIFFA,$temp_pricediff_a, $temp_dozen_code);

						
						
						
					}
					//set new line
					else if ($i % 3 == 1){
						$temp_dozen_code = str_replace(DOZEN_LINK_B,$doz_bits[0], $temp_dozen_code);
						$temp_dozen_code = str_replace(DOZEN_IMG_B,$doz_bits[1], $temp_dozen_code);
						$temp_dozen_code = str_replace(DOZEN_ALT_B,$doz_bits[2], $temp_dozen_code);
						$temp_dozen_code = str_replace(DOZ_BOT_IMG_B,$doz_bits[3], $temp_dozen_code);
						$temp_dozen_code = str_replace(DOZ_TOP_IMG_B,$doz_bits[4], $temp_dozen_code);

						$temp_dozen_code = str_replace(ITEM_TITLE_B,$doz_bits[6], $temp_dozen_code);
						$temp_dozen_code = str_replace(ITEM_PRICE_B,$doz_bits[5], $temp_dozen_code);
						$temp_dozen_code = str_replace(ITEM_PRICE_BB,$doz_bits[7], $temp_dozen_code);

						$temp_pricediff_b = abs(round(($doz_bits[7] - $doz_bits[5]), 2, PHP_ROUND_HALF_UP));
						$temp_dozen_code = str_replace(ITEM_PRICE_DIFFB,$temp_pricediff_b, $temp_dozen_code);

						
					}


					else if ($i % 3 == 2){
						$temp_dozen_code = str_replace(DOZEN_LINK_C,$doz_bits[0], $temp_dozen_code);
						$temp_dozen_code = str_replace(DOZEN_IMG_C,$doz_bits[1], $temp_dozen_code);
						$temp_dozen_code = str_replace(DOZEN_ALT_C,$doz_bits[2], $temp_dozen_code);
						$temp_dozen_code = str_replace(DOZ_BOT_IMG_C,$doz_bits[3], $temp_dozen_code);
						$temp_dozen_code = str_replace(DOZ_TOP_IMG_C,$doz_bits[4], $temp_dozen_code);

						$temp_dozen_code = str_replace(ITEM_TITLE_C,$doz_bits[6], $temp_dozen_code);
						$temp_dozen_code = str_replace(ITEM_PRICE_C,$doz_bits[5], $temp_dozen_code);
						$temp_dozen_code = str_replace(ITEM_PRICE_CC,$doz_bits[7], $temp_dozen_code);

						$temp_pricediff_b = abs(round(($doz_bits[7] - $doz_bits[5]), 2, PHP_ROUND_HALF_UP));
						$temp_dozen_code = str_replace(ITEM_PRICE_DIFFC,$temp_pricediff_b, $temp_dozen_code);

						$main_dozen_code .= $temp_dozen_code;
					}



				}

				//replace the dozen macro in main template with the main dozen code
				$maintemplate = str_replace(DOZEN_ITEMS,$main_dozen_code, $maintemplate);
			}
			else{
				$maintemplate = str_replace(DOZEN_ITEMS,"", $maintemplate);
			}

			

			


		}

		//save the file
		$maintemplate = stripslashes($maintemplate);
		//now save
		$file_path = HTMLNEWSOUTPUT_FOLDER . $_POST['filename'] . ".html";
		$fh = fopen($file_path, 'w') or die("can't open file");
		fwrite($fh, $maintemplate);
		fclose($fh);


		//save the text
		$textdoc .= $text_bot;
		$textdoc = str_replace("	","",$textdoc);
		$file_path = TEXTNEWSOUTPUT_FOLDER . $_POST['filename'] . ".txt";
		$fh = fopen($file_path, 'w') or die("can't open file");
		fwrite($fh, $textdoc);
		fclose($fh);

		echo "<p style='color:green'><b>" . $_POST['filename'] . ".html and .txt have been created.</b></p>";
	}	








/*
	echo "<h3>Top Image file</h3>";
	echo "<p>Upload " . TOP_FILE_PATH . ". with 1 promo. Format-> <b>Image <span style='color:grey;'>TAB</span> Link</b>  <span style='color:grey;'>TAB</span><b> ALT</b></p>";

	echo "<h3>5 Categories</h3>";
	echo "<p>Upload " . CAT_FILE_PATH . ". with 5 categories. Format-> <b>Category Name <span style='color:grey;'>TAB</span> Category Link</b></p>";

	echo "<h3>Item Promos in Rows of 3</h3>";
	echo "<p>Upload " . DOZ_FILE_PATH . ". Items in multiples of 3. Format-> <b>Dozen Link <span style='color:grey;'>TAB</span> Dozen Image <span style='color:grey;'>TAB</span> Dozen Alt</b> <b><span style='color:grey;'>TAB</span> Start End Times Image</b><b><span style='color:grey;'>TAB</span> 12 / 24 Hr Deal Top Img</b><b><span style='color:grey;'>TAB</span> PRICE</b><b><span style='color:grey;'>TAB</span> Item Name</b></p>";

	echo "<h3>Featured Items in Rows of 2</h3>";
	echo "<p>Upload " . DEAL_FILE_PATH . ". Items in multiples of 2. Format-> <b>Item Name <span style='color:grey;'>TAB</span> Item Link <span style='color:grey;'>TAB</span> Item Image full URL</b> <b><span style='color:grey;'>TAB</span> Item Disprice</b></p>";

	echo "<h3>Bottom Items (deprecated)</h3>";
	echo "<p>Upload " . BOTTOM_ITEM_FILE_PATH . ". Format-> <b>SKU</b></p>";

	
	echo "<hr>";


	echo "<form method = 'POST' action ='index.php'>";
	echo "<b>Enter the newsletter filename</b> (no need for .html)<input type='text' size='30' name='filename'>";
	echo "<input type='hidden' name='process' value='1'>";
	echo "<input type='submit' value='Create Newsletter'>";
	echo "</form>";	



*/




	echo $display;
	flush();
	ob_flush();









?>