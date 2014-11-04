<?php
$radd = $_SERVER['REMOTE_ADDR'];
$hxff = getenv('HTTP_X_FORWARDED_FOR');
$agent = $_SERVER['HTTP_USER_AGENT'];
$check = hash('sha256', 'admin' . $radd . $hxff . $agent);
if($check !== $_SESSION['check']){
	session_unset();
	session_destroy();
	header('Location: admin_login.php');
}
