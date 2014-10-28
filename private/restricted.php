<?php

// This checks that the same computer is accessing the restricted page as the one who logged in

$radd = $_SERVER['REMOTE_ADDR'];
$hxff = getenv('HTTP_X_FORWARDED_FOR');
$agent = $_SERVER['HTTP_USER_AGENT'];
$check = hash('sha256', $radd . $hxff . $agent);
if($check != $_SESSION['check']){
	session_destroy();
	header('Location: login.php');
}
