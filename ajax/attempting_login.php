<?php
require('../private/config.php');

if(!isset($_POST['email']) || !isset($_POST['password'])){
	echo '<p>Please enter your email address and password.</p>';
} else {
	require('class/Login.php');

	$email = $_POST['email'];
	$password = $_POST['password'];

	$login = new CyanideSystems\OrderSystem\Login();

	if($login->verifyLogin($email, $password)){
		echo '<p>You are now logged in.</p>';
	} else {
		echo '<p>Login unsuccessful.</p>';
	}

}
