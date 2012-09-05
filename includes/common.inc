<?php
require_once 'templates.inc';
function processPage($arg) {
	// Filter input. 
	$page = preg_replace('/[^a-zA-Z0-9_]/', '_',  $arg);
	$fullpath = 'pages/' . $page;
	$fullpath_php = $fullpath . '.php';
	$fullpath_css = $fullpath . '.css';
	$fullpath_js = $fullpath . '.js';
	if (!file_exists($fullpath_php)) {

		header('HTTP/1.0 404 Page not found');
		//require_once 'pages/404.php';
	}
	else require_once $fullpath_php;
	if (file_exists($fullpath_css)) $ret['styles'][] = $fullpath_css;
	if (file_exists($fullpath_js)) $ret['styles'][] = $fullpath_js;
	return $ret;
}

function getModule($mod_name, $page, &$ret) {
	$fullpath = 'modules/' . $mod_name . '/' . $mod_name;
	$fullpath_php = $fullpath . '.php';
	$fullpath_css = $fullpath . '.css';
	$fullpath_js = $fullpath . '.js';
	if (file_exists($fullpath_php)) {
		require_once $fullpath_php;
		$html = '<div id="block-' . $mod_name . '" class="block">' . call_user_func($mod_name . '_module', $page) . '</div>';
		if (file_exists($fullpath_css)) $ret['styles'][] = $fullpath_css;
		if (file_exists($fullpath_js)) $ret['scripts'][] = $fullpath_js;
	}
	else $html = '<div class="error">Модуль ' . $mod_name . ', запрошенный со страницы ' . $page . ', не найден.</div>';
	return $html;
}


function getMainText($page) {
	if (file_exists('text/' . $page . '.html')) {
		return file_get_contents('text/'. $page . '.html');
	}
	return '';
}

function requireModule($mod_name) {
	$ret = array();
	getModule($mod_name, '', $ret);
}
