<?php
require('../private/config.php');
require('../class/Login.php');

$email = $_POST['email'];
$password = $_POST['password'];

$signup = new CyanideSystems\OrderSystem\Admin();

// Directs back to registration.php if there's an error
if($signup->registerAdminUser($email, $password)){
	header('Location: index.php');
} else {
	header('Location: register_admin.php');
}
