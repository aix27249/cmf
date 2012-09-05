<?php
require_once 'salthash.php';
require_once 'dbconfig.php';
require_once 'password.inc';
require_once 'timezone_functions.php';
function cdie($value) {
	die($value);
}

$mysqli = moviedb_connect_database(); // КОСТЫЛЬ!
//$trollolo_mode=false;
//$trollolo_username="ANONYMOUS";
// Checks if such user exists in database, then returns SHA1 sum of password, or NULL if none
function checkUserBlockedByName($username) {
	$user_id = getUserID($username);
	return checkUserBlockedByID($user_id);
}

function checkUserBlockedByID($user_id) {
	// No such table for now
	return false;
	global $mysqli;
	$user_id = intval($user_id); // Safety check
	$check = $mysqli->query("SELECT user_id FROM blocked WHERE user_id=$user_id");
	if ($check->num_rows!==0) return true;
	return false;
}

function simpleCheckAuth() {

	if (isset($_COOKIE["uid"]) && isset($_COOKIE["sid"])) {
		$c_user = $_COOKIE['uid'];
		$c_pass = $_COOKIE['sid'];
		$mysqli = moviedb_connect_database();
		$stmt = $mysqli->prepare('SELECT uid FROM users WHERE name=? AND pass=?') or die("WTF: " . $mysqli->error);
		$stmt->bind_param('ss', $c_user, $c_pass);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows==0) return false;
		// If success, load user timezone
		setTimezone(getUserTimezone($c_user));
		return $c_user;
	}
	return false;

}

function getUserID($username) {
	global $mysqli;
	$username=$mysqli->real_escape_string(trim($username));
	$users_result=$mysqli->query("SELECT uid FROM users WHERE name='$username';");
	if (!$users_result) cdie($mysqli->error);
	if ($users_result->num_rows!=1) return -1;
	$userrow = $users_result->fetch_row();
	$user_id = $userrow[0];
	return intval($user_id);
}
function getUserName($user_id) {
	global $mysqli;
	$user_id=$mysqli->real_escape_string(trim($user_id));
	$users_result=$mysqli->query("SELECT name FROM users WHERE uid='$user_id';");
	if (!$users_result) cdie($mysqli->error);
	if ($users_result->num_rows!=1) return "USER_NOT_FOUND";

	$userrow = $users_result->fetch_row();
	$username = $userrow[0];
	return $username;


}



function isMailValidated($username) {
	global $mysqli;
	$username=$mysqli->real_escape_string(trim($username));
	$users_result=$mysqli->query("SELECT validation_ok FROM users WHERE name='$username' AND validation_ok=TRUE");
	if (!$users_result) cdie($mysqli->error);
	if ($users_result->num_rows!=1) return false;
	return true;
}

function isAdmin($user) {
	// Users specified here will be threated as admin users
	if ($user==='admin') return true;
	return false;
}
