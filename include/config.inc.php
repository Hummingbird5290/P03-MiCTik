<?php
	# configuration for database
	$_config['database']['hostname'] = "localhost";
	$_config['database']['username'] = "apt";
	$_config['database']['password'] = "apt1234";
	$_config['database']['database'] = "api3";
	# configuration for database		
	// define('DB_SERVER', 'localhost');
	// define('DB_USERNAME', 'root');
	// define('DB_PASSWORD', 'root1234');
	// define('DB_DATABASE', 'api3');
	# connect the database server
	$link = new mysqldb();
	$link->connect($_config['database']);
	$link->selectdb($_config['database']['database']);
	$link->query("SET NAMES 'utf8'");

	@session_start();
?>
