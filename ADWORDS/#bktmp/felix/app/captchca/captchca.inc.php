<?php

	/*
		Need to add the text and the image location to session variables
	*/

	Class captchca{

		//generates a filename to save the captchca image
		public function generate_filename(){
			$md5 = md5(microtime() * time());

			$filename = $md5 . ".jpg";

			return $filename;
		}


		//generates random 5 string for captchca
		public function generate_random(){
			//Now lets use md5 to generate a totally random string
			$md5 = md5(microtime() * time());

			/*
			We dont need a 32 character long string so we trim it down to 5
			*/
			$string = substr($md5,0,5);

			return $string;
		}


		//generates captchca image and saves to file system

		/*
			$image_loc = Location of default source image
			$string = The captchca text
			$save_loc = filesystem location to temporarily save the captchca image

		*/

		public function generate_captchca_images($image_loc, $string, $save_loc){
			/*
			Now for the GD stuff, for ease of use lets create
			 the image from a background image.
			*/

			$captcha = imagecreatefrompng($image_loc);

			/*
			Lets set the colours, the colour $line is used to generate lines.
			 Using a blue misty colours. The colour codes are in RGB
			*/

			$colour = imagecolorallocate($captcha, 146, 178, 241);
			$line = imagecolorallocate($captcha,233,239,239);

			/*
			Now to make it a little bit harder for any bots to break, 
			assuming they can break it so far. Lets add some lines
			in (static lines) to attempt to make the bots life a little harder
			*/
			imageline($captcha,0,0,39,29,$line);
			imageline($captcha,40,0,64,29,$line);

			/*
			Now for the all important writing of the randomly generated string to the image.
			*/
			imagestring($captcha, 10, 20, 5, $string, $colour);

			//now save the image for display
			imagejpeg($captcha, $save_loc, 80);

			//unload from memory
			imagedestroy($captcha);

		}

		public function show_captchca_image($image_loc){
			$show = "<img src='".$image_loc."'>";

			return $show;
		}



	}



?>