<?php
require_once 'mailer.php';
require_once 'dbconfig.php';
require_once 'auth_check.php';
function checkLoginFree($login) {
	global $mysqli;
	$check = $mysqli->query('SELECT id FROM users WHERE name="' . $login . '"') or die($mysqli->error);
	if ($check->num_rows>0) return false;
	return true;
}

function checkEmailFree($email) {
	return true; // FIXME: debug statement
	global $mysqli;
	$check = $mysqli->query('SELECT id FROM users WHERE email="' . $email . '"') or die($mysqli->error);
	if ($check->num_rows>0) return false;
	return true;
}
function getGameGroup($birthdate) {
	$b = intval($birthdate);
	if ($b >= 20030101) $group = 0;
	else $group = 1;
	return $group;

}
function generateConfirmCode() {
	return mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9);
}

function registerUser($data) {
	// Escaping strings
	global $mysqli;
	$passhash = __hash($data["pass"]);
	foreach($data as $key => $value) {
		$data[$key] = $mysqli->real_escape_string(trim($value));
	}

	if (!checkLoginFree($data["login"]) || !checkEmailFree($data["email"])) return -1;
	$confirm_code = generateConfirmCode();
	$b_m = $data["birth_month"];
	if (strlen($b_m)==1) $b_m = "0" . $b_m;
	$b_d = $data["birth_day"];
	if (strlen($b_d)==1) $b_d = "0" . $b_d;



	$birthdate = $data["birth_year"] . $b_m . $b_d;
	$game_group = getGameGroup($birthdate);

	// Now, store data in DB.
	$mysqli->query('INSERT INTO users VALUES
		(NULL, "' . 
		$data["login"] . '","' . 
		$data["email"] . '","' . 
		$confirm_code . '",
		FALSE, "' . // validation
		$birthdate . '",' . 
		$game_group . ',"' . 
		'' . '","' . // phone
		$passhash . '",
	       	"",
		"",
		0,
		-1)') or die($mysqli->error);

	// Set registration cookie
	setcookie("uid", $_POST["login"], time()+864000);
	setcookie("sid", $passhash, time()+864000);


	//sendConfirmationEmail($data["login"], $data["email"], $confirm_code);
	return $mysqli->insert_id;
	
}

function sendMailCode($user_id) {
	global $mysqli;
	$check = $mysqli->query("SELECT id FROM mail_log WHERE user_id=$user_id") or die($mysqli->error());;
	if ($check->num_rows>0) {
		// Mail already sent
		return false;
	}
	$query = $mysqli->query("SELECT name, email, confirm_code FROM users WHERE id=$user_id") or die($mysqli->error);
	if ($query->num_rows!==1) {
		// No such user
		return false; 
	}
	$row = $query->fetch_row();
	sendConfirmationEmail($row[0], $row[1], $row[2]);
	$mysqli->query("INSERT INTO mail_log VALUES(NULL, $user_id, NOW())") or die($mysqli->error);
	return true;
}
