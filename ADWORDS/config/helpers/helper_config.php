<?php

	$input_helper_settings['min_pass_length'] = 6;
	$input_helper_settings['max_pass_length'] = 32;
	$input_helper_settings['len_pass_error_msg'] = "Password must be " . $input_helper_settings['min_pass_length'] . " characters or longer, and must be shorter than " . $input_helper_settings['max_pass_length'] . " characters.";


	$input_helper_settings['min_user_name_length'] = 6;
	$input_helper_settings['max_user_name_length'] = 16;
	$input_helper_settings['len_user_name_error_msg'] = "Username must be " . $input_helper_settings['min_user_name_length'] . " characters or longer, and must be shorter than " . $input_helper_settings['max_user_name_length'] . " characters.";

	//only allow these characters in username
	$input_helper_settings['main_user_name_char_regex'] = "/[^A-Za-z0-9\_\-\.]+/i";
	$input_helper_settings['char_user_name_error_msg'] = "Username may only contain letters, numbers, underscores, dashes, or full-stops.";


	//only allow alpha numeric and space
	$input_helper_settings['alpha_space'] = "/[A-Za-z ]+/i";
	$input_helper_settings['alpha_space_error_msg'] = "Only letters and spaces are allowed";

	//password salt for extra security
	$input_helper_settings['password_salt'] = md5("salty___%%x431093[]xyz");
	$input_helper_settings['password_addenda'] = "_*&.";
	$input_helper_settings['hash_algorithm'] = "sha512";





	//ascii table
	$ascii_table[0]['base'] = "&";
	$ascii_table[0]['code'] = "&#38;";
	
	$ascii_table[1]['base'] = "\"";
	$ascii_table[1]['code'] = "&#34;";

	$ascii_table[2]['base'] = "'";
	$ascii_table[2]['code'] = "&#39;";

	$ascii_table[3]['base'] = "<";
	$ascii_table[3]['code'] = "&#60;";

	$ascii_table[4]['base'] = ">";
	$ascii_table[4]['code'] = "&#62;";

	$ascii_table[5]['base'] = "?";
	$ascii_table[5]['code'] = "&#63;";

	$ascii_table[6]['base'] = "=";
	$ascii_table[6]['code'] = "&#61;";

	$ascii_table[7]['base'] = "©";
	$ascii_table[7]['code'] = "&#169;";

	





?>