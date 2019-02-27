<?php


	require_once 'config/constants/constants.inc.php';
	require_once FILE_SYSTEM_HTML_OUTPUT_CALLER;
	require_once FILE_SYSTEM_DBASE_CALL;

	$display = $html_output->headermain("Stock & Dropshipper Types - SoldSmart Management Tools");


	

		$display .= "<div class='wrappermain'>";

			$display .= "<h1>Stock & Dropshipper Types</h1>";

			
			

			$display .= "<div class='leftmenu'>";

				//dropshipper types

				$display .= "<div>";

					$display .= "<h2>Dropshippers</h2>";

					$display .= "<a href='stocktypes.php?showds=1'>View All Existing Dropshippers</a>";

				$display .= "</div>";
				
				
				$form_elements = "<h3>Add New Dropshipper</h3>";
				
				if (isset($_POST['dsprefix'])){
					$form_elements .= $html_output->textbox_element("dsprefix", $_POST['dsprefix']) . "<br/>Enter Dropshipper 3 digit prefix";
				}
				else{
					$form_elements .= $html_output->textbox_element("dsprefix") . "<br/>Enter Dropshipper 3 digit prefix";
				}

				$form_elements .= $html_output->linersub();

				if (isset($_POST['dsname'])){
					$form_elements .= $html_output->textbox_element("dsname", $_POST['dsname']) . "<br/>Enter Dropshipper Name";
				}
				else{

					$form_elements .= $html_output->textbox_element("dsname") . "<br/>Enter Dropshipper Name";
				}

				$form_elements .= $html_output->linersub();

				$ds_drop_value[0][0] = DS_SET_ACTIVE;
				$ds_drop_value[0][1] = "Active";
				$ds_drop_value[0][2] = true;
				$ds_drop_value[0][3] = false;
				$ds_drop_value[1][0] = DS_SET_INACTIVE;
				$ds_drop_value[1][1] = "Inactive";
				$ds_drop_value[1][2] = false;
				$ds_drop_value[1][3] = false;

				$form_elements .= $html_output->create_dropdown($ds_drop_value, "ds_status", "") . "&nbsp;&nbsp;Dropshipper Active Status";;

				$form_elements .= $html_output->linersub();


				$ds_drop_value[0][0] = 0;
				$ds_drop_value[0][1] = "No";
				$ds_drop_value[0][2] = true;
				$ds_drop_value[0][3] = false;
				$ds_drop_value[1][0] = 1;
				$ds_drop_value[1][1] = "Yes";
				$ds_drop_value[1][2] = false;
				$ds_drop_value[1][3] = false;

				$form_elements .= $html_output->create_dropdown($ds_drop_value, "ebay_status", "") . "&nbsp;&nbsp;Make Available on eBay";;

				$form_elements .= $html_output->linersub();



				$form_elements .= $html_output->create_submit("Add New Dropshipper");



				$form_elements .= $html_output->hidden_element("dstypeadd", "1");

				$display .= "<fieldset>" . $html_output->create_form(0, "stocktypes.php?showds=1", $form_elements) . "</fieldset>";


				$display .= $html_output->linermain();

				
				//stock types

				$display .= "<div>";
					$display .= "<h2>Stock Types</h2>";

					$display .= "<a href='stocktypes.php?vs=1'>View Stock Types</a>";

				$display .= "</div>";
				$display .= $html_output->linermain();



			$display .= "</div>";
			

			$display .= "<div class='rightmenu'>";

				$form_message = "";
			
				//system messages
				if (isset($_POST['dstypeadd'])){
					if ($_POST['dstypeadd'] == "1"){
						//check the fields
						//check prefix
						$ds_prefix_arr = $html_output->check_form_elements("Dropshipper Prefix", $_POST['dsprefix'], 3);
						$ds_name_arr = $html_output->check_form_elements("Dropshipper Name", $_POST['dsname'], 20);
						
						//error
						if ($ds_prefix_arr[0] || $ds_name_arr[0]){
							$display .= "<div class='alerterror'>";
								$display .= "<h2>Input Error</h2>";
								
								if ($ds_prefix_arr[0]){
									$display .= $ds_prefix_arr[1];
									$display .= "<br/>";
								}
								
								if ($ds_name_arr[0]){
									$display .= $ds_name_arr[1];
									$display .= "<br/>";
								}
								$display .= "<strong>".FORM_RESUBMIT_MSG."</strong>";

							$display .= "</div>";
						}

						else{
							//check if data exists on database
							$prefix = $ds_prefix_arr[1];
							$name = $ds_name_arr[1];
							
							$selectcols = array();

							$selectcols[0] = DS_TYPES_TABLE_PREFIX;
							$selectcols[1] = DS_TYPES_TABLE_NAME;

							//get prefix & name
							$where_cols[0][0] = DS_TYPES_TABLE_PREFIX;
							$where_cols[0][1] = $prefix;


							$prefix_details = $dbase_getters->basic_get(DS_TYPES_TABLE, $selectcols, $where_cols, "", "");

							$where_cols[0][0] = DS_TYPES_TABLE_NAME;
							$where_cols[0][1] = $name;
							$name_details = $dbase_getters->basic_get(DS_TYPES_TABLE, $selectcols, $where_cols, "", "");

							
							if(sizeof($prefix_details[DS_TYPES_TABLE_PREFIX]) > 0 || sizeof($prefix_details[DS_TYPES_TABLE_NAME]) > 0 ){
								$display .= "<div class='alerterror'>";
									$display .= "<h2>Data Error</h2>";

									if(sizeof($prefix_details[DS_TYPES_TABLE_PREFIX]) > 0){
										$display .= "That prefix already exists. Choose another.";
										$display .= "<br/>";
									}
									if(sizeof($prefix_details[DS_TYPES_TABLE_NAME]) > 0){
										$display .= "That dropshipper name already exists. Choose another.";
										$display .= "<br/>";
									}

									$display .= "<strong>".FORM_RESUBMIT_MSG."</strong>";
									$display .= "<br/>";

								$display .= "</div>";
							}
							else{

								//add to the database
								$setcols[0][0] = DS_TYPES_TABLE_PREFIX;
								$setcols[0][1] = $prefix;

								$setcols[1][0] = DS_TYPES_TABLE_NAME;								
								$setcols[1][1] = $name;

								$setcols[2][0] = DS_TYPES_ACTIVE;								
								$setcols[2][1] = $_POST['ds_status'];

								$setcols[3][0] = DS_TYPES_MIN_SS_STOCK;								
								$setcols[3][1] = DEFAULT_SS_BUFFER;

								$setcols[4][0] = DS_TYPES_MIN_EBAY_STOCK;								
								$setcols[4][1] = DEFAULT_EBAY_BUFFER;

								$setcols[5][0] = DS_TYPES_EBAY_LIST;								
								$setcols[5][1] = $_POST['ebay_status'];
								

								

								//$setcols[1][0] = DS_TYPES_ACTIVE;								
								//$setcols[1][1] = 1;

								$dbase_setters->insert_query(DS_TYPES_TABLE, $setcols);

								//display success
								$display .= "<div class='alertok'>";
								$display .=	FORM_SUBMIT_OKMSG;
								$display .= "</div>";
							}
						}
					}
				}// end type add POST


				
				$display .= $form_message;



				//show lists
				if (isset($_GET['showds'])){
					$display .= "<div class='newshow'>";
						$display .= "<h2>Dropshippers List</h2>";

						$display .= "<p>To modify or delete any of the values below, please contact admin.</p>";
						
						$header_array = array();
						$header_array[0] = "Prefix";
						$header_array[1] = "Dbase ID";
						$header_array[2] = "Name";
						$header_array[3] = "Active Status";
						$header_array[4] = "SS Min Stock Buffer";
						$header_array[5] = "eBay Min Stock Buffer";
						$header_array[6] = "Allow on eBay";

						$values_array = array();

						$selectcols = array();

						$selectcols[0] = DS_TYPES_TABLE_PREFIX;
						$selectcols[1] = DS_TYPES_TABLE_NAME;
						$selectcols[2] = DS_TYPES_ACTIVE;
						$selectcols[3] = DS_TYPES_MIN_SS_STOCK;
						$selectcols[4] = DS_TYPES_MIN_EBAY_STOCK;
						$selectcols[5] = DS_TYPES_EBAY_LIST;
						$selectcols[6] = DS_TYPES_TABLE_ID;


						
						$order = array();
						$order[0][0] = DS_TYPES_TABLE_PREFIX;
						$order[0][1] = 0;

						//get data
						$dstypeget = $dbase_getters->basic_get(DS_TYPES_TABLE, $selectcols, false, $order, false);


						//presentation table array for subtds
						$subtdclasses = array();

						for ($x=0; $x < sizeof($dstypeget[DS_TYPES_TABLE_PREFIX])  ;$x++){
							$values_array[$x][0] = $dstypeget[DS_TYPES_TABLE_PREFIX][$x];
							$values_array[$x][1] = $dstypeget[DS_TYPES_TABLE_ID][$x];
							$values_array[$x][2] = $dstypeget[DS_TYPES_TABLE_NAME][$x];
							$values_array[$x][3] = $dstypeget[DS_TYPES_ACTIVE][$x];
							$values_array[$x][4] = $dstypeget[DS_TYPES_MIN_SS_STOCK][$x];
							$values_array[$x][5] = $dstypeget[DS_TYPES_MIN_EBAY_STOCK][$x];
							$values_array[$x][6] = $dstypeget[DS_TYPES_EBAY_LIST][$x];

							$subtdclasses[$x][0] = "tdmain";
							$subtdclasses[$x][1] = "tdmain";
							$subtdclasses[$x][2] = "tdmain";
							$subtdclasses[$x][3] = "tdmain";
							$subtdclasses[$x][4] = "tdmain";
							$subtdclasses[$x][5] = "tdmain";
							$subtdclasses[$x][6] = "tdmain";


						}
						

						//set the table
						$headstyle = array();
						$headstyle[0] = "tdheader";
						$headstyle[1] = "tdheader";
						$headstyle[2] = "tdheader";
						$headstyle[3] = "tdheader";
						$headstyle[4] = "tdheader";
						$headstyle[5] = "tdheader";
						$headstyle[6] = "tdheader";



						$display .= $html_output->create_table($header_array, $values_array, $headstyle, $subtdclasses, "");
					$display .= "</div>";
				}
				else if (isset($_GET['vs'])){

					$display .= "<div class='newshow'>";
						$display .= "<h2>Stock Types List</h2>";

						$selectcols = array();
						$selectcols[0] = DS_STOCK_TYPES_ID;
						$selectcols[1] = DS_STOCK_TYPES_NAME;
						

						$order = array();
						$order[0][0] = DS_STOCK_TYPES_ID;
						$order[0][1] = 0;

						$stocktypeeget = $dbase_getters->basic_get(DS_STOCK_TYPES_TABLE, $selectcols, false, $order, false);


						//presentation table array for subtds
						$subtdclasses = array();

						for ($x=0; $x < sizeof($stocktypeeget[DS_STOCK_TYPES_ID])  ;$x++){
							$values_array[$x][0] = $stocktypeeget[DS_STOCK_TYPES_ID][$x];
							$values_array[$x][1] = $stocktypeeget[DS_STOCK_TYPES_NAME][$x];
							

							$subtdclasses[$x][0] = "tdmain";
							$subtdclasses[$x][1] = "tdmain";
							


						}
						

						//set the table
						$headstyle = array();
						$headstyle[0] = "tdheader";
						$headstyle[1] = "tdheader";
						

						$header_array = array();
						$header_array[0] = "Numeric ID";
						$header_array[1] = "Type Name";
						

						$display .= $html_output->create_table($header_array, $values_array, $headstyle, $subtdclasses, "");


					$display .= "</div>";
					
				}



			$display .= "</div>";
			

		$display .= "</div>";
	


	$display .="</body></html>";


	echo $display;


	function checkdstypes($prefix, $name){
		
	}



?>