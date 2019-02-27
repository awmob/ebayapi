<?php
	
	//requires session to be started

	require_once FILE_SYSTEM_CAPTCHCA_CLASS;

	$captchca = new captchca();

	//create the captchca string
	$captchca_string = $captchca->generate_random();
	
	//generate the captchca image filename and the save path
	$captchca_filename_base = $captchca->generate_filename();
	$captchca_save_path = FILE_SYSTEM_CAPTCHCA_IMAGES . $captchca_filename_base;
	
	//save the captchca image to filesystem
	$captchca->generate_captchca_images(FILE_SYSTEM_CAPTCHCA_RAW_IMAGE, $captchca_string, $captchca_save_path);

	//generate the image to display
	$captchca_image_show = $captchca->show_captchca_image(HTTP_CAPTCHCA . $captchca_filename_base);

	$_SESSION['captchca_image'] = $captchca_save_path;
	$_SESSION['captchca_text'] = $captchca_string;

?>