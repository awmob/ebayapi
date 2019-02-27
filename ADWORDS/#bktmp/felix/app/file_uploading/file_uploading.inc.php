<?php


	Class file_uploading{

		
		private $file_uploading_settings;


		function __construct($file_uploading_settings){
			//set the array with the config settings
			$this->file_uploading_settings = $file_uploading_settings;
		}

		


		//modifies filename to remove potential issues

		/*
			$filename = String to be modified
		*/

		public function sanitize_filename($filename){
			$filename = preg_replace($this->file_uploading_settings['filename_sanitize'], '', $filename);

			return $filename;
		}


		//Checks file size
		/*
			$filename = name of file string
		*/

		public function check_file_sizes($filename){
			$error['error_exists'] = false; 
			$error['error_message'] = false; 

			if (filesize($filename) == null){
				$error['error_exists'] = true; 
				$error['error_message'] = $this->file_uploading_settings['file_not_exist']; 

			}
			else if (filesize($filename) > $this->file_uploading_settings['max_size']){
				$error['error_exists'] = true; 
				$error['error_message'] = $this->file_uploading_settings['file_too_big'];
			}

			return $error;
		}

		//Checks mime type of file and returns the mime type
		/*
			$filename = name of file string
		*/	
		public function get_mime($filename){
			if ($filename == "" || $filename == null){
				$mime = false;
			}

			else{
				$finfo = new finfo(FILEINFO_MIME);
				$type = $finfo->file($filename);
				$mime = substr($type, 0, strpos($type, ';'));
			}

			return $mime;
		}


		//Checks if mime type is allowed by comparing to the allowed mime types array
		/*
			$mime = String-> mime type
			$allowed_types = Selected array of desired mime types sets from config. Format: array[$i]['mimetype'], array[$i]['extension']
		*/	
		public function check_mime_allowed_general($mime, $allowed_types){
			$error['error_exists'] = true;
			$error['error_message'] = $this->file_uploading_settings['mime_not_allowed'];


			//loop through mime types and check. If not present then not allowed.
			foreach($allowed_types as $value){
				if ($value['mimetype'] == $mime){
					$error['error_exists'] = false;
					$error['error_message'] = false;
				}
			}

			return $error;
			
		}






		//sets the file extension for general upload
		/*
			$mime = String of mime type
			$allowed_types = Selected array of desired mime types sets from config. Format: array[$i]['mimetype'], array[$i]['extension']
		*/

		public function set_general_file_extension($mime, $allowed_types){
			$extension = false;
			
			//loop through image mimes and return extension
			foreach($allowed_types as $value){
				
				if ($value['mimetype'] == $mime){
					$extension = $value['extension'];
				}
			}

			return $extension;
		}



		//Encrypts filename with md5 and appends the desired file extension
		/*
			$extension = String of file extension
		*/

		public function encrypt_filename($extension){
			$encrpyted = md5(rand(1, 10000000) . time());
			$encrpyted .= $extension;
			return $encrpyted;
		}


		

		//Appends unix epoch time and random number to start of the filename if overwrites are not allowed
		/*
			$filename = String of original file name
		*/

		public function check_file_exists_change_filename($filename, $target_folder = false){
			if (!$this->file_uploading_settings['allow_overwrites']){
				if (file_exists($target_folder . $filename)){
					//rename file if file exists
					$filename = rand(1000,9999) . time() . $filename;
				}
			}

			return $filename;
			
		}



		//Checks if image is within allowed width and height
		/*
			$image_file = String name of file
		*/

		public function check_image_sizes($image_file){
			$error['error_exists'] = false;
			$error['error_message'] = false;
			
			//if the image file is not there then show error
			if (!isset($image_file) || $image_file == null){
				$error['error_exists'] = true;
				$error['error_message'] = $this->file_uploading_settings['file_not_exist'];			
			}
			else{
				$image_size = getimagesize($image_file);

				$width = $image_size[0];
				$height = $image_size[1];
				
				//must be greater than a certain dimension
				if ($width < $this->file_uploading_settings['min_height_width'] || $height < $this->file_uploading_settings['min_height_width']){
					$error['error_exists'] = true;
					$error['error_message'] = $this->file_uploading_settings['min_image_size_error'];	
				}
				
				//must be smaller than a certain dimension -> no need to do if config set to 0 -> 0 = unlimited
				if ($this->file_uploading_settings['max_width'] > 0){
					if ($width > $this->file_uploading_settings['max_width']){
						$error['error_exists'] = true;
						$error['error_message'] = $this->file_uploading_settings['max_image_size_error'];				
					}
				}

				if ($this->file_uploading_settings['max_height'] > 0){
					if ($height > $this->file_uploading_settings['max_height']){
						$error['error_exists'] = true;
						$error['error_message'] = $this->file_uploading_settings['max_image_size_error'];				
					}
				}
			}




			return $error;


			
		}


		//Uploads file to desired location
		/*
			$tmp_filename = String of temp file
			$target_filename = String name of target file
			$target_folder = String name of target folder


		*/

		public function upload_file($tmp_filename, $target_filename, $target_folder = false){
			$target_path = $target_folder . $target_filename;
			$error['error_exists'] = false;
			$error['error_message'] = $this->file_uploading_settings['upload_success'];	


			if(move_uploaded_file($tmp_filename, $target_path)) {
				$error['error_message'] = $this->file_uploading_settings['upload_success'];	
			} 
			else{
				$error['error_exists'] = true;
				$error['error_message'] = $this->file_uploading_settings['upload_error'];					
			}

			return $error;

		}



		//Uploads file to desired location and completes verification
		/*
			$tmp_file = String of temp file
			$base_filename = String of base file name
			$type = type for filename saving - 0 = encrypt, 1 = sanitize, etc.
			$allowed_types = Selected array of desired mime types sets from config. Format: array[$i]['mimetype'], array[$i]['extension']
			$target_folder = String of target folder path ending in /. Default is false.


		*/
		public function quick_image_upload($tmp_file, $base_filename, $type, $allowed_types, $target_folder = false){
			$errors = $this->check_file_sizes($tmp_file);
			if ($errors['error_exists']){

				return $errors;
			}
			else{
				$mime = $this->get_mime($tmp_file);

				$errors = $this->check_mime_allowed_general($mime, $allowed_types);
				if ($errors['error_exists']){
					return $errors;
				}
				else{
					$errors = $this->check_image_sizes($tmp_file);

					if ($errors['error_exists']){
						return $errors;
					}
					else{
						if ($type == 0){
							$ext = $this->set_general_file_extension($mime, $allowed_types);
							$filename = $this->encrypt_filename($ext);
							$filename = $this->check_file_exists_change_filename($filename, $target_folder);
						}
						else if ($type == 1){
							$filename = $this->sanitize_filename($base_filename);
							$filename = $this->check_file_exists_change_filename($filename, $target_folder);
						}




						$errors = $this->upload_file($tmp_file, $filename, $target_folder);
						
						//return the error array
						if ($errors['error_exists']){
							$errors['filename'] = false;
							$errors['filepath'] = false;
							return $errors;
						}
						else{
							//add the filename if no error
							$errors['filename'] = $filename;
							$errors['filepath'] = $target_folder;
							return $errors;
						}

					}
					
				}

			}


		}


		//Uploads file to desired location and completes verification
		/*
			$tmp_file = String of temp file
			$base_filename = String of base file name
			$type = type for filename saving - 0 = encrypt, 1 = sanitize, etc.
			$allowed_types = Selected array of desired mime types sets from config. Format: array[$i]['mimetype'], array[$i]['extension']
			$target_folder = string target folder / for upload -> default = false


		*/
		public function quick_file_upload($tmp_file, $base_filename, $type, $allowed_types, $target_folder = false){
			$errors = $this->check_file_sizes($tmp_file);
			if ($errors['error_exists']){

				return $errors;
			}
			else{
				$mime = $this->get_mime($tmp_file);

				$errors = $this->check_mime_allowed_general($mime, $allowed_types);
				if ($errors['error_exists']){
					return $errors;
				}
				else{
					
					if ($type == 0){
						$ext = $this->set_general_file_extension($mime, $allowed_types);
						$filename = $this->encrypt_filename($ext);
						$filename = $this->check_file_exists_change_filename($filename, $target_folder);
					}
					else if ($type == 1){
						$filename = $this->sanitize_filename($base_filename);
						$filename = $this->check_file_exists_change_filename($filename, $target_folder);
					}




					$errors = $this->upload_file($tmp_file, $filename, $target_folder);
					
					//return the error array
					if ($errors['error_exists']){
						$errors['filename'] = false;
						$errors['filepath'] = false;
						return $errors;
					}
					else{
						//add the filename if no error
						$errors['filename'] = $filename;
						$errors['filepath'] = $target_folder;
						return $errors;
					}

					
					
				}

			}


		}

	}



?>