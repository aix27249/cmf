<?php
function isModuleBlacklisted($module_name, $section) {
	global $mod_blacklist, $section_blacklist;

	if (!isset($mod_blacklist) || !is_array($mod_blacklist)) $mod_blacklist=array();
		foreach ($mod_blacklist as $m) {
			if ($m==$module_name) return true;
		}
	if (isset($section_blacklist[$section])) {
		foreach ($section_blacklist[$section] as $m) {
			if ($m==$module_name) return true;
		}
	}
	return false;
}


function printBlocks($area_name) {
	global $blocks;
	$ret = '';
	if (isset($blocks[$area_name]) && is_array($blocks[$area_name])) {
		foreach($blocks[$area_name] as $b) {
			if (isModuleBlacklisted($b['name'], $area_name)) continue;
			if (!isset($keep_empty_blocks) && $b['content'] === '') continue;
			if (isset($b['header'])) {
				$hdr = '<div class="block_header">';
				$hdr_img = '';
				if (isset($b['header_image'])) {
					$hdr_img = ' <img class="block_header_image" src="' . $b['header_image'] . '" alt="" />';
				}
				
				if (isset($b['options']['raw_header']) && $b['options']['raw_header']) {
					$hdr .= $b['header'];
				}
				else {
					$hdr .= '<h2>' .$b['header'] . $hdr_img . '</h2>';
				}
				$hdr .= '</div>';
			}
			else $hdr = '';
			$ret .= '<div id="block-' . $b['name'] . '" class="block">' . $hdr . '<div class="block_bg">' . $b['content'] . '</div></div>';
		}
	}
	echo $ret;
}
