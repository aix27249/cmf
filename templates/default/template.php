<?php
/*
 * Default template
 *
 * Template is used to display stuff.
 * Template can define its own styles in variable $template_styles[] and scripts in variable $template_scripts[]
 * Template should form page body in variable $page_content.
 * 
 * You should use this template as example and create your own one. It is not intended to be useful as is (for now...).
 *
 */

// Specify template CSS styles
$template_styles[] = 'defaults.css';
$template_styles[] = 'selectstyled.css';

// Specify template JavaScript scripts
$template_scripts[] = 'selectstyled.js';

// Render page
ob_start();
require_once 'template_body.php';
$page_content = ob_get_contents();
ob_end_clean();


// Dirty hack, should be improved in future
function getIEHeaders() {
	return '<link rel="stylesheet" type="text/css" href="/templates/default/ie.css" />';
}
