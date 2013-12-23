<?php
/**
* @author Joshua Anderson
* Date: 12/17/13
* Description: Any special configurations and the database connection
*
*/

const SCRIPT_ROOT = 'http://localhost/internship';

function connect() {
	$host = '127.0.0.1';
	$database = 'internship';
	$username = 'root';
	$password = '';

	$connection = new mysqli($host, $username, $password, $database);
	if(mysqli_connect_errno()) {
		printf("Connection failed!< br />");
		exit();
	}
	return $connection;
}

?>