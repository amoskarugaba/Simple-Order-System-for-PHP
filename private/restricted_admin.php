<?php
$r = $_SERVER['REMOTE_ADDR'];
$h = getenv('HTTP_X_FORWARDED_FOR');
$a = $_SERVER['HTTP_USER_AGENT'];
$check = hash('sha256', $r . $h . $a);
if($check !== $_SESSION['admin_check']){
	session_unset();
	session_destroy();
	header('Location: admin_login.php');
}
