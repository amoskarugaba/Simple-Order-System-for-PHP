<?php
require('../private/config.php');
require('../class/Admin.php');

$email = $_POST['email'];
$password = $_POST['password'];

$signup = new CyanideSystems\OrderSystem\Admin();

if($signup->setupDatabase()){
	// Directs back to registration.php if there's an error
	if($signup->registerAdminUser($email, $password)){
		header('Location: ../admin/index.php?install=success');
	} else {
		$_SESSION['error'] = 'There was an error registering your email address and password into the database';
		header('Location: index.php');
	}
} else {
	$_SESSION['error'] = 'There was an error in creating the database tables. Please ensure you have entered the database connection settings correctly in private/config.php and that the database user has sufficient permissions to create new tables.';
	header('Location: index.php');
}
