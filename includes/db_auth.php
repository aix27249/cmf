<?php
/* Database authorization
 *
 * Specify your credentials here
 *
 */

function moviedb_getDBAuth() {
	$db_auth['host']='localhost';
	$db_auth['username']='db_user';
	$db_auth['password']='db_pass';
	$db_auth['database']='db_name';
	return $db_auth;
}

