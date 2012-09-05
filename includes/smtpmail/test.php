<?php
/* Test script for mail system */

require_once 'smtp-func.php';

$to = 'test@example.net';
$subj = 'Тест';
$message = 'Тест';

smtpmail($to, $subj, $message);
