<?php
$module_styles[] = '404.css';
$module_header = 'Страница не найдена';
function page404_module() {
	return '<div class="error_page">Запрашиваемой вами страницы ' . $_SERVER['REQUEST_URI'] . ' не существует.</div>';
}
