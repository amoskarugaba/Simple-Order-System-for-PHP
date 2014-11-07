<?php
require('../../private/config.php');
require('../../class/Admin.php');

$email = $_POST['email'];
$password = $_POST['password'];

$signup = new CyanideSystems\OrderSystem\Admin();

// Directs back to registration.php if there's an error
if($signup->registerAdminUser($email, $password)){
	echo '<p>Registration successful.</p>';
} else {
	echo '<p>Registration unsuccessful.</p>';
}
