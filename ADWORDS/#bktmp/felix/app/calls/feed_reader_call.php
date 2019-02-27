<?php
	
	//requires session to be started

	require_once FILE_SYSTEM_FEED_READER_CONFIG_FILE;
	require_once FILE_SYSTEM_FEED_READER_CLASS;

	$feed_reader = new feed_reader($feed_reader_config_error_messages);
	

?>