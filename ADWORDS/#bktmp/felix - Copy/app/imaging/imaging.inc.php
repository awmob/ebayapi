<?php


	Class imaging{
/*
	[IMAGETYPE_GIF] => 1
	[IMAGETYPE_JPEG] => 2
	[IMAGETYPE_PNG] => 3
	[IMAGETYPE_SWF] => 4
	[IMAGETYPE_PSD] => 5
	[IMAGETYPE_BMP] => 6
	[IMAGETYPE_TIFF_II] => 7
	[IMAGETYPE_TIFF_MM] => 8
	[IMAGETYPE_JPC] => 9
	[IMAGETYPE_JP2] => 10
	[IMAGETYPE_JPX] => 11
	[IMAGETYPE_JB2] => 12
	[IMAGETYPE_SWC] => 13
	[IMAGETYPE_IFF] => 14
	[IMAGETYPE_WBMP] => 15
	[IMAGETYPE_JPEG2000] => 9
	[IMAGETYPE_XBM] => 16
	[IMAGETYPE_ICO] => 17
	[IMAGETYPE_UNKNOWN] => 0


*/
/*
		public function $image_types($type){
			if ($type == IMAGETYPE_GIF){
				
			}
		}

		//converts name to md5 with the date prefix.

		public function setmd5_img_name($root_name, $type){
			$image_name = date('Y-m-d H:i:s') . $root_name;

			$image_name = md5($image_name);

			return $image_name;
		}
*/

		//must use only png 8 for watermark file transparency
		public function add_watermark($main_image, $watermark, $target_file, $image_quality, $transparency){
			// Load the stamp and the photo to apply the watermark to
			$im = imagecreatefromjpeg($main_image);
			$stamp = imagecreatefrompng($watermark);
			
		

			// Set the margins for the stamp and get the height/width of the stamp image
			
			$sx = imagesx($stamp);
			$sy = imagesy($stamp);

			$marge_right = (imagesx($im) / 2) - ($sx / 2); 
			$marge_bottom = (imagesy($im) / 2) - ($sy / 2);

			// Merge the stamp onto our photo with an opacity of 50%
			imagecopymerge($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), $transparency);

			// Save the image to file and free memory
			
			imagejpeg($im, $target_file, $image_quality);
			imagedestroy($im);
			imagedestroy($stamp);

		}




		public function check_and_resize_image($file, $target_dir, $desired_width, $desired_height, $image_quality){
			
			$mime = getimagesize($file);
			$file_width = $mime[0];
			$file_height = $mime[1];

			//change heights / widths - work with smallest dimension to ensure full image coverage
			if (!empty($desired_width) &&  !empty($desired_height)){
				if ($file_width > $file_height){
					
						$final_height = $desired_height;
						$old_new_ratio = $desired_height / $file_height;
						$final_width = ceil($file_width * $old_new_ratio);

						if ($final_width < $desired_width){
							$final_width = $desired_width;
							$old_new_ratio = $desired_width / $file_width;
							$final_height = ceil($file_height * $old_new_ratio);
						}
					
				}
				else if ($file_width <= $file_height){
					$final_width = $desired_width;
					$old_new_ratio = $desired_width / $file_width;
					$final_height = ceil($file_height * $old_new_ratio);
					if ($final_height < $desired_height){
						$final_height = $desired_height;
						$old_new_ratio = $desired_height / $file_height;
						$final_width = ceil($file_width * $old_new_ratio);
					}
				}

				
			}
			else if (!empty($desired_width) && empty($desired_height)){

				$ratio = $file_width / $desired_width;
				$desired_height = ceil($file_height / $ratio);

				$final_width = $desired_width;
				$final_height = $desired_height;

				
			}
			else if (empty($desired_width) && !empty($desired_height)){

				$ratio = $file_height / $desired_height;
				$desired_width = ceil($file_width / $ratio);
				$final_width = $desired_width;
				$final_height = $desired_height;				
			}
			
			//create from gif or jpg depending on mime
			if ($mime[2] == IMAGETYPE_GIF){
				$src = imagecreatefromgif($file);
			}
			else if ($mime[2] == IMAGETYPE_JPEG){
				$src = imagecreatefromjpeg($file);
			}
			else if ($mime[2] == IMAGETYPE_PNG){
				$src = imagecreatefrompng($file);
			}
			else {
				$src = imagecreatefromjpeg($file);
			}

			$dest = imagecreatetruecolor($desired_width, $desired_height);

			//now dimensions dest
			//UNFINISHED - WORK ON CROPPING LATER
			imagecopyresampled($dest, $src, 0, 0, 0, 0, $final_width, $final_height, $file_width, $file_height);
			
			
			

			imagejpeg($dest, $target_dir, $image_quality);

			imagedestroy($dest);
		}


/*
		public function check_and_resize_image$file, $target_dir, $desired_width, $desired_height, $image_quality){
			
			$mime = getimagesize($file);
			$file_width = $mime[0];
			$file_height = $mime[1];

			//change heights / widths - work with smallest dimension to ensure full image coverage
			if ($file_width > $file_height){
				
					$final_height = $desired_height;
					$old_new_ratio = $desired_height / $file_height;
					$final_width = ceil($file_width * $old_new_ratio);

					if ($final_width < $desired_width){
						$final_width = $desired_width;
						$old_new_ratio = $desired_width / $file_width;
						$final_height = ceil($file_height * $old_new_ratio);
					}
				
			}
			else if ($file_width <= $file_height){
				$final_width = $desired_width;
				$old_new_ratio = $desired_width / $file_width;
				$final_height = ceil($file_height * $old_new_ratio);
				if ($final_height < $desired_height){
					$final_height = $desired_height;
					$old_new_ratio = $desired_height / $file_height;
					$final_width = ceil($file_width * $old_new_ratio);
				}
			}

			
			//create from gif or jpg depending on mime
			if ($mime[2] == IMAGETYPE_GIF){
				$src = imagecreatefromgif($file);
			}
			else if ($mime[2] == IMAGETYPE_JPEG){
				$src = imagecreatefromjpeg($file);
			}
			else if ($mime[2] == IMAGETYPE_PNG){
				$src = imagecreatefrompng($file);
			}
			else {
				$src = imagecreatefromjpeg($file);
			}

			$dest = imagecreatetruecolor($desired_width, $desired_height);

			//now dimensions dest
			//UNFINISHED - WORK ON CROPPING LATER
			imagecopyresampled($dest, $src, 0, 0, 0, 0, $final_width, $final_height, $file_width, $file_height);
			
			
			

			imagejpeg($dest, $target_dir, $image_quality);

			imagedestroy($dest);
		}

*/

	}



?>