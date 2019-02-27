<?php


	Class logs{


		
		public function save_log($data, $log_file){
			//create the file if it doesn't exist
			if (!file_exists($log_file)){
				$fh = fopen($log_file, 'w');
			}
			else{
				$fh = fopen($log_file, 'a');
			}

			fwrite($fh, date('Y-m-d H:i:s') . "	" . $data . "\r\n");

			fclose($fh);

		}



	}



?>