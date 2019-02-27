<?php


	Class input_helper{

		private $min_pass_length;
		private $max_pass_length;
		private $min_user_name_length;
		private $max_user_name_length;
		private $main_user_name_char_regex;
		private $alpha_space;
		private $password_salt;
		private $hash_algorithm;
		private $password_addenda;
		private $len_pass_error_msg;
		private $len_user_name_error_msg;	
		private $char_user_name_error_msg;
		private $alpha_space_error_msg;
		

		private $ascii_table;
		
		//constructs the class with the variables passed from config

		function __construct($input_helper_settings, $ascii_table){

			$this->min_pass_length = $input_helper_settings['min_pass_length'];
			$this->max_pass_length = $input_helper_settings['max_pass_length'];
			$this->min_user_name_length = $input_helper_settings['min_user_name_length'];
			$this->max_user_name_length = $input_helper_settings['max_user_name_length'];
			$this->main_user_name_char_regex = $input_helper_settings['main_user_name_char_regex'];
			$this->alpha_space = $input_helper_settings['alpha_space'];
			$this->password_salt = $input_helper_settings['password_salt'];
			$this->hash_algorithm = $input_helper_settings['hash_algorithm'];
			$this->password_addenda = $input_helper_settings['password_addenda'];
			$this->len_pass_error_msg = $input_helper_settings['len_pass_error_msg'];
			$this->len_user_name_error_msg = $input_helper_settings['len_user_name_error_msg'];	
			$this->char_user_name_error_msg = $input_helper_settings['char_user_name_error_msg'];				
			$this->alpha_space_error_msg = $input_helper_settings['alpha_space_error_msg'];	
			
			

			$this->ascii_table = $ascii_table;


		}

		//Converts the string to the desired hash algorithm - esp for passwords

		/*
			$string = String to be converted
		*/
		
		public function set_hash($string){
			$string = hash($this->hash_algorithm, $string . $this->password_salt);
			$string = $this->password_addenda . $string . $this->password_addenda;
			return $string;

		}

		//Checks password. Returns array of errors -> ['error_exists'] = boolean. true if error, false if no error. ['error_message'] = String if error, false if no error.

		/*
			$pass = password
		*/
		
		public function check_new_pass($pass){
			$error['error_exists'] = false;
			$error['error_message'] = false;

			if (strlen($pass) < $this->min_pass_length){
				$error['error_exists'] = true;
				$error['error_message'] = $this->len_pass_error_msg;
			}
			else if (strlen($pass) >= $this->max_pass_length){
				$error['error_exists'] = true;
				$error['error_message'] = $this->len_pass_error_msg;
			}

			return $error;

		}


		//Checks username. Returns array of errors -> ['error_exists'] = boolean. true if error, false if no error. ['error_message'] = String if error, false if no error.

		/*
			$username = username
		*/


		public function check_new_username($username){
			$error['error_exists'] = false;
			$error['error_message'] = false;

			if (strlen($username) < $this->min_user_name_length){
				$error['error_exists'] = true;
				$error['error_message'] = $this->len_user_name_error_msg;
			}
			else if (strlen($username) >= $this->max_user_name_length){
				$error['error_exists'] = true;
				$error['error_message'] = $this->len_user_name_error_msg;
			}

			else if (preg_match($this->main_user_name_char_regex, $username)){
				$error['error_exists'] = true;
				$error['error_message'] = $this->char_user_name_error_msg;
			}

			return $error;

		}


		//replaces instances of ascii text with normal, and vice versa. Returns modified string. Only perform on text without html markup.

		/*
			$string = String to be modfied
			$to_ascii = true or false. False = from ascii code to standard. True = from standard to ascii code. Default = true.
		*/
		public function set_unset_ascii_text($string, $to_ascii = true){
			for ($i=0; $i < sizeof($this->ascii_table);$i++){

				if ($to_ascii){
					$string = str_replace($this->ascii_table[$i]['base'], $this->ascii_table[$i]['code'], $string);
				}
				else{
					$string = str_replace($this->ascii_table[$i]['code'], $this->ascii_table[$i]['base'], $string);
				}

			}

			return $string;
		}







	}



?>