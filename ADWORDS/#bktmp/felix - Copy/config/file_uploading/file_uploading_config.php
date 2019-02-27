<?php

//FILE UPLOAD SETTINGS ARRAY
	//file sanitizer
	$file_uploading_settings['filename_sanitize'] = "/[^A-Za-z0-9\_\-\.]+/i";

	//mmaximum file size in bytes
	$file_uploading_settings['max_size'] = 1000000;

	//max pixel dimensions of images ->0 = no limit
	$file_uploading_settings['max_width'] = 1000;
	$file_uploading_settings['max_height'] = 1000;

	//min pixel dimensions
	$file_uploading_settings['min_height_width'] = 1;

	//The maximum char length that a file name can be. Set to zero for no limit
	$file_uploading_settings['max_filename'] = 0;

	//whether or not to allow overwrites. If not allowed, then set to false, else set to true.
	$file_uploading_settings['allow_overwrites'] = false;

	//error messages
	$file_uploading_settings['file_not_exist'] = "You didn't choose a file to upload.";
	$file_uploading_settings['file_too_big'] = "Your file must not exceed " . $file_uploading_settings['max_size'] / 1000 . "kb in size.";
	$file_uploading_settings['mime_not_allowed'] = "That file type is not allowed. Please choose another file.";

	$file_uploading_settings['max_image_size_error'] = "The image size must not exceed " . $file_uploading_settings['max_width'] . " pixels in width and " . $file_uploading_settings['max_height'] . " pixels in height. Please choose another file.";

	$file_uploading_settings['min_image_size_error'] = "The image size must be greater than " . $file_uploading_settings['min_height_width'] . " pixels in width and height. Please choose another file.";

	$file_uploading_settings['upload_error'] = "There was a problem uploading your file. Please try again.";
	$file_uploading_settings['upload_success'] = "Your file was uploaded successfully.";


//MAIN MIME TYPES AND EXTENSIONS ARRAY
	//allowed general mime types - add to this list as required
	$mime_types_config[0]['mimetype'] = "image/jpeg";
	$mime_types_config[0]['extension'] = ".jpg";

	$mime_types_config[1]['mimetype'] = "image/png";
	$mime_types_config[1]['extension'] = ".png";

	$mime_types_config[2]['mimetype'] = "image/gif";
	$mime_types_config[2]['extension'] = ".gif";

	$mime_types_config[3]['mimetype'] = "text/plain";
	$mime_types_config[3]['extension'] = ".txt";

	$mime_types_config[4]['mimetype'] = "text/csv";
	$mime_types_config[4]['extension'] = ".csv";

	$mime_types_config[5]['mimetype'] = "image/bmp";
	$mime_types_config[5]['extension'] = ".bmp";

	$mime_types_config[6]['mimetype'] = "image/tiff";
	$mime_types_config[6]['extension'] = ".tiff";


//IMAGE MIME TYPES AND EXTENSIONS ARRAY
	//allowable image mime types only
	$image_mime_types_config[0]['mimetype'] = "image/jpeg";
	$image_mime_types_config[0]['extension'] = ".jpg";

	$image_mime_types_config[1]['mimetype'] = "image/png";
	$image_mime_types_config[1]['extension'] = ".png";

	$image_mime_types_config[2]['mimetype'] = "image/gif";
	$image_mime_types_config[2]['extension'] = ".gif";

	$image_mime_types_config[3]['mimetype'] = "image/bmp";
	$image_mime_types_config[3]['extension'] = ".bmp";

	$image_mime_types_config[4]['mimetype'] = "image/tiff";
	$image_mime_types_config[4]['extension'] = ".tiff";

//Extra mime types - you may add new multidimensional associative arrays of mime type sets as needed. Must be of the format: array[$]['mimetype'] & array[$]['mimetype']['extension']

	//for data feeds
	$feed_mime_types_config[0]['mimetype'] = "text/plain";
	$feed_mime_types_config[0]['extension'] = ".txt";

	$feed_mime_types_config[1]['mimetype'] = "text/csv";
	$feed_mime_types_config[1]['extension'] = ".csv";

















?>