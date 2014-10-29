<?php
require('private/config.php');

if(!isset($_POST['email']) || !isset($_POST['password'])){
	header('Location: login.php?e=Please+enter+your+username+and_password+to+continue');
} else {

	require('class/Login.php');

	$email = $_POST['email'];
	$password = $_POST['password'];

	$login = new CyanideSystems\Login();

	if(!$login->verifyLogin($email, $password)){
		header('Location: login.php?e=' . urlencode($login->getErrors()));
	} else {
		header('Location: index.php');
	}

}
