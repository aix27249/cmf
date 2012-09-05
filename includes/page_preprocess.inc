<?php

if (isset($_GET['p'])) $page_name = $_GET['p'];
else $page_name = 'home';

// Postprocess p for news

$_pc = preg_replace('/\/news\//', '', $_SERVER['REQUEST_URI']); 
if ($_pc!=='' && $_pc!==$_SERVER['REQUEST_URI']) {
	$_GET['id'] = intval($_pc);
	$page_name = 'news';
}

$_pc = preg_replace('/\/movies\//', '', $_SERVER['REQUEST_URI']); 
if ($_pc!=='' && $_pc!==$_SERVER['REQUEST_URI']) {
	$_GET['m'] = intval($_pc);
	$page_name = 'movies';
}
