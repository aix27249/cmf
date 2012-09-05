<?php
/* Example page.
 * File name (without .php) is equal to url, for example, mypage.php displays at http://www.example.com/mypage
 *
 * There are two special names:
 * home.php is a site root: http://www.example.net/
 * 404.php displayed when 404 error occurs
 *
 * Mandatory fields:
 * $page['url']: page url (may be deprecated in future)
 * $page['title']: page title
 *
 * function loadModule($module_name, $area_name) specifies modules for this page. Modules are displayed in same order as specified here.
 * function blacklistModule($module_name, $area_name) blocks loading specified module in specified area. Option $area_name can be omitted, in that case module will not be loaded regardless of area.
 *
 */

$page['url'] = '/home';
$page['title'] = 'Главная';

loadModule('frontadvisor', 'highlight');
loadModule('thisweek', 'content');
loadModule('onair', 'sidebar');
