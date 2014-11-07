<?php
require('../../private/config.php');

if(!isset($_POST['email']) || !isset($_POST['password'])){
	echo '<p>Please enter your login credentials.</p>';
} else {
	require('../../class/Admin.php');

	$email = $_POST['email'];
	$password = $_POST['password'];

	$login = new CyanideSystems\OrderSystem\Admin();

	if($login->verifyAdminLogin($email, $password)){
		echo '<p>You are now logged in.</p>';
	} else {
		echo '<p>Login unsuccessful.</p>';
	}

}
