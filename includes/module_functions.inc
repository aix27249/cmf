<?php
function loadModule($module_name, $area_name) {
	global $blocks, $styles, $scripts, $header_items, $module_head_items, $module_header, $module_styles, $page_title;
	$b['name'] = $module_name;
	$module_dir = 'modules/' . $module_name;
	if (!file_exists($module_dir . '/module.php')) $b['content'] = 'No such module: ' . $module_name;
	else {
		$old_css = array();
		$old_js = array();
		$old_head = array();
		if (isset($module_styles)) $old_css = $module_styles;
		if (isset($module_scripts)) $old_js = $module_scripts;
		if (isset($module_head_items)) $old_head = $module_head_items;
		require_once $module_dir . '/module.php';

		$b['content'] = call_user_func($module_name . '_module');


		
		if (isset($module_options)) $b['options'] = $module_options;
		if (isset($module_header)) $b['header'] = $module_header;
		if (isset($module_header_image)) $b['header_image'] = $module_header_image;
		if (isset($module_styles) && is_array($module_styles)) {
			foreach($module_styles as $s) {
				$styles[] = $module_dir . '/' . $s;
			}
			$module_styles = $old_css; // Reset them for next modules
		}

		if (isset($module_scripts) && is_array($module_scripts)) {
			foreach($module_scripts as $s) {
				$scripts[] = $module_dir . '/' . $s;
			}
			$module_scripts = $old_js;
		}
		if (isset($module_head_items) && is_array($module_head_items)) {

			foreach($module_head_items as $s) {
				$header_items[] = $s;
			}
			$module_head_items = $old_head;
		}


	}

	unset($module_header);
	unset($module_styles);
	$blocks[$area_name][] = $b;


}


function requireModule($module_name, $load_styles = true, $load_scripts = true) {
	global $blocks, $styles, $scripts, $header_items;
	$module_dir = 'modules/' . $module_name;
	if (!file_exists($module_dir . '/module.php')) die('Required module ' . $module_name . ' not found');
	else {
		$old_css = array();
		$old_js = array();
		if (isset($module_styles)) $old_css = $module_styles;
		if (isset($module_scripts)) $old_js = $module_scripts;

		require_once $module_dir . '/module.php';
		if ($load_styles && isset($module_styles) && is_array($module_styles)) {
			foreach($module_styles as $s) {
				$styles[] = $module_dir . '/' . $s;
			}

			$module_styles = $old_css; // Reset them for next modules
		}
		if ($load_scripts && isset($module_scripts) && is_array($module_scripts)) {
			foreach($module_scripts as $s) {
				$scripts[] = $module_dir . '/' . $s;
			}
			$module_scripts = $old_js;
		}
		if (isset($module_head_items) && is_array($module_head_items)) {
			foreach($module_head_items as $s) {
				$header_items[] = $s;
			}
			$module_head_items = $old_head;
		}


	}
	return true;


}

function blacklistModule($module_name, $section="") {
	global $mod_blacklist, $section_blacklist;
	if ($section==='') {
		$mod_blacklist[] = $module_name;
	}
	else {
		$section_blacklist[$section][]=$module_name;
	}

}
