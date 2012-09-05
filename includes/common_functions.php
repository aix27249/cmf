<?php

require_once 'email_validator.php';
require_once 'smtpmail/smtp-func.php';

function getWordEnding($num, $mode = 0) {
	$e = $num % 10;
	switch($mode) {
		case 0:
			if ($e == 1 && ($num<11 || $num>20)) return 'я';
			else if ($e>1 && $e<5 && ($num<11 || $num>20)) return 'и';
			else return 'й';
			break;
		case 1:
			if ($e == 1 && ($num<11 || $num>20)) return 'й';
			else if ($e>1 && $e<5 && ($num<11 || $num>20)) return 'я';
			else return 'ев';
			break;
	}

			
}

function getFileInputField($id, $text, $bg = "/images/icons/arrow_left_small_gray.png", $width = 258, $height = 26) {
	return '<div class="file_input_bg" id="file_input_' . $id . '" style="width: ' . $width . 'px; height: ' . $height . 'px; line-height: ' . $height . 'px;  background: url(' . $bg . ') right 2px no-repeat; position: relative; text-align: right; padding-right: 26px; cursor: pointer;">
			 <span class="h3" id="file_input_text_' . $id . '">' . $text . '</span>
			<input type="file" name="' . $id . '" id="' . $id . '" style="opacity: 0; width: ' . $width . 'px; height: ' . $height . 'px; position: absolute; top: 0px; left: 0px; z-index: 1;  cursor: pointer;" onchange="handleFileInputChange(\'' . $id . '\');" />
			
		</div>';
}


function getMonthName($num) {
	$intnum = intval($num);
	$days = array(0 => "числа",
		1 => "января", 
		2 => "февраля", 
		3 => "марта", 
		4 => "апреля", 
		5 => "мая",
		6 => "июня",
		7 => "июля",
		8 => "августа",
		9 => "сентября",
		10 => "октября",
		11 => "ноября",
		12 => "декабря");
	return $days[$intnum];
}


function getMonthNamePlain($num) {
	$intnum = intval($num);
	$days = array(0 => "числа",
		1 => "январь", 
		2 => "февраль", 
		3 => "март", 
		4 => "апрель", 
		5 => "май",
		6 => "июнь",
		7 => "июль",
		8 => "август",
		9 => "сентябрь",
		10 => "октябрь",
		11 => "ноябрь",
		12 => "декабрь");
	return $days[$intnum];
}

function getWeekDayLabel($num) {
	$days = array(1 => "пн", 
		2 => "вт", 
		3 => "ср", 
		4 => "чт", 
		5 => "пт",
		6 => "сб",
		7 => "вс");
	return $days[$num];
}


function truncateText($text, $max_length = 380) {
	$ret = mb_substr($text, 0, $max_length);
	$cutpos = mb_strrpos($ret, '.');
	if ($cutpos!==FALSE) $ret = mb_substr($ret, 0, $cutpos+1);
	return $ret;
}


function getMergedStyles($styles) {
	$ret = '';
	foreach($styles as $s) {
		$path_base = dirname($s);
		$path = substr($s, 1);

		$css = preg_replace('/url\(\'[^\/]/', 'url(' . $path_base . '/', file_get_contents($path) . "\n");
		$ret .= $css;
	}
	return $ret;
}




function replaceNobr($data) {
	$ret = preg_replace('/\<nobr\>/', '<span style="white-space: nowrap;">', $data);
	$ret = preg_replace('/\<\/nobr\>/', '</span>', $ret);
	return $ret;
}


function getOverlayLink($url) {
	//$ret = '<a class="link_overlay_bg" href="' . $url . '"><div class="link_overlay_bg_image"></div></a>'; // Works, but arrow is semi-transparent. Wants opaque one.
	$ret = '<a class="link_overlay" href="' . $url . '"><span class="link_overlay_bg"></span><span class="link_overlay_bg_image"></span></a>';
	return $ret;
}
