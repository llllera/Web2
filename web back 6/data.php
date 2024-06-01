<?php


header('Content-Type: text/html; charset=UTF-8');

$db_user = 'u67325';
$db_pass = '2356748';
$db = new PDO('mysql:host=localhost;dbname=u67325', $db_user, $db_pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);