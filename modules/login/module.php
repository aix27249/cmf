<?php
/* Login module
 *
 * Displays login form
 * Handles login actions via AJAX
 */

$module_scripts[] = 'login.js';
$module_styles[] = 'login.css';



function login_module() {
	// Check if user already logged in
	global $user, $login_fail;
	if ($user) return '<script type="text/javascript">var is_registered=true;</script>';
	$err = '';
	$oldvalue = '';
	$error_class = '';
	if (isset($login_fail) && $login_fail) {
		$err = '<div class="login-error" style="color: red;">Имя пользователя и/или пароль введены неверно.</div>';
		$oldvalue='value="' . $login_fail . '"';
		$style = '<style type="text/css">.login_fade_group {display: block;}</style>';
		$err = $style . $err;
		$error_class = ' error';
	}

	$form = '<form method="post" class="login_form' . $error_class . '">
		<fieldset>
		<h3>имя пользователя</h3>
		<input class="login_input" id="login" name="login" type="text" ' . $oldvalue . ' />
		<h3>пароль</h3>
		<input class="login_input" id="password" name="password" type="password" />
		<input class="login_submit" type="submit" value="Войти" />
		</fieldset>
		</form>';

	$ret = '<div class="login_header"></div>
			' . $err . '
		<div class="login_items">
			<div class="login_form">' . $form . '</div>
		</div>';

	return $ret;
}
