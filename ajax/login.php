<?php
require('../private/config.php');
require('../class/Login.php');

$email = $_POST['email'];
$password = $_POST['password'];

$login = new CyanideSystems\Login();

// registerUser() returns message as defined in private/config.php
if($login->verifyLogin($email,$password)){
	echo 'Login successful. Click <a href="index.php">here</a> to go to your dashboard';
} else {
	echo 'Sorry, those login details appear to be incorrect - please try again';
}
