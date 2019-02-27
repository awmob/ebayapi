<?php


	Class html_output{

		//returns string with password element
		/*
			$name = String with the form element name
			$size = size of textbox
			$style = Name of stylesheet class. default is false.

		*/
		public function password_element($name, $size, $style = false){
			$space = "\r\n";

			if ($style){
				$class = " class='".$style."' ";
			}
			else{
				$class = "";
			}
			

			$textbox = $space . "<input type='password' name='".$name."' ". $class.  ">" . $space;

			return $textbox;
		}



		//Returns string with a series of divs. The div series is ideal for displaying products, images etc. in a series, where we want them to appear the same.

		/*
			$data = single dimensional array of data to put in between div elements
			$style = name of stylesheet class - default is false
			*All divs will have the same style.
		*/

		public function create_series_of_divs($data, $style = false){
			$space = "\r\n";

			if ($style){
				$style_show = " class='".$style."'";
			}
			else{
				$style_show = "";
			}

			$div = "";

			for ($i=0; $i < sizeof($data) ;$i++){
				$div .= $space. "<div".$style_show.">" . $space;
				$div .= $data[$i];
				$div .= $space . "</div>" . $space;

			}

			return $div;

		}


		//returns string with button submit element

		/*
			$value = String with text to dislay on button - default is false
			$type = 0 or 1. 0 = standard, 1 = image. If not set, then defaults to 0 - default is false
			$image_loc = string of image location. Must be included if $type = image. - default is false
			$style = name of stylesheet class - default is false
			* If no variables are set, only standard raw button is returned
		*/


		public function create_submit($value = false, $type = false, $image_loc = false, $style = false){
			$space = "\r\n";

			if ($value){
				$value_show = " value='".$value ."'";
			}
			else{
				$value_show = "";
			}

			//standard button
			if (!$type || $type == 0){
				$button = $space . "<input type='submit' ".$value_show.">" . $space;
			}
			//image button
			else{
				if ($style){
					$style_show = " class='".$style."'";
				}
				else{
					$style_show = "";
				}
				$button = $space . "<input type='image' src='".$image_loc."'".$style_show.">" . $space;

			}

			return $button;

		}


		//returns string with list element

		/*
			$values = Multi dimensional array with names and links [$i][0] = name, [$i][1] = link, - set [$i][1] to false if no link
			$style = name of stylesheet class
			$type = 0 or 1. 0 = unordered list, 1 = ordered list. If not set, then defaults to 0
		*/

		public function list_element($values, $style = false, $type = false){
			$space = "\r\n";

			$list = "";

			if ($style){
				$class = " class='".$style."'";
			}
			else {
				$class = "";
			}

			if (!$type || $type == 0){
				$list_open = "<ul".$class.">";
				$list_close = "</ul>";
			}
			else{
				$list_open = "<ol".$class.">";
				$list_close = "</ol>";
			}

			$list = $space . $list_open . $space;

			for ($i=0; $i <  sizeof($values) ;$i++){
				if ($values[$i][1]){
					$list .= $space . "<li><a href='".$values[$i][1]."'>".$values[$i][0]."</a></li>" .  $space;
				}
				else{
					$list .= $space . "<li>".$values[$i][0]."</li>" .  $space;
				}

			}

			$list .= $space . $list_close . $space;

			return $list;
	
		}


		//returns string with radio element

		/*
			$name = String with the form element name
			$values = Multi dimensional array with values and names [$i][0] = value, [$i][1] = name
		*/

		public function radio_element($name, $values){
			$space = "\r\n";

			$radio = "";

			for ($i=0; $i <  sizeof($values) ;$i++){
				$radio .= $space . "<input type='radio' name='".$name."' value='".$values[$i][0]."'> ".$values[$i][1]."<br>" . $space;

			}

			return $radio;
	
		}


		//returns string with textarea element

		/*
			$name = String with the form element name
			$rows = integer row size of textarea
			$cols = integer column size of textarea 
			$value = value to default enter into textarea. default is false. 
			$style = Name of stylesheet class. default is false.
			$onclick_code = code to run if clicked. default is false.
		*/

		public function textarea_element($name, $rows, $cols, $value = false, $style = false, $onclick_code = false){

			$space = "\r\n";

			if ($style){
				$class = " class='".$style."' ";
			}
			else{
				$class = "";
			}


			if ($onclick_code){
				$onclick = " onClick='".$onclick_code."' ";
			}
			else {
				$onclick = "";
			}

			if ($value){
				$value_text = $value;
			}
			else{
				$value_text = "";
			}

			
			$textarea = $space . "<textarea cols='".$cols."' rows= '".$rows."' name = '" . $name . "' " . $class .$onclick.">".$value_text."</textarea>" . $space;

			return $textarea;

		}



		//returns string with hidden form element

		/*
			$name = String with the form element name
			$value = String value of the form element
		*/

		
		public function hidden_element($name, $value){
			$space = "\r\n";

			$hidden = $space . "<input type='hidden' name='".$name."' value='".$value."'>" . $space;

			return $hidden;
		}


		//returns string with textbox
		/*
			$name = String with the form element name
			$size = size of textbox
			$value = value to default enter into textbox. default is false. 
			$style = Name of stylesheet class. default is false.
			$onclick_code = code to run if clicked. default is false.

		*/
		public function textbox_element($name, $value = false, $style = false, $onclick_code = false){
			$space = "\r\n";

			if ($style){
				$class = " class='".$style."' ";
			}
			else{
				$class = "";
			}


			if ($onclick_code){
				$onclick = " onClick='".$onclick_code."'";
			}
			else {
				$onclick = "";
			}

			if ($value){
				$value_text = " value='" . $value . "' ";
			}
			else{
				$value_text = "";
			}

			$textbox = $space . "<input type='text' name='".$name."' ". $value_text . $class. $onclick . ">" . $space;

			return $textbox;
		}


		//returns string with file upload dialogue
		/*
			$name = String with the form element name
			$style = Name of stylesheet class. default is false.

		*/
		public function file_uploader($name, $max_size, $style = false){
			$space = "\r\n";

			if ($style){
				$class = " class='".$style."' ";
			}
			else{
				$class = "";
			}
			$upload = $space . "<input name='".$name."' type='file' ".$class.">" . $space;
			$upload .= "<input type='hidden' name='MAX_FILE_SIZE' value='".$max_size."'>"  . $space;

			return $upload;
		}


		//returns string with checkbox

		/*
			$name = String with the checkbox name
			$value = String with the value of the checkbox
			$checked = Boolean representing if checkbox is checked. True = checked. False = not checked.
			$onclick_code = code for javascript onclick. optional. Default = false;

		*/

		public function create_checkbox($name, $value, $checked, $onclick_code = false){

			$space = "\r\n";

			if ($checked){
				$checked = " checked ";
			}
			else {
				$checked = "";
			}

			if ($onclick_code){
				$onclick = " onClick='".$onclick_code."'";
			}
			else {
				$onclick = "";
			}

			$checkbox = $space . "<input type='checkbox' name='".$name."' value='".$value."' " . $checked . $onclick. ">" . $space;

			return $checkbox;

		}




		//returns string with form
		
		/*
			$type = Integer representing type of form. 0 = standard form. 1 = file upload form.
			$action = String with name of file to send form data to.
			$data = String with all of the form data and html presentation

		*/

		public function create_form($type, $action, $data){

			$space = "\r\n";


			if ($type == 1){
				$enctype = " enctype='multipart/form-data' ";
			}
			else{
				$enctype = "";
			}

			$form = $space . $space . "<form ".$enctype." method = 'POST' action = '".$action."'>" . $space;

			$form .= $data;

			$form .= $space . "</form>" . $space  . $space ;

			return $form;

		}


		//returns string with dropdown menu
		/*

			$values = multi-dimensional array of values and names -> [$i][0] = value, [$i][1] = display name, [$i][2] = selected status -> true, else false - only one can be true -> true=selected. [$i][3] = onclick submit. true or false. If true then sets auto submit. 
			$select_name = name of variable to post. String.
			$style = name of stylesheet class. String.
		*/

		public function create_dropdown($values, $select_name, $style){
			$space = "\r\n";

			$dropdown = $space. $space. "<select name='".$select_name."' class='".$style."'>" . $space;

			for ($i=0; $i < sizeof($values) ;$i++){
				if ($values[$i][2] == true){
					$selected = " selected ";
				}
				else{
					$selected = "";
				}

				if ($values[$i][3] == true){
					$auto_submit = " onClick='this.form.submit()'";
				}
				else{
					$auto_submit = "";
				}

				$dropdown .= "<option ".$selected." value='".$values[$i][0]."' ".$auto_submit.">".$values[$i][1]."</option>". $space;

			}

			$dropdown .= "</select>". $space. $space;

			return $dropdown;

		}


		//returns string with the table
		/*
			$header_array = single dimensional array -> string values of headers. Can be anything that parses into html.
			$values_array = multidimensional array [$i][$x] -> String values. Can be anything, including html, form elements, etc. [$i] Must be same size as header array
			$header_td_styles = single dimensional array -> contains-> css class name. Must be same size as header_array.
			$values_td_styles = multi dimensional array [$i][$x] -> contains-> css class name. [$x] Must be same size as header_array.
			$table_style = single string -> contains-> css class name

		*/

		public function create_table($header_array, $values_array, $header_td_styles, $values_td_styles, $table_style){

			$space = "\r\n";

			$table = $space. $space. "<table  cellpadding='0' cellspacing='0' border='0' class='".$table_style."'>" . $space;
			
			//header row
			$table.= "<tr>" . $space;

			//loop through header entries to display headers
			for ($i=0; $i < sizeof($header_array)  ;$i++){
				$table .= "<td class='".$header_td_styles[$i]."'>" . $header_array[$i] . "</td>" .$space;

			}

			$table.= "</tr>" . $space;

			//loop over values rows
			for ($i=0; $i < sizeof($values_array) ;$i++){
				$table.= "<tr>" . $space;	
				
				//loop over value entries
				for ($x=0; $x < sizeof($values_array[$i])  ;$x++){
					$table .= "<td class='". $values_td_styles[$i][$x] ."'>" . $values_array[$i][$x] . "</td>" . $space;

				}

				$table.= "</tr>" . $space;
			}

			//subsequent data rows


			$table .= "</table>" .$space .$space;

			return $table;

		}


		public function headermain($title){
			$display = "<!DOCTYPE html><head><title>".$title."</title><link rel='stylesheet' type='text/css' href='http://127.0.0.1/KOKO_LIVING_EBAY_API/ADWORDS/stylesheets/style.css'></head><body>";
			
			$display .= "<div style='min-width:1100px;'>";

				$display .= "<div style='float:left;width:664px;'><a href='".ROOT."'><img src='".ROOT."images/logo.jpg' title='HOME'></a></div>";

				$display .= "<div  style='float:right;width:336px;'><a href='".ROOT."'><img src='".ROOT."images/logob.jpg' title='HOME'></a></div>";

				$display .= "<div style='clear:both;'></div>";

			$display .= "</div>";

			return $display;

		}

		public function linermain(){
			$display = "<div class='linermain'></div>";
			return $display;
		}

		public function linersub(){
			$display = "<div class='linersub'></div>";
			return $display;
		}

		public function newsmain($newsarray, $title){
			//[$i]['date']   [$i]['news']

			$display = "<div class='rightmenu'>";

				$display .= "<h2>".$title."</h2>";

				for ($i=0; $i < sizeof($newsarray)  ;$i++){
					$display .= "<div class='newshow'>";

						$display .= "<b>".$newsarray[$i]['date']."</b>";
						$display .= $newsarray[$i]['news'];

					$display .= "</div>";

				}

			$display .= "</div>";

			return $display; 
		}





		public function check_form_elements($name, $string, $maxlength){
			$string = trim($string);
			$length = strlen($string);

			$error = false;

			if ($length == 0){
				$error = true;
				$string = $name . " is empty.";
			}
			else if($length > $maxlength){
				$error = true;
				$string = $name . " must be no longer than " . $maxlength . " characters.";
			}

			$error_arr = array();

			$error_arr[0] = $error;
			$error_arr[1] = $string;

			return $error_arr;
		}



	}



?>