<?php


	Class feed_reader{

		private $feed_reader_config_error_messages;


		function __construct($feed_reader_config_error_messages){
			$this->feed_reader_config_error_messages = $feed_reader_config_error_messages;

		}

		//Creates and returns single dimensional array with separated lines from feed

		/*
			$feed_file_data -> String feed data with separated lines
			$line_delimiter -> Desired line delimiter -> selected from config $feed_reader_config['line_delimiter'][$i]

		*/
		
		public function break_feed_lines($feed_file_data, $line_delimiter){
			echo "Separating data into lines. . . ";
			flush();
			ob_flush();

			$feed_lines = explode($line_delimiter, $feed_file_data);
			return $feed_lines;
		}


		/*Creates and returns multi dimensional array $lines_and_bits with separated lines from feed. Entries are trimmed. 
		First entry in $lines_and_bits[0] will contain error associative array. 

		$error['error_exists'] = false;
		$error['error_ends_upload'] = false;
		$error['error_message'] = "";

		Subsequent entries in $lines_and_bits[$i] will contain array of data elements if they exist, and if there are no errors. If there are errors and type 1 is chosen, upload has been halted, and array will only contain errors, and no lines. If there are errors and type 0 is chosen, the upload has been allowed, and the array will contain the allowed lines, if they exist.

		*/

		/*
			$feed_lines -> Single dimensional array with lines from the feed
			$space_delim -> Desired space delimiter -> selected from config $feed_reader_config['element_delimiter'][$i]
			$type -> Type of upload. Type 0 - allows skipping of lines with incorrect number of elements, type 1 halts upload altogether if lines do not contain correct number of elements
		*/

	
		public function break_up_feed_lines_and_clean($feed_lines, $space_delim, $type){
			echo "Separating lines into columns. . . ";
			flush();
			ob_flush();
			
			$error['error_exists'] = false;
			$error['error_ends_upload'] = false;
			$error['error_message'] = "";

			//array to return entries
			$lines_and_bits[0] = $error;

			//check number of lines in feed. There must be more than one line. If only 1 line then end and return error, otherwise continue
			if (sizeof($feed_lines) <= 1){
				$error['error_exists'] = true;
				$error['error_ends_upload'] = true;
				$error['error_message'] = $this->feed_reader_config_error_messages['one_line'];
				$lines_and_bits[0] = $error;

				return $lines_and_bits;
			}

			else{
				//feed bits must all be the same count - use first line as the base
				$main_bits_count = sizeof(explode($space_delim, $feed_lines[0]));

				for ($i=0; $i < sizeof($feed_lines) ;$i++){
					if ($i % 100  == 0){
						echo ". ";
						flush();
						ob_flush();
					}

					$bits = explode($space_delim, $feed_lines[$i]);

					

					//set errors
					if (sizeof($bits) != $main_bits_count){
						
						//skip line
						if ($type == 0){
							$error['error_exists'] = true;
							$error['error_message'] .= $this->feed_reader_config_error_messages['error_line_prefix'] . ($i+1) . $this->feed_reader_config_error_messages['wrong_num_not_added_columns'];

							//enter updated error data into main array
							$lines_and_bits[0] = $error;
						}

						//end the upload if number of bits does not correspond to first line
						else if($type == 1){
							$error['error_exists'] = true;
							$error['error_ends_upload'] = true;	
							$error['error_message'] = $this->feed_reader_config_error_messages['error_line_prefix'] . ($i+1) . $this->feed_reader_config_error_messages['wrong_num_not_uploaded_columns'];

							//reset the main array with errors only
							$lines_and_bits = array();
							$lines_and_bits[0] = $error;

							return $lines_and_bits;
							break;

						}
					}
					else{
						//trim bits
						for ($x=0; $x < sizeof($bits) ;$x++){
							$bits[$x] = trim($bits[$x]);
							
							
						}

						//add bits to array
						array_push($lines_and_bits, $bits);

					}
				}
				
				//enter updated error data into main array - enter success message
				//if there is a non fatal error change the message
				if ($error['error_exists']){
					$error['error_message'] .= $this->feed_reader_config_error_messages['right_number_of_lines_with_errors'];
				}
				else{
					$error['error_message'] = $this->feed_reader_config_error_messages['right_number_of_lines'];
				}
				$lines_and_bits[0] = $error;
				return $lines_and_bits;
			}
			



			
		}



		/*
			$required_feed_headers -> single dimensional array with header names
			$feed_first_line_array -> single dimensional array with headers from feed
			
			---
			$output either false or array

			$output -> false

			$output['headername'] = integer position of element in feed from 0 to x. eg if headername is id, and id is first element in feed, then $output['headername'] = 0;


		*/

		public function check_feed_headers($required_feed_headers, $feed_first_line_array){

			$required_size = sizeof($required_feed_headers);
			$feed_size = sizeof($feed_first_line_array);
			
			echo "Checking Header Compatability. . . ";
			flush();
			ob_flush();
			
			//check header names if same number of headers exist
			

			//loop through $required_feed_headers - if not found in feed line then set to true
			$error = false;

			$output = array();

			foreach ($required_feed_headers as $required){
				echo ". ";
				flush();
				ob_flush();
				$exists = false; 
				
				$element_position = 0;

				foreach($feed_first_line_array as $feedfirstline){
					

					//if entries are the same, then enter into array and break
					if (trim($required) == trim($feedfirstline)){
						$exists = true;
						//set element position in uploaded feed
						$output[trim($feedfirstline)] = $element_position;

						break;
					}

					$element_position++;
				}

				if (!$exists){
					$error = true;
					break;
				}
			}

			if($error){
				return false;
			}

			else{
				return $output;
			}
		



		}








	}



?>