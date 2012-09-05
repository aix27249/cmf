<?php
/* 
 * Page defaults
 *
 * This file defines default variables that will apply to each page
 * You can override them on any page if required.
 *
 */


// Default template name
$template = "default";

// Add modules for all pages. Modules can be placed in one template place, or in different places. In case of multiple modules in one place, they are ordered as loaded.
// syntax: loadModule($module_name, $template_place);
loadModule('logo', 'header');
loadModule('menu', 'header');
loadModule('social_top', 'header');
loadModule('search_bar', 'header');
loadModule('gmt_select', 'header');
loadModule('side_actions', 'pageside');
loadModule('footer', 'footer');
// Default page title
$title = 'Unnamed page';


