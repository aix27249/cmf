<?php
require_once 'dbconfig.php';
require_once 'password.inc';

$c_user = trim($_POST['uid']);
$c_pass = trim($_POST['pass']);
if ($c_user==='') die("EMPTY USER");
if ($c_pass==='') die("EMPTY PASS");
$mysqli = moviedb_connect_database();

$stmt = $mysqli->prepare('SELECT uid, pass FROM users WHERE name=?') or die("WTF: " . $mysqli->error);
$stmt->bind_param('s', $c_user);
$stmt->bind_result($uid, $_passhash) or die($stmt->error);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows==0) die('NO SUCH USER');
$stmt->fetch();
$account->uid=$uid;
$account->name=$c_user;
$account->pass=$_passhash;

if (user_check_password($c_pass, $account)) {
	// Set cookies
	//
	setcookie("uid", $c_user, time()+864000) or die('COOKIE SET FAILED');
	setcookie("sid", $_passhash, time()+864000) or die('COOKIE SET FAILED');

	echo 'OK';
}
else die('PASS INCORRECT, name: ' . $account->name . ', uid: ' . $account->uid . ', passhash: ' . $account->pass);
