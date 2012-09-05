<?php
/*
 * Site defaults
 *
 * This file defines default variables that apply to whole site
 */

$favicon = '/favicon.ico';
$site_name = 'My cool site';
$site_url = 'example.net';

// Common scripts used in each page of site
$scripts[] = '/jquery-1.7.2.min.js';
$scripts[] = '/jquery.placeholder.min.js';
$scripts[] = '/common.js';

// Encoding settings. Please do not change this unless you know what are you doing.
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

/* $merge_styles:
 * An experimental feature to merge all CSS files into single one. Can dramatically improve site loading time.
 * To use this, all paths in CSS files should be either absolute, or relative to site root (not module's root).
 */
$merge_styles = false;

