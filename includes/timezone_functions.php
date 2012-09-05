<?php
function getTimezones() {
	$tz = array('Europe/Kaliningrad' => 'Калининград (GMT +3)',
		'Europe/Moscow' => 'Москва (GMT +4)',
		'Asia/Yekaterinburg' => 'Екатеринбург (GMT +6)',
		'Asia/Omsk' => 'Омск (GMT +7)',
		'Asia/Krasnoyarsk' => 'Красноярск (GMT +8)',
		'Asia/Irkutsk' => 'Иркутск (GMT +9)',
		'Asia/Yakutsk' => 'Якутск (GMT +10)',
		'Asia/Vladivostok' => 'Владивосток (GMT +11)',
		'Asia/Kamchatka' => 'Камчатка (GMT +12)'
	);

	return $tz;
}

function getTimezoneName($timezone) {
	$tz = getTimezones();
	return $tz[$timezone];
}
function getDefaultTimezone() {
	$default_timezone = 'Europe/Moscow';
	return $default_timezone;
}
function getUserTimezone($user) {
	$default_timezone = getDefaultTimezone();
	global $mysqli;
	$user_id = getUserID($user);
	$stmt = $mysqli->prepare('SELECT attr_value FROM users_attributes WHERE uid=? AND attr_name="timezone"') or die($mysqli->error);
	$stmt->bind_param('i', $user_id);
	$stmt->bind_result($user_timezone);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows>0) {
		$stmt->fetch();
	}
	else $user_timezone = $default_timezone;
	$stmt->free_result();
	$stmt->close();
	return $user_timezone;
}


function setTimezone($tz) {
	date_default_timezone_set($tz);
	setcookie("tz", $tz, time()+864000) or die('COOKIE SET FAILED');
}
