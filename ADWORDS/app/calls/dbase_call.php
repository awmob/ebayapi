<?php
	
	require_once FILE_SYSTEM_DBASE_TABLES_CONSTANTS;
	require_once FILE_SYSTEM_DBASE_CONFIG;
	require_once FILE_SYSTEM_DBASE_GETTERS;
	require_once FILE_SYSTEM_DBASE_SETTERS;
	require_once FILE_SYSTEM_DBASE_FUNCS;
	

	

	$connection = new dbaseconnect($db['hostname'], $db['username'], $db['password'], $db['database']);
	$dbase_getters = new dbase_getters($connection);
	$dbase_setters = new dbase_setters($connection);






?>