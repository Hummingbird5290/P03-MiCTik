<?php
	require_once( "include/test.class.php");
	# configuration for database
	// $_config['database']['hostname'] = "localhost";
	// $_config['database']['username'] = "root";
	// $_config['database']['password'] = "root1234";
	// $_config['database']['database'] = "api3";
	# configuration for database		
	// define('DB_SERVER', 'localhost');
	// define('DB_USERNAME', 'root');
	// define('DB_PASSWORD', 'root1234');
	// define('DB_DATABASE', 'api3');
	# connect the database server
	//  $link = new Myclass();
	//  $link->connect(null);
	// $link->selectdb($_config['database']['database']);
	// $link->query("SET NAMES 'utf8'");
    return $link;
	@session_start();
?>
