<?php
require('../private/config.php');
require('../class/Login.php');

$email = $_POST['email'];
$password = $_POST['password'];

$signup = new CyanideSystems\Login();

// registerUser() returns message as defined in private/config.php
echo $signup->registerUser($email,$password);
