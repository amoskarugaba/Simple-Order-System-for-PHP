<?php
require('private/config.php');

if(!isset($_POST['email']) || !isset($_POST['password'])){
	$_SESSION['error'] = LOGIN_CREDENTIALS_NOT_ENTERED;
	header('Location: login.php');
} else {
	require('class/Login.php');

	$email = $_POST['email'];
	$password = $_POST['password'];

	$login = new CyanideSystems\OrderSystem\Login();

	if($login->verifyLogin($email, $password)){
		header('Location: index.php');
	} else {
		header('Location: login.php');
	}

}
