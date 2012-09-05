<?php
require_once 'db_auth.php';

date_default_timezone_set('Europe/Moscow'); // NOTE: Should update php and get correct datetime with Europe/Moscow here!

function moviedb_connect_database() {
	//global $mysqli;

	$db_auth = moviedb_getDBAuth();
	$mysqli = new mysqli($db_auth['host'], $db_auth['username'], $db_auth['password'], $db_auth['database']) or die("FAILED TO CONNECT");
	if ($mysqli->connect_errno) {
		die("Connection failed: " . $mysqli->connect_error);
	}
	return $mysqli;
}
require_once 'userauth.php';
