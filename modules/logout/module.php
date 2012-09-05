<?php

function logout_module() {
	setcookie("uid", '', time()-3600) or die('COOKIE SET FAILED');
	setcookie("sid", '',  time()-3600) or die('COOKIE SET FAILED');
	global $url;
	header('Location: /');

}
