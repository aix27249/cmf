<?php
function processPage($arg) {
	// Filter input. 
	$page_name = preg_replace('/[^a-zA-Z0-9_]/', '_',  $arg);
	$fullpath = 'pages/' . $page_name;
	$fullpath_php = $fullpath . '.php';
	$fullpath_css = $fullpath . '.css';
	$fullpath_js = $fullpath . '.js';
	if (!file_exists($fullpath_php)) {
		header('HTTP/1.0 404 Not Found');
		require_once 'pages/404.php';
	}
	else require_once $fullpath_php;
	if (file_exists($fullpath_css)) $page['styles'][] = $fullpath_css;
	if (file_exists($fullpath_js)) $page['scripts'][] = $fullpath_js;
	return $page;
}

