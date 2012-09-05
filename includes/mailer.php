<?php

error_reporting(E_NONE);
require_once 'Mail.php';
require_once 'Mail/mime.php';

function sendMail($to, $subj, $text, $html) {
	$crlf = "\r\n";
	$encoded_to = '=?utf-8?b?' . base64_encode($to) . '?=';
	$hdrs = array (
			'Сontent-type' => 'text/plain; charset=utf-8',
			'From' => '=?utf-8?b?' . base64_encode('Школа Пиратов') . '?=' . ' <no-reply@shkolapiratov.ru>',
			'To' => $encoded_to,
			'Reply-To' => 'no-reply@shkolapiratov.ru',
			'Return-Path' => 'no-reply@shkolapiratov.ru',
			'Subject' => '=?utf-8?b?' . base64_encode($subj) . '?=',
			'X-Mailer' => 'PHP/' . phpversion()
		);
	$mime = new Mail_mime($crlf);
	$mime->setTXTBody($text);
	$mime->setHTMLBody($html);

	//do not ever try to call these lines in reverse order
	$body = $mime->get(
		array('text_encoding'=>'8bit', 
	        'text_charset'=>'utf-8', 
	        'html_charset'=>'utf-8', 
	        'head_charset'=>'utf-8')
	);
	$hdrs = $mime->headers($hdrs);

	$params["host"]    = 'smtp.yandex.ru'; 
	$params["auth"]    = TRUE;
	$params["auth"]    = "PLAIN";  
	$params["username"]    = 'no-reply@shkolapiratov.ru'; 
	$params["password"]    = 'qazqaz'; 

	// Send
	$mail =& Mail::factory('smtp', $params); 
	$mail->send($to, $hdrs, $body);

}

function sendSimpleMail($user_to, $to, $subj, $text) {
	$crlf = "\r\n";
	$headers = 'MIME-Version: 1.0' . $crlf;
	$headers .= 'Content-type: text/plain; charset=UTF-8' . $crlf;
	$headers .= 'From: no-reply@shkolapiratov.ru' . $crlf;
	$headers .= 'To: ' . $user_to . ' <' . $to . '>' . $crlf;
	$headers .= 'Return-Path: no-reply@shkolapiratov.ru' . $crlf;
	$headers .= 'Reply-To: no-reply@shkolapiratov.ru' . $crlf;
	$headers .= 'X-Mailer: PHP/' . phpversion() . $crlf;

	$result = mail($to, $subj, $text, $headers);
	if ($result) return true;
	return false;
}

function sendConfirmationEmail($username, $email, $code) {
	$server_address = "www.shkolapiratov.ru";
	//$text = "Спасибо за регистрацию на $server_address!\r\nВаш логин: $username\r\n\r\nДля подтверждения e-mail и завершения регистрации, используйте данный код подтверждения:\r\n" . $code . "\r\n\r\nЕсли вы не регистрировались на данном сайте, просто проигнорируйте данное сообщение.";
	$text = "Multipart";
	$html = "<p>Спасибо за регистрацию на $server_address!</p><p><img src='kluchik.png' alt=''></p><p>Ваш логин: $username</p><p>Для подтверждения e-mail и завершения регистрации, используйте данный код подтверждения:<br><br><b>" . $code . "</b><br></p><p>Если вы не регистрировались на данном сайте, просто проигнорируйте данное сообщение.</p>";
	sendMail($email, "Регистрация на школе пиратов", $text, $html);
}
