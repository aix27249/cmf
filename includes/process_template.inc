<?php
/*
 * Template processor
 *
 * Defines variables used in templates
 * Loads template itself
 * Adds scripts and styles from template to generic arrays
 *
 */

// This variable SHOULD be defined, do not change it:
$template_path = 'templates/' . $template;

$template_file = $template_path . '/template.php';
if (file_exists($template_file)) require_once 'templates/' . $template . '/template.php';
else error('Template ' . $template . ' does not exist');

if (isset($template_styles) && is_array($template_styles)) {
	foreach($template_styles as $s) {
		$styles[] = 'templates/' . $template . '/' . $s;
	}
}

if (isset($template_scripts) && is_array($template_scripts)) {
	foreach($template_scripts as $s) {
		$scripts[] = 'templates/' . $template . '/' . $s;
	}
}

function checkSlash($s) {
	$s = trim($s);
	if (sizeof($s)==0) return $s;
	if (substr($s, 0, 1)=='/') return $s;
	if (substr($s, 0, 6)=='http://') return $s;
	if (substr($s, 0, 7)=='https://') return $s;
	return '/' . $s;
}

// Process paths for scripts
function preprocessPaths() {
	global $scripts, $styles;
	for ($i=0; $i<sizeof($scripts); $i++) {
		$scripts[$i] = checkSlash($scripts[$i]);
	}
	for ($i=0; $i<sizeof($styles); $i++) {
		$styles[$i] = checkSlash($styles[$i]);
	}

}


preprocessPaths();
