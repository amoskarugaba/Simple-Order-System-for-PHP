<?php
require('../private/config.php');

if(!isset($_POST['email']) || !isset($_POST['password'])){
	$_SESSION['user_message'] = LOGIN_CREDENTIALS_NOT_ENTERED;
	header('Location: admin_login.php');
} else {
	require('../class/Admin.php');

	$email = $_POST['email'];
	$password = $_POST['password'];

	$login = new CyanideSystems\OrderSystem\Admin();

	if($login->verifyAdminLogin($email, $password)){
		header('Location: index.php');
	} else {
		header('Location: admin_login.php');
	}

}
