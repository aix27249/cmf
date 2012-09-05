<?php
require_once 'auth_check.php';
function failLogin($username) {
	global $login_fail;
       	$login_fail = $username;

}
function checkLogin() {
	global $user;
	$c_user = trim($_POST['login']);
	$c_pass = trim($_POST['password']);
	if ($c_user==='') failLogin($c_user);
	if ($c_pass==='') failLogin($c_user);
	$mysqli = moviedb_connect_database();

	$stmt = $mysqli->prepare('SELECT uid, pass FROM users WHERE name=?') or die("WTF: " . $mysqli->error);
	$stmt->bind_param('s', $c_user);
	$stmt->bind_result($uid, $_passhash) or die($stmt->error);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows==0) failLogin($c_user);
	$stmt->fetch();
	$account->uid=$uid;
	$account->name=$c_user;
	$account->pass=$_passhash;

	if (user_check_password($c_pass, $account)) {
		// Set cookies
		//
		setcookie("uid", $c_user, time()+864000) or die('COOKIE SET FAILED');
		setcookie("sid", $_passhash, time()+864000) or die('COOKIE SET FAILED');
		$user = $c_user;

		setTimezone(getUserTimezone($c_user));
	}
	else failLogin($c_user);
}

if (isset($_POST['login']) && isset($_POST['password'])) checkLogin();
else $user=simpleCheckAuth();
if (!$user) {
	if (isset($_COOKIE['tz'])) {
		$tz_list = getTimezones();
		if (isset($tz_list[$_COOKIE['tz']])) $tz = $_COOKIE['tz'];
		else $tz = getDefaultTimezone();
	}
	else $tz = getDefaultTimezone();

	setTimezone($tz);
}	
